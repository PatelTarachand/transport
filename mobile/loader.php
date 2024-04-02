<?php
error_reporting(0);
include("config.php");
include("lib/dboperation.php");
include("lib/getval.php");
$cmn = new Comman();
$pagename = "loader.php";
$title = "Loader List";
$paydate = date('Y-m-d');

if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = addslashes(trim($_GET['fromdate']));
    $todate = addslashes(trim($_GET['todate']));
} else {
    $fromdate = date('Y-m-d');
    $todate = date('Y-m-d');
}

if (isset($_GET['suppartyid'])) {
    $suppartyid = trim(addslashes($_GET['suppartyid']));
} else
    $suppartyid = '';


$crit = " ";
if($fromdate!="" && $todate!="")
{
	$fromdate = $fromdate;
	$todate = $todate;
	$crit .= " and  A.loaddate between '$fromdate' and '$todate'";
}



if($suppartyid !='') {
	$crit .= " and B.suppartyid='$suppartyid' ";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIJAK</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="select/select2.min.css">
    <style>
        .active .collapsible-header {
            background-color: #d1ffd4;
        }

        .collapsible-header {
            font-weight: 600;
            font-size: 15px;
        }

        body {
            background: aliceblue;
        }

        .collapsible.popout>li {
            margin: 0 10px;
        }

        input[type=search]:not(.browser-default) {
            height: 2rem;
        }

        .select2-container .select2-selection--single {
            height: 32px;
        }

        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #080c2f;
            color: white;
        }
         .btn {
            width: 100%;
        }
    </style>
</head>

<body>
    <!-- Topmenu -->
    <?php include('include/header.php'); ?>
    <!-- Topmenu Close -->
    <!-- Sidemenu -->
    <?php include('include/leftmenu.php'); ?>
    <!-- Sidemenu close -->
    <div class="container">
    <div class="row">
                  <div class="col s12 offset-m3 m6">
                   <blockquote>
                    <h6><strong>Loader List</strong></h6>
                </blockquote>
    
                 <form action="" method="get">
                        <table class="table table-bordered">
                <div class="row" style="margin-bottom: 0px;">
                    <div class="input-field col s6">
                        <input id="fromdate" name="fromdate" type="date" value="<?php echo $fromdate;?>" class="validate">
                        <label for="fromdate">Frome Date</label>
                    </div>
                    <div class="input-field col s6">
                        <input  id="todate" name="todate" value="<?php echo $todate;?>" type="date" class="validate">
                        <label for="mobileno">To Date</label>
                    </div>
                    <div class="input-field col s12">
                   
                    <select  name="suppartyid" id="suppartyid"  class="chzn-select" style="width:200px;">
                           <option value="">--All--</option>	

                 <?php
                 $sql = mysqli_query($connection,"select * from m_supplier_party where is_loader='1' && enable=0 order by supparty_name");
                   while($row = mysqli_fetch_array($sql))
                      {  ?>
   
                      <option value="<?php echo $row['suppartyid']; ?>"><?php echo $row['supparty_name']; ?></option>

                  <?php } ?>

                    <script>
                          document.getElementById('suppartyid').value = '<?php echo $suppartyid; ?>';
                      </script>
                   </select>
                        
                    </div>
                    
                    <div class="input-field col s6">
                        <button type="submit" class="btn indigo darken-4" >Search</button>
                    </div>
                    <div class="input-field col s6">
                        <a href="loader.php" class="btn success" style="padding: 0;">Reset</a>
                    </div>
                   
                </div>
              
        
                     
                 </form>
                 <tbody>
                           
                           
                           <div class="container">
        <div class="row">
            <div class="col s12 offset-m3 m6">
                <blockquote>
                    <h6>Loader List</h6>
                </blockquote>
                <ul class="collection">
                <?php 	
					$sn=1;
					$netamount=0;
					$netsaleamt=0;
					$netbalamt=0;
					
                 
						$sql = mysqli_query($connection,"select A.* from loading as A left join m_supplier_party as B on A.suppartyid = B.suppartyid where 1=1 $crit  order by lodingid"); 
						while($row=mysqli_fetch_assoc($sql))
						{	
							$lodingid = $row['lodingid'];
							$netsale = $row['netsale'];
								$amount= $cmn->getvalfield($connection,"loading","motorbhada","lodingid='$lodingid'") + $cmn->getvalfield($connection,"loaderentry","sum((qty * weight * rate) + (qty * unitrate))","lodingid='$lodingid'");
								$balamount =  $netsale - $amount;
								
								$netamount += $amount;
								$netsaleamt += $netsale;
								$netbalamt += $balamount;
					 ?>
                    <li class="collection-item avatar" style="padding-left:25px">
                        
                      
                        <span class="title"><strong><?php echo $row['biltyno']; ?></td>	</strong></span>
                    <p><i class="material-icons tiny">money  &nbsp; &nbsp; </i> <?php echo $cmn->getvalfield($connection,"m_supplier_party","supparty_name","suppartyid='$row[suppartyid]'"); ?> <br>
                            <i class="material-icons tiny">date_range  &nbsp; &nbsp; </i><?php echo $cmn->dateformatindia($row['loaddate']); ?>
                        </p>

                               <i class="material-icons tiny">payment &nbsp; &nbsp; </i>Bill Amount &nbsp; <?php echo number_format($amount,2); ?><br>
                               <i class="material-icons tiny">money &nbsp; &nbsp; </i>Net Amount &nbsp;  <?php echo number_format($netsale,2); ?><br>
                               <i class="material-icons tiny">payment &nbsp; &nbsp; </i>Profit/Loss  <?php echo number_format($balamount,2); ?><br>
                        </p>
                       
                    </li>
 <?php } ?>
                     </ul>
            </div>
        
   
                                   
                            



                        </tbody>
                    </table>
 
            </div>
        </div>
    </div>
              
                 
       

        <!-- script -->
        <script src="js/jquery-3.6.2.min.js"></script>
        <script src="materialize/js/materialize.min.js"></script>
        <script src="select/select2.min.js"></script>
        <script>
             $(document).ready(function() {
            // $('select').formSelect();
            $('select').select2({
                width: '100%'
            });
        });
            $(document).ready(function() {
                $('.sidenav').sidenav();
            });
            // search
            $(document).ready(function() {
                $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".collapsible li ").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
            $(document).ready(function() {
                $('.collapsible').collapsible();
            });
            // function geturl(suppartyid){
            //     location='loder_list_details.php?suppartyid='+suppartyid;
            // }
        </script>
</body>

</html>