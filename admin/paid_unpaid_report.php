<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='paid_unpaind_report.php';
$modulename = "Paid Unpaid Report";

$crit=" ";

if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}
 @$selectype=$_GET['selectype'];
if($selectype!=''){
@$selectype=$_GET['selectype'];
    if($selectype=='Paid'){
       $crit.=" and is_complete='1'";
    }else{
        $crit.=" and is_complete='0'";
    }
}


if($fromdate !='' && $todate !='')
{
		$crit.=" and tokendate between '$fromdate' and '$todate' ";	
}

@$lr_no=$_GET['lr_no'];
if($lr_no!=''){
  $lr_no=$_GET['lr_no'];
  $crit.=" and lr_no='$lr_no'";
}
@$lr_no='';
 
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
    				<fieldset style="margin-top:45px; margin-left:45px;" > <!--   <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                      -->
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?></legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">LR No :</th>
                                             <th width="15%" style="text-align:left;">Select type</th>
                                            
                                           	
                                             <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="date" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="date" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td><input class="formcent" type="text" name="lr_no" id="lr_no"  value="<?php  
                                            			echo $lr_no;
                                            			  ?>"  data-date="true"  style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                           	<td>
                                           		<select id="selectype" name="selectype" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                      
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                           
                       
                        </select>
                        <script>document.getElementById('selectype').value = '<?php echo $selectype; ?>';</script>


                                           	</td>
                                            
                                            
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
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
             <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						
							<div class="box-title">
        <h3><i class="icon-table"></i>Paid Unpaid Report Details</h3>

								<a class="btn btn-primary btn-lg" href="excel_paid_unpaid.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&selectype=<?php echo $_GET['selectype']; ?>&lr_no=<?php echo $_GET['lr_no']; ?>" target="_blank" 
                                style="float:right;" >  Excel </a> </br>
							</div>
                            
                            	
							<div class="box-content nopadding" style="overflow: scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>SN</th>  
                                            <th>LR NO.</th>
                                            <?php if(@$_GET['selectype']=='Paid'){ ?>
                                            <th>Voucher No.</th>
                                            <?php } ?>
                                            <th>Consignee</th>
                                            <th>Truck No.</th>
                                            <th>Destination</th>
                      
                                              <th>Weight</th>
                                              <th>Rec. Weight</th>
                                              <th>Comapny Rate</th> 
                                              
                                              <th>Final Rate</th> 
                                              <th>Commission</th>
                                               <th>Payment <p>Commission</p></th> 
                                               <th>TDS</th>
                        
                                               <th>Diesal adv.</th>
                                               <th> Cash Adv. </th>
                                               
                                             <th>Total Amount</th>
                                              <th> Date </th>
                                                                    
                                            <th>Status</th>
                                                                           	 
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
									
									
									  $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid'  order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{					
                  $lr_no = $row['lr_no'];				
								$gr_date = $row['gr_date'];
								$truckid = $row['truckid'];
								$itemid = $row['itemid'];
								$consigneeid = $row['consigneeid'];
								$destinationid = $row['destinationid'];
								$supplier_id = $row['supplier_id'];
								$brand_id = $row['brand_id'];
								$s = $row['bilty_date'];
								$dt = new DateTime($s);								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');	
								$adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						 $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        $totalweight = $row['totalweight'];
                        $recweight = $row['recweight'];

                        $total_adv=$adv_cash+$adv_other+$adv_consignor;
                        $freightamt=$row['freightamt'];
                         $final_rate= $row['freightamt']-$row['trip_commission'];
                         $trip_commission=$row['trip_commission'];
                         $commission=$row['commission'];
                          $deduct=$row['deduct'];
                           $tds_amt=$row['tds_amt'];
							 $destinationid = $row['destinationid'];
                          $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");

                          $amount=$totalweight*$final_rate;
                            $netamount=$amount-$deduct;

                                $tds=$netamount*$tds_amt/100;
                                $total=$netamount-$tds;
                           $paidamount=$total-$commission-$total_adv-$adv_diesel;
                           
                           $is_complete=$row['is_complete'];
                           $voucher_id=$row['voucher_id'];


									?>
            <tr tabindex="<?php echo $slno; ?>" class="abc">
                    <td><?php echo $slno; ?></td>
                    <td><?php echo $row['lr_no'];?></td>
                       <?php if(@$_GET['selectype']=='Paid'){ ?>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id = '$voucher_id'"));?></td>
                                            <?php } ?>
					          <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                    <td><?php echo $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     ?></td>
                            <td><?php echo $toplace; ?></td>
                          
                           
                            </td>
                           <td><?php echo $totalweight;?></td>
                           <td><?php echo $recweight;?></td>
                           <td><?php echo $freightamt;?></td>
                            <td><?php echo $final_rate; ?></td>
                             <td><?php echo $trip_commission;?></td>
                              <td><?php echo $commission;?></td> 
                              <td><?php echo round($tds);?></td> 
                              <td><?php echo $adv_diesel; ?></td>  
                              <td><?php echo $total_adv;?></td>                      
                            
                             
                            <?php if($is_complete!=0){ ?>
                            	<td><?php echo number_format(round($paidamount),2);?></td>	
                              <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                              <td>Paid</td>
                            <?php }else{ ?>
                            	<td><?php echo number_format(round($paidamount),2);?></td>	
                            	<td><?php echo $cmn->dateformatindia($row['tokendate']);?>
                              <td>Unpaid</td>
                            <?php }  ?> 	
                 
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
