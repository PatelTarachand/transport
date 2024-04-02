<?php include("dbconnect.php");
$tblname = "consignor_ratesetting";
$tblpkey = "rateid";

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
                                              <th>Place</th>
                                                <th>Rate</th>
                                                  <th>Set Date</th>
                                           										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from consignor_ratesetting order by rateid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'");
										$session_name = $cmn->getvalfield($connection,"m_session","session_name","sessionid='$row[sessionid]'");
										$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$row[placeid]'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $consignorname;?></td>
                                            <td><?php echo $session_name;?></td>
                                             <td><?php echo $placename;?></td>
                                             <td><?php echo $row['rate'];?></td> 
                                              <td><?php echo $cmn->dateformatindia($row['setdate']);?></td> 
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>