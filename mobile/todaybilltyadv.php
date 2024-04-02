<?php error_reporting(0);
include("adminsession.php");
$pagename = "todaybilltyadv.php";
include("lib/dboperation.php");
include_once("lib/getval.php");

$curr_date = date('Y-m-d');

$isuchanti = ""; 
if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));
	//$crit=" where bid_id='$bid_id'";
	
}
else
$bid_id='';

	$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);
	$di_no = $row['di_no'];
	$truckid = $row['truckid'];
	$placeid = $row['placeid'];
	$totalweight = $row['totalweight'];
	$own_rate = $row['own_rate'];	
	$newrate = $row['newrate'];
	$adv_date = $row['adv_date'];
	$thirdid = $row['thirdid'];
		$otheradv_date = $row['otheradv_date'];
	if($adv_date !='') { $adv_date = $cmn->dateformatindia($adv_date); }
		if($otheradv_date !='') { $otheradv_date = $cmn->dateformatindia($otheradv_date); }
	
	$adv_cash = $row['adv_cash'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other =  $row['adv_other'];
	$adv_consignordate =  $row['adv_consignordate'];
	$adv_consignor =  $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
	$consignorid= $row['consignorid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
		$paytype = $row['paytype'];
	
	$advchequedate = $row['advchequedate'];
	if($advchequedate !='') { $advchequedate = $cmn->dateformatindia($advchequedate); }
	$adv_dieselltr = $row['adv_dieselltr']; 
	$supplier_id = $row['supplier_id']; 
	
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
	$toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	
	//$charrate = $own_rate - $newrate;
	//$netamount = $newrate * $wt_mt;
	//$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other;
	
	if($newrate==0){ $newrate=''; }
	if($adv_cash==0){ $adv_cash=''; }
	if($adv_diesel==0){ $adv_diesel=''; }
	if($adv_cheque==0){ $adv_cheque=''; }
	if($adv_consignordate==0){ $adv_consignordate=''; }
	if($adv_consignor==0){ $adv_consignor=''; }
	
	if($adv_date=='0000-00-00' || $adv_date=='')
	{
			$adv_date = date('d-m-Y');
	}
	
		if($otheradv_date=='0000-00-00' || $otheradv_date=='')
	{
			$otheradv_date = date('d-m-Y');
	}
	if($adv_consignordate=='0000-00-00' || $adv_consignordate=='')
	{
			$adv_consignordate = date('d-m-Y');
	}



if(isset($_POST['sub']))
{

	//$own_rate = trim(addslashes($_POST['own_rate']));
	
	$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));
	$otheradv_date = $cmn->dateformatusa(trim(addslashes($_POST['otheradv_date'])));
	$adv_cash = trim(addslashes($_POST['adv_cash']));
	$adv_diesel = trim(addslashes($_POST['adv_diesel']));	
	//$bankid = isset($_POST['bankid'])?trim(addslashes($_POST['bankid'])):'';
	//$adv_dieselltr = trim(addslashes($_POST['adv_dieselltr'])); 
	$adv_other = trim(addslashes($_POST['adv_other'])); 
		$paytype = trim(addslashes($_POST['paytype']));
			$thirdid = trim(addslashes($_POST['thirdid']));
			$adv_consignordate = trim(addslashes($_POST['adv_consignordate']));
			$adv_consignor = trim(addslashes($_POST['adv_consignor']));
	$supplier_id = isset($_POST['supplier_id'])?trim(addslashes($_POST['supplier_id'])):''; 
	$dispatch_date=date('Y-m-d');
	$isdispatch=1;
	
//echo "update  bidding_entry  set adv_cash = '$adv_cash',thirdid = '$thirdid',adv_other = '$adv_other',adv_diesel = '$adv_diesel',adv_date='$adv_date',otheradv_date='$otheradv_date',supplier_id='$supplier_id',ipaddress = '$ipaddress', isdispatch='$isdispatch', paytype='$paytype' where bid_id = $bid_id"; die;
		$sql_update = "update  bidding_entry  set adv_cash = '$adv_cash',thirdid = '$thirdid',adv_other = '$adv_other',adv_diesel = '$adv_diesel',adv_consignordate = '$adv_consignordate',adv_consignor = '$adv_consignor',adv_date='$adv_date',otheradv_date='$otheradv_date',supplier_id='$supplier_id',ipaddress = '$ipaddress', isdispatch='$isdispatch', paytype='$paytype' where bid_id = $bid_id"; 
			mysqli_query($connection,$sql_update);
			
			echo "<script>location='$pagename?action=2'</script>";
	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHIVALI LOGISTICS</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="select/select2.min.css">
     <style>
        .btn {
            width: 100%;
        }

        input[type=search]:not(.browser-default){
            height: 2rem;
        }
        .select2-container .select2-selection--single {
            height: 32px;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #080c2f;
            color: white;
        }
    </style>
</head>




    <body>
    <!-- Topmenu -->
    <?php include('include/header.php'); ?>
    <!-- Topmenu Close -->
    <?php include('include/leftmenu.php'); ?>
    <div class="container">
        <div class="row">

                     
                           
                <div class="col s12">
        
                <ul class="collection">
                <?php
									$slno=1;
							
									 $sel = "select * from bidding_entry where  isdispatch=1 &&  adv_date='$curr_date'&& compid='$compid'order by bid_id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									   $paydone=$row['is_complete'];
										$truckid = $row['truckid'];	
										$itemid = $row['itemid'];	
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
								
									?>

                        <li class="collection-item avatar" >
                          <img src="images/sale.png" alt="" class="circle">
                      
                        <span class="title"><strong> LR No<?php echo ucfirst($row['lr_no']);?></strong></span><br>
                       
                        <span class="title"><strong>Bilty No<?php echo ucfirst($row['bilty_no']);?></strong></span><br>
                       
                        <span class="title"><?php echo date('d-m-Y',strtotime($row['tokendate']));?>
                         <br>
                         <?php if($truckno!=''){?><i class="material-icons tiny">location_on <?php }?></i>
                        <span class="title"><strong><?php echo $truckno;?></strong></span><br>
                        <?php if($placename!=''){?><i class="material-icons tiny">person <?php }?></i>
                        <span class="title"><strong><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></strong></span><br>
                     
                         <?php if($row['itemname']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $itemname;?> </strong></span><br>
                        <?php if($row['mobile1']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo ucfirst($row['totalweight']);?></strong></span>
                      
                    </li>

                           <?php }?>
                    
               
                     </ul>
            </div>
        
   
                                   
                            



                        </tbody>
                    </table>
 
            </div>
        </div>
    </div>
    <?php include('include/footer.php');
    ?>

        <!-- footer navigation -->
        <?php //include('include/footer.php'); 
        ?>
        <!-- script -->
        <script src="js/jquery-3.6.2.min.js"></script>
        <script src="materialize/js/materialize.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.sidenav').sidenav();
            });
        </script>
</body>

</html>