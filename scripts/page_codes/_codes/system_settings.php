<?php

$settings_data = new_fetch_db_table('connect','settings',0,'id','');

$limit_login_attempts_id = $settings_data[1]['limit_attempts'][0];

$limit_login_attempts_title = "Don't limit";
$limit_attempts_holder = ' display:none;';
if($limit_login_attempts_id){
	$limit_login_attempts_title = "Limit";
	$limit_attempts_holder = '';
}

$allowed_login_attempts = $settings_data[1]['allowed_attempts'][0];

$action_on_limit_id = $settings_data[1]['action_on_limit'][0];
$action_on_limit_title = 'Block account and allow password reset';
if($action_on_limit_id == 1){
	$action_on_limit_title = "Block account. Nofify gloabal super administrators";
	
}else if($action_on_limit_id == 2){
	$action_on_limit_title = "Don't block account. Nofify gloabal super administrators";
}

$reattempt_delay_id = $settings_data[1]['reattempt_delay'][0];
$reattempt_delay_title = 'Off';
$delay_seconds_holder = 'display:none;';

if($reattempt_delay_id == 1){
	$reattempt_delay_title = 'Fixed delay';
	$delay_seconds_holder = '';
	
}else if($reattempt_delay_id == 2){
	$reattempt_delay_title = 'Incremental delay';
	$delay_seconds_holder = '';
}

$re_attempt_delay = $settings_data[1]['delay_interval'][0];

$allow_password_reset_id = $settings_data[1]['password_reset'][0];
$allow_password_reset_title = 'Disallow';
$password_strict_holder = 'Display:none;';

if($allow_password_reset_id == 1){
	$allow_password_reset_title = 'Allow';
	$password_strict_holder = '';
}

$password_strict_id = $settings_data[1]['password_strict'][0];
$password_strict_title = 'Off';
if($password_strict_id == 1){
	$password_strict_title = 'Strict 1 - require at-least one uppercase';
	
}else if($password_strict_id == 2){
	$password_strict_title = 'Strict 2 - require uppercase and special charactor';	
}

$password_length = $settings_data[1]['password_length'][0];
$username_length = $settings_data[1]['username_length'][0];

$password_expiry_id = $settings_data[1]['password_expiry'][0];
$password_expiry_title = 'Off';
$expiry_period_holder = 'display:none;';
if($password_expiry_id == 1){
	$password_expiry_title = 'On';
	$expiry_period_holder = '';
}
$password_expiry_period = $settings_data[1]['password_expiry_period'][0];

$url_password_reset_id = $settings_data[1]['url_password_reset'][0];
$url_password_reset_title = 'Disallow';
$url_password_expiry_period_display = 'display:none;';
if($url_password_reset_id == 1){
	$url_password_reset_title = 'Allow';
	$url_password_expiry_period_display = '';
}

$url_password_reset_period = $settings_data[1]['url_password_reset_period'][0];

$auto_backup_id = $settings_data[1]['auto_backup'][0];
$auto_backup_title = 'Off';
$backup_interval_holder = 'display:none;';

if($auto_backup_id){
	$auto_backup_title = 'On';
	$backup_interval_holder = '';
}
$backup_interval_id = $settings_data[1]['backup_interval'][0];
if($backup_interval_id == 0){
	$backup_interval_title = 'Daily';
	
}else if($backup_interval_id == 1){
	$backup_interval_title = 'Weekly';
	
}else if($backup_interval_id == 2){
	$backup_interval_title = 'Monthly';
	
}

$backup_time = $settings_data[1]['backup_time'][0];
if(!$backup_time){
	$hour = '00';
	$minute = '00';
	$second = '00';
	
}else{
	$backup_time_array = explode('/',$settings_data[1]['backup_time'][0]);
	$hour = $backup_time_array[0];
	$minute = $backup_time_array[1];
	$second = $backup_time_array[2];
}
?>


