<?php error_reporting(0);
ini_set("memory_limit","1500M");
include("dbconnect.php");

include("./mpdf/mpdf.php");

if(isset($_GET['ownerid'])) {
        $ownerid = trim(addslashes($_GET['ownerid']));
    }
    else
    $ownerid='';
    
    
    if(isset($_GET['truckid'])) {
        $truckid = trim(addslashes($_GET['truckid']));
    }
    else
    $truckid='';

if(isset($_GET['fromdate'])) {
    $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate = $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  }
  else
  $todate=date('Y-m-d');

    $crit = "";
  $cond="";
  $cond2="";
    if($ownerid !='') {
        $crit = " and truckid in(select truckid from m_truck where ownerid='$ownerid') ";
        }

    if($truckid !='') {
        $crit = " and truckid='$truckid'";
        }


if($fromdate !='' && $todate !='' ) {
  $cond = "and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate' "; 
  $cond2 = " and payment_date between '$fromdate' and '$todate' "; 
}


$mpdf=new mPDF('utf-8','A4');
$mpdf->AddPage('L','','','','','4','4','4','4');
//$bills_arr = explode (",", $bills);  
 
	
	
$html ='
<html>
<head>
<style>
td.small {
  line-height: 0.7;
}
</style>
<meta charset="utf-8">
</head>';

$slno = 1;
        $netpayamt = 0;

  $sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1 $crit $cond order by tokendate desc";

    $res_table = mysqli_query($connection,$sql_table);

 
                            
                               	$html.="
                               	<div>
                               		<div>
                               		<div>
                               		<table style='width:100%'>
                               		<tr><th colspan='2' style='height:0px;border:#000000 1px solid;'>Truck Owner Ledger Details</th>
                               		</tr>
                               		<tr>";
                               			$company_owner = "SELECT * FROM `m_company` ";

                               		$cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){

                               		$html.="<th  style='text-align:left;
                               		height:0px;border:#000000 1px solid;'>
                               		<h2>".$onwer['cname']."</h2>
                               		<p>".$onwer['headaddress']."</p>
                               		</th>";
                               	}
                               		$track_owner = "SELECT * FROM `m_truckowner` where `ownerid`='$ownerid' ";

                               		$tracK_table = mysqli_query($connection,$track_owner);
                               while($trcuk = mysqli_fetch_assoc($tracK_table)){

                               		$html.="<th  style='height:40px;border:#000000 1px solid; text-align:right;'>
                               		<p>".$trcuk['ownername']."</p>
                               		<p>".$trcuk['mobileno1']."</p>
                               		<p>".$trcuk['owneraddress']."</p>
                               		</th>
                               		</tr>
                               		<tr><th colspan='2' style='text-align:left;border:#000000 1px solid;'>Opening Balance : ".$netpayamt."</th>
                               		</tr>

                               		<tr>
                               		<th  style='text-align:left;border:#000000 1px solid;'>From Date  : ".$cmn->dateformatindia($fromdate)."</th>
                               		<th style='text-align:left;border:#000000 1px solid;'>To Date : ".$cmn->dateformatindia($todate)."</th>
                               		</tr>

                               		</table>
                               		</div>
                               		</div>";
                               	}

                      $html.="
                      	

                      	<div style='align:left; float:left;width:60%'>  
                      		<table>
                      		<thead>
                      		<tr><th colspan='9' style='border:#000000 1px solid;background: grey; color:white;'>Dispatch Details</th></tr>
                      		<tr>
                      			<th style='border:#000000 1px solid;'>S.No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Consignee</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>LR No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>LR Date</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Truck No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Total <p> Weight</p></th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Com<p> Rate </p></th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Final <p> Rate </p></th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Total Amt</th>
                      			</tr>
                      		</thead>
                      		<tbody>";

                      		 while($row_table = mysqli_fetch_assoc($res_table))
                                            {
                                                 $freightamt=$row_table['freightamt'];
											  
											    
											    $newrate=$row_table['newrate'];
											    
										
												$biltyAmt = $row_table['recweight'] * $freightamt;
                                                $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
                                             $consignee = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row_table[consigneeid]'");

                        $html.="

                        		<tr>
                        			<td style='border:#000000 1px solid;font-size:12;margin:0px!important;padding:0px;'>".$slno++."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$consignee."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$row_table['lr_no']."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$row_table['tokendate']."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$truckno."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$row_table['totalweight']."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$freightamt."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$newrate."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".number_format($biltyAmt,2)."</td>
                        			
                        		</tr>
                                        ";
				$netbilty += $biltyAmt;
                                            }

                      		$html.="
                      			<tr>
                      				<td colspan='5' style='text-align:center; border:#000000 1px solid;font-size:14;'><b>Total</b></td>
                      				<td colspan='4' style='text-align:right;border:#000000 1px solid;font-size:14;'><b>".number_format(round($netbilty),2)."</b></td>

                      			</tr>
                      		</tbody>
                      		</table>

                      	</div>
                      	<div style='style='align:right!important;float:right; width:40%''>
                      	<table>
                      		<thead>
                      		<tr><th colspan='8' style='border:#000000 1px solid; background: grey; color:white;'>Bilty Payment Details </th></tr>
                      		<tr>
                      			<th style='border:#000000 1px solid;'>S.No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>LR No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Cash Adv</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Diesel Adv</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Fright Date</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Fright Paid Amount <p> Weight</p></th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Total Paid Amount <p> Rate </p></th>
                      			
                      			</tr>
                      		</thead>
                      		<tbody>";
                       $slno = 1;
        $netpayamt = 0;

        $sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1 $crit  $cond2 order by tokendate desc";                                           
                                            $res_table = mysqli_query($connection,$sql_table);
          while($row_table = mysqli_fetch_assoc($res_table))
                                            {
                                                $payment = $row_table['cashpayment'] + $row_table['chequepayment'] + $row_table['neftpayment'];
                                                $totalamt = $payment  + $row_table['adv_cash'] + $row_table['adv_diesel'];

                                       $html.="<tr>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$slno++."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['lr_no']."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['adv_cash']."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['adv_diesel']."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$cmn->dateformatindia($row_table['payment_date'])."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".number_format($payment,2)."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".number_format($totalamt,2)."</td>

                                       </tr>";
$netpayamt += $totalamt;
                                            }

