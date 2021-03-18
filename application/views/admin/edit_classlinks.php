
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Online Class Links</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Online Classes</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/classlinks' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/classlinks/'.$row->mid;?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Subject Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="subject" value="<?php print $row->subject;?>" required="" min="1" max="99" placeholder="Enter Subject Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Teacher Name</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="teacher_name" value="<?php print $row->teacher_name;?>" min="1" max="99" placeholder="Enter Teacher Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Class Time<span class="text-danger">*</span> e.g.(11:30 AM - 12:15 PM)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="class_time" value="<?php print $row->class_time;?>" required="" min="1" max="99" placeholder="Enter Class Time">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>ID / Password</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="id_password" value="<?php print $row->id_password;?>"  placeholder="Enter ID / Password">															
									</div>
								</div>										
							</div>
							<div class="col-lg-8 col-md-8">	
								<div class="ui search focus mt-20 lbel25">
									<label>Zoom Link<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="zoom_link" value="<?php print $row->zoom_link;?>" required="" min="1" max="99" placeholder="Enter Zoon Link">															
									</div>
									<span class="help-block">Visit <a href="https://us04web.zoom.us/profile" target="_blank">zoom.us</a> for Meeting URL e.g. https://us04web.zoom.us/j/3298687485?pwd=M3R3BWN1hBZz09 </span>
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
