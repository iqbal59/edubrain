
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-reader"></i>Daily Attendance (<?php print get_date_from_jd($jd); ?>) -  Class <?php print $row->name; ?></h2>
					<div class="text-right">
						<span><a href="<?php print $this->CONT_ROOT.'attendance/'.$row->mid.'/?jd='.($jd-1);?>" title="Previous Day" class="text-danger">Previous Day</a></span>
						<?php if($jd!=$this->user_m->todayjd){?>
						<span class="mlr-15"><a href="<?php print $this->CONT_ROOT.'attendance/'.$row->mid.'/?jd='.$this->user_m->todayjd;?>" title="Today" class="text-success">Today</a></span>
						<?php }?>
						<?php if($jd<$this->user_m->todayjd){?>
						<span class="mlr-15"><a href="<?php print $this->CONT_ROOT.'attendance/'.$row->mid.'/?jd='.($jd+1);?>" title="Next Day" class="text-info">Next Day</a></span>
						<?php }?>
					</div>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>				
			</div>
			<?php 
			$att=array();
			?>
			<div class="row">
				<div class="col-md-12">	
					<div class="_14d25">
						<div class="row">
							<div class="table-responsive mt-30">
								<table class="table ucp-table">
									<thead class="thead-s">
										<tr>
											<th>#</th>
											<th class="cell-ta">Student</th>
											<?php foreach($subjects as $id=>$name){
												$att[$id]['total']=0;
												$att[$id]['present']=0;
												?>
											<th class="cell-ta"><?php print ucwords($name); ?></th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i=0;
										foreach($students as $std){
										 ?>
			                                <tr>
			                                	<td><?php print ++$i; ?></td>
												<td class="cell-ta"><a href="<?php print $this->LIB_CONT_ROOT.'detail/mdl/students/'.$std['mid'];?>" title="View Profile"><?php print $std['name']; ?></a></td>
												<?php foreach($subjects as $id=>$name){
													$att[$id]['total']++;
												?>
												<td class="cell-ta">
													<?php 
													$lesn="";
													$status="<span class='text-danger'>A</span>";
													if(array_key_exists($id, $lessons)){
														$lesn=$lessons[$id].' - ';
													}else{
														$status="---";														
													}
													foreach($att_log as $log){
														if($log['subject_id']==$id){
															if($log['student_id']==$std['mid']){
																$att[$id]['present']++;
																$status="<span class='text-success' title='".$lesn.$log['datetime']."'>P</span>";
															}
														}
														?>
													<?php }; ?>
													<?php print $status; ?>
												</td>
												<?php } ?>												
											</tr>
										 <?php } ?>
		                            </tbody>
									<tfoot class="tfoot-s">
										<tr>
											<th class="cell-ta" colspan="2">Presence Ratio</th>
											<?php foreach($subjects as $id=>$name){?>
												<th class="cell-ta"><?php print round(($att[$id]['present']/$att[$id]['total'])*100,2); ?>%</th>
											<?php } ?>
										</tr>
									</tfoot>
								</table>
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
