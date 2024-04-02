<?php
error_reporting(0);
include("dbconnect.php");
$tblname = 'trip_entry';
$tblpkey = 'trip_id';
$pagename  = 'payment_recive.php';
$modulename = "Payment Receive";









if (isset($_GET['billing_type'])) {
    $billing_type  = trim(addslashes($_GET['billing_type']));
} else
    $billing_type = '';


if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = $_GET['fromdate'];

    $todate = $_GET['todate'];
    $billing_type = trim(addslashes($_GET['billing_type']));
    if ($billing_type == 'Consignor') {
        $consignorid = trim(addslashes($_GET['consignorid']));
    } else {
        $consigneeid = trim(addslashes($_GET['consigneeid']));
    }
} else {
    $fromdate = date('Y-m-d');
    $todate = date('Y-m-d');
}
$crit = " ";
if ($fromdate != "" && $todate != "") {


    $crit .= " and  loding_date   between '$fromdate' and '$todate'";
}

if ($consignorid != '') {
    $crit .= " and consignorid ='$consignorid'";
}
if ($consigneeid != '') {
    $crit .= " and consigneeid ='$consigneeid'";
}


if ($_GET['editid'] != '') {
    $bulk_vid = $_GET['editid'];
} else {
    $bulk_vid = 0;
}
// echo $bulk_vid;
if ($bulk_vid != '') {
    $paid_to = $cmn->getvalfield($connection, "voucher_entry", "paid_to", "bulk_vid=$bulk_vid");
    $pay_date = $cmn->getvalfield($connection, "voucher_entry", "pay_date", "bulk_vid=$bulk_vid");
    $remark = $cmn->getvalfield($connection, "voucher_entry", "remark", "bulk_vid=$bulk_vid");
    $consignorid1 = $cmn->getvalfield($connection, "voucher_entry", "consignorid", "bulk_vid=$bulk_vid");
    $consigneeid1 = $cmn->getvalfield($connection, "voucher_entry", "consigneeid", "bulk_vid=$bulk_vid");
}


?>
<!doctype html>
<html>

<head>

    <?php include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>

    <script>
        $(function() {

            $('#start_date').datepicker({
                dateFormat: 'dd-mm-yy'
            }).val();
            $('#end_date').datepicker({
                dateFormat: 'dd-mm-yy'
            }).val();

        });
    </script>

</head>

