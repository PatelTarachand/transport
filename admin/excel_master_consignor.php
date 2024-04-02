<?php include("dbconnect.php");
$tblname = "m_consignor";
$tblpkey = "consignorid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Consigoner</th>
                                            <th>Contact No</th>
                                            <th>Email(1)</th>
                                            <th>Address</th>
                                             <th>Place</th>
                                           
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_consignor  order by consignorid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['consignorname']);?></td>
                                            <td><?php echo ucfirst($row['contactno']);?></td>
                                            <td><?php echo ucfirst($row['email1']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                             <td><?php echo  $cmn->getvalfield($connection,"m_place","placename","placeid=$row[placeid]");?></td>
                                         
                                            
                                     
                                          
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>