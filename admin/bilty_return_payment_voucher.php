<?php //error_reporting(0); 
include("dbconnect.php");
$tblname = 'bilty_payment_voucher';
$tblpkey = 'payid';
$pagename = "bilty_return_payment_voucher.php";

$dup = '';
if (isset($_POST['submit'])) {
	$bulk_vid = $_POST['bulk_vid'];
	$rec_no = $_POST['rec_no'];
	$rec_from = $_POST['rec_from'];
	$rec_date = $_POST['rec_date'];
  $amt=$_POST['amt'];
	$pay_mode = $_POST['pay_mode'];
	$remark = $_POST['remark'];
// 	 $vamt = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$bulk_vid'");
	$consignorid = $cmn->getvalfield($connection, "voucher_entry", "consignorid","bulk_vid='$bulk_vid'");
	$consigneeid = $cmn->getvalfield($connection, "voucher_entry", "consigneeid","bulk_vid='$bulk_vid'");

	if ($pay_id  == '') {
		$sqlcheckdup = mysqli_query($connection, "SELECT * FROM voucher_pay WHERE pay_id ='$pay_id '");


		$check = mysqli_num_rows($sqlcheckdup);
		if ($check > 0) {
			$dup = "<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
		} else {

			// echo "INSERT into voucher_pay set bulk_vid='$bulk_vid',rec_no='$rec_no',rec_from='$rec_from',rec_date='$rec_date',amt='$amt',pay_mode='$pay_mode',remark='$remark',user_id='$userid',created_date='$createdate',compid='$compid',sessionid='$sessionid'";die;
			mysqli_query($connection, "INSERT into voucher_pay set bulk_vid='$bulk_vid',rec_no='$rec_no',rec_from='$rec_from',rec_date='$rec_date',amt='$amt',pay_mode='$pay_mode',remark='$remark',user_id='$userid',created_date='$createdate',compid='$compid',sessionid='$sessionid'");
			  $lastid = $connection->insert_id;
				mysqli_query($connection, "INSERT into transaction set bulk_vid='$bulk_vid',pay_id='$lastid',consignorid='$consignorid',consigneeid='$consigneeid', trans_date='$rec_date',particular='Payment',amt='$amt',user_id='$userid',created_at='$createdate',compid='$compid',sessionid='$sessionid'");
			 $lasttrans_id = $connection->insert_id;
    mysqli_query($connection,"UPDATE voucher_pay set trans_id='$lasttrans_id' WHERE pay_id ='$lastid'" );
			$action = 1;
			 $totamt = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$bulk_vid'");
	   $recamt = $cmn->getvalfield($connection, "voucher_pay", "sum(amt)", "bulk_vid='$bulk_vid'");
	   if($totamt == $recamt){
	        	mysqli_query($connection, "UPDATE trip_entry set is_paid='1' WHERE bulk_vid ='$bulk_vid'");
	       	mysqli_query($connection, "UPDATE payment_recive set is_pay='1' WHERE bulk_vid ='$bulk_vid'");
	       	 	mysqli_query($connection, "UPDATE voucher_entry set is_pay='1' WHERE bulk_vid ='$bulk_vid'");
	   }
			echo "<script>location='bilty_return_payment_voucher.php?action=$action'</script>";
		}
	} else {
		mysqli_query($connection, "UPDATE voucher_pay set bulk_vid='$bulk_vid',rec_no='$rec_no',rec_from='$rec_from',rec_date='$rec_date',amt='$amt',pay_mode='$pay_mode',remark='$remark',user_id='$userid',created_date='$createdate',compid='$compid',sessionid='$sessionid' WHERE pay_id ='$_GET[editid]'");
	
	
		$action = 2;
			 $totamt = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$bulk_vid'");
	   $recamt = $cmn->getvalfield($connection, "voucher_pay", "sum(amt)", "bulk_vid='$bulk_vid'");
	   if($totamt==$recamt){
	       	mysqli_query($connection, "UPDATE payment_recive set is_pay='1', WHERE bulk_vid ='$bulk_vid'");
	       	 	mysqli_query($connection, "UPDATE voucher_entry set is_pay='1', WHERE bulk_vid ='$bulk_vid'");
	   }
		echo "<script>location='bilty_return_payment_voucher.php?action=$action'</script>";
	}
}

