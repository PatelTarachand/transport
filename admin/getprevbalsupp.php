<?php include("dbconnect.php");
 $sup_id = trim(addslashes($_REQUEST['sup_id']));
$paymentdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['paymentdate']))); 
$purchaseid = $cmn->getvalfield($connection,"purchaseentry","purchaseid","sup_id='$sup_id'");


if($sup_id !='') {
	$opningamt = $cmn->getvalfield($connection,"suppliers","sum(opening_bal)","sup_id='$sup_id'");
	$purpayents = $cmn->getvalfield($connection,"payment","sum(paid_amt)","sup_id='$sup_id' and type='purchase'");
		$discamtt = $cmn->getvalfield($connection,"payment","sum(discamt)","sup_id='$sup_id' and type='purchase'");
		$totpur = $cmn->getvalfield($connection,"purchasentry_detail","sum(nettotal)","purchaseid='$purchaseid'");

$balamt =$opningamt+ $totpur-$purpayents-$discamtt;

echo $balamt;
}

?>