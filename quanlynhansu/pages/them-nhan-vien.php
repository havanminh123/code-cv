<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  // create  var default
  $maNhanVien = "MNV" . time();

  // show data
  // ----- Nationality
  $quocTich = "SELECT id, ten_quoc_tich FROM quoc_tich";
  $resultQuocTich = mysqli_query($conn, $quocTich);
  $arrQuocTich = array();
  while ($rowQuocTich = mysqli_fetch_array($resultQuocTich)) 
  {
    $arrQuocTich[] = $rowQuocTich;
  }

  // ----- Religion
  $tonGiao = "SELECT id, ten_ton_giao FROM ton_giao";
  $resultTonGiao = mysqli_query($conn, $tonGiao);
  $arrTonGiao = array();
  while ($rowTonGiao = mysqli_fetch_array($resultTonGiao)) 
  {
    $arrTonGiao[] = $rowTonGiao;
  }

  // ----- Nation
  $danToc = "SELECT id, ten_dan_toc FROM dan_toc";
  $resultDanToc = mysqli_query($conn, $danToc);
  $arrDanToc = array();
  while ($rowDanToc = mysqli_fetch_array($resultDanToc)) 
  {
    $arrDanToc[] = $rowDanToc;
  }

  // ----- Type  staff
  $loaiNhanVien = "SELECT id, ten_loai_nv FROM loai_nv";
  $resultLoaiNhanVien = mysqli_query($conn, $loaiNhanVien);
  $arrLoaiNhanVien = array();
  while ($rowLoaiNhanVien = mysqli_fetch_array($resultLoaiNhanVien)) 
  {
    $arrLoaiNhanVien[] = $rowLoaiNhanVien;
  }

  // ----- Level
  $trinhDo = "SELECT id, ten_trinh_do FROM trinh_do";
  $resultTrinhDo = mysqli_query($conn, $trinhDo);
  $arrTrinhDo = array();
  while ($rowTrinhDo = mysqli_fetch_array($resultTrinhDo)) 
  {
    $arrTrinhDo[] = $rowTrinhDo;
  }

  // ----- Expertise
  $chuyenMon = "SELECT id, ten_chuyen_mon FROM chuyen_mon";
  $resultChuyenMon = mysqli_query($conn, $chuyenMon);
  $arrChuyenMon = array();
  while ($rowChuyenMon = mysqli_fetch_array($resultChuyenMon)) 
  {
    $arrChuyenMon[] = $rowChuyenMon;
  }

  // ----- Degree
  $bangCap = "SELECT id, ten_bang_cap FROM bang_cap";
  $resultBangCap = mysqli_query($conn, $bangCap);
  $arrBangCap = array();
  while ($rowBangCap = mysqli_fetch_array($resultBangCap)) 
  {
    $arrBangCap[] = $rowBangCap;
  }

  // ----- Departments
  $phongBan = "SELECT id, ten_phong_ban FROM phong_ban";
  $resultPhongBan = mysqli_query($conn, $phongBan);
  $arrPhongBan = array();
  while ($rowPhongBan = mysqli_fetch_array($resultPhongBan)) 
  {
    $arrPhongBan[] = $rowPhongBan;
  }

  // ----- position
  $chucVu = "SELECT id, ten_chuc_vu FROM chuc_vu";
  $resultChucVu = mysqli_query($conn, $chucVu);
  $arrChucVu = array();
  while ($rowChucVu = mysqli_fetch_array($resultChucVu)) 
  {
    $arrChucVu[] = $rowChucVu;
  }

  // ----- marriage
  $honNhan = "SELECT id, ten_tinh_trang FROM tinh_trang_hon_nhan";
  $resultHonNhan = mysqli_query($conn, $honNhan);
  $arrHonNhan = array();
  while ($rowHonNhan = mysqli_fetch_array($resultHonNhan)) 
  {
    $arrHonNhan[] = $rowHonNhan;
  }


  // chuc nang them nhan vien
  if(isset($_POST['save']))
  {
    // tao bien bat loi
    $error = array();
    $success = array();
    $showMess = false;

    // lay du lieu ve
    $tenNhanVien = $_POST['tenNhanVien'];
    $bietDanh = $_POST['bietDanh'];
    $honNhan = $_POST['honNhan'];
    $CMND = $_POST['CMND'];
    $ngayCap = $_POST['ngayCap'];
    $noiCap = $_POST['noiCap'];
    $quocTich = $_POST['quocTich'];
    $tonGiao = $_POST['tonGiao'];
    $danToc = $_POST['danToc'];
    $loaiNhanVien = $_POST['loaiNhanVien'];
    $bangCap = $_POST['bangCap'];
    $trangThai = $_POST['trangThai'];
    $gioiTinh = $_POST['gioiTinh'];
    $ngaySinh = $_POST['ngaySinh'];
    $noiSinh = $_POST['noiSinh'];
    $nguyenQuan = $_POST['nguyenQuan'];
    $hoKhau = $_POST['hoKhau'];
    $tamTru = $_POST['tamTru'];
    $phongBan = $_POST['phongBan'];
    $chucVu = $_POST['chucVu'];
    $trinhDo = $_POST['trinhDo'];
    $chuyenMon = $_POST['chuyenMon'];
    $id_user = $row_acc['id'];
    $ngayTao = date("Y-m-d H:i:s");

    // cau hinh o chon anh
    $hinhAnh = $_FILES['hinhAnh']['name'];
    $target_dir = "../uploads/staffs/";
    $target_file = $target_dir . basename($hinhAnh);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // validate
    if(empty($tenNhanVien))
      $error['tenNhanVien'] = 'error';
    if($honNhan == 'chon')
      $error['honNhan'] = 'error';
    if(empty($CMND))
      $error['CMND'] = 'error';
    if(empty($noiCap))
      $error['noiCap'] = 'error';
    if($quocTich == 'chon')
      $error['quocTich'] = 'error';
    if($danToc == 'chon')
      $error['danToc'] = 'error';
    if($loaiNhanVien == 'chon')
      $error['loaiNhanVien'] = 'error';
    if($trangThai == 'chon')
      $error['trangThai'] = 'error';
    if($gioiTinh == 'chon')
      $error['gioiTinh'] = 'error';
    if(empty($hoKhau))
      $error['hoKhau'] = 'error';
    if($phongBan == 'chon')
      $error['phongBan'] = 'error';
    if($chucVu == 'chon')
      $error['chucVu'] = 'error';
    if($trinhDo == 'chon')
      $error['trinhDo'] = 'error';

    // validate file
    if($hinhAnh)
    {
      if($_FILES['hinhAnh']['size'] > 50000000)
        $error['kichThuocAnh'] = 'error';
      if($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif')
        $error['kieuAnh'] = 'error';
    }

    if(!$error)
    {
      if($hinhAnh)
      {
        $imageName = time() . "." . $imageFileType;
        $moveFile = $target_dir . $imageName;

        // insert data
        $insert = "INSERT INTO nhanvien(ma_nv, hinh_anh, ten_nv, biet_danh, gioi_tinh, ngay_sinh, noi_sinh, hon_nhan_id, so_cmnd, noi_cap_cmnd, ngay_cap_cmnd, nguyen_quan, quoc_tich_id, ton_giao_id, dan_toc_id, ho_khau, tam_tru, loai_nv_id, trinh_do_id, chuyen_mon_id, bang_cap_id, phong_ban_id, chuc_vu_id, trang_thai, nguoi_tao_id, ngay_tao, nguoi_sua_id, ngay_sua) VALUES('$maNhanVien', '$imageName', '$tenNhanVien', '$bietDanh', '$gioiTinh', '$ngaySinh', '$noiSinh', '$honNhan', '$CMND', '$noiCap', '$ngayCap', '$nguyenQuan', '$quocTich', '$tonGiao', '$danToc', '$hoKhau', '$tamTru', '$loaiNhanVien', '$trinhDo', '$chuyenMon', '$bangCap', '$phongBan', '$chucVu', '$trangThai', '$id_user', '$ngayTao', '$id_user', '$ngayTao')";
        $result = mysqli_query($conn, $insert);
        if($result)
        {
          $showMess = true;
          // move image
          move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $moveFile);

          $success['success'] = 'Create staff Success';
          echo '<script>setTimeout("window.location=\'them-nhan-vien.php?p=staff&a=add-staff\'",1000);</script>';
        }
      }
      else
      {
        $showMess = true;
        $hinhAnh = "demo-3x4.jpg";
        // insert data
        $insert = "INSERT INTO nhanvien(ma_nv, hinh_anh, ten_nv, biet_danh, gioi_tinh, ngay_sinh, noi_sinh, hon_nhan_id, so_cmnd, noi_cap_cmnd, ngay_cap_cmnd, nguyen_quan, quoc_tich_id, ton_giao_id, dan_toc_id, ho_khau, tam_tru, loai_nv_id, trinh_do_id, chuyen_mon_id, bang_cap_id, phong_ban_id, chuc_vu_id, trang_thai, nguoi_tao_id, ngay_tao, nguoi_sua_id, ngay_sua) VALUES('$maNhanVien', '$hinhAnh', '$tenNhanVien', '$bietDanh', '$gioiTinh', '$ngaySinh', '$noiSinh', '$honNhan', '$CMND', '$noiCap', '$ngayCap', '$nguyenQuan', '$quocTich', '$tonGiao', '$danToc', '$hoKhau', '$tamTru', '$loaiNhanVien', '$trinhDo', '$chuyenMon', '$bangCap', '$phongBan', '$chucVu', '$trangThai', '$id_user', '$ngayTao', '$id_user', '$ngayTao')";
        $result = mysqli_query($conn, $insert);
        if($result)
        {
          $success['success'] = 'Create staff Success';
          echo '<script>setTimeout("window.location=\'them-nhan-vien.php?p=staff&a=add-staff\'",1000);</script>';
        }
      }
    }
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create new staff
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="them-nhan-vien.php?p=staff&a=add-staff">Staff</a></li>
        <li class="active">Create new staff</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create new staff</h3> &emsp;
              <small>
              Input fields marked with <span style="color: red;">*</span> are required</small>
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
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Employee code: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maNhanVien" value="<?php echo $maNhanVien; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Username <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input username" name="tenNhanVien" value="<?php echo isset($_POST['tenNhanVien']) ? $_POST['tenNhanVien'] : ''; ?>">
                      <small style="color: red;"><?php if(isset($error['tenNhanVien'])){ echo "Username không được để trống"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Nickname: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input Nickname" name="bietDanh" value="<?php echo isset($_POST['bietDanh']) ? $_POST['bietDanh'] : ''; ?>">
                    </div>
                    <div class="form-group">
                      <label>
                      Marital status <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="honNhan">
                        <option value="chon">--- 
                        Select marital status ---</option>
                        <?php 
                          foreach ($arrHonNhan as $hn)
                          {
                            echo "<option value='".$hn['id']."'>".$hn['ten_tinh_trang']."</option>";
                          }
                        ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['honNhan'])){ echo "Please Select marital status"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>CMND <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input CMND" name="CMND" value="<?php echo isset($_POST['CMND']) ? $_POST['CMND'] : ''; ?>">
                      <small style="color: red;"><?php if(isset($error['CMND'])){ echo "Please input CMND"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Date of issue <span style="color: red;">*</span>: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Input place of issue" name="ngayCap" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group">
                      <label>Place of issue <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input place of issue" name="noiCap" value="<?php echo isset($_POST['noiCap']) ? $_POST['noiCap'] : ''; ?>">
                      <small style="color: red;"><?php if(isset($error['noiCap'])){ echo "Please input place of issue"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Nationality<span style="color: red;">*</span>: </label>
                      <select class="form-control" name="quocTich">
                      <option value="chon">--- Select nationality---</option>
                      <?php 
                        foreach ($arrQuocTich as $qt)
                        {
                          echo "<option value='".$qt['id']."'>".$qt['ten_quoc_tich']."</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['quocTich'])){ echo "Please select nationality"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Religion: </label>
                      <select class="form-control" name="tonGiao">
                      <?php 
                      foreach ($arrTonGiao as $tg)
                      {
                        echo "<option value='".$tg['id']."'>".$tg['ten_ton_giao']."</option>";
                      }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nation <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="danToc">
                      <option value="chon">--- Select nation ---</option>
                      <?php 
                      foreach ($arrDanToc as $dt)
                      {
                        echo "<option value='".$dt['id']."'>".$dt['ten_dan_toc']."</option>";
                      }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['danToc'])){ echo "Please select nation"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Type  staff <span style="color: red;">*</span> : </label>
                      <select class="form-control" name="loaiNhanVien">
                      <option value="chon">--- Select type  staff ---</option>
                      <?php 
                        foreach ($arrLoaiNhanVien as $lnv)
                        {
                          echo "<option value='".$lnv['id']."'>".$lnv['ten_loai_nv']."</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['loaiNhanVien'])){ echo "Please select type  staff"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Degree: </label>
                      <select class="form-control" name="bangCap">
                      <?php 
                        foreach ($arrBangCap as $bc)
                        {
                          echo "<option value='".$bc['id']."'>".$bc['ten_bang_cap']."</option>";
                        }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Status <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="trangThai">
                        <option value="chon">--- Select status ---</option>
                        <option value="1">Working</option>
                        <option value="0">Retired</option>
                      </select>
                      <small style="color: red;"><?php if(isset($error['trangThai'])){ echo "Please select status"; } ?></small>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>
                      3x4 photo (if available) </label>
                      <input type="file" class="form-control" id="exampleInputEmail1" name="hinhAnh">
                      <small style="color: red;"><?php if(isset($error['kichThuocAnh'])){ echo "Image size too large"; } ?></small>
                      <small style="color: red;"><?php if(isset($error['kieuAnh'])){ echo "Only accept image files in format: jpg, jpeg, png, gif"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Sex <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="gioiTinh">
                        <option value="chon">--- Select sex ---</option>
                        <option value="1">Nam</option>
                        <option value="0">Nữ</option>
                      </select>
                      <small style="color: red;"><?php if(isset($error['gioiTinh'])){ echo "Please select sex "; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Date of birth: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" name="ngaySinh" value="<?php echo date("Y-m-d"); ?>">
                    </div>
                    <div class="form-group">
                      <label>
Place of birth: </label>
                      <textarea class="form-control" name="noiSinh"><?php echo isset($_POST['noiSinh']) ? $_POST['noiSinh'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Original place: </label>
                      <textarea class="form-control" name="nguyenQuan"><?php echo isset($_POST['nguyenQuan']) ? $_POST['nguyenQuan'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Household registration <span style="color: red;">*</span>: </label>
                      <textarea class="form-control" name="hoKhau"></textarea>
                      <small style="color: red;"><?php if(isset($error['hoKhau'])){ echo "Please input household registration"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Temporary residence: </label>
                      <textarea class="form-control" name="tamTru"><?php echo isset($_POST['tamTru']) ? $_POST['tamTru'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Departments <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="phongBan">
                      <option value="chon">--- Select Departments ---</option>
                      <?php 
                        foreach ($arrPhongBan as $pb)
                        {
                          echo "<option value='".$pb['id']."'>".$pb['ten_phong_ban']."</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['phongBan'])){ echo "Please select Departments"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>position <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="chucVu">
                      <option value="chon">--- Select position ---</option>
                      <?php 
                      foreach ($arrChucVu as $cv)
                      {
                        echo "<option value='".$cv['id']."'>".$cv['ten_chuc_vu']."</option>";
                      }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['chucVu'])){ echo "Please select position"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Level <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="trinhDo">
                      <option value="chon">--- Select level ---</option>
                      <?php 
                        foreach ($arrTrinhDo as $td)
                        {
                          echo "<option value='".$td['id']."'>".$td['ten_trinh_do']."</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['trinhDo'])){ echo "Please select level"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Expertise: </label>
                      <select class="form-control" name="chuyenMon">
                      <?php 
                        foreach ($arrChuyenMon as $cm)
                        {
                          echo "<option value='".$cm['id']."'>".$cm['ten_chuyen_mon']."</option>";
                        }
                      ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <?php 
                  if($_SESSION['level'] == 1)
                    echo "<button type='submit' class='btn btn-primary' name='save'><i class='fa fa-plus'></i> Create new staff</button>";
                ?>
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