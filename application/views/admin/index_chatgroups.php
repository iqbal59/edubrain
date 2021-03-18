
<!-- Body Start -->
<div class="wrapper">
	<div class="sa4d25">
		<div class="container-fluid">			
			<div class="row">
				<div class="col-lg-12">	
					<h2 class="st_title"><i class="uil uil-comment-lines"></i>Chat Groups</h2>
					<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>
				</div>			
				<div class="col-md-12">
					<div class="card_dash1">
						<div class="card_dash_left1">
							<i class="uil uil-plus-circle"></i>
							<h1>Jump Into Chat Groups Creation</h1>
						</div>
						<div class="card_dash_right1">
							<button class="create_btn_dash" onclick="window.location.href = '<?php print $this->LIB_CONT_ROOT.'add/mdl/chatgroups' ?>';">Add New Group</button>
						</div>
					</div>
				</div>					
			</div>
			<div class="row">
				<div class="col-md-12">					
					<div class="table-responsive mt-30">
						<table class="table ucp-table">
							<thead class="thead-s">
								<tr>
									<th class="text-center" scope="col">#</th>
									<th class="cell-ta">Group Name</th>
									<th class="text-center" scope="col">Class</th>
									<th class="text-center" scope="col">Section</th>
									<th class="text-center" scope="col">Group</th>
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
										<td class="cell-ta"><b><a href="<?php print $this->LIB_CONT_ROOT.'chat/groupview/'.$row['mid'];?>"><?php print $row['name']; ?></a></b></td>
										<?php if($row['class_id']){ ?>
										<td class="text-center"><?php print $classes[$row['class_id']]; ?></td>
										<?php }else{ ?>
										<td class="text-center"> ALL </td>
										<?php } ?>
										<?php if($row['group_id']){ ?>
										<td class="text-center"><?php print $groups[$row['group_id']]; ?></td>
										<?php }else{ ?>
										<td class="text-center"> ALL </td>
										<?php } ?>
										<?php if($row['section_id']){ ?>
										<td class="text-center"><?php print $sections[$row['section_id']]; ?></td>
										<?php }else{ ?>
										<td class="text-center"> ALL </td>
										<?php } ?>
										<td class="text-center">
											<a href="<?php print $this->LIB_CONT_ROOT.'edit/mdl/chatgroups/'.$row['mid'];?>" title="Edit" class="gray-s"><i class="uil uil-edit-alt"></i></a>
											<a href="<?php print $this->LIB_CONT_ROOT.'delete/mdl/chatgroups/?rid='.$row['mid'];?>" onclick="return confirm('Are you sure to delete?')" title="Delete" class="gray-s"><i class="uil uil-trash-alt"></i></a>
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
