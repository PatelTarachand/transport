<?php  error_reporting(0);
include("dbconnect.php");
$pagename  = 'excel_inc_exp_report.php';
$modulename = "Expenses Report ";



if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	   $fromdate =$_GET['fromdate'];
         
    $todate =$_GET['todate'];
    // $main_head_id = trim(addslashes($_GET['main_head_id']));
	$driver_id = trim(addslashes($_GET['driver_id']));
}
else
{
    $fromdate = date('Y-m-01');
	$todate = date('Y-m-d');
	
}

if(isset($_GET['inc_ex_id']))
{
	$inc_ex_id=trim(addslashes($_GET['inc_ex_id']));
}
else
$inc_ex_id='';
if(isset($_GET['category']))
{
	$category=trim(addslashes($_GET['category']));
}
else
$category='';

if($fromdate !='' && $todate !='')
{
		$crit.=" where exp_date BETWEEN  '$fromdate' and  '$todate' ";
		//echo $crit;
}

if($inc_ex_id !='') {
	$crit .=" and inc_ex_id='$inc_ex_id'";

}

if($category !='') {
	$crit .="and category='$category'  ";
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="excel_inc_exp_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);
?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
                               
								      <tr>
                                      <th>Sno </th>

<th>Expense Date </th>
  <th>Trip No./LR No. </th> 
  <th>Vehicle No. </th> 
<!--<th>Party Billing Type </th> -->
<th>Category</th>
<!--<th>Qty/MT/DayTrip</th>-->
<th>Income / Expense Head </th>
<!--<th>Frieght Amt </th>-->
<!--<th>Trip Expenses </th>-->
<th> Amount </th>
                                            
                                     </tr>
									</thead>
                                    <tbody>
                                    <?php
                   	     $sn=1;  
                       
                  $sel = "SELECT * from trip_expenses  $crit";
        $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
           
//  $trip_no=$cmn->getvalfield($connection,"trip_entry","trip_no","trip_id='$row[trip_id]'");   
//  $loding_date=$cmn->getvalfield($connection,"trip_entry","loding_date","trip_id='$row[trip_id]'");   
  $truckid=$cmn->getvalfield($connection,"trip_entry","truckid","trip_no='$row[trip_no]'");   
//  $qty_mt_day_trip=$cmn->getvalfield($connection,"trip_entry","qty_mt_day_trip","trip_id='$row[trip_id]'");   
	$truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'");
// $rate=$cmn->getvalfield($connection,"trip_entry","rate","trip_id='$row[trip_id]'");   
// $frieght_amt=$cmn->getvalfield($connection,"trip_entry","frieght_amt","trip_id='$row[trip_id]'");   
// $trip_expenses=$cmn->getvalfield($connection,"trip_entry","trip_expenses","trip_id='$row[trip_id]'");   
$incex_head_name=$cmn->getvalfield($connection,"inc_ex_head_master","incex_head_name","inc_ex_id='$row[inc_ex_id]'");   
$gross_amt=$frieght_amt-$trip_expenses;
 $trip_no=$row['trip_no'];
 $loding_date=$row['loding_date'];
  $amount=$row['amt'];
 $category=$row['category']; 
     $tp_id=$row['tp_id'];   
     $totamount +=$row['amt'];
   
                           ?>
                                <tr>
                                                <td><?php echo $sn++;?></td> 
                                                <!--<td><?php echo date('Y-m-d', $loding_date);?></td>-->
                                                	<td><?php echo date('d-m-Y', strtotime($row['exp_date'])); ?></td>
                                                <td><?php echo $trip_no;?></td>
                                                <td><?php echo $truckno;?></td>
									 			<td><?php echo $category;?></td> 
									 				<td><?php echo $incex_head_name;?></td> 
									 				<!--<td><?php echo $qty_mt_day_trip;?></td> 	<td><?php echo $rate;?></td> 	<td><?php echo $gross_amt;?></td> 	<td><?php echo $tp_amount;?></td> -->
									 			<td><?php echo $amount;?></td> 
                              				


                                               
                                            <?php } ?>
									
                                   							
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>