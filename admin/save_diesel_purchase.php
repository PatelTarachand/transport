<?php error_reporting(0);
include("dbconnect.php");
if(isset($_POST['submit']))
{
	$d_purchase_id = $_REQUEST['d_purchase_id'];
	$invoice_no = $_REQUEST['invoice_no'];
	$invoice_date = $cmn->dateformatusa($_REQUEST['invoice_date']);
	$supplier_id = $_REQUEST['supplier_id'];
	$shipment_doc_no = $_REQUEST['shipment_doc_no'];
	$delivery_no = $_REQUEST['delivery_no'];
	$truckno = $_REQUEST['truckno'];
	
	$type = $_REQUEST['type'];
	$qty = $_REQUEST['qty'];
	$rate = $_REQUEST['rate'];
	$discrs = $_REQUEST['discrs'];
	$dly_tax = $_REQUEST['dly_tax'];
	$tax = $_REQUEST['tax'];
	$cess_fixed = $_REQUEST['cess_fixed'];
	
	
	
	
	
	
		if($d_purchase_id == 0)
		{
		
			//insert into diesel_purchase_entry
			 $sql_ins = "insert into diesel_purchase_entry set invoice_no = '$invoice_no',invoice_date = '$invoice_date',supplier_id = '$supplier_id',shipment_doc_no = '$shipment_doc_no',truckno='$truckno',delivery_no = '$delivery_no',createdate= now(),lastupdated = now(),ipaddress='$ipaddress',sessionid='$_SESSION[sessionid]'";//die;
		
			$res_ins = mysqli_query($connection,$sql_ins);
			 $d_purchase_id = mysqli_insert_id($connection);
		
			//insert details
			for($i = 0;$i< count($type);$i++)
			{
				
							
				if($type[$i] != "")
				{			 
				 
				$sql_det = "insert into diesel_purchase_entry_detail set d_purchase_id = '$d_purchase_id',type = '$type[$i]',qty = '$qty[$i]' ,dly_tax = '$dly_tax[$i]',rate ='$rate[$i]',discrs='$discrs[$i]',tax = '$tax[$i]',cess_fixed ='$cess_fixed[$i]',createdate= now(),lastupdated = now()"; 
				$res_det = mysqli_query($connection,$sql_det);
				}
			}
			//die;
			$action = "1";
			
		}
		else
		{
			//update
			$sql_upd = "update diesel_purchase_entry set invoice_no = '$invoice_no',invoice_date = '$invoice_date',supplier_id = '$supplier_id',shipment_doc_no = '$shipment_doc_no',delivery_no = '$delivery_no',truckno='$truckno',createdate= now(),lastupdated = now(),ipaddress='$ipaddress'  where d_purchase_id = '$d_purchase_id'";
			$res_ins = mysqli_query($connection,$sql_upd);
			
			//delete all details
			mysqli_query($connection,"delete from  diesel_purchase_entry_detail where d_purchase_id = '$d_purchase_id' ");
			

			//insert details
			for($i = 0;$i< count($type);$i++)
			{
				if($type[$i] != "")
				{
					
				$sql_det = "insert into diesel_purchase_entry_detail set d_purchase_id = '$d_purchase_id',type = '$type[$i]',qty = '$qty[$i]' ,dly_tax = '$dly_tax[$i]',rate ='$rate[$i]',discrs='$discrs[$i]',tax = '$tax[$i]',cess_fixed ='$cess_fixed[$i]',createdate= now(),lastupdated = now()";
				$res_det = mysqli_query($connection,$sql_det);
				}
			}
			//die;
			$action = "2";
		}
		//die;
		echo "<script>location = 'diesel_purchase_entry.php?action=$action';</script>";
	
	
}

?>