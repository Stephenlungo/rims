<?php

/*
if($user_id != 1031){
	print('<div style="margin-top:30px;font-weight:bold;color:red;width:100%;height:30pc;line-height:30px;float:left;text-align:center;">Oops!! Sorry. We are installing a major update aimed at improving system speed. Please check again after some minutes</div>');
	exit;
}*/

$claims_found = 0;

$colors = array('#eae5cc','#ccedbb','#96d4ca','#a2b0d7','#ccafde','#eaebc6','#e5cdb8','#abaca5','#d09a9c','#4fc44a','','','','','','','','','','');
$hover_colors = array('#e4dfc8','#e2f1da','#b1e2da','#bac4de','#dfcde9','#e5e6c7','#e8d8ca','#bcbcb8','#e1bcbd','#7cce78');

$open_colors = array('#eeebdd','#d8f0cc','#b7e1da','#d8deee','#ebdef2','#edeed8','#f2e7de','#cfcfcf','#e9cecf','#95d392');
$open_hover_colors = array('#f2f0e3','#e7f5e0','#daf1ed','#e5e9f5','#f2e9f7','#f4f5e5','#f9f4f0','#cfcfcf','#f1e0e0','#afdcac');

$claims_in_view = '';

$color_index = 0;

if($claim_id_search_key_string != 'company_id = 1 and claim_id = 0' and $claim_id_search_key_string != ''){
	$claim_search = $claim_id_search_key_string.$status_string.$creation_method_filter;
	
}else{
	$claim_search = $search_string.$claim_id_search_key_string.$status_string.$creation_method_filter;
	
}

if($user_allocation != '-1'){
	
	if($user_allocation == '-2'){
		$claim_search = $claim_search.' and user_allocation != 0';
		
	}else{
		$claim_search = $claim_search.' and user_allocation = '.$user_allocation;
	}
}

if($ordering == 0){
	$ordering = 'claim_id asc';
	
}else if($ordering == 1){
	$ordering = 'claim_id desc';
	
}else if($ordering == 2){
	$ordering = 'amount asc';
	
}else if($ordering == 3){
	$ordering = 'amount desc';
	
}

$claim_number_list = '';
$legend = '';

$legend_user_ids = array();
$legent_user_qty = array();

if($ignore_dates){
	$from_date = mktime(0,0,0,01,01,2015);
	$to_date = time();
}

$this_default_partition_name = $default_partition_names[7][1][0];
$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];

$partitions = fetch_database_partitions(7,$from_date,$to_date);
$total_claims = 0;

