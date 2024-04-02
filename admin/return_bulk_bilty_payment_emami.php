<?php
  error_reporting(0);
  include("dbconnect.php");
  $tblname = "";
  $tblpkey = "";
  $pagename = "return_bulk_bilty_payment_emami.php";
  $modulename = "Return Bulk Bilty Payment";
  
  if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0;  
  
  $cond=' ';
  
  
   $printdate=date('Y-m-d');
  if(isset($_GET['di_no']))
  {
    $di_no = trim(addslashes($_GET['di_no']));  
  }
  else
  $di_no = '';
  
  if(isset($_GET['ownerid']))
  {
    $ownerid = trim(addslashes($_GET['ownerid']));  
  }
  else
   $ownerid = '';
   
    if(isset($_GET['truckno']))
  {
    $truckno = trim(addslashes($_GET['truckno']));  
  }
  else
   $truckno = '';
  
if(isset($_GET['todate']))
  {
   // $todate = $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	$todate = $_GET['todate'];
  }else{
	  $todate = date('Y-m-d');
  }

  if(isset($_GET['from']))
  {
    $from =$_GET['from'];
	//$from =$cmn->dateformatusa(trim(addslashes($_GET['from'])));
  }
  else{
	  $from = date('2020-m-d');
  }

if(isset($_GET['bulk_voucher_id'])){
   $bulk_voucher_id=$_GET['bulk_voucher_id'];
}

  
  
  $cond= " where 1=1";
  if($from !='--' && $todate !='--') {
    
    $cond .=" and  B.tokendate BETWEEN '$from' and '$todate'";
    
    }
    if($ownerid !='') {
    
    $cond .=" and A.ownerid='$ownerid'";
    
    }
	
	 if($truckno !='') {
    
    $cond .=" and A.truckno='$truckno'";
    
    }
    
    if($bulk_voucher_id!=''){
      $payNoIncre=$bulk_voucher_id;
    }else{

    if($sessionid==7){ 
    $payment_vouchar="SELECT * FROM `return_bulk_payment_vochar` where sessionid= '$sessionid' && compid= '$compid' group by bulk_voucher_id";
    $payres = mysqli_query($connection,$payment_vouchar);
    $rowcount=mysqli_num_rows($payres);
    $payrow = mysqli_fetch_array($payres);
    
     $payNoIncre= $rowcount+1;   
    }
    
    if($sessionid==6){
    $payment_vouchar="SELECT * FROM `return_bulk_payment_vochar` where sessionid= '$sessionid' && compid= '$compid' ORDER by id DESC";
     $payres = mysqli_query($connection,$payment_vouchar);
                              $payrow = mysqli_fetch_array($payres);
                                $payNoIncre= $payrow['bulk_voucher_id']+1;
    }
    
    }
  
  if($sessionid==6){
    $vocher_no="FP/22/23/".str_pad($payNoIncre, 4, '0', STR_PAD_LEFT)."".$payince;
}
if($sessionid==7){
  $vocher_no="FP/23/24/".str_pad($payNoIncre, 4, '0', STR_PAD_LEFT)."".$payince;
}
if($sessionid==8){
  $vocher_no="FP/24/25/".str_pad($payNoIncre, 4, '0', STR_PAD_LEFT)."".$payince;
}
if($sessionid==9){
  $vocher_no="FP/25/26/".str_pad($payNoIncre, 4, '0', STR_PAD_LEFT)."".$payince;
}
 
 

if(isset($_POST['sub'])) {
  $vocher_no;
   $total_paid=$_POST['total_paid'];
  // print_r($total_paid);
$total1= array_sum($total_paid);

   $mobileNumber = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
   $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
  function get_tiny_url($url) {
    $api_url = 'https://tinyurl.com/api-create.php?url=' . $url;
  
    $curl = curl_init();
    $timeout = 10;
  
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_URL, $api_url);
  
    $new_url = curl_exec($curl);
    curl_close($curl);
  
    return $new_url;
  }


  $tiny_url = get_tiny_url('http://shivalilogistics.in/erp/admin/pdf_return_bulk_bilty_payment_emami_report1.php?ownerid='.$ownerid.'&voucharno='.$vocher_no.'&bulk_voucher_id='.$payNoIncre1.'&compid='.$compid.'&sessionid='.$sessionid);


  // echo "hjghg";die;
