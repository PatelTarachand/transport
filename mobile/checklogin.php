<?php
session_start();
include("config.php");
$mobile = test_input($_POST['mobile']);
$password = test_input($_POST['password']);
$compid = test_input($_POST['compid']);
$sessionid = test_input($_POST['sessionid']);

if ($mobile != "" || $password != "") {
  // echo "select * from user_master where mobile='$mobile' && password='$password'";die;
  $sql = mysqli_query($connection, "select * from  m_userlogin where mobile='$mobile' && password='$password'");

  $count = mysqli_num_rows($sql);
  //echo   $count; die;
  $row = mysqli_fetch_array($sql);
  if ($count > 0) {
     //echo "1";die;
    $_SESSION['loginid'] = $row['userid'];
    $_SESSION['compid'] = $compid ;
    $_SESSION['sessionid'] = $sessionid;

    echo "<script>location='dashboard.php?success=1'</script>";
  } else {
    echo "<script>location='index.php?msg=invalid'</script>";
  }
} else {
  echo "<script>location='index.php?msg=invalid'</script>";
}



function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
