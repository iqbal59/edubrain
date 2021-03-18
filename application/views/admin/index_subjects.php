
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Subjects</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Subject Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/subjects' ?>';">Create New Subject</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'subjects';?>" method="get">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Subject Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Subject Name">
							</div>
						</div>										
					</div>
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
					<!-- <div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Group</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="group_id">
							<option value="">Select Group</option>
							<option value="0">All Group</option>
							<?php foreach($groups as $id=>$name){ ?>
							<option value="<?php print $id; ?>" <?php isset($form['group_id'])&& $form['group_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
							<?php } ?>
						</select>
					</div> -->
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
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Subject Name</th>
									<th class="text-center" scope="col">Class Name</th>
									<?php if(count($groups)>0){ ?>
										<th class="text-center" scope="col">Group Name</th>
									<?php } ?>
									<th class="text-center" scope="col">Actions</th>
									<th class="text-center" scope="col">Options</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i=0;
								foreach($rows as $row){
									$i++;									
					                $subject_groups=$this->subject_group_m->get_values_array('group_id','subject_id',array('subject_id'=>$row['mid']));
								 ?>
	                                <tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="text-center"><?php print $classes[$row['class_id']]; ?></td>
										<?php if(count($groups)>0){ ?>
											<?php if(in_array($row['mid'], $subject_groups)){ ?>
											<td class="text-center">
												<?php foreach($subject_groups as $key=>$val){
												print isset($groups[$key]) ? $groups[$key] : '';
												print ', ';
												}  ?>
											</td>
											<?php }else{ ?>
											<td class="text-center"> All Groups </td>
											<?php } ?>
										<?php } ?>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'index/notes/?sid='.$row['mid'];?>" title="View Notes / Downloads" class="text-info">Notes</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/homework/?sid='.$row['mid'];?>" title="View Notes / Downloads" class="text-warning">Homework</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/qbank/?sid='.$row['mid'];?>" title="View Question Bank" class="text-success">Question Bank</a>  | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/lessons/?sid='.$row['mid'];?>" title="View Lessons">Lessons</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/quiz/?sid='.$row['mid'];?>" title="View Quizes" class="text-danger">Quizzes</a>   | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/paper/?sid='.$row['mid'];?>" title="View Papers" class="text-warning">Papers</a>
										</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/subjects/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/subjects/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
										</td>
									</tr>
								 <?php } ?>
                            </tbody>
						</table>
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
