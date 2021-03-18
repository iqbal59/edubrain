
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Exam Results</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">Serial No</th>
								<th class="text-center" scope="col">Paper</th>
								<th class="text-center" scope="col">Subject</th>
								<th class="text-center" scope="col">Date</th>
								<th class="text-center" scope="col">Marks</th>
								<th class="text-center" scope="col">Percentage</th>
								<th class="text-center" scope="col">Options</th>
							</tr>
						</thead>
						<tbody>
							<?php 							
							$i=0;
							$grand_total_marks=0;
							$grand_obt_marks=0;
							$total_skipped=0;
							$filter=array('class_id'=>$this->LOGIN_USER->class_id);
							$todayjd=$this->user_m->todayjd;
							$filter['jd <=']=$todayjd;
							$filter['show_result']=1;
			                $std_answers=$this->paper_answer_m->get_values_array('question_id','answer',array('student_id'=>$this->LOGIN_USER->mid));
			                $std_answer_marks=$this->paper_answer_m->get_values_array('question_id','marks',array('student_id'=>$this->LOGIN_USER->mid));
							$papers=$this->paper_m->get_rows($filter,array('select'=>'name,date,jd,subject_id,class_id,section_id,start_time,marks','orderby'=>'jd DESC, start_time DESC'));
							foreach($papers as $ppr){
								$subject=$this->subject_m->get_by_primary($ppr['subject_id']);
								$filter=array('subject_id'=>$subject->mid);
								if($this->subject_group_m->get_rows($filter,'',true)<1){
									//verify the section exam
									if($ppr['section_id']>0 && $ppr['section_id'] != $this->LOGIN_USER->section_id){continue;}
									$ppr_questions=$this->paper_question_m->get_rows(array('paper_id'=>$ppr['mid']),array('select'=>'paper_id,marks,answer'));
									$i++; 
									?>
										<tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="text-center"><?php print $ppr['name']; ?></td>
										<td class="text-center"><?php print $subject->name; ?></td>
										<td class="text-center"><?php print $ppr['date']; ?></td>
											<?php if($this->paper_attempt_m->get_rows(array('paper_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)<1){$total_skipped++;
											 ?>
												<td class="text-center" colspan="3"><span class="text-danger">Paper Not Attempted</span></td>
											<?php }else{
												$obt_marks=0;
												$total_marks=0;
												$percentage=0;
												$grand_total_marks+=$ppr['marks'];
												$total_marks=$ppr['marks'];
												foreach($ppr_questions as $q){
													//verify the answer
													if(isset($std_answer_marks[$q['mid']]) ){
														//correct answer
														$obt_marks+=$std_answer_marks[$q['mid']];
														$grand_obt_marks+=$std_answer_marks[$q['mid']];
													}
												}
												$total_marks >0 ? $percentage=round(($obt_marks/$total_marks)*100,2) : '';
												?>
											<td class="text-center"><?php print $obt_marks.'/'.$total_marks;?></td>
											<td class="text-center"><?php print $percentage;?>%</td>
											<td class="text-center"><a href="<?php print $this->CONT_ROOT.'detail/'.$ppr['mid'];?>">View Detail</a></td>
											<?php } ?>
										</tr>
									<?php }else if($this->LOGIN_USER->group_id > 0 ){
									$filter['group_id']=$this->LOGIN_USER->group_id;
									if($this->subject_group_m->get_rows($filter,'',true)>0){
									//verify the section exam
									if($ppr['section_id']>0 && $ppr['section_id'] != $this->LOGIN_USER->section_id){continue;}
									$ppr_questions=$this->paper_question_m->get_rows(array('paper_id'=>$ppr['mid']),array('select'=>'paper_id,marks,answer'));
									$i++; 
									?>
										<tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="text-center"><?php print $ppr['name']; ?></td>
										<td class="text-center"><?php print $subject->name; ?></td>
										<td class="text-center"><?php print $ppr['date']; ?></td>
											<?php if($this->paper_attempt_m->get_rows(array('paper_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)<1){$total_skipped++;
											 ?>
												<td class="text-center" colspan="3"><span class="text-danger">Paper Not Attempted</span></td>
											<?php }else{
												$obt_marks=0;
												$total_marks=0;
												$percentage=0;
												$grand_total_marks+=$ppr['marks'];
												$total_marks=$ppr['marks'];
												foreach($ppr_questions as $q){
													//verify the answer
													if(isset($std_answer_marks[$q['mid']]) ){
														//correct answer
														$obt_marks+=$std_answer_marks[$q['mid']];
														$grand_obt_marks+=$std_answer_marks[$q['mid']];
													}
												}
												$total_marks >0 ? $percentage=round(($obt_marks/$total_marks)*100,2) : '';
												?>
											<td class="text-center"><?php print $obt_marks.'/'.$total_marks;?></td>
											<td class="text-center"><?php print $percentage;?>%</td>
											<td class="text-center"><a href="<?php print $this->CONT_ROOT.'detail/'.$ppr['mid'];?>">View Detail</a></td>
											<?php } ?>
										</tr>
									<?php 
									}
								}
							}?>
                        </tbody>
	                    <?php if($i>0){ ?>
                        <tfoot class="tfoot-s">
							<tr>
								<th class="text-center" scope="col" colspan="4">Grand Total</th>
								<th class="text-center" scope="col"><?php print $grand_obt_marks.'/'.$grand_total_marks; ?></th>
								<th class="text-center" scope="col"><?php print $grand_total_marks>0 ? round(($grand_obt_marks/$grand_total_marks)*100,2) : ''; ?>%</th>
								<th class="text-center" scope="col"></th>
							</tr>
						</tfoot>
						<?php } ?>
					</table>
                    <?php if($i>0){ ?>
					<p>The student not appeared in <strong><span class="text-danger"><?php print $total_skipped; ?></span></strong> papers out of total <strong><?php print $i; ?></strong> papers.</p>
					<?php } ?>
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
