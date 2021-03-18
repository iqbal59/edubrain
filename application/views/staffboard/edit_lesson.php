
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Lessons</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Lessons</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/lessons' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/lessons/'.$row->mid;?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="name" value="<?php print $row->name;?>" required="" min="1" max="99" placeholder="Enter Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lessons No<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="lesson_no" value="<?php print $row->lesson_no;?>" required="" min="1" max="99" placeholder="Enter Lesson No">															
									</div>
								</div>										
							</div>
							<div class="col-lg-5 col-md-5">
								<div class="mt-20 lbel25">	
									<label>Select Subject<span class="text-danger">*</span></label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="subject_id">
									<option value="">Select Subject</option>
									<?php foreach($subjects as $subject){ 										
										if(in_array($subject['mid'], $my_subjects)){
										?>
									<option value="<?php print $subject['mid']; ?>" <?php print $subject['mid']==$row->subject_id ? 'selected': ''; ?> ><?php print $subject['name'].' (class : '.$classes[$subject['class_id']].') ';?></option>
									<?php } 
									} ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="mt-20 lbel25">	
									<label>Select Video Host</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="host">
									<option value="">Select Host</option>
									<?php foreach($hosts as $id=>$name){ ?>
									<option value="<?php print $id; ?>" <?php print $id==$row->host ? 'selected': ''; ?> ><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-5 col-md-5">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Video Link</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="video_link" value="<?php print $row->video_link;?>" placeholder="Enter Video Link">															
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Duration (in minutes)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="duration" value="<?php print $row->duration;?>" placeholder="Enter Duration">															
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Date<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore datepicker-here" type="text" name="lesson_date" value="<?php print $row->lesson_date;?>" required="" min="1" max="255" placeholder="dd-mm-yyyy" readonly="">															
									</div>
								</div>										
							</div>
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>About Lesson</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore" name="about" value="" placeholder="Write about lesson" rows="10" cols="800"><?php print $row->about;?></textarea>
									</div>
								</div>										
							</div>


						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Save Data</button>										
							</div>
						</div>	
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<br><hr><br>
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<h1>Video Preview</h1>
					<div class="section3125">
						<div class="live1452">
							<?php switch (strtolower($row->host)) {
								case 'youtube':{ 
									if($iframe){
									?>
									<iframe src="https://www.youtube.com/embed/<?php print getVideoIdFromUrl($row->video_link,'youtube');?>?rel=0&autoplay=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
									<?php }else{ ?>
										<!-- unpkg : use the latest version of Video.js -->
										<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
										<script src="https://unpkg.com/video.js/dist/video.min.js"></script>
										<span>
											<video
											    id="my-player"
											    class="video-js"
											    controls
											    preload="auto"
											    height="420"
											    poster="<?php print $video_image; ?>"
											    data-setup='{}' style="width: 100%;">
											  <source src="<?php print $video_link;?>" type="video/mp4"></source>
											  <p class="vjs-no-js">
											    To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video
											  </p>
											</video>
										</span>
									<?php } ?>
									
								<?php }
								break;
							} ?>
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
