<?php error_reporting(0);
include("dbconnect.php");
$tblname = "m_prefix_setting";
$tblpkey = "prefixid";
$pagename = "prefix_setting.php";
$modulename = "Prefix Setting Master";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;



$sql_edit="select * from $tblname where branchid='$_SESSION[branchid]'";
$res_edit=mysqli_query($connection,$sql_edit);
if($res_edit)
{
	$row=mysqli_fetch_array($res_edit);
	
	$challan = $row['challan'];
	$branch = $row['branch'];
	$receipt = $row['receipt'];
	
	
}//end if


if(isset($_POST['submit']))
{
	$challan = $_POST['challan'];
	$branch = $_POST['branch'];
	$receipt = $_POST['receipt'];
	$address = $_POST['address'];
	$contactpersion = $_POST['contactpersion'];
	$helpline = $_POST['helpline'];
	$mobileno = $_POST['mobileno'];
	$phoneno = $_POST['phoneno'];
	//print_r($_POST);die;
	
	//delete previous entry
	mysqli_query($connection,"delete from $tblname where branchid = '$branchid'");
	
	$sql_insert="insert into $tblname set branchid = '$_SESSION[branchid]',challan = '$challan', branch = '$branch',
	 receipt='$receipt',createdby = '$_SESSION[userid]',ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]', createdate=now()"; 
	mysqli_query($connection,$sql_insert);
	$keyvalue = mysqli_insert_id($connection);
	$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
	echo "<script>location='prefix_setting.php?action=1'</script>";
		
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
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                               
                                
                                <tr>
                                    <td width="10%"><strong>Challan Prefix</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="18%"><input type="text" name="challan" id="challan" value="<?php echo $challan; ?>"
                                     autocomplete="off"  maxlength="10" tabindex="1"  class="input-large" required ></td>
                                    <td width="12%"><strong>Branch Prefix:</strong><span class="red">*</span></td>
                                    <td width="19%"><input type="text" name="branch" id="branch" value="<?php echo $branch; ?>" autocomplete="off"  maxlength="10" tabindex="2"  class="input-large" required></td>
                                
                                  
                                    <td width="10%"> <strong>Receipt Prefix:</strong><span class="red">*</span></td>
                                    <td width="31%">
                    				<input type="text" name="receipt" value="<?php echo $receipt; ?>" id="receipt" 
                                       tabindex="3"  class="input-large" maxlength="10">
                                    </td>
                                   </tr> 
                                  
                                  
                                  
                                   <tr>
                                    <td colspan="6">&nbsp;</td>
                                    </tr>
                                  
                                   
                                  
                                  <tr>
                                    <td colspan="6">
                                 
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary"
                                     onClick="return checkinputmaster('challan,branch,receipt')" tabindex="4">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-success">
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </td>
                                  </tr>
                                </table> 
                                </form>
							
						</div>
					</div>
				</div>
                <!--   DTata tables -->
                
				
			
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
		document.getElementById('challan').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('challan').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('challan').disabled = false;
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