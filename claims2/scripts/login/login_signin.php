<div style="width:100%;height:auto;float:left;" id="login">
<div style="width:300px;margin-top:40px;float:left;color:#006BB3;margin-bottom:10px;">Enter your login details bellow</div>
<div style="width:300px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">User name:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="clear_input_value($(this).attr('id'),'Enter your login user name');disalarm_input($(this).attr('id'));" onfocusout="refill_input_value($(this).attr('id'),'Enter your login user name');" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" id="login_username" value="Enter your login user name"  onkeyup="if (event.keyCode == 13) {authenticate_signin();}"></div>
</div>

<div style="width:300px;margin-top:10px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Password:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="clear_input_value($(this).attr('id'),'password');disalarm_input($(this).attr('id'));" onfocusout="refill_input_value($(this).attr('id'),'password');" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="password" id="login_password" value="password" onkeyup="if (event.keyCode == 13) {authenticate_signin();}"></div>
</div>



<div style="width:300px;height:30px;float:left;margin-top:10px;" id="login_section_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="authenticate_signin();" id="sign_in_button">Sign in</div>

<div style="width:120px;height:30px;color:#000;text-align:left;line-height:30px;float:left;margin-right:5px;cursor:pointer;<?php if(!$password_reset){print('display:none;');}?>" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="$('#recovery').slideDown('fast');$('#login').slideUp('fast');" id="forgot_password">Forgot password</div>
</div>
</div>