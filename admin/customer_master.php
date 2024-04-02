<?php
include("dbconnect.php");
$tblname = "m_customer";
$tblpkey = "customer_id";
$pagename = "customer_master.php";
$modulename = "Customer Master";
$duplicate = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}
if (isset($_GET['editid'])) {
    $keyvalue = $_GET['editid'];
} else {
    $keyvalue = 0;
}
if (isset($_GET['editid']) != "") {
    $keyvalue = test_input($_GET['editid']);
    $sql = mysqli_query($connection, "select * from $tblname where $tblpkey='$keyvalue'");
    $row = mysqli_fetch_array($sql);
    $customer_name = $row['customer_name'];
    $mobile_no  = $row['mobile_no'];
    $email_id = $row['email_id'];
    $customer_address = $row['customer_address'];
    $place_id = $row['place_id'];
    $gst_no = $row['gst_no'];
    $pan_no = $row['pan_no'];
    $opn_balnc = $row['opn_balnc'];
    $opn_balnc_date = $row['opn_balnc_date'];
    $acc_holder_name = $row['acc_holder_name'];
    $acc_no = $row['acc_no'];
    $ifsc_code = $row['ifsc_code'];
    $bank_name = $row['bank_name'];
    $branch_name = $row['branch_name'];
    $acc_type = $row['acc_type'];
    $ac_type1 = $row['ac_type1'];
    $stateid = $row['stateid'];
    $placeid = $row['placeid'];
    $pincode = $row['pincode'];
    $country = $row['country'];
    $party_type = $row['party_type'];
} else {
    $customer_name = '';
    $mobile_no  = '';
    $email_id  = '';
    $customer_address  = '';
    $place_id  = '';
    $gst_no  = '';
    $pan_no  = '';
    $opn_balnc  = '';
    $opn_balnc_date  = '';
    $acc_holder_name  = '';
    $acc_no  = '';
    $ifsc_code  = '';
    $bank_name  = '';
    $branch_name  = '';
    $acc_type  = '';
    $ac_type1 = '';
    $stateid = '';
    $placeid = '';
    $pincode = '';
    $country = '';
}
if (isset($_POST['submit'])) {
    $customer_name = $_POST['customer_name'];
    $mobile_no = $_POST['mobile_no'];
    $email_id = $_POST['email_id'];
    $customer_address = $_POST['customer_address'];
    $place_id = $_POST['place_id'];
    $gst_no = $_POST['gst_no'];
    $pan_no = $_POST['pan_no'];
    $opn_balnc = $_POST['opn_balnc'];
    $opn_balnc_date = $_POST['opn_balnc_date'];
    $acc_holder_name = $_POST['acc_holder_name'];
    $acc_no = $_POST['acc_no'];
    $ifsc_code = $_POST['ifsc_code'];
    $bank_name = $_POST['bank_name'];
    $branch_name = $_POST['branch_name'];
    $acc_type = $_POST['acc_type'];
    $party_type = $_POST['party_type'];
    $ac_type1 = $_POST['ac_type1'];
    $stateid = $_POST['stateid'];
    $placeid = $_POST['placeid'];
    $pincode = $_POST['pincode'];
    $country = $_POST['country'];

    if ($keyvalue  == 0) {
 
        $sql_insert = "insert into m_customer set customer_name = '$customer_nam e',mobile_no='$mobile_no', ac_type1='$ac_type1', 
        country='$country',stateid='$stateid', pincode='$pincode', 
        placeid='$placeid',email_id = '$email_id',customer_address='$customer_address', gst_no = '$gst_no',pan_no = '$pan_no', opn_balnc = '$opn_balnc', opn_balnc_date = '$opn_balnc_date', acc_holder_name = '$acc_holder_name', acc_no = '$acc_no', ifsc_code = '$ifsc_code', bank_name = '$bank_name', branch_name = '$branch_name', acc_type = '$acc_type', party_type = '$party_type', comp_id = '$comp_id', created_date = '$currentdate'";

       mysqli_query($connection, $sql_insert);
        
            echo "<script>location='$pagename?action=1'</script>";
    
    } else {
        $sql_insert = "Update m_customer set customer_name = '$customer_name',mobile_no='$mobile_no', ac_type1='$ac_type1', 
        country='$country',stateid='$stateid', pincode='$pincode', 
        placeid='$placeid',email_id = '$email_id',customer_address='$customer_address', gst_no = '$gst_no',pan_no = '$pan_no', opn_balnc = '$opn_balnc', opn_balnc_date = '$opn_balnc_date', acc_holder_name = '$acc_holder_name', acc_no = '$acc_no', ifsc_code = '$ifsc_code', bank_name = '$bank_name', branch_name = '$branch_name', acc_type = '$acc_type', party_type = '$party_type', comp_id = '$comp_id', created_date = '$currentdate' where customer_id ='$keyvalue'";

       mysqli_query($connection, $sql_insert);
        echo "<script>location='$pagename?action=2'</script>";
    }
}

