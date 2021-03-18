
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Edit Paper - Class <?php print ucwords($class->name); ?></h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Go back to class</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'detail/mdl/classes/'.$class->mid.'?tab=paper' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/paper/'.$row->mid;?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<?php if(is_array($sections) && count($sections)>0){ ?>
							<div class="col-lg-2 col-md-2">
								<div class="mt-20 lbel25">	
									<label>Select Section</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
									<option value="">All Sections</option>
									<option value="0">All Sections</option>
									<?php foreach($sections as $id=>$name){ ?>
									<option value="<?php print $id; ?>" <?php print $id==$row->section_id ? 'selected':''; ?>><?php print ucwords($name);?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Paper Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="name" value="<?php print $row->name; ?>" required="" min="1" max="99" placeholder="Enter Paper Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Allowed Time (in minutes)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="allowed_time" value="<?php print $row->allowed_time; ?>" placeholder="Time (in minutes)">															
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Paper Date<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore datepicker-here" type="text" name="date" value="<?php print $row->date; ?>" required="" min="1" max="255" placeholder="dd-mm-yyyy" readonly="" >															
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Start Time</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="start_time" value="<?php print get_time_from_minutes($row->start_time,false); ?>" placeholder="00:00">															
									</div>
								</div>										
							</div>
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Paper Instructions</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore" name="instructions" placeholder="Write paper instuctions" rows="10" cols="800"><?php print $row->instructions; ?></textarea>
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Update Paper</button>										
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
