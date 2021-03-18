
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="st_title"><i class='uil uil-cog'></i>Themes &amp; Appearance </h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>

					<div class="row">
						<div class="col-4">
							<img src="<?php print $this->RES_ROOT.'images/themes/default.jpg';?>" alt=" " class="img img-rounded" width="100%">
							<center><a href="<?php print $this->CONT_ROOT.'save/theme';?>" class="save_btn " style="padding: 7px;"><b>Set As Default</b></a></center>
						</div>
						<div class="col-4">
							<img src="<?php print $this->RES_ROOT.'images/themes/green.jpg';?>" alt=" " class="img img-rounded" width="100%">
							<center><a href="<?php print $this->CONT_ROOT.'save/theme/green';?>" class="save_btn " style="padding: 7px;"><b>Set As Default</b></a></center>
						</div>
						<div class="col-4">
							<img src="<?php print $this->RES_ROOT.'images/themes/blue.jpg';?>" alt=" " class="img img-rounded" width="100%">
							<center><a href="<?php print $this->CONT_ROOT.'save/theme/blue';?>" class="save_btn " style="padding: 7px;"><b>Set As Default</b></a></center>
						</div>
						<div class="col-4">
							<img src="<?php print $this->RES_ROOT.'images/themes/orange.jpg';?>" alt=" " class="img img-rounded" width="100%">
							<center><a href="<?php print $this->CONT_ROOT.'save/theme/orange';?>" class="save_btn " style="padding: 7px;"><b>Set As Default</b></a></center>
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
