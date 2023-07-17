	<div style="width:100%;height:30px;float:left;margin-top:10px;">Number of claims to merge into one: <?php print(count($selected_claims));?></div>
	
	<?php
		
		$this_default_claim_partition_name = $default_partition_names[7][1][0];
	
		$claim_ids = array();
		
		for($c=0;$c<count($selected_claims);$c++){
			$this_claim_date = $selected_claims[$c];
			$partitions = fetch_database_partitions(7,$this_claim_date,$this_claim_date);
			$payment_claims_table = $this_default_claim_partition_name.'_partition_'.$partitions[0];
			
			$claim_array = fetch_db_table('claims_connect',$payment_claims_table,$company_id,'id',"_date = '".$this_claim_date."'");
			
			$claim_ids[count($claim_ids)] = $claim_array['claim_id'][0];
		}
	?>
	
	
	<div style="width:110px;height:30px;line-height:30px;float:left;color:#006bb3">Merge claims to:</div>	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#target_claim_menu').toggle('fast');" id="active_target_claim" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select target claim</div>
		
		<div class="option_menu" id="target_claim_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
				for($c=0;$c<count($claim_ids);$c++){
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#target_claim_menu').toggle('fast');$('#active_target_claim').html($(this).html());$('#selected_target_claim').val(<?php print($selected_claims[$c]);?>);">Claim <?php print($claim_ids[$c]);?></div>
					<?php
				}
			?>
		</div>
	</div>
		
	<input type="hidden" id="selected_target_claim" value="0">		
	<input type="hidden" id="selected_claims" value="<?php print($selected_claim_list);?>">		
	
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
		<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#b33c3c';" onmouseout="this.style.backgroundColor='brown';"  id="claims_merge_button" onclick="complete_merge_claims();" title="Click to update account details">Merge</div>

	</div>