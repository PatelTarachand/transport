<?php

include("../superadmin/dbconnect.php");



$id = $_REQUEST['id'];

$tblname  =$_REQUEST['tblname'];

$tblpkey  =$_REQUEST['tblpkey'];

$imagename = $_REQUEST['imagename'];

if($id!="" && $tblname!="")

{

	$sql_del="Delete from $tblname where $tblpkey='$id'";

	$res=mysqli_query($connection,$sql_del);

	if($res)

	{

		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $id,'deleted');

		if($imagename!="")

		{

			$delete_img_name_path = "../upload/".$imagename;

			if(file_exists($delete_img_name_path))

			unlink($delete_img_name_path);

		

		}

	}

	

	

}

?>

