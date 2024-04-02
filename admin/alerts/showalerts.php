<?php

if($action == 1)//insert msg

echo "<div id='testdiv' style='text-align:center;color:#090'><h4 class='alert_success'>Record Saved Successfuly</h4></div>";

elseif($action == 2)// update msg

echo "<div id='testdiv' style='text-align:center;color:#306'><h4 class='alert_success'>Record Updated Successfuly</h4></div>";

elseif($action == 3)// delete msg

echo "<div id='testdiv' style='text-align:center;color:#F00'><h4 class='alert_success'>Record Deleted Successfuly</h4></div>";

elseif($action == 4)// cant delete, as foreign key constraint

echo "<div id='testdiv' style='text-align:center;color:#F00'><h4 class='alert_success'>Record Can not be Deleted, already in Used !</h4></div>";

elseif($action == 5)// already exist

echo "<div id='testdiv' style='text-align:center;color:#03C'><h4 class='alert_success'>Record Aleready Exist, Can not be saved !</h4></div>";

elseif($action == 6)// already exist

echo "<div id='testdiv' style='text-align:center;color:#03C'><h4 class='alert_success'>Bill can not be saved, Please Add EGP !</h4></div>";

elseif($action == 7)// already exist

echo "<div id='testdiv' style='text-align:center;color:#03C'><h4 class='alert_success'>Duplicate Bill Number, Can not be saved !</h4></div>";

elseif($action == 8)// Cancel order msg

echo "<div id='testdiv' style='text-align:center;color:#F00'><h4 class='alert_success'>Error: Data not saved: </h4></div>";

elseif($action == 9)// Cancel order msg

echo "<div id='testdiv' style='text-align:center;color:#F00'><h4 class='alert_success'>Order Can not be cancelled, First Delete Issued Product.</h4></div>";

elseif($action == 10)// Cancel order msg

echo "<div id='testdiv' style='text-align:center;color:#F00'><h4 class='alert_success'>Record Deleted Successfully.</h4></div>";

else

echo "";

?>