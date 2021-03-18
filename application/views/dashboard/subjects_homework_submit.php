
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Submit Homework (<?php print $subject->name; ?>) - <a href="<?php print $this->LIB_CONT_ROOT.'subjects/homework/'.$subject->mid ?>">Go Back</a></h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'upload_homework';?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="rid" value="<?php print $record->mid; ?>">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Homework</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore" name="homework" value="" placeholder="Write homework description" rows="10" cols="800"></textarea>
									</div>
								</div>										
							</div>
							<div class="col-lg-8 col-md-8">	
								<div class="ui search focus mt-20 lbel25">
									<label>Select Homework File (optional)</label>
									<div class="ui left icon input swdh19">										
										<input type="file" name="file">
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<br><br>
								<button class="create_btn_dash" type="submit">Save Homework</button>
							</div>
						</div>	
					</div>
				</div>
			</form>
			<?php if(count($rows)>0){ ?>
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="text-center" scope="col">Date</th>
								<th class="text-center" scope="col">Homework</th>
								<th class="text-center" scope="col">Action</th>
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
							<td class="text-center"><?php print $row['date']; ?></td>
							<td class="text-center"><?php print $row['answer']; ?></td>
							<td class="text-center">
								<?php if(!empty($row['file'])){ ?>
									<a href="<?php print $this->UPLOADS_ROOT.'files/docs/'.$row['file'];?>">Download File</a>
								<?php } ?>
							</td>
							</tr>
							<?php }?>
                        </tbody>
					</table>
				</div>
			</div>	
			<?php } ?>
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
