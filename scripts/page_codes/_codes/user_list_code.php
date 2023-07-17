
<?php 
$users = mysqli_query($connect,"select * from users where company_id = $company_id $search_string order by _name ")or die(mysqli_error($connect));

for($u=0;$u<mysqli_num_rows($users);$u++){
	$this_users_results = mysqli_fetch_array($users,MYSQLI_ASSOC);
	
	if($this_users_results['region_id'] == 0){
		$region_title = '<i>All regions</i>';
		$location = $region_title;
		$location_hint = '';
		
	}else{
		$region_id = $this_users_results['region_id'];
		$region = mysqli_query($connect,"select * from regions where id = $region_id")or die(mysqli_error($connect));
		$region_results = mysqli_fetch_array($region,MYSQLI_ASSOC);
		
		$region_title = $region_results['title'];
		
		$location = $region_title;
		$location_hint = '('.$region_title.' - All provinces)';
	}
	
	if($this_users_results['province_id'] == 0){
		$province_title = '<i>All provinces</i>';
		
	}else{
		$province_id = $this_users_results['province_id'];
		$province = mysqli_query($connect,"select * from provinces where id = $province_id")or die(mysqli_error($connect));
		$province_results = mysqli_fetch_array($province,MYSQLI_ASSOC);
		
		$province_title = $province_results['title'];
		
		$location = $province_title;
		$location_hint = '('.$region_title.' - '.$province_title.' - All hubs)';
	}
	
	if($this_users_results['hub_id'] == 0){
		$hub_title = '<i>All hubs</i>';
		
	}else{
		$hub_id = $this_users_results['hub_id'];
		$hub = mysqli_query($connect,"select * from hubs where id = $hub_id")or die(mysqli_error($connect));
		$hub_results = mysqli_fetch_array($hub,MYSQLI_ASSOC);
		
		$hub_title = $hub_results['title'];
		
		$location = $hub_title;
		$location_hint = '('.$region_title.' - '.$province_title.' - '.$hub_title.' - All sites)';
	}
	
	if($this_users_results['site_id'] == 0){
		$site_title = '<i>All sites</i>';
		
	}else{
		$site_id = $this_users_results['site_id'];
		$site = mysqli_query($connect,"select * from sites where id = $site_id")or die(mysqli_error($connect));
		$site_results = mysqli_fetch_array($site,MYSQLI_ASSOC);
		
		$site_title = $site_results['title'];
		$location = $site_title;
		$location_hint = '('.$province_title.' - '.$hub_title.')';
	}
	
	if($this_users_results['id'] == $_COOKIE['user_id']){
		$background_color = '#fee';
		$mouseover_color = '#fbb';
		$mouseout_color = '#fee';
		
	}else{
		$background_color = '';
		$mouseover_color = '#eee';
		$mouseout_color = '';
	}
	
	if(!$this_users_results['status']){
		$user_text_color = '#999';
		
	}else{
		$user_text_color = '#000';
		
	}
	
	if($this_users_results['branch_id'] == 0){
		$branch_title = '<i>Non-clustered</i>';
		
	}else{
		$branch_id = $this_users_results['branch_id'];
		$user_branch = mysqli_query($connect,"select * from branches where id = '$branch_id' order by title")or die(mysqli_error($connect));
		$user_branch_results = mysqli_fetch_array($user_branch,MYSQLI_ASSOC);
		$branch_title = $user_branch_results['title'];
		
	}
	
	$entry_display = '';  
	if($user_group_id != 0){
		if(!check_item_in_list($user_group_id,$this_users_results['user_group_ids'],0,",")){
			$entry_display = 'display:none;';
			
		}
	}

	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;<?php print($entry_display);?>background-color:<?php print($background_color.';color:'.$user_text_color);?>" onmouseover="this.style.backgroundColor='<?php print($mouseover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($mouseout_color);?>';" title="Click to edit or view details" onclick="fetch_user_details(<?php print($this_users_results['id']);?>);$('#user_filter_options').slideUp('fast');" id="user_<?php print($this_users_results['id']);?>">
		<div style="width:30px;float:left;min-height:20px;height:auto;"><?php print($this_users_results['id']);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;"><?php print($this_users_results['_name']);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;text-align:left;"><?php print($this_users_results['phone']);?></div>
		<div style="width:180px;float:left;height:20px;text-align:left;"><?php print($this_users_results['email']);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;text-align:left;"><?php print($branch_title);?></div>
		<div style="width:170px;float:left;min-height:20px;height:auto;margin-left:5px;" title="<?php print($location_hint);?>"><?php print($location);?></div>
	</div>
	<?php
}
?>