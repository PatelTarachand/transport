<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Final Rate Pending Report";

   
if(isset($_GET['startdate']) && isset($_GET['enddate']) && isset($_GET['monthname']))
{

	$startdate = $_GET['startdate'];
	$enddate =  $_GET['enddate'];
	$monthname =  $_GET['monthname'];
}


?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
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
<script>
$(document).ready(function(){
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
});
$(document).ready(function(){
	$("#shortcut_consigneeid").click(function(){
		$("#div_consigneeid").toggle(1000);
	});
	});
	$(document).ready(function(){
	$("#short_place").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});

</script>
</head>

<body data-layout-topbar="fixed">

<?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	
        </div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								
							</div>
                             	<legend class="legend_blue"> </i>&nbsp;<?php echo $monthname;?> Panding Report </legend>                          	
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                           <th>Sl. No.</th>
                                           <th>BT. No.</th>
                                           <th>Date</th>
                                           <th>Veh. No.</th>
                                           <th>Ship To Desti.</th>
                                           <th>MT</th>
                                           <th>Rate</th>
                                           <th>Char/mt</th>
                                           <th>Final Rs.</th>
                                           <th>Total Amt</th>                                          
                                           <th>Final Amt</th>
                                           <th>Profit</th>                                          
                                           <th>Owner Name</th>
                                           <th>Mobile No.</th> 
                                           <th>Consignee Name</th>
                                           <th>Consignor Name</th>  
										</tr>
									</thead>
                                    <tbody>
                                    <?php
										
									$slno=1;
									
									$sel = "select bilty_id,billtyno,billtydate,consignorid,consigneeid,destinationid,truckid,wt_mt,rate_mt,newrate,adv_cash,adv_diesel,
									adv_cheque,adv_date,payment_date,chequepaymentno,cashpayment,chequepayment,commission,venderid,drivername,
									driverlisenceno from bilty_entry where recd_date ='0000-00-00' && billtydate between '$startdate' and '$enddate' order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$char_amt = $row['rate_mt'] - $row['newrate'];
										$tot_amt = $row['wt_mt'] * $row['newrate']; 
										$final_amt = $tot_amt - $row['adv_diesel'] - $row['adv_cash'] - $row['adv_cheque'];
										$profit = $char_amt * $row['wt_mt'];
										$truckid = $row['truckid'];
										$bilty_id = $row['bilty_id'];
										$consignorid = $row['consignorid'];
										$consigneeid = $row['consigneeid'];
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
										
										$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
										$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
										$ownermobileno1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['billtyno']; ?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                                            <td><?php echo strtoupper($cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"));?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'");?></td>
                                            <td><?php echo $row['wt_mt']; ?></td>
                                            <td><span id="rate_mt<?php echo $bilty_id; ?>" > <?php echo $row['rate_mt']; ?> </span> </td>
                                            <td> <span id="char_mt<?php echo $bilty_id; ?>" > <?php echo $row['rate_mt'] - $row['newrate']; ?> </span> </td>
                                            <td>
											<input type="text" id="newrate<?php echo $bilty_id; ?>" value="<?php echo $row['newrate']; ?>" style="width:100px;" onChange="setfinalrate();" >
											</td>
                                            <td><?php echo $row['wt_mt'] * $row['newrate']; ?></td>                                          
                                            <td>
											
										<?php echo $final_amt; ?>	
                                            </td>
                                            <td><?php echo $profit; ?></td>
                                          
                                            <td><?php echo $ownername; ?></td>
                                            <td><?php echo $ownermobileno1; ?></td>
                                                <td><?php echo $consigneename; ?></td>
                                                    <td><?php echo $consignorname; ?></td>
                                            <!--<td><a onClick="updatefinalrate(<?php  //echo $bilty_id; ?>);" target="_blank" class="btn btn-sm btn-success" > update </a>
                                            <span id="update<?php // echo $bilty_id; ?>" style="color:#F00;" > </span>
                                            </td>-->
                                                                                   	
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
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
function funDel(id)
{    
	  //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
	   tblpkey = '<?php echo $tblpkey; ?>';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close


//below code for date mask
jQuery(function($){
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});


function updatefinalrate(bilty_id)
{
	var newrate = document.getElementById('newrate'+bilty_id).value;	
	
	$.ajax({
		  type: 'POST',
		  url: 'updaterate.php',
		  data: 'newrate='+newrate+'&bilty_id='+bilty_id,
		  dataType: 'html',
		  success: function(data){
				if(data==1)
				{
					$('#update'+bilty_id).html('saved');	
				}
		
			}
		
		  });//ajax close
	
}



</script>			
                
		
	</body>

	</html>