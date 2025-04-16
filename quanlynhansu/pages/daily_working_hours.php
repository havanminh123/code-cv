<?php 

// Create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // Include file
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    // Lấy tháng và năm từ form
    $selectedMonth = isset($_POST['month']) ? $_POST['month'] : date('m');
    $selectedYear = isset($_POST['year']) ? $_POST['year'] : date('Y');

    // Xóa toàn bộ dữ liệu chấm công nếu đã qua 22h30
    $currentHour = date('H');
    $currentMinute = date('i');
    
    if ($currentHour >= 22 && $currentMinute >= 15) {
        // Sao chép dữ liệu vào bảng daily_working_hours
        $copyData = "
            INSERT INTO daily_working_hours (employee_id, work_date, total_hours)
            SELECT 
                employee_id, 
                DATE(check_in) AS work_date, 
                SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, check_in, check_out))) AS total_hours
            FROM 
                chan_cong
            WHERE 
                check_out IS NOT NULL
            GROUP BY 
                employee_id, work_date
            HAVING 
                total_hours > '00:00:00'
        ";

        // Kiểm tra và thực hiện sao chép
        if (mysqli_query($conn, $copyData)) {
            // Xóa dữ liệu chấm công
            $deleteAllCheckIns = "DELETE FROM chan_cong";
            mysqli_query($conn, $deleteAllCheckIns);
        } else {
            echo "Error copying data: " . mysqli_error($conn);
        }
    }

    // Lấy danh sách nhân viên
    $employeeData = "
    SELECT 
        id, 
        ma_nv, 
        ten_nv 
    FROM 
        quanly_nhansu.nhanvien
    ";
    
    $employeeResult = mysqli_query($conn, $employeeData);
    $employees = [];
    
    while ($row = mysqli_fetch_array($employeeResult)) {
        $employees[$row['id']] = [
            'ma_nv' => $row['ma_nv'],
            'ten_nv' => $row['ten_nv'],
        ];
    }

    // Hiển thị dữ liệu cho tháng và năm đã chọn
    $showData = "
    SELECT 
        employee_id, 
        work_date,
        total_hours
    FROM 
        daily_working_hours
    WHERE 
        MONTH(work_date) = '$selectedMonth' AND 
        YEAR(work_date) = '$selectedYear'
    ORDER BY 
        employee_id, work_date
    ";
    
    $result = mysqli_query($conn, $showData);
    $arrShow = [];
    
    while ($row = mysqli_fetch_array($result)) {
        $arrShow[$row['employee_id']][$row['work_date']] = $row['total_hours'];
    }

    // Tạo danh sách ngày trong tháng
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Timekeeping
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
            <li class="active">Manage Timekeeping</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Timekeeping Records</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="month">Select Month:</label>
                                <select name="month" id="month" class="form-control">
                                    <?php
                                    for ($m = 1; $m <= 12; $m++) {
                                        echo "<option value='$m'" . ($m == $selectedMonth ? ' selected' : '') . ">$m</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year">Select Year:</label>
                                <select name="year" id="year" class="form-control">
                                    <?php
                                    for ($y = 2020; $y <= date('Y'); $y++) {
                                        echo "<option value='$y'" . ($y == $selectedYear ? ' selected' : '') . ">$y</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Show Records</button>
                        </form>
                        <div class="table-responsive" style="margin-top: 20px;">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Employee Code</th>
                                        <th>Username</th>
                                        <?php
                                        // Hiển thị các ngày trong tháng
                                        for ($day = 1; $day <= $daysInMonth; $day++) {
                                            echo "<th>" . sprintf('%02d', $day) . "</th>";
                                        }
                                        ?>
                                        <th>Total Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($employees as $employeeId => $employee) {
                                    ?>
                                    <tr>
                                        <td><?php echo $employee['ma_nv']; ?></td>
                                        <td><?php echo $employee['ten_nv']; ?></td>
                                        <?php
                                        // Hiển thị giờ làm cho từng ngày
                                        $totalHours = 0;
                                        for ($day = 1; $day <= $daysInMonth; $day++) {
                                            $date = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $day);
                                            $hours = isset($arrShow[$employeeId][$date]) ? $arrShow[$employeeId][$date] : '0:00';
                                            echo "<td>$hours</td>";
                                            
                                            // Tính tổng số giờ làm
                                            $timeParts = explode(':', $hours);
                                            $totalHours += ($timeParts[0] * 60) + $timeParts[1]; // Chuyển đổi thành phút
                                        }
                                        // Chuyển đổi tổng số phút về định dạng giờ:phút
                                        $totalHoursFormatted = floor($totalHours / 60) . ':' . sprintf('%02d', $totalHours % 60);
                                        ?>
                                        <td><?php echo $totalHoursFormatted; ?></td>
                                    </tr>
                                    <?php
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
    // Include footer
    include('../layouts/footer.php');
} else {
    // Redirect to login page
    header('Location: dang-nhap.php');
}
?>