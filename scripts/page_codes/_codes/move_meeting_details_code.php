
<div style="width:100%;height:30px;line-height:30px;float:left;color:#006bb3;margin-top:10px;">Move participants to another meeting</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:140px;height:30px;line-height:30px;float:left;">Meeting ID to move to:</div>
<div style="width:170px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#aaa;" value="Enter new meeting ID here"  id="new_meeting_id" onfocus="if(this.value=='Enter new meeting ID here'){this.value='';this.style.color='#000'};this.style.borderColor='#aaa';if($('#meeting_check_holder_details').html() != ''){$('#check_meeting_holder').slideDown('fast');}" onfocusout="if(this.value==''){this.value='Enter new meeting ID here';this.style.color='#aaa'}" onkeyup="if(event.keyCode == 13){check_meeting_code()}"></div> <div style="width:70px;height:30px;line-height:30px;float:right;text-align:center;margin-left:2px;cursor:pointer;background-color:purple;color:#fff;" onclick="check_meeting_code()" id="meeting_code_check_button">Check</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:10px;font-weight:bold;display:none;" id="moving_to_holder" onclick="if($('#moving_to_holder').html() != ''){$('#check_meeting_holder').slideDown('fast');}"></div>

<div style="width:100%;height:auto;float:left;display:none;" id="check_meeting_holder"><div style="width:100%;height:auto;float:left;background-color:#eef;"><div style="width:120px;min-height:20px;float:left;">Meeting code</div><div style="width:260px;min-height:20px;height:auto;float:left;">Meeting title</div></div>

<div style="width:100%;height:auto;float:left;overflow:auto;" id="meeting_check_holder_details"></div>
</div>
<input type="hidden" id="new_meeting_id_input" value="0">
<div style="width:100%;height:auto;float:left;display:none;margin-top:10px;" id="move_meeting_now_holder">
<div style="width:100px;height:30px;background-color:006bb3;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#3592d0';" onmouseout="this.style.backgroundColor='006bb3';"  id="move_participants_meeting_button" onclick="confirm_move_meeting_participants(<?php print($meeting_id);?>);" title="Click to update account details">Move now</div>

</div>