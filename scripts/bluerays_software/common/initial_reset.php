<div style="width:410px;height:auto;margin:0 auto;margin-top:40px;">
<div style="width:410px;min-height:480px;height:auto;margin:0 auto;margin-top:60px;background-color:#fff;text-align:center;">
<input type="hidden" id="connection" value="connect">
<input type="hidden" id="table_name" value="users">
<input type="hidden" id="this_user_id" value="<?php print($user_id_vars[1]);?>">
<input type="hidden" id="admin_request" value="1">
<input type="hidden" id="reset_var" value="<?php print($reset_vars[1]);?>">
	
		<div style="width:100%;height:100px;line-height:50px;border-bottom:solid 1px #eee;">
			<div style="width:70px;height:70px;margin: 0 auto;"><img src="<?php print($url);?>imgs/jsi_logo.png" style="height:70px;width:70px;"></div>
			<div style="width:100%;height:30px;line-height:30px;float:left;font-size:1.4em;">Welcome to RIMS 2.0</div>
			<div style="width:100%;height:20px;line-height:20px;float:left;color:#666;font-size:1.1em">"Easy | Fast | Reliable"</div>
		</div>
		
		
		
		<?php
		
		if($user_found != 1 || $invalid_code != 0){
			?>
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;font-size:1em;margin-top:10px;color:#006bb3">Hi, <?php print($reset_username);?><br>You requested to have your password reset</div>
			
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;font-size:1em;margin-top:10px;color:#f00"><?php print($error_message);?></div>
			
			<div style="width:100%;height:30px;float:left;margin-top:10px;">
				<div style="width:70px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;margin:0 auto;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="window.open($('#url').val(),'_self');">Login</div>
			</div>
			
			<?php
		}else{
			
			?>
			<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;font-size:1em;margin-top:10px;color:#006bb3">Hi, <?php print($reset_username);?><br>You requested to have your password reset. Please enter your new password below:</div>
			<div style="width:100%;height:auto;float:left;margin-top:10px;" id="configuration_steps">
			
			<div style="width:300px;float:left;">
				<div style="line-height:20px;width:100%;height:20px;float:left;text-align:left;">New password:</div>
				<div style="width:100%;height:30px;float:left;"><input onfocusout="if(this.value==''){this.value='<?php print($new_password);?>';}" style="border:solid 1px #aaa;height:30px;width:100%;" type="text" id="reset_password" value="<?php print($new_password);?>"></div>
			</div>

			<div style="width:300px;float:left;margin-top:10px;">
				<div style="line-height:20px;width:100%;height:20px;float:left;text-align:left;">Re-enter password:</div>
				<div style="width:100%;height:30px;float:left;"><input onfocusout="if(this.value==''){this.value='<?php print($new_password);?>';}" style="border:solid 1px #aaa;height:30px;width:100%;" type="text" id="reset_password2" value="<?php print($new_password);?>"></div>
			</div>


			<div style="width:300px;height:30px;float:left;margin-top:10px;">
				<div style="width:70px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="process_password_reset();" id="password_reset_button">Reset</div>
			</div>
		
		
			<div style="width:100%;height:auto;float:left;margin-top:20px;display:none;color:red;" id="error_message"></div>
			
			</div>
			<?php
		}
		?>
		
		<div style="width:100%;height:40px;line-height:15px;float:left;font-size:0.8em;margin-top:10px;color:#666">By USAID DISCOVER - Health<br>Zambia</div>
</div>

</div>