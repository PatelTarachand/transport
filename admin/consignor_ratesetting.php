<?php 
include("dbconnect.php");
$tblname = "consignor_ratesetting";
$tblpkey = "rateid";
$pagename = "consignor_ratesetting.php";
$modulename = "Consignor Rate Setting";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$rateid=$_GET['edit'];
	$sql_edit="select * from consignor_ratesetting where rateid='$rateid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			
			$consignorid = $row['consignorid'];
			$placeid = $row['placeid'];
			$sessionid = $row['sessionid'];
			$rate = $row['rate'];
			$setdate = $cmn->dateformatindia($row['setdate']);
			
		
		}//end while
	}//end if
}//end if
else
{
	$rateid = 0;
	$incdate = date('d-m-Y');	
	$consignorid = '';
	$placeid = '';
	$sessionid = '';
	$rate = '';
	$setdate ='';
	
}

$duplicate= "";
if(isset($_POST['submit']))
{
	
	$consignorid = $_POST['consignorid'];
	$placeid = $_POST['placeid'];
	$sessionid = $_POST['sessionid'];
	$rate = $_POST['rate'];
	$setdate = $cmn->dateformatusa($_POST['setdate']);
	
	
	
	if($rateid==0)
	{
		//check doctor existance
		
		$sql_chk = "select * from consignor_ratesetting where consignorid='$consignorid' and sessionid='$sessionid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
		
			$sql_insert="insert into consignor_ratesetting set  consignorid = '$consignorid',sessionid = '$sessionid',rate = '$rate',setdate = '$setdate',placeid = '$placeid',createdate=now()";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='consignor_ratesetting.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update consignor_ratesetting set  consignorid = '$consignorid',sessionid = '$sessionid',createdate=now(),rate = '$rate',setdate = '$setdate',placeid = '$placeid' where rateid='$rateid'";
		mysqli_query($connection,$sql_update);
		$keyvalue = $rateid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='consignor_ratesetting.php?action=2'</script>";
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
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('consignorid,consignor_prefix')">
                                <div class="control-group">
                                <table>
                                	
                                    <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
                                    <tr>
                                    	<td>
                                            <label for="name" class="control-label">Consignor:<span class="red">*</span></label>
                                            <select name="consignorid" id="consignorid" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        <?php
														$sql = "Select consignorid,consignorname from m_consignor order by consignorname";
														$res = mysqli_query($connection,$sql);
														if($res)
														{
															while($row = mysqli_fetch_assoc($res))
															{
														?>
                                                        	<option value="<?php echo $row['consignorid']; ?>"><?php echo $row['consignorname']; ?></option>
                                                        <?php
															}
														}
														?>
                                    				</select>
                                                    <script>document.getElementById('consignorid').value = "<?php echo $consignorid; ?>";</script>
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <label for="name" class="control-label">Session Name:<span class="red">*</span></label>
                                           <select name="sessionid" id="sessionid" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        <?php
														$sql = "Select sessionid,session_name from m_session";
														$res = mysqli_query($connection,$sql);
														if($res)
														{
															while($row = mysqli_fetch_assoc($res))
															{
														?>
                                                        	<option value="<?php echo $row['sessionid']; ?>"><?php echo $row['session_name']; ?></option>
                                                        <?php
															}
														}
														?>
                                    				</select>
                                                    <script>document.getElementById('sessionid').value = "<?php echo $sessionid; ?>";</script>
                                        </td>
                                        
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <label for="name" class="control-label">Place:<span class="red">*</span></label>
                                            
                                             <select name="placeid" id="placeid" class="select2-me input-large" >
                                    					<option value="">-Select-</option>
                                                        <?php
														$sql = "Select * from m_place order by placename";
														$res = mysqli_query($connection,$sql);
														if($res)
														{
															while($row = mysqli_fetch_assoc($res))
															{
																$distname = $cmn->getvalfield($connection,"m_district","distname","districtid='$row[districtid]'");
														?>
                                                        	<option value="<?php echo $row['placeid']; ?>"><?php echo $row['placename']."-".$distname; ?></option>
                                                        <?php
															}
														}
														?>
                                    				</select>
                                                    <script>document.getElementById('placeid').value = "<?php echo $placeid; ?>";</script>
                                            
                                          
                                        </td>
                                    </tr>
                                    <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
                                    
                                          <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
                                    <tr>
                                    	<td>
                                            <label for="name" class="control-label">Rate:<span class="red">*</span></label>
                                            <input type="text" name="rate" id="rate" value="<?php echo $rate; ?>"  tabindex="3">
                                        </td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <label for="name" class="control-label">Rate Set Date:<span class="red">*</span></label>
                                            <input type="text" name="setdate" id="setdate" value="<?php echo $setdate; ?>"  tabindex="3">
                                        </td>
                                        
                                       
                                    </tr>
                                    <tr><td>&nbsp;&nbsp;&nbsp;</td></tr>
                                    
                                     
                                   <tr>
                                   <td colspan="4" style="line-height:5">
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('consignorid,sessionid')" tabindex="10" style="margin-left:308px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" style="margin-left:15px">
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
                <div class="row-fluid" id="list">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                                <a href="excel_consignor_rate.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                 
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr >
                                            <th>Sno</th>
                                            <th>Consignor Name</th>
                                            <th>Session Name</th>
                                              <th>Place</th>
                                                <th>Rate</th>
                                                  <th>Set Date</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
											$slno=1;
											$sql_get = mysqli_query($connection,"select * from consignor_ratesetting order by rateid desc");
											while($row = mysqli_fetch_array($res))
									{?> 
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td> 
                                            <td><?php echo $cmn->getvalfield($connection,"m_session","session_name","sessionid='$row[sessionid]'");?></td>
                                             <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[placeid]'"); ?></td>
                                             <td><?php echo $row['rate'];?></td> 
                                              <td><?php echo $cmn->dateformatindia($row['setdate']);?></td> 
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['rateid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['rateid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
			 //alert(data);
			 //alert('Data Deleted Successfully');
			location=pagename+'?action=10';
			}
		  });//ajax close
	}//confirm close
} //fun close
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
</script>
<script>
//below code for date mask
jQuery(function($){
   $("#setdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
    
});
</script>

	</body>
 
	</html>
<?php
mysqli_close($connection);
?>