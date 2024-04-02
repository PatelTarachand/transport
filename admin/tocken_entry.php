<?php  
include("dbconnect.php");
$tblname = 'tokenpass';
$tblpkey = 'tpass_id';
$pagename  ='tocken_entry.php';
$modulename = "Recent Added Bidding";

if(isset($_GET['source']))
{
	$source = trim(addslashes($_GET['source']));	
}

if(isset($_GET['edit']))
{
	$tpass_id = addslashes(trim($_GET['edit']));
	$row = mysqli_fetch_array(mysqli_query($connection,"select * from tokenpass where tpass_id = '$tpass_id'"));
	$tpass_id = $row['tpass_id'];
	$token_no = $row['token_no'];
	$tocken_date = $row['tocken_date'];
	$truck_no = $row['truck_no'];
	$driver_name = $row['driver_name'];
	$qty = $row['qty'];
	$destination = $row['destination'];
	$mobile  = $row['mobile'];
}
else
{
$tpass_id = 0;
$token_no='';
$driver_name ='';
$qty='';
$truck_no='';
$tocken_date = date('Y-m-d');
$mobile='';
$destination='';
}
$duplicate= "";

if(isset($_POST['sub']))
{
	$tpass_id = trim(addslashes($_POST['tpass_id']));
	$token_no = trim(addslashes($_POST['token_no']));
	$tocken_date = $cmn->dateformatusa(trim(addslashes($_POST['tocken_date'])));
	$truck_no = trim(addslashes($_POST['truck_no']));
	$driver_name = trim(addslashes($_POST['driver_name']));
	$qty = trim(addslashes($_POST['qty']));
	$destination = trim(addslashes($_POST['destination']));	
	$mobile = trim(addslashes($_POST['mobile']));
	
	if($tpass_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from tokenpass where token_no='$token_no'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{		
			$sql_insert="insert into tokenpass set token_no = '$token_no', tocken_date = '$tocken_date',truck_no = '$truck_no',driver_name='$driver_name',destination = '$destination',qty = '$qty',mobile='$mobile',createdate=now(),ipaddress = '$ipaddress',createdby='$userid',sessionid='$sessionid'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
		
			echo "<script>location='tokenpass.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		
			 $sql_update = "update  tokenpass set  token_no = '$token_no', tocken_date = '$tocken_date',truck_no = '$truck_no',driver_name='$driver_name',destination = '$destination',qty = '$qty',mobile='$mobile',createdate=now(),lastupdated=now(),ipaddress = '$ipaddress' where tpass_id='$tpass_id'"; 
		
		mysqli_query($connection,$sql_update);
	
		echo "<script>location='tocken_entry.php?action=2'</script>";
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
		$("#div_driver_name").toggle(1000);
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
                  	  
    				<fieldset style="margin-top:45px; margin-left:45px;" >
                                        
    	<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
		<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Token</legend>
		
                 
                   
                <div class="innerdiv">
                    <div>Token no. <span class="err" style="color:#F00;">*</span></div>
                   <div class="text">
                    <input type="text" class="formcent" name="token_no" id="token_no" value="<?php echo $token_no; ?>" required style="border: 1px solid #368ee0" autocomplete="off"  >
                    </div>
               </div>
                 
                <div class="innerdiv">
                    <div>Token Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="tocken_date" id="tocken_date" value="<?php echo $cmn->dateformatindia($tocken_date); ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
               <div class="innerdiv">
                    <div>Truck No <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                   <input type="text" class="formcent" name="truck_no" id="truck_no" value="<?php echo $truck_no; ?>" required style="border: 1px solid #368ee0" autocomplete="off"  >                  
                </div>
                </div>
           
                <br>
                <br>


            <div class="innerdiv">
                <div>Driver Name<span class="err" style="color:#F00;">*</span> &nbsp;</div>
                <div class="text">
               <input type="text" class="formcent" name="driver_name" id="driver_name" value="<?php echo $driver_name; ?>"  style="border: 1px solid #368ee0" autocomplete="off"  >
                </div>
                   </div>
              <div class="innerdiv">
                    <div>Destination<span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
                       <input type="text" class="formcent" name="destination" id="destination" value="<?php echo $destination; ?>"  style="border: 1px solid #368ee0" autocomplete="off"  >
                    </div>
                </div>
                
               
					
            	<div class="innerdiv">
                	<div>Qty<span class="err" style="color:#F00;">*</span> </div>
                    <div class="text">
            		<input type="text" class="formcent" name="qty" id="qty" value="<?php echo $qty; ?>"  style="border: 1px solid #368ee0" autocomplete="off"  >
                </div>
                </div>
                <br><br>
                   <div class="innerdiv">
                    <div>Mobile</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="mobile" id="mobile" value="<?php echo $mobile;?>" style="border: 1px solid #368ee0" autocomplete="off" >                 
                    </div>
					</div>
<br>
<br>
<br>
  <br>
    		 
	<center>				
					
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('token_no,tocken_date,truck_no,driver_name,qty'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                   
					
  </center>                 
    				</fieldset>
    		        <input type="hidden" name="tpass_id" id="tpass_id" data-key="primary" value="<?php echo $tpass_id; ?>">
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
                                        	<th>Tocken Date</th>
                                            <th>Truck No </th>
                                            <th>Driver Name</th>
                                            <th>Destination</th>
                                            <th>Qty</th>
                                            <th>Mobile</th>
                                           
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
									
									$sel = "select * from tokenpass $cond  order by tpass_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
            <tr>
                    <td><?php echo $slno; ?></td>
                    <td><?php echo ucfirst($row['token_no']);?></td>
                    <td><?php echo $cmn->dateformatindia($row['tocken_date']);?></td>
                    <td><?php  echo $row['truck_no'];?></td>                    
                    <td><?php echo $row['driver_name']?></td>
                    <td><?php echo ucfirst($row['destination']);?></td>
                    <td><?php echo ucfirst($row['qty']);?></td>
                    <td><?php echo ucfirst($row['mobile']);?></td>
                    <td class='hidden-480'>
                    <a href= "?edit=<?php echo ucfirst($row['tpass_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                    &nbsp;&nbsp;&nbsp;
                    <a onClick="funDel('<?php echo $row['tpass_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
				document.getElementById("driver_name").innerHTML = xmlhttp.responseText;
				
				document.getElementById("districtid").value = "";
				document.getElementById("placename").value = "";
				$("#div_driver_name").hide(1000);
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
$('#truck_no').change(function(){										  	
var truck_no = $('#truck_no').val();

$.ajax({
		type: 'POST',
		url: 'getbillno.php',
		data: 'truck_no=' + truck_no,
		dataType: 'html',
		success: function(data){
			//alert(data);
			var arr = data.split('|');
			//$('#billtyno').val(arr[0]);
			$('#driver_name').val(arr[1]);	
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
	var truck_no = $('#truck_no').val();
	var qty = $('#qty').val();
	
	if(qty !='' && truck_no !='')
	{
		$.ajax({
		type: 'POST',
		url: 'getconsignorrate.php',
		data: 'truck_no='+truck_no+'&qty='+qty,
		dataType: 'html',
		success: function(data){
			document.getElementById('rate_mt').value= data;
		}					
});//ajax close	
		
	}
		
}

function saverate()
{
	var truck_no = $('#truck_no').val();
	var qty = $('#qty').val();
	var rate_mt = $('#rate_mt').val();
	var billtydate = $('#billtydate').val();
	
	if(truck_no=='')
	{
		alert("Please Select Consignor");
		$('#rate_mt').val('');
		return false;
	}
	
	if(qty=='')
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
		data: 'truck_no='+truck_no+'&qty='+qty+'&rate_mt='+rate_mt+'&billtydate='+billtydate,
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
