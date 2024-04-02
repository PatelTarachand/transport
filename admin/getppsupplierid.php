<?php error_reporting(0);
include("dbconnect.php");
$type = trim(addslashes($_REQUEST['type']));

if($type=="self")
{
	echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_id","type='self'");
}
else
{
	echo "";
}

?>