<?php
session_start();
include '../dbConfig.php';
if (empty($_SESSION['is_logged_in'])){
header("Location: ../login.php");
}
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
$notif = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM nt WHERE n = 'all'" ));
if ($login_data['_user_type'] != "admin" && $login_data['_user_type'] != "reseller") {
	header("Location: ../login.php");
}
if ($login_data['_user_type'] != "admin"){
header("Location: index.php");
}
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_h_status = 'online'");
$server_data = mysqli_fetch_assoc($fetch_server);
$online = 'online';
if (isset($_POST['password'])){
if (empty($_POST['username'])){
$_SESSION['inc'] = "<script>swal('Error', 'Username Field Is Empty', 'error');</script>";
} else if (empty($_POST['password'])){
$_SESSION['inc'] = "<script>swal('Error', 'Password Field Is Empty', 'error');</script>";
} else if (empty($_POST['token'])){
$_SESSION['inc'] = "<script>swal('Error', 'Token Field Is Empty', 'error');</script>";
} else if (empty($_POST['money'])){
$_SESSION['inc'] = "<script>swal('Error', 'Money Field Is Empty', 'error');</script>";
} else if (empty($_POST['resets'])){
$_SESSION['inc'] = "<script>swal('Error', 'Resets Field Is Empty', 'error');</script>";
}
date_default_timezone_set('Asia/Dhaka');
$username = $_POST['username'];
$password = $_POST['password'];
$token = $_POST['token'];
$verify = 'verified';
$status = 'active';
$reg_date = date("Y/m/d h:i");
$exp_date = Date('Y-m-d h:i', strtotime('+999 day'));
$curr_time = date("Y/m/d h:i"); 
$user_role = 'reseller';
$money = $_POST['money'];
$registrar = $_POST['registrar'];
$version = 'injector';
$p_status = 'paid';
$resets = '10';
$is_verified = '1';
$verifycode = bin2hex(random_bytes(32));
    $check_exists = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _token = '$token'"));
$check_if_exists = mysqli_num_rows(mysqli_query($con, "SELECT * FROM panel WHERE _username = '$username'"));
		if ($check_if_exists > 0) {
		$_SESSION['inc'] = "<script>swal('Error', 'Failed To Add User Exception : User Already Exists', 'error');</script>";
    } else
		if ($check_exists > 0) {
		$_SESSION['inc'] = "<script>swal('Error', 'Failed To Add User Exception : Token Already Exists', 'error');</script>";
    }
      else {
 if ($login_data['_user_type'] == "admin"){
	$insert = mysqli_query($con, "INSERT INTO `panel` (`_username`, `_password`, `_token`, `_v_status`, `_status`, `_reg_date`, `_exp_date`, `_curr_time`, `_uid`, `_user_type`, `_registrar`, `_version`, `_p_status`, `_credits`, `_resets`, `_r_resets`, `verification_code`, `is_verified`) VALUES ('$username', '$password', '$token', '$verify', 'active', '$reg_date', '$exp_date', '$reg_date', NULL, '$user_role', '$registrar', '$version', 'paid', '$money', '0', '$resets', '$verifycode', '$is_verified');");
	if ($insert){
  $_SESSION['inc']= "<script>swal({title:'Success',text:'User Has Been Added Successfully',type:'success'});</script>";
  header("Location: " . BASE_URL . "info-reseller.php?id=$verifycode");
					exit();
	} else {
	$_SESSION['inc'] = "<script>swal('Error', 'Failed To Add User Exception : 408', 'error');</script>";
	}
	} else {
	$_SESSION['inc'] = "<script>swal('Error', 'Failed To Add User Exception : 405', 'error');</script>";
	}
	}
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Add Reseller - Blue Triple 4</title>
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
	<link rel="stylesheet" type="text/css" href="styles/core.css" />
<link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />
<!-- Core CSS -->
<link rel="stylesheet" href="../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../assets/css/demo.css" />
<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
<link rel="stylesheet" type="text/css" href="../styles/sweetalert.min.css"/>
  <script src="../scripts/sweetalert.min.js"></script>
<!-- Vendor Styles -->
<link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css">
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


        </nav>
  <!-- / Navbar -->
            <!-- END: Navbar-->


      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
                  <div class="container-xxl flex-grow-1 container-p-y">


<div class="card">
  <h5 class="card-header">Add Reseller</h5>
  	<?php if (!empty($_SESSION['inc'])) { ?>
<?php echo $_SESSION['inc'];
unset($_SESSION['inc']);?>
<?php } ?>
  <!--Search Form -->
  <div class="card-body">
    <form class="dt_adv_search" method="POST">
      <div class="row">
        <div class="col-12">
          <div class="row g-3">
            <div class="position-relative form-group">
              <label class="form-label">Username</label>
              <input class="form-control dt-input dt-full-name" type="text" name="username" placeholder="Enter A Username" required />
            </div>
            <div class="position-relative form-group">
              <label class="form-label">Password</label>
              <input class="form-control dt-input" placeholder="Enter A Password" name="password" type="text" required />
            </div>
                        <div class="position-relative form-group">
		<label class="form-label">Token</label>
		       <div class="input-group input-group-merge">
			<input readonly class="form-control dt-input" placeholder="Generate A Token" id="token" name="token" type="text" required />
									<span class="input-group-text cursor-pointer"><button type="button" id="btn" onclick="getToken()" class="btn btn-outline-success mr-3">
									                  Generate</button></span>
									</div>
								

	</div>
            <div class="position-relative form-group">
              <label class="form-label">Reseller</label>
              <input type="text" readonly class="form-control dt-input" name="registrar" type="text" placeholder="" value="<?php echo $login_data['_username'];?>">
            </div>
                        <div class="position-relative form-group">
        <div class="mb-3">
          <label class="form-label" for="user-role">User Type</label>
	<select class="form-select" name="">
	                       <option value="">Reseller</option>
	

	</select>
        </div>

            <div class="position-relative form-group">
              <label class="form-label">Credits</label>
              <input class="form-control dt-input" name="money" type="number" placeholder="" value="0" required />
            </div>
 

	<hr>
	<div align="right">
<button type="submit" class="btn btn-outline-primary"><i class="dw dw-upload"></i> Submit</button>
</form></div>
          </div>
        </div>
      </div>
    </form>
  </div>

<!--/ Responsive Datatable -->

            <!-- pricingModal -->
                        <!--/ pricingModal -->

          </div>
          <!-- / Content -->


          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

        <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
            <!-- pricingModal -->
                        <!--/ pricingModal -->
          </div>
          <!-- / Content -->

          <div class="content-backdrop fade"></div>
        </div>
        <!--/ Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>
        <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
  </div>
  <!-- / Layout wrapper -->
    <!--/ Layout Content -->
 
  </div>
  	<script>
			function getToken(){
    const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'

    let tokenLength = 6;
    let token =  "";

    for (let i=0; i<tokenLength; i++){
        let randomNumber = Math.floor(Math.random() * chars.length);
        token += chars.substring(randomNumber,randomNumber+1);
    }
    document.getElementById('token').value = token;
}
		</script>
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
