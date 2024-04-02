<?php
error_reporting(0);
include("dbconnect.php");
// include("../lib/smsinfo.php");
$tblname = "issueentry";
$tblpkey = "issueid";
$pagename = "issueentry.php";
$modulename = "Issue Entry";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;
if(isset($_GET['issueid']))
 $keyvalue = $_GET['issueid'];
else
$keyvalue = 0;


if (isset($_POST['submit'])) {
	//	echo 'ok';
		$issueid=trim(addslashes($_POST['issueid']));
	$issuno = trim(addslashes($_POST['issuno']));
	$issudate = $cmn->dateformatusa(trim(addslashes($_POST['issudate'])));
	$truckid = trim(addslashes($_POST['truckid']));
	$remark = trim(addslashes($_POST['remark']));
	$driver_name =  trim(addslashes($_POST['driver_name']));
	$meterread = $_POST['meterread'];
	
 
	if ($issueid == 0) {
 
		mysqli_query($connection,"insert into issueentry set issuno = '$issuno', issudate = '$issudate',driver_name = '$driver_name', truckid = '$truckid',
        remark='$remark',meterread='$meterread',createdby='$createdby', ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate',compid='$compid'");
 
	   $action = 1;
	   $process = "insert";
	   $keyvalue = mysqli_insert_id($connection);
	   mysqli_query($connection,"update issueentrydetail set issueid='$keyvalue' where issueid='0'");
	} else {
 
 
 
	mysqli_query($connection,"update  issueentry set issuno = '$issuno', issudate = '$issudate',driver_name = '$driver_name', truckid = '$truckid',
	remark='$remark',meterread='$meterread',createdby='$createdby', ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate' WHERE issueid = '$keyvalue'");
 
	   $action = 2;
	   $process = "updated";
	}
 

	echo "<script>location='$pagename?action=$action'</script>";
		
	}
if(isset($_GET[$tblpkey]))
{
	$btn_name = "Update";
	
	$sqledit = "SELECT * from $tblname where $tblpkey = $keyvalue";
	$rowedit = mysqli_fetch_array(mysqli_query($connection,$sqledit));
	$issuno  =  $rowedit['issuno'];
	$issudate  =  $rowedit['issudate'];
	$truckid  =  $rowedit['truckid'];
	$remark  =  $rowedit['remark'];	
	$driver_name  =  $rowedit['driver_name'];	
	$meterread =  $rowedit['meterread'];	
}
else
{
	$issudate=date('Y-m-d'); 
	$issuno  = $cmn->getcode($connection,"issueentry","issuno","1=1");		 
	$truckid  = '';	 
	$remark  = '';
	 $driver_name = '';
	 $meterread= '';
}

?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

<script>
  $(function() {
   
	 $('#start_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	  $('#end_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	
  });
  </script>

</head>

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
                                
                                
                                
                                 <a href="issueentry_detail.php" class="btn btn-primary" style="float:right;">View Detail</a>
                                 
                                
						      <?php include("../include/page_header.php"); ?>
                        
							</div>
                            
                                 
							
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('truckid,issuno,issudate,driver_name')">
                                <div class="control-group" style="border:2px double #CCC"> 
                                <table class="table table-condensed">
                                <tr><td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td width="20%"><strong>Truck No </strong><strong>:</strong><span class="red">*</span></td>
                                    <td width="20%"><strong>Driver Name </strong><strong>:</strong><span class="red">*</span></td>
                                     <td width="14%"><strong>Issue No.</strong> <strong>:</strong><span class="red">*</span></td>
                                      <td width="19%"><strong>Date </strong> <strong>:</strong><span class="red">*</span></td>
                                      <td><strong>Meter Reading</strong></td>
                                       <td width="47%"><strong>Remark:</strong> <strong>:</strong></td>
                                       </tr>
                                <tr>
                                    <td>  <select name="truckid" id="truckid" class="select2-me input-large" onChange="getdrivermapped()" >
                                     <option value="">-select-</option>
                                        <?php
											$sql = mysqli_query($connection,"Select truckid,truckno from m_truck  order by truckno");
											if($sql)
											{
												while($row = mysqli_fetch_assoc($sql))
												{
											?>
											 <option value="<?php echo $row['truckid']; ?>"><?php echo strtoupper($row['truckno']); ?></option>
											<?php
												}
											}
									   ?>
                                       
                                    </select>
                                    
                                  <script> document.getElementById('truckid').value='<?php echo $truckid; ?>'; </script>  </td>
                                  <td><input type="text" name="driver_name" id="driver_name" class="form-control text-red"  value="<?php echo $driver_name;?>"  style="font-weight:bold;"  autocomplete="off"></td>
                                  
                                  <!-- <td>  <select name="empid" id="empid" class="select2-me input-large" >
                                     <option value="">-select-</option>
                                        <?php
											$sql = mysqli_query($connection,"Select empid,empname from m_employee  order by empname");
											if($sql)
											{
												while($row = mysqli_fetch_assoc($sql))
												{
											?>
											 <option value="<?php echo $row['empid']; ?>"><?php echo strtoupper($row['empname']); ?></option>
											<?php
												}
											}
									   ?>
                                       
                                    </select>
                                    
                                  <script> document.getElementById('empid').value='<?php echo $empid; ?>'; </script>  </td> -->
                                      <td><input type="text" name="issuno" id="issuno" value="<?php echo $issuno; ?>"
                                     autocomplete="off"  maxlength="120" class="input-medium" readonly ></td>
                                      <td> <input type="text" name="issudate" id="issudate" class="form-control text-red" value="<?php echo $cmn->dateformatindia($issudate);?>" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask autocomplete="off" ></td>
                                      
                                       <td><input type="text" name="meterread" id="meterread" class="form-control text-red"  value="<?php echo $meterread;?>"  style="font-weight:bold;"  autocomplete="off"></td>
                                     
                                        <td width="47%"><input type="text" name="remark" id="remark" class="form-control text-red"  value="<?php echo $remark;?>"  style="font-weight:bold;"  autocomplete="off"></td>
										<td><input type="hidden" name="issueid" id="issueid" class="form-control text-red"  value="<?php echo $keyvalue;?>"  style="font-weight:bold;"  autocomplete="off"></td>
                                 
									</tr>
                                    
                                    
                                    
                                
                                </table> 
                                </div>
                            
                                <!--   DTata tables -->
                                <div class="row-fluid">
                                <div class="span12">
                                <div >
                                <table width="100%" class="table table-bordered table-condensed">
                                <tr>
                                <th width="28%">ITEM  </th>                                
                                <th width="15%">UOM</th>  
                                <th width="15%">Stock</th>                          
                                <th width="15%">QTY</th>
                                <th width="15%">Exchange Receipt</th>  
                               <th width="15%">Return Category</th>  
                                <th width="20%">Issue Remark</th>  
                                <th width="10%">Action</th>
                                </tr>
                                <tr>
                                <td>
                                <select id="item_id" class="select2-me" style="width:300px;" onChange="getDetails(this.value);" >
                                <option value="" >--Choose Item--</option>
                                <?php
                                //where cat_id not in (5,8)
                                $resprod = mysqli_query($connection,"select * from item_master  order by itemcategoryname");
                                while($rowprod = mysqli_fetch_array($resprod))
                                {
											$item_category_name = $cmn->getvalfield($connection, "item_category_master", "item_category_name", "item_cat_id='$rowprod[item_cat_id]'");

                                
                                ?>
                                <option value="<?php echo $rowprod['item_id']; ?>"><?php echo $rowprod['itemcategoryname']; ?>/<?php echo $item_category_name; ?></option>
                                <?php
                                }
                                ?>
                                </select>
                                </td>
                                
                                <td><input class="input-mini" type="text"  id="unit_name" value="" style="width:90%;"  >
                                  <td><input class="input-mini" type="text" id="stock" value="" style="width:90%;"  ></td>
                                
                                <td><input class="input-mini" type="text" id="qty" value="" style="width:90%;"  ></td> 
                                <td>
                                 <select id="excrec" class="input-medium" >
                                 	<option value=""></option>
                                 	<option value="Yes">Yes</option>
                                    <option value="No"Repaired>No</option>
                                 </select>
                                 </td>
                                
                                 <td>
                                 <select id="is_rep" class="input-medium" >
                                 	<option value="">--</option>
                                 	<option value="Scrap">Scrap</option>
                                    <option value="Repaired"Repaired>Repairable</option>
                                 </select>
                                 </td>
                                   <td><input class="input-mini" type="text" id="remark1" value="" style="width:90%;"  ></td>

                                <td>
                                <input type="button" class="btn btn-primary" onClick="addlist();" style="margin-left:20px;" value="Add">
                                </td>
                                </tr>
                                </table>
                                </div>	
                                </div>
                                
                                <div class="row-fluid">
                                <div class="span12">
                                <h4 class="widgettitle nomargin"> <span style="color:#00F;" > Product Details : <span id="inentryno" > </span>
                                
                                </span></h4>
                                
                                
                                <div class="widgetcontent bordered" id="showrecord">
                                
                                </div><!--widgetcontent-->
                                <br>
                                </div> <center> <button type="submit" name="submit" class="btn btn-primary">
                        Submit</button>
               <!-- <button href="issueentry.php" class="btn btn-success">Reset</button> -->

           
                  </center>

                                
                                <!--span8-->
                                
                                
                                </div>
                                </div>
                                
                                </form>
                                
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
							Enter OTP  :  <input type="text" id="otp" value="" class="input-large" >
					</p>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
                <input type="text" id="<?php echo $_GET['issueid'];?>" value="" >
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
		</div></div>
<script>
function deleterecord(id)
{    
	  //alert(id);   
	  tblname = 'issueentrydetail';
	   tblpkey = 'issuedetailid';
	   pagename  ='<?php echo $pagename; ?>';
		modulename  ='<?php echo $modulename; ?>';
	  //alert(tblpkey); 
	if(confirm("Are you sure! You want to delete this record."))
	{
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 	getrecord(<?php echo $keyvalue; ?>);
			}
		
		  });//ajax close
	}//confirm close
} //fun close

