<?php error_reporting(0);
include("dbconnect.php");
$placename = trim($_GET['placename']);
if($placename!="")
{
	$cnt = $cmn->getvalfield($connection,"m_place","count(*)","placename='$placename'");
	if($cnt == 0)
	{
		$sqlins = "insert into m_place set placename='$placename',createdate = now(),
		sessionid = '$_SESSION[sessionid]'";
		mysqli_query($connection,$sqlins);		
	}
	
	$sql_show = mysqli_query($connection,"select * from m_place");
	while($row_show = mysqli_fetch_array($sql_show))
	{
	?>
		<option value="<?php echo $row_show['placeid']; ?>"><?php echo $row_show['placename']; ?></option>
	<?php
	}
}

?>