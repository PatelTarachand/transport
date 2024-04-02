<?php error_reporting(0);
include("adminsession.php");
$pagename = "biltypendingreport.php";
include("lib/dboperation.php");
include_once("lib/getval.php");

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$cond=' ';
  

if(isset($_GET['start_date']))
{
	$start_date = $cmn->dateformatusa(trim(addslashes($_GET['start_date'])));	
}
else
$start_date = date('Y-m-d');

if(isset($_GET['end_date']))
{
	$end_date = $cmn->dateformatusa(trim(addslashes($_GET['end_date'])));	
}
else
$end_date = date('Y-m-d');

if(isset($_GET['di_no']))
{
	$di_no = trim(addslashes($_GET['di_no']));	
}
else
$di_no = '';

if($di_no !='') {
	
	$cond .=" and lr_no='$di_no'";
	
	}
	
if($start_date !='' && $end_date !='')
{
		$cond .=" and DATE_FORMAT(tokendate,'%Y-%m-%d') between '$start_date' and '$end_date' ";
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
						$sn=1;
						//echo "select * from bidding_entry where 1=1 && is_bilty=1 $cond"; 
						
						$sql = mysqli_query($connection,"select * from bidding_entry where 1=1 && is_bilty=1 and compid='$compid' and isreceive=0 ");
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['placeid'];
						$bid_id = $row['bid_id'];
						$recweight = $row['recweight'];
						
						if($recweight==0) { $recweight= $row['totalweight']; }
						
						$destaddress = $row['destaddress'];
						$recdate = $cmn->dateformatindia($row['recdate']);
						$sortagr = $row['sortagr'];	
						$truckid = $row['truckid'];
						$noofqty = $row['noofqty'];						
						$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
						$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
						$recbag = $row['recbag'];
						
						if($recdate !='') {
						$sortagbag = $noofqty - $row['recbag'];
						}
						else
						$sortagbag='';	 
						
						$fpay = $row['fpay'];
						
						?>

                        <li class="collection-item avatar" >
                          <img src="images/sale.png" alt="" class="circle">
                      
                        <span class="title"><strong> LR No - <?php echo $row['lr_no']; ?></strong></span><br>
                       
                        <span class="title"><strong>Truck No - <?php echo $truckno; ?></strong></span><br>
                       
                        <span class="title"><strong> Date - </i><?php echo $date; ?>
                         <br>
                         <?php if($row['totalweight']!=''){?><i class="material-icons tiny">location_on <?php }?></i>
                        <span class="title"><strong><?php echo $row['totalweight']; ?></strong></span><br>
                      
                      
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