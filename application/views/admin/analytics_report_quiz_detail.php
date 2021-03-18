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
									<a href="<?php print $this->CONT_ROOT.'report/quiz/'.$quiz->mid;?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Student: <?php print ucwords($student->name);?></h2>
										<span>Quiz: <?php print ucwords($quiz->name);?></span> |
										<span>Class: <?php print $class->name; ?> </span> |
										<span>Subject: <?php print $subject->name; ?></span>
									</div>										
								</div>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->CONT_ROOT.'report/quiz/'.$quiz->mid;?>" class="color-white">
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
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="cell-ta">Question</th>
								<th class="text-center">CorrectAnswer</th>
								<th class="text-center">Student Answer</th>
								<th class="text-center">Status</th>
								<th class="text-center">Obt. Marks</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=0;
							foreach($questions as $row){
								$i++;
								$status=false;
								$std_ans='';
								if(isset($answers[$row['mid']] ) && $row['answer'] == $answers[$row['mid']]){$status=true;}
								if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
							 ?>
                                <tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="cell-ta"><?php print real_html($row['question']); ?></td>
									<td class="text-center"><?php 
										switch ($row['answer']) {
											case '1': print real_html($row['option1']);
											break;
											case '2': print real_html($row['option2']);
											break;
											case '3': print real_html($row['option3']);
											break;
											case '4': print real_html($row['option4']);
											break;
										}
									 ?></td>
									<td class="text-center"><?php 
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
									 ?></td>
									<td class="text-center">
										<?php if($status){
											?> <span class="text-success">Correct</span><?php
										}else{
											?> <span class="text-danger">Wrong</span><?php											
										} ?>
									</td>
									<td class="text-center">
										<?php if($status){
											print $row['marks'];
										}else{
											print '0';											
										} ?>
									</td>
								</tr>
							 <?php } ?>
                        </tbody>
					</table>
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