function hideval()
{
	var paymode = document.getElementById('paymode').value;
	if(paymode == 'cash')
	{
		document.getElementById('checquenumber').disabled = true;
		document.getElementById('session_name').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('session_name').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('session_name').disabled = false;
	}
}
</script>
	</body>
  
<script>
   
	function getrecord(keyvalue){
	  var truckid=jQuery("#truckid").val();	
			  jQuery.ajax({
			  type: 'POST',
			  url: 'show_issuerecord.php',
			   data: "truckid="+truckid+'&issueid='+keyvalue,
			  dataType: 'html',
			  success: function(data){				  
				//alert(data);
					jQuery('#showrecord').html(data);
				//	setTotalrate();		
					jQuery('#item_id').focus();	
				}				
			  });//ajax close								
	}
	
	

function getproductdetail(item_id)
{
	var item_id=jQuery("#item_id").val();
	if(!isNaN(item_id))
	{
		jQuery.ajax({
					type: 'POST',
					url: 'ajaxgetproductdetail.php',
					data: 'item_id='+item_id+'&process='+'purchase',
					dataType: 'html',
					success: function(data){				  
					//alert(data);
					
					arr=data.split('|');
									
					unit_name=arr[0];
					stock = arr[2];
					 					
					jQuery('#unit_name').val(unit_name);
					jQuery('#stock').val(stock);
					var text = '';
					if(arr[3] !='') {
						
						 text = `Item Last Issue Date :  ${arr[4]} Issue No : ${arr[3]}`;
							
							//$('#lastissueno').html(arr[2]);
						}
						$('#ihistory').html('<b>'+text+'</b>');
				 
					jQuery('#qty').focus();
					
					}
				
			  });//ajax close
	}
}


