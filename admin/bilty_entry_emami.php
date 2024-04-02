<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='bilty_entry_emami.php';
$modulename = "Recent Added Bidding";

$userid=$_SESSION['userid'];

if(isset($_GET['consignorid']))
{
	$consignorid= trim(addslashes($_GET['consignorid']));
	$placeid = $cmn->getvalfield($connection,"m_consignor","placeid","consignorid='$consignorid'");
}
else {
$consignorid=4;
$placeid = '';
}



if(isset($_GET['bid_id']))
{
		$bid_id = trim(addslashes($_GET['bid_id']));	
		$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
		$row=mysqli_fetch_assoc($sql);
		$consignorid = $row['consignorid'];
		$order_no = $row['order_no'];
		$di_no = $row['di_no'];
		$tokendate = date('d-m-Y',strtotime($row['tokendate']));
		$inv_date = $cmn->dateformatindia($row['inv_date']);
		$invoiceno = $row['invoiceno'];
		if($invoiceno=='') { $invoiceno = $cmn->getvalfield($connection,"m_session","inv_prefix","sessionid='$sessionid'"); }
		$bilty_no = $row['bilty_no'];
		$gr_no = $row['gr_no'];
		$consigneeid = $row['consigneeid']; 
		$placeid = $row['placeid'];
		$destinationid = $row['destinationid'];
		$truckid = $row['truckid'];
		$driver =$row['driver']; 
		$itemid = $row['itemid'];
		$discount = $row['discount'];
		$brand_id = $row['brand_id'];
		$totalweight = $row['totalweight'];
		$noofqty = $row['noofqty'];
		$biltyremark = $row['biltyremark'];
		$ewayno =$row['ewayno']; 
		$drivermobile = $row['drivermobile'];
			$packingqty = $row['packingqty'];
				$pid = $row['pid'];
		$own_rate = $row['own_rate'];
		$lr_no = $row['lr_no'];
		$comp_rate = $row['comp_rate'];
		$freightamt = $row['comp_rate']*$row['totalweight'];
		$totalamt = $own_rate * $totalweight;
		$netamount = $totalamt - $discount;

}
else
{	
		$bid_id =0;
		$order_no = '';
		$lr_no='';
		$di_no = '';
		$order_no = '';
		$tokendate = '';
		$invoiceno = '';
		$bilty_no = '';
		$ownername='';
		$inv_date = '';
		$gr_no = '';
		$consigneeid = '';
		$lrno='';
		$ewayno='';
		$destinationid = '';
		$truckid = '';
		$driver = '';
		$deliverat = '';
		$itemid = '';
		$brand_id = '6';
		$totalweight = '';
		$noofqty = '';
		$comp_rate = '';
		$own_rate = '';
		$freightamt = '';
		$biltyremark = '';
		$placeid=431;
		$drivermobile='';
		$own_rate='';
		$comp_rate = '';
		
		$duplicate= "";
		$packingqty = "";
				$pid = "";
		$inv_date=$cmn->dateformatindia(date('Y-m-d'));
		$tokendate=$cmn->dateformatindia(date('Y-m-d'));
}




