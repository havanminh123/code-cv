<?php
// Create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // Include files
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    // Fetch salary data
    $showData = "
        SELECT l.ma_luong, nv.hinh_anh, nv.id as idNhanVien, nv.ten_nv, cv.ten_chuc_vu, 
               l.luong_thang, l.ngay_cong, l.tam_ung, l.thuc_lanh, l.ngay_cham 
        FROM luong l 
        JOIN nhanvien nv ON nv.id = l.nhanvien_id 
        JOIN chuc_vu cv ON nv.chuc_vu_id = cv.id 
        ORDER BY l.ma_luong DESC
    ";

    $result = mysqli_query($conn, $showData);
    
    // Check for query errors
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $arrShow = array();
    while ($row = mysqli_fetch_array($result)) {
        $arrShow[] = $row;
    }

    // Delete record
    if (isset($_POST['delete'])) {
        $maLuong = $_POST['maLuong'];
        $xoaLuong = "DELETE FROM luong WHERE ma_luong = '$maLuong'";
        $resultXoaLuong = mysqli_query($conn, $xoaLuong);
        if ($resultXoaLuong) {
            $showMess = true;
            $success['success'] = 'Delete record Salary Success.';
            echo '<script>setTimeout("window.location=\'bang-luong.php?p=salary&a=salary\'",1000);</script>';
        } else {
            echo "<script>alert('Error deleting record.');</script>";
        }
    }
?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <span style="font-size: 18px;">Notification</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="maLuong">
                    Do you really want to Delete This?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Calculate Salary Staff</h1>
        <ol class="breadcrumb">
            <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
            <li class="active">Payroll</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Payroll</h3>
                    </div>
                    <div class="box-body">
                        <div class="d-flex" style="margin-bottom: 15px; display: flex; justify-content: end;">
                            <a href="tinh-luong.php?p=salary&a=salary" class="btn btn-primary">
                                <i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;"></i>Calculate Salary
                            </a>
                            <a href="export-bang-luong.php" class="btn btn-success" style="margin-left: 7px;">
                                <i class="fa fa-file-excel-o" aria-hidden="true" style="margin-right: 5px;"></i>Excel
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Code Salary</th>
                                        <th>Username</th>
                                        <th>Position</th>
                                        <th>Salary Month</th>
                                        <th>Work Day</th>
                                        <th>Net Salary</th>
                                        <th>Calculation Date</th>
                                        <th>Detail</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    foreach ($arrShow as $arrS) {
                                    ?>
                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $arrS['ma_luong']; ?></td>
                                            <td><?php echo $arrS['ten_nv']; ?></td>
                                            <td><?php echo $arrS['ten_chuc_vu']; ?></td>
                                            <td><?php echo number_format($arrS['luong_thang']) . ' VNĐ'; ?></td>
                                            <td class="text-center"><?php echo $arrS['ngay_cong']; ?></td>
                                            <td class="text-danger" style="font-weight: bold;"><?php echo number_format($arrS['thuc_lanh']) . ' VNĐ'; ?></td>
                                            <td class="text-center"><?php echo date_format(date_create($arrS['ngay_cham']), 'd-m-Y'); ?></td>
                                            <td>
                                                <form method="POST">
                                                    <input type="hidden" value="<?php echo $arrS['ma_luong']; ?>" name="maLuong"/>
                                                    <button type="submit" class="btn btn-primary btn-flat" name="chiTietLuong"><i class="fa fa-eye"></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <button type="button" class="btn bg-maroon btn-flat" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo $arrS['ma_luong']; ?>"><i class='fa fa-trash'></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php
    // Include footer
    include('../layouts/footer.php');
} else {
    header('Location: dang-nhap.php');
}
?>