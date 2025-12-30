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
}

$fetch_server = mysqli_query($con, "SELECT * FROM server WHERE server_h_status = 'online'");
$server_data = mysqli_fetch_assoc($fetch_server);
$online = 'online';


$output_dir = "../lib/";

  if(isset($_FILES["mylib"]))
  {
      $ret = array();
      $error =$_FILES["mylib"]["error"];
      if(!is_array($_FILES["mylib"]["name"]))
      {   
          $lib_name = isset($_POST['lib_name']) ? $_POST['lib_name'] : '';
          $lib_version = isset($_POST['lib_version']) ? $_POST['lib_version'] : '';
          $lib_status = isset($_POST['lib_status']) ? $_POST['lib_status'] : '';
          $lib_namechecked = mysqli_real_escape_string($con, $lib_name);
          $lib_versionchecked = mysqli_real_escape_string($con, $lib_version);
          $lib_statuschecked = mysqli_real_escape_string($con, $lib_status);
          $libName = $_FILES["mylib"]["name"];
          $libExtension = pathinfo($libName, PATHINFO_EXTENSION);
          $allowedExtensions = ['so'];
          $libPath = $output_dir.$libName ;
          $lib_size = intval($_FILES['mylib']['size']);
          if(!in_array($libExtension, $allowedExtensions)) {
            $_SESSION['inc']= "<script>swal({title:'Warning',text:'Only Lib Uploads Here !',type:'warning'});</script>";
            header("Refresh:0; url=add-lib.php");
            exit();
        }
          $uploaded = move_uploaded_file($_FILES["mylib"]["tmp_name"],$libPath);
          if(!$uploaded){
              echo 'Error! Failed to Upload the lib ';exit;
          }
          $query = "INSERT INTO lib (lib_name, lib_name_show, lib_version, lib_path, lib_downloads, lib_size, lib_status, created_at)
                    VALUES ('{$libName}', '{$lib_namechecked}', '{$lib_versionchecked}', '{$libPath}', 0, {$lib_size}, '{$lib_statuschecked}', NOW())";
          $result = mysqli_query($con, $query);
          if(!$result) {
              echo 'Error! Failed to insert the lib'. "<pre>" . mysqli_error($con) . "</pre>";exit;
          } else {

              $_SESSION['inc']= "<script>swal({title:'Success',text:'".$lib_namechecked." Uploaded Successfully',type:'success'});</script>";
          }
      }
      else
      {
          $libCount = count($_FILES["mylib"]["name"]);
          for($i=0; $i < $libCount; $i++)
          { 
              $lib_name = isset($_POST['lib_name']) ? $_POST['lib_name'] : '';
              $lib_version = isset($_POST['lib_version']) ? $_POST['lib_version'] : '';
              $lib_status = isset($_POST['lib_status']) ? $_POST['lib_status'] : '';
              $lib_namechecked = mysqli_real_escape_string($con, $lib_name);
              $lib_versionchecked = mysqli_real_escape_string($con, $lib_version);
              $lib_statuschecked = mysqli_real_escape_string($con, $lib_status);
            $libName = $_FILES["mylib"]["name"][$i];
            $libPath = $output_dir.$libName ;
            $lib_size = intval($_FILES['mylib']['size'][$i]);
            move_uploaded_file($_FILES["mylib"]["tmp_name"][$i],$output_dir.$libName);
            $ret[]= $libName;
            $query = "INSERT INTO lib (lib_name, lib_name_show, lib_version, lib_path, lib_downloads, lib_size, lib_status, created_at)
                  VALUES ('{$libName}', '{$lib_namechecked}', '{$lib_versionchecked}', '{$libPath}', 0, {$lib_size}, '{$lib_statuschecked}', NOW())";
            $result = mysqli_query($con, $query);
            if(!$result) {
                echo 'Error! Failed to insert the lib'. "<pre>" . mysqli_error($con) . "</pre>";exit;
            }
        }

    }
    $_SESSION['inc']= "<script>swal({title:'Success',text:'".$lib_namechecked." Uploaded Successfully',type:'success'});</script>";
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Add Lib - Blue Triple 4</title>
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
  <h5 class="card-header">Add Lib</h5>
<?php if (!empty($_SESSION['inc'])) { ?>
<?php echo $_SESSION['inc'];
unset($_SESSION['inc']);?>
<?php } ?>
  <!--Search Form -->
  <div class="card-body">


          <form action="" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-12">
          <div class="row g-3">
            <div class="position-relative form-group">
              <label class="form-label">Lib Name</label>
              <input class="form-control dt-input dt-full-name" type="text" name="lib_name" placeholder="Enter Lib Name" required />
            </div>
            <div class="position-relative form-group">
              <label class="form-label">Lib Version</label>
              <input class="form-control dt-input" placeholder="Enter Lib Version" name="lib_version" type="text" required />
            </div>
                        <div class="position-relative form-group">
        <div class="mb-3">
          <label class="form-label" for="user-role">Status</label>
	<select class="form-select" 
	                       name="lib_status">
                  <option value="online">Online</option>
                  <option value="maintain">Maintenance</option>
                  <option value="offline">Offline</option>
                </select>
        </div>
    <div class="position-relative form-group">
        <div class="mb-3">
<label class="form-label" for="user-role">Choose .so Files</label>
              <label class="col-sm-12 col-md-2 col-form-label" data-hs-file-attach-options='{
                 "textTarget": "[for=\"customFile\"]"
                }'></label>

                <input type="file" class="form-control-file form-control height-auto" name="mylib" required />
              </div>
            </div>
            <hr>
            <div align="right">
            <button type="submit" name="Submit" class="btn btn-outline-primary"><i class="dw dw-upload"></i> Submit</button>
          </form>
              </div>

          </div>
        </div>
      </div>
    </form>
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
