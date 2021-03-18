
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="st_title"><i class='uil uil-cog'></i> Change Password</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
							<form action="<?php print $this->CONT_ROOT.'save/preset';?>" method="post">
								<div class="account_setting">
									<h4>Update Password</h4>
									<p>Update your account password to proceed further.</p>
									<div class="basic_profile">
										<div class="basic_form">

											<div class="row">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-8">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="password" name="password" value="" required="" maxlength="255" placeholder="New Password">															
																	<div class="form-control-counter" data-purpose="form-control-counter">255</div>
																</div>
																<div class="help-block">Enter Your New Password</div>
															</div>
														</div>
														<div class="col-lg-12">
															<div class="divider-1"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<button class="save_btn" type="submit">Update Password</button>
								</div>
							</form>
						</div>
					</div>
				</div>						
			</div>
		</div>
	</div>
	
	<!-- Footer -->
	<br><br><br><br><br><br>
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->
