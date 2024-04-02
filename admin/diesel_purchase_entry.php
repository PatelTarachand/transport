<?php  error_reporting(0);
include("dbconnect.php");
$pagename = "diesel_purchase_entry.php";
$modulename = "Diesel Purchase Entry";
$tblpkey = "d_purchase_id";
$duplicate='';


if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


if(isset($_GET['edit']))
{
	$d_purchase_id = $_GET['edit'];
	$sql_edit="select * from diesel_purchase_entry where d_purchase_id='$d_purchase_id'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_assoc($res_edit))
		{
			//challan info
			$invoice_no = $row['invoice_no'];
			$invoice_date = $row['invoice_date'];
			$supplier_id = $row['supplier_id'];
			$shipment_doc_no = $row['shipment_doc_no'];
			$delivery_no = $row['delivery_no'];	
			$truckno = $row['truckno'];
		
			
		}//end while
	}//end if
}//end if
else
{
	$supplier_id = '';
	$invoice_date = date('Y-m-d');
	$invoice_no = '';
	$shipment_doc_no = '';	
	$delivery_no = "";
	$d_purchase_id =0;	
	$truckno='';
}


?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>
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
	
	$(document).ready(function(){
	$("#shortcut_supplier_id").click(function(){
		$("#div_supplier_id").toggle(1000);
	});
	});
	
$("#shortcut_empid").click(function(){
		$("#div_empid").toggle(1000);
	});
	});
	</script>
<title>BPS - Transport</title></head>

<body>




