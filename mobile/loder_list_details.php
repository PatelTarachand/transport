<?php
error_reporting(0);
include("config.php");
include("lib/dboperation.php");
include("lib/getval.php");
$cmn = new Comman();
$pagename = "loder.php";
$title = "Loder List";
$suppartyid = $_GET['suppartyid'];
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
            <div class="col s12">

                <ul class="collapsible popout">
                <?php
	$nettoral=0;	
	$sql_get = mysqli_query($connection,"Select * from m_supplier_party where (is_loader='1') and suppartyid <> 0 and suppartyid='$suppartyid' order by supparty_name ");
	while($row_get = mysqli_fetch_assoc($sql_get))
	{                                   
	$suppartyid = $row_get['suppartyid'];
	$balamt = $cmn->getopeningbalcust($connection,$row_get['suppartyid'],date('Y-m-d'));
	$givendate = date('Y-m-d');
	if($suppartyid !='') {
	$msg='';
	$total=0;
	$sql = mysqli_query($connection,"select unitid,unit_name from m_unit where isstockable=1");
	while($row=mysqli_fetch_assoc($sql)) {
			$unitid = $row['unitid'];
			$unit_name = strtoupper($row['unit_name']);	
			$balqty =$cmn->getcarretopenbydate($connection,$suppartyid,$unitid,$givendate);			
			$total += $balqty;
	}

 } 
 	
 					
						?>
                    <li>
                       
                        <div class="body white">
                            <table>
                            <tr>
                            <th>Customer</th>
                            <td><?php echo $row_get['supparty_name'];?></td>
                            </tr>
                            <tr>
                            <th>Carret Bal</th>                                
                            <td><?php echo $total;?></td>
                            </tr>
                            <tr>
                            <th>Amount Bal</th>
                            <td><?php echo $balamt;?></td>                                
                            
                            </tr>
                            </table>
                        </div>
                    </li>
                    <?php } ?>
                    
                </ul>
            </div>
        </div>
</div>
        <!-- script -->
        <script src="js/jquery-3.6.2.min.js"></script>
        <script src="materialize/js/materialize.min.js"></script>
        <script>
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
        </script>
</body>

</html>