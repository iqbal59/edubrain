<?php $active='class="active"'; $only_active='active'; $item_active=' nav-item-expanded nav-item-open ';?>
<!-- //////////////////////////////////////////////////////////////////////////// --> 

	<!-- Left Sidebar Start -->
	<nav class="vertical_nav">
		<div class="left_section menu_left" id="js-menu" >
			<div class="left_section">
				<h6 class="left_title"><?php print ucwords($this->config->item('app_name'));?>(<?php print $this->config->item('app_version');?>)
					<span class="help-block"><small><b>Standard Time:</b> <?php print date('d M Y h:i A'); ?></small></span>
				</h6>
			</div>
			<div class="left_section">
				<ul>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'home'?>" class="menu--link <?php print $menu=='home'? $only_active : ''; ?>" title="Home">
							<i class="uil uil-home menu--icon"></i>
							<span class="menu--label">Home</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'profile'?>" class="menu--link <?php print $menu=='profile'? $only_active : ''; ?>" title="My Profile">
							<i class="uil uil-user menu--icon"></i>
							<span class="menu--label">My Profile</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'dashboard'?>" class="menu--link <?php print $menu=='dashboard'? $only_active : ''; ?>" title="Dashboard">
							<i class="uil uil-apps menu--icon"></i>
							<span class="menu--label">Dashboard</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'classlinks'?>" class="menu--link <?php print $menu=='classlinks'? $only_active : ''; ?>" title="Online Classes">
							<i class="uil uil-laptop-cloud menu--icon"></i>
							<span class="menu--label">Online Classes</span>
						</a>
					</li>
					<!-- <li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'notes'?>" class="menu--link <?php print $menu=='notes'? $only_active : ''; ?>" title="Download Notes">
							<i class="uil uil-file-download-alt menu--icon"></i>
							<span class="menu--label">Subject Notes</span>
						</a>
					</li> -->
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'subjects'?>" class="menu--link <?php print $menu=='subjects'? $only_active : ''; ?>" title="My Subjects">
							<i class="uil uil-book-open menu--icon"></i>
							<span class="menu--label">My Subjects</span>
						</a>
					</li>
					<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE]) && intval($this->SETTINGS[$this->system_setting_m->_WS_LESSON_SCHEDULE])>0){ ?>
						<li class="menu--item">
							<a href="<?php print $this->LIB_CONT_ROOT.'timetable'?>" class="menu--link <?php print $menu=='timetable'? $only_active : ''; ?>" title="Online Lecture Time Table">
								<i class="uil uil-calendar-alt menu--icon"></i>
								<span class="menu--label">Lesson Schedule</span>
							</a>
						</li>
					<?php }else{ ?>
						<li class="menu--item">
							<a href="<?php print $this->LIB_CONT_ROOT.'lessons'?>" class="menu--link <?php print $menu=='lessons'? $only_active : ''; ?>" title="Video Lessons">
								<i class="uil uil-video menu--icon"></i>
								<span class="menu--label">Video Lessons</span>
							</a>
						</li>						
					<?php } ?>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'quiz'?>" class="menu--link <?php print $menu=='quiz'? $only_active : ''; ?>" title="Online Quiz Test">
							<i class="uil uil-meeting-board menu--icon"></i>
							<span class="menu--label">MCQ's Test</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'quiz/result'?>" class="menu--link <?php print $menu=='quiz_result'? $only_active : ''; ?>" title="Quiz Test Result">
							<i class="uil uil-medal menu--icon"></i>
							<span class="menu--label">Test Results</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'paper'?>" class="menu--link <?php print $menu=='paper'? $only_active : ''; ?>" title="Online Exam">
							<i class="uil uil-clipboard-notes menu--icon"></i>
							<span class="menu--label">Exam</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'paper/result'?>" class="menu--link <?php print $menu=='paper_result'? $only_active : ''; ?>" title="Exam Result">
							<i class="uil uil-book-reader menu--icon"></i>
							<span class="menu--label">Exam Result</span>
						</a>
					</li>
					<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]) && intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST])>0 ){ ?>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'test'?>" class="menu--link <?php print $menu=='test'? $only_active : ''; ?>" title="Online Practice Test">
							<i class="uil uil-tachometer-fast menu--icon"></i>
							<span class="menu--label">Practice Test</span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Left Sidebar End -->
