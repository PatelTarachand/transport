<?php
include("dbconnect.php");
$tblname = "supplier_master";
$tblpkey = "supplier_id";
$pagename = "supplier_master.php";
$modulename = "Supplier Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from supplier_master where supplier_id='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$supplier_name = $row['supplier_name'];
			$mobile_no = $row['mobile_no'];
			$address = $row['address'];
			$opening_balance = $row['opening_balance'];
			$ope_bal_date = $row['ope_bal_date'];
				$party_type = $row['party_type'];
		}//end while
	}//end if
}//end if
else
{
	$supplier_id = 0;

	$supplier_name='';
	$mobile_no='';
	$address='';
	$opening_balance='';
	$party_type = '';
		$ope_bal_date = '';
}

$duplicate= "";
if(isset($_POST['submit']))
{	
	$supplier_id = $_POST['supplier_id'];
	$supplier_name = $_POST['supplier_name'];
		$party_type = $_POST['party_type'];
	$mobile_no = $_POST['mobile_no'];
	$address = $_POST['address'];
	$opening_balance = $_POST['opening_balance'];

	$ope_bal_date = $_POST['ope_bal_date'];

	if($supplier_id==0)
	{
		
		//check doctor existance
	
		$sql_chk = "select * from supplier_master where supplier_name='$supplier_name'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
	
		if($cnt == 0)
		{
			
			 $sql_insert="insert into supplier_master set supplier_name = '$supplier_name', mobile_no = '$mobile_no',address = '$address', opening_balance = '$opening_balance', party_type = '$party_type',
			 ope_bal_date='$ope_bal_date',sessionid='$sessionid',createdate='$createdate',compid='$compid',ipaddress='$ipaddress'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
		
			// echo "<script>location='master_company.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
		$supplier_name='';
		$mobile_no='';
		$address='';
		$opening_balance='';
		$ope_bal_date = '';
	}
	
	else
	{
		// // echo "test";die;
		// echo "update   supplier_master set supplier_name = '$supplier_name', mobile_no = '$mobile_no',address = '$address', opening_balance = '$opening_balance',
		// ope_bal_date='$ope_bal_date' where supplier_id='$supplier_id'";die;
		
		$keyvalue = $_GET['edit'];
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		
		
	
		$sql_update = "update  supplier_master set supplier_name = '$supplier_name', mobile_no = '$mobile_no',address = '$address', opening_balance = '$opening_balance', party_type = '$party_type',
		ope_bal_date='$ope_bal_date' where supplier_id='$keyvalue'";
		mysqli_query($connection,$sql_update);
		
		
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		//echo "<script>location='master_company.php?action=2'</script>";
	}
	$supplier_name='';
	$mobile_no='';
	$address='';
	$opening_balance='';
	$ope_bal_date = '';
	
}

?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php");?>

<script>
  $(function() {
   
	 $('#start_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	$('#end_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	
  });
  </script>

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
								<h3><i class="icon-edit"></i>supplier Master</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                 <td><strong>supplier Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="25%">
                 <input type="text" name="supplier_name"  id="supplier_name"  value="<?php echo $supplier_name; ?>"class="input-large" required >
                                    </td>
                                    <td><strong>Mobile No.</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="37%"><input  type="text" pattern="[6-9]{1}[0-9]{9}"  onchange="try{setCustomValidity('')}catch(e){}"
      oninput="setCustomValidity(' ')"   oninvalid="this.setCustomValidity('Please Enter valid mobile no.')" name="mobile_no" id="mobile_no"  maxlength="10"  value="<?php echo $mobile_no; ?>"
                                     autocomplete="off"  maxlength="120" class="input-large"  ></td>
                                    
                                 </tr>
                                
                                  <tr>
                                    <td width="11%"> <strong>Address:</strong></td>
                                    <td>
                    				<input type="text" name="address" value="<?php echo $address; ?>" id="address" 
                                      class="input-large" >
                                    </td>
                                    <td width="27%"><strong>Opening Balance:</strong></td>
                                    <td><input type="text" name="opening_balance" id="opening_balance" value="<?php echo $opening_balance; ?>"
                                     autocomplete="off"  maxlength="120" class="input-large" ></td>
                                   </tr> 
                                  
                                  <tr>
                                    <td><strong>Opening Bal. Date:</strong><span class="red">*</span></td>
                                    <td width="25%">
                                    <input type="date" name="ope_bal_date" value="<?php echo $ope_bal_date; ?>" id="ope_bal_date" 
                                     class="input-large" required>
                                    </td>
                                     <td><strong>Part Type :</strong><span class="red">*</span></td>
                                    <td width="25%">
                                    <select data-placeholder="Choose a Country..." name="party_type" id="party_type" style="width:220px" class="formcent select2-me" onChange="getSearch();">
                                                    <option value="">Select</option>
                                                    <option value="Consignor">Consignor</option>
                                                    <option value="Consignee">Consignee</option>
                                                    <script>
                                                        document.getElementById('party_type').value = '<?php echo $party_type; ?>';
                                                    </script>
                                                </select>
                                    </td>
                                    
                                  </tr>
                                  
                             
                                   
                               
                                    
                                 <tr>
                                    <td colspan="3">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('cname')" style="margin-left:340px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
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
                                            <th>Supplier  Name</th>
                                        	<th>Supplier mobile no</th>
                                            <th>Address</th>
                                            <th>Opening Balance</th>
                                            <th>Opening Bal. Date</th>
                                         <th>Party Type</th>
                                            <th>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from supplier_master";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['supplier_name']);?></td>
                                            <td><?php echo ucfirst($row['mobile_no']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                            <td><?php echo ucfirst($row['opening_balance']);?></td>
                                            <td><?php echo ucfirst($row['ope_bal_date']);?></td>
                                            <td><?php echo ucfirst($row['party_type']);?></td>
                                           <td class=''>
                                           <a href= "?edit=<?php echo ucfirst($row['supplier_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"  ><img src="../img/del.png" title="Delete" ></a>
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
