<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'billty';
$tblpkey = 'billtyid';
$pagename  ='billty_form.php';
$modulename = "Billty";
//print_r($_SESSION);
$crit = "";

if(isset($_REQUEST['billtydate']) && $_REQUEST['billtydate']!="" && isset($_REQUEST['todate']) && $_REQUEST['todate']!="")
{
	$billtydate = $cmn->dateformatusa($_REQUEST['billtydate']);
	$todate = $cmn->dateformatusa($_REQUEST['todate']);
	$crit .= " and (DATE_FORMAT(tokendate,'%Y-%m-%d') between '$billtydate' and '$todate') ";
}





$sel = "select * from bilty_entry $crit order by bilty_id desc";?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>

</head>

<body data-layout-topbar="fixed">
	

	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3>
							</div>
							<div class="box-content nopadding">
                            <form action="" method="get">
                            <table width="100%" border="0" class="table table-condensed table-bordered">
                      <tr> 
                        <td width="13%" scope="col"><strong>From Date</strong> </td>
                       <td width="12%">
                        <input class="input-medium" type="hidden" name="consignorid" id="consignorid"  value="<?php echo $consignorid; ?>" >
                        
                    <input class="input-medium" type="text" name="billtydate" id="billtydate"  value="<?php echo $cmn->dateformatindia($billtydate); ?>"  data-date="true" required style="border: 1px solid #368ee0" >
                </td>
                
                  <td width="6%" scope="col"><strong>To Date</strong> </td>
                       <td width="11%">
                    <input class="input-medium" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0" >
                </td>
                
                
                
                <td width="58%"> <input type="submit" name="submit" class="btn btn-success" id="" value="Search" onClick="return checkinputmaster('billtydate,todate');">
                    <a href="billty_record.php" class="btn btn-danger">Cancel</a>
                     </td>
                        
                      </tr>
                      
                    </table>
                    </form>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Di no.</th>
                                        	<th>Consignee</th>
                                            <th>Session </th>
                                            <th>Item</th>
                                            <th>Company Rate/(M.T.)</th>
                                            <th>Own Rate/(M.T.)</th>
                                            <th>Total Weight/(M.T.)</th>
                                            <th>Remark</th>
                                             <!--<th>Print</th>-->
                                        	 <th>Action</th>
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
									
									$sel = "select * from bidding_entry $cond && sessionid='$sessionid' $crit order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_session","session_name","sessionid = '$row[sessionid]'"));?></td>
                                             <td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>
											<td><?php echo ucfirst($row['comp_rate']);?></td>

                                            <td><?php echo ucfirst($row['own_rate']);?></td>
                                            
                                            <td><?php echo ucfirst($row['totalweight']);?></td>
											<td><?php echo ucfirst($row['remark']);?></td>

                                           <!--<td><a href= "pdf_bill_invoice.php?bilty_id=<?php //echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>-->
                                           
                                           
                                            <td class='hidden-480'>
                                           <a href= "bidding_entry.php?edit=<?php echo ucfirst($row['bid_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <!--<a onClick="funDel('<?php //echo $row['bid_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
                                           </td>
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


function get_dispatch_list()
{
	consignorid = $("#consignorid").val();
	billtydate = $("#billtydate").val();
	todate = $("#todate").val();
	isbilled = $("#isbilled").val();
	if(consignorid != ""){
	$.ajax({
	type: 'POST',
	url: 'ajax_get_dispatch_list.php',
	data: 'consignorid=' + consignorid + '&billtydate=' + billtydate + '&todate=' +todate+ '&isbilled=' + isbilled,
	dataType: 'html',
	success: function(data){
		document.getElementById('dispatch_list').innerHTML = data;
		}
	});//ajax close
	}
}
jQuery(function($){
   $("#billtydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
  $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});
</script>			
                
		
	</body>

	</html>
