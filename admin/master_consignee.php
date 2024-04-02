<?php 
include("dbconnect.php");
$tblname = "m_consignee";
$tblpkey = "consigneeid";
$pagename = "master_consignee.php";
$modulename = "Consignee Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$consigneeid	=$_GET['edit'];
	$sql_edit="select * from m_consignee where consigneeid	='$consigneeid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$consigneename = $row['consigneename'];
			$contactname = $row['contactname'];
			$phoneno = $row['phoneno'];
			$mob1 = $row['mob1'];
			$mob2 = $row['mob2'];
			$email = $row['email'];
			$consigneeaddress = $row['consigneeaddress'];
			$stateid = $row['stateid'];
			$gstno = $row['gstno'];
			$enable = $row['enable'];
			$type = $row['type'];
		}//end while
	}//end if
}//end if
else
{
	$consigneeid	 = 0;
	$incdate = date('d-m-Y');
	$enable = "enable";
	$consigneename = '';
			$contactname = '';
			$phoneno = '';
			$mob1 = '';
			$mob2 = '';
			$email = '';
			$consigneeaddress = '';
			$stateid = '';
			$gstno = '';
			$type=0;
	
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$consigneename = $_POST['consigneename'];
	$contactname = $_POST['contactname'];
	$phoneno = $_POST['phoneno'];
	$mob1 = $_POST['mob1'];
	$mob2 = $_POST['mob2'];
	$email = $_POST['email'];
	$consigneeaddress = $_POST['consigneeaddress'];
	$stateid = isset($_POST['stateid'])?$_POST['stateid']:'';
	$gstno = $_POST['gstno'];
	$type = $_POST['type'];
	$enable = "enable";
	if($consigneeid	==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_consignee where consigneename='$consigneename'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
			$sql_insert="insert into m_consignee set consigneename = '$consigneename',
			 phoneno='$phoneno', mob1='$mob1', mob2='$mob2', contactname='$contactname',type='$type', email='$email',stateid='$stateid', gstno='$gstno', enable='$enable',consigneeaddress='$consigneeaddress',  createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_consignee.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_consignee set consigneename = '$consigneename',stateid='$stateid', gstno='$gstno', enable='$enable',type='$type', 
		 phoneno='$phoneno', contactname='$contactname', email='$email',  mob1='$mob1', mob2='$mob2',
		  consigneeaddress='$consigneeaddress', lastupdate=now(),ipaddress = '$ipaddress' where consigneeid	='$consigneeid'";
		mysqli_query($connection,$sql_update);
		$keyvalue = $consigneeid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_consignee.php?action=2'</script>";
	}
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
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="width:60%;">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td width="12%"><strong>Consignee Name</strong><span class="red">*</span></td>
                                    <td width="24%"><input type="text" name="consigneename" id="consigneename" value="<?php echo $consigneename; ?>"
                                     autocomplete="off"  maxlength="120" placeholder='enter consignee name' class="input-large" ></td>
                                    <td width="15%"><strong>Contact Person:</strong></td>
                                    <td width="49%"><input type="text" name="contactname" id="contactname" value="<?php echo $contactname; ?>" autocomplete="off"  maxlength="10"  class="input-large" placeholder='enter contact person'></td>
                                 </tr>
                                  
                                  <tr>
                                    <td><strong>Phone No:</strong></td>
                                    <td width="24%">
                                    <input type="text" name="phoneno" value="<?php echo $phoneno; ?>" id="phoneno" 
                                 class="input-large" placeholder='enter phone no:'>
                                    </td>
                                    <td width="15%"><strong>Contact No-1:</strong></td>
                                    <td width="49%"><input type="text" name="mob1" id="mob1" maxlength="10" value="<?php echo $mob1; ?>" autocomplete="off"
                                      maxlength="120" class="input-large" placeholder='enter contact number'></td>
                                  </tr>
                                  
                                   <tr>                                    
                                    <td width="15%"><strong>Email: </strong></td>
                                    <td width="49%"><input type="text" name="email" value="<?php echo $email; ?>" id="email" 
                                    class="input-large" placeholder='enter email address'></td>
                                    
                                    <td><strong>PAN No:</strong></td>
                                    <td width="24%">
                                    <input type="text" name="mob2" value="<?php echo $mob2; ?>" id="mob2" class="input-large" maxlength="20" placeholder='Enter PAN Number'>
                                    </td>
                                    
                                  </tr>
                                  <tr>
                                    <td><strong>GSTIN No :</strong></td>
                                    <td width="18%">
                                    <input type="text" name="gstno" value="<?php echo $gstno; ?>" id="gstno" 
                                  class="input-large" maxlength="20" >
                                    </td>
                                    <td width="7%"><strong>State Code :</strong></td>
                                    <td width="65%"><select name="stateid" id="stateid" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        <?php
														$sql = "Select stateid,statename,statecode from m_state";
														$res = mysqli_query($connection,$sql);
														if($res)
														{
															while($row = mysqli_fetch_assoc($res))
															{
														?>
                                                        	<option value="<?php echo $row['stateid']; ?>"><?php echo $row['statename']."-".$row['statecode']; ?></option>
                                                        <?php
															}
														}
														?>
                                    				</select>
                                                    <script>document.getElementById('stateid').value = "<?php echo $stateid; ?>";</script></td>
                                  </tr>
                                  <tr>
                                    <td><strong>Consignee Address:</strong></td>
                                    <td width="24%">
                                    <input type="text" name="consigneeaddress" value="<?php echo $consigneeaddress; ?>" id="consigneeaddress" 
                                    class="input-large" placeholder='enter address'>
                                    </td>
                                    
                                    
                                   <td width="15%"><strong>Type :</strong></td>
                                    <td><select name="type" id="type" class="form-control input-large" >
                                      		  <option value="0">Party</option>
                                      		  <option value="1">Dumb</option>
                                   		    </select>
                                            <script>document.getElementById('type').value='<?php echo $type; ?>';</script></td>
                                    
                                   </tr> 
								   
                                   <tr>
                                                               
                                   <td width="15%"><strong>Status :</strong></td>
                                    <td width="49%"><select name="enable" id="enable" class="form-control input-large">
                                      		  <option value="enable">Enable</option>
                                      		  <option value="disable">Disable</option>
                                   		    </select>
                                            <script>document.getElementById('enable').value='<?php echo $enable; ?>';</script></td>
                                    
                                   </tr>
								   
                                  <tr>
                                  <td colspan="4">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('consigneename')" style="margin-left:380px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									<?php
                                   }
                                   else
                                   {
                                       
                                   ?>   
									<input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
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
				</div>
                <!--   DTata tables -->
                <div class="row-fluid" id="list" style="display:none;">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                <a href="excel_master_consignee.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                 
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Consignee Name</th>
                                            <th>Contact Person</th>
                                            <th>Phone No</th>
                                            <th>Contact No(1)</th>
                                            <th>Contact No(2)</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_consignee order by consigneeid  desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['consigneename']);?></td>
                                            <td><?php echo ucfirst($row['contactname']);?></td>
                                            <td><?php echo ucfirst($row['phoneno']);?></td>
                                            <td><?php echo ucfirst($row['mob1']);?></td>
                                            <td><?php echo ucfirst($row['mob2']);?></td>
                                            <td><?php echo ucfirst($row['email']);?></td>
                                            <td><?php echo ucfirst($row['consigneeaddress']);?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['consigneeid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
