<?php 
include("dbconnect.php");

   $current_date=date('Y-m-d');
  
   
   $truckid=$_REQUEST['truckid'];
   $typos=$_REQUEST['typos'];
 $issue_cate=$_REQUEST['issue_cate'];
   $itemid=$_REQUEST['itemid'];
   $pos_id=$_REQUEST['pos_id'];
   $meterreading=$_REQUEST['meterreading'];
   $uploaddate=$_REQUEST['uploaddate'];  
   $return_cate = $_REQUEST['return_cate'];
    $tyre_new_image=$_FILES['tyre_new_image'];
//   print_r($tyre_new_image);
   $tyre_old_image=$_FILES['tyre_old_image'];
//   print_r($tyre_old_image);
    $old_tyre_name=$_REQUEST['old_tyre_name'];
    $old_tyre_serial_no=$_REQUEST['old_tyre_serial_no'];
    $rpos_id=$_REQUEST['rpos_id'];

    $mapid = $cmn->getvalfield($connection,"tyre_map","mapid","truckid='$truckid' and typos='$typos' && is_remove='0'");
  // print_r($upload_photo);
    // $imgpath = "uploaded/pan_card/";

           if($tyre_new_image!=''){ 
         $doc_name = $tyre_new_image['name'];
         $tm="DOC";
         $tm.=microtime(true)*1000;
         $ext = pathinfo($doc_name, PATHINFO_EXTENSION);
         $doc_name=$tm.".".$ext;
          move_uploaded_file($tyre_new_image['tmp_name'],"uploaded/newtyre/".$doc_name);
  
           }
          if($tyre_old_image!=''){
         $doc_name1 = $tyre_old_image['name'];
         $tm="DOC";
         $tm.=microtime(true)*1000;
         $ext = pathinfo($doc_name1, PATHINFO_EXTENSION);
         $doc_name1=$tm.".".$ext;
          move_uploaded_file($tyre_old_image['tmp_name'],"uploaded/oldtyre/".$doc_name1);
          }

// echo "INSERT into tyre_map set truckid='$truckid',rpos_id='$rpos_id',return_cate='$return_cate',typos='$typos',issue_cate='$issue_cate',itemid='$itemid',pos_id='$pos_id', meterreading='$meterreading',uploaddate='$uploaddate',tyre_new_image='$doc_name',tyre_old_image='$doc_name1',old_tyre_name='$old_tyre_name',createdate='$createdate',old_tyre_serial_no='$old_tyre_serial_no',sessionid='$sessionid'";
// echo "INSERT into tyre_map set truckid='$truckid',typos='$typos', serial_number='$serial_number',tyre_name='$tyre_name', meterreading='$meterreading',uploaddate='$uploaddate',tyre_model='$tyre_model',tyre_new_image='$doc_name',tyre_old_image='$doc_name1',old_tyre_name='$old_tyre_name',createdate='$createdate',old_tyre_serial_no='$old_tyre_serial_no',sessionid='$sessionid'";
   	mysqli_query($connection,"INSERT into tyre_map set truckid='$truckid',rpos_id='$rpos_id',return_cate='$return_cate',typos='$typos',issue_cate='$issue_cate',itemid='$itemid',pos_id='$pos_id', meterreading='$meterreading',uploaddate='$uploaddate',tyre_new_image='$doc_name',tyre_old_image='$doc_name1',old_tyre_name='$old_tyre_name',createdate='$createdate',old_tyre_serial_no='$old_tyre_serial_no',sessionid='$sessionid'");
    //  $lastid = mysqli_insert_id($connection);
    //    $process = "INSERT";
      
    if($rpos_id!=''){
 
 mysqli_query($connection,"update  purchaseorderserial set return_cate='$return_cate' WHERE pos_id ='$rpos_id'");
 mysqli_query($connection,"update  tyre_map set is_remove='1' WHERE mapid ='$mapid'");

    }
    mysqli_query($connection,"update  purchaseorderserial set issue_cate='$issue_cate',is_issue=1 WHERE pos_id ='$pos_id'");
      $action=2;
   $process = "UPDATE";
      


//  if ($typos!='') {
//    $sqledit = "SELECT * from tyre_map where $typos = $typos";
//    $rowedit = mysqli_fetch_array(mysqli_query($connection, $sqledit));

//  $serial_number=$rowedit['serial_number'];
//  $tyre_name=$rowedit['tyre_name'];
//  $meterreading=$rowedit['meterreading'];
//  $uploaddate=$rowedit['uploaddate'];  
//  $tyre_model = $rowedit['tyre_model'];
//   $tyre_new_image=$_FILES['tyre_new_image'];
//  // print_r($tyre_new_image);
//  $tyre_old_image=$_FILES['tyre_old_image'];
//   $old_tyre_name=$rowedit['old_tyre_name'];
//   $old_tyre_serial_no=$rowedit['old_tyre_serial_no'];

//  }

?>