<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:10px;font-size:1.3em">Login  settings</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Limit login attempts:</div>
<div style="width:130px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#limit_login_attempts_menu').toggle('fast');" id="active_limit_login_attempts" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($limit_login_attempts_title);?></div>		
		
		<div class="option_menu" id="limit_login_attempts_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_login_attempts_menu').toggle('fast');$('#active_limit_login_attempts').html($(this).html());$('#selected_limit_login_attempts').val(0);$('#limit_attempts_holder').slideUp('fast');">Don't limit</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_login_attempts_menu').toggle('fast');$('#active_limit_login_attempts').html($(this).html());$('#selected_limit_login_attempts').val(1);$('#limit_attempts_holder').slideDown('fast');">Limit</div>
		</div>
	</div>
	<input type="hidden" id="selected_limit_login_attempts" value="<?php print($limit_login_attempts_id);?>">
</div>

<div style="width:auto;float:left;height:auto;<?php print($limit_attempts_holder);?>" id="limit_attempts_holder">
<div style="width:105px;height:30px;line-height:30px;float:left;">Allowed attempts:</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($allowed_login_attempts);?>"  id="allowed_attempts" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($allowed_login_attempts);?>';}"></div>

<div style="width:90px;height:30px;line-height:30px;float:left;margin-left:10px;">Action on limit:</div>
<div style="width:380px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#action_on_limit_attempts_menu').toggle('fast');" id="active_action_on_limit_attempts" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:130px;max-width:380px;width:auto;"><?php print($action_on_limit_title);?></div>		
		
		<div class="option_menu" id="action_on_limit_attempts_menu" style="display:none;min-width:150px;max-width:380px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_on_limit_attempts_menu').toggle('fast');$('#active_action_on_limit_attempts').html($(this).html());$('#selected_action_on_limit_login_attempts').val(0);">Block account and allow password reset</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_on_limit_attempts_menu').toggle('fast');$('#active_action_on_limit_attempts').html($(this).html());$('#selected_action_on_limit_login_attempts').val(1);">Block account. Nofify gloabal super administrators</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#action_on_limit_attempts_menu').toggle('fast');$('#active_action_on_limit_attempts').html($(this).html());$('#selected_action_on_limit_login_attempts').val(2);">Don't block account. Nofify gloabal super administrators</div>
		</div>
	</div>
	<input type="hidden" id="selected_action_on_limit_login_attempts" value="<?php print($action_on_limit_id);?>">
</div>
</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Re-attempt delay:</div>
<div style="width:130px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#attempts_delay_menu').toggle('fast');" id="active_attempts_delay" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($reattempt_delay_title);?></div>		
		
		<div class="option_menu" id="attempts_delay_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#attempts_delay_menu').toggle('fast');$('#active_attempts_delay').html($(this).html());$('#selected_attempts_delay').val(0);$('#delay_seconds_holder').slideUp('fast');">Off</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#attempts_delay_menu').toggle('fast');$('#active_attempts_delay').html($(this).html());$('#selected_attempts_delay').val(1);$('#delay_seconds_holder').slideDown('fast');">Fixed delay</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#attempts_delay_menu').toggle('fast');$('#active_attempts_delay').html($(this).html());$('#selected_attempts_delay').val(2);$('#delay_seconds_holder').slideDown('fast');">Incremental delay</div>
		</div>
	</div>
	<input type="hidden" id="selected_attempts_delay" value="<?php print($reattempt_delay_id);?>">
</div>

<div style="width:auto;float:left;height:auto;<?php print($delay_seconds_holder);?>" id="delay_seconds_holder">
<div style="width:105px;height:30px;line-height:30px;float:left;">Delay seconds:</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($re_attempt_delay);?>"  id="delay_interval" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($re_attempt_delay);?>';}"></div></div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Password reset:</div>
<div style="width:130px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#password_reset_menu').toggle('fast');" id="active_password_reset" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($allow_password_reset_title);?></div>		
		
		<div class="option_menu" id="password_reset_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_reset_menu').toggle('fast');$('#active_password_reset').html($(this).html());$('#selected_password_reset').val(0);">Disallow</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_reset_menu').toggle('fast');$('#active_password_reset').html($(this).html());$('#selected_password_reset').val(1);">Allow</div>
		</div>
	</div>
	<input type="hidden" id="selected_password_reset" value="<?php print($allow_password_reset_id);?>">
</div>

<div style="width:105px;height:30px;line-height:30px;float:left;">Username length:</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($username_length);?>"  id="username_length" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($username_length);?>';}"></div>

