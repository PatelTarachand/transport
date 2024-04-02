<?php 
include("dbconnect.php");

$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='excel_pentrol_advance_report.php';
$modulename = "Diesel Advance Report";

if(isset($_GET['supplier_id'])) {
		$supplier_id = trim(addslashes($_GET['supplier_id']));
	}
	else
	$supplier_id='';
	
	
  if(isset($_GET['truckid'])) {
    $truckid = trim(addslashes($_GET['truckid']));
  }
  else
  $truckid='';
	

if(isset($_GET['fromdate'])!='--') {
    $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  }
  else
  $fromdate=date('Y-m-d');

if(isset($_GET['todate'])!='--') {
    $todate = $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  }
  else
  $todate=date('Y-m-d');



	
	$crit = "";
  $cond="";
  $cond2="";
	if($supplier_id !='') {
		$crit = " and supplier_id='$supplier_id' ";
		}

	if($truckid !='') {
		$crit = " and truckid='$truckid'";
		}


if($fromdate !='--' && $todate !='--' ) {
  $cond = "and DATE_FORMAT(adv_date,'%Y-%m-%d') between '$fromdate' and '$todate' "; 
  
}
 
 $companyname = $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'");

// The function header by sending raw excel
	header("Content-type: application/vnd-ms-excel");
	$filename ="Diesel_advanceReport.xls";
	// Defines the name of the export file "codelution-export.xls"
	header("Content-Disposition: attachment; filename=".$filename);



?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
									    <tr>
									        <th colspan='6'><b><?php echo $companyname;?></b> </th>
									    </tr>
									    <tr>
									        <th >From Date : </th>
									        <th colspan='2'><?php echo $fromdate ;?> </th>
									        <th > To Date </th>
									        <th colspan='2' ><?php echo $todate; ?>  </th>
									    </tr>
									    									    <tr>
									        <th colspan='6'><b>Advance Diesel Report</b> </th>
									    </tr>
									    
										<tr>
											
                                             <th>S No</th>
                                                <th>LR No</th>
                                                <th>Advance Date</th>
                                                <th>Diesel Pump</th>
                                                <th>Truck No. </th>
                                                
                                                <th>Advance Diesel</th>   
                                                                              	 
										</tr>
									</thead>
                                    <tbody>
                                    <?php
											$netbilty =0;
										 
											$slno = 1;
									 $sql_table = "select * from bidding_entry where 1=1 $crit $cond and compid='$compid' and sessionid=$sessionid order by adv_date desc";
											 
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
												$consignor = $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row_table[consignorid]'");


                        $sql_supp= mysqli_query($connection,"select supplier_id,supplier_name from inv_m_supplier where supplier_id='$supplier_id'");
                        $row_supp = mysqli_fetch_array($sql_supp);
												
											?>
                                            	<tr>
                                                    <td><?php echo $slno++; ?></td>

                                                     <td><?php echo $row_table['lr_no']; ?></td>
                                                     <td><?php echo $row_table['adv_date']; ?></td>
                                                    <td><?php echo $row_supp['supplier_name']; ?></td>

                                                    <td><?php echo $truckno; ?></td>
                                                   
                                <td style="text-align:right"><?php echo number_format(round($row_table['adv_diesel']),2); ?></td>
                                                   
                                                    
                                                   
                                                </tr>
                                            
                                            <?php
											$net_adv_diesel += $row_table['adv_diesel'];
											}
											?>
                                            
                                       
                                        </tbody>
                                        <tfoot class="bg-light-blue">
                                           <tr>
                                                                                               
                                                <th colspan='5' style="text-align:right">Total</th>                                                
                                                                                   
                                                <th  style="text-align:right"><i class="fa fa-inr"></i> <?php echo number_format(round($net_adv_diesel),2); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>


<script>window.close();</script>