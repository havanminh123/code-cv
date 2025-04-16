<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  // show data
  $NV = "SELECT id, ma_nv, ten_nv FROM nhanvien";
  $resultNV = mysqli_query($conn, $NV);
  $arrNV = array();
  while ($rowNV = mysqli_fetch_array($resultNV)) {
    $arrNV[] = $rowNV;
  }

  // create code room
  $maCongTac = "MCT" . time();

  // delete record
  if(isset($_POST['save']))
  {
    // create array error
    $error = array();
    $success = array();
    $showMess = false;

    // get id in form
    $maNhanVien = $_POST['maNhanVien'];
    $ngayBatDau = $_POST['ngayBatDau'];
    $ngayKetThuc = $_POST['ngayKetThuc'];
    $diaDiem = $_POST['diaDiem'];
    $mucDich = $_POST['mucDich'];
    $ghiChu = $_POST['ghiChu'];
    $nguoiTao = $_POST['nguoiTao'];
    $ngayTao = date("Y-m-d H:i:s");

    // validate
    if($maNhanVien == 'chon')
      $error['maNhanVien'] = 'error';
    if(empty($ngayKetThuc))
      $error['ngayKetThuc'] = 'error';
    if(!empty($ngayKetThuc) && ($ngayBatDau > $ngayKetThuc))
      $error['loiNgay'] = 'error';
    if(empty($diaDiem))
      $error['diaDiem'] = 'error';

    // kiem tra nhan vien co dang trong qua trinh cong tac
    $check = "SELECT nhanvien_id FROM cong_tac WHERE nhanvien_id = '$maNhanVien'";
    $resultCheck = mysqli_query($conn, $check);
    if(mysqli_num_rows($resultCheck) != 0)
    {
      $error['dangCongTac'] = 'error';
      echo "<script>alert('Staff này trong quá trình Collaborate');</script>";
    }


    if(!$error)
    {
      $showMess = true;
      $insert = "INSERT INTO cong_tac(ma_cong_tac, nhanvien_id, ngay_bat_dau, ngay_ket_thuc, dia_diem, muc_dich, ghi_chu, nguoi_tao, ngay_tao) VALUES('$maCongTac','$maNhanVien', '$ngayBatDau', '$ngayKetThuc', '$diaDiem', '$mucDich', '$ghiChu', '$nguoiTao', '$ngayTao')";
      $result = mysqli_query($conn, $insert);
      if($result)
      {
        $success['success'] = 'Create Collaborate Success';
        echo '<script>setTimeout("window.location=\'cong-tac.php?p=collaborate&a=add-collaborate\'",1000);</script>';
      }
    }
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Collaborate
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="cong-tac.php?p=collaborate&a=add-collaborate">Collaborate</a></li>
        <li class="active">Create Collaborate</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create Collaborate</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php 
                // show error
                if($row_acc['quyen'] != 1) 
                {
                  echo "<div class='alert alert-warning alert-dismissible'>";
                  echo "<h4><i class='icon fa fa-ban'></i> Notification!</h4>";
                  echo "You <b> do not have permission</b> to perform this function.";
                  echo "</div>";
                }
              ?>
              <?php 
                // show success
                if(isset($success)) 
                {
                  if($showMess == true)
                  {
                    echo "<div class='alert alert-success alert-dismissible'>";
                    echo "<h4><i class='icon fa fa-check'></i> Success!</h4>";
                    foreach ($success as $suc) 
                    {
                      echo $suc . "<br/>";
                    }
                    echo "</div>";
                  }
                }
              ?>
              <form action="" method="POST">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Code Collaborate: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maCongTac" value="<?php echo $maCongTac; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select staff<span style="color: red;">*</span> : </label>
                      <select class="form-control" name="maNhanVien">
                        <option value="chon">--- Select staff ---</option>
                        <?php 
                        foreach ($arrNV as $nv) 
                        {
                          echo "<option value='".$nv['id']."'>". $nv['ma_nv'] ." - ".$nv['ten_nv']."</option>";
                        }
                        ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['maNhanVien'])){ echo 'Please select staff';} ?></small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Start date<span style="color: red;">*</span>: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" name="ngayBatDau" value="<?php echo date('Y-m-d'); ?>">
                      <small style="color: red;"><?php if(isset($error['loiNgay'])){ echo 'Start date <b> không được sau </b> End date';} ?></small>
                    </div>  
                    <div class="form-group">
                      <label for="exampleInputEmail1">End date<span style="color: red;">*</span>: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" name="ngayKetThuc">
                      <small style="color: red;"><?php if(isset($error['ngayKetThuc'])){ echo 'Please select End date';} ?></small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Address  Collaborate<span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="diaDiem" placeholder="Please input Address ">
                      <small style="color: red;"><?php if(isset($error['diaDiem'])){ echo 'Please input Address  Collaborate';} ?></small>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Purpose Collaborate: </label>
                      <textarea id="editor1" rows="10" cols="80" name="mucDich">
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Note: </label>
                      <textarea id="editor" class="form-control" name="ghiChu"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creator: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row_acc['ho']; ?> <?php echo $row_acc['ten']; ?>" name="nguoiTao" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creation date: </label>
                      <input type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="ngayTao" readonly>
                    </div>
                    <!-- /.form-group -->
                    <?php 
                      if($_SESSION['level'] == 1)
                        echo "<button type='submit' class='btn btn-primary' name='save'><i class='fa fa-plus'></i> Create Collaborate</button>";
                    ?>
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
}
else
{
  // go to pages login
  header('Location: dang-nhap.php');
}

?>