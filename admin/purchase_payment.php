<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "payment";
$tblpkey = "payment_id";
$pagename = "purchase_payment.php";
$modulename = "Purchase Payment";

$tblname = "payment";
$tblpkey = "paymentid";

$paymentdate = date('d-m-Y');
if(isset($_GET['action']))
{
$action = addslashes(trim($_GET['action']));
}
else
{
	$action = "";
}
if(isset($_GET['paymentid']))
$keyvalue = $_GET['paymentid'];
else
$keyvalue = 0;




if(isset($_POST['save'])) {

	$paymentdate = $cmn->dateformatusa(trim($_POST['paymentdate']));	
   echo "update payment set iscomp=1 where type='purchase' && iscomp=0";
	mysqli_query($connection,"update payment set iscomp=1 where type='purchase' && iscomp=0");	
	echo "<script>window.location='purchase_payment.php?action=1'</script>";
   
}


?>
<!doctype html>
<html>
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

                     <form id='purchase_entry' method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('compid,supplier_id,billno,purchase_date,purchase_type,remark')">
                        <div class="control-group" style="border:2px double #CCC">
                           <table class="table table-condensed">
                              <tr>
                                 <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                              </tr>

                              <tr>
                                 <th width="20%"> Payment Date </th>
                        
                              </tr>
                              <tr>
                                 <input type="hidden" name="purchaseid" id="purchaseid" class="input-xxlarge" style="width:30px;"  value="<?php echo $purchaseid; ?>" autofocus autocomplete="off" />

                                 <td><input type="text" name="paymentdate" id="paymentdate" class="input-xxlarge" style="width:200px;" autofocus  autocomplete="off" tabindex="1" value="<?php echo $paymentdate; ?>" /> </td>
 
                           </table>
                        </div>


                        <!--   DTata tables -->
                        <div class="row-fluid">
                           <div class="span12">
                              <div class="alert alert-success" style="border:3px double #999">
                              <h3 style="color:#FF0000" id="prebal"></h3>
                                 <table  class="table table-bordered table-condensed">
                                    <tr>
                                                  <th  class="head0">Supplier Name</th>
                                        <!-- <th width="10%" class="head0">TYRE NO.</th></th> -->
                                       <th  class="head0 nosort">Paid Amount</th>
                                       <th class="head0 nosort">Disc(Rs.)</th>
