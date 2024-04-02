<?php
  error_reporting(0);
  include("dbconnect.php");
  $tblname = "";
  $tblpkey = "";
  $pagename = "return_bulk_bilty_payment_emami_report.php";
  $modulename = "Bulk Bilty Payment Report";
  
  if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0; 	
  
  $cond=' ';
  
  
   $printdate=date('Y-m-d');
  if(isset($_GET['di_no']))
  {
  	$di_no = trim(addslashes($_GET['di_no']));	
  }
  else
  $di_no = '';
  
  if(isset($_GET['ownerid']))
  {
  	$ownerid = trim(addslashes($_GET['ownerid']));	
  }
  else
   $ownerid = '';
  
if(isset($_GET['voucher_id']))
  {
    $voucher_No = $_GET['voucher_id'];
  }
  else
    $voucher_No='';
  
$sql_voucher = mysqli_query($connection,"select * from return_bulk_payment_vochar where payment_vochar='$voucher_No'");
        $row_voucher = mysqli_fetch_array($sql_voucher);

            $bulk_voucher_id=$row_voucher['bulk_voucher_id'];
  
  $cond= " where 1=1";
  if($voucher_No!='') {
  	
  	$cond .=" and  B.voucher_id = '$bulk_voucher_id'  ";
  	
  	}
  	if($ownerid !='') {
  	
  	$cond .=" and A.ownerid='$ownerid'";
  	
  	}
  	
  	$payment_vouchar="SELECT * FROM `return_bulk_payment_vochar` ORDER by id DESC";
     $payres = mysqli_query($connection,$payment_vouchar);
                              $payrow = mysqli_fetch_array($payres);
                              $payNoIncre= $payrow['bulk_voucher_id']+1;
  
  
  ?>
