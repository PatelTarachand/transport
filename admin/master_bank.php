<?php 
include("dbconnect.php");
$tblname = "m_bank";
$tblpkey = "bankid";
$pagename = "master_bank.php";
$modulename = "Bank Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$bankid=$_GET['edit'];
	$sql_edit="select * from m_bank where bankid='$bankid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$bankname = $row['bankname'];
			$branchname = $row['branchname'];
			$bankaddress = $row['bankaddress'];
			$contactpersion = $row['contactpersion'];
			$helpline = $row['helpline'];
			$mobileno = $row['mobileno'];
			$ifsc_code = $row['ifsc_code'];
			
		}//end while
	}//end if
}//end if
else
{
	$bankid = 0;
	$incdate = date('d-m-Y');
	
	$bankname ='';
			$branchname = '';
			$bankaddress ='';
			$contactpersion = '';
			$helpline = '';
			$mobileno = '';
			$ifsc_code = '';
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$bankname = $_POST['bankname'];
	$branchname = $_POST['branchname'];
	$bankaddress = $_POST['bankaddress'];
	$contactpersion = $_POST['contactpersion'];
	$helpline = $_POST['helpline'];
	$mobileno = $_POST['mobileno'];
	$ifsc_code = $_POST['ifsc_code'];
	//print_r($_POST);die;
	if($bankid==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_bank where bankname='$bankname' and branchname = '$branchname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{						
			$sql_insert="insert into m_bank set bankname = '$bankname', branchname = '$branchname',
			 bankaddress='$bankaddress',contactpersion='$contactpersion',ifsc_code = '$ifsc_code', helpline='$helpline',
			  mobileno='$mobileno', createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]'"; 
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		
			echo "<script>location='master_bank.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_bank set bankname = '$bankname', branchname = '$branchname',
		 bankaddress='$bankaddress',  contactpersion='$contactpersion',ifsc_code = '$ifsc_code', helpline='$helpline',
		  mobileno='$mobileno', lastupdate=now(),ipaddress = '$ipaddress' where bankid='$bankid'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $bankid;
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_bank.php?action=2'</script>";
	}
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
							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="width:60%;">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td><strong>Bank Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="22%"><input type="text" name="bankname" id="bankname" value="<?php echo $bankname; ?>"
                                     autocomplete="off"   class="input-large"  ></td>
                                    <td width="17%"><strong>Branch:</strong><span class="red">*</span></td>
                                    <td width="48%"><input type="text" name="branchname" id="branchname" value="<?php echo $branchname; ?>" autocomplete="off"  maxlength="120"  class="input-large" required></td>
                                 </tr>
                                
                                  <tr>
                                    <td width="13%"> <strong>Address:</strong></td>
                                    <td colspan="3">
                    				<input type="text" name="bankaddress" value="<?php echo $bankaddress; ?>" id="bankaddress" 
                                         class="input-large" >
                                    </td>
                                   </tr> 
                                  
                                  <tr>
                                    <td><strong>AC No:</strong></td>
                                    <td width="22%">
                                    <input type="text" name="helpline" value="<?php echo $helpline; ?>" id="helpline" 
                                     class="input-large">
                                    </td>
                                    <td width="17%"><strong>Contact Person Name:</strong></td>
                                    <td width="48%"><input type="text" name="contactpersion" id="contactpersion" value="<?php echo $contactpersion; ?>" autocomplete="off"  maxlength="120"   class="input-large"></td>
                                  </tr>
                                  
                                   <tr>
                                   
                                    <td width="13%"><strong>Mobile No:</strong></td>
                                    <td width="22%"><input type="text" name="mobileno" id="mobileno" value="<?php echo $mobileno; ?>" autocomplete="off"
                                      maxlength="10" class="input-large"></td>
                                       <td width="17%"> <strong>IFSC Code: </strong></td>
                                    <td colspan="3">
                    				<input type="text" name="ifsc_code" value="<?php echo $ifsc_code; ?>" id="ifsc_code" 
                                        class="input-large">
                                    </td>
                                  </tr>
                                  
                                 <tr>
                                 <td colspan="3" style="line-height:5"> <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('bankname al,branchname al')"  style="margin-left:360px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" ></td>
                                 
                                 <td>&nbsp;</td></tr>  
                                  
                                  
                                </table> 
                                </div>
                                </form>
							
						</div>
					</div>
				</div>
                
                <!--   DTata tables -->
                <div class="row-fluid" id="list">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                <a href="excel_master_bank.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                 
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Bank</th>
                                        	<th>Branch</th>
                                            <th>Address</th>
                                            <th>A/C No</th>
                                            <th>Contact Person</th>
                                            <th>Mobile</th>
                                            <th>Phone</th>
                                        	<th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_bank order by bankid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['bankname']);?></td>
                                            <td><?php echo ucfirst($row['branchname']);?></td>
                                            <td><?php echo ucfirst($row['bankaddress']);?></td>
                                            <td><?php echo ucfirst($row['helpline']);?></td>
                                            <td><?php echo ucfirst($row['contactpersion']);?></td>
                                            <td><?php echo ucfirst($row['mobileno']);?></td>
                                            <td><?php echo ucfirst($row['ifsc_code']);?></td>
                                            <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['bankid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
		document.getElementById('bankname').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('bankname').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('bankname').disabled = false;
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
