
<?php

include 'new_question_group.php';

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
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="show_window('new_question_group',1);$('#uploaded_files').val('');" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php 
}
?>

</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:50px;float:left;height:20px;">ID</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:280px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:280px;float:left;height:20px;">Questionnaire</div>
<div style="width:40px;float:left;height:20px;">Order</div>
<div style="width:70px;float:left;height:20px;">Questions</div>
<div style="width:70px;float:left;height:20px;">Clients</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}


$question_groups = mysqli_query($prep_connect,"select * from questionnaire_stages where company_id = $company_id $branch_search order by _order")or die(mysqli_error($prep_connect));

if(!mysqli_num_rows($question_groups)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($q=0;$q<mysqli_num_rows($question_groups);$q++){
		$question_group_results = mysqli_fetch_array($question_groups,MYSQLI_ASSOC);
		$group_id = $question_group_results['id'];
		
		$questionnaire_id = $question_group_results['questionnaire_id'];
		
		$questionnaire = mysqli_query($prep_connect,"select * from questionnaires where id = $questionnaire_id")or die(mysqli_error($prep_connect));
		$questionnaires_results = mysqli_fetch_array($questionnaire,MYSQLI_ASSOC);
		
		$questions = mysqli_query($prep_connect,"select * from questions where group_id = $group_id")or die(mysqli_error($prep_connect));
		
		$client_answers = mysqli_query($prep_connect,"select * from client_answers where group_id = $group_id")or die(mysqlI_error($prep_connect));
		
		if(!$question_group_results['branch_id']){
			$branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$indicator_group_branch_id = $question_group_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $indicator_group_branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$branch_title = $branch_results['title'];
		
		}
		
		?>
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" id="item_<?php print($question_group_results['id']);?>">
		<div style="width:50px;float:left;height:20px;"><?php print($question_group_results['id']);?></div>
		<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($branch_title);?></div>
		<div style="width:280px;float:left;height:20px;margin-left:2px;"><?php print($question_group_results['title']);?></div>
		<div style="width:280px;float:left;height:20px;"><?php print($questionnaires_results['title']);?></div>
		<div style="width:70px;float:left;height:20px;"><?php print(mysqli_num_rows($questions));?></div>
		<div style="width:40px;float:left;height:20px;"><?php print($question_group_results['_order']);?></div>
		<div style="width:70px;float:left;height:20px;"><?php print(mysqli_num_rows($client_answers));?></div>
		</div>
		

		<?php
	
	}
}
?>