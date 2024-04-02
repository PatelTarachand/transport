<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'otherincome';
$tblpkey = 'otherincomeid';
$pagename  ='bonus_report.php';
$modulename = "Diesel Demand Slip Report";

if($_GET['fromdate']!="" && $_GET['todate']!="")
{
	$fromdate = $cmn->dateformatusa(addslashes(trim($_GET['fromdate'])));
	$todate = $cmn->dateformatusa(addslashes(trim($_GET['todate'])));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}

$crit = " where 1 = 1 ";
$cond = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{
	$crit .= " and diedate between '$fromdate' and '$todate'";
	$cond .=" and adv_date between '$fromdate' and '$todate'";
}

if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";	
	$cond .= " and  truckid ='$truckid' ";	
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; <?php echo $modulename; ?></legend>
                            <table width="998">
                                    <tr>
                                            <th width="212" style="text-align:left;">Fromdate: <span class="red">*</span></th>
                                            <th width="227" style="text-align:left;">Todate : <span class="red">*</span></th>
                                           <th width="212" style="text-align:left;">Truck No : </th> 
                                             
                                    </tr>
                                    <tr>
                                            <td><input type="text" name="fromdate" id="fromdate" autocoplete="off" value="<?php echo $cmn->dateformatindia($fromdate); ?>">
                                                                       
                                            </td>
                                            <td><input type="text" name="todate" id="todate" autocoplete="off" value="<?php echo $cmn->dateformatindia($todate); ?>">
                                                
                                                    
                                            </td>
                                            <td>  
                                                 <select id="truckid" name="truckid" class="formcent select2-me" style="width:224px;">
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select A.truckid,truckno from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid  
														 order by A.truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                            </td>  </tr>
                                             
                                            
                                    <tr>                
                                            <td colspan="3"> <input type="submit" name="search" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate'); " >
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
								<h4>Diesel Demand Slip Report Report</h4>
							</div>
                            
                            	<a class="btn btn-primary btn-lg" href="excel_bonus_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&head_id=<?php echo $head_id; ?>&truckid=<?php echo $truckid; ?>&payment_type=<?php echo $payment_type; ?>" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Slip No</th> 
                                            <th>Date</th> 
                                            <th>Truck No </th>
                                            <th>Driver Name</th>
                                            <th>Average</th> 
                                            <th>Supplier</th>
                                            <th>Item</th>
                                            <th>Rate</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                            <th>Narration</th>
										</tr>
									</thead>
                                    <tbody>
                                     <?php
									$slno=1;
									$totalexp = 0;
									$sql = "select B.slipno,diedate,truckid,drivername,actual_avg,remarks,supplier_id,productid,qty,rate,naration from diesel_demand_detail as A left join diesel_demand_slip as B on A.dieslipid=B.dieslipid $crit order by diedate desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{			
										$slipno = $row['slipno'];
										$diedate = $row['diedate'];
										$truckid = $row['truckid'];
										$drivername = $row['drivername'];
										$actual_avg = $row['actual_avg'];
										$remarks = $row['remarks'];
										
										$supplier_id = $row['supplier_id'];
										$productid = $row['productid'];
										$qty = $row['qty'];
										$rate = $row['rate'];
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($slipno);?></td>       
                                            <td><?php echo $cmn->dateformatindia($diedate);?></td>   
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");  ?></td>
                                            <td><?php echo ucfirst($drivername);?></td>
                                            <td><?php echo number_format($actual_avg,2);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'"); ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"inv_m_deisel_product","itemname","productid='$productid'"); ?></td>
                                            <td><?php echo $rate; ?></td>
                                            <td><?php echo $qty; ?></td>
                                            <td><?php echo $rate * $qty; ?></td>
                                            <td><?php echo $row['naration']; ?></td>     
										</tr>
                                       <?php
										$slno++;
										$tot_amt += $rate * $qty;
									}
									?>
									
        <tr>
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"><strong>Total</strong></td>
            <td style="background-color:#00F; color:#FFF;"> </td>           
            <td style="background-color:#00F; color:#FFF;"> </td>                                         
            <td style="background-color:#00F; color:#FFF;"> </td>   
            <td style="background-color:#00F; color:#FFF;"> </td>   
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"> </td> 
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php echo number_format($tot_amt,2); ?></strong></td>               
             <td style="background-color:#00F; color:#FFF;"> </td>
        </tr>					
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
                
                <br>
				<br>
				<br>

                
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
										<h4>Bilty Diesel Advance Report</h4>
							</div>                      	
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                               
                                            <th>Sno</th>  
                                          <th>Bilty No.</th>
                                             <th>Truck No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>                                         
                                             <th>Diesel Advance</th> 
                                            <th>Petrol Pump</th>  
                                            <th>Advance Date</th>
                                                                                                                                         					 								</tr>
									</thead>
                                    <tbody>
                                    
                                   <?php
									$slno=1;
									$tot_adv_dieselltr=0;									
									$totalexp = 0;
									$sql = "select * from bilty_entry  $cond and adv_dieselltr !=0 order by adv_date desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{										
											$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									?>
        <tr>
            <td><?php echo $slno; ?></td>
            <td><?php echo ucfirst($row['billtyno']);?></td>
             <td><?php echo $truckno;?></td>
            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?> </td>
            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?> </td>  
            <td><?php echo number_format($row['adv_dieselltr'],2);?></td>
            <td><?php echo ucwords($row['petrol_pump_type']);?></td> 
            <td><?php echo $cmn->dateformatindia($row['adv_date']); ?></td>  
        </tr>
                                       <?php
										$slno++;
								$tot_adv_dieselltr += $row['adv_dieselltr'];											
									}
									?>
          <tr>
            <td style="background-color:#00F; color:#FFF;"> </td>
            <td style="background-color:#00F; color:#FFF;"></td>
            <td style="background-color:#00F; color:#FFF;"> </td>           
            <td style="background-color:#00F; color:#FFF;"> </td>                                         
            <td style="background-color:#00F; color:#FFF;"> </td>   
            <td style="background-color:#00F; color:#FFF;"> <strong>Total</strong></td>   
            <td style="background-color:#00F; color:#FFF;"><?php echo number_format($tot_adv_dieselltr,2); ?></td>         
            <td style="background-color:#00F; color:#FFF; text-align:right;"><strong><?php //echo number_format($totalbonus + $totaluchantibonus,2); ?></strong></td>              <td style="background-color:#00F; color:#FFF;"> </td> 
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
