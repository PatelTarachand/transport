<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$truckid = trim(addslashes($_REQUEST['truckid']));
$drivername = trim(addslashes($_REQUEST['drivername']));
$bhatta_amount = trim(addslashes($_REQUEST['bhatta_amount']));
$bhatta_date = $cmn->dateformatusa(trim(addslashes($_REQUEST['bhatta_date'])));
$hammali_amount = trim(addslashes($_REQUEST['hammali_amount']));
$hammali_date = $cmn->dateformatusa(trim(addslashes($_REQUEST['hammali_date'])));
$other_amount = trim(addslashes($_REQUEST['other_amount']));
$other_date = $cmn->dateformatusa(trim(addslashes($_REQUEST['other_date'])));
$tax_amount = trim(addslashes($_REQUEST['tax_amount']));
$tax_date = $cmn->dateformatusa(trim(addslashes($_REQUEST['tax_date'])));

if($bhatta_amount !='')
{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='bhatta' && headtype='Truck'");
	if($head_id !='')
	{
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$bhatta_amount',payment_type='cash',
			paymentdate='$bhatta_date',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
	}
}


if($hammali_amount !='')
{
	if($head_id !='')
	{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='Hamali' && headtype='Truck'");
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$hammali_amount',payment_type='cash',
			paymentdate='$hammali_date',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
	}
}


if($other_amount !='')
{
	if($head_id !='')
	{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='other' && headtype='Truck'");
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$other_amount',payment_type='cash',
			paymentdate='$other_date',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
	}
}


if($tax_amount !='')
{
	if($head_id !='')
	{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='total tax' && headtype='Truck'");
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$tax_amount',payment_type='cash',
			paymentdate='$tax_date',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
	}
	
}

?>