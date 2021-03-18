
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Lessons</h2> 
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Lessons Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/lessons' ?>';">Add New Lessons</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'lessons';?>" method="get">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Lesson Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Lesson Name">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">AND Date</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore datepicker-here" type="text" name="date" value="<?php isset($form['date'])&&!empty($form['date']) ? print $form['date'] : ''; ?>" placeholder="Date" readonly="">
							</div>
						</div>										
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
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Lesson Name</th>
									<th class="text-center" scope="col">Lesson Number</th>
									<th class="text-center" scope="col">Subject</th>
									<th class="text-center" scope="col">Class</th>
									<th class="text-center" scope="col">Group</th>
									<th class="text-center" scope="col">Date</th>
									<th class="text-center" scope="col">Options</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i=0;
								foreach($rows as $row){
									if(in_array($row['subject_id'], $my_subjects)){
									$i++;
								 ?>
	                                <tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="text-center"><?php print $row['lesson_no']; ?></td>
										<td class="text-center"><?php print $subjects[$row['subject_id']]; ?></td>
										<td class="text-center"><?php print $classes[$row['class_id']]; ?></td>
										<?php if($row['group_id']){ ?>
										<td class="text-center"><?php print $groups[$row['group_id']]; ?></td>
										<?php }else{ ?>
										<td class="text-center"> --- </td>
										<?php } ?>
										<td class="text-center"> <?php print $row['lesson_date']; ?> </td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/lessons/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
										</td>
									</tr>
								 <?php }
								 } ?>
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
