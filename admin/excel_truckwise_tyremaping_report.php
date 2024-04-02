<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Billty Report";

// The function header by sending raw excel
	//header("Content-type: application/vnd-ms-excel");
	//$filename ="tyrereport.xls";
	// Defines the name of the export file "codelution-export.xls"
	//header("Content-Disposition: attachment; filename=".$filename);
	
if(isset($_GET['truckid']))	
	$truckid = $_GET['truckid'];	
else
	$truckid='';
	
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
?>
<table>
	<tr>
    	<td>Started Date</td>
        <td>Tyre No.</td>
        <td>Op. Km./-</td>
        <td>Clo. Km./-</td>
        <td>Run Km./-</td>
         
    </tr>
    
    <?php
	$sql = mysqli_query($connection,"select * from tyre_map where truckid='$truckid' group by  typos order by typos desc");	
	while($row=mysqli_fetch_assoc($sql)) {
	?>
    
    <tr>
    		<td><?php echo $cmn->dateformatindia($row['uploaddate']); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
    </tr>
    <?php 
	}
	?>
</table>

		Tyre Name						Tyre Name


<script>//window.close();</script>