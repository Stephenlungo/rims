<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="claim_list_status_bar" onclick="$('#claim_number_holder').slideToggle('fast');" title="Click to view claim numbers"><strong>Records found:</strong> (Counting...)</div>


<?php
if($active_user_roles[9]){
	?>
	
	<div style="width:auto;height:auto;float:right;margin-right:50px;">
		<div style="width:auto;min-height:20px;height:auto;float:left;">
		
		<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:brown;color:#fff;" onclick="merge_claims();change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#b65151';" onmouseout="this.style.backgroundColor = 'brown';" title="Click to add entry">Merge</div>
		
		<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="$('#claim_export_menu').toggle('fast');" id="active_claim_export" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">Export</div>

		<div class="option_menu" id="claim_export_menu" style="display:none;min-width:120px;max-width:280px;width:auto;margin-top:20px;">
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_export_menu').toggle('fast');export_claims(0)">Claim list</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_export_menu').toggle('fast');alert('Not yet installed')">Beneficiary list</div>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_export_menu').toggle('fast');export_claims(1)">Allocation table</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_export_menu').toggle('fast');export_tilt_file()">TILT file (Excel)</div>
		</div>
		</div>
	</div>
	
	<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="allocate_claims();change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">Allocate</div>
	
	
	
<div class="general_button" style="margin-right:40px;width:90px;float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_claim_details(0);change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">Create New</div>



<?php
}
?>
<div style="width:100%;min-height:20px;height:auto;float:left;background-color:#eee;display:none;" id="claim_number_holder"></div>

<div style="width:100%;height:20px;height:auto;float:left;display:none;" id="legend_holder"></div>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="claims_header"><div style="width:20px;height:20px;float:left;"><input type="checkbox" onclick="if(this.checked){select_or_deselect_all_claims(1);}else{select_or_deselect_all_claims(0);}" id="select_all_claim_button"></div><div style="width:60px;height:20px;float:left;margin-right:3px;">Claim No.</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:130px;height:20px;float:left;margin-right:3px;">Claim type</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Creator</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:183px;height:20px;float:left;margin-right:3px;">Location</div><div style="width:50px;height:20px;float:left;margin-right:3px;text-align:right;">Level</div><div style="width:65px;height:20px;float:left;margin-right:3px;text-align:right;">Claimants</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div></div>
<input type="hidden" id="approval_queue" value="">
<input type="hidden" id="rejection_queue" value="">
<div class="general_holder" id="payment_claim_list_holder" style="min-height:300px;">


</div>

<input type="hidden" id="claim_status" value="<?php print($a);?>">
<script>
fetch_payment_claims();
freeze_header('claims_header');

</script>