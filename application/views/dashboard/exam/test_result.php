<?php 

$COMP_DIR=$LIB_VIEW_DIR.'components/';
$this->load->view($COMP_DIR.'header');
$this->load->view($COMP_DIR.'menu');
?>


	<!-- Body Start -->
	<div class="wrapper _bg4586 _new89">		
		<div class="_215b15">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">	
						<div class="title126">	
							<h2>Test Result</h2>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php 
		$total_questions=0;
		$total_answered=0;
		$total_correct=0;
		$total_wrong=0;
		$total_marks=0;
		$obt_marks=0;
		$percentage=0;
		foreach($questions as $row){
			$total_questions++;$total_marks+=$row['marks'];
			foreach($answers as $ans){
				if($ans['question_id']==$row['mid']){
					$total_answered++;
					//verify if answer is correct
					if($row['answer']==$ans['answer']){
						$total_correct++;
						$obt_marks+=$row['marks'];
					}else{
						$total_wrong++;
					}
				}
			}
		}
		$total_marks>0 ? $percentage=round((($obt_marks/$total_marks)*100),2): '';
		 ?>
		<div class="faq1256">
			<div class="container">
				<div class="certi_form rght1528">
					<div class="test_result_bg">
						<ul class="test_result_left">
							<li>
								<div class="result_dt">
									<i class="uil uil-check right_ans"></i>
									<p>Right<span>(<?php print $total_correct; ?>)</span></p>
								</div>
							</li>
							<li>
								<div class="result_dt">
									<i class="uil uil-times wrong_ans"></i>
									<p>Wrong<span>(<?php print $total_wrong; ?>)</span></p>
								</div>
							</li>
							<li>
								<div class="result_dt">
									<h4><?php print $percentage; ?>%</h4>
									<p>Marks (<?php print $obt_marks.'/'.$total_marks; ?>)</p>
								</div>
							</li>
						</ul>
						<div class="result_content">
							<?php if($percentage>=90){?>
								<h2>Excelent! <?php print $this->LOGIN_USER->name; ?></h2>
							<?php }elseif($percentage>=80){ ?>
								<h2>Very Good! <?php print $this->LOGIN_USER->name; ?></h2>
							<?php }elseif($percentage>=70){ ?>
								<h2>Good! <?php print $this->LOGIN_USER->name; ?></h2>
							<?php }elseif($percentage>=50){ ?>
								<h2>Fair! <?php print $this->LOGIN_USER->name; ?></h2>
							<?php }else{ ?>
								<h2>Try Next Time! <?php print $this->LOGIN_USER->name; ?></h2>
							<?php } ?>
							<p>Hardwork is the key to success.</p>
							<a href="<?php print $this->CONT_ROOT;?>">Go Back</a> | 
							<a href="<?php print $this->CONT_ROOT.'detail/'.$test->mid;?>">View Result Detail</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Body End -->
<?php
$this->load->view($COMP_DIR.'footer');
 ?>
	