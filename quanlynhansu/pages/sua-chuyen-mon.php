<?php 

// create session
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['level']))
{
  // include file
  include('../layouts/header.php');
  include('../layouts/topbar.php');
  include('../layouts/sidebar.php');

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    // show data
    $showData = "SELECT id, ma_chuyen_mon, ten_chuyen_mon, ghi_chu, nguoi_tao, ngay_tao, nguoi_sua, ngay_sua FROM chuyen_mon WHERE id = $id ORDER BY ngay_tao DESC";
    $result = mysqli_query($conn, $showData);
    $arrShow = array();
    $row = mysqli_fetch_array($result);
  }


  // delete record
  if(isset($_POST['save']))
  {
    // create array error
    $error = array();
    $success = array();
    $showMess = false;

    // get id in form
    $titleSpecial = $_POST['titleSpecial'];
    $description = $_POST['description'];
    $personEdit = $_POST['personCreate'];
    $dateEdit = date("Y-m-d H:i:s");

    // validate
    if(empty($titleSpecial))
      $error['titleSpecial'] = 'Please input <b> name expertise </b>';

    if(!$error)
    {
      $showMess = true;
      $update = " UPDATE chuyen_mon SET 
                  ten_chuyen_mon = '$titleSpecial',
                  ghi_chu = '$description',
                  nguoi_sua = '$personEdit',
                  ngay_sua = '$dateEdit'
                  WHERE id = $id";
      mysqli_query($conn, $update);
      $success['success'] = 'Save Success';
      echo '<script>setTimeout("window.location=\'sua-chuyen-mon.php?p=staff&a=specialize&id='.$id.'\'",1000);</script>';
    }

  }

?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Expertise
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
        <li><a href="chuyen-mon.php?p=staff&a=specialize">Expertise</a></li>
        <li class="active">edit expertise</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">edit expertise</h3>
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
                      <label for="exampleInputEmail1">Code expertise: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" name="speacialCode" value="<?php echo $row['ma_chuyen_mon']; ?>" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Name expertise: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Input name expertise" name="titleSpecial" value="<?php echo $row['ten_chuyen_mon']; ?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Description: </label>
                      <textarea id="editor1" rows="10" cols="80" name="description"><?php echo $row['ghi_chu']; ?>
                      </textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Fixer: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo $row_acc['ho']; ?> <?php echo $row_acc['ten']; ?>" name="personCreate" readonly>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Edit date: </label>
                      <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo date('d-m-Y H:i:s'); ?>" name="dateCreate" readonly>
                    </div>
                    <!-- /.form-group -->
                    <?php 
                      if($_SESSION['level'] == 1)
                        echo "<button type='submit' class='btn btn-warning' name='save'><i class='fa fa-save'></i> Save</button>";
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