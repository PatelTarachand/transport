<?php 
   include("dbconnect.php");
    $truckid=$_REQUEST['truckid'];
    $typos=$_REQUEST['id'];
    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
    $rpos_id = $cmn->getvalfield($connection,"tyre_map","pos_id","truckid='$truckid' and typos='$typos' && is_remove='0'");
    $serial_no = $cmn->getvalfield($connection,"purchaseorderserial","serial_no","pos_id='$rpos_id'");
    $item_id = $cmn->getvalfield($connection,"purchaseorderserial","itemid","pos_id='$rpos_id'");
      $itemname = $cmn->getvalfield($connection,"items","item_name","itemid='$item_id'");
   $old_tyre_name= $itemname."(".$serial_no.")";
   //  $sqlcheckdup = mysqli_query($connection, "SELECT * FROM tyre_map WHERE truckid = '$truckid' && typos='$typos'");
   //  echo $check = mysqli_num_rows($sqlcheckdup);
   
   //  if($check >0)
   // {
   	// $sql = mysqli_query($connection, " select * from tyre_map where typos='$typos' && truckid = '$truckid' ");
   	// $row = mysqli_fetch_array($sql);
   
      //   $typos = $row['typos'];
      //   $serial_number = $row['serial_number'];
      //   $tyre_name = $row['tyre_name'];
      //  $meterreading = $row['meterreading'];
   
      //  $uploaddate = $row['uploaddate'];
      //  $tyre_model = $row['tyre_model'];
      //   $tyre_new_image = $row['tyre_new_image'];
      //  $tyre_old_image = $row['tyre_old_image'];
      //  $old_tyre_name = $row['old_tyre_name'];
      //  $old_tyre_serial_no = $row['old_tyre_serial_no'];
             
   ?>

<form action="" method="POST" enctype="multipart/form-data" id="photoform">
<h6 style="border-bottom: 1px solid #ddd;padding: 10px;">Truck Number:<?php echo $truckno;?> , Tyre Type: Front Left</h6>
   <ul class="nav nav-tabs" style="padding-left: 20px;">
      <li class="active"><a data-toggle="tab" id="issue">Create</a></li>
      
      <li><a data-toggle="tab" id="report">Report</a>
   </li>
   </ul>

   <div class="tab-content" id="main1">
      <div id="home" class="tab-pane fade in active">
         <h4 style="text-align: center;">Tyre Issue Entry</h4>
         <table style="width:100%;">
            <tr>
               <input type="hidden" id="id" name="typos"  value="<?php echo $typos;?>" class="formcent" >
               <input type="hidden" id="truckid" name="truckid"  value="<?php echo $truckid;?>" class="formcent" >
               <td style="padding-left:17px;">
                  <div style="padding-left: 10px;">Issue category</div>
                  <div class="text">
                  <select id="issue_cate" name='issue_cate' class="input-medium" >
                                 	<option value="">--</option>
                                 	<option value="New Item">New Item</option>
                                    <option value="Repair">Repair</option>
                                      <option value="Exchange">Exchange</option>
                                 </select>
                  </div>
               </td>
               <td style="padding: 17px;">
                  <div style="padding-left: 10px;">Tyre Name / Serial No.</div>
                  <div class="text">
                  <select data-placeholder="Choose a Country..." name="itemid" id="itemid" style="width:200px" tabindex="7" class="select2-me input-large" onchange="getissue();">
                                                <option value="">Select </option>
                                               <?php $sql = mysqli_query($connection, "select * from  items where itemcatid=19");
  while ($row = mysqli_fetch_array($sql)) { ?>
    <option value="<?php echo $row['itemid']; ?>"><?php echo $row['item_name']; ?></option>
                                                   
                                                   <?php  } ?>
                                                   </select>
                                                <script>
                                                   document.getElementById('itemid').value = '<?php echo $itemid; ?>';
                                                </script> </td>
                  </div>
  </td>

  <td style="padding: 17px;">
                  <div style="padding-left: 10px;">Serial Number:</div>
                
                  <select data-placeholder="Choose a Country..." name="pos_id" id="pos_id" style="width:200px" tabindex="7" class="select2-me" >
                  
                    
                   
                  </select> 
                   <script>
                     document.getElementById('pos_id').value = '<?php echo $pos_id; ?>';
                  </script> 
                
               </td>
               
            </tr>

            <tr>
            <td style="padding: 17px;">
                  <div style="padding-left: 10px;">Meter Reading:</div>
                  <div class="text">
                     <input type="text" id="meterreading" name="meterreading" class="formcent" value="<?php echo $meterreading; ?>" placeholder="Enter Meter Reading" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                  </div>
               </td>
               <td style="padding-left:17px;">
                  <div style="padding-left: 10px;">Upload Date:</div>
                  <div class="text">
                     <input type="date" id="uploaddate" name="uploaddate" class="formcent" value="<?php echo $uploaddate; ?>" required style="border: 1px solid #368ee0;margin-bottom: 0px;" autocomplete="off">
                  </div>
               </td>
             
               <td style="padding-left:17px;">
                  <div style="padding-left: 10px;">Tyre New Image:</div>
                  <div class="text">
                  <input type="file" name="tyre_new_image" id="tyre_new_image" value="">
                  <!-- <span><img src="uploaded/newtyre/<?php echo $tyre_new_image ?>" width="50px;" alt="" /></span> -->
                     
                  </div>
               </td>
         
					

                 
                     <tr>
            <td style="padding:17px;">
                  <div style="padding-left: 10px;"> Old Tyre (Serial No.)</div>
                  <div class="text">
                     <!-- <input type="file" class="formcent" id="tyre_old_image" name="tyre_old_image" value="<?php echo $tyre_old_image; ?>" required autocomplete="off"> -->
                     <input type="text" name="old_tyre_name" id="old_tyre_name" class="form-control" data-rule-maxlength="255" autocomplete="off" value="<?php echo $old_tyre_name ?>" readonly>
