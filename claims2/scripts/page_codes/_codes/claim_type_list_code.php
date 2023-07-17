<?php

if($status == -1){
	$status_filter = '';
	
}else{
	$status_filter = ' and status = '.$status;
	
}

$claim_types = mysqli_query($$module_connect,"select * from claim_types where company_id = $company_id $status_filter order by status desc, title asc");

for($ct=0;$ct<mysqli_num_rows($claim_types);$ct++){
	$claim_type_results = mysqli_fetch_array($claim_types,MYSQLI_ASSOC);
	
	if($claim_type_results['status']){
		$text_color = '#000';
		
	}else{
		$text_color = '#aaa';
		
	}
	
	if($claim_type_results['day_adjustment']){
		$day_adjustment = 'Yes';
		
	}else{
		$day_adjustment = 'Yes';
		
	}
	?>
	<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;color:<?php print($text_color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view more details" onclick="fetch_claim_type_details(<?php print($claim_type_results['id']);?>);"><div style="width:300px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($claim_type_results['title']);?></div>
<div style="width:130px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($claim_type_results['approval_stages']);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print($claim_type_results['daily_rate']);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:right;"><?php print($claim_type_results['day_limit']);?></div><div style="width:150px;min-height:20px;height:auto;line-height:20px;float:left;margin-right:3px;text-align:left;margin-left:5px;"><?php print($day_adjustment);?></div></div>
	
	<?php
}
?>
<script>
$('#claim_type_status_bar').html('<strong>Records found:</strong> <?php print(mysqli_num_rows($claim_types));?>');
</script>