<?php
include("dbconnect.php");

$crit = " where 1=1 ";
if(isset($_REQUEST['consignorid'])!="")
{
	$consignorid = addslashes(trim($_REQUEST['consignorid']));
	$crit .= " and consignorid = '$consignorid'";
}

if(isset($_REQUEST['placeid'])!="")
{
	$placeid = addslashes(trim($_REQUEST['placeid']));
	$crit .= " and placeid = '$placeid'";
}

$slno=1;
$sel = "select * from m_rates $crit order by fromdate desc";
$res =mysqli_query($connection,$sel);
while($row = mysqli_fetch_array($res))
{
	$consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid=$row[consignorid]");
?>
	<tr>
		<td><?php echo $slno; ?></td>
		<td><?php echo $consignorname; ?></td>
		<td><?php echo $cmn->getvalfield($connection,"m_place","placename","placeid=$row[placeid]");?></td>
		<td><?php echo $cmn->dateformatindia(ucfirst($row['fromdate']));?></td>
		<td><?php echo $cmn->dateformatindia(ucfirst($row['todate']));?></td>
		<td><?php echo ucfirst($row['companyrate']);?></td>
        <td><?php echo ucfirst($row['clinkerrate']);?></td>
       <td class='hidden-480'>
       <!--<a href= "?edit=<?php //echo ucfirst($row['rateid']);?>"><img src="../img/b_edit.png" title="Edit"></a>-->
       &nbsp;&nbsp;&nbsp;
       <a onClick="funDel('<?php echo $row['rateid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
       </td>
	</tr>
	<?php
	$slno++;
}
?>