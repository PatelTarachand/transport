<?php
include("dbconnect.php");
$tblname = "item_category_master";
$tblpkey = "item_cat_id";
$pagename = "item_category_master.php";
$modulename = "Item Category Master";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from item_category_master where item_cat_id='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$item_category_name = $row['item_category_name'];
	
			
		}//end while
	}//end if
}//end if
else
{
	$item_cat_id = 0;

	$item_category_name='';
	
	
}

$duplicate= "";
if(isset($_POST['submit']))
{	
	$item_cat_id = $_POST['item_cat_id'];
	$item_category_name = $_POST['item_category_name'];
	


	if($item_cat_id==0)
	{
		//check doctor existance
	
		$sql_chk = "select * from item_category_master where item_category_name='$item_category_name'";
		$res_chk = mysqli_query($connection,$sql_chk);
	$cnt = mysqli_num_rows($res_chk);
		if($cnt == 0)
		{
			// echo "insert into item_category_master set item_category_name = '$item_category_name',
            // ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate',compid='$compid',lastupdate='$lastupdate'";
			 $sql_insert="insert into item_category_master set item_category_name = '$item_category_name',
			 ipaddress='$ipaddress',sessionid='$sessionid',createdate='$createdate',compid='$compid',lastupdate='$lastupdate'";
			 // echo  $sql_insert;
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
		
			// echo "<script>location='master_company.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
		$item_category_name='';
	
	}
	
	else
	{
		// // echo "test";die;
		// echo "update   item_category_master set item_category_name = '$item_category_name', mobile_no = '$mobile_no',address = '$address', opening_balance = '$opening_balance',
		// ope_bal_date='$ope_bal_date' where item_cat_id='$item_cat_id'";die;
		
		$keyvalue = $_GET['edit'];
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		
		
	
		$sql_update = "update  item_category_master set item_category_name ='$item_category_name'
		 where item_cat_id='$keyvalue'";
		mysqli_query($connection,$sql_update);
		
		
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
		//echo "<script>location='master_company.php?action=2'</script>";
	}
	$item_category_name='';
	
	
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
								<h3><i class="icon-edit"></i>Item Category Master</h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                 <td><strong>Item Category Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="25%">
                 <input type="text" name="item_category_name"  id="item_category_name"  value="<?php echo $item_category_name; ?>"class="input-large" required >
                                    </td>
                           
                                    <td colspan="3">
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
                                            <th>Item Category Name</th>
                                       
                                            <th>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from item_category_master";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_assoc($res))
									{
									
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['item_category_name']);?></td>
                                         
                                           <td class=''>
                                           <a href= "?edit=<?php echo ucfirst($row['item_cat_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
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
