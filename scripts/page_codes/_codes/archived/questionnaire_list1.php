<?php

include 'item_details.php';

if($a){
	$bg_color = '#ddf';
	
}else if($a == 0){
	$bg_color = '#fdd';
	
}else{
	$bg_color = '#dfd';
}

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">

<?php
if($a){?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_questionnaire(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php 
}
?>

</div>
<input type="hidden" value="3" id ="module_id">
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:50px;float:left;height:20px;">ID</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:310px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:140px;float:left;height:20px;">Question groups</div>
<div style="width:140px;float:left;height:20px;">Questions</div>
<div style="width:140px;float:left;height:20px;">Clients</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}


$questionnaires = mysqli_query($connect,"select * from prep_questionnaires where company_id = $company_id and module_id = 3 $branch_search order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($questionnaires)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($q=0;$q<mysqli_num_rows($questionnaires);$q++){
		$questionnaires_results = mysqli_fetch_array($questionnaires,MYSQLI_ASSOC);
		
		$questionnaire_id = $questionnaires_results['id'];
		
		$groups = mysqli_query($connect,"select * from prep_questionnaire_sessions where questionnaire_id = $questionnaire_id")or die(mysqli_error($connect));
		
		$questions = mysqli_query($connect,"select * from prep_questions where questionnaire_id = $questionnaire_id")or die(mysqli_error($connect));
		
		$client_answers = mysqli_query($connect,"select * from prep_client_answers where questionnaire_id = $questionnaire_id")or die(mysqlI_error($connect));
		
		if(!$questionnaires_results['branch_id']){
			$branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$indicator_group_branch_id = $questionnaires_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $indicator_group_branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$branch_title = $branch_results['title'];
		
		}
		
		?>

		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" id="item_<?php print($questionnaires_results['id']);?>" onclick="fetch_questionnaire(<?php print($questionnaires_results['id']);?>);">
		<div style="width:50px;float:left;height:20px;margin-left:2px;" ><?php print($questionnaires_results['id']);?></div>
		<div style="width:180px;float:left;height:20px;margin-left:2px;" ><?php print($branch_title);?></div>
		<div style="width:310px;float:left;height:20px;" ><?php print($questionnaires_results['title']);?></div>
		<div style="width:140px;float:left;height:20px;margin-left:2px;"><?php print(mysqli_num_rows($groups));?></div>
		<div style="width:140px;float:left;height:20px;"><?php print(mysqli_num_rows($questions));?></div>
		<div style="width:140px;float:left;height:20px;"><?php print(mysqli_num_rows($client_answers));?></div>
		</div>
		
		
		<?php
	
	}
}
?>