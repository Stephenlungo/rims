<?php

$next_visit_dates = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_option_id = 319 order by id desc")or die(mysqli_error($connect));
		
$next_visit_date_client_id_array = array();
$next_visit_date_value_array = array();
for($i=0;$i<mysqli_num_rows($next_visit_dates);$i++){
	$next_visit_date_values_results = mysqli_fetch_array($next_visit_dates,MYSQLI_ASSOC);
	$next_visit_date_client_id_array[$i] = $next_visit_date_values_results['client_id'];
	$next_visit_date_value_array[$i] = $next_visit_date_values_results['_value'];
	
}

$initiation_next_visit_dates = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_option_id = 221")or die(mysqli_error($connect));
		
$initiation_next_visit_date_client_id_array = array();
$initiation_next_visit_date_value_array = array();
for($i=0;$i<mysqli_num_rows($initiation_next_visit_dates);$i++){
	$initiation_next_visit_date_values_results = mysqli_fetch_array($initiation_next_visit_dates,MYSQLI_ASSOC);
	$initiation_next_visit_date_client_id_array[$i] = $initiation_next_visit_date_values_results['client_id'];
	$initiation_next_visit_date_value_array[$i] = $initiation_next_visit_date_values_results['_value'];
	
}

$initiation_next_visit_dates = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_option_id = 221")or die(mysqli_error($connect));
		
$initiation_next_visit_date_client_id_array = array();
$initiation_next_visit_date_value_array = array();
for($i=0;$i<mysqli_num_rows($initiation_next_visit_dates);$i++){
	$initiation_next_visit_date_values_results = mysqli_fetch_array($initiation_next_visit_dates,MYSQLI_ASSOC);
	$initiation_next_visit_date_client_id_array[$i] = $initiation_next_visit_date_values_results['client_id'];
	$initiation_next_visit_date_value_array[$i] = $initiation_next_visit_date_values_results['_value'];
	
}

$initiation_array = fetch_db_table('connect','dynamic_form_values',1,'id','dynamic_form_category_option_id = 340');

if($user_results['prep_decryption_key_id']){
	$key_id = $user_results['prep_decryption_key_id'];
		
	$this_key = mysqli_query($connect,"select * from prep_decryption_keys where id = $key_id")or die(mysqli_error($connect));
	$this_key_results = mysqli_fetch_array($this_key,MYSQLI_ASSOC);
	$key_expiry = $this_key_results['expiry_date'];
	
	if($user_results['code_session_expiry'] > time()){
		$authorised = 1;
		
	}else{
		$authorised = 0;
	}
	
}else{
	$authorised = 0;
}

