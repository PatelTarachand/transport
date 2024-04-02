<?php
include("dbconnect.php");
$tblname = "m_company";
$tblpkey = "compid";
$pagename = "master_company.php";
$modulename = "Company Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from m_company where compid='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$ownername = $row['ownername'];
			$cname = $row['cname'];
			$headname = $row['headname'];
			$phoneno = $row['phoneno'];
			$headaddress = $row['headaddress'];
			$hasepf = $row['hasepf'];
			$mobileno1 = $row['mobileno1'];
			$hasesic = $row['hasesic'];
			$faxno = $row['faxno'];
			$mobileno2 = $row['mobileno2'];
			$caddress = $row['caddress'];
			$pan_card = $row['pan_card'];
			$c_logo = $row['c_logo'];
			$gst_no = $row['gst_no'];
			$stateid = $row['stateid'];
			$chl_prefix= $row['chl_prefix'];
			$saaccode =$row['saaccode']; 
			$venderCode =$row['venderCode'];
			$gstvalid =$row['gstvalid'];
			$account_no= $row['account_no'];
			$bank_name =$row['bank_name']; 
			$branch =$row['branch'];
			$ifsc_code =$row['ifsc_code'];
		}//end while
	}//end if
}//end if
else
{
	$compid = 0;
	$incdate = date('d-m-Y');
	$ownername='';
	$cname='';
	$headname='';
	$phoneno='';
	$headaddress='';
	$hasepf='';
	$mobileno1 = '';
	$hasesic = '';
	$faxno = '';
	$mobileno2 = '';
	$caddress = '';
	$pan_card = '';
	$c_logo="";
	$gst_no = '';
	$stateid ='';
	$chl_prefix='';
	$saaccode='';
	$venderCode='';
	$gstvalid='';
	$account_no='';
	$bank_name='';
	$branch='';
	$ifsc_code='';
}

