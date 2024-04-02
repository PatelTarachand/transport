<?php error_reporting(0);
include("dbconnect.php"); 
$mapid = $_REQUEST['mapid'];
$downdate = $cmn->dateformatdb($_REQUEST['downdate']);
$description=$_REQUEST['description'];
$remarks=$_REQUEST['remarks'];;
$resale_amt=$_REQUEST['resale_amt'];
$resale_to=$_REQUEST['resale_to'];
$resale_description=$_REQUEST['resale_description'];

if($mapid != '' && $downdate != "")
{

	$res = mysqli_query($connection,"Update tyre_map set downdate = '$downdate',description='$description' , remarks='$remarks'  where mapid = '$mapid'");
	if($res && $remarks > 0)
	{
		$tid = $cmn->getvalfield($connection,"tyre_map","tid","mapid = '$mapid'");				
		$truckid =  $cmn->getvalfield($connection,"tyre_map","truckid","mapid = '$mapid'");
		
		
		$res = mysqli_query($connection,"update tyre_purchase set truckid = '$truckid',removedate = '$downdate',description='$description' , remarks='$remarks' , resale_amt='$resale_amt' ,resale_to='$resale_to' ,resale_description='$resale_description',lastupdated = now() where tid='$tid' ");
	}
	
}

if($res)
echo 1;
else
echo 0;
?>