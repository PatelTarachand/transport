<?php  
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bilty_dispatch1.php';
$modulename = "Bilty Dispatch";

if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));
	//$crit=" where bid_id='$bid_id'";
	
}
else
$bid_id='';

	$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);
	$di_no = $row['di_no'];
	$truckid = $row['truckid'];
	$placeid = $row['placeid'];
	$totalweight = $row['totalweight'];
	$own_rate = $row['own_rate'];	
	$newrate = $row['newrate'];
	$adv_date = $row['adv_date'];
	if($adv_date !='') { $adv_date = $cmn->dateformatindia($adv_date); }	
	
	$adv_cash = $row['adv_cash'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other =  $row['adv_other'];
	$adv_consignor =  $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
	$consignorid= $row['consignorid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
	$truckowner = $row['truckowner'];
	$advchequedate = $row['advchequedate'];
	if($advchequedate !='') { $advchequedate = $cmn->dateformatindia($advchequedate); }
	$adv_dieselltr = $row['adv_dieselltr']; 
	$supplier_id = $row['supplier_id']; 
	$petrol_pump_type = $row['petrol_pump_type']; 
	$isuchanti = $row['isuchanti']; 
	
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
	$toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	
	//$charrate = $own_rate - $newrate;
	//$netamount = $newrate * $wt_mt;
	//$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other;
	
	if($newrate==0){ $newrate=''; }
	if($adv_cash==0){ $adv_cash=''; }
	if($adv_diesel==0){ $adv_diesel=''; }
	if($adv_cheque==0){ $adv_cheque=''; }
	
	if($adv_date=='0000-00-00' || $adv_date=='')
	{
			$adv_date = date('d-m-Y');
	}




if(isset($_POST['sub']))
{
	//$di_no = trim(addslashes($_POST['di_no']));
	$own_rate = trim(addslashes($_POST['own_rate']));
	//$consignorid = trim(addslashes($_POST['consignorid']));
	//$truckid = trim(addslashes($_POST['truckid']));
	//$newrate = trim(addslashes($_POST['newrate']));
	$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));
	$adv_cash = trim(addslashes($_POST['adv_cash']));
	$adv_diesel = trim(addslashes($_POST['adv_diesel']));
	$adv_cheque = trim(addslashes($_POST['adv_cheque']));
	$cheque_no = trim(addslashes($_POST['cheque_no']));
	$bankid = isset($_POST['bankid'])?trim(addslashes($_POST['bankid'])):'';
	$adv_dieselltr = trim(addslashes($_POST['adv_dieselltr'])); 
	$isuchanti = isset($_POST['isuchanti'])?trim(addslashes($_POST['isuchanti'])):'0';
	//$petrol_pump_type = trim(addslashes($_POST['petrol_pump_type']));
	$advchequedate = $cmn->dateformatusa(trim(addslashes($_POST['advchequedate'])));
	$adv_other = trim(addslashes($_POST['adv_other']));
	$adv_consignor = trim(addslashes($_POST['adv_consignor']));
	$supplier_id = isset($_POST['supplier_id'])?trim(addslashes($_POST['supplier_id'])):''; 
	$dispatch_date=date('Y-m-d');
	$isdispatch=1;
	$sessionid = 3;

	
		$sql_update = "update  bidding_entry  set adv_cash = '$adv_cash',adv_diesel = '$adv_diesel',adv_dieselltr='$adv_dieselltr',adv_other='$adv_other',adv_consignor='$adv_consignor',adv_cheque='$adv_cheque',cheque_no='$cheque_no',advchequedate='$advchequedate',bankid='$bankid',adv_date='$adv_date',supplier_id='$supplier_id',
		isuchanti='$isuchanti',ipaddress = '$ipaddress', isdispatch='$isdispatch' where bid_id = $bid_id"; 
			mysqli_query($connection,$sql_update);
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='bilty_dispatch1.php?action=2'</script>";
	
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
$(function() {   
	 $('#advchequedate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	 $('#adv_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
  });
</script>
</head>

<body data-layout-topbar="fixed">
	
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
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; <span style="color:#F00"></span>Billty Advance</legend>
                 
                   
                
               
               <div class="innerdiv">
                    <div> Di No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    		
                    <select id="bid_id" name="bid_id" class="formcent select2-me" style="width:220px;" onChange="getdetail();">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bid_id,di_no from bidding_entry where is_bilty=1	&& sessionid='$sessionid' and consignorid !=4");
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
                    <div> Truck No </div>
                    <div class="text">
                     <input type="text" class="formcent" id="truckno" value="<?php echo $truckno; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;" readonly autocomplete="off"  >
                </div>
                </div>
               
                <div class="innerdiv">
                    <div> From Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $fromplace; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Ship To Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $toplace; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                
                
                <div class="innerdiv">
                    <div> Owner Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $ownername; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;" readonly  autocomplete="off"  >
                </div>
                </div>
         
                
                <div class="innerdiv">
                    <div> Item Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $itemname; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
               
               <div class="innerdiv">
                    <div> Weight </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $totalweight; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
                
               
               <div class="innerdiv">
                    <div> Final Rate(M.T.) <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="own_rate" id="own_rate" value="<?php echo $own_rate; ?>" onChange="get_net_total();" style="border: 1px solid #368ee0;background-color:#cacecb;"  readonly autocomplete="off"  >
                    </div>
                </div>
            
             
            
               
                
                <div class="innerdiv">
                    <div> Advance Cash </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_cash" id="adv_cash" value="<?php echo $adv_cash; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
            
               <div class="innerdiv">
                    <div> Advance Diesel </div>
                    <div class="text">
                     <input type="text" class="formcent" name="adv_diesel" id="adv_diesel" value="<?php echo $adv_diesel; ?>" onChange="getbal();"   style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
                 <div class="innerdiv">
                    <div> Diesel(ltr.) </div>
                    <div class="text">
                     <input type="text" class="formcent" name="adv_dieselltr" id="adv_dieselltr" value="<?php echo $adv_dieselltr; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Petrol Pump </div>
                    <div class="text">
                    		
                    <select id="supplier_id" name="supplier_id" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select supplier_id,supplier_name from inv_m_supplier order by supplier_name");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['supplier_id']; ?>"><?php echo $row_fdest['supplier_name']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>';</script>                                  
                </div>
               </div>
                 
                
                 <div class="innerdiv">
                    <div> Other Advance Cash </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_other" id="adv_other" value="<?php echo $adv_other; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                <div class="innerdiv">
                    <div> Advance Cash (Consignor) </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_consignor" id="adv_consignor" value="<?php echo $adv_consignor; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                <div class="innerdiv">
                    <div>Advance Cheque Amt</div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_cheque" id="adv_cheque" value="<?php echo $adv_cheque; ?>" onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
            
               <div class="innerdiv">
                    <div>Cheque No </div>
                    <div class="text">
                     <input type="text" class="formcent" name="cheque_no" id="cheque_no" value="<?php echo $cheque_no; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div>Cheque Date </div>
                    <div class="text"> 
                     <input type="text" class="formcent" name="advchequedate" id="advchequedate" value="<?php echo $advchequedate; ?>"  data-date="true"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Bank Name <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    		
                    <select id="bankid" name="bankid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bankid,bankname,helpline from m_bank order by bankname");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['bankid']; ?>"><?php echo $row_fdest['bankname'].' / '.$row_fdest['helpline']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('bankid').value = '<?php echo $bankid; ?>';</script>                                  
                </div>
               </div>
                
                
            
                 
                <div class="innerdiv">
                    <div>Adv. Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_date" id="adv_date" value="<?php echo $adv_date; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
			<?php 
			$truckownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'"); 	
			$owner_type = $cmn->getvalfield($connection,"m_truckowner","owner_type","ownerid='$truckownerid'");
			
			if($owner_type=="self") {
				?>
				<div class="innerdiv">
                    <div><span style="color:#FF0000;"><strong>Uchanti</strong> </span> </div>
                    <div class="text">
                  
					<input type="checkbox" class="formcent" name="isuchanti" value="1" <?php if($isuchanti==1) { ?> checked="checked" <?php } ?> ><br>
                    </div>
                </div>
				<?php } ?>
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('bid_id'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
                     <input type="hidden" name="ppsuplier_id" id="ppsuplier_id" value="<?php echo $ppsuplier_id; ?>">
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                    <input  type="hidden" name="totalweight" id="totalweight" value="<?php echo $totalweight; ?>" >
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="billty_dispatch_record.php" target="_blank">Click Here</a>)</span></h3>
							</div>
								
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>Di No.</th>
                                            <th>Truck No.</th>
                                            <th>Owner Name</th>
                                        	<th>Item</th>
                                            <th>Weight</th>
                                            <th>Advance Cash</th>
                                            <th>Advance Diesel</th>
                                            <th>Other Advance </th>
                                              <th>Other Advance (Consignor) </th>
                                            <th>Advance Cheque</th>
                                        	<th>Print Recipt</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									 $sel = "select * from bidding_entry where isdispatch=1 && sessionid='$sessionid' && consignorid !=4  order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];	
										$itemid = $row['itemid'];	
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                             <td><?php echo $truckno;?></td>
                                            <td><?php echo $ownername;?></td>
                                            <td><?php echo $itemname;?>  </td> 
                                            <td><?php echo ucfirst($row['totalweight']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_diesel']);?></td>
                                            <td><?php echo ucfirst($row['adv_other']);?></td>
                                             <td><?php echo ucfirst($row['adv_consignor']);?></td>
                                            <td><?php echo ucfirst($row['adv_cheque']);?></td>
                                           <td>
                                           <a href="pdf_paiddispatchreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>  </td>
                                            <td class='hidden-480'>
                                           <a href="bilty_dispatch1.php?bid_id=<?php echo ucfirst($row['bid_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           
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
	//alert(bid_id);	
	if(bid_id !='') {
			window.location.href='?bid_id='+bid_id;
		}
}

</script>			
                
		
	</body>

	</html>
