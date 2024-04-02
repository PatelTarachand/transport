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
   


<?php $enddateexpalert = date('Y-m-d', strtotime('+1 months')); ?>
     <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Licence lisenceexpiredate Report.</h3>
								<a class="btn btn-primary btn-lg" href="excel_builty_receive.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&di_no=<?php echo $di_no; ?>" target="_blank" style="float:right;"> Excel </a>
							</div>
							
							<div class="box-content nopadding" style='overflow:scroll'>
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
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
