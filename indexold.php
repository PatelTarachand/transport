<?php 
include("dbinfo.php");
include("lib/getval.php");
 $cmn = new Comman();
 $msg='';
 $exp_msg='';
 $error_msg='';	
 $msg1='';
if(isset($_GET['msg']))
{
	$msg=trim(addslashes($_GET['msg']));	
}

if($msg=="wrong")
{
	$error_msg = "Wrong Username or Password";
}

if($msg=="invalid")
{
	$error_msg = " ";
}


if(isset($_GET['msg1']) && $_GET['msg1']!="")
$msg1 = addslashes(trim($_GET['msg1']));
$curr_date=date('Y-m-d');
$expiry_date =$cmn->getvalfield($connection,"panel_expiry","expiry_date","1=1");

	$expirydate=strtotime($expiry_date); 
	$currdate=strtotime($curr_date);

	if($currdate >= $expirydate)
	{
		$exp_msg= '0';
	}
	else
	{
		$exp_msg= '0';
	}
	
	
?>
<!doctype html>
<html>
<head>
	<?php include"include/login_files.php"; ?>
  
    
    
    
   

</head>

<body class='login' >
	<div class="wrapper">
		<a href="index.php">        
        <h4 style="color:#FFF; text-shadow:2px 2px 3px #039;">
        <img src="img/logo-big.png" alt="" class='retina-ready' width="40" height="30">&nbsp;  Sarthak TRANSPORT </h4>
       
        </a>
		<div class="login-body">
			<h2>SIGN IN</h2>
			<form action="check_login.php" method='post' class='form-validate' id="test" autocomplete="off">
				<div class="control-group">
					<div class="email controls">
						<input type="text" name="user_name" id="user_name" placeholder="User Name" class='input-block-level' data-rule-required="true" autofocus>
					</div>
				</div>
				<div class="control-group">
					<div class="pw controls">
						<input type="password" name="password" id="password" placeholder="Password" class='input-block-level' data-rule-required="true">
					</div>
				</div>
                
                <div class="control-group">
					<div class="pw controls">
						<select name="sessionid" id="sessionid" data-rule-required="true">
                        <option value="">- Select Session -</option>
                        <?php
						$res = mysqli_query($connection,"Select sessionid,session_name from m_session order by sessionid desc");
						if($res)
						{
							while($row = mysqli_fetch_array($res))
							{
						?>
                        <option value="<?php echo $row['sessionid']; ?>"><?php echo $row['session_name']; ?></option>
                        <?php
							}
						}
						?>
                        </select>
					</div>
				</div>
                
                <div class="control-group">
					<div class="pw controls">
                
                     
                       <input name="captcha_code" id="captcha_code" placeholder="Enter Captcha" type="text" class='input-block-level' style="width:150px;" maxlength="4"  data-rule-required="true" />
                        <img src="chapcha.php" id='captchaimg' style="padding-bottom:10px"/>
                     </div>
                </div>
                
                 <?php 
					if($exp_msg=='1')
					{
					?>
                    
                    <strong style="color:#F00;">Your Panel has been Expired,Plz Contact : <br> &nbsp; &nbsp;8871181890
</strong> 
					<?php } ?>
                
                <div class="control-group">
					<div class="pw controls">
                    <label><span class="red"><?php echo $error_msg; ?></span><span class="red"><?php echo $msg1; ?></span></label>
					</div>
				</div>
				<div class="submit">
					<input type="submit" name="login" value="Sign me in" class='btn btn-primary'>
				</div>
			</form>
			<div class="forget">
				<a href="#" onClick="myFunction()"><span>Forgot password?</span></a>
			</div>
		</div>
	</div>
    
<marquee style="font-weight:bold; color:#FFF;" scrolldelay="200">This Software is Under Construction. If You Have Any Query Please Feel Free To Ask - +91-8871181890</marquee>
    
<script>
function myFunction() {
    alert("Contact To Administrator \n +91-8871181890");
}
</script>

	
	
    
</body>

</html>
<?php
mysqli_close($connection);
?>