
<?php 
$user_groups = mysqli_query($connect,"select * from user_groups where company_id = $company_id $search_string order by title ")or die(mysqli_error($connect));

$users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));

for($u=0;$u<mysqli_num_rows($users);$u++){
	$user_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
	$user_group_array[$u] = $user_results['user_group_ids'];
	$user_name_array[$u] = $user_results['_name'];
	
}


if(!mysqli_num_rows($user_groups)){
	?>
	<div style="width:100%;height:20px;line-height:20px;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
}else{

	for($u=0;$u<mysqli_num_rows($user_groups);$u++){
		$this_user_groups_results = mysqli_fetch_array($user_groups,MYSQLI_ASSOC);
		
		if(!$this_user_groups_results['status']){
			$user_text_color = '#999';
			
		}else{
			$user_text_color = '#000';
			
		}
		
		if($this_user_groups_results['branch_id'] == 0){
			$branch_title = '<i>Non-clustered</i>';
			
		}else{
			$branch_id = $this_user_groups_results['branch_id'];
			$user_branch = mysqli_query($connect,"select * from branches where id = '$branch_id' order by title")or die(mysqli_error($connect));
			$user_branch_results = mysqli_fetch_array($user_branch,MYSQLI_ASSOC);
			$branch_title = $user_branch_results['title'];
			
		}
		
		if($this_user_groups_results['supervisor_date'] == 0){
			$supervisor_name = '<i>Unspecified</i>';
			
		}else{
			$supervisor_date = $this_user_groups_results['supervisor_date'];
			$supervisor = mysqli_query($connect,"select * from users where _date = '$supervisor_date' and company_id = $company_id")or die(mysqli_error($connect));
			$supervisor_results = mysqli_fetch_array($supervisor,MYSQLI_ASSOC);
			$supervisor_name = $supervisor_results['_name'];
			
		}
		
		$total_users = 0;
		for($u2=0;$u2<count($user_name_array);$u2++){
			if(check_item_in_list($this_user_groups_results['id'],$user_group_array[$u2],0,",")){
				$total_users++;
				
			}			
		}
		
		$background_color = '';
		$mouseover_color = '#eee';
		$mouseout_color = '';
		
		if(!$this_user_groups_results['status']){
			$user_text_color = '#999';
			
		}else{
			$user_text_color = '#000';
			
		}

		?>
		
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;background-color:<?php print($background_color.';color:'.$user_text_color);?>" onmouseover="this.style.backgroundColor='<?php print($mouseover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($mouseout_color);?>';" title="Click to edit or view details" onclick="fetch_user_group_details(<?php print($this_user_groups_results['id']);?>);$('#user_filter_options').slideUp('fast');" id="user_group_<?php print($this_user_groups_results['id']);?>">
			<div style="width:200px;float:left;height:20px;"><?php print($this_user_groups_results['title']);?></div>
			<div style="width:80px;float:left;height:20px;text-align:left;"><?php print($total_users);?></div>
			<div style="width:200px;float:left;height:20px;text-align:left;"><?php print($branch_title);?></div>
			<div style="width:180px;float:left;height:20px;text-align:left;"><?php print($supervisor_name);?></div>
			<div style="width:310px;float:left;height:20px;text-align:left;"><?php print($this_user_groups_results['details']);?></div>
		</div>
		<?php
	}
}
?>