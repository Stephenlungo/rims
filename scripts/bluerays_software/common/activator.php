<?php
$http = 'http://';
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	$http = 'https://';
}
$url = $http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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
 
<title>RIMS Installer</title>
</head>

<body>
<?php 
	if(!$validation_array[0]){
		include 'initial.php';
	}
?>
</body>
</html>