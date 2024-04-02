<?php
error_reporting(0);
ini_set("memory_limit","1500M");
 include("dbconnect.php");

$pagename = 'advance_cash_report.php';
$pageheading = "Cash Advance Report Detail";
$mainheading = "Cash Advance Report Detail";


// if(isset($_GET['supplier_id'])) {
// 		$supplier_id = trim(addslashes($_GET['supplier_id']));
// 	}
// 	else
// 	$supplier_id='';
	
	
//   if(isset($_GET['truckid'])) {
//     $truckid = trim(addslashes($_GET['truckid']));
//   }
//   else
//   $truckid='';
	

if(isset($_GET['fromdate'])) {
    $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])) {
    $todate = $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  }
  else
  $todate=date('Y-m-d');



	
// 	$crit = "";
//   $cond="";
//   $cond2="";
// 	if($supplier_id !='') {
// 		$crit = " and supplier_id='$supplier_id' ";
// 		}

// 	if($truckid !='') {
// 		$crit = " and truckid='$truckid'";
// 		}


if($fromdate !='--' && $todate !='--' ) {
  $cond = "and DATE_FORMAT(adv_date,'%Y-%m-%d') between '$fromdate' and '$todate' "; 
  
}


?>

<!DOCTYPE html>
<html>
    <head>
    	<title>Cash Advance Report </title>  
	<?php include("../include/top_files.php"); ?>
    </head>
      <script>
      $(function() {
       
      $('#fromdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       $('#todate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
         
      
      
      });
    </script>
    <body >
        <?php include("../include/top_menu.php"); ?>
        <!-- header logo: style can be found in header.less -->
        <div  style="width:100%;border-radius:5px;">
       <table  width="60%" align="center">
       <tr>
    <td colspan="3" style="text-align:left;font-weight:bold;"> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; </td>
    <td align="center"><span style="font-size:20px;"> <br/><strong>	SHIVALI LOGISTICS</strong></span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span><br />
    <span style="color:#000;font:'Times New Roman', Times, serif;font-size:14px;font-weight:bold;"> </span></td>
    <td colspan="4" style="text-align:right;font-weight:bold;">Mobile No. 7354020270</td>
  </tr>
       </table>
                               
								<form action="" method="Get" >
                                    <table  width="60%" align="center">
                                   
                                    	<tr>
                                     
      
                                               <td><strong>From </strong></td>
                                        <td>  <input type="date" name="fromdate" id="fromdate"   value="<?php echo @$_GET['fromdate']; ?>" tabindex="10" style="width:150px;margin-bottom:0px;" >

                                        <td><strong>To</strong> </td>
                                        <td>
                                          <input type="date" name="todate" id="todate"   value="<?php echo @$_GET['todate']; ?>"  tabindex="10" style="width:150px;margin-bottom:0px;" >
                                        
                                        </td>                                     
                                        	
                                          
                                         <td width="37%" >
                                        
										 <input type="submit" name="submit"  value="Search" class="btn btn-success"  style="width:150px; margin:0px 10px">
                                         
										 <input type="button" class="btn btn-danger"  onclick="document.location='<?php echo $pagename; ?>'"  name="reset_dept" value="Reset" >
                                       
                                         </td>
                                       </tr>
                                    </table>
								</form>	
                             
					<div>
                            <!-- /.box -->
                             <?php $prevbalance = 0;?>
                             
                          
                            
                          <div align="center">
                          <hr>
                          
                          <table width="98%">
                          	<tr>
                            	<td colspan="2">
                               
                               <a  style="float:right;  " href="excel_advance_cash_report.php?fromdate=<?php echo $_GET['fromdate']; ?>&todate=<?php echo $_GET['todate']; ?>" target="_blank"> <button class="btn btn-primary right" >Download Excel</button></a>
                                </td>
                            </tr>
                          </table>
                          </div>    
                        <div style="width:100%; float:left; margin-left: 10px;">
                           
                           <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						
						<div class="box-title">
								<h3><i class="icon-table"></i> Advance Cash Report Details</h3>
							</div>
							
							<div class="box-content nopadding">
                               
                                    <table border="1" width="100%">
                                        <thead style="background: burlywood;">
                                       
                                            <tr>
                                                <th>S No</th>
                                                <th>LR No</th>
                                                <th>Advance Date</th>
                                                <th>Truck Owner</th>
                                                <th>Truck No. </th>
                                                
                                                <th>Advance Cash</th> 
                                                  <th>Advance Cash (Consignor)</th>   
                                                <th>OtherAdvance </th>   
                                                
                                               	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
											$netbilty =0;
										 
											$slno = 1;
									 $sql_table = "select * from bidding_entry where 1=1 $crit $cond  and compid='$compid' and sessionid = $sessionid order by adv_date desc";
											 
											$res_table = mysqli_query($connection,$sql_table);
											while($row_table = mysqli_fetch_assoc($res_table))
											{
											    
											    $freightamt=$row_table['freightamt'];
											    $comp_rate=$row_table['comp_rate'];
                           $supplier_id=$row_table['supplier_id'];

											    if($comp_rate==0){
											        $new_comp=$freightamt;
											    }else{
											        $new_comp=$comp_rate;
											    }
												$biltyAmt = $row_table['totalweight'] * $new_comp;
												$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row_table[truckid]'");
												
												$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row_table[truckid]'");
												$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
												
												
												$consignor = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row_table[consignorid]'");


                        $sql_supp= mysqli_query($connection,"select supplier_id,supplier_name from inv_m_supplier where supplier_id='$supplier_id'");
                        $row_supp = mysqli_fetch_array($sql_supp);
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>

                                                     <td><?php echo $row_table['lr_no']; ?></td>
                                                     <td><?php echo $cmn->dateformatusa(trim(addslashes($row_table['adv_date']))); ?></td>
                                                
                                                    <td><?php echo $ownername; ?></td>
                                                    <td><?php echo $truckno; ?></td>
                                                   
                                <td style="text-align:right"><?php echo number_format(round($row_table['adv_cash']),2); ?></td>
                                <td style="text-align:right"><?php echo number_format(round($row_table['adv_other']),2); ?></td>
                                 <td style="text-align:right"><?php echo number_format(round($row_table['adv_consignor']),2); ?></td>                  
                                                    
                                                   
                                                </tr>
                                            
                                            <?php
											$net_adv_diesel += $row_table['adv_cash']+$row_table['adv_other']+$row_table['adv_consignor'];
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                               
                                                <th colspan='5' style="text-align:right">Total</th>                                                
                                                                                   
                                                <th  colspan='2' style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($net_adv_diesel),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                   
                             
                        </div>
                      
                    </div>
                  
			</div>
                      
                    </div>
                    </div>
                      
                   		
                    

                        
                       
         
                </div>
           <script>
           function getTruckNolist(id) {
				$.ajax({
					type: 'POST',
					url: 'gettrucklistownerwise.php',
					data: 'id=' + id,
					dataType: 'html',
					success: function(data){
						//alert(data);
						$('#truckid').html(data);
					}				
				});//ajax close
			   }
           </script>
    </body>
</html>