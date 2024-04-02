<?php 
include("dbconnect.php");
$tblname = 'otherincome';
$tblpkey = 'otherincomeid';
$pagename  ='truck_income_report.php';
$modulename = "Truck Income Report";

if(isset($_GET['fromdate']) && isset($_GET['todate']))
{
	$fromdate = $cmn->dateformatusa(addslashes(trim($_GET['fromdate'])));
	$todate = $cmn->dateformatusa(addslashes(trim($_GET['todate'])));
}
else
{
	$fromdate = date('Y-m-d');
	$todate = date('Y-m-d');
}

if(isset($_GET['ownerid']))
{
	$ownerid = addslashes(trim($_GET['ownerid']));
}
else
{
	$ownerid='';	
}


$crit = " where 1 = 1 ";
if($fromdate!="" && $todate!="")
{

	$crit .= " and adv_date between '$fromdate' and '$todate'";
}	


if($ownerid !='')
{
	$crit .= " and  ownerid ='$ownerid' ";	
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
    				<fieldset style="margin-top:45px; margin-left:45px;" >                                        
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp; Truck Income Report </legend>
                            <table width="998">
                <tr>
                            <th width="212" style="text-align:left;">Fromdate: <span class="red">*</span></th>
                            <th width="227" style="text-align:left;">Todate : <span class="red">*</span></th>
                            <th width="212" style="text-align:left;">Owner Name  : </th>                 
                </tr>
                <tr>
                            <td><input type="text" name="fromdate" id="fromdate" autocoplete="off" value="<?php echo $cmn->dateformatindia($fromdate); ?>"> </td>
                            <td><input type="text" name="todate" id="todate" autocoplete="off" value="<?php echo $cmn->dateformatindia($todate); ?>"> </td>
                            <td>      <select id="ownerid" name="ownerid" class="formcent select2-me" style="width:224px;">
                            <option value=""> -Select- </option>
                            <?php 
                            $sql_fdest = mysqli_query($connection,"select ownerid,ownername from m_truckowner order by ownername");
                            while($row_fdest = mysqli_fetch_array($sql_fdest))
                            {
                            ?>
                            <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                            <?php
                            } ?>
                            </select>
                            <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>  </td>
                </tr>
                                            
            <tr>  
            				 <td></td>                
                            <td> <input type="submit" name="search" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate'); " >
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
                            
                            	<a class="btn btn-primary btn-lg" href="excel_truck_income_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&head_id=<?php echo $head_id; ?>&truckid=<?php echo $truckid; ?>&payment_type=<?php echo $payment_type; ?>" target="_blank" style="float:right;" >  Excel </a>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
                                            <th>Sno</th>  
                                            <th>Truck No</th> 
                                            <th>Truck Owner Name</th> 
                                            <th>Advance Date</th>                         
                                            <th>Diesel Ltr</th>                                            
                                            <th>Amount</th>  
                                            <th>Remark</th>                                                               
                                        	<th class='hidden-480'>Action</th>                                           
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
									$sel = "select * from other_diesel_adv  $crit order by adv_date desc";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","ownerid='$row[ownerid]'");
										//$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","ownerid='$row[ownerid]'"); 
										//$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'"); 
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                           
                                            <td><?php echo ucfirst($row['truckno']);?></td>
                                             <td><?php echo $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'");  ?></td>
                                             <td><?php echo $cmn->dateformatindia($row['adv_date']);?></td>   
                                           	 <td><?php echo ucfirst($row['diesel_ltr']);?></td>
                                               <td><?php echo ucfirst($row['amount']);?></td>
                                               <td><?php echo $row['remark'];?></td>
                                            <td class='hidden-480'>
                                           <a href= "?othrdieseladv_id=<?php echo ucfirst($row['othrdieseladv_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <a onClick="funDel('<?php echo $row[$tblpkey]; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           </td>
										</tr>
                                        <?php
								$tot_amt += $row['amount'];		
								$tot_ltr += $row['diesel_ltr'];			
										$slno++;
									}
									?>
                                    
                                    <tr>
                                    		<td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_ltr,2); ?></td>
                                                                                        
                                            <td style="background-color:#00C; color:#FFF;"><?php echo number_format($tot_amt,2); ?></td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                            <td style="background-color:#00C; color:#FFF;"> </td>
                                    </tr>
										
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
