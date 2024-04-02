<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "issueentrydetail";
$tblpkey = "issuedetailid";
$pagename = "itemwise_issue_report.php";
$modulename = "Item Issue Detail Report";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	$truckid = trim(addslashes($_GET['truckid'])); 
	$itemid = trim(addslashes($_GET['itemid']));
 	
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
	$itemid='';
	$truckid='';
	$is_rep='';
	$excrec = '';
}


$crit =" where 1=1 ";
if($fromdate !='' && $todate !='') {
		$crit .=" and  issudate between '$fromdate' and '$todate' ";
	}

if($truckid !='')
{
	$crit .=" and B.truckid='$truckid' ";
}

if($itemid !='')
{
	$crit .=" and A.itemid='$itemid' ";
}
 

header("Content-type: application/vnd-ms-excel");
$filename = "Itemwise Issue Report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=".$filename);

?>

<!doctype html>

<html>
<head>
</head>
<body>

	<table border="1">

									<thead>
										<tr>   
                                                <th>Sno</th>  
                                                <th>Item Name</th> 
                                                <th>Unit</th> 
                                                <th>Qty</th>
                                                <th>Exchange Receipt</th>
                                                <th>Return Category</th>
                                                <th>Truck No</th>
                                                <th>Driver Name</th>
                                                <th>Issue No</th>
                                                <th>Issue Date</th>  
                                                <th>Remark</th>
										</tr>
									</thead>
                                    <tbody>
                                      <?php
									$slno=1;
							
									$sel = "select A.*,B.truckid,B.driver_name,issuno,issudate,B.remark ,B.meterread from issueentrydetail as A left join  issueentry as B on  A.issueid=B.issueid   
									$crit order by B.issuno desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];
										$empid = $row['empid'];
										$item_id = $row['item_id'];
										$unit_name = $row['unit_name'];
										$issuedetailid = $row['issuedetailid'];
										$qty = $row['qty'];
				$itemcategoryname=$cmn->getvalfield($connection,"item_master","itemcategoryname","item_id='$item_id'");

									?>

										<tr>

                                           <td><?php echo $slno; ?></td>

                                             <td><?php echo  $itemcategoryname?></td>
											 <td><?php echo $row['unit_name'];?></td>

                                            <td><?php echo $row['qty'];?></td>
                                            <td><?php echo $row['excrec']; ?></td>
                                            <td><?php echo $row['is_rep']; ?></td>
                                            <td><?php echo  $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'"); ?></td>
											<td><?php echo $row['driver_name']; ?></td>

                                            <td><?php echo $row['issuno'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['issudate']);?></td>
                                       		 <td><?php echo $row['remark']; ?></td>
										</tr>

                                        <?php

										$slno++;

									}

									?>

										

									</tbody>

									

								</table>
	</body>

   
	</html>

