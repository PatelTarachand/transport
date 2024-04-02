<?php
//$cmn->check_access();
$page_name = basename($_SERVER['PHP_SELF']);
?>

<div id="navigation">
		<div class="container-fluid">
			<a href="#" id="brand">Singh Roadlines</a>
			<a href="#" class="toggle-av" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>
			<ul class='main-nav'>
				<li <?php if($page_name == "dashboard.php"){ ?> class='active' <?php } ?>>
                <a href="dashboard.php"><span>Home</span></a>
				</li>
                
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Masters</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-submenu"><a href="#">Companies</a>
                        	<ul class="dropdown-menu"> 
                            <li><a href="master_truckowner.php">Truck Owners</a></li>
                            <li><a href="master_company.php">Company Master</a></li>
                            <li><a href="master_consignor.php">Consignor Master</a></li>
                            <li><a href="master_consignee.php">Consignee Master</a></li> 
                               <li><a href="customer_master.php">Customer  Master  </a> </li>
                            <li><a href="master_subconsignee.php">Sub Consignee</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown-submenu"><a href="#">Dispatch</a>
                        	<ul class="dropdown-menu"> 
                            <li><a href="master_district.php">District Master</a></li>
                            <li><a href="master_place.php">Place Master</a></li>
                            <li><a href="master_rate.php">Rate Master</a></li> 
                            <li><a href="master_trucktype.php">Truck Type Master</a></li>
                            <li><a href="master_truck.php">Truck Master</a></li> 
                            <li><a href="master_route.php">Route Master</a></li>
                            <li><a href="#">Billty Reporter</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown-submenu"><a href="#">Inventory</a>
                        	<ul class="dropdown-menu"> 
                        <li><a href="master_supplier.php">Supplier Master</a></li>    
                       	<li><a href="master_group.php">Group Master</a></li>
                        <li><a href="master_item.php">Item Master</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown-submenu"><a href="#">Payroll</a>
                        	<ul class="dropdown-menu"> 
                       	<li><a href="master_employee.php">Employee</a></li> 
                        <li><a href="master_salary.php">Salary Master</a></li>
                            </ul>
                        </li>
                        
                        <li class="dropdown-submenu"><a href="#">Accounts</a>
                        	<ul class="dropdown-menu"> 
                        <li><a href="master_session.php">Session Master</a></li> 
                        <li><a href="master_branch.php">Branches</a></li>
                        <li><a href="master_finance.php">Finance Master</a></li> 
                        <li><a href="master_bank.php">Bank Master</a></li> 
                        <li><a href="master_bank_account.php">Bank Accounts</a></li>
                        <li><a href="master_driver_expense.php">Driver Expenses</a></li> 
                        <li><a href="master_office_expenses.php">Office Expenses</a></li>
                          <!--<li><a href="master_new_cheque.php">Cheque Book Entry</a></li>
                          <li><a href="acc_uchanti_len.php">Uchanti Len Entry</a></li>
                          <li><a href="acc_uchanti_den.php">Uchanti Den Entry</a></li>-->
                            </ul>
                        </li>
                        <!-- <li><a href="master_session.php">Session Master</a></li> -->
					</ul>
					
				</li>
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Dispatch</span>
						<span class="caret"></span>
					</a>
								<ul class="dropdown-menu">
                                    <li><a href="order_form.php"> Order</a></li>
                                    <li><a href="billty_form.php"> Billty</a></li>
                                    <li><a href="dispatch.php"> Dispatch Report</a></li>
                                    
                                    <li class="dropdown-submenu"><a href="#">Return Dispatch</a>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="return_dispatch.php"> Return Dispatch</a></li>
                                            <li><a href="return_billing.php"> Return Billing</a></li>
                                           
                                        </ul>
                                    </li>
                
                
                                   <!-- <li><a href="return_dispatch.php"> Return Dispatch Report</a></li>-->
                                    <li><a href="ses_entry.php"> SES Entry</a></li>
                                    <li><a href="goods_receive.php"> Good Recive</a></li>
                                    <li><a href="billing.php"> Billing</a></li>
                                    <!--<li><a href="return_billing.php"> Return Billing</a></li>-->
                                    <li><a href="freight_payment.php"> Freight Payment</a></li>
                                    <li><a href="#"> Freight Recieve</a></li>
                                    <li><a href="#"> Bill Recieve</a></li>
                				</ul>
				</li>
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Inventory</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
				<li class="dropdown-submenu"><a href="#">Items</a>
                	<ul class="dropdown-menu"> 
                    	<li><a href="demand_slip.php">Item Demand Slip</a></li>
                    	<li><a href="item_purchase.php">Item Purchase</a></li>
                        <li><a href="item_purchase_return.php">Purchase Return</a></li>
                        <li><a href="issue_item.php"> Item Issue</a></li>
                        <li><a href="issue_item_return.php"> Issue Return</a></li>
                        <li><a href="scrap_entry.php">Scrap Entry</a></li>
                		
                    </ul>
                </li>
                <li class="dropdown-submenu"><a href="#">Tyre</a>
                	<ul class="dropdown-menu"> 
                    	<li><a href="#"> Tyre Demand Slip</a></li>
                    	<li><a href="tyre_purchase.php">Tyre Purchase</a></li>
                        <li><a href="tyre_truck_maping.php">Truck Tyre Mapping</a></li>
                    </ul>
                </li>
                <li class="dropdown-submenu"><a href="#">Diesel</a>
                	<ul class="dropdown-menu"> 
                    <li><a href="supllier_diesel_rate_setting.php">Diesel Rate Setting</a></li>
                    	<li><a href="diesel_demand_slip.php"> Diesel Demand Slip</a></li>
                        <li><a href="report_diesel_demand.php">Diesel Demand Slip Report</a></li>
                        <li><a href="diesel_billing.php"> Diesel Billing</a></li>
                        <li><a href="#">Route Entry</a></li>
                    </ul>
                </li>
                <li><a href="truck_driver_map.php">Driver Truck Mapping</a></li>
					</ul>
				</li>
                
                
                
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> Maintainance</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="servicing_type_master.php">Servicing Type Master</a></li>
                <li><a href="servicing_company_master.php">Servicing Company Master</a></li>
               <!-- <li><a href="/beetracker/admin/maintainance/servicing_engineer_master.php">Servicing Engineer</a></li>-->
                <li><a href="truck_service_card.php">Truck Service Card</a></li>
                <li><a href="truck_parts_service_card.php">Truck Parts Service Card</a></li>
                <li><a href="truck_labour_service_card.php">Truck Labour Service Card</a></li>
                <li><a href="#">Tyre Service</a></li>
                <li><a href="truck_permanent_document.php">Truck Permanent Document</a></li>
					</ul>
				</li>
                
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> Payroll</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="employee_advance.php">Employee Advance</a></li>
               			<li class="dropdown-submenu"><a href="generate_employee_salary.php">Generate Salary</a>
                    
                </li>
                    </ul>
                </li>
					


                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> Expenses</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                        <li><a href="uchanti.php">Uchanti</a></li>
                        <li><a href="driver_book.php">Driver Book</a></li>
                        <li><a href="office_expenses.php">Office Expences</a></li>
                        <li><a href="loan.php">Loan Entry</a></li>
					</ul>
				</li>
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> Report</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                    <li  class="dropdown-submenu"><a href="#">Inventory</a>
                    	<ul class="dropdown-menu">
                        	<li  class="dropdown-submenu"><a href="#">Diesel</a>
                            	<ul class="dropdown-menu">
                                	 <li><a href="report_diesel_demand.php">Diesel Demand Report</a></li>
                                     <li><a href="report_diesel_billing.php">Diesel Billing Report</a></li>
                                </ul>
                            </li>
                            
                            
                        </ul>
                    
                    
                    </li>
                    <li class="dropdown-submenu"><a href="#">Return Dispatch</a>
                                        <ul class="dropdown-menu"> 
                                            <li><a href="report_return_dispatch.php"> Return Dispatch</a></li>
                                            <li><a href="report_return_billing.php"> Return Billing</a></li>
                                           
                                        </ul>
                                    </li>
              		<li class="dropdown-submenu"><a href="#">Expenses</a>
                    	<ul class="dropdown-menu">
                        	<li><a href="report_uchanti.php">Uchanti Report</a>
                            <li><a href="report_driver_book.php">Driver Book Report</a>	
                            </li>
                        </ul>
                    </li>
					</ul>
					
				</li>
                
                
                
                
                
                
                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> User</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                       <li><a href="billty_setting.php">Billty Settings</a></li>
				<li><a href="change_password.php">Change Password</a></li>
				<li><a href="logout.php">Logout</a></li>
                        
					</ul>
				</li>
                
                
                
			</ul>
			<!--<div class="user">
				<div class="dropdown" style="background-color:#006">
                
					<a href="#" class='dropdown-toggle' data-toggle="dropdown">Admin</a>
					<ul class="dropdown-menu pull-right">
						<li><a href="/beetracker/admin/dispatch/setting_billty.php"> <img src="/beetracker/images/bilty.png"> Billty Settings</a></li>
				<li><a href="/beetracker/change_password.php"> <img src="/beetracker/images/lock3.png"> Change Password</a></li>
				<li><a href="?logout=logout"> <img src="/beetracker/images/logout.png"> Logout</a></li>
					</ul>
				</div>
			</div>-->
		</div>
	</div>
    <script>
	/*	$(document).ready(function(){
			$("#page_form").hide();
			$("#page_table").show();
			$("#addnew").click(function(){
				$("#page_form").toggle(300);
				$("#page_table").toggle(300);
				if($(this).html()=="ADD NEW")
				$(this).html("SHOW TABLE");
				else
				$(this).html("ADD NEW");
			});
			<?php //if(isset($_REQUEST['edit']) && $_REQUEST['edit']!=""){ ?>$("#addnew").click();<?php //} ?>
		});*/
	</script>