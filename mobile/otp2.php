<?php
error_reporting(0);
include("config.php");
include_once("lib/getval.php");
$cmn = new Comman();
 $mobileNumber =$_GET['mobile'];
 $id = $_GET['id'];
 $otp = rand(1000,9999);  $totmo = $cmn->getvalfield($connection,"adduser","count(id)","mobile='$mobileNumber'");
if ($id == '') {
     
     // echo "SELECT * FROM adduser WHERE mobile='$mobileNumber'";
        // $sqlcheckdup = mysqli_query($connection, "SELECT * FROM adduser WHERE mobile='$mobileNumber' ");
        // $check = mysqli_num_rows($sqlcheckdup);
        // if ($check > 0) {
        //     $dup = "<div class='alert alert-danger'>
        //     <strong>Error!</strong> Error : Duplicate Record.
        //     </div>";
        // } 	else{
    echo "update adduser set checkotp='$otp' where mobile='$mobileNumber'";
mysqli_query($connection,"update adduser set checkotp='$otp' where mobile='$mobileNumber'");
        }
// sendsmsGET($mobileNumber,$otp);
if ($_GET['resend']!= '') {
    echo "update adduser set checkotp='$otp' where mobile='$mobile'";
    mysqli_query($connection, "update adduser set checkotp='$otp' where mobile='$mobile'");
    
    sendsmsGET($mobile, $otp);
}
function sendsmsGET($mobileNumber,$otp)
{	
    //API URL
    $url="mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber&message=your%20OTP%20for%20Registration%20is%20$otp%20INFOMAPS&senderid=INFMPS&accusage=1&entityid=1701159947912026600&tempid=1707163490806710927";
	
    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0

    ));


    //get response
    $output = curl_exec($ch);
	
//	print_r($output);
    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

    return $output;
}

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("header_file.php")?>

    <style>
        .otp-input-fields {
            width: auto;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .otp-input-fields input {
            height: 40px;
            width: 40px;
            background-color: transparent;
            border-radius: 4px;
            border: 1px solid #2f8f1f;
            text-align: center;
            outline: none;
            font-size: 16px;
            /* Firefox */
        }

        .otp-input-fields input::-webkit-outer-spin-button,
        .otp-input-fields input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input-fields input[type=number] {
            -moz-appearance: textfield;
        }

        .otp-input-fields input:focus {
            border-width: 2px;
            border-color: #287a1a;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <!-- login -->
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div style="margin-top: 2rem;">
                    <center>
                        <img src="images/otp.svg" alt="Anand Group CG" class="responsive-img">
                        <h5><strong>OTP Verification</strong></h5>
                        <p>Enter your OTP code number.</p>
                    </center>

        
                        <div class="card">
                            <div class="card-content">
                             <span id="errormsg" style="display:none; color:#F00;">OTP not Matched</span>
                                <div class="otp-input-fields center">
                                    <input type="number" class="otp__digit otp__field__1" id="n1">
                                    <input type="number" class="otp__digit otp__field__2" id="n2">
                                    <input type="number" class="otp__digit otp__field__3" id="n3">
                                    <input type="number" class="otp__digit otp__field__4" id="n4">
                                </div>
                                <input type="hidden" id="verificationCode" />
                                <div class="input-field center">
                                    <button class="btn waves-effect waves-light" type="submit" name="verify"
                                        id="verify" style="width: 100%;"  onClick="matchOtp()">Verify
                                    </button>
                                </div>
                            </div>
                        </div>
       
                    <center>
                        <p>Didn't you receive any code? </p>
                     
                       <a href="otp2.php?mobile=<?php echo $_GET['mobile'] ?>&resend=resend"  class="btn-flat teal-text"><strong>Resend New Code</strong></a>

                        
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- script -->
    <?php include("footer_file.php")?>
    <script src="js/jquery-3.6.2.min.js"></script>
    <script src="materialize/js/materialize.min.js"></script>
    <script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function () {
            window.setTimeout(document.querySelector('img').classList.add('animated'), 1000);
        });

        var otp_inputs = document.querySelectorAll(".otp__digit");
        $('#verify').prop('disabled', true);
        var mykey = "0123456789".split("")
        otp_inputs.forEach((_) => {
            _.addEventListener("keyup", handle_next_input)
        })
        function handle_next_input(event) {
            let current = event.target
            let index = parseInt(current.classList[1].split("__")[2])
            current.value = event.key

            if (event.keyCode == 8 && index > 1) {
                current.previousElementSibling.focus()
            }
            if (index < 4 && mykey.indexOf("" + event.key + "") != -1) {
                var next = current.nextElementSibling;
                next.focus()
            }
            var _finalKey = ""
            for (let { value } of otp_inputs) {
                _finalKey += value
            }
            if (_finalKey.length == 4) {
                $('#verify').prop('disabled', false);
            } else {
                $('#verify').prop('disabled', true);
            }
        }

    </script>
    <script>
	function matchOtp(){
	  var n1 = document.getElementById('n1').value;
	   var n2 = document.getElementById('n2').value;
	    var n3 = document.getElementById('n3').value;
		 var n4 = document.getElementById('n4').value;
		 var otp=n1+n2+n3+n4;
	
	    var mobile = '<?php echo $mobileNumber;?>';
        
	$.ajax({
			type: 'POST',
			url: 'matchotp.php',
			 data: 'mobile=' + mobile + '&otp=' + otp,
			dataType: 'html',
			success: function(data){              
                // alert(data);				
				if(data==0){					
				$("#errormsg").show();					 
				}else{
					$("#errormsg").hide();
					location='repassword.php?mobile=<?php echo $mobileNumber;?>';
				}
			}
			});//ajax close
	}

   
	</script>
</body>

</html>