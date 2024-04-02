<?php 
include("dbconnect.php");
$truckid=$_REQUEST['truckid'];
 $typos=$_REQUEST['id'];
 $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
 $mapid = $cmn->getvalfield($connection,"tyre_map","max(mapid)","truckid='$truckid' and typos='$typos'");


 $sqlcheckdup = mysqli_query($connection, "SELECT * FROM tyre_map WHERE truckid = '$truckid' && typos='$typos'");
 echo $check = mysqli_num_rows($sqlcheckdup);

 if($check >0)
{
	$sql = mysqli_query($connection, " select * from tyre_map where typos='$typos' && truckid = '$truckid'&& mapid = '$mapid' ");
	$row = mysqli_fetch_array($sql);

     $typos = $row['typos'];
     $serial_number = $row['serial_number'];
     $tyre_name = $row['tyre_name'];
    $meterreading = $row['meterreading'];

    $uploaddate = $row['uploaddate'];
    $tyre_model = $row['tyre_model'];
     $tyre_new_image = $row['tyre_new_image'];
    $tyre_old_image = $row['tyre_old_image'];
    $old_tyre_name = $row['old_tyre_name'];
    $old_tyre_serial_no = $row['old_tyre_serial_no'];
          
                    
			
        }else{
            $serial_number = '';
            $tyre_name = '';
           $meterreading = '';
       
           $uploaddate = '';
           $tyre_model ='';
           echo $tyre_new_image = '';
           $tyre_old_image = '';
           $old_tyre_name = '';
           $old_tyre_serial_no = '';
        }



?>
<div id="myModal" class="modal">
<form action="" method="post"   id="photoform">
                                                   

                                                   <div class="tab-content">
                                                      <div id="home" class="tab-pane fade in active">
                                                         <h4 style="text-align: center;"> ADD TYRE NO.</h4>
                                                         <table style="width:100%;">
                                                            <tr>
                                                        
                                                               <input type="hidden" id="id" name="typos"  value="<?php echo $typos;?>" class="formcent" >
                                                               <input type="hidden" id="truckid" name="truckid"  value="<?php echo $truckid;?>" class="formcent" >

                                                               <td style="padding: 17px;">
                                                                  <div style="padding-left: 10px;">Serial Number:</div>
                                                                  <div class="text">
                                                                     <input type="text" id="serial_number" name="serial_number" class="formcent" value="<?php echo $serial_number;?>" placeholder="Enter Serial Number" required style="border: 1px solid #368ee0;color:red;margin-bottom: 0px;" autocomplete="off">
                                                                  </div>

                                                                  
                                                               </td>
                                                              
                     <!-- <td style="padding:17px;">
                        <div style="padding-left: 10px;">Old Tyre Serial No.:</div>
                        <div class="text">
                           <input type="text" class="formcent" id="old_tyre_serial_no" name="old_tyre_serial_no" value="<?php echo $old_tyre_serial_no; ?>" placeholder="Old Tyre Serial No." required style="border: 1px solid #368ee0;" autocomplete="off">
                        </div>
                     </td> -->
                     </tr>



                     </table>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-dismiss="modal"  >Submit</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                     </div>
                  </div>
                 
                
                 
                        </form>
                  </div>
                  <script>

                    
		$(document).ready(function(e) {


$("#photoform").on('submit', (function(e) {
   alert('hi');
   e.preventDefault();
   $.ajax({


      url: "tyre_issue_entry.php",

      type: "POST",

      data: new FormData(this),

      contentType: false,

      cache: false,

      processData: false,

      success: function(data) {
      // alert(data)
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