<?php include("dbconnect.php");
$tblname = "";
$tblpkey = "tid";
$pagename = "tyre_purchase.php";
$modulename = "Tyre Purchase";


$invoiceno = $cmn->get_invoice($connection,$tblname,$tblpkey);
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tid=$_GET['edit'];
	$sql_edit="select * from tyre_purchase where tid='$tid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$tnumber = $row['tnumber'];
			$tsize = $row['tsize'];
			$tdiscount = $row['tdiscount'];
			$tlife = $row['tlife'];
			$trate = $row['trate'];
			$tmanufacture = $row['tmanufacture'];
			$twidth = $row['twidth'];
			$supplier_id = $row['supplier_id'];
			$invoicedate = $cmn->dateformatindia($row['invoicedate']);
			$invoiceno = $row['invoiceno'];
			$tdescription = $row['tdescription'];
			
		}//end while
	}//end if
}//end if
else
{
	$tid = 0;
	$invoicedate = date('d-m-Y');
	$netamount = 0;
	$netqty = 0;
	$supplier_id = '-1';

}

$duplicate= "";
if(isset($_POST['submit']))
{
	$tid = $_POST['tid'];
	$supplier_id = $_POST['supplier_id'];
	$invoicedate = $cmn->dateformatusa($_POST['invoicedate']);
	$invoiceno = $_POST['invoiceno'];
	$tdiscount = $_POST['tdiscount'];
	$tsize = $_POST['tsize'];
	
	
	//array form
	$trate = $_POST['trate'];
	$tnumber = $_POST['tnumber'];	
	$tlife = $_POST['tlife'];	
	$tmanufacture = $_POST['tmanufacture'];
	$twidth = $_POST['twidth'];
	
	$tdescription = $_POST['tdescription'];

	mysqli_query($connection,"delete from tyre_purchase where invoiceno = '$invoiceno' and supplier_id = '$supplier_id' ");
		
		//insert new values
		for($i =0 ; $i < sizeof($tnumber) ; $i++)
		{
		$sql_insert="insert into tyre_purchase set tnumber = '$tnumber[$i]', tsize = '$tsize',
		tdiscount='$tdiscount',tlife = '$tlife[$i]',trate='$trate[$i]',supplier_id = '$supplier_id', tmanufacture='$tmanufacture[$i]',
		twidth='$twidth[$i]',invoicedate = '$invoicedate',invoiceno='$invoiceno', tdescription='$tdescription[$i]',createdate=now(),
		sessionid = '$_SESSION[sessionid]'"; 
		mysqli_query($connection,$sql_insert);
		//$keyvalue = mysql_insert_id($connection);
		//$cmn->InsertLog($pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		}//	die;
		echo "<script>location='tyre_purchase.php?action=1'</script>";
		
	
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


/* tooltip */
.tooltip1 {
    position: relative;
    display: inline-block;
    border-bottom: 1px dotted black;
	cursor:pointer;
}

.tooltip1 .tooltiptext1 {
    visibility: hidden;
    width: 320px;
    background-color: black;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 5px 0;
    
    /* Position the tooltip */
    position: absolute;
    z-index: 1;
    bottom: 100%;
    left: 50%;
    margin-left: -60px;
}

.tooltip1:hover .tooltiptext1 {
    visibility: visible;
}
</style>
<script>

	
	$(document).ready(function(){
	$("#shortcut_supplier_id").click(function(){
											 // alert('ff');
		$("#div_supplier_id").toggle(1000);
											  });
	});
	
</script>
</head>

<body>
<!--- short cut form supplier --->
<div class="messagepop pop" id="div_supplier_id">
<img src="b_drop.png" class="close" onClick="$('#div_supplier_id').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place</strong></td></tr>
  <tr><td>&nbsp;Supplier Name: </td></tr>
  <tr><td><input type="text" name="supplier_name" id="supplier_name" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
  <tr><td>&nbsp;Address : </td></tr>
  <tr><td><input type="text" name="address" id="address" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_suppliername();"/></td></tr>
</table>
</div>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                
                                    <table class="table table-condensed">
                                    	<tr>
                                        	<td><strong>Supplier: &nbsp;&nbsp;<img src="add.png" id="shortcut_supplier_id"><span class="red">*</span></strong></td>
                                        	<td><strong>Invoice Number :<span class="red">*</span></strong></td>
                                             <td ><strong>Invoice Date:<span class="red">*</span></strong></td>
                                             
                                                
                                               <td ><strong>Tyre Size:<span class="red">*</span></strong></strong></td>
                                                <td ><strong>Discount:</strong></td>
                                                <td><strong>Total Qty</strong></td>
                                             <td><strong>Net Amount</strong></td>
                                           
                                             
                                        </tr>
                                        
                                        
                                        <tr>
                                        	<td>
                                            	<select id="supplier_id" name="supplier_id" class="input-medium select2-me">
                                    	<option value="">-Select-</option>
                                        <?php 
										$sql = mysqli_query($connection,"select supplier_id,supplier_name from  inv_m_supplier");
										if($sql)
										{
											while($row = mysqli_fetch_assoc($sql))
											{
										?>
                                        <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>
                                        <?php
											}
										}
										?>
                                    </select>
                                    <script> document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>'; </script>
                                            </td>
                                            <td >
                                            <input type="text" name="invoiceno" value="<?php echo $invoiceno; ?>" id="invoiceno" 
                                            class="input-medium" onChange="check_invoiceno(this.value); ">
                                            </td>
                                             <td ><input type="text" name="invoicedate" id="invoicedate" value="<?php echo $invoicedate; ?>" autocomplete="off"  maxlength="120" class="input-small"></td>
                                              
                                      <td><input type="text" name="tsize" id="tsize" value="<?php echo $tsize; ?>" autocomplete="off"
                                      maxlength="10"   class="input-small"></td>
                                      
                                     	 <td><input type="text" name="tdiscount" id="tdiscount" value="<?php echo $tdiscount; ?>" autocomplete="off"
                                      maxlength="10"   class="input-small"></td>
                                            
                                            <td><input type="text" name="netqty" id="netqty" value="<?php echo $netqty; ?>" style="color:#F00" autocomplete="off"  maxlength="120" class="input-small" readonly></td>
                                             <td><input type="text" name="netamount" id="netamount" value="<?php echo $netamount; ?>" autocomplete="off"  maxlength="120" class="input-small"  style="color:#F00" readonly></td>
                                                
                                        </tr>
                                        <tr>
                                        	
                                     	
                                        </tr>
                                        <tr>
                                           
                                          
                                     
                                    
                                        </tr>
                                    
                                    </table>
                               <hr>
                                 <table class="table" border="1" style="background-color:#368ee0; color:#FFF; font-weight:bold padding-bottom:10px">
                                   
                                   <tr>
                                        <td  align="left" width="19%"><strong>Tyre Number</strong> <strong>:<span class="red">*</span></strong></td>                                     <td align="left" width="22%"><strong>Tyre Manufacture:<span class="red">*</span></strong></td>
                                        <td align="left" width="21%"><strong>Description</strong></td>
                                        <td width="10%"><strong>Tyre Width:<span class="red">*</span></strong></td>
                                        <td width="12%"><strong>Tyre Life Km :<span class="red">*</span></strong></td>
                                         <td width="10%"><strong>Tyre Rate:<span class="red">*</span></strong></td>
                                        <td width="6%" colspan="8"><strong>Action </strong></td>
                                   </tr>
                                   <tr>
                                   <td width="19%" align="left" ><strong style="color:#F00;"><?php echo $duplicate; ?></strong>
                                   <input type="text"  id="tnumber" 
                                     autocomplete="off"  maxlength="120" class="input-medium"  onChange="check_tyreno(this.value);"><br>
                                     
									</td>
                                      <td width="22%" align="left"><input type="text" id="tmanufacture" class="input-large">
                                   </td>
                                   <td align="left" width="21%"><input type="text" id="tdescription" ></td>
                                   
                                     <td><input type="text"  id="twidth" autocomplete="off"  maxlength="120"   class="input-small"></td>
                                           <td><input type="text"   id="tlife" class="input-small">
                                    </td>
                                    <td align="left" width="21%"><input type="text" id="trate" class="input-small" ></td>
                                  
                                   <td colspan="8" align="left"> <button type="button" name="add" id="add" onClick="return myFunction();"   class="btn btn-small btn-success" > ADD </button></td>
                                     
                                   </tr>
                                    
                                </table>
                                 <table id="myTable" border="1" class="table" style="background-color:#368ee0; color:#FFF; font-weight:bold">
                                  <tr>
                                    	<td width="4%"><strong>Slno</strong></td>
                                        <td width="14%"><strong>Tyre Number</strong></td>
                                        <td width="23%"><strong>Tyre Manufacture:</strong></td>
                                        <td width="21%"><strong>Description</strong></td>
                                        
                                       <td width="10%"><strong>Tyre Width:</strong></td>
                                        <td width="10%"><strong>Tyre Life Km :</strong></td>
                                        <td width="10%"><strong>Tyre Rate:</strong></td>
                                        <td width="5%"><strong>Action</strong></td>
                                   </tr>
                                   <?php
								   $sn =1;
								   $netqty = 0;							
								   $sql = mysqli_query($connection,"Select * from tyre_purchase where supplier_id = '$supplier_id' and invoiceno = '$invoiceno'");
								   while($row = mysqli_fetch_assoc($sql))
								   {
									   $netamount += $row['trate'];
									   $productlist = $productlist .",".$row['tnumber'];
									   $netqty += 1;
								   ?>
                                   		<tr>
                                        <td><?php echo $sn; ?></td>
                                           <td width="16%" align="left" >
                                           <input type="text"  id="tnumber<?php echo $sn; ?>" name="tnumber[]" value="<?php echo $row['tnumber']; ?>"
                                             autocomplete="off"  maxlength="120" class="input-medium" readonly >
                                             
                                             
                                            </td>
                                              <td width="23%" align="left"><input type="text" name="tmanufacture[]"  id="tmanufacture<?php echo $sn; ?>" value="<?php echo  $row['tmanufacture']; ?>" class="input-large">
                                           </td>
                                           <td align="left" width="21%"><input type="text"   name="tdescription[]"id="tdescription<?php echo $sn; ?>" 
                                            value="<?php echo $row['tdescription']; ?>"></td>
                                            
                                             <td><input type="text"  id="twidth<?php echo $sn; ?>"  name="twidth[]" value="<?php echo $row['twidth']; ?>" autocomplete="off"  maxlength="120"   class="input-small"></td>
                                                   <td><input type="text"  name="tlife[]"  value="<?php echo $row['tlife']; ?>" id="tlife<?php echo $sn; ?>" class="input-small">
                                            </td>
                                             <td align="left" width="21%"><input type="text"   name="trate[]" id="trate<?php echo $row['tnumber']; ?>" 
                                            value="<?php echo $row['trate']; ?>" class="input-small" readonly></td>
                                            
                                           <td colspan="8" align="left"> <button type="button" name="del" id="del" 
                                           onClick="deleterow_edit(<?php echo $sn; ?>,this)"  class="btn btn-small btn-danger"  > X </button></td>
                                     
                                   </tr>
                                   <?php
								   $sn++;
								   }
								   ?>
                                   <script>
								   $("#netamount").val("<?php echo $netamount; ?>");
								    $("#netqty").val("<?php echo $netqty; ?>");
								   </script>
                                 </table>
                                <table class="table" >
                                <tr>
                                    <td colspan="8" style="line-height:5">
                                 
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checktablerow();" style="margin-left:386px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tid; ?>" >
                                    </td>
                                  </tr>
                                  </table> 
                                </div>
                                </form>
                                <input type="hidden" name="check_product" id="check_product" value="<?php echo $productlist;?>"  >
							
						</div>
					</div>
				</div>
                
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
                                             
                                            <th>Tyre Number</th>
                                            <th>Invoice Date</th>
                                            <th width="15%">Invoice Number</th>
                                            <th>Supplier</th>
                                        	<th>Tyre Size</th>
                                          	<th>Discount</th>
                                        	<th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								//	echo "select * from tyre_purchase group by invoiceno order by tid desc ";
									$sel = "select * from tyre_purchase group by invoiceno order by tid desc ";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
										$tnumberall = "";
										$sql_t = mysqli_query($connection,"select tnumber from tyre_purchase where invoiceno = '$row[invoiceno]'  and remarks=0");
										if($sql_t)
										{
											$i =1;
											while($row_t = mysqli_fetch_assoc($sql_t))
											{
												if($i%4 == 0)
												$tnumberall .= "<br>";
												
												$tnumberall .= $row_t['tnumber'].",";
												$i++;
											}
										}
										//$tnumberall = $cmn->getvalmultiple("tyre_purchase","tnumber","","");
										$tnumber1 = $cmn->getvalfield($connection,"tyre_purchase","tnumber","invoiceno = '$row[invoiceno]' and remarks=0");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><div class="tooltip1"><?php echo $tnumber1;?>
                                            <span class="tooltiptext1"><?php echo $tnumberall;?></span></div></td>
                                            
                                             <td width="15%"><?php echo $cmn->dateformatindia($row['invoicedate']);?></td>
                                              <td><?php echo ucfirst($row['invoiceno']);?></td>
                                              <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id = '$row[supplier_id]'");?></td>
                                            <td><?php echo ucfirst($row['tsize']);?></td>
                                           
                                            <td><?php echo ucfirst($row['tdiscount']);?></td>
                                             <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['tid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['invoiceno']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		</div></div>
<script>
function myFunction()
{
	//alert('hi');
	
	var tnumber = document.getElementById("tnumber").value;
	tnumber = tnumber.trim();
	var tmanufacture = document.getElementById("tmanufacture").value;
	var tdescription = document.getElementById("tdescription").value;
	var trate = document.getElementById("trate").value;
	var twidth = document.getElementById("twidth").value;
	var tlife = document.getElementById("tlife").value;
	
	//alert(productid);
	if(tnumber!="" && tmanufacture!="" && tdescription!="" && twidth !="" && tlife != "" )
	{
		//alert('hi');
		check_product = document.getElementById("check_product").value;
		check_product_old = document.getElementById("check_product").value ;
		//check product
		var pro_arr = check_product_old.split(","); 
		var check_dup_product = pro_arr.indexOf(tnumber); 
		//alert('indexof='+a);
			if(check_dup_product > 0)
			{
				alert('Already Added..');
				document.getElementById("tnumber").value = "";
				document.getElementById("tmanufacture").value = "";
				document.getElementById("tdescription").value ="" ;
				document.getElementById("twidth").value ="";
				document.getElementById("tlife").value ="";
				document.getElementById("tnumber").focus();
				
			}
			else
			{
				document.getElementById("check_product").value = check_product +','+tnumber;
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
				t2.id = "tnumber" + rowcount;
				t2.name = "tnumber[]";
				t2.style.width = "98%";
				t2.style.border = "none";
				t2.value = tnumber.trim();
				t2.className = "input-medium";
				t2.readOnly = true;
				cell2.appendChild(t2);
				
				
				var cell3 = row.insertCell(2);
				var t3 = document.createElement("input");
				t3.id = "tmanufacture" + rowcount;
				t3.name = "tmanufacture[]";
				t3.style.width = "98%";
				t3.style.border = "none";
				t3.value = tmanufacture;
				t3.className = "input-large";
				cell3.appendChild(t3);
				
				var cell4 = row.insertCell(3);
				var t4 = document.createElement("input");
				t4.id = "tdescription" + rowcount;
				t4.name = "tdescription[]";
				t4.style.width = "98%";
				t4.style.border = "none";
				t4.value = tdescription;
				t4.className = "input-large";
				cell4.appendChild(t4);
				
				
				
				var cell5 = row.insertCell(4);
				var t5 = document.createElement("input");
				t5.id = "twidth" + rowcount;
				t5.name = "twidth[]";
				t5.style.width = "98%";
				t5.style.border = "none";
				t5.value = twidth;
				t5.className = "input-small";
				cell5.appendChild(t5);
				
				var cell5 = row.insertCell(5);
				var t6 = document.createElement("input");
				t6.id = "tlife" + rowcount;
				t6.name = "tlife[]";
				t6.style.width = "98%";
				t6.style.border = "none";
				t6.value = tlife;
				t6.className = "input-small";
				cell5.appendChild(t6);
				
				var cellrt = row.insertCell(6);
				var trt= document.createElement("input");
				trt.id = "trate" + tnumber;
				trt.name = "trate[]";
				//trt.style.width = "98%";
				trt.style.border = "none";
				trt.readOnly = 'true';
				trt.value = trate;
				trt.className = "input-small";
				cellrt.appendChild(trt);
				
				var cell12 = row.insertCell(7);
				var btn = document.createElement("BUTTON");
				//var pquantity = document.getElementById("pquantity").value;
				btn.id = "del" + rowcount;
				//t5.name = "pquantity[]";
				//btn.style.width = "50px";
				//btn.style.height = "25px";
				var txtbtn = document.createTextNode("X");
				btn.appendChild(txtbtn);
				btn.className = "btn btn-small btn-danger";
				btn.onclick =function()
							{
								deleterow_edit(rowcount,this);
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
				
				netamount = document.getElementById("netamount").value ;
				netamount = parseFloat(netamount);
				//alert(netamount);
				netamount = parseFloat(netamount) + parseFloat(trate);
				document.getElementById("netamount").value = ""+netamount.toFixed(2);
				
				netqty = document.getElementById("netqty").value ;
				netqty = parseInt(netqty);
				netqty = parseInt(netqty) + 1;
				document.getElementById("netqty").value = ""+netqty;
				
				document.getElementById("tnumber").value ="";
				document.getElementById("trate").value ="";
				document.getElementById("tmanufacture").value ="";
				document.getElementById("tdescription").value ="";
				document.getElementById("twidth").value = "";
				document.getElementById("tlife").value = "";
				document.getElementById("tnumber").focus();
				
				
				
			}
			
	}
	else
	{
		//alert(productid);
		
		if(tnumber == "")
		{
			alert("please enter tyre number");
			document.getElementById("tnumber").focus();
			return false;
		}
		else if(tmanufacture == "")
		{
			alert("please enter manufacturee");
			document.getElementById("tmanufacture").focus();
			return false;
		}
		else if(trate == "")
		{
			alert("please enter tyre rate");
			document.getElementById("trate").focus();
			return false;
		}
		else if(twidth == "")
		{
			alert("please enter width");
			document.getElementById("twidth").focus();
			return false;
		}
		else if(tlife == "")
		{
			alert("please enter tyre life");
			document.getElementById("tlife").focus();
			return false;
		}
		
		
	}
	
}

function deleterow_edit(rowcount,r)
{
	if(confirm('Are you sure to delete this record?'))
	{
		var i = r.parentNode.parentNode.rowIndex;
		
			delproduct = document.getElementById("tnumber" + rowcount).value;
			delrate = document.getElementById("trate" + delproduct).value;
			netamount = document.getElementById("netamount").value;
			prod_cnt_old = document.getElementById("check_product").value;
			//alert(delrate);
			if(prod_cnt_old != "")
			{
				//alert("productid" + rowCount);
				//alert(delproduct);
				var prod_cnt_new = prod_cnt_old.replace(delproduct, "0");
				document.getElementById("check_product").value = prod_cnt_new;		
			}
			netamount = parseFloat(netamount) - parseFloat(delrate);
			document.getElementById("netamount").value = ''+netamount.toFixed(2);
			
			netqty = parseInt(document.getElementById("netqty").value);
			netqty = netqty - 1;
			document.getElementById("netqty").value = ""+netqty ;
			
			document.getElementById("myTable").deleteRow(i);
			set_total();
			return true ;
			
	}
}
function check_tyreno(tnumber)
{
	//alert(tnumber);
	tnumber = tnumber.trim();
	
	if(tnumber != "")
	{
		$.ajax({
			  type: 'POST',
			  url: '../ajax/ajax_check_tyreno.php',
			  data: 'tnumber='+tnumber,
			  dataType: 'html',
			  success: function(data){
				 //alert(data);
					if(data != "")
					{
						if(data != '0')
						{
							alert("Duplicate Tyre Number..");
							$("#tnumber").val("");
							$("#tnumber").focus();
							return false;
						}
					}
				}
			
			  });//ajax close
	}
}
function check_invoiceno(invoiceno)
{
	//alert(invoiceno);
	if(invoiceno != "")
	{
		$.ajax({
			  type: 'POST',
			  url: '../ajax/ajax_check_invoiceno.php',
			  data: 'invoiceno='+invoiceno,
			  dataType: 'html',
			  success: function(data){
				//alert(data);
					if(data != "")
					{
						if(data != '0')
						{
							alert("Duplicate invoice Number..");
							$("#invoiceno").val("");
							$("#invoiceno").focus();
							return false;
						}
					}
				}
			
			  });//ajax close
	}
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
		  url: '../ajax/delete_purchase.php',
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
function checktablerow()
{
	supplier_id = $("#supplier_id").val();
	invoiceno =  $("#invoiceno").val();
	invoicedate =  $("#invoicedate").val();
	tsize =  $("#tsize").val();
	
	var x = document.getElementById("myTable").rows.length;
	//alert(metread);
	if(supplier_id == "")
	{
		alert("please select supplier");
		$("#supplier_id").select2().focus();
		return false;
	}
	else if(invoiceno == "")
	{
		alert("please enter invoice no");
		$("#invoiceno").focus();
		return false;
	}
	else if(invoicedate == "")
	{
		alert("please enter invoice date");
		$("#invoicedate").focus();
		return false;
	}
		else if(tsize == "")
	{
		alert("please enter tyre size");
		$("#tsize").focus();
		return false;
	}
	
	else if(x == 1)
	{
		alert('Please add Item');
		return false;
	}
	
	 
}
function set_total()
   {
	   /*trate = $("#trate").val();
	   
	   var x = parseInt(document.getElementById("myTable").rows.length); 
	   x -= 1;
	   if(trate != "")
	   netamt = parseFloat(x) * parseFloat(trate);
	   else
	   netamt = 0;
	   $("#netamount").val(''+netamt.toFixed(2));*/
   }
function ajax_save_suppliername()
{
	var supplier_name = document.getElementById('supplier_name').value;
	var address = document.getElementById('address').value;
	if(supplier_name == "" )
	{
		alert('Fill form properly');
		document.getElementById("supplier_name").focus();
		return false;
	}
	
	//alert(unitmessure);
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
			//alert(xmlhttp.responseText);
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("supplier_id").innerHTML = xmlhttp.responseText;
				
				document.getElementById("supplier_name").value = "";
				document.getElementById("address").value = "";
				
				//$('#itemid').select2('val', '');
				$("#div_supplier_id").hide(1000);
				document.getElementById("supplier_id").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_save_supplier.php?supplier_name="+supplier_name+"&address="+address,true);
	xmlhttp.send();
	
}
</script>
	</body>
<script>
//below code for date mask
jQuery(function($){
   $("#invoicedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});
</script>
	</html>
<?php
mysqli_close($db_link);
?>
