<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "items";
$tblpkey = "itemid";
$pagename = "master_item_inv.php";
$modulename = "Item Master";

//print_r($_SESSION);

if (isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = 0;

if (isset($_GET['edit'])) {
	$itemid = $_GET['edit'];
	$sql_edit = "select * from items where itemid='$itemid'";
	$res_edit = mysqli_query($connection, $sql_edit);
	if ($res_edit) {
		while ($row = mysqli_fetch_array($res_edit)) {

			$itemcatid = $row['itemcatid'];
			$item_name = $row['item_name'];
		 	$unitid = $row['unitid'];
			$unit_messure = $row['unit_messure'];
			$hsncode = $row['hsncode'];
				$serial_no = $row['serial_no'];
			
		} //end while
	} //end if
} //end if
else {

	$item_name = '';
	$item_name = '';
	$unitid = '';
	$unit_messure = '';
	$hsncode = '';
		$serial_no = '';
	
}

$duplicate = "";
if (isset($_POST['submit'])) {

	$itemcatid = $_POST['itemcatid'];
	$item_name = $_POST['item_name'];
	$unitid = $_POST['unitid'];
	$unit_messure = $_POST['unit_messure'];
	$hsncode = $_POST['hsncode'];
		$serial_no = $_POST['serial_no'];

	if ($itemid == 0) {
		//check doctor existance
		$sql_chk = "select * from items where item_name='$item_name'";
		$res_chk = mysqli_query($connection, $sql_chk);
		$cnt = mysqli_num_rows($res_chk);

		if ($cnt == 0) {
			//echo "insert into items set itemcatid = '$itemcatid', item_name = '$item_name', unitid = '$unitid', unit_messure = '$unit_messure',hsncode = '$hsncode', sessionid = '$_SESSION[sessionid]'";die;
			$sql_insert = "insert into items set itemcatid = '$itemcatid', item_name = '$item_name', serial_no = '$serial_no', unitid = '$unitid', unit_messure ='$unit_messure', hsncode = '$hsncode', sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection, $sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection, $pagename, $modulename, $tblname, $tblpkey, $keyvalue, 'insert');
			echo "<script>location='master_item_inv.php?action=1'</script>";
		} else
			$duplicate = "* Duplicate entry .... Data can not be saved!";
	} else {
		$sql_update = "update  items set itemcatid = '$itemcatid', item_name = '$item_name', serial_no = '$serial_no',  unitid = '$unitid', unit_messure = '$unit_messure',hsncode = '$hsncode' where itemid='$itemid'";
		mysqli_query($connection, $sql_update);
		$cmn->InsertLog($connection, $pagename, $modulename, $tblname, $tblpkey, $itemid, 'updated');
		echo "<script>location='master_item_inv.php?action=2'</script>";
	}
}
?>
<!doctype html>
<html>

<head>
	<?php include("../include/top_files.php"); ?>
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
								<form method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('placename')">
									<div class="control-group">
										<table class="table table-condensed" style="width:60%;">
											<tr>
												<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
											</tr>

											<tr>
												<td><strong>Category Name</strong> <strong>:</strong><span class="red">*</span></td>
												<td>

													<select name="itemcatid" id="itemcatid" required class="select2-me input-medium" style="width: 230px;">
														<option>-Select-</option>
														<?php
														$sql_cust = "select * from item_categories";
														$res_cust = mysqli_query($connection, $sql_cust);
														while ($row_cust = mysqli_fetch_array($res_cust)) {
														?>
															<option value="<?php echo $row_cust['itemcatid']; ?>"><?php echo $row_cust['item_category_name']; ?></option>
														<?php
														}
														?>
													</select>
													<script>
														document.getElementById('itemcatid').value = <?php echo $itemcatid; ?>
													</script>


												</td>

												<td><strong>Item Name</strong> <strong>:</strong><span class="red">*</span></td>
												<td><input type="text" name="item_name" id="item_name" value="<?php echo $item_name; ?>" autocomplete="off" maxlength="120" tabindex="1" class="input-large" required></td>

	</tr>
	<tr>

												<td><strong>Select Unit</strong> <strong>:</strong><span class="red">*</span></td>
												<td>
											    <select name="unitid" id="unitid" class="formcent select2-me"style="width:230px;">
														<option>-Select-</option>
														<?php
														$sql_cust = "select * from m_unit";
														$res_cust = mysqli_query($connection, $sql_cust);
														while ($row_cust = mysqli_fetch_array($res_cust)) {
														?>
															<option value="<?php echo $row_cust['unitid']; ?>"><?php echo $row_cust['unitname']; ?></option>
														<?php
														}
														?>
													</select>
													<script>
													       document.getElementById('unitid').value = '<?php echo $unitid ; ?>';
													
													</script>
												</td>


												<td><strong>HSN Code</strong> </td>
												<td>
												<input type="text" name="hsncode" id="hsncode" value="<?php echo $hsncode; ?>" autocomplete="off" maxlength="4" tabindex="1" class="input-large">
								
												</tr>	
												<tr>
											</td>
											
											<!--	<td><strong>Serial No.</strong> </td>-->
											<!--	<td>-->
											<!--	<input type="text" name="serial_no" id="serial_no" value="<?php echo $serial_no; ?>" autocomplete="off" maxlength="120" tabindex="1" class="input-large">-->
								
												
											<!--</td>-->
											</tr>




											</tr>



											<tr>
												


											</tr>
											<tr>

											<td colspan="4" style="line-height:5">

													<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('placename')" tabindex="10" style="margin-left:360px">
													<?php if (isset($_GET['edit']) && $_GET['edit'] !== "") { ?>
														<input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename; ?>';" tabindex="9" />

													<?php
													} else {

													?> <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename; ?>';">
													<?php
													}
													?>

													<input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>">
													</span>
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
				<div class="row-fluid" id="list" style="display:none;">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th width="10%">Sno</th>
											<th width="40%">Category Name</th>
											<th width="40%">Item Name</th>
											<th width="40%"> Unit</th>
											
											
											<th width="40%">HSN Code </th>
	                                           
											<th class='hidden-480' width="10%">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$slno = 1;
										$sel = "select * from items order by itemid  desc";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_array($res)) {
											$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");
											$unitname = $cmn->getvalfield($connection, "m_unit", "unitname", "unitid='$row[unitid]'");

										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo ucfirst($item_category_name); ?></td>
												<td><?php echo ucfirst($row['item_name']); ?></td>
												<td><?php echo ucfirst($unitname); ?></td>
											
												<td><?php echo $row['hsncode']; ?></td>
											
												<td class='hidden-480'>
													<a href="?edit=<?php echo ucfirst($row[$tblpkey]); ?>"><img src="../img/b_edit.png" title="Edit"></a>
													&nbsp;&nbsp;&nbsp;
													<a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"><img src="../img/del.png" title="Delete"></a>
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
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: '../ajax/delete.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						// alert('Data Deleted Successfully');
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