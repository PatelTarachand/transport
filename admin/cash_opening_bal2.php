<?php  
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='cash_opening_bal2.php';
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
                                        		<th width="1%"></th>
                                                <th width="18%">Date</th>
                                                <th width="24%">Opening Bal.</th>
                                                <th width="19%">Cement Advance </th>
                                                <th width="16%">Clinker Advance </th>
                                                <th width="11%">Other Income</th>
                                                <th width="11%">Other Expense</th>
                                                	
										</tr>
									</thead>
                                    <tbody>
                                  <?php 								   
						$cash_opening=0;
						$cementadv=0;
						$clinkeradv=0;
						$tot_cementadv=0;
						$tot_clinkeradv=0;
						
						$otherincome=0;
						$otherexpense=0;
						$tot_otherincome=0;
						$tot_otherexpense=0;
						$net_cash_opening=0;
						//$enddate=1;
						
                              for($i=$enddate;$i>=1;$i--)    
							  {	
							$yesterday = date('Y-m-d', strtotime($searchdate . ' -1 day'));  
							  							  
							$cash_opening = $cmn->getcashopeningplant($connection,$searchdate);
							
							$cementadv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=2 && adv_date='$searchdate'");
							
							$clinkeradv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash)","itemid=1 && adv_date='$searchdate'");
						
						$otherincome = $cmn->getvalfield($connection,"otherincome as A left join m_userlogin as B on A.createdby = B.userid","sum(incomeamount)","payment_type='cash' && paymentdate='$searchdate' && branchid=1");
						
						$otherexpense = $cmn->getvalfield($connection,"other_expense as A left join m_userlogin as B on A.createdby = B.userid","sum(expamount)","payment_type='cash' && paymentdate='$searchdate' && branchid=1");  
							  ?>
                            <tr>
                            	<td></td>
                                <td><?php echo $cmn->dateformatindia($searchdate); ?></td>
								<td style="text-align:right;"><?php echo $cash_opening; ?></td>
                                <td style="text-align:right;"><a href="excel_bilty_advance_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>&itemid=2&type="><?php echo $cementadv; ?></a></td>
                                <td style="text-align:right;"><a href="excel_bilty_advance_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>&itemid=1&type="><?php echo $clinkeradv; ?></a></td>
                                
                                <td style="text-align:right;"><a href="excel_office_income_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>&head_id=&payment_type="><?php echo $otherincome; ?></a></td>
                                <td style="text-align:right;"> <a href="excel_office_expense_report.php?fromdate=<?php echo $searchdate; ?>&todate=<?php echo $searchdate; ?>&head_id=&payment_type="><?php echo $otherexpense; ?></a></td>
                                  
                            </tr>
                                <?php 
									$searchdate = date('Y-m-d', strtotime('-1 day', strtotime($searchdate)));
									$tot_cementadv += $cementadv;
									$tot_clinkeradv += $clinkeradv;
									$tot_otherincome += $otherincome;
									$tot_otherexpense += $otherexpense;
									$net_cash_opening += $cash_opening;
							  }
								?>
                              		
						</tbody>
             <tr>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;">Total</th>
                         <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($net_cash_opening,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_cementadv,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_clinkeradv,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($tot_otherincome,2); ?></th>
                        <th style="color:#FFF; background-color:#00F; text-align:right;"><?php echo number_format($otherexpense,2); ?></th>
                       
                                              
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
