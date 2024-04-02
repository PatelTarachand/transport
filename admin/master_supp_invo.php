<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "suppliers";
$tblpkey = "sup_id";
$pagename = "master_supp_invo.php";
$modulename = "Supplier Master";
//print_r($_SESSION);
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$sup_id=$_GET['edit'];
	$sql_edit="select * from suppliers where sup_id='$sup_id'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$sup_name = $row['sup_name'];
			$placeid = $row['placeid'];			
			$address = $row['address'];
			$contactno = $row['contactno'];
			$email1 = $row['email1'];
			$stateid  = $row['stateid'];
			$sup_gstin  = $row['sup_gstin'];
				$opening_bal  = $row['opening_bal'];
					$opening_bal_date  = $row['opening_bal_date'];
			$enable = $row['enable'];
			
			
		}//end while
	}//end if
}//end if
else
{
	$sup_id = '';
	
	$enable = 'enable';	
	$sup_name ='';
	$placeid = '';
	$address = '';
	$contactno = '';
	$email1 = '';
	$districtid  = '';
	$stateid  = '';
	$sup_gstin  = '';
	$opening_bal-'';
		$opening_bal_date-'';
	
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$sup_name = $_POST['sup_name'];
	$placeid = isset($_POST['placeid'])?$_POST['placeid']:'';
	
	$address = $_POST['address'];
	$contactno = $_POST['contactno'];
	$email1 = $_POST['email1'];
	$stateid   = isset($_POST['stateid'])?$_POST['stateid']:'';
	$sup_gstin   = $_POST['sup_gstin'];
	$opening_bal   = $_POST['opening_bal'];
	$opening_bal_date   = $_POST['opening_bal_date'];

	$enable = $_POST['enable'];
	
	
	if($sup_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from suppliers where sup_name='$sup_name'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{

			
			$sql_insert= "insert into suppliers set sup_name = '$sup_name',stateid='$stateid',enable='$enable',sup_gstin='$sup_gstin',opening_bal='$opening_bal' ,opening_bal_date='$opening_bal_date'
			  ,address='$address', contactno='$contactno',email1='$email1', placeid='$placeid' 
			  ,sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_supp_invo.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  suppliers set sup_name = '$sup_name',stateid='$stateid',sup_gstin='$sup_gstin',,opening_bal='$opening_bal' ,opening_bal_date='$opening_bal_date',
		address='$address',contactno='$contactno',enable='$enable',commission='$commission',
		  email1='$email1',placeid='$placeid' where sup_id='$sup_id'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $sup_id;
	
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_supp_invo.php?action=2'</script>";
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
                                    <td><strong>Supplier Name </strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="35%"><input type="text" name="sup_name" id="sup_name" value="<?php echo $sup_name; ?>"
                                     autocomplete="off"  maxlength="120" placeholder='enter consignor name' class="input-large" ></td>
                                    <td width="20%"><strong>Place:</strong></td>
                                    <td width="36%"><select name="placeid" id="placeid" class="select2-me input-large">
                                <option value="">-Select-</option>
                                <?php
									$sql_cust="select * from m_place";
									$res_cust=mysqli_query($connection,$sql_cust);
									while($row_cust=mysqli_fetch_array($res_cust))
									{
								?>
                                	<option value="<?php echo $row_cust['placeid']; ?>"><?php echo $row_cust['placename']; ?></option>
                                <?php
									}
								?>
                                </select>
                               <script>document.getElementById('placeid').value=<?php echo $placeid; ?></script></td>
                                 </tr>
                                
                                    
									
									
                                  
                                  <tr>
                                    <td><strong>Contact No:</strong></td>
                                    <td width="35%">
                                   <input type="text" name="contactno" id="contactno" value="<?php echo $contactno; ?>" autocomplete="off"
                                      maxlength="10" class="input-large" placeholder='Enter contact number'>
                                    </td>
                                    <td width="20%"><strong>Email:</strong></td>
                                    <td width="36%"><input type="email" name="email1" value="<?php echo $email1; ?>" id="email1" class="input-large" placeholder='enter first email address'></td>
                                  </tr>
                                  
                                   
                                  
                                  <tr>
                                    <td><strong>Address:</strong></td>
                                    <td width="35%">
                                    <input type="text" name="address" value="<?php echo $address; ?>" id="address" 
                                    class="input-large" placeholder='enter company address'>
                                    </td>
                                    
                                    <td width="20%"><strong>GSTIN: </strong></td>
                                    <td width="36%"><input type="text" name="sup_gstin" value="<?php echo $sup_gstin; ?>" id="sup_gstin" 
                                       maxlength="15" class="input-large" placeholder='Enter GSTIN NO'></td>
                                  </tr>
									
									<tr>
                                    <td><strong>Opening Bal.:</strong></td>
                                    <td width="35%">
                                    <input type="text" name="opening_bal" value="<?php echo $opening_bal; ?>" id="opening_bal" 
                                    class="input-large" >
                                    </td>
                                    
                                    <td width="20%"><strong>Opening Bal. Date: </strong></td>
                                    <td width="36%"><input type="date" name="opening_bal_date" value="<?php echo $opening_bal_date; ?>" id="opening_bal_date" 
                                        class="input-large" placeholder='DD/MM/YYYY'></td>
                                  </tr>
                                  
                                  <tr>
                                    <td><strong>State Code:</strong></td>
                                    <td width="35%">
                                      <select name="stateid" id="stateid" class="select2-me input-large" >
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
                                                    <script>document.getElementById('stateid').value = "<?php echo $stateid; ?>";</script>
                                    </td>
                                    
                                  <td width="20%"><strong>Status</strong></td>
                                    <td width="36%"><select name="enable" id="enable" style="width:100px;">
									
                                      		  <option value="enable">Enable</option>
                                      		  <option value="disable">Disable</option>
                                   		    </select>
                                            <script>document.getElementById('enable').value='<?php echo $enable; ?>';</script></td>
                                  </tr>
                                  
                                  
                                  
                                  
                                  <tr>
                                  <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="9%">&nbsp;</td>
                                    <td colspan="3">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('sup_name')" style="margin-left:180px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
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
                                 <a href="excel_master_consignor.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                           
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
                                             <th>Place</th>
                                            
                                           <th class='hidden-480'>Action</th>
                                            
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from suppliers  order by sup_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['sup_name']);?></td>
                                            <td><?php echo ucfirst($row['contactno']);?></td>
                                            <td><?php echo ucfirst($row['email1']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                             <td><?php echo  $cmn->getvalfield($connection,"m_place","placename","placeid=$row[placeid]");?></td>
                                         
                                            
                                     
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['sup_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
