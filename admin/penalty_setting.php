<?php 
include("dbconnect.php");
$tblname = "penalty_setting";
$tblpkey = "penalty_id";
$pagename = "penalty_setting.php";
//$keyvalue =0 ;
$modulename = "Penalty Master";
$keyvalue="1";

//print_r($_SESSION);
if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
if(isset($_POST['submit']))
{
	$penalty_amt = trim(mysqli_real_escape_string($connection,$_POST['penalty_amt']));
	
	
	//check Duplicate
	//$check=0;
	//$cntchk = check_duplicate($connection,$tblname,"penalty_amt = '$penalty_amt' and $tblpkey  <> '$keyvalue'");

		//update
			$form_data = array('penalty_amt'=>$penalty_amt,'ipaddress'=>$ipaddress,'lastupdated'=>$createdate);
			dbRowUpdate($connection,$tblname, $form_data,"WHERE $tblpkey = '$keyvalue'");
				$action=2;
				$process = "updated";
		  
	
		 //$cmn->InsertLog($connection,$pagename, $module, $submodule, $tblname, $tblpkey, $keyvalue, $process);
		 echo "<script>location='$pagename?action=$action'</script>";
	
	
}
     $btn_name = "Update";
	 //echo "SELECT * from $tblname where $tblpkey = $keyvalue";die;
	 $sqledit       = "SELECT * from $tblname where $tblpkey = $keyvalue";
	 $rowedit       = mysqli_fetch_array(mysqli_query($connection,$sqledit));
	 $penalty_amt     =  $rowedit['penalty_amt'];
	
	
	 
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
							<div class="box-content">
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('placename')">
                                <div class="control-group">
                                <table class="table table-condensed">
                                
                                
                                <tr>
                                    <td ><strong>Penalty Amount&nbsp;(/MT)</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td ><input type="text" name="penalty_amt" id="penalty_amt" value="<?php echo $penalty_amt; ?>"
                                     autocomplete="off"  maxlength="120" tabindex="1" placeholder='Enter Amount'  class="input-large" ></td>
                                    
                                 </tr>   
                                   
                                 <tr>
                                 <td colspan="4" style="line-height:5">
                                   
                                    <button type="submit" name="submit" id="submit"  class="btn btn-success"
                                     onClick="return checkinputmaster('penalty_amt')" tabindex="10" style="margin-left:360px">
                                     	<?php echo $btn_name; ?></button>
									
                                    <a href="penalty_setting.php"  name="reset" id="reset" class="btn btn-success">Reset</a>
                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                    
                                    
                                    
                                    
                                    
                                    
                                
                                
                                    
                                    
                                    
                                    
                                  
									
                                    </td>
                                 </tr>
                                </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
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
                                            <th width="10%">Sno</th>  
                                            <th width="40%">Penalty Amount</th>
                                            <th class='hidden-480' width="10%">Action</th>
										</tr>
									</thead>
                                    <tbody>
                                       <?php
											$slno=1;
											//echo"select * from brand_master order by brand_id desc";die;
											
											$sql_get = mysqli_query($connection,"select * from penalty_setting order by penalty_id desc");
											while($row_get = mysqli_fetch_assoc($sql_get))
											{?>
                                    
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row_get['penalty_amt'];?></td>
                                           	<td class='hidden-480'>
                                           <a href=  'penalty_setting.php?penalty_id=<?php echo  $row_get['penalty_id'] ; ?>'><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row_get[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		document.getElementById('bankname').disabled = true;
		document.getElementById('checquenumber').value = "";

		document.getElementById('bankname').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('bankname').disabled = false;
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
