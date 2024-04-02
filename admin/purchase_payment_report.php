<?php
error_reporting(0);
include("dbconnect.php");
$pagename = "purchase_payment_report.php";
$tblname = "payment";
$tblpkey = "payment_id";

$modulename = "Purchase Payment Report";

$tblname = "payment";
$tblpkey = "paymentid";
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


	$crit .= " and  paymentdate   between '$fromdate' and '$todate'";
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
<style>
.modal.fade{
    top: 20% !important;
   z-index: -1;
}
.modal.fade.in {
    top: 10% !important;
   position: fixed !important;
   z-index: 1097;
}
</style>
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
									<a href="purchase_payment.php" class="btn btn-primary" style="float:right;">ADD NEW</a>
								<?php include("../include/page_header.php"); ?>
							</div>
						

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
						
								<div class="control-group">
									<table class="table table-condensed">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<th style="text-align:left;">From Date</th>
											<th style="text-align:left;"> To Date</th>
											<th> <strong>Supplier Name </strong></th>
								
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

				<div id="myModal_product" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 ><strong>Update Entry</strong></h4>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered table-condensed">
                                   <tr>
						<th>Supplier Name</th>
						<th>Paid Amount</th>

					</tr>
					<tr>
						<td>  <select data-placeholder="Choose a Suppliers..." id="s_sup_id" class="formcent select2-me" tabindex="2" style="width:250px;"  onChange="getprebal();" >
                                    <!--<select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" tabindex="2" style="width:200px"  class="formcent select2-me" required>-->
                                       <option value="">Select </option>
                                       <?php
                                       $sql = mysqli_query($connection, "select * from  suppliers order by sup_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['sup_id']; ?>"><?php echo $row['sup_name']; ?></option>

                                       <?php } ?>
                                       <script>
                                          document.getElementById('sup_id').value = '<?php echo $sup_id ; ?>';
                                       </script>
						</td>
						<td>
						<input type="text" id="s_paid_amt" class="form-control"  value=""  style="font-weight:bold; " autocomplete="off"  >   
					
					</td>				
					</tr>

					<tr>
						<th>Disc Amount</th>
						<th>Narration</th>
					</tr>
					<tr>
						<td><input class="form-control" type="text" id="s_discamt" value="" placeholder='Disc Amt'></td>
						<td>
						<input class="form-control" type="text" id="s_narration" value="" placeholder='Remark'>
						</td>

					</tr>
					<tr> 
			<th>Payment Date</th>
			 <th>Payment Mode</th> 
			 <th></th>            
          
            </tr>
            <tr>
				<td><input type="text" id="s_paymentdate" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td>
				
		
                <td> 
                  <!-- <input type="text" id="s_pay_type" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td> -->
               <select data-placeholder="Choose Payment Type..." id="s_pay_type" class="formcent select2-me" tabindex="4" style="width:180px;">
                                       <option value="">Select</option>
                                              <option value="NEFT/Net Banking">NEFT/Net Banking</option>

                                       <option value="UPI">UPI</option>
                                       <option value="Cash">Cash</option>
                             
                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script>
	
				</td>					  
									             
            </tr>
					




                        </table>
                    </div>
                    <div class="modal-footer">
					<button class="btn btn-primary" name="s_save" id="s_save" onClick="updatesale();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
			   <input type="hidden" id="s_paymentid" value="" >
			   
                    </div>
                </div>
            <!-- /.modal-dialog -->
         </div>
      </div>
   </div>
				<!--   DTata tables -->
				<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<a class="btn btn-primary btn-lg" href="excel_purchase_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&sup_id=<?php echo $sup_id; ?>&bill_type=<?php echo $bill_type; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                        <th>S.No</th>
                                                                            <th>Supplier Name</th>

                                                                            <th>Payment Date</th>
                                                                            <th>Paid Amount</th>
                                                                            <th>Disc Amt</th>

                                                                            <th>Remark</th>
                                                                            <th>Print</th>

                                                                            <th>Action</th>


										</tr>
									</thead>
									<tbody>
                                    <?php
                            $sn = 1;
                            $netamount = 0;
                            //  echo "select A.* from payment as A left join m_supplier_party as B on A.suppartyid=B.suppartyid where A.paymentdate between '$fromdate' and '$todate' and A.type='purchase' $crit and  A.createdby='$loginid' order by paymentid";
                            $sql = mysqli_query($connection, "select * from payment where iscomp=1 $crit ");
                            while ($row = mysqli_fetch_assoc($sql)) {

                            ?>
                                <tr class="abc" tabindex="<?php echo $sn; ?>">
                                    <td><?php echo $sn++; ?></td>
                                    <td> <?php echo $cmn->getvalfield($connection,"suppliers","sup_name","sup_id='$row[sup_id]'"); ?> </td>
                                    <td><?php echo $cmn->dateformatindia($row['paymentdate']); ?></td>
                                    <td style="text-align:left;"><?php echo number_format($row['paid_amt'], 2); ?></td>
                                    <td style="text-align:left;"><?php echo number_format($row['discamt'],2); ?></td>
                                    <td><?php echo $row['narration']; ?></td>
									<td><a href="pdf_puchase_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

</td>    
								<td>

								<input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $cmn->dateformatindia($row['paymentdate']); ?>','<?php echo $row['sup_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
								<input type="button" class="btn btn-danger" name="add_data_list" id="add_data_list" onClick="funDel1('<?php echo $row['paymentid']; ?>');" value="X">

								</td>	


                                </tr>
											
										<?php
										     $netamount += $row['paid_amt'];
										     $discamt1 += $row['discamt'];
	$totqty += $qty;
											$slno++;
										}
										?>
										
	<tfoot>
<tr><th></th><th></th><th>Total</th><th><?php echo $netamount; ?></th><th><?php echo number_format($discamt1,2); ?></th><th></th><th></th><th></th></tr>

</tfoot>
									</tbody>

								</table>
							</div>
						</div>
					</div>
				</div>


			</div>
		</div></div>
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

		
function updatesale() {
		
		var sup_id = document.getElementById('s_sup_id').value.trim();
		var paid_amt = document.getElementById('s_paid_amt').value.trim();
		var pay_type = document.getElementById('s_pay_type').value.trim();

		var disc = document.getElementById('s_discamt').value.trim();
		var narration = document.getElementById('s_narration').value.trim();
		var paymentdate = document.getElementById('s_paymentdate').value.trim();
		var paymentid= document.getElementById('s_paymentid').value.trim();
	
		
		if(paymentdate=='') {
			  alert("Please Select Date");
			  return false;
		}
		
		
		if(sup_id=='') {
			  alert("Please Select Customer");
			  return false;
		}
		
		
		if(paid_amt=='' || paid_amt=='0') {
			  alert("Paid Amount cant be Balnk/Zero");
			  return false;
		}
		
		
		
		   jQuery.ajax({
				   type: 'POST',
				   url: 'savepaymentpur.php',
				   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&sup_id='+sup_id+'&paymentid='+paymentid,
				 //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
				   dataType: 'html',
				   success: function(data){		
					// alert(data)	  ;
				   jQuery('#s_sup_id').val('');
				   jQuery('#s_pay_type').val('');
				   jQuery('#s_paid_amt').val('');
				   jQuery('#s_narration').val('');
				   jQuery('#s_paymentdate').val('');
				   jQuery('#s_paymentid').val('');
				   jQuery('#myModal_product').modal('hide');
				   showrecord();
						  
						  }				
					  });//ajax close
				  
		
		
		}
	
function editselected(paymentid,paymentdate,sup_id,paid_amt,narration,disc,pay_type)
{

	jQuery('#myModal_product').modal('show');
	jQuery('#s_paymentid').val(paymentid);

	jQuery('#s_discamt').val(disc);
	jQuery('#s_paymentdate').val(paymentdate);
	jQuery('#s_paid_amt').val(paid_amt);
	jQuery('#s_narration').val(narration);

   $("#s_sup_id").select2().select2('val', sup_id);	

	jQuery('#s_paymentid').val(paymentid);

   $("#s_pay_type").select2().select2('val', pay_type);	

}


function funDel1(id) {
	alert(id);
	tblname = '<?php echo $tblname; ?>';
	tblpkey = '<?php echo $tblpkey; ?>';
	pagename = '<?php echo $pagename; ?>';
	submodule = '<?php echo $submodule; ?>';
	module = '<?php echo $module; ?>';
	
	
	jQuery.ajax({
			  type: 'POST',
			  url: 'delete_master.php',
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
			//  alert(data);
           showrecord(<?php echo $keyvalue; ?>);
		   location = pagename + '?action=10';
		          showrecord(<?php echo $keyvalue; ?>);
				}				
			  });//ajax close
}
   
	</script>
</body>

</html>
<?php
mysqli_close($connection);
?>