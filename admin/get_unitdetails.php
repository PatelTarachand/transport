<?php error_reporting(0);
include("dbconnect.php");
$itemid = $_REQUEST['itemid'];



 $unitid = $cmn->getvalfield($connection,"items","unitid","itemid='$itemid'");
 
 $unit_name = $cmn->getvalfield($connection,"m_unit","unitname","unitid='$unitid'");
// $unit_id = $cmn->getvalfield($connection,"item_master","unit_id","item_id='$item_id '");
 


?>
 <option value="<?php echo $unitid; ?>"><?php echo  $unit_name; ?></option>