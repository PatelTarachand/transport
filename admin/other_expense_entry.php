<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "other_expense_entry";
$tblpkey = "other_exp_id";
$pagename = "other_expense_entry.php";
$modulename = "Other Expenses Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['other_exp_id']))
{
	$other_exp_id = $_GET['other_exp_id'];	
}else{
$other_exp_id = '';
}	

if(isset($_GET['edit']))
{
	$other_exp_id=$_GET['edit'];
	$sql_edit="select * from other_expense_entry where other_exp_id='$other_exp_id'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
          
            $service_date = $row['service_date'];
            $truckid = $row['truckid'];
            $driver = $row['driver'];
            $headid = $row['headid'];
            $meachineid= $row['meachineid'];
            $payment_type = $row['payment_type'];
            $bill_type = $row['bill_type'];
            
            $amount = $row['amount'];
            $meater_reading = $row['meater_reading'];
            $narration = $row['narration'];
             $otherid = $row['otherid'];
			
		}//end while
	}//end if
}//end if
else
{
	$truckid ='';
	
	$service_date='';
	
	$driver='';
	$headid='';
	$meachineid='';
	$payment_type='';
	$payment_mode = '';
	$bill_type='';
    $meater_reading='';
    $amonut='';
    $narration='';
   $otherid='';
	
}





if(isset($_POST['submit']))
		{
			
			 
          
			$service_date = $_POST['service_date'];
			$truckid = trim(addslashes($_POST['truckid']));
			$driver = trim(addslashes($_POST['driver']));
			$headid = $_POST['headid'];
			$meachineid= $_POST['meachineid'];
            $payment_type = $_POST['payment_type'];
            
			$meater_reading = trim(addslashes($_POST['meater_reading']));
            $amount = trim(addslashes($_POST['amount']));
            $bill_type = trim(addslashes($_POST['bill_type']));
			$narration = trim(addslashes($_POST['narration']));
				$otherid = $_POST['otherid'];
			
		
			if($other_exp_id==0)
			{  

            //echo "insert into other_expense_entry set service_date='$service_date',truckid='$truckid',driver='$driver', bill_type='$bill_type',headid='$headid',meachineid='$meachineid',payment_type='$payment_type',meater_reading='$meater_reading',amount='$amount', narration='$narration',createdate='$createdate', sessionid='$sessionid'";die;
				mysqli_query($connection,"insert into other_expense_entry set service_date='$service_date',truckid='$truckid',driver='$driver', otherid='$otherid', bill_type='$bill_type',headid='$headid',meachineid='$meachineid',payment_type='$payment_type',meater_reading='$meater_reading',amount='$amount', narration='$narration',createdate='$createdate', sessionid='$sessionid'");

                $action = 1;
                echo "<script>location='$pagename?action=$action'</script>";
			}
			else
			{
                //echo "update mechine_service_master set service_date='$service_date',truck_no='$truck_no',driver_name='$driver_name',service_head='$service_head', mechine_service_name='$mechine_service_name',meater_reading='$meater_reading',narration='$narration',createdate='$createdate' where meachineid='$meachineid'";die;
				mysqli_query($connection,"update other_expense_entry set service_date='$service_date',truckid='$truckid',driver='$driver',otherid='$otherid',  headid='$headid',meachineid='$meachineid',payment_type='$payment_type', bill_type='$bill_type', meater_reading='$meater_reading',amount='$amount', narration='$narration',createdate='$createdate', sessionid='$sessionid' where other_exp_id='$other_exp_id'");
				$action = 2;
			}			
            echo "<script>location='$pagename?action=$action'</script>";
			}
		
	




?>



<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>

</script>


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



    $(document).ready(function(){
	$("#shortcut_headid").click(function(){
		$("#div_headname").toggle(1000);
	});
	});

   
	
	

  

</script>


<?php include("alerts/alert_js.php"); ?>




</head>

<body>
    
    
    
    <div class="messagepop pop" id="div_headname">
<img src="b_drop.png" class="close" onClick="$('#div_headname').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Head</strong></td></tr>
  <tr><td>&nbsp;Head Name: </td></tr>
  <tr><td><input type="text" name="headname" id="headname" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_officeheadname('headname');"/></td></tr>
