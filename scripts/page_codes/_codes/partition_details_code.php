<?php
$partition_type = $variables[0];
$partition_id = $variables[1];

if($partition_id){
	$this_partition_array = new_fetch_db_table('connect','table_partitions',$company_id,'id','id = '.$partition_id);
	$period_from = date('m/d/Y',$this_partition_array[1]['period_from'][0]);
	$period_to = date('m/d/Y',$this_partition_array[1]['period_to'][0]);
	
	$button_text = 'Update';
	
	$period_from_validity_id = 1;
	
	
}else{
	$period_from = date('m/d/Y',time());
	$period_to = date('m/d/Y',time());
	$button_text = 'Create';
	
	$period_from_validity_id = 1;
}
$period_validation_color = 'green';
$period_validation_message = 'Period validation successful...';
?>
<input type="hidden" id="partition_type" value="<?php print($partition_type);?>">
<div style="width:100%;height:auto;float:left;">
	<div style="width:120px;height:30px;line-height:30px;float:left;">Period from:</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="partition_from" style="width:100%;height:30px;" value="<?php print($period_from);?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}" onchange="check_partition_dates(0);check_other_partition_date(<?php print($partition_type.','.$partition_id);?>)">
	</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
	<div style="width:120px;height:30px;line-height:30px;float:left;">Period to:</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="partition_to" style="width:100%;height:30px;" value="<?php print($period_to);?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}" onchange="check_partition_dates(1);check_other_partition_date(<?php print($partition_type.','.$partition_id);?>)">
	</div>
</div>

<input type="hidden" id="period_from_validity" value="<?php print($period_from_validity_id);?>">
<div style="width:100%;min-height:20px;height:auto;line-height:20px;color:<?php print($period_validation_color);?>;float:left;font-weight:bold;" id="period_from_validation_status"><?php print($period_validation_message);?></div>

<div style="width:100%;height:auto;float:left;margin-top:30px;">
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_update_partition_button" onclick="update_or_create_partition(<?php print($partition_type.','.$partition_id);?>);" title="Click to save details"><?php print($button_text);?></div>
	
	<?php 
	if($partition_id){
		?>
		<div style="marrgin-left:5px;width:120px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#b34545';" onmouseout="this.style.backgroundColor='brown';"  id="cdelete_partition_button" onclick="delete_partition(<?php print($partition_type.','.$partition_id);?>);" title="Click to merg with default">Merge with default</div>
	<?php
	}
	?>
</div>

<script>
$( function() {
	$( "#partition_from" ).datepicker();
	$( "#partition_to" ).datepicker();
} );

check_other_partition_date(<?php print($partition_type.','.$partition_id);?>)
</script>