<?php
session_start();
include '../dbConfig.php';
if (empty($_SESSION['is_logged_in'])){
header("Location: ../login.php");
}
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
$notif = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM nt WHERE n = 'all'" ));
if ($login_data['_user_type'] != "owner") {
	header("Location: ../login.php");
	exit();
}
date_default_timezone_set('Asia/Dhaka');
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_h_status = 'online'");
$server_data = mysqli_fetch_assoc($fetch_server);
$online = 'online';
if (isset($_POST['delete-all'])){
$delete = mysqli_query($con, "DELETE FROM panel WHERE _registrar = '".$_SESSION['is_logged_in']."' AND _user_type = 'member' AND _p_status = 'paid'");
if ($delete){
$_SESSION['inc'] = "<script>swal('Success', 'All Users From Your Panel Has Been Deleted', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Your Panel Does Not Have Any Users', 'error');</script>";
}
}
if (isset($_POST['delete-al'])){
$delete = mysqli_query($con, "DELETE FROM panel WHERE _registrar = '".$_SESSION['is_logged_in']."' AND _user_type = 'member' AND _version = 'free'");
if ($delete){
$_SESSION['inc'] = "<script>swal('Success', 'All Users From Your Panel Has Been Deleted', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Your Panel Does Not Have Any Users', 'error');</script>";
}
}
if (isset($_POST['reset-all'])){
$reset = mysqli_query($con, "UPDATE panel SET _uid = NULL WHERE _registrar = '".$_SESSION['is_logged_in']."' AND _user_type = 'member'");
if ($reset){
$_SESSION['inc'] = "<script>swal('Success', 'All Users From Your Panel Has Been Reseted', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Your Panel Does Not Have Any Users', 'error');</script>";
}
}
if (isset($_GET['delete'])){
$delete = $_GET['delete'];
$check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _username = '$delete'"));
if ($check_user == 1){
$delete_user = mysqli_query($con, "DELETE FROM panel WHERE _username = '$delete'");
if ($delete_user){
$_SESSION['inc'] = "<script>swal('Success', 'Account Has Been Deleted', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Run Query', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Invalid Account', 'error');</script>";
}
}
if (isset($_GET['reset'])){
$reset = $_GET['reset'];
$uid = $_GET['uid'];
$check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _username = '$reset'"));
if ($check_user == 1){
$_user_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$reset."'"));
if ($_user_data['_uid'] != NULL){
$reset_user = mysqli_query($con, "UPDATE panel SET _uid = NULL WHERE _username = '$reset'");
if ($reset_user){
$_SESSION['inc'] = "<script>swal('Success', 'Account Has Been Reseted', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'This Account Is Not Connected To Any Device', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'This User Has No Connected Devices', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Invalid Account', 'error');</script>";
}
}
if (isset($_GET['verify'])){
$verify = $_GET['verify'];
$verify_user = mysqli_query($con, "UPDATE panel SET _v_status = 'verified' WHERE _username = '$verify'");
if ($verify_user){
$_SESSION['inc'] = "<script>swal('Success', 'Account Has Been Verified', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Invalid Account', 'error');</script>";
}
}
if (isset($_POST['add-days'])){
$add_days = mysqli_query($con,"UPDATE panel SET `_exp_date` = DATE_ADD(`_exp_date` , INTERVAL 2 DAY) WHERE `_exp_date` > CURDATE();");
if ($add_days){
$_SESSION['inc'] = "<script>swal('Success', '2 Days Has Been Added To All Users', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Run The Query', 'error');</script>";
}
}


if (isset($_GET['ban'])){
$ban = $_GET['ban'];
$check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _username = '$ban'"));
if ($check_user == 1){
$delete_user = mysqli_query($con, "UPDATE panel SET `_status` = 'banned' WHERE _username = '$ban'");
if ($delete_user){
$_SESSION['inc'] = "<script>swal('Success', 'Reseller Has Been Banned Successfully', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Run Query', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Invalid Account', 'error');</script>";
}
}



if (isset($_GET['unban'])){
$unban = $_GET['unban'];
$check_user = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _username = '$unban'"));
if ($check_user == 1){
$delete_user = mysqli_query($con, "UPDATE panel SET `_status` = 'active' WHERE _username = '$unban'");
if ($delete_user){
$_SESSION['inc'] = "<script>swal('Success', 'Reseller Has Been UnBanned Successfully', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Run Query', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Invalid Account', 'error');</script>";
}
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Manage Resellers - Blue Triple 4</title>
	<link rel="canonical" href="" />
  
  <!-- Canonical SEO -->
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
      <!-- Google Tag Manager (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <script>
    (function (w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-5DDHKGP');
  </script>
  <!-- End Google Tag Manager -->
  <!-- Include Styles -->
  <!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
<link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />
<!-- Core CSS -->
<link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../assets/css/demo.css" />
<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
<!-- Vendor Styles -->
<link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css">

<link rel="stylesheet" type="text/css" href="../styles/sweetalert.min.css"/>
  <script src="../scripts/sweetalert.min.js"></script>
  

<!-- Page Styles -->
  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- laravel style -->
<script src="../assets/vendor/js/helpers.js"></script>
<!-- beautify ignore:start -->
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="../assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
  <script>
    window.templateCustomizer = new TemplateCustomizer({
      cssPath: '',
      themesPath: '',
      defaultShowDropdownOnHover: true, // true/false (for horizontal layout only)
      displayCustomizer: true,
      lang: 'en',
      pathResolver: function(path) {
        var resolvedPaths = {
          // Core stylesheets
                      'core.css': '../assets/vendor/css/rtl/core.css?id=30f6a84d4dc0a86dc216aa680dd667cd',
            'core-dark.css': '../assets/vendor/css/rtl/core-dark.css?id=219e84e3d1fac8566672731c35d62d6e',
          // Themes
                      'theme-default.css': '../assets/vendor/css/rtl/theme-default.css?id=2f917d58c88e2f7f1b632fe86d6b21e6',
            'theme-default-dark.css':
            '../assets/vendor/css/rtl/theme-default-dark.css?id=4a7fa3486f98ff5ea4cc844dea4b56b7',
                      'theme-bordered.css': '../assets/vendor/css/rtl/theme-bordered.css?id=bca67194f9d192b8e7d7e8b139dfcae2',
            'theme-bordered-dark.css':
            '../assets/vendor/css/rtl/theme-bordered-dark.css?id=e4ff4792d65f77e1d21e221534d35fe1',
                      'theme-semi-dark.css': '../assets/vendor/css/rtl/theme-semi-dark.css?id=62342f847731afa78c9595579da0e81d',
            'theme-semi-dark-dark.css':
            '../assets/vendor/css/rtl/theme-semi-dark-dark.css?id=d9b8b306e76164f732f816809db5e358',
                  }
        return resolvedPaths[path] || path;
      },
      'controls': ["rtl","style","layoutType","showDropdownOnHover","layoutNavbarFixed","layoutFooterFixed","themes"],
    });
  </script>
  <!-- beautify ignore:end -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async="async" src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', 'GA_MEASUREMENT_ID');
</script>
</head>
<body>
      <!-- Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
	<?php include('header.php'); ?>

          <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
                  <div class="container-xxl flex-grow-1 container-p-y">
            

<!-- Ajax Sourced Server-side -->
<div class="card">
  <h5 class="card-header">Manage Resellers</h5>
	<?php if (!empty($_SESSION['inc'])) { ?>
<?php echo $_SESSION['inc'];
unset($_SESSION['inc']);?>
<?php } ?>
  <div class="card-datatable text-nowrap">
  <div class="table-responsive">
    <table class="datatables-ajax table table-bordered">
<thead>
								<tr>
									<th >Username</th>
									<th>Password</th><th>Role</th>
									<th>Token</th>
									<th>Verified?</th>
									<th>Status</th><th>Reg Date</th><th>Exp Date</th><th>Devices</th><th>Resets</th><th>Seller</th><th>Version</th><th>Payment</th><th>Credits</th><th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								 $query_panel = mysqli_query($con,"SELECT * FROM panel WHERE `_user_type` = 'reseller' ORDER BY _user_id ASC");
									while ($row = mysqli_fetch_assoc($query_panel)) {
									?>							<tr>
									<td ><?php echo $row['_username'];?>
									</td>
									<td><?php echo $row['_password'];?></td><td><span class="text-capitalize pt-1" style="border: 1px solid; border-color: #6a6aee; border-radius: 40px; color: #6a6aee; padding: 2px"><i class="dw dw-checked pt-2" style="margin-top: 6px;"></i> <?php echo $row['_user_type'];?></span></td>
									<td><?php echo $row['_token'];?></td>
									<td><?php if ($row['_v_status'] == "verified"){
		echo '<span >Yes</span>';
		} else {
		echo '<span >No</span>';
		}
		?></td>
									<td>
										<span
											class=" badge-pill text-capitalize"
										
											><?php echo $row['_status'];?></span
										>
									</td>
									<td><?php echo $row['_reg_date'];?>
									</td><td><?php echo $row['_exp_date'];?></td>
								<td><?php 
										if($row['_uid'] == NULL){
											echo "0/1"; 
										}else{
											echo "1/1";
										}
										?></td><td><?php echo ''.$row['_resets'].'/'.$row['_r_resets'].''; ?></td><td><?php echo $row['_registrar']; ?></td><td><?php echo $row['_version']; ?></td><td><?php echo $row['_p_status']; ?></td><td>$<?php echo $row['_credits']; ?></td><td>
											<?php if ($row['_status'] == "banned") { ?>
											<a href="manage-resellers.php?unban=<?php echo $row['_username'];?>"><button type="button" class="btn btn-primary ml-1 text-xs"  style="margin: 0px 0px 0px 2px; background-color:#04d108; border-color:#04d108"><i class="fas fa-play"></i></button></a>
											
											<?php } ?>
					<?php if ($row['_status'] == "active") { ?>
			<a href="manage-resellers.php?ban=<?php echo $row['_username'];?>"><button type="button" class="btn btn-primary ml-1 text-xs" style="margin: 0px 0px 0px 2px; background-color:#ffaa00; border-color:#ffaa00"><i class="fas fa-ban"></i></button></a>
										<?php } ?>
										<a href="manage-resellers.php?delete=<?php echo $row['_username'];?>"><button type="button" class="btn btn-primary ml-1 text-xs" onClick="return confirm('Do you really want to Delete?');" style="margin: 0px 0px 0px 2px; background-color:#FF005C; border-color:#FF005C"><i class="fas fa-circle-xmark"></i></button></a>
										
									<a href="add-credits.php?account=<?php echo $row['_username'];?>"><button type="button" class="btn btn-primary ml-1 text-xs" style="margin: 0px 0px 0px 2px; background-color:#04d108; border-color:#04d108"><i class="fas fa-money-check-alt"></i></button></a>
										
										<a 
<?php if ($row['_v_status'] == "not-verified"){?><a href="manage-resellers.php?verify=<?php echo $row['_username'];?>" class="btn btn-success btn-sm mr-1" style="border-radius: 4px"><i class="dw dw-checked"></i></a><?php } ?></td>
								</tr>
								<?php } ?>																</tbody>
										
							
						</table>
					</div>
				</div>
				</div>
				</div>
				

				
<!--/ Ajax Sourced Server-side -->



            <!-- pricingModal -->
                        <!--/ pricingModal -->

          </div>
          <!-- / Content -->

          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->

  <!-- Include Scripts -->
  <!-- BEGIN: Vendor JS-->
<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="../assets/js/main.js"></script>
<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
<script src="../assets/js/dashboards-analytics.js"></script>
<!-- END: Page JS-->
</body>
</html>
