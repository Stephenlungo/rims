<?php
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");

$request = explode('/',$_SERVER['REQUEST_URI']);

$refresh_page = 0;
if(isset($request[1]) and $request[1] != ''){
	$check_variables = explode('?',$request[1]);
	
	if(!isset($check_variables[1])){
		$refresh_page = 1;		
	}
}

if(!isset($_SERVER['HTTPS']) || $refresh_page){
	header('location:'.$url);	
}


if(isset($_GET['logout'])){
	$cookie = setcookie('session_active','0',time() - 10,'','pipatzambia.org');
	$cookie = setcookie('user_id','0',time() - 10,'/','pipatzambia.org');
	$cookie = setcookie('user_date','0',time() - 10,'/','pipatzambia.org');
	$cookie = setcookie('activeArea','0',time()-10,'/','pipatzambia.org');
	$cookie = setcookie('user_type','0',time() - 10,'/','pipatzambia.org');
	$cookie = setcookie('connection','0',time() - 10,'/','pipatzambia.org');

	header('location:'.$url);
//	print('hi');
	
}else{
   
	if(isset($_COOKIE['session_active'])){
	    
		$user_id = $_COOKIE['user_id'];
		$user_date = $_COOKIE['user_date'];
		$user_type = $_COOKIE['user_type'];
		
		$connection = explode(',',$_COOKIE['connection']);
		$this_connection = $connection[$user_type];
		//print($this_connection);
	
		$user = mysqli_query($$this_connection,"select * from users where id = $user_id")or die(mysqli_error($$this_connection));
		$user_results = mysqli_fetch_array($user,MYSQLI_ASSOC);
		
		if(isset($user_results['companyID'])){
			$company_id = $user_results['companyID'];
			
		}else{
			$company_id = $user_results['company_id'];
		}
		
		$company = mysqli_query($connect,"select * from companies where id = $company_id")or die(mysqli_error($connect));
		$company_results = mysqli_fetch_array($company,MYSQLI_ASSOC);
		
		$system_name = $validation_array[5];
		$system_logo = $validation_array[7];
		$license_expiry = $validation_array[2];
		$license_name = $validation_array[11];
		
		$enable_chat = $validation_array[13];
		
		
		$activeUserID = $user_results['id'];
		$logged_user_name = $user_results['_name'];
		$active_role = $user_results['roles'];
		
		$theme_titles_array = explode('|',$validation_array[16]);
		$theme_images_array = explode('|',$validation_array[17]);
		
		if($user_results['theme_ind'] == '-1'){
			$actve_theme_title = 'None';
			$active_theme_images = '';
		
		}else{
		
			$actve_theme_title = $theme_titles_array[$user_results['theme_ind']];
			$active_theme_images = $theme_images_array[$user_results['theme_ind']];
		
		}
		 
		$forground_color = $user_results['foregroundColor'];
		$forground_text_color = $user_results['foregroundTxtColor'];
	}else{
		$company_id = 0;
		
	}
}

if(isset($_COOKIE['activeArea'])){
	$activeAreaID = $_COOKIE['activeArea'];
	
}else{
	$activeAreaID = 14;
}

?>