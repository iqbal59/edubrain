
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<form method="get" action="<?php print $this->CONT_ROOT.'create'; ?>">
						<div class="row">
							<div class="col-sm-6">
								<h2 class="st_title"><i class="uil uil-book-alt"></i>Practice Tests </h2>
							</div>
							<div class="col-sm-2">
								<div class="mt-10">	
									<label>Select test subject</label>
								</div>
								<select class="ui hj145" name="subject_id">
									<option value="">Select Subject</option>
									<?php foreach($subjects_arr as $id=>$name){									
										$filter=array('subject_id'=>$id);
										if($this->subject_group_m->get_rows($filter,'',true)<1){?>
											<option value="<?php print $id; ?>"><?php print ucwords($name);?></option>
										<?php }else if($this->LOGIN_USER->group_id > 0 ){
											$filter['group_id']=$this->LOGIN_USER->group_id;
											if($this->subject_group_m->get_rows($filter,'',true)>0){?>
												<option value="<?php print $id; ?>"><?php print ucwords($name);?></option>
											<?php 
											}
										}
									} ?>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="mt-10">	
									<label>Select Chapter</label>
								</div>
								<select class="ui hj145" name="chapter">
									<option value="">All Chapters</option>
									<?php for($c=1;$c<=20;$c++){ ?>
									<option value="<?php print $c; ?>">Chapter <?php print $c;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="mt-10">	
									<label>Click here</label>
								</div>
								<button type="submit" class="btn btn-success" href="<?php print $this->CONT_ROOT.'create';?>"><b>Create Test</b></button>
							</div>
						</div>
					</form>
					<p class="text-muted">
						<code>Questions in Practice Test:</code> <?php print $this->_ALLOWED_TIME; ?> <br>
						<code>Maximum Allowed Time of Test:</code> <?php print $this->_TEST_QUESTIONS; ?> minutes <br>
						<code>*</code> Attempt the practice test in same day.<br>
					</p>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">Serial No</th>
								<th class="text-center" scope="col">Test</th>
								<th class="text-center" scope="col">Marks</th>
								<th class="text-center" scope="col">Date</th>
								<th class="text-center" scope="col">Subject</th>
								<th class="text-center" scope="col">Options</th>
							</tr>
						</thead>
						<tbody class="tbody-s">
							<?php 
							
							$i=0;
							$todayjd=$this->user_m->todayjd;
							foreach($tests as $ppr){
								$subject=$this->subject_m->get_by_primary($ppr['subject_id']);
							    $i++;
							?>
							<tr>
							<td class="text-center"><?php print $i; ?></td>
							<td class="text-center"><?php print $ppr['name']; ?></td>
							<td class="text-center"><?php print $ppr['marks']; ?></td>
							<td class="text-center"><?php print $ppr['date']; ?></td>
							<td class="text-center"><?php print $subject->name; ?></td>
							<td class="text-center">
								<?php if($ppr['jd']>=$this->test_m->todayjd){
									if($this->test_attempt_m->get_rows(array('test_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)<1){ ?>
										<a class="btn btn-danger" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Start Test</a>
									<?php }elseif($this->test_attempt_m->get_rows(array('test_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid,'is_ended'=>0),'',true)>0){ ?>
										<a class="btn btn-success" href="<?php print $this->CONT_ROOT.'attempt/'.$ppr['mid'];?>">Resume Test</a>
									<?php }else{ ?>
										<a class="btn btn-success" href="<?php print $this->CONT_ROOT.'detail/'.$ppr['mid'];?>">View Result</a>
									<?php }									
									?>
								<?php }else{
									if($this->test_attempt_m->get_rows(array('test_id'=>$ppr['mid'],'student_id'=>$this->LOGIN_USER->mid),'',true)>1){ ?>							
										<a class="btn btn-success" href="<?php print $this->CONT_ROOT.'detail/'.$ppr['mid'];?>">View Result</a>
									<?php }else{ ?>
										<span class="text-danger" title="Test not attempted">Time Over</span>
									<?php } ?>
								<?php } ?>
							</td>
							</tr>
							<?php
							}
							 ?>
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
