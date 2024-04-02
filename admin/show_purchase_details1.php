<?php error_reporting(0);
include("dbconnect.php");
 $purdetail_id = $_REQUEST['purdetail_id'];
 $issue_cate = $_REQUEST['issue_cate'];
// $issuedetailid = $_GET['issuedetailid'];

 $itemid = $cmn->getvalfield($connection,"purchasentry_detail","itemid","purdetail_id='$purdetail_id'");
   $serial_no = $cmn->getvalfield($connection,"purchasentry_detail","serial_no","purdetail_id='$purdetail_id'");
 $purchaseid = $cmn->getvalfield($connection,"purchasentry_detail","purchaseid","itemid='$itemid'");
 $unitid = $cmn->getvalfield($connection,"items","unitid","itemid='$itemid'");
 $item_cat_id = $cmn->getvalfield($connection,"items","itemcatid","itemid='$itemid'");

 $unit_name = $cmn->getvalfield($connection,"m_unit","unitname","unitid='$unitid'");
//  $qty = $cmn->getvalfield($connection,"purchasentry_detail","sum(qty)","itemid='$itemid'");
  $qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "itemid='$itemid' && serial_no='$serial_no'");
   //$qty = $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "purchaseid='$purchaseid' && itemid='$itemid'");
   $purdetail_id1 = $cmn->getvalfield($connection, "purchasentry_detail", "purdetail_id", "purchaseid='$purchaseid' && itemid='$itemid' && serial_no='$serial_no'");
 $issuedetailid = $cmn->getvalfield($connection,"issueentrydetail","issuedetailid","itemid='$itemid'");

//  $issueqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid '");
   $materialinqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid' && is_rep='For New Vehicle' &&  purdetail_id='$purdetail_id1'");
     $materialinqty1 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid' && is_rep='Repaired' &&  purdetail_id='$purdetail_id1'");
        $materialinqty2 = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid' && is_rep='Exchnage' &&  purdetail_id='$purdetail_id1'");
 
  //$stock = $materialinqty1;

 
 if($issue_cate=='New Item'){
 $stock = $qty- $materialinqty;

}

 if($issue_cate=='Repaired'){
 $stock = $qty- $materialinqty1;

}

 if($issue_cate=='Exchnage'){
 $stock = $qty- $materialinqty2;

}




 
 

 echo  $unit_name ."|".$stock."|".$item_cat_id;

?>