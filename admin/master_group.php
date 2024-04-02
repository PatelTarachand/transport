<?php error_reporting(0);
include("dbconnect.php");
$tblname = "inv_m_group";
$tblpkey = "groupid";
$pagename = "master_group.php";
$modulename = "Group Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$groupid=$_GET['edit'];
	$sql_edit="select * from inv_m_group where groupid='$groupid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			
			$groupname = $row['groupname'];
		
		}//end while
	}//end if
}//end if
else
{
	$groupid = 0;
	$incdate = date('d-m-Y');
}

$duplicate= "";
if(isset($_POST['submit']))
{
	
	$groupname = $_POST['groupname'];
	
	
	if($groupid==0)
	{
		//check doctor existance
		$sql_chk = "select * from inv_m_group where groupname='$groupname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
			$sql_insert="insert into inv_m_group set  groupname = '$groupname', createdate=now(),sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_group.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  inv_m_group set groupname = '$groupname', lastupdated=now() where groupid='$groupid'";
		mysqli_query($connection,$sql_update);
		$keyvalue = $groupid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_group.php?action=2'</script>";
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
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('groupname')">
                                <div class="control-group">
                                
                                
                                  	<label for="name" class="control-label">Group Name:<span class="red">*</span></label>
                                  	<input type="text" name="groupname" id="groupname" value="<?php echo $groupname ; ?>"  tabindex="8">
                                &nbsp;&nbsp;&nbsp;
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('consigneename,placeid')" tabindex="10">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px">
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                   
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
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>
                                            <th>Group Name</th>
                                            
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from inv_m_group";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['groupname'];?></td>
                                            
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['groupid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['groupid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
	</body>
    <?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

	</html>
<?php
mysqli_close($connection);
?>