function getDetails(item_id){
	
    $.ajax({
			type: 'POST',
			url: 'show_purchase_details.php',
			data: 'item_id='+item_id,
			dataType: 'html',
			success: function(data){
				// alert(data);
				arr = data.split("|");
		$('#unit_name').val(arr[0]);
		$('#stock').val(arr[1]);

		$('#qty').val(arr[2]);


			
			}
		});//ajax close	
}

function addlist()
{
 	var  item_id= document.getElementById('item_id').value; 
 	var  unit_name= document.getElementById('unit_name').value; 
	 var  qty= document.getElementById('qty').value;	 
	var  stock= document.getElementById('stock').value;	 
	var  excrec= document.getElementById('excrec').value;	 
	var  remark1= document.getElementById('remark1').value;	
	var  is_rep= document.getElementById('is_rep').value;	 
	var issueid='<?php echo $keyvalue; ?>';	
	var issuedetailid=0;	
		
	if(qty =='')
	{
		alert('Quantity cant be blank');	
		return false;
	}	 
	else
	{
	
		jQuery.ajax({
		  type: 'POST',
		  url: 'save_issueproduct.php',
		  data: 'item_id='+item_id+'&unit_name='+unit_name+'&stock='+stock+'&qty='+qty+'&issueid='+issueid+'&issuedetailid='+issuedetailid+'&is_rep='+is_rep+'&excrec='+excrec+'&remark1='+remark1,
		  dataType: 'html',
		  success: function(data){				  
		//  alert(data);				
			jQuery('#item_id').val('');
			$("#item_id").select2().select2('val','');
			jQuery('#is_rep').val('');
			jQuery('#excrec').val('');
			jQuery('#remark1').val('');
			jQuery('#unit_name').val('');		  
			jQuery('#qty').val('');
			jQuery('#stock').val('');
			getrecord(<?php echo $keyvalue; ?>)
			
			}
			
		  });//ajax close
	}
}


