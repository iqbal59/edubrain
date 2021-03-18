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
						<a href="<?php print $this->LIB_CONT_ROOT.'index/subjects'?>" class="menu--link <?php print $menu=='subjects'? $only_active : ''; ?>" title="My Subjects">
							<i class='uil uil-book-open menu--icon'></i>
							<span class="menu--label">My Subjects</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/messages'?>" class="menu--link <?php print $menu=='messages'? $only_active : ''; ?>" title="Messages">
							<i class='uil uil-fast-mail menu--icon'></i>
							<span class="menu--label">Messages</span>
						</a>
					</li>
					<li class="menu--item">
						<a href="<?php print $this->LIB_CONT_ROOT.'index/lessons'?>" class="menu--link <?php print $menu=='lessons'? $only_active : ''; ?>" title="Lessons">
							<i class='uil uil-book-alt menu--icon'></i>
							<span class="menu--label">Lessons</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Left Sidebar End -->
