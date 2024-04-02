<?php 
include("dbconnect.php");
$tblname = "check_entry";
$tblpkey = "check_entry_id";
$pagename = "check_entry_report.php";
$modulename = "Check Entry";

$crit = '';
if(isset($_GET['fromdate'])!="" && isset($_GET['todate'])!="")
{
	$fromdate = $cmn->dateformatusa(addslashes(trim($_GET['fromdate'])));
	$todate = $cmn->dateformatusa(addslashes(trim($_GET['todate'])));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['party_name']))
{
	$party_name = addslashes(trim($_GET['party_name']));
}
else
{
	$party_name='';	
}

if(isset($_GET['check_no']))
{
	$check_no = addslashes(trim($_GET['check_no']));
}
else
{
	$check_no = '';	
}
$crit = " where 1 = 1 ";
if($fromdate!="" && $todate !='')
{

	$crit .= " and check_date between '$fromdate' and '$todate' ";
}	


if($party_name !='')
{
	$crit .= " and  party_name ='$party_name' ";
	
}

if($check_no !='')
{
	$crit .= " and  check_no ='$check_no' ";
	
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; Check Entry Report </legend>
                            <table width="998">
                                    <tr>
                                            <th width="20" style="text-align:left;">From Date : </th>
                                            <th width="20" style="text-align:left;">To Date : </th>
                                            
                                            <th width="20" style="text-align:left;">Name Of Party  : </th> 
                                             <th width="20" style="text-align:left;">Cheque No : </th>                                               
                                            
                                    </tr>
                                    <tr>
                                            <td><input type="text" name="fromdate" id="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" autocoplete="off">
                                            </td>
                                            
                                            <td><input type="text" name="todate" id="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" autocoplete="off">
                                            </td>
                                            
                                            <td><input type="text" name="party_name" id="party_name" value="<?php echo $party_name; ?>" autocoplete="off">
                                            </td>
                                            
                                            <td><input type="text" name="check_no" id="check_no" value="<?php echo $check_no; ?>" autocoplete="off">
                                            </td>
                                           
                                               
                                            </tr>                       
                                           <tr> <td></td><td></td><td> <input type="submit" name="search" class="btn btn-success" id="" value="Search" >
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
                            
                            	<a class="btn btn-primary btn-lg" href="excel_check_entry_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&&party_name=<?php echo $party_name; ?>&check_no=<?php echo $check_no; ?>" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                             <th>Sno</th>
                                            <th>Name Of Party</th>
                                            <th>Cheque No</th>
                                           	<th>Cheque Amount</th>
                                            <th>Remark</th>
                                             <th>Date</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                     <?php
									
									$slno=1;
									$totalexp = 0;
									//echo "select * from check_entry $crit order by check_entry_id desc"; die;
									$sel = "select * from check_entry $crit order by check_entry_id desc"; 
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										        $check_amount = 0;									
												$check_amount = $row['check_amount'];
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo  $row['party_name']; ?></td>
                                            <td><?php echo $row['check_no']; ?></td>
                                           <td><?php echo $row['check_amount']; ?></td>
                                            <td><?php echo $row['remark'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['check_date']); ?></td>
										</tr>
                                        <?php
										$slno++;
										$totalexp += $check_amount;
									}
									?>
										
                                    <tr>
                                    		<td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($totalexp,2); ?></strong> </td>
                                        <td style="background-color:#00F; color:#FFF;"></td>
                                            <td style="background-color:#00F; color:#FFF;"> </td>
                                            
                                           
                                    </tr>									
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
//below code for date mask
jQuery(function($){
   $("#date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

</script>			
                
		
	</body>

	</html>
