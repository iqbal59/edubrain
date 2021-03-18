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
									<a href="<?php print $this->CONT_ROOT.'result';?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Student: <strong><?php print ucwords($student->name);?></strong></h2>
										<span>Paper: <strong><?php print ucwords($paper->name);?></strong></span> |
										<span>Class: <strong><?php print $class->name; ?> </strong></span> |
										<span>Subject: <strong><?php print $subject->name; ?></strong></span>
									</div>										
								</div>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->CONT_ROOT.'result';?>" class="color-white">
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
		<div class="bg-info color-white mt-30 mb-30"><center><h2>MCQ's</h2></center></div><br>
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
			<?php 
			$i=0;
			foreach($questions_mcq as $row){
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
		<div class="bg-info color-white mt-30 mb-30"><center><h2>Short Questions</h2></center></div><br>
		<div class="container">	
			<?php 
			foreach($questions_short as $row){
				$i++;
				$status=false;
				$std_ans='';
				$marks='';
				if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
				if(isset($answer_marks[$row['mid']] ) ){$marks=$answer_marks[$row['mid']];}
			 ?>
			 <div class="row mb-20 border font-size-1-1em">
			 	<div class="col-sm-12 border">
			 		<span><strong>Question <?php print $i; ?>: </strong><?php print real_html($row['question']); ?></span>
			 	</div>
			 	<div class="col-sm-10 border">
			 		<span><strong>Std.Answer : </strong>
			 			<span class="text-info"><?php print real_html($std_ans);?></span>
					</span>
			 	</div>
			 	<div class="col-sm-2 border">
			 		<span><strong>Obt Marks : </strong><?php print $marks.'/'.$row['marks']; ?></span>
			 	</div>

			 	<div class="col-sm-12 border">
			 		<span><strong>Explanation : </strong><?php print real_html($row['solution']); ?></span>
			 	</div>
				<div class="col-sm-12">
					<span><strong>Attachments : </strong>
					<?php 
					$docs=$this->paper_doc_m->get_rows(array('question_id'=>$row['mid'],'paper_id'=>$row['paper_id'],'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,file_name,date')); 
					if(count($docs)>0){ ?>
							<?php foreach($docs as $doc){ ?>
								<a href="<?php print $this->UPLOADS_ROOT.'files/exam/'.$doc['file_name']; ?>" target="_blank"><?php print $doc['file_name']; ?></a> | 
							<?php } ?>
					<?php } ?>
					</span>
				</div>
			 </div>
			 <hr>
			<?php } ?>
		</div>
		<div class="bg-info color-white mt-30 mb-30"><center><h2>Long Questions</h2></center></div><br>
		<div class="container">	
			<?php 
			foreach($questions_long as $row){
				$i++;
				$status=false;
				$std_ans='';
				$marks='0';
				if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
				if(isset($answer_marks[$row['mid']] ) ){$marks=$answer_marks[$row['mid']];}
			 ?>
			 <div class="row mb-20 border font-size-1-1em">
			 	<div class="col-sm-12 border">
			 		<span><strong>Question <?php print $i; ?>: </strong><?php print real_html($row['question']); ?></span>
			 	</div>
			 	<div class="col-sm-10 border">
			 		<span><strong>Std.Answer : </strong>
			 			<span class="text-info"><?php print real_html($std_ans);?></span>
					</span>
			 	</div>
			 	<div class="col-sm-2 border">
			 		<span><strong>Obt Marks : </strong><?php print $marks.'/'.$row['marks']; ?></span>
			 	</div>

			 	<div class="col-sm-12 border">
			 		<span><strong>Explanation : </strong><?php print real_html($row['solution']); ?></span>
			 	</div>
				<div class="col-sm-12">
					<span><strong>Attachments : </strong>
					<?php 
					$docs=$this->paper_doc_m->get_rows(array('question_id'=>$row['mid'],'paper_id'=>$row['paper_id'],'student_id'=>$this->LOGIN_USER->mid),array('select'=>'mid,file_name,date')); 
					if(count($docs)>0){ ?>
							<?php foreach($docs as $doc){ ?>
								<a href="<?php print $this->UPLOADS_ROOT.'files/exam/'.$doc['file_name']; ?>" target="_blank"><?php print $doc['file_name']; ?></a> | 
							<?php } ?>
					<?php } ?>
					</span>
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
