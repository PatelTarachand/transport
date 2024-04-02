<?php //error_reporting(0); 
include("dbconnect.php");
$tblname = 'return_bilty_payment_voucher';
$tblpkey = 'payid';
$pagename  ='return_bilty_payment_voucher.php';
$modulename = "Bilty Payment Voucher";
$voucher_id=$_GET['voucher_id'];
	if($usertype=='admin')
	{
	$crit=" where payment_date='0000-00-00'";
	}
	else
	{
$crit=" where payment_date='0000-00-00'";
	}
  $payment_vochar = $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$voucher_id' && sessionid='$sessionid'");

if(isset($_GET['ownerid']) && isset($_GET['voucher_id']))
{
	$great_total=0;
	 
	   $voucher_amount= showBiltyVoucher($connection,$compid,$_GET['voucher_id'],$sessionid);	
  $payamount = $cmn->getvalfield($connection,"return_bilty_payment_voucher","sum(payamount)","ownerid='$_GET[ownerid]' && voucher_id='$_GET[voucher_id]' && compid='$compid' && sessionid= $sessionid");
  $payment_date = dateformatindia($cmn->getvalfield($connection,"returnbidding_entry","payment_date","voucher_id='$_GET[voucher_id]' && compid='$compid'"));	 
  
  //$bal_amt=floatval($voucher_amount)-floatval($payamount);
    $bal_amt = bcsub($voucher_amount, $payamount);
//  if($bal_amt<0){
//      $bal_amt=0;
//  }
	
}
else{
$payment_date='00-00-0000';
}
if(isset($_POST['sub']))
{
$ownerid=$_POST['ownerid'];
$voucher_id=$_POST['voucher_id'];
$voucher_amount=$_POST['voucher_amount'];
$payamount=$_POST['payamount'];
$bal_amt=$_POST['bal_amt'];
$receive_date=$_POST['receive_date'];
$payment_rec_no=$_POST['payment_rec_no'];
$narration=$_POST['narration'];

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
	 
	if(($voucher_id !='' || $voucher_amount !='0')  && ($payamount !='' || $receive_date !='0'))
	{
		
  $sql_update = "INSERT INTO return_bilty_payment_voucher set ownerid='$ownerid',voucher_id='$voucher_id',voucher_amount='$voucher_amount',payamount='$payamount',bal_amt='$bal_amt',receive_date='$receive_date',payment_rec_no='$payment_rec_no',createdate='$createdate',sessionid='$sessionid',narration='$narration',compid='$compid',userid='$userid',ipaddress='$ipaddress'"; 
			mysqli_query($connection,$sql_update);
		  $last_id = mysqli_insert_id($connection);
		
			$tiny_url = get_tiny_url('http://shivalilogistics.in/erp/admin/pdf_biltypayment_voucher1.php?payid='.$last_id);
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
      // echo  $tiny_url;die;
  
    // echo    $msg1="Dear $ownername  your payment for voucher no v/555/555  voucher number is v/555/555 .you can download voucher using $tiny_url. SVLGST";die;
     $msg1="Dear $ownername your payment for voucher no $payment_vochar has been paid successfully of RS $payamount on 31-07-2023. your balance amount is $bal_amt. you can download voucher using $tiny_url SVLGST";
  
    //  " Dear $ownername your voucher has been generated of RS $payamount. voucher number isv/555/555 .you can download voucher using $link. SVLGST"
      $msg = str_replace(' ', '%20', $msg1);

      sendsmsGET($mobileNumber,$msg);

echo "<script>location='return_bilty_payment_voucher.php?action=1&ownerid=$ownerid&voucher_id=$voucher_id'</script>";

	}
}else{
$payment_rec_no = $cmn->getcode($connection,"return_bilty_payment_voucher","payment_rec_no","1=1 and sessionid = $_SESSION[sessionid] && compid='$compid'");
}
   
  
function sendsmsGET($mobileNumber,$msg)
{	
    //API URL
	//  echo $url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber&message=$msg&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707168907871490147";die;
 	 $url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber&message=$msg&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707169079897949005";

// $url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=6265782440&message=Dear%20KAPIL%20PRASAD%20AGRAWAL%20Your%20Truck%20CG04JD5498%20Loaded%20On%202023-07-22%20From%20Bilashpur%20To%20Kasdol%20,%20QTY%2034%20Party%20is%20KAPIL%20PRASAD%20AGRAWAL%20contact%206265782440.%20To%20Download%20Your%20Builty%20click%20id_id=38%20SVLGST&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707168907871490147";
	//header("location:".$url);
	
    // init the resource
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

//echo "SELECT A.ownerid,B.voucher_id,B.payment_date from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid) where A.ownerid='$_GET[ownerid]' && B.compid='$compid' &&  B.sessionid='$sessionid' && B.voucher_id!=0 group by B.voucher_id";die;
?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#0CF;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:230px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>
<script>

  
  $(function() {
   
   $('#receive_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
     
  });

</script>

</head>

<body data-layout-topbar="fixed">
 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
					
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from returnbidding_entry $crit  && recweight !='0' && ownerid =4"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >                                       
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp;Return Bilty Payment Voucher </legend>   
                <div class="innerdiv">
                    <div> Truck Owner <span class="err" style="color:#F00;">*</span></div>
                    <div class="text"> 
                      <select id="ownerid" name="ownerid" class="select2-me input-large" onChange="window.location.href='?ownerid='+this.value" style="width:220px;">
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
                          <script>document.getElementById('ownerid').value = '<?php echo $_GET['ownerid']; ?>';</script>
                                             		
              
                   
                </div>
               </div>
               <div class="innerdiv">
                    <div> Voucher No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
              
                   <select id="voucher_id" name="voucher_id" class="select2-me input-large" 
                   onChange="getUrl(this.value);"
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			
			$sql_fdest = mysqli_query($connection,"SELECT A.ownerid,B.voucher_id,B.payment_date from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid) where A.ownerid='$_GET[ownerid]' && B.compid='$compid' &&  B.sessionid='$sessionid' && B.voucher_id!=0 group by B.voucher_id ");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			
			$payment_vochar = $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row_fdest[voucher_id]' && sessionid='$sessionid' ");
			$voucher_amount1= showBiltyVoucher($connection,$compid,$row_fdest['voucher_id'],$sessionid);	
        	 $payamount1 = $cmn->getvalfield($connection,"return_bilty_payment_voucher","sum(payamount)","ownerid='$_GET[ownerid]' && voucher_id='$row_fdest[voucher_id]' && sessionid='$sessionid' && compid='$compid' ");	 
	$bal_amt1=$voucher_amount1-$payamount1;
// 	if($bal_amt1>1){
//     // $bal_amt1=0;
//  }		
			
	if($bal_amt1 > 1){
			?>
			<option value="<?php echo $row_fdest['voucher_id']; ?>"><?php echo $payment_vochar; ?></option>
			<?php
		}  }?>
			</select>
			<script>document.getElementById('voucher_id').value = '<?php echo $_GET['voucher_id']; ?>';</script>

                </div>
               </div>
               <div class="innerdiv">
                    <div> Voucher Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" id="voucher_amount" name="voucher_amount" value="<?php echo $voucher_amount; ?>"  style="border:1px solid #368ee0; color:#F00;" readonly autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Voucher Date</div>
                    <div class="text">
                     <input type="text" class="formcent" name="payment_date" id="payment_date" value="<?php echo $payment_date;?>"   style="border: 1px solid #368ee0;color:#F00;" readonly  autocomplete="off"  >
                </div>
                </div>
                <div class="innerdiv">
                    <div>Balance Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" 	 id="bal_amt" name="bal_amt"  value="<?php echo $bal_amt; ?>"  style="border: 1px solid #368ee0;color:#F00;" readonly  autocomplete="off"  >
                </div>
                </div>
                
                
                <div class="innerdiv">
                    <div>Pay  Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" name="payamount" id="payamount"  style="border: 1px solid #368ee0;" onChange="gettot_paid();" autocomplete="off"  >
                </div>
                </div>


                
                
                
                

        
                        
                
                <div class="innerdiv">
                    <div> Payment Date </div>
                    <div class="text">
                     <input type="date" class="formcent"  name="receive_date" id="receive_date"  value="<?php  $date=date('Y-m-d'); 
                     echo date('Y-m-d',strtotime($date)); ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>

                <div class="innerdiv">
                    <div> Payment Receive No </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="payment_rec_no" id="payment_rec_no"  value="<?php echo $payment_rec_no; ?>"  style="border: 1px solid #368ee0;" readonly  autocomplete="off"  >
                </div>
                </div>
                
                
              <div class="innerdiv">
                    <div> Narration </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="narration" id="narration"  value="<?php echo $narration; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
         
              
             
			   
           
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return chepayment(); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                    <input  type="hidden" name="wt_mt" id="wt_mt" value="<?php echo $wt_mt; ?>" >
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
            <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
					   
						<div class="box box-bordered">
						    <div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3></div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Consignor Name</th>
                                            <th>Voucher No.</th>
											<th>Pay Amount</th>
                                            <th>Payment Receive No</th>
											<th>Pay Date </th>
                                            	<th>Narration </th>
                                                <th>Print </th>
										<th>Delete</th>
											    
											<!-- <th>Print</th> -->
											<!-- <th class='hidden-480'>Action</th> -->
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									$sel = "SELECT * FROM `return_bilty_payment_voucher` WHERE compid='$compid' && sessionid='$sessionid' && ownerid='$_GET[ownerid]' order by payid desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									$ownername =  $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'");	
									$payment_vochar =  $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row[voucher_id]'");	
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                              <td><?php echo $ownername;?></td> 
                          <td><?php echo $payment_vochar;?></td> 
					         <td><?php echo number_format(round($row['payamount']),2);?></td>
                             <td><?php echo$row['payment_rec_no'];?></td>
                             
                            <td><?php echo dateformatindia($row['receive_date']);?></td>  
                           <td><?php echo$row['narration'];?></td>
                                                  
                            
                            
                          <td><a href="pdf_return_biltypayment_voucher.php?payid=<?php echo $row['payid'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                    </td>
                                              <td class='hidden-480'>
                           <a onClick="funDel(<?php echo $row['payid'];?>)" class="btn btn-danger">Delete</a>
                           </td> 
                        </tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
            </div>
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
 function funDel(id)
 {    
 //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
 	   tblpkey = '<?php echo $tblpkey; ?>';
 	   pagename  ='<?php echo $pagename; ?>';
 		modulename  ='<?php echo $modulename; ?>';
// 	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
 	{
 		$.ajax({
 		  type: 'POST',
 		  url: '../ajax/delete1.php',
 		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
 		  dataType: 'html',
 		  success: function(data){
 			 
// 			 // alert('Data Deleted Successfully');
 			  location=pagename+'?ownerid=<?php echo $_GET['ownerid'];?>';
		}
		
		  });//ajax close
	}//confirm close
	} //fun close
function getUrl(voucher_id){
	window.location.href='?voucher_id='+voucher_id+'&ownerid='+<?php echo $_GET['ownerid'];?>
}



 

function gettot_paid()
{

	
	var bal_amt = parseFloat(document.getElementById('bal_amt').value);
	var payamount = parseFloat(document.getElementById('payamount').value);
	
	
	var bal_amt=bal_amt-payamount;
	document.getElementById('bal_amt').value=bal_amt;
	
	
	
	
	
	
}


</script>			
                
		
	</body>

	</html>
