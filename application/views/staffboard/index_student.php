
<!-- Body Start --> 
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-reader"></i>Students</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'students';?>" method="get">
				<input type="hidden" name="sid" value="<?php print $form['sid']; ?>">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Student ID</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="student_id" value="<?php isset($form['student_id'])&&!empty($form['student_id']) ? print $form['student_id'] : ''; ?>" placeholder="Student ID">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted"><b>AND</b> Student Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Student Name">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">
						<div class="mt-20 lbel25">	
							<label class="text-muted"><b>AND</b>  Section</label>
						</div>
						<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
							<option value="">Select Section</option>
							<option value="0">All Sections</option>
							<?php foreach($sections as $id=>$name){ ?>
							<option value="<?php print $id; ?>" <?php isset($form['section_id'])&& $form['section_id']==$id ? print 'selected' : ''; ?>><?php print $name;?></option>
							<?php } ?>
						</select>
					</div>
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
					<div class="table-responsive mt-20">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="text-center" scope="col">Student ID</th>
									<th class="cell-ta">Student Name</th>
									<th class="text-center" scope="col">Father Name</th>
									<th class="text-center" scope="col">Roll.No</th>
									<th class="text-center" scope="col">Class</th>
									<th class="text-center" scope="col">Section</th>
									<th class="text-center" scope="col">Group</th>
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
										<td class="text-center"><?php print $row['student_id']; ?></td>
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="text-center"><?php print $row['father_name']; ?></td>
										<td class="text-center"><?php print $row['roll_number']; ?></td>
										<td class="text-center"><?php print $classes[$row['class_id']]; ?></td>
										<?php if($row['section_id']){ ?>
											<td class="text-center"><?php print $sections[$row['section_id']]; ?></td>
										<?php }else{ ?>
											<td class="text-center"> --- </td>
										<?php } ?>
										<?php if($row['group_id']){ ?>
											<td class="text-center"><?php print $groups[$row['group_id']]; ?></td>
										<?php }else{ ?>
											<td class="text-center"> --- </td>
										<?php } ?>
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
