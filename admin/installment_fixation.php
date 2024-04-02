<?php error_reporting(0);
include("dbconnect.php");
$tblname = "installment_fixation";
$tblpkey = "if_id";
$pagename = "installment_fixation.php";
$modulename = "Truck Installment Fixation";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


if($_GET['t'])
{
	$truckid = addslashes(trim($_GET['t']));
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$sql = mysqli_query($connection,"select * from installment_fixation where truckid = '$truckid'");
	$row=mysqli_fetch_assoc($sql);
	$total_amt=$row["total_amt"];
	$noofinst=$row["noofinst"];			
	$if_id=$row["if_id"];
	
}

if($if_id=='')
{
	$if_id=0;	
}



if(isset($_POST['submit']))
{
			$if_id= trim(addslashes($_POST["if_id"]));
			$truckid= trim(addslashes($_POST["truckid"]));
			$total_amt=trim(addslashes($_POST["total_amt"]));
			$noofinst=trim(addslashes($_POST["noofinst"]));	
			
			$amount = $_POST['amount'];
			$duedate = $_POST['duedate'];
			$is_paid = $_POST['is_paid'];
	
	
	if($if_id==0)
	{
	mysqli_query($connection,"insert into installment_fixation set truckid='$truckid',total_amt='$total_amt',noofinst='$noofinst',
				ipaddress='$ipaddress',createdate='$createdate',sessionid='$sessionid'");
	$if_id = mysqli_insert_id($connection);
	}
	else
	{
		mysqli_query($connection,"update installment_fixation set truckid='$truckid',total_amt='$total_amt',noofinst='$noofinst',
				ipaddress='$ipaddress',createdate='$createdate' where if_id='$if_id'");
	}
	
	mysqli_query($connection,"delete from installment_detail where if_id='$if_id'");
	
	for($i=0;$i<sizeof($amount);$i++)
	{
		$duedate[$i] = $cmn->dateformatusa($duedate[$i]);
		mysqli_query($connection,"insert into installment_detail set amount='$amount[$i]',duedate='$duedate[$i]',is_paid='$is_paid[$i]',if_id='$if_id'");	
	}
	
			echo "<script>location = '$pagename';</script>";	
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
	
	});
	</script>
</head>

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
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
            <?php //include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            <div class="box-content">
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table>
                                    <tr>
                                        
                                        <td><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        
                                    </tr>
                                <tr>
                                   
                                      <td width="13%"><select name="truckid"  class="input-large select2-me"  id="truckid"   onChange="getTruck(this.value);" >
                                        <option value="">-Select-</option>
                                        <?php
													$sql_cat = mysqli_query($connection,"Select truckid,truckno from  m_truck order by truckid desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['truckid']; ?>" > <?php echo $res_cat['truckno']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>                                        
									  <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>' ;
                                      function getTruck(truckid)
                                      {
										  location = 'installment_fixation.php?t='+truckid;
                                      }</script>
                                     </td>                                                                      
                                 </tr>
                                </table>                               
                                </div>
                                </form>
							</div>
							
						</div>
					</div>
				</div>
                <?php
				if($truckid != "")
				{
					$typeid = $cmn->getvalfield($connection,"m_truck","typeid","truckid = '$truckid'");
				?>
                <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i>Save Truck Installment</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            <div class="box-content">
                                 <form  method="post" action="" class='form-horizontal'>
                                 <input type="hidden" name="truckid" id="truckid" value="<?php echo $truckid; ?>">
                                <div class="control-group">
                                
                                
                                
                      <table class="table table-condensed">
                                        <tr>
                                        <td width="20%"><strong>Owner Name</strong> <strong>:</strong><span class="red">*</span></td>
                                        <td width="29%"><span class="red"><?php echo ucfirst($cmn->getvalfield($connection," m_truckowner","ownername","ownerid = '$ownerid'")); ?></span></td>
                                        <td width="17%"><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span></td>
                                        <td width="34%"><span class="red"><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'"); ?></span></td>
                                        </tr>
                                        
                                         <tr>
                                        <td width="20%"><strong>Truck Type</strong> <strong>:</strong><span class="red">*</span></td>
                                        <td width="29%"><span class="red"><?php echo ucfirst($cmn->getvalfield($connection,"m_trucktype","typename","typeid = '$typeid'")); ?></span></td>
                                        <td width="17%"><strong>Manufacturer </strong> <strong>:</strong><span class="red">*</span></td>
                                        <td width="34%"><span class="red"><?php echo $cmn->getvalfield($connection," m_truck","manufacturer","truckid = '$truckid'"); ?></span></td>
                                        </tr>
                                        
                                        <tr>
                                        <td><strong>Total Amount</strong> </td>
                                        <td width="29%"><input type="text" name="total_amt" id="total_amt" class="input-small"
                                        value="<?php echo $total_amt; ?>"   autocomplete="off" ></td>
                                         <td width="17%"><strong>No of Installment </strong> <strong>:</strong><span class="red">*</span></td>
                                        <td><input type="text" name="noofinst" id="noofinst" class="input-small"
                                        value="<?php echo $noofinst; ?>"   autocomplete="off" onChange="getrecord();" ></td>
                                        </tr>
                                       </table> 
                                       
                                       <br>
										<br>
					
                    	<div id="getrecord" >
                                       
                        </div>                
                                        <table>
                                        <tr>
                                        <td width="627"><span class="control-group">
                                        <div class="form-actions">
                                        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary"
                                        onClick="return checkinputs();" >
                                       
                                        <input type="button" value="Reset" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />       
                                        </div>
                                        
                                        <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $if_id; ?>" >
                                        </span></td>
                                        </tr>
                                        </table>
                                </div>
                                </form>
							</div>
							
						</div>
					</div>
				</div>
                <?php
				}?>
               
                
				
			
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
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
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




function getrecord()
{
	var noofinst = document.getElementById('noofinst').value;
	var if_id = '<?php echo $if_id; ?>';
	
	if(isNaN(noofinst))
	{
		noofinst=0;	
	}
	
	$.ajax({
		  type: 'POST',
		  url: 'getrecordinst.php',
		  data: 'noofinst=' + noofinst+'&if_id='+if_id,
		  dataType: 'html',
		  success: function(data){
					$('#getrecord').html(data);
			}
		
		  });//ajax close
	
}
getrecord();
function setvalue(r)
{
	 if(document.getElementById('paid'+r).checked=true)
	 {
		document.getElementById('is_paid'+r).value=1; 
	 }
	 else
	 {
		document.getElementById('is_paid'+r).value=0;  
	 }
}

</script>

</html>

<?php
mysqli_close($connection);
?>