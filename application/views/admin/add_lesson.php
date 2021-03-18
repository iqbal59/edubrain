
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
			<form action="<?php print $this->CONT_ROOT.'save/lessons';?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="name" value="" required="" min="1" max="99" placeholder="Enter Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-5 col-md-5">
								<div class="mt-20 lbel25">	
									<label>Select Subject<span class="text-danger">*</span></label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="subject_id">
									<option value="">Select Subject</option>
									<?php foreach($subjects as $subject){ ?>
									<option value="<?php print $subject['mid']; ?>"><?php print $subject['name'].' (class : '.$classes[$subject['class_id']].') ';?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson No</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="lesson_no" value="" placeholder="Blank for auto numbering">															
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="mt-20 lbel25">	
									<label>Select Video Host</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="host">
									<option value="">Select Host</option>
									<?php foreach($hosts as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-5 col-md-5">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Video Link</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="video_link" value="" placeholder="Enter Video Link">															
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Duration (in minutes)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="duration" value="" placeholder="Enter Duration">															
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Lesson Date<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore datepicker-here" type="text" name="lesson_date" value="" required="" min="1" max="255" placeholder="dd-mm-yyyy" readonly="">															
									</div>
								</div>										
							</div>
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>About Lesson</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore" name="about" value="" placeholder="Write about lesson" rows="10" cols="800"></textarea>
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
	
	<!-- Footer -->
	<br><br><br><br><br><br>
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->
