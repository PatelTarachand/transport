<?php 
error_reporting(0);
include("dbconnect.php");
$pagename = "purchaseentry.php";
$tblname ="purchase_entry";
$tblpkey= "purchaseid";
$modulename = "Purchase Entry";

  $purchaseid = $_REQUEST['purchaseid'];
  $itemcatid = $_REQUEST['itemcatid'];
 
    $bill_type = $_REQUEST['bill_type'];
  $sup_id = $_REQUEST['sup_id'];
   // $purchase_date = $_REQUEST['purchase_date'];

if ($purchaseid != 0) {
   $purchaseid = $_REQUEST['purchaseid'];
} else {
   $purchaseid = 0;
}

if ($sup_id != 0) {
   $sup_id = $_REQUEST['sup_id'];
} else {
   $sup_id = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title></title>
</head>
<body>



<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>S.No.</th>  
                                            <th>ITEM NAME</th>
                                               <?php if($itemcatid==19){?>
                                              <th>TYRE NO.</th> 
                                              <?php } else {?>
                                              <?php } ?>
                                        	<th>QTY</th>
                                            <th>RATE</th>
                                            <th>TOTAL AMOUNT</th>
                                            <?php if($bill_type=="challan"){?>
                                            
                                           
                               <?php } else {?>
                                <th>GST %</th>
                               <?php } ?>
                                            <th>NET AMOUNT</th>
                                         
                                            <th>ACTION</th>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
               //   echo "select * from purchasentry_detail  where purchaseid='$purchaseid'";
                              $sel = "select * from purchasentry_detail  where purchaseid='$purchaseid'  ORDER BY `purdetail_id` DESC";
                       
                           // echo "select * from purchase_entry where sup_id=$sup_id";

                     
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
								// $unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unitid='$row[unitid]'");
								$itemcategoryname = $cmn->getvalfield($connection, "items", "item_name", "itemid ='$row[itemid]'");
									$itemid= $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id ='$row[purdetail_id]'");
									$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
				$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid'");
           
     


            
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($itemcategoryname);?>/<?php echo ucfirst($item_category_name);?></td>
                                           <?php if($itemcatid==19){?>  <td>        
                                               <?php $sel1 = "select * from purchaseorderserial  where purchaseid='$purchaseid' and itemid ='$itemid'";
            $res1 =mysqli_query($connection,$sel1);
            while($row1 = mysqli_fetch_assoc($res1)){?>
            
                                            <?php echo ltrim(','.$row1['serial_no']);?>
                                             <?php } ?> </td>
                                                <?php } else{ ?>
                                                   <?php } ?>
                                            <td><?php echo ucfirst($row['qty']);?></td>
                                            <td><?php echo ucfirst($row['rate']);?></td>
                                            <td><?php echo number_format($row['total_amt'],2);?></td>
                                             <?php if($bill_type=="challan"){?>
                                            
                                              <?php } else {?>
                                              <td><?php echo number_format($row['gst'],2);?></td>
                                                <?php } ?>
                                            <td><?php echo number_format($row['nettotal'],2);?></td>

                                           <td class=''>
                                           <!-- <a href= "?edit=<?php echo ucfirst($row['purchaseid']);?>"><img src="../img/b_edit.png" title="Edit"></a> -->
                                           <a class="btn btn-warning" onClick="modelFun('<?php echo $row['purdetail_id']; ?>','<?php echo $row['itemid']; ?>','<?php echo $row['qty']; ?>','<?php echo $row['rate']; ?>','<?php echo $row['total_amt']; ?>','<?php echo $row['gst']; ?>','<?php echo $row['nettotal'];?>','<?php echo $row['purdetail_id']; ?>')">  <i class="icon-edit"></i></a>

                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['purdetail_id']; ?>')"  ><img src="../img/del.png" title="Delete" ></a>
                                           </td>
										</tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['total_amt'];
                              $total+=$row['nettotal'];

									}
									?>
									
									
									    <?php if($bill_type=="challan"  && $itemcatid==19){?>
                                            
                                           	<tr><th></th><th></th><th></th><th></th><th>Total</th><th><?php echo number_format($totalamt,2);?></th><th><?php echo number_format($total,2);?></th><th></th></tr>
                               <?php } if($bill_type=="Invoice" && $itemcatid==19) {?>
                             	<tr><th></th><th></th><th></th><th></th><th>Total</th><th><?php echo number_format($totalamt,2);?></th><th></th><th><?php echo number_format($total,2);?></th><th></th></tr>
                         
                          
                               <?php } ?>
									
									</tbody>
									
								</table>
                                </div>
					</div>
				</div>
				
   </body>
</html>
   <script type="text/javascript">


      
 function getTotal() {

               var qty = parseFloat(jQuery('#qty').val());
               var rate = parseFloat(jQuery('#rate').val());
               var disc_rs = parseFloat(jQuery('#disc_rs').val());
               var total_amt = parseFloat(jQuery('#total_amt').val());




               if (!isNaN(qty) && !isNaN(rate)) {
                  total = qty * rate;
                   //alert(total);
jQuery('#total_amt').val(total);
               }
               if (!isNaN(disc_rs)) {
                  total = qty * rate;
                  total = total - disc_rs;
                  jQuery('#total_amt').val(total);
               }
               // alert(total_amt);
               jQuery('#total_amt').val(total);
            }
   </script>