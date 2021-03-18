
<!-- Body Start -->
<div class="wrapper _bg4586">

	
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-book-alt"></i>Online Classes (via Zoom)</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>					
			</div>


			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="text-center" scope="col">Teacher</th>
								<th class="text-center" scope="col">Subject</th>
								<th class="text-center" scope="col">Class Time</th>
								<th class="text-center" scope="col">ID / Password</th>
								<th class="text-center" scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 							
							$i=0;
							$filter=array('class_id'=>$this->LOGIN_USER->class_id);	
							if($this->LOGIN_USER->section_id>0){
								$this->db->where(" (section_id=0 OR section_id=".$this->LOGIN_USER->section_id.")");								
							}				
							$rows=$this->class_link_m->get_rows($filter,array('select'=>'subject,teacher_name,class_time,id_password,zoom_link,class_id,section_id,group_id','orderby'=>'class_id ASC, class_time ASC, section_id ASC'));
							foreach($rows as $row){
								if($this->LOGIN_USER->group_id>0 && intval($row['group_id'])>0 && $this->LOGIN_USER->group_id != $row['group_id']){continue;}
								$i++;
							?>
							<tr>
							<td class="text-center"><?php print $i; ?></td>
							<td class="text-center"><?php print $row['teacher_name']; ?></td>
							<td class="text-center"><?php print $row['subject']; ?></td>
							<td class="text-center"><?php print $row['class_time']; ?></td>
							<td class="text-center"><?php print $row['id_password']; ?></td>
							<td class="text-center"><a href="<?php print $this->CONT_ROOT.'joinclass/'.$row['mid'];?>">Join Class</a></td>
							</tr>
							<?php }?>
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
