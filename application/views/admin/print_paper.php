<!DOCTYPE html>
<html>
<head>
	<title>Paper Printing Module</title>
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
		<div class="row">
			<div class="col-12">
				<center>
					<span><strong>[Multiple Choice Question's]</strong></span>
				</center>
				<hr>
			</div>
			<?php foreach($questions_mcq as $row){
				$qi++;
			 ?>
			<div class="col-12 avoid-page-break">
				<div class="row avoid-page-break">
					<div class="col-10 avoid-page-break">
						<strong>Question </strong><?php print $qi; ?>:&nbsp;<?php print real_html(strip_question($row['question'])); ?>
					</div>
					<div class="col-2"><?php print $row['marks']; ?> Marks</div>
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

		<?php if(is_array($questions_short) && count($questions_short)>0){ ?>
		<div class="row avoid-page-break">
			<div class="col-12 avoid-page-break">
				<br>
				<center>
					<span><strong>[Short Question's]</strong></span>
				</center>
				<hr>
			</div>
			<?php foreach($questions_short as $row){
				$qi++;
			 ?>
			<div class="col-12 avoid-page-break">
				<div class="row avoid-page-break">
					<div class="col-10">
						<strong>Question </strong><?php print $qi; ?>:&nbsp;<?php print real_html(strip_question($row['question'])); ?>
					</div>
					<div class="col-2"><?php print strip_question($row['marks']); ?> Marks</div>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

		<?php if(is_array($questions_long) && count($questions_long)>0){ ?>
		<div class="row avoid-page-break">
			<div class="col-12 avoid-page-break">
				<br>
				<center>
					<span><strong>[Long Question's]</strong></span>
				</center>
				<hr>
			</div>
			<?php foreach($questions_long as $row){
				$qi++;
			 ?>
			<div class="col-12 avoid-page-break">
				<div class="row avoid-page-break">
					<div class="col-10">
						<strong>Question </strong><?php print $qi; ?>:&nbsp;<?php print real_html(strip_question($row['question'])); ?>
					</div>
					<div class="col-2"><?php print $row['marks']; ?> Marks</div>
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
