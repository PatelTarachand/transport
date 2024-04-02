<?php
include("dbconnect.php");
$tblname = "";
$tblpkey = "";
$pagename = "bilty_payment_confirmation.php";
$modulename = "Bilty Payment Confirmation";

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
	
	$cond .=" and di_no='$di_no'";
	
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
                                    
                                    <td><strong>From Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="start_date" id="start_date" value="<?php echo $cmn->dateformatindia($start_date); ?>" autocomplete="off"   tabindex="2"  class="input-medium" required></td>
                                
                                   
                                    <td><strong>To Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="end_date" id="end_date" value="<?php echo  $cmn->dateformatindia($end_date); ?>" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
                                       <td><strong>D.I No.</strong> <strong>:</strong><span class="red">*</span></td>
<td><input type="text" name="di_no" id="di_no" value="<?php echo $di_no; ?>" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
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
											<th >Invoice No.</th>
											<th >Truck No.</th>
                                        	<th >Bilty Date</th>
                                            <th >Des. Wt.</th>
											 <th >Rec. Wt.</th>
											  
											<th >conf. Payment Dt.</th>                                            									                                          
                                        	<th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
						// echo "select * from bidding_entry where 1=1 && is_bilty=1 $cond";
						$sql = mysqli_query($connection,"select * from bidding_entry where 1=1  $cond and confdate='0000-00-00' order by bid_id desc ");
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
						
							 
						
						
						
						?>
                      
					<tr>
							 <td><?php echo $sn++; ?></td>
                            <td><?php echo $row['lr_no']; ?></td>
							
							<td><?php echo $row['gr_no']; ?></td>
							<td><?php echo $row['invoiceno']; ?></td>
							<td><?php echo $truckno; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><span id="totalweight<?php echo $bid_id; ?>"><?php echo $row['totalweight']; ?></span></td>
                        
                            <td>
							<span id="rec1" style="color:red;" >*</span>
                            <input type="text" class="input-small" value="<?php echo $recweight; ?>" id="recweight<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px; width:100px;"  autocomplete="off" onChange="getshortage(<?php  echo $bid_id; ?>);" >
                            </td>
							
                            <td>
							<span id="recdate1" style="color:red;" >*</span>
							 <input type="text" class="formcent recdate" value="<?php echo $confdate; ?>" id="confdate<?php echo $bid_id; ?>"  style="border: 1px solid #368ee0;width:140px;"  autocomplete="off" 
                                      >
                            </td>
                            
                           <td>
                           <input type="button" class="btn btn-sm btn-success" value="Save" onClick="getsave(<?php echo $bid_id; ?>);"  >
                          <span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> 
                           
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
			  location=pagename+'?action=10';
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
	
	var confdate = document.getElementById('confdate'+bid_id).value;
	
	
	document.getElementById("msg"+bid_id).innerHTML='';
	
	
	
	
	if (confdate=='')
	{
	alert ("Please Enter Conf Date"); 
	document.getElementById('confdate'+bid_id).value='';
	document.getElementById('confdate'+bid_id).focus();
	return false;
	}
	
	
	$.ajax({
		  type: 'POST',
		  url: 'updateconfirmation.php',
		  data: 'bid_id=' + bid_id + '&confdate=' + confdate,
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

}
return true;
	}

</script>

	</body>
    

	</html>
<?php
mysqli_close($connection);
?>
