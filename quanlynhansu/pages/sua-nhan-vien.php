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
  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $showData = "SELECT nv.id as id, quoc_tich_id, ton_giao_id, dan_toc_id, loai_nv_id, bang_cap_id, phong_ban_id, chuc_vu_id, trinh_do_id, chuyen_mon_id, hon_nhan_id, ma_nv, hinh_anh, ten_nv, biet_danh, gioi_tinh, nv.ngay_tao as ngay_tao, ngay_sinh, noi_sinh, so_cmnd, ngay_cap_cmnd, noi_cap_cmnd, nguyen_quan, ten_quoc_tich, ten_dan_toc, ten_ton_giao, ho_khau, tam_tru, ten_loai_nv, ten_trinh_do, ten_chuyen_mon, ten_bang_cap, ten_phong_ban, ten_chuc_vu, ten_tinh_trang, trang_thai FROM nhanvien nv, quoc_tich qt, dan_toc dt, ton_giao tg, loai_nv lnv, trinh_do td, chuyen_mon cm, bang_cap bc, phong_ban pb, chuc_vu cv, tinh_trang_hon_nhan hn WHERE nv.quoc_tich_id = qt.id AND nv.dan_toc_id = dt.id AND nv.ton_giao_id = tg.id AND nv.loai_nv_id = lnv.id AND nv.trinh_do_id = td.id AND nv.chuyen_mon_id = cm.id AND nv.bang_cap_id = bc.id AND nv.phong_ban_id = pb.id AND nv.chuc_vu_id = cv.id AND nv.hon_nhan_id = hn.id AND nv.id = $id";
    $result = mysqli_query($conn, $showData);
    $row = mysqli_fetch_array($result);

    // set option active
    $qt_id = $row['quoc_tich_id'];
    $ten_qt = $row['ten_quoc_tich'];

    $tg_id = $row['ton_giao_id'];
    $ten_tg = $row['ten_ton_giao'];

    $dt_id = $row['dan_toc_id'];
    $ten_dt = $row['ten_dan_toc'];

    $nv_id = $row['loai_nv_id'];
    $ten_nv = $row['ten_loai_nv'];

    $bc_id = $row['bang_cap_id'];
    $ten_bc = $row['ten_bang_cap'];

    $pb_id = $row['phong_ban_id'];
    $ten_pb = $row['ten_phong_ban'];

    $cv_id = $row['chuc_vu_id'];
    $ten_cv = $row['ten_chuc_vu'];

    $td_id = $row['trinh_do_id'];
    $ten_td = $row['ten_trinh_do'];

    $cm_id = $row['chuyen_mon_id'];
    $ten_cm = $row['ten_chuyen_mon'];

    $hn_id = $row['hon_nhan_id'];
    $ten_hn = $row['ten_tinh_trang'];


    // set value option another
    $qt = "SELECT id, ten_quoc_tich FROM quoc_tich WHERE id <> $qt_id";
    $resultQT = mysqli_query($conn, $qt);
    $arrQT = array();
    while ($rowQT = mysqli_fetch_array($resultQT)) 
    {
      $arrQT[] = $rowQT;
    }

    $tg = "SELECT id, ten_ton_giao FROM ton_giao WHERE id <> $tg_id";
    $resultTG = mysqli_query($conn, $tg);
    $arrTG = array();
    while ($rowTG = mysqli_fetch_array($resultTG)) 
    {
      $arrTG[] = $rowTG;
    }

    $dt = "SELECT id, ten_dan_toc FROM dan_toc WHERE id <> $dt_id";
    $resultDT = mysqli_query($conn, $dt);
    $arrDT = array();
    while ($rowDT = mysqli_fetch_array($resultDT)) 
    {
      $arrDT[] = $rowDT;
    }

    $lnv = "SELECT id, ten_loai_nv FROM loai_nv WHERE id <> $nv_id";
    $resultLNV = mysqli_query($conn, $lnv);
    $arrLNV = array();
    while ($rowLNV = mysqli_fetch_array($resultLNV)) 
    {
      $arrLNV[] = $rowLNV;
    }

    $bc = "SELECT id, ten_bang_cap FROM bang_cap WHERE id <> $bc_id";
    $resultBC = mysqli_query($conn, $bc);
    $arrBC = array();
    while ($rowBC = mysqli_fetch_array($resultBC)) 
    {
      $arrBC[] = $rowBC;
    }

    $pb = "SELECT id, ten_phong_ban FROM phong_ban WHERE id <> $pb_id";
    $resultPB = mysqli_query($conn, $pb);
    $arrPB = array();
    while ($rowPB = mysqli_fetch_array($resultPB)) 
    {
      $arrPB[] = $rowPB;
    }

    $cv = "SELECT id, ten_chuc_vu FROM chuc_vu WHERE id <> $cv_id";
    $resultCV = mysqli_query($conn, $cv);
    $arrCV = array();
    while ($rowCV = mysqli_fetch_array($resultCV)) 
    {
      $arrCV[] = $rowCV;
    }

    $td = "SELECT id, ten_trinh_do FROM trinh_do WHERE id <> $td_id";
    $resultTD = mysqli_query($conn, $td);
    $arrTD = array();
    while ($rowTD = mysqli_fetch_array($resultTD)) 
    {
      $arrTD[] = $rowTD;
    }

    $cm = "SELECT id, ten_chuyen_mon FROM chuyen_mon WHERE id <> $cm_id";
    $resultCM = mysqli_query($conn, $cm);
    $arrCM = array();
    while ($rowCM = mysqli_fetch_array($resultCM)) 
    {
      $arrCM[] = $rowCM;
    }

    $hn = "SELECT id, ten_tinh_trang FROM tinh_trang_hon_nhan WHERE id <> $hn_id";
    $resultHN = mysqli_query($conn, $hn);
    $arrHN = array();
    while ($rowHN = mysqli_fetch_array($resultHN)) 
    {
      $arrHN[] = $rowHN;
    }

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
    $ngaySua = date("Y-m-d H:i:s");

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

        // remove old image
        $oldImage = $row['hinh_anh'];

        // insert data
        $update = " UPDATE nhanvien SET 
                    hinh_anh = '$imageName',
                    ten_nv = '$tenNhanVien',
                    biet_danh = '$bietDanh',
                    gioi_tinh = '$gioiTinh',
                    ngay_sinh = '$ngaySinh',
                    noi_sinh = '$noiSinh',
                    hon_nhan_id = '$honNhan',
                    so_cmnd = '$CMND',
                    noi_cap_cmnd = '$noiCap',
                    ngay_cap_cmnd = '$ngayCap',
                    nguyen_quan = '$nguyenQuan',
                    quoc_tich_id = '$quocTich',
                    ton_giao_id = '$tonGiao',
                    dan_toc_id = '$danToc',
                    ho_khau = '$hoKhau',
                    tam_tru = '$tamTru',
                    loai_nv_id = '$loaiNhanVien',
                    trinh_do_id = '$trinhDo',
                    chuyen_mon_id = '$chuyenMon',
                    bang_cap_id = '$bangCap',
                    phong_ban_id = '$phongBan',
                    chuc_vu_id = '$chucVu',
                    trang_thai = '$trangThai',
                    nguoi_sua_id = '$id_user',
                    ngay_sua = '$ngaySua'
                    WHERE id = $id";
        $result = mysqli_query($conn, $update);

        if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
          // Duyệt qua từng Image
          for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
              // Lấy name, type  và tạm thời của Image
              $fileName = $_FILES['images']['name'][$i];
              $fileTmp = $_FILES['images']['tmp_name'][$i];
              $fileType = $_FILES['images']['type'][$i];
  
              // Đường dẫn lưu trữ Image
              $uploadDir = 'uploads/images/';
              $uploadFile = $uploadDir . basename($fileName);
  
              // Kiểm tra nếu tệp là Image
              $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
              if (in_array($fileType, $allowedTypes)) {
                  // Di chuyển Image đến thư mục lưu trữ
                  if (move_uploaded_file($fileTmp, $uploadFile)) {
                      echo "Tải Image '$fileName' lên Success.<br>";
                      // $stmt = $conn->prepare("INSERT INTO images (file_name, file_path) VALUES (?, ?)");
                      $result = mysqli_query($conn, "INSERT INTO images (employee_id, file_name) VALUES ($id, 'uploads/images/'$fileName)");
                  } else {
                      echo "Error khi tải Image '$fileName'.<br>";
                  }
              } else {
                  echo "'$fileName' không phải là một Image hợp lệ.<br>";
              }
          }
        }


        if($result)
        {
          $showMess = true;

          // remove old image
          if($oldImage != "demo-3x4.jpg")
          {
            unlink($target_dir . $oldImage);
          }

          // move image
          move_uploaded_file($_FILES["hinhAnh"]["tmp_name"], $moveFile);

          $success['success'] = 'Lưu Information Success';
          echo '<script>setTimeout("window.location=\'sua-nhan-vien.php?p=staff&a=list-staff&id='.$id.'\'",1000);</script>';
        }
      }
      else
      {
        $showMess = true;
        // update data
        $update = " UPDATE nhanvien SET 
                    ten_nv = '$tenNhanVien',
                    biet_danh = '$bietDanh',
                    gioi_tinh = '$gioiTinh',
                    ngay_sinh = '$ngaySinh',
                    noi_sinh = '$noiSinh',
                    hon_nhan_id = '$honNhan',
                    so_cmnd = '$CMND',
                    noi_cap_cmnd = '$noiCap',
                    ngay_cap_cmnd = '$ngayCap',
                    nguyen_quan = '$nguyenQuan',
                    quoc_tich_id = '$quocTich',
                    ton_giao_id = '$tonGiao',
                    dan_toc_id = '$danToc',
                    ho_khau = '$hoKhau',
                    tam_tru = '$tamTru',
                    loai_nv_id = '$loaiNhanVien',
                    trinh_do_id = '$trinhDo',
                    chuyen_mon_id = '$chuyenMon',
                    bang_cap_id = '$bangCap',
                    phong_ban_id = '$phongBan',
                    chuc_vu_id = '$chucVu',
                    trang_thai = '$trangThai',
                    nguoi_sua_id = '$id_user',
                    ngay_sua = '$ngaySua'
                    WHERE id = $id";
        $result = mysqli_query($conn, $update);
        $uploadDir = 'uploads/images'; // Đường dẫn đến thư mục uploads

        // Kiểm tra nếu thư mục uploads tồn tại, nếu không create new
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
          // Duyệt qua từng Image
          for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
              // Lấy name, type  và tạm thời của Image
              $fileName = $_FILES['images']['name'][$i];
              $fileTmp = $_FILES['images']['tmp_name'][$i];
              $fileType = $_FILES['images']['type'][$i];
  
              // Đường dẫn lưu trữ Image
              $uploadDir = 'uploads/images/';
              $uploadFile = $uploadDir . basename($fileName);
  
              // Kiểm tra nếu tệp là Image
              $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
              if (in_array($fileType, $allowedTypes)) {
                  // Di chuyển Image đến thư mục lưu trữ
                  if (move_uploaded_file($fileTmp, $uploadFile)) {
                      // echo "Tải Image '$fileName' lên Success.<br>";
                      // $stmt = $conn->prepare("INSERT INTO images (file_name, file_path) VALUES (?, ?)");
                      $result = mysqli_query($conn, "INSERT INTO images (employee_id, file_name) VALUES ($id, 'uploads/images/$fileName')");
                  } else {
                      echo "Error khi tải Image '$fileName'.<br>";
                  }
              } else {
                  echo "'$fileName' không phải là một Image hợp lệ.<br>";
              }
          }
        }

        if($result)
        {
          $success['success'] = 'Lưu Information Success';
          echo '<script>setTimeout("window.location=\'sua-nhan-vien.php?p=staff&a=list-staff&id='.$id.'\'",1000);</script>';

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
        edit staff
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="danh-sach-nhan-vien.php?p=staff&a=list-staff">Staff</a></li>
        <li class="active">edit Information staff</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">edit Information staff</h3> &emsp;
              <small>Những ô input có dấu <span style="color: red;">*</span> là bắt buộc</small>
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
                      <input type="text" class="form-control" id="exampleInputEmail1" name="maNhanVien" value="<?php echo $row['ma_nv']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label>Username <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input username" name="tenNhanVien" value="<?php echo $row['ten_nv']; ?>">
                      <small style="color: red;"><?php if(isset($error['tenNhanVien'])){ echo "Username không được để trống"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Nickname: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input Nickname" name="bietDanh" value="<?php echo $row['biet_danh']; ?>">
                    </div>
                    <div class="form-group">
                      <label>Status marriage <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="honNhan">
                        <option value="<?php echo $hn_id; ?>"><?php echo $ten_hn; ?></option>
                        <?php 
                          foreach ($arrHN as $hn)
                          {
                            echo "<option value='".$hn['id']."'>".$hn['ten_tinh_trang']."</option>";
                          }
                        ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['honNhan'])){ echo "Please select Status marriage"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>CMND <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input CMND" name="CMND" value="<?php echo $row['so_cmnd']; ?>">
                      <small style="color: red;"><?php if(isset($error['CMND'])){ echo "Please input CMND"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Date of issue <span style="color: red;">*</span>: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Input place of issue" name="ngayCap" value="<?php echo $row['ngay_cap_cmnd']; ?>">
                    </div>
                    <div class="form-group">
                      <label>Place of issue <span style="color: red;">*</span>: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input place of issue" name="noiCap" value="<?php echo $row['noi_cap_cmnd']; ?>">
                      <small style="color: red;"><?php if(isset($error['noiCap'])){ echo "Please input place of issue"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Nationality<span style="color: red;">*</span>: </label>
                      <select class="form-control" name="quocTich">
                      <option value="<?php echo $qt_id; ?>"><?php echo $ten_qt; ?></option>
                      <?php 
                        foreach ($arrQT as $qt)
                        {
                          echo "<option value='".$qt['id']."'>".$qt['ten_quoc_tich']."</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['quocTich'])){ echo "Please select Nationality"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Religion: </label>
                      <select class="form-control" name="tonGiao">
                      <option value="<?php echo $tg_id; ?>"><?php echo $ten_tg; ?></option>
                      <?php 
                      foreach ($arrTG as $tg)
                      {
                        echo "<option value='".$tg['id']."'>".$tg['ten_ton_giao']."</option>";
                      }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Nation <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="danToc">
                      <option value="<?php echo $dt_id; ?>"><?php echo $ten_dt; ?></option>
                      <?php 
                      foreach ($arrDT as $dt)
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
                      <option value="<?php echo $nv_id; ?>"><?php echo $ten_nv; ?></option>
                      <?php 
                        foreach ($arrLNV as $lnv)
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
                      <option value="<?php echo $bc_id; ?>"><?php echo $ten_bc; ?></option>
                      <?php 
                        foreach ($arrBC as $bc)
                        {
                          echo "<option value='".$bc['id']."'>".$bc['ten_bang_cap']."</option>";
                        }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Status <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="trangThai">
                      <?php 
                        if($row['trang_thai'] == 1)
                        {
                          echo "<option value='1' selected>Working</option>";
                          echo "<option value='0'>Retired</option>";
                        }
                        else
                        {
                          echo "<option value='1'>Working</option>";
                          echo "<option value='0' selected>Retired</option>";
                        }
                      ?>
                        
                        
                      </select>
                      <small style="color: red;"><?php if(isset($error['trangThai'])){ echo "Please select status"; } ?></small>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Image 3x4 (Nếu có): </label>
                      <input type="file" class="form-control" id="exampleInputEmail1" name="hinhAnh">
                      <small style="color: red;"><?php if(isset($error['kichThuocAnh'])){ echo "Kích thước Image quá lớn"; } ?></small>
                      <small style="color: red;"><?php if(isset($error['kieuAnh'])){ echo "Chỉ nhận file Image dạng: jpg, jpeg, png, gif"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Sex <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="gioiTinh">
                      <?php 
                        if($row['gioi_tinh'] == 1)
                        {
                          echo "<option value='1' selected>Nam</option>";
                          echo "<option value='0'>Nữ</option>";
                        }
                        else
                        {
                          echo "<option value='1'>Nam</option>";
                          echo "<option value='0' selected>Nữ</option>";
                        }
                      ?>
                      </select>
                      <small style="color: red;"><?php if(isset($error['gioiTinh'])){ echo "Please select sex "; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Date of birth: </label>
                      <input type="date" class="form-control" id="exampleInputEmail1" name="ngaySinh" value="<?php echo $row['ngay_sinh']; ?>">
                    </div>
                    <div class="form-group">
                      <label>
Place of birth: </label>
                      <textarea class="form-control" name="noiSinh"><?php echo $row['noi_sinh']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Original place: </label>
                      <textarea class="form-control" name="nguyenQuan"><?php echo $row['nguyen_quan']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Household registration <span style="color: red;">*</span>: </label>
                      <textarea class="form-control" name="hoKhau"><?php echo $row['ho_khau']; ?></textarea>
                      <small style="color: red;"><?php if(isset($error['hoKhau'])){ echo "Please input household registration"; } ?></small>
                    </div>
                    <div class="form-group">
                      <label>Temporary residence: </label>
                      <textarea class="form-control" name="tamTru"><?php echo $row['tam_tru']; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Departments <span style="color: red;">*</span>: </label>
                      <select class="form-control" name="phongBan">
                      <option value="<?php echo $pb_id; ?>"><?php echo $ten_pb; ?></option>
                      <?php 
                        foreach ($arrPB as $pb)
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
                      <option value="<?php echo $cv_id; ?>"><?php echo $ten_cv; ?></option>
                      <?php 
                      foreach ($arrCV as $cv)
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
                      <option value="<?php echo $td_id; ?>"><?php echo $ten_td; ?></option>
                      <?php 
                        foreach ($arrTD as $td)
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
                      <option value="<?php echo $cm_id; ?>"><?php echo $ten_cm; ?></option>
                      <?php 
                        foreach ($arrCM as $cm)
                        {
                          echo "<option value='".$cm['id']."'>".$cm['ten_chuyen_mon']."</option>";
                        }
                      ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Image timekeeping (nhiều Image khuân mặt mình): </label>
                      <input type="file" name="images[]" id="images"  class="form-control" multiple>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <?php 
                if($_SESSION['level'] == 1)
                  echo "<button type='submit' class='btn btn-warning' name='save'><i class='fa fa-save'></i> Save Information</button>";
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