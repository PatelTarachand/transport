<?php
  error_reporting(0);
  include("dbconnect.php");
  $tblname = "";
  $tblpkey = "";
  $pagename = "bulk_bilty_payment_emami_trash.php";
  $modulename = "Bulk Bilty Payment Trash file";
  
  if(isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
  else
  $action = 0; 	
  
  $cond=' ';
  
  
   $printdate=date('Y-m-d');
  if(isset($_GET['di_no']))
  {
  	$di_no = trim(addslashes($_GET['di_no']));	
  }
  else
  $di_no = '';
  
  if(isset($_GET['ownerid']))
  {
  	$ownerid = trim(addslashes($_GET['ownerid']));	
  }
  else
   $ownerid = '';
  
if(isset($_GET['voucher_id']))
  {
    $voucher_No = $_GET['voucher_id'];
  }
  else
    $voucher_No='';
  
$sql_voucher = mysqli_query($connection,"select * from bulk_payment_vochar where payment_vochar='$voucher_No'");
        $row_voucher = mysqli_fetch_array($sql_voucher);

            $bulk_voucher_id=$row_voucher['bulk_voucher_id'];
  
  $cond= " where 1=1";
  if($voucher_No!='') {
  	
  	$cond .=" and  B.voucher_id = '$bulk_voucher_id'  ";
  	
  	}
  	if($ownerid !='') {
  	
  	$cond .=" and A.ownerid='$ownerid'";
  	
  	}
  	
  	$payment_vouchar="SELECT * FROM `bulk_payment_vochar` ORDER by id DESC";
     $payres = mysqli_query($connection,$payment_vouchar);
                              $payrow = mysqli_fetch_array($payres);
                              $payNoIncre= $payrow['bulk_voucher_id']+1;
  
  
  ?>
<!doctype html>
<html>
  <head>
    <?php  include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>
    <script>
      $(function() {
       
      $('#from').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       $('#todate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
       	  $('.recdate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
      
      
      });
    </script>
  </head>
  <body>
    <?php include("../include/top_menu.php"); ?> <!--- top Menu----->
    <div class="container-fluid" id="content">
      <div id="main">
        <div class="container-fluid">
          <!--  Basics Forms -->
          <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                  <legend class="legend_blue"><a href="dashboard.php"> 
                    <img src="menu/home.png" style="width:30px;"/><span style="color:#FF0000; font-weight:bold"> GO TO HOME </span></a>
                  </legend>
                  <?php include("alerts/showalerts.php"); ?>
                  <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
                  <?php include("../include/page_header.php"); ?>
                </div>
                <form  method="get" action="" class='form-horizontal' >
                  <div class="control-group">
                    <table class="table table-condensed">
                      <tr>
                        <td colspan="7"><strong style="color:#F00;"><?php echo $duplicate; ?></strong></td>
                      </tr>
                      <tr>
                        <td><strong>Truck Owner </strong> <strong>:</strong><span class="red">*</span></td>
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
                          <script>document.getElementById('ownerid').value = '<?php echo $ownerid; ?>';</script>
                        </td>
                        <td><strong>Voucher No</strong> <strong>:</strong><span class="red">*</span></td>
                        <td>
                          <input type="text" name="voucher_id" id="voucher_id" value="<?php echo $_GET['voucher_id']; ?>"  tabindex="10" >
                         
                        </td>
                       
                        <td>
                          <input type="submit" name="submit" id="submit" value="Search" class="btn btn-success" tabindex="10">
                          <?php if(isset($_GET['edit']) && $_GET['edit']!=="")
                            {?>
                          <input type="button" value="Cancel" class="btn btn-success" onClick="document.location.href='<?php echo $pagename ; ?>';" />
                          <?php
                            }
                                                      else
                                                      {                                       
                                                      ?>   <input type="reset" value="Reset" class="btn btn-danger" style="margin-left:10px" onClick="document.location.href='<?php echo $pagename ; ?>';" >
                          <?php
                            }
                            ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </form>
              </div>
            </div>
          </div>



           <div class="row-fluid">
            <div class="span12">
              <div class="box">
                <div class="box-title">
                
                  
                  <h3><?php 
                 $OWNIID= $_GET['ownerid'];
                  $OWN="SELECT * FROM `m_truckowner` WHERE `ownerid`=$OWNIID";
                  $OWNres = mysqli_query($connection,$OWN);
                        			while($OWNrow = mysqli_fetch_array($OWNres))
                        			{
                        				echo $OWNrow['ownername']; 
                        			}
				?>
                  </h3>
                </div>

			
              </div>
            </div>
          </div>


          <!--   DTata tables -->
          <div class="row-fluid">
            <div class="span12" style="width:100%">
              <div class="box box-bordered">
                <div class="box-title">
                  <h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                </div>
                
                <div class="box-content nopadding overflow-x:auto" style="overflow: scroll;width: 100%;">
                  <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered"  width="100%">
                    <thead id="table">
                      <tr>
                        <th width="2%" >Sn</th>
                        <th width="5%" >Truck Owner</th>
                        <th width="5%" >Vouchar No</th>
                      
                        
                        <th width="5%" >Action</th>
                        <th width="5%" >Permanent Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 

                        $sn=1;
                        
                         
                        if($ownerid=='' && $voucher_No==''){
                              $sel = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.consignorid=4 && B.recweight !='0' && B.deletestatus!=0 && B.compid='$compid' Group by B.voucher_id,B.voucher_id  DESC  LIMIT 20 ";
                        }
                        else
                        {
                             $sel = "SELECT * from m_truck as A left join bidding_entry as B on (A.truckid = B.truckid)   $cond and B.is_complete=1 && B.consignorid=4 && B.recweight !='0' && B.deletestatus!=0 && B.compid='$compid' Group by B.voucher_id , B.voucher_id  DESC ";
                        
                        }
                        $res = mysqli_query($connection,$sel);
                        			while($row = mysqli_fetch_array($res))
                        			{
                        				$truckid = $row['truckid'];	
                        				$truckno = $row['truckno'];	
                        				$ownerid = $row['ownerid'];	
                                        $bid_id = $row['bid_id'];	
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $ownername = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        
                      
                        
                        
                        $itemname = $cmn->getvalfield($connection,"inv_m_item","itemname","itemid='$itemid'");
                        $truckno = $cmn->getvalfield($connection,"m_truck","truckno","truckid='$truckid'");
                        $ownerid = $cmn->getvalfield($connection,"m_truck","ownerid","truckid='$truckid'");
                        $truckowner = $cmn->getvalfield($connection,"m_truckowner","ownername","ownerid='$ownerid'");
                        
                        
                         $payment_date = $row['payment_date'];
                        	$voucher_id = $row['voucher_id'];
                        $vou_query="SELECT `payment_vochar` FROM `bulk_payment_vochar` WHERE `bulk_voucher_id`='$voucher_id'";
                                
                                $voures = mysqli_query($connection,$vou_query);
                                    $vocrow = mysqli_fetch_array($voures);
                                    $voucharno= $vocrow['payment_vochar'];
                                    

                        ?>
                      <tr tabindex="<?php echo $sn; ?>" class="abc">
                        <td><?php echo $sn++; ?></td>
                          <td><?php echo $ownername; ?>
                        </td>
                        
                          <td><?php echo $voucharno; ?>
                        </td>
                        <td>	
                        <a  href="bulk_bilty_payment_emami_Undo_trash.php?id=<?php echo $voucher_id; ?>" ><button class="btn btn-success">Sent to Report list</button></a>                  
                        </td>
                        <td>
                         
                    <button class="btn btn-danger center" onClick="funDel('<?php echo $voucher_id; ?>')">Delete</button>
                           
                          
                        </td>
                        
                    
                         
                      </tr>
                      <?php 
                        }
                       
                        ?>
                    </tbody>
                  </table>
                </div>
                  <div>
                  </a>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>

    function funDel(id)
	{  
	
		if(confirm("Are you sure! You want to delete this record."))
		{
		  //  alert(id);
			$.ajax({
			  type: 'POST',
			  url: 'bulk_bilty_payment_emami_per_delete.php',
			  data: 'id='+id,
			  dataType: 'html',
			  success: function(data){
				//   alert(data);
				 // alert('Data Deleted Successfully');
				   location='<?php echo $pagename."?action=3" ; ?>';
				}
			
			  });//ajax close
		}//confirm close
	} //fun close
	





      
    </script>
  </body>
</html>
<?php
  mysqli_close($connection);
  ?>