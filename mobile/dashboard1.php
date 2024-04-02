<?php
include("adminsession.php");
$pagename = "dashboard.php";
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
        .collection .collection-item.avatar {
            min-height: 60px;
            padding-left: 72px;
            position: relative;
        }

        body {
            background: aliceblue;
        }

        .collection-item span.badge {
            margin-top: 8px !important;
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
            <div class="col s12 ">
                <blockquote>
                    <h5><strong>Dashboard</strong></h5>
                    <p>Total number of customer <b>25</b></p>
                </blockquote>
                <br>

                <div class="collection z-depth-1">
                    <a href="customer-list.php" class="collection-item avatar black-text">
                        <img src="images/user-list.png" alt="" class="circle">
                        <span class="title"><strong>Customer List</strong></span>
                        <p>View customer list
                        </p>
                        <span class="secondary-content"><i class="material-icons green-text darken-3">send</i></span>
                    </a>
                </div>
                <div class="collection z-depth-1">
                    <a href="#" class="collection-item avatar black-text">
                        <img src="images/password.png" alt="Login OTP" class="circle">
                        <span class="title"><strong>Login OTP</strong>
                            <span class="badge red white-text badge" style="margin-right: 60px;font-size: 1.2rem;">4355</span>
                        </span>
                        <p>View OTP No.
                        </p>
                        <span class="secondary-content"><i class="material-icons green-text darken-3">send</i></span>
                    </a>
                </div>
                <br>
                <center><a href="dashboard.php" class="btn green darken-3"><i class="material-icons left">cached</i> Refresh</a></center>
            </div>
        </div>
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