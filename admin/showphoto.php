<?php 
include("dbconnect.php");
    $tmaintance_id=$_REQUEST['tmaintance_id'];
   
  	 $upload_photo = $cmn->getvalfield($connection, "truckupload", "uploaddocument", "tmaintance_id='$tmaintance_id'");
    
          if($upload_photo!=''){
          
           
          ?>
          
											   <a href="uploaded/img/<?php echo $upload_photo; ?>"    target="_blank"> <strong style="color:red"> View </strong></a><?php } ?>

