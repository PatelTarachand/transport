<?php
include("dbconnect.php");

$pagename = "saletrasaction_report.php";
$module = "Sale Transaction Report";
$submodule = "Sale Transaction Report List";
$btn_name = "Search";
$keyvalue = 0;
$tblname = "transaction_details";
$tblpkey = "strans_id";

if (isset($_GET['strans_id']))
    $keyvalue = $_GET['strans_id'];
else
    $keyvalue = 0;
if (isset($_GET['action']))
    $action = $_GET['action'];

$search_sql = "";


if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
    $fromdate = addslashes(trim($_GET['fromdate']));
    $todate = addslashes(trim($_GET['todate']));
} else {
    $fromdate = date("d-m-Y", strtotime("-1 months"));
    $todate = date('d-m-Y');
}





$crit = '';
if ($fromdate != "" && $todate != "") {
    $fromdate = $cmn->dateformatusa($fromdate);
    $todate = $cmn->dateformatusa($todate);
    $crit .= " and transdate between '$fromdate' and '$todate'";
}

if (isset($_GET['customer_id'])) {
    $customer_id = trim(addslashes($_GET['customer_id']));
} else
    $customer_id = '';



if ($customer_id != '') {
    $crit .= " and customer_id='$customer_id' ";
}
$yesterday = date('Y-m-d', strtotime('-1 day', strtotime($fromdate)));

?>
<!doctype html>
<html>

<head>

    <?php include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>


</head>

<body onLoad="hideval();">
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
                                <h3><i class="icon-edit"></i>Sale Transaction Report</h3>
                                <?php include("../include/page_header.php"); ?>
                            </div>

                            <form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                    <table class="table table-condensed"  style="border: 1px solid #ebebeb;">
                                        <tr>
                                            <td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                                        </tr>

                                        <tr>
                                            <th>From Date</th>
                                            <th>To date</th>
                                            <th>Customer</th>
                                            <th></th>

                                        </tr>
                                        <tr>




                                            <td><input type="text" name="fromdate" id="fromdate" class="form-control" placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>

                                            <td class='hidden-350'><input type="text" name="todate" id="todate" class="form-control" placeholder='dd-mm-yyyy' value="<?php echo $cmn->dateformatindia($todate); ?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask /></td>

                                            <td> 
                                                <select data-placeholder="Choose a Country..." name="customer_id" id="customer_id" style="width:200px" class="formcent select2-me" onchange="getunitid();getHsn();" required >
                                                <option value="">Select </option>
                                                <?php
                                                $sql = mysqli_query($connection, "select * from  m_customer order by customer_name");
                                                while ($row = mysqli_fetch_array($sql)) {
                                                   
											// $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");

                                                ?>
                                                   <option value="<?php echo $row['customer_id']; ?>"><?php echo $row['customer_name']; ?></option>

                                                <?php } ?>
                                                <script>
                                                   document.getElementById('customer_id').value = '<?php echo $customer_id; ?>';
                                                </script>
                                            </td>

                                            <td class='hidden-350'>
                                                <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" tabindex="4" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
                                                <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;" tabindex="5">Reset</a>
                                            </td>

                                        </tr>



                                    </table>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!--   DTata tables -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3><i class="icon-table"></i><?php echo $modulename; ?> Transaction List</h3>
                            </div>
                            <!-- <a class="btn btn-primary btn-lg" href="excel_service_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckno=<?php echo $truckno; ?>&mechanic_name=<?php echo $mechanic_name; ?>&maintenance=<?php echo $maintenance; ?>" target="_blank" style="float:right;"> Excel </a> -->
                            <div class="box-content nopadding">
                                 
                                    <tbody>
                                        <?php

                                        $opnbalamt = 0;
                                        $total_blcamt = 0;
                                        $sel = "select * from sale_trans where 1=1 and transdate > '$fromdate' ";
                                        $res = mysqli_query($connection, $sel);
                                        while ($row = mysqli_fetch_assoc($res)) {


                                            if ($row['transtype'] == 'debit') {

                                                $opnbalamt += $row['pamount'];
                                            }
                                            if ($row['transtype'] == 'credit') {
                                                $opnbalamt -= $row['pamount'];

                                                // $opnbalamt +=$balamt;


                                            }
                                        }

                                        // echo $opnbalamt;
                                        ?>
                                        <!-- <div style="text-align: right;"> <a href="purchase_ledger_pdf.php?fromdate=<?php echo $fromdate; ?> & todate=<?php echo $todate; ?>&customer_id=<?php echo $customer_id; ?>" target="_blank"> <input name="button" type="button" class="btn btn-danger" value="PRINT PDF"></a></div> -->

                                        <table class="table table-hover table-nomargin">
                                            <thead style="border: 3px solid #2c5e7b ">
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Date</th>

                                                    <th>Particular</th>
                                                    <th>Debit</th>
                                                    <th>credit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <thead style="border: 3px solid #2c5e7b ">
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th style="color:red;"> Opening Balance :-</th>
                                                    <th><?php echo number_format($opnbalamt, 2) . " Dr."; ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $slno = 1;
                                                $balamt = 0;
                                                // echo "select * from billing_entry where 1=1 $crit order by billing_id desc";
                                                $sel = "select * from sale_trans where 1=1 $crit ";
                                                $res = mysqli_query($connection, $sel);
                                                while ($row = mysqli_fetch_assoc($res)) {


                                                    if ($row['transtype'] == 'debit') {

                                                        $balamt += $row['pamount'];
                                                    }
                                                    if ($row['transtype'] == 'credit') {
                                                        $balamt -= $row['pamount'];
                                                    }



                                                ?>
                                                    <tr>
                                                        <td><?php echo $slno; ?></td>
                                                        <td><?php echo dateformatusa($row['transdate']); ?></td>
                                                        <td><?php echo $row['purticular']; ?></td>
                                                        <td><?php if ($row['transtype'] == 'debit') {
                                                                echo $row['pamount'];
                                                            } ?></td>
                                                        <td><?php if ($row['transtype'] == 'credit') {
                                                                echo $row['pamount'];
                                                            } ?></td>
                                                        <td><?php echo $balamt; ?></td>


                                                    </tr>

                                                <?php
                                                    $totalamt += $row['total_amt'];

                                                    $slno++;
                                                }
                                                ?>


                                            </tbody>
                                        </table>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script>
        function funDel(id) {
            //alert(id);   
            tblname = '<?php echo $tblname; ?>';
            tblpkey = '<?php echo $tblpkey; ?>';
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
                        // alert(data);
                        // alert('Data Deleted Successfully');
                        location = pagename + '?action=10';
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
</body>
<?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

</html>
<?php
mysqli_close($connection);
?>