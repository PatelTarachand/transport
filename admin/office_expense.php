<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$tblname = "other_expense";
$tblpkey = "otherexpenseid";
$pagename = "office_expense.php";
$modulename = "Office Expense";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['otherexpenseid']))
{
	$otherexpenseid = trim(addslashes($_GET['otherexpenseid']));	
}
else
{
	$otherexpenseid=0;	
}

		if(isset($_POST['submit']))
		{
			$tblpkey_value= trim(addslashes($_POST['otherexpenseid']));
			$stype = trim(addslashes($_POST['stype']));
			$payeename = trim(addslashes($_POST['payeename']));
			$head_id = trim(addslashes($_POST['head_id']));
			$expamount = trim(addslashes($_POST['expamount']));
			$payment_type = trim(addslashes($_POST['payment_type']));
			$chequeno = trim(addslashes($_POST['chequeno']));
			$bankid = trim(addslashes($_POST['bankid']));
			$chequedate = $cmn->dateformatusa(trim(addslashes($_POST['chequedate'])));
			$paymentdate = $cmn->dateformatusa(trim(addslashes($_POST['paymentdate'])));
			$narration = trim(addslashes($_POST['narration']));
			
			if($stype !='' && $head_id !='' && $expamount !='' && $paymentdate !='')
			{
			if($tblpkey_value==0)
			{	
			//echo "insert into other_expense set stype='$stype',payeename='$payeename',head_id='$head_id',expamount='$expamount',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate',paymentdate='$paymentdate',narration='$narration',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'"; die;			
				mysqli_query($connection,"insert into other_expense set stype='$stype',payeename='$payeename',head_id='$head_id',expamount='$expamount',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate',paymentdate='$paymentdate',narration='$narration',createdby='$userid',compid = '$compid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
				$action = 1;
			}
			else
			{
				mysqli_query($connection,"update other_expense set stype='$stype',payeename='$payeename',head_id='$head_id',expamount='$expamount',payment_type='$payment_type',compid = '$compid',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate',paymentdate='$paymentdate',narration='$narration',createdate='$createdate',ipaddress='$ipaddress'  where otherexpenseid='$tblpkey_value'");
				$action = 2;
			}			
			echo "<script>location='$pagename?action=$action';</script>";
			}
		}
		

if($otherexpenseid !='0')
{
$sql = mysqli_query($connection,"select * from other_expense where otherexpenseid='$otherexpenseid'");
$row=mysqli_fetch_assoc($sql);
$tblpkey_value = $row['otherexpenseid'];
$stype = $row['stype'];
$payeename = $row['payeename'];
$head_id = $row['head_id'];
$expamount = $row['expamount'];
$payment_type = $row['payment_type'];
$chequeno = $row['chequeno'];
$bankid = $row['bankid'];
$chequedate = $row['chequedate'];
$paymentdate = $row['paymentdate'];
$narration = $row['narration'];
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
							<!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="margin-top:20px;">
                                <tr>
                                    <td width="40%"><strong>Select Type</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="stype" name="stype" class="formcent select2-me" style="width:224px;" onChange="getoption();" >
                                	<option value=""> -Select- </option>  
                                    <option value="company owner">Company Owner</option>                            
                                    <option value="Employee">Employee</option>
                               		<option value="Owner">Truck Owner</option>
                                    <option value="Driver">Driver</option>
                                    <option value="Other">Other</option>
                                </select>
                                <script>document.getElementById('stype').value = '<?php echo $stype; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 <tr>
                                    <td width="40%"><strong>Payee Name</strong> <strong>:</strong></td>
                                    <td width="60%">
                            <input list="browsers" value="<?php echo $payeename; ?>" id="payeename" name="payeename" autocomplete="off" class="formcent input-large" >
                                     
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
                            <select id="head_id" name="head_id" class="formcent select2-me" style="width:224px;" onChange="hidedate(this.value);" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select head_id,headname from other_income_expense  order by headname");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                    //where headtype='Truck'
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
                    				<input type="text" name="expamount" value="<?php echo $expamount; ?>" id="expamount" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                                                                                 
                                 		 <tr>
                                    <td>
                                    <div id="mmm"> 
                                     <strong>Payment Type:</strong><span class="red">*</span>
                                     </div>
                                     </td>
                                    <td>
                                    <div id="nnn"> 
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="neft">NEFT</option>
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>
                                         </div>      
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
                                  <td><strong>Expense Date:</strong></td>
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
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,expamount');" >
                    <input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
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
                                            <th>Type</th> 
                                            <th>Payee Name</th> 
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
									$cond=" where 1=1 && sessionid='$sessionid' ";
									}
									else
									{
									$cond=" where 1=1 && sessionid='$sessionid'";	
									}
									
									$slno=1;
									 $sel = "select * from other_expense  $cond and compid='$compid' order by paymentdate desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{																			
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['stype']);?></td>                                          
                                            <td><?php echo ucfirst($row['payeename']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td><?php echo ucfirst($row['expamount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['paymentdate']);?></td>
                                             <td><?php echo ucfirst($row['narration']);?></td>
                                               <td><a href= "pdfreciept_other_expenses.php?otherexpenseid=<?php echo $row['otherexpenseid'];?>" class="btn btn-success" target="_blank" >Print Reciept</a></td>
                                            <td class='hidden-480'>
                                           <a href= "?otherexpenseid=<?php echo ucfirst($row['otherexpenseid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <!--<a onClick="funDel('<?php //echo $row['otherexpenseid']; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
                                           </td>
										</tr>
                                        <?php
										$tot_amt += $row['expamount'];		
										
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
						
			</div>
		</div></div>
<script>
function funDel(id)
{    
	//  alert(id);   
		tblname = '<?php echo $tblname; ?>';
		tblpkey = '<?php echo $tblpkey; ?>';
		pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	 // alert(tblname); 
	 // alert(tblpkey); 
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


function getoption()
{
	var stype = document.getElementById('stype').value;
	
	if(stype=="company owner")
	{
			document.getElementById('payeename').value="Owner";
			$('#browsers').html('');
	}
	else
	{
		$.ajax({
		  type: 'POST',
		  url: 'getoption.php',
		  data: 'stype=' + stype,
		  dataType: 'html',
		  success: function(data){
					$('#browsers').html(data);
			}
		
		  });//ajax close	
	}
	
	}


function set_payment(payment_type)
{
	if(payment_type != "")
	{
		if(payment_type == 'cash')
		{
			
			
			$("#cheque_td").hide();
			$("#bank_td").hide();
			$("#chequed_td").hide();
			
		
		}
		else if(payment_type=='cheque' || payment_type=='neft' )
		{
			
			
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
