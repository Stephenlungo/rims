<div style="width:100%;height:auto;float:left;">

<div style="width:100%;height:auto;float:left;">
<div style="width:200px;height:30px;margin:0 auto;">
<div style="width:auto;height:auto;float:left;" id="unit_0_holder">
			<div style="width:50px;height:30px;line-height:30px;float:left;">Module:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#data_uploader_menu').toggle('fast');" id="active_data_uploader" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">PIPAT PrEP</div>

			<div class="option_menu" id="data_uploader_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_uploader_menu').toggle('fast');$('#active_data_uploader').html($(this).html());$('#selected_data_uploader').val(1);fetch_script('_codes/pipat_uploader.php','data_uploader_holder');">PIPAT Main</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_uploader_menu').toggle('fast');$('#active_data_uploader').html($(this).html());$('#selected_data_uploader').val(2);fetch_script('_codes/claims_tracker_uploader.php','data_uploader_holder');">PIPAT Claims Tracker</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_uploader_menu').toggle('fast');$('#active_data_uploader').html($(this).html());$('#selected_data_uploader').val(3);fetch_script('_codes/prep_uploader.php','data_uploader_holder');">PIPAT PrEP</div>
				
			</div>
			</div>
			<input type="hidden" id="selected_data_uploader" value="2">
		</div>
</div>
</div>

<div style="width:100%;min-height:30px;height:auto;float:left;" id="data_uploader_holder"></div>
</div>

<script>
fetch_script('_codes/prep_uploader.php','data_uploader_holder');
</script>