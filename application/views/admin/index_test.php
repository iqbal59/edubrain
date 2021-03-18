
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
					<h2 class="st_title"><i class="uil uil-database"></i>Practice Tests<?php if(isset($subject)){ ?> - (<?php print $subject->name; ?>) <?php } ?></h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'test';?>" method="get">
				<input type="hidden" name="sid" value="<?php isset($form['sid'])&&!empty($form['sid']) ? print $form['sid'] : ''; ?>">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Test Name</label>
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
				<div class="table-responsive mt-20">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th> 
								<th class="cell-ta">Student</th>
								<th class="cell-ta">Class</th>
								<th class="cell-ta">Subject</th>
								<th class="cell-ta">Quiz</th>
								<!-- <th class="cell-ta">Marks</th> -->
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
									<td class="text-center"><?php print isset($students[$row['student_id']]) ? $students[$row['student_id']] : ''; ?></td>
									<td class="text-center"><?php print isset($classes[$row['class_id']]) ? $classes[$row['class_id']] : ''; ?></td>
									<td class="text-center"><?php print isset($subjects[$row['subject_id']]) ? $subjects[$row['subject_id']] : ''; ?></td>
									<td class="cell-ta"><?php print $row['name']; ?></td>
									<!-- <td class="cell-ta"><?php print $row['marks']; ?></td> -->
									<td class="cell-ta"><?php print $row['date']; ?></td>
									<td>
										<a href="<?php print $this->LIB_CONT_ROOT.'analytics/report/testdetail/'.$row['mid'];?>" title="View Report">View Report</a>
									</td>

									<td>
										<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/test/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
