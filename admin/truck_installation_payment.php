<?php error_reporting(0);
include("dbconnect.php");
$tblname = "truck_installation_payment";
$tblpkey = "t_install_pay_id";
$pagename = "truck_installation_payment.php";
$modulename = "Truck Installment Payment";


if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$t_install_pay_id = $_GET['edit'];	
}
else
{
	$t_install_pay_id=0;	
}

if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");	
	$paid_amt = $cmn->getvalfield($connection,"truck_installation_payment","paid_amt","truckid='$truckid' order by t_install_pay_id desc limit 1");
}

if(isset($_POST['submit']))
{
			$t_install_pay_id= trim(addslashes($_POST["t_install_pay_id"]));
			$truckid= trim(addslashes($_POST["truckid"]));
			$head_id=trim(addslashes($_POST["head_id"]));
			$paid_amt=trim(addslashes($_POST["paid_amt"]));				
			$payment_type= trim(addslashes($_POST["payment_type"]));
			$bankid=trim(addslashes($_POST["bankid"]));
			$ref_no=trim(addslashes($_POST["ref_no"]));				
			$ref_date= $cmn->dateformatusa(trim(addslashes($_POST["ref_date"])));
			$remark=trim(addslashes($_POST["remark"]));
			$payment_date=$cmn->dateformatusa(trim(addslashes($_POST["payment_date"])));
	
	if($t_install_pay_id==0)
	{
		
	mysqli_query($connection,"insert into truck_installation_payment set truckid='$truckid',head_id='$head_id',paid_amt='$paid_amt',payment_type='$payment_type',bankid='$bankid',
				ref_no='$ref_no',ref_date='$ref_date',remark='$remark',payment_date='$payment_date',ipaddress='$ipaddress',createdate='$createdate',createdby='$userid',
				sessionid='$sessionid'");
	$t_install_pay_id = mysqli_insert_id($connection);
	}
	else
	{
		mysqli_query($connection,"update truck_installation_payment set truckid='$truckid',head_id='$head_id',paid_amt='$paid_amt',payment_type='$payment_type',bankid='$bankid',
					ref_no='$ref_no',ref_date='$ref_date',remark='$remark',payment_date='$payment_date',createdby='$userid',ipaddress='$ipaddress',
			lastupdate='$createdate' where t_install_pay_id='$t_install_pay_id'");
	}
		
			echo "<script>location = '$pagename?truckid=$truckid';</script>";	
}


if($t_install_pay_id !='')
{
	$sql = mysqli_query($connection,"select * from truck_installation_payment where t_install_pay_id='$t_install_pay_id'");
	$row=mysqli_fetch_assoc($sql);
	$truckid = $row['truckid'];
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	
			$head_id=$row['head_id'];
			$paid_amt=$row['paid_amt'];			
			$payment_type=$row['payment_type'];
			$bankid=$row['bankid'];
			$ref_no=$row['ref_no'];		
			$ref_date=$row['ref_date'];
			$remark=$row['remark'];
			$payment_date=$row['payment_date'];
}
else
{
	$head_id = 6;
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>


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
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
	
	});
	</script>
</head>

<body>
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
            <?php //include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
							<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            <div class="box-content">
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table>
                                    <tr>
                                        
                                        <td><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        <td><strong> Owner Name</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        <td><strong> Payment Head Name</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        <td><strong>Paid Amount</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        
                                    </tr>
                              		<tr>                                   
                                     <td width="13%"><select name="truckid"  class="input-large select2-me"  id="truckid" onChange="window.location.href='?truckid='+this.value" >
                                        <option value="">-Select-</option>
                                        <?php
													$sql_cat = mysqli_query($connection,"Select A.truckid,A.truckno from  m_truck as A left join  m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by A.truckid desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['truckid']; ?>" > <?php echo $res_cat['truckno']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>
                                      <script> document.getElementById('truckid').value='<?php echo $truckid; ?>'; </script>
                                     </td>
                                      <td width="13%">
                                    <input type="text"  id="ownername" value="<?php echo $ownername; ?>" autocomplete="off"   class="input-large" readonly style="background-color:#CFF;"  >
                                     </td>
                                     
                                     <td width="13%">
                                     
                                     <select name="head_id"  class="input-large select2-me"  id="head_id"  >
                                        <option value="">-Select-</option>
                                        <?php
					$sql_cat = mysqli_query($connection,"Select head_id,headname from  other_income_expense where headtype='Truck' && head_id=6 order by headname desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['head_id']; ?>" > <?php echo $res_cat['headname']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>
                                      
                                      <script> document.getElementById('head_id').value='<?php echo $head_id; ?>'; </script>                                        
									  
                                     </td>
                                     
                                     <td width="13%">
                                    <input type="text" name="paid_amt" id="paid_amt" value="<?php echo $paid_amt; ?>" autocomplete="off"   class="input-large"  >
                                     </td>
                                                                                                         
                                 </tr>
                                 
                                   <tr>
                                        
                                        <td><strong>Payment Type </strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        <td><strong> Bank Name</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        <td><strong> Cheque/NEFT No</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        <td><strong>Date</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        
                                    </tr>
                              		<tr>
                                   
                                     <td width="13%"><select name="payment_type"  class="input-large select2-me"  id="payment_type" onChange="settype();" >
                                        <option value="">-Select-</option>
                                      	<option value="Cash">Cash</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Cheque">Cheque</option>		
                                      </select>                                        
									 <script> document.getElementById('payment_type').value='<?php echo $payment_type; ?>'; </script>              
                                     </td>  
                                     <td width="13%"><select name="bankid"  class="input-large"  id="bankid" <?php if($payment_type=="Cash") { ?> style="background-color:#CFF" <?php } ?> >
                                        <option value="">-Select-</option>
                                        <?php
													$sql_cat = mysqli_query($connection,"Select bankid,bankname,helpline from  m_bank order by bankname");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['bankid']; ?>" > <?php echo $res_cat['bankname'].' / '.$res_cat['helpline']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>                                        
									<script> document.getElementById('bankid').value='<?php echo $bankid; ?>'; </script>   
                                     </td>
                                     
                                     <td width="13%">
                                    <input type="text" name="ref_no" id="ref_no" value="<?php echo $ref_no; ?>" autocomplete="off" class="input-large" <?php if($payment_type=="Cash") { ?> style="background-color:#CFF" <?php } ?> >
                                     </td>
                                     <td width="13%">
                                    <input type="text" name="ref_date" id="ref_date" value="<?php echo $cmn->dateformatindia($ref_date); ?>" autocomplete="off"  class="input-large maskdate" placeholder="dd-mm-yyyy" <?php if($payment_type=="Cash") { ?> style="background-color:#CFF" <?php } ?> >
                                     </td>
                                                                                                         
                                 </tr>
                                 
                                <tr>
                                        
                                        <td><strong> Narration</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        <td><strong> Payment Date</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                        
                                        
                                    </tr>
                              		<tr>
                                   
                                     <td width="13%">
                                    <input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" autocomplete="off"  class="input-large"  >
                                     </td>  
                                     <td width="13%">
                                    <input type="text" name="payment_date" id="payment_date" value="<?php echo $cmn->dateformatindia($payment_date); ?>" autocomplete="off" class="input-large maskdate"  placeholder="dd-mm-yyyy" >
                                     </td>
                                   
                                                                                                         
                                 </tr>  
                                 
                                 <tr>
                                 			<td colspan="4"> <center>
                                            <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"  onClick="return checkinputmaster('truckid,head_id,paid_amt,payment_type,payment_date');" > &nbsp; &nbsp; <a href="<?php echo $pagename; ?>" class="btn btn-danger"> Reset </a>
                                            <input type="hidden" name="t_install_pay_id" value="<?php echo $t_install_pay_id; ?>" >
                                             </center></td>
                                 </tr>
                                 
                                
                                </table>                               
                                </div>
                                </form>
                                
							</div>
							
						</div>
					</div>
				</div>
                
                <div class="row-fluid">
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
                                            <th>Owner Name</th>
                                            <th>Payment Head Name</th>
                                           	<th>Paid Amount</th>
                                            <th>Payment Date</th>
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
									
									$sel = "select * from truck_installation_payment where truckid='$truckid' $cond";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'");
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno; ?></td>
                                            <td><?php echo $ownername;?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'"); ?></td>
                                            <td><?php echo $row['paid_amt'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['payment_date']); ?></td>
                                            <td class='hidden-480'>
                                            <a href= "?edit=<?php echo ucfirst($row['t_install_pay_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a onClick="funDel('<?php echo $row['t_install_pay_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		</div>
        
        
    </div>
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
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=<?php echo "'$pagename?truckid=$truckid'"; ?>;
			}
		
		  });//ajax close
	}//confirm close
} //fun close

//below code for date mask
jQuery(function($){
   $(".maskdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});


function settype()
{
	var payment_type = document.getElementById('payment_type').value;
	if(payment_type=='Cash')
	{
		document.getElementById('bankid').value='';	
		document.getElementById('ref_no').value='';	
		document.getElementById('ref_date').value='';	
		
		document.getElementById('bankid').disabled=true;
		document.getElementById('ref_no').disabled=true;
		document.getElementById('ref_date').disabled=true;
		
		document.getElementById('bankid').style.backgroundColor="#CFF";
		document.getElementById('ref_no').style.backgroundColor="#CFF";
		document.getElementById('ref_date').style.backgroundColor="#CFF";
	}
	else
	{
		document.getElementById('bankid').disabled=false;
		document.getElementById('ref_no').disabled=false;
		document.getElementById('ref_date').disabled=false;
		
		document.getElementById('bankid').style.backgroundColor  ="#fff";
		document.getElementById('ref_no').style.backgroundColor="#fff";
		document.getElementById('ref_date').style.backgroundColor="#fff";
	}
}



</script>

</html>

<?php
mysqli_close($connection);
?>