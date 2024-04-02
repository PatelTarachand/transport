<?php include("dbconnect.php");

$pagename = 'comapny_cash_book.php';
$pageheading = "Company Cash Book Detail";
$mainheading = "Company Cash Book Detail";


	


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



	

  $cond="";
  $cond2="";



if($fromdate !='' && $todate !='' ) {
  $cond = "and paymentdate between '$fromdate' and '$todate' "; 
  $cond2 = " and payment_date between '$fromdate' and '$todate' "; 
}


?>

<!DOCTYPE html>
<html>
    <head>
    	<title><?php echo $pageheading; ?></title>  
	<?php include("../include/top_files.php"); ?>
  <?php include("../include/top_menu.php"); ?>
    </head>
    <body >
        <!-- header logo: style can be found in header.less -->
        <div  style="border:1px solid #000; width:100%;border-radius:5px;">
       <table  width="80%" align="center">
       <tr>
   
    <td align="center"><span style="font-size:20px;"> <strong>Sarthak Logisticss </strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Tel. No: +91-&nbsp;&nbsp; </td>
  </tr>
       </table>
                               
								<form action="" method="Get" >
                                    <table  width="80%" align="center">
                                   
                                    	<tr>
                                        <th>From Date</th>
                                        <td> <input type="text" class="input-small" name="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" id="fromdate" > </td>
                                        <th>To Date</th>
                                        <td>
                                          <input type="text" class="input-small" name="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" id="today" >
                                        </td>
                                        	
                                          
                                         <td width="37%">
                                        
										 <input type="submit" name="submit"  value="Search" class="btn btn-primary"  >
                                         
										 <input type="button"  onclick="document.location='<?php echo $pagename; ?>'"  name="reset_dept" value="Reset" >
                                       
                                         </td>
                                       </tr>
                                    </table>
								</form>	
                               
                            <?php
							if($todate != '' || $fromdate !='')
							{?>
					<div>
                            <!-- /.box -->
                             <?php $prevbalance = 0;?>
                             
                          
                            
                          <div align="center">
                          <hr>
                          <strong>Truck Owner Ledger Details</strong>
                          <hr>
                          <table width="98%">
                          	<tr>
                            	<td colspan="2">
                               <strong>Opening Balance: <?php
							 echo number_format($prevbalance,2);?></strong>
                               <a  style="float:right;  " href="pdf_truckowner_roaker.php?ownerid=<?php echo $_GET['ownerid'];?>&truckNo=<?php echo $_GET['truckid']; ?>&fromdate=<?php echo $_GET['fromdate']; ?>&todate=<?php echo $_GET['todate']; ?>" target="_blank"> <button class="btn btn-primary right" >PDF</button></a>
                                </td>
                            </tr>
                          </table>
                          </div>    
                        <div style="width:49%; float:left; margin-left: 10px;">
                           
                           
                               
                                    <table border="1" width="98%">
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center"><strong> Payment Receive</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Head</th>   
                                                <th>Payname</th> 
                                                
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
										 
											$slno = 1;
											   $sql_table = "SELECT * FROM `otherincome`  where 1=1 $cond";
											 
											 $res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											    
											    echo $paymentdate=$row_table['paymentdate'];
											    $incomeamount=$row_table['incomeamount'];
											    
												$head_id = $row_table['head_id'];
                        $payeename = $row_table['payeename'];
											
												
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $paymentdate ?></td>
                                                    <td><?php echo $incomeamount; ?></td>
                                                    <td><?php echo $head_id; ?></td>
                                                    <td><?php echo $payeename; ?></td>
                                                    
                                                </tr>
                                            
                                            <?php
											$netbilty += $incomeamount;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th  style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                             
                        </div>
                        <div style="width:49%; float:right; margin-right:10px; ">
                            
                           
                               
                                    <table border="1" width="100%">
                                  
                                        <thead>
                                        <tr>
                                        	<th colspan="6" align="center"><strong> Pay Expenses</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                                <th>Date</th>
                                                <th>LR No</th>
                                                <th>Cash Adv</th>
                                                <th>Other Adv</th>
                                                <th>Truck NO</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$slno = 1;
											$netpayamt = 0;
											$sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1  $cond2 order by tokendate desc";											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
												$payment = $row_table['cashpayment'] + $row_table['chequepayment'] + $row_table['neftpayment'];
												$totalamt = $payment  + $row_table['adv_cash'] + $row_table['adv_diesel'];
                        $otherAdv= $row_table['adv_other'];
                          $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $cmn->dateformatindia($row_table['payment_date']); ?></td>
                                                    <td><?php echo $row_table['lr_no']; ?></td>
                                                    <td align="right"><?php echo $row_table['adv_cash']; ?></td>
                                                    <td align="right"><?php echo $row_table['adv_other']; ?></td>
                                                    
                                                    <td align="right"><i class="fa fa-inr"></i> <?php echo $truckno; ?></td>
                                                   
                                                </tr>
                                            
                                            <?php
											$netpayamt += $totalamt;
											}
											?>
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                 <th>&nbsp;</th>
                                                <th style="text-align:right">Total</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netpayamt),2); ?></th>
                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                   
                            
                        </div>
                    </div>
                    <?php $balamt = $prevbalance + $netbilty - $netpayamt; 
					 ?>
                     <br>
                     
                  
                    	<table width="99%" border="1"   style="font-size:14px; margin-right: 10px; margin-left: 10px;" >
                        	<tr bgcolor="#CCCCCC">
                            	<td>&nbsp;   </td><td>&nbsp;   </td>
                            	<td align="right"><strong>Balance Amt : <i class="fa fa-inr"></i> <?php echo number_format(round($balamt),2); ?></strong></td>
                            </tr>
                           
                        </table>

                        
                       
                    <?php
							}
				?>
                </div>
           <script>
           function getTruckNolist(id) {
				$.ajax({
					type: 'POST',
					url: 'gettrucklistownerwise.php',
					data: 'id=' + id,
					dataType: 'html',
					success: function(data){
						//alert(data);
						$('#truckid').html(data);
					}				
				});//ajax close
			   }
           </script>
    </body>
</html>