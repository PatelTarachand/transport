<?php
include("dbconnect.php");
if(isset($_POST['save']))
{
/*
echo "<pre>";

print_r($_POST);
die; */
	 $billid = $_POST['billid'];
	$consignorid= $_POST['consignorid'];
	$consigneeid= $_POST['consigneeid'];
	$consi_type= $_POST['consi_type'];
	$billno= $_POST['billno'];
	$billdate= $cmn->dateformatdb($_POST['billdate']);
	$istaxable  = $_POST['istaxable'];
	//$gatepassno= $_POST['gatepassno'];
	$rate= $_POST['rate'];
	
	//print_r($rate);
	$ulamt =  $_POST['ulamt'];
	//print_r($ulamt); die;
	
	$taxable_percent= 0;
	$serv_tax_percent = 0;
	$ecess_percent= 0;
	$hcess_percent= 0;
	$safai_percent= 0;
	$krishi_cess = 0;
	$addlist = $_POST['addlist'];
	$billamount = 0;
	
	$cgst_percent = $_POST['cgst_percent'];
	$sgst_percent = $_POST['sgst_percent'];	
	//print_r($addlist);die;
	$bid_iddata = explode(",",$addlist);
	
foreach($bid_iddata as $key => $link) 
{     if($link === '0') 
    { 
        unset($bid_iddata[$key]); 
    }
} 
$bid_id=array();
foreach($bid_iddata as $data) 
{    
array_push($bid_id,$data);
} 


// print_r($bid_id);die;
	if($billid == '0')
	{

	//insert

		$sql_ins = "insert into bill set consignorid = '$consignorid',consi_type = '$consi_type',consigneeid = '$consigneeid', billno='$billno',istaxable = '$istaxable', billdate='$billdate', taxable_percent='$taxable_percent', serv_tax_percent='$serv_tax_percent', krishi_cess = '$krishi_cess',cgst_percent='$cgst_percent',sgst_percent='$sgst_percent',
		ecess_percent='$ecess_percent', hcess_percent='$hcess_percent', safai_percent='$safai_percent',compid='$compid', createdate = now(), sessionid='$_SESSION[sessionid]'";
		mysqli_query($connection,$sql_ins);
		$billid  = mysqli_insert_id($connection);
		$action=1;
	}
	else
	{
		//update
	
		$sql_ins = "update bill set consignorid = '$consignorid',consigneeid = '$consigneeid', billno='$billno', billdate='$billdate', istaxable = '$istaxable', taxable_percent='$taxable_percent', serv_tax_percent='$serv_tax_percent', krishi_cess = '$krishi_cess',cgst_percent='$cgst_percent',sgst_percent='$sgst_percent',
		ecess_percent='$ecess_percent', hcess_percent='$hcess_percent', safai_percent='$safai_percent',compid='$compid', lastupdated = now() where billid = '$billid'";
		mysqli_query($connection,$sql_ins);
		$action=2;
		
	}
	
	 

	
	if($billid != '0' || $billid != "")
	{
	//echo "select bid_id from bill_details where billid = '$billid'";die;	
		$sql_get = mysqli_query($connection,"select bid_id from bill_details where billid = '$billid'");
		while($row_get = mysqli_fetch_assoc($sql_get))
		{
			
			mysqli_query($connection,"update bidding_entry set is_invoice = '0' where bid_id = '$row_get[bid_id]'");
		}
		
		
		mysqli_query($connection,"delete from bill_details  where billid = '$billid'");
	
	
		
		
		for($i=0;$i<count($bid_id);$i++)
		{
			if($bid_id[''.$i] != '0' && $bid_id[''.$i] != "")
			{				
			 $rate_val = $rate[$i];			
			mysqli_query($connection,"insert into bill_details set billid = '$billid',bid_id = '$bid_id[$i]',ulamt='$ulamt[$i]',compid='$compid',sessionid='".$_SESSION['sessionid']."'");
		
			mysqli_query($connection,"update bidding_entry set is_invoice='1',invoiceid='$billid',comp_rate='$rate[$i]'  where bid_id ='$bid_id[$i]'");			
			}
		}
	}
	
	echo "<script>location='billing_entry_emami.php?action=$action';</script>";
}
?>