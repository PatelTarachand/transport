<?php include("dbconnect.php");

$pagename = 'truckowner_roaker.php';
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
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}
 
if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));	
}
else
$ownerid = '';

if(isset($_GET['voucher_id']))
{
	$voucher_id = trim(addslashes($_GET['voucher_id']));	
}
else
$voucher_id = '';



if($fromdate !='' && $todate !='')
{
		$cond.=" and receive_date between '$fromdate' and '$todate' ";
		$cond1.=" and B.payment_date between '$fromdate' and '$todate' ";
}

if($ownerid !='') {
	
	$cond .=" and ownerid='$ownerid'";
	$cond1 .=" and A.ownerid='$ownerid'";
	
	}
	if($voucher_id !='') {
	
	$cond .=" and voucher_id='$voucher_id'";
	$cond1 .=" and B.voucher_id='$voucher_id'";
	
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
        <div  style="border:1px solid #000; width:100%;border-radius:5px;">
       <table  width="80%" align="center">
       <tr>
    <td colspan="4" style="text-align:left;font-weight:bold;"> </td>
    <td align="center"><span style="font-size:20px;"> <br/> <strong><?php echo $companyname;?></strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Contact No: +91-<?php echo $companymob1;?></td>
  </tr>
       </table>
                               
								<form action="" method="Get" >
                                    <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Truck Owner :</th>
                                             <th width="15%" style="text-align:left;">Voucher No</th>
                                            
                                         
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td>
                                             <select id="ownerid" name="ownerid" class="select2-me input-large" style="width:220px;">
                            <option value=""> - All - </option>
                            <?php 
                              $sql_fdest = mysqli_query($connection,"select * from m_truckowner");
                              while($row_fdest = mysqli_fetch_array($sql_fdest))
                              {
                              ?>
                            <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                            <?php
                              } ?>
                          </select>
                          <script>document.getElementById('ownerid').value = '<?php echo $_GET['ownerid']; ?>';</script>
                        </td>
                                            
                                           	<td>
                                           	      <select id="voucher_id" name="voucher_id" class="select2-me input-large" 
                   onChange="getUrl(this.value);"
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			
			$sql_fdest = mysqli_query($connection,"SELECT A.ownerid,B.voucher_id,B.payment_date from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid) where A.ownerid='$_GET[ownerid]' && B.compid='$compid' && B.voucher_id!=0 group by B.voucher_id ");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			
				$payment_vochar = $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row_fdest[voucher_id]' ");
			
			?>
			<option value="<?php echo $row_fdest['voucher_id']; ?>"><?php echo $payment_vochar; ?></option>
			<?php
		}?>
			</select>
			<script>document.getElementById('voucher_id').value = '<?php echo $_GET['voucher_id']; ?>';</script>

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
                               
                            <?php
							if($ownerid !='')
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
                             <!--  <strong>Opening Balance: <?php
							 echo number_format($prevbalance,2);?></strong>-->
                              <!-- <a  style="float:right;  " href="pdf_truckowner_roaker.php?ownerid=<?php echo $_GET['ownerid'];?>&truckNo=<?php echo $_GET['truckid']; ?>&fromdate=<?php echo $_GET['fromdate']; ?>&todate=<?php echo $_GET['todate']; ?>" target="_blank"> <button class="btn btn-primary right" >PDF</button></a>-->
                                </td>
                            </tr>
                          </table>
                          </div>    
                        <div style="width:49%; float:left; margin-left: 10px;">
                           
                           
                               
                                    <table border="1" width="98%">
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center"><strong> Voucher Detail</strong></th>
                                        </tr>
                                            <tr>
                                              <th style="background-color:#C99">Sno</th>  
											<th style="background-color:#C99">Consignor Name</th>
                                            <th style="background-color:#C99">Voucher No.</th>
                                              <th style="background-color:#C99">Voucher Date</th>
                                                <th style="background-color:#C99">Voucher Amount</th>
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
										
											$slno = 1;
											echo "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond1 and B.is_complete=1 && B.recweight !='0' && B.deletestatus!=1 && B.compid='$compid' Group by B.voucher_id order by B.voucher_id  DESC";
											 $sql_table = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond1 and B.is_complete=1 && B.recweight !='0' && B.deletestatus!=1 && B.compid='$compid' Group by B.voucher_id order by B.voucher_id  DESC ";
											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row = mysqli_fetch_assoc($res_table))
											{
											$ownername =  $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'");	
											$payment_vochar =  $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row[voucher_id]'");
											$payment_date = dateformatindia($cmn->getvalfield($connection,"bidding_entry","payment_date","voucher_id='$row[voucher_id]' "));	
											$voucher_amount= showBiltyVoucher($connection,$row['voucher_id']);	
											
											
	
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                   <th><?php echo $ownername;?></th>
                                            <th><?php echo $payment_vochar;?></th>
                                            <th><?php echo $payment_date;?></th>
                                            <th colspan="5" style="font-size:18px;text-align:right" ><?php echo $voucher_amount;?></th>
                                            
                                                   
                                                </tr>
                                            
                                            <?php
											$netbilty += $voucher_amount;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th> 
                                                   <th>&nbsp;</th>                                               
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
                                        	<th colspan="7" align="center"><strong> Customer Payments</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                            <th style="background-color:#6C9">Voucher No</th>
                                            <th style="background-color:#6C9">Payment Receive No</th>
											<th style="background-color:#6C9">Pay Date </th>
                                            	<th style="background-color:#6C9">Narration </th>
                                                <th style="background-color:#6C9">Pay Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
									$slno=1;
									$netpayamt=0;
							
									$sel1 = "SELECT * FROM `bilty_payment_voucher` WHERE sessionid='$sessionid' and compid='$compid' $cond order by payid desc";
							$res1 = mysqli_query($connection,$sel1);
									while($row1 = mysqli_fetch_array($res1))
									{
									$payment_vochar =  $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row1[voucher_id]'");	
									?>
                                            	<tr>
                            <td><?php echo $slno; ?></td>
					          <td><?php echo $payment_vochar;?></td>
                             <td><?php echo $row1['payment_rec_no'];?></td>
                             
                            <td><?php echo dateformatindia($row1['receive_date']);?></td>  
                           <td><?php echo $row1['narration'];?></td>
                            <td><?php echo number_format(round($row1['payamount']),2);?></td>
                               
                            
                            
                          
                        </tr>
                                            
                                            <?php
										$slno++;
								
								$netpayamt += $row1['payamount'];
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