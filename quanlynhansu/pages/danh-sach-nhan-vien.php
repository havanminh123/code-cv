<?php
// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
    // include file
    include('../layouts/header.php');
    include('../layouts/topbar.php');
    include('../layouts/sidebar.php');

    if (isset($_POST['edit'])) {
        $id = $_POST['idStaff'];
        echo "<script>location.href='sua-nhan-vien.php?p=staff&a=list-staff&id=" . $id . "'</script>";
    }

    if (isset($_POST['view'])) {
        $id = $_POST['idStaff'];
        echo "<script>location.href='thong-tin-nhan-vien.php?p=staff&a=list-staff&id=" . $id . "'</script>";
    }

    // show data
    $showData = "SELECT id, ma_nv, hinh_anh, ten_nv, gioi_tinh, ngay_tao, ngay_sinh, noi_sinh, so_cmnd, trang_thai FROM nhanvien ORDER BY id DESC";
    $result = mysqli_query($conn, $showData);
    $arrShow = array();
    while ($row = mysqli_fetch_array($result)) {
        $arrShow[] = $row;
    }

    // delete record
    if (isset($_POST['delete'])) {
        $id = $_POST['idStaff'];
        $target_dir = "../uploads/staffs/";

        // get image
        $image = "SELECT hinh_anh FROM nhanvien WHERE id = $id";
        $resultImage = mysqli_query($conn, $image);
        $rowImage = mysqli_fetch_array($resultImage);
        $removeImage = $target_dir . $rowImage['hinh_anh'];

        // Xóa các bản ghi liên quan trong bảng phụ (images)
        $deleteImages = "DELETE FROM images WHERE employee_id = $id";
        mysqli_query($conn, $deleteImages);
        
        // Xóa bản ghi nhân viên
        $delete = "DELETE FROM nhanvien WHERE id = $id";
        $resultDel = mysqli_query($conn, $delete);
        if ($resultDel) {
            $showMess = true;
            if ($rowImage['hinh_anh'] != "demo-3x4.jpg") {
                unlink($removeImage);
            }

            $success['success'] = 'Delete staff Success.';
            echo '<script>setTimeout("window.location=\'danh-sach-nhan-vien.php?p=staff&a=list-staff\'",1000);</script>';
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
                        <input type="hidden" name="idStaff">
                        Do you really want to Delete staff This?
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Staff
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
                <li><a href="danh-sach-nhan-vien.php?p=staff&a=list-staff">Staff</a></li>
                <li class="active">List of employees</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">List of employees</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="d-flex" style="margin-bottom: 15px; display: flex; justify-content: end;">
                                <a href="them-nhan-vien.php?p=staff&a=add-staff" class="btn btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true" style="margin-right: 5px;"></i>Create staff</a>
                                <a href="export-nhan-vien.php" class="btn btn-success" style="margin-left: 7px;">
                                    <i class="fa fa-file-excel-o" aria-hidden="true" style="margin-right: 5px;"></i>Excel
                                </a>
                            </div>

                            <?php
                            // show error
                            if ($row_acc['quyen'] != 1) {
                                echo "<div class='alert alert-warning alert-dismissible'>";
                                echo "<h4><i class='icon fa fa-ban'></i> Notification!</h4>";
                                echo "You <b> do not have permission</b> to perform this function.";
                                echo "</div>";
                            }
                            ?>

                            <?php
                            // show error
                            if (isset($error)) {
                                if ($showMess == false) {
                                    echo "<div class='alert alert-danger alert-dismissible'>";
                                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                                    echo "<h4><i class='icon fa fa-ban'></i> Error!</h4>";
                                    foreach ($error as $err) {
                                        echo $err . "<br/>";
                                    }
                                    echo "</div>";
                                }
                            }
                            ?>
                            <?php
                            // show success
                            if (isset($success)) {
                                if ($showMess == true) {
                                    echo "<div class='alert alert-success alert-dismissible'>";
                                    echo "<h4><i class='icon fa fa-check'></i> Success!</h4>";
                                    foreach ($success as $suc) {
                                        echo $suc . "<br/>";
                                    }
                                    echo "</div>";
                                }
                            }
                            ?>
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Employee code</th>
                                            <th>Image</th>
                                            <th>Username</th>
                                            <th>Sex</th>
                                            <th>Date of birth</th>
                                            <th>Place of birth</th>
                                            <th>CMND</th>
                                            <th>Status</th>
                                            <th>View</th>
                                            <th>Edit</th>
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
                                                <td><?php echo $arrS['ma_nv']; ?></td>
                                                <td><img src="../uploads/staffs/<?php echo $arrS['hinh_anh']; ?>" width="80"></td>
                                                <td><?php echo $arrS['ten_nv']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($arrS['gioi_tinh'] == 1) {
                                                        echo "Nam";
                                                    } else {
                                                        echo "Nữ";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $date = date_create($arrS['ngay_sinh']);
                                                    echo date_format($date, 'd-m-Y');
                                                    ?>
                                                </td>
                                                <td><?php echo $arrS['noi_sinh']; ?></td>
                                                <td><?php echo $arrS['so_cmnd']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($arrS['trang_thai'] == 1) {
                                                        echo '<span class="badge bg-blue"> Working </span>';
                                                    } else {
                                                        echo '<span class="badge bg-red"> Retired </span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row_acc['quyen'] == 1) {
                                                        echo "<form method='POST'>";
                                                        echo "<input type='hidden' value='" . $arrS['id'] . "' name='idStaff'/>";
                                                        echo "<button type='submit' class='btn btn-primary btn-flat' name='view'><i class='fa fa-eye'></i></button>";
                                                        echo "</form>";
                                                    } else {
                                                        echo "<button type='button' class='btn btn-primary btn-flat' disabled><i class='fa fa-eye'></i></button>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row_acc['quyen'] == 1) {
                                                        echo "<form method='POST'>";
                                                        echo "<input type='hidden' value='" . $arrS['id'] . "' name='idStaff'/>";
                                                        echo "<button type='submit' class='btn bg-orange btn-flat' name='edit'><i class='fa fa-edit'></i></button>";
                                                        echo "</form>";
                                                    } else {
                                                        echo "<button type='button' class='btn bg-orange btn-flat' disabled><i class='fa fa-edit'></i></button>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row_acc['quyen'] == 1) {
                                                        echo "<button type='button' class='btn bg-maroon btn-flat' data-toggle='modal' data-target='#exampleModal' data-whatever='" . $arrS['id'] . "'><i class='fa fa-trash'></i></button>";
                                                    } else {
                                                        echo "<button type='button' class='btn bg-maroon btn-flat' disabled><i class='fa fa-trash'></i></button>";
                                                    }
                                                    ?>
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