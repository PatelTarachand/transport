<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'billty';
$tblpkey = 'billtyid';
$pagename  = 'billty_form.php';
$modulename = "Billty Dispatch";
//print_r($_SESSION);
$crit = "";
$cond = '';
if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
 } else {
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
 }
 if (isset($_GET['bid_id'])) {
	$bid_id = trim(addslashes($_GET['bid_id']));
 } else
	$bid_id = '';
 
 $crit = " ";
 if ($fromdate != "" && $todate != "") {
 
	$crit .= " and  tokendate between '$fromdate' and '$todate'";
 }



$sel = "select * from bilty_entry $crit order by bilty_id desc"; ?>
<!doctype html>
<html>

<head>
	<?php include("../include/top_files.php"); ?>

</head>

<body data-layout-topbar="fixed">


	<?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">

		<!--   DTata tables -->
		<div class="row-fluid">
			<div class="span12">
				<div class="box box-bordered">
					<div class="box-title">
						<h3><i class="icon-table"></i><?php echo $modulename; ?> Details </h3>
					</div>
					<div class="box-content nopadding">
						<form action="" method="get">
							<table width="100%" border="0" class="table table-condensed table-bordered">
								<tr>
									<td width="13%" scope="col"><strong>From Date</strong> </td>
									<td width="12%">
										<input class="input-medium" type="hidden" name="consignorid" id="consignorid" value="<?php echo $consignorid; ?>">

										<input class="input-medium" type="text" name="fromdate" id="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-date="true" required style="border: 1px solid #368ee0">
									</td>

									<td width="6%" scope="col"><strong>To Date</strong> </td>
									<td width="11%">
										<input class="input-medium" type="text" name="todate" id="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" data-date="true" required style="border: 1px solid #368ee0">
									</td>



									<td width="58%"> <input type="submit" name="submit" class="btn btn-success" id="" value="Search" onClick="return checkinputmaster('billtydate,todate');">
										<a href="billty_record.php" class="btn btn-danger">Cancel</a>
									</td>

								</tr>

							</table>
						</form>
						<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
							<thead>

								<tr>
									<th>Sno</th>
									<th>Bilty No. </th>
									<th>Di No.</th>

									<th>Bilty Date</th>
									<th>Truck No.</th>
									<th>Owner Name</th>
									<th>Item</th>
									<th>Weight</th>
									<th>Advance Cash</th>
									<th>Advance Diesel</th>
									<th>Other Advance </th>
									<th>Advance (Consignor) </th>
									<th>Advance Cheque</th>
									<th>Print Recipt</th>
									<th class='hidden-480'>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$slno = 1;
								$sel = "select * from bidding_entry where isdispatch=1 && sessionid='$sessionid' && compid='$compid'";
								$res = mysqli_query($connection, $sel);
								while ($row = mysqli_fetch_array($res)) {
									$truckid = $row['truckid'];
									$itemid = $row['itemid'];
									$truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'");


									$ownerid = $cmn->getvalfield($connection, "m_truck", "ownerid", "truckid='$truckid'");
									$ownername = $cmn->getvalfield($connection, "m_truckowner", "ownername", "ownerid='$ownerid'");
									$itemname = $cmn->getvalfield($connection, "inv_m_item", "itemname", "itemid='$itemid'");

								?>
									<tr>
										<td><?php echo $slno; ?></td>
										<td><?php echo ucfirst($row['bilty_no']); ?></td>
										<td><?php echo ucfirst($row['di_no']); ?></td>

										<td><?php echo date('d-m-Y', strtotime($row['tokendate'])); ?></td>
										<td><?php echo $truckno; ?></td>
										<td><?php echo $ownername; ?></td>
										<td><?php echo $itemname; ?> </td>
										<td><?php echo ucfirst($row['totalweight']); ?>
										</td>
										<td><?php echo ucfirst($row['adv_cash']); ?>
										</td>
										<td><?php echo ucfirst($row['adv_diesel']); ?></td>
										<td><?php echo ucfirst($row['adv_other']); ?></td>
										<td><?php echo ucfirst($row['adv_consignor']); ?></td>
										<td><?php echo ucfirst($row['adv_cheque']); ?></td>
										<td>
											<a href="pdf_paiddispatchreceipt.php?bid_id=<?php echo $row['bid_id']; ?>" target="_blank" class="btn btn-success">Print Recipt</a>
										</td>
										<td class='hidden-480'>

                                        <a onClick="edit('<?php echo $row['bid_id'];?>');"><img src="../img/b_edit.png" title="Edit"></a>
						    	<a href= "bilty_dispatch1.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  style="display: none;"id="add_data_list_edit_<?php echo  $row['bid_id'] ; ?>"
									

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

	</div><!-- class="container-fluid nav-hidden" ends here  -->
    <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">OTP Check</h3>
    </div>
    <div class="modal-body">
       <center><span id="getotp"></span></center> 
        <h4>Enter 4 Digit Code</h4>
       <p>
       			<table>
                		<tr>
                        		<td> <input type="text" id="otp" class="form-control" value="" autocomplete="off" > </td>
                                <td> <input type="button" class="btn btn-primary" onClick="checkotp();" value="Check" > </td>
                        </tr>
                        <input type="hidden" id="ref_id" value="" >
                </table>
       </p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button> 
    </div>
</div><!--#myModal-->


	 <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModallll">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">OTP Check</h3>
    </div>
    <div class="modal-body">
        <h4>Enter 4 Digit Code</h4>
       <p>
       			<table>
                		<tr>
                        		<td> <input type="text" id="otpppp" class="form-control" value="" autocomplete="off" > </td>
                                <td> <input type="button" class="btn btn-primary" onClick="checkotpppp();" value="check" > </td>
                        </tr>
                        <input type="hidden" id="ref_idddd" value="" >
                </table>
       </p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button> 
    </div>
</div><!--#myModal-->          
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


        function checkotpppp() {
	var otp = document.getElementById('otpppp').value;
	var ref_id = document.getElementById('ref_idddd').value;
	if(otp !='') {
	 
					
					jQuery.ajax({
			  type: 'POST',
			  url: 'checkotp_billing_entry_delete.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
					// alert(data);
					if(data==1) {
						 //location = "other_expense.php?expenseid="+ref_id;
						 //alert("ok");
						 jQuery("#myModallll").modal('hide');
						jQuery("#add_data_delete_"+ref_id).click();
						} 
						else
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}
function edit(bid_id) {
    
	if(bid_id !='') {
				
				jQuery.ajax({
		  type: 'POST',
		  url: 'getotp_payment.php',
		  data: 'bid_id='+bid_id,
		  dataType: 'html',
		  success: function(data){ 
			  // alert(data);
				  jQuery("#ref_id").val(bid_id);
				jQuery("#myModal").modal('show');
				//	jQuery("#getotp").html(data);
				
			}	
		  });//ajax close
		}	
}

function checkotp() {
	var otp = document.getElementById('otp').value;
	var ref_id = document.getElementById('ref_id').value;
	if(otp !='') {
					jQuery.ajax({
			  type: 'POST',
			  url: 'biltyentry_edit.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
				// alert(data);
				
					if(data==1) {
						 //location = "other_expense.php?expenseid="+ref_id;
						 //alert("ok");
						 jQuery("#myModal").modal('hide');
						 location= "bilty_dispatch_emami.php?bid_id="+ref_id;
						 jQuery("#add_data_list_edit_"+ref_id).click();
						} 
						else
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}
		function get_dispatch_list() {
			consignorid = $("#consignorid").val();
			billtydate = $("#billtydate").val();
			todate = $("#todate").val();
			isbilled = $("#isbilled").val();
			if (consignorid != "") {
				$.ajax({
					type: 'POST',
					url: 'ajax_get_dispatch_list.php',
					data: 'consignorid=' + consignorid + '&billtydate=' + billtydate + '&todate=' + todate + '&isbilled=' + isbilled,
					dataType: 'html',
					success: function(data) {
						document.getElementById('dispatch_list').innerHTML = data;
					}
				}); //ajax close
			}
		}
		jQuery(function($) {
			$("#billtydate").mask("99-99-9999", {
				placeholder: "dd-mm-yyyy"
			});
			$("#todate").mask("99-99-9999", {
				placeholder: "dd-mm-yyyy"
			});
		});
	</script>


</body>

</html>