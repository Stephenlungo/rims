<?php
include 'scripts/connector.php';
?>
<div style="width:100%;height:auto;float:left;background-color:#fee;padding:2px;display:none;" id="main_error_output" ondblclick="$(this).slideUp('fast');" title="Double click to hide"></div>

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php print($main_url);?>/scripts/bluerays_software/common/default_style.css">
<link rel="stylesheet" type="text/css" href="scripts/style.css">
<link rel="stylesheet" href="<?php print($main_url);?>/scripts/bluerays_software/common/jquery_css.css" >


<script type="text/javascript" src="<?php print($main_url);?>/scripts/bluerays_software/common/jquery.js" ></script>
<script type="text/javascript" src="<?php print($main_url);?>/scripts/bluerays_software/common/jquery_ul.js" ></script>

<script type="text/javascript" src="<?php print($main_url);?>/scripts/bluerays_software/common/html2canvas.js" ></script>
<script type="text/javascript" src="<?php print($main_url);?>/scripts/bluerays_software/common/default_java_codes_3.js" ></script>

<script src="../scripts/common_java_codes_11.js" type="text/javascript"></script>
<script src="scripts/java_codes_1.js" type="text/javascript"></script>
<!--background-image:url(\''.$code_url.'/imgs/default_bg_images/'.$user_results['bgImage'].'\');-->
<input type="hidden" id="url" value="<?php print($main_url);?>">
<input type="hidden" id="claims_url" value="<?php print($url);?>">
<input type="hidden" id="code_url" value="<?php print($code_url);?>">
<input type="hidden" id="company_id" value="<?php print($company_id);?>">
<input type="hidden" id="img_ind" value="">
<input type="hidden" id="nxt_img_ind" value="0">
<input type="hidden" id="img_string" value="<?php print($active_theme_images);?>">
<input type="hidden" id="theme_titles" value="<?php print($validation_array[16]);?>">
<input type="hidden" id="theme_imgs" value="<?php print($validation_array[17]);?>">
<title><?php print($login_array[0]);?></title>
</head>

<body id="main_body" <?php print($body_effects);?>>
	<?php
	
	if(isset($_COOKIE['session_active'])){		
		include 'scripts/main.php';
		
	}else{
		if(!$settings_results['start_page_type']){
			
			include 'scripts/default_start.php';
		}else{
			include 'scripts/start.php';
		}	
	}
	?>
	
	
</body>
</html>