<?php  
include("dbconnect.php");
$tblname = 'bidding_entry';
$tblpkey = 'bid_id';
$pagename  ='pump_entry_emami.php';
$modulename = "Pump Entry Emami";
$isuchanti = ""; 
if(isset($_GET['bid_id']))
{
	$bid_id = trim(addslashes($_GET['bid_id']));
	//$crit=" where bid_id='$bid_id'";
	
}
else
$bid_id='';

	$sql = mysqli_query($connection,"select * from bidding_entry where bid_id='$bid_id'");
	$row=mysqli_fetch_assoc($sql);
	$di_no = $row['di_no'];
	$truckid = $row['truckid'];
	$placeid = $row['placeid'];
	$totalweight = $row['totalweight'];
	$own_rate = $row['own_rate'];	
	$newrate = $row['newrate'];
	$adv_date = $row['adv_date'];
		$otheradv_date = $row['otheradv_date'];
	if($adv_date !='') { $adv_date = $cmn->dateformatindia($adv_date); }
		if($otheradv_date !='') { $otheradv_date = $cmn->dateformatindia($otheradv_date); }
	
	$adv_cash = $row['adv_cash'];
	$adv_diesel = $row['adv_diesel'];
	$adv_other =  $row['adv_other'];
	$adv_consignor =  $row['adv_consignor'];
	$adv_cheque = $row['adv_cheque'];
	$cheque_no = $row['cheque_no'];
	$bankid = $row['bankid'];
	$consignorid= $row['consignorid'];
	$destinationid = $row['destinationid'];
	$itemid = $row['itemid'];
	
	$advchequedate = $row['advchequedate'];
	if($advchequedate !='') { $advchequedate = $cmn->dateformatindia($advchequedate); }
	$adv_dieselltr = $row['adv_dieselltr']; 
	$supplier_id = $row['supplier_id']; 
	
	$ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$fromplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$placeid'");
	$toplace = $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
	$truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
	
	//$charrate = $own_rate - $newrate;
	//$netamount = $newrate * $wt_mt;
	//$balamt = $netamount - $adv_cash - $adv_diesel - $adv_cheque -$adv_other;
	
	if($newrate==0){ $newrate=''; }
	if($adv_cash==0){ $adv_cash=''; }
	if($adv_diesel==0){ $adv_diesel=''; }
	if($adv_cheque==0){ $adv_cheque=''; }
	
	if($adv_date=='0000-00-00' || $adv_date=='')
	{
			$adv_date = date('d-m-Y');
	}
	
		if($otheradv_date=='0000-00-00' || $otheradv_date=='')
	{
			$otheradv_date = date('d-m-Y');
	}




