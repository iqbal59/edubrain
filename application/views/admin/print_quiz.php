<!DOCTYPE html>
<html>
<head>
	<title>Quiz Printing Module</title>
	<link href="<?php print $this->RES_ROOT;?>css/print.css<?php print $this->FILE_VERSION;?>" rel="stylesheet">
</head>
<body>
<?php 

$qi=0;

?>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<center>
					<h3><strong><?php print ucwords($row->name); ?></strong></h3>
					<h4>Subject: <?php print ucwords($subject->name); ?> (<?php print ucwords($class->name); ?>)</h4>
				</center>
			</div>
		</div>
		<div class="row">
			<div class="col-4">Allowed Time: <?php print $row->allowed_time; ?> Mins</div>
			<div class="col-4">Student ID/Roll No: ...............</div>
			<div class="col-4 float-right">Total Marks: <?php print $row->marks; ?></div>
		</div>


		<?php if(is_array($questions_mcq) && count($questions_mcq)>0){ ?>
		<br><hr>
		<div class="row avoid-page-break">
			<?php foreach($questions_mcq as $row){
				$qi++;
			 ?>
			<div class="col-12 avoid-page-break">
				<div class="row avoid-page-break">
					<div class="col-10 avoid-page-break">
						<strong>Question </strong><?php print $qi; ?>:&nbsp;<?php print real_html(strip_question($row['question'])); ?>
					</div>
					<div class="col-2"><small><?php print $row['marks']; ?> Marks</small></div>
				</div>
				<div class="row avoid-page-break">
					<div class="col-3"><small>(a)</small> <?php print real_html(strip_question($row['option1'])); ?></div>
					<div class="col-3"><small>(b)</small> <?php print real_html(strip_question($row['option2'])); ?></div>
					<div class="col-3"><small>(c)</small> <?php print real_html(strip_question($row['option3'])); ?></div>
					<div class="col-3"><small>(d)</small> <?php print real_html(strip_question($row['option4'])); ?></div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		
	</div>



    <script src="<?php print $this->RES_ROOT;?>js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    	window.print();
	});
    </script>
</body>
</html>
