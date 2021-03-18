
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">
					<h2 class="st_title"><i class='uil uil-history'></i>Software Change Log </h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>

					<div class="row">
						<div class="col-12">
							<table class="table table-hover">
							    <tbody>
							        <tr>
							            <td>Current Version </td>
							            <td><span class='text-success'><?php print $this->config->item('app_version');?></span> <small>(Installed &amp; Running...)</small></td>
							        </tr>
							        <?php 
							        if(file_exists($this->_home_path.'assets'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'version_info.php')){
								        include $this->_home_path.'assets'.DIRECTORY_SEPARATOR.'downloads'.DIRECTORY_SEPARATOR.'version_info.php';
					                }else{
					                	$error=true;
					                	print '<tr><td colspan="2">An error occurred fetching the version information...</td></tr>';
					                }
							        ?>
							    </tbody>
							</table>
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
