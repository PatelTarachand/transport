<?php
include("dbconnect.php");
$tblname = "";
$tblpkey = "";
$pagename = "admin_payment_approvable.php";
$modulename = "Admin Payment Approvable";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

$cond=' ';


if(isset($_GET['start_date']))
{
	 $start_date = $cmn->dateformatusa(trim(addslashes($_GET['start_date'])));	
}
else
$start_date = date('Y-m-d');

if(isset($_GET['end_date']))
{
	 $end_date = $cmn->dateformatusa(trim(addslashes($_GET['end_date'])));	
}
else
$end_date = date('Y-m-d');

// if(isset($_GET['di_no']))
// {
// 	$di_no = trim(addslashes($_GET['di_no']));	
// }
// else
// // $di_no = '';

// // if($di_no !='') {
	
// // 	$cond .=" and di_no='$di_no'";
	
// // 	}
	
if($start_date !='' && $end_date !='')
{
		$cond .=" and DATE_FORMAT(payment_date,'%Y-%m-%d') between '$start_date' and '$end_date' ";
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
	  	  $('.recdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();

	
  });
  </script>

</head>

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
							<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="get" action="" class='form-horizontal' >
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    
                                    <td><strong>From Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="start_date" id="start_date" value="<?php echo $cmn->dateformatindia($start_date); ?>" autocomplete="off"   tabindex="2"  class="input-medium" required></td>
                                
                                   
                                    <td><strong>To Date:</strong><span class="red">* (dd/mm/yyyy)</span></td>
                                    <td><input type="text" name="end_date" id="end_date" value="<?php echo  $cmn->dateformatindia($end_date); ?>" autocomplete="off"   tabindex="5" 
                                     class="input-medium"></td>
                                     </td>
                                    <td>
                                 
                                    <input type="submit" name="submit" id="submit" value="Search" class="btn btn-success" tabindex="10">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    <?php
									}
                                   else
                                   {                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                                    <?php
                                   }
								   ?>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </td>
                                  </tr>
                                </table> 
                                </div>
                                </form>
							
							</div>
					</div>
				</div>
                <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; 
								
								?> Details</h3>
							</div>
							
							<input type="hidden" id="hiddenid" value="" >
							<div class="box-content nopadding" >
								<table class="table table-hover table-nomargin ">
									<thead>
										<tr>
										    <th ><input type="checkbox" name="chk0" id="chk0" onClick="toggle(this.checked)" class="w3-check" />All</th>
                                            <th >LR No.</th>
											
											<th >Voucher No.</th>
											<th >Owner Name.</th>
											<th >Truck No.</th>
											<th >Bilty Date</th>
                                        	<th >Payment Date</th>
                                        	<th>Dis. Weight</th>
                                        	<th>Rec. Weight</th>
                                        	<th>Company Rate</th>
                                        	<th>Final Rate</th>
                                        	<th>Net Amount</th>
                                            <th >Cash Adv. </th>
											 <th >Diesal Adv. </th>
											  
											<th >Total Amount</th>
											
										</tr>
									</thead>
                                    <tbody>
						<?php 
						$sn=1;
						// echo "select * from bidding_entry where 1=1 && is_bilty=1 $cond";
						 
						 if($_SESSION['username']=='skdiwan'){
						 $query="select * from bidding_entry where 1=1  $cond and is_complete='1' and compid='$compid' and payment_status='0'";
                        }elseif($_SESSION['username']=='admin'){
                        
                        $query="select * from bidding_entry where 1=1  $cond and is_complete='1' and compid='$compid' and payment_status='1'";
                        }
                        $sql = mysqli_query($connection,$query);
                        						
						while($row=mysqli_fetch_assoc($sql)) {
							
						$s = $row['tokendate'];
						$dt = new DateTime($s);											
						$date = $dt->format('d-m-Y');
						$placeid = $row['placeid'];
						$bid_id = $row['bid_id'];
						$recweight = $row['recweight'];
						
						if($recweight==0) { $recweight= $row['totalweight']; }
						
						$destaddress = $row['destaddress'];
						$confdate = $cmn->dateformatindia($row['confdate']);
						$sortagr = $row['sortagr'];	
						$truckid = $row['truckid'];
						$noofqty = $row['noofqty'];						
						$placename = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
						$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
						$recbag = $row['recbag'];
						$voucher_id = $row['voucher_id'];
						$bulk_payment_vochar = $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$voucher_id'");
						
						$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
						
						$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                    	$adv_cash = $row['adv_cash'];		
						$adv_diesel = $row['adv_diesel'];		
						$adv_other = $row['adv_other'];	
						$adv_consignor = $row['adv_consignor'];	
						$total_cash=$adv_cash+$adv_other+$adv_consignor;
						 $freightamt = $row['freightamt'];		
						 $newrate = $row['newrate'];
						$netamount=$recweight*$newrate;

						$deduct = $row['deduct'];

						$new_newamount=$netamount-$deduct;
						$tds_amt = $row['tds_amt'];
						$tds_amount=$new_newamount*$tds_amt/100;
						$new_newamount=$new_newamount-$tds_amount;
						$commission = $row['commission'];

						$total_paid=$new_newamount-$total_cash-$adv_diesel-$commission;
						
						?>
                      
					<tr>
					        <td><input type="checkbox" name="chk<?php echo $sn++; ?>" id="chk<?php echo $sn++; ?>" onClick="addids()" value="<?php echo $row['bid_id']; ?>"></td>
							<td><?php echo $row['lr_no']; ?></td>

							<td><?php echo $bulk_payment_vochar; ?></td>
							
							<td><?php echo $ownername; ?></td>
							<td><?php echo $truckno; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $cmn->dateformatindia($row['payment_date']); ?></td>
                            <td><?php echo $row['totalweight']; ?></td>
                            <td><?php echo $recweight; ?></td>
                            <td><?php echo $freightamt; ?></td>
                            <td><?php echo $newrate; ?></td>
                            <td><?php echo $new_newamount; ?></td>
                            <td><?php echo $total_cash; ?></td>
                            <td><?php echo $adv_diesel; ?></td>
                        
                            <td>
								<?php echo number_format(round($total_paid),2); ?>
                            </td>
                            
                           
                    </tr>
                    	<?php 
						}
						
						?>
                            <tr><td colspan="13"></td>
                            <?php 
                                if($_SESSION['usertype']=='admin'){
                                ?>
                                <td colspan="2" width="18%">
                                <input type="button" class="btn btn-sm btn-success" value="Released" onClick="status(3)"  >
                                <span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> 

                                <!--<input type="button" class="btn btn-sm btn-danger" value="Hold" onclick="status(4)"  >-->
                                <!--<span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> -->
                           
                                </td>
                                <?php 
                                }
                                elseif($_SESSION['username']=='skdiwan'){
                                ?>
                                 <td colspan="2" width="18%">
                                <input type="button" class="btn btn-sm btn-success" value="Verify" onClick="status(1)"  >
                                <span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> 

                                <!--<input type="button" class="btn btn-sm btn-danger" value="Hold" onclick="status(2)"  >-->
                                <!--<span style="color:#F00;" id="msg<?php echo $bid_id; ?>"></span> -->
                           
                                </td>
                                
                                                                <?php 
                                }
                                else{ }
                                ?>
                            </tr>
                    
									</tbody>
								</table>
								
								
							</div>
						</div>
					</div>
				</div>
				
			
			</div>
		</div></div>