if(isset($_POST['sub'])) {

   	$bid_id = trim(addslashes($_POST['bid_id']));
	$di_no = trim(addslashes($_POST['di_no']));
	$consignorid = trim(addslashes($_POST['consignorid']));
	$placeid = trim(addslashes($_POST['placeid']));
	$destinationid = trim(addslashes($_POST['destinationid']));
	$itemid = trim(addslashes($_POST['itemid']));
	$comp_rate = trim(addslashes($_POST['comp_rate']));
	$own_rate = trim(addslashes($_POST['own_rate']));
	$totalweight = trim(addslashes($_POST['totalweight'])); 
		$noofqty = trim(addslashes($_POST['noofqty'])); 
   // $noofqty = $totalweight * 20; 	
     $totalweight1 = $totalweight." MT"; 
	//$remark = trim(addslashes($_POST['remark']));
	$brand_id= trim(addslashes($_POST['brand_id']));
	$newdate = date('Y-m-d H:i:s');
	//$order_type= trim(addslashes($_POST['order_type']));
	$order_no= trim(addslashes($_POST['order_no']));
	$consigneeid = trim(addslashes($_POST['consigneeid'])); 
    $inv_date = $_POST['inv_date'];
    $tokendate = $cmn->dateformatusa($_POST['tokendate']);
    $invoiceno = $_POST['invoiceno'];
    $lr_no = $_POST['lr_no'];
    $truckid = $_POST['truckid'];
    $driver =$_POST['driver']; 
    $itemid = $_POST['itemid'];
    $biltyremark = $_POST['biltyremark'];
    $ewayno = $_POST['ewayno'];
    $drivermobile = $_POST['drivermobile'];
   	$is_bilty = 1;
	 $freightamt = $_POST['freightamt'];
	 $Discount = $_POST['discount'];
	 $bilty_no = $_POST['bilty_no'];
	 
	 	$packingqty = $_POST['packingqty'];
				$pid = $_POST['pid'];
				
				$mobileNumber = $cmn->getvalfield($connection," m_consignee","phoneno","consigneeid='$consigneeid'");
				$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
					  $mobileNumber1 = $cmn->getvalfield($connection,"m_truckowner","mobileno1","ownerid='$ownerid'");
				 $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
				$consigneename = $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$consigneeid'");
	   $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	   $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	 $placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
  $toplacename = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");

	  $companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$compid'");
$link="bid_id=38";
$customer= $consigneename . $companyname;
$customer1= $ownername . $companyname;
			 



		 
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
	 



    	
    		
        if($bid_id==0) {
       
	$sql_chk = "select * from bidding_entry where lr_no='$lr_no' && sessionid='$sessionid'  && compid='$compid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
        $sql_update = "insert into bidding_entry set bilty_date = '$tokendate',packingqty='$packingqty',pid='$pid',tokendate='$tokendate', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid',entry_type='Dispatch'"; 
        
		//echo $sql_update;die;
            mysqli_query($connection,$sql_update);
            
            
       		$last_id = mysqli_insert_id($connection);
		
		  	$tiny_url = get_tiny_url('https://shivalilogistics.in/erp/admin/pdf_bilty_invoice_emami1.php?bid_id='.$last_id);
			// echo "hjghg";die;
	// echo  $tiny_url;die;
  $msgs="Dear $consigneename  Your Truck $truckno Loaded $itemname On $inv_date From $placename To  $toplacename , QTY $totalweight1 Party is $ownername contact $mobileNumber. To Download Your Builty click $tiny_url SVLGST";

//  echo"Dear {#$consigneename . $companyname#} Your Truck {#$truckno#} Loaded {#$itemname#} On {#$inv_date#} From {#$placename#} To {#$toplacename#} , QTY {#$noofqty#} Party is {#$consigneename#} contact {#$mobileNumber#}. To Download Your Builty click {#$link}";die;
$msg = str_replace(' ', '%20', $msgs);
// echo $msg;die;
 $msg2="Dear $ownername  Your Truck $truckno Loaded $itemname On $inv_date From $placename To  $toplacename , QTY $totalweight1 Party is $consigneename contact $mobileNumber1. To Download Your Builty click $tiny_url SVLGST";
//  echo"Dear {#$consigneename . $companyname#} Your Truck {#$truckno#} Loaded {#$itemname#} On {#$inv_date#} From {#$placename#} To {#$toplacename#} , QTY {#$noofqty#} Party is {#$consigneename#} contact {#$mobileNumber#}. To Download Your Builty click {#$link}";die;
$msg1 = str_replace(' ', '%20', $msg2);
sendsmsGET($mobileNumber,$msg);
GET1($mobileNumber1,$msg1);
            echo "<script>location='bilty_entry_emami.php?action=1';</script>";
       
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
            }
            
        
            else
            {
           
        		$sql_chk = "select * from bidding_entry where lr_no='$lr_no'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
	//	if($cnt!=0 && $_GET['edit']=='true')
	//	{	
//	echo "update  bidding_entry set bilty_date = '$tokendate',tokendate='$tokendate', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid' where bid_id='$bid_id'";die;
                $sql_update = "update  bidding_entry set bilty_date = '$tokendate',tokendate='$tokendate',packingqty='$packingqty',pid='$pid', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid' where bid_id='$bid_id'"; 	 
         
            mysqli_query($connection,$sql_update);
              echo "<script>location='bilty_entry_emami.php?bid_id=$bid_id&action=2';</script>";
	//	}   

	//else
	//	$duplicate ="* Duplicate entry .... Data can not be saved!";
          
            
            }
        
        
    }
    
    $increasebiltyno=    $cmn->getcode($connection,"bidding_entry","bilty_no","compid = '$_SESSION[compid]' && sessionid='$sessionid'");
    
   
