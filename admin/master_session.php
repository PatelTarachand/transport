<?php
include("dbconnect.php");
$tblname = "m_session";
$tblpkey = "sessionid";
$pagename = "master_session.php";
$modulename = "Session Master";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$sessionid=$_GET['edit'];
	$sql_edit="select * from m_session where sessionid='$sessionid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$logsession_name = $row['session_name'];
			$inv_prefix = $row['inv_prefix'];
			$clinker_prefix = $row['clinker_prefix'];
			$start_date = $cmn->dateformatindia($row['start_date']);
			$end_date =  $cmn->dateformatindia($row['end_date']);
		}//end while
	}//end if
}//end if
else
{
	$sessionid = 0;
	$incdate = date('d-m-Y');
	$end_date='';
	$start_date='';
	$logsession_name='';
	$inv_prefix='';
	$clinker_prefix='';
}

$duplicate= "";
if(isset($_POST['submit']))
{
	$session_name = $_POST['session_name'];
	$inv_prefix = trim($_POST['inv_prefix']);
	$clinker_prefix = trim($_POST['clinker_prefix']);
	$start_date = $cmn->dateformatusa($_POST['start_date']);
	$end_date =  $cmn->dateformatusa($_POST['end_date']);
	
	//print_r($_POST);die;
	if($sessionid==0)
	{
		
		$sql_chk = "select * from m_session where session_name='$session_name' and start_date = '$start_date' and end_date = '$end_date'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
			$sql_insert="insert into m_session set session_name = '$session_name', start_date = '$start_date',end_date='$end_date',createdby = '$_SESSION[userid]',inv_prefix='$inv_prefix',clinker_prefix='$clinker_prefix',
			branchid = '$_SESSION[branchid]', createdate=now(),ipaddress = '$ipaddress'"; 
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_session.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_session set session_name = '$session_name', start_date = '$start_date',
			end_date='$end_date',createdby = '$_SESSION[userid]',inv_prefix='$inv_prefix',branchid = '$_SESSION[branchid]',clinker_prefix='$clinker_prefix',lastupdate=now(),ipaddress = '$ipaddress' where sessionid='$sessionid'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $sessionid;
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_session.php?action=2'</script>";
	}
}

?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

<script>
  $(function() {
   
	 $('#start_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	  $('#end_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	
  });
  </script>

</head>

<body onLoad="hideval();">
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('session_name,start_date ,end_date')">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td><strong>Session Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="session_name" id="session_name" value="<?php echo $logsession_name; ?>"
                                     autocomplete="off"  maxlength="120" class="input-medium" required ></td>
                                    <td><strong>Start Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="start_date" id="start_date" value="<?php echo $start_date; ?>" autocomplete="off"  maxlength="10" class="input-medium" required></td>
                                
                                   
                                    <td><strong>End Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="end_date" id="end_date" value="<?php echo $end_date; ?>" autocomplete="off"  maxlength="10" class="input-medium"></td> </tr>
									
									<tr>
                                 
								 <td><strong>Cement Prefix</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="inv_prefix" id="inv_prefix" value="<?php echo $inv_prefix; ?>" autocomplete="off"  maxlength="120"  class="input-medium"  ></td>
									
									
									<td><strong>Clinker Prefix</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="clinker_prefix" id="clinker_prefix" value="<?php echo $clinker_prefix; ?>" autocomplete="off"  maxlength="120"  class="input-medium"  ></td>
									 
                                    <td>
                                 
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" tabindex="10">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    <?php
									}
                                   else
                                   {                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
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
                <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table width="100%" class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th width="4%">Sno</th>  
                                            <th width="28%">Session Name</th>
                                        	<th width="18%">Start Date</th>
                                            <th width="16%">End Date</th>
                                            <th width="16%">Cement Prefix</th>
											<th>Clinker Prefix</th>
                                        	<th width="18%" class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_session";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['session_name']);?> </td>
                                            <td><?php echo $cmn->dateformatindia($row['start_date']);?></td>
                                          
                                           <td><?php echo $cmn->dateformatindia($row['end_date']);?></td>
                                            <td><?php echo $row['inv_prefix'];?> </td>
											<td><?php echo $row['clinker_prefix'];?> </td>
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['sessionid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
		document.getElementById('session_name').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('session_name').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('session_name').disabled = false;
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
