<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'return_consignor_payment';
$tblpkey = 'payid';
$pagename  ='return_bill_payment.php';
$modulename = "Payment Receive";

	if($usertype=='admin')
	{
	$crit=" where payment_date='0000-00-00'";
	}
	else
	{
$crit=" where payment_date='0000-00-00'";
	}
if (isset($_GET['consi_type'])) {
	$consi_type = addslashes(trim($_GET['consi_type']));
	
	//die;
} else
	$consi_type  = '';
if(isset($_GET['consignorid']) && isset($_GET['billid']))
{
	 
	 $advamount = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$_GET[consignorid]' && invoiceid='$_GET[billid]'");
 	   $bill_amount= $cmn->get_total_billing_amt1($connection,"$_GET[billid]");	 
	 $payamount = $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consignorid='$_GET[consignorid]' && billid='$_GET[billid]'");
	 $totaltdsamt = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consignorid='$_GET[consignorid]' && billid='$_GET[billid]'");
	  $deduct_amount = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consignorid='$_GET[consignorid]' && billid='$_GET[billid]'");
	 $bal_amt=($bill_amount-$advamount-$deduct_amount-$totaltdsamt)-($payamount);
	
}



if(isset($_GET['consigneeid']) && isset($_GET['billid']))
{
	 
	 $advamount = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consigneeid='$_GET[consigneeid]' && invoiceid='$_GET[billid]'");
 	 $bill_amount= $cmn->get_consigneetotal_billing_amt1($connection,"$_GET[billid]");	  
	 $payamount = $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consigneeid='$_GET[consigneeid]' && billid='$_GET[billid]'");
	 $totaltdsamt = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consigneeid='$_GET[consigneeid]' && billid='$_GET[billid]'");
	  $deduct_amount = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consigneeid='$_GET[consigneeid]' && billid='$_GET[billid]'");
	$bal_amt=($bill_amount-$advamount-$deduct_amount-$totaltdsamt)-($payamount);

	
	
}



if(isset($_POST['sub']))
{
$consignorid=$_POST['consignorid'];
$consigneeid=$_POST['consigneeid'];
$billid=$_POST['billid'];
$bill_amount=$_POST['bill_amount'];
$payamount=$_POST['payamount'];
$deduct_amount=$_POST['deduct_amount'];
$bal_amt=$_POST['bal_amt'];
$tdsper=$_POST['tdsper'];
$tdsamt=$_POST['tdsamt'];
$advamount=$_POST['advamount'];
$narration=$_POST['narration'];
$receive_date=$_POST['receive_date'];
$payment_rec_no=$_POST['payment_rec_no'];
	if(($billid !='' || $bill_amount !='0')  && ($payamount !='' || $receive_date !='0'))
	{
		
  $sql_update = "INSERT INTO return_consignor_payment set consignorid='$consignorid',consigneeid='$consigneeid',consi_type='$consi_type',billid='$billid',bill_amount='$bill_amount',payamount='$payamount',tdsper='$tdsper',tdsamt='$tdsamt',advamount='$advamount',deduct_amount='$deduct_amount',bal_amt='$bal_amt',receive_date='$receive_date',payment_rec_no='$payment_rec_no',narration='$narration',createdate='$createdate',sessionid='$sessionid',compid='$compid',userid='$userid',ipaddress='$ipaddress'"; 
			mysqli_query($connection,$sql_update);
			
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='return_bill_payment.php?action=1&consi_type=$consi_type&consignorid=$consignorid&consigneeid=$consigneeid'</script>";
	}
}else{
$payment_rec_no = $cmn->getcode($connection,"return_consignor_payment","payment_rec_no","1=1 and sessionid = $_SESSION[sessionid] && compid='$compid'");
}

