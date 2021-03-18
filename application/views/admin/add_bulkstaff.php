
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-reader"></i>Staff - Import Excel File</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Staff</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/staff' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<?php echo form_open_multipart($this->CONT_ROOT.'save/bulkstaff');?> 
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-6">	
								<div class="mt-20 lbel25">	
									<label>Select Excel File<span class="text-danger">*</span></label>
								</div>											
								<input type="file" name="file">
								<br>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Upload File</button>										
							</div>
						</div>	
					</div>
				</div>
			<?php echo form_close(); ?>
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
