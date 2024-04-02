<?php include("dbconnect.php");
$tblname = "diesel_m_supplier";
$tblpkey = "supplier_id";
$pagename = "m_diesel_supplier.php";
$modulename = "Diesel Supplier Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$supplier_id=$_GET['edit'];
	$sql_edit="select * from diesel_m_supplier where supplier_id='$supplier_id'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$supplier_name = $row['supplier_name'];
			$address = $row['address'];
			$district = $row['district'];
			$state = $row['state'];
			$mobile1 = $row['mobile1'];
			$mobile2 = $row['mobile2'];
			$phoneno1 = $row['phoneno1'];
			$phoneno2 = $row['phoneno2'];
			$email = $row['email'];
			$faxno = $row['faxno'];
			$service_tax_no = $row['service_tax_no'];
			$gstno = $row['gstno'];
			$cstno = $row['cstno'];
			$panno = $row['panno'];
			$rslno = $row['rslno'];
			$taxdeduction_acc_no = $row['taxdeduction_acc_no'];
			$contact_persion = $row['contact_persion'];
			$designation = $row['designation'];
			$contact_persion_mobile = $row['contact_persion_mobile'];
			$contact_persion_email = $row['contact_persion_email'];
		}//end while
	}//end if
}//end if
else
{
	$supplier_id = 0;
	$incdate = date('d-m-Y');
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$supplier_name = $_POST['supplier_name'];
	$address = $_POST['address'];
	$district = $_POST['district'];
	$state = $_POST['state'];
	$mobile1 = $_POST['mobile1'];
	$mobile2 = $_POST['mobile2'];
	$phoneno1 = $_POST['phoneno1'];
	$phoneno2 = $_POST['phoneno2'];
	$email = $_POST['email'];
	$faxno = $_POST['faxno'];
	$service_tax_no = $_POST['service_tax_no'];
	$gstno = $_POST['gstno'];
	$cstno = $_POST['cstno'];
	$panno = $_POST['panno'];
	$rslno = $_POST['rslno'];
	$taxdeduction_acc_no = $_POST['taxdeduction_acc_no'];
	$contact_persion = $_POST['contact_persion'];
	$designation = $_POST['designation'];
	$contact_persion_mobile = $_POST['contact_persion_mobile'];
	$contact_persion_email = $_POST['contact_persion_email'];
	
	if($supplier_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from diesel_m_supplier where supplier_name='$supplier_name'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		if($cnt == 0)
		{
			 $sql_insert="insert into diesel_m_supplier set supplier_name = '$supplier_name',address='$address', district='$district', 
			 state='$state', mobile1 = '$mobile1',mobile2='$mobile2', phoneno1='$phoneno1', 
			 phoneno2='$phoneno2',email = '$email',faxno='$faxno', service_tax_no='$service_tax_no', 
			 gstno='$gstno', cstno = '$cstno',panno='$panno', rslno='$rslno', 
			 taxdeduction_acc_no='$taxdeduction_acc_no', contact_persion='$contact_persion', designation = '$designation',contact_persion_mobile='$contact_persion_mobile', contact_persion_email='$contact_persion_email', createdate=now(),lastupdated=now(), sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='m_diesel_supplier.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  diesel_m_supplier set supplier_name = '$supplier_name',address='$address',  district='$district', state='$state',mobile1 = '$mobile1',mobile2='$mobile2',  phoneno1='$phoneno1', phoneno2='$phoneno2',email = '$email',faxno='$faxno',  service_tax_no='$service_tax_no', gstno='$gstno',cstno = '$cstno',panno='$panno',  rslno='$rslno', taxdeduction_acc_no='$taxdeduction_acc_no', contact_persion='$contact_persion', designation = '$designation',contact_persion_mobile='$contact_persion_mobile', contact_persion_email='$contact_persion_email', lastupdated=now() where supplier_id='$supplier_id'";
		mysqli_query($connection,$sql_update);
		$keyvalue = $supplier_id;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='m_diesel_supplier.php?action=2'</script>";
	}
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
	$("#shortcut_placeid").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});
	</script>
</head>

