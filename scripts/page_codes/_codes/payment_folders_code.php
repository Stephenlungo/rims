<div style="width:100%;height:30px;line-height:30px;float:left;" id="folder_level_holder">

<div style="width:70px;height:30px;float:left;text-align:center;background-color:#dde;border-radius:0px 20px 20px 0px;cursor:pointer;" onclick="fetch_payment_folder_content(0,0)" onmouseover="this.style.backgroundColor='#ccd';" onmouseout="this.style.backgroundColor='#dde';" id="level_folder_0">Root</div>



</div>

<input type="hidden" id="current_folder_id" value="0">
<input type="hidden" id="folder_level" value="0">
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div style="width:100%;height:20px;line-height:20px;">
<div style="width:140px;height:20px;float:left;line-height:20px;" id="folder_list_status_bar"><strong>Records found:</strong> (Counting...)</div><div style="width:150px;height:20px;float:left;line-height:20px;margin-left:5px;" id="folder_list_selected_bar"> <font color="brown">Clear</font></div><div style="width:auto;float:left;display:none;" id="payment_folder_edit_options"><div style="width:210px;height:20px;line-height:20px;float:left;background-color:#ddf;text-align:center;cursor:pointer;margin-left:10px;" onmouseover="this.style.backgroundColor='#bbf'" onmouseout="this.style.backgroundColor='#ddf'" onclick="batch_folder_agents(0)" id="batch_flder_agents_button">Batch agents and create claim</div><div style="width:90px;height:20px;line-height:20px;float:left;background-color:#ded;text-align:center;cursor:pointer;margin-left:50px;" onmouseover="this.style.backgroundColor='#cdc'" onmouseout="this.style.backgroundColor='#ded'" onclick="add_agents_to_folder()">Edit agents</div><div style="color:#fff;width:150px;height:20px;line-height:20px;float:left;background-color:#cb5656;text-align:center;cursor:pointer;margin-left:5px;display:none;" onmouseover="this.style.backgroundColor='#db6b6b'" onmouseout="this.style.backgroundColor='#cb5656'" onclick="#ddf">Remove selected agents</div><div style="margin-left:50px;width:115px;height:20px;line-height:20px;float:right;background-color:#a64d79;text-align:center;cursor:pointer;color:#fff;" onmouseover="this.style.backgroundColor='#c27ba0'" onmouseout="this.style.backgroundColor='#a64d79'" onclick="fetch_payment_folder_details(0,0);" id="edit_payment_folder_button">View folder details</div></div><div style="width:75px;height:20px;line-height:20px;float:right;background-color:#ddf;text-align:center;cursor:pointer;margin-left:5px;" onmouseover="this.style.backgroundColor='#bbf'" onmouseout="this.style.backgroundColor='#ddf'" onclick="fetch_payment_folder_details(0);">Add folder</div></div></div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="activity_list_header"><div style="width:20px;height:20px;float:left;"></div><div style="width:20px;height:20px;float:left;"></div><div style="width:250px;height:20px;float:left;margin-right:3px;">Title/Agent</div>
<div style="width:150px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:60px;height:20px;float:left;margin-right:3px;">Items</div></div>

<div style="width:100%;height:auto;float:left;" id="payment_folder_holder"></div>


<script>
fetch_payment_folder_content(0,'0');
</script>