<?php  error_reporting(0);                                                                                           include("dbconnect.php");
$tblname = "salary_deduction";
$tblpkey = "deduction_id";
$pagename = "driver_salary.php";
$modulename = "Truck Expense";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
}
else
{
	$truckid='';	
}

if(isset($_GET['deduction_id']))
{
	$deduction_id = trim(addslashes($_GET['deduction_id']));	
}
else
{
	$deduction_id=0;	
}

		if(isset($_POST['submit']))
		{
			$tblpkey_value= trim(addslashes($_POST['deduction_id']));
			$truckid = trim(addslashes($_POST['truckid']));
			$drivername = trim(addslashes($_POST['drivername']));			
			$deduct_amt = trim(addslashes($_POST['deduct_amt']));
			$deduct_date = $cmn->dateformatusa(trim(addslashes($_POST['deduct_date'])));
			$narration = trim(addslashes($_POST['narration']));
			
			if($truckid !='' && $deduct_amt !='' && $deduct_date !='')
			{
			if($tblpkey_value==0)
			{
				
				mysqli_query($connection,"insert into salary_deduction set truckid='$truckid',drivername='$drivername',deduct_amt='$deduct_amt',deduct_date='$deduct_date',narration='$narration',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',sessionid='$sessionid'");
				$action = 1;
			}
			else
			{
				mysqli_query($connection,"update salary_deduction set truckid='$truckid',drivername='$drivername',deduct_amt='$deduct_amt',deduct_date='$deduct_date',narration='$narration',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress'  where deduction_id='$tblpkey_value'");
				$action = 2;
			}			
			echo "<script>location='$pagename?action=$action&truckid=$truckid'</script>";
			}
		}
		

if($deduction_id !='0')
{
$sql = mysqli_query($connection,"select * from salary_deduction where deduction_id='$deduction_id'");
$row=mysqli_fetch_assoc($sql);
$tblpkey_value = $row['deduction_id'];
$truckid = $row['truckid'];
$drivername = $row['drivername'];
$deduct_amt = $row['deduct_amt'];
$deduct_date = $row['deduct_date'];
$narration = $row['narration'];
}
else
{
	$drivername = '';
	$deduct_amt = '';
	$deduct_date = date('Y-m-d');
	$narration = '';	
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
                                    <td width="40%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="truckid" name="truckid" class="formcent select2-me" style="width:224px;" onChange="window.location.href='?truckid='+this.value;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select A.truckid,truckno,A.ownerid from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid  order by A.truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno'].' / '.$cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row_fdest[ownerid]'"); ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                    </td>                                    
                                 </tr>
                                 <tr>
                                    <td width="40%"><strong>Driver Name</strong> <strong>:</strong></td>
                                    <td width="60%">
                            <input list="browsers" value="<?php echo $drivername; ?>" id="drivername" name="drivername" autocomplete="off" class="input-large" onChange="getdriverbal();" >
                                     
                                <datalist id="browsers">
                                <?php 
								$sql = mysqli_query($connection,"select drivername from bilty_entry where drivername !='' group by drivername");
								while($row=mysqli_fetch_assoc($sql))
								{
								?>
                                <option value="<?php echo $row['drivername']; ?>">
                               <?php 
								}
							   ?>
                                </datalist>


                                    </td>                                    
                                 </tr>
                                 
                                <tr>
                                    <td> <strong>Balance Amount:</strong></td>
                                    <td>
                    				<input type="text" name="bal_amt" value="<?php echo $bal_amt; ?>" id="bal_amt" autocomplete="off"  class="input-large" readonly >
                                    </td>
                                   </tr>  
                                 
                                 
                                 <tr>
                                    <td> <strong>Deduction Amount:</strong><span class="red">*</span></td>
                                    <td>
                    				<input type="text" name="deduct_amt" value="<?php echo $deduct_amt; ?>" id="deduct_amt" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>
                                            
                                         
                                  
                                  <tr>
                                  <td><strong>Deduction Date:</strong></td>
                                    <td><input type="text" name="deduct_date" id="deduct_date" value="<?php echo $cmn->dateformatindia($deduct_date); ?>" autocomplete="off" class="input-large" data-date="true" placeholder="dd-mm-yyyy" ></td>
                                  </tr>
                                  
                                 <tr>
                                    <td> <strong>Narration:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>  
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,deduct_amt');" >
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
				if($truckid !='')
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
                                            <th>Head </th>
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th>  
                                            <th>Narration</th> 
                                                                                                                                   
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
									$sel = "select * from salary_deduction where truckid='$truckid' $cond order by deduct_date desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										//$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($truckno);?></td>                                           
                                            <td><?php echo ucfirst($row['drivername']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'");  ?></td>
                                            <td><?php echo ucfirst($row['deduct_amt']);?></td>
                                            <td><?php echo ucfirst($row['payment_type']);?></td> 
                                            <td><?php echo $cmn->dateformatindia($row['deduct_date']);?></td>
                                            <td><?php echo ucfirst($row['narration']);?></td> 

                                               
                                            <td class='hidden-480'>
                                           <a href= "?deduction_id=<?php echo ucfirst($row['deduction_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
										</tr>
                                        <?php
										$tot_amt += $row['deduct_amt'];		
										
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_amt,2); ?> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"></td>
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
			  location=pagename+'?action=10&truckid=<?php echo $truckid; ?>';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

jQuery(function($){
   $("#deduct_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});


function settruckno()
{
	var ownerid = document.getElementById('ownerid').value;
	
	if(ownerid !='')
	{
		window.location.href='?ownerid='+ownerid;
	}	
}


function getdriverbal() {
	var truckid = document.getElementById('truckid').value;
	var drivername = document.getElementById('drivername').value;
	
	if(drivername !='' && truckid !='')
	{
		$.ajax({
		  type: 'POST',
		  url: 'getdriverbalance.php',
		  data: 'drivername=' + drivername + '&truckid=' + truckid,
		  dataType: 'html',
		  success: function(data){
			  //alert(data);
				jQuery('#bal_amt').val(data);
			}		
		  });//ajax close	
	}
}

getdriverbal();

</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
