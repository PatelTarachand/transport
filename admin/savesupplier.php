<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$catname = trim(addslashes($_REQUEST['supplier_name']));

if($catname !='')
{
	$cnt = $cmn->getvalfield($connection,"supplier_master","count(*)","supplier_name='$supplier_name'");
	
	if($cnt !='0')
	{
		echo "dup";	
	}
	else
	{
		mysqli_query($connection,"insert into supplier_master set supplier_name='$supplier_name',status='1',createdby='$loginuser_id',ipaddress='$ipaddress',createdate='$createdate'");	

	}
	?>
    
      
