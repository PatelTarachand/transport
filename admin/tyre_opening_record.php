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

//  if (isset($_POST['typos'])) {
//    $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
//    $rowedit = mysqli_fetch_array(mysqli_query($connection, $sqledit));

//  $serial_number=$rowedit['serial_number'];
//  $tyre_name=$rowedit['tyre_name'];
//  $meterreading=$rowedit['meterreading'];
//  $uploaddate=$rowedit['uploaddate'];  
//  $tyre_model = $rowedit['tyre_model'];
//   $tyre_new_image=$_FILES['tyre_new_image'];
//  // print_r($tyre_new_image);
//  $tyre_old_image=$_FILES['tyre_old_image'];
//   $old_tyre_name=$rowedit['old_tyre_name'];
//   $old_tyre_serial_no=$rowedit['old_tyre_serial_no'];

//  }

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

   .modal-backdrop{
      background-color: transparent !important;
      z-index: -1 !important;
   }
   .modal.fade{
      transition: none;
   }
   /* .modal-backdrop, .modal-backdrop.fade.in{
      opacity: 0 !important;
   } */
</style>

<body >
   
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

                   
 <div class="control-group">
                           <table class="table table-condensed">
                              <tr>
                                 <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                              </tr>

                              <tr>
                                 <td width="20%"><strong>Truck No </strong><strong>:</strong><span class="red">*</span></td>

                              </tr>
                              <tr>
                           

                              <input type="hidden" id="id" name="typos" class="formcent">
                                <td><select id="truckid" name="truckid" style="width:200px;" class="select2-me"  onchange ="gettruckno();">

                                        	<option value="" selected>-Select-</option>

                                            <?php 

											$sql3 = "select A.* from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by truckno";

											$res3 = mysqli_query($connection,$sql3);

											while($row3 = mysqli_fetch_assoc($res3))

												{

											?>

                                          	<option value="<?php echo $row3['truckid']; ?>"><?php echo $row3['truckno']; ?></option>

                                            <?php

												}

												?>

                                      </select>

							      <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script></td>

                              </tr>




                           </table>
                        </div>

                      <div class="col-sm-12">                         
<!-- tire images -->
<center>
<div class="container-fluid">
<table id="table10">
   <thead>
      <tr>
         <td>
            <h5 style="margin-left: 38px;padding-top: 37px;">Front Left</h5>
         </td>
         <td>

         
        
 
</div>
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Front Left')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">1</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(1);" src="ty.png" alt="" style="height: 110px;">
         </td>
         <td rowspan="6"><img src="body-truck.png" alt="" style="margin-left: -2px;"></td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Front Right')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 25px;color: white;font-size: 13px;">2</h1>
            <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(2);"src="ty.png" alt="" style="height: 110px;margin-left: -4px;">
         </td>
         <td></td>
         <td>
            <h5 style="margin-left: 20px;padding-top: 37px;">Front Right</h5>
         </td>
      </tr>
      <tr>
         <td>
            <h5 style="margin-left: 22px;padding-top: 37px;">Crown Left 1 <br> Crown Left 2</h5>
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Crown Left 1')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">3</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(3);" src="2t.png" alt="" style="height: 110px;margin-right: -7px;">
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Crown Left 2')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">4</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(4);" src="ty.png" alt="" style="height: 110px;">
         </td>
         <!-- <td>  <div class="rectangle"> </div> </td> -->
         <td style="cursor: pointer;" onclick="tireOpeningModal('Crown Right 1')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 21px;color: white;font-size: 13px;">5</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(5);"class="i1" src="ty.png" alt="" style="height: 110px;margin-left: -4px;">
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Crown Right 2')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">6</h1>
            <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(6);"src="2t.png" alt="" style="height: 110px;margin-left: -4px;">
         </td>
         <td>
            <h5 style="margin-left: 26px;padding-top: 37px;">Crown Right 1 <br> Crown Right 2</h5>
         </td>
      </tr>
      <tr>
         <td>
            <h5 style="margin-left: 39px;padding-top: 37px;">Dumy  Left 1 <br> Dumy Left 2</h5>
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Dumy  Left 1')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">7</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(7);"src="2t.png" alt="" style="height: 110px;margin-right: -7px;">
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Dumy  Left 2')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">8</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(8);"src="ty.png" alt="" style="height: 110px;">
         </td>
         <!-- <td>  <div class="rectangle"> </div> </td> -->
         <td style="cursor: pointer;" onclick="tireOpeningModal('Dumy Right 1')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 22px;color: white;font-size: 13px;">9</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(9);"class="i1" src="ty.png" alt="" style="height: 110px; margin-left: -4px;">
         </td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Dumy Right 2')">
            <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 8px;color: white;font-size: 13px;">10</h1>
            <img onclick="jQuery('#mymodal').modal('show');getmodal(10);" class="i1" src="2t.png" alt="" style="height: 110px;margin-left: -4px;">
         </td>
         <td>
            <h5 style="margin-left: 26px;padding-top: 37px;">Dumy Right 1 <br>Dumy Right 2</h5>
         </td>
      </tr>
      <tr>
         <td></td>
         <td></td>
         <td style="cursor: pointer;" onclick="tireOpeningModal('Stepney')"><img src="{{ asset('storage/app/public/tire/tyer.png') }}" alt="" style="height: 119px;margin-left: 141px;position: absolute;margin-top: -124px;"></td>
         <td></td>
         <td></td>
      </tr>
   </thead>
