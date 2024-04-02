<?php 
error_reporting(0);
include("dbconnect.php");
$fromdate= $_GET['fromdate'];
$todate= $_GET['todate'];
$truckid= $_GET['truckid'];
$m_id= $_GET['m_id'];
$mid= $_GET['mid'];

$cond= "where 1=1";

if($fromdate!='' && $todate!=''){

    $cond .= " and date between '$fromdate' and '$todate'";
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
	$filename ="Maintenance_report.xls";
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
                                            <th> Maintenance / Spare</th>
                                            <th>Amount</th>
                                            <th>Payment type</th>
                                            <th>Payment Mode</th>
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
                                 
									$sel = "select * from maintenance_entry $cond order by main_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{

										$truckno=$cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
										$maintenance=$cmn->getvalfield($connection,"head_master","headname","headid='$row[headid]'");
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno;?></td>
                                            <td><?php echo ucfirst($driver);?></td>
                                            <td><?php echo dateformatindia($row['date']);?></td>
                                          
                                            <td><?php echo $mechanic_name;?></td>
											<td><?php echo $maintenance;?></td>
                                            <td><?php echo ucfirst($row['amount']);?></td>
											<td><?php echo ucfirst($row['payment_type']);?></td>
                                           
                                            <td><?php echo ucfirst($row['payment_mode']);?></td>
                                            
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>


