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
							<h2>Paper Ended</h2>
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
		$percentage=round((($obt_marks/$total_marks)*100),2);
		 ?>
		<div class="faq1256">
			<div class="container">
				<div class="certi_form rght1528">
					<div class="test_result_bg">
						<div class="result_content">
							<h2>Thanks You<?php print $this->LOGIN_USER->name; ?>!</h2>
							<p>You can see the result after paper checking.<br> Allways Remember! Hardwork is the key to success so keep hardworking.</p>
							<a href="<?php print $this->CONT_ROOT;?>">Go Back</a>
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
	