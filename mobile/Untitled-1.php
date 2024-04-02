<?php error_reporting(0);
include("../adminsession.php");
$pagename = "customer_roker_book.php";
$module = "Customer Ledger";
$submodule = "Customer Ledger";
$btn_name = "Search";
$keyvalue = 0;
$tblname = "purchaseentry";
$tblpkey = "purchaseid";
if (isset($_GET['purchaseid']))
	$keyvalue = $_GET['purchaseid'];
else
	$keyvalue = 0;
if (isset($_GET['action']))
	$action = $_GET['action'];
$search_sql = "";

if ($_GET['fromdate'] != "" && $_GET['todate'] != "") {
	$fromdate = addslashes(trim($_GET['fromdate']));
	$todate = addslashes(trim($_GET['todate']));
} else {
	$fromdate = date("d-m-Y", strtotime("-1 months"));
	$todate = date('d-m-Y');
}


$crit = " where 1 = 1 ";
if ($fromdate != "" && $todate != "") {
	$fromdate = $cmn->dateformatusa($fromdate);
	$todate = $cmn->dateformatusa($todate);
	$crit .= " and  purchasedate between '$fromdate' and '$todate'";
}

if (isset($_GET['productid'])) {
	$productid = trim(addslashes($_GET['productid']));

	if ($productid != '') {
		$crit .= " and productid='$productid' ";
	}
} else {
	$productid = '';
}


if (isset($_GET['suppartyid'])) {
	$suppartyid = trim(addslashes($_GET['suppartyid']));
	if ($suppartyid != '') {
		$crit .= " and suppartyid='$suppartyid' ";
	}
} else {
	$suppartyid = '';
}

//echo $fromdate;
// echo  $suppartyid . " " . $fromdate . " ";
// $openingbal = $cmn->getopeningbalcust($connection, $suppartyid, $fromdate);


?>
<!DOCTYPE html>

<head>
    <title>Customer Ledger</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("inc/top_files.php"); ?>
</head>

