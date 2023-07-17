<?php 
$memo_date = $memo_results['_date'];

if($memo_results['budget_id']){
	$budget_id = $memo_results['budget_id'];
	$this_budget = mysqli_query($connect,"select * from budgets where id = $budget_id")or die(mysqli_error($connect));
	$this_budget_results = mysqli_fetch_array($this_budget,MYSQLI_ASSOC);
	
	$budget_distribution_totals = explode('~}',$this_budget_results['final_distribution_totals']);
	
	$allocated_amount = $budget_distribution_totals[0];
	
}else{
	$allocated_amount = $memo_results['allocated_amount'];
}

$request_type = $memo_results['request_type'];
$this_request_type = mysqli_query($connect,"select * from request_types where id = $request_type")or die(mysqli_error($connect));
$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
$total_levels = $this_request_type_results['approval_stages'];

$level_titles = explode('~}',$this_request_type_results['approval_stage_titles']);
$action_titles = explode('~}',$this_request_type_results['action_titles']);

$holder_width = ($total_levels) * 125;
?>

<div style="width:100%;height:auto;float:left;">
<div style="width:<?php print($holder_width);?>px;height:20px;float:left;line-height:20px;background: linear-gradient(to right, #faa , #ccf, #afa);">

<?php
$approvers = explode(",",$this_request_type_results['stage_approvers']);
$action_types = explode(",",$this_request_type_results['action_type']);

for($l=0;$l<$total_levels;$l++){
	$this_approvers = explode("~}",$approvers[$l]);
	$check_approvers = check_approvers($company_id,$user_id,$this_approvers[0],$allocated_amount);
	
	$can_approve[$l] = $check_approvers[0];
	$approver_names = explode(",",$check_approvers[2]);
	$approver_phones = explode(",",$check_approvers[3]);
	$approver_emails = explode(",",$check_approvers[4]);
	
	?>
<div style="border-right:solid 1px #eee;width:120px;float:left;height:20px;padding-left:2px;padding-right:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view approvers" onclick="$('#approvers_<?php print($memo_date.'_'.$l);?>').slideToggle('fast');"><?php print($level_titles[$l]);?>

<div style="width:160px;position:absolute;height:150px;overflow:auto;background-color:#eee;display:none;color:#000;" id="approvers_<?php print($memo_date.'_'.$l);?>">

<div style="width:100%;height:20px;float:left;background-color:#006bb3;color:#fff;text-align:center;">Approvers</div>
<?php
for($a=0;$a<count($approver_names);$a++){?>
<div style="width:100%;min-height:20px;height:auto;float:left;border-bottom:solid 1px #fff;"><?php print($approver_names[$a].'<br>'.$approver_phones[$a].'<br>'.$approver_emails[$a]);?></div>

<?php
}
?>

</div>
</div>

<?php
}
?>
</div>
</div>
<div style="width:<?php print($holder_width);?>px;float:left;height:auto;" onclick="animate_bill_direction(<?php print($memo_results['id']);?>);">
<div style="color:green;font-weight:bold;width:100px;position:absolute;height:150px;line-height:150px;text-align:center;font-size:5em;opacity:0.2;z-index:-1" id="item_direction_<?php print($memo_results['id']);?>">>></div>

