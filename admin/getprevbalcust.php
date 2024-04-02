<?php include("dbconnect.php");
 $customer_id = trim(addslashes($_REQUEST['customer_id']));
$paymentdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['paymentdate']))); 
$saleid = $cmn->getvalfield($connection,"sale_entry","saleid","customer_id='$customer_id'");


if($customer_id !='') {
	$opningamt = $cmn->getvalfield($connection,"m_customer","sum(opening_bal)","customer_id='$customer_id'");
	$purpayents = $cmn->getvalfield($connection,"payment","sum(paid_amt)","customer_id='$customer_id' and type='sale'");
		$discamtt = $cmn->getvalfield($connection,"payment","sum(discamt)","customer_id='$customer_id' and type='sale'");
		$totpur = $cmn->getvalfield($connection,"saleentry_detail","sum(grandtotal)","saleid='$saleid'");

$balamt =$opningamt+ $totpur-$purpayents-$discamtt;

echo $balamt;
}

?>