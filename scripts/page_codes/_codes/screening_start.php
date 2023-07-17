<div style="width:100%;height:30px;line-height:30px;float:left;display:none;" id="questionnaire_title_holder"></div>
<input type="hidden" id="tmp_client_id" value="<?php print(time());?>">
<input type="hidden" id="client_id" value="<?php print($client_id);?>">
<input type="hidden" id="client_scores" value="">
<input type="hidden" id="total_score" value="0">
<input type="hidden" id="client_screening_validated" value="0">

<input type="hidden" id="screening_client_phone" value="">
<input type="hidden" id="screening_client_name" value="">
<input type="hidden" id="site_id" value="0">
<input type="hidden" id="hub_id" value="0">
<input type="hidden" id="province_id" value="0">
<input type="hidden" id="region_id" value="0"><input type="hidden" id="client_profile_updated" value="0">

<div style="width:100%;height:auto;float:left;" id="screen_data_holder">

<div style="width:50%;height:50%;margin:0 auto;margin-top:30px;border:solid 2px #888;">
<img src="<?php print($prep_url);?>/imgs/prep_welcome.jpg" style="width:100%;height:100%;">
</div>
<div style="width:100%;height:auto;float:left;margin-top:30px;text-align:center;">Please select a questionnaire below:<br></div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
<?php
$questionnaires = mysqli_query($connect,"select * from prep_questionnaires where module_id = $module_id and status = 1 order by title")or die(mysqli_error($prep_connect));

?>
<div style="width:<?php print(mysqli_num_rows($questionnaires) * 206);?>px;height:auto;margin:0 auto;">
<?php
$screenings_complete = 1;
for($q=0;$q<mysqli_num_rows($questionnaires);$q++){
	$questionnaire_results = mysqli_fetch_array($questionnaires,MYSQLI_ASSOC);
	
	
	$bg_color = '#d6b054';
	$hover_color = '#e3c57b';
	$questionnaire_id = $questionnaire_results['id'];
	if($client_id){
		
		$this_default_partition_name = $default_partition_names[6][1][1];
		$partitions = fetch_database_partitions(6,$today_start,$now);
		$prep_clients_answers_table = $this_default_partition_name.'_partition_'.$partitions[0];
		
		$check_client_answers = mysqli_query($connect,"select * from $prep_clients_answers_table where client_id = $client_id and questionnaire_id = $questionnaire_id")or die(mysqli_error($connect));
		
		if(mysqli_num_rows($check_client_answers)){
			$questionnaire_title = $questionnaire_results['title'].' (Done)';
			$bg_color = '#98cb97';
			$hover_color = '#b3d8b2';
			
			$function_code = 'fetch_screening_results('.$questionnaire_id.','.$client_id.','.$client_date.')';
			
		}else{
			$questionnaire_title = $questionnaire_results['title'];
			
			if($questionnaire_results['client_identity']){
				$function_code = "fetch_questionnaire_client_identity(".$questionnaire_id.")";
				
			}else{
				$function_code = "questionnaire_next(".$questionnaire_id.",0,0,0,1,'','')";
			
			}
			
			if($questionnaire_results['necessity']){
				$screenings_complete = 0;
			}
		}
		
	}else{
		$screenings_complete = 0;
		$questionnaire_title = $questionnaire_results['title'];
		
		if($questionnaire_results['client_identity']){
		$function_code = "fetch_questionnaire_client_identity(".$questionnaire_id.")";
		
		}else{
			$function_code = "questionnaire_next(".$questionnaire_id.",0,0,0,1,'','')";
		}
	}
	?>
	<div style="cursor:pointer;width:180px;min-height:40px;height:auto;float:left;background-color:<?php print($bg_color);?>;margin:5px;text-align:center;color:#fff;" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>'" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>'">

	<?php
	if($questionnaire_results['welcome_image']!= ''){?>
		<div style="width:100%;min-height:40px;height:auto;margin:5px;float:left;" onclick="<?php print($function_code);?>"><div style="width:20%;height:40px;float:left;"><img src="<?php print($prep_url);?>/imgs/<?php print($questionnaire_results['welcome_image']);?>" style="width:100%;height:100%;"></div><div style="width:70%;height:auto;float:left;margin-left:5px;" ><?php print($questionnaire_title);?></div></div>
	<?php
	}else{
		?>
		<div style="width:100%;min-height:40px;height:auto;margin:5px;float:left;text-align:center;" onclick="<?php print($function_code);?>"><div style="width:auto%;height:auto;float:left;"><?php print($questionnaire_title);?></div></div>
	<?php
	}
	?>
	</div>

	<?php
}
?>
</div>
</div>
</div>

<?php
if($screenings_complete){
	?>
	<script>
		$('#client_screening_validated').val(1);
	
	</script>
	<?php
}
?>