<?php include("../include/top_menu.php"); ?>
<!--- top Menu----->

	<div class="container-fluid" id="content">
		
  <div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
              <form id="myform"  method="post" action="save_diesel_purchase.php" class='form-horizontal' > 
				  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
                              
                              <input type="hidden" name="<?php echo $tblpkey; ?>" value="<?php echo $d_purchase_id; ?>" id="<?php echo $tblpkey; ?>">
							<table class="table table-condensed table-bordered">
							  <tr>
							    <td colspan="6"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
						      </tr>
							  <tr>
							    <td width="15%" ><strong>Invoice No. :</strong><span class="red">*</span></td>
							    <td width="15%" ><strong>Invoice Date :</strong><span style="color:#F00;font-size:10px;"> (dd-mm-yyyy)</span></td>
							    <td width="15%" ><strong>Supplier Name :</strong><span class="red">*</span></td>
							    <td width="15%" ><strong>Shipment Document No :</strong>&nbsp;&nbsp;</td>
							    <td width="15%" ><strong>Delivery No :</strong></td>
							    <td width="15%" ><strong>Truck No :</strong></td>
						      </tr>
							  <tr>
							    <td><input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice_no; ?>" class="input-medium"  autofocus autocomplete="off" ></td>
							    <td><input type="text" name="invoice_date" id="invoice_date" value="<?php echo $cmn->dateformatindia($invoice_date); ?>" class="input-medium" autocomplete="off" ></td>
							    <td>
                                <?php
									$sql1 = "Select supplier_id,supplier_name from diesel_m_supplier order by supplier_name desc";
									$res1 = mysqli_query($connection,$sql1);
 									?>
							      <select name="supplier_id" id="supplier_id"style="width:200px;"  class="input-large  select2-me" >
							        <option value="">-Select-</option>
							        <?php
										while($row1 = mysqli_fetch_assoc($res1))
										{
										?>
							        <option value="<?php echo $row1['supplier_id']; ?>"><?php echo $row1['supplier_name']; ?></option>
							        <?php
										} ?>
						          </select>
							      <script>document.getElementById('supplier_id').value='<?php echo $supplier_id; ?>';</script>
                                
                                </td>
                                
							    <td><input type="text" name="shipment_doc_no" id="shipment_doc_no" value="<?php echo $shipment_doc_no; ?>" class="input-medium" autocomplete="off"  ></td>
                                
							    <td><input type="text" name="delivery_no" id="delivery_no" value="<?php echo $delivery_no; ?>" class="input-medium" autocomplete="off"  ></td>
                               
                                <td><input type="text" name="truckno" id="truckno" value="<?php echo $truckno; ?>" class="input-medium"  autofocus autocomplete="off" ></td>
                               
							    
						      </tr>
							  
							  
							  <tr>
							    <td colspan="2">&nbsp;  </td>
						      </tr>
							  </table>
                                   
                                <div class="control-group">
                                
                                </div>
                                <table width="100%">
                                <tr>
                                	<td align="right"><strong>Total Rate :   <input type="text" readonly class="input-medium" style="color:red" name="total_ratee" id="total_ratee" value="<?php echo $cmn->gettotalamt($connection,$d_purchase_id); ?>"></strong></td>
                                </tr>
                                </table>
                                 <table width="100%" border="1" >
                                      <tr bgcolor="#CCCCCC" >                                        
                                        <td width="20%" height="25px"><b>Item</b></td>
                                        <td width="9%" height="25px"><b>Qty (ltr)</b></td>
                                        <td width="9%" height="25px"><b>Rate</b></td> 
                                        <td width="9%" height="25px"><b>Disc(Rs)</b></td> 
                                        <td width="9%" height="25px"><b>DLY/Tax</b></td>                                         
                                        <td width="9%" height="25px"><b>VAT / LST Tax (%)</b></td>
                                        <td width="9%" height="25px"><b>Cess Fixed</b></td>
                                        <td width="9%" height="25px"><b>Total</b></td>
                                        <td width="17%" height="25px"><b>Action</b></td>
                                      </tr>
                                      <tr>
                                        
                                        <td><select id="type" style="width:200px;"  class="select2-me" >
                                        	<option value="">-Select-</option>  
                                            <option value="Diesel">Diesel</option>                                           
                                          	<option value="Petrol">Petrol</option>
                                      </select></td>
                                     
                                     <td>
                                     <input type="text" id="qty" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" >
                                     
                                        </td>
                                        
                                        <td><input type="text" id="rate" autocomplete="off"  maxlength="120" class="input-small" style="width:90px" onChange="getamt();" ></td>
                                        
                      					 <td><input type="text" id="discrs" autocomplete="off"  maxlength="120" class="input-small" style="width:90px" onChange="getamt();" ></td>
                                                        
                                       <td><input type="text" id="dly_tax" autocomplete="off"  maxlength="120" class="input-small" style="width:90px" onChange="getamt();" ></td>
                       
                                        <td>
                                        	<input type="text"id="tax" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" onChange="getamt();" >
                                        </td>
                                        
                                        
                                         <td>
                                        	<input type="text"id="cess_fixed" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" onChange="getamt();" >
                                        </td>
                                        
                                        
                                         <td>
                                        	<input type="text"id="total" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" onChange="getamt();" >
                                        </td>
                                       
                                        <td>
                                        <input type="button" value="ADD" style="width:60px;" id="add" onClick="return myFunction();"  class="btn-small btn-success" /></td>
                                      </tr>
                                    </table>
                                     <br>
                                 <table id="myTable" border="1" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                    	<td width="3%" height="25px"><b>Slno</b></td>
                                         <td width="17%" height="25px"><b>Item</b></td>
                                          <td width="9%" height="25px"><b>Qty</b></td>
                                        <td width="9%" height="25px"><b>Rate</b></td>   
                                        <td width="9%" height="25px"><b>Disc(Rs)</b></td>                                     
                                        <td width="9%" height="25px"><b>DLY/Tax</b></td>                                       
                                        <td width="9%" height="25px"><b>VAT / LST Tax (%)</b></td>
                                          <td width="9%" height="25px"><b>Cess Fixed</b></td> 
                                          <td width="9%" height="25px"><b>Total</b></td> 
                                       <td width="17%" height="25px"><b>Action</b></td>
                                   </tr>
                                   <?php
								   $total=0;
								   if($d_purchase_id!=0 && $d_purchase_id!="")
								   {
									   $slno = 1;									  
									   $sql_edit_billty = "select * from diesel_purchase_entry_detail where d_purchase_id='$d_purchase_id'";
									   $res_edit_billty = mysqli_query($connection,$sql_edit_billty);
									   while($row_edit_billty =  mysqli_fetch_assoc($res_edit_billty))
									   {
										$total=0; 
										$dly_tax = $row_edit_billty['dly_tax'];
										$tax = $row_edit_billty['tax'];
										$cess_fixed = $row_edit_billty['cess_fixed'];
										$total = $row_edit_billty['qty'] * $row_edit_billty['rate'];	
										
										$total -= $row_edit_billty['discrs'];
										if($dly_tax !=0) { $total += $dly_tax; }
										if($tax !=0) { 
										$tax_amt = 	($total * $tax)/100;
										$total += $tax_amt;
										}
										
										if($cess_fixed !=0) { $total += $cess_fixed; }
										
			
								   ?>
                                        <tr>
                                            <td><?php echo $slno; ?></td>
                                  <td><input type="text" name="type[]" id="type<?php echo $slno; ?>" value="<?php echo $row_edit_billty['type']; ?>"  style="width:50px;border:none;" readonly></td>
                                             <td>
                                            <input type="text" name="qty[]" id="qty<?php echo $slno; ?>" 
                                            value="<?php echo $row_edit_billty['qty']; ?>" style="width:50px;border:none;" readonly>
                                            </td>
                                           
                                            <td>
                                            <input type="text" name="rate[]" id="rate<?php echo $slno; ?>" 
                                            value="<?php echo $row_edit_billty['rate']; ?>" style="width:50px;border:none;" readonly>
                                            </td>
                                            
                                            <td>
                                            <input type="text" name="discrs[]" id="discrs<?php echo $slno; ?>" 
                                            value="<?php echo $row_edit_billty['discrs']; ?>" style="width:50px;border:none;" readonly>
                                            </td>
                                            
                                             <td><input type="text" name="dly_tax[]" id="dly_tax<?php echo $slno; ?>" value="<?php echo $row_edit_billty['dly_tax']; ?>" 
                                            style="width:50px;border:none;" readonly></td>
                                           <td><input type="text" name="tax[]" id="tax<?php echo $slno; ?>" value="<?php echo $row_edit_billty['tax']; ?>" style="width:50px;border:none;" readonly></td>
                                            <td>
                                            <input type="text" name="cess_fixed[]" id="cess_fixed<?php echo $slno; ?>" value="<?php echo $row_edit_billty['cess_fixed'] ;?>"  style="width:70%;border:none;" readonly>
                                             
                                        </td>
                                        
                                        <td>
                                            <input type="text" id="total<?php echo $slno; ?>"
                                             value="<?php echo number_format($total,2);?>"
                                              style="width:70%;border:none;" readonly>
                                             
                                        </td>
                                            
                                           
                                            <td><?php if($retbilltyid == 0) {?><input type="button" onClick="deleterow_edit(<?php echo $slno; ?>);" 
                                             style="width: 50px; height: 25px;" id="del<?php echo $slno; ?>" value="X"><?php }?></td>
                                       </tr>
                                   <?php
								   		$slno++;
									   }
								   }
								   ?>
                                 </table>
                              <br>
                                 <br>



                      <table width="100%">
                                    	<tr>
                                        	<td>
                                            	<center>
                                        		<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checktablerow()"   >
                                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                                 <a href="diesel_purchase_entry.php" class="btn btn-danger">Clear</a>
                                                
                                                 
                                                </center>
                                        	</td>
                                        </tr>
                                    </table>
							
							</div>
						</div>
					</div>
				</div>
                	</form>
                <!--   DTata tables -->
                <div class="row-fluid" id="list">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Invoice No.</th>
                                            <th>Date</th>
                                            <th>Supplier Name</th>
                                            <th>Shipment Doc No</th>
                                            <th>Delivery No </th>
                                            <th>Truck No</th>                                           
                                            <th>Total Amount</th>                                          
                                           	<th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$tot_amt=0;
									$sel = "select * from diesel_purchase_entry order by invoice_date desc";
									$res = mysqli_query($connection,$sel);								
									while($row = mysqli_fetch_assoc($res))
									{
										$d_purchase_id = $row['d_purchase_id'];	
										$supplier_id = $row['supplier_id'];	
										$supplier_name = $cmn->getvalfield($connection,"diesel_m_supplier","supplier_name","supplier_id='$supplier_id'");
										$tot_amt = $cmn->gettotalamt($connection,$d_purchase_id);
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['invoice_no'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['invoice_date']);?></td>
                                            <td><?php echo $supplier_name; ?></td>
                                            <td><?php echo $row['shipment_doc_no']; ?></td>
                                            <td><?php echo $row['delivery_no']; ?></td>
                                             <td><?php echo $row['truckno']; ?></td>
                                           <td><?php echo round($tot_amt); ?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['d_purchase_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['d_purchase_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
										</tr>
                                        <?php
										$slno++;
										
									}
									?>
									</tbody>
								</table>
                                <br>                                
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<script>

function checkexist(invoice_no)
{
	if(invoice_no != "" )
	{
	$.ajax({
		  type: 'POST',
		  url: 'ajax_check_invoice_no.php',
		  data: 'invoice_no=' + invoice_no.trim(),
		  dataType: 'html',
		  success: function(data){
			 if(data != "0" && data != "")
			 {
				alert("Slip no Already Exist");
				$("#invoice_no").val("");
				$("#invoice_no").focus();
				return false;
			}
			else 
			return true;
		  }
		  });//ajax close
	}
}
/*function getShortage()
{
	actual_avg = $("#actual_avg").val();
	cal_avg = $("#cal_avg").val();
	totalkm = $("#totalkm").val();
	totalqty = $("#totalqty").val();
	if(actual_avg != "" && cal_avg != "" && totalkm != "")
	{
		//var one_km_ltr = 1 / parseFloat(actual_avg);
		var act_diesel = parseFloat(totalkm) / parseFloat(actual_avg) ;
		shortage = parseFloat(act_diesel) - parseFloat(totalqty);
		$("#dieselshortage").val(""+Math.abs(shortage.toFixed(3)));
	}
}*/
function setTotalKM()
{
	prevread = $("#prevread").val();
	metread = $("#metread").val();
	truckid = $("#truckid").val();
	invoice_no = $("#invoice_no").val();
	total = parseInt(metread) - parseInt(prevread); 
	 $("#totalkm").val(total);
	 
	 $.ajax({
		  type: 'POST',
		  url: 'ajax_get_bonus.php',
		  data: 'total=' + total+'&truckid='+truckid,
		  dataType: 'html',
		  success: function(data){
				//alert(data);
				var arr = data.split('|');
				//document.getElementById('actual_avg').value= arr[0];
				//document.getElementById('bonus_amt').value= arr[1];
		  }
		  });//ajax close
	
}


function getAVG()
{
var actual_avg = document.getElementById('actual_avg').value;	 
	 $.ajax({
		  type: 'POST',
		  url: 'get_bonus_ajax.php',
		  data: 'actual_avg=' + actual_avg,
		  dataType: 'html',
		  success: function(data){
				jQuery('#bonus_amt').val(data);
		  }
		  });//ajax close
}


function getDriver()
{
	truckid = $("#truckid").val();
	drivername = $("#drivername").val();

	if(truckid != ""  || drivername != "")
	{
	$.ajax({
		  type: 'POST',
		  url: 'ajax_get_driver.php',
		  data: 'truckid=' + truckid + '&drivername=' +drivername ,
		  dataType: 'html',
		  success: function(data){
			 //alert(data);
			 if(data != "")
			 {
				 arr = data.split("|");
				//$("#drivername").select2().select2('val',arr[0]);
				$("#prevread").val(arr[1]);
				
			 
			}
		  }
		  });//ajax close
	}
}

</script>
<script>
function getrate()
{
	supplier_id = $("#supplier_id").val();
	productid = $("#productid").val();
	if(supplier_id != "" && productid != "")
	{
	$.ajax({
		  type: 'POST',
		  url: 'ajax_getdiesel_rate.php',
		  data: 'supplier_id=' + supplier_id + '&productid=' + productid,
		  dataType: 'html',
		  success: function(data){
			 //alert(data);
			 $("#rate").val(data);
			 
			}
		
		  });//ajax close
	}
	
}
function funDel(id)
{    
	  //alert(id);   
	  tblname = 'diesel_purchase_entry';
	  tblpkey = '<?php echo $tblpkey; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this RECORD."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location='diesel_purchase_entry.php?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close



</script>
<script>
function myFunction()
{
	
	var type = document.getElementById("type").value.trim();
	var rate = document.getElementById("rate").value.trim();
	var qty = document.getElementById("qty").value.trim();	
	var discrs = document.getElementById("discrs").value.trim();	
	var dly_tax = document.getElementById("dly_tax").value.trim();	
	var tax = document.getElementById("tax").value.trim();
	var cess_fixed = document.getElementById("cess_fixed").value.trim();
	var total = document.getElementById("total").value.trim();
	var total_ratee = $("#total_ratee").val();
	//alert(total_ratee);
	if(type=='')
	{
		alert("Please Select Item");
		return false;
	}
	
	if(qty=='')
	{
		alert("Please Select Qty");
		return false;
	}
	
	if(rate=='')
	{
		alert("Please Select Rate");
		return false;
	}
	
	
	//alert(productid);
	if(type!="" && rate!="" && qty!="")
	{
		//alert('hi');
		var table = document.getElementById("myTable");
		var rowcount = document.getElementById('myTable').getElementsByTagName("tr").length;
		//alert(rowcount);
		if(rowcount > 1)
		{
			var slno; 
			//alert(document.getElementById("myTable").rows[rowcount-1].cells[0].innerHTML);
			slno = parseInt(document.getElementById("myTable").rows[rowcount-1].cells[0].innerHTML);
			slno = slno + 1;
			//alert(slno);
			//rowcount++;
			//alert($('#myTable tr:last')[0].val());
		}
		
		var row = table.insertRow(rowcount);
		var cell1 = row.insertCell(0);
		cell1.innerHTML = slno;
		
		var cell2 = row.insertCell(1);
		var t2 = document.createElement("input");
		t2.id = "type" + rowcount;
		t2.name = "type[]";
		t2.style.width = "98%";
		t2.style.border = "none";
		t2.readOnly = "true";
		t2.value = type.trim();
		cell2.appendChild(t2);
		
		
		var cell3 = row.insertCell(2);
		var t3 = document.createElement("input");
		t3.id = "qty" + rowcount;
		t3.name = "qty[]";
		t3.style.width = "98%";
		t3.style.border = "none";
		t3.readOnly = "true";
		t3.value = qty;
		cell3.appendChild(t3);
		
		
		var cell4 = row.insertCell(3);
		var t4 = document.createElement("input");
		t4.id = "rate" + rowcount;
		t4.name = "rate[]";
		t4.style.width = "98%";
		t4.style.border = "none";
		t4.readOnly = "true";
		t4.value = rate;
		cell4.appendChild(t4);
		
		var celld = row.insertCell(4);
		var td = document.createElement("input");
		td.id = "discrs" + rowcount;
		td.name = "discrs[]";
		td.style.width = "98%";
		td.style.border = "none";
		td.readOnly = "true";
		td.value = discrs;
		celld.appendChild(td);
		
		
		
		var cell5 = row.insertCell(5);
		var t5 = document.createElement("input");
		t5.id = "dly_tax" + rowcount;
		t5.name = "dly_tax[]";
		t5.style.width = "98%";
		t5.style.border = "none";
		t5.readOnly = "true";
		t5.value = dly_tax;
		cell5.appendChild(t5);
		
		var cell5 = row.insertCell(6);
		var t6 = document.createElement("input");
		t6.id = "tax" + rowcount;
		t6.name = "tax[]";
		t6.style.width = "98%";
		t6.style.border = "none";
		t6.readOnly = "true";
		t6.value = tax;
		cell5.appendChild(t6);
		
		var cell6 = row.insertCell(7);
		var t7 = document.createElement("input");
		t7.id = "cess_fixed" + rowcount;
		t7.name = "cess_fixed[]";
		t7.style.width = "98%";
		t7.style.border = "none";
		t7.readOnly = "true";
		t7.value = cess_fixed;
		cell6.appendChild(t7);
		
		var cell7 = row.insertCell(8);
		var t8 = document.createElement("input");
		t8.id = "total" + rowcount;
		t8.name = "total[]";
		t8.style.width = "98%";
		t8.style.border = "none";
		t8.readOnly = "true";
		t8.value = total;
		cell7.appendChild(t8);
		
		var cell12 = row.insertCell(9);
		var btn = document.createElement("BUTTON");
		//var pquantity = document.getElementById("pquantity").value;
		btn.id = "del" + rowcount;
		//t5.name = "pquantity[]";
		btn.style.width = "50px";
		btn.style.height = "25px";
		var txtbtn = document.createTextNode("X");
		btn.appendChild(txtbtn); 
		btn.onclick = function()
		{ 
			//code for delete row
			//alert('hi javascript');
			if(confirm('Are you sure want to remove this item'))
			{
				
				var total_ratee = $("#total_ratee").val();
				total_rate = parseFloat(total_ratee) - parseFloat(total);	
				
				document.getElementById("total_ratee").value = total_rate.toFixed(2);
				//getnewavg();
				document.getElementById("myTable").deleteRow(rowcount);
				return false;
			}
			else
			{
				return false;
			}
		}; 
		cell12.appendChild(btn);
		
		if(rowcount == 1)
		{
			cell1.innerHTML = rowcount;
		}
		else
		{
			cell1.innerHTML = slno;
		}
		
		total_rate = parseFloat(total_ratee) + parseFloat(total);		
		document.getElementById("total_ratee").value = total_rate.toFixed(2);
		
		//getnewavg();
		//cell2.innerHTML = pname;
		$('#type').val('');
		$("#type").select2().select2('val','');
		document.getElementById("qty").value = "";
		document.getElementById("rate").value = "";
		document.getElementById('discrs').value='';
		document.getElementById("dly_tax").value = "";
		document.getElementById("tax").value = "";
		document.getElementById("cess_fixed").value = "";
		document.getElementById("total").value = "";
		
		$('#type').select2('focus');
		
	}
	else
	{
		//alert(productid);
		
		if(truckid == "")
		{
			alert("please select truck no.");
			document.getElementById("truckid").focus();
			return false;
		}
		else if(metread == "")
		{
			alert("please enter meter reading");
			document.getElementById("metread").focus();
			return false;
		}
		else if(supplier_id == "")
		document.getElementById("supplier_id").focus();
		else if(productid == "")
		{
		 $('#productid').select2('focus');
		}
		else if(rate == "")
		document.getElementById("rate").focus();
		else if(qty == 0)
		document.getElementById("qty").focus();
		
	}
	
}





function deleterow_edit(rowcount)
{
	if(confirm('Are you sure to delete this record?'))
	{
		
		total_ratee = $("#total_ratee").val();
		total=$("#total"+rowcount).val();		
		total_rate = parseFloat(total_ratee) - parseFloat(total);		
		document.getElementById("total_ratee").value = total_rate.toFixed(2);	
		document.getElementById("myTable").deleteRow(rowcount);
		
		
	}
}



function checktablerow()
{
	invoice_no = $("#invoice_no").val();
	invoice_date =  $("#invoice_date").val();
	supplier_id =  $("#supplier_id").val();
		
	var x = document.getElementById("myTable").rows.length;
	//alert(metread);
	if(invoice_no == "")
	{
		alert("Please Enter Invoice No");
		$("#invoice_no").focus();
		return false;
	}
	else if(invoice_date == "")
	{
		alert("Please Enter Invoice Date");
		$("#invoice_date").focus();
		return false;
	}
	else if(supplier_id == "")
	{
		alert("Please Select Supplier");
		$("#supplier_id").focus();
		return false;
	}
	
	if(x == 1)
	{
		alert('Please add Item');
		return false;
	}
	
	 
}


function getamt()
{	
	var rate = parseFloat(document.getElementById("rate").value.trim());
	var qty = parseFloat(document.getElementById("qty").value.trim());	
	var discrs = parseFloat(document.getElementById("discrs").value.trim());	
	var dly_tax = parseFloat(document.getElementById("dly_tax").value.trim());	
	var tax = parseFloat(document.getElementById("tax").value.trim());
	var cess_fixed = parseFloat(document.getElementById("cess_fixed").value.trim());
	var total = 0;
	var tax_amt = 0;
	if(isNaN(rate)) { rate=0; }
	if(isNaN(qty)) { qty=0; }
	if(isNaN(dly_tax)) { dly_tax=0; }
	if(isNaN(tax)) { tax=0; }
	if(isNaN(cess_fixed)) { cess_fixed=0; }
	if(isNaN(discrs)) { discrs=0; }
	
	if(qty !=0 && rate != 0)
	{
			total = qty * rate;	
			total -= discrs;
			if(dly_tax !=0) { total += dly_tax; }
			if(tax !=0) { 
				tax_amt = 	(total * tax)/100;
				total += tax_amt;
			}
			
			if(cess_fixed !=0) { total += cess_fixed; }
			
			document.getElementById('total').value=total.toFixed(2);
	}
}

</script>


	</body>
	</html>
<?php
mysqli_close($connection);
?>
