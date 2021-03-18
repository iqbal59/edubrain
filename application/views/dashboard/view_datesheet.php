
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Class Date Sheet</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<?php 							
				$i=0; 
				foreach($rows as $row){

					//skip other section students
					if($row['section_id']>0 && $row['section_id'] != $this->LOGIN_USER->section_id){continue;}
					?>
					<div class="col-lg-12">
						<br>
						<h3><?php print $row['title']; ?></h3>
						<hr>
						<img src="<?php print $this->UPLOADS_ROOT.'files/docs/'.$row['file'];?>" width="100%">
						<br>
					</div>
				<?php } ?>
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
