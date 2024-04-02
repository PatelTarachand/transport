<?php
  error_reporting(0);
  include("dbconnect.php");
  $tblname = "";
  $tblpkey = "";
  $pagename = "bulk_bilty_payment_emami_report.php";
  $modulename = "Bulk Bilty Payment Report";
  
  if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0; 	
  
  $cond=' ';
  
  
   $printdate=date('Y-m-d');
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
   $ownerid = '';
  
if(isset($_GET['voucher_id']))
  {
    $voucher_No = $_GET['voucher_id'];
  }
  else
    $voucher_No='';
  
$sql_voucher = mysqli_query($connection,"select * from bulk_payment_vochar where payment_vochar='$voucher_No'");
        $row_voucher = mysqli_fetch_array($sql_voucher);

            $bulk_voucher_id=$row_voucher['bulk_voucher_id'];
  
  $cond= " where 1=1";
  if($voucher_No!='') {
  	
  	$cond .=" and  B.voucher_id = '$bulk_voucher_id'  ";
  	
  	}
  	if($ownerid !='') {
  	
  	$cond .=" and A.ownerid='$ownerid'";
  	
  	}
  	
  	$payment_vouchar="SELECT * FROM `bulk_payment_vochar` ORDER by id DESC";
     $payres = mysqli_query($connection,$payment_vouchar);
                              $payrow = mysqli_fetch_array($payres);
                              $payNoIncre= $payrow['bulk_voucher_id']+1;

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bulk_bilty_payment_emami_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table border="1">
								 <thead id="table">
                      <tr>
                        <th width="2%" >Sn</th>
                        <th width="5%" >Truck Owner</th>
                        <th width="5%" >Vouchar No</th>
                      
                           <th width="5%" >Payment Date</th>
                           <th width="5%" >Bal Amount</th>
                        <th width="5%" >Action</th>
                        <th width="5%" >Print PDF</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $sn=1;
                        
                         
                        if($ownerid=='' && $voucher_No==''){
                           // echo "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.consignorid=4 && B.recweight !='0' && B.deletestatus!=1 Group by B.voucher_id,order by B.voucher_id  DESC";
                               $sel = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 &&  B.recweight !='0'  && B.compid='$compid'  && B.sessionid='$sessionid' and B.deletestatus!=1 Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";
                        }
                        else
                        {
                             $sel = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.recweight !='0' && B.deletestatus!=1 && B.compid='$compid' && B.sessionid='$sessionid' Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";
                        
                        }
                        $res = mysqli_query($connection,$sel);
                        			while($row = mysqli_fetch_array($res))
                        			{
                        				$truckid = $row['truckid'];	
                        				$truckno = $row['truckno'];	
                        				$ownerid = $row['ownerid'];	
                                        $bid_id = $row['bid_id'];	
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                         //  $vouchardate = $vocrow['createdate'];
                        
                      
                        
                        
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                       // $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        
                         $payment_date = $row['payment_date'];
                        	$voucher_id = $row['voucher_id'];
                        $vou_query="SELECT `payment_vochar` FROM `bulk_payment_vochar` WHERE `bulk_voucher_id`='$voucher_id' && compid='$compid' && sessionid= $sessionid";
                                
                                $voures = mysqli_query($connection,$vou_query);
                                    $vocrow = mysqli_fetch_array($voures);
                                    $voucharno= $vocrow['payment_vochar'];
                                       $cuurentdate=date('Y-m-d');  

                                       $voucher_amount= showBiltyVoucher($connection,$compid,$voucher_id,$sessionid);	
                                       $payamount = $cmn->getvalfield($connection,"bilty_payment_voucher","sum(payamount)","ownerid='$ownerid' && voucher_id='$voucher_id' && compid='$compid' && sessionid= $sessionid ");
                                   
                                      // $bal_amt=floatval($voucher_amount-$payamount);
                                       $bal_amt = bcsub($voucher_amount, $payamount);
                                      // if($bal_amt < 0){
                                      //   $bal_amt=0;  
                                    //   }
                                    

                        ?>
                      <tr tabindex="<?php echo $sn; ?>" class="abc">
                        <td><?php echo $sn++; ?></td>
                          <td><?php echo $ownername; ?>
                        </td>
                        
                          <td><?php echo $voucharno; ?>
                        </td>
                          <td><?php echo dateformatindia($payment_date); ?></td>
                         <td><?php echo "Voucher Amt:" .$voucher_amount."<br>Paid :".$payamount."<br> Bal :".$bal_amt; ?>
                        </td>
                         
                        <td>
                                                <a href="bulk_bilty_payment_emami.php?ownerid=<?php echo $ownerid ?>&voucharno=<?php echo $voucharno; ?>&bulk_voucher_id=<?php echo $voucher_id ?>"><button class="btn btn-success center" > Edit</button></a>
                      
                            <!--<button class="btn btn-danger center" onClick="funDel('<?php echo $voucher_id; ?>')">Delete</button>	-->
                                       
                        </td>
                        <td>
                            
                          <a style=" margin-right: 10%;" href="pdf_bulk_bilty_payment_emami_report.php?ownerid=<?php echo $ownerid ?>&voucharno=<?php echo $voucharno; ?>&bulk_voucher_id=<?php echo $voucher_id ?>" target="_blank">
                    <button class="btn btn-primary center">Print PDF</button></span> 
                              
                          
                        </td>
                        
                    
                         
                      </tr>
                      <?php 
                        }
                       
                        ?>
                    </tbody>
							</table>


<script>window.close();</script>