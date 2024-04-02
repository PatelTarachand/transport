<?php error_reporting(0);
include("dbconnect.php");
$tblname = "truck_installation_payment";
$tblpkey = "t_install_pay_id";
$pagename = "truck_installation_payment.php";
$modulename = "Truck Installment Payment";


if($_GET['fromdate']!="" && $_GET['todate']!="")
{
	$fromdate = $cmn->dateformatusa(addslashes(trim($_GET['fromdate'])));
	$todate = $cmn->dateformatusa(addslashes(trim($_GET['todate'])));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['head_id']))
{
	$head_id = addslashes(trim($_GET['head_id']));
}

if(isset($_GET['payment_type']))
{
	$payment_type = addslashes(trim($_GET['payment_type']));
}

if(isset($_GET['truckid']))
{
	$truckid = addslashes(trim($_GET['truckid']));
}

if(isset($_GET['ownername']))
{
	$ownername = addslashes(trim($_GET['ownername']));
}

$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

$crit .= " and payment_date between '$fromdate' and '$todate'";
}	


if($head_id !='')
{
	$crit .= " and  head_id ='$head_id' ";
	
}

if($payment_type !='')
{
	$crit .= " and  payment_type ='$payment_type' ";
	
}
if($truckid !='')
{
	$crit .= " and  truckid ='$truckid' ";
	
}

if($ownername!='')
{
	$crit .= " and  ownername ='$ownername' ";
	
}
?>
<!doctype html>
<html>
<head>
	<?php include("../include/top_files.php"); ?>
