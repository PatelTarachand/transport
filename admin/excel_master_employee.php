<?php include("dbconnect.php");
$tblname = "m_employee";
$tblpkey = "empid";

 header("Content-type: application/vnd-ms-excel");
$filename = "excel_truck_owner".strtotime("now").'.xls';
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>


<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered table-condensed table-striped">
									<thead>
										<tr>
                                            <th>Sno</th>
                                            <th>Employee Name</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Date of Joining</th>
                                            <th>Sallary</th>
                                            <th>Company Name</th>
                                            <th>Blood Group</th>
                                            <th>Status</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_employee where empid != '-1' order by empid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										if($row['designation']==1)
										{
											$designation = "Driver";
										}
										else
										{
											if($row['designation']==2)
											{
												$designation = "Conductor";
											}
												else
												{
													if($row['designation']==3)
													{
														$designation = "Office Staff";
													}
												}
										}
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['empname'];?></td>
                                            <td><?php echo $row['mob1'];?></td>
                                            <td><?php echo $designation;?></td>
                                            <td><?php echo $cmn->dateformatindia($row['doj']);?></td>
                                            <td><?php echo $row['salary'];?></td>
                                           
                                            <td><?php echo  $cmn->getvalfield($connection,"m_company","cname","compid=$row[compid]");?></td>
                                           
                                            <td><?php echo $row['bloodgroup'];?></td>
                                            
                                       


                                        </head>
                                        <body >



                                            
                                            <td><strong style="color:red;">
												<?php 
											         $status = $row['status'];
											      if ( $status == 0 ) { $status= '<span >In-Active</span>';	} else { $status= '<span style=color:green;> Active</span>';}											
											     	echo  $status;  
												?>
                                                </strong></td>
                                            
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>