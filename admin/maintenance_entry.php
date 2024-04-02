<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "maintenance_entry";
$tblpkey = "main_id";
$pagename = "maintenance_entry.php";
$modulename = "Master Maintenance Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from maintenance_entry where main_id='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			 $truckid1 = $row['truckid'];
			$driver = $row['driver'];
			$maint_date = $row['maint_date'];
			$headid = $row['headid'];
			$meachineid = $row['meachineid'];
			$amount = $row['amount'];
			$payment_type = $row['payment_type'];
			$payment_mode = $row['payment_mode'];
				$remark = $row['remark'];
			
		}//end while
	}//end if
}//end if
else
{
	$main_id = 0;
	
	$driver='';
	
	$headid='';
	$mid='';
	$amount='';
	$payment_type='';
	$payment_mode = '';
	$remark='';
	
}

$duplicate= "";
if(isset($_POST['submit']))
{	
	$main_id = $_POST['main_id'];
	$truckid = $_POST['truckid'];
	$driver = $_POST['driver'];
	$maint_date = $_POST['maint_date'];
	$headid = $_POST['headid'];
	$meachineid = $_POST['meachineid'];
	$amount = $_POST['amount'];
	$payment_type = $_POST['payment_type'];
	$payment_mode = $_POST['payment_mode'];
	$remark = $_POST['remark'];

	
	if($main_id==0)
	{
		
		//check doctor existance
	
		$sql_chk = "select * from maintenance_entry where truckid='$truckid' &&  driver='$driver' &&  maint_date='$maint_date' &&  amount='$amount'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
	
		if($cnt == 0)
		{
			

//  echo "insert into maintenance_entry set truckid = '$truckid', empid = '$driver',  meachineid ='$meachineid', remark = '$remark',maint_date = '$date', headid = '$headid',
//  amount='$amount', payment_type='$payment_type',payment_mode='$payment_mode',sessionid='$sessionid'";die;

			  $sql_insert="insert into maintenance_entry set truckid = '$truckid', empid = '$driver',  meachineid ='$meachineid', remark = '$remark',maint_date = '$maint_date', headid = '$headid',
			 amount='$amount', payment_type='$payment_type',payment_mode='$payment_mode',sessionid='$sessionid'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);

			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		     echo "<script>location='maintenance_entry.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
		
	}
	else
	{
		
		
	// 	echo "update  m_company set cname = '$cname', headname ='$headname',headaddress = '$headaddress', phoneno = '$phoneno',saaccode='$saaccode',
	// 	mobileno1='$mobileno1', ownername='$ownername', faxno='$faxno',pan_card='$pan_card',c_logo='$doc_name',gst_no='$gst_no',stateid ='$stateid',venderCode='$venderCode',
	//    mobileno2='$mobileno2',gstvalid='$gstvalid', caddress='$caddress',chl_prefix='$chl_prefix' ,lastupdated=now() where compid='$compid'";die;
		
		$keyvalue = $main_id;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		

		$sql_update = "update maintenance_entry set truckid = '$truckid', empid = '$driver',  meachineid ='$meachineid',remark = '$remark',maint_date = '$maint_date', headid = '$headid',
		 amount='$amount', payment_type='$payment_type',payment_mode='$payment_mode' where main_id='$main_id'";
		mysqli_query($connection,$sql_update);
	
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		echo "<script>location='maintenance_entry.php?action=2'</script>";
	}
	
	$driver='';
	$maint_date=date('d-m-Y');
	$headid='';
	$mid='';
	$amount='';
	$payment_type='';
	$payment_mode = '';
}
?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
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
	$("#shortcut_empid").click(function(){
		$("#div_empname").toggle(1000);
	});
	});


    $(document).ready(function(){
	$("#shortcut_headid").click(function(){
		$("#div_headname").toggle(1000);
	});
	});

    $(document).ready(function(){
	$("#shortcut_meachineid").click(function(){
		$("#div_mechanicname").toggle(1000);
	});
	});
	
	
	

  

</script>

<?php include("alerts/alert_js.php"); ?>


</head>

<body onLoad="hideval();">