if(isset($_POST['sub']))
{

	//$own_rate = trim(addslashes($_POST['own_rate']));
	
	$adv_date = $cmn->dateformatusa(trim(addslashes($_POST['adv_date'])));
	$lr_no = trim(addslashes($_POST['lr_no']));
	$amount_diesel = trim(addslashes($_POST['amount_diesel']));	
	$supplier_id = isset($_POST['supplier_id'])?trim(addslashes($_POST['supplier_id'])):''; 
	
	
		 $sql_update = "Insert  pump_entery  set lr_no = '$lr_no',date='$adv_date',amount='$amount_diesel',pump_id='$supplier_id', consignorid=4 "; 
			mysqli_query($connection,$sql_update);
			
			echo "<script>location='$pagename?action=2'</script>";
	
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
	 $('#adv_date').datepicker({ dateFormat: 'dd-mm-yy' }).val();
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
                   <form method="post" action="">
                   
                    
    				<fieldset style="margin-top:45px; margin-left:45px;" >
            <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend>                            
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; <span style="color:#F00"></span><?php echo $modulename; ?> </legend>
                 
                   <?php //echo $bid_id; ?>
                
               
               
            
               
                
                <div class="innerdiv">
                    <div> LR No. </div>
                    <div class="text">
                    <input type="text" class="formcent" name="lr_no" id="lr_no" 
                    
                     onChange="getbal();"  style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>
            
               <div class="innerdiv">
                    <div>Date </div>
                    <div class="text">
                    <input type="text" class="formcent" name="adv_date" id="adv_date" value="<?php echo $adv_date; ?>" required style="border: 1px solid #368ee0"  autocomplete="off"  >
                    </div>
                </div>

               <div class="innerdiv">
                    <div> Diesel  Amount</div>
                    <div class="text">
                     <input type="text" class="formcent" name="amount_diesel" id="amount_diesel"  onChange="getbal();"   style="border: 1px solid #368ee0"  autocomplete="off"  >
                </div>
                </div>
                
           
                
                <div class="innerdiv">
                    <div> Petrol Pump </div>
                    <div class="text">
                    		
                    <select id="supplier_id" name="supplier_id" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
                        <?php 
                        $sql_fdest = mysqli_query($connection,"select supplier_id,supplier_name from inv_m_supplier order by supplier_name");
                        while($row_fdest = mysqli_fetch_array($sql_fdest))
                        {
                        ?>
                        <option value="<?php echo $row_fdest['supplier_id']; ?>"><?php echo $row_fdest['supplier_name']; ?></option>
                        <?php
                        } ?>
                    </select>
                    <script>document.getElementById('supplier_id').value = '<?php echo $supplier_id; ?>';</script>                                  
                </div>
               </div>
               </br>
               </br>  
            
      
				 <div class="innerdiv">
           <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Save"  onClick="return checkinputmaster('bid_id'); " >
                    <a href="<?php echo $pagename; ?>" class="btn btn-danger">Cancel</a>
                    </div>
                    </div>
               
    				</fieldset>
                    
    		        <input type="hidden" name="bilty_id" id="bilty_id" data-key="primary" value="<?php echo $bilty_id; ?>">
                   
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
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details </h3>
							</div>
								
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                            <th>LR No.</th>
										                      	<th>Date </th>
                                             <th>Diesal Amount</th>
                                            <th>Pump Name</th>
                                            
                                        	<th>Print Recipt</th>
                                           <!--  <th class='hidden-480'>Action</th> -->
										</tr>
									</thead>
                                    <tbody>
                                    <?php

              


									$slno=1;
									 $sel = "SELECT * FROM `pump_entery` where  consignorid=4  order by id desc limit 500";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
                   
                   $pump_id=$row['pump_id'];
	$Pump_name = $cmn->getvalfield($connection,"inv_m_supplier","supplier_name","supplier_id='$pump_id'");
	$ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
	$itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
								
									?>
										<tr tabindex="<?php echo $slno; ?>" class="abc">
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo ucfirst($row['lr_no']);?></td>
											 <td><?php echo $cmn->dateformatindia(ucfirst($row['date']));?></td>
                                            <td><?php echo ucfirst($row['amount']);?></td>
                                             <td><?php echo $Pump_name; ?></td>
                                           
                                            <td class='hidden-480'>

                                             <a href="#" target="_blank" class="btn btn-success">Print Recipt</a>   
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


function getdetail()
{
	var bid_id = document.getElementById('bid_id').value;
	//alert(bid_id);	
	if(bid_id !='') {
			window.location.href='?bid_id='+bid_id;
		}
}

function editrecord(bid_id) {

  $.ajax({
      type: 'POST',
      url: 'getotp.php',
      data: 'bid_id=' + bid_id,
      dataType: 'html',
      success: function(data){
        //console.log(data);
        //alert(data);
         $('#otpmodel').modal('show');
         $("#otp_bid_id").val(bid_id);
         $("#otp").val(data);
      }
    
      });//ajax close  
}


function matchotp() {

  bid_id = $("#otp_bid_id").val();
  otp = $("#otp").val();

   $.ajax({
      type: 'POST',
      url: 'matchotp.php',
      data: 'bid_id=' + bid_id+'&otp='+otp,
      dataType: 'html',
      success: function(data){
//alert(data);
            if(data==1) 
            {
                location.href="bilty_dispatch_emami.php?bid_id="+bid_id;
            }
            else
            {
              alert("Otp didnt match");
            }
        }
    
    });//ajax close  

}
</script>


<?php include("otpmodel.php"); ?>			
                
		
	</body>

	</html>
