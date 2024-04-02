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
$username =$cmn->getvalfield($connection,"m_userlogin","username","1=1");
$password =$cmn->getvalfield($connection,"m_userlogin","password","1=1");

$cname =$cmn->getvalfield($connection,"m_company","cname","compid=2");
$session_name =$cmn->getvalfield($connection,"m_session","session_name","sessionid=7");
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
<!DOCTYPE html>
<html lang="zxx">
  
<head>
  <!-- Basic Page Needs
  ================================================== -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- For Search Engine Meta Data  -->
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="yoursite.com" />
	
  <title>E-TRANSPORT SOLUTION :: +91-88711818190</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/icon" href="newimages/favicon-16x16.html"/>
   
  <!-- Main structure css file -->
  <link  rel="stylesheet" href="newcss/login3-style.css">
  
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if IE]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
  @-webkit-keyframes blinker {
  from {opacity: 1.0;}
  to {opacity: 0.0;}
}
.blink{
	text-decoration: blink;
	-webkit-animation-name: blinker;
	-webkit-animation-duration: 1s;
	-webkit-animation-iteration-count:infinite;
	-webkit-animation-timing-function:ease-in-out;
	-webkit-animation-direction: alternate;
}
  </style>
  
  
  
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script id="hostingsHelper" hosting-id="114" src="https://hostpayu.chaaruvi.com/public/js/host.js"></script>
<div class="hostingsHelper"></div>




  </head>
  
  <body>
    <!-- Start Preloader -->
    <div id="preload-block">
      <div class="square-block"></div>
    </div>
    <!-- Preloader End -->
    
    <div class="container-fluid">
      <div class="row">
        <div class="authfy-container col-xs-12 col-sm-10 col-md-8 col-lg-6 col-sm-offset-1 col-md-offset-2 col-lg-offset-3">
          <div class="col-sm-5 authfy-panel-left">
            <div class="brand-col">
              <div class="headline">
                <!-- brand-logo start -->
                <div class="brand-logo">
                  <img src="ets.png" style="width:200PX;" alt="brand-logo">
                </div><!-- ./brand-logo -->
                <p style="text-align:justify">HELPS TO PERFECTLY MANAGE YOUR TRANSPORTATION ACTIVITIES</p>
                
                <a href="http://etransportsolution.com/" class="blink" target="_blank" style="color:#FFF; font-weight:bold">click here for more details</a>
                <!-- social login buttons start -->
                <div class="row social-buttons">
                  
                  
                  <div class="col-xs-4 col-sm-4 col-md-12">
                    <a href="#" class="btn btn-block btn-google">
                      <i class="fa fa-phone"></i> <span class="hidden-xs hidden-sm">
                      +91-8871181890</span>
                    </a>
                  </div>
                  
                  <div class="col-xs-4 col-sm-4 col-md-12">
                    <a href="#" class="btn btn-block btn-facebook">
                      <i class="fa fa-facebook"></i> <span class="hidden-xs hidden-sm">
                      ETS on facebook</span>
                    </a>
                  </div>
                </div><!-- ./social-buttons -->
              </div>
            </div>
          </div>
          <div class="col-sm-7 authfy-panel-right">
            <!-- authfy-login start -->
            <div class="authfy-login">
              <!-- panel-login start -->
              <div class="authfy-panel panel-login text-center active">
                <!--<div class="authfy-heading">
                  <h3 class="auth-title">Login to your account</h3>
                  
                </div>-->
                <div class="row">
                  <div class="col-xs-12 col-sm-12">
                    <form name="loginForm" class="loginForm" action="check_login.php" method="POST">
                      <div class="form-group">
                        <input type="Text" class="form-control email" name="user_name" value="<?php echo $username;?>" placeholder="User Name"  required >
                      </div>
                      <div class="form-group">
                        <div class="pwdMask">
                          <input type="password" class="form-control password" name="password" value="<?php echo $password;?>" placeholder="Password" required>
                          <span class="fa fa-eye-slash pwd-toggle"></span>
                        </div>
                      </div>
                      
                      	
                     <div class="form-group">
                       <select name="compid" class="form-control email" id="compid" data-rule-required="true" required >
                        <option value="">- Select Company -</option>
                     
                        <?php
						$res = mysqli_query($connection,"Select compid,cname from m_company order by compid desc");
						if($res)
						{
							while($row = mysqli_fetch_array($res))
							{
						?>
                        <option value="<?php echo $row['compid']; ?>"><?php echo $row['cname']; ?></option>
                        <?php
							}
						}
						?>
						</select>
                      </div>
                      
                      <div class="form-group">
                       <select name="sessionid" class="form-control email" id="sessionid" data-rule-required="true" required >
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
                      
                   <div class="form-group">
                     
                       <input name="captcha_code" id="captcha_code" placeholder="Enter Captcha" type="text" class='input-block-level'  maxlength="4"  data-rule-required="true" style="border-radius: 30px !important; height: 36px; padding-left:15px; width:150px;"/>
                        <img src="chapcha.php" id='captchaimg' style="padding-bottom:10px"/>
                      </div>
					  
					  <div class="control-group">
					<div class="pw controls">
                    <label><span class="red"><?php echo $error_msg; ?></span><span class="red"><?php echo $msg1; ?></span></label>
					</div>
				</div>
                </div>
                      
                      <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">Login</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div> <!-- ./panel-login -->
           
            </div> <!-- ./authfy-login -->
          </div>
        </div>
      </div> <!-- ./row -->
    </div> <!-- ./container -->
    
    <!-- Javascript Files -->

    <!-- initialize jQuery Library -->
    <script src="newjs/jquery-2.2.4.min.js"></script>
  
    <!-- for Bootstrap js -->
    <script src="newjs/bootstrap.min.js"></script>
  
    <!-- Custom js-->
    <script src="newjs/custom.js"></script>
  
  </body>	

</html>
