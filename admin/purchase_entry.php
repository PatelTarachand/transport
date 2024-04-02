<?php
error_reporting(0);
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
  $keyvalue = $_GET['purchaseid'];

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
   	// echo 'ok';
   $purchaseid = trim(addslashes($_POST['purchaseid']));
   $sup_id = trim(addslashes($_POST['sup_id']));
   $purchase_date = $_POST['purchase_date'];
   $bill_type = $_POST['bill_type'];
   $billno = $_POST['billno'];
   $purchase_type = $_POST['purchase_type'];
   $remark = $_POST['remark'];
   $purchase_type = $_POST['purchase_type'];


   if ($purchaseid == 0) {

// echo "INSERT into purchaseentry set purchase_date='$purchase_date',sup_id='$sup_id',bill_type='$bill_type', billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate'";die;
   	mysqli_query($connection,"INSERT into purchaseentry set purchase_date='$purchase_date',sup_id='$sup_id',bill_type='$bill_type', billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate'");

      $action = 1;
      $process = "insert";
      $keyvalue = mysqli_insert_id($connection);
      mysqli_query($connection, "update purchasentry_detail set purchaseid='$keyvalue' where purchaseid='0'");
	mysqli_query($connection,"update purchaseorderserial set purchaseid='$keyvalue' where purchaseid='0'");
   $totalamt = $cmn->gettotalpurchase($connection, $keyvalue);
//   echo "INSERT into purchase_trans set  sup_id='$sup_id',transdate='$purchase_date',pamount='$totalamt',transtype='debit',purticular='purchase',bill_id='$keyvalue'";die;
   mysqli_query($connection, "INSERT into purchase_trans set  sup_id='$sup_id',transdate='$purchase_date',pamount='$totalamt',transtype='debit',purticular='purchase',bill_id='$keyvalue'");


   } else {


// echo "update purchaseentry set purchase_date='$purchase_date',sup_id='$sup_id',bill_type='$bill_type', billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate' WHERE $tblpkey = '$keyvalue'";die;
   mysqli_query($connection,"update purchaseentry set purchase_date='$purchase_date',sup_id='$sup_id',bill_type='$bill_type', billno='$billno',remark='$remark',purchase_type='$purchase_type',sessionid='$sessionid',createdby='$createdby',ipaddress='$ipaddress',lastupdated='$lastupdated',createdate='$createdate' WHERE $tblpkey = '$keyvalue'");
   $totalamt = $cmn->gettotalpurchase($connection, $keyvalue);
      $action = 2;
      $process = "updated";

      // echo "UPDATE purchase_trans set  sup_id='$sup_id',transdate='$purchase_date',pamount='$totalamt',transtype='debit',purticular='purchase',bill_id='$keyvalue' where bill_id='$keyvalue'";die;
		mysqli_query($connection, "UPDATE purchase_trans set  sup_id='$sup_id',transdate='$purchase_date',pamount='$totalamt',transtype='debit',purticular='purchase',bill_id='$keyvalue' where bill_id='$keyvalue'");

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
   $sup_id = $rowedit['sup_id'];
   $purchase_type = $rowedit['purchase_type'];
   $remark = $rowedit['remark'];
   $bill_type = $rowedit['bill_type'];
   

} else {
   $purchase_date = date('Y-m-d');
   $transport_date = date('Y-m-d');
   $billno  = '';
   $purchase_type  = '';
   $sup_id  = '';
   $bill_type  = 'challan';

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
<style>
.modal.fade{
    top: 20% !important;
    position: relative;
}
.modal.fade.in {
    top: 10% !important;
   position: fixed !important;
}
</style>
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
                                 <th width="15%"> Bill No. </th>
                                          
                                 <th width="15%"> Bill Type </th>

                                 <th width="15%" class="head0">Payment Type</th>




                                 <th width="15%"> Remark </th>
                              </tr>
                              <tr>
                                 <!-- <input type="hidden" name="purchaseid" id="purchaseid" class="input-xxlarge" style="width:30px;"  value="<?php echo $purchaseid; ?>" autofocus autocomplete="off" /> -->

                                 <td><input type="date" name="purchase_date" id="purchase_date" class="input-xxlarge" style="width:95%" autofocus  autocomplete="off" value="<?php echo $purchase_date; ?>" /> </td>
 <td>
                                     
                                     <select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" class="formcent select2-me"style="width:180px;"required>
                                    <!--<select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" tabindex="2" style="width:200px"  class="formcent select2-me" required>-->
                                       <option value="">Select </option>
                                       <?php
                                       $sql = mysqli_query($connection, "select * from  suppliers order by sup_name");
                                       while ($row = mysqli_fetch_array($sql)) {

                                       ?>
                                          <option value="<?php echo $row['sup_id']; ?>"><?php echo $row['sup_name']; ?></option>

                                       <?php } ?>
                                       <script>
                                          document.getElementById('sup_id').value = '<?php echo $sup_id ; ?>';
                                       </script>

                                 </td>
                               
                                 <td><input type="text" name="billno" id="billno"  value="<?php echo $billno; ?>"  autocomplete="off" maxlength="120" class="input-medium" required ></td>
                                  
                                 <td>
                                 <select data-placeholder="Choose Payment Type..." name="bill_type" id="bill_type" class="input-xxlarge" style="width:180px;" onChange="showAmt();">
                                 <option value="challan">Challan</option>
                                       <option value="Invoice">Invoice</option>
                                     

                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script>
                                 
                                 </td>

                                 <td> <select data-placeholder="Choose Payment Type..." name="purchase_type" id="purchase_type" class="formcent select2-me"  style="width:180px;">
                                       <option value="">Select</option>
                                       <option value="Cash">Cash</option>
                                       <option value="Credit">Credit</option>

                                    </select>
                                    <script>
                                       document.getElementById('purchase_type').value = '<?php echo $purchase_type; ?>';
                                    </script>
                                 </td>
                                 <td><input type="text" name="remark" id="remark" class="input-xxlarge" style="width:95%"  value="<?php echo $remark; ?>" autofocus autocomplete="off" /> </td>

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
                                       <th width="20%" class="head0">ITEM</th>
                                         <th width="10%" class="head0">HSN Code </th>
                                        <!-- <th width="10%" class="head0">TYRE NO.</th></th> -->
                                       <th width="20%" class="head0 nosort">Unit</th>
                                       <th width="25%" class="head0 nosort">Qty</th>

                                       <th width="25%" class="head0">Rate</th>
                                       <!-- <th width="25%" class="head0">Total Amount</th> -->
                                       <th width="25%" class="head0"  id="gst1" <?php
                                                                                if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>GST(%)</th>
                                       
                                       <th width="25%" class="head0">Net Amount</th>



                                       <th width="8%" class="head0">Action</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                       </span>
                                       <tr>
                                          <td>
                                             <select data-placeholder="Choose a Country..." name="itemid" id="itemid" style="width:200px" class="formcent select2-me" onchange="getunitid();getHsn();" >
                                                <option value="">Select </option>
                                                <?php
                                                $sql = mysqli_query($connection, "select * from  items order by item_name");
                                                while ($row = mysqli_fetch_array($sql)) {
                                                   
											$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");

                                                ?>
                                                   <option value="<?php echo $row['itemid']; ?>"><?php echo $row['item_name']; ?>/<?php echo $item_category_name; ?></option>

                                                <?php } ?>
                                                <script>
                                                   document.getElementById('itemid').value = '<?php echo $itemid; ?>';
                                                </script>

                                          </td>
                                          <input type="hidden" name="itemcatid" id="itemcatid" class="input-xxlarge" style="width:100px;"  value="<?php echo $itemcatid; ?>"  autofocus autocomplete="off" />
                                            <td> <input type="text" name="hsncode" id="hsncode" class="input-xxlarge" style="width:100px;"  value="<?php echo $hsncode; ?>"  autofocus autocomplete="off" /> </td>
                                          <!-- <td> <input type="text" name="serial_no" id="serial_no" class="input-xxlarge" style="width:100px;" tabindex="9" value="<?php echo $serial_no; ?>"  autofocus autocomplete="off" /> </td> -->
                                          <td>

                           <select  data-placeholder="Choose a Country..." name="unitid" id="unitid" style="width:200px"  class="formcent select2-me"  >
											<option value="">Select Unit</option>
											
                                 <script>
												document.getElementById('unitid').value = '<?php echo $unitid; ?>';
											</script>
                           </select>
											
                           </td>
                                          <!-- <input type="hidden" name="unitid" id="unitid" class="input-xxlarge" style="width:30px;" value="<?php echo $unitid; ?>" tabindex="8" autofocus autocomplete="off" /> -->

                                          <td><input type="text" name="qty[]" id="qty" onchange="addserial(<?php echo $qty; ?>) " class="input-xxlarge" style="width:80%;" value="<?php echo $qty; ?>" autofocus autocomplete="off" /> </td>
                                          <td><input type="text" name="rate" id="rate"  class="input-xxlarge" style="width:80%;" onChange="getdel();" value="<?php echo $rate; ?>" autofocus autocomplete="off" /> </td>
                                          <input type="hidden" name="purdetail_id" id="purdetail_id"  value="<?php echo $purdetail_id; ?>">

                                          <input type="hidden" name="total_amt" id="total_amt" class="input-xxlarge" style="width:100px;"  value="<?php echo $total_amt; ?>" onChange="getdel();" autofocus autocomplete="off" />
                                          <td id="gst2" <?php
                                                                    if ($bill_type == 'Invoice') { ?> style="display:block;" <?php  } else { ?>style="display:none;" <?php } ?>>
                                                        <select name="gst" id="gst" class="default-select ms-0 form-control" tabindex="14" style="width:100px;" onchange="getdel();">
                                                            <option value="">Select</option>
                                                            <option value="5">5%</option>
                                                            <option value="12">12%</option>
                                                             <option value="14">14%</option>
                                                            <option value="18">18%</option>
                                                            <option value="28">28%</option>
                                                        </select>
                                                        <script>
                                                            document.getElementById('bill_type').value = '<?php echo $bill_type; ?>';
                                                        </script>

                                                    </td>

                                                    <td><input type="text" name="nettotal" id="nettotal" class="input-xxlarge" style="width:150px;"  value="<?php echo $nettotal; ?>" autofocus autocomplete="off" /> </td>

                                        
                                       <input type="hidden" name="purchaseid" id="purchaseid" class="form-control text-red"  value="<?php echo $keyvalue;?>"  style="font-weight:bold;"  autocomplete="off">



                                          <td>
                                              
                                              <!--<input type"text" onClick="getSave();"  class="btn btn-primary"  style="width:30px;"  tabindex="15" value="ADD">-->
                                               <a class="btn btn-primary" tabindex="16" onClick="getSave();" >
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

   <div id="modal-snserial" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> <span id="m_itemname"></span> </h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body" id="serialbody1">
					<p>
						
					</p>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
                <input type="hidden" id="m_purdetail_id" value=""  >
                
					<button type="button" class="btn btn-primary" data-dismiss="modal"><?php if($keyvalue==0){?>Save<?php } else{ ?> Update <?php }?></button>
					<!-- <button type="button" class="btn btn-primary" onchange="saveserial();">Save changes</button> -->
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
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
         var bill_type = document.getElementById("bill_type").value;
           var itemcatid = document.getElementById("itemcatid").value;
        //   alert(itemcatid);
         var sup_id = document.getElementById("sup_id").value;
         // alert(purchaseid);
         jQuery.ajax({
            type: 'POST',
            url: 'show_purchaseentry.php',
            data: 'purchaseid=' + purchaseid+ '&bill_type=' + bill_type +'&itemcatid=' + itemcatid,
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
                  // alert(data);

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

      function addserial() {
      

      var itemid = jQuery("#itemid").val();	
      var purchaseid = document.getElementById("purchaseid").value;
    
      // var purchaseid = document.getElementById("purchaseid1").value;
      // var purdetail_id = document.getElementById("purdetail_id").value;
      var qty = jQuery("#qty").val();	
      // alert(itemid);
      // alert(qty);
		jQuery.ajax({
		  type: 'POST',
		  url: 'addserialnoitembody.php',
		  data: 'itemid='+itemid+'&qty='+qty+'&purchaseid='+purchaseid,
		  dataType: 'html',
		  success: function(data){			
         // alert(data);
         if(data==2){
		jQuery("#modal-snserial").modal('hide');
            
         }else{
		jQuery("#modal-snserial").modal('show');

			jQuery("#serialbody1").html(data);
		
			}}
			
		  });//ajax close
		
      getdel();
	}	


	function saveserial(i) {
		// alert(i);
		var pos_id = document.getElementById('pos_id'+i).value;
		var itemid = document.getElementById('itemid').value;
      var purchaseid = document.getElementById("purchaseid").value;
    


// 		alert(itemid);
		var serial_no = document.getElementById('serial_no1'+i).value;
		var purdetail_id = document.getElementById('purdetail_id').value;
// 		alert(purchaseid);
		// alert(serial_no);

		// var serial_no='';
		// for (var i = 0;i < serial_no.length;i++) {
		// serial_no += serial_no[i].value+',';
		// }
		
 		// serial_no = serial_no.substring(0,serial_no.length -1);
		
		jQuery.ajax({
		  type: 'POST',
		  url: 'saveserialnotyre.php',
		  data: 'i='+i+'&pos_id='+pos_id+'&itemid='+itemid+'&purdetail_id='+purdetail_id+'&serial_no='+serial_no+'&purchaseid='+purchaseid,
		  dataType: 'html',
		  success: function(data){				  
			// alert(data);
				// jQuery("#modal-snserial").modal('hide');
		//	jQuery("#modal-snserial").hide();
			
			}
			
		  });//ajax close
		
		
		}


      function showAmt() {

var bill_type = document.getElementById('bill_type').value;

if (bill_type == 'Invoice') {
//alert(bill_type);
   //  jQuery('#grand_total2').show();
    jQuery('#gst2').show();
   //  jQuery('#grand_total1').show();
    jQuery('#gst1').show();



} else {

   //  jQuery('#grand_total2').hide();
    jQuery('#gst2').hide();
   //  jQuery('#grand_total1').hide();
    jQuery('#gst1').hide();

}
}

      function getdel() {

         var qty = document.getElementById("qty").value;
      
         var rate = document.getElementById("rate").value;
             
         var gst = document.getElementById("gst").value;
         
         var total_amt = document.getElementById("total_amt").value;

         if (qty != "" && !isNaN(rate)) {

            var total = qty * rate;
            //alert(total);
            var gsttotal = total * gst/100;
            var nettotal = total+gsttotal;
            jQuery('#total_amt').val(total);
            jQuery('#nettotal').val(nettotal);
         }

      }








      function funDel(id)
{    
	 
     tblname = 'purchasentry_detail';
	   tblpkey = 'purdetail_id';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		jQuery.ajax({
		  type: 'POST',
		  url: '../ajax/deletepurchase.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){

			 // alert('Data Deleted Successfully');
			//   location=pagename+'?action=10';
           showrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close

function getunitid(itemid){
   var itemid = document.getElementById("itemid").value;
	
   $.ajax({
        type: 'POST',
        url: 'get_unitdetails.php',
        data: 'itemid='+itemid,
        dataType: 'html',
        success: function(data){
           //alert(data);
           
     $('#unitid').html(data).trigger('change').trigger('select2:select');
    
        }
     });//ajax close	
}

function getHsn(){
   var itemid = document.getElementById("itemid").value;

   $.ajax({
        type: 'POST',
        url: 'ajax_gethsnno.php',
        data: 'itemid='+itemid,
        dataType: 'html',
        success: function(data){
            // alert(data);
            	arr = data.split('|');

				hsncode = arr[0];
				itemcatid = arr[1];
							jQuery('#hsncode').val(hsncode);
                  jQuery('#itemcatid').val(itemcatid);
    //  $('#hsncode').val(data);
     showrecord(<?php echo $keyvalue; ?>);
        }
     });//ajax close 
     
}




      function getSave() {

         var itemid = document.getElementById("itemid").value;
         var unitid = document.getElementById("unitid").value;


         var qty = document.getElementById("qty").value;
         var rate = document.getElementById("rate").value;
          var gst = document.getElementById("gst").value;


         var purchaseid = '<?php echo $keyvalue; ?>';
         // var purdetail_id = 0;

         var purdetail_id = document.getElementById("purdetail_id").value;
        
         var total_amt = document.getElementById("total_amt").value;
         var nettotal = document.getElementById("nettotal").value;
        //   alert(total_amt);


           
            jQuery.ajax({
               type: 'POST',
               url: 'ajax_purchase_entry.php',
               data: 'itemid=' + itemid + '&unitid=' + unitid + '&qty=' + qty + '&gst=' + gst +  '&rate=' + rate + '&total_amt=' + total_amt + '&nettotal=' + nettotal +'&purchaseid=' + purchaseid + '&purdetail_id=' + purdetail_id,
               success: function(data) {
            //  alert(data);
               
                  showrecord(<?php echo $keyvalue; ?>);
                  jQuery('#itemid').val('');
                  jQuery("#qty").val('');
                  jQuery("#serial_no").val('');
                  jQuery("#hsncode").val('');
                  jQuery("#rate").val('');

                  jQuery("#total_amt").val('');
                  jQuery("#nettotal").val('');
  $("#gst").select2().select2('val', '');
                  $("#itemid").select2().select2('val', '');



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
      function modelFun(purdetail_id,itemid, qty, rate, total_amt, gst,nettotal,purchaseid) {


jQuery("#purdetail_id").val(purdetail_id);

$('#itemid').val(itemid).trigger('change').trigger('select2:select');

jQuery("#qty").val(qty);
jQuery("#rate").val(rate);
jQuery("#total_amt").val(total_amt);
$('#gst').val(gst).trigger('change').trigger('select2:select');

jQuery("#nettotal").val(nettotal);
if (qty != "" && !isNaN(rate)) {

var total = qty * rate;
//alert(total);
var gsttotal = total * gst/100;
var nettotal = total+gsttotal;
jQuery('#total_amt').val(total);
jQuery('#nettotal').val(nettotal);
}
addserial();
 }
   </script>
</body>

</html>
<?php
mysqli_close($connection);
?>