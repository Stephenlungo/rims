<?php

if($claim_id_search_key_string != 'company_id = 1 and claim_id = 0' and $claim_id_search_key_string != ''){
	$claim_search = $claim_id_search_key_string.$status_string;
	
}else{
	$claim_search = $search_string.$claim_id_search_key_string.$status_string;
	
}

$payment_claims = mysqli_query($$module_connect,"select * from payment_claims where company_id = $company_id  $claim_search order by claim_id")or die(mysqli_error($$module_connect));


if(!mysqli_num_rows($payment_claims)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
<?php	
}else{
	
	for($c=0;$c<mysqli_num_rows($payment_claims);$c++){
		$this_claim_results = mysqli_fetch_array($payment_claims,MYSQLI_ASSOC);
		
		for($r=0;$r<count($region_id_array);$r++){
			if($this_claim_results['region_id'] == $region_id_array[$r]){
				$this_region_title = $region_name_array[$r];
				
				break;
				
			}else if($r==count($region_id_array) -1){
				$this_region_title = '<i>Unknown</i>';
			}
		}
		
		for($h=0;$h<count($hub_id_array);$h++){
			if($this_claim_results['hub_id'] == $hub_id_array[$h]){
				$this_hub_title = $hub_name_array[$h];
				
				break;
				
			}else if($h==count($hub_id_array) -1){
				$this_hub_title = '<i>Unknown</i>';
			}
		}
		
		for($u=0;$u<count($user_id_array);$u++){
			if($this_claim_results['user_date'] == $user_date_array[$u]){
				$this_user_name = $user_name_array[$u];
				$this_user_phone = $user_phone_array[$u];
				
				break;
				
			}else if($u==count($user_id_array) -1){
				$this_user_name = '<i>Unknown</i>';
				$this_user_phone = '<i>Unknown</i>';
			}
		}
		
		for($ct=0;$ct<count($claim_type_id_array);$ct++){
			$this_claim_types = explode(',',$this_claim_results['claim_type_date']);
			
			if(count($this_claim_types) > 1){
				$claim_type_title = '[<i>Multiple types</i>]';
				$claim_type_total_levels = '<i>Multiple</i>';
				break;
				
			}else{
				if($this_claim_results['claim_type_date'] == $claim_type_date_array[$ct]){
					$claim_type_title = $claim_type_title_array[$ct];
					$claim_type_total_levels = $claim_type_total_levels_array[$ct];
					break;
					
				}else if($ct==count($claim_type_id_array) -1){
					$claim_type_title = '<i>Unknown</i>';
					$claim_type_total_levels = '<i>Unknown</i>';
				}
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
<div style="width:100%;height:auto;float:left" id="claim_<?php print($this_claim_results['_date']);?>_holder">
<div style="color:<?php print($text_color);?>;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to expand/collapse" onclick="fetch_claim_beneficiaries(<?php print($this_claim_results['_date']);?>);" id="claim_<?php print($this_claim_results['_date']);?>"><div style="width:60px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_claim_results['claim_id']);?></div><div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$this_claim_results['claim_date']));?></div>
<div style="width:130px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($claim_type_title);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_user_name);?></div><div style="width:120px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_user_phone);?></div><div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_region_title);?></div><div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($this_hub_title);?></div><div style="width:50px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print($this_claim_results['level']+1);?></div><div style="width:65px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print($claim_type_total_levels);?></div><div style="width:70px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print(number_format($this_claim_results['amount'],2));?></div></div>
<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_active" value="0">
<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_original_color" value="<?php print($text_color);?>">

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
	}
}
?>
<script>
$('#claim_list_status_bar').html('<strong>Records found: <?php print(number_format(mysqli_num_rows($payment_claims)));?></<strong>');

</script>