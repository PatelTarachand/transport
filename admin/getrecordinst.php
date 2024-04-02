<?php error_reporting(0);
include("dbconnect.php");
$noofinst = trim(addslashes($_REQUEST['noofinst']));
$if_id= trim(addslashes($_REQUEST['if_id']));


if($if_id==0)
{
?>
<table width="100%"> 
                                       <tr>
                                       	<td width="4%"><strong>Sn</strong></td>
                                        <td width="17%"><strong>Amount</strong> <strong>:</strong></td>
                                        <td width="17%"><strong>Due Date :</strong> </td>
                                        <td width="62%" colspan="2"><strong>  Is Paid </strong> <strong>:</strong></td>
                                        </tr>  
<?php                                       
										for($i=1;$i<=$noofinst;$i++)
{
?>
                                        <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><input type="text" name="amount[]" id="amount<?php echo $i; ?>" class="input-small"
                                        value="<?php echo $amount; ?>"   autocomplete="off" ></td>
                                        <td width="17%"><input type="text" name="duedate[]" id="duedate<?php echo $i; ?>" class="input-small maskdate"
                                        value="<?php echo $cmn->dateformatindia($duedate); ?>"   autocomplete="off"  ></td>
                                        <td colspan="2">
                                        		<input type="checkbox" id="paid<?php echo $i; ?>" onClick="setvalue(<?php echo $i; ?>);" >
                                                <input type="hidden" name="is_paid[]" value="<?php echo $is_paid; ?>" id="is_paid<?php echo $i; ?>" >
                                        </td>
                                        </tr>   
                                        <?php 
}
?>                    
                                        </table>
<?php 
}
else if($if_id !=0)
{
?>

<table width="100%"> 
                                       <tr>
                                       	<td width="4%"><strong>Sn</strong></td>
                                        <td width="17%"><strong>Amount</strong> <strong>:</strong></td>
                                        <td width="17%"><strong>Due Date :</strong> </td>
                                        <td width="62%" colspan="2"><strong>  Is Paid </strong> <strong>:</strong></td>
                                        </tr>  
<?php          
$i=1;
									$sql = mysqli_query($connection,"select * from installment_detail order by detail_id");
									while($row=mysqli_fetch_assoc($sql))								
{
			$detail_id = $row['detail_id'];
			$amount = $row['amount'];
			$duedate = $row['duedate'];
			$is_paid = $row['is_paid'];
?>
                                        <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><input type="text" name="amount[]" id="amount<?php echo $detail_id; ?>" class="input-small"
                                        value="<?php echo $amount; ?>"   autocomplete="off" ></td>
                                        <td width="17%"><input type="text" name="duedate[]" id="duedate<?php echo $detail_id; ?>" class="input-small maskdate" value="<?php echo $cmn->dateformatindia($duedate); ?>"   autocomplete="off"  ></td>
                                        <td colspan="2">
                                        		<input type="checkbox" id="paid<?php echo $detail_id; ?>" onClick="setvalue(<?php echo $detail_id; ?>);" <?php if($is_paid==1) { ?> checked <?php } ?> >
                                                <input type="hidden" name="is_paid[]" value="<?php echo $is_paid; ?>" id="is_paid<?php echo $detail_id; ?>" >
                                        </td>
                                        </tr>   
                                        <?php 
}
?>                    
                                        </table>

<?php 
}
?>
                                        
    <script>
	//below code for date mask
jQuery(function($){
   $(".maskdate").mask("99-99-9999",{placeholder:"dd-mm-yyyy"});
 
});
	</script>
                                        
