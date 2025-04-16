<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // include file
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    // tạo biến mặc định
    $salaryCode = "ML" . time();

    // show data
    $nv = "SELECT id, ma_nv, ten_nv FROM nhanvien WHERE trang_thai <> 0";
    $resultNV = mysqli_query($conn, $nv);
    $arrNV = array();
    while($rowNV = mysqli_fetch_array($resultNV)){
        $arrNV[] = $rowNV;
    }

    // tháng tính lương
    $thang = date_create(date("Y-m-d"));
    $thangFormat = date_format($thang, "m/Y");

    // tính lương nhân viên
    if(isset($_POST['tinhLuong'])) {
        // tạo các giá trị mặc định
        $showMess = false;
        $error = array();
        $success = array();

        // lấy giá trị trên form
        $maNhanVien = $_POST['maNhanVien'];

        // Lấy tất cả chấm công trong tháng để tính số ngày công
        $queryChamCong = "
            SELECT check_in, check_out 
            FROM chan_cong 
            WHERE employee_id = $maNhanVien AND MONTH(check_in) = MONTH(CURDATE()) AND YEAR(check_in) = YEAR(CURDATE())";
        
        $resultChamCong = mysqli_query($conn, $queryChamCong);
        $soNgayCong = 0;
        $luongThang = 0;

        while ($rowChamCong = mysqli_fetch_array($resultChamCong)) {
            $checkInTime = new DateTime($rowChamCong['check_in']);
            $checkOutTime = new DateTime($rowChamCong['check_out']);
            $workedHours = $checkInTime->diff($checkOutTime)->h + ($checkInTime->diff($checkOutTime)->i / 60); // tổng số giờ làm

            // Kiểm tra thời gian làm việc
            if ($workedHours >= 8) {
                $soNgayCong++;
                $luongThang += $getLuongNgay; // tính lương cho 1 ngày công
            } else {
                $luongThang += $getLuongNgay * ($workedHours / 8); // tính theo số giờ làm
            }
        }

        // Lấy lương ngày của nhân viên theo chức vụ
        $luongNgay = "SELECT luong_ngay FROM nhanvien nv, chuc_vu cv WHERE nv.chuc_vu_id = cv.id AND nv.id = $maNhanVien";
        $resultLuongNgay = mysqli_query($conn, $luongNgay);
        $rowLuongNgay = mysqli_fetch_array($resultLuongNgay);
        $getLuongNgay = $rowLuongNgay['luong_ngay'];

        // Tính các khoản phải nộp lại
        $baoHiemXaHoi = $luongThang * (8/100);
        $baoHiemYTe = $luongThang * (1.5/100);
        $baoHiemThatNghiep = $luongThang * (1/100);
        $tongKhoanTru = $baoHiemXaHoi + $baoHiemYTe + $baoHiemThatNghiep;

        // Tính thực lãnh
        $thucLanh = $luongThang - $tongKhoanTru;

        // Thêm vào db
        $insert = "INSERT INTO luong(ma_luong, nhanvien_id, luong_thang, ngay_cong, thuc_lanh, ngay_cham, nguoi_tao_id, ngay_tao) 
        VALUES('$salaryCode', $maNhanVien, $luongThang, $soNgayCong, $thucLanh, NOW(), {$row_acc['id']}, NOW())";
        $result = mysqli_query($conn, $insert);

        if($result) {
            $showMess = true;
            $success['success'] = 'Calculate salary Success';
            echo '<script>setTimeout("window.location=\'bang-luong.php?p=salary&a=salary\'",1000);</script>';
        } else {
            echo "<script>alert('Lỗi');</script>";
        }
    }
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Calculate salary
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
            <li><a href="tinh-luong.php?p=salary&a=salary">Calculate salary</a></li>
            <li class="active">Calculate salary staff</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Calculate salary staff</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php 
                        // show error
                        if($row_acc['quyen'] != 1) {
                            echo "<div class='alert alert-warning alert-dismissible'>";
                            echo "<h4><i class='icon fa fa-ban'></i> Notification!</h4>";
                            echo "You <b> do not have permission</b> to perform this function.";
                            echo "</div>";
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Staff: </label>
                                        <select class="form-control" name="maNhanVien" id="idNhanVien">
                                            <option value="chon">--- Select staff ---</option>
                                            <?php 
                                            foreach ($arrNV as $nv) {
                                                echo "<option value='".$nv['id']."'>" .$nv['ma_nv']. " - " .$nv['ten_nv']."</option>";
                                            } 
                                            ?>
                                        </select>
                                        <small style="color: red;"><?php if(isset($error['maNhanVien'])){ echo 'Please select staff'; } ?></small>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Work day: </label>
                                        <input type="text" class="form-control" placeholder="Input Work day" name="soNgayCong" value="<?php echo isset($_POST['soNgayCong']) ? $_POST['soNgayCong'] : ''; ?>" id="soNgayCong" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Allowances (Allowances position, gas, lunch,...): </label>
                                        <input type="text" class="form-control" placeholder="Input Allowances" name="phuCap" id="phuCap">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Advance: </label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" name="tamUng" placeholder="Input Advance" value="0">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Calculate salary date: </label>
                                        <input type="date" class="form-control" id="exampleInputEmail1" name="ngayTinhLuong" value="<?php echo date('Y-m-d'); ?>">
                                    </div>

                                    <!-- Submit button -->
                                    <button type="submit" class="btn btn-primary" name="tinhLuong"><i class="fa fa-money"></i> Calculate salary staff</button>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </form>
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
    // include
    include('../layouts/footer.php');
} else {
    // go to pages login
    header('Location: dang-nhap.php');
}
?>