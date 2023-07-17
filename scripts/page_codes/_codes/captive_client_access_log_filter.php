<div style="width:auto;height:auto;float:left;">
<div style="width:40px;height:30px;line-height:30px;float:left;">WI-FI:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<div class="option_item" title="Click to change option" onclick="$('#wifi_menu').toggle('fast');" id="active_wifi" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select option</div>

		<div class="option_menu" id="wifi_menu" style="display:none;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_menu').toggle('fast');$('#active_wifi').html($(this).html());$('#selected_wifi').val(0);$('#active_survey').html('All surveys');fetch_menu_items('connect','prep_questionnaires','module_id',4,'survey',1,1,'');">All WIFI's</div>
		
		<?php
		
			if($branch_id == 0){
				$branch_search = '';
				
			}else{
				$branch_search = ' and branch_id = '.$branch_id;
				
			}
			
			$wifi_menu = mysqli_query($connect,"select * from wifis where company_id = $company_id $branch_search order by title")or die(mysqli_error($connect));

			for($u=0;$u<mysqli_num_rows($wifi_menu);$u++){
				$wifi_menu_results = mysqli_fetch_array($wifi_menu,MYSQLI_ASSOC);
				
				if(!$wifi_menu_results['status']){
					$wifi_title = $wifi_menu_results['title'].'[Disabled]';
					
				}else{
					$wifi_title = $wifi_menu_results['title'];
					
				}
				
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_menu').toggle('fast');$('#active_wifi').html($(this).html());$('#selected_wifi').val(<?php print($wifi_menu_results['id']);?>);fetch_menu_items('connect','prep_questionnaires','wifi_id',<?php print($wifi_menu_results['id']);?>,'survey',1,1,'');"><?php print($wifi_title);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_wifi" value="0">
		</div>
		
		<div style="width:auto;height:auto;float:left;">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Survey:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<div class="option_item" title="Click to change option" onclick="$('#survey_menu').toggle('fast');" id="active_survey" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select option</div>

		<div class="option_menu" id="survey_menu" style="display:none;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#survey_menu').toggle('fast');$('#active_survey').html($(this).html());$('#selected_survey').val(0);">All surveys</div>
		
		<?php
		
			$survey_menu = mysqli_query($connect,"select * from prep_questionnaires where company_id = $company_id and module_id = 4 $branch_search order by title")or die(mysqli_error($connect));

			for($u=0;$u<mysqli_num_rows($survey_menu);$u++){
				$survey_menu_results = mysqli_fetch_array($survey_menu,MYSQLI_ASSOC);
				
				if(!$survey_menu_results['status']){
					$survey_title = $survey_menu_results['title'].'[Disabled]';
					
				}else{
					$survey_title = $survey_menu_results['title'];
					
				}
				
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#survey_menu').toggle('fast');$('#active_survey').html($(this).html());$('#selected_survey').val(<?php print($survey_menu_results['id']);?>);"><?php print($survey_title);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_survey" value="0">
		</div>
		
		
		

		<div style="width:120px;height:30px;line-height:30px;float:left;">From (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_from" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;">To (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		
		
	
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_captive_client_access_log()" title="Click to fetch report with specified options">Fetch</div>
	<script>
	$( function() {
	$( "#date_from" ).datepicker();
	$( "#date_to" ).datepicker();
} );
</script>