
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-users-alt"></i>Teachers</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-arrow-circle-left"></i>
							<h1>Jump Into Teachers</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/staff' ?>';">Go Back</button>
						</div>
					</div>
				</div>					
			</div>
			<form action="<?php print $this->CONT_ROOT.'save/staff/'.$row->mid;?>" method="post">
				<div class="row">
					<div class="col-md-12">	
						<div class="row">
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Full Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="name" value="<?php print $row->name;?>" required="" min="1" max="99" placeholder="Enter Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Father Name<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="father_name" value="<?php print $row->father_name;?>" required="" min="1" max="99" placeholder="Enter Father Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Mobile<span class="text-danger">*</span></label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="mobile" value="<?php print $row->mobile;?>" required="" min="1" max="99" placeholder="Enter Mobile">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>City</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="city" value="<?php print $row->city;?>" placeholder="Enter City Name">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Staff ID</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="staff_id" value="<?php print $row->staff_id;?>" placeholder="Enter Staff ID">															
									</div>
								</div>										
							</div>
							<div class="col-lg-4 col-md-4">	
								<div class="ui search focus mt-20 lbel25">
									<label>Account Password</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="password" name="password" value="" placeholder="Enter New password or leave empty">															
									</div>
								</div>										
							</div>
							<div class="col-lg-10 col-md-10">	
								<div class="ui search focus mt-20 lbel25">
									<label>Address</label>
									<div class="ui left icon input swdh19">
										<input class="prompt srch_explore" type="text" name="address" value="<?php print $row->address;?>" placeholder="Enter Address">														
									</div>
								</div>										
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
