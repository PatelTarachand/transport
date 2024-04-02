<?php 
date_default_timezone_set("Asia/Kolkata");
include("dbconnect.php");
//print_r($_SESSION);

include("../lib/smsinfo.php");
$curdate= date('Y-m-d');
 $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($curdate)));
$yesterday = date('Y-m-d', strtotime($curdate . ' -1 day'));
$cmn = new Comman();
$todaybilty = $cmn->getvalfield($connection,"bidding_entry","count(*)","tokendate='$curdate' && sessionid='$sessionid' && is_bilty=1 and compid ='$compid' ");

$countbilling =  $cmn->getvalfield($connection,"bidding_entry","count(*)","voucher_id!='0' && sessionid='$sessionid' && compid ='$compid' "); 

$countbillingpending =  $cmn->getvalfield($connection,"bidding_entry","count(*)","voucher_id='0' && sessionid='$sessionid' && compid ='$compid'"); 





$todaycashadv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' "); 

$todaydieseladv = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid'");


$todaypayment = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$curdate' && sessionid='$sessionid' and compid ='$compid' ");

$total_pending_bilty_rec = $cmn->getvalfield($connection,"bidding_entry","count(*)","is_bilty=1 && sessionid='$sessionid' && isreceive=0 and compid ='$compid' ");

$total_pending_bidding = $cmn->getvalfield($connection,"bidding_entry","count(*)","sessionid='$sessionid' && is_bilty=0 and compid ='$compid'");




$todaybilty_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","tokendate='$curdate' && sessionid='$sessionid' && is_bilty=1 and compid ='$compid'");

$todaycashadv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_cash + adv_cheque + adv_other+ adv_consignor)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' ");

$todaydieseladv_emami = $cmn->getvalfield($connection,"bidding_entry","sum(adv_diesel)","adv_date='$curdate' && sessionid='$sessionid' && isdispatch=1 and compid ='$compid' ");


$todaypayment_emami = $cmn->getvalfield($connection,"bidding_entry","sum(cashpayment)","payment_date='$curdate' && sessionid='$sessionid' and compid ='$compid' ");

$total_pending_bilty_rec_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","is_bilty=1 && sessionid='$sessionid' && isreceive=0 and compid ='$compid' ");

$total_pending_bidding_emami = $cmn->getvalfield($connection,"bidding_entry","count(*)","sessionid='$sessionid' && is_bilty=0 and compid ='$compid'");

$currentdate =date('Y-m-d');
?>
<!doctype html>
<html>
<head>
    
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

	<?php include("../include/top_files.php"); ?>
	<style>
		p {
	padding-left: none;
		padding-right: none;
			padding-top: none;
				padding-bottom: none;
			font-size:1em;
			font-family: serif;
			color: red;
			font-weight: bold;
/*			text-align: center;*/
			animation: animate 1.5s linear infinite;
		}

		@keyframes animate {
			0% {
				opacity: 0;
			}

			50% {
				opacity: 0.7;
			}

			60% {
				opacity: 0;
			}
		}
		.fixTableHead { 
      overflow-y: auto; 
      height: 110px; 
    } 
    .fixTableHead thead th { 
      position: sticky; 
      top: 0; 
    } 
    table { 
      border-collapse: collapse;         
      width: 100%; 
    } 
    th, 
    td { 
      padding: 8px 15px; 
      border: 2px solid #529432; 
    } 
    th { 
      background: #ABDD93; 
    } 
	</style>
</head>


  <body>
	
	
		 <?php include("../include/top_menu.php"); ?>
   

