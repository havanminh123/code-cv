import base64
import io
import numpy as np
from flask import Flask, request, jsonify
from PIL import Image
import face_recognition
from flask_cors import CORS
import mysql.connector
from datetime import datetime, timedelta
import cv2

app = Flask(__name__)
CORS(app)

# Kết nối MySQL
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="quanly_nhansu"
)
cursor = db.cursor()

# Load khuôn mặt từ DB
def load_known_faces():
    cursor.execute("SELECT employee_id, file_name FROM images")
    data = cursor.fetchall()
    encodings, ids = [], []

    for emp_id, file in data:
        try:
            image = face_recognition.load_image_file(f"pages/{file}")
            face_enc = face_recognition.face_encodings(image)
            if face_enc:
                encodings.append(face_enc[0])
                ids.append(emp_id)
        except Exception as e:
            print(f"Lỗi ảnh {file}: {e}")

    return encodings, ids

KNOWN_ENCODINGS, EMPLOYEE_IDS = load_known_faces()

# Trích xuất ảnh và resize nhỏ để tăng tốc
def preprocess_image(base64_img):
    img_data = base64.b64decode(base64_img.split(",")[1])
    img = Image.open(io.BytesIO(img_data)).convert('RGB')
    img = np.array(img)

    # Resize để tăng tốc (tùy chỉnh theo GPU/CPU)
    small_img = cv2.resize(img, (0, 0), fx=0.25, fy=0.25)
    return img, small_img

# Trích xuất giờ điều chỉnh
def get_adjusted_times():
    try:
        cursor.execute("SELECT check_in_time, check_out_time FROM adjusted_times LIMIT 1")
        result = cursor.fetchone()
        if not result:
            return {"error": "Không tìm thấy thông tin giờ điều chỉnh."}

        return {
            "check_in_time": result[0],
            "check_out_time": result[1]
        }
    except Exception as e:
        print("Lỗi giờ điều chỉnh:", e)
        return {"error": str(e)}

# Nhận diện khuôn mặt
def recognize_face(encodings):
    best_match = None
    best_dist = 0.45  # Ngưỡng khoảng cách giữa các khuôn mặt
    for face_encoding in encodings:
        distances = face_recognition.face_distance(KNOWN_ENCODINGS, face_encoding)
        if len(distances) == 0: 
            continue
        min_dist = min(distances)
        if min_dist < best_dist:
            best_dist = min_dist
            best_match = EMPLOYEE_IDS[np.argmin(distances)]
    return best_match

@app.route("/check_face", methods=["POST"])
def check_face():
    try:
        img_full, img_small = preprocess_image(request.json["image"])
        locs = face_recognition.face_locations(img_small)

        if not locs:
            return jsonify({"message": "Không phát hiện khuôn mặt!"})

        encodings = face_recognition.face_encodings(img_small, locs)
        emp_id = recognize_face(encodings)

        if emp_id:
            cursor.execute("SELECT id, ma_nv, ten_nv FROM nhanvien WHERE id = %s", (emp_id,))
            data = cursor.fetchone()
            if data:
                return jsonify({
                    "message": "Khuôn mặt được nhận diện!",
                    "employee_info": {
                        "id": data[0],
                        "ma_nv": data[1],
                        "ten_nv": data[2]
                    }
                })

        return jsonify({"message": "Không tìm thấy nhân viên phù hợp!"})
    except Exception as e:
        return jsonify({"error": str(e)}), 500
from datetime import datetime, timedelta

