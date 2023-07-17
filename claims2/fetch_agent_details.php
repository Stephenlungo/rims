<?php
$column_names = array('Name','Job title','NRC','Cluster','Region','Province','Hub','Site');
$formating = array(0,0,0,0,0,0,0,0);
include 'scripts/connector.php';
$row_array = array();

$agent_array = fetch_db_table('connect','agents',1,'id','');

$region_array = fetch_db_table('connect','regions',1,'id','');
$province_array = fetch_db_table('connect','provinces',1,'id','');
$hub_array = fetch_db_table('connect','hubs',1,'id','');
$site_array = fetch_db_table('connect','sites',1,'id','');

$branch_array = fetch_db_table('connect','branches',1,'id','');

for($a=0;$a<count($agent_array['id']);$a++){
	
	$region_index = array_keys($region_array['id'],$agent_array['region_id'][$a]);
	
	$region_title = 'Unspecified';
	if(isset($region_index[0])){
		$region_title = $region_array['title'][$region_index[0]];
		
	}
	
	$province_index = array_keys($province_array['id'],$agent_array['province_id'][$a]);
	$province_title = 'Unspecified';
	if(isset($province_index[0])){
		$province_title = $province_array['title'][$province_index[0]];
		
	}
	
	$hub_index = array_keys($hub_array['id'],$agent_array['hub_id'][$a]);
	$hub_title = 'Unspecified';
	if(isset($hub_index[0])){
		$hub_title = $hub_array['title'][$hub_index[0]];
		
	}
	
	$site_index = array_keys($site_array['id'],$agent_array['site_id'][$a]);
	$site_title = 'Unspecified';
	if(isset($site_index[0])){
		$site_title = $site_array['title'][$site_index[0]];
		
	}
	
	$branch_title = 'Unspecified';
	$branch_index = array_keys($branch_array['id'],$agent_array['branch_id'][$a]);
	if(isset($branch_index[0])){
		$branch_title = $branch_array['title'][$branch_index[0]];
		
	}
	
	//$column_names = array('Name','Job title','NRC','Region','Province','Hub','Site');
	
	$row_array[count($row_array)] = array($agent_array['_name'][$a],$agent_array['responsibility'][$a],$agent_array['id_number'][$a],$branch_title,$region_title,$province_title,$hub_title,$site_title);
				
}
$file_name = new_excel_export($column_names,$row_array,$formating);
header('location: '.$url.'/'.$file_name);
?>