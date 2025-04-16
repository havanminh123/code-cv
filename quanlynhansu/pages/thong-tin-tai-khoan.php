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

    // validate
    if(empty($_POST['lastName']))
      $error['lastName'] = 'Please input <b> Surname </b>';

    if(empty($_POST['firstName']))
      $error['firstName'] = 'Please input <b> name </b>';

    // validate file image
    $target_dir = '../uploads/images/';
    $image = $_FILES["image"]["name"];
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
      $email = $row_acc['email'];
      $lastName = $_POST['lastName'];
      $firstName = $_POST['firstName'];
      $phone = $_POST['phone'];
      // set for admin
      if($_SESSION['level'] == 1)
      { 
        $level = $_POST['level'];
        $status = $_POST['status'];
      }
      else
      {
        $level = $row_acc['quyen'];
        $status = $row_acc['trang_thai'];
      }
      
      
      $date_update = date("Y-m-d H:i:s");

      if($image)
      {
        // update record
        $update = "UPDATE tai_khoan SET
                    ho = '$lastName',
                    ten = '$firstName',
                    hinh_anh = '$nameImage',
                    so_dt = '$phone',
                    quyen = $level,
                    trang_thai = $status,
                    ngay_sua = '$date_update'
                    WHERE email = '$email'";   
        mysqli_query($conn, $update);
        // remove old image
        if($row_acc['hinh_anh'] != 'admin.png')
        {
          unlink($target_dir . $row_acc['hinh_anh']);
        }
        // add image to folder
        $dirFile = $target_dir . $nameImage;
        move_uploaded_file($_FILES["image"]["tmp_name"], $dirFile);
        $success['success'] = 'edit Account Success.';
        echo '<script>setTimeout("window.location=\'thong-tin-tai-khoan.php?p=account&a=profile\'",1000);</script>';
      }
      else
      {
        // update record
        $update = "UPDATE tai_khoan SET
                    ho = '$lastName',
                    ten = '$firstName',
                    so_dt = '$phone',
                    quyen = $level,
                    trang_thai = $status,
                    ngay_sua = '$date_update'
                    WHERE email = '$email'";   
        mysqli_query($conn, $update);
        $success['success'] = 'edit Account Success.';
        echo '<script>setTimeout("window.location=\'thong-tin-tai-khoan.php?p=account&a=profile\'",1000);</script>';
      }
    }
  }

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Information Account
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="thong-tin-tai-khoan.php?p=account&a=profile">Account</a></li>
        <li class="active">Information Account</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../uploads/images/<?php echo $row_acc['hinh_anh']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $row_acc['ten']; ?> <?php echo $row_acc['ho']; ?></h3>

              <p class="text-muted text-center">
                <?php 

                  if($row_acc['quyen'] == 1)
                  {
                    echo "Administrator";
                  }
                  else
                  {
                    echo "Staff";
                  }

                ?>
              </p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>views views:</b> <a class="pull-right"><?php echo number_format($row_acc['truy_cap']); ?></a>
                </li>
                <li class="list-group-item">
                  <b>Creation date:</b> <a class="pull-right">
                    <?php 
                      $date_cre = date_create($row_acc['ngay_tao']);
                      echo date_format($date_cre, 'd/m/Y');
                    ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Edit date:</b> <a class="pull-right">
                    <?php 
                      $date_edi = date_create($row_acc['ngay_sua']);
                      echo date_format($date_edi, 'd/m/Y');
                    ?>
                  </a>
                </li>
                <li class="list-group-item">
                  <b>Status:</b> <a class="pull-right">
                    <?php 
                      if($row_acc['trang_thai'] == 1)
                      {
                        echo "Active";
                      }
                      else
                      {
                        echo "Ngừng hoạt động";
                      }
                    ?>
                  </a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">edit Information</a></li>
            </ul>
            <div class="tab-content">
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
                // show error
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
              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Select Image: </label>
                    <div class="col-sm-10">
                      <input type="file" class="form-control" id="inputName" name="image">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Surname <b style="color: red;">*</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputName" placeholder="Input Surname" value="<?php echo $row_acc['ho']; ?>" name="lastName">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Name <b style="color: red;">*</b></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputEmail" placeholder="Input name" value="<?php echo $row_acc['ten']; ?>" name="firstName">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName"  value="<?php echo $row_acc['email']; ?>" readonly> 
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label"> phone</label>
                    <div class="col-sm-10">
                       <input type="text" class="form-control" id="inputEmail" placeholder="Input  phone" name="phone" value="<?php echo $row_acc['so_dt']; ?>">
                    </div>
                  </div>
                  <?php 
                    // show for admin
                    if($row_acc['quyen'] == 1)
                    {
                  ?>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">role</label>
                    <div class="col-sm-10">
                      <?php 
                        if($row_acc['quyen'] == 1)
                        {
                      ?>
                          <label>
                            <input type="radio" name="level" class="minimal" value="1" checked>
                            Administrator
                          </label>
                          <label>
                            <input type="radio" name="level" class="minimal" value="0">
                            Staff
                          </label>

                      <?php
                        }
                        else
                        {
                      ?>
                          <label>
                            <input type="radio" name="level" class="minimal" value="1">
                            Administrator
                          </label>
                          <label>
                            <input type="radio" name="level" class="minimal" value="0" checked>
                            Staff
                          </label>

                      <?php
                        }
                      ?>
                      
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10">
                      <?php 
                        if($row_acc['trang_thai'] == 1)
                        {
                      ?>
                          <label>
                            <input type="radio" name="status" class="minimal" value="1" checked>
                            Active
                          </label>
                          <label>
                            <input type="radio" name="status" class="minimal" value="0">
                            Inactive
                          </label>

                      <?php
                        }
                        else
                        {
                      ?>
                          <label>
                            <input type="radio" name="status" class="minimal" value="1">
                            Active
                          </label>
                          <label>
                            <input type="radio" name="status" class="minimal" value="0" checked>
                            Inactive
                          </label>

                      <?php
                        }
                      ?>
                      
                    </div>
                  </div>
                  <?php 
                    }
                  ?>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" name="save"><i class="fa fa-save"></i> Save</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
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