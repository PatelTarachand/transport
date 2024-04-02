<!--  Page Header....-->
<?php
$msg="";
if(isset($_REQUEST['msg']) && $_REQUEST['msg']!="")
{
	$msg=$_REQUEST['msg'];
}
?>
<div class="page-header">
    <div class="pull-left">
        <?php
		if($msg=="")
		{
		}
		elseif($msg=="1")
		{
			echo "<span id='msg_span' class='help-block' style='border:1px solid #999; border-radius:4px; padding:3px; background-color:#3F9; color:#000;'>DATA SAVED SUCCESSFULLY . . . </span>";
		}
		elseif($msg=="2")
		{
			echo "<span id='msg_span' class='help-block' style='border:1px solid #999; border-radius:4px; padding:3px; background-color:#F93; color:#000;'>Cannot Save . . . </span>";
		}
		elseif($msg=="3")
		{
			echo "<span id='msg_span' class='help-block' style='border:1px solid #999; border-radius:4px; padding:3px; background-color:#3F9; color:#000;'>DATA DELETED . . . </span>";
		}
		elseif($msg=="4")
		{
			echo "<span id='msg_span' class='help-block' style='border:1px solid #999; border-radius:4px; padding:3px; background-color:#F93; color:#000;'>Cannot Delete . . . </span>";
		}
		?>
    </div>
    
    <script>
	$(document).ready(function(){
		$("#table_div").hide();
		$("input#add_new").click(function(){
			$("#table_div").toggle(300);
			$("#page_div").toggle(300);
			if($(this).val()=="Add New")
				$(this).val("Show Table");
			else
				$(this).val("Add New");
		});
		setTimeout(function(){$("#msg_span").fadeOut(1000);},1500);
	});
	</script>
    <!--<div class="pull-right">
						<ul class="minitiles">
							<li class='grey'>
								<a href="#">
									<i class="icon-cogs"></i>
								</a>
							</li>
							<li class='lightgrey'>
								<a href="#">
									<i class="icon-globe"></i>
								</a>
							</li>
						</ul>
						<ul class="stats">
							<li class='satgreen'>
								<i class="icon-money"></i>
								<div class="details">
									<span class="big">$324,12</span>
									<span>Balance</span>
								</div>
							</li>
							<li class='lightred'>
								<i class="icon-calendar"></i>
								<div class="details">
									<span class="big">February 22, 2013</span>
									<span>Wednesday, 13:56</span>
								</div>
							</li>
						</ul>
					</div>-->
</div>
<!--   breads crumbs-->
<!--<div class="breadcrumbs">
    <ul>
        <li>
            <a href="index.php">Home</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="#">Master</a>
            <i class="icon-angle-right"></i>
        </li>
        <li>
            <a href="#">.......</a>
        </li>
    </ul>
    <div class="close-bread">
        <a href="#"><i class="icon-remove"></i></a>
    </div>
</div>-->