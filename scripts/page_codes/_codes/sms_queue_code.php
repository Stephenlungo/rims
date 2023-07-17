<?php
include 'item_details.php';
?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;float:left;height:20px;line-height:20px;" id="total_records"><strong>Records Found:</strong> </div>

<?php
if($active_user_roles[8]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_sms_details(0)" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php
}
?>

</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:120px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:120px;float:left;height:20px;margin-left:2px;">Module</div>
<div style="width:160px;float:left;height:20px;margin-left:2px;">SMS Group</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">To</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">Date Scheduled</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">Date Executed</div>

<div style="width:180px;float:left;height:20px;">Message</div>
</div>

<?php

if(!$sms_branch_id){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$sms_branch_id;
}

if(!$module_id){
	$module_search = '';
	
}else{
	$module_search = ' and module_id = '.$module_id;
	
}

if(!$group_id){
	$group_search = '';
	
}else{
	$group_search = ' and group_id = '.$group_id;
	
}

$sms_queue = mysqli_query($connect,"select * from sms_queue where company_id = $company_id and send_status = $status_id and _date >= '$date_from' and _date <= '$date_to' $branch_search $module_search $group_search order by _date")or die(mysqli_error($connect));

$total_records = 0;

if(!mysqli_num_rows($sms_queue)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($s=0;$s<mysqli_num_rows($sms_queue);$s++){
		$schedule_results = mysqli_fetch_array($sms_queue,MYSQLI_ASSOC);
		
		$total_records++;
		
		if(!$schedule_results['branch_id']){
			$sms_branch_title = '<i>Non-clustered</i>';
			
		}else{
			$sms_branch_id = $schedule_results['branch_id'];
			$sms_branch = mysqli_query($connect,"select * from branches where id = $sms_branch_id")or die(mysqli_error($connect));
			$sms_branch_results = mysqli_fetch_array($sms_branch,MYSQLI_ASSOC);
			
			$sms_branch_title = $sms_branch_results['title'];

		}
		if($schedule_results['send_status'] == 1){
			$color = 'green';
			
		}else if($schedule_results['send_status'] == 2){
			$color = 'brown';
		}
		
		if($schedule_results['date_sent'] == 0){
			$execution_date = '<font color="orange">Pending...</font>';
			
		}else{
			$execution_timestamp = ceil($schedule_results['date_sent']/1000);
			
			$execution_date = date('jS M, Y',$execution_timestamp);
			
		}
		
		if(strlen($schedule_results['text_message']) > 40){
			$text_message = substr($schedule_results['text_message'],0,40).'...';
			
		}else{
			$text_message = $schedule_results['text_message'];
		}
		
			?>

<div style="width:100%;height:20px;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;color:<?php print($color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click for more details" onclick="fetch_sms_details(<?php print($schedule_results['id']);?>);">
<div style="width:120px;float:left;height:20px;margin-left:2px;"><?php print($sms_branch_title);?></div>
<div style="width:120px;float:left;height:20px;margin-left:2px;">Module</div>
<div style="width:160px;float:left;height:20px;margin-left:2px;">SMS Group</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print($schedule_results['_to']);?></div>
<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print(date('jS M, Y',$schedule_results['_date']));?></div>
<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print($execution_date);?></div>

<div style="width:260px;float:left;height:20px;"><?php print($text_message);?></div>
</div>
		<?php
	
	}
}
?>
<script>
$('#total_records').html('<strong>Total records: </strong><?php print($total_records);?>');
</script>