?>
<!doctype html>
<html>

<head>

    <?php include("../include/top_files.php"); ?>
    <?php include("alerts/alert_js.php"); ?>

    <script>
        $(function() {

            $('#start_date').datepicker({
                dateFormat: 'dd-mm-yy'
            }).val();
            $('#end_date').datepicker({
                dateFormat: 'dd-mm-yy'
            }).val();

        });
    </script>

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
                                <h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
                                <?php include("../include/page_header.php"); ?>
                            </div>

                            <form method="post" action="" class='form-horizontal' onSubmit="return checkinputmaster('empname al,designation,mob1 nu')" enctype="multipart/form-data">
                                <div class="control-group">
                                    <table>
                                        <tr>
                                            <td colspan="4" class="text-error"><strong><?php echo $duplicate; ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Party Type <span style="color:#F00">*</span></td>
                                            <td width="23%">

                                                <select name="party_type" id="party_type" tabindex="1" class='select2-me' style="width:220px;">
                                                    <option value="">Select</option>
                                                    <option value="Customer">Customer</option>
                                                    <option value="Supplier"> Supplier</option>
                                                    <option value="Customer/Supplier">Both</option>
                                                </select>
                                                <script>
                                                    document.getElementById('party_type').value = '<?php echo $party_type; ?>';
                                                </script>
                                            </td>
                                            <td width="20%">Party Name <span style="color:#F00">*</span></td>
                                            <td width="17%">

                                                <input type="text" name="customer_name" id="customer_name" placeholder="Enter Name" tabindex="2" class="form-control" value="<?php echo $customer_name; ?>" required>

                                            </td>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="18%">Mobile No. </td>
                                            <td width="23%">
                                                <input type="number" name="mobile_no" id="mobile_no" placeholder="Contact No." tabindex="3" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" value="<?php echo $mobile_no; ?>" required>
                                            </td>
                                            <td width="18%" valign="top">State</td>
                                            <td valign="top">
                                                <!--<input class="frmsave formbox " type="hidden" name="bloodgroup" id="bloodgroup" data-type="select" value="<?php // echo $; 
                                                                                                                                                                ?>" />-->
                                                <select name="stateid" id="stateid" tabindex="4" class='select2-me' style="width:220px;" onchange="getchange();">
                                                    <option value="">Select</option>
                                                    <?php

                                                    $sql = mysqli_query($connection, "select * from m_state  order by statename");
                                                    while ($row = mysqli_fetch_array($sql)) {

                                                    ?>
                                                        <option value="<?php echo $row['stateid']; ?>"><?php echo $row['statename']; ?> </option>

                                                    <?php } ?>

                                                </select>

                                                <script>
                                                    document.getElementById('stateid').value = '<?php echo $stateid; ?>';
                                                </script>
                                            </td>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td style="display: none;">City</td>
                                            <td style="display: none;"><input class="frmsave formbox" type="text" name="esicno" id="esicno" maxlength="20" tabindex="5" value="<?php echo $esicno; ?>"></td>
                                            <td>City</td>
                                            <td>
                                                <select name="placeid" id="placeid" tabindex="5" class="select2-me" style="width:220px;">
                                                    <option value="">Select</option>

                                                    <?php
                                                    $sql = mysqli_query($connection, "select * from m_place order by placename");
                                                    while ($row = mysqli_fetch_array($sql)) {
                                                    ?>
                                                        <option value="<?php echo $row['placeid']; ?>"><?php echo $row['placename']; ?></option>
                                                    <?php } ?>



                                                </select>
                                                <script>
                                                    document.getElementById('placeid').value = '<?php echo $placeid; ?>';
                                                </script>
                                            </td>
                                            <td>Address</td>
                                            <td>
                                                <input type="text" name="customer_address" id="customer_address" placeholder="Customer Address" tabindex="6" class="form-control" value="<?php echo $customer_address; ?>" required>

                                            </td>
                                        </tr>
                                        <tr>

                                            <td>Pin Code</td>
                                            <td>

                                                <input type="text" name="pincode" id="pincode" placeholder="Pin Code" tabindex="7" class="form-control" value="<?php echo $pincode; ?>">
                                            </td>
                                            <td>Email ID</td>
                                            <td>
                                                <input type="email" name="email_id" id="email_id" placeholder="Email Id" tabindex="9" class="form-control" value="<?php echo $email_id; ?>">


                                            </td>

                                        </tr>

                                        <tr>

                                            <td valign="top" style="display: none;">Medical Expire Date<span class="red">(dd-mm-yyyy)</span></td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" type="text" name="medicalexpire" id="medicalexpire" placeholder="dd-mm-yyyy" data-date="true" tabindex="12" value="<?php echo $medicalexpire; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td valign="top">GST No.</td>
                                            <td valign="top"> <input type="text" name="gst_no" id="gst_no" placeholder="GST Number" tabindex="10" class="form-control" value="<?php echo $gst_no; ?>" maxlength="15">
                                            </td>
                                            <td valign="top">PAN No.<span style="color:#F00">*</span></td>
                                            <td valign="top"> <input type="text" name="pan_no" id="pan_no" placeholder="Pan Number" tabindex="11" class="form-control" value="<?php echo $pan_no; ?>" maxlength="10">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td valign="top">Account Details</td>
                                            <td>
                                                <select name="ac_type1" id="ac_type1" tabindex="12" class='select2-me' style="width:220px;">

                                                    <option value="">select</option>
                                                    <option value="Debit">Debit</option>
                                                    <option value="Credit">Credit</option>
                                                </select>
                                                <script>
                                                    document.getElementById('ac_type1').value = '<?php echo $ac_type1; ?>';
                                                </script>
                                            </td>
                                            <td>Opening Balance</td>
                                            <td>
                                                <input type="text" name="opn_balnc" id="opn_balnc" placeholder="Opening Balance" tabindex="13" class="form-control" value="<?php echo $opn_balnc; ?>">

                                            </td>
                                            <td valign="top" style="display: none;">Opening Balance Date</td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" name="acntno" type="text" id="acntno" maxlength="20" tabindex="19" value="<?php echo $acntno; ?>" /></td>


                                        </tr>
                                        <tr>
                                            <td valign="top" style="display: none;">Petrol Allowance</td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" name="petrolallownce" type="text" id="petrolallownce" tabindex="17" value="<?php echo $petrolallownce; ?>" /></td>
                                            <td valign="top" style="display: none;">Mobile Allowance</td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" name="moballownce" type="text" id="moballownce" tabindex="18" value="<?php echo $moballownce; ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="display: none;">PF(%)</td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" name="pf_per" type="text" id="pf_per" tabindex="19" value="<?php echo $pf_per; ?>" /></td>
                                            <td valign="top" style="display: none;">ESIC(%)</td>
                                            <td valign="top" style="display: none;"><input class="frmsave formbox" name="esic_per" type="text" id="esic_per" tabindex="20" value="<?php echo $esic_per; ?>" /></td>
                                        </tr>
                                        <tr>


                                            <td valign="top">Opening Balance Date</td>
                                            <td> <input type="date" name="opn_balnc_date" id="opn_balnc_date" placeholder="DD/MM/YYYY" tabindex="14" class="form-control" value="<?php echo $opn_balnc_date; ?>">
                                            </td>
                                            <!-- <td valign="top">Aadhar No.</td>
                                            <td valign="top"><input type="file" name="upload_aadhar" id="upload_aadhar" placeholder="Text input" class="form-control" value="<?php echo $upload_aadhar; ?>"></td> -->

                                        </tr>
                                        <!-- <tr>

                                            <td valign="top">Licence No.</td>
                                            <td valign="top"> <input type="file" name="upload_licence" id="upload_licence" placeholder="Text input" class="form-control" value="<?php echo $upload_licence; ?>">
                                            </td>
                                        </tr> -->
                                        <tr>
                                            <td colspan="4" style="line-height:5">
                                                <input type="submit" name="submit" id="submit" value="Save" class="btn btn-success" onClick="return checkinputmaster('consigneename,placeid')" tabindex="20" style="margin-left:515px">

                                                <input type="button" value="Cancel" class="btn btn-danger" onClick="document.location.href='<?php echo $pagename; ?>';" tabindex="9" />


                                                <input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $tblpkey_value; ?>">
                                            </td>
                                        </tr>
                                    </table>



                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <!--   DTata tables -->
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-bordered">
                            <div class="box-title">
                                <h3><i class="icon-table"></i><?php echo $modulename; ?> Details</h3>
                            </div>
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin table-striped table-bordered dataTable dataTable-colvis">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Customer Name</th>
                                            <th>Party Type</th>
                                            <th>Mobile No.</th>
                                            <th>City</th>
                                            <th>GST No.</th>
                                            <th>Opening Balance</th>
                                            <th>Opening Balance Date</th>
                                            <th class='hidden-480'>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sn = 1;
                                        if ($comp_id == 10) {
                                            $sql = mysqli_query($connection, "Select * from  $tblname  where comp_id='$comp_id'  order by $tblpkey desc");
                                        } else {
                                            //echo "Select * from  $tblname  where comp_id='$comp_id' && gst_no='' order by $tblpkey desc";
                                            $sql = mysqli_query($connection, "Select * from  $tblname  where comp_id='$comp_id' && gst_no='' order by $tblpkey desc");
                                        }
                                        while ($row = mysqli_fetch_array($sql)) {
                                            $place_name = $cmn->getvalfield($connection, "m_place", "place_name", "place_id=$row[place_id]");
                                            $placename = $cmn->getvalfield($connection, "m_place", "placename", "placeid='$row[placeid]'");

                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?></td>
                                                <td><?php echo $row['customer_name']; ?></td>
                                                <td><?php echo $row['party_type']; ?></td>
                                                <td><?php echo $row['mobile_no']; ?></td>
                                                <td><?php echo $place_name; ?><?php echo $placename; ?></td>
                                                <td><?php echo $row['gst_no']; ?></td>
                                                <td class='hidden-350'><?php echo $row['opn_balnc']; ?></td>
                                                <td class='hidden-1024'><?php echo dateformatindia($row['opn_balnc_date']); ?></td>
                                            

                                                <td class='hidden-480'>
														<a href="?editid=<?php echo ucfirst($row['customer_id']); ?>"><img src="../img/b_edit.png" title="Edit"></a>
														&nbsp;&nbsp;&nbsp;
														<a onClick="funDel('<?php echo $row['customer_id']; ?>')"><img src="../img/del.png" title="Delete"></a>
													</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
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

        function getchange() {

            // alert("okk");
            var stateid = document.getElementById("stateid").value;

            // alert(stateid);
            jQuery.ajax({

                type: 'POST',
                url: 'ajax_state.php',
                data: 'stateid=' + stateid,
                dataType: 'html',
                success: function(data) {
                    // alert(data);
                    jQuery('#placeid').html(data);
                    $('select').formSelect({
                        dropdownOptions: data
                    });
                }

            });
        }
    </script>

    ?>

</html>
<?php
mysqli_close($connection);
?>