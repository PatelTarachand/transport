<?php include("dbconnect.php");
$tblname = "m_consignee";
$tblpkey = "consigneeid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Consignee Name</th>
                                            <th>Contact Person</th>
                                            <th>Phone No</th>
                                            <th>Contact No(1)</th>
                                            <th>Contact No(2)</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_consignee order by consigneeid  desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['consigneename']);?></td>
                                            <td><?php echo ucfirst($row['contactname']);?></td>
                                            <td><?php echo ucfirst($row['phoneno']);?></td>
                                            <td><?php echo ucfirst($row['mob1']);?></td>
                                            <td><?php echo ucfirst($row['mob2']);?></td>
                                            <td><?php echo ucfirst($row['email']);?></td>
                                            <td><?php echo ucfirst($row['consigneeaddress']);?></td>
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>