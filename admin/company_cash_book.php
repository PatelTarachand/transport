<?php include("dbconnect.php");

$pagename = 'company_cash_book.php';
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
  $cond2 = " and adv_date between '$fromdate' and '$todate' "; 
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
        <div  style="width:100%;border-radius:5px;">
       <table  width="80%" align="center">
       <tr>
   
    <td align="center"><span style="font-size:20px;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;"></td>
  </tr>
       </table>
       <div id="main">
			<div class="container-fluid">
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i>Company Cash Book</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                               
								<form action="" method="Get" style="margin-top:40px;" >
                                    <table  width="70%">
                                   
                                    	<tr>
                                        <th>From Date</th>
                                        <td> <input type="date" class="input-small" name="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" id="fromdate" style="width:180px;margin-bottom:0px;"> </td>
                                        <th>To Date</th>
                                        <td>
                                          <input type="date" class="input-small" name="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" id="today" style="width:180px;margin-bottom:0px;">
                                        </td>
                                        	
                                          
                                         <td width="37%">
                                        
										 <input type="submit" name="submit"  value="Search" class="btn btn-success"  >
                                         
										 <input type="button"  onclick="document.location='<?php echo $pagename; ?>'" class="btn btn-danger"  name="reset_dept" value="Reset" >
                                       
                                         </td>
                                       </tr>
                                    </table>
								</form>	
                               
                            <?php
							if($todate != '' || $fromdate !='')
							{?>
					<div>
					</div>
					</div>
					</div>
					</div>
                            <!-- /.box -->
                             <?php  

$prevbalance = $cmn->getcashopeningplant($connection,$fromdate);?>
                             
                          
                            
                          <div align="center">
                          <hr>
                          <strong>Comapany Cash Book Details</strong>
                          <hr>
                          <table width="98%">
                          	<tr>
                            	<td colspan="2">
                               <strong>Opening Balance: <?php
							 echo number_format($prevbalance,2);?></strong>
                               <a  style="float:right;  " href="pdf_comoany_cash_book.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank"> <button class="btn btn-primary right" >PDF</button></a>
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
                                                
                                                <th>Head</th>   
                                                <th>Payname</th> 
                                                <th>Amount</th>
                                                
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
										 
											$slno = 1;
											   $sql_table = "SELECT * FROM `otherincome`  where 1=1 and payment_type='cash' $cond  and compid='$compid' ";
											 
											 $res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											    
											     $paymentdate=$row_table['paymentdate'];
											    $incomeamount=$row_table['incomeamount'];
											    
												$head_id = $row_table['head_id'];
                        $payeename = $row_table['payeename'];
											
												$headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$head_id'");
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $cmn->dateformatindia($paymentdate); ?></td>
                                                    
                                                    <td><?php echo $headname; ?></td>
                                                    <td><?php echo $payeename; ?></td>
                                                    <td><?php echo $incomeamount; ?></td>
                                                    
                                                </tr>
                                            
                                            <?php
											$netbilty += $incomeamount;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="4" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                      <table border="1" width="98%">
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center"><strong> Office Expances</strong></th>
                                        </tr>
                                            <tr>
                                                <th>S No</th>
                                                <th>Date</th>
                                                
                                                <th>Head</th>   
                                                <th>Narration</th> 
                                                <th>Amount</th>
                                                
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty1 =0;
										 
											$slno = 1;
											   $sql_table = "SELECT * FROM `other_expense`  where 1=1 and payment_type='cash' $cond";
											 
											 $res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											    
											     $paymentdate=$row_table['paymentdate'];
											    $expamount=$row_table['expamount'];
											    
												$head_id = $row_table['head_id'];
                        $narration = $row_table['narration'];
											
												$headname = $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$head_id'");
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $cmn->dateformatindia($paymentdate); ?></td>
                                                    
                                                    <td><?php echo $headname; ?></td>
                                                    <td><?php echo $narration; ?></td>
                                                    <td><?php echo $expamount; ?></td>
                                                    
                                                </tr>
                                            
                                            <?php
											$netbilty1 += $expamount;
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                                
                                                <th colspan="4" style="text-align:right">Total</th>                                                
                                                                                              
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($netbilty1),2); ?></th>
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
                                                <th>CR No</th>
                                                <th>Truck NO</th>
                                                <th>Cash Adv</th>
                                               
                                                
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$slno = 1;
											$netadv = 0;
                      $netotherAdv = 0;
                    //  echo "select *,DATE_FORMAT(adv_date,'%d-%m-%Y') as adv_date from bidding_entry where 1=1  ($cond2 and sessionid=$sessionid) and adv_cash !=0 || adv_other != 0  order by adv_date desc";
  											$sql_table = "select *,DATE_FORMAT(adv_date,'%d-%m-%Y') as adv_date from bidding_entry where 1=1  $cond2 and sessionid='$sessionid' and (adv_cash !=0 || adv_other != 0)  order by adv_date desc";											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											
                          $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                    <td><?php echo $cmn->dateformatindia($row_table['adv_date']); ?></td>
                                                    <td><?php echo $row_table['lr_no']; ?></td>

                                                    <td align="right"><i class="fa fa-inr"></i> <?php echo $truckno; ?></td>
                                                    <td align="right"><?php echo $row_table['adv_cash']; ?></td>
                                                  
                                                    
                                                   
                                                </tr>
                                            
                                            <?php
											$netadv += $row_table['adv_cash'];
                      $netotherAdv+=$row_table['adv_other']+$row_table['adv_consignor'];
											}
											?>
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                
                                                <th colspan="4" style="text-align:right">Total</th>
                                                 
                                                  <th style="text-align:right"><?php echo number_format(round($netadv),2); ?></th>
                                              
                                               
                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                   
                            
                        </div>
                    </div>
                    <?php $balamt = $prevbalance + $netbilty - $netadv-$netbilty1; 
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