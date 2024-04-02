<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='billty_record2.php';
$modulename = "Billty";
//print_r($_SESSION);
// $sale_date = date('Y-m-d');
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

?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
 
</head>

<body data-layout-topbar="fixed">
	

	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

         <div class="maincontent">
            <div class="contentinner content-dashboard">
           <br><br>   <br><br>
               <!--alert-->
               <form action="" method="get">
                  <table class="table table-bordered">
                     <tr>
                        <th width="20%"> From Date </th>
                        <th width="20%"> To Date </th>
                 
                        <th width="20%">Action </th>
                     </tr>
                     <tr>
                        <td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off"  value="<?php echo $fromdate; ?>" /> </td>
                        <td><input type="date" name="todate" id="" class="input-xxlarge" style="width:95%" autofocus autocomplete="off"  value="<?php echo $todate; ?>" /> </td>

                  
                     <td><button type="submit" name="submit" value="submit" class="btn btn-primary">
                              Search</button>
							  <a href="billty_record2.php" type="submit" name="submit" value="submit" class="btn btn-primary">
                              Reset</button>
                        </td>
                     </tr>
                  </table>
               </form>
<br> 

<br>
<br>
									<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>LR No</th>
											<th>Bilty No</th>
											<th>Bilty Date</th>
										
										<th>	Consignor</th>
											<th>Consignee</th>
											<th>Truck No.</th>
											<th>Owner Name</th>

											<th>Destination</th>
											<th>Item</th>
											<th>Weight/(M.T.)</th>
											<th>Qty(Bags)</th>
											<th>Comp Rate</th>
											<th>Freight Rate</th>
											<th>Print</th>
											<th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{   $payUser=1;
										$cond="where compid='$_SESSION[compid]' ";	
									}
									else
									{
									    $payUser=0;
										//$cond="where createdby='$userid' ";	
										$cond="where compid='$_SESSION[compid]' ";											
									}
								// echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit and compid='$compid' order by bid_id desc";
								 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond && sessionid='$sessionid' and compid='$compid' && is_bilty=1  $crit  order by bid_id desc ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									    $paydone=$row['is_complete'];
									    	$truckid = $row['truckid'];	
									    	$ownerid = $row['ownerid'];	

									    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									     $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid ='$truckid'");
									    $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid ='$ownerid'");
										  $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'");

									?>
										<tr tabindex="<?php echo $slno; ?>" class="abc">
						<td><?php echo $slno; ?></td>						
						<td><?php echo ucfirst($row['lr_no']);?></td>
						<td><?php echo ucfirst($row['bilty_no']);?></td>
						<td><?php echo  $row['tokendate'];?></td>
					
								<td><?php echo  $consignorname;?></td>		
						<td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
						<td><?php echo $truckno;?></td>
						<td><?php echo $ownername;?></td>
						<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
						
						<td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>						
						<td><?php echo ucfirst($row['totalweight']);?></td>						
												
						<td><?php if($row['noofqty']!='0') { echo ucfirst($row['noofqty']); } ?></td>
						<td><?php if($row['comp_rate']!='0'){ echo ucfirst($row['comp_rate']); } ?></td>
						<td><?php  if($row['comp_rate']!='0'){ echo $row['comp_rate']*$row['totalweight']; } ?></td>
						<td><a href= "pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>
						<td class='hidden-480'>
						<a onClick="edit('<?php echo $row['bid_id'];?>');"><img src="../img/b_edit.png" title="Edit"></a>
						    	<a href= "bilty_entry_emami.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  style="display: none;"id="add_data_list_edit_<?php echo  $row['bid_id'] ; ?>"
							    
							> </a>
							<!-- <a  href= "bilty_entry_emami.php?bid_id=<?php echo ucfirst($row['bid_id']);?>&edit=true"
							  
							><img src="../img/b_edit.png" title="Edit"></a> -->
						&nbsp;&nbsp;&nbsp;

						<a  onClick="funDelotp('<?php echo $row['bid_id'];?>');"><img src="../img/del.png"  title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel('<?php echo $row['bid_id']; ?>');" value="X">
							<?php 
							    if($paydone!=0){ 
						 echo "Payment Done.";
					?>

						</td>
						
						 <?php } ?>
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
			  location='billty_record2.php?action=10&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>';

			}
		
		  });//ajax close
	}//confirm close
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
		      alert(data);
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
						 location= "bilty_entry_emami.php?bid_id="+ref_id;
						 jQuery("#add_data_list_edit_"+ref_id).click();
						} 
						else
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}

function funDelotp(bid_id){ 
    
	if(bid_id !='') {
		
				jQuery.ajax({
		  type: 'POST',
		  url: 'getotp_billing_entry_delete.php',
		  data: 'bid_id='+bid_id,
		  dataType: 'html',
		  success: function(data){ 
			// alert(data);
				  jQuery("#ref_idddd").val(bid_id);
				jQuery("#myModallll").modal('show');
			}	
		  });//ajax close
		}	
}
function get_dispatch_list()
{
	consignorid = $("#consignorid").val();
	billtydate = $("#billtydate").val();
	todate = $("#todate").val();
	isbilled = $("#isbilled").val();
	if(consignorid != ""){
	$.ajax({
	type: 'POST',
	url: 'ajax_get_dispatch_list.php',
	data: 'consignorid=' + consignorid + '&billtydate=' + billtydate + '&todate=' +todate+ '&isbilled=' + isbilled,
	dataType: 'html',
	success: function(data){
		document.getElementById('dispatch_list').innerHTML = data;
		}
	});//ajax close
	}
}
jQuery(function($){
   $("#billtydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
  $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});
</script>			
                
		
	</body>

	</html>
