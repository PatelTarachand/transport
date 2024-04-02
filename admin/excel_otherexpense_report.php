<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "other_expense_entry";
$tblpkey = "other_exp_id";
$pagename = "other_expense_entry.php";
$modulename = "Other Expenses Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$cond= "where 1=1";

if(isset($_GET['search']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	$todate = trim(addslashes($_GET['todate']));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}


if($fromdate!='' && $todate!=''){

    $cond .= " and service_date between '$fromdate' and '$todate'";
}else{
    $fromdate= date('Y-m-d');
$todate=date('Y-m-d');
}

if($otherid!=''){

    $cond .= " and otherid ='$otherid'";
}else{
    $otherid='';
}

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="office_expense_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
											<thead>
										<tr>
                                        <th>Sno</th>  
                                            <th> Date</th> 
                                            <th>Truck No.</th> 
                                              <th>Office Expense</th> 
                                            <th>Amonut</th> 
                                            <th>Driver name </th>
                                        	<th>Pay Mode</th>                                            
                                            <!--<th>Meater Reading</th> -->
                                            <th>Billing Type</th> 
                                            <th>Narration</th>  
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
                                   
								
                                   
                                   
									$sql = "select * from other_expense_entry $cond  order by otherid  desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
                                        $office_headname = $cmn->getvalfield($connection,"otherexp_master","headname","otherid='$row[otherid]'"); 
                                        $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
									
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 

										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
									
									?>
										<tr>
                                        <td><?php echo $slno; ?></td>
                                            <td><?php echo dateformatindia($row['service_date']);?></td>   
                                              <td><?php echo ucfirst($truckno);?></td>
                                                <td><?php echo ucfirst($office_headname);?></td>             
                                               
                                                                    
                                          
                                         
                                            <td><?php echo $row['amount'];?></td>
                                           
                                            <td><?php echo ucfirst($driver);?></td> 
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                            <!--<td><?php echo ucfirst($row['meater_reading']);?></td> -->
                                             <td><?php echo $row['bill_type'];?></td>
                                          
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                            
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>


