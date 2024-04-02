<?php
error_reporting(0);
class Comman {
	
function checkmenu($connection,$mudule_setting,$userid,$usertype)
{
	if($usertype !='admin')
	{
  $sql=mysqli_query($connection,"SELECT B.* FROM m_privilage AS A LEFT JOIN m_pages AS B ON A.page_id = B.page_id where B.module='$mudule_setting' and A.userid='$userid'");	
  $numrows=mysqli_num_rows($sql);
	}
	else
	{
		$numrows=1;
	}
  
 // echo $numrows; die;
return $numrows;
	
}

function getinvoiceamount($connection,$invoiceid)
{
$nettotal=0;

//echo "select own_rate,totalweight,mul(own_rate * totalweight) as total from bidding_entry where invoiceid='$invoiceid'"; die;
	$sql = mysqli_query($connection,"select own_rate,totalweight,sum(own_rate * totalweight) as total from bidding_entry where invoiceid='$invoiceid'");
	while($row=mysqli_fetch_assoc($sql))
	{
	$total=0;
	//print_r($row);
		//$total = $row['totalweight'] * $row['own_rate']; 
		$nettotal += $row['total'];
	}
	//echo $nettotal; die;
	return $nettotal;
}
function getdieselopening($connection,$currdate)
{
	$otherdiseladv = 0;
	 $openingbal = $this->getvalfield($connection,"account_setting","diesel_opening_bal","1=1");	 
	 $diesel_open_bal =$this->getvalfield($connection,"account_setting","diesel_open_bal_date","1=1");
	 $diesel_open_bal_str = strtotime($this->getvalfield($connection,"account_setting","diesel_open_bal_date","1=1"));
	 $currdate_str = strtotime($currdate);
	
	
	if($currdate_str > $diesel_open_bal_str)
	{	
			
	
		$diesel_open_bal =  date('Y-m-d', strtotime($diesel_open_bal . ' +1 day'));
		$tot=0;	
		
		
		
		$sql = mysqli_query($connection,"select A.qty from diesel_purchase_entry_detail as A left join diesel_purchase_entry as B on A.d_purchase_id=B.d_purchase_id where B.invoice_date between '$diesel_open_bal' and '$currdate' && A.type='Diesel'");
		while($row=mysqli_fetch_assoc($sql))
		{
			$tot += $row['qty'];
		}
		
		
		$tot_fill =0;
		$sql2 = mysqli_query($connection,"select adv_dieselltr from bilty_entry  where adv_date between '$diesel_open_bal' and '$currdate' && petrol_pump_type='self'");
		while($row2=mysqli_fetch_assoc($sql2))
		{
			$tot_fill += $row2['adv_dieselltr'];
		}
		
			
		$tot_fill_dd=0;		
		$sql3 = mysqli_query($connection,"select A.qty from diesel_demand_detail as A left join diesel_demand_slip as B on A.dieslipid=B.dieslipid left join inv_m_supplier as C on C.supplier_id=A.supplier_id where C.type='self' && B.diedate between '$diesel_open_bal' and '$currdate'");
		while($row3=mysqli_fetch_assoc($sql3))
		{
			$tot_fill_dd +=$row3['qty'];
		}
		
		
		$otherdiseladv = $this->getvalfield($connection,"other_diesel_adv","sum(diesel_ltr)","adv_date between '$diesel_open_bal' and '$currdate'");
				
		$curr_openingbal = $openingbal + $tot - $tot_fill - $tot_fill_dd - $otherdiseladv;
	}
	else
	{
		$curr_openingbal = $openingbal;	
	}
	
		
	return $curr_openingbal;
}



function getstock($connection,$itemid) {
	$stock = 0;
	$openstock = 0;
	$total_pur = 0;
	$total_issue = 0;
	$materialin =0;
	$dieseldemand = 0;
	$openstock = $this->getvalfield($connection,"items","opening_stock","itemid='$itemid'");
	$total_pur = $this->getvalfield($connection,"purchasentry_detail","sum(rec_qty)","itemid='$itemid'");
	$total_issue = $this->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$itemid'");
	$materialin = $this->getvalfield($connection,"materialin","sum(qty)","itemid='$itemid'");
	$dieseldemand = $this->getvalfield($connection,"diesel_demand_detail","sum(qty)","productid='$itemid'");
	
	$stock = $openstock + $total_pur - $total_issue + $materialin - $dieseldemand;
	
	return $stock;
	
	}


function gettotalamt($connection,$d_purchase_id)
{
	$total = 0;
	$sql = mysqli_query($connection,"select * from diesel_purchase_entry_detail where d_purchase_id='$d_purchase_id'");
	while($row=mysqli_fetch_assoc($sql))
	{
		$dly_tax = $row['dly_tax'];
		$tax = $row['tax'];
		$cess_fixed = $row['cess_fixed'];
		$total = $row['qty'] * $row['rate'];	
		$total -= $row['discrs'];
		if($dly_tax !=0) { $total += $dly_tax; }
			if($tax !=0) { 
				$tax_amt = 	($total * $tax)/100;
				$total += $tax_amt;
			}
			
			if($cess_fixed !=0) { $total += $cess_fixed; }
			
	}
	
	return $total;
}


function gettotalpurchase($connection, $purchaseid)
{


	// old logic
	$netamount = 0;
	$total_unit_rate = 0;
	$sql = mysqli_query($connection, "select * from purchasentry_detail where purchaseid='$purchaseid'");
	while ($row = mysqli_fetch_assoc($sql)) {
		$total = $row['nettotal'] ;
		// $total_unit_rate += $row['qty'] ;
		$netamount += $total;
	}


	
	
	$tot_exp = 0;

	

	//echo $total_unit_rate;
	return round($netamount  );

	/*
	$sql = mysqli_query($connection, "select A.purchaseid,(qty * rate * weight) as total,(qty*unitrate) as total_unit_rate,
	(
   case when expprocess='Add' then (
   case when type='rs' then sum(expamt)
   else sum(( (qty * rate * weight) * expamt)/100)
   end
   )
   else -(
   case when type='rs' then sum(expamt)
   else sum(( (qty * rate * weight) * expamt)/100)
   end
   )
   end
   ) as expamt
	from purchaseentrydetail as A inner join purchaseentry as B on A.purchaseid=B.purchaseid 
	left join purchaseexp as C on A.purchaseid = C.purchaseid
   where  B.purchaseid = '$purchaseid' group by A.purchaseid ");

	$row = mysqli_fetch_assoc($sql);
	return round($row['total'] + $row['total_unit_rate'] + $row['expamt']);*/
}


function gettotalsale($connection, $saleid)
	{
	
	
		// old logic
		$netamount = 0;
		$total_unit_rate = 0;
		$sql = mysqli_query($connection, "select * from saleentry_detail where saleid='$saleid'");
		while ($row = mysqli_fetch_assoc($sql)) {
			$total = $row['grandtotal'] ;
			// $total_unit_rate += $row['qty'] ;
			$netamount += $total;
		}



	
	
	$tot_exp = 0;

	

	//echo $total_unit_rate;
	return round($netamount  );

	/*
	$sql = mysqli_query($connection, "select A.purchaseid,(qty * rate * weight) as total,(qty*unitrate) as total_unit_rate,
	(
   case when expprocess='Add' then (
   case when type='rs' then sum(expamt)
   else sum(( (qty * rate * weight) * expamt)/100)
   end
   )
   else -(
   case when type='rs' then sum(expamt)
   else sum(( (qty * rate * weight) * expamt)/100)
   end
   )
   end
   ) as expamt
	from purchaseentrydetail as A inner join purchaseentry as B on A.purchaseid=B.purchaseid 
	left join purchaseexp as C on A.purchaseid = C.purchaseid
   where  B.purchaseid = '$purchaseid' group by A.purchaseid ");

	$row = mysqli_fetch_assoc($sql);
	return round($row['total'] + $row['total_unit_rate'] + $row['expamt']);*/
}


function getprofit_bytruck($connection,$truckid,$fromdate,$todate)
{
	$nettotal = 0;
	 //echo "select rate_mt,wt_mt from bilty_entry where truckid='$truckid' && billtydate between '$fromdate' and '$todate'";
	$sql = mysqli_query($connection,"select rate_mt,wt_mt from bilty_entry where truckid='$truckid' && billtydate between '$fromdate' and '$todate'");
	while($row=mysqli_fetch_assoc($sql))
	{
	$total = $row['wt_mt'] * $row['rate_mt'];	
	$nettotal += $total;
	}
	
	return $nettotal;
}




function getdieselexp($connection,$truckid,$fromdate,$todate)
{	
	$total = 0;
	$sql = mysqli_query($connection,"select dieslipid from diesel_demand_slip where truckid='$truckid' && diedate between '$fromdate' and '$todate'");
	while($row=mysqli_fetch_assoc($sql))
	{
		$sql2 = mysqli_query($connection,"select qty,rate from diesel_demand_detail where dieslipid='$row[dieslipid]'");	
		while($row2=mysqli_fetch_assoc($sql2))
		{
			$total += $row2['qty'] * $row2['rate'];	
		}
	}
	
	return $total;
}

function getdiesel($connection,$dieslipid)
{
	$total = 0;
	$sql2 = mysqli_query($connection,"select qty,rate from diesel_demand_detail where dieslipid='$dieslipid'");	
		while($row2=mysqli_fetch_assoc($sql2))
		{
			$total += $row2['qty'] * $row2['rate'];	
		}
	
	return $total;
}

function getbiltyamountprofit($connection,$truckid,$fromdate,$todate)
{	
	$nettotal=0;
	$sql = mysqli_query($connection,"select wt_mt,rate_mt,newrate from bilty_entry where truckid='$truckid' && billtydate between '$fromdate' and '$todate'");
	while($row=mysqli_fetch_assoc($sql))
	{
		
		$profitrate = $row['rate_mt'] - $row['newrate'];
		$total = $row['wt_mt'] * $profitrate;	
		$nettotal += $total;
	}
	
	return $nettotal;
}


