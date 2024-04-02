<?php error_reporting(0);
include("dbconnect.php");
$tblname = "account_setting";
$tblpkey = "account_id";
$pagename = "account_setting.php";
$modulename = "Account Setting";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_POST['submit']))
{
	$account_id = $_POST['account_id'];
	$cashopeningbal = $_POST['cashopeningbal'];
	$bankopeningbal = $_POST['bankopeningbal'];
	$open_bal_date = $cmn->dateformatusa($_POST['open_bal_date']);
	
	$diesel_opening_bal = $_POST['diesel_opening_bal'];
	$diesel_open_bal_date = $cmn->dateformatusa($_POST['diesel_open_bal_date']);
	
	$cashopeningbal_emami = $_POST['cashopeningbal_emami'];	
	$bankopeningbal_emami = $_POST['bankopeningbal_emami'];
	$open_bal_date_emami = $cmn->dateformatusa($_POST['open_bal_date_emami']);
	
	$totcom = $cmn->getvalfield($connection,"account_setting","count(account_id)","compid='$compid'");
	
	if($totcom==0){
	    	$sql_update = "insert into  account_setting set cashopeningbal = '$cashopeningbal', bankopeningbal = '$bankopeningbal',open_bal_date='$open_bal_date',diesel_opening_bal='$diesel_opening_bal',diesel_open_bal_date='$diesel_open_bal_date',
	cashopeningbal_emami='$cashopeningbal_emami',bankopeningbal_emami='$bankopeningbal_emami',open_bal_date_emami='$open_bal_date_emami',
	createdby = '$_SESSION[userid]',ipaddress = '$ipaddress',compid = '$compid'"; 
		mysqli_query($connection,$sql_update);
	    
	}else{
	$sql_update = "update  account_setting set cashopeningbal = '$cashopeningbal', bankopeningbal = '$bankopeningbal',open_bal_date='$open_bal_date',diesel_opening_bal='$diesel_opening_bal',diesel_open_bal_date='$diesel_open_bal_date',
	cashopeningbal_emami='$cashopeningbal_emami',bankopeningbal_emami='$bankopeningbal_emami',open_bal_date_emami='$open_bal_date_emami',
	createdby = '$_SESSION[userid]',ipaddress = '$ipaddress',compid = '$compid' where account_id='$account_id'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $account_id;
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
	}
		echo "<script>location='account_setting.php?action=2'</script>";
	
}

$sql = mysqli_query($connection,"select * from account_setting where compid = '$compid'");
$row=mysqli_fetch_assoc($sql);
$account_id = $row['account_id'];

$cashopeningbal = $row['cashopeningbal'];
$bankopeningbal = $row['bankopeningbal'];
$open_bal_date = $row['open_bal_date'];
$diesel_opening_bal = $row['diesel_opening_bal'];
$diesel_open_bal_date = $row['diesel_open_bal_date'];

$cashopeningbal_emami = $row['cashopeningbal_emami'];
$bankopeningbal_emami = $row['bankopeningbal_emami'];
$open_bal_date_emami = $row['open_bal_date_emami'];
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
						      																																																																																																																														
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' >
                                <div class="control-group">
                                <table class="table table-condensed" style="width:70%;margin-top: 20px;">
                   <!--             <tr>-->
                   <!--                 <td width="15%"><strong>Plant Opening Balance(Cash)</strong> <strong>:</strong><span class="red">*</span></td>-->
                   <!--<td width="15%"><input type="text" name="cashopeningbal" id="cashopeningbal" value="<?php echo $cashopeningbal; ?>"  autocomplete="off"    tabindex="1"  class="input-medium" ></td>-->
                   <!--                 <td width="15%"><strong>Plant Opening Balance(Bank)</strong> <strong>:</strong><span class="red">*</span></td>-->
                   <!--<td width="15%"><input type="text" name="bankopeningbal" id="bankopeningbal" value="<?php echo $bankopeningbal; ?>" autocomplete="off" -->
                   <!--tabindex="2"  class="input-medium" ></td>-->
                   <!--<td width="15%"><strong>Plant Opening Balance Date</strong> <strong>:</strong><span class="red">*</span></td>-->
                   <!--<td width="10%"><input type="text" name="open_bal_date" id="open_bal_date" value="<?php echo $cmn->dateformatindia($open_bal_date); ?>" autocomplete="off" tabindex="3"  class="input-medium" ></td>-->
                                
                                    
                   <!--               </tr>-->
                                  
                   <!--             <tr>-->
                   <!--                 <td width="15%"><strong>Office Opening Balance</strong> <strong>:</strong><span class="red">*</span></td>-->
                   <!--<td width="15%"><input type="text" name="diesel_opening_bal" id="diesel_opening_bal" value="<?php echo $diesel_opening_bal; ?>"  autocomplete="off"    tabindex="4"  class="input-medium" ></td>-->
                                    
                   
                   <!--<td width="15%"><strong>Office Opening Balance Date</strong> <strong>:</strong><span class="red">*</span></td>-->
                   <!--<td width="10%"><input type="text" name="diesel_open_bal_date" id="diesel_open_bal_date" value="<?php echo $cmn->dateformatindia($diesel_open_bal_date); ?>" autocomplete="off" tabindex="5"  class="input-medium" ></td>-->
                   <!-- <td colspan="2"></td>            -->
                                    
                   <!--               </tr>-->
                                  
                                  
                                  <tr>
                                    <td width="15%"><strong>Opening Balance(Cash)</strong> <strong>:</strong><span class="red">*</span></td>
                   <td width="15%"><input type="text" name="cashopeningbal_emami" id="cashopeningbal_emami" value="<?php echo $cashopeningbal_emami; ?>"  autocomplete="off"    tabindex="1"  class="input-medium" ></td>
                                    <td width="15%"><strong>Opening Balance(Bank)</strong> <strong>:</strong><span class="red">*</span></td>
                   <td width="15%"><input type="text" name="bankopeningbal_emami" id="bankopeningbal_emami" value="<?php echo $bankopeningbal_emami; ?>" 
                   autocomplete="off" 
                   tabindex="2"  class="input-medium" ></td>
                   <td width="15%"><strong>Opening Balance Date</strong> <strong>:</strong><span class="red">*</span></td>
                   <td width="10%"><input type="text" name="open_bal_date_emami" id="open_bal_date_emami" value="<?php echo $cmn->dateformatindia($open_bal_date_emami); ?>" autocomplete="off" tabindex="3"  class="input-medium" ></td>
                                
                                    
                                  </tr>
                                  
                                  
                                  <tr> 
                                  
                                  			<td colspan="6">  
                                            <center>                               
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                      tabindex="6">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="6" />                        
                                    <?php
                                   }
                                   else
                                   {                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="6" >
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="account_id" id="account_id" value="<?php echo $account_id; ?>" >
                                      </center>
                                    </td>
                                  </tr>
                                  
                                </table> 
                                </div>
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

jQuery(function($){
   $("#open_bal_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
   $("#open_bal_date_emami").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#diesel_open_bal_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

</script>
	</body>
	</html>
<?php
mysqli_close($connection);
?>
