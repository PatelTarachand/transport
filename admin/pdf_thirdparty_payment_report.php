<?php
//error_reporting(0);           
include("dbconnect.php");
include("../fpdf17/fpdf.php");

if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0;  
  
  $cond=' ';
  
  
  
  if(isset($_GET['bulkthirdid']))
  {
    $bulkthirdid = trim(addslashes($_GET['bulkthirdid']));  
  }
  else
  $bulkthirdid = '';
  
 


    $res_table = mysqli_query($connection,$sql_table);
                                        $pdf = new FPDF();
                                        $pdf->AddPage('P','A4',2);
                                          
                                            $company_owner = "SELECT * FROM `m_company` ";

                                    $cmp_owm = mysqli_query($connection,$company_owner);
                               while($onwer = mysqli_fetch_assoc($cmp_owm)){

                                    //   $pdf->Image('images/ltc1.jpg',10,5,20);
                                                    
                                        $pdf->SetX(82);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(80,8,'JK LAXMI',2,0,'L');
                                        
                                         $pdf->SetX(130);
                                         $pdf->SetFont('Arial','',24);
                                        $pdf->Cell(150,8,'',2,0,'L');
                                        
                                        $pdf->Ln();

                                        $pdf->SetX(82);
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


$thirdid = $cmn->getvalfield($connection,"thirdparty_boucher","thirdid","bulkthirdid='$bulkthirdid'");
 $paydate = $cmn->getvalfield($connection,"thirdparty_boucher","paydate","bulkthirdid='$bulkthirdid'");
 $third_name = $cmn->getvalfield($connection,"m_third_party","third_name","thirdid='$thirdid'");
                                      

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(59,8,'Third Party : '.$third_name ,0,0,'L');
                                                     
                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(59,8,'Payment Date : '.dateformatindia($paydate),0,0,'L');
                                        
                                        $pdf->Ln(10);

                                            $pdf->SetFont('Arial','B',8);
                                                    $pdf->Cell(7,8,'S.N',1,0,'C');

                                                    
                                                       $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'DI No',1,0,'L');
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(14,8,'LR No',1,0,'L');

                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(26,8,'Truck No',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Consignee',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(56,8,'Destination',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(18,8,'Dis.Date',1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(15,8,'Qty',1,0,'L');
                                                     


                                                     $pdf->SetFont('Arial','B',8);
                                                     $pdf->Cell(20,8,'Pay Amount',1,0,'R');
                                                     
                                                    

                                                      $pdf->Ln();
                                                         $sn=1;
														 $total_amt=0;
								//	echo "select * from thirdparty_boucher where bulkthirdid='$bulkthirdid' order by bulkthirdid desc";
                                  $sel = "select * from thirdparty_boucher where bulkthirdid='$bulkthirdid' order by bulkthirdid desc";

                                            $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
                                        $voucherno = $row['voucherno'];
											$bulkthirdid = $row['bulkthirdid'];
										$paydate = $row['paydate'];
											$thirdid = $row['thirdid'];
									 $di_no=$row['di_no'];
                                        $adv_other = $cmn->getvalfield($connection,"bidding_entry","adv_other","di_no='$di_no'");
										 $adv_consignor = $cmn->getvalfield($connection,"bidding_entry","adv_consignor","di_no='$di_no'");
                                       $consigneeid = $cmn->getvalfield($connection,"bidding_entry","consigneeid","di_no='$di_no'");
                                        $destinationid = $cmn->getvalfield($connection,"bidding_entry","destinationid","di_no='$di_no'");
                                         $truckid = $cmn->getvalfield($connection,"bidding_entry","truckid","di_no='$di_no'");
                                       $noofqty = $cmn->getvalfield($connection,"bidding_entry","noofqty","di_no='$di_no'");
                                        $lr_no = $cmn->getvalfield($connection,"bidding_entry","lr_no","di_no='$di_no'");
                                       $adv_date = dateformatindia($cmn->getvalfield($connection,"bidding_entry","adv_date","di_no='$di_no'"));
                                      
                                       $consigneename = ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$consigneeid'"));
                                        $placename = 	ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$destinationid'"));
                      
              	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");   
              	
                                            $pdf->SetFont('Arial','',8);
                                                    $pdf->Cell(7,8, $sn++,1,0,'L');

                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$row['di_no'],1,0,'L');
                                                     
                                                      $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(14,8,$lr_no,1,0,'L');
                                                     
                                                        $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(26,8,$truckno,1,0,'L');
                                                     
                                                        $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$placename,1,0,'L');
                                                     
                                                        $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(56,8,$consigneename,1,0,'L');
                                                     
                                                        $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(18,8,$adv_date,1,0,'L');
                                                     
                                                        $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(15,8,$noofqty,1,0,'R');

                                                     $pdf->SetFont('Arial','',8);
                                                     $pdf->Cell(20,8,$adv_other,1,1,'R');
                                                     
                                                 
                                                $total_amt+=$adv_other+$adv_consignor;
                                                   
                                                  }  

                                         
                                                     

                                                     $pdf->SetFont('Arial','B',9);
                                                     $pdf->Cell(176,12,'Total',1,0,'R');
 												$pdf->Cell(20,12,number_format(round($total_amt),2),1,0,'R');
                                                    
                                                      $pdf->Ln();



                                               

 $pdf->Output();
 
?>
    