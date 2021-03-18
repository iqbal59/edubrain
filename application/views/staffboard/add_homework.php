
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Assign Homework (<?php print $subject->name; ?>)</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Homework</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/homework?sid='.$subject->mid ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'upload_homework';?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="rid" value="<?php print $subject->mid; ?>">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<?php if (isset($sections) && count($sections)>0): ?>
							<div class="col-lg-3 col-md-3">
								<div class="mt-20 lbel25">	
									<label>Class Section</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
									<option value="">All Sections</option>
									<?php foreach($sections as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>								
							<?php endif ?>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Date</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore datepicker-here" type="text" name="date" value="<?php print date('d.m.Y');?>" required="" min="1" max="99" placeholder="Select Homework Date">
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Select Homework File (if any)</label>
									<div class="ui left icon input swdh19">										
										<input type="file" name="file">
									</div>
								</div>										
							</div>
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Homework</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore" name="homework" value="" placeholder="Write homework description" rows="10" cols="800"></textarea>
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Save Homework</button>										
							</div>
						</div>	
					</div>
				</div>
			</form>
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
