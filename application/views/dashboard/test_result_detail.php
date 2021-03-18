<!-- Body Start -->
<div class="wrapper _bg4586">
	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">
								<span class="_216b22">
									<a href="<?php print $this->CONT_ROOT.'';?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Student: <strong><?php print ucwords($student->name);?></strong></h2>
										<span>Test: <strong><?php print ucwords($test->name);?></strong></span> |
										<span>Class: <strong><?php print $class->name; ?> </strong></span> |
										<span>Subject: <strong><?php print $subject->name; ?></strong></span>
									</div>										
								</div>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->CONT_ROOT.'';?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a> 
								</span>								
							</div>													
						</div>		
					</div>							
				</div>															
			</div>
		</div>
	</div>
	<div class="_215b15">
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>	
			<?php 
			$i=0;
			foreach($questions as $row){
				$i++;
				$status=false;
				$std_ans='';
				if(isset($answers[$row['mid']] ) && $row['answer'] == $answers[$row['mid']]){$status=true;}
				if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
			 ?>
			 <div class="row mb-20 border font-size-1-1em">
			 	<div class="col-sm-12 border">
			 		<span><strong>Question <?php print $i; ?>: </strong><?php print real_html($row['question']); ?></span>
			 	</div>
			 	<div class="col-sm-4 border">
			 		<span><strong>Std.Answer : </strong>
			 			<span class="text-info">
			 			<?php 
						switch ($std_ans) {
							case '1': print real_html($row['option1']);
							break;
							case '2': print real_html($row['option2']);
							break;
							case '3': print real_html($row['option3']);
							break;
							case '4': print real_html($row['option4']);
							break;
							default: print 'Not Answered';
							break;
						}
					 ?></span>
					</span>
			 	</div>
			 	<div class="col-sm-4 border">
			 		<span><strong>Correct : </strong><span class="text-success"><?php $opt='option'.$row['answer'];print isset($row[$opt]) ? real_html($row[$opt]):''; ?></span></span>
			 	</div>
			 	<div class="col-sm-2 border">
			 		<span><strong>Status : </strong>
						<?php if($status){
							?> <span class="text-success">Correct</span><?php
						}else{
							?> <span class="text-danger">Wrong</span><?php											
						} ?>
					</span>
			 	</div>
			 	<div class="col-sm-2 border">
			 		<span><strong>Obt Marks : </strong><?php if($status){print $row['marks'];}else{print '0';	} ?></span>
			 	</div>

			 	<div class="col-sm-12 border">
			 		<span><strong>Explanation : </strong><?php print real_html($row['solution']); ?></span>
			 	</div>
			 </div>
			 <hr>
			<?php } ?>
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
