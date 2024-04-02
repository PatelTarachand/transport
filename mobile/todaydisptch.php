<?php error_reporting(0);
include("adminsession.php");
$pagename = "todaydisptch.php";
include("lib/dboperation.php");
include_once("lib/getval.php");
$currentdate = date('Y-m-d');
$crit = " ";

if (isset($_GET['search'])) {
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
} else {
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d', strtotime('-3 month', strtotime($todate)));
}



if ($fromdate != '' && $todate != '') {
	$crit .= " and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$fromdate' and '$todate' ";
}

if ($_GET['consignorid'] != '') {
	$consignorid = $_GET['consignorid'];
	$crit .= " and consignorid = '$consignorid' ";
}
$consignorid = '';



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
								$slno = 1;
								if ($usertype == 'admin') {
									$cond = "where 1=1 ";
								} else {
									//$cond="where createdby='$userid' ";
									$cond = "where 1=1 ";
								}


								$sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond && sessionid='$sessionid' && is_bilty=1 $crit  and bilty_date ='$currentdate' and compid='$compid' order by bid_id desc";
								$res = mysqli_query($connection, $sel);
								while ($row = mysqli_fetch_array($res)) {
									$gr_date = $row['gr_date'];
									$truckid = $row['truckid'];
									$itemid = $row['itemid'];
									$consigneeid = $row['consigneeid'];
									$destinationid = $row['destinationid'];
									$supplier_id = $row['supplier_id'];
									$brand_id = $row['brand_id'];
									$truckid = $row['truckid'];
									$ownerid = $cmn->getvalfield($connection, "m_truck", "ownerid", "truckid='$truckid'");
									$ownername = $cmn->getvalfield($connection, "m_truckowner", "ownername", "ownerid='$ownerid'");
									$s = $row['bilty_date'];
									$dt = new DateTime($s);
									$date = $dt->format('d-m-Y');
									$time = $dt->format('H:i:s');
									$advance = $row['adv_cash'] + $row['adv_cheque'];
									$adv_other = $row['adv_other'];
									$adv_consignor = $row['adv_consignor'];
									$consignorname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid = '$row[consignorid]'");
								?>

                        <li class="collection-item avatar" >
                          <img src="images/sale.png" alt="" class="circle">
                      
                        <span class="title"><strong> Bilty No - <?php echo $row['bilty_no']; ?></strong></span><br>
                       
                        <span class="title"><strong> Date -<?php echo $row['tokendate']; ?></strong></span><br>
                       
                        <span class="title"><strong>Invoice No.- </i><?php echo $row['invoiceno']; ?>
                         <br>
                         <?php if($row['inv_date']!=''){?><i class="material-icons tiny">location_on <?php }?></i>
                        <span class="title"><strong><?php echo $cmn->dateformatindia($row['inv_date']); ?><br>
                        <?php if($row['ewayno']!=''){?><i class="material-icons tiny">person <?php }?></i>
                        <span class="title"><strong><?php echo $row['ewayno']; ?></strong></span><br>
                     
                         <?php if($row['di_no']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $row['di_no']; ?></strong></span><br>
                        <?php if($row['lr_no']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $row['lr_no']; ?></strong></span><br>
                        <?php if($consignorname !=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $consignorname; ?></strong></span><br>
                        <?php if($consigneename !=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$consigneeid'"); ?></strong></span><br>
                        <?php if($placename!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $cmn->getvalfield($connection, "m_place", "placename", "placeid='$destinationid'"); ?></strong></span>
                      
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