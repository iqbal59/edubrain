
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="st_title"><i class='uil uil-cog'></i> Edit Profile</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="setting_tabs">
						<ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="pills-account-tab" data-toggle="pill" href="#pills-account" role="tab" aria-selected="true">Account</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-password-tab" data-toggle="pill" href="#pills-password" role="tab" aria-selected="false">Change Password</a>
							</li>
						</ul>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
							<form action="<?php print $this->CONT_ROOT.'save/profile';?>" method="post">
								<div class="account_setting">
									<h4>Edit Profile</h4>
									<p>Update your account details below.</p>
									<div class="basic_profile">
										<div class="basic_form">

											<div class="row">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-4">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="name" value="<?php print $this->LOGIN_USER->name;?>" id="id_headline" required="" maxlength="255" placeholder="Full Name">															
																	<div class="form-control-counter" data-purpose="form-control-counter">255</div>
																</div>
																<div class="help-block">Enter Your Name</div>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="mobile" value="<?php print $this->LOGIN_USER->mobile;?>" id="id_headline" maxlength="12" placeholder="Full Name">															
																	<div class="form-control-counter" data-purpose="form-control-counter">12</div>
																</div>
																<div class="help-block">Enter Your Mobile Number</div>
															</div>
														</div>
														<div class="col-lg-4">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="father_name" value="<?php print $this->LOGIN_USER->father_name;?>" id="id_headline" maxlength="99" placeholder="Father Name">															
																	<div class="form-control-counter" data-purpose="form-control-counter">99</div>
																</div>
																<div class="help-block">Enter Your Father Name</div>
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
									<button class="save_btn" type="submit">Save Changes</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="pills-password" role="tabpanel" aria-labelledby="pills-password-tab">
							<form action="<?php print $this->CONT_ROOT.'save/password';?>" method="post">
								<div class="account_setting">
									<h4>Change Password</h4>
									<p>Update your account password.</p>
									<div class="basic_profile">
										<div class="basic_form">

											<div class="row">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-6">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="password" name="password" value="" required="" maxlength="255" placeholder="Current Password">															
																	<div class="form-control-counter" data-purpose="form-control-counter">255</div>
																</div>
																<div class="help-block">Enter Your Current Password</div>
															</div>
														</div>
														<div class="col-lg-6">
															<div class="ui search focus mt-10">
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="password" name="npassword" value="" required="" maxlength="255" placeholder="New Password">															
																	<div class="form-control-counter" data-purpose="form-control-counter">255</div>
																</div>
																<div class="help-block">Enter New Password</div>
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
									<button class="save_btn" type="submit">Change Password</button>
								</div>
							</form>
						</div>
						<div class="tab-pane fade" id="pills-notification" role="tabpanel" aria-labelledby="pills-notification-tab">
							<div class="account_setting">
								<h4>Notifications - Choose when and how to be notified</h4>
								<p>Select push and email notifications you'd like to receive</p>
								<div class="basic_profile">										
									<div class="basic_form">
										<div class="nstting_content">
											<div class="basic_ptitle">
												<h4>Choose when and how to be notified</h4>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss1" checked>
												<label>Subscriptions</label>
												<p class="ml5">Notify me about activity from the profiles I'm subscribed to</p>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss2">
												<label>Recommended Courses</label>
												<p class="ml5">Notify me of courses I might like based on what I watch</p>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss3">
												<label>Activity on my comments</label>
												<p class="ml5">Notify me about activity on my comments on others’ courses</p>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss4" checked>
												<label>Replies to my comments</label>
												<p class="ml5">Notify me about replies to my comments</p>
											</div>																								
										</div>
									</div>
								</div>
								<div class="divider-1 mb-50"></div>
								<div class="basic_profile">										
									<div class="basic_form">
										<div class="nstting_content">
											<div class="basic_ptitle">
												<h4>Email notifications</h4>
												<p>Your emails are sent to gambol943@gmail.com. To unsubscribe from an email, click the "Unsubscribe" link at the bottom of it. <a href="#">Learn more</a> about emails from Edututs+.</p>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss5" checked>
												<label>Send me emails about my Cursus activity and updates I requested</label>
												<p class="ml5">If this setting is turned off, Cursus may still send you messages regarding your account, required service announcements, legal notifications, and privacy matters</p>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss6">
												<label>Promotions, course recommendations, and helpful resources from Cursus.</label>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss7">
												<label>Announcements from instructors whose course(s) I’m enrolled in.</label>
												<p class="ml5">To adjust this preference by course, leave this box checked and go to the  course dashboard and click on "Options" to opt in or out of specific announcements.</p>
											</div>																																				
										</div>
									</div>
								</div>
								<button class="save_btn" type="submit">Save Changes</button>
							</div>
						</div>
						<div class="tab-pane fade" id="pills-privacy" role="tabpanel" aria-labelledby="pills-privacy-tab">
							<div class="account_setting">
								<h4>Privacy</h4>
								<p>Modify your privacy settings here.</p>
								<div class="basic_profile">										
									<div class="basic_form">
										<div class="nstting_content">
											<div class="basic_ptitle">
												<h4>Profile page settings</h4>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss8" checked>
												<label>Show your profile on search engines</label>
											</div>
											<div class="ui toggle checkbox _1457s2">
												<input type="checkbox" name="stream_ss9">
												<label>Show courses you're taking on your profile page</label>
											</div>																																			
										</div>
									</div>
								</div>	
								<button class="save_btn" type="submit">Save Changes</button>
							</div>
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
