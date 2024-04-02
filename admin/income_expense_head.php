<?php 
include("dbconnect.php");
$tblname = "other_income_expense";
$tblpkey = "head_id";
$pagename = "income_expense_head.php";
$modulename = "Other Income Expense Head";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from other_income_expense where head_id='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$headname = $row['headname'];
			$headtype = $row['headtype'];
					
		}//end while
	}//end if
}//end if
else
{
	$head_id = 0;
	$headname ='';
	$headtype = '';

}

$duplicate= "";
if(isset($_POST['submit']))
{
	$head_id = $_POST['head_id'];
	$headname = $_POST['headname'];
	$headtype = $_POST['headtype'];
		
	if($head_id==0)
	{
		//check doctor existance
		$sql_chk = "select * from other_income_expense where headname='$headname'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
		
			$sql_insert="insert into other_income_expense set headname = '$headname',headtype='$headtype',createdate=now(),ipaddress = '$ipaddress'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='income_expense_head.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  other_income_expense set headname='$headname',headtype='$headtype',lastupdated=now(),ipaddress = '$ipaddress' where head_id='$head_id'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $head_id;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='income_expense_head.php?action=2'</script>";
	}
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
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td width="9%"><strong>Head Name :</strong> <span class="red">*</span></td>
                                    <td width="21%"><input type="text" name="headname" id="headname" value="<?php echo $headname; ?>"
                                     autocomplete="off" placeholder='Enter Head Name' class="input-large" ></td>
                                    <td width="8%"><strong> Type </strong> <span class="red">*</span> </td>
                                    <td width="62%">
                                    				<select name="headtype" id="headtype" class="formcent" style="width:220px;">
                                                    <option value="">--Select--</option>
                                                    <option value="Bilty">Bilty</option>
                                                    <option value="Truck">Truck</option>
                                                    <option value="Office">Office</option>
                                                    <option value="Bonus">Bonus</option>
                                                    </select>  
                                                 <script> document.getElementById('headtype').value='<?php echo $headtype; ?>'; </script>
                            		</td>
                                 </tr>
                                
                                  
                                  <tr>
                                  <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td width="9%">&nbsp;</td>
                                    <td colspan="3">
                                     <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('headname,headtype')"  style="margin-left:180px">
								
									<input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />
								
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
				</div>
                <!--   DTata tables -->
                <div class="row-fluid" id="list">
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
                                            <th>Head Name</th>
                                            <th>Head Type</th>                                            
                                           <th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from other_income_expense order by head_id desc";//13 = to pay & -1 = other
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['headname']);?></td>
                                            <td><?php echo ucfirst($row['headtype']);?></td>                                           
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['head_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                             <!-- <a onClick="funDel('<?php //echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>-->
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
   

	</html>
<?php
mysqli_close($connection);
?>
