<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='paid_unpaind_report.php';
$modulename = "Vehicle Tyre Report";
$crit=" ";

if(isset($_GET['search']))
{
	$fromdate = $_GET['fromdate'];
	$todate =  $_GET['todate'];
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}

	$truckid = $_GET['truckid'];





if($fromdate !='' && $todate !='')
{
		$crit.=" uploaddate between '$fromdate' and '$todate' ";	
}

if($truckid !='')
{
	$crit .= " and truckid = '$truckid' ";
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
    				<fieldset style="margin-top:45px; margin-left:45px;" > <!--   <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                      -->
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?></legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                             <th width="15%" style="text-align:left;">Truck No.</th>
                                            
                                           	
                                             <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input type="date" name="fromdate" id="fromdate"  value="<?php echo $fromdate; ?>"  data-date="true"  style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input " type="date" name="todate" id="todate"  value="<?php echo $todate; ?>"  data-date="true"  style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                           
                                            
                                           	<td>
                                           		<select id="truckid" name="truckid" style="width:200px;" class="select2-me">

                                        	<option value="" selected>-Select-</option>

                                            <?php 

											$sql3 = "select A.* from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by truckno";

											$res3 = mysqli_query($connection,$sql3);

											while($row3 = mysqli_fetch_assoc($res3))

												{

											?>

                                          	<option value="<?php echo $row3['truckid']; ?>"><?php echo $row3['truckno']; ?></option>

                                            <?php

												}

												?>

                                      </select>

							      <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script>

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
        <h3><i class="icon-table"></i>Vehicle Tyre Report Details</h3>

								<a class="btn btn-primary btn-lg" href="excel_vechicletyre_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&selectype=<?php echo $_GET['selectype']; ?>&lr_no=<?php echo $_GET['lr_no']; ?>" target="_blank" 
                                style="float:right;" >  Excel </a> </br>
							</div>
                            
                            	
							<div class="box-content nopadding" style="overflow: scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered;">
									<thead>
										<tr>
                                               <th>S.no</th>
                  <th>Issue Category</th>
                   <th>Truck No.</th>
                  <th>Tyre Name</th>
                  <th>Serial No.</th>
                  <th>Meter Reading</th>
                  <th>Upload Date</th>
                  <th>Return Category</th>
                  <!--<th>Tyre New Image</th>-->
                  <!--<th>Tyre Old Image</th>-->
                  <th>Old Tyre Name</th>
                  <th>Old Tyre Serial No.</th>
                                                                           	 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
								 $slno = 1;
          //echo    "select * from tyre_map where $crit ORDER BY mapid DESC";
                  $sel = "select * from tyre_map where $crit ORDER BY mapid DESC";
                  $res = mysqli_query($connection, $sel);
                  while ($row = mysqli_fetch_array($res)) {
                                $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
                     $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","pos_id='$row[pos_id]'");
                   
                       $itemname = $cmn->getvalfield($connection,"items","item_name","itemid='$row[itemid]'");
                       $item_id = $cmn->getvalfield($connection,"purchaseorderserial","itemid","pos_id='$row[rpos_id]'");
                       $old_serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","pos_id='$row[rpos_id]'");
                       $old_itemname = $cmn->getvalfield($connection,"items","item_name","itemid='$item_id'");
                  ?>
               <tr tabindex="<?php echo $slno; ?>" class="abc">
                  <td><?php echo $slno; ?></td>
                  <td><?php echo $row['issue_cate']; ?></td>
                  <td><?php echo $truckno; ?></td>
                  <td><?php echo $itemname; ?></td>
                  <td><?php echo $serial_no; ?></td>
                  <td><?php echo $row['meterreading']; ?></td>
                  <td><?php echo dateformatindia($row['uploaddate']); ?></td>
                  <td><?php echo $row['return_cate']; ?></td>
                
                  <!--<td>  <a href="uploaded/newtyre/<?php echo $row['tyre_new_image']; ?>" target="_blank" download>download</a></td>-->
                  <!--<td> <a href="uploaded/oldtyre/<?php echo $row['tyre_old_image']; ?>" target="_blank" download>download</a></td>-->
                  <td><?php echo $old_itemname; ?></td>
                  <td><?php echo $old_serial_no; ?></td>
                  <!-- <td class='hidden-480'>
                     
                     <a onClick="funDelotp('<?php echo $row['billid']; ?>');"><img src="../img/del.png" title="Delete"></a>
                     <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['billid']; ?>" onClick="funDel('<?php echo $row['billid']; ?>');" value="X">
                     
                     &nbsp;&nbsp;&nbsp;
                   
                  </td> -->


								
       
                	
                 
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
// jQuery(function($){
//   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
// });

// jQuery(function($){
//   $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
// });

</script>			
                
		
	</body>

	</html>