@app.route('/check_in', methods=['POST'])
def check_in():
    try:
        data = request.json
        img_data = data['image'].split(",")[1]
        img_bytes = base64.b64decode(img_data)
        img = Image.open(io.BytesIO(img_bytes))
        img = np.array(img)

        # Lấy giờ vào và ra điều chỉnh
        adjusted_times = get_adjusted_times()
        if "error" in adjusted_times:
            return jsonify(adjusted_times)

        # Chuyển đổi giờ vào sang kiểu thời gian
        adjusted_check_in_time = (adjusted_times['check_in_time'] if isinstance(adjusted_times['check_in_time'], str)
                                   else (datetime(1, 1, 1) + adjusted_times['check_in_time']).time())

        current_time = datetime.now().time()

        # Tính thời gian cho phép check-in sớm nhất là 30 phút trước
        earliest_check_in_time = (datetime.combine(datetime.today(), adjusted_check_in_time) - timedelta(minutes=30)).time()

        # Kiểm tra thời gian check-in
        if current_time < earliest_check_in_time:
            return jsonify({"message": "Bạn chỉ có thể chấm công vào sớm nhất là 30 phút trước giờ vào đã điều chỉnh!"})

        # Nhận diện khuôn mặt
        face_locations = face_recognition.face_locations(img)
        if not face_locations:
            return jsonify({"message": "Không phát hiện khuôn mặt!"})

        face_encodings = face_recognition.face_encodings(img, face_locations)
        best_match_id = None
        best_distance = float("inf")
        threshold = 0.5

        # Nhận diện nhân viên
        for encoding in face_encodings:
            distances = face_recognition.face_distance(KNOWN_ENCODINGS, encoding)
            min_distance = min(distances)

            if min_distance < best_distance and min_distance < threshold:
                best_distance = min_distance
                best_match_id = EMPLOYEE_IDS[distances.tolist().index(min_distance)]

        # Kiểm tra xem nhân viên có được nhận diện hay không
        if best_match_id:
            cursor = db.cursor()
            check_in_time = datetime.now()

            # Kiểm tra đã có ghi nhận vào hay chưa
            cursor.execute("SELECT check_in FROM chan_cong WHERE employee_id = %s AND DATE(check_in) = CURDATE()", (best_match_id,))
            check_in_record = cursor.fetchone()

            # Kiểm tra thời gian chấm công
            if check_in_time.time() > adjusted_check_in_time:  # Chấm công muộn
                message = "Chấm công vào thành công!"
            else:
                message = "Bạn đã chấm công muộn!"

            # Cập nhật hoặc thêm ghi nhận giờ vào
            if check_in_record:
                cursor.execute("UPDATE chan_cong SET check_in = %s WHERE employee_id = %s AND DATE(check_in) = CURDATE()", (check_in_time, best_match_id))
            else:
                cursor.execute("INSERT INTO chan_cong (employee_id, check_in) VALUES (%s, %s)", (best_match_id, check_in_time))

            db.commit()
            return jsonify({"message": message})

        return jsonify({"message": "Không tìm thấy nhân viên phù hợp!"})

    except Exception as e:
        print(f"Lỗi khi chấm công vào: {e}")  # Ghi lại thông báo lỗi
        return jsonify({"error": str(e)}), 500
@app.route('/check_out', methods=['POST'])
def check_out():
    try:
        data = request.json
        img_data = data['image'].split(",")[1]
        img_bytes = base64.b64decode(img_data)
        img = Image.open(io.BytesIO(img_bytes)).convert('RGB')
        img = np.array(img)

        # Lấy giờ ra điều chỉnh mới nhất từ bảng adjusted_times
        cursor = db.cursor()
        cursor.execute("SELECT check_out_time FROM adjusted_times ORDER BY id DESC LIMIT 1")
        adjusted_time_record = cursor.fetchone()

        if not adjusted_time_record:
            return jsonify({"error": "Không tìm thấy thời gian điều chỉnh!"})

        adjusted_checkout_time = (
            adjusted_time_record[0] if isinstance(adjusted_time_record[0], str)
            else (datetime(1, 1, 1) + adjusted_time_record[0]).time()
        )

        current_time = datetime.now().time()
        print(f"Current time: {current_time}, Adjusted Check-out Time: {adjusted_checkout_time}")

        # Kiểm tra thời gian check-out
        if current_time < adjusted_checkout_time:
            return jsonify({"message": "Chưa đến giờ chấm công ra!"})

        # Nhận diện khuôn mặt
        face_locations = face_recognition.face_locations(img)
        if not face_locations:
            return jsonify({"message": "Không phát hiện khuôn mặt!"})

        face_encodings = face_recognition.face_encodings(img, face_locations)
        best_match_id = None
        best_distance = float("inf")
        threshold = 0.5

        # Nhận diện nhân viên
        for encoding in face_encodings:
            distances = face_recognition.face_distance(KNOWN_ENCODINGS, encoding)
            if distances.size == 0:
                continue  # Tránh lỗi khi không có khoảng cách

            min_distance = min(distances)
            if min_distance < best_distance and min_distance < threshold:
                best_distance = min_distance
                best_match_id = EMPLOYEE_IDS[distances.tolist().index(min_distance)]

        if best_match_id is None:
            return jsonify({"message": "Khuôn mặt không xác định!"})

        check_out_time = datetime.now()

        # Kiểm tra xem có ghi nhận vào hay chưa
        cursor.execute("SELECT check_in FROM chan_cong WHERE employee_id = %s AND DATE(check_in) = CURDATE()", (best_match_id,))
        check_in_record = cursor.fetchone()

        if not check_in_record:
            return jsonify({"message": "Bạn chưa chấm công vào!"})

        # Kiểm tra xem có lịch check-out chưa
        cursor.execute("SELECT check_out FROM chan_cong WHERE employee_id = %s AND DATE(check_in) = CURDATE()", (best_match_id,))
        check_out_record = cursor.fetchone()

        if check_out_record:
            cursor.execute("UPDATE chan_cong SET check_out = %s WHERE employee_id = %s AND DATE(check_in) = CURDATE()", (check_out_time, best_match_id))
            message = "Chấm công ra thành công!"
        else:
            cursor.execute("INSERT INTO chan_cong (employee_id, check_out) VALUES (%s, %s)", (best_match_id, check_out_time))
            message = "Chấm công ra thành công!"

        db.commit()
        return jsonify({"message": message})

    except Exception as e:
        print(f"Lỗi khi chấm công ra: {e}")
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
       