
<!-- Body Start -->
<div class="wrapper _bg4586">

	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">
								<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/staff/'.$row->mid;?>" class="_216b22">										
									<span><i class="uil uil-user"></i></span>Edit Profile
								</a>
								<div class="dp_dt150">						
									<div class="img148">
										<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$row->image;?>" alt="">										
									</div>
									<div class="prfledt1">
										<h2><?php print ucwords($row->name);?></h2>
										<span>Login ID: <?php print $row->staff_id; ?></span><br>
										<span>Since: <?php print $row->date; ?></span>
									</div>										
								</div>
								
							</div>
							<div class="col-lg-5">
								<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/staff/'.$row->mid;?>" class="_216b12">										
									<span><i class="uil uil-user"></i></span>Edit Profile
								</a>
								
								
							</div>													
						</div>		
					</div>							
				</div>															
			</div>
		</div>
	</div>
	<div class="_215b15">
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>					
			<div class="row">
				<div class="col-lg-12">						
					<div class="course_tabs">
						<nav>
							<div class="nav nav-tabs tab_crse" id="nav-tab" role="tablist">
								<a class="nav-item nav-link <?php print empty($tab)||$tab=='home'? 'active' : '';?>" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">About</a>
								<a class="nav-item nav-link <?php print $tab=='subjects'? 'active':'';?>" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Subjects</a>
								<a class="nav-item nav-link <?php print $tab=='activity'? 'active':'';?>" id="nav-activitylog-tab" data-toggle="tab" href="#nav-activitylog" role="tab" aria-selected="false">Activity Log</a>
								<a class="nav-item nav-link <?php print $tab=='login'? 'active':'';?>" id="nav-loginlog-tab" data-toggle="tab" href="#nav-loginlog" role="tab" aria-selected="false">Login History</a>
							</div>
						</nav>						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="_215b17">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="course_tab_content">
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade <?php print empty($tab)||$tab=='home'? 'show active':'';?>" id="nav-about" role="tabpanel">
								<div class="_htg451">
									<div class="_htg452">
										<h3>About <?php print ucwords($row->name); ?></h3>

										<div class="row">						
											<div class="col-lg-7">
												<p>
													<span><b>Staff Name : </b><?php print ucwords($row->name); ?></span><br>
													<span><b>Father Name : </b><?php print ucwords($row->father_name); ?></span><br>
													<span><b>Mobile Number : </b><?php print ucwords($row->mobile); ?></span><br>
													<span><b>City : </b><?php print ucwords($row->city); ?></span><br>
													<span><b>Address : </b><?php print ucwords($row->address); ?></span><br>
													<span><b>Registered On : </b><?php print ucwords($row->date); ?></span><br>
												</p>
											</div>
											<div class="col-lg-5">		
												<p>Update Profile Picture</p>										
												<?php echo form_open_multipart($this->CONT_ROOT.'upload_picture_staff');?> 
													<input type="hidden" name="rid" value="<?php print $row->mid;?>">
													<input type="file" name="file">
													<br><br>
													<button class="upload_btn" type="submit"><i class="uil uil-message"></i>Upload Photo</button>										
												<?php echo form_close(); ?>
											</div>
										</div>
									</div>																	
								</div>							
							</div>
							<div class="tab-pane fade <?php print $tab=='subjects'? 'show active':'';?>" id="nav-courses" role="tabpanel">
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingOne">
											<div class="panel-title adcrse1250">
												<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
													Assign New Subject
												</a>
											</div>
										</div>
										<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body adcrse_body">
												<form action="<?php print $this->CONT_ROOT.'save/staff/'.$row->mid;?>" method="post">
													<input type="hidden" name="rid" value="<?php print $row->mid;?>">
													<div class="row">
														<div class="col-lg-12">
															<div class="discount_form">
																<div class="row">
																	<div class="col-lg-10 col-md-10">
																		<div class="mt-20 lbel25">	
																			<label>Select Subject</label>
																		</div>
																		<select class="ui hj145 dropdown  srch_explore search" name="subjects[]" multiple="multiple">
																			<option value="">Select Course</option>
																			<?php foreach($subjects as $subject){ ?>
																			<option value="<?php print $subject['mid']; ?>"><?php print $subject['name'].' (class : '.$classes[$subject['class_id']].') ';?></option>
																			<?php } ?>
																		</select>
																	</div>
																	<div class="col-lg-6 col-md-6">	
																		<button class="discount_btn" type="submit">Save Changes</button>										
																	</div>
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="crse_content">
									<h3>My Subjects (<?php print count($staff_subjects); ?>)</h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject Name</th>
															<th class="text-center">Class Name</th>
															<th class="text-center" scope="col">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($staff_subjects as $subject){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subjects_arr[$subject['subject_id']]; ?></td>
																<td class="text-center"><?php print $classes[$subject['class_id']]; ?></td>
																<td class="text-center">
																	<a href="<?php print $this->LIB_CONT_ROOT.'detail/del/staff/?rid='.$subject['mid'].'&sid='.$row->mid;?>" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a> 
																</td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade <?php print $tab=='activity'? 'show active':'';?>" id="nav-activitylog" role="tabpanel">
								<div class="crse_content">
									<h3>Staff Activity Log </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Action</th>
															<th class="cell-ta">Date &amp; Time</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($activity_log as $log){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $log['Message']; ?></td>
																<td class="cell-ta"><?php print $log['date']; ?></td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade <?php print $tab=='login'? 'show active':'';?>" id="nav-loginlog" role="tabpanel">
								<div class="crse_content">
									<h3>Staff Login History </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Ip Address</th>
															<th class="cell-ta">Date &amp; Time</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($login_log as $log){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $log['ip_address']; ?></td>
																<td class="cell-ta"><?php print $log['date']; ?></td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
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
