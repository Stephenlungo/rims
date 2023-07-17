<div style="width:100%;height:auto;float:left;">
	<div style="float:left;width:100%;height:30px;line-height:30px;color:#849839;text-align:center;font-size:1.4em;margin-top:20px;">Select survey below:</div>
	<?php 
	$surveys = mysqli_query($connect,"select * from prep_questionnaires where company_id = $company_id and (branch_id = $branch_id or branch_id = 0) and module_id = 5")or die(mysqli_error($connect));
	
	for($s=0;$s<mysqli_num_rows($surveys);$s++){
		$survey_results = mysqli_fetch_array($surveys,MYSQLI_ASSOC);
		?>
		<div style="width:313px;height:320px;float:left;margin:5px;background-color:#eef;border:solid 1px #777;cursor:pointer;" title="Click to open survey" onmouseover="this.style.border='solid 1px orange';" onmouseout="this.style.border='solid 1px #777';" onclick="start_analytical_survey(<?php print($survey_results['id']);?>,0);">
			<div style="width:100%;height:170px;float:left;"><img src="imgs/risk_assessment.jpg" style="width:100%;height:100%;"></div>
			<div style="width:100%;min-height:30px;max-height:60px;float:left;line-height:30px;text-align:center;font-size:1.3em;"><?php print($survey_results['title']);?></div>
			<div style="width:99.6%;min-height:30px;max-height:90px;float:left;padding:2px;text-align:center;"><?php print($survey_results['description']);?></div>
		</div>
		<?php
	}
	?>
</div>