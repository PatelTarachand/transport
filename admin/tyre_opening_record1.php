<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "tyre_map";
$tblpkey = "mapid";
$pagename = "tyre_truck_maping.php";
$modulename = "Truck-Tyre-Mapping";
if (isset($_REQUEST['action']))
   $action = $_REQUEST['action'];
else
   $action = 0;
$truckid = $_GET['truckid'];
// $typos = $_REQUEST['id'];

if (isset($id)) {
   $btn_name = "Update";

   $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
   $rowedit = mysqli_fetch_array(mysqli_query($connection, $sqledit));
   $truckid=$rowedit['truckid'];
   $mapid=$rowedit['mapid'];

   $typos=$rowedit['typos'];
 $serial_number=$rowedit['serial_number'];
   $tyre_name=$rowedit['tyre_name'];
   $meterreading=$rowedit['meterreading'];
   $uploaddate=$rowedit['uploaddate'];  
   $tyre_model = $rowedit['tyre_model'];
   $tyre_new_image=$rowedit['tyre_new_image'];
   $tyre_old_image=$rowedit['tyre_old_image'];
    $old_tyre_name=$rowedit['old_tyre_name'];
    $old_tyre_serial_no=$rowedit['old_tyre_serial_no'];
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
<style type="text/css">
   img.i1 {

      transform: scaleX(-1);
   }

   .modal-header {
      padding: 0px 0px;
   }

   .modal {
      left: 40% !important;
      width: 800px !important;
   }
</style>

<body onLoad="getrecord('<?php echo $keyvalue; ?>');">
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



                        <!-- <a href="issueentry_detail.php" class="btn btn-primary" style="float:right;">View Detail</a> -->


                        <?php include("../include/page_header.php"); ?>

                     </div>



                     <form method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('truckid,issuno,issudate,driver')">
                        <div class="control-group">
                           <table class="table table-condensed">
                              <tr>
                                 <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                              </tr>

                              <tr>
                                 <td width="20%"><strong>Truck No </strong><strong>:</strong><span class="red">*</span></td>

                              </tr>
                              <tr>
                                 <td> <select name="truckid" id="truckid" class="select2-me input-large" onChange="getdetail()">
                                       <option value="">-select-</option>
                                       <?php
                                       $sql = mysqli_query($connection, "Select truckid,truckno from m_truck  order by truckno");
                                       if ($sql) {
                                          while ($row = mysqli_fetch_assoc($sql)) {
                                       ?>
                                             <option value="<?php echo $row['truckid']; ?>"><?php echo strtoupper($row['truckno']); ?></option>
                                       <?php
                                          }
                                       }
                                       ?>

                                    </select>

                                    <script>
                                       document.getElementById('truckid').value = '<?php echo $truckid; ?>';
                                    </script>
                                 </td>

                              </tr>




                           </table>
                        </div>

                        <?php
                        if (isset($_GET['truckid'])) { ?>
                           <div class="container-fluid">
                              <div class="row" style="display:flex;justify-content: center;">
                                 <table>
                                    <thead>
                                       <tr>
                                          <td>
                                             <h5 style="margin-right: 31px;padding-top: 100px;">Front Left</h5>
                                          </td>
                                          <td>
                                             <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
                                                <div class="modal-header">

                                                   <h6 style="border-bottom: 1px solid #ddd;padding: 10px;">Truck Number: CG06GN8855, Tyre Type: Front Left</h6>
                                                   <ul class="nav nav-tabs" style="padding-left: 20px;">
                                                      <li class="active"><a data-toggle="tab" href="#home">Create</a></li>
                                                      <li><a data-toggle="tab" href="#menu1">Report</a></li>

                                                   </ul>

                                                   <div class="tab-content">
                                                      <div id="home" class="tab-pane fade in active">
                                                         <h4 style="text-align: center;">Create Tyre Opening Balance</h4>
                                                         <table style="width:100%;">
                                                            <tr>

                                                               <input type="text"  id="id" class="formcent">

                                                               <td style="padding: 17px;">
                                                                  <div style="padding-left: 10px;">Serial Number:</div>
                                                                  <div class="text">
                                                                     <input type="text" id="serial_number" name="serial_number" class="formcent" value="<?php echo $serial_number; ?>" placeholder="Enter Serial Number" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                               <td style="padding: 17px;">
                                                                  <div style="padding-left: 10px;">Tyre Name:</div>
                                                                  <div class="text">
                                                                     <input type="text" id="tyre_name" name="tyre_name" class="formcent" value="<?php echo $tyre_name; ?>" placeholder="Enter tyre name" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                               <td style="padding: 17px;">
                                                                  <div style="padding-left: 10px;">Meter Reading:</div>
                                                                  <div class="text">
                                                                     <input type="text" id="meterreading" name="meterreading" class="formcent" value="<?php echo $meterreading; ?>" placeholder="Enter Meter Reading" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                            </tr>

                                                            <tr>
                                                               <td style="padding-left:17px;">
                                                                  <div style="padding-left: 10px;">Upload Date:</div>
                                                                  <div class="text">
                                                                     <input type="date" id="uploaddate" name="uploaddate" class="formcent" value="<?php echo $uploaddate; ?>" required style="border: 1px solid #368ee0;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                               <td style="padding-left:17px;">
                                                                  <div style="padding-left: 10px;">Tyre Model:</div>
                                                                  <div class="text">
                                                                     <input type="text" id="tyre_model" name="tyre_model" class="formcent" value="<?php echo $tyre_model; ?>" placeholder="Enter Tyre Model" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                               <td style="padding-left:17px;">
                                                                  <div style="padding-left: 10px;">Tyre New Image:</div>
                                                                  <div class="text">
                                                                     <!-- <input type="file" class="formcent" id="tyre_new_image" name="tyre_new_image" value="<?php echo $tyre_new_image; ?>" required autocomplete="off"> -->
                                                                     <input type="file" name="tyre_new_image" id="tyre_new_image"   
                                               class="form-control"   	data-rule-maxlength="255"   autocomplete="off">
                                               <span><img src="uploaded/tyre_img/<?php echo $tyre_new_image ?>" width="100px;" alt="" /></span>
                                                                  </div>
                                                               </td>
                                                            </tr>
                                                            <tr>

                                                               <td style="padding:17px;">
                                                                  <div style="padding-left: 10px;">Tyre Old Image:</div>
                                                                  <div class="text">
                                                                     <!-- <input type="file" class="formcent" id="tyre_old_image" name="tyre_old_image" value="<?php echo $tyre_old_image; ?>" required autocomplete="off"> -->
                                                                     <input type="file" name="tyre_old_image" id="tyre_old_image"   
                                               class="form-control"   	data-rule-maxlength="255"   autocomplete="off">
                                               <span><img src="uploaded/tyre_img/<?php echo $tyre_old_image ?>" width="100px;" alt="" /></span>
                                                                  </div>
                                                               </td>
                                                               <td style="padding:17px;">

                                                                  <div> Old Tyre Name:</div>
                                                                  <div class="text">
                                                                     <input type="text" class="formcent" id="old_tyre_name" name="old_tyre_name" value="<?php echo $old_tyre_name; ?>" placeholder="Old Tyre Name" required style="border: 1px solid #368ee0;" autocomplete="off">
                                                                  </div>

                                                               </td>
                                                               <td style="padding:17px;">
                                                                  <div style="padding-left: 10px;">Old Tyre Serial No.:</div>
                                                                  <div class="text">
                                                                     <input type="text" class="formcent" id="old_tyre_serial_no" name="old_tyre_serial_no" value="<?php echo $old_tyre_serial_no; ?>" placeholder="Old Tyre Serial No." required style="border: 1px solid #368ee0;" autocomplete="off">
                                                                  </div>
                                                               </td>
                                                            </tr>



                                                         </table>
                                                         <div class="modal-footer">
                                                            <button type="button" class="btn btn-success" onclick="getSave()" data-dismiss="modal">Submit</button>
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                         </div>
                                                      </div>

                                                      <div id="menu1" class="tab-pane fade">
                                                         <h4 style="padding-left: 10px;text-align: center;">Report</h4>
                                                         <table class="table table-hover table-nomargin  table-bordered" width="100%" style="padding: 10px;padding-bottom: 50px;">
                                                            <thead>
                                                               <tr>

                                                                  <th>Truck No.</th>
                                                                  <th>Tyre Type</th>
                                                                  <th>Serial No.</th>
                                                                  <th>Tyre Name</th>
                                                                  <th>Meter Reading</th>
                                                                  <th>Upload Date</th>
                                                                  <th>Tyre Model</th>
                                                                  <th>Tyre New Image</th>
                                                                  <th>Tyre Old Image</th>
                                                                  <th>Old Tyre Serial No.</th>
                                                                  <th>Old Tyre Name</th>
                                                                  <th>Action</th>
                                                               </tr>
                                                            </thead>
                                                            <tbody>
                                                               <?php
                                                               $slno = 1;

                                                               $sel = "select * from bill where billdate > '2017-06-30' && sessionid='$_SESSION[sessionid]' && compid='$compid' order by billid desc limit 0,100";
                                                               $res = mysqli_query($connection, $sel);
                                                               while ($row = mysqli_fetch_array($res)) {

                                                                  if ($row['ispaid'] == '0')
                                                                     $status = "<span class='red'><strong>Unpaid</strong></span>";
                                                                  else

                                                                     $status = "<span style='color: green;'><strong>Paid</strong></span>";
                                                                  $billamount = $cmn->get_total_billing_amt($connection, $row['billid']);
                                                                  $consignorname = $cmn->getvalfield($connection, "m_consignor", "consignorname", "consignorid='$row[consignorid]'");
                                                                  $consigneename =  $cmn->getvalfield($connection, "m_consignee", "consigneename", "consigneeid='$row[consigneeid]'");

                                                               ?>
                                                                  <tr tabindex="<?php echo $slno; ?>" class="abc">

                                                                     <td><?php echo $slno; ?></td>
                                                                     <td><?php echo $cmn->dateformatindia(ucfirst($row['billdate'])); ?></td>
                                                                     <td><?php echo ucfirst($row['billno']); ?></td>
                                                                     <td><?php echo ucfirst($row['consi_type']); ?></td>
                                                                     <td><?php echo $consignorname; ?></td>
                                                                     <td><?php echo $consigneename; ?></td>

                                                                     <td><?php echo $cmn->getvalfield($connection, "m_session", "session_name", "sessionid='$_SESSION[sessionid]'"); ?></td>
                                                                     <td><?php echo number_format($billamount, 2); ?></td>



                                                                     <td class='hidden-480'>
                                                                        <a href="?edit=<?php echo $row['billid']; ?>&consi_type=<?php echo $row['consi_type']; ?>"><img src="../img/b_edit.png" title="Edit"></a>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                        <?php
                                                                        if ($row['ispaid'] == '0') {
                                                                        ?>
                                                                           <a onClick="funDelotp('<?php echo $row['billid']; ?>');"><img src="../img/del.png" title="Delete"></a>
                                                                           <input type="button" class="btn btn-danger" name="add_data_list" style="display: none;" id="add_data_delete_<?php echo  $row['billid']; ?>" onClick="funDel('<?php echo $row['billid']; ?>');" value="X">
                                                                        <?php
                                                                        } ?>
                                                                        &nbsp;&nbsp;&nbsp;
                                                                        <?php if ($gstvalid == "Yes") { ?>
                                                                           <a href="pdf_nogstprint_gst_billing_demo_emami.php?p=<?php echo ucfirst($row['billid']); ?>" class="btn btn-info" target="_blank">PDF</a>
                                                                        <?php } else { ?>
                                                                           <a href="pdf_nogstprint_gst_billing_demo_emami.php?p=<?php echo ucfirst($row['billid']); ?>" class="btn btn-info" target="_blank">PDF</a>
                                                                        <?php } ?>
                                                                     </td>


                                                                  </tr>
                                                               <?php
                                                                  $slno++;
                                                               }
                                                               ?>
                                                            </tbody>
                                                         </table>
                                                      </div>

                                                   </div>

                                                </div><!--#myModal-->

                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 89px;margin-left: 15px;color: white;font-size: 13px;">1</h1>

                                             <img onclick="getmodal(1)" src="ty.png" alt="" style="height: 78px;margin-top: 81px;">
                                          </td>

                                          <td rowspan="10"><img src="body-truck.png" alt="" style="margin-left: -2px;"></td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 89px;margin-left: 15px;color: white;font-size: 13px;">2</h1>
                                             <img class="i1" onclick="getmodal(2)" src="ty.png" alt="" style="height: 78px;margin-left: -4px; margin-top: 81px;">
                                          </td>
                                          <td></td>
                                          <td>
                                             <h5 style="margin-right: 31px;padding-top: 100px;">Front Right</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <h5>Front Single Left</h5>
                                          </td>
                                          <td></td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">3</h1>
                                             <img src="ty.png" onclick="getmodal(3)" alt="" style="height: 78px;">
                                          </td>
                                          <!-- <td>  <div class="rectangle"> </div> </td> -->
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">4</h1>
                                             <img class="i1" onclick="getmodal(4)" src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td></td>
                                          <td>
                                             <h5>Front Single Right</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <h5>Lefter Left 1 <br>Lefter Left 2</h5>
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">5</h1>
                                             <img src="2t.png" onclick="getmodal(5)" alt="" style="height: 78px;margin-right: -7px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">6</h1>
                                             <img src="ty.png" onclick="getmodal(6)" alt="" style="height: 78px;">
                                          </td>
                                          <!-- <td>  <div class="rectangle"> </div> </td> -->
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">7</h1>
                                             <img class="i1" onclick="getmodal(7)" src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">8</h1>
                                             <img class="i1" onclick="getmodal(8)" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td>
                                             <h5 style="margin-left: 16px;">Lefter Right 1 <br>Lefter Right 2</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <h5>Crown Left 1 <br> Crown Left 2</h5>
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">9</h1>
                                             <img src="2t.png" onclick="getmodal(9)" alt="" style="height: 78px;margin-right: -7px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">10</h1>
                                             <img src="ty.png" onclick="getmodal(10)" alt="" style="height: 78px;">
                                          </td>
                                          <!-- <td>  <div class="rectangle"> </div> </td> -->
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">11</h1>
                                             <img class="i1" onclick="getmodal(11)" src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">12</h1>
                                             <img class="i1" onclick="getmodal(12)" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td>
                                             <h5 style="margin-left: 16px;">Crown Right 1 <br> Crown Right 2</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <h5>Dumy Left 1 <br>Dumy Left 2</h5>
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 3px;color: white;font-size: 13px;">13</h1>
                                             <img src="2t.png" onclick="getmodal(13)" alt="" style="height: 78px;margin-right: -7px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">14</h1>
                                             <img src="ty.png" onclick="getmodal(14)" alt="" style="height: 78px;">
                                          </td>
                                          <!-- <td>  <div class="rectangle"> </div> </td> -->
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">15</h1>
                                             <img class="i1" onclick="getmodal(15)" src="ty.png" alt="" style="height: 78px; margin-left: -4px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">16</h1>
                                             <img class="i1" onclick="getmodal(16)" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td>
                                             <h5 style="margin-left: 16px;">Dumy Right 1 <br>Dumy Right 2</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <h5>Dumy Left 1 <br>Dumy Left 2</h5>
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 3px;color: white;font-size: 13px;">17</h1>
                                             <img src="2t.png" onclick="getmodal(17)" alt="" style="height: 78px;margin-right: -7px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">18</h1>
                                             <img src="ty.png" onclick="getmodal(18)" alt="" style="height: 78px;">
                                          </td>
                                          <!-- <td>  <div class="rectangle"> </div> </td> -->
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">19</h1>
                                             <img class="i1" onclick="getmodal(20)" src="ty.png" alt="" style="height: 78px; margin-left: -4px;">
                                          </td>
                                          <td style="cursor: pointer;">
                                             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">20</h1>
                                             <img class="i1" onclick="getmodal(21)" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
                                          </td>
                                          <td>
                                             <h5 style="margin-left: 16px;">Dumy Right 1 <br>Dumy Right 2</h5>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                       </tr>
                                       <tr>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td><img src="tyer.png" alt="" style="height: 119px;margin-left: 88px;position: absolute;margin-top: -129px;cursor: pointer;"></td>
                                          <td></td>
                                       </tr>
                                    </thead>
                                 </table>
                              </div>
                           </div>

                        <?php }
                        ?>

                        <script type="text/javascript">
                           function getmodal(id) {
                              alert(id);
                              id = $("#id").val(id);


                              $('#myModal').modal('show');


                           };


                           function getdetail() {
                              var truckid = document.getElementById('truckid').value;
                              //alert(bid_id);	
                              if (truckid != '') {
                                 window.location.href = '?truckid=' + truckid;
                              }
                           }
                           
                           function getSave() {
                              // alert(id);
                              var typos = document.getElementById("id").value;
                              // alert(typos);
                              var truckid = document.getElementById("truckid").value;

                              var serial_number = document.getElementById("serial_number").value;
                              var tyre_name = document.getElementById("tyre_name").value;
                              var meterreading = document.getElementById("meterreading").value;


                              var uploaddate = document.getElementById("uploaddate").value;
                              var tyre_model = document.getElementById("tyre_model").value;
                              var tyre_new_image = document.getElementById("tyre_new_image").value;


                              var tyre_old_image = document.getElementById("tyre_old_image").value;
                              var old_tyre_name = document.getElementById("old_tyre_name").value;
                              var old_tyre_serial_no = document.getElementById("old_tyre_serial_no").value;
                              var mapid = 0;




                              jQuery.ajax({
                                 type: 'POST',
                                 url: 'tyre_issue_entry.php',
                                 data: 'truckid=' + truckid + '&typos=' + typos + '&serial_number=' + serial_number + '&tyre_name=' + tyre_name +
                                    '&meterreading=' + meterreading + '&uploaddate=' + uploaddate + '&tyre_model=' + tyre_model + '&tyre_new_image=' + tyre_new_image +
                                    '&tyre_old_image=' + tyre_old_image + '&old_tyre_name=' + old_tyre_name+ '&old_tyre_serial_no=' + old_tyre_serial_no+ '&mapid=' + mapid,
                                 success: function(data) {

                                     alert(data);
                                    // if (data == 1) {
                                    //    alert("Data Already Exist");
                                    // }
                                    // showrecord(<?php echo $keyvalue; ?>);
                                    // jQuery('#itemid').val('');
                                    // jQuery("#qty").val('');
                                    // jQuery("#serial_no").val('');
                                    // jQuery("#hsncode").val('');
                                    // jQuery("#rate").val('');

                                    // jQuery("#total_amt").val('');
                                    // jQuery("#nettotal").val('');
                                    // $("#gst").select2().select2('val', '');
                                    // $("#itemid").select2().select2('val', '');


                                 }
                              });
                           }
                         
                        </script>

</html>
<?php
mysqli_close($connection);
?>