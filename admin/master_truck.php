<?php 
include("dbconnect.php");
$tblname = "m_truck";
$tblpkey = "truckid";
$pagename = "master_truck.php";
$modulename = "Truck Master";
$imgpath1 ="uploaded/rc_card/";
$imgpath2 ="uploaded/agreement/";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['edit']))
{
	$truckid=$_GET['edit'];
	$sql_edit="select * from m_truck where truckid='$truckid'";
	$res_edit=mysqli_query($connection,$sql_edit);
	if($res_edit)
	{
		while($row=mysqli_fetch_array($res_edit))
		{
			$truckno = $row['truckno'];
			$typeid = $row['typeid'];
			$ownerid = $row['ownerid'];
			$manufacturer = $row['manufacturer'];
			$chesisno = $row['chesisno'];
			$model = $row['model'];
			$engineno = $row['engineno'];
			$openningkm = $row['openningkm'];
			$openningmeter = $row['openningmeter'];
			$make = $row['make'];
			$ownermob = $row['ownermob'];
			$owneraddress = $row['owneraddress'];
			$salary =  $row['salary'];
			$openingbalance =  $row['openingbalance'];
			$open_bal_date = $cmn->dateformatindia( $row['open_bal_date']);
			$imgname1=  $row['imgname1'];
			$imgname2=  $row['imgname2'];
			
		}//end while
	}//end if
}//end if
else
{
	$truckid = 0;
	$truckno='';
	$model='';
	$manufacturer='';
	$chesisno='';
	$engineno='';
	$openningkm='';
	$make='';
	$salary='';
	$openingbalance='';
	$openningmeter='';
	$ownermob='';
	$owneraddress='';
	$imgname1='';
	$imgname2='';
	$open_bal_date = date('Y-m-d');
}

$duplicate= "";

if(isset($_POST['submit']))
{
	$truckno = $_POST['truckno'];
	$typeid = $_POST['typeid'];
	$ownerid = $_POST['ownerid'];
	$manufacturer = $_POST['manufacturer'];
	$model = $_POST['model'];
	$chesisno = $_POST['chesisno'];
	$engineno = $_POST['engineno'];
	$openningkm = $_POST['openningkm'];
	//$openningmeter = $_POST['openningmeter'];
	$make = $_POST['make'];
	//$ownermob = $_POST['ownermob'];
	//$owneraddress = $_POST['owneraddress'];
	$salary = $_POST['salary'];
	$openingbalance = $_POST['openingbalance'];
	$open_bal_date = $cmn->dateformatusa($_POST['open_bal_date']);
	 $imgname1= $_FILES['imgname1'];
	// print_r($imgname1);
	  $imgname2= $_FILES['imgname2'];
	 //  print_r($imgname2);
	if($truckid==0)
	{
		//check doctor existance
		$sql_chk = "select * from m_truck where truckno='$truckno'";
		$res_chk = mysqli_query($connection,$sql_chk);
		$cnt = mysqli_num_rows($res_chk);
		
		if($cnt==0)
		{
			
			
			$sql_insert="insert into m_truck set truckno = '$truckno', typeid = '$typeid',
			 ownerid='$ownerid', manufacturer='$manufacturer', model='$model',empid='$empid', engineno='$engineno', openningkm='$openningkm',salary='$salary',
			  chesisno='$chesisno', make='$make',openingbalance='$openingbalance',createdate=now(),
			  open_bal_date='$open_bal_date',ipaddress = '$ipaddress',sessionid = '$_SESSION[sessionid]'";
			
			mysqli_query($connection,$sql_insert);
			$keyvalue = mysqli_insert_id($connection);
			$uploaded_filename = uploadImage($imgpath1,$imgname1);			

			mysqli_query($connection,"update m_truck set imgname1='$uploaded_filename' where truckid='$keyvalue'");

			$uploaded_filename = uploadImage($imgpath2,$imgname2);			

			mysqli_query($connection,"update m_truck set imgname2='$uploaded_filename' where truckid='$keyvalue'");

			$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $keyvalue,'insert');
			echo "<script>location='master_truck.php?action=1'</script>";
		}
		else
		$duplicate ="* Duplicate entry .... Data can not be saved!";
	}
	else
	{
		 $sql_update = "update  m_truck set truckno = '$truckno', typeid = '$typeid',
			 ownerid='$ownerid', manufacturer='$manufacturer', model='$model', engineno='$engineno', openningkm='$openningkm',salary='$salary',
			  chesisno='$chesisno',make='$make',openingbalance='$openingbalance',lastupdate=now(),
			  open_bal_date='$open_bal_date',ipaddress = '$ipaddress' where truckid='$truckid'"; 
			 //die;
		mysqli_query($connection,$sql_update);
		if($_FILES['imgname1']['tmp_name']!="")

				{

					//delete old file

					//$rowimg = mysqli_fetch_array(SelectDB($connection,$tblname,'1=1'));

					$oldimg1 = $rowimg["imgname1"];

					if($oldimg1 != "")

					unlink("uploaded/rc_card/$oldimg1");

					

					//insert new file

					$uploaded_filename1 = uploadImage($imgpath1,$imgname1);

					//$cmn->convert_image($uploaded_filename,"uploaded/slider","150","150");

					

					mysqli_query($connection,"update $tblname set imgname1='$uploaded_filename1' where $tblpkey='$truckid'");

				}
				
				
				if($_FILES['imgname2']['tmp_name']!="")

				{

					//delete old file

				//	$rowimg = mysqli_fetch_array(SelectDB($connection,$tblname,'1=1'));

					$oldimg2 = $rowimg["imgname2"];

					if($oldimg2 != "")

					unlink("uploaded/agreement/$oldimg2");

					

					//insert new file

					$uploaded_filename2 = uploadImage($imgpath2,$imgname2);

					//$cmn->convert_image($uploaded_filename,"uploaded/slider","150","150");

					

					mysqli_query($connection,"update $tblname set imgname2='$uploaded_filename2' where $tblpkey='$truckid'");

				}
			
		$cmn->InsertLog($connection,$pagename, $modulename, $tblname, $tblpkey, $truckid,'insert');
		echo "<script>location='master_truck.php?action=2'</script>";
	}
}

