<?php error_reporting(0); include("dbconnect.php");
$tblname = 'payment_receive';
$tblpkey = 'pay_id';
$pagename  ='payment_received_by_consignor.php';
$modulename = "Payment Receive by Consignor";

	if($usertype=='admin')
	{
	$crit=" where payment_date='0000-00-00'";
	}
	else
	{
$crit=" where payment_date='0000-00-00'";
	}

if(isset($_GET['billid']))
{
	 $billid = $_GET['billid'];
	 $crit=" where billid='$billid'";
	 
	 "SELECT * FROM `bill_details`  where billid='$billid'"; 
	$sql = mysqli_query($connection,"SELECT * FROM `bill_details`  where billid='$billid'");
	$row=mysqli_fetch_assoc($sql);	
	
 	$bill_amount= $cmn->get_total_billing_amt($connection,$_GET['billid']);
	
	
}



if(isset($_POST['sub']))
{
	$billid=$_POST['billid'];
  $amount=$_POST['amount'];
  $tds_amount=$_POST['tds_amount'];
  $shortage_amount=$_POST['shortage_amount'];
  $receive_date= date('Y-m-d',strtotime($_POST['receive_date']));
  $payment_rec_no=$_POST['payment_rec_no'];
  
	$sessionid = 3;

	
	if(($billid !='' || $amount !='0')  && ($receive_date !='' || $payment_rec_no !='0'))
	{
		
  $sql_update = "INSERT INTO `payment_receive`(`pay_id`, `amount`, `tds_amount`, `shortage_amount`, `receive_date`, `payment_rec_no`, `bill_no`, `status`,`consignorid`) VALUES (Null,'$amount','$tds_amount','$shortage_amount','$receive_date','$payment_rec_no','$billid','0','4')"; 
			mysqli_query($connection,$sql_update);
			
			//$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
			echo "<script>location='payment_received_by_consignor.php?action=2'</script>";
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
   
   $('#receive_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
     
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
                   <form method="post" action="">
                    <input type="hidden" name="pagename" id="pagename" value="<?php echo $pagename;?>">                    <?php //echo "select bid_id,di_no from bidding_entry $crit  && recweight !='0' && consignorid =4"; ?>
    				<fieldset style="margin-top:45px; margin-left:45px;" >           <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                             
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; Payment Receive by Consignor</legend>   
                <div class="innerdiv">
                    <div> Bill No. <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">                    		
                 <!--   <input type="text" class="formcent" name="bill_no" id="bill_no" value="<?php echo $toplace; ?>"  style="border: 1px solid #368ee0;"   autocomplete="off"  >    
 -->

                   <select id="billid" name="billid" class="select2-me input-large" 
                   onChange="window.location.href='?billid='+this.value"
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			

			$sql_fdest = mysqli_query($connection,"select * from bill");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['billid']; ?>"><?php echo $row_fdest['billno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('billid').value = '<?php echo $billid; ?>';</script>

                </div>
               </div>
               <div class="innerdiv">
                    <div> Bill Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" id="bill_amount" value="<?php echo $bill_amount; ?>"  style="border: 1px solid #368ee0;" readonly autocomplete="off"  >
                </div>
                </div>
                <div class="innerdiv">
                    <div>Receiving Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" name="amount" id="amount"  style="border: 1px solid #368ee0;" onChange="gettot_paid();" autocomplete="off"  >
                </div>
                </div>


                
                <div class="innerdiv">
                    <div> TDS Amount </div>
                    <div class="text">
                     <input type="text" class="formcent" name="tds_amount" id="tds_amount"   style="border: 1px solid #368ee0;"  autocomplete="off" onChange="gettot_paid();"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Shortage Amount </div>
                    <div class="text">
                     <input type="text" class="formcent" name="shortage_amount" id="shortage_amount"   style="border: 1px solid #368ee0;"  autocomplete="off" onChange="gettot_paid();"  >
                </div>
                </div>

        
                        <div class="innerdiv">
                    <div>Balance Amount  </div>
                    <div class="text">
                     <input type="text" class="formcent" 	 id="bal_amt" value="<?php echo number_format(round($bal_amt),2); ?>"  style="border: 1px solid #368ee0;" readonly  autocomplete="off"  >
                </div>
                </div>
                
                <div class="innerdiv">
                    <div> Receiving Date </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="receive_date" id="receive_date"  value="<?php  $date=date('Y-m-d'); 
                     echo date('d-m-Y',strtotime($date)); ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>

                <div class="innerdiv">
                    <div> Payment Receive No </div>
                    <div class="text">
                     <input type="text" class="formcent"  name="payment_rec_no" id="payment_rec_no"  value="<?php echo $toplace; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                </div>
                </div>
                
                
              
         
              
             
			   
           
                        
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					<br>
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return chepayment(); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                    <input  type="hidden" name="wt_mt" id="wt_mt" value="<?php echo $wt_mt; ?>" >
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Bill no.</th>
											<th>Receiving Amount</th>
											<th>TDS Amount </th>
											<th>Shortage Amount</th>
											<th>Receiving Date</th>
											<th>Payment Receive No</th>
											    
											<!-- <th>Print</th> -->
											<!-- <th class='hidden-480'>Action</th> -->
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
									$sel = "SELECT * FROM `payment_receive` WHERE consignorid=4 and compid='$compid' order by pay_id desc limit 10";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"bill","billno","billid = '$row[bill_no]'"));?></td>
					         <td><?php echo number_format(round($row['amount']),2);?></td>
                             <td><?php echo number_format(round($row['tds_amount']),2);?></td>
                             
                            <td><?php echo number_format(round($row['shortage_amount']),2);?></td>  
                            <td><?php echo $cmn->dateformatindia($row['receive_date']);?></td>  
                            <td><?php echo $row['payment_rec_no'];?></td>                         
                            
                            
                            <!-- <td><a href="pdf_paymentreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                    </td> -->
                      <!--       <td class='hidden-480'>
                           <a href= "?bid_id=<?php echo ucfirst($row['bid_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                           </td> -->
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
// function funDel(id)
// {    
// 	  //alert(id);   
// 	  tblname = '<?php echo $tblname; ?>';
// 	   tblpkey = '<?php echo $tblpkey; ?>';
// 	   pagename  ='<?php echo $pagename; ?>';
// 		modulename  ='<?php echo $modulename; ?>';
// 	  //alert(tblpkey); 
// 	if(confirm("Are you sure! You want to delete this record."))
// 	{
// 		$.ajax({
// 		  type: 'POST',
// 		  url: '../ajax/delete.php',
// 		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
// 		  dataType: 'html',
// 		  success: function(data){
// 			 // alert(data);
// 			 // alert('Data Deleted Successfully');
// 			  location=pagename+'?action=10';
// 			}
		
// 		  });//ajax close
// 	}//confirm close
// } //fun close



//below code for date mask
jQuery(function($){
	$("#payment_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#chequepaydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
	$("#cashbook_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"}); 
});


 

function gettot_paid()
{

	
	var bill_amount = parseFloat(document.getElementById('bill_amount').value);
	var amount = parseFloat(document.getElementById('amount').value);
	
	var tds_amount = parseFloat(document.getElementById('tds_amount').value);
	var shortage_amount = parseFloat(document.getElementById('shortage_amount').value);
	
	var bal_amt=bill_amount-amount-tds_amount-shortage_amount;
	document.getElementById('bal_amt').value=bal_amt;
	
	
	
	
	
	
}


</script>			
                
		
	</body>

	</html>
