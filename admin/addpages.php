<?php  error_reporting(0);                                                                                           include("dbconnect.php");

if(isset($_POST['submit']))
{
	$pagename = trim($_POST['pagename']);
	$module = trim($_POST['module']);
	$menu = trim($_POST['menu']);
	
	mysqli_query($connection,"insert into m_pages set pagename='$pagename',module='$module',menu='$menu'");
	
	header("location: addpages.php");
} 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
	<form method="post" action="" >
 <label>Pagename	:</label> <input type="text" name="pagename"  /> <br /> <br />

 <label>Module	:</label> <input type="text" name="module"  /> <br /> <br />

 <label>Menu	:</label> <input type="text" name="menu"  /> <br /> <br />

 <input type="submit" name="submit" value="save"  />
 </form>
</body>
</html>