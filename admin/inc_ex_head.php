<?php 
include("dbconnect.php");

   error_reporting(0);
   $pagename="item_master.php";
  
   $dup='';
   if(isset($_POST['submit'])){
	$incex_head_name = $_POST['incex_head_name'];
	$head_type = $_POST['head_type'];

	$inc_ex_id = $_POST['inc_ex_id'];

 
   if($inc_ex_id =='')
             {
             	$sqlcheckdup = mysqli_query($connection,"SELECT * FROM inc_ex_head_master WHERE incex_head_name='$incex_head_name' &&");
   
   	   echo $check=mysqli_num_rows($sqlcheckdup);
   	    if($check > 0){
   	 	$dup="<div class='alert alert-danger'>
   			<strong>Error!</strong> Error : Duplicate Record.
   			</div>";
   		}
   		else
   		{
   
// echo "INSERT into inc_ex_head_master set vehicletype='$vehicletype', head_type='$head_type',userid='$userid',createdate='$createdate',compid='$compid'";die;
			mysqli_query($connection, "INSERT into inc_ex_head_master set incex_head_name='$incex_head_name', head_type='$head_type',userid='$userid',createdate='$createdate',compid='$compid'");
			$action = 1;
			echo "<script>location='inc_ex_head.php?action=$action'</script>";
             }
             }
   else
             {
				mysqli_query($connection, "UPDATE inc_ex_head_master set incex_head_name='$incex_head_name', head_type='$head_type',userid='$userid',createdate='$createdate',compid='$compid' WHERE inc_ex_id='$_GET[eid]'");
				$action = 2;
				echo "<script>location='inc_ex_head.php?action=$action'</script>";
            }  
            }
   
   if($_GET['eid']!=''){
	$sql = mysqli_query($connection, "select * from inc_ex_head_master WHERE inc_ex_id='$_GET[eid]'");
	$row = mysqli_fetch_array($sql);
	$incex_head_name = $row['incex_head_name'];
	$head_type = $row['head_type'];
	
   }
   else
   {
	$incex_head_name = '';
	$head_type = '';
   }
   ?>
<!doctype html>
<html>



<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />

	<!-- <title>HEAD MASTER</title> -->

<?php include("inc/top-files.php"); ?>	

</head>
<body>
	
	<?php include("inc/model.php"); ?>
	
	<?php include("inc/top-header.php"); ?>
	
	
	<div class="container-fluid" id="content">
		<?php include("inc/left-menu.php"); ?>
				
		<div id="main">
			<div class="container-fluid">
			

                <div class="row">
					<div class="col-sm-12">
						<div class="box box-bordered box-color">
							<div class="box-title">
								<h3>
									<i class="fa fa-list"></i>Head Master</h3>
							</div>
							<div class="box-content nopadding">
							<?php include("include/alerts.php"); ?>
					<?php echo  $dup;  ?>
								<form action="" method="POST" class='form-horizontal form-column form-bordered'>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Head Name <span style="color: red;">*</span></label>
												<div class="col-sm-8">
													<input type="text" name="incex_head_name" id="incex_head_name" placeholder="Head Name" tabindex="1" class="form-control" value="<?php echo $incex_head_name;?>" required>
												</div>
											</div>
										
										</div>
                                        
										
										<div class="col-sm-6">
											<div class="form-group">
												<label for="textfield" class="control-label col-sm-4">Head Type <span style="color: red;">*</span></label>
												<div class="col-sm-8">
												<select data-placeholder="Choose a Country..." name="head_type" id="head_type" style="width:250px" tabindex="2" class="formcent select2-me" required>
								
												<option value="">Select</option>	
												<option value="Income">Income</option>
												<option value="Expenses">Expenses</option>
												
												<script>
												document.getElementById('head_type').value = '<?php echo $head_type; ?>';
											</script>
											</select>
												</div>
											</div>
										
										</div>
										</div>
										<div class="row">
										<div class="form-actions">
												<center>
												<button  type="submit" name="submit" class="btn btn-primary" tabindex="3" >
                        Save</button>
                        <a href="inc_ex_head.php"  name="reset" id="reset" class="btn btn-success" tabindex="4" >Reset</a>
                        <input type="hidden" name="inc_ex_id" id="inc_ex_id" value="<?php echo $_GET['eid'];?>">
												
												</center>	
											</div>
										</div>
									</div>

	
									
								</form>
							</div>
						</div>
					</div>
				</div>
				



<p align="right" style="margin-top:7px ;padding-right:20px;"> <a href="pdf_inc_ex_head.php" class="btn btn-primary" target="_blank">
                     <span style="font-weight:bold;text-shadow: 2px 2px 2px #000; color:#FFF">Print PDF</span></a></p>
							
                           	
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-color box-bordered" style="padding-left:20px;padding-right: 20px;">
							<div class="box-title">
								<h3>
									<i class="fa fa-table"></i>
									Expense Head Details
								</h3>
							</div>
							<div class="box-content nopadding">
								<table class="table" id="mytable">
									<thead>
									
										<th>S.no.</th>
											<th>Head Name</th>
											<th>Head Type </th>
											<th class='hidden-350'>Action</th>
											
									
									</thead>
									<tbody style="text-transform: capitalize;">
									<?php $sn = 1;
							$sql = mysqli_query($connection, "select * from inc_ex_head_master  order by inc_ex_id desc ");
							while ($row = mysqli_fetch_array($sql)) {

							?>
								<tr>
									<td><?php echo $sn++; ?></td>
									<td><?php echo $row['incex_head_name']; ?></td>
									<td><?php echo $row['head_type']; ?></td>


									<td>
									
										<a  href="inc_ex_head.php?eid=<?php echo $row['inc_ex_id'];?>" class="btn btn-magenta">
             Edit
            </a> 
            <a href="inc_ex_head.php" title="Delete" onClick="funDel(<?php echo $row['inc_ex_id'];?>);" class="btn btn-satblue">
               Delete
            </a>
									</td>
								<?php } ?>
										</tr>
										
										
									</tbody>
								</table>
						
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
	<script type="text/javascript">
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
						location = 'inc_ex_head.php?action=3';
					}
				}); //ajax close
			}
		}
	</script>
</body>



</html>
									