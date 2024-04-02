<?php include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_report.php';
$modulename = "Third Party Payment Report";

if(isset($_GET['thirdid']))
{
	$thirdid=trim(addslashes($_GET['thirdid']));
}
else
$thirdid='';

$crit='1=1';
if($thirdid !='')
{
	 $crit .=" and thirdid='$thirdid' ";
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
    	<legend class="legend_blue"> <i class="icon-edit"></i> <?php echo $modulename; ?></legend>
                            <table width="999">
                                    <tr>
                                          
                                                 <th style="text-align:left;">Third Party </th>
                                              
                                    </tr>
                                    <tr>
                                           
                                          <td>
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
                                         
                     </td> 
                         
                        
                        
                        
                         
                      </tr>
                      <tr>
                      <td></td> <td></td> <td></td>
                                                             
                                            <td width="300px;" colspan="5" > <input type="submit" name="search" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('fromdate,todate'); " >
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
                            
                            	<!--<a class="btn btn-primary btn-lg" href="excel_thirdparty.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>&consignorid=<?php echo $consignorid; ?>" target="_blank" style="float:right;" >  Excel </a>-->
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
									<thead>
                                    
										<tr>
                                            <th>Sno</th>  
                                              <th>Third Party</th>
                                            <th>Di No.</th>
                                            <th>Voucher No.</th> 
                                            <th>Paydate Date</th>
                                          
                                           <th>Print</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
								
					//	echo "select  A.* from bidding_entry as A left join m_truck as B on A.truckid=B.truckid where A.sessionid='$sessionid' and $crit order by bid_id desc ";		
								$sel = "select * from thirdparty_boucher where $crit group by bulkthirdid desc ";	
								//	 $sel = "select * from bidding_entry where $crit  and sessionid='$sessionid' && adv_date!='0000-00-00' order by bid_id desc limit 500 ";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										$voucherno = $row['voucherno'];
											$bulkthirdid = $row['bulkthirdid'];
										$paydate = $row['paydate'];
											$thirdid = $row['thirdid'];
										$di_no=$row['di_no'];
			$third_name = $cmn->getvalfield($connection,"m_third_party","third_name","thirdid='$thirdid'");
								
									?>
										<tr>
                                            <td><?php echo $slno; ?></td>
                                             <td><?php echo $third_name;?></td>
                                            <td><?php echo $row['di_no'];?></td> 
                                             <td><?php echo $row['voucherno'];?></td>                                            
                                             <td><?php echo dateformatindia($paydate);?></td>
                                             <td>
                            
                           
                          <a style=" margin-right: 10%;" href="pdf_thirdparty_payment_report.php?bulkthirdid=<?php echo $bulkthirdid ?>" target="_blank">
                              
                    <button class="btn btn-primary center">Print PDF</button></a>
                          
                          
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
