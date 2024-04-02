<?php 
include("dbconnect.php");
$truckid=$_REQUEST['truckid'];


$typos=$_REQUEST['typos'];
  $tyre_new_image=$_FILES['tyre_new_image'];
  $tyre_old_image=$_FILES['tyre_old_image'];
// print_r($upload_photo);
  $imgpath = "uploaded/tyre_img/";


       $doc_name = $tyre_new_image['name'];
       $tm="DOC";
       $tm.=microtime(true)*1000;
       $ext = pathinfo($doc_name, PATHINFO_EXTENSION);
       $doc_name=$tm.".".$ext;
        move_uploaded_file($tyre_new_image['tmp_name'],"uploaded/tyre_img/".$doc_name);


        
       $doc_name1 = $tyre_old_image['name'];
       $tm="DOC";
       $tm.=microtime(true)*1000;
       $ext = pathinfo($doc_name, PATHINFO_EXTENSION);
       $doc_name=$tm.".".$ext;
        move_uploaded_file($tyre_old_image['tmp_name'],"uploaded/tyre_img/".$doc_name);
			
    // echo "update truckupload set uploaddocument='$doc_name',documentstatus=1 where docid = '$docid' && truckid='$truckid'";
			// mysqli_query($connection,"update truckupload set uploaddocument='$doc_name',documentstatus=1 where docid = '$docid' && truckid='$truckid'");
            mysqli_query($connection,"update  tyre_map set tyre_new_image='$doc_name',tyre_old_image='$doc_name1' WHERE truckid = '$truckid' && typos ='$typos'");
		

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