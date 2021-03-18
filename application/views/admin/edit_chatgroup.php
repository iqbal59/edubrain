
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-comment-lines"></i>Chat Groups</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Chat Groups</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/chatgroups' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/chatgroups/'.$row->mid;?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Group Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="name" value="<?php print $row->name;?>" required="" min="1" max="99" placeholder="Enter Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="mt-20 lbel25">	
									<label>Select Class</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="class_id">
									<option value="">Select Class</option>
									<option value="0"<?php print 0==$row->class_id ? 'selected': ''; ?> > All Classes</option>
									<?php foreach($classes as $id=>$name){ ?>
									<option value="<?php print $id; ?>" <?php print $id==$row->class_id ? 'selected': ''; ?> ><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="mt-20 lbel25">	
									<label>Select Section</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
									<option value="">Select Section</option>
									<option value="0"<?php print 0==$row->section_id ? 'selected': ''; ?> > All Sections</option>
									<?php foreach($sections as $id=>$name){ ?>
									<option value="<?php print $id; ?>" <?php print $id==$row->section_id ? 'selected': ''; ?> ><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-3 col-md-3">
								<div class="mt-20 lbel25">	
									<label>Select Group</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="group_id">
									<option value="">Select Group</option>
									<option value="0"<?php print 0==$row->group_id ? 'selected': ''; ?> > All Groups</option>
									<?php foreach($groups as $id=>$name){ ?>
									<option value="<?php print $id; ?>" <?php print $id==$row->group_id ? 'selected': ''; ?> ><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button class="create_btn_dash" type="submit">Save Data</button>										
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
