<?php
$this_questionnaire = mysqli_query($connect,"select * from prep_questionnaires where id = $questionnaire_id")or die(mysqli_error($connect));
$this_questionnaire_results = mysqli_fetch_array($this_questionnaire,MYSQLI_ASSOC);


?>
<div style="width:100%;height:30px;line-height:30px;float:left;background-color:#dfd;font-weight:bold;text-align:center;" id="this_client_questionnaire_title"><?php print($this_questionnaire_results['title']);?></div>

<div style="width:100%;height:25px;float:left;margin-top:2px;"><div style="width:50px;margin-right:5px;height:20px;float:left;background-color:#aaa;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa'" onclick="fetch_client_details(<?php print($client_id);?>,0)">Close</div><div style="width:50px;height:20px;float:left;background-color:orange;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#ffc863';" onmouseout="this.style.backgroundColor='orange'" onclick="questionnaire_next(<?php print($questionnaire_id);?>,0,0,0,1,'','');">Redo</div></div>

<?php$this_default_partition_name = $default_partition_names[5][1][2];$partitions = fetch_database_partitions(5,$client_date,$client_date);$prep_questionnaire_data_sets_table = $this_default_partition_name.'_partition_'.$partitions[0];$this_default_partition_name = $default_partition_names[6][1][1];$partitions = fetch_database_partitions(6,$client_date,$client_date);$prep_client_answers_table = $this_default_partition_name.'_partition_'.$partitions[0];
$data_sets = mysqli_query($connect,"select * from $prep_questionnaire_data_sets_table where company_id = $company_id and questionnaire_id = $questionnaire_id and client_id = $client_id order by _date desc")or die(mysqli_error($connect));

for($ds=0;$ds<mysqli_num_rows($data_sets);$ds++){
	$data_set_results = mysqli_fetch_array($data_sets,MYSQLI_ASSOC);
	
	if($data_set_results['user_id'] == ''){
		$this_user_name = 'Self assessed';
		
	}else{
		$data_user_id = $data_set_results['user_id'];
		$this_user = mysqli_query($connect,"select * from users where id = '$data_user_id' and company_id = $company_id")or die(mysqli_error($connect));
		$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
		
		$this_user_name = $this_user_results['_name'];
	}
	?>
	
	<div style="width:99.2%;height:25px;line-height:25px;float:left;padding-left:5px;cursor:pointer;margin-top:2px;background-color:#fde7fe" onmouseover="this.style.backgroundColor='#fef0fe';" onmouseout="this.style.backgroundColor='#fde7fe'" onclick="$('#questionnaire_data_set_results_<?php print($data_set_results['id']);?>').slideToggle('fast');" id="questionnaire_data_set_title_<?php print($data_set_results['id']);?>">Submitted on <?php print(date('jS M, Y',$data_set_results['_date']).' - '.date('H:i:s',$data_set_results['_date']).'. User: '.$this_user_name);?></div>
	
<div style="width:100%;height:auto;float:left;display:none;background-color:#fffaff" id="questionnaire_data_set_results_<?php print($data_set_results['id']);?>">

<div style="width:100%;height:auto;line-height:15px;float:left;border-bottom:solid 1px #eee;padding-bottom:5px;margin-bottom:10px;margin-top:5px;"><div style="width:100%;float:left;margin-right:5px;height:20px;line-height:20px;" id="client_score"><div style="width:auto;float:left;">Total Score: <?php print($data_set_results['score']);?>, Eligibility score: <?php print($this_questionnaire_results['passing_score']);?></div><div style="width:70px;height:20px;float:right;background-color:brown;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#c14545';" onmouseout="this.style.backgroundColor='brown';" onclick="delete_prep_data_set(<?php print($data_set_results['id'].','.$client_id);?>);" id="prep_dadta_set_delete_button_<?php print($data_set_results['id']);?>">Delete</div></div>

<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:4px;" id="assessment_comment"><?php
if($data_set_results['score'] >= $this_questionnaire_results['passing_score']){
print('<font color="brown">'.$this_questionnaire_results['passing_message'].'</font>');}else{print('<font color="brown">'.$this_questionnaire_results['failing_message'].'</font>');}?></div>
</div>

<?php
$questionnaire_sessions = mysqli_query($connect,"select * from prep_questionnaire_sessions where questionnaire_id = $questionnaire_id")or die(mysqli_error($connect));

$this_score = 0;
for($s=0;$s<mysqli_num_rows($questionnaire_sessions);$s++){
	$questionnaire_sessions_results = mysqli_fetch_array($questionnaire_sessions,MYSQLI_ASSOC);
	if($s==0){
		$session_margin = '0px';		
	}else{
		$session_margin = '30px';	
	}
	?>
	<div style="width:100%;height:20px;line-height:20px;color:#9e35a7;float:left;font-weight:bold;margin-top:<?php print($session_margin);?>;"><?php print($questionnaire_sessions_results['title']);?></div>
	<?php
	$session_id = $questionnaire_sessions_results['id'];
	$these_questions = mysqli_query($connect,"select * from prep_questions where questionnaire_id = $questionnaire_id and session_id = $session_id")or die(mysqli_error($connect));
	for($q=0;$q<mysqli_num_rows($these_questions);$q++){
		$these_question_results = mysqli_fetch_array($these_questions,MYSQLI_ASSOC);
		
		if($q==0){
			$question_margin = '0px';
			
		}else{
			$question_margin = '20px';
			
		}
		
		$question_id = $these_question_results['id'];
		
		$client_answers = mysqli_query($connect,"select * from $prep_client_answers_table where questionnaire_id = $questionnaire_id and client_id = $client_id and question_id = $question_id and session_id = $session_id")or die(mysqli_error($connect));
		
		$client_answer_results = mysqli_fetch_array($client_answers,MYSQLI_ASSOC);
		
		$this_answer = $client_answer_results['answer'];
		$this_score += $client_answer_results['score'];
		
		?>
		<div style="width:90%;margin-left:10px;height:25px;line-height:25px;float:left;margin-top:<?php print($question_margin);?>"><?php print(($q+1).'. '.$these_question_results['title']);?></div>
		
		<?php
		
		$these_options = mysqli_query($connect,"select * from prep_question_options where questionnaire_id = $questionnaire_id and session_id = $session_id and question_id = $question_id")or die(mysqli_error($connect));
		
		for($o=0;$o<mysqli_num_rows($these_options);$o++){
			$these_option_results = mysqli_fetch_array($these_options,MYSQLI_ASSOC);
			
			if($this_answer == $these_option_results['id']){
				$answer_code = '&#10003';
				
			}else{
				$answer_code = '';
			}
			?>
			<div style="width:80%;margin-left:30px;height:20px;float:left;line-height:20px;"><?php print($these_option_results['title'].' ('.$these_option_results['score'].') '.$answer_code);?></div>
			
			<?php
		}
	}	
}
?>
</div>
	<?php
}
?>