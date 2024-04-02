<?php
$page_name = basename($_SERVER['PHP_SELF']);
$session_name = $cmn->getvalfield($connection,"m_session","session_name","sessionid='$_SESSION[sessionid]'");

?>
<style>
    .dropdown-toggle::after{
        display:none;
    }
    #navigation .main-nav>li>a{
        padding: 10px 11px !important;
    }
    #navigation #brand{
        font-size:18px !important;
    }
</style>
<div id="navigation">
		<div class="container-fluid">
			<a id="brand" style="padding-left:0px;padding-right:14px;"> <?php echo $cmn->getvalfield($connection,"m_company","cname","compid='$_SESSION[compid]'"); ?></a>
			<!--<a href="#" class="toggle-av" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>-->
			<ul class='main-nav'>
				<li <?php if($page_name == "dashboard.php"){ ?> class='active' <?php } ?>>
                <a href="dashboard.php"><span>Home</span></a>
				</li>
                
         <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Dispatch</span>
						<span class="caret"></span>
					</a>
         
					<ul class="dropdown-menu"> 
                   
						
					       <li> <a href="bidding_entry.php" style="display: none">Bidding Entry</a></li>
                           <li>  <a href="bilty_entry_emami.php">Bilty Entry</a></li>
                           <li> <a href="bilty_dispatch_emami.php">Bilty Advance</a></li>
                           <li><a href="bilty_receive_emami.php?consignorid=4">Bilty Receive</a></li>
                           <li><a href="billing_entry_emami.php"> Billing Entry</a></li>
                           <!-- <li  class="dropdown-submenu"><a href="#">Return Trip</a>
                        <ul class="dropdown-menu">
                          <li><a href="return_trip_entry.php">Return Trip Entry</a></li>
                          <li><a href="return_trip_report.php">Return Trip Report</a></li>
						  <li><a href="payment_recive.php">Payment Recive Entry </a></li>
                          <li><a href="payment_voucher_report.php">Payment Recive Report</a></li>
						  
						  	    <li><a href="bilty_return_payment_voucher.php">Payment Recive </a></li>
                          <li><a href="inc_exp_report.php">Expenses Report</a></li>
						  	
                        
                       </ul> -->
                    </li>
         


                    
           
                    
                    <li class="dropdown-submenu" style="display: none"> <a href="#" style="font-weight: bold">Third Party</a>
						<ul class="dropdown-menu">
					    <li class="dropdown"> <a href="thirdparty_enrty.php" style="color: green; font-weight: bold">TP Payment Entry</a> </li>
                        <li class="dropdown"> <a href="thirdpartypayment_report.php" style="color: green; font-weight: bold">TP Payment Report</a> </li>
                           
					</li>
                        </ul>
                        
                        
						</li>
                        </li>
          
          
                        
                        
						</li>
				                                                          
                       
                                                                    
					</ul>	
                
                    		
				</li>
                    

                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Return Trip</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">  
						
					
                    <li><a href="return_trip_entry.php">Return Trip Entry</a></li>
                          <li><a href="return_trip_advance.php">Return Trip Advance</a></li>
						  <li><a href="return_trip_receive.php">Return Trip Receive</a></li>
                          <li><a href="return_entry_emami.php"> Billing Entry</a></li>
						  
						  	    <!--<li><a href="bilty_return_payment_voucher.php">Payment Recive </a></li>-->
             <!--             <li><a href="inc_exp_report.php">Expenses Report</a></li>-->
                    </li>
						
                    <li  class="dropdown-submenu"><a href="#">Payment</a>
                        <ul class="dropdown-menu">
                    
                        <!--<li class="dropdown" ><a href="return_bulk_bilty_payment_emami.php" >Bulk Bilty Payment </a> </li>-->
                        <!--<li class="dropdown"><a href="return_bulk_bilty_payment_emami_report.php" >Bulk Bilty Payment Report</a> </li> -->
                        
                        <!-- <li class="dropdown"><a href="return_bilty_payment_voucher.php" >Bilty Payment Voucher</a> </li> -->
                        <!-- <li class="dropdown"><a href="return_bilty_payment_voucher_report.php" >Bilty Payment Voucher Report</a> </li> -->
                       <!--  <li class="dropdown"><a href="voucher_ledger.php" style="color:#039; font-weight:bold">Voucher Ledger</a> </li> -->
                         
                         
                        <li class="dropdown"><a href="return_bill_payment.php" >Payment Received </a> </li> 
                         <!--<li class="dropdown"><a href="return_bill_payment_consignee.php" >Payment</a> </li>-->
                         <li class="dropdown"><a href="return_consignor_ledger.php" > Ledger</a> </li>  
                         <!--<li class="dropdown"><a href="return_consignee_ledger.php" >Consignee Ledger</a> </li>  -->
                        
                       </ul>
                    </li>	
                     
					
                      
                     </ul>			
				</li>  
                 
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Maintenance</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">  
						
					<li  class="dropdown-submenu"><a href="#">Master</a>
                        <ul class="dropdown-menu">
                          <li><a href="head_master.php">Head Master</a></li>
						  <li><a href="mechine_service.php">Mechanic/Service Center Master</a></li>
						  	  <li><a href="other_expense_master.php">Other Expense Head Master</a></li>
						  	
                        
                       </ul>
                    </li>
						
						
                     
					<li class="dropdown"><a href="service_entry.php"> Service Entry </a> </li> 
				
						
					<li class="dropdown"><a href="maintenance_entry.php"> Maintenance Entry </a> </li>
						
					<li class="dropdown"><a href="other_expense_entry.php"> Other Expenses Entry </a> </li> 
						
					<li  class="dropdown-submenu"><a href="#">Reports</a>
                        <ul class="dropdown-menu">
                          <li><a href="service_report.php">Service Report</a></li>
						  <li><a href="maintenance_report1.php">Maintenance Report</a></li>
						    <li><a href="office_exreport.php">Office Expense Report</a></li>	
                        
                       </ul>
                    </li>	
                      
                     </ul>			
				</li>  

                
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Inventory</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">  
						
					<li  class="dropdown-submenu"><a href="#">Master</a>
                        <ul class="dropdown-menu">
                          <li><a href="master_unit.php">Unit Master</a></li> 
						  <li> <a href="master_item_category.php">Item Category Master</a></li>
                          <li> <a href="master_item_inv.php">Item Master</a></li>
						  <li> <a href="master_supp_invo.php">Supplier Master</a></li>	
                       </ul>
                    </li>
						
								
								
								
								
					<li  class="dropdown-submenu"><a href="#">Purchase</a>
                        <ul class="dropdown-menu">
           	<li class="dropdown"><a href="purchase_entry.php">Purchase  Entry </a> </li>
					   <li><a href="purchase_payment.php">Purchase Payment</a></li>
                       </ul>
                    </li>	<li  class="dropdown-submenu"><a href="#">Sale</a>
                        <ul class="dropdown-menu">
                     <li class="dropdown"><a href="sale_entry.php">Sale  Entry </a> </li>
                          	<li class="dropdown"><a href="sale_payment.php">Payment Receive </a> </li>
                       </ul>
                    </li>
				
					<li class="dropdown"><a href="issueentry.php">Item Issue Entry </a> </li>
				<li class="dropdown"><a href="tyre_opening_record.php">Tyre Issue Entry</a> </li>	
						
					<li  class="dropdown-submenu"><a href="#">Reports</a>
                        <ul class="dropdown-menu">
                         <li><a href="purchase_report.php">Purchase  Report</a></li>
                                                                             <li><a href="purtrasaction_report.php">Purchase Payment Report</a></li>
                                                                             <li><a href="sale_report.php">Sale  Report</a></li>
                                                                             <li><a href="saletrasaction_report.php">Payment Receive Report</a></li>

						  <li><a href="issueentry_detail.php">Item Issue Report</a></li>
						  <!--<li><a href="tyre_details.php">Tyre Report</a></li>-->
						  <li><a href="vechicletyre_report.php">Tyre Report</a></li>
						    <li><a href="scrap_report.php">Scrap Report</a></li>
						  <li><a href="material_in_detail.php">Repairable Report</a></li>
						  <li><a href="exchangereport.php">Exchange Report</a></li>
						  <li><a href="stock_report.php">Item Stock Report</a></li>	
						  	  <li><a href="vechicletyre_report.php">Vechicle Tyre Report</a></li>	
                            <!--<li><a href=""></a>Vechicle Tyre Report</li>-->
                       </ul>
                    </li>	
                      
                     </ul>			
				</li>
				


				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Documents</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">  
						
					<li  class="dropdown-submenu"><a href="#">Master</a>
                        <ul class="dropdown-menu">
                          
						  <li> <a href="doc_category_master.php">Doc. Category Master</a></li>
                         
                       </ul>
                    </li>
						
					<li class="dropdown"><a href="truck_permanent_document1.php">Update Document </a> </li>
						
				   <li  class="dropdown-submenu"><a href="#">Report</a>
                        <ul class="dropdown-menu">
                          <li><a href="truck_document_report.php">Doc. Expier Report</a></li> 
						 
                         
                       </ul>
                    </li>		
					
                      
                     </ul>			
				</li>
                
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Payroll</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">  
						
					<li  class="dropdown-submenu"><a href="#">Master</a>
                        <ul class="dropdown-menu">
                          <li><a href="master_employee.php">Master Employee</a> </li>
						  <li> <a href="expense_head_master.php">Expenses Head Master</a></li>
                         
                       </ul>
                    </li>
						
					<li class="dropdown"><a href="emp_payment.php">Employee Payment </a> </li>
						
				   <li  class="dropdown-submenu"><a href="#">Report</a>
                        <ul class="dropdown-menu">
                          <li><a href="emp_paymentreport.php">Payment Report</a></li> 
						 
                         
                       </ul>
                    </li>		
					
                      
                     </ul>			
				</li>
				
				 <?php if($user_companyid==4 || $user_companyid==0) { ?>	 
				<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Payment</span>
						<span class="caret"></span>
					</a>
               <?php      
                     $master_chk=1;
			if($master_chk !='0')
			{
                     ?>  
					<ul class="dropdown-menu"> 
                        
                    
                        <li class="dropdown" ><a href="bulk_bilty_payment_emami.php" style="color:#F00; font-weight:bold">Bulk Bilty Payment </a> </li>
                        <li class="dropdown"><a href="bulk_bilty_payment_emami_report.php" style="color:#F00; font-weight:bold">Bulk Bilty Payment Report</a> </li> 
                        
                         <li class="dropdown"><a href="bilty_payment_voucher.php" style="color:#039; font-weight:bold">Bilty Payment Voucher</a> </li> 
                         <li class="dropdown"><a href="bilty_payment_voucher_report.php" style="color:#039; font-weight:bold">Bilty Payment Voucher Report</a> </li> 
                       <!--  <li class="dropdown"><a href="voucher_ledger.php" style="color:#039; font-weight:bold">Voucher Ledger</a> </li> -->
                         
                         
                        <li class="dropdown"><a href="bill_payment.php" style="color:#600; font-weight:bold">Payment Received By Consignor</a> </li> 
                         <li class="dropdown"><a href="bill_payment_consignee.php" style="color:#e92c48; font-weight:bold">Payment Paid to Consignee</a> </li> 
                         <li class="dropdown"><a href="consignor_ledger.php" style="color:#600; font-weight:bold">Consignor Ledger</a> </li>  
                         <li class="dropdown"><a href="consignee_ledger.php" style="color:#600; font-weight:bold">Consignee Ledger</a> </li>  
                        
                         
                         
                          
                                                                    
					</ul>	
                 <?php } ?>   
                    		
				</li>
				   <?php } ?>  
                
             
                
                
               <!-- <li >
					<a href="#" data-toggle="dropdown" style="display:none;" class='dropdown-toggle'>
						<span>Maintenance</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">                    
                     
						<li class="dropdown" style="display:none;"><a href="truck_permanent_document.php"> Truck Permanent Document </a> </li> 
                        <li class="dropdown" style="display:none;"><a href="installment_fixation.php">Installment Fixation</a> </li>
                        <li class="dropdown" style="display:none;"><a href="truck_installation_payment.php">Truck Installment Payment</a> </li> 
                        <li class="dropdown" style="display:none;"> <a href="driver_salary.php">Driver Salary Deduction</a></li>
                        <li class="dropdown" style="display:none;"> <a href="salary_driverwise.php">Driver Salary Entry</a></li>
                        

          
                  
                     </ul>			
				</li>    -->
                
                                  
               
                <li>
                   <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Account</span>
						<span class="caret"></span>
					</a> 
                    
                    <ul class="dropdown-menu">
                      	  <li><a href="account_setting.php">Account Setting</a></li>
                      	  <li> <a href="office_expense.php"> Payments Expense </a> </li>
                      	  <li> <a href="office_income.php">  Payment Received </a></li>
                        <li><a href="office_expense_report.php"> Payments Expense Report</a></li>
                            <li><a href="office_income_report.php"> Payment Received Report</a></li>
                           	
                     
                           
                        <ul class="dropdown-menu">                     
                            <li><a href="office_expense_report.php"> Expense Report</a></li>
                             <li><a href="office_income_report.php"> Income Report</a></li>
                                
                       </ul>
                    </li>
					</ul>
                   
                    </li>
                    
                    <!-- <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Maintenance</span>
						
					</a>
					<ul class="dropdown-menu">
                    
           
                        <li  class="dropdown-submenu"><a href="#">Master</a>
                    	    <ul class="dropdown-menu">
                            <li><a href="supplier_master.php">Supplier Master</a></li>
							<li><a href="unit_master.php">Unit  Master</a></li>
							<li><a href="item_category_master.php">Item Category Master</a></li>
							<li><a href="item_master.php">Item Master</a></li>
                            <li><a href="master_mechanic.php">Mechanic Master</a></li>
                            <li><a href="master_maintenance.php">Maintenance Master</a> </li>
                        </ul>
                        </li>
                        <li><a href="purchase_entry.php">Purchase Entry</a></li>
                        <li><a href="issueentry.php">Item Issue </a></li>
                        <li><a href="issueentry_detail.php">Item Issue Details</a></li>

                        <li><a href="master_maintenance_entry.php">Maintenance Entry</a></li>
                        <li><a href="maintenance_report.php">Maintenance Report</a></li>
                    
					</ul>
				</li>
                 -->
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Masters</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                    
           
                        <li  class="dropdown-submenu"><a href="#">Company</a>
                    	    <ul class="dropdown-menu">
            
                            <li><a href="master_session.php">Session Master</a></li>
                            <li><a href="master_company.php">Companies Master</a> </li>
                            <li><a href="master_consignor.php">Master Consignor</a> </li>
                            <li><a href="master_consignee.php">Master Consignee</a> </li>
                               <li><a href="customer_master.php">Customer  Master  </a> </li>
                            <li><a href="master_bank.php">Master Bank</a> </li>
                      		<li><a href="master_employee.php">Master Employee</a> </li>
                            <li><a href="brand_master.php">Brand Master</a> </li>                         
                       </ul>
                    </li>
                  
                        <li  class="dropdown-submenu"><a href="#">Place</a>
                    	    <ul class="dropdown-menu">                      
                            <li><a href="master_place.php">Place Master</a> </li>                         
                            <li><a href="master_state.php">State Master</a> </li>                           
                             </ul>
                        </li>
                        
                              
                      
                        <li  class="dropdown-submenu"><a href="#">Good</a>
                    	    <ul class="dropdown-menu">                       
                                    <li><a href="master_item.php">Good Group</a>  </li>                           
                                    <li><a href="master_item.php">Master Item</a>  </li> 
                                     <li><a href="master_packing.php">Master Packing</a>  </li>                            
                             </ul>
                        </li>
                     
                        
                        <li  class="dropdown-submenu"><a href="#">Truck</a>
                    	    <ul class="dropdown-menu">                       
                            <li><a href="master_trucktype.php">Master Truck Type</a></li>
                            <li><a href="master_truckowner.php">Truck Owner</a></li>
                            <li><a href="master_truck.php"> Truck Master</a>  </li>          
                                               
                             </ul>
                        </li>
           
		
                        <li  class="dropdown-submenu"><a href="#">Inventory</a>
                    	    <ul class="dropdown-menu">                                     
                                    <li><a href="master_supplier.php">Petrol Pump Master</a></li>                                    
                                    <li><a href="#" style="display:none;">Group Master</a></li>                                    
                                    <li><a href="income_expense_head.php">Income Expense Head</a></li>                  
                             </ul>
                        </li>
                        
               <li style="display: none"><a href="m_third_party.php">Master Third Party</a> </li>
                         
					</ul>
				</li>
