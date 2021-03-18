
<!-- Body Start -->
<div class="wrapper _bg4586">
	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-12">								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Class: <?php print ucwords($row->name);?></h2>
										<span>Total Quizzes: <?php print count($quizez); ?> </span> |
										<span>Total Papers: <?php print $total_paper; ?></span>
									</div>										
								</div>
								<ul class="_ttl120">
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Students</div>
											<div class="_ttl123"><?php print $total_student; ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Subjects</div>
											<div class="_ttl123"><?php print count($subjects); ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Lessons</div>
											<div class="_ttl123"><?php print $total_lesson;?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Questions</div>
											<div class="_ttl123"><?php print $total_qbank; ?></div>
										</div>
									</li>
								</ul>
							</div>												
						</div>								
						<div class="row">						
							<div class="col-lg-12">
								<br>
								<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/quiz/'.$row->mid;?>" class=" color-white">
									<span><i class="uil uil-file-plus"></i></span>Generate Quiz
								</a> 
								 |
								<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paper/'.$row->mid;?>" class="color-white">
									<span><i class="uil uil-file-plus"></i></span>Generate Paper
								</a>
								 |
								<a href="<?php print $this->LIB_CONT_ROOT.'add/mdl/datesheet/?cid='.$row->mid;?>" class="color-white">
									<span><i class="uil uil-cloud-upload"></i></span>Upload Date Sheet
								</a>	
								 |
								<a href="<?php print $this->LIB_CONT_ROOT.'add/mdl/syllabus/?cid='.$row->mid;?>" class="color-white">
									<span><i class="uil uil-cloud-upload"></i></span>Upload Syllabus
								</a>	
								 |
								<a href="<?php print $this->LIB_CONT_ROOT.'add/mdl/timetable/?cid='.$row->mid;?>" class="color-white">
									<span><i class="uil uil-cloud-upload"></i></span>Upload Time Table
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
							<div class="nav nav-tabs tab_crse-s" id="nav-tab" role="tablist">
								<a class="nav-item nav-link text-success <?php empty($tab) ? print 'active' : ''; ?>" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">About</a>
								<a class="nav-item nav-link text-info <?php strtolower($tab)=='subjects' ? print 'active' : ''; ?>" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Subjects</a>
								<a class="nav-item nav-link text-danger <?php strtolower($tab)=='quiz' ? print 'active' : ''; ?>" id="nav-quiz-tab" data-toggle="tab" href="#nav-quiz" role="tab" aria-selected="false">Quiz(s)</a>
								<a class="nav-item nav-link text-warning <?php strtolower($tab)=='paper' ? print 'active' : ''; ?>" id="nav-paper-tab" data-toggle="tab" href="#nav-paper" role="tab" aria-selected="false">Paper(s)</a>
								<a class="nav-item nav-link text-success <?php strtolower($tab)=='datesheet' ? print 'active' : ''; ?>" id="nav-datesheet-tab" data-toggle="tab" href="#nav-datesheet" role="tab" aria-selected="false">Date Sheet</a>
								<a class="nav-item nav-link text-info <?php strtolower($tab)=='syllabus' ? print 'active' : ''; ?>" id="nav-syllabus-tab" data-toggle="tab" href="#nav-syllabus" role="tab" aria-selected="false">Syllabus</a>
								<a class="nav-item nav-link text-danger <?php strtolower($tab)=='timetable' ? print 'active' : ''; ?>" id="nav-timetable-tab" data-toggle="tab" href="#nav-timetable" role="tab" aria-selected="false">Time Table</a>
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
							<div class="tab-pane fade <?php empty($tab) ? print 'show active' : ''; ?>" id="nav-about" role="tabpanel">
								<div class="_htg451">
									<div class="_htg452">
										<h3>About <?php print ucwords($row->name); ?></h3>

										<div class="row">						
											<div class="col-lg-7">
												<p>
													<span><b>Class Name : </b><?php print ucwords($row->name); ?></span><br>
												</p>
											</div>
											
										</div>
									</div>																	
								</div>							
							</div>
							<div class="tab-pane fade <?php strtolower($tab)=='subjects' ? print 'show active' : ''; ?>" id="nav-courses" role="tabpanel">
								<div class="crse_content">
									<h3>Class Subjects (<?php print count($subjects); ?>)</h3>
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
							<div class="tab-pane fade <?php strtolower($tab)=='quiz' ? print 'show active' : ''; ?>" id="nav-quiz" role="tabpanel">
								<div class="crse_content">
									<h3>Class Quiz(s) </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject</th>
															<th class="cell-ta">Quiz</th>
															<th class="cell-ta">Marks</th>
															<th class="cell-ta">Start Date &amp; Time</th>
															<th class="cell-ta">Actions</th>
															<th class="cell-ta">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($quizez as $qz){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subjects_arr[$qz['subject_id']]; ?></td>
																<td class="cell-ta"><?php print $qz['name']; ?></td>
																<td class="cell-ta"><?php print $qz['marks']; ?></td>
																<td class="cell-ta"><?php print $qz['date'].' '.get_time_from_minutes($qz['start_time'],false,true); ?></td>
																<td>
																	<?php if($qz['jd']<=$this->user_m->todayjd){ ?>
																	<a href="<?php print $this->LIB_CONT_ROOT.'analytics/report/quiz/'.$qz['mid'];?>" title="View Report">View Report</a>
																	<?php }else{
																		print '<span class="text-info">Awaiting Result</span>';
																	} ?>
																</td>
																<td>
																	<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/quiz/'.$qz['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
																	<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/quizbank/'.$qz['mid'];?>" title="Question Bank" class="gray-s"><i class="uil uil-database"></i></a>
																	<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/quiz/?rid='.$qz['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
							<div class="tab-pane fade <?php strtolower($tab)=='paper' ? print 'show active' : ''; ?>" id="nav-paper" role="tabpanel">
								<div class="crse_content">
									<h3>Class Paper(s) </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Subject</th>
															<th class="cell-ta">Paper</th>
															<th class="cell-ta">Marks</th>
															<th class="cell-ta">Start Date &amp; Time</th>
															<th class="cell-ta">Actions</th>
															<th class="cell-ta">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($papers as $pp){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $subjects_arr[$pp['subject_id']]; ?></td>
																<td class="cell-ta"><?php print $pp['name']; ?></td>
																<td class="cell-ta"><?php print $pp['marks']; ?></td>
																<td class="cell-ta"><?php print $pp['date'].' '.get_time_from_minutes($pp['start_time'],false,true); ?></td>
																<td>
																	<?php if($pp['jd']<=$this->user_m->todayjd){ ?>
																	<a href="<?php print $this->LIB_CONT_ROOT.'analytics/report/paper/'.$pp['mid'];?>" title="View Report">View Report</a>
																	<?php }else{
																		print '<span class="text-info">Awaiting Result</span>';
																	} ?>
																</td>
																<td>
																	<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/paper/'.$pp['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
																	<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paperbank/'.$pp['mid'];?>" title="Question Bank" class="gray-s"><i class="uil uil-database"></i></a>
																	<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/paper/?rid='.$pp['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
							<div class="tab-pane fade <?php strtolower($tab)=='datesheet' ? print 'show active' : ''; ?>" id="nav-datesheet" role="tabpanel">
								<div class="crse_content">
									<h3>Class Date Sheet </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Title</th>
															<th class="cell-ta">Section</th>
															<th class="cell-ta">Actions</th>
															<th class="cell-ta">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($datesheet as $prow){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $prow['title']; ?></td>
																<?php if(intval($prow['section_id'])>0){ ?>
																<td class="cell-ta"><?php print isset($sections[$prow['section_id']]) ? $sections[$prow['section_id']] :''; ?></td>
																<?php }else{ ?>
																	<td class="cell-ta">All Sections</td>
																<?php } ?>
																<td>
																	<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$prow['file'];?>" title="View File">View </a>
																</td>
																<td>
																	<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/datesheet/?rid='.$prow['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
							<div class="tab-pane fade <?php strtolower($tab)=='syllabus' ? print 'show active' : ''; ?>" id="nav-syllabus" role="tabpanel">
								<div class="crse_content">
									<h3>Class Syllabus </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Title</th>
															<th class="cell-ta">Section</th>
															<th class="cell-ta">Actions</th>
															<th class="cell-ta">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($syllabus as $prow){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $prow['title']; ?></td>
																<?php if(intval($prow['section_id'])>0){ ?>
																<td class="cell-ta"><?php print isset($sections[$prow['section_id']]) ? $sections[$prow['section_id']] :''; ?></td>
																<?php }else{ ?>
																	<td class="cell-ta">All Sections</td>
																<?php } ?>
																<td>
																	<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$prow['file'];?>" title="View File">View </a>
																</td>
																<td>
																	<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/syllabus/?rid='.$prow['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
							<div class="tab-pane fade <?php strtolower($tab)=='timetable' ? print 'show active' : ''; ?>" id="nav-timetable" role="tabpanel">
								<div class="crse_content">
									<h3>Class Timetable </h3>
									<div class="_14d25">
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Title</th>
															<th class="cell-ta">Section</th>
															<th class="cell-ta">Actions</th>
															<th class="cell-ta">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														foreach($timetable as $prow){
															$i++;
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="cell-ta"><?php print $prow['title']; ?></td>
																<?php if(intval($prow['section_id'])>0){ ?>
																<td class="cell-ta"><?php print isset($sections[$prow['section_id']]) ? $sections[$prow['section_id']] :''; ?></td>
																<?php }else{ ?>
																	<td class="cell-ta">All Sections</td>
																<?php } ?>
																<td>
																	<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$prow['file'];?>" title="View File">View </a>
																</td>
																<td>
																	<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/timetable/?rid='.$prow['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
