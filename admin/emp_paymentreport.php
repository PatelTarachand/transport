<?php
error_reporting(0);
include("dbconnect.php");
$tblname = "emp_payment";
$tblpkey = "emppayment_id";
$pagename = "emp_paymentreport.php";
$modulename = "Payment Entry Detail";

if (isset($_REQUEST['action']))
  $action = $_REQUEST['action'];
else
  $action = 0;


if (isset($_GET['search'])) {
  $fromdate = $cmn->dateformatusa(trim(addslashes($_GET['fromdate'])));
  $todate =  $cmn->dateformatusa(trim(addslashes($_GET['todate'])));
  $empid = trim(addslashes($_GET['empid']));
  
} else {
  $fromdate = date('Y-m-d');
  $todate = date('Y-m-d');
 
  $empid = '';
  
}


$crit = " where 1=1 ";
if ($fromdate != '' && $todate != '') {
  $crit .= " and  pay_date between '$fromdate' and '$todate' ";
}

if ($empid != '') {
  $crit .= " and empid='$empid' ";
}


?>

<!doctype html>

<html>

<head>

  <?php include("../include/top_files.php"); ?>

  <?php include("alerts/alert_js.php"); ?>



</head>



<body onLoad="hideval();">

  <?php include("../include/top_menu.php"); ?> <!--- top Menu----->



  <div class="container-fluid" id="content">



    <div id="main">

      <div class="container-fluid">



        <!--  Basics Forms -->

        <div class="row-fluid">

          <div class="span12">

            <div class="box">

              <div class="box-title">

                <?php include("alerts/showalerts.php"); ?>

               <h3><i class="icon-edit"></i><?php echo $modulename; 
                                                  ?></h3>
                                                   <a href="emp_payment.php" class="btn btn-primary" style="float:right;">ADD NEW</a>

                <?php include("../include/page_header.php"); ?>

              </div>

              <div class="box-content">

                <form method="get" action="">


                 <!--  <legend class="legend_blue"> <i class="icon-edit"></i>&nbsp;<?php echo $modulename; ?> </legend> -->
                 
                  <table width="60%">
                    <tr>
                      <td><strong>From Date :</strong> </td>
                      <td><strong>To Date : </strong></td>
                      <td><strong>	Employee Name:</strong> </td>
                      <!-- <th width="15%" style="text-align:left;">Item Name : </th> -->
                      <!-- <th width="20%" style="text-align:left;">Action : </th> -->
                    </tr>
                    <tr>
                      <td> <input class="formcent" type="date" name="fromdate" id="fromdate" value="<?php echo $cmn->dateformatindia($fromdate); ?>" data-date="true" required style="border: 1px solid #368ee0;width:150px;margin-bottom:0px" autocomplete="off"></td>
                      <td> <input class="formcent" type="date" name="todate" id="todate" value="<?php echo $cmn->dateformatindia($todate); ?>" data-date="true" required style="border: 1px solid #368ee0;width:150px;margin-bottom:0px" autocomplete="off"></td>

                      <td>
                        <select id="empid" name="empid" class="formcent select2-me" style="width:180px;">
                          <option value=""> - Select - </option>
                          <?php
                          $sql_fdest = mysqli_query($connection, "select empid,empname from m_employee order by empname");
                          while ($row_fdest = mysqli_fetch_array($sql_fdest)) {
                          ?>
                            <option value="<?php echo $row_fdest['empid']; ?>"><?php echo $row_fdest['empname']; ?></option>
                          <?php
                          } ?>
                        </select>
                        <script>
                          document.getElementById('empid').value = '<?php echo $empid; ?>';
                        </script>

                      </td>

                      <!-- <td>

                        <select id="itemid" class="select2-me" style="width:300px;">
                          <option value="">--Choose Item--</option>
                          <?php
                          //where cat_id not in (5,8)
                          $resprod = mysqli_query($connection, "select * from items order by item_name");
                          while ($rowprod = mysqli_fetch_array($resprod)) {
                            $item_category_name = $cmn->getvalfield($connection, "item_categories", "item_category_name", "itemcatid='$rowprod[itemcatid]'");

                          ?>
                            <option value="<?php echo $rowprod['itemid']; ?>"><?php echo  $rowprod['item_name'] ; ?>/<?php echo $item_category_name; ?></option>
                          <?php
                          }
                          ?>
                        </select>

                      </td>
 -->





                      <td>
                        <input type="submit" name="search" class="btn btn-success btn-sm" id="" value="Search" onClick="return checkinputmaster('fromdate,todate');" style="width:80px;">
                        <a href="<?php echo $pagename; ?>" class="btn btn-danger" style="width:80px;">Reset</a>
                      </td>
                    </tr>


                  </table>
                  </fieldset>
                </form>

              </div>

            </div>

          </div>

        </div>

        <!--   DTata tables -->

        <div class="row-fluid">

          <div class="span12">

            <div class="box box-bordered">

              <div class="box-title">

                <h3><i class="icon-table"></i><?php echo $modulename; ?> </h3>

                   <p align="right" style="margin-top:7px; margin-right:10px;"> <a href="excel_emp_payment_report.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" class="btn btn-info" style="background-color:#368ee0;" target="_blank">
                  <span style="font-weight:bold;color:#FFF">Print Excel</span></a></p>

              </div>


              


              <div class="box-content nopadding">

                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">

                  <thead>
                    <tr>
                    <th>Sno</th>  
                                            <th>Payment Date</th> 
                                            <th>Employee Name</th> 
                                            <th>Expense Head</th> 
                                          
                                            <th>Amonut</th> 
                                          
                                        	<th>Pay Mode</th>                                            
                                        
                                            <th>Narration</th> 
                                            <th>Print</th> 
                      <!--<th class='hidden-480'>Action</th>-->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $slno = 1;
      // echo "select * from emp_payment $crit order by emppayment_id desc";die;
       $sql = "select * from emp_payment $crit order by emppayment_id desc";
       $res =mysqli_query($connection,$sql);
       while($row = mysqli_fetch_array($res))
       {
         $truckno = $cmn->getvalfield($connection,"m_truck","truckno","empid='$row[empid]'");
         $exp_head = $cmn->getvalfield($connection,"exp_head_master","exp_head","exheadid='$row[exheadid]'"); 
                             $mechanic_name=$cmn->getvalfield($connection,"mechine_service_master","mechanic_name","meachineid='$row[meachineid]'");
       
         $empname = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[empid]' "); 

         $driver = $cmn->getvalfield($connection,"m_employee","empname","empid='$row[driver]' && designation='1' "); 
       ?>
         <tr>
                                 <td><?php echo $slno; ?></td>
                                 <td><?php echo dateformatindia($row['pay_date']);?></td>   
                                 <td><?php echo ucfirst($empname);?></td>                                        
                                 <td><?php echo ucfirst($exp_head);?></td>
                                 <td><?php echo ucfirst($row['amount']);?></td>
                                 <td><?php echo ucfirst($row['payment_type']);?></td> 
                              
                                
                                  <td><?php echo ucfirst($row['narration']);?></td> 
                        <td>
                                            <a href="print_emp_payment.php?emppayment_id=<?php echo ucfirst($row['emppayment_id']);?>" target="_blank" class="btn btn-warning">Print</a>
                                            </td>
                        <!--<td class='hidden-480'>-->
                        <!--  <a href="issueentry.php?issueid=<?php echo $row['emppayment_id']; ?>"><img src="../img/b_edit.png" title="Edit"></a>-->
                          <!-- onClick="edit(<?php echo $row['issueid']; ?>)" -->
                        <!--  &nbsp;&nbsp;&nbsp;-->
                        <!--  <?php if ($usertype == "admin") { ?><a onClick="funDel('<?php echo $row['emppayment_id'];  ?>')"><img src="../img/del.png" title="Delete"></a><?php } ?>-->
                        <!--</td>-->
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

    </div>
  </div>

  <script>
    $(function() {



      $('#open_date').datepicker({
        dateFormat: 'dd-mm-yy'
      }).val();





    });
  </script>

  <script>
    function funDel(id)

    {

      //alert(id);   

      tblname = 'issueentry';

      tblpkey = 'issueid';

      pagename = '<?php echo $pagename; ?>';

      modulename = '<?php echo $modulename; ?>';

      //alert(tblpkey); 

      if (confirm("Are you sure! You want to delete this record."))

      {

        $.ajax({

          type: 'POST',

          url: '../ajax/delete_issue.php',

          data: 'id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' + modulename,

          dataType: 'html',

          success: function(data) {

            // alert(data);

            // alert('Data Deleted Successfully');

            location = pagename + '?action=10';

          }



        }); //ajax close

      } //confirm close

    } //fun close





    function hideval()

    {

      var paymode = document.getElementById('paymode').value;

      if (paymode == 'cash')

      {

        document.getElementById('checquenumber').disabled = true;

        document.getElementById('bankname').disabled = true;

        document.getElementById('checquenumber').value = "";

        document.getElementById('bankname').value = "";

      } else

      {

        document.getElementById('checquenumber').disabled = false;

        document.getElementById('bankname').disabled = false;

      }

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

mysqli_close($connection);

?>