function getdrivermapped() {
	var truckid = $('#truckid').val();
	var issudate = $('#issudate').val();
	
	
	jQuery.ajax({
		  type: 'POST',
		  url: 'getmappeddriver.php',
		  data: 'truckid='+truckid+'&date='+issudate,
		  dataType: 'html',
		  success: function(data){				  
	 		//	alert(data);
				var arr = data.split('|');
					$("#driver_name").select2().select2('val',arr[0]);
					//alert(arr[1]);
					if(arr[1] !='') {
						
						var text = `<a href='print_issue_entry.php?issueid=${arr[3]}' target='_blank'>Last Issue Date :  ${arr[1]} Issue No : ${arr[2]}</a>`;
							$('#history').html('<b>'+text+'</b>');
							//$('#lastissueno').html(arr[2]);
						}
				//$("#driver_name").val(data);
			}
			
		  });//ajax close
	
	}

 
</script>
<script>
  function edit(purchaseid) {
   
			$.ajax({			
				type: 'POST',			
				url: 'checkotp.php',			
				data: 'type=Issue',			
				dataType: 'html',			
				success: function(data){
				//	alert(data);
					$('#modal-sn').modal('show');
					$("#otp").val('');
					$("#m_purchaseid").val(purchaseid);
				
				}
			});//ajax close
	}

  function checkotp() {
	purchaseid = $("#m_purchaseid").val(); 
	otp = $("#otp").val(); 
		$.ajax({			
			type: 'POST',			
			url: 'checkotpsave.php',			
			data: 'purchaseid=' + purchaseid+'&otp='+otp,			
			dataType: 'html',			
			success: function(data){
				//alert(data);
				
				if(data==1) {
					$('#modal-sn').modal('hide');
				 $("#saveid").show();
				  $("#otpid").hide();
				
					}
					else {
          //  $( "#purchase_entry" ).submit();
						alert("OTP doesn't Match");
						}
			}
		});//ajax close
	
	}	

  </script>

	</html>
<?php
mysqli_close($connection);
?>

