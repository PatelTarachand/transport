<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$stype = trim(addslashes($_REQUEST['stype']));

if($stype=="Owner")
{
	$sql = mysqli_query($connection,"select ownername from m_truckowner order by ownername");
	while($row=mysqli_fetch_assoc($sql))
	{
	?>
    
     <option value="<?php echo $row['ownername']; ?>">
    
    <?php
	}
}
else if($stype=="Driver")
{
	$sql = mysqli_query($connection,"select drivername from bilty_entry where drivername !='' group by drivername order by drivername");
	while($row=mysqli_fetch_assoc($sql))
	{
	?>
    
     <option value="<?php echo $row['drivername']; ?>">
    
    <?php
	}
}

?>