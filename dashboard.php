<?php
date_default_timezone_set("Asia/Kolkata");
include("dbconnect.php");
//include("../lib/smsinfo.php");
?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
    <script>
		$(document).ready(function(){
				$("#return").hide();				   
			$("#ambujabtn").click(function(){ 
				$("#return").hide();
				$("#ambuja").show();
			});
			$("#returnbtn").click(function(){
				$("#return").show();
				$("#ambuja").hide();
			});
		});	
		
	</script>
   
</head>

<body data-layout-topbar="fixed">
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
	  <div class="container-fluid">
				<div class="page-header" style="margin-right:150px;">
					<div class="pull-left">
                   
					<!--	<h1 style="font-family:Copperplate Gothic Light">Singh Roadlines </h1>-->
					</div>
					<div class="pull-right">
						<ul class="stats">
                        	<li class='satblue' style="cursor:pointer;"  id="ambujabtn" >
								<i class="icon-file"></i>
								<div class="details" >
									<a href="#" ><span style="font-size:18px">Ambuja Cement</span></a>
                                    <!--<span style="text-align:center"><?php // echo "ABh"; ?></span>-->
								</div>
							</li>
                            <li class='satgreen' style="cursor:pointer;" id="returnbtn">
								<i class="icon-file"></i>                               
								<div class="details">
									<a href="#" ><span style="font-size:18px">Return Dispatch</span></a>
                                    <span style="text-align:center"><?php echo "0"; ?></span>
								</div>
                               
							</li>
							<li class='pink' style="cursor:pointer">
								<i class="icon-file-text"></i>                               
								<div class="details">
									<a href="#"><span style="font-size:20px">Jaypee Bhilai</span></a>
                                    <span style="text-align:center"><?php echo "0"; ?></span>
								</div>
							</li>
                            <li class='orange' style="cursor:pointer">
								<i class="icon-lock"></i>
                               
								<div class="details">
									<a href="#"><span style="font-size:20px">Last Login</span></a>
                                    <span style="text-align:center">
									<?php 
									$sql = mysqli_query($connection,"select login_logout_time from logs_loginreport where sessionid ='$_SESSION[branchid]' limit 1 offset 1");
									if($sql)
									{
										$row = mysqli_fetch_assoc($sql);
										//$lastlog = $cmn->getvalfield($connection,"logs_loginreport","login_logout_time","logid ='$_SESSION[lastlogin]' ");
										$lastlog = $row['login_logout_time'];
										echo $cmn->dateFullToIndia($lastlog,"full");
									}
									?></span>
								 </div>
                            
							</li>
							<li class='lightred'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>
                    
				</div>
                <div style="width:1050px; border:1px sold #000"> 
                <div id="ambuja"> 
             
               		 <div style="border:0px solid #000;width:100%; margin-left:80px; border-radius:15px; padding:0px;">
               			  <ul class="tiles">
							<li class="blue long">
								<a href="#"> <span style="font-size:25px; font-weight:bold"><?php echo $total_billty; ?></span><span class='name'>All Billty-Ambuja Cement</span></a>
							</li>
							<li class="blue long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_billty_recvd; ?></span><span class='name'>All Received Billty-Ambuja Cement</span></a>
							</li>
							<li class="blue long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_bills; ?></span><span class='name'>All Bills-Ambuja Cement</span></a>
							</li>
							<li class="blue long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_bills_received; ?></span><span class='name'>All Received Bills-Ambuja Cement</span></a>
							</li>
							
						</ul>
					</div>
        		</div><!-- Ambuja bility information-->
                
                <div id="return"> 
                <?php
			
				?>
               		 <div style="border:0px solid #000;width:100%; margin-left:80px; border-radius:15px; padding:0px;">
               			  <ul class="tiles">
							<li class="green long">
								<a href="#"> <span style="font-size:25px; font-weight:bold"><?php echo $total_billty; ?></span><span class='name'>All Billty-RETURN TRIP</span></a>
							</li>
							<li class="green long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_billty_recvd; ?></span><span class='name'>All Received Billty-RETURN TRIP</span></a>
							</li>
							<li class="green long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_bills; ?></span><span class='name'>All Bills-RETURN TRIP</span></a>
							</li>
							<li class="green long">
								<a href="#"><span style="font-size:25px; font-weight:bold"><?php echo $total_bills_received; ?></span><span class='name'>All Received Bills-RETURN TRIP</span></a>
							</li>
							
						</ul>
					</div>
        		</div><!-- v return bility information-->
                </div>
			</div>
           
            <div><!--trucks & dashboard  main div -->
        <!--trucks & dashboard  main div end -->
			  <style>
              .permit              {                  background:#9FF;              }
              .insurance              {                  background:#FCF;              }
              .fitness              {                  background:#6CF;              }
              .road              {                  background:#99F;              }
			  .national              {                  background:#969;              }
              </style>      
        <!-- trucks Alert start-->
<div class="truck_alerts" style="float:left; margin-left:75px; margin-top:20px; background:#FFF;">




<div class="head" align="center"> 
 <strong>Trucks Permit Alerts: </strong>
</div>
<!--span id="scroll_up_span" style="float:right; margin-right:5px; cursor:pointer;">Up</span-->
<div class="headbody" style="overflow-y:scroll; height:420px">
    <ul class="" style="list-style:none">
   
        <li class="permit"> 
            
            <div >
                 <strong style="color:#00C">Truck No. <?php echo $row_per['truckno']; ?></strong><br />
                Permit Exp:: <?php echo $cmn->dateformatindia($row_per['expirydate']); ?>
                </div>
        </li>
         
    </ul>
    
</div>        	<!--span id="scroll_down_span" style="float:right; margin-right:5px; cursor:pointer;">Down</span-->        
</div>

<div class="truck_alerts" style="float:left; margin-top:20px;">
<div class="head" align="center"> 
 <strong>Insurance Alerts: </strong>
</div>
<!--span id="scroll_up_span" style="float:right; margin-right:5px; cursor:pointer;">Up</span-->
<div class="headbody" style="overflow-y:scroll; height:420px">
    <ul class="" style="list-style:none; " >
      
        <li class="insurance"> 
             <div style="padding:3px 3px 5px 3px;float:left;">
                <img src="images/truck.png" width="32"  />
            </div>
            <div >
                 <strong style="color:#00C">Truck No. <?php echo $row_per['truckno']; ?></strong><br />
                Insurance Exp:: <?php echo $cmn->dateformatindia($row_per['expirydate']); ?>
                </div>
        </li>
        
    </ul>
    
</div>        	<!--span id="scroll_down_span" style="float:right; margin-right:5px; cursor:pointer;">Down</span-->        
</div>

<div class="truck_alerts" style="float:left; margin-top:20px;">
<div class="head" align="center"> 
 <strong>Fitness Alerts: </strong>
</div>
<!--span id="scroll_up_span" style="float:right; margin-right:5px; cursor:pointer;">Up</span-->
<div class="headbody" style="overflow-y:scroll; height:420px">
    <ul class="" style="list-style:none">
    
        <li class="fitness"> 
            <div style="padding:3px 3px 5px 3px;float:left;">
                <img src="images/truck.png" width="32"  />
            </div>
            <div >
                 <strong style="color:#00C"> Truck No. <?php echo $row_per['truckno']; ?></strong><br />
                Fitness Exp::  <?php echo $cmn->dateformatindia($row_per['expirydate']); ?>
                </div>
        </li>
       
        
      
    </ul>
    
</div>        	<!--span id="scroll_down_span" style="float:right; margin-right:5px; cursor:pointer;">Down</span-->        
</div>

<div class="truck_alerts" style="float:left; margin-top:20px;">
<div class="head" align="center"> 
 <strong>Road Tax: </strong>
</div>
<!--span id="scroll_up_span" style="float:right; margin-right:5px; cursor:pointer;">Up</span-->
<div class="headbody" style="overflow-y:scroll; height:420px">
    <ul class="" style="list-style:none">
     
        <li class="road"> 
            <div style="padding:3px 3px 5px 3px;float:left;">
                <img src="images/truck.png" width="32"  />
            </div>
            <div >
                 <strong style="color:#00C">Truck No. <?php echo $row_per['truckno']; ?></strong><br />
                Road Exp:: <?php echo $cmn->dateformatindia($row_per['expirydate']); ?>
            </div>
        </li>       
      
    </ul>
    
</div>        	<!--span id="scroll_down_span" style="float:right; margin-right:5px; cursor:pointer;">Down</span-->        
</div>




		<!--trucks Alert end-->
	</div>

            
            
		</div></div>
		
	</body>
  <script>
  (function blink() { 
    $('#blink_me').fadeOut(500).fadeIn(500, blink); 
})();
  </script>
	</html>
<?php
mysqli_close($connection);
?>
