<?php 
error_reporting(0);
include("dbconnect.php");

$tblpkey = "emppayment_id";
$pagename = "tyre_details.php";
$modulename = "Tyre";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

</head>

<body>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">		
		<div id="main">
			<div class="container-fluid">
      
			  <!--  Basics Forms -->
			 
                
                
               
                <!--   DTata tables -->
                <div class="row-fluid"  >
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Purchase Date</th> 
                                            <th>Bill No.</th> 
                                            <th>Item Name </th> 
                                          
                                            <th>Tyre No.</th> 
                                          
                                        	<th>Unit Name</th>                                            
                                        
                                            <th>Qty</th>  
                                            <!--<th>Action</th>                                                         -->
                                        	                                     
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									
									$slno=1;
                                   
									$sql = "select * from purchasentry_detail order by purdetail_id desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","empid='$row[empid]'");
										$unitname = $cmn->getvalfield($connection,"m_unit","unitname","unitid='$row[unitid]'"); 
                                        $itemname=$cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$row[itemid]'");
									
										$billno = $cmn->getvalfield($connection,"purchaseentry","billno","purchaseid='$row[purchaseid]' "); 
	$purchase_date = $cmn->getvalfield($connection,"purchaseentry","purchase_date","purchaseid='$row[purchaseid]' "); 
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                             <td><?php echo dateformatindia($purchase_date);?></td> 
                                             <td><?php echo $billno;?></td>  
                                             
                                            <td><?php echo ucfirst($itemname);?></td>                                        
                                        
                                            <td><?php echo ucfirst($row['serial_no']);?></td>
                                            <td><?php echo ucfirst($unitname);?></td> 
                                         
                                           
                                             <td><?php echo ucfirst($row['qty']);?></td> 
                                      
                                         
                                           <!-- <td class='hidden-480'>-->
                                            
                                           <!--<a href= "?edit=<?php echo $row['emppayment_id'];?>"><img src="../img/b_edit.png" title="Edit"></a>-->
                                           <!--&nbsp;&nbsp;&nbsp;-->
                                           <!--<a onClick="funDel('<?php echo $row['emppayment_id']; ?>')"  style="display:"><img src="../img/del.png" title="Delete" ></a>-->
                                           <!--</td>-->
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
				<?php 
				
				?>			
			</div>
		</div></div>

	</body>
  	</html>
<?php
mysqli_close($connection);
?>
