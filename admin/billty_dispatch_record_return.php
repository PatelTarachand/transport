<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'billty';
$tblpkey = 'billtyid';
$pagename  = 'billty_dispatch_record_return.php';
$modulename = "Return Dispatch";
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
 
	$crit .= " and  tokendate  between '$fromdate' and '$todate'";
 }



 ?>
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
								<td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" value="<?php echo $fromdate; ?>" /> </td>
                  <td><input type="date" name="todate" id="" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" value="<?php echo $todate; ?>" /> </td>



									<td width="58%"> <input type="submit" name="submit" class="btn btn-success" id="" value="Search" onClick="return checkinputmaster('billtydate,todate');">
										<a href="billty_dispatch_record_return.php" class="btn btn-danger">Cancel</a>
									</td>

								</tr>

							</table>
						</form>
						<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>LR No.</th>
                                             <th>Bilty No.</th>
											
											
											<th>Bilty Date </th>
                                            <!--<th>Invoice No</th>-->
                                            <th>Truck No.</th>
                                            <th>Destination</th>
                                        	<th>Item</th>
                                            <th>Weight</th>
                                            <th>Adv. Cash <br> (Self)</th>
                                            <th>Adv. Cash <br>(Consignor)</th>
                                      
                                            <th>Remark</th>
                                            
											<th>Print </th>
                                        	<!-- <th  style="width:200px;">Print Recipt</th> -->
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									//  $sel = "select * from returnbidding_entry where isdispatch=1 && sessionid='$sessionid'  and compid='$compid' order by bid_id desc";
                                    // echo "select * from returnbidding_entry where 1=1$crit  and compid='$compid'";
                                    $sel = "select * from returnbidding_entry where 1=1 $crit &&  isdispatch=1  && sessionid='$sessionid'  and compid='$compid' ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									   $paydone=$row['is_complete'];
										$truckid = $row['truckid'];	
										$itemid = $row['itemid'];	
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
								
									?>
										<tr tabindex="<?php echo $slno; ?>" class="abc">
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['lr_no']);?></td>
                                             <td><?php echo ucfirst($row['bilty_no']);?></td>
                                          
											 <td><?php echo date('d-m-Y',strtotime($row['tokendate']));?></td>
                                            <!--<td><?php echo ucfirst($row['invoiceno']);?></td>-->
                                             <td><?php echo $truckno;?></td>
					                    	<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                            <td><?php echo $itemname;?>  </td> 
                                            <td><?php echo ucfirst($row['totalweight']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_consignor']);?>  
                                            </td>
                                         
                                           <td><?php echo $row['remark'];?></td>
											<!-- <td><a href="pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-primary">Print Bilty</a></td> -->
                                           <td style="display: flex;width: 204px;justify-content: space-around;">
                                           <a href="pdf_paiddispatchreceipt_return.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-sm btn-success">Print Recipt</a> </td>
                                            <!-- <a href="pdf_paiddiselreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-sm btn-success">Diesel Slip</a> </td> -->
                                            <td class='hidden-480'>

                                             <?php 
                                               if($usertype=='admin')
                  {
                    $payUser=1;
                  }
                  else
                  {
                    $payUser=0;                 
                  }
                                

            if($paydone!=0){ 
                if($usertype=='admin'){  ?> 
  <!--<a onClick="editrecord(<?php echo $row['bid_id'];?>);" ><img src="../img/b_edit.png" title="Edit"></a>-->
  <a href= "return_trip_advance.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  ><img src="../img/b_edit.png" title="Edit">
                                         </a>  &nbsp;&nbsp;&nbsp;

                                           <?php } else { echo "Payment Done."; } }
            else { ?>
                <!--<a onClick="editrecord(<?php echo $row['bid_id'];?>);" ><img src="../img/b_edit.png" title="Edit"></a>-->
                <!--                           &nbsp;&nbsp;&nbsp;-->
                                             <a href= "return_trip_advance.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  ><img src="../img/b_edit.png" title="Edit"></a>
              <?php } ?>
                                  
                                           
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