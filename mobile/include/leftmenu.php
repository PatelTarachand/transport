<?php
error_reporting(0);
?>
<ul id="slide-out" class="sidenav">
    <li>
        <div class="user-view">
            <div class="background">
                <img src="images/background.jpg" style="width: 100%;">
            </div>
            
            <a href="#user"><img class="circle" src="images/user1.png"></a>
            <a href="#name"><span class="white-text name"><?php echo $user_name1;?></span></a>
         
        </div>
    </li>
    <li><a href="dashboard.php"><i class="material-icons indigo-text darken-4">home</i>Home</a></li>
    <li><a href="user-master.php"><i class="material-icons indigo-text darken-4">account_circle</i>User Master</a></li>
    <li><a href="logout.php"><i class="material-icons indigo-text darken-4">exit_to_app</i>Log Out</a></li>
</ul>