if ($_GET['editid'] != '') {
	$sql = mysqli_query($connection, "select * from voucher_pay WHERE pay_id='$_GET[editid]'");
	$row = mysqli_fetch_array($sql);
	$bulk_vid = $row['bulk_vid'];
	$rec_no = $row['rec_no'];
	$rec_from = $row['rec_from'];
	$rec_date = $row['rec_date'];
  $amt=$row['amt'];
	$pay_mode = $_POST['pay_mode'];
	$remark = $row['remark'];
} else {
	$bulk_vid = '';
	$amt = '';
		   $lrec = $cmn->getvalfield($connection, "voucher_pay", "max(rec_no)", "1=1") +1;
 $rec_no='0000'.$lrec;
	$rec_date = '';
	$rec_from = '';
	$pay_mode = '';
	$remark = '';
}
//echo "SELECT A.ownerid,B.voucher_id,B.payment_date from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid) where A.ownerid='$_GET[ownerid]' && B.compid='$compid' &&  B.sessionid='$sessionid' && B.voucher_id!=0 group by B.voucher_id";die;
?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#0CF;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:230px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>
<script>

  
  $(function() {
   
   $('#receive_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
     
  });

</script>

</head>

<body data-layout-topbar="fixed">
 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
					
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from bidding_entry $crit  && recweight !='0' && ownerid =4"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >                                       
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp;Bilty Payment Voucher </legend>   
                <div class="innerdiv">
                    <div> Voucher No <span class="err" style="color:#F00;">*</span></div>
                    <div class="text"> 
                    <select data-placeholder="Choose a Vehicle..." name="bulk_vid" id="bulk_vid" style="width:210px" onchange="getdetails(this.value);" tabindex="1" class="select2-me input-large"  required>
														<option value="">Select Voucher No</option>
														<?php
														$sql = mysqli_query($connection, "select * from voucher_entry where is_pay=0 order by voucher_no");
														while ($row = mysqli_fetch_array($sql)) {

														?>
															<option value="<?php echo $row['bulk_vid']; ?>"><?php echo $row['voucher_no']; ?></option>

														<?php } ?>
														<script>
															document.getElementById('bulk_vid').value = '<?php echo $bulk_vid; ?>';
														</script>

													</select>
                   
                </div>
               </div>
               <div class="innerdiv">
                    <div> Party Name <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
              
                    <input type="text" name="partyname" id="partyname" placeholder="Enter Name" class="form-control" tabindex="4" value="<?php echo $partyname; ?>" readonly>

                </div>
               </div>
               <div class="innerdiv">
                    <div> Voucher Amount  </div>
                    <div class="text">
<input type="text" name="vamt" id="vamt" placeholder="Enter Name" class="form-control" tabindex="4" value="<?php echo $vamt; ?>" readonly>

                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Balance Amt</div>
                    <div class="text">
													<input type="text" name="balamt" id="balamt" placeholder="Enter Name" class="form-control" tabindex="4" value="<?php echo $balamt; ?>" readonly>

                </div>
                </div>
                <div class="innerdiv">
                    <div>Received No  </div>
                    <div class="text">
													<input type="text" name="rec_no" id="rec_no" placeholder="Enter Serial Number" class="form-control" tabindex="4" value="<?php echo $rec_no; ?>" readonly>

                </div>
                </div>
                
                
                <div class="innerdiv">
                    <div>Received From </div>
                    <div class="text">
													<input type="text" name="rec_from" id="rec_from" placeholder="Enter Name" class="form-control" tabindex="4" value="<?php echo $rec_from; ?>" required>

                </div>
                </div>


                
                
                
                

        
                        
                
                <div class="innerdiv">
                    <div> Received Date </div>
                    <div class="text">
                    <input type="date" name="rec_date" id="rec_date" placeholder="Expenses Date" class="form-control" tabindex="5" value="<?php echo $rec_date; ?>" required>

                </div>
                </div>

                <div class="innerdiv">
                    <div>Received Amount </div>
                    <div class="text">
													<input type="text" name="amt" id="amt" placeholder="Enter Amount" class="form-control" tabindex="5" value="<?php echo $amt; ?>" required>

                </div>
                </div>
                
                
              <div class="innerdiv">
                    <div> Payment Mode </div>
                    <div class="text">
                     <select data-placeholder="Choose a Vehicle..." name="pay_mode" id="pay_mode" style="width:210px"  tabindex="1" class="formcent select2-me" >
														<option value="">Select</option>
														<option value="Cash">Cash</option>
															<option value="NEFT">NEFT</option>
															<option value="Cheque">Cheque</option>
														<script>
															document.getElementById('pay_mode').value = '<?php echo $pay_mode; ?>';
														</script>

													</select>
                </div>
                </div>
         
                <div class="innerdiv">
                    <div>Remark </div>
                    <div class="text">
													<input type="text" name="remark" id="remark" placeholder="Remark" class="form-control" tabindex="6" value="<?php echo $remark; ?>">

                </div>
                </div>
             
			   
           
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="submit" class="btn btn-success" id="" value="Save"  onClick="return chepayment(); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
													<input type="hidden" name="maintance_id" id="maintance_id" value="<?php echo $_GET['editid']; ?>">

                    </div>
                    </div>
               
    				</fieldset>
    		        
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
            <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
					   
						<div class="box box-bordered">
						    <div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3></div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
										<th>S.No.</th>

										<th>Voucher No.</th>
										<th>Party Name</th>
										<th>Received From</th>
										<th>Received Amt.</th>

										<th>
											Received Date</th>
										<th>Remark</th>
										<th class='hidden-350'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php $sn = 1;
										$sql = mysqli_query($connection, "select * from voucher_pay where compid='$compid' order by pay_id  desc");
										while ($row = mysqli_fetch_array($sql)) {
                                            $consignorid=$row['consignorid'];
                                            $consigneeid=$row['consigneeid'];
											$voucher_no = $cmn->getvalfield($connection, "voucher_entry", "voucher_no", "bulk_vid='$row[bulk_vid]'");
								$consignorid = $cmn->getvalfield($connection, "voucher_entry", "consignorid", "bulk_vid='$row[bulk_vid]'");
								$consigneeid = $cmn->getvalfield($connection, "voucher_entry", "consigneeid", "bulk_vid='$row[bulk_vid]'");
								// 			$head_name = $cmn->getvalfield($connection, "main_head_master", "head_name", "main_head_id='$row[main_head_id]'");
                          $partyname = $cmn->getvalfield($connection, "supplier_master", "party_name", "supplier_id='$partyid'");
                          if($consignorid!=0){
                            $partyname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$consignorid'");
                    
                        } if($consigneeid!=0){
                            $partyname = $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$consigneeid'");
                    
                        }
										?>
											<tr>
												<td><?php echo $sn++; ?></td>
												<td><?php echo $voucher_no; ?></td>
												<td><?php echo $partyname; ?></td>
												<td><?php echo $row['rec_from']; ?></td>
												<td><?php echo $row['amt']; ?></td>

												<td><?php echo date('d-m-Y', strtotime($row['rec_date'])); ?></td>
												<td><?php echo $row['remark']; ?></td>


												<td>
													<!--<a href='maintance_entry.php?editid=<?php echo $row['pay_id']; ?>' class="btn btn-magenta">Edit</a>-->
													<a  onClick="funDel(<?php echo $row['pay_id']; ?>)" class="btn btn-satblue">Delete</a>
													   <a href="pdf_voucherpay.php?pay_id=<?php echo $row['pay_id'] ?>" class="btn btn-primary" target="_blank">
                     <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></td>
												</td>
											<?php } ?>
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
            </div>
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
function funDel(id) {

var tablename = 'voucher_pay';
var tableid = 'pay_id';
if (confirm("Do You want to Delete this record ?")) {
    jQuery.ajax({
        type: 'POST',
        url: 'delete_vpay.php',
        data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
        dataType: 'html',
        success: function(data) {

            location = 'bilty_return_payment_voucher.php?action=3';
        }
    }); //ajax close
}
}



function getdetails(bulk_vid) {
// alert(bulk_vid);
				jQuery.ajax({
					type: 'POST',
					url: 'getvdetails.php',
					data: 'bulk_vid=' + bulk_vid ,
					dataType: 'html',
					success: function(data) {
                       
   arr=data.split("|");
               jQuery('#partyname').val(arr[0]);
               jQuery('#vamt').val(arr[1]);
              jQuery('#balamt').val(arr[2]);
            //   jQuery('#rec_no').val(arr[3]);
				// 		location = 'maintance_entry.php?action=3';
					}
				}); //ajax close
			
		}

</script>			
                
		
	</body>

	</html>
