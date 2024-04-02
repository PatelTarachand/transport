<?php  error_reporting(0);
include("dbconnect.php");

$qty = trim(addslashes($_REQUEST['qty']));
$purchaseid = trim(addslashes($_REQUEST['purchaseid']));
$itemid = trim(addslashes($_REQUEST['itemid']));
$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
$i = trim(addslashes($_REQUEST['i']));

?>

<?php 
	$slno = 1;
if($itemcatid=='19'){ ?>
<table class="table table-bordered">
		<tr>
        <th>#</th>
         <th>Tyre Name</th>
         <th>Serial No</th>
        </tr>
        
      
	<!-- <button type="button" class="btn btn-default"  onclick="saveserial('<?php echo $i;?>');">Add</button> -->
                            <?php $sel1 = "select * from purchaseorderserial  where purchaseid='$purchaseid' ";
            $res1 =mysqli_query($connection,$sel1);
            while($row1 = mysqli_fetch_assoc($res1)){
                $itemcategoryname = $cmn->getvalfield($connection, "items", "item_name", "itemid ='$row1[itemid]'");
                $itemcatid1 = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$row1[itemid]'");

                $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid1'");
                
                ?>
												<td><?php echo $slno++; ?></td>
                                                <td><?php echo $itemcategoryname ;?>/<?php echo $item_category_name ;?>
                                              </td>
                                            <td><?php echo ltrim($row1['serial_no']);?>
                                              </td>
             
            </tr>
           <?php	
		   }     
	   ?>
       
</table>
<?php }else{  echo "2";
}
	
	?>
	
