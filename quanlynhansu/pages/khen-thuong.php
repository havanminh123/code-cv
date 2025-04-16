<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  if(isset($_POST['suaLoai']))
  {
    $id = $_POST['idLoai'];
    echo "<script>location.href='sua-loai-khen-thuong.php?p=bonus-discipline&a=bonus&id=".$id."'</script>";
  }

  if(isset($_POST['suaKhenThuong']))
  {
    $id = $_POST['idKhenThuong'];
    echo "<script>location.href='sua-khen-thuong.php?p=bonus-discipline&a=bonus&id=".$id."'</script>";
  }

  // hien thi loai khen thuong
  $showData = "SELECT id, ma_loai, ten_loai, ghi_chu, nguoi_tao, ngay_tao, nguoi_sua, ngay_sua FROM loai_khen_thuong_ky_luat WHERE flag = 1 ORDER BY ngay_tao DESC";
  $result = mysqli_query($conn, $showData);
  $arrShow = array();
  while ($row = mysqli_fetch_array($result)) {
    $arrShow[] = $row;
  }

  // hien thi khen thuong
  $kt = "SELECT ktkl.id as id, ma_kt, ten_khen_thuong, ten_nv, so_qd, ngay_qd, ten_loai, hinh_thuc, so_tien, ktkl.ngay_tao as ngay_tao FROM khen_thuong_ky_luat ktkl, nhanvien nv, loai_khen_thuong_ky_luat lktkl WHERE ktkl.nhanvien_id = nv.id AND ktkl.loai_kt_id = lktkl.id AND ktkl.flag = 1 ORDER BY ktkl.ngay_tao DESC";
  $resultKT = mysqli_query($conn, $kt);
  $arrKT = array();
  while ($rowKT = mysqli_fetch_array($resultKT)) {
    $arrKT[] = $rowKT;
  }

  // hien thi nhan vien
  $nv = "SELECT id, ma_nv, ten_nv FROM nhanvien ORDER BY id DESC";
  $resultNV = mysqli_query($conn, $nv);
  $arrNV = array();
  while ($rowNV = mysqli_fetch_array($resultNV)) {
    $arrNV[] = $rowNV;
  }

  // create code 
  $maLoai = "LKT" . time();
  $maKhenThuong = "MKT" . time();

  // them loai khen thuong
  if(isset($_POST['taoLoai']))
  {
    // create array error
    $error = array();
    $success = array();
    $showMess = false;

    // get id in form
    $tenLoai = $_POST['tenLoai'];
    $moTa = $_POST['moTa'];
    $flag = 1;
    $nguoiTao = $_POST['nguoiTao'];
    $ngayTao = date("Y-m-d H:i:s");

    // validate
    if(empty($tenLoai))
      $error['tenLoai'] = 'Please input <b> name type  </b>';

    if(!$error)
    {
      $showMess = true;
      $insert = "INSERT INTO loai_khen_thuong_ky_luat(ma_loai, ten_loai, ghi_chu, flag, nguoi_tao, ngay_tao, nguoi_sua, ngay_sua) VALUES('$maLoai','$tenLoai','$moTa', '$flag', '$nguoiTao', '$ngayTao', '$nguoiTao', '$ngayTao')";
      $result = mysqli_query($conn, $insert);
      if($result)
      {
        $success['success'] = 'Create type  Reward Success';
        echo '<script>setTimeout("window.location=\'khen-thuong.php?p=bonus-discipline&a=bonus&tao-loai\'",1000);</script>';
      }
    }
  }

  // them khen thuong
  if(isset($_POST['taoKhenThuong']))
  {
    // create array error
    $error = array();
    $success = array();
    $showMess = false;

    // get id in form
    $soQuyetDinh = $_POST['soQuyetDinh'];
    $ngayQuyetDinh = $_POST['ngayQuyetDinh'];
    $tenKhenThuong = $_POST['tenKhenThuong'];
    $nhanVien = $_POST['nhanVien'];
    $loaiKhenThuong = $_POST['loaiKhenThuong'];
    $hinhThuc = $_POST['hinhThuc'];
    $soTienThuong = $_POST['soTienThuong'];
    $moTa = $_POST['moTa'];
    $nguoiTao = $_POST['nguoiTao'];
    $ngayTao = date("Y-m-d H:i:s");
    $flag = 1;


    // validate
    if(empty($soQuyetDinh))
      $error['soQuyetDinh'] = 'Please input <b>  Decision </b>';
    if($nhanVien == 'chon')
      $error['nhanVien'] = 'Please select <b> staff </b>';
    if($loaiKhenThuong == 'chon')
      $error['loaiKhenThuong'] = 'Please select <b> type  Reward </b>';
    if($hinhThuc == 'chon')
      $error['hinhThuc'] = 'Please select <b> Form </b>';
    if(empty($soTienThuong))
      $error['soTienThuong'] = 'Please input <b>  bonus </b>';

    if(!$error)
    {
      $showMess = true;
      $insert = "INSERT INTO khen_thuong_ky_luat(ma_kt, so_qd, ngay_qd, nhanvien_id, ten_khen_thuong, loai_kt_id, hinh_thuc, so_tien, flag, ghi_chu, nguoi_tao, ngay_tao, nguoi_sua, ngay_sua) VALUES('$maKhenThuong', '$soQuyetDinh', '$ngayQuyetDinh', '$nhanVien', '$tenKhenThuong', '$loaiKhenThuong', '$hinhThuc', '$soTienThuong', '$flag', '$moTa', '$nguoiTao', '$ngayTao', '$nguoiTao', '$ngayTao')";
      $result = mysqli_query($conn, $insert);
      if($result)
      {
        $success['success'] = 'Create Reward Success';
        echo '<script>setTimeout("window.location=\'khen-thuong.php?p=bonus-discipline&a=bonus&khen-thuong\'",1000);</script>';
      }
    }
  }

  // delete record
  if(isset($_POST['delete']))
  {
    $showMess = true;
    $id = $_POST['id'];

    // chon xoa bang nao?
    $table = substr($id, 0, 3);

    // neu xoa loai khen thuong
    if($table == 'LKT')
    {
      $delete = "DELETE FROM loai_khen_thuong_ky_luat WHERE ma_loai = '$id'";
      mysqli_query($conn, $delete);
      $success['success'] = 'Delete type  Reward Success.';
      echo '<script>setTimeout("window.location=\'khen-thuong.php?p=bonus-discipline&a=bonus&tao-loai\'",1000);</script>';
    }
    
    // neu xoa khen thuong
    if($table == 'MKT')
    {
      $delete = "DELETE FROM khen_thuong_ky_luat WHERE ma_kt = '$id'";
      mysqli_query($conn, $delete);
      $success['success'] = 'Delete Reward Success.';
      echo '<script>setTimeout("window.location=\'khen-thuong.php?p=bonus-discipline&a=bonus&khen-thuong\'",1000);</script>';
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
            <input type="hidden" name="id">
            Do you really want to Delete <?php if(isset($_GET['tao-loai'])){ echo "type  Reward"; }else{ echo "Reward"; } ?> This?
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
        Reward
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="khen-thuong.php?p=bonus-discipline&a=bonus">Reward</a></li>
        <li class="active">Reward staff</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Action function</h3>
            </div>
            <div class="box-body">
              <a  href="khen-thuong.php?p=bonus-discipline&a=bonus&tao-loai" class="btn btn-app">
                <i class="fa fa-plus"></i> Type  Reward
              </a>
              <a href="khen-thuong.php?p=bonus-discipline&a=bonus&khen-thuong" class="btn btn-app">
                <i class="fa fa-star"></i> Create Reward
              </a>
              <?php 
                if(isset($_GET['tao-loai']) || isset($_GET['khen-thuong']))
                  echo "<a href='khen-thuong.php?p=bonus-discipline&a=bonus' class='btn btn-app'>
                          <i class='fa fa-close'></i> Cancel
                        </a>";
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- box -->
          <?php 
          if(isset($_GET['tao-loai']))
          {
          ?>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create type  Reward</h3>
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
                // show error
                if(isset($error)) 
                {
                  if($showMess == false)
                  {
                    echo "<div class='alert alert-danger alert-dismissible'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<h4><i class='icon fa fa-ban'></i> Error!</h4>";
                    foreach ($error as $err) 
                    {
                      echo $err . "<br/>";
                    }
                    echo "</div>";
                  }
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
                      <label for="exampleInputEmail1">Code type : </label>
                      <input type="text" class="form-control" name="speacialCode" value="<?php echo $maLoai; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name type : </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input name type " name="tenLoai">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description: </label>
                      <textarea id="editor1" rows="10" cols="80" name="moTa">
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creator: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row_acc['ho']; ?> <?php echo $row_acc['ten']; ?>" name="nguoiTao" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creation date: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo date('d-m-Y H:i:s'); ?>" name="ngayTao" readonly>
                    </div>
                    <!-- /.form-group -->
                    <?php 
                      if($_SESSION['level'] == 1)
                        echo "<button type='submit' class='btn btn-primary' name='taoLoai'><i class='fa fa-plus'></i> Create type  Reward</button>";
                    ?>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <?php 
          }
          ?>
          <!-- /.box -->
          <?php 
          if(isset($_GET['khen-thuong']))
          {
          ?>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create Reward</h3>
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
                // show error
                if(isset($error)) 
                {
                  if($showMess == false)
                  {
                    echo "<div class='alert alert-danger alert-dismissible'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<h4><i class='icon fa fa-ban'></i> Error!</h4>";
                    foreach ($error as $err) 
                    {
                      echo $err . "<br/>";
                    }
                    echo "</div>";
                  }
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
                      <label for="exampleInputEmail1">Code Reward: </label>
                      <input type="text" class="form-control" name="maKhenThuong" value="<?php echo $maKhenThuong; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"> Decision <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input  Decision" name="soQuyetDinh" value="<?php echo isset($_POST['soQuyetDinh']) ? $_POST['soQuyetDinh'] : ''; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Decision day: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Input name type " value="<?php echo date('Y-m-d'); ?>" name="ngayQuyetDinh">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name Reward <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input name Reward" name="tenKhenThuong">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select staff: </label>
                      <select class="form-control" name="nhanVien">
                      <option value="chon">--- Select staff ---</option>
                      <?php 
                        foreach($arrNV as $nv)
                        {
                          echo "<option value='".$nv['id']."'>".$nv['ma_nv']." - ".$nv['ten_nv']."</option>";
                        }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Type  Reward: </label>
                      <select class="form-control" name="loaiKhenThuong">
                      <option value="chon">--- Select Reward ---</option>
                      <?php 
                        foreach($arrShow as $arrS)
                        {
                          echo "<option value='".$arrS['id']."'>".$arrS['ten_loai']."</option>";
                        }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Form: </label>
                      <select class="form-control" name="hinhThuc">
                        <option value="chon">--- Select Form ---</option>
                        <option value="1">Chuyển khoản qua thẻ</option>
                        <option value="0">Gửi money mặt</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1"> bonus <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input  bonus" name="soTienThuong" value="<?php echo isset($_POST['soTienThuong']) ? $_POST['soTienThuong'] : ''; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description: </label>
                      <textarea class="form-control" id="editor1" name="moTa"></textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creator: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row_acc['ho']; ?> <?php echo $row_acc['ten']; ?>" name="nguoiTao" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Creation date: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo date('d-m-Y H:i:s'); ?>" name="ngayTao" readonly>
                    </div>
                    <!-- /.form-group -->
                    <?php 
                      if($_SESSION['level'] == 1)
                        echo "<button type='submit' class='btn btn-primary' name='taoKhenThuong'><i class='fa fa-plus'></i> Create Reward</button>";
                    ?>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <?php 
          }
          ?>
          <!-- Bảng type  Reward -->
          <?php 
          if(isset($_GET['tao-loai']))
          {
          ?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of type  Reward</h3>
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
                // show error
                if(isset($error)) 
                {
                  if($showMess == false)
                  {
                    echo "<div class='alert alert-danger alert-dismissible'>";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
                    echo "<h4><i class='icon fa fa-ban'></i> Error!</h4>";
                    foreach ($error as $err) 
                    {
                      echo $err . "<br/>";
                    }
                    echo "</div>";
                  }
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
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Code type </th>
                    <th>Name type </th>
                    <th>Description</th>
                    <th>Creator</th>
                    <th>Creation date</th>
                    <th>Fixer</th>
                    <th>Edit date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $count = 1;
                    foreach ($arrShow as $arrS) 
                    {
                  ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $arrS['ma_loai']; ?></td>
                        <td><?php echo $arrS['ten_loai']; ?></td>
                        <td><?php echo $arrS['ghi_chu']; ?></td>
                        <td><?php echo $arrS['nguoi_tao']; ?></td>
                        <td><?php echo $arrS['ngay_tao']; ?></td>
                        <td><?php echo $arrS['nguoi_sua']; ?></td>
                        <td><?php echo $arrS['ngay_sua']; ?></td>
                        <th>
                          <?php 
                            if($row_acc['quyen'] == 1)
                            {
                              echo "<form method='POST'>";
                              echo "<input type='hidden' value='".$arrS['id']."' name='idLoai'/>";
                              echo "<button type='submit' class='btn bg-orange btn-flat'  name='suaLoai'><i class='fa fa-edit'></i></button>";
                              echo "</form>";
                            }
                            else
                            {
                              echo "<button type='button' class='btn bg-orange btn-flat' disabled><i class='fa fa-edit'></i></button>";
                            }
                          ?>
                          
                        </th>
                        <th>
                          <?php 
                            if($row_acc['quyen'] == 1)
                            {
                              echo "<button type='button' class='btn bg-maroon btn-flat' data-toggle='modal' data-target='#exampleModal' data-whatever='".$arrS['ma_loai']."'><i class='fa fa-trash'></i></button>";
                            }
                            else
                            {
                              echo "<button type='button' class='btn bg-maroon btn-flat' disabled><i class='fa fa-trash'></i></button>";
                            }
                          ?>
                        </th>
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
          <?php 
          }
          ?>
          <!-- Bảng Reward -->
          <?php 
          if(isset($_GET['khen-thuong']))
          {
          ?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Reward</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Code Reward</th>
                    <th>Name Reward</th>
                    <th>Username</th>
                    <th> Decision</th>
                    <th>Decision day</th>
                    <th>Name type </th>
                    <th>Form</th>
                    <th> money</th>
                    <th>Date  Reward</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $count = 1;
                    foreach ($arrKT as $kt) 
                    {
                  ?>
                      <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $kt['ma_kt']; ?></td>
                        <td><?php echo $kt['ten_khen_thuong']; ?></td>
                        <td><?php echo $kt['ten_nv']; ?></td>
                        <td><?php echo $kt['so_qd']; ?></td>
                        <td><?php echo date_format(date_create($kt['ngay_qd']), "d-m-Y"); ?></td>
                        <td><?php echo $kt['ten_loai']; ?></td>
                        <td>
                        <?php 
                          if($kt['hinh_thuc'] == 1)
                          {
                            echo "Chuyển khoản qua thẻ";
                          }
                          else
                          {
                            echo "Gửi money mặt";
                          }
                        ?>
                        </td>
                        <td><?php echo "<span style='color: blue; font-weight: bold;'>". number_format($kt['so_tien'])."vnđ </span>"; ?></td>
                        <td><?php echo date_format(date_create($kt['ngay_tao']), "d-m-Y"); ?></td>
                        <th>
                          <?php 
                            if($row_acc['quyen'] == 1)
                            {
                              echo "<form method='POST'>";
                              echo "<input type='hidden' value='".$kt['ma_kt']."' name='idKhenThuong'/>";
                              echo "<button type='submit' class='btn bg-orange btn-flat'  name='suaKhenThuong'><i class='fa fa-edit'></i></button>";
                              echo "</form>";
                            }
                            else
                            {
                              echo "<button type='button' class='btn bg-orange btn-flat' disabled><i class='fa fa-edit'></i></button>";
                            }
                          ?>
                          
                        </th>
                        <th>
                          <?php 
                            if($row_acc['quyen'] == 1)
                            {
                              echo "<button type='button' class='btn bg-maroon btn-flat' data-toggle='modal' data-target='#exampleModal' data-whatever='".$kt['ma_kt']."'><i class='fa fa-trash'></i></button>";
                            }
                            else
                            {
                              echo "<button type='button' class='btn bg-maroon btn-flat' disabled><i class='fa fa-trash'></i></button>";
                            }
                          ?>
                        </th>
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
          <?php 
          }
          ?>
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