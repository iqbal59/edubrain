
<!-- Body Start -->
<div class="wrapper" ng-controller="mozzCtrl"  ng-cloak>
	<?php if(isset($_SESSION['class_id']) ){ ?><span ng-init="entry.class_id='<?php print $_SESSION['class_id'];?>'"></span> <?php } ?>
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-open"></i>Add New Class Link</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Subjects</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/classlinks' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/classlinks';?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Class<span class="text-danger">*</span></label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="class_id" ng-model="entry.class_id" ng-change="loadRows()">
									<option value="">Select Claass</option>
									<?php foreach($classes as $id=>$cls){ ?>
									<option value="<?php print $id; ?>" <?php if(isset($_SESSION['class_id']) && $_SESSION['class_id']==$id){print 'selected';} ?>><?php print $cls;?></option>
									<?php } ?>
								</select>
							</div> 
							<?php if(count($sections)>0){ ?>
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Section</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="section_id">
									<option value="">All Sections</option>
									<?php foreach($sections as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<?php if(count($groups)>0){ ?>
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Group</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="group_id">
									<option value="">All Groups</option>
									<?php foreach($groups as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Subject<span class="text-danger">*</span></label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="subject_id">
									<option value="">Select Subject</option>
									 <?php if(isset($_SESSION['subject_id'])){
									 	$sub=$this->subject_m->get_by_primary($_SESSION['subject_id']);
									 	?>
										<option value="<?php print $sub->mid;?>" selected><?php print $sub->name;?></option>
									 	<?php
									 } ?>
									<option ng-repeat="row in subjects" value="{{row.mid}}">{{row.name}}</option>
								</select>
							</div>
							<?php if(count($teachers)>0){ ?>
							<div class="col-lg-4 col-md-4">
								<div class="mt-20 lbel25">	
									<label>Select Teacher</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore search" name="teacher_id">
									<option value="">Select Teacher</option>
									<?php foreach($teachers as $id=>$name){ ?>
									<option value="<?php print $id; ?>"><?php print $name;?></option>
									<?php } ?>
								</select>
							</div>
							<?php } ?>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Class Time<span class="text-danger">*</span> e.g.(11:30 AM - 12:15 PM)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="class_time" value="" required="" min="1" max="99" placeholder="e.g. 11:00AM TO 11:40AM">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>ID / Password</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="id_password" value="" placeholder="ID / Password">
									</div>
								</div>										
							</div>
							<div class="col-lg-8 col-md-8">	
								<div class="ui search focus mt-20 lbel25">
									<label>Zoom Link <span class="text-danger">*</span>
									</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="zoom_link" value="" required="" min="1" max="99" placeholder="Paste here zoom link">															
									</div>
									<span class="help-block">Visit <a href="https://us04web.zoom.us/profile" target="_blank">zoom.us</a> for Meeting URL e.g. https://us04web.zoom.us/j/3298687485?pwd=M3R3BWN1hBZz09 </span>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br><br>
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
