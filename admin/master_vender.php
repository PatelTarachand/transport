<?php 
include("dbconnect.php");
$tblname = "m_vender";
$tblpkey = "venderid";
$pagename = "master_vender.php";
$modulename = "Vender Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$venderid=$_GET['edit'];
	$sql_edit="select * from m_vender where venderid='$venderid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$vendername = $row['vendername'];			
			$address = $row['address'];			
			$contactno = $row['contactno'];
			$email1 = $row['email1'];			
			$enable = $row['enable'];
			
		}//end while
	}//end if
}//end if
else
{
		$venderid = 0;
		$incdate = date('d-m-Y');
		$enable = "enable";
		$vendername = '';
		$address = '';
		$contactname = '';
		$contactno = '';
		$email1 = '';
	
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$vendername = $_POST['vendername'];	
	$address = $_POST['address'];
	$contactno = $_POST['contactno'];
	$email1 = $_POST['email1'];		
	$enable = $_POST['enable'];	
	
	if($venderid==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_vender where vendername='$vendername'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
		
			$sql_insert="insert into m_vender set vendername = '$vendername',enable='$enable',
			  address='$address', contactno='$contactno',
			  email1='$email1',createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			
			echo "<script>location='master_vender.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_vender set vendername = '$vendername',contactno='$contactno',
		address='$address',enable='$enable',
		  email1='$email1', lastupdate=now(),ipaddress = '$ipaddress' where venderid='$venderid'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $venderid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_vender.php?action=2'</script>";
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
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td width="10%"><strong>Vender Name :</strong> <span class="red">*</span></td>
                                    <td width="35%"><input type="text" name="vendername" id="vendername" value="<?php echo $vendername; ?>"
                                     autocomplete="off"  maxlength="120" tabindex="1" placeholder='enter consignor name' class="input-large" ></td>
                                    <td width="20%"><strong>Contact No:</strong></td>
                                    <td width="36%"> <input type="text" name="contactno" id="contactno" value="<?php echo $contactno; ?>" autocomplete="off"
                                      maxlength="10" class="input-large" placeholder='enter contact number'>
                            </td>
                                 </tr>
                                
                                   
                                  
                                  <tr>
                                    <td><strong>Email:</strong></td>
                                    <td width="35%">
                                  <input type="text" name="email1" value="<?php echo $email1; ?>" id="email1" tabindex="7"  class="input-large" placeholder='enter first email address'>
                                    </td>
                                    <td width="20%"><strong>Address:</strong></td>
                                    <td width="36%"> <input type="text" name="address" value="<?php echo $address; ?>" id="address" 
                                       tabindex="9"  class="input-large" placeholder='enter company address'></td>
                                  </tr>
                                  
                                   
                                  
                                  
                                  
                                  <tr>
                                    <td><strong>Status:</strong></td>
                                    <td width="35%">
                                      <select name="enable" id="enable" class="form-control" style="width:100px;" tabindex="4">
                                      		  <option value="enable">Enable</option>
                                      		  <option value="disable">Disable</option>
                                   		    </select>
                                            <script>document.getElementById('enable').value='<?php echo $enable; ?>';</script>
                                    </td>
                                  
                                  </tr>
                                  <tr>
                                  <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="9%">&nbsp;</td>
                                    <td colspan="3">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('vendername')" tabindex="10" style="margin-left:180px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									<?php
                                   }
                                   else
                                   {
                                       
                                   ?>   
									<input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
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
                <div class="row-fluid" id="list">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                 <a href="excel_master_vender.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Consigoner</th>
                                            <th>Contact No</th>
                                            <th>Email(1)</th>
                                            <th>Address</th>
                                           <th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_vender order by venderid desc";//13 = to pay & -1 = other
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['vendername']);?></td>
                                            <td><?php echo ucfirst($row['contactno']);?></td>
                                            <td><?php echo ucfirst($row['email1']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['venderid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