<body onLoad="showrecord('<?php echo $keyvalue; ?>');">
    <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

    <div class="container-fluid" id="content">

        <div id="main">
            <div class="container-fluid">
                <!--  Basics Forms -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box">
                            <div class="box-title">
                                <?php include("alerts/showalerts.php"); ?>
                                <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
                                <a href="purchase_payment_report.php" class="btn btn-success" style="float:right;">View Detail</a>
                                <?php include("../include/page_header.php"); ?>
                            </div>

                            <form id='purchase_entry' method="get" action="" class='form-horizontal' onSubmit="return checkinputmaster('compid,consignorid,consigneeid,billno,purchase_date,purchase_type,remark')">
                                <div class="control-group" style="border:2px double #CCC">
                                    <table id="mytable01" align="center" class="table table-bordered table-condensed" width="100%">
                                        <tr>

                                            <th width="20%">From Date</th>
                                            <th width="20%">To Date : </th>
                                            <th width="20%">Category</th>
                                            <!-- <th  <?php if ($_GET['billing_type'] == "Consignor") { ?>>
                                              Consignor
                                                <?php }
                                                if ($_GET['billing_type'] == "Consignee") { ?>Consignee

                                            </th><?php } ?> -->
                                            <th width="15%"> <?php if ($_GET['billing_type']!='') { ?> Party Type <?php } else { ?>Action<?php } ?> </th>
                                        </tr>
                                        <tr>
                                            <td><input type="date" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>" autocomplete="off" tabindex="1" class="form-control" required></td>
                                            <td><input type="date" name="todate" id="todate" value="<?php echo $todate; ?>" autocomplete="off" tabindex="2" class="form-control" required></td>

                                            <!--                     
                     <td><input type="text" name="fromdate" id="fromdate" class="input-medium"  placeholder='dd-mm-yyyy'
                     value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /> </td>
                   
                    
                    <td><input type="text" name="todate" id="todate" class="input-medium" 
                    placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>
                     -->
                                            <td>
                                                <select data-placeholder="Choose a Country..." name="billing_type" id="billing_type" style="width:220px" onchange="getUrl(this.value);" class="formcent select2-me">
                                                    <option value="">Select</option>
                                                    <option value="Consignor">Consignor</option>
                                                    <option value="Consignee">Consignee</option>
                                                    <script>
                                                        document.getElementById('billing_type').value = '<?php echo $_GET['billing_type']; ?>';
                                                    </script>
                                                </select>
                                            </td>

                                            <td style="display: <?php if ($_GET['billing_type'] == "Consignor") { ?> block; <?php }else{ ?> none; <?php } ?>">
                                                
                                                    <select name="consignorid" id="consignorid" class="form-control form-control-sm">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        $sql = mysqli_query($connection, "select * from m_consignor ");
                                                        while ($row = mysqli_fetch_array($sql)) {
                                                        ?>
                                                            <option value="<?php echo $row['consignorid']; ?>"><?php echo $row['consignorname']; ?></option>

                                                        <?php } ?>
                                                        <script>
                                                            document.getElementById('consignorid').value = '<?php echo $consignorid; ?>';
                                                        </script>

                                                    </select>
                                                        </td>
                                                        <td style="display: <?php if ($_GET['billing_type'] == "Consignee") { ?> block; <?php }else{ ?> none; <?php } ?>">
                                              
                                                    <select name="consigneeid" id="consigneeid" class="form-control form-control-sm">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        $sql = mysqli_query($connection, "select * from m_consignee ");
                                                        while ($row = mysqli_fetch_array($sql)) {
                                                        ?>
                                                            <option value="<?php echo $row['consigneeid']; ?>"><?php echo $row['consigneename']; ?></option>

                                                        <?php } ?>
                                                        <script>
                                                            document.getElementById('consigneeid').value = '<?php echo $consigneeid; ?>';
                                                        </script>
                                                    </select>

                                                
                                            </td>

                                            <td> <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">

                                            </td>


                                        </tr>



                                    </table>


                            </form>
                        </div>


                        <!--   DTata tables -->
                        <div class="row-fluid">

                            <div class="span12">
                                <div class="alert alert-success" style="border:3px double #999">
                                    <h3 style="color:#FF0000" id="prebal"></h3>
                                    <h5><i class="icon-table"></i><?php echo $modulename; ?> Details</h5>

                                    <table width="100%" class="table table-bordered table-condensed">
                                        <tr>
                                            <th width="10%" class="head0">Payment Date</th>
                                            <!-- <th width="10%" class="head0">TYRE NO.</th></th> -->
                                            <th width="20%" class="head0 nosort">Received To</th>
                                            <th width="25%" class="head0 nosort">Narration</th>



                                        </tr>
                                        </thead>

                                        <tbody>
                                            </span>
                                            <tr>
                                                <td>
                                                    <input type="date" name="pay_date" id="pay_date" placeholder=" " value="<?php echo $pay_date; ?>" tabindex="9" class="form-control">
                                                </td>

                                                <!-- <td> <input type="text" name="serial_no" id="serial_no" class="input-xxlarge" style="width:100px;" tabindex="9" value="<?php echo $serial_no; ?>"  autofocus autocomplete="off" /> </td> -->

                                                <!-- <input type="hidden" name="unitid" id="unitid" class="input-xxlarge" style="width:30px;" value="<?php echo $unitid; ?>" tabindex="8" autofocus autocomplete="off" /> -->
                                                <td>
                                                    <input type="text" name="paid_to" id="paid_to" placeholder="Received To" value="<?php echo $paid_to; ?>" tabindex="9" class="form-control">
                                                </td>


                                                <td>
                                                    <input type="text" name="remark" id="remark" placeholder=" Enter Remark" value="<?php echo $remark; ?>" tabindex="9" class="form-control">
                                                </td>




                                            </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row-fluid">
                                <div class="span12">
                                    <h4 class="widgettitle nomargin" style="margin-left:20px;"> <span style="color:#00F;"> Payment Details : <span id="inentryno"> </span>

                                        </span></h4>




                                    <!--span8-->


                                </div>
                            </div>

                            </form>

                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <!--<div class="box box-bordered">-->
                            <!--			<h3><i class="icon-table"></i>Payment Details <span id="inentryno"> </span></h3>-->
                            <!--	</div>-->

                            <div class="box-content nopadding" style="overflow:scroll;">
                                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sno </th>

                                            <th>Loding Date </th>
                                            <th>Trip No./LR No. </th>
                                            <!-- <th>Item Name </th> 
