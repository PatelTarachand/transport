<?php error_reporting(0);
include("adminsession.php");
$pagename = "todaybilty.php";
include("lib/dboperation.php");
include_once("lib/getval.php");
$currentdate = date('Y-m-d');

if(isset($_GET['consignorid']))
{
	$consignorid= trim(addslashes($_GET['consignorid']));
	$placeid = $cmn->getvalfield($connection,"m_consignor","placeid","consignorid='$consignorid'");
}
else {
$consignorid='';
$placeid = '';
}



if(isset($_GET['bid_id']))
{
		$bid_id = trim(addslashes($_GET['bid_id']));	
		$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
		$row=mysqli_fetch_assoc($sql);
		$consignorid = $row['consignorid'];
		$order_no = $row['order_no'];
		$di_no = $row['di_no'];
		$tokendate = date('d-m-Y',strtotime($row['tokendate']));
		$inv_date = $cmn->dateformatindia($row['inv_date']);
		$invoiceno = $row['invoiceno'];
		if($invoiceno=='') { $invoiceno = $cmn->getvalfield($connection,"m_session","inv_prefix","sessionid='$sessionid'"); }
		$bilty_no = $row['bilty_no'];
		$gr_no = $row['gr_no'];
		$consigneeid = $row['consigneeid']; 
		$placeid = $row['placeid'];
		$destinationid = $row['destinationid'];
		$truckid = $row['truckid'];
		$driver =$row['driver']; 
		$itemid = $row['itemid'];
		$discount = $row['discount'];
		$brand_id = $row['brand_id'];
		$totalweight = $row['totalweight'];
		$noofqty = $row['noofqty'];
		$biltyremark = $row['biltyremark'];
		$ewayno =$row['ewayno']; 
		$drivermobile = $row['drivermobile'];
			$packingqty = $row['packingqty'];
				$pid = $row['pid'];
		$own_rate = $row['own_rate'];
		$lr_no = $row['lr_no'];
		$comp_rate = $row['comp_rate'];
		$freightamt = $row['comp_rate']*$row['totalweight'];
		$totalamt = $own_rate * $totalweight;
		$netamount = $totalamt - $discount;

}
else
{	
		$bid_id =0;
		$order_no = '';
		$lr_no='';
		$di_no = '';
		$order_no = '';
		$tokendate = '';
		$invoiceno = '';
		$bilty_no = '';
		$ownername='';
		$inv_date = '';
		$gr_no = '';
		$consigneeid = '';
		$lrno='';
		$ewayno='';
		$destinationid = '';
		$truckid = '';
		$driver = '';
		$deliverat = '';
		$itemid = '';
		$brand_id = '6';
		$totalweight = '';
		$noofqty = '';
		$comp_rate = '';
		$own_rate = '';
		$freightamt = '';
		$biltyremark = '';
		$placeid=431;
		$drivermobile='';
		$own_rate='';
		$comp_rate = '';
		
		$duplicate= "";
		$packingqty = "";
				$pid = "";
		$inv_date=$cmn->dateformatindia(date('Y-m-d'));
		$tokendate=$cmn->dateformatindia(date('Y-m-d'));
}