<?php
for($l=0;$l<$total_levels;$l++){?>

	<div style="width:120px;float:left;min-height:150px;height:auto;font-size:0.9em;padding:2px;border-right:solid 1px #eee;">
	<div style="width:100%;min-height:20px;height:auto;line-height:15px;float:left;font-weight:bold;border-bottom:solid 1px #eee;"><?php print($action_titles[$l]);?></div>

	<?php
	$approvals = mysqli_query($connect,"select * from approvals where company_id = $company_id and memo_date = '$memo_date' and level = $l order by _date desc")or die(mysqli_error($connect));
	
	if(mysqli_num_rows($approvals)){
		for($ap=0;$ap<mysqli_num_rows($approvals);$ap++){
			
			$approval_results = mysqli_fetch_array($approvals,MYSQLI_ASSOC);
			
			$user_date = $approval_results['user_date'];
			
			$this_user = mysqli_query($claims_connect,"select * from users where _date = '$user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
			
			if(!mysqli_num_rows($this_user)){
				$this_user = mysqli_query($pipat_connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($pipat_connect));
			}
			$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
			
			if($user_type == 1 and $ap==0 and $approval_results['validity'] == 0 ){
				include 'approve_code.php';
				
			}
			
			if($approval_results['validity'] == 0){
				$approval_display = 'none';
				$color = '#888';
				$font_style = 'italic';
				
				?>
				<div style="width:100%;cursor:pointer;height:15px;float:left;margin-top:4px;font-style:italic;background-color:#dfdfdf;color:#333;line-height:15px;" onclick="$('#approval_holder_<?php print($memo_date.'_'.$l.'_'.$ap);?>').slideToggle('fast');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#dfdfdf';"><?php print(date('jS M, Y',$approval_results['_date']));?></div>
				
				<?php
			}else{
				$approval_display = '';
				$color = '#000';
				$font_style = 'normal';
			}
			
			?>
			<div style="width:100%;height:auto;float:left;display:<?php print($approval_display.';color:'.$color.';font-style:
			'.$font_style);?>" id="approval_holder_<?php print($memo_date.'_'.$l.'_'.$ap);?>">
				<div style="width:100%;min-height:15px;height:auto;float:left;line-height:15px;"><?php if($approval_results['status']){print('<font style="color:green;">Done</font>');}else{print('<font style="color:red;font-weight:bold;">Denied</font> <br> <font style="color:#c78100"><i>Sent back to level '.$approval_results['jump_level'].'</i></font>');};?></div>
				
				<?php
				if(!$approval_results['status']){
					?>
					<div style="width:100%;min-height:15px;height:auto;line-height:15px;float:left;font-style:italic;margin-bottom:5px;color:brown">(<?php print($approval_results['comment']);?>)</div>
					
					<?php
				}
				?>
				
				<div style="width:100%;min-height:15px;height:auto;float:left;"><?php print($this_user_results['_name']);?></div>
				<div style="width:100%;min-height:15px;height:auto;float:left;"><?php print(date('jS M, Y',$approval_results['_date']));?></div>
				<div style="width:100%;min-height:15px;height:auto;float:left;"><?php print(date('H:i:s',$approval_results['_date']));?></div>

				<?php
				if($approval_results['attachments'] != ''){
					?>
					<div style="width:100%;height:15px;float:left;margin-top:10px;font-weight:bold;">Attachments</div>
					<?php
					$attachments = explode(',',$approval_results['attachments']);
					for($at=0;$at<count($attachments);$at++){
						?>
						<div style="width:100%;min-height:15px;height:auto;float:left;cursor:pointer;text-decoration:underline;" onclick="window.open($('#url').val()+'/imgs/<?php print($attachments[$at]);?>','_files');" onmouseover="this.style.color='green';" onmouseout="this.style.color='';"><?php print($attachments[$at]);?></div>

					<?php
					}
					?>
					<div style="width:100%;height:15px;float:left;cursor:pointer;" ></div>
					<?php

				}
				?>
			</div>
			
			<?php
			
		}
		
	}else{
			
				if($can_approve[$l] and $user_type == 1){
					
					include 'approve_code.php';
				}
		
	}
	?>
	</div>
	<?php
}
?>


</div>
<div style="width:100%;height:20px;float:left;margin-bottom:2px;background-color:#cceaff;">
<?php
if($memo_results['approval_status'] ==0){
	$btn_bg_color = 'brown';
	$btn_hover_color = '#a75f5f';
	$btn_title = 'Memorandum not approved. Click to view';
	
}else{
	$btn_bg_color = '#006bb3';
	$btn_hover_color = '#44afb3';
	$btn_title = 'Memorandum approved. Click to view';
}
?>


<div style="cursor:pointer;width:80px;height:20px;float:left;background-color:<?php print($btn_bg_color);?>;text-align:center;color:#fff;margin-right:2px;" onmouseover="this.style.backgroundColor='<?php print($btn_hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($btn_bg_color);?>';" title="<?php print($btn_title)?>" onclick="window.open($('#url').val()+'/pdf_export.php?m=<?php print($memo_date);?>&a=1&k=hblhsbsrbefibuqpufubnslnlquigrw2187768','_memo');">Memo</div>

<?php
if($memo_results['budgeted']){
	$this_budget = mysqli_query($connect,"select * from budgets where memo_date = '$memo_date' and company_id = $company_id")or die(mysqli_error($connect));
	$this_budget_results = mysqli_fetch_array($this_budget,MYSQLI_ASSOC);
	
	
	if($this_budget_results['approval_status'] ==0){
		$btn_bg_color = 'brown';
		$btn_hover_color = '#a75f5f';
		$btn_title = 'Budget not approved. Click to view';
		
	}else{
		$btn_bg_color = '#006bb3';
		$btn_hover_color = '#44afb3';
		$btn_title = 'Budget approved. Click to view';
	}
	?>
<div style="cursor:pointer;width:80px;height:20px;float:left;background-color:<?php print($btn_bg_color);?>;text-align:center;color:#fff;margin-right:2px;" onmouseover="this.style.backgroundColor='<?php print($btn_hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($btn_bg_color);?>';" title="<?php print($btn_title)?>" onclick="window.open($('#url').val()+'/pdf_export.php?m=<?php print($memo_date);?>&a=0&k=hblhsbsrbefibuqpufubnslnlquigrw2187768','_budget');">Budget</div>


<?php
}
?>
</div>