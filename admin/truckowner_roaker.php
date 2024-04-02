<?php include("dbconnect.php");

$pagename = 'truckowner_roaker.php';
$pageheading = "Customer Transaction Detail";
$mainheading = "Customer Transaction Detail";


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
        <div class="container-fluid">
        <div  style="width:100%;border-radius:5px;">
       <table  width="80%" align="center">
       <tr>
    <td colspan="4" style="text-align:left;font-weight:bold;"> </td>
    <td align="center"><span style="font-size:20px;"> <br/> <strong><?php echo $companyname;?></strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Contact No: +91-<?php echo $companymob1;?></td>
  </tr>
       </table>
                               <hr>
								<form action="" method="Get" >
                                    <table  width="100%">
                                   
                                    	<tr>
                                        <td style="width:10%"><strong>From Date</strong></td>
                                        <td style="width:15%"> <input type="date" class="input-small" name="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" id="fromdate" style="width:150px;" > </td>
                                        <td  style="width:5%"><strong>To Date</strong></td>
                                        <td style="width:15%">
                                          <input type="date" class="input-small" name="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" id="today" style="width:150px;" >
                                        </td>
                                        	<td style="width:11%"><strong>Truck Owner Name</strong></td>
                                          
                                        	
                                        	<td style="width:15%">
                                        	<div class="col-xs-12">
                                            <select id="ownerid" name="ownerid"  class="form-control chosen-select" onChange="getTruckNolist(this.value);" style="width:150px;">
                                        	<option value="">-Select-</option>
                                            <?php 
											$sql2 = "select ownerid,ownername from  m_truckowner order by ownername";
											$res2 = mysqli_query($connection,$sql2);
											while($row2 = mysqli_fetch_assoc($res2))
												{
											?>
                                          			<option value="<?php echo $row2['ownerid']; ?>"><?php echo $row2['ownername']; ?></option>
                                            <?php
												}
												?>
                                          	
                                      </select>
                                      <script>document.getElementById('ownerid').value='<?php echo $ownerid; ?>';</script>
                                            </div>
                                            </td>
                                    
                                    <td style="width:5%"> <strong>Truck No</strong></td>
                                          
                                          
                                          <td style="width:10%">
                                          <div class="col-xs-12">
                                            <select id="truckid" name="truckid"  class="form-control"  >
                                          <option value="">-Select-</option>
                                            <?php 
                      $sql2 = "select truckid,truckno from  m_truck order by truckno";
                      $res2 = mysqli_query($connection,$sql2);
                      while($row2 = mysqli_fetch_assoc($res2))
                        {
                      ?>
                                <option value="<?php echo $row2['truckid']; ?>"><?php echo $row2['truckno']; ?></option>
                                            <?php
                        }
                        ?>
                                            
                                      </select>
                                      <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script>
                                            </div>
                                            </td>                                      
                                        	
                                          
                                         <td width="37%">
                                        
										 <input type="submit" name="submit"  value="Search" class="btn btn-success"  >
                                         
										 <input type="button" class="btn btn-danger"  onclick="document.location='<?php echo $pagename; ?>'"  name="reset_dept" value="Reset" >
                                       
                                         </td>
                                       </tr>
                                    </table>
								</form>	
                               
                            <?php
							if($truckid != '' || $ownerid !='')
							{?>
					<div>
					</div>
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
                                        	<th colspan="9" align="center"><strong> Bilty Detail</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                                <th>Consignee</th>
                                                <th>LR No</th>
                                                <th>LR Date</th>   
                                                <th>Truck No</th> 
                                                <th>Total Weight</th> 
                                                <th>Comp. Rate </th> 
                                                <th>Final Rate </th> 
                                                <th>Total Amt</th>
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
										 
											$slno = 1;
											 $sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1 $crit $cond and compid='$compid' order by tokendate desc";
											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											    
											     $freightamt=$row_table['freightamt'];
											  
											    
											    $newrate=$row_table['newrate'];
											    
											   
											    
											    
											    
											    
											    $final_rate=$freightamt-$newrate;
											    
												$biltyAmt = $row_table['recweight'] * $freightamt;
												$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
												$consignee = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row_table[consigneeid]'");
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $consignee; ?></td>
                                                    <td><?php echo $row_table['lr_no']; ?></td>
                                                    <td><?php echo $row_table['tokendate']; ?></td>
                                                    <td><?php echo $truckno; ?></td>
                                                    <td><?php echo $row_table['totalweight']; ?></td>
                                                    
                                                    <td><?php echo $freightamt; ?></td><td><?php echo $newrate; ?></td>
                                                    
                                                    <td align="right"><i class="fa fa-inr"></i> <?php echo number_format($biltyAmt,2); ?></td>
                                                   
                                                </tr>
                                            
                                            <?php
											$netbilty += $biltyAmt;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>                                                
                                                <th  style="text-align:right">Total</th>                                                
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>                                                
                                                <th>&nbsp;</th>                                                
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
                                                <th>LR No</th>
                                                <th>Cash Adv</th>
                                                <th>Diesel Adv</th>
                                                <th>Paid Date</th>
                                                <th>Paid Amt</th>
                                               	<th>Total Amt</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$slno = 1;
											$netpayamt = 0;
											$sql_table = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where 1=1 $crit  $cond2 order by tokendate desc";											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
												$payment = $row_table['cashpayment'] + $row_table['chequepayment'] + $row_table['neftpayment'];
												$totalamt = $payment  + $row_table['adv_cash'] + $row_table['adv_diesel'];
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $row_table['lr_no']; ?></td>
                                                    <td align="right"><?php echo $row_table['adv_cash']; ?></td>
                                                    <td align="right"><?php echo $row_table['adv_diesel']; ?></td>
                                                    <td><?php echo $cmn->dateformatindia($row_table['payment_date']); ?></td>
                                                    <td align="right"><i class="fa fa-inr"></i> <?php echo number_format($payment,2); ?></td>
                                                   <td align="right"><i class="fa fa-inr"></i> <?php echo number_format($totalamt,2); ?></td>
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