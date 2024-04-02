<?php
include("dbconnect.php");
$tblname = "m_employee";
$tblpkey = "empid";
$pagename = "master_employee.php";
$modulename = "Employee Master";

//print_r($_SESSION);
if (isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = 0;
if (isset($_GET['edit'])) {
	$empid = $_GET['edit'];
	$sql_edit = "select * from m_employee where empid='$empid'";
	$res_edit = mysqli_query($connection, $sql_edit);
	if ($res_edit) {
		while ($row = mysqli_fetch_array($res_edit)) {
			$empname = $row['empname'];
			$designation = $row['designation'];
			$doj = $cmn->dateformatindia($row['doj']);
			$salary = $row['salary'];
			$pfno = $row['pfno'];
			$esicno = $row['esicno'];
			$pan = $row['pan'];
			$acntno = $row['acntno'];
			$lisenceno = $row['lisenceno'];
			$lisenceissuedate = $cmn->dateformatindia($row['lisenceissuedate']);
			$lisenceexpiredate = $cmn->dateformatindia($row['lisenceexpiredate']);
			$compid = $row['compid'];
			$dateofbirth = $cmn->dateformatindia($row['dateofbirth']);
			$medicalexpire = $cmn->dateformatindia($row['medicalexpire']);
			$bloodgroup = $row['bloodgroup'];
			$mob1 = $row['mob1'];
			$mob2 = $row['mob2'];
			$address = $row['address'];
			$petrolallownce = $row['petrolallownce'];
			$address = $row['address'];
			$moballownce = $row['moballownce'];
			$esic_per = $row['esic_per'];
			$pf_per = $row['pf_per'];
			$status = $row['status'];
			$upload_aadhar = $row['upload_aadhar'];
			$upload_licence = $row['upload_licence'];
			$acc_holder_name = $row['acc_holder_name'];
			$acc_no = $row['acc_no'];
			$ifsc_code = $row['ifsc_code'];
			$bank_name = $row['bank_name'];
			$branch_name = $row['branch_name'];
			$acc_type = $row['acc_type'];
			$truckid = $row['truckid'];
		} //end while
	} //end if
} //end if
else {
	$empid = 0;
	$incdate = date('d-m-Y');
	$empname = '';
	$designation = '';
	$doj = '';
	$salary = '';
	$pfno = '';
	$esicno = '';
	$pan = '';
	$acntno = '';
	$lisenceno = '';
	$lisenceissuedate = '';
	$lisenceexpiredate = '';
	$compid = '';
	$truckid = '';
	$dateofbirth = '';
	$medicalexpire = '';
	$bloodgroup = '';
	$mob1 = '';
	$mob2 = '';
	$address = '';
	$petrolallownce = '';
	$address = '';
	$moballownce = '';
	$esic_per = '';
	$pf_per = '';
	$status = '';
	$upload_aadhar = '';
	$upload_licence = '';
	$acc_holder_name = '';
	$acc_no = '';
	$ifsc_code = '';
	$bank_name = '';
	$branch_name = '';
	$acc_type = '';
}
$duplicate = "";
if (isset($_POST['submit'])) {

	$empname = $_POST['empname'];
	$designation = $_POST['designation'];
	$doj = $cmn->dateformatindia($_POST['doj']);

	$salary = $_POST['salary'];
	//$pfno = $_POST['pfno'];
	$esicno = $_POST['esicno'];
	$pan = $_POST['pan'];
	$acntno = $_POST['acntno'];
	$lisenceno = $_POST['lisenceno'];
	$lisenceissuedate = $cmn->dateformatusa($_POST['lisenceissuedate']);
	$lisenceexpiredate = $cmn->dateformatusa($_POST['lisenceexpiredate']);
	$compid = $_POST['compid'];
	$dateofbirth = $cmn->dateformatusa($_POST['dateofbirth']);
	$medicalexpire = $cmn->dateformatusa($_POST['medicalexpire']);

	$mob1 = $_POST['mob1'];
	$mob2 = $_POST['mob2'];
	$address = $_POST['address'];
	$moballownce = $_POST['moballownce'];
	$petrolallownce = $_POST['petrolallownce'];
	$esic_per = $_POST['esic_per'];
	$pf_per = $_POST['pf_per'];
	$status = $_POST['status'];
	$upload_aadhar = $_FILES['upload_aadhar'];
	$upload_licence = $_FILES['upload_licence'];
	$acc_holder_name = $_POST['acc_holder_name'];
	$acc_no = $_POST['acc_no'];
	$ifsc_code = $_POST['ifsc_code'];
	$bank_name = $_POST['bank_name'];
	$branch_name = $_POST['branch_name'];
	$acc_type = $_POST['acc_type'];
	$truckid = $_POST['truckid'];

	if ($empid == 0) {

		//check doctor existance
		$sql_chk = "select * from m_employee where empname='$empname' and compid = '$compid'";
		$res_chk = mysqli_query($connection, $sql_chk);
		$cnt = mysqli_num_rows($res_chk);

		if ($cnt == 0) {
		
			$sql_insert = "insert into m_employee set empname = '$empname',designation='$designation', doj='$doj', 
			 salary='$salary',esicno='$esicno', pan='$pan', 
			 acntno='$acntno',lisenceno = '$lisenceno',lisenceissuedate='$lisenceissuedate', lisenceexpiredate='$lisenceexpiredate', 
			 compid='$compid',truckid='$truckid', dateofbirth = '$dateofbirth',medicalexpire='$medicalexpire', bloodgroup='$bloodgroup', 
			 mob1='$mob1', mob2='$mob2', address='$address', acc_holder_name='$acc_holder_name', acc_no='$acc_no', ifsc_code='$ifsc_code', bank_name='$bank_name', branch_name='$branch_name', acc_type='$acc_type', esic_per='$esic_per', pf_per='$pf_per', moballownce='$moballownce',
			 petrolallownce='$petrolallownce',status='$status', createdate=now(),sessionid = '$_SESSION[sessionid]'";

			mysqli_query($connection, $sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection, $pagename, $modulename, $tblname, $tblpkey, $keyvalue, 'insert');
			$imgpath2 = "uploaded/emp_aadhar/";
			$imgpath3 = "uploaded/emp_licence/";
			$uploaded_filename1 = uploadImage($imgpath2, $upload_aadhar);
			$uploaded_filename2 = uploadImage($imgpath3, $upload_licence);

			if ($_FILES['upload_aadhar']['tmp_name'] != "") {

				//delete old file
				$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
				$rowimg = mysqli_fetch_array($sql);

				$oldimg = $rowimg["upload_aadhar"];
				if ($oldimg != "") {
					unlink("uploaded/emp_aadhar/$oldimg");
				}
				$imgpath = "uploaded/emp_aadhar/";
				//insert new file
				$uploaded_filename = uploadImage($imgpath, $upload_aadhar);
				// echo "update $tblname set upload_aadhar='$uploaded_filename1' where $tblpkey='$keyvalue'";
				mysqli_query($connection, "update $tblname set upload_aadhar='$uploaded_filename1' where $tblpkey='$keyvalue'");
			}

			if ($_FILES['upload_licence']['tmp_name'] != "") {

				//delete old file
				$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
				$rowimg = mysqli_fetch_array($sql);

				$oldimg1 = $rowimg["upload_licence"];
				if ($oldimg1 != "") {
					unlink("uploaded/emp_licence/$oldimg1");
				}
				$imgpath4 = "uploaded/emp_licence/";
				//insert new file
				$uploaded_filename3 = uploadImage($imgpath4, $upload_licence);

				mysqli_query($connection, "update $tblname set upload_licence='$uploaded_filename2' where $tblpkey='$keyvalue'");
			}
			echo "<script>location='master_employee.php?action=1'</script>";
		} else
			$duplicate = "* Duplicate entry .... Data can not be saved!";
	} else {
		if ($_FILES['upload_aadhar']['tmp_name'] != "") {

			//delete old file
			$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
			$rowimg = mysqli_fetch_array($sql);

			$oldimg = $rowimg["upload_aadhar"];
			if ($oldimg != "") {
				unlink("uploaded/emp_aadhar/$oldimg");
			}
			$imgpath = "uploaded/emp_aadhar/";
			//insert new file
			$uploaded_filename = uploadImage($imgpath, $upload_aadhar);

			mysqli_query($connection, "update $tblname set upload_aadhar='$uploaded_filename' where $tblpkey='$keyvalue'");
		}

		if ($_FILES['upload_licence']['tmp_name'] != "") {

			//delete old file
			$sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
			$rowimg = mysqli_fetch_array($sql);

			$oldimg1 = $rowimg["upload_licence"];
			if ($oldimg1 != "") {
				unlink("uploaded/emp_licence/$oldimg1");
			}
			$imgpath4 = "uploaded/emp_licence/";
			//insert new file
			$uploaded_filename3 = uploadImage($imgpath4, $upload_licence);

			mysqli_query($connection, "update $tblname set upload_licence='$uploaded_filename3' where $tblpkey='$keyvalue'");
		}
		$sql_update = "update  m_employee set empname = '$empname',designation='$designation', doj='$doj', 
			 salary='$salary',esicno='$esicno', pan='$pan', 
			 acntno='$acntno',lisenceno = '$lisenceno',lisenceissuedate='$lisenceissuedate', lisenceexpiredate='$lisenceexpiredate', 
			 compid='$compid',truckid='$truckid', dateofbirth = '$dateofbirth',medicalexpire='$medicalexpire', bloodgroup='$bloodgroup', 
			 mob1='$mob1', mob2='$mob2',address='$address', acc_holder_name='$acc_holder_name', acc_no='$acc_no', ifsc_code='$ifsc_code', bank_name='$bank_name', branch_name='$branch_name', acc_type='$acc_type',  moballownce='$moballownce', petrolallownce='$petrolallownce',
			 esic_per='$esic_per', pf_per='$pf_per',status='$status', lastupdated=now() where empid='$empid'";
		mysqli_query($connection, $sql_update);
		$keyvalue = $empid;
		$cmn->InsertLog($connection, $pagename, $modulename, $tblname, $tblpkey, $keyvalue, 'updated');
		echo "<script>location='master_employee.php?action=2'</script>";
	}
}

?>
<!doctype html>
<html>

<head>
	<?php include("../include/top_files.php"); ?>
	<?php include("alerts/alert_js.php"); ?>
	<style>
		a.selected {
			background-color: #1F75CC;
			color: white;
			z-index: 100;
		}

		.messagepop {
			background-color: #0CF;
			border: 2px solid #000;
			cursor: default;
			display: none;
			border-radius: 5px;
			position: fixed;
			top: 50px;
			right: 0px;
			text-align: left;
			width: 230px;
			z-index: 50;

		}

		.messagepop p,
		.messagepop.div {
			border-bottom: 1px solid #EFEFEF;
			margin: 8px 0;
			padding-bottom: 8px;
		}
	</style>
	<script>
		$(document).ready(function() {
			$("#shortcut_placeid").click(function() {
				$("#div_placeid").toggle(1000);
			});
		});
	</script>
</head>

<body>
	<!--- short cut form place --->
	<div class="messagepop pop" id="div_placeid">
		<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
		<table width="100%" border="0" class="table table-bordered table-condensed">
			<tr>
				<td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place</strong></td>
			</tr>
			<tr>
				<td>&nbsp;Unit Name: </td>
			</tr>
			<tr>
				<td><input type="text" name="placename" id="placename" class="input-medium" style="width:190px ; border:1px dotted #666" /></td>
			</tr>

			<tr>
				<td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_placename();" /></td>
			</tr>
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
								<form method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('empname al,designation,mob1 nu')" enctype="multipart/form-data">
									<div class="control-group">
										<table>
											<tr>
												<td colspan="4" class="text-error"><strong><?php echo $duplicate; ?></strong></td>
											</tr>
											<tr>
												<td width="18%">Employee Name <span style="color:#F00">*</span></td>
												<td width="23%"><input class="frmsave formbox" type="text" id="empname" data-required="true" name="empname" tabindex="1" value="<?php echo $empname; ?>"></td>
												<td width="20%">Designation<span style="color:#F00">*</span></td>
												<td width="17%">

													<select name="designation" id="designation" class="formbox" tabindex="2" value="<?php echo $designation; ?>">
														<option> - Select - </option>
														<option value="1">Driver</option>
														<option value="2">Conductor</option>
														<option value="3">Office Staff</option>
														<option value="4">Owner</option>
													</select>
													<script>
														document.getElementById('designation').value = '<?php echo $designation; ?>';
													</script>
												</td>
												</td>
											</tr>
											<tr>
												<td width="18%">Date Of Joining<span class="red"> (dd-mm-yyyy)</span> </td>
												<td width="23%"><input class="frmsave formbox" type="text" name="doj" id="doj" placeholder="dd-mm-yyyy" data-date="true" tabindex="3" value="<?php echo $doj; ?>"></td>
												<td width="18%" valign="top">Blood Group</td>
												<td valign="top">
													<!--<input class="frmsave formbox " type="hidden" name="bloodgroup" id="bloodgroup" data-type="select" value="<?php // echo $; 
																																									?>" />-->
													<select class="formbox" name="bloodgroup" id="bloodgroup" tabindex="4">
														<option> - Select - </option>
														<option value="A+">A+</option>
														<option value="A-">A-</option>
														<option value="B+">B+</option>
														<option value="B-">B-</option>
														<option value="O+">O+</option>
														<option value="O-">O-</option>
														<option value="AB+">AB+</option>
														<option value="AB-">AB-</option>
													</select>
													<script>
														document.getElementById('bloodgroup').value = '<?php echo $bloodgroup; ?>';
													</script>
												</td>
												</td>

											</tr>
											<tr>
												<td style="display: none;">ESIC No</td>
												<td style="display: none;"><input class="frmsave formbox" type="text" name="esicno" id="esicno" maxlength="20" tabindex="5" value="<?php echo $esicno; ?>"></td>
												<td>PAN</td>
												<td><input class="frmsave formbox" type="text" name="pan" id="pan" tabindex="6" value="<?php echo $pan; ?>"></td>
												<td>Lisence No</td>
												<td><input class="frmsave formbox" type="text" name="lisenceno" id="lisenceno" maxlength="20" tabindex="7" value="<?php echo $lisenceno; ?>"></td>
											</tr>
											<tr>

												<td>Lisence Issue Date<span class="red"> (dd-mm-yyyy)</span></td>
												<td><input class="frmsave formbox" type="text" name="lisenceissuedate" id="lisenceissuedate" placeholder="dd-mm-yyyy" data-date="true" tabindex="8" value="<?php echo $lisenceissuedate; ?>"></td>
												<td>Lisence Expire Date<span class="red"> (dd-mm-yyyy)</span></td>
												<td><input class="frmsave formbox" type="text" name="lisenceexpiredate" id="lisenceexpiredate" placeholder="dd-mm-yyyy" tabindex="9" data-date="true" value="<?php echo $lisenceexpiredate; ?>" /></td>
											</tr>
											<tr>

												<td>Company Name <span style="color:#F00">*</span></td>
												<td>
													<select name="compid" id="compid" tabindex="10" value="<?php echo $compid; ?>"require>
														<option>-Select-</option>
														<?php
														$sql_cust = "select * from m_company";
														$res_cust = mysqli_query($connection, $sql_cust);
														while ($row_cust = mysqli_fetch_array($res_cust)) {
														?>
															<option value="<?php echo $row_cust['compid']; ?>"><?php echo $row_cust['cname']; ?></option>
														<?php
														}
														?>
													</select>
													<script>
														document.getElementById('compid').value = <?php echo $compid; ?>
													</script>

												</td>
												<td>Truck No.<span style="color:#F00">*</span></td>
												<td>
													<select data-placeholder="Choose a Country..." name="truckid" id="truckid" style="width:220px" tabindex="3" class="formcent select2-me" required>

														<option value=""> - Select - </option>
														<?php
														$sql_fdest = mysqli_query($connection, "select truckid,truckno from m_truck");
														while ($row_fdest = mysqli_fetch_array($sql_fdest)) {
														?>
															<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
														<?php
														} ?>
													</select>
													<script>
														document.getElementById('truckid').value = '<?php echo $truckid; ?>';
													</script>

												</td>




											</tr>
											<tr>

												<td valign="top" style="display: none;">Medical Expire Date<span class="red">(dd-mm-yyyy)</span></td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" type="text" name="medicalexpire" id="medicalexpire" placeholder="dd-mm-yyyy" data-date="true" tabindex="12" value="<?php echo $medicalexpire; ?>" /></td>
											</tr>
											<tr>
												<td valign="top">Date of Birth<span class="red">(dd-mm-yyyy)</span></td>
												<td valign="top"><input class="frmsave formbox" type="text" name="dateofbirth" id="dateofbirth" placeholder="dd-mm-yyyy" tabindex="11" data-date="true" value="<?php echo $dateofbirth; ?>" /></td>
												<td valign="top">Mobile(1)<span style="color:#F00">*</span></td>
												<td valign="top"><input class="frmsave formbox" type="text" name="mob1" id="mob1" tabindex="13" maxlength="10" value="<?php echo $mob1; ?>" /></td>

											</tr>
											<tr>
												<td valign="top">Mobile(2)</td>
												<td><input class="frmsave formbox" type="text" id="mob2" name="mob2" tabindex="14" maxlength="10" value="<?php echo $mob2; ?>" /></td>
												<td>Salary</td>
												<td><input class="frmsave formbox" type="text" name="salary" id="salary" tabindex="15" value="<?php echo $salary; ?>"></td>
												<td valign="top" style="display: none;">Bank A/C no.</td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" name="acntno" type="text" id="acntno" maxlength="20" tabindex="19" value="<?php echo $acntno; ?>" /></td>


											</tr>
											<tr>
												<td valign="top" style="display: none;">Petrol Allowance</td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" name="petrolallownce" type="text" id="petrolallownce" tabindex="17" value="<?php echo $petrolallownce; ?>" /></td>
												<td valign="top" style="display: none;">Mobile Allowance</td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" name="moballownce" type="text" id="moballownce" tabindex="18" value="<?php echo $moballownce; ?>" /></td>
											</tr>
											<tr>
												<td valign="top" style="display: none;">PF(%)</td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" name="pf_per" type="text" id="pf_per" tabindex="19" value="<?php echo $pf_per; ?>" /></td>
												<td valign="top" style="display: none;">ESIC(%)</td>
												<td valign="top" style="display: none;"><input class="frmsave formbox" name="esic_per" type="text" id="esic_per" tabindex="20" value="<?php echo $esic_per; ?>" /></td>
											</tr>
											<tr>


												<td valign="top">Address</td>
												<td><textarea class="frmsave formarea" name="address" id="address" tabindex="16"><?php echo $address; ?></textarea></td>
												<td valign="top">Aadhar No.</td>
												<td valign="top"><input type="file" name="upload_aadhar" id="upload_aadhar" placeholder="Text input" class="form-control" value="<?php echo $upload_aadhar; ?>"></td>

											</tr>
											<tr>

												<td valign="top">Licence No.</td>
												<td valign="top"> <input type="file" name="upload_licence" id="upload_licence" placeholder="Text input" class="form-control" value="<?php echo $upload_licence; ?>">
												</td>
											</tr>

										</table>
										<div class="box-title">

											<h5 style="font-weight: bold; color: red">Bank Details</h5>

										</div>
									</div>
									<div class="control-group">
										<table>

											<tr>
												<td width="18%">Account Holder Name<span style="color:#F00">*</span></td>
												<td width="23%"> <input type="text" name="acc_holder_name" id="acc_holder_name" placeholder="Enter Name" tabindex="15" class="form-control" value="<?php echo $acc_holder_name; ?>">
												</td>
												<td width="20%">A/C No.<span style="color:#F00">*</span></td>
												<td width="17%">

													<input type="text" name="acc_no" id="acc_no" placeholder="Account Number" tabindex="16" class="form-control" value="<?php echo $acc_no; ?>" maxlength="16">

												</td>
											</tr>
											<tr>
												<td width="18%">IFSC Code</td>
												<td width="23%"> <input type="text" name="ifsc_code" id="ifsc_code" placeholder="Ifsc Code" tabindex="18" class="form-control" value="<?php echo $ifsc_code; ?>" maxlength="15">
												</td>
												<td width="18%" valign="top">Bank Name</td>
												<td valign="top">
													<!--<input class="frmsave formbox " type="hidden" name="bloodgroup" id="bloodgroup" data-type="select" value="<?php // echo $; 
																																									?>" />-->
													<input type="text" name="bank_name" id="bank_name" placeholder="Bank Name" tabindex="19" class="form-control" value="<?php echo $bank_name; ?>">


												</td>

											</tr>
											<tr>
												<td>Branch Name</td>
												<td> <input type="text" name="branch_name" id="branch_name" placeholder="Branch Name" tabindex="20" class="form-control" value="<?php echo $branch_name; ?>">
												</td>
												<td>Account Type</td>
												<td> <select name="acc_type" id="acc_type" tabindex="21" class='form-control'>
														<option value="">Select</option>
														<option value="Saving">Saving</option>
														<option value="Current">Current</option>
													</select>
													<script>
														document.getElementById('acc_type').value = '<?php echo $acc_type; ?>';
													</script>
												</td>

											</tr>


											<tr>

												<td valign="top">Status</td>
												<td valign="top">
													<select name="status" id="status" tabindex="10" value="<?php echo $status; ?>">
														<option value="0">In-Active</option>
														<option value="1">Active</option>
													</select>
													<script>
														document.getElementById('status').value = '<?php echo $status; ?>';
													</script>
												</td>

											</tr>



											</tr>
											<tr>
												<td colspan="4" style="line-height:5">
													<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('consigneename,placeid')" tabindex="20" style="margin-left:515px">

													<input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename; ?>';" tabindex="9" />


													<input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>">
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
								<a href="excel_master_employee.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>


							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered table-condensed table-striped">
									<thead>
										<tr>
											<th>Sno</th>
											<th>Employee Name</th>
											<th>Mobile</th>
											<th>Designation</th>
											<th>Date of Joining</th>
											<th>Sallary</th>
											<th>Company Name</th>
											<th>Truck No</th>
											<th>Blood Group</th>
											<th>Uploaded Aadhar</th>
											<th>Uploaded Licence</th>
											<th>Status</th>
											<th class='hidden-480'>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$slno = 1;
										$sel = "select * from m_employee where empid != '-1' order by empid desc";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_array($res)) {
											if ($row['designation'] == 1) {
												$designation = "Driver";
											} else {
												if ($row['designation'] == 2) {
													$designation = "Conductor";
												} else {
													if ($row['designation'] == 3) {
														$designation = "Office Staff";
													}
												}
											}
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo $row['empname']; ?></td>
												<td><?php echo $row['mob1']; ?></td>
												<td><?php echo $designation; ?></td>
												<td><?php echo $cmn->dateformatindia($row['doj']); ?></td>
												<td><?php echo $row['salary']; ?></td>

												<td><?php echo  $cmn->getvalfield($connection, "m_company", "cname", "compid=$row[compid]"); ?></td>
												<td><?php echo  $cmn->getvalfield($connection, "m_truck", "truckno", "truckid=$row[truckid]"); ?></td>

												<td><?php echo $row['bloodgroup']; ?></td>

												<td><b><a href="uploaded/emp_aadhar/<?php echo $row['upload_aadhar'] ?>" class="text-danger" target="_blank" download>Download</a></b></td>
												<td><b><a href="uploaded/emp_licence/<?php echo $row['upload_licence'] ?>" class="text-danger" target="_blank" download>Download</a></b></td>


												</head>

												<body>




													<td><strong style="color:red;">
															<?php
															$status = $row['status'];
															if ($status == 0) {
																$status = '<span >In-Active</span>';
															} else {
																$status = '<span style=color:green;> Active</span>';
															}
															echo  $status;
															?>
														</strong></td>

													<td class='hidden-480'>
														<a href="?edit=<?php echo ucfirst($row['empid']); ?>"><img src="../img/b_edit.png" title="Edit"></a>
														&nbsp;&nbsp;&nbsp;
														<a onClick="funDel('<?php echo $row['empid']; ?>')"><img src="../img/del.png" title="Delete"></a>
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
		function funDel(id) {
			//alert(id);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblname);
			if (confirm("Are you sure! You want to delete this record.")) {
				//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
				$.ajax({
					type: 'POST',
					url: '../ajax/delete.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						//alert(data);
						//alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}
				}); //ajax close
			} //confirm close
		} //fun close
		function hideval() {
			var paymode = document.getElementById('paymode').value;
			if (paymode == 'cash') {
				document.getElementById('checquenumber').disabled = true;
				document.getElementById('bankname').disabled = true;
				document.getElementById('checquenumber').value = "";
				document.getElementById('bankname').value = "";
			} else {
				document.getElementById('checquenumber').disabled = false;
				document.getElementById('bankname').disabled = false;
			}
		}
	</script>
	<script>
		function ajax_save_placename() {
			var placename = document.getElementById('placename').value;
			//alert(placename);
			if (placename == "") {
				alert('Please Fill place name');
				document.getElementById('placename').focus();
				return false;
			}

			if (window.XMLHttpRequest) {
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp = new XMLHttpRequest();
			} else { // code for IE6, IE5
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					if (xmlhttp.responseText != '') {
						//alert('This specification already exist');
						//alert( xmlhttp.responseText);
						document.getElementById("placeid").innerHTML = xmlhttp.responseText;

						document.getElementById("placename").value = "";
						$("#div_placeid").hide(1000);

					}
				}
			}
			xmlhttp.open("GET", "ajax_saveplace.php?placename=" + placename, true);
			xmlhttp.send();
		}
	</script>
	<script>
		function upload_image(id) {
			$('#' + id).click();
		}

		function delete_image(id) {
			if ($('#' + id).val() != "") {
				ajaxManager.addReq({
					type: 'POST',
					url: 'delete_file.php',
					data: {
						file_name: "" + $('#' + id).val()
					},
					success: function(data) {
						$('#' + id).val("");
						$('#' + id).change();
					}
				});
			}
		}
		$(document).ready(function() {
			// must keep draw_table();
			$("#empname").focus();
			draw_table();
			$("#save").click(function() {
				if ($("input#<?php echo $tablekey; ?>").val().length > 0) {
					save("<?php echo $tablename; ?>", "<?php echo $tablekey; ?>", "frmsave", "update");
				} else {
					save("<?php echo $tablename; ?>", "<?php echo $tablekey; ?>", "frmsave", "");
				}
			});
			$("#reset").click(function() {
				draw_table();
				$("img.preview").attr("src", "350x150.jpg");
				$("img.preview1").attr("src", "not_availabe.png");
				$("img.preview2").attr("src", "not_availabe.png");
				$("img.preview3").attr("src", "not_availabe.png");
				$("img.preview4").attr("src", "not_availabe.png");
				$("img.preview5").attr("src", "not_availabe.png");
				$("#empname").focus();
			});
			// upload
			$('#e_photo').live('change', function() {
				$("#preview").html('');
				$("#preview").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform").ajaxForm({
					target: '#preview',
					success: showResponse
				}).submit();
			});

			$('#e_photo1').live('change', function() {
				$("#preview1").html('');
				$("#preview1").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform1").ajaxForm({
					target: '#preview1',
					success: showResponse1
				}).submit();
			});

			$('#e_photo2').live('change', function() {
				$("#preview2").html('');
				$("#preview2").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform2").ajaxForm({
					target: '#preview2',
					success: showResponse2
				}).submit();
			});

			$('#e_photo3').live('change', function() {
				$("#preview3").html('');
				$("#preview3").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform3").ajaxForm({
					target: '#preview3',
					success: showResponse3
				}).submit();
			});

			$('#e_photo4').live('change', function() {
				$("#preview4").html('');
				$("#preview4").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform4").ajaxForm({
					target: '#preview4',
					success: showResponse4
				}).submit();
			});

			$('#e_photo5').live('change', function() {
				$("#preview5").html('');
				$("#preview5").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
				$("#imageform5").ajaxForm({
					target: '#preview5',
					success: showResponse5
				}).submit();
			});
			// Apply changes
			$("#photo").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview").html('<img src="350x150.jpg" class="preview" >');
			});
			$("#doc1").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview1").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview1").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview1").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview1").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview1").html('<img src="not_availabe.png" class="preview" >');
			});
			$("#doc2").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview2").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview2").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview2").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview2").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview2").html('<img src="not_availabe.png" class="preview" >');
			});
			$("#doc3").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview3").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview3").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview3").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview3").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview3").html('<img src="not_availabe.png" class="preview" >');
			});
			$("#doc4").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview4").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview4").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview4").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview4").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview4").html('<img src="not_availabe.png" class="preview" >');
			});
			$("#doc5").change(function() {
				if ($(this).val() != "") {
					var value = $(this).val();
					var ext = value.split(".");
					if (ext[1] == "pdf") {
						$("#preview5").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "doc") {
						$("#preview5").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else if (ext[1] == "xls" || ext[1] == "xlsx") {
						$("#preview5").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
					} else {
						$("#preview5").html('<img src="' + $(this).val() + '" class="preview" height="150" width="120" alt="Employee Photo"/>');
					}
				} else
					$("#preview5").html('<img src="not_availabe.png" class="preview" >');
			});
		});
		// Response
		function showResponse(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(0)")) {
				$("#photo").val($("img.preview:eq(0)").attr("src"));
			}
		}

		function showResponse1(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(1)")) {
				$("#doc1").val($("img.preview:eq(1)").attr("src"));
			}
		}

		function showResponse2(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(2)")) {
				$("#doc2").val($("img.preview:eq(2)").attr("src"));
			}
		}

		function showResponse3(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(3)")) {
				$("#doc3").val($("img.preview:eq(3)").attr("src"));
			}
		}

		function showResponse4(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(4)")) {
				$("#doc4").val($("img.preview:eq(4)").attr("src"));
			}
		}

		function showResponse5(responseText, statusText, xhr, $form) {
			if ($("img.preview:eq(5)")) {
				$("#doc5").val($("img.preview:eq(5)").attr("src"));
			}
		}
	</script>
</body>

</html>
<?php
mysqli_close($connection);
?>