
	<!-- Signup Start -->
	<div class="sign_in_up_bg">
		<div class="container">
			<div class="row justify-content-lg-center justify-content-md-center justify-content-sm-center">
				<div class="col-lg-12 col-md-12 col-sm-12"><div class="main_logo2" id="logo"><br></div></div>
			
				<div class="col-lg-6 col-md-8 col-sm-10">
					<div class="sign_form">
					    <center><img src="<?php print $this->UPLOADS_ROOT;?>images/logo/default.png" alt="" class="m-15"></center>
						<p class="form_title color-white font-bold font-size-18px p-5">TEACHER PORTAL</p>
						<?php 
			            //include warning alerts
			            $this->load->view($this->LIB_VIEW_DIR.'includes/flash_inc');
			            ?>  
						<form action="<?php print $this->APP_ROOT.'auth/signin_staff';?>" method="post">
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="text" name="user_id" value="" id="id_email" required="" maxlength="64" placeholder="Enter Teacher ID">															
									<i class="uil uil-envelope icon icon2"></i>
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="password" name="password" value="" id="id_password" required="" maxlength="64" placeholder="Password">
									<i class="uil uil-key-skeleton-alt icon icon2"></i>
								</div>
							</div>
							<button class="login-btn" type="submit"><i class="uil uil-lock icon icon2 color-black"></i>SIGN IN</button>
						</form>
						<br><p class="ssgntrm145">I am a student. <a href="<?php print $this->CONT_ROOT.'login' ?>">Click Here</a> for student login.</p>
					</div>
					<div class="sign_footer"><img src="<?php print $this->RES_ROOT;?>images/logo_small.png" alt="">© 2020 <strong><?php print ucwords($this->config->item('app_author'));?></strong>. All Rights Reserved.</div>
				</div>				
			</div>				
		</div>				
	</div>
	<!-- Signup End -->	
