<?php 
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='truck_owner_payment_report.php';
$modulename = "Truck Owner Payment Report";

$crit=" ";

if(isset($_GET['search']))
{
  $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  $todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  
}
else
{
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
}

if(isset($_GET['ownerid']))
{
  $ownerid=trim(addslashes($_GET['ownerid']));
}
else
$ownerid='';

if(isset($_GET['truckid']))
{
  $truckid=trim(addslashes($_GET['truckid']));
}
else
$truckid='';

if($fromdate !='' && $todate !='')
{
     $crit.=" and A.payment_date between '$fromdate' and '$todate' ";   
}

if($truckid !='') {
  $crit .=" and A.truckid='$truckid' ";
}

if($ownerid !='') {
  $crit .=" and B.ownerid='$ownerid' ";
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
padding:6px;
width:390px;
margin-left:8px;
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
$(document).ready(function(){
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
});
$(document).ready(function(){
  $("#shortcut_consigneeid").click(function(){
    $("#div_consigneeid").toggle(1000);
  });
  });
  $(document).ready(function(){
  $("#short_place").click(function(){
    $("#div_placeid").toggle(1000);
  });
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
                   <form method="get" action="">
            <fieldset style="margin-top:45px; margin-left:45px;" > <!--      <legend class="legend_blue"><a href="dashboard.php"> 
    <img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                                   -->
      <legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> </legend>
                            <table width="100%">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Owner Name :</th>
                                            <th width="15%" style="text-align:left;">Truck No : </th>
                                            
                                           <!--  <th width="208" style="text-align:left;">Consignee : </th>
                                            <th width="208" style="text-align:left;">To Place : </th>
                                            <th width="208" style="text-align:left;">GP No : </th>
                                           
                                            -->
                                            <th width="40%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td><select id="ownerid" name="ownerid" class="select2-me input-large" style="width:220px;">
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
                                            <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script></td>
                                            
                             <td><select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;">
                                              <option value=""> - All - </option>
                                              <?php 
                        $sql_fdest = mysqli_query($connection,"select * from m_truck");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                                              <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                                              <?php
                        } ?>
                                            </select>
                                            <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script></td>              
                      
                        
                                            
                                            
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>                                           </td>
                                    </tr>
                            </table>            
                    </fieldset>              
                    </form>
         </div>
        </div>
                  </div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
            <div class="container-fluid">
                <div class="row-fluid">
          <div class="span12">
            <div class="box box-bordered">
              <div class="box-title">
              	<h3><i class="icon-table"></i>Truck Owner Payment Report Details</h3>

                      <a class="btn btn-primary btn-lg" href="excel_truck_owner_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&ownerid=<?php echo $ownerid; ?>&truckid=<?php echo $truckid; ?>" target="_blank" 
                                style="float:right;" >  Excel </a>
              </div>
                            
                          
              <div class="box-content nopadding" style="overflow: scroll;">
                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
                  <thead>
                    <tr>
                      <th>Sno</th>  
                      <th>LR NO</th>
                      
                      <th>Consignee</th>
                      <th>Trcuk No.</th>
                      <th>Destination</th>
                      <th>Confirm Date</th>
                      <th>Payment Date</th>
                    <th>Payment Vouchar No.</th>
                      <th>Weight</th>
                     <th>Comapny <p> Rate </p></th> 
                      <th>Final Rate</th> 
                      <th>Commission</th>
                       <th>Payment <p>Commission</p></th> 
                       <th>TDS</th>
                      <th>Diesal adv.</th>
                       <th>Total Cash Adv. </th>
                      <th>Final Paid</th> 
                      <th>Profit Amount</th>   
                      <th>Print</th>
                      
                    </tr>
                  </thead>
                                    <tbody>
                                    <?php
                  $slno=1;
                  
                $sel = "select  A.* from bidding_entry as A left join m_truck as B on A.truckid=B.truckid where A.is_complete=1 $crit and A.compid='$compid'and sessionid=$sessionid order by bid_id desc ";
              $res = mysqli_query($connection,$sel);
                  while($row = mysqli_fetch_array($res))
                  {
                    $truckid = $row['truckid'];                   
                    $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     @$voucher_id = $row['voucher_id']; 
                   
              $payment_vochar = $cmn->getvalfield($connection,"bulk_payment_vochar","payment_vochar","bulk_voucher_id='$voucher_id'");

                        $adv_cash = $row['adv_cash'];
                        $adv_other =  $row['adv_other'];
						 $adv_consignor =  $row['adv_consignor'];
                        $adv_diesel = $row['adv_diesel'];
                        $adv_cheque = $row['adv_cheque'];
                        $cheque_no = $row['cheque_no']; 
                        $totalweight = $row['totalweight'];

                        $total_adv=$adv_cash+$adv_other+$adv_consignor;
                        $freightamt=$row['freightamt'];
                         $final_rate= $row['freightamt']-$row['trip_commission'];
                         $trip_commission=$row['trip_commission'];
                         $commission=$row['commission'];
                          $deduct=$row['deduct'];
                           $tds_amt=$row['tds_amt'];
                            $destinationid = $row['destinationid'];
                          $toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");

                          $amount=$totalweight*$final_rate;
                            $netamount=$amount-$deduct;

                                $tds=$netamount*$tds_amt/100;
                                $total=$netamount-$tds;
                           $paidamount=$total-$commission-$adv_diesel-$total_adv;
                           $Profit=$totalweight*$trip_commission;


                    ?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                            <td><?php echo $row['lr_no'];?></td>
                        
                            
                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
                            <td><?php echo $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");

                     ?></td>
                            <td><?php echo $toplace; ?></td>
                            <td><?php echo $cmn->dateformatindia($row['confdate']);?>
                            <td><?php echo $cmn->dateformatindia($row['payment_date']);?>
                             </span>
                            </td>
                            <td><?php echo $payment_vochar;?></td>
                           <td><?php echo $totalweight;?></td>
                           <td><?php echo $freightamt;?></td>
                            <td><?php echo $final_rate; ?></td>
                             <td><?php echo $trip_commission;?></td>
                              <td><?php echo $commission;?></td> 
                              <td><?php echo round($tds);?></td>   
                              <td><?php echo $adv_diesel; ?></td>  
                              <td><?php echo $total_adv;?></td>                       
                            
                             <td><?php echo number_format(round($paidamount),2);?></td>
                              <td><?php echo number_format(round($Profit),2);?></td>
                             
                            <td><a href="pdf_paymentreceipt.php?bid_id=<?php echo $row['bid_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
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
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

</script>     
                
    
  </body>

  </html>
