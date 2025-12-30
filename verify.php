<?php
require("dbConfig.php");

if(isset($_GET['v_code']))
{
  $v_code = mysqli_real_escape_string($con, $_GET['v_code']);
  
  $query = "SELECT * FROM `panel` WHERE `verification_code`='$v_code'";
  $result = mysqli_query($con, $query);
  
  if(mysqli_num_rows($result) == 1)
  {
    $result_fetch = mysqli_fetch_assoc($result);
    
    if($result_fetch['is_verified'] == 0)
    {
      $email = $result_fetch['email'];
      $update = "UPDATE `panel` SET `is_verified`=1, `_v_status`='verified' WHERE `verification_code`='$v_code'";
      
      if(mysqli_query($con, $update))
      {
        echo "<script>setTimeout(function(){swal({title:'Success',text:'Verify Success',type:'success'},function(){window.location = 'login.php';});},100);</script>";
      }
      else
      {
        echo "<script>setTimeout(function(){swal({title:'Error',text:'Can not run',type:'error'},function(){window.location = 'login.php';});},100);</script>";
      }
    }
    else
    {
      echo "<script>setTimeout(function(){swal({title:'Error',text:'Email Already Verified',type:'error'},function(){window.location = 'login.php';});},100);</script>";
    }
  }
  else
  {
    echo "<script>setTimeout(function(){swal({title:'Error',text:'Can not run',type:'error'},function(){window.location = 'login.php';});},100);</script>";
  }
}
?> 




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="styles/sweetalert.min.css"/>
  <script src="scripts/sweetalert.min.js"></script>
  <title>Verify</title>
</head>
<body>
  
</body>
</html>