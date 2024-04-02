<?php error_reporting(0); include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_payment_emami.php';
$modulename = "Recent Added Billty";

	if($usertype=='admin')
	{
	$crit=" where payment_date='0000-00-00'";
	}
	else
	{
$crit=" where payment_date='0000-00-00'";
	}

if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));
	$crit=" where bid_id='$bid_id'";
	$sql = mysqli_query($connection,"select  * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);	
	
	$consignorid = $row['consignorid'];
	$consigneeid = $row['consigneeid'];
	$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
	$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
	$truckid = $row['truckid'];
	$wt_mt = $row['totalweight'];
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
	$neftpayment =$row['neftpayment']; 	

	
	if($payment_date=='0000-00-00')
	{
			$payment_date = date('Y-m-d');
			$compcommission = $cmn->getvalfield($connection,"m_consignor","commission","consignorid='$consignorid'");
	}
	
	
	$netamount = $newrate * $wt_mt;
	$charrate = $rate_mt - $newrate;	
	$tot_adv = $adv_cash  + $adv_cheque +$adv_other+$adv_consignor;
	
	$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other-$adv_consignor - $commission;
	
	$tot_profit = $wt_mt * $charrate;
	$comp_commision = ($tot_profit * $compcommission)/100;
	$net_profit = round($tot_profit - $comp_commision);
	
	$othrcharrate = $rate_mt - $newrate;
	
	if($newrate==0){ $newrate=''; }
	if($adv_cash==0){ $adv_cash=''; }
	if($adv_diesel==0){ $adv_diesel=''; }
	if($adv_cheque==0){ $adv_cheque=''; }
	if($adv_other==0){ $adv_other=''; }
	if($adv_consignor==0){ $adv_consignor=''; }
	
	
}



