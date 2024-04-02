<?php 
include("dbconnect.php");
   $current_date=date('Y-m-d');
  
   
   $itemid=$_REQUEST['itemid'];

   $unitid=$_REQUEST['unitid'];
 $gst=$_REQUEST['gst'];
   $qty=$_REQUEST['qty'];
   $rate=$_REQUEST['rate'];
   $disc=$_REQUEST['disc'];
   $saledetail_id=$_REQUEST['saledetail_id'];  
   $saleid = $_REQUEST['saleid'];
   $total_amt=$_REQUEST['total_amt'];
   $nettotal=$_REQUEST['nettotal'];
    $serial_no=$_REQUEST['serial_no'];
    $grandtotal=$_REQUEST['grandtotal'];
       $itemcateid =  $cmn->getvalfield($connection, "items", "itemcatid", "itemid='$itemid'");
      $itemcateid =  $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcateid'");
    
   // $grand_total = $_REQUEST['grand_total'];
   //   $gst=$_REQUEST['gst'];
   if($qty !='')
   
{
	if($saledetail_id==0){

// echo "INSERT into saleentry_detail set saleid='$saleid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress',disc='$disc'";
   	mysqli_query($connection,"INSERT into saleentry_detail set saleid='$saleid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress',disc='$disc',grandtotal='$grandtotal'");

      $action=1;
   $process = "insert";
}
else
{
echo "update  saleentry_detail set saleid='$saleid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress',disc='$disc' WHERE saledetail_id = '$saledetail_id'";
   mysqli_query($connection,"update  saleentry_detail set saleid='$saleid',serial_no='$serial_no', gst='$gst',itemid='$itemid', unitid='$unitid',qty='$qty',rate='$rate',total_amt='$total_amt',nettotal='$nettotal',sessionid='$sessionid',createdate='$createdate',ipaddress='$ipaddress',disc='$disc',grandtotal='$grandtotal' WHERE saledetail_id = '$saledetail_id'");


   $action=2;
   $process = "update";
}	
}


?>