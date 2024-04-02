<?php 
include("dbconnect.php");
$tblname = 'tokenpass';
$tblpkey = 'tpass_id';
$pagename  ='excel_token.php';
$modulename = "Token Entry Report";

if(isset($_GET['fromdate']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	
}
if(isset($_GET['todate']))
{
	
	$todate = trim(addslashes($_GET['todate']));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
}

if(isset($_GET['itemid']))
{
	$itemid = trim(addslashes($_GET['itemid']));
	
}

if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));
	
}

$crit =" 1=1 ";
if($ownername !='')
{
	$crit .=" and truckowner='$ownername' ";
}

if($itemid !='')
{
	$crit .=" and itemid='$itemid' ";
}

if($consignorid !='')
{
	$crit .=" and consignorid='$consignorid' ";
}


// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="bilty_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>


<table border="1" >
									
                                    <thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Token no.</th>
                                        	<th>Tocken Date</th>
                                            <th>Truck No </th>
                                            <th>Driver Name</th>
                                            <th>Destination</th>
                                            <th>Qty</th>
                                            <th>Mobile</th>
                                           
                                             <!--<th>Print</th>-->
                                        	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{
										$cond="where 1=1 ";	
									}
									else
									{
										$cond="where createdby='$userid' ";	
									}
									
									$sel = "select * from tokenpass $cond  order by tpass_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{

									?>
            <tr>
                    <td><?php echo $slno; ?></td>
                    <td><?php echo ucfirst($row['token_no']);?></td>
                    <td><?php echo $cmn->dateformatindia($row['tocken_date']);?></td>
                    <td><?php  echo $row['truck_no'];?></td>                    
                    <td><?php echo $row['driver_name']?></td>
                    <td><?php echo ucfirst($row['destination']);?></td>
                    <td><?php echo ucfirst($row['qty']);?></td>
                    <td><?php echo ucfirst($row['mobile']);?></td>
                    
            </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
</table>


<script>window.close();</script>