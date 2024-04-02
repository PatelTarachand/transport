<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_payment.php';
$modulename = "Recent Added Billty";

	if($usertype=='admin')
	{
	$crit=" where is_complete=0";
	}
	else
	{
	$crit=" where is_complete=0 && createdby='$userid'";	
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

</head>

<body data-layout-topbar="fixed">
 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
			  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
								
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                                    <th>Sno</th>  
                                                    <th>Bilty No.</th>
                                                    <th>Truck No.</th>
                                                    <th>Bilty Date</th>
                                                    <th>Consignor</th>
                                                    <th>Consignee</th>
                                                    <th>Owner Name</th>
                                                    <th>Final Pay</th>    
                                                    <th>Today Payment</th>
                                            
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
									$crit=" && createdby='$userid'";	
									}	
									$sel = "select A.*,DATE_FORMAT(A.tokendate,'%Y-%m-%d') as billdate,B.ownerid from bidding_entry as A left join m_truck as B on A.truckid=B.truckid where  A.recweight !='0'  && B.ownerid !=2 && is_complete=0 &&  isconf=0 order by bid_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];	
										$ownerid = $row['ownerid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");	
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");										
										$amount = $row['totalweight'] * $row['own_rate'];										
										//$final_amount = $amount - $row['adv_cash'] - $row['adv_diesel'] - $row['adv_cheque'] - $row['commission']-$row['tds_amt']-$row['deduct'];
										$final_amount = $row['fpay'];	
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo ucfirst($row['di_no']);?></td>
                             <td><?php echo $truckno;?></td>
                            <td><?php echo $cmn->dateformatindia($row['billdate']);?></td>
                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?></td>
                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                            
                           
                             <td><?php echo $ownername;?>
                           		
                           </td>                                    
                            
                             <td><?php echo number_format($final_amount,2);?></td>
                            <td> <input type="checkbox" onClick="getreminder('<?php echo $row['bid_id']; ?>','<?php echo $row['is_reminder']; ?>');" <?php if($row['is_reminder']==1) { ?> checked <?php } ?> > &nbsp; &nbsp;  <span style="color:#F00;" id="msg<?php echo $row['bilty_id']; ?>"></span>    </td>
                            
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
	var cashpayment = parseFloat(document.getElementById('cashpayment').value);
	var chequepayment = parseFloat(document.getElementById('chequepayment').value);
	var bal_amount = parseFloat(document.getElementById('bal_amount').value);
	
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
	
	//alert(commission);
	
	var tot_paid = commission + cashpayment + chequepayment;
	
	document.getElementById('total_paid').value = tot_paid;
	
	if(isNaN(bal_amount))
	{
		bal_amount = 0;	
	}
	var bal = bal_amount - tot_paid;
	document.getElementById('remaining').value = bal.toFixed(2);
	
	
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


function getreminder(bid_id,is_reminder)
{ 

//alert(is_reminder);
	if(bid_id !='' && is_reminder !='')
	{
		$.ajax({
		  type: 'POST',
		  url: 'updatereminder.php',
		  data: 'bid_id=' + bid_id + '&is_reminder=' + is_reminder,
		  dataType: 'html',
		  success: function(data){	
		  			//alert(data);
						document.getElementById('msg'+bid_id).innerHTML=' Updated ';
			}
		
		  });//ajax close
	}
}

</script>			
                
		
	</body>

	</html>
