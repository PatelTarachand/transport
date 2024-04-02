<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "sservice_entry";
$tblpkey = "service_id";
$pagename = "service_report.php";
$modulename = "Service Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


$fromdate= $_GET['fromdate'];
$todate= $_GET['todate'];
$truckid= $_GET['truckid'];
$meachineid= $_GET['meachineid'];
$headid= $_GET['headid'];

$cond= "where 1=1";

if(isset($_GET['search']))
{
	$fromdate = trim(addslashes($_GET['fromdate']));
	$todate = trim(addslashes($_GET['todate']));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}


if($fromdate!='' && $todate!=''){

    $cond .= " and service_date between '$fromdate' and '$todate'";
}else{
    $fromdate= date('Y-m-d');
$todate=date('Y-m-d');
}

if($truckid!=''){

    $cond .= " and truckid ='$truckid'";
}else{
    $truckid='';
}

if($headid!=''){

    $cond .= " and headid ='$headid'";
}
else{
    $headid='';
}

if($meachineid!=''){

    $cond .= " and meachineid ='$meachineid'";
}
else{
    $meachineid='';
}
?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
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
								<h3><i class="icon-edit"></i>Service Report</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="get" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                            <td><strong>From Date</strong></td>
                                            <td><strong> To Date</strong></td>
                                            <td> <strong>Truck No.	</strong></td>
                                            <td><strong>Service Head:</strong></td>
                                            <td><strong>Mechanic Name:</strong></td>
											<!-- <td><strong>Action:</strong></td> -->
                                           
                                    </tr>
                                    <tr>
                                    <td>
                    				<input type="date" name="fromdate" value="<?php echo $fromdate; ?>" id="date" 
                                      class="input-large" >
                                    </td> 
                                     <td>
                    				<input type="date" name="todate" value="<?php echo $todate; ?>" id="date" 
                                      class="input-large" >
                                    </td>

                               
                                      <td>
									  <select id="truckid" name="truckid" class="select2-me input-large" style="width:220px;" onChange="getOwner(this.value);" \ >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"SELECT m_truck.truckid,m_truck.truckno FROM m_truck LEFT JOIN m_truckowner ON m_truck.ownerid = m_truckowner.ownerid where m_truckowner.owner_type='self'");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
			
                                    </td>

                                   
                                    <td>	  <select id="headid" name="headid" class="select2-me input-large" style="width:220px;">
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select headid,headname from head_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['headid']; ?>"><?php echo $row_fdest['headname']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('headid').value = '<?php echo $mid; ?>';</script>
                                                    
                                    </td>
                                    
                                 
                                    <td>
									<select id="meachineid" name="meachineid" class="select2-me input-large" style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select meachineid,mechanic_name from mechine_service_master");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['meachineid']; ?>"><?php echo $row_fdest['mechanic_name']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('meachineid').value = '<?php echo $meachineid; ?>';</script>
                                                    
                                    </td>
                                    <td style="margin-top:0px;"> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="">Reset</a>
                                           </td>
                                      
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<a class="btn btn-primary btn-lg" href="excel_service_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&truckno=<?php echo $truckno; ?>&headid=<?php echo $headid; ?>&mechanic_name=<?php echo $mechanic_name; ?>&maintenance=<?php echo $maintenance; ?>" target="_blank" 
                                style="float:right;margin-top: 10px;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck No</th>
                                        	<th>Driver Name </th>
                                            <th>Date</th>
                                            <th> Mechanic Name </th>
                                            <th>Service Head</th>
                                            <th>Amount</th>
                                            <th>Payment type</th>
                                            <!-- <th>Payment Mode</th> -->
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
                                //    echo "select * from service_entry $cond order by service_id desc";die;
									$sel = "select * from service_entry $cond order by service_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{

										$truckno=$cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
										$maintenance=$cmn->getvalfield($connection,"head_master","headname","headid='$row[headid]'");
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' && designation='1' "); 
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $truckno;?></td>
                                            <td><?php echo ucfirst($driver);?></td>
                                            <td><?php echo dateformatindia($row['service_date']);?></td>
                                          
                                            <td><?php echo $mechanic_name;?></td>
											<td><?php echo $maintenance;?></td>
                                            <td><?php echo $row['amount'];?></td>
											<td><?php echo $row['payment_type'];?></td>
                                           
                                            <!-- <td><?php echo $row['payment_mode'];?></td> -->
                                            
                                           
										</tr>
                                        <?php
										$slno++;
									}
									?>
										
									</tbody>
									
								</table>
							</div>
						</div>
					</div>
				</div>
				
			
			</div>
		</div></div>
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
		  url: '../ajax/delete.php',
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
		document.getElementById('session_name').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('session_name').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('session_name').disabled = false;
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
