<?php  error_reporting(0);
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


if($month !='')
{
	$fromdate = date("Y-$month-01");	
 	$todate = date("Y-m-t", strtotime($fromdate));
}
$x = "$month";
$monthNumm  = (int)$x;
$dateObj   = DateTime::createFromFormat('m', $monthNumm);
$monthName = $dateObj->format('F'); // March

//echo $monthName;die;

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));	
}

if(isset($_GET['truckno']))
{
	$truckno = trim(addslashes($_GET['truckno']));
	$truckid = $cmn->getvalfield($connection,"m_truck","truckid","truckno='$truckno'");
}


if($ownerid !='')
{
	$crit = " and ownerid='$ownerid'";
}
if($truckid !='')
{
	$crit .= " and truckid='$truckid'";
}



// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="truckownerreport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%" border="2">
									<thead>
                                   <tr><th colspan="26"><strong>BPS : ALL VEHICLE EXPENCES DETAILS</strong></th> </tr>																								
                                     <tr><th colspan="26">MONTH OF :<?php echo $monthName?>- 2018</th></tr>	
                                     <tr><th colspan="26">VEHICLE WISE EXP. SUMMERY</th></tr>	
                                     
										<tr>
                                            <th width="3%"  bgcolor="#FFCC33" >Sl. No.</th>
                                            <th bgcolor="#FFCC33">Truck No</th>
                                            <th width="7%"  bgcolor="#FFCC33">Pichhla Bachat</th>
                                            <th width="7%"  bgcolor="#FFCC33">Cash Expense</th>
                                            <th width="9%"  bgcolor="#FFCC33">Total</th>
                                            <th width="9%"  bgcolor="#FFCC33">Bhatta</th>
                                            <th width="9%"  bgcolor="#FFCC33">Hamali</th>
                                            <th width="8%"  bgcolor="#FFCC33">Trip</th>
                                            <th width="7%"  bgcolor="#FFCC33">Toll Tax</th>
                                            <th width="7%"  bgcolor="#FFCC33">Other</th>                                            
                                            <th width="8%"  bgcolor="#FFCC33">Total</th>
                                            <th width="8%"  bgcolor="#FFCC33">Final Total</th>   
                                            <th width="6%"  bgcolor="#FFCC33">Return</th>	
                                            <th width="6%"  bgcolor="#FFCC33">Salary Ded.</th>   
                                            <th width="6%"  bgcolor="#FFCC33">Bachat</th>	
                                            <th width="6%"  bgcolor="#FFCC33">Bonus</th>	                                            
                                            <th width="8%"  bgcolor="#FFCC33">Diesel Exp.</th>
                                            <th width="8%"  bgcolor="#FFCC33">Spair Item</th>   
                                            <th width="6%"  bgcolor="#FFCC33">Note</th>	   
                                            <th width="6%"  bgcolor="#FFCC33">Total Exp.</th>	
                                            <th width="6%"  bgcolor="#FFCC33">Driver/Helper Payment</th>                                            
                                            <th width="8%"  bgcolor="#FFCC33">RTO & Insurence</th>
                                             <th width="8%"  bgcolor="#FFCC33">Truck Installment</th>
                                            <th width="8%"  bgcolor="#FFCC33">Grand Total</th>   
                                            <th width="6%"  bgcolor="#FFCC33">Trip</th>	   
                                            <th width="6%"  bgcolor="#FFCC33">Amount</th>	
                                            <th width="6%"  bgcolor="#FFCC33">Profit</th>	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}	
									
									$slno=1;
									
										$open_bal=0;									
										$tot_cash_exp = 0;
										$tot_saveamt = 0;
										$tot_truckexp = 0;
										$tot_returnamt = 0;
										$tot_bachat = 0;
										$tot_bonus_amt = 0;
										$tot_diesel_exp = 0;
										$tot_spareexp_amt = 0;
										$tot_salary_deduct = 0;
										$tot_total_exp = 0;
										$tot_salary = 0;
										$tot_grandtotal = 0;
										$tot_nooftrip = 0;
										$tot_biltyamountprofit = 0;
										$tot_profit = 0;
										$tot_truck_installment = 0;
										
						$sel = "select truckid,truckno,openningkm,salary,openingbalance,ownerid from m_truck where 1=1 $crit order by truckno";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];
										$ownerid = $row['ownerid'];
										$open_bal = $cmn->getopeningbal($connection,$truckid,$fromdate);
										$bhatta_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=9 && paymentdate between '$fromdate' and '$todate'");
										$hamali_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=10 && paymentdate between '$fromdate' and '$todate'");
										$cashexp_amt = $cmn->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && head_id=8 && paymentdate between '$fromdate' and '$todate'");
										$toltax_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=11 && paymentdate between '$fromdate' and '$todate'");
										$nooftrip =  $cmn->getvalfield($connection,"bilty_entry","count(*)","truckid='$truckid' && billtydate between '$fromdate' and '$todate'");
										$otherexpamt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=12 && paymentdate between '$fromdate' and '$todate'");
										$returnamt =  $cmn->getvalfield($connection,"otherincome","sum(incomeamount)","truckid='$truckid' && head_id=2 && paymentdate between '$fromdate' and '$todate'");
										$bonus_amt =  $cmn->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","truckid='$truckid' && diedate between '$fromdate' and '$todate'");
										$spareexp_amt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=13 && paymentdate between '$fromdate' and '$todate'");
										$rto_amt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=14 && paymentdate between '$fromdate' and '$todate'");
										$truck_installment = $cmn->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","truckid='$truckid' && payment_date between '$fromdate' and '$todate'");
										$salary_deduct =  $cmn->getvalfield($connection,"salary_deduction","sum(deduct_amt)","truckid='$truckid' && deduct_date between '$fromdate' and '$todate'");
									 $owner_type = $cmn->getvalfield($connection,"m_truckowner","owner_type","ownerid='$ownerid'");
										
										$saveamt = $open_bal + $cashexp_amt;
										$truckexp = $bhatta_amt + $hamali_amt + $toltax_amt + $otherexpamt;										
										$final_total = $saveamt - $truckexp;										
										$bachat = $final_total - $returnamt -$salary_deduct;										
										$diesel_exp = $cmn->getdieselexp($connection,$truckid,$fromdate,$todate);
										$total_exp = $diesel_exp + $bonus_amt+ $spareexp_amt + $truckexp;										
										$salary = $row['salary'];										
										$grandtotal = $total_exp + $salary + $rto_amt +$truck_installment;							
										
										if($owner_type=="self")
										{
											$biltyamountprofit = $cmn->getprofit_bytruck($connection,$truckid,$fromdate,$todate);
										}
										else
										{
										$biltyamountprofit = $cmn->getbiltyamountprofit($connection,$truckid,$fromdate,$todate);
										}
										
										$profit = $biltyamountprofit - $grandtotal;
																			
									?>
                            <tr>
                                <td><?php echo $slno; ?></td>
                                <td><?php echo $row['truckno']; ?></td>
                                <td style="text-align:right;"><?php echo number_format($open_bal,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($cashexp_amt,2); ?></td>
                                <td bgcolor="#33CC33" style="text-align:right;"><?php echo number_format($saveamt,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($bhatta_amt,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($hamali_amt,2); ?></td>
                                <td><?php echo $nooftrip; ?></td>
                                <td style="text-align:right;"><?php echo number_format($toltax_amt,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($otherexpamt,2); ?></td>                               
                                <td style="text-align:right;" bgcolor="#FFCC33"><?php echo number_format($truckexp,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($final_total,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($returnamt,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($salary_deduct,2); ?></td>
                                <td style="text-align:right;" bgcolor="#FFCCCC"><?php echo number_format($bachat,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($bonus_amt,2); ?></td>                                
                                <td style="text-align:right;"><?php echo number_format($diesel_exp,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($spareexp_amt,2); ?></td>
                                <td> </td>
                                <td style="text-align:right;"><?php echo number_format($total_exp,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($salary,2); ?></td>                                
                                <td style="text-align:right;"><?php echo number_format($rto_amt,2); ?></td>
                                  <td style="text-align:right;"> <?php echo number_format($truck_installment,2); ?> </td>
                                <td style="text-align:right;"><?php echo number_format($grandtotal,2); ?></td>
                                <td><?php echo $nooftrip; ?></td>
                                <td style="text-align:right;"><?php echo number_format($biltyamountprofit,2); ?></td>
                                <td style="text-align:right;" bgcolor="#6699FF"><?php echo number_format($profit,2); ?></td>                                                                        
                            </tr>
                                        <?php
										$slno++;
										
										$tot_cash_exp += $cashexp_amt;
										$tot_saveamt += $saveamt;
										$tot_truckexp += $truckexp;
										$tot_returnamt += $returnamt;
										$tot_bachat += $bachat;
										$tot_bonus_amt += $bonus_amt;
										$tot_diesel_exp += $diesel_exp;
										$tot_spareexp_amt += $spareexp_amt;
										$tot_salary_deduct += $salary_deduct;
										$tot_total_exp += $total_exp;
										$tot_salary += $salary;
										$tot_grandtotal += $grandtotal;
										$tot_nooftrip += $nooftrip;
										$tot_biltyamountprofit += $biltyamountprofit;
										$tot_profit += $profit;
										$tot_truck_installment += $truck_installment;
								}
									?>
                                    
                            <tr>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                    <td style="background-color:#00F;"> </td>                                       
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_cash_exp,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_saveamt,2); ?></strong></td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_truckexp,2); ?></strong></td>
                                    <td style="background-color:#00F;"> </td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_returnamt,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_salary_deduct,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_bachat,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_bonus_amt,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_diesel_exp,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_spareexp_amt,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;"></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_total_exp,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_salary,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;"></td>
                                     <td style="background-color:#00F; color:#FFF;text-align:right;"><?php echo number_format($tot_truck_installment,2); ?></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_grandtotal,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;"><strong><?php echo $tot_nooftrip; ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_biltyamountprofit,2); ?></strong></td>
                                    <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_profit,2); ?></strong></td>
                            </tr>   
									</tbody>
							</table>

                
                            
                            


<script>window.close();</script>