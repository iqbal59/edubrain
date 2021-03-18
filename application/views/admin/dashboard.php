
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">			
				<div class="row">
					<div class="col-lg-12">	
						<h2 class="st_title"><i class="uil uil-apps"></i> Administrator Dashboard</h2>
						<br>						
						<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					</div>

					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Monthly Visits</h5>
								<h2><?php print $total_visits_month; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Today Visits</h5>
								<h2><?php print $total_visits_today; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Total Students</h5>
								<h2><?php print $total_students; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Total Teachers</h5>
								<h2><?php print $total_staff; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Total Subjects</h5>
								<h2><?php print $total_subjects; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Total Lessons</h5>
								<h2><?php print $total_lessons; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Total Questions</h5>
								<h2><?php print $total_qbank; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6">
						<div class="card_dash">
							<div class="card_dash_left">
								<h5>Today Questions</h5>
								<h2><?php print $today_qbank; ?></h2>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="card_dash1">
							<div class="card_dash_left1">
								<i class="uil uil-plus-circle"></i>
								<h1>Jump Into Lessons Creation</h1>
							</div>
							<div class="card_dash_right1">
								<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/lessons' ?>';">Add New Lesson</button>
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



