<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "m_unit";
$tblpkey = "unitid";
$pagename = "master_unit.php";
$modulename = "Unit Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$unitid=$_GET['edit'];
	$sql_edit="select * from m_unit where unitid='$unitid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$unitname = $row['unitname'];
			
		}//end while
	}//end if
}//end if
else
{
	$unitid = 0;
	$unitname='';
	
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$unitname = $_POST['unitname'];
	//$districtid = $_POST['districtid'];
	
	if($unitid==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_unit where unitname='$unitname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
			 $sql_insert="insert into m_unit set unitname = '$unitname', createdate=now(),sessionid = '$_SESSION[sessionid]'"; 
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_unit.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_unit set unitname = '$unitname' where unitid='$unitid'";
		mysqli_query($connection,$sql_update);
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $unitid,'updated');
		echo "<script>location='master_unit.php?action=2'</script>";
	}
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

</head>

<body onLoad="hideval();">
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
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('unitname')">
                                <div class="control-group">
                                <table class="table table-condensed" style="width:50%;">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td style="width:2%;"><strong>Unit Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td style="width:1%;"><input type="text" name="unitname" id="unitname" value="<?php echo $unitname; ?>" autocomplete="off"  maxlength="120" tabindex="1"   class="input-large" ></td>
                                     <td style="width:10%;">
                                   
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('unitname')" tabindex="10" >
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="unitid" id="<?php echo $unitid; ?>" value="<?php echo $unitid; ?>" >
                                    </span></td>
                                 </tr>  
									
									
                                
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
                <!--   DTata tables -->
                <div class="row-fluid" id="list" style="display:none;">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th width="10%">Sno</th>  
                                            <th width="40%">UNIT Name</th>
                                            <th class='hidden-480' width="10%">Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_unit order by unitid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['unitname']);?></td>
                                           	<td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['unitid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
