<?php
include("dbconnect.php");
$tblname = "";
$tblpkey = "";
$pagename = "admin_payment_approvable.php";
$modulename = "Admin Payment Approvable";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$cond=' ';


if(isset($_GET['start_date']))
{
	 $start_date = $cmn->dateformatusa(trim(addslashes($_GET['start_date'])));	
}
else
$start_date = date('Y-m-d');

if(isset($_GET['end_date']))
{
	 $end_date = $cmn->dateformatusa(trim(addslashes($_GET['end_date'])));	
}
else
$end_date = date('Y-m-d');


if(isset($_GET['selectype']))
{
	 $selectype = $_GET['selectype'];	
}
else
$selectype = '';

if($selectype=='1'){
	$cond .="  and payment_status='3'";
}else if($selectype=='2'){
	$cond .="  and payment_status='1'";
}
else {
    $cond .="  and payment_status='0'";
}

if($start_date !='' && $end_date !='')
{
		$cond .=" and DATE_FORMAT(payment_date,'%Y-%m-%d') between '$start_date' and '$end_date' ";
}
	


?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

<script>
  $(function() {
   
	 $('#start_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	  $('#end_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	  	  $('.recdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();

	
  });
  </script>

</head>

<body >
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
							<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="get" action="" class='form-horizontal' >
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    
                                    <td><strong>From Date:</strong><span class="red">* </span></td>
                                    <td><input type="text" name="start_date" id="start_date" value="<?php echo $cmn->dateformatindia($start_date); ?>" autocomplete="off"   tabindex="2"  class="input-medium" required></td>
                                
                                   
                                    <td><strong>To Date:</strong><span class="red">* </span></td>
                                    <td><input type="text" name="end_date" id="end_date" value="<?php echo  $cmn->dateformatindia($end_date); ?>" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
                                     </td>
                                    <td>

                                    	 <td><strong>Status</strong><span class="red">* </span></td>
                                    <td><select id="selectype" name="selectype" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                      
                            <option value="1">Released</option>
                            <option value="2">Verified</option>
                            <option value="3">Pending</option>
                           
                       
                        </select>
                        <script>document.getElementById('selectype').value = '<?php echo $selectype; ?>';</script></td>
                                     </td>
                                    <td>
                                 
                                    <input type="submit" name="submit" id="submit" value="Search" class="btn btn-success" tabindex="10">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    <?php
									}
                                   else
                                   {                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </td>
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
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th >Sno</th>  
                                            <th >LR No.</th>
											<th >DI No.</th>
											<th >Voucher No.</th>
											<th >Owner Name.</th>
											<th >Truck No.</th>
                                        	<th >Bilty Date</th>
                                        	<th>Rec. Weight</th>
                                        	<th>Fianl Rate</th>
                                            <th >Cash Adv. </th>
											 <th >Diesal Adv. </th>
											  
											<th >Total Amount</th>                                            									                                          
                                        	<th width="18%" class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
						// echo "select * from bidding_entry where 1=1 && is_bilty=1 $cond";
						 
						$sql = mysqli_query($connection,"select * from bidding_entry where 1=1  $cond and is_complete='1' and compid='$compid' ");
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['placeid'];
						$bid_id = $row['bid_id'];
						$recweight = $row['recweight'];
						
						if($recweight==0) { $recweight= $row['totalweight']; }
						
						$destaddress = $row['destaddress'];
						$confdate = $cmn->dateformatindia($row['confdate']);
						$sortagr = $row['sortagr'];	
						$truckid = $row['truckid'];
						$noofqty = $row['noofqty'];						
						$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
						$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
						$recbag = $row['recbag'];
						$voucher_id = $row['voucher_id'];
						$bulk_payment_vochar = $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$voucher_id'");
						
						$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
						
						$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");


						$adv_cash = $row['adv_cash'];		
						$adv_diesel = $row['adv_diesel'];		
						$adv_other = $row['adv_other'];	
                        $adv_consignor = $row['adv_consignor'];	
						$total_cash=$adv_cash+$adv_other+$adv_consignor;

						$freightamt = $row['freightamt'];		
						$newrate = $row['newrate'];		
						
						 $final_rate=$freightamt-$newrate;

						$netamount=$recweight*$final_rate;

						$deduct = $row['deduct'];

						$new_newamount=$netamount-$deduct;
						$tds_amt = $row['tds_amt'];
						$new1_netamount=$new_newamount*$tds_amt/100;
						$commission = $row['commission'];

						$total_paid=$new1_netamount-$total_cash-$adv_diesel-$commission;

						$payment_status = $row['payment_status'];
						
						?>
                      
					<tr>
							 <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['lr_no']; ?></td>
							<td><?php echo $row['gr_no']; ?></td>

							<td><?php echo $bulk_payment_vochar; ?></td>
							
							<td><?php echo $ownername; ?></td>
							<td><?php echo $truckno; ?></td>
                            
                            <td><?php echo $date; ?></td>
                            <td><?php echo $recweight; ?></td>
                            <td><?php echo $final_rate; ?></td>
                            
                            <td><?php echo $total_cash; ?></td>
                            <td><?php echo $adv_diesel; ?></td>
                        
                            <td>
								<?php echo number_format(round($total_paid),2); ?>
                            </td>
							
                           <td width="18%">
                           	
                           	<?php  if($payment_status=='1'){
                           		echo "<b style='color:green'>Verified By Accountant</b>";
                           	} elseif($payment_status=='1')
                           	{ echo "<b style='color:green'>Released by Admin</b>"; }
                           	else { echo "<b style='color:red'>Pending.</b>"; }?>
                           	
                           </td>
                    </tr>
                    	<?php 
						}
						
						?>
                    
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				
			
			</div>
		</div></div>
<script>


function appoved_save(bid_id) {
	 pagename  ='<?php echo $pagename; ?>';
	 start_date='<?php echo date('d-m-Y',strtotime($start_date)); ?>';
	 end_date='<?php echo date('d-m-Y',strtotime($end_date)); ?>';
	$.ajax({
		  type: 'POST',
		  url: 'appoved_save.php',
		  data: 'bid_id=' + bid_id ,
		  dataType: 'html',
		  success: function(data){
			  // alert(data);
			  location=pagename+'?action=11&start_date='+start_date+'&end_date='+end_date;
			 // alert('Data Deleted Successfully');
			 // if(data==1) {
				//  document.getElementById('msg'+bid_id).innerHTML='Updated';
				 
				//  }
			}
		
		  });//ajax close
	
	}

</script>

<script>


function reject_save(bid_id) {
	 pagename  ='<?php echo $pagename; ?>';
	 start_date='<?php echo date('d-m-Y',strtotime($start_date)); ?>';
	 end_date='<?php echo date('d-m-Y',strtotime($end_date)); ?>';
	$.ajax({
		  type: 'POST',
		  url: 'reject_save.php',
		  data: 'bid_id=' + bid_id ,
		  dataType: 'html',
		  success: function(data){
			  // alert(data);
			  location=pagename+'?action=12&start_date='+start_date+'&end_date='+end_date;
			 // alert('Data Deleted Successfully');
			 // if(data==1) {
				//  document.getElementById('msg'+bid_id).innerHTML='Updated';
				 
				//  }
			}
		
		  });//ajax close
	
	}

</script>



	</body>
    

	</html>
<?php
mysqli_close($connection);
?>
