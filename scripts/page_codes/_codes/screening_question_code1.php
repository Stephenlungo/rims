
<div style="width:80%;margin:0 auto;height:auto;">
<?php

if(!$end){
	$question_options = mysqli_query($connect,"select * from prep_question_options where question_id = $this_question_id and status = 1 order by _order")or die(mysqli_error($connect));
	?>
	<div style="width:90%;min-height:30px;float:left;height:auto;line-height:30px;border-bottom:solid 1px #eee;font-size:1.3em;margin-top:10px;color:#5a8cce"><?php print($this_session_results['title']);?></div>
	<div style="width:80%;margin:0 auto;height:auto;">
	<div style="width:100%;height:auto;float:left;line-height:20px;margin-top:10px;font-weight:bold;margin-bottom:5px;"><?php	print($index.'. '.$this_question_results['title']);	?></div>
	
	<?php
	if($this_question_results['option_type'] == 0){
		for($o=0;$o<mysqli_num_rows($question_options);$o++){
			$question_option_results = mysqli_fetch_array($question_options,MYSQLI_ASSOC);
		?>
		<div style="cursor:pointer;height:20px;line-height:20px;min-width:80px;width:auto;padding:5px;text-align:center;background-color:#9bd075;;color:#fff;float:left;margin:2px;" onmouseover="this.style.backgroundColor='#addf8b';" onmouseout="this.style.backgroundColor='#9bd075';" onclick="questionnaire_next(<?php print($questionnaire_id.','.$this_session_id.','.$this_question_id.','.$ordering.','.($index+1).','.$question_option_results['id'].','.$question_option_results['score']);?>);"><?php print($question_option_results['title']);?></div>
		<?php
		}
	}
	?>
	<div style="width:100%;height:10px;float:left;margin-top:30px;">
	<?php
	$prev_question_id = 0;
	$prev_session_id = 0;
	$prev_ordering = 0;
	for($tq=1;$tq<mysqli_num_rows($total_questions)+1;$tq++){
		$total_question_results = mysqli_fetch_array($total_questions);
		?>
		<div style="width:<?php print(100/(mysqli_num_rows($total_questions)));?>%;font-size:0.7em;text-align:center;height:15px;line-height:15px;border-top:solid 1px #eee;border-bottom:solid 1px #eee;float:left;<?php if($index == $tq){?>background-color:orange;<?php }?>" <?php if($tq<$index and $this_questionnaire_results['prev_nav']){?> onmouseover="this.style.backgroundColor='#ffc55b';" onmouseout="this.style.backgroundColor='';" onclick="questionnaire_next(<?php print($total_question_results['questionnaire_id'].','.$prev_session_id.','.$prev_question_id.','.$prev_ordering.','.$tq);?>,'','');trim_from_selection(<?php print($tq-1);?>,'client_scores')"<?php }?>><?php print($tq);?></div>
		
		<?php
		
		$prev_question_id = $total_question_results['id'];
		$prev_session_id = $total_question_results['session_id'];
		$prev_ordering = $total_question_results['_order'];
	}
	?></div>
	</div>
	<?php
}else{	
	?>
	<div style="width:90%;min-height:30px;float:left;height:auto;line-height:30px;border-bottom:solid 1px #eee;font-size:1.3em;margin-top:10px;color:#5a8cce">Thank you</div>
	<div style="width:80%;margin:0 auto;height:auto;margin-top:50px;text-align:center;color:<?php print($result_color);?>">You have successfully completed your assessment...</div>
	<script>
		function calculate_total_score(){
			var scores = $('#client_scores').val();
			var score_array = scores.split(',');
			
			var total_score = 0;
			for(var s=0;s<score_array.length;s++){
				total_score = total_score + Number(score_array[s]);				
			}

			return total_score;
		}
		
		
	//$('#screen_result').html('You got '+calculate_total_score());
	</script>
	<div style="width:80%;margin:0 auto;height:auto;text-align:center;color:<?php print($result_color);?>" id="screen_result">
	
	</div>
	<div style="width:80%;margin:0 auto;height:auto;text-align:center;margin-top:10px;font-weight:bold;color:<?php print($result_color);?>">
	<?php print($result_message);?>
	</div>
	
	<div style="width:80%;margin:0 auto;height:auto;text-align:center;display:none;" id="result_status">
	
	</div>
	
	
	
	<div style="width:80%;margin:0 auto;height:auto;margin-top:10px;">
	<?php
	include $this_questionnaire_results['finish_script'];
	
	?>
	</div>
	<?php
}
?>
</div>

<script>
if($('#direct_access').val() == undefined){
	$('#screening_restart_button').attr('onclick',"var c = confirm('Are you sure you wish to restart this session?');if(c){fetch_client_details(0);}");
	
}
</script>