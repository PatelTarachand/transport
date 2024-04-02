<?php 
// error_reporting(0);
session_start();
include("config.php");
include("lib/getval.php");

      $cmn = new Comman();
if($_SESSION['loginid']!=''){
     $loginid = $_SESSION['loginid'];
     $compid = $_SESSION['compid'];
     $sessionid = $_SESSION['sessionid'];
 

  //  $mobile=$cmn->getvalfield($connection,"adduser","mobile","id=$loginid");
  // $username=$cmn->getvalfield($connection,"adduser","username","id='$loginid'");
  // $fathers_name=$cmn->getvalfield($connection,"adduser","fathers_name","id='$loginid'");
  // $mobile=$cmn->getvalfield($connection,"adduser","mobile","id='$loginid'");
  // $email_id=$cmn->getvalfield($connection,"adduser","email_id","id='$loginid'");
  // $dob=$cmn->getvalfield($connection,"adduser","dob","id='$loginid'");
  // $gender=$cmn->getvalfield($connection,"adduser","gender","id='$loginid'");
  // $city=$cmn->getvalfield($connection,"adduser","city_id","id='$loginid'");
  // $state_name=$cmn->getvalfield($connection,"adduser","stateid","id='$loginid'");
  // $imgname=$cmn->getvalfield($connection,"adduser","imgname","id='$loginid'");


  // $mobile=$cmn->getvalfield($connection,"adduser","mobile","id='$loginid'");
   

$createdate=date('Y-m-d H:i:s');
$currentdate=date('Y-m-d');
 }else{

    echo "<script>location='index.php' </script>";
 }
?>