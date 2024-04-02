<?php error_reporting(0);
include("dbconnect.php");
$bilty_id = trim(addslashes($_REQUEST['bilty_id']));
$recd_wt = trim(addslashes($_REQUEST['recd_wt']));
$shortagewt = trim(addslashes($_REQUEST['shortagewt']));
$unloading_place = trim(addslashes($_REQUEST['unloading_place']));
$recd_date = $cmn->dateformatusa(trim(addslashes($_REQUEST['recd_date'])));

mysqli_query($connection,"update bilty_entry set recd_wt='$recd_wt',shortagewt='$shortagewt',recd_date='$recd_date',unloading_place='$unloading_place' where bilty_id='$bilty_id'");

echo "1";
?>