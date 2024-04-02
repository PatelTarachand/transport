<?php
include("config.php");
include("lib/dboperation.php");
include("lib/getval.php");
$cmn = new Comman();
$pagename = "supplier.php";
$title = "Supplier List";
$btn_name = "Search";


if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = addslashes(trim($_GET['fromdate']));
    $todate = addslashes(trim($_GET['todate']));
} else {
    $fromdate = date('Y-m-d');
    $todate = date('Y-m-d');
}




$crit = " ";
if ($fromdate != "" && $todate != "") {
    $fromdate = $fromdate;
    $todate = $todate;
    $crit .= " and  prevbal_date between '$fromdate' and '$todate'";
}



if (isset($_GET['productid'])) {
    $productid = trim(addslashes($_GET['suppartyid']));

    if ($suppartyid != '') {
        $crit .= " and suppartyid='$suppartyid' ";
    }
} else {
    $suppartyid = '';
}


if (isset($_GET['suppartyid'])) {
    $suppartyid = trim(addslashes($_GET['suppartyid']));
    if ($suppartyid != '') {
        $crit .= " and suppartyid='$suppartyid' ";
    }
} else {
    $suppartyid = '';
}
$date = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
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
                    <h6><strong>Supplier List</strong></h6>
                </blockquote>


                <form action="" method="get">
                    <table class="table table-bordered">
                        <div class="row" style="margin-bottom: 0px;">
                            <div class="input-field col s6">
                                <input id="fromdate" name="fromdate" type="date" value="<?php echo $fromdate; ?>" class="validate">
                                <label for="fromdate">From Date</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="todate" name="todate" type="date" value="<?php echo $todate; ?>" class="validate">
                                <label for="todate">To Date</label>
                            </div>

                            <div class="col s12" style="margin-top: 40px;">

                                <select name="suppartyid" id="suppartyid" class="chzn-select" style="width:200px;">
                                    <option value="">Select</option>

                                    <?php

                                    $sql = mysqli_query($connection, "Select * from m_supplier_party where (is_supp='1') and suppartyid <> 0  order by supparty_name ");
                                    while ($row = mysqli_fetch_assoc($sql)) {  ?>

                                        <option value="<?php echo $row['suppartyid']; ?>"><?php echo $row['supparty_name']; ?></option>

                                    <?php } ?>
                                    <script>
                                        document.getElementById('suppartyid').value = '<?php echo $suppartyid; ?>';
                                    </script>
                                </select>
                            </div>
                            <div class="input-field col s6">
                                <button type="submit" onClick="return checkinputmaster('fromdate');" class="btn indigo darken-4">Search</button>
                            </div>
                            <div class="input-field col s6">
                                <a href="supplier.php" class="btn success" style="padding: 0;">Reset</a>
                            </div>

                        </div>



                </form>


                <tbody>
                    </span>

                    <div class="container">
                        <div class="row">
                            <div class="col s12 offset-m3 m6">
                                <blockquote>
                                    <h6>Supplier List</h6>
                                </blockquote>
                                <ul class="collection">

                                    <?php

                                    $customerroaker = $cmn->getcustomerroaker2all($connection, $suppartyid, $fromdate, $todate);
                                    $openingbal = $cmn->getopeningbalcust($connection, $suppartyid, $date);

                                    if ($openingbal < 0) {
                                        $str = "Cr.";
                                    } else {
                                        $str = "Dr.";
                                    } ?>
                                    <span class="title" style="color: blue;"><strong> Opening balance &nbsp; <?php echo number_format($openingbal, 2) . " $str"; ?> </strong></span><br>


                                    <?php
                                    $slno = 1;

                                    $netbal = $openingbal;

                                    foreach ($customerroaker as $cust) {

                                        $unixTimestamp = strtotime($cust[0]);
                                        $dayOfWeek = date("D", $unixTimestamp);
                                        $dr = $cust[1];
                                        $cr = $cust[2];
                                        if ($dr == '') {
                                            $dr = 0;
                                        }
                                        if ($cr == '') {
                                            $cr = 0;
                                        }
                                        $netbal += $dr - $cr;
                                        $narration = '';
                                        $id = $cust[5];
                                        if ($netbal < 0) {
                                            $str = "Cr.";
                                        } else {
                                            $str = "Dr.";
                                        }

                                        if (strpos($cust[4], 'Sale') !== false) {
                                            $link1 = " target='_blank' href='salereport2.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
                                        } else if (strpos($cust[4], 'Payment') !== false) {
                                            $link1 = " target='_blank' href='supplier_payment_report.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
                                            $narration = $cmn->getvalfield($connection, "payment", "narration", "paymentid='$id'");
                                        } else if (strpos($cust[4], 'Loading') !== false) {
                                            $link1 = " target='_blank' href='loadingreport.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
                                        } else
                                            $link1 = '';



                                        if (strpos($cust[4], 'Receipt') !== false) {
                                            $link2 = " target='_blank' href='customer_payment_report.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
                                            $narration = $cmn->getvalfield($connection, "payment", "narration", "paymentid='$id'");
                                        } else if (strpos($cust[4], 'Bijak') !== false) {
                                            $link2 = " target='_blank' href='purchasereport.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
                                        } else
                                            $link2 = '';

                                        if ($netbal < 0) {
                                            $str = "Cr.";
                                        } else {
                                            $str = "Dr.";
                                        }

                                    ?>
                                        <li class="collection-item avatar" style="padding-left:10px">


                                            <span class="title"><strong><?php echo $cmn->dateformatindia($cust[0]) . ' (' . $dayOfWeek . ')'; ?> </strong></span>
                                            <p><i class="material-icons tiny">money &nbsp; &nbsp; </i><?php echo $cust[4]; ?> <br>
                                                <?php if ($narration != '') { ?><i class="material-icons tiny">date_range &nbsp; &nbsp; <?php } ?> </i> <?php echo $narration; ?>
                                            </p>

                                            <?php if ($cust[1] != '') { ?><i class="material-icons tiny">payment &nbsp; &nbsp; </i>Debit &nbsp;<?php } ?> <?php if ($cust[1] != '') {
                                                                                                                        echo number_format($cust[1], 2);
                                                                                                                    } ?>
                                            <?php if ($cust[2] != '') { ?> <i class="material-icons tiny">money &nbsp; &nbsp; </i>Credit &nbsp; <?php } ?><?php if ($cust[2] != '') {
                                                                                                                    echo number_format($cust[2], 2);
                                                                                                                } ?>
                                            <i class="material-icons tiny">payment &nbsp; &nbsp; </i>Balance &nbsp; <?php echo number_format($netbal, 2) . ' ' . $str; ?><br>
                                            </p><br>


                                        </li>
                                    <?php }



                                    ?>
                                    <?php


                                    //$netbal = $openingbal + $cust[3];

                                    if ($netbal < 0) {
                                        $str = "Cr.";
                                    } else {
                                        $str = "Dr.";
                                    }
                                    ?>
                                    <span class="title" style="color: blue;"><strong> Net balance &nbsp; <?php echo number_format($netbal, 2) . ' ' . $str; ?> </strong></span><br>
                                </ul>
                            </div>

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

        function geturl(suppartyid) {
            location = 'supplier_list_details.php?suppartyid=' + suppartyid;
        }
    </script>
</body>

</html>