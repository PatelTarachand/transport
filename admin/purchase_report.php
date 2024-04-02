<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "purchase_report.php";
$modulename = "Purchase Report";

$tblname = "purchaseentry";
$tblpkey = "purchaseid";
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
	$fromdate = '2022-07-01';
	$todate = date('Y-m-d');
}

if (isset($_GET['sup_id'])) {
	$sup_id  = trim(addslashes($_GET['sup_id']));
} else
	$sup_id = '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  purchase_date   between '$fromdate' and '$todate'";
}

if ($sup_id != '') {
	$crit .= " and sup_id ='$sup_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
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
								<h3><i class="icon-edit"></i>Purchase Report</h3>
															<a href="purchase_entry.php" class="btn btn-primary" style="float:right;">ADD NEW</a>

								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
								<div class="control-group">
									<table class="table table-condensed" style="border: 1px solid #ebebeb;">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<th style="text-align:left;">From Date</th>
											<th style="text-align:left;"> To Date</th>
											<th> <strong>Supplier Name </strong></th>
											<th> <strong>Bill Type </strong></th>
											<th> <strong>Action </strong></th>



										</tr>
										<tr>

											<td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="1" value="<?php echo $fromdate; ?>" /> </td>
											<td><input type="date" name="todate" id="todate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="2" value="<?php echo $todate; ?>" /> </td>
											<td>
												<select data-placeholder="Choose a Country..." name="sup_id" id="sup_id" style="width:200px" tabindex="3" class="formcent select2-me">
													<option value="">Select </option>
													<?php
													$sql = mysqli_query($connection, "select * from  suppliers order by sup_name");
													while ($row = mysqli_fetch_array($sql)) {

													?>
														<option value="<?php echo $row['sup_id']; ?>"><?php echo $row['sup_name']; ?></option>

													<?php } ?>
													<script>
														document.getElementById('sup_id').value = '<?php echo $sup_id; ?>';
													</script>

											</td>

<td>
                                 <select data-placeholder="Choose Payment Type..." name="bill_type" id="bill_type" class="chzn-select" tabindex="5" style="width:180px;" onChange="showAmt();">
                                       <option value="">Select</option>
                                       <option value="Invoice">Invoice</option>
                                       <option value="challan">challan</option>

                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script>
                                 
                                 </td>
											
											<center>
										    <td>
											
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

				<div id="modal-snserial" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> <span id="m_itemname"></span> </h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body" id="serialbody1">
					<p>
						
					</p>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
                <input type="hidden" id="m_purdetail_id" value=""  >
                
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-primary" onchange="saveserial();">Save changes</button> -->
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
				<!--   DTata tables -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<a class="btn btn-primary btn-lg" href="excel_purchase_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&sup_id=<?php echo $sup_id; ?>&bill_type=<?php echo $bill_type; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>
											<th > Date </th>
                                                <th> Supplier Name </th>
											
												<th> Bill No. </th>
                                            <th> Bill Type </th>
											<th> Qty </th>
                                        <th>Remark</th>
                                       <th> Net Total</th>

											<!-- <th>Tyre</th> -->
											<th>Print</th>
											<th>Action</th>


										</tr>
									</thead>
									<tbody>
										<?php
										$slno = 1;
										//echo "select * from purchaseentry where 1=1 $crit order by purchase_date desc";die;
										$sel = "select * from purchaseentry where 1=1 $crit group  by billno order by billno desc  ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$supplier_name = $cmn->getvalfield($connection, "suppliers", "sup_name", "sup_id='$row[sup_id]'");
											$total_amt = $cmn->getvalfield($connection, "purchasentry_detail", "sum(nettotal)", "purchaseid='$row[purchaseid]'");
											$itemid = $cmn->getvalfield($connection, "purchasentry_detail", "itemid", "purchaseid='$row[purchaseid]'");
											$qty = $cmn->getvalfield($connection, "purchasentry_detail", "qty", "purchaseid='$row[purchaseid]'");
											$purchaseid=$row['purchaseid'];
											$bill_type=$row['bill_type'];
											$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
											
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['purchase_date']); ?></td>

												<td><?php echo $supplier_name; ?></td>
												<td><?php echo ucfirst($row['billno']); ?></td>
												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<td><?php echo $qty; ?></td>
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo number_format($total_amt,2); ?></td>
<td>
<?php if($itemcatid=='19'){ ?>
<input type="button"  id="purchaseid" onclick="addserial(<?php echo $itemid; ?>,<?php echo $row['purchaseid']; ?>)" value="Tyre" class="btn btn-warning"  > 
<!-- <a class="btn btn-warning" onclick="addserial(<?php echo $row['purchaseid']; ?>)" target="_blank">Tyre</a> -->
<?php if($_GET['bill_type']=='challan'){ ?>
												<a class="btn btn-warning" href="print_purchase_order.php?purchaseid=<?php echo ucfirst($row['purchaseid']); ?>" target="_blank">Print</a>
											<?php }	else {?>
													 	<a class="btn btn-warning" href="pdf_invoice3.php?purchaseid=<?php echo ucfirst($row['purchaseid']); ?>" target="_blank">Print</a>
											<?php }	?>
<?php }else {?>  
	<?php if($_GET['bill_type']=='challan'){ ?>
												<a class="btn btn-warning" href="print_purchase_order.php?purchaseid=<?php echo ucfirst($row['purchaseid']); ?>" target="_blank">Print</a>
											<?php }	else {?>
													 	<a class="btn btn-warning" href="pdf_invoice3.php?purchaseid=<?php echo ucfirst($row['purchaseid']); ?>" target="_blank">Print</a>
											<?php }	}?>


											

												 
												
												<td class='hidden-480'>
                          <a href="purchase_entry.php?purchaseid=<?php echo $row['purchaseid']; ?>"><img src="../img/b_edit.png" title="Edit"></a>
                          <!-- onClick="edit(<?php echo $row['purchaseid']; ?>)" -->
                          &nbsp;&nbsp;&nbsp;
                          <?php if ($usertype == "admin") { ?><a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"><img src="../img/del.png" title="Delete"></a><?php } ?>
                        </td>
											</tr>
											
										<?php
											$totalamt += $total_amt;
	$totqty += $qty;
											$slno++;
										}
										?>
										
	<tfoot>
<tr><th></th><th></th><th></th><th></th><th>Total</th><th><?php echo $totqty; ?></th><th></th><th><?php echo number_format($totalamt,2); ?></th><th> </th><th></th><th></th></tr>

</tfoot>
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
				
						// alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close

		function addserial(itemid,purchaseid) {

		jQuery.ajax({
		  type: 'POST',
		  url: 'show_tyre_report.php',
		  data: 'itemid='+itemid+'&purchaseid='+purchaseid,
		  dataType: 'html',
		  success: function(data){			
         // alert(data);
         if(data==2){
		jQuery("#modal-snserial").modal('hide');
            
         }else{
		jQuery("#modal-snserial").modal('show');

			jQuery("#serialbody1").html(data);
		
			}}
			
		  });//ajax close
		
		
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