// echo  $tiny_url;die;
  $msgs="Dear $ownername your voucher has been generated successfully. voucher number $vocher_no, Voucher Amount Rs. $total1 you can download voucher using $tiny_url SVLGST";
// "Dear $ownername your voucher has been generated successfully. voucher number $vocher_no, Voucher Amount Rs. $total_paid you can download voucher using $tiny_url. SVLGST"
//  echo"Dear {#$consigneename . $companyname#} Your Truck {#$truckno#} Loaded {#$itemname#} On {#$inv_date#} From {#$placename#} To {#$toplacename#} , QTY {#$noofqty#} Party is {#$consigneename#} contact {#$mobileNumber#}. To Download Your Builty click {#$link}";die;
$msg = str_replace(' ', '%20', $msgs);
// echo $msg;die;

sendsmsGET($mobileNumber,$msg);

}


function sendsmsGET($mobileNumber,$msg)
{	
  //echo "hello";
    //API URL

    $url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber&message=$msg&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707169088863422306";


    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0

    ));


    //get response
    $output = curl_exec($ch);
	
	//print_r($output);
    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }

    curl_close($ch);

    return $output;
}
  ?>
<!doctype html>
<html>
  <head>
    <?php  include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>
    <script>
      $(function() {
       
      $('#from').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       $('#todate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
          $('.recdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
          $('#payment_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
      
      
      });
    </script>
  </head>
  <body>
    <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
    <div class="container-fluid" id="content">
      <div id="main">
        <div class="container-fluid">
          <!--  Basics Forms -->
          <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                 <!--  <legend class="legend_blue"><a href="dashboard.php"> 
                    <img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a>
                  </legend> -->
                
                  <?php include("alerts/showalerts.php"); if($bulk_voucher_id==''){ ?>
                  <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
                  <?php include("../include/page_header.php"); ?>
                </div>
                <form  method="get" action="" class='form-horizontal' >
                  <div class="control-group">
                    <table class="table table-condensed" style="width:90%;">
                      <tr>
                        <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                      </tr>
                      <tr>
                       <td><strong>Truck Owner </strong> <strong>:</strong><span class="red">*</span></td>
                       <td><strong>Truck No. </strong> <strong>:</strong><span class="red">*</span></td>
                        <td><strong>From Date</strong> <strong>:</strong><span class="red">*</span></td>
                          <td><strong>To</strong> <strong>:</strong><span class="red">*</span></td>
                      </tr>
                      
                      <tr>
                       
                        <td>
                          <select id="ownerid" name="ownerid" class="select2-me input-large" style="width:220px;">
                            <option value=""> - All - </option>
                            <?php 
                              $sql_fdest = mysqli_query($connection,"select * from m_truckowner");
                              while($row_fdest = mysqli_fetch_array($sql_fdest))
                              {
                              ?>
                            <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                            <?php
                              } ?>
                          </select>
                          <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>
                        </td>
                        
                         
                        <td>
                          <select id="truckno" name="truckno" class="select2-me input-large" style="width:220px;">
                            <option value=""> - All - </option>
                            <?php 
                              $sql_fdest = mysqli_query($connection,"SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)  where B.is_complete=0  && B.recweight !='0' && B.payment_date='0000-00-00'");
                              while($row_fdest = mysqli_fetch_array($sql_fdest))
                              {
                              ?>
                            <option value="<?php echo $row_fdest['truckno']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                            <?php
                              } ?>
                          </select>
                          <script>document.getElementById('truckno').value = '<?php echo $truckno; ?>';</script>
                        </td>
                        
                       
                        <td>
                          <input type="date" name="from" id="from" value="<?php echo $from; ?>" autocomplete="off"   tabindex="10" >
                         
                          <input type="hidden" name="payinvo"   value="<?php echo $payNoIncre; ?>">
                        </td>
                      
                        <td>
                          <input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" autocomplete="off"  tabindex="10">
                         
                        </td>
                        <td>
                          <input type="submit" name="submit" id="submit" value="Search" class="btn btn-success" tabindex="10">
                          <?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                            {?>
                          <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                          <?php
                            }
                                                      else
                                                      {                                       
                                                      ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                          <?php
                            }
                            ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </form>
              <?php } ?>

              </div>
            </div>
          </div>



           <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                
                  
                  <h3><?php 
              
                 $OWNIID= $_GET['ownerid'];
                  $OWN="SELECT * FROM `m_truckowner` WHERE `ownerid`=$OWNIID";
                  $OWNres = mysqli_query($connection,$OWN);
                              while($OWNrow = mysqli_fetch_array($OWNres))
                              {
                                echo $OWNrow['ownername']; 
                              }
                ?>
                  </h3></br>
                  <h4> <?php if($bulk_voucher_id!='') { ?> Updated <?php } else { ?> Payment  <?php } ?> Date:   
                   <?php if($bulk_voucher_id!='') { 
                   $payment_date = $cmn->getvalfield($connection,"returnbidding_entry","payment_date","voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid'");
                     $paidto = $cmn->getvalfield($connection,"returnbidding_entry","paidto","voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid'");
                       $remark = $cmn->getvalfield($connection,"returnbidding_entry","remark","voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid'");
                   }
                   ?>
                    <input type="text" name="payment_date" id="payment_date"  value="<?php if($bulk_voucher_id!='') { echo dateformatindia($payment_date);}  else { echo date('d-m-Y'); } ?>" />
                          
                     <span> Paid To <input type="text" name="paidto" id="paidto"  value="<?php echo $paidto;?>" placeholder="Enter Paid To" /></span>
                     <span> Remark <input type="text" name="remark" id="remark"  value="<?php echo $remark;?>" style="width: 500px;" placeholder="Remark" /></span>
                     </h4>
                </div>

      
              </div>
            </div>
          </div>


          <!--   DTata tables -->
          <div class="row-fluid">
            <div class="span12" style="width:100%">
              <div class="box box-bordered">
                <div class="box-title">
                  <h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                   <a style="align-items: right; float: right; margin-right: 10%;" href="pdf_return_bulk_bilty_payment_emami.php?ownerid=<?php echo $ownerid ?>&payinvo=<?php if($bulk_voucher_id!='') { echo $bulk_voucher_id; } else { echo $_GET['payinvo']; }
               ?>" target="_blank" >
                    <button class="btn btn-primary" >Print PDF</button></a>
                </div>
                
                <div class="box-content nopadding overflow-x:auto" style="overflow: scroll;width: 100%;">
                  <table class="table"  width="100%">
                    <thead id="table">
                      <tr>
                        <th width="2%" >Sn</th>
                        <th width="5%" >LR No.</th>
                        <th width="5%" >Bilty Date</th>
                        
                        <th width="6%" >Truck No.</th>
                        <th width="6%" >Destination</th>
                        <th width="5%"> Weight </th>
                        <th width="5%">Receive <p> Weight </p></th>
                        <th width="5%">  Company Rate </th>
                        <th width="5%"> Final Rate(M.T.) <span class="err" style="color:#F00;">*</span></th width="5%">
                        
                        <th width="5%"> Commission  </th>
                        
                         <th>Bilty Commission(Rs) </th>
                       
                         <th> Shortage </th>
                       <th> Shortage Amt </th>
                        <th> TDS(%) </th>
                        <th> TDS Amt </th>
                        <th width="5%"> Cash Adv (Self)</th>
                         <th width="5%"> Cash Adv (Consignor)</th>
                        <th> Diesel Adv </th>
                        <th> Other  <p>cash Adv </th>
                       
                        
                        <th> Net Amount <span class="err" style="color:#F00;">*</span></th>
                        
                        <th>Total</th>
                        
                        <th width="7%" class='hidden-480'>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $sn=1;
                        
                         
                     if($ownerid!='' or $truckno!='' or $bulk_voucher_id!=''){
                       
                      if($bulk_voucher_id!=''){
                        $payment_vochar = $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$bulk_voucher_id' && compid='$compid' && sessionid='$sessionid'");

                         $sel = "SELECT * from  returnbidding_entry Where  voucher_id='$bulk_voucher_id' && compid='$compid'  && sessionid='$sessionid'";

                      }else{
			
                         $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.sessionid='$sessionid' and B.is_complete=0  && B.recweight !='0' && B.compid='$compid' && B.payment_date='0000-00-00'";
                        }                       

                          $res = mysqli_query($connection,$sel);
                              while($row = mysqli_fetch_array($res))
                              {
                                $truckid = $row['truckid']; 
                                $truckno = $row['truckno']; 
                                $ownerid = $row['ownerid']; 
                                        $bid_id = $row['bid_id']; 
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        $consignorid = $row['consignorid'];
                        $consigneeid = $row['consigneeid'];
                        $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$consignorid'");
                        $consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
                        $placeid = $row['placeid'];
                        $destinationid = $row['destinationid'];
                        $itemid = $row['itemid'];
                        $truckid = $row['truckid'];
                        $wt_mt = $row['totalweight'];
                        $rec_mt = $row['recweight'];
                        $pay_no = $row['pay_no'];
                        if($pay_no!=''){
                        $pay_no = $cmn->getcode($connection,"returnbidding_entry","pay_no","1=1 and sessionid = $_SESSION[sessionid]");
                        
                        }
                        else {
                        $pay_no = $row['pay_no'];
                        }
                        
                        $ac_holder = $row['ac_holder'];
                        $rate_mt = $row['freightamt'];

                        $comp_rate = $row['comp_rate'];
                        $newrate = $row['own_rate']; 
                        
                        $deduct_r = $row['deduct_r'];
                        if($deduct_r=='') { $deduct_r= 0; }
                        
                       // $deduct = $row['deduct']; 
                        
                        $fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
                        $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        $tds_act = $cmn->getvalfield($connection,"m_truckowner","tds_act","ownerid='$ownerid'");
                        $adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						             $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        
                        
                        $payment_date = $row['payment_date'];
                        $chequepaydate = $row['chequepaydate']; ;
                        
                        //$venderid = $row['venderid'];
                        $commission = $row['commission'];
                        
                        
                        $cashpayment = $row['cashpayment'];
                        $chequepayment = $row['chequepayment'];
                        $chequepaymentno = $row['chequepaymentno'];
                        $paymentbankid = $row['paymentbankid']; 
                        $shortagewt =  $row['shortagewt']; 
                        $compcommission =  $row['compcommission']; 
                        $cashbook_date = $row['cashbook_date'];
                        $payeename = $row['payeename']; 
                        $tds_amt = $row['tds_amt']; 
						  $sortagr =$row['sortagr'];
                        $neftpayment =$row['neftpayment'];  
                        


                        if($payment_date=='0000-00-00')
                        {
                        $payment_date = date('Y-m-d');
                        $compcommission = $cmn->getvalfield($connection,"m_consignor","commission","consignorid='$consignorid'");
                        }
                        
                        
                        $netamount = $newrate * $rec_mt;
						
						//$sortamount=$newrate * $sortagr;
                        if($bulk_voucher_id!=''){

                          if($deduct==0){ 
                              $tds_amount= $netamount*$tds_amt/100;
                              $netamount=$netamount-$tds_amount;
                          }
                        }
                        $charrate = $rate_mt - $newrate;

                        $tot_adv = $adv_cash  + $adv_cheque +$adv_other+$adv_consignor;
                        
                        $balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other-$adv_consignor - $commission;
                        
                        $tot_profit = $rec_mt * $charrate;
                        $comp_commision = ($tot_profit * $compcommission)/100;
                        $net_profit = round($tot_profit - $comp_commision);
                        
                        $othrcharrate = $comp_rate - $newrate;
                        
                        if($bulk_voucher_id!=''){
                          $paidValue=$balamt;
                        }

                        if($newrate==0){ $newrate=''; }
                        if($adv_cash==0){ $adv_cash=''; }
                        if($adv_diesel==0){ $adv_diesel='0'; }
                        if($adv_cheque==0){ $adv_cheque='0'; }
                        if($adv_other==0){ $adv_other='0'; }
                         if($adv_consignor==0){ $adv_consignor='0'; }
                        
                        // $toYear=substr(date('Y'),2);
                         //$nextYear=$toYear+1;
                         //$vocher_no= "FP/".$toYear;
                          
                        ?>
                      <tr tabindex="<?php echo $sn; ?>" class="abc">
                        <td><?php echo $sn++;
                       
                       ?>
                          
                        </td>
                        
                        <td><?php echo $row['lr_no']; ?>
                          <span style="color:#FFFFFF;"><?php echo $ewayno; ?></span>    
                        </td>
                        <td width="10px"><?php  echo date('d-m-Y',strtotime($row['tokendate']));?></td>
                       
                        <td><?php echo $truckno; ?></td>
                        <td><?php echo $toplace; ?></td>
                        <td>
                            

                          <input type="hidden" class="formcent" id="payNoIncre<?php echo $bid_id; ?>" value="<?php echo $payNoIncre; ?>"   autocomplete="off" style="width: 70px;" readonly >

                            <input type="hidden" class="formcent" id="payinvoice<?php 
echo $bid_id; ?>" value="<?php echo $vocher_no;?>"   autocomplete="off" style="width: 70px;" readonly >



                         <input type="text" class="formcent" id="wt_mt<?php echo $bid_id; ?>" value="<?php echo $row['totalweight']; ?>"   autocomplete="off" style="width: 70px;" readonly ></td>

                          <td><input type="text" class="formcent" id="recweight<?php echo $bid_id; ?>" value="<?php echo $row['recweight']; ?>"   autocomplete="off" style="width: 70px;"  readonly></td>

                        <td><input type="text" class="formcent"  value="<?php echo $comp_rate; ?>" id="rate_mt<?php echo $bid_id; ?>" name="freightamt"   style="border: 1px solid #368ee0; width: 70px;"  autocomplete="off" onChange="gettot_paid(<?php echo $bid_id; ?>);"   ></td>

                         <td><input type="text" class="formcent" name="newrate" id="newrate<?php echo $bid_id; ?>" value="<?php echo $newrate; ?>"  style="border: 1px solid #368ee0; width: 70px;"  autocomplete="off" onChange="gettot_paid(<?php echo $bid_id; ?>);" ></td>

                        <td><input type="text" class="formcent" value="<?php echo $othrcharrate; ?>" name="trip_commission" id="othrcharrate<?php echo $bid_id; ?>" style="border: 1px solid #368ee0; width: 70px;" onChange="gettot_paid(<?php echo $bid_id; ?>);"  autocomplete="off" >
                          <input type="hidden" class="formcent" value="<?php echo $charrate; ?>" id="charrate<?php echo $bid_id; ?>"  autocomplete="off"   >
                        </td>

                       
                        <td><input type="text" class="formcent commission" name="commission" id="commission<?php echo $bid_id; ?>" value="<?php echo $commission; ?>"  style="border: 1px solid #368ee0; width: 70px"   autocomplete="off" onChange="gettot_paid(<?php echo $bid_id; ?>);"  ></td>

<td>
                            <input type="text" class="formcent" name="sortagr" id="sortagr<?php echo $bid_id; ?>" value="<?php echo $sortagr; ?>"  style="border: 1px solid #368ee0;width: 70px;"  autocomplete="off"   
                            <?php if($row['totalweight']==$row['recweight']) { ?> readonly <?php }else {?> required <?php }?> />
                          </td>
                        
                        
                          <td>
                            <input type="text" class="formcent" name="sortamount" id="sortamount<?php echo $bid_id; ?>" value="<?php echo $sortamount; ?>"  style="border: 1px solid #368ee0;width: 70px;"  autocomplete="off"  onChange="gettot_paid(<?php echo $bid_id; ?>);"   
                            <?php if($row['totalweight']==$row['recweight']) { ?>  <?php }else {?> required <?php }?> />
                          </td>
                        
                        <td><input type="text" class="formcent" name="tds_amt" id="tds_amt<?php echo $bid_id; ?>" value="<?php echo $tds_amt; ?>"  
                        style="border: 1px solid #368ee0;width: 70px;"  autocomplete="off"  onChange="gettot_paid(<?php echo $bid_id; ?>);"  
                          <?php if($tds_act!=1) { ?> readonly <?php }else { ?> required <?php } ?> /> 
                          </td>

                         <td><input type="text" class="formcent" name="tds_amount" id="tds_amount<?php echo $bid_id; ?>" value="<?php echo $tds_amount; ?>"  style="border: 1px solid #368ee0;width: 70px;"  autocomplete="off"  readonly  ></td>

                      

                        <td><input type="text" class="formcent" value="<?php echo $adv_cash; ?>" id="adv_cash<?php echo $bid_id; ?>"  onChange="gettot_paid();"  autocomplete="off"  style="width: 70px;"  ></td>
 <td><input type="text" class="formcent" value="<?php echo $adv_consignor; ?>" id="adv_consignor<?php echo $bid_id; ?>"  onChange="gettot_paid();"  autocomplete="off"  style="width: 70px;"  ></td>
                      
                        
                        <td><input type="text" class="formcent" value="<?php echo $adv_diesel; ?>" id="adv_diesel<?php echo $bid_id; ?>" onChange="gettot_paid();" style="width: 70px;" autocomplete="off"   ></td>
                        <td><input type="text" class="formcent" value="<?php echo $adv_other; ?>" id="adv_other<?php echo $bid_id; ?>"  onChange="gettot_paid();"  autocomplete="off"  style="width: 70px;"  ></td>
                        

                       

                          <td><input type="text" class="formcent" value="<?php echo $netamount; ?>" id="netamount<?php echo $bid_id; ?>"  autocomplete="off"  readonly style="width: 70px;" ></td>

                      <form method="post" action="">

                        <td><input type="text" class="formcent" name="total_paid[]"  id="total_paid<?php echo $bid_id; ?>"  value="<?php if($bulk_voucher_id!='' ) { echo $paidValue; } ?>" autocomplete="off" style="width: 70px;" ></td>
                       
                       
                       
                        <td>
                          <input type="button" class="btn btn-sm btn-success" value="Update" onClick="getsave(<?php echo $bid_id; ?>);"  >
                          
                          <span style="color:#F00;width: 70px;" id="msg<?php echo $bid_id; ?>"></span> 
                           
                          
                        </td>
                         
                      </tr>
                      <?php 
                        }
                        }
                        ?>
                    </tbody>
                  </table>
                </div> 
                  <div>
             
                 
                  
                </div>
              </div>
              
               <br>
              <br>

              <div class="col-xs-12" style="text-align:center;">
              <input type="hidden" name="ownerid" id="ownerid" class="btn btn-success" value="<?php echo $ownerid ;?>">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save/Send Msg">
             
                    </div>
</form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>

 





      function gettot_paid(bid_id)
      {
      
      
        var commission = parseFloat(document.getElementById('commission'+bid_id).value);
        var newrate = parseFloat(document.getElementById('newrate'+bid_id).value);
        var othrcharrate = parseFloat(document.getElementById('othrcharrate'+bid_id).value);

        var rate_mt = parseFloat(document.getElementById('rate_mt'+bid_id).value);
        
        


        var tds_amt =  parseFloat(document.getElementById('tds_amt'+bid_id).value);

        var adv_diesel =  parseFloat(document.getElementById('adv_diesel'+bid_id).value);
        var wt_mt =  parseFloat(document.getElementById('wt_mt'+bid_id).value);
        
        
        var adv_cash = parseFloat(document.getElementById('adv_cash'+bid_id).value);
        var adv_other =  parseFloat(document.getElementById('adv_other'+bid_id).value);
         var adv_consignor =  parseFloat(document.getElementById('adv_consignor'+bid_id).value);
        
        var adv_diesel = parseFloat(document.getElementById('adv_diesel'+bid_id).value);
        var sortamount = parseFloat(document.getElementById('sortamount'+bid_id).value);  
          var recweight = parseFloat(document.getElementById('recweight'+bid_id).value);
        
        
        
        
        if(isNaN(adv_diesel)){ adv_diesel=0; }
     
        if(isNaN(newrate)){ newrate=0; }
        if(isNaN(rate_mt)){ rate_mt=0; }
        if(isNaN(adv_diesel)){ adv_diesel=0; }
        if(isNaN(adv_other)){ adv_other=0; }
        
        if(isNaN(adv_cash)){ adv_cash=0; }
        if(isNaN(adv_consignor)){ adv_consignor=0; }
		  if(isNaN(sortamount)){ sortamount=0; }
        //if(isNaN(deduct)){ deduct=0; }
        if(isNaN(commission))
        {
          commission = 0; 
        }
        
        
        
        
        
        if(isNaN(tds_amt))
        {
          tds_amt=0;
        }
        
    if(isNaN(wt_mt))
      {
          wt_mt=0;
        }
        
        
        othrcharrate = rate_mt - newrate;
        
        document.getElementById('othrcharrate'+bid_id).value=othrcharrate;
       
        
        var char = rate_mt - newrate; 
        document.getElementById('charrate'+bid_id).value= char; 
        //alert(commission) 
        var netamt = newrate * recweight
        document.getElementById('netamount'+bid_id).value= netamt;

       // var netamt = netamt - deduct;
        document.getElementById('netamount'+bid_id).value= netamt;

        tds_amt = netamt*tds_amt/100;
        document.getElementById('tds_amount'+bid_id).value= Math.round(tds_amt);
        var tot_paid = netamt - commission - adv_diesel - adv_cash - adv_other - adv_consignor - tds_amt-sortamount;
        document.getElementById('total_paid'+bid_id).value = tot_paid.toFixed(2);
        //var balamount = netamt - commission - adv_diesel - tot_adv - tds_amt -deduct;
        
        //document.getElementById('bal_amount'+bid_id).value = balamount.toFixed(2);
        
        //var tot_paid = cashpayment + chequepayment + neftpayment;
        
        //
        
      //var remainingpayment = bal_amount - tot_paid;
        
        
       //document.getElementById('remaining'+bid_id).value = remainingpayment.toFixed(2);
        
        
    }
      

      function getsave(bid_id){


        var rate_mt = parseFloat(document.getElementById('rate_mt'+bid_id).value);
        
      var wt_mt = parseFloat(document.getElementById('wt_mt'+bid_id).value);
        var recweight = parseFloat(document.getElementById('recweight'+bid_id).value);
        var othrcharrate = parseFloat(document.getElementById('othrcharrate'+bid_id).value);
        var newrate = parseFloat(document.getElementById('newrate'+bid_id).value);
        var commission = parseFloat(document.getElementById('commission'+bid_id).value);
        var tds_amt =  parseFloat(document.getElementById('tds_amt'+bid_id).value);
        var sortamount = parseFloat(document.getElementById('sortamount'+bid_id).value);
        
        
        var payment_date =  document.getElementById('payment_date').value;
		 var paidto =  document.getElementById('paidto').value;
     var remark =  document.getElementById('remark').value;
            var payNoIncre =  document.getElementById('payNoIncre'+bid_id).value;
        var payinvoice =  document.getElementById('payinvoice'+bid_id).value;

      var bid_idd=bid_id;
	 
         if(paidto=='')
        {
            alert("Please fill the Paid To");
            return false;
        }
        
        if(isNaN(rate_mt) || rate_mt=='0' )
        {
            alert("Please fill the Company Rate");
            return false;
        }
        
        if(isNaN(recweight) || recweight=='0' )
        {
            alert("Please fill the Receice Weight");
            return false;
        }
        
        if(isNaN(newrate) || newrate=='0' )
        {
            alert("Please fill the Final  Rate");
            return false;
        }
        
        

        if(confirm("Are you sure you want to update ? ")){
           
        $.ajax({
          type:"POST",
        url:"return_bulk_bilty_payment_save.php",
        

        data:"newrate="+newrate+"&commission="+commission+"&sortamount="+sortamount+"&tds_amt="+tds_amt+"&payment_date="+payment_date+"&paidto="+paidto+"&remark="+remark+"&bid_id="+bid_idd+"&rate_mt="+rate_mt+"&othrcharrate="+othrcharrate+"&payNoIncre="+payNoIncre+"&payinvoice="+payinvoice,
        
        success:function(response) {
		// alert(response);
              document.getElementById('msg'+bid_id).innerHTML = 'Updated';
         //alert('Update Successfully');
         //
       },

      });
      
    
      

  }}
      
    </script>
  </body>
</html>
<?php
  mysqli_close($connection);
  ?>