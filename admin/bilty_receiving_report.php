<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bidding_entry_report.php';
$modulename = "Bidding Report";

$crit=" ";

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

if($fromdate !='' && $todate !='')
{
		$crit.=" and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate' ";	
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
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;Bilty Receiving Report </legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            
                                            
                                           	
                                           <!--  <th width="208" style="text-align:left;">Consignee : </th>
                                            <th width="208" style="text-align:left;">To Place : </th>
                                            <th width="208" style="text-align:left;">GP No : </th>
                                            <th width="208" style="text-align:left;">Truck No : </th>
                                            -->
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            
                                            
                                           	
                                            
                                            
                                            
                                          
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
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								
							</div>
                            
                            	<a class="btn btn-primary btn-lg" href="excel_bilty_recieving.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&ownerid=<?php echo $ownerid; ?>&itemid=<?php echo $itemid; ?>&consignorid=<?php echo $consignorid; ?>" target="_blank" 
                                style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Di no.</th>
                                             <th>Di Date</th>
                                        	<th>Consignor</th>
                                            <th>Session </th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                            <th>Remark</th>
                                             <!--<th>Print</th>-->
                                        	
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
										$cond="where createdby='$userid' ";	
									}
									
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' $crit order by bid_id desc limit 500";
									
									
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
										
								$s = $row['tokendate'];
								$dt = new DateTime($s);
								
								$date = $dt->format('d-m-Y');
								$time = $dt->format('H:i:s');
										

									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                             <td><?php echo $date;?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_session","session_name","sessionid = '$row[sessionid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
											<td><?php echo ucfirst($row['remark']);?></td>

                                           <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                           
                                           
                                            
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
