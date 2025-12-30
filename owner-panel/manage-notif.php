<?php
session_start();
include '../dbConfig.php';
if (empty($_SESSION['is_logged_in'])){
header("Location: ../login.php");
}
$login_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM panel WHERE _username = '".$_SESSION['is_logged_in']."'"));
$notif = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM nt WHERE n = 'all'" ));
if ($login_data['_user_type'] != "owner" && $login_data['_user_type'] != "reseller") {
	header("Location: ../login.php");
}
if ($login_data['_user_type'] != "owner"){
header("Location: index.php");
	exit();
}


if (isset($_GET['mainprid'])) {
	$mainprID = $_GET['mainprid'];
	if ($dados_logado['_user_type'] == "owner") {
	$msg = mysqli_query($con, "UPDATE apps SET `pstatus` = 'maintenance' WHERE pname = '$mainprID'");
	if($msg) {
	$_SESSION['acao'] = "<script>swal('Warning', 'Product : $mainprID Is Now Under Maintenance', 'warning');</script>";
	
	}
	}
}

if (isset($_GET['onlineprid'])) {
	$onlineprID = $_GET['onlineprid'];
	if ($dados_logado['_user_type'] == "owner") {
	$msg = mysqli_query($con, "UPDATE apps SET `pstatus` = 'online' WHERE pname = '$onlineprID'");
	if($msg) {
	$_SESSION['acao'] = "<script>swal('Successo', 'Product : $onlineprID Is Now Online', 'success');</script>";
		
	}
}
}

if (isset($_GET['delete'])){
		$nt = isset($_POST['nt']) ? $_POST['nt'] : '';
		$ntchecked = mysqli_real_escape_string($con, $nt);
$delete = $_GET['delete'];
$check = mysqli_num_rows(mysqli_query($con, "SELECT * FROM nt WHERE nt = '$delete'"));
if ($check == 1){
$delete = mysqli_query($con, "DELETE FROM nt WHERE nt = '$delete'");
		if ($delete) {
		    $_SESSION['acao'] = "<script>swal('Successo', 'Notif : $ntchecked Has Been Deleted', 'success');</script>";
		    header("Location: manage-notif.php");
	exit();
		} else {
		    $_SESSION['acao'] = "<script>swal('Error', 'Failed!', 'error');</script>";
		    
		}
}
}

if (isset($_POST['Delete'])) {
		$nt = isset($_POST['nt']) ? $_POST['nt'] : '';
		$dt = isset($_POST['dt']) ? $_POST['dt'] : '';
	$n = 'all';
	$ntchecked = mysqli_real_escape_string($con, $nt);
	$dtchecked = mysqli_real_escape_string($con, $dt);
	$nchecked = mysqli_real_escape_string($con, $n);
	
	if ($nchecked) {
		$query = mysqli_query($con, "DELETE FROM nt WHERE nt = '$ntchecked'");
		if ($query) {
		    $_SESSION['acao'] = "<script>swal('Successo', 'Notif Has Been Deleted', 'success');</script>";
		    header("Location: manage-notif.php");
	exit();
		} else {
		    $_SESSION['acao'] = "<script>swal('Error', 'Failed!', 'error');</script>";
		}
	}
  }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Manage Notification - Blue Triple 4</title>
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
  <h5 class="card-header">Manage Notification</h5>
	<?php if(!empty($_SESSION['acao'])){ echo $_SESSION['acao'].'<hr>'; unset($_SESSION['acao']); }?>
  <div class="card-datatable text-nowrap">
  <div class="table-responsive">
    <table class="datatables-ajax table table-bordered">
	<thead>
							              <tr>
              
	<th>#</th>
													<th>Notification</th>
		<th>Sented Date</th>
											
												
	<th>Action</th>

		</thead>									<tbody>				<?php 
									
									//$admins=$row['username'];
									$query_nt = mysqli_query($con,"SELECT * FROM nt WHERE `n` = 'all' ORDER BY id ASC");
									/*
									$cur_user = $_SESSION['user_logado'];
									$query_users = mysqli_query($con,"SELECT * FROM tokens WHERE 'Vendedor' = $cur_user");
									print_r($query_users);
									*/
									while ($row = mysqli_fetch_assoc($query_nt)) {
									?>
					
												<tr>
													<td><span class="bx bx-bell bx-sm"></span></td>
											        <td><?php echo $row['nt'];?></td>
											                <td><?php echo $row['dt'];?></td>
		
																			<th><div class="btn-group text-xs btn-xs" role="group" aria-label="Basic example">
      <a href="manage-notif.php?delete=<?php echo $row['nt'];?>"><button type="button" class="btn btn-primary ml-1 text-xs" onClick="return confirm('Do you really want to Delete?');" style="margin: 0px 0px 0px 2px; background-color:#FF005C; border-color:#FF005C"><i class="fas fa-circle-xmark"></i></button></a>


</div>
										
									

												</tr>
												<?php
}
?>
	
		
 
              </tr>
										</tbody>
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