<div class="container-fluid" id="content">
    
	<div id="main">
			<div class="container">
				<div class="page-header">
					<div class="pull-left">
						<h1>Welcome <?php echo ucfirst($cmn->getvalfield($connection,"m_userlogin","username","userid='$userid'")); ?></h1>
					</div>
					<div class="pull-right">
					  <marquee>  <h4 style="color:red;"><b>It is necessary to back up the database daily. Go to the user menu and click in the backup data base button.</b></h4></marquee>
					</div>
				</div>
				
				<div class="row">
				    
					<div class="col-md-3" style="display:none">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Opning Balance.
								</h3>
								
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php 

											echo $cmn->getcashopeningplant($connection,$curdate,$compid); ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3" >
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Today Bilty
								</h3>
								
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php echo isset($todaybilty) ? $todaybilty : '0' ; ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Today Cash Adv.
								</h3>
								
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php echo isset($todaycashadv) ? $todaycashadv : '0' ; ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Today Diesel Adv.
								</h3>
								
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php echo isset($todaydieseladv) ? $todaydieseladv : '0' ; ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Today Bilty Payment
								</h3>
								
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php echo round($todaypayment); ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="box box-color box-bordered">
							<div class="box-title">
								<h3>
									<i class="fa fa-bar-chart-o"></i>
									Pending Bilty To Rec.
								</h3>
								 
							</div>
							<div class="box-content">
								<div class="statistic-big">
									<div class="top">
										
										<div class="right">
											<?php echo $total_pending_bilty_rec; ?>
											<span>
												<i class="fa fa-arrow-circle-up"></i>
											</span>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
					<div class="box box-color  box-bordered">
						<div class="box-title">
							<h3>
							
								Today Dispatch Qty
							</h3>
							 
						</div>
						<div class="box-content">
							<div class="statistic-big">
								<div class="top">
									
									<div class="right">
										<?php 
										$grannd='';
										 $dateToday=date('Y-m-d');
											 $tdq="SELECT totalweight FROM `bidding_entry` WHERE tokendate ='$dateToday'";
											 	$res_tdq = mysqli_query($connection,$tdq);
	while($row_tdq = mysqli_fetch_array($res_tdq))
	{ 
			$total_weight=$row_tdq['totalweight'];
			@$grannd +=$total_weight;
	}
										 if($grannd!=''){
										 	echo @$grannd." MT";
										 }else{
										 	echo "0 MT";
										 } ?>
										<span>
											<i class="fa fa-arrow-circle-up"></i>
										</span>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
					<div class="col-md-3">
					<div class="box box-color  box-bordered">
						<div class="box-title">
							<h3>
							
								Current Month Dis.
							</h3>
							 
						</div>
						<div class="box-content">
							<div class="statistic-big">
								<div class="top">
									
									<div class="right">
										<?php 
										$granndMonth='';
										 $dateToday=date('m');
										 $currentYear=date('Y');

											  $tdqMonth="SELECT totalweight FROM `bidding_entry` WHERE tokendate BETWEEN '$currentYear-$dateToday-01' AND '$currentYear-$dateToday-31'";
											 	$res_tdqMonth = mysqli_query($connection,$tdqMonth);
	while($row_tdqMonth = mysqli_fetch_array($res_tdqMonth))
	{ 
			$total_weightMonth=$row_tdqMonth['totalweight'];
			@$granndMonth +=$total_weightMonth;
	}
										 if($granndMonth!=''){
										 	echo @$granndMonth." MT";
										 }else{
										 	echo "0 MT";
										 } ?>
										<span>
											<i class="fa fa-arrow-circle-up"></i>
										</span>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
				</div>
				<div class="container-fluid">

