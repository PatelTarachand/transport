<?php
  include("dbconnect.php");
 $billid = $_REQUEST['billid'];
 $mobile = $_REQUEST['mobile'];
 $bill_name = $_REQUEST['bill_name'];
 $type=$_REQUEST['type'];
  $upval=$_REQUEST['upval'];
//  echo $upval;

  $payment_vochar=$_REQUEST['payment_vochar'];
  $voucharno=$_REQUEST['voucharno'];

 $photopath =  'whatsapp/'.$type.'/'.$billid.'.pdf';
 if($type=='payment'){
  $tablename="m_truckowner";
  $tblkey="ownerid";
  if($upval==1){
    // echo "UPDATE $tablename  set mobileno1 = $mobile WHERE $tblkey='$billid'";die;
  mysqli_query($connection,"UPDATE $tablename  set mobileno1 = $mobile WHERE $tblkey='$billid'");
}

// echo  $cond="Voucher successfully Created by SHIVALI LOGISTICS";
  $cond="Voucher No. $voucharno Has Been Created Successfully By SHIVALI LOGISTICS";

 }
 
 if($type=='voucher'){
    $tablename="bilty_payment_voucher";
    $tblkey="payid";
         $ownerid = $cmn->getvalfield($connection,"bilty_payment_voucher","ownerid","payid='$billid'");
     $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
    if($upval==1){

  
    mysqli_query($connection,"UPDATE m_truckowner  set mobileno1 = $mobile WHERE ownerid='$ownerid'");
  }
 
    //   $cond=" SHIVALI LOGISTICS Payment Voucher successfully Paid  by $ownername ";
           $cond=" Payment Has Been Done by $ownername Against Voucher No. $payment_vochar Successfully , Kindly Check Your Bank Account From SHIVALI LOGISTICS ";  

   }

//  echo $tablename;



  //   echo "UPDATE m_supplier_party  set mobile = $mobile WHERE bid_id='$bid_id'";

//    $supparty_name =	$cmn->getvalfield($connection,"m_supplier_party","supparty_name","bid_id='$bid_id'");
    //  $mobile =	$cmn->getvalfield($connection,"m_supplier_party","mobile","bid_id='$bid_id'");

$photodata = file_get_contents($photopath);
$bsimg =  base64_encode($photodata);
 $bsimg=urlencode("data:application/pdf;base64,". $bsimg); 			
 $url="http://api.iconicsolution.co.in/wapp/api/send?";

$data="apikey=f9aa0071e0d84f11beac97e075310a99&mobile=$mobile&msg=$cond ,

Transport Management सॉफ्टवेयर बनवाने के लिए सम्पर्क करे- 8871181890&pdf=$bsimg&pdfname=$bill_name.pdf";



// $data="apikey=f9aa0071e0d84f11beac97e075310a99&mobile=$mobile&msg=$cond , Transport सॉफ्टवेयर के लिए सम्पर्क करे- 8871181890&pdf=$bsimg&pdfname=$bill_name.pdf

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));   
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
var_dump($result);


    if(is_file($photopath))  {

      unlink($photopath);  
    }


?>