<?php  error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='tyre_stock_report.php';
$modulename = "Billty Report";
$crit = " where 1=1 ";
if(isset($_GET['fromdate']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	
}
else
{
	$fromdate = date('Y-m-d');
}


if(isset($_GET['todate']))
{
	
	$todate = trim(addslashes($_GET['todate']));
}
else
{	
	$todate = date('Y-m-d');
}

if(isset($_GET['tnumber']))
{
	$tnumber = trim(addslashes($_GET['tnumber']));
	
}
else
{
	$tnumber ="";
}


if(isset($_GET['supplier_id']))
{
	$supplier_id = trim(addslashes($_GET['supplier_id']));
	
}
else
{
	$supplier_id = "";
}

if(isset($_GET['tsize']))
{
	$tsize = trim(addslashes($_GET['tsize']));
	
}
else
{
	$tsize ="";
}


if($fromdate!="" && $todate!="")
	{
	$crit .= " and  A.invoicedate between '$fromdate' and '$todate' ";
	}
	
	if($tnumber!="")
	{
		$crit .= " and  A.tnumber ='$tnumber'"; 
	}
	
	if($supplier_id !="")
	{
	$crit .= " and  A.supplier_id ='$supplier_id'"; 
	}
	
	if($tsize !="")
	{
	$crit .= " and  A.tsize  = '$tsize'"; 
	}
// The function header by sending raw excel
	 header("Content-type: application/vnd-ms-excel");
	$filename ="tyre_stock_report.xls";
	// Defines the name of the export file "codelution-export.xls"
	 header("Content-Disposition: attachment; filename=".$filename);



?>


<table class="table table-hover table-nomargin table-bordered">
									<thead>
                                    <tr>
                                    		<th colspan="7">Tyre Stock Report</th>                                    
                                    </tr>
										<tr>
                                            <th>Sno</th> 
                                            <th>Tyre Manufacture</th>
                                            <th>Tyre Number</th>
                                            <th>Invoice Date</th>
                                            <th width="15%">Invoice Number</th>
                                            <th>Amount</th>
                                            <th>Supplier</th>                            					 																	
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
						  $sel = "select A.* from tyre_purchase as A left join tyre_map as B on A.tid=B.tid $crit and B.tid is NULL order by A.tid desc"; 
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{										
									?>

										<tr>
                                                <td><?php echo $slno; ?></td>
                                                <td><?php echo $row['tmanufacture'];?></td>
                                                <td><?php echo $row['tnumber'];?></td>
                                                <td width="15%"><?php echo $cmn->dateformatindia($row['invoicedate']);?></td>
                                                <td><?php echo ucfirst($row['invoiceno']);?></td>
                                                <td><?php echo ucfirst($row['trate']);?></td>
                                                <td><?php echo $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id = '$row[supplier_id]'");?></td>
								    	</tr>
                                        <?php
										$slno++;
									}
									
									
									?>                                    
                                     
									</tbody>
							</table>
                            
            
   
                
                            
 <script>window.close();</script>