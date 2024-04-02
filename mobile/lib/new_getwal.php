<?php

class Comman {
	
	// get value from any condition //
function getvalfield($connection,$table,$field,$where)
{
	$sql = mysqli_query($connection,"set names utf-8 ");
	$sql = "select $field from $table where $where";
	//echo $sql;
	
	//die;
	$getvalue = mysqli_query($connection,$sql);
	$getval = mysqli_fetch_row($getvalue);

	return $getval[0];
}


function getdayname($name) {

		if($name=="Mon") { $msg = "सोमवार";    }
		else if($name=="Tue") { $msg = "मंगलवार";     }
		else if($name=="Wed") {  $msg = "बुधवार";  }
		else if($name=="Thu") {  $msg = "गुरुवार";    }
		else if($name=="Fri") {   $msg = "शुक्रवार";   }
		else if($name=="Sat") {   $msg = "शनिवार";   }
		else if($name=="Sun") {   $msg = "रविवार";    }
		else {   $msg = "";   }
		
		return $msg;

}


// get date format (01-03-2012) from (2012-03-01) //
function dateformatindia($date)
{
	$ndate = explode("-",$date);
	$year = $ndate[0];
	$day = $ndate[2];
	$month = $ndate[1];
	
	if($date == "0000-00-00" || $date =="")
	return "";
	else
	return $day . "-" . $month . "-" . $year;
	
}


		function getpurchasetilldate($connection,$fromdate,$suppartyid) {
	$pur=0;
	$sql = mysqli_query($connection,"select purchaseid from purchaseentry where purchasedate <= '$fromdate' && suppartyid='$suppartyid'");
	while($row=mysqli_fetch_assoc($sql)) {
	$pur +=$this->gettotalpurchase($connection,$row['purchaseid']);
	}
	
	return $pur;
	}
	
		function getrounfsaleamt($connection,$date,$suppartyid) {
	$saleamount=0;
	
	$sql = mysqli_query($connection,"select billdate from saleenetry where suppartyid='$suppartyid' and billdate <='$date' group by billdate");
	while($row=mysqli_fetch_assoc($sql))	
	{
	$billdate = $row['billdate'];		
	$saleamount += round($this->getvalfield($connection,"saleenetry","sum((qty * rate * weight)+(qty * unitrate))","suppartyid='$suppartyid' and billdate ='$billdate'"));
	}
	return $saleamount;
	
	}
	
	
	function gettotalpurchase($connection,$purchaseid) {
	
	$netamount = 0;
	$total_unit_rate=0;
	$sql = mysqli_query($connection,"select * from purchaseentrydetail where purchaseid='$purchaseid'");
	while($row=mysqli_fetch_assoc($sql)) {
	$total = $row['qty'] * $row['weight'] * $row['rate'];
	$total_unit_rate += $row['qty'] * $row['unitrate'];
	$netamount += $total ;
	}
	
	
	$tot_exp = 0;
	$sql = mysqli_query($connection,"select * from purchaseexp where purchaseid='$purchaseid'");
	while($row=mysqli_fetch_assoc($sql))
	{
	
	$type = $row['type'];
	$expprocess = $row['expprocess'];
	
	if($type=='rs')
	{
	$expamt = $row['expamt'];
	}
	else
	{
	$expamt = ($netamount * $row['expamt'])/100;
	}
	
	if($expprocess=='Add') {
	$tot_exp += $expamt;
	}	
	else
	{
	$tot_exp -= $expamt;
	}
	}	
	
	//echo $total_unit_rate;
	return round($netamount + $tot_exp + $total_unit_rate);
	}
	

	
	
	function getopeningbalcust_New($connection,$suppartyid,$fromdate) {

     $openbal = $this->getvalfield($connection,"m_supplier_party","prevbalance","suppartyid='$suppartyid'");
	//$tilldate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
	 $totbillamt = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <'$fromdate' and type='Sale'");	
	 $totalpaid = $this->getvalfield($connection,"customer_new_book","sum(credit)","supplier_id='$suppartyid' and cdate <'$fromdate' and type='Sale_Payment'");
	
	$totpur = $this->getvalfield($connection,"customer_new_book","sum(credit)","supplier_id='$suppartyid' and cdate <'$fromdate' and type='Purchase'");	
	$purpay = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <'$fromdate'  and type='Purchase_Payment'");
	
	 $loadamt = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <'$fromdate' and type='Loading'");

	return $openbal + $totbillamt - $totalpaid - $totpur + $purpay + $loadamt;
	}


