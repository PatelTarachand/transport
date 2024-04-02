<?php 
date_default_timezone_set("Asia/Kolkata");
include("dbconnect.php");
include("../lib/smsinfo.php");
$curdate= date('Y-m-d');


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

<body data-layout-topbar="fixed" onLoad="myFunction();" >
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	 
	 
	<div class="container-fluid nav-hidden" id="content" >
		<div id="main">
	  
            
            
        <div style="width:100%; border:5px sold #000; margin-top:10px;" > 
		<h4>Hi.. <?php echo $cmn->getvalfield($connection,"m_userlogin","personname","1=1"); ?></h4>
    <br>
    <br>

        <h4>Bidding List</h4>
        
        <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							
							<div class="box-content nopadding">
                            <div id="div11">
								<table class="table table-hover table-nomargin table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Di no.</th>
                                        	<th>Consignee</th>
                                           <th>Sheep To City</th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                             <th>Bidding Date</th>
                                           <th>Pending Hour</th>
										</tr>
									</thead>
                                    <tbody>
                                    
                                 
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										//$cond="where createdby='$userid' ";
										$cond="where 1=1 ";	
									}
									
                                 //curdate  
								 $olddate =  date("Y-m-d", strtotime("-1 months")); 
                                   
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' && is_bilty=0 and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$olddate' and '$curdate'  order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
 									
											$s = $row['tokendate'];
											$dt = new DateTime($s);											
											$date = $dt->format('d-m-Y');
											$time = $dt->format('H:i');
											
																						
											$minutes = round((strtotime($s) - time()) / 60);
											$hour = ceil($minutes/60);
											$minute = $minutes%60;

									?>
                                    
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
                                            <td><?php echo $date.' '.$time;?></td>
											<td  style="color:red;"><span class="blink"><b><?php echo abs($hour).' h and '.abs($minute).' m'; ?></b></span></td>

                                        
                                           
                                            
										</tr>
                                      <?php
										$slno++;
								
									}
									
									
                                     
									?>
									</tbody>
							</table>
                            </div>
							</div>
						</div>
					</div>
				</div>
        
        
        
        
              
         
        </div>    
            

          


		</div></div>
		
	</body>
  <script>
  (function blink() { 
    $('#blink_me').fadeOut(500).fadeIn(500, blink); 
})();
  
  
 function myFunction() {
  setInterval(function(){ 
					   
			$.ajax({
		  type: 'POST',
		  url: 'getdashboardnotification.php',
		  data: '1=1',
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 
			 document.getElementById('div11').innerHTML=data;			 
						
			}		
		  });//ajax close		   
					   
					   },30000);
}


var sn=1;
	function blink_text() {
   // $('.blink').fadeOut(500);
   // $('.blink').fadeIn(500);
   if(sn % 2==0) {
	   $('.blink').css({"color":"red"},500);
   }
   else
   {
	    $('.blink').css({"color":"black"},500);
	  }
   
  
   sn = sn +1;
}

setInterval(blink_text, 500);




  </script>
	</html>
<?php
mysqli_close($connection);
?>
