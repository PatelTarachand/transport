<?php 
error_reporting(0);
include("dbconnect.php");
$tblname = "mechine_service_master";
$tblpkey = "meachineid";
$pagename = "mechine_service.php";
$modulename = "Mechanic/Service Center Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['meachineid']))
{
	$meachineid = $_GET['meachineid'];	
}else{
$meachineid = '';
}	



if(isset($_POST['submit']))
		{
			
			 $meachineid = $_POST['meachineid'];
			$mechanic_name = trim(addslashes($_POST['mechanic_name']));
			$mobile = trim(addslashes($_POST['mobile']));
			$address = trim(addslashes($_POST['address']));
			$placeid = trim(addslashes($_POST['placeid']));
			$openingdate = trim(addslashes($_POST['openingdate']));
			$openingbal = trim(addslashes($_POST['openingbal']));
		
			$narration = trim(addslashes($_POST['narration']));
			
		
			if($meachineid==0)
			{  

                // echo "insert into mechine_service_master set meachineid='$meachineid',mechanic_name='$mechanic_name',mobile='$mobile',address='$address',placeid='$placeid',openingdate='$openingdate',openingbal='$openingbal',narration='$narration',createdate='$createdate', sessionid='$sessionid'";die;
				mysqli_query($connection,"insert into mechine_service_master set meachineid='$meachineid',mechanic_name='$mechanic_name',mobile='$mobile',address='$address',placeid='$placeid',openingdate='$openingdate',openingbal='$openingbal',narration='$narration',createdate='$createdate', sessionid='$sessionid'");

                $action = 1;
                echo "<script>location='$pagename?action=$action'</script>";
			}
			else
			{
                //echo "update mechine_service_master set mechanic_name='$mechanic_name',mobile='$mobile',address='$address',placeid='$placeid', openingdate='$openingdate',openingbal='$openingbal',narration='$narration',createdate='$createdate' where meachineid='$meachineid'";die;
				mysqli_query($connection,"update mechine_service_master set mechanic_name='$mechanic_name',mobile='$mobile',address='$address',placeid='$placeid', openingdate='$openingdate',openingbal='$openingbal',narration='$narration',createdate='$createdate' where meachineid='$meachineid'");
				$action = 2;
			}			
            echo "<script>location='$pagename?action=$action'</script>";
			}
		
		

