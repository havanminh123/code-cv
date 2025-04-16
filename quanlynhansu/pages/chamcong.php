<?php 

// create session
session_start();
include('../layouts/db_connection.php');

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // include file
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    // Lấy giờ check-in từ bảng setting
    $settingQuery = "SELECT check_in_time FROM settings LIMIT 1"; // Giả sử có 1 bản ghi
    $settingResult = mysqli_query($conn, $settingQuery);
    $settingRow = mysqli_fetch_assoc($settingResult);
    $checkInTimeString = $settingRow['check_in_time']; // Giả sử giờ được lưu dưới định dạng 'H:i:s'
    $checkInTime = DateTime::createFromFormat('H:i:s', $checkInTimeString);

    // Lấy giờ hiện tại
    $currentHour = date('H');
    $currentMinute = date('i');
    
    // Xóa toàn bộ dữ liệu chấm công nếu đã qua 19h39
    if ($currentHour >= 22 && $currentMinute >= 30 ) {
        // Sao chép dữ liệu vào bảng attendance_history
        $copyAttendanceHistory = "INSERT INTO attendance_history (employee_id, work_date, check_in, check_out) SELECT employee_id, DATE(check_in) AS work_date, check_in, check_out FROM chan_cong WHERE check_out IS NOT NULL";
        
        // Sao chép dữ liệu vào bảng daily_working_hours
        $copyDailyWorkingHours = "INSERT INTO daily_working_hours (employee_id, work_date, total_hours) SELECT employee_id, DATE(check_in) AS work_date, SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, check_in, check_out))) AS total_hours FROM chan_cong WHERE check_out IS NOT NULL GROUP BY employee_id, work_date HAVING total_hours > '00:00:00'";
        
        // Thực hiện sao chép vào bảng attendance_history
        if (mysqli_query($conn, $copyAttendanceHistory)) {
            // Thực hiện sao chép vào bảng daily_working_hours
            if (mysqli_query($conn, $copyDailyWorkingHours)) {
                // Xóa dữ liệu chấm công
                $deleteAllCheckIns = "DELETE FROM chan_cong";
                if (!mysqli_query($conn, $deleteAllCheckIns)) {
                    echo "Error deleting data: " . mysqli_error($conn);
                }
            } else {
                echo "Error copying to daily_working_hours: " . mysqli_error($conn);
            }
        } else {
            echo "Error copying to attendance_history: " . mysqli_error($conn);
        }
    }

    // show data
    $showData = "SELECT nhanvien.id, nhanvien.ma_nv, nhanvien.ten_nv, MIN(chan_cong.check_in) AS check_in, MAX(chan_cong.check_out) AS check_out FROM quanly_nhansu.nhanvien LEFT JOIN chan_cong ON nhanvien.id = chan_cong.employee_id GROUP BY nhanvien.id ORDER BY nhanvien.ma_nv";
    
    $result = mysqli_query($conn, $showData);
    $arrShow = array();
    
    while ($row = mysqli_fetch_array($result)) {
        $checkIn = $row['check_in'];
        $checkOut = $row['check_out'];
        
        if ($checkIn === null) {
            // Nếu không có chấm công
            $status = "Nghỉ việc";
            $totalHours = "0:00";
        } else {
            // Tính tổng giờ làm
            $checkInTimeActual = new DateTime($checkIn);
            $checkOutTime = new DateTime($checkOut);
            $totalHours = $checkInTimeActual->diff($checkOutTime)->format('%h:%i');

            // Kiểm tra giờ chấm công
            if ($checkInTimeActual < $checkInTime) {
                $status = "Đúng giờ"; // Check-in sớm hơn giờ quy định
            } else {
                $status = "Chấm công muộn"; // Check-in sau giờ quy định
            }
        }

        $arrShow[] = [
            'ma_nv' => $row['ma_nv'],
            'ten_nv' => $row['ten_nv'],
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'total_hours' => $totalHours,
            'status' => $status,
        ];
    }
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage timekeeping
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
            <li><a href="bang-luong.php?p=salary&a=salary">Timekeeping</a></li>
            <li class="active">Manage timekeeping</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Timekeeping</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="d-flex" style="margin-bottom: 15px; display: flex; justify-content: end;">
                            <a href="cham-cong-py.php?p=salary&a=salary" class="btn btn-primary">
                                <i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;"></i>Timekeeping</a>
                        </div>

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Employee code</th>
                                        <th>Username</th>
                                        <th>Start time</th>
                                        <th>End time</th>
                                        <th>Total working hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($arrShow as $arrS) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $arrS['ma_nv']; ?></td>
                                        <td><?php echo $arrS['ten_nv']; ?></td>
                                        <td><?php echo $arrS['check_in'] ? $arrS['check_in'] : 'Không có'; ?></td>
                                        <td><?php echo $arrS['check_out'] ? $arrS['check_out'] : 'Không có'; ?></td>
                                        <td><?php echo $arrS['total_hours']; ?></td>
                                        <td><?php echo $arrS['status']; ?></td>
                                    </tr>
                                    <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
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

<?php
    // include footer
    include('../layouts/footer.php');
} else {
    // go to pages login
    header('Location: dang-nhap.php');
}
?>