<div style="width:100%;height:25px;line-height:20px;float:left;"><div style="width:90px;cursor:pointer;height:20px;line-height:20px;float:left;text-align:center;border:solid 1px #eee;margin-top:1px;background-color:#ddf;" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';" title="Export to Excel" onclick="export_survey_report()" id="client_export_button">Export</div></div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:100px;float:left;height:20px;">Date</div>
<div style="width:250px;float:left;height:20px;margin-left:2px;">Survey</div>
<div style="width:310px;float:left;height:20px;margin-left:2px;">User</div>
<div style="width:140px;float:left;height:20px;"></div>
<div style="width:140px;float:left;height:20px;"></div>
<div style="width:140px;float:left;height:20px;"></div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}



$survey_responses = mysqli_query($connect,"select * from prep_questionnaire_data_sets where company_id = $company_id and module_id = 5 $branch_search order by _date desc")or die(mysqli_error($connect));

if(!mysqli_num_rows($survey_responses)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	$survey_array = fetch_db_table('connect','prep_questionnaires',1,'id','(module_id = 5)');
	$user_array = fetch_db_table('connect','users',1,'id','');
	for($s=0;$s<mysqli_num_rows($survey_responses);$s++){
		$survey_response_results = mysqli_fetch_array($survey_responses,MYSQLI_ASSOC);
		
		$survey_index = array_keys($survey_array['id'],$survey_response_results['questionnaire_id']);
		
		$survey_title = 'Survey not found';
		if(isset($survey_index[0])){
			$survey_title = $survey_array['title'][$survey_index[0]];
			
		}
		
		$user_index = array_keys($user_array['id'],$survey_response_results['user_id']);
		
		$user_title = 'User not found';
		if(isset($user_index[0])){
			$user_title = $user_array['_name'][$user_index[0]];
		}
		?>
		
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" onclick="start_analytical_survey(<?php print($survey_response_results['questionnaire_id'].','.$survey_response_results['id']);?>);">
<div style="width:100px;float:left;height:20px;"><?php print(date('jS M, Y',$survey_response_results['_date']));?></div>
<div style="width:250px;float:left;height:20px;margin-left:2px;"><?php print($survey_title);?></div>
<div style="width:310px;float:left;height:20px;margin-left:2px;"><?php print($user_title);?></div>
<div style="width:140px;float:left;height:20px;"></div>
<div style="width:140px;float:left;height:20px;"></div>
<div style="width:140px;float:left;height:20px;"></div>
</div>
		
		<?php
	}
}
?>