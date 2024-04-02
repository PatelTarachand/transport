<?php 
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Cash Bilty Paymet Report";

if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));	
	
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
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
                        	<div class="box-content nopadding">
                   <form method="get" action="">
    				<fieldset style="margin-top:45px; margin-left:45px;" >                                        
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp<?php echo $modulename; ?></legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                                                                    
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            
                                            
                                       
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                                           </td>
                                    </tr>
                            </table>    				
                    </fieldset>    		       
                    </form>
         </div>
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
                            
                            	<a class="btn btn-primary btn-lg" href="excel_cash_bilty_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank" 
                                style="float:right;" >  Excel </a>
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
                                           <th>Cash Payment</th>   
                                           <th>Payee Name</th>                                     
                                           <th>Agent Name</th>
                                           <th>Commission</th> 
                                          <th>Commission Date</th> 
                                                                                     					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}	
																		
									$slno=1;
									$sel = "select bilty_id,billtyno,billtydate,destinationid,truckid,wt_mt,rate_mt,newrate,adv_cash,adv_diesel,
									adv_cheque,adv_date,payment_date,chequepaymentno,cashpayment,chequepayment,commission,venderid,drivername,payeename,
									driverlisenceno,cashbook_date from bilty_entry where payment_date between '$fromdate' and '$todate'  $cond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$char_amt = $row['rate_mt'] - $row['newrate'];
										$tot_amt = $row['wt_mt'] * $row['newrate']; 
										$final_amt = $tot_amt - $row['adv_diesel'] - $row['adv_cash'] - $row['adv_cheque'];
										$profit = $char_amt * $row['wt_mt'];
										$truckid = $row['truckid'];
										$commission = $row['commission'];
										$venderid = $row['venderid'];
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
										$vendername = $cmn->getvalfield($connection,"m_vender","vendername","venderid='$venderid'");
										$ownermobileno1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['billtyno']; ?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                                            <td><?php echo strtoupper($cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"));?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'");?></td>
                                            <td><?php echo $row['wt_mt']; ?></td>
                                            <td><?php echo $row['rate_mt']; ?></td>
                                            <td><?php echo $row['rate_mt'] - $row['newrate']; ?></td>
                                            <td><?php echo $row['newrate']; ?></td>
                                            <td><?php echo $row['wt_mt'] * $row['newrate']; ?></td>                                          
                                            <td><?php echo $final_amt; ?></td>
                                            <td><?php echo $profit; ?></td>
                                          	<td><?php echo $row['cashpayment']; ?></td>
                                            <td><?php echo $row['payeename']; ?></td>
                                            <td><?php echo $vendername; ?></td>
                                            <td><?php echo $commission; ?></td>
                                            <td><?php echo $cmn->dateformatindia($row['cashbook_date']); ?></td>
                                                                                   	
										</tr>
                                        <?php
										$slno++;
										$tot_final_amt += $final_amt;
										$tot_profit_amt += $profit;
										$net_tot_amt += $tot_amt;	
										$net_tot_comm += $commission;	
										$net_cash_payment += $row['cashpayment'];
								}
									?>
                                    
                                     <tr style="color:#FFF; background-color:#0E3CF3;">
                                    		<td><strong>Total</strong></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align:right;"><?php echo number_format($net_tot_amt,2); ?></td>                                          
                                            <td style="text-align:right;"><?php echo number_format($tot_final_amt,2); ?></td>
                                            <td style="text-align:right;"><?php echo number_format($tot_profit_amt,2); ?></td>
                                           <td style="text-align:right;"><?php echo number_format($net_cash_payment,2); ?></td>
                                            <td></td>
                                            <td></td>
                                           <td style="text-align:right;"><?php echo number_format($net_tot_comm,2); ?></td>
                                           <td></td> 
                                    </tr>
                                    
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

</script>			
                
		
	</body>

	</html>