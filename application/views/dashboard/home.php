
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'profile';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-info"><i class="uil uil-user-square"></i></span>
							<h2 class="db-h2">My Profile</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'classlinks';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-danger"><i class="uil uil-laptop-cloud"></i></span>
							<h2 class="db-h2">Online Classes</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'subjects';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-success"><i class="uil uil-home"></i></span>
							<h2 class="db-h2">Homework</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'view/syllabus';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-warning"><i class="uil uil-book-open"></i></span>
							<h2 class="db-h2">Syllabus</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'view/timetable';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-danger"><i class="uil uil-clock-nine"></i></span>
							<h2 class="db-h2">Time Table</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'view/datesheet';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-danger"><i class="uil uil-clock-nine"></i></span>
							<h2 class="db-h2">Date Sheet</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'timetable';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-info"><i class="uil uil-home"></i></span>
							<h2 class="db-h2">Lesson Plan</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'quiz';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-warning"><i class="uil uil-clipboard-notes"></i></span>
							<h2 class="db-h2">MCQ Test</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'quiz/result';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-success"><i class="uil uil-tachometer-fast"></i></span>
							<h2 class="db-h2">Quiz Test Result</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'paper';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-danger"><i class="uil uil-clipboard-alt"></i></span>
							<h2 class="db-h2">Paper(s)</h2>
						</div>
					</a>
				</div>
				<div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3">
					<a href="<?php print $this->LIB_CONT_ROOT.'paper/result';?>" class="db-link">
						<div class="card_dash">
							<span class="db-icon text-success"><i class="uil uil-tachometer-fast"></i></span>
							<h2 class="db-h2">Paper Result</h2>
						</div>
					</a>
				</div>	
			</div>
			<div class="row">
				<div class="col-xl-6 col-lg-8 col-md-8">
					<div class="section3125 mt-50">
						<h4 class="item_title">Analytics</h4>
						<div class="la5lo1">	
							<div class="fcrse_1">
								<div class="fcrse_content">
									<h6 class="crsedt8145">My Subjects</h6>
									<h3 class="subcribe_title"><?php print $subjects; ?> subject(s)</h3>
									<div class="allvperf">
										<div class="crse-perf-left">My Lesson Watch Time</div>
										<div class="crse-perf-right">
											<?php print ceil((($my_watch_time/60)/60)); ?> hours
											<span class="analyics_pr"><i class="uil uil-clock"></i>approx.</span>
										</div>
									</div>
									<div class="allvperf">
										<div class="crse-perf-left">My Lessons Performance</div>
										<div class="crse-perf-right">
											<?php print $my_lessons_played.'/'.$my_lessons; ?>
											<span class="analyics_pr"><i class="uil uil-video"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php print intval($my_lessons)>0 ? ceil(($my_lessons_played/$my_lessons)*100) : '0';?>%</span>
										</div>
									</div>
									<div class="allvperf">
										<div class="crse-perf-left">My Quiz Attempted</div>
										<div class="crse-perf-right">
											<?php print $my_quiz_solved.'/'.$my_quiz; ?>
											<span class="analyics_pr"><i class="uil uil-meeting-board"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<?php print intval($my_quiz)>0 ? ceil(($my_quiz_solved/$my_quiz)*100) : '0';?>%</span>
										</div>
									</div>
									<div class="allvperf">
										<div class="crse-perf-left">My Paper Attempted</div>
										<div class="crse-perf-right">
											<?php print $my_paper_solved.'/'.$my_paper; ?>
											<span class="analyics_pr"><i class="uil uil-clipboard-notes"></i>&nbsp;&nbsp;&nbsp;
											<?php print intval($my_paper)>0 ? ceil(($my_paper_solved/$my_paper)*100) : '0';?>%</span>
										</div>
									</div>
								</div>
							</div>	
						</div>
					</div>
					<div class="fcrse_2 mb-30">
						<h1>Pending Quiz Tests</h1>
						<div class="row">
							<div class="table-responsive mt-10">
								<table class="table ucp-table">
									<thead class="thead-s">
										<tr>
											<th class="text-center" scope="col">Quiz</th>
											<th class="text-center" scope="col">Date</th>
											<th class="text-center" scope="col">Subject</th>
											<th class="text-center" scope="col">Options</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										
										$i=0;
										$days=30;
										$filter=array('class_id'=>$this->LOGIN_USER->class_id);
										$todayjd=$this->user_m->todayjd;
										$filter['jd >=']=$todayjd;
										$papers=$this->quiz_m->get_rows($filter,array('select'=>'name,date,jd,subject_id,class_id,section_id,start_time','orderby'=>'jd ASC, start_time ASC'));
										foreach($papers as $ppr){
											//if already attempted the quiz the skip
											if($this->quiz_attempt_m->get_rows(array('quiz_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)>0){continue;}
											//verify the section exam
											if($ppr['section_id']>0 && $ppr['section_id'] != $this->LOGIN_USER->section_id){continue;}
										    $i++;
										?>
										<tr>
										<td class="text-center"><?php print $ppr['name']; ?></td>
										<td class="text-center"><?php print get_time_from_minutes($ppr['start_time'],false,true); ?></td>
										<td class="text-center"><?php print $this->subject_m->get_by_primary($ppr['subject_id'])->name; ?></td>
										<td class="text-center">
											<?php if($ppr['jd']==$this->quiz_m->todayjd){?><a class="btn btn-danger" href="<?php print $this->LIB_CONT_ROOT.'quiz/attempt/'.$ppr['mid'];?>">Start Test</a>
											<?php }else{ ?>
												<?php $rem_days=$ppr['jd']-$this->user_m->todayjd; ?>
												<?php if($rem_days==1){ ?>
													<span class="text-info">Tomorrow</span>
												<?php }else{ ?>
													<span class="text-info">After <?php print $rem_days-1; ?> Day<?php print $rem_days>2? 's':''; ?></span>
												<?php }  ?>
											<?php } ?>
										</td>
										</tr>
										<?php
										}
										
										
										 ?>
			                        </tbody>
								</table>
							</div>
						</div>	
						<p class="color-white">Please visit <a href="<?php print $this->LIB_CONT_ROOT;?>quiz" class="color-white">MCQ's Test</a> menu to see all tests.</p>
					</div>
				</div>
			</div>
			<div class="row mt-30">
				<span class="float-right"><a href="https://mozzine.work/software/windows/math-type-6-full.zip">Click Here</a> to download Math Type 6.0</span>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<?php $this->load->view($LIB_VIEW_DIR.'includes/footer_inc'); ?>
	<!-- /footer -->
</div>
<!-- Body End -->