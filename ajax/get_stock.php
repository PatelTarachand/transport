<?php 
include("../admin/dbconnect.php");
$itemid = $_REQUEST['itemid'];

if($itemid !='' )
{
	
	$stock = $cmn->get_stock($itemid);	
	 echo $stock;
            
		
	
}
?>
