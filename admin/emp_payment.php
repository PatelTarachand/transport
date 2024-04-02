<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "emp_payment";
$tblpkey = "emppayment_id";
$pagename = "emp_payment.php";
$modulename = "Employee Payment";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['emppayment_id']))
{
	echo $emppayment_id = $_GET['emppayment_id'];
}else{
$emppayment_id = '';
}	

if(isset($_GET['edit']))
{
	$emppayment_id=$_GET['edit'];
	$sql_edit="select * from emp_payment where emppayment_id='$emppayment_id'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
          
            $pay_date = $row['pay_date'];
            $empid = $row['empid'];
            $inc_ex_id = $row['inc_ex_id'];
            $amount = $row['amount'];
            $payment_type = $row['payment_type'];
            $narration = $row['narration'];
            	$account_no = $row['account_no'];
            $ifsc_code = $row['ifsc_code'];
              $upi_id = $row['upi_id'];
			$emp_month =$row['emp_month'];
        
			
		}//end while
	}//end if
}//end if
else
{
	
	$pay_date='';
	$empid='';
	$inc_ex_id='';
	$amount='';
	$payment_type='';
	$narration='';
    	$account_no='';
	$ifsc_code='';
	$emp_month='';
	 $upi_id='';
}





if(isset($_POST['submit']))
		{
		 	$emppayment_id = $_POST['emppayment_id'];
			$pay_date = $_POST['pay_date'];
			$empid = trim(addslashes($_POST['empid']));
			$inc_ex_id = trim(addslashes($_POST['inc_ex_id']));
			$amount = $_POST['amount'];
            $payment_type = $_POST['payment_type'];
			$narration = trim(addslashes($_POST['narration']));
					$account_no = $_POST['account_no'];
            $ifsc_code = $_POST['ifsc_code'];
			$emp_month =$_POST['emp_month'];
			$upi_id =$_POST['$upi_id'];
		
			if($emppayment_id==0)
			{  

       // echo "insert into emp_payment set emppayment_id='$emppayment_id', pay_date='$pay_date',empid='$empid',inc_ex_id='$inc_ex_id', amount='$amount',payment_type='$payment_type',narration='$narration', sessionid='$sessionid'";die; 
				mysqli_query($connection,"insert into emp_payment set emppayment_id='$emppayment_id', pay_date='$pay_date',   upi_id='$upi_id', empid='$empid',inc_ex_id='$inc_ex_id', amount='$amount',payment_type='$payment_type',narration='$narration',account_no='$account_no',ifsc_code='$ifsc_code',emp_month='$emp_month', sessionid='$sessionid'");

                $action = 1;
                echo "<script>location='$pagename?action=$action'</script>";
			}
			else
			{
                //echo "update mechine_service_master set pay_date='$pay_date',truck_no='$truck_no',driver_name='$driver_name',service_head='$service_head', mechine_service_name='$mechine_service_name',meater_reading='$meater_reading',narration='$narration',createdate='$createdate' where meachineid='$meachineid'";die;
				mysqli_query($connection,"update emp_payment set pay_date='$pay_date',empid='$empid',inc_ex_id='$inc_ex_id', upi_id='$upi_id', amount='$amount',payment_type='$payment_type',narration='$narration',account_no='$account_no',ifsc_code='$ifsc_code',emp_month='$emp_month', sessionid='$sessionid' where emppayment_id='$emppayment_id'");
				$action = 2;
			}			
            echo "<script>location='$pagename?action=$action'</script>";
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
                            
                            <div class="span10" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="margin-top:20px;width: 60%;">
                                <tr>
                                    <td style="width:25%"><strong>Payment Date</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td style="width:25%">
                                    <input type="date" name="pay_date" value="<?php echo $pay_date; ?>" id="pay_date" autocomplete="off"  class="input-large">
                                    </td>   
                                    <td style="width:25%"><strong>Employee Name</strong> <strong>:</strong></td>
                                    <td style="width:25%">
                                    <select name="empid" id="empid"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                               $sql = mysqli_query($connection,"select * from m_employee");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
												if($row['designation']==1)
										{
											$designation = "Driver";
										}
										else
										{
											if($row['designation']==2)
											{
												$designation = "Conductor";
											}
												else
												{
													if($row['designation']==3)
													{
														$designation = "Office Staff";
													}
												}
										}
                                               ?>
                                                  <option value="<?php echo $row['empid']; ?>"><?php echo $row['empname'] ?>/<?php echo $designation; ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('empid').value = '<?php echo $empid ; ?>'; </script>
                                           
                                    </td>   
                                    
                                 </tr>
                                
                                 
                                 

                                 <tr>
                                    <td> <strong>Expense Head:</strong><span class="red">*</span></td>
                                    <td>
                                    <select name="inc_ex_id" id="inc_ex_id"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                            //    echo "select * from m_employee where designation='1'";die;
                                               $sql = mysqli_query($connection,"select * from inc_ex_head_master");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['inc_ex_id']; ?>"><?php echo $row['incex_head_name'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('inc_ex_id').value = '<?php echo $inc_ex_id ; ?>'; </script>
                                    </td>
                                    <td><strong>Amonut</strong></td>
                                    <td><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>"  autocomplete="off" class="input-large" data-date="true" ></td>

                                   </tr>
                                
                                  <!-- <tr> --> 
                                  <!-- <tr>
                                    <td width="40%"><strong>truck_no No.</strong> <strong>:</strong></td>
                                    <td width="60%">
                                    <input type="text" name="opening_bal" value="<?php echo $opening_bal; ?>" id="opening_bal" autocomplete="off"  class="input-large">
                                    </td>                                    
                                 </tr> -->
                                       
                                        
                                         
                                  
                                  <tr>
                                
                                 
                                    <td> <strong>Pay Mode:</strong><span class="red">*</span></td>
                                    <td>
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="neft">UPI</option>
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>
                                    </td>
                                
                                    <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                  
                                
                                </tr>
                                
                                
                                
                                  <tr>
                                
                                 
                                    <td> <strong>Account No:</td>
                                    <td>
       	<input type="text" name="account_no" value="<?php echo $account_no; ?>" id="account_no" autocomplete="off"  class="input-large">
                                    </td>
                                
                                    <td> <strong>IFSC Code :</strong></td>
                                    <td>
                    				<input type="text" name="ifsc_code" value="<?php echo $ifsc_code; ?>" id="ifsc_code" autocomplete="off" maxlength="20"  class="input-large">
                                    </td>
                                  
                                
                                </tr>
  <tr>
                                
                                 
                                 
                                
                                    <td> <strong>Month:</strong></td>
                                    <td>
                    				<input type="month" name="emp_month" value="<?php echo $emp_month; ?>" id="emp_month" autocomplete="off"  class="input-large">
                                    </td>
                                    
                                      <td> <strong>UPI Id:</strong></td>
                                    <td>
                    				<input type="text" name="upi_id" value="<?php echo $upi_id; ?>" id="upi_id" autocomplete="off"  class="input-large">
                                    </td>
                                  
                                
                                </tr>

                                   

                                  
                                   
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('empid,head_id,incomeamount,payment_type');" >
                    <input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="emppayment_id" id="emppayment_id" value="<?php echo $emppayment_id; ?>" > 
					
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
                <div class="row-fluid" id="list" style="display:none;" >
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
                                            <th>Payment Date</th> 
                                            <th>Employee Name</th> 
                                            <th>Expense Head</th> 
                                          
                                            <th>Amonut</th> 
                                          
                                        	<th>Pay Mode</th>                                            
                                        
                                            <th>Narration</th>  
                                             <th>Account No.</th> 
                                          
                                        	<th>IFSC Code</th>                                            
                                        
                                            <th>Month</th>  
                                            <th>Action</th>                                                         
                                        	                                     
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									
									$slno=1;
                                   
									$sql = "select * from emp_payment order by emppayment_id desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","empid='$row[empid]'");
										$incex_head_name = $cmn->getvalfield($connection,"inc_ex_head_master","incex_head_name","inc_ex_id='$row[inc_ex_id]'"); 
                                        $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
									
										$empname = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' "); 

										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo dateformatindia($row['pay_date']);?></td>   
                                            <td><?php echo ucfirst($empname);?></td>                                        
                                            <td><?php echo ucfirst($incex_head_name);?></td>
                                            <td><?php echo ucfirst($row['amount']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                         
                                           
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                          <td><?php echo ucfirst($row['account_no']);?></td>
                                            <td><?php echo ucfirst($row['ifsc_code']);?></td> 
                                         
                                           
                                             <td><?php echo ucfirst($row['emp_month']);?></td> 
                                         
                                            <td class='hidden-480'>
                                            
                                           <a href= "?edit=<?php echo $row['emppayment_id'];?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['emppayment_id']; ?>')"  style="display:"><img src="../img/del.png" title="Delete" ></a>
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
			 //alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10&service_id=<?php echo $service_id; ?>';
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
