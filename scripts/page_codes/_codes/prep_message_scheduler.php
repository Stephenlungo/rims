<?php
include 'prep_schedule_message_editor.php';
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

<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_scheduler(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>


</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:310px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Type</div>
<div style="width:140px;float:left;height:20px;">Effective date</div>
</div>

<?php

$schedulers = mysqli_query($connect,"select * from prep_message_scheduler where company_id = $company_id order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($schedulers)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($s=0;$s<mysqli_num_rows($schedulers);$s++){
		$schedulers_results = mysqli_fetch_array($schedulers,MYSQLI_ASSOC);		
		$schedulers_id = $schedulers_results['id'];		
		
		if(!$schedulers_results['type']){
			$scheduler_type = 'Relative';
			
		}else{
			$scheduler_type = 'Absolute';
		
		}
		
		?>

		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" id="item_<?php print($schedulers_results['id']);?>" onclick="fetch_scheduler(<?php print($schedulers_results['id']);?>);">
		<div style="width:310px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($schedulers_results['title']);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($scheduler_type);?></div>
		<div style="width:140px;float:left;min-height:20px;height:auto;"><?php print(date('jS M, Y',$schedulers_results['start_date']));?></div>
		</div>
		
		
		<?php
	
	}
}
?>