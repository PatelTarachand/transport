<?php 
error_reporting(0);
include("dbconnect.php");

$tblname = "trip_entry";
$tblpkey = "trip_id";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_return_entry".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);
$tblname = 'voucher_entry';
$tblpkey = 'bulk_vid';
$pagename  ='payment_expenses.php';
$modulename = "Payment Voucher ";
$crit = "";
if ($_GET['billing_type'] != '') {
	$billing_type=$_GET['billing_type'];
}

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	    $fromdate =$_GET['fromdate'];
         
    $todate =$_GET['todate'];
     $billing_type = trim(addslashes($_GET['billing_type']));
 if($billing_type == 'Consignor'){
        $consignorid = trim(addslashes($_GET['partyid']));
    }else {
         $consigneeid = trim(addslashes($_GET['partyid']));
    }
}
else
{
    $fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
	
}

if(isset($_GET['billing_type']))
{
	$billing_type=trim(addslashes($_GET['billing_type']));
}
else
$billing_type='';


  if(isset($_GET['tp_id']))
 {
    $tp_id=trim(addslashes($_GET['tp_id']));
 }
 else
 $tp_id='';
 
 


if($fromdate !='' && $todate !='')
{
		$crit.="pay_date BETWEEN  '$fromdate' and  '$todate' ";
		
}

if($billing_type !='') {
	$crit .=" and billing_type='$billing_type'";
  //echo $crit;
}
 if($consignorid !=''){
$crit .="and consignorid='$consignorid'";
 } 
 if($tp_id !=''){
      $crit .="and tp_id='$tp_id'  ";
 }
 
?>
<<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
   <title>
	</title>
	<style type="text/css">
		table, th, td {
  border: 1px solid;
}	
	</style>
</head>
<body>
<table>
									<thead>
										<tr>
                                        <th>Sno</th>
                 
                 <th>Voucher No </th>
                   <th>Paid to </th> 
                 <!--<th>Truck No. </th>-->
                 <!--<th>Qty/MT/DayTrip</th>-->
                 <!--<th>Rate </th>-->
                 <th>Payment Date </th>
                 <th>Remark </th>
                 
                 <th>Net Amount</th>
                                                
										</tr>
									</thead>
									<tbody>
                                    <?php $sn=1;
										
										//echo"select * from payment_recive where $crit order by payment_recive_id desc";
                            $sql=mysqli_query($connection,"select * from voucher_entry where $crit order by bulk_vid desc");
                            while($row=mysqli_fetch_array($sql)){

								// $driver_name = $cmn->getvalfield($connection, "driver_master", "driver_name", "driver_id='$row[driver_id]'");
							// 	$tp_name= $cmn->getvalfield($connection, "tp_master", "tp_name", "tp_id='$row[tp_id]'");
							// 	$trip_no = $cmn->getvalfield($connection, "trip_entry", "trip_no", "trip_id='$row[trip_id]'");
							// 		$consignor= $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id='$row[consignorid]'");
							// 		$consigneeid= $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id='$row[consigneeid]'");
							// 		$frieght_amt = $cmn->getvalfield($connection, "trip_entry", "frieght_amt", "trip_id='$row[trip_id]'");	
							// $trip_expenses = $cmn->getvalfield($connection, "trip_entry", "trip_expenses", "trip_id='$row[trip_id]'");	
							// $loding_date = $cmn->getvalfield($connection, "trip_entry", "loding_date", "trip_id='$row[trip_id]'");	
								$final_total = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$row[bulk_vid]'");	
                           ?>
                      <tr>
                        <td><?php echo $sn++;?></td> 
                     
													<td><?php echo $row['voucher_no'];?></td> 
												  <td><?php echo $row['paid_to'];?></td> 
												  <td><?php echo dateformatindia($row['pay_date']);?></td>
												  <td><?php echo $row['remark'];?></td>
												  	<td><?php echo $final_total;?></td>
                           
                       
                        <?php } ?>
							
									</tbody>
								</table>
</body>
</html>
