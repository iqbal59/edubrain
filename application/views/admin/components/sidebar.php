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
						<a href="<?php print $this->LIB_CONT_ROOT.''?>" class="menu--link <?php print $menu=='dashboard'? $only_active : ''; ?>" title="Dashboard">
							<i class="uil uil-apps menu--icon"></i>
							<span class="menu--label">Dashboard</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/students'?>" class="menu--link <?php print $menu=='students'? $only_active : ''; ?>" title="Students">
							<i class='uil uil-book-reader menu--icon'></i>
							<span class="menu--label">Students</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/staff'?>" class="menu--link <?php print $menu=='staff'? $only_active : ''; ?>" title="Teachers">
							<i class='uil uil-users-alt menu--icon'></i>
							<span class="menu--label">Teachers</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/chatgroups'?>" class="menu--link <?php print $menu=='chatgroups'? $only_active : ''; ?>" title="Chat Groups">
							<i class='uil uil-comment-lines menu--icon'></i>
							<span class="menu--label">Group Discussion</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/messages'?>" class="menu--link <?php print $menu=='messages'? $only_active : ''; ?>" title="Messages">
							<i class='uil uil-fast-mail menu--icon'></i>
							<span class="menu--label">Messages</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/classes'?>" class="menu--link <?php print $menu=='classes'? $only_active : ''; ?>" title="Classes">
							<i class='uil uil-layer-group menu--icon'></i>
							<span class="menu--label">Classes</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/subjects'?>" class="menu--link <?php print $menu=='subjects'? $only_active : ''; ?>" title="Subjects">
							<i class='uil uil-book-open menu--icon'></i>
							<span class="menu--label">Subjects</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/lessons'?>" class="menu--link <?php print $menu=='lessons'? $only_active : ''; ?>" title="Lessons">
							<i class='uil uil-book-alt menu--icon'></i>
							<span class="menu--label">Lesson Planning</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/quiz'?>" class="menu--link <?php print $menu=='quiz'? $only_active : ''; ?>" title="Quiz Tests">
							<i class='uil uil-clipboard menu--icon'></i>
							<span class="menu--label">Quiz Tests</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/paper'?>" class="menu--link <?php print $menu=='paper'? $only_active : ''; ?>" title="Exam Papers">
							<i class='uil uil-clipboard-alt menu--icon'></i>
							<span class="menu--label">Exam</span>
						</a>
					</li>
					<?php if(isset($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST]) && intval($this->SETTINGS[$this->system_setting_m->_WS_EXAM_PRACTICE_TEST])>0 ){ ?>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/test'?>" class="menu--link <?php print $menu=='test'? $only_active : ''; ?>" title="Online Practice Test">
							<i class="uil uil-tachometer-fast menu--icon"></i>
							<span class="menu--label">Practice Tests</span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div>
			<div class="left_section">
				<h6 class="left_title">CONFIGURATION</h6>
				<ul>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/classlinks'?>" class="menu--link <?php print $menu=='classlinks'? $only_active : ''; ?>" title="Sections">
							<i class='uil uil-laptop-cloud menu--icon'></i>
							<span class="menu--label">Online Classes</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/sections'?>" class="menu--link <?php print $menu=='sections'? $only_active : ''; ?>" title="Sections">
							<i class='uil uil-focus-target menu--icon'></i>
							<span class="menu--label">Class Sections</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/groups'?>" class="menu--link <?php print $menu=='groups'? $only_active : ''; ?>" title="Groups">
							<i class='uil uil-folder-check menu--icon'></i>
							<span class="menu--label">Student Groups</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/qbank'?>" class="menu--link <?php print $menu=='qbank'? $only_active : ''; ?>" title="Question Bank">
							<i class='uil uil-database menu--icon'></i>
							<span class="menu--label">Question Bank</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'settings'?>" class="menu--link <?php print $menu=='system'? $only_active : ''; ?>" title="Settings">
							<i class='uil uil-laptop menu--icon'></i>
							<span class="menu--label">Settings</span>
						</a>
					</li>
					
				</ul>
			</div>
			
		</div>
	</nav>
	<!-- Left Sidebar End -->
