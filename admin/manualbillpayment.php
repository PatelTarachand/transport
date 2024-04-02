<?php include("dbconnect.php");
$tblname = 'manualinv';
$tblpkey = 'minvid';
$pagename  ='manualbillpayment.php';
$modulename = "Manual Bill Payment";

if(isset($_GET['minvid']))
{
	$minvid = trim(addslashes($_GET['minvid']));
}
else
$minvid='0';

$sql = mysqli_query($connection,"select * from manualinv where minvid='$minvid'");
$row=mysqli_fetch_assoc($sql);
$invno = $row['invno'];
$invdate = $row['invdate'];
$qty = $row['qty'];
$amount = $row['amount'];
	

if(isset($_POST['sub']))
{
	$minvid = trim(addslashes($_POST['minvid']));
	$invno = trim(addslashes($_POST['invno']));
	$invdate = $cmn->dateformatusa(trim(addslashes($_POST['invdate'])));
	$qty = trim(addslashes($_POST['qty']));
	$amount = trim(addslashes($_POST['amount']));
	
	if($invno !='' && $invdate !='0')
	{
	
	if($minvid==0) {
			mysqli_query($connection,"insert into manualinv set invno='$invno',invdate='$invdate',					
			qty='$qty',amount='$amount',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid'");
			}
			else{
			mysqli_query($connection,"update manualinv set invno='$invno',invdate='$invdate',					
			qty='$qty',amount='$amount',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid' where minvid='$minvid'");
			}
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='$pagename?action=2'</script>";
	}
}


?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#0CF;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:230px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>

<script>
  $(function() {
   
	 $('#invdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	   });
  </script>

</head>

<body data-layout-topbar="fixed">
 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
					
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="post" action="" onSubmit="return checkinputmaster('invno,invdate')">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from bidding_entry $crit  && recweight !='0'"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >           <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                             
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?></legend>   
                <div class="innerdiv">
                    <div> Invoice No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
<input type="text" class="formcent" id="invno" name="invno" value="<?php echo $invno; ?>"  autocomplete="off"  >                                                     
                </div>
               </div>
               
                <div class="innerdiv">
                    <div> Invoice Date <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                     <input type="text" id="invdate" name="invdate" class="formcent" value="<?php echo $cmn->dateformatindia($invdate); ?>"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> qty </div>
                    <div class="text">
                     <input type="text" id="qty" name="qty" class="formcent" value="<?php echo $qty; ?>"  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div>Amount</div>
                    <div class="text">
                     <input type="text" id="amount" name="amount" class="formcent" value="<?php echo $amount; ?>" autocomplete="off"  >
                </div>
                </div>
                
                    <br>
					<br>
					<br>
					<br>
					<br>
					<br>
				<center>	
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save" >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
				</center>	
                    
               
    				</fieldset>
    		        <input type="hidden" name="minvid" id="minvid" data-key="primary" value="<?php echo $minvid; ?>">
                    </form>
                   			 </div>
                    		</div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<a class="btn btn-primary btn-lg" href="excel_manualbillpayment.php" target="_blank" style="float:right;" >  Excel </a>	
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Invoice No</th>
											<th>Invoice Date</th>
											<th>Qty</th>
											<th>Amount</th>
											
											<th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									if($usertype=='admin')
									{
									$crit="";
									}
									else
									{
									//$crit=" && createdby='$userid'";	
									$crit="";
									}	
									$sel = "select  * from  manualinv order by minvid";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['invno'];?></td>
							<td><?php echo $cmn->dateformatindia($row['invdate']);?></td>
                             <td><?php echo $row['qty'];?></td>
                            <td><?php echo $row['amount'];?></td>
                           
                           
                            <td class='hidden-480'>
                           <a href= "?minvid=<?php echo ucfirst($row['minvid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
						    &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['minvid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
						   
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
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
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
			  location=pagename+'?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close



//below code for date mask
jQuery(function($){
	$("#payment_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#chequepaydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#cashbook_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
});



function gettot_paid()
{
	var commission = parseFloat(document.getElementById('commission').value);
	var newrate = parseFloat(document.getElementById('newrate').value);
	var rate_mt = parseFloat(document.getElementById('rate_mt').value); 
	var cashpayment = parseFloat(document.getElementById('cashpayment').value);
	var chequepayment = parseFloat(document.getElementById('chequepayment').value);
	var bal_amount = parseFloat(document.getElementById('bal_amount').value);
	var tds_amt =  parseFloat(document.getElementById('tds_amt').value);
	var adv_diesel =  parseFloat(document.getElementById('adv_diesel').value);
	var wt_mt =  parseFloat(document.getElementById('wt_mt').value);
	var neftpayment =  parseFloat(document.getElementById('neftpayment').value);
	var othrcharrate = parseFloat(document.getElementById('othrcharrate').value);
	var tot_adv = parseFloat(document.getElementById('tot_adv').value);
	var adv_diesel = parseFloat(document.getElementById('adv_diesel').value);
	var deduct = parseFloat(document.getElementById('deduct').value);
	
	if(isNaN(tot_adv)){ tot_adv=0; }
	if(isNaN(adv_diesel)){ adv_diesel=0; }
	if(isNaN(neftpayment)){ neftpayment=0; }
	if(isNaN(newrate)){ newrate=0; }
	if(isNaN(rate_mt)){ rate_mt=0; }
	if(isNaN(adv_diesel)){ adv_diesel=0; }
	if(isNaN(othrcharrate)){ othrcharrate=0; }
	if(isNaN(deduct)){ deduct=0; }
	if(isNaN(commission))
	{
		commission = 0;	
	}
	
	if(isNaN(cashpayment))
	{
		cashpayment = 0;	
	}
	
	if(isNaN(chequepayment))
	{
		chequepayment = 0;	
	}
	
	if(isNaN(tds_amt))
	{
		tds_amt=0;
	}
	
	if(isNaN(wt_mt))
	{
		wt_mt=0;
	}
	
	
	newrate = rate_mt - othrcharrate;
	
	document.getElementById('newrate').value=newrate;
	
	var char = rate_mt - newrate;	
	document.getElementById('charrate').value= char;	
	//alert(commission)	
	var netamt = newrate * wt_mt;
	document.getElementById('netamount').value= netamt;
	
	var balamount = netamt - commission - adv_diesel - tot_adv - tds_amt -deduct;
	
	document.getElementById('bal_amount').value = balamount.toFixed(2);
	
	var tot_paid = cashpayment + chequepayment + neftpayment;
	
	document.getElementById('total_paid').value = tot_paid.toFixed(2);
	
	var remainingpayment = bal_amount - tot_paid;
	
	
	document.getElementById('remaining').value = remainingpayment.toFixed(2);
	
	
}

gettot_paid();

function chepayment()
{
	gettot_paid();
	var bal_amount = parseFloat(document.getElementById('bal_amount').value);
	var total_paid = parseFloat(document.getElementById('total_paid').value); 
	
	if(isNaN(bal_amount))
	{
		bal_amount = 0;	
	}
	
	if(isNaN(total_paid))
	{
		total_paid = 0;	
	}
	
	
}

function get_net_profit()
{
	var tot_profit = document.getElementById('tot_profit').value;
	var commission = document.getElementById('compcommission').value;
	
	if(isNaN(tot_profit))
	{
		tot_profit=0;	
	}
	
	if(isNaN(commission))
	{
		commission=0;	
	}
	
	var net_profit = tot_profit - (tot_profit * commission)/100;
	
	document.getElementById('net_profit').value=net_profit.toFixed(2);
}
</script>			
                
		
	</body>

	</html>
