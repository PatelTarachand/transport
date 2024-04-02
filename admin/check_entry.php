<?php error_reporting(0);
include("dbconnect.php");
$tblname = "check_entry";
$tblpkey = "check_entry_id";
$pagename = "check_entry.php";
$modulename = "Check Entry";


if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$check_entry_id = $_GET['edit'];	
}
else
{
	$check_entry_id=0;	
}

if(isset($_GET['check_entry_id']))
{
	$check_entry_id = trim(addslashes($_GET['check_entry_id']));
	
		
}

if(isset($_POST['submit']))
{
	
			$check_entry_id= trim(addslashes($_POST["check_entry_id"]));
			$party_name= trim(addslashes($_POST["party_name"]));
			$check_no=trim(addslashes($_POST["check_no"]));
			$check_amount=trim(addslashes($_POST["check_amount"]));	
			$check_date= $cmn->dateformatusa(trim(addslashes($_POST["check_date"])));
			$remark=trim(addslashes($_POST["remark"]));
			
	
	if($check_entry_id==0)
	{
	
		
	mysqli_query($connection,"insert into check_entry set party_name='$party_name',check_no='$check_no',check_amount='$check_amount',check_date='$check_date',remark='$remark'
				,ipaddress='$ipaddress',createdate='$createdate',createdby='$userid',
				sessionid='$sessionid'");
	$check_entry_id = mysqli_insert_id($connection);
	echo "<script>location='check_entry.php?action=1'</script>";
	

	}
	else
	{ 
		mysqli_query($connection,"update check_entry set party_name='$party_name',check_no='$check_no',check_amount='$check_amount',check_date='$check_date',remark='$remark',createdby='$userid',ipaddress='$ipaddress',
			lastupdate='$createdate' where check_entry_id='$check_entry_id'");

		
			echo "<script>location='check_entry.php?action=2'</script>";
}	}


if($check_entry_id !='')
{
	//echo "select * from check_entry where check_entry_id='$check_entry_id'";die;
	$sql = mysqli_query($connection,"select * from check_entry where check_entry_id='$check_entry_id'");
	$row=mysqli_fetch_assoc($sql);
	         //$check_entry_id = $row['check_entry_id'];
			$party_name=$row['party_name'];
			$check_no=$row['check_no'];			
			$check_amount=$row['check_amount'];
			$check_date=$row['check_date'];
			$remark=$row['remark'];
			
}
else
{
	$check_entry_id = 0;
	
}
?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>


<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#0CF;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:230px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>
<script>
$(document).ready(function(){
    $("#shortcut_truck").click(function(){
        $("#div_truck").toggle(1000);
    });
	
	});
	</script>
</head>

<body>
	 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
            <?php //include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            <div class="box-content">
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table>
                                    <tr>
                                        
                                        <td><strong>Name Of Party</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>                                      
                                        <td><strong>Cheque No</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        <td><strong>Cheque Amount</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                         <td><strong>Remark </strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>
                                        
                                    </tr>
                              		<tr>
                                    <td width="13%">
                                    <input type="text" name="party_name" id="party_name" value="<?php echo $party_name; ?>" autocomplete="off"   class="input-large"  >
                                     </td>
                                     
                                      <td width="13%">
                                    <input type="text" name="check_no" id="check_no" value="<?php echo $check_no; ?>" autocomplete="off"   class="input-large"  >
                                     </td>
                                     
                                      <td width="13%">
                                    <input type="text" name="check_amount" id="check_amount" value="<?php echo $check_amount; ?>" autocomplete="off"   class="input-large"  >
                                     </td>
                                       
                                    <td width="13%">
                                    <input type="text" name="remark" id="remark" value="<?php echo $remark; ?>" autocomplete="off"  class="input-large"  >
                                     </td>
                                                                                                
                                 </tr>
                                 
                                   <tr>
                                        <td><strong>Date</strong> <strong>:</strong>&nbsp;&nbsp;</td>
                                          
                                    </tr>
                              		<tr>
                                     <td width="13%">
                                    <input type="text" name="check_date" id="check_date" value="<?php echo $cmn->dateformatindia($check_date); ?>" autocomplete="off"  class="input-large maskdate" placeholder="dd-mm-yyyy" >
                                     </td>
                                                                                                           
                                 </tr>                                 
                                	
                                 <tr>
                                        <td colspan="4"><center>
                                        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"  
                                        onClick="return checkinputmaster('party_name,check_no,check_amount,check_date');" > &nbsp; &nbsp; 
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger"> Reset </a>
                                        <input type="hidden" name="check_entry_id" value="<?php echo $check_entry_id; ?>" >
                                        </center></td>
                                 </tr>
                                 
                                
                                </table>                               
                                </div>
                                </form>
                                
							</div>
							
						</div>
					</div>
				</div>
                
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
                                            <th>Name Of Party</th>
                                            <th>Cheque No</th>
                                           	<th>Cheque Amount</th>
                                            <th>Remark</th>
                                             <th>Date</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from check_entry ";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo  $row['party_name']; ?></td>
                                            <td><?php echo $row['check_no']; ?></td>
                                           <td><?php echo $row['check_amount']; ?></td>
                                            <td><?php echo $row['remark'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['check_date']); ?></td>
                                            <td class='hidden-480'>
                                            <a href= "?edit=<?php echo ucfirst($row['check_entry_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                            
                                            &nbsp;&nbsp;&nbsp;
                                            <a onClick="funDel('<?php echo $row['check_entry_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		</div>
        
        
    </div>
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
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 // alert(data);
			 // alert('Data Deleted Successfully');
			  location=<?php echo "'$pagename?check_entry_id=$check_entry_id'"; ?>;
			}
		
		  });//ajax close
	}//confirm close
} //fun close

//below code for date mask
jQuery(function($){
   $(".maskdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});





</script>

</html>

<?php
mysqli_close($connection);
?>