</table>


<table id="table12">
    <thead>
       <tr>
          <td>
             <h5 style="margin-left: 54px;padding-top: 37px;">Front Left</h5>
          </td>
          <td>  
 
</div></td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;margin-top: 35px;">1</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(1);"src="ty.png" alt="" style="height: 110px;margin-top: 35px;">
          </td>
          <td rowspan="8"><img src="body-truck.png" alt="" style="margin-left: -2px;"></td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 25px;color: white;font-size: 13px;margin-top: 35px;">2</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(2);" class="i1" src="ty.png" alt="" style="height: 110px;margin-left: -4px;margin-top: 35px;"">
          </td>
          <td></td>
          <td>
             <h5 style="margin-right: 31px;padding-top: 37px;">Front Right</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;padding-top: 37px;">Lefter Left</h5>
          </td>
          <td></td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">3</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(3);" src="ty.png" alt="" style="height: 110px;">
          </td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 21px;color: white;font-size: 13px;">4</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(4);"class="i1" src="ty.png" alt="" style="height: 110px;margin-left: -4px;">
          </td>
          <td></td>
          <td>
             <h5 style="margin-right: 31px;padding-top: 37px;">Lefter Right</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;padding-top: 37px;">Crown Left 1 <br>Crown Left 2</h5>
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">5</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(5);" src="2t.png" alt="" style="height: 110px;margin-right: -7px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">6</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(6);" src="ty.png" alt="" style="height: 110px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 21px;color: white;font-size: 13px;">7</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(7);" class="i1" src="ty.png" alt="" style="height: 110px;margin-left: -4px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">8</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(8);"class="i1" src="2t.png" alt="" style="height: 110px;margin-left: -4px;">
          </td>
          <td>
             <h5 style="margin-right: 31px;padding-top: 37px;">Crown Right 1 <br>Crown Right 2</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;padding-top: 37px;">Dumy Left 1 <br> Dumy Left 2</h5>
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">9</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(9);" src="2t.png" alt="" style="height: 110px;margin-right: -7px;">
          </td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;">10</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(10);"src="ty.png" alt="" style="height: 110px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 22px;color: white;font-size: 13px;">11</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(11);"class="i1" src="ty.png" alt="" style="height: 110px; margin-left: -4px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 8px;color: white;font-size: 13px;">12</h1>
             <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(12);" src="2t.png" alt="" style="height: 110px;margin-left: -4px;">
          </td>
          <td>
             <h5 style="margin-right: 31px;padding-top: 37px;">Dumy Right 1 <br> Dumy Left 2</h5>
          </td>
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
          <td style="cursor: pointer;"><img src="{{ asset('storage/app/public/tire/tyer.png') }}" alt="" style="height: 116px;margin-left: 143px;position: absolute;margin-top: -125px;"></td>
          <td></td>
       </tr>
    </thead>
 </table>


 <table id="table14">
    <thead>
       <tr>
          <td>
             <h5 style="margin-left: 54px;padding-top: 100px;">Front Left</h5>
          </td>
          <td>
 
