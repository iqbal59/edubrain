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
	<div class="header_right">
		<ul>
			
			<li class="ui dropdown">
				<a href="#" class="opts_account">
					<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image; ?> " alt="">
				</a>
				<div class="menu dropdown_account">
					<div class="channel_my">
						<div class="profile_link">
							<img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image; ?>" alt="">
							<div class="pd_content">
								<div class="rhte85">
									<h6><?php print ucwords($this->LOGIN_USER->name);?></h6>
								</div>
								<span><?php print $this->LOGIN_USER->staff_id;?></span>
							</div>							
						</div>
						<a href="<?php print $this->LIB_CONT_ROOT.'profile/edit';?>" class="dp_link_12">Edit Profile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>						
					</div>
					<div class="night_mode_switch__btn">
						<a href="#" id="night-mode" class="btn-night-mode">
							<i class="uil uil-moon"></i> Night mode
							<span class="btn-night-mode-switch">
								<span class="uk-switch-button"></span>
							</span>
						</a>
					</div>
					<a href="<?php print $this->APP_ROOT;?>auth/logout/staff" class="item channel_item">Sign Out</a>
				</div>
			</li>
		</ul>
	</div>
</header>
<!-- Header End -->