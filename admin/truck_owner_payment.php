<?php error_reporting(0);
include("dbconnect.php");
$tblname = "bilty_payment";
$tblpkey = "payment_id";
$pagename = "truck_owner_payment.php";
$modulename = "Truck Owner Payment";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['payment_id']))
{
	$payment_id = trim(addslashes($_GET['payment_id']));
	
}

$sql_edt = mysqli_query($connection,"select * from bilty_payment where payment_id='$payment_id'");
$row_edit = mysqli_fetch_assoc($sql_edt);
$ownerid = $row_edit['ownerid'];
$remark = $row_edit['remark'];
$payamount = $row_edit['payamount'];
$paymentdate = $row_edit['paymentdate'];
$payment_type = $row_edit['payment_type'];
$chequeno = $row_edit['chequeno'];
$chequedate = $row_edit['chequedate'];
$bankid = $row_edit['bankid'];
$tblpkey_value = $row_edit['payment_id'];

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));
	
}

if($ownerid !='')
{
	
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$payment = $cmn->getvalfield($connection,"bilty_payment","sum(payamount)","ownerid='$ownerid'");
	$total_rate_net=0;
	$total_paid_net=0;
	$sql = mysqli_query($connection,"select billtyno,wt_mt,newrate,adv_cash,adv_diesel,adv_cheque,commission,cashpayment,chequepayment from bilty_entry where truckowner='$ownername'");
	while($row=mysqli_fetch_assoc($sql))
	{
			$toalrate = $row['newrate'] * $row['wt_mt'];
			$toalrate -= $row['commission'];
			$total_deduct =  $row['adv_cash'] + $row['adv_diesel'] + $row['adv_cheque']  + $row['cashpayment'] + $row['chequepayment'];
			$total_rate_net += $toalrate;
			$total_paid_net += $total_deduct;
	}
	
				$total_paid_net += $payment;
}

