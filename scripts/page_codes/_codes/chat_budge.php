<div style="width:auto;height:auto;float:left;display:none;" id="chat_budge_holder">
<div style="display:none;width:250px;height:350px;margin-right:2px;float:left;border:solid 1px #fff;background-color:#eef;background-image:url('<?php print($code_url);?>/imgs/default_bg_images/chat_wallpaper3.jpg')" id="chat_0">
<div style="width:250px;height:35px;float:left;background-color:#999" id="chat_budge_title_0">
<div style="width:30px;height:30px;float:left;border:solid 1px #ddd;border-radius:5px;margin:1.5px;background-color:#fff;"><img src="" style="width:25px;height:25px;margin:2px;" id="chat_budge_image_0"></div>

<div style="width:180px;height:35px;float:left;margin-left:5px;" onclick="$('#chat_0').">
<div style="width:100%;height:20px;line-height:20px;float:left;color:#fff;" id="chat_budge_name_0"></div>

<div style="width:100%;height:15px;line-height:15px;float:left;color:#fff;font-size:0.8em;" id="chat_budge_location_0"></div>
</div>
<div style="cursor:pointer;float:right;width:20px;height:35px;background-color:brown;color:#fff;line-height:30px;text-align:center;" onmouseover="this.style.backgroundColor='red';" onmouseout="this.style.backgroundColor='brown';" onclick="remove_budge('_0');">X</div>
</div>

<div style="width:100%;height:240px;float:left;overflow:auto;" id="message_holder_0">

<div style="width:100%;height:30px;float:left;margin-top:10px;text-align:center;">Loading chat messages...</div>

</div>
<div style="display:none;cursor:pointer;width:250px;height:25px;line-height:25px;background-color:#999;color:#eee;text-align:center;position:absolute;margin-top:250px;" onclick="$('#message_holder_0').scrollTop($('#message_holder_0')[0].scrollHeight);$(this).fadeOut('fast');" id="new_messages_received_0">New messages received</div>
<input type="hidden" value="1" id="is_message_start_0">
<div style="width:100%;min-height:40px;height:auto;float:left;">
<textarea style="min-width:100%;max-width:100%;height:40px;max-height:40px;color:#888;font-family:arial;font-size:0.9em;" onfocus="if(this.value=='Type your message here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Type your message here';this.style.color='#888';}" id="message_0" onkeyup="if (event.keyCode == 13 && $('#enter_sends_0').val() == 1) {send_message('_0');}">Type your message here</textarea>
<input type="checkbox" id="enter_sends_input_0" checked onchange="if(this.checked){$('#enter_sends_0').val(1);}else{$('#enter_sends_0').val(0);}"><label for="enter_sends_input_0">Enter key sends</label>

<input type="hidden" value="1" id="enter_sends_0">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="send_message('_0');" id="send_message_button_0">Send</div>
</div>

</div>

</div>