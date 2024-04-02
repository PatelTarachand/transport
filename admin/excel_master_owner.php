<?php include("dbconnect.php");
$tblname = "m_truckowner";
$tblpkey = "ownerid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck Owner</th>
                                            <th>Father Name</th>
                                        	<th>Adress</th>
                                            <th>Mobile</th>
                                            <th>PAN No</th>
                                           <th>Bank Name</th>
                                            <th>A/C Number</th>
                                        	<th>Branch</th>
                                            <th>IFSC Code</th>
                                            <th>Owner Type</th>
                                            
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_truckowner order by ownerid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                                <td><?php echo $slno; ?></td>
                                                <td><?php echo ucfirst($row['ownername']);?></td>
                                                <td><?php echo ucfirst($row['father_name']);?></td>
                                                <td><?php echo ucfirst($row['owneraddress']);?></td>
                                                <td><?php echo $row['mobileno1'];?></td>
                                                <td><?php echo ucfirst($row['pan']);?></td>
                                                <td><?php echo ucfirst($row['bank_name']);?></td>
                                                <td><?php echo $row['ac_number'];?></td>
                                                <td><?php echo $row['branch_name'];?></td>
                                                <td><?php echo $row['ifsc_code'];?></td>
                                                <td><?php echo ucfirst($row['owner_type']);?></td>
                                          
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>






?>