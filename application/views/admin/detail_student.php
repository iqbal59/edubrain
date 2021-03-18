
<!-- Body Start -->
<div class="wrapper _bg4586">

	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">
								<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/students/'.$row->mid;?>" class="_216b22">										
									<span><i class="uil uil-user"></i></span>Edit Profile
								</a>
								<div class="dp_dt150">						
									<div class="img148">
										<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$row->image;?>" alt="">										
									</div>
									<div class="prfledt1">
										<h2><?php print ucwords($row->name);?></h2>
										<span>
											Class: <?php print ucwords($classes[$row->class_id]); ?> 
											<?php if($row->section_id>0){print '('.$sections[$row->section_id].')';} ?>
											<?php if($row->group_id>0){print ' - '.$groups[$row->group_id].'';} ?>
										</span><br>
										<span>Roll Number: <?php print $row->roll_number; ?></span>
									</div>										
								</div>
								<ul class="_ttl120">
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Watch Time</div>
											<div class="_ttl123"><?php print human_time($total_watch_time); ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Today Time</div>
											<div class="_ttl123"><?php print human_time($today_watch_time); ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122"><?php print date("F"); ?> Presence</div>
											<div class="_ttl123"><?php print $daily_att_percent;?>%</div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Subjects</div>
											<div class="_ttl123"><?php print count($subjects); ?></div>
										</div>
									</li>
								</ul>
							</div>
							<div class="col-lg-5">
								<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/students/'.$row->mid;?>" class="_216b12">										
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
								<a class="nav-item nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">About</a>
								<a class="nav-item nav-link" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Subjects</a>
								<a class="nav-item nav-link" id="nav-attend-tab" data-toggle="tab" href="#nav-attend" role="tab" aria-selected="false">Daily Attendance</a>
								<a class="nav-item nav-link" id="nav-attendancelog-tab" data-toggle="tab" href="#nav-attendancelog" role="tab" aria-selected="false">Attendance Log</a>
								<a class="nav-item nav-link" id="nav-activitylog-tab" data-toggle="tab" href="#nav-activitylog" role="tab" aria-selected="false">Activity Log</a>
								<a class="nav-item nav-link" id="nav-lessonlog-tab" data-toggle="tab" href="#nav-lessonlog" role="tab" aria-selected="false">Lesson Watch Log</a>
								<a class="nav-item nav-link" id="nav-loginlog-tab" data-toggle="tab" href="#nav-loginlog" role="tab" aria-selected="false">Login History</a>
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
							<div class="tab-pane fade show active" id="nav-about" role="tabpanel">
								<div class="_htg451">
									<div class="_htg452">
										<h3>About <?php print ucwords($row->name); ?></h3>

										<div class="row">						
											<div class="col-lg-7">
												<p>
													<span><b>Student Name : </b><?php print ucwords($row->name); ?></span><br>
													<span><b>Father Name : </b><?php print ucwords($row->father_name); ?></span><br>
													<span><b>Mobile Number : </b><?php print ucwords($row->mobile); ?></span><br>
													<span><b>City : </b><?php print ucwords($row->city); ?></span><br>
													<span><b>Address : </b><?php print ucwords($row->address); ?></span><br>
													<span><b>Registered On : </b><?php print ucwords($row->date); ?></span><br>
												</p>
											</div>
											<div class="col-lg-5">		
												<p>Update Profile Picture</p>										
												<?php echo form_open_multipart($this->CONT_ROOT.'upload_picture');?> 
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
							<div class="tab-pane fade" id="nav-courses" role="tabpanel">
								<div class="crse_content">
									<h3>My Subjects (<?php print count($subjects); ?>)</h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject Name</th>
															<th class="text-center" scope="col">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($subjects as $subject){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subject['name']; ?></td>
																<td class="text-center">
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
							<div class="tab-pane fade" id="nav-reviews" role="tabpanel">
								<div class="student_reviews">
									<div class="row">
										<div class="col-lg-12">
											<div class="review_right">
												<div class="review_right_heading">
													<h3>Discussions</h3>
												</div>
											</div>
											<div class="cmmnt_1526">
												<div class="cmnt_group">
													<div class="img160">
														<img src="images/left-imgs/img-1.jpg" alt="">										
													</div>
													<textarea class="_cmnt001" placeholder="Add a public comment"></textarea>
												</div>
												<button class="cmnt-btn" type="submit">Comment</button>
											</div>
											<div class="review_all120">
												<div class="review_item">
													<div class="review_usr_dt">
														<img src="images/left-imgs/img-1.jpg" alt="">
														<div class="rv1458">
															<h4 class="tutor_name1">John Doe</h4>
															<span class="time_145">2 hour ago</span>
														</div>
														<div class="eps_dots more_dropdown">
															<a href="#"><i class="uil uil-ellipsis-v"></i></a>
															<div class="dropdown-content">
																<span><i class='uil uil-comment-alt-edit'></i>Edit</span>
																<span><i class='uil uil-trash-alt'></i>Delete</span>
															</div>																											
														</div>
													</div>
													<p class="rvds10">Nam gravida elit a velit rutrum, eget dapibus ex elementum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
													<div class="rpt101">
														<a href="#" class="report155"><i class='uil uil-thumbs-up'></i> 10</a>
														<a href="#" class="report155"><i class='uil uil-thumbs-down'></i> 1</a>
														<a href="#" class="report155"><i class='uil uil-heart'></i></a>
														<a href="#" class="report155 ml-3">Reply</a>
													</div>
												</div>
												<div class="review_reply">
													<div class="review_item">
														<div class="review_usr_dt">
															<img src="images/left-imgs/img-3.jpg" alt="">
															<div class="rv1458">
																<h4 class="tutor_name1">Rock Doe</h4>
																<span class="time_145">1 hour ago</span>
															</div>
															<div class="eps_dots more_dropdown">
																<a href="#"><i class="uil uil-ellipsis-v"></i></a>
																<div class="dropdown-content">
																	<span><i class='uil uil-trash-alt'></i>Delete</span>
																</div>																											
															</div>
														</div>
														<p class="rvds10">Fusce lacinia, nunc sit amet tincidunt venenatis.</p>
														<div class="rpt101">
															<a href="#" class="report155"><i class='uil uil-thumbs-up'></i> 4</a>
															<a href="#" class="report155"><i class='uil uil-thumbs-down'></i> 2</a>
															<a href="#" class="report155"><i class='uil uil-heart'></i></a>
															<a href="#" class="report155 ml-3">Reply</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="nav-attendancelog" role="tabpanel">
								<div class="crse_content">
									<h3>Student Attendance Log </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject</th>
															<th class="cell-ta"> Attendance Date &amp; Time</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($att_log as $log){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subjects_arr[$log['subject_id']]; ?></td>
																<td class="cell-ta"><?php print $log['datetime']; ?></td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade" id="nav-attend" role="tabpanel">
								<div class="crse_content">
									<h3>Student Daily Attendance (<?php print date('M-Y') ?>)</h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">Date</th>
															<?php foreach($subjects as $sub){?>
															<th class="cell-ta"><?php print ucwords($sub['name']); ?></th>
															<?php } ?>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														$days=days_in_month($this->user_m->month,$this->user_m->year);
														for($d=1;$d<=$days;$d++){
														 ?>
							                                <tr>
																<td class="text-center"><?php print $d.'-'.date('M-Y'); ?></td>
																<?php foreach($subjects as $sub){?>
																<td class="cell-ta">
																	<?php print $daily_att_log[$d][$sub['mid']]; ?>
																</td>
																<?php } ?>
																
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade" id="nav-activitylog" role="tabpanel">
								<div class="crse_content">
									<h3>Student Activity Log </h3>
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
							<div class="tab-pane fade" id="nav-lessonlog" role="tabpanel">
								<div class="crse_content">
									<h3>Student Lesson Time Log </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject</th>
															<th class="cell-ta">Lesson</th>
															<th class="cell-ta">Start Time</th>
															<th class="cell-ta">End Time</th>
															<th class="cell-ta">Date </th>
															<th class="cell-ta">Total Watch Time</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($time_log as $log){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subjects_arr[$log['subject_id']]; ?></td>
																<td class="cell-ta"><?php print $lessons[$log['subject_id']]; ?></td>
																<td class="cell-ta"><?php print $log['start_time']; ?></td>
																<td class="cell-ta"><?php print $log['end_time']; ?></td>
																<td class="cell-ta"><?php print $log['date']; ?></td>
																<td class="cell-ta"><?php print human_time($log['total_time']); ?></td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade" id="nav-loginlog" role="tabpanel">
								<div class="crse_content">
									<h3>Student Login History </h3>
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