for($p=0;$p<count($partitions);$p++){
	$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[$p];
	$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[$p];

	$payment_claims = mysqli_query($$module_connect,"select * from $payment_claims_table where company_id = $company_id  $claim_search order by $ordering")or die(mysqli_error($$module_connect));

	$beneficiary_array = fetch_db_table('claims_connect',$claim_beneficiaries_table,$company_id,'id','');
	
	$total_claims += mysqli_num_rows($payment_claims);
	
	for($c=0;$c<mysqli_num_rows($payment_claims);$c++){
		$this_claim_results = mysqli_fetch_array($payment_claims,MYSQLI_ASSOC);
		
		$beneficiary_index = array_keys($beneficiary_array['claim_date'],$this_claim_results['_date']);
		$no_beneficiaries = 0;
		if(isset($beneficiary_index[0])){
			$no_beneficiaries = count($beneficiary_index);
		}
		
		$bg_color = '';
		$hover_color = '#eee';
		$open_color = '#34b8b2';
		$hover_open_color = '#37aea8';
		
		if($this_claim_results['user_allocation'] != 0 and $allocation_colors){
			if(!isset($allocation_color[$this_claim_results['user_allocation']])){
				$allocation_color[$this_claim_results['user_allocation']] = $color_index;
				
				$this_user_index = array_keys($user_array['id'],$this_claim_results['user_allocation']);
				
				if(isset($this_user_index[0])){
					$legend .= '<div style="width:auto;float:left;margin-right:5px;"><div style="float:left;width:10px;height:15px;background-color:'.$colors[$allocation_color[$this_claim_results['user_allocation']]].';border:solid 1px #ddd;"></div><div style="width:auto;height:15px;line-height:15px;font-size:0.8em;margin-left:5px;float:left;">'.$user_array['_name'][$this_user_index[0]].'</div><div style="width:15px;height:15px;line-height:15px;float:left;font-size:0.8em;margin-left:2px;" id="legent_user_'.$this_claim_results['user_allocation'].'">0</div></div>';
					
					
				}
				
				$color_index++;				
			}
			
			$bg_color = $colors[$allocation_color[$this_claim_results['user_allocation']]];
			$hover_color = $hover_colors[$allocation_color[$this_claim_results['user_allocation']]];
			$open_color = $open_colors[$allocation_color[$this_claim_results['user_allocation']]];
			$hover_open_color = $open_hover_colors[$allocation_color[$this_claim_results['user_allocation']]];
			
			if($this_claim_results['ascensions'] == 0){
				$legend_user_index = array_keys($legend_user_ids,$this_claim_results['user_allocation']);
				
				if(isset($legend_user_index[0])){
					$legent_user_qty[$this_claim_results['user_allocation']]++;
					
				}else{
					$legend_user_ids[count($legend_user_ids)] = $this_claim_results['user_allocation'];
					$legent_user_qty[$this_claim_results['user_allocation']] = 1;
				}
			}
		}
		
		
		if($claims_in_view == ''){
			$claims_in_view = $this_claim_results['_date'];
			
			
		}else{
			$claims_in_view .= ','.$this_claim_results['_date'];
			
		}
		
		if($claim_number_list == ''){
			$claim_number_list = $this_claim_results['claim_id'];
			
		}else{
			$claim_number_list .= ', '.$this_claim_results['claim_id'];
			
		}
		
		$location_string = '';
		$this_region_title = '<i>Unknown</i>';
		$region_index = array_keys($region_array['id'],$this_claim_results['region_id']);
		if(isset($region_index[0])){
			$this_region_title = $region_array['title'][$region_index[0]];
			
			$location_string = 'Region: '.$this_region_title;
		}
		
		$this_province_title = '<i>Unspecified</i>';
		$province_index = array_keys($province_array['id'],$this_claim_results['province_id']);
		if(isset($province_index[0])){
			$this_province_title = $province_array['title'][$province_index[0]];
			
			$location_string .= ', Province: '.$this_province_title;
		}
		
		
		$this_hub_title = '<i>Unspecified</i>';
		$hub_index = array_keys($hub_array['id'],$this_claim_results['hub_id']);
		if(isset($hub_index[0])){
			$this_hub_title = $hub_array['title'][$hub_index[0]];
			
			$location_string .= ', Hub: '.$this_hub_title;
		}
		
		$this_site_title = '<i>Unspecified</i>';
		if($this_claim_results['site_id']){
			$site_index = array_keys($site_array['id'],$this_claim_results['site_id']);
			if(isset($site_index[0])){
				$this_site_title = $site_array['title'][$site_index[0]];
				
				$location_string .= ', Site: '.$this_site_title;
			}
		}
		
		if($this_claim_results['title'] != ''){
			$location_string .= ' <strong>('.$this_claim_results['title'].')</strong>';
			
		}
		
		$this_user_name = '<i>Unknown</i>';
		$this_user_phone = '<i>Unknown</i>';
		$user_index = array_keys($user_array['_date'],$this_claim_results['user_date']);
		
		if(isset($user_index[0])){
			$this_user_name = $user_array['_name'][$user_index[0]];
			$this_user_phone = $user_array['phone'][$user_index[0]];
		}
		
		
		$this_claim_types = explode(',',$this_claim_results['claim_type_date']);
		
		if(count($this_claim_types) > 1){
			$claim_type_title = '[<i>Multiple types</i>]';
			$claim_type_total_levels = '<i>Multiple</i>';
				
		}else{
			$this_claim_type_index = array_keys($claim_type_date_array,$this_claim_results['claim_type_date']);
			
			$claim_type_title = '<i>Unknown</i>';
			$claim_type_total_levels = '<i>Unknown</i>';
			if(isset($this_claim_type_index[0])){
				$claim_type_title = $claim_type_title_array[$this_claim_type_index[0]];
				$claim_type_total_levels = $claim_type_total_levels_array[$this_claim_type_index[0]];
			}
		}
		

		
		if($this_claim_results['status'] == 0){
			$text_color = '#999';
			
		}else if($this_claim_results['status'] == 3){
			$text_color = 'purple';
		
		}else if($this_claim_results['status'] == 1){
			$text_color = '#000';
			
		}else if($this_claim_results['status'] == 2){
			$text_color = '#679f67';
			
		}
			
	?>
	<div style="width:100%;height:auto;float:left;background-color:<?php print($bg_color);?>" id="claim_<?php print($this_claim_results['_date']);?>_holder">
	<div style="color:<?php print($text_color);?>;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" ><div style="width:20px;height:20px;float:left;"><input type="checkbox" onchange="if(this.checked){$('#claim_<?php print($this_claim_results['_date']);?>_selected').val(1);add_to_selection(<?php print($this_claim_results['_date']);?>,'selected_claims');}else{$('#claim_<?php print($this_claim_results['_date']);?>_selected').val(0);remove_from_selection(<?php print($this_claim_results['_date']);?>,'selected_claims');}" id="claim_check_<?php print($this_claim_results['_date']);?>"></div><div style="width:auto;height:auto;float:left;cursor:pointer;"  onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($bg_color);?>';" title="Click to expand/collapse" onclick="fetch_claim_beneficiaries(<?php print($this_claim_results['_date']);?>);" id="claim_<?php print($this_claim_results['_date']);?>"><div style="width:60px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_claim_results['claim_id']);?></div><div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$this_claim_results['claim_date']));?></div>
	<div style="width:130px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($claim_type_title);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_user_name);?></div><div style="width:120px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_user_phone);?></div><div style="width:183px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($location_string);?></div><div style="width:50px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print(($this_claim_results['level']+1).' of '.$claim_type_total_levels);?></div><div style="width:65px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print($no_beneficiaries);?></div><div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print(number_format($this_claim_results['amount'],2));?></div></div></div>
	<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_active" value="0">
	<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_original_color" value="<?php print($text_color);?>">
	<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_selected" value="0">

	<div style="width:100%;min-height:200px;height:auto;float:left;display:none;margin-bottom:10px;border-bottom:solid 3px #ddd;" id="claim_<?php print($this_claim_results['_date']);?>_beneficiaries"></div>



	<script>

	if(window.XMLHttpRequest){
		claim_xmlhttp_<?php print($this_claim_results['_date']);?> = new XMLHttpRequest();

	}else{
		claim_xmlhttp_<?php print($this_claim_results['_date']);?> = new ActiveXObject("Microsoft.XMLHTTP");
		
	}

	claim_xmlhttp_<?php print($this_claim_results['_date']);?>.onreadystatechange = function(){
		if(claim_xmlhttp_<?php print($this_claim_results['_date']);?>.readyState == 4 && claim_xmlhttp_<?php print($this_claim_results['_date']);?>.status == 200){
			
			var response_text = claim_xmlhttp_<?php print($this_claim_results['_date']);?>.responseText;
			var response_array = response_text.split("[]");
			if(response_array[0] == 'fetch_claim_beneficiaries'){
				$('#claim_<?php print($this_claim_results['_date']);?>_beneficiaries').html(response_array[1]);
				
				
			
			}else{
				$('#main_error_output').html(response_array[0]);
				$('#main_error_output').slideDown('fast');
				
			}
		}
	}
	</script>
	</div>
	<?php
	$claims_found =1;
	}
}

if(!$claims_found){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
}

?>
<input type="hidden" id="claims_in_view" value="<?php print($claims_in_view);?>">
<input type="hidden" id="all_claims_selected" value="0">
<input type="hidden" id="selected_claims" value="">
<script>
	$('#claim_list_status_bar').html('<strong>Records found: <?php  print(number_format($total_claims));?></<strong>');
	$('#claim_number_holder').html('<?php print($claim_number_list);?>');


	$('#legend_holder').slideDown();
	$('#legend_holder').html('<?php print($legend);?>');

	<?php
	for($u=0;$u<count($legend_user_ids);$u++){		
		?>
		$('#legent_user_'+<?php print($legend_user_ids[$u]);?>).html('(<?php print($legent_user_qty[$legend_user_ids[$u]]);?>)');
		<?php
	}
	?>
</script>