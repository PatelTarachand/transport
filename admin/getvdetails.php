<?php 
include("dbconnect.php");

    $bulk_vid = $_REQUEST['bulk_vid'];
     
   // echo "select * from trip_entry where trip_id =$trip_id";
    $sql = mysqli_query($connection, "select * from voucher_entry where bulk_vid=$bulk_vid");

  	  $row = mysqli_fetch_array($sql);
$consignorid=$row['consignorid'];
 $consigneeid=$row['consigneeid'];

	   $vamt = $cmn->getvalfield($connection, "payment_recive", "sum(final_total)", "bulk_vid='$row[bulk_vid]'");
    //  echo "//";
	     $recamt = $cmn->getvalfield($connection, "voucher_pay", "sum(amt)", "bulk_vid='$row[bulk_vid]'");
    //  echo "//";
	   if($recamt==''){
	    //   echo "ok";
          
           $balamt=$vamt;
	   } else {
        // echo "jiiii";
	       $balamt=$vamt - $recamt;
	   }
   if($consignorid!=0){
        $partyname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$consignorid'");

    } if($consigneeid!=0) {
        $partyname = $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$consigneeid'");

    }
	echo $partyname."|".$vamt."|".$balamt;
   ?>