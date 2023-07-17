<div style="width:100%;height:auto;float:left;display:none;background-color:#eee;border-top:solid 1px #ddd;border-bottom:solid 1px #ddd;padding-bottom:5px;" id="filter_options">

<div style="width:100%;height:30px;float:left;margin-top:2px;" id="search_bar"><div style="width:300px;margin:0 auto;height:30px;"><input type="text" id="search_key" value="Search by memo number" style="width:100%;height:25px;color:#aaa;text-align:center;border:solid 1px #aaa;" onfocus="if($(this).val() == 'Search by memo number'){$(this).val('');this.style.color='#000';this.style.textAlign='left';}" onfocusout="if($(this).val() == ''){$(this).val('Search by memo number');this.style.color='#aaa';this.style.textAlign='center';}" onkeyup="if (event.keyCode == 13) {if($(this).val() != '' && $(this).val() != 'Search by memo number'){fetch_tracker();}}"></div></div>

<div style="width:100%;height:30px;float:left;line-height:30px;">

<div style="width:320px;float:left;margin-left:3px;">
<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">From:</div>
<div style="width:250px;min-height:25px;height:auto;float:left;">
<input type="text" id="search_field_from" style="color:#aaa;height:100%;width:100%;" value="<?php print(date('m/01/Y',time()));?>">
</div>
</div>

<div style="width:320px;float:left;margin-left:3px;">
<div style="width:50px;height:30px;line-height:30px;float:left;font-weight:bold;">From:</div>
<div style="width:250px;min-height:25px;height:auto;float:left;">
<input type="text" id="search_field_from" style="color:#aaa;height:100%;width:100%;" value="<?php print(date('m/j/Y',time()));?>">
</div>
</div>

<div style="width:auto;height:30px;float:left;line-height:30px;"><input type="checkbox" id="only_my_approval" <?php if(!isset($_GET['jump'])){print('checked');}?> onchange="if(this.checked){$('#selected_only_my_approval').val(1);fetch_tracker();}else{$('#selected_only_my_approval').val(0);fetch_tracker();}"><label for="only_my_approval">Only show my approvals</label></div>

<input type="hidden" id="selected_only_my_approval" value="1">




</div>

<div class="option_lebel">Request type:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#type_menu').toggle('fast');" id="active_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Select item</div>

<div class="option_menu" id="type_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#type_menu').fadeOut('fast');$('#selected_claim_type').val(0);$('#active_type').html($(this).html());" style="min-width:100px;">All types</div>

<?php
$request_types = mysqli_query($connect,"select * from request_types where company_id = $company_id order by title")or die(mysqli_error($connect));

for($r=0;$r<mysqli_num_rows($request_types);$r++){
	$request_type_results = mysqli_fetch_array($request_types,MYSQLI_ASSOC);
	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#type_menu').fadeOut('fast');$('#selected_claim_type').val(<?php print($request_type_results['id']);?>);$('#active_type').html($(this).html());fetch_tracker();" style="min-width:100px;"><?php print($request_type_results['title']);?></div>
	
	<?php
}
?>
<input type="hidden" id="selected_claim_type" value="0">
</div>
</div>


<div class="option_lebel">Approval level:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#level_menu').toggle('fast');" id="active_level" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">All</div>

<div class="option_menu" id="level_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_menu').fadeOut('fast');$('#selected_level').val(-1);$('#active_level').html($(this).html());" style="width:40px;">All</div>

<?php
$stage_request_types = mysqli_query($connect,"select * from request_types where company_id = $company_id order by approval_stages desc")or die(mysqli_error($connect));
$request_type_results = mysqli_fetch_array($stage_request_types,MYSQLI_ASSOC);

for($r=0;$r<$request_type_results['approval_stages']+1;$r++){
	
	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_menu').fadeOut('fast');$('#selected_level').val(<?php print($r);?>);$('#active_level').html($(this).html());fetch_tracker();"><?php print($r+1);?></div>
	
	<?php
}
?>
<input type="hidden" id="selected_level" value="-1">
</div>
</div>

<div style="width:auto;float:left;" id="claim_agents">

<div class="option_lebel">Created by:</div>

<div style="width:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#claim_beneficiary_menu').toggle('fast');$('#beneficiary_search_box').slideUp('fast');" id="active_claim_beneficiary" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Any creators</div>

<div class="option_menu" id="claim_beneficiary_menu" style="display:none;z-index:100">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_beneficiary_menu').toggle('fast');$('#active_claim_beneficiary').html($(this).html());$('#selected_claim_agent_date').val(0);">Any creators</div>

