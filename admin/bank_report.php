<?php
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bank_report.php';
$modulename = "Billty Report";

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

if(isset($_GET['chequeno']))
{
	$chequeno = trim(addslashes($_GET['chequeno']));	
}
else
{
	$chequeno='';	
}

if(isset($_GET['bankid']))
{
	$bankid = trim(addslashes($_GET['bankid']));	
}
else
{
	$bankid='';	
}

if($chequeno !='')
{
	$crit =" and cheque_no like '%$chequeno%'";
	$cond=" and chequepaymentno like '%$chequeno%'";
}

if($bankid !='')
{
	$crit .=" and bankid='$bankid'";
	$cond .=" and paymentbankid ='$chequeno'";
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; Bank Report </legend>
                            <table width="940">
                                    <tr>
                                            <th width="20%" style="text-align:left;">From Date : </th>
                                            <th width="20%" style="text-align:left;">To Date : </th>                                            
                                             <th width="20%" style="text-align:left;">Cheque No : </th>
                                            <th width="20%" style="text-align:left;">Bank Name : </th>                                         
                                            <th width="20%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0; width:80%;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0; width:80%;" autocomplete="off" ></td>
                                            
                                            <td> <input class="formcent" type="text" name="chequeno" id="chequeno"  value="<?php echo $chequeno; ?>"  data-date="true" style="border: 1px solid #368ee0; width:80%;" autocomplete="off" ></td>
                                            
                                            <td>   
                    <select id="bankid" name="bankid" class="formcent select2-me" style="width:220px;" >
                    <option value=""> - Select - </option>
                    <?php 
                    $sql_fdest = mysqli_query($connection,"select bankid,bankname,helpline from m_bank");
                    while($row_fdest = mysqli_fetch_array($sql_fdest))
                    {
                    ?>
                    <option value="<?php echo $row_fdest['bankid']; ?>"><?php echo $row_fdest['bankname'].' / '.$row_fdest['helpline']; ?></option>
                    <?php
                    } ?>
                    </select>
                    <script>document.getElementById('bankid').value = '<?php echo $bankid; ?>';</script>
                        
                                            </td>
                                            
                                         
                                            <td> <input type="submit" name="search" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate'); " >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger">Reset</a></td>
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
                            
                            	<a class="btn btn-primary btn-lg" href="excel_bank_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&chequeno=<?php echo $chequeno; ?>&bankid=<?php echo $bankid; ?>" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
                            <h4> Advance Cheque Amount </h4>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                           <th width="4%">Sl. No.</th>
                                           <th width="6%">BT. No.</th>
                                           <th width="4%">Date</th>
                                           <th width="4%"> Cheque No</th>
                                            <th width="9%">Adv. Cheque Date</th>
                                           <th width="6%">Truck No.</th>
                                           <th width="10%">Consignor Name</th> 
                                           <th width="6%">To Place</th>
                                           <th width="8%">Owner Name</th>
                                           <th width="9%">Owner Mobile</th>                                         
                                           <th width="8%">Cheque Adv.</th>
                                           <th width="10%">Final Pay</th>                                           
                                           <th width="10%">Bank Name</th>            					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
									$ycond="";
									}
									else
									{
									$ycond=" && createdby='$userid' && sessionid='$sessionid'";	
									}	
							
							
							$tot_final_pay = 0;
							$tot_check_adv = 0;
									$sel = "select bilty_id,billtyno,billtydate,consignorid,destinationid,truckowner,truckownermobile,commission,cashpayment,chequepayment,drivername,
									driver_mobile,adv_cheque,cheque_no,advchequedate,bankid,truckid from bilty_entry where advchequedate between '$fromdate' and '$todate' && adv_cheque !='0' $crit $ycond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{		
								
									?>
                <tr>
                        <td><?php echo $slno; ?></td>
                        <td><?php echo $row['billtyno']; ?></td>
                        <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                        <td><?php echo $row['cheque_no']; ?></td>
                         <td><?php echo $cmn->dateformatindia($row['advchequedate']); ?></td> 
                        <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"); ?></td>
                        <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td>
                        <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                        <td><?php echo $row['truckowner']; ?></td>
                        <td><?php echo $row['truckownermobile']; ?></td>
                        <td><?php echo number_format($row['adv_cheque'],2); ?></td>
                        <td><?php echo number_format($row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'],2);?></td>
                        
                        <td><?php  if($row['bankid'] !='0') {  echo $cmn->getvalfield($connection,"m_bank","bankname","bankid='$row[bankid]'").' / '.$cmn->getvalfield($connection,"m_bank","helpline","bankid='$row[bankid]'"); } ?></td>                                          
                </tr>
                                        <?php
										
						$tot_final_pay += $row['adv_cheque'];
						$tot_check_adv += $row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'];
							
										$slno++;
								}
									?>
                                    
                                    
                                     <tr>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"></td> 
                         <td style="background-color:#00F; color:#FFF;"></td> 
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_final_pay,2);?></td> 
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_check_adv,2); ?></td>
                        <td style="background-color:#00F; color:#FFF;"></td>                                          
                </tr>
                
									</tbody>
							</table>
							</div>
            <br>
            <br>

                            <div class="box-content nopadding">
                            <h4> Payment Cheque Amount </h4>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                                <th>Sl. No.</th>
                                                <th>BT. No.</th>
                                                <th>Date</th>
                                                <th> Cheque No</th>
                                                <th> Cheque Date</th>
                                                <th>Truck No.</th>
                                                <th>Consignor Name</th> 
                                                <th>To Place</th>
                                                <th>Owner Name</th>
                                                <th>Owner Mobile</th>                                                  
                                                <th> Cheque Amt</th>                                           
                                                <th> Final Pay </th>                                          
                                                <th>Bank Name</th>                         					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php									
									$tot_final_pay = 0;
									$tot_check_adv = 0;
									$slno=1;
									$sel = "select bilty_id,billtyno,billtydate,consignorid,destinationid,truckowner,commission,cashpayment,chequepayment,truckownermobile,drivername,
									driver_mobile,chequepayment,chequepaymentno,chequepaydate,paymentbankid,truckid from bilty_entry where chequepaydate between '$fromdate' and '$todate' && chequepayment !='0' $cond $ycond order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                    <td><?php echo $row['billtyno']; ?></td>
                    <td><?php echo $cmn->dateformatindia($row['billtydate']); ?></td>
                    <td><?php echo $row['chequepaymentno']; ?></td>
                     <td><?php echo $cmn->dateformatindia($row['chequepaydate']); ?></td>  
                    <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"); ?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); ?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$row[destinationid]'"); ?></td>
                     <td><?php echo $row['truckowner']; ?></td>
                    <td><?php echo $row['truckownermobile']; ?></td>                   
                    <td><?php echo number_format($row['chequepayment'],2); ?></td>
                     <td><?php echo number_format($row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'],2);?></td>
                   
                    <td><?php  if($row['paymentbankid'] !='0') { echo $cmn->getvalfield($connection,"m_bank","bankname","bankid='$row[paymentbankid]'").' / '.$cmn->getvalfield($connection,"m_bank","helpline","bankid='$row[paymentbankid]'"); } ?></td> 
										</tr>
                                        <?php
										
								$tot_final_pay += $row['chequepayment'];
								$tot_check_adv += $row['commission']+$row['cashpayment']+$row['chequepayment']-$row['commission'];
						
										$slno++;
								}
									?>
                                    
                                    
                                    <tr>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                         <td style="background-color:#00F; color:#FFF;"></td> 
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"></td> 
                        <td style="background-color:#00F; color:#FFF;"></td>
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_final_pay,2);?></td>   
                        <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_check_adv,2); ?></td>
                        <td style="background-color:#00F; color:#FFF;"></td>                                          
                </tr>
                  
									</tbody>
							</table>
                            <br>
<br>
<br>
	
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
