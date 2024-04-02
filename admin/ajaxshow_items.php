<?php
include("dbconnect.php");
 $issue_cate= addslashes($_REQUEST['issue_cate']);
 ?>
  <option value="">-Select-</option>
 <?php
if($issue_cate=='New Item'){ ?>
   <?php
                                //where cat_id not in (5,8)
                                $resprod = mysqli_query($connection,"select * from purchasentry_detail  order by itemid ");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
	$itemid =  $rowprod['itemid'];
										
												$item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid' and itemcatid!='19'");
													$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid='$itemid'");
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid' ");
													 
   $qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "itemid='$rowprod[itemid]'");
  
   $materialinqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid' && is_rep='For New Vehicle'");
 
 

 
 
 $stock = $qty-$materialinqty;
if($itemcatid!='19'){
if($stock>0){
                                
                                ?>
                                <option value="<?php echo $rowprod['purdetail_id']; ?>"><?php echo $item_name; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }}
                                ?>  
<?php } }?>
 <?php
if($issue_cate=='Repaired'){ ?>
    <?php
                                //where cat_id not in (5,8)
                                //echo "select * from  issueentrydetail where is_rep='Repaired' order by itemid";
                                $resprod = mysqli_query($connection,"select * from  issueentrydetail where is_rep='Repaired' and is_used='0'  order by itemid");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
										$itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id='$rowprod[returnitem_id]'");
											$returnitem = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid' and itemcatid!='19'");
										
										
										
										
												$item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$rowprod[itemid]' and itemcatid!='19'");
												
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$rowprod[itemcatid]' ");
														//$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$rowprod[purdetail_id]'");
													$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$rowprod[returnitem_id]'");

                                
                                ?>
                                <option value="<?php echo $rowprod['returnitem_id']; ?>"><?php echo $returnitem; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }
                                ?>  
<?php } ?>

 <?php
if($issue_cate=='Exchange'){ ?>
   <?php
                                //where cat_id not in (5,8)
                                $resprod = mysqli_query($connection,"select * from issueentrydetail where is_rep='Exchange'  order by itemid");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
												$itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id='$rowprod[returnitem_id]'");
											$returnitem = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid' and itemcatid!='19'");
										
										
										
										
												$item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$rowprod[itemid]' and itemcatid!='19'");
												
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$rowprod[itemcatid]' ");
														//$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$rowprod[purdetail_id]'");
													$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$rowprod[returnitem_id]'");

                                
                                ?>
                                <option value="<?php echo $rowprod['returnitem_id']; ?>"><?php echo $returnitem; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }
                                ?>  
<?php } ?>