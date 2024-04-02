<?php
error_reporting(0);
include("dbconnect.php");
 $docid=$_REQUEST['docid'];
$truckid=$_REQUEST['truckid'];
$permitissue=dateformatindia($_REQUEST['permitissue']);
  $permitexpiry=dateformatindia($_REQUEST['permitexpiry']);

 

 $tmaintance_id =  $cmn->getvalfield($connection, "truckupload", "count(tmaintance_id)", "docid='$docid' && truckid='$truckid'");

if($tmaintance_id==0){

     // echo "insert into  truckupload set docid='$docid',issuedate='$permitissue',expiry='$permitexpiry', uploaddocument='$doc_name', truckid='$truckid',sessionid='$sessionid'";die;
            mysqli_query($connection, "insert into  truckupload set docid='$docid',issuedate='$permitissue',expiry='$permitexpiry', uploaddocument='$doc_name', truckid='$truckid',sessionid='$sessionid'");
             $tmaintance_id = mysqli_insert_id($connection);
           $action=1;
           $process = "insert";
      }
      else
      {


            mysqli_query($connection, "update  truckupload set docid='$docid', issuedate='$permitissue',expiry='$permitexpiry',truckid='$truckid',uploaddocument='$doc_name' where docid='$docid' && truckid='$truckid'");
     
}	

			

	

	?>
