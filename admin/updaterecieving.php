<?php  
include("dbconnect.php");

$bid_id = trim(addslashes($_REQUEST['bid_id']));
$recweight = trim(addslashes($_REQUEST['recweight']));
$recdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['recdate'])));
$sortagr = trim(addslashes($_REQUEST['sortagr']));
$recbag = trim(addslashes($_REQUEST['recbag']));
$shortagetype = trim(addslashes($_REQUEST['shortagetype']));
$fpay = 0;

		if($bid_id !='')
		{
			// echo "update bidding_entry set recweight='$recweight',recdate='$recdate',sortagr='$sortagr',recbag='$recbag',shortagetype='$shortagetype',isreceive='1',fpay='$fpay' where bid_id='$bid_id'";
			mysqli_query($connection,"update bidding_entry set recweight='$recweight',recdate='$recdate',sortagr='$sortagr',recbag='$recbag',shortagetype='$shortagetype',isreceive='1',fpay='$fpay' where bid_id='$bid_id'");
			
			echo "1";
			}

?>