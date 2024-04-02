<?php 
include("dbconnect.php");
$tblname = 'bilty_entry';
$tblpkey = 'bilty_id';
$pagename  ='bilty_receiving.php';
$modulename = "Billty Receiving Report";

if(isset($_GET['sub']))
{
	$consignorid = trim(addslashes($_GET['consignorid']));	
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
border-color: #bce8f1;
}
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
					
					
    	<legend class="legend_blue"><i class="icon-edit"></i>&nbsp; <?php echo $modulename; ?></legend>
                 
             <div class="innerdiv">
                    <div> Consignor <span class="err" style="color:#F00;">*</span></div>
                    <div class="text">
                    		
                    <select id="consignorid" name="consignorid" class="formcent select2-me" style="width:220px;">
                        <option value=""> - Select - </option>
				<?php 
                $sql_fdest = mysqli_query($connection,"select consignorid,consignorname from m_consignor where enable='enable' order by consignorname");
                while($row_fdest = mysqli_fetch_array($sql_fdest))
                {
                ?>
                <option value="<?php echo $row_fdest['consignorid']; ?>"><?php echo $row_fdest['consignorname']; ?></option>
                <?php
                } ?>
            </select>
            <script>document.getElementById('consignorid').value = '<?php echo $consignorid; ?>';</script>                                  
                </div>
               </div>
               
               <div class="innerdiv">
                    <div class="text">
                    <input type="submit" name="sub" class="btn btn-success" id="" value="Search"  onClick="return checkinputmaster('consignorid'); " >
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
            
            <?php if($consignorid !='') { ?>
            <!--   DTata tables -->
            
                <div class="row-fluid">
					<div class="span12">
						<div class="box box-bordered">
							<div class="box-content nopadding">
                           
                 			<table align="center" width="95%">
                            	<tr><td width="10%">Search Billty No.</td><td width="21%"> <input type="text" name="searchbillty" id="searchbillty" value="" placeholder="Search Billty No."></td>
                                <td width="12%">Search Vehicle No.</td><td width="22%"><input type="text" name="searchtruck" id="searchtruck" value="" placeholder="Search vehicle No."></td>
                                <td width="12%">Search Owner Name</td><td width="23%"><input type="text" name="ownername" id="ownername" value="" placeholder="Search Owner Name"  onkeyup="myFunction();" ></td>
                                </tr>
                               
                            </table>
                            
                            
								<table class="table table-hover table-bordered" id="myTable">
									<thead>
										<tr>
                                            <th width="4%">Sno</th>  
                                            <th width="6%">Bilty No.</th>
                                            <th width="7%">Bilty Date</th>
                                            <th width="7%">Truck No</th>
                                            <th width="10%">Owner</th>
                                            <th width="10%">Des. Wt.</th>
                                            <th width="12%">Rec. Wt.</th>
                                            <th width="12%">Unloading Place</th>
                                          <th width="10%">Destination Address</th>
                                            <th width="12%">Recd. Dt.</th>
                                            <th width="12%">Shortage(Bags)</th>  
                                            <th width="8%"> Action</th>                                       
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									if($usertype=='admin')
									{
									$crit="";
									}
									else
									{
									$crit=" && createdby='$userid'";	
									}	
					$sel = "select bilty_id,billtyno,billtydate,truckid,truckowner,wt_mt,recd_wt,recd_date,shortagewt,unloading_place,destinationid
			 from bilty_entry where is_complete ='0' && wt_mt !='0' && consignorid='$consignorid' $crit order by bilty_id desc";
							$res = mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{		
									if($row['recd_wt']==0)
									{
										$row['recd_wt']=$row['wt_mt'];
									}
									
									$destinationid=$row['destinationid'];
									?>
                    <tr  class="data-content" data-val = "<?php echo ucfirst($row['billtyno']);?>" 
                                            data-vehicle = "<?php echo ucfirst($cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row[truckid]'"));?>" >
                            <td><?php echo $slno; ?></td>
                            <td><?php echo ucfirst($row['billtyno']);?></td>
                            <td><?php echo $cmn->dateformatindia($row['billtydate']);?></td>
                            <td><?php  echo strtoupper($cmn->getvalfield($connection,"m_truck","truckno","truckid='$row[truckid]'"));?></td>
                            <td><?php echo strtoupper($row['truckowner']);?></td>
                            <td><?php echo ucfirst($row['wt_mt']);?>
                            <input type="hidden" class="formcent" value="<?php echo $row['wt_mt'];?>" id="wt_mt<?php echo $row['bilty_id']; ?>"  style="border: 1px solid #368ee0;"  autocomplete="off"  >
                            </td>
                            <td>
							 <input type="text" class="formcent" value="<?php echo $row['recd_wt'];?>" id="recd_wt<?php echo $row['bilty_id']; ?>"  style="border: 1px solid #368ee0;width:140px;"  autocomplete="off" >
                            </td>
                            <td><?php echo  $cmn->getvalfield($connection,"m_place","placename","placeid='$destinationid'"); ?></td>
                            <td>
							 <input type="text" class="formcent" value="<?php echo $row['unloading_place'];?>" id="unloading_place<?php echo $row['bilty_id']; ?>"  style="border: 1px solid #368ee0;width:140px;"  autocomplete="off" >
                            </td>
                            <td>
							 <input type="text" class="formcent recvddate" value="<?php echo $cmn->dateformatindia($row['recd_date']);?>" id="recd_date<?php echo $row['bilty_id']; ?>"  style="border: 1px solid #368ee0;width:140px;"  autocomplete="off" > <span id="msg<?php echo $row['bilty_id']; ?>" style="color:#F00;" ></span>
							</td>
                           <td><input type="text" value="<?php echo $row['shortagewt'];?>" id="shortagewt<?php echo $row['bilty_id']; ?>"  style="border: 1px solid #368ee0;background-color:#6CF;width:140px;"  autocomplete="off"  readonly > </td>
                           <td>
                           <input type="button" class="btn btn-sm btn-success" value="Save" onClick="getcalcwt(<?php echo $row['bilty_id']; ?>);" >
                           
                           
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
                
            <?php } ?>
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
   $(".recvddate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

function getcalcwt(bilty_id)
{
	var wt_mt = document.getElementById("wt_mt"+bilty_id).value;
	var recd_wt = document.getElementById("recd_wt"+bilty_id).value;
	var shortagewt = document.getElementById("shortagewt"+bilty_id).value;
	
	if(isNaN(wt_mt))
	{
		wt_mt = 0;	
	}
	
	if(isNaN(recd_wt))
	{
		recd_wt = 0;	
	}
	
	if(isNaN(shortagewt))
	{
		shortagewt = 0;	
	}
	
	if(recd_wt !='0')
	{
		if(wt_mt >= recd_wt)
		{
		var shortg = wt_mt - recd_wt;		
		document.getElementById('shortagewt'+bilty_id).value= shortg.toFixed(2);
		savereceived(bilty_id)
		}
		else
		{
			alert("Recevd Weight Cant Be Greater");
			document.getElementById("recd_wt"+bilty_id).value='';
			return false;
		}
	}
	else if(shortagewt !='0')
	{
		if(wt_mt >= shortagewt)
		{
			var recvd = wt_mt - shortagewt;		
		
	//	$('#msg1846').html('Saved');
		savereceived(bilty_id)
		}
		else
		{
				alert("Shortage Weight Cant Be Greater");
				return false;
		}
	}		
}

function savereceived(bilty_id)
{
	var wt_mt = document.getElementById("wt_mt"+bilty_id).value;
	var recd_wt = document.getElementById("recd_wt"+bilty_id).value;
	var shortagewt = document.getElementById("shortagewt"+bilty_id).value; 
	var recd_date = document.getElementById("recd_date"+bilty_id).value;
	var unloading_place = document.getElementById("unloading_place"+bilty_id).value;
	$.ajax({
		  type: 'POST',
		  url: 'savereceive.php',
		  data: 'bilty_id='+bilty_id+'&recd_wt='+recd_wt+'&shortagewt='+shortagewt+'&recd_date='+recd_date+'&unloading_place='+unloading_place,
		  dataType: 'html',
		  success: function(data){
					if(data==1)
					{
						$('#msg'+bilty_id).html("Saved");	
					}
			}
		
		  });//ajax close	
}


$("#searchbillty").keyup(function()
	{
		 var input, filter, table, tr, td, i;
  input = document.getElementById("searchbillty");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
		
	});
	
	$("#searchtruck").keyup(function()
	{
		 var input, filter, table, tr, td, i;
  input = document.getElementById("searchtruck");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }

	});
	
	
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("ownername");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[4];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

	
</script>			
                
		
	</body>

	</html>