if(isset($_POST['submit']))
{
	$ownerid = trim(addslashes($_POST['ownerid']));
	$payamount = trim(addslashes($_POST['payamount']));
	$paymentdate = $cmn->dateformatusa(trim(addslashes($_POST['paymentdate'])));
	$recpt_no =  $cmn->getcode($connection,$tblname,"recpt_no","1=1");
	$remark = trim(addslashes($_POST['remark']));
	$payment_id = trim(addslashes($_POST['payment_id']));
	$payment_type = trim(addslashes($_POST['payment_type']));
	$chequeno = trim(addslashes($_POST['chequeno']));
	$chequedate = $cmn->dateformatusa(trim(addslashes($_POST['chequedate'])));
	$bankid = trim(addslashes($_POST['bankid']));
	
	if($payment_id==0)
	{
		mysqli_query($connection,"insert into bilty_payment set ownerid='$ownerid',payamount='$payamount',paymentdate='$paymentdate',recpt_no='$recpt_no',createdate='$createdate',remark='$remark',payment_type='$payment_type',chequeno='$chequeno',chequedate='$chequedate',bankid='$bankid',ipaddress='$ipaddress',sessionid='$sessionid'");
		echo "<script>location='truck_owner_payment.php?ownerid=$ownerid&action=1'</script>";
	}
	else
	{
		mysqli_query($connection,"update bilty_payment set ownerid='$ownerid',payamount='$payamount',paymentdate='$paymentdate',payment_type='$payment_type',chequeno='$chequeno',chequedate='$chequedate',bankid='$bankid',remark='$remark',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid' where payment_id='$payment_id'");	
		echo "<script>location='truck_owner_payment.php?ownerid=$ownerid&action=2'</script>";
	}
	
}
else
{
	$paymentdate = date('Y-m-d');	
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

</head>

<body>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr>
                                    <td width="40%"><strong>Truck Owner Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="ownerid" name="ownerid" class="formcent select2-me" style="width:224px;" onChange="settruckno();">
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select ownerid,ownername from m_truckowner where paytype='Bulk Payment' order by ownername");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                 <tr>
                                 <td><strong>Total Bilty Amount:</strong></td>
                                    <td><input type="text" id="total_rate_net" value="<?php echo $total_rate_net; ?>" autocomplete="off"  class="input-large" required></td>
                                 </tr>
                                
                                  <tr>
                                    <td> <strong>Total Paid Amount:</strong></td>
                                    <td>
                    				<input type="text" name="total_paid_net" value="<?php echo $total_paid_net; ?>" id="total_paid_net" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr> 
                                  
                                  <tr>
                                    <td><strong>Balance Amount:</strong></td>
                                    <td>
                                    <input type="text" value="<?php echo $balamt; ?>" id="balamt" autocomplete="off"
                                     class="input-large">
                                    </td>                                    
                                  </tr>
                                  
                                  <tr>
                                    <td><strong>Pay Amount:</strong></td>
                                    <td>
                                    <input type="text" value="<?php echo $payamount; ?>" id="payamount" name="payamount" autocomplete="off"
                                     class="input-large" >
                                    </td>
                                    
                                  </tr>
                                  
                                  <tr>
                                    <td> <strong>Payment Type:</strong></td>
                                    <td>
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>
                                    </td>
                                   </tr> 
                                   
                                  <tr id="cheque_td" style="display:none" >
                                        
                                         <th  align="left"><strong>Cheque No.</strong></th>
                                            <td align="left">
                                           
                                            <input type="text" class="form-control" name="chequeno" id="chequeno" value="<?php echo $chequeno; ?>">
                                           
                                            </td>
                                            </tr>
                                            
                                           
                                            
                                             <tr id="bank_td" style="display:none">
                                        
                                         <th  align="left"><strong>Bank Name</strong></th>
                                            <td align="left">
                                           		 <select name="bankid" id="bankid"  class="formcent select2-me" style="width:224px;" >
                                           		<option value="">-Select-</option>
                                                <?php 
												$sql = mysqli_query($connection,"select bankid,bankname,helpline from m_bank order by bankname");
												while($row=mysqli_fetch_assoc($sql))
												{
												?>
                                               	<option value="<?php echo $row['bankid']; ?>"><?php echo $row['bankname'].' / '.$row['helpline']; ?></option>
                                               <?php 
												}
											   ?>
                                           </select>
                                           <script>document.getElementById('bankid').value = '<?php echo $bankid ; ?>'; </script>
                                            
                                            </td>
                                             
                                        </tr> 
                                        
                                         <tr id="chequed_td" style="display:none" >
                                        
                                         <th  align="left"><strong>Cheque Date</strong></th>
                                            <td align="left">
                                           
                                            <input type="text" class="form-control" name="chequedate" id="chequedate" value="<?php echo $cmn->dateformatindia($chequedate); ?>" data-date="true" placeholder="dd-mm-yyyy" >
                                           
                                            </td>
                                            </tr>
                                  
                                  <tr>
                                  <td><strong>Payment Date:</strong></td>
                                    <td><input type="text" name="paymentdate" id="paymentdate" value="<?php echo $cmn->dateformatindia($paymentdate); ?>" autocomplete="off" class="input-large" data-date="true" placeholder="dd-mm-yyyy" ></td>
                                  </tr>
                                  
                                   <tr>
                                    <td><strong>Remark:</strong></td>
                                    <td>
                                    <input type="text" value="<?php echo $remark; ?>" id="remark" name="remark" autocomplete="off" class="input-large" >
                                    </td>
                                    
                                  </tr>
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('payamount,paymentdate');" >
                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                    			</td>
                                </tr>  
                                 
                                  
                                </table> 
                                </div>
                                </form>
                                
                           </div>
                           
                           <div class="span5" style="float:right;" >
                        
                                <div class="control-group">
                                 
                                </div>
                            
                           </div>     
							
						</div>
					</div>
				</div>
                
                
                <?php 
				if($ownerid !='')
				{
				?>
                <!--   DTata tables -->
                <div class="row-fluid" >
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Receipt No</th> 
                                            <th>Payment Date</th> 
                                            <th>Payment Type</th>
                                        	<th>Owner Name</th>                                            
                                            <th>Payment</th> 
                                            <th>Remark</th>                                                                                      
                                        	<th class='hidden-480'>Action</th>                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from bilty_payment where ownerid='$ownerid' order by paymentdate desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'"); 
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['recpt_no']);?></td>
                                            <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td>
                                            <td><?php echo ucfirst($ownername);?></td>
                                            <td><?php echo ucfirst($row['payamount']);?></td>
                                            <td><?php echo ucfirst($row['remark']);?></td>                                           
                                            <td class='hidden-480'>
                                           <a href= "?payment_id=<?php echo ucfirst($row['payment_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
				<?php 
				}
				?>			
			</div>
		</div></div>
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

jQuery(function($){
   $("#paymentdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#chequedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

function settruckno()
{
	var ownerid = document.getElementById('ownerid').value;
	
	if(ownerid !='')
	{
		window.location.href='?ownerid='+ownerid;
	}	
}

function getbalamt()
{
	var total_rate_net = document.getElementById('total_rate_net').value;
	var total_paid_net = document.getElementById('total_paid_net').value;
	
	if(isNaN(total_rate_net))
	{
		var total_rate_net = 0;	
	}
	
	if(isNaN(total_paid_net))
	{
		var total_paid_net = 0;	
	}
	var balamt = total_rate_net - total_paid_net;
	document.getElementById('balamt').value=balamt.toFixed(2);
}

getbalamt();


function set_payment(payment_type)
{
	if(payment_type != "")
	{
		if(payment_type == 'cash')
		{
			//$("#chequeno").val('');
			//$("#refno").val('');
			//$("#bank_name").val('');
			
			$("#cheque_td").hide();
			$("#bank_td").hide();
			$("#chequed_td").hide();
			
		
		}
		else if(payment_type=='cheque' || payment_type=='neft' )
		{
			//$("#chequeno").val('');
			//$("#refno").val('');
			//$("#bank_name").val('');
			
			$("#cheque_td").show();
			$("#bank_td").show();
			$("#chequed_td").show();
			
		}
	}
}

set_payment("<?php echo $payment_type; ?>");

</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