<th>Party Billing Type </th> -->
                                            <th>Truck No. </th>
                                            <th>Qty/MT/DayTrip</th>
                                            <th>Rate </th>
                                            <th>Frieght Amt </th>

                                            <th>Total Expence </th>


                                            <th>Tds %</th>
                                            <th>Tds Amt</th>
                                            <th>Gross Amount </th>
                                            <th>Shortage Deduction </th>
                                            <th>Other Deduction</th>
                                            <th style="display:none;">Tp Name</th>
                                            <th style="display:none;"> Tp Amount</th>
                                            <th>Net Amount</th>
                                            <th class='hidden-480'>Action</th>
                                        </tr>
                                    </thead>
                                    <?php if ($bulk_vid == 0) { ?>
                                        <tbody>
                                            <?php $sn = 1;
                                            // echo "select * from trip_entry where $crit && compid='$compid' && is_complete=0 order by trip_id desc";
                                            // echo "select * from trip_entry where 1=1  $crit && compid='$compid' && is_complete=0 order by trip_id desc";
                                            $sql = mysqli_query($connection, "select * from trip_entry where 1=1  $crit && compid='$compid' && is_complete=0 order by trip_id desc");
                                            while ($row = mysqli_fetch_array($sql)) {

                                                $itemcategoryname = $cmn->getvalfield($connection, "item_master", "itemcategoryname", "item_id='$row[item_id]'");

                                                $party_type = $cmn->getvalfield($connection, "supplier_master", "party_type", "trip_id='consignor' && party_type='$row[supplier_name]'");

                                                $supplier_name = $cmn->getvalfield($connection, "supplier_master", "supplier_name", "consid='$row[consid]'");
                                                $place_name = $cmn->getvalfield($connection, "place_master", "place_name", "place_id='$row[place_id]'");
                                                $truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
                                                $unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unit_id='$row[unit_id]'");

                                                $Consignor = $cmn->getvalfield($connection, "supplier_master", "supplier_name", "consid='$row[consignorid]'");
                                                $Consignee = $cmn->getvalfield($connection, "supplier_master", "supplier_name", "consid='$row[consigneeid]'");
                                                $fromplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[fromplaceid]'");
                                                $toplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[toplaceid]'");
                                                $totexp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]'");
                                                $Consignee_amt = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]'");
                                                $Consignor_amt = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]'");
                                                $final_total = $row['net_amount'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $sn++; ?></td>
                                                    <td><?php echo date('d-m-Y', strtotime($row['loding_date'])); ?></td>
                                                    <td><?php echo $row['trip_no']; ?></td>
                                                    <!-- <td><?php echo $itemcategoryname; ?></td>  -->

                                                    <!-- <td><?php echo $Consignor; ?></td>	
											<td><?php echo $Consignee; ?></td> -->
                                                    <!-- <td><?php echo $row['billing_type']; ?></td> -->
                                                    <!-- <td><?php echo $fromplace; ?></td>	
											<td><?php echo $toplace; ?></td> -->

                                                    <td><?php echo $truckno; ?></td>
                                                    <!-- <td><?php echo $unit_name; ?></td> -->
                                                    <td><?php echo $row['qty_mt_day_trip']; ?></td>
                                                    <td><?php echo $row['rate']; ?></td>
                                                    <td>
                                                        <!-- <?php echo $row['net_amount']; ?> -->
                                                        <input type="text" name="frieght_amt" id="frieght_amt<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="9" class="form-control" value="<?php echo $row['frieght_amt']; ?>" style="width:80px;" readonly>
                                                    </td>
                                                    <!--<?php echo $row['tds']; ?>-->

                                                    <!--<td><?php echo $row['tds_amt']; ?></td>-->
                                                    <td><?php echo $totexp; ?></td>

                                                    <td> <input type="text" name="tds" id="tds<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $row['tds']; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">
                                                    </td>
                                                    <td> <input type="text" name="tds_amt" id="tds_amt<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $row['tds_amt']; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);" readonly>
                                                    </td>

                                                    <td>
                                                        <!-- <?php echo $row['net_amount']; ?> -->
                                                        <input type="text" name="net_amount" id="net_amount<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $row['net_amount']; ?>" readonly>
                                                    </td>


                                                    <td>
                                                        <input type="text" name="short_deduct" id="short_deduct<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $short_deduct; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">

                                                    </td>
                                                    <td>
                                                        <input type="text" name="other_deduct" id="other_deduct<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="10" class="form-control" value="<?php echo $other_deduct; ?> " onchange="getdeduct(<?php echo $row['trip_id']; ?>);">

                                                    </td>
                                                    <td style="display:none;"><select name="tp_id" tabindex="5" id="tp_id<?php echo $row['trip_id']; ?>" style="width:80px;" tabindex="6" style="width:100%;" class='select2-me'>
                                                            <option value=""> Select </option>
                                                            <?php
                                                            $sql1 = mysqli_query($connection, "Select * from  tp_master  order by tp_id desc");
                                                            while ($row1 = mysqli_fetch_array($sql1)) { ?>


                                                                <option value="<?php echo $row1['tp_id']; ?>"><?php echo $row1['tp_name']; ?></option>
                                                            <?php } ?>

                                                        </select></td>
                                                    <td style="display:none;"><input type="text" tabindex="9" name="tp_amount" id="tp_amount<?php echo $row['trip_id']; ?>" placeholder="" class="form-control" tabindex="10" value="<?php echo $tp_amount; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);"></td>
                                                    <!-- <td><?php echo $tp_name; ?></td>	
											<td style="display:none;"><?php echo $row['tp_amount']; ?></td>
											<td><?php echo $row['unloading_place']; ?></td>
											<td><?php echo $row['unloading_date']; ?></td>
											<td><?php echo $row['upload_builty']; ?></td> -->

                                                    <td>
                                                        <input type="text" name="final_total" id="final_total<?php echo $row['trip_id']; ?>" placeholder=" " style="width:100px;" tabindex="10" class="form-control" value="<?php echo $final_total; ?> " readonly>
                                                        <input type="hidden" name="payment_recive_id" id="payment_recive_id<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="10" class="form-control" value="<?php echo $payment_recive_id; ?> " readonly>
                                                    </td>
                                                    <td>
                                                        <a onClick="savepay(<?php echo $row['trip_id']; ?>)" class="btn btn-success">Save</a>
                                                        <span style="color:#F00;width: 70px;" id="msg<?php echo $row['trip_id']; ?>"></span>
                                                    </td>
                                                <?php } ?>
                                                </tr>




                                        </tbody>
                                    <?php } else { ?>

                                        <tbody>

                                            <?php $sn = 1;
                                            // echo "select * from trip_entry where compid='$compid' order by trip_id desc";
                                            $sql = mysqli_query($connection, "select * from trip_entry where compid='$compid' && is_complete=1 && bulk_vid=$bulk_vid order by trip_id desc");
                                            while ($row = mysqli_fetch_array($sql)) {

                                                $itemcategoryname = $cmn->getvalfield($connection, "item_master", "itemcategoryname", "item_id='$row[item_id]'");

                                                $party_type = $cmn->getvalfield($connection, "supplier_master", "party_type", "trip_id='consignor' && party_type='$row[supplier_name]'");

                                                $supplier_name = $cmn->getvalfield($connection, "supplier_master", "supplier_name", "consid='$row[consid]'");
                                                $place_name = $cmn->getvalfield($connection, "place_master", "place_name", "place_id='$row[place_id]'");
                                                $truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");
                                                $unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unit_id='$row[unit_id]'");

                                                $Consignor = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$row[consignorid]'");
                                                $Consignee = $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$row[consigneeid]'");
                                                $fromplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[fromplaceid]'");
                                                $toplace = $cmn->getvalfield($connection, "city_master", "city_name", "city_id='$row[toplaceid]'");
                                                $Self_amt = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Self'");
                                                $Consignee_amt = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Consignee'");
                                                $Consignor_amt = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no='$row[trip_no]' && category='Consignor'");
                                                // $final_total=$row['net_amount'];
                                                $short_deduct = $cmn->getvalfield($connection, "payment_recive", "short_deduct", "trip_id='$row[trip_id]'");
                                                $other_deduct = $cmn->getvalfield($connection, "payment_recive", "other_deduct", "trip_id='$row[trip_id]'");
                                                $final_total = $cmn->getvalfield($connection, "payment_recive", "final_total", "trip_id='$row[trip_id]'");
                                                $payment_recive_id  = $cmn->getvalfield($connection, "payment_recive", "payment_recive_id ", "trip_id='$row[trip_id]'");
                                            ?>
                                                <tr>
                                                    <td><?php echo $sn++; ?></td>
                                                    <td><?php echo date('d-m-Y', strtotime($row['loding_date'])); ?></td>
                                                    <td><?php echo $row['trip_no']; ?></td>
                                                    <!-- <td><?php echo $itemcategoryname; ?></td>  -->

                                                    <!-- <td><?php echo $Consignor; ?></td>	
											<td><?php echo $Consignee; ?></td> -->
                                                    <!-- <td><?php echo $row['billing_type']; ?></td> -->
                                                    <!-- <td><?php echo $fromplace; ?></td>	
											<td><?php echo $toplace; ?></td> -->

                                                    <td><?php echo $truckno; ?></td>
                                                    <!-- <td><?php echo $unit_name; ?></td> -->
                                                    <td><?php echo $row['qty_mt_day_trip']; ?></td>
                                                    <td><?php echo $row['rate']; ?></td>
                                                    <!--<td><?php echo $row['frieght_amt']; ?></td>-->
                                                    <td>
                                                        <!-- <?php echo $row['net_amount']; ?> -->
                                                        <input type="text" name="frieght_amt" id="frieght_amt<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="9" class="form-control" value="<?php echo $row['frieght_amt']; ?>" style="width:80px;" readonly>
                                                    </td>
                                                    <!--<td><?php echo $row['tds']; ?></td>-->
                                                    <td><?php echo $row['tds_amt']; ?></td>
                                                    <td><?php echo $totexp; ?></td>

                                                    <td> <input type="text" name="tds" id="tds<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $row['tds']; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">
                                                    </td>
                                                    <td> <input type="text" name="tds_amt" id="tds_amt<?php echo $row['trip_id']; ?>" placeholder=" " style="width:80px;" tabindex="9" class="form-control" value="<?php echo $row['tds_amt']; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">
                                                    </td>
                                                    <td>
                                                        <!-- <?php echo $row['net_amount']; ?> -->
                                                        <input type="text" name="net_amount" id="net_amount<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="9" class="form-control" value="<?php echo $row['net_amount']; ?>" style="width:80px;" readonly>
                                                    </td>



                                                    <td>
                                                        <input type="text" name="short_deduct" id="short_deduct<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="9" class="form-control" value="<?php echo $short_deduct; ?>" style="width:80px;" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">

                                                    </td>
                                                    <td>
                                                        <input type="text" name="other_deduct" id="other_deduct<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="10" class="form-control" value="<?php echo $other_deduct; ?> " style="width:80px;" onchange="getdeduct(<?php echo $row['trip_id']; ?>);">

                                                    </td>
                                                    <td style="display:none;"><select name="tp_id" tabindex="5" id="tp_id<?php echo $row['trip_id']; ?>" tabindex="6" class='select2-me'>
                                                            <option value=""> Select </option>
                                                            <?php
                                                            $sql1 = mysqli_query($connection, "Select * from  tp_master  order by tp_id desc");
                                                            while ($row1 = mysqli_fetch_array($sql1)) { ?>


                                                                <option value="<?php echo $row1['tp_id']; ?>"><?php echo $row1['tp_name']; ?></option>
                                                            <?php } ?>

                                                        </select></td>
                                                    <td style="display:none;"><input type="text" tabindex="9" name="tp_amount" id="tp_amount<?php echo $row['trip_id']; ?>" placeholder="" class="form-control" tabindex="10" value="<?php echo $tp_amount; ?>" onchange="getdeduct(<?php echo $row['trip_id']; ?>);"></td>
                                                    <!-- <td><?php echo $tp_name; ?></td>	
											<td style="display:none;"><?php echo $row['tp_amount']; ?></td>
											<td><?php echo $row['unloading_place']; ?></td>
											<td><?php echo $row['unloading_date']; ?></td>
											<td><?php echo $row['upload_builty']; ?></td> -->

                                                    <td>
                                                        <input type="text" name="final_total" id="final_total<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="10" class="form-control" style="width:80px;" value="<?php echo $final_total; ?> " readonly>
                                                        <input type="hidden" name="payment_recive_id" id="payment_recive_id<?php echo $row['trip_id']; ?>" placeholder=" " tabindex="10" class="form-control" value="<?php echo $payment_recive_id; ?> " readonly>
                                                    </td>
                                                    <td>
                                                        <a onClick="savepay(<?php echo $row['trip_id']; ?>)" class="btn btn-satblue">Save</a>
                                                        <span style="color:#F00;width: 70px;" id="msg<?php echo $row['trip_id']; ?>"></span>
                                                    </td>

                                                <?php } ?>
                                                </tr>



                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="bulk_vid" id="bulk_vid" placeholder=" " tabindex="10" class="form-control" value="<?php echo $bulk_vid; ?> " readonly>
            <input type="hidden" name="consignorid1" id="consignorid1" placeholder=" " tabindex="10" class="form-control" value="<?php echo $consignorid1; ?> " readonly>
            <input type="hidden" name="consigneeid1" id="consigneeid1" placeholder=" " tabindex="10" class="form-control" value="<?php echo $consigneeid1; ?> " readonly>
            <br />
            <center>
                <a type="submit" name="submit" class="btn btn-success" tabindex="7" onclick="savebulkvid();">
                    Save</a>
                <a href="payment_recive.php" name="reset" id="reset" class="btn btn-danger" style="border-radius:4px !important;" tabindex="8">Reset</a>


            </center>
        </div>
    </div>
    </div>
    </div>


    </div>
    </div>
    </div>



    <script>
        function deleterecord(id) {
            //alert(id);   
            tblname = 'purchasentry_detail';
            tblpkey = 'purdetail_id';
            pagename = '<?php echo $pagename; ?>';
            modulename = '<?php echo $modulename; ?>';
            //alert(tblpkey); 
            if (confirm("Are you sure! You want to delete this record.")) {
                $.ajax({
                    type: 'POST',
                    url: '../ajax/delete.php',
                    data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
                    dataType: 'html',
                    success: function(data) {
                        showrecord(<?php echo $keyvalue; ?>);
                    }

                }); //ajax close
            } //confirm close
        } //fun close

        function hideval() {
            var paymode = document.getElementById('paymode').value;
            if (paymode == 'cash') {
                document.getElementById('checquenumber').disabled = true;
                document.getElementById('session_name').disabled = true;
                document.getElementById('checquenumber').value = "";
                document.getElementById('session_name').value = "";
            } else {
                document.getElementById('checquenumber').disabled = false;
                document.getElementById('session_name').disabled = false;
            }
        }
    </script>


    <script>
        function showrecord(keyvalue) {
            var purchaseid = document.getElementById("purchaseid").value;
            // alert(purchaseid);
            var sup_id = document.getElementById("sup_id").value;
            // alert(purchaseid);
            jQuery.ajax({
                type: 'POST',
                url: 'show_paymentpur.php',
                data: 'purchaseid=' + purchaseid + '&sup_id=' + sup_id,
                success: function(data) {
                    // alert(data);
                    jQuery("#showsalerecord").html(data);

                }
            }); //ajax close


        }


        function getdeduct(trip_id) {
            var other_deduct = parseFloat(jQuery('#other_deduct' + trip_id).val());
            var frieght_amt = parseFloat(jQuery('#frieght_amt' + trip_id).val());
           
            var short_deduct = parseFloat(jQuery('#short_deduct' + trip_id).val());
            var net_amount = parseFloat(jQuery('#net_amount' + trip_id).val());
            var tp_amount = parseFloat(jQuery('#tp_amount' + trip_id).val());
            var tds = parseFloat(jQuery('#tds' + trip_id).val());
          
            var tds_amt = parseFloat(jQuery('#tds_amt' + trip_id).val());
            // alert(tp_amount);
            if (isNaN(short_deduct)) {
                short_deduct = '0';
            }
            if (isNaN(other_deduct)) {
                other_deduct = '0';
            }

            if (isNaN(tp_amount)) {
                tp_amount = '0';
            }
            if (isNaN(tds_amt)) {
                tds_amt = 0;
            }
            if (tds != '') {
                var tds_amt = frieght_amt * (tds / 100);
                jQuery('#tds_amt' + trip_id).val(tds_amt);
             
                var net_amount = net_amount - tds_amt;
                jQuery('#net_amount' + trip_id).val(net_amount);
            }
            var final_total = net_amount - short_deduct - other_deduct - tp_amount;




            jQuery('#final_total' + trip_id).val(final_total);



        }

        function savepay(trip_id) {
            var other_deduct = jQuery('#other_deduct' + trip_id).val();
            var short_deduct = jQuery('#short_deduct' + trip_id).val();
            var final_total = jQuery('#final_total' + trip_id).val();
            var tp_amount = jQuery('#tp_amount' + trip_id).val();
            var tp_id = jQuery('#tp_id' + trip_id).val();

            var payment_recive_id = jQuery('#payment_recive_id' + trip_id).val();
            var tds = parseFloat(jQuery('#tds' + trip_id).val());
       
            var tds_amt = parseFloat(jQuery('#tds_amt' + trip_id).val());

            jQuery.ajax({
                type: 'POST',
                url: 'savepayment.php',
                data: "trip_id=" + trip_id + '&other_deduct=' + other_deduct + '&short_deduct=' + short_deduct + '&final_total=' + final_total + '&tp_amount=' + tp_amount + '&tp_id=' + tp_id + '&payment_recive_id=' + payment_recive_id + '&tds=' + tds + '&tds_amt=' + tds_amt,
                dataType: 'html',
                success: function(data) {
                    // 			alert(data);
                    document.getElementById('msg' + trip_id).innerHTML = 'Save';
                }
            }); //ajax close


        }

        function getprebal() {
            var sup_id = document.getElementById('sup_id').value;
            var paymentdate = document.getElementById('paymentdate').value;
            // alert(paymentdate);

            if (paymentdate == '') {
                alert("Please Select Date");
                return false;
            }

            if (sup_id == '') {
                alert("Please Select Customer");
                return false;
            }

            if (sup_id != '') {
                jQuery.ajax({
                    type: 'POST',
                    url: 'getprevbalsupp.php',
                    data: 'sup_id=' + sup_id + '&paymentdate=' + paymentdate,
                    dataType: 'html',
                    success: function(data) {
                        // 		alert(data);
                        document.getElementById('prebal').innerHTML = 'Old Balance : ' + data;
                        jQuery('#paid_amt').focus('');
                    }
                }); //ajax close
            }

        }

        // function getSearch() {

        //     var fromdate = document.getElementById("fromdate").value;
        //     var todate = document.getElementById("todate").value;
        //     var billing_type = document.getElementById("billing_type").value;
        //     var consignorid = document.getElementById("consignorid").value;
        //     var consigneeid = document.getElementById("consigneeid").value;

        //     location = "payment_recive.php?fromdate=" + fromdate + '&todate=' + todate + '&billing_type=' + billing_type + '&consignorid=' + consignorid+ '&consigneeid=' + consigneeid;
        // }


        function updatesale() {

            var sup_id = document.getElementById('s_sup_id').value.trim();
            var paid_amt = document.getElementById('s_paid_amt').value.trim();
            var pay_type = document.getElementById('s_pay_type').value.trim();
            //   alert(pay_type);
            var disc = document.getElementById('s_discamt').value.trim();
            var narration = document.getElementById('s_narration').value.trim();
            var paymentdate = document.getElementById('s_paymentdate').value.trim();
            var paymentid = document.getElementById('s_paymentid').value.trim();
            //   alert(paymentdate);

            if (paymentdate == '') {
                alert("Please Select Date");
                return false;
            }


            if (sup_id == '') {
                alert("Please Select Customer");
                return false;
            }


            if (paid_amt == '' || paid_amt == '0') {
                alert("Paid Amount cant be Balnk/Zero");
                return false;
            }



            jQuery.ajax({
                type: 'POST',
                url: 'savepaymentpur.php',
                data: 'paymentdate=' + paymentdate + '&paid_amt=' + paid_amt + '&disc=' + disc + '&narration=' + narration + '&pay_type=' + pay_type + '&sup_id=' + sup_id + '&paymentid=' + paymentid,
                //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
                dataType: 'html',
                success: function(data) {
                    //   alert(data)	  ;
                    jQuery('#s_sup_id').val('');
                    jQuery('#s_pay_type').val('');
                    jQuery('#s_paid_amt').val('');
                    jQuery('#s_narration').val('');
                    jQuery('#s_paymentdate').val('');
                    jQuery('#s_paymentid').val('');
                    jQuery('#myModal_product').modal('hide');
                    showrecord();

                }
            }); //ajax close



        }

        function savebulkvid() {


            var pay_date = document.getElementById("pay_date").value;
            var remark = document.getElementById("remark").value;
            var paid_to = document.getElementById("paid_to").value;

            var consignorid = document.getElementById("consignorid").value;
            var consigneeid = document.getElementById("consigneeid").value;
            var bulk_vid = document.getElementById("bulk_vid").value;
            var consignorid1 = document.getElementById("consignorid1").value;
            var consigneeid1 = document.getElementById("consigneeid1").value;


            if (consignorid == ''&& consigneeid == '') {
         
            //     consigneeid = consigneeid1;

                alert("Please fill the Category And  Party Type");
                return false;
            }
            if (consigneeid == '') {
                consigneeid = consigneeid1;
         
            }
            if (consignorid == '') {
                consignorid = consignorid1;

         
            }


            if (pay_date == '' || paid_to == '') {
                alert("Please fill the Required Details ");
                return false;
            }
        


            jQuery.ajax({
                type: 'POST',
                url: 'savebulkvid.php',
                data: "pay_date=" + pay_date + "&remark=" + remark + "&paid_to=" + paid_to + "&consignorid=" + consignorid + "&consigneeid=" + consigneeid + "&bulk_vid=" + bulk_vid,
                success: function(data) {
              
                    location.reload();
                },
            });
        }

        function addserial() {


            var itemid = jQuery("#itemid").val();
            var purchaseid = 0;

            // var purchaseid = document.getElementById("purchaseid1").value;
            // var purdetail_id = document.getElementById("purdetail_id").value;
            var qty = jQuery("#qty").val();
            // alert(itemid);
            // alert(qty);
            jQuery.ajax({
                type: 'POST',
                url: 'addserialnoitembody.php',
                data: 'itemid=' + itemid + '&qty=' + qty + '&purchaseid=' + purchaseid,
                dataType: 'html',
                success: function(data) {
                    // alert(data);
                    if (data == 2) {
                        jQuery("#modal-snserial").modal('hide');

                    } else {
                        jQuery("#modal-snserial").modal('show');

                        jQuery("#serialbody1").html(data);

                    }
                }

            }); //ajax close


        }


        function saveserial(i) {
            // alert(i);
            var pos_id = document.getElementById('pos_id' + i).value;
            var itemid = document.getElementById('itemid').value;
            var purchaseid = 0;
            // alert(itemid);
            var serial_no = document.getElementById('serial_no1' + i).value;
            var purdetail_id = document.getElementById('m_purdetail_id').value;
            // alert(purchaseid);
            // alert(serial_no);

            // var serial_no='';
            // for (var i = 0;i < serial_no.length;i++) {
            // serial_no += serial_no[i].value+',';
            // }

            // serial_no = serial_no.substring(0,serial_no.length -1);

            jQuery.ajax({
                type: 'POST',
                url: 'saveserialnotyre.php',
                data: 'i=' + i + '&pos_id=' + pos_id + '&itemid=' + itemid + '&purdetail_id=' + purdetail_id + '&serial_no=' + serial_no + '&purchaseid=' + purchaseid,
                dataType: 'html',
                success: function(data) {
                    // alert(data);
                    // jQuery("#modal-snserial").modal('hide');
                    //	jQuery("#modal-snserial").hide();

                }

            }); //ajax close


        }


        // function showAmt() {

        //     var billing_type = document.getElementById('billing_type').value;

        //     if (billing_type == 'Consignor') {
        //         //alert(billing_type);
        //         //  jQuery('#grand_total2').show();
        //         // jQuery('#consignorid').show();
        //          jQuery('#gst2').show();
        //         // jQuery('#consigneeid').hide();
        //         jQuery('#gst3').hide();




        //     } else {

        //         //  jQuery('#grand_total2').hide();
        //         // jQuery('#consigneeid').show();
        //          jQuery('#gst2').hide();
        //         // jQuery('#consignorid').hide();
        //         jQuery('#gst3').show();

        //     }
        // }

        function getdel() {

            var qty = document.getElementById("qty").value;

            var rate = document.getElementById("rate").value;

            var gst = document.getElementById("gst").value;

            var total_amt = document.getElementById("total_amt").value;

            if (qty != "" && !isNaN(rate)) {

                var total = qty * rate;
                //alert(total);
                var gsttotal = total * gst / 100;
                var nettotal = total + gsttotal;
                jQuery('#total_amt').val(total);
                jQuery('#nettotal').val(nettotal);
            }

        }








        function funDel(id) {
            // 	  alert(id);   
            tblname = 'payment';
            tblpkey = 'paymentid';
            pagename = '<?php echo $pagename; ?>';
            modulename = '<?php echo $modulename; ?>';
            //alert(tblpkey); 
            if (confirm("Are you sure! You want to delete this record.")) {
                jQuery.ajax({
                    type: 'POST',
                    url: '../ajax/deletepurchase.php',
                    data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,
                    dataType: 'html',
                    success: function(data) {
                        // 			alert(data);
                        // alert('Data Deleted Successfully');
                        //   location=pagename+'?action=10';
                        showrecord(<?php echo $keyvalue; ?>);
                    }

                }); //ajax close
            } //confirm close
        } //fun close

        function getunitid(itemid) {
            var itemid = document.getElementById("itemid").value;

            $.ajax({
                type: 'POST',
                url: 'get_unitdetails.php',
                data: 'itemid=' + itemid,
                dataType: 'html',
                success: function(data) {
                    //alert(data);

                    $('#unitid').html(data).trigger('change').trigger('select2:select');

                }
            }); //ajax close	
        }

        function getHsn() {
            var itemid = document.getElementById("itemid").value;
            $.ajax({
                type: 'POST',
                url: 'ajax_gethsnno.php',
                data: 'itemid=' + itemid,
                dataType: 'html',
                success: function(data) {
                    $('#disc').val(data);
                }
            }); //ajax close 
        }



        function addlist() {
            var sup_id = document.getElementById('sup_id').value;
            var paymentdate = document.getElementById('paymentdate').value;
            //var unitrate = document.getElementById('unitrate').innerHTML.trim();
            var paid_amt = document.getElementById('paid_amt').value.trim();
            var disc = document.getElementById('disc').value.trim();
            var pay_type = document.getElementById('pay_type').value.trim();
            var narration = document.getElementById('narration').value.trim();
            // alert(sup_id);
            var paymentid = 0;

            if (paymentdate == '') {
                alert("Please Select Date");
                return false;
            }


            if (sup_id == '') {
                alert("Please Select Customer");
                return false;
            }


            if (paid_amt == '' || paid_amt == '0') {
                alert("Paid Amount cant be Balnk/Zero");
                return false;
            }

            jQuery.ajax({
                type: 'POST',
                url: 'savepaymentpur.php',
                data: 'paymentdate=' + paymentdate + '&paid_amt=' + paid_amt + '&disc=' + disc + '&narration=' + narration + '&pay_type=' + pay_type + '&sup_id=' + sup_id + '&paymentid=' + paymentid,
                //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
                dataType: 'html',
                success: function(data) {
                    //alert(data);		  
                    jQuery('#sup_id').val('');
                    jQuery('#paid_amt').val('');
                    jQuery('#disc').val('');
                    jQuery('#receiptno').val('');
                    jQuery('#prebal').val('');
                    jQuery('#narration').val('');



                    jQuery("#sup_id").val('').trigger("liszt:updated");
                    document.getElementById('sup_id').focus();
                    jQuery(".chzn-single").focus();


                    showrecord();

                }
            }); //ajax close


        }
    </script>
    <script>
        function edit(purchaseid) {

            $.ajax({
                type: 'POST',
                url: 'checkotp.php',
                data: 'type=Purchase',
                dataType: 'html',
                success: function(data) {
                    //	alert(data);
                    $('#modal-sn').modal('show');
                    $("#otp").val('');
                    $("#m_purchaseid").val(purchaseid);

                }
            }); //ajax close
        }

        function checkotp() {
            purchaseid = $("#m_purchaseid").val();
            otp = $("#otp").val();
            $.ajax({
                type: 'POST',
                url: 'checkotpsave.php',
                data: 'purchaseid=' + purchaseid + '&otp=' + otp,
                dataType: 'html',
                success: function(data) {
                    //

                    if (data == 1) {
                        $('#modal-sn').modal('hide');
                        $("#saveid").show();
                        $("#otpid").hide();

                    } else {
                        //  $( "#purchase_entry" ).submit();
                        alert("OTP doesn't Match");
                    }
                }
            }); //ajax close

        }

        function funDel1(id) {
            // 	alert(id);
            tblname = '<?php echo $tblname; ?>';
            tblpkey = '<?php echo $tblpkey; ?>';
            pagename = '<?php echo $pagename; ?>';
            submodule = '<?php echo $submodule; ?>';
            module = '<?php echo $module; ?>';


            jQuery.ajax({
                type: 'POST',
                url: 'delete_master.php',
                data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&submodule=' + submodule + '&pagename=' + pagename + '&module=' + module,
                dataType: 'html',
                success: function(data) {
                    //alert(data);
                    showrecord(<?php echo $keyvalue; ?>);

                }
            }); //ajax close
        }

        function editselected(paymentid, paymentdate, sup_id, paid_amt, narration, disc, pay_type) {
          
            jQuery('#myModal_product').modal('show');
            jQuery('#s_paymentid').val(paymentid);

            jQuery('#s_discamt').val(disc);
            jQuery('#s_paymentdate').val(paymentdate);
            jQuery('#s_paid_amt').val(paid_amt);
            jQuery('#s_narration').val(narration);
            // jQuery('#s_sup_id').val(sup_id);
            $("#s_sup_id").select2().select2('val', sup_id);

            jQuery('#s_paymentid').val(paymentid);
            // jQuery('#s_pay_type').val(pay_type);
            $("#s_pay_type").select2().select2('val', pay_type);
            // $("#trip_detailid").select2().select2('val', '');
            //		
        }

        function getUrl(billing_type) {
       
            location = "payment_recive.php?billing_type=" + billing_type;
            var fromdate = document.getElementById('fromdate').value.trim();
            var todate = document.getElementById('todate').value.trim();
            var consigneeid = document.getElementById('consigneeid').value.trim();
            var consignorid = document.getElementById('consignorid').value.trim();

            location = "payment_recive.php?billing_type=" + billing_type + '&fromdate=' + fromdate + '&todate=' + todate + '&consignorid=' + consignorid+ '&consigneeid=' + consigneeid;
        }
    </script>
</body>

</html>
<?php
mysqli_close($connection);
?>