<div style="width:100%;float:left;height:auto;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Password strict:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#password_strict_menu').toggle('fast');" id="active_password_strict" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:410px;width:auto;"><?php print($password_strict_title);?></div>		
		
		<div class="option_menu" id="password_strict_menu" style="display:none;min-width:150px;max-width:410px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_strict_menu').toggle('fast');$('#active_password_strict').html($(this).html());$('#selected_password_strict').val(0);">Off</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_strict_menu').toggle('fast');$('#active_password_strict').html($(this).html());$('#selected_password_strict').val(1);">Strict 1 - require at-least one uppercase</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_strict_menu').toggle('fast');$('#active_password_strict').html($(this).html());$('#selected_password_strict').val(2);">Strict 2 - require uppercase and special charactor</div>
		</div>
	</div>
	<input type="hidden" id="selected_password_strict" value="<?php print($password_strict_id);?>">
</div>

<div style="width:105px;height:30px;line-height:30px;float:left;">Password length:</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($password_length);?>"  id="password_length" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($password_length);?>';}"></div>
</div>

<div style="width:100%;float:left;height:auto;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Password expiry:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#password_expiry_menu').toggle('fast');" id="active_password_expiry" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:410px;width:auto;"><?php print($password_expiry_title);?></div>		
		
		<div class="option_menu" id="password_expiry_menu" style="display:none;min-width:150px;max-width:410px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_expiry_menu').toggle('fast');$('#active_password_expiry').html($(this).html());$('#selected_password_expiry').val(0);$('#expiry_period_holder').slideUp('fast')">Off</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#password_expiry_menu').toggle('fast');$('#active_password_expiry').html($(this).html());$('#selected_password_expiry').val(1);$('#expiry_period_holder').slideDown('fast');">On</div>
		</div>
	</div>
	<input type="hidden" id="selected_password_expiry" value="<?php print($password_expiry_id);?>">
</div>

<div style="width:auto;height:auto;float:left;<?php print($expiry_period_holder);?>" id="expiry_period_holder">
<div style="width:120px;height:30px;line-height:30px;float:left;">Expiry period (days):</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($password_expiry_period);?>"  id="password_expiry_period" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($password_expiry_period);?>';}"></div>
</div>
</div>

<div style="width:100%;float:left;height:auto;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Allow URL reset:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#url_password_reset_menu').toggle('fast');" id="active_url_password_reset" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:410px;width:auto;"><?php print($url_password_reset_title);?></div>		
		
		<div class="option_menu" id="url_password_reset_menu" style="display:none;min-width:150px;max-width:410px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#url_password_reset_menu').toggle('fast');$('#active_url_password_reset').html($(this).html());$('#selected_url_password_reset').val(0);$('#url_password_expiry_period_holder').slideUp('fast')">Disallow</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#url_password_reset_menu').toggle('fast');$('#active_url_password_reset').html($(this).html());$('#selected_url_password_reset').val(1);$('#url_password_expiry_period_holder').slideDown('fast');">Allow</div>
		</div>
	</div>
	<input type="hidden" id="selected_url_password_reset" value="<?php print($url_password_reset_id);?>">
</div>

<div style="width:auto;height:auto;float:left;<?php print($url_password_expiry_period_display);?>" id="url_password_expiry_period_holder">
<div style="width:150px;height:30px;line-height:30px;float:left;">URL expiry period (Hrs):</div>
<div style="width:90px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="<?php print($url_password_reset_period);?>"  id="url_password_reset_period" onfocus="if(this.value==0){this.value='';}" onfocusout="if(this.value=='' || isNaN(this.value)){this.value='<?php print($url_password_reset_period);?>';}"></div>
</div>
</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:10px;font-size:1.3em">System backup settings</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:120px;height:30px;line-height:30px;float:left;">Auto-backup:</div>
<div style="width:130px;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#auto_backup_menu').toggle('fast');" id="active_auto_backup" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($auto_backup_title);?></div>		
		
		<div class="option_menu" id="auto_backup_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#auto_backup_menu').toggle('fast');$('#active_auto_backup').html($(this).html());$('#selected_auto_backup').val(1);$('#backup_interval_holder').slideDown('fast');">On</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#auto_backup_menu').toggle('fast');$('#active_auto_backup').html($(this).html());$('#selected_auto_backup').val(0);$('#backup_interval_holder').slideUp('fast');">Off</div>
		</div>
	</div>
	<input type="hidden" id="selected_auto_backup" value="<?php print($auto_backup_id);?>">
