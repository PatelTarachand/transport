<?php  
include("dbconnect.php");
include("../lib/smsinfo.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bilty_entry.php';
$modulename = "Bilty Entry";

if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));	
}
else
$bid_id='';
$totalamt='';
$netamt='';
$chalan='';



$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
$row=mysqli_fetch_assoc($sql);

$consignorid = $row['consignorid'];
$tokendate = $row['tokendate'];
$placeid = $row['placeid'];
$destinationid = $row['destinationid'];
$comp_rate = $row['comp_rate'];
$own_rate = $row['own_rate'];
$totalweight = $row['totalweight'];
$di_no = $row['di_no'];
$brand_id = $row['brand_id'];
$biltyremark = $row['biltyremark'];
$invoiceno =$row['invoiceno']; 
if($invoiceno=='') { $invoiceno = $cmn->getvalfield($connection,"m_session","inv_prefix","sessionid='$sessionid'"); }


$gr_date = $cmn->dateformatindia($row['gr_date']);
$driver =  $row['driver'];
$gr_no = $row['gr_no'];

//FGC/SJE/

if($gr_no=="") {
	$gr_no="FGC/SJE/";
}

$distance = $row['distance'];

$freightamt = $row['freightamt'];
$deliverat = $row['deliverat'];
$truckid = $row['truckid'];
$noofqty = $row['noofqty'];
$discount = $row['discount'];
$is_bilty = $row['is_bilty'];
if ($is_bilty==0)
{
$chalan = $cmn->getcode($connection,"bidding_entry","chalan","sessionid=$sessionid");
}
else
$chalan = $row['chalan'];



$bilty_date = $row['bilty_date']; 
$s = $row['tokendate'];
$dt = new DateTime($s);											
 $bilty_date = $dt->format('d-m-Y'); 
//echo $totalweight; die;
$totalamt = $own_rate * $totalweight;

$netamount = $totalamt - $discount;




if(isset($_GET['edit']))
{
	$success  = strrev(trim(addslashes($_GET['success'])));
	
	$otp = $cmn->getvalfield($connection,"bidding_entry","otp","bid_id='$bid_id'");
	if($otp !='')
	{
		if($success !=$otp)
		{	
			echo "<script>location='bidding_entry.php'</script>";
		}
	}
	else
	{
	echo "<script>location='bidding_entry.php'</script>";
	}
}



if(isset($_POST['sub'])) {

$biltyremark = $_POST['biltyremark'];
$gr_date = $cmn->dateformatusa($_POST['gr_date']);
$gr_no = $_POST['gr_no'];
$distance = $_POST['distance'];
$freightamt = $_POST['freightamt'];
$deliverat = $_POST['deliverat'];
$truckid = isset($_POST['truckid'])?$_POST['truckid']:'';
$noofqty = $_POST['noofqty'];
$discount = $_POST['discount'];
$chalan = $_POST['chalan'];
$invoiceno = $_POST['invoiceno'];
$driver =$_POST['driver']; 

$bilty_date = date('Y-m-d');
$is_bilty = 1;
 



//$is_bilty = $cmn->getvalfield($connection,"bidding_entry","is_bilty","bid_id='$bid_id'");

//if($is_bilty==0) {
//$truckid = $cmn->getvalfield($connection,"bidding_entry","truckid","bid_id='$bid_id'");
$consigneeid = $cmn->getvalfield($connection,"bidding_entry","consigneeid","bid_id='$bid_id'");

$consigneemob1 = $cmn->getvalfield($connection,"m_consignee","mob1","consigneeid='$consigneeid'");

$di_no = $cmn->getvalfield($connection,"bidding_entry","di_no","bid_id='$bid_id'");
//$gr_no = $cmn->getvalfield($connection,"bidding_entry","gr_no","bid_id='$bid_id'");
//$deliverat = $cmn->getvalfield($connection,"bidding_entry","deliverat","bid_id='$bid_id'");
$totalweight = $cmn->getvalfield($connection,"bidding_entry","totalweight","bid_id='$bid_id'");
$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
$ownermobileno1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");

$message = "Bilty Date:".$cmn->dateformatindia($bilty_date)."\nDI No: $di_no\nGR No: $gr_no\nTruck No: $truckno\nWeight: $totalweight MT\nDestination: $deliverat \nFrom : Sarthak Logistics";

//sendsmsGET("$ownermobileno1,9340940289",$senderId,$routeId,$message,$serverUrl,$authKey); now
//sendsmsGET($consigneemob1,$senderId,$routeId,$message,$serverUrl,$authKey); now
//die;
//}

		 $sql_update = "update  bidding_entry set  bilty_date='$bilty_date',gr_no='$gr_no',gr_date='$gr_date',biltyremark='$biltyremark',invoiceno='$invoiceno',distance='$distance',driver='$driver',chalan='$chalan',freightamt='$freightamt',truckid='$truckid',deliverat='$deliverat',noofqty='$noofqty',discount='$discount',is_bilty='$is_bilty'  where bid_id='$bid_id'"; 
			 //die;
			 
			// echo "update  bidding_entry set  bilty_date='$bilty_date',gr_no='$gr_no',gr_date='$gr_date',biltyremark='$biltyremark',invoiceno='$invoiceno',distance='$distance',driver='$driver',chalan='$chalan',freightamt='$freightamt',truckid='$truckid',deliverat='$deliverat',noofqty='$noofqty',discount='$discount',is_bilty='$is_bilty'  where bid_id='$bid_id'"; 
			//die;
		
		
			 
				 
	 
		mysqli_query($connection,$sql_update);
		//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
		echo "<script>location='bilty_entry.php?action=2'</script>";
	
	
}

