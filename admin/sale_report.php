<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "sale_report.php";
$modulename = "Sale Report";

$tblname = "sale_entry";
$tblpkey = "saleid";
if ($_GET['action'] != '') {
	$action = $_GET['action'];
} else {
	$action = '';
}

$sale_date = date('Y-m-d');

$cond = '';

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = '2022-07-01';
	$todate = date('Y-m-d');
}

if (isset($_GET['customer_id'])) {
	$customer_id  = trim(addslashes($_GET['customer_id']));
} else
	$customer_id = '';

if (isset($_GET['bill_type'])) {
	$bill_type  = trim(addslashes($_GET['bill_type']));
} else
	$bill_type = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {


	$crit .= " and  sale_date   between '$fromdate' and '$todate'";
}

if ($customer_id != '') {
	$crit .= " and customer_id ='$customer_id'";
}
if ($bill_type != '') {
	$crit .= " and bill_type ='$bill_type'";
}
if ($_GET['saleid'] != "") {

	// echo "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid";
	mysqli_query($connection, "update sale_entry  set is_complete=0  where is_complete=1 and saleid='$saleid");
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
								<h3><i class="icon-edit"></i>Sale Report</h3>
															<a href="sale_entry.php" class="btn btn-primary" style="float:right;">ADD NEW</a>

								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
								<div class="control-group">
									<table class="table table-condensed"  style="border: 1px solid #ebebeb;">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<th style="text-align:left;">From Date</th>
											<th style="text-align:left;"> To Date</th>
											<th> <strong>Customer Name </strong></th>
											<th> <strong>Bill Type </strong></th>
											<th> <strong>Action </strong></th>



										</tr>
										<tr>

											<td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="1" value="<?php echo $fromdate; ?>" /> </td>
											<td><input type="date" name="todate" id="todate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="2" value="<?php echo $todate; ?>" /> </td>
											<td>
											<select data-placeholder="Choose a Country..." name="customer_id" id="customer_id" style="width:200px" class="formcent select2-me" onchange="getunitid();getHsn();" >
                                                <option value="">Select </option>
                                                <?php
                                                $sql = mysqli_query($connection, "select * from  m_customer order by customer_name");
                                                while ($row = mysqli_fetch_array($sql)) {
                                                   
											// $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");

                                                ?>
                                                   <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>

                                                <?php } ?>
                                                <script>
                                                   document.getElementById('customer_id').value = '<?php echo $customer_id; ?>';
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
							<a class="btn btn-primary btn-lg" href="excel_sale_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&customer_id=<?php echo $customer_id; ?>&bill_type=<?php echo $bill_type; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>
											<th > Date </th>
                                                <th> Customer Name </th>
											
                                            <th> Bill Type </th>
											<!-- <th> Qty </th> -->
											<!-- <th>Rate </th> -->
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
										// echo "select * from sale_entry where 1=1 $crit";
										$sel = "select * from sale_entry where 1=1 $crit ";
										$res = mysqli_query($connection, $sel);
										while ($row = mysqli_fetch_assoc($res)) {
											$customer_name = $cmn->getvalfield($connection, "m_customer", "customer_name", "customer_id='$row[customer_id]'");
											$total_amt = $cmn->getvalfield($connection, "saleentry_detail", "sum(nettotal)", "saleid='$row[saleid]'");
											$itemid = $cmn->getvalfield($connection, "saleentry_detail", "itemid", "saleid='$row[saleid]'");
											$qty = $cmn->getvalfield($connection, "saleentry_detail", "qty", "saleid='$row[saleid]'");
											$saleid=$row['saleid'];
											// $rate=$row['rate'];
											$bill_type=$row['bill_type'];
											$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid ='$itemid'");
											
										?>
											<tr>
												<td><?php echo $slno; ?></td>
												<td><?php echo dateformatindia($row['sale_date']); ?></td>

												<td><?php echo $customer_name; ?></td>

												
												<td><?php echo ucfirst($row['bill_type']); ?></td>
												<!-- <td><?php echo $qty; ?></td> -->
												<!-- <td><?php echo $rate; ?></td> -->
												<td><?php echo ucfirst($row['remark']); ?></td>
												<td><?php echo number_format($total_amt,2); ?></td>
<td>
<?php if($itemcatid=='19'){ ?>
<input type="button"  id="saleid" onclick="addserial(<?php echo $itemid; ?>,<?php echo $row['saleid']; ?>)" value="Tyre" class="btn btn-warning"  > 
<!-- <a class="btn btn-warning" onclick="addserial(<?php echo $row['saleid']; ?>)" target="_blank">Tyre</a> -->
<?php if($_GET['bill_type']=='challan'){ ?>
												<a class="btn btn-warning" href="print_purchase_order.php?saleid=<?php echo ucfirst($row['saleid']); ?>" target="_blank">Print</a>
											<?php }	else {?>
													 	<a class="btn btn-warning" href="pdf_sale_invoice3.php?saleid=<?php echo ucfirst($row['saleid']); ?>" target="_blank">Print</a>
											<?php }	?>
<?php }else {?>  
	<?php if($_GET['bill_type']=='challan'){ ?>
												<a class="btn btn-warning" href="print_purchase_order.php?saleid=<?php echo ucfirst($row['saleid']); ?>" target="_blank">Print</a>
											<?php }	else {?>
													 	<a class="btn btn-warning" href="pdf_sale_invoice3.php?saleid=<?php echo ucfirst($row['saleid']); ?>" target="_blank">Print</a>
											<?php }	}?>


											

												 
												
												<td class='hidden-480'>
                          <a href="sale_entry.php?saleid=<?php echo $row['saleid']; ?>"><img src="../img/b_edit.png" title="Edit"></a>
                          <!-- onClick="edit(<?php echo $row['saleid']; ?>)" -->
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
<tr><th></th><th></th><th></th><th></th><th>Total</th><th><?php echo number_format($totalamt,2); ?></th><th> </th><th></th></tr>

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
					url: '../ajax/deletesale.php',
					data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
					dataType: 'html',
					success: function(data) {
						alert(data);
						// alert('Data Deleted Successfully');
						location = pagename + '?action=10';
					}

				}); //ajax close
			} //confirm close
		} //fun close

		function addserial(itemid,saleid) {
   
		jQuery.ajax({
		  type: 'POST',
		  url: 'show_tyre_report.php',
		  data: 'itemid='+itemid+'&saleid='+saleid,
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