<input type="hidden" name="rpos_id" id="rpos_id" class="form-control" data-rule-maxlength="255" autocomplete="off" value="<?php echo $rpos_id ?>" readonly>      
               <span></span>
                  </div>
               </td>
               <td style="padding-left:17px;">
                  <div style="padding-left: 10px;">Return category</div>
                  <div class="text">
                  <select id="return_cate" name='return_cate' class="input-medium" onChange="showItems(this.value)" >
                                 	<option value="">--</option>
                                 	
                                    <option value="Repaired">Repairable</option>
                                      <option value="Exchange">Exchange</option>
                                      <option value="Scrap">Scrap</option>
                                 </select>
                  </div>
               </td>
               <td style="padding:17px;">
                  <div style="padding-left: 10px;">Tyre Old Image:</div>
                  <div class="text">
                     <!-- <input type="file" class="formcent" id="tyre_old_image" name="tyre_old_image" value="<?php echo $tyre_old_image; ?>" required autocomplete="off"> -->
                     <input type="file" name="tyre_old_image" id="tyre_old_image" class="form-control" data-rule-maxlength="255" autocomplete="off">
                     <span><?php echo $tyre_old_image ?></span>
                  </div>
               </td>
             
             
             
         
            </tr>

<tr>
   <td></td>
   <td>
            <button type="submit" name="upload" class="btn btn-primary">
							Upload</button>
  </td>
  <td></td>
  </tr>
					</form>

				</tr>
				<input type="hidden" id="ref_id" value="">
			</table>
			</p>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn">Close</button>
		</div>
	</div><!--#myModal-->
<script>
   $(document).ready(function(e) {
   
   
   $("#photoform").on('submit', (function(e) {
   //  alert('hi');
    e.preventDefault();
    $.ajax({
   
   
       url: "tyre_issue_entry.php",
   
       type: "POST",
   
       data: new FormData(this),
   
       contentType: false,
   
       cache: false,
   
       processData: false,
   
       success: function(data) {
        alert(data);
          alert('Document hasbeen uploaded Successfully');
          //href='truck_permanent_document.php';
          jQuery("#myModal").modal('hide');
          // alert(data);
          showphoto(data);
           
          //showTick(data);
       
       },
       //window.location.hr
       error: function()
   
       {
   
       }
   
    });
   
   }));
   
   });
       
      
       
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#report').click(function(){
      $('#main1').load('vehicle_tyre_report.php?truckid=<?php echo $truckid; ?>&typos=<?php echo $typos; ?> #main', function() {
      
      jQuery('.select2-me').select2();
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>
<script type="text/javascript" language="javascript">
$(document).ready(function() { /// Wait till page is loaded
   $('#issue').click(function(){
      $('#main1').load('save_modal.php?truckid=<?php echo $truckid; ?>&id=<?php echo $typos; ?> #main1', function() {
      jQuery('.select2-me').select2();
           /// can add another function here
      });
   });
}); //// End of Wait till page is loaded
</script>