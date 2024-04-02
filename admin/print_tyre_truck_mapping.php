<?php error_reporting(0);
include("dbconnect.php");
$tblname = "tyre_map";
$tblpkey = "mapid";
$pagename = "tyre_truck_maping.php.php";
$modulename = "Truck-Tyre-Mapping";

//print_r($_SESSION);

if(isset($_REQUEST['action']))
$action = $_REQUEST['action'];
else
$action = 0;

if(isset($_GET['truckid']))
{
	$truckid = addslashes(htmlspecialchars(trim($_GET['truckid'])));
	$typeid = $cmn->getvalfield($connection,"m_truck","typeid","truckid = '$truckid'");
	$noofwheels = $cmn->getvalfield($connection,"m_trucktype","noofwheels","typeid = '$typeid'");
	$typeimg = $cmn->getvalfield($connection,"m_trucktype","typeimg","typeid = '$typeid'");
}

?>
<!doctype html>
<html>
<head>
<?php  include("../include/top_files.php"); ?>
<?php include("alerts/alert_js.php"); ?>
<style>
	.body table td { font-family:Arial, Helvetica, sans-serif; font-size:11px; }
</style>
 
</head>

<body>
	<div class="container-fluid" id="content">
		
		<div id="main">
			<div class="container-fluid">
            <?php
						if(isset($_GET['truckid']))
						{?>
         			 <div class="row-fluid" >
                     	<div class="span12">
                          <div class="box-title">
                           <table> 
                          </table>
							</div>
                           </div>
                       </div>
                     <div class="row-fluid" >   
                    	<div class="span3" >
                        	<div class="box">
                              <center><img src="../images/<?php echo $typeimg; ?>" /></center>
                            </div>
                        </div>
                        <div class="span9" >
                        	<div class="box">
                            	<table width="100%" align="center" border="1" st>
                                    <tr bgcolor="#CCCCCC">
                                    <th width="9%" scope="col" colspan="6" align="center"><h4>Truck Tyre Mapping For Truck No : <?php echo $cmn->getvalfield($connection,"m_truck","truckno","truckid = '$truckid'");?></h4></th>
                                    </tr>
                                    <tr bgcolor="#CCCCCC">
                                    <th width="9%" scope="col"><strong>Location No</strong></th>
                                    <th width="20%" scope="col"><strong>Tyre No</strong></th>
                                    <th width="8%" scope="col"><strong>Upload Date</strong></th>
                                    <th width="16%" scope="col"><strong>Meter Reading</strong></th>
                                    <th width="20%" scope="col"><strong>Description</strong></th>
                                    <th width="11%" scope="col"><strong>Total Km</strong></th>
                                    </tr>
                                    <?php
                                    for($i = 1;$i<=$noofwheels ; $i++)
                                    {
                                    $mpid="";
                                    $tid="";
                                    $desc="";
                                    $uploaddate="";
                                    $mtrd="";
                                    $data_fetch=mysqli_query($connection,"SELECT * FROM tyre_map where truckid='$truckid' and typos='$i' and downdate = '0000-00-00'");
                                    if(mysqli_num_rows($data_fetch)==1)
                                    {
                                        $row_fetch=mysqli_fetch_array($data_fetch);
                                        $mpid=$row_fetch['mapid'];
                                        $tid=$row_fetch['tid'];
                                        $desc= $cmn->getvalfield($connection,"tyre_purchase","tdescription","tid = '$tid'");
                                        $uploaddate=$cmn->dateformatindia($row_fetch['uploaddate'],"ymd","dmy","-");
                                        $mtrd=$row_fetch['meterreading'];
                                        $tyre_id = $tid.",".$tyre_id;
                                    }
                                    ?>
                                    <input type="hidden" name="typos[]" id="typos<?php echo $i; ?>" value="<?php echo $i; ?>">
                                    <tr>
                                    <td align="center"><strong><?php echo $i; ?></strong></td>
                                    <td align="center">
                                        
                                      <strong> <?php echo $cmn->getvalfield($connection,"tyre_purchase","tnumber","tid = '$tid' "); ?></strong>
                                        
                                    </td>
                                    <td align="center"><?php echo $uploaddate; ?></td>
                                    <td align="center"><?php echo $mtrd; ?></td>
                                    <td><div id="desc<?php echo $i; ?>" style="font-weight:bold; color:#0C3"><?php echo $desc; ?></div></td>
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
                                                $row13=mysqli_fetch_array($data13);
                                                //echo " : ".$row13['totkm']." ";
                                                $totkm+=$row13['totkm'];
                                            }
                                        }
                                    }
                                    ?><span class="red"><?php echo $totkm." KM"; ?></span></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    </table>
                            </div>
                        </div>
                      </div>
			
                           	<div>
                             <!--truck history start-->
                            <!--<div style="width:49.5%; float:left">
                            <table width="100%" border="1" >
                            
                            <tr><td colspan="5" align="center"><strong> Truck History</strong></td></tr>
                            <tr bgcolor="#CCCCCC">
                            <td width="8%"><strong>S.No.</strong></td>
                            <td width="17%"><strong>Tyre No</strong></td>
                            <td width="16%"><strong>Location</strong></td>
                            <td width="27%"><strong>UpLoad Dt.</strong></td>
                            <td width="32%"><strong>DownLoad Dt.</strong></td>
                            </tr>
                            <?php
                            
                            $sql = mysqli_query($connection,"select * from tyre_map where downdate != '0000-00-00' and truckid = '$truckid' ");
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
                            </div>-->
                             <!--truck history end-->
                              <!--tyre history start-->
                            <!--<div style="width:49.5%; float:right">
                            <table width="100%" border="1">
                             <tr><td colspan="6" align="center"><strong> Tyre History</strong></td></tr>
                                                    <?php
                            $tid = explode(",",$tyre_id);
                            //	echo count($tid);
                            for($i=count($tid) + 1; $i>0; $i--)
                            {
                            if($tid[''+$i] != "")
                            {?>
                            
                            <tr bgcolor="#CCCCCC">
                                <td colspan="6" align="center"><strong>Tyre No : <?php echo $cmn->getvalfield($connection,"tyre_purchase","tnumber ","tid = '$tid[$i]'"); ?></strong></td>
                               
                              </tr>
                              <tr bgcolor="#CCCCCC">
                                <td><strong>S.No.</strong></td>
                                 <td><strong>Vehicle</strong></td>
                             
                                <td><strong>Location</strong></td>
                                <td><strong>UpLoad Dt</strong></td>
                                <td><strong>DownLoad Dt</strong></td>
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
                                      echo "<tr><td colspan='5'><strong>NO RECORD FOUND</strong></td></tr>";
                                  }
                            }
                            ?>
                            
                            
                            <?php
                            }
                            }
                            ?>
                            </table>
                            </div>-->
                             <!--tyre history end-->
                            </div>
					<?php }?>
         </div>
        </div>
   </div>
</body>
  
	</html>
<?php
mysql_close($db_link);
?>
