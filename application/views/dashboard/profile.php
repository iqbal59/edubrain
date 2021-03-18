
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-xl-8 col-lg-8 md-8 sm-12">
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
					<div class="right_sides">
						<div class="fcrse_2 mb-30">
							<div class="tutor_img">
								<a href="#"><img src="<?php print $this->UPLOADS_ROOT.'images/user/'.$this->LOGIN_USER->image;?>" alt=""></a>												
							</div>
							<div class="tutor_content_dt">
								<div class="tutor150">
									<a href="#" class="tutor_name color-white"><span class="color-white"><?php print $this->LOGIN_USER->name;?></span></a>
									<div class="mef78" title="Verify">
										<i class="uil uil-check-circle"></i>
									</div>
								</div>
								
                				<div class="table-responsive mt-30"> 
                					<table class="table color-white">
                						<tbody>
                						    <tr>
                								<td class="text-center">Student ID</td>
                								<td class="text-center"><?php print $this->LOGIN_USER->student_id;?></td>
                							</tr>
                						    <tr>
                								<td class="text-center">Father Name</td>
                								<td class="text-center"><?php print $this->LOGIN_USER->father_name;?></td>
                							</tr>
                						    <tr>
                								<td class="text-center">Mobile</td>
                								<td class="text-center"><?php print $this->LOGIN_USER->mobile;?></td>
                							</tr>
                						    <tr>
                								<td class="text-center">Class</td>
                								<td class="text-center"><?php print $this->class_m->get_by_primary($this->LOGIN_USER->class_id)->name;?></td>
                							</tr>
                							<?php if($this->LOGIN_USER->section_id>0){ ?>
                						    <tr>
                								<td class="text-center">Section</td>
                								<td class="text-center"><?php print $this->section_m->get_by_primary($this->LOGIN_USER->section_id)->name;?></td>
                							</tr>
	                						<?php } ?>
                							<?php if($this->LOGIN_USER->group_id>0){ ?>
                						    <tr>
                								<td class="text-center">Group</td>
                								<td class="text-center"><?php print $this->group_m->get_by_primary($this->LOGIN_USER->group_id)->name;?></td>
                							</tr>
	                						<?php } ?>
                						    <tr>
                								<td class="text-center">Roll Number</td>
                								<td class="text-center"><?php print $this->LOGIN_USER->roll_number;?></td>
                							</tr>
                						    <tr>
                								<td class="text-center">Address</td>
                								<td class="text-center"><?php print $this->LOGIN_USER->address;?></td>
                							</tr>
                                        </tbody>
                					</table>
                				</div>
							</div> 
						</div>
						<div class="get1452">
							<h4>Daily Motivation</h4>
							<p><?php print $this->SETTINGS[$this->system_setting_m->_WS_DAILY_QOUTE] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->



