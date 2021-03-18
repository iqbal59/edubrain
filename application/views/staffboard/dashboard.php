
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-xl-9 col-lg-8">
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="section3125">
						<h4 class="item_title">Online Lectures</h4>
						<div class="la5lo1">
							<div class="owl-carousel live_stream owl-theme">
								<?php foreach ($subjects as $row): ?>
								<div class="item">
									<div class="stream_1">
										<a href="<?php print $this->LIB_CONT_ROOT.'lessons/index/'.$row['subject_id'] ?>" class="stream_bg">
											<h4><?php print  $subjects_arr[$row['subject_id']];?></h4>
											<p><?php print  $class_arr[$row['class_id']];?></p>
										</a>
									</div>
								</div>									
								<?php endforeach ?>
							</div>
						</div>
					</div>
					<div class="section3125 mt-50">
						<h4 class="item_title">Group Discussion</h4>
						<div class="la5lo1">
							<div class="owl-carousel live_stream owl-theme">
								<?php foreach ($chatgroups as $row): 
									if(in_array($row['class_id'], $my_subjects)){
								?>
								<div class="item">
									<div class="stream_1">
										<a href="<?php print $this->LIB_CONT_ROOT.'chat/groupview/'.$row['mid'] ?>" class="stream_bg">
											<h4><?php print  $row['name'];?></h4>
											<p>Join Now</p>
										</a>
									</div>
								</div>									
								<?php 
									}
								endforeach ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-4">
					<div class="right_side">
						<div class="fcrse_2 mb-30">
							<div class="tutor_img">
								<a href="#"><img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image;?>" alt=""></a>												
							</div>
							<div class="tutor_content_dt">
								<div class="tutor150">
									<a href="#" class="tutor_name"><?php print $this->LOGIN_USER->name;?></a>
									<div class="mef78" title="Verify">
										<i class="uil uil-check-circle"></i>
									</div>
								</div>
								<div class="tutor_cate">Since: <?php print $this->LOGIN_USER->date;?></div>
							</div> 
						</div>
						<div class="get1452">
							<h4>Daily Motivation</h4>
							<p><?php print $this->SETTINGS[$this->system_setting_m->_WS_DAILY_QOUTE] ?></p>
						</div>
					</div>
				</div>
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



