<?php include("../../dbinfo.php");
include("../../lib/getval.php");
include("../../lib/dboperation.php");
$cmn = new Comman();
$curdate= date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($curdate)));
$yesterday = date('Y-m-d', strtotime($curdate . ' -1 day'));
$sessionid = $cmn->getvalfield($connection,"m_session","sessionid","'$curdate' between start_date and end_date");


$todaybilty = $cmn->getvalfield($connection,"bidding_entry","count(*)","gr_date='$curdate' && sessionid='$sessionid' && is_bilty=1");

$todaycashadv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other+ adv_consignor)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1");

$todaydieseladv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1");


$todaypayment = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$curdate' && sessionid='$sessionid'");

$total_pending_bilty_rec = $cmn->getvalfield($connection,"bidding_entry","count(*)","is_bilty=1 && sessionid='$sessionid' && isreceive=0");

$total_pending_bidding = $cmn->getvalfield($connection,"bidding_entry","count(*)","sessionid='$sessionid' && is_bilty=0");
?>
<!DOCTYPE html>
<html>
<title>Transport</title>
<?php include("../pages/headerfile.php"); ?>
<style>
body {font-family: "Roboto", sans-serif}
.w3-bar-block .w3-bar-item{padding:16px;font-weight:bold}
</style>
<script src="../js/jquery-3.2.1.min.js"></script>

<body>
<?php 
//include("../pages/menues.php");
?>
<div class="w3-overlay w3-hide-large w3-animate-opacity" onClick="w3_close()" style="cursor:pointer" id="myOverlay"></div>
<div class="w3-main" style="margin-left:250px;">
<div id="myTop" class="w3-container w3-top w3-theme w3-large">
  <p><i class="fa fa-bars w3-button w3-teal w3-hide-large w3-xlarge" onClick="w3_open()"></i>
  <span id="myIntro" class="w3-hide"> Sarthak Logistics</span></p>
</div>
<header class="w3-container w3-theme">
  <p> Sarthak Logistics</p>
</header>
  <br>


<a style="text-decoration:none;" href="emami_payment_request.php" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-green" style="text-align:center" >
      
    <h4> Emami Payment Request</h4>
    
    </li>       
  </ul>
</div> 
 </a>
 
   
<a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Plant Opening Balance</h4>
     <?php echo $cmn->getcashopeningplant($connection,$curdate); ?>
    </li>       
  </ul>
</div> 
 </a>
 
 <a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Cash In Hand</h4>
       <?php echo $cmn->getcashopeningplant($connection,$tomorrow); ?>	
    </li>       
  </ul>
</div> 
 </a>
 
 
 
<a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Today Cash Advance</h4>
       <?php echo $todaycashadv; ?>
    </li>       
  </ul>
</div> 
 </a>
 
 <a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Today Diesel Advance</h4>
       <?php echo $todaydieseladv; ?>
    </li>       
  </ul>
</div> 
 </a>

<a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Today Cash Payment</h4>
       <?php echo $todaypayment; ?>
    </li>       
  </ul>
</div> 
 </a>
 
  
<a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Total Pend. Bilty To Receive</h4>
       <?php echo $total_pending_bilty_rec; ?>
    </li>       
  </ul>
</div> 
 </a>


<a style="text-decoration:none;" >
<div class="w3-container w3-padding w3-border w3-round-small" >
   <ul class="w3-ul w3-card-4">
    <li class="w3-bar w3-light-blue" style="text-align:center" >
      
    <h4>Total Pending Bidding</h4>
       <?php echo $total_pending_bidding; ?>
    </li>       
  </ul>
</div> 
 </a>
 
 <br>
<br>


 <table class="w3-table" border="1">
<tr class="w3-green" >
  		      
        <th>Owner Name</th>
        <th> Advance</th>
        <th style="text-align:center;">Bilty Amt</th>   
</tr>

<?php 
$slno=1;
$tot_amt=0;
 $sel = "select A.*,DATE_FORMAT(A.tokendate,'%Y-%m-%d') as billdate,B.ownerid from bidding_entry as A left join m_truck as B on A.truckid=B.truckid where  A.recweight !='0'  && B.ownerid !=2 &&  isconf=0 && is_reminder=1 order by bid_id desc";
        $res = mysqli_query($connection,$sel);
        while($row = mysqli_fetch_array($res))
        {
        $truckid = $row['truckid'];	
		$bid_id = $row['bid_id'];
		$billtydate= $row['billdate'];
        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");	
		$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");	 
		$mobileno1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");	 
		$amount = $row['totalweight'] * $row['own_rate'];										
		//$final_amount = $amount - $row['adv_cash'] - $row['adv_diesel'] - $row['adv_cheque'] - $row['commission']-$row['tds_amt']-$row['deduct'];
		$final_amount = $row['fpay'];
        ?>
        <tr style="border:3px solid #333">
              
                  
        <td><?php echo $truckno;?> <br><?php echo $row['truckowner'];?> <br>
 			<?php echo $mobileno1; ?><br><?php echo $cmn->dateformatindia($billtydate); ?>  </td>
        <td>C- <?php echo $row['adv_cash']; ?> <br/>
        	D- <?php echo $row['adv_diesel']; ?><br>
            CQ- <?php echo $row['adv_cheque']; ?>
            </td>
        <td style="text-align:right;"><?php echo number_format($final_amount,2);?></td>
        
        </tr>
        <?php
        $slno++;
		
		$tot_amt += $final_amount;
        }
        ?>
		<tr class="w3-green" >  		      
                <th colspan="2" style="text-align:right;">Total</th>                
                <th style="text-align:right;"><?php echo number_format($tot_amt,2); ?></th>   
		</tr>
</table>
 
  
 
 <br>
<br>
<br>

<?php 
include("../pages/footerfiles.php");
//include("../pages/footer.php");

?>



</div>


   
</body>
</html> 