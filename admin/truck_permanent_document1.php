<?php error_reporting(0);
include("dbconnect.php");
$tblname = "truck_permanent_document";
$tblpkey = "jobid";
$pagename = "truck_permanent_document.php";
$modulename = "Truck Permanent Document";
$imgpath = "upload/";
//print_r($_SESSION);

if (isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = 0;


if ($_GET['t']) {
	$truckid = addslashes(trim($_GET['t']));
	$ownerid = $cmn->getvalfield($connection, "m_truck", "ownerid", "truckid = '$truckid'");
	$sql = mysqli_query($connection, "select * from truck_maintenance where truckid = '$truckid' && status=1");
	$row = mysqli_fetch_assoc($sql);
	$permitissue = $row["permitissue"];
	$permitexpiry = $row["permitexpiry"];
	$fitnessissue = $row["fitnessissue"];
	$fitnessexpiry = $row["fitnessexpiry"];
	$insuranceissue = $row["insuranceissue"];
	$insuranceexpiry = $row["insuranceexpiry"];
	$roadtaxissue = $row["roadtaxissue"];
	$roadtaxexpiry = $row["roadtaxexpiry"];
	$pollutionissue = $row["pollutionissue"];
	$pollutionexpiry = $row["pollutionexpiry"];
	$national_permit_issue = $row["national_permit_issue"];
	$national_permit_date = $row["national_permit_date"];
	$khanij_reg_issue = $row["khanij_reg_issue"];
	$khanij_reg_exp = $row["khanij_reg_exp"];

	$permitdocument  = $cmn->getvalfield($connection, "truck_maintenance", "permitdocument", "truckid = '$truckid'  && permitdocument !='' order by tmaintance_id");
	$fitnessdocument  = $cmn->getvalfield($connection, "truck_maintenance", "fitnessdocument", "truckid = '$truckid'  && fitnessdocument !='' order by tmaintance_id");
	$insurancedocument  = $cmn->getvalfield($connection, "truck_maintenance", "insurancedocument", "truckid = '$truckid'  && insurancedocument !='' order by tmaintance_id");
	$roadtaxdocument  = $cmn->getvalfield($connection, "truck_maintenance", "roadtaxdocument", "truckid = '$truckid'  && roadtaxdocument !='' order by tmaintance_id");
	$pollutiondocument  = $cmn->getvalfield($connection, "truck_maintenance", "pollutiondocument", "truckid = '$truckid'  && pollutiondocument !='' order by tmaintance_id");
	$nationalpermitdoc  = $cmn->getvalfield($connection, "truck_maintenance", "nationalpermitdoc", "truckid = '$truckid'  && nationalpermitdoc !='' order by tmaintance_id");
	$khanijpermitdoc  = $cmn->getvalfield($connection, "truck_maintenance", "khanijpermitdoc", "truckid = '$truckid'  && khanijpermitdoc !='' order by tmaintance_id");
}



if (isset($_POST['submit'])) {
	$truckid = trim(addslashes($_POST["truckid"]));
	$permitissue = $cmn->dateformatusa($_POST["permitissue"]);
	$permitexpiry = $cmn->dateformatusa($_POST["permitexpiry"]);
	$fitnessissue = $cmn->dateformatusa($_POST["fitnessissue"]);
	$fitnessexpiry = $cmn->dateformatusa($_POST["fitnessexpiry"]);
	$insuranceissue = $cmn->dateformatusa($_POST["insuranceissue"]);
	$insuranceexpiry = $cmn->dateformatusa($_POST["insuranceexpiry"]);
	$roadtaxissue = $cmn->dateformatusa($_POST["roadtaxissue"]);
	$roadtaxexpiry = $cmn->dateformatusa($_POST["roadtaxexpiry"]);
	$pollutionissue = $cmn->dateformatusa($_POST["pollutionissue"]);
	$pollutionexpiry = $cmn->dateformatusa($_POST["pollutionexpiry"]);
	$national_permit_issue = $cmn->dateformatusa($_POST["national_permit_issue"]);
	$national_permit_date = $cmn->dateformatusa($_POST["national_permit_date"]);

	$khanij_reg_issue = $cmn->dateformatusa($_POST["khanij_reg_issue"]);
	$khanij_reg_exp = $cmn->dateformatusa($_POST["khanij_reg_exp"]);
	$status = 1;

	$permitdocument = $_FILES['permitdocument'];
	$fitnessdocument = $_FILES['fitnessdocument'];
	$insurancedocument = $_FILES['insurancedocument'];
	$roadtaxdocument = $_FILES['roadtaxdocument'];
	$pollutiondocument = $_FILES['pollutiondocument'];
	$nationalpermitdoc = $_FILES['nationalpermitdoc'];
	$khanijpermitdoc = $_FILES['khanijpermitdoc'];

	//	mysqli_query($connection,"update truck_maintenance set status='0' where truckid='$truckid'");

	$count = $cmn->getvalfield($connection, "truck_maintenance", "tmaintance_id", "truckid='$truckid'");

	if ($count != '') {
		$tmaintance_id = $count;

		mysqli_query($connection, "update  truck_maintenance set truckid='$truckid',permitissue='$permitissue',permitexpiry='$permitexpiry',
				fitnessissue='$fitnessissue',fitnessexpiry='$fitnessexpiry',insuranceissue='$insuranceissue',sessionid='$sessionid',				insuranceexpiry='$insuranceexpiry',roadtaxissue='$roadtaxissue',roadtaxexpiry='$roadtaxexpiry',khanij_reg_issue='$khanij_reg_issue',
				khanij_reg_exp='$khanij_reg_exp',pollutionissue='$pollutionissue',pollutionexpiry='$pollutionexpiry',national_permit_issue='$national_permit_issue',
				national_permit_date='$national_permit_date',status='$status',ipaddress='$ipaddress',createdate='$createdate' where tmaintance_id='$tmaintance_id'");
	} else {
		mysqli_query($connection, "insert into truck_maintenance set truckid='$truckid',permitissue='$permitissue',permitexpiry='$permitexpiry',
				fitnessissue='$fitnessissue',fitnessexpiry='$fitnessexpiry',insuranceissue='$insuranceissue',sessionid='$sessionid',				insuranceexpiry='$insuranceexpiry',roadtaxissue='$roadtaxissue',roadtaxexpiry='$roadtaxexpiry',khanij_reg_issue='$khanij_reg_issue',
				khanij_reg_exp='$khanij_reg_exp',pollutionissue='$pollutionissue',pollutionexpiry='$pollutionexpiry',national_permit_issue='$national_permit_issue',
				national_permit_date='$national_permit_date',status='$status',ipaddress='$ipaddress',createdate='$createdate'");
		$tmaintance_id = mysqli_insert_id($connection);
	}




	if ($_FILES['permitdocument']['tmp_name'] != '') {

		$uploaded_filename = uploadImage($imgpath, $permitdocument);
		mysqli_query($connection, "update truck_maintenance set permitdocument='$uploaded_filename' where tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['fitnessdocument']['tmp_name'] != '') {
		$uploaded_filename = uploadImage($imgpath, $fitnessdocument);

		echo	mysqli_query($connection, "update truck_maintenance set fitnessdocument='$uploaded_filename' where tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['insurancedocument']['tmp_name'] != '') {
		$uploaded_filename = uploadImage($imgpath, $insurancedocument);
		mysqli_query($connection, "update truck_maintenance set insurancedocument='$uploaded_filename' where tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['roadtaxdocument']['tmp_name'] != '') {
		$uploaded_filename = uploadImage($imgpath, $roadtaxdocument);
		mysqli_query($connection, "update truck_maintenance set roadtaxdocument='$uploaded_filename' where tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['pollutiondocument']['tmp_name'] != '') {
		$uploaded_filename = uploadImage($imgpath, $pollutiondocument);
		mysqli_query($connection, "update truck_maintenance set pollutiondocument='$uploaded_filename' where tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['nationalpermitdoc']['tmp_name'] != '') {

		$uploaded_filename = uploadImage($imgpath, $nationalpermitdoc);
		mysqli_query($connection, "update truck_maintenance set nationalpermitdoc='$uploaded_filename' where  tmaintance_id='$tmaintance_id'");
	}

	if ($_FILES['khanijpermitdoc']['tmp_name'] != '') {

		$uploaded_filename = uploadImage($imgpath, $khanijpermitdoc);
		mysqli_query($connection, "update truck_maintenance set khanijpermitdoc='$uploaded_filename' where  tmaintance_id='$tmaintance_id'");
	}

	echo "<script>location = '$pagename';</script>";
}


?>
<!doctype html>
<html>

<head>
	<?php include("../include/top_files.php"); ?>
	<?php include("alerts/alert_js.php"); ?>


	<style>
		a.selected {
			background-color: #1F75CC;
			color: white;
			z-index: 100;
		}

		.messagepop {
			background-color: #0CF;
			border: 2px solid #000;
			cursor: default;
			display: none;
			border-radius: 5px;
			position: fixed;
			top: 50px;
			right: 0px;
			text-align: left;
			width: 230px;
			z-index: 50;

		}

		.messagepop p,
		.messagepop.div {
			border-bottom: 1px solid #EFEFEF;
			margin: 8px 0;
			padding-bottom: 8px;
		}
	</style>
	<script>
		$(document).ready(function() {
			$("#shortcut_truck").click(function() {
				$("#div_truck").toggle(1000);
			});

		});
	</script>
</head>

<body>
	<!--- short cut form truck --->
	<div class="messagepop pop" id="div_truck">
		<img src="b_drop.png" class="close" onClick="$('#div_truck').toggle(1000);">
		<table width="100%" border="0" class="table table-bordered table-condensed">
			<tr>
				<td><strong style="font-size:14px;color:#F00;">&nbsp;Add New Truck </strong></td>
			</tr>
			<tr>
				<td>&nbsp;<b>Owner Name:</b> </td>
			</tr>
			<tr>
				<td>
					<select name="sc_ownerid" id="sc_ownerid" class="select2-me" style="width:202px;">
						<option value="">--select--</option>
						<?php
						$sql_sc = "select * from m_truckowner";
						$res_sc = mysqli_query($connection, $sql_sc);
						while ($row_sc = mysqli_fetch_array($res_sc)) { ?>
							<option value="<?php echo $row_sc['ownerid']; ?>"><?php echo $row_sc['ownername']; ?></option>
						<?php
						}
						?>
					
					</select>
				</td>
			</tr>
			<tr>
				<td>&nbsp;<b>Truck Number:</b> </td>
			</tr>
			<tr>
				<td><input type="text" name="sc_truckno" id="sc_truckno" style="width:190px;" /></td>
			</tr>
			<tr>
				<td><input type="submit" value="Save" class="btn-small btn-success" onClick="ajax_save_shortcut_truckno('sc_ownerid','sc_truckno');" /></td>
			</tr>
		</table>
	</div>

	<!-- The Modal -->
	<div aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in" id="myModal">
		<div class="modal-header">
			<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>

			<h3 id="myModalLabel"></h3>
		</div>
		<div class="modal-body">
			<!-- <center><span id="getotp"></span></center>  -->
			<h4>Upload Document</h4>
			<p>
			<table>
				<tr>

					<form action="" method="POST" enctype="multipart/form-data" id="photoform">
						<input type="hidden" name="docid" id="docid">
						<input type="hidden" id="truckid" name="truckid" value="<?php echo $truckid; ?>">

						<input type="file" name="upload_photo" id="upload_photo<?php echo $res_cat['docid']; ?>" value=""><span><img src="uploaded/img/<?php echo $upload_photo ?>" width="50px;" alt="" /></span>

						<button type="submit" name="upload" class="btn btn-primary">
							Upload</button>
					</form>

				</tr>
				<input type="hidden" id="ref_id" value="">
			</table>
			</p>
		</div>
		<div class="modal-footer">
			<button data-dismiss="modal" class="btn">Close</button>
		</div>
	</div><!--#myModal-->


	<!------end here ---->
	<?php include("../include/top_menu.php"); ?> <!--- top Menu----->

	<div class="container-fluid" id="content">

		<div id="main">
			<div class="container-fluid">
				<?php //include("../include/showbutton.php"); 
				?>
				<!--  Basics Forms -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box">
							<div class="box-title">
								<?php include("alerts/showalerts.php"); ?>
								<h3><i class="icon-edit"></i><?php echo $modulename; ?></h3>
								<?php include("../include/page_header.php"); ?>
							</div>
							<div class="box-content">
								<form method="post" action="" class='form-horizontal'>
									<div class="control-group">
										<table>
											<tr>

												<td><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span>&nbsp;&nbsp;</td>

											</tr>
											<tr>

												<td width="13%"><select name="truckid" class="input-large select2-me" id="truckid1" onChange="getTruck(this.value);">
														<option value="">-Select-</option>
														<?php
														$sql_cat = mysqli_query($connection, "Select truckid,truckno from  m_truck order by truckid desc");
														if ($sql_cat) {
															while ($res_cat = mysqli_fetch_array($sql_cat)) {
														?>
																<option value="<?php echo $res_cat['truckid']; ?>"> <?php echo $res_cat['truckno']; ?></option>
														<?php
															}
														}
														?>
													</select>
													<script>
														document.getElementById('truckid1').value = "<?php echo $_GET['t']; ?>";

														function getTruck(truckid) {
															location = 'truck_permanent_document.php?t=' + truckid;
														}
													</script>
												</td>
											</tr>
										</table>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>

				<?php
				if ($truckid != "") {
				?>
					<div class="row-fluid">
						<div class="span12">
							<div class="box">
								<div class="box-title">
									<?php include("alerts/showalerts.php"); ?> <?php include("../include/page_header.php"); ?>

									<h3><i class="icon-edit"></i>Save Permanent Document</h3>

								</div>
								<div class="box-content">

									<input type="hidden" name="truckid" id="truckid" value="<?php echo $truckid; ?>">
									<div class="control-group">

										<table class="table table-condensed">
											<tr>
												<td width="10%"><strong>Owner Name</strong> <strong>:</strong><span class="red">*</span></td>
												<td width="18%"><span class="red"><?Php echo ucfirst($cmn->getvalfield($connection, " m_truckowner", "ownername", "ownerid = '$ownerid'")); ?></span></td>
												<td width="14%"><strong>Truck No.</strong> <strong>:</strong><span class="red">*</span></td>
												<td width="12%"><span class="red"><?Php echo $cmn->getvalfield($connection, " m_truck", "truckno", "truckid = '$truckid'"); ?></span></td>
												<td width="13%"></td>
												<td width="33%">

												</td>
											</tr>
											<tr>

												<td><strong>Documents</strong> <strong>:</strong><span class="red">*</span></td>
												<td width="18%"><strong>Issue Date</strong> <span class="red">*</span></td>
												<td colspan="2"><strong> Expiry Date *</strong> <strong>:</strong><span class="red">*</span></td>
												<td>

												</td>
												<td></td>

											</tr>
											<?php
											$sql_cat = mysqli_query($connection, "Select docid,doc_name from  doc_category_master order by docid asc");
											if ($sql_cat) {
												while ($res_cat = mysqli_fetch_array($sql_cat)) {
													$docid = $res_cat['docid'];

													$issuedate = dateformatindia($cmn->getvalfield($connection, "truckupload", "issuedate", "docid='$docid' && truckid = '$truckid' "));
													$expiry = dateformatindia($cmn->getvalfield($connection, "truckupload", "expiry", "docid='$docid' && truckid = '$truckid' "));
													$upload_photo = $cmn->getvalfield($connection, "truckupload", "uploaddocument", "docid='$docid' && truckid = '$truckid' ");
													 $tmaintance_id = $cmn->getvalfield($connection, "truckupload", "tmaintance_id", " docid = '$docid' && truckid='$truckid'");

											?>

													<tr>

														<td><strong><?php echo $res_cat['doc_name']; ?></strong>
	


														</td>

														<td width="18%"><input type="text" name="issuedate" id="permitissue<?php echo $res_cat['docid']; ?>" onChange="getdate(<?php echo $res_cat['docid']; ?>);" class="input-small maskdate" value="<?php echo $issuedate; ?>" autocomplete="off" tabindex="1"></td>
														<td colspan=""><input type="text" name="expiry" id="permitexpiry<?php echo $res_cat['docid']; ?>" onChange="getdate(<?php echo $res_cat['docid']; ?>);" class="input-small maskdate" value="<?php echo $expiry; ?>" autocomplete="off" tabindex="2"></td>

														<td colspan="3">
															<button onclick="getModal(<?php echo $res_cat['docid']; ?>);" class="btn btn-primary">
																Upload</button>

															<div id="existingphoto">  <?php if($upload_photo!=''){ ?><a href="uploaded/img/<?php echo $upload_photo; ?>"    target="_blank"> <strong style="color:red"> View </strong></a><?php } ?></div>
															
															<div id="newphoto<?php echo $res_cat['docid'];?>" ></div>
														
											   
											    
											    <!--<button class="btn btn-small btn-green" disabled>-->
															<!--					View <i class="fa fa-download"></i></button>-->
											    
												</td>

														
									</div>

									</td>
									
									</tr>
							<?php
												}
											}
							?>




							</table>

							<table>
								<tr>
									<!-- <td width="627"><span class="control-group">
											<div class="form-actions">
												<input type="submit" name="submit" id="submit" value="Save" class="btn btn-primary" onClick="return checkinputs();" tabindex="13">

												<input type="button" value="Reset" class="btn btn-success" onClick="document.location.href='<?php echo $pagename; ?>';" />
											</div>

											<input type="hidden" name="<?php echo $tblpkey; ?>" id="<?php echo $tblpkey; ?>" value="<?php echo $jobid; ?>">
										</span></td> -->
								</tr>
							</table>
								</div>

							</div>

						</div>
					</div>
			</div>
		<?php
				} ?>




		</div>
	</div>


	</div>
	<script>
		function funDel(id) {
			//alert(id);   
			tblname = '<?php echo $tblname; ?>';
			tblpkey = '<?php echo $tblpkey; ?>';
			pagename = '<?php echo $pagename; ?>';
			modulename = '<?php echo $modulename; ?>';
			//alert(tblpkey); 
			if (confirm("Are you sure! You want to delete this record.")) {
				//alert('id=' + id + '&tblname=' + tblname + '&tblpkey=' + tblpkey + '&pagename=' + pagename + '&modulename=' +modulename);
				$.ajax({
					type: 'POST',
					url: '../ajax/delete.php',
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





		function getdate(docid) {

			var permitissue = document.getElementById("permitissue" + docid).value;
			var permitexpiry = document.getElementById("permitexpiry" + docid).value;
			// alert(permitexpiry);
			var truckid = document.getElementById("truckid").value;


			jQuery.ajax({
				type: 'POST',
				url: 'getdate_truckowner.php',
				data: 'permitissue=' + permitissue + '&permitexpiry=' + permitexpiry + '&docid=' + docid + '&truckid=' + truckid,
				success: function(data) {
					//alert(data);


				}
			}); //ajax close


		}

		//below code for date mask
		jQuery(function($) {
			$(".maskdate").mask("99-99-9999", {
				placeholder: "dd-mm-yyyy"
			});

		});



		$(document).ready(function(e) {


			$("#photoform").on('submit', (function(e) {
				e.preventDefault();
				$.ajax({


					url: "ajax_savephoto.php",

					type: "POST",

					data: new FormData(this),

					contentType: false,

					cache: false,

					processData: false,

					success: function(data) {
					
						alert('Document hasbeen uploaded Successfully');
						//href='truck_permanent_document.php';
						jQuery("#myModal").modal('hide');
						//alert(data);
						showphoto(data);
					    
						//showTick(data);
					
					},
					//window.location.hr
					error: function()

					{

					}

				});

			}));

		});
		
		function showphoto(tmaintance_id){
		   
		    arr=tmaintance_id.split(',');				
				var gdoc= arr[0];
				var gtm=arr[1];
		   
		    	jQuery.ajax({
				type: 'POST',
				url: 'showphoto.php',
				data: 'tmaintance_id=' + gtm,
				success: function(data) {
				   
				    	jQuery("#existingphoto").hide();
				    		jQuery("#newphoto"+gdoc).html(data);
				// 	$("#showphotosaved").load(location.href + " #showphotosaved");

				}
			}); //ajax close

		    
		}


		function getModal(docid) {
			if (docid != '') {
				jQuery("#docid").val(docid);

				jQuery("#myModal").modal('show');
				//myModal
			}
		}
	</script>

</html>

<?php
mysqli_close($connection);
?>