<li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span>Reports</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
                    
           
                        <li  class="dropdown-submenu"><a href="#">Dispatch</a>
                    	    <ul class="dropdown-menu">
            
                            <li><a href="emami_bilty_report.php">Dispatch Report</a></li>
                            <li><a href="builty_receive.php">Bilty Receiving Report</a> </li>
                            <li><a href="biltypendingreport.php">Bilty Receiving Pending Report</a></li>
                           
                          
                        </ul>
                        </li>
                        
                       
                       	
                            <li  class="dropdown-submenu"><a href="#">Payment</a>
                    	    <ul class="dropdown-menu">
                            <li><a href="emami_bilty_advance_report.php">Bilty Advance Report</a></li>
                            <li><a href="petrol_advance_report.php">Diesel advance Report</a></li>
                            <li><a href="advance_cash_report.php">Cash advance Report</a></li>
                            
                        
                            <li><a href="bulk_bilty_payment_emami_report.php">Bulk Bilty Payment Report</a> </li>
                            
                           
                             </ul>
                       </li>
                       
                              
                            <li  class="dropdown-submenu"><a href="#">Account</a>
                    	    <ul class="dropdown-menu">
                    	          <li><a href="company_cash_book.php">Company Cash Book</a></li>
                            <li><a href="tds_emami_report.php">TDS Report</a></li>
                              <li><a href="consignor_payment_report.php">Consignor TDS Report</a></li>
                            <li><a href="consignee_payment_report.php">Consignee TDS Report</a></li>
                            <li><a href="paid_unpaid_report.php">Paid/Unpaid Report</a></li>
                            <li><a href="truckowner_roaker.php">Truck Owner Ledger</a></li>
                            
                            <li> <a href="transport_commision_report.php">Transporting commission Report</a></li>
                           <!--<li><a href="cash_summary_report_emami.php">Cash Summary Report JK Laxmi</a></li> -->
                            <li><a href="truck_owner_payment_report.php">Truck Owner Payment Report</a></li>
                             
                           
                          
                       </ul>
                    </li>
                    
                          <!--<li><a href="licence_report.php"> Licence Report</a></li>-->
                 
                              
                          <li><a href="truck_p_l_report.php">Truck Profit/Loss  Report</a></li>
                     
                         
					</ul>
				</li>                
                <li>
					<a href="#" data-toggle="dropdown" class='dropdown-toggle'>
						<span> User</span>
						<span class="caret"></span>
					</a> 
                    <ul class="dropdown-menu"> 
					<?php if($_SESSION['usertype']=="admin") { ?>
					
                    		<li><a href="master_user.php"> Add User </a></li>  
					<?php } ?>		                        
                            <li><a href="backupdb.php"> Database Backup </a></li>                     
                                <li><a href="change_password.php">Change Password</a></li>
                                <li><a href="logout.php">Logout</a></li>
					</ul>
                    </li>
                    
                    <li>
					<a data-toggle="dropdown" class='dropdown-toggle'>
	          <span><strong><?php echo $cmn->getvalfield($connection,"m_session","session_name","sessionid='$_SESSION[sessionid]'"); ?></strong></span>						
					</a>
				</li>				               
			</ul>			
		</div>
	</div>
   