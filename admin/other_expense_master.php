<?php error_reporting(0);
include("dbconnect.php");
$tblname = "otherexp_master";
$tblpkey = "otherid";
$modulename = "Other Expenses Master";
if(isset($_POST['submit'])){
	$incex_head_name = $_POST['incex_head_name'];
	$head_type = $_POST['head_type'];

	$inc_ex_id = $_POST['inc_ex_id'];
	$narration = $_POST['narration'];

 
   if($inc_ex_id =='')
             {
             	$sqlcheckdup = mysqli_query($connection,"SELECT * FROM inc_ex_head_master WHERE incex_head_name='$incex_head_name'");
   
   	   echo $check=mysqli_num_rows($sqlcheckdup);
   	    if($check > 0){
   	 	$dup="<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
   		}
   		else
   		{
   
// echo "INSERT into inc_ex_head_master set vehicletype='$vehicletype', head_type='$head_type',userid='$userid',createdate='$createdate',compid='$compid'";die;
			mysqli_query($connection, "INSERT into inc_ex_head_master set incex_head_name='$incex_head_name', head_type='$head_type',userid='$userid',narration='$narration',createdate='$createdate',compid='$compid'");
			$action = 1;
			echo "<script>location='other_expense_master.php?action=$action'</script>";
             }
             }
   else
             {
				mysqli_query($connection, "UPDATE inc_ex_head_master set incex_head_name='$incex_head_name', head_type='$head_type',narration='$narration',userid='$userid',createdate='$createdate',compid='$compid' WHERE inc_ex_id='$_GET[eid]'");
				$action = 2;
				echo "<script>location='other_expense_master.php?action=$action'</script>";
            }  
            }
   
   if($_GET['eid']!=''){
	$sql = mysqli_query($connection, "select * from inc_ex_head_master WHERE inc_ex_id='$_GET[eid]'");
	$row = mysqli_fetch_array($sql);
	$incex_head_name = $row['incex_head_name'];
	$head_type = $row['head_type'];
	$narration = $row['narration'];
	
   }
   else
   {
	$incex_head_name = '';
	$head_type = '';
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
							<!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span5" style="float:left;">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="margin-top: 20px;">
                                <!-- <tr> -->
                                    <!-- <td width="40%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td> -->
                                    <!-- <td width="60%">
                            <select id="truckid" name="truckid" class="formcent select2-me" style="width:224px;" onChange="window.location.href='?truckid='+this.value;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select A.truckid,truckno,A.ownerid from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid  
														 order by A.truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno'].' / '.$cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row_fdest[ownerid]'"); ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                    </td>                                    
                                 </tr> -->
                                 <!-- <tr>
                                    <td width="40%"><strong>Driver Name</strong> <strong>:</strong></td>
                                    <td width="60%">
                            <input list="browsers" value="<?php echo $drivername; ?>" id="drivername" name="drivername" autocomplete="off" class="input-large" >
                                     
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
                                 </tr> -->
                                 
                                 
                                 <!-- <tr>
                                    <td width="40%"><strong>Head</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="60%">
                            <select id="head_id" name="head_id" class="formcent select2-me" style="width:224px;" >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select head_id,headname from other_income_expense where headtype='Truck' && headname not IN('RTO & INSURANCE','Spare Item','total tax','Hamali','Bhatta','Cash Expanses','Truck Maintanance')  order by headname");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['head_id']; ?>"><?php echo $row_fdest['headname']; ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('head_id').value = '<?php echo $head_id; ?>';</script>
                                    </td>                                    
                                 </tr> -->
                                 
                                 <tr>
                                    <td> <strong>Head Name:</strong><span class="red">*</span></td>
                                    <td>
									<input type="text" name="incex_head_name" id="incex_head_name" placeholder="Head Name" tabindex="1" class="form-control" value="<?php echo $incex_head_name;?>" required>

                                    </td>
                                   </tr>
								   <tr>
                                    <td> <strong>Head Type:</strong><span class="red">*</span></td>
                                    <td>                                                            
								   <select data-placeholder="Choose a Country..." name="head_type" id="head_type" style="width:220px" tabindex="2" class="formcent select2-me" required>
								
								<option value="">Select</option>	
								<option value="Income">Income</option>
								<option value="Expenses">Expenses</option>
								
								<script>
								document.getElementById('head_type').value = '<?php echo $head_type; ?>';
							</script>
							</select>
							</td>
                                   </tr>
                                 <tr>
                                    <td> <strong>Description:</strong></td>
                                    <td>
                    				<input type="text" name="narration" value="<?php echo $narration; ?>" id="narration" autocomplete="off"  class="input-large">
                                    </td>
                                   </tr>  
                                                                     
                                 <tr>
                                 <td colspan="2" style="line-height:5">
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('truckid,head_id,incomeamount,payment_type');" >
                    <input type="button" value="Reset" class="btn btn-danger" style="border-radius:4px !important;" onClick="document.location.href='<?php echo $pagename ; ?>';" />			
                    <input type="hidden" name="otherid" id="otherid" value="<?php echo $otherid; ?>" >
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
				if($otherid =='')
				{
				?>
                <!--   DTata tables -->
				<div class="row-fluid" id="list" style="display:none;">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
										<th>S.no.</th>
											<th>Head Name</th>
											<th>Head Type </th>
											<th>Discription</th>  

											<th class='hidden-350'>Action</th>                                       
										</tr>
									</thead>
                                    <tbody>
                                    <?php $sn = 1;
							$sql = mysqli_query($connection, "select * from inc_ex_head_master  order by inc_ex_id desc ");
							while ($row = mysqli_fetch_array($sql)) {

							?>
								<tr>
									<td><?php echo $sn++; ?></td>
									<td><?php echo $row['incex_head_name']; ?></td>
									<td><?php echo $row['head_type']; ?></td>
									<td><?php echo $row['narration']; ?></td>


									<td>
									
										<a  href="other_expense_master.php?eid=<?php echo $row['inc_ex_id'];?>" class="btn btn-magenta">
             Edit
            </a> 
            <a href="other_expense_master.php" title="Delete" onClick="funDel(<?php echo $row['inc_ex_id'];?>);" class="btn btn-satblue">
               Delete
            </a>
									</td>
								<?php } ?>
                                    
                                   
										
										
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
function funDel(id) {
			var tablename = 'inc_ex_head_master';
			var tableid = 'inc_ex_id';
			if (confirm("Do You want to Delete this record ?")) {
				jQuery.ajax({
					type: 'POST',
					url: 'ajax/delete_master.php',
					data: 'id=' + id + '&tablename=' + tablename + '&tableid=' + tableid,
					dataType: 'html',
					success: function(data) {
						// alert(data);
						location = 'other_expense_master.php?action=3';
					}
				}); //ajax close
			}
		}
</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
