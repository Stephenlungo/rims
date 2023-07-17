<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">

<div style="width:auto;height:auto;float:left;">

		<div style="width:90px;height:30px;line-height:30px;float:left;">Quick report:</div>

		<div style="width:auto;min-height:30px;height:auto;float:left;"  >

		<div class="option_item" title="Click to change option" onclick="$('#quick_report_menu').toggle('fast');" id="client_export_button" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';"  style="min-width:110px;max-width:270px;width:auto;background-color:#bbf;color:#fff;">Select report</div>



		<div class="option_menu" id="quick_report_menu" style="display:none;width:auto;width:290px;">

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(0);$('#screening_rule_string').val('');$('#profile_rule_string').val('');$('#form_rule_string').val('');$('#screening_question_level_rule_string').val('');$('#form_category_level_rule_string').val('');create_new_prep_report(0);">Create new</div>

		
			<?php

			

			if(!$user_results['region_id']){

				$report_filter = '';

				

			}else if(!$user_results['province_id']){

				$report_filter = ' and (region_id = '.$user_results['region_id'].' or region_id = 0)';

				

			}else if(!$user_results['hub_id']){

				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' or region_id = 0 or province_id = 0)';

				

			}else if(!$user_results['site_id']){

				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' and hub_id = '.$user_results['hub_id'].' or (region_id = 0) or (province_id = 0) or (hub_id = 0))';

				

			}else{

				$report_filter = ' and (region_id = '.$user_results['region_id'].' and province_id = '.$user_results['province_id'].' and hub_id = '.$user_results['hub_id'].' or site_id = 0)';

				

			}

			

			$prep_reports = mysqli_query($connect,"select * from dynamic_reports where company_id = $company_id and module_id = 6 and primary_column_type = 0 and dashboard_id = 0 and (accessibility_type = 0 or accessibility_type = $user_id) $report_filter");

			

			for($r=0;$r<mysqli_num_rows($prep_reports);$r++){

				$prep_report_results = mysqli_fetch_array($prep_reports,MYSQLI_ASSOC);

				$rule_string_array = explode(',',$prep_report_results['rule_string']);

				

				?>

				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#quick_report_menu').toggle('fast');$('#selected_quick_report').val(<?php print($prep_report_results['id']);?>);$('#screening_question_level_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[0]));?>');$('#form_category_level_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[1]));?>');$('#screening_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[2]));?>');$('#profile_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[3]));?>');$('#form_rule_string').val('<?php print(str_replace('|',',',$rule_string_array[4]));?>');create_new_prep_report(<?php print($prep_report_results['id']);?>);" id="quick_report_item_<?php print($prep_report_results['id']);?>"><?php print($prep_report_results['title']);?></div>

				<?php

			}

			?>

		</div>

		</div>

		<input type="hidden" id="selected_quick_report" value="0">

		

		<input type="hidden" id="form_rule_string" value="">

		<input type="hidden" id="form_category_level_rule_string" value="">

		

		<input type="hidden" id="screening_rule_string" value="">

		<input type="hidden" id="screening_question_level_rule_string" value="">

		

		<input type="hidden" id="profile_rule_string" value="">

	</div>


















<div class="general_button" style="float:right;width:80px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="$('#filter_options').slideUp('fast');fetch_covid_client_details(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New Client</div> </div>

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