function sendsmsGET($mobileNumber,$msg)
{	
    //API URL

	 $url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber&message=$msg&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707168907871490147";


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

function GET1($mobileNumber1,$msg1)
{
	$url="https://mobicomm.dove-sms.com//submitsms.jsp?user=Chaaravi&key=627e1eb48fXX&mobile=$mobileNumber1&message=$msg1&senderid=SVLGST&accusage=1&entityid=1701168864567671448&tempid=1707168907871490147";

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
$(document).ready(function(){
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
});
$(document).ready(function(){
	$("#shortcut_consigneeid").click(function(){
		$("#div_consigneeid").toggle(1000);
	});
	});
	$(document).ready(function(){
	$("#short_place").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});
	
	$(document).ready(function(){
	$("#short_di_no").click(function(){
		$("#div_di_no").toggle(1000);
	});
	});
	
	$(function() {
   
	 $('#tokendate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
     $('#inv_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
  });

</script>
</head>

<body data-layout-topbar="fixed">

<div class="messagepop pop" id="div_truck">
<img src="b_drop.png" class="close" onClick="$('#div_truck').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Truck </strong></td></tr>
  <tr><td>&nbsp;<b>Owner Name:</b> <img src="add.png" id="short_owner"><a href="#" id="add_new" data-form="div_owner" tabindex="49"></a></td></tr>
  <tr>
  	<td>
  		<select name="sc_ownerid" id="sc_ownerid" class="select2-me" style="width:202px;">
        <option value="">--select--</option>
        <?php 
		
		$sql_sc = "select * from m_truckowner order by ownername"; 
		$res_sc = mysqli_query($connection,$sql_sc);
		while($row_sc = mysqli_fetch_array($res_sc))
		{ ?>
        	<option value="<?php echo $row_sc['ownerid']; ?>"><?php echo $row_sc['ownername']; ?></option>
		<?php
        }
		?>
        </select>
  	</td>
  </tr>
  <tr><td>&nbsp;<b>Truck Number:</b> </td></tr>
  <tr><td><input type="text" name="sc_truckno" id="sc_truckno" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_truckno('sc_ownerid','sc_truckno');"/></td></tr>
</table>
</div>


<div class="messagepop pop" id="div_owner">
<img src="b_drop.png" class="close" onClick="$('#div_owner').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place </strong></td></tr>
  <tr><td>&nbsp;<b>Owner Name:</b> </td></tr>
  <tr><td><input type="text" name="ownername" id="ownername" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_owner('placename');"/></td></tr>
</table>
</div>

<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place </strong></td></tr>
  <tr><td>&nbsp;<b>Placename:</b> </td></tr>
  <tr><td><input type="text" name="placename" id="placename" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_place('placename');"/></td></tr>
</table>
</div>

<div class="messagepop pop" id="div_consigneeid">
<img src="b_drop.png" class="close" onClick="$('#div_consigneeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Consignee</strong></td></tr>
  <tr><td>&nbsp;Consignee Name: </td></tr>
  <tr><td><input type="text" name="consigneename" id="consigneename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>
 
  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_consigneename();"/></td></tr>
</table>
</div>
	
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	 
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
							
                   <form method="post" action="">
                  	  
    				<fieldset style="margin-top:45px; margin-left:45px;" >
       <!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>    -->                              
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Add New Bilty  </legend>
    	
    	<h4 style="color:#FF0000;"> <?php echo $duplicate; ?></h4>
    	
         
		   
		   <div class="innerdiv" style="display: flex;align-items: center;">
			<div>LR No. <span class="err" style="color:#F00;">*</span> </div>
			<div class="text">
			    	<input type="text" class="formcent" name="lr_no" id="lr_no" maxlength="20"  value="<?php	echo $lr_no;  ?>" required style="border: 1px solid #368ee0" autocomplete="off"  >
			       
			</div>
			</div>      
				 
			
			<div class="innerdiv" style="display:none;">
			<div>Own Bilty No.</div>
			<div class="text">
			<input type="text" class="formarea control_dynamic" name="order_no" id="order_no" value="<?php echo $order_no; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
			</div>
			</div>
				 
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div> Bilty No </div>
			<div class="text">
			<input type="text" class="formcent" name="bilty_no" id="bilty_no" maxlength="20" value="<?php  if($bilty_no!='')
			                                                                        {  echo $bilty_no; }
			                                                                        else { echo $increasebiltyno; } ?>"  style="border: 1px solid #368ee0" autocomplete="off"  >
			</div>
			</div>
			
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Bilty Date </div>
			<div class="text">
			<input type="text" class="formcent" name="tokendate" id="tokendate" value="<?php echo $tokendate; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >
			</div>
			</div>
			
			
			<div class="innerdiv" style="display:none;">
			<div> LR No <span class="err" style="color:#F00;">*</span>
			</br> <span id="msglr_no" style="color: red;font-size: 10px"></span>
			</div>
			<div class="text">

			<input type="text" class="formcent" name="di_no" id="di_no"  value="<?php	echo $di_no;  ?>"  style="border: 1px solid #368ee0" autocomplete="off"  >
			</div>
			</div>
			 
				
				 <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Invoice No <span class="err" style="color:#F00;"></span></div>
                    <div class="text">
                     <input type="text" class="formcent" name="invoiceno" id="invoiceno" maxlength="20" value="<?php  	echo $invoiceno; 			 ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >                
                </div>
                </div>
				
				<div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Invoice Date  <span class="err" style="color:#F00;"></span></div>
                    <div class="text">
                    <input type="text" class="formcent" name="inv_date" id="inv_date" value="<?php echo 	$inv_date; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
	
<br>
<br>
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Item<span class="err" style="color:#F00;">*</span> </div>
			<div class="text">
						
			<select id="itemid" name="itemid" class="select2-me input-large " style="width:220px;"  onChange="getbags();" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from inv_m_item");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['itemid']; ?>"><?php echo $row_fdest['itemname']; ?></option>
			<?php
			} ?>
			</select>
			
			
			<script>document.getElementById('itemid').value = '<?php echo $itemid; ?>';</script>
			</div>
			</div>
			
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Brand</div>
			<div class="text">
			
			<select id="brand_id" name="brand_id" class="input-large select2-me" style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from brand_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['brand_id']; ?>"><?php echo $row_fdest['brand_name']; ?></option>
			<?php
			} ?>
			</select>
			
			<script>document.getElementById('brand_id').value = '<?php echo $brand_id; ?>' ;</script>   
			
			
			
			</div>
			</div>
			
		 <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Total Weight/MT<span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="totalweight" id="totalweight" value="<?php echo $totalweight;?>" style="border: 1px solid #368ee0;" autocomplete="off" required >                   
                    </div>
					</div> 
              <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Qty (Bags)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="noofqty" id="noofqty" value="" style="border: 1px solid #368ee0;" autocomplete="off" onChange="totalFreight();"  >                   
                    </div>
					</div> 
					    <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Own Rate</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="own_rate" id="own_rate" value="<?php echo $own_rate;?>" style="border: 1px solid #368ee0;" autocomplete="off" onChange="totalFreight();"  >                   
                    </div>
					</div> 
							 <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Company Rate</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="comp_rate" id="comp_rate" value="<?php echo $comp_rate;?>" style="border: 1px solid #368ee0; " autocomplete="off"  >                   
                    </div>
					</div>  
					
                     <div class="innerdiv" style="display:none">
                    <div>Total Amount</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="totalamt" id="totalamt" value="<?php echo number_format($totalamt,2);?>" style="border: 1px solid #368ee0;" autocomplete="off"  >                   
                    </div>
					</div> 	
			
				<div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Total Freight Amt</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="freightamt" id="freightamt" value="<?php echo $freightamt;?>" style="border: 1px solid #368ee0" autocomplete="off" >                 
                    </div>
					</div>
			
                    
                  


            
               <div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Consignor<span class="err" style="color:#F00;">*</span>
                    </br> <span id="msg" style="color: red;font-size: 10px"></span> 
                    </div>
                    <div class="text">
                   <?php echo $cmn->create_combo($connection,"m_consignor","consignorid","consignorname","1=1","formcent select2-me"); ?>
			<script>document.getElementById('consignorid').value = '<?php echo $consignorid; ?>' ;</script>                                    
                </div>
                </div>

			
                
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Consignee <span class="err" style="color:#F00;">*</span><img src="add.png" id="shortcut_consigneeid"><a href="#" id="add_new" data-form="short_consignee" tabindex="49"></a></div>
			<div class="text">
			<?php echo    $cmn->create_combo($connection,"m_consignee","consigneeid","consigneename","1=1","formcent select2-me") ?>
			<script>document.getElementById('consigneeid').value = '<?php echo $consigneeid; ?>' ;</script>                    
			</div>
			</div>			
	<br>
	<br>
	
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>From Place <span class="err" style="color:#F00;">*</span> &nbsp;</div>
			<div class="text">
			<?php echo $cmn->create_combo($connection,"m_place","placeid","placename","1=1"," input-large select2-me"); ?>
			<script>document.getElementById('placeid').value = '<?php echo $placeid; ?>';</script>
			</div>
			</div>
			
		
			
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Ship To City <span class="err" style="color:#F00;">*</span> <img src="add.png" id="short_place"><a href="#" id="add_new" data-form="div_placeid" tabindex="49"></a> </div>
			<div class="text">
			<select id="destinationid" name="destinationid" class="select2-me input-large" style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from m_place");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['placeid']; ?>"><?php echo $row_fdest['placename']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('destinationid').value = '<?php echo $destinationid; ?>';</script>
			</div>
			</div>	
			
			
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div> Truck No <span class="err" style="color:#F00;">*</span> &nbsp;<img src="add.png" id="shortcut_truck"><a href="#" id="add_new" data-form="short_truck" tabindex="49"></a></div>
			<div class="text">
			<select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" required >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select truckid,truckno from m_truck");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
			
			</div>
			</div>
			<div class="innerdiv" style="display: flex;align-items: center;">
                    <div>Owner Name </div>
                    <div class="text">
                     <input type="text" class="formcent" name="ownername" id="ownername1" value="<?php echo $ownername; ?>"  style="border: 1px solid #368ee0"  autocomplete="off"  >                
                </div>
                </div>
		<br>
			<br>
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Driver Name :</div>
			<div class="text">
			<input type="text" class="formarea control_dynamic" name="driver" id="driver" value="<?php echo $driver;?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
			</div>
			</div>
			
			<div class="innerdiv" style="display: flex;align-items: center;">
			<div>Driver Mobile :</div>
			<div class="text">
			<input type="text" class="formarea control_dynamic" name="drivermobile" id="drivermobile" value="<?php echo $drivermobile;?>" style="border: 1px solid #368ee0" autocomplete="off" maxlength="10" >                   
			</div>
			</div>
			
				<div class="innerdiv" style="display: flex;align-items: center;">
                    <div>E-way Bill No </div>
                    <div class="text">
                     <input type="text" class="formcent" name="ewayno" id="ewayno" value="<?php echo $ewayno; ?>"  style="border: 1px solid #368ee0" maxlength="20"  autocomplete="off"  >                
                </div>
                </div>
	
                     <div class="innerdiv" style="display:none">
                    <div>Discount (Rs)</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="discount" id="discount" value="<?php echo $discount;?>" style="border: 1px solid #368ee0" autocomplete="off" onChange="getnetamt();" >                   
                    </div>
					</div> 
                    
                     <div class="innerdiv" style="display:none">
                    <div>Net Amount</div>
                    <div class="text">
                    <input type="text" class="formarea control_dynamic" name="netamt" id="netamt" value="<?php echo number_format($netamount,2);?>" style="border: 1px solid #368ee0;" autocomplete="off"  >                   
                    </div>
					</div> 
					 	<div class="innerdiv" style="display: flex;align-items: center;">
		<div>Method of Packing</div>
		<div class="text">
		<select id="pid" name="pid" class="input-large select2-me" style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select * from inv_packing_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['pid']; ?>"><?php echo $row_fdest['m_packing']; ?></option>
			<?php
			} ?>
			</select>
			
			<script>document.getElementById('pid').value = '<?php echo $pid; ?>' ;</script>                 
		</div>
		</div>
		
			<div class="innerdiv" style="display: flex;align-items: center;">
		<div>Packing Qty/Kg</div>
		<div class="text">
		<input type="text" class="formarea control_dynamic" name="packingqty" id="packingqty" value="<?php echo $packingqty; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
		</div>
		</div>
			
		<div class="innerdiv" style="display: flex;align-items: center;">
		<div>Remark</div>
		<div class="text">
		<input type="text" class="formarea control_dynamic" name="biltyremark" id="biltyremark" value="<?php echo $biltyremark; ?>" style="border: 1px solid #368ee0" autocomplete="off" >                   
		</div>
		</div>
		

					
					<div class="innerdiv">
	<br>
	

                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('truckid,consignorid'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="border-radius:4px;">Cancel</a>
                    </div>
                  </div>
					
                   
    				</fieldset>
    		        <input type="hidden" name="bid_id" id="bid_id" data-key="primary" value="<?php echo $bid_id; ?>">
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 100 records are shown below for more <a href="billty_record2.php?consignorid=<?php echo $consignorid; ?>" target="_blank">Click Here</a>)</span></h3>
							</div>
							
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>LR No</th>
											<th>Bilty No</th>
											<th>Bilty Date</th>
										
										<th>	Consignor</th>
											<th>Consignee</th>
											<th>Truck No.</th>
											<th>Destination</th>
											<th>Item</th>
											<th>Weight/(M.T.)</th>
											<th>Qty(Bags)</th>
											<th>Comp Rate</th>
											<th>Freight Rate</th>
											<th>Print</th>
											<th>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									if($usertype=='admin')
									{   $payUser=1;
										$cond="where compid='$_SESSION[compid]' ";	
									}
									else
									{
									    $payUser=0;
										//$cond="where createdby='$userid' ";	
										$cond="where compid='$_SESSION[compid]' ";											
									}
								// echo "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1  and compid='$compid' order by bid_id desc limit 0,100";
									$sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1  and compid='$compid' order by bid_id desc limit 0,100";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									    $paydone=$row['is_complete'];
									    	$truckid = $row['truckid'];	
									    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										  $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'");
									?>
									<tr tabindex="<?php echo $slno; ?>" class="abc">
						<td><?php echo $slno; ?></td>						
						<td><?php echo ucfirst($row['lr_no']);?></td>
						<td><?php echo ucfirst($row['bilty_no']);?></td>
						<td><?php echo  $row['tokendate'];?></td>
					
								<td><?php echo  $consignorname;?></td>		
						<td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
						<td><?php echo $truckno;?></td>
						<td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
						
						<td><?php echo ucfirst($cmn->getvalfield($connection,"inv_m_item","itemname","itemid = '$row[itemid]'"));?></td>						
						<td><?php echo ucfirst($row['totalweight']);?></td>						
												
						<td><?php if($row['noofqty']!='0') { echo ucfirst($row['noofqty']); } ?></td>
						<td><?php if($row['comp_rate']!='0'){ echo ucfirst($row['comp_rate']); } ?></td>
						<td><?php  if($row['comp_rate']!='0'){ echo $row['comp_rate']*$row['totalweight']; } ?></td>
						<td><a href= "pdf_bilty_invoice_emami.php?bid_id=<?php echo $row['bid_id'];?>" class="btn btn-success" target="_blank" >Print </a></td>
						<td class='hidden-480'>
						<!-- <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="edit('<?php echo $row['saleid']; ?>');" value="E">
						  <input type="button" class="btn btn-primary" style="display: none;" name="add_data_list" id="add_data_list_edit_<?php echo  $row['saleid'] ; ?>" onClick="editselected('<?php echo $row['saleid']; ?>','<?php echo $row['rate']; ?>','<?php echo $row['unitrate']; ?>','<?php echo $row['qty']; ?>','<?php echo $row['weight']; ?>','<?php echo $row['suppartyid']; ?>','<?php echo $row['unitid']; ?>','<?php echo $row['productid']; ?>','<?php echo $cmn->dateformatindia($row['billdate']); ?>');" value="E">
						  &nbsp; -->


						
							  
						<a onClick="edit('<?php echo $row['bid_id'];?>');"><img src="../img/b_edit.png" title="Edit"></a>
						    	<a href= "bilty_entry_emami.php?bid_id=<?php echo ucfirst($row['bid_id']); ?>&edit=true"  style="display: none;"id="add_data_list_edit_<?php echo  $row['bid_id'] ; ?>"
							    
							> </a>
							<!-- <a  href= "bilty_entry_emami.php?bid_id=<?php echo ucfirst($row['bid_id']);?>&edit=true"
							  
							><img src="../img/b_edit.png" title="Edit"></a> -->
						&nbsp;&nbsp;&nbsp;

						<a onClick="funDelotp('<?php echo $row['bid_id'];?>');"><img src="../img/del.png" title="Delete"></a>
										   <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['bid_id'] ; ?>" onClick="funDel('<?php echo $row['bid_id']; ?>');" value="X">
							<?php 
							    if($paydone!=0){ 
							//  echo "Payment Done.";
					?>

						</td>
						
						 <?php } ?>
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
	 

	 <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">OTP Check</h3>
    </div>
    <div class="modal-body">
       <center><span id="getotp"></span></center> 
        <h4>Enter 4 Digit Code</h4>
       <p>
       			<table>
                		<tr style="display: flex;">
                        		<td> <input type="text" id="otp" class="form-control" value="" autocomplete="off" > </td>
                                <td> <input type="button" class="btn btn-primary" onClick="checkotp();" value="Check" > </td>
                        </tr>
                        <input type="hidden" id="ref_id" value="" >
                </table>
       </p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button> 
    </div>
