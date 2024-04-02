<?php include("dbconnect.php");
$truckid = trim(addslashes($_REQUEST['truckid']));
$date = $cmn->dateformatusa($_REQUEST['date']);

$empid = $cmn->getvalfield($connection,"driver_map","empid","truckid='$truckid' and '$date' between fromdate and todate");
$lastissuedate= $cmn->dateformatindia($cmn->getvalfield($connection,"issueentry","issudate","truckid='$truckid' order by issueid desc"));
$lastissueno= $cmn->getvalfield($connection,"issueentry","issuno","truckid='$truckid' order by issueid desc");
$lastissueid =  $cmn->getvalfield($connection,"issueentry","issueid","truckid='$truckid' order by issueid desc");

echo $empid.'|'.$lastissuedate.'|'.$lastissueno.'|'.$lastissueid;

?>