<?php
$pipat_users = mysqli_query($pipat_connect,"select * from agents where company_id = $company_id")or die(mysqli_error($pipat_connect));

	for($a=0;$a<mysqli_num_rows($pipat_users);$a++){
		$pipat_user_results = mysqli_fetch_array($pipat_users,MYSQLI_ASSOC);

		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_beneficiary_menu').toggle('fast');$('#active_claim_beneficiary').html($(this).html());$('#selected_claim_agent_date').val(<?php print($pipat_user_results['_date']);?>);fetch_tracker();"><?php print($pipat_user_results['_name']);?></div>

		<?php

	}
?>
</div>

<input type="hidden" name="selected_claim_agent_date" id="selected_claim_agent_date" value="0">

</div>

<div style="cursor:pointer;margin-right:30px;margin-top:1px;width:25px;height:25px;float:left;border:solid 1px #aaa;background-color:#eee;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" title="Click to search beneficiaries"onclick="$('#beneficiary_search_box').slideToggle('fast');$('#claim_beneficiary_menu').slideUp('fast');"><img src="https://secure51.ezhostingserver.com/blueraysit-com/imgs/search_icon.png" style="height:70%;margin-top:4px;margin-left:3px;"></div>

<div style="display:none;margin-top:30px;border:solid 1px #ccc;width:200px;float:left;max-height:300px;height:auto;position:absolute;background-color:#eee;" id="beneficiary_search_box">
<div style="width:100%;height:20px;float:left;background-color:#006bb3;text-align:center;line-height:20px;font-size:0.9em;color:#fff;">
Search for creators
<div style="cursor:pointer;width:20px;height:20px;text-align:center;line-height:20px;color:#fff;float:right;background-color:brown;" onmouseover="this.style.backgroundColor='#a55';" onmouseout="this.style.backgroundColor='brown';" title="Click to exit search" onclick="$('#beneficiary_search_box').slideUp('fast');">X</div>
</div>

<div style="width:100%;height:20px;float:left;margin-top:1px;">
<input type="text" id="search_beneficiary_key" style="width:97.2%;color:#aaa;" value="Enter beneficiary title here" onfocus="if(this.value=='Enter beneficiary title here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter beneficiary title here';this.style.color='#aaa';}">
</div>

<div style="cursor:pointer;width:70%;margin-left:30px;height:20px;float:left;margin-top:4px;color:#fff;text-align:center;background-color:orange;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="search_claim_beneficiary();">Search</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;padding:2px;max-height:220px;overflow:auto;" id="claim_beneficiary_search_results"></div>

</div>
</div>


<div style="width:100%;height:auto;float:left;">
<div class="option_lebel">Regions:</div>

<div style="width:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#location_0_menu').toggle('fast');" id="active_location_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All regions</div>

		<div class="option_menu" id="location_0_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<?php
			
			$location_menu = mysqli_query($pipat_connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($pipat_connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#location_0_menu').toggle('fast');$('#active_location_0').html($(this).html());$('#selected_location_0').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('pipat_connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'location_1',1,1,'pipat_connect-districts-province_id-{id}-location_2-1-1|pipat_connect-sites-district_id-{id}-location_3-1-1');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		<input type="hidden" id="selected_location_0" value="0">
</div>



<div style="width:auto;float:left;display:none;" id="location_1_holder">

<div class="option_lebel">Provinces:</div>

<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#location_1_menu').toggle('fast');" id="active_location_1" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select item</div>

		<div class="option_menu" id="location_1_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		</div>

<input type="hidden" id="selected_location_1" value="0">
</div>
</div>



<div style="width:auto;float:left;display:none;" id="location_2_holder">
<div class="option_lebel">Hub:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#location_2_menu').toggle('fast');" id="active_location_2" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select item</div>

		<div class="option_menu" id="location_2_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		</div>

<input type="hidden" id="selected_location_2" value="0">
</div>
</div>

<div style="width:auto;float:left;display:none;" id="location_1_holder">

<div class="option_lebel">Site:</div>

<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#location_3_menu').toggle('fast');" id="active_location_3" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select item</div>

		<div class="option_menu" id="location_3_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		</div>

<input type="hidden" id="selected_location_3" value="0">
</div>
</div>

<div style="margin-left:2px;width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="fetch_tracker();" id="tracking_search_button">Search</div>

</div>
</div>