</div><!--#myModal-->


	 <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" class="modal hide fade in" id="myModallll">
    <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        <h3 id="myModalLabel">OTP Check</h3>
    </div>
    <div class="modal-body">
        <h4>Enter 4 Digit Code</h4>
       <p>
       			<table>
                		<tr>
                        		<td> <input type="text" id="otpppp" class="form-control" value="" autocomplete="off" > </td>
                                <td> <input type="button" class="btn btn-primary" onClick="checkotpppp();" value="check" > </td>
                        </tr>
                        <input type="hidden" id="ref_idddd" value="" >
                </table>
       </p>
    </div>
    <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button> 
    </div>
</div><!--#myModal-->                  
<script>
$('#gr_no').on("input", function() {
    var gr_no = this.value;
   $.ajax({
		  type: 'POST',
		  url: 'di_no_check.php',
		  data: 'gr_no=' + gr_no,
		  dataType: 'html',
		  success: function(data){
			 $('#msg').html(data);
			}
		  });//ajax close
});


$('#lr_no').on("input", function() {
    var lr_no = this.value;
   $.ajax({
		  type: 'POST',
		  url: 'lr_no_check.php',
		  data: 'lr_no=' + lr_no,
		  dataType: 'html',
		  success: function(data){
		  	
			 $('#msglr_no').html(data);
			 
			}
		
		  });//ajax close
    
});