if(isset($_POST['sub']))
{
	$bid_id = trim(addslashes($_POST['bid_id']));
	$newrate = trim(addslashes($_POST['newrate']));
	$payment_date = $cmn->dateformatusa(trim(addslashes($_POST['payment_date'])));
	$chequepaydate = $cmn->dateformatusa(trim(addslashes($_POST['chequepaydate'])));
	$commission = trim(addslashes($_POST['commission']));
	$tds_amt = trim(addslashes($_POST['tds_amt']));
	$cashpayment = trim(addslashes($_POST['cashpayment']));
	$neftpayment = trim(addslashes($_POST['neftpayment']));
	$chequepayment = trim(addslashes($_POST['chequepayment']));
	$chequepaymentno = trim(addslashes($_POST['chequepaymentno']));
	$paymentbankid = trim(addslashes($_POST['paymentbankid']));
	$deduct = trim(addslashes($_POST['deduct']));
	$deduct_r = trim(addslashes($_POST['deduct_r']));
	$trip_commission = trim(addslashes($_POST['trip_commission'])); 
	$freightamt =trim(addslashes($_POST['freightamt']));  
	//$cashbook_date = $cmn->dateformatusa(trim(addslashes($_POST['cashbook_date'])));
	$payeename = trim(addslashes($_POST['payeename']));
   $ac_holder =  trim(addslashes($_POST['ac_holder']));
	$sessionid = 3;

	
	if(($cashpayment !='' || $cashpayment !='0') && ($commission !='' || $commission !='0') && ($chequepayment !='' || $chequepayment !='0'))
	{
		
 $sql_update = "update bidding_entry set newrate='$newrate',payment_date='$payment_date',commission= 
	'$commission',chequepaydate='$chequepaydate',tds_amt='$tds_amt',cashpayment ='$cashpayment',	chequepayment='$chequepayment',chequepaymentno='$chequepaymentno',payeename='$payeename',deduct='$deduct',ac_holder='$ac_holder',
	deduct_r='$deduct_r',trip_commission='$trip_commission',freightamt='$freightamt',
	neftpayment='$neftpayment',paymentbankid='$paymentbankid',is_complete='1',lastupdated=now(),
	ipaddress = '$ipaddress' where bid_id='$bid_id'"; 

			mysqli_query($connection,$sql_update);
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='bilty_payment_emami.php?action=2'</script>";
	}
}


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
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from bidding_entry $crit  && recweight !='0' && consignorid =4"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >           <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                             
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Bilty Payment Emami</legend>   
                <div class="innerdiv">
                    <div> DI No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
                    <select id="bid_id" name="bid_id" class="formcent select2-me" style="width:220px;" onChange="window.location.href='?bid_id='+this.value">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bid_id,di_no from bidding_entry $crit  && recweight !='0' && consignorid =4");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['bid_id']; ?>"><?php echo $row_fdest['di_no']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('bid_id').value = '<?php echo $bid_id; ?>';</script>                                  
                </div>
               </div>
               
                <div class="innerdiv">
                    <div> Consignor Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $consignorname; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Consignee Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $consigneename; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> From Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $fromplace; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> To Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $toplace; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                 <div class="innerdiv">
                    <div> Truck No </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $truckno; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Owner Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $truckowner; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
         
                
                <div class="innerdiv">
                    <div> Item Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $itemname; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
               <div class="innerdiv">
                    <div> Weight </div>
                    <div class="text">
                     <input type="text" class="formcent" id="wt_mt" value="<?php echo $wt_mt; ?>" required readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div>  Company Rate </div>
                    <div class="text">
                     <input type="text" class="formcent"  value="<?php echo $rate_mt; ?>" id="rate_mt" name="freightamt" required  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
               
			    <div class="innerdiv">
                    <div> Commission  </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $othrcharrate; ?>" name="trip_commission" id="othrcharrate" style="border: 1px solid #368ee0;" onChange="gettot_paid();"  autocomplete="off" >
					 <input type="hidden" class="formcent" value="<?php echo $charrate; ?>" id="charrate" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  readonly >
                </div>
                </div>
				
               <div class="innerdiv">
                    <div> Final Rate(M.T.) <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="newrate" id="newrate" value="<?php echo $newrate; ?>" required style="border: 1px solid #368ee0;"  autocomplete="off" onChange="gettot_paid();" >
                    </div>
                </div>
            
            
               
               <div class="innerdiv">
                    <div> Net Amount <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $netamount; ?>" id="netamount" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Cash Adv </div>
                    <div class="text">
                    <input type="text" class="formcent" value="<?php echo $tot_adv; ?>" id="tot_adv"  onChange="getbal();" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                    </div>
                </div>
				
				 <div class="innerdiv">
                    <div> Diesel Adv </div>
                    <div class="text">
                    <input type="text" class="formcent" value="<?php echo $adv_diesel; ?>" id="adv_diesel" onChange="getbal();" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                    </div>
                </div>
            
                
               
                
                
                <div class="innerdiv" style="display:none;">
                    <div> Total Profit </div>
                    <div class="text">
                     <input type="text" class="formcent" id="tot_profit" value="<?php echo $tot_profit; ?>" style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly >
                </div>
                </div>
                
                           
                
                <div class="innerdiv" style="display:none;">
                    <div> Net Profit </div>
                    <div class="text">
                     <input type="text" class="formcent" id="net_profit" value="<?php echo $net_profit; ?>" style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly >
                </div>
                </div>
                
                <!-- <div class="innerdiv">
                    <div> Shortage Weight(MT) </div>
                    <div class="text">
                    <input type="text" class="formcent" name="shortagewt" id="shortagewt" value="<?php //echo $shortagewt; ?>" required style="border: 1px solid #368ee0"  autocomplete="off" >
                    </div>
                </div>-->
                
                 
                
                 <div class="innerdiv">
                    <div>Bilty Commission(Rs) </div>
                    <div class="text">
                    <input type="text" class="formcent" name="commission" id="commission" value="<?php echo $commission; ?>" required style="border: 1px solid #368ee0"  autocomplete="off" onChange="gettot_paid();"  >
                    </div>
                </div>
				
				
				<div class="innerdiv">
                    <div> TDS(%) </div>
                    <div class="text">
                    <input type="text" class="formcent" name="tds_amt" id="tds_amt" value="<?php echo $tds_amt; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
				
				<div class="innerdiv">
                    <div> TDS(Rs) </div>
                    <div class="text">
                    <input type="text" class="formcent" name="tds_amount" id="tds_amount" value="<?php echo $tds_amount; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
				
				<div class="innerdiv">
                    <div> Deduction </div>
                    <div class="text">
                    <input type="text" class="formcent" name="deduct" id="deduct" value="<?php echo $deduct; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
				
				<div class="innerdiv">
                    <div> Deduct Remark </div>
                    <div class="text">
                    <input type="text" class="formcent" name="deduct_r" id="deduct_r" value="<?php echo $deduct_r; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"   >
                    </div>
                </div>
				
				 <div class="innerdiv">
                    <div>Bal Amount</div>
                    <div class="text">
                     <input type="text" class="formcent" id="bal_amount" value="<?php echo $balamt; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
                                  
                                
                
                
                 <div class="innerdiv">
                    <div>  Cash Payment </div>
                    <div class="text">
                    <input type="text" class="formcent" name="cashpayment" id="cashpayment" value="<?php echo $cashpayment; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
				
				<div class="innerdiv">
                    <div>  NEFT Payment </div>
                    <div class="text">
                    <input type="text" class="formcent" name="neftpayment" id="neftpayment" value="<?php echo $neftpayment; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
            
                          
                <div class="innerdiv">
                    <div>Cheque Payment</div>
                    <div class="text">
                    <input type="text" class="formcent" name="chequepayment" id="chequepayment" value="<?php echo $chequepayment; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  onChange="gettot_paid();"  >
                    </div>
                </div>
            
          
            
               <div class="innerdiv">
                    <div> Cheque No </div>
                    <div class="text">
                     <input type="text" class="formcent" name="chequepaymentno" id="chequepaymentno" value="<?php echo $chequepaymentno; ?>"   style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
                 <div class="innerdiv">
                    <div> Payee Name </div>
                    <div class="text">
                    <input type="text" class="formcent" name="payeename" id="payeename" value="<?php echo $payeename; ?>" style="border: 1px solid #368ee0"  autocomplete="off" >
                    </div>
                </div>
                
                <div class="innerdiv">
                    <div> Bank Name <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    		
                    <select id="paymentbankid" name="paymentbankid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bankid,bankname,helpline from m_bank order by bankname");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['bankid']; ?>"><?php echo $row_fdest['bankname'].' / '.$row_fdest['helpline']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('paymentbankid').value = '<?php echo $paymentbankid; ?>';</script>                                  
                </div>
               </div>
               
                <div class="innerdiv">
                    <div>Cheque Payment Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="chequepaydate" id="chequepaydate" value="<?php echo $cmn->dateformatindia($chequepaydate); ?>" style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                
                 <div class="innerdiv">
                    <div>Payment Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="payment_date" id="payment_date" value="<?php echo $cmn->dateformatindia($payment_date); ?>" style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
               
                
             
              <div class="innerdiv">
                    <div>Total Paid</div>
                    <div class="text">
                    <input type="text" class="formcent"  id="total_paid" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly >
                    </div>
                </div>
                
                <div class="innerdiv">
                    <div>Remaining Amount </div>
                    <div class="text">
                    <input type="text" class="formcent"  id="remaining" value="" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly >
                    </div>
                </div>

                <br>

                  <div class="innerdiv">
                    <div>Account Holder </div>
                    <div class="text">
                    <input type="text" class="formcent"  name="ac_holder" value="<?php echo $ac_holder; ?>" id="ac_holder"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                    </div>
                </div>
               
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return chepayment(); " >
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
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="bilty_paymenrecord.php" target="_blank">Click Here</a>)</span></h3>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>DI No.</th>
											<th>GR NO</th>
											<th>Invoice No </th>
											<th>Truck No.</th>
											<th>Consignor</th>
											<th>Consignee</th>
											<th>Payment Date</th>
											<th>Commission</th> 
											<th>Final Pay</th>    
											<th>Print</th>
											<th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									if($usertype=='admin')
									{
									$crit="";
									}
									else
									{
									//$crit=" && createdby='$userid'";	
									$crit="";
									}	
									$sel = "select  * from bidding_entry where is_complete=1 $crit && consignorid=4 order by payment_date desc limit 50";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['di_no'];?></td>
							<td><?php echo $row['gr_no'];?></td>
                             <td><?php echo $row['invoiceno'];?></td>
                             <td><?php echo $truckno;?></td>
                           
                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                            <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                            <span style="color:#FFF;"> <?php echo $truckno; ?> </span>
                            </td>
                           
                           <td><?php echo $row['commission'];?></td>                         
                            
                             <td><?php echo number_format($row['cashpayment']+$row['chequepayment']+$row['neftpayment'],2);?></td>
                            <td><a href="pdf_paymentreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                    </td>
                            <td class='hidden-480'>
                           <a href= "?bid_id=<?php echo ucfirst($row['bid_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
