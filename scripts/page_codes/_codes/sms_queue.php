<?php
include 'item_details.php';

if($a){
	$bg_color = '#ddf';
	
}else if($a == 0){
	$bg_color = '#fdd';
	
}else{
	$bg_color = '#dfd';
}

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">

<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="alert('Not Installed');" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>


</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:180px;float:left;height:20px;margin-left:2px;">Action date</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Action time</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">From</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">To</div>
<div style="width:200px;float:left;height:20px;">Message</div>
</div>

<?php

$sms_queue = mysqli_query($connect,"select * from prep_message_schedule where company_id = $company_id order by action_date")or die(mysqli_error($connect));

if(!mysqli_num_rows($sms_queue)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($s=0;$s<mysqli_num_rows($sms_queue);$s++){
		$schedule_results = mysqli_fetch_array($sms_queue,MYSQLI_ASSOC);		
		
		?>

		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" id="item_<?php print($schedulers_results['id']);?>" onclick="fetch_scheduler(<?php print($schedulers_results['id']);?>);"><div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print(date('jS M, Y',$schedule_results['action_date']));?></div>
<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print(date('H:i:s',$schedule_results['action_date']));?></div>
<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($schedule_results['_from']);?></div>
<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($schedule_results['_to']);?></div>
<div style="width:200px;float:left;min-height:20px;height:auto;"><?php print($schedule_results['message']);?></div>
		</div>
		
		
		<?php
	
	}
}
?>