$duplicate= "";
if(isset($_POST['submit']))
{	
	$compid = $_POST['compid'];
	$venderCode = $_POST['venderCode'];
	
	$cname = $_POST['cname'];
	$headname = $_POST['headname'];
	$phoneno = $_POST['phoneno'];
	$headaddress = $_POST['headaddress'];
	$mobileno1 = $_POST['mobileno1'];
	$faxno = $_POST['faxno'];
	$mobileno2 = $_POST['mobileno2'];
	$caddress = $_POST['caddress'];
	$ownername = $_POST['ownername'];
	$pan_card = $_POST['pan_card'];
	$c_logo = $_FILES['c_logo'];
	
	$gst_no  = $_POST['gst_no'];
	$stateid = isset($_POST['stateid'])?$_POST['stateid']:'';
	$chl_prefix = $_POST['chl_prefix']; 
	$saaccode =  $_POST['saaccode']; 
	$gstvalid =  $_POST['gstvalid']; 
	$account_no= $_POST['account_no'];
	$bank_name =$_POST['bank_name']; 
	$branch =$_POST['branch'];
	$ifsc_code =$_POST['ifsc_code'];
	
	if($compid==0)
	{
		
		//check doctor existance
	
		$sql_chk = "select * from m_company where cname='$cname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
	
		if($cnt == 0)
		{
			// echo "insert into m_company set cname = '$cname', headname = '$headname',headaddress = '$headaddress', phoneno = '$phoneno',
			// mobileno1='$mobileno1', ownername='$ownername', faxno='$faxno',pan_card='$pan_card',gst_no='$gst_no',stateid='$stateid',venderCode='$venderCode',
			//  mobileno2='$mobileno2',saaccode='$saaccode',gstvalid='$gstvalid', account_no='$account_no',bank_name='$bank_name',branch='$branch',ifsc_code='$ifsc_code',caddress='$caddress',chl_prefix='$chl_prefix',createdate=now(),sessionid = '$_SESSION[sessionid]'";die;
			 echo $sql_insert="insert into m_company set cname = '$cname', headname = '$headname',headaddress = '$headaddress', phoneno = '$phoneno',
			 mobileno1='$mobileno1', ownername='$ownername', faxno='$faxno',pan_card='$pan_card',gst_no='$gst_no',stateid='$stateid',venderCode='$venderCode',
			  mobileno2='$mobileno2',saaccode='$saaccode',gstvalid='$gstvalid', account_no='$account_no',bank_name='$bank_name',branch='$branch',ifsc_code='$ifsc_code',caddress='$caddress',chl_prefix='$chl_prefix',createdate=now(),sessionid = '$_SESSION[sessionid]'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$doc_name = $c_logo['name'];
			$ext = pathinfo($doc_name, PATHINFO_EXTENSION);	
			$imgname=$keyvalue.".".$ext;	
			move_uploaded_file($c_logo['tmp_name'],"logo/".$imgname);
			
			 $sql_update = mysqli_query($connection,"update  m_company set c_logo = '$imgname' where compid='$keyvalue' ");
			
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_company.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		
		
	// 	echo "update  m_company set cname = '$cname', headname ='$headname',headaddress = '$headaddress', phoneno = '$phoneno',saaccode='$saaccode',
	// 	mobileno1='$mobileno1', ownername='$ownername', faxno='$faxno',pan_card='$pan_card',c_logo='$doc_name',gst_no='$gst_no',stateid ='$stateid',venderCode='$venderCode',
	//    mobileno2='$mobileno2',gstvalid='$gstvalid', caddress='$caddress',chl_prefix='$chl_prefix' ,lastupdated=now() where compid='$compid'";die;
		
		$keyvalue = $compid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		
		
		$doc_name = $c_logo['name'];
		$ext = pathinfo($doc_name, PATHINFO_EXTENSION);	
		$imgname=$keyvalue.".".$ext;	
		$sql_update = "update  m_company set cname = '$cname', headname ='$headname',headaddress = '$headaddress', phoneno = '$phoneno',saaccode='$saaccode',
			   mobileno1='$mobileno1', ownername='$ownername', faxno='$faxno',pan_card='$pan_card',c_logo='$doc_name',gst_no='$gst_no',stateid ='$stateid',venderCode='$venderCode',
			  mobileno2='$mobileno2',gstvalid='$gstvalid', account_no='$account_no',bank_name='$bank_name',branch='$branch',ifsc_code='$ifsc_code', caddress='$caddress',chl_prefix='$chl_prefix' ,lastupdated=now() where compid='$compid'";
		mysqli_query($connection,$sql_update);
		move_uploaded_file($c_logo['tmp_name'],"logo/".$imgname);
		if($c_logo['tmp_name']!=''){
		 $sql_update = mysqli_query($connection,"update  m_company set c_logo = '$imgname' where compid='$keyvalue' ");
		}
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		//echo "<script>location='master_company.php?action=2'</script>";
	}
}
?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

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
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                 <td><strong>Owner Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="25%">
                 <input type="text" name="ownername" value="<?php echo $ownername; ?>" id="ownername" class="input-large" >
                                    </td>
                                    <td><strong>Company Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="37%"><input type="text" name="cname" id="cname" value="<?php echo $cname; ?>"
                                     autocomplete="off"  maxlength="120" class="input-large" ></td>
                                    
                                 </tr>
                                
                                  <tr>
                                    <td width="11%"> <strong>Company Head:</strong></td>
                                    <td>
                    				<input type="text" name="headname" value="<?php echo $headname; ?>" id="headname" 
                                      class="input-large" >
                                    </td>
                                    <td width="27%"><strong>Phone:</strong></td>
                                    <td><input type="text" name="phoneno" id="phoneno" value="<?php echo $phoneno; ?>"
                                     autocomplete="off"  maxlength="120" class="input-large" ></td>
                                   </tr> 
                                  
                                  <tr>
                                    <td><strong>Mobile 1:</strong></td>
                                    <td width="25%">
                                    <input type="text" name="mobileno1" value="<?php echo $mobileno1; ?>" id="billingdescription" 
                                     class="input-large" >
                                    </td>
                                    <td width="27%"><strong>Mobile 2:</strong></td>
                                    <td width="37%"><input type="text" name="mobileno2" id="mobileno2" value="<?php echo $mobileno2; ?>" autocomplete="off" maxlength="120" class="input-large" ></td>
                                  </tr>
                                  
                                   <tr>
                                    <td><strong>Fax No:</strong></td>
                                    <td width="25%">
                                    <input type="text" name="faxno" value="<?php echo $faxno; ?>" id="faxno" class="input-large" >
                                    </td>
                                     <td width="27%"><strong>Head Address: </strong></td>
                                    <td width="37%"><input type="text" name="headaddress" value="<?php echo $headaddress; ?>" id="headaddress"                      class="input-large"></td>
                                  </tr>
                                  <tr>
                                    <td width="11%"><strong>Address: </strong></td>
                                    <td width="25%"><input type="text" name="caddress" value="<?php echo $caddress; ?>" id="caddress" 
                          class="input-large" ></td>
                                   <td width="11%"> <strong>Pan Card:</strong></td>
                                    <td><input type="text" name="pan_card" id="pan_card" value="<?php echo $pan_card; ?>"
                                     autocomplete="off" class="input-large" ></td>
                                    </tr>
                                   
                                    <tr>
                                    
                                     
                                     
                                     <td width="11%"> <strong>GST No:</strong></td>
                                     <td><input type="text" name="gst_no" id="gst_no" value="<?php echo $gst_no; ?>"
                                     autocomplete="off" class="input-large" ></td>
									 
									 <td width="11%"> <strong>SAAC Code:</strong></td>
                                     <td><input type="text" name="saaccode" id="saaccode" value="<?php echo $saaccode; ?>" autocomplete="off" class="input-large" ></td>
									 
                                     
                                      
                                  
                                    </tr>
                                     <tr>
									
									
									
                                    <td width="11%"><strong>Chalan Prefix: </strong></td>
                                    <td width="25%"><input type="text" name="chl_prefix" value="<?php echo $chl_prefix; ?>" id="chl_prefix" 
                          class="input-large" ></td>
                          
                          
                          
                                   
                                    
                                    </tr>
                                    <tr>
									
									<td width="11%"> <strong>State Name:</strong></td>
                                      <td>
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
									
                                    <td width="11%"><strong>Chalan Prefix: </strong></td>
                                    <td width="25%"><input type="text" name="chl_prefix" value="<?php echo $chl_prefix; ?>" id="chl_prefix" 
                          class="input-large" ></td>
                          
                          
                          
                                   
                                    
                                    </tr>
                                    <tr>  <td width="11%"><strong>Vendor Code: </strong></td>
                                    <td width="25%"><input type="text" name="venderCode" value="<?php echo $venderCode; ?>" id="chl_prefix" 
                          class="input-large" ></td> 
                          <td width="11%"> <strong>GST Valid :</strong></td>
                                      <td>
                                    				<select name="gstvalid" id="gstvalid" class="select2-me input-large" required >
                                    					<option value="">-Select-</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                       
                                    				</select>
                                                    <script>document.getElementById('gstvalid').value = "<?php echo $gstvalid; ?>";</script>
                                    </td>
                          
                          </tr>
						  <tr>  <td width="11%"><strong>Account No: </strong></td>
                                    <td width="25%"><input type="text" name="account_no" value="<?php echo $account_no; ?>" id="chl_prefix" 
                          class="input-large" ></td> 
                          <td width="11%"> <strong>Bank Name :</strong></td>
						  <td width="25%"><input type="text" name="bank_name" value="<?php echo $bank_name; ?>" id="chl_prefix" 
                          class="input-large" ></td> 
                          
                          </tr>
						  <tr>  <td width="11%"><strong>Branch: </strong></td>
                                    <td width="25%"><input type="text" name="branch" value="<?php echo $branch; ?>" id="chl_prefix" 
                          class="input-large" ></td> 
                          <td width="11%"> <strong>IFSC Code:</strong></td>
						  <td width="25%"><input type="text" name="ifsc_code" value="<?php echo $ifsc_code; ?>" id="chl_prefix" 
                          class="input-large" ></td> 
                          
                          </tr>
						  
						  <tr>
									<td width="11%"> <strong>Logo</strong></td>
                                           <td>
                                    
                                             <input type="file" name="c_logo" id="c_logo" value=""  
                                               class="form-control"   	data-rule-maxlength="255"   autocomplete="off">
                                               <span><img src="logo/<?php echo $c_logo ?>" width="100px;" alt="<?php echo $c_logo; ?>" /></span>
										   </td>
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
                                            <th>Owner Name</th>
                                        	<th>Company Name</th>
                                            <th>Head Name</th>
                                            <th>Head Address</th>
                                            <th>Mobile1</th>
                                            <th>Address</th>
                                            <th>Logo</th>
                                            <th>GST No</th>
                                            <th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_company";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['ownername']);?></td>
                                            <td><?php echo ucfirst($row['cname']);?></td>
                                            <td><?php echo ucfirst($row['headname']);?></td>
                                            <td><?php echo ucfirst($row['headaddress']);?></td>
                                            <td><?php echo ucfirst($row['mobileno1']);?></td>
                                            <td><?php echo ucfirst($row['caddress']);?></td>
											<td><img src="logo/<?php echo $row['c_logo'];?>" width="100px"></td>
                                           
                                            <td><?php echo ucfirst($row['gst_no']);?></td>
                                            
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['compid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"  style="display:none"><img src="../img/del.png" title="Delete" ></a>
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
