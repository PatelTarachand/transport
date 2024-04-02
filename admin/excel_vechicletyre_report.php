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




 

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="excel_paid_unpaid.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
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


<script>window.close();</script>