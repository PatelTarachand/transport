<?php include("dbconnect.php");
error_reporting(0);
$pagename = 'consignor_ledger.php';
$pageheading = "Customer Transaction Detail";
$mainheading = "Customer Transaction Detail";
$cond=" ";
$cond1=" ";
if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-1 year',strtotime($todate)));
	
}
 
if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}
else
$consignorid = '';

if(isset($_GET['billid']))
{
	$billid = trim(addslashes($_GET['billid']));	
}
else
$billid = '';



if($fromdate !='' && $todate !='')
{ 
		$cond.=" and billdate between '$fromdate' and '$todate' ";	
		$cond1.=" and receive_date between '$fromdate' and '$todate' ";	
}

if($consignorid !='') {
	
	$cond .=" and consignorid='$consignorid'";
	$cond1 .=" and consignorid='$consignorid'";
	
	}
	if($billid !='') {
	
	$cond .=" and billid='$billid'";
	$cond1 .=" and billid='$billid'";
	
	}
$companymob1 = $cmn->getvalfield($connection,"m_company","mobileno1","compid='$_SESSION[compid]'");
$companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'");
?>

<!DOCTYPE html>
<html>
    <head>
    	<title>Customer Payment DetaILS</title>  
	<?php include("../include/top_files.php"); ?>
    </head>
    <body >
        <?php include("../include/top_menu.php"); ?>
        <!-- header logo: style can be found in header.less -->
        <!--<div  style="border:1px solid #000; width:100%;border-radius:5px;">-->
        <div class="container-fluid">
       <table  width="90%" align="">
       <tr>
    <td colspan="4" style="text-align:left;font-weight:bold;"> </td>
    <td align=""><span style="font-size:20px;"> <br/> <strong><?php echo $companyname;?></strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Contact No: +91-<?php echo $companymob1;?></td>
  </tr>
       </table>
                           
								<form action="" method="Get" >

                                    <table width="80%" align="">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Consignor :</th>
                                             <th width="15%" style="text-align:left;">Bill No</th>
                                            
                                         
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input  style="margin-bottom:0px;" class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input style="margin-bottom:0px;" class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td>
                                         
                   <select id="consignorid" name="consignorid" class="select2-me input-large" 
                   onChange="window.location.href='?consignorid='+this.value"
                   style="width:220px;" >
			<option value="all"> - All - </option>
			<?php 
   
			$sql_fdest = mysqli_query($connection,"select * from m_consignor");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['consignorid']; ?>"><?php echo $row_fdest['consignorname']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consignorid').value = '<?php echo $_GET['consignorid']; ?>';</script>
                        </td>
                                            
                                           	<td>
                                           	        <select id="billid" name="billid" class="select2-me input-large" 
                   onChange="getUrl(this.value);"
                   style="width:220px;" >
			<option value="all"> - Select - </option>
			<?php 
			

			$sql_fdest = mysqli_query($connection,"select * from bill where consignorid='$_GET[consignorid]'");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
				
			?>
			<option value="<?php echo $row_fdest['billid']; ?>"><?php echo $row_fdest['billno']; ?></option>
			<?php
		} ?>
			</select>
			<script>document.getElementById('billid').value = '<?php echo $_GET['billid']; ?>';</script>
                                           	</td>
                                            
                                            
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                                           </td>
                                    </tr>
                                   
                                    
                            </table>
								</form>	
                                </div>
                                <hr>
                            <?php
							if($consignorid !='')
						{?>
					<div>
                            <!-- /.box -->
                             <?php $prevbalance = 0;?>
                             
                          
                            
                          <div class="container-fluid">
                        
                          <strong>Consignor Ledger Details</strong>
                     
  
         <?php
							if($consignorid =='all')
						{?>
      <a href="pdf_consignor_ledgerall.php?consignorid=<?php echo $consignorid;?>&billid=<?php echo $billid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" style="float:right;" target="_blank"> <button type="button" class="btn btn-primary"> Print PDF</button></a>
      <?php } else {?> 
       <a href="pdf_consignor_ledger.php?consignorid=<?php echo $consignorid;?>&billid=<?php echo $billid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" style="float:right;" target="_blank"> <button type="button" class="btn btn-primary"> Print PDF</button></a></div>     
              <?php } ?>                                       
              <hr>
                          <table width="98%">
                          	<tr>
                            	<td colspan="2">
                            <!--   <strong>Opening Balance: <?php
							 echo number_format($prevbalance,2);?></strong>-->
                              <!-- <a  style="float:right;  " href="pdf_truckowner_roaker.php?consignorid=<?php echo $_GET['consignorid'];?>&truckNo=<?php echo $_GET['truckid']; ?>&fromdate=<?php echo $_GET['fromdate']; ?>&todate=<?php echo $_GET['todate']; ?>" target="_blank"> <button class="btn btn-primary right" >PDF</button></a>-->
                                </td>
                            </tr>
                          </table>
                          </div>    
                        <div <?php  if($consignorid == 'all'){?>style="width:100%; float:left; margin-left: 10px;"<?php } else { ?>style="width:49%; float:left; margin-left: 10px;"<?php } ?>>
                           
                           
                               
                                    <table border="1" width="98%">
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center"><strong> Billing Detail</strong></th>
                                        </tr>
                                            <tr>
                                              <th style="background-color:#C99">Sno</th>  
											<th style="background-color:#C99">Consignor Name</th>
                                            <th style="background-color:#C99">Bill No.</th>
                                              <th style="background-color:#C99">Bill Date</th>
                                                <th style="background-color:#C99">Advance Amount</th>
                                                 <th style="background-color:#C99">Bill Amount</th>
                                                  <th style="background-color:#C99">Balance Amount</th>
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
											
										 	$netbilty1 =0;
											$slno = 1;
                      
                    
                      if($consignorid == 'all'){
                         $sql_table = "SELECT * FROM `bill` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignor' ";
                      }else{
                        $sql_table = "SELECT * FROM `bill` WHERE sessionid='$sessionid' and compid='$compid' $cond and consi_type='Consignor'";
                      }
											 
											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row = mysqli_fetch_assoc($res_table))
											{
											$consignorname =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");	
									$billno =  $cmn->getvalfield($connection,"bill","billno","billid='$row[billid]'");
									$billdate =  $cmn->getvalfield($connection,"bill","billdate","billid='$row[billid]'");
										
						//$advamount = $cmn->getvalfield($connection,"bidding_entry","sum(adv_consignor)","consignorid='$row[consignorid]' && invoiceid='$row[billid]' ");
 	// $bill_amount= $cmn->get_total_billing_amt($connection,"$row[billid]");	  
 	 
 	 	$availbill =  $cmn->getvalfield($connection,"consignor_payment","count(billid)","billid='$row[billid]' and compid='$compid'");
 	 	//	$totamount=($bill_amount-$advamount);
 	 		
 	 			$advamount1 = $cmn->getvalfield($connection,"bidding_entry","sum(adv_consignor)","consignorid='$row[consignorid]' && invoiceid='$row[billid]' ");
 	
	 $tdsamt1 = $cmn->getvalfield($connection,"consignor_payment","sum(tdsamt)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
		
				 $bill_amount1= $cmn->get_total_billing_amt($connection,"$row[billid]");
	 $payamount1 = $cmn->getvalfield($connection,"consignor_payment","sum(payamount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
	 $deduct_amount1 = $cmn->getvalfield($connection,"consignor_payment","sum(deduct_amount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
	$bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$tdsamt1)-($payamount1);
		if($bal_amt1>1){
 	 		
 	 			$netbilty += $bal_amt1;
//	if($availbill==0 ){

	
	
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                   <th><?php echo $consignorname;?></th>
                                            <th><?php echo $billno;?></th>
                                            <th><?php echo $billdate;?></th>
                                             <th><?php echo $advamount1;?></th>
                                              <th><?php echo $bill_amount1;?></th>
                                            <th colspan="4" style="font-size:18px;text-align:right" ><?php echo $bal_amt1;?></th>
                                            
                                                   
                                                </tr>
                                            
                                            <?php
                                            	//$totamount1=($bill_amount-$advamount);
											$netbilty1 += $bal_amt1;
									}	}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th> 
                                                   <th>&nbsp;</th> 
                                                   <th>&nbsp;</th> 
                                                   <th>&nbsp;</th>                                               
                                                <th  style="text-align:right">Total</th>                                                
                                               
                                                                                             
                                                <th  style="text-align:right;font-size:18px;"> <?php echo number_format(round($netbilty1),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                             
                        </div>

                        <div style="width:49%; float:right; margin-right:10px; ">
                            
                           
                               <?php if($consignorid != 'all'){?>
                                    <table border="1" width="100%">
                                  
                                        <thead>
                                        <tr>
                                        	<th colspan="6" align="center"><strong> Consignor  Payments</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                         
                                            <th style="background-color:#6C9"> Bill No</th>
                                             <th style="background-color:#6C9"> Pay Receive No</th>
											                        <th style="background-color:#6C9">Receive Date </th>
                                            	<th style="background-color:#6C9">Narration </th>
                                                <th style="background-color:#6C9">TDS Amount</th>
                                                <th style="background-color:#6C9">Other Deduction Amount</th>
                                                <th style="background-color:#6C9">Receive Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
									$slno=1;
									$netpayamt=0;
						$netdeduct_amount=0;
						$netpayamt = 0;
								$nettdsamt = 0;
                if($consignorid == 'all'){
                  $sel1 = "SELECT * FROM `consignor_payment` WHERE sessionid='$sessionid' and compid='$compid'order by payid desc";

                }else{

                 
									$sel1 = "SELECT * FROM `consignor_payment` WHERE sessionid='$sessionid' and compid='$compid' $cond1 order by payid desc";
                }
							$res1 = mysqli_query($connection,$sel1);
									while($row1 = mysqli_fetch_array($res1))
									{
									$billno1 =  $cmn->getvalfield($connection,"bill","billno","billid='$row1[billid]'");	
									?>
                                            	<tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $billno1;?></td> 
                             <td><?php echo $row1['payment_rec_no'];?></td>                             
                            <td><?php echo dateformatindia($row1['receive_date']);?></td>  
                           <td><?php echo $row1['narration'];?></td>
                             <td style="text-align:right"><?php echo number_format($row1['tdsamt'],2);?></td>
                               <td style="text-align:right"><?php echo number_format($row1['deduct_amount'],2);?></td>
                             <td style="text-align:right"><?php echo number_format($row1['payamount'],2);?></td>
                            
                          
                        </tr>
                                            
                                            <?php
										$slno++;
								
								$netpayamt += $row1['payamount'];
								$nettdsamt += $row1['tdsamt'];
								$netdeduct_amount += $row1['deduct_amount'];
								} 
									?>
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                 <th>&nbsp;</th>
                                                <th style="text-align:right"></th>
                                                <th>&nbsp;</th>
                                                  <th>&nbsp;</th>
                                                <th>Total</th>
                                              <th style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format($nettdsamt,2); ?></th>
                                              <th style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format($netdeduct_amount,2); ?></th>
                                               
                                                <th style="text-align:right;font-size:18px;"><i class="fa fa-inr"></i> <?php echo number_format($netpayamt,2); ?></th>
                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                   
                            
                        </div>
                    </div>
                    <?php $balamt = ($netpayamt+$nettdsamt+$netdeduct_amount)-($netbilty1); 
					 ?>
                     <br>
                     
                  
                    	<!--<table width="99%" border="1"   style="font-size:14px; margin-right: 10px; margin-left: 10px;" >-->
                     <!--   	<tr bgcolor="#CCCCCC">-->
                     <!--       	<td>&nbsp;   </td><td>&nbsp;   </td>-->
                     <!--       	<td align="right"><strong>Received Amt : <i class="fa fa-inr"></i> <?php echo number_format($balamt,2); ?></strong></td>-->
                     <!--       </tr>-->
                           
                     <!--   </table>-->

                        
                       
                    <?php
						}}
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