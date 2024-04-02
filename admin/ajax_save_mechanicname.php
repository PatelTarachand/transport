<?php error_reporting(0);
include("dbconnect.php");
$mechanic_name = trim($_GET['mechanic_name']);
$mobile = trim($_GET['mobile']);

if($mechanic_name!="")
{
	$cnt = $cmn->getvalfield($connection,"mechine_service_master","count(*)","mechanic_name='$mechanic_name'");
	if($cnt == 0)
	{
        // echo "insert into m_employee set empname='$empname', mob1='$mob1',
		// sessionid = '$_SESSION[sessionid]'";die;
		$sqlins = "insert into mechine_service_master set mechanic_name='$mechanic_name', mobile='$mobile',
		sessionid = '$_SESSION[sessionid]'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from mechine_service_master");
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['meachineid']; ?>"><?php echo $row_show['mechanic_name']; ?></option>
	<?php
	}
}

?>