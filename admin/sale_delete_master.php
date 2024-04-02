<?php
include("dbconnect.php");

 $id  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
 $transtype = $_REQUEST['transtype'];

echo "delete from $tblname where $tblpkey = '$id'";
echo "delete from purchase_trans where bill_id = '$id'";
 mysqli_query($connection,"delete from $tblname where $tblpkey = '$id'");
 mysqli_query($connection,"delete from sale_trans where bill_id = '$id'");


?>