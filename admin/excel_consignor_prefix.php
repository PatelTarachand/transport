<?php include("dbconnect.php");
$tblname = "consignor_prefixsetting";
$tblpkey = "prefixid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr >
                                            <th>Sno</th>
                                            <th>Consignor Name</th>
                                            <th>Session Name</th>
                                              <th>Prefix Name</th>
                                           										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from consignor_prefixsetting";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");
										$session_name = $cmn->getvalfield($connection,"m_session","session_name","sessionid='$row[sessionid]'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $consignorname;?></td>
                                            <td><?php echo $session_name;?></td>
                                             <td><?php echo $row['consignor_prefix'];?></td> 
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>