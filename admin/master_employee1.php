<?php 
include("dbconnect.php");
$tblname = "m_employee";
$tblpkey = "empid";
$pagename = "master_employee.php";
$modulename = "Employee Master";

//print_r($_SESSION);
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;
if(isset($_GET['edit']))
{
	$empid=$_GET['edit'];
	$sql_edit="select * from m_employee where empid='$empid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$empname = $row['empname'];
			$designation = $row['designation'];
			$doj =$row['doj'];
			$salary = $row['salary'];
			$pfno = $row['pfno'];
			$esicno = $row['esicno'];
			$pan = $row['pan'];
			$acntno = $row['acntno'];
			$lisenceno = $row['lisenceno'];
			$lisenceissuedate = $row['lisenceissuedate'];
			$lisenceexpiredate =$row['lisenceexpiredate'];
			$compid = $row['compid'];
			$dateofbirth =$row['dateofbirth'];
			$medicalexpire =$row['medicalexpire'];
			$bloodgroup = $row['bloodgroup'];
			$mob1 = $row['mob1'];
			$mob2 = $row['mob2'];
			$address = $row['address'];
			$petrolallownce = $row['petrolallownce'];
			$address = $row['address'];
			$moballownce = $row['moballownce'];
			$esic_per = $row['esic_per'];
			$pf_per = $row['pf_per'];
			$status = $row['status'];
		}//end while
	}//end if
}//end if
else
{
	$empid = 0;
	$incdate = date('d-m-Y');
	$empname = '';
	$designation = '';
	$doj = '';
	$salary = '';
	$pfno = '';
	$esicno = '';
	$pan ='';
	$acntno = '';
	$lisenceno = '';
	$lisenceissuedate = '';
	$lisenceexpiredate = '';
	$compid = '';
	$dateofbirth = '';
	$medicalexpire = '';
	$bloodgroup = '';
	$mob1 = '';
	$mob2 = '';
	$address ='';
	$petrolallownce = '';
	$address = '';
	$moballownce = '';
	$esic_per = '';
	$pf_per = '';
	$status = '';
}
$duplicate= "";
if(isset($_POST['submit']))
{
	
	$empname = $_POST['empname'];
	$designation = $_POST['designation'];
	$doj = $_POST['doj'];
	
	$salary = $_POST['salary'];
	//$pfno = $_POST['pfno'];
	$esicno = $_POST['esicno'];
	$pan = $_POST['pan'];
	$acntno = $_POST['acntno'];
	$lisenceno = $_POST['lisenceno'];
	$lisenceissuedate = $_POST['lisenceissuedate'];
	$lisenceexpiredate = $_POST['lisenceexpiredate'];
	$compid = $_POST['compid'];
	$dateofbirth = $_POST['dateofbirth'];
	$medicalexpire = $_POST['medicalexpire'];
	
	$mob1 = $_POST['mob1'];
	$mob2 = $_POST['mob2'];
	$address = $_POST['address'];
	$moballownce = $_POST['moballownce'];
	$petrolallownce = $_POST['petrolallownce'];
	$esic_per = $_POST['esic_per'];
	$pf_per = $_POST['pf_per'];
	$status = $_POST['status'];
	
	
	if($empid==0)
	{
		
		//check doctor existance
		$sql_chk = "select * from m_employee where empname='$empname' and compid = '$compid'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt == 0)
		{
		    
		   
			$sql_insert="insert into m_employee set empname = '$empname',designation='$designation', doj='$doj', 
			 salary='$salary',esicno='$esicno', pan='$pan', 
			 acntno='$acntno',lisenceno = '$lisenceno',lisenceissuedate='$lisenceissuedate', lisenceexpiredate='$lisenceexpiredate', 
			 compid='$compid', dateofbirth = '$dateofbirth',medicalexpire='$medicalexpire', bloodgroup='$bloodgroup', 
			 mob1='$mob1', mob2='$mob2', address='$address', esic_per='$esic_per', pf_per='$pf_per', moballownce='$moballownce',
			 petrolallownce='$petrolallownce',status='$status', createdate=now(),sessionid = '$_SESSION[sessionid]'";
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
					
			echo "<script>location='master_employee.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
	    
		
		 $sql_update = "update  m_employee set empname = '$empname',designation='$designation', doj='$doj', 
			 salary='$salary',esicno='$esicno', pan='$pan', 
			 acntno='$acntno',lisenceno = '$lisenceno',lisenceissuedate='$lisenceissuedate', lisenceexpiredate='$lisenceexpiredate', 
			 compid='$compid', dateofbirth = '$dateofbirth',medicalexpire='$medicalexpire', bloodgroup='$bloodgroup', 
			 mob1='$mob1', mob2='$mob2',address='$address',  moballownce='$moballownce', petrolallownce='$petrolallownce',
			 esic_per='$esic_per', pf_per='$pf_per',status='$status', lastupdated=now() where empid='$empid'";
		mysqli_query($connection,$sql_update);
		$keyvalue = $empid;
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'updated');
		echo "<script>location='master_employee.php?action=2'</script>";
	}
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
	$("#shortcut_placeid").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});
	</script>
