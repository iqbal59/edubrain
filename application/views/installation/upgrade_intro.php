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
		<?php echo form_open_multipart($this->CONT_ROOT.'start');?> 
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
		            	<!-- Circle empty -->
						<div class="card card-body border-top-warning">
							<div class="list-feed">
								<ul>
									<ol>Welcome to <?php print ucwords($this->config->item('app_name'));?> upgrade module.</ol>
									<ol><span class="text-danger">*</span>Please <a href="">make a database backup</a> before proceeding to next step.</ol>
									<ol><span class="text-danger">*</span>Go to <a href="<?php print $this->LIB_CONT_ROOT.'admin'; ?>">Admin Dashboard</a> after upgrade process.</ol>
								</ul>
							</div>
						</div>
						<!-- /circle empty -->

		            </div>

		            <div class="row">
						<div class="card card-body border-top-info">	

							<?php
							if ($error == true) {
							    echo '<div class="text-center alert alert-danger">Please fulfill the requirements to begin installation.</div>';
							}?>
							<table class="table table-hover">
							    <tbody>
							        <tr>
							            <td>Current Version </td>
							            <td><span class='badge badge-flat border-success text-success'><?php print $this->config->item('app_version');?></span></td>
							        </tr>
							    </tbody>
							</table>
							<hr/>
							<p class="text-info">Select software new version file</p>	<input type="file" name="file">										

						</div>
		            </div>		


					<?php if ($error == false){ ?>
					<br><br>
					<div class="form-group text-center">
						<button type="submit" class="btn btn-success font-weight-bold">
							Proceed to upgrade <i class="icon-circle-right2 ml-2"></i></button>
					</div>
					<br><br><br>
					<?php } ?>
        

					<span class="form-text text-center text-muted">Trouble in upgrading? Please <a href="https://<?php print $this->config->item('app_author_site');?>" target="_blank">contact us</a> for technical support.</span>
				</div>
			</div>
		<?php echo form_close(); ?>
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