<body onLoad="hideval();">
<!--- short cut form place --->
<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place</strong></td></tr>
  <tr><td>&nbsp;Unit Name: </td></tr>
  <tr><td><input type="text" name="placename" id="placename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_placename();"/></td></tr>
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
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('supplier_name')">
                                <div class="control-group">
                                <table width="100%" border="0" class="gap">
    	<tr>
            <td width="15%">Supplier Name <span class="err">*</span></td>
            <td width="23%"><input type="text" name="supplier_name" id="supplier_name" class="frmsave formbox" data-required="true" value="<?php echo $supplier_name; ?>">
            </td>
            <td width="14%">Address </td>
            <td width="48%"><input type="text" name="address" id="address" class="frmsave formbox" value="<?php echo $address; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">District</td>
            <td width="23%"><input type="text" id="district" name="district" class="frmsave formbox" value="<?php echo $district; ?>">
            </td>
            <td width="14%">State</td>
            <td width="48%"><input type="text" id="state" name="state" class="frmsave formbox" value="<?php echo $state; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">Mobile No-1 </td>
            <td width="23%"><input type="text" id="mobile1" name="mobile1" class="frmsave formbox" maxlength="13" value="<?php echo $mobile1; ?>">
            </td>
            <td width="14%">Mobile No-2</td>
            <td width="48%"><input type="text" id="mobile2" name="mobile2" class="frmsave formbox" maxlength="13" value="<?php echo $mobile2; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">Phone No-1</td>
            <td width="23%"><input type="text" id="phoneno1" name="phoneno1" class="frmsave formbox" maxlength="13" value="<?php echo $phoneno1; ?>">
            </td>
            <td width="14%">Phone No-2</td>
            <td width="48%"><input type="text" id="phoneno2" name="phoneno2" class="frmsave formbox" maxlength="13" value="<?php echo $phoneno2; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">email</td>
            <td width="23%"><input type="text" id="email" name="email" class="frmsave formbox" value="<?php echo $email; ?>">
            </td>
            <td width="14%">Fax No</td>
            <td width="48%"><input type="text" id="faxno" name="faxno" class="frmsave formbox" maxlength="15" value="<?php echo $faxno; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">Service Tax No</td>
            <td width="23%"><input type="text" id="service_tax_no" name="service_tax_no" class="frmsave formbox" value="<?php echo $service_tax_no; ?>">
            </td>
            <td width="14%">GST No</td>
            <td width="48%"><input type="text" id="gstno" name="gstno" class="frmsave formbox" value="<?php echo $gstno; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">CST No</td>
            <td width="23%"><input type="text" id="cstno" name="cstno" class="frmsave formbox" value="<?php echo $cstno; ?>">
            </td>
            <td width="14%">PAN No</td>
            <td width="48%"><input type="text" id="panno" name="panno" class="frmsave formbox" maxlength="16" value="<?php echo $panno; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">RSL No</td>
            <td width="23%"><input type="text" id="rslno" name="rslno" class="frmsave formbox" value="<?php echo $rslno; ?>">
            </td>
            <td width="14%">TEX Deduction no</td>
            <td width="48%"><input type="text" id="taxdeduction_acc_no" name="taxdeduction_acc_no" class="frmsave formbox" value="<?php echo $taxdeduction_acc_no; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">Contact Persion</td>
            <td width="23%"><input type="text" id="contact_persion" name="contact_persion" class="frmsave formbox" value="<?php echo $contact_persion; ?>">
            </td>
            <td width="14%">Designation</td>
            <td width="48%"><input type="text" id="designation" name="designation" class="frmsave formbox" value="<?php echo $designation; ?>">
            </td>
        </tr>
        <tr>
            <td width="15%">Contact Persion Mobile</td>
            <td width="23%"><input type="text" id="contact_persion_mobile" name="contact_persion_mobile" class="frmsave formbox" maxlength="13" value="<?php echo $contact_persion_mobile; ?>">
            </td>
            <td width="14%">Contact Persion Email</td>
            <td width="48%"><input type="text" id="contact_persion_email" name="contact_persion_email" class="frmsave formbox" value="<?php echo $contact_persion_email; ?>">
            </td>
        </tr>
        
                                 <tr>
                                  	
                                    <td colspan="4" style="line-height:5">
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" style="margin-left:360px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </td>
                                    
                                  </tr>
                                 
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
                <!--   DTata tables -->
                <div class="row-fluid" id="list">
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
                                            <th>Supplier Name</th>
                                            <th>Address</th>
                                            <th>District</th>
                                            <th>State</th>
                                            <th>Mobile-1</th>
                                            <th>Email</th>
                                            <th>Fax No</th>
                                            <th>Pan No</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from diesel_m_supplier";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['supplier_name']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                            <td><?php echo ucfirst($row['district']);?></td>
                                            <td><?php echo ucfirst($row['state']);?></td>
                                            <td><?php echo ucfirst($row['mobile1']);?></td>
                                            <td><?php echo ucfirst($row['email']);?></td>
                                            <td><?php echo ucfirst($row['faxno']);?></td>
                                            <td><?php echo ucfirst($row['panno']);?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['supplier_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['supplier_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
	  	//alert(tblname);
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
			 //alert('Data Deleted Successfully');
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
<script>
function ajax_save_placename()
{
	var placename = document.getElementById('placename').value;
		//alert(placename);
		if(placename == "")
		{
			alert('Please Fill place name');
			document.getElementById('placename').focus();
			return false;
		}
		
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
				if(xmlhttp.responseText != '')
				{
					//alert('This specification already exist');
					//alert( xmlhttp.responseText);
					document.getElementById("placeid").innerHTML = xmlhttp.responseText;
					
					document.getElementById("placename").value = "";
					$("#div_placeid").hide(1000);
					
				}
			}
		}
		xmlhttp.open("GET","ajax_saveplace.php?placename="+placename,true);
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
