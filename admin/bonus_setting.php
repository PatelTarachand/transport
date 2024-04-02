<?php 
include("dbconnect.php");
$tblname = "m_bonus";
$tblpkey = "bonus_id";
$pagename = "bonus_setting.php";
$modulename = "Bonus Setting";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['bonus_id']))
{
	$keyvalue=trim(addslashes($_GET['bonus_id']));	
}
else
{
	$keyvalue=0;
}


if(isset($_POST['submit']))
{
	$keyvalue = trim(addslashes($_POST['bonus_id']));
	$avg_from = trim(addslashes($_POST['avg_from']));
	$avg_to = trim(addslashes($_POST['avg_to']));
	$typeid = trim(addslashes($_POST['typeid']));
	$bonus_amt = trim(addslashes($_POST['bonus_amt']));
	
	if($keyvalue==0)
	{
		mysqli_query($connection,"insert into m_bonus set avg_from='$avg_from',avg_to='$avg_to',typeid='$typeid',bonus_amt='$bonus_amt',ipaddress='$ipaddress',createdate='$createdate',
					createdby='$userid'");	
		$action = 1;
	}
	else
	{
		mysqli_query($connection,"update m_bonus set avg_from='$avg_from',avg_to='$avg_to',bonus_amt='$bonus_amt',typeid='$typeid',ipaddress='$ipaddress',lastupdate='$createdate',
					createdby='$userid' where bonus_id='$keyvalue'");
		$action = 2;
	}
	
	echo "<script>location='$pagename?action=$action'</script>";
}	

if($keyvalue !='0')
{
	$sql = mysqli_query($connection,"select * from m_bonus where bonus_id='$keyvalue'");	
	$row=mysqli_fetch_assoc($sql);
	$avg_from = $row['avg_from'];
	$avg_to = $row['avg_to'];
	$typeid = $row['typeid'];
	$bonus_amt = $row['bonus_amt'];
}
else
{
	$bonus_id=0;
	$avg_from='';
	$avg_to='';
	$typeid='';
	$bonus_amt='';
	
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
                            
                            <div class="span12">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                
                                <table class="table table-condensed" width="100%">
                                <tr>
<td width="10%"><strong> From Bonus</strong> <strong>:</strong><span class="red">*</span></td>
<td width="10%">
<input name="avg_from" id="avg_from" value="<?php echo $avg_from; ?>" placeholder="Average From" class="input-small" type="text" autocomplete="off">
</td>    


<td width="10%"><strong>To Bonus</strong> <strong>:</strong><span class="red">*</span></td> 
<td width="10%">                          
<input name="avg_to" id="avg_to" value="<?php echo $avg_to; ?>" placeholder="Average To" class="input-small" type="text" autocomplete="off">
</td>

<td width="10%"><strong>Truck Type</strong><strong>:</strong><span class="red">*</span></td>
<td width="15%">
                                    <?php
									$sql2 = "select * from m_trucktype order by typeid";
									$res2 = mysqli_query($connection,$sql2);
									?>
                                    <select name="typeid" id="typeid" class="select2-me input-medium" style="width:72%;" >
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

<td width="10%"><strong>Bonus Amount</strong> <strong>:</strong><span class="red">*</span></td> 
<td width="10%">                          
<input name="bonus_amt" id="bonus_amt" value="<?php echo $bonus_amt; ?>" placeholder="Bonus Amount" class="input-small" type="text" autocomplete="off">
</td>





<td>
<input type="submit" name="submit" value="Save" class="btn btn-success" > &nbsp;
<a href="<?php echo $pagename; ?>" class="btn btn-danger" >Reset</a>
<input type="hidden" name="bonus_id" value="<?php echo $keyvalue; ?>" >
</td>
                                                                   
                                 </tr>
                                                                                                    		                                
                                </table>
                                                     
                                
                                
                                 
                                </div>
                                </form>
                                
                           </div>
                           
                                
							
						</div>
					</div>
				</div>
                
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
                                            <th width="20%">Average From</th>
                                            <th width="20%">Average To</th>
                                             <th width="20%">Truck Type</th>
                                            <th width="20%">Bonus Amount</th>
                                            <th class='hidden-480' width="10%">Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									$sel = "select * from m_bonus order by bonus_id desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$typename = $cmn->getvalfield($connection,"m_trucktype","typename","typeid=$row[typeid]")
										
										
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['avg_from']);?></td>
                                            <td><?php echo ucfirst($row['avg_to']);?></td>
                                             <td><?php echo $typename ;?></td>
                                            <td><?php echo ucfirst($row['bonus_amt']);?></td>
                                           	<td class='hidden-480'>
                                           <a href= "?bonus_id=<?php echo ucfirst($row['bonus_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row['bonus_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
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
			  location=pagename+'?action=10&truckid=<?php echo $bonus_id; ?>';
			}
		
		  });//ajax close
	}//confirm close
} //fun close

jQuery(function($){
		$(".datemaskk").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
		
 
});


function searchdata()
{
	var truckid = document.getElementById('truckid').value;
	var drivername = document.getElementById('drivername').value;
	
	if(truckid=='')
	{
		alert("Please Select Truck No");
		return false;
	}
	
	if(drivername=='')
	{
		alert("Please Select Driver Name");	
		return false;
	}
	
	window.location.href='?truckid='+truckid+'&drivername='+drivername;
}

function checkdriver()
{
	var drivername = document.getElementById('drivername').value;
	
	if(drivername !='')
	{
	$.ajax({
		  type: 'POST',
		  url: 'checkdriverexist.php',
		  data: 'drivername=' + drivername,
		  dataType: 'html',
		  success: function(data){
			  //alert(data);
			  if(data==0)
			  {
					alert("driver doesn't exist");  
					document.getElementById('drivername').value='';
					return false;
			  }
			
			}
		
		  });//ajax close
	}
}

function addlist()
{
	var truckid = document.getElementById('truckid').value;
	var drivername = document.getElementById('drivername').value;
	var bhatta_amount =  document.getElementById('bhatta_amount').value;
	var bhatta_date =  document.getElementById('bhatta_date').value;	
	var hammali_amount =  document.getElementById('hammali_amount').value;
	var hammali_date =  document.getElementById('hammali_date').value;
	var other_amount =  document.getElementById('other_amount').value;
	var other_date =  document.getElementById('other_date').value;
	var tax_amount =  document.getElementById('tax_amount').value;
	var tax_date =  document.getElementById('tax_date').value;
	
	
	$.ajax({
		  type: 'POST',
		  url: 'saveexpense.php',
		  data: 'truckid=' + truckid + '&drivername=' + drivername + '&bhatta_amount=' + bhatta_amount + '&bhatta_date=' + bhatta_date + 
		  '&hammali_amount=' + hammali_amount + '&hammali_date=' + hammali_date +'&other_amount=' + other_amount + '&other_date=' + other_date
		    +'&tax_amount=' + tax_amount + '&tax_date=' + tax_date,
		  dataType: 'html',
		  success: function(data){
		
			}
		
		  });//ajax close
}

</script>
	</body>
  	</html>
<?php
mysqli_close($connection);
?>
