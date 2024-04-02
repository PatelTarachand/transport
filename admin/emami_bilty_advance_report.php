<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='emami_bilty_advance_report.php';
$modulename = "Bilty Advance";

$crit=" ";

if (isset($_GET['search'])) {
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
} else {
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d', strtotime('-3 month', strtotime($todate)));
}


@$selectype=$_GET['selectype'];
if($selectype!=''){
  $selectype=$_GET['selectype'];
  $crit.=" and selectype='$selectype'";
}
@$selectype='';


@$itemid=$_GET['itemid'];
if($itemid!=''){
  $itemid=$_GET['itemid'];
  $crit.=" and itemid='$itemid'";
}
@$itemid='';

if($fromdate !='' && $todate !='')
{
		$crit.=" and adv_date between '$fromdate' and '$todate' ";	
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> Report </legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Item Name :</th>
                                             <th width="15%" style="text-align:left;">Select Advance type</th>
                                            
                                           	
                                           <!--  <th width="208" style="text-align:left;">Consignee : </th>
                                            <th width="208" style="text-align:left;">To Place : </th>
                                            <th width="208" style="text-align:left;">GP No : </th>
                                            <th width="208" style="text-align:left;">Truck No : </th>
                                            -->
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="width:150px;margin-right:10px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="width:150px;margin-right:10px;" autocomplete="off" ></td>
                                            
                                            <td><select id="itemid" name="itemid" class="select2-me input-large" style="width:170px;margin-right:10px;">
                        <option value=""> - All - </option>
           
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select * from inv_m_item");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['itemid']; ?>"><?php echo $row_fdest['itemname']; ?></option>
                        <?php
                        } ?>
                              <script>document.getElementById('itemid').value = '<?php echo $itemid; ?>';</script>

                        </select>
                       </td>
                                            
                                           	<td>
                                           		<select id="selectype" name="selectype" class="select2-me input-large" style="width:170px;margin-right:10px;">
                        <option value=""> - All - </option>
                      
                            <option value="Advance Cash">Advance Cash</option>
                            <option value="Advance Diesel">Advance Diesel</option>
                           
                       
                        </select>
                        <script>document.getElementById('selectype').value = '<?php echo $selectype; ?>';</script>


                                           	</td>
                                            
                                            
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;border-radius:4px !important;">Reset</a>
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
            <div class="container-fluid">
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
					<h3><i class="icon-table"></i>Bilty Advance Report List</h3>

					</div>
                            	
							<div class="box-content nopadding" style="overflow: scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
								<a class="btn btn-primary btn-lg" href="excel_emami_bilty_advance_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&itemid=<?php echo  $_GET['itemid']?>&selectype=<?php echo $_GET[selectype]; ?>" target="_blank" 
                                style="float:right;margin-top:10px;margin-right:10px;" >  Excel </a>
									<thead>
										<tr>
                                            <th>SN</th>  
                                            <th>LR No</th>
                                            <th>Bilty Date</th>
                                        	<th>Invoice No</th>
											<th>Invoice Date</th>
											<th>E Way Bill No</th>
                                            <th>DI No</th>
											<th>Consignee</th>
											<th>Destination</th>
											 <th>Truck No</th>
										
                                            <th>Item Name</th>
                                            <th>Weight
                                            	<p>/(M.T.)</p></th>
                                            <th>Qty</th>
                                            <?php 
                                            if(@$selectype=='Advance Cash'){
                                            ?>
                                            <th>Advance</th>
                                           
                                           
                                             <?php 
                                        		 }
                                            else if(@$selectype=='Advance Diesel'){
                                            ?>
                                            <th>Diesel Rs</th>
                                            <th>Petrol Pump</th>
                                        	<?php }
                                        	else { ?>
                                        		 <th>Advance</th>
                                        		 
                                        		 <th>Diesel Rs</th>
                                        		 <th>Petrol Pump</th>
                                        	<?php } ?>
                                             <th>Other <p>Advance Date</p></th>
                                            <th>Rec. Weight</th>
											<th>Rec Bags</th>
											<th>Rec Date</th>
                                                                           	 
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
									
								// 	echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid' order by bid_id desc";
									 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and compid='$compid' order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{									
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
								$advance = $row['adv_cash']+$row['adv_cheque'];
									?>
            <tr tabindex="<?php echo $slno; ?>" class="abc">
                    <td><?php echo $slno; ?></td>
					<td><?php echo $row['lr_no'];?></td>
                    <td><?php echo $row['tokendate'];?></td>
					<td><?php echo $row['invoiceno'];?></td>
					<td><?php echo $cmn->dateformatindia($row['inv_date']);?></td>
                    <td><?php echo $row['ewayno'];?></td>                    
                    <td><?php echo $row['gr_no'];?></td>
					<td><?php echo $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");?></td>
                   <td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");?></td>
					<td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");?></td>
					

					<td><?php echo $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");?></td>
					 <td><?php echo ucfirst($row['totalweight']);?></td>
					  <td><?php echo ucfirst($row['noofqty']);?></td>
                   
                         <?php 
                                            if($selectype=='Advance Cash'){
                                            ?>              
                    <td><?php echo ucfirst($advance);?></td>
                     
                                           
                    	
                    	<?php	 }
                                            else if($selectype=='Advance Diesel'){
                                            ?>
					<td><?php echo ucfirst($row['adv_diesel']);?></td>
                    <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td>
                    <?php }
                                        	else { ?>
                                     <td><?php echo ucfirst($advance);?></td>
                                     
                                     <td><?php echo ucfirst($row['adv_diesel']);?></td>
                    <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");?></td>
                                        		<?php } ?>
                                        		<td><?php echo $cmn->dateformatindia($row['adv_date']);?></td>
                    <td><?php echo ucfirst($row['recweight']);?></td>
					<td><?php echo ucfirst($row['recbag']);?></td>
					<td><?php echo $cmn->dateformatindia($row['recdate']);?></td>					
                    
                 
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
