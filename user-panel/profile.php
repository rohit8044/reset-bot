<?php
session_start();
include '../dbConfig.php';
if (empty($_SESSION['is_logged_in'])){
header("Location: ../login.php");
}
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
$notif = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM nt WHERE n = 'all'" ));
if ($login_data['_user_type'] != "admin" && $login_data['_user_type'] != "member" && $login_data['_user_type'] != "reseller") {
	header("Location: ../login.php");
	exit();
}
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_h_status = 'online'");
$server_data = mysqli_fetch_assoc($fetch_server);
$online = 'online';
if (isset($_POST['value_2'])){
$old_pass = $_POST['value_1'];
$new_pass = $_POST['value_2'];
$cn_pass = $_POST['value_3'];
if (empty($new_pass)){
$_SESSION['inc'] = "<script>swal('Error', 'New Password Field Is Empty', 'error');</script>";
} else if (empty($cn_pass)){
$_SESSION['inc'] = "<script>swal('Error', 'Confirm New Password Field Is Empty', 'error');</script>";
} else {
if ($new_pass == $old_pass){
$_SESSION['inc'] = "<script>swal('Error', 'New Password Should Not Be Equal To Your Old Password', 'error');</script>";
} else if ($new_pass == $cn_pass){
$update_query = mysqli_query($con, "UPDATE panel SET _password = '$cn_pass' WHERE _username = '".$_SESSION['is_logged_in']."'");
if ($update_query){
$_SESSION['inc'] = "<script>swal('Success', 'Your Password Has Been Changed Successfully', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Change Your Password', 'error');</script>";
}
} else {
$_SESSION['inc'] = "<script>swal('Error', 'New Password Should Be Equal To Confirm Password', 'error');</script>";
}
}
}
if (isset($_POST['reset'])){
if ($login_data['_uid'] != NULL){
if ($login_data['_r_resets'] < $login_data['_resets']){
$_SESSION['inc'] = "<script>swal('Failed', 'Your Reset Limit Has Been Exceeded', 'error');</script>";
} else {
$reset_query = mysqli_query($con, "UPDATE panel SET _uid = NULL WHERE _username = '".$_SESSION['is_logged_in']."'");
if ($reset_query){
$inc_resets = $login_data['_resets'] + 1;
$reset_query = mysqli_query($con, "UPDATE panel SET _resets = '$inc_resets' WHERE _username = '".$_SESSION['is_logged_in']."'");
$_SESSION['inc'] = "<script>swal('Success', 'Your Account Has Been Reseted Successfully', 'success');</script>";
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Failed To Reset Your Account', 'error');</script>";
}
}
} else {
$_SESSION['inc'] = "<script>swal('Failed', 'Your Account Is Not Connected To Any Device', 'error');</script>";
}
}


