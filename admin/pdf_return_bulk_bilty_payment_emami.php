<?php 

error_reporting(0);           
include("dbconnect.php");
include("../fpdf17/fpdf.php");

if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0;  
  
  $cond=' ';
  
  
  
  if(isset($_GET['di_no']))
  {
    $di_no = trim(addslashes($_GET['di_no']));  
  }
  else
  $di_no = '';
  
  if(isset($_GET['ownerid']))
  {
    $ownerid = trim(addslashes($_GET['ownerid']));  
  }
  else
  echo $ownerid = '';
  

  $payinvo=$_GET['payinvo'];
  $cond= " where 1=1";
  if($payinvo!=' ' ) {
    
    $cond .=" and B.voucher_id ='$payinvo'";
    
    }
    if($ownerid !='') {
    
    $cond .=" and A.ownerid='$ownerid'";
    }
$c_logo = $cmn->getvalfield($connection,"m_company","c_logo","compid='$_SESSION[compid]'");
   
    $res_table = mysqli_query($connection,$sql_table);
                                        $pdf = new FPDF();
                                        $pdf->AddPage('L','A4',2);
                                          
                                    $company_owner = "SELECT * FROM `m_company` where compid='$compid' ";
                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){
      
                                   $pdf->Image('logo/'.$c_logo,10,5,20);
	
                                                    
                                        $pdf->SetX(33);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,$onwer['cname'],2,0,'L');
                                        
                                         $pdf->SetX(130);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        $pdf->Ln();

                                        $pdf->SetX(33);
                                         $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(270,6,$onwer['headaddress'],2,0,'L');
                                        $pdf->Ln();

                                            
                                         $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(125,-20,'Contact : '.$onwer['mobileno1'].",".$onwer['mobileno2'],2,0,'R');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(150,5,'',2,0,'L');
                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,-10,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                         
                                                                               

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,8,'PAN No. : '.$onwer['pan_card'],2,0,'R');
                                        $pdf->Ln();


                                         $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(150,10,'',2,0,'R');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(125,2,'GST No. : '.$onwer['gst_no'],2,0,'R');
                                        $pdf->Ln();

                                           }

                                           $lh = 100;
                                            $lw= $lh+8;

                                            $pdf->Line(5, 30, 290,30);
                                             $pdf->Ln(8);

                                              $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','B',12);


                                         $OWNIID= $_GET['ownerid'];
                  $OWN="SELECT * FROM `m_truckowner` WHERE `ownerid`=$OWNIID";
                  $OWNres = mysqli_query($connection,$OWN);
                                  $OWNrow = mysqli_fetch_array($OWNres);
                                    
                                        
                   $invoicquery = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.compid=$compid && B.recweight !='0' ";

                                            $invres = mysqli_query($connection,$invoicquery);
                                    $incrow = mysqli_fetch_array($invres);

                                    $inc_payment_dat=$incrow['payment_date']; 
									 $paidto=$incrow['paidto']; 
                   $remark=$incrow['remark']; 
                                    $voucher_id=$incrow['voucher_id'];  

                                  $vou_query="SELECT `payment_vochar` FROM `return_bulk_payment_vochar` WHERE `bulk_voucher_id`='$voucher_id'";
                                
                                $voures = mysqli_query($connection,$vou_query);
                                    $vocrow = mysqli_fetch_array($voures);
                                    $voucharno= $vocrow['payment_vochar'];

                        $pdf->Cell(125,10,'Truck Owner: '.$OWNrow['ownername'] ,2,0,'L');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);

                                       $pdf->Cell(55,10,'',2,0,'L');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(85,8,'Voucher No.: '.$voucharno,2,0,'L');
                                        $pdf->Ln();

                                              $pdf->SetFont('Arial','',10);
											  
											   $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','B',10);
                                       $pdf->Cell(95,10,'Paid To : '.$paidto ,2,0,'L');
									   

                                       $pdf->Cell(5,10,'',2,0,'L');
                                         $pdf->SetFont('Arial','',10);
                                       $pdf->Cell(80,10,'Received Date : '.date('d-m-Y',strtotime($inc_payment_dat)) ,2,0,'L');
                                         
                                               

                                        $pdf->SetFont('Arial','',10);

                                      // $pdf->Cell(55,10,'',2,0,'L');

                                        $pdf->SetFont('Arial','',10);
                                        $pdf->Cell(85,8,'Location: Raipur',2,1,'L');
                                        $pdf->SetFont('Arial','B',10);
                                        $pdf->Cell(85,10,'Remark: '.$remark ,2,0,'L');
                                        // $pdf->Cell(95,10,'Remark : '.$remark ,2,0,'L');


                                        $pdf->Ln(10);

                                          $pdf->SetFont('Arial','B',8);
                                                    $pdf->Cell(6,8,'S.N',1,0,'C');

                                                     

                                                   
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(10,8,'LR No',1,0,'L');
                                                     
                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(16,8,'Bilty Date',1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,8,'Truck No',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(30,8,'Destination',1,0,'L');
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,8,'Wt.(MT)',1,0,'R');
                                                     $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(15,8,'Rec.wt(MT)',1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,8,'Com. Rate',1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',7);
                                                    //  $pdf->Cell(13,8,'Commi.',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,8,'Rate',1,0,'L');
                                                    
                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,8,'Freight Amt',1,0,'R');

                                                    $pdf->SetFont('Arial','B',7);
                                                     $pdf->Cell(16,8,"Paymt Comi",1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,8,'Short.',1,0,'L');
                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'Short Amt',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(9,8,'TDS',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'TDS Amt',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(17,8,'Adv(Self)',1,0,'R');
                                                     
                                                        $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Adv(Consi)',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(17,8,'Diesel Adv',1,0,'R');

                                                 

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Total Net Amt',1,0,'R');
                                                 



                                                      $pdf->Ln();
                                                         $sn=1;
                                 $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.compid=$compid  ";

                                            $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        $truckid = $row['truckid']; 
                                        $truckno = $row['truckno']; 
                                        $ownerid = $row['ownerid']; 
                                        $bid_id = $row['bid_id'];   
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        $consignorid = $row['consignorid'];
                        $consigneeid = $row['consigneeid'];
                        $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
                        $consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
                        $placeid = $row['placeid'];
                        $destinationid = $row['destinationid'];
                        $itemid = $row['itemid'];
                        $truckid = $row['truckid'];
                        $wt_mt = $row['totalweight'];
                        
                        $recweight = $row['recweight'];
                        $pay_no = $row['pay_no'];
                        if($pay_no!=''){
                        $pay_no = $cmn->getcode($connection,"returnbidding_entry","pay_no","1=1 and sessionid = $_SESSION[sessionid] ");
                        
                        }
                        else {
                        $pay_no = $row['pay_no'];
                        }
                        
                        $ac_holder = $row['ac_holder'];
                        $rate_mt = $row['freightamt'];
                        $newrate = $row['newrate']; 
                        $deduct_r = $row['deduct_r'];
                        if($deduct_r=='') { $deduct_r= 0; }
                        
                        $deduct = $row['deduct'];   
                        
                        $fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
                        $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        $adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						 $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        
                        
                        $payment_date = $row['payment_date'];
                        $chequepaydate = $row['chequepaydate']; ;
                        
                        //$venderid = $row['venderid'];
                        $commission = $row['commission'];
                        
                        
                        $cashpayment = $row['cashpayment'];
                        $chequepayment = $row['chequepayment'];
                        $chequepaymentno = $row['chequepaymentno'];
                        $paymentbankid = $row['paymentbankid']; 
                        $shortagewt =  $row['shortagewt']; 
                        $compcommission =  $row['compcommission']; 
                        $cashbook_date = $row['cashbook_date'];
                        $payeename = $row['payeename']; 
                        $tds_amt = $row['tds_amt'];
						 $sortagr = $row['sortagr'];
                        $neftpayment =$row['neftpayment']; 
						 $sortamount =$row['sortamount']; 
                        


                        if($payment_date=='0000-00-00')
                        {
                        $payment_date = date('Y-m-d');
                        $compcommission = $cmn->getvalfield($connection,"m_consignor","commission","consignorid='$consignorid'");
                        }
                        
                        $friendt_amount=$newrate * $recweight;
                        $netamount = $newrate * $recweight;
                        $charrate = $rate_mt - $newrate;    
                        $tot_adv = $adv_cash  + $adv_cheque +$adv_other+$adv_consignor;
                        
                        $trip_commission=$row['trip_commission'];
                        $netamount=$netamount-$deduct;    
                       $tds_amount= $netamount*$row['tds_amt']/100;

                       // $sortamount=$newrate * $sortagr;
                        $balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other-$adv_consignor - $commission;
                        
                        $tot_profit = $recweight * $charrate;
                        $comp_commision = ($tot_profit * $compcommission)/100;
                        $net_profit = round($tot_profit - $comp_commision);
                        
                        $othrcharrate = $rate_mt - $newrate;
                        
                        if($newrate==0){ $newrate=''; }
                        if($adv_cash==0){ $adv_cash='0'; }
                        if($adv_diesel==0){ $adv_diesel='0'; }
                        if($adv_cheque==0){ $adv_cheque=''; }
                        if($adv_other==0){ $adv_other='0'; }
						 if($adv_consignor==0){ $adv_consignor='0'; }
                        
                      $total_paid= $netamount-$commission-$adv_diesel-$tot_adv-$tds_amount-$sortamount;
                      $final_rate=$rate_mt-$trip_commission;
                                               $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(6,8, $sn++,1,0,'L');

                                                     

                                                   $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(10,8,$row['lr_no'],1,0,'L');
                                                     
                                                    
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(16,8,date('d-m-Y',strtotime($row['tokendate'])),1,0,'R');
                                                     


                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(19,8,$truckno,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(30,8,$toplace,1,0,'L');
                                                     
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(12,8, $wt_mt,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,$row['recweight'],1,0,'R');

                                                    //  $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$rate_mt,1,0,'R');


                                                    // $pdf->SetFont('Arial','',8);
                                                    //  $pdf->Cell(13,8,$trip_commission,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(12,8,round($final_rate),1,0,'R');
                                                    
                                                     $pdf->Cell(19,8,round($friendt_amount),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(16,8,round($commission),1,0,'R');
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(12,8,$sortagr,1,0,'R');
													 
													  $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,round($sortamount),1,0,'R');


                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(9,8,$tds_amt.'%',1,0,'R');

                                                    $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,round($tds_amount),1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(17,8,round($adv_cash),1,0,'R');
                                                     
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,round($adv_consignor),1,0,'R');
                                                     
                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(17,8,round($adv_diesel),1,0,'R');
                                                   
                                                     $pdf->SetFont('Arial','',8);
                                                    
                                                     $pdf->Cell(20,8,number_format(round($total_paid),2),1,0,'R');



                                                      $pdf->Ln();
                                                    $total_wt_mt+=$wt_mt;
                                                $total_recweight+=$row['recweight'];
                                                $total_final_rate+=$final_rate;
                                                    $total_rate_mt+=$rate_mt;
                                                $total_trip_commission+=$trip_commission;
                                                $total_commision+=$commission;
                                                $total_deduct+=$deduct;    
                                                $total_tds_amount+=$tds_amount;
                                                $total_adv +=$adv_cash;
                                                $total_desial_adv += $adv_diesel;
                                                $total_netamout +=$netamount;
                                                $toal_other_adv +=$adv_consignor;
												$toal_other_conginor +=$adv_consignor;
                                                $great_total +=$total_paid;
                                                $total_tds+=$tds_amt;
                                                   
                                                  }  

                                          
                                                     

                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(81,12,'Total',1,0,'C');

                                                     
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12, $total_wt_mt,1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,$total_recweight,1,0,'R');
                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_rate_mt,1,0,'R');

                                                    //  $pdf->SetFont('Arial','B',8);
                                                    //  $pdf->Cell(13,12,$total_trip_commission,1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12,'',1,0,'R');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(19,12,'',1,0,'R');

                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(16,12,round($total_commision),1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(12,12,'',1,0,'R');


                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(24,12,'',1,0,'R');

                                                    $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,12,'',1,0,'R');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(17,12,$total_adv,1,0,'R');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,12,round($toal_other_adv),1,0,'R');
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(17,12,round($total_desial_adv),1,0,'R');
                                                     
                                                    
                                                    
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,12,number_format(round($great_total),2),1,0,'R');



                                                      $pdf->Ln();

                                                      $pdf->SetFont('Arial','B',10);
                                                     $pdf->Cell(206,12,'Grant Total Amount',1,0,'C');

                                                     
                                                     $pdf->Cell(74,12,number_format(round($great_total),2),1,0,'R');



                                                      $pdf->Ln();



                                               

 $pdf->Output();
 
?>
    