<?php error_reporting(0);
include("adminsession.php");
$pagename = "dashboard.php";
include("lib/dboperation.php");
		include_once("lib/getval.php");
        date_default_timezone_set("Asia/Kolkata");
include("dbconnect.php");
//print_r($_SESSION);

include("../lib/smsinfo.php");


$sql = mysqli_query($connection,"select otpcode from get_otp where 1=1");
$row=mysqli_fetch_assoc($sql);
$otpcode = $row['otpcode'];
$curdate= date('Y-m-d');
 $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($curdate)));
$yesterday = date('Y-m-d', strtotime($curdate . ' -1 day'));


$todaybilty = $cmn->getvalfield($connection,"bidding_entry","count(*)","tokendate='$curdate' && sessionid='$sessionid' && is_bilty=1 and compid ='$compid' ");

$countbilling =  $cmn->getvalfield($connection,"bidding_entry","count(*)","voucher_id!='0' && sessionid='$sessionid' && compid ='$compid' "); 

$countbillingpending =  $cmn->getvalfield($connection,"bidding_entry","count(*)","voucher_id='0' && sessionid='$sessionid' && compid ='$compid'"); 





$todaycashadv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' "); 


$todaydieseladv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid'");



$todaypayment = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$curdate' && sessionid='$sessionid' and compid ='$compid' ");

$total_pending_bilty_rec = $cmn->getvalfield($connection,"bidding_entry","count(*)","is_bilty=1 && sessionid='$sessionid' && isreceive=0 and compid ='$compid' ");

$total_pending_bidding = $cmn->getvalfield($connection,"bidding_entry","count(*)","sessionid='$sessionid' && is_bilty=0 and compid ='$compid'");




$todaybilty_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","tokendate='$curdate' && sessionid='$sessionid' && is_bilty=1 and compid ='$compid'");

$todaycashadv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other+ adv_consignor)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' ");

$todaydieseladv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' ");


$todaypayment_emami = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$curdate' && sessionid='$sessionid' and compid ='$compid' ");

$total_pending_bilty_rec_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","is_bilty=1 && sessionid='$sessionid' && isreceive=0 and compid ='$compid' ");

$total_pending_bidding_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","sessionid='$sessionid' && is_bilty=0 and compid ='$compid'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIVALI LOGISTICS</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .collection .collection-item.avatar {
            min-height: 60px;
            padding-left: 15px;
            position: relative;
        }

        body {
            background: aliceblue;
        }

        .collection-item span.badge {
            margin-top: 8px !important;
        }
    </style>
</head>

<body>
    <!-- Topmenu -->
    <?php include('include/header.php'); ?>
    <!-- Topmenu Close -->
    <!-- Sidemenu -->
    <?php include('include/leftmenu.php'); ?>
    <!-- Sidemenu close -->
    <div class="container">
    <div class="row">

<div class="col s12 offset-m3 m6">
                <blockquote>
                    <h6><strong>Dashboard</strong>
          
                  <b></b></h6>
                </blockquote>


<P></p>

    
    <div class="row">
        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="todaybilty.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src="" alt="Total User" class="circle"> -->
                    <span class="title"><strong>	<?php echo isset($todaybilty) ? $todaybilty : '0' ; ?></strong></span>
                    <p> Today Bilty
                    </p>
                </a>
            </div>
        </div>
        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="todaybilltyadv.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src=""  class="circle"> -->
                    <span class="title"><strong><?php echo isset($todaycashadv) ? $todaycashadv : '0' ; ?></strong></span>
                    <p> Today Cash Advance
                    </p>
                </a>
            </div>
        </div>
       
        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="todaybiltypayment.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src="images/delivery-truck.png" alt="रोजनामचा रिपोर्ट" class="circle"> -->
                    <span class="title"><strong><?php echo round($todaypayment); ?></strong></span>
                    <p> Today Bilty Payment
                    </p>
                </a>
            </div>
        </div>
        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="todaydisptch.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src="images/mitti.png" alt="Total User" class="circle"> -->
                    <span class="title"><strong><?php 
										$grannd='';
										 $dateToday=date('Y-m-d');
											 $tdq="SELECT totalweight FROM `bidding_entry` WHERE tokendate ='$dateToday'";
											 	$res_tdq = mysqli_query($connection,$tdq);
	while($row_tdq = mysqli_fetch_array($res_tdq))
	{ 
			$total_weight=$row_tdq['totalweight'];
			@$grannd +=$total_weight;
	}
										 if($grannd!=''){
										 	echo @$grannd." MT";
										 }else{
										 	echo "0 MT";
										 } ?></strong></span>
                    <p> Today Dispatch Qty
                    </p>
                </a>
            </div>
        </div>

        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="biltypendingreport.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src="images/mitti.png" alt="Total User" class="circle"> -->
                    <span class="title"><strong><?php echo $total_pending_bilty_rec; ?></strong></span>
                    <p> Pending Bilty To Rec.
                    </p>
                </a>
            </div>
        </div>

        <div class="col s6">
            <div class="collection z-depth-1">
                <a href="currentmonthdis.php" class="collection-item avatar black-text borderleft">
                    <!-- <img src="images/mitti.png" alt="Total User" class="circle"> -->
                    <span class="title"><strong>	<?php 
										$granndMonth='';
										 $dateToday=date('m');
										 $currentYear=date('Y');

											  $tdqMonth="SELECT totalweight FROM `bidding_entry` WHERE tokendate BETWEEN '$currentYear-$dateToday-01' AND '$currentYear-$dateToday-31'";
											 	$res_tdqMonth = mysqli_query($connection,$tdqMonth);
	while($row_tdqMonth = mysqli_fetch_array($res_tdqMonth))
	{ 
			$total_weightMonth=$row_tdqMonth['totalweight'];
			@$granndMonth +=$total_weightMonth;
	}
										 if($granndMonth!=''){
										 	echo @$granndMonth." MT";
										 }else{
										 	echo "0 MT";
										 } ?></strong></span>
                    <p>  Current Month Dis.
                    </p>
                </a>
            </div>
        </div>
        </div>
        


         <div class="collection z-depth-1">
                    <a href="#" class="collection-item avatar black-text">

                        <span class="title"><strong>OTP</strong>
                            <span class="badge red white-text badge" style="margin-right: 60px;font-size: 1.2rem;"><?php echo ($otpcode); ?></span>
                    <!-- <span class="title"><strong></strong></span> -->

                        </span>
                        <p>View OTP No.
                        </p>
                        <span class="secondary-content"><i class="material-icons green-text darken-3">send</i></span>
                    </a>
                </div>
                <center><a href="dashboard.php" class="btn green darken-3"><i class="material-icons left">cached</i> Refresh</a></center>
    </div>
</div>

</div>



        <!-- footer navigation -->
        <?php //include('include/footer.php'); 
        ?>
        <!-- script -->
        <script src="js/jquery-3.6.2.min.js"></script>
        <script src="materialize/js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.sidenav').sidenav();
            });
        </script>
</body>

</html>