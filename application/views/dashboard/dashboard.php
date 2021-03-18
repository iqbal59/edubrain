
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-sm-12">
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="section3125">
						<h4 class="item_title">Video Lectures</h4>
						<div class="la5lo1">
							<div class="owl-carousel live_stream owl-theme">
								<?php foreach ($subjects as $row){
									$filter=array('subject_id'=>$row['mid']);
									if($this->subject_group_m->get_rows($filter,'',true)<1){ ?>
										<div class="item">
											<div class="stream_1">
												<a href="<?php print $this->LIB_CONT_ROOT.'lessons/index/'.$row['mid'] ?>" class="stream_bg">
													<h4><?php print  $row['name'];?></h4>
													<p>View Lectures</p>
												</a>
											</div>
										</div>	
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
										$filter['group_id']=$this->LOGIN_USER->group_id;
										if($this->subject_group_m->get_rows($filter,'',true)>0){ ?>
											<div class="item">
												<div class="stream_1">
													<a href="<?php print $this->LIB_CONT_ROOT.'lessons/index/'.$row['mid'] ?>" class="stream_bg">
														<h4><?php print  $row['name'];?></h4>
														<p>View Lectures</p>
													</a>
												</div>
											</div>
										<?php 
										}
									}
								} ?>
							</div>
						</div>
					</div>
					<div class="section3125 mt-50">
						<h4 class="item_title">Group Discussion</h4>
						<div class="la5lo1">
							<div class="owl-carousel live_stream owl-theme">
								<?php foreach ($chatgroups as $row): ?>
								<div class="item">
									<div class="stream_1">
										<a href="<?php print $this->LIB_CONT_ROOT.'chat/groupview/'.$row['mid'] ?>" class="stream_bg">
											<h4><?php print  $row['name'];?></h4>
											<p>Join Now</p>
										</a>
									</div>
								</div>									
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<div class="section3125 mt-50">
						<h4 class="item_title">My Teachers</h4>
						<div class="la5lo1">
							<div class="owl-carousel live_stream owl-theme">
								<?php foreach ($teachers as $row){								
									$filter=array('subject_id'=>$row['subject_id']);
									if($this->subject_group_m->get_rows($filter,'',true)<1){ ?>
										<div class="item">
											<div class="stream_1">
												<a href="<?php print $this->LIB_CONT_ROOT.'chat/messages/'.$row['staff_id'] ?>" class="stream_bg">
													<h4><?php print  $staff[$row['staff_id']];?></h4>
													<span><?php print  $subjects_arr[$row['subject_id']];?></span><br>
													<p>Ask Question
														<?php if($this->chat_m->get_rows(array('staff_id'=>$row['staff_id'],'student_id'=>$this->LOGIN_USER->mid,'stf_update'=>1),'',true)>0){?><span></span><?php } ?>
													</p>
												</a>
											</div>
										</div>	
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
										$filter['group_id']=$this->LOGIN_USER->group_id;
										if($this->subject_group_m->get_rows($filter,'',true)>0){ ?>
											<div class="item">
												<div class="stream_1">
													<a href="<?php print $this->LIB_CONT_ROOT.'chat/messages/'.$row['staff_id'] ?>" class="stream_bg">
														<h4><?php print  $staff[$row['staff_id']];?></h4>
														<span><?php print  $subjects_arr[$row['subject_id']];?></span><br>
														<p>Ask Question
															<?php if($this->chat_m->get_rows(array('staff_id'=>$row['staff_id'],'student_id'=>$this->LOGIN_USER->mid,'stf_update'=>1),'',true)>0){?><span></span><?php } ?>
														</p>
													</a>
												</div>
											</div>
										<?php 
										}
									}
								} ?>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row mt-30">
				<span class="float-right"><a href="https://mozzine.work/software/windows/math-type-6-full.zip">Click Here</a> to download Math Type 6.0</span>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->



