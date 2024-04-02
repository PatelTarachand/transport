<?php error_reporting(0);
include("dbconnect.php");
$consignorid = trim(addslashes($_REQUEST['consignorid']));
$destinationid = trim(addslashes($_REQUEST['destinationid']));
$rate_mt = trim(addslashes($_REQUEST['rate_mt']));
$billtydate = $cmn->dateformatusa(trim(addslashes($_REQUEST['billtydate'])));
$setdate = date('Y-m-d');

	

		if($rate_mt !='' && $rate_mt !='0')
		{
			
			
			$sql = mysqli_query($connection,"select rateid,rate from consignor_ratesetting where consignorid='$consignorid' && placeid='$destinationid' && setdate <='$billtydate' order by setdate desc,rateid desc limit 1");				
			$row=mysqli_fetch_assoc($sql);		
			 $rate = $row['rate'];

			if($rate !=$rate_mt)
			{
			if($chk_duplicate==0)
			{
				
	mysqli_query($connection,"delete from consignor_ratesetting where consignorid='$consignorid' && placeid='$destinationid' && setdate=
			'$billtydate'");			
			mysqli_query($connection,"insert into consignor_ratesetting set rate='$rate_mt',consignorid='$consignorid',placeid='$destinationid',setdate=
			'$billtydate',createdate='$setdate',sessionid='$sessionid'");	
			
			//echo "1";
			}
			}
		}

?>