</div></td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 10px;color: white;font-size: 13px;margin-top: 58px;">1</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(1);" src="ty.png" alt="" style="height: 78px;margin-top: 58px;">
          </td>
          <td rowspan="8"><img src="body-truck.png" alt="" style="margin-left: -2px;"></td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 27px;margin-left: 15px;color: white;font-size: 13px;margin-top: 58px;">2</h1>
             <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(2);" src="ty.png" alt="" style="height: 78px;margin-left: -4px;margin-top: 58px;"">
          </td>
          <td></td>
          <td>
             <h5 style="margin-right: 31px;padding-top: 100px;">Front Right</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;">Front Single Left</h5>
          </td>
          <td></td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 10px;color: white;font-size: 13px;">3</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(3);" src="ty.png" alt="" style="height: 78px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">4</h1>
             <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(4);" src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
          </td>
          <td></td>
          <td>
             <h5 style="margin-right: 31px;">Front Single Right</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;">Lefter Left</h5>
          </td>
          <td></td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 10px;color: white;font-size: 13px;">5</h1>
             <img src="ty.png" onclick="jQuery('#mymodal').modal('show');getmodal(5);" alt="" style="height: 78px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">6</h1>
             <img class="i1"onclick="jQuery('#mymodal').modal('show');getmodal(6);"  src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
          </td>
          <td></td>
          <td>
             <h5 style="margin-right: 31px;">Lefter Right</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;">Crown Left 1 <br>Crown Left 2</h5>
          </td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">7</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(7);" src="2t.png" alt="" style="height: 78px;margin-right: -7px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">8</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(8);" src="ty.png" alt="" style="height: 78px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">9</h1>
             <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(9);"src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">10</h1>
             <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(10);" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
          </td>
          <td>
             <h5 style="margin-right: 31px;margin-left: 20px;">Crown Right 1 <br>Crown Right 2</h5>
          </td>
       </tr>
       <tr>
          <td>
             <h5 style="margin-left: 54px;">Dumy Left 1 <br>Dumy Left 2</h5>
          </td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">11</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(11);" src="2t.png" alt="" style="height: 78px;margin-right: -7px;">
          </td>
          <td style="cursor: pointer;">
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">12</h1>
             <img onclick="jQuery('#mymodal').modal('show');getmodal(12);" src="ty.png" alt="" style="height: 78px;">
          </td>
          <!-- <td>  <div class="rectangle"> </div> </td> -->
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 11px;color: white;font-size: 13px;">13</h1>
             <img class="i1"onclick="jQuery('#mymodal').modal('show');getmodal(13);"  src="ty.png" alt="" style="height: 78px; margin-left: -4px;">
          </td>
          <td style="cursor: pointer;" >
             <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">14</h1>
             <img class="i1"onclick="jQuery('#mymodal').modal('show');getmodal(14);"  src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
          </td>
          <td>
             <h5 style="margin-right: 31px; margin-left: 20px;">Dumy Right 1 <br> Dumy Right 2</h5>
          </td>
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
          <td style="cursor: pointer;" onclick="tireOpeningModal('Stepney')"><img src="tyer.png" alt="" style="height: 116px;margin-left: 127px;position: absolute;margin-top: -129px;"></td>
          <td></td>
       </tr>
    </thead>
    </table>


    <table id="table16">
        <thead>
           <tr>
              <td>
                 <h5 style="margin-right: 31px;padding-top: 100px;">Front Left</h5>
              </td>
              <td>
 
</div></td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 89px;margin-left: 10px;color: white;font-size: 13px;">1</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(1);" src="ty.png" alt="" style="height: 78px;margin-top: 81px;">
              </td>
              <td rowspan="10"><img src="body-truck.png" alt="" style="margin-left: -2px;"></td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 89px;margin-left: 15px;color: white;font-size: 13px;">2</h1>
                 <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(2);" src="ty.png" alt="" style="height: 78px;margin-left: -4px; margin-top: 81px;">
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
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 10px;color: white;font-size: 13px;">3</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(3);" src="ty.png" alt="" style="height: 78px;">
              </td>
              <!-- <td>  <div class="rectangle"> </div> </td> -->
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">4</h1>
                 <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(4);"src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
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
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">5</h1>
                 <img src="2t.png" onclick="jQuery('#mymodal').modal('show');getmodal(5);"alt="" style="height: 78px;margin-right: -7px;">
              </td>
              <td style="cursor: pointer;">
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">6</h1>
                 <img src="ty.png"onclick="jQuery('#mymodal').modal('show');getmodal(6);"  alt="" style="height: 78px;">
              </td>
              <!-- <td>  <div class="rectangle"> </div> </td> -->
              <td style="cursor: pointer;">
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 15px;color: white;font-size: 13px;">7</h1>
                 <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(7);"src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
              </td>
              <td style="cursor: pointer;">
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">8</h1>
                 <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(8);" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
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
                 <img src="2t.png" onclick="jQuery('#mymodal').modal('show');getmodal(9);" alt="" style="height: 78px;margin-right: -7px;">
              </td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">10</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(10);" src="ty.png" alt="" style="height: 78px;">
              </td>
              <!-- <td>  <div class="rectangle"> </div> </td> -->
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 12px;color: white;font-size: 13px;">11</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(11);"  class="i1" src="ty.png" alt="" style="height: 78px;margin-left: -4px;">
              </td>
              <td style="cursor: pointer;">
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">12</h1>
                 <img class="i1" onclick="jQuery('#mymodal').modal('show');getmodal(12);" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
              </td>
              <td>
                 <h5 style="margin-left: 16px;">Crown Right 1 <br> Crown Right 2</h5>
              </td>
           </tr>
           <tr>
              <td>
                 <h5>Dumy Left 1 <br>Dumy Left 2</h5>
              </td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 3px;color: white;font-size: 13px;">13</h1>
                 <img src="2t.png" onclick="jQuery('#mymodal').modal('show');getmodal(13);" alt="" style="height: 78px;margin-right: -7px;">
              </td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 5px;color: white;font-size: 13px;">14</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(14);" src="ty.png" alt="" style="height: 78px;">
              </td>
              <!-- <td>  <div class="rectangle"> </div> </td> -->
              <td style="cursor: pointer;">
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 8px;color: white;font-size: 13px;">15</h1>
                 <img onclick="jQuery('#mymodal').modal('show');getmodal(15);"class="i1" src="ty.png" alt="" style="height: 78px; margin-left: -4px;">
              </td>
              <td style="cursor: pointer;" >
                 <h1 style="z-index: 1;position: absolute; padding-top: 5px;margin-left: 1px;color: white;font-size: 13px;">16</h1>
                 <img class="i1"onclick="jQuery('#mymodal').modal('show');getmodal(16);" src="2t.png" alt="" style="height: 78px;margin-left: -4px;">
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
 </center>
    
    
         </div>
      </div>
      <div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
                                                <div class="modal-header">
                                             
                                                   
