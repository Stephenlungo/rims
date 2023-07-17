
<div style="display:none;margin-top:10px;width:980px;height:450px;position:absolute;z-index:10;" id="image_uploader">
<div class="window_holder">


<div class="window_title_bar" id="uploader_window_title" style="">Simple file uploader

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="reset_image_upload();close_window('image_uploader');" id="close_uploader_button">X</div>
</div>
<div class="window_container" style="height:450px;">
<div style="margin-left:4px;width:98%;min-height:30px;height:auto;line-height:30px;float:left;margin-top:20px;color:black;" id="uploader_title">
Select files to upload bellow;
</div>
<div style="margin-left:4px;width:98%;min-height:20px;height:auto;float:left;color:brown;margin-bottom:20px;">
Please note that smaller files are easier to download. We, therefore, recommend that EACH file be less than 1MB.
</div>

<div style="width:380px;float:left;padding:4px;" id="image_fields">
<div style="width:250px;height:30px;float:left;margin-bottom:10px;" id="image_0_holder"><input type="file" name="image_0"  id="image_0" style="height:30px;" onchange="tmp_single_upload(<?php print($company_id);?>,0);"></div>

<div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:red;" id="image_0_error"></div>

<div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:#000;" id="image_0_progress"><img src="imgs/loading.gif" style="height:20px;float:left;"> <div style="margin-left:6px;width:auto;height:20px;line-height:20px;float:left;">Uploading image... Please wait</div></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="uploader_error_message"></div>

<div style="margin-left:4px;width:70px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';" onclick="add_upload_field()" id="uploader_more_images">Add more</div>

<div style="margin-left:4px;width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="tmp_image_upload();" id="save_upload_images">Finish</div>

</div>
</div>
</div>