	function getopeningbalcust($connection,$suppartyid,$fromdate) {

     $openbal = $this->getvalfield($connection,"m_supplier_party","prevbalance","suppartyid='$suppartyid'");
	//$tilldate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
	 $totbillamt = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <='$fromdate' and type='Sale'");		
	 //$totbillamt =  "call getTotal($suppartyid,'$fromdate','Sale')";
	 
	 $totalpaid = $this->getvalfield($connection,"customer_new_book","sum(credit)","supplier_id='$suppartyid' and cdate <='$fromdate' and type='Sale_Payment'");
	
	$totpur = $this->getvalfield($connection,"customer_new_book","sum(credit)","supplier_id='$suppartyid' and cdate <='$fromdate' and type='Purchase'");	
	$purpay = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <='$fromdate'  and type='Purchase_Payment'");
	//$purpay =  "call getTotal($suppartyid,'$fromdate','Purchase_Payment')";
	 $loadamt = $this->getvalfield($connection,"customer_new_book","sum(debit)","supplier_id='$suppartyid' and cdate <='$fromdate' and type='Loading'");
	//$loadamt = "call getTotal($suppartyid,'$fromdate','Loading')";
	return $openbal + $totbillamt - $totalpaid - $totpur + $purpay + $loadamt;
	}
	
	
	function getopeningbalcust2($connection,$suppartyid,$fromdate) {

    	$openingbal =  mysqli_query($connection,"call openingBal($suppartyid,'$fromdate',@openning_amt)");
				$res =  mysqli_query($connection,"Select @openning_amt");
		$row=mysqli_fetch_assoc($res);	
        return $row['@openning_amt'];
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


function getcarretroaker($connection,$suppartyid,$fromdate,$todate) {

$nettoral= 0;
$roaker= array();	

$sql_get = mysqli_query($connection,"Select Distinct(date) From (
select billdate as date from saleenetry where 1=1 and suppartyid='$suppartyid' and billdate between '$fromdate' and '$todate'
 UNION ALL select billdate as date from carretentry where 1=1 and suppartyid='$suppartyid'  and billdate between '$fromdate' and '$todate'
  UNION ALL  select purchasedate as date from purchaseentry where 1=1 and suppartyid='$suppartyid' and purchasedate between '$fromdate' and '$todate'
   UNION ALL select loaddate as date from loading where 1=1 and suppartyid='$suppartyid' and loaddate between '$fromdate' and '$todate')A group by date ORDER BY date");

while($row_get = mysqli_fetch_assoc($sql_get))
{
	//print_r($row_get);
	$date = $row_get['date'];				
	$msg='';
				
	$custarray = array();	
	$supparray=array();	
	$loadarray =array();	
	$sql = mysqli_query($connection,"select unitid,unit_name,unit_name_hindi from m_unit where isstockable=1");
				while($row=mysqli_fetch_assoc($sql)) {
				
			$msg='';			
			$unitid = $row['unitid'];
			$unit_name = $row['unit_name'];
			
			$dateopen = date('Y-m-d', strtotime('-1 day', strtotime($date)));
			$cartbalopen = $this->getcarretopenbydate($connection,$suppartyid,$unitid,$dateopen);
			
					 $salecaret = $this->getvalfield($connection,"saleenetry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate='$row_get[date]'");
					 $recaret = $this->getvalfield($connection,"carretentry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate='$row_get[date]' && is_sup=0");
					 
					 $returncaret = $this->getvalfield($connection,"carretentry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate='$row_get[date]' && is_sup=1");
					 
					 $purcaret  = $this->getvalfield($connection,"purchaseentrydetail as A left join purchaseentry as B on A.purchaseid=B.purchaseid","sum(qty)","suppartyid='$suppartyid' and A.unitid='$unitid' && purchasedate='$row_get[date]'");
					 
					  $loadcaret  = $this->getvalfield($connection,"loaderentry as A left join loading as B on A.lodingid=B.lodingid","sum(qty)","suppartyid='$suppartyid' and A.unitid='$unitid' && loaddate='$row_get[date]'");
					 
					$tot = 0;				
					
					$net =  $cartbalopen - $recaret + $salecaret; 
					
					if($retaty_rec !='') { $recno = '- Rec. No.'.$retaty_rec; } else { $recno='';}
					if($salecaret !=0) { $msg.="Sale Carret Out /"; }
					if($recaret !=0) { $msg.="Sale Carret In $recno/"; }
					$process="Customer";
					$custarray[]=array($unit_name,$process,$msg,$salecaret,$recaret,-$recaret + $salecaret,$net);
					
					
					$msg='';
					
					if($returncaret !=0) { $msg.="Bijak Carret Out /"; }
					if($purcaret !=0) { $msg.="Bijak Carret In $recno/"; }
					$process="Supplier";
					$net =  $net - $purcaret+$returncaret;
					
					$supparray[] = array($unit_name,$process,$msg,$returncaret,$purcaret,-$purcaret+$returncaret,$net);
					
					
					$msg='';
					
					
					if($loadcaret !=0) { $msg.="Loading/"; }
					$process="Loader";
					$net =  $net + $loadcaret;
					
					$loadarray[] = array($unit_name,$process,$msg,$loadcaret,"0",$loadcaret,$net);
					
					
				

	} //unitm
	
	
	$newar = array($date,$custarray);			
	$roaker[] = $newar;
	
	$newar = array($date,$supparray);			
	$roaker[] = $newar;
	
	$newar = array($date,$loadarray);			
	$roaker[] = $newar;
		
}	
	
	return $roaker;
}

function getcarretopenbydate($connection,$suppartyid,$unitid,$date) {
		
		$openbalcar = $this->getvalfield($connection,"openingunitentry","openunit","suppartyid='$suppartyid' and unitid='$unitid' && type=0");			
		$qtycartoon = $this->getvalfield($connection,"saleenetry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate <='$date'"); 
	    $retaty = $this->getvalfield($connection,"carretentry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate <='$date' && is_sup=0");
		
		 $purqtycartoon = $this->getvalfield($connection,"purchaseentrydetail as A left join purchaseentry as B on A.purchaseid=B.purchaseid","sum(A.qty)","B.suppartyid='$suppartyid' and A.unitid='$unitid' && purchasedate <='$date'");  
		$purretaty = $this->getvalfield($connection,"carretentry","sum(qty)","suppartyid='$suppartyid' and unitid='$unitid' && billdate <='$date' && is_sup=1");
		
		$loadingcaret = $this->getvalfield($connection,"loaderentry as A left join loading as B on A.lodingid=B.lodingid","sum(A.qty)","B.suppartyid='$suppartyid' and A.unitid='$unitid' && loaddate <='$date'");  
	
		return $openbalcar + $qtycartoon - $retaty - $purqtycartoon + $purretaty + $loadingcaret;			

}


}
?>