</table>
</div>
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
                                <table class="table table-condensed" style="width:60%;margin-top: 20px;">
                                <tr>
                                    <td style="width:25%"><strong> Date</strong> <strong>:</strong></td>
                                    <td style="width:25%">
                                    <input type="date" name="service_date" value="<?php echo $service_date; ?>" id="service_date" autocomplete="off"  class="input-large">
                                    </td>   
                                    <td style="width:25%"><strong>Other Expense.</strong><span class="red">*</span><img src="add.png" id="shortcut_headid"><a href="#" id="add_new" data-form="div_headname" ></td>
                                    <td style="width:25%">
                                    <select name="otherid" id="otherid"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                               $sql = mysqli_query($connection,"select * from otherexp_master");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['otherid']; ?>"><?php echo $row['headname'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('otherid').value = '<?php echo $otherid ; ?>'; </script>
                                           
                                    </td>   
                                    
                                 </tr>
                                
                                 
                                 

                                 <tr>
                                     
                                       <td style="width:25%"><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td style="width:25%">
                                    <select name="truckid" id="truckid"  class="formcent select2-me" style="width:224px;" required>
                                                  <option value="">-Select-</option>
                                               <?php 
                                               $sql = mysqli_query($connection,"SELECT m_truck.truckid,m_truck.truckno FROM m_truck LEFT JOIN m_truckowner ON m_truck.ownerid = m_truckowner.ownerid where m_truckowner.owner_type='self'");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['truckid']; ?>"><?php echo $row['truckno'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('truckid').value = '<?php echo $truckid ; ?>'; </script>
                                           
                                    </td>   
                                     
                                     
                                    <td> <strong>Driver name:</strong><span class="red">*</span></td>
                                    <td>
                                      <select name="driver" id="empid"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                            //    echo "select * from m_employee where empname='1'";die;
                                               $sql = mysqli_query($connection,"select * from m_employee where designation='1'");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['empid']; ?>"><?php echo $row['empname'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('empid').value = '<?php echo $driver ; ?>'; </script>
                                    </td>
                                   

                                   </tr>
                                
                                  <!-- <tr> --> 
                                  <!-- <tr>
                                    <td width="40%"><strong>truck_no No.</strong> <strong>:</strong></td>
                                    <td width="60%">
                                    <input type="text" name="opening_bal" value="<?php echo $opening_bal; ?>" id="opening_bal" autocomplete="off"  class="input-large">
                                    </td>                                    
                                 </tr> -->
                                         <!-- <tr>
                                             
                                              <td><strong>Mechanic Name</strong><span class="red">*</span> </td>
                                           <td align="left">
                                           <select name="meachineid" id="meachineid" class="formcent select2-me" style="width:224px;" required >
                                           		<option value="">-Select-</option>
                                                <?php 
												$sql = mysqli_query($connection,"select * from mechine_service_master");
												while($row=mysqli_fetch_assoc($sql))
												{
												?>
                                               	<option value="<?php echo $row['meachineid']; ?>"><?php echo $row['mechanic_name']; ?></option>
                                               <?php 
												}
											   ?>
                                           </select>
                                           <script>document.getElementById('meachineid').value = '<?php echo $meachineid; ?>'; </script>
                                           
                                           </td>
                                             
                                        
                                         <td  align="left"><strong>Maintenance / Spare</strong><span class="red">*</span></td>
                                        
                                            <td align="left">
                                            <select id="headid" name="headid" class="select2-me input-large" style="width:220px;"  required >
			<option value="s"> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select headid,headname from head_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['headid']; ?>"><?php echo $row_fdest['headname']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('headid').value = '<?php echo $headid; ?>';</script>
                                            
                                            </td>
                                         
                                 
                                   


                                             
                                        </tr>  -->
                                        
                                         
                                  <tr>
                                      
                                         <td><strong>Amonut</strong></td>
                                    <td><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>"  autocomplete="off" class="input-large" data-date="true" required></td>
                                      

                                  <td> <strong>Pay Mode:</strong></td>
                                    <td>
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="neft">UPI</option>
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>
                                    </td>



                                   
                                  </tr>
                               


                                   

                                  <tr>
                                  
                                   <td><strong>Billing Type</strong></td>
                                    <td>
                                    <select name="bill_type" id="bill_type" class="formcent select2-me" style="width:224px;" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CREDIT</option>
                                              
                                           </select>
                                           <script>document.getElementById('bill_type').value = '<?php echo $bill_type ; ?>'; </script></td>
                                  
                                  
                                  
                                  
                                           <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                  
                                  
                                  
                                  
                                        </tr>
                                  
                                   
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,incomeamount,payment_type');" >
                    <input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="other_exp_id" id="<?php echo $other_exp_id; ?>" value="<?php echo $other_exp_id; ?>" > 
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
                                            <th> Date</th> 
                                          
                                            <th>Truck No.</th> 
                                              <th>Office Expense</th> 
                                        
                                          
                                            <th>Amonut</th> 
                                            <th>Driver name </th>
                                        	<th>Pay Mode</th>                                            
                                            <!--<th>Meater Reading</th> -->
                                            <th>Billing Type</th> 
                                            <th>Narration</th>  
                                            <th>Action</th>                                                         
                                        	                                     
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									
									$slno=1;
                                   
									$sql = "select * from other_expense_entry order by other_exp_id  desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$office_headname = $cmn->getvalfield($connection,"otherexp_master","headname","otherid='$row[otherid]'"); 
                                        $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
									
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 

										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo dateformatindia($row['service_date']);?></td>   
                                              <td><?php echo ucfirst($truckno);?></td>
                                                <td><?php echo ucfirst($office_headname);?></td>             
                                               
                                                                    
                                          
                                         
                                            <td><?php echo $row['amount'];?></td>
                                           
                                            <td><?php echo ucfirst($driver);?></td> 
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                            <!--<td><?php echo ucfirst($row['meater_reading']);?></td> -->
                                             <td><?php echo $row['bill_type'];?></td>
                                          
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                      
                                         
                                            <td class='hidden-480'>
                                            
                                           <a href= "?edit=<?php echo ucfirst($row['other_exp_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['other_exp_id']; ?>')"  style="display:"><img src="../img/del.png" title="Delete" ></a>
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
			  location=pagename+'?action=10&other_exp_id=<?php echo $other_exp_id; ?>';
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


function ajax_save_officeheadname(headname)
{
    
	var headname = document.getElementById(headname).value;
    
 
	if(headname == "")
	{
      
		alert('Fill form properly');
		document.getElementById(headname).focus();
		return false;
	}

   
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("otherid").innerHTML = xmlhttp.responseText;
			
				document.getElementById("headname").value = "";
			
              
				$("#div_headname").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_save_shortcut_officehead.php?headname="+headname,true);
   xmlhttp.send();
	
}

set_payment("<?php echo $payment_type; ?>");

</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
