<?php include("config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>SHIVALI LOGISTICS</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- login -->
    <div class="container">
        <div class="row">
            <div class="col s12 offset-m4 m4">
                <div style="margin-top: 5rem;">
                    <center>
                        <img src="images/img.png" alt="2" class="responsive-img" style="width:150px;">
                    </center>

                    <h4><strong>Welcome</strong></h4>
                    <p>Login to continue.</p>
                    <br />
                    <form id="" action="checklogin.php" method="post">
                        <!-- <form action="dashboard.php" method="post"> -->
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" placeholder="Enter your mobile no." id="mobile" name="mobile" class="validate">
                            <label for="mobile_no">Mobile No.</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input placeholder="Enter your password" id="password" name="password" type="password" class="validate">
                            <label for="mobile_no">Password</label>
                        </div>
                        <div class="input-field ">
                        <i class="material-icons prefix">account_circle</i>
                            <select name="compid" class="form-control email" id="compid" data-rule-required="true" required >
                            <option value="" disabled selected>Select Company</option>
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
                            <!-- <label> Select company</label> -->
                        </div>
                        <div class="input-field ">
                        <i class="material-icons prefix">portrait</i>
                        <select name="sessionid" class="form-control email" id="sessionid" data-rule-required="true" required >
                                <option value="" disabled selected>Select Session</option>
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
                            <!-- <label> Select session</label> -->
                        </div>

                        <!-- <div class="input-field right-align">
                            <a href="forget-password.php">Forget Password?</a>
                        </div> -->
                        <div class="input-field center">
                            <button class="btn waves-effect waves-light green darken-3" type="submit" name="action" style="width: 100%;">Login
                            </button>
                        </div>


                        <!-- <div class="input-field center">
                            <strong> New User ? <a href="registration.php">Register Now</a></strong>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col s12 center">
                <hr>
                <h6 class="social"> Our Social Media</h6>
                <a href="">
                    <img src="images/facebook.png" alt="Facebook" width="50px">
                </a>
                <a href="">
                    <img src="images/instagram.png" alt="Instagram" width="50px">
                </a>
                <a href="">
                    <img src="images/twitter.png" alt="twitter" width="50px">
                </a>
                <a href="">
                    <img src="images/web.png" alt="web" width="50px">
                </a>
            </div>
        </div> -->
    </div>

    <center>
        <div class="chip red white-text">
            <i class="close material-icons left ">phone</i>
            Support No. 81871181892
        </div>
        <p>Powered by <a href="https://chaaruvi.com/" target="_blank"> Chaaruvi Infotech Pvt. Ltd.</a></p>
    </center>
    <!-- script -->
    <script src="js/jquery-3.6.2.min.js"></script>
    <script src="materialize/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
</body>

</html>