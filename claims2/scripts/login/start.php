<?php
$login_title = $login_array[0];
$img_url = $login_array[1];
$logo = $login_array[2];
$site_url = $login_array[3];
$table = $login_array[4];
$query_resource = $login_array[5];

$limit_attempts = $login_array[7];
$allowed_attempts = $login_array[8];
$action_on_limit = $login_array[9];
$reattempt_delay = $login_array[10];
$delay_interval = $login_array[11];
$password_reset = $login_array[12];
$password_strict = $login_array[13];
$password_length = $login_array[14];


$code_url = 'http://www.blueraysit.com/';
$connection = $query_resource;
$function_name = 'signin_user';

$bottom_notes_url = '<div style="width:300px;float:left;font-size:0.9em;"><div style="width:100%;height:auto;float:left;margin-top:10px;"><div style="line-height:30px;width:auto;height:30px;float:right;text-align:right;font-size:0.9em;">&#0169; BlueRays Software</div></div></div>';
?>
<div style="width:850px;min-height:480px;height:auto;margin:0 auto;margin-top:90px;background-color:#fff;" id="login_holder">
<div style="width:450px;height:480px;float:left;border-right:solid 1px #eee;" id="login_image_holder">
<img src="" width="100%;" height="100%" id="active_home_image" style="display:none;">
</div>
<input type="hidden" id="img_url" value="<?php print($img_url);?>">
<div style="width:390px;height:auto;float:right;">
<?php
include 'signin.php';
?>
</div>
</div>

<script>
animate_home_image();
if(window.innerWidth < 850){
	$('#login_holder').css('width','400px');
	$('#login_image_holder').hide('fast');
}
</script>

<input type="hidden" id="login_delay" value="0">
<input type="hidden" id="current_login_delay_time" value="0">