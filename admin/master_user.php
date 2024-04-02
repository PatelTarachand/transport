<?php error_reporting(0);
include("dbconnect.php");
$tblname = "m_userlogin";
$tblpkey = "userid";
$pagename = "master_user.php";
$modulename = "User Master";

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;



if(isset($_GET['edit']))
{
	$tblpkey_value=$_GET['edit'];
	$sql_edit="select * from m_userlogin where userid='$tblpkey_value'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$username = $row['username'];
			$password = $row['password'];
			$usertype = $row['usertype'];
			$personname = $row['personname'];
			$branchid = $row['branchid'];
		//	$compid = $row['compid'];
		}//end while
	}//end if
}//end if

$duplicate= "";
if(isset($_POST['submit']))
{
	$username = trim(mysqli_real_escape_string($connection,$_POST['username']));
	$password = trim(mysqli_real_escape_string($connection,$_POST['password']));
	$usertype = "user";
	$personname = trim(mysqli_real_escape_string($connection,$_POST['personname']));
	$tblpkey_value = trim(mysqli_real_escape_string($connection,$_POST['userid']));
	$branchid = trim(mysqli_real_escape_string($connection,$_POST['branchid'])); 
//	$compid = trim(mysqli_real_escape_string($connection,$_POST['compid'])); 
	
	if($tblpkey_value==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_userlogin where username='$username'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{						
			$sql_insert="insert into m_userlogin set username = '$username', password = '$password',compid='$compid',
			 usertype='$usertype', personname='$personname',branchid='$branchid',createdate=now(),ipaddress = '$ipaddress',
			 sessionid = '$_SESSION[sessionid]'"; 
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_user.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		$sql_update = "update  m_userlogin set username = '$username', password = '$password',compid='$compid',
			 usertype='$usertype', personname='$personname',branchid='$branchid',createdate=now(),ipaddress = '$ipaddress',
			 sessionid = '$_SESSION[sessionid]' where userid='$tblpkey_value'"; 
		mysqli_query($connection,$sql_update);
		$keyvalue = $userid;
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='$pagename?action=2'</script>";
	}
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
							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                <table class="table table-condensed" style="width:50%;margin-top: 20px;">                                                               
                                <tr>                                
                                	<td><strong>Person Name:</strong></td>
                                    <td>
        					<input type="text" name="personname" value="<?php echo $personname; ?>" id="personname" class="input-large" autocomplete="off" >
                                    </td>
                                    
                                    <td><strong>User Name</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="username" id="username" value="<?php echo $username; ?>"
                                     autocomplete="off" class="input-large"></td>
                                   
                                 </tr>
                                                                                                    
                                  <tr>
                                   <td><strong>Password:</strong><span class="red">*</span></td>
                                    <td><input type="text" name="password" id="password" value="<?php echo $password; ?>" autocomplete="off"  maxlength="120"  class="input-large" ></td>                                   
                                    
                                    <td><strong>Branch:</strong></td>
                                    <td>
											<select name="branchid" id="branchid" class="select2-me input-large" >
                                    <option value="">--Select Branch--</option>
                                    <?php
									$res2 = mysqli_query($connection,"select * from m_branch");
									while($row =  mysqli_fetch_array($res2)) 
									{
									?>
                                    	<option value="<?php echo $row['branchid']; ?>"><?php echo $row['branchname']; ?></option>
                                        <?php
									}
									?>
                                    </select>
                                    <script>document.getElementById('branchid').value='<?php echo $branchid; ?>';</script>
									</td>
                                  </tr>
                                  
								 
                                                                     
                                 <tr>
                                 <td colspan="3" style="line-height:5"> 
                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('username,password')">
                    <input type="button" value="Reset" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />       			
                    <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                             </td>                                 
                                 <td>&nbsp;</td></tr>  
                                  
                                  
                                </table> 
                                </div>
                                </form>
							
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
                                            <th>Full Name</th>
                                        	<th>User Name</th>
                                            <th>Password</th>
											<th>Branch</th>
                                            <th>User Type</th>   
											<th>Company</th>                                        
                                        	<th class='hidden-480'>Action</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								//	echo "select * from m_userlogin where usertype='user' and compid='$compid' order by userid desc";
									$sel = "select * from m_userlogin where usertype='user' and compid='$compid' order by userid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$branchid = $row['branchid'];
										$compid = $row['compid'];
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                             <td><?php echo ucfirst($row['personname']);?></td>    
                                            <td><?php echo $row['username'];?></td>
                                            <td><?php echo $row['password'];?></td>
											<td><?php echo $cmn->getvalfield($connection,"m_branch","branchname","branchid='$branchid'"); ?></td>
                                            <td><?php echo ucfirst($row['usertype']);?></td>   
											<td><?php echo $cmn->getvalfield($connection,"m_company","cname","compid='$compid'"); ?></td>    
                                            <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['userid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
		document.getElementById('username').disabled = true;
		document.getElementById('checquenumber').value = "";
		document.getElementById('username').value = "";
	}
	else
	{
		document.getElementById('checquenumber').disabled = false;
		document.getElementById('username').disabled = false;
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
