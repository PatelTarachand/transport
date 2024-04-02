<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_dispatch.php';
$modulename = "Recent Added Billty";

if($usertype=='admin')
	{
	$crit=" where newrate=0";
	}
	else
	{
	$crit=" where newrate=0 && createdby='$userid' && sessionid='$sessionid' ";	
	}


if(isset($_GET['bilty_id']))
{
	$bilty_id = trim(addslashes($_GET['bilty_id']));
	$crit=" where bilty_id='$bilty_id'";
	$sql = mysqli_query($connection,"select wt_mt,rate_mt,newrate,adv_date,adv_cash,adv_diesel,adv_cheque,cheque_no,consignorid,consigneeid,
					   placeid,destinationid,itemid,bankid,truckid,truckowner,advchequedate,adv_dieselltr,petrol_pump_type,ppsuplier_id,adv_other,adv_consignor from bilty_entry where bilty_id='$bilty_id'");
	$row=mysqli_fetch_assoc($sql);	
	$wt_mt = $row['wt_mt'];
	$rate_mt = $row['rate_mt'];	
	$newrate = $row['newrate'];
	$adv_date = $row['adv_date'];
	$adv_cash = $row['adv_cash'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other =  $row['adv_other'];
	$adv_consignor =  $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
	$consignorid = $row['consignorid'];
	$consigneeid = $row['consigneeid'];
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
	$truckid = $row['truckid'];
	$truckowner = $row['truckowner'];
	$advchequedate = $row['advchequedate'];
	$adv_dieselltr = $row['adv_dieselltr']; 
	$ppsuplier_id = $row['ppsuplier_id']; 
	$petrol_pump_type = $row['petrol_pump_type']; 
	
	$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
	$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
	$fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
	$toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	
	$charrate = $rate_mt - $newrate;
	$netamount = $newrate * $wt_mt;
	
	$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other -$adv_consignor;
	
	if($newrate==0){ $newrate=''; }
	if($adv_cash==0){ $adv_cash=''; }
	if($adv_diesel==0){ $adv_diesel=''; }
	if($adv_cheque==0){ $adv_cheque=''; }
	
	if($adv_date=='0000-00-00')
	{
			$adv_date = date('Y-m-d');
	}
	
}



if(isset($_POST['sub']))
{
	$bilty_id = trim(addslashes($_POST['bilty_id']));
	$newrate = trim(addslashes($_POST['newrate']));
	$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));
	$adv_cash = trim(addslashes($_POST['adv_cash']));
	$adv_diesel = trim(addslashes($_POST['adv_diesel']));
	$adv_cheque = trim(addslashes($_POST['adv_cheque']));
	$cheque_no = trim(addslashes($_POST['cheque_no']));
	$bankid = trim(addslashes($_POST['bankid']));
	$adv_dieselltr = trim(addslashes($_POST['adv_dieselltr'])); 
	$ppsuplier_id = trim(addslashes($_POST['ppsuplier_id']));
	$petrol_pump_type = trim(addslashes($_POST['petrol_pump_type']));
	$advchequedate = $cmn->dateformatusa(trim(addslashes($_POST['advchequedate'])));
	$adv_other = trim(addslashes($_POST['adv_other'])); 
	$dispatch_date=date('Y-m-d');
	if($adv_date !='' && $newrate !='')
	{
		$paid_no = 'P1'.$bilty_id;
		$sql_update = "update  bilty_entry  set newrate = '$newrate', adv_date = '$adv_date',paid_no = '$paid_no',adv_cash = '$adv_cash',adv_diesel = '$adv_diesel',bankid='$bankid',advchequedate='$advchequedate',adv_cheque='$adv_cheque',ppsuplier_id='$ppsuplier_id',adv_other='$adv_other',
		petrol_pump_type='$petrol_pump_type',cheque_no='$cheque_no',dispatch_date='$dispatch_date',adv_dieselltr='$adv_dieselltr',
		lastupdated=now(),ipaddress = '$ipaddress' where bilty_id='$bilty_id'"; 
			mysqli_query($connection,$sql_update);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='bilty_dispatch.php?action=2'</script>";
	}
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
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">
                    
    				<fieldset style="margin-top:45px; margin-left:45px;" >
                                        
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Billty Advance</legend>
                 
                   
                <div class="innerdiv">
                    <div> Bilty No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    		
                    <select id="bilty_id" name="bilty_id" class="formcent select2-me" style="width:220px;" onChange="window.location.href='?bilty_id='+this.value">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select bilty_id,billtyno from bilty_entry $crit");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['bilty_id']; ?>"><?php echo $row_fdest['billtyno']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('bilty_id').value = '<?php echo $bilty_id; ?>';</script>                                  
                </div>
               </div>
               
               <div class="innerdiv">
                    <div> Consignor Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $consignorname; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Consignee Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $consigneename; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> From Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $fromplace; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> To Place </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $toplace; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Truck No </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $truckno; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Owner Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $truckowner; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
         
                
                <div class="innerdiv">
                    <div> Item Name </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $itemname; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
               <div class="innerdiv">
                    <div> Weight </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $wt_mt; ?>" required readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
                <div class="innerdiv">
                    <div>  Company Rate </div>
                    <div class="text">
                     <input type="text" class="formcent" id="comprate" value="<?php echo $rate_mt; ?>" required readonly style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off"  >
                </div>
                </div>
               
               <div class="innerdiv">
                    <div> Final Rate(M.T.) <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="newrate" id="newrate" value="<?php echo $newrate; ?>" onChange="get_net_total();" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
             <div class="innerdiv">
                    <div> Char  </div>
                    <div class="text">
                     <input type="text" class="formcent" value="<?php echo $charrate; ?>" id="charrate" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
            
               <div class="innerdiv">
                    <div> Net Amount <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" class="formcent" name="netamount" id="netamount" value="<?php echo $netamount; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly >
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
                    <div>Petrol Pump</div>
                    <div class="text">
                     			<select name="petrol_pump_type" id="petrol_pump_type" onChange="getppsupplierid();">
                                		<option value="">--None--</option>
                                		<option value="self">Self</option>
                                        <option value="other">Other</option>
                                </select>
                            <script> document.getElementById('petrol_pump_type').value='<?php echo $petrol_pump_type; ?>'; </script>    
        
                </div>
                </div>
                
                 <div class="innerdiv">
                    <div> Other Advance Cash </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_other" id="adv_other" value="<?php echo $adv_other; ?>"  onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
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
                     <input type="text" class="formcent" name="advchequedate" id="advchequedate" value="<?php echo $cmn->dateformatindia($advchequedate); ?>"  data-date="true"  style="border: 1px solid #368ee0"  autocomplete="off"  >
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
                    <div>Bal Amount</div>
                    <div class="text">
                     <input type="text" class="formcent" id="bal_amount" value="<?php echo $balamt; ?>" required style="border: 1px solid #368ee0;background-color:#cacecb;"  autocomplete="off" readonly  >
                </div>
                </div>
            
                 
                <div class="innerdiv">
                    <div>Adv. Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_date" id="adv_date" value="<?php echo $cmn->dateformatindia($adv_date); ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('bilty_id,newrate'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
                     <input type="hidden" name="ppsuplier_id" id="ppsuplier_id" value="<?php echo $ppsuplier_id; ?>">
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                    <input  type="hidden" name="wt_mt" id="wt_mt" value="<?php echo $wt_mt; ?>" >
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="bilty_dispatchrecord.php" target="_blank">Click Here</a>)</span></h3>
							</div>
							<div class="box-content nopadding">
								 <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                     <?php
									$slno=1;									
								if($usertype=='admin')
								{
								$crit="";
								}
								else
								{
								$crit=" && createdby='$userid' && sessionid='$sessionid' ";	
								}	
									$totaladvcash = 0;
									$totaladv_diesel = 0;
									$totaladv_cheque = 0;
									$totaladv_other=0;
									$sel1 = "select * from bilty_entry where (newrate !='0' || dispatch_date !='0000-00-00') $crit and compid='$compid' order by bilty_id desc";
							$res1 = mysqli_query($connection,$sel1);
									while($row1 = mysqli_fetch_array($res1))
									{
										
										$totaladvcash += $row1['adv_cash'];
										$totaladv_diesel += $row1['adv_diesel'];
										$totaladv_cheque += $row1['adv_cheque'];
										$totaladv_other += $row1['adv_other'];
									}
										?>
                                       
                                       
                                    <tr>                                          
                                            <th colspan="5"></th>
                                            <th><span style="color:#F00"><strong>Total</strong></span></th>
                                            <th><span style="color:#F00"><strong><?php echo number_format($totaladvcash,2);?></strong> </span></th>
                                            <th><span style="color:#F00"><strong><?php echo number_format($totaladv_diesel,2);?></strong> </span></th>
                                            <th><span style="color:#F00"><strong><?php echo number_format($totaladv_other,2);?></strong> </span></th>
                                            <th colspan="4"><span style="color:#F00"><strong><?php echo number_format($totaladv_cheque,2);?></strong> </span></th>
										</tr>
										<tr>
                                            <th>Sno</th>  
                                            <th>Bilty No.</th>
                                             <th>Truck No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>
                                            <th>Advance Cash</th>
                                            <th>Advance Diesel</th>
                                            <th>Other Advance </th>
                                            <th>Advance Cheque</th>
                                            <th>Truck Owner</th>
                                        	 <th>Print Recipt</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from bilty_entry where newrate !='0' || dispatch_date !='0000-00-00' order by bilty_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['billtyno']);?></td>
                                             <td><?php echo $truckno;?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?> <span style="color:#FFF;"><?php echo $row['drivername']; ?></span> </td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?> <span style="color:#FFF;"><?php echo $truckno; ?></span></td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_diesel']);?></td>
                                            <td><?php echo ucfirst($row['adv_other']);?></td>
                                            <td><?php echo ucfirst($row['adv_cheque']);?></td>
                                            <td><?php echo ucfirst($row['truckowner']);?></td>
                                              <td>
                                           <a href="pdf_paiddispatchreceipt.php?bilty_id=<?php echo $row['bilty_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                                           
                                           </td>
                                                                                   
                                            <td class='hidden-480'>
                                           <a href= "?bilty_id=<?php echo ucfirst($row['bilty_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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


