<?php include("dbconnect.php");
$tblname = "m_vender";
$tblpkey = "venderid";

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
                                           
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_vender order by venderid desc";//13 = to pay & -1 = other
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['vendername']);?></td>
                                            <td><?php echo ucfirst($row['contactno']);?></td>
                                            <td><?php echo ucfirst($row['email1']);?></td>
                                            <td><?php echo ucfirst($row['address']);?></td>
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>