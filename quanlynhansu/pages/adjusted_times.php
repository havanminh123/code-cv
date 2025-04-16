<?php
// Bắt đầu phiên
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
    header('Location: dang-nhap.php');
    exit();
}

// Kết nối cơ sở dữ liệu chính
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanly_nhansu";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý dữ liệu đầu vào
    $new_check_in_time = isset($_POST['new_check_in_time']) ? $_POST['new_check_in_time'] : null;
    $new_check_out_time = isset($_POST['new_check_out_time']) ? $_POST['new_check_out_time'] : null;

    if ($new_check_in_time && $new_check_out_time) {
        // Cập nhật giờ vào bảng settings
        $sql = "UPDATE settings SET check_in_time = ?, check_out_time = ? WHERE id = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_check_in_time, $new_check_out_time);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "Giờ chấm công đã được cập nhật thành công!";
            } else {
                $message = "Không có bản ghi nào được cập nhật. Kiểm tra lại ID trong bảng settings.";
            }
        } else {
            $message = "Lỗi khi cập nhật giờ vào settings: " . $stmt->error;
        }
        $stmt->close();

        // Kết nối đến cơ sở dữ liệu mới để lưu giờ đã chỉnh
        $conn_adjusted = new mysqli($servername, $username, $password, "quanly_nhansu");
        if ($conn_adjusted->connect_error) {
            die("Kết nối thất bại: " . $conn_adjusted->connect_error);
        }

        // Lưu vào bảng adjusted_times
        $insertAdjustedTime = "INSERT INTO adjusted_times (check_in_time, check_out_time) VALUES (?, ?)";
        $stmt2 = $conn_adjusted->prepare($insertAdjustedTime);
        $stmt2->bind_param("ss", $new_check_in_time, $new_check_out_time);
        if ($stmt2->execute()) {
            $message .= " Giờ đã được lưu vào bảng adjusted_times.";
        } else {
            $message .= " Lỗi khi lưu vào bảng adjusted_times: " . $stmt2->error;
        }
        $stmt2->close();
        $conn_adjusted->close();
    } else {
        $message = "Vui lòng nhập đủ thông tin giờ vào và ra.";
    }
}

// Lấy giờ hiện tại từ bảng settings
$sql = "SELECT check_in_time, check_out_time FROM settings WHERE id = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $times = $result->fetch_assoc();
    $current_check_in_time = $times['check_in_time'];
    $current_check_out_time = $times['check_out_time'];
} else {
    $current_check_in_time = "07:00"; // Giờ vào mặc định
    $current_check_out_time = "17:00"; // Giờ ra mặc định
    $message = "Không tìm thấy cài đặt, sử dụng giờ mặc định.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điều Chỉnh Giờ Chấm Công</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Link đến CSS của bạn -->
</head>
<body>

<?php include('../layouts/header.php'); ?>
<?php include('../layouts/topbar.php'); ?>
<?php include('../layouts/sidebar.php'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>Điều Chỉnh Giờ Chấm Công</h1>
        <ol class="breadcrumb">
            <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
            <li class="active">Điều Chỉnh Giờ</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Cài Đặt Giờ Mới</h3>
                    </div>
                    <div class="box-body">
                        <?php if (!empty($message)): ?>
                            <div><?php echo htmlspecialchars($message); ?></div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <label for="new_check_in_time">Giờ Check-in Mới:</label>
                            <input type="time" id="new_check_in_time" name="new_check_in_time" value="<?php echo htmlspecialchars($current_check_in_time); ?>" required>

                            <label for="new_check_out_time">Giờ Check-out Mới:</label>
                            <input type="time" id="new_check_out_time" name="new_check_out_time" value="<?php echo htmlspecialchars($current_check_out_time); ?>" required>

                            <button type="submit">Cập Nhật Giờ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include('../layouts/footer.php'); ?>

</body>
</html>