<?php
 include("dbconnect.php");
 $truckid = isset($_REQUEST['truckid'])?trim(addslashes($_REQUEST['truckid'])):'';
 $drivername = isset($_REQUEST['drivername'])?trim(addslashes($_REQUEST['drivername'])):'';
 $currdate = date('Y-m-d');
 
 $truckwiseuchanti =0;
 $truckwiseincome=0;
 $truckwiseexpense=0;
 $salary_deduction=0;
 $amount=0;
 
 

 if($truckid !='')
 {
$truckwiseuchanti = $cmn->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && paymentdate between '2018-08-01' and '$currdate'"); 
$truckwiseincome = $cmn->getvalfield($connection,"otherincome","sum(incomeamount)","truckid='$truckid' && paymentdate between '2018-08-01' and '$currdate'"); 
$truckwiseexpense = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && paymentdate between '2018-08-01' and '$currdate'"); 
$salary_deduction = $cmn->getvalfield($connection,"salary_deduction","sum(deduct_amt)","truckid='$truckid' && deduct_date between '2018-08-01' and '$currdate'");
$amount = $truckwiseuchanti - $truckwiseincome - $truckwiseexpense-$salary_deduction;
 }
 
 echo $amount;
 ?>