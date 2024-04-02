<?php error_reporting(0);
include("dbconnect.php");
$modulename = "Change Password";
$alert_msg="";
if(isset($_POST['save']))
{
	if($_SESSION["code"]==$_POST["captcha"])
	{
		$user_name=$_POST['user_name'];
		$old_password=$_POST['old_password'];
		$new_password=$_POST['new_password'];
		$re_new_password=$_POST['re_new_password'];
		
		$sql_password="SELECT count(*) FROM m_userlogin where username='$user_name' and password='$old_password'";
		$data_password=mysqli_query($connection,$sql_password);
		$row_password=mysqli_fetch_array($data_password);
		if($row_password[0]=="1")
		{
			$sql_update_password="UPDATE m_userlogin SET password='$re_new_password' WHERE username='$user_name'";
			$data_update_password=mysqli_query($connection,$sql_update_password);
			if($data_update_password)
			{
				$alert_msg="Password changed Successfully";
			}
			else
			{
				$alert_msg="Oops! There was a problem with the Server. Kindly try later . . . ";
			}
		}
		else
		{
			$alert_msg="Incorrect User Name or Password";
		}
	}
	else
	{
		$alert_msg="Incorrect Captcha";
	}
}
//apply_edit();
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

</head>

<body >
<!--- short cut form place --->

		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
			  <!--  Basics Forms --><span class="red"><h5> </h5></span>
			  <div class="row-fluid" >
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3></div>
						      <?php include("../include/page_header.php"); ?>
							
							<div class="box-content">
                                 <form method="post" action="" id="form_change_pwd"  autocomplete="off">
<table width="60%" border="0" align="center" style="background:#eee; border-radius:10px">
<tr>
	<td align="right"><p id="message" style="font-size:15px; color:#0000CC; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $alert_msg; ?></p></td>
</tr>
	<tr>
		<td width="28%" align="right" style="color:#31708f; font-weight:bold">USER NAME : </td>
  	  	<td width="72%"><input type="text" class="formboxlong" name="user_name" id="user_name" required style="background:#d9edf7; border-color:#bce8f1; margin-left:15px"></td>
	</tr>
	<tr>
		<td align="right" style="color:#31708f; font-weight:bold">OLD PASSWORD : </td>
		<td><input type="password" class="formboxlong" name="old_password" id="old_password" required style="background:#d9edf7; border-color:#bce8f1; margin-left:15px"></td>
	</tr>
    <tr>
		<td width="28%" align="right" style="color:#31708f; font-weight:bold">NEW PASSWORD : </td>
		<td width="35%"><input type="password" class="formboxlong" name="new_password" id="new_password" required style="background:#d9edf7; border-color:#bce8f1; margin-left:15px"></td>
		<td width="37%">&nbsp;</td>
	</tr>
	<tr>
		<td align="right" style="color:#31708f; font-weight:bold">RETYPE NEW PASSWORD : </td>
		<td><input type="password" class="formboxlong" name="re_new_password" id="re_new_password" onChange="return check_password();" required style="background:#d9edf7; border-color:#bce8f1; margin-left:15px">
		<span class="err" id="re_div" style="color:#660" style="font-size:12px">&nbsp;</span></td>
	</tr>
    <tr>
		<td align="right" style="color:#31708f; font-weight:bold">ENTER CAPTCHA : </td>
		<td><input name="captcha" type="text" class="excelbox" required style="background:#d9edf7; border-color:#bce8f1; margin-left:15px">&nbsp;
		<img src="captcha.php" style="margin-bottom:12px" /></td>
        <tr style="line-height:50px">
        <td>&nbsp;</td>
        <td><input type="submit" name="save" class="btn btn-success" value="Save" style="margin-left:15px;">&nbsp;&nbsp;&nbsp;<input type="reset" value="Clear" name="reset" class="btn btn-danger"></td>
        </tr>
        <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
	</tr>
</table>

</form>

							</div>
						</div>
					</div>
				</div>
                <!--   DTata tables -->
			</div>
		</div>
    </div>
	</body>
	</html>
<?php
mysqli_close($connection);
?>
<script>
$(document).ready(function(){
	$("input#user_name").focus();
	$("input#old_password").focus(function(){
		$(this).val("");
	});
	
});
function check_password()
{
	var cond=true;
	if($("input#new_password").val().trim()!=$("input#re_new_password").val().trim())
	{
		cond=false;
		$("#re_div").html("Password doesn't match");
		$("input#new_password").val("");
		$("input#re_new_password").val("");
		$("input#new_password").focus();
	}
	else
	{
		$("#re_div").html("Password Match");
		return cond;
	}
}
</script>