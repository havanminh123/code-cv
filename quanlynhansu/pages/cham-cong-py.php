<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // include file
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    // show data
    $nv = "SELECT id, ma_nv, ten_nv FROM nhanvien WHERE trang_thai <> 0";
    $resultNV = mysqli_query($conn, $nv);
    $arrNV = array();
    while ($rowNV = mysqli_fetch_array($resultNV)) {
        $arrNV[] = $rowNV;
    }

?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Timekeeping by Face Recognition
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
                <li class="active">Timekeeping</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Timekeeping for staff</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="employee-info" style="display: none;">
                                <h4>Employee Information</h4>
                                <p id="employee-id"></p>
                                <p id="employee-code"></p>
                                <p id="employee-name"></p>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body pb-5">
                                            <video id="video" class="w-100" height="480" autoplay></video>

                                            <div class="mt-2 mb-2">
                                                <button id="checkFace" type="button" class="btn btn-primary mt-3 w-100">CHECK FACE</button>
                                                <button id="checkIn" type="button" class="btn btn-success mt-3 w-100">CHECK IN</button>
                                                <button id="checkOut" type="button" class="btn btn-danger mt-3 w-100">CHECK OUT</button>
                                            </div>

                                            <!-- Thanh tiến trình -->
                                            <div class="progress mt-3 w-100" style="display: none;">
                                                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                            </div>

                                            <!-- Notification -->
                                            <div id="alert-message" class="mt-3" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

    <script>
        const video = document.getElementById('video');
        const progressBar = document.getElementById('progress-bar');
        const progressDiv = document.querySelector('.progress');
        const alertMessage = document.getElementById('alert-message');

        // Mở camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => video.srcObject = stream)
            .catch(error => {
                console.error("Error accessing webcam: ", error);
            });

        function sendRequest(endpoint) {
            const canvas = document.createElement('canvas');
            canvas.width = 640;
            canvas.height = 480;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = canvas.toDataURL('image/jpeg');

            progressDiv.style.display = 'block';
            progressBar.style.width = '0%';

            fetch(`http://127.0.0.1:5000/${endpoint}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ image: imageData })
            })
            .then(res => res.json())
            .then(data => {
                progressBar.style.width = '100%';
                alertMessage.style.display = 'block';
                alertMessage.textContent = data.message;

                // Hiển thị thông tin nhân viên nếu có
                if (data.employee_info) {
                    document.getElementById('employee-info').style.display = 'block';
                    document.getElementById('employee-id').textContent = `ID: ${data.employee_info.id}`;
                    document.getElementById('employee-code').textContent = `Employee Code: ${data.employee_info.ma_nv}`;
                    document.getElementById('employee-name').textContent = `Name: ${data.employee_info.ten_nv}`;
                } else {
                    document.getElementById('employee-info').style.display = 'none';
                }

                setTimeout(() => {
                    alertMessage.style.display = 'none';
                }, 3000);
            })
            .catch(error => {
                progressBar.style.width = '100%';
                alertMessage.style.display = 'block';
                alertMessage.textContent = 'An error occurred, please try again!';
            });
        }

        document.getElementById('checkFace').onclick = () => sendRequest('check_face');
        document.getElementById('checkIn').onclick = () => sendRequest('check_in');
        document.getElementById('checkOut').onclick = () => sendRequest('check_out');

    </script>
<?php
    // include
    include('../layouts/footer.php');
} else {
    // go to pages login
    header('Location: dang-nhap.php');
}
?>