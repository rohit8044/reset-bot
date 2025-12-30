<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require ("PHPMailer/PHPMailer.php");
require ("PHPMailer/SMTP.php");
require ("PHPMailer/Exception.php");
include 'dbConfig.php';
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_h_status = 'online'");
	$server_data = mysqli_fetch_assoc($fetch_server);
	$online = 'online';
 	unset($_SESSION['is_logged_in']);
if (isset($_POST['value_1'])) {
	$value_1 = $_POST['value_1'];
	$value_2 = $_POST['value_2'];
	$value_3 = $_POST['value_3'];
    $value_4 = $_POST['token'];
    $value_0 = $_POST['value_0'];
 //post
 //functions
	   if($server_data['server_status'] == $online){
	   if(empty($value_1)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Username Is Empty', 'warning');</script>";
	   }else if(empty($value_2)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Password Is Empty', 'warning');</script>";
	   }else if(empty($value_3)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Confirm Password Is Empty', 'warning');</script>";
	   }else if(empty($value_4)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Token Is Empty', 'warning');</script>";
	   }else if(empty($value_0)){
	   $_SESSION['inc'] = "<script>swal('Error', 'Email Is Empty', 'warning');</script>";
	   }else{
	   //function
	   if ($value_2 == $value_3){
	   $value_pass = $value_3;
	   $check_email_ = mysqli_query($con, "SELECT * FROM panel WHERE email = '".$value_0."'");
	$check_email = mysqli_num_rows($check_email_);
	      $check_token_ = mysqli_query($con, "SELECT * FROM panel WHERE _token = '".$value_4."'");
	$check_username = mysqli_num_rows($check_token_);
	$check_username_ = mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$value_1."'");
	$check_username = mysqli_num_rows($check_username_);
	if ($check_token == 0) {
	if ($check_email == 0) {
	if ($check_username == 0) {
	date_default_timezone_set('Asia/Dhaka');
	$curr_date = date("Y/m/d h:i:s");
	$value_exp = date('Y-m-d h:i:s', strtotime('+7 day'));
	$verified = 'verified';
	$active = 'active';
	$member = 'member';
	$free = 'free';
	$unpaid = 'unpaid';
	$zero = '0';
	$five = '5';
	$NULL = NULL;
	$verifycode = bin2hex(random_bytes(32));
	   $fetch = mysqli_query($con, "INSERT INTO `panel` (`_username`, `_password`, `_token`, `_v_status`, `_status`, `_reg_date`, `_exp_date`, `_curr_time`, `_uid`, `_user_type`, `_registrar`, `_version`, `_p_status`, `_credits`, `_resets`, `_r_resets`, `email`, `verification_code`, `is_verified`) VALUES ('$value_1', '$value_2', '$value_4', 'verified', 'active', '$curr_date', '$value_exp', '$curr_date', NULL, 'member', 'BlueTriple4', 'injector', 'unpaid', '0', '0', '5', '$value_0', '$verifycode', '0');");
	   try {
		$mail = new PHPMailer(true);

		// SMTP configuration
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'bluetriple4.ultra@gmail.com'; // Enter your Gmail address
		$mail->Password = 'tbqsfuhowgpqqtva'; // Enter your Gmail password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
		$mail->Port = 465;

		// Sender and recipient settings
		$mail->setFrom('bluetriple4.ultra@gmail.com', 'Blue Triple 4'); // Enter your name and email address
		$mail->addAddress($value_0, $value_1); // Send the email to
		// Email content
		$mail->isHTML(true);
		$mail->Subject = 'Email Verification';
		$mail->Body = 'Thank you for registering! Please click the following link to verify your email address:<br><br><a href="https://bluetriple4.xyz/verify.php?v_code=' . $verifycode . '">Verify Email</a>';

		$mail->send();

	   $_SESSION['inc']= "<script>setTimeout(function(){swal({title:'Success',text:'Registration Success, Please Verify Your Email ',type:'success'},function(){window.location = 'login.php';});},100);</script>";
		} catch (Exception $e) {
		// Display error message
		$_SESSION['acao'] = "<script>setTimeout(function(){swal({title:'Error',text:'Registration Failed',type:'error'},function(){window.location = 'login.php';});},100);</script>";
	  }
	   } else {
	   $_SESSION['inc'] = "<script>swal('Error', 'Username Already Exists', 'error');</script>";
	   }
	   } else {
	   $_SESSION['inc'] = "<script>swal('Error', 'Email Already Exists', 'error');</script>";
	   }
	      } else {
	   $_SESSION['inc'] = "<script>swal('Error', 'Token Already Exists', 'error');</script>";
	   }
	   } else {
	     $_SESSION['inc'] = "<script>swal('Error', 'Password Mismatch', 'error');</script>";
	 

	 
	   }
       //function end	   
	   }
	   }else{
	   $_SESSION['inc'] = "<script>swal('Error', 'Server Is Offline', 'error');</script>";
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
                  <label for="email" class="form-label">Username</label>
                  <input
                    class="form-control"
                    type="text"
										name="value_1"
                    placeholder="Enter A Username"
                    autofocus
                  required />
                </div>
                            <div class="position-relative form-group">
		<label class="form-label">Token</label>
		       <div class="input-group input-group-merge">
			<input readonly class="form-control dt-input" placeholder="Generate A Token" id="token" name="token" type="text"required />
									<span class="input-group-text cursor-pointer"><button type="button" id="btn" onclick="getToken()" class="btn btn-outline-success mr-3">
									                  Generate</button></span>
									</div>
								
		</div>
	
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input
                    
                    class="form-control"
                    type="email"
										name="value_0" id="email"
                    placeholder="Enter A Email"
                    autofocus
                  required />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>

                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      
                      
                      class="form-control"
                      type="password" id="password"
										name="value_2"
                      placeholder="Enter A Password"
                      aria-describedby="password"
                    required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Confirm Password</label>

                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      
                      
                      class="form-control"
                      type="password" 
                      name="value_3" id="password2"
                      placeholder="Enter Confirm Password"
                      aria-describedby="password"
                    required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                  <div class="mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> I accept Terms And condition.</label>
                  </div>
                </div>
                
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit" name="Submit">Register</button>
                </div>
              </form>

              <p class="text-center">
                <span>Already a member?</span>
                <a href="login.php">
                  <span>Login</span>
                </a>
              </p>
            </div>
          </div>
          <!-- /Register -->
        </div>
      </div>
    </div>

    <!-- / Content -->

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
