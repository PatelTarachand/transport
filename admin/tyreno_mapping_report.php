<?php include("dbconnect.php");
$tblname = "tyre_purchase";
$tblpkey = "tid";
$pagename = "tyreno_mapping_report.php";
$modulename = "Truckwise Tyre Mapping Report";


$crit = "where 1=1";
if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
	
}
else
$truckid='';

if(isset($_GET['fromdate']) !='' && isset($_GET['todate']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if($truckid !='') { $crit .=" and A.truckid='$truckid'"; }

if($fromdate !='' && $fromdate !='') {
	 $crit .=" and A.uploaddate between '$fromdate' and '$todate'";
	}

?>

<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

	<script>
    $(function() {
    
    $('#fromdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
    $('#todate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
    
    });
    </script>
  
</head>
<body>
<?php include("../include/top_menu.php"); ?>
<!--- short cut form supplier --->
<form id="myform"  method="get" action="" class='form-horizontal' > 
				  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							<table class="table table-condensed table-bordered">
							  <tr>
							    <td colspan="9"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
						      </tr>
							  <tr>							   
							    <td width="20%" ><strong>Truck No :</strong></td>
                                <td width="20%" ><strong>From Date :</strong></td>
                                <td width="20%" ><strong>To Date :</strong></td>
                                <td width="40%" >&nbsp;</td>
						      </tr>

							  <tr>
							    <td><select id="truckid" name="truckid" style="width:200px;" class="select2-me" >

                                        	<option value="" selected>-Select-</option>

                                            <?php 

											$sql3 = "select A.* from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by truckno";

											$res3 = mysqli_query($connection,$sql3);

											while($row3 = mysqli_fetch_assoc($res3))

												{

											?>

                                          	<option value="<?php echo $row3['truckid']; ?>"><?php echo $row3['truckno']; ?></option>

                                            <?php

												}

												?>

                                      </select>

							      <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script></td>

							    <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>

                                <td>

                                <input type="submit" name="search" id="search" class="btn-info" value="Search">

                                &nbsp;&nbsp;

                                <a href="tyreno_mapping_report.php" class="btn btn-inverse">Cancel</a>

                                </td>

						      </tr>

							  </table>

						  </div>

						</div>

					</div>

				</div>

                	</form>
	<div class="container-fluid" id="content">
		<div id="main">
			<div class="container-fluid">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                        <th>Sno</th>  
                                         <th>Invoice No</th>   
                                         <th>Invoice Date</th> 
                                         <th>Manufacture</th> 
                                         <th>Supplier Name</th>                                           
                                        <th>Tyre Number</th>
                                          <th>Truck No</th>
                                        <th>Location</th>
                                        <th>Uploading Date</th>
                                        <th>Downloading Date</th>
                                        <th>Rate </th>                                      
                                       </tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$total=0;
									$sel = "select A.* from tyre_map as A left join tyre_purchase as B on A.tid=B.tid $crit  order by B.tnumber desc"; 
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{	
									$tid = $row['tid'];
									$truckid = $row['truckid'];
									$typos = $row['typos'];
									$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									$tnumber = $cmn->getvalfield($connection,"tyre_purchase","tnumber","tid='$tid'");
									$invoiceno = $cmn->getvalfield($connection,"tyre_purchase","invoiceno","tid='$tid'");
									$invoicedate = $cmn->getvalfield($connection,"tyre_purchase","invoicedate","tid='$tid'");
									$tmanufacture = $cmn->getvalfield($connection,"tyre_purchase","tmanufacture","tid='$tid'");
									$supplier_id = $cmn->getvalfield($connection,"tyre_purchase","supplier_id","tid='$tid'");
									$supplier_name = $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");
									$trate =  $cmn->getvalfield($connection,"tyre_purchase","trate","tnumber='$tnumber'");
									?>

										<tr>
                                                <td><?php echo $slno; ?></td>   
                                                <td><?php echo $invoiceno;?></td> 
                                                <td><?php echo $cmn->dateformatindia($invoicedate);?></td> 
                                                <td><?php echo $tmanufacture;?></td> 
                                                <td><?php echo $invoiceno;?></td>                                            
                                                <td><?php echo $tnumber;?></td>
                                                 <td><?php echo $truckno;?></td>
                                                <td><?php echo $typos;?></td>
                                                <td><?php echo $cmn->dateformatindia($row['uploaddate']);?></td>
                                                <td><?php echo $cmn->dateformatindia($row['downdate']);?></td>
                                               <td style="text-align:right;"><?php echo $trate;?></td>  
								    	</tr>
                                        <?php
										$slno++;
										$total += $trate; 
									}
									?>
                                    
                                    <tr style="background-color:#00F; color:#FFF;">
                                    		<td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right;"><?php echo number_format($total,2); ?></td>
                                    </tr>
                                    
									</tbody>
								</table>

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

mysql_close($db_link);

?>

