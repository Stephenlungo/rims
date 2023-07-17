<div style="cursor:pointer;width:100%;height:20px;line-height:20px;float:left;background-color:#ac77a5;color:#fff;text-align:center;margin-top:10px;" ><div style="width:180px;float:left;" onclick="$('#menu_holder').slideToggle('fast');animate_height();" title="Click to expand/collapse" onmouseover="this.style.backgroundColor='#ac77ee';" onmouseout="this.style.backgroundColor='#ac77a5';">PIPAT Live Chat</div><div style="margin:1.4px;background-color:#fff;width:15px;float:left;height:15px;float:right;border:solid 1px #fff;border-radius:2px;"><img src="imgs/search_icon.png" style="width:15px;height:15px;" title="Click to search for user" onclick="$('#chat_search').slideToggle('fast');$('#menu_holder').slideUp('fast');$('#chat_users').animate({maxHeight:(490) + 'px'},'fast');"></div></div>

<div style="width:100%;height:20px;float:left;background-color:#fff;display:none;" id="chat_search">
<input id="user_chat_search" type="text" style="width:100%;height:20px;color:#aaa;line-height:20px;" value="Enter name here" onfocus="if(this.value=='Enter name here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}">
</div>

<div style="width:100%;min-height:130px;max-height:130px;float:left;overflow:auto;background-color:#eee;" id="chat_users">
<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;color:#000;margin-top:20px;">Loading PIPAT chat...</div>

</div>
<input type="hidden" value="" id="selected_budges">
<script>

online_refresh(<?php print($user_id);?>);

function animate_height(){
	var div_height = $('#chat_users').css('max-height');
	div_height = div_height.replace('px','');
	
	if(div_height == 130){
		$('#chat_users').animate({maxHeight:(490) + 'px'},'fast');
		
	}else{		
		$('#chat_users').animate({maxHeight:(130) + 'px'},'fast');
		
	}
}

</script>