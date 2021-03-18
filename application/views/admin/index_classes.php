
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-layer-group"></i>Classes</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Class Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/classes' ?>';">Create New Class</button>
						</div>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Class Name</th>
									<th class="cell-ta">Students</th>
									<th class="text-center" scope="col">Actions</th>
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
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="cell-ta"><?php print $this->student_m->get_rows(array('class_id'=>$row['mid']),'',true); ?></td>
										<td class="text-center">
											<a class="text-info" href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/classes/'.$row['mid'];?>" title="View Detail">View Details</a> |
											<a class="text-success" href="<?php print $this->LIB_CONT_ROOT.'analytics/attendance/'.$row['mid'];?>" title="View Attendance">View Attendance</a> |
											<a class="text-warning" href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/quiz/'.$row['mid'];?>" title="Generate New Quiz">New Quiz</a> |
											<a class="text-danger" href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paper/'.$row['mid'];?>" title="Generate New Paper">New Paper</a>
										</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/classes/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/classes/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
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
