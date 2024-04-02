<?php
include("dbconnect.php"); 
$tid = $_REQUEST['tid'];
$reusedate = $cmn->dateformatdb($_REQUEST['reusedate']);
$tnumber=$_REQUEST['tnumber'];
$invoiceno = $cmn->get_invoice($connection,"tyre_purchase","tid");
if($tid != '' && $reusedate != "" && $tnumber != "")
{
	//echo "Update tyre_map set downdate = '$downdate',description='$description' , remarks='$remarks' , resale_amt='$resale_amt' ,resale_to='$resale_to' ,resale_description='$resale_description' where mapid = '$mapid'";
	$res = mysqli_query($connection,"Update tyre_purchase set reusedate = '$reusedate',reuse='1'  where tid = '$tid'");
	if($res)
	{
		//echo "insert into tyre_purchase set tnumber = '$tnumber',invoiceno = '$invoiceno',supplier_id = '-1' ,createdate=now(),		sessionid = '$_SESSION[sessionid]'";
		$res = mysqli_query($connection,"insert into tyre_purchase set tnumber = '$tnumber',invoiceno = '$invoiceno',supplier_id = '-1' ,createdate=now(),sessionid = '$_SESSION[sessionid]'");
	}
	
}

if($res)
echo 1;
else
echo 0;
?>