$balamt = $prevbalance + $netbilty - $netpayamt;
                      	$html.="


                      	<tr>
                      				<td colspan='4' style='text-align:center; border:#000000 1px solid;font-size:14;'><b>Total</b></td>
                      				<td colspan='4' style='text-align:right;border:#000000 1px solid;font-size:14;'><b>".number_format(round($netpayamt),2)."</b></td>

                      			</tr></tbody>
                      		</table>


                      		</div>
                      			</div>
                      	<div>
                      		<table width='100%'>
                      			<tr>
                      				<th  style='text-align:right;border:#000000 1px solid;font-size:14;'>Balance Amt : ".number_format(round($balamt),2)."</th>
                      			<tr>
                      			<tr>
                      				<th  style='text-align:right;border:#000000 1px solid;font-size:14; height:60px; padding-right:20px;'>Signature with Date</th>
                      			<tr>
                      		</table>
                      	</div>
                      ";

                    








//==============================================================

$mpdf->WriteHTML($html);



$mpdf->SetTitle('Truck Owner Ledger Details');
$mpdf->Output();

if ($_REQUEST['html']) //{ //echo $html; exit; }
if ($_REQUEST['source']) { 
	$file = __FILE__;
	header("Content-Type: text/plain");
	header("Content-Length: ".filesize($file));
	header("Content-Disposition: attachment; filename='".$file."'");
	readfile($file);
    exit; 
}



//exit;
//==============================================================
?>
<!--<img  src="../uploaded/registration/".$imge width="172px" height="136px"/> -->
