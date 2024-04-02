<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "materialin";
$tblpkey = "matin_id";
$pagename = "material_in_detail.php";
$modulename = "Scrap Detail";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


if (isset($_GET['search'])) {
  $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  $todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
    $truckid = trim(addslashes($_GET['truckid']));
  $itemid = $_GET['itemid'];
  $driver = $_GET['driver'];
} else {
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
  $itemid = '';
   $truckid = '';
   $driver='';
}


$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and B.issudate between '$fromdate' and '$todate' ";
}
if ($truckid != '') {
  $crit .= " and truckid='$truckid' ";
}

if ($itemid != '') {
  $crit .= " and itemid='$itemid' ";
}

if ($driver != '') {
  $crit .= " and driver='$driver' ";
}


$cond  = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $cond .= " and  A.createdate between '$fromdate' and '$todate' ";
}

if ($truckid != '') {
  $cond .= " and truckid='$truckid' ";
}

if ($itemid != '') {
  $cond .= " and itemid='$itemid' ";
}

if ($driver != '') {
  $cond .= " and driver='$driver' ";
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

              <div class="box-title">

                <?php include("alerts/showalerts.php"); ?>

               <h3><i class="icon-edit"></i>Scrap Report</h3>

                <?php include("../include/page_header.php"); ?>

              </div>

              <div class="box-content">

                <form method="get" action="">


                 
                  <table width="100%">
                    <tr>
                      <th width="10%" style="text-align:left;">From Date : </th>
                      <th width="10%" style="text-align:left;">To Date : </th>
                       <th width="10%" style="text-align:left;">Truck No. : </th>
                    <th width="15%" style="text-align:left;">Driver Name : </th>
                    <th width="15%" style="text-align:left;">Item Name : </th>
                      <th width="20%" style="text-align:left;">Action : </th>
                    </tr>
                    <tr>
                      <td> <input class="formcent" type="text" name="fromdate" id="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off"></td>
                      <td> <input class="formcent" type="text" name="todate" id="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off"></td>

<td>
                        <select id="truckid" name="truckid" class="formcent select2-me" style="width:180px;">
                          <option value=""> - Select - </option>
                          <?php
                          $sql_fdest = mysqli_query($connection, "select truckid,truckno from m_truck order by truckno");
                          while ($row_fdest = mysqli_fetch_array($sql_fdest)) {
                          ?>
                            <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                          <?php
                          } ?>
                        </select>
                        <script>
                          document.getElementById('truckid').value = '<?php echo $truckid; ?>';
                        </script>

                      </td>
                      <td><select name="driver" id="empid" class="select2-me input-large">
                          <option value="">-select-</option>
                          <?php
                          $sql = mysqli_query($connection, "Select empid,empname from m_employee  where designation='1'");
                          if ($sql) {
                            while ($row = mysqli_fetch_assoc($sql)) {
                          ?>
                              <option value="<?php echo $row['empid']; ?>"><?php echo strtoupper($row['empname']); ?></option>
                          <?php
                            }
                          }
                          ?>

                        </select>

                        <script>
                          document.getElementById('empid').value = '<?php echo $driver; ?>';
                        </script>
                      </td>


                      <td>

                        <select id="itemid" name="itemid" class="select2-me" style="width:300px;">
                          <option value="">--Choose Item--</option>
                          <?php
                          //where cat_id not in (5,8)
                          $resprod = mysqli_query($connection, "select * from purchasentry_detail  order by itemid");
                          while ($rowprod = mysqli_fetch_array($resprod)) {
                            $item_name = $cmn->getvalfield($connection, "items", "item_name", "itemid='$rowprod[itemid]'");
													$itemcatid = $cmn->getvalfield($connection, "items", "itemcatid", "itemid='$rowprod[itemid]'");
													$item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$itemcatid'");
                            

                          ?>
                            <option value="<?php echo $rowprod['itemid']; ?>"><?php echo  $item_name; ?>/<?php echo $item_category_name; ?>/<?php echo $rowprod['serial_no']; ?></option>
                          <?php
                          }
                          ?>
                        </select>
                         <script>
                          document.getElementById('itemid').value = '<?php echo $itemid; ?>';
                        </script>

                      </td>

                      






                      <td>
                        <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                      </td>
                    </tr>


                  </table>
                  </fieldset>
                </form>

              </div>

            </div>

          </div>

        </div>

        <!--   DTata tables -->

        <div class="row-fluid">

          <div class="span12">

            <div class="box box-bordered">

              <div class="box-title">

                <h3><i class="icon-table"></i><?php echo $modulename; ?> </h3>
                <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="excel_scrap_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn btn-primary" target="_blank">
                  <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print Excel</span></a></p>



              </div>


              


				  <div class="box-content nopadding">
 <?php if($itemid!=''){?>
<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">

	<thead>
		<tr>   
				<th>Sno</th>  
				<th>Item Name</th> 
				<th>Unit</th> 
     
				<th>Truck No</th>
				<th>Driver Name</th>
				<th>Issue No</th>
				<th>Issue Date</th>  
											  
				<th>Scrap Qty</th>                                      
				<!-- <th class='hidden-480'>Action</th>  -->
		</tr>
	</thead>
	<tbody>
	  <?php
 $slno = 1;

// echo "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid  $crit and A.is_rep='Scrap'";
              $sel = "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid  $crit   and A.is_rep='Scrap'";
              $res = mysqli_query($connection, $sel);
              while ($row = mysqli_fetch_array($res)) {
                $itemid = $row['itemid'];
                $unitid = $row['unitid'];
              	$empid = $row['driver'];
                $truckid = $row['truckid'];
                
                 $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$row[itemcatid]'");
	$serial_no = $cmn->getvalfield($connection, "purchasentry_detail", "serial_no", "purdetail_id='$row[purdetail_id]'");
  $maxissueid = $cmn->getvalfield($connection, "issueentrydetail", "max(issueid)", "itemid='$itemid' && is_rep ='Scrap'");
    // $maxissueid = $cmn->getvalfield($connection, "issueentrydetail", "count(issueid)", "itemid='$itemid' && is_rep ='Scrap'");
		   $maxissudate = $cmn->getvalfield($connection, "issueentry", "issudate", "issueid='$maxissueid'");
		   $maxissuno = $cmn->getvalfield($connection, "issueentry", "issuno", "issueid='$maxissueid' ");
	?>

		<tr>

    <td><?php echo $slno; ?></td>
    <td><?php echo  $cmn->getvalfield($connection,"items","item_name","itemid='$itemid'"); ?>/<?php echo $item_category_name;  ?>/<?php echo $serial_no;  ?></td>
    <td><?php echo $row['unitname']; ?></td>
                        <td><?php echo  $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'"); ?></td>
                      

                       
                        <!-- <td><?php echo $row['is_rep']; ?></td> -->
                        <td><?php echo  $cmn->getvalfield($connection,"m_employee","empname","empid='$empid'"); ?></td>
                    
                        <td><?php echo $row['issuno'];?></td>
                        <td><?php echo $cmn->dateformatindia($row['issudate']); ?></td>
                     
                        
                        <td><?php echo $row['qty']; ?></td>
  
		   <!-- <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a> -->
		   
		</tr>

		<?php

	$totalqty+=$row['qty'];

	}

	?>
	<tfoot>
<tr><th></th><th></th><th></th><th></th><th></th><th></th><th>Total</th><th> <?php echo $totalqty; ?></th></tr>

</tfoot>	

	</tbody>

	

</table>
<?php } else {?>


                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">

                  <thead>
                    <tr>
                      <th>Sno</th>
                      <th>Truck No</th>
                      <th>Driver Name</th>
                      <th>Issue No</th>
                      <th>Issue Date</th>
                      <th>Meter Reading</th>
                      <th>Return Category</th>
                      <th>Remark</th>
                      <th>Total Qty</th>
                      <th>Print</th>

                      <th class='hidden-480'>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $slno = 1;



                 

                   
                    //   echo "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid  $cond   and A.is_rep='Scrap'";
                      $sel = "select * from issueentrydetail as A left join issueentry as B on A.issueid = B.issueid  $cond  and A.is_rep='Scrap'";
                    
                    $res = mysqli_query($connection, $sel);
                    while ($row = mysqli_fetch_array($res)) {
                      $truckid = $row['truckid'];
                      $driver = $row['driver'];
                      $itemid = $row['itemid'];
                      // $purchaseamt = $cmn->getPurchaseAmt($connection,$row['issueid']);
                      $drivername = $cmn->getvalfield($connection, "m_employee", "empname", "empid='$driver'");
                      $is_repname = $cmn->getvalfield($connection, "issueentrydetail", "is_rep", "issueid='$row[issueid]'");
                      $total_qty = $cmn->getvalfield($connection, "issueentrydetail", "sum(qty)", "issueid='$row[issueid]'");
                    ?>

                      <tr>

                        <td><?php echo $slno; ?></td>
                        <td><?php echo  $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'"); ?></td>
                        <td><?php echo $drivername; ?></td>

                        <td><?php echo $row['issuno']; ?></td>
                        <td><?php echo $cmn->dateformatindia($row['issudate']); ?></td>
                        <td><?php echo $row['meterread']; ?></td>
                        <td><?php echo  $is_repname; ?></td>
                        <td><?php echo ucfirst($row['remark']); ?></td>
                        <td><?php echo $total_qty; ?></td>

                        <td>
                          <a href="print_scrap.php?issueid=<?php echo ucfirst($row['issueid']); ?>" target="_blank" class="btn btn-warning">Print</a>
                        </td>
                        <td class='hidden-480'>
                          <a href="issueentry.php?issueid=<?php echo $row['issueid']; ?>"><img src="../img/b_edit.png" title="Edit"></a>
                          <!-- onClick="edit(<?php echo $row['issueid']; ?>)" -->
                          &nbsp;&nbsp;&nbsp;
                          <?php if ($usertype == "admin") { ?><a onClick="funDel('<?php echo $row['issueid'];  ?>')"><img src="../img/del.png" title="Delete"></a><?php } ?>
                        </td>
                      </tr>

                    <?php
$totalqty+=$total_qty;
                      $slno++;
                    }

                    ?>


	<tfoot>
<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th>Total</th><th> <?php echo $totalqty; ?></th><th></th><th></th></tr>

</tfoot>
                  </tbody>



                </table>
<?php } ?>
</div>

</div>

</div>

</div>





</div>

</div></div>

<script>

$(function() {

 

   $('#open_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();

	

  

});

</script>

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

		url: '../ajax/delete_issue.php',

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





function hideval()

{

  var paymode = document.getElementById('paymode').value;

  if(paymode == 'cash')

  {

	  document.getElementById('checquenumber').disabled = true;

	  document.getElementById('bankname').disabled = true;

	  document.getElementById('checquenumber').value = "";

	  document.getElementById('bankname').value = "";

  }

  else

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

