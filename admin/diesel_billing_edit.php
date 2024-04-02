<?php error_reporting(0);
include("dbconnect.php");
$tblname = "diesel_billing";
$tblpkey = "uchid";
$pagename = "diesel_billing.php";
$modulename = "Diesel Billing";

//print_r($_SESSION);
$maxid = $cmn->getvalfield($connection,"diesel_billing","max(diesel_billid)","1=1");
$maxbillno = $cmn->getvalfield($connection,"diesel_billing","max(diesel_billno)","diesel_billid = '$maxid' ") + 1;
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


$duplicate= "";
if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$supplier_id = $_POST['supplier_id'];
	$diesel_billno = $_POST['diesel_billno'];
	$diesel_billdate = $cmn->dateformatusa($_POST['diesel_billdate']);
	$remarks = $_POST['remarks'];
	$demandlist = $_POST['demandlist'];
	$rate = $_POST['rate'];
	$diesel_detailid = explode(",",$demandlist);
	$billno = $_POST['billno'];
	$billno = $_POST['billno'];
	$diesel_billid = $_POST['diesel_billid'];
	//print_r($demandlist);die;
	if($demandlist != "")
	{
		//echo $diesel_billid;die;
		if($diesel_billid == "")
		{
		$sql_ins = "insert into diesel_billing set diesel_billno = '$diesel_billno',diesel_billdate = '$diesel_billdate',supplier_id= '$supplier_id',remarks = '$remarks',createdate = now(),lastupdated = now(),sessionid = '$_SESSION[sessionid]'";
		$res_ins = mysqli_query($connection,$sql_ins);
		$diesel_billid = mysqli_insert_id($connection);
		}
		else
		{	
		$sql_ins = "update diesel_billing set diesel_billno = '$diesel_billno',diesel_billdate = '$diesel_billdate',supplier_id= '$supplier_id',remarks = '$remarks',lastupdated = now() where diesel_billid = '$diesel_billid'";
		$res_ins = mysqli_query($connection,$sql_ins);
		}
		
	}
	if($res_ins)
	{
		$sql_old = mysqli_query($connection,"Select diesel_detailid from diesel_billing_detail where  diesel_billid = '$diesel_billid'");
		while($row_old = mysqli_fetch_assoc($sql_old))
		{
			mysqli_query($connection,"update diesel_demand_detail set isbilled = '0' where diesel_detailid = '$row_old[diesel_detailid]' ");
		}
		mysqli_query($connection,"delete from diesel_billing_detail where diesel_billid = '$diesel_billid'");
		
		for($i=0;$i<count($diesel_detailid);$i++)
		{
			$sql_det = "insert into diesel_billing_detail set diesel_billid = '$diesel_billid',diesel_detailid = '$diesel_detailid[$i]',createdate=now(),lastupdated=now(),sessionid='$_SESSION[sessionid]',billno = '$billno[$i]'";
			//echo "<br>";
			$res_det = mysqli_query($connection,$sql_det);
			mysqli_query($connection,"update diesel_demand_detail set isbilled = '1',rate = '$rate[$i]' where diesel_detailid = '$diesel_detailid[$i]' ");
			
		}//die;
	}
	echo "<script>location='$pagename';</script>";

}
if(isset($_GET['search']))
{
	$supplier_id = addslashes(trim($_GET['supplier_id']));
	$from_date = addslashes(trim($_GET['from_date']));
	$to_date = addslashes(trim($_GET['to_date']));
	$billing_type =  addslashes(trim($_GET['billing_type']));
	if($supplier_id != "" && $from_date != "" && $to_date != "")
	{
		$from_date = $cmn->dateformatusa($from_date);
		$to_date =  $cmn->dateformatusa($to_date);
		
		
		
		
		
		//echo $sql_srch;die;
	}
	
}
if(isset($_GET['edit']))
{
	$diesel_billid = addslashes(htmlspecialchars(trim($_GET['edit'])));
	$sql_edit = mysqli_query($connection,"select * from  diesel_billing where diesel_billid = '$diesel_billid'");
	$row_edit = mysqli_fetch_assoc($sql_edit);
	$diesel_billno = $row_edit['diesel_billno'];
	$supplier_id = $row_edit['supplier_id'];
	$diesel_billdate = $row_edit['diesel_billdate'];
	$remarks = $row_edit['remarks'];
	
	$demandlist = "";
	$sql_d = mysqli_query($connection,"select diesel_detailid from  diesel_billing_detail where diesel_billid  = '$diesel_billid'");
	while($row_d = mysqli_fetch_assoc($sql_d))
	$demandlist =$demandlist.",".$row_d['diesel_detailid'];
	
	
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
   
	
	$("#shortcut_supplier_id").click(function(){
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
			  <div class="row-fluid" id="new" >
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							<div class="box-content">
                                 <form  method="get" action="" class='form-horizontal'>
                                
                                <div class="control-group">
                                <table class="table table-condensed">
                               
                                <tr>
                                 	<td style="width:20%"><strong>Supplier: <span class="red">*</span></strong>&nbsp;&nbsp;<img src="add.png" id="shortcut_supplier_id"></td>
                                 	<td style="width:20%"><strong>From Date:<span class="red">*</span></strong></td>
                                    <td style="width:20%"><strong>To Date:<span class="red">*</span></strong></td>
                                    <td style="width:40%" colspan="3"><strong>Bill No.</strong></td>
                                 </tr>
                                
                                  <tr>
                                    <td width="15%">
                                    <select name="supplier_id" id="supplier_id" class="select2-me input-large" >
                                      <option value="">-Select-</option>
                                      <?php
                                        $sql = "Select supplier_id, supplier_name from inv_m_supplier";
                                        $res = mysqli_query($connection,$sql);
                                        if($res)
                                        {
                                            while($row = mysqli_fetch_assoc($res))
                                            {
                                        ?>
                                      			<option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>
                                      <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <script>document.getElementById('supplier_id').value='<?php echo $supplier_id; ?>';</script>
                                    </td>
                                    <?php 
									if($$diesel_billid == "" )
									{?>
                                    <td>
                                    <input type="text" name="from_date" id="from_date" value="<?php echo $cmn->dateformatindia($from_date); ?>" 
                                    class="input-large" placeholder='DD-MM-YYYY'></td>
                                    <td width="17%"><input type="text" name="to_date" id="to_date" value="<?php echo $cmn->dateformatindia($to_date); ?>" 
                                    class="input-large" placeholder='DD-MM-YYYY'></td>
                                    <td>
                                     <select name="billing_type" id="billing_type" class="input-small" >
                                      <option value="">-All-</option>
                                     
                                      			<option value="1">Billed</option>
                                                <option value="0">Not Billed</option>
                                      
                                    </select>
                                    <script>document.getElementById('billing_type').value = '<?php echo $billing_type; ?>' ; </script>
                                    </td>
                                  
                                   
                                   
                                  <td align="left">
                                     <input type="submit" name="search" id="search" value="Search" 
                                     class="btn btn-primary" 
                    onClick="return checkinputmaster('supplier_id,from_date,to_date')" tabindex="10" style="margin-left:105px">
                    </td>
                    <td>
									<input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									
                                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" ></td>
                                  <?php
									}
									?></tr>
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				
                <!--   DTata tables -->
                
               <?php
			   if(isset($_GET['search']) || $diesel_billid != "")
				{?>
                 <form action="" method="post">
                  <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $supplier_id; ?>">
                   <input type="hidden" name="diesel_billid" id="diesel_billid" value="<?php echo $diesel_billid; ?>">
                 <!--- short cut form place --->
                <div  id="div_diesel_bill" class="accordion" <?php  if($diesel_billid == "") {?>style="display:none;background:#CCCDC9; border:1px solid" 
				<?php } else { ?>style="background:#CCCDC9; border:1px solid" <?php }?> >
                <strong style="font-size:14px;color:#F00;">&nbsp;Generate Bill</strong>
                <img src="b_drop.png" class="close" onClick="$('#div_diesel_bill').toggle(1000); $('#make_bill').toggle(1000);">
                <table width="100%" border="0" class="table table-condensed" >
                  <tr>
                   
                    <td>&nbsp;<b>Bill No. :</b> </td>
                    <td><input type="text" name="diesel_billno" id="diesel_billno" value="<?php if($diesel_billno == "") echo $diesel_billno; else echo $maxbillno; ?>" class="input-medium"/></td>
                    
                    <td>&nbsp;<b>Bill Date. :</b> </td>
                    <td><input type="text" name="diesel_billdate" id="diesel_billdate"value="<?php echo $cmn->dateformatindia($diesel_billdate); ?>" class="input-medium" /></td>
                  
                    <td>&nbsp;<b>Remarks :</b> </td>
                    <td><input type="text" name="remarks" value="<?php echo $remarks; ?>" id="remarks" class="input-large"/></td>
                    
                    <td><input type="submit" value="Save" name="submit" id="submit" class="btn-small btn-success" onClick="return checkinputs();" /></td>
                 </tr>
                </table>
                </div>
                <!------end here ---->
               
               <input type="text"  id="searchslip"  placeholder ="Search">
               <?php if( $diesel_billid == ""){?>
                <span class="badge badge-important" style="font-size:18px; cursor:pointer;" id="make_bill" onClick="return checkinputs();" >Generate bill</span>
                <?php } ?>
               <br>
                <input type="text" name="demandlist" id="demandlist" value="<?php echo $demandlist; ?>">
            	<div style="height:300px;overflow-y:scroll">
                <?php
				 
								 $sql_srch = "Select *,diesel_demand_detail.diesel_detailid as mainid from diesel_demand_detail left join diesel_demand_slip on diesel_demand_slip.dieslipid = diesel_demand_detail.dieslipid left join diesel_billing_detail on diesel_billing_detail.diesel_detailid = diesel_demand_detail.diesel_detailid where diedate between '$from_date' and '$to_date' and supplier_id = '$supplier_id' ";
								 if( $diesel_billid != "")
									$sql_srch = "Select *,diesel_demand_detail.diesel_detailid as mainid from diesel_demand_detail left join diesel_demand_slip on diesel_demand_slip.dieslipid = diesel_demand_detail.dieslipid left join diesel_billing_detail on diesel_billing_detail.diesel_detailid = diesel_demand_detail.diesel_detailid where supplier_id = '$supplier_id' ";
								 else if($billing_type == "")// blank for all
									$sql_srch .= " and  (diesel_billing_detail.ispaid = '0' or diesel_billing_detail.ispaid IS NULL)";//which is not paid
									else if($billing_type == "1")//1 for billed and blank for all
									$sql_srch .= " and diesel_demand_detail.diesel_detailid in ( Select diesel_detailid from diesel_billing_detail where ispaid = '0' )";//which is not paid
									else if($billing_type == "0")//0 not billed
									$sql_srch = "Select *,diesel_demand_detail.diesel_detailid as mainid from diesel_demand_detail left join diesel_demand_slip on diesel_demand_slip.dieslipid = diesel_demand_detail.dieslipid where diedate between '$from_date' and '$to_date' and supplier_id = '$supplier_id' and isbilled = '0' ";
									 
									 ?>
                                <table border="1" width="100%"  cellpadding="5" class="mohan" >
                               
                                <tr style="background:#636; color:#FFF">
                                 	<td width="5%"><strong>S.No.</strong></td>
                                 	<td width="16%"><strong>Slip No.</strong></td>
                                    <td width="20%"><strong>Demand Date</strong></td>
                                    <td width="12%"><strong>Bill No.</strong></td>
                                    <td width="12%"><strong>Vehicle</strong></td>
                                    <td width="8%"><strong>Item</strong></td>
                                     <td width="6%" align="center"><strong>Qty</strong></td>
                                    <td width="8%" align="right"><strong>Rate</strong></td>
                                    <td width="13%" align="right"><strong>Amount</strong></td>
                                 </tr>
                                <?php
									 
									//echo $sql_srch;
								 $res = mysqli_query($connection,$sql_srch);
								 if($res)
								 {
									 $sn = 1;
									 $billno = "";
									 while($row = mysqli_fetch_assoc($res))
									 {
										$diesel_billid = $cmn->getvalfield($connection,"diesel_billing_detail","diesel_billid","diesel_detailid = '$row[mainid]'");
										$diesel_billno = $cmn->getvalfield($connection,"diesel_billing","diesel_billno","diesel_billid = '$diesel_billid'");
										$billno = $cmn->getvalfield($connection,"diesel_billing_detail","billno","diesel_detailid = '$row[mainid]'");
										$diesel_detailid = $row['mainid'];
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row[truckid]'");
										$itemname = $cmn->getvalfield($connection,"inv_m_deisel_product","itemname","productid = '$row[productid]'");
										
										
								 ?>
                                 <tr class="data-content" data-slip="<?php echo $row['slipno']; ?>" data-date="<?php echo $cmn->dateformatindia($row['diedate']); ?>" data-bill="<?php echo $billno; ?>"  data-truckno="<?php echo $truckno; ?>" data-item="<?php echo $itemname; ?>" data-qty="<?php echo  $row['qty']; ?>" data-rate="<?php echo  $row['rate']; ?>" data-amt="<?php echo  $row['amt']; ?>">
                                 	<td>
                                    <span id="actionid<?php echo $sn; ?>">
									<?Php if($diesel_billno == "") {?>
                                    <input type="checkbox" id="chk<?php echo $sn; ?>"  onclick="addids(<?php echo $sn; ?>,<?php echo $diesel_detailid; ?>)" value="<?php echo $row['mainid'];?>" >
									<?php } 
									else { ?>
                                    <input type="button" id="rem<?php echo $row['mainid'];?>"   class="btn-danger" onClick="remove_bill1(<?php echo $row['mainid'];?>,<?php echo $sn; ?>)" value="X" >
									<?php }?>
                                    </span>
                                    <input type="hidden" id="del<?php echo $row['mainid'];?>" value="<?php echo $row['mainid'];?>">
                                    <strong><?php echo $sn; ?></strong></td>
                                 	<td><?php echo $row['slipno']; ?></td>
                                    <td><?php echo $cmn->dateformatindia($row['diedate']); ?></td>
                                    <td>
                                    <div id="showbill<?php echo $diesel_detailid; ?>">
                                    <?php 
									if($billno != "")
									{?>
                                    <span id="billno<?php echo $diesel_detailid; ?>"><strong class="red"><?php echo $billno; ?>
                                    </strong></span>
                                    <?php
									}
									else
									{?>
                                    <input type="text" value="<?php echo $billno; ?>" id="billno<?php echo $diesel_detailid; ?>" class="input-medium" name="billno[]">
                                    <?php
									}?>
                                    </div>
                                    </td>
                                    <td><?php echo $truckno; ?></td>
                                    <td><?php echo  $itemname; ?></td>
                                    <td align="center"><span id="qty<?php echo $diesel_detailid; ?>"><?php echo $row['qty']; ?></span></td>
                                    <td align="right"><input type="text" value="<?php echo number_format($row['rate'],2); ?>" name="rate[]" id="rate<?php echo $diesel_detailid; ?>" onChange="setTotal(<?php echo $diesel_detailid; ?>);"></td>
                                   <td align="right" class="red" id="amt<?php echo $diesel_detailid; ?>">
								   <strong style="font-size:14px"><?php echo number_format($row['rate'] * $row['qty'],2); ?></strong></td>
                                 </tr>
                                 <?php
								 $sn++;
									 }
								 }
								 ?>
                                
                               
                                </table>
                               </div>
                </form>
					<script>
				
                    function setTotal(id)
                    {
                       qty = $("#qty"+id).html();
                       rate = $("#rate"+id).val();
                       amt = parseFloat(qty) * parseFloat(rate);
                       $("#amt"+id).html(''+amt.toFixed(2));
                    }
                    </script>
                               
                <?php
				}
				?>			
			</div>
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
                                            <th><strong>Bill No.</strong></th>
                                             <th><b>Bill Date</b></th>  
                                            <th><b>Remarks</b></th>                                           
                                           <th><b>Action</b></th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from diesel_billing ";
									$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['diesel_billno'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['diesel_billdate']);?></td>
                                            <td><?php echo ucfirst($row['remarks']);?></td>
                                            
                                           
                                           
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['diesel_billid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['diesel_billid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		</div></div>
       <script>
    $(document).ready(function() { 
        $('#searchslip').keyup(function() { 
								//	alert('g');
            var searchterm = $('#searchslip').val().toLowerCase(); 
            $('.data-content').each(function() { 
                var theValue = $(this).attr('data-slip').toLowerCase(); 
				var dateval = $(this).attr('data-date').toLowerCase();
				var billval = $(this).attr('data-bill').toLowerCase(); 
				var trucknoval =  $(this).attr('data-truckno').toLowerCase(); 
				var itemval =  $(this).attr('data-item').toLowerCase(); 
				var qtyval =  $(this).attr('data-qty').toLowerCase(); 
				var rateval =  $(this).attr('data-rate').toLowerCase(); 
				var amtval =  $(this).attr('data-amt').toLowerCase(); 
				//theValue = theValue.split(",");
				//alert(theValue);
                    if (theValue.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    } 
					else if (dateval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    } 
					else if (billval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    } 
					else if (trucknoval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    }
					else if (itemval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    }
					else if (qtyval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    }
					else if (rateval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    }
					else if (amtval.indexOf(searchterm) == 0) { 
                        $(this).show(); 
                    }
                    else { 
                        $(this).hide(); 
                    } 
            }); 
        }); 
    });
</script>
<script>
function checkinputs()
{
	 len = document.getElementById("demandlist").value ;
	//alert(len);
	if(len == "")
	{
		alert("Please select demand slips to generate bills...");
		return false;
	}
	else
	{
		$('#div_diesel_bill').toggle(1000); $('#make_bill').toggle(1000);
	}
}
</script>
<script>
function remove_bill1(mainid,sn)
{
	//alert(mainid);
	if(confirm("Are you sure! You want to delete this bill no. ??"))
	{
		$.ajax({
		  type: 'POST',
		  url: 'ajax_remove_bill.php',
		  data: 'diesel_detailid=' + mainid ,
		  dataType: 'html',
		  success: function(data){
			//alert(data);
			 if(data == '1')
			 {
				 document.getElementById('actionid'+sn).innerHTML = '<input type="checkbox" id="chk'+sn+'"  onclick="addids('+sn+','+mainid+')" value="'+mainid+'" >';
				  document.getElementById('showbill'+mainid).innerHTML = "<input type='text' value='' id='billno"+mainid+"' class='input-medium' name='billno[]'>";
				  delproduct = document.getElementById("del" + mainid).value;
				  prod_cnt_old = document.getElementById("demandlist").value;
					if(prod_cnt_old != "")
					{
						var prod_cnt_new = prod_cnt_old.replace(delproduct, "0");
						//alert(prod_cnt_new);
						document.getElementById("demandlist").value = prod_cnt_new;
						
					}	
				 		
			}
		  }
		
		  });//ajax close
	}//confirm close
}
</script>
<script>
function addids(sn,mainid)
{
    strids="";
	//alert(sn+","+mainid);
	billno = $("#billno"+mainid).val();
	if(document.getElementById("chk" + sn).checked == true && billno == "")
	{
		alert("Please enter bill no");
		document.getElementById("chk" + sn).checked = false;
		$("#billno"+mainid).focus();
		return false;
	}//end if
	else if(document.getElementById("chk" + sn).checked == false)
	{
		//strids = document.getElementById("demandlist").value;
		delproduct = document.getElementById("chk" + sn).value;
		prod_cnt_old = document.getElementById("demandlist").value;
		if(prod_cnt_old != "")
		{
			var prod_cnt_new = prod_cnt_old.replace(delproduct, "0");
			//alert(prod_cnt_new);
			document.getElementById("demandlist").value = prod_cnt_new;
			
		}	
		$("#billno"+mainid).val("");
		return false;
	}
	else
	{
		//strids = document.getElementById("demandlist").value;
		var cbs = document.getElementsByTagName('input');
		var len = cbs.length;
		//alert(len);
		for (var i = 1; i < len; i++)
		{
		 if (document.getElementById("chk" + i)!=null)
		 {
			// alert(document.getElementById("chk" + i).checked);
		
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
    	document.getElementById("demandlist").value = strids;
	}//end else
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
//below code for date mask
jQuery(function($){
   $("#diesel_billdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
    $("#from_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
	 $("#to_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});

</script>
	</body>
	</html>
<?php
mysqli_close($connection);
?>
