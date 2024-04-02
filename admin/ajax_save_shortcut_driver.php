<?php error_reporting(0);
include("dbconnect.php");
$empname = trim($_GET['empname']);
$mob1 = trim($_GET['mob1']);

if($empname!="")
{
	$cnt = $cmn->getvalfield($connection,"m_employee","count(*)","empname='$empname'");
	if($cnt == 0)
	{
        // echo "insert into m_employee set empname='$empname', mob1='$mob1',
		// sessionid = '$_SESSION[sessionid]'";die;
		$sqlins = "insert into m_employee set empname='$empname', mob1='$mob1', designation='1',
		sessionid = '$_SESSION[sessionid]'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from m_employee");
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['empid']; ?>"><?php echo $row_show['empname']; ?></option>
	<?php
	}
}

?>