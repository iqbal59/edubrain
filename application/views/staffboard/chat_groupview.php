
<!-- Body Start -->
<div class="wrapper" ng-controller="mozzCtrl"  ng-cloak>
	<div class="sa4d25">
		<div class="container-fluid" ng-init="rid='<?php print $row->mid;?>'">
			<div class="row">
				<div class="col-12">
					<div class="all_msg_bg">
						<div class="row no-gutters">
							<div class="col-xl-12 col-lg-12 col-md-12">			
								<div class="chatbox_right">
									<div class="chat_header">
										<div class="user-status">
											<p class="user-status-title"> Messages of <span class="bold"><?php print $row->name ?></span> Group</p>					
										</div>
									</div>
									<div class="messages-line simplebars-content-wrapper2 scrollstyle_4">											
										<div class="mCustomScrollbar">	
											<div ng-repeat="row in responseData.rows">
												<div class="main-message-box ta-right" ng-show="row.staff_id > 0">
													<div class="message-dt" ng-show="row.message.length > 0">
														<div class="message-inner-dt">
															<p>{{row.message}}</p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.staff_name}}</span>
													</div><!--message-dt end-->
													<div class="message-dt" ng-show="row.image.length > 0">
														<div class="message-inner-dt">
															<p><img ng-src="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.image}}" width="100%"></p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.staff_name}} <a ng-href="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.image}}" target="_blank">View</a></span>
													</div><!--message-dt end-->
													<div class="message-dt" ng-show="row.file.length > 0">
														<div class="message-inner-dt">
															<p>{{row.staff_name}} has uploaded a file. Please click on download to save the file.</p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.staff_name}} <a ng-href="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.file}}" target="_blank">Download</a></span>
													</div><!--message-dt end-->
												</div><!--main-message-box end-->


												<div class="main-message-box st3" ng-show="row.student_id > 0">
													<div class="message-dt st3" ng-show="row.message.length > 0">
														<div class="message-inner-dt">
															<p>{{row.message}}</p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.student_name}}</span>
													</div><!--message-dt end-->
													<div class="message-dt st3" ng-show="row.image.length > 0">
														<div class="message-inner-dt">
															<p><img ng-src="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.image}}" width="100%"></p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.student_name}} <a ng-href="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.image}}" target="_blank">View</a></span>
													</div><!--message-dt end-->
													<div class="message-dt st3" ng-show="row.file.length > 0">
														<div class="message-inner-dt">
															<p>{{row.student_name}} has uploaded a file. Please click on download to save the file.</p>
														</div><!--message-inner-dt end-->
														<br><span>{{row.time}} by {{row.student_name}} <a ng-href="<?php print $this->UPLOADS_ROOT.'files/chat/';?>{{row.file}}" target="_blank">Download</a></span>
													</div><!--message-dt end-->
												</div><!--main-message-box end-->
												
											</div>	
										</div>
									</div>
									<div id="cBottom"></div>
									<div class="message-send-area">
											<div class="mf-field">
												<div class="ui search focus input__msg">
													<div class="ui left icon input swdh19">
														<textarea class="prompts srch_explore" ng-model="message" placeholder="Write a message..." rows="3" cols="800"></textarea>
													</div>
												</div>
												<button class="add_msg"><i class="uil uil-message" ng-click="sendGroupMessage()"></i></button>
											</div>
										<hr>
										<?php echo form_open_multipart($this->CONT_ROOT.'group_upload_picture');?> 
											<input type="hidden" name="rid" value="<?php print $row->mid;?>">
											<input type="file" name="file">
											<button class="add_msgs" type="submit"><i class="uil uil-message"></i>Upload</button>										
										<?php echo form_close(); ?>
									</div>
								</div>
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
