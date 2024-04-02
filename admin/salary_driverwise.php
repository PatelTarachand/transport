<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$tblname = "driver_salary";
$tblpkey = "d_salary_id";
$pagename = "salary_driverwise.php";
$modulename = "Driver Salary Entry";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['empid']))
{
	$empid = trim(addslashes($_GET['empid']));	
}
else
{
	$empid=0;
}
if(isset($_GET['d_salary_id']))
{
	$d_salary_id = trim(addslashes($_GET['d_salary_id']));	
	
}
else
{
	$d_salary_id=0;	
}

		if(isset($_POST['submit']))
		{
			$tblpkey_value= trim(addslashes($_POST['d_salary_id']));
			$empid = trim(addslashes($_POST['empid']));
			$truckid = trim(addslashes($_POST['truckid']));
			$month = trim(addslashes($_POST['month']));
			$year = trim(addslashes($_POST['year']));
			$basic_salary = trim(addslashes($_POST['basic_salary']));
			$deduct_amt = trim(addslashes($_POST['deduct_amt']));			
			$narration = trim(addslashes($_POST['narration']));		
			$salary_date = $cmn->dateformatusa(trim(addslashes($_POST['salary_date'])));
			$no_of_day_present = trim(addslashes($_POST['no_of_day_present']));	
			$bal_amt =  trim(addslashes($_POST['bal_amt']));	
			
			if($truckid !='' && $month !='' && $year !='' && $basic_salary !='')
			{
			if($tblpkey_value==0)
			{
		
		mysqli_query($connection,"insert into driver_salary set truckid='$truckid',empid='$empid',month='$month',year='$year',basic_salary='$basic_salary',deduct_amt='$deduct_amt',narration='$narration',bal_amt='$bal_amt',no_of_day_present='$no_of_day_present',
					 salary_date='$salary_date',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
				$action = 1;
			}
			else
			{
	
				mysqli_query($connection,"update driver_salary set truckid='$truckid',empid='$empid',month='$month',year='$year',basic_salary='$basic_salary',deduct_amt='$deduct_amt',narration='$narration',
no_of_day_present='$no_of_day_present',salary_date='$salary_date',createdby='$userid',createdate='$createdate',bal_amt='$bal_amt',
ipaddress='$ipaddress'  where d_salary_id='$tblpkey_value'");
				$action = 2;
			}			
			echo "<script>location='$pagename?action=$action&empid=$empid'</script>";
			}
		}
		

if($d_salary_id !='0')
{
$sql = mysqli_query($connection,"select * from driver_salary where d_salary_id='$d_salary_id'");
$row=mysqli_fetch_assoc($sql);
$tblpkey_value = $row['d_salary_id'];
$truckid = $row['truckid'];
$empid = $row['empid'];
$month = $row['month'];
$year = $row['year'];
$basic_salary = $row['basic_salary'];
$deduct_amt = $row['deduct_amt'];
$narration = $row['narration'];
$salary_date = $row['salary_date'];
$no_of_day_present = $row['no_of_day_present'];
$bal_amt = $row['bal_amt'];
}
else
{
	$tblpkey_value=0;	
	$truckid='';
	$month=(integer)date('m');
	$year = date('Y');
	$basic_salary = $cmn->getvalfield($connection,"m_employee","salary","empid='$empid'");
	$deduct_amt=0;
	$salary_date = date('Y-m-d');
	$narration='';
	$bal_amt=0;
	$no_of_day_present='';
	$bal_amt='';
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

</head>

<body>
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
             <?php include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" id="new">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">                                
                                <tr>
                                    <td width="40%"><strong>Driver Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="empid" name="empid" class="formcent select2-me" style="width:224px;" onChange="window.location.href='?empid='+this.value;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select empid,empname from m_employee where designation=1 && status=1 order by empname");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['empid']; ?>"><?php echo $row_fdest['empname']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('empid').value = '<?php echo $empid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                 
                                <tr>
                                    <td width="40%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="truckid" name="truckid" class="formcent select2-me" style="width:224px;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select truckid,truckno from m_truck order by truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                  
                                  
                                  
                                  
                                   <tr>
                                    <td width="40%"><strong>Month</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="month" name="month" class="formcent select2-me" style="width:224px;" onChange="balamt();"  >
                                <option value=""> -Select- </option>  
                                <?php
								$i=1;
								while($i<=12) {
									
				$dateObj   = DateTime::createFromFormat('!m', $i);
				$monthName = $dateObj->format('F'); 
								?>                             
                                    <option value="<?php echo $i; ?>"><?php echo $monthName; ?></option>
                                <?php
								$i++;
								} ?>    
                                </select>
                                <script>document.getElementById('month').value = '<?php echo $month; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                  <tr>
                                    <td width="40%"><strong>Year</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="year" name="year" class="formcent select2-me" style="width:224px;" onChange="balamt();"  >
                                <option value=""> -Select- </option>
                                <?php 
								$y=2018;
								while($y<2025) {
								?>
                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                                <?php  $y++; } ?>
                                </select>
                                <script>document.getElementById('year').value = '<?php echo $year; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 
                                  <tr>
                                    <td> <strong>No of Day Present:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="no_of_day_present" value="<?php echo $no_of_day_present; ?>" id="no_of_day_present" autocomplete="off"  class="input-large" onChange="balamt();" >
                                    </td>
                                   </tr>
                                   
                                        
                                 <tr>
                                    <td> <strong>Basic Salary:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="basic_salary" value="<?php echo $basic_salary; ?>" id="basic_salary" autocomplete="off"  class="input-large" readonly>
                                    </td>
                                   </tr>
                               
                                <tr>
                                    <td> <strong>Deduct Amount:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="deduct_amt" value="<?php echo $deduct_amt; ?>" id="deduct_amt" autocomplete="off"  class="input-large" onChange="balamt();" >
                                    </td>
                                   </tr>
                                   
                                    <tr>
                                    <td> <strong>Bal. Amount:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="bal_amt" value="<?php echo $bal_amt; ?>" id="bal_amt" autocomplete="off"  class="input-large" readonly>
                                    </td>
                                   </tr>                                                                  
                                 		                                  
                                  <tr>
                                  <td><strong>Salary Date:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="salary_date" id="salary_date" value="<?php echo $cmn->dateformatindia($salary_date); ?>" autocomplete="off" class="input-large" data-date="true" placeholder="dd-mm-yyyy" ></td>
                                  </tr>
                                  
                                 <tr>
                                    <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>  
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('empid,truckid,month,year,salary_date,no_of_day_present,bal_amt');" >
                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                    			</td>
                                </tr>  
                                 
                                  
                                </table> 
                                </div>
                                </form>
                                
                           </div>
                           
                           <div class="span5" style="float:right;" >
                        
                                <div class="control-group">
                                 
                                </div>
                            
                           </div>     
							
						</div>
					</div>
				</div>
                
                
                <?php 
				if($empid !='')
				{
				?>
                <!--   DTata tables -->
                <div class="row-fluid" >
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck No</th> 
                                            <th>Driver Name</th> 
                                            <th>Month </th>
                                        	<th>Year</th>                                            
                                            <th>Salary</th> 
                                            <th>Payment Date</th>  
                                            <th>Narration</th> 
                                              <!--<th>Print Reciept</th> -->              
                                        	<th class='hidden-480'>Action</th>                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$slno=1;
									$sel = "select * from driver_salary where empid='$empid' $cond order by salary_date desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$empname = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
										
										$dateObj   = DateTime::createFromFormat('!m', $row['month']);
										$monthName = $dateObj->format('F'); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                           
                                            <td><?php echo ucfirst($empname);?></td>
                                            <td><?php echo $monthName;  ?></td>
                                            <td><?php echo ucfirst($row['year']);?></td>
                                            <td style="text-align:right;"><?php echo ucfirst($row['bal_amt']);?></td> 
                                            <td><?php echo $cmn->dateformatindia($row['salary_date']);?></td>
                                            <td><?php echo ucfirst($row['narration']);?></td> 

                                               <!--<td><a href= "pdfreciept_truck_expenses.php?truckexpenseid=<?php //echo $row['truckexpenseid'];?>" class="btn btn-success" target="_blank" >Print Reciept</a></td>-->
                                            <td class='hidden-480'>
                                           <a href= "?d_salary_id=<?php echo ucfirst($row['d_salary_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
										</tr>
                                        <?php
										$tot_amt += $row['bal_amt'];		
										
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;text-align:right;"><?php echo number_format($tot_amt,2); ?> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"></td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                    </tr>
										
									</tbody>
									
								</table>
							</div>
						</div>
					</div>
				</div>
				<?php 
				}
				?>			
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
			  location=pagename+'?action=10&empid=<?php echo $empid; ?>';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

jQuery(function($){
   $("#paymentdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#chequedate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});



function balamt(){
	var basic_salary = parseFloat(document.getElementById('basic_salary').value);
	var deduct_amt = parseFloat(document.getElementById('deduct_amt').value);
	var no_of_day_present = parseFloat(document.getElementById('no_of_day_present').value);
	var month =document.getElementById('month').value;
	var year = document.getElementById('year').value;
	
	var bal_amt = 0;
	
	if(isNaN(basic_salary)) { basic_salary = 0; }
	if(isNaN(deduct_amt)) { deduct_amt = 0; }
	if(isNaN(no_of_day_present)) { no_of_day_present = 0; }
	
	if(basic_salary !=0 && no_of_day_present !=0 && month !='' && year !='')
	{
	var total_day_in_month=daysInMonth(month,year);
	var per_day_salary = parseFloat(basic_salary/total_day_in_month);		
	var net_salary = no_of_day_present * per_day_salary;
	//alert(per_day_salary);
	bal_amt = net_salary - deduct_amt;
	}
	document.getElementById('bal_amt').value=Math.round(bal_amt);
	
	}
	

	
function daysInMonth (month, year) {
return new Date(year, month, 0).getDate();
}


</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
