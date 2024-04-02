<?php error_reporting(0);
include("dbconnect.php");
$tblname = "truck_expense";
$tblpkey = "truckexpenseid";
$pagename = "truck_expenses_mul.php";
$modulename = "Truck Expense";
if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['truckid']))
{
	$truckid = trim(addslashes($_GET['truckid']));	
}

if(isset($_GET['drivername']))
{
	$drivername = trim(addslashes($_GET['drivername']));	
}
else
{
	$drivername='';	
}

if(isset($_POST['submit']))
{
$truckid = trim(addslashes($_POST['truckid']));
$drivername = trim(addslashes($_POST['drivername']));
$bhatta_amount = $_POST['bhatta_amount'];
$bhatta_date = $_POST['bhatta_date'];
$bhatta_remark = $_POST['bhatta_remark'];

$hammali_amount =$_POST['hammali_amount'];
$hammali_date =$_POST['hammali_date'];
$hamali_remark = $_POST['hamali_remark'];

$other_amount =$_POST['other_amount'];
$other_date =$_POST['other_date'];
$other_remark = $_POST['other_remark'];

$tax_amount =$_POST['tax_amount'];
$tax_date =$_POST['tax_date'];
$tax_remark = $_POST['tax_remark'];

if($truckid !='' && $drivername !='')
{

if($bhatta_amount !='')
{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='bhatta' && headtype='Truck'");
	if($head_id !='')
	{
		for($i=0; $i<sizeof($bhatta_amount);$i++)
		{
			$bhatta_date[$i] = $cmn->dateformatusa($bhatta_date[$i]);
			if($bhatta_amount[$i] !='')
			{
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$bhatta_amount[$i]',payment_type='cash',
			paymentdate='$bhatta_date[$i]',narration='$bhatta_remark[$i]',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid'");
			}
		}
	}
}


if($hammali_amount !='')
{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='Hamali' && headtype='Truck'");
	if($head_id !='')
	{
		for($i=0; $i<sizeof($hammali_amount);$i++)
		{
			$hammali_date[$i] = $cmn->dateformatusa($hammali_date[$i]);
	if($hammali_amount[$i] !='')
			{
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$hammali_amount[$i]',payment_type='cash',
			paymentdate='$hammali_date[$i]',narration='$hamali_remark[$i]',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid'");
			}
		}
	}
}


if($other_amount !='')
{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='other' && headtype='Truck'");
	if($head_id !='')
	{
		for($i=0; $i<sizeof($other_amount);$i++)
		{
			$other_date[$i] = $cmn->dateformatusa($other_date[$i]);
			if($other_amount[$i] !='')
			{
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$other_amount[$i]',payment_type='cash',
			paymentdate='$other_date[$i]',narration='$other_remark[$i]',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid'");
			}
		}
	}
}


if($tax_amount !='')
{
	$head_id = $cmn->getvalfield($connection,"other_income_expense","head_id","headname='total tax' && headtype='Truck'");
	if($head_id !='')
	{
		for($i=0; $i<sizeof($tax_amount);$i++)
		{
			$tax_date[$i] = $cmn->dateformatusa($tax_date[$i]);
			if($tax_amount[$i] !='')
			{
mysqli_query($connection,"insert into truck_expense set truckid='$truckid',drivername='$drivername',head_id='$head_id',uchantiamount='$tax_amount[$i]',payment_type='cash',
			paymentdate='$tax_date[$i]',narration='$tax_remark[$i]',createdby='$userid',createdate='$createdate',ipaddress='$ipaddress',
			sessionid='$sessionid'");
			}
		}
	}
	
}

}
		$action = 1;
		echo "<script>location='$pagename?action=$action&truckid=$truckid&drivername=$drivername'</script>";
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
							<legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
						      <?php include("../include/page_header.php"); ?>
							</div>
                            
                            <div class="span12">							
                                 <form  method="post" action="" class='form-horizontal'>
                                <div class="control-group">
                                
                                <table class="table table-condensed" width="100%">
                                <tr>
                                    <td width="10%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td>
                                    <td width="15%">
                            <select id="truckid"  class="formcent select2-me" style="width:224px;" <?php if($truckid !='') { ?> readonly <?php } ?> >
                                <option value=""> -Select- </option>
                                <?php 
                                $sql_fdest = mysqli_query($connection,"select A.truckid,truckno,A.ownerid from m_truck as A left join m_truckowner as B on A.ownerid=B.ownerid  
														 order by A.truckno");
                                while($row_fdest = mysqli_fetch_array($sql_fdest))
                                {
                                ?>
                                    <option value="<?php echo $row_fdest['truckid']; ?>"><?php echo $row_fdest['truckno'].' / '.$cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row_fdest[ownerid]'"); ?></option>
                                <?php
                                } ?>
                                </select>
                                <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>';</script>
                                    </td>    
                                    
                                    <td width="10%"><strong>Driver Name</strong> <strong>:</strong><span class="red">*</span></td> 
                                    
                                    <td width="15%">
                            <input list="browsers" value="<?php echo $drivername; ?>" id="drivername" name="drivername" autocomplete="off" class="input-large"  <?php if($drivername !='') { ?> readonly <?php } ?> >
                                     
                                <datalist id="browsers">
                                <?php 
								$sql = mysqli_query($connection,"select drivername from bilty_entry where drivername !='' group by drivername");
								while($row=mysqli_fetch_assoc($sql))
								{
								?>
                                <option value="<?php echo $row['drivername']; ?>">
                               <?php 
								}
							   ?>
                                </datalist>


                                    </td>
                                    <td width="50%">
                               <input type="button" class="btn btn-success" id="search" value="Search" onClick="searchdata();" >     
                                    </td>
                                    
                                                                   
                                 </tr>
                                                                                                    		                                
                                </table>
                       <?php 
					   if($truckid !='')
					   {
					   ?>
                       <br>
     					<br>
		<input type="hidden" name="truckid" value="<?php echo $truckid; ?>" >
                      <table width="89%" class="table table-condensed table-bordered">  
                      			<tr>
                                		<th style="background-color:#00F; color:#FFF; text-align:center;" colspan="3">Bhatta</th>
                                        <th style="background-color:#00F; color:#FFF; text-align:center;" colspan="3">Hamali</th>
                                        <th style="background-color:#00F; color:#FFF; text-align:center;" colspan="3">Other</th>
                                        <th style="background-color:#00F; color:#FFF; text-align:center;" colspan="3">Tax</th>
                                       
                                </tr>     
                              	<tr>
                                		<th width="89" style="width:80px;">Amount</th>
                                        <th width="109" style="width:100px;">Date</th>
                                        <th width="109" style="width:100px;">Remark</th>
                                       <th width="89" style="width:80px;">Amount</th>
                                        <th width="109" style="width:100px;">Date</th>
                                         <th width="109" style="width:100px;">Remark</th> 
                                        <th width="89" style="width:80px;">Amount</th>
                                        <th width="109" style="width:100px;">Date</th>
                                         <th width="109" style="width:100px;">Remark</th> 
                                        <th width="89" style="width:80px;">Amount</th>
                                        <th width="109" style="width:100px;">Date</th>
                                         <th width="109" style="width:100px;">Remark</th> 
                                       
                                </tr> 
                                <?php 
								for($i=0;$i<10;$i++)
								{
								?>
                                  
                <tr>
               			<td><input name="bhatta_amount[]" id="bhatta_amount<?php echo $i; ?>" class="input-small" type="text" style="width:60px;" autocomplete="off"></td>
                        <td><input name="bhatta_date[]" id="bhatta_date<?php echo $i; ?>" class="input-small datemaskk" type="text" style="width:80px;" autocomplete="off" ></td>
                        <td><input name="bhatta_remark[]" id="bhatta_remark<?php echo $i; ?>" class="input-small" type="text" style="width:80px;" autocomplete="off" ></td>
                        
                        <td><input name="hammali_amount[]" id="hammali_amount<?php echo $i; ?>" class="input-small" type="text" style="width:60px" autocomplete="off"></td>
                        <td><input name="hammali_date[]" id="hammali_date<?php echo $i; ?>" class="input-small datemaskk" type="text" style="width:80px" autocomplete="off"></td>
                        <td><input name="hamali_remark[]" id="hamali_remark<?php echo $i; ?>" class="input-small" type="text" style="width:80px;" autocomplete="off" ></td>
                        <td><input name="other_amount[]" id="other_amount<?php echo $i; ?>" class="input-small" type="text" style="width:60px" autocomplete="off"></td>
                        <td><input name="other_date[]" id="other_date<?php echo $i; ?>" class="input-small datemaskk" type="text" style="width:80px" autocomplete="off"></td>
                         <td><input name="other_remark[]" id="other_remark<?php echo $i; ?>" class="input-small" type="text" style="width:80px;" autocomplete="off" ></td>
                        <td><input name="tax_amount[]" id="tax_amount<?php echo $i; ?>" class="input-small" type="text" style="width:60px" autocomplete="off"></td>
                        <td><input name="tax_date[]" id="tax_date<?php echo $i; ?>" class="input-small datemaskk" type="text" style="width:80px" autocomplete="off"></td>
                         <td><input name="tax_remark[]" id="tax_remark<?php echo $i; ?>" class="input-small" type="text" style="width:80px;" autocomplete="off" ></td>
                       
                        
                </tr>   
                                <?php 
								}
								?>
                                <tr>
                        <td colspan="8">
                        <center>
                        <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" >
                        <input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename ; ?>';" />	
                        </center>
                        </td>
                                </tr>
                                
                      </table>                       
                       
                       <?php
					   }
					   ?>
                                
                                
                                
                                 
                                </div>
                                </form>
                                
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
			  location=pagename+'?action=10&truckid=<?php echo $truckid; ?>';
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
