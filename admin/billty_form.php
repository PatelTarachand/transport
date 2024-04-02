<?php 
include("dbconnect.php");
include("../lib/smsinfo.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='billty_form.php';
$modulename = "Recent Added Billty";





if(isset($_GET['source']))
{
	$source = trim(addslashes($_GET['source']));	
}

if(isset($_GET['edit']))
{
	$bilty_id = addslashes(trim($_GET['edit']));
	$row = mysqli_fetch_array(mysqli_query($connection,"select * from bilty_entry where bilty_id = '$bilty_id'"));
	$bilty_id = $row['bilty_id'];
	$billtyno = $row['billtyno'];
	$billtydate = $row['billtydate'];
	$consignorid = $row['consignorid'];
	$consigneeid = $row['consigneeid'];
	$subconsigneeid = $row['subconsigneeid'];
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$shipmentno = $row['shipmentno'];
	$gpno = $row['gpno'];
	$truckid = $row['truckid'];
	$drivername = $row['drivername'];
	$driverlisenceno = $row['driverlisenceno'];
	$truckowner = $row['truckowner'];
	$truckownermobile = $row['truckownermobile'];
	$driver_mobile = $row['driver_mobile'];
	$qty = $row['qty'];
	$itemid = $row['itemid'];
	$wt_mt = $row['wt_mt'];
	$rate_mt = $row['rate_mt'];
	$freight = $row['freight'];
	$description = $row['description'];
	}
else
{
$billtyid = 0;
$isbilled = 0;
$billtydate = date('Y-m-d');
}

$duplicate= "";



if(isset($_GET['edit']))
{
	$success  = strrev(trim(addslashes($_GET['success'])));
	
	$otp = $cmn->getvalfield($connection,"bilty_entry","otp","bilty_id='$bilty_id'");
	if($otp !='')
	{
		if($success !=$otp)
		{	
			echo "<script>location='billty_form.php'</script>";
		}
	}
	else
	{
	echo "<script>location='billty_form.php'</script>";
	}
}





if(isset($_POST['sub']))
{
	$bilty_id = trim(addslashes($_POST['bilty_id']));
	$billtyno = trim(addslashes($_POST['billtyno']));
	$billtydate = $cmn->dateformatusa(trim(addslashes($_POST['billtydate'])));
	$consignorid = trim(addslashes($_POST['consignorid']));
	$consigneeid = trim(addslashes($_POST['consigneeid']));
	$subconsigneeid = trim(addslashes($_POST['subconsigneeid']));
	$placeid = trim(addslashes($_POST['placeid']));
	$destinationid = trim(addslashes($_POST['destinationid']));
	$shipmentno = trim(addslashes($_POST['shipmentno']));
	$gpno = trim(addslashes($_POST['gpno']));
	$description = trim(addslashes($_POST['description']));
	$truckid = trim(addslashes($_POST['truckid']));
	$drivername = trim(addslashes($_POST['drivername']));
	$driverlisenceno = trim(addslashes($_POST['driverlisenceno']));
	$truckowner = trim(addslashes($_POST['truckowner']));
	$truckownermobile = trim(addslashes($_POST['truckownermobile']));
	$driver_mobile = trim(addslashes($_POST['driver_mobile']));
	$qty =  trim(addslashes($_POST['qty']));
	$itemid = trim(addslashes($_POST['itemid']));
	$wt_mt = trim(addslashes($_POST['wt_mt']));
	$rate_mt = trim(addslashes($_POST['rate_mt']));
	$freight = trim(addslashes($_POST['freight']));
	
	if($billtyno !='' && $consignorid !='' && $consigneeid !='' && $placeid !='' && $destinationid !='')
	{
	if($bilty_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from bilty_entry where billtyno='$billtyno' && consignorid='$consignorid' && sessionid='$sessionid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
			
				$count = $cmn->getvalfield($connection,"bilty_entry","count(*)","consignorid='$consignorid' && sessionid='$sessionid' && bilty_id <> '$bilty_id'");				
				if($count==0)
				{
				$billtyno = $cmn->getvalfield($connection,"consignor_prefixsetting","consignor_prefix","consignorid='$consignorid' && sessionid='$sessionid'").$cmn->getcode($connection,"bilty_entry","billtyno","consignorid='$consignorid' && sessionid='$sessionid'");
				}
				else
				{
				$billtyno = $cmn->getcode($connection,"bilty_entry","billtyno","consignorid='$consignorid' && sessionid='$sessionid'");	
				}
 
			
			$sql_insert="insert into bilty_entry set billtyno = '$billtyno', billtydate = '$billtydate',description = '$description',consignorid ='$consignorid',consigneeid = '$consigneeid',qty='$qty',subconsigneeid='$subconsigneeid',placeid='$placeid', destinationid='$destinationid', shipmentno='$shipmentno', gpno='$gpno',truckid='$truckid', drivername='$drivername', driverlisenceno='$driverlisenceno',truckowner='$truckowner',itemid='$itemid', wt_mt='$wt_mt', rate_mt='$rate_mt',freight='$freight',truckownermobile='$truckownermobile',driver_mobile='$driver_mobile', createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]',createdby='$userid'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			
			
			
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='billty_form.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
			 $sql_update = "update  bilty_entry  set billtyno = '$billtyno', billtydate = '$billtydate',description = '$description',consignorid = '$consignorid',consigneeid = '$consigneeid',qty='$qty',subconsigneeid='$subconsigneeid',placeid='$placeid', destinationid='$destinationid', shipmentno='$shipmentno', gpno='$gpno',truckid='$truckid', drivername='$drivername',driverlisenceno='$driverlisenceno',truckowner='$truckowner', itemid='$itemid', wt_mt='$wt_mt', rate_mt='$rate_mt',freight='$freight',truckownermobile='$truckownermobile',driver_mobile='$driver_mobile', lastupdated=now(),ipaddress = '$ipaddress' where bilty_id='$bilty_id'"; 
			 //die;
		mysqli_query($connection,$sql_update);
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
		
		if($source=="bilty_record")
		{
			echo "<script>location='billty_record.php?action=2'</script>";	
		
		}
		else
		{
		echo "<script>location='billty_form.php?action=2'</script>";
		}
	}
	
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
	
<!--- short cut form place --->
<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place </strong></td></tr>
  <tr><td>&nbsp;<b>District:</b> </td></tr>
  <tr>
  	<td>
  		<select name="districtid" id="districtid" class="select2-me" style="width:202px;">
        <option value="">--select--</option>
        <?php 
		$sql_sc = "select * from m_district"; 
		$res_sc = mysqli_query($connection,$sql_sc);
		while($row_sc = mysqli_fetch_array($res_sc))
		{ ?>
        	<option value="<?php echo $row_sc['districtid']; ?>"><?php echo $row_sc['distname']; ?></option>
		<?php
        }
		?>
        </select>
  	</td>
  </tr>
  <tr><td>&nbsp;<b>Placename:</b> </td></tr>
  <tr><td><input type="text" name="placename" id="placename" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_place('districtid','placename');"/></td></tr>
</table>
</div>
<!------end here ---->
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
<!--- short cut form consignee --->
<div class="messagepop pop" id="div_consigneeid">
<img src="b_drop.png" class="close" onClick="$('#div_consigneeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Consignee</strong></td></tr>
  <tr><td>&nbsp;Consignee Name: </td></tr>
  <tr><td><input type="text" name="consigneename" id="consigneename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_consigneename();"/></td></tr>
</table>
</div>
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
                                        
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Billty</legend>
                 
                   
                <div class="innerdiv">
                    <div>Consignor <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <?php echo $cmn->create_combo($connection,"m_consignor","consignorid","consignorname","1=1","formcent select2-me") ?>
                    <script>document.getElementById('consignorid').value = '<?php echo $consignorid; ?>' ;</script>                    
                </div>
               </div>
            
                 
                <div class="innerdiv">
                    <div>Bilty No <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="billtyno" id="billtyno" value="<?php echo $billtyno; ?>" required style="border: 1px solid #368ee0" readonly autocomplete="off"  >
                    </div>
                </div>
            
            
               <div class="innerdiv">
                    <div>Bilty Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input class="formcent" type="text" name="billtydate" id="billtydate"  value="<?php echo $cmn->dateformatindia($billtydate); ?>"  data-date="true" required style="border: 1px solid #368ee0" autocomplete="off" >
                </div>
                </div>
              
             <div class="innerdiv">
                    <div>Consignee&nbsp; <span class="err" style="color:#F00;">*</span><img src="add.png" id="shortcut_consigneeid"><a href="#" id="add_new" data-form="short_consignee" tabindex="49"></a></div>
                    <div class="text">
                            <?php echo $cmn->create_combo($connection,"m_consignee","consigneeid","consigneename","1=1","formcent select2-me"); ?>
                            <script>document.getElementById('consigneeid').value = '<?php echo $consigneeid; ?>';</script>
                    </div>
                </div>
              
              
               <div class="innerdiv">
                <div>From Place <span class="err" style="color:#F00;">*</span> &nbsp;</div>
                <div class="text">
                <?php echo $cmn->create_combo($connection,"m_place","placeid","placename","1=1","formcent"); ?>
                <script>document.getElementById('placeid').value = '<?php echo $placeid; ?>';</script>
                </div>
                </div>
                        
                <div class="innerdiv">
                    <div>To Place <span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
                        <select id="destinationid" name="destinationid" class="formcent select2-me" style="width:220px;" onChange="getrate();">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from m_place");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['placeid']; ?>"><?php echo $row_fdest['placename']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('destinationid').value = '<?php echo $destinationid; ?>';</script>
                    </div>
                </div>
                
                
                 <div class="innerdiv">
                    <div>Sub Consignee&nbsp; </div>
                    <div class="text">                    
                    <select id="subconsigneeid" name="subconsigneeid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select consigneeid,consigneename from m_consignee");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['consigneeid']; ?>"><?php echo $row_fdest['consigneename']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('subconsigneeid').value = '<?php echo $subconsigneeid; ?>';</script>
                    </div>
                </div>
            
                <div class="innerdiv">
                	<div>Shipment No <span class="err" style="color:#F00;">*</span> </div>
                	<div class="text">
                    <input type="text" class="formcent" name="shipmentno" id="shipmentno" value="<?php echo $shipmentno; ?>" style="border: 1px solid #368ee0" autocomplete="off" maxlength="12" >
                </div>
                </div>
             
                
           
            	<div class="innerdiv">
                	<div>GP No <span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
            		<input type="text" class="formcent" name="gpno" id="gpno" value="<?php echo $gpno; ?>" style="border: 1px solid #368ee0" autocomplete="off" maxlength="12" >
                </div>
                </div>
                
                  <div class="innerdiv">
                	<div>Truck No <span class="err" style="color:#F00;">*</span> &nbsp;<img src="add.png" id="shortcut_truck"><a href="#" id="add_new" data-form="short_truck" tabindex="49"></a></div>
                    <div class="text">
            		<?php echo $cmn->create_combo($connection,"m_truck","truckid","truckno","1=1","formcent select2-me"); ?>
                     <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                  </div>
                </div>
                
                 <div class="innerdiv">
                	<div>Truck Owner Name <span class="err" style="color:#F00;">*</span> </div>
            		<div class="text">
                    <input type="text" class="formcent" name="truckowner" id="truckowner" value="<?php echo $truckowner;?>" style="border: 1px solid #368ee0" autocomplete="off" readonly >
                </div>
                </div>
        	
        		<div class="innerdiv">
                	<div>Mobile No</div>
            		<div class="text">
                    <input class="formcent" type="text" name="truckownermobile" id="truckownermobile" value="<?php echo $truckownermobile;?>" style="border: 1px solid #368ee0" autocomplete="off" >
                </div>
                </div>
            
            	              
                    <div class="innerdiv">
                    <div>Driver Name<span class="err" style="color:#F00;">*</span> &nbsp;<img src="add.png" id="shortcut_truck"><a href="#" id="add_new" data-form="short_truck" tabindex="49"></a></div>
                    <div class="text">
            		<?php echo $cmn->create_combo($connection,"m_employee","empid","empname","1=1","formcent select2-me"); ?>
                     <script>document.getElementById('empid').value = '<?php echo $empid; ?>';</script>
                  </div>
					
                </div>
                    <div class="innerdiv">
                	<div>Driver Lisence no</div>
                    <div class="text">
            		<input type="text" class="formcent" name="driverlisenceno" id="driverlisenceno"  value="<?php echo $driverlisenceno; ?>" style="border: 1px solid #368ee0" autocomplete="off" >
                </div>
                </div>
                          
           
             
                    <div class="innerdiv">
                    <div>Driver Mobile</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="driver_mobile" id="driver_mobile" value="<?php echo $driver_mobile;?>" style="border: 1px solid #368ee0" autocomplete="off" maxlength="10" >                    </div>
                    </div>
                    
                     <div class="innerdiv">
                    <div>Item <span style="color:#F00;">*</span></div>
                    <div class="text">
                    <?php echo $cmn->create_combo($connection,"inv_m_item","itemid","itemname","1=1","formcent select2-me"); ?>
                     <script>document.getElementById('itemid').value = '<?php echo $itemid; ?>';</script>
                     </div>
                    </div>
                    
                     <div class="innerdiv">
                    <div>Qty (Bags)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="qty" id="qty" value="<?php echo $qty;?>" style="border: 1px solid #368ee0" autocomplete="off" >                    </div>
                    </div>
                    
                     <div class="innerdiv">
                    <div>Weight/(M.T.)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="wt_mt" id="wt_mt" value="<?php echo $wt_mt;?>" style="border: 1px solid #368ee0" autocomplete="off" >                    </div>
                    </div>
                    
                     <div class="innerdiv">
                    <div>Rate/(M.T.)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="rate_mt" id="rate_mt" value="<?php echo $rate_mt;?>" style="border: 1px solid #368ee0" autocomplete="off" onChange="saverate();" >                    </div>
                    </div>
                    
                     <div class="innerdiv">
                    <div>Freight</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="freight" id="freight" value="<?php echo $freight;?>" style="border: 1px solid #368ee0" autocomplete="off" >     </div>
                    </div>
                    
                    <div class="innerdiv">
                    <div>Description</div>
                    <div class="text">
                   <input type="text" name="description" value="<?php echo $description; ?>" id="description"  class="formarea control_dynamic" style="border: 1px solid #368ee0" autocomplete="off" >
                                                        </div>
                    </div>
                     	
              
                        <div class="innerdiv">
                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('billtyno,billtydate,consignorid,consigneeid,placeid,destinationid,shipmentno,gpno,truckid,truckowner,itemid'); " >
                    <a href="billty_form.php" class="btn btn-danger">Cancel</a>
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
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="billty_record.php" target="_blank">Click Here</a>)</span></h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Bilty No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>
                                            <th>Truck No</th>
                                            <th>Driver</th>
                                            <th>Destination</th>
                                            <th>Truck Owner</th>
                                        	  <th>Print Bilty</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										$cond="where createdby='$userid' ";	
									}
									
									$sel = "select * from bilty_entry $cond && sessionid='$sessionid' order by bilty_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['billtyno']);?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row[truckid]'"));?></td>
                                            <td><?php echo ucfirst($row['drivername']);?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                            <td><?php echo ucfirst($row['truckowner']);?></td>
                                           <td><a href= "pdf_bill_invoice.php?bilty_id=<?php echo $row['bilty_id'];?>" class="btn btn-success" target="_blank" >Print Bilty</a></td>
                                           
                                           
                                            <td class='hidden-480'>
                                           <a href= "billty_form.php?bilty_id=<?php echo ucfirst($row['bilty_id']);?>&sms=true"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[bilty_id]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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

