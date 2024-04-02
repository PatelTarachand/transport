<?php include("dbconnect.php");

 $customer_id = trim(addslashes($_REQUEST['customer_id']));
  $paymentdate = $cmn->dateformatusa(trim(addslashes($_REQUEST['paymentdate']))); 
 $paid_amt = trim(addslashes($_REQUEST['paid_amt']));
$disc = trim(addslashes($_REQUEST['disc']));
$pay_type = trim(addslashes($_REQUEST['pay_type']));
$narration = trim(addslashes($_REQUEST['narration']));
echo  $paymentid = trim(addslashes($_REQUEST['paymentid']));

 // $keyvalue = $paymentid;

	if($customer_id !='' && $paymentdate !='' && $paid_amt !='') {
	if($paymentid==0) {
		
echo "insert into payment set paymentdate='$paymentdate', customer_id='$customer_id',	
paid_amt='$paid_amt',discamt='$disc',narration='$narration',createdby='$loginid',createdate='$createdate',
type='sale',ipaddress='$ipaddress',sessionid='$sessionid'";
	mysqli_query($connection,"insert into payment set paymentdate='$paymentdate', customer_id='$customer_id',	
	paid_amt='$paid_amt',discamt='$disc',pay_type='$pay_type',narration='$narration',createdby='$loginid',createdate='$createdate',
	type='sale',ipaddress='$ipaddress',sessionid='$sessionid'");

$keyvalue = mysqli_insert_id($connection);

	mysqli_query($connection, "INSERT into sale_trans set  customer_id='$customer_id',transdate='$paymentdate',pamount='$paid_amt',transtype='credit',purticular='payment',bill_id='$keyvalue'");
	
			
	}
	else
	{
		echo "UPDATE payment set paymentdate='$paymentdate', customer_id='$customer_id', 
		paid_amt='$paid_amt', discamt='$disc',pay_type='$pay_type', narration='$narration',createdby='$loginid',lastupdated='$createdate',
		ipaddress='$ipaddress' where paymentid='$paymentid'";
	  
		mysqli_query($connection,"UPDATE payment set paymentdate='$paymentdate', customer_id='$customer_id', 
	paid_amt='$paid_amt', discamt='$disc',pay_type='$pay_type', narration='$narration',createdby='$loginid',lastupdated='$createdate',
	ipaddress='$ipaddress' where paymentid='$paymentid'");

		

			mysqli_query($connection,"UPDATE sale_trans set customer_id='$customer_id',transdate='$paymentdate',pamount='$paid_amt',transtype='credit',purticular='payment' where bill_id='$paymentid'");




	}

}

?>



