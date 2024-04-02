<?php include("dbconnect.php");
$department_id = trim(addslashes($_POST['department_id']));

$sql = mysqli_query($connection,"select empid,empname from m_employee where department_id='$department_id'");
?>
	<option value="">--Select--</option>
<?php 
while($row=mysqli_fetch_assoc($sql))
{
?>
		<option value="<?php echo $row['empid']; ?>"><?php echo $row['empname']; ?></option>
<?php 	
}
?>