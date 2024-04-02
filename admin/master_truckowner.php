<?php 
include("dbconnect.php");
$tblname = "m_truckowner";
$tblpkey = "ownerid";
$pagename = "master_truckowner.php";
$modulename = "Truck Owner";
$imgpath = "uploaded/pan_card/";
//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$ownerid=$_GET['edit'];
	$sql_edit="select * from m_truckowner where ownerid='$ownerid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$ownername = $row['ownername'];
			$owneraddress = $row['owneraddress'];
			$ac_number = $row['ac_number'];
			$mobileno1 = $row['mobileno1'];
			$bank_name = $row['bank_name'];
			$pan = $row['pan'];
			$ifsc_code = $row['ifsc_code'];

			$branch_name = $row['branch_name'];
			$stateid = $row['stateid'];
			$gstno = $row['gstno'];
			$owner_type = $row['owner_type'];
			$paytype = $row['paytype'];
      $tds_act = $row['tds_act'];
			$father_name = $row['father_name'];
			$imgname=  $row['imgname'];
		}//end while
	}//end if
}//end if
else
{
	$ownerid = 0;
	$ownername='';
	$father_name='';
	$owneraddress='';
	$mobileno1='';
	$pan='';
	$gstno='';
	$ac_number='';
	$bank_name='';
	$branch_name='';
	$ifsc_code='';
	$imgname='';
	$incdate = date('d-m-Y');
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$ownername = trim($_POST['ownername']);
	$owneraddress = $_POST['owneraddress'];
	$ac_number = $_POST['ac_number'];
	$mobileno1 = $_POST['mobileno1'];
	$bank_name = $_POST['bank_name'];
	$pan = $_POST['pan'];
	$ifsc_code = $_POST['ifsc_code'];
	$branch_name = $_POST['branch_name'];
	$stateid = $_POST['stateid'];
	$gstno = $_POST['gstno'];
	$owner_type = $_POST['owner_type'];
  $tds_act = $_POST['tds_act'];
    
	$paytype = $_POST['paytype'];
	$father_name = trim($_POST['father_name']);
	 $imgname= $_FILES['imgname'];
	// print_r($imgname);
	 
	if($ownerid==0)
	{
	//echo "select * from m_truckowner where ownername='$ownername' and ownerid <> '$ownerid'"; die;
		//check doctor existance
		$sql_chk = "select * from m_truckowner where ownername='$ownername' && father_name='$father_name' and ownerid <> '$ownerid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		//echo $cnt; die;
		if($cnt == 0)
		{
			
			 $sql_insert="insert into m_truckowner set ownername = '$ownername', owneraddress = '$owneraddress', father_name='$father_name',ac_number='$ac_number',paytype='$paytype',mobileno1='$mobileno1', bank_name='$bank_name', pan='$pan', ifsc_code='$ifsc_code', branch_name='$branch_name', stateid='$stateid', gstno='$gstno', owner_type='$owner_type', createdate=now(),tds_act='$tds_act',sessionid = '$_SESSION[sessionid]'"; 
	
			mysqli_query($connection,$sql_insert);
			echo "<script>location='master_truckowner.php?action=1'</script>";
			$keyvalue = mysqli_insert_id($connection);
				$uploaded_filename = uploadImage($imgpath,$imgname);			

			mysqli_query($connection,"update m_truckowner set imgname='$uploaded_filename' where ownerid='$keyvalue'");

			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		
		 $sql_update = "update  m_truckowner set ownername = '$ownername', owneraddress = '$owneraddress',father_name='$father_name',
		 ac_number='$ac_number', mobileno1='$mobileno1', bank_name='$bank_name', pan='$pan',paytype='$paytype',
		  ifsc_code='$ifsc_code', branch_name='$branch_name',stateid='$stateid', gstno='$gstno', tds_act='$tds_act',owner_type='$owner_type', lastupdated=now() where ownerid='$ownerid'"; 
		mysqli_query($connection,$sql_update);
			if($_FILES['imgname']['tmp_name']!="")

				{

					//delete old file

				//	$rowimg = mysqli_fetch_array(SelectDB($connection,$tblname,'1=1'));

					$oldimg = $rowimg["imgname"];

					if($oldimg != "")

					unlink("uploaded/pan_card/$oldimg");

					

					//insert new file

					$uploaded_filename = uploadImage($imgpath,$imgname);

					//$cmn->convert_image($uploaded_filename,"uploaded/slider","150","150");

					

					mysqli_query($connection,"update $tblname set imgname='$uploaded_filename' where $tblpkey='$ownerid'");

				}

		
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $ownerid,'updated');
		echo "<script>location='master_truckowner.php?action=2'</script>";
	}
}

?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

