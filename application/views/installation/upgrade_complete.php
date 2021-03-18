<?php 

$error = false;
?>

<!-- Page content -->
<div class="page-content">

<!-- Main content -->
<div class="content-wrapper">

	<!-- Content area -->
	<div class="content d-flex justify-content-center align-items-center">

		<!-- Login card -->
			<div class="card mb-0">
				<div class="card-body">
					<div class="text-center mb-3">
						<i class="icon-laptop icon-2x text-slate-800 border-slate-800 border-3 rounded-round p-3 mb-3 mt-1"></i>
						<h5 class="mb-0"><?php print ucwords($this->config->item('app_name'));?></h5>
						<span class="d-block text-muted">Version <?php print $this->config->item('app_version');?> developed by <a href="https://<?php print $this->config->item('app_author_site');?>" target="_blank"><?php print $this->config->item('app_author');?></a></span>				
						<span class="d-block text-muted"><?php print $this->config->item('app_description');?></span>						
					</div>

					<?php 
		            //include warning alerts
		            $this->load->view($this->LIB_VIEW_DIR.'includes/flash_inc');
		            ?>  


		            <div class="row">
						<div class="card card-body border-top-info">	
						<pre><?php print $this->_log; ?></pre>

						<p class="text-success">Upgrade process completed successfully.</p>
						<?php
						if ($error == true) {
						    echo '<div class="text-center alert alert-danger">Please fullfill the requirements to begin installation.</div>';
						}?>
						<hr />
						</div>
		            </div>		


					<?php if ($error == false) { ?>
					<br><br>
					<div class="form-group text-center">
						<a href="<?php print $this->APP_ROOT; ?>" class="btn btn-success font-weight-bold">Login Now <i class="icon-circle-right2 ml-2"></i></a>
					</div>
					<br><br><br>
					<?php } ?>
        

					<span class="form-text text-center text-muted">Trouble in upgrading? Please <a href="https://<?php print $this->config->item('app_author_site');?>" target="_blank">contact us</a> for technical support.</span>
				</div>
			</div>
		<!-- /login card -->

	</div>
	<!-- /content area -->
	<!-- Footer -->
	<?php 
        //include warning alerts
        $this->load->view($this->LIB_VIEW_DIR.'includes/footer_inc');
     ?> 
	<!-- /footer -->

</div>
<!-- /main content -->

</div>
<!-- /page content -->
