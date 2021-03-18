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
									<a href="<?php print $this->CONT_ROOT.'report/paper/'.$paper->mid;?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Student: <?php print ucwords($student->name);?></h2>
										<span>Quiz: <?php print ucwords($paper->name);?></span> |
										<span>Class: <?php print $class->name; ?> </span> |
										<span>Subject: <?php print $subject->name; ?></span>
									</div>										
								</div>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->CONT_ROOT.'report/paper/'.$paper->mid;?>" class="color-white">
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
				<h3>MCQ Questions</h3>
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
							foreach($questions_mcq as $row){
								$i++;
								$status=false;
								$std_ans='';
								$ans_id=0;
								if(isset($answers[$row['mid']] ) && $row['answer'] == $answers[$row['mid']]){$status=true;}
								if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
								if(isset($answer_ids[$row['mid']] ) ){$ans_id=$answer_ids[$row['mid']];}
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
											if($ans_id>0){$this->paper_answer_m->save(array('marks'=>$row['marks']),$ans_id);}
											//add marks to student answer
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
			<hr>
			<div class="row">
				<center><h3>Short Questions</h3></center>
					<div class="certi_form">
						<div class="all_ques_lest">
							<?php 
							$i=0;
							foreach($questions_short as $row){
								$i++;
								$status=false;
								$std_ans='';
								$marks='';
								if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
								if(isset($answer_marks[$row['mid']] ) ){$marks=$answer_marks[$row['mid']];}
								 ?>
									<form action="<?php print $module_url.'&qid='.$row['mid'];?>" method="post">
										<input type="hidden" name="qid" value="<?php print $row['mid'];?>">
										<div class="ques_item border-green-1">
											<div class="ques_title">
												<span>Question :-</span> <?php print real_html($row['question']);?>? (<?php print $row['marks'];?> Marks)
											</div>
											<div class="ui search focus mt-15">																
												<input class="prompts" type="text" name="marks" value="<?php print $marks; ?>" required="" placeholder="Enter obtained marks">
												<span><button class="submit_btn" type="submit">Save Marks</button></span>
												<?php if ($marks==''): ?><span class="text-danger">Not Answered by student</span><?php endif ?>
												<div class="row">													
													<div class="col-lg-6">
														<p class="text-info">Student Answer</p>
														<div class="ui form swdh30">
															<div class="field">
																<textarea rows="5" placeholder="Student answer here..." class="editor3"><?php print real_html($std_ans); ?></textarea>
															</div>
														</div>
													</div>
													<div class="col-lg-6">													
														<p class="text-success">Correct Answer</p>
														<div class="ui form swdh30">
															<div class="field">
																<textarea rows="5" placeholder="Correct Answer..." class="editor3"><?php print real_html($row['solution']); ?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
							 <?php } ?>
						</div>
					</div>
			</div>		
			<hr>
			<div class="row">
				<center><h3>Long Questions</h3></center>
					<div class="certi_form">
						<div class="all_ques_lest">
							<?php 
							$i=0;
							foreach($questions_long as $row){
								$i++;
								$status=false;
								$std_ans='';
								$marks='';
								if(isset($answers[$row['mid']] ) ){$std_ans=$answers[$row['mid']];}
								if(isset($answer_marks[$row['mid']] ) ){$marks=$answer_marks[$row['mid']];}
								 ?>
									<form action="<?php print $module_url.'&qid='.$row['mid'];?>" method="post">
										<input type="hidden" name="qid" value="<?php print $row['mid'];?>">
										<div class="ques_item border-black-1">
											<div class="ques_title">
												<span>Question :-</span> <?php print real_html($row['question']);?>?  (<?php print $row['marks'];?> Marks)
											</div>
											<div class="ui search focus mt-15">																
												<input class="prompts" type="text" name="marks" value="<?php print $marks; ?>" required="" placeholder="Enter obtained marks">
												<span><button class="submit_btn" type="submit">Save Marks</button></span>
												<?php if ($marks==''): ?><span class="text-danger">Not Answered by student</span><?php endif ?>
												<div class="row">													
													<div class="col-lg-6">
														<p class="text-info">Student Answer</p>
														<div class="ui form swdh30">
															<div class="field">
																<textarea rows="5" placeholder="Student answer here..." class="editor3"><?php print real_html($std_ans); ?></textarea>
															</div>
														</div>
													</div>
													<div class="col-lg-6">													
														<p class="text-success">Correct Answer</p>
														<div class="ui form swdh30">
															<div class="field">
																<textarea rows="5" placeholder="Correct Answer..." class="editor3"><?php print real_html($row['solution']); ?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
							 <?php } ?>
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
