<?php
include 'image_uploader.php';
?>

<div style="width:400px;height:auto;margin:0 auto;padding:2px;margin-top:10px;">
<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;background-color:#eee;">Advanced Data Unloader</div>

<div style="width:100%;height:auto;line-height:20px;float:left;margin-bottom:10px;">Uploads PrEP client data. Consult administrators for file structure</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div class="option_lebel" style="font-weight:bold;width:70px;">Excel File:</div>
<div style="width:auto;height:30px;float:left;line-height:30px;color:green" id="tool_excel_file"></div>

<div style="width:60px;height:30px;background-color:#006bb3;color:#fff;text-align:center;line-height:30px;float:left;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#339db3';" onmouseout="this.style.backgroundColor='#006bb3';"  onclick="open_uploader('add_prep_uploaded_file()', 0);$('#new_error_message').slideUp('fast');">Add file</div>
</div>

<div style="width:100%;float:left;" >
<div class="option_lebel" style="font-weight:bold;width:80px;">Client ID Type:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#id_type_menu').slideToggle('fast');$('#new_error_message').slideUp('fast');" id="active_id_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Client PrEP ID</div>

<div class="option_menu" id="id_type_menu" style="display:none;z-index:1000;width:100px;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#id_type_menu').fadeOut('fast');$('#selected_id_type').val(0);$('#active_id_type').html($(this).html());" style="min-width:100px;">Client PrEP ID</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#id_type_menu').fadeOut('fast');$('#selected_id_type').val(1);$('#active_id_type').html($(this).html());" style="min-width:100px;">Client name</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#id_type_menu').fadeOut('fast');$('#selected_id_type').val(2);$('#active_id_type').html($(this).html());" style="min-width:100px;">Client NRC</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#id_type_menu').fadeOut('fast');$('#selected_id_type').val(3);$('#active_id_type').html($(this).html());" style="min-width:100px;">Client phone</div>

<input type="hidden" id="selected_id_type" value="0">
</div>
</div>

<div style="width:100%;height:auto;float:left;">
<div class="option_lebel" style="font-weight:bold;width:110px;">Data-set to affect:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#data_set_menu').slideToggle('fast');$('#new_error_message').slideUp('fast');" id="active_data_set" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Last data-set</div>

<div class="option_menu" id="data_set_menu" style="display:none;z-index:1000;width:100px;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_set_menu').fadeOut('fast');$('#selected_data_set').val(0);$('#active_data_set').html($(this).html());" style="min-width:100px;">Last data-set</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#data_set_menu').fadeOut('fast');$('#selected_data_set').val(1);$('#active_data_set').html($(this).html());" style="min-width:100px;">First data-set</div>

<input type="hidden" id="selected_data_set" value="0">
</div>
</div>
</div>

<?php
if($active_user_roles[8]){
	?>
<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:20px;">

	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="process_prep_file_button" onclick="process_prep_uploader();">Process</div>
	</div>
	
	<?php
}
?>
</div>