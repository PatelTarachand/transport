<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "emp_payment";
$tblpkey = "emppayment_id";
$pagename = "emp_paymentreport.php";
$modulename = "Payment Entry Detail";

if (isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
else
  $action = 0;


if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
  $fromdate =$_GET['fromdate'];
  $todate =  $_GET['todate'];
  $empid = $_GET['empid'];
  
} else {
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
 
  $empid = '';
  
}


$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and  pay_date between '$fromdate' and '$todate' ";
}

if ($empid != '') {
  $crit .= " and empid='$empid' ";
}



header("Content-type: application/vnd-ms-excel");
$filename = "Emp paymentreport Report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<!doctype html>

<html>
<head>
</head>
<body>

	<table border="1">

									<thead>
										<tr>   
                                        <th>Sno</th>  
                                            <th>Payment Date</th> 
                                            <th>Employee Name</th> 
                                            <th>Expense Head</th> 
                                          
                                            <th>Amonut</th> 
                                          
                                        	<th>Pay Mode</th>                                            
                                        
                                            <th>Narration</th> 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
                    $slno = 1;
      //echo "select * from emp_payment $crit order by emppayment_id desc";die;
       $sql = "select * from emp_payment $crit order by emppayment_id desc";
       $res =mysqli_query($connection,$sql);
       while($row = mysqli_fetch_array($res))
       {
         $truckno = $cmn->getvalfield($connection,"m_truck","truckno","empid='$row[empid]'");
         $exp_head = $cmn->getvalfield($connection,"exp_head_master","exp_head","exheadid='$row[exheadid]'"); 
                             $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
       
         $empname = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' "); 

         $driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
       ?>
         <tr>
                                 <td><?php echo $slno; ?></td>
                                 <td><?php echo dateformatindia($row['pay_date']);?></td>   
                                 <td><?php echo ucfirst($empname);?></td>                                        
                                 <td><?php echo ucfirst($exp_head);?></td>
                                 <td><?php echo ucfirst($row['amount']);?></td>
                                 <td><?php echo ucfirst($row['payment_type']);?></td> 
                              
                                
                                  <td><?php echo ucfirst($row['narration']);?></td> 
                     
                        
                        </td>
                      </tr>

                    <?php

                      $slno++;
                    }

                    ?>


										

									</tbody>

									

								</table>
	</body>

   
	</html>

