<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <a href="index.php?p=index&a=statistic" class="logo">
        <span class="logo-mini"><b>H</b>RM</span>
        <span class="logo-lg"><b>NHOM 4 QLNS</b></span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../uploads/images/<?php echo $row_acc['hinh_anh']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $row_acc['ten']; ?> <?php echo $row_acc['ho']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="../uploads/images/<?php echo $row_acc['hinh_anh']; ?>" class="img-circle" alt="User Image">

                  <p>
                    <?php echo $row_acc['ten']; ?> <?php echo $row_acc['ho']; ?> -
                    <?php
                    if ($row_acc['quyen'] == 1) {
                      echo "Administrator";
                    } else {
                      echo "Staff";
                    }
                    ?>
                    <small>
                      <?php
                      echo "Views: " . $row_acc['truy_cap'];
                      ?>
                    </small>
                  </p>
                </li>
                <!-- Menu Body -->
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a href="thong-tin-tai-khoan.php?p=account&a=profile" class="btn btn-default btn-flat">Account information</a>
                  </div>
                  <div class="pull-right">
                    <a href="dang-xuat.php" class="btn btn-default btn-flat">
                    Sign out</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
              <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
            </li>
          </ul>
        </div>
      </nav>
    </header>