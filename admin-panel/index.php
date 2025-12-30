<?php
session_start();
include '../dbConfig.php';
if (empty($_SESSION['is_logged_in'])){
header("Location: ../login.php");
}
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
$notif = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM nt WHERE n = 'all'" ));
if ($login_data['_user_type'] != "admin") {
	header("Location: ../login.php");
	exit();
}
$dados_editar = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM server WHERE srv_id=1"));
$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE srv_id = '1'");
$server_data = mysqli_fetch_assoc($fetch_server);
$online = 'online';
$offline = 'offline';
$online1 = 'Online';
date_default_timezone_set('Asia/Dhaka');
$time = date("Y/m/d h:i"); 
$m = 'main';
if(isset($_GET['file_name'])) { // Check if a file name has been provided
    $apk_name = mysqli_real_escape_string($con, $_GET['file_name']);
    $sql = "SELECT * FROM `apks` WHERE `apk_name`='$apk_name'";
    $result = mysqli_query($con, $sql);
    $file = mysqli_fetch_assoc($result);
    $file_path = "../apks/" . $_GET['file_name']; // Set the path to the file using the file name
    $file_name = $_GET['file_name']; // Set the name of the file that will be downloaded

    // Check if the file exists
    if (file_exists($file_path)) {
      $file_name = str_replace(" ","",$file_name);
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . $file_name);
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file_path));

      // Read and output the file contents
      readfile($file_path);
      $newCount = $file['apk_downloads'] + 1;
      $updateQuery = "UPDATE `apks` SET `apk_downloads`=$newCount WHERE `apk_name`='$apk_name'";
      mysqli_query($con, $updateQuery);
      header("Refresh: 1; url=see-apk.php");
      exit();
  } else {
        // File does not exist, display an error message
        $_SESSION['inc'] = "<script>swal('Error', 'File not found.', 'error');</script>";
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
                  
<div class="row g-4 mb-4">
  <div class="col-md-12 col-lg-4 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-8">
          <div class="card-body">
            <h6 class="card-title mb-1 text-nowrap">Welcome <?php echo ''.$_SESSION['is_logged_in'].'';?> !
</h6>
            <small class="d-block mb-3 text-nowrap">This Is The Server Of Blue Triple 4</small>
            <h5 class="card-title text-primary mb-1">Total Views</h5>
            <h4><?php echo ''.$server_data['total_sessions'].'';?></h4>

          </div>
        </div>
        <div class="col-4 pt-3 ps-0">
          <img src="../assets/img/illustrations/prize-light.png" width="90" height="140" class="rounded-start" alt="View Sales">
        </div>
      </div>
      </div>
<br>

<div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div class="card-title mb-0">
          <h5 class="m-0 me-2">Products</h5>
        </div>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
        
          <div id="conversionRateChart"></div>
        </div>
        <hr>
        <ul class="p-0 m-0">
          <li class="d-flex mb-4">
            <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Total Apks</h6>
              </div>
              <div class="user-progress">
                <strong><?php $fetch_t = mysqli_query($con, "SELECT * FROM apks");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></strong>
              </div>
            </div>
          </li>
          <hr>
          <li class="d-flex mb-4">
            <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Total Scripts</h6>
              </div>
              <div class="user-progress">
                <strong><?php $fetch_t = mysqli_query($con, "SELECT * FROM script");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></strong>
              </div>
            </div>
          </li>
          <hr>
          <li class="d-flex mb-4">
            <div class="d-flex w-100 flex-wrap justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-0">Total Libs</h6>
              </div>
              <div class="user-progress">
<strong><?php $fetch_t = mysqli_query($con, "SELECT * FROM lib");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></strong>
              </div>
            </div>
          </li>
        </ul>
      </div>

  </div>
            <br>

            
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Role</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Admin</h3>
              <small class="text-success"></small>
            </div>
            <small>Your Role</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="fas fa-user-circle bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
    <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Members</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php $fetch_t = mysqli_query($con, "SELECT * FROM panel WHERE _user_type = 'member'");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Total Members</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="fas fa-user bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Registers</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php $fetch_t = mysqli_query($con, "SELECT * FROM panel WHERE _user_type = 'member' AND _p_status = 'unpaid'");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Total Registers</small>
          </div>
          <span class="badge bg-label-info rounded p-2">
            <i class="fas fa-user-injured bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Banned Members</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php $fetch_t = mysqli_query($con, "SELECT * FROM panel WHERE _status = 'banned'");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Total Banned Members</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="fas fa-user-slash bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  
       <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Expired Members</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php $fetch_t = mysqli_query($con, "SELECT * FROM panel WHERE _user_type = 'member' AND _exp_date < '$time'");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Total Expired Members</small>
          </div>
          <span class="badge bg-label-primary rounded p-2">
            <i class="fas fa-face-frown bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Resellers</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php $fetch_t = mysqli_query($con, "SELECT * FROM panel WHERE _user_type = 'reseller'");
	$count = mysqli_num_rows($fetch_t);
	echo $count; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Total Resellers</small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="fas fa-user-friends bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Credits</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Unlimited</h3>
              <small class="text-success"></small>
            </div>
            <small>Total Credits</small>
          </div>
          <span class="badge bg-label-info rounded p-2">
            <i class="fas fa-money-check-alt bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php if ($server_data['server_h_status'] == $online) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Online</h3>
              <small class="text-success"></small>
            </div>
            <small>Apk Status</small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="fab fa-app-store bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php } ?>
            <?php if ($server_data['server_h_status'] == $m) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Maintenance</h3>
              <small class="text-success"></small>
            </div>
            <small>Apk Status</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="fab fa-app-store bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php } ?>
            <?php if ($server_data['server_h_status'] == $offline) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Offline</h3>
              <small class="text-success"></small>
            </div>
            <small>Apk Status</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="fab fa-app-store bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
  				
            <?php } ?>
            <?php if ($server_data['server_status'] == $online) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Online</h3>
              <small class="text-success"></small>
            </div>
            <small>Server Status</small>
          </div>
          <span class="badge bg-label-success rounded p-2">
            <i class="fas fa-cog bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php } ?>
                        <?php if ($server_data['server_status'] == $m) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Maintenance</h3>
              <small class="text-success"></small>
            </div>
            <small>Server Status</small>
          </div>
          <span class="badge bg-label-warning rounded p-2">
            <i class="fas fa-cog bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php } ?>
            <?php if ($server_data['server_status'] == $offline) { ?>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Status</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2">Offline</h3>
              <small class="text-success"></small>
            </div>
            <small>Server Status</small>
          </div>
          <span class="badge bg-label-danger rounded p-2">
            <i class="fas fa-cog bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
  </div>
            <?php } ?>
            
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div class="content-left">
            <span>Provider</span>
            <div class="d-flex align-items-end mt-2">
              <h3 class="mb-0 me-2"><?php echo ''.$login_data['_registrar'].''; ?></h3>
              <small class="text-success"></small>
            </div>
            <small>Your Provider</small>
          </div>
          <span class="badge bg-label-info rounded p-2">
            <i class="fas fa-user-secret bx-sm"></i>
          </span>
        </div>
      </div>
    </div>
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
