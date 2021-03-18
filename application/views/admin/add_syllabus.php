
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Upload Syllabus (<?php print $record->name; ?>)</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Go Back to Syllabus</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'detail/mdl/classes/'.$record->mid.'/?tab=syllabus' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'upload_syllabus';?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="rid" value="<?php print $record->mid; ?>">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<?php if(is_array($sections) && count($sections)>0){ ?>
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Section</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
									<option value="">All Sections</option>
									<option value="0">All Sections</option>
									<?php foreach($sections as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print ucwords($name);?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Title<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="title" value="" required="" min="1" max="99" placeholder="Enter Title">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Select File<span class="text-danger">*</span> (pdf, doc, zip, jpg, png, bmp)</label>
									<div class="ui left icon input swdh19">										
										<input type="file" name="file" required>															
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Upload Syllabus</button>										
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
