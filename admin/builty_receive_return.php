<?php
include("dbconnect.php");
$tblname = "";
$tblpkey = "";
$pagename = "builty_receive.php";
$modulename = "Bilty Receiving Report";

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

if(isset($_GET['di_no']))
{
	$di_no = trim(addslashes($_GET['di_no']));	
}
else
$di_no = '';

if($di_no !='') {
	
	$cond .=" and lr_no='$di_no'";
	
	}
	
if($start_date !='' && $end_date !='')
{
		$cond .=" and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$start_date' and '$end_date' ";
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
<style>
.btn.btn-danger{
border-radius:4px !important;
}
</style>
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
							<!-- <legend class="legend_blue"><a href="dashboard.php">
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                                 <form  method="get" action="" class='form-horizontal' >
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    
                                    <td style="width: 10%;"><strong>From Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td style="width: 10%;"><input type="text" name="start_date" id="start_date" value="<?php echo $cmn->dateformatindia($start_date); ?>" autocomplete="off"   tabindex="2"  class="input-medium" required></td>
                                
                                    <td style="width: 10%;"><strong>To Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td style="width: 10%;"><input type="text" name="end_date" id="end_date" value="<?php echo  $cmn->dateformatindia($end_date); ?>" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
                                       <td style="width: 5%;"><strong>LR No.</strong> <strong>:</strong><span class="red">*</span></td>
<td style="width: 12%;"><input type="text" name="di_no" id="di_no" value="<?php echo $di_no; ?>" maxlength="10" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
                                    <td style="width: 12%;">
                                 
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
								<a class="btn btn-primary btn-lg" href="excel_builty_receive_return.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&di_no=<?php echo $di_no; ?>" target="_blank" style="float:right;"> Excel </a>
							</div>
							
							<div class="box-content nopadding" style='overflow:scroll'>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th >Sno</th>  
                                          
											<th >LR No.</th>
											<th >Truck No.</th>
                                        	<th >Bilty Date</th>
                                            <th >Des. Wt.</th>
											 <th >Rec. Wt.</th>
											  <th >Dispatch Bags</th>
											   <th >Rec. Bags</th>
                                        	<th >Unloading Place</th>
                                            
											<th >Recd. Dt.</th>                                            									                                            
											<th >Shortage(MT)</th>  
											<th >Shortage(Bags)</th> 
                                             <th>Final Pay</th>  
                                             <th>Action</th>  

                                        
                                           
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
				// 		echo "select * from bidding_entry where 1=1 && is_bilty=1 and compid='$compid' and isreceive!=0 $cond and sessionid =$sessionid";
						
						$sql = mysqli_query($connection,"select * from returnbidding_entry where 1=1 && is_bilty=1 and compid='$compid' and isreceive!=0 $cond and sessionid =$sessionid");
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['placeid'];
						$bid_id = $row['bid_id'];
						$recweight = $row['recweight'];
						
						if($recweight==0) { $recweight= $row['totalweight']; }
						
						$destaddress = $row['destaddress'];
						$recdate = $cmn->dateformatindia($row['recdate']);
						$sortagr = $row['sortagr'];	
						$truckid = $row['truckid'];
						$noofqty = $row['noofqty'];						
						$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
						$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
						$recbag = $row['recbag'];
						
						if($recdate !='') {
						$sortagbag = $noofqty - $row['recbag'];
						}
						else
						$sortagbag='';	 
						
						$fpay = $row['fpay'];
						
						?>
                      
					<tr>
							 <td><?php echo $sn++; ?></td>
                          
							<td><?php echo $row['lr_no']; ?></td>
							<td><?php echo $truckno; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><span id="totalweight<?php echo $bid_id; ?>"><?php echo $row['totalweight']; ?></span></td>
                        
                            <td>
							<span id="rec1" style="color:red;" >*</span>
                            <input type="text" class="input-small" value="<?php echo $recweight; ?>" id="recweight<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px; width:60px;"  autocomplete="off" onChange="getshortage(<?php  echo $bid_id; ?>);" >
                            </td>
							
							
							 <td><span id="totalbag<?php echo $bid_id; ?>"><?php echo $row['noofqty']; ?></span></td>
                        
                            <td>
							<span style="color:red;" >*</span>
                            <input type="text" class="input-small" value="<?php echo $recbag; ?>" id="recbag<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px;width:60px;"  autocomplete="off" onChange="getshortage(<?php  echo $bid_id; ?>);" >
                            </td>
							
							
                            <td> <?php echo $placename; ?>  </td>
							
                            
                            <td>
							<span id="recdate1" style="color:red;" >*</span>
							 <input type="text" class="formcent recdate" value="<?php echo $recdate; ?>" id="recdate<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:80px;"  autocomplete="off" 
                                      >
                            </td>
                            <td>
							<input type="text" value="<?php echo $sortagr; ?>" id="sortagr<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;background-color:#6CF;width:60px;"  autocomplete="off"  readonly >  
							</td>
							
							<td>
							<input type="text" value="<?php echo $sortagbag; ?>" id="sortagbag<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;background-color:#6CF;width:60px;"  autocomplete="off"  readonly >  
							</td>
							<td>
                          <input type="text" class="input-small" value="<?php echo $fpay; ?>" id="fpay<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:80px;"  autocomplete="off" >  
                            </td>
							<td>    <a onClick="funDelotp('<?php echo $row['bid_id']; ?>');"><img src="../img/del.png" title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel('<?php echo $row['bid_id'];?>');" value="X"></td>
                          
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
			

			  location='builty_receive.php?action=10&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date; ?>&di_no=<?php echo $di_no ;?>';


			}
		
		  });//ajax close
	}//confirm close
} //fun close

