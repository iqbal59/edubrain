<?php 

$COMP_DIR=$LIB_VIEW_DIR.'components/';
$this->load->view($COMP_DIR.'header');
?>
<!-- Body Start -->
	<div class="wrapper coming_soon_wrapper">		
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="cmtk_group">
						<div class="ct-logo">
							<a href="#"><img src="images/ct_logo.svg" alt=""></a>
						</div>
						<div class="cmtk_dt">
							<div class="col-lg-8 no-float no-padding center-block">
								<ul class="clock block clearfix">
									<li>
										<span class="remaining-days" id="days">00</span>
										<label>Days</label>
									</li>
									<li class="sep">:</li>
									<li>
										<span class="remaining-hours" id="hours">00</span>
										<label>hours</label>
									</li>
									<li class="sep">:</li>
									<li>
										<span class="remaining-minutes" id="minutes">00</span>
										<label>minutes</label>
									</li>
									<li class="sep">:</li>
									<li>
										<span class="remaining-seconds" id="seconds">00</span>
										<label>seconds</label>
									</li>
								</ul>
							</div>
							<h4 class="thnk_title1">Please wait. Exam will start soon...</h4>
							<?php if(!empty($quiz->instructions)){ ?>
								<hr>
								<span class="color-white text-left">
									<h5>Exam Instructions:</h5>
									<div  class="color-white text-left"><?php print $quiz->instructions; ?></div>
								</span>
							<?php } ?>
						</div>
						<div class="tc_footer_main">
							<div class="tc_footer_right">
								<p>© 2020 <strong><?php print ucwords($this->config->item('app_author'));?></strong>. All Rights Reserved.</p>
							</div>
						</div>
					</div> 	
				</div>	
			</div>	
		</div>		
	</div>	
	<!-- Body End -->
	<?php 
		$day=get_day_from_date($quiz->date);
		$month=get_month_from_date($quiz->date);
		$year=get_year_from_date($quiz->date);
		$js_date="$year"."-".sprintf('%02s',$month)."-".sprintf('%02s',$day)."T".get_time_from_minutes($quiz->start_time).":00.000".date('P');
	 ?>
	<script type="text/javascript">
		// === Timer === //
		var count = new Date("<?php print $js_date;?>").getTime();
		var x = setInterval(function() {
			var now =  new Date().getTime();
			var d = count - now;	
			if(d <=0){
				location.reload();
				clearInterval(x);
			}else{				
				var days = Math.floor(d/(1000*60*60*24));
				var hours = Math.floor((d%(1000*60*60*24))/(1000*60*60));
				var minutes = Math.floor((d%(1000*60*60))/(1000*60));
				var seconds = Math.floor((d%(1000*60))/1000);	
				document.getElementById("days").innerHTML = days;
				document.getElementById("hours").innerHTML = hours;
				document.getElementById("minutes").innerHTML = minutes;
				document.getElementById("seconds").innerHTML = seconds;	
			}
		},1000);
	</script>
<?php
$this->load->view($COMP_DIR.'footer');
 ?>