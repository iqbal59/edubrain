
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Subjects Homework (<?php print $subject->name.' - '.$cls->name; ?>)</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Upload / Assign Homework for today</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/homework?sid='.$subject->mid ?>';">Assign Homework</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'homework';?>" method="get">
				<input type="hidden" name="sid" value="<?php print $form['sid']; ?>">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Date</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore datepicker-here" type="text" name="date" value="<?php isset($form['date'])&&!empty($form['date']) ? print $form['date'] : ''; ?>" placeholder="Homewok Date">
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
									<th class="text-center" scope="col">Homework</th>
									<th class="text-center" scope="col">Date</th>
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
										<td class="text-center"><?php print $row['homework']; ?></td>
										<td class="text-center"><?php print $row['date']; ?></td>
										<td class="text-center">
											<?php if(!empty($row['file'])){ ?>
												<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$row['file'];?>" title="Download" class="text-info">Download</a> |
											<?php } ?>
												<a href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/homework/'.$row['mid'];?>" title="View Submissions" class="text-success">View Submissions</a>
										</td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/homework/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
