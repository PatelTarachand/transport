<?php
include("dbconnect.php");
$tblname = "m_rates";
$tblpkey = "rateid";
$pagename = "master_rate.php";
$modulename = "Rate Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$rateid=$_GET['edit'];
	$sql_edit="select * from m_rates where rateid='$rateid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$consignorid = $row['consignorid'];
			$placeid = $row['placeid'];
			$fromdate = $cmn->dateformatusa($row['fromdate']);
			$todate = $cmn->dateformatusa($row['todate']);
			$companyrate = $row['companyrate'];
			$clinkerrate = $row['clinkerrate'];
			
		}//end while
	}//end if
}//end if
else
{
	$rateid = 0;
	$incdate = date('d-m-Y');
	$clinkerrate='';
	$consignorid = '';
			$placeid = '';
			$fromdate = '';
			$todate = '';
			$companyrate = '';
}

$duplicate= "";
if(isset($_POST['submit']))
{

	


	if(isset($_FILES['csv']['tmp_name']))
	{
		
	$file = $_FILES['csv']['tmp_name'];
//	print_r($_FILES);die;
	$handle = fopen($file,"r");
	if ($handle) {
	$c=1;
		while($data = fgetcsv($handle))
		{
		//	print_r($data);die;
			    $schoolname=$data[0]; 
			 	$X=$data[1];
				
			

			$form_data = mysqli_query($connection,"UPDATE `bidding_entry` SET  freightamt='$X' where lr_no='$schoolname' and `is_complete`!=1	 ");
					
									  
			  $action=1;
			  $process = "insert";
							
								
												
					//	}
						
			
			$c++;
		}// end while
		
	}

	else {
    die("Unable to open file");
}
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
$("#shortcut_placeid").click(function(){
	$("#div_placeid").toggle(1000);
});
});
</script>
</head>

<body onLoad="hideval();">
<!--- short cut form place --->
<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place</strong></td></tr>
  <tr><td>&nbsp;Unit Name: </td></tr>
  <tr><td><input type="text" name="placename" id="placename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_placename();"/></td></tr>
</table>
</div>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
 			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							<div class="box-title"><a href="source/master_rate.csv"> <button>CSV Format</button></a> </div>
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data" onSubmit="return checkinputmaster('consignorid,placeid,fromdate,todate,companyrate nu,freightrate nu')">
                                <div class="control-group">
                                <table class="table table-bordered table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                	<tr>
                                  
                            		<td width="16%">Upload CSV File<span class="red">*</span></td>
                                    <td width="47%">
                            	<input type="file" name="csv" accept=".csv" id="csv" required></td>
                                    
                            </td>
                                  </tr>
                                  <tr>
                                    
                                    
                                    
                                  
                                  </tr>
                                  
                                  <tr >
                                        <td style="display:none;">Clinker Rate:<span class="red">*</span></td>
                                        <td style="display:none;"><input type="text" name="clinkerrate" id="clinkerrate" value="<?php echo $clinkerrate ; ?>"  ></td>
                                        
                                        <td></td>
                                  </tr>
                                  
                                 <tr>
                                  	 
                                    <td colspan="4">
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('consigneename,placeid')" style="margin-left:390px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </td>
                                  </tr>
                                 
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
                <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding"   >
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>
                                            <th>LR. No</th>
                                            <th>Company Rate</th>
                                            
										</tr>
									</thead>
                                    <tbody >
                                    	<?php 

$slno=1;
 $sel = "SELECT * FROM `bidding_entry` WHERE is_complete!='1' and 1=1  order by bid_id desc";
$res =mysqli_query($connection,$sel);
while($row = mysqli_fetch_array($res))
{
	$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid=$row[consignorid]");
?>
	<tr>
		<td><?php echo $slno; ?></td>
		<td><?php echo $row['lr_no']; ?></td>
		<td><?php echo 	$row['freightamt'];?></td>
	   
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
				
			
			</div>
		</div></div>
<script>
function funDel(id)
{    
	  	//alert(id);   
	  	tblname = '<?php echo $tblname; ?>';
	  	tblpkey = '<?php echo $tblpkey; ?>';
	  	pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  	//alert(tblname);
	if(confirm("Are you sure! You want to delete this record."))
	{
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			// alert(data);
			 //alert('Data Deleted Successfully');
			location=pagename+'?action=10';
			}
		  });//ajax close
	}//confirm close
} //fun close


function get_selected_rates()
{
	var consignorid = document.getElementById('consignorid').value;
	var placeid = document.getElementById('placeid').value;
	//alert(consignorid);
	
	if(consignorid !='' && placeid !='') {
	
	$.ajax({
	type: 'POST',
	url: 'ajax_get_rate_master.php',
	data: 'consignorid=' + consignorid + '&placeid=' + placeid,
	dataType: 'html',
	success: function(data){
		//alert(data);
	 	//alert('Data Deleted Successfully');
		document.getElementById('getratelist').innerHTML = data;
		//location=pagename+'?action=10';
		}
	});//ajax close

	}	
}

function hideval()
{
	var paymode = document.getElementById('paymode').value;
	if(paymode == 'cash')
	{
		document.getElementById('checquenumber').disabled = true;
		document.getElementById('bankname').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('bankname').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('bankname').disabled = false;
	}
}
</script>
<script>
function ajax_save_placename()
{
	var placename = document.getElementById('placename').value;
		//alert(placename);
		if(placename == "")
		{
			alert('Please Fill place name');
			document.getElementById('placename').focus();
			return false;
		}
		
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
				if(xmlhttp.responseText != '')
				{
					//alert('This specification already exist');
					//alert( xmlhttp.responseText);
					document.getElementById("placeid").innerHTML = xmlhttp.responseText;
					
					document.getElementById("placename").value = "";
					$("#div_placeid").hide(1000);
					
				}
			}
		}
		xmlhttp.open("GET","ajax_saveplace.php?placename="+placename,true);
		xmlhttp.send();
}

	//below code for date mask
jQuery(function($){
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

</script>
	</body>
	</html>
<?php
mysqli_close($connection);
?>
