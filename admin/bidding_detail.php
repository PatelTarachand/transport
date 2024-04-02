<?php  
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bidding_detail.php';
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
	$tokenno = $row['tokenno'];
	$tokendate = $row['tokendate'];
	$consignorid = $row['consignorid'];
	$placeid = $row['placeid'];
	$destinationid = $row['destinationid'];
	$sessionid = $row['sessionid'];
	$itemid = $row['itemid'];
	$comp_rate = $row['comp_rate'];
	$own_rate = $row['own_rate'];
	$totalweight = $row['totalweight'];
	$remark = $row['remark'];
	
	}
else
{
$bid_id = 0;
$tokenno='';
$placeid ='';
$destinationid='';
$itemid='';
$comp_rate='';
$own_rate='';
$totalweight='';
$remark='';
$consignorid='';
$isbilled = 0;
$tokendate = date('Y-m-d');
}

$duplicate= "";



if(isset($_GET['edit']))
{
	$success  = strrev(trim(addslashes($_GET['success'])));
	
	$otp = $cmn->getvalfield($connection,"bidding_entry","otp","bid_id='$bid_id'");
	if($otp !='')
	{
		if($success !=$otp)
		{	
			echo "<script>location='bidding_entry.php'</script>";
		}
	}
	else
	{
	echo "<script>location='bidding_entry.php'</script>";
	}
}





if(isset($_POST['sub']))
{

	//print_r($_POST); die;
	$bid_id = trim(addslashes($_POST['bid_id']));
	$tokenno = trim(addslashes($_POST['tokenno']));
	$tokendate = $cmn->dateformatusa(trim(addslashes($_POST['tokendate'])));
	$consignorid = trim(addslashes($_POST['consignorid']));
	$placeid = trim(addslashes($_POST['placeid']));
	$destinationid = trim(addslashes($_POST['destinationid']));
	//$sessionid = trim(addslashes($_POST['sessionid']));
	$itemid = trim(addslashes($_POST['itemid']));
	$comp_rate = trim(addslashes($_POST['comp_rate']));
	$own_rate = trim(addslashes($_POST['own_rate']));
	$totalweight = trim(addslashes($_POST['totalweight']));
	$remark = trim(addslashes($_POST['remark']));
	
	
	
	if($bid_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from bidding_entry where bid_id='$bid_id' && consignorid='$consignorid' && sessionid='$sessionid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
			
			//	$count = $cmn->getvalfield($connection,"bidding_entry","count(*)","consignorid='$consignorid' && sessionid='$sessionid' && bid_id <> '$bid_id'");				
				
			//echo"insert into bidding_entry set tokenno = '$tokenno', tokendate = '$tokendate',consignorid = '$consignorid',placeid='$placeid',destinationid = '$destinationid',itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight', remark='$remark',createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]',createdby='$userid'";die;
			$sql_insert="insert into bidding_entry set tokenno = '$tokenno', tokendate = '$tokendate',consignorid = '$consignorid',placeid='$placeid',destinationid = '$destinationid',itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight', remark='$remark',createdate=now(),ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]',createdby='$userid'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='bidding_entry.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
			 $sql_update = "update  bidding_entry  set tokenno = '$tokenno', tokendate = '$tokendate',consignorid = '$consignorid',placeid='$placeid',destinationid = '$destinationid',sessionid='$sessionid',itemid='$itemid',comp_rate='$comp_rate', own_rate='$own_rate', totalweight='$totalweight', remark='$remark', lastupdated=now(),ipaddress = '$ipaddress' where bid_id='$bid_id'"; 
			 //die;
		mysqli_query($connection,$sql_update);
		//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
		
	
	}
	
	}



?>
<!doctype html>
<html>
<head>
    
    
    	
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



	<?php include("../include/top_files.php"); ?>

</head>

<body data-layout-topbar="fixed">
	
	 <?php include("../include/top_menu.php"); ?>
	 
	 
	 
	 <!--- top Menu----->
	 
	 
	 
	 
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                  	  
    				<fieldset style="margin-top:45px; margin-left:45px;" >
                                        
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Bidding</legend>
                 
                   
                <div class="innerdiv">
                    <div>Token no. <span class="err" style="color:#F00;">*</span></div>
                   <div class="text">
                    <input type="text" class="formcent" name="tokenno" id="tokenno" value="<?php echo $tokenno; ?>" required style="border: 1px solid #368ee0" autocomplete="off"  >
                    </div>
               </div>
                 
                <div class="innerdiv">
                    <div>Token Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="tokendate" id="tokendate" value="<?php echo 	$cmn->dateformatindia($tokendate); ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
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
                <div>From Place <span class="err" style="color:#F00;">*</span> &nbsp;</div>
                <div class="text">
                <?php echo $cmn->create_combo($connection,"m_place","placeid","placename","1=1","input-large"); ?>
                <script>document.getElementById('placeid').value = '<?php echo $placeid; ?>';</script>
                </div>
                   </div>
              <div class="innerdiv">
                    <div>To Place <span class="err" style="color:#F00;">*</span> </div>
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
                    <div>Remark</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="remark" id="remark" value="<?php echo $remark; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
                    </div>
					</div>
					
					<div class="innerdiv">
                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('tokenno,tokendate,consignorid,placeid,destinationid'); " >
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
							
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Token no.</th>
                                        	<th>Consignor</th>
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
										$cond="where createdby='$userid' ";	
									}
									
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['tokenno']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_session","session_name","sessionid = '$row[sessionid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
											<td><?php echo ucfirst($row['remark']);?></td>

                                           <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                           
                                           
                                            <td class='hidden-480'>
                                           <a href= "bidding_detail.php?bid_id=<?php echo ucfirst($row['bid_id']);?>&sms=true"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['bid_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
