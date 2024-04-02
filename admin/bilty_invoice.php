<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bilty_invoice.php';
$modulename = "Bilty Invoice";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


$crit=" ";

if(isset($_GET['edit'])) {
	$invoiceid = trim(addslashes($_GET['edit']));
	$invno = $cmn->getvalfield($connection,"invoicebilty","invno","invoiceid='$invoiceid'");
	$invdate = $cmn->getvalfield($connection,"invoicebilty","invdate","invoiceid='$invoiceid'");
	$itemtype = $cmn->getvalfield($connection,"invoicebilty","itemtype","invoiceid='$invoiceid'");	
}
else
{
$invoiceid=0;
$invno='';
$invdate = date('Y-m-d');
$itemtype='';
}

if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	$type = trim(addslashes($_GET['type']));
	
}
else
{
	$fromdate = date("Y-m-d", strtotime("-3 months"));
	$todate = date('Y-m-d');
	$type='';
}

if(isset($_GET['itemid']))
{
	$itemid=trim(addslashes($_GET['itemid']));
}
else
$itemid='';

if($fromdate !='' && $todate !='')
{
		$crit.=" and DATE_FORMAT(bilty_date,'%Y-%m-%d') between '$fromdate' and '$todate' ";	
}

if($itemid !='') {
	$crit .=" and A.itemid='$itemid' ";
}

if($type !='') {
	$crit .=" and B.type='$type' ";
}

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

</script>
</head>

<body data-layout-topbar="fixed">

