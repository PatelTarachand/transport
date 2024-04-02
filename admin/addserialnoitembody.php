<?php  error_reporting(0);
include("dbconnect.php");

$qty = trim(addslashes($_REQUEST['qty']));
$purchaseid = trim(addslashes($_REQUEST['purchaseid']));
$itemid = trim(addslashes($_REQUEST['itemid']));
$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");


?>

<?php if($itemcatid=='19'){ ?>
<table class="table table-bordered">
		<tr>
        <th>#</th>
         <th>Serial No</th>
        </tr>
        
       <?php 
	   for($i=1; $i <= $qty; $i++) {
		   
		    $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","purchaseid='$purchaseid' and itemid='$itemid' and loop_i='$i' ");
		   $pos_id = $cmn->getvalfield($connection,"purchaseorderserial","pos_id","serial_no='$serial_no' and loop_i='$i'");
		   ?>
           	<tr>
            		<td>Serial <?php echo $i +0; ?></td>
            		<td>
						<!-- <?php echo $purdetail_id;?> -->
                    		<input type="text" class="" name="serial_no" id="serial_no1<?php echo $i;?>" value="<?php echo $serial_no; ?>"  onchange="saveserial('<?php echo $i;?>');">
                    		<input type="hidden" class="" name="pos_id" id="pos_id<?php echo $i;?>"  value="<?php echo $pos_id; ?>" >
							<!-- <button type="button" class="btn btn-default"  onclick="saveserial('<?php echo $i;?>');">Add</button> -->
                    </td>
            </tr>
           <?php	
		   }   
	   ?>
       
</table>
<?php }else{  echo "2";
}
	
	?>
	
