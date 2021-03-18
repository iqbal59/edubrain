
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>MCQ Test Date Sheet</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">Serial No</th>
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
							$papers=$this->quiz_m->get_rows($filter,array('select'=>'name,date,jd,subject_id,class_id,section_id,start_time,allowed_time','orderby'=>'jd ASC, start_time ASC'));
							foreach($papers as $ppr){
								$subject=$this->subject_m->get_by_primary($ppr['subject_id']);
								$filter=array('subject_id'=>$subject->mid);
								if($this->subject_group_m->get_rows($filter,'',true)<1){
									//verify the section exam
									if($ppr['section_id']>0 && $ppr['section_id'] != $this->LOGIN_USER->section_id){continue;}
									$i++; 
									?>									
									<tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="text-center"><?php print $ppr['name']; ?></td>
									<td class="text-center"><?php print $ppr['date'].' '.get_time_from_minutes($ppr['start_time'],false,true); ?></td>
									<td class="text-center"><?php print $subject->name; ?></td>
									<td class="text-center">
										<?php if($ppr['jd']==$this->quiz_m->todayjd){
											if(get_minutes_from_time()>($ppr['start_time']-$this->_TIME_MARGIN)){
													if(isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]) && intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME])>0 && get_minutes_from_time()>($ppr['start_time']+$ppr['allowed_time'])){?>
														<span class="text-danger">Time Over</span>
													<?php

													}elseif($this->quiz_attempt_m->get_rows(array('quiz_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)<1){ ?>
													<a class="btn btn-danger" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Start Test</a>
												<?php }elseif($this->quiz_attempt_m->get_rows(array('quiz_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid,'is_ended'=>0),'',true)>0){ ?>
													<a class="btn btn-success" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Resume Test</a>
												<?php }else{ ?>
													<span class="text-danger">Test Attempted</span>
												<?php }
											}else{
												?>
												<span class="text-success"><?php print human_time((intval($ppr['start_time']-get_minutes_from_time())*60));?> remaining</span>
												<?php
											}
											?>
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
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
									$filter['group_id']=$this->LOGIN_USER->group_id;
									if($this->subject_group_m->get_rows($filter,'',true)>0){
									//verify the section exam
									if($ppr['section_id']>0 && $ppr['section_id'] != $this->LOGIN_USER->section_id){continue;}
									$i++; 
									?>										
										<tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="text-center"><?php print $ppr['name']; ?></td>
										<td class="text-center"><?php print $ppr['date'].' '.get_time_from_minutes($ppr['start_time'],false,true); ?></td>
										<td class="text-center"><?php print $subject->name; ?></td>
										<td class="text-center">
											<?php if($ppr['jd']==$this->quiz_m->todayjd){
												if(get_minutes_from_time()>($ppr['start_time']-$this->_TIME_MARGIN)){
														if(isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME]) && intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_STRICT_START_TIME])>0 && get_minutes_from_time()>($ppr['start_time']+$ppr['allowed_time'])){?>
															<span class="text-danger">Time Over</span>
														<?php

														}elseif($this->quiz_attempt_m->get_rows(array('quiz_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)<1){ ?>
														<a class="btn btn-danger" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Start Test</a>
													<?php }elseif($this->quiz_attempt_m->get_rows(array('quiz_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid,'is_ended'=>0),'',true)>0){ ?>
														<a class="btn btn-success" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Resume Test</a>
													<?php }else{ ?>
														<span class="text-danger">Test Attempted</span>
													<?php }
												}else{
													?>
													<span class="text-success"><?php print human_time((intval($ppr['start_time']-get_minutes_from_time())*60));?> remaining</span>
													<?php
												}
												?>
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
								}
							}?>
                        </tbody>
					</table>
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
