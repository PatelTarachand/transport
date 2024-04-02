<?php  
error_reporting(0);
include("dbconnect.php");
$tblname = 'returnbidding_entry';
$tblpkey = 'bid_id';
$pagename  ='return_trip_advance.php';
$modulename = "Return Advance";
$isuchanti = ""; 

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;
if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));
	//$crit=" where bid_id='$bid_id'";
	
}
else
$bid_id='';

	$sql = mysqli_query($connection,"select * from returnbidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);
	$di_no = $row['di_no'];
	$truckid = $row['truckid'];
	$placeid = $row['placeid'];
	$totalweight = $row['totalweight'];
	$own_rate = $row['own_rate'];	
	$newrate = $row['newrate'];
	$adv_date = $row['adv_date'];
	$thirdid = $row['thirdid'];
		$otheradv_date = $row['otheradv_date'];
	if($adv_date !='') { $adv_date = $cmn->dateformatindia($adv_date); }
		if($otheradv_date !='') { $otheradv_date = $cmn->dateformatindia($otheradv_date); }
	
	$adv_cash = $row['adv_cash'];
	$remark = $row['remark'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other =  $row['adv_other'];
	$adv_consignordate =  $row['adv_consignordate'];
	$adv_consignor =  $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
	$consignorid= $row['consignorid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
		$paytype = $row['paytype'];
	
	$advchequedate = $row['advchequedate'];
	if($advchequedate !='') { $advchequedate = $cmn->dateformatindia($advchequedate); }
	$adv_dieselltr = $row['adv_dieselltr']; 
	$supplier_id = $row['supplier_id']; 
	
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
	if($adv_consignordate==0){ $adv_consignordate=''; }
	if($adv_consignor==0){ $adv_consignor=''; }
	
	if($adv_date=='0000-00-00' || $adv_date=='')
	{
			$adv_date = date('d-m-Y');
	}
	
		if($otheradv_date=='0000-00-00' || $otheradv_date=='')
	{
			$otheradv_date = date('d-m-Y');
	}
	if($adv_consignordate=='0000-00-00' || $adv_consignordate=='')
	{
			$adv_consignordate = date('d-m-Y');
	}



if(isset($_POST['sub']))
{

	//$own_rate = trim(addslashes($_POST['own_rate']));
	
	$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));
	$otheradv_date = $cmn->dateformatusa(trim(addslashes($_POST['otheradv_date'])));
	$adv_cash = trim(addslashes($_POST['adv_cash']));
	$remark = trim(addslashes($_POST['remark']));
	$adv_diesel = trim(addslashes($_POST['adv_diesel']));	
	//$bankid = isset($_POST['bankid'])?trim(addslashes($_POST['bankid'])):'';
	//$adv_dieselltr = trim(addslashes($_POST['adv_dieselltr'])); 
	$adv_other = trim(addslashes($_POST['adv_other'])); 
		$paytype = trim(addslashes($_POST['paytype']));
			$thirdid = trim(addslashes($_POST['thirdid']));
			$adv_consignordate = trim(addslashes($_POST['adv_consignordate']));
			$adv_consignor = trim(addslashes($_POST['adv_consignor']));
	$supplier_id = isset($_POST['supplier_id'])?trim(addslashes($_POST['supplier_id'])):''; 
	$dispatch_date=date('Y-m-d');
	$isdispatch=1;
	
//echo "update  bidding_entry  set adv_cash = '$adv_cash',thirdid = '$thirdid',adv_other = '$adv_other',adv_diesel = '$adv_diesel',adv_date='$adv_date',otheradv_date='$otheradv_date',supplier_id='$supplier_id',ipaddress = '$ipaddress', isdispatch='$isdispatch', paytype='$paytype' where bid_id = $bid_id"; die;
		$sql_update = "update  returnbidding_entry  set adv_cash = '$adv_cash',thirdid = '$thirdid',adv_other = '$adv_other',adv_diesel = '$adv_diesel',adv_consignordate = '$adv_consignordate',adv_consignor = '$adv_consignor',adv_date='$adv_date',otheradv_date='$otheradv_date',remark='$remark',supplier_id='$supplier_id',ipaddress = '$ipaddress', isdispatch='$isdispatch', paytype='$paytype' ,is_bilty=1 where bid_id = $bid_id"; 
			mysqli_query($connection,$sql_update);
			
			echo "<script>location='$pagename?action=2'</script>";
	
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
		     <?php include("alerts/showalerts.php"); ?>
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                   
                    
    				<fieldset style="margin-top:45px; margin-left:45px;" >
            <!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->                            
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; <span style="color:#F00"></span><?php echo $modulename; ?> </legend>
                 
                   <?php //echo $bid_id; ?>
                
               <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Bilty No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    	
                    <select id="bid_id" name="bid_id" class="formcent select2-me" style="width:220px;" onChange="getdetail();">
                        <option value=""> - Select - </option>
                        <?php 
				
				// 		$sql_fdest = mysqli_query($connection,"select bid_id,bilty_no from returnbidding_entry where compid='$compid' and is_bilty=0 && sessionid='$sessionid'");
							$sql_fdest = mysqli_query($connection,"select bid_id,bilty_no from returnbidding_entry where compid='$compid' and is_bilty=1 && sessionid='$sessionid'");
						
						
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['bid_id']; ?>"><?php echo $row_fdest['bilty_no']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('bid_id').value = '<?php echo $bid_id; ?>';</script>                                  
                </div>
               </div>
               
               <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Truck No </div>
                    <div class="text">
                     <input type="text" class="formcent" id="truckno" value="<?php echo $truckno; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;" readonly autocomplete="off"  >
                </div>
                </div>
               
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> From Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $fromplace; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Ship To Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $toplace; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                
                
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Owner Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $ownername; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;" readonly  autocomplete="off"  >
                </div>
                </div>
         
                
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Item Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $itemname; ?>"  style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
               
               <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> Weight </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $totalweight; ?>" readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
                
               
               <!--<div class="innerdiv">-->
               <!--     <div> Final Rate(M.T.) <span class="err" style="color:#F00;">*</span></div>-->
               <!--     <div class="text">-->
               <!--     <input type="text" class="formcent" name="own_rate" id="own_rate" value="<?php echo $own_rate; ?>" onChange="get_net_total();" style="border: 1px solid #368ee0;background-color:#cacecb;"  readonly autocomplete="off"  >-->
               <!--     </div>-->
               <!-- </div>-->
            
             
            
               
                
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> <span style="font-weight:bold; color:#00C"> Cash Adv. (Self)</span> </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_cash" id="adv_cash" value="<?php echo $adv_cash; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
            
            
            
               <div class="innerdiv" style="display: flex;align-items: center;">
                    <div> <span style="font-weight:bold; color:#00C"> Cash Adv. Date (Self) </span> </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_date" id="adv_date" value="<?php echo $adv_date; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
            
             <div class="innerdiv" style="display: flex;align-items: center;">
                    <div><span style="font-weight:bold; color:#F00"> Cash Adv. (Consignor) </span> </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_consignor" id="adv_consignor" value="<?php echo $adv_consignor; ?>"    style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                
                
                
                
                  <div class="innerdiv" style="display: flex;align-items: center;">
                    <div><span style="font-weight:bold; color:#F00"> Cash Adv. Date (Consignor) </span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_consignordate" id="adv_consignordate" value="<?php echo $adv_consignordate; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
               <div class="innerdiv" style="display:none;">
                    <div> Advance Diesel </div>
                    <div class="text">
                     <input type="text" class="formcent" name="adv_diesel" id="adv_diesel" value="<?php echo $adv_diesel; ?>" onChange="getbal();"   style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
                 <div class="innerdiv" style="display:none;">
                    <div> Diesel(ltr.) </div>
                    <div class="text">
                     <input type="text" class="formcent" name="adv_dieselltr" id="adv_dieselltr" value="<?php echo $adv_dieselltr; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv" style="display: flex;align-items: center;">
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
                 
             
                
             <?php     // if(isset($_GET['bid_id']))
//{      ?>


            
                
                <div class="innerdiv"style="display:none;">
                    <div> Other Adv. Cash </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_other" id="adv_other" value="<?php echo $adv_other; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                
                
                
                 <div class="innerdiv" style="display:none;">
                    <div>Other Adv. Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="otheradv_date" id="otheradv_date" value="<?php echo $otheradv_date; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Remark </div>
                    <div class="text">
                    <input type="text" class="formcent" name="remark" id="remark" value="<?php echo $remark; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
               
                
                
                
                 
                
                
                   
             
                
                  <div class="innerdiv" style="display:none">
                    <div>Third Party Name</div>
                    <div class="text">
                          <select id="thirdid" name="thirdid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select thirdid,third_name from m_third_party order by third_name");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['thirdid']; ?>"><?php echo $row_fdest['third_name']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('thirdid').value = '<?php echo $thirdid; ?>';</script> 
                    
                     
                </div>
                </div>
			<?php 
			
//}
			$truckownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'"); 	
			$owner_type = $cmn->getvalfield($connection,"m_truckowner","owner_type","ownerid='$truckownerid'");
			
			if($owner_type=="self") {
				?>
				<div class="innerdiv" style="display: flex;align-items: center;">
                    <div><span style="color:#FF0000;display:none;"><strong>Uchanti</strong> </span> </div>
                    <div class="text">
                  
					<input type="checkbox"  style="display:none;" class="formcent" name="isuchanti" value="1" <?php if($isuchanti==1) { ?> checked="checked" <?php } ?> ><br>
                    </div>
                </div>
				<?php } ?>
				
				   <div class="innerdiv" style="display:none;">
                    <div>Pay Type <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    	
                    <select id="paytype" name="paytype" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                       
                        <option value="Self">Self</option>
                         <option value="Consignor">Consignor</option>
                      
                    </select>
                    <script>document.getElementById('paytype').value = '<?php echo $paytype; ?>';</script>                                  
                </div>
               </div>
                        
                    <div class="innerdiv" style="display: flex;align-items: center;">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('bid_id'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="border-radius:4px;">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
                    
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                   
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
            <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						
						<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="billty_dispatch_record_return.php" target="_blank">Click Here</a>)</span></h3>
							</div>
								
							<div class="box-content nopadding" style="overflow:scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>LR No.</th>
                                             <th>Bilty No.</th>
											
											
											<th>Bilty Date </th>
                                            <!--<th>Invoice No</th>-->
                                            <th>Truck No.</th>
                                            <th>Destination</th>
                                        	<th>Item</th>
                                            <th>Weight</th>
                                            <th>Adv. Cash <br> (Self)</th>
                                            <th>Adv. Cash <br>(Consignor)</th>
                                   
											<th>Remark</th>
                                            
											<th>Print</th>
                                        	<!-- <th  style="width:200px;">Print Recipt</th> -->
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									 $sel = "select * from returnbidding_entry where isdispatch=1 && sessionid='$sessionid'  and compid='$compid' order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									   $paydone=$row['is_complete'];
										$truckid = $row['truckid'];	
										$itemid = $row['itemid'];	
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
								
									?>
										<tr tabindex="<?php echo $slno; ?>" class="abc">
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['lr_no']);?></td>
                                             <td><?php echo ucfirst($row['bilty_no']);?></td>
                                          
											 <td><?php echo date('d-m-Y',strtotime($row['tokendate']));?></td>
                                            <!--<td><?php echo ucfirst($row['invoiceno']);?></td>-->
                                             <td><?php echo $truckno;?></td>
					                    	<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                            <td><?php echo $itemname;?>  </td> 
                                            <td><?php echo ucfirst($row['totalweight']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_consignor']);?>  
                                            </td>
                                    
                                           <td><?php echo $row['remark'];?></td>

											<!-- <td><a href="pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-primary">Print Bilty</a></td> -->
                                           <td style="display: flex;width: 204px;justify-content: space-around;">
                                           <a href="pdf_paiddispatchreceipt_return.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-sm btn-success">Print Recipt</a> </td>
                                            <!-- <a href="pdf_paiddiselreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-sm btn-success">Diesel Slip</a> </td> -->
                                            <td class='hidden-480'>

                                             <?php 
                                               if($usertype=='admin')
                  {
                    $payUser=1;
                  }
                  else
                  {
                    $payUser=0;                 
                  }
                                
       if($paydone!=0){ 
                if($usertype=='admin'){  ?> 
  <!--<a onClick="editrecord(<?php echo $row['bid_id'];?>);" ><img src="../img/b_edit.png" title="Edit"></a>-->
  <a href= "return_trip_advance.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  ><img src="../img/b_edit.png" title="Edit">
                                         </a>  &nbsp;&nbsp;&nbsp;

                                           <?php } else { echo "Payment Done."; } }
            else { ?>
                <!--<a onClick="editrecord(<?php echo $row['bid_id'];?>);" ><img src="../img/b_edit.png" title="Edit"></a>-->
                <!--                           &nbsp;&nbsp;&nbsp;-->
                                             <a href= "return_trip_advance.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  ><img src="../img/b_edit.png" title="Edit"></a>
              <?php } ?>
                                  
                                           
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
				</div></div>
            
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

function editrecord(bid_id) {
// alert("okk");
  $.ajax({
      type: 'POST',
      url: 'getotp.php',
      data: 'bid_id=' + bid_id,
      dataType: 'html',
      success: function(data){
        //console.log(data);
        //alert(data);
         $('#otpmodel').modal('show');
         $("#otp_bid_id").val(bid_id);
         $("#otp").val(data);
      }
    
      });//ajax close  
}


function matchotp() {

  otp_bid_id = $("#otp_bid_id").val();
  otp = $("#otp").val();

   $.ajax({
      type: 'POST',
      url: 'matchotp.php',
      data: 'otp_bid_id=' + otp_bid_id+'&otp='+otp,
      dataType: 'html',
      success: function(data){
// alert(data);
            if(data==1) 
            {
                location.href="return_trip_advance.php?bid_id="+otp_bid_id;

            }
            else
            {
              alert("Otp didnt match");
            }
        }
    
    });//ajax close  

}

</script>


			
                
		
	</body>

	</html>
