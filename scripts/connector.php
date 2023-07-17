<?php 
include 'short_connector.php';

$settings = mysqli_query($connect,"select * from settings")or die(mysqli_error($connect));
$settings_results = mysqli_fetch_array($settings,MYSQLI_ASSOC);

/*-------------Include bluerays general header -----------------*/
$arrContextOptions=array(
    "ssl"=>array(
       "verify_peer"=>false,
       "verify_peer_name"=>false,
    ),
);

$validate_company = @file_get_contents($code_url.'/company_access.php?access='.$access_key,false, stream_context_create($arrContextOptions));



$validation_array = explode('~',$validate_company);

if($validation_array[0]){
	
	if(isset($_GET['reset'])){
		include 'bluerays_software/common/password_reset.php';
		exit;
	}
	
	if($validation_array[1]){
		if(time() > ($settings_results['last_sync'] +  $validation_array[15])){
			$update_settings = mysqli_query($connect,"update settings set last_sync = '$today' where id = 1")or die(mysqli_error($connect));
			/*copy($code_url.'/general_codes/default_functions.txt','scripts/bluerays_software/default_functions.php');
			copy($code_url.'/general_codes/default_general_xmlhttp_processor.txt','scripts/bluerays_software/default_general_xmlhttp_processor.php');
			copy($code_url.'/general_codes/default_processor.txt','scripts/bluerays_software/default_processor.php');
			copy($code_url.'/general_codes/default_start.txt','scripts/bluerays_software/default_start.php');
			copy($code_url.'/general_codes/platforms/'.$validation_array[3],'scripts/main.php');
			
			copy($code_url.'/general_codes/scripts/login_recovery.txt','scripts/login/login_recovery.php');
			copy($code_url.'/general_codes/scripts/login_signin.txt','scripts/login/login_signin.php');
			copy($code_url.'/general_codes/scripts/main_progress.txt','scripts/main_progress.php');
			copy($code_url.'/general_codes/scripts/signin.txt','scripts/login/signin.php');
			copy($code_url.'/general_codes/scripts/signup.txt','scripts/login/signup.php');
			copy($code_url.'/general_codes/scripts/signup_form.txt','scripts/login/signup_form.php');
			copy($code_url.'/general_codes/scripts/start.txt','scripts/login/start.php');
				
			if(!$settings_results['start_page_type']){
				copy($code_url.'/general_codes/platforms/'.$validation_array[4],'scripts/default_start.php');
			}*/
		}		
	}else{
		print($validation_array[10]);
	}
	
}else{
	print($validation_array[10]);
}

$login_array[0] = $validation_array[5];
$login_array[1] = $validation_array[6];
$login_array[2] = $validation_array[7];
$login_array[3] = $validation_array[8];
$login_array[4] = $validation_array[9];
$login_array[5] = $validation_array[12];
$login_array[6] = $validation_array[13];
$login_array[7] = $settings_results['limit_attempts'];
$login_array[8] = $settings_results['allowed_attempts'];
$login_array[9] = $settings_results['action_on_limit'];
$login_array[10] = $settings_results['reattempt_delay'];
$login_array[11] = $settings_results['delay_interval'];
$login_array[12] = $settings_results['password_reset'];
$login_array[13] = $settings_results['password_strict'];
$login_array[14] = $settings_results['password_length'];

$_ENV['pipat_database_ip'] = $validation_array[19];
$_ENV['pipat_database_name'] = $validation_array[20];
$_ENV['pipat_database_username'] = $validation_array[21];
$_ENV['pipat_database_password'] = $validation_array[22];

//var_dump($validation_array);

/*---------Include important files-----*/
include 'processor.php';
include 'bluerays_software/default_functions.php';
/*-----------Body coloring effects------------*/
if(isset($_COOKIE['session_active'])){
	$body_effects = 'style="background-color:'.$user_results['bgColor'].';'; 
	 
	if($user_results['bgImage'] != 'none' or $user_results['bgImage'] != 'fade'){
		 $body_effects .= 'background-attachment:fixed; background-size:cover;background-position:top 40px;"';
	}
	
	$body_effects .= 'onscroll="check_scroll();"';
	
	$foreground_opacity = $user_results['foregroundOpacity'];
	$foreground_color = $user_results['foregroundColor'];
	$paper_txt_color = $user_results['paperTxtColor'];
	$paper_opacity = $user_results['paperOpacity'];
	$paper_color = $user_results['paperColor'];
	$user_bg_image = $user_results['bgImage'];
	$bg_color = $user_results['bgColor'];
	
}else{
	$body_effects = '';
}

//$default_cookie_expiry = time()+1800;

if(isset($_COOKIE['session_active']) and !isset($_GET['logout'])){
	$cookie = setcookie('session_active',1,$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('user_id',$_COOKIE['user_id'],$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('user_date',$_COOKIE['user_date'],$default_cookie_expiry,'/','pipatzambia.org');
	
	if(isset($_COOKIE['activeArea']) and !isset($_POST['fetch_menu_page'])){
		$cookie = setcookie('activeArea',$_COOKIE['activeArea'],$default_cookie_expiry,'/','pipatzambia.org');
		
	}
}

if(isset($_GET['auto_log']) and isset($_GET['ud']) and isset($_GET['ut']) and isset($_GET['cn']) and !isset($_GET['logout'])){
	$cookie = setcookie('session_active',1,$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('user_id',$_GET['auto_log'],$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('user_date',$_GET['ud'],$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('user_type',$_GET['ut'],$default_cookie_expiry,'/','pipatzambia.org');
	$cookie = setcookie('connection',$_GET['cn'],$default_cookie_expiry,'/','pipatzambia.org');
	
	header('location:'.$prep_assess_url);
}

?>