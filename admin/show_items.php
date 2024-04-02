<?php
include("dbconnect.php");
  $itemid= $_REQUEST['itemid'];
  $issue_cate= $_REQUEST['issue_cate'];
  if($issue_cate=='New Item'){
  $sql = mysqli_query($connection, "select * from purchaseorderserial where itemid =$itemid && is_issue=0");
?>
<option value="">select</option>
<?php
while($row = mysqli_fetch_array($sql)) { ?>
    <option value="<?php echo $row['pos_id']; ?>"><?php echo $row['serial_no']; ?></option>
<?php	  }
  }

  if($issue_cate=='Repair'){
  $sql = mysqli_query($connection, "select * from purchaseorderserial where return_cate ='Repaired' && itemid =$itemid");
?>
<option value="">select</option>
<?php
while($row = mysqli_fetch_array($sql)) { ?>
    <option value="<?php echo $row['pos_id']; ?>"><?php echo $row['serial_no']; ?></option>
<?php	  }
  }

  if($issue_cate=='Exchange'){
    $sql = mysqli_query($connection, "select * from purchaseorderserial where itemid =$itemid && is_issue=0");
  ?>
  <option value="">select</option>
  <?php
  while($row = mysqli_fetch_array($sql)) { ?>
      <option value="<?php echo $row['pos_id']; ?>"><?php echo $row['serial_no']; ?></option>
  <?php	  }
    }
  
?>
 

