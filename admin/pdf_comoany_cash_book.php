<?php error_reporting(0);
ini_set("memory_limit","1500M");
include("dbconnect.php");

include("./mpdf/mpdf.php");

if(isset($_GET['fromdate'])) {
    $fromdate = trim(addslashes($_GET['fromdate']));
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate = trim(addslashes($_GET['todate']));
  }
  else
  $todate=date('Y-m-d');



  

  $cond="";
  $cond2="";



if($fromdate !='' && $todate !='' ) {
  $cond = "and paymentdate between '$fromdate' and '$todate' "; 

  $cond2 = " and adv_date between '$fromdate' and '$todate' "; 
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

        $prevbalance =$cmn->getcashopeningplant($connection,$fromdate);
  
 
                            
                               	$html.="
                               	<div>
                               		<div>
                               		<div>
                               		<table style='width:100%'>
                               		<tr><th colspan='2' style='height:0px;border:#000000 1px solid;'>Comapany Cash Book - Shree</th>
                               		</tr>
                               		<tr>";
                               			$company_owner = "SELECT * FROM `m_company` ";

                               		$cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){

                               		$html.="<th colspan='2' style='text-align:center;
                               		height:0px;border:#000000 1px solid;'>
                               		<h2>".$onwer['cname']."</h2>
                               		<p>".$onwer['headaddress']."</p>
                               		</th>";
                               	}
                               	
                               		$html.="
                               		</tr>
                               		<tr><th colspan='2' style='text-align:left;border:#000000 1px solid;'>Opening Balance : ".$prevbalance."</th>
                               		</tr>

                               		<tr>
                               		<th  style='text-align:left;border:#000000 1px solid; width:50%'>From Date  : ".$cmn->dateformatindia($fromdate)."</th>
                               		<th style='text-align:left;border:#000000 1px solid; width:50%'>To Date : ".$cmn->dateformatindia($todate)."</th>
                               		</tr>

                               		</table>
                               		</div>
                               		</div>";
                             

                      $html.="
                      	

                      	<div style='align:left!important; float:left; width:50%'>  
                      		<table style='width:100%'>
                      		<thead>
                      		<tr><th colspan='5' style='border:#000000 1px solid;background: grey; color:white;'>Payment Receive</th></tr>
                      		<tr>
                      			<th style='border:#000000 1px solid;'>S.No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Date</th>
                      			
                      			<th style='font-size:12;border:#000000 1px solid;'>Head</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Payname</th>
                            <th style='font-size:12;border:#000000 1px solid;'>Amount</th>
                      			
                      			</tr>
                      		</thead>
                      		<tbody>";
              $sql_table = "SELECT * FROM `otherincome`  where 1=1 and payment_type='cash' $cond";
                       
                       $res_table = mysqli_query($connection,$sql_table);
                      while($row_table = mysqli_fetch_assoc($res_table))
                      {
                          
                           $paymentdate=$row_table['paymentdate'];
                          $incomeamount=$row_table['incomeamount'];
                          
                        $head_id = $row_table['head_id'];
                        $payeename = $row_table['payeename'];
                      $headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$head_id'");
                        
                        
                        $html.="

                        		<tr>
                        			<td style='border:#000000 1px solid;font-size:12;margin:0px!important;padding:0px;'>".$slno++."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$cmn->dateformatindia($paymentdate)."</td>
                        			
                        			<td style='border:#000000 1px solid;font-size:12;'>".$headname."</td>
                        			<td style='border:#000000 1px solid;font-size:12;'>".$payeename."</td>
                              <td style='border:#000000 1px solid;font-size:12;'>".$incomeamount."</td>
                        		
                        		</tr>
                                        ";
				$netbilty += $incomeamount;
                                            }

                      		$html.="
                      			<tr>
                      				<td colspan='4' style='text-align:center; border:#000000 1px solid;font-size:14;'><b>Total</b></td>
                      				<td colspan='1' style='text-align:right;border:#000000 1px solid;font-size:14;'><b>".number_format(round($netbilty),2)."</b></td>

                      			</tr>
                      		</tbody>
                      		</table>

                      	</div>
                      	<div style='style='align:right!important;float:right; width:50%''>
                      	<table style='width:100%'>
                      		<thead>
                      		<tr><th colspan='6' style='border:#000000 1px solid; background: grey; color:white;'>Pay Expenses </th></tr>
                      		<tr>
                      			<th style='border:#000000 1px solid;'>S.No</th>
                            <th style='font-size:12;border:#000000 1px solid;'>Date</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>CR No</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Truck NO</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Cash Adv</th>
                      			<th style='font-size:12;border:#000000 1px solid;'>Other Adv</th>
								<th style='font-size:12;border:#000000 1px solid;'> Adv (Consignor)</th>
                      			
                      			
                      			</tr>
                      		</thead>
                      		<tbody>";
                       $slno = 1;
        $netadv = 0;
                      $netotherAdv = 0;

         $sql_table = "select *,DATE_FORMAT(adv_date,'%d-%m-%Y') as adv_date from bidding_entry where 1=1  $cond2 and adv_cash !=0 || adv_other != 0  || adv_consignor != 0 order by adv_date desc";	                   
                      $res_table = mysqli_query($connection,$sql_table);
                      while($row_table = mysqli_fetch_assoc($res_table))
                      {
                        
                          $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");

                                       $html.="<tr>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$slno++."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$cmn->dateformatindia($row_table['adv_date'])."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['lr_no']."</td>
                                        <td style='border:#000000 1px solid;font-size:12;'>".$truckno."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['adv_cash']."</td>
                                       <td style='border:#000000 1px solid;font-size:12;'>".$row_table['adv_other']."</td>
									     <td style='border:#000000 1px solid;font-size:12;'>".$row_table['adv_consignor']."</td>
                                      
                                       
                                       </tr>";
    $netadv += $row_table['adv_cash'];
                      $netotherAdv+=$row_table['adv_other']+$row_table['adv_consignor'];
                                            }

$balamt = $prevbalance + $netbilty - $netadv-$netotherAdv; 
                      	$html.="


                      	<tr>
                      				<td colspan='4' style='text-align:center; border:#000000 1px solid;font-size:14;'><b>Total</b></td>
                              <td  style='text-align:right;border:#000000 1px solid;font-size:14;'><b>".number_format(round($netadv),2)."</b></td>
                      				<td  style='text-align:right;border:#000000 1px solid;font-size:14;'><b>".number_format(round($netotherAdv),2)."</b></td>

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



$mpdf->SetTitle('Company Cash Book Details');
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
