
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>My Subjects</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="text-center" scope="col">Subject</th>
								<th class="text-center" scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 							
							$i=0; 
							foreach($subjects as $row){
								$filter=array('subject_id'=>$row['mid']);
								if($this->subject_group_m->get_rows($filter,'',true)<1){
								$i++; ?>
									<tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="text-center"><?php print $row['name']; ?></td>
									<td class="text-center"><a href="<?php print $this->CONT_ROOT.'view/'.$row['mid'];?>">View Subject Notes</a></td>
									</tr>
								<?php }else if($this->LOGIN_USER->group_id > 0 ){
									$filter['group_id']=$this->LOGIN_USER->group_id;
									if($this->subject_group_m->get_rows($filter,'',true)>0){
									$i++; ?>
										<tr>
										<td class="text-center"><?php print $i; ?></td>
										<td class="text-center"><?php print $row['name']; ?></td>
										<td class="text-center"><a href="<?php print $this->CONT_ROOT.'view/'.$row['mid'];?>">View Subject Notes</a></td>
										</tr>
									<?php 
									}
								}
							}?>
                        </tbody>
					</table>
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