	function getopeningbal($connection,$truckid,$fromdate)
	{
		$fromdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
				
		$sel = "select truckid,truckno,openningkm,salary,openingbalance,open_bal_date,ownerid from m_truck where truckid='$truckid' order by truckno";
		$res = mysqli_query($connection,$sel);
			while($row = mysqli_fetch_array($res))
			{
				$truckid = $row['truckid'];
				$open_bal = $row['openingbalance'];
				$ownerid = $row['ownerid'];
				 $open_bal_date = $row['open_bal_date'];
				$open_bal_date = date('Y-m-d',strtotime($open_bal_date . "+1 days"));
				
				$bhatta_amt = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=9 && paymentdate between '$open_bal_date' and '$fromdate'");
				$hamali_amt = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=10 && paymentdate between '$open_bal_date' and '$fromdate'");
				$cashexp_amt = $this->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && head_id=8 && paymentdate between '$open_bal_date' and '$fromdate'");
				$toltax_amt = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=11 && paymentdate between '$open_bal_date' and '$fromdate'"); 
				$nooftrip =  $this->getvalfield($connection,"bilty_entry","count(*)","truckid='$truckid' && payment_date between '$open_bal_date' and '$fromdate'"); 
				$otherexpamt =  $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=12 && paymentdate between '$open_bal_date' and '$fromdate'");  
				$returnamt =  $this->getvalfield($connection,"otherincome","sum(incomeamount)","truckid='$truckid' && head_id=2 && paymentdate between '$open_bal_date' and '$fromdate'");
				
										$bonus_amt =  $this->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","truckid='$truckid' && diedate between '$open_bal_date' and '$fromdate'")+ $this->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && head_id=16 && paymentdate between '$open_bal_date' and '$fromdate'");
										$spareexp_amt =  $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=13 && paymentdate between '$open_bal_date' and '$fromdate'");
										$rto_amt =  $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=14 && paymentdate between '$open_bal_date' and '$fromdate'");
										$truck_installment = $this->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","truckid='$truckid' && payment_date between '$open_bal_date' and '$fromdate'");
										$salary_deduct =  $this->getvalfield($connection,"salary_deduction","sum(deduct_amt)","truckid='$truckid' && deduct_date between '$open_bal_date' and '$fromdate'");
				
				
				
										$saveamt = $open_bal + $cashexp_amt;
										$truckexp = $bhatta_amt + $hamali_amt + $toltax_amt + $otherexpamt;										
										$final_total = $saveamt - $truckexp;										
										$bachat = $final_total - $returnamt - $salary_deduct;	
				
										
										
										
			}
		return $bachat;
	}



function getcashopeningplant_emami($connection,$currdate,$compid) {
//echo $currdate; die;
	 $open_bal_date = $this->getvalfield($connection,"account_setting","open_bal_date","compid=$compid && 1=1");  
 
	$open_bal_date_str = strtotime($open_bal_date);	
	$curdatestr = strtotime($currdate);	
	
	
	if($curdatestr < $open_bal_date_str)
	{
	//echo "hi"; die;
		$openingbal=0;	
	}
	else if($curdatestr==$open_bal_date_str)
	{
		 $openingbal = $this->getvalfield($connection,"account_setting","compid=$compid && cashopeningbal","1=1");
		 
	}
	else
	{
	
	$currdate = date('Y-m-d', strtotime('-1 day', strtotime($currdate)));
	
	//echo $currdate; die; 
		
		 $cashopeningbal = $this->getvalfield($connection,"account_setting","cashopeningbal","compid=$compid && 1=1");
		 $cementadv = $this->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=2 && adv_date between '$open_bal_date' and '$currdate' and compid=$compid ");
							
							$clinkeradv = $this->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=1 && adv_date between '$open_bal_date' and '$currdate' and compid=$compid ");
						
						$otherincome = $this->getvalfield($connection,"otherincome as A left join m_userlogin as B on A.createdby = B.userid","sum(incomeamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate' &&  compid=$compid  && branchid=1 && A.createdby in (select userid from m_userlogin where compid=$compid");
						
						$otherexpense = $this->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate' &&  compid=$compid  && branchid=1 && A.createdby in (select userid from m_userlogin where  compid=$compid)");   
						
			$truckexpense = $this->getvalfield($connection,"truck_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(uchantiamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate'  && branchid=1 && A.createdby in (select userid from m_userlogin where  compid=$compid)"); 
			
												
						$openingbal = $cashopeningbal - $cementadv - $clinkeradv - $otherexpense + $otherincome - $truckexpense;
		
	}
	
	return $openingbal;
	
}


function getcashopeningplant($connection,$currdate,$compid) {
//echo $currdate; die;
  $open_bal_date = $this->getvalfield($connection,"account_setting","open_bal_date_emami","compid=$compid && 1=1");  
	$open_bal_dateincrea = date('Y-m-d', strtotime('+1 day', strtotime($open_bal_date)));
	$open_bal_date_str = strtotime($open_bal_date);	
	$curdatestr = strtotime($currdate);	
	
	
	if($curdatestr < $open_bal_date_str)
	{
	//echo "hi"; die;
		$openingbal=0;	
	}
	else if($curdatestr==$open_bal_date_str)
	{
		 $openingbal = $this->getvalfield($connection,"account_setting","cashopeningbal_emami","compid=$compid && 1=1");
		 
	}
	else
	{
	
	$currdate = date('Y-m-d', strtotime('-1 day', strtotime($currdate)));
	
	//echo $currdate; die; 
		
		 $cashopeningbal = $this->getvalfield($connection,"account_setting","cashopeningbal_emami","compid=$compid && 1=1");
		 $cementadv = $this->getvalfield($connection,"bidding_entry","sum(adv_cash)","adv_date between '$open_bal_date' and '$currdate' and compid=$compid");
							
							// $clinkeradv = $this->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=1 && adv_date between '$open_bal_date' and '$currdate' and consignorid !=4 ");
						
						 $otherincome = $this->getvalfield($connection,"otherincome as A left join m_userlogin as B on A.createdby = B.userid","sum(incomeamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate'  && B.branchid=1 && A.createdby in (select userid from m_userlogin where compid=$compid)");
						
						$otherexpense = $this->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate'  && B.branchid=1 && A.createdby in (select userid from m_userlogin where compid=$compid)");   
						
					   $truckexpense = $this->getvalfield($connection,"truck_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(uchantiamount)","payment_type='cash' && paymentdate between '$open_bal_date' and '$currdate'  && branchid=1 && A.createdby in (select userid from m_userlogin where compid=$compid)"); 
			
												
						$openingbal = $cashopeningbal - $cementadv - $otherexpense + $otherincome - $truckexpense;
		
	}
	
	return $openingbal;
	
}

