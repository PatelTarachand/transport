<?php
include("dbconnect.php");
$tblname = "tyre_map";
$tblpkey = "mapid";
$pagename = "tyre_truck_maping.php";
$modulename = "Truck-Tyre-Mapping";


if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;





if(isset($_GET['search']))
{
	$truckid = addslashes(trim($_GET['truckid']));
	$typeid = $cmn->getvalfield($connection,"m_truck","typeid","truckid = '$truckid'");
	$noofwheels = $cmn->getvalfield($connection,"m_trucktype","noofwheels","typeid = '$typeid'");
	$typeimg = $cmn->getvalfield($connection,"m_trucktype","typeimg","typeid = '$typeid'");
}



if(isset($_POST['submit']))
{
	$truckid=$_POST['truckid'];
	$typos=$_POST['typos'];
	$tid=$_POST['tid'];
	$uploaddate=$_POST['uploaddate'];
	$meterreading=$_POST['meterreading'];
	
	//echo "<pre>";
	//print_r($_POST);
	//echo "</pre>";
	
	for($i=0;$i<sizeof($typos);$i++)
	{
		$udate=$cmn->dateformatdb($uploaddate[$i]);
		// check blank
		if($tid[$i]!="" && $udate!="") // meterreading not required
		{
			$sql_2="SELECT * FROM tyre_map where truckid='$truckid'  and typos='$typos[$i]' and downdate = '0000-00-00' ";
			$data_2=mysqli_query($connection,$sql_2);
			//echo mysqli_num_rows($data_2);die;
			if(mysqli_num_rows($data_2)>0)
			{
				
				$row_2=mysqli_fetch_assoc($data_2);
				$ids=$row_2['mapid'];
				
			
				// update if exists in table tyre_map
				$ss="UPDATE tyre_map SET tid='$tid[$i]', uploaddate='$udate', meterreading='$meterreading[$i]', lastupdated=now() where  truckid='$truckid'  and downdate = '0000-00-00' and typos='$typos[$i]'";
				mysqli_query($connection,$ss);
				
				
			}
			else
			{				
				// insert if not exist in table tyre_map
				$sql_3="INSERT INTO tyre_map (tid, truckid, typos, uploaddate, meterreading, createdate, lastupdated,sessionid) VALUES ('".$tid[$i]."', '$truckid', '".$typos[$i]."', '".$udate."', '".$meterreading[$i]."', now(), now(),'".$_SESSION['sessionid']."')";//die;
				mysqli_query($connection,$sql_3);
				
				
			}
			//echo "<br>";
		}
	}
	//die;
}


?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>
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

.rempop {
  background-color:#CDFEFE;
  border:2px solid #000;
  cursor:default;
  display:none;
  border-radius:5px;
  position:fixed;
  top:20%;
  right:40%;
  text-align:left;
  width:330px;
  z-index:50;

}

