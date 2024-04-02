<?php include("dbconnect.php");
$tblname = "m_bank";
$tblpkey = "bankid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Bank</th>
                                        	<th>Branch</th>
                                            <th>Address</th>
                                            <th>A/C No</th>
                                            <th>Contact Person</th>
                                            <th>Mobile</th>
                                            <th>Phone</th>
                                        	
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_bank order by bankid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['bankname']);?></td>
                                            <td><?php echo ucfirst($row['branchname']);?></td>
                                            <td><?php echo ucfirst($row['bankaddress']);?></td>
                                            <td><?php echo ucfirst($row['helpline']);?></td>
                                            <td><?php echo ucfirst($row['contactpersion']);?></td>
                                            <td><?php echo ucfirst($row['mobileno']);?></td>
                                            <td><?php echo ucfirst($row['ifsc_code']);?></td>
                                            
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>