<div id="updatedata"></div>

                                                </div>
 

   <script type="text/javascript">
      function getmodal(id) {
      
         var truckid = document.getElementById('truckid').value;

         jQuery.ajax({
          type: 'POST',
          url: 'save_modal.php',
          data: "id="+id+ '&truckid=' + truckid,
          dataType: 'html',
          success: function(data){  
         //  alert(data);     
       $('#myModal').modal('show');
       $("#updatedata").html(data);
      //  $('#mymodal').modal('show');
      //  $("#updatedata1").html(data);
      //  $('#mymodal').modal('show');
   
      //  $("#updatedata2").html(data);
      //  $('#mymodal').modal('show');
      //  $("#updatedata3").html(data);

            }
          });//ajax close

         // $('#myModal').modal('show');


      }
      function getissue(){
         var issue_cate = document.getElementById('issue_cate').value;
         var itemid = document.getElementById('itemid').value;
   //  alert(issue_cate);
    $.ajax({
         type: 'POST',
         url: 'show_items.php',
         data: 'issue_cate='+issue_cate+'&itemid='+itemid,
         dataType: 'html',
         success: function(data){
            // alert(data);
                jQuery('#pos_id').html(data);
            
 
 
         
         }
      });//ajax close	
 
    }
   //    function getadv(dispatch_id){  
   //              // alert(dispatch_id);
   //        jQuery.ajax({
   //        type: 'POST',
   //        url: 'ajax/adv_details.php',
   //        data: "dispatch_id="+dispatch_id,
   //        dataType: 'html',
   //        success: function(data){  
   //        // alert(data);     
   //      jQuery("#updatedata").html(data);
   //          }
   //        });//ajax close
   //  }


      function getdetail() {
         var truckid = document.getElementById('truckid').value;
         //alert(bid_id);	
         if (truckid != '') {
            window.location.href = '?truckid=' + truckid;
         }
      }


		
    function gettruckno(){
      var truckid = document.getElementById('truckid').value.trim();
        $("#table10").hide();
        $("#table12").hide();
        $("#table14").hide();
        $("#table16").hide();
         //  alert("okk");
       $.ajax({
           type:'GET',
           url:'getTyreType.php',
             data: 'truckid='+truckid,
			  dataType: 'html',
           success:function(data){
            //   console.log(res);
               // alert(data);
              if(data==10){
                $("#table10").show();
              }
              if(data==12){
                $("#table12").show();
              }
              if(data==14){
                $("#table14").show();
              }
               if(data==16){
                  
                $("#table16").show();
               }
            // $("#tyre_type").html(res);
            // $("#tyre_type").val(@php echo $tyre_type; @endphp);
            // $("#tyre_type").trigger('change'); 
           }
       });
    }  
    $("#table10").hide();
    $("#table12").hide();
    $("#table14").hide();
    $("#table16").hide();

   </script>

</html>