function ajax_save_consigneename()
{
	var consigneename = document.getElementById('consigneename').value;	
	if(consigneename == "" )
	{
		alert('Fill form properly');
		document.getElementById("consigneename").focus();
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
				document.getElementById("consigneeid").innerHTML = xmlhttp.responseText;
				document.getElementById("consigneename").value = "";	
				//$('#itemid').select2('val', '');
				$("#div_consigneeid").hide(1000);
				document.getElementById("consigneeid").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savconsignee.php?consigneename="+consigneename,true);
	xmlhttp.send();
	
}
function ajax_save_shortcut_place(districtid,placename)
{
	var districtid = document.getElementById(districtid).value;
	var placename = document.getElementById(placename).value;
	
	if(districtid == "" || placename == "")
	{
		alert('Fill form properly');
		document.getElementById(districtid).focus();
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
				document.getElementById("placeid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("districtid").value = "";
				document.getElementById("placename").value = "";
				$("#div_placeid").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_saveplace.php?districtid="+districtid+"&placename="+placename,true);
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
//below code for date mask
jQuery(function($){
   $("#billtydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

$(document).ready(function(){
$('#consignorid').change(function(){										  	
var consignorid = $('#consignorid').val();

$.ajax({
		type: 'POST',
		url: 'getbillno.php',
		data: 'consignorid=' + consignorid,
		dataType: 'html',
		success: function(data){
			alert(data);
			var arr = data.split('|');
			$('#billtyno').val(arr[0]);
			$('#placeid').val(arr[1]);	
			getrate();
		}					
});//ajax close	
						
					  });
	   });


$(document).ready(function(){
$('#truckid').change(function(){										  	
var truckid = $('#truckid').val();

$.ajax({
		type: 'POST',
		url: 'gettruckdetail.php',
		data: 'truckid=' + truckid,
		dataType: 'html',
		success: function(data){
			//$('#billtyno').val(data);
			var arr = data.split('|');
			
			$('#truckowner').val(arr[0]);
			$('#truckownermobile').val(arr[1]);
			//$('#owneraddress').val(arr[2]);
		}					
});//ajax close	
						
					  });
	   });
	   
	   
	   

$(document).ready(function(){
$('#empid').change(function(){										  	
var empid = $('#empid').val();

$.ajax({
		type: 'POST',
		url: 'getemployee.php',
		data: 'empid=' + empid,
		dataType: 'html',
		success: function(data){
			//$('#billtyno').val(data);
			
			var arr = data.split('|');
			
			$('#driverlisenceno').val(arr[0]);
		
			$('#driver_mobile').val(arr[1]);
			
			//$('#owneraddress').val(arr[2]);
		}					
});//ajax close	
						
					  });
	   });

function getrate()
{
	var consignorid = $('#consignorid').val();
	var destinationid = $('#destinationid').val();
	
	if(destinationid !='' && consignorid !='')
	{
		$.ajax({
		type: 'POST',
		url: 'getconsignorrate.php',
		data: 'consignorid='+consignorid+'&destinationid='+destinationid,
		dataType: 'html',
		success: function(data){
			document.getElementById('rate_mt').value= data;
		}					
});//ajax close	
		
	}
		
}

function saverate()
{
	var consignorid = $('#consignorid').val();
	var destinationid = $('#destinationid').val();
	var rate_mt = $('#rate_mt').val();
	var billtydate = $('#billtydate').val();
	
	if(consignorid=='')
	{
		alert("Please Select Consignor");
		$('#rate_mt').val('');
		return false;
	}
	
	if(destinationid=='')
	{
		alert("Please Select To Place");
		$('#rate_mt').val('');
		return false;
	}
	
	if(rate_mt !='')
	{
			$.ajax({
		type: 'POST',
		url: 'saveratesett.php',
		data: 'consignorid='+consignorid+'&destinationid='+destinationid+'&rate_mt='+rate_mt+'&billtydate='+billtydate,
		dataType: 'html',
		success: function(data){
			//alert(data);
		}					
});//ajax close	
	}	
}

</script>			
                
		
	</body>

	</html>
