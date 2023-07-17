<?php
	$this_level_rule = $this_level_rule_array;
	if(!$this_level_rule[2]){
		?>
		<div style="width:100px;min-height:20px;height:auto;line-height:20px;float:left;text-align:left;text-align:center;" id="beneficiary_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$this_beneficiary_agent_date.'_'.$c.'_'.$l);?>_level" title="" onmouseover="" onmouseout="">
			<?php
			$rules = validate_claim_rules($company_id,$user_id,$this_claim_type_date,($l),$this_beneficiary_amount);
			
			if($rules){
				if($this_claim_results['status'] != 0){
					$user_once_validated[$l] = 1;
					?>			
					<div style="width:auto;float:left;margin-left:5px;text-align:left;" >
					
					
					<div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#898;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#898';" onmouseover="this.style.backgroundColor='#8d8';" onclick="confirm_level(<?php print($this_claim_date.','.$this_claim_type_date.','.$this_beneficiary_agent_date.','.$c.','.$l.',0,0');?>);" title="Click to approve">&#10004;</div> <?php if($l!=0){?><div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#e88;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#e88';"onmouseover="this.style.backgroundColor='brown';" onclick="reject_level(<?php print($this_claim_date.','.$this_claim_type_date.','.$this_beneficiary_agent_date.','.$c.','.$l.',0,0');?>);" title="Click to deny approval">&#10005; </div><?php }?>
					
					</div>
				<?php
				}else{
					print('N/A');
				
				}
			}
				
				if(isset($user_once_validated[$l])){
					if($b==count($this_claim_benefificiary_index)-1){
					//	include 'approve_all_code.php';
						
					}
				}
			?>
		</div>
	<?php
	}else if($this_level_rule[2] == 1){
		$documents = explode("~}",$approvers[$l]);
		$documents = array_splice($documents,1);
		
		for($d=0;$d<count($documents)-5;$d++){
			?>
			<div style="width:100%;height:15px;float:left;line-height:15px;font-style:italic"><?php	print(($d+1).'. '.$documents[$d]);?></div>
			<div style="width:100%;height:20px;margin-bottom:4px;float:left;"><div style="width:50px;text-align:center;float:left;height:20px;background-color:#f4bc55;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#f4bc55';" onmouseover="this.style.backgroundColor='#ffcf77';" onclick="open_uploader('add_approval_file(<?php print($memo_results['id'].','.$l.','.$d);?>)',0);$('#image_0').click();" id="file_upload_button_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>">Upload</div>
			
			<div style="width:100%;min-height:20px;height:auto;float:left;display:none;" id="file_upload_name_holder_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>">
			<div style="width:auto;height:20px;float:left;color:green;cursor:pointer;" id="file_upload_name_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>" onmouseover="this.style.color='#55ba55';" onmouseout="this.style.color='green';" onclick="window.open($('#url').val()+'/imgs/'+$(this).html(),'_file');"></div>
			
			<div style="margin-left:2px;width:20px;height:20px;float:right;color:#fff;line-height:20px;text-align:center;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor='#f00';" onmouseout="this.style.backgroundColor='brown';" onclick="var c=confirm('This will remove this file. Proveed?');if(c){$('#file_upload_name_holder_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>').hide('fast');$('#file_upload_button_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>').show('fast');$('#uploaded_file_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>').val('');}">X</div>
			
			</div>
			<input type="hidden" id="uploaded_file_<?php print($memo_results['id'].'_'.$l.'_'.$d);?>" value="">
			</div>
			
			<?php				
		}
		?>
		<input type="hidden" id="total_documents" value="<?php print(count($documents)-5);?>">
		
		<?php
	}
	?>