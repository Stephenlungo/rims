<?php
$claim_types = fetch_db_table('claims_connect','request_types',1,'id','');
$regions = fetch_db_table('connect','regions',1,'id','');
$provinces = fetch_db_table('connect','provinces',1,'id','');
$hubs = fetch_db_table('connect','hubs',1,'id','');
$facilities = fetch_db_table('connect','sites',1,'id','');

?>

<div style="width:100%;height:20px;line-height:#eef;font-size:1.3em;float:left;">From meetings</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#fee;" id="claims_header"><div style="width:80px;height:20px;float:left;margin-right:3px;">ID.</div><div style="width:95px;height:20px;float:left;margin-right:3px;">Date created</div>
<div style="width:260px;height:20px;float:left;margin-right:3px;">Meeting title</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Facility</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div></div>


<?php
	$awaiting_creation = mysqli_query($connect,"select * from meetings where company_id = $company_id and status = 2 $meetings_search_string")or die(mysqli_error($connect));
	
	for($a=0;$a<mysqli_num_rows($awaiting_creation);$a++){
		$awaiting_creation_results = mysqli_fetch_array($awaiting_creation,MYSQLI_ASSOC);
		
		if(!$awaiting_creation_results['region_id']){
			$region_name = '<i>Unspecified</i>';
			
		}else{
			$region_index = array_keys($regions['id'],$awaiting_creation_results['region_id']);
			
			if(isset($region_index[0])){
				$region_name = $regions['title'][$region_index[0]];
				
			}else{
				$region_name = 'Not found';
				
			}
		}
		
		if(!$awaiting_creation_results['province_id']){
			$province_name = '<i>Unspecified</i>';
			
		}else{
			$province_index = array_keys($provinces['id'],$awaiting_creation_results['province_id']);
			
			if(isset($province_index[0])){
				$province_name = $provinces['title'][$province_index[0]];
				
			}else{
				$province_name = 'Not found';
				
			}
		}
		
		if(!$awaiting_creation_results['hub_id']){
			$hub_name = '<i>Unspecified</i>';
			
		}else{
			$hub_index = array_keys($hubs['id'],$awaiting_creation_results['hub_id']);
			
			if(isset($hub_index[0])){
				$hub_name = $hubs['title'][$hub_index[0]];
				
			}else{
				$hub_name = 'Not found';				
			}
		}
		
		if(!$awaiting_creation_results['site_id']){
			$facility_name = '<i>Unspecified</i>';
			
		}else{
			$facility_index = array_keys($facilities['id'],$awaiting_creation_results['site_id']);
			
			if(isset($facility_index[0])){
				$facility_name = $facilities['title'][$facility_index[0]];
				
			}else{
				$mother_facility_name = 'Not found';				
			}
		}
		
		$claim_type_names = '<i>Multiple</i>';
		
		?>
		<div style="width:100%;height:auto;float:left;" id="awaiting_<?php print($awaiting_creation_results['_date']);?>_holder">
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view beneficiaries" onclick="fetch_awaiting_beneficiaries(<?php print($awaiting_creation_results['id']);?>,0)" id="awaiting_<?php print($awaiting_creation_results['id']);?>"><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($awaiting_creation_results['meeting_code']);?></div><div style="width:95px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$awaiting_creation_results['_date']));?></div>
<div style="width:260px;height:20px;float:left;margin-right:3px;"><?php print($awaiting_creation_results['title']);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($facility_name);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">0.00</div>
</div>
<input type="hidden" value="0" id="awaiting_<?php print($awaiting_creation_results['id']);?>_active">
<div style="width:100%;min-height:200px;height:auto;float:left;display:none;margin-bottom:10px;border-bottom:solid 3px #ddd;" id="awaiting_<?php print($awaiting_creation_results['id']);?>_beneficiaries"></div>
<script>
if(window.XMLHttpRequest){
	awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?> = new XMLHttpRequest();

}else{
	awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?> = new ActiveXObject("Microsoft.XMLHTTP");
	
}

awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?>.onreadystatechange = function(){
	if(awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?>.readyState == 4 && awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?>.status == 200){
		
		var response_text = awaiting_xmlhttp_<?php print($awaiting_creation_results['id']);?>.responseText;
		var response_array = response_text.split("[]");
		if(response_array[0] == 'fetch_awaiting_beneficiaries'){
			$('#awaiting_<?php print($awaiting_creation_results['id']);?>_beneficiaries').html(response_array[1]);
			
		}else if(response_array[0] == 'create_claim_from_awaiting' || response_array[0] == 'delete_awaiting_claim'){
			$('#awaiting_'+response_array[1]+'_holder').slideUp('fast');
			
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
?>




<div style="width:100%;height:20px;line-height:#eef;font-size:1.3em;float:left;margin-top:40px;">From automatic schedules</div>
<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="awaiting_claim_list_status_bar" onclick="$('#claim_number_holder').slideToggle('fast');" title="Click to view claim numbers"><strong>Records found:</strong> (Counting...)</div>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#fee;" id="claims_header"><div style="width:40px;height:20px;float:left;margin-right:3px;">ID.</div><div style="width:95px;height:20px;float:left;margin-right:3px;">Date created</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Payment Period</div>
<div style="width:150px;height:20px;float:left;margin-right:3px;">Claim type</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">M. Facility</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div></div>


<?php
	$awaiting_creation = mysqli_query($$module_connect,"select * from tmp_payment_claims where company_id = $company_id $search_string")or die(mysqlI_error($$module_connect));
	
	for($a=0;$a<mysqli_num_rows($awaiting_creation);$a++){
		$awaiting_creation_results = mysqli_fetch_array($awaiting_creation,MYSQLI_ASSOC);
		
		if(!$awaiting_creation_results['region_id']){
			$region_name = '<i>Unspecified</i>';
			
		}else{
			$region_index = array_keys($regions['id'],$awaiting_creation_results['region_id']);
			
			if(isset($region_index[0])){
				$region_name = $regions['title'][$region_index[0]];
				
			}else{
				$region_name = 'Not found';
				
			}
		}
		
		if(!$awaiting_creation_results['province_id']){
			$province_name = '<i>Unspecified</i>';
			
		}else{
			$province_index = array_keys($provinces['id'],$awaiting_creation_results['province_id']);
			
			if(isset($province_index[0])){
				$province_name = $provinces['title'][$province_index[0]];
				
			}else{
				$province_name = 'Not found';
				
			}
		}
		
		if(!$awaiting_creation_results['hub_id']){
			$hub_name = '<i>Unspecified</i>';
			
		}else{
			$hub_index = array_keys($hubs['id'],$awaiting_creation_results['hub_id']);
			
			if(isset($hub_index[0])){
				$hub_name = $hubs['title'][$hub_index[0]];
				
			}else{
				$hub_name = 'Not found';				
			}
		}
		
		if(!$awaiting_creation_results['mother_facility_id']){
			$mother_facility_name = '<i>Unspecified</i>';
			
		}else{
			$mother_facility_index = array_keys($mother_facilities['id'],$awaiting_creation_results['mother_facility_id']);
			
			if(isset($mother_facility_index[0])){
				$mother_facility_name = $mother_facilities['title'][$mother_facility_index[0]];
				
			}else{
				$mother_facility_name = 'Not found';				
			}
		}
		
		
		$claim_type_date = explode(',',$awaiting_creation_results['claim_type_date']);
		
		$claim_type_names = '';
		for($c=0;$c<count($claim_type_date);$c++){
			
			$this_claim_type_date = $claim_type_date[$c];
			$claim_type_index = array_keys($claim_types['_date'],$this_claim_type_date);
		
			if($claim_type_names == ''){
				$claim_type_names = $claim_types['title'][$claim_type_index[0]];
				
			}else{
				$claim_type_names .= ', '.$claim_types['title'][$claim_type_index[0]];
				
			}
		}
		
		?>
		<div style="width:100%;height:auto;float:left;" id="awaiting_<?php print($awaiting_creation_results['_date']);?>_holder">
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view beneficiaries" onclick="fetch_awaiting_beneficiaries(<?php print($awaiting_creation_results['_date']);?>,1)" id="awaiting_<?php print($awaiting_creation_results['_date']);?>"><div style="width:40px;height:20px;float:left;margin-right:3px;"><?php print($awaiting_creation_results['_date']);?></div><div style="width:95px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$awaiting_creation_results['claim_date']));?></div>
<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$awaiting_creation_results['_from']).' - '.date('jS M, Y',$awaiting_creation_results['_to']));?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($claim_type_names);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($region_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($province_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($hub_name);?></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($mother_facility_name);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;"><?php print(number_format($awaiting_creation_results['amount'],2));?></div>
</div>
<input type="hidden" value="0" id="awaiting_<?php print($awaiting_creation_results['_date']);?>_active">
<div style="width:100%;min-height:200px;height:auto;float:left;display:none;margin-bottom:10px;border-bottom:solid 3px #ddd;" id="awaiting_<?php print($awaiting_creation_results['_date']);?>_beneficiaries"></div>
<script>
if(window.XMLHttpRequest){
	awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?> = new XMLHttpRequest();

}else{
	awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?> = new ActiveXObject("Microsoft.XMLHTTP");
	
}

awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?>.onreadystatechange = function(){
	if(awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?>.readyState == 4 && awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?>.status == 200){
		
		var response_text = awaiting_xmlhttp_<?php print($awaiting_creation_results['_date']);?>.responseText;
		var response_array = response_text.split("[]");
		if(response_array[0] == 'fetch_awaiting_beneficiaries'){
			$('#awaiting_<?php print($awaiting_creation_results['_date']);?>_beneficiaries').html(response_array[1]);
			
		}else if(response_array[0] == 'create_claim_from_awaiting' || response_array[0] == 'delete_awaiting_claim'){
			$('#awaiting_'+response_array[1]+'_holder').slideUp('fast');
			
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
?>

<script>
$('#awaiting_claim_list_status_bar').html('<strong>Records found: <?php print(mysqli_num_rows($awaiting_creation));?>');

</script>