//echo "select * from bill where consignorid='$_GET[consignorid]'";die;
?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#0CF;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:230px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>
<script>

  
  $(function() {
   
   $('#receive_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
     
  });

</script>

</head>

<body data-layout-topbar="fixed">
 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
					
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from returnbidding_entry $crit  && recweight !='0' && consignorid =4"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >           <!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->                             
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Payment Receive </legend>   
              
              
              
                <div class="innerdiv">
                    <div> Type <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
              
               	<select name="consi_type" id="consi_type" onChange="getType(this.value);" class="select2-me input-medium" style="width:220px;" required>
										
											<option value="Consignor">Consignor</option>
											<option value="Consignee">Consignee</option>
										</select>
										<script>
											document.getElementById("consi_type").value = '<?php echo $consi_type; ?>';
										</script>

                </div>
               </div>
              
              
              
              
                <div class="innerdiv">
                    
                    <div>
                        	<?php if ($consi_type == '') { ?> <td id="d1"><label><strong>Consignor</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?>
                         	<?php if ($consi_type == 'Consignor') { ?> <td id="d1"><label><strong>Consignor</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?>
									<?php if ($consi_type == 'Consignee') { ?> <td id="d3"><label><strong>Consignee</strong> <span class="err" style="color:#F00;">*</span></label></td><?php } ?> </div>
									
									<?php if ($consi_type == '') { ?>
                  	<div class="text">                    		
              
                   <select id="consignorid" name="consignorid1" class="select2-me input-large" 
                 onChange="geturl1(this.value);" 
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql = mysqli_query($connection, "Select * from  returnbidding_entry where is_invoice='1' and bill_type='Consignor' ");
												
												
												while ($row = mysqli_fetch_assoc($sql)) {
												    
												    	 $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'  ");
			?>
			<option value="<?php echo $row['consignorid']; ?>"><?php echo $consignorname; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consignorid').value = '<?php echo $_GET['consignorid']; ?>';</script>

                </div>
               </div>
               			<?php } ?>
									
									
                  	<?php if ($consi_type == 'Consignor') { ?>
                  	<div class="text">                    		
              
                   <select id="consignorid" name="consignorid" class="select2-me input-large" 
                 onChange="geturl1(this.value);" 
                   style="width:200px;" >
			<option value=""> - Select - </option>
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

                </div>
               </div>
               			<?php } ?>

									<?php if ($consi_type == 'Consignee') { ?>
										<div class="text">                    		
              
                   <select id="consigneeid" name="consigneeid" class="select2-me input-large" 
                    onChange="geturl2(this.value);" 
                   style="width:220px;" >
			<option value=""> - Select - </option>
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

                </div>
               </div>
               <?php } ?>
               <div class="innerdiv">
                    <div> Bill No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
              <!-- <?php echo "select * from  returnbill  where consigneeid='$_GET[consigneeid]' and compid='$compid'and sessionid= '$sessionid'";?> -->
                   <select id="billid" name="billid" class="select2-me input-large" 
                   onChange="getdel();"
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			
if($consi_type=='Consignor'){
			$sql_fdest = mysqli_query($connection,"select * from  returnbill where consignorid='$_GET[consignorid]' and compid='$compid'and sessionid= '$sessionid'");
}else{
    	$sql_fdest = mysqli_query($connection,"select * from  returnbill where consigneeid='$_GET[consigneeid]' and compid='$compid' and sessionid= '$sessionid'");
}
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
				// $advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$row_fdest[consignorid]' && invoiceid='$row_fdest[billid]' ");
 	
	// $tdsamt1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
		
				// $bill_amount1= $cmn->get_total_billing_amt1($connection,"$row_fdest[billid]");
	// $payamount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
	// $deduct_amount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
//	$bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$tdsamt1)-($payamount1);

if($consi_type=="Consignor"){
	 $advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consignorid='$row_fdest[consignorid]' && invoiceid='$row_fdest[billid]' ");
	  $bill_amount1= $cmn->get_total_billing_amt1($connection,"$row_fdest[billid]");	 
 $payamount1= $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
 $totaltdsamt1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
  $deduct_amount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consignorid='$row_fdest[consignorid]' && billid='$row_fdest[billid]' ");
  $bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$totaltdsamt1)-($payamount1);

} else {

	$advamount1 = $cmn->getvalfield($connection,"returnbidding_entry","sum(adv_consignor)","consigneeid='$row_fdest[consigneeid]' && invoiceid='$row_fdest[billid]' ");
	$bill_amount1= $cmn->get_consigneetotal_billing_amt1($connection,"$row_fdest[billid]");
   $payamount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(payamount)","consigneeid='$row_fdest[consigneeid]' && billid='$row_fdest[billid]' ");
   $totaltdsamt1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(tdsamt)","consigneeid='$row_fdest[consigneeid]' && billid='$row_fdest[billid]' ");
   $deduct_amount1 = $cmn->getvalfield($connection,"return_consignor_payment","sum(deduct_amount)","consigneeid='$row_fdest[consigneeid]' && billid='$row_fdest[billid]' ");
    $bal_amt1=($bill_amount1-$advamount1-$deduct_amount1-$totaltdsamt1)-($payamount1);
}


		if($bal_amt1>1){
			?>
			<option value="<?php echo $row_fdest['billid']; ?>"><?php echo $row_fdest['billno']; ?></option>
			<?php
		} } ?>
			</select>
			<script>document.getElementById('billid').value = '<?php echo $_GET['billid']; ?>';</script>

                </div>
               </div>
               <div class="innerdiv">
                    <div> Bill Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" id="bill_amount" name="bill_amount" value="<?php echo $bill_amount; ?>"  style="border: 1px solid #368ee0; color:#F00" readonly autocomplete="off"  >
                </div>
                </div>
               <div class="innerdiv">
                    <div> Advance Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" id="advamount" name="advamount" value="<?php echo $advamount; ?>"  style="border: 1px solid #368ee0; color:#F00" readonly autocomplete="off"  >
                </div>
                </div>
                
                
                
                 
                
                <div class="innerdiv">
                    <div>Balance Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" 	 id="bal_amt" name="bal_amt"  value="<?php echo $bal_amt; ?>"  style="border: 1px solid #368ee0; color:#F00" readonly  autocomplete="off"  >
                </div>
                </div>
                <div class="innerdiv">
                    <div> TDS(%)  </div>
                    <div class="text">
                     <input type="text" class="formcent" id="tdsper" name="tdsper" value="<?php echo $tdsper; ?>" onChange="getBalance();"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                    
                </div>
                </div>
                <div class="innerdiv">
                    <div> TDS(Rs) </div>
                    <div class="text">
                     <input type="text" class="formcent" id="tdsamt" name="tdsamt" value="<?php echo $tdsamt; ?>"  style="border: 1px solid #368ee0;" readonly  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Other Deduction Amount </div>
                    <div class="text">
                     <input type="text" class="formcent" name="deduct_amount" id="deduct_amount" onChange="getDeduct();"   style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
                <div class="innerdiv">
                    <div>Receive Amount   <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" class="formcent" name="payamount" id="payamount"  style="border: 1px solid #368ee0;" autocomplete="off"  required>
                </div>
                </div>


                
                
                
                

        
                        
                
                <div class="innerdiv">
                    <div> Receive Date </div>
                    <div class="text">
                     <input type="date" class="formcent"  name="receive_date" id="receive_date"  value="<?php  $date=date('Y-m-d'); 
                     echo date('Y-m-d',strtotime($date)); ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>

                <div class="innerdiv">
                    <div> Payment Receive No </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="payment_rec_no" id="payment_rec_no"  value="<?php echo $payment_rec_no; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Narration </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="narration" id="narration"  value="<?php echo $narration; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
              
         
              
             
			   
           
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"   >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                    <input  type="hidden" name="wt_mt" id="wt_mt" value="<?php echo $wt_mt; ?>" >
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
            <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						    <div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3></div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
										<?php	if($consi_type=='Consignee'){?>
											<th> Consignee  Name</th>
											<?php } else  {?>
												<th>Consignor Name</th>
												<?php } ?>
                                            <th>Bill No.</th>
											<th>Pay Amount</th>
											<th>TDS Amount</th>
                                            <th>Payment Receive No</th>
											<th>Pay Date </th>
                                            <th>Narration </th>
											<th>Print</th>

										<th>Delete</th>
											    
											<!-- <th class='hidden-480'>Action</th> -->
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								//	echo "SELECT * FROM `return_consignor_payment` WHERE compid='$compid' && consignorid='$_GET[consignorid]' order by payid desc";
								if($consi_type=="Consignor"){
									$sel = "SELECT * FROM `return_consignor_payment` WHERE compid='$compid' && consignorid='$_GET[consignorid]' and sessionid='$sessionid' and consi_type='Consignor' order by payid desc";
								}
									if($consi_type=="Consignee"){
									    $sel = "SELECT * FROM `return_consignor_payment` WHERE compid='$compid' && consigneeid='$_GET[consigneeid]' and sessionid='$sessionid' and consi_type='Consignee' order by payid desc";
									}
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{


									    		if($consi_type=="Consignor"){
									$consigname =  $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");	
									    		}
									    			if($consi_type=="Consignee"){
												
									    			    			 $consigname =  $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]'");	
									    			}
									$billno =  $cmn->getvalfield($connection,"bill","billno","billid='$row[billid]'");	
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                              <td><?php echo $consigname;?></td> 
                          <td><?php echo $billno;?></td> 
                          
					         <td><?php echo number_format(round($row['payamount']),2);?></td>
					         <td><?php echo $row['tdsamt'];?></td>
                             <td><?php echo $row['payment_rec_no'];?></td>
                             
                            <td><?php echo dateformatindia($row['receive_date']);?></td>  
                           <td><?php echo $row['narration'];?></td>
                                                  
                            
                            
                           <td><a href="pdf_reurn_bill_payment.php?payid=<?php echo $row['payid'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                    </td>
                                              <td class='hidden-480'>
                           <a onClick="funDel(<?php echo $row['payid'];?>)" class="btn btn-danger">Delete</a>
                           </td> 
                        </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
            </div>
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
 function funDel(id)
 {    
 //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
 	   tblpkey = '<?php echo $tblpkey; ?>';
 	   pagename  ='<?php echo $pagename; ?>';
 		modulename  ='<?php echo $modulename; ?>';
// 	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
 	{
 		$.ajax({
 		  type: 'POST',
 		  url: '../ajax/delete1.php',
 		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
 		  dataType: 'html',
 		  success: function(data){
 			  // alert(data);
// 			 // alert('Data Deleted Successfully');
 			  location=pagename+'?consignorid=<?php echo $_GET['consignorid'];?>';
		}
		
		  });//ajax close
	}//confirm close
	} //fun close
function getdel(){

    var billid = document.getElementById('billid').value;
      var consi_type = document.getElementById('consi_type').value;
if(consi_type=='Consignor'){
    var consignorid = parseFloat(document.getElementById('consignorid').value);
	location = 'return_bill_payment.php?consi_type=' + consi_type+'&consignorid='+consignorid +'&billid='+billid;
}
else {
      var consigneeid = parseFloat(document.getElementById('consigneeid').value);
	location = 'return_bill_payment.php?consi_type=' + consi_type+'&consigneeid='+consigneeid +'&billid='+billid;
}
	// window.location.href='?consi_type=' + Consignor+'billid='+billid+'&consignorid='+<?php echo $_GET['consignorid'];?>
		// location = 'return_bill_payment.php?consi_type=' +consi_type+'&consignorid='+consignorid+'billid='+billid+;
}
function getType(data) {
			location = 'return_bill_payment.php?consi_type=' + data;
}
function geturl1() {

    var consi_type = document.getElementById('consi_type').value;
        var consignorid = parseFloat(document.getElementById('consignorid').value);
        
			location = 'return_bill_payment.php?consi_type=' + consi_type+'&consignorid='+consignorid;
			 
}
function geturl2() {

    var consi_type = document.getElementById('consi_type').value;
        var consigneeid = parseFloat(document.getElementById('consigneeid').value);
			location = 'return_bill_payment.php?consi_type=' + consi_type+'&consigneeid='+consigneeid;
			 
}
function getBalance()
{
var bal_amt = parseFloat(document.getElementById('bal_amt').value);
var bill_amount = parseFloat(document.getElementById('bill_amount').value);
	var tdsper = parseFloat(document.getElementById('tdsper').value);
	
	if(bill_amount!=''){
	var tdsamt = bill_amount*tdsper/100;
	bal_amt = bal_amt-tdsamt;

	document.getElementById('tdsamt').value=tdsamt;
	document.getElementById('bal_amt').value=bal_amt;
	}
	
}
function getDeduct()
{
	var bal_amt = parseFloat(document.getElementById('bal_amt').value);
	
	var deduct_amount = parseFloat(document.getElementById('deduct_amount').value);
	
	if(!isNaN(deduct_amount)){
		
		bal_amt = bal_amt-deduct_amount;
		
	document.getElementById('bal_amt').value=bal_amt;
	}
}




</script>			
                
		
	</body>

	</html>
