<?php error_reporting(0);
include("dbconnect.php");
$consigneename = trim($_GET['consigneename']);
if($consigneename!="")
{
	$cnt = $cmn->getvalfield($connection,"m_consignee","count(*)","consigneename='$consigneename'");
	if($cnt == 0)
	{
		$sqlins = "insert into m_consignee set consigneename='$consigneename',enable='enable',stateid='14',createdate = now(),
		sessionid = '$_SESSION[sessionid]', ipaddress='$ipaddress'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from m_consignee");
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['consigneeid']; ?>"><?php echo $row_show['consigneename']; ?></option>
	<?php
	}
}

?>