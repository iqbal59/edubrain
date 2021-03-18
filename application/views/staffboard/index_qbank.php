
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-database"></i>Question Bank - (<?php print $subject->name; ?>)</h2>
					<span class="float-right"><a href="https://mozzine.work/software/windows/math-type-6-full.zip">Click Here</a> to download Math Type 6.0</span>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Question Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/qbank/?sid='.$subject->mid; ?>';">Add New Question</button>
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
										<td class="text-center"><?php print real_html($row['question']); ?></td>
										<td class="text-center"><?php print strtoupper($row['type']); ?></td>
										<td class="text-center"><?php print $row['marks']; ?></td>
										<td class="text-center"><?php print $row['difficulty']; ?>%</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/qbank/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
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
