
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
			<form action="<?php print $this->CONT_ROOT.'save/qbank';?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-2 col-md-2">
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
							<div class="col-lg-2 col-md-2">
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
							<div class="col-lg-2 col-md-2">
								<div class="mt-20 lbel25">	
									<label>Difficulty Level</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="difficulty">
									<option value="">Select level</option>
									<?php for($d=10;$d<=100;$d+=10){ ?>
									<option value="<?php print $d;?>" <?php if(isset($_SESSION['difficulty']) && $_SESSION['difficulty']==$d){print 'selected';} ?>><?php print $d;?>%</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-lg-2 col-md-2">
								<div class="mt-20 lbel25">	
									<label>Question Type<span class="text-danger">*</span></label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="type" ng-model="entry.type">
									<option value="">Select Type</option>
									<option value="mcq" <?php if(isset($_SESSION['type']) && $_SESSION['type']=='mcq'){print 'selected';}?>>MCQ</option>
									<option value="short" <?php if(isset($_SESSION['type']) && $_SESSION['type']=='short'){print 'selected';}?>>Short</option>
									<option value="long" <?php if(isset($_SESSION['type']) && $_SESSION['type']=='long'){print 'selected';}?>>Long</option>
								</select>
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Marks</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="marks" value="<?php isset($_SESSION['marks']) ? print $_SESSION['marks'] : ''; ?>" placeholder="Enter Marks">
									</div>
								</div>										
							</div>
							<div class="col-lg-2 col-md-2">	
								<div class="ui search focus mt-20 lbel25">
									<label>Chapter Number</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="chapter" value="<?php isset($_SESSION['chapter']) ? print $_SESSION['chapter'] : ''; ?>" placeholder="Chapter N0">															
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Topic (optional)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="topic" value="<?php isset($_SESSION['topic']) ? print $_SESSION['topic'] : ''; ?>" placeholder="Write Topic name (optional)">															
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Write Question<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore editor2" type="text" placeholder="Write Question Here...." name="question">
									</div>
								</div>										
							</div>
						</div>
						<div class="row" ng-show="entry.type==='mcq'">
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Option 1<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore editor" type="text"  placeholder="Write Option1...." name="option1">
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Option 2<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore editor" type="text"  placeholder="Write Option2...." name="option2">
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Option 3<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore editor" type="text"  placeholder="Write Option3...." name="option3">
									</div>
								</div>										
							</div>
							<div class="col-lg-3 col-md-3">	
								<div class="ui search focus mt-20 lbel25">
									<label>Option 4<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore editor" type="text"  placeholder="Write Option4...." name="option4">
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3" ng-show="entry.type==='mcq'">
								<div class="mt-20 lbel25">	
									<label>Select Correct Option</label>
								</div>
								<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="answer">
									<option value="">Select Correct Option</option>
									<option value="1">Option 1</option>
									<option value="2">Option 2</option>
									<option value="3">Option 3</option>
									<option value="4">Option 4</option>
								</select>
							</div>
							<div class="col-lg-9 col-md-9">	
								<div class="ui search focus mt-20 lbel25">
									<label>Hint (if any)</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="hint" placeholder="Write hint (if any)">
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Question Detail (if any)</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore editor2" name="detail" value="" placeholder="Write question detail (if any)" rows="10" cols="800"></textarea>
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12">	
								<div class="ui search focus mt-20 lbel25">
									<label>Solution (if any)</label>
									<div class="ui left icon input swdh19">
										<textarea class="prompts srch_explore editor3" name="solution" value="" placeholder="Write question solution (if any)" rows="10" cols="800"></textarea>
									</div>
								</div>										
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-3">	
								<br>
								<button type="submit" class="create_btn_dash" >Save Data</button>										
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
