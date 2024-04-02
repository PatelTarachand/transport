<?php error_reporting(0);
include("dbconnect.php");
if(isset($_POST['submit']))
{
	if($_FILES['uploaded_file']['tmp_name']!='')
	{
		
		$file = $_FILES['uploaded_file']['tmp_name'];
		$handle = fopen($file,"r");	
		$c=1;
		while($data = fgetcsv($handle))
		{
			$truckno = ucwords(trim(addslashes($data[0])));	
			$openingbalance = ucwords(trim(addslashes($data[1])));
			$salary = ucwords(trim(addslashes($data[2])));
			$openningkm = ucwords(trim(addslashes($data[3])));
			
			$open_bal_date ="2018-07-31";
			
			if($c!=1)
			{
				
				
				if($truckno !='')
				{	
						$truckid = $cmn->getvalfield($connection,"m_truck","truckid","truckno='$truckno'");
					
						if($truckid =='')
						{	
						
						mysqli_query($connection,"insert into m_truck set truckno='$truckno',openingbalance='$openingbalance',salary='$salary',empid='$empid',openningkm='$openningkm',
									open_bal_date='$open_bal_date',createdate='$createdate',sessionid='$sessionid',ipaddress='$ipaddress'");
						}
						else
						{
							
							mysqli_query($connection,"update m_truck set truckno='$truckno',openingbalance='$openingbalance',salary='$salary',empid='$empid',openningkm='$openningkm',
									open_bal_date='$open_bal_date',createdate='$createdate',sessionid='$sessionid',ipaddress='$ipaddress' where truckid='$truckid'");
						}
				}	
			}
			$c++;
		}
		echo "<script>location='$pagename?action=$action</script>";
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<form action="" method="post" enctype="multipart/form-data" >
    		<input type="file" name="uploaded_file"  />
            <br /> <br />

			<input type="submit" name="submit" value="save"  />
    </form> 
</body>
</html>