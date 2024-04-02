<?php 
include("dbconnect.php");
$tblname = 'returnbidding_entry';
$tblpkey = 'bid_id';
$pagename  ='return_bilty_payment_voucher_report.php';
$modulename = "Payment Voucher";

$cond=" ";

if(isset($_GET['search']))
{
	$fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
	$todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
	
}
else
{
	$todate = date('Y-m-d');
	$fromdate = date('Y-m-d',strtotime('-3 month',strtotime($todate)));
	
}
 
if(isset($_GET['ownerid']))
{
	$ownerid = trim(addslashes($_GET['ownerid']));	
}
else
$ownerid = '';

if(isset($_GET['voucher_id']))
{
	$voucher_id = trim(addslashes($_GET['voucher_id']));	
}
else
$voucher_id = '';



if($fromdate !='' && $todate !='')
{
		$cond.=" and receive_date between '$fromdate' and '$todate' ";	
}

if($ownerid !='') {
	
	$cond .=" and ownerid='$ownerid'";
	
	}
	if($voucher_id !='') {
	
	$cond .=" and voucher_id='$voucher_id'";
	
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
    				<fieldset style="margin-top:45px; margin-left:45px;" >   <!-- <legend class="legend_blue"><a href="dashboard.php"> 
		<img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a></legend> -->                                     
    	<legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> Report </legend>
                            <table width="1037">
                                    <tr>
                                            <th width="15%" style="text-align:left;">From Date : </th>
                                            <th width="15%" style="text-align:left;">To Date : </th>
                                            <th width="15%" style="text-align:left;">Truck Owner :</th>
                                             <th width="15%" style="text-align:left;">Voucher No</th>
                                            
                                         
                                            <th width="30%" style="text-align:left;">Action : </th>
                                    </tr>
                                    <tr>
                                            <td> <input class="formcent" type="text" name="fromdate" id="fromdate"  value="<?php echo $cmn->dateformatindia($fromdate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            <td> <input class="formcent" type="text" name="todate" id="todate"  value="<?php echo $cmn->dateformatindia($todate); ?>"  data-date="true" required style="border: 1px solid #368ee0;width:150px;" autocomplete="off" ></td>
                                            
                                            <td>
                                             <select id="ownerid" name="ownerid" class="select2-me input-large" style="width:220px;">
                            <option value=""> - All - </option>
                            <?php 
                              $sql_fdest = mysqli_query($connection,"select * from m_truckowner");
                              while($row_fdest = mysqli_fetch_array($sql_fdest))
                              {
                              ?>
                            <option value="<?php echo $row_fdest['ownerid']; ?>"><?php echo $row_fdest['ownername']; ?></option>
                            <?php
                              } ?>
                          </select>
                          <script>document.getElementById('ownerid').value = '<?php echo $_GET['ownerid']; ?>';</script>
                        </td>
                                            
                                           	<td>
                                           	      <select id="voucher_id" name="voucher_id" class="select2-me input-large" 
                   onChange="getUrl(this.value);"
                   style="width:220px;" >
			<option value=""> - Select - </option>
			<?php 
			
			$sql_fdest = mysqli_query($connection,"SELECT A.ownerid,B.voucher_id,B.payment_date from m_truck as A left join returnbidding_entry as B on (A.truckid = B.truckid) where A.ownerid='$_GET[ownerid]' && B.compid='$compid' && B.voucher_id!=0 group by B.voucher_id ");
			while($row_fdest = mysqli_fetch_array($sql_fdest))
			{
			
				$payment_vochar = $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row_fdest[voucher_id]' ");
			
			?>
			<option value="<?php echo $row_fdest['voucher_id']; ?>"><?php echo $payment_vochar; ?></option>
			<?php
		}?>
			</select>
			<script>document.getElementById('voucher_id').value = '<?php echo $_GET['voucher_id']; ?>';</script>

                                           	</td>
                                            
                                            
                                            
                                          
                                             <!-- <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>-->
                                            <td> 
                                             <input type="submit" name="search" class="btn btn-success btn-sm" id="Search" value="Search"  onClick="return checkinputmaster('fromdate,todate');" style="width:80px;" >
                                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                                           </td>
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
             <div class="container-fluid">
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
						
							    <div class="box-title">
								<h3><i class="icon-table"></i>Payment Receive by Consignor Details  </h3>
							</div>
								<!--<a class="btn btn-primary btn-lg" href="excel_emami_bilty_advance_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank" 
                                style="float:right;" >  Excel </a> </br>-->
						
                            
                            	
							<div class="box-content nopadding" style="overflow: scroll;">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
										<tr>
											<th>Sno</th>  
											<th>Consignor Name</th>
                                            <th>Voucher No.</th>
											<th>Pay Amount</th>
                                            <th>Payment Receive No</th>
											<th>Pay Date </th>
                                            	<th>Narration </th>
                                                <th>Print </th>
									
											<!-- <th>Print</th> -->
											<!-- <th class='hidden-480'>Action</th> -->
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								//	echo "SELECT * FROM `bilty_payment_voucher` where compid='$compid' $cond order by payid desc";die;
									$sel = "SELECT * FROM `return_bilty_payment_voucher` where compid='$compid' $cond order by payid desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
									$ownername =  $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$row[ownerid]'");	
									$payment_vochar =  $cmn->getvalfield($connection,"return_bulk_payment_vochar","payment_vochar","bulk_voucher_id='$row[voucher_id]'");	
									?>
                        <tr>
                            <td><?php echo $slno; ?></td>
                              <td><?php echo $ownername;?></td> 
                          <td><?php echo $payment_vochar;?></td> 
					         <td><?php echo number_format(round($row['payamount']),2);?></td>
                             <td><?php echo$row['payment_rec_no'];?></td>
                             
                            <td><?php echo dateformatindia($row['receive_date']);?></td>  
                           <td><?php echo$row['narration'];?></td>
                                                  
                            
                            
                          <td><a href="pdf_return_biltypayment_voucher.php?payid=<?php echo $row['payid'];?>" target="_blank" class="btn btn-success">Print Recipt</a>
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
		  url: '../ajax/delete1.php',
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
