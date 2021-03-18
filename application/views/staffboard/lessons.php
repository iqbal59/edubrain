
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Online Lectures of <?php print $subject->name;?> subject.</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<div class="row">
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">Lesson N0</th>
									<th class="cell-ta">Lesson Name</th>
									<th class="cell-ta">About</th>
									<th class="text-center" scope="col">Options</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach($rows as $row){
								 ?>
	                                <tr>
										<td class="text-center"><?php print $row['lesson_no']; ?></td>
										<td class="cell-ta"><?php print $row['name']; ?></td>
										<td class="cell-ta"><?php print $row['about']; ?></td>
										<td class="text-center">
											<a href="<?php print $this->CONT_ROOT.'view/'.$row['mid'];?>" title="View Lecture" class="gray-s text-info"><i class="uil uil-message"></i> Play Video</a>
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
