<?php  
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='cash_opening_bal.php';
$modulename = "Billty Report";

if(isset($_GET['search']))
{
	$month = trim(addslashes($_GET['month']));
}
else
{
	$month = date('m');	
}

if(isset($_GET['year']))
{
	$year =  trim(addslashes($_GET['year']));
}
else
{
	$year = date('Y');
}

if($month !='')
{
	$fromdate = date("$year-$month-01");	
 	$searchdate = date("Y-m-t", strtotime($fromdate));
}

$enddate = date("t", strtotime($fromdate));
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;Cash Opening Balance</legend>
                            <table width="998">
                                    <tr>
                                            
                                              
                                            <th width="227" style="text-align:left;">Month : </th>
 											<th width="227" style="text-align:left;">Year : </th>                                            
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
                            
                            	<a class="btn btn-primary btn-lg" href="excel_cash_opening_bal.php?month=<?php echo $month; ?>&year=<?php echo $year; ?>&search=Search" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                        		<td> </td>
                                                <th width="3%">Date</th>
                                                <th width="7%">Opening Bal.</th>
                                                <th width="7%">Truck Income</th>
                                                <th width="9%">Office Income</th>
                                                <th width="9%">Bilty Adv</th>
                                                <th width="9%">Final Payment</th>
                                                <th width="8%">Truck Uchanti</th>
                                                <th width="7%">Truck Exp.</th>
                                                <th width="7%">Office Exp.</th>                                            
                                                <th width="8%">Diesel Payment</th>
                                                <th width="8%">Bonus</th>   
                                                <th width="6%">Truck Inst. Payment</th>	   
                                       			<th width="6%">Commission</th>
                                                <th width="6%">Tuck Owner Payment</th>
                                                <th width="6%">Driver Salary</th>			
										</tr>
									</thead>
                                    <tbody>
                                  <?php 
								    $net_truck_income = 0;
									$net_office_income = 0;
									$net_bilty_adv = 0;
									$net_final_payment = 0;
									$net_truck_uchanti = 0;
									$net_truck_expense = 0;
									$net_other_expense = 0;
									$net_bonuspayment = 0;
									$net_truck_installation_payment = 0;
									$net_commision = 0;
									$net_truck_owner_payment = 0;
									$net_driver_salary=0;
									$truck_income =0;
									$office_income =0;
									$bilty_adv =0;
									$final_payment =0;
									$truck_uchanti =0;
									$truck_expense=0;
									$other_expense =0;
									$bonuspayment =0;
									$truck_installation_payment =0;
									$commision =0;
									$truck_owner_payment =0;
									$driver_salary =0;
									$cash_opening=0;
									
									
                              for($i=$enddate;$i>=1;$i--)    
							  {								  
							$cash_opening = $cmn->getcashopening($connection,$searchdate);
							$truck_income = $cmn->getvalfield($connection,"otherincome","sum(incomeamount)","truckid !=0 && paymentdate='$searchdate' && payment_type='cash'");
							$office_income = $cmn->getvalfield($connection,"otherincome","sum(incomeamount)","truckid =0 && paymentdate='$searchdate' && payment_type='cash'");
							$bilty_adv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash)","adv_date='$searchdate'");
							$final_payment = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$searchdate'");
							$truck_uchanti = $cmn->getvalfield($connection,"truck_uchanti","sum(uchantiamount)","paymentdate='$searchdate' && payment_type='cash'");
							$truck_expense = $cmn->getvalfield($connection,"truck_expense","sum(uchantiamount)","paymentdate='$searchdate' && payment_type='cash' && head_id not in('9','10','11','12','13')");
							$other_expense = $cmn->getvalfield($connection,"other_expense","sum(expamount)","paymentdate='$searchdate' && payment_type='cash'");
							$bonuspayment = $cmn->getvalfield($connection,"diesel_demand_slip","sum(bonus_amt)","diedate='$searchdate' && payment_type='cash'");
							$truck_installation_payment = $cmn->getvalfield($connection,"truck_installation_payment","sum(paid_amt)","payment_date='$searchdate' && payment_type='Cash'");
							
							$commision = $cmn->getvalfield($connection,"bidding_entry","sum(commission)","payment_date='$searchdate'");
							$truck_owner_payment = $cmn->getvalfield($connection,"bilty_payment","sum(payamount)","paymentdate='$searchdate' && payment_type !='cheque'");
							$driver_salary =  $cmn->getvalfield($connection,"driver_salary","sum(bal_amt)","salary_date='$searchdate'");
							
							//$diesel_payment = $cmn->getvalfield($connection,"","","");
							  ?>
                            <tr>
                            	<td> </td>
                                <td><?php echo $cmn->dateformatindia($searchdate); ?></td>
                                <td style="text-align:right;"><?php echo number_format($cash_opening,2); ?></td>
                                <td style="text-align:right;"><a href="excel_truck_income_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $truck_income; ?></a></td>
                                <td style="text-align:right;"><a href="excel_office_income_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $office_income; ?></a></td>
                                <td style="text-align:right;"><a href="excel_bilty_adv.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo number_format($bilty_adv,2); ?></a></td>
                                <td style="text-align:right;"><a href="excel_bilty_payment.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo number_format($final_payment,2); ?></a></td>
                         <td style="text-align:right;"><a href="excel_truck_uchanti_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $truck_uchanti; ?></a></td>
                          <td style="text-align:right;"><a href="excel_truck_expenses_report2.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $truck_expense; ?></a></td>
                          <td style="text-align:right;"><a href="excel_office_expense_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $other_expense;?></a></td>                               
                                <td> </td>
                  <td style="text-align:right;"><a href="excel_bonus_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $bonuspayment; ?></a></td>
                  <td style="text-align:right;"><a href="excel_truck_installation_payment_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $truck_installation_payment; ?></a></td>
                                <td style="text-align:right;"><a href="excel_bilty_commision_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $commision; ?></a></td> 
                              <td><a href="excel_truck_owner_payment_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>"><?php echo $truck_owner_payment; ?></a></td>
                              
                              <td><a><?php echo $driver_salary; ?></a></td>
                                  
                            </tr>
                                <?php 
									$searchdate = date('Y-m-d', strtotime('-1 day', strtotime($searchdate)));
									
									$net_truck_income += $truck_income;
									$net_office_income += $office_income;
									$net_bilty_adv += $bilty_adv;
									$net_final_payment += $final_payment;
									$net_truck_uchanti += $truck_uchanti;
									$net_truck_expense += $truck_expense;
									$net_other_expense += $other_expense;
									$net_bonuspayment += $bonuspayment;
									$net_truck_installation_payment += $truck_installation_payment;
									$net_commision += $commision;
									$net_truck_owner_payment += $truck_owner_payment;
									$net_driver_salary += $driver_salary;
							  }
								?>
                              		
						</tbody>
             <tr>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"> </th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;">Total</th>
                         <th style="color:#FFF; background-color:#00F; text-align:right;"> </th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_truck_income,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_office_income,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_bilty_adv,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_final_payment,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_truck_uchanti,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_truck_expense,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_other_expense,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_bonuspayment,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_truck_installation_payment,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_commision,2); ?></th>   
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_truck_owner_payment,2); ?></th> 
                         <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_driver_salary,2); ?></th> 
                                              
                </tr>  	
                                    
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
