
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-database"></i>Question Bank</h2>
					<span>Want to add bulk questions? <a href="<?php print $this->APP_ROOT.'assets/downloads/bulk-qb-sample.xls' ?>">Download Bulk Sample File</a></span>
					 <span class="float-right">Download <a href="https://mozzine.work/software/windows/math-type-6-full.zip">Math Type 6.0</a>  | <span class="float-right"><a href="https://mozzine.work/software/windows/setup-lightshot.zip">Screenshoter</a></span>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Question Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/bulkqbank' ?>';">Import Excel File</button>
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/qbank' ?>';">Add New Question</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'qbank';?>" method="get">
				<div class="row">
					<div class="col-lg-3 col-md-3">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Search </label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Enter Question, Hint etc.">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Ttype</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="type">
							<option value="">Select Type</option>
							<option value="0">All Type</option>
							<option value="mcq" <?php isset($form['type'])&& $form['type']=='mcq' ? print 'selected' : ''; ?>>MCQ's</option>
							<option value="short" <?php isset($form['type'])&& $form['type']=='short' ? print 'selected':''; ?>>Short</option>
							<option value="long" <?php isset($form['type'])&& $form['type']=='long' ? print 'selected' : ''; ?>>Long</option>
						</select>
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
						<table class="table ucp-table" width="100%">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Subject &amp; Class </th>
									<th class="text-center" scope="col">Question</th>
									<th class="text-center" scope="col">Type</th>
									<th class="text-center" scope="col">Marks</th>
									<th class="text-center" scope="col">Difficulty</th>
									<th class="text-center" scope="col">Options</th>
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
										<td class="text-center"><?php if(isset($subjects[$row['subject_id']])){print '<strong>'.ucwords($subjects[$row['subject_id']]).'</strong> (Class: '.ucwords($classes[$row['class_id']]).')';} ?></td>
										<td class="text-center max-w500"><?php print real_html($row['question']); ?></td>
										<td class="text-center"><?php print strtoupper($row['type']); ?></td>
										<td class="text-center"><?php print $row['marks']; ?></td>
										<td class="text-center"><?php print $row['difficulty']; ?>%</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/qbank/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/qbank/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
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
