<?php 

$COMP_DIR=$LIB_VIEW_DIR.'components/';
$this->load->view($COMP_DIR.'header');
?>

<!-- Header Start -->
	<header class="header clearfix">
		<div class="container exam_container">
			<div class="row soft_padding">
				<div class="col-lg-10 col-md-10">
					<a href="<?php print $test_url.'/?finish';?>" onclick="return confirm('Are you sure to end paper? You can not resume paper afterwards.');" class="btn btn-danger">End Test</a>
					<span  class="ml-30">Goto
					<select class="input" name="qi" id="goto">
						<option value="">Select Question</option>
						<?php foreach ($indexes as $id => $value) {
							?>
						<option value="<?php print $id;?>">Question <?php print $id+1;?>&nbsp;&nbsp;&nbsp;&nbsp; <?php if(!array_key_exists($value, $answers)){print 'x';} ?></option>
						<?php } ?>
					</select>	
					</span>		
				</div>	
				<div class="col-lg-2 col-md-2">
					<span><strong><h4><span class="color-white"><?php print $this->LOGIN_USER->name; ?></span></h4></strong></span>
				</div>	
			</div>
		</div>
	</header>
	<!-- Header End --> 
	<!-- Body Start -->
	<div class="wrapper _bg4586 _new89">
		<div class="faq1256">
			<div class="container exam_container">
				<div class="row soft_padding">				
					<div class="col-lg-3 col-md-3 left_bar">
						<div class="right_side">
							<div class="fcrse_2 mb-30">
								<div class="tutor_content_dt">
									<div class="tutor150">
										<a class="tutor_name"><span class="color-white">Test Information</span></a>
									</div>
									<hr>
									<div class="tutor_cate">
										<strong>Test Name : </strong><?php print ucwords($test->name);?> <br>
										<strong>Subject : </strong><?php print ucwords($subject->name);?> <br>
										<strong>Start Time : </strong><?php print get_time_from_minutes($attempt->start_time,false,true);?> <br>
										<strong>End Time : </strong><?php print get_time_from_minutes($attempt->end_time,false,true);?> <br>
									</div>
									<div class="tut1250">
										<span class="vdt15">Attempted <?php print count($answers);?> out of <?php print count($questions);?></span>
									</div>		
									<hr>	
									<h2><span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span></h2>	
									<hr>
									<?php if ($current_question >0): ?>			
									<a href="<?php print $test_url.'/?prev';?>" class="btn btn-info"><i class="uil uil-angle-double-left"></i>Previous</a> 
									<?php endif ?>
									| 
									<?php if ($current_question+1<count($questions)): ?>
									<a href="<?php print $test_url.'/?next';?>" class="btn btn-info">Next <i class="uil uil-angle-double-right"></i></a>
									<?php endif ?>
								</div> 
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-md-9 right_bar">
						<form action="<?php print $this->CONT_ROOT.'attempt/'.$test->mid;?>" method="post">
							<input type="hidden" name="question_id" value="<?php print $question->mid; ?>">
							<div class="certi_form">
								<div class="all_ques_lest">
									<div class="ques_item">
										<div class="ques_title w-100-percent h-50-percent">
											<span>Question <?php print $current_question+1;?> :-</span> <?php print real_html($question->question);?>
										</div>
										<div class="ui form">
											<div class="grouped fields">										
												<div class="field fltr-radio">
													<div class="ui radio checkbox">
														<input type="radio" name="answer" tabindex="0" class="hidden" value="1" <?php if(isset($answers[$question->mid]) && $answers[$question->mid]=='1'){print " checked";} ?>>
														<label><?php print real_html($question->option1);?></label>
													  </div>
												</div>
												<div class="field fltr-radio">
													<div class="ui radio checkbox">
														<input type="radio" name="answer" tabindex="1" class="hidden" value="2"<?php if(isset($answers[$question->mid]) && $answers[$question->mid]=='2'){print " checked";} ?>>
														<label><?php print real_html($question->option2);?></label>
													</div>
												</div>
												<div class="field fltr-radio">
													<div class="ui radio checkbox">
														<input type="radio" name="answer" tabindex="2" class="hidden" value="3"<?php if(isset($answers[$question->mid]) && $answers[$question->mid]=='3'){print " checked";} ?>>
														<label><?php print real_html($question->option3);?></label>
													</div>
												</div>
												<div class="field fltr-radio">
													<div class="ui radio checkbox">
														<input type="radio" name="answer" tabindex="3" class="hidden" value="4"<?php if(isset($answers[$question->mid]) && $answers[$question->mid]=='4'){print " checked";} ?>>
														<label><?php print real_html($question->option4);?></label>
													  </div>
												</div>
											</div>
										</div>
										<div class="ui form">
											<?php if (!empty($question->hint) ){
												?><p class="text-danger"> hint:- <?php print real_html($question->hint); ?></p><?php
											} ?>
										</div>
									</div>
								</div>
								<span class="float-right"><button class="test_submit_btn" type="submit">Save Answer</button></span>
								<span class="float-right mr-10"><button class="test_submit_btn" type="submit" name="next" value="yes">Save &amp; Next</button></span>
							</div>
						</form>
					</div>	
				</div>
			</div>
			<div class="container exam_container">
				<div class="row soft_padding">
					<div class="col-lg-12 col-md-12">
						<p>
							<ul class="questions">							
							<?php 
							$q=0;
							foreach ($indexes as $id => $value) {
								?>
								<li class="<?php if(array_key_exists($value, $answers)){print 'active ';}?>"><a href="<?php print $test_url.'/?qi='.$id;?>"><?php print $q+1 ?></a></li>
								<?php $q++; } ?>
								<?php if ($current_question+1==count($questions)): ?>
								<li class="min-w150 bg-orange"><a href="<?php print $test_url.'/?finish';?>">End Test</a>
								</li>
								<?php endif ?>
							</ul>
						</p>
						<?php if (!empty($question->detail) ){ ?>
							<p>Details:<br><?php print real_html($question->detail); ?></p>
						<?php } ?>
					</div>	
				</div>
			</div>
		</div>
	</div>
	<!-- Body End -->
	<?php 
		$day=$this->test_m->day;
		$month=$this->test_m->month;
		$year=$this->test_m->year;
		$js_date="$year"."-".sprintf('%02s',$month)."-".sprintf('%02s',$day)."T".get_time_from_minutes($attempt->end_time).":00.000".date('P');
	 ?>
	<script type="text/javascript">
		function minTwoDigits(n) {
		  return (n < 10 ? '0' : '') + n;
		}
		var count = new Date("<?php print $js_date;?>").getTime();
		var x = setInterval(function() {
			var now =  new Date().getTime();
			var d = count - now;	
			if(d <=0){
				location.reload();
				clearInterval(x);
			}else{
			var hours = minTwoDigits(Math.floor((d%(1000*60*60*24))/(1000*60*60)));
			var minutes = minTwoDigits(Math.floor((d%(1000*60*60))/(1000*60)));
			var seconds = minTwoDigits(Math.floor((d%(1000*60))/1000));	
			document.getElementById("hours").innerHTML = hours;
			document.getElementById("minutes").innerHTML = minutes;
			document.getElementById("seconds").innerHTML = seconds;	

			}
		},1000);
		
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
		window.onhashchange=function(){window.location.hash="no-back-button";}
	</script>
<?php
$this->load->view($COMP_DIR.'footer');
 ?>
<script type="text/javascript">
	$('#goto').change(function() {
	    window.location = "<?php print $test_url;?>/?qi=" + $(this).val();
	});
</script>