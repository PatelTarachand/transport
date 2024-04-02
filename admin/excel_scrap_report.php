<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "materialin";
$tblpkey = "matin_id";
$pagename = "material_in_detail.php";
$modulename = "Scrap Detail";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$fromdate = $_GET['fromdate'];
  $todate =  $_GET['todate'];
  $truckid = $_GET['truckid'];
  $itemid = $_GET['itemid'];
  $driver = $_GET['driver'];

$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and B.issudate between '$fromdate' and '$todate' ";
}
if ($truckid != '') {
  $crit .= " and truckid='$truckid' ";
}

if ($itemid != '') {
  $crit .= " and itemid='$itemid' ";
}

if ($driver != '') {
  $crit .= " and driver='$driver' ";
}


$cond  = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $cond .= " and  A.createdate between '$fromdate' and '$todate' ";
}

if ($truckid != '') {
  $cond .= " and truckid='$truckid' ";
}

if ($itemid != '') {
  $cond .= " and itemid='$itemid' ";
}

if ($driver != '') {
  $cond .= " and driver='$driver' ";
}


header("Content-type: application/vnd-ms-excel");
$filename = "Scrap Report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=" . $filename);

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
     
				<th>Truck No</th>
				<th>Driver Name</th>
				<th>Issue No</th>
				<th>Issue Date</th>  
														  
				<th>Scrap Qty</th>  
			</tr>
		</thead>
		<tbody>
        <?php
 $slno = 1;

// echo "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid $crit and A.is_rep='Scrap'";die;
              $sel = "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid $crit and A.is_rep='Scrap'";
              $res = mysqli_query($connection, $sel);
              while ($row = mysqli_fetch_array($res)) {
                $itemid = $row['itemid'];
                $unitid = $row['unitid'];
              	$empid = $row['driver'];
                $truckid = $row['truckid'];
                
                $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");
        	$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "itemid='$itemid'");
	?>

		<tr>

    <td><?php echo $slno; ?></td>
    <td><?php echo  $cmn->getvalfield($connection,"items","item_name","itemid='$itemid'"); ?>/<?php echo  $item_category_name; ?>/<?php echo  $serial_no; ?></td>
    <td><?php echo $row['unitname']; ?></td>
                        <td><?php echo  $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'"); ?></td>
                      

                       
                        <!-- <td><?php echo $row['is_rep']; ?></td> -->
                        <td><?php echo  $cmn->getvalfield($connection,"m_employee","empname","empid='$empid'"); ?></td>
                    
                        <td><?php echo $row['issuno'];?></td>
                        <td><?php echo $cmn->dateformatindia($row['issudate']); ?></td>
                        <td><?php echo ucfirst($row['qty']); ?></td>
  
		   <!-- <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a> -->
		   
		</tr>

		<?php

	$totalqty+= $row['qty'];

	}

	?>
<tfoot>
<tr><th></th><th></th><th></th><th></th><th></th><th></th><th>Total: </th><th><?php echo $totalqty; ?></th></tr>

</tfoot>	

		</tbody>



	</table>
</body>


</html>