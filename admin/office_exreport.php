<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "other_expense_entry";
$tblpkey = "other_exp_id";
$pagename = "other_expense_entry.php";
$modulename = "Other Expenses Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;


$fromdate= $_GET['fromdate'];
$todate= $_GET['todate'];
$truckid= $_GET['truckid'];
$meachineid= $_GET['meachineid'];
$headid= $_GET['headid'];



	$truckid = $_GET['truckid'];	

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

if($otherid!=''){

    $cond .= " and otherid ='$otherid'";
}else{
    $otherid='';
}
	if($truckid !='') {
	
	$cond .=" and truckid='$truckid'";
	
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
								<h3><i class="icon-edit"></i>Other Expenses Report</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="get" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed" style="width:60%;">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                            <td><strong>From Date</strong></td>
                                            <td> <strong>To Date</strong></td>
                                               <td> <strong>Truck No</strong></td>
                                            
                                            <td> <strong>Office Expense.	</strong></td>
                                          
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
                                          	<select id="truckid" name="truckid" class="select2-me input-large" style="width:200px;" >
			<option value=""> - Select - </option>
			<?php 
			$sql_fdest = mysqli_query($connection,"select truckid,truckno from m_truck");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			?>
			<option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
			<?php
			} ?>
			</select>
			<script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                        </td>
                                      <td>
                                      <select name="otherid" id="otherid"  class="formcent select2-me" style="width:224px;" >
                                                  <option value="">-Select-</option>
                                               <?php 
                                               $sql = mysqli_query($connection,"select * from otherexp_master");
                                               while($row=mysqli_fetch_assoc($sql))
                                               {
                                               ?>
                                                  <option value="<?php echo $row['otherid']; ?>"><?php echo $row['headname'] ?></option>
                                              <?php 
                                               }
                                              ?>
                                          </select>
                                          <script>document.getElementById('otherid').value = '<?php echo $otherid ; ?>'; </script>
			
                                    </td>

                                   
                                   
                                    
                                 
                                  
                                    <td> 
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
							<a class="btn btn-primary btn-lg" href="excel_otherexpense_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&otherid=<?php echo $otherid; ?>" target="_blank"  style="float:right;margin-top: 10px;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                    <th>Sno</th>  
                                            <th> Date</th> 
                                            <th>Truck No.</th> 
                                              <th>Office Expense</th> 
                                            <th>Amonut</th> 
                                            <th>Driver name </th>
                                        	<th>Pay Mode</th>                                            
                                            <!--<th>Meater Reading</th> -->
                                            <th>Billing Type</th> 
                                            <th>Narration</th>  
                                         
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
                                   
								
                                   
                                   
									$sql = "select * from other_expense_entry $cond  order by otherid  desc";
									$res =mysqli_query($connection,$sql);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
                                        $office_headname = $cmn->getvalfield($connection,"otherexp_master","headname","otherid='$row[otherid]'"); 
                                        $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
									
										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 

										$driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
									
									?>
										<tr>
                                    
                                        <td><?php echo $slno; ?></td>
                                            <td><?php echo dateformatindia($row['service_date']);?></td>   
                                              <td><?php echo ucfirst($truckno);?></td>
                                                <td><?php echo ucfirst($office_headname);?></td>             
                                               
                                                                    
                                          
                                         
                                            <td><?php echo $row['amount'];?></td>
                                           
                                            <td><?php echo ucfirst($driver);?></td> 
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                            <!--<td><?php echo ucfirst($row['meater_reading']);?></td> -->
                                             <td><?php echo $row['bill_type'];?></td>
                                          
                                             <td><?php echo ucfirst($row['narration']);?></td> 
                                            
                                           
										</tr>
                                        <?php
										
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
