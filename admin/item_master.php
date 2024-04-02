<?php
include("dbconnect.php");
$tblname = "item_master";
$tblpkey = "item_id";
$pagename = "item_master.php";
$modulename = "Item Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from item_master where item_id='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$itemcategoryname = $row['itemcategoryname'];
			$item_cat_id = $row['item_cat_id'];
			$unit_id = $row['unit_id'];
		
			
		}//end while
	}//end if
}//end if
else
{
	$item_id = 0;

	$itemcategoryname='';
	$item_cat_id='';
	$unit_id='';

	
}

$duplicate= "";
if(isset($_POST['submit']))
{	
	$item_id = $_POST['item_id'];
	$itemcategoryname = $_POST['itemcategoryname'];
	
	$item_cat_id = $_POST['item_cat_id'];
	$unit_id = $_POST['unit_id'];


	if($item_id==0)
	{
		
		//check doctor existance
	
		$sql_chk = "select * from item_master where itemcategoryname='$itemcategoryname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
	
		if($cnt == 0)
		{
			 $sql_insert="insert into item_master set itemcategoryname = '$itemcategoryname', item_cat_id = '$item_cat_id',unit_id = '$unit_id', lastupdate = '$lastupdate',
			 ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate',compid='$compid'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
		
			// echo "<script>location='master_company.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
		$itemcategoryname='';
		$item_cat_id='';
		$unit_id='';
		$opening_balance='';
		$ope_bal_date = '';
	}
	
	else
	{
		// // echo "test";die;
		// echo "update   item_master set itemcategoryname = '$itemcategoryname', item_cat_id = '$item_cat_id',unit_id = '$unit_id', opening_balance = '$opening_balance',
		// ope_bal_date='$ope_bal_date' where item_id='$item_id'";die;
		
		$keyvalue = $_GET['edit'];
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		
		
	
		$sql_update = "update  item_master set itemcategoryname = '$itemcategoryname', item_cat_id = '$item_cat_id',unit_id = '$unit_id' where item_id='$keyvalue'";
		mysqli_query($connection,$sql_update);
		
		
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		//echo "<script>location='master_company.php?action=2'</script>";
	}
	$itemcategoryname='';
	$item_cat_id='';
	$unit_id='';
	$opening_balance='';
	$ope_bal_date = '';
	
}

?>
<!doctype html>
<html>
<head>

<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php");?>

<script>
  $(function() {
   
	 $('#start_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	$('#end_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	
  });
  </script>

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
								<h3><i class="icon-edit"></i>Item Master</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                 <td><strong>Item Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="25%">
                 <input type="text" name="itemcategoryname"  id="itemcategoryname"  value="<?php echo $itemcategoryname; ?>"class="input-large" required >
                                    </td>
                                    <td width="11%"> <strong>Category Name:</strong></td>
                                    <td>
                    				<select data-placeholder="Choose a Country..." name="item_cat_id" id="item_cat_id" style="width:200px" tabindex="3" class="formcent select2-me" required>
											<option value="">Select Category</option>
											<?php
											$sql = mysqli_query($connection, "select * from  item_category_master order by item_category_name");
											while ($row = mysqli_fetch_array($sql)) {

											?>
												<option value="<?php echo $row['item_cat_id']; ?>"><?php echo $row['item_category_name']; ?></option>
												
											<?php } ?>
											<script>
												document.getElementById('item_cat_id').value = '<?php echo $item_cat_id; ?>';
											</script>
                                    </td>
                                 </tr>
                                
                                  <tr>
                                    <td width="11%"> <strong>Unit Name:</strong></td>
                                    <td>
                    				<select data-placeholder="Choose a Country..." name="unit_id" id="unit_id" style="width:200px" tabindex="3" class="formcent select2-me" required>
											<option value="">Select Unit</option>
											<?php
											$sql = mysqli_query($connection, "select * from unit_master order by unit_name");
											while ($row = mysqli_fetch_array($sql)) {

											?>
												<option value="<?php echo $row['unit_id']; ?>"><?php echo $row['unit_name']; ?></option>
												
											<?php } ?>
											<script>
												document.getElementById('unit_id').value = '<?php echo $unit_id; ?>';
											</script>
                                    </td>
                                   
                                  
                            
                                  
                             
                                   
                               
                                    
                                 <tr>
                                    <td colspan="3">
                                        <br>
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('cname')" style="margin-left:340px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
									<input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
									<?php
                                   }
                                   else
                                   {
                                       
                                   ?>   
									<input type="reset" value="Reset" onClick="document.location.href='<?php echo $pagename ; ?>';" class="btn btn-danger" style="margin-left:15px">
                                    <?php
                                   }
								   ?>
                                    </td>
                                   </tr> 
                                
                                  
                                  <tr>
                                <td colspan="4"><input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" ></td>
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
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Item  Name</th>
                                        	<th>Category Name</th>
                                            <th>Unit Name</th>
                                          
                                         
                                            <th>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from item_master";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
								$unit_name = $cmn->getvalfield($connection, "unit_master", "unit_name", "unit_id='$row[unit_id]'");
								$item_category_name = $cmn->getvalfield($connection, "item_category_master", "item_category_name", "item_cat_id='$row[item_cat_id]'");


									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['itemcategoryname']);?></td>
                                            <td><?php echo ucfirst($item_category_name);?></td>
                                            <td><?php echo ucfirst($unit_name);?></td>
                           
                                           <td class=''>
                                           <a href= "?edit=<?php echo ucfirst($row['item_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')"  ><img src="../img/del.png" title="Delete" ></a>
                                           </td>
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