<th  class="head0">Payment Mode</th>
                                       <th  class="head0">Narration</th>
                                       
                                       <!-- <th width="25%" class="head0"  id="gst1" <?php
                                                                                // if ($bill_type == 'Invoice') { ?> style="display:block;" <?php // } else { ?>style="display:none;" <?php //} ?>>GST(%)</th>
                                       
                                       <th width="25%" class="head0">Net Amount</th> -->



                                       <th  class="head0">Action</th>
                                    </tr>
                                    </thead>
                                    
                                    <tbody>
                                       </span>
                                       <tr>
                                          <td>
                                          <select data-placeholder="Choose a Suppliers..." name="sup_id" id="sup_id" class="formcent select2-me" tabindex="2" style="width:200px;"  onChange="getprebal();" >
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
                                            <td> <input type="text" name="paid_amt" id="paid_amt" class="input-xxlarge" style="width:250px;" tabindex="8" value="<?php echo $paid_amt; ?>"  autofocus autocomplete="off" /> </td>
                                            <td> <input type="text" name="disc" id="disc" class="input-xxlarge" style="width:250px;" tabindex="8" value="<?php echo $disc; ?>"  autofocus autocomplete="off" /> </td>
                                          <!-- <td> <input type="text" name="serial_no" id="serial_no" class="input-xxlarge" style="width:100px;" tabindex="9" value="<?php echo $serial_no; ?>"  autofocus autocomplete="off" /> </td> -->
                                       
                                          <!-- <input type="hidden" name="unitid" id="unitid" class="input-xxlarge" style="width:30px;" value="<?php echo $unitid; ?>" tabindex="8" autofocus autocomplete="off" /> -->
                                          <td>
                                 <select data-placeholder="Choose Payment Type..." name="pay_type" id="pay_type" class="formcent select2-me" tabindex="4" style="width:180px;">
                                       <option value="">Select</option>
                                       <option value="NEFT/Net Banking">NEFT/Net Banking</option>

                                       <option value="UPI">UPI</option>
                                       <option value="Cash">Cash</option>
                             
                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script>
                                 
                                 </td>
                                          <td><input type="text" name="narration" id="narration" tabindex="12" class="input-xxlarge" style="width:250px;" value="<?php echo $narration; ?>" autofocus autocomplete="off" /> </td>

                                          


                                        



                                          <td>
                                              
                                              <!--<input type"text" onClick="getSave();"  class="btn btn-primary"  style="width:30px;"  tabindex="15" value="ADD">-->
                                               <button class="btn btn-primary" tabindex="16" onClick="addlist();" >
                                                ADD</button>



                                          </td>

                                          <input type="hidden" name="purchaseid1" id="purchaseid1" value="<?php echo $keyvalue; ?>">
                                       </tr>
                                 </table>
                              </div>
                           </div>

                           <div class="row-fluid">
                              <div class="span12">
                                 <h4 class="widgettitle nomargin"> <span style="color:#00F;"> Payment  Details : <span id="inentryno"> </span>

                                    </span></h4>


                                 <div class="widgetcontent bordered" id="showsalerecord">

                                 </div><!--widgetcontent-->
                                <br>
                              <center> <button type="submit" name="save" class="btn btn-primary">
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

         <div id="myModal_product" class="modal fade" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 ><strong>Update Entry</strong></h4>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered table-condensed">
                                   <tr>
						<th>Supplier Name</th>
						<th>Paid Amount</th>

					</tr>
					<tr>
						<td>  <select data-placeholder="Choose a Suppliers..." id="s_sup_id" class="formcent select2-me" tabindex="2" style="width:250px;"  onChange="getprebal();" >
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
						<td>
						<input type="text" id="s_paid_amt" class="form-control"  value=""  style="font-weight:bold; " autocomplete="off"  >   
					
					</td>				
					</tr>

					<tr>
						<th>Disc Amount</th>
						<th>Narration</th>
					</tr>
					<tr>
						<td><input class="form-control" type="text" id="s_discamt" value="" placeholder='Disc Amt'></td>
						<td>
						<input class="form-control" type="text" id="s_narration" value="" placeholder='Remark'>
						</td>

					</tr>
					<tr> 
			<th>Payment Date</th>
			 <th>Payment Mode</th> 
			 <th></th>            
          
            </tr>
            <tr>
				<td><input type="text" id="s_paymentdate" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td>
				
		
                <td> 
                  <!-- <input type="text" id="s_pay_type" class="form-control" value="" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask > </td> -->
              <select data-placeholder="Choose Payment Type..." id="s_pay_type" class="formcent select2-me" tabindex="4" style="width:180px;">
                                       <option value="">Select</option>
                                              <option value="NEFT/Net Banking">NEFT/Net Banking</option>

                                       <option value="UPI">UPI</option>
                                       <option value="Cash">Cash</option>
                             
                                    </select>
                                    <script>
                                       document.getElementById('bill_type').value ='<?php echo $bill_type; ?>';
                                    </script> 
	
				 </td>					    
									             
            </tr>
					




                        </table>
                    </div>
                    <div class="modal-footer">
					<button class="btn btn-primary" name="s_save" id="s_save" onClick="updatesale();">Save</button>
               <button data-dismiss="modal" class="btn btn-danger">Close</button>
			   <input type="hidden" id="s_paymentid" value="" >
			   
                    </div>
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
                
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
         // alert(purchaseid);
         var sup_id = document.getElementById("sup_id").value;
         // alert(purchaseid);
         jQuery.ajax({
            type: 'POST',
            url: 'show_paymentpur.php',
            data: 'purchaseid=' + purchaseid+'&sup_id=' + sup_id,
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
      function getprebal() {
	var sup_id = document.getElementById('sup_id').value;
	var paymentdate = document.getElementById('paymentdate').value;
    // alert(paymentdate);
	
	if(paymentdate=='') {
	alert("Please Select Date");
	return false;
	}
	
	if(sup_id=='') {
	alert("Please Select Customer");
	return false;
	}
	
	if(sup_id !='') {
	jQuery.ajax({
			  type: 'POST',
			  url: 'getprevbalsupp.php',
			  data: 'sup_id='+sup_id+'&paymentdate='+paymentdate,
			  dataType: 'html',
			  success: function(data){
				// 		alert(data);
						document.getElementById('prebal').innerHTML='Old Balance : '+data;
						jQuery('#paid_amt').focus('');
						}				
			  	});//ajax close
			 } 

}


function updatesale() {
		
      var sup_id = document.getElementById('s_sup_id').value.trim();
      var paid_amt = document.getElementById('s_paid_amt').value.trim();
      var pay_type = document.getElementById('s_pay_type').value.trim();
    //   alert(pay_type);
      var disc = document.getElementById('s_discamt').value.trim();
      var narration = document.getElementById('s_narration').value.trim();
      var paymentdate = document.getElementById('s_paymentdate').value.trim();
      var paymentid= document.getElementById('s_paymentid').value.trim();
//   alert(paymentdate);
      
      if(paymentdate=='') {
            alert("Please Select Date");
            return false;
      }
      
      
      if(sup_id=='') {
            alert("Please Select Customer");
            return false;
      }
      
      
      if(paid_amt=='' || paid_amt=='0') {
            alert("Paid Amount cant be Balnk/Zero");
            return false;
      }
      
      
      
         jQuery.ajax({
                 type: 'POST',
                 url: 'savepaymentpur.php',
                 data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&sup_id='+sup_id+'&paymentid='+paymentid,
               //   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
                 dataType: 'html',
                 success: function(data){		
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
                    });//ajax close
                
      
      
      }
      function addserial() {
      

      var itemid = jQuery("#itemid").val();	
      var purchaseid =0;	
    
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
		
		
	}	


	function saveserial(i) {
		// alert(i);
		var pos_id = document.getElementById('pos_id'+i).value;
		var itemid = document.getElementById('itemid').value;
		var purchaseid = 0;
		// alert(itemid);
		var serial_no = document.getElementById('serial_no1'+i).value;
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
// 	  alert(id);   
     tblname = 'payment';
	   tblpkey = 'paymentid';
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
// 			alert(data);
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
     $('#disc').val(data);
        }
     });//ajax close 
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
var paymentid=0;

if(paymentdate=='') {
		alert("Please Select Date");
		return false;
}


if(sup_id=='') {
		alert("Please Select Customer");
		return false;
}


if(paid_amt=='' || paid_amt=='0') {
		alert("Paid Amount cant be Balnk/Zero");
		return false;
}

	jQuery.ajax({
			  type: 'POST',
			  url: 'savepaymentpur.php',
			  data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&pay_type='+pay_type+'&sup_id='+sup_id+'&paymentid='+paymentid,
			//   data: 'paymentdate='+paymentdate+'&paid_amt='+paid_amt+'&disc='+disc+'&narration='+narration+'&sup_id='+sup_id+'&paymentid='+paymentid,
			  dataType: 'html',
			  success: function(data){	
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
			  	});//ajax close
			

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
			  data: 'id='+id+'&tblname='+tblname+'&tblpkey='+tblpkey+'&submodule='+submodule+'&pagename='+pagename+'&module='+module,
			  dataType: 'html',
			  success: function(data){
			 //alert(data);
           showrecord(<?php echo $keyvalue; ?>);
				
				}				
			  });//ajax close
}
   
function editselected(paymentid,paymentdate,sup_id,paid_amt,narration,disc,pay_type)
{

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
   </script>
</body>

</html>
<?php
mysqli_close($connection);
?>