
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<!-- alert -->
					<div class="alert alert-info alert-styled-left alert-dismissible">
					<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
					This section heavily depends on time calculation so please update your timezone in <a href="<?php print $this->LIB_CONT_ROOT.'maintenance';?>">Settings</a> before creating and attempting paper.
					</div>
					 <!-- /alert -->
					<h2 class="st_title"><i class="uil uil-database"></i>Exam Papers<?php if(isset($subject)){ ?> - (<?php print $subject->name; ?>) <?php } ?></h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<div class="panel-title adcrse1250">
									<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
										Add New Paper
									</a>
								</div>
							</div>
							<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
								<div class="panel-body adcrse_body">
									<form action="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paper/';?>" method="get">
										<div class="row">
											<div class="col-lg-12">
												<div class="discount_form">
													<div class="row">
														<div class="col-lg-4 col-md-4">
															<div class="mt-20 lbel25">	
																<label class="text-muted">Select class to proceed further</label>
															</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore search" required="" name="cid">
																<option value="">Select Class</option>
																<?php foreach($classes as $id=>$name){ ?>
																<option value="<?php print $id; ?>" <?php isset($form['class_id'])&& $form['class_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
																<?php } ?>
															</select>
														</div>
														<div class="col-lg-6 col-md-6">	
															<button class="discount_btn mt-50" type="submit">Add New Paper</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'paper';?>" method="get">
				<input type="hidden" name="sid" value="<?php isset($form['sid'])&&!empty($form['sid']) ? print $form['sid'] : ''; ?>">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Paper Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Lesson Name">
							</div>
						</div>										
					</div>
					<?php if(!isset($form['sid']) || empty($form['sid'])){ ?>
					<div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Class</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="class_id">
							<option value="">Select Class</option>
							<option value="0">All Classes</option>
							<?php foreach($classes as $id=>$name){ ?>
							<option value="<?php print $id; ?>" <?php isset($form['class_id'])&& $form['class_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
							<?php } ?>
						</select>
					</div>
					<?php if(isset($form['class_id'])&& !empty($form['class_id'])){ ?>
					<div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Subject</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="subject_id">
							<option value="">Select Subject</option>
							<option value="0">All Subjects</option>
							<?php foreach($class_subjects as $id=>$name){ ?>
							<option value="<?php print $id; ?>" <?php isset($form['subject_id'])&& $form['subject_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
							<?php } ?>
						</select>
					</div>
					<?php } ?>
					<?php } ?>
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">&nbsp;</label>
							<div class="ui left icon input swdh19">
								<button class="create_btn_dash" type="submit">Search</button>							
							</div>
						</div>		
					</div>
				</div>
			</form>
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="cell-ta">Class</th>
								<th class="cell-ta">Subject</th>
								<th class="cell-ta">Paper</th>
								<th class="cell-ta">Marks</th>
								<th class="cell-ta">Start Date &amp; Time</th>
								<th class="cell-ta">Actions</th>
								<th class="cell-ta">Options</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=0;
							foreach($rows as $row){
								$i++;
							 ?>
                                <tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="text-center">
										<?php print isset($classes[$row['class_id']]) ? ucwords($classes[$row['class_id']]) : ''; ?>
										<?php if($row['section_id']>0 && is_array($sections) && isset($sections[$row['section_id']])){ print '('.$sections[$row['section_id']].')'; } ?>
									</td>
									<td class="text-center"><?php print isset($subjects[$row['subject_id']]) ? $subjects[$row['subject_id']] : ''; ?></td>
									<td class="cell-ta"><?php print $row['name']; ?></td>
									<td class="cell-ta"><?php print $row['marks']; ?></td>
									<td class="cell-ta"><?php print $row['date'].' '.get_time_from_minutes($row['start_time'],false,true); ?></td>
									<td>
										<?php if($row['jd']<=$this->user_m->todayjd){ ?>
										<a href="<?php print $this->LIB_CONT_ROOT.'analytics/report/paper/'.$row['mid'];?>" title="View Report">View Report</a>
										<?php }else{
											print '<span class="text-info">Awaiting Result</span>';
										} ?>
									</td>
									<td>
										<a href="<?php print $this->LIB_CONT_ROOT.'printer/mdl/paper/'.$row['mid'];?>" title="Print Paper" class="gray-s" target="_blank"><i class="uil uil-print"></i></a>
										<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/paper/'.$row['mid'];?>" title="Edit" class="text-info"><i class="uil uil-edit-alt"></i></a>
										<?php if($row['jd']<=$this->user_m->todayjd ){ ?>
											<?php if(intval($row['show_result'])<1){ ?>
												<a href="<?php print $this->LIB_CONT_ROOT.'edit/save/paperresult/'.$row['mid'].'/?status=1';?>" title="Declare Result" class="gray-s text-success"><i class="uil uil-eye"></i></a>
											<?php }else{ ?>
												<a href="<?php print $this->LIB_CONT_ROOT.'edit/save/paperresult/'.$row['mid'].'/?status=0';?>" title="UnDeclare Result. Declared on <?php print $row['result_date']; ?>" class="gray-s text-danger"><i class="uil uil-eye-slash"></i></a>
											<?php } ?>
										<?php } ?>
										<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paperbank/'.$row['mid'];?>" title="Question Bank" class="gray-s"><i class="uil uil-database"></i></a>
										<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/paper/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
