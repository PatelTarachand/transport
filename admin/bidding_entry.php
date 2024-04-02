<?php  
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bidding_entry.php';
$modulename = "Recent Added Bidding";


if(isset($_GET['source']))
{
	$source = trim(addslashes($_GET['source']));	
}

if(isset($_GET['edit']))
{
	$bid_id = addslashes(trim($_GET['edit']));
	$row = mysqli_fetch_array(mysqli_query($connection,"select * from bidding_entry where bid_id = '$bid_id'"));
	$bid_id = $row['bid_id'];
	$di_no = $row['di_no'];
	$tokendate = date('d-m-Y',strtotime($row['bilty_date']));
	$consignorid = $row['consignorid'];
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$sessionid = $row['sessionid'];
	$itemid = $row['itemid'];
	$comp_rate = $row['comp_rate'];
	$own_rate = $row['own_rate'];
	$totalweight = $row['totalweight'];
	$remark = $row['remark'];
	$brand_id=$row['brand_id'];
	$order_type=$row['order_type'];
	$order_no=$row['order_no'];
	$consigneeid = $row['consigneeid'];
	
	
	}
else
{
$bid_id = 0;
$di_no='';
$placeid ='624';
$destinationid='';
$itemid='';
$comp_rate='';
$own_rate='';
$totalweight='';
$remark='';
$consignorid='4';
$isbilled = 0;
$brand_id='';
$order_type='';
$order_no='';
$consigneeid='';
$tokendate = date('d-m-Y');
}

$duplicate= "";







