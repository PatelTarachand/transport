<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$total = trim(addslashes($_REQUEST['total']));
$truckid = trim(addslashes($_REQUEST['truckid']));
$slipno = trim(addslashes($_REQUEST['slipno'])); 
$tot_diesel = $cmn->getvalfield($connection,"diesel_demand_detail as A left join diesel_demand_slip as B on A.dieslipid=B.dieslipid","sum(qty)","B.truckid='$truckid' &&  A.productid='1' && B.dieslipid=(select max(dieslipid) from diesel_demand_slip where truckid = '$truckid')");

if($tot_diesel !='' && $tot_diesel !='0')
{
$act_average = round($total/$tot_diesel,2);
$bonusamt = $cmn->getvalfield($connection,"m_bonus","bonus_amt","'$act_average' between avg_from and avg_to order by bonus_id desc limit 1");
}
echo $act_average.'|'.$bonusamt;

?>