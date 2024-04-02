<?php error_reporting(0);
include("dbconnect.php");
$tblname = 'returnbill';
$tblpkey = 'billid';
$pagename  ='return_billing_report.php';
$modulename ="Bill Generation";




?>
<!doctype html>
<html>
<head>
	
<?php include("../include/top_files.php"); ?>
</head>

<body data-layout-topbar="fixed">

<?php include("../include/top_menu.php"); ?>
		
           		
						
						<div class="box-title">
								<h3><i class="icon-table"></i><?php echo $modulename; ?> Details  </h3>
							</div>	
							
                           	<table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered" width="100%">
									<thead>
										<tr>
                                            <th width="4%">Sno</th>
                                            <th width="10%">Date</th>
                                           <th width="10%">Bill No</th>
                                            <th width="10%">Type</th>
                                             <th width="15%">Consignor Name</th>
                                              <th width="15%">Consignee Name</th>
                                            <th width="10%">Session</th>
                                            <th width="10%">Bill Amount</th>
                                           
                                            <th width="25%" class='hidden-480'>Action</th>
										</tr>
									</thead>
                                    <tbody>
                                    <?php
									$slno=1;
									
									$sel = "select * from returnbill where billdate > '2017-06-30' && sessionid='$_SESSION[sessionid]' && compid='$compid' order by billid desc ";
									$res =mysqli_query($connection,$sel);
									while($row = mysqli_fetch_array($res))
									{
										
										if($row['ispaid'] == '0')
										$status = "<span class='red'><strong>Unpaid</strong></span>";
										else
										
										$status = "<span style='color: green;'><strong>Paid</strong></span>";
										$billamount = $cmn->get_total_billing_amt1($connection,$row['billid']);
										$consignorname= $cmn->getvalfield($connection,"m_consignor","consignorname","consignorid='$row[consignorid]'"); 
                                         $consigneename=  $cmn->getvalfield($connection,"m_consignee","consigneename","consigneeid='$row[consigneeid]'"); 
									 
									?>
										<tr tabindex="<?php echo $slno; ?>" class="abc">
                                            <td><?php echo $slno; ?></td>
                                            <td><?php echo $cmn->dateformatindia(ucfirst($row['billdate']));?></td>
                                           <td><?php echo ucfirst($row['billno']);?></td>
                                            <td><?php echo ucfirst($row['consi_type']);?></td>
                                            <td><?php echo $consignorname;?></td>
                                           <td><?php echo $consigneename;?></td>
                                            
                                           <td><?php echo $cmn->getvalfield($connection,"m_session","session_name","sessionid='$_SESSION[sessionid]'"); ?></td>
                                           <td><?php echo number_format($billamount,2);?></td>
                                           
                                           
                                           
                                           <td class='hidden-480'>
                                           <a href= "billing_entry_emami.php?edit=<?php echo $row['billid'];?>&consi_type=<?php echo $row['consi_type'];?>"><img src="../img/b_edit.png" title="Edit"></a>
                                           &nbsp;&nbsp;&nbsp;
                                           <?php
										   if($row['ispaid'] == '0')
										   {
										   ?>
                                           <a onClick="funDel('<?php echo $row['billid']; ?>')" ><img src="../img/del.png" title="Delete"></a>
                                           <?php
										   }?>
										   
										    &nbsp;&nbsp;&nbsp;
                                            <?php if($gstvalid=="Yes"){ ?>
                                           <a href= "pdf_nogstprint_gst_billing_demo_emami.php?p=<?php echo ucfirst($row['billid']);?>" class="btn btn-info" target="_blank">PDF</a>
                                           <?php } else {?>
                                            <a href= "pdf_nogstprint_gst_billing_demo_emami.php?p=<?php echo ucfirst($row['billid']);?>" class="btn btn-info" target="_blank">PDF</a>
                                           <?php } ?>
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
function getType(data){
	location='billing_entry_emami.php?consi_type='+data;
/*	if(data=='Consignor'){
		$("#d1").show();
		$("#d2").show();
		$("#d3").hide();
		$("#d4").hide();
	}else{
		$("#d1").hide();
		$("#d2").hide();
		$("#d3").show();
		$("#d4").show();
	}*/
}
function setTotal()
{
	istaxable = document.getElementById('istaxable').value;
	grossamt= parseFloat(document.getElementById("grossamt").innerHTML);
	if(isNaN(grossamt)) { grossamt = 0; }
	
	var ulamt=0;
	$(".ulamt").each(function(){
	amt = parseFloat($(this).val());
	if(isNaN(amt)) { amt = 0; }
	ulamt = ulamt + amt;
	});
	
	//alert(grossamt);
	grossamt = grossamt - ulamt;
	
	if(istaxable == "1")
	{
		cgst_percent=document.getElementById("cgst_percent").value;
		sgst_percent = document.getElementById('sgst_percent').value;
		
		//alert(krishi_cess);
		if(cgst_percent == "")
		cgst_percent = 0;
		
		if(sgst_percent == "")
		sgst_percent = 0;
			if(!isNaN(cgst_percent) && !isNaN(sgst_percent))
			{
		cgst_percent = (parseFloat(cgst_percent) * parseFloat(grossamt)) /100;
		sgst_percent = (parseFloat(sgst_percent) * parseFloat(grossamt)) /100;
	
		$("#taxableamt").html(cgst_percent.toFixed(2));
		$("#servtaxamt").html(sgst_percent.toFixed(2));
		
		netamt = parseFloat(grossamt) +  parseFloat(cgst_percent) +  parseFloat(sgst_percent) +
		 parseFloat(ulamt);
		
		$("#netamt").html(Math.round(netamt).toFixed(2));
		$("#net").val(Math.round(netamt).toFixed(2));
		}
	}
	else
	{
		netamt = parseFloat(grossamt);
		$("#servtaxamt").html(0);
		$("#taxableamt").html(0);
	    $("#netamt").html(Math.round(netamt).toFixed(2));
		$("#net").val(Math.round(netamt).toFixed(2));
	}
}
function checkinputs()
{
	var x = document.getElementById("bidding_entrylist").rows.length;
	var net = parseFloat(document.getElementById('net').value);
	
	

	if(x == 1)
	{
		alert("Please add billties");
		$('#bid_id').select2('focus');
		return false;
	}
	else if($("#billno").val() == "")
	{
		alert("Please enter bill no.");
		$("#billno").focus();
		return false;
	}
	else if($("#billdate").val() == "")
	{
		alert("Please enter bill date");
		$("#billdate").focus();
		return false;
	}	
	else if(net==0)
	{
		alert("Bill Amount Can't Be Zero");
		//$("#billdate").focus();
		return false;
	}

	
}
function funremovebidding_entry()
{
	removelist=document.getElementById("removelist").value ;
	addlist=document.getElementById("addlist").value ;
	remarr = removelist.split(",");
	addarr = addlist.split(",");
	grossamt = parseFloat($("#grossamt").html());
	if(confirm("Are you sure! You want to remove this billties."))
	{
		
		//alert(remarr.length);
		len = remarr.length;
		for(var i=0; i< len ; i++)
		{
			rem =remarr[''+i];
			//alert(rem);
			 var index = addarr.indexOf(rem);
				  
					if (index != -1) {
							addarr[index] = 0;
						}
						remamt = $("#amt"+rem).html();
						//alert(""+remamt);

						grossamt = parseFloat(grossamt) - parseFloat($("#amt"+rem).html());
						
		}
		$("#grossamt").html(""+parseFloat(grossamt).toFixed(2));
		strids = addarr.join();
		document.getElementById("addlist").value = strids;
		document.getElementById("removelist").value = "";
		$("#bidding_entrylist tr input:checked").parents('tr').remove();
		setTotal();
	}
	
}
function checkbidding_entry(bid_id)
{
		addlist=document.getElementById("addlist").value ;
	//alert('addlist');
	addarr = addlist.split(",");
	var index = addarr.indexOf(bid_id);
				  
	if (index != -1) {
		alert("This Bilty already added...");
		$("#bid_id").select2().select2('val','');//for select2 refresh to blank value
		$('#bid_id').select2('focus');
	}
	else
	{
		//alert(bid_id);
		if(bid_id != "")
		{
			$.ajax({
			  type: 'POST',
			  url: '../ajax/check_shrtge_billty_emami.php',
			  data: 'bid_id=' + bid_id ,
			  dataType: 'html',
			  success: function(data){
				//alert(data);
				/*if(data == '1')
					{
						alert("Billty Not Received..");
						$("#bid_id").select2().select2('val','');//for select2 refresh to blank value
						$('#bid_id').select2('focus');
						return false;
					}					
					else */
					 if(data == '5')
					{
						alert("Billty Date is below to  GST");
						$("#bid_id").select2().select2('val','');//for select2 refresh to blank value
						$('#bid_id').select2('focus');
						return false;
					}
					else if(data == '3')
					{
						if(confirm("This Billty has shortage..DO you want to add this ??"))
						{
							addbidding_entry(bid_id);
						}
						else
						{
							$("#bid_id").select2().select2('val','');//for select2 refresh to blank value
							$('#bid_id').select2('focus');
						}
					}
					
					
					else
					{
						addbidding_entry(bid_id);
					}
				}
			
			  });//ajax close		
		}
	}

}

function addbidding_entry(bid_id)
{
	if(bid_id != "")
	{
		grossamt = parseFloat($("#grossamt").html());
	$.ajax({
		  type: 'POST',
		  url: '../ajax/add_bill_emami.php',
		  data: 'bid_id=' + bid_id ,
		  dataType: 'html',
		  success: function(data){
			 //alert(data);
			if(data != "")
				{
					var x = document.getElementById("bidding_entrylist").rows.length;
					arr = data.split("|");
					 var table = document.getElementById("bidding_entrylist");
					var row = table.insertRow(-1);
					row.className = "data-content";
					row.setAttribute("data-val",""+arr[1]);
					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					//var cell6 = row.insertCell(5);
					var cell7 = row.insertCell(5);
					var cell8 = row.insertCell(6);
					var cell9 = row.insertCell(7);
					var cell10 = row.insertCell(8);
					var cell11 = row.insertCell(9);
					var cell12 = row.insertCell(10);
					var cell13 = row.insertCell(11);
					
					cell1.innerHTML = "<input type='checkbox' id='chk"+bid_id+"' value='1' onclick='addids("+bid_id+");'>";
					cell1.style.textAlign="center";
					
					cell2.innerHTML = arr[0];
					cell2.style.fontWeight ="bold";
					
					cell3.innerHTML =  arr[11];
					cell3.style.fontWeight ="bold";
					
					cell4.innerHTML =  arr[14];
					cell4.style.fontWeight ="bold";
					
		cell5.innerHTML = arr[13];
					cell5.style.fontWeight ="bold";
					
	 //cell6.innerHTML =  "<input type='text' id='pur_no"+bid_id+"' name='pur_no"+bid_id+"' class='input-medium'  value='"+arr[10]+"'>";
					//cell6.style.fontWeight ="bold";
					
					cell7.innerHTML =  arr[4];
					cell7.style.fontWeight ="bold";
					
					cell8.innerHTML =  arr[5];
					cell8.style.fontWeight ="bold";
					
					cell9.innerHTML = "<span id ='destwt"+bid_id+"'>"+arr[6]+"</span>";
					cell9.style.fontWeight ="bold";
					
					cell10.innerHTML =  "<span id ='recwt"+bid_id+"'>"+arr[7]+"</span>";
					cell10.style.fontWeight ="bold";
					
					cell11.innerHTML ="<input type='text' id='ulamt"+bid_id+"' name='ulamt[]' class='input-medium ulamt'  value='' onchange = 'setAmt(this.value,"+bid_id+");' >";
					cell11.style.fontWeight ="bold";
					cell11.style.textAlign ="center";
					$('#ulamt'+bid_id).width("50px");
					
					
					
					cell12.innerHTML ="<input type='text' id='rate"+bid_id+"' name='rate[]' class='input-medium rate'  value='"+ parseFloat(arr[8])+"'				onchange = 'setAmt(this.value,"+bid_id+");' >";
					cell12.style.fontWeight ="bold";
					cell12.style.textAlign ="center";
					$('#rate'+bid_id).width("50px");
					
					
					
					
					amt = parseFloat(arr[9]).toFixed(2);//300;//
					cell13.innerHTML =  "<span class='amt_basant' id ='amt"+bid_id+"'>"+amt+"</span>";
					cell13.style.fontWeight ="bold";
					cell13.style.textAlign ="right";
					
					list_old = $("#addlist").val();
					 if(list_old=="")
					   list_old=list_old + bid_id;
					   else
					   list_old=list_old + "," + bid_id;
					    $("#addlist").val(list_old);
						
						grossamt =parseFloat(grossamt) + parseFloat(amt);
						$("#grossamt").html(grossamt.toFixed(2));
						$("#bid_id").select2().select2("val","");
						$('#bid_id').select2('focus');
						setTotal();
				}
				
			}
		
		  });//ajax close
	}
	
}
function setAmt(amt,bid_id)
{
	var ulamt = parseFloat($("#ulamt"+bid_id).val());
	var rate = parseFloat($("#rate"+bid_id).val());
	var recwt = parseFloat($("#recwt"+bid_id).html());
	
	if(isNaN(ulamt)) { ulamt=0; }
	if(isNaN(rate)) { rate=0; }
	if(isNaN(recwt)) { recwt=0; }
	
	amt = (rate * recwt)+ulamt;
	$("#amt"+bid_id).html(amt.toFixed(2));
	
	var grsamt=0;
	$(".amt_basant").each(function(){
	amt = parseFloat($(this).html());
	if(isNaN(amt)) { amt=0; }
	grsamt = grsamt + amt;
	});
	
	
	//grossamt =  parseFloat($("#grossamt").html());
	$("#grossamt").html(grsamt.toFixed(2));
	setTotal();
}
function addids(bid_id)
{

	strids=document.getElementById("removelist").value ;
	if (document.getElementById("chk" + bid_id).checked==true)
			  {
				   if(strids=="")
				   strids=strids + bid_id;
				   else
				   strids=strids + "," + bid_id;
				  
			   }
			   else
			   {
				   arr = strids.split(",");
				  var index = arr.indexOf(''+bid_id);
				  
					if (index !== -1) {
							arr[index] = 0;
						}
						strids = arr.join();
						//alert(strids);

			   }
		  
	// alert(strids);
    	document.getElementById("removelist").value = strids;
}
function save_receive(bid_id)
{
	recievedwt = $("#recievedwt"+bid_id).val();
	recievedate = $("#recievedate"+bid_id).val();
	shortage = $("#shortage"+bid_id).val();
	if(bid_id != "" )
	{
	$.ajax({
		  type: 'POST',
		  url: '../ajax/save_received.php',
		  data: 'bid_id=' + bid_id + '&recievedwt=' + recievedwt + '&recievedate=' + recievedate + '&shortage=' + shortage,
		  dataType: 'html',
		  success: function(data){
			if(data == '0')
				{
					$("#recievedwt"+bid_id).val("");
					$("#recievedate"+bid_id).val("");
					$("#shortage"+bid_id).val("");
				}
			}
		
		  });//ajax close
	}
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
			  //alert(data);
			 // alert('Data Deleted Successfully');
			  location=pagename+'?action=10';
			}
		
		  });//ajax close
	}//confirm close
} //fun close
</script>			
   <script>
	$("#searchbidding_entry").keyup(function()
	{
		searchterm = $("#searchbidding_entry").val().toLowerCase();
		$(".data-content").each(function() {
			value = $(this).attr("data-val").toLowerCase();
			if(value.indexOf(searchterm) == 0)
			$(this).show();
			else
			$(this).hide();
			
		});
	});
	//below code for date mask
jQuery(function($){
   $("#billdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});

setTotal();


function updategatepassno(bid_id)
{
	var gatepassno = document.getElementById('gatepassno'+bid_id).value;
	
	$.ajax({
		  type: 'POST',
		  url: 'updategatepassno.php',
		  data: 'bid_id=' + bid_id+'&gatepassno='+gatepassno,
		  dataType: 'html',
		  success: function(data){
			
			}
		
		  });//ajax close
}

</script>              
		
	</body>

	</html>