</div>

<div style="width:auto;float:left;height:auto;<?php print($backup_interval_holder);?>" id="backup_interval_holder">
<div style="width:100px;height:30px;line-height:30px;float:left;margin-left:10px;">Backup interval:</div>
<div style="width:auto;min-height:30px;height:auto;float:left;line-height:30px;">
	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#backup_interval_menu').toggle('fast');" id="active_backup_interval" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:auto;"><?php print($backup_interval_title);?></div>		
		
		<div class="option_menu" id="backup_interval_menu" style="display:none;width:auto;">			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#backup_interval_menu').toggle('fast');$('#active_backup_interval').html($(this).html());$('#selected_backup_interval').val(0);">Daily</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#backup_interval_menu').toggle('fast');$('#active_backup_interval').html($(this).html());$('#selected_backup_interval').val(1);">Weekly</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#backup_interval_menu').toggle('fast');$('#active_backup_interval').html($(this).html());$('#selected_backup_interval').val(2);">Monthly</div>
		</div>
	</div>
	<input type="hidden" id="selected_backup_interval" value="<?php print($backup_interval_id);?>">
</div>


<div style="width:auto;float:left;margin-left:5px;">
<div style="width:90px;height:30px;line-height:30px;float:left;color:#006bb3">Backup Time:</div>
<div style="line-height:30px;width:50px;height:30px;float:left;">Hour:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_hour_menu').toggle('fast');" id="active_from_hour" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($hour);?></div>

<div class="option_menu" id="from_hour_menu" style="display:none;">
<?php
	for($d=0;$d<24;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_hour_menu').toggle('fast');$('#active_from_hour').html($(this).html());$('#selected_from_hour').val('<?php print($do);?>');" style="width:40px;"><?php print($do);?></div>
	<?php
	}
?>
</div>
<input type="hidden" name="selected_from_hour" id="selected_from_hour" value="<?php print($hour);?>">
</div>

<div style="line-height:30px;width:60px;height:30px;float:left;">Minute:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_minute_menu').toggle('fast');" id="active_from_minute" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($minute);?></div>

<div class="option_menu" id="from_minute_menu" style="display:none;">
<?php
	for($m=0;$m<60;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_minute_menu').toggle('fast');$('#active_from_minute').html($(this).html());$('#selected_from_minute').val(<?php print($mo);?>);" style="width:40px;"><?php print($mo);?></div>
		<?php
	}
?>
</div>
<input type="hidden" name="selected_from_minute" id="selected_from_minute" value="<?php print($minute);?>">
</div>

<div style="line-height:30px;width:60px;height:30px;float:left;">Second:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_second_menu').toggle('fast');" id="active_from_second" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($second);?></div>