if (isset($_POST['change'])){
$output_dir = "../assets/img/avatars/";

  if(isset($_FILES["profile"]))
  {
      $ret = array();
      $error =$_FILES["profile"]["error"];
      if(!is_array($_FILES["profile"]["name"]))
      {   
          $apkName = $_FILES["profile"]["name"];
          $apkExtension = pathinfo($apkName, PATHINFO_EXTENSION);
          $allowedExtensions = ['png'];
          $apkPath = $output_dir.$apkName ;
          if(!in_array($apkExtension, $allowedExtensions)) {
            $_SESSION['inc']= "<script>swal({title:'Warning',text:'Only Png Uploads Here !',type:'warning'});</script>";
            header("Refresh:0; url=profile.php");
            exit();
        }
          $uploaded = move_uploaded_file($_FILES["profile"]["tmp_name"],$apkPath);
          if(!$uploaded){
              echo 'Error! Failed to Upload the png ';exit;
          }
          $query = "UPDATE panel SET profile = '{$apkPath}' WHERE _username = '".$_SESSION['is_logged_in']."'";
          $result = mysqli_query($con, $query);
          if(!$result) {
              echo 'Error! Failed to insert the png'. "<pre>" . mysqli_error($con) . "</pre>";exit;
          } else {

              $_SESSION['inc']= "<script>swal({title:'Success',text:'Profile Photo Change Successfully,type:'success'});</script>";
          }
      }
      else
      {
          $apkCount = count($_FILES["profile"]["name"]);
          for($i=0; $i < $apkCount; $i++)
          { 
            $apkName = $_FILES["profile"]["name"][$i];
            $apkPath = $output_dir.$apkName ;
            move_uploaded_file($_FILES["profile"]["tmp_name"][$i],$output_dir.$apkName);
            $ret[]= $apkName;
          $query = "UPDATE panel SET profile = '{$apkPath}' WHERE _username = '".$_SESSION['is_logged_in']."'";
            $result = mysqli_query($con, $query);
            if(!$result) {
                echo 'Error! Failed to insert the png'. "<pre>" . mysqli_error($con) . "</pre>";exit;
            }
        }

    }
    $_SESSION['inc']= "<script>swal({title:'Success',text:'Profile Photo Change Successfully',type:'success'});</script>";
    header("Refresh:0; url=profile.php");
            exit();
}
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Profile - Blue Triple 4</title>
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
      <div class="content-wrapper">

        <!-- Content -->
                  <div class="container-xxl flex-grow-1 container-p-y">
            

  

<!-- Header -->
  <div class="col-12">
    <div class="card mb-4">
  <h5 class="card-header"></h5>
      <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
        <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                    <img src="<?php echo ''.$login_data['profile'].'';?>" alt class="w-px-100 h-auto rounded-circle">
        </div>
        <div class="flex-grow-1 mt-3 mt-sm-5">
          <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
            <div class="user-profile-info">
              <h4><?php echo ''.$_SESSION['is_logged_in'].'';?></h4>

            </div>

          </div>
        </div>

      <div class="card-body">
        <small class="text-muted text-uppercase">About</small>
        <ul class="list-unstyled mb-4 mt-3">
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Username :</span> <span><?php echo ''.$_SESSION['is_logged_in'].'';?></span></li>

                    <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Token :</span> <span><?php echo ''.$login_data['_token'].'';?></span></li>
                    
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Role :</span> <span>Member</span></li>
                    <?php if ($login_data['_version'] == "free") { ?> 
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Device :</span> <span>Unlimited</span></li>
                      <?php } ?>
                    <?php if ($login_data['_version'] == "injector") { ?>
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Device :</span> <span><?php 
										if($login_data['_uid'] == NULL){
											echo "0/1"; 
										}else{
											echo "1/1";
										}
										?></span></li>
                      <?php } ?>
                    <?php if ($login_data['_p_status'] == "unpaid") { ?>
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Email :</span> <span>	<?php echo ''.$login_data['email'].'';?></span></li>
            <?php } ?>
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Registered :</span> <span><?php echo ''.$login_data['_reg_date'].'';?></span></li>
          
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Expired :</span> <span><?php echo ''.$login_data['_exp_date'].'';?></span></li>
          
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Resets :</span> <span><?php echo ''.$login_data['_resets'].'/'.$login_data['_r_resets'].'';?></span></li>
          
          <li class="d-flex align-items-center mb-3"><span class="fw-semibold mx-2">Provider :</span> <span><?php echo ''.$login_data['_registrar'].'';?></span></li>


        </ul>


      </div>
    </div>
  </div>
</div>
<!--/ Header -->


<!--/ Header -->
	<?php if (!empty($_SESSION['inc'])) { ?>
<?php echo $_SESSION['inc'];
unset($_SESSION['inc']);?>
<?php } ?>
  <div class="col-12">
    <div class="card mb-4">
  <h5 class="card-header">Change Profile Photo</h5>
  
  <!--Search Form -->
  <div class="card-body">
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-12">
          <div class="row g-3">
    <div class="position-relative form-group">
        <div class="mb-3">
<label class="form-label" for="user-role">Choose Only .png Files</label>
              <label class="col-sm-12 col-md-2 col-form-label" data-hs-file-attach-options='{
                 "textTarget": "[for=\"customFile\"]"
                }'></label>

                <input type="file" class="form-control-file form-control height-auto" name="profile"  required />
              </div>
            </div>
	<hr>
<button type="submit" name="change" class="btn btn-outline-primary"><i class="dw dw-upload"></i> Submit</button>
</form>
          </div>
        </div>
      </div>
    </form>
  </div>
  </div>

             <?php if ($login_data['_version'] == "injector") { ?>
  <div class="col-12">
    <div class="card mb-4">
  <h5 class="card-header">Reset Your Device</h5>
  <!--Search Form -->
  <div class="card-body">
    <form class="dt_adv_search" method="POST">
      <div class="row">
        <div class="col-12">
          <div class="row g-3">



	<hr>


	
	<button type="submit" name="reset" class="btn btn-outline-primary" style="margin-right: 63px;"><i class="dw dw-settings1"></i> Reset </button>
          </div>
        </div>
      </div>
    </form>
  </div>
 </div>
 
            <?php } ?>

             <?php if ($login_data['_version'] == "injector") { ?>
  <div class="col-12">
    <div class="card mb-4">
  <h5 class="card-header">Change Password</h5>
  
  <!--Search Form -->
  <div class="card-body">
    <form class="dt_adv_search" method="POST">
      <div class="row">
        <div class="col-12">
          <div class="row g-3">
            <div class="position-relative form-group">
              <label class="form-label">Old Password</label>
              <input type="text" readonly class="form-control dt-input" name="value_1" type="text" placeholder="" value="<?php echo $login_data['_password'];?>">
            </div>
            <div class="position-relative form-group">
              <label class="form-label">Enter A New Password</label>
              <input class="form-control dt-input dt-full-name" type="text" name="value_2" placeholder="Enter A New Password" required />
            </div>
            <div class="position-relative form-group">
              <label class="form-label">Confirm New Password</label>
              <input class="form-control dt-input dt-full-name" type="text" name="value_3" placeholder="Re-Enter Your New Password" required />
            </div>



	<hr>
<div align="right">
<button type="submit" class="btn btn-outline-primary"><i class="dw dw-upload"></i> Submit</button>
</form>
	</div>
          </div>
        </div>
      </div>
    </form>
  </div>
            <?php } ?>


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
