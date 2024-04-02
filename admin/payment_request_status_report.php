<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='payment_request_status_report.php';
$modulename = "Payment Request Status";

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


if (isset($_GET['ac_holder'])) {
	$ac_holder = trim($_GET['ac_holder']);
}
else
$ac_holder='';
 

if($fromdate !='' && $todate !='')
{
		$crit.=" and adv_date between '$fromdate' and '$todate' ";	
}


 if(isset($_GET['truckid'])) {
	 $truckid = trim(addslashes($_GET['truckid']));
	 }
	 else
	 $truckid = "";
	 
	 if($truckid !='') { $crit .= " and truckid='$truckid'"; }
 
 
 if(isset($_GET['status'])) {
	 $status = trim(addslashes($_GET['status']));
	 }
	 else
	 $status = "";
	 
	 if($status !='') { $crit .= " and isconf='$status'"; }

 if($ac_holder !='')
	  { 
	  	$crit .= "and ac_holder like '%$ac_holder%'";
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
    				<fieldset style="margin-top:45px; margin-left:45px;" >   <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                     
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> Report </legend>
                            <table width="100%">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Truck No :</th>
                                            
                                           	
                                           <!--  <th width="208" style="text-align:left;">Consignee : </th>
                                            <th width="208" style="text-align:left;">To Place : </th>
                                            <th width="208" style="text-align:left;">GP No : </th>
                                            <th width="208" style="text-align:left;">Truck No : </th>
                                            -->
                                            <th width="15%" style="text-align:left;">Status : </th>
                                            <th width="15%" style="text-align:left;">Account Holder : </th>
                                            <th></th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td><select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from m_truck");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script></td>
                                            
                                           	
                           
                              <td><select id="status" name="status" class="select2-me input-large" style="width:220px;">
                        <option value=""> - All - </option>
                       <option value="0">Pending</option>
                       <option value="1">Accept </option>
                       <option value="2">Reject</option>
                        </select>
                        <script>document.getElementById('status').value = '<?php echo $status; ?>';</script></td>                 
                        <td>
                        	<input type="text" class="input-large" name="ac_holder" value="<?php echo $ac_holder; ?>" autocomplete="off" >
                        </td>                      
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td width="26%"> 
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
                             
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
											<th>DI No.</th>
											<th>GR NO</th>
											<th>Invoice No </th>
											<th>Truck No.</th>
											<th>Consignor</th>
											<th>Consignee</th>
											<th>Payment Date</th>
											<th>Commission</th> 
											<th>Final Pay</th>   
											<th>Ac Holder</th>   
											<th>Status</th>
											                       	 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$total_bilty = 0;
									$total_commission =0;
									$total_fpay =0;
									 	
									$sel = "select  * from bidding_entry where is_complete=1 $crit && consignorid=4 order by payment_date desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['di_no'];?></td>
							<td><?php echo $row['gr_no'];?></td>
                             <td><?php echo $row['invoiceno'];?></td>
                             <td><?php echo $truckno;?></td>
                           
                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                            <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                            <span style="color:#FFF;"> <?php echo $truckno; ?> </span>
                            </td>
                           
                           <td><?php echo $row['commission'];?></td>                         
                             <td><?php echo $row['ac_holder'] ?></td>
                             <td><?php echo number_format($row['cashpayment']+$row['chequepayment']+$row['neftpayment'],2);?></td>
                            <td><?php if($row['isconf']==0) { echo "Pending"; } else if($row['isconf']==1){ echo "Accept"; } else { echo "Reject"; } ?></td>
                           
                        </tr>
                                        <?php
										$slno++;

										  $total_fpay += $row['cashpayment']+$row['chequepayment']+$row['neftpayment'];
                                       $total_commission += $row['commission'];
								}
									?>
									</tbody>
							</table>
							</div>


							 <br>
                           <h4 style="text-align: center;" > <span style="color: blue"> Total Bilty : <?php echo $slno - 1; ?> </span> ,
                           			<span style="color: blue"> Total Commission : <?php echo $total_commission; ?> </span> ,
                           			<span style="color: blue"> Total Final Pay : <?php echo $total_fpay;  ?> </span>
                           	</h4>

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
