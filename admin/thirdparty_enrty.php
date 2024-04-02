<?php  
error_reporting(0);
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='thirdparty_enrty.php';
$modulename = "TP Payment";

if(isset($_GET['thirdid']))
{
	$thirdid = trim(addslashes($_GET['thirdid']));	
}
else
$thirdid='';

if(isset($_GET['tppay_status']))
{
	$tppay_status = trim(addslashes($_GET['tppay_status']));	
}
else
$tppay_status='';


$con =" where 1=1";

if($thirdid!=""){
$con .=" and thirdid ='$thirdid'";	
}

if($tppay_status!=""){
$con .=" and tppay_status ='$tppay_status'";	
}
$paydate=date('Y-m-d');
 if($bulkthirdid!=''){
      $payNoIncre=$bulkthirdid;
    }else{
    $payment_vouchar="SELECT * FROM `thirdparty_boucher` ORDER by tboucherid DESC";
     $payres = mysqli_query($connection,$payment_vouchar);
                              $payrow = mysqli_fetch_array($payres);
                              $payNoIncre= $payrow['bulkthirdid']+1;
  
  }
if(isset($_POST['submit'])) {

$arr = $_POST['bid_id'];
foreach( $arr as $row ) {
	if($row!=''){
		
	$sql_update = mysqli_query($connection,"update  bidding_entry set  tppay_status='Paid' where bid_id='$row'"); 
	$di_no = $cmn->getvalfield($connection,"bidding_entry","di_no","bid_id='$row'");
	
                            $toYear=substr(date('Y'),2);
                            $nextYear=$toYear+1;
                             
                                $voucherno='TP'.$toYear.'/'.$nextYear.'/'.str_pad($payNoIncre, 4, '0', STR_PAD_LEFT);
                          
//echo "insert into  thirdparty_boucher set  voucherno='$voucherno',bulkthirdid='$payNoIncre',paydate='$paydate',bid_id='$row',di_no='$di_no',thirdid='$thirdid'";

	$sql_update = mysqli_query($connection,"insert into  thirdparty_boucher set  voucherno='$voucherno',bulkthirdid='$payNoIncre',paydate='$paydate',bid_id='$row',di_no='$di_no',thirdid='$thirdid' "); 
	}
}

echo "<script>location='thirdparty_enrty.php?thirdid=$thirdid&action=2'</script>";
 
			 

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
$(function() {   
	 $('#advchequedate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
	 $('#tppay_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
  });
</script>
</head>

<body data-layout-topbar="fixed">
<div class="messagepop pop" id="div_truck">
<img src="b_drop.png" class="close" onClick="$('#div_truck').toggle(1000);">
<table width="100%" border="0" class="table table-bordered table-condensed">
  <tr><td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Third Party </strong></td></tr>
  <tr><td>&nbsp;<b> Name:</b> </td></tr>
  <tr>
  	<td>
  		<input type="text" name="third_name" id="third_name" style="width:190px;"/>
  	</td>
  </tr>
  <tr><td>&nbsp;<b>Mobile No.:</b> </td></tr>
  <tr><td><input type="text" name="mob1" id="mob1" style="width:190px;"/></td></tr>
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_truckno('third_name','mob1');"/></td></tr>
</table>
</div>
	
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
          
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; <span style="color:#F00"></span>TP Payment</legend>
                 
                
               
                
                 <div class="innerdiv">
                    <div>Third Party Name  <span class="err" style="color:#F00;">*</span> &nbsp;<img src="add.png" id="shortcut_truck" onClick="getShort();"><a href="#" id="add_new" data-form="short_truck" tabindex="49"></a></div>
                    <div class="text">
                          <select id="thirdid" name="thirdid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select thirdid,third_name from m_third_party order by third_name");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['thirdid']; ?>"><?php echo $row_fdest['third_name']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('thirdid').value = '<?php echo $thirdid; ?>';</script> 
                    
                     
                </div>
                </div>
                
                
                
                
                    <div class="innerdiv">
                	<div> &nbsp; &nbsp; </div>
                    <div class="text">
                    <br>
					
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('bid_id'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
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
							<!--	<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  <span class="red">( Only 500 records are shown below for more <a href="#" target="_blank">Click Here</a>)</span></h3>-->
							</div>
                            <?php if($thirdid!='') { ?>
							<form action="" method="post">	
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>Di No.</th>
                                              <th>LR No.</th>
                                            <th>Truck No.</th>                                         
                                           	<th>Consignee</th>
											 <th>Destination</th>
											 <th>Dispatch Date</th>
											 <th>Qty</th>
                                             <th>TP Name</th>
                                            <th>TP Amount</th>
                                            
                                        	<th>Status</th>
                                           
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								
									 $sel = "select * from bidding_entry where thirdid='$thirdid' and tppay_status!='Paid' && sessionid='$sessionid'  order by adv_date desc ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$truckid = $row['truckid'];
											$supplier_id = $row['supplier_id'];
										$itemid = $row['itemid'];
											$thirdid = $row['thirdid'];
										$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
										$paydone=$row['is_complete'];
							
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
		$supplier_name = $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$supplier_id'");
			$third_name = $cmn->getvalfield($connection,"m_third_party","third_name","thirdid='$thirdid'");
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['di_no']);?></td>
                                             <td><?php echo ucfirst($row['lr_no']);?></td>
                                             <td><?php echo $truckno;?></td>
                                             
                                             <td><?php  echo ucfirst($cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid = '$row[consigneeid]'"));?></td>
										 <td><?php echo ucfirst($cmn->getvalfield($connection,"m_place","placename","placeid = '$row[destinationid]'"));?></td>
                                            <td><?php echo dateformatindia($row['adv_date']);?></td>
                                              <td><?php echo $row['noofqty'];?>
                                           <td><?php echo $third_name;?></td>                                          
                                             <td><?php echo $row['adv_other'];?>
                                              <input type="hidden" id="bid_id<?php echo $row['bid_id'];?>" name="bid_id[]" class="formcent" >
                                             </td>
                                             
                                           
                                            <td><select id="tppay_status<?php echo $row['bid_id'];?>" name="tppay_status[]" onChange="getData(<?php echo $row['bid_id'];?>);" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <option value="Paid"> Paid</option>
                        <option value="Pending"> Pending </option>
                        </select> 
                         <script>document.getElementById('tppay_status').value = '<?php echo $tppay_status; ?>';</script> </td>
                                          
                                             
										</tr>
                                        <?php
										$slno++;
								}
									?>
									</tbody>
							</table>
                             
							</div>
                             <center> <input type="submit" name="submit" id="submit" onClick="getSave(<?php echo $row['bid_id'];?>);" value="Save" class="btn btn-primary"
                                        tabindex="4"></center>
                                        
                                        </form>
						<?php } ?>
                        </div>
					</div>
				</div>
            
     </div><!-- class="container-fluid nav-hidden" ends here  -->
                       
<script>
function getShort(){
    $("#shortcut_truck").click(function(){
       // $("#div_truck").toggle(1000);
    });
}
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


function getdetail()
{
	var bid_id = document.getElementById('bid_id').value;
	//alert(bid_id);	
	if(bid_id !='') {
			window.location.href='?bid_id='+bid_id;
		}
}

function getData(bid_id)
{
	var tppay_status  = document.getElementById('tppay_status'+bid_id).value;
	if(tppay_status=='Paid'){
	 document.getElementById("bid_id"+bid_id).value = bid_id;
	}
}


</script>			
                
		
	</body>

	</html>
