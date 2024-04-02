<?php
error_reporting(0);
include("dbconnect.php");
$pagename  = 'inc_exp_report.php';
$modulename = "Expenses Report ";



if (isset($_GET['fromdate']) != "" && isset($_GET['todate']) != "") {
	   $fromdate =$_GET['fromdate'];
         
    $todate =$_GET['todate'];
    // $main_head_id = trim(addslashes($_GET['main_head_id']));
	$driver_id = trim(addslashes($_GET['driver_id']));
}
else
{
    $fromdate = date('Y-m-01');
	$todate = date('Y-m-d');
	
}

if(isset($_GET['inc_ex_id']))
{
	$inc_ex_id=trim(addslashes($_GET['inc_ex_id']));
}
else
$inc_ex_id='';
if(isset($_GET['category']))
{
	$category=trim(addslashes($_GET['category']));
}
else
$category='';

if($fromdate !='' && $todate !='')
{
		$crit.=" where exp_date BETWEEN  '$fromdate' and  '$todate' ";
		//echo $crit;
}

if($inc_ex_id !='') {
	$crit .=" and inc_ex_id='$inc_ex_id'";

}

if($category !='') {
	$crit .="and category='$category'  ";
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
								<h3><i class="icon-edit"></i>Return Trip Report</h3>
								<?php include("../include/page_header.php"); ?>
							</div>

							<form method="get" action="" class='form-horizontal' enctype="multipart/form-data">
								<div class="control-group">
									<table class="table table-condensed">
										<tr>
											<td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
										</tr>

										<tr>
											<th style="text-align:left;">From Date</th>
											<th style="text-align:left;"> To Date</th>
											<th> <strong>Truck No </strong></th>
											<th> <strong>Consignor </strong></th>
											<th> <strong>Action </strong></th>



										</tr>
										<tr>

											<td> <input type="date" name="fromdate" id="fromdate" placeholder="Text input" class="form-control" value="<?php echo $fromdate; ?>" required>
											</td>
											<td> <input type="date" name="todate" id="todate" placeholder="Text input" class="form-control" value="<?php echo $todate; ?>" required>
											</td>
											<td>
                                            <select data-placeholder="Choose a Country..." name="category" id="category"  class="form-control" >
										<option value="">Select category</option>
										<option value="Consignee">Consignee</option>
										<option value="Consignor">Consignor</option>
										<option value="Self">Self</option>



										<script>
											document.getElementById('category').value = '<?php echo $category; ?>';
										</script>
									</select>


											</td>

											<td>
                                            <select data-placeholder="Choose a Country..." name="inc_ex_id" id="inc_ex_id" style="width:250px" tabindex="3" class="formcent select2-me" >
                            <option value="">Select  Name</option>
                            <?php
                            $sql = mysqli_query($connection, "select * from inc_ex_head_master  order by inc_ex_id");
                            while ($row = mysqli_fetch_array($sql)) {

                            ?>
                              <option value="<?php echo $row['inc_ex_id']; ?>"><?php echo $row['incex_head_name']; ?></option>

                            <?php } ?>
                            <script>
                              document.getElementById('inc_ex_id').value = '<?php echo $inc_ex_id; ?>';
                            </script>

                          </select>
											</td>

											<center>
												<td>

													<input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
													<a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
												</td>
											</center>

										</tr>



									</table>
								</div>
							</form>

						</div>
					</div>
				</div>
				<!--   DTata tables -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i>Return Trip Details</h3>
							</div>
							<a class="btn btn-primary btn-lg" href="excel_inc_exp_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $consignorid; ?>&truckid=<?php echo $truckid; ?>" target="_blank" style="float:right;"> Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                        <th>Sno </th>

<th>Expense Date </th>
  <th>Trip No./LR No. </th> 
  <th>Vehicle No. </th> 
<!--<th>Party Billing Type </th> -->
<th>Category</th>
<!--<th>Qty/MT/DayTrip</th>-->
<th>Income / Expense Head </th>
<!--<th>Frieght Amt </th>-->
<!--<th>Trip Expenses </th>-->
<th> Amount </th>
										</tr>
									</thead>
									<tbody>
                                    <?php
                   	     $sn=1;  
                        //  echo "SELECT * from trip_expenses  $crit";
                  $sel = "SELECT * from trip_expenses  $crit";
        $res = mysqli_query($connection,$sel);
                                    while($row = mysqli_fetch_array($res))
                                    {
           
//  $trip_no=$cmn->getvalfield($connection,"trip_entry","trip_no","trip_id='$row[trip_id]'");   
//  $loding_date=$cmn->getvalfield($connection,"trip_entry","loding_date","trip_id='$row[trip_id]'");   
  $truckid=$cmn->getvalfield($connection,"trip_entry","truckid","trip_no='$row[trip_no]'");   
//  $qty_mt_day_trip=$cmn->getvalfield($connection,"trip_entry","qty_mt_day_trip","trip_id='$row[trip_id]'");   
	$truckno = $cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$truckid'");
// $rate=$cmn->getvalfield($connection,"trip_entry","rate","trip_id='$row[trip_id]'");   
// $frieght_amt=$cmn->getvalfield($connection,"trip_entry","frieght_amt","trip_id='$row[trip_id]'");   
// $trip_expenses=$cmn->getvalfield($connection,"trip_entry","trip_expenses","trip_id='$row[trip_id]'");   
$incex_head_name=$cmn->getvalfield($connection,"inc_ex_head_master","incex_head_name","inc_ex_id='$row[inc_ex_id]'");   
$gross_amt=$frieght_amt-$trip_expenses;
 $trip_no=$row['trip_no'];
 $loding_date=$row['loding_date'];
  $amount=$row['amt'];
 $category=$row['category']; 
     $tp_id=$row['tp_id'];   
     $totamount +=$row['amt'];
   
                           ?>
                                <tr>
                                                <td><?php echo $sn++;?></td> 
                                                <!--<td><?php echo date('Y-m-d', $loding_date);?></td>-->
                                                	<td><?php echo date('d-m-Y', strtotime($row['exp_date'])); ?></td>
                                                <td><?php echo $trip_no;?></td>
                                                <td><?php echo $truckno;?></td>
									 			<td><?php echo $category;?></td> 
									 				<td><?php echo $incex_head_name;?></td> 
									 				<!--<td><?php echo $qty_mt_day_trip;?></td> 	<td><?php echo $rate;?></td> 	<td><?php echo $gross_amt;?></td> 	<td><?php echo $tp_amount;?></td> -->
									 			<td><?php echo $amount;?></td> 
                              				


                                               
                                            <?php } ?>

									<tfoot>

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
		function funDel(id) {
			//alert(id);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				$.ajax({
					type: 'POST',
					url: '../ajax/delete.php',
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