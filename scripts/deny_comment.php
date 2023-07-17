<div style="display:none;width:380px;height:190px;position:absolute;z-index:2;margin-left:300px;" id="deny_comment">
<div class="window_holder" style="width:370px;">
<div class="window_title_bar" >Comment
<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('deny_comment');">X</div>
</div>
<input type="hidden" id="deny_claim_date" value="0">
<input type="hidden" id="deny_beneficiary_date" value="0">
<input type="hidden" id="deny_level" value="0">
<input type="hidden" id="deny_claim_type_date" value="0">


<div class="window_container" style="height:110px;width:99.5%;">
<div style="width:99%;height:30px;float:left;padding:2px;">
<div style="width:365px;float:left;">
<div style="line-height:30px;width:90px;height:30px;float:left;line-height:30px;">Comment:</div><div style="width:250px;height:30px;float:left;"><input type="text" style="height:24px;width:100%;color:#aaa;" id="item_comment" value="No comment added" onfocus="if(this.value=='No comment added'){this.value='';this.style.color='#000'}$('#new_user_error_message').hide('fast');" onfocusout="if(this.value==''){this.value='No comment added';this.style.color='#aaa';}"></div></div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_user_error_message"></div>

<div style="width:60px;height:30px;background-color:brown;color:#fff;margin-top:5px;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ff3333';" onmouseout="this.style.backgroundColor='brown';" onclick="confirm_deny_approval()" id="deny_button">Deny</div>
</div>
</div>
</div>