<div class="option_menu" id="from_second_menu" style="display:none;width:65px;">
<?php
	for($s=0;$s>60;$s++){
		if($s<10){
			$so='0'.$s;
		}else{
			$so = $m;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_second_menu').toggle('fast');$('#active_from_second').html($(this).html());$('#selected_from_second').val(<?php print($so);?>);" style="width:50px;"><?php print($so);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_from_second" id="selected_from_second" value="<?php print($second);?>">
</div>

</div>
</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_settings_button" onclick="update_system_settings();" title="Click to update system settings">Update</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:10px;font-size:1.3em">Database partitioning</div>
<?php
$table_partitions = new_fetch_db_table('connect','table_partitions',$company_id,'period_from desc','');

$user_array = new_fetch_db_table('connect','users',$company_id,'id','');


$sizes = mysqli_query($connect,"SELECT table_name AS 'table',
ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'size'
FROM information_schema.TABLES
WHERE table_schema = '$this_pipat_main_database_name'
ORDER BY (data_length + index_length) DESC;");

$table_array = array();
for($s=0;$s<mysqli_num_rows($sizes);$s++){
	$sizes_results = mysqli_fetch_array($sizes,MYSQLI_ASSOC);
	
	$table_array[0][$s] = $sizes_results['table'];
	$table_array[1][$s] = $sizes_results['size'];
}
for($dp=0;$dp<count($default_partition_names);$dp++){
	$partition_type = $dp;
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;border-bottom:solid 1px #fff;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddf'" onmouseout="this.style.backgroundColor='#eef'" onclick="$('#partition_holder_<?php print($dp);?>').slideToggle('fast');"><?php print($default_partition_names[$dp][0]);?></div>

	<div style="width:100%;height:auto;float:left;display:none;margin-bottom:30px;" id="partition_holder_<?php print($dp);?>">
	<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:2px;margin-bottom:2px;"><?php if($active_user_roles[8]){?>
	<div style="width:100%;height:20px;float:left;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_item_details('partition','<?php print($partition_type.'-0');?>','','','<?php print($default_partition_names[$dp][0]);?> partition Details','',1);">Add</div></div>
	<?php
	}
	?></div>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;background-color:#ddd;">
		<div style="width:150px;float:left;">Date</div>
		<div style="width:150px;float:left;">Date from</div>
		<div style="width:150px;float:left;">Date to</div>
		<div style="width:80px;float:left;">Size</div>
		<div style="width:300px;float:left;">User</div>
		<div style="width:145px;float:left;">Comments</div>
	</div>
	<?php
	
	$daily_reporting_index = array_keys($table_partitions[1]['_type'],$partition_type);
	if(isset($daily_reporting_index[0])){
		for($p=0;$p<count($daily_reporting_index);$p++){
			$user_index = array_keys($user_array[1]['id'],$table_partitions[1]['user_id'][$daily_reporting_index[$p]]);
			
			$this_user = '<i>User not found</i>';
			if(isset($user_index[0])){
				$this_user = $user_array[1]['_name'][0];
			}
			
			$table_size = 0;
			
			for($d=0;$d<count($default_partition_names[$partition_type][1]);$d++){
				$table_index = array_keys($table_array[0],$default_partition_names[$partition_type][1][$d].'_partition_'.$table_partitions[1]['partition_code'][$daily_reporting_index[$p]]);
				
				if(isset($table_index[0])){
					$table_size += $table_array[1][$table_index[0]];
				}
				
			}
			
			?>
			<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor=''" onclick="fetch_item_details('partition','<?php print($partition_type.'-'.$table_partitions[1]['id'][$daily_reporting_index[$p]]);?>','','','<?php print($default_partition_names[$dp][0]);?> partition details','',1);">
				<div style="width:150px;float:left;"><?php print(date('jS M, Y',$table_partitions[1]['_date'][$daily_reporting_index[$p]]));?></div>
				<div style="width:150px;float:left;"><?php print(date('jS M, Y',$table_partitions[1]['period_from'][$daily_reporting_index[$p]]));?></div>
				<div style="width:150px;float:left;"><?php print(date('jS M, Y',$table_partitions[1]['period_to'][$daily_reporting_index[$p]]));?></div>
				<div style="width:80px;float:left;"><?php print(number_format($table_size,2));?>MB</div>
				<div style="width:300px;float:left;"><?php print($this_user);?></div>
				<div style="width:145px;float:left;">N/A</div>
			</div>
			<?php
			
		}
	}

	$table_size = 0;
	for($d=0;$d<count($default_partition_names[$partition_type][1]);$d++){
		$table_index = array_keys($table_array[0],$default_partition_names[$partition_type][1][$d]);
		
		if(isset($table_index[0])){
			$table_size += $table_array[1][$table_index[0]];
		}
	}
	?>

	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;">
			<div style="width:150px;float:left;">N/A</div>
			<div style="width:150px;float:left;">N/A</div>
			<div style="width:150px;float:left;">N/A</div>
			<div style="width:80px;float:left;"><?php print($table_size);?>MB</div>
			<div style="width:300px;float:left;">N/A</div>
			<div style="width:145px;float:left;">Default storages (<?php print(count($default_partition_names[$partition_type][1]));?>)</div>
		</div>
	</div>

<?php
}
?>