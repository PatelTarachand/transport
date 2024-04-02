<?php include("dbconnect.php");
$tblname = "m_truck";
$tblpkey = "truckid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck No.</th>
                                            <th>Type</th>
                                            <th>Owner</th>
                                            <th>Manufacturer</th>
                                            <th>Model</th>
                                            <th>Chesis No</th>
                                            <th>Engine No</th>
                                            <th>Openning Km</th>                                          
                                            <th>Make Year</th>
                                                                                       
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_truck order by truckid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['truckno']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_trucktype","typename","typeid=$row[typeid]"); ?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_truckowner","ownername","ownerid=$row[ownerid]"));?></td>
                                            <td><?php echo ucfirst($row['manufacturer']);?></td>
                                            <td><?php echo ucfirst($row['model']);?></td>
                                            <td><?php echo ucfirst($row['chesisno']);?></td>
                                            <td><?php echo ucfirst($row['engineno']);?></td>
                                            <td><?php echo ucfirst($row['openningkm']);?></td>                                          
                                            <td><?php echo ucfirst($row['make']);?></td>
                                            
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>