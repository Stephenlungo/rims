<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;width:80px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="$('#filter_options').slideUp('fast');fetch_covid_client_details(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New Client</div> </div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
	<div style="width:100px;height:20px;float:left;margin-right:3px;">Date</div>
	<div style="width:130px;height:20px;float:left;margin-right:3px;">Client ID</div>
	<div style="width:150px;height:20px;float:left;margin-right:3px;">Phone</div>
	<div style="width:50px;height:20px;float:left;margin-right:3px;">Gender</div>
	<div style="width:40px;height:20px;float:left;margin-right:3px;">Age</div>
	<div style="width:150px;height:20px;float:left;margin-right:3px;">Province</div>
	<div style="width:120px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:130px;height:20px;float:left;margin-right:3px;">Facility</div><div style="width:70px;height:20px;float:left;margin-right:3px;">Risk level</div>
</div>

<?php
$covid_clients = mysqli_query($connect,"select * from covid_clients where company_id = $company_id and case_classification_id = $tab_id order by _date desc")or die(mysqli_error($connect));

$provinces = new_fetch_db_table('connect','provinces',1,'id','');
$regions = new_fetch_db_table('connect','regions',1,'id','');
$hubs = new_fetch_db_table('connect','hubs',1,'id','');
$sites = new_fetch_db_table('connect','sites',1,'id','');

if($tab_id){
	$color = '#000';
	
}else{
	$color = '#aaa';
	
}

for($c=0;$c<mysqli_num_rows($covid_clients);$c++){
	$covid_client_results = mysqli_fetch_array($covid_clients,MYSQLI_ASSOC);
	
	if($covid_client_results['client_id'] == 0){
		$client_id = 'Not set';
		
	}else{
		$client_id = $covid_client_results['client_id'];
		
	}
	
	if($covid_client_results['sex'] == 1){
		$gender = 'Male';
		
	}else if($covid_client_results['sex'] == 2){
		$gender = 'Female';
		
	}else{
		$gender = 'Not set';
		
	}
	
	$region_title = 'Unknown';
	$region_index = array_keys($regions[1]['id'],$covid_client_results['region_id']);	
	if(isset($region_index[0])){
		$region_title = $regions[1]['title'][$region_index[0]];
		
	}
	
	$province_title = 'Unknown';
	$province_index = array_keys($provinces[1]['id'],$covid_client_results['province_id']);	
	if(isset($province_index[0])){
		$province_title = $provinces[1]['title'][$province_index[0]];
		
	}
	
	
	$hub_title = 'Unknown';
	$hub_index = array_keys($provinces[1]['id'],$covid_client_results['hub_id']);	
	if(isset($hub_index[0])){
		$hub_title = $hubs[1]['title'][$hub_index[0]];
		
	}
	
	$site_title = 'Unknown';
	$site_index = array_keys($provinces[1]['id'],$covid_client_results['site_id']);
	$site_index = array_keys($sites[1]['id'],$covid_client_results['site_id']);	
	if(isset($site_index[0])){
		$site_title = $sites[1]['title'][$site_index[0]];
		
	}
	
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($color);?>;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_covid_client_details(<?php print($covid_client_results['id']);?>)">
		<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$covid_client_results['_date']));?></div>
		<div style="width:130px;height:20px;float:left;margin-right:3px;"><?php print($client_id);?></div>
		<div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($covid_client_results['phone']);?></div>
		<div style="width:50px;height:20px;float:left;margin-right:3px;"><?php print($gender);?></div>
		<div style="width:40px;height:20px;float:left;margin-right:3px;"><?php print($covid_client_results['age']);?></div>
		<div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($province_title);?></div>
		<div style="width:120px;height:20px;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:130px;height:20px;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;"><?php print($covid_client_results['risk_level']);?></div>
	</div>
	
	<?php
}
?>