<?php  error_reporting(0);
include("dbconnect.php");
$pagename = "diesel_demand_slip.php";
$modulename = "Diesel Demand Slip";
$tblpkey = "dieslipid";
$duplicate='';
$maxslipid = $cmn->getvalfield($connection,"diesel_demand_slip","max(dieslipid)","sessionid='$_SESSION[sessionid]'");

$slipno = $cmn->getvalfield($connection,"diesel_demand_slip","slipno","dieslipid='$maxslipid'") + 1;
$challandate = date('d-m-Y');
//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$prevread = 0;
$metread = "";

if(isset($_GET['p']))
$productid = $_GET['p'];
else
$productid = "";


$totalqty = 0;
if(isset($_GET['edit']))
{
	$dieslipid = $_GET['edit'];
	$sql_edit="select * from diesel_demand_slip where dieslipid='$dieslipid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			//challan info
			$slipno = $row['slipno'];
			$diedate = $row['diedate'];
			$truckid = $row['truckid'];
			$drivername = $row['drivername'];
			$dieselshortage = $row['dieselshortage'];			
			$prevread = $row['prevread'];
			$metread = $row['metread'];
			$totalkm = $row['totalkm'];
			$actual_avg = $row['actual_avg'];
			$remarks = $row['remarks'];			
			$bonus_amt = $row['bonus_amt'];
			$head_id = $row['head_id'];
			$payment_type = $row['payment_type'];
			$chequeno = $row['chequeno'];
			$bankid = $row['bankid'];
			$chequedate = $row['chequedate'];			
			$totalqty = $cmn->getvalfield($connection,"diesel_demand_detail","sum(qty)","dieslipid = '$row[dieslipid]'");
			if($totalqty != 0)
			$cal_avg = number_format($totalkm / $totalqty,2);
			else
			$cal_avg = number_format(0,2);
			
			$retbilltyid = $row['retbilltyid'];
			
		}//end while
	}//end if
}//end if
else
{
	$dieslipid = 0;
	$incdate = date('d-m-Y');
	$retbilltyid = 0;
	$diedate = date('Y-m-d');	
	$payment_type = "cash";
	$head_id =14;	
			
	$truckid = '';
	$drivername = '';
	$dieselshortage = '';			
	$prevread ='';
	$metread = '';
	$totalkm ='';
	$actual_avg = '';
	$remarks = '';			
	$bonus_amt = '';
	$head_id = '';
	$chequeno = '';
	$bankid = '';
	$chequedate = '';			
	$totalqty = 0;			
	$cal_avg = '';
			
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
<!--- short cut form truck --->
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
		$sql_sc = "select * from m_truckowner"; 
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
<!------end here ---->
<!--- short cut form supplier --->
<div class="messagepop pop" id="div_supplier_id">
<img src="b_drop.png" class="close" onClick="$('#div_supplier_id').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Supplier</strong></td></tr>
  <tr><td>&nbsp;Supplier Name: </td></tr>
  <tr><td><input type="text" name="supplier_name" id="supplier_name" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
  <tr><td>&nbsp;Address : </td></tr>
  <tr><td><input type="text" name="address" id="address" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_suppliername();"/></td></tr>
</table>
</div>
<!--- short cut form emp --->
<div class="messagepop pop" id="div_empid">
<img src="b_drop.png" class="close" onClick="$('#div_empid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Driver</strong></td></tr>
  <tr><td>&nbsp;Driver Name: </td></tr>
  <tr><td><input type="text" name="empname" id="empname" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_driver();"/></td></tr>
</table>
</div>

<?php include("../include/top_menu.php"); ?>
<!--- top Menu----->

	<div class="container-fluid" id="content">
		
  <div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
              <form id="myform"  method="post" action="save_diesel_demand_slip.php" class='form-horizontal' > 
				  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
                              
                              <input type="hidden" name="<?php echo $tblpkey; ?>" value="<?php echo $dieslipid; ?>" id="<?php echo $tblpkey; ?>">
							<table class="table table-condensed table-bordered">
							  <tr>
							    <td colspan="6"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
						      </tr>
							  <tr>
							    <td width="15%" ><strong>Slip No. :</strong><span class="red">*</span></td>
							    <td width="15%" ><strong>Date :</strong><span style="color:#F00;font-size:10px;"> (dd-mm-yyyy)</span></td>
							    <td width="15%" ><strong>Truck No. :</strong></td>
							    <td width="15%" ><strong>Driver :</strong><span class="red">*</span>&nbsp;&nbsp;</td>
							    <td width="15%" ><strong>Previous Reading:</strong></td>
							    <td width="40%" ><strong>Meter Reading :</strong><span class="red">*</span></td>
						      </tr>
							  <tr>
							    <td><input type="text" name="slipno" id="slipno" value="<?php echo $slipno; ?>" class="input-medium" onChange="checkexist(this.value);"  autofocus></td>
							    <td><input type="text" name="diedate" id="diedate" value="<?php echo $cmn->dateformatindia($diedate); ?>" class="input-medium" 
								<?php if($retbilltyid != 0) echo "readonly"; ?>></td>
							    <td><?php 
								if($retbilltyid != 0)
								{
									echo $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'"); ?>
                                <input type="hidden" name="truckid" id="truckid" value="<?php echo $truckid; ?>" class="input-medium" 
								readonly>
                                <?php
								}
								else
								{
									$sql1 = "Select A.truckid,A.truckno from  m_truck as A left join  m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by A.truckid desc";
									$res1 = mysqli_query($connection,$sql1);
 									?>
							      <select name="truckid" id="truckid"style="width:130px;"  class="input-large  select2-me" onChange="getDriver();" >
							        <option value="">-Select-</option>
							        <?php
										while($row1 = mysqli_fetch_array($res1))
										{
										?>
							        <option value="<?php echo $row1['truckid']; ?>"><?php echo $row1['truckno']; ?></option>
							        <?php
										} ?>
						          </select>
							      <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script>
                                  <?php
								}
								?></td>
							    <td>
                                                <input list="browsers" name="drivername" id="drivername" value="<?php echo $drivername; ?>" style="width:150px;" class="input-large">
                                                
                                                <datalist id="browsers">
                                                <?php
									 $sql_driver = "select drivername from bilty_entry where drivername !='' group by drivername order by drivername";
									 $res_driver = mysqli_query($connection,$sql_driver);
									 while($row_driver = mysqli_fetch_array($res_driver))
										{
									 ?>
                                                <option value="<?php echo $row_driver['drivername']; ?>">
                                               
                                          <?php
										} ?>      
                                                </datalist> 

							     </td>
							    <td><input type="text" name="prevread" id="prevread" value="<?php echo $prevread; ?>" class="input-medium" readonly ></td>
							    <td><input type="text" name="metread" id="metread" value="<?php echo $metread; ?>" onChange="setTotalKM();" autocomplete="off"  style="width:90%" ></td>
						      </tr>
							  <tr>
							    <td width="15%" ><strong>Total KM :</strong></td>
							    <!--<td width="15%" ><strong>Calculated Average :</strong></td>-->
                                 <td width="15%" ><strong>Actual Average :</strong></td>
							  
							    <td width="15%" colspan="2" ><strong>Remarks :</strong></td>
                                <td colspan="2">&nbsp;  </td>
						      </tr>
							  <tr>
							    <td><input type="text" name="totalkm" id="totalkm" value="<?php echo $totalkm; ?>" class="input-medium" readonly ></td>
							    <!--<td><input type="text" name="cal_avg" id="cal_avg" value="<?php //echo $cal_avg; ?>" class="input-medium" onChange="getShortage();" readonly ></td>-->
                                 <td><input type="text" name="actual_avg" id="actual_avg" value="<?php echo $actual_avg; ?>" class="input-medium" onChange="getAVG();"   >
							    </td>
							    
							    <td colspan="2"><input type="text" name="remarks" id="remarks" value="<?php echo $remarks; ?>" class="input-xxlarge" autocomplete="off" ></td>
						      </tr>
							  <tr>
							    <td colspan="2">&nbsp;  </td>
						      </tr>
							  </table>
                                   
                                <div class="control-group">
                                
                                </div>
                                <table width="100%">
                                <tr>
                                	<td align="right"><strong>Total Qty :   <input type="text" readonly class="input-medium" style="color:red" name="totalqty" id="totalqty" value="<?php echo $totalqty ; ?>"></strong></td>
                                </tr>
                                </table>
                                 <table width="100%" border="1" >
                                      <tr bgcolor="#CCCCCC" >
                                        <td height="25px"><b>Supplier</b>&nbsp;&nbsp;<img src="add.png" id="shortcut_supplier_id" style="cursor:pointer"></td>
                                        <td height="25px"><b>Item</b></td>
                                        <td height="25px"><b>Rate</b></td>
                                        <td height="25px"><b>Qty</b></td>
                                        <td height="25px"><b>Naration</b></td>
                                        <td height="25px"><b>Action</b></td>
                                      </tr>
                                      <tr>
                                        <td><select id="supplier_id" style="width:200px;" onChange="getrate();" class="select2-me" >
                                        	<option value="0">-Select-</option>
                                            <?php 
											$sql3 = "select supplier_id,supplier_name from  inv_m_supplier";
											$res3 = mysqli_query($connection,$sql3);
											while($row3 = mysqli_fetch_array($res3))
												{
											?>
                                          	<option value="<?php echo $row3['supplier_id']; ?>"><?php echo $row3['supplier_name']; ?></option>
                                            <?php
												}
												?>
                                          	<option value="0" selected>other</option>
                                      </select>
                                      </td>
                                     
                                        <td><select id="productid" style="width:90px;" onChange="getrate();" class="select2-me" >
                                        	<option value="">-Select-</option>
                                            <?php 
											$sql3 = "select productid,itemname from  inv_m_deisel_product";
											$res3 = mysqli_query($connection,$sql3);
											while($row3 = mysqli_fetch_array($res3))
												{
											?>
                                          	<option value="<?php echo $row3['productid']; ?>"><?php echo $row3['itemname']; ?></option>
                                            <?php
												}
												?>
                                          	
                                      </select></td>
                                     
                                        <td><input type="text" id="rate" autocomplete="off"  maxlength="120" class="input-small" style="width:90px" ></td>
                                     
                                        <td>
                                     <input type="text" id="qty" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" >
                                     
                                        </td>
                                        <td>
                                        	<input type="text"id="naration" autocomplete="off"  maxlength="120"  class="input-small" style="width:90px" >
                                        </td>
                                       
                                        <td>
                                        <input type="button" value="ADD" style="width:60px;" id="add" onClick="return myFunction();"  class="btn-small btn-success" onKeyUp="chengefocus();"/></td>
                                      </tr>
                                    </table>
                                     <br>
                                 <table id="myTable" border="1" width="100%">
                                    <tr bgcolor="#CCCCCC">
                                    	<td width="3%" height="25px"><b>Slno</b></td>
                                        <td width="27%" height="25px"><b>Supplier</b></td>
                                        <td width="14%" height="25px"><b>Item</b></td>
                                        <td width="15%" height="25px"><b>Rate</b></td>
                                        <td width="16%" height="25px"><b>Qty</b></td>
                                        <td width="16%" height="25px"><b>Naration</b></td>
                                       <td width="9%" height="25px"><b>Action</b></td>
                                   </tr>
                                   <?php
								   if($dieslipid!=0 && $dieslipid!="")
								   {
									   $slno = 1;
									   $sql_edit_billty = "select * from diesel_demand_detail where dieslipid='$dieslipid'";
									   $res_edit_billty = mysqli_query($connection,$sql_edit_billty);
									   while($row_edit_billty =  mysqli_fetch_array($res_edit_billty))
									   {
								   ?>
                                        <tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><input type="text" name="supplier_name[]" id="supplier_name<?php echo $slno; ?>" 
                                            value="<?php if($row_edit_billty['supplier_id'] == 0 ) echo "other"; 
											else echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$row_edit_billty[supplier_id]'"); ?>" style="width:250px;border:none;" readonly>
                                        <input type="hidden" name="supplier_id[]" id="supplier_id<?php echo $slno; ?>" value="<?php echo									$row_edit_billty['supplier_id']; ?>" ></td>
                                            <td><input type="text" name="productname[]" id="productid<?php echo $slno; ?>" value="<?php echo $cmn->getvalfield($connection," inv_m_deisel_product","itemname","productid = '$row_edit_billty[productid]'"); ?>" 
                                            style="width:50px;border:none;" readonly>
                                            <input type="hidden" name="productid[]" value="<?php echo $row_edit_billty['productid']; ?>" 
                                            style="width:50px;border:none;"></td>
                                           
                                            <td>
                                            <input type="text" name="rate[]" id="rate<?php echo $slno; ?>" 
                                            value="<?php echo $row_edit_billty['rate']; ?>" style="width:50px;border:none;" readonly>
                                            </td>
                                             <td><input type="text" name="qty[]" id="qty<?php echo $slno; ?>" value="<?php echo $row_edit_billty['qty']; ?>" 
                                            style="width:50px;border:none;" readonly></td>
                                            <td>
                                            <input type="text" name="naration[]" id="naration<?php echo $slno; ?>"
                                             value="<?php echo $row_edit_billty['naration'] ;?>"
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


	
    <table id="myTable" border="1" width="100%">
     <div id="div1" style="display:none;"> 
            <tr bgcolor="#CCCCCC">           
            <td width="14%" height="25px"><b>Bonus Amount</b></td>
            <td width="15%" height="25px"><b>Head</b></td>
            <td width="27%" height="25px"><b>Payment Type</b></td>           
            <td width="16%" height="25px"><b>Cheque No.</b></td>
            <td width="16%" height="25px"><b>Bank Name</b></td>
            <td width="9%" height="25px"><b>Cheque Date</b></td>
            </tr>
       </div>       
            <tr>	
            		<td><input type="text" name="bonus_amt" value="<?php echo $bonus_amt; ?>" id="bonus_amt" autocomplete="off"  class="input-large"></td>
                    <td>
                    		 <select id="head_id" name="head_id" class="formcent select2-me" style="width:224px;">
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select head_id,headname from other_income_expense where headtype='Bonus' order by headname");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['head_id']; ?>"  ><?php echo $row_fdest['headname']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('head_id').value = '<?php echo $head_id; ?>';</script>
                    </td>
                    <td> 
                            <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                            <option value="">-Select-</option>
                            <option value="cash">CASH</option>
                            <option value="cheque">CHEQUE</option>
                            <option value="neft">NEFT</option>
                            </select>
                            <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>                                    
                    </td>
                    
                     <div id="div2"> 
                     
                    <td> <input class="form-control" name="chequeno" id="chequeno" value="<?php echo $chequeno; ?>" type="text" placeholder="Enter Cheque No" autocomplete="off" > </td>
                    <td>
                            <select name="bankid" id="bankid"  class="formcent select2-me" style="width:224px;" >
                            <option value="">-Select-</option>
                            <?php 
                            $sql = mysqli_query($connection,"select bankid,bankname,helpline from m_bank order by bankname");
                            while($row=mysqli_fetch_assoc($sql))
                            {
                            ?>
                            <option value="<?php echo $row['bankid']; ?>"><?php echo $row['bankname'].' / '.$row['helpline']; ?></option>
                            <?php 
                            }
                            ?>
                            </select>
                            <script>document.getElementById('bankid').value = '<?php echo $bankid ; ?>'; </script>
                    </td>
                    <td> <input class="form-control" name="chequedate" id="chequedate" value="<?php echo $cmn->dateformatindia($chequedate); ?>" data-date="true" placeholder="dd-mm-yyyy" type="text"> </td>
                    </div>
            </tr>    
    </table>
                                   
                                   <br>
									<br>

                                 <table width="100%">
                                    	<tr>
                                        	<td>
                                            	<center>
                                        		<input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checktablerow()"   >
                                                 &nbsp;&nbsp;&nbsp;&nbsp;
                                                 <a href="diesel_demand_slip.php" class="btn btn-danger">Clear</a>
                                                
                                                 
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
                                            <th>Slip No.</th>
                                            <th>Date</th>
                                            <th>Truck No.</th>
                                            <th>Driver</th>
                                            <th>Prev. Reading</th>
                                            <th>Meter Reading</th>
                                            <th>Total KM</th>
                                            <th>Average</th> 
                                            <th>Total Amount</th>                                          
                                           	<th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from diesel_demand_slip order by dieslipid desc";
									$res = mysqli_query($connection,$sel);
									$total_challan_adv = 0;
									$total_challan_weight = 0;
									while($row = mysqli_fetch_array($res))
									{
										$openningkm=0;
										$metread=0;
										$dieslipid = $row['dieslipid'];
										$truckid = $row['truckid'];
										$tot = $cmn->getvalfield($connection,"diesel_demand_detail","sum(qty * rate)","dieslipid = '$row[dieslipid]'");
										$tot_qty = $cmn->getvalfield($connection,"diesel_demand_detail","sum(qty)","dieslipid = '$row[dieslipid]'");
									$openningkm = $cmn->getvalfield($connection,"m_truck","openningkm","truckid='$truckid'");	
									$sql_prev = mysqli_query($connection,"Select metread from diesel_demand_slip where dieslipid = (select max(dieslipid) from diesel_demand_slip where truckid = '$truckid' && dieslipid < '$dieslipid')");
									if($sql_prev)
									{
									while($row_prev = mysqli_fetch_assoc($sql_prev))
									{
									$metread = $row_prev['metread'];
									}
									}
									
									if($metread == "")
									{
									$metread += $openningkm;
									
									if($metread == "")
									{	
									$metread = 0;
									}									
									}
	
	
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['slipno'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['diedate']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid ='$row[truckid]'"); ?></td>
                                            <td><?php echo $row['drivername']; ?></td>
                                            <td><?php echo number_format($metread,2); ?></td>
                                            <td><?php echo $row['metread']; ?></td>                                            
                                            <td><?php echo $row['totalkm']; ?></td>
                                            <td>
											<?php
											if($tot != 0)
											echo number_format($row['totalkm']/$tot_qty,2);
											else
											echo number_format(0,2);
											?>
                                            </td>
                                           <td><?php echo round($tot); ?></td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['dieslipid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['dieslipid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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

function checkexist(slipno)
{
	if(slipno != "" )
	{
	$.ajax({
		  type: 'POST',
		  url: 'ajax_check_slipno.php',
		  data: 'slipno=' + slipno.trim(),
		  dataType: 'html',
		  success: function(data){
			 if(data != "0" && data != "")
			 {
				alert("Slip no Already Exist");
				$("#slipno").val("");
				$("#slipno").focus();
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
	slipno = $("#slipno").val();
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
	  tblname = 'm_place';
	  tblpkey = '<?php echo $tblpkey; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this RECORD."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete_demand_slip.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location='diesel_demand_slip.php?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close



</script>
<script>
function myFunction()
{
	//alert('hi');
	truckid =  $("#truckid").val();
	metread = $("#metread").val();
	
	
	var supplier_id = document.getElementById("supplier_id").value;
	var supplier_name = $("#supplier_id option:selected").text();
	var productid = document.getElementById("productid").value;
	var itemname = $("#productid option:selected").text();
	var rate = document.getElementById("rate").value;
	var qty = document.getElementById("qty").value;
	var naration = document.getElementById("naration").value;
	var totalkm = document.getElementById("totalkm").value;
	var totalqty = document.getElementById("totalqty").value;

	//alert(productid);
	if(supplier_id!="" && productid!="" && rate!="" && qty!="" && truckid !="" && metread != "" )
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
		t2.id = "supplier_name" + rowcount;
		t2.name = "supplier_name[]";
		t2.style.width = "98%";
		t2.style.border = "none";
		t2.readOnly = "true";
		t2.value = supplier_name.trim();
		cell2.appendChild(t2);
		
		var elehid1 = document.createElement("input");
		elehid1.type = "hidden";
		elehid1.name = 'supplier_id[]';
		elehid1.id = 'supplier_id'+rowcount;
		elehid1.value = supplier_id.trim();
		cell2.appendChild(elehid1);
		
		var cell3 = row.insertCell(2);
		var t3 = document.createElement("input");
		t3.id = "itemname" + rowcount;
		t3.name = "itemname[]";
		t3.style.width = "98%";
		t3.style.border = "none";
		t3.readOnly = "true";
		t3.value = itemname;
		cell3.appendChild(t3);
		
		var elehid2 = document.createElement("input");
		elehid2.type = "hidden";
		elehid2.name = 'productid[]';
		elehid2.id = 'productid'+rowcount;
		elehid2.value = productid.trim();
		cell3.appendChild(elehid2);
		
		var cell4 = row.insertCell(3);
		var t4 = document.createElement("input");
		t4.id = "rate" + rowcount;
		t4.name = "rate[]";
		t4.style.width = "98%";
		t4.style.border = "none";
		t4.readOnly = "true";
		t4.value = rate;
		cell4.appendChild(t4);
		
		var cell5 = row.insertCell(4);
		var t5 = document.createElement("input");
		t5.id = "qty" + rowcount;
		t5.name = "qty[]";
		t5.style.width = "98%";
		t5.style.border = "none";
		t5.readOnly = "true";
		t5.value = qty;
		cell5.appendChild(t5);
		
		var cell5 = row.insertCell(5);
		var t6 = document.createElement("input");
		t6.id = "naration" + rowcount;
		t6.name = "naration[]";
		t6.style.width = "98%";
		t6.style.border = "none";
		t6.readOnly = "true";
		t6.value = naration;
		cell5.appendChild(t6);
		
		var cell12 = row.insertCell(6);
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
				getnewavg();
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
		
		getnewavg();
		//cell2.innerHTML = pname;
		document.getElementById("rate").value = "";
		document.getElementById("naration").value = "";
		document.getElementById("qty").value = "";
		
		totalqty = parseFloat(totalqty) + parseFloat(qty);
		avg = parseFloat(totalkm) / parseFloat(totalqty);
		document.getElementById("totalqty").value = totalqty;
		document.getElementById("cal_avg").value = avg.toFixed(2);
		
		 $("#productid").select2().select2('val','');
		$('#supplier_id').val('');
		 $("#supplier_id").select2().select2('val','');//for select2 refresh to blank value
		 
		 $("#totalqty").html(totalqty);
		getShortage();
		$('#supplier_id').select2('focus');
		
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
		totalkm =  $("#totalkm").val();
		totalqty = $("#totalqty").val();
		//alert(totalqty);
		qty=$("#qty"+rowcount).val();
		//alert(qty);
		totalqty = parseInt(totalqty) - parseInt(qty);
		//alert(totalqty);
		if(totalqty != 0)
		avg = parseFloat(totalkm) / parseFloat(totalqty);
		else
		avg = 0;
		
		document.getElementById("totalqty").value = totalqty;
		//document.getElementById("cal_avg").value = avg.toFixed(2);
		getnewavg();
		
		document.getElementById("myTable").deleteRow(rowcount);
		getShortage();
		
	}
}



function checktablerow()
{
	slipno = $("#slipno").val();
	diedate =  $("#diedate").val();
	truckid =  $("#truckid").val();
	empid =  $("#empid").val();
	metread = $("#metread").val();
	
	var x = document.getElementById("myTable").rows.length;
	//alert(metread);
	if(slipno == "")
	{
		alert("please enter slip no");
		$("#slipno").focus();
		return false;
	}
	else if(diedate == "")
	{
		alert("please enter date");
		$("#diedate").focus();
		return false;
	}
	else if(truckid == "")
	{
		alert("please select truck no");
		$("#truckid").focus();
		return false;
	}
	else if(empid == "")
	{
		alert("please select driver");
		$("#empid").focus();
		return false;
	}
	else if(metread == "")
	{
		alert("please enter meter reading");
		$("#metread").focus();
		return false;
	}
	/*if(x == 1)
	{
		alert('Please add Item');
		return false;
	}*/
	
	 
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
function ajax_save_driver()
{
	var empname = document.getElementById("empname").value;
	
	if(empname == "" )
	{
		alert('Fill form properly');
		document.getElementById("empname").focus();
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
			//alert(xmlhttp.responseText);
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("empid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("empname").value = "";
				$("#div_empid").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savedriver.php?empname="+empname,true);
	xmlhttp.send();
}
//below code for date mask
jQuery(function($){
   $("#diedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
   $("#chequedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});

function set_payment(payment_type)
{	
	//alert(payment_type);
	
	if(payment_type=="cash")
	{
		//$('#div1').hide();
		//$('#div2').hide();
	}
	else
	{
	//$('#div1').show();
	//$('#div2').show();	
	}
}

function getnewavg()
{
	var tablelen = parseInt(document.getElementById('myTable').rows.length);
	var totalkm = parseFloat(document.getElementById('totalkm').value);
	//alert(tablelen);
	totalqty = 0;
	var i=1;
	var qtystr;
	var alltotqty = 0;
 //alert(totalkm);
	for(i=1;i<tablelen;i++)
	{		
		qtystr = "qty" + i;
		//alert(document.getElementById(qtystr).value);
		totalqty = document.getElementById(qtystr).value;
		//alert(totalqty);
		
		alltotqty = parseFloat(alltotqty) + parseFloat(totalqty);
	}
	
	
	
		var avg = parseFloat(totalkm / alltotqty);
		
		
		document.getElementById('actual_avg').value = avg;
}

//getnewavg();
//alert(document.getElementById('myTable').rows.length);
</script>


	</body>
	</html>
<?php
mysqli_close($connection);
?>