if(isset($_POST['sub'])) {

   	$bid_id = trim(addslashes($_POST['bid_id']));
	$di_no = trim(addslashes($_POST['di_no']));
	$consignorid = trim(addslashes($_POST['consignorid']));
	$placeid = trim(addslashes($_POST['placeid']));
	$destinationid = trim(addslashes($_POST['destinationid']));
	$itemid = trim(addslashes($_POST['itemid']));
	$comp_rate = trim(addslashes($_POST['comp_rate']));
	$own_rate = trim(addslashes($_POST['own_rate']));
	$totalweight = trim(addslashes($_POST['totalweight'])); 
		$noofqty = trim(addslashes($_POST['noofqty'])); 
   // $noofqty = $totalweight * 20; 	
	//$remark = trim(addslashes($_POST['remark']));
	$brand_id= trim(addslashes($_POST['brand_id']));
	$newdate = date('Y-m-d H:i:s');
	//$order_type= trim(addslashes($_POST['order_type']));
	$order_no= trim(addslashes($_POST['order_no']));
	$consigneeid = trim(addslashes($_POST['consigneeid'])); 
    $inv_date = $cmn->dateformatusa($_POST['inv_date']);
    $tokendate = $cmn->dateformatusa($_POST['tokendate']);
    $invoiceno = $_POST['invoiceno'];
    $lr_no = $_POST['lr_no'];
    $truckid = $_POST['truckid'];
    $driver =$_POST['driver']; 
    $itemid = $_POST['itemid'];
    $biltyremark = $_POST['biltyremark'];
    $ewayno = $_POST['ewayno'];
    $drivermobile = $_POST['drivermobile'];
   	$is_bilty = 1;
	 $freightamt = $_POST['freightamt'];
	 $Discount = $_POST['discount'];
	 $bilty_no = $_POST['bilty_no'];
	 
	 	$packingqty = $_POST['packingqty'];
				$pid = $_POST['pid'];



    	
    		
        if($bid_id==0) {
       
	$sql_chk = "select * from bidding_entry where lr_no='$lr_no'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
        $sql_update = "insert into bidding_entry set bilty_date = '$tokendate',packingqty='$packingqty',pid='$pid',tokendate='$tokendate', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid'"; 
        
		//echo $sql_update;die;
            mysqli_query($connection,$sql_update);
            echo "<script>location='bilty_entry_emami.php?action=1';</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
            }
            
        
            else
            {
           
        		$sql_chk = "select * from bidding_entry where lr_no='$lr_no'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
	//	if($cnt!=0 && $_GET['edit']=='true')
	//	{	
//	echo "update  bidding_entry set bilty_date = '$tokendate',tokendate='$tokendate', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid' where bid_id='$bid_id'";die;
                $sql_update = "update  bidding_entry set bilty_date = '$tokendate',tokendate='$tokendate',packingqty='$packingqty',pid='$pid', consignorid ='$consignorid',placeid='$placeid', consigneeid='$consigneeid',destinationid = '$destinationid', itemid='$itemid',comp_rate='$comp_rate',own_rate='$own_rate',totalweight='$totalweight',brand_id='$brand_id',noofqty='$noofqty',drivermobile='$drivermobile', order_no='$order_no',inv_date='$inv_date', gr_no='$gr_no',lr_no='$lr_no',truckid='$truckid',driver='$driver', biltyremark='$biltyremark',is_bilty='$is_bilty',invoiceno='$invoiceno', ewayno='$ewayno',freightamt='$freightamt',bilty_no='$bilty_no',createdate='$createdate', ipaddress = '$ipaddress',sessionid = '$sessionid',compid = '$compid',createdby='$userid' where bid_id='$bid_id'"; 	 
         
             mysqli_query($connection,$sql_update);
              echo "<script>location='bilty_entry_emami.php?bid_id=$bid_id&action=2';</script>";
	//	}   

	//else
	//	$duplicate ="* Duplicate entry .... Data can not be saved!";
          
            
            }
        
        
    }
    
    $increasebiltyno =    $cmn->getcode($connection,"bidding_entry","bilty_no","compid = '$_SESSION[compid]' && sessionid='$sessionid'");

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
									
									if($usertype=='admin')
									{   $payUser=1;
										$cond="where compid='$_SESSION[compid]' ";	
									}
									else
									{
									    $payUser=0;
										//$cond="where createdby='$userid' ";	
										$cond="where compid='$_SESSION[compid]' ";											
									}
									 $sel = "select *,DATE_FORMAT(tokendate,'%d-%m-%Y') as tokendate  from bidding_entry $cond  && is_bilty=1  and compid='$compid' and bilty_date ='$currentdate' order by bid_id desc limit 0,100";
							      $res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									    $paydone=$row['is_complete'];
									    	$truckid = $row['truckid'];	
									    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										  $consignorname = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'");

									?>

                        <li class="collection-item avatar" >
                          <img src="images/sale.png" alt="" class="circle">
                      
                        <span class="title"><strong> LR No - <?php echo ucfirst($row['lr_no']);?></strong></span><br>
                       
                        <span class="title"><strong>Bilty No -<?php echo ucfirst($row['bilty_no']);?></strong></span><br>
                       
                        <span class="title"><strong>Bilty Date - </i><?php echo  $row['tokendate'];?>
                         <br>
                         <?php if($consignorname!=''){?><i class="material-icons tiny">location_on <?php }?></i>
                        <span class="title"><strong><?php echo  $consignorname;?></strong></span><br>
                        <?php if($consigneename!=''){?><i class="material-icons tiny">person <?php }?></i>
                        <span class="title"><strong><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></strong></span><br>
                     
                         <?php if($row['payment_type']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo $truckno;?></strong></span><br>
                        <?php if($row['mobile1']!=''){?><i class="material-icons tiny">money <?php }?></i>
                        <span class="title"><strong><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></strong></span>
                      
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