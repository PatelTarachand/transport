<?php  include_once("dbconnect.php");
$bid_id = trim(addslashes($_REQUEST['bid_id']));
$is_reminder = trim(addslashes($_REQUEST['is_reminder']));

if($is_reminder==1) { $is_reminder=0; } else { $is_reminder=1; }


mysqli_query($connection,"update bidding_entry set is_reminder='$is_reminder' where bid_id='$bid_id'");


?>