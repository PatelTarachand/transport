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
$netamt = 0;

$duplicate= "";
$compid = 1;
if(isset($_POST['submit']))
{
	//print_r($_POST);die;
	$diesel_billno = $_POST['diesel_billno'];
	$compid = $_POST['compid'];
	$diesel_billdate = $cmn->dateformatusa($_POST['diesel_billdate']);
	$remarks = $_POST['remarks'];
	$demandlist = $_POST['demandlist'];
	$supplier_id = $_POST['supplier_id'];
	$rate = $_POST['rate'];
	$diesel_detailid = explode(",",$demandlist);
	$billno = $_POST['billno'];
	//print_r($billno);die;
	$sql_ins = "insert into diesel_billing set diesel_billno = '$diesel_billno',compid = '$compid',diesel_billdate = '$diesel_billdate',supplier_id = '$supplier_id',remarks = '$remarks',createdate = now(),lastupdated = now(),sessionid = '$_SESSION[sessionid]'";
	$res_ins = mysqli_query($connection,$sql_ins);
	if($res_ins)
	{
		$lastid = mysqli_insert_id($connection);
		for($i=0;$i<count($diesel_detailid);$i++)
		{
			$rate = $_POST['rate'.$diesel_detailid[''.$i]];
			$billno = $_POST['billno'.$diesel_detailid[''.$i]];
			  $sql_det = "insert into diesel_billing_detail set diesel_billid = '$lastid',diesel_detailid = '$diesel_detailid[$i]',createdate=now(),lastupdated=now(),sessionid='$_SESSION[sessionid]',billno = '$billno'";
			//echo "<br>";
			$res_det = mysqli_query($connection,$sql_det);
			mysqli_query($connection,"update diesel_demand_detail set isbilled = '1',rate = '$rate' where diesel_detailid = '$diesel_detailid[$i]' ");
			
		}//die;
	}
	echo "<script>location='$pagename';</script>";

}
if(isset($_GET['search']))
{
	$supplier_id = addslashes(trim($_GET['supplier_id']));
	$compid =  addslashes(trim($_GET['compid']));
	$from_date = addslashes(trim($_GET['from_date']));
	$to_date = addslashes(trim($_GET['to_date']));
	$billing_type =  addslashes(trim($_GET['billing_type']));
	if($supplier_id != "" && $from_date != "" && $to_date != "")
	{
		$from_date = $cmn->dateformatusa($from_date);
		$to_date =  $cmn->dateformatusa($to_date);
		
		$sql_srch = "Select *,diesel_demand_detail.diesel_detailid as mainid from diesel_demand_detail left join diesel_demand_slip on diesel_demand_slip.dieslipid = diesel_demand_detail.dieslipid left join diesel_billing_detail on diesel_billing_detail.diesel_detailid = diesel_demand_detail.diesel_detailid where diedate between '$from_date' and '$to_date' and supplier_id = '$supplier_id' ";
		
		if($billing_type == "")// blank for all
		$sql_srch .= " and  (diesel_billing_detail.ispaid = '0' or diesel_billing_detail.ispaid IS NULL)";//which is not paid
		else if($billing_type == "1")//1 for billed and blank for all
		$sql_srch .= " and diesel_demand_detail.diesel_detailid in ( Select diesel_detailid from diesel_billing_detail where ispaid = '0' )";//which is not paid
		else if($billing_type == "0")//0 not billed
		$sql_srch = "Select *,diesel_demand_detail.diesel_detailid as mainid from diesel_demand_detail left join diesel_demand_slip on diesel_demand_slip.dieslipid = diesel_demand_detail.dieslipid where diedate between '$from_date' and '$to_date' and supplier_id = '$supplier_id' and isbilled = '0'";
		
		//echo $sql_srch;die;
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
                                	<td style="width:20%"><strong>Company: <span class="red">*</span></strong>&nbsp;&nbsp;</td>
                                 	<td style="width:20%"><strong>Supplier: <span class="red">*</span></strong>&nbsp;&nbsp;<img src="add.png" id="shortcut_supplier_id"></td>
                                 	<td style="width:20%"><strong>From Date:<span class="red">*</span></strong></td>
                                    <td style="width:20%"><strong>To Date:<span class="red">*</span></strong></td>
                                    <td style="width:40%" colspan="3"><strong>Bill No.</strong></td>
                                    
                                 </tr>
                                
                                  <tr>
                                  <td width="15%">
                                    <select name="compid" id="compid" class="select2-me input-large" >
                                      <option value="">-Select-</option>
                                      <?php
                                        $sql = "Select compid, cname from m_company";
                                        $res = mysqli_query($connection,$sql);
                                        if($res)
                                        {
                                            while($row = mysqli_fetch_assoc($res))
                                            {
                                        ?>
                                      			<option value="<?php echo $row['compid']; ?>"><?php echo $row['cname']; ?></option>
                                      <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <script>document.getElementById('compid').value='<?php echo $compid; ?>';</script>
                                    </td>
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
                    onClick="return checkinputmaster('compid,supplier_id,from_date,to_date')" tabindex="10" style="margin-left:105px">
                    </td>
                    <td>
									<input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									
                                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" ></td>
                                  </tr>
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				
                <!--   DTata tables -->
                
               <?php
			   if(isset($_GET['search']))
				{?>
                 <form action="" method="post">
                 <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $supplier_id; ?>">
                  <input type="hidden" name="compid" id="compid" value="<?php echo $compid; ?>">
                 <!--- short cut form place --->
                <div  id="div_diesel_bill" class="accordion" style="display:none; background:#CCCDC9; border:1px solid">
                <strong style="font-size:14px;color:#F00;">&nbsp;Generate Bill</strong>
                <img src="b_drop.png" class="close" onClick="$('#div_diesel_bill').toggle(1000); $('#make_bill').toggle(1000);">
                <table width="100%" border="0" class="table table-condensed" >
                  <tr>
                   
                    <td>&nbsp;<b>Bill No. :</b> </td>
                    <td><input type="text" name="diesel_billno" id="diesel_billno" value="<?php echo $maxbillno; ?>" class="input-medium"/></td>
                    
                    <td>&nbsp;<b>Bill Date. :</b> </td>
                    <td><input type="text" name="diesel_billdate" id="diesel_billdate" class="input-medium" /></td>
                    <td>&nbsp;<b>Net Amt :</b> </td>
                    <td><input type="text" name="netamt_text" id="netamt_text" class="input-medium" value="<?PHP ECHO $netamt; ?>" readonly /></td>
                  
                    <td>&nbsp;<b>Remarks :</b> </td>
                    <td><input type="text" name="remarks" id="remarks" class="input-large"/></td>
                    
                    <td><input type="submit" value="Save" name="submit" id="submit" class="btn-small btn-success" onClick="ajax_save_driver_exp();"/></td>
                 </tr>
                </table>
                </div>
                <!------end here ---->
                <div>
                <input type="text"  id="searchslip"  placeholder ="Search slip No.">&nbsp;
                <span style="background-color:#0CF; border:1px solid"><strong>Net Amt :   Rs.</strong><strong><span name="netamt" id="netamt" ><?php echo round($netamt); ?></span></strong>|<strong>Total Slips :   </strong><strong><span name="total_slip" id="total_slip" ><?php echo round($netamt); ?></span></strong>
                </span>&nbsp;&nbsp;
                    <span class="badge badge-important" style="font-size:18px; cursor:pointer;" id="make_bill" onClick="return checkinputs();" >Generate bill</span>
                    </div>
                  
                <input type="hidden" name="demandlist" id="demandlist">
            	<div style="height:300px;overflow-y:scroll">
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
										$amt = $row['rate'] * $row['qty'];
										
								 ?>
                                 <tr class="data-content" data-slip="<?php echo $row['slipno']; ?>" data-date="<?php echo $cmn->dateformatindia($row['diedate']); ?>" data-bill="<?php echo $billno; ?>"  data-truckno="<?php echo $truckno; ?>" data-item="<?php echo $itemname; ?>" data-qty="<?php echo  $row['qty']; ?>" data-rate="<?php echo  $row['rate']; ?>" data-amt="<?php echo  $row['amt']; ?>">
                                 	<td>
                                    <span id="actionid<?php echo $sn; ?>"><?Php if($diesel_billno == "") {?><input type="checkbox" id="chk<?php echo $sn; ?>"  onclick="addids(<?php echo $sn; ?>,<?php echo $diesel_detailid; ?>)" value="<?php echo $row['mainid'];?>" ><?php } else { ?><input type="button" id="rem<?php echo $row['mainid'];?>"   class="btn-danger" onClick="remove_bill(<?php echo $row['mainid'];?>,<?php echo $sn; ?>)" value="X" ><?php }?>
                                    </span>
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
                                    <input type="text" value="<?php echo $billno; ?>" id="billno<?php echo $diesel_detailid; ?>" class="input-medium"   name="billno<?php echo $diesel_detailid;?>">
                                    <?php
									}?>
                                    </div>
                                    </td>
                                    <td><?php echo $truckno; ?></td>
                                    <td><?php echo  $itemname; ?></td>
                                    <td align="center"><span id="qty<?php echo $diesel_detailid; ?>"><?php echo $row['qty']; ?></span></td>
                                    <td align="right"><input type="text" value="<?php echo round($row['rate'],2); ?>" name="rate<?php echo $diesel_detailid;?>" 
                                     id="rate<?php echo $diesel_detailid; ?>" onChange="setTotal(<?php echo $diesel_detailid; ?>);"></td>
                                   <td align="right" class="red" >
								   <strong style="font-size:14px" id="amt<?php echo $diesel_detailid; ?>"><?php echo round($amt,2); ?></strong></td>
                                 </tr>
                                 <?php
								 $sn++;
									 }
								 }
								 ?>
                                
                               
                                </table>
                               </div>
                              
                               <script>
							   
							   function setTotal(id)
							   {
								   qty = $("#qty"+id).html();
								   rate = $("#rate"+id).val();
								   amt = parseFloat(qty) * parseFloat(rate);
								   $("#amt"+id).html(''+amt.toFixed(2));
								   document.getElementById("amt"+id).style.fontWeight = 'bold';
								   setnet_total();
							   }
							   </script>
                    </form>            
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
                                            <th>Company</th>
                                            <th>Supplier</th>
                                            <th><strong>Bill No.</strong></th>
                                            <th><b>Bill Date</b></th>  
                                            <th><b>Remarks</b></th>   
                                            <th><b>Total Amt</b></th>                                           
                                            <th><b>Action</b></th>
                                            <th>PDF</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from diesel_billing ";
									$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$tot = 0;
										$cname = $cmn->getvalfield($connection,"m_company","cname","compid = '$row[compid]'");
										//echo "select diesel_detailid from  diesel_billing_detail where diesel_billid = '$row[diesel_billid]'";die;
										$sql_d = mysqli_query($connection,"select diesel_detailid from  diesel_billing_detail where diesel_billid = '$row[diesel_billid]'");
										while($row_d = mysqli_fetch_assoc($sql_d))
										{
											$qty = $cmn->getvalfield($connection,"diesel_demand_detail","qty","diesel_detailid = '$row_d[diesel_detailid]'");
											$rate = $cmn->getvalfield($connection,"diesel_demand_detail","rate","diesel_detailid = '$row_d[diesel_detailid]'");
											$tot += ($qty * $rate);
										}
										//echo $tot ;die;
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cname; ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id = '$row[supplier_id]'"); ?></td>
                                            <td><?php echo $row['diesel_billno'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['diesel_billdate']);?></td>
                                            <td><?php echo ucfirst($row['remarks']);?></td>
                                            <td><?php echo number_format($tot,2);?></td>
                                           <td class='hidden-480'>
                                           <a href= "edit_diesel_billing.php?edit=<?php echo ucfirst($row['diesel_billid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['diesel_billid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
                                           <td><a href="pdf_diesel_billing.php?diesel_billid=<?php echo $row['diesel_billid']?>" target="_blank" class="red"><strong>Pdf</strong></a></td>
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
function remove_bill(mainid,sn)
{
	if(confirm("Are you sure! You want to delete this bill no. ??"))
	{
		$.ajax({
		  type: 'POST',
		  url: 'ajax_remove_bill.php',
		  data: 'diesel_detailid=' + mainid ,
		  dataType: 'html',
		  success: function(data){
			// alert(data);
			 if(data == '1')
			 {
				 document.getElementById('actionid'+sn).innerHTML = '<input type="checkbox" id="chk'+sn+'"  onclick="addids('+sn+','+mainid+')" value="'+mainid+'" >';
				  document.getElementById('showbill'+mainid).innerHTML = "<input type='text' value='' id='billno"+mainid+"' class='input-medium' name='billno[]'>";
				  total_slip = parseInt($("#total_slip").html()) - 1;
					$("#total_slip").html(total_slip);
				  	setnet_total();

			 }
			
			}
		
		  });//ajax close
	}//confirm close
}
function addids(sn,mainid)
{
    strids="";
	
	//$("#netamt").html();
	//alert(sn+","+mainid);
	billno = $("#billno"+mainid).val();
	if(document.getElementById("chk" + sn).checked == true && billno == "")
	{
		alert("Please enter bill no");
		document.getElementById("chk" + sn).checked = false;
		$("#billno"+mainid).focus();
		return false;
	}//end if
	else
	{
		//$("#billno"+mainid).val("");
		var cbs = document.getElementsByTagName('input');
		var len = cbs.length;
		//alert(len);
		s = 0;
		for (var i = 1; i < len; i++)
		{
		 if (document.getElementById("chk" + i)!=null)
		 {
			// alert(document.getElementById("chk" + i).checked);
		
			  if (document.getElementById("chk" + i).checked==true)
			  {
					++s;
					if(strids=="")
				   strids=strids + document.getElementById("chk" + i).value;
				   else
				   strids=strids + "," + document.getElementById("chk" + i).value;
				  
			   }
			   else
			   {
				  // --s;
				   //netamt = parseFloat(netamt) -  parseFloat(amt);
			   }
		  }
		}
	// alert(strids)
		$("#total_slip").html(s);
		document.getElementById("demandlist").value = strids;
		setnet_total();
	}//end else
}
function setnet_total()
{
	 strids = document.getElementById("demandlist").value;
	 list = strids.split(",");
	 var netamt = 0;
	// alert( list.length);
	 for(var i=0; i< list.length; i++)
	 {
		// alert(list[''+i]);
		 if(list[''+i] != "" && list[''+i] != '0')
		 {
			 amt = $("#amt"+list[''+i]).html();
			 netamt = parseFloat(netamt) + parseFloat(amt); 
		 }
	 }
	 
	  //alert(netamt);
	$("#netamt").html(netamt.toFixed(2));
	$("#netamt_text").val(netamt.toFixed(2));
    	
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
		  url: '../ajax/delete_diesel_billing.php',
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