</head>

<body>
<!--- short cut form place --->
<div class="messagepop pop" id="div_placeid">
<img src="b_drop.png" class="close" onClick="$('#div_placeid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Place</strong></td></tr>
  <tr><td>&nbsp;Unit Name: </td></tr>
  <tr><td><input type="text" name="placename" id="placename" class="input-medium" style="width:190px ; border:1px dotted #666"/></td></tr>

  <tr><td align="center"><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_placename();"/></td></tr>
</table>
</div>
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
                                 <form  method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('empname al,designation,mob1 nu')">
                                <div class="control-group">
                                <table>
                                <tr><td colspan="4" class="text-error"><strong><?php echo $duplicate ;?></strong></td></tr>
                                <tr>
                                <td width="18%">Employee Name <span style="color:#F00">*</span></td>
		<td width="23%"><input class="frmsave formbox" type="text" id="empname" data-required="true" name="empname"  tabindex="1" value="<?php echo $empname; ?>"></td>
		<td width="20%">Designation<span style="color:#F00">*</span></td>
		<td width="17%">
			
			<select name="designation" id="designation" class="formbox" tabindex="2" value="<?php echo $designation; ?>">
				<option > - Select - </option>
                <option value="1">Driver</option>
                <option value="2">Conductor</option>
                <option value="3">Office Staff</option>
				<option value="4">Computer Oprator</option>
				<option value="5">Marketing Executive</option>
				<option value="6">Accountant</option>
              
			</select>
             <script>document.getElementById('designation').value='<?php echo $designation; ?>';</script></td>
		</td>
	</tr>
	<tr>
		<td width="18%">Date Of Joining<span class="red"> (dd-mm-yyyy)</span> </td>
		<td width="23%"><input class="frmsave formbox" type="date" name="doj" id="doj" placeholder="dd-mm-yyyy" data-date="true" tabindex="3" value="<?php echo $doj; ?>"></td>
		<td>PAN</td>
		<td><input class="frmsave formbox" type="text" name="pan" id="pan" maxlength="12"  tabindex="6" value="<?php echo $pan; ?>"></td>
		
	</tr>
	<tr>
		
		
		<td>Lisence No</td>
		<td><input class="frmsave formbox" type="text" name="lisenceno" id="lisenceno" maxlength="19" tabindex="7" value="<?php echo $lisenceno; ?>"></td>
		<td>Lisence Issue Date<span class="red"> (dd-mm-yyyy)</span></td>
		<td><input class="frmsave formbox" type="date" name="lisenceissuedate" id="lisenceissuedate" placeholder="dd-mm-yyyy" data-date="true" tabindex="8" value="<?php echo $lisenceissuedate; ?>"></td>
	</tr>
	<tr>
		
		
	</tr>
	<tr>
		<td>Lisence Expire Date<span class="red"> (dd-mm-yyyy)</span></td>
		<td><input class="frmsave formbox" type="date" name="lisenceexpiredate" id="lisenceexpiredate" placeholder="dd-mm-yyyy" tabindex="9" data-date="true" value="<?php echo $lisenceexpiredate; ?>"/></td>
		<td valign="top">Date of Birth<span class="red">(dd-mm-yyyy)</span></td>
		<td valign="top"><input class="frmsave formbox" type="date" name="dateofbirth" id="dateofbirth" placeholder="dd-mm-yyyy" tabindex="11" data-date="true" value="<?php echo $dateofbirth; ?>" /></td>
	</tr>
	<tr>
		
		<!-- <td valign="top">Medical Expire Date<span class="red">(dd-mm-yyyy)</span></td>
		<td valign="top"><input class="frmsave formbox" type="text" name="medicalexpire" id="medicalexpire" placeholder="dd-mm-yyyy" data-date="true" tabindex="12" value="<?php echo $medicalexpire; ?>" /></td> -->
	</tr>
	<tr>
		<td valign="top">Mobile(1)<span style="color:#F00">*</span></td>
		<td valign="top"><input class="frmsave formbox" type="text" name="mob1" id="mob1" tabindex="13" maxlength="13" value="<?php echo $mob1; ?>" /></td>
		<td valign="top">Mobile(2)</td>
		<td><input class="frmsave formbox" type="text" id="mob2" name="mob2" tabindex="14" maxlength="13" value="<?php echo $mob2; ?>" /></td>
	</tr>
	
		<tr>
		<td valign="top">Salary</td>
		<td valign="top"><input class="frmsave formbox" type="text" name="salary" id="salary" tabindex="13" maxlength="13" value="<?php echo $salary; ?>" /></td>
		 
		<td valign="top">Status</td>
        <td valign="top">
        	<select  name="status" id="status" tabindex="10" value="<?php echo $status; ?>">
            	<option value="0">In-Active</option>
                <option value="1">Active</option>
            </select>
        	 <script>document.getElementById('status').value='<?php echo $status; ?>';</script>			
        </td>
	</tr>
    
	 
      
      <tr>
        <td valign="top">Address</td>
		<td><textarea class="frmsave formarea" name="address" id="address" tabindex="16" ><?php echo $address; ?></textarea></td>
		
	
	  
      </tr>
       <tr><td colspan="4" style="line-height:5">
        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"onClick="return checkinputmaster('consigneename,placeid')" tabindex="20" style="margin-left:515px" >
       
        <input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" tabindex="9"/>
        
      
          <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
       </td></tr>
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
                             <a href="excel_master_employee.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                 
                             
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered table-condensed table-striped">
									<thead>
										<tr>
                                            <th>Sno</th>
                                            <th>Employee Name</th>
                                            <th>Mobile</th>
                                            <th>Designation</th>
                                            <th>Date of Joining</th>
                                            <th>Salary</th>
                                            <!--<th>Company Name</th>-->
                                           
                                            <th>Status</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_employee where empid != '-1' order by empid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										if($row['designation']==1)
										{
											$designation = "Driver";
										}
										else
										{
											if($row['designation']==2)
											{
												$designation = "Conductor";
											}
												else
												{
													if($row['designation']==3)
													{
														$designation = "Office Staff";
													}
												}
										}
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $row['empname'];?></td>
                                            <td><?php echo $row['mob1'];?></td>
                                            <td><?php echo $designation;?></td>
                                            <td><?php echo $cmn->dateformatindia($row['doj']);?></td>
                                            <td><?php echo $row['salary'];?></td>
                                           
                                            <!--<td><?php echo  $cmn->getvalfield($connection,"m_company","cname","compid=$row[compid]");?></td>-->
                                           
                                          
                                            
                                       


                                        </head>
                                        <body >



                                            
                                            <td><strong style="color:red;">
												<?php 
											         $status = $row['status'];
											      if ( $status == 0 ) { $status= '<span >In-Active</span>';	} else { $status= '<span style=color:green;> Active</span>';}											
											     	echo  $status;  
												?>
                                                </strong></td>
                                            
                                           <td class='hidden-480'>
                                           <a href= "?edit=<?php echo ucfirst($row['empid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['empid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
	  	//alert(tblname);
	if(confirm("Are you sure! You want to delete this record."))
	{
		//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
		$.ajax({
		  type: 'POST',
		  url: '../ajax/delete.php',
		  data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename,
		  dataType: 'html',
		  success: function(data){
			 //alert(data);
			 //alert('Data Deleted Successfully');
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
<script>
function ajax_save_placename()
{
	var placename = document.getElementById('placename').value;
		//alert(placename);
		if(placename == "")
		{
			alert('Please Fill place name');
			document.getElementById('placename').focus();
			return false;
		}
		
		if(window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} 
		else
		{ // code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText != '')
				{
					//alert('This specification already exist');
					//alert( xmlhttp.responseText);
					document.getElementById("placeid").innerHTML = xmlhttp.responseText;
					
					document.getElementById("placename").value = "";
					$("#div_placeid").hide(1000);
					
				}
			}
		}
		xmlhttp.open("GET","ajax_saveplace.php?placename="+placename,true);
		xmlhttp.send();
}
</script>
<script>
function upload_image(id)
{
	$('#'+id).click();
}
function delete_image(id)
{
	if($('#'+id).val()!="")
	{
		ajaxManager.addReq({
		   type: 'POST',
		   url: 'delete_file.php',
		   data: {
				file_name:""+$('#'+id).val()
			},
		   success: function(data){
				$('#'+id).val("");
				$('#'+id).change();
		   }
		});
	}
}
$(document).ready(function(){
	// must keep draw_table();
	$("#empname").focus();
	draw_table();
	$("#save").click(function(){
		if($("input#<?php echo $tablekey; ?>").val().length>0)
		{
			save("<?php echo $tablename; ?>","<?php echo $tablekey; ?>","frmsave","update");
		}
		else
		{
			save("<?php echo $tablename; ?>","<?php echo $tablekey; ?>","frmsave","");
		}
	});
	$("#reset").click(function(){
		draw_table();
		$("img.preview").attr("src", "350x150.jpg");
		$("img.preview1").attr("src", "not_availabe.png");
		$("img.preview2").attr("src", "not_availabe.png");
		$("img.preview3").attr("src", "not_availabe.png");
		$("img.preview4").attr("src", "not_availabe.png");
		$("img.preview5").attr("src", "not_availabe.png");
		$("#empname").focus();
	});
	// upload
		$('#e_photo').live('change', function(){
		$("#preview").html('');
		$("#preview").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform").ajaxForm({target: '#preview', success: showResponse}).submit();
		});
		
		$('#e_photo1').live('change', function(){
		$("#preview1").html('');
		$("#preview1").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform1").ajaxForm({target: '#preview1', success: showResponse1}).submit();
		});
		
		$('#e_photo2').live('change', function(){
		$("#preview2").html('');
		$("#preview2").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform2").ajaxForm({target: '#preview2', success: showResponse2}).submit();
		});
		
		$('#e_photo3').live('change', function(){
		$("#preview3").html('');
		$("#preview3").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform3").ajaxForm({target: '#preview3', success: showResponse3}).submit();
		});
		
		$('#e_photo4').live('change', function(){
		$("#preview4").html('');
		$("#preview4").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform4").ajaxForm({target: '#preview4', success: showResponse4}).submit();
		});
		
		$('#e_photo5').live('change', function(){
		$("#preview5").html('');
		$("#preview5").html('<img src="loading.gif" height="100" width="100" alt="Uploading...."/>');
		$("#imageform5").ajaxForm({target: '#preview5', success: showResponse5}).submit();
		});
		// Apply changes
		$("#photo").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview").html('<img src="350x150.jpg" class="preview" >');
		});
		$("#doc1").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview1").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview1").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview1").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview1").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview1").html('<img src="not_availabe.png" class="preview" >');
		});
		$("#doc2").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview2").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview2").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview2").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview2").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview2").html('<img src="not_availabe.png" class="preview" >');
		});
		$("#doc3").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview3").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview3").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview3").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview3").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview3").html('<img src="not_availabe.png" class="preview" >');
		});
		$("#doc4").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview4").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview4").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview4").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview4").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview4").html('<img src="not_availabe.png" class="preview" >');
		});
		$("#doc5").change(function(){
			if($(this).val()!="")
			{
				var value=$(this).val();
				var ext=value.split(".");
				if(ext[1]=="pdf")
				{
					$("#preview5").html('<img src="paragraph1.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="doc")
				{
					$("#preview5").html('<img src="paragraph11.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else if(ext[1]=="xls" || ext[1]=="xlsx")
				{
					$("#preview5").html('<img src="excelimg.png" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
				else
				{
					$("#preview5").html('<img src="'+$(this).val()+'" class="preview" height="150" width="120" alt="Employee Photo"/>');
				}
			}
			else
			$("#preview5").html('<img src="not_availabe.png" class="preview" >');
		});
	});
	// Response
	function showResponse(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(0)"))
		{
			$("#photo").val($("img.preview:eq(0)").attr("src"));
		}
	}
	function showResponse1(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(1)"))
		{
			$("#doc1").val($("img.preview:eq(1)").attr("src"));
		}
	}
	function showResponse2(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(2)"))
		{
			$("#doc2").val($("img.preview:eq(2)").attr("src"));
		}
	}
	function showResponse3(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(3)"))
		{
			$("#doc3").val($("img.preview:eq(3)").attr("src"));
		}
	}
	function showResponse4(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(4)"))
		{
			$("#doc4").val($("img.preview:eq(4)").attr("src"));
		}
	}
	function showResponse5(responseText, statusText, xhr, $form)
	{
		if($("img.preview:eq(5)"))
		{
			$("#doc5").val($("img.preview:eq(5)").attr("src"));
		}
	}
</script>
	</body>
  
	</html>
<?php
mysqli_close($connection);
?>
