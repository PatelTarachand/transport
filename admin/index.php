<?php 
error_reporting(0);
include("../dbinfo.php");
include("../lib/getval.php");
$cmn= new Comman();

$curdate = date('Y-m-d');

$todaycashadv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other+ adv_consignor)","adv_date='$curdate'  && isdispatch=1 && consignorid=4");

$todaydieseladv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate'   && isdispatch=1 && consignorid=4");


$todaycashadv_shree = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other + adv_consignor)","adv_date='$curdate'   && isdispatch=1 && consignorid!=4");

$todaydieseladv_shree = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate'   && isdispatch=1 && consignorid!=4");


?>
<!DOCTYPE html>
<html>
<title>Sarthak Logistics</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>

<style>
.btn {
  border: none;
  color: white;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
}

.success {background-color: #4CAF50;} /* Green */
.success:hover {background-color: #46a049;}

.info {background-color: #2196F3;} /* Blue */
.info:hover {background: #0b7dda;}

.warning {background-color: #ff9800;} /* Orange */
.warning:hover {background: #e68a00;}

.danger {background-color: #f44336;} /* Red */ 
.danger:hover {background: #da190b;}

.default {background-color: #e7e7e7; color: black;} /* Gray */ 
.default:hover {background: #ddd;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onClick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Sarthak</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="img/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong>Mike</strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onClick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Overview</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Views</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i>  Traffic</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bullseye fa-fw"></i>  Geo</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-diamond fa-fw"></i>  Orders</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i>  News</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw"></i>  General</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onClick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <input type="text" id="hiddenid" value="" >
  <div class="w3-container">
   <h5><b><i class="fa fa-dashboard"></i> Payment Approval Request</b></h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white">
    	
       <tr>
        <td> 
<label style="font-weight:bold; color:#900"><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" class="w3-check" />All</td>
        <td style="font-weight:bold; color:#900">TRUCK DEATAILS</td>
<?php 
$slno = 1;
$sql = mysqli_query($connection,"select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry where  is_complete=1 && isconf=0 && consignorid =4 && payment_date !='0000-00-00'");
while($row=mysqli_fetch_assoc($sql)) {

$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'");
$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
$ownernamemobileno = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
?>
 
      <tr>
       <td><input type="checkbox" name="chk<?php echo $slno; ?>" id="chk<?php echo $slno; ?>" onClick="addids()" value="<?php echo $row['bid_id']; ?>"  class="w3-check" />
 </td>

        <td><button onClick="myFunction('Demo<?php echo $row['bid_id']; ?>')" class="w3-button"><i class="fa fa-truck"></i> <?php echo $truckno; ?>  (EMAMI)&nbsp;&nbsp;&nbsp; :: &nbsp;&nbsp;&nbsp; <i class="fa fa-inr"></i> <?php echo number_format($row['cashpayment']+$row['chequepayment']+$row['neftpayment'],2);?>  </button>

                <div id="Demo<?php echo $row['bid_id']; ?>" class="w3-hide w3-container">
                   <div class="w3-panel w3-pale-blue w3-leftbar w3-border-blue">
                   <table class="w3-table">
                    
                    <tr>
                      <td>DI NO . <?php echo $row['di_no']; ?> </td>
                      <td>DI DATE- <?php echo $row['tokendate']; ?></td>
                    </tr>
                    <tr>
                      <td>ADV- <?php echo number_format($row['adv_cash']+$row['adv_diesel']+$row['adv_other']+$row['adv_consignor']+$row['adv_cheque'],2);?></td>
                      <td>ITEM - <?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$row[itemid]'"); ?></td>
                    </tr>
                    <tr>
                      <td>OWNER - <?php echo $ownername; ?></td>
                      
                      <td>MOBILE - <?php echo $ownernamemobileno; ?></td>
                    </tr>
                    
                    <tr>
                      <td>FROM - <?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[placeid]'"); ?></td>
                      
                      <td>TO  - <?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                    </tr>
                  </table>
                  </div>
                
                </div>
</td>
   
      </tr>
      
 <?php
 $slno++;
 }
 ?> 
       
    </table><br>
 <button class="btn success" onClick="status(1)">Approved</button>

<button class="btn danger" onClick="status(2)">Reject</button>

  </div>
  <hr>
  <div class="w3-container">
    <h5>Recent Updates</h5>
    <ul class="w3-ul w3-card-4 w3-white">
      <li class="w3-padding-16">
       
        <span class="w3-xlarge">Emami Cash Advance - <?php echo number_format($todaycashadv_emami,2) ?> </span><br>
      </li>
      
      <li class="w3-padding-16">
       
        <span class="w3-xlarge">Emami Diesel Advance - <?php echo number_format($todaydieseladv_emami,2) ?> </span><br>
      </li>
      
      <li class="w3-padding-16">
       
        <span class="w3-xlarge">Shree Cash Advance - <?php echo number_format($todaycashadv_shree,2) ?></span><br>
      </li>
      
      <li class="w3-padding-16">
       
        <span class="w3-xlarge">Shree Diesel Advance - <?php echo number_format($todaydieseladv_shree,2) ?></span><br>
      </li>
      
    </ul>
  </div>
  <hr>

  
  

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4>Sarthak Logistics</h4>
    <p>Powered by <a href="#" target="_blank">CHAARUVI INFOTECH</a></p>
  </footer>

  <!-- End page content -->
</div>

<script>


function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}





function addids()
{
    strids="";
    var cbs = document.getElementsByTagName('input');
    var len = cbs.length;
    for (var i = 1; i < len; i++)
    {
         if (document.getElementById("chk" + i)!=null)
         {
              if (document.getElementById("chk" + i).checked==true)
              {
                   if(strids=="")
                   strids=strids + document.getElementById("chk" + i).value;
                   else
                   strids=strids + "," + document.getElementById("chk" + i).value;
               }
          }
     }
	// alert(strids);
     document.getElementById("hiddenid").value = strids;
}

function toggle(source)
{
	//alert(source);
	if(source == true)
	{
		//alert("hi");
		var cbs = document.getElementsByTagName('input');
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = true;
			}
		}
		addids()
	}
	else
	{
		//alert("hello");
		var cbs = document.getElementsByTagName('input');
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = false;
			}
		}
		addids()
		
	}
}	 


function status(status) {
 var ids = document.getElementById('hiddenid').value;	
 
	$.ajax({
		type: 'POST',
		url: 'save_status.php',
		data: 'status='+status+'&ids='+ids,
		dataType: 'html',
		success: function(data){
		 //alert(data);  
	 location.reload();
		
		}
	
	});//ajax close
  
  
}

</script>

</body>
</html>
