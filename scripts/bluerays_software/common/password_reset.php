<?php
$http = 'http://';
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	$http = 'https://';
}
$url = $http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$url_array = explode('?',$url);
$url = $url_array[0];

$reset_vars = explode('-',$url_array[1]);

$user_id_vars = explode('=',$reset_vars[0]);

$new_password = 'JSIrims'.rand(100,999).'!';

$this_user_id = $user_id_vars[1];
$user_url = $url[1];
$this_user = mysqli_query($connect,"select * from users where id = $this_user_id")or die(mysqli_error($connect));
$settings = mysqli_query($connect,"select * from settings")or die(mysqli_error($connect));
$settings_results = mysqli_fetch_array($settings,MYSQLI_ASSOC);

$user_found = 0;
$invalid_code = 0;
$error_message = 'This link is not for your account.<br>Please contact system administrators to get another link';
$reset_username = 'Unknown user';
if(mysqli_num_rows($this_user)){
	$user_found = 1;
	$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
	
	$reset_username = $this_user_results['_name'];
	
	$Link_expiry_date = $this_user_results['password_reset_request_date'] + ($settings_results['url_password_reset_period'] * 60 * 60);

	if($this_user_results['password_reset_url'] != $this_user_id.'-'.$reset_vars[1]){
		$invalid_code = 1;
		$error_message = 'You entered an invalid URL or link has expired. <br>Contact system administrators.';
		
	}else if($Link_expiry_date < time()){
		$invalid_code = 2;
		$error_message = 'This link expired on '.date('dS M, Y',$Link_expiry_date).'.<br>Contact system administrators to get another link';
	}
}

?>

<div style="width:100%;height:auto;float:left;background-color:#fee;padding:2px;display:none;" id="main_error_output" ondblclick="$(this).slideUp('fast');" title="Double click to hide"></div>
<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml/">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, height=device-height,  initial-scale=1.0, user-scalable=no;user-scalable=0;"/>

<link rel="stylesheet" type="text/css" href="scripts/bluerays_software/common/default_style.css">
<link rel="stylesheet" type="text/css" href="scripts/style.css">
<link rel="stylesheet" href="<?php print($url);?>/scripts/bluerays_software/common/jquery_css.css" >


<script type="text/javascript" src="<?php print($url);?>/scripts/bluerays_software/common/jquery.js" ></script>
<script type="text/javascript" src="<?php print($url);?>/scripts/bluerays_software/common/jquery_ul.js" ></script>

<script type="text/javascript" src="<?php print($url);?>/scripts/bluerays_software/common/html2canvas.js" ></script>
<script type="text/javascript" src="<?php print($url);?>/scripts/bluerays_software/common/default_java_codes_3.js" ></script>

<input type="hidden" id="url" value="<?php print($url);?>">
 
<title>RIMS Password Reset</title>
</head>

<body>
<?php 
	//if(!$validation_array[0]){
		include 'initial_reset.php';
	//}
?>
</body>
</html>