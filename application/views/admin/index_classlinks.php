
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>On line Classes</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Class Schedule</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/classlinks' ?>';">Add New Class</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'classlinks';?>" method="get">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Subject Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="subject" value="<?php isset($form['subject'])&&!empty($form['subject']) ? print $form['subject'] : ''; ?>" placeholder="Subject Name">
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
					<?php if(count($sections)>0){ ?>
					<div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Section</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
							<option value="">All Sections</option>
							<option value="0">All Sections</option>
							<?php foreach($sections as $id=>$name){ ?>
							<option value="<?php print $id; ?>" <?php isset($form['section_id'])&& $form['section_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
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
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="text-center" scope="col">Class</th>
									<th class="text-center" scope="col">Subject</th>
									<th class="text-center" scope="col">Teacher</th>
									<th class="text-center" scope="col">Class Time</th>
									<th class="text-center" scope="col">ID/Password</th>
									<th class="text-center" scope="col">Action</th>
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
										<td class="text-center">
											<?php print isset($classes[$row['class_id']]) ? $classes[$row['class_id']] : ''; ?>
											<?php if(isset($row['section_id']) && intval($row['section_id'])>0 && isset($sections[$row['section_id']])){ print ' -'.$sections[$row['section_id']].'';} ?>
											<?php if(isset($row['group_id']) && intval($row['group_id'])>0 && isset($groups[$row['group_id']])){ print ' ('.$groups[$row['group_id']].')';} ?>
												
										</td>
										<td class="text-center"><?php print $row['subject']; ?></td>
										<td class="text-center"><?php print $row['teacher_name']; ?></td>
										<td class="text-center"><?php print $row['class_time']; ?></td>
										<td class="text-center"><?php print $row['id_password']; ?></td>
										<td class="text-center">
											<a href="<?php print $row['zoom_link']; ?>" title="Join Class" target="_blank">Join Class</a>
										</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/classlinks/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/classlinks/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
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