if($meachineid !='')
{
$sql = mysqli_query($connection,"select * from mechine_service_master where meachineid='$meachineid'");
$row=mysqli_fetch_assoc($sql);
$meachineid = $row['meachineid'];
$mechanic_name = $row['mechanic_name'];
$mobile = $row['mobile'];
$address = $row['address'];
$placeid = $row['placeid'];
$openingdate = $row['openingdate'];
$openingbal = $row['openingbal'];
$narration = $row['narration'];
}
else
{
	$meachineid = '';	
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

</head>

<body>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">		
		<div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
							<!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="margin-top: 20px;">
                                <tr>
                                    <td width="40%"><strong>Mechanic/Service Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                                    <input type="text" name="mechanic_name" value="<?php echo $mechanic_name; ?>" id="mechanic_name" autocomplete="off"  class="input-large">
                                    </td>                                    
                                 </tr>
                                 <tr>
                                    <td width="40%"><strong>Mobile No.</strong> <strong>:</strong></td>
                                    <td width="60%">
                                    <input type="text" name="mobile" value="<?php echo $mobile; ?>" id="mobile" autocomplete="off" maxlength="10"  class="input-large">
                                    </td>                                    
                                 </tr>
                                 
                                 

                                 <tr>
                                    <td> <strong>Address:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="address" value="<?php echo $address; ?>" id="address" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                   <tr>
                                        
                                        <td><strong> City</strong> </td>
                                           <td align="left">
                                                   <select name="placeid" id="city_id"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                               $sql = mysqli_query($connection,"select * from m_place ");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['placeid']; ?>"><?php echo $row['placename'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('city_id').value = '<?php echo $placeid ; ?>'; </script>
                                           
                                           </td>
                                            
                                       </tr> 




                                                                                                  
                                  <!-- <tr>
                                    <td> <strong>Payment Type:</strong><span class="red">*</span></td>
                                    <td>
                    				 <select name="payment_type" id="payment_type" class="formcent select2-me" style="width:224px;" onChange="set_payment(this.value);" >
                                           		<option value="">-Select-</option>
                                               	<option value="cash">CASH</option>
                                               	<option value="cheque">CHEQUE</option>
                                               <option value="neft">NEFT</option>
                                           </select>
                                           <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script>
                                    </td>
                                   </tr> 
                                   
                                  <tr> -->
                                  <!-- <tr>
                                    <td width="40%"><strong>Mobile No.</strong> <strong>:</strong></td>
                                    <td width="60%">
                                    <input type="text" name="opening_bal" value="<?php echo $opening_bal; ?>" id="opening_bal" autocomplete="off"  class="input-large">
                                    </td>                                    
                                 </tr> -->
                                         <tr id="bank_td" style="display:none">
                                        
                                         <th  align="left"><strong>Bank Name</strong></th>
                                            <td align="left">
                                           		 <select name="bankid" id="bankid"  class="formcent select2-me" style="width:224px;" >
                                           		<option value="">-Select-</option>
                                                <?php 
												$sql = mysqli_query($connection,"select bankid,bankname,helpline from m_bank order by bankname");
												while($row=mysqli_fetch_assoc($sql))
												{
												?>
                                               	<option value="<?php echo $row['bankid']; ?>"><?php echo $row['bankname'].' / '.$row['helpline']; ?></option>
                                               <?php 
												}
											   ?>
                                           </select>
                                           <script>document.getElementById('bankid').value = '<?php echo $bankid ; ?>'; </script>
                                            
                                            </td>
                                             
                                        </tr> 
                                        
                                         <tr id="chequed_td" style="display:none" >
                                        
                                         <th  align="left"><strong>Cheque Date</strong></th>
                                            <td align="left">
                                           
                                            <input type="text" class="form-control" name="chequedate" id="chequedate" value="<?php echo $cmn->dateformatindia($chequedate); ?>" data-date="true" placeholder="dd-mm-yyyy" >
                                           
                                            </td>
                                            </tr>
                                  
                                  <tr>
                                  <td><strong>Opening Date:</strong></td>
                                    <td><input type="date" name="openingdate" id="openingdate" value="<?php echo $openingdate; ?>"    autocomplete="off" class="input-large" data-date="true" ></td>
                                  </tr>

                                  <tr>
                                  <td><strong>Opening bal:</strong></td>
                                    <td><input type="text" name="openingbal" id="openingbal" value="<?php echo $openingbal; ?>"    autocomplete="off"  class="input-large" data-date="true"  ></td>
                                  </tr>
                                  
                                 <tr>
                                    <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>  
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,incomeamount,payment_type');" >
                    <input type="button" value="Reset" class="btn btn-danger" style="border-radius:4px !important;" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="meachineid" id="<?php echo $meachineid; ?>" value="<?php echo $meachineid; ?>" >
                    			</td>
                                </tr>  
                                 
                                  
                                </table> 
                                </div>
                                </form>
                                
                           </div>
                           
                           <div class="span5" style="float:right;" >
                        
                                <div class="control-group">
                                 
                                </div>
                            
                           </div>     
							
						</div>
					</div>
				</div>
                
                
               
                <!--   DTata tables -->
                <div class="row-fluid" id="list" style="display:none;" >
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Mechanic/Service Name</th> 
                                            <th>Mobile No.</th> 
                                            <th>Address </th>
                                        	<th>City</th>                                            
                                            <th>Opening Date</th> 
                                            <th>Opening bal</th> 
                                            <th>Narration</th>  
                                            <th>Action</th>                                                         
                                        	                                     
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									
									$slno=1;
                                   
									$sql = "select * from mechine_service_master order by meachineid desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$row[placeid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['mechanic_name']);?></td>                                           
                                            <td><?php echo ucfirst($row['mobile']);?></td>
                                        
                                            <td><?php echo ucfirst($row['address']);?></td>
                                            <td><?php echo $placename;?></td> 
                                            <td><?php echo ucfirst($row['openingbal']);?></td> 
                                             <td><?php echo $cmn->dateformatindia($row['openingdate']);?></td>
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                      
                                         
                                            <td class='hidden-480'>
                                            
                                           <a href= "?meachineid=<?php echo ucfirst($row['meachineid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <!--<a onClick="funDel('<?php //echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
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
					</div>
				</div>
				<?php 
				
				?>			
			</div>
		</div></div>
<script>
function funDel(id)
{    
	  //alert(id);   
	  tblname = '<?php echo $tblname; ?>';
	   tblpkey = '<?php echo $tblpkey; ?>';
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
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10&truckid=<?php echo $truckid; ?>';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

jQuery(function($){
   $("#paymentdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#chequedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

function settruckno()
{
	var ownerid = document.getElementById('ownerid').value;
	
	if(ownerid !='')
	{
		window.location.href='?ownerid='+ownerid;
	}	
}

function getbalamt()
{
	var total_rate_net = document.getElementById('total_rate_net').value;
	var total_paid_net = document.getElementById('total_paid_net').value;
	
	if(isNaN(total_rate_net))
	{
		var total_rate_net = 0;	
	}
	
	if(isNaN(total_paid_net))
	{
		var total_paid_net = 0;	
	}
	var balamt = total_rate_net - total_paid_net;
	document.getElementById('balamt').value=balamt.toFixed(2);
}

getbalamt();


function set_payment(payment_type)
{
	if(payment_type != "")
	{
		if(payment_type == 'cash')
		{
			//$("#chequeno").val('');
			//$("#refno").val('');
			//$("#bank_name").val('');
			
			$("#cheque_td").hide();
			$("#bank_td").hide();
			$("#chequed_td").hide();
			
		
		}
		else if(payment_type=='cheque' || payment_type=='neft' )
		{
			//$("#chequeno").val('');
			//$("#refno").val('');
			//$("#bank_name").val('');
			
			$("#cheque_td").show();
			$("#bank_td").show();
			$("#chequed_td").show();
			
		}
	}
}

set_payment("<?php echo $payment_type; ?>");

</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