<?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
			  <?php include("../include/showbutton.php"); ?>
					<div class="row" id="new">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
							<?php include("alerts/showalerts.php"); ?>
							
                   <form method="get" action="">
    				<fieldset style="margin-top:45px; margin-left:45px;" >    <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                    
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?>  </legend>
                            <table width="100%">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Item Name :</th>
                                            <th width="15%" style="text-align:left;">Consignee : </th>
                                            <th width="10%" style="text-align:left;">Type : </th>
                                           <!--  <th width="208" style="text-align:left;">GP No : </th>
                                            <th width="208" style="text-align:left;">Truck No : </th>
                                            -->
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td><select id="itemid" name="itemid" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from inv_m_item");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['itemid']; ?>"><?php echo $row_fdest['itemname']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('itemid').value = '<?php echo $itemid; ?>';</script></td>
                                            
               <td><select id="consigneeid" name="consigneeid" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from m_consignee order by consigneename");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['consigneeid']; ?>"><?php echo $row_fdest['consigneename']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('consigneeid').value = '<?php echo $consigneeid; ?>';</script></td>                             	
                                       
                 <td>
				 <select name="type" id="type" class="form-control" style="width:100px;">
				 								<option value="">All</option>
                                      		  <option value="0">Party</option>
                                      		  <option value="1">Dumb</option>
                                   		    </select>
                                            <script>document.getElementById('type').value='<?php echo $type; ?>';</script>
				 </td>
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                                           </td>
                                    </tr>
                                   
                                    
                            </table>    				
                    </fieldset>    		       
                    </form>
         </div>
        </div>
                	</div>  <!--rowends here -->
					
					
						<div class="box box-bordered">
							<div class="box-title">
								
							</div>
                            
                            	
							<div class="box-content nopadding">
							&nbsp; &nbsp;<strong>Search Here</strong> <input id="myInput" type="text" placeholder="Search.." >
							<input type="hidden" id="hiddenid" value="" >
							<?php if($invoiceid==0) { ?>
							<input type="button" class="btn btn-success" value="Create Invoice" style="text-align:right; float:right;" onClick="createinvoice();" > <?php } else { ?>
							<input type="button" class="btn btn-success" value="Update Invoice" style="text-align:right; float:right;" onClick="createinvoice();" >
							<?php } ?>
							
							<?php if($invoiceid==0) { ?>
								<table class="table table-hover table-nomargin table-bordered" style=" margin-left:8px;">
									<thead>
										<tr>
                                            <th><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" />All </th>  
                                            <th>GR Date</th>
                                            <th>GR No</th>
                                        	<th>Invoice No</th>
                                            <th>DI No</th>
											<th>Item Name</th>
                                            <th>Truck No</th>
                                            <th>Consignee</th>
                                            <th>Destination</th>
                                            <th>Weight/(M.T.)</th>
                                            <th>Rate/MT</th>
                                             <!--<th>Print</th>-->
                                             
                                            <th>Freight</th>
                                            <th>Advance</th>
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>
                                            <th>Brand</th>                                       	 
										</tr>
									</thead>
                                    <tbody id="myTable">
                                    <?php
									$slno=1;									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										$cond="where 1=1 ";	
									}
									
									 $sel = "select A.* from bidding_entry as A left join m_consignee as B on A.consigneeid = B.consigneeid $cond && A.sessionid='$sessionid' && A.is_bilty=1 $crit  and A.is_invoice=0 && consignorid !=4 order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
								$gr_date = $row['gr_date'];
								$truckid = $row['truckid'];
								$itemid = $row['itemid'];
								$consigneeid = $row['consigneeid'];
								$destinationid = $row['destinationid'];
								$supplier_id = $row['supplier_id'];
								$brand_id = $row['brand_id'];
								$s = $row['bilty_date'];
								$dt = new DateTime($s);								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');	
								
								$advance = $row['adv_cash']+$row['adv_other']+$row['adv_cheque']+$row['adv_consignor'];
									?>
            <tr>
                    <td><input type="checkbox" name="chk<?php echo $slno; ?>" id="chk<?php echo $slno; ?>" onClick="addids()" value="<?php echo $row['bid_id']; ?>" <?php //if($exist){ echo "Checked" ;}?>/></td>
                    <td><?php echo $cmn->dateformatindia($row['gr_date']);?></td>
                    <td><?php echo $row['gr_no'];?></td>
                    <td><?php echo $row['invoiceno'];?></td>
                    <td><?php echo $row['di_no'];?></td>
					<td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
                    <td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
                    <td><?php echo ucfirst($row['totalweight']);?></td>
                    <td><?php echo ucfirst($row['own_rate']);?></td>
                    
                    <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                    
                    <td><?php echo number_format($row['totalweight'] * $row['own_rate'],2);?></td>
                    <td><?php echo number_format($advance,2);?></td>
                    <td><?php echo ucfirst($row['adv_diesel']);?></td>
                    
                   <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td> 
                   <td><?php echo $cmn->getvalfield($connection,"brand_master","brand_name","brand_id='$brand_id'");?></td>
            
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
							<?php } else {
							//echo "hi";
							 ?>
							<table class="table table-hover table-nomargin table-bordered" style=" margin-left:8px;">
									<thead>
										<tr>
                                            <th><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" />All </th>  
                                            <th>GR Date</th>
                                            <th>GR No</th>
                                        	<th>Invoice No</th>
                                            <th>DI No</th>
											<th>Item Name</th>
                                            <th>Truck No</th>
                                            <th>Consignee</th>
                                            <th>Destination</th>
                                            <th>Weight/(M.T.)</th>
                                            <th>Rate/MT</th>
                                             <!--<th>Print</th>-->
                                             
                                            <th>Freight</th>
                                            <th>Advance</th>
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>
                                            <th>Brand</th>                                       	 
										</tr>
									</thead>
                                    <tbody id="myTable">
                                    <?php
									$slno=1;									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										$cond="where 1=1 ";
									}
									
									 $sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit && consignorid !=4 and is_bilty=1 and (is_invoice=0 || invoiceid='$invoiceid') order by invoiceid desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
								$gr_date = $row['gr_date'];
								$truckid = $row['truckid'];
								$itemid = $row['itemid'];
								$consigneeid = $row['consigneeid'];
								$destinationid = $row['destinationid'];
								$supplier_id = $row['supplier_id'];
								$brand_id = $row['brand_id'];
								$s = $row['bilty_date'];
								$dt = new DateTime($s);								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');	
								
								$advance = $row['adv_cash']+$row['adv_other']+$row['adv_cheque']+$row['adv_consignor'];
								
							$exist = $cmn->getvalfield($connection,"bidding_entry","count(*)","invoiceid='$invoiceid' && bid_id='$row[bid_id]'");	
									?>
            <tr>
                    <td><input type="checkbox" name="chk<?php echo $slno; ?>" id="chk<?php echo $slno; ?>" onClick="addids()" value="<?php echo $row['bid_id']; ?>" <?php if($exist !=0){ echo "Checked" ;}?>/></td>
                    <td><?php echo $cmn->dateformatindia($row['gr_date']);?></td>
                    <td><?php echo $row['gr_no'];?></td>
                    <td><?php echo $row['invoiceno'];?></td>
                    <td><?php echo $row['di_no'];?></td>
					<td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
                    <td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
                    <td><?php echo ucfirst($row['totalweight']);?></td>
                    <td><?php echo ucfirst($row['own_rate']);?></td>
                    
                    <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                    
                    <td><?php echo number_format($row['totalweight'] * $row['own_rate'],2);?></td>
                    <td><?php echo number_format($advance,2);?></td>
                    <td><?php echo ucfirst($row['adv_diesel']);?></td>
                    
                   <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td> 
                   <td><?php echo $cmn->getvalfield($connection,"brand_master","brand_name","brand_id='$brand_id'");?></td>
            
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
							<?php } ?>
							</div>
						</div>
					
					
				
				
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
				
				<div class="row-fluid" id="list">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                <a href="excel_master_bank.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                 
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Invoice No</th>
                                        	<th>Invoice Date</th>
                                            <th>Qty</th>
                                            <th>Invoice Amount</th>
                                            <th>Print</th>
                                         	<th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from invoicebilty order by invoiceid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									//$invoiceid = $row['invoiceid'];
									$consigneeid = $cmn->getvalfield($connection,"bidding_entry","consigneeid","invoiceid='$row[invoiceid]'");
									
									$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
									
									
									$amount = $cmn->getinvoiceamount($connection,$row['invoiceid']);
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['invno']);?></td>
                                            <td><?php echo $cmn->dateformatindia($row['invdate']);?></td>
                                            <td><?php echo number_format($amount,2);?></td>
                                            <td><?php echo number_format($amount,2);?></td>
                                            
                                            <td><a href= "pdf_invoice.php?invoiceid=<?php echo $row['invoiceid'];?>" class="btn btn-success" target="_blank">Print</a></td>
                                            <td>
													<a href= "bilty_invoice.php?edit=<?php echo ucfirst($row['invoiceid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['invoiceid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
				
					
				</div>
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
function funDel(id)
{    
	  //alert(id);   
	  tblname = 'invoicebilty';
	   tblpkey = 'invoiceid';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/deleteinvoice.php',
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


//below code for date mask
jQuery(function($){
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
   $("#invdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});


function addids()
{
    strids="";
    var cbs = document.getElementsByTagName('input');
    var len = cbs.length;
    for (var i = 1; i < len; i++)
    {
         if (document.getElementById("chk" + i)!=null)
         {
              if (document.getElementById("chk" + i).checked==true)
              {
                   if(strids=="")
                   strids=strids + document.getElementById("chk" + i).value;
                   else
                   strids=strids + "," + document.getElementById("chk" + i).value;
               }
          }
     }
	// alert(strids);
     document.getElementById("hiddenid").value = strids;
}

function toggle(source)
{
	//alert(source);
	if(source == true)
	{
		//alert("hi");
		var cbs = document.getElementsByTagName('input');
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = true;
			}
		}
		addids()
	}
	else
	{
		//alert("hello");
		var cbs = document.getElementsByTagName('input');
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = false;
			}
		}
		addids()
	}
}