<?php $enddateexpalert = date('Y-m-d', strtotime('+1 months')); ?>
<div class="row" style="margin-left: -20px;     margin-right: -24px">
	<div class="col-sm-6">
		<div class="box box-color  box-bordered">
						<div class="box-title">
				<h3>

					Documents:
				</h3>

			</div>
			<div class="box-content" style="height:200px; overflow:scroll;padding:0">

				<table class="fixTableHead table table-hover table-nomargin" style="width:100%;white-space: nowrap">
				<thead>
			<th>S.no.</th>
			<th>Truck No.</th>		
			<!--<th> Expiry Date </th>-->
			<th>Document</th>		
			<?php
			$slno=1;
			$sel = "Select * from  doc_category_master";
			$res =mysqli_query($connection,$sel);
			while($row = mysqli_fetch_array($res))
			{
				
			?>
				 
					 
					  <th><?php echo  $row['doc_name']; ?></th>
			   <?php } ?>        
					  
			   
			</thead>
			<tbody>
			<?php
			$slno=1;
				  $currentdate1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($currentdate)) . "+10 day"));
		// 		 echo  "select * from truckupload  WHERE (expiry between '$currentdate1' and '$currentdate' ||  expiry > '$currentdate') && expiry !='0000-00-00' GROUP BY truckid ";
			$sel = "select * from truckupload  WHERE (expiry between '$currentdate1' and '$currentdate' ||  expiry > '$currentdate') && expiry !='0000-00-00' GROUP BY truckid " ;
			$res =mysqli_query($connection,$sel);
			while($row = mysqli_fetch_array($res))
			{
				
				$truck_no =$cmn->getvalfield($connection, "m_truck", "truckno", "truckid='$row[truckid]'");	
					 //echo $doc_expiry_date = date("d-m-Y", strtotime(date("Y-m-d", strtotime($row['expiry'])) . "-5 day"));
				 $currentdate;
		// 	  if ($doc_expiry_date <= $currentdate) { 
			?>
				<tr>
						<td><?php echo  $slno; ?></td>
						<td><?php echo  $truck_no; ?></td>
							<!--<td ><b><p  class="text-danger"><?php echo dateformatindia($row['expiry']); ?> </p></b></td>-->
						<!--<td><a href="uploaded/img/<?php echo $row['uploaddocument']; ?>"  class="btn btn-small btn-green" download>Download</a></td>-->
						
							<td><b><a href="uploaded/img/<?php echo $row['uploaddocument'] ?>" class="text-danger" target="_blank" download>Download</a></b></td>
						
			   <?php       
						$sel1 = "Select * from  doc_category_master";
			$res1 =mysqli_query($connection,$sel1);
			while($row1 = mysqli_fetch_array($res1))
			{
	
				$docid = $row1['docid'];
				
				$expdate =$cmn->getvalfield($connection, "truckupload", "expiry", "docid='$docid' && truckid='$row[truckid]'");
				$issuedate =$cmn->getvalfield($connection, "truckupload", "issuedate", "docid='$docid' && truckid='$row[truckid]'");
		// 		 echo "$expdate!='' && $currentdate1>$expdate || $issuedate!=''";
				
			?>
				 
				<?php if($expdate!='' && $currentdate1>$expdate){?>
					  <td>Expiry : <p><?php echo  dateformatindia($expdate);?></p></td>
			   <?php } else{?>
			   <td></td>
					  <?php }} ?>  
				  
				</tr>

				<?php

				$slno++;

			

			}?>

					</tbody>



					</thead>
				</table>


			</div>
		</div>
	</div>


				
	<div class="col-sm-6">
		<div class="box box-color  box-bordered">
						<div class="box-title">
				<h3>

			Driver	Licence expiry Report	:
				</h3>

			</div>
			<div class="box-content" style="height:200px; overflow:scroll;padding:0">

				<table class="fixTableHead table table-hover table-nomargin" style="width:100%;white-space: nowrap">
				<thead>
		<th>S.no.</th>
			<th>Employee Name</th>		
			<th> Mobile No </th>
				<th>Licence</th>
			<th>Licence Issue Date</th>
			<th>Licence expiry Date</th>
			   
			</thead>
			<tbody>
			<?php
			$slno=1;
				  $currentdate1 = date("Y-m-d", strtotime(date("Y-m-d", strtotime($currentdate)) . "+15 day"));
				//  echo  "select * from m_employee  WHERE (lisenceexpiredate between '$currentdate1' and '$currentdate' ||  lisenceexpiredate > '$currentdate') && lisenceexpiredate !='0000-00-00' GROUP BY empid ";
		
		
			$sel = "select * from m_employee  WHERE (lisenceexpiredate between '$currentdate1' and '$currentdate' ||  lisenceexpiredate > '$currentdate') && lisenceexpiredate !='0000-00-00' GROUP BY empid " ;
			$res =mysqli_query($connection,$sel);
			while($row = mysqli_fetch_array($res))
			{
				
				$truck_no =$cmn->getvalfield($connection, "m_truck", "truckno", "empid='$row[empid]'");	
					 //echo $doc_expiry_date = date("d-m-Y", strtotime(date("Y-m-d", strtotime($row['expiry'])) . "-5 day"));
				 $currentdate;
		// 	  if ($doc_expiry_date <= $currentdate) { 
			?>
				<tr>
						<td><?php echo  $slno; ?></td>
						<td><?php echo  $row['empname']; ?></td>
							<td><?php echo  $row['mob1']; ?></td>
						<td><b><a href="uploaded/emp_licence/<?php echo $row['upload_licence'] ?>" class="text-danger" target="_blank" download>Download</a></b></td>
							<td><?php echo  dateformatindia( $row['lisenceissuedate']); ?></td>
			   <?php       
						$sel1 = "Select * from  m_employee";
			$res1 =mysqli_query($connection,$sel1);
			while($row1 = mysqli_fetch_array($res1))
			{
	
			
				
				$expdate =$cmn->getvalfield($connection, "m_employee", "lisenceexpiredate", " empid='$row[empid]'");
				$issuedate =$cmn->getvalfield($connection, "m_employee", "lisenceissuedate", " empid='$row[empid]'");
		// 		 echo "$expdate!='' && $currentdate1>$expdate || $issuedate!=''";
				
			?>
				   <?php } ?> 
				<?php if($expdate!='' && $currentdate1>$expdate){?>
					  <td>Expiry : <p><?php echo  dateformatindia($expdate);?></p></td>
			   <?php } else{?>
			  
					  <?php } ?>  
				  <td><?php echo  dateformatindia( $row['lisenceexpiredate']); ?></td>
				</tr>

				<?php

				$slno++;

			

			}?>

					</tbody>



					</thead>
				</table>


			</div>
		</div>
	</div>

				</div>
                

				
			</div>
	</div>

	
				
</div>

	<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-38620714-4']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script');
		ga.type = 'text/javascript';
		ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(ga, s);
	})();
	</script>
	
	  <script>
(function blink() {
							$('#blink_me').fadeOut(500).fadeIn(500, blink);
						})();


 
 function myFunction() {
  setInterval(function(){ 
					   
			$.ajax({
		  type: 'POST',
		  url: 'getdashboardnotification.php',
		  data: '1=1',
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 
			 document.getElementById('div11').innerHTML=data;			 
						
			}		
		  });//ajax close		   
					   
					   },30000);
}


var sn=1;
function blink_text() {
							// $('.blink').fadeOut(500);
							// $('.blink').fadeIn(500);
							if (sn % 2 == 0) {
								$('.blink').css({
									"color": "red"
								}, 500);
							} else {
								$('.blink').css({
									"color": "black"
								}, 500);
							}


							sn = sn + 1;
						}

						setInterval(blink_text, 500);



  </script>
</body>
	</html>
<?php
mysqli_close($connection);
?>
