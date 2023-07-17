<div style="width:auto;height:auto;float:left;">
	<div style="width:50px;height:30px;line-height:30px;float:left;">Status:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
	
	<div class="option_item" title="Click to change option" onclick="$('#analytical_survey_status_menu').toggle('fast');" id="active_analytical_survey_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Active</div>

	<div class="option_menu" id="analytical_survey_status_menu" style="display:none;min-width:120px;width:auto;">
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#analytical_survey_status_menu').toggle('fast');$('#active_analytical_survey_status').html($(this).html());$('#selected_analytical_survey_status').val(1);$('#active_survey').html('All surveys');">Active</div>
	
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#analytical_survey_status_menu').toggle('fast');$('#active_wifi').html($(this).html());$('#selected_analytical_survey_status').val(0);$('#active_survey').html('All surveys');">Inactive</div>
	
	
	</div>
	</div>
	<input type="hidden" id="selected_analytical_survey_status" value="1">
</div>
	
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_analytical_surveys()" title="Click to fetch report with specified options">Fetch</div>