<div class="messagepop pop" id="div_empname">
<img src="b_drop.png" class="close" onClick="$('#div_empname').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Driver </strong></td></tr>
  <tr><td>&nbsp;<b>Driver name:</b> </td></tr>
  <tr><td><input type="text" name="empname" id="empname" style="width:190px;"/></td></tr>
  <tr><td>&nbsp;<b>Mobile No.</b> </td></tr>
  <tr><td><input type="text" name="mob1" id="mob1" maxlength="10" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_driver('empname','mob1');"/></td></tr>
</table>
</div>
<div class="messagepop pop" id="div_headname">
<img src="b_drop.png" class="close" onClick="$('#div_headname').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Head</strong></td></tr>
  <tr><td>&nbsp;Head Name: </td></tr>
  <tr><td><input type="text" name="headname" id="headname" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_headname('headname');"/></td></tr>
</table>
</div>
<div class="messagepop pop" id="div_mechanicname">
<img src="b_drop.png" class="close" onClick="$('#div_mechanicname').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New </strong></td></tr>
  <tr><td>&nbsp;Mechanic/Service Name: </td></tr>
  <tr><td><input type="text" name="mechanic_name" id="mechanic_name" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
  <tr><td>&nbsp;Mobile No. </td></tr>
  <tr><td><input type="text" name="mobile" id="mobile" maxlength="10" style="width:190px;"/></td></tr>
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_mechanicname('mechanic_name','mobile');"/></td></tr>
</table>
</div>






		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i>Master Maintenance Entry</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed" style="width:60%;">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                 <td width="11%"> <strong>Truck No.	</strong></td>
                                      <td>
									  <select id="truckid1" name="truckid" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" required >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"SELECT m_truck.truckid,m_truck.truckno FROM m_truck LEFT JOIN m_truckowner ON m_truck.ownerid = m_truckowner.ownerid where m_truckowner.owner_type='self'");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('truckid1').value = '<?php echo $truckid1; ?>';</script>
			
                                    </td>


                                    <td><strong>Driver Name</strong> <strong>:</strong><span class="red">*</span><img src="add.png" id="shortcut_empid"><a href="#" id="add_new" data-form="div_empname" ></td>

                                    <td> <select name="driver" id="empid"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                            //    echo "select * from m_employee where designation='1'";die;
                                               $sql = mysqli_query($connection,"select * from m_employee where designation='1'");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['empid']; ?>"><?php echo $row['empname'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('empid').value = '<?php echo $driver ; ?>'; </script></td>

                                    
                                 </tr>
                                
                                  <tr>
                                    <td> <strong>Date</strong></td>
                                    <td>
                    				<input type="date" name="maint_date" value="<?php echo $maint_date; ?>" id="maint_date" 
                                      class="input-large" >
                                    </td>

                                    <td><strong>Mechanic Name:</strong><img src="add.png" id="shortcut_meachineid"><span class="red">*</span><a href="#" id="add_new" data-form="div_mechanicname" ></td>
                                    <td>
									<select name="meachineid" id="meachineid" class="formcent select2-me" style="width:224px;" >
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
                                   </tr> 
                                  
                                  <tr>
                                  	
                                    <td style="width:19%;"><strong> Maintenance / Spare:</strong><img src="add.png" id="shortcut_headid"><span class="red">*</span><a href="#" id="add_new" data-form="div_headname" ></td>
                                    <td>	  <select id="headid" name="headid" class="select2-me input-large" style="width:220px;"  required >
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


                                    <td><strong>Amount:</strong></td>
                                    <td><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>" autocomplete="off" maxlength="120" class="input-large" ></td>
                                  </tr>
                                  
                                   <tr>
                                    <td><strong>Payment type:</strong></td>
                                    <td>
									<select id="payment_type" name="payment_type" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                       
                        <option value="Cash">Cash</option>
                         <option value="Credit">Credit</option>
                      
                    </select>
                    <script>document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';</script>  
                                                    
                                    </td>
                                    <td><strong>Payment Mode:</strong></td>
                                    <td>
									<select id="payment_mode" name="payment_mode" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                       
                        <option value="Cash">Cash</option>
                         <option value="UPI">UPI</option>
						 <option value="Check">Check</option>
                      
                    </select>
                    <script>document.getElementById('payment_mode').value = '<?php echo $payment_mode; ?>';</script> 
                                                    
                                    </td>
                                  </tr>
                               
                                  <tr>
                                      
                                       <td><strong>Remark</strong> <strong>:</strong><span class="red">*</span></td>

                                    <td width="37%"><input type="text" name="remark" id="remark" value="<?php echo $remark; ?>"
                                     autocomplete="off"  class="input-large" ></td>

                                  </tr> 
                            			
            
                       

                                 <tr>
                                    <td colspan="3">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('cname')" style="margin-left:340px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									<?php
                                   }
                                   else
                                   {
                                       
                                   ?>   
									<input type="reset" value="Reset" onClick="document.location.href='<?php echo $pagename ; ?>';" class="btn btn-danger" style="margin-left:15px;border-radius:4px !important;">
                                    <?php
                                   }
								   ?>
                                    </td>
                                   </tr> 
                                
                                  
                                  <tr>
                                <td colspan="4"><input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" ></td>
                                  </tr>
                                  
                                </table>
                                </div>
                                </form>
							
							</div>
					</div>
				</div>
                <!--   DTata tables -->
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
                                            <th>S.No</th>  
                                            <th>Truck No</th>
                                        	<th>Driver Name </th>
                                            <th>Date</th>
                                            <th> Mechanic Name </th>
                                            <th> Maintenance / Spare</th>
                                            <th>Amount</th>
                                            <th>Payment type</th>
                                            <th>Payment Mode</th>
                                             <th>Remark</th>
                                            <th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from maintenance_entry order by main_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{

										$truckno=$cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
										$maintenance=$cmn->getvalfield($connection,"head_master","headname","headid='$row[headid]'");
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' && designation='1' "); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno;?></td>
                                            <td><?php echo ucfirst($driver);?></td>
                                            <td><?php echo dateformatindia($row['maint_date']);?></td>
                                          
                                            <td><?php echo $mechanic_name;?></td>
											<td><?php echo $maintenance;?></td>
                                            <td><?php echo ucfirst($row['amount']);?></td>
											<td><?php echo ucfirst($row['payment_type']);?></td>
                                           
                                            <td><?php echo ucfirst($row['payment_mode']);?></td>
                                            <td><?php echo ucfirst($row['remark']);?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['main_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"  style="display:"><img src="../img/del.png" title="Delete" ></a>
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

function hideval()
{
	var paymode = document.getElementById('paymode').value;
	if(paymode == 'cash')
	{
		document.getElementById('checquenumber').disabled = true;
		document.getElementById('session_name').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('session_name').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('session_name').disabled = false;
	}
}






function ajax_save_shortcut_driver(empname,mob1)
{
	var empname = document.getElementById(empname).value;
    var mob1 = document.getElementById(mob1).value;
 
	if( empname == ""  || mob1 == "")
	{
       
		alert('Fill form properly');
		document.getElementById(empname).focus();
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
				document.getElementById("empid").innerHTML = xmlhttp.responseText;
			
				document.getElementById("empname").value = "";
				document.getElementById("mob1").value = "";
              
				$("#div_empname").toggle(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_save_shortcut_driver.php?empname="+empname+"&mob1="+mob1,true);
   xmlhttp.send();
	
}



function ajax_save_headname(headname)
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
				document.getElementById("headid").innerHTML = xmlhttp.responseText;
			
				document.getElementById("headname").value = "";
			
              
				$("#div_headname").toggle(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_save_shortcut_head.php?headname="+headname,true);
   xmlhttp.send();
	
}

function ajax_save_mechanicname(mechanic_name,mobile)
{
    
	var mechanic_name = document.getElementById(mechanic_name).value;
    var mobile = document.getElementById(mobile).value;

 
	if(mechanic_name == "" ||  mobile == "" )
	{
      
		alert('Fill form properly');
		document.getElementById(mechanic_name).focus();
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
				alert('ok');
				document.getElementById("meachineid").innerHTML = xmlhttp.responseText;
			  
				document.getElementById("mechanic_name").value = "";
                document.getElementById("mobile").value = "";
              
				$("#div_mechanicname").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_save_mechanicname.php?mechanic_name="+mechanic_name+"&mobile="+mobile,true);
   xmlhttp.send();
	
}
</script>
	</body>
    <?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

	</html>
<?php
mysqli_close($connection);
?>