<style>
.form-actions { text-align:center; }
#save {background:#2c9e2e; font-weight:100; font-size:16px; border: 1px solid #2c9e2e;}
#clear {background:#8a6d3b; font-weight:100; font-size:16px; border: 1px solid #8a6d3b; margin-left:15px;}
.alert-success {
	color: #31708f;
background-color: #d9edf7;
border-color: #bce8f1; }
.innerdiv
{
float:left;
width:390px;
margin-left:8px;
padding:6px;
height:25px;
/*border:1px solid #333;*/
}

.innerdiv > div { float:left;
     margin:5px;
	 width:140px;
}
.text {margin:5px 0 0 8px;

}
.col-sm-2 { width:100%;
           height:43px;
}
.navbar-nav { position:relative;
             width:100%;
			 background:#368ee0;
			 color:#FFF;
			 height:35px;
			 }
			 
.navbar-nav > li {
	       font-size:14px;
		   color:#FFF;
		   padding-left:10px;
		   padding-top:7px;
		   width:105px;
}
.btn.btn-primary {width:80px;
           
}
.formcent { margin-top:6px;
border:1px solid #368ee0;
}
.text1 {margin:5px 0 0 8px;
}
</style>
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
$(document).ready(function(){
	$("#shortcut_consigneeid").click(function(){
		$("#div_consigneeid").toggle(1000);
	});
	});
	$(document).ready(function(){
	$("#short_place").click(function(){
		$("#div_placeid").toggle(1000);
	});
	});

</script>
</head>

<body data-layout-topbar="fixed">

<?php include("../include/top_menu.php"); ?> <!--- top Menu----->
	<div class="container-fluid nav-hidden" id="content">
		<div id="main">
			  <div class="container-fluid">
					<div class="row">
					<div class="col-sm-12">
                    	<div class="box">
                        	<div class="box-content nopadding">
                   <form method="get" action="">
    				<fieldset style="margin-top:45px; margin-left:45px;" >          <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                              
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; Truck Installation Payment Report </legend>
                            <table width="998">
                                    <tr>
                                            <th width="212" style="text-align:left;">Fromdate: <span class="red">*</span></th>
                                            <th width="227" style="text-align:left;">Todate : <span class="red">*</span></th>
                                            <th width="212" style="text-align:left;">Head  : </th>                                           
                                            
                                    </tr>
                                    <tr>
                                            <td><input type="text" name="fromdate" id="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" autocoplete="off">
                                                                       
                                            </td>
                                            <td><input type="text" name="todate" id="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" autocoplete="off">
                                                
                                                    
                                            </td>
                                            <td>  
                                                   <select name="head_id"  class="input-large select2-me"  id="head_id">
                                        <option value="">-Select-</option>
                                        <?php
					$sql_cat = mysqli_query($connection,"Select head_id,headname from  other_income_expense where headtype='Truck' && head_id=6 order by headname desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['head_id']; ?>" > <?php echo $res_cat['headname']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>
                                                <script>document.getElementById('head_id').value = "<?php echo $head_id; ?>";</script>
                                            </td>
                                            </tr>
                                            <tr>  
                                             <th width="212" style="text-align:left;">Truck no </th> 
                                             <th width="212" style="text-align:left;">Owner Name</th>
                                             <th width="212" style="text-align:left;">Payment Type : </th>    
                                             </tr>
                                             <tr>
                                               <td>  
                                            
                                                    <select name="truckid"  class="input-large select2-me"  id="truckid" >
                                        <option value="">-Select-</option>
                                        <?php
													$sql_cat = mysqli_query($connection,"Select A.truckid,A.truckno from  m_truck as A left join  m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by A.truckid desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['truckid']; ?>" > <?php echo $res_cat['truckno']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>
                                                    <script>document.getElementById('truckid').value='<?php echo $truckid; ?>';</script>
                                             </td>
                                             <td><select name="ownerid"  class="input-large select2-me"  id="ownerid">
                                        <option value="">-Select-</option>
                                        <?php
					$sql_cat = mysqli_query($connection,"Select A.ownerid,B.ownername from  m_truck as A left join  m_truckowner as B on A.ownerid=B.ownerid where B.owner_type='self' order by A.ownerid desc");
													if($sql_cat)
													{
														while($res_cat = mysqli_fetch_array($sql_cat))
														{
															?>
                                        <option value="<?php echo $res_cat['ownerid']; ?>" > <?php echo $res_cat['ownername']; ?></option>
                                        <?php
                                                        }
													}
													?>
                                      </select>
                                      <script>document.getElementById('ownerid').value='<?php echo $ownerid; ?>';</script>
                                                    
                                             </td>
                                              <td>
                                    <select name="payment_type"  class="input-large select2-me"  id="payment_type" onChange="settype();" >
                                        <option value="">-Select-</option>
                                      	<option value="Cash">Cash</option>
                                        <option value="Credit">Credit</option>
                                        <option value="Cheque">Cheque</option>		
                                      </select>
                                    <script>document.getElementById('payment_type').value = '<?php echo $payment_type ; ?>'; </script> </td></tr>                      
                                            <td> <input type="submit" name="search" class="btn btn-success" id="search" value="Search"  onClick="return checkinputmaster('fromdate,todate'); " >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger">Reset</a></td>
                                    </tr>
                            </table>    				
                    </fieldset>    		       
                    </form>
         </div>
        </div>
                	</div>  <!--rowends here -->
                    </div>    <!--com sm 12 ends here -->
                    
                <!--rowends here -->  
    
            </div><!--class="container-fluid"  ends here -->
            </div>  <!--  main ends here-->
            
            
            <!--   DTata tables -->
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-title">
								
							</div>
                            
                            	<a class="btn btn-primary btn-lg" href="excel_truck_installation_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&head_id=<?php echo $head_id; ?>&truckid=<?php echo $truckid; ?>&ownerid=<?php echo $ownerid; ?>&payment_type=<?php echo $payment_type; ?>" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                             <th>Sno</th>  
                                            <th>Head</th> 
                                            <th>Truck No </th>
                                             <th>Owner Name</th> 
                                        	<th>Amount</th>                                            
                                            <th>Payment Type</th> 
                                            <th>Payment Date</th> 
                                             
                                        </tr>
									</thead>
                                    <tbody>
                                      <?php
									
									if($usertype=='admin')
									{
									$cond="";
									}
									else
									{
									$cond=" && createdby='$userid' && sessionid='$sessionid'";	
									}
									
									$slno=1;
								
									$sel = "select * from truck_installation_payment $crit $cond";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'");
										$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$row[truckid]'");
										$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"other_income_expense","headname","head_id='$row[head_id]'"); ?></td>
                                            <td><?php echo $truckno; ?></td>
                                            <td><?php echo $ownername;?></td>
                                            <td><?php echo $row['paid_amt'];?></td>
                                            <td><?php echo $row['payment_type'];?></td>
                                            <td><?php echo $cmn->dateformatindia($row['payment_date']); ?></td>
                                            <!--<td class='hidden-480'>
                                            <a href= "?edit=<?php echo ucfirst($row['t_install_pay_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <a onClick="funDel('<?php echo $row['t_install_pay_id']; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                            </td>-->
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
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
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


//below code for date mask
jQuery(function($){
   $("#fromdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

jQuery(function($){
   $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

</script>			
                
		
	</body>

	</html>