<?php 
error_reporting(0);
include("dbconnect.php");
$pagename = "purchaseentry.php";
$tblname ="payment";
$tblpkey= "payment_id";
$modulename = "Payment ";

   $saleid = $_REQUEST['saleid'];
  $customer_id = $_REQUEST['customer_id'];
   // $purchase_date = $_REQUEST['purchase_date'];

if ($saleid != 0) {
   $saleid = $_REQUEST['saleid'];
} else {
   $saleid = 0;
}

if ($customer_id != 0) {
   $customer_id = $_REQUEST['customer_id'];
} else {
   $customer_id = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title></title>
</head>
<body>



<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                        <td>Sn</td>
                     	<td>Customer</td>
                        <td>Paid Amount</td>
						<td >Disc Amount</td>
                        <td >Payment Mode</td> 
                        <td >Narration</td> 
                        <td >Print</td>
                        <td >Action</td>

                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php 	
					$sn=1;					
					$netpaiamt=0;
					
						$sql = mysqli_query($connection,"select * from payment where  type='sale' && iscomp=0 order by paymentid desc"); 
						while($row=mysqli_fetch_assoc($sql))
						{
						
					 ?>
                     <tr class="abc" tabindex="<?php echo $sn; ?>" onfocus="fff(<?php echo $sn; ?>);" id="abc<?php echo $sn; ?>">
							<td><?php echo $sn++; ?></td>
							<td> <?php echo $cmn->getvalfield($connection,"m_customer","customer_name","customer_id='$row[customer_id]'"); ?></td>

						<td style="text-align:right;"><?php echo number_format($row['paid_amt'],2); ?></td>
						<td style="text-align:right;"><?php echo number_format($row['discamt'],2); ?></td>
						<td><?php echo $row['pay_type']; ?></td>  
						<td><?php echo $row['narration']; ?></td>  
						             
                           <td><a href="pdf_sale_payment.php?paymentid=<?php echo $row['paymentid'];?>" target="_blank" class="btn btn-success">Print </a>

                                   </td>          
                          <td>
						  <input type="button" class="btn btn-primary" name="add_data_list" id="add_data_list" onClick="editselected('<?php echo $row['paymentid']; ?>','<?php echo $cmn->dateformatindia($row['paymentdate']); ?>','<?php echo $row['customer_id']; ?>','<?php echo $row['paid_amt']; ?>','<?php echo $row['narration']; ?>','<?php echo $row['discamt']; ?>','<?php echo $row['pay_type']; ?>');" value="E"> &nbsp;
                        
						     <input type="button" class="btn btn-danger" name="add_data_list" id="add_data_list" onClick="funDel1('<?php echo $row['paymentid']; ?>');" value="X">
                          </td>
                      </tr>
                                        <?php
										$slno++;
										 $totalamt+=$row['paid_amt'];
                              $total+=$row['discamt'];

									}
									?>
										<tr><th></th><th>Total</th><th style="text-align:right;"><?php echo number_format($totalamt,2);?></th><th style="text-align:right;"><?php echo number_format($total,2);?></th><th></th><th></th><th></th><th></th></tr>
									</tbody>
									
								</table>
                                </div>
					</div>
				</div>
				
   </body>
</html>
   <script type="text/javascript">


      
 function getTotal() {

               var qty = parseFloat(jQuery('#qty').val());
               var rate = parseFloat(jQuery('#rate').val());
               var disc_rs = parseFloat(jQuery('#disc_rs').val());
               var total_amt = parseFloat(jQuery('#total_amt').val());




               if (!isNaN(qty) && !isNaN(rate)) {
                  total = qty * rate;
                   //alert(total);
jQuery('#total_amt').val(total);
               }
               if (!isNaN(disc_rs)) {
                  total = qty * rate;
                  total = total - disc_rs;
                  jQuery('#total_amt').val(total);
               }
               // alert(total_amt);
               jQuery('#total_amt').val(total);
            }
   </script>