<body class="noselect">

    <div class="mainwrapper">

        <!-- START OF LEFT PANEL -->
        <?php include("inc/left_menu.php"); ?>

        <!--mainleft-->
        <!-- END OF LEFT PANEL -->

        <!-- START OF RIGHT PANEL -->

        <div class="rightpanel">
            <?php include("inc/header.php"); ?>

            <div class="maincontent">
                <div class="contentinner">
                    <?php include("../include/alerts.php"); ?>
                    <!--widgetcontent-->
                    <div class="widgetcontent  shadowed nopadding">
                        <form class="stdform stdform2" method="get" action="">

                            <table id="mytable01" align="center" class="table table-bordered table-condensed"
                                width="100%">
                                <tr>
                                    <th width="50%">Customer Name </th>
                                    <th width="10%">From Date</th>
                                    <th width="10%">To Date </th>


                                    <th width="30%">Action</th>
                                </tr>
                                <tr>

                                    <td> <select name="suppartyid" id="suppartyid" class="chzn-select"
                                            style="width:100%;">
                                            <option value="">--Select--</option>
                                            <?php
											$sql = mysqli_query($connection, "select suppartyid,supparty_name from m_supplier_party where (is_cust='1' || is_loader=1) && enable=0 order by supparty_name");
											while ($row = mysqli_fetch_assoc($sql)) {
											?>
                                            <option value="<?php echo $row['suppartyid'];  ?>">
                                                <?php echo $row['supparty_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <script>
                                        document.getElementById('suppartyid').value = '<?php echo $suppartyid; ?>';
                                        </script>
                                    </td>

                                    <td><input type="text" name="fromdate" id="fromdate" class="form-control"
                                            placeholder='dd-mm-yyyy'
                                            value="<?php echo $cmn->dateformatindia($fromdate); ?>"
                                            data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>


                                    <td><input type="text" name="todate" id="todate" class="form-control"
                                            placeholder='dd-mm-yyyy'
                                            value="<?php echo $cmn->dateformatindia($todate); ?>"
                                            data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>






                                    <td>&nbsp; <button type="submit" name="search" class="btn btn-primary"
                                            onClick="return checkinputmaster('fromdate');"> Search
                                        </button>&nbsp; <a href="<?php echo $pagename; ?>" name="reset" id="reset"
                                            class="btn btn-success">Reset</a></td>

                                </tr>
                            </table>


                        </form>
                    </div>

                    <!--widgetcontent-->
                    <?php if ($suppartyid != '') { ?>

                    <p align="right">

                        <a href="print_customer_detail_roker_book_hindi_a4.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&suppartyid=<?php echo $suppartyid; ?>"
                            class="btn btn-warning" target="_blank">Detail A4</a>



                        <a href="print_customer_roker_book.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&suppartyid=<?php echo $suppartyid; ?>"
                            class="btn btn-primary" target="_blank">A4</a>


                        <!-- <a href="print_customer_roker_book_a5.php?fromdate=<?php echo $cmn->dateformatusa($fromdate); ?>&todate=<?php echo $cmn->dateformatusa($todate); ?>&suppartyid=<?php echo $suppartyid; ?>" class="btn btn-primary" target="_blank" >A5</a>-->

                        <a href="print_customer_roker_book_hindi_a4.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&suppartyid=<?php echo $suppartyid; ?>"
                            class="btn btn-warning" target="_blank">A4</a>
                        <!--<a href="print_customer_roker_book_hindi_a5.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&suppartyid=<?php echo $suppartyid; ?>" class="btn btn-warning" target="_blank" >A5</a>-->
                    </p>
                    <!--widgetcontent-->
                    <h4 class="widgettitle"><?php echo $submodule; ?> List</h4>
                    <?php
						$customerroaker = $cmn->getcustomerroaker2all($connection, $suppartyid, $fromdate, $todate);



						$openfromdate = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));
						$openingbal = $cmn->getopeningbalcust($connection, $suppartyid, $openfromdate);


						if ($openingbal < 0) {
							$str = "Cr.";
						} else {
							$str = "Dr.";
						}
						?>
                    <table class="table table-bordered" width="100%">
                        <colgroup>
                            <col class="con0" style="align: center; width: 4%" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th width="4%" class="head0">Sno.</th>
                                <th width="14%" class="head0">Date</th>
                                <th width="13%" class="head0">Particular</th>
                                <th width="29%" class="head0">Narration</th>
                                <th width="13%" class="head0">Debit</th>
                                <th width="11%" class="head0">Credit</th>
                                <th width="16%" class="head0">Balance</th>
                            </tr>
                        </thead>
                        <tbody id="record">

                            <tr style="background-color:#0033FF; color:#FFFFFF; border:2px solid #993300">
                                <td colspan="6" style="text-align:right; font-weight:bold; font-size:19px;">
                                    Opening Balance :-</td>
                                <td style="text-align:right; font-weight:bold; font-size:19px;">
                                    <?php echo number_format($openingbal, 2) . " Dr."; ?></td>
                            </tr>


                            <?php
								$slno = 1;
								$total_dr = 0;
								$total_cr = 0;
								$netbal = $openingbal;

								foreach ($customerroaker as $cust) {
									$narration = '';
									$id = $cust[5];
									$unixTimestamp = strtotime($cust[0]);
									$dayOfWeek = date("D", $unixTimestamp);
									$dr = $cust[1];
									$cr = $cust[2];
									$netbal += $dr - $cr;

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
										$vouchar = $cmn->getvalfield($connection, "payment", "vouchar_no", "paymentid='$id'");
										if ($vouchar != '') {
											$vouchar_no = '(' . $vouchar . ')';
										} else {
											echo "";
										}
									} else if (strpos($cust[4], 'Bijak') !== false) {
										$link2 = " target='_blank' href='purchasereport.php?fromdate=" . $cmn->dateformatindia($cust[0]) . "&todate=" . $cmn->dateformatindia($cust[0]) . "&suppartyid=$suppartyid'";
									} else
										$link2 = '';


								?> <tr class="abc" tabindex="<?php echo $slno; ?>">
                                <td><?php echo $slno++; ?></td>
                                <td><?php echo $cmn->dateformatindia($cust[0]) . ' (' . $dayOfWeek . ')'; ?></td>

                                <td><?php echo $cust[4] . $vouchar_no; ?></td>
                                <td><?php echo $narration; ?></td>
                                <td style="text-align:right;"><a <?php echo $link1; ?>> <?php if ($cust[1] != '') {
																									echo number_format($cust[1], 2);
																								}  ?> </a></td>
                                <td style="text-align:right;"><a <?php echo $link2; ?>><?php if ($cust[2] != '') {
																									echo number_format($cust[2], 2);
																								} ?></a></td>
                                <td style="text-align:right;"><?php echo number_format($netbal, 2) . " $str"; ?></td>
                            </tr>
                            <?php
									$total_dr += $cust[1];
									$total_cr += $cust[2];
								}
								//$netbal = $openingbal + $cust[3];

								if ($netbal < 0) {
									$str = "Cr.";
								} else {
									$str = "Dr.";
								}
								?>

                            <tr style="background-color:#0033FF; color:#FFFFFF;">
                                <td colspan="4" style="text-align:right; font-weight:bold; font-size:19px;">Net Balance
                                    :-</td>
                                <td style="text-align:right; font-weight:bold; font-size:19px;">
                                    <?php echo number_format($total_dr, 2); ?>

                                </td>
                                <td style="text-align:right; font-weight:bold; font-size:19px;">
                                    <?php echo number_format($total_cr, 2); ?>

                                </td>
                                <td style="text-align:right; font-weight:bold; font-size:19px;">
                                    <?php echo number_format($netbal, 2) . ' ' . $str; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php } ?>

                </div>
                <!--contentinner-->
            </div>
            <!--maincontent-->



        </div>
        <!--mainright-->
        <!-- END OF RIGHT PANEL -->

        <div class="clearfix"></div>
        <?php include("inc/footer.php"); ?>
        <!--footer-->


    </div>
    <!--mainwrapper-->


    <script>
    function funDel(id) { //alert(id);   


        tblname = '<?php echo $tblname; ?>';
        tblpkey = '<?php echo $tblpkey; ?>';
        pagename = '<?php echo $pagename; ?>';
        submodule = '<?php echo $submodule; ?>';
        module = '<?php echo $module; ?>';
        fromdate = '<?php echo $cmn->dateformatindia($fromdate); ?>';
        todate = '<?php echo $cmn->dateformatindia($todate); ?>';
        // alert(fromdate); 
        if (confirm("Are you sure! You want to delete this record.")) {
            jQuery.ajax({
                type: 'POST',
                url: 'ajax/delete_sale.php',
                data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule +
                    '&pagename=' + pagename + '&module=' + module,
                dataType: 'html',
                success: function(data) {
                    //alert(pagename+'?action=3&fromdate='+fromdate+'&todate='+todate);
                    location = pagename + '?action=3&fromdate=' + fromdate + '&todate=' + todate;
                }

            }); //ajax close
        } //confirm close
    } //fun close
    </script>
    <script>
    jQuery(function() {
        //Datemask dd/mm/yyyy
        jQuery("#fromdate").inputmask("dd-mm-yyyy", {
            "placeholder": "dd-mm-yyyy"
        });
        //Datemask2 mm/dd/yyyy
        jQuery("#todate").inputmask("dd-mm-yyyy", {
            "placeholder": "mm-dd-yyyy"
        });
        //Money Euro
        jQuery("[data-mask]").inputmask();
    });
    </script>

    <script>
    function changestatus(purchaseid, is_completed) {
        var crit = "<?php echo $crit; ?>";

        //alert(crit);
        if (confirm("Do You want to Update this record ?")) {
            jQuery.ajax({
                type: 'POST',
                url: 'ajax_update_order.php',
                data: "purchaseid=" + purchaseid + '&crit=' + crit + '&is_completed=' + is_completed,
                dataType: 'html',
                success: function(data) {
                    //alert(data);
                    // jQuery('#record').html(data);
                    arr = data.split("|");
                    status = arr[0].trim();
                    count_product = arr[1].trim();

                    //alert(status);

                    if (status == 1) {
                        curr_status = "Completed";
                    } else {
                        curr_status = "Pending";
                    }

                    jQuery('#status' + purchaseid).html(curr_status);

                }

            }); //ajax close
        } //confirm close
    }
    </script>

</body>

</html>