//
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
$(document).ready(function(){
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
});
$(document).ready(function(){
	$("#shortcut_consigneeid").click(function(){
		$("#div_consigneeid").toggle(1000);
	});
	});
	$(document).ready(function(){
	$("#short_place").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});
	
	
	$(function() {
   
	 $('#bilty_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	  $('#gr_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	
  });

</script>
</head>

<body data-layout-topbar="fixed">

<div class="messagepop pop" id="div_truck">
<img src="b_drop.png" class="close" onClick="$('#div_truck').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Truck </strong></td></tr>
  <tr><td>&nbsp;<b>Owner Name:</b> </td></tr>
  <tr>
  	<td>
  		<select name="sc_ownerid" id="sc_ownerid" class="select2-me" style="width:202px;">
        <option value="">--select--</option>
        <?php 
		$sql_sc = "select * from m_truckowner order by ownername"; 
		$res_sc = mysqli_query($connection,$sql_sc);
		while($row_sc = mysqli_fetch_array($res_sc))
		{ ?>
        	<option value="<?php echo $row_sc['ownerid']; ?>"><?php echo $row_sc['ownername']; ?></option>
		<?php
        }
		?>
        </select>
  	</td>
  </tr>
  <tr><td>&nbsp;<b>Truck Number:</b> </td></tr>
  <tr><td><input type="text" name="sc_truckno" id="sc_truckno" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_truckno('sc_ownerid','sc_truckno');"/></td></tr>
</table>
</div>
	
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                  	  
    				<fieldset style="margin-top:45px; margin-left:45px;" >
       <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                 
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Bilty</legend>
                 
                   
                <div class="innerdiv">
                    <div>Di no. <span class="err" style="color:#F00;">*</span></div>
                   <div class="text">
                  <select id="bid_id" name="bid_id" class="select2-me input-large" style="width:220px;" onChange="getdetail();">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bid_id,di_no from bidding_entry where sessionid='$sessionid'");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['bid_id']; ?>"><?php echo $row_fdest['di_no']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('bid_id').value = '<?php echo $bid_id; ?>';</script>
                    </div>
               </div>
                 
                <div class="innerdiv">
                    <div>Bilty Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="bilty_date" id="bilty_date" value="<?php echo 	$bilty_date; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
				
				 <div class="innerdiv">
                    <div>Invoice No <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" class="formcent" name="invoiceno" id="invoiceno" value="<?php echo $invoiceno; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >                
                </div>
                </div>
            
               
           
                <br>
                <br>
				
				<div class="innerdiv">
                    <div>GR No <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" class="formcent" name="gr_no" id="gr_no" value="<?php echo $gr_no; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >                
                </div>
                </div>


            <div class="innerdiv">
                <div>GR Date<span class="err" style="color:#F00;">*</span> &nbsp;</div>
                <div class="text">
                 <input type="text" class="formcent" name="gr_date" id="gr_date" value="<?php echo 	$gr_date; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                   </div>
              
                
               
					
            	<div class="innerdiv">
                	<div>Distance<span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
            		 <input type="text" class="formcent" name="distance" id="distance" value="<?php echo $distance; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
				
				<br>
<br>

                
                   <div class="innerdiv">
                    <div>Freight Amt</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="freightamt" id="freightamt" value="<?php echo $freightamt;?>" style="border: 1px solid #368ee0" autocomplete="off" >                 
                    </div>
					</div>
                
                 <div class="innerdiv">
                    <div> Truck No <span class="err" style="color:#F00;">*</span> &nbsp;<img src="add.png" id="shortcut_truck"><a href="#" id="add_new" data-form="short_truck" tabindex="49"></a></div>
                    <div class="text">
                                     <select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;" >
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
                  
                    </div>
					</div>
					
        	
        		 <div class="innerdiv">
                    <div>Deliver At</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="deliverat" id="deliverat" value="<?php echo $deliverat;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
					
					 <div class="innerdiv">
                    <div>Driver Name :</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="driver" id="driver" value="<?php echo $driver;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
					
                     <div class="innerdiv">
                    <div>Company Rate</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="comp_rate" id="comp_rate" value="<?php echo $comp_rate;?>" style="border: 1px solid #368ee0; background-color:#CFC;" autocomplete="off" readonly >                   
                    </div>
					</div>  
                    
                     <div class="innerdiv">
                    <div>Own Rate</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="own_rate" id="own_rate" value="<?php echo $own_rate;?>" style="border: 1px solid #368ee0; background-color:#CFC;" autocomplete="off" readonly >                   
                    </div>
					</div>  
                    
                      <div class="innerdiv">
                    <div>Total Weight/MT</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="totalweight" id="totalweight" value="<?php echo $totalweight;?>" style="border: 1px solid #368ee0; background-color:#CFC;" autocomplete="off" readonly >                   
                    </div>
					</div> 
                    
                     <div class="innerdiv">
                    <div>Total Amount</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="totalamt" id="totalamt" value="<?php echo number_format($totalamt,2);?>" style="border: 1px solid #368ee0; background-color:#CFC;" autocomplete="off" readonly >                   
                    </div>
					</div> 
            
            	      <div class="innerdiv">
                    <div>Qty (Bags)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="noofqty" id="noofqty" value="<?php echo $noofqty;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>    
                    
                     <div class="innerdiv">
                    <div>Discount (Rs)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="discount" id="discount" value="<?php echo $discount;?>" style="border: 1px solid #368ee0" autocomplete="off" onChange="getnetamt();" >                   
                    </div>
					</div> 
                    
                     <div class="innerdiv">
                    <div>Net Amount</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="netamt" id="netamt" value="<?php echo number_format($netamount,2);?>" style="border: 1px solid #368ee0; background-color:#CFC;" autocomplete="off" readonly >                   
                    </div>
					</div> 
					
					
					<div class="innerdiv">
                    <div>Chalan No.</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="chalan" id="chalan" value="<?php echo $chalan;?>" style="border: 1px solid #368ee0" autocomplete="off" readonly>                   
                    </div>
					</div>  
					      
                    
        		 <div class="innerdiv">
                    <div>Remark</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="biltyremark" id="biltyremark" value="<?php echo $biltyremark; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
                    



					
					<div class="innerdiv">
                    <br>
<br>

                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('tokenno,tokendate,consignorid,placeid,destinationid'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                  </div>
					
                   
    				</fieldset>
    		        <input type="hidden" name="bid_id" id="bid_id" data-key="primary" value="<?php echo $bid_id; ?>">
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						
						<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="billty_record2.php" target="_blank">Click Here</a>)</span></h3>
							</div>
							
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                           <th>DI No</th>
										   <th>GR No</th>
										   <th>Invoice No</th>
										   
                                        	<th>Consignee</th>
											 <th>Destination</th>
                                            
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                            
                                             <th>Print</th>
                                        	 <th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										//$cond="where createdby='$userid' ";	
										$cond="where 1=1 ";	
									}
									
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 && consignorid =4 order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                           
										   <td><?php echo ucfirst($row['di_no']);?></td>
										   <td><?php echo ucfirst($row['gr_no']);?></td>
										   <td><?php echo ucfirst($row['invoiceno']);?></td>
										   
                                           <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
										 <td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                            
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
											