function funDel(id)
{    
	  //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
	   tblpkey = '<?php echo $tblpkey; ?>';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close



//below code for date mask
jQuery(function($){
	$("#payment_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#chequepaydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#cashbook_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
});


 

function gettot_paid()
{
	var commission = parseFloat(document.getElementById('commission').value);
	var newrate = parseFloat(document.getElementById('newrate').value);
	var rate_mt = parseFloat(document.getElementById('rate_mt').value); 
	var cashpayment = parseFloat(document.getElementById('cashpayment').value);
	var chequepayment = parseFloat(document.getElementById('chequepayment').value);
	var bal_amount = parseFloat(document.getElementById('bal_amount').value);
	var tds_amt =  parseFloat(document.getElementById('tds_amt').value);
	var adv_diesel =  parseFloat(document.getElementById('adv_diesel').value);
	var wt_mt =  parseFloat(document.getElementById('wt_mt').value);
	var neftpayment =  parseFloat(document.getElementById('neftpayment').value);
	var othrcharrate = parseFloat(document.getElementById('othrcharrate').value);
	var tot_adv = parseFloat(document.getElementById('tot_adv').value);
	var adv_diesel = parseFloat(document.getElementById('adv_diesel').value);
	var deduct = parseFloat(document.getElementById('deduct').value);
	var tds_amount = parseFloat(document.getElementById('tds_amount').value);
	
	if(isNaN(tot_adv)){ tot_adv=0; }
	if(isNaN(adv_diesel)){ adv_diesel=0; }
	if(isNaN(neftpayment)){ neftpayment=0; }
	if(isNaN(newrate)){ newrate=0; }
	if(isNaN(rate_mt)){ rate_mt=0; }
	if(isNaN(adv_diesel)){ adv_diesel=0; }
	if(isNaN(othrcharrate)){ othrcharrate=0; }
	if(isNaN(deduct)){ deduct=0; }
	if(isNaN(commission))
	{
		commission = 0;	
	}
	
	if(isNaN(cashpayment))
	{
		cashpayment = 0;	
	}
	
	if(isNaN(chequepayment))
	{
		chequepayment = 0;	
	}
	
	if(isNaN(tds_amt))
	{
		tds_amt=0;
	}
	
	if(isNaN(wt_mt))
	{
		wt_mt=0;
	}
	
	
	newrate = rate_mt - othrcharrate;
	
	document.getElementById('newrate').value=newrate;
	
	var char = rate_mt - newrate;	
	document.getElementById('charrate').value= char;	
	//alert(commission)	
	var netamt = newrate * wt_mt;
	document.getElementById('netamount').value= netamt;
	
	tds_amt = netamt*tds_amt/100;
	document.getElementById('tds_amount').value= Math.round(tds_amt);
	
	var balamount = netamt - commission - adv_diesel - tot_adv - tds_amount -deduct;
	
	document.getElementById('bal_amount').value = balamount.toFixed(2);
  
	var tot_paid = cashpayment + chequepayment + neftpayment;
	
	document.getElementById('total_paid').value = tot_paid.toFixed(2);
	
	var remainingpayment = bal_amount - tot_paid;
	
	
	document.getElementById('remaining').value = remainingpayment.toFixed(2);
	
	
}

gettot_paid();

 
function chepayment()
{
	gettot_paid();
	var bal_amount = parseFloat(document.getElementById('bal_amount').value);
	var total_paid = parseFloat(document.getElementById('total_paid').value); 
	
	if(isNaN(bal_amount))
	{
		bal_amount = 0;	
	}
	
	if(isNaN(total_paid))
	{
		total_paid = 0;	
	}
	
	
}

function get_net_profit()
{
	var tot_profit = document.getElementById('tot_profit').value;
	var commission = document.getElementById('compcommission').value;
	
	if(isNaN(tot_profit))
	{
		tot_profit=0;	
	}
	
	if(isNaN(commission))
	{
		commission=0;	
	}
	
	var net_profit = tot_profit - (tot_profit * commission)/100;
	
	document.getElementById('net_profit').value=net_profit.toFixed(2);
}
</script>			
                
		
	</body>

	</html>
