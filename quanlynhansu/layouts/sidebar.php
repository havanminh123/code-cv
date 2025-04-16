
<?php 
    
    // get active sidebar
    if(isset($_GET['p']) && isset($_GET['a']))
    {
        $p = $_GET['p'];
        $a = $_GET['a'];
    }
?>

<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../uploads/images/<?php echo $row_acc['hinh_anh']; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>
            <?php echo $row_acc['ten']; ?> <?php echo $row_acc['ho']; ?>
          </p>
          <a href="#"><i class="fa fa-circle text-success"></i>
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
          </a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Tìm kiếm...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">CƠ SỞ DỮ LIỆU</li> -->
        <li class="<?php if($p == 'index') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>
            Overview</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if($a == 'statistic') echo 'active'; ?>"><a href="index.php?p=index&a=statistic"><i class="fa fa-circle-o"></i> Statistical</a></li>
            <li class="<?php if($a == 'nhanvien') echo 'active'; ?>"><a a href="ds-nhanvien.php?p=index&a=nhanvien"><i class="fa fa-circle-o"></i> List of employees</a></li>
            <li class="<?php if(($p == 'index') && ($a == 'taikhoan')) echo 'active'; ?>"><a href="index_taikhoan.php?p=index&a=taikhoan"><i class="fa fa-circle-o"></i> List of accounts</a></li>
          </ul>
        </li>
        <li class="<?php if($p == 'staff') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Personnel management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(($p == 'staff') && ($a == 'room')) echo 'active'; ?>"><a href="phong-ban.php?p=staff&a=room"><i class="fa fa-circle-o"></i> Departments</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'position')) echo 'active'; ?>"><a href="chuc-vu.php?p=staff&a=position"><i class="fa fa-circle-o"></i> Position</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'level')) echo 'active'; ?>"><a href="trinh-do.php?p=staff&a=level"><i class="fa fa-circle-o"></i> Level</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'specialize')) echo 'active'; ?>"><a href="chuyen-mon.php?p=staff&a=specialize"><i class="fa fa-circle-o"></i> Expertise</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'certificate')) echo 'active'; ?>"><a href="bang-cap.php?p=staff&a=certificate"><i class="fa fa-circle-o"></i> Degree</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'employee-type')) echo 'active'; ?>"><a href="loai-nhan-vien.php?p=staff&a=employee-type"><i class="fa fa-circle-o"></i> Employee type</a></li>
            <li class="<?php if(($p == 'staff') && ($a == 'add-staff')) echo 'active'; ?>"><a href="them-nhan-vien.php?p=staff&a=add-staff"><i class="fa fa-circle-o"></i> Add new employee</a></li>
            <li class="<?php if(($p == 'staff') && ($a =='list-staff')) echo 'active'; ?>"><a href="danh-sach-nhan-vien.php?p=staff&a=list-staff"><i class="fa fa-circle-o"></i> List of employees</a></li>
          </ul>
        </li>
        <li class="<?php if($p == 'salary') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-money"></i>
            <span>Salary management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(($p == 'salary') && ($a =='salary')) echo 'active'; ?>"><a href="chamcong.php?p=salary&a=salary"><i class="fa fa-circle-o"></i>Timekeeping</a></li>
            <li class="<?php if(($p == 'timekeeping') && ($a == 'records')) echo 'active'; ?>"><a href="luu_cham_cong.php?p=timekeeping&a=records"><i class="fa fa-clock-o"></i> Timekeeping Records</a></li>
            <li class="<?php if(($p == 'timekeeping') && ($a == 'records')) echo 'active'; ?>"><a href="adjusted_times.php?p=timekeeping&a=records"><i class="fa fa-clock-o"></i> manage_timekeeping</a></li>
            <li class="<?php if(($p == 'luu_gio_cong') && ($a == 'view')) echo 'active'; ?>"><a href="daily_working_hours.php?p=luu_gio_cong&a=view"><i class="fa fa-circle-o"></i> Manage Working Hours</a></li>
            <li class="<?php if(($p == 'salary') && ($a =='salary')) echo 'active'; ?>"><a href="bang-luong.php?p=salary&a=salary"><i class="fa fa-circle-o"></i> Salary spreadsheet</a></li>
            <li class="<?php if(($p == 'salary') && ($a =='calculator')) echo 'active'; ?>"><a href="tinh-luong.php?p=salary&a=calculator"><i class="fa fa-circle-o"></i> Calculate salary</a></li>
          </ul>
        </li>
        <li class="<?php if($p == 'collaborate') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>
            Work management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(($p == 'collaborate') && ($a =='add-collaborate')) echo 'active'; ?>"><a href="cong-tac.php?p=collaborate&a=add-collaborate"><i class="fa fa-circle-o"></i> Create workc</a></li>
            <li class="<?php if(($p == 'collaborate') && ($a =='list-collaborate')) echo 'active'; ?>"><a href="danh-sach-cong-tac.php?p=collaborate&a=list-collaborate"><i class="fa fa-circle-o"></i> Work listc</a></li>
          </ul>
        </li>
        <!--
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        -->
        <li class="<?php if($p == 'group') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>
            Staff group</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(($p == 'group') && ($a =='add-group')) echo 'active'; ?>"><a href="tao-nhom.php?p=group&a=add-group"><i class="fa fa-circle-o"></i> 
            Create groups</a></li>
            <li class="<?php if(($p == 'group') && ($a =='list-group')) echo 'active'; ?>"><a href="danh-sach-nhom.php?p=group&a=list-group"><i class="fa fa-circle-o"></i> Group list</a></li>
          </ul>
        </li>
        <li class="<?php if($p == 'bonus-discipline') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-star"></i> <span>Reward - Discipline</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="<?php if(($p == 'bonus-discipline') && ($a =='bonus')) echo 'active'; ?>"><a href="khen-thuong.php?p=bonus-discipline&a=bonus"><i class="fa fa-circle-o"></i>Reward</a></li>
            <li class="<?php if(($p == 'bonus-discipline') && ($a =='discipline')) echo 'active'; ?>"><a href="ky-luat.php?p=bonus-discipline&a=discipline"><i class="fa fa-circle-o"></i> Discipline</a></li>
          </ul>
        </li>
        <!--
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        -->
        <li class="<?php if($p == 'account') echo 'active'; ?> treeview">
          <a href="#">
            <i class="fa fa-user-plus"></i> <span>Account</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li class="<?php if($a == 'profile') echo 'active'; ?>"><a href="thong-tin-tai-khoan.php?p=account&a=profile"><i class="fa fa-circle-o"></i> Information Account</a></li> -->
            <li class="<?php if($a == 'add-account') echo 'active'; ?>"><a href="tao-tai-khoan.php?p=account&a=add-account"><i class="fa fa-circle-o"></i> Create an account</a></li>
            <li class="<?php if(($p == 'account') && ($a == 'list-account')) echo 'active'; ?>"><a href="ds-tai-khoan.php?p=account&a=list-account"><i class="fa fa-circle-o"></i> List of accounts</a></li>
            <!-- <li class="<?php if($a == 'changepass') echo 'active'; ?>"><a href="doi-mat-khau.php?p=account&a=changepass"><i class="fa fa-circle-o"></i> Đổi Password</a></li>
            <li><a href="dang-xuat.php"><i class="fa fa-circle-o"></i> Đăng xuất</a></li> -->
          </ul>
        </li>
        <li >
          <a href="thong-tin-tai-khoan.php?p=account&a=profile">
            <i class="fa fa-user"></i> <span>
            Account information</span>
          </a>
        </li>
        <li >
          <a href="doi-mat-khau.php?p=account&a=changepass">
            <i class="fa fa-key"></i> <span>Change password</span>
          </a>
        </li>
        <li >
          <a href="dang-xuat.php">
            <i class="fa fa-sign-out"></i> <span>
            Sign out</span>
          </a>
        </li>
        <!--
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
          -->
        </li>
        <!--
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
        -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>