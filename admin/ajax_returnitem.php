<?php
include("dbconnect.php");
 $truckid= addslashes($_REQUEST['truckid']);
 $itemcatid= addslashes($_REQUEST['itemcatid']);
 
 ?>
 
   <?php
   
    $resprod = mysqli_query($connection,"select * from purchasentry_detail  order by itemid");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
											
												$item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$rowprod[itemid]'");
													$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid='$rowprod[itemid]'");
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid'");
													 $is_rep = $cmn->getvalfield($connection, "issueentrydetail", "is_rep", "returnitem_id='$rowprod[purdetail_id]'");
												

                                
                                ?>
                                <?php if($is_rep!='Scrap'){?>
                                <option value="<?php echo $rowprod['purdetail_id']; ?>"><?php echo $item_name; ?>/<?php echo $item_category_name; ?>/<?php echo $rowprod['serial_no']; ?></option>
                                <?php
                                }}
                                ?>
                                
                                
