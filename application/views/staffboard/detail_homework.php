<!-- Body Start -->
<div class="wrapper _bg4586">
	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">
								<span class="_216b22">
									<a href="<?php print $this->LIB_CONT_ROOT.'index/homework/?sid='.$homework->subject_id.'';?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back 
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Date: <?php print ucwords($homework->date);?></h2>
										<span>Class: <?php print $class->name; if(isset($homework->section_id) && intval($homework->section_id)>0 && isset($sections[$homework->section_id])){print '('.$sections[$homework->section_id].')';} ?> </span> |
										<span>Subject: <?php print $subject->name; ?></span> <br>
										<span>Total Submissions: <?php print count($rows); ?></span> <br>
										<span>Homework: <small><?php print $homework->homework; ?></small></span>
									</div>										
								</div>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->LIB_CONT_ROOT.'index/homework/?sid='.$homework->subject_id.'';?>"  class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a> 
								</span>								
							</div>													
						</div>		
					</div>							
				</div>															
			</div>
		</div>
	</div>
	<div class="_215b15">
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>	
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="cell-ta">Student</th>
								<th class="text-center">Roll N0</th>
								<th class="text-center">Student Work</th>
								<th class="text-center">Options</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=0;
							foreach($rows as $row){
								$student=$this->student_m->get_by_primary($row['student_id']);
								$i++;
							 ?>
                                <tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="cell-ta"><?php print ucwords($student->name); ?></td>
									<td class="text-center"><?php print $student->roll_number; ?></td>
									<td class="text-center"><?php print $row['answer']; ?></td>

									<td class="text-center">
										<?php if(!empty($row['file'])){ ?>
											<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$row['file'];?>" title="View Report">View Document</a>
										<?php }else{ ?>
											N/A
										<?php } ?>
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
