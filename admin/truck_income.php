<?php error_reporting(0);
include("dbconnect.php");
$tblname = "otherincome";
$tblpkey = "otherincomeid";
$pagename = "truck_income.php";
$modulename = "Truck Income";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
}

if(isset($_GET['otherincomeid']))
{
	$otherincomeid = trim(addslashes($_GET['otherincomeid']));	
}
else
{
	$otherincomeid=0;	
}

		if(isset($_POST['submit']))
		{
			$tblpkey_value= trim(addslashes($_POST['otherincomeid']));
			$truckid = trim(addslashes($_POST['truckid']));
			$drivername = trim(addslashes($_POST['drivername']));
			$head_id = trim(addslashes($_POST['head_id']));
			$incomeamount = trim(addslashes($_POST['incomeamount']));
			$payment_type = trim(addslashes($_POST['payment_type']));
			$chequeno = trim(addslashes($_POST['chequeno']));
			$bankid = trim(addslashes($_POST['bankid']));
			$chequedate = $cmn->dateformatusa(trim(addslashes($_POST['chequedate'])));
			$paymentdate = $cmn->dateformatusa(trim(addslashes($_POST['paymentdate'])));
			$narration = trim(addslashes($_POST['narration']));
			
			if($truckid !='' && $head_id !='' && $incomeamount !='' && $paymentdate !='')
			{
			if($tblpkey_value==0)
			{
			
				mysqli_query($connection,"insert into otherincome set truckid='$truckid',drivername='$drivername',head_id='$head_id',incomeamount='$incomeamount',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate',paymentdate='$paymentdate',narration='$narration',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
				$action = 1;
			}
			else
			{
				mysqli_query($connection,"update otherincome set truckid='$truckid',drivername='$drivername',head_id='$head_id',incomeamount='$incomeamount',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate',paymentdate='$paymentdate',narration='$narration',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress'  where otherincomeid='$tblpkey_value'");
				$action = 2;
			}			
			echo "<script>location='$pagename?action=$action&truckid=$truckid'</script>";
			}
		}
		

if($otherincomeid !='0')
{
$sql = mysqli_query($connection,"select * from otherincome where otherincomeid='$otherincomeid'");
$row=mysqli_fetch_assoc($sql);
$tblpkey_value = $row['otherincomeid'];
$truckid = $row['truckid'];
$drivername = $row['drivername'];
$head_id = $row['head_id'];
$incomeamount = $row['incomeamount'];
$payment_type = $row['payment_type'];
$chequeno = $row['chequeno'];
$bankid = $row['bankid'];
$chequedate = $row['chequedate'];
$paymentdate = $row['paymentdate'];
$narration = $row['narration'];
}
else
{
	$head_id = '34';	
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
							<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr>
                                    <td width="40%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="truckid" name="truckid" class="formcent select2-me" style="width:224px;" onChange="window.location.href='?truckid='+this.value;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select A.truckid,truckno,A.ownerid from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid  
														 order by A.truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno'].' / '.$cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row_fdest[ownerid]'"); ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 <tr>
                                    <td width="40%"><strong>Driver Name</strong> <strong>:</strong></td>
                                    <td width="60%">
                            <input list="browsers" value="<?php echo $drivername; ?>" id="drivername" name="drivername" autocomplete="off" class="input-large" >
                                     
                                <datalist id="browsers">
                                <?php 
								$sql = mysqli_query($connection,"select drivername from bilty_entry where drivername !='' group by drivername");
								while($row=mysqli_fetch_assoc($sql))
								{
								?>
                                <option value="<?php echo $row['drivername']; ?>">
                               <?php 
								}
							   ?>
                                </datalist>


                                    </td>                                    
                                 </tr>
                                 
                                 
                                 <tr>
                                    <td width="40%"><strong>Head</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="head_id" name="head_id" class="formcent select2-me" style="width:224px;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select head_id,headname from other_income_expense where headtype='Truck' && headname not IN('RTO & INSURANCE','Spare Item','total tax','Hamali','Bhatta','Cash Expanses','Truck Maintanance')  order by headname");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['head_id']; ?>"><?php echo $row_fdest['headname']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('head_id').value = '<?php echo $head_id; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                 <tr>
                                    <td> <strong>Amount:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="incomeamount" value="<?php echo $incomeamount; ?>" id="incomeamount" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                                                                                  
                                  <tr>
                                    <td> <strong>Payment Type:</strong><span class="red">*</span></td>
                                    <td>
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="neft">NEFT</option>
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
                                    <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>  
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,incomeamount,payment_type');" >
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
				if($truckid !='')
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
                                            <th>Truck No</th> 
                                            <th>Driver Name</th> 
                                            <th>Head </th>
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th> 
                                            <th>Narration</th>  
                                            	  <th>Print Reciept</th>                                                                                    
                                        	<th class='hidden-480'>Action</th>                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$slno=1;
									$sql = "select * from otherincome where truckid='$truckid' $cond order by paymentdate desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										//$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                           
                                            <td><?php echo ucfirst($row['drivername']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td><?php echo ucfirst($row['incomeamount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                           <td><a href= "pdfreciept_otherincome.php?otherincomeid=<?php echo $row['otherincomeid'];?>" class="btn btn-success" target="_blank" >Print Reciept</a></td>
                                         
                                            <td class='hidden-480'>
                                            
                                           <a href= "?otherincomeid=<?php echo ucfirst($row['otherincomeid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <!--<a onClick="funDel('<?php //echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
                                           </td>
										</tr>
                                        <?php
										$tot_amt += $row['incomeamount'];		
										
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_amt,2); ?> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"></td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                    </tr>
										
										
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
			  location=pagename+'?action=10&truckid=<?php echo $truckid; ?>';
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
