<?php
include("dbconnect.php");
echo $item_id= addslashes($_REQUEST['item_id']);

echo $unit_name= addslashes($_REQUEST['unit_name']);

echo $qty= addslashes($_REQUEST['qty']);
echo $issuedetailid=trim(addslashes($_REQUEST['issuedetailid'])); 
$issueid = trim(addslashes($_REQUEST['issueid']));
$is_rep = trim(addslashes($_REQUEST['is_rep']));  
$excrec = trim(addslashes($_REQUEST['excrec']));  
$stock = trim(addslashes($_REQUEST['stock']));  

$remark1 = trim(addslashes($_REQUEST['remark1']));  


if($item_id !='' && $qty !='')
{
	if($issuedetailid==0)
	{
// echo "insert into issueentrydetail set item_id = '$item_id', unit_name = '$unit_name',qty = '$qty', issueid = '$issueid',
// excrec='$excrec',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate'";
		$sql_insert="insert into issueentrydetail set item_id = '$item_id', unit_name = '$unit_name', stock = '$stock',qty = '$qty', issueid = '$issueid',
        excrec='$excrec',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate'";
 
		mysqli_query($connection,$sql_insert);



	$action=1;
	$process = "insert";
	echo "1";
	}
	else
	{
		$sql_insert="update issueentrydetail set item_id = '$item_id', unit_name = '$unit_name', stock = '$stock',qty = '$qty', issueid = '$issueid',
        excrec='$excrec',remark1='$remark1',is_rep='$is_rep', ipaddress='$ipaddress',createdby='$userid',createdate='$createdate' WHERE issuedetailid = '$issuedetailid'";
 
		mysqli_query($connection,$sql_insert);

		$action=2;
		$process = "update";
	}	

}

?>