function totalFreight(){
    	var totalweight = document.getElementById('totalweight').value;
    		var own_rate = document.getElementById('own_rate').value;
    		var freightamt=totalweight*own_rate;
    	//	alert(freightamt);
    			$('#freightamt').val(freightamt);	
}

function getdetail()
{
	var bid_id = document.getElementById('bid_id').value;
	
	if(bid_id !='') {
			window.location.href='?bid_id='+bid_id;
		}
}

function getnetamt() {
	var totalweight = parseFloat(document.getElementById('totalweight').value);
	var own_rate = parseFloat(document.getElementById('own_rate').value);
	var discount = parseFloat(document.getElementById('discount').value);
	
		if(isNaN(totalweight)) { totalweight=0; }
		if(isNaN(own_rate)) { own_rate=0; }
		if(isNaN(discount)) { discount=0; }	
		
		var totalamt = totalweight * own_rate;		
		var netamt = totalamt - discount;
		
		document.getElementById('totalamt').value= totalamt.toFixed(2);
		document.getElementById('netamt').value= netamt.toFixed(2);
	
	}

function funDel(id)
{    
	  //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
	   tblpkey = '<?php echo $tblpkey; ?>';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

function getOwner(truckid){
    
    $.ajax({
			type: 'POST',
			url: 'show_owner.php',
			data: 'truckid='+truckid,
			dataType: 'html',
			success: function(data){
			   // alert(data);
			   
			 //  	alert(data);
				arr = data.split('|');

				ownername1 = arr[0];
				driver = arr[1];
				// $('#ownername1').val(data);	
				jQuery('#ownername1').val(ownername1);
                  jQuery('#driver').val(driver);
				//console.log('get road');
				//console.log(data);
				$('#ownername1').val(data);	
			}
		});//ajax close	
}

function ajax_save_consigneename()
{
	var consigneename = document.getElementById('consigneename').value;	
	if(consigneename == "" )
	{
		alert('Fill form properly');
		document.getElementById("consigneename").focus();
		return false;
	}
	
	//alert(unitmessure);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//alert(xmlhttp.responseText);
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("consigneeid").innerHTML = xmlhttp.responseText;
				document.getElementById("consigneename").value = "";	
				//$('#itemid').select2('val', '');
				$("#div_consigneeid").hide(1000);
				document.getElementById("consigneeid").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savconsignee.php?consigneename="+consigneename,true);
	xmlhttp.send();	
}

function ajax_save_shortcut_owner(ownername)
{
	
	var ownername = document.getElementById('ownername').value;
	
	if( ownername == "")
	{
		alert('Fill form properly');
		document.getElementById(ownername).focus();
		return false;
	}
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			//alert(xmlhttp.responseText); 
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("sc_ownerid").innerHTML = xmlhttp.responseText;
				
				
				document.getElementById("ownername").value = "";
				$("#div_owner").hide(1000);
				//document.gwneretElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_saveowner.php?ownername="+ownername,true);
	xmlhttp.send();
}


function ajax_save_shortcut_place(placename)
{
	
	var placename = document.getElementById(placename).value;
	
	if( placename == "")
	{
		alert('Fill form properly');
		document.getElementById(placename).focus();
		return false;
	}
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("destinationid").innerHTML = xmlhttp.responseText;
				
				
				document.getElementById("placename").value = "";
				$("#div_placeid").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_saveplace.php?placename="+placename,true);
	xmlhttp.send();
}

function ajax_save_shortcut_truckno(sc_ownerid,sc_truckno)
{
	var ownerid = document.getElementById(sc_ownerid).value;
	var truckno = document.getElementById(sc_truckno).value;
	
	if(ownerid == "" || truckno == "")
	{
		alert('Fill form properly');
		document.getElementById(sc_truckno).focus();
		return false;
	}
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("truckid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("sc_truckno").value = "";
				document.getElementById("sc_ownerid").value = "";
				$("#div_truck").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savetruck.php?truckno="+truckno+"&ownerid="+ownerid,true);
	xmlhttp.send();
}


function getbags() {
    
	var totalweight = document.getElementById('totalweight').value;	
	var itemid= document.getElementById('itemid').value;	
	
	

	if(isNaN(totalweight)) { totalweight=0; }	
	if(itemid!=4){
	bags = totalweight * 20;	
	document.getElementById('noofqty').value=bags;
	}
	else{
		document.getElementById('noofqty').value=0;
	}

}
function checkotpppp() {
	var otp = document.getElementById('otpppp').value;
	var ref_id = document.getElementById('ref_idddd').value;
	if(otp !='') {
	 
					
					jQuery.ajax({
			  type: 'POST',
			  url: 'checkotp_billing_entry_delete.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
					// alert(data);
					if(data==1) {
						 //location = "other_expense.php?expenseid="+ref_id;
						 //alert("ok");
						 jQuery("#myModallll").modal('hide');
						jQuery("#add_data_delete_"+ref_id).click();
						} 
						else
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}


function edit(bid_id) {
    
	if(bid_id !='') {
				
				jQuery.ajax({
		  type: 'POST',
		  url: 'getotp_payment.php',
		  data: 'bid_id='+bid_id,
		  dataType: 'html',
		  success: function(data){ 
			  alert(data);
				  jQuery("#ref_id").val(bid_id);
				jQuery("#myModal").modal('show');
				//	jQuery("#getotp").html(data);
				
			}	
		  });//ajax close
		}	
}

function checkotp() {
	var otp = document.getElementById('otp').value;
	var ref_id = document.getElementById('ref_id').value;
	if(otp !='') {
					jQuery.ajax({
			  type: 'POST',
			  url: 'biltyentry_edit.php',
			  data: 'ref_id='+ref_id+'&otp='+otp,
			  dataType: 'html',
			  success: function(data){ 
			//	alert(data);
				
					if(data==1) {
						 //location = "other_expense.php?expenseid="+ref_id;
						 //alert("ok");
						 jQuery("#myModal").modal('hide');
						 location= "bilty_entry_emami.php?bid_id="+ref_id;
						 jQuery("#add_data_list_edit_"+ref_id).click();
						} 
						else
						alert("Wrong OTP");
				}	
			  });//ajax close
		 
	}
	
}


function funDelotp(bid_id){ 
    
	if(bid_id !='') {
		
				jQuery.ajax({
		  type: 'POST',
		  url: 'getotp_billing_entry_delete.php',
		  data: 'bid_id='+bid_id,
		  dataType: 'html',
		  success: function(data){ 
			// alert(data);
				  jQuery("#ref_idddd").val(bid_id);
				jQuery("#myModallll").modal('show');
			}	
		  });//ajax close
		}	
}
</script>			
                
	
</body>

</html>
