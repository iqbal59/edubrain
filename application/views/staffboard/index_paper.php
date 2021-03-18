
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-database"></i>Papers - (<?php print $subject->name.' - '.$classes[$subject->class_id]; ?> Class)</h2>
					<button  class="float-right" class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'index/subjects'?>';">Go Back</button>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="cell-ta">Paper</th>
								<th class="cell-ta">Marks</th>
								<th class="cell-ta">Start Date &amp; Time</th>
								<th class="cell-ta">Actions</th>
								<th class="cell-ta">Options</th>
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
									<td class="cell-ta"><?php print $row['name']; if(isset($row['section_id']) && intval($row['section_id'])>0 && isset($sections[$row['section_id']])){print ' - ('.$sections[$row['section_id']].' Section)';} ?></td>
									<td class="cell-ta"><?php print $row['marks']; ?></td>
									<td class="cell-ta"><?php print $row['date'].' '.get_time_from_minutes($row['start_time'],false,true); ?></td>
									<td>
										<?php if($row['jd']<=$this->user_m->todayjd){ ?>
										<a href="<?php print $this->LIB_CONT_ROOT.'analytics/report/paper/'.$row['mid'];?>" title="View Report">View Report</a>
										<?php }else{
											print '<span class="text-info">Awaiting Result</span>';
										} ?>
									</td>
									<td>
										<a href="<?php print $this->LIB_CONT_ROOT.'generate/mdl/paperbank/'.$row['mid'];?>" title="Question Bank" class="gray-s"><i class="uil uil-database"></i></a>
									</td>
								</tr>
							 <?php } ?>
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
