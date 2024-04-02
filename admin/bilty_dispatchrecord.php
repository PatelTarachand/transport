<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_dispatch.php';
$modulename = "Recent Added Billty";
$crit = " where 1=1 ";
if(isset($_REQUEST['consignorid']) && $_REQUEST['consignorid']!="")
{
	$consignorid = addslashes(trim($_REQUEST['consignorid']));
	$crit .= " and consignorid = '$consignorid'";
}
if(isset($_REQUEST['billtydate']) && $_REQUEST['billtydate']!="" && isset($_REQUEST['todate']) && $_REQUEST['todate']!="")
{
	$billtydate = $cmn->dateformatusa($_REQUEST['billtydate']);
	$todate = $cmn->dateformatusa($_REQUEST['todate']);
	$crit .= " and adv_date between '$billtydate' and '$todate' ";
}


if(isset($_GET['consignorid']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
}

if($consignorid !='')
{
	$crit .=" and consignorid='$consignorid' ";	
}


$sel = "select * from bilty_entry $crit order by bilty_id desc";

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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red"></span></h3>
                                <form action="" method="get">
                            <table width="100%" border="0" class="table table-condensed table-bordered">
                      <tr> 
                        <td width="7%" scope="col"><strong>From Date</strong> </td>
                       <td width="15%">
                        <input class="input-medium" type="hidden" name="consignorid" id="consignorid"  value="<?php echo $consignorid; ?>" >
                        
                    <input class="input-medium" type="text" name="billtydate" id="billtydate"  value="<?php echo $cmn->dateformatindia($billtydate); ?>"  data-date="true" required style="border: 1px solid #368ee0" >
                </td>
                
                  <td width="6%" scope="col"><strong>To Date</strong> </td>
                       <td width="15%">
                    <input class="input-medium" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0" >
                </td>
                <td width="10%"> <strong>Consignor</strong> </td>
                <td width="21%">
                			  <select id="CCconsignorid" name="consignorid" class="formcent" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select consignorid,consignorname from m_consignor");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                            <option value="<?php echo $row_fdest['consignorid']; ?>"><?php echo $row_fdest['consignorname']; ?></option>
                        <?php
                        } ?>
                        </select>
                        <script>document.getElementById('CCconsignorid').value = '<?php echo $consignorid; ?>';</script>
                
                </td>
                
                <td width="26%"> <input type="submit" name="submit" class="btn btn-success" id="" value="Search" onClick="return checkinputmaster('billtydate,todate');">
                    <a href="bilty_dispatchrecord.php" class="btn btn-danger">Cancel</a>
                     <a href="bilty_dispatch.php" class="btn btn-success">Back</a></td>
                        
                      </tr>
                      
                    </table>
                    </form>
							</div>
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    <?php
									$slno=1;
									$totaladvcash = 0;
									$totaladv_diesel = 0;
									$totaladv_cheque = 0;
									
									$sel1 = "select * from bilty_entry $crit and (newrate !='0' || dispatch_date !='0000-00-00') order by bilty_id desc";
							$res1 = mysqli_query($connection,$sel1);
									while($row1 = mysqli_fetch_array($res1))
									{
										
										$totaladvcash += $row1['adv_cash'];
										$totaladv_diesel += $row1['adv_diesel'];
										$totaladv_cheque += $row1['adv_cheque'];
										$totaladv_other += $row1['adv_other'];
										$totaladv_consignor += $row1['adv_consignor'];
									}
										?>
                                       
                                       
                                    <tr>
                                          
                                            <th colspan="5"></th>
                                            <th><span style="color:#F00"><strong>Total</strong></span></th>
                                         <th><span style="color:#F00"><strong><?php echo number_format($totaladvcash,2);?></strong> </span></th>
                                         <th><span style="color:#F00"><strong><?php echo number_format($totaladv_diesel,2);?></strong> </span></th>
                                         <th><span style="color:#F00"><strong><?php echo number_format($totaladv_other,2);?></strong> </span></th>
                                            <th><span style="color:#F00"><strong><?php echo number_format($totaladv_consignor,2);?></strong> </span></th>
                                         <th colspan="4"><span style="color:#F00"><strong><?php echo number_format($totaladv_cheque,2);?></strong> </span></th>
										</tr>
										<tr>
                                            <th>Sno</th>  
                                            <th>Bilty No.</th>
                                             <th>Truck No.</th>
                                        	<th>Bilty Date</th>
                                            <th>Consignor</th>
                                            <th>Consignee</th>
                                            <th>Advance Cash</th>
                                            <th>Advance Diesel</th>
                                            <th>Other Advance</th>
                                            <th>Advance(Consignor)</th>
                                            <th>Advance Cheque</th>
                                            <th>Truck Owner</th>
                                        	 <th>Print Recipt</th>
                                            <th class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									//$sel = "select * from bilty_entry where newrate !='0' || dispatch_date !='0000-00-00' order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];										
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['billtyno']);?></td>
                                             <td><?php echo $truckno;?></td>
                                            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
                                            <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignor","consignorname","consignorid = '$row[consignorid]'"));?><span style="color:#FFF;"><?php echo $row['drivername']; ?></span></td>
                                            <td><?php echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?>   <span style="color:#FFF;"><?php echo $truckno; ?></span></td>
                                            <td><?php echo ucfirst($row['adv_cash']);?>  
                                            </td>
                                            <td><?php echo ucfirst($row['adv_diesel']);?></td>
                                            <td><?php echo ucfirst($row['adv_other']);?></td>
                                              <td><?php echo ucfirst($row['adv_consignor']);?></td>
                                            <td><?php echo ucfirst($row['adv_cheque']);?></td>
                                            <td><?php echo ucfirst($row['truckowner']);?></td>
                                              <td>
                                           <a href="pdf_paiddispatchreceipt.php?bilty_id=<?php echo $row['bilty_id'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
                                           
                                           </td>
                                                                                   
                                            <td class='hidden-480'>
                                           <a href= "bilty_dispatch.php?bilty_id=<?php echo ucfirst($row['bilty_id']);?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           
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

jQuery(function($){
   $("#billtydate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
  $("#todate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
});

</script>			
                
		
	</body>

	</html>
