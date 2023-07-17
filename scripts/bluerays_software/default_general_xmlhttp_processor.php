<?php
include '../short_connector.php';
if(isset($_POST['process_login'])){
	include 'default_functions.php';
	
	$username = str_replace("'","",$_POST['username']);
	$password = str_replace("'","",$_POST['password']);
	$table_name = $_POST['table_name'];
	$user_id = 0;
	$user_date = 0;
	
	$username = simple_encode($username);
	//$password = simple_encode($password);
	
	$connection = explode(',',$_POST['connection']);
	
	$output = 0;
	$message = 'Invalid credentials provided';
	$user_type = 0;
	$allow_login = 0;
	$reattempt_delay = 0;
	$delay_interval = 0;
	$allow_continue = 1;
	$action_on_limit = 0;
	$company_id = 0;
	$log_entry_type = 0;
	$today = time();

	$brower_string = 'IP: '.$_SERVER['REMOTE_ADDR'].', Agent: '.$_SERVER['HTTP_USER_AGENT'];
	
	for($c=0;$c<count($connection);$c++){
		$user_type = $c;
		
		$this_connection = $connection[$c];
		
		$settings = mysqli_query($$this_connection,"select * from settings")or die(mysqli_error($$this_connection));
		$settings_results = mysqli_fetch_array($settings,MYSQLI_ASSOC);

		
		$auth = mysqli_query($$this_connection,"select * from $table_name where username = '$username' and status = 1")or die(mysqli_error($$this_connection));
		if(mysqli_num_rows($auth)){
			$auth_results = mysqli_fetch_array($auth,MYSQLI_ASSOC);		
			$company_id = $auth_results['company_id'];
			if(password_verify($password,$auth_results['password'])){
				$output = 1;
				$allow_login = 1;
				$message = '';
				$user_id = $auth_results['id'];
				$user_date = $auth_results['_date'];
				
				if(($settings_results['password_expiry'] and (((time() - $auth_results['last_password_change'])/86400) > $settings_results['password_expiry_period']))){
					$allow_login = 0;
					$reattempt_delay = $settings_results['reattempt_delay'];
					$delay_interval = $settings_results['delay_interval'];
					$allow_continue = 0;
					$action_on_limit = $settings_results['action_on_limit'];
					
					$message = 'Your password has expired.  Please reset your password or contact system administrators';
					
					$log_entry_type = 1;
					
				}else if(($settings_results['limit_attempts'] and ($auth_results['login_attempts'] < $settings_results['allowed_attempts'])) || !$settings_results['limit_attempts']){
					
					$update_user = mysqli_query($$this_connection,"update users set login_attempts = 0 where id = $user_id")or die(mysqli_error($$this_connection));
					
					$log_entry_type = 2;
					
				}else{
					$allow_login = 0;
					$reattempt_delay = $settings_results['reattempt_delay'];
					$delay_interval = $settings_results['delay_interval'];
					$allow_continue = 0;
					$action_on_limit = $settings_results['action_on_limit'];
					
					$message = 'You exceeded login attempts and your account is blocked. Contact system administrators';
					
					$log_entry_type = 3;
				}
				
			}else{
				$output = 0;
				$message = 'Invalid credentials provided';
				
				
				if($settings_results['limit_attempts'] and ($auth_results['login_attempts'] < $settings_results['allowed_attempts'])){
					
					$user_id = $auth_results['id'];
					
					$new_login_attempts = $auth_results['login_attempts']+1;
					
					$update_user = mysqli_query($$this_connection,"update users set login_attempts = $new_login_attempts where id = $user_id")or die(mysqli_error($$this_connection));
					
					$allow_login = 1;
					$reattempt_delay = $settings_results['reattempt_delay'];
					$delay_interval = $settings_results['delay_interval'];
					
					$message = 'Invalid credentials provided. Attempt '.$new_login_attempts.' of '.$settings_results['allowed_attempts'];
					
					$log_entry_type = 4;
					
				}else{
					$allow_login = 0;
					$reattempt_delay = $settings_results['reattempt_delay'];
					$delay_interval = $settings_results['delay_interval'];
					$allow_continue = 0;
					$action_on_limit = $settings_results['action_on_limit'];

					$message = 'You exceeded login attempts and your account is blocked. Contact system administrators';
					
					$log_entry_type = 3;
				}
			}
			
			$add_to_log = mysqli_query($$this_connection,"insert into user_access_log (company_id,user_id,entry_type,_date,details) VALUES($company_id,$user_id,$log_entry_type,'$today','$brower_string')")or die(mysqli_error($$this_connection));
			break;
			
		}else{
			$add_to_log = mysqli_query($$this_connection,"insert into user_access_log (company_id,user_id,entry_type,_date,details) VALUES($company_id,$user_id,$log_entry_type,'$today','$brower_string')")or die(mysqli_error($$this_connection));
			
		}
	}

	print('process_login~'.$output.'~'.$message.'~'.$_POST['function_name'].'~'.$user_id.'~'.$user_date.'~'.$user_type.'~'.$allow_login.'~'.$reattempt_delay.'~'.$delay_interval.'~'.$action_on_limit.'~'.$allow_continue);	
}


