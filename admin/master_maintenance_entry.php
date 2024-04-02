<?php
include("dbconnect.php");
$tblname = "maintenance_entry";
$tblpkey = "main_id";
$pagename = "master_maintenance_entry.php";
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
			$driver_name = $row['driver_name'];
			$date = $row['date'];
			$m_id = $row['m_id'];
			$mid = $row['mid'];
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
	
	$driver_name='';
	
	$m_id='';
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
	$driver_name = $_POST['driver_name'];
	$date = $_POST['date'];
	$m_id = $_POST['m_id'];
	$mid = $_POST['mid'];
	$amount = $_POST['amount'];
	$payment_type = $_POST['payment_type'];
	$payment_mode = $_POST['payment_mode'];
	$remark = $_POST['remark'];

	
	if($main_id==0)
	{
		
		//check doctor existance
	
		$sql_chk = "select * from maintenance_entry where truckid='$truckid' &&  driver_name='$driver_name' &&  date='$date' &&  amount='$amount'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
	
		if($cnt == 0)
		{
			
			  $sql_insert="insert into maintenance_entry set truckid = '$truckid', driver_name = '$driver_name', remark = '$remark',date = '$date', m_id = '$m_id',
			 mid='$mid', amount='$amount', payment_type='$payment_type',payment_mode='$payment_mode'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);

			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		     echo "<script>location='master_maintenance_entry.php?action=1'</script>";
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
		

		$sql_update = "update maintenance_entry set truckid = '$truckid', driver_name = '$driver_name',remark = '$remark',date = '$date', m_id = '$m_id',
		mid='$mid', amount='$amount', payment_type='$payment_type',payment_mode='$payment_mode' where main_id='$main_id'";
		mysqli_query($connection,$sql_update);
	
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		echo "<script>location='master_maintenance_entry.php?action=2'</script>";
	}
	
	$driver_name='';
	$date=date('d-m-Y');
	$m_id='';
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
<?php include("alerts/alert_js.php"); ?>


</head>

<body onLoad="hideval();">
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
                                <table class="table table-condensed">
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


                                    <td><strong>Driver Name</strong> <strong>:</strong><span class="red">*</span></td>

                                    <td width="37%"><input type="text" name="driver_name" id="driver_name" value="<?php echo $driver_name; ?>"
                                     autocomplete="off"  maxlength="120" class="input-large" ></td>

                                    
                                 </tr>
                                
                                  <tr>
                                    <td width="11%"> <strong>Date</strong></td>
                                    <td>
                    				<input type="date" name="date" value="<?php echo $date; ?>" id="date" 
                                      class="input-large" >
                                    </td>

                                    <td width="27%"><strong>Mechanic Name:</strong></td>
                                    <td>
									<select id="m_id" name="m_id" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" required >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select m_id,mechanic_name from mechanic_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['m_id']; ?>"><?php echo $row_fdest['mechanic_name']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('m_id').value = '<?php echo $m_id; ?>';</script>
                                                    
                                    </td>
                                   </tr> 
                                  
                                  <tr>
                                  	
                                    <td width=""><strong> Maintenance / Spare:</strong></td>
                                    <td>	  <select id="mid" name="mid" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" required >
			<option value="s"> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select mid,maintenance from maintenance_spare");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['mid']; ?>"><?php echo $row_fdest['maintenance']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('mid').value = '<?php echo $mid; ?>';</script>
                                                    
                                    </td>


                                    <td width=""><strong>Amount:</strong></td>
                                    <td width=""><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>" autocomplete="off" maxlength="120" class="input-large" ></td>
                                  </tr>
                                  
                                   <tr>
                                    <td width=""><strong>Payment type:</strong></td>
                                    <td>
									<select id="payment_type" name="payment_type" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                       
                        <option value="Cash">Cash</option>
                         <option value="Credit">Credit</option>
                      
                    </select>
                    <script>document.getElementById('payment_type').value = '<?php echo $payment_type; ?>';</script>  
                                                    
                                    </td>
                                    <td width=""><strong>Payment Mode:</strong></td>
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
									<input type="reset" value="Reset" onClick="document.location.href='<?php echo $pagename ; ?>';" class="btn btn-danger" style="margin-left:15px">
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
                                            <th>Sno</th>  
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
									$sel = "select * from maintenance_entry order by m_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{

										$truckno=$cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$mechanic_name=$cmn->getvalfield($connection,"mechanic_master","mechanic_name","m_id='$row[m_id]'");
										$maintenance=$cmn->getvalfield($connection,"maintenance_spare","maintenance","mid='$row[mid]'");
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno;?></td>
                                            <td><?php echo ucfirst($row['driver_name']);?></td>
                                            <td><?php echo ucfirst($row['date']);?></td>
                                          
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