<!doctype html>
<html>
  <head>
    <?php  include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>
    <script>
      $(function() {
       
      $('#from').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       $('#todate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       	  $('.recdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
      
      
      });
    </script>
  </head>
  <body>
    <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
    <div class="container-fluid" id="content">
      <div id="main">
        
        <div class="container-fluid">
          <!--  Basics Forms -->
          <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                 <!--  <legend class="legend_blue"><a href="dashboard.php"> 
                    <img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a>
                  </legend> -->
                  <?php include("alerts/showalerts.php"); ?>
                  <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
                  <?php include("../include/page_header.php"); ?>
                </div>
                <form  method="get" action="" class='form-horizontal' >
                  <div class="control-group">
                    <table class="table table-condensed" style="width:60%;">
                      <tr>
                        <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                      </tr>
                      <tr>
                        <td><strong>Truck Owner </strong> <strong>:</strong><span class="red">*</span></td>
                        <td>
                          <select id="ownerid" name="ownerid" class="select2-me input-large" style="width:220px;">
                            <option value=""> - All - </option>
                            <?php 
                              $sql_fdest = mysqli_query($connection,"select * from m_truckowner");
                              while($row_fdest = mysqli_fetch_array($sql_fdest))
                              {
                              ?>
                            <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                            <?php
                              } ?>
                          </select>
                          <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>
                        </td>
                        <td><strong>Voucher No</strong> <strong>:</strong><span class="red">*</span></td>
                        <td>
                          <input type="text" name="voucher_id" id="voucher_id" value="<?php echo $_GET['voucher_id']; ?>" maxlength="20"  tabindex="10" >
                         
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
                        </td>
                      </tr>
                    </table>
                  </div>
                </form>
              </div>
            </div>
          </div>



           <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                
                  
                  <h3><?php 
                 $OWNIID= $_GET['ownerid'];
                  $OWN="SELECT * FROM `m_truckowner` WHERE `ownerid`=$OWNIID";
                  $OWNres = mysqli_query($connection,$OWN);
                        			while($OWNrow = mysqli_fetch_array($OWNres))
                        			{
                        				echo $OWNrow['ownername']; 
                        			}
				?>
                  </h3>
                </div>

			
              </div>
            </div>
          </div>


          <!--   DTata tables -->
          <div class="row-fluid">
            <div class="span12" style="width:100%">
              <div class="box box-bordered">
                <div class="box-title">
                  <h3><i class="icon-table"></i><?php echo $modulename; ?> Details<span class="red">( Only 100 records are shown below for more <a href="return_bulk_bilty_payment_emami_report2.php?ownerid=<?php echo $ownerid; ?>" target="_blank">Click Here</a>)</span></h3>
                  
                  	<a class="btn btn-primary btn-lg" href="excel_emami_bilty_ereturn_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $_GET['consignorid']; ?>" target="_blank" style="float:right;"> Excel </a>
                </div>
                
                <div class="box-content nopadding overflow-x:auto" style="overflow: scroll;width: 100%;">
                  <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered"  width="100%">
                    <thead id="table">
                      <tr>
                        <th width="2%" >Sn</th>
                        <th width="5%" >Truck Owner</th>
                        <th width="5%" >Vouchar No</th>
                      
                           <th width="5%" >Payment Date</th>
                           <th width="5%" >Bal Amount</th>
                        <th width="5%" >Action</th>
                        <th width="5%" >Print PDF</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $sn=1;
                        
                         
                        if($ownerid=='' && $voucher_No==''){
                           // echo "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.consignorid=4 && B.recweight !='0' && B.deletestatus!=1 Group by B.voucher_id,order by B.voucher_id  DESC";
                               $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 &&  B.recweight !='0'  && B.compid='$compid'  && B.sessionid='$sessionid' and B.deletestatus!=1 Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";
                        }
                        else
                        {
                             $sel = "SELECT * from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.recweight !='0' && B.deletestatus!=1 && B.compid='$compid' && B.sessionid='$sessionid' Group by B.voucher_id order by B.voucher_id  DESC limit 0,100";
                        
                        }
                        $res = mysqli_query($connection,$sel);
                        			while($row = mysqli_fetch_array($res))
                        			{
                        				$truckid = $row['truckid'];	
                        				$truckno = $row['truckno'];	
                        				$ownerid = $row['ownerid'];	
                                        $bid_id = $row['bid_id'];	
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                         //  $vouchardate = $vocrow['createdate'];
                        
                      
                        
                        
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                       // $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        
                         $payment_date = $row['payment_date'];
                        	$voucher_id = $row['voucher_id'];
                        $vou_query="SELECT `payment_vochar` FROM `return_bulk_payment_vochar` WHERE `bulk_voucher_id`='$voucher_id' && compid='$compid' && sessionid= $sessionid";
                                
                                $voures = mysqli_query($connection,$vou_query);
                                    $vocrow = mysqli_fetch_array($voures);
                                    $voucharno= $vocrow['payment_vochar'];
                                       $cuurentdate=date('Y-m-d');  

                                       $voucher_amount= showBiltyVoucher1($connection,$compid,$voucher_id,$sessionid);	
                                       $payamount = $cmn->getvalfield($connection,"return_bilty_payment_voucher","sum(payamount)","ownerid='$ownerid' && voucher_id='$voucher_id' && compid='$compid' && sessionid= $sessionid ");
                                   
                                      // $bal_amt=floatval($voucher_amount-$payamount);
                                       $bal_amt = bcsub($voucher_amount, $payamount);
                                      // if($bal_amt < 0){
                                      //   $bal_amt=0;  
                                    //   }
                                    

                        ?>
                      <tr>
                        <td><?php echo $sn++; ?></td>
                          <td><?php echo $ownername; ?>
                        </td>
                        
                          <td><?php echo $voucharno; ?>
                        </td>
                          <td><?php echo dateformatindia($payment_date); ?></td>
                         <td><?php echo "Voucher Amt:" .$voucher_amount."<br>Paid :".$payamount."<br> Bal :".$bal_amt; ?>
                        </td>
                         
                        <td>
                                                <a href="return_bulk_bilty_payment_emami.php?ownerid=<?php echo $ownerid ?>&voucharno=<?php echo $voucharno; ?>&bulk_voucher_id=<?php echo $voucher_id ?>"><button class="btn btn-success center" > Edit</button></a>
                      
                            <!--<button class="btn btn-danger center" onClick="funDel('<?php echo $voucher_id; ?>')">Delete</button>	-->
                                       
                        </td>
                        <td>
                            
                          <a style=" margin-right: 10%;" href="pdf_return_bulk_bilty_payment_emami_report.php?ownerid=<?php echo $ownerid ?>&voucharno=<?php echo $voucharno; ?>&bulk_voucher_id=<?php echo $voucher_id ?>" target="_blank">
                    <button class="btn btn-primary center">Print PDF</button></span> 
                              
                          
                        </td>
                        
                    
                         
                      </tr>
                      <?php 
                        }
                       
                        ?>
                    </tbody>
                  </table>
                </div>
                  <div>
                  </a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>

   function funDel(id)
	{  
	
		if(confirm("Are you sure! You want to delete this record."))
		{
		  //  alert(id);
			$.ajax({
			  type: 'POST',
			  url: 'return_bulk_bilty_payment_emami_report_detele.php',
			  data: 'id='+id,
			  dataType: 'html',
			  success: function(data){
				//   alert(data);
				 // alert('Data Deleted Successfully');
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
			
			  });//ajax close
		}//confirm close
	} //fun close
	





      function gettot_paid(bid_id)
      {
      
      
      	var commission = parseFloat(document.getElementById('commission'+bid_id).value);
      	var newrate = parseFloat(document.getElementById('newrate'+bid_id).value);
      	var othrcharrate = parseFloat(document.getElementById('othrcharrate'+bid_id).value);

      	var rate_mt = parseFloat(document.getElementById('rate_mt'+bid_id).value);
      	
      	
      	var tds_amt =  parseFloat(document.getElementById('tds_amt'+bid_id).value);
      	var adv_diesel =  parseFloat(document.getElementById('adv_diesel'+bid_id).value);
      	var wt_mt =  parseFloat(document.getElementById('wt_mt'+bid_id).value);
      	
      	
      	var tot_adv = parseFloat(document.getElementById('tot_adv'+bid_id).value);
      	var adv_diesel = parseFloat(document.getElementById('adv_diesel'+bid_id).value);
      	var deduct = parseFloat(document.getElementById('deduct'+bid_id).value);	
      		//var recweight = parseFloat(document.getElementById('recweight'+bid_id).value);
      	
      	
      	
      	
      	if(isNaN(adv_diesel)){ adv_diesel=0; }
     
      	if(isNaN(newrate)){ newrate=0; }
      	if(isNaN(rate_mt)){ rate_mt=0; }
      	if(isNaN(adv_diesel)){ adv_diesel=0; }
      	if(isNaN(othrcharrate)){ othrcharrate=0; }
      	if(isNaN(deduct)){ deduct=0; }
      	if(isNaN(commission))
      	{
      		commission = 0;	
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
      	
       	document.getElementById('newrate'+bid_id).value=newrate;
       	
      	var char = rate_mt - newrate;	
       	document.getElementById('charrate'+bid_id).value= char;	
       	//alert(commission)	
      	var netamt = (newrate * wt_mt)-deduct;
       	document.getElementById('netamount'+bid_id).value= netamt;

       	// var netamt = newrate - deduct;
       	// document.getElementById('netamount'+bid_id).value= netamt;
      	
      	tds_amt = netamt*tds_amt/100;
      	document.getElementById('tds_amount'+bid_id).value= tds_amt;
      	var tot_paid = netamt - commission - adv_diesel - tot_adv - tds_amt;
      	document.getElementById('total_paid'+bid_id).value = tot_paid.toFixed(2);
      	//var balamount = netamt - commission - adv_diesel - tot_adv - tds_amt -deduct;
      	
      	//document.getElementById('bal_amount'+bid_id).value = balamount.toFixed(2);
        
      	//var tot_paid = cashpayment + chequepayment + neftpayment;
      	
       	//
      	
    	//var remainingpayment = bal_amount - tot_paid;
      	
      	
       //document.getElementById('remaining'+bid_id).value = remainingpayment.toFixed(2);
      	
      	
    }
      

      function getsave(bid_id){

      	if(confirm("Are you sure you want to update ? ")){
     
      	var rate_mt = parseFloat(document.getElementById('rate_mt'+bid_id).value);

      var wt_mt = parseFloat(document.getElementById('wt_mt'+bid_id).value);
        var receweight = parseFloat(document.getElementById('receweight'+bid_id).value);
        var othrcharrate = parseFloat(document.getElementById('othrcharrate'+bid_id).value);
        var newrate = parseFloat(document.getElementById('newrate'+bid_id).value);
        
      	
      	var commission = parseFloat(document.getElementById('commission'+bid_id).value);
      	var tds_amt =  parseFloat(document.getElementById('tds_amt'+bid_id).value);
      	var deduct = parseFloat(document.getElementById('deduct'+bid_id).value);
      	
       	
      	var payment_date =  document.getElementById('payment_date'+bid_id).value;

        var payNoIncre =  document.getElementById('payNoIncre'+bid_id).value;
        var payinvoice =  document.getElementById('payinvoice'+bid_id).value;

      	
      	
     	var bid_idd=bid_id;
      	

      	$.ajax({
      		type:"POST",
        url:"return_bulk_bilty_payment_save.php",
        

        data:"newrate="+newrate+"&commission="+commission+"&tds_amt="+tds_amt+"&deduct="+deduct+"&payment_date="+payment_date+"&bid_id="+bid_idd+"&rate_mt="+rate_mt+"&othrcharrate="+othrcharrate+"&receweight="+receweight+"&payNoIncre="+payNoIncre+"&payinvoice="+payinvoice,
        
        success:function(response) {
          alert(response);
         //document.getElementById("disp").innerHTML =response;
       },

      });

  }}
      
    </script>
  </body>
</html>
<?php
  mysqli_close($connection);
  ?>