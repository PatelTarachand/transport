<?php error_reporting(0);
include("dbconnect.php");
$tblname = "inv_m_rate_diesel";
$tblpkey = "rateid";
$pagename = "supllier_diesel_rate_setting.php";
$modulename = "Supplier  Rate Setting";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$rateid=$_GET['edit'];
	$sql_edit="select * from inv_m_rate_diesel where rateid='$rateid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$rateid = $row['rateid'];
			$supplier_id = $row['supplier_id'];
			$rate = $row['rate'];
			$productid = $row['productid'];
		}//end while
	}//end if
}//end if
else
{
	$rateid = 0;
	$incdate = date('d-m-Y');
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$rateid = $_POST['rateid'];
	$supplier_id = $_POST['supplier_id'];
	$rate = $_POST['rate'];
	$productid = $_POST['productid'];
	if($rateid==0)
	{
		//check doctor existance
		$sql_chk = "select * from inv_m_rate_diesel where rateid='$rateid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
			 $sql_insert="insert into inv_m_rate_diesel set productid = '$productid',supplier_id = '$supplier_id',rate='$rate', createdate=now(),sessionid = '$_SESSION[sessionid]'"; 
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='supllier_diesel_rate_setting.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  inv_m_rate_diesel set productid = '$productid',supplier_id = '$supplier_id',rate = '$rate', lastupdated=now() where rateid='$rateid'";
		mysqli_query($connection,$sql_update);
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $rateid,'updated');
		echo "<script>location='supllier_diesel_rate_setting.php?action=2'</script>";
	}
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
	$("#shortcut_item").click(function(){
		$("#div_item").toggle(1000);
	});
	});
	$(document).ready(function(){
	$("#shortcut_supplier_id").click(function(){
		$("#div_supplier_id").toggle(1000);
	});
	});
	</script>
</head>

<body>
<!--- short cut form item --->
<div class="messagepop pop" id="div_item">
<img src="b_drop.png" class="close" onClick="$('#div_item').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Item</strong></td></tr>
  <tr><td>&nbsp;Item Code: </td></tr>
  <tr><td><input type="text" name="itemcode" id="itemcode" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
   <tr><td>&nbsp;Item Name: </td></tr>
  <tr><td><input type="text" name="itemname" id="itemname" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

 <tr><td>&nbsp;Item Group: </td></tr>
  <tr><td><select name="groupid" id="groupid" class="input-medium" style="width:190px ; border:1px dotted #666">
  				<option value="">-Select-</option>
                <?php
				$res = mysqli_query($connection,"Select groupid,groupname from inv_m_group");
				if($res)
				{
					while($row = mysqli_fetch_assoc($res))
					{
				?>
                	<option value="<?php echo $row['groupid']; ?>"><?php echo $row['groupname']; ?></option>
                <?php
					}
				}
				?>
  			</select>
  </td></tr>
   <tr><td>&nbsp;Unit Measure: </td></tr>
  <tr><td> <select name="unitmessure" id="unitmessure" style="width:190px ; border:1px dotted #666">
                                            <option value="">-Select-</option>
                                       
                                    <option value="Pcs">Pcs</option>
                                    <option value="Packets">Packets</option>
                                    <option value="Boxes">Boxes</option>
                                    <option value="KG">KG</option>
                                    <option value="MT">MT</option>
                                    <option value="Litres">Litres</option>
                                    <option value="Galon">Galon</option>
                                        </select>
                                        </td>
                                        </tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_itemname('itemcode','itemname','groupid','unitmessure');"/></td></tr>
</table>
</div>

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
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('productid,supplier_id,rate')">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td ><strong>Item Name</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;<img src="add.png" id="shortcut_item"></td>
                                    <td ><select tabindex="1" name="productid" id="productid">
                                <option value="">-Select Item-</option>
                                <?php
									$sql_cust="select productid,itemname 	 from  inv_m_deisel_product";
									$res_cust=mysqli_query($connection,$sql_cust);
									while($row_cust=mysqli_fetch_array($res_cust))
									{
								?>
                                	<option value="<?php echo $row_cust['productid']; ?>"><?php echo $row_cust['itemname']; ?></option>
                                <?php
									}
								?>
                                </select>
                                <script>document.getElementById('productid').value = '<?php echo $productid; ?>';</script>
                                </td>
                                     <td ><strong>Select Supplier</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;<img src="add.png" id="shortcut_supplier_id"></td>
                                     <td>
                            	<select tabindex="2" name="supplier_id" id="supplier_id">
                                <option value="">-Select-</option>
                                <?php
									$sql_cust="select * from inv_m_supplier";
									$res_cust=mysqli_query($connection,$sql_cust);
									while($row_cust=mysqli_fetch_array($res_cust))
									{
								?>
                                	<option value="<?php echo $row_cust['supplier_id']; ?>"><?php echo $row_cust['supplier_name']; ?></option>
                                <?php
									}
								?>
                                </select>
                               <script>document.getElementById('supplier_id').value=<?php echo $supplier_id; ?></script>
                                
                            </td>
                             <td><strong>Rate</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td><input type="text" tabindex="3" name="rate" id="rate" value="<?php echo $rate; ?>">
                              
                                </td>
                                <tr>
                                <td colspan="6"style="line-height:5" >
                                   
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     tabindex="4" style="margin-left:490px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </span></td>
                                    </tr>
                                    
                                 
                                </table>
                                </div>
                                </form>
							</div>
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
                                            <th width="10%">Sno</th>  
                                            <th width="40%">Item Name</th>
                                             <th width="40%">Supplier</th>
                                            <th width="40%">Rate</th>
                                            <th class='hidden-480' width="10%">Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from inv_m_rate_diesel order by rateid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                           
                                            <td><?php echo  $cmn->getvalfield($connection,"inv_m_deisel_product","itemname","productid='$row[productid]'");?></td>
                                           	<td><?php echo  $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$row[supplier_id]'");?></td>
                                             <td><?php echo $row['rate'];?></td>
                                           	<td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['rateid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
function ajax_save_itemname(itemcode,itemname,groupid,unitmessure)
{
	var itemcode = document.getElementById("itemcode").value;
	var itemname = document.getElementById("itemname").value;
	var groupid = document.getElementById("groupid").value;
	var unitmessure = document.getElementById("unitmessure").value;
	if(itemcode == "" )
	{
		alert('Fill form properly');
		document.getElementById("itemcode").focus();
		return false;
	}
	else if(itemname == "")
	{
		alert('Fill form properly');
		document.getElementById("itemname").focus();
		return false;
	}
	else if(groupid == "" )
	{
		alert('Fill form properly');
		document.getElementById("groupid").focus();
		return false;
	}
	else if( unitmessure == ""  )
	{
		alert('Fill form properly');
		document.getElementById("unitmessure").focus();
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
				document.getElementById("itemid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("itemname").value = "";
				document.getElementById("itemcode").value = "";
				document.getElementById("groupid").value = "";
				document.getElementById("unitmessure").value = "";
				//$('#itemid').select2('val', '');
				$("#div_item").hide(1000);
				document.getElementById("itemid").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_saveitem.php?itemname="+itemname+"&itemcode="+itemcode+"&groupid="+groupid+"&unitmessure="+unitmessure,true);
	xmlhttp.send();

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
    <?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

	</html>
<?php
mysqli_close($connection);
?>
