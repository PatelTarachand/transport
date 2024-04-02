<?php error_reporting(0);
include("dbconnect.php");
$headname = $_GET['headname'];

echo($headname);
if($headname!="")
{
	$cnt = $cmn->getvalfield($connection,"head_master","count(*)","headname='$headname'");
	if($cnt == 0)
	{
       
		$sqlins = "insert into head_master set headname='$headname',
		sessionid = '$_SESSION[sessionid]'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from head_master");
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['headid']; ?>"><?php echo $row_show['headname']; ?></option>
	<?php
	}
}

?>