if(isset($_POST['sub']))
{

	//print_r($_POST); die;
	$bid_id = trim(addslashes($_POST['bid_id']));
	$di_no = trim(addslashes($_POST['di_no']));
		$tokendate = $cmn->dateformatusa($_POST['tokendate']);
//	$tokendate =date('d-m-Y',strtotime($_POST['tokendate'])); $cmn->dateformatindia(trim(addslashes($_POST['tokendate'])));
	$consignorid = trim(addslashes($_POST['consignorid']));
	$placeid = trim(addslashes($_POST['placeid']));
	$destinationid = trim(addslashes($_POST['destinationid']));

	$itemid = trim(addslashes($_POST['itemid']));
	$comp_rate = trim(addslashes($_POST['comp_rate']));
	$own_rate = trim(addslashes($_POST['own_rate']));
	$totalweight = trim(addslashes($_POST['totalweight']));
  
    $noofqty = $totalweight * 20; 
	
	$remark = trim(addslashes($_POST['remark']));
	$brand_id= trim(addslashes($_POST['brand_id']));
	$newdate = date('Y-m-d H:i:s');
	$order_type= trim(addslashes($_POST['order_type']));
	$order_no= trim(addslashes($_POST['order_no']));
	$consigneeid = trim(addslashes($_POST['consigneeid']));
	
  if($sessionid=='') { $sessionid=4; }

	if($bid_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from bidding_entry where di_no='$di_no'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
			$sql_insert="insert into bidding_entry set di_no = '$di_no',bilty_date = '$tokendate',tokendate='$tokendate',
			consignorid ='$consignorid',placeid='$placeid',order_type='$order_type',
			order_no='$order_no',consigneeid='$consigneeid',destinationid = '$destinationid',
			itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',
			 remark='$remark',brand_id='$brand_id',noofqty='$noofqty',createdate='$newdate',
			 ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
   
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
	
			echo "<script>location='bidding_entry.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
	  
					 $sql_update = "update bidding_entry set di_no='$di_no',bilty_date= '$tokendate',tokendate='$tokendate',consignorid='$consignorid',placeid='$placeid',order_type='$order_type',
					 order_no='$order_no',destinationid ='$destinationid',itemid='$itemid', 
					 comp_rate='$comp_rate',own_rate='$own_rate',consigneeid='$consigneeid',
					 totalweight='$totalweight', remark='$remark',brand_id='$brand_id',
					 noofqty='$noofqty',createdate='$newdate',compid = '$compid',ipaddress = '$ipaddress', 
					 lastupdate=now(),ipaddress = '$ipaddress' where bid_id='$bid_id'"; 
			 //die;
		mysqli_query($connection,$sql_update);
		//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
		echo "<script>location='bidding_entry.php?action=2'</script>";
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
	
	$(document).ready(function(){
	$("#short_di_no").click(function(){
		$("#div_di_no").toggle(1000);
	});
	});
	
	$(function() {
   
	 $('#tokendate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
  });

</script>
</head>

<body data-layout-topbar="fixed">
    
    
    
    	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
    	 
    	 
    	 

<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place </strong></td></tr>
  <tr><td>&nbsp;<b>Placename:</b> </td></tr>
  <tr><td><input type="text" name="placename" id="placename" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_place('placename');"/></td></tr>
</table>
</div>


<div class="messagepop pop" id="div_consigneeid">
<img src="b_drop.png" class="close" onClick="$('#div_consigneeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Consignee</strong></td></tr>
  <tr><td>&nbsp;Consignee Name: </td></tr>
  <tr><td><input type="text" name="consigneename" id="consigneename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_consigneename();"/></td></tr>
</table>
</div>
	

	 
	 
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
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Bidding <h4 style="color:#FF0000;"> <?php echo $duplicate; ?></h4></legend>
                 
                   
                <div class="innerdiv">
                    <div>DI No. <span class="err" style="color:#F00;">*</span></div>
                   <div class="text">
                    <input type="text" class="formcent" name="di_no" id="di_no" value="<?php echo $di_no; ?>" required style="border: 1px solid #368ee0" autocomplete="off" onChange="checkLength(this);" pattern=".{10,10}" maxlength="10" >
                    </div>
               </div>
                 
                <div class="innerdiv">
                    <div>DI Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="tokendate" id="tokendate" value="<?php echo 	$tokendate ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
               <div class="innerdiv">
                    <div>Consignor <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <?php echo $cmn->create_combo($connection,"m_consignor","consignorid","consignorname","1=1","formcent select2-me") ?>
                    <script>document.getElementById('consignorid').value = '<?php echo $consignorid; ?>' ;</script>                    
                </div>
                </div>
           
                <br>
                <br>
				
				
				<div class="innerdiv">
                    <div>Consignee <span class="err" style="color:#F00;">*</span><img src="add.png" id="shortcut_consigneeid"><a href="#" id="add_new" data-form="short_consignee" tabindex="49"></a></div>
                    <div class="text">
                    <?php echo $cmn->create_combo($connection,"m_consignee","consigneeid","consigneename","1=1","formcent select2-me") ?>
                    <script>document.getElementById('consigneeid').value = '<?php echo $consigneeid; ?>' ;</script>                    
                </div>
                </div>


            <div class="innerdiv">
                <div>From Place <span class="err" style="color:#F00;">*</span> &nbsp;</div>
                <div class="text">
                <?php echo $cmn->create_combo($connection,"m_place","placeid","placename","1=1"," input-large"); ?>
                <script>document.getElementById('placeid').value = '<?php echo $placeid; ?>';</script>
                </div>
                   </div>
              <div class="innerdiv">
                    <div>Ship To City <span class="err" style="color:#F00;">*</span> <img src="add.png" id="short_place"><a href="#" id="add_new" data-form="div_placeid" tabindex="49"></a> </div>
                    <div class="text">
                        <select id="destinationid" name="destinationid" class="select2-me input-large" style="width:220px;" onChange="getrate();">
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
                	<div>Item<span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
            		<?php echo $cmn->create_combo($connection,"inv_m_item","itemid","itemname","1=1","select2-me input-large"); ?>
                <script>document.getElementById('itemid').value = '<?php echo $itemid; ?>';</script>
                </div>
                </div>
                
                   <div class="innerdiv">
                    <div>Company Rate/(M.T.)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="comp_rate" id="comp_rate" value="<?php echo $comp_rate;?>" style="border: 1px solid #368ee0" autocomplete="off" >                 
                    </div>
					</div>
                
                 <div class="innerdiv">
                    <div>Own Rate/(M.T.)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="own_rate" id="own_rate" value="<?php echo $own_rate;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
					
        	
        		 <div class="innerdiv">
                    <div>Total Weight/(M.T.)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="totalweight" id="totalweight" value="<?php echo $totalweight;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
                    
                    
                    
                    
					
            
            	              
                    
        		 <div class="innerdiv">
                  <div>Brand</div>
                    <div class="text">
                     
                      <select id="brand_id" name="brand_id" class="input-large" style="width:220px;" onChange="getrate();">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from brand_master");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['brand_id']; ?>"><?php echo $row_fdest['brand_name']; ?></option>
                        <?php
                        } ?>
                        </select>
                     
                    <script>document.getElementById('brand_id').value = '<?php echo $brand_id; ?>' ;</script>   
                    
                    
                        
                    </div>
                    </div>
                    
                    
                    <div class="innerdiv">
                    <div>Order No.</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="order_no" id="order_no" value="<?php echo $order_no; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
                    
                    <div class="innerdiv">
                    <div>Order Type</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="order_type" id="order_type" value="<?php echo $order_type; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
                    
                    
                    
                  <div class="innerdiv">
                    <div>Remark</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="remark" id="remark" value="<?php echo $remark; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
					
					<div class="innerdiv">
                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('di_no,tokendate,consignorid,placeid,destinationid,itemid'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                  </div>
					
                   
    				</fieldset>
    		        <input type="hidden" name="bid_id" id="bid_id" data-key="primary" value="<?php echo $bid_id; ?>">
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
                                            <th>Di no.</th>
                                        	<th>Consignee</th>
                                            <th>Session </th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                            <th>Remark</th>
                                             <!--<th>Print</th>-->
                                        	 <th>Action</th>
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
										//$cond="where createdby='$userid' ";
										$cond="where 1=1 ";	
									}
									
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' and compid='$compid' order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_session","session_name","sessionid = '$row[sessionid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
											<td><?php echo ucfirst($row['remark']);?></td>

                                           <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                           
                                           
                                            <td class='hidden-480'>
                                           <a href= "bidding_entry.php?edit=<?php echo ucfirst($row['bid_id']);?>" ><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                          <?php if($usertype=='admin'){ ?>                     
                                           <a onClick="funDel('<?php echo $row['bid_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
				</div>
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
	 
	 
	 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
	  <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Verification</h4>
        </div>
        <div class="modal-body">
          <p><strong>Code</strong> :  &nbsp; <input type="text" id="otp" > <input type="button" class="btn btn-warning" style="margin-top:-10px;" value="Verify" onClick="verify();" >
		  
		  </p>
        </div>
        <div class="modal-footer">
		<input type="hidden" id="otp_bid_id" value="" >
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
                       
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
function ajax_save_shortcut_place(placename)
{
	
	var placename = document.getElementById(placename).value;
	
	if( placename == "")
	{
		alert('Fill form properly');
		document.getElementById(placename).focus();
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
				document.getElementById("destinationid").innerHTML = xmlhttp.responseText;
				
				
				document.getElementById("placename").value = "";
				$("#div_placeid").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_saveplace.php?placename="+placename,true);
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
			//alert(data);
			var arr = data.split('|');
			//$('#billtyno').val(arr[0]);
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



$('#itemid').change(function(){
		//alert("hi");
		var itemid = $('#itemid').val();
		if(itemid==1) {
				$('#brand_id').val('5');
		}else {
			$('#brand_id').val('');
		}
});

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

function checkLength(el) {
  if (el.value.length != 10) {
    alert("DI No Must Be 10 Digit");
	//document.getElementById('di_no').innerHTML='';
	$('#di_no').focus();
	$('#di_no').html('');
	return false;
  }
}


function edit(bid_id) {
$('#myModal').modal('show');


$.ajax({
		type: 'POST',
		url: 'ajax_getverify.php',
		data: 'bid_id='+bid_id,
		dataType: 'html',
		success: function(data){
			//alert(data);
			
			$('#otp_bid_id').val(bid_id);
		}					
});//ajax close	

}


function verify() {
		var bid_id = $('#otp_bid_id').val();
		var otp = $('#otp').val();
		
		if(otp !='') {
		$.ajax({
		type: 'POST',
		url: 'ajax_getverify_otp.php',
		data: 'bid_id='+bid_id+'&otp='+otp,
		dataType: 'html',
		success: function(data){
			if(data==1) {
				window.location="bidding_entry.php?edit="+bid_id;
			}
			else
			{
				alert("Wrong OTP");
			}
			
		}					
});//ajax close
}

}
</script>			
                
		
	</body>

	</html>
