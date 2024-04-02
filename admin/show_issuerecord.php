<?php
error_reporting(0);
include("dbconnect.php");
$issueid = $_REQUEST['issueid'];

if ($issueid != 0) {
  $issueid = $_REQUEST['issueid'];
} else {
  $issueid = 0;
}

$sqlget = mysqli_query($connection, "select * from issueentrydetail where issueid='$issueid' ORDER BY `issuedetailid` DESC");
$sn = 1;
$amount = 0;
?>


<table width="100%" class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th width="3%">SN</th>
      <th width="25%">Item Name</th>
      <th width="8%">Unit Name</th>
     
      <th width="8%">Qty.</th>
      
      <th width="15%">Return Category</th>
          
      <th width="15%">Return Item</th>
     
      <th width="15%">Remark</th>
      <th width="9%" class="center">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $rowcount = mysqli_num_rows($sqlget);
    while ($rowget = mysqli_fetch_assoc($sqlget)) {

      $issuedetailid = $rowget['issuedetailid'];
        $returnitem_id = $rowget['returnitem_id'];
      $itemid = $rowget['itemid'];
      $issueid = $rowget['issueid'];
      $unitname = $rowget['unitname'];
      $is_rep = $rowget['is_rep'];
      $excrec = $rowget['excrec'];
      $qty = $rowget['qty'];
      $remark1 = $rowget['remark1'];
      $stock = $rowget['stock'];
       $purdetail_id = $rowget['purdetail_id'];


      $itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id='$purdetail_id'");

      $itemcategoryname = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid'");
         
		// $serial_nopur = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$purdetail_id'");
	
    $itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purdetail_id='$rowget[returnitem_id]'");
    $returnitem = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid' and itemcatid!='19'");
    $item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$rowget[itemid]' and itemcatid!='19'");
                     
    $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$rowget[itemcatid]' ");
    ?>

      <tr>

        <td><?php echo $sn; ?></td>
        <td><?php echo $itemcategoryname; ?>/<?php echo $item_category_name; ?></td>
        <td><?php echo $unitname; ?></td>
        
        <td><?php echo $qty;  ?></td>
       
        <td><?php echo $is_rep;  ?></td>
       <?php if($is_rep!='For New Vehicle'){?>
         <td><?php echo $returnitem; ?>/<?php echo $item_category_name; ?>/<?php echo $item_category_name ?></td>
         <?php }else{ ?>
               <td></td>
        <?php  }
         ?>
         
        <td><?php echo $remark1;  ?></td>
        <td class="center"><a class="btn btn-danger btn-small" onClick="deleterecord('<?php echo $issuedetailid; ?>');"> X </a>
        </td>

      </tr>



    <?php


      $sn++;
    }





    ?>

    <!--                                
<?php if ($rowcount > 0) { ?>
      <tr>

      <td colspan="9"><p align="center" id="otpid" > <a  class="btn btn-danger"  onclick="edit(1)"> Send OTP</a></p>
 <p id="saveid" style="display:none"> <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" style="margin-left:315px">
      <a href="issueentry.php" class="btn btn-primary" > Reset </a>

      

       </p> </td>

      </tr>      <?php } ?>                                 -->





  </tbody>

</table>