function getcashopening($connection,$currdate)
{
return	$open_bal_date = $this->getvalfield($connection,"account_setting","open_bal_date","1=1");
	$open_bal_date = date('Y-m-d', strtotime('+1 day', strtotime($open_bal_date)));
	$open_bal_date_str = strtotime($open_bal_date);	
	$curdatestr = strtotime($currdate);	
	if($curdatestr < $open_bal_date_str)	
	{
		$openingbal=0;	
	}
	else if($curdatestr==$open_bal_date_str)
	{
		 $openingbal = $this->getvalfield($connection,"account_setting","cashopeningbal","open_bal_date <='$currdate' ");
	}
	else
	{
		$currdate = date('Y-m-d', strtotime('-1 day', strtotime($currdate)));	
	 $cashopeningbal = $this->getvalfield($connection,"account_setting","cashopeningbal","open_bal_date <='$currdate'");
	 
		$truck_income = $this->getvalfield($connection,"otherincome","sum(incomeamount)","truckid !=0 && paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
		$office_income = $this->getvalfield($connection,"otherincome","sum(incomeamount)","truckid =0 && paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
		$bilty_adv = $this->getvalfield($connection,"bidding_entry","sum(adv_cash)","adv_date between '$open_bal_date' and '$currdate' ");
		$final_payment = $this->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date between '$open_bal_date' and '$currdate' ");
		$truck_uchanti = $this->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
		$truck_expense = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash' && head_id not in('9','10','11','12','13')");
		$other_expense = $this->getvalfield($connection,"other_expense","sum(expamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
		$bonuspayment = $this->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","diedate between '$open_bal_date' and '$currdate' && payment_type='cash'");
		$truck_installation_payment = $this->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","payment_date between '$open_bal_date' and '$currdate' && payment_type='Cash'");	 
		$commision = $this->getvalfield($connection,"bidding_entry","sum(commission)","payment_date between '$open_bal_date' and '$currdate' ");
		$truck_owner_payment = $this->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date between '$open_bal_date' and '$currdate'");
		
	 	$driver_salary = $this->getvalfield($connection,"driver_salary","sum(bal_amt)","salary_date between '$open_bal_date' and '$currdate' ");
	 
	 
	/* $truck_income = $this->getvalfield($connection,"otherincome","sum(incomeamount)","truckid !=0 && paymentdate between '$open_bal_date' and '$currdate' &&   
																	   payment_type='cash'");
	 $office_income = $this->getvalfield($connection,"otherincome","sum(incomeamount)","truckid =0 && paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
	
	$bilty_advance =  $this->getvalfield($connection,"bilty_entry","sum(adv_cash)","adv_date between '$open_bal_date' and '$currdate' ");
	$truck_expense = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'  && head_id not in('9','10','11','12','13')");
	$other_expense = $this->getvalfield($connection,"other_expense","sum(expamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
	$truck_uchanti = $this->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","paymentdate between '$open_bal_date' and '$currdate' && payment_type='cash'");
	$truck_installation_payment = $this->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","payment_date between '$open_bal_date' and '$currdate' && payment_type='Cash'");
	$bonuspayment = $this->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","diedate between '$open_bal_date' and '$currdate' && payment_type='cash'");
	
	$bilty_commision = $this->getvalfield($connection,"bilty_entry","sum(commission)","cashbook_date  between '$open_bal_date' and '$currdate'"); 
	$final_payment = $this->getvalfield($connection,"bilty_entry","sum(cashpayment)","payment_date between '$open_bal_date' and '$currdate'"); 
	$truck_owner_payment = $this->getvalfield($connection,"bilty_payment","sum(payamount)","paymentdate='$currdate'");*/
	
	//$openingbal = $cashopeningbal + $consignorwiseincome - $truck_installation_payment - $truck_uchanti -$truck_expense - $other_expense + $otherincome - $ownerbilty_payment - $bilty_advance - $bilty_commision + $bilty_payment;
	
	$openingbal = $cashopeningbal + $truck_income + $office_income - $bilty_adv - $final_payment - $truck_uchanti - $truck_expense -$other_expense - $bonuspayment -$truck_installation_payment -$commision-$truck_owner_payment - $driver_salary;
	
	}	
	return $openingbal;	
	
}

function getopeningbalance($connection,$sessionid)
{
	$currdate = date('Y-m-d');
	$cashopeningbal = $this->getvalfield($connection,"account_setting","cashopeningbal","1=1");
	$otherincome = $this->getvalfield($connection,"otherincome","sum(incomeamount)","paymentdate <= '$currdate' && payment_type='cash' && sessionid='$sessionid'");
	$bilty_advance =  $this->getvalfield($connection,"bilty_entry","sum(adv_cash)","adv_date <= '$currdate' && sessionid='$sessionid'") +  $this->getvalfield($connection,"bilty_entry","sum(adv_diesel)","adv_date <= '$currdate' && sessionid='$sessionid'");
	$truck_expense = $this->getvalfield($connection,"truck_expense","sum(uchantiamount)","paymentdate <= '$currdate' && payment_type='cash' && sessionid='$sessionid'");
	$other_expense = $this->getvalfield($connection,"other_expense","sum(expamount)","paymentdate <= '$currdate' && payment_type='cash' && sessionid='$sessionid'");
	$truck_uchanti = $this->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","paymentdate <= '$currdate' && payment_type='cash' && sessionid='$sessionid'");
	$truck_installation_payment = $this->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","payment_date <= '$currdate' && payment_type='Cash' && sessionid='$sessionid'");
	$bonuspayment = $this->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","diedate <= '$currdate' && payment_type='cash' && sessionid='$sessionid'");
	 $otherdiseladv = $this->getvalfield($connection,"other_diesel_adv","sum(diesel_ltr)","adv_date <= '$currdate'"); 
	//$bilty_commision = $this->getvalfield($connection,"bilty_entry","sum(commission)","payment_date <= '$currdate' && sessionid='$sessionid'"); 
	$final_payment = $this->getvalfield($connection,"bilty_entry","sum(cashpayment)","payment_date <= '$currdate' && sessionid='$sessionid'"); 
	
	//$openingbal = $cashopeningbal + $consignorwiseincome - $truck_installation_payment - $truck_uchanti -$truck_expense - $other_expense + $otherincome - $ownerbilty_payment - $bilty_advance - $bilty_commision + $bilty_payment;
	
	$openingbal = $cashopeningbal + $otherincome - $bilty_advance - $truck_expense - $other_expense - $truck_installation_payment -$truck_uchanti - $bonuspayment -$final_payment - $otherdiseladv;
	
	return $openingbal;	
}

function check_menuname($connection,$location,$userid,$usertype)
{
	if($usertype !='admin')
	{
	$sql=mysqli_query($connection,"select * from m_privilage as A left join m_pages as B on A.page_id = B.page_id  where A.userid='$userid' && B.pagename='$location'");
		$numrows=mysqli_num_rows($sql);
		
	}
	else
	{
		$numrows=1;
	}	
	
	return $numrows;
	
}
	

function get_invoice($connection,$tblname,$tblpkey)
{
	$maxid = $this ->getvalfield($connection,$tblname,"max($tblpkey)","1=1");	
	
	
	$id = $maxid + 1;
	$strlen = strlen($id);
	if($strlen == 1)
	$id = '00000'.$id;
	else if($strlen == 2)
	$id = '0000'.$id;
	else if($strlen == 3)
	$id = '000'.$id;
	else if($strlen == 4)
	$id = '00'.$id;
	else if($strlen == 5)
	$id = '0'.$id;
	else if($strlen == 6)
	$id = $id;
	return $id;
	
}


function calc_freight_net_amt($freight_bill_no)
{
	$grossamt = 0;
	$sql_bil = mysqli_query($connection,"select * from billty where freight_bill_no = '$freight_bill_no'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$rate = $row['freightrate'];
		$commissionamt = $row['commissionamt'];
		
		$grossamt += ($rate * $row['vehiclewt']) - $row['advance'] - $row['shortageamt'] + $row['unloading_charges'] - $commissionamt;
		
		
	}
	return $grossamt;
}
function calc_freight_ret_net_amt($freight_bill_no)
{
	$grossamt = 0;
	$sql_bil = mysqli_query($connection,"select * from return_billty where freight_bill_no = '$freight_bill_no'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$rate = $row['freightrate'];
		$tdsamt = $rate * $row['vehiclewt'] *  $row['freight_tds']/ 100;
		$grossamt += ($rate * $row['vehiclewt']) - $row['advance'] - $row['shortageamt'] - $row['unloading_charges'] - $tdsamt;
		
		
	}
	return $grossamt;
}

function get_consigneetotal_billing_amt($connection,$billid)
{
	$grossamt = 0;
	$taxamt=0;
	$tot_ulamt=0;
	$sql_bil = mysqli_query($connection,"select bid_id,ulamt from bill_details where billid = '$billid'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$bid_id = $row['bid_id'];
		$ulamt = $row['ulamt'];
		
		$sql = mysqli_query($connection,"select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from bidding_entry where bid_id = '$bid_id'");
		$row_amt = mysqli_fetch_assoc($sql);
		$rate = $row_amt['comp_rate'];
		$grossamt += $rate * $row_amt['totalweight'];
		$tot_ulamt += $ulamt;
		
	}
	
	
	$sql_net = mysqli_query($connection,"select istaxable,taxable_percent,serv_tax_percent,ecess_percent,hcess_percent,safai_percent,krishi_cess,cgst_percent,sgst_percent from bill where billid = '$billid'");
	$row_net = mysqli_fetch_assoc($sql_net);
	if($row_net['istaxable'] == '1')
	{
		$taxableamt = ($row_net['taxable_percent'] * $grossamt) /100;
		$servtaxamt = ($row_net['serv_tax_percent'] * $taxableamt) /100;
		$ecessamt = ($row_net['ecess_percent'] * $grossamt) /100;
		$hcessamt = ($row_net['hcess_percent'] * $grossamt) /100;
		$swachamt = ($row_net['safai_percent'] * $taxableamt) /100;
		$krishiamt = ($row_net['krishi_cess'] * $taxableamt) /100;
		$gstamount = (($row_net['cgst_percent']+$row_net['sgst_percent']) * $grossamt) /100;
		$taxamt +=  $taxableamt + $servtaxamt + $ecessamt + $hcessamt + $swachamt + $krishiamt + $gstamount;
	}
	
	return round($grossamt + $taxamt + $tot_ulamt);
}


function get_consigneetotal_billing_amt1($connection,$billid)
{
	$grossamt = 0;
	$taxamt=0;
	$tot_ulamt=0;
	$sql_bil = mysqli_query($connection,"select bid_id,ulamt from returnbill_details where billid = '$billid'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$bid_id = $row['bid_id'];
		$ulamt = $row['ulamt'];
		
		$sql = mysqli_query($connection,"select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from  	returnbidding_entry  where bid_id = '$bid_id'");
		$row_amt = mysqli_fetch_assoc($sql);
		$rate = $row_amt['comp_rate'];
		$grossamt += $rate * $row_amt['totalweight'];
		$tot_ulamt += $ulamt;
		
	}
	
	
	$sql_net = mysqli_query($connection,"select istaxable,taxable_percent,serv_tax_percent,ecess_percent,hcess_percent,safai_percent,krishi_cess,cgst_percent,sgst_percent from returnbill where billid = '$billid'");
	$row_net = mysqli_fetch_assoc($sql_net);
	if($row_net['istaxable'] == '1')
	{
		$taxableamt = ($row_net['taxable_percent'] * $grossamt) /100;
		$servtaxamt = ($row_net['serv_tax_percent'] * $taxableamt) /100;
		$ecessamt = ($row_net['ecess_percent'] * $grossamt) /100;
		$hcessamt = ($row_net['hcess_percent'] * $grossamt) /100;
		$swachamt = ($row_net['safai_percent'] * $taxableamt) /100;
		$krishiamt = ($row_net['krishi_cess'] * $taxableamt) /100;
		$gstamount = (($row_net['cgst_percent']+$row_net['sgst_percent']) * $grossamt) /100;
		$taxamt +=  $taxableamt + $servtaxamt + $ecessamt + $hcessamt + $swachamt + $krishiamt + $gstamount;
	}
	
	return round($grossamt + $taxamt + $tot_ulamt);
}




  
function get_total_billing_amt($connection,$billid)
{
	$grossamt = 0;
	$taxamt=0;
	$tot_ulamt=0;
//	echo "select bid_id,ulamt from bill_details where billid = '$billid'";die;
	$sql_bil = mysqli_query($connection,"select bid_id,ulamt from bill_details where billid = '$billid'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$bid_id = $row['bid_id'];
		$ulamt = $row['ulamt'];
		//echo "select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from bidding_entry where bid_id = '$bid_id'";
		$sql = mysqli_query($connection,"select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from bidding_entry where bid_id = '$bid_id'");
		$row_amt = mysqli_fetch_assoc($sql);
		$rate = $row_amt['comp_rate'];
		$grossamt += $rate * $row_amt['recweight'];
		$tot_ulamt += $ulamt;
		
	}
	
	
	$sql_net = mysqli_query($connection,"select istaxable,taxable_percent,serv_tax_percent,ecess_percent,hcess_percent,safai_percent,krishi_cess,cgst_percent,sgst_percent from bill where billid = '$billid'");
	$row_net = mysqli_fetch_assoc($sql_net);
	if($row_net['istaxable'] == '1')
	{
		$taxableamt = ($row_net['taxable_percent'] * $grossamt) /100;
		$servtaxamt = ($row_net['serv_tax_percent'] * $taxableamt) /100;
		$ecessamt = ($row_net['ecess_percent'] * $grossamt) /100;
		$hcessamt = ($row_net['hcess_percent'] * $grossamt) /100;
		$swachamt = ($row_net['safai_percent'] * $taxableamt) /100;
		$krishiamt = ($row_net['krishi_cess'] * $taxableamt) /100;
		$gstamount = (($row_net['cgst_percent']+$row_net['sgst_percent']) * $grossamt) /100;
		$taxamt +=  $taxableamt + $servtaxamt + $ecessamt + $hcessamt + $swachamt + $krishiamt + $gstamount;
	}
	
	return round($grossamt + $taxamt + $tot_ulamt);
}



function get_total_billing_amt1($connection,$billid)
{
	$grossamt = 0;
	$taxamt=0;
	$tot_ulamt=0;
//	echo "select bid_id,ulamt from bill_details where billid = '$billid'";die;
	$sql_bil = mysqli_query($connection,"select bid_id,ulamt from returnbill_details where billid = '$billid'");
	while($row = mysqli_fetch_assoc($sql_bil))
	{
		
		$bid_id = $row['bid_id'];
		$ulamt = $row['ulamt'];
		//echo "select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from bidding_entry where bid_id = '$bid_id'";
		$sql = mysqli_query($connection,"select consignorid,recweight,tokendate,destinationid,comp_rate,totalweight from returnbidding_entry where bid_id = '$bid_id'");
		$row_amt = mysqli_fetch_assoc($sql);
		$rate = $row_amt['comp_rate'];
		$grossamt += $rate * $row_amt['recweight'];
		$tot_ulamt += $ulamt;
		
	}
	
	
	$sql_net = mysqli_query($connection,"select istaxable,taxable_percent,serv_tax_percent,ecess_percent,hcess_percent,safai_percent,krishi_cess,cgst_percent,sgst_percent from returnbill where billid = '$billid'");
	$row_net = mysqli_fetch_assoc($sql_net);
	if($row_net['istaxable'] == '1')
	{
		$taxableamt = ($row_net['taxable_percent'] * $grossamt) /100;
		$servtaxamt = ($row_net['serv_tax_percent'] * $taxableamt) /100;
		$ecessamt = ($row_net['ecess_percent'] * $grossamt) /100;
		$hcessamt = ($row_net['hcess_percent'] * $grossamt) /100;
		$swachamt = ($row_net['safai_percent'] * $taxableamt) /100;
		$krishiamt = ($row_net['krishi_cess'] * $taxableamt) /100;
		$gstamount = (12 * $grossamt) /100;
		$taxamt +=  $taxableamt + $servtaxamt + $ecessamt + $hcessamt + $swachamt + $krishiamt + $gstamount;
	}
	
	return round($grossamt + $taxamt + $tot_ulamt);
}





/*--------get total no. of rows----------*/
function getTotalNum($table,$where)
{
	$sql = "select * from $table where $where";
	//echo $sql; die;
	$getvalue = mysqli_query($connection,$sql);
	$getval = mysqli_num_rows($getvalue);

	return $getval;
}
function get_stock($itemid)
{
	$purchase_product = $this->getvalfield($connection,"inv_purchase_item", "sum(qty)","itemid='$itemid'");
	$purchase_return = $this->getvalfield($connection,"inv_purchase_return_item", "sum(retqty)","itemid='$itemid'");
	$issued_product = $this->getvalfield($connection,"inv_issue_item", "sum(issueqty)","itemid='$itemid'");
	$issued_return_product = $this->getvalfield($connection," inv_issue_return_items", "sum(retqty)","itemid='$itemid'");
	$scrap_product = $this->getvalfield($connection,"inv_scrap", "sum(scrapqty)","itemid='$itemid'");
	$opening_stock = $this->getvalfield($connection,"inv_m_item", "opening_stock","itemid='$itemid'");
	$stock = $opening_stock + $purchase_product + $issued_return_product - $issued_product - $purchase_return - $scrap_product;
	
	return $stock;
}

function dirver_cash_in_hand($empid,$currdate)
{
	//$currdate = $this->dateformatdb($currdate);
	$sql1 = "select sum(amount) as totalexp  from acc_driver_book_details left join acc_driver_book on acc_driver_book.expid = acc_driver_book_details.expid where empid='$empid' and expdate <= '$currdate'"; 
	$row1 = mysqli_fetch_array(mysqli_query($connection,$sql1));
	$totalexp = $row1['totalexp'];
	
	$totaluchanti = $this->getvalfield($connection,"uchanti","sum(uamount)","empid = '$empid' and udate <= '$currdate'");
	///return $curr_month_no = date("n",$currdate);
	
	$arr = explode("-",$currdate);
	$curr_month_no =  $arr[1];
	$cash_in_hand_deduction = $this->getvalfield($connection,"driver_salary_book","sum(cash_in_hand_deduction)","empid = '$empid' and monthid <= '$curr_month_no' and '$currdate' <= generate_date");
	$prev_cash_in_hand = $this->getvalfield($connection,"acc_employee_advance","sum(advance)","adv_status = '1' and empid = '$empid' and advdate <= '$currdate' ");
	if($totaluchanti == "")
	$totaluchanti = 0;
	if($totalexp == "")
	$totalexp = 0;
	if($cash_in_hand_deduction == "")
	$cash_in_hand_deduction = 0;
	if($prev_cash_in_hand == "")
	$prev_cash_in_hand = 0;
	
	
	$cash_in_hand = $totaluchanti - $totalexp - $cash_in_hand_deduction - $prev_cash_in_hand;
	//return($totaluchanti.'-'.$totalexp.'-'.$cash_in_hand_deduction.'-'.$prev_cash_in_hand);
	return($cash_in_hand);
}



function create_combo($connection,$tablename,$columnkey,$columnval,$where,$classname)
{
	echo "<select name='$columnkey' id='$columnkey' class='$classname' style='width:220px;'>";
	$sql = "select * from $tablename where $where";
	$res = mysqli_query($connection,$sql);
	$response_txt = "<option value=''>--Select--</option>";
	while($row = mysqli_fetch_array($res))
	{
		$key = $row[$columnkey];
		$val = $row[$columnval];
		$response_txt .= "<option value='$key'>$val</option>";
		
	}
	$response_txt .= "</select>";
	return($response_txt);
}


function create_combobloack($connection,$tablename,$columnkey,$columnval,$where,$classname)
{
	echo "<select name='$columnkey' id='$columnkey' class='$classname' style='width:220px;' readonly disabled >";
	$sql = "select * from $tablename where $where";
	$res = mysqli_query($connection,$sql);
	$response_txt = "<option value=''>--Select--</option>";
	while($row = mysqli_fetch_array($res))
	{
		$key = $row[$columnkey];
		$val = $row[$columnval];
		$response_txt .= "<option value='$key'>$val</option>";
		
	}
	$response_txt .= "</select>";
	return($response_txt);
}


/*-----------to check if a parent table exist in child table-------*/
public function query($query_string)
{   //echo $query_string;
    //die;
	$this->queryId = mysqli_query($connection,$query_string);
	if (! $this->queryId) {
		$this->_throwException($query_string);
	}
	return $this->queryId;
}

private function _throwException($query = null)
{
	$msg = mysql_error().".  Query was:\n\n".$query.
                "\n\nError number: ".mysql_errno();
	throw new Exception($msg);
}
	// to get invvoice number 
function auto_num($tablename,$field,$crit)
{
	
	 $sql = "select max($field) as inv from  $tablename where $crit";
    $res = mysqli_query($connection,$sql);
	//echo $sql;
	$check = mysqli_num_rows($res);
	$row = mysqli_fetch_array($res);
    $inv = $row['inv'];
	//if invoice no exist
	if(isset($inv))
     $inv = $row['inv'];
	 else
	 $inv=0;
	   
		   ++$inv; 
		   $len = strlen($inv);
		   for($i=$len; $i<= 4; ++$i) {
           $num = '0'.$num;
		   }
		    $issue_no = $num.$inv; 
	return $issue_no;
}
// to get ipaddress of user logged in
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//Insert into log history in CA admin //
function insertLoginLogout($connection,$process,$loginuser_id,$user_type,$compid,$ipaddress)
{
	$date = date("Y-m-d H:i:s");
   $sql = "insert into logs_loginreport set process = '$process' ,userid = '$loginuser_id' ,usertype = '$user_type' ,login_logout_time = '$date' ,compid = '$compid' ,ipaddress = '$ipaddress'";
	mysqli_query($connection,$sql);
	//echo $sql;die;
}

// function to add user activity in database
function InsertLog($connection,$pagename, $modulename, $tablename, $tablekey, $keyvalue, $action)
{
	$userid = $_SESSION['userid'];
	$usertype = $_SESSION['usertype'];
	$activitydatetime  = date('Y-m-d H:m:s');
	
	$sqlquery = "insert into activitylogreport set userid='$userid', usertype='$usertype', modulename= '$modulename', tablename ='$tablename', pagename='$pagename', primarykeyid ='$tablekey' , activitydatetime = '$activitydatetime', keyvalue = '$keyvalue',action='$action' , branchid = '$_SESSION[branchid]',sessionid = '$_SESSION[sessionid]',ipaddress = '$_SESSION[ipaddress]' ";
	//echo $sqlquery;die;
	mysqli_query($connection,$sqlquery);
}
// To encrypt data based on key //
function encrypt($string, $key)
{
	$result = '';
	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)+ord($keychar));
		$result.=$char;
	}
	return base64_encode($result);
}

