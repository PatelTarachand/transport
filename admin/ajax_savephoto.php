<?php 
include("dbconnect.php");
  $docid=$_REQUEST['docid'];
  $truckid=$_REQUEST['truckid'];
  $upload_photo=$_FILES['upload_photo'];
	 $tmaintance_id = $cmn->getvalfield($connection, "truckupload", "tmaintance_id", " docid = '$docid' && truckid='$truckid'");
	echo $docid.",".$tmaintance_id;
// print_r($upload_photo);
  $imgpath = "uploaded/img/";


       $doc_name = $upload_photo['name'];
       $tm="DOC";
       $tm.=microtime(true)*1000;
       $ext = pathinfo($doc_name, PATHINFO_EXTENSION);
       $doc_name=$tm.".".$ext;
        move_uploaded_file($upload_photo['tmp_name'],"uploaded/img/".$doc_name);

			
    // echo "update truckupload set uploaddocument='$doc_name',documentstatus=1 where docid = '$docid' && truckid='$truckid'";
			mysqli_query($connection,"update truckupload set uploaddocument='$doc_name',documentstatus=1 where docid = '$docid' && truckid='$truckid'");
		

 /* mysqli_query($connection,"insert into validatedocument set catid='$catid',quesid='$quesid',numerator_ques='$numerator_ques',denominator_ques='$denominator_ques',numerator='$numerator',denominator='$denominator',not_available='$not_available',ratio_ques='$ratio_ques',total_ratio='$total_ratio',ulbname='$ulbname',ulbtype='$usertype',userid='$userid'");  
	      */
/* $keyvalue = mysqli_insert_id($connection);

if(is_array($_FILES)) {

if(is_uploaded_file($_FILES['upload_photo']['tmp_name'])) {

$sourcePath = $_FILES['upload_photo']['tmp_name'];

$imgname = $_FILES['upload_photo']['name'];

 $targetPath = "uploaded/validationdocument/".$imgname;

move_uploaded_file($sourcePath,$targetPath);

//echo "update validatedocument set uploaddocument='$imgname',documentstatus=1 where vid = '$aid' ";
mysqli_query($connection,"update validatedocument set uploaddocument='$imgname',documentstatus=1 where vid = '$aid' ");



}

}*/

?>