.rempop p, .rempop.div {
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
	
	</script>
</head>

<body>


<!--- short cut form removal --->
<div class="rempop pop" id="div_remove">
<img src="b_drop.png" class="close"  onClick="$('#div_remove').fadeToggle( 'slow', 'linear' ); $('#content').stop().fadeTo('slow',1);">
<table width="100%" border="0" class="table  table-condensed">
  <tr><td colspan="2"><strong style="font-size:14px;color:#F00;">&nbsp;Tyre Removal </strong></td></tr>
  <tr>
  	<td colspan="2"><b>Tyre No. : </b><span id="tnumber_hid"></span></td>
  </tr>
  <tr>
  	<td colspan="2"><b>Location : </b><span id="location_hid"></span>
    <input type="hidden" name="mapid_hid" id="mapid_hid" value=""></td>
  </tr>
  <tr>
  <td><b>Date</b>:</td>
  <td><input type="text" name="downdate" id="downdate" style="width:90px;" value="<?php echo date('d-m-Y'); ?>" placeholder="Removal Date"/></td></tr>
  <tr>
  <td><strong>Description:</strong></td><td><textarea name="description" id="description" placeholder="Enter Removal Description"></textarea></td>
  </tr>
  <tr>
  	<td><strong>Remarks</strong>:</td>
    <td>
  		<select name="remarks" id="remarks" class="select2-me" style="width:150px;" onChange="set_remark(this.value);">
        <option value="">--select--</option>
       	<option value="1">Remold</option>
        <option value="2">Scrap</option>
        <option value="3">Resale</option>
        <option value="0">Other</option>
        </select>
       
  	</td>
  </tr>
  <tr  id="r_name" style="display:none">
  <td><strong>Resale To:</strong></td>
  <td><input type="text" name="resale_to" id="resale_to" placeholder="Enter Name"></td>
  </tr>
  <tr id="r_amt" style="display:none">
  <td><strong>Resale Amt:</strong></td>
  <td><input type="text" name="resale_amt" id="resale_amt" placeholder="Enter Amt"></td>
  </tr>
  <tr  id="r_desc" style="display:none">
  <td><strong>Resale Description:</strong></td>
  <td><textarea name="resale_description" id="resale_description" placeholder="Enter Resale Description"></textarea></td>
  </tr>
  
  <tr><td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_removal();"/></td></tr>
</table>
 <script>
		function set_remark(remarks)
		{
			if(remarks == '3')
			{
				$("#r_name").show();
				$("#r_amt").show();
				$("#r_desc").show();
			}
			else
			{
				$("#resale_to").val("");
				$("#resale_amt").val("");
				$("#resale_description").val("");
				
				$("#r_name").hide();
				$("#r_amt").hide();
				$("#r_desc").hide();
			}
		}
		</script>
</div>
<!------removal end here ---->
		 <?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
             <?php //include("../include/showbutton.php"); ?>
			  <!--  Basics Forms -->
			  <div class="row-fluid" >
					<div class="span12">
						<div class="box">
							<div class="box-title">
                            <?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
							</div>
							<div class="control-group"><br/>
                            <form action="" method="get">
                            <table width="40%" border="0">
                              <tr>
                                <td width="19%"><strong>Truck No</strong> <strong>:</strong><span class="red">*</span></td>
                                <td width="34%"><select id="truckid" name="truckid" class="input-medium select2-me">
                                        <option value="">-Select-</option>
                                        <?php 
                                        $sql_t = mysqli_query($connection,"Select truckid,truckno from m_truck where ownerid IN (SELECT ownerid FROM m_company group by ownerid)");
                                        if($sql_t)
                                        {
                                            while($row_t = mysqli_fetch_assoc($sql_t))
                                            {?>
                                            <option value="<?php echo $row_t['truckid']; ?>"><?php echo ucfirst($row_t['truckno']); ?></option>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <script>document.getElementById('truckid').value = '<?php echo $truckid; ?>' ;</script>
                                    </td>
                                <td width="47%"> <input type="submit" name="search" id="search" value="Search" class="btn btn-primary"
                                                                 onClick="return checkinputmaster('truckid')">
                                </td>
                              </tr>
                            </table>
                            <?php include("../include/page_header.php"); ?>
                            </form>

						<?php
						if(isset($_GET['truckid']))
						{?>
                       
                      
                            <hr/>
                            <fieldset style="border:0px solid #000; width:18%; height:400px; float:left">
                            <center><img src="../images/<?php echo $typeimg; ?>" /></center>
                            </fieldset>
                             <form action="" method="post">
                              
                            <fieldset style=" width:78%; min-height:400px; float:left ; margin-left:20px;">
                             <input type="hidden" name="truckid" id="truckid" value="<?php echo $truckid; ?>">
                              <table width="100%" border="1">
                              <tr bgcolor="#CCCCCC">
                                <th width="9%" scope="col"><strong>Location No</strong></th>
                                <th width="22%" scope="col"><strong>Tyre No</strong></th>
                                <th width="12%" scope="col"><strong>Upload Date</strong></th>
                                <th width="16%" scope="col"><strong>Meter Reading</strong></th>
                                <th width="17%" scope="col"><strong>Description</strong></th>
                                <th width="11%" scope="col"><strong>Total Km</strong></th>
                                <th width="13%" scope="col"><strong>Action</strong></th>
                              </tr>
                              <?php	
							  for($i = 1;$i<=$noofwheels ; $i++)
							  {
								$mpid="";
								$tid="";
								$desc="";
								$uploaddate="";
								$mtrd="";
							//	echo "SELECT * FROM tyre_map where truckid='$truckid' and typos='$i' and downdate = '0000-00-00'<br>"; 
								$data_fetch=mysqli_query($connection,"SELECT * FROM tyre_map where truckid='$truckid' and typos='$i' and downdate = '0000-00-00'");
								$rowcount = mysqli_num_rows($data_fetch);
								
								$row_fetch=mysqli_fetch_array($data_fetch);
								$mpid=$row_fetch['mapid'];
								$tid=$row_fetch['tid'];
								$desc= $cmn->getvalfield($connection,"tyre_purchase","tdescription","tid = '$tid'");
								$uploaddate=$cmn->dateformatindia($row_fetch['uploaddate']);
								$mtrd=$row_fetch['meterreading'];
								$tyre_id = $tid.",".$tyre_id;
								
							  ?>
                             
                              <tr>
                                <td align="center"><strong><?php echo $i; ?></strong>  <input type="hidden" name="typos[]" id="typos<?php echo $i; ?>" value="<?php echo $i; ?>"></td>
                                <td align="center">
                                <?php $check = $cmn->getvalfield($connection,"tyre_map","count(*)","truckid='$truckid' and typos='$i' and downdate = '0000-00-00'"); 
								
								if($check !=0) {
									?>
                                    
                                    <select name="tid[]" id="tid<?php echo $i; ?>" class="input-medium select2-me" onChange="return getdescription(this.value,<?php echo $i; ?>);" >
                                    	<option value="">-Select-</option>
                                        <?php	
										$sql_tyre = mysqli_query($connection,"select tid,tnumber from tyre_purchase where remarks = 0 and tid not in (SELECT tid from tyre_map where truckid<>'$truckid' and  downdate = '0000-00-00')");
										if($sql_tyre)
										{
											while($row_tyre = mysqli_fetch_assoc($sql_tyre))
											{												
										?>
                                        <option value="<?php echo $row_tyre['tid']; ?>"><strong><?php echo $row_tyre['tnumber']; ?></strong></option>
                                        <?php												
											}
										}
										?>
                                    </select>                                   
                                    <script>document.getElementById('tid<?php echo $i; ?>').value = '<?php echo $tid; ?>';
									  // document.getElementById('tnumber_hid<?php //echo $mpid; ?>').value = '<?php //$cmn->getvalfield($connection,"tyre_purchase","tnumber","tid = '$tid'"); ?>';
                                   // document.getElementById('truckno_hid<?php //echo $mpid; ?>').value = '<?php //$cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'"); ?>';
                                    </script>
								<?php 
                                
									}
									else
								{
								?>
                                
                                 
                                	<select name="tid[]" id="tid<?php echo $i; ?>" class="input-medium select2-me" onChange="return getdescription(this.value,<?php echo $i; ?>);" >
                                    	<option value="">-Select-</option>
                                        <?php	
										$sql_tyre = mysqli_query($connection,"select tid,tnumber from tyre_purchase where remarks = 0 and tid not in (SELECT tid from tyre_map where truckid='$truckid' and  downdate = '0000-00-00')");
										if($sql_tyre)
										{
											while($row_tyre = mysqli_fetch_assoc($sql_tyre))
											{												
										?>
                                        <option value="<?php echo $row_tyre['tid']; ?>"><strong><?php echo $row_tyre['tnumber']; ?></strong></option>
                                        <?php												
											}
										}
										?>
                                    </select>                                   
                                    <script>document.getElementById('tid<?php echo $i; ?>').value = '<?php echo $tid; ?>';
									  // document.getElementById('tnumber_hid<?php //echo $mpid; ?>').value = '<?php //$cmn->getvalfield($connection,"tyre_purchase","tnumber","tid = '$tid'"); ?>';
                                   // document.getElementById('truckno_hid<?php //echo $mpid; ?>').value = '<?php //$cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'"); ?>';
                                    </script>
								<?php } ?>	
									
                                </td>
                                <td align="center"><input type="text" name="uploaddate[]" id="uploaddate<?php echo $i; ?>" class="input-small" value="<?php echo $uploaddate; ?>"></td>
                                <td align="center"><input type="text" name="meterreading[]" id="meterreading<?php echo $i; ?>" class="input-small" value="<?php echo $mtrd; ?>"></td>
                                <td><div id="desc<?php echo $i; ?>" style="width:200px;height:20px; font-weight:bold; color:#0C3"><?php echo $desc; ?></div></td>
                                <td align="center">
                                <?php
								$totkm=0;
								$sql12="SELECT *,tyre_map.truckid as 'trcid' FROM tyre_map left join m_truck on m_truck.truckid=tyre_map.truckid where tid='$tid'";
								if($data12=mysqli_query($connection,$sql12))
								{
									while($row12=mysqli_fetch_array($data12))
									{
										$trcid=$row12['trcid'];
										$update=$row12['uploaddate'];
										$downdate=$row12['downdate'];
										if($downdate != '0000-00-00')
										$sql13="Select sum(totalkm) as 'totkm' from diesel_demand_slip where truckid='$trcid' and diedate between '$update' and '$downdate'";
										else
										$sql13="Select sum(totalkm) as 'totkm' from diesel_demand_slip where truckid='$trcid' and diedate >='$update' ";
										if($data13=mysqli_query($connection,$sql13))
										{
											$row13=mysqli_fetch_assoc($data13);
									
											$totkm+=$row13['totkm'];
										}
									}
								}
								?><span class="red"><?php echo $totkm." KM"; ?></span></td>
                                <td align="center"><?php if($mpid!=""){ ?><a 
                                onclick='my_delete1(<?php echo $mpid; ?>,<?php echo $i; ?>);' style="cursor:pointer;" class="btn btn-block">Remove</a> <?php }else{echo "&nbsp;";} ?></td>
                              </tr>
                              <?php
							  }
							  ?>
                            </table>
                            <br>
							 <input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary">
									
                                    <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                                     <a href='print_tyre_truck_mapping.php?truckid=<?php echo $truckid ; ?>' class="btn btn-success" target="_blank">Print</a>
                               
                                  
                            </fieldset>
                            </form>
                            
                            
                              
                            <center>
                            <fieldset style=" width:47%; height:400px; float:left ; margin-left:20px; margin-top:20px;"><h4><i class="icon-edit"></i> Truck History</h4>
                            <table width="100%" border="1" >
                              <tr bgcolor="#33CCFF">
                                <td width="8%"><strong>S.No.</strong></td>
                                <td width="17%"><strong>Tyre No</strong></td>
                                <td width="16%"><strong>Location</strong></td>
                                <td width="27%"><strong>Up Loaded Date</strong></td>
                                <td width="32%"><strong>Down Loaded Date</strong></td>
                              </tr>
                              <?php
									//echo "select * from tyre_map where downdate != '0000-00-00' and truckid = '$truckid'";	 
							  $sql = mysqli_query($connection,"select * from tyre_map where downdate != '0000-00-00' and truckid = '$truckid'");
							  if($sql)
							  {
								  $cnt = mysqli_num_rows($sql);
								  if($cnt != 0)
								  {
									  $sn = 1;
									  while($row = mysqli_fetch_assoc($sql))
									  {
								  ?>
									  <tr>
										<td><?php echo $sn++;?></td>
										<td><?php echo $cmn->getvalfield($connection,"tyre_purchase","tnumber ","tid = '$row[tid]'"); ?></td>
										<td><?php echo $row['typos']; ?></td>
										<td><?php echo $cmn->dateformatindia($row['uploaddate']); ?></td>
										<td><?php echo $cmn->dateformatindia($row['downdate']); ?></td>
									  </tr>
								  <?php
									  }
								  }
								 else
								  {
									  echo "<tr><td colspan='5'><strong>NO DATA FOUND</strong></td></tr>";
								  }
								  
							  }
							  ?>
                            </table>
                            
                            
                            </fieldset>
                            
                            <div style="display:none;">
                            
                            <fieldset style="width:47%; height:400px; float:left ; margin-left:20px;margin-top:20px;"><h4><i class="icon-edit"></i> Tyre History</h4>
                            <?php
							$tid = explode(",",$tyre_id);
						//	echo count($tid);
							for($i=count($tid) + 1; $i>0; $i--)
							{
								if($tid[''+$i] != "")
								{?>
                            	<table width="100%" border="1">
                                <tr bgcolor="#33CCFF">
                                    <td colspan="5" align="center"><strong>Tyre No : <?php echo $cmn->getvalfield($connection,"tyre_purchase","tnumber ","tid = '$tid[$i]'"); ?></strong></td>
                                   
                                  </tr>
                                  <tr bgcolor="#33CCFF">
                                    <td><strong>S.No.</strong></td>
                                     <td><strong>Vehicle</strong></td>
                                    <td><strong>Location</strong></td>
                                    <td><strong>Up Loaded Date</strong></td>
                                    <td><strong>Down Loaded Date</strong></td>
                                  </tr>
                                  <?php
                                 // echo $tyre_id;
                                 //echo "select * from tyre_map where downdate != '0000-00-00' and tid = '$tid[$i]' ";
                                  $sql = mysqli_query($connection,"select * from tyre_map where downdate != '0000-00-00' and tid = '$tid[$i]' ");
                                  if($sql)
                                  {
                                      $cnt = mysqli_num_rows($sql);
                                      if($cnt != 0)
                                      {
                                          $sn = 1;
                                          while($row = mysqli_fetch_assoc($sql))
                                          {
                                      ?>
                                          <tr>
                                            <td><?php echo $sn++;?></td>
                                            <td><?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$row[truckid]'"); ?></td>
                                            <td><?php echo $row['typos']; ?></td>
                                            <td><?php echo $cmn->dateformatindia($row['uploaddate']); ?></td>
                                            <td><?php echo $cmn->dateformatindia($row['downdate']); ?></td>
                                          </tr>
                                      <?php
                                          }
                                      }
                                      else
                                      {
                                          echo "<tr><td colspan='5'><strong>NO DATA FOUND</strong></td></tr>";
                                      }
							  }
							  ?>
                            </table>
                            <br>
                            <?php
								}
							}
							?>
                            </fieldset>
                            
                            </div>
                            
                            </center>
                                                  
                            
						<?php
						}?>





                          </div>
                            
						</div>
					</div>
				</div>
                
                <!--   DTata tables -->
                
				
			
			</div>
		</div></div>
        <script>
		function getdescription(tid,i)
		{
			if(tid != "" && i != "")
			{
			$.ajax({
			  type: 'POST',
			  url: 'ajax_get_tyre_description.php',
			  data: 'tid='+tid,
			  dataType: 'html',
			  success: function(data){
				  //alert(data);
					if(data!= "")
					{
						$("#desc"+i).html(data);
						
					}
				}
		
		  });//ajax close
			}//end if
			else
			$("#desc"+i).html("");
		}
		</script>
                                    
        <script>
function my_delete1(mapid,location)
{
	tnumber_hid= $("#tid"+location+" option:selected").text();
	//alert(tnumber_hid);
	$("#div_remove").fadeToggle( "slow", "linear" );
	$("#content").fadeTo("slow", 0.35);
	$("#mapid_hid").val(''+mapid);
	$("#location_hid").html(''+location);
	$("#tnumber_hid").html(tnumber_hid);
	
}
</script>
<script>
function setMap(truckid)
{
	//alert(truckid);
	empid = $("#empid"+truckid).val();
	//alert(empid);
	conductorid = $("#conductorid"+truckid).val();
	//alert(conductorid);
	$.ajax({
		  type: 'POST',
		  url: 'ajax_tyre_truck_maping.php',
		  data: 'conductorid='+conductorid+'&empid='+empid+'&truckid='+truckid,
		  dataType: 'html',
		  success: function(data){
			  //alert(data);
				if(data == 1)
				{
					$("#show"+truckid).show();
					setTimeout(function() { $("#show"+truckid).fadeOut(1500); }, 3000);
					
				}
			}
		
		  });//ajax close
	
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


function ajax_save_shortcut_truckno(sc_ownerid,sc_truckno)
{
	var ownerid = document.getElementById(sc_ownerid).value;
	var truckno = document.getElementById(sc_truckno).value;
	
	if(ownerid == "" || truckno == "")
	{
		alert('Fill form properly');
		document.getElementById(sc_truckno).focus();
		return false;
	}
	//alert(textval);
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert('This Challan number is already exist');
				document.getElementById("truckid").innerHTML = xmlhttp.responseText;
				
				document.getElementById("sc_truckno").value = "";
				document.getElementById("sc_ownerid").value = "";
				$("#div_truck").hide(1000);
				//document.getElementById("chalannum").focus();
			}
		}
	}
	xmlhttp.open("GET","ajax_savetruck.php?truckno="+truckno+"&ownerid="+ownerid,true);
	xmlhttp.send();
}

function ajax_save_shortcut_removal()
{
	downdate= $("#downdate").val();
	description= $("#description").val();
	remarks= $("#remarks").val();	
	resale_amt= $("#resale_amt").val();
	resale_to= $("#resale_to").val();
	resale_description= $("#resale_description").val();
	mapid= $("#mapid_hid").val();
	

	if(downdate == "" || description == "" || remarks == "")
	{
		alert('Fill form properly');
		document.getElementById("downdate").focus();
		return false;
	}
	else if(description == "" )
	{
		alert('Fill form properly');
		document.getElementById("description").focus();
		return false;
	}
	else if(remarks == "")
	{
		alert('Fill form properly');
		document.getElementById("remarks").focus();
		return false;
	}
	
	if(window.XMLHttpRequest)
	{
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} 
	else
	{ // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText != 0)
			{
				//alert( xmlhttp.responseText);
				document.getElementById("truckid").innerHTML = xmlhttp.responseText;				
				//document.getElementById("sc_truckno").value = "";
				//document.getElementById("sc_ownerid").value = "";
				//$("#div_truck").hide(1000);
				//document.getElementById("chalannum").focus();*/
				location =  window.location="tyre_truck_maping.php?truckid=<?php echo $truckid; ?>&search=Search";
			}
		}
	}
	xmlhttp.open("GET","ajax_remove_tyre.php?mapid="+mapid+"&downdate="+downdate+"&description="+description+"&remarks="+remarks+"&resale_amt="+resale_amt+"&resale_to="+resale_to+"&resale_description="+resale_description, 	true);
	xmlhttp.send();
}
</script>
	</body>
    <?php
/*<script>
    // autocomplet : this function will be executed every time we change the text
    function autocomplet() {
    var min_length = 0; // min caracters to display the autocomplete
    var keyword = $('#country_id').val();
    if (keyword.length >= min_length) {
    $.ajax({
    url: '\autocomplete/ajax_refresh.php',
    type: 'POST',
    data: {keyword:keyword},
    success:function(data){
    $('#country_list_id').show();
    $('#country_list_id').html(data);
    }
    });
    } else {
    $('#country_list_id').hide();
    }
    }
     
    // set_item : this function will be executed when we select an item
    function set_item(item) {
    // change input value
    $('#country_id').val(item);
    // hide proposition list
    $('#country_list_id').hide();
    }
</script>*/

?>

	</html>
<?php
mysql_close($db_link);
?>
