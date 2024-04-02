<?php  
include("dbconnect.php");

$bid_id = trim(addslashes($_REQUEST['bid_id']));
$confdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['confdate'])));

		if($bid_id !='')
		{
			
			mysqli_query($connection,"update bidding_entry set confdate='$confdate',isconf='1' where bid_id='$bid_id'");
			
			echo "1";
			}

?>