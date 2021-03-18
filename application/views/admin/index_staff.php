
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-users-alt"></i>Teachers</h2>
					<span>Want to add bulk staff/teachers? <a href="<?php print $this->APP_ROOT.'assets/downloads/bulk-staff-sample.xls' ?>">Download Bulk Sample File</a></span>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Teacher Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/bulkstaff' ?>';">Import Excel File</button>
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/staff' ?>';">Add New Teacher</button>
						</div>
					</div>
				</div>					
			</div>

			<form action="<?php print $this->CONT_ROOT.'staff';?>" method="get">
				<div class="row">
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">Staff ID</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="staff_id" value="<?php isset($form['staff_id'])&&!empty($form['staff_id']) ? print $form['staff_id'] : ''; ?>" placeholder="Staff ID">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted"><b>AND</b> Staff Name</label>
							<div class="ui left icon input swdh19">
								<input class="srch_explore" type="text" name="name" value="<?php isset($form['name'])&&!empty($form['name']) ? print $form['name'] : ''; ?>" placeholder="Student Name">
							</div>
						</div>										
					</div>
					<div class="col-lg-2 col-md-2">	
						<div class="ui search focus mt-20 lbel25">
							<label class="text-muted">&nbsp;</label>
							<div class="ui left icon input swdh19">
								<button class="create_btn_dash" type="submit">Search</button>							
							</div>
						</div>		
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Staff Name</th>
									<th class="text-center" scope="col">Staff ID</th>
									<th class="text-center" scope="col">Father Name</th>
									<th class="text-center" scope="col">Mobile</th>
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
										<td class="cell-ta"><a href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/staff/'.$row['mid'];?>" title="View Detail"><?php print $row['name']; ?></a></td>
										<td class="text-center"><?php print $row['staff_id']; ?></td>
										<td class="text-center"><?php print $row['father_name']; ?></td>
										<td class="text-center"><?php print $row['mobile']; ?></td>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/staff/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/staff/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
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
	
	<!-- Footer -->
	<br><br><br><br><br><br>
	<?php
	$this->load->view($LIB_VIEW_DIR.'includes/footer_inc');
	?>
	<!-- /footer -->
</div>
<!-- Body End -->