function hideval()
{
	var paymode = document.getElementById('paymode').value;
	if(paymode == 'cash')
	{
		document.getElementById('checquenumber').disabled = true;
		document.getElementById('session_name').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('session_name').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('session_name').disabled = false;
	}
}

function getshortage(bid_id)
{
	var totalweight = parseFloat(document.getElementById('totalweight'+bid_id).innerHTML);	
	var recweight = parseFloat(document.getElementById('recweight'+bid_id).value);
	var recbag = parseFloat(document.getElementById('recbag'+bid_id).value);
	var totalbag = parseFloat(document.getElementById('totalbag'+bid_id).innerHTML);
	
	if(isNaN(totalweight)) { totalweight=0; }
	if(isNaN(recweight)) { recweight=0; }
	if(isNaN(recbag)) { recbag=0; }
	if(isNaN(totalbag)) { totalbag=0; }
	
	var shortage = totalweight - recweight;
	var shortagebag = totalbag - recbag;
	
	document.getElementById('sortagr'+bid_id).value = shortage ;
	document.getElementById('sortagbag'+bid_id).value = shortagebag ;
	
}


function getsave(bid_id) {
	var recweight = document.getElementById('recweight'+bid_id).value;
	var recdate = document.getElementById('recdate'+bid_id).value;
	var sortagr = document.getElementById('sortagr'+bid_id).value;
	var recbag = document.getElementById('recbag'+bid_id).value; 
	var fpay = document.getElementById('fpay'+bid_id).value;  
	//alert(fpay);
	document.getElementById("msg"+bid_id).innerHTML='';
	
	
	
	if (recweight=='' || recweight=='0')
	{
	alert ("Please Enter Receive weight");
	document.getElementById('recweight'+bid_id).value='';
	document.getElementById('recweight'+bid_id).focus();
	 return false;
	}
	if (recdate=='')
	{
	alert ("Please Enter Receive Date"); 
	document.getElementById('recdate'+bid_id).value='';
	document.getElementById('recdate'+bid_id).focus();
	return false;
	}
	
	
	$.ajax({
		  type: 'POST',
		  url: 'updaterecieving.php',
		  data: 'bid_id=' + bid_id + '&recweight=' + recweight + '&recdate=' + recdate + '&sortagr=' +sortagr+'&recbag='+recbag+'&fpay='+fpay,
		  dataType: 'html',
		  success: function(data){
			//  alert(data);
			 // alert('Data Deleted Successfully');
			 if(data==1) {
				 document.getElementById('msg'+bid_id).innerHTML='Updated';
				 
				 }
			}
		
		  });//ajax close
	
	}


</script>
<script>
function checkval()
	{
	var recweight = document.getElementById('recweight').value.trim();
	var destaddress=document.getElementById('destaddress').value.trim();
	var recdate=document.getElementById('recdate').value.trim();
	
	if(recweight=='')
		{
			//alert("Please Enter Full Name");
			document.getElementById('rec1').innerHTML;
			document.getElementById("recweight").focus(); 
			return false;
		}
		
		if(destaddress=='')
		{
			//alert("Please Enter Full Name");
			document.getElementById('rec1').innerHTML;
			document.getElementById("des1").focus(); 
			return false;
		}
		
		if(recdate=='')
		{
			//alert("Please Enter Full Name");
			document.getElementById('rec1').innerHTML;
			document.getElementById("recdate1").focus(); 
			return false;
		}

	
return true;
	}
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
		  url: '../ajax/deletebuiltyreceive.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			  // alert(data);
			 // alert('Data Deleted Successfully');
			  location='builty_receive.php?action=10&start_date=<?php echo dateformatusa($start_date);?>&end_date=<?php echo dateformatusa($end_date); ?>&di_no=<?php echo $di_no ;?>';

			}
		
		  });//ajax close
	}//confirm close
} //fun close
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
				location=pagename+'?action=10';
			}	
		  });//ajax close
		}	
}
function checkotpppp() {
	var otp = document.getElementById('otpppp').value;
	var ref_id = document.getElementById('ref_idddd').value;
	// alert(ref_id);
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
</script>

	</body>
    

	</html>
<?php
mysqli_close($connection);
?>
