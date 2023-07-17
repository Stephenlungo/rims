<div style="width:100%;height:auto;float:left;<?php if(!isset($_COOKIE['recoveryMode'])){print('display:none;');}?>" id="recovery">

<div style="width:100%;height:auto;float:left;display:none;" id="password_recovery_step_2">

<input type="hidden" id="action" value="reset">
<input type="hidden" id="this_user_id" value="0">
<div style="width:300px;margin-top:40px;float:left;color:#006BB3;margin-bottom:10px;">Enter your new password bellow</div>

<div style="width:300px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Code:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter code from email'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter code from email';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" id="reset_code" value="Enter code from email"></div>
</div>

<div style="width:300px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">New password:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter your new password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter your new password';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="password" id="reset_password" value="Enter your new password"></div>
</div>

<div style="width:300px;float:left;margin-top:10px;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Re-enter password:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Re-enter your new password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Re-enter your new password';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="password" id="reset_password2" value="Re-enter your new password"></div>
</div>


<div style="width:300px;height:30px;float:left;margin-top:10px;">
<div style="width:70px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="process_password_reset();" id="password_reset_button">Reset</div>

<div style="width:120px;height:30px;color:#000;text-align:left;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="$('#password_recovery_step_1').slideDown('fast');$('#password_recovery_step_2').slideUp('fast');">Cancel</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;" id="password_recovery_step_1">

<input type="hidden" name="action" value="recover">
<div style="width:300px;margin-top:40px;float:left;color:#006BB3;margin-bottom:10px;">Enter registered user name to recover your password</div>
<div style="width:300px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Username:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter your login user name'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter your login user name';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" id="recovery_usermame" value="Enter your login user name"></div>
</div>


<div style="width:300px;height:30px;float:left;margin-top:10px;">
<div style="background-color:orange;float:left;" class="common_button" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="authenticateRecovery();" id="check_recovery_button">Continue</div>

<div style="color:#000;line-height:30px;text-align:center;cursor:pointer;float:left;height:30px;width:80px;z-index:1000;position:absolute;margin-left:80px"  onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="$('#recovery').slideUp('fast');$('#login').slideDown('fast');">Sign in</div>
</div>
</div>

</div>