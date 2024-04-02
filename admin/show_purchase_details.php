<?php error_reporting(0);
include("dbconnect.php");
$item_id = $_REQUEST['item_id'];
$issuedetailid = $_GET['issuedetailid'];


 $unit_id = $cmn->getvalfield($connection,"item_master","unit_id","item_id='$item_id'");
 $item_cat_id = $cmn->getvalfield($connection,"item_master","item_cat_id","item_id='$item_id'");

 $unit_name = $cmn->getvalfield($connection,"unit_master","unit_name","unit_id='$unit_id'");
 $stock = $cmn->getvalfield($connection,"issueentrydetail","sum(stock)","item_id='$item_id'");

// $unit_id = $cmn->getvalfield($connection,"item_master","unit_id","item_id='$item_id'");
 $issuedetailid = $cmn->getvalfield($connection,"issueentrydetail","issuedetailid","item_id='$item_id'");
 $qty = $cmn->getvalfield($connection,"issueentrydetail","qty","issuedetailid='$issuedetailid'");
 echo  $unit_name ."|".$stock."|".$qty;

?>