if(isset($_POST['authenticateRecovery'])){
	include 'default_functions.php';
	$user_name = str_replace("'","",$_POST['user_name']);
	$connection = $_POST['connection'];
	$table_name = $_POST['table_name'];
	
	$user_name = simple_encode($user_name);
	
	$check_user = mysqli_query($$connection,"select * from $table_name where username = '$user_name'")or die(mysqli_error($$connection));
	
	$user_found = 0;
	$user_id = 0;
	$error_message = 'No user account found';
	if(mysqli_num_rows($check_user)){
		
		$check_user_results = mysqli_fetch_array($check_user,MYSQLI_ASSOC);
		
		if($check_user_results['email'] === '' || $check_user_results['email'] === 0){
			$error_message = 'Your account has no email address. Contact administrators to help reset your password';
			
		}else{
			$user_found = 1;
			$user_id = $check_user_results['id'];
			$new_code = rand(10000,99999);
			$user_email = explode(',',$check_user_results['email']);
				
			$message = 'Hi, '.$check_user_results['_name'].',<br><br>You requested a password reset on PIPAT. Enter the code below on the password recovery form to reset your password:<br> <strong>'.$new_code.'</strong>.<br><br> Please ignore this email if you did not attempt a password reset.<br><br>Have a good day<br>PIPAT 2.0';
			
			$headers = "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
			$headers .= "replyTo:support@pipatzambia.org\r\n";
			$headers .= 'From: PIPAT 2.0'.'<support@pipatzambia.org>'."\r\n";
			
			mail($user_email[0],'PIPAT password recovery request',$message,$headers);
			$error_message = '';
			
			$update_users = mysqli_query($connect,"update $table_name set reset_code = '$new_code' where id = $user_id")or die(mysqli_error($connect));
		}
	}
	
	print('authenticateRecovery~'.$user_found.'~'.$user_id.'~'.$error_message);
}

if(isset($_POST['process_password_reset'])){
	$this_user_id = $_POST['this_user_id'];
	$new_password = str_replace("'","",$_POST['new_password']);
	$table_name = $_POST['table_name'];
	$connection = $_POST['connection'];
	$reset_code = $_POST['reset_code'];
	$last_password_change = time();
	
	$admin_request = $_POST['admin_request'];
	$reset_var = $this_user_id.'-'.$_POST['reset_var'];
	
	$check_user = mysqli_query($$connection,"select * from $table_name where id = $this_user_id")or die(mysqli_error($$connection));
	$check_user_results = mysqli_fetch_array($check_user,MYSQLI_ASSOC);
	
	$success = 0;
	$error_message = 'Reset code provided is incorrect';
	if($check_user_results['reset_code'] == $reset_code || $admin_request == 1){
		$success = 1;
		$error_message = '';
		include 'scripts/bluerays_software/default_functions.php';
		$new_password = password_hash($new_password,PASSWORD_BCRYPT);
		
		if($admin_request == 1){
			$settings = mysqli_query($$connection,"select * from settings")or die(mysqli_error($$connection));
			$settings_results = mysqli_fetch_array($settings,MYSQLI_ASSOC);
			
			if($check_user_results['password_reset_url'] != $reset_var){
				$success = 0;
				$error_message = 'Invalid URL. Contact administrator';
				
			}else if($check_user_results['password_reset_request_date']+($settings_results['url_password_reset_period']*60*60) < time()){
				$success = 0;
				$error_message = 'This link has expired. Contact administrator to generate another link for you';
				
			}
		}
		
		if($success){
			$update_users = mysqli_query($$connection,"update $table_name set password = '$new_password',last_password_change = '$last_password_change', login_attempts = 0, password_reset_url = '', password_reset_request_date = '' where id = $this_user_id")or die(mysqli_error($$connection));
			
			$cookie = setcookie('session_active','0',time() - 10,'/',$url);
			$cookie = setcookie('user_id','0',time() - 10,'/',$url);
			$cookie = setcookie('user_date','0',time() - 10,'/',$url);
			$cookie = setcookie('activeArea','0',time()-10,'/',$url);
			$cookie = setcookie('user_type','0',time() - 10,'/',$url);
			$cookie = setcookie('connection','0',time() - 10,'/',$url);
		}
	}
	
	print('process_password_reset~'.$this_user_id.'~'.$success.'~'.$error_message.'~'.$admin_request);
}