?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>

<script>
$(document).ready(function(){
    $("#shortcut_owner").click(function(){
        $("#div_ownerid").toggle(1000);
    });
});

$(document).ready(function(){
    $("#shortcut_trucktype").click(function(){
        $("#div_trucktype").toggle(1000);
    });
});
</script>

<style>
a.selected 
{
  background-color:#1F75CC;
  color:white;
  z-index:100;
}

.messagepop {
  background-color:#9FEAE5;
  border:1px solid #999999;
  cursor:default;
  display:none;

  position:fixed;
  top:50px;
  right:0px;
  text-align:left;
  width:300px;
  z-index:50;

}

.messagepop p, .messagepop.div {
  border-bottom: 1px solid #EFEFEF;
  margin: 8px 0;
  padding-bottom: 8px;
}
</style>

</head>
<body>
<!--- short cut form owner name --->
<div class="messagepop pop" id="div_ownerid">
<img src="b_drop.png" class="close" onClick="$('#div_ownerid').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Truck Owner </strong></td></tr>
  <tr><td>&nbsp;Owner Name: </td></tr>
  <tr><td><input type="text" name="sc_ownerid" id="sc_ownerid" class="input-medium"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_ownerid();"/></td></tr>
</table>
</div>
<!------end here ---->

<!--- short cut form truck type --->
<div class="messagepop pop" id="div_trucktype">
<img src="b_drop.png" class="close" onClick="$('#div_trucktype').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed" >
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Truck Type </strong></td></tr>
  <tr><td>&nbsp;Truck Type: </td></tr>
  <tr><td><input type="text" name="sc_typename" id="sc_typename" class="input-medium"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_trucktype();"/></td></tr>
