<div style="width:100%;height:auto;margin-top:10px;float:left;">
<div style="width:200px;height:30px;margin:0 auto;">
<div style="width:auto;height:auto;float:left;" id="unit_0_holder">
			<div style="width:40px;height:30px;line-height:30px;float:left;">Tool:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#tool_menu').toggle('fast');" id="active_tool" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">USSD</div>

			<div class="option_menu" id="tool_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#tool_menu').toggle('fast');$('#active_tool').html($(this).html());$('#selected_tool').val(0);fetch_script('_codes/data_mover.php','tool_holder');">Data Mover</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#tool_menu').toggle('fast');$('#active_tool').html($(this).html());$('#selected_tool').val(1);fetch_script('_codes/data_uploader.php','tool_holder');">Data Uploader</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#tool_menu').toggle('fast');$('#active_tool').html($(this).html());$('#selected_tool').val(2);fetch_script('_codes/ussd_loader.php','tool_holder');">USSD loader</div>
				
			</div>
			</div>
			<input type="hidden" id="selected_tool" value="2">
		</div>
</div>

<div style="width:100%;min-height:30px;height:auto;float:left;border-top:solid 1px #eee;" id="tool_holder"></div>


</div>
<script>
fetch_script('_codes/ussd_loader.php','tool_holder');
</script>