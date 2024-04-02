<?php error_reporting(0);
include("dbconnect.php");
if(isset($_POST['submit']))
{
	$dieslipid = $_REQUEST['dieslipid'];
	$slipno = $_REQUEST['slipno'];
	$diedate = $cmn->dateformatusa($_REQUEST['diedate']);
	$truckid = $_REQUEST['truckid'];
	$drivername = $_REQUEST['drivername'];
	$dieselshortage = $_REQUEST['dieselshortage'];
	$prevread = $_REQUEST['prevread'];
	$metread = $_REQUEST['metread'];
	$totalkm = $_REQUEST['totalkm'];
	$remarks = $_REQUEST['remarks'];
	$actual_avg = $_REQUEST['actual_avg'];
	$supplier_id = $_REQUEST['supplier_id'];
	$productid = $_REQUEST['productid'];
	$qty = $_REQUEST['qty'];
	$rate = $_REQUEST['rate'];
	$naration = $_REQUEST['naration'];
	
	
	$bonus_amt = $_REQUEST['bonus_amt'];
	$head_id = $_REQUEST['head_id'];
	$payment_type = $_REQUEST['payment_type'];
	$chequeno = $_REQUEST['chequeno'];
	$bankid = $_REQUEST['bankid'];
	$chequedate = $cmn->dateformatusa($_REQUEST['chequedate']);
	
	
		if($dieslipid == 0)
		{
			//insert into diesel_demand_slip
			 $sql_ins = "insert into diesel_demand_slip set slipno = '$slipno',diedate = '$diedate',truckid = '$truckid',drivername = '$drivername',dieselshortage = '$dieselshortage',prevread = '$prevread' ,metread = '$metread' ,totalkm = '$totalkm',remarks = '$remarks',actual_avg = '$actual_avg',createdate= now(),lastupdated = now(),sessionid = '$_SESSION[sessionid]',bonus_amt='$bonus_amt',head_id='$head_id',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',
			 chequedate='$chequedate'";//die;
			$res_ins = mysqli_query($connection,$sql_ins);
			$dieslipid = mysqli_insert_id($connection);
			
			//insert details
			for($i = 0;$i< count($supplier_id);$i++)
			{
				if($productid[''.$i] != 0 && $productid[''.$i] != "")
				{
				$sql_det = "insert into diesel_demand_detail set dieslipid = '$dieslipid',supplier_id = '$supplier_id[$i]',productid = '$productid[$i]' ,qty = '$qty[$i]' ,rate = '$rate[$i]' ,naration = '$naration[$i]',createdate= now(),lastupdated = now(),sessionid = '$_SESSION[sessionid]'";
				$res_det = mysqli_query($connection,$sql_det);
				}
			}
			//die;
			$action = "1";
			
		}
		else
		{
			//update
			$sql_upd = "update diesel_demand_slip set slipno = '$slipno',diedate = '$diedate',truckid = '$truckid',drivername = '$drivername',dieselshortage = '$dieselshortage',prevread = '$prevread' ,metread = '$metread' ,totalkm = '$totalkm',remarks = '$remarks',actual_avg = '$actual_avg',lastupdated = now(),
			bonus_amt='$bonus_amt',head_id='$head_id',payment_type='$payment_type',chequeno='$chequeno',bankid='$bankid',chequedate='$chequedate', sessionid = '$_SESSION[sessionid]' where dieslipid = '$dieslipid'";
			$res_ins = mysqli_query($connection,$sql_upd);
			
			//delete all details
			mysqli_query($connection,"delete from  diesel_demand_detail where dieslipid = '$dieslipid' ");
			//insert details
			for($i = 0;$i< count($supplier_id);$i++)
			{
				if($productid[''.$i] != 0 && $productid[''.$i] != "")
				{
				$sql_det = "insert into diesel_demand_detail set dieslipid = '$dieslipid',supplier_id = '$supplier_id[$i]',productid = '$productid[$i]' ,qty = '$qty[$i]' ,rate = '$rate[$i]' ,naration = '$naration[$i]',createdate= now(),lastupdated = now(),sessionid = '$_SESSION[sessionid]'";
				$res_det = mysqli_query($connection,$sql_det);
				}
			}
			//die;
			$action = "2";
		}
		//die;
		echo "<script>location = 'diesel_demand_slip.php?action=$action';</script>";
	
	
}

?>