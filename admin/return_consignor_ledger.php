<?php include("dbconnect.php");
error_reporting(0);
$pagename = 'return_consignor_ledger.php';
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

 
if(isset($_GET['consigneeid']))
{
	$consigneeid= trim(addslashes($_GET['consigneeid']));	
}
else
$consigneeid= '';

if(isset($_GET['billid']))
{
	$billid = trim(addslashes($_GET['billid']));	
}
else
$billid = '';


if (isset($_GET['consi_type'])) {
	$consi_type = addslashes(trim($_GET['consi_type']));
	
	//die;
} else
	$consi_type  = '';

if($fromdate !='' && $todate !='')
{ 
		$cond.=" and billdate between '$fromdate' and '$todate' ";	
		$cond1.=" and receive_date between '$fromdate' and '$todate' ";	
}

if($consignorid !='') {
	
	$cond .=" and consignorid='$consignorid'";
	$cond1 .=" and consignorid='$consignorid'";
	
	}

  
if($consigneeid!='') {
	
	$cond .=" and consigneeid='$consigneeid'";
	$cond1 .=" and consigneeid='$consigneeid'";
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
       
       
             <div class="container-fluid">
       <table  width="100%" align="">
       <tr>
    <td colspan="4" style="text-align:left;font-weight:bold;"> </td>
    <td style="padding-left: 67px;"><span style="font-size:20px;"> <br/> <strong><?php echo $companyname;?></strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Contact No: +91-<?php echo $companymob1;?></td>
  </tr>
       </table>
                       </div>        
								<form action="" method="Get" >

                                    <table  align="center" style="width:90%">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Type : </th>
                                           
                         	<?php if ($consi_type == 'Consignor') { ?> <th id="d1" style="text-align: left;"><label><strong>Consignor</strong> <span class="err" style="color:#F00;">*</span></label></th><?php } ?>
									<?php if ($consi_type == 'Consignee') { ?> <th id="d3" ><label><strong>Consignee</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?></th>
                                             <th width="15%" style="text-align:left;">Bill No</th>
                                            
                                         
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;margin-bottom: 0px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;margin-bottom: 0px;" autocomplete="off" ></td>
                                            
                                            <td>

                                            <select name="consi_type" id="consi_type" onChange="getType(this.value);" class="select2-me input-medium" style="width:220px;" required>
										
                    <option value="Consignor">Consignor</option>
                    <option value="Consignee">Consignee</option>
                  </select>
                  <script>
                    document.getElementById("consi_type").value = '<?php echo $consi_type; ?>';
                  </script>
                                            </td>

                                          

<?php if ($consi_type == 'Consignor') { ?>
                <td>                    		
              
                   <select id="consignorid" name="consignorid" class="select2-me input-large" 
                 onChange="geturl1(this.value);" 
                   style="width:200px;" >
			<option value="all"> - Select - </option>
			<?php 
			$sql = mysqli_query($connection, "Select * from  returnbidding_entry where is_invoice='1' and bill_type='Consignor' group by consignorid  ");
												
												
												while ($row = mysqli_fetch_assoc($sql)) {
												    
												    	 $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'  ");
			?>
			<option value="<?php echo $row['consignorid']; ?>"><?php echo $consignorname; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consignorid').value = '<?php echo $_GET['consignorid']; ?>';</script>

    </td>
               			<?php } ?>

									<?php if ($consi_type == 'Consignee') { ?>
									<td>                  		
              
                   <select id="consigneeid" name="consigneeid" class="select2-me input-large" 
                    onChange="geturl2(this.value);" 
                   style="width:180px;" >
			<option value="all"> - Select - </option>
			<?php 
			$sql = mysqli_query($connection, "Select * from  returnbidding_entry where is_invoice='1' and bill_type='Consignee' group by consigneeid ");
												while ($row = mysqli_fetch_assoc($sql)) {
												    
												     $consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]' ");
			?>
			<option value="<?php echo $row['consigneeid']; ?>"><?php echo $consigneename; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consigneeid').value = '<?php echo $_GET['consigneeid']; ?>';</script>

    </td>
               <?php } ?>




                                                 
                                           	<td>
                                             <select id="billid" name="billid" class="select2-me input-large" 
                   onChange="getUrl(this.value);"
                   style="width:180px;" >
			<option value="all"> - Select - </option>
			<?php 
			
      if($consi_type=='Consignor'){
			$sql_fdest = mysqli_query($connection,"select * from returnbill where consignorid='$_GET[consignorid]' and compid='$compid' and sessionid= '$sessionid' and consi_type='Consignor' ");
    }else{
    	$sql_fdest = mysqli_query($connection,"select * from  returnbill where consigneeid='$_GET[consigneeid]' and compid='$compid' and sessionid= '$sessionid'  and consi_type='Consignee'");
}
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
                              <hr>
                            <?php
							if($consignorid !='' || $consigneeid !='')
						{?>
				
                            <!-- /.box -->
                             <?php $prevbalance = 0;?>
                             
                          
                            
                          <div class="container-fluid">
                         
                          <strong style="font-size:20px;"><?php  if($consi_type=='Consignee'){?> Consignee  <?php } else {?>Consignor <?php } ?>  Ledger Details</strong>
                       
          <?php
              if($consi_type=='Consignor'){
							if($consignorid =='all')
						{?>
      <a href="pdf_return_consignor_ledgerall.php?consignorid=<?php echo $consignorid;?>&billid=<?php echo $billid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" target="_blank"> <button type="button" class="btn btn-primary" style="float: right;"> Print PDF</button></a>
      <?php } else {?> 
       <a href="pdf_return_consignor_ledger.php?consignorid=<?php echo $consignorid;?>&billid=<?php echo $billid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" target="_blank"> <button type="button" class="btn btn-primary" style="float: right;"> Print PDF</button></a></div>     
              <?php } } ?>
              
              <?php if($consi_type=='Consignee'){
                	if($consigneeid =='all'){
                ?>      
              
              <a href="pdf_return_consignee_ledgerall.php?consigneeid=<?php echo $consigneeid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" target="_blank"> <button type="button" class="btn btn-primary" style="float: right;"> Print PDF</button></a>

      <?php } else {?> 
        <a href="pdf_return_consignee_ledger.php?consigneeid=<?php echo $consigneeid;?>&fromdate=<?php echo $fromdate;?>&todate=<?php echo $todate;?>" target="_blank"> <button type="button" class="btn btn-primary" style="float: right;"> Print PDF</button></a>     </div>                    <hr>

              <?php } }?> 
                       </div>
  
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
                        <div <?php  if($consignorid == 'all' || $consigneeid == 'all'){?>style="width:100%; float:left; margin-left: 10px;"<?php } else { ?>style="width:49%; float:left; margin-left: 10px;"<?php } ?>>
                           
                           
                               
                                    <table border="1" width="98%">
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center"><strong> Bill Detail</strong></th>
                                        </tr>
                                            <tr>
                                              <th style="background-color:#C99">Sno</th>
                                              <?php	if($consi_type=='Consignee'){?>
											<th style="background-color:#C99"> Consignee  Name</th>
											<?php } else  {?>
												<th style="background-color:#C99">Consignor Name</th>
												<?php } ?>  
                                             
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
                      if($consi_type=='Consignor'){
                    
                      if($consignorid == 'all'){
                         $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignor' ";
                      }else{

                        // echo "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' $cond and consi_type='Consignor'";
                        $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' $cond and consi_type='Consignor'";
                      }
                    } if($consi_type=='Consignee'){
                    if($consigneeid == 'all'){
                      $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignee'";

                    }else{
                      $sql_table = "SELECT * FROM `returnbill` WHERE sessionid='$sessionid' and compid='$compid' $cond and consi_type='Consignee'";
                    }}
											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row = mysqli_fetch_assoc($res_table))
											{

                       
                        if($consi_type=="Consignor"){
                           $consigname1 =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");	
                                  }
                                    if($consi_type=="Consignee"){
                                
                                                $consigname1 =  $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]'");	
                                    }
									 $billno =  $cmn->getvalfield($connection,"returnbill","billno","billid='$row[billid]'");
									$billdate =  $cmn->getvalfield($connection,"returnbill","billdate","billid='$row[billid]'");
										
						//$advamount = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$row[consignorid]' && invoiceid='$row[billid]' ");
 	// $bill_amount= $cmn->get_total_billing_amt($connection,"$row[billid]");	  
 	 
 	 	


  if($consi_type=="Consignor"){
      $advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$row[consignorid]' && invoiceid='$row[billid]' ");
       $bill_amount1= $cmn->get_total_billing_amt1($connection,"$row[billid]");	 
   $payamount1= $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
   $totaltdsamt1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
    $deduct_amount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consignorid='$row[consignorid]' && billid='$row[billid]' ");
    $bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$totaltdsamt1)-($payamount1);
  
  } else {
  
    $advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consigneeid='$row[consigneeid]' && invoiceid='$row[billid]' ");
    $bill_amount1= $cmn->get_consigneetotal_billing_amt1($connection,"$row[billid]");
     $payamount1 = $cmn->getvalfield($connection,"return_consignee_payment","sum(payamount)","consigneeid='$row[consigneeid]' && billid='$row[billid]' ");
     $totaltdsamt1 = $cmn->getvalfield($connection,"return_consignee_payment","sum(tdsamt)","consigneeid='$row[consigneeid]' && billid='$row[billid]' ");
     $deduct_amount1 = $cmn->getvalfield($connection,"return_consignee_payment","sum(deduct_amount)","consigneeid='$row[consigneeid]' && billid='$row[billid]' ");
      $bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$totaltdsamt1)-($payamount1); 

  }


		if($bal_amt1 >1){
 	 		
 	 			$netbilty += $bal_amt1;
//	if($availbill==0 ){

	
	
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>
                                                   <th><?php echo $consigname1;?></th>
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
                            
                           
                               <?php if($consignorid != 'all' && $consigneeid != 'all'){?>
                                    <table border="1" width="100%">
                                  
                                        <thead>
                                        <tr>
                                        	<th colspan="9" align="center" style="border-left: 1px solid;
  border-right: 1px solid #000;"><strong><?php  if($consi_type=='Consignee'){?> Consignee  <?php } else {?>Consignor <?php } ?> Payments</strong></th>
                                        </tr>
                                            <tr>
                                                <th style="background-color:#6C9">S No</th>
                                         
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

                if($consi_type=='Consignor'){
                if($consignorid == 'all'){
                  $sel1 = "SELECT * FROM `return_consignor_payment` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignor' order by payid desc";

                }else{

                 
									$sel1 = "SELECT * FROM `return_consignor_payment` WHERE sessionid='$sessionid' and compid='$compid' $cond1 and consi_type='Consignor'order by payid desc";
                }}

                if($consi_type=='Consignee'){

                  if($consigneeid == 'all'){
                    $sel1 = "SELECT * FROM `return_consignor_payment` WHERE sessionid='$sessionid' and compid='$compid' and consi_type='Consignee' order by payid desc";
  
                  }else{
  
                   
                    $sel1 = "SELECT * FROM `return_consignor_payment` WHERE sessionid='$sessionid' and compid='$compid' $cond1 and consi_type='Consignee'order by payid desc";
                  }
                }
							$res1 = mysqli_query($connection,$sel1);
									while($row1 = mysqli_fetch_array($res1))
									{
									$billno1 =  $cmn->getvalfield($connection,"returnbill","billno","billid='$row1[billid]'");	
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

         function getType(data) {
			location = 'return_consignor_ledger.php?consi_type=' + data;
}
function geturl1() {
	// alert("ok");
    var consi_type = document.getElementById('consi_type').value;
        var consignorid =document.getElementById('consignorid').value;
        
			location = 'return_consignor_ledger.php?consi_type=' + consi_type+'&consignorid='+consignorid;
			 
}
function geturl2() {
	// alert("hiiii");
    var consi_type = document.getElementById('consi_type').value;
        var consigneeid = document.getElementById('consigneeid').value;
			location = 'return_consignor_ledger.php?consi_type=' + consi_type+'&consigneeid='+consigneeid;
			 
}
           </script>
    </body>
</html>