// To decrypt data based on key //
function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);
	
	for($i=0; $i<strlen($string); $i++)
	{
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}
// get value if you know the primary key value //
function getvalMultiple($table,$field,$where,$space)
{
	if($where != "")
	$sql = "select $field from $table where $where";
	else
	$sql = "select $field from $table";
	//echo $sql;
	$getvalue = mysqli_query($connection,$sql);
	$getval="";
	while($row = mysqli_fetch_row($getvalue))
	{
		if($getval == "")
		$getval = $row[0];
		else
		{
			if($space!="")
			$getval .= " / ". $row[0];
			else
			$getval .= ",". $row[0];
		}
	}
	
	return $getval;
}


// get value from any condition //
function getvalfield($connection,$table,$field,$where)
  {
	  if($where == "")
	  $where =1;
	  
	  $sql = "select $field from $table where $where";
   	//  echo $sql; 
	  
	  $getvalue = mysqli_query($connection,$sql);
	  $getval = mysqli_fetch_row($getvalue);
 
	  return $getval[0];
  }
function check_access()
{    
    
	$user_type = $_SESSION['user_type'];
	if($user_type=='user')
	{
	$user_id = $_SESSION['loginuser_id'];
	$row_company = mysqli_fetch_array(mysqli_query($connection,"select company_id from details_user where user_id='$user_id'"));
	$company_id = $row_company['company_id'];
	$pageurl =$_SERVER['REQUEST_URI'];
    $sql_page_id = "select page_id from  master_pagename where  pageurl='$pageurl'";
	$res_page_id=mysqli_query($connection,$sql_page_id);
	$row_page_id = mysqli_fetch_array($res_page_id);
	$page_id = $row_page_id['page_id'];
    $sql_role ="select role_id from process_assign_role where user_id = '$user_id' ";
	$res_role = mysqli_query($connection,$sql_role);
	$row_role = mysqli_fetch_array($res_role);
    $role_id = $row_role['role_id'];
	$sql_priv = "select status from process_set_privilege where  company_id='$company_id' and page_id='$page_id' and role_id = '$role_id'" ;
	$sql_privilege = mysqli_query($connection,$sql_priv);
	$row_privilege = mysqli_fetch_array($sql_privilege);
	$status  = $row_privilege['status'];
	if($status == "")
	 $status = 1;
	// echo $status;
	//die;
	    if($status == 0)
		{ 

			echo "<script>location='../company/access_denied.php'</script>";
		} 
		else
		{
		}
	}
 }
 
 // get date format (2016-04-11) from 4/11/2016 //
