<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "purchase_report.php";
$modulename = "Truck Document Report";

$tblname = "truckupload";
$tblpkey = "tmaintance_id";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$purchase_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if (isset($_GET['truckid'])) {
	$truckid  = trim(addslashes($_GET['truckid']));
} else
	$truckid = '';

if (isset($_GET['docid'])) {
	$docid  = trim(addslashes($_GET['docid']));
} else
	$docid = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= "   issuedate   between '$fromdate' and '$todate'";
}

if ($truckid != '') {
	$crit .= " and truckid ='$truckid'";
}
if ($docid != '') {
	$crit .= " and docid ='$docid'";
}
if ($_GET['purchaseid'] != "") {

	// echo "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid";
	mysqli_query($connection, "update purchase_entry  set is_complete=0  where is_complete=1 and purchaseid='$purchaseid");
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
				<!--  Basics Forms -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
								<?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i>Truck Document Report</h3>
								<a href="truck_permanent_document.php" class="btn btn-success" style="float:right;">Add New</a>
								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
						
								<div class="control-group">
									<table class="table table-condensed">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<td><strong>From Date</strong></th>
											<td><strong> To Date</strong></th>
											<td> <strong>Truck No. </strong></td>
											<td> <strong>Document </strong></td>
											<td> <strong>Action </strong></td>



										</tr>
										<tr>

											<td style="width:15%"><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="1" value="<?php echo $fromdate; ?>" /> </td>
											<td style="width:15%"><input type="date" name="todate" id="todate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="2" value="<?php echo $todate; ?>" /> </td>
											<td style="width:15%">
												<select data-placeholder="Choose a Country..." name="truckid" id="truckid" style="width:200px" tabindex="3" class="formcent select2-me">
													<option value="">Select </option>
													<?php
													$sql = mysqli_query($connection, "select * from  m_truck order by truckid");
													while ($row = mysqli_fetch_array($sql)) {

													?>
														<option value="<?php echo $row['truckid']; ?>"><?php echo $row['truckno']; ?></option>

													<?php } ?>
													<script>
														document.getElementById('truckid').value = '<?php echo $truckid; ?>';
													</script>

											</td>

<td style="width:15%">
                                <select data-placeholder="Choose a Country..." name="docid" id="docid" style="width:200px" tabindex="3" class="formcent select2-me">
													<option value="">Select </option>
													<?php
													$sql = mysqli_query($connection, "select * from  doc_category_master order by docid");
													while ($row = mysqli_fetch_array($sql)) {

													?>
														<option value="<?php echo $row['docid']; ?>"><?php echo $row['doc_name']; ?></option>

													<?php } ?>
													<script>
														document.getElementById('docid').value = '<?php echo $docid; ?>';
													</script>

                                 
                                 </td>
											
											<center>
										    <td >
											
                        <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                      </td>
													</center>

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
							<!--<a class="btn btn-primary btn-lg" href="excel_purchase_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&sup_id=<?php echo $sup_id; ?>&bill_type=<?php echo $bill_type; ?>" target="_blank" style="float:right;"> Excel </a>-->
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>
										
                                                <th> Document </th>
											
												<th>Issue date. </th>
                                            <th> Expire Date </th>
										
                                   
											<th>Action</th>


										</tr>
									</thead>
									<tbody>
										<?php
										$slno = 1;
										//echo "select * from truckupload where $crit";die;
										$sel = "select * from truckupload where $crit";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
										 	$doc_name = $cmn->getvalfield($connection, "doc_category_master", "doc_name", "docid='$row[docid]'");
										
											
										?>
											<tr>
												<td><?php echo $slno; ?></td>
													<td><?php echo $doc_name; ?></td>
												<td><?php echo dateformatindia($row['issuedate']); ?></td>
	                                              <td><?php echo dateformatindia($row['expiry']); ?></td>
										
													<td><a href="uploaded/img/<?php echo $row['uploaddocument']; ?>"  class="btn btn-small btn-green"  target="_blank"> View</a></td>
												
											
											

											
											
													 
												
											</tr>
											
										<?php
											$totalamt += $total_amt;
	$totqty += $qty;
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