<?php error_reporting(0);
include("dbconnect.php");
$tblname = "other_diesel_adv";
$tblpkey = "othrdieseladv_id";
$pagename = "diesel_advance.php";
$modulename = "Other Diesel Advance";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));	
}
else
$ownerid='';


if(isset($_GET['othrdieseladv_id']))
{
	$othrdieseladv_id = trim(addslashes($_GET['othrdieseladv_id']));
}
else
$othrdieseladv_id=0;



		if(isset($_POST['submit']))
		{
			$tblpkey_value= trim(addslashes($_POST['othrdieseladv_id']));
			$ownerid = trim(addslashes($_POST['ownerid']));
			$truckno = trim(addslashes($_POST['truckno']));
			$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));			
			$diesel_ltr = trim(addslashes($_POST['diesel_ltr']));
			$amount = trim(addslashes($_POST['amount']));
			$remark = trim(addslashes($_POST['remark'])); 
			
			if($ownerid !='' && $diesel_ltr !=''  && $adv_date !='')
			{
			if($tblpkey_value==0)
			{
					
				mysqli_query($connection,"insert into other_diesel_adv set ownerid='$ownerid',truckno='$truckno',diesel_ltr='$diesel_ltr',amount='$amount',adv_date='$adv_date',remark='$remark',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
				$action = 1;
			}
			else
			{
				mysqli_query($connection,"update other_diesel_adv set ownerid='$ownerid',truckno='$truckno',diesel_ltr='$diesel_ltr',amount='$amount',adv_date='$adv_date',remark='$remark',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress'  where othrdieseladv_id='$tblpkey_value'");
				$action = 2;
			}			
			echo "<script>location='$pagename?action=$action&ownerid=$ownerid'</script>";
			}
		}
		

if($othrdieseladv_id !='0')
{
$sql = mysqli_query($connection,"select * from other_diesel_adv where othrdieseladv_id='$othrdieseladv_id'");
$row=mysqli_fetch_assoc($sql);
$tblpkey_value = $row['othrdieseladv_id'];
$ownerid = $row['ownerid'];
$truckno = $row['truckno'];
$diesel_ltr = $row['diesel_ltr'];
$amount = $row['amount'];
$adv_date = $row['adv_date'];
$remark = $row['remark'];
}
else
{
	$adv_date = date('Y-m-d');
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
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr>
                                    <td width="40%"><strong>Truck Owner Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="ownerid" name="ownerid" class="formcent select2-me" style="width:224px;" onChange="window.location.href='?ownerid='+this.value;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select ownerid,ownername from m_truckowner order by ownername");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                 <tr>
                                  <td><strong>Truck No :</strong></td>
                                    <td><input type="text" name="truckno" id="truckno" value="<?php echo $truckno; ?>" autocomplete="off" class="input-large" data-date="true" placeholder="Enter Truck No" ></td>
                                  </tr>
                                 
                                 <tr>
                                  <td><strong>Adv. Date :</strong></td>
                                    <td><input type="text" name="adv_date" id="adv_date" value="<?php echo $cmn->dateformatindia($adv_date); ?>" autocomplete="off" class="input-large" data-date="true" placeholder="dd-mm-yyyy" ></td>
                                  </tr>
                                  
                                  
                                  
                                  <tr>
                                    <td> <strong>Diesel Ltr:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="diesel_ltr" value="<?php echo $diesel_ltr; ?>" id="diesel_ltr" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                 
                                 
                                 <tr>
                                    <td> <strong>Amount:</strong></td>
                                    <td>
                    				<input type="text" name="amount" value="<?php echo $amount; ?>" id="amount" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                    
                                    <tr>
                                    <td> <strong>Remark:</strong></td>
                                    <td>
                    				<input type="text" name="remark" value="<?php echo $remark; ?>" id="remark" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                                                      
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('ownerid,diesel_ltr,adv_date');" >
                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
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
                
                
                <?php 
				if($ownerid !='')
				{
				?>
                <!--   DTata tables -->
                <div class="row-fluid" >
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
                                            <th>Truck No</th> 
                                            <th>Truck Owner Name</th> 
                                            <th>Advance Date</th>                         
                                            <th>Diesel Ltr</th>                                            
                                            <th>Amount</th>   
                                            <th>Remark</th>                                                             
                                        	<th class='hidden-480'>Action</th>                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$slno=1;
									$sel = "select * from other_diesel_adv where ownerid='$ownerid' $cond order by adv_date desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","ownerid='$row[ownerid]'");
										//$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","ownerid='$row[ownerid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                           
                                            <td><?php echo ucfirst($row['truckno']);?></td>
                                             <td><?php echo $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'");  ?></td>
                                             <td><?php echo $cmn->dateformatindia($row['adv_date']);?></td>   
                                           	 <td><?php echo ucfirst($row['diesel_ltr']);?></td>
                                               <td><?php echo ucfirst($row['amount']);?></td>
                                               <td><?php echo $row['remark'];?></td>
                                            <td class='hidden-480'>
                                           <a href= "?othrdieseladv_id=<?php echo ucfirst($row['othrdieseladv_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
										</tr>
                                        <?php
								$tot_amt += $row['amount'];		
								$tot_ltr += $row['diesel_ltr'];			
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_ltr,2); ?></td>
                                                                                        
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_amt,2); ?></td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                    </tr>
										
									</tbody>
									
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php 
				}
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
			  location=pagename+'?action=10&ownerid=<?php echo $ownerid; ?>';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

jQuery(function($){
   $("#adv_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
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
			
			//alert('hi');
			
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
