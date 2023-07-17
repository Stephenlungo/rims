<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="export_dynamic_report();" id="dynamic_report_export_button">Export</div></div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:90px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:60px;height:20px;float:left;margin-right:3px;">Time</div>
<div style="width:90px;height:20px;float:left;margin-right:3px;">Phone</div>
<div style="width:70px;height:20px;float:left;margin-right:3px;">Code</div>
<div style="width:200px;height:20px;float:left;margin-right:3px;">Menu title</div>
<div style="width:140px;height:20px;float:left;margin-right:3px;">Name</div>
<div style="width:280px;height:20px;float:left;margin-right:3px;">Location</div>

</div>

<?php

$ussd_log = mysqli_query($connect,"select * from ussd_activity_log where $filter_string order by _date asc")or die(mysqli_error($connect));

			
	$column_string = 'Date|]Time|]Phone|]Code|]Menu title|]Name|]Location';
	$column_formating_string = '0|]0|]0|]0|]0|]0|]0';
	$row_string = '';
	
if(!mysqli_num_rows($ussd_log)){
	?>
	<div style="width:100%;height:20px;line-height:20px;color:#f00;text-align:center;float:left;font-weight:bold;">No records were found</div>
	
	<?php
	
}else{
	$region_array = fetch_db_table('connect','regions',1,'title','');
	$province_array = fetch_db_table('connect','provinces',1,'title','');
	$hub_array = fetch_db_table('connect','hubs',1,'title','');
	$mother_facility_array = fetch_db_table('connect','mother_facilities',1,'title','');
	$site_array = fetch_db_table('connect','sites',1,'title','');
	$agent_array = fetch_db_table('connect','agents',1,'_name','');
	$ussd_array = fetch_db_table('connect','ussd_menu',0,'id','');
	for($u=0;$u<mysqli_num_rows($ussd_log);$u++){
		$ussd_log_results = mysqli_fetch_array($ussd_log,MYSQLI_ASSOC);
		
		if(!$ussd_log_results['ussd_code'] || $ussd_log_results['ussd_code'] == 573){
			$session_start[$ussd_log_results['c_id']] = 1;
			$ussd_index[$ussd_log_results['c_id']] = 0;
			$parent_ussd_id[$ussd_log_results['c_id']] = 0;
			$menu_title = '<font style="color:#006bb3;">HOME MENU</font>';
			$export_menu_title = 'HOME MENU';
		}else{
			$session_start[$ussd_log_results['c_id']] = 0;
			$ussd_index[$ussd_log_results['c_id']] = $ussd_index[$ussd_log_results['c_id']]+1;
			$menu_title = '<i style="color:#f00;">Custom command</i>';
			
			$export_menu_title = 'Custom command';
		}
		
		if($ussd_log_results['ussd_code'] == 'b' || $ussd_log_results['ussd_code'] == 'B'){
			$menu_title = '<font style="color:#006bb3;">"Back" command</font>';
			$export_menu_title = 'Back command';
		}else{		
			$this_menu_items_index = array_keys($ussd_array['parent_id'],$parent_ussd_id[$ussd_log_results['c_id']]);
			
			for($mi=0;$mi<count($this_menu_items_index);$mi++){
				if($ussd_array['ussd_id'][$this_menu_items_index[$mi]] == $ussd_log_results['ussd_code']){
					
					$menu_title = $ussd_array['title'][$this_menu_items_index[$mi]];
					$export_menu_title = $menu_title;
					$parent_ussd_id[$ussd_log_results['c_id']] = $ussd_array['id'][$this_menu_items_index[$mi]];
				}
			}
		}
		
		
		$region_index = array_keys($region_array['id'],$ussd_log_results['region_id']);
		if(isset($region_index[0])){
			$region_title = $region_array['title'][$region_index[0]];
			
		}else{
			$region_title = '<i>Unknown</i>';
			
		}
		
		$province_index = array_keys($province_array['id'],$ussd_log_results['province_id']);
		if(isset($province_index[0])){
			$province_title = $province_array['title'][$province_index[0]];
			
		}else{
			$province_title = '<i>Unknown</i>';
			
		}
		
		$hub_index = array_keys($hub_array['id'],$ussd_log_results['hub_id']);
		if(isset($hub_index[0])){
			$hub_title = $hub_array['title'][$hub_index[0]];
			
		}else{
			$hub_title = '<i>Unknown</i>';
			
		}
		
		$site_index = array_keys($site_array['id'],$ussd_log_results['site_id']);
		if(isset($site_index[0])){
			$site_title = $site_array['title'][$site_index[0]];
			
		}else{
			$site_title = '<i>Unknown</i>';
			
		}
		
		$agent_index = array_keys($agent_array['id'],$ussd_log_results['agent_id']);
		if(isset($agent_index[0])){
			$agent_title = $agent_array['_name'][$agent_index[0]];
			$export_agent_title = $agent_title;
		}else{
			$agent_title = '<i>Unknown</i>';
			$export_agent_title = 'Unknown';
			
		}
		
		if(!$ussd_log_results['region_id']){
			$location_title = '<i>Unknown</i>';
			$export_location_title = 'Unknown';
			//print('hi');
			
		}else if(!$ussd_log_results['province_id']){
			$location_title = $region_title. ' region';
			
		}else if(!$ussd_log_results['hub_id']){
			$location_title = $region_title.' - '.$province_title.' province';
			
		}else if(!$ussd_log_results['site_id']){
			$location_title = $region_title.' - '.$province_title.' - '.$hub_title.' hub';
			
		}else{
			$location_title = $region_title.' - '.$province_title.' - '.$hub_title.' - '.$site_title.' site';
			
		}
		
		if($ussd_log_results['region_id']){
			$export_location_title = $location_title;
			
		}
		
		?>
		
		<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:90px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$ussd_log_results['_date']));?></div>
		<div style="width:60px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print(date('H:i:s',$ussd_log_results['_date']));?></div>
		<div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_log_results['c_id']);?></div>
		<div style="width:70px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_log_results['ussd_code']);?></div><div style="width:200px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($menu_title);?></div>
		<div style="width:140px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_title);?></div>
		<div style="width:280px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($location_title);?></div>
		

		</div>
		
		<?php
		if($row_string == ''){
			$row_string = date('jS M, Y',$ussd_log_results['_date']).'|]'.date('H:i:s',$ussd_log_results['_date']).'|]'.$ussd_log_results['c_id'].'|]'.$ussd_log_results['ussd_code'].'|]'.$export_menu_title.'|]'.$export_agent_title.'|]'.$export_location_title;
			
		}else{
			$row_string .= '|}'.date('jS M, Y',$ussd_log_results['_date']).'|]'.date('H:i:s',$ussd_log_results['_date']).'|]'.$ussd_log_results['c_id'].'|]'.$ussd_log_results['ussd_code'].'|]'.$export_menu_title.'|]'.$export_agent_title.'|]'.$export_location_title;
		}
	}
	
	//$row_string = str_replace('"',"'",$row_string);
}
?>

<input type="hidden" id="total_rows" value="<?php print(mysqli_num_rows($ussd_log));?>">
<input type="hidden" id="column_string" value="<?php print($column_string);?>">
<input type="hidden" id="row_string" value="<?php print($row_string);?>">
<input type="hidden" id="column_formating_string" value="<?php print($column_formating_string);?>">