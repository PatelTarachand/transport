<?php
include("dbconnect.php");
$tblname = "purchaseentry";
$tblpkey = "purchaseid";
$pagename = "purchase_entry.php";
$modulename = "Purchase Entry";
$purchase_date = date('Y-m-d');

if (isset($_REQUEST['action']))
   $action = $_REQUEST['action'];
else
   $action = 0;
if (isset($_GET['purchaseid'])) {
   $keyvalue = $_GET['purchaseid'];
   $otp = $_GET['otp'];
   $realotp =  $cmn->getvalfield($connection, "purchaseentry", "otp", "purchaseid='$keyvalue'");

   if ($realotp != $otp) {
      die("OTP Mismatch");
   }
} else
   $keyvalue = 0;
if (isset($_POST['submit'])) {
   //	echo 'ok';
   $purchaseid = trim(addslashes($_POST['purchaseid']));
   $billno = trim(addslashes($_POST['billno']));
   $purchase_date = $_POST['purchase_date'];
   $supplier_id = $_POST['supplier_id'];
   $purchase_type = $_POST['purchase_type'];
   $remark = $_POST['remark'];


   if ($purchaseid == 0) {


   	mysqli_query($connection,"INSERT into purchaseentry set purchase_date='$purchase_date',supplier_id='$supplier_id',billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate',compid='$compid'");

      $action = 1;
      $process = "insert";
      $keyvalue = mysqli_insert_id($connection);
      mysqli_query($connection, "update purchasentry_detail set purchaseid='$keyvalue' where purchaseid='0'");
   } else {



   mysqli_query($connection,"update  purchaseentry set purchase_date='$purchase_date',supplier_id='$supplier_id',billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate',compid='$compid' WHERE $tblpkey = '$keyvalue'");

      $action = 2;
      $process = "updated";
   }



   echo "<script>location='$pagename?action=$action'</script>";
}
if (isset($_GET[$tblpkey])) {
   $btn_name = "Update";

   $sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
   $rowedit = mysqli_fetch_array(mysqli_query($connection, $sqledit));
   $purchaseid =$rowedit['purchaseid'];
   $billno = $rowedit['billno'];
   $purchase_date = $rowedit['purchase_date'];
   $supplier_id = $rowedit['supplier_id'];
   $purchase_type = $rowedit['purchase_type'];
   $remark = $rowedit['remark'];

} else {
   $purchase_date = date('Y-m-d');
   $transport_date = date('Y-m-d');
   $billno  = '';
   $purchase_type  = '';
   $supplier_id  = '';
   $remark  = '';


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
                        <a href="purchase_report.php" class="btn btn-success" style="float:right;">View Detail</a>
                        <?php include("../include/page_header.php"); ?>
                     </div>

                     <form id='purchase_entry' method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('compid,supplier_id,billno,purchase_date,purchase_type,remark')">
                        <div class="control-group" style="border:2px double #CCC">
                           <table class="table table-condensed">
                              <tr>
                                 <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                              </tr>

                              <tr>
                                 <th width="20%"> Date </th>
                                 <th width="20%"> Supplier Name </th>
                                 <th width="20%"> Bill No </th>

                                 <th width="20%" class="head0">Payment Type</th>

                                 <th width="20%"> Remark </th>
                              </tr>
                              <tr>
                                 <input type="hidden" name="purchaseid" id="purchaseid" class="input-xxlarge" style="width:30px;" tabindex="1" value="<?php echo $purchaseid; ?>" autofocus autocomplete="off" />

                                 <td><input type="date" name="purchase_date" id="purchase_date" class="input-xxlarge" style="width:95%" autofocus autocomplete="off" tabindex="2" value="<?php echo $purchase_date; ?>" /> </td>

                                 <td>
                                    <select data-placeholder="Choose a Country..." name="supplier_id" id="supplier_id" style="width:200px" tabindex="3" class="formcent select2-me" required>
                                       <option value="">Select </option>
                                       <?php
                                       $sql = mysqli_query($connection, "select * from  supplier_master order by supplier_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['supplier_id']; ?>"><?php echo $row['supplier_name']; ?></option>

                                       <?php } ?>
                                       <script>
                                          document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>';
                                       </script>

                                 </td>
                                 <td><input type="text" name="billno" id="billno" style="width:195px;" value="<?php echo $billno; ?>" autocomplete="off" maxlength="120" class="input-medium" required ></td>

                                 <td> <select data-placeholder="Choose Payment Type..." name="purchase_type" id="purchase_type" class="chzn-select" tabindex="5" style="width:180px;">
                                       <option value="">Select</option>
                                       <option value="Cash">Cash</option>
                                       <option value="Credit">Credit</option>

                                    </select>
                                    <script>
                                       document.getElementById('purchase_type').value = '<?php echo $purchase_type; ?>';
                                    </script>
                                 </td>
                                 <td><input type="text" name="remark" id="remark" class="input-xxlarge" style="width:95%" tabindex="6" value="<?php echo $remark; ?>" autofocus autocomplete="off" /> </td>

                              </tr>



                              </tr>
                           </table>
                        </div>


                        <!--   DTata tables -->
                        <div class="row-fluid">
                           <div class="span12">
                              <div class="alert alert-success" style="border:3px double #999">
                                 <table width="100%" class="table table-bordered table-condensed">
                                    <tr>
                                       <th width="25%" class="head0">Item</th>
                                       <!-- <th width="25%" class="head0 nosort">Unit</th> -->

                                       <th width="25%" class="head0 nosort">Qty</th>

                                       <th width="25%" class="head0">Rate</th>
                                       <th width="25%" class="head0">Total Amount</th>
                                       <!-- <th width="6%" class="head0">Bhara</th> -->



                                       <th width="8%" class="head0">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       </span>
                                       <tr>
                                          <td>
                                             <select data-placeholder="Choose a Country..." name="item_id" id="item_id" style="width:200px" tabindex="7" class="formcent select2-me" >
                                                <option value="">Select </option>
                                                <?php
                                                $sql = mysqli_query($connection, "select * from   item_master order by itemcategoryname");
                                                while ($row = mysqli_fetch_array($sql)) {

                                                ?>
                                                   <option value="<?php echo $row['item_id']; ?>"><?php echo $row['itemcategoryname']; ?></option>

                                                <?php } ?>
                                                <script>
                                                   document.getElementById('item_id').value = '<?php echo $item_id; ?>';
                                                </script>

                                          </td>
                                          <!-- <td>

                           <select  data-placeholder="Choose a Country..." name="unit_id" id="unit_id" style="width:200px" tabindex="3" class="formcent select2-me" required>
											<option value="">Select Unit</option>
											<?php
                                 $sql = mysqli_query($connection, "select * from unit_master order by unit_name");
                                 while ($row = mysqli_fetch_array($sql)) {

                                 ?>
												<option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
												
											<?php } ?>
											<script>
												document.getElementById('unit_id').value = '<?php echo $unit_id; ?>';
											</script>
                           </td> -->
                                          <input type="hidden" name="unit_id" id="unit_id" class="input-xxlarge" style="width:30px;" value="<?php echo $unit_id; ?>" tabindex="8" autofocus autocomplete="off" />

                                          <td><input type="text" name="qty" id="qty" tabindex="9" class="input-xxlarge" style="width:80%;" onChange="getdel();" value="<?php echo $qty; ?>" autofocus autocomplete="off" /> </td>
                                          <td><input type="text" name="rate" id="rate" tabindex="10" class="input-xxlarge" style="width:80%;" onChange="getdel();" value="<?php echo $rate; ?>" autofocus autocomplete="off" /> </td>






                                          <td><input type="text" name="total_amt" id="total_amt" class="input-xxlarge" style="width:150px;" tabindex="11" value="<?php echo $total_amt; ?>" onChange="getdel();" autofocus autocomplete="off" /> </td>
                                       <input type="hidden" name="purchaseid" id="purchaseid" class="form-control text-red"  value="<?php echo $keyvalue;?>"  style="font-weight:bold;"  autocomplete="off">



                                          <td> <a class="btn btn-primary" onClick="getSave();" tabindex="12">
                                                ADD</a>



                                          </td>

                                          <input type="hidden" name="purchaseid1" id="purchaseid1" value="<?php echo $keyvalue; ?>">
                                       </tr>
                                 </table>
                              </div>
                           </div>

                           <div class="row-fluid">
                              <div class="span12">
                                 <h4 class="widgettitle nomargin"> <span style="color:#00F;"> Purchase  Details : <span id="inentryno"> </span>

                                    </span></h4>


                                 <div class="widgetcontent bordered" id="showsalerecord">

                                 </div><!--widgetcontent-->
                                <br>
                              <center> <button type="submit" name="submit" class="btn btn-primary">
                        Submit</button>
               <!-- <button href="issueentry.php" class="btn btn-success">Reset</button> -->

           
                  </center>  </div>

                              <!--span8-->


                           </div>
                        </div>

                     </form>

                  </div>
               </div>
            </div>



         </div>

         <div id="modal-sn" class="modal fade" role="dialog">
            <div class="modal-dialog">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                     <h4 class="modal-title" id="myModalLabel">Verify OTP</h4>
                  </div>
                  <!-- /.modal-header -->
                  <div class="modal-body" id="serialbody">
                     <p>
                        Enter OTP : <input type="text" id="otp" value="" class="input-large">
                     </p>
                  </div>
                  <!-- /.modal-body -->
                  <div class="modal-footer">
                     <input type="hidden" id="m_purchaseid" value="">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary" onClick="checkotp();">Check</button>
                  </div>
                  <!-- /.modal-footer -->
               </div>
               <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
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
         jQuery.ajax({
            type: 'POST',
            url: 'show_purchaseentry.php',
            data: 'purchaseid=' + purchaseid,
            success: function(data) {
               // alert(data);
               jQuery("#showsalerecord").html(data);

            }
         }); //ajax close


      }



      function getproductdetail(itemid) {
         var itemid = jQuery("#itemid").val();
         if (!isNaN(itemid)) {
            jQuery.ajax({
               type: 'POST',
               url: 'ajaxgetproductdetail.php',
               data: 'itemid=' + itemid + '&process=' + 'purchase',
               dataType: 'html',
               success: function(data) {
                  //alert(data);

                  arr = data.split('|');

                  unit_name = arr[0];
                  rate = arr[1];
                  //	tax_id=arr[3].trim();
                  //tax=arr[4].trim();
                  //jQuery('#tax_type').val('exc');
                  //jQuery('#unitid').val(unitid);						
                  jQuery('#unit_name').val(unit_name);
                  jQuery('#rate').val(rate);
                  //jQuery('#tax_id').val(tax_id);
                  //jQuery('#tax').val(tax);
                  jQuery('#qty').focus();

               }

            }); //ajax close
         }
      }


      function getdel() {

         var qty = document.getElementById("qty").value;
         var rate = document.getElementById("rate").value;

         var total_amt = document.getElementById("total_amt").value;

         if (qty != "" && !isNaN(rate)) {

            var total = qty * rate;
            jQuery('#total_amt').val(total);
         }

      }
      function funDel(id)
{    
	  //alert(id);   
     tblname = 'purchasentry_detail';
	   tblpkey = 'purdetail_id';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 alert(data);
			 // alert('Data Deleted Successfully');
			//   location=pagename+'?action=10';
           showrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close

      function getSave() {

         var item_id = document.getElementById("item_id").value;
         var unit_id = document.getElementById("unit_id").value;


         var qty = document.getElementById("qty").value;
         var rate = document.getElementById("rate").value;

         var purchaseid = '<?php echo $keyvalue; ?>';
         var purdetail_id = 0;
// alert(purchaseid);

         var total_amt = document.getElementById("total_amt").value;
         //  alert(total_amt);


           
            jQuery.ajax({
               type: 'POST',
               url: 'ajax_purchase_entry.php',
               data: 'item_id=' + item_id + '&unit_id=' + unit_id + '&qty=' + qty + '&rate=' + rate + '&total_amt=' + total_amt + '&purchaseid=' + purchaseid + '&purdetail_id=' + purdetail_id,
               success: function(data) {
             
                  // alert(data);
                  showrecord(<?php echo $keyvalue; ?>);
                  jQuery('#item_id').val('');
                  jQuery("#qty").val('');
                  jQuery("#rate").val('');

                  jQuery("#total_amt").val('');

                  $("#item_id").select2().select2('val', '');


               }
            });
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
   </script>
</body>

</html>
<?php
mysqli_close($connection);
?>