function get_net_total()
{
	var wt_mt = parseFloat(document.getElementById('wt_mt').value);
	var newrate = parseFloat(document.getElementById('newrate').value);	
	var comprate = parseFloat(document.getElementById('comprate').value);	
	if(isNaN(wt_mt))
	{
		wt_mt = 0;	
	}
	
	if(isNaN(newrate))
	{
		newrate = 0;	
	}
	
	if(isNaN(comprate))
	{
		comprate = 0;	
	}
	
	var nettotal = wt_mt * newrate;
	var charrate = comprate - newrate;
	document.getElementById('charrate').value = charrate.toFixed(2);
	document.getElementById('netamount').value = nettotal.toFixed(2);
	
	getbal();
}

function getbal()
{
	var netamount = parseFloat(document.getElementById('netamount').value);
	var adv_cash = parseFloat(document.getElementById('adv_cash').value);
	var adv_diesel = parseFloat(document.getElementById('adv_diesel').value);
	var adv_cheque = parseFloat(document.getElementById('adv_cheque').value);	
	var adv_other = parseFloat(document.getElementById('adv_other').value);	
	if(isNaN(netamount))
	{
		netamount = 0;	
	}
	if(isNaN(adv_cash))
	{
		adv_cash = 0;	
	}
	if(isNaN(adv_diesel))
	{
		adv_diesel = 0;	
	}
	if(isNaN(adv_cheque))
	{
		adv_cheque = 0;	
	}	
	if(isNaN(adv_other)) { adv_other=0; }
	
	var balamt = netamount - adv_cash - adv_diesel - adv_cheque - adv_other;
	//alert(balamt);
	document.getElementById('bal_amount').value = balamt;
}

jQuery(function($){
   $("#adv_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#advchequedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

function getppsupplierid()
{
	var type = document.getElementById('petrol_pump_type').value;
	//alert(type);
	$.ajax({
		  type: 'POST',
		  url: 'getppsupplierid.php',
		  data: 'type=' + type,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			  
					document.getElementById('ppsuplier_id').value=data;
			}
		  });//ajax close
}

</script>			
                
		
	</body>

	</html>