<script>

function addids()
{
    strids="";
    var cbs = document.getElementsByTagName('input');
    var len = cbs.length;
    for (var i = 1; i < len; i++)
    {
         if (document.getElementById("chk" + i)!=null)
         {
              if (document.getElementById("chk" + i).checked==true)
              {
                   if(strids=="")
                   strids=strids + document.getElementById("chk" + i).value;
                   else
                   strids=strids + "," + document.getElementById("chk" + i).value;
               }
          }
     }
// 	alert(strids);
     document.getElementById("hiddenid").value = strids;
}


function toggle(source)
{
// 	alert(source);
	if(source == true)
	{
		//alert("hi");
		var cbs = document.getElementsByTagName('input');
		
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = true;
			}
		}
		addids()
	}
	else
	{
		//alert("hello");
		var cbs = document.getElementsByTagName('input');
		var cond_yes_or_no = "";
		for (var i=0, len = cbs.length; i < len; i++)
		{
			if (cbs[i].type.toLowerCase() == 'checkbox')
			{
				cbs[i].checked = false;
			}
		}
		addids()
		
	}
}	 


function status(status) {
 var ids = document.getElementById('hiddenid').value;	
//  alert(ids);
//  alert(status);
	$.ajax({
		type: 'POST',
		url: 'save_status.php',
		data: 'status='+status+'&ids='+ids,
		dataType: 'html',
		success: function(data){
// 		 alert(data);  
	 location.reload();
		
		}
	
	});//ajax close
  
  
}

</script>



	</body>
    

	</html>
<?php
mysqli_close($connection);
?>
