<div style="width:500px;height:300px;margin:0 auto;margin-top:20px;border:solid 1px #eee;padding:5px;">
<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">File type:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#file_type_menu').toggle('fast');" id="active_file_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">CSV (Comma delimited)</div>

			<div class="option_menu" id="file_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#file_type_menu').toggle('fast');$('#active_file_type').html($(this).html());$('#agent_selected_file_type').val(0);$('#new_agent_error_message').slideUp('fast');">CSV (Comma delimited)</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#file_type_menu').toggle('fast');$('#active_file_type').html($(this).html());$('#agent_selected_file_type').val(1);$('#new_agent_error_message').slideUp('fast');">SQL</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#file_type_menu').toggle('fast');$('#active_file_type').html($(this).html());$('#selected_file_type').val(2);$('#new_agent_error_message').slideUp('fast');">PDF</div>
			
			</div>
	</div>
	
	<input type="hidden" id="selected_file_type" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Data:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#data_menu').toggle('fast');" id="active_data" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Report entries</div>

			<div class="option_menu" id="data_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_menu').toggle('fast');$('#active_data').html($(this).html());$('#selected_data').val('_data_new');">Report entries</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_menu').toggle('fast');$('#active_data').html($(this).html());$('#selected_data').val('agents');">Agent list</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_menu').toggle('fast');$('#active_data').html($(this).html());$('#selected_data').val('facilities');">Facility list</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_menu').toggle('fast');$('#active_data').html($(this).html());$('#selected_data').val('users');">User list</div>
			
			</div>
	</div>
	
	<input type="hidden" id="selected_data" value="_data_new">
</div>
</div>

<div style="width:70px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="export_download_button" onclick="process_data_download();" title="Click to update account details">Download</div>
</div>