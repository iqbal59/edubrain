<?php 
$grand_total_marks=0;
$grand_obt_marks=0;
$total_marks=$paper->marks;
$absentees=array();
$student_positions=array();
$student_obt_marks=array();
$student_percentage=array();
foreach($students as $std){
	$student_obt_marks[$std['mid']]=0;
	$student_percentage[$std['mid']]=0;
	$absent=true;
	foreach($std_answers as $ans){
		//select only intended student
		if($std['mid']==$ans['student_id']){
			$absent=false;
			$student_obt_marks[$std['mid']]+=$ans['marks'];
		}
	}
	//calculate student percentage
	$student_percentage[$std['mid']]=0;
	if($total_marks>0){
		$student_percentage[$std['mid']]=round(($student_obt_marks[$std['mid']]/$total_marks)*100,2);
	}
	if($absent){
		$absentees[$std['mid']]='Absent';
	}else{
		/////////////////////////////////////////
		$grand_total_marks+=$total_marks;
		$grand_obt_marks+=$student_obt_marks[$std['mid']];		
	}
}

arsort($student_percentage,SORT_REGULAR);
$ei=0;
$last_val='';
foreach($student_percentage as $key => $value){
	if(!empty($value)){
		if($last_val != $value){
			$last_val=$value;
			$ei++;
		}
		$student_positions[$key]=$ei;
	}
}


 ?>
<!-- Body Start -->
<div class="wrapper _bg4586">
	<div class="_216b01">
		<div class="container">			
			<div class="row justify-content-md-center">
				<div class="col-md-10">
					<div class="section3125 rpt145">							
						<div class="row">						
							<div class="col-lg-7">
								<span class="_216b22">
									<a href="<?php print $this->LIB_CONT_ROOT.'index/paper/?sid='.$paper->subject_id;?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back 
									</a>
									<br>
								</span>
								
								<div class="dp_dt150">	
									<div class="prfledt1">
										<h2>Quiz: <?php print ucwords($paper->name);?></h2>
										<span>Class: <?php print $class->name; if(isset($paper->section_id) && intval($paper->section_id)>0 && isset($sections[$paper->section_id])){print '('.$sections[$paper->section_id].')';} ?> </span> |
										<span>Subject: <?php print $subject->name; ?></span>
									</div>										
								</div>
								<ul class="_ttl120">
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Students</div>
											<div class="_ttl123"><?php print count($students); ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Absents</div>
											<div class="_ttl123"><?php print count($absentees); ?></div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Result Avg</div>
											<div class="_ttl123"><?php print $grand_total_marks>0 ? round(($grand_obt_marks/$grand_total_marks)*100,2) : '0';?>%</div>
										</div>
									</li>
									<li>
										<div class="_ttl121">
											<div class="_ttl122">Presense</div>
											<div class="_ttl123"><?php print count($students)>0 ? round(((count($students)-count($absentees))/count($students))*100,2) : '0'; ?>%</div>
										</div>
									</li>
								</ul>
							</div>
							<div class="col-lg-5">
								<span class="_216b12">
									<a href="<?php print $this->LIB_CONT_ROOT.'index/paper/?sid='.$paper->subject_id;?>" class="color-white">
										<span><i class="uil uil-arrow-circle-left"></i></span>Go Back
									</a> 
								</span>								
							</div>													
						</div>		
					</div>							
				</div>															
			</div>
		</div>
	</div>
	<div class="_215b15">
		<div class="container">
			<?php $this->load->view($this->LIB_VIEW_DIR.'includes/alert_inc');?>	
			<div class="row">
				<div class="table-responsive mt-30">
					<table class="table ucp-table">
						<thead class="thead-s">
							<tr>
								<th class="text-center" scope="col">#</th>
								<th class="cell-ta">Student</th>
								<th class="text-center">Roll N0</th>
								<th class="text-center">Marks</th>
								<th class="text-center">Percentage</th>
								<th class="text-center">Position</th>
								<th class="text-center">Options</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=0;
							foreach($students as $row){
								$i++;
							 ?>
                                <tr>
									<td class="text-center"><?php print $i; ?></td>
									<td class="cell-ta"><a href="#" title="View Profile"><?php print ucwords($row['name']); ?></a></td>
									<td class="text-center"><?php print $row['roll_number']; ?></td>
									<?php if(array_key_exists($row['mid'], $absentees)){
										?>
										<td class="text-center" colspan="4"><span class="text-danger">Absent</span></td>
										<?php
									}else{
										?>
										<td class="text-center"><?php print $student_obt_marks[$row['mid']].'/'.$total_marks; ?></td>
										<td class="text-center"><?php print $student_percentage[$row['mid']]; ?>%</td>
										<td class="text-center"><?php print isset($student_positions[$row['mid']]) ? get_ordinal_symbol($student_positions[$row['mid']]) : '0'; ?></td>
										<td class="text-center">
											<a href="<?php print $this->CONT_ROOT.'report/paperdetail/'.$paper->mid.'/?std='.$row['mid'];?>" title="View Report">View Paper</a>
										</td>
										<?php
									} ?>
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
