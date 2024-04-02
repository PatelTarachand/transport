<?php
include_once("dbconnect.php");
$supplier_name=$_REQUEST['supplier_name'];
$address = $_REQUEST['address'];

if($supplier_name != "" )
{
	mysqli_query($connection,"Insert into inv_m_supplier set supplier_name = '$supplier_name',address = '$address',createdate = now(),sessionid = '$sessionid'");?>
	 <option value="">-Select-</option>
	<?php
        $sql_cust="select * from  inv_m_supplier";
        $res_cust=mysqli_query($connection,$sql_cust);
        while($row_cust=mysqli_fetch_assoc($res_cust))
        {
    ?>
        <option value="<?php echo $row_cust['supplier_id']; ?>"><?php echo $row_cust['supplier_name']; ?></option>
    <?php
        }
   
}
?>