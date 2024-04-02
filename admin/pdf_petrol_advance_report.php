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


if($fromdate !='--' && $todate !='--' ) {
  $cond = "and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate' "; 
  $cond2 = " and payment_date between '$fromdate' and '$todate' "; 
}
$slno = 1;
        $netpayamt = 0;

   $sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1 $crit $cond order by tokendate desc";

    $res_table = mysqli_query($connection,$sql_table);


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
</head>
<body>';

                            
                                $html.="
                             
                                  <table style='width:100%'>
                                  <tr><th  style='height:0px;border:#000000 1px solid;'>Advance Petrol Advance Report</th>
                                  </tr>
                                  <tr>";
                                    $company_owner = "SELECT * FROM `m_company` ";

                                  $cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){

                                  $html.="<th  style='text-align:center;
                                  height:0px;border:#000000 1px solid;'>
                                  <h2>".$onwer['cname']."</h2>
                                  <p>".$onwer['headaddress']."</p>
                                  </th>";
                                }
                                  
                                  
                                  $html.="</tr></table>
                                 ";



                          $html.="
                        

                    
                          <table  style='width:100%'>
                          <thead>
                          <tr><th colspan='5' style='border:#000000 1px solid;background: grey; color:white;'>Petrol Details</th></tr>
                          <tr>
                            <th style='border:#000000 1px solid;'>S.No</th>
                            
                            <th style='font-size:12;border:#000000 1px solid;'>LR No</th>
                            
                             <th style='font-size:12;border:#000000 1px solid;'>Petrol Pump</th>
                            <th style='font-size:12;border:#000000 1px solid;'>Truck No</th>
                            <th style='font-size:12;border:#000000 1px solid;'>Advance Diesel </th>
                          
                            
                            </tr>
                          </thead>
                          <tbody>";
                        
                    $netbilty =0;
                     
                      $slno = 1;
                  echo $sql_table = "select * from bidding_entry where 1=1 $crit $cond order by adv_date desc";
                       
                      $res_table = mysqli_query($connection,$sql_table);
                      while($row_table = mysqli_fetch_assoc($res_table))
                      {
                          
                          $freightamt=$row_table['freightamt'];
                          $comp_rate=$row_table['comp_rate'];
                           $supplier_id=$row_table['supplier_id'];

                          if($comp_rate==0){
                              $new_comp=$freightamt;
                          }else{
                              $new_comp=$comp_rate;
                          }
                        $biltyAmt = $row_table['totalweight'] * $new_comp;
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
                        $consignor = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row_table[consignorid]'");


                        $sql_supp= mysqli_query($connection,"select supplier_id,supplier_name from inv_m_supplier where supplier_id='$supplier_id'");
                        $row_supp = mysqli_fetch_array($sql_supp);
                      
                          $html.="

                            <tr>
                              <td style='border:#000000 1px solid;font-size:12;margin:0px!important;padding:0px;'>".$slno++."</td>
                              <td style='border:#000000 1px solid;font-size:12;'>".$row_table['lr_no']."</td>
                              <td style='border:#000000 1px solid;font-size:12;'>".$row_supp['supplier_name']."</td>
                              <td style='border:#000000 1px solid;font-size:12;'>".$truckno."</td>
                              <td style='border:#000000 1px solid;font-size:12;'>".number_format(round($row_table['adv_diesel']),2)."</td>
                             
                            </tr>";
                              $net_adv_diesel += $row_table['adv_diesel'];
                          }

                    
             $html.="<tr>

                          <td colspan='4' style='border:#000000 1px solid;background: grey; color:white; text-align:right; padding-right:20px;'>Total</td>
                          <td colspan='1' style='border:#000000 1px solid;background: grey; color:white;'>".number_format(round($net_adv_diesel),2)."</td>
                      </tr>
                      </tbody>
                      </table>
                      
                      </body>
                      </html>";         







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
