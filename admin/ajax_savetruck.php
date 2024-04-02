<?php error_reporting(0);
include("dbconnect.php");
$truckno = trim($_GET['truckno']);
$ownerid = trim($_GET['ownerid']);
$typeid = trim($_GET['typeid']);

if($truckno!="" && $ownerid!="")
{
	$cnt = $cmn->getvalfield($connection,"m_truck","count(*)","truckno='$truckno' and ownerid = '$ownerid'");
	if($cnt == 0)
	{
		$sqlins = "insert into m_truck set truckno='$truckno', ownerid = '$ownerid',typeid = '$typeid',createdate = now(), sessionid = '$_SESSION[sessionid]', ipaddress='$ipaddress'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from m_truck");
	echo "<option value=''>--select--</option>";
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['truckid']; ?>"><?php echo $row_show['truckno']; ?></option>
	<?php
	}
}

?>