</table>
</div>
<!------end here ---->


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
                                 <form  method="post" action="" class='form-horizontal' enctype="multipart/form-data" onSubmit="return checkinputmaster('truckno')">
                                <div class="control-group">
                                <table class="table table-condensed">
                                <tr><td colspan="4"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td></tr>
                                
                                <tr>
                                    <td width="12%"><strong>Truck Number:</strong><span class="red">*</span></td>
                                    <td width="25%"><input type="text" name="truckno" id="truckno" value="<?php echo $truckno; ?>"
                                     autocomplete="off"  maxlength="120"   class="input-large" placeholder='enter truck no.' ></td>
                                    <td width="12%"><strong>Owner Name:</strong></strong><span class="red">*</span> &nbsp;&nbsp;<!--<img src="add.png" id="shortcut_owner">--></td>
                                    <td width="51%">
                                     <?php
									$sql2 = "select * from m_truckowner order by ownerid";
									$res2 = mysqli_query($connection,$sql2);
									?>
                                    <select name="ownerid" id="ownerid" class="select2-me input-large">
                                    <option value="">--select Owner--</option>
                                    <?php
									while($row =  mysqli_fetch_array($res2)) 
									{
									?>
                                    	<option value="<?php echo $row['ownerid']; ?>"><?php echo $row['ownername'].' / '.ucwords($row['father_name']); ?></option>
                                        <?php
									}
									?>
                                    </select>
                                    <script>document.getElementById('ownerid').value='<?php echo $ownerid; ?>';</script>
                                    
                                    
                                    
                                 </td
                                    ></td>
                                 </tr>
                                 
                                 
                                
                                  <tr>
                                    <td><strong>Truck Type:</strong><span class="red">*</span>&nbsp;&nbsp;<!--<img src="add.png" id="shortcut_trucktype">--></td>
                                    <td width="25%">
                                    <?php
									$sql2 = "select * from m_trucktype order by typeid";
									$res2 = mysqli_query($connection,$sql2);
									?>
                                    <select name="typeid" id="typeid" class="select2-me input-large" >
                                    <option value="">--select type--</option>
                                    <?php
									while($row2 =  mysqli_fetch_array($res2)) 
									{
									?>
                                    	<option value="<?php echo $row2['typeid']; ?>"><?php echo $row2['typename']; ?></option>
                                        <?php
									}
									?>
                                    </select>
                                    <script>document.getElementById('typeid').value='<?php echo $typeid; ?>';</script>
                                    </td>
                                    <td width="12%"><strong>Truck Model:</strong></td>
                                    <td width="51%"><input type="text" name="model" id="model" value="<?php echo $model; ?>" autocomplete="off"
                                      maxlength="120"  class="input-large" placeholder='enter truck model'></td>
                                  </tr>
                                  
                                   <tr>
                                    <td><strong>Manufacturer:</strong></td>
                                    <td width="25%">
                                    <input type="text" name="manufacturer" value="<?php echo $manufacturer; ?>" id="manufacturer" 
                                      class="input-large" placeholder='enter manufacturer name'>
                                    </td>
                                    <td width="12%"><strong>Chassis No:</strong></td>
                                    <td width="51%"><input type="text" name="chesisno" value="<?php echo $chesisno; ?>" id="chesisno" 
                                     class="input-large" placeholder='enter chasis no.'></td>
                                  </tr>
                                  
                                   <tr>
                                    <td><strong>Engine No:</strong></td>
                                    <td width="25%">
                                    <input type="text" name="engineno" value="<?php echo $engineno; ?>" id="engineno" 
                                     class="input-large" placeholder='engine number'>
                                    </td>
                                    <td width="12%"><strong>Opening K.M.</strong></td>
                                    <td width="51%"><input type="text" name="openningkm" value="<?php echo $openningkm; ?>" id="openningkm" 
                                      class="input-large" placeholder='opening km'></td>
                                  </tr>
                                  
                                  <tr>                            
                                    <td><strong>Make Year:</strong></td>
                                    <td>
                                    <input type="text" name="make" value="<?php echo $make; ?>" id="make" 
                                     class="input-large" placeholder='enter make year'>
                                    </td>
                                     <td><strong>Driver/Hamali Salary :</strong></td>
                                    <td>
                                    <input type="text" name="salary" value="<?php echo $salary; ?>" id="salary" 
                                     class="input-large" placeholder='enter salary'>
                                    </td>
                                  </tr>
                                   
                                   <tr>                                   
                                    <td><strong>Opening Balance</strong></td>
                                    <td>
       							 <input type="text" name="openingbalance" value="<?php echo $openingbalance; ?>" id="openingbalance" class="input-large" placeholder='enter opening balance'></td>
                                  <td><strong>Open. Bal. Date :</strong></td>
                                    <td>
                                     <input type="text" class="form-control" name="open_bal_date" id="open_bal_date" value="<?php echo $cmn->dateformatindia($open_bal_date); ?>"  placeholder="dd-mm-yyyy" >
                                    </td>
                                  </tr>
                                  
                                  <tr>
                                  <td><strong>Upload RCcard</strong></td>

                       <td><input type="file" name="imgname1"id="imgname1"><img id="blah" alt="" style="width:100px;" title='Text Image' src='<?php if($imgname1!="" && file_exists("uploaded/rc_card/".$imgname1)){ echo "uploaded/rc_card/".$imgname1; }?>'/>  </td> 

                                  
                                  <td><strong>Upload Agreement Paper</strong></td>

                       <td><input type="file" name="imgname2"id="imgname2"><img id="blah" alt="" style="width:100px;" title='Text Image' src='<?php if($imgname2!="" && file_exists("uploaded/agreement/".$imgname2)){ echo "uploaded/agreement/".$imgname2; }?>'/>  </td> 

                                  
                                  
                                  </tr>
                                  
                                   
                                  
                                  <tr>                                  
                                    <td colspan="4"><span class="control-group">
                                    <div class="form-actions">
                                    <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success"
                                     onClick="return checkinputmaster('truckno,ownerid,typeid')" tabindex="10" style="margin-left:192px">
									<?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                                   {?>
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                    
                                    <?php
                                   }
                                   else
                                   {
                                       
                                   ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:15px" onClick="document.location.href='<?php echo $pagename ; ?>';">
                                    <?php
                                   }
								   ?>
									</div>
                                      <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>" >
                                    </span></td>
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
                                 <a href="excel_master_truck.php" class="btn btn-small btn-primary" style="float:right;">Excel</a>
                                
                                
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck No.</th>
                                            <th>Type</th>
                                            <th>Owner</th>
                                            <th>Manufacturer</th>
                                            <th>Model</th>
                                            <th>Chesis No</th>
                                            <th>Engine No</th>
                                            <th>Openning Km</th>                                          
                                            <th>Make Year</th>
                                            <th>RC Card</th>
                                            <th>Agreement Paper</th>
                                            <th>Action</th>                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_truck order by truckid desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['truckno']);?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_trucktype","typename","typeid=$row[typeid]"); ?></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_truckowner","ownername","ownerid=$row[ownerid]"));?></td>
                                            <td><?php echo ucfirst($row['manufacturer']);?></td>
                                            <td><?php echo ucfirst($row['model']);?></td>
                                            <td><?php echo ucfirst($row['chesisno']);?></td>
                                            <td><?php echo ucfirst($row['engineno']);?></td>
                                            <td><?php echo ucfirst($row['openningkm']);?></td>                                          
                                            <td><?php echo ucfirst($row['make']);?></td>
                                             <td> <?php if($row['imgname1']!=""){ ?>
                                            <a href="uploaded/rc_card/<?php echo $row['imgname1'];?>" target="_blank" style="color:#F00; font-weight:bold">Download RCcard</a>  <?php } else {  ?> Not Available <?php } ?>  </td>
                                            <td> <?php if($row['imgname2']!=""){ ?>
                                            <a href="uploaded/agreement/<?php echo $row['imgname2'];?>" target="_blank" style="color:#F00; font-weight:bold">Download Agreement Paper</a>  <?php } else {  ?> Not Available <?php } ?>  </td>
                                            <td>
                                           <a href= "?edit=<?php echo ucfirst($row['truckid']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['truckid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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





function ajax_save_trucktype()
{
	var typename = document.getElementById('sc_typename').value;
	//alert(textval);
	if(typename == "")
	{
		alert('Fill form properly');
		document.getElementById('sc_typename').focus();
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
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("typeid").innerHTML = xmlhttp.responseText;
				document.getElementById("sc_typename").value = "";
				$("#div_trucktype").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savetrucktype.php?typename="+typename,true);
	xmlhttp.send();
}

jQuery(function($){
   $("#open_bal_date").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});



</script>
	</body>
	</html>
<?php
mysqli_close($connection);
?>
