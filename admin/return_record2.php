<?php error_reporting(0);
include("dbconnect.php");
$tblname = "trip_entry";
$tblpkey = "trip_id";
$pagename  = 'billty_record2.php';
$modulename = "Billty";
//print_r($_SESSION);
// $sale_date = date('Y-m-d');
$cond = '';
if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
   $fromdate = addslashes(trim($_GET['fromdate']));
   $todate = addslashes(trim($_GET['todate']));
} else {
   $fromdate = date('Y-m-d');
   $todate = date('Y-m-d');
}
if (isset($_GET['bid_id'])) {
   $bid_id = trim(addslashes($_GET['bid_id']));
} else
   $bid_id = '';

$crit = " ";
if ($fromdate != "" && $todate != "") {

   $crit .= " and  loding_date between '$fromdate' and '$todate'";
}

?>
<!doctype html>
<html>

<head>
   <?php include("../include/top_files.php"); ?>

</head>

<body data-layout-topbar="fixed">


   <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

   <div class="maincontent">

      <div class="contentinner content-dashboard">
         <br><br> <br><br>
         <!--alert-->
         <form action="" method="get">
            <table class="table table-bordered">
               <tr>
                  <th width="20%"> From Date </th>
                  <th width="20%"> To Date </th>

                  <th width="20%">Action </th>
               </tr>
               <tr>
                  <td><input type="date" name="fromdate" id="fromdate" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" value="<?php echo $fromdate; ?>" /> </td>
                  <td><input type="date" name="todate" id="" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" value="<?php echo $todate; ?>" /> </td>


                  <td><button type="submit" name="submit" value="submit" class="btn btn-primary">
                        Search</button>
                     <a href="billty_record2.php" type="submit" name="submit" value="submit" class="btn btn-primary">
                        Reset</button>
                  </td>
               </tr>
            </table>
         </form>
         <br>

         <br>
         <br>
         <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
            <thead>
               <a class="btn btn-primary btn-lg" href="excel_return_entry1.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $consignorid; ?>&truckid=<?php echo $truckid; ?>" target="_blank" style="float:right;"> Excel </a>

               <tr>
                  <th>S.No</th>
                  <th>Trip No.</th>
                  <th>Truck No.</th>
                  <th class='hidden-350'>Loading Date</th>
                  <th>Consignor</th>
                  <th>Consignee</th>
                  <!-- <th class='hidden-1024'>Truck No.</th> -->
                  <th>Destination</th>
                  <!-- <th>Item</th> -->
                  <th>Weight/MT</th>
                  <!-- <th>Qty (Bags)</th> -->
                  <th> Expenses(Consignor) </th>
                  <th> Expenses(Consignee) </th>
                  <th> Expenses(Self) </th>
                  <th>Petrol Pump</th>
                  <th>Total Amount</th>
                  <th>Total Expenses</th>
                  <th>Total Amount</th>
                  <th class='hidden-480'>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php
               $sn = 1;
               // 	  echo "Select * from  $tblname where compid='$compid' $crit and  sessionid='$sessionid' ";
               $sql = mysqli_query($connection, "Select * from  $tblname where compid='$compid' $crit and  sessionid='$sessionid'  order by $tblpkey desc limit 10");
               while ($row = mysqli_fetch_array($sql)) {
                  $consignor_name = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid=$row[consignorid]");
                  $consignee_name = $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid=$row[consigneeid]");
                  $truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid=$row[truckid]");
                  $destination = $cmn->getvalfield($connection, "m_place", "placename", "placeid=$row[toplaceid]");
                  $cash_adv = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no=$row[trip_no] and inc_ex_id='10'");
                  $diesel_advance = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", "trip_no=$row[trip_no] and inc_ex_id='1'");
                  $consignor_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Consignor' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");
                  $consignee_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Consignee' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");
                  $self_exp = $cmn->getvalfield($connection, "trip_expenses", "sum(amt)", " category='Self' && trip_no='$row[trip_no]'  && truckid='$row[truckid]'");

                  // 										   
               ?>
                  <tr>
                     <td><?php echo $sn++; ?></td>
                     <td><?php echo $row['trip_no']; ?></td>
                     <td class='hidden-1024'><?php echo $truckno; ?></td>
                     <td><?php echo dateformatindia($row['loding_date']); ?></td>
                     <td><?php echo $consignor_name; ?></td>
                     <td class='hidden-350'><?php echo $consignee_name; ?></td>
                     <td class='hidden-1024'><?php echo $destination; ?></td>
                     <!-- <td class='hidden-1024'><?php echo $itemname; ?></td> -->
                     <td><?php echo $row['qty_mt_day_trip']; ?></td>
                     <!-- <td><?php echo $row['qty']; ?></td> -->
                     <td><?php echo $consignor_exp; ?></td>
                     <td><?php echo $consignee_exp; ?></td>
                     <td><?php echo $self_exp; ?></td>
                     <td><?php echo $row['petrol_pump']; ?></td>
									<td><?php echo $row['frieght_amt']; ?></td>
                 
                     <td><?php echo $row['trip_expenses']; ?></td>
                     <td><?php echo $row['net_amount']; ?></td>
                     <!-- <td><b><a href="upload/bilty/<?php echo $row['bilty_scan'] ?>" class="text-danger"  target="_blank" download>Download</a></b></td> -->
                     <td class='hidden-480'>
                        <!-- 	<a href="pdf/pdf_dispatch_printA4.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-warning" rel="tooltip" title="Builty A4"target="_blank" >
                                                            <i class="fa fa-print">A4</i>
                                                            <a href="pdf/pdf_dispatch_printA5.php?dispatch_id=<?php echo $row['dispatch_id']; ?>" class="btn btn-info" rel="tooltip" title="Builty A5" style="margin-left: 3px;" target="_blank">
                                                            <i class="fa fa-print">A5</i>
                                                            </a> -->
                        <a href="?editid=<?php echo $row['trip_id']; ?>">
                           <img src="../img/b_edit.png" title="Edit">
                        </a>&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo $pagename ?>" onClick="funDel(<?php echo $row['trip_id']; ?>)">
                           <img src="../img/del.png" title="Delete"></a>
                        </a>
                     </td>
                  </tr>
               <?php } ?>
            </tbody>
         </table>
      </div>
   </div>
   </div>
   </div>

   </div><!-- class="container-fluid nav-hidden" ends here  -->


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
   </script>


</body>

</html>