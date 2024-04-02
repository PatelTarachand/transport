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
			$placename = ucwords(trim(addslashes($data[0])));	
						
			if($c!=1)
			{
	                                                                                                                                                                    $cnt = $cmn->getvalfield($connection,"m_place","count(*)","placename='$placename'");
																																										
				if($cnt==0)
				{
					mysqli_query($connection,"insert into m_place set placename='$placename',createdate='$createdate',sessionid='$sessionid'");	
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