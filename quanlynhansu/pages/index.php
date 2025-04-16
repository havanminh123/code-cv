<?php

// create session
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['level'])) {
	// include file
	include('../layouts/header.php');
	include('../layouts/topbar.php');
	include('../layouts/sidebar.php');

	// dem so luong nhan vien
	$nv = "SELECT count(id) as soluong FROM nhanvien";
	$resultNV = mysqli_query($conn, $nv);
	$rowNV = mysqli_fetch_array($resultNV);
	$tongNV = $rowNV['soluong'];

	// var_dump($row_acc['id']);

	// dem so luong nhan vien nghỉ việc
	$nghiViec = "SELECT count(id) as soluong FROM nhanvien WHERE trang_thai = 0";
	$resultNghiViec = mysqli_query($conn, $nghiViec);
	$rowNghiViec = mysqli_fetch_array($resultNghiViec);
	$tongNghiViec = $rowNghiViec['soluong'];

	$chuc_vu = "SELECT count(id) as soluong FROM `chuc_vu`";
	$resultchuc_vu = mysqli_query($conn, $chuc_vu);
	$rowchuc_vu = mysqli_fetch_array($resultchuc_vu);
	$tongchuc_vu = $rowchuc_vu['soluong'];

	$tong_luong_thang_nay = "SELECT SUM(thuc_lanh) AS tong_luong_thang_nay FROM luong WHERE MONTH(ngay_cham) = MONTH(CURRENT_DATE) AND YEAR(ngay_cham) = YEAR(CURRENT_DATE);";
	$resulttong_luong_thang_nay = mysqli_query($conn, $tong_luong_thang_nay);
	$rowtong_luong_thang_nay = mysqli_fetch_array($resulttong_luong_thang_nay);
	$tongtong_luong_thang_nay = number_format($rowtong_luong_thang_nay['tong_luong_thang_nay'], 0, ',', '.');

	$nv_khen_thuong = "SELECT COUNT(nhanvien_id) AS nv_khen_thuong FROM khen_thuong_ky_luat WHERE MONTH(ngay_tao) = MONTH(CURRENT_DATE) AND YEAR(ngay_tao) = YEAR(CURRENT_DATE);";
	$resultnv_khen_thuong = mysqli_query($conn, $nv_khen_thuong);
	$rownv_khen_thuong = mysqli_fetch_array($resultnv_khen_thuong);
	$tongnv_khen_thuong = $rownv_khen_thuong['nv_khen_thuong'];

	$tien_khen_thuong = "SELECT SUM(so_tien) AS tien_khen_thuong FROM khen_thuong_ky_luat WHERE MONTH(ngay_tao) = MONTH(CURRENT_DATE) AND YEAR(ngay_tao) = YEAR(CURRENT_DATE);";
	$resulttien_khen_thuong = mysqli_query($conn, $tien_khen_thuong);
	$rowtien_khen_thuong = mysqli_fetch_array($resulttien_khen_thuong);
	$tongtien_khen_thuong = number_format($rowtien_khen_thuong['tien_khen_thuong'], 0, ',', '.');

	// dem so phong ban
	$pb = "SELECT count(id) as soluong FROM phong_ban";
	$resultPB = mysqli_query($conn, $pb);
	$rowPB = mysqli_fetch_array($resultPB);
	$tongPB = $rowPB['soluong'];

	// dem so phong ban
	$tk = "SELECT count(id) as soluong FROM tai_khoan";
	$resultTK = mysqli_query($conn, $tk);
	$rowTK = mysqli_fetch_array($resultTK);
	$tongTK = $rowTK['soluong'];

	// danh sach phong ban
	$phongBan = "SELECT ma_phong_ban, ten_phong_ban, ngay_tao FROM phong_ban ORDER BY id DESC";
	$resultPhongBan = mysqli_query($conn, $phongBan);
	$arrPhongBan = array();
	while ($rowPhongBan = mysqli_fetch_array($resultPhongBan)) {
		$arrPhongBan[] = $rowPhongBan;
	}

	// danh sach chuc vu
	$chucVu = "SELECT ma_chuc_vu, ten_chuc_vu, ngay_tao FROM chuc_vu ORDER BY id DESC";
	$resultChucVu = mysqli_query($conn, $chucVu);
	$arrChucVu = array();
	while ($rowChucVu = mysqli_fetch_array($resultChucVu)) {
		$arrChucVu[] = $rowChucVu;
	}

	// danh sach luong nhan vien thang hien tai
	$thangLuongHienTai = date_format(date_create(date("Y-m-d H:i:s")), "m/Y");
	$thangHienTai = date_format(date_create(date("Y-m-d H:i:s")), "m");
	$namHienTai = date_format(date_create(date("Y-m-d H:i:s")), "Y");
	$luongThang = "SELECT ma_luong, hinh_anh, ten_nv, gioi_tinh, ngay_sinh, luong_thang, ngay_cong, thuc_lanh, trang_thai FROM luong l JOIN nhanvien nv ON l.nhanvien_id = nv.id WHERE YEAR(ngay_cham) = '$namHienTai' AND MONTH(ngay_cham) = '$thangHienTai' ORDER BY ma_luong DESC";  // Đã loại bỏ khoan_nop
	$resultLuongThang = mysqli_query($conn, $luongThang);
	$arrLuongThang = array();
	while ($rowLuongThang = mysqli_fetch_array($resultLuongThang)) {
		$arrLuongThang[] = $rowLuongThang;
	}

?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">

		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Overview
				<small>
				Human resource management software</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="index.php?p=index&a=statistic"><i class="fa fa-dashboard"></i> Overview</a></li>
				<li class="active">Statistical</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<!-- Small boxes (Stat box) -->
			<div class="row">
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $tongNV; ?></h3>

							<p>Staff</p>
						</div>
						<div class="icon">
							<i class="fa fa-user"></i>
						</div>
						<a href="danh-sach-nhan-vien.php?p=staff&a=list-staff" class="small-box-footer">
						List of employees <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3><?php echo $tongnv_khen_thuong; ?></h3>

							<p>Number of employees rewarded</p>
						</div>
						<div class="icon">
							<i class="fa fa-bank"></i>
						</div>
						<a href="khen-thuong.php?p=bonus-discipline&a=bonus" class="small-box-footer">
						List of awards <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $tongTK; ?></h3>

							<p>
							User account</p>
						</div>
						<div class="icon">
							<i class="ion ion-person-add"></i>
						</div>
						<a href="ds-tai-khoan.php?p=account&a=list-account" class="small-box-footer">List of accounts <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				<!-- ./col -->
				<div class="col-lg-3 col-xs-6">
					<!-- small box -->
					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $tongchuc_vu; ?></h3>
							<p>
							Position</p>
						</div>
						<div class="icon">
							<i class="ion ion-pie-graph"></i>
						</div>
						<a href="#" class="small-box-footer" onclick="return false;">
						List of positions <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</div>
				
			</div>

			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Departments
							</span>
							<span class="info-box-number"><?php echo $tongPB; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Money for rewards</span>
							<span class="info-box-number"><?php echo $tongtien_khen_thuong; ?> đ</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->

				<!-- fix for small devices only -->
				<div class="clearfix visible-sm-block"></div>

				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Salary paid in the month</span>
							<span class="info-box-number"><?php echo ($tongtong_luong_thang_nay ?? 0); ?> đ</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="info-box">
						<span class="info-box-icon bg-red"><i class="fa fa-google-plus"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">
							Employee quits</span>
							<span class="info-box-number"><?php echo $tongNghiViec; ?></span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
			<!-- Main row -->
			<div class="row">
				<div class="col-lg-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">List of departments</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>Room Code</th>
											<th>
											Room name</th>
											<th>Creation date</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrPhongBan as $pb) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $pb['ma_phong_ban']; ?></td>
												<td><?php echo $pb['ten_phong_ban']; ?></td>
												<td><?php echo $pb['ngay_tao']; ?></td>
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
				<!-- col-lg-6 -->
				<div class="col-lg-6">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">
							List of positions</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example3" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>
											Position code</th>
											<th>
											Position name</th>
											<th>Creation date</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrChucVu as $cv) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $cv['ma_chuc_vu']; ?></td>
												<td><?php echo $cv['ten_chuc_vu']; ?></td>
												<td><?php echo $cv['ngay_tao']; ?></td>
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
				<!-- col-lg-6 -->
				<div class="col-lg-12">
					<div class="box">
						<div class="box-header">
							<h3 class="box-title">List of monthly salaries: <?php echo $thangLuongHienTai; ?></h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example4" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>STT</th>
											<th>
											Employee code</th>
											<th>Image</th>
											<th>Name</th>
											<th>Gender</th>
											<th>
											 salary</th>
											<th>
											Work day</th>
											<th>
											Payment</th>
											<th>Truly cool</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$count = 1;
										foreach ($arrLuongThang as $lt) {
										?>
											<tr>
												<td><?php echo $count; ?></td>
												<td><?php echo $lt['ma_luong']; ?></td>
												<td><img src="../uploads/staffs/<?php echo $lt['hinh_anh']; ?>" width="80"></td>
												<td><?php echo $lt['ten_nv']; ?></td>
												<td>
													<?php
													if ($lt['gioi_tinh'] == 1) {
														echo "Nam";
													} else {
														echo "Nữ";
													}
													?>
												</td>
												<td><?php echo number_format($lt['luong_thang']) . "vnđ"; ?></td>
												<td><?php echo $lt['ngay_cong']; ?></td>
												<td><?php echo "<span style='color: red; font-weight: bold;'>" . number_format($lt['khoan_nop']) . "vnđ </span>"; ?></td>
												<td><?php echo "<span style='color: blue; font-weight: bold;'>" . number_format($lt['thuc_lanh']) . "vnđ </span>"; ?></td>
												<td>
													<?php
													if ($lt['trang_thai'] == 1) {
														echo '<span class="badge bg-blue"> Working </span>';
													} else {
														echo '<span class="badge bg-red"> Retired </span>';
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
				<!-- col-lg-12 -->
			</div>
			<!-- /.row (main row) -->
		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->
<?php
	// include
	include('../layouts/footer.php');
} else {
	// go to pages login
	header('Location: dang-nhap.php');
}

?>