function dateformatslash($date)
{
	if($date != "00/00/0000" && $date != "0/00/0000")
	{
	$ndate = explode("/",$date);
	$month = $ndate[0];	
	$day = $ndate[1];
	$year = $ndate[2];
	
	return $year . "-" . $month . "-" . $day;
	}
	else
	return "";
}
// get date format (01 march 2012) from 2012-03-01 //
function dateformat($date)
{
	if($date != "0000-00-00")
	{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = intval($ndate[1])-1;
	$montharr = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$month1 = $montharr[$month];
	
	
	return $day . " " . $month1 . " " . $year;
	}
	else
	return "";
}

// get date format (01-03-2012) from (2012-03-01) //
function dateformatindia($date)
{
	if($date == "0000-00-00" || $date =="")
	{
	return "";
	}
	else
	{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	return $day . "-" . $month . "-" . $year;
	}
	
}
// get date format (01.03.2012) from (2012-03-01) //
function dateformatindiadot($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	if($date == "0000-00-00" || $date =="")
	return "";
	else
	return $day . "." . $month . "." . $year;
	
}

// get date format (01/03/2012) from (2012-03-01) //
function dateformatslashindia($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	if($date == "0000-00-00" || $date =="")
	return "";
	else
	return $day . "/" . $month . "/" . $year;
	
}

// get date format (01-03-2012) from (2012-03-01 23:12:04) //
function dateFullToIndia($date,$full)
{
	$fdate = explode(" ",$date);
	
	$ndate = explode("-",$fdate[0]);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	$time = explode(":",$fdate[1]);
	$hour = $time[0];
	$minute = $time[1];
	$second = $time[2];
	if($hour > 12)
	{
		$h = $hour-12;
		if($h < 10)
		$h = "0" . $h;
		$fulltime = $h . ":" . $minute . ":" . $second . " PM";
	}
	else
	$fulltime = $hour . ":" . $minute . ":" . $second . " AM";
	
	
	if($full == "full")
	return $day . "-" . $month . "-" . $year . " " . $fdate[1];
	else if($full == "fullindia")
	return $day . "-" . $month . "-" . $year . " " . $fulltime;
	else if($full == "time")
	return $fulltime;
	else
	return $day . "-" . $month . "-" . $year;
}

// get date format (2012-03-01) from (01-03-2012) //
function dateformatusa($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[2];
	$day = $ndate[0];
	$month = $ndate[1];
	
	return $year . "-" . $month . "-" . $day;
}

function dateformatdb($currdate)
{
	$cmn = new Comman(); 
	$tdate = str_replace(".","-",$currdate);
	$tdate = str_replace("/","-",$tdate);
	//$tdate_arr = explode("-",$tdate);
	$dbdate = $this->dateformatusa($tdate);
	return $dbdate;
}

// get image in particular size. if you writ only width then it returns in ratio of height. and you can set width and height //
function convert_image($fname,$path,$wid,$hei)
{
	$wid = intval($wid); 
	$hei = intval($hei); 
	//$fname = $sname;
	$sname = "$path$fname";
	//echo $sname;
	//header('Content-type: image/jpeg,image/gif,image/png');
	//image size
	list($width, $height) = getimagesize($sname);
	
	if($hei == "")
	{
		if($width < $wid)
		{
			$wid = $width;
			$hei = $height;
		}
		else
		{
			$percent = $wid/$width;  
			$wid = $wid;
			$hei = round ($height * $percent);
		}
	}
	
	//$wid=469;
	//$hei=290;
	$thumb = imagecreatetruecolor($wid,$hei);
	//image type
	$type=exif_imagetype($sname);
	//check image type
	switch($type)
	{
	case 2:
	$source = imagecreatefromjpeg($sname);
	break;
	case 3:
	$source = imagecreatefrompng($sname);
	break;
	case 1:
	$source = imagecreatefromgif($sname);
	break;
	}
	// Resize
	imagecopyresized($thumb, $source, 0, 0, 0, 0,$wid,$hei, $width, $height);
	// source filename
	$file = basename($sname);
	//destiantion file path
	$dname=$path.$fname;
	//display on browser
	//store into file path
	imagejpeg($thumb,$dname);
}

