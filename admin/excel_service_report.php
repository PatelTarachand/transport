<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "sservice_entry";
$tblpkey = "service_id";
$pagename = "service_report.php";
$modulename = "Service Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


$fromdate= $_GET['fromdate'];
$todate= $_GET['todate'];
$truckid= $_GET['truckid'];
$meachineid= $_GET['meachineid'];
$headid= $_GET['headid'];

$cond= "where 1=1";


	$fromdate = trim(addslashes($_GET['fromdate']));
	$todate = trim(addslashes($_GET['todate']));



if($fromdate!='' && $todate!=''){

    $cond .= " and service_date between '$fromdate' and '$todate'";
}else{
    $fromdate= date('Y-m-d');
$todate=date('Y-m-d');
}

if($truckid!=''){

    $cond .= " and truckid ='$truckid'";
}else{
    $truckid='';
}

if($headid!=''){

    $cond .= " and headid ='$headid'";
}
else{
    $headid='';
}

if($meachineid!=''){

    $cond .= " and meachineid ='$meachineid'";
}
else{
    $meachineid='';
}


// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="service_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
											<thead>
										<tr>
                                      <th>Sno</th>  
                                            <th>Truck No</th>
                                        	<th>Driver Name </th>
                                            <th>Date</th>
                                            <th> Mechanic Name </th>
                                            <th>Service Head</th>
                                            <th>Amount</th>
                                            <th>Payment type</th>
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
                                        <?php
									$slno=1;
                                //    echo "select * from service_entry $cond order by service_id desc";die;
									$sel = "select * from service_entry $cond order by service_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{

										$truckno=$cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
										$maintenance=$cmn->getvalfield($connection,"head_master","headname","headid='$row[headid]'");
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' && designation='1' "); 
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno;?></td>
                                            <td><?php echo ucfirst($driver);?></td>
                                            <td><?php echo dateformatindia($row['service_date']);?></td>
                                          
                                            <td><?php echo $mechanic_name;?></td>
											<td><?php echo $maintenance;?></td>
                                            <td><?php echo $row['amount'];?></td>
											<td><?php echo $row['payment_type'];?></td>
                                           
                                            <!-- <td><?php echo $row['payment_mode'];?></td> -->
                                            
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
									</tbody>
									
								</table>


