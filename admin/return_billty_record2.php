<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='return_billty_record2.php';
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
 
 
 
 
 
 if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}
else
$consignorid = '';

if(isset($_GET['consigneeid']))
{
	$consigneeid = trim(addslashes($_GET['consigneeid']));	
}
else
$consigneeid = '';


if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
}
else
$truckid = '';


 $crit = " ";
 if ($fromdate != "" && $todate != "") {
 
	$crit .= " and  tokendate between '$fromdate' and '$todate'";
 }
 
 if($consignorid !='') {
	
	$crit .=" and consignorid='$consignorid'";
	
	}
	if($consigneeid !='') {
	
	$crit .=" and consigneeid='$consigneeid'";
	
	}

	if($truckid !='') {
	
	$crit .=" and truckid='$truckid'";
	
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
                        <th width="17%"> From Date </th>
                        <th width="17%"> To Date </th>
               
                   <th width="17%"> Consignor Name </th>
                    <th width="17%"> Consignee  Name </th>
                       <th width="17%">Truck No. </th>
                        <th width="20%">Action </th>
                     </tr>
                     <tr>
                        <td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off"  value="<?php echo $fromdate; ?>" /> </td>
                        <td><input type="date" name="todate" id="" class="input-xxlarge" style="width:95%" autofocus autocomplete="off"  value="<?php echo $todate; ?>" /> </td>

                  <td>
                                            <select id="consignorid" name="consignorid" class="select2-me input-large" 
                
                   style="width:200px;" >
		<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from m_consignor");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['consignorid']; ?>"><?php echo $row_fdest['consignorname']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consignorid').value = '<?php echo $_GET['consignorid']; ?>';</script>
                        </td>
                        
                        <td>
                                            <select id="consigneeid" name="consigneeid" class="select2-me input-large" 
                
                   style="width:200px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from  m_consignee");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['consigneeid']; ?>"><?php echo $row_fdest['consigneename']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('consigneeid').value = '<?php echo $_GET['consigneeid']; ?>';</script>
                        </td>
                        
                        <td>
                                          	<select id="truckid" name="truckid" class="select2-me input-large" style="width:200px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select truckid,truckno from m_truck");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                        </td>
                  
                     <td><button type="submit" name="submit" value="submit" class="btn btn-primary">
                              Search</button>
							  <a href="return_billty_record2.php" type="submit" name="submit" value="submit" class="btn btn-primary">
                              Reset</button>
                        </td>
                     </tr>
                  </table>
               </form>
<br> 
	<a class="btn btn-primary btn-lg" href="excel_return_billty_record2.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $_GET['consignorid']; ?>&consigneeid=<?php echo $_GET['consigneeid']; ?>&truckid=<?php echo $_GET['truckid']; ?>" target="_blank" style="float:right;"> Excel </a>
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
								//  echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from returnbidding_entry where 1=1 $crit  && sessionid='$sessionid' && is_bilty=1  and compid='$compid' order by bid_id desc limit 0,100";
									$sel =  "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from returnbidding_entry where 1=1 $crit && sessionid='$sessionid'   and compid='$compid' ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									    $paydone=$row['is_complete'];
									    	$truckid = $row['truckid'];	
									    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
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
						<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
						
						<td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>						
						<td><?php echo ucfirst($row['totalweight']);?></td>						
												
						<td><?php if($row['noofqty']!='0') { echo ucfirst($row['noofqty']); } ?></td>
						<td><?php if($row['comp_rate']!='0'){ echo ucfirst($row['comp_rate']); } ?></td>
						<td><?php  if($row['own_rate']!='0'){ echo $row['own_rate']*$row['totalweight']; } ?></td>
						<td><a href= "pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>
						<td class='hidden-480'>
						<!-- <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="edit('<?php echo $row['saleid']; ?>');" value="E">
						  <input type="button" class="btn btn-primary" style="display: none;" name="add_data_list" id="add_data_list_edit_<?php echo  $row['saleid'] ; ?>" onClick="editselected('<?php echo $row['saleid']; ?>','<?php echo $row['rate']; ?>','<?php echo $row['unitrate']; ?>','<?php echo $row['qty']; ?>','<?php echo $row['weight']; ?>','<?php echo $row['suppartyid']; ?>','<?php echo $row['unitid']; ?>','<?php echo $row['productid']; ?>','<?php echo $cmn->dateformatindia($row['billdate']); ?>');" value="E">
						  &nbsp; -->


						
							  
						<a onClick="edit('<?php echo $row['bid_id'];?>');"><img src="../img/b_edit.png" title="Edit"></a>
						    	<a href= "return_trip_entry.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  style="display: none;"id="add_data_list_edit_<?php echo  $row['bid_id'] ; ?>"
							    
							> </a>
							<!-- <a  href= "return_trip_entry.php?bid_id=<?php echo ucfirst($row['bid_id']);?>&edit=true"
							  
							><img src="../img/b_edit.png" title="Edit"></a> -->
						&nbsp;&nbsp;&nbsp;

						<a onClick="funDelotp('<?php echo $row['bid_id'];?>');"><img src="../img/del.png" title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel('<?php echo $row['bid_id']; ?>');" value="X">
							<?php 
							    if($paydone!=0){ 
							//  echo "Payment Done.";
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
			  location='return_billty_record2.php?action=10&fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>';

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
						 location= "return_trip_entry.php?bid_id="+ref_id;
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
