<?php include("dbconnect.php");

//print_r($_REQUEST); die;
$invoiceid = trim(addslashes($_REQUEST['invoiceid']));
$hiddenid = trim(addslashes($_POST['hiddenid']));
$invno = trim(addslashes($_POST['invoiceno']));
$itemtype = trim(addslashes($_POST['itemtype']));
$invdate = $cmn->dateformatusa(trim(addslashes($_POST['invdate'])));
$ids = explode(',', $hiddenid);
//print_r($id);

if($invoiceid==0) {
			mysqli_query($connection,"insert into invoicebilty set invno='$invno',invdate='$invdate',itemtype='$itemtype',createdate='$createdate',ipaddress='$ipaddress'");
			$lastid = mysqli_insert_id($connection);
}
else
{
	mysqli_query($connection,"update invoicebilty set invno='$invno',invdate='$invdate',itemtype='$itemtype',lastupdated='$createdate',ipaddress='$ipaddress' 
	where invoiceid='$invoiceid'");
			$lastid = $invoiceid;
			
			mysqli_query($connection,"update bidding_entry set invoiceid='0',is_invoice='0' where invoiceid='$lastid'");
}
foreach($ids as $id) {
		
		mysqli_query($connection,"update bidding_entry set invoiceid='$lastid',is_invoice='1' where bid_id='$id'");

}


echo $lastid;
?>