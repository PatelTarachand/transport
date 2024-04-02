<?php
include_once("dbconnect.php");
$truckid = $_REQUEST['truckid'];
//echo $truckid;

$openningkm = $cmn->getvalfield($connection,"m_truck","openningkm","truckid='$truckid'");
if($truckid != "" && $truckid != 0)
{
	$currdate = date('Y-m-d');
	
	$sql_prev = mysqli_query($connection,"Select metread from diesel_demand_slip where dieslipid = (select max(dieslipid) from diesel_demand_slip where truckid = '$truckid')");
	if($sql_prev)
	{
		while($row_prev = mysqli_fetch_assoc($sql_prev))
		{
			$metread = $row_prev['metread'];
		}
	}
	
	if($metread == "")
	{
	$metread += $openningkm;
	
	if($metread == "")
	{	
	$metread = 0;
	}
	
	}
	
															
	
	echo $empid."|".$metread;
}
?>