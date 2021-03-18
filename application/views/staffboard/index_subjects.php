
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Subjects</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
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
											<a href="<?php print $this->LIB_CONT_ROOT.'index/homework/?sid='.$row['mid'];?>" title="Homework">Homework</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/notes/?sid='.$row['mid'];?>" title="Notes" class="text-warning">Notes</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/lessons/?sid='.$row['mid'];?>" title="View Lessons">View Lessons</a> | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/qbank/?sid='.$row['mid'];?>" title="View Question Bank" class="text-success">Question Bank</a>  | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/quiz/?sid='.$row['mid'];?>" title="View Quizes" class="text-danger">Quizzes</a>   | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/paper/?sid='.$row['mid'];?>" title="View Papers" class="text-warning">Papers</a>   | 
											<a href="<?php print $this->LIB_CONT_ROOT.'index/students/?sid='.$row['mid'];?>" title="View Students" class="text-info">Students</a> 
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
