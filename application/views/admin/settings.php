
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="st_title"><i class='uil uil-cog'></i>Configurations &amp; Settings </h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="setting_tabs">
						<ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link <?php print empty($tab)||$tab=='home'? 'active' : '';?>" id="pills-account-tab" data-toggle="pill" href="#pills-account" role="tab" aria-selected="true">Settings</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php print $tab=='action'? 'active':'';?>" id="pills-action-tab" data-toggle="pill" href="#pills-action" role="tab" aria-selected="false">Actions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php print $tab=='logo'? 'active':'';?>" id="pills-logo-tab" data-toggle="pill" href="#pills-logo" role="tab" aria-selected="false">Upload Logo</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php print $tab=='sms'? 'active':'';?>" id="pills-sms-tab" data-toggle="pill" href="#pills-sms" role="tab" aria-selected="false">Student Alert</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php print $tab=='staffsms'? 'active':'';?>" id="pills-staff-sms-tab" data-toggle="pill" href="#pills-staff-sms" role="tab" aria-selected="false">Teacher Alert</a>
							</li>
							<li class="nav-item">
								<a class="nav-link <?php print $tab=='bulkpc'? 'active':'';?>" id="pills-bulk-pc-tab" data-toggle="pill" href="#pills-bulk-pc" role="tab" aria-selected="false">Bulk Password Change</a>
							</li>
						</ul>
					</div>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade <?php print empty($tab)||$tab=='home'? 'show active':'';?>" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab">
							<form action="<?php print $this->CONT_ROOT.'save/settings';?>" method="post">
								<div class="account_setting">
									<h4>General Settings &amp; Configuration</h4>
									<div class="basic_profile">
										<div class="basic_form">
											<div class="row">
												<div class="col-lg-12">
													<div class="row">
														<div class="col-lg-12">
															<div class="ui search focus">
															  <div class="form-check">
															    <input type="checkbox" class="form-check-input" id="cb1" name="<?php print $this->system_setting_m->_WS_EXAM_STRICT_START_TIME;?>" <?php print $this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]=='1' ? 'checked':''; ?>>
															    <label class="form-check-label help-block" for="cb1">Enable Exam Strict Mode? If enabled then student must have to attempt the exam on prescribed time. otherwise student can attempt exam any time after prescribed time.</label>
															  </div>
															</div>
														</div>
														<div class="col-lg-12">
															<div class="ui search focus">
															  <div class="form-check">
															    <input type="checkbox" class="form-check-input" id="cb2" name="<?php print $this->system_setting_m->_WS_EXAM_PRACTICE_TEST;?>" <?php print $this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]=='1' ? 'checked':''; ?>>
															    <label class="form-check-label help-block" for="cb2">Student can Practice Exam? If enabled then student can create and attempt practice quiz tests from their dashboard</label>
															  </div>
															</div>
														</div>
														<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING])){ ?>
														<div class="col-lg-12">
															<div class="ui search focus">
															  <div class="form-check">
															    <input type="checkbox" class="form-check-input" id="cb3" name="<?php print $this->system_setting_m->_WS_CHAPTER_WISE_LESSONING;?>" <?php print $this->SETTINGS[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING]=='1' ? 'checked':''; ?>>
															    <label class="form-check-label help-block" for="cb3">Enable chapter wise Lessons Display? If enabled then lessons will be display in chapter wise groups instead of list.</label>
															  </div>
															</div>
														</div>
														<?php } ?>
														<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE])){ ?>
														<div class="col-lg-12">
															<div class="ui search focus">
															  <div class="form-check">
															    <input type="checkbox" class="form-check-input" id="cb4" name="<?php print $this->system_setting_m->_WS_LESSON_SCHEDULE;?>" <?php print $this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE]=='1' ? 'checked':''; ?>>
															    <label class="form-check-label help-block" for="cb4">Enable  lesson schedule display? If enabled then week-wise lesson schedule will be displayed on student dashboard.</label>
															  </div>
															</div>
															<br>
														</div>
														<?php } ?>
														<div class="col-6">
															<div class="ui search focus">
																<div class="help-block">Add a motivational quotation for students</div>
																<div class="ui input swdh11">
																	<input class="prompt srch_explore" type="text" name="<?php print $this->system_setting_m->_WS_DAILY_QOUTE ?>" value="<?php print $this->SETTINGS[$this->system_setting_m->_WS_DAILY_QOUTE] ?>" placeholder="Daily Qoute">
																</div>
															</div>
														</div>
														<div class="col-3">
															<div class="help-block">Select time zone</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="<?php print $this->system_setting_m->_WS_TIMEZONE ?>">
																<option value="">Select TimeZone</option>
																<?php foreach($timezones as $zone){ ?>
																<option value="<?php print $zone; ?>" <?php print $this->SETTINGS[$this->system_setting_m->_WS_TIMEZONE]==$zone ? 'selected':''; ?>><?php print $zone;?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-3">
															<div class="ui search focus">
																<div class="help-block">Lesson active time(in minutes)</div>
																<div class="ui input swdh11">
																	<input class="prompt srch_explore" type="text" name="<?php print $this->system_setting_m->_WS_LECTURE_ACTIVE_TIME ?>" value="<?php print $this->SETTINGS[$this->system_setting_m->_WS_LECTURE_ACTIVE_TIME] ?>" id="id_headline" placeholder="Lesson Active Time">
																</div>
															</div>
														</div>

														<div class="col-3 mt-10">
															<div class="help-block">SMS Vendor</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="<?php print $this->system_setting_m->_SMS_VENDOR ?>">
																<option value="">Select vendor</option>
																<option value="akspk" <?php print $this->SETTINGS[$this->system_setting_m->_SMS_VENDOR]=='akspk'?'selected' :'';?>>akspk.com</option>
																<option value="dotclick" <?php print $this->SETTINGS[$this->system_setting_m->_SMS_VENDOR]=='dotclick'?'selected' :'';?>>dotclick.com</option>
															</select>
														</div>
														<div class="col-3 mt-10">
															<div class="ui search focus">
																<div class="help-block">Username / Mobile Number</div>
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="<?php print $this->system_setting_m->_SMS_API_USERNAME ?>" value="<?php print $this->SETTINGS[$this->system_setting_m->_SMS_API_USERNAME] ?>" placeholder="Username / Mobile Number">
																</div>
															</div>
														</div>
														<div class="col-4 mt-10">
															<div class="ui search focus">
																<div class="help-block">Password / API Key</div>
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="<?php print $this->system_setting_m->_SMS_API_KEY ?>" value="<?php print $this->SETTINGS[$this->system_setting_m->_SMS_API_KEY] ?>"  placeholder="Password / API Key">
																</div>
															</div>
														</div>
														<div class="col-2 mt-10">
															<div class="ui search focus">
																<div class="help-block">Sender ID / Masking</div>
																<div class="ui left icon input swdh11 swdh19">
																	<input class="prompt srch_explore" type="text" name="<?php print $this->system_setting_m->_SMS_MASK ?>" value="<?php print $this->SETTINGS[$this->system_setting_m->_SMS_MASK] ?>" placeholder="Sender ID / Masking">
																</div>
															</div>
														</div>
														<div class="col-12"><div class="divider-1"></div></div>
														<div class="col-lg-12">
															<br><p class="help-block">
															<span>* Lecture active time is lesson start time. E.g. if set 8AM then student can view the lesson after 8AM on specified date.(8 AM = 8*60=480)</span><br>
															<span>* Set your local timezone so that quiz test and paper time can be calculated accordingly.</span><br>
															<span>* Visit <a href="https://akspk.com">akspk.com</a> to get your API Credentials.</span><br>
															</p>
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
						<div class="tab-pane fade <?php print $tab=='action'? 'show active':'';?>" id="pills-action" role="tabpanel" aria-labelledby="pills-action-tab">
							<div class="account_setting">
								<div class="row">
									<div class="col-6">										
										<h4>General Actions</h4><hr>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											Force students to <a href="<?php print $this->CONT_ROOT.'do_action?action=frp_std';?>">Change Password on the next login </a><br>
											<small>-Click here if you want every student to change password on their next login. They will not be able to access the dashboard without changing password.</small>
										</p>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											Force staff/teachers to <a href="<?php print $this->CONT_ROOT.'do_action?action=frp_stf';?>">Change Password on the next login </a><br>
											<small>-Click here if you want every staff/teachers to change password on their next login. They will not be able to access the dashboard without changing password.</small>
										</p>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											<a href="<?php print $this->CONT_ROOT.'do_action?action=unblock';?>">Clear failed login cache</a> for all blocked logins<br>
											<small>-If a student/staff try to login with wrong ID and password then system restrict their access after 5 invalid attempts. You can reset login cache to allow users to login once again..</small>
										</p>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											<a href="<?php print $this->CONT_ROOT.'do_action?action=recheck';?>">Re-validate configurations &amp; Settings</a> once again<br>
											<small>-If system is behaving abnormal then you can re-validate the configuration and settings once. Please contact support team if problem is still there.</small>
										</p>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											<a href="<?php print $this->CONT_ROOT.'do_action?action=redo_id&key=lms&confirm=0';?>">Re-assign student ID's</a> once again<br>
											<small>-Assign ID's to all students once again. starting from 1000-99999. Provide <code>&key=lms</code> in the url for custom student keys. Default student key is lms.</small>
										</p>
									</div>
									<div class="col-6">
										<h4>Database Actions</h4><hr>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span></strong>
											<a href="<?php print $this->CONT_ROOT.'savebackup';?>">Click Here </a> to download database backup.<br>
											<small>-You can restore the backup via phpmyadmin import interface.</small>
										</p>
										<br>
										<h4>Session Actions</h4><hr>
										<p class="bb-dotted">
											<strong> Action<span class="text-danger">:-</span> </strong>
											<a href="<?php print $this->CONT_ROOT.'do_action?action=start_session';?>" onclick="return confirm('Please note that it will remove all data of previous session. You can not reverse this action.');">Click Here </a> to clear all the data of previous session.<br>
											<small>-At the start of new session, you need to clear all the data of previous session. To help you in th process we have created this one click tool. All assignments, chats, group messages, quiz tests , papers, attendance log, and watch log will be removed from the database.</small>
										</p>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade <?php print $tab=='logo'? 'show active':'';?>" id="pills-logo" role="tabpanel" aria-labelledby="pills-logo-tab">
								<div class="account_setting">
									<h4>Upload your logo</h4>
									<p>Here you can change logo of your organization..</p>
									<?php echo form_open_multipart($this->CONT_ROOT.'upload_logo');?> 
									<div class="basic_profile">
										<div class="basic_form">
											<div class="row">
												<div class="col-lg-8">

														<input type="file" name="file">
														<br><br>										
												</div>
											</div>
										</div>
									</div>
									<button class="save_btn" type="submit">Upload Logo</button>
									<?php echo form_close(); ?>
								</div>
						</div>
						<div class="tab-pane fade <?php print $tab=='sms'? 'show active':'';?>" id="pills-sms" role="tabpanel" aria-labelledby="pills-sms-tab">

							<form action="<?php print $this->CONT_ROOT.'sendsms';?>" method="post">
								<div class="row">
									<div class="col-lg-4 col-md-4">
										<div class="mt-20 lbel25">	
											<label class="help-block">Select Class</label>
										</div>
										<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="class_id">
											<option value="">All Classes</option>
											<?php foreach($classes as $id=>$name){ ?>
											<option value="<?php print $id; ?>"><?php print $name;?></option>
											<?php } ?>
										</select>
									</div> 
									<?php if(is_array($groups) && count($groups)>0){ ?>
									<div class="col-lg-4 col-md-4">
										<div class="mt-20 lbel25">	
											<label class="help-block">Select Group</label>
										</div>
										<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="group_id">
											<option value="">Select Group</option>
											<?php foreach($groups as $id=>$name){ ?>
											<option value="<?php print $id; ?>"><?php print $name;?></option>
											<?php } ?>
										</select>
									</div>
									<?php } ?>
									<?php if(is_array($sections) && count($sections)>0){ ?>
									<div class="col-lg-4 col-md-4">
										<div class="mt-20 lbel25">	
											<label class="help-block">Select Section</label>
										</div>
										<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
											<option value="">All Sections</option>
											<?php foreach($sections as $id=>$name){ ?>
											<option value="<?php print $id; ?>"><?php print $name;?></option>
											<?php } ?>
										</select>
									</div>
									<?php } ?>
								</div>	
								<hr>
								<div class="row">									
									<div class="col-8">
										<div class="ui search focus">
											<div class="help-block">Write down the student if you want to send the message to single student or leave blank</div>
											<div class="ui input swdh11">
												<input class="prompt srch_explore" type="text" name="student_id" placeholder="Enter Student ID or leave blank">
											</div>
										</div>
									</div>
								</div>
								<div class="account_setting">
									<h4>Send SMS Notification to all students</h4>
									<p>You can use following keys to for students...<br>
										{NAME} : Student Name <br>
										{CLASS} : Student CLASS <br>
										{ROLLNO} : Student Roll Number <br>
										{ID} : Student ID <br>
										{NEWPASSWORD} : Only if you want to reset password of every student.<br>
									</p>
									<div class="col-lg-12">
										<div class="ui search focus mt-10">																
											<div class="ui form swdh30">
												<div class="field">
													<textarea rows="5" name="message" placeholder="Write your message here..."></textarea>
												</div>
											</div>
										</div>
									</div>
									<button class="save_btn" type="submit" onclick="showWait()">Send Message</button>
									<p id="wait-message" class="bg-success color-white p-5 hidden"> Please wait!!! System is now sending sms to all students.</p>
								</div>
							</form>
						</div>
						<div class="tab-pane fade <?php print $tab=='staffsms'? 'show active':'';?>" id="pills-staff-sms" role="tabpanel" aria-labelledby="pills-staff-sms-tab">
							<form action="<?php print $this->CONT_ROOT.'sendstaffsms';?>" method="post">
								<div class="row">									
									<div class="col-8">
										<div class="ui search focus">
											<div class="help-block">Write down the staff if you want to send the message to single staff or leave blank</div>
											<div class="ui input swdh11">
												<input class="prompt srch_explore" type="text" name="staff_id" placeholder="Enter Staff ID or leave blank">
											</div>
										</div>
									</div>
								</div>
								<div class="account_setting">
									<h4>Send SMS Notification to all teachers</h4>
									<p>You can use following keys to for teachers...<br>
										{NAME} : Teacher Name <br>
										{ID} : Teacher ID <br>
										{NEWPASSWORD} : Only if you want to reset password of every teacher.<br>
									</p>
									<div class="col-lg-12">
										<div class="ui search focus mt-10">																
											<div class="ui form swdh30">
												<div class="field">
													<textarea rows="5" name="message" placeholder="Write your message here..."></textarea>
												</div>
											</div>
										</div>
									</div>
									<button class="save_btn" type="submit" onclick="showWait()">Send Message</button>
									<p id="wait-message-staff" class="bg-success color-white p-5 hidden"> Please wait!!! System is now sending sms to all teachers.</p>
								</div>
							</form>
						</div>
						<div class="tab-pane fade <?php print $tab=='bulkpc'? 'show active':'';?>" id="pills-bulk-pc" role="tabpanel" aria-labelledby="pills-bulk-pc-tab">
							<form action="<?php print $this->CONT_ROOT.'bulkpc';?>" method="post">
								<div class="account_setting">
									<h4>Change password for complete class in one click</h4>
									<div class="row">									
										<div class="col-lg-4 col-md-4">
											<div class="mt-20 lbel25">	
												<label>Select Class<span class="text-danger">*</span></label>
											</div>
											<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="class_id" required="">
												<option value="">Select Class</option>
												<?php foreach($classes as $id=>$name){ ?>
												<option value="<?php print $id; ?>"><?php print $name;?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-md-4">
											<div class="mt-20 lbel25">	
												<label>Select Section</label>
											</div>
											<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
												<option value="">All Sections</option>
												<option value="0">All Sections</option>
												<?php foreach($sections as $id=>$name){ ?>
												<option value="<?php print $id; ?>"><?php print $name;?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-4 col-md-4">	
											<div class="ui search focus mt-20 lbel25">
												<label>New Password<span class="text-danger">*</span></label>
												<div class="ui left icon input swdh19">
													<input class="prompt srch_explore" type="text" name="password" value="" required="" min="1" max="99" placeholder="Enter New Password">															
												</div>
											</div>										
										</div>	
									</div>	
									<button class="save_btn" type="submit">Change Password</button>
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