// for get mixed no. like password etc. //
function getmixedno($totalchar)
{
	$abc= array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9");
	$mixedno = "";
	for($i=1; $i<=$totalchar; $i++)
	{
		$mixedno .= $abc[rand(0,33)];
	}
	return $mixedno;
}




// for pagination //
function startPagination($page_query, $data_in_a_page)
{
	$getrow = mysqli_query($connection,$page_query);
	$count = mysqli_num_rows($getrow);
	
	$page_for_site = "";
	
	$page=1;
	if(isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
	if($count > $data_in_a_page)
	{
		$cnt = ceil($count / $data_in_a_page);
		
		$page_for_site .= "<div style='float:left; padding-top:3px; color:#c0f;'>Page $page of $cnt &nbsp;&nbsp;&nbsp;</div>";
		
		for($i = 1; $i<= $cnt; $i++)
		{
			$class = " class='pagination' ";
			if($i == $page)
			$class = " class='pagination-current' ";
			
			$pu = $this->curPageURL();
			$cm = explode("/",$pu);
			$n = count($cm);
			$curl = $cm[$n-1];
			
			$qm_avail = strpos($curl,"?");
			if($qm_avail == "")
			$page_for_site .= "<a href='?page=$i' $class>$i</a>";
			else
			{
				$page_avail = strpos($curl,"page=");
				if($page_avail != "")
				{
					$pagevalue = $_REQUEST['page'];
					$past_page = "page=$pagevalue";
					$finalurl = str_replace($past_page,"page=$i",$curl);
					$page_for_site .= "<a href='$finalurl' $class>$i</a>";
				}
				else
				$page_for_site .= "<a href='$curl&page=$i' $class>$i</a>";
			}
		}
		$page_for_site .= "<div style='clear:both'></div>";
	}
	echo $page_for_site;
}


// return present page url //
function curPageURL()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") 
	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	return $pageURL;
}

// change number into word format //	
function numtowords($num)
{
	$ones = array(
	1 => "one",
	2 => "two",
	3 => "three",
	4 => "four",
	5 => "five",
	6 => "six",
	7 => "seven",
	8 => "eight",
	9 => "nine",
	10 => "ten",
	11 => "eleven",
	12 => "twelve",
	13 => "thirteen",
	14 => "fourteen",
	15 => "fifteen",
	16 => "sixteen",
	17 => "seventeen",
	18 => "eighteen",
	19 => "nineteen"
	);
	$tens = array(
	2 => "twenty",
	3 => "thirty",
	4 => "forty",
	5 => "fifty",
	6 => "sixty",
	7 => "seventy",
	8 => "eighty",
	9 => "ninety"
	);
	$hundreds = array(
	"hundred",
	"thousand",
	"million",
	"billion",
	"trillion",
	"quadrillion"
	); //limit t quadrillion
	$num = number_format($num,2,".",",");
	$num_arr = explode(".",$num);
	$wholenum = $num_arr[0];
	$decnum = $num_arr[1];
	$whole_arr = array_reverse(explode(",",$wholenum));
	krsort($whole_arr);
	$rettxt = "";
	foreach($whole_arr as $key => $i)
	{
		if($i < 20)
		{
			$rettxt .= $ones[$i];
		}
		elseif($i < 100)
		{
			$rettxt .= $tens[substr($i,0,1)];
			$rettxt .= " ".$ones[substr($i,1,1)];
		}
		else
		{
			$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0];
			$rettxt .= " ".$tens[substr($i,1,1)];
			$rettxt .= " ".$ones[substr($i,2,1)];
		}
		
		if($key > 0)
		{
			$rettxt .= " ".$hundreds[$key]." ";
		}
	}
	if($decnum > 0)
	{
		$rettxt .= " and ";
		if($decnum < 20)
		{
			$rettxt .= $ones[$decnum];
		}
		elseif($decnum < 100)
		{
			$rettxt .= $tens[substr($decnum,0,1)];
			$rettxt .= " ".$ones[substr($decnum,1,1)];
		}
	}
	return $rettxt;
} 
// send sms by get smsinfo from database //
// action (1) for send sms, (2) for delivery report, (3) for balance check //
// schedule format should be yyyy-mm-dd H:i:s format //
function sendSmsDynamic($client_id, $msg, $mobile, $schedule="", $sentid="", $action=1)
{
	$sql_sms = "select status from setting_sms_block where sms_id=1";
	$res_sms = mysqli_query($connection,$sql_sms);
	$row_sms = mysqli_fetch_array($res_sms);
	$sms_id = $row_sms['status'];
	//die;
	if($sms_id==1)
	{
	$sttSms = "select * from sms_info where client_id='$client_id'";
	$sqlSms = mysqli_query($connection,$sttSms);
	$rowSms = mysqli_fetch_assoc($sqlSms);
	//die;
	
	$smsuname    = $rowSms['smsuname'];   // sms user name 
	$smspass     = $rowSms['smspass'];    // sms password 
	$smssender   = $rowSms['smssender'];  // sms sender id
	$veruname    = $rowSms['veruname'];   // variable name of user name
	$verpass     = $rowSms['verpass'];    // variable name of password
	$versender   = $rowSms['versender'];  // variable name of sender id
	$vermessage  = $rowSms['vermessage']; // variable name of message
	$vermob      = $rowSms['vermob'];     // variable name of to (mobile no)
	
	$verdate     = $rowSms['verdate'];    // variable of date field for schedule sms
	$verpatter   = $rowSms['verpatter'];  // pattern of date field e.g. ddmmyyyy
	$working_key = $rowSms['working_key'];// working key
	$verkey      = $rowSms['verkey'];     // variable name of working key
	
	$api_url     = $rowSms['api_url'];    // API URL
	$send_api    = $rowSms['send_api'];   // sending page name 
	
	$chk_bal_api = $rowSms['chk_bal_api'];// balance check api
	$sch_api     = $rowSms['sch_api'];    // schedule api
	$status_api  = $rowSms['status_api']; // status api
	
	
	//echo "Called";
	$request = ""; //initialize the request variable
	
	if($working_key == "")
	{
		$param[$veruname] = $smsuname; //this is the username of our TM4B account
		$param[$verpass]  = $smspass; //this is the password of our TM4B account
		
		if($action==1)
		$param[$vermob]   = $mobile; //these are the recipients of the message
	}
	else
	{
		$param[$verkey] = $working_key; //this is the key of our TM4B account
		
		if($action==1)
		$param[$vermob] = "91".$mobile; //these are the recipients of the message
	}
	
	if($action==1)
	{
		$param[$versender]  = $smssender;//this is our sender 
		$param[$vermessage] = $msg; //this is the message that we want to send
	}
	else if($action==2)
	{
		$param['messageid']  = $sentid;//this is our sender 
	}
	
	// for schedule //
	if($schedule!="")
	{
		$timearr = explode(" ",$schedule);
		
		$dateoftime = $timearr[0];
		$timeoftime = $timearr[1];
		
		$datearr = explode("-",$dateoftime); // explode Date //
		$yyyy = $datearr[0]; // year
		$mm   = $datearr[1]; // month
		$dd   = $datearr[2]; // day
		
		$datearr = explode(":",$timeoftime);
		$hh  = $datearr[0];
		$mmt = $datearr[1];
		$ss  = $datearr[2];
		
		$scdltime = strtolower($verpatter);
		$scdltime = str_replace("yyyy",$yyyy,$scdltime);
		$scdltime = str_replace("dd",$dd,$scdltime);
		$scdltime = str_replace("hh",$hh,$scdltime);
		$scdltime = str_replace("ss",$ss,$scdltime);
		$scdltime = preg_replace('/mm/i', $mm, $scdltime, 1);
		$scdltime = str_replace("mm",$mmt,$scdltime);
		
		
		 $param[$verdate] = $scdltime; //this is the schedule datetime //
		
	}
	//print_r($param);	
	foreach($param as $key=>$val) //traverse through each member of the param array
	{ 
		$request.= $key."=".urlencode($val); //we have to urlencode the values
		$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
	}
	$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
	//echo $request;

	if($action=="1") // 1 for send sms //
	$process_api = trim($send_api,"/");
	else if($action=="2") // 2 for Delivery report //
	$process_api = trim($status_api,"/");
	else if($action=="3") // 3 for check balance //
	$process_api = trim($chk_bal_api,"/");
	
	
	//First prepare the info that relates to the connection
	$host = $api_url;
	$script = "/$process_api";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
	  $script .= "?$request";
	}
	
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	
	//echo $header;
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{ 
	  fputs($socket, $header); // send the details over
	  while(!feof($socket))
	  {
		 $output[] = fgets($socket); //get the results 
				
	  }
	  fclose($socket); 
	}
	
	if($action==1)
	{ 
		$cntOutput = count($output);
		$lastValue = $output[$cntOutput-1];
		$expLastValue = explode("=",$lastValue);
		$cntLastValue = count($expLastValue);
		$messageid = $expLastValue[$cntLastValue-1];
		
		return  $messageid;
	}
	else if($action==2 || $action==3)
	{
		return  $output;
	}
	} // end of sms setting
}

