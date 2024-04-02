<?php 
include("dbconnect.php");
$tblname = 'consignor_payment';
$tblpkey = 'payid';
$pagename  ='excel_consignor_report.php';
$modulename = "Consignor  Report";
$crit = "";
if(isset($_GET['fromdate']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	
}
if(isset($_GET['todate']))
{
	
	$todate = trim(addslashes($_GET['todate']));
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}


 


if($fromdate !='' && $todate !='')
{
			$crit.=" and receive_date between '$fromdate' and '$todate' ";	
}

 

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" border="1">
									<thead>
										<tr>
                                            <th>SN</th>  
                                            <th>Consignor Name</th>
                                            <th>Bill No</th>
                                        	 
                      					           	<th>TDS Amount</th>				    
                                              <th>Pay Amount</th>
                                              <th>Payment Receive No</th>
                                              <th>Pay Date</th>
                                            
                      					            	<th>Narration</th>
                                                                               	 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										//$cond="where createdby='$userid' ";
										$cond="where 1=1 ";		
									}
									
									
									 $sel = "SELECT * FROM `consignor_payment` WHERE compid='$compid' && tdsamt<>0 && sessionid=$sessionid order by payid desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									$consignorname =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");	
									$billno =  $cmn->getvalfield($connection,"bill","billno","billid='$row[billid]'");	
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                              <td><?php echo $consignorname;?></td> 
                          <td><?php echo $billno;?></td> 
                          <td><?php echo $row['tdsamt'];?></td>
					         <td><?php echo number_format(round($row['payamount']),2);?></td>
                             <td><?php echo $row['payment_rec_no'];?></td>
                             
                            <td><?php echo dateformatindia($row['receive_date']);?></td>  
                           <td><?php echo $row['narration'];?></td>
                                                  
                            
                            
                          <!--  <td><a href="pdf_paymentreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                    </td> -->
                                              
                        </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>


<script>window.close();</script>