<?php                                                                                          include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='vehicalwiseexpensereport.php';
$modulename = "Billty Report";
$crit='';
if(isset($_GET['month']))
{
	$month = trim(addslashes($_GET['month']));	
}
else
{
	$month = date('m');	
}


if(isset($_GET['year']))
{
	$year = trim(addslashes($_GET['year']));	
}
else
$year='';

if($month !='')
{
	$fromdate = date("$year-$month-01");	
 	$todate = date("Y-m-t", strtotime($fromdate));
}

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));	
}
else
{
	$ownerid='';	
}

if(isset($_GET['truckno']))
{
	$truckno = trim(addslashes($_GET['truckno']));
	$truckid = $cmn->getvalfield($connection,"m_truck","truckid","truckno='$truckno'");
}
else
{
	$truckno='';
	$truckid='';	
}


if($ownerid !='')
{
	$crit = " and ownerid='$ownerid'";
}
if($truckid !='')
{
	$crit .= " and truckid='$truckid'";
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
    				<fieldset style="margin-top:45px; margin-left:45px;" >                                        <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; Vehical Wise Expenses Report </legend>
                            <table width="998">
                                    <tr>
                                            <th width="212" style="text-align:left;">Month: <span class="red">*</span></th>
                                            <th width="212" style="text-align:left;">Year: <span class="red">*</span></th>
                                            <th width="227" style="text-align:left;">Owner Name : <span style="color:#F00;">*</span> </th>
                                            <th width="212" style="text-align:left;">Truck No : </th>                                              
                                            <th width="327" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td>
                        <select name="month" id="month" class="select2-me input-large" >                                   
                                    <option value="01">Jan</option> 
                                    <option value="02">Feb</option> 
                                    <option value="03">Mar</option> 
                                    <option value="04">Apr</option> 
                                    <option value="05">May</option> 
                                    <option value="06">Jun</option> 
                                    <option value="07">Jul</option> 
                                    <option value="08">Aug</option> 
                                    <option value="09">Sep</option> 
                                    <option value="10">Oct</option> 
                                    <option value="11">Nov</option> 
                                    <option value="12">Dec</option>                                                
                        </select>
                        <script>document.getElementById('month').value = "<?php echo $month; ?>";</script>                                                   
                                            </td>
                                            
                                             <td>
                        <select name="year" id="year" class="select2-me input-large" >  
                        <?php
						for($i=2018;$i<2025;$i++) {
						?>                                 
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                           <?php } ?>                                                                                      
                        </select>
                        <script>document.getElementById('year').value = "<?php echo $year; ?>";</script>                                                   
                                            </td>
                                            <td>
                                                <select name="ownerid" id="ownerid" class="select2-me input-large" >
                                                <option value="">-Select Owner-</option>
                                                <?php 
												$sql_i = mysqli_query($connection,"select ownerid,ownername from m_truckowner order by ownername");
												while($row_i=mysqli_fetch_assoc($sql_i))
												{
												?>
                                                <option value="<?php echo $row_i['ownerid']; ?>"><?php echo $row_i['ownername']; ?></option> 
                                                <?php 
												}
												?>
                                                </select>
                                                <script>document.getElementById('ownerid').value = "<?php echo $ownerid; ?>";</script>
                                                    
                                            </td>
                                            <td>  
                                                    <input list="browsers" class="formcent" name="truckno" id="truckno" value="<?php echo $truckno; ?>" autocomplete="off" >
                                                    
                                                    <datalist id="browsers">
                                                    <?php 
													$sql = mysqli_query($connection,"select truckno from m_truck order by truckno");
													while($row=mysqli_fetch_assoc($sql))
													{
													?>
                                                    <option value="<?php echo $row['truckno']; ?>"> 
                                                    <?php 
													}
													?>
                                                    </datalist> 
                                            </td>                                                                                    
                                            <td> <input type="submit" name="search" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate,ownerid'); " >
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
            
            <?php if($ownerid !='') { ?>
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<a class="btn btn-primary btn-lg" href="excel_vehicalwiseexpensereport.php?month=<?php echo $month; ?>&truckno=<?php echo $truckno; ?>&ownerid=<?php echo $ownerid; ?>" target="_blank" style="float:right;" >  Excel </a>
							</div>
                            
                            	
                                
							<div class="box-content nopadding" style="overflow-x:scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                            <th width="3%">Sl. No.</th>
                                            <th>Truck No</th>
                                            <th width="7%">Pichhla Bachat</th>
                                            <th width="7%">Cash Expense</th>
                                            <th width="9%">Total</th>
                                            <th width="9%">Bhatta</th>
                                            <th width="9%">Hamali</th>
                                            <th width="8%">Trip</th>
                                            <th width="7%">Toll Tax</th>
                                            <th width="7%">Other</th>                                            
                                            <th width="8%">Total</th>
                                            <th width="8%">Final Total</th>   
                                            <th width="6%">Return</th>	 
                                            <th width="6%">Salary Ded.</th>	  
                                            <th width="6%">Bachat</th>	
                                            <th width="6%">Bonus</th>	                                            
                                            <th width="8%">Diesel Exp.</th>
                                            <th width="8%">Spair Item</th>   
                                            <th width="6%">Note</th>	   
                                            <th width="6%">Total Exp.</th>	
                                            <th width="6%">Driver/Helper Payment</th>                                            
                                            <th width="8%">RTO & Insurence</th>
                                            <th width="8%">Truck Installment</th>
                                            <th width="8%">Grand Total</th>   
                                            <th width="6%">Trip</th>	   
                                            <th width="6%">Amount</th>	
                                            <th width="6%">Profit</th>	
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
										$open_bal=0;									
										$tot_cash_exp = 0;
										$tot_saveamt = 0;
										$tot_truckexp = 0;
										$tot_returnamt = 0;
										$tot_bachat = 0;
										$tot_bonus_amt = 0;
										$tot_diesel_exp = 0;
										$tot_spareexp_amt = 0;
										$tot_salary_deduct = 0;
										$tot_total_exp = 0;
										$tot_salary = 0;
										$tot_grandtotal = 0;
										$tot_nooftrip = 0;
										$tot_biltyamountprofit = 0;
										$tot_profit = 0;
										$tot_truck_installment = 0;
										
						$sel = "select truckid,truckno,openningkm,salary,openingbalance,ownerid from m_truck where 1=1 $crit order by truckno";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];
										$ownerid = $row['ownerid'];
										
										
										$open_bal = $cmn->getopeningbal($connection,$truckid,$fromdate);
										
										
										$bhatta_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=9 && paymentdate between '$fromdate' and '$todate'");
										$hamali_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=10 && paymentdate between '$fromdate' and '$todate'");
										$cashexp_amt = $cmn->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && head_id=8 && paymentdate between '$fromdate' and '$todate'");
										$toltax_amt = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=11 && paymentdate between '$fromdate' and '$todate'");
										$nooftrip =  $cmn->getvalfield($connection,"bilty_entry","count(*)","truckid='$truckid' && billtydate between '$fromdate' and '$todate'");
										$otherexpamt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=12 && paymentdate between '$fromdate' and '$todate'");
										$returnamt =  $cmn->getvalfield($connection,"otherincome","sum(incomeamount)","truckid='$truckid' && head_id=2 && paymentdate between '$fromdate' and '$todate'");
										$bonus_amt =  $cmn->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","truckid='$truckid' && diedate between '$fromdate' and '$todate'") + $cmn->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","truckid='$truckid' && head_id=16 && paymentdate between '$fromdate' and '$todate'");
										$spareexp_amt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=13 && paymentdate between '$fromdate' and '$todate'");
										$rto_amt =  $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","truckid='$truckid' && head_id=14 && paymentdate between '$fromdate' and '$todate'");
										$truck_installment = $cmn->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","truckid='$truckid' && payment_date between '$fromdate' and '$todate'");
										
										$salary_deduct =  $cmn->getvalfield($connection,"salary_deduction","sum(deduct_amt)","truckid='$truckid' && deduct_date between '$fromdate' and '$todate'");
										
									 $owner_type = $cmn->getvalfield($connection,"m_truckowner","owner_type","ownerid='$ownerid'");
										
										$saveamt = $open_bal + $cashexp_amt;
										$truckexp = $bhatta_amt + $hamali_amt + $toltax_amt + $otherexpamt;										
										$final_total = $saveamt - $truckexp;										
										$bachat = $final_total - $returnamt -$salary_deduct;										
										$diesel_exp = $cmn->getdieselexp($connection,$truckid,$fromdate,$todate);
										$total_exp = $diesel_exp + $bonus_amt+ $spareexp_amt + $truckexp;										
										$salary = $row['salary'];										
										$grandtotal = $total_exp + $salary + $rto_amt +$truck_installment;
										
										
										
										if($owner_type=="self")
										{
										
											$biltyamountprofit = $cmn->getprofit_bytruck($connection,$truckid,$fromdate,$todate);
										}
										else
										{
										$biltyamountprofit = $cmn->getbiltyamountprofit($connection,$truckid,$fromdate,$todate);
										}
										
										$profit = $biltyamountprofit - $grandtotal;
																			
									?>
                            <tr>
                                <td><?php echo $slno; ?></td>
                                <td><?php echo $row['truckno']; ?></td>
                                <td style="text-align:right;"><?php echo number_format($open_bal,2); ?></td>
                <td style="text-align:right;"><a href="excel_truck_uchanti_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=8"><?php echo number_format($cashexp_amt,2); ?></a></td>
                                <td style="text-align:right;"><?php echo number_format($saveamt,2); ?></td>
                              <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=9"><?php echo number_format($bhatta_amt,2); ?></a></td>
                                <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=10"><?php echo number_format($hamali_amt,2); ?></a></td>
                                <td><?php echo $nooftrip; ?></td>
                                <td style="text-align:right;"><?php echo number_format($toltax_amt,2); ?></td>
                                <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=12"><?php echo number_format($otherexpamt,2); ?></a></td>                               
                                <td style="text-align:right;"><?php echo number_format($truckexp,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($final_total,2); ?></td>
                                <td style="text-align:right;"><a href="excel_truck_income_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=2"><?php echo number_format($returnamt,2); ?></a></td>
                                <td style="text-align:right;"><a href="salary_deduction_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>"><?php echo $salary_deduct; ?></a></td>
                                <td style="text-align:right;"><?php echo number_format($bachat,2); ?></td>
                                <td style="text-align:right;"><a href="excel_bonus_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>"><?php echo number_format($bonus_amt,2); ?></a></td>                                
                                <td style="text-align:right;"><a href="excel_diesel_demand_slip.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>"> <?php echo number_format($diesel_exp,2); ?></a></td>
                                <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=13"><?php echo number_format($spareexp_amt,2); ?></a></td>
                                <td> </td>
                                <td style="text-align:right;"><?php echo number_format($total_exp,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($salary,2); ?></td>                                
                                <td style="text-align:right;"><a href="excel_truck_expenses_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>&head_id=14"><?php echo number_format($rto_amt,2); ?></a></td>
                                <td style="text-align:right;"><a href="excel_truck_installation_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckid=<?php echo $truckid; ?>"> <?php echo number_format($truck_installment,2); ?></a> </td>
                                <td style="text-align:right;"><?php echo number_format($grandtotal,2); ?></td>
                                <td><?php echo $nooftrip; ?></td>
                                <td style="text-align:right;"><?php echo number_format($biltyamountprofit,2); ?></td>
                                <td style="text-align:right;"><?php echo number_format($profit,2); ?></td>                                                                        
                            </tr>
                                        <?php
										$slno++;
										
										$tot_cash_exp += $cashexp_amt;
										$tot_saveamt += $saveamt;
										$tot_truckexp += $truckexp;
										$tot_returnamt += $returnamt;
										$tot_bachat += $bachat;
										$tot_bonus_amt += $bonus_amt;
										$tot_diesel_exp += $diesel_exp;
										$tot_spareexp_amt += $spareexp_amt;
										$tot_salary_deduct += $salary_deduct;
										$tot_total_exp += $total_exp;
										$tot_salary += $salary;
										$tot_grandtotal += $grandtotal;
										$tot_nooftrip += $nooftrip;
										$tot_biltyamountprofit += $biltyamountprofit;
										$tot_profit += $profit;
										$tot_truck_installment += $truck_installment;
								}
									?>
                                    
                              <tr>
                              			<td style="background-color:#00F;"> </td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong>Total</strong></td>
                                        <td style="background-color:#00F;"> </td>                                       
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_cash_exp,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_saveamt,2); ?></strong></td>
                                         <td style="background-color:#00F;text-align:right;"> </td>
                                        <td style="background-color:#00F;text-align:right;"> </td>
                                        <td style="background-color:#00F;text-align:right;"> </td>
                                        <td style="background-color:#00F;"> </td>
                                        <td style="background-color:#00F;"> </td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_truckexp,2); ?></strong></td>
                                        <td style="background-color:#00F;"> </td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_returnamt,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_salary_deduct,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_bachat,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_bonus_amt,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_diesel_exp,2); ?>
                                        </strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_spareexp_amt,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;"></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_total_exp,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_salary,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;"></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><?php echo number_format($tot_truck_installment,2); ?></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_grandtotal,2); ?>
                                        </strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_nooftrip,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_biltyamountprofit,2); ?></strong></td>
                                        <td style="background-color:#00F; color:#FFF;text-align:right;"><strong><?php echo number_format($tot_profit,2); ?></strong></td>
                              </tr>      
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
                <?php } ?>
            
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
