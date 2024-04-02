<?php include("dbconnect.php");
$tblname = "tyre_removal";
$tblpkey = "removeid";
$pagename = "tyre_reuse.php";
$modulename = "Tyre Reuse";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$removeid=trim(addslashes($_GET['edit']));
	$sql_edit="select * from tyre_removal where removeid='$removeid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_assoc($res_edit))
		{
			$removeid = $row['removeid'];
			$reuse_date = $row['reuse_date'];
		}//end while
	}//end if
}//end if
else
{
	$removeid = 0;
	$reuse_date = date('d-m-Y');
}

$duplicate= "";
if(isset($_POST['submit']))
{
//	print_r($_POST);die;
	$removeid = $_POST['removeid'];
	$reuse_date = $cmn->dateformatdb($_POST['reuse_date']);
	
	
		$sql_update = "update  tyre_removal set reuse_date = '$reuse_date',reuse = '1', lastupdated=now() where removeid='$removeid'";
		mysqli_query($connection,$sql_update);
		//$cmn->InsertLog($pagename, $modulename, $tblname, $tblpkey, $removeid,'updated');
		echo "<script>location='tyre_reuse.php?action=2'</script>";
	
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
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('removeid')">
                                <div class="control-group">
                                <table width="100%" border="1">
                              <tr bgcolor="#CCCCCC">
                                <th width="2%" scope="col"><strong>S.No</strong></th>
                                <th width="22%" scope="col"><strong>Tyre No</strong></th>
                                <th width="12%" scope="col"><strong>Remold Date</strong></th>
                                <th width="16%" scope="col"><strong>Truck No.</strong></th>
                                <th width="17%" scope="col"><strong>Description</strong></th>
                                <th width="13%" scope="col"><strong>Action</strong></th>
                              </tr>
                              <?php
							  $sn = 1;
							  $sql =mysqli_query($connection,"select * from tyre_purchase where reuse = 0 and remarks = 1 ");
							  while($row_e = mysqli_fetch_assoc($sql))
							  {
							  ?>
                              	<tr>
                                    <td align="center"><strong><?php echo $sn++ ; ?></strong></td>
                                    <td align="center"><strong><?php echo $row_e['tnumber'] ; ?></strong></td>
                                    <td align="center"><strong><?php echo $cmn->dateformatindia($row_e['removedate']) ; ?></strong></td>
                                    <td align="center"><strong><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row_e[truckid]'"); ?></strong></td>
                                    <td align="center"><strong><?php echo $row_e['description'] ; ?></strong></td>
                                    <td align="center"><strong><input type="button" onClick="reuse_this('<?php echo $row_e['tid'] ; ?>','<?php echo $row_e['tnumber'] ; ?>')" value="Reuse" class="btn btn-small btn-primary" ></td>
                              </tr>
                              <?php
							  }
							  ?>
                            
                            </table>
                                </div>
                                </form>
							</div>
						</div>
					</div>
				</div>
                <!--   DTata tables -->
                
				
			
			</div>
		</div></div>
<script>
function reuse_this(tid,tnumber)
{ 
	var d = new Date();
	var curr_date = d.getDate();
	var curr_month = d.getMonth();
	var curr_year = d.getFullYear();
	var reusedate = curr_date + "-" + curr_month 
	+ "-" + curr_year;
	var reusedate = prompt("Please enter reusable date", ""+reusedate);
	

	
	if(reusedate != "")
	{
		$.ajax({
		  type: 'POST',
		  url: 'ajax_reuse_tyre.php',
		  data: 'tid=' + tid + '&tnumber=' + tnumber+ '&reusedate='+ reusedate ,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location='<?php echo $pagename; ?>'+'?action=1';
			}
		
		  }); 
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
<script>
//below code for date mask
jQuery(function($){
   $("#downdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});</script>
	</html>
<?php
mysql_close($db_link);
?>
