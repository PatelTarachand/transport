<?php  
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Report";

if(isset($_GET['month']))
{
	$month = trim(addslashes($_GET['month']));
}
else
{
	$month = date('m');	
}

if(isset($_GET['year']))
{
	$year = trim(addslashes($_GET['year']));
}
else
{
	$year = date('Y');	
}

if($month !='')
{
	$fromdate = date("$year-$month-01");	
 	$searchdate = date("Y-m-t", strtotime($fromdate));
}

$x = "$month";
$monthNumm  = (int)$x;
$dateObj   = DateTime::createFromFormat('m', $monthNumm);
$monthName = $dateObj->format('F'); // March

//echo $monthName;die;

$enddate = date("t", strtotime($fromdate));
// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered" border="2">
									<thead>
		<tr>
			<tr><th colspan="6"><strong><?php echo $cmn->getvalfield($connection,"m_company","cname","1='1'"); ?> : ALL CASH OPENING BALANCE DETAILS</strong></th> </tr>																								
			<tr><th colspan="6">MONTH OF :<?php echo $monthName?>- 2018</th></tr>	
			<tr><th colspan="6">CASH OPENING BALANCE. SUMMARY</th></tr>	                                   
		</tr>
								<tr>
                                               
                                               <th width="18%">Date</th>
                                                <th width="24%">Opening Bal.</th>
                                                <th width="19%">Cement Advance </th>
                                                <th width="16%">Clinker Advance </th>
                                                <th width="11%">Other Income</th>
                                                <th width="11%">Other Expense</th>                                                                              					 								</tr>
									</thead>
                                    <tbody>
                                    <?php 
							$cash_opening=0;
						$cementadv=0;
						$clinkeradv=0;
						$tot_cementadv=0;
						$tot_clinkeradv=0;
						
						$otherincome=0;
						$otherexpense=0;
						$tot_otherincome=0;
						$tot_otherexpense=0;
						$net_cash_opening=0;
								
                              for($i=$enddate;$i>=1;$i--)    
							  {	
							$yesterday = date('Y-m-d', strtotime($searchdate . ' -1 day'));  
							  							  
							$cash_opening = $cmn->getcashopeningplant($connection,$yesterday);
							
							$cementadv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=2 && adv_date='$searchdate'");
							
							$clinkeradv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=1 && adv_date='$searchdate'");
						
						$otherincome = $cmn->getvalfield($connection,"otherincome as A left join m_userlogin as B on A.createdby = B.userid","sum(incomeamount)","payment_type='cash' && paymentdate='$searchdate' && branchid=1");
						
						$otherexpense = $cmn->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate='$searchdate' && branchid=1");  
							  ?>
                            <tr>                            	
                                    <td><?php echo $cmn->dateformatindia($searchdate); ?></td>
								<td style="text-align:right;"><?php echo $cash_opening; ?></td>
                                <td style="text-align:right;"><?php echo $cementadv; ?></td>
                                <td style="text-align:right;"><?php echo $clinkeradv; ?></td>
                                
                                <td style="text-align:right;"><?php echo $otherincome; ?></td>
                                <td style="text-align:right;"><?php echo $otherexpense; ?></td>                                  
                            </tr>
                                <?php 
								$searchdate = date('Y-m-d', strtotime('-1 day', strtotime($searchdate)));
									$tot_cementadv += $cementadv;
									$tot_clinkeradv += $clinkeradv;
									$tot_otherincome += $otherincome;
									$tot_otherexpense += $otherexpense;
									$net_cash_opening += $cash_opening;
							  }
								?>
                                    
                                   <tr>
                   
                        <th style="color:#FFF; background-color:#00F; text-align:right;">Total</th>
                         <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_cash_opening,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_cementadv,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_clinkeradv,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_otherincome,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($otherexpense,2); ?></th>                    
                </tr>  	
                                    
									</tbody>
							</table>
                            

                
                            
                            


<script>window.close();</script>