function sendSmsDynamicforcronjob($client_id, $msg, $mobile, $schedule="", $sentid="", $action=1)
{
	$sttSms = "select * from sms_info where client_id='$client_id'";
	$sqlSms = mysqli_query($connection,$sttSms);
	$rowSms = mysqli_fetch_assoc($sqlSms);
	
	$smsuname    = $rowSms['smsuname'];   // sms user name 
	$smspass     = $rowSms['smspass'];    // sms password 
	$smssender   = $rowSms['smssender'];  // sms sender id
	$veruname    = $rowSms['veruname'];   // variable name of user name
	$verpass     = $rowSms['verpass'];    // variable name of password
	$versender   = $rowSms['versender'];  // variable name of sender id
	$vermessage  = $rowSms['vermessage']; // variable name of message
	$vermob      = $rowSms['vermob'];     // variable name of to (mobile no)
	
	$verdate     = $rowSms['verdate'];    // variable of date field for schedule sms
	$verpatter   = $rowSms['verpatter'];  // pattern of date field e.g. ddmmyyyy
	$working_key = $rowSms['working_key'];// working key
	$verkey      = $rowSms['verkey'];     // variable name of working key
	
	$api_url     = $rowSms['api_url'];    // API URL
	$send_api    = $rowSms['send_api'];   // sending page name 
	
	$chk_bal_api = $rowSms['chk_bal_api'];// balance check api
	$sch_api     = $rowSms['sch_api'];    // schedule api
	$status_api  = $rowSms['status_api']; // status api
	
	
	//echo "Called";
	$request = ""; //initialize the request variable
	
	if($working_key == "")
	{
		$param[$veruname] = $smsuname; //this is the username of our TM4B account
		$param[$verpass]  = $smspass; //this is the password of our TM4B account
		
		if($action==1)
		$param[$vermob]   = $mobile; //these are the recipients of the message
	}
	else
	{
		$param[$verkey] = $working_key; //this is the key of our TM4B account
		
		if($action==1)
		$param[$vermob] = "91".$mobile; //these are the recipients of the message
	}
	
	if($action==1)
	{
		$param[$versender]  = $smssender;//this is our sender 
		$param[$vermessage] = $msg; //this is the message that we want to send
	}
	else if($action==2)
	{
		$param['messageid']  = $sentid;//this is our sender 
	}
	
	// for schedule //
	if($schedule!="")
	{
		$timearr = explode(" ",$schedule);
		
		$dateoftime = $timearr[0];
		$timeoftime = $timearr[1];
		
		$datearr = explode("-",$dateoftime); // explode Date //
		$yyyy = $datearr[0]; // year
		$mm   = $datearr[1]; // month
		$dd   = $datearr[2]; // day
		
		$datearr = explode(":",$timeoftime);
		$hh  = $datearr[0];
		$mmt = $datearr[1];
		$ss  = $datearr[2];
		
		$scdltime = strtolower($verpatter);
		$scdltime = str_replace("yyyy",$yyyy,$scdltime);
		$scdltime = str_replace("dd",$dd,$scdltime);
		$scdltime = str_replace("hh",$hh,$scdltime);
		$scdltime = str_replace("ss",$ss,$scdltime);
		$scdltime = preg_replace('/mm/i', $mm, $scdltime, 1);
		$scdltime = str_replace("mm",$mmt,$scdltime);
		
		
		 $param[$verdate] = $scdltime; //this is the schedule datetime //
		
	}
	//print_r($param);	
	foreach($param as $key=>$val) //traverse through each member of the param array
	{ 
		$request.= $key."=".urlencode($val); //we have to urlencode the values
		$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
	}
	$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
	//echo $request;

	if($action=="1") // 1 for send sms //
	$process_api = trim($send_api,"/");
	else if($action=="2") // 2 for Delivery report //
	$process_api = trim($status_api,"/");
	else if($action=="3") // 3 for check balance //
	$process_api = trim($chk_bal_api,"/");
	
	
	//First prepare the info that relates to the connection
	$host = $api_url;
	$script = "/$process_api";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
	  $script .= "?$request";
	}
	
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	
	//echo $header;
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{ 
	  fputs($socket, $header); // send the details over
	  while(!feof($socket))
	  {
		 $output[] = fgets($socket); //get the results 
				
	  }
	  fclose($socket); 
	}
	
	if($action==1)
	{ 
		$cntOutput = count($output);
		$lastValue = $output[$cntOutput-1];
		$expLastValue = explode("=",$lastValue);
		$cntLastValue = count($expLastValue);
		$messageid = $expLastValue[$cntLastValue-1];
		
		return  $messageid;
	}
	else if($action==2 || $action==3)
	{
		return  $output;
	}

}


function sendsms($smsuname,$msg_token,$smssender,$msg,$mobile)
{
	//echo "Called";
	//http://loginsms.trinitysolutions.pw/api/send_transactional_sms.php?username=u2377&msg_token=dgy4ws&sender_id=PALITP&message=hello%20nipesh&mobile=9770131555
	$request = ""; //initialize the request variable
	$param["username"] = $smsuname; //this is the username of our TM4B account
	$param["msg_token"] = $msg_token; //this is the password of our TM4B account
	$param["sender_id"] = $smssender;//this is our sender 
	$param["message"] = $msg; //this is the message that we want to send
	$param["mobile"] = $mobile; //these are the recipients of the message
	//print_r($param)	;	//;die;
	foreach($param as $key=>$val) //traverse through each member of the param array
	{// echo $val;
		$request.= $key."=".urlencode($val); //we have to urlencode the values
		$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
	}
	$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
	
	//die;
	//First prepare the info that relates to the connection
	$host = "websms.trinitysolutions.pw";
	$script = "/api/send_transactional_sms.php";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
	  $script .= "?$request";
	}
	
	//echo $host; die;
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	
	//echo $header; die;
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{ 
	  fputs($socket, $header); // send the details over
	  while(!feof($socket))
	  {
		$output[] = fgets($socket); //get the results 
	  }
	  //print_r($output);die;
	  fclose($socket); 
	} 
}

// for send SMS //
function sendSmsByKey($workingkey,$smssender,$msg,$mobile)
{
	//echo "Called";
	$request = ""; //initialize the request variable
	//$param["username"] = $smsuname; //this is the username of our TM4B account
	//$param["password"] = $smspass; //this is the password of our TM4B account
	$param["workingkey"] = $workingkey; //this is the key of our TM4B account
	$param["sender"] = $smssender;//this is our sender 
	$param["message"] = $msg; //this is the message that we want to send
	$param["to"] = "91".$mobile; //these are the recipients of the message
			
	foreach($param as $key=>$val) //traverse through each member of the param array
	{ 
		$request.= $key."=".urlencode($val); //we have to urlencode the values
		$request.= "&"; //append the ampersand (&) sign after each paramter/value pair
	}
	$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
	

	//First prepare the info that relates to the connection
	$host = "alerts.reliableindya.info";
	$script = "/api/web2sms.php";
	$request_length = strlen($request);
	$method = "POST"; // must be POST if sending multiple messages
	if ($method == "GET") 
	{
		$script .= "?$request";
	}
	
	//Now comes the header which we are going to post. 
	$header = "$method $script HTTP/1.1\r\n";
	$header .= "Host: $host\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: $request_length\r\n";
	$header .= "Connection: close\r\n\r\n";
	$header .= "$request\r\n";
	//Now we open up the connection
	$socket = @fsockopen($host, 80, $errno, $errstr); 
	if ($socket) //if its open, then...
	{
		fputs($socket, $header); // send the details over
		while(!feof($socket))
		{
			$output[] = fgets($socket); //get the results 
		}
		fclose($socket);
	}
}


function genNDigitCode($joinchar, $id, $num)
{
	$digit = strlen($id);
	$zeronum = "";
	for($i=$digit; $i<$num;  $i++)
	$zeronum .= "0";
	return $joinchar . $zeronum . $id;
}

// get value from table and generate max no. //
function genMaxNDigitCode($tblname, $colname, $where, $joinchar, $num, $start)
{
	if($where == "")
	$where = 1;
	
	$charlenght = strlen($joinchar);
	
	if($num == "" || $num == 0)
	{
		$sttMaxVal = "SELECT $colname
		FROM $tblname
		where $where
		ORDER BY
		CASE WHEN $colname
		REGEXP '^[A-Z]{2}'
		THEN 1
		ELSE 0
		END desc ,
		CASE WHEN $colname
		REGEXP '^[A-Z]{2}'
		THEN LEFT( $colname , $charlenght )
		ELSE LEFT( $colname , 1 )
		END desc ,
		CASE WHEN $colname
		REGEXP '^[A-Z]{2}'
		THEN CAST( RIGHT( $colname , LENGTH( $colname ) -$charlenght ) AS SIGNED )
		ELSE CAST( RIGHT( $colname , LENGTH( $colname ) -1 ) AS SIGNED )
		END desc";
		
		$sqlMaxVal = mysqli_query($connection,$sttMaxVal);
		$rowMaxVal = mysqli_fetch_array($sqlMaxVal);
		$val = $rowMaxVal[0];
	}
	else
	{
		$val = $this->getvalfield($connection,$tblname, "max($colname)", $where);
	}
	
	$id = preg_replace("/[^0-9]/","",$val);
	$id = intval($id) + 1;
	
	if($id < $start)
	$id = intval($start);
	
	if($num != "" && $num != 0)
	{
		$digit = strlen($id);
		$zeronum = "";
		for($i=$digit; $i<$num;  $i++)
		$zeronum .= "0";
		return $joinchar . $zeronum . $id;
	}
	else
	{
		return $joinchar . $id;
	}
}


