<?php
error_reporting(0);
include("dbconnect.php");

$pagename = "stock_report.php";
$modulename = "Stock Report Detail";

if (isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
else
  $action = 0;


if (isset($_GET['search'])) {
  $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  $todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  
  $itemid = $_GET['itemid'];
} else {
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
  $itemid = '';
  
}


$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and  issudate between '$fromdate' and '$todate' ";
}


header("Content-type: application/vnd-ms-excel");
$filename = "Stock Report.xls";
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=" . $filename);

?>

<!doctype html>

<html>

<head>
</head>

<body>

	<table border="1">

		<thead>
			<tr>
           <th width="3%">SN</th>
             <th width="31%"> Item Name</th>
      <th width="31%">Purchase Stock</th>
      <th width="25%">Issue Stock</th>
         <th width="25%">Scrap Stock</th>
            <th width="25%">Repair Stock</th>
               <th width="25%">Exchange Stock</th>
      <th width="30%">Stock.</th>
			</tr>
		</thead>
		<tbody>
        <?php
                    $slno =1;
       
       $sqlget = mysqli_query($connection, "select * from items;");
       $rowcount = mysqli_num_rows($sqlget);
       while ($rowget = mysqli_fetch_assoc($sqlget)) {
   
         $issuedetailid = $rowget['issuedetailid'];
         $itemid = $rowget['itemid'];
         $issueid = $rowget['issueid'];
         $unitname = $rowget['unitname'];
         $is_rep = $rowget['is_rep'];
         $excrec = $rowget['excrec'];
         $qty = $rowget['qty'];
         $remark1 = $rowget['remark1'];
         $stock = $rowget['stock'];
         $itemcatid = $rowget['itemcatid'];
         
         $itemid = $cmn->getvalfield($connection, "issueentrydetail", "itemid", "issueid='$issueid'");
        	 $purchasentryqty= $cmn->getvalfield($connection, "purchasentry_detail", "sum(qty)", "itemid='$rowget[itemid]'");
        	   $issueqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$rowget[itemid]'");
        	 
  $Scrapqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$rowget[itemid]' &&  is_rep='Scrap'");
    $Repairedqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$rowget[itemid]' &&  is_rep='Repaired'");
     $Exchangeqty = $cmn->getvalfield($connection,"issueentrydetail","sum(qty)","itemid='$rowget[itemid]' &&  is_rep='Exchange'");
         $itemcategoryname = $cmn->getvalfield($connection, "items", "item_name", "itemid='$itemid'");
         $issuedetailid = $cmn->getvalfield($connection, "issueentrydetail", "issuedetailid", "itemid='$itemid'");
          $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid'");
        $unit_name = $cmn->getvalfield($connection,"m_unit","unitname","unitname='$unitname'");
    
        
        
        
      if($purchasentryqty==''){
          $purchasentryqty='0';
      }
      
       if($issueqty==''){
          $issueqty='0';
      }
       if($Scrapqty==''){
          $Scrapqty='0';
      }
         if($Repairedqty==''){
          $Repairedqty='0';
      }
         if($Exchangeqty==''){
          $Exchangeqty='0';
      }
        
        
        
        
        $stock = $purchasentryqty-$issueqty-$Scrapqty;



                    ?>

                      <tr>

                     <td><?php echo $slno++; ?></td>
                        <td><?php echo $rowget['item_name']; ?>/<?php echo $item_category_name; ?></td>
                        <td><?php echo $purchasentryqty; ?></td>
                        <td><?php echo $issueqty; ?></td>
                         <td><?php echo $Scrapqty; ?></td>
                          <td><?php echo $Repairedqty; ?></td>
                           <td><?php echo $Exchangeqty; ?></td>
                        <td><?php echo $stock; ?></td>

                       
                        </td>
                      </tr>

                    <?php

                      $totalqty+=$purchasentryqty;
                    $totalssueqty+=$issueqty;
                    $totalScrapqty+=$Scrapqty;
                     $totalRepairedqty+=$Repairedqty;
                      $totalExchangeqty+=$Exchangeqty;
                      $totalstock+=$stock;
                    }

                    ?>

<tfoot>
<tr><th></th><th>Total</th><th><?php echo $totalqty; ?></th><th><?php echo $totalssueqty; ?></th><th><?php echo $totalScrapqty; ?></th><th> <?php echo $totalRepairedqty; ?></th><th><?php echo $totalExchangeqty; ?></th><th><?php echo $totalstock; ?></th></tr>

</tfoot>


		</tbody>



	</table>
</body>


</html>