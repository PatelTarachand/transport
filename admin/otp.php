<?php include("dbconnect.php");
include("../lib/smsinfo.php");
$tblname = "m_place";
$tblpkey = "placeid";
$pagename = "billty_form.php";
$modulename = "Enter OTP";



//print_r($_SESSION);
$messege='';

if(isset($_GET['msg']))
{
	$msg = trim(addslashes($_GET['msg']));
}
else
{
	$msg='';	
}



if($msg !='')
{
	if($msg=='resend')
	{
	$messege="Otp Send Successfully, Kindly Check Mobile No";
	}
	
	if($msg=='wrong')
	{
	$messege="Wrong Otp, Kindly Check Mobile No";
	}
	
}



if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;



if(isset($_GET['bilty_id']))
{
	$bilty_id = trim(addslashes($_GET['bilty_id']));
	if($msg=='')
	{
	$messege="Otp Send Successfully, Kindly Check Mobile No";
	}
}
else
{
	$bilty_id ='';
}




if($bilty_id !='')
{
	
	if(isset($_GET['sms'])=='true')
{
	
	
	$otp = $cmn->getvalfield($connection,"bilty_entry","otp","bilty_id='$bilty_id'");
	
	
	if($otp=='')
	{
	$otp = mt_rand(1000,9999);	
	mysqli_query($connection,"update bilty_entry set otp='$otp' where bilty_id='$bilty_id'");
	}
	
	
	if(!isset($_POST['submit']))
	{
	$otpmsg = "Dear Admin, your 4 digit otp is $otp\nBPS Transport";
	//$cmn->sendsms($username,$msg_token,$sender_id,$otpmsg,"9993114257");
	//$cmn->sendsms($username,$msg_token,$sender_id,$otpmsg,"7225060522");
	
	
	}
	}
}
else
{
	echo "<script>location='billty_form.php'</script>";
}




$duplicate= "";
if(isset($_POST['submit']))
{
	$otp = trim(addslashes($_POST['otp']));
	$bilty_id = $_POST['bilty_id'];
	
	if($otp !='')
	{
	$givenotp = $cmn->getvalfield($connection,"bilty_entry","otp","bilty_id='$bilty_id'");

	
	if($givenotp == $otp)
	{
		$otp = strrev($otp);
		echo "<script>location='billty_form.php?edit=$bilty_id&&success=$otp'</script>";
	}
	else
	{
		echo "<script>location='otp.php?bilty_id=$bilty_id&msg=wrong'</script>";
	}
	
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
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('placename')">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><center><b style="color:#F00;"> <?php echo $messege;  ?> </b></center></td></tr>
                                <?php echo $cmn->getvalfield($connection,"bilty_entry","otp","bilty_id='$bilty_id'"); ?>
                                <tr>
                                    <td ><strong>Enter OTP </strong> <strong>:</strong><span class="red">*</span></td>
                                    <td ><input type="text" name="otp" id="otp" value=""
                                     autocomplete="off"  maxlength="120" tabindex="1" placeholder='Enter 4 digit otp'  class="input-large" ></td>
                                    
                                 </tr>   
                                   
                                 <tr>
                                 <td colspan="4" style="line-height:5">
                                   
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('otp')" tabindex="10" style="margin-left:360px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Back" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                                    <?php
                                   }
								   ?>
									
                                      <input type="hidden" name="bilty_id" id="bilty_id" value="<?php echo $bilty_id; ?>" >
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
