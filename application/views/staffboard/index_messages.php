
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-fast-mail"></i>Chat Messages</h2>
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
									<th class="cell-ta">Staff Name</th>
									<th class="cell-ta">Student Name</th>
									<th class="text-center" scope="col">Highlight</th>
									<th class="text-center" scope="col">Started on</th>
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
										<td class="cell-ta"><?php print $staff[$row['staff_id']]; ?></td>
										<td class="cell-ta"><?php print $students[$row['student_id']]; ?></td>
										<td class="text-center"><b><a href="<?php print $this->LIB_CONT_ROOT.'chat/messages/'.$row['mid'];?>"><?php print $row['name']; ?></a></b> 
											<?php if($row['std_update']>0){ ?>
											<span class="badge badge-danger">New</span>
											<?php } ?>
										</td>
										<td class="text-center"><?php print $row['date']; ?></td>
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
