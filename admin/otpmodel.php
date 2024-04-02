<div id="otpmodel" class="modal fade" role="dialog" style="top: 30%;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">OTP</h4>
				</div>
				<!-- /.modal-header -->
				<div class="modal-body" style="background: #eee;">
								<table class="table">
									<tr>
										<th>OTP</th>
										<th>
											<input type="text" id="otp">
										</th>
									</tr>
								</table>
				</div>
				<!-- /.modal-body -->
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="matchotp();" >Check</button>
					<input type="hidden" id="otp_bid_id" value="" >
				</div>
				<!-- /.modal-footer -->
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>