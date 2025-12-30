<?php
session_start();
include 'dbConfig.php';
if (!empty($_SESSION['is_logged_in'])){
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
if ($login_data['_user_type'] == "member"){
header("Location: user-panel/");
} else if ($login_data['_user_type'] == "reseller"){
header("Location: reseller-panel/");
} else if ($login_data['_user_type'] == "admin"){
header("Location: admin-panel/");
} else if ($login_data['_user_type'] == "owner"){
header("Location: owner-panel/");
}
} else {
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_status = 'online'");
	$server_data = mysqli_fetch_assoc($fetch_server);
	$online = 'online';
 	unset($_SESSION['is_logged_in']);
if (isset($_POST['value_1'])) {
	$value_1 = $_POST['value_1'];
	   if(empty($value_1)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Key Is Empty', 'warning');</script>";
	   }else{
	 $fetch = mysqli_query($con, "SELECT * FROM panel WHERE _token = '".$value_1."'");
	$check = mysqli_num_rows($fetch);
	if ($check == 1) {
	$data = mysqli_fetch_assoc($fetch);
	if ($data['is_verified'] == 1 ){
	if ($data['_v_status'] == "verified"){
	if ($data['_status'] == "active"){
	$username = $data['_username'];
	$_SESSION['is_logged_in'] = $username;
		$update_ts = $server_data['total_sessions'] + 1;
	$update_query = mysqli_query($con, "UPDATE server SET total_sessions = $update_ts ");
	if ($data['_user_type'] == "reseller"){
			 $_SESSION['inc']= "<script>setTimeout(function(){swal({title:'Success',text:'Login Success',type:'success'},function(){window.location = 'reseller-panel/';});},100);</script>";
	  
		} else if ($data['_user_type'] == "admin") {
		 $_SESSION['inc']= "<script>setTimeout(function(){swal({title:'Success',text:'Login Success',type:'success'},function(){window.location = 'admin-panel/';});},100);</script>";
	        } else if ($data['_user_type'] == "member") {
            $_SESSION['inc']= "<script>setTimeout(function(){swal({title:'Success',text:'Login Success',type:'success'},function(){window.location = 'user-panel/';});},100);</script>";
		} else if ($data['_user_type'] == "owner") {
            $_SESSION['inc']= "<script>setTimeout(function(){swal({title:'Success',text:'Login Success',type:'success'},function(){window.location = 'owner-panel/';});},100);</script>";
	  
		} else {
			$_SESSION['acao'] = "You don't have permission to access this site";
			session_destroy();
		}
		} else {
		$_SESSION['inc'] = "<script>swal('Error', 'Your Account Is Banned', 'warning');</script>";
		}
  }else{
  $_SESSION['inc'] = "<script>swal('Error', 'Your Account Isn't Verified Yet', 'warning');</script>";
  }
    }else{
  $_SESSION['inc'] = "<script>swal('Error', 'Your Email Is Not Verified', 'warning');</script>";
  }
	}else{
		$_SESSION['inc'] = "<script>swal('Error', 'Entered Key Is Incorrect', 'error');</script>";
	}
	}
}
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Dashboard - Blue Triple 4</title>
	<link rel="canonical" href="" />
  
  <!-- Canonical SEO -->
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
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
<link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
<link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
<link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />

<link rel="stylesheet" type="text/css" href="styles/sweetalert.min.css"/>
  <script src="scripts/sweetalert.min.js"></script>
  


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>

<!-- Page Styles -->
  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- laravel style -->
<script src="assets/vendor/js/helpers.js"></script>
<!-- beautify ignore:start -->
  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 section -->
  <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
  <script src="assets/vendor/js/template-customizer.js"></script>
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="assets/js/config.js"></script>
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
                      'core.css': 'assets/vendor/css/rtl/core.css?id=30f6a84d4dc0a86dc216aa680dd667cd',
            'core-dark.css': 'assets/vendor/css/rtl/core-dark.css?id=219e84e3d1fac8566672731c35d62d6e',
          // Themes
                      'theme-default.css': 'assets/vendor/css/rtl/theme-default.css?id=2f917d58c88e2f7f1b632fe86d6b21e6',
            'theme-default-dark.css':
            'assets/vendor/css/rtl/theme-default-dark.css?id=4a7fa3486f98ff5ea4cc844dea4b56b7',
                      'theme-bordered.css': 'assets/vendor/css/rtl/theme-bordered.css?id=bca67194f9d192b8e7d7e8b139dfcae2',
            'theme-bordered-dark.css':
            'assets/vendor/css/rtl/theme-bordered-dark.css?id=e4ff4792d65f77e1d21e221534d35fe1',
                      'theme-semi-dark.css': 'assets/vendor/css/rtl/theme-semi-dark.css?id=62342f847731afa78c9595579da0e81d',
            'theme-semi-dark-dark.css':
            'assets/vendor/css/rtl/theme-semi-dark-dark.css?id=d9b8b306e76164f732f816809db5e358',
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
    <!-- Content -->
	<?php if (!empty($_SESSION['inc'])) { ?>
<?php echo $_SESSION['inc'];
unset($_SESSION['inc']);?>
<?php } ?>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          <div class="card">
            <div class="card-body">

    <form class="dt_adv_search" method="POST">
      



                  <h1 class="text-center" style="font-weight: bold; margin: 10px;">Blue<span style="font-weight: bold; margin: 10px;">Triple 4</span></h1>
             
            
              
                           <p class="mb-4"> </p>
             


                <div class="mb-3">
                  <label for="username" class="form-label">Key</label>
                  <input
                    type="text"
                    class="form-control"
name="value_1"
                    placeholder="Enter Your Key"
                    autofocus
                  required />
                </div>
                <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit" name="Submit">Login</button>
                </div>
              </form>
              <p class="text-center">
                <span>Login Normally</span>
                <a href="login.php">
                  <span>Login</span>
                </a>
              </p>
              <p class="text-center">
                <span>Not yet a member?</span>
                <a href="register.php">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/libs/hammer/hammer.js"></script>
<script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="assets/vendor/js/menu.js"></script>
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="assets/js/main.js"></script>
<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
<script src="assets/js/dashboards-analytics.js"></script>
<!-- END: Page JS-->
</body>
</html>
