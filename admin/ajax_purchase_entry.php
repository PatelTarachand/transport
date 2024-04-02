<?php 
include("dbconnect.php");
   $current_date=date('Y-m-d');
  
   
   $itemid=$_REQUEST['itemid'];

   $unitid=$_REQUEST['unitid'];
 $gst=$_REQUEST['gst'];
   $qty=$_REQUEST['qty'];
   $rate=$_REQUEST['rate'];
   $purdetail_id=$_REQUEST['purdetail_id'];  
   $purchaseid = $_REQUEST['purchaseid'];
   $total_amt=$_REQUEST['total_amt'];
   $nettotal=$_REQUEST['nettotal'];
    $serial_no=$_REQUEST['serial_no'];
       $itemcateid =  $cmn->getvalfield($connection, "items", "itemcatid", "itemid='$itemid'");
      $itemcateid =  $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcateid'");
    
   // $grand_total = $_REQUEST['grand_total'];
   //   $gst=$_REQUEST['gst'];
   if($qty !='')
   
{
	if($purdetail_id==0){

echo "INSERT into purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress'";
   	mysqli_query($connection,"INSERT into purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress'");

      $action=1;
   $process = "insert";
}
else
{
echo "update  purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress' WHERE purdetail_id = '$purdetail_id'";
   mysqli_query($connection,"update  purchasentry_detail set purchaseid='$purchaseid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress' WHERE purdetail_id = '$purdetail_id'");


   $action=2;
   $process = "update";
}	
}


?>