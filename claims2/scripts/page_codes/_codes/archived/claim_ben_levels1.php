<?php
	$claim_date = $this_claim_results['_date'];
	$claim_type_array = explode(",",$this_claim_results['claim_type_date']);
	
	$selected_beneficiaries = '';
	for($ct=0;$ct<count($claim_type_array);$ct++){		
		$claim_type_date = $claim_type_array[$ct];
		$this_claim_type = mysqli_query($claims_connect,"select * from request_types where _date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($claims_connect));
		$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
		
		$approval_rules = explode(']',$this_claim_type_results['rule_string']);
		$levels = count($approval_rules);
		
		$beneficiaries = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date = '$claim_date' and type_date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		
		if($ct!=0){
			$margin_top = '10px';
			
		}else{
			$margin_top = '0px';
		}
		
	?>
	<div style="width:505px;float:left;height:auto;padding-bottom:25px;margin-top:<?php print($margin_top);?>">
		<div style="height:20px;line-height:20px;width:100%;float:left;background-color:#b6c5fd;font-weight:bold;"><?php print($this_claim_type_results['title']);?></div>
		<div style="width:505px;float:left;height:20px;background-color:#d8e7fd;">
		<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Beneficiary</div>
		<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;">Days</div>
		<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;">From</div>
		<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;">To</div>
		<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;">Amount(K)</div>
		</div>

		<?php
		for($b=0;$b<mysqli_num_rows($beneficiaries);$b++){
			$beneficiaries_results = mysqli_fetch_array($beneficiaries,MYSQLI_ASSOC);
			$this_beneficiary_date = $beneficiaries_results['_date'];
			
			$check_disapproval = mysqli_query($$module_connect,"select * from claim_approvals where beneficiary_date = '$this_beneficiary_date' and claim_date = '$claim_date' and company_id = $company_id and status = 0")or die(mysqli_error($$module_connect));
			
			if(!mysqli_num_rows($check_disapproval)){
				if($selected_beneficiaries == ''){
					$selected_beneficiaries = $beneficiaries_results['_date'];
					
				}else{
					$selected_beneficiaries .= ','.$beneficiaries_results['_date'];
				}
			}
			
			$period_from = $beneficiaries_results['_from'];
			$period_to = $beneficiaries_results['_to'];
			
			if(strlen($beneficiaries_results['_name']) > 13){
				$beneficiary_name = substr($beneficiaries_results['_name'],0,13).'...';
				
			}else{
				$beneficiary_name = $beneficiaries_results['_name'];
			};
			
			if($beneficiaries_results['rate'] != ''){
				$days =  $beneficiaries_results['paid_days'].' of '.$beneficiaries_results['days'].' @K'.$beneficiaries_results['rate'].'/d';
			
			}else{
				$days = $beneficiaries_results['paid_days'].' of '.$beneficiaries_results['days'];
			}
			
			if($beneficiaries_results['days'] != $beneficiaries_results['paid_days']){
				$day_color = 'red';
				
			}else{
				$day_color = 'black';
			}
			
			?>
			<div style="width:100%;float:left;height:20px;border-bottom:solid 1px #fff;">
			<div style="width:140px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;" title="<?php print($beneficiaries_results['_name'].' ('.$beneficiaries_results['phone'].')');?>"><input type="checkbox" <?php if(!mysqli_num_rows($check_disapproval)){print('checked');}else{print(' disabled ');}?> onchange="if(this.checked){add_to_selection(<?php print($beneficiaries_results['_date']);?>,'claim_<?php print($claim_date);?>_selected_beneficiaries');}else{remove_from_selection(<?php print($beneficiaries_results['_date']);?>,'claim_<?php print($claim_date);?>_selected_beneficiaries');}" id="beneficiary_check_<?php print($beneficiaries_results['_date']);?>"><label for="beneficiary_check_<?php print($beneficiaries_results['_date']);?>"><?php print($beneficiary_name);?><label></div>
			<label for="beneficiary_check_<?php print($beneficiaries_results['_date']);?>"><div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;color:<?php print($day_color);?>" title="<?php if($beneficiaries_results['comment'] =='' || $beneficiaries_results['comment'] =='Enter comment here'){print('No comment');}else{print($beneficiaries_results['comment']);} ?>"><?php print($days);?></div>
			<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;"><?php print(date('jS M, Y',$period_from));?></div>
			<div style="width:95px;height:20px;line-height:20px;float:left;text-align:left;"><?php print(date('jS M, Y',$period_to));?></div>
			<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;" ><?php print(number_format($beneficiaries_results['amount'],2));?></div></label>
			</div>
		<?php
		}
		?>
	
	</div>

	<div style="width:435px;height:20px;float:left;overflow:auto;height:auto;margin-left:3px;padding-bottom:25px;" id="claim_levels_<?php print($this_claim_results['_date']);?>">
	<?php
	$claim_middle_point = (60 + (20*mysqli_num_rows($beneficiaries))) / 2;
	?>

	<?php
	if(mysqli_num_rows($beneficiaries) > 15){
			?>
		<div style="width:30px;line-height:20px;text-align:center;height:20px;float:right;background-color:#eee;position:absolute;margin-top:<?php print($claim_middle_point);?>px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#eee'" onclick="scroll_left('claim_levels_<?php print($this_claim_results['_date']);?>');" id="claim_levels_<?php print($this_claim_results['_date']);?>_scroll_left"><<</div>

		<?php
		if(count($approval_rules) > 4){?>
		<div style="width:30px;line-height:20px;text-align:center;height:20px;float:right;background-color:#eee;position:absolute;margin-left:400px;margin-top:<?php print($claim_middle_point);?>px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd'" onmouseout="this.style.backgroundColor='#eee'" onclick="scroll_right('claim_levels_<?php print($this_claim_results['_date']);?>');" id="claim_levels_<?php print($this_claim_results['_date']);?>_scroll_right">>></div>

		<?php
		}
	}
	?>

	<div style="width:<?php print(count($approval_rules) * 100);?>px;height:auto;float:left;margin-top:<?php print($margin_top);?>">
	<div style="height:20px;line-height:20px;width:100%;float:left;background-color:#b6c5fd;text-align:center;font-weight:bold;">Approval levels</div>
	<div style="width:100%;height:20px;float:left;line-height:20px;background-color:#d8e7fd;">
	<?php	
	$levels = count($approval_rules);
	for($a=0;$a<($levels);$a++){
		$instruction_array = explode(',',$approval_rules[$a]);
		$approval_users = check_approval_users($claim_type_date,($a),$company_id);
		
		if($instruction_array[0] == ''){
			$this_level_title = 'Level '.$a;
			
		}else{
			if(strlen($instruction_array[0]) > 10){
				$this_level_title = ($a+1).': '.substr($instruction_array[0],0,10).'...';
			}else{
				$this_level_title = ($a+1).': '.$instruction_array[0];
			}
			
			
		}
		
	?>
		<div style="width:100px;height:20px;line-height:20px;float:left;text-align:center;cursor:pointer;" onclick="$('#approvers_<?php print($claim_date.'_'.$claim_type_date.'_'.$a);?>').slideToggle('fast');" title="<?php print($instruction_array[0].' (Click to view level approvers)');?>" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='';"><?php print($this_level_title);?><div style="width:160px;padding:2px;position:absolute;border:solid 1px #aaa;display:none;background-color:#eef;min-height:20px;max-height:150px;overflow:auto;" id="approvers_<?php print($claim_date.'_'.$claim_type_date.'_'.$a);?>">
			
			<?php
				for($u=0;$u<count($approval_users);$u++){
					if($u==0){
						?>
						<div style="width:140px;font-size:0.9em;line-height:20px;min-height:20px;height:auto;background-color:#000;color:#fff;text-align:center;"><?php print($approval_users[$u][4]);?></div>
						<?php
						
					}
						?>
						<div style="width:140px;border-bottom:solid 1px #fff;font-size:0.9em;line-height:20px;min-height:20px;height:auto;color:#000;text-align:left;margin-bottom:5px;"><?php print('<strong>'.$approval_users[$u][2].'</strong><br>'.$approval_users[$u][1].'<br>'.$approval_users[$u][3]);?></div>
						<?php
					
				}
		?>
		</div></div>
	<?php
	}
	?>
	</div>

	<?php

	$beneficiaries_2 = mysqli_query($$module_connect,"select * from claim_beneficiaries where claim_date = '$claim_date' and type_date = '$claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));

	for($b=0;$b<mysqli_num_rows($beneficiaries_2);$b++){
		$this_beneficiary_results = mysqli_fetch_array($beneficiaries_2,MYSQLI_ASSOC);
		$this_beneficiary_date = $this_beneficiary_results['_date'];
		
		?>
		<div style="width:100%;height:20px;float:left;line-height:20px;border-bottom:solid 1px #eee;">				
			<?php
			
			
			for($l=0;$l<count($approval_rules);$l++){
				$claim_approvals = mysqli_query($$module_connect,"select * from claim_approvals where company_id = $company_id and claim_date = '$claim_date' and level = $l and beneficiary_date = '$this_beneficiary_date'")or die(mysqli_error($$module_connect));
				
				if(mysqli_num_rows($claim_approvals)){
					include 'claim_approved_code.php';
					$level_approved[$l] =  1;
					
				}else if($active_user_roles[11]){
					include 'approve_code.php';
					
				}else{
					?>
					<div style="width:100px;height:20px;line-height:20px;float:left;text-align:left;" id="beneficiary_<?php print($this_beneficiary_date);?>_level_<?php print($l);?>" title=""></div>
					<?php
				}			
			}
			?>
		</div>
		<?php
	}
	?>
	
	
	</div>
	</div>
	
	<?php
	}
	?>
	
	<div style="width:100%;min-height:40px;height:auto;float:left;background-color:#fff;border-bottom:solid 1px #eee;">
	<?php
		if($this_claim_results['file_src'] != ''){
			$attachments = explode(',',$this_claim_results['file_src']);
			
			for($f=0;$f<count($attachments);$f++){
				$file_array = explode('.',$attachments[$f]);
				
				if(!file_exists('../imgs/'.$file_array[1].'_icon.png')){
					$file_icon = 'unknown_icon.png';
					
				}else{
					$file_icon = $file_array[1].'_icon.png';
				}
				
				?>
			<div style="margin:5px;width:auto;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;border:solid 1px #ddd;" onmouseover="this.style.backgroundColor='#efe';" onmouseout="this.style.backgroundColor='';" onclick="window.open($('#url').val()+'/imgs/attachments/<?php print($attachments[$f]);?>','attachment_<?php print($attachments[$f]);?>');" id="download_attachment_<?php print($this_claim_results['_date']);?>"><div style="margin:2px;width:25px;height:25x;color:#000;text-align:center;float:left;"><img src="../imgs/<?php print($file_icon);?>" style="height:25px"></div><div style="width:auto;height:30x;color:#000;text-align:center;float:left;padding-right:5px;"><?php print($attachments[$f]);?></div></div>
			
			<?php
			}
		}else{
			?>
			<div style="width:100%;float:left;min-height:40px;height:auto;line-height:40px;color:#888;background-color:#fff;text-align:center;font-size:1.5em;" id="attachments_holder">No attachments were added</div>
			<?php
		}
		?>
	</div>
	
	<div style="width:100%;height:40px;float:left;background-color:#f1fbfb;">			
		<div style="margin-top:5px;margin:5px;width:90px;height:30px;background-color:#006bb3;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#8cb7d4';" onmouseout="this.style.backgroundColor='#006bb3';" onclick="open_spreadsheet(<?php print($this_claim_results['_date'].','.$user_date.','.$company_id);?>)">Spreadsheet</div><div style="margin-top:5px;margin:5px;width:100px;height:30px;background-color:#d697ee;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#faa4ff';" onmouseout="this.style.backgroundColor='#d697ee';" onclick="export_claim(<?php print($this_claim_results['_date'].',0,'.$company_id);?>);" id="export_claim_<?php print($this_claim_results['_date']);?>">CSV (Standard)</div><div style="margin-top:5px;margin:5px;width:95px;height:30px;background-color:#d697ee;color:#fff;text-align:center;line-height:30px;float:left;margin:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#faa4ff';" onmouseout="this.style.backgroundColor='#d697ee';" onclick="export_claim(<?php print($this_claim_results['_date'].',1,'.$company_id);?>);" id="export_claim_<?php print($this_claim_results['_date']);?>">CSV (ZOONA)</div>
	
		<div style="background-color:brown;width:70px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#bf1a1a';" onmouseout="this.style.backgroundColor='brown';" onclick="disable_claim(<?php print($this_claim_results['id']);?>)" id="claim_disable_button_<?php print($this_claim_results['id']);?>">Disable</div>
	
		<div style="background-color:orange;width:70px;color:#fff;cursor:pointer;height:30px;margin:5px;float:right;text-align:center;line-height:30px;border:solid 1px #fff;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="fetch_claim_details(<?php print($this_claim_results['id']);?>);">Edit</div>
		
	</div>
	<input type="hidden" id="claim_<?php print($this_claim_results['_date']);?>_selected_beneficiaries" value="<?php print($selected_beneficiaries);?>">
	<?php
	print('[]'.$selected_beneficiaries);
	?>
			
			