$total_clients = 0;
$clients = mysqli_query($connect,"select * from prep_clients where company_id = $company_id $search_string order by id desc")or die(mysqli_error($connect));
if(!mysqli_num_rows($clients)){
	?>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center">No records were found</div>
	<?php
	
}else{

for($c=0;$c<mysqli_num_rows($clients);$c++){
	$client_results = mysqli_fetch_array($clients,MYSQLI_ASSOC);
	
	$this_client_id = $client_results['id'];
	
	$entry_color = 'green';
	
	$initiation_date = 0;
	
	$initiation_index = array_keys($initiation_array['client_id'],$this_client_id);
	
	if(isset($initiation_index[0])){
		$initiation_date = $initiation_array['_value'][$initiation_index[0]];
		
		
	}
	
	
	for($i=0;$i<count($next_visit_date_client_id_array);$i++){
		if($next_visit_date_client_id_array[$i] == $this_client_id){			
			if($next_visit_date_value_array[$i] > time()){
				$client_status	= 1;
			
			}else{
				$client_status	= 2;
			}
			
			if($next_visit_date_value_array[$i] == 0){
				$next_client_visit = 'Next refill date was not provided';
				$entry_color = '#000';
				
			}else{
				$next_client_visit = 'Next refill date: '.date('jS M, Y',$next_visit_date_value_array[$i]).'( Based on follow up form)';
				
				if($next_visit_date_value_array[$i] < time()){
					$entry_color = 'brown';
					
				}
			
			}
			break;
		}else if($i==count($next_visit_date_client_id_array)-1){
			
			for($i2=0;$i2<count($initiation_next_visit_date_client_id_array);$i2++){
				if($initiation_next_visit_date_client_id_array[$i2] == $this_client_id){
				
					if($initiation_next_visit_date_value_array[$i2] > time()){
						$client_status	= 1;
					
					}else{
						$client_status	= 2;
					}
					
					if($initiation_next_visit_date_value_array[$i2] == 0){
						$next_client_visit = 'Next refill date was not provided';
						$entry_color = '#000';
						
					}else{
						$next_client_visit = 'Next refill date: '.date('jS M, Y',$initiation_next_visit_date_value_array[$i2]).' (Based on initiation form)';
						
						if($initiation_next_visit_date_value_array[$i2] < time()){
							$entry_color = 'brown';
							
						}
						
					}
					break;
					
				}else if($i2==count($initiation_next_visit_date_client_id_array)-1){
					$client_status	= 2;
					
					$next_client_visit = 'Next refill date was not provided';
					$entry_color = '#000';
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if($authorised){
		if($client_results['region_id']){			
			for($r=0;$r<count($region_id_array);$r++){
				if($region_id_array[$r] == $client_results['region_id']){
					$region_title = $region_title_array[$r];
					break;
				}
			}
			
		}else{
			$region_title = '<i>Unknown</i>';
			
		}
	}else{
		$region_title = '<i style="color:red;">Locked</i>';
		
	}
		
	if($authorised){
		if($client_results['province_id']){
			for($p=0;$p<count($province_id_array);$p++){
				if($province_id_array[$p] == $client_results['province_id']){
					$province_title = $province_title_array[$p];
					break;
				}
			}			
		}else{
			$province_title = '<i>Unknown</i>';
			
		}
		
	}else{
		$province_title = '<i style="color:red;">Locked</i>';
		
	}
	
	if($authorised){
		if($client_results['hub_id']){
			for($h=0;$h<count($hub_id_array);$h++){
				if($hub_id_array[$h] == $client_results['hub_id']){
					$hub_title = $hub_title_array[$h];
					break;
				}
			}			
		}else{
			$hub_title = '<i>Unknown</i>';
			
		}
		
	}else{
		$hub_title = '<i style="color:red;">Locked</i>';
	}
		
	if($authorised){		
		if($client_results['site_id']){
			for($s=0;$s<count($site_id_array);$s++){
				if($site_id_array[$s] == $client_results['site_id']){
    				if(strlen($site_title_array[$s]) > 8){
    					$site_title = substr($site_title_array[$s],0,8).'...';
    						
    				}else{
    					$site_title = $site_title_array[$s];						
    				}
					break;
				}
			}			
		}else{
			$site_title = '<i>Unknown</i>';
			
		}
		
	}else{
		$site_title = '<i style="color:red;">Locked</i>';
		
	}
		
		if($client_results['agent_id']){
			for($a=0;$a<count($agent_id_array);$a++){
				if($agent_id_array[$a] == $client_results['agent_id']){
					$agent_title = $agent_title_array[$a];
					break;
				}
			}			
		}else{
			$agent_title = '<i>Unknown</i>';
			
		}

        $population_category_title = 'General';
		if($client_results['population_category_id'] == 1){
			$population_category_title = 'MSM';
			
		}else if ($client_results['population_category_id'] == 2){
			$population_category_title = 'DC';
			
		}else if($client_results['population_category_id'] == 3){
			$population_category_title = 'FSW';
			
		}else if($client_results['population_category_id'] == 4){
			$population_category_title = 'PLM';
			
		}else if($client_results['population_category_id'] == 5){
			$population_category_title = 'AG/YW';
			
		}else if($client_results['population_category_id'] == 6){
			$population_category_title = 'Police Officer';
			
		}else if($client_results['population_category_id'] == 7){
			$population_category_title = 'Inmates';
			
		}else if($client_results['population_category_id'] == 8){
			$population_category_title = 'Prison Officer';
		
		}else if($client_results['population_category_id'] == 9){
			$population_category_title = 'Young Males';
		}
	
	if($authorised){	
		$gender_id = $client_results['sex'];
		
		$this_gender = mysqli_query($connect,"select * from genders where id = $gender_id")or die(mysqli_error($connect));
		$this_gender_results = mysqli_fetch_array($this_gender,MYSQLI_ASSOC);
		
		$client_gender = $this_gender_results['title'];
		
	}else{
		$client_gender = '<i style="color:red;">Locked</i>';
		
	}
		
		if(!$client_results['prep_id']){
			$prep_id_title = '<i style="color:brown;">Unset</i>';
			
		}else{
			$prep_id_title = $client_results['prep_id'];
			
		}
		
	if($authorised){
		$client_name = $client_results['_name'];
		
	}else{
		$client_name = '<i style="color:red;">Locked</i>';
		
	}
	
	if($authorised){
		$client_phone = $client_results['phone'];
		
	}else{
		$client_phone = '<i style="color:red;">Locked</i>';
		
	}
	
	if($authorised){
		$client_age = $client_results['age'];
		
	}else{
		$client_age = '<i style="color:red;">Locked</i>';
		
	}
	
	if(!$client_results['account_status']){
		$entry_color = '#aaa';
	}
	
	if($client_results['entry_method'] == 1){
		$entry_background = '#fee';
		
	}else{
		$entry_background = '';
		
	}
	
	if(($client_status == $client_active_status or ($client_active_status == 0)) and ($date_basis == 0 || ($date_basis == 1 and ($initiation_date >= $date_from and $initiation_date <= $date_to)))){
		$total_clients++;
		?>
		<div style="cursor:pointer;color:<?php print($entry_color);?>;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;background-color:<?php print($entry_background);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='<?php print($entry_background);?>';" onclick="$('#filter_options').slideUp('fast');<?php if($authorised){?>if(<?php print($user_id.' == 765 && '.$client_results['user_id'].' != 765'); ?>){alert('You are in an excluded cluster. You can only view profiles you create');}else{fetch_client_details(<?php print($client_results['id']);?>,0);}<?php }else {?> alert('You are not authorized to view client data'); <?php }?>" id="client_<?php print($client_results['id']);?>" title="<?php print($next_client_visit);?>"><div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$client_results['_date']));?></div>
	<div style="width:80px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($prep_id_title);?></div>
	<div style="width:160px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_name);?></div>
	<div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_phone);?></div>
	<div style="width:50px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_gender);?></div>
	<div style="width:40px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_age);?></div>
	<div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:110px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:100px;height:auto;line-height:20px;float:left;" id="client_risk_<?php print($client_results['id']);?>"><?php print($population_category_title);?></div></div>
		
		<?php
	}
}
}
?>

<script>
$('#client_result_status').html('<div style="width:auto;float:left;height:auto;"><strong>Records found:</strong></div><div style="margin-left:5px;width:auto;float:left;height:auto;" id="records_number"><?php print($total_clients);?></div>');

</script>
