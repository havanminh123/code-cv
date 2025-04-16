<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');


  // save
  if(isset($_POST['save']))
  {
    // create error array
    $error = array();
    $success = array();
    $showMess = false;

    // get value
    $lastName = $_POST['lastName'];
    $firstName = $_POST['firstName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $repass = md5($_POST['repass']);
    $phone = $_POST['phone'];
    $level = $_POST['level'];
    $status = $_POST['status'];
    $access = 0;
    $date_create = date("Y-m-d H:i:s");
    $date_update = date("Y-m-d H:i:s");

    // validate
    if(empty($_POST['lastName']))
      $error['lastName'] = 'Please input <b> Surname </b>';

    if(empty($_POST['firstName']))
      $error['firstName'] = 'Please input <b> name </b>';

    if(empty($_POST['email']))
      $error['email'] = 'Please input <b> email </b>';

    if(empty($_POST['password']))
      $error['password'] = 'Please input <b> Password </b>';

    if(empty($_POST['repass']))
      $error['repass'] = 'Please input again <b> Password </b>';

    if((!empty($_POST['password']) && !empty($_POST['repass'])) && ($password != $repass))
      $error['checkPass'] = 'Password không <b> trùng nhau </b>. Please input lại!.';

    // check email exists
    $checkEmail = "SELECT email FROM tai_khoan WHERE email = '$email'";
    $rs_checkEmail = mysqli_query($conn, $checkEmail);
    if(mysqli_num_rows($rs_checkEmail) > 0)
      $error['checkEmail'] = 'Email <b> đã được sử dụng </b>. Please input email khác!.';
    
    // validate file image
    $target_dir = '../uploads/images/';
    $image = $_FILES['image']['name'];
    $target_file = $target_dir . basename($image);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if($image)
    {
      // check file type
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif")
      {
        $error['formatImage'] = 'Image không đúng định dạng: <b>jpg</b>, <b>jpeg</b>, <b>png</b>, <b>gif</b>';
      }
      else
      {
        // check exists
        if (file_exists($target_file)) 
        {
          $nameImage = time() . "." . $imageFileType;
        }
        else
        {
          $nameImage = time() . "." . $imageFileType;
        }
      }
    }

    // save to db
    if(!$error)
    {
      $showMess = true;

      if($image)
      {

        // insert record
        $insert = "INSERT INTO tai_khoan(ho, ten, hinh_anh, email, mat_khau, so_dt, quyen, trang_thai, truy_cap, ngay_sua, ngay_tao) VALUES('$lastName', '$firstName', '$nameImage', '$email', '$password', '$phone', $level, $status, $access, '$date_create', '$date_update')";   
        mysqli_query($conn, $insert);
        // add image to folder
        $dirFile = $target_dir . $nameImage;
        move_uploaded_file($_FILES["image"]["tmp_name"], $dirFile);
        $success['success'] = 'Create Account new Success.';
        echo '<script>setTimeout("window.location=\'tao-tai-khoan.php?p=account&a=add-account\'",1000);</script>';
      }
      else
      {
        $nameImage = 'admin.png';
        // insert record
        $insert = "INSERT INTO tai_khoan(ho, ten, hinh_anh, email, mat_khau, so_dt, quyen, trang_thai, truy_cap, ngay_sua, ngay_tao) VALUES('$lastName', '$firstName', '$nameImage', '$email', '$password', '$phone', $level, $status, $access, '$date_create', '$date_update')";   
        mysqli_query($conn, $insert);
        $success['success'] = 'Create Account new Success.';
        echo '<script>setTimeout("window.location=\'tao-tai-khoan.php?p=account&a=add-account\'",1000);</script>';
      }
    }
  }

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Account
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="tao-tai-khoan.php?p=account&a=add-account">Account</a></li>
        <li class="active">Create new Account</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create Account</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" enctype="multipart/form-data">
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
                <div class="form-group">
                  <label for="exampleInputEmail1">Select Image: </label>
                  <input type="file" class="form-control" id="exampleInputEmail1" name="image">
                  <p class="help-block">Please select file đúng định dạng: jpg, jpeg, png, gif.</p>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Surname: <b style="color: red;">*</b></label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Input Surname" name="lastName" value="<?php echo isset($_POST['lastName']) ? $_POST['lastName'] : ''; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">name: <b style="color: red;">*</b></label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Input name" name="firstName" value="<?php echo isset($_POST['firstName']) ? $_POST['firstName'] : ''; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email: <b style="color: red;">*</b></label>
                  <input type="email" class="form-control" id="exampleInputPassword1" placeholder="Input email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password: <b style="color: red;">*</b></label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Input Password" name="password">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Input again Password: <b style="color: red;">*</b></label>
                  <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Input again Password" name="repass">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1"> phone:</label>
                  <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Input  phone" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">role:</label>
                  <div class="col-md-12">
                    <label>
                      <input type="radio" name="level" class="minimal" value="1" checked>
                      Administrator
                    </label>
                    <label>
                      <input type="radio" name="level" class="minimal" value="0">
                      Staff
                    </label>
                  </div>
                </div> 
                <div class="form-group">
                  <label for="exampleInputPassword1">Status:</label>
                  <div class="col-md-12">
                    <label>
                      <input type="radio" name="status" class="minimal" value="1" checked>
                      Active
                    </label>
                    <label>
                      <input type="radio" name="status" class="minimal" value="0">
                      Ngừng hoạt động
                    </label>
                  </div>
                </div> 
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <?php 
                  if($_SESSION['level'] == 1)
                    echo "<button type='submit' class='btn btn-primary' name='save'><i class='fa fa-plus'></i> Create Account new</button>";
                ?>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

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