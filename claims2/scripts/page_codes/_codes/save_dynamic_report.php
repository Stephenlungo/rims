<?php
if($report_id){
	$this_report = mysqli_query($$module_connect,"select * from dynamic_reports where id = $report_id")or die(mysqli_error($$module_connect));
		
	$this_report_resuts = mysqli_fetch_array($this_report,MYSQLI_ASSOC);
	
	$title = $this_report_resuts['title'];
	$default_color = '#000';
	
	$report_accessibility_id = $this_report_resuts['accessibility'];
	
	if($report_accessibility_id){
		$report_accessibility_title = 'Accessible to me only';
		
	}else{
		$report_accessibility_title = 'Accessible to everyone';
		
	}
	
	$button_text = 'Update';
}else{
	$title = 'Enter report title here';
	$default_color = '#aaa';
	$report_accessibility_id = 0;
	$report_accessibility_title = 'Accessible to everyone';
	
	$button_text = 'Save';
}

?>


<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Title*:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($default_color);?>" value="<?php print($title);?>"  id="report_title" onfocus="if(this.value=='Enter report title here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter report title here';this.style.color='#aaa'}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Accessibility:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#report_accessibility_menu').toggle('fast');" id="active_report_accessibility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($report_accessibility_title);?></div>

			<div class="option_menu" id="report_accessibility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_accessibility_menu').toggle('fast');$('#active_report_accessibility').html($(this).html());$('#selected_report_accessibility').val(1);$('#error_message').slideUp('fast');">Accessible to me only</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_accessibility_menu').toggle('fast');$('#active_report_accessibility').html($(this).html());$('#selected_report_accessibility').val(0);$('#error_message').slideUp('fast');">Accessible to everyone</div>

			</div>
	</div>
	<input type="hidden" id="selected_report_accessibility" value="<?php print($report_accessibility_id);?>">
</div>
</div>

	<div style="width:100%;min-height:20px;line-height:20px;float:left;color:#f00;font-weight:bold;display:none;" id="save_report_error_message">Error comes here</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="finish_save_dynamic_report" onclick="process_save_dynamic_form();"><?php print($button_text);?></div>