if(isset($_POST['fetch_menu_items'])){
	$db_query = $_POST['db_query'];
	$db_table = $_POST['db_table'];
	$table_column = $_POST['table_column'];
	$item_id = $_POST['item_id'];
	$return_div_id = $_POST['return_div_id'];
	$company_id = $_POST['company_id'];	
	$target_function = $_POST['target_function'];
	
	if(isset($_POST['check_support'])){
		$check_support = $_POST['check_support'];
		$check_function = $_POST['check_function'];
		
	}else{
		$check_support = 0;
		$check_function = '';
	}
	
	
	
	if($_POST['continues_values'] != ''){
		$continues_values = explode("|",$_POST['continues_values']);
		$function_attributes = str_replace('-','\',\'',$continues_values[0]);
		
		if(isset($continues_values[1])){
			$next_function_attributes_array = array_slice($continues_values,1);
			$next_function_attributes = implode('|',$next_function_attributes_array);
		
			$fetch_next_menu_codded = 'fetch_menu_items(\''.$function_attributes.'\',\''.$next_function_attributes.'\')';
			
		}else{
			$fetch_next_menu_codded = 'fetch_menu_items(\''.$function_attributes.'\',\'\')';
			
		}
	}else{
		$fetch_next_menu_codded = '';
		
	}

	$item_table_string = str_replace("-"," or ".$table_column." = ",$item_id);
	$item_table_string = ' and ('.$table_column." = ".$item_table_string.')';

	if($db_table == 'users' || $db_table == 'agents'){
		$ordering_column = '_name';
		
	}else{
		$ordering_column = 'title';
		
	}
	
	$menu_query = mysqli_query($$db_query,"select * from $db_table where company_id = $company_id $item_table_string order by $ordering_column")or die(mysqli_error($$db_query));
	
	$output_string = '';
	
	$menu_id_array = array();
	$menu_title_array = array();
	for($m=0;$m<mysqli_num_rows($menu_query);$m++){
		$menu_query_results = mysqli_fetch_array($menu_query,MYSQLI_ASSOC);
		
		
		
		if($fetch_next_menu_codded != ''){
			if(strstr($fetch_next_menu_codded,'{')){
				$target_column = substr($fetch_next_menu_codded,(strpos($fetch_next_menu_codded,'{')+1),(strpos($fetch_next_menu_codded,'}') - strpos($fetch_next_menu_codded,'{') -1 ));
			}
			
			$fetch_next_menu = str_replace("'[]'",$item_id,str_replace("'0'",0,str_replace("'1'",1,str_replace("'{".$target_column."}'","'".str_replace(',','-',$menu_query_results[$target_column])."'",$fetch_next_menu_codded)))).';';
			
		}else{
			$fetch_next_menu = '';
			
		}
		
		if(isset($menu_query_results['title'])){
			$menu_title = $menu_query_results['title'];
			
		}else{
			$menu_title = $menu_query_results['_name'];
			
		}
		
		$check_div = '';
		if($check_support){
			$check_div = '<input onchange="'.$check_function.'" type="checkbox" id="check_'.$menu_query_results['id'].'" checked> ';
			
		}
		
		
		$output_string .= '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#'.$return_div_id.'_menu\').toggle(\'fast\');$(\'#active_'.$return_div_id.'\').html($(this).html());$(\'#selected_'.$return_div_id.'\').val('.$menu_query_results['id'].');'.$fetch_next_menu.$target_function.'" style="min-width:80px;width:auto;">'.$check_div.$menu_title.'</div>';

	}
	
	print('fetch_menu_items~'.$output_string.'~'.$return_div_id);
}

if(isset($_POST['quick_search_items'])){
	$db_connect = $_POST['db_connect'];
	$db_table = $_POST['db_table'];
	$search_column = $_POST['search_column'];
	$search_input = str_replace("'","''",$_POST['search_input']);
	$filter_column = $_POST['filter_column'];
	$filter_value = $_POST['filter_value'];
	
	if($filter_column != '' and $filter_value != ''){
		$filter_query = ' and '.$filter_column.' = '.$filter_value;
		
	}else{
		$filter_query = '';
		
	}
	
	$search_items = mysqli_query($$db_connect,"select * from $db_table where $search_column LIKE '%$search_input%' $filter_query order by $search_column")or die(mysqli_error($$db_connect));
	
	$output_string = '';
	for($o=0;$o<mysqli_num_rows($search_items);$o++){
		$search_items_results = mysqli_fetch_array($search_items,MYSQLI_ASSOC);
		
		$output_string .= '<div style="width:100%;min-height:20px;line-height:20px;height:auto;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\'" onmouseout="this.style.backgroundColor=\'\'" onclick="$(\'#'.$_POST['search_id'].'_selection_holder\').html(\''.$search_items_results[$search_column].'\');$(\'#'.$_POST['search_id'].'_input_holder\').slideUp(\'fast\');$(\'#'.$_POST['search_id'].'_selection_holder\').slideDown(\'fast\');$(\'#selected_'.$_POST['search_id'].'\').val('.$search_items_results['_date'].');">'.$search_items_results[$search_column].'</div>';
	}
	
	if($output_string == ''){
		$output_string = '<div style="width:100%;height:20px;line-height:20px;text-align:center;color:red">No results were found</div>';
		
	}
	
	print('quick_search_items~'.$output_string.'~'.$_POST['search_id']);
}
?>