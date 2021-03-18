<?php  ?>
<!-- Body Start -->
<div class="wrapper _bg4586" ng-controller="mozzCtrl"  ng-cloak>
	<div class="_216b01" ng-init="rid='<?php print $quiz->mid; ?>'">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">	
								<span class="_216b22">
									<a href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/classes/'.$quiz->class_id;?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a> 									
								</span>									
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Quiz: <?php print ucwords($quiz->name);?></h2>
										<span><strong>Class:</strong> <?php print ucwords($class->name); ?> </span> | 
										<span><strong>Subject:</strong> <?php print ucwords($subject->name); ?></span> | 
										<span><strong>Date:</strong> <?php print ucwords($quiz->date); ?></span> | 
										<span><strong>Start Time:</strong> <?php print get_time_from_minutes($quiz->start_time,false); ?></span>
									</div>										
								</div>
								<ul class="_ttl120">
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Questions</div>
											<div class="_ttl123">{{record.total_questions}}</div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Marks</div>
											<div class="_ttl123">{{record.marks}}</div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Allowed Time</div>
											<div class="_ttl123">{{record.total_time}} min.</div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Difficulty</div>
											<div class="_ttl123"><?php print $quiz->difficulty; ?>%</div>
										</div>
									</li>
								</ul>
								<p class="mt-2">									
									<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/quizbank/?rid='.$quiz->mid;?>" class="text-danger">
										<span><i class="uil uil-trash-alt"></i></span>Delete All Questions (Total Added:{{record.total_questions}})
									</a> 
								</p>
							</div>		
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/classes/'.$quiz->class_id.'?tab=quiz';?>" class="color-white">
										<span><i class="uil uil-arrow-left"></i></span>Go Back
									</a> 
								</span>
								
							</div>												
						</div>		
					</div>							
				</div>															
			</div>
		</div>
	</div>
	<div class="_215b15">
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>					
			<div class="row">
				<div class="col-lg-12">						
					<div class="course_tabs">
						<nav>
							<div class="nav nav-tabs tab_crse" id="nav-tab" role="tablist">
								<a class="nav-item nav-link <?php empty($tab) ? print 'active' : ''; ?>" href="<?php print $mod_url;?>" aria-selected="true">Questions List</a>
								<a class="nav-item nav-link <?php strtolower($tab)=='qbadd' ? print 'active' : ''; ?>" href="<?php print $mod_url.'?tab=qbadd';?>" aria-selected="true">Add Question from Question Bank</a>
								<a class="nav-item nav-link <?php strtolower($tab)=='add' ? print 'active' : ''; ?>" href="<?php print $mod_url.'?tab=add';?>" aria-selected="true">Add New Question</a>
							</div>
						</nav>						
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="_215b17">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="course_tab_content">
						<div class="tab-content" id="nav-tabContent">
							<div class="tab-pane fade <?php empty($tab) ? print 'show active' : ''; ?>" id="nav-about" role="tabpanel">
								<div class="_htg451">
									<div class="_htg452">
										<h3>Questions List</h3>
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Question</th>
															<th class="text-center">Answer</th>
															<th class="text-center">Marks</th>
															<th class="text-center">Type</th>
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
																<td class="text-center"><?php print real_html($row['answer']); ?></td>
																<td class="text-center"><?php print real_html($row['marks']); ?></td>
																<td class="text-center">
																	<a href="<?php print $mod_url.'?action=delete&qid='.$row['mid'];?>"  title="Delete" class="gray-s text-danger"><i class="uil uil-trash-alt"></i></a>
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
							<div class="tab-pane fade <?php strtolower($tab)=='qbadd' ? print 'show active' : ''; ?>" id="nav-courses" role="tabpanel">
								<div class="crse_content">
									<h3>Add Question from question bank</h3>
									<div class="_14d25">
										<form action="<?php print $mod_url;?>" method="get">
											<input type="hidden" name="tab" value="qbadd">
											<div class="row text-right">
												<div class="col-md-12">
													<select class="" name="limit">
														<option value="">select Questions Limit</option>
														<option value="5" <?php if(isset($form['limit']) && $form['limit']=='5'){print 'selected';}?>>5 Questions</option>
														<option value="10" <?php if(isset($form['limit']) && $form['limit']=='10'){print 'selected';}?>>10 Questions</option>
														<option value="20" <?php if(isset($form['limit']) && $form['limit']=='20'){print 'selected';}?>>20 Questions</option>
														<option value="50" <?php if(isset($form['limit']) && $form['limit']=='50'){print 'selected';}?>>50 Questions</option>
													</select>
													<input type="text" name="chapter" value="<?php if(isset($form['chapter']) && !empty($form['chapter'])){print $form['chapter'];}?>" size="36" placeholder="Enter chapter number or leave blank">
													<input type="text" name="topic" value="<?php if(isset($form['topic']) && !empty($form['topic'])){print $form['topic'];}?>" size="36" placeholder="Enter Topic or leave blank">
													<button class="create_btn_dash" type="submit">Load More</button>		
												</div>
											</div>
										</form>
										<hr>
										<div class="alert alert-success alert-styled-left alert-dismissible" ng-show="show_note">
											<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button> Question added successfully
										</div>
										<div class="row">
											<div class="table-responsive mt-30">
												<table class="table ucp-table">
													<thead class="thead-s">
														<tr>
															<th class="text-center" scope="col">#</th>
															<th class="cell-ta">Question</th>
															<th class="text-center">Answer</th>
															<th class="text-center">Marks</th>
															<th class="text-center">Chapter</th>
															<th class="text-center" scope="col">Options</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i=0;
														$q_ids='';
														foreach($rows as $row){
															$i++;
															$q_ids.=$row['mid'].'-';
														 ?>
							                                <tr>
																<td class="text-center"><?php print $i; ?></td>
																<td class="text-center"><?php print real_html($row['question']); ?></td>
																<td class="text-center"><?php print real_html($row['answer']); ?></td>
																<td class="text-center"><?php print real_html($row['marks']); ?></td>
																<td class="text-center"><?php print $row['chapter']; ?></td>
																<td class="text-center">
																	<a href="<?php print $mod_url.'?tab=qbadd&action=save&qid='.$row['mid'];?><?php if(!empty($mod_url_params)){print $mod_url_params;}?>"  title="Add to Paper" class="gray-s text-info"><i class="uil uil-plus"></i></a>
																</td>
															</tr>
														 <?php } ?>
						                            </tbody>
												</table>

												<p class="mt-2">									
													<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/quizbank/'.$quiz->mid.'?tab=qbadd&action=multisave&qid='.$q_ids;?><?php if(!empty($mod_url_params)){print $mod_url_params;}?>" class="text-success">Add above all question into paper
													</a> 
												</p>
											</div>
										</div>		
									</div>		
								</div>
							</div>
							<div class="tab-pane fade <?php strtolower($tab)=='add' ? print 'show active' : ''; ?>" id="nav-quiz" role="tabpanel">
								<div class="crse_content">
									<h3>Add New Question</h3>
									<div class="_14d25">

										<form action="<?php print $mod_url.'?tab=add';?>" method="post">
											<div class="row">
												<div class="col-md-12">	
													<div class="row">
														<div class="col-lg-3 col-md-3">
															<div class="mt-20 lbel25">	
																<label>Save Question into</label>
															</div>
															<select class="ui hj145 dropdown cntry152 prompt srch_explore" name="saveqb">
																<option value="">Select option</option>
																<option value="0" <?php if(isset($_SESSION['saveqb']) && $_SESSION['saveqb']=='0'){print 'selected';} ?>>Quiz Only</option>
																<option value="1" <?php if(isset($_SESSION['saveqb']) && $_SESSION['saveqb']=='1'){print 'selected';} ?>>Quiz + Question Bank</option>
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
													<div class="row">
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
														<div class="col-lg-3 col-md-3">
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
							</div>
						</div>
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
