<?php error_reporting(0);
include("dbconnect.php");
$tblname = "m_bank";
$tblpkey = "bankid";
$pagename = "user_privilage.php";
$modulename = "User Privilage";

if(isset($_GET['loguserid']))
{
	$loguserid = trim(addslashes($_GET['loguserid']));	
}


if(isset($_POST['submit']))
{
	$page_id = $_POST['page_id'];
	$loguserid = $_POST['loguserid'];
	
	mysqli_query($connection,"delete from m_privilage where userid='$loguserid'");
	
	for($i=0;$i<count($page_id);$i++)
	{
			mysqli_query($connection,"insert into m_privilage set userid='$loguserid',page_id='$page_id[$i]',createdby='$userid',ipaddress='$ipaddress',createdate='$createdate'");	
	}
	
	echo "<script>location='user_privilage.php?loguserid=$loguserid&action=2'</script>";
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
                            <?php // include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td><strong>User Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="22%">
                                    			
                                        <select id="loguserid" name="loguserid" class="select2-me" style="width:202px;" onChange="seturl();" >
                                                <option value="">--select--</option>
                                                <?php 
                                                $sql_sc = "select * from m_userlogin where usertype='user'"; 
                                                $res_sc = mysqli_query($connection,$sql_sc);
                                                while($row_sc = mysqli_fetch_array($res_sc))
                                                { ?>
                                                <option value="<?php echo $row_sc['userid']; ?>"><?php echo $row_sc['username']; ?></option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                        <script> document.getElementById('loguserid').value='<?php echo $loguserid; ?>'; </script>        
                                    </td>
                                    <td width="17%">&nbsp;  </td>
                                    <td width="48%">&nbsp;  </td>
                                 </tr>
                                
                                </table> 
                                
                                <?php 
                                if($loguserid !='')
                                {
                                ?>
                                <br>
								<br>

                                 <table class="table table-condensed">
                                    
                                    <tr><th colspan="6">Master</th></tr>
                                                               
                                <tr>
                                    <th width="17%">
                                    	<?php  $pageclick= check_duplicate("m_privilage","page_id = '1' and userid ='$loguserid'"); ?>	
												<input name="page_id[]" type="checkbox" value="1" <?php if($pageclick !='0') { ?> checked <?php } ?> > &nbsp; &nbsp; Session Master</th>
                                    <th width="16%">
                                    <?php  $pageclick= check_duplicate("m_privilage","page_id = '2' and userid ='$loguserid'"); ?>	
                                    <input name="page_id[]" type="checkbox" value="2"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Company Master</th>
                                    <th width="17%">
                                    <?php  $pageclick= check_duplicate("m_privilage","page_id = '3' and userid ='$loguserid'"); ?>	
                                    <input name="page_id[]" type="checkbox" value="3"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Consignor</th>
                                    <th width="16%">
                                    <?php  $pageclick= check_duplicate("m_privilage","page_id = '4' and userid ='$loguserid'"); ?>	
                                    <input name="page_id[]" type="checkbox" value="4"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Consignee</th>
                                    <th width="17%">
                                    <?php  $pageclick= check_duplicate("m_privilage","page_id = '5' and userid ='$loguserid'"); ?>	
                                    <input name="page_id[]" type="checkbox" value="5"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Bank</th>
                                    <th width="17%">
                                    <?php  $pageclick= check_duplicate("m_privilage","page_id = '6' and userid ='$loguserid'"); ?>	
                                    <input name="page_id[]" type="checkbox" value="8"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Consignor Prefix Setting</th>
                                 </tr>
                                
                                
                                <tr>
                                	<th width="17%">
                                     <?php  $pageclick= check_duplicate("m_privilage","page_id = '9' and userid ='$loguserid'"); ?>
                                     <input name="page_id[]" type="checkbox" value="9"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Consignor Rate Setting</th>
                                   <th width="17%"> <?php  $pageclick= check_duplicate("m_privilage","page_id = '10' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="10"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Vender</th>
                                   <th width="17%"> <?php  $pageclick= check_duplicate("m_privilage","page_id = '11' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="11"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Employee</th>
                                   <th width="16%"> <?php  $pageclick= check_duplicate("m_privilage","page_id = '12' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="12"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Place Master</th>
                                    <th width="16%"> <?php  $pageclick= check_duplicate("m_privilage","page_id = '13' and userid ='$loguserid'"); ?> 									<input name="page_id[]" type="checkbox" value="13"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; State Master</th>
                                   <th width="16%"> <?php  $pageclick= check_duplicate("m_privilage","page_id = '14' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="14"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Item</th>                                                                        
                                 </tr>
                                 
                                 
                                  <tr>
                                	<th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '16' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="16"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Truck Type</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '17' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="17"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Truck Owner</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '18' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="18"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Master Truck</th>
                                    <th width="16%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '19' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="19"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Supplier Master</th>
                                    <th width="16%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '20' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="20"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Income Expense Head</th>
                                    <th width="16%"></th>                                                                        
                                 </tr>
                                 
                               
                                    <tr><th colspan="6"></th></tr>
                                    <tr><th colspan="6">Dispatch</th></tr>
                                 
                                 <tr>
                                	<th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '21' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="21"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Add Bilty</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '22' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="22"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Bilty Advance</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '23' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="23"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Bility Receiving</th>
                                    <th width="16%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '24' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="24"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Bilty Payment</th>
                                    <th width="16%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '25' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="25"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Truck Owner Payment</th>
                                    <th width="16%"></th>                                                                        
                                 </tr>
                                 
                                 
                                    <tr><th colspan="6"></th></tr>
                                    <tr><th colspan="6">Inventory</th></tr>
                                 
                                 <tr>
                                	<th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '26' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="26"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Diesel Rate Setting </th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '27' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="27"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Diesel Demand Slip</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '28' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="28"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Diesel Billing</th>
                                    <th width="16%"></th>
                                    <th width="16%"></th>
                                    <th width="16%"></th>                                                                        
                                 </tr>
                                 
                                 <tr><th colspan="6"></th></tr>
                                    <tr><th colspan="6">Maintenance</th></tr>
                                 
                                 <tr>
                                	<th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '29' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="29"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Truck Permanent Document</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '30' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="30"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Installment Fixation</th>
                                  <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '31' and userid ='$loguserid'"); ?>
                                  <input name="page_id[]" type="checkbox" value="31"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Truck Installation Payment</th>								                                  <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '32' and userid ='$loguserid'"); ?>
                                  <input name="page_id[]" type="checkbox" value="32"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Truck Uchanti</th>
                                   <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '33' and userid ='$loguserid'"); ?>
                                   <input name="page_id[]" type="checkbox" value="33"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp;Truck Expenses</th>
                                    <th width="16%"></th>                                                                        
                                 </tr>
                                 
                                 <tr><th colspan="6"></th></tr>
                                    <tr><th colspan="6">Account</th></tr>
                                 
                                 <tr>
                                	<th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '34' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="34"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp;  	Account Setting</th>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '35' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="35"  <?php if($pageclick !='0') { ?> checked <?php } ?>> &nbsp; &nbsp; Consignor Wise Income</th>
                                  <th width="17%"></th>								                                  
                                  <th width="17%"></th>
                                   <th width="17%"></th>
                                    <th width="16%"></th>                                                                        
                                 </tr>
                                 
                                 <tr><th colspan="6"></th></tr>
                                    <tr><th colspan="6">User</th>
                                    </tr>
                                    <tr>
                                    <th width="17%"><?php  $pageclick= check_duplicate("m_privilage","page_id = '36' and userid ='$loguserid'"); ?>
                                    <input name="page_id[]" type="checkbox" value="36"  <?php if($pageclick !='0') { ?> checked <?php } ?> > &nbsp; &nbsp;  	Add User</th>
                                 	 <th width="16%"></th>
                                      <th width="16%"></th>
                                       <th width="16%"></th>
                                        <th width="16%"></th>
                                         <th width="16%"></th>
                                         </tr>
                                 
                                </table> 
                                
                                <br>
								<br>

                                <center> 
                                				<input type="submit" class="btn btn-success" name="submit" id="submit" value="Save" > 
                                               <a href="<?php echo $pagename; ?>" class="btn btn-danger" >Reset</a>
                                </center>
                                
                                <?php 
								}
								?>
                                </div>
                                </form>
							
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

function seturl()
{
	var loguserid = document.getElementById('loguserid').value;
	
	if(loguserid !='')
	{
		window.location.href='?loguserid='+loguserid;	
	}
}
</script>
	</body>
  

	</html>
<?php
mysqli_close($connection);
?>