function createinvoice() {
var hiddenid = document.getElementById('hiddenid').value;
//alert(hiddenid);
if(hiddenid=='') {
	alert("Please Select Bilty");
	return false;
}
else
{


	$('#myModal').modal('show');
	
}

}

function saveinvoice() {

var hiddenid = document.getElementById('hiddenid').value.trim();
var invoiceno = document.getElementById('invoiceno').value.trim();
var invdate = document.getElementById('invdate').value.trim();
var itemtype = document.getElementById('itemtype').value.trim();
var invoiceid = '<?php echo $invoiceid; ?>';

//alert(hiddenid);
if(hiddenid=='') {
	alert("Please Select Bilty");
	return false;
}
else if(invoiceno=='')
{
	alert("Please Add Invoice No");
	return false;
} else if(invdate=='')
{
	alert("Please Add Invoice Date");
	return false;
} else if(itemtype=='') {
	alert("Please Select Type");
	return false;
}
else
{
$.ajax({
		  type: 'POST',
		  url: 'ajax_create_invoice.php',
		  data: 'hiddenid=' + hiddenid+'&invoiceno='+invoiceno+'&invdate='+invdate+'&invoiceid='+invoiceid
		  +'&itemtype='+itemtype,
		  dataType: 'html',
		  success: function(data){
			 //alert(data);
			// window.open('pdf_invoice.php?invoiceid='+data, '_blank');
			 window.location='?action=1';
			}		
		  });//ajax close
	}	  
}

$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

addids();
</script>	

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Invoice</h4>
      </div>
      <div class="modal-body">
        		
				<div class="form-group">
    <label for="email"><strong>Invoice No :</strong></label>
    <input type="text" class="form-control" id="invoiceno" value="<?php echo $invno; ?>"> <br>
	<label for="invdate"><strong>Invoice Date :</strong></label>
<input type="text" class="form-control" id="invdate" value="<?php echo $cmn->dateformatindia($invdate); ?>">
	<br>
	
	<label for="itemtype"><strong>Type :</strong></label>
				<select id="itemtype">
						<option value="CEMENT">Cement</option>
						<option value="LOOSE CLINKER">Clinker</option>
				</select>
				<script> document.getElementById('itemtype').value='<?php echo $itemtype; ?>'; </script>
		<br>
<br>

	<button type="submit" class="btn btn-default btn-success" onClick="saveinvoice()" style="margin-top:-8px;">Submit</button>
  </div>
  
  
  
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>		
                
		
	</body>

	</html>
