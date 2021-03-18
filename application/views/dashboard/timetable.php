
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Online Lectures Time Table for this month.</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>

			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">Date</th>
								<?php foreach($subjects as $sub){
									$filter=array('subject_id'=>$sub['mid']);
									if($this->subject_group_m->get_rows($filter,'',true)<1){?>
										<th class="cell-ta"><?php print ucwords($sub['name']); ?></th>
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
										$filter['group_id']=$this->LOGIN_USER->group_id;
										if($this->subject_group_m->get_rows($filter,'',true)>0){?>
											<th class="cell-ta"><?php print ucwords($sub['name']); ?></th>
										<?php 
										}
									}
								} ?>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=0;
							$days=7;
							$todayjd=$this->user_m->todayjd;
							$filter=array('class_id'=>$this->LOGIN_USER->class_id);
							for($d=0;$d<$days;$d++){
							 ?>
                                <tr>
									<td class="text-center"><?php print get_date_from_jd($todayjd+$d); ?></td>
									<?php foreach($subjects as $sub){
										$filter['subject_id']=$sub['mid'];
										$filter['lesson_jd']=$todayjd+$d;
										$sub_filter=array('subject_id'=>$sub['mid']);
										if($this->subject_group_m->get_rows($sub_filter,'',true)<1){?>
											<td class="cell-ta">
												<?php if($this->lesson_m->get_rows($filter,'',true)>0){
													$lesson=$this->lesson_m->get_by($filter);
													if($lesson->lesson_jd==$this->user_m->todayjd && intval($this->SETTINGS[$this->system_setting_m->_WS_LECTURE_ACTIVE_TIME])<=day_minutes_passed() ){
														?>
														<a href="<?php print $this->LIB_CONT_ROOT.'lessons/view/'.$lesson->mid;?>" title="View Lecture" class="text-info">Watch Lecture</a>
														<?php
													}else{
														?>
														<span class="text-danger" title="<?php print $lesson->name ?>">Lesson <?php print $lesson->lesson_no; ?></span>
														<?php
													}

												} ?>
											</td>
										<?php }else if($this->LOGIN_USER->group_id > 0 ){
											$sub_filter['group_id']=$this->LOGIN_USER->group_id;
											if($this->subject_group_m->get_rows($sub_filter,'',true)>0){?>
												<td class="cell-ta">
													<?php if($this->lesson_m->get_rows($filter,'',true)>0){
														$lesson=$this->lesson_m->get_by($filter);
														if($lesson->lesson_jd==$this->user_m->todayjd && intval($this->SETTINGS[$this->system_setting_m->_WS_LECTURE_ACTIVE_TIME])<=day_minutes_passed() ){
															?>
															<a href="<?php print $this->LIB_CONT_ROOT.'lessons/view/'.$lesson->mid;?>" title="View Lecture" class="text-info">Watch Lecture</a>
															<?php
														}else{
															?>
															<span class="text-danger" title="<?php print $lesson->name ?>">Lesson <?php print $lesson->lesson_no; ?></span>
															<?php
														}

													} ?>
												</td>
											<?php 
											}
										}
									} ?>
									
								</tr>
							 <?php } ?>
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