// To upload a file with selected extentions only //
function fileupload($controlname, $extention, $convert=false, $width, $height, $uploadfolder)
{
	$uploadfolder = trim($uploadfolder,"/");
	if(isset($_FILES[$controlname]['tmp_name']))
	{
		if($_FILES[$controlname]['error']!=4)
		{
			//$date = new DateTime();
			$timestamp = date('U');
			$swatch = date('B');
			$now = $timestamp.$swatch;
			
			$fname=$_FILES[$controlname]['name'];
			$tm="oc";
			$tm.= $now.strtolower($this->getmixedno(1));
			$ext = pathinfo($fname, PATHINFO_EXTENSION);
			$fname=$tm.".".$ext;
			
			$arrext = explode(",",$extention);
			if(in_array($ext,$arrext))
			{
				if(move_uploaded_file($_FILES[$controlname]['tmp_name'],"$uploadfolder/$fname"))
				{
					if($convert==true)
					{
						if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'bmp' || $ext == 'png')
						$this->convert_image($fname,"$uploadfolder/","$width","$height");
					}
					return $fname;
				}
				else
				return 0;
			}
			else
			return 0;
		}
	}
	else
	return 0;
}

// to get final page name e.g. http://www.mysite.com/index.php?a=1 to index.php//
function finalPageName()
{
	$urlname = $_SERVER["REQUEST_URI"]; //to get complete url //
	$urlurl = explode("/",$urlname); // to explode based on '/' to get array of folders //
	$cnturl = count($urlurl); // count all folders in array //
	$finalpagename_q = $urlurl[$cnturl-1]; // to get last page of url //
	$arr_of_qs = explode("?",$finalpagename_q); // to remove query string from last page //
	$finalpagename = $arr_of_qs[0]; // to get final page name //
	return $finalpagename;
}


// check privileges of any user //
function checkPrivileges($roleid, $finalpagename)
{
	//$finalpagename = $this->finalPageName();
	
	$getprivs = mysqli_query($connection,"select * from setprivilege where roleid='$roleid'");
	$rowprivs = mysqli_fetch_array($getprivs);
	
	$privilegesids	= $rowprivs['privilegesids']; // all privileges id means all pages id in concat //
	$setvalues		= $rowprivs['setvalues']; // all privilege's values //
	
	
	$explode_privilegesids = explode(",",$privilegesids);
	$explode_setvalues = explode(",",$setvalues);
	
	
	$return_priv = "";
	//print_r($explode_privilegesids);
	$sttpagename = "select * from privileges where pageurl='$finalpagename'";
	//echo $sttpagename;
	$getpagename = mysqli_query($connection,$sttpagename);
	$rowpagename = mysqli_fetch_array($getpagename);
	
	if($rowpagename['privilegesid'] != "")
	{
		//echo $rowpagename['privilegesid'];
		$key = array_search($rowpagename['privilegesid'], $explode_privilegesids);
		//echo "..".$key;
		$val = $explode_setvalues[$key];
		
		
		if($val == 1 || $val == 3 || $val == 5 || $val == 7 || $val == 9 || $val == 11 || $val == 13 || $val == 15)
		$return_priv .= "T";
		else
		$return_priv .= "F";
		
		if($val == 2 || $val == 3 || $val == 6 || $val == 7 || $val == 10 || $val == 11 || $val == 14 || $val == 15)
		$return_priv .= "T";
		else
		$return_priv .= "F";
		
		if($val == 4 || $val == 5 || $val == 6 || $val == 7 || $val == 12 || $val == 13 || $val == 14 || $val == 15)
		$return_priv .= "T";
		else
		$return_priv .= "F";
		
		if($val == 8 || $val == 9 || $val == 10 || $val == 11 || $val == 12 || $val == 13 || $val == 14 || $val == 15)
		$return_priv .= "T";
		else
		$return_priv .= "F";
		
		return $return_priv;
	}
}

// to get privileg true or false //
function explodePriv($return_priv,$type)
{
	$view = substr($return_priv,0,1);
	$add = substr($return_priv,1,1);
	$edit = substr($return_priv,2,1);
	$delete = substr($return_priv,3,1);
	
	if($type == "V")
	return $view;
	else if($type == "A")
	return $add;
	else if($type == "E")
	return $edit;
	else if($type == "D")
	return $delete;
}

// get max number from database //
function autonum($tblname, $fldname, $where="")
{
	$stt = "SELECT max($fldname) FROM $tblname ";
	if($where<>"")
	{
		$stt .= "where " . $where;
	}
	
	//echo $stt; die;
	$sql = mysqli_query($connection,$stt);
	$row = mysqli_fetch_row($sql);
	$count=(int)$row[0];
	return $count +1;
}

function check_state_permission($user_type)
{
	if($user_type == "state")
	return "1";
	else
	return "0";
}
function check_admin_permission($user_type)
{
	if($user_type == "admin" || $user_type == "user")
	return "1";
	else
	return "0";
}

// Change hexadecimal color code to rgb color code //
function hex2rgb($hex)
{
	$hex = str_replace("#", "", $hex);
	
	if(strlen($hex) == 3)
	{
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	}
	else
	{
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

function rgb2hex($rgb) {
   $hex = "#";
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

   return $hex; // returns the hex value including the number sign (#)
}

// get admission no. //
function getAdmissionNo($admission_prefix,$admitted_class_id,$admitted_batch_id,$admitted_group_id,$session)
{
	$ad = $this->getvalfield($connection,"student_static_details","max(substring_index(admission_no, '/', -1))","1");
	$admission_no = "";
	
	$lastval = substr(strrchr($ad, "/"), 1); // get last value of '/'
	$id = preg_replace("/[^0-9]/","",$lastval); // remove un numeric values //
	$id++;
	
	$explodeadprefix = explode("||",$admission_prefix);
	$clscgryrss = $explodeadprefix[0];
	$admissinpr = $explodeadprefix[1];
	
	if($clscgryrss == "")
	{
		$admission_no = $admissinpr.$id;
	}
	else
	{
		$admission_no = "";
		$numchar = strlen($clscgryrss);
		for($i=0; $i<$numchar; $i++)
		{
			switch (substr($clscgryrss,$i,1))
			{
				case "C" :
				$admission_no .= "$admitted_class_id/";
				break;
				
				case "B" :
				$admission_no .= "$admitted_batch_id/";
				break;
				
				case "G" :
				{
					if($admitted_group_id != "")
					$admission_no .= "$admitted_group_id/";
				}
				break;
				
				case "Y" :
				$admission_no .= date("Y")."/";
				break;
				
				case "S" :
				$admission_no .= "$session/";
				break;
			}
		}
		$admission_no .= $admissinpr.$id;
	}
	
	return $admission_no;
}




// Calculate Math string //
function calculate_string($mathString) // calculate string equation //
{
	if($mathString == "")
	{
		return 0;
	}
	else
	{
		$mathString = trim($mathString);
		// remove any non-numbers chars; exception for math operators
		$mathString = preg_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString); 
		$compute = create_function("", "return (" . $mathString . ");" );
		return 0 + $compute();
	}
}

// get next / previous session //
function getSession($currentSession, $sessionWants, $operator) // operator for next session '+', previous '-'
{
	$sessionid = $this->getvalfield($connection,"year","yearid","year='$currentSession'");
	
	if($operator=='+')
	$nexsessid = $sessionid + $sessionWants;
	else if($operator=='-')
	$nexsessid = $sessionid - $sessionWants;
	
	return $nextsession = $this->getvalfield($connection,"year","year","yearid='$nexsessid'");
}



function gen_code($tablename,$gen_code,$client_id,$where,$con)
{ 
    $sql = "select max($tablename.$gen_code) as gen_code from  $tablename ";
	$res = mysqli_query($connection,$sql);
	//echo $sql;
	$check = mysqli_num_rows($res);
	$row = mysqli_fetch_array($res);
    $gen_code = $row['gen_code'];
		if(isset($gen_code))
	{   
		   ++$gen_code; 
		   $len = strlen($gen_code);
		   for($i=$len; $i<= 4; ++$i) {
           $num = '0'.$num;
            }
			$comp = $num.$gen_code; 

	}
	else
	//for first invoiceno
	{
		 for($i=0; $i<4; ++$i)
		 {
		   $num = '0'.$num;
		 }
	 $x =1;
	 $gen_code = $num .$x ;
	}
	
	//echo $gen_code; die;
	return $gen_code;
	
}

function getcode($connection,$tablename,$tablepkey,$cond)
{
	$num =  $this->getvalfield($connection,$tablename,"max($tablepkey)",$cond);
	//if($num == NULL)
	//$num = 0;
    ++$num; // add 1;
    $len = strlen($num);
    for($i=$len; $i< 5; ++$i) {
        $num = '0'.$num;
    }
    return $num;
}



}
?>