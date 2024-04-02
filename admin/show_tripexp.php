<?php 
include("dbconnect.php");

   $keyvalue=$_REQUEST['id'];
   $trip_no=$_REQUEST['trip_no'];
   $truckid=$cmn->getvalfield($connection,"trip_entry", "truckid", "trip_id=$keyvalue");
//     $tripno=$cmn->getvalfield($connection,"trip_entry", "trip_no", "trip_id=$keyvalue");
//  $trip_no=$cmn->getvalfield($connection,"trip_expenses", "trip_no", "trip_expenses_id=$keyvalue");
   ?>
<div class="box-content nopadding">
								<table class="table table-hover table-nomargin">
									<thead>
										<tr>
										<th>Sno</th>
											<th>Expense  Name</th>
											<th>Amount</th>

											<th>Select Category</th>
											<th>Action</th>	
										</tr>
									</thead>
									<tbody>
									<tr>
										<?php $sn=1;
									
										if($keyvalue==0){
											// echo "select * from  trip_expenses where is_complete=0  && userid='$userid'";
                           $sql=mysqli_query($connection,"select * from  trip_expenses where is_complete=0  && userid='$userid' and trip_no='$trip_no'");


                        }else{
                    //  echo   "select * from  trip_expenses where trip_no='$tripno' && userid='$userid'"; 
          $sql=mysqli_query($connection,"select * from  trip_expenses where trip_no='$trip_no' && userid='$userid'");
                      
                        }

                           while($row=mysqli_fetch_array($sql)){
                           	// code...
                           
								
								$incex_head_name = $cmn->getvalfield($connection, "inc_ex_head_master", "incex_head_name", "inc_ex_id='$row[inc_ex_id]'");
 $totamt1+=$row['amt'];
                        
                           ?>
                                <tr>
                                     <td><?php echo $sn++;?></td>
									 			<td><?php echo $incex_head_name;?></td>

												<td><?php echo $row['amt'];?></td>
												<td><?php echo $row['category'];?></td>

									 			
									 			 <!-- <td><?php echo $unit_name;?></td>

                                                <td>
												<a title="Edit" href="trip_entry.php?eid=<?php echo $row['item_id'];?>" class="btn btn-success">
             E
            </a>  -->
			<td>
			    			<a  onClick="funDel1(<?php echo $row['trip_expenses_id']; ?>)" class="btn btn-satblue">Delete</a>

            </a>
						   </td>
            <!-- </a>
                                                </td>  -->
                                            <?php }?>
										</tr>
										<tr > 
											<th></th>
											<th></th>
											<th>Total: <?php echo $totamt1?></th>
											<th></th>
									
										<th></th></tr>
										
										
										
									</tbody>
									
								</table>
							