<script type="text/javascript">
        function ChangeTab () {
            var inputs = document.getElementsByTagName ("input");
            inputs[0].tabIndex = 3;
            inputs[1].tabIndex = 2;
            inputs[2].tabIndex = 1;
        }
    </script>
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
                                 <form  method="post" action="" enctype="multipart/form-data" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                <tr>
                                    <td><strong>Owner Name </strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="25%"><input type="text" name="ownername" id="ownername" value="<?php echo $ownername; ?>"
                                     autocomplete="off"  maxlength="120"  class="input-large"></td>
                                     <td><strong>Father's / Husband's Name:</strong></td>
                                     <td width="52%">
                    <input type="text" name="father_name" value="<?php echo $father_name; ?>" id="father_name"  class="input-large" >
                                    </td>                                   
                                 </tr>
                                  
                                
                                  <tr>
                                    <td width="12%"> <strong>Address :</strong></td>
                                    <td colspan="3">
                    				<input type="text" name="owneraddress" value="<?php echo $owneraddress; ?>" id="owneraddress" 
                                      class="input-xxlarge" >
                                    </td>
                                   </tr> 
                                  
                                   <tr>
                                   	  <td><strong>Mobile 1 :</strong></td>
                                     <td width="25%">
                                    <input type="text" name="mobileno1" value="<?php echo $mobileno1; ?>" id="ac_number" maxlength="10" 
                                 class="input-large" >
                                    </td>
                                   
                                    <td><strong>Pan No :</strong></td>
                                    <td width="52%">
                                    <input type="text" name="pan" maxlength="20" value="<?php echo $pan; ?>" id="pan" 
                                      class="input-large" >
                                    </td>
                                    
                                  </tr>
                                  
                                  <tr>
                                  	<td width="12%"><strong>Owner Type :</strong></td>
                                    <td width="25%"><select name="owner_type" id="owner_type" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        	<option value="self">Self</option> 
                                                            <option value="other">Other</option> 
                                    				</select>
                                                    <script>document.getElementById('owner_type').value = "<?php echo $owner_type; ?>";</script></td>
                                  
                                    <td><strong>GST No :</strong></td>
                                    <td width="52%">
                                    <input type="text" name="gstno" value="<?php echo $gstno; ?>" id="gstno" 
                                     class="input-large" >
                                    </td>
                                    
                                  </tr>
                                  
                                    <tr>
                                    <td width="12%"><strong>State Code :</strong></td>
                                    <td width="25%"><select name="stateid" id="stateid" class="select2-me input-large" >
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
                                    
                                    <td width="11%"><strong>A/C No. :</strong></td>
                                    <td ><input type="text" name="ac_number" id="ac_number" value="<?php echo $ac_number; ?>" autocomplete="off"  maxlength="20"   class="input-large"></td>
                                    
                                  </tr>
                                  <tr>
                                  
                                  		<td width="12%"><strong>Bank Name :</strong></td>
                                    <td ><input type="text" name="bank_name" id="bank_name" value="<?php echo $bank_name; ?>" autocomplete="off"  maxlength="120"  class="input-large" ></td>
                                    
                                     <td width="11%"><strong>Branch Name :</strong></td>
                                     <td ><input type="text" name="branch_name" id="branch_name" value="<?php echo $branch_name; ?>" autocomplete="off"  maxlength="120"  class="input-large"></td>
                                   
                                  </tr>
                                  <tr>
                                      <td width="12%"><strong>IfSC Code :</strong></td>
                                    <td ><input type="text" name="ifsc_code" id="ifsc_code" value="<?php echo $ifsc_code; ?>" autocomplete="off"  maxlength="20"  class="input-large" ></td>
                                                                     
                                    <td><strong>Payment Type :</strong></td>
                                    <td><select name="paytype" id="paytype" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        	<option value="Bilty Wise Payment">Bilty Wise Payment</option> 
                                                            <option value="Bulk Payment">Bulk Payment</option> 
                                    				</select>
                                                    <script>document.getElementById('paytype').value = "<?php echo $paytype; ?>";</script></td>
                                    
                                  </tr>
                                   
                                    <tr>                                   

                                    <td><strong>Upload Pancard</strong></td>

                       <td><input type="file" name="imgname"id="imgname"><img id="blah" alt="" style="width:100px;" title='Text Image' src='<?php if($imgname!="" && file_exists("uploaded/pan_card/".$imgname)){ echo "uploaded/pan_card/".$imgname; }?>'/>  </td> 

                                  
                                    
                                                                     
                                    <td >  Do You want to Active TDS ? </td>
                                    
                                     <td><select name="tds_act" id="tds_act" class="select2-me input-large" >
                                              <option value="">-Select-</option>
                                                          <option value="1">Yes</option> 
                                                            <option value="0">No</option> 
                                            </select>
                                                    <script>document.getElementById('tds_act').value = "<?php echo $tds_act; ?>";</script></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4"><span class="control-group">
                                    <div class="form-actions">
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('ownername al, ')" style="margin-left:140px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success"  onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    <?php            
									}
                                   else
								   {
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger"   style="margin-left:15px" onClick="document.location.href='<?php echo $pagename ; ?>';">
                                    <?php
                                   }
								   ?>
									</div>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </span></td>
                                    
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
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                <a href="excel_master_owner.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
							</div>
                            
                            
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck Owner</th>
                                            <th>Father Name</th>
                                        	<th>Adress</th>
                                            <th>Mobile</th>
                                            <th>PAN No</th>
                                           <th>Bank Name</th>
                                            <th>A/C Number</th>
                                        	<th>Branch</th>
                                            <th>IFSC Code</th>
                                            <th>Owner Type</th>
                                               <th>Pan Card</th>
                                            <th>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_truckowner order by ownerid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['ownername']);?></td>
                                            <td><?php echo ucfirst($row['father_name']);?></td>
                                            <td><?php echo ucfirst($row['owneraddress']);?></td>
                                            <td><?php echo $row['mobileno1'];?></td>
                                            <td><?php echo ucfirst($row['pan']);?></td>
                                              <td><?php echo ucfirst($row['bank_name']);?></td>
                                            <td><?php echo $row['ac_number'];?></td>
                                              <td><?php echo $row['branch_name'];?></td>
                                                 <td><?php echo $row['ifsc_code'];?></td>
                                            <td><?php echo ucfirst($row['owner_type']);?></td>
                                          <td>

                                          <?php if($row['imgname']!=""){ ?>

<a href="uploaded/pan_card/<?php echo $row['imgname'];?>" target="_blank" style="color:#F00; font-weight:bold">Download Pancard</a>

                                          <?php } else {  ?> Not Available <?php } ?>

                                          

                                          </td>
                                            <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['ownerid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
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