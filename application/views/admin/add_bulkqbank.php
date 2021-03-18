
<!-- Body Start -->
<div class="wrapper" ng-controller="mozzCtrl"  ng-cloak>
	<?php if(isset($_SESSION['class_id']) ){ ?><span ng-init="entry.class_id='<?php print $_SESSION['class_id'];?>'"></span> <?php } ?>
	<?php if(isset($_SESSION['subject_id'])){ ?><span ng-init="entry.subject_id='<?php print $_SESSION['subject_id'];?>';loadRows();"></span> <?php } ?>
	<?php if(isset($_SESSION['type']) ){ ?><span ng-init="entry.type='<?php print $_SESSION['type'];?>'"></span> <?php } ?>
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-database"></i>Question Bank</h2>
					<span>Want to add bulk questions? <a href="<?php print $this->APP_ROOT.'assets/downloads/bulk-qb-sample.xls' ?>">Download Bulk Sample File</a></span>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Question Bank</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/qbank' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<?php echo form_open_multipart($this->CONT_ROOT.'save/bulkqbank');?> 
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-3 col-md-3">
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
							<div class="col-lg-3 col-md-3">
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
							<div class="col-lg-3">	
								<div class="mt-20 lbel25">	
									<label>Select Excel File<span class="text-danger">*</span></label>
								</div>											
								<input type="file" name="file">
								<br>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button type="submit" class="create_btn_dash" >Upload Data File</button>										
							</div>
						</div>	
					</div>
				</div>
			<?php echo form_close(); ?>
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
