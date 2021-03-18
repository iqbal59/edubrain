
<!-- Body Start -->
<div class="wrapper" ng-controller="mozzCtrl"  ng-cloak>
	<div class="sa4d25">
		<div class="container-fluid" ng-init="rid='<?php print $lesson->mid;?>'">			
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<div class="section3125">
						<div class="live1452">
							<?php switch (strtolower($lesson->host)) {
								case 'youtube':{ ?>
									<iframe src="https://www.youtube.com/embed/<?php print getVideoIdFromUrl($lesson->video_link,'youtube');?>?rel=0&autoplay=1" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								<?php }
								break;
							} ?>
						</div>
						<div class="user_dt5">
							<div class="user_dt_left">
								<div class="live_user_dt">
									<div class="user_cntnt">
										<h4><?php print $subject->name ?></h4>
										<!-- <button class="subscribe-btn">Subscribe</button> -->
									</div>
								</div>
							</div>
							<div class="user_dt_right">
								<ul>
									<li>
										<a href="#" class="lkcm152"><i class='uil uil-eye'></i><span><?php print $lesson->views; ?></span></a>
									</li>
								</ul>
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
