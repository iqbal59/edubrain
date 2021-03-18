<!-- Header Start -->
<header class="header clearfix">
	<button type="button" id="toggleMenu" class="toggle_menu">
	  <i class='uil uil-bars'></i>
	</button>
	<button id="collapse_menu" class="collapse_menu">
		<i class="uil uil-bars collapse_menu--icon "></i>
		<span class="collapse_menu--label"></span>
	</button>
	<div class="main_logo" id="logo">
		<a href="<?php print $this->LIB_CONT_ROOT;?>"><img src="<?php print $this->UPLOADS_ROOT.'images/logo/default.png';?>" width="72" alt=""></a>
		<a href="<?php print $this->LIB_CONT_ROOT;?>"><img class="logo-inverse" src="<?php print $this->UPLOADS_ROOT.'images/logo/default.png';?>" width="72" alt=""></a>
	</div>
	<div class="search120">
		<form action="<?php print $this->LIB_CONT_ROOT.'home/search';?>" method="post">
			<div class="ui search">
				<select class="ui dropdown prompt srch_explore" name="type">
					<option value="students">Search Students</option>
					<option value="staff">Search Teachers</option>
					<option value="classes">Search Classes</option>
					<option value="subjects">Search Subjects</option>
					<option value="lessons">Search Lessons</option>
					<option value="qbank">Search Question</option>
				</select>
			  <div class="ui left icon input swdh10">
				<input class="prompt srch10" type="text" name="search" placeholder="Search for students, teachers, lessons and more..">
				<i class='uil uil-search-alt icon icon1'></i>
			  </div>
			</div>
		</form>
	</div>
	<div class="header_right">
		<ul>
			<li class="ui dropdown">
				<a href="#" class="opts_account">
					<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image; ?>" alt="">
				</a>
				<div class="menu dropdown_account">
					<div class="channel_my">
						<div class="profile_link">
							<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image; ?>" alt="">
							<div class="pd_content">
								<div class="rhte85">
									<h6><?php print ucwords($this->LOGIN_USER->name);?></h6>
									<div class="mef78" title="Verify">
										<i class='uil uil-check-circle'></i>
									</div>
								</div>
								<span><?php print $this->LOGIN_USER->email;?></span><br>
								<span><?php print $this->LOGIN_USER->date;?></span>
							</div>							
						</div>
						<a href="<?php print $this->LIB_CONT_ROOT.'profile'; ?>" class="dp_link_12">Edit Profile</a>						
					</div>
					<div class="night_mode_switch__btn">
						<a href="#" id="night-mode" class="btn-night-mode">
							<i class="uil uil-moon"></i> Night mode
							<span class="btn-night-mode-switch">
								<span class="uk-switch-button"></span>
							</span>
						</a>
					</div>
					<a href="<?php print $this->LIB_CONT_ROOT;?>themes" class="item channel_item">Themes</a>
					<a href="<?php print $this->LIB_CONT_ROOT;?>settings/changelog" class="item channel_item">Change Log</a>
					<a href="<?php print $this->APP_ROOT;?>auth/logout/admin" class="item channel_item">Sign Out</a>
				</div>
			</li>
		</ul>
	</div>
</header>
<!-- Header End