<td><a href= "pdf_bill_invoice.php?bid_id=<?php echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>
                                           
                                           
                                            <td class='hidden-480'>
                                           <a href= "bilty_entry.php?bid_id=<?php echo ucfirst($row['bid_id']);?>&sms=true"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                          <!-- <a onClick="funDel('<?php //echo $row['bid_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
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

function getdetail()
{
	var bid_id = document.getElementById('bid_id').value;
	
	if(bid_id !='') {
			window.location.href='?bid_id='+bid_id;
		}
}

function getnetamt() {
	var totalweight = parseFloat(document.getElementById('totalweight').value);
	var own_rate = parseFloat(document.getElementById('own_rate').value);
	var discount = parseFloat(document.getElementById('discount').value);
	
		if(isNaN(totalweight)) { totalweight=0; }
		if(isNaN(own_rate)) { own_rate=0; }
		if(isNaN(discount)) { discount=0; }	
		
		var totalamt = totalweight * own_rate;		
		var netamt = totalamt - discount;
		
		document.getElementById('totalamt').value= totalamt.toFixed(2);
		document.getElementById('netamt').value= netamt.toFixed(2);
	
	}


function ajax_save_shortcut_truckno(sc_ownerid,sc_truckno)
{
	var ownerid = document.getElementById(sc_ownerid).value;
	var truckno = document.getElementById(sc_truckno).value;
	
	if(ownerid == "" || truckno == "")
	{
		alert('Fill form properly');
		document.getElementById(sc_truckno).focus();
		return false;
	}
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("truckid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("sc_truckno").value = "";
				document.getElementById("sc_ownerid").value = "";
				$("#div_truck").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savetruck.php?truckno="+truckno+"&ownerid="+ownerid,true);
	xmlhttp.send();
}

</script>			
                
		
	</body>

	</html>
