
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<?php if(empty($subject_id)){
			//subject id is not present. show subjects list
		?>
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>My Subjects.</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<div class="row">
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">Serial N0</th>
									<th class="text-left">Subject Name</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i=0;
								foreach($rows as $row){
									$filter=array('subject_id'=>$row['mid']);
									if($this->subject_group_m->get_rows($filter,'',true)<1){
									$i++; ?>
										<tr>
											<td class="text-center"><?php print $i; ?></td>
											<td class="text-left">
												<a href="<?php print $this->CONT_ROOT.'index/'.$row['mid'];?>" title="View Lessons" class="gray-s text-info"><i class="uil uil-arrow-right"></i> <?php print ucwords($row['name']); ?></a>
											</td>
										</tr>
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
										$filter['group_id']=$this->LOGIN_USER->group_id;
										if($this->subject_group_m->get_rows($filter,'',true)>0){
										$i++; ?>
											<tr>
												<td class="text-center"><?php print $i; ?></td>
												<td class="text-left">
													<a href="<?php print $this->CONT_ROOT.'index/'.$row['mid'];?>" title="View Lessons" class="gray-s text-info"><i class="uil uil-arrow-right"></i> <?php print ucwords($row['name']); ?></a>
												</td>
											</tr>
										<?php 
										}
									}
								} ?>
                            </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php }else{
			///show subject lessons
		 ?>
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Online Lectures of <?php print $subject->name;?> subject.</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<div class="row">
				<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING]) && intval($this->SETTINGS[$this->system_setting_m->_WS_CHAPTER_WISE_LESSONING])>0 && empty($chapter) && is_array($chapters)&& count($chapters)>0){ ?>
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">Serial N0</th>
									<th class="text-center">Chapter Number</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i=0;
								foreach($chapters as $key=>$val){
									$i++;
									?>
									<tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="text-center">
											<a href="<?php print $this->CONT_ROOT.'index/'.$subject_id.'/'.$val;?>" title="View Lectures" class="gray-s text-info"><i class="uil uil-arrow-right"></i> Chapter <?php print $val; ?></a>
										</td>
									</tr>
									<?php
								 } ?>
                            </tbody>
						</table>
					</div>
				</div>
				<?php }else{ ?>
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col" width="10%">Lesson N0</th>
									<th class="cell-ta">Lesson Name</th>
									<th class="text-center" scope="col" width="10%">Options</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach($rows as $row){
									if($row['lesson_jd']==$this->user_m->todayjd){
										if(intval($this->SETTINGS[$this->system_setting_m->_WS_LECTURE_ACTIVE_TIME])<=day_minutes_passed() ){
											//lesson time started.
										?>
										<tr>
											<td class="text-center"><?php print $row['lesson_no']; ?></td>
											<td class="cell-ta"><?php print $row['name']; ?></td>
											<td class="text-center">
												<a href="<?php print $this->CONT_ROOT.'view/'.$row['mid'];?>" title="View Lecture" class="gray-s text-info"><i class="uil uil-message"></i> Play</a>
											</td>
										</tr>
										<?php
										}
									}else{
								 ?>
	                                <tr>
										<td class="text-center"><?php print $row['lesson_no']; ?></td>
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="text-center">
											<a href="<?php print $this->CONT_ROOT.'view/'.$row['mid'];?>" title="View Lecture" class="gray-s text-info"><i class="uil uil-message"></i> Play</a>
										</td>
									</tr>
								 <?php }
								 } ?>
                            </tbody>
						</table>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	</div>
	
	<!-- Footer -->
	<br><br><br><br><br><br>
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->
