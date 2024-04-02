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





?>

<!doctype html>

<html>

<head>

  <?php include("../include/top_files.php"); ?>

  <?php include("alerts/alert_js.php"); ?>



</head>



<body onLoad="hideval();">

  <?php include("../include/top_menu.php"); ?> <!--- top Menu----->



  <div class="container-fluid" id="content">



    <div id="main">

      <div class="container-fluid">



        <!--  Basics Forms -->

        <div class="row-fluid">

          <div class="span12">

            <div class="box">

              <div class="box-title" style="border-bottom:none;">

                <?php include("alerts/showalerts.php"); ?>

               <!--  <h3><i class="icon-edit"></i>Stock Report</h3> -->
                   
                <?php include("../include/page_header.php"); ?>

              </div>

              <!-- <div class="box-content">

                

              </div> -->

            </div>

          </div>

        </div>

        <!--   DTata tables -->

        <div class="row-fluid">

          <div class="span12">

            <div class="box box-bordered">

              <div class="box-title">

                <h3><i class="icon-table"></i><?php echo $modulename; ?> </h3>



              </div>


             


              <div class="box-content nopadding">

                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">

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

              </div>

            </div>

          </div>

        </div>





      </div>

    </div>
  </div>

  <script>
    $(function() {



      $('#open_date').datepicker({
        dateFormat: 'dd-mm-yy'
      }).val();





    });
  </script>

  <script>
    function funDel(id)

    {

      //alert(id);   

      tblname = 'issueentry';

      tblpkey = 'issueid';

      pagename = '<?php echo $pagename; ?>';

      modulename = '<?php echo $modulename; ?>';

      //alert(tblpkey); 

      if (confirm("Are you sure! You want to delete this record."))

      {

        $.ajax({

          type: 'POST',

          url: '../ajax/delete_issue.php',

          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,

          dataType: 'html',

          success: function(data) {

            // alert(data);

            // alert('Data Deleted Successfully');

            location = pagename + '?action=10';

          }



        }); //ajax close

      } //confirm close

    } //fun close





    function hideval()

    {

      var paymode = document.getElementById('paymode').value;

      if (paymode == 'cash')

      {

        document.getElementById('checquenumber').disabled = true;

        document.getElementById('bankname').disabled = true;

        document.getElementById('checquenumber').value = "";

        document.getElementById('bankname').value = "";

      } else

      {

        document.getElementById('checquenumber').disabled = false;

        document.getElementById('bankname').disabled = false;

      }

    }
  </script>

</body>

<?php

/*<script>

    // autocomplet : this function will be executed every time we change the text

    function autocomplet() {

    var min_length = 0; // min caracters to display the autocomplete

    var keyword = $('#country_id').val();

    if (keyword.length >= min_length) {

    $.ajax({

    url: '\autocomplete/ajax_refresh.php',

    type: 'POST',

    data: {keyword:keyword},

    success:function(data){

    $('#country_list_id').show();

    $('#country_list_id').html(data);

    }

    });

    } else {

    $('#country_list_id').hide();

    }

    }

     

    // set_item : this function will be executed when we select an item

    function set_item(item) {

    // change input value

    $('#country_id').val(item);

    // hide proposition list

    $('#country_list_id').hide();

    }

</script>*/



?>



</html>

<?php

mysqli_close($connection);

?>