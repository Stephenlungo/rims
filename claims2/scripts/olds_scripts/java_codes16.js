var active_menu = 0;
var last_pos = 0;
var rep_timer = 0;
var mark_process = 0;
var new_member_type_action = 0;
var new_member_document_action = 0;
var active_script = '';
var general_variable = 0;
var general_variable_1 = 0;
var invoice_variable = 0;
var general_index = 0;
var data_holder = '';
var items = 0;
var details_to_correct = '';
var progress_text = '<div style="width:200px;height:auto;margin:0 auto;margin-top:30px;display:none;" id="progress_bar"><div style="width:200px;height:20px;line-height:20px;float:left;text-align:center;" id="loading_text">Fetching data. Please wait...</div><div style="width:200px;background-color:#006bb3;height:5px;float:left;line-height:5px;text-align:left;color:#006bb3;font-size:1.4em;" id="progress_line"></div><div style="width:200px;height:20px;float:left;text-align:center;margin-top:40px;font-size:0.7em;position:fixed;">&#0169; BlueRays Software</div></div>';

if(window.XMLHttpRequest){
	information_processor = new XMLHttpRequest();
	xmlhttp = new XMLHttpRequest();
	online_confirm = new XMLHttpRequest();
	chat_checker = new XMLHttpRequest();
	company_checker = new XMLHttpRequest();
	chat_sender = new XMLHttpRequest();
	tmp_uploader_http = new XMLHttpRequest();
	new_member_type = new XMLHttpRequest();
	new_member_document = new XMLHttpRequest();
	new_member_template = new XMLHttpRequest();
	advanced_settings_processor = new XMLHttpRequest();
	create_new_member = new XMLHttpRequest();
	general_xmlhttp = new XMLHttpRequest();
	check_new_invoices = new XMLHttpRequest();
	chat_processor = new XMLHttpRequest();
	check_member = new XMLHttpRequest();
	
}else{
	information_processor = new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	online_confirm = new ActiveXObject("Microsoft.XMLHTTP");
	chat_sender = new ActiveXObject("Microsoft.XMLHTTP");
	chat_checker = new ActiveXObject("Microsoft.XMLHTTP");
	company_checker = new ActiveXObject("Microsoft.XMLHTTP");
	tmp_uploader_http = new ActiveXObject("Microsoft.XMLHTTP");
	new_member_type = new ActiveXObject("Microsoft.XMLHTTP");
	new_member_document = new ActiveXObject("Microsoft.XMLHTTP");
	new_member_template = new ActiveXObject("Microsoft.XMLHTTP");
	advanced_settings_processor = new ActiveXObject("Microsoft.XMLHTTP");
	create_new_member = new ActiveXObject("Microsoft.XMLHTTP");
	general_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	check_new_invoices = new ActiveXObject("Microsoft.XMLHTTP");
	chat_processor = new ActiveXObject("Microsoft.XMLHTTP");
	check_member = new XMLHttpRequest();
}

information_processor.onreadystatechange = function(){
	var requestState = information_processor.readyState;
	if(requestState == 4 && information_processor.status == 200){
		$('#info_area').html(information_processor.responseText);
		$('#main_cover').fadeOut('fast');
		$('#main_progress').fadeOut('fast');
	}
}

function process_information(url_var){	
	var sent_var = url_var.split("=");
	var data = new FormData();
	data.append('async',true);
	data.append(sent_var[0],sent_var[1]);
	
	information_processor.open('POST','scripts/information_processor.php',true);
	information_processor.send(data);	
}

function fetch_menu_items(table_name,query_field,item_id,next_table_name,next_query_field){
	var data = new FormData();
	//alert(query_field);
	data.append('query_field',query_field);
	data.append('fetch_menu_items',item_id);
	data.append('table_name',table_name);
	data.append('next_table_name',next_table_name);
	data.append('next_query_field',next_query_field);
	
	send_general_xmlhttp(data);
}



xmlhttp.onreadystatechange = function(){
	var requestState = xmlhttp.readyState;
	if(requestState == 4 && xmlhttp.status == 200){
	
	if(xmlhttp.responseText == 0){
		$('#chat_company_status').html('Off-line');
		$('#chat_company_status').css('background-color','brown');
	
	}else if(xmlhttp.responseText == 1){
		$('#chat_company_status').html('On-line');
		$('#chat_company_status').css('background-color','green');
	}
	z = setTimeout("check_online_status(document.getElementById('chat_active').value)",5000);
}
}


function check_online_status(company_id){
	xmlhttp.open('POST','scripts/chat_processor.php',true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("online_check="+company_id);
	$('#chat_active').val(company_id);
}

online_confirm.onreadystatechange = function(){
	var requestState = online_confirm.readyState;
	if(requestState == 4 && online_confirm.status == 200){
		if(online_confirm.responseText != ''){
			show_chat(5,'BlueRays Software');	
		}
		y = setTimeout("confirm_online_status(document.getElementById('active_company_id').value)",2000);
	}
}

function confirm_online_status(company_id){
	online_confirm.open('POST','scripts/chat_processor.php',true);
	online_confirm.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	online_confirm.send("online_confirm="+company_id);
}


chat_sender.onreadystatechange = function(){
	var requestState = chat_sender.readyState;
	if(requestState == 4 && chat_sender.status == 200){
		if(chat_sender.responseText == 0){
			
		
		}else if(chat_sender.responseText == 1){

		}
	}
}

function send_chat(from,to,msg){
	$('#chat_msg').css('color','#aaa');
	$('#chat_msg').val('Type message here');
	chat_sender.open('POST','scripts/chat_processor.php',true);
	chat_sender.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	chat_sender.send("send_chat="+to+"&from="+from+"&msg="+msg);
}


chat_checker.onreadystatechange = function(){
	var requestState = chat_checker.readyState;
	
	if(requestState == 4 && chat_checker.status == 200){
		var result = chat_checker.responseText;
		var strt = result.indexOf('$last_id=');
		var position_result = result.substr(strt);
		
		if(position_result != ''){
			var position_end_part = position_result.replace('$last_id=','');
			last_pos = position_end_part;
			result = result.replace(position_result,'');
			$('#chat_budge_messages').append(result);
			var budge_height = document.getElementById('chat_budge_messages').scrollHeight;
			$('#chat_budge_messages').scrollTop(budge_height);
		}
		
		x = setTimeout("check_chat(document.getElementById('active_company_id').value,document.getElementById('chat_active').value,last_pos,document.getElementById('active_company_id').value)",2000);	
	}
}

function check_chat(from,to,start_id,active_company_id){
	
	chat_checker.open('POST','scripts/chat_processor.php',true);
	chat_checker.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	chat_checker.send("chat_checker="+from+"&to="+to+"&start_id="+start_id+"&active_company_id="+active_company_id);
}


company_checker.onreadystatechange = function(){
	var requestState = company_checker.readyState;
	
	if(requestState == 4 && company_checker.status == 200){
		var result = company_checker.responseText;
		$('#online_companies').html(result);
		var active_company_id = $('#active_company_id').val();
		w = setTimeout("check_company(active_company_id)",5000);	
	}
}

function check_company(){
	company_checker.open('POST','scripts/chat_processor.php',true);
	company_checker.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	company_checker.send("company_checker="+$('#active_company_id').val());
}


$(document).ready(function(){
	var active_company_id = $('#active_company_id').val();

	change_image();
});

function change_image(){
	var image_string = $('#img_string').val();
	var image_array = image_string.split(',');
	
	if(check_next_image_loaded($('#code_url').val()+'/imgs/default_bg_images/'+image_array[Number($('#nxt_img_ind').val())])){
		
		
		if($('#img_ind').val() === ''){		
			var current_image_index = 0;

		}else{
			if(Number($('#img_ind').val()) < (image_array.length)-1){
				var current_image_index = Number($('#img_ind').val())+1;
				
			}else{
				var current_image_index = 0;
			}
			
		}
		
		
		var current_image = $('#code_url').val()+'/imgs/default_bg_images/'+image_array[current_image_index];
		$('#main_body').css("backgroundImage","url('"+current_image+"')");
		
		$('#img_ind').val(current_image_index);
		$('#nxt_img_ind').val(current_image_index+1);
		
	}
	
	setTimeout("change_image()",120000);
	
}

function check_next_image_loaded(img){
	if(img.naturalWidth ===0){
		return false;
		
	}else{
		return true;
		
	}
}


function show_chat(company_id,company_name){
	//check_online_status(company_id);
	$('#chat_active').val(company_id);
	$('#chat_title').html(company_name);
	$('#chat_budge').fadeIn('fast');
	check_chat(document.getElementById('active_company_id').value,company_id,0,document.getElementById('active_company_id').value);
	
}


function authenticateLogin(){
	if(document.loginForm.email.value=='Enter your login email' || document.loginForm.email.value==''){
		document.getElementById('errorMsg').value='You need to enter your login email';
		document.loginForm.email.style.borderColor='#f00';
	
	}else if(document.loginForm.password.value=='password' || document.loginForm.password.value==''){
		document.getElementById('errorMsg').value='Enter your password to proceed';
		document.loginForm.password.style.borderColor='#f00';
		
	}else{
		display_progress('login_cover','login_progress');
		document.loginForm.submit();
	}
}


function authenticateRecovery(){
	if(document.recoveryForm.email.value=='Enter your login email' || document.recoveryForm.email.value==''){
		document.getElementById('errorMsg').value='You need to enter your registered email';
		document.recoveryForm.email.style.borderColor='#f00';
		
	}else{
		display_progress('login_cover','login_progress');
		document.recoveryForm.submit();
		
	}
}

function authenticateReset(){
if(document.resetForm.password.value=='Enter your new password' || document.resetForm.password.value==''){
document.getElementById('errorMsg').value='Enter your new password';
document.resetForm.password.style.borderColor='#f00';

}else if(document.resetForm.password2.value == 'Re-enter your new password'){
document.getElementById('errorMsg').value='Re-enter your password to confirm';
document.resetForm.password2.style.borderColor='#f00';

}else if(document.resetForm.password.value != document.resetForm.password2.value){
document.getElementById('errorMsg').value='Your new passwords do not match. try again';
document.resetForm.password2.style.borderColor='#f00';
}else{
	display_progress('login_cover','login_progress');
document.resetForm.submit();
}
}

function authenticateSignup(){
	if(document.signupForm.name.value=='Enter full names here' || document.signupForm.name.value==''){
		document.signupForm.name.style.borderColor='#f00';
		show_error_message("Enter user's full names");
		
	}else if(document.signupForm.username.value=='Enter user name here' || document.signupForm.username.value==''){
		document.signupForm.name.style.borderColor='#f00';
		show_error_message("Enter user name in the space provided");
	
	}else if(document.signupForm.email.value=='Enter email address here' || document.signupForm.email.value==''){
		document.signupForm.email.style.borderColor='#f00';
		show_error_message("Enter email address");
	
	}else if(document.signupForm.password.value=='Enter password here' || document.signupForm.password.value==''){
		document.signupForm.password.style.borderColor='#f00';
		show_error_message("Enter password");
	
	}else if(document.signupForm.password2.value=='Re-enter password' || document.signupForm.password2.value==''){
		document.signupForm.password2.style.borderColor='#f00';
		show_error_message("Confirm password entered by re-entering in highlighted field");
	
	}else if(document.signupForm.password.value != document.signupForm.password2.value){
		document.signupForm.password.style.borderColor='#f00';
		document.signupForm.password2.style.borderColor='#f00';
		show_error_message("Passwords do not match. Try again");
		
	}else if(document.signupForm.phone.value=='Enter phone number'){
		document.signupForm.phone.style.borderColor='#f00';
		show_error_message("Enter phone number");
		
	}else if(document.signupForm.qualification.value=='Enter qualification here'){
		document.signupForm.qualification.style.borderColor='#f00';
		show_error_message("Enter user qualification");
		
	}else if(document.signupForm.responsibility.value=='Enter qualification here'){
		document.signupForm.responsibility.style.borderColor='#f00';
		show_error_message("Enter user responsibility or position");
	
	}else{
		if($('#create_user').html() != 'Wait...'){
			var data = new FormData();
			data.append('create_new_user',1);
			data.append('full_names',$('#name').val());
			data.append('username',$('#username').val());
			data.append('password',$('#password').val());
			data.append('email',$('#email').val());
			data.append('phone',$('#phone').val());
			data.append('phone',$('#phone').val());
			data.append('responsibility',$('#responsibility').val());
			data.append('qualification',$('#qualification').val());
			data.append('department_id',$('#department_id').val());
			data.append('division_id',$('#new_station_division_id').val());
			data.append('department_supervisor',$('#department_supervisor').val());
			data.append('region_id',$('#new_station_regions_id').val());
			data.append('province_id',$('#new_station_provinces_id').val());
			data.append('hub_id',$('#new_station_districts_id').val());
			data.append('site_id',$('#new_station_sites_id').val());
			data.append('unit_id',$('#new_user_unit_id').val());
			data.append('email_send_rule',$('#email_send_rule').val());
			data.append('email_notify_rule',$('#email_notify_rule').val());
			
			
			data.append('roles',$('#roles').val());
			
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			
			$('#create_user').html('Wait...');
			send_general_xmlhttp(data);
		}
	}
}

function show_error_message(message){
	$('#new_user_error_message').show('fast');
	$('#new_user_error_message').html(message);
}

function authenticateNewKeyForm(){
	if(document.newKeyForm.newKey.value=='Enter new key here' || document.newKeyForm.newKey.value==''){
		alert('Enter license key');
	
	}else{
		document.newKeyForm.submit();
	}
}

function authenticate_tag_login(){
	if($('#tag_number').val() == 'Enter your device tag number here'){
		$('#errorMsg').val('Please enter your device tag number');
		$('#tag_number').css('borderColor','red');
		
	}else if($('#tag_password').val() == 'password'){
		$('#errorMsg').val('Please enter your password');
		$('#tag_password').css('borderColor','red');
	
	}else{
		var data = new FormData();
		data.append('authenticate_tag_login',1);
		data.append('login_type',1);
		data.append('tag_number',$('#tag_number').val());
		data.append('user_password',$('#tag_password').val());
		
		send_general_xmlhttp(data);

		$('#tag_signin').html('Wait...');
		$('#login_cover').fadeIn('fast');
		show_loading_progress('login_progress');
		$('#loading_text').html('Checking credentials. Please wait...');
		
		//$('#login_progress').fadeIn('fast');
	}
}

function authenticate_username_login(){
	if($('#username').val() == 'Enter your login user name'){
		$('#errorMsg').val('Please enter your user name');
		$('#username').css('borderColor','red');
		
	}else if($('#user_password').val() == 'password'){
		$('#errorMsg').val('Please enter your password');
		$('#user_password').css('borderColor','red');
	
	}else{
		var data = new FormData();
		data.append('authenticate_username_login',1);
		data.append('login_type',0);
		data.append('username',$('#username').val());
		data.append('user_password',$('#user_password').val());
		
		send_general_xmlhttp(data);

		$('#username_signin').html('Wait...');
		$('#login_cover').fadeIn('fast');
		show_loading_progress('login_progress');
		$('#loading_text').html('Checking credentials. Wait...');
		
		//$('#login_progress').fadeIn('fast');
	}
}

function show_loading_progress(div_id){
	$('#'+div_id).html(progress_text);
	$('#progress_bar').fadeIn('fast');
	animate_progress();
	
}

function display_infor(div_id,info){
	$('#progress_bar').fadeOut('fast');
	clearTimeout(general_variable);
	$('#'+div_id).hide();
	$('#'+div_id).html(info);
	$('#'+div_id).fadeIn('medium');
}

function show_province_filter(region_id,function_name){
	var data = new FormData();
	
	data.append('show_province_filter',region_id);
	data.append('function_name',function_name);
	send_general_xmlhttp(data);	
}

function show_district_filter(province_id,function_name){
	var data = new FormData();
	
	data.append('show_district_filter',province_id);
	data.append('function_name',function_name);
	send_general_xmlhttp(data);	
}

function show_site_filter(district_id,function_name){
	var data = new FormData();
	
	data.append('show_site_filter',district_id);
	data.append('function_name',function_name);	
	send_general_xmlhttp(data);	
}

function show_agent_filter(site_id,function_name){
	var data = new FormData();
	
	data.append('show_agent_filter',site_id);
	data.append('function_name',function_name);	
	send_general_xmlhttp(data);	
}

function hide_vote_filter_sections(show_sections){
	$('#vote_districts').hide('fast');
	$('#vote_sites').hide('fast');
	
	var sections_array = show_sections.split(",");
	
	for(var s=0;s<sections_array.length;s++){
		var this_section = sections_array[s];
		
		$('#vote_'+this_section).show('fast');

	}
}

function reset_station_fields(exempt_field){
	if(exempt_field == 'selected_provinces_id'){
		$('#selected_districts_id').val(0);
		$('#vote_districts').hide('fast');
		$('#active_districts').html('Select Hub');
		
		$('#selected_sites_id').val(0);
		$('#vote_sites').hide('fast');
		$('#active_sites').html('Select site');
		
		$('#selected_agents_id').val(0);
		$('#vote_agents').hide('fast');
		$('#active_agents').html('Select agent');

	}
	
	if(exempt_field == 'selected_districts_id'){
		$('#selected_sites_id').val(0);
		$('#vote_sites').hide('fast');
		$('#active_sites').html('Select site');
		
		$('#selected_agents_id').val(0);
		$('#vote_agents').hide('fast');
		$('#active_agents').html('Select agent');
		
	}
	
	if(exempt_field == 'selected_sites_id'){
		$('#selected_agents_id').val(0);
		$('#vote_agents').hide('fast');
		$('#active_agents').html('Select agent');
		
	}
}


function animate_progress(){
	$('#progress_line').animate({marginTop:(10) + 'px'},'slow');
	$('#progress_line').animate({marginTop:(0) + 'px'},'slow');
	
	general_variable = setTimeout("animate_progress()",1000);
}

function authenticate_company_registration(){
	if(document.company_signup_form.company_name.value == 'Enter your company name here'){
		alert('You need to enter your company name');
	
	}else if(document.company_signup_form.admin_name.value == 'Enter your name here'){
		alert('You need to enter your name');
		
	}else if(document.company_signup_form.admin_email.value == 'Enter your login email'){
		alert('You need to enter an administrator email');
	
	}else if(document.company_signup_form.admin_password.value == 'password'){
		alert('You need to enter a password for your account. Password cannot be the word \'password\'');
	
	}else if(document.company_signup_form.admin_password.value != document.company_signup_form.admin_password_2.value){
		alert('Your password must match confirmation password');
	}else{
		document.company_signup_form.submit();
	}
}

function display_progress(progress_cover_id,progress_id){
	$('#'+progress_cover_id).fadeIn('fast');
	$('#'+progress_id).fadeIn('slow');
}

function hide_progress(progress_cover_id,progress_id){
	$('#'+progress_cover_id).fadeOut('fast');
	$('#'+progress_id).fadeOut('fast');
}

function close_window(a){
	$('#'+a).fadeOut('fast');
	$('#info_cover').fadeOut('fast');
}

function show_window(a,b){
	$('#info_cover').fadeIn('fast');
	$('#'+a).fadeIn('fast');
	center_item_vertical(a,b);
}

function close_window_special(a,area_id){
	$('#'+a).fadeOut('fast');
	$('#'+area_id+'_cover').fadeOut('fast');
}

function show_window_special(a,b,area_id){
	$('#'+area_id+'_cover').fadeIn('fast');
	$('#'+a).fadeIn('fast');
	center_item_vertical(a,b);
}

function center_item_vertical(item_id,item_position_type){
	var bigger_height = window.outerHeight;
	var smaller_height = $('#'+item_id).css('height');
	smaller_height = smaller_height.replace('px','');
	var entry_times = bigger_height / smaller_height;
	var vertical_center_position = (entry_times / 2) * smaller_height;
	var smaller_vertical_position = vertical_center_position - (smaller_height);
	
	if(item_position_type == null){
		smaller_vertical_position = smaller_vertical_position + window.pageYOffset + 110;
		
	}else{
		if(item_position_type == 0){
			smaller_vertical_position = smaller_vertical_position + window.pageYOffset-110;
			
		}else if(item_position_type == 1){
			smaller_vertical_position = smaller_vertical_position + window.pageYOffset+50;
			
		}
	}
	
	$('#'+item_id).animate({marginTop:(smaller_vertical_position) + 'px'},'fast');
}


tmp_uploader_http.onreadystatechange = function(){
	var requestState = tmp_uploader_http.readyState;
	if(requestState == 4 && tmp_uploader_http.status == 200){
	alert(tmp_uploader_http.responseText);
	}
}

function tmp_upload(input_id,output_id){	
	var upload_files = document.getElementById(input_id).files;
	var data = new FormData();
	var file_upload = "true";
	
	for(var i=0;i<upload_files.length;i++){
		
		var this_file = upload_files[i];
		
		//alert(this_file.type);
		/*if(!this_file.type.match('image.*')){
			continue;
		}*/

		data.append(input_id,this_file,this_file.name);
		data.append('file_upload',input_id);
	}

	tmp_uploader_http.open('POST','scripts/tmp_image_uploader.php',true);
	//tmp_uploader_http.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	tmp_uploader_http.send(data);
}

function switch_member_tabs(a){
	$('#member_types_button').css('background-color','#eee');
	$('#required_documents_holder_button').css('background-color','#eee');
	$('#message_templates_button').css('background-color','#eee');
	$('#advanced_button').css('background-color','#eee');
	$('#'+a).css('background-color','#ccc');
	
	$('#member_types').hide();
	$('#required_documents_holder').hide();
	$('#message_templates').hide();
	$('#advanced').hide();
	
	b = a.replace('_button','');
	
	$('#'+b).fadeIn('fast');	
}

//Reacting to new member type entry
new_member_type.onreadystatechange = function(){
	var requestState = new_member_type.readyState;
	if(requestState == 4 && new_member_type.status == 200){
	if(new_member_type.responseText == 0){
		$('#new_member_type_submit').html('Save');
		$('#member_type_error').html('A member type with the same title exists');

	}else{
		if(new_member_type_action == 0){
			var response_txt = new_member_type.responseText;
			var response_txt_array = response_txt.split("^");
			
			$('#new_member_type_submit').html('Save');
			$('#new_member_type').hide();
			$('#member_type_list').fadeIn('fast');
			$('#member_type_list').append(response_txt_array[0]);
			$('#new_member_type_menu').append(response_txt_array[1]);
			$('#member_type_name').val('Enter member type title here');
			$('#member_type_description').val('Enter type description here');
			$('#member_type_name').css('color','#aaa');
			$('#member_type_description').css('color','#aaa');
		
		}else if(new_member_type_action == -1 || new_member_type_action == -5){
			
			var response_txt = new_member_type.responseText;
			var response_txt_array = response_txt.split("^");
			
			var updated_selections = response_txt_array[0];
			var updated_selections_array = updated_selections.split(',');
			
			if(new_member_type_action == -5){
				for(var i=0;i<updated_selections_array.length;i++){
					$('#member_type_'+updated_selections_array[i]).remove();
				}

				$('#new_member_type_menu').append(response_txt_array[1]);
				
			}else{
				for(var i=0;i<updated_selections_array.length;i++){
					$('#member_type_'+updated_selections_array[i]).remove();
					$('#new_member_type_'+updated_selections_array[i]).remove();
				}
			}
			
			$('#type_active_action').html('Select action');
			new_member_type_action == 0;
			$('#selected_items').val('');
			
		}else if(new_member_type_action == -2 || new_member_type_action == -3 || new_member_type_action == -4){
			var response_txt = new_member_type.responseText;
			var response_txt_array = response_txt.split("^");
			
			
			$('#member_type_listing').html(response_txt_array[0]);
			$('#new_member_type').html(response_txt_array[1]);
			
			new_member_type_action == 0;
			
		}else{
			var response_txt = new_member_type.responseText;
			var response_txt_array = response_txt.split("^");
			$('#member_type_'+new_member_type_action).html(response_txt_array[0]);
			$('#new_member_type_'+new_member_type_action).html(response_txt_array[1]);
			$('#update_button_'+new_member_type_action).html('Save');
		}
	}
	}
}


function create_new_member_type(company_id){
	new_member_type_action = 0;
	var data = new FormData();
	data.append('new_member_type',true);
	data.append('company_id',company_id);
	data.append('title',$('#member_type_name').val());
	data.append('description',$('#member_type_description').val());
	new_member_type.open('POST','scripts/new_member_type_processor.php',true);
	new_member_type.send(data);
}

function update_member_type(member_type_id){
	new_member_type_action = member_type_id;
	$('#update_button_'+member_type_id).html('Saving');
	var data = new FormData();
	data.append('update_member_type',member_type_id);
	data.append('title',$('#member_type_title_'+member_type_id).val());
	data.append('description',$('#member_type_description_'+member_type_id).val());
	new_member_type.open('POST','scripts/new_member_type_processor.php',true);
	new_member_type.send(data);
}

function add_type_selection(selection_id){
	var selected_items = $('#selected_items').val();
	if(selected_items == ''){
		selected_items = selection_id;
	
	}else{
		selected_items = selected_items+','+selection_id;
	}
	
	$('#selected_items').val(selected_items);
}

function remove_type_selection(selection_id){
	var new_selected_items = '';
	var selected_items = $('#selected_items').val();
	var item_array = selected_items.split(',');

	for(var i=0;i<item_array.length;i++){
		
		if(item_array[i] != selection_id){
			
			if(new_selected_items == ''){
				new_selected_items = item_array[i];
			
			}else{
				new_selected_items = new_selected_items+','+item_array[i];
			}
		}
	}
	$('#selected_items').val(new_selected_items);
}


function deactivate_member_types(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_type_action = -1;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('deactivate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_type.open('POST','scripts/new_member_type_processor.php',true);
		new_member_type.send(data);
	}
}

function activate_member_types(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_type_action = -5;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('activate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_type.open('POST','scripts/new_member_type_processor.php',true);
		new_member_type.send(data);
	}
}

function fetch_inactive_member_types(company_id){
	new_member_type_action = -2;
	
	$('#member_type_activate_action').show();
	$('#member_type_deactivate_action').hide();
	
	data = new FormData();
	data.append('inactive_member_types',true);
	data.append('company_id',company_id);
	new_member_type.open("POST",'scripts/new_member_type_processor.php',true);
	new_member_type.send(data);
}

function fetch_active_member_types(company_id){
	new_member_type_action = -3;
	
	$('#member_type_activate_action').hide();
	$('#member_type_deactivate_action').show();
	
	data = new FormData();
	data.append('active_member_types',true);
	data.append('company_id',company_id);
	new_member_type.open("POST",'scripts/new_member_type_processor.php',true);
	new_member_type.send(data);
}

function fetch_all_member_types(company_id){
	new_member_type_action = -4;
	
	$('#member_type_activate_action').show();
	$('#member_type_deactivate_action').show();
	
	data = new FormData();
	data.append('all_member_types',true);
	data.append('company_id',company_id);
	new_member_type.open("POST",'scripts/new_member_type_processor.php',true);
	new_member_type.send(data);
}

//Reacting to new member document entry
new_member_document.onreadystatechange = function(){
	var requestState = new_member_document.readyState;
	if(requestState == 4 && new_member_document.status == 200){
	
		if(new_member_document.responseText == 0){
			$('#new_member_type_submit').html('Save');
			
			$('#general_error_msg').fadeIn('fast');
			$('#general_error_msg_txt').html('Oops!! A document with the same title exists');

		}else{
			if(new_member_document_action == 0){
				
				var response_txt = new_member_document.responseText;
				var response_txt_array = response_txt.split("^");
				
				$('#new_member_document_submit').html('Save');
				$('#new_member_document').hide();
				$('#member_document_list').fadeIn('fast');
				$('#member_document_list').append(response_txt_array[0]);
				$('#member_document_name').val('Enter member document title here');
				$('#member_document_description').val('Enter document description here');
				$('#member_document_name').css('color','#aaa');
				$('#member_document_description').css('color','#aaa');
				$('#new_member_documents').append(response_txt_array[1]);
			
			}else if(new_member_document_action == -1 || new_member_document_action == -5){
				var response_txt = new_member_document.responseText;
				var response_txt_array = response_txt.split("^");
				
				var updated_selections = response_txt_array[0];
				var updated_selections_array = updated_selections.split(',');
				
				if(new_member_document_action == -5){
					for(var i=0;i<updated_selections_array.length;i++){
						$('#member_document_'+updated_selections_array[i]).remove();
					}
					$('#new_member_documents').append(response_txt_array[1]);
					
				}else{
					for(var i=0;i<updated_selections_array.length;i++){
						$('#member_document_'+updated_selections_array[i]).remove();
						$('#required_document_'+updated_selections_array[i]).remove();
					}
				}
				$('#type_active_action').html('Select action');
				new_member_document_action == 0;
				$('#selected_items').val('');
				
			}else if(new_member_document_action == -2 || new_member_document_action == -3 || new_member_document_action == -4){
				var response_txt = new_member_document.responseText;
			var response_txt_array = response_txt.split("^");
				
				$('#member_document_listing').html(response_txt_array[0]);
				$('#new_member_documents').html(response_txt_array[1]);
				new_member_document_action == 0;
				
			}else{
				var response_txt = new_member_document.responseText;
				var response_txt_array = response_txt.split("^");
				
				$('#member_document_'+new_member_document_action).html(response_txt_array[0]);
				$('#required_document_'+new_member_document_action).html(response_txt_array[1]);
				$('#update_button_'+new_member_document_action).html('Save');
			}
		}
	}
}

function create_new_member_document(company_id){
	new_member_document_action = 0;
	var data = new FormData();
	data.append('new_member_document',true);
	data.append('company_id',company_id);
	data.append('title',$('#member_document_name').val());
	data.append('description',$('#member_document_description').val());
	new_member_document.open('POST','scripts/new_member_document_processor.php',true);
	new_member_document.send(data);
}

function update_member_document(member_document_id){
	new_member_document_action = member_document_id;
	$('#update_button_'+member_document_id).html('Saving');
	var data = new FormData();
	data.append('update_member_document',member_document_id);
	data.append('title',$('#member_document_title_'+member_document_id).val());
	data.append('description',$('#member_document_description_'+member_document_id).val());
	new_member_document.open('POST','scripts/new_member_document_processor.php',true);
	new_member_document.send(data);
}

function add_document_selection(selection_id){
	var selected_items = $('#selected_items').val();
	if(selected_items == ''){
		selected_items = selection_id;
	
	}else{
		selected_items = selected_items+','+selection_id;
	}
	
	$('#selected_items').val(selected_items);
}

function remove_document_selection(selection_id){
	var new_selected_items = '';
	var selected_items = $('#selected_items').val();
	var item_array = selected_items.split(',');

	for(var i=0;i<item_array.length;i++){
		
		if(item_array[i] != selection_id){
			
			if(new_selected_items == ''){
				new_selected_items = item_array[i];
			
			}else{
				new_selected_items = new_selected_items+','+item_array[i];
			}
		}
	}
	$('#selected_items').val(new_selected_items);
}


function deactivate_member_documents(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_document_action = -1;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('deactivate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_document.open('POST','scripts/new_member_document_processor.php',true);
		new_member_document.send(data);
	}
}

function activate_member_documents(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_document_action = -5;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('activate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_document.open('POST','scripts/new_member_document_processor.php',true);
		new_member_document.send(data);
	}
}

function fetch_inactive_member_documents(company_id){
	new_member_document_action = -2;
	
	$('#member_document_activate_action').show();
	$('#member_document_deactivate_action').hide();
	
	data = new FormData();
	data.append('inactive_member_documents',true);
	data.append('company_id',company_id);
	new_member_document.open("POST",'scripts/new_member_document_processor.php',true);
	new_member_document.send(data);
}

function fetch_active_member_documents(company_id){
	new_member_document_action = -3;
	
	$('#member_document_activate_action').hide();
	$('#member_document_deactivate_action').show();
	
	data = new FormData();
	data.append('active_member_documents',true);
	data.append('company_id',company_id);
	new_member_document.open("POST",'scripts/new_member_document_processor.php',true);
	new_member_document.send(data);
}

function fetch_all_member_documents(company_id){
	new_member_document_action = -4;
	
	$('#member_document_activate_action').show();
	$('#member_document_deactivate_action').show();
	
	data = new FormData();
	data.append('all_member_documents',true);
	data.append('company_id',company_id);
	new_member_document.open("POST",'scripts/new_member_document_processor.php',true);
	new_member_document.send(data);
}

//Reacting to new template entry
new_member_template.onreadystatechange = function(){
	var requestState = new_member_template.readyState;
	if(requestState == 4 && new_member_template.status == 200){
	if(new_member_template.responseText == 0){
		$('#new_member_template_submit').html('Save');
		$('#member_template_error').html('A template with the same title exists');

	}else{
		if(new_member_template_action == 0){
			var response_txt = new_member_template.responseText;
			var response_txt_array = response_txt.split("^");
			
			$('#new_member_template_submit').html('Save');
			$('#new_member_template').hide();
			$('#member_template_list').fadeIn('fast');
			$('#member_template_list').append(response_txt_array[0]);
			$('#actions_menu').append(response_txt_array[1]);
			$('#member_template_name').val('Enter template title here');
			$('#member_template_text').val('Enter template message here');
			$('#member_template_name').css('color','#aaa');
			$('#member_template_text').css('color','#aaa');
		
		}else if(new_member_template_action == -1 || new_member_template_action == -5){
			
			var response_txt = new_member_template.responseText;
			var response_txt_array = response_txt.split("^");
			
			var updated_selections = response_txt_array[0];
			var updated_selections_array = updated_selections.split(',');
			
			if(new_member_template_action == -5){
				for(var i=0;i<updated_selections_array.length;i++){
					$('#member_template_'+updated_selections_array[i]).remove();
				}

				$('#new_member_template_menu').append(response_txt_array[1]);
				
			}else{
				for(var i=0;i<updated_selections_array.length;i++){
					$('#member_template_'+updated_selections_array[i]).remove();
					$('#new_member_template_'+updated_selections_array[i]).remove();
				}
			}
			
			$('#template_active_action').html('Select action');
			new_member_template_action == 0;
			$('#selected_items').val('');
			
		}else if(new_member_template_action == -2 || new_member_template_action == -3 || new_member_template_action == -4){
			var response_txt = new_member_template.responseText;
			var response_txt_array = response_txt.split("^");
			
			
			$('#member_template_listing').html(response_txt_array[0]);
			$('#new_member_template').html(response_txt_array[1]);
			
			new_member_template_action == 0;
			
		}else{
			
			var response_txt = new_member_template.responseText;
			var response_txt_array = response_txt.split("^");
			$('#member_update_button_'+response_txt_array[2]).html('Save');
			$('#member_template_'+new_member_template_action+'_title').html(response_txt_array[0]);
			
			$('#member_templates_'+response_txt_array[2]+'_item').show();
			$('#member_templates_'+response_txt_array[2]+'_edit').hide();
		
		}
	}
	}
}


function create_new_member_template(company_id){
	new_member_template_action = 0;
	var data = new FormData();
	data.append('new_member_template',true);
	data.append('company_id',company_id);
	data.append('title',$('#member_template_name').val());
	data.append('text',$('#member_template_message').val());
	new_member_template.open('POST','scripts/new_member_template_processor.php',true);
	new_member_template.send(data);
}

function update_member_template(member_template_id){
	new_member_template_action = member_template_id;
	$('#member_update_button_'+member_template_id).html('Saving...');
	var data = new FormData();
	data.append('update_member_template',member_template_id);
	data.append('title',$('#member_template_title_'+member_template_id).val());
	data.append('message',$('#member_template_message_'+member_template_id).val());
	new_member_template.open('POST','scripts/new_member_template_processor.php',true);
	new_member_template.send(data);
}

function add_template_selection(selection_id){
	var selected_items = $('#selected_items').val();
	if(selected_items == ''){
		selected_items = selection_id;
	
	}else{
		selected_items = selected_items+','+selection_id;
	}
	
	$('#selected_items').val(selected_items);
}

function remove_template_selection(selection_id){
	var new_selected_items = '';
	var selected_items = $('#selected_items').val();
	var item_array = selected_items.split(',');

	for(var i=0;i<item_array.length;i++){
		
		if(item_array[i] != selection_id){
			
			if(new_selected_items == ''){
				new_selected_items = item_array[i];
			
			}else{
				new_selected_items = new_selected_items+','+item_array[i];
			}
		}
	}
	$('#selected_items').val(new_selected_items);
}


function deactivate_member_templates(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_template_action = -1;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('deactivate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_template.open('POST','scripts/new_member_template_processor.php',true);
		new_member_template.send(data);
	}
}

function activate_member_templates(){
	if($('#selected_items').val() == ''){
		$('#template_active_action').html('Select action');
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_template_action = -5;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('activate_selections',true);
		data.append('selections',$('#selected_items').val());
		
		new_member_template.open('POST','scripts/new_member_template_processor.php',true);
		new_member_template.send(data);
	}
}

function fetch_inactive_member_templates(company_id){
	new_member_template_action = -2;
	
	$('#member_template_activate_action').show();
	$('#member_template_deactivate_action').hide();
	
	data = new FormData();
	data.append('inactive_member_templates',true);
	data.append('company_id',company_id);
	new_member_template.open("POST",'scripts/new_member_template_processor.php',true);
	new_member_template.send(data);
}

function fetch_active_member_templates(company_id){
	new_member_template_action = -3;
	
	$('#member_template_activate_action').hide();
	$('#member_template_deactivate_action').show();
	
	data = new FormData();
	data.append('active_member_templates',true);
	data.append('company_id',company_id);
	new_member_template.open("POST",'scripts/new_member_template_processor.php',true);
	new_member_template.send(data);
}

function fetch_all_member_templates(company_id){
	new_member_template_action = -4;
	
	$('#member_template_activate_action').show();
	$('#member_template_deactivate_action').show();
	
	data = new FormData();
	data.append('all_member_templates',true);
	data.append('company_id',company_id);
	new_member_template.open("POST",'scripts/new_member_template_processor.php',true);
	new_member_template.send(data);
}

function save_advanced_settings(company_id){
	$('#advanced_settings_submit').html('Wait...');
	
	var lease_plan_start = $('#lease_year').val()+'-'+$('#lease_month').val()+'-'+$('#lease_day').val();

	var data = new FormData();
	data.append('save_advanced_settings',company_id);
	data.append('membership_period',$('#membership_period').val());
	data.append('auto_renewal',$('#auto_renewal').val());
	data.append('auto_invoicing',$('#auto_invoicing').val());
	data.append('member_access',$('#member_access').val());
	data.append('lease_plan_start',lease_plan_start);
	data.append('lease_plan_charge',$('#membership_charge').val());
	data.append('membership_expiration_type',$('#membership_expiration_type').val());
	data.append('absolute_expiry_day',$('#membership_expiry_day').val());
	data.append('absolute_expiry_month',$('#membership_expiry_month').val());
	data.append('absolute_expiry_year',$('#membership_expiry_year').val());
	data.append('client_subscription',$('#client_subscription').val());
	
	advanced_settings_processor.open('POST','scripts/advanced_settings_processor.php',true);
	advanced_settings_processor.send(data);	
}

advanced_settings_processor.onreadystatechange = function(){
	var requestState = advanced_settings_processor.readyState;
	if(requestState == 4 && advanced_settings_processor.status == 200){
		if(advanced_settings_processor.responseText == 1){
		$('#advanced_settings_submit').html('Save');
		$('#advanced_settings_success').html('Settings have been saved');
		}else{
			alert(advanced_settings_processor.responseText);
		}
	}
}



create_new_member.onreadystatechange = function(){
	if(create_new_member.readyState == 4 && create_new_member.status == 200){	
		var response_text = create_new_member.responseText;
		var response_array = response_text.split("~");
		$('#new_member_saving_button').html('Save');
		if(response_array[1] == 1 || response_array[1] == '~~~0' || response_array[1] == '~~~1'){
			$('#new_member').fadeOut('fast');
			$('#info_cover').fadeOut('fast');
			$('#member_list').append(response_array[2]);
			
			if(response_array[4] == 1){
				show_window('new_member');
				alert(response_array[0]);
			}
			
		}else if(response_array[0] == 'member_exists'){
			alert('Member with exactly the same name exists. Please create another member');
			
		}else if(response_array[0] == 'member_created'){
			alert('Member created successfully...');
			
		}else{
			alert(create_new_member.responseText);
		}
		
		$('#no_data_message').hide('fast');
		$('#no_data_message').remove();
		
	}
}


check_member.onreadystatechange = function(){
	if(check_member.readyState == 4 && check_member.status == 200){
		var response_text = check_member.responseText;
		var response_array = response_text.split("~");
	
		if(response_array[0] == 0){
			$('#company_name').css('border','solid 1px red');
			//alert('Member with exactly the same name exists. Please create another member');
			
			
		}
	}
}


function create_new_member_function(company_id,user_date){	
	var joining_date = $('#new_year').val()+'-'+$('#new_month').val()+'-'+$('#new_day').val();
	var business_start_date = $('#bus_new_year').val()+'-'+$('#bus_new_month').val()+'-'+$('#bus_new_day').val();
	
	var form_data = new FormData();
	form_data.append("member_name",$('#company_name').val());
	form_data.append("membership_type",$('#membership_type').val());
	form_data.append("applicant_name",$('#applicant').val());
	form_data.append("contact_person",$('#contact_person').val());
	form_data.append("contact_number",$('#contact_number').val());
	form_data.append("email",$('#email').val());
	form_data.append("address",$('#address').val());
	form_data.append("required_documents",$('#required_documents').val());
	form_data.append("messages",$('#new_member_template_messages').val());
	form_data.append("company_id",company_id);
	form_data.append("user_date",user_date);	
	form_data.append("joining_date",joining_date);
	form_data.append("business_start_date",business_start_date);
	form_data.append('continue_adding',$('#continue_adding_input').val());
	form_data.append('branch_id',$('#client_branch').val());
	
	for(var f=0;f<$('#required_documents').val();f++){
		var this_file = document.getElementById('file_'+f).files[0];
		var this_file_name = $('#file_'+f).attr('name');
		form_data.append(this_file_name,this_file);
	}

	create_new_member.open("POST","scripts/new_member_processor.php",true);
	create_new_member.send(form_data);
}


function authenticate_new_member(company_id,user_date){
	if($('#company_name').val() == 'Enter company name here'){
		$('#new_member_error_message').html('You need to enter the company name');
		$('#company_name').css('border-color','red')
	}else if($('#active_type').html() == 'Select membership type'){
		$('#new_member_error_message').html('You need to select a membership type from the types provided');
	}else if($('#applicant').val() == 'Enter applicant name here'){
		$('#new_member_error_message').html('Please provide the applicant\'s name');
		$('#applicant').css('border-color','red')
	}else if($('#contact_person').val() == 'Enter contact person here'){
		$('#new_member_error_message').html('Provide the contact person for this company');
		$('#contact_person').css('border-color','red')
	}else if($('#contact_number').val() == 'Enter contact number here'){
		$('#new_member_error_message').html('Enter a contact number for this company');
		$('#contact_number').css('border-color','red')
	}else if($('#email').val() == 'Enter login email here'){
		$('#new_member_error_message').html('You need to provide an email address for this compnay');
		$('#email').css('border-color','red')
	}else if($('#address').val() == 'Enter member\'s address'){
		$('#new_member_error_message').html('You need to provide an address for this compnay');
		$('#address').css('border-color','red')
	}else{
		
		$('#new_member_saving_button').html('Wait...');
		
		 if($('#required_documents').val() > 0){
			for(var r=0;r<$('#required_documents').val();r++){
				if($('#file_'+r).val() == ''){
					$('#new_member_error_message').html('You need to provide file for "'+$('#document_'+r+'_label').html()+'"');
					break;
				}else if(r==($('#required_documents').val() - 1)){
					create_new_member_function(company_id,user_date);
				}	
			}
		 }else{
			create_new_member_function(company_id,user_date);
		 }
	}
}

function add_message_selection(selection_id){
	var selected_items = $('#new_member_template_messages').val();
	if(selected_items == ''){
		selected_items = selection_id;
	
	}else{
		selected_items = selected_items+','+selection_id;
	}
	
	$('#new_member_template_messages').val(selected_items);
}

function remove_message_selection(selection_id){
	var new_selected_items = '';
	var selected_items = $('#new_member_template_messages').val();
	var item_array = selected_items.split(',');

	for(var i=0;i<item_array.length;i++){
		
		if(item_array[i] != selection_id){
			
			if(new_selected_items == ''){
				new_selected_items = item_array[i];
			
			}else{
				new_selected_items = new_selected_items+','+item_array[i];
			}
		}
	}
	$('#new_member_template_messages').val(new_selected_items);
}

function change_script(script_id){
	if(active_script != ''){
		$('#'+active_script).fadeOut('fast');	
	}
	active_script = 'script_'.script_id;
	$('#script_'+script_id).fadeIn('fast');
}


general_xmlhttp.onreadystatechange = function(){
	var requestState = general_xmlhttp.readyState;

	if(requestState == 4 && general_xmlhttp.status == 200){
			
		var response_text = general_xmlhttp.responseText;
		var response_array = response_text.split("~");
		

		if(response_array[0] == 'fetch_receipt_invoice'){
			$('#invoice_menu').html(response_array[1]);
			$('#active_invoice').html('Select invoice');
			
		}else if(response_array[0] == 'fetch_payment_invoice'){
			$('#payment_invoice_menu').html(response_array[1]);
			$('#active_payment_invoice').html('Select invoice');
		
		}else if(response_array[0] == 'fetch_script'){
			$('#'+response_array[2]).html(response_array[1]);
		
		}else if(response_array[0] == 'display_transaction_details'){
			$('#transaction_details_window').html(response_array[1]);
			
			
		}else if(response_array[0] == 'send_template_message'){
			$('#template_option_'+response_array[2]).html('Select option');
			alert('Your message was sent successfully...');

		}else if(response_array[0] == 'new_staff'){
			if($('#staff_members').html() == '<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center;" id="no_data_message">No records where found.</div>'){
				$('#staff_members').html('');
			}
			
			$('#staff_members').append(response_array[1]);
			close_window('new_staff');
			
		}else if(response_array[0] == 'delete_member_of_staff'){
			close_window('staff_details_'+response_array[1]);
		$('#member_staff_'+response_array[1]).remove();
		
		if($('#staff_members').html() == ''){
			$('#staff_members').html('<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center;" id="no_data_message">No records where found.</div>');
		}
		
		}else if(response_array[0] == 'update_member'){
			
			if(response_array[2] == 1){
				check_invoices(response_array[3]);
			
			}else{
				var c=confirm('Member updated successfully... We need to reload the page for new changes to be visible. Reload page?');
				
				if(c){
					window.open($('#url').val(),'_self');		
				}
			}
		}else if(response_array[0] == 'change_status_selections'){
			var selections = response_array[1];
			selections = selections.split(",");
			
			for(var i=0;i<selections.length;i++){
				if(response_array[2] == 0){
					$('#member_'+selections[i]).css('color','red');
					$('#status_'+selections[i]).html('Suspended');
				
				}else{
					$('#member_'+selections[i]).css('color','black');
					$('#status_'+selections[i]).html('Active');
					
				}
				$('#member_check_'+selections[i]).click();
			}
			$('#active_action').html('Select action');
			hide_progress('main_cover','main_progress');
			
		}else if(response_array[0] == 'delete_selections'){
			var selections = response_array[1];
			selections = selections.split(",");
			
				for(var i=0;i<selections.length;i++){
					if(response_array[2] == 0){
						$('#member_'+selections[i]).remove();
					}
				}
			$('#active_action').html('Select action');
			hide_progress('main_cover','main_progress');
			
		}else if(response_array[0] == 'cancel_transactions'){
			var c = confirm("Transaction entries have been altered. We need to reload the page for new changes to be available. Reload page?");
			
			if(c){
				window.open($('#url').val(),'_self');
			}
			
		}else if(response_array[0] == 'update_account'){
			$('#'+response_array[3]).hide();
			
			//alert(response_array[5]);
			
			//$('#'+response_array[4]).fadeIn('fast');
			
			fetch_script(response_array[5],'script_holder',response_array[3],response_array[6]);
			
		}else if(response_array[0] == 'create_new_branch'){
			close_window('new_account');			
			$('#new_branch_create_button').html('Create');
			$('#branch_menu').append(response_array[1]);
			reload_active_menu();
			
		}else if(response_array[0] == 'update_branch' || response_array[0] == 'delete_branch'){
			reload_active_menu();
			
			if(response_array[0] == 'update_branch'){
				$('#branch_'+response_array[1]).html(response_array[2]);
				
			}else{
				$('#branch_'+response_array[1]).remove();
				
			}
			
		}else if(response_array[0] == 'creat_new_stock'){
			close_window('new_stock');
			reload_active_menu();
			
		}else if(response_array[0] == 'update_stock'){
			reload_active_menu();
			
		}else if(response_array[0] == 'create_job'){
			close_window('new_job');
			$('#job_listing').append(response_array[1]);
			$('#job_create_button').html('Create');
			
			if(response_array[2] == 1){
				window.open('index.php?a=10&force_receipt='+response_array[3],'_self');
			}
			
		}else if(response_array[0] == 'fetch_material'){
			$('#material_selection').html(response_array[1]);
			$('#material_selection').fadeIn('fast');
			
		}else if(response_array[0] == 'create_new_account'){
			close_window('new_account');
			
			//window.open($('#url').val(),'_self');
			
			$('#'+response_array[3]).click();
			
			
		}else if(response_array[0] == 'fetch_item_details'){
			$('#detailed_info').html(response_array[1]);
			
		}else if(response_array[0] == 'inactive_employee_departments' || response_array[0] == 'active_employee_departments' || response_array[0] == 'all_employee_departments'){
			$('#employee_department_listing').html(response_array[1]);
			
			
		}else if(response_array[0] == 'authenticate_user_login'){
			if(response_array[1] == 0){
				$('#errorMsg').val(response_array[2]);
				//$('#login_progress').fadeOut('fast');
				$('#login_cover').hide('fast');
				$('#tag_signin').html('Sign in');
				$('#username_signin').html('Sign in');
				
				$('#progress_bar').fadeOut('fast');
				
			}else{
				$('#loading_text').html('<font color="green">Login successful. Redirecting...</font>');
				$('#user_type').val(response_array[4]);
				$('#login_type').val(response_array[3]);
				$('#login_id').val(response_array[2]);
				$('#login_form').submit();
				
				//alert(response_array[4]);
			}

		}else if(response_array[0] == 'fetch_devices'){
			$('#information_holder').html(response_array[1]);
			
		}else if(response_array[0] == 'new_device'){
			close_window('new_device');
			fetch_devices();
			
		}else if(response_array[0] == 'fetch_device_details'){
			//$('#detailed_info').html(response_array[1]);
			display_infor('detailed_info',response_array[1]);
			
		}else if(response_array[0] == 'update_device'){
			$('#edit_device_update_button').html('Update');
			close_window('item_details');
			
			var c=confirm('Your action was completed successfully... We need to reload the page for changes to appear. Reload page?');
			
			if(c){
				window.open($('#url').val(),'_self');
			
			}
			
		}else if(response_array[0] == 'fetch_menu_items'){
			$('#'+response_array[1]+'_menu').html(response_array[2]);
			$('#new_station_'+response_array[1]).show('fast');
			
			if(response_array[3] == 0){
				$('#active_'+response_array[1]).html('No '+response_array[1]+' found');
				
			}else{
				$('#active_'+response_array[1]).html('Select '+response_array[1]);
				
			}
			
		}else if(response_array[0] == 'create_new_user'){
			var c=confirm('Your action was completed successfully... We need to reload the page for changes to appear. Reload page?');
			
			if(c){
				window.open($('#url').val(),'_self');
			
			}
			
		}else if(response_array[0] == 'fetch_claim_types'){
			display_infor('section_information',response_array[1]);
			
			
		}else if(response_array[0] == 'create_claim_type'){
			close_window('new_claim_type');
			fetch_claim_types();
			$('#create_claim_type').html('Create');
			
		}else if(response_array[0] == 'fetch_claim_type_details'){
			display_infor('detailed_info',response_array[1]);
			
		}else if(response_array[0] == 'delete_claim_type'){
			close_window('item_details');
			fetch_claim_types();
			
		}else if(response_array[0] == 'fetch_level_locations'){
			$('#active_'+response_array[1]+'_location').html('All locations');
			$('#edit_'+response_array[1]+'_location').val(0);
			$('#'+response_array[1]+'_location_menu').html(response_array[2]);
			
		}else if(response_array[0] =='update_claim_type'){
			close_window('item_details');
			fetch_claim_types();
			
		}else if(response_array[0] == 'fetch_payment_claims'){
			display_infor('section_information',response_array[1]);
			
		}else if(response_array[0] == 'create_claim'){
			fetch_payment_claims();
			close_window('new_claim');
			$('#selected_search_beneficiaries').val('');
			$('#create_claim_button').html('Create');
			
		}else if(response_array[0] == 'fetch_claim_details'){
			display_infor('detailed_info',response_array[1]);
			
		}else if(response_array[0] == 'delete_claim'){
			close_window('item_details');
			fetch_payment_claims();
			
		}else if(response_array[0] == 'edit_claim'){
			general_variable_1 = $('#new_claim_holder').html();
			$('#new_claim_holder').html('');
			display_infor('this_claim_details',response_array[1]);
			
		}else if(response_array[0] =='update_claim'){
			close_window('edit_claim');
			fetch_payment_claims();
			
		}else if(response_array[0] =='confirm_level'){
			
			var succeeded_entries = response_array[5];
			var succeeded_entries_array = succeeded_entries.split(',');
			
			if(succeeded_entries != 0){
				for(var s=0;s<succeeded_entries_array.length;s++){
					var this_beneficiary_date = succeeded_entries_array[s];
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).html('&#8594;');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('backgroundColor','#6ac96a');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('color','#fff');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('textAlign','center');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr('title',response_array[3]);
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr("onmouseover","this.style.backgroundColor='#53a953'");
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr("onmouseout","this.style.backgroundColor='#6ac96a'");
				}
				
				fetch_claim_beneficiaries(response_array[6]);
			}
			//alert(succeeded_entries_array.length);
			if(succeeded_entries_array.length > 1 || succeeded_entries == 0){
				//alert(succeeded_entries);
				$('#all_actions_'+response_array[6]+'_'+response_array[7]+'_'+response_array[2]).html('');
			
			}			
			
			
			if(succeeded_entries == 0){
				alert('No entry was affected. If selection is disabled, you will need to act on the entries individualy');
			}
			
			if(response_array[4] != 0){
				//alert(response_array[4]);
				alert('One or more of the previous levels is not confirmed. Entries for unconfirmed levels are not confirmed');
				
				$('#beneficiary_'+response_array[1]+'_'+'level_'+response_array[2]).html(data_holder);
			}
		
		}else if(response_array[0] == 'deny_confirm'){
			var succeeded_entries = response_array[5];
			var succeeded_entries_array = succeeded_entries.split(',');
			
			if(succeeded_entries != 0){
				for(var s=0;s<succeeded_entries_array.length;s++){
					var this_beneficiary_date = succeeded_entries_array[s];
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).html('&#8592;');
				
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('backgroundColor','brown');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('color','#fff');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).css('textAlign','center');
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr('title',response_array[3]);
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr("onmouseover","this.style.backgroundColor='#852828'");
					
					$('#beneficiary_'+this_beneficiary_date+'_'+'level_'+response_array[2]).attr("onmouseout","this.style.backgroundColor='brown'");
				
				}
				
				fetch_claim_beneficiaries(response_array[6]);
			}
			
			if(succeeded_entries_array.length > 1 || succeeded_entries == 0){
				$('#all_actions_'+response_array[6]+'_'+response_array[7]+'_'+response_array[2]).html('');
			
			}
			
			if(succeeded_entries == 0){
				alert('No entry has been affected. If selection is disabled, you will need to act on the entries individualy');
			}
					
			if(response_array[4] != 0){
				//alert(response_array[4]);
				alert('One or more of the previous levels is not confirmed. Entries for unconfirmed levels are not acted on');
			}
			
			close_window('deny_comment');
			$('#deny_button').html('Deny');
			
		}else if(response_array[0] == 'tmp_single_upload'){
			var item_id = response_array[3];
			var responses = response_array[1];
			var errors = response_array[2];
			
			$('#image_'+item_id+'_progress').hide('fast');
			$('#image_'+item_id+'_holder').hide('fast');
			$('#image_'+item_id+'_error').fadeIn('fast');
			
			var cancel_error = '<div style="display:none;float:right;border:solid 1px #aaa;cursor:pointer;height:20px;width:40px;line-height:20px;text-align:center;line-height:20px;" onclick="$(\'#image_'+item_id+'_error\').fadeOut(\'fast\');$(\'#image_'+item_id+'_holder\').fadeIn(\'fast\');">OK</div>';
			
			if(errors == 0){
				$('#image_'+item_id+'_error').css('color','red');
				$('#image_'+item_id+'_error').html('Error uploading image... '+responses+cancel_error);
			
			}else{
				$('#image_'+item_id+'_error').css('color','green');
				$('#image_'+item_id+'_error').html('Successful...('+responses+cancel_error+')');
				
				if($('#uploaded_files').val() == ''){
					$('#uploaded_files').val(response_array[1]);
					
				}else{
					$('#uploaded_files').val($('#uploaded_files').val()+','+response_array[1])
				}
			}
			
			if($('#file_upload_confirm_function').val() != ''){
				var file_upload_confirm_function = $('#file_upload_confirm_function').val();
				eval(file_upload_confirm_function);
			}
			
			//alert(file_upload_confirm_function);
			
		}else if(response_array[0] == 'fetch_site_agents'){
			$('#new_claim_agents_holder').html(response_array[1]);
			recalculate_claim_total();
			
		}else if(response_array[0] == 'fetch_agent_days'){
			$('#beneficiary_'+response_array[1]+'_'+response_array[2]+'_progress').fadeOut('fast');
			$('#days_'+response_array[1]+'_'+response_array[2]).val(response_array[3]);
			$('#paid_days_'+response_array[1]+'_'+response_array[2]).val(response_array[4]);
			
			$('#amount_'+response_array[1]+'_'+response_array[2]).val(response_array[4] * Number($('#rate_'+response_array[1]+'_'+response_array[2]).val()));
			
			//alert(response_array[2] * Number($('#rate_'+response_array[1]).val()));
			recalculate_claim_total();
			
			$('#check_'+response_array[1]+'_'+response_array[2]).attr('checked',true);
			
			if($('#selected_agents_'+response_array[1]).val() == ''){
				$('#selected_agents_'+response_array[1]).val(response_array[2]);
				
			}else{
				var selected_agents = $('#selected_agents_'+response_array[1]).val();
				var selected_agents_array = selected_agents.split(',');
				
				var found = 0;
				for(var i=0;i<selected_agents_array.length;i++){
					if(selected_agents_array[i] == response_array[2]){
						found = 1;
						
					}
					
				}

				if(found == 0){
					$('#selected_agents_'+response_array[1]).val($('#selected_agents_'+response_array[1]).val()+','+response_array[2]);
					
					
				}
				
				$('#comment_'+response_array[1]+'_'+response_array[2]).val('');
			}
			recalculate_claim_total();
			
		}else if(response_array[0] == 'search_claim_site'){
			$('#claim_site_search_results').html(response_array[1]);
			
		}else if(response_array[0] == 'search_claim_beneficiary'){
			$('#claim_beneficiary_search_results').html(response_array[1]);
			
		}else if(response_array[0] == 'search_new_claim_beneficiary'){
			$('#new_claim_beneficiary_search_results').html(response_array[1]);
			
		}else if(response_array[0] == 'show_vote_filter'){
			$('#'+response_array[1]+'_menu').html(response_array[3]);
			hide_vote_filter_sections(response_array[2]);
			
		}else if(response_array[0] == 'fetch_tracker'){
			display_infor('information_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_report'){
			if($('#selected_report').val() != 4){
				display_infor('report_container',response_array[1]);
				
			}else{
				$('#report_container').html(response_array[1]);
			}
			
			//var restore_report = setTimeout('fetch_report',10000);
			
		}else if(response_array[0] == 'fetch_claim_beneficiaries'){
			display_infor('payment_claim_container_'+response_array[1],response_array[2]);
			$('#claim_'+response_array[1]+'_selected_beneficiaries').val(response_array[3]);
			
			$('#claim_'+response_array[1]+'_actions').slideDown('fast');
			
		}else if(response_array[0] == 'fetch_divisions'){
			
			if(response_array[2] == 0){
				$('#active_division').html('<i>Not applicable</i>');
				$('#new_station_division_id').val(0);
				$('#division_menu').html('');
			}else{
				$('#division_menu').html(response_array[1]);			
				$('#active_division').html('Select division');
			
			}
		
			
			
		}else{
			alert(response_array[0]);
			//close_window('script_'+response_array[0]);
			//var c=confirm('Your action was completed successfully... We need to reload the page for changes to appear. Reload page?');
			
			if(c){
			//	window.open($('#url').val(),'_self');
			
			}
		}
	}
}

function tmp_single_upload(company_id,item_id){
	
	$('#image_'+item_id+'_progress').show('fast');
	$('#image_'+item_id+'_error').hide();
	$('#image_'+item_id+'_holder').hide('fast');
	
	if($('#file_upload_progress_function').val() != ''){
		var file_upload_progress_function = $('#file_upload_progress_function').val();
		eval(file_upload_progress_function);
	}
	
	var data = new FormData();
	
	data.append('tmp_single_upload',1);
	data.append('item_id',item_id);
	data.append('company_id',$('#active_company_id').val());
	data.append('image_'+item_id,document.getElementById('image_'+item_id).files[0]);
	
	send_general_xmlhttp(data);
}


function tmp_image_upload(company_id){
		var data = new FormData();
		var items = Number($('#items').val());

		data.append('tmp_image_upload',1);
		data.append('total_images',items);
		data.append('company_id',$('#active_company_id').val());

		for(var i =0;i<(items + 1);i++){
			$('#image_'+i+'_progress').show('fast');
			$('#image_'+i+'_error').hide();
			$('#image_'+i+'_holder').hide('fast');
				data.append('image_'+i,document.getElementById('image_'+i).files[0]);
		}	
		send_general_xmlhttp(data);		
}

function open_uploader(function_name, multiple_images){
	//alert('heyo');
	show_window('image_uploader',1);
	
	if(multiple_images == 0){
		$('#uploader_more_images').hide('fast');
	}
	$('#save_upload_images').attr('onclick',function_name);	
	
	add_upload_field();
}

function reset_image_upload(){
	$('#uploaded_files').val(general_variable_1);
	
	var items = Number($('#items').val());
	
	for(var i =0;i<(items +1);i++){
		$('#image_'+i+'_progress').hide('fast');
		$('#image_'+i+'_error').hide();
		$('#image_'+i+'_holder').show('fast');
		$('#image_'+i).val('');
		
		if(i != 0){
			$('#image_'+i+'_holder').remove();
			
		}
	}
	
	$('#items').val(0);
	
	$('#uploader_error_message').html('');
	$('#uploader_error_message').hide('fast');
	
	close_window_special('image_uploader','new_claim');
}

function process_claim_image(){
	close_window_special('image_uploader','new_claim');
	
	var uploaded_files = $('#uploaded_files').val();
	var uploaded_files_array = uploaded_files.split(",");
	
	if($('#uploaded_claim_file').val() != ''){
		if($('#prev_upload_file').val() == ''){
			$('#prev_upload_file').val($('#uploaded_claim_file').val());
		
		}else{
			$('#prev_upload_file').val($('#prev_upload_file').val()+','+$('#uploaded_claim_file').val());	
		}
	}
	
	$('#uploaded_images').html('');
	for(var i=0;i<uploaded_files_array.length;i++){
		
		var added_image= '<div style="width:auto;height:25px;float:left;padding:2px;margin:2px;border:solid 1px #ddd" id="file_'+i+'"><div style="cursor:pointer;width:auto;float:left;height:25px;line-height:25px;background-color:#efe;" onmouseover="this.style.backgroundColor=\'#dfd\';" onmouseout="this.style.backgroundColor=\'#efe\';" title="Click to view file" id="file_div_'+i+'" onclick="window.open(\''+$('#url').val()+'/imgs/'+uploaded_files_array[i]+'\',\'file\');">'+uploaded_files_array[i]+'</div><div style="margin-left:2px;width:20px;height:25px;float:left;color:#fff;line-height:25px;text-align:center;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#f00\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="var c=confirm(\'This will remove this file. Proveed?\');if(c){remove_from_selection(\''+uploaded_files_array[i]+'\',\'uploaded_files\');$(\'#file_'+i+'\').remove();}">X</div></div>';
		
		$('#uploaded_images').show('fast');
		$('#uploaded_images').append(added_image);
		$('#uploaded_claim_file').val($('#uploaded_files').val());
	}
}

function process_edit_claim_image(){
	close_window('image_uploader');
	
	var uploaded_files = $('#uploaded_files').val();
	var uploaded_files_array = uploaded_files.split(",");
		
		if($('#prev_claim_file_src').val() == ''){
			$('#prev_claim_file_src').val($('#edit_uploaded_claim_file').val());
			
		}else{
			$('#prev_claim_file_src').val($('#prev_claim_file_src').val()+','+$('#edit_uploaded_claim_file').val());
		}
	
	for(var i=0;i<uploaded_files_array.length;i++){
		var added_image = '<div style="width:100%;height:20px;line-height:20px;float:left;color:green;">'+uploaded_files_array[i]+'</div>';
		
		$('#edit_uploaded_images').show('fast');
		$('#edit_uploaded_images').html(added_image);
		$('#edit_uploaded_claim_file').val(uploaded_files_array[i]);
	}
}

check_new_invoices.onreadystatechange = function(){
	
	var requestState = check_new_invoices.readyState;

	if(requestState == 4 && check_new_invoices.status == 200){
		if(check_new_invoices.responseText == 1){
			var c=confirm("New invoices where generated. We need to reload the page for invoices to appear on transactions. Reload page?");
			
			if(c){window.open($('#url').val(),'_self');}
			
		}else if(check_new_invoices.responseText == 0){
			alert("Invoicing is up to date. No invoices where generated");
			
			$('#active_action').html('Select action');
		}else{
			
			alert(check_new_invoices.responseText);
		}
	}
	
}



function check_scroll(){
	
	clearTimeout(rep_timer);
	rep_timer = setTimeout("reposition_item('section_holder')",100);
	
	if(window.pageYOffset > 80){
		$('#header_2').fadeIn('medium');
		
	}else{
		$('#header_2').fadeOut('fast');
	}
	
}

function reposition_item(item_id){
	$('#'+item_id).animate({marginTop:window.pageYOffset},'slow');
	
}


function send_general_xmlhttp(a){
	general_xmlhttp.open('POST','scripts/general_xmlhttp_processor.php',true);
	general_xmlhttp.send(a);
}

function fetch_receipt_invoices(a,b){
	var data = new FormData();
	$('#active_invoice').html('Fetching invoices. Wait....');
	data.append("fetch_receipt_invoice",a);
	data.append("company_id",b);
	send_general_xmlhttp(data);
}

function fetch_payment_invoices(a,b){
	var data = new FormData();
	$('#active_payment_invoice').html('Fetching invoices. Wait....');
	data.append("fetch_payment_invoice",a);
	data.append("company_id",b);
	send_general_xmlhttp(data);
}

function fetch_script(script_src,output_holder_id,company_id,account_section_selector,account_type,menu_id){

	$('#'+output_holder_id).html('<div style="width:100%;height:30px;line-height:30px;margin-top:50px;text-align:center;font-size:1.2em;">Fetching data. Please wait...</div>');

	var data = new FormData();
	if(account_section_selector){
	data.append('account_section_selector',account_section_selector);
	}
	data.append('fetch_script',1)
	data.append('company_id',company_id);
	data.append('script_src',script_src);
	data.append('output_holder_id',output_holder_id);
	data.append('account_type',account_type);
	data.append('menu_id',menu_id);
	data.append('branch_id',$('#branch_id').val());
	data.append('branch_date',$('#branch_date').val());
	send_general_xmlhttp(data);
}



function display_trans_details(transaction_id,voucher_type,company_id,trans_type){
	show_window('transaction_details');
	$('#transaction_details_window').html('<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:30px;text-align:center;font-size:1.2em;">Fetching data. Please wait...</div>');
	var data = new FormData();
	data.append('display_transaction_details',transaction_id);
	data.append('company_id',company_id);
	data.append('voucher_type',voucher_type);
	data.append('trans_type',trans_type);
	send_general_xmlhttp(data);
}

function authenticate_new_receipt(script_id){
	if($('#new_receipt_debtor_id').val() == 0){
		$('#new_receipt_error').html('You need to select an account to credit account');
	
	}else if($('#new_receipt_creditor_id').val() == 0){
		$('#new_receipt_error').html('You need to select an account to debit account');
		
	}else if($('#new_receipt_invoice_id').val() == 0){
		$('#new_receipt_error').html('You need to select atleast one invoice to receive payment for');
	
	}else{
	var receipt_date = $('#new_receipt_year').val()+'-'+$('#new_receipt_month').val()+'-'+$('#new_receipt_day').val();
	
	//alert(receipt_date);
	
	var data = new FormData();
	data.append('new_receipt',1);
	data.append('receipt_date',receipt_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('new_receipt_debtor_date',$('#new_receipt_debtor_id').val());
	data.append('new_receipt_creditor_date',$('#new_receipt_creditor_id').val());
	data.append('selected_invoices',$('#new_receipt_invoice_id').val());
	data.append('receipt_amount_received',$('#receipt_amount_received').val());
	data.append('payment_mode',$('#payment_mode').val());
	data.append('cheque_no',$('#cheque_no').val());
	data.append('send_receipt',$('#send_receipt').val());
	data.append('narration',$('#receipt_narration').val());
	data.append('receipt_type',0);
	data.append('user_date',$('#active_user_date').val());
	data.append('script',script_id);
	
	var selected_invoice_array = $('#new_receipt_invoice_id').val().split(",");
	
	for(var si=0;si<selected_invoice_array.length;si++){
		data.append('invoice_'+selected_invoice_array[si]+'_amount',$('#invoice_'+selected_invoice_array[si]+'_amount').val());
	}
	
	send_general_xmlhttp(data);
		
	}
	
	
}

function authenticate_new_payment(script_id){
	if($('#new_payment_debtor_id').val() == 0){
		$('#new_payment_error').html('You need to select an account to debit');
	
	}else if($('#new_payment_creditor_id').val() == 0){
		$('#new_payment_error').html('You need to select an account to credit');
		
	}else if($('#new_payment_invoice_id').val() == 0){
		$('#new_payment_error').html('You need to select atleast one invoice to pay for');
	
	}else{
	var payment_date = $('#new_payment_year').val()+'-'+$('#new_payment_month').val()+'-'+$('#new_payment_day').val();
	
	//alert(receipt_date);
	
	var data = new FormData();
	data.append('new_payment',1);
	data.append('payment_date',payment_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('new_payment_debtor_date',$('#new_payment_debtor_id').val());
	data.append('new_payment_creditor_date',$('#new_payment_creditor_id').val());
	data.append('selected_invoices',$('#new_payment_invoice_id').val());
	data.append('payment_amount_received',$('#payment_amount_received').val());
	data.append('payment_mode',$('#payment_mode').val());
	data.append('cheque_no',$('#cheque_no').val());
	data.append('send_payment',$('#send_payment').val());
	data.append('narration',$('#payment_narration').val());
	data.append('payment_type',0);
	data.append('user_date',$('#active_user_date').val());
	data.append('script',script_id);
	
	var selected_invoice_array = $('#new_payment_invoice_id').val().split(",");
	
	for(var si=0;si<selected_invoice_array.length;si++){
		data.append('payment_invoice_'+selected_invoice_array[si]+'_amount',$('#invoice_'+selected_invoice_array[si]+'_amount').val());
	}
	
	send_general_xmlhttp(data);
		
	}
	
	data.append('sub_area_id',$('#active_submenu').val());
	
	
}

function add_invoice_selection(invoice_title,invoice_id,invoice_amount){
	var current_selected_invoices = $('#new_receipt_invoice_id').val();
	var current_selected_invoices_array = current_selected_invoices.split(",");
	
	for(var i=0;i<current_selected_invoices_array.length;i++){
		
		if(current_selected_invoices_array[i] != invoice_id ){
			if(i == (current_selected_invoices_array.length - 1)){
			
				if($('#new_receipt_invoice_id').val() == 0){
					var selected_invoices = invoice_id;
		
				}else{
					var selected_invoices = $('#new_receipt_invoice_id').val()+','+invoice_id;
				}
	
				if($('#receipt_amount_received').val() == 'Enter amount here'){
					var invoices_total_amount = 0;
	
				}else{
					var invoices_total_amount =  parseFloat($('#receipt_amount_received').val());
				}
	
				invoices_total_amount +=  invoice_amount;

				var field = '<div style="width:auto;float:left;" id="selected_invoice_'+invoice_id+'_container"><div class="option_item"   onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" onclick="window.open(\'pdf_export.php?t='+invoice_id+'&i=0\',\'view_invoice\');">'+invoice_title+'</div><div style="line-height:20px;width:70px;height:20px;float:left;line-height:30px;">Amount(K):</div><div class="option_item" title="Click to change option" id="selected_invoice_'+invoice_id+'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="width:50px;"><input type="text" name="invoice_'+invoice_id+'_amount" id="invoice_'+invoice_id+'_amount" value="'+invoice_amount+'" style="width:100%;"></div><div style="cursor:pointer;line-height:27px;width:27px;height:27px;float:left;text-align:center;background-color:#eee;" onclick="remove_selected_invoice('+invoice_id+')">X</div></div>';
	
				$('#receipt_invoice_selections').show('fast');
				$('#receipt_invoice_selections').append(field);
				$('#new_receipt_invoice_id').val(selected_invoices);
				$('#receipt_amount_received').css('color','#000');
				$('#receipt_amount_received').val(invoices_total_amount);
			}
	
		}else{
			alert('You have already added this invoice to invoice set');	
		}
	}
}

function add_payment_invoice_selection(invoice_title,invoice_id,invoice_amount){
	var current_selected_invoices = $('#new_payment_invoice_id').val();
	var current_selected_invoices_array = current_selected_invoices.split(",");
	
	for(var i=0;i<current_selected_invoices_array.length;i++){
		
		if(current_selected_invoices_array[i] != invoice_id ){
			if(i == (current_selected_invoices_array.length - 1)){
			
				if($('#new_payment_invoice_id').val() == 0){
					var selected_invoices = invoice_id;
		
				}else{
					var selected_invoices = $('#new_payment_invoice_id').val()+','+invoice_id;
				}
	
				if($('#payment_amount_received').val() == 'Enter amount here'){
					var invoices_total_amount = 0;
	
				}else{
					var invoices_total_amount =  parseFloat($('#payment_amount_received').val());
				}
	
				invoices_total_amount +=  invoice_amount;

				var field = '<div style="width:auto;float:left;" id="selected_invoice_'+invoice_id+'_container"><div class="option_item"   onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" onclick="window.open(\'pdf_export.php?t='+invoice_id+'&i=1\',\'view_invoice\');">'+invoice_title+'</div><div style="line-height:20px;width:70px;height:20px;float:left;line-height:30px;">Amount(K):</div><div class="option_item" title="Click to change option" id="selected_invoice_'+invoice_id+'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" style="width:50px;"><input type="text" name="invoice_'+invoice_id+'_amount" id="invoice_'+invoice_id+'_amount" value="'+invoice_amount+'" style="width:100%;"></div><div style="cursor:pointer;line-height:27px;width:27px;height:27px;float:left;text-align:center;background-color:#eee;" onclick="remove_selected_payment_invoice('+invoice_id+')">X</div></div>';
	
				$('#payment_invoice_selections').show('fast');
				$('#payment_invoice_selections').append(field);
				$('#new_payment_invoice_id').val(selected_invoices);
				$('#payment_amount_received').css('color','#000');
				$('#payment_amount_received').val(invoices_total_amount);
			}
	
		}else{
			alert('You have already added this invoice to invoice set');	
		}
	}
}

function remove_selected_payment_invoice(invoice_id){
	var remaining_invoices = '';
	var selected_invoices = $('#new_payment_invoice_id').val();
	var selected_invoices_array = selected_invoices.split(",");
	
	for(var i=0;i<selected_invoices_array.length;i++){
		if(selected_invoices_array[i] != invoice_id){
			if(remaining_invoices == ''){
				remaining_invoices = selected_invoices_array[i]
			}else{
				remaining_invoices = remaining_invoices+','+selected_invoices_array[i];
			}
		
		}
	}
	
	var this_amount = parseFloat($('#invoice_'+invoice_id+'_amount').val());
	if(remaining_invoices == ''){
		var received_invoice_amount = 'Enter amount here';
		$('#payment_amount_received').css('color','#aaa');
		
	}else{
		var received_invoice_amount = parseFloat($('#payment_amount_received').val()) - this_amount;
	
		
	}
	
	$('#selected_invoice_'+invoice_id+'_container').remove();
	$('#new_payment_invoice_id').val(remaining_invoices);
	$('#payment_amount_received').val(received_invoice_amount);
	if(remaining_invoices == ''){
		$('#payment_invoice_selections').hide('fast');
		$('#active_invoice').html('Select invoice');
	}	
}

function remove_selected_invoice(invoice_id){
	var remaining_invoices = '';
	var selected_invoices = $('#new_receipt_invoice_id').val();
	var selected_invoices_array = selected_invoices.split(",");
	
	for(var i=0;i<selected_invoices_array.length;i++){
		if(selected_invoices_array[i] != invoice_id){
			if(remaining_invoices == ''){
				remaining_invoices = selected_invoices_array[i]
			}else{
				remaining_invoices = remaining_invoices+','+selected_invoices_array[i];
			}
		
		}
	}
	
	var this_amount = parseFloat($('#invoice_'+invoice_id+'_amount').val());
	if(remaining_invoices == ''){
		var received_invoice_amount = 'Enter amount here';
		$('#receipt_amount_received').css('color','#aaa');
		
	}else{
		var received_invoice_amount = parseFloat($('#receipt_amount_received').val()) - this_amount;
	
		
	}
	
	$('#selected_invoice_'+invoice_id+'_container').remove();
	$('#new_receipt_invoice_id').val(remaining_invoices);
	$('#receipt_amount_received').val(received_invoice_amount);
	if(remaining_invoices == ''){
		$('#receipt_invoice_selections').hide('fast');
		$('#active_invoice').html('Select invoice');
	}	
}

function clear_receipt_invoices(){
	$('#receipt_invoice_selection_fields').html('');
	$('#receipt_invoice_selections').hide();
	$('#new_receipt_invoice_id').val(0);
}

function clear_payment_invoices(){
	$('#payment_invoice_selection_fields').html('');
	$('#payment_invoice_selections').hide();
	$('#new_payment_invoice_id').val(0);
}

function send_auto_message(template_id,account_id,account_type){
	$('#template_option_'+template_id).html('Sending...');
	
	var data = new FormData();
	
	data.append('send_template_message',1)
	data.append('template_id',template_id);
	data.append('account_id',account_id);
	data.append('account_type',account_type);
	data.append('company_id',$('#active_company_id').val());
	
	send_general_xmlhttp(data);
}

function show_staff_member(staff_id){
	show_window('staff_details_'+staff_id);
	
}

function authenticate_new_staff(member_date,company_id,user_type,user_date){
	
	if($('#staff_name').val() == 'Enter staff name here'){
		$('#new_staff_error_message').html('Enter name of staff');

	}else if($('#staff_age').val() == 'Enter age of staff here'){
		$('#new_staff_error_message').html('Enter age of staff');
		
	}else if($('#staff_contact_number').val() == 'Enter staff contact number here'){
		$('#new_staff_error_message').html('You need to put staff contact number');
		
	}else if($('#staff_email').val() == 'Enter staff email here'){
		$('#new_staff_error_message').html('Provide email for this staff');
		
	}else if($('#staff_position').val() == 'Enter staff position here'){
		$('#new_staff_error_message').html('Enter position for new staff');
		
	}else if($('#staff_details').val() == 'Enter some details here'){
		$('#new_staff_error_message').html('Enter brief description of new staff and work experiences');
	
		
	}else{
		var data = new FormData();
		data.append('new_staff',1);
		data.append('company_id',company_id);
		data.append('member_date',member_date);
		data.append('user_type',user_type);
		data.append('user_date',user_date);
		data.append('staff_name',$('#staff_name').val());
		data.append('staff_age',$('#staff_age').val());
		data.append('staff_contact_number',$('#staff_contact_number').val());
		data.append('staff_email',$('#staff_email').val());
		data.append('staff_position',$('#staff_position').val());
		data.append('staff_day',$('#staff_new_day').val());
		data.append('staff_month',$('#staff_new_month').val());
		data.append('staff_year',$('#staff_new_year').val());
		data.append('staff_details',$('#staff_details').val());
		
		send_general_xmlhttp(data);		
	}	
}

function delete_member_of_staff(staff_id){
	var data = new FormData();
	data.append('delete_member_of_staff',1);
	data.append('staff_id',staff_id);
	
	send_general_xmlhttp(data);
}

function update_member_profile(member_id){
	var joining_date = $('#member_edit_joining_year').val()+'-'+$('#member_edit_joining_month').val()+'-'+$('#member_edit_joining_day').val();
	var business_start_date = $('#member_edit_start_year').val()+'-'+$('#member_edit_start_month').val()+'-'+$('#member_edit_start_day').val();
	
	var data = new FormData();
	
	data.append('update_member',member_id);
	data.append('member_name',$('#member_edit_name').val());
	data.append('joining_date',joining_date);
	data.append('business_start_date',business_start_date);
	data.append('applicant',$('#member_edit_applicant').val());
	data.append('contact_person',$('#member_edit_contact_person').val());
	data.append('contact_number',$('#member_edit_contact_number').val());
	data.append('email',$('#member_edit_email').val());
	data.append('password',$('#member_edit_password').val());
	data.append('address',$('#member_edit_address').val());
	
	if($('#active_account_type').val() == 0){
		var c=confirm('Changing joining date might affect invoicing. Do you want to delete all receipts and re-generate invoices for this account? Note that you will need to re-nter all receipts for this account.');
		
		if(c){
			data.append('recreate_invoices',1);
		}
	}
	
	send_general_xmlhttp(data);
}

function check_invoices(company_id){
	var data = new FormData();
	data.append('company_id',company_id);
	
	check_new_invoices.open('POST','invoicing_crone.php',true);
	check_new_invoices.send(data);
}

function add_to_selections(item_id){
	var current_selections = $('#item_selections').val();
	
	if(current_selections == ''){
		current_selections = item_id;
	
	}else{
		current_selections = current_selections+','+item_id;
	}
	
	$('#item_selections').val(current_selections);
}

function remove_from_selection(selection_id,input_id){
	var new_selected_items = '';
	var selected_items = $('#'+input_id).val();
	var item_array = selected_items.split(',');

	for(var i=0;i<item_array.length;i++){
		
		if(item_array[i] != selection_id){
			
			if(new_selected_items == ''){
				new_selected_items = item_array[i];
			
			}else{
				new_selected_items = new_selected_items+','+item_array[i];
			}
		}
	}
	$('#'+input_id).val(new_selected_items);
}


function remove_selections(item_id){
	if($('#item_selections').val() != ''){
		var current_selections = $('#item_selections').val();
		current_selections = current_selections.split(",");
		var new_selections = '';
		for(var i=0;i<current_selections.length;i++){
			if(current_selections[i] != item_id){
				
				if(new_selections == ''){
					new_selections = current_selections[i];
				
				}else{
					new_selections = new_selections+','+current_selections[i];
				}
			}		
		}
	
		$('#item_selections').val(new_selections);
	}
}


function add_to_selections_general(item_id,input_id){
	var current_selections = $('#'+input_id).val();
	
	if(current_selections == ''){
		current_selections = item_id;
	
	}else{
		current_selections = current_selections+','+item_id;
	}
	
	$('#'+input_id).val(current_selections);
}


function remove_selections_general(item_id,input_id){
	if($('#'+input_id).val() != ''){
		var current_selections = $('#'+input_id).val();
		current_selections = current_selections.split(",");
		var new_selections = '';
		for(var i=0;i<current_selections.length;i++){
			if(current_selections[i] != item_id){
				
				if(new_selections == ''){
					new_selections = current_selections[i];
				
				}else{
					new_selections = new_selections+','+current_selections[i];
				}
			}		
		}
	
		$('#'+input_id).val(new_selections);
	}
}



function change_status_selections(action){
	if($('#item_selections').val() != ''){
		display_progress('main_cover','main_progress');
		var data = new FormData();
		data.append('change_status_selections',$('#item_selections').val());
		data.append('action',action);
		send_general_xmlhttp(data);
		
	}else{
		alert('You need to select atleast one item');
		$('#active_action').html('Select action');
	}
}

function delete_selections(account_type){
	if($('#item_selections').val() != ''){
		display_progress('main_cover','main_progress');
		
		var data = new FormData();
		data.append('delete_selections',$('#item_selections').val());
		data.append('account_type',account_type);
		send_general_xmlhttp(data);
		
	}else{
		alert('You need to select atleast one item');	
		$('#active_action').html('Select action');
	}
}

function cancel_transactions(type){
	
	if($('#item_selections').val() != ''){
		display_progress('main_cover','main_progress');
		var item = $('#item_selections').val();
		var data = new FormData();
		data.append('cancel_transactions',$('#item_selections').val());
		data.append('action_type',type);
		data.append('company_id',$('#active_company_id').val());
		send_general_xmlhttp(data);
		
	}else{
		alert('You need to select atleast one item');
		$('#active_action').html('Select action');
	}
}


function restore_transactions(){
	
	if($('#item_selections').val() != ''){
		display_progress('main_cover','main_progress');
		var item = $('#item_selections').val();
		var data = new FormData();
		data.append('restore_transactions',$('#item_selections').val());
		data.append('company_id',$('#active_company_id').val());
		send_general_xmlhttp(data);
		
	}else{
		alert('You need to select atleast one item');
		$('#active_action').html('Select action');
	}
}

function send_chat_processor(a){
	chat_processor.open('POST','scripts/chat_processor.php',true);
	chat_processor.send(a);
	
	//alert('hey');
}

chat_processor.onreadystatechange = function(){	
	if(chat_processor.readyState == 4 && chat_processor.status == 200){
		var response_text = chat_processor.responseText;
		var response_array = response_text.split("~");
		
		if(response_array[0] == 'online_checker'){
			z = setTimeout("online_status_extender();",5000);
			$('#online_companies').html(response_array[1]);
			
			var online_admins = response_array[2];
			var online_admins_array = online_admins.split(',');
			for(var oa=0;oa<online_admins_array.length;oa++){
				var admin_id_array = online_admins_array[oa].split('-');
				
				
				if($('#online_admin_'+admin_id_array[0]).val() == undefined){
					var item_div = '<input type="hidden" id="online_admin_'+admin_id_array[0]+'">';
					$('#online_items').append(item_div);
					
					if(admin_id_array[1] > 0){
						playSound('sounds/'+$('#sound_file').val());
						
					}
					
					$('#online_admin_'+admin_id_array[0]).val(admin_id_array[1]);
				}else{
					if($('#online_admin_'+admin_id_array[0]).val() < admin_id_array[1]){
						playSound('sounds/'+$('#sound_file').val());
						
						$('#online_admin_'+admin_id_array[0]).val(admin_id_array[1]);
					}
				}
				
			}
			
			var online_clients = response_array[3];
			var online_clients_array = online_clients.split(',');
			for(var oa=0;oa<online_clients_array.length;oa++){
				var client_id_array = online_clients_array[oa].split('-');
				
				
				if($('#online_client_'+client_id_array[0]).val() == undefined){
					var item_div = '<input type="hidden" id="online_client_'+client_id_array[0]+'">';
					$('#online_items').append(item_div);
					
					if(client_id_array[1] > 0){
						playSound('sounds/'+$('#sound_file').val());
						
					}
					
					$('#online_client_'+client_id_array[0]).val(client_id_array[1]);
				}else{
					if($('#online_client_'+client_id_array[0]).val() < client_id_array[1]){
						playSound('sounds/'+$('#sound_file').val());
						
						$('#online_client_'+client_id_array[0]).val(client_id_array[1]);
					}
				}
				
			}
			
			
			
		}else if(response_array[0] == 'online_status_extender'){
			z = setTimeout("online_checker();",5000);
			
		}else if(response_array[0] == 'show_budge'){
			var chat_budge = response_array[4];
			var budge_id = response_array[2];
			
			chat_budge = chat_budge.replace(/-definer-/g,"<script>");
			chat_budge = chat_budge.replace(/-definer_end-/g,"</script>");
			chat_budge = chat_budge.replace(/-this_company_id-/g,$('#active_user_date').val());
			chat_budge = chat_budge.replace(/-this_company_type-/g,$('#active_account_type').val());
			chat_budge = chat_budge.replace(/-company_id-/g,budge_id);
			
			chat_budge = chat_budge.replace(/-company_type-/g,response_array[1]);
			//alert(response_array[1]);
			
			chat_budge = chat_budge.replace(/_0/g,'_'+budge_id);
			
			chat_budge = chat_budge.replace(/-and-/g,'&&');
			
			chat_budge = chat_budge.replace(/`/g,'~');
			
			//alert($('#active_account_type').val());
			$('#chat_area').append(chat_budge);
			//alert('hey');
				
			if(response_array[3].length > 30){
				var company_title = response_array[3].substring(0,27)+'...';
			}else{
				var company_title = response_array[3];
			}
			
			
			
			$('#chat_title_'+budge_id).html(company_title);
			$('#chat_company_status_'+response_array[2]).html('Online');
			$('#chat_company_status_'+response_array[2]).css('background-color','green');
			
			
			

		}else if(response_array[0] == 'send_chat_message'){
			$('#chat_msg_'+response_array[1]).val('');
			$('#scroll_div_'+response_array[1]).val(1); 
			
		}else if(response_array[0] == 'process_marking'){
			var marked_items = response_array[1];
			var marked_items_array = marked_items.split(',');
			var items_for_marking = $('#mark_as_seen').val();
			var items_for_marking_array = items_for_marking.split(',');
			
			var remaining_items = '';
			for(var i=0;i<items_for_marking_array.length;i++){
				for(var m=0;m<marked_items_array.length;m++){					
					if(items_for_marking_array[i] != marked_items_array[m] && (m == (marked_items_array.length - 1))){
						if(remaining_items == ''){
							remaining_items = items_for_marking_array[i];
							
						}else{
							remaining_items = remaining_items+','+items_for_marking_array[i];
							
						}
					}
					
					$('#message_'+marked_items_array[m]).css('color','black');
				}
			}
			
			$('#mark_as_seen').val(remaining_items);
			
			if(remaining_items == ''){
				mark_process = 0;
				
			}else{
				process_marking();
			}
		}else{
			alert(response_array[0]);
			
		}
	}
}

function online_checker(){ 
	var data = new FormData();
	data.append('online_checker',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('account_id',$('#active_account_id').val());
	data.append('account_type',$('#active_account_type').val());
	data.append('account_date',$('#active_account_date').val());
	data.append('user_date',$('#active_user_date').val());
	
	send_chat_processor(data);
	//z = setTimeout("online_checker()",5000);
}

function online_status_extender(){	
	if($('#active_company_id').val() != undefined){
		var info = new FormData();
		info.append('online_status_extender',1);
		info.append('company_id',$('#active_company_id').val());
		info.append('account_id',$('#active_account_id').val());
		info.append('account_type',$('#active_account_type').val());
		info.append('account_date',$('#active_account_date').val());
		info.append('user_date',$('#active_user_date').val());
		
		send_chat_processor(info);
	}
	//y = setTimeout("online_status_extender()",10000);
}

function show_budge(target_user_date,target_account_type){
	var active_chats = $('#active_chats').val();
	active_chats = active_chats.split(",");
	
	for(var a =0;a<active_chats.length;a++){
		if(active_chats[a] != target_user_date && a == (active_chats.length) -1){
			var data = new FormData();
			data.append('show_budge',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('active_user_type',$('#active_account_type').val());
			data.append('active_user_date',$('#active_user_date').val());
			data.append('target_user_type',target_account_type);
			data.append('target_user_date',target_user_date);
			data.append('user_date',$('#active_user_date').val());

			send_chat_processor(data);
			
			if($('#active_chats').val() == ''){
				$('#active_chats').val(target_user_date);
				
			}else{
				$('#active_chats').val($('#active_chats').val()+','+target_user_date);
			}
			
		}else{
			alert('Selected chat is already active...');
		}
	}
}

function remove_from_active_chats(item_date){
	var active_chats = $('#active_chats').val();
	active_chats = active_chats.split(",");
	
	var new_items = '';
	for(var a =0;a<active_chats.length;a++){
		if(active_chats[a] != item_date){
			if(new_items == ''){
				new_items = active_chats[a];
				
			}else{
				new_items = new_items +','+active_chats[a];
				
			}
		}
	}
	$('#active_chats').val(new_items);
	
	clearTimeout(x);
}

function send_chat_message(account_id,account_type,company_id,company_type){
	var data = new FormData();
	
	data.append('send_chat_message',1);
	data.append('account_id',account_id);
	data.append('account_type',account_type);
	data.append('company_id',company_id);
	data.append('company_type',company_type);
	data.append('message',$('#chat_msg_'+company_id).val());
	
	send_chat_processor(data);
}

function check_member_exists(member_name,company_id){
	var data = new FormData();
	
	data.append('check_member',1);
	data.append('member_name',member_name);
	data.append('company_id',company_id);
	
	check_member.open("POST","scripts/check_member.php",true);
	check_member.send(data);
	
}

function update_account(account_id,user_date,company_id,editing_div_id,listing_div_id,script_file){
	var data = new FormData();
	
	data.append('update_account',1);
	data.append('account_id',account_id);
	data.append('user_date',user_date);
	data.append('company_id',company_id);
	data.append('editing_div_id',editing_div_id);
	data.append('listing_div_id',listing_div_id);
	data.append('script_file',script_file);
	
	data.append('account_name',$('#account_name').val());
	data.append('account_access_level',$('#account_access_level').val());
	data.append('account_email',$('#account_email').val());
	data.append('account_contact_no',$('#account_contact_no').val());
	data.append('account_address',$('#account_address').val());
	data.append('account_vat_reg',$('#account_vat_reg').val());
	data.append('account_tpin',$('#account_tpin').val());
	data.append('account_details',$('#account_details').val());
	data.append('opening_balance',$('#account_opening_balance').val());
	data.append('branch_id',$('#this_account_branch_id').val());
	
	send_general_xmlhttp(data);
}

function authenticate_new_branch(company_id,user_date){

	if($('#new_branch_name').val() == 'Enter branch name here' || $('#new_branch_name').val() == ''){
		$('#new_branch_error_message').html('Please enter the name of the branch');
		$('#new_branch_error_message').show('fast');
		
	}else if($('#new_branch_email').val() == 'Enter email here' || $('#new_branch_email').val() == ''){
		$('#new_branch_error_message').html('Please enter branch email here');
		$('#new_branch_error_message').show('fast');
		
	}else if($('#new_branch_phone').val() == 'Enter contact number' || $('#new_branch_phone').val() == ''){
		$('#new_branch_error_message').html('Please enter contact number here');
		$('#new_branch_error_message').show('fast');
		
	}else{	
		$('#new_branch_create_button').html('Wait...');
		var data = new FormData();
		data.append('create_new_branch',1);
		data.append('company_id',company_id);
		data.append('user_date',user_date);
		data.append('branch_name',$('#new_branch_name').val());
		data.append('branch_email',$('#new_branch_email').val());
		data.append('contact_number',$('#new_branch_contact_number').val());
		data.append('phone',$('#new_branch_phone').val());
		data.append('details',$('#new_branch_details').val());
		
		send_general_xmlhttp(data);
		
	
	}
}


function reload_active_menu(){
	$('#'+$('#active_submenu').val()).click();
	$('#'+$('#active_menu').val()).hide('fast');
}

function update_branch(branch_id,user_date,company_id){
	var data = new FormData();
	data.append('update_branch',1);
	data.append('branch_id',branch_id);
	data.append('company_id',company_id);
	data.append('user_date',user_date);
	data.append('branch_name',$('#account_name').val());
	data.append('email',$('#account_email').val());
	data.append('phone',$('#account_contact_no').val());
	data.append('details',$('#account_details').val());
	
	send_general_xmlhttp(data);
}

function delete_branch(branch_id){
	if($('#delete_branch_button').html() != 'Delete'){
		alert('Wait for current operation to finish');
	
	}else{
		var c = confirm('Are you sure you wish to delete this branch? This will delete all transactions and other items under it');
		
		if(c){			
			var data = new FormData();
			data.append('delete_branch',1);
			data.append('branch_id',branch_id);
			
			send_general_xmlhttp(data);
			
			$('#delete_branch_button').html('Wait...');
		}
	}
}

function new_stock_create(company_id,user_date){
	if($('#new_stock_create_button').html() == 'Create'){
	if($('#new_stock_name').val() == 'Enter item name here' || $('#new_stock_name').val() == ''){
		$('#new_stock_error_message').html('Please enter item name');
		$('#new_stock_error_message').show('fast');
		
		
	}else if($('#new_stock_qty').val() == 'Enter quantity here' || $('#new_stock_qty').val() == ''){
		$('#new_stock_error_message').html('Please enter quantity');
		$('#new_stock_error_message').show('fast');
		
		
	}else if($('#new_stock_unit').val() == 'Enter amount per unit here' || $('#new_stock_unit').val() == ''){
		$('#new_stock_error_message').html('Please enter amount per unit');
		$('#new_stock_error_message').show('fast');
	
	}else if($('#new_stock_markup').val() == 'Enter markup here' || $('#new_stock_markup').val() == ''){
		$('#new_stock_error_message').html('Please markup');
		$('#new_stock_error_message').show('fast');
	
	}else{
		var data = new FormData();
		data.append('new_stock_item',1);
		data.append('company_id',company_id);
		data.append('user_date',user_date);
		data.append('item_name',$('#new_stock_name').val());
		data.append('branch_date',$('#stock_branch').val());
		data.append('qty',$('#new_stock_qty').val());
		data.append('qty_unit',$('#new_stock_unit').val());
		data.append('unit_amount',$('#new_stock_unit_amount').val());
		data.append('markup_type',$('#stock_markup_type').val());
		data.append('markup',$('#new_stock_markup').val());
		data.append('details',$('#new_stock_details').val());
		
		send_general_xmlhttp(data);
		
		$('#new_stock_create_button').html('Wait...');
	}
	
	}else{
		alert('Wait for current operation to finish');
	}
}


function update_stock(stock_id,user_date,company_id){
	var data = new FormData();
	data.append('update_stock',1);
	data.append('stock_id',stock_id);
	data.append('user_date',user_date);
	data.append('company_id',company_id);
	data.append('title',$('#edit_stock_name').val());
	data.append('branch_date',$('#edit_stock_branch').val());
	data.append('qty',$('#edit_stock_qty').val());
	data.append('qty_unit',$('#edit_stock_unit').val());
	data.append('unit_amount',$('#edit_stock_unit_amount').val());
	data.append('markup_type',$('#edit_markup_type').val());
	data.append('markup',$('#edit_stock_markup').val());
	data.append('details',$('#edit_stock_details').val());
	
	send_general_xmlhttp(data);
}

function delete_stock(item_id){
	var c = confirm('Are you sure you with to delete this item? This will delete other items using it');
	
	if(c){
		var data = new FormData();
		data.append('delete_stock',1);
		data.append('item_id',item_id);
		data.append('company_id',$('#active_company_id').val());
		
		send_general_xmlhttp(data);
	
		$('#delete_stock_button').html('Wait...');		
	}
}

function recalculate_this_material(){
	var this_material_amount = $('#this_material_qty').val() * $('#this_material_unit').val();
	$('#this_material_amount').html('K'+this_material_amount);
	
	var markup = (parseFloat($('#this_material_unit').val()) - $('#material_default_unit').val() + parseFloat($('#material_default_markup').val())) * $('#this_material_qty').val();
	$('#this_material_markup').html('K'+markup);
	
}

function add_material_to_list(item_id){
	if(parseFloat($('#this_material_qty').val()) > parseFloat($('#this_material_original_qty').val())){
		alert('You have specified more quantities than what is in stock for this item');
	
	}else{		
		var this_material_amount = $('#this_material_qty').val() * $('#this_material_unit').val();
		$('#this_material_amount').html(this_material_amount);
		
		var markup = (parseFloat($('#this_material_unit').val()) - $('#material_default_unit').val() + parseFloat($('#material_default_markup').val())) * $('#this_material_qty').val();
		
		var material_item = '<div style="height:20px;line-height:20px;text-align:center;float:left;width:100%;border-bottom:solid 1px #eee;" ondblclick="var c=confirm(\'Are you sure you wish to remove this item\');if(c){remove_material_item('+general_variable+','+item_id+','+$('#this_material_qty').val()+');}" title="Double click to remove" id="material_'+general_variable+'"><div style="width:10%;height:20px;line-height:20px;text-align:left;float:left;" >'+$('#this_material_qty').val()+'</div><div style="width:50%;height:20px;line-height:20px;text-align:left;float:left;">'+$('#this_material_name').val()+'</div><div style="width:20%;height:20px;line-height:20px;text-align:right;float:left;">'+$('#this_material_unit').val()+'</div><div style="width:20%;height:20px;line-height:20px;text-align:right;float:left;">'+this_material_amount+'</div><input type="hidden" id="item_'+general_variable+'_markup" value="'+markup+'"> <input type="hidden" id="item_'+general_variable+'_amount" value="'+this_material_amount+'"></div>';
		
		$('#picked_materials').append(material_item);
		
		var material_markup = $('#this_material_markup').html();
		material_markup = material_markup.replace('K','');
		if($('#job_card_listing').val() == ''){
			$('#job_card_listing').val($('#this_material_qty').val()+'~|'+$('#this_material_name').val()+'~|'+$('#this_material_unit').val()+'~|'+material_markup+'~|'+this_material_amount+'~|'+item_id);
			
		}else{
			$('#job_card_listing').val($('#job_card_listing').val()+'~}'+$('#this_material_qty').val()+'~|'+$('#this_material_name').val()+'~|'+$('#this_material_unit').val()+'~|'+material_markup+'~|'+this_material_amount+'~|'+item_id);
		}
		
			//alert($('#this_material_amount').html());
		
		$('#job_card_markup').val(markup + parseFloat($('#job_total_markup').html()));
		$('#job_card_amount').val(this_material_amount + parseFloat($('#job_total_charge').html()));
		
		$('#job_total_charge').html(parseFloat($('#job_total_charge').html())+this_material_amount);
		
		$('#job_total_markup').html(parseFloat($('#job_total_markup').html())+markup);
		
		general_variable++;
		
		if($('#job_item_qty_'+item_id).val() == undefined){
			var item_job_qty = '<input type="hidden" id="job_item_qty_'+item_id+'" value="'+$('#this_material_qty').val()+'"><input type="hidden" id="item_'+item_id+'_instances" value="1">';		
			$('#picked_materials').append(item_job_qty);
			
			if($('#picked_material_ids').val() == ''){
				$('#picked_material_ids').val(item_id);
				
			}else{
				$('#picked_material_ids').val($('#picked_material_ids').val()+','+item_id);
			}
		}else{
			$('#job_item_qty_'+item_id).val(parseFloat($('#job_item_qty_'+item_id).val()) + parseFloat($('#this_material_qty').val()));
			$('#item_'+item_id+'_instances').val(parseFloat($('#item_'+item_id+'_instances').val())+1);
			
		}
		check_item_qty(item_id,0);
	}
}

function check_item_qty(item_id,type){
	if($('#job_item_qty_'+item_id).val() != undefined){
		if(type == 0){
			var remaining_qty = parseFloat($('#qty_unit').html()) - parseFloat($('#this_material_qty').val());
		
		}else{
			var remaining_qty = parseFloat($('#qty_unit').html()) - parseFloat($('#job_item_qty_'+item_id).val());
		}
		
		$('#qty_unit').html(remaining_qty);
		$('#this_material_original_qty').val(remaining_qty);
	}
}

function add_material_service_to_list(){
	if($('#material_service').val() == 'Enter service here' || $('#material_service').val() == ''){
		alert('Please enter name of service or remove service amount to exclude it');
		$('#material_service').css('border-color','red');
		
	}else if($('#material_service_charge').val() == 'Charge here here'){
		alert('Please enter service charge or remove service name to exclude it');
		$('#material_service_charge').css('border-color','red');
		
	}else{
		var service_item = '<div style="height:20px;line-height:20px;text-align:center;float:left;width:100%;border-bottom:solid 1px #eee;" ondblclick="var c=confirm(\'Are you sure you wish to remove this item\');if(c){remove_material_service_item('+general_variable+');}" title="Double click to remove" id="material_service_'+general_variable+'"><div style="width:10%;height:20px;line-height:20px;text-align:left;float:left;"></div><div style="width:50%;height:20px;line-height:20px;text-align:left;float:left;">'+$('#material_service').val()+'</div><div style="width:20%;height:20px;line-height:20px;text-align:right;float:left;">'+$('#material_service_charge').val()+'</div><div style="width:20%;height:20px;line-height:20px;text-align:right;float:left;">'+$('#material_service_charge').val()+'</div><input type="hidden" id="item_'+general_variable+'_markup" value="'+$('#material_service_charge').val()+'" ><input type="hidden" id="item_'+general_variable+'_amount" value="'+$('#material_service_charge').val()+'"></div>';
		
		$('#picked_materials').append(service_item);
		
		var job_total_charge = parseFloat($('#job_total_charge').html())+ parseFloat($('#material_service_charge').val());
		
		$('#job_total_charge').html(job_total_charge);
		
		var current_markup = parseFloat($('#job_total_markup').html());
		
		var this_total_makup = parseFloat($('#material_service_charge').val()) + current_markup;
		
		$('#job_total_markup').html(this_total_makup);		
		
		if($('#job_card_listing').val() == ''){
			$('#job_card_listing').val('1'+'~|'+$('#material_service').val()+'~|'+$('#material_service_charge').val()+'~|'+$('#material_service_charge').val()+'~|'+$('#material_service_charge').val()+'~|0~|'+general_variable);
		
		}else{
			$('#job_card_listing').val($('#job_card_listing').val()+'~}1'+'~|'+$('#material_service').val()+'~|'+$('#material_service_charge').val()+'~|'+$('#material_service_charge').val()+'~|'+$('#material_service_charge').val()+'~|0~|'+general_variable);
		}
		
		$('#job_card_markup').val(this_total_makup);
		$('#job_card_amount').val(job_total_charge);
				
		general_variable++;
	}
}


function remove_material_item(material_id,item_id,item_qty){
	$('#material_'+material_id).hide('fast');
	
	
	$('#job_total_charge').html(parseFloat($('#job_total_charge').html())-parseFloat($('#item_'+material_id+'_amount').val()));
			
	$('#job_total_markup').html(parseFloat($('#job_total_markup').html())-parseFloat($('#item_'+material_id+'_markup').val()));
	$('#material_'+material_id).remove();
	
	var picked_material_ids = $('#picked_material_ids').val();
	var picked_material_ids_array = picked_material_ids.split(',');
	
	var new_picked_material_ids = '';
	for(var pm=0;pm<picked_material_ids_array.length;pm++){
		
		if(picked_material_ids_array[pm] != item_id || ($('#item_'+item_id+'_instances').val() != 1)){
			if(new_picked_material_ids == ''){
				new_picked_material_ids = picked_material_ids_array[pm];
				
			}else{
				new_picked_material_ids = new_picked_material_ids+','+picked_material_ids_array[pm];
			}
			
			if(picked_material_ids_array[pm] == item_id && ($('#item_'+item_id+'_instances').val() != 1)){
				$('#item_'+item_id+'_instances').val(parseFloat($('#item_'+item_id+'_instances').val())-1);
				//alert('hey');
			}
		}
	}
	
	$('#picked_material_ids').val(new_picked_material_ids);
	
	var job_card_listing = $('#job_card_listing').val();
job_card_listing_array = job_card_listing.split('~}');
	
	var new_job_card_listing = '';
	for(jl=0;jl<job_card_listing_array.length;jl++){
		var job_card_listing_item_fields = job_card_listing_array[jl];
		
		var job_card_listing_item_fields_array = job_card_listing_item_fields.split('~|');
		
		if(item_id != job_card_listing_item_fields_array[5]){
			if(new_job_card_listing == ''){
				new_job_card_listing = job_card_listing_array[jl];
				
			}else{
				new_job_card_listing = new_job_card_listing+'~}'+job_card_listing_array[jl];
			}
		}
	}
	$('#job_card_listing').val(new_job_card_listing);
	
	var remaining_qty = parseFloat($('#qty_unit').html()) + item_qty;
	
	if(item_id == parseFloat($('#this_material_id').val())){
		$('#qty_unit').html(remaining_qty);
		$('#this_material_original_qty').val(remaining_qty);
	}
	
	$('#job_item_qty_'+item_id).val(parseFloat($('#job_item_qty_'+item_id).val()) - item_qty);	
}

function remove_material_service_item(material_id){
	$('#material_service_'+material_id).hide('fast');
	
	$('#job_total_charge').html(parseFloat($('#job_total_charge').html())-parseFloat($('#item_'+material_id+'_amount').val()));
			
	$('#job_total_markup').html(parseFloat($('#job_total_markup').html())-parseFloat($('#item_'+material_id+'_markup').val()));
	
	$('#material_service_'+material_id).remove();	
	
	var job_card_listing = $('#job_card_listing').val();
job_card_listing_array = job_card_listing.split('~}');
	
	var new_job_card_listing = '';
	for(jl=0;jl<job_card_listing_array.length;jl++){
		var job_card_listing_item_fields = job_card_listing_array[jl];
		
		var job_card_listing_item_fields_array = job_card_listing_item_fields.split('~|');
		
		if(material_id != job_card_listing_item_fields_array[6]){
			if(new_job_card_listing == ''){
				new_job_card_listing = job_card_listing_array[jl];
				
			}else{
				new_job_card_listing = new_job_card_listing+'~}'+job_card_listing_array[jl];
			}
		}
	}
	$('#job_card_listing').val(new_job_card_listing);
}

function aunthenticate_new_job(){
	if($('#job_create_button').html() != 'Wait...'){
		if($('#job_title').val() == 'Enter job title here'){
			alert('Please enter the title of this job');
			$('#job_title').css('border-color','red');
			
		}else if($('#job_client').val() == 0){
			alert('Choose a client for this job');
			$('#job_client').css('border-color','red');
			
		}else if($('#job_sales_account').val() == 0){
			alert('Please select sales account for this job');
		
			
			
		}else if($('#job_card_amount').val() == ''){
			alert('You need to add some materials or services to your job');
		
		}else{
			var data = new FormData();
			data.append('create_job',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			data.append('start_day',$('#job_start_day').val());
			data.append('start_month',$('#job_start_month').val());
			data.append('start_year',$('#job_start_year').val());
			data.append('branch_date',$('#branch_date').val());
			
			data.append('end_day',$('#job_end_day').val());
			data.append('end_month',$('#job_end_month').val());
			data.append('end_year',$('#job_end_year').val());
			data.append('job_title',$('#job_title').val());
			data.append('job_client',$('#job_client').val());
			data.append('job_sales_account',$('#job_sales_account').val());
			data.append('client_name',$('#active_client').html());
			data.append('job_agent',$('#job_agent').val());
			data.append('job_card_listing',$('#job_card_listing').val());
			data.append('job_card_amount',$('#job_card_amount').val());
			data.append('job_card_markup',$('#job_card_markup').val());
			
			data.append('client_notify',$('#job_client_notify').val());
			data.append('show_material_charges',$('#show_material_charge').val());
			
			data.append('picked_material_ids',$('#picked_material_ids').val());
			
			data.append('process_payment_action',$('#process_payment_action').val());
			
			var picked_material_ids = $('#picked_material_ids').val();
			
			var picked_material_ids_array = picked_material_ids.split(",");
			
			for(var i=0;i<picked_material_ids_array.length;i++){
				data.append('material_item_'+picked_material_ids_array[i]+'_qty',$('#job_item_qty_'+picked_material_ids_array[i]).val());
			}
			
			send_general_xmlhttp(data);
			$('#job_create_button').html('Wait...');
		}
	}else{
		alert('Wait for current operation to finish');
	}
}

function fetch_material(material_id){
	var data = new FormData();
	data.append('fetch_material',1);
	data.append('material_id',material_id);
	
	send_general_xmlhttp(data);
	
	$('#material_selection').html('<div style="width:100%;height:20px;float:left;lie-height:20px;text-align:center;">Fetching material details...</div>');

}

function authenticate_new_account(account_type,user_date,script_menu_id){
	//alert(script_menu_id);
	var data = new FormData();
	data.append('create_new_account',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',user_date);
	data.append('account_type',account_type);
	data.append('new_account_name',$('#new_account_name').val());
	data.append('new_account_access_level',$('#new_account_access_level').val());
	data.append('new_account_email',$('#new_account_email').val());
	data.append('new_account_contact_number',$('#new_account_contact_number').val());
	data.append('new_account_address',$('#new_account_address').val());
	data.append('new_account_vat',$('#new_account_vat').val());
	data.append('new_account_tpin',$('#new_account_tpin').val());
	data.append('new_account_details',$('#new_account_details').val());
	data.append('branch_id',$('#account_branch_id').val());
	data.append('script_menu_id',script_menu_id);
	
	send_general_xmlhttp(data);

}

function fetch_item_details(area_id,item_id,window_title){
	var data = new FormData();
	data.append('fetch_item_details',1);
	data.append('area_id',area_id);
	data.append('item_id',item_id);
	
	show_window('item_details');
	$('#detailed_info').html(progress_text);
	$('#window_title_bar').html(window_title);
	send_general_xmlhttp(data);
}

function process_order_action(order_date){
	var c=confirm('Are you sure you wish to perform this operation?');
	
	if(c){
		var data = new FormData();
		data.append('process_order_action',1);
		data.append('order_date',order_date);
		data.append('action',$('#order_action').val());
		
		if($('#order_comment').val() == 'Add comment for your actions here'){
			data.append('comment','No comment was added');
			
		}else{
			data.append('comment',$('#order_comment').val());
		
		}
		
		data.append('restore_materials',$('#restore_materials').val());
		data.append('cancel_invoices_receipts',$('#cancel_invoices_receipts').val());
		
		var material_ids = $('#material_ids').val();
		var material_ids_array = material_ids.split(",");
		
		for(var m=0;m<material_ids_array.length;m++){
			data.append('item_'+material_ids_array[m]+'_qty',$('#item_'+material_ids_array[m]+'_qty').val());
			
		}
		
		data.append('material_ids',material_ids);
		
		send_general_xmlhttp(data);
	}
}


function authenticate_new_cash_receipt(sub_area_id){
	if($('#payer_name').val() == 'Enter name of payer here'){		
		$('#new_cash_receipt_error').html('Please enter name of payer');
		$('#payer_name').css('border-color','red');
		
	}else if($('#new_receipt_cash_creditor_id').val() == 0){
		$('#new_cash_receipt_error').html('Please select account to debit');
		
	}else if($('#new_cash_receipt_sales_id').val() == 0){
		$('#new_cash_receipt_error').html('Please select a sales account');
		
	}else if($('#receipt_cash_amount_received').val() == 'Enter amount here'){
		$('#new_cash_receipt_error').html('Please enter amount being received');
		$('#receipt_cash_amount_received').css('border-color','red');
		
	}else{
		var data = new FormData();
		data.append('new_cash_receipt',1);
		data.append('sub_area_id',sub_area_id);
		data.append('receipt_day',$('#new_cash_receipt_day').val());
		data.append('receipt_month',$('#new_cash_receipt_month').val());
		data.append('receipt_year',$('#new_cash_receipt_year').val());
		data.append('receipt_month',$('#new_cash_receipt_month').val());
		data.append('company_id',$('#active_company_id').val());
		data.append('new_receipt_creditor_date',$('#new_receipt_cash_creditor_id').val());
		data.append('new_receipt_sales_date',$('#new_cash_receipt_sales_id').val());
		data.append('receipt_amount_received',$('#receipt_cash_amount_received').val());
		data.append('payment_mode',$('#cash_payment_mode').val());
		data.append('narration',$('#cash_receipt_narration').val());
		data.append('send_receipt',$('#send_cash_receipt').val());
		data.append('user_date',$('#active_user_date').val());
		data.append('receipt_payer',$('#payer_name').val());
		
		send_general_xmlhttp(data);
	}
}


function authenticate_new_cash_payment(sub_area_id){
	if($('#payee_name').val() == 'Enter name of payee here'){		
		$('#new_cash_payment_error').html('Please enter name of payee');
		$('#payee_name').css('border-color','red');
		
	}else if($('#new_payment_cash_creditor_id').val() == 0){
		$('#new_cash_payment_error').html('Please select account to credit');
		
	}else if($('#new_cash_purchase_id').val() == 0){
		$('#new_cash_payment_error').html('Please select a purchase account');
		
	}else if($('#payment_cash_amount_paid').val() == 'Enter amount here'){
		$('#new_cash_payment_error').html('Please enter amount being paid');
		$('#payment_cash_amount_paid').css('border-color','red');
		
	}else{
		var data = new FormData();
		data.append('new_cash_payment',1);
		data.append('sub_area_id',sub_area_id);
		data.append('payment_day',$('#new_cash_payment_day').val());
		data.append('payment_month',$('#new_cash_payment_month').val());
		data.append('payment_year',$('#new_cash_payment_year').val());
		data.append('company_id',$('#active_company_id').val());
		data.append('new_payment_creditor_date',$('#new_payment_cash_creditor_id').val());
		data.append('new_payment_purchase_date',$('#new_cash_purchase_id').val());
		data.append('payment_expense_account',$('#new_cash_expense_account_id').val());
		data.append('payment_amount_paid',$('#payment_cash_amount_paid').val());
		data.append('payment_mode',$('#cash_payment_payment_mode').val());
		data.append('narration',$('#cash_payment_narration').val());
		data.append('send_payment',$('#send_cash_payment_receipt').val());
		data.append('user_date',$('#active_user_date').val());
		data.append('payment_payee',$('#payee_name').val());
		
		send_general_xmlhttp(data);
	}
}

function recalculate_sales_invoice_value(){
	var sub_total = 0;
	var invoice_total = 0;
	var invoice_qtys = '';
	var invoice_description = '';
	var invoice_amounts = '';
	for(var i=0;i<(invoice_variable+1);i++){
		this_total = (Number($('#unit_'+i).val()) * Number($('#qty_'+i).val()));
		
		$('#total_'+i).val(this_total);
		sub_total = sub_total + this_total;
		invoice_total = sub_total;
		
		 
		if(invoice_qtys == ''){
			invoice_qtys = $('#qty_'+i).val();
			invoice_description = $('#description_'+i).val();
			invoice_amounts = $('#unit_'+i).val();
			
		}else{
			invoice_qtys = invoice_qtys+'}'+$('#qty_'+i).val();
			invoice_description = invoice_description+'}'+$('#description_'+i).val();
			invoice_amounts = invoice_amounts+'}'+$('#unit_'+i).val();
			
		}
	}
	$('#sales_invoice_qtys').val(invoice_qtys);
	$('#sales_invoice_descriptions').val(invoice_description);
	$('#sales_invoice_amounts').val(invoice_amounts);
	$('#sales_sub_total').val(sub_total);
	$('#sales_invoice_total').val(invoice_total);
	
	$('#sales_invoice_markup').val(invoice_total);
}

function add_sales_invoice_fields(){
	if($('#description_'+invoice_variable).val() == 'Type service description here' || $('#unit_'+invoice_variable).val() == 0){
		alert('Please complete filling in the current item first');
		
	}else{
		invoice_variable++
		var data = '<div style="width:100%;min-height:25px;height:auto;float:left;border-bottom:solid 1px #eee;" id="entry_'+invoice_variable+'"><div style="margin-left:5px;width:50px;height:25px;float:left;text-align:left;line-height:25px;"><input onfocusout="if(this.value==\'\' || this.value == 0){this.value=1}recalculate_sales_invoice_value();" name="qty_'+invoice_variable+'" id="qty_'+invoice_variable+'" value="1" type="text" style="border:none;width:100%;"></div><div style="margin-left:5px;width:305px;min-height:20px;height:auto;float:left;text-align:left;line-height:25px;"><textarea onfocus="if(this.value==\'Type service description here\'){this.value=\'\';this.style.color=\'#000\';}" onfocusout="if(this.value==\'\'){this.value=\'Type service description here\';this.style.color=\'#aaa\';}" name="description_'+invoice_variable+'" id="description_'+invoice_variable+'" type="text" style="border:none;width:100%;max-width:100%;color:#aaa;height:17px;font-family:verdana, arial;">Type service description here</textarea></div><div style="margin-left:7px;width:100px;height:25px;float:left;text-align:right;line-height:25px;"><input onfocus="if(this.value==0){this.value=\'\';}" onfocusout="if(this.value==\'\'){this.value=0;}recalculate_sales_invoice_value();" name="unit_'+invoice_variable+'" id="unit_'+invoice_variable+'" value="0" type="text" style="width:100%;color:#000;border:none;text-align:right;" ></div><div style="margin-left:7px;width:100px;height:25px;float:left;text-align:right;line-height:25px;"><input disabled name="total_'+invoice_variable+'" id="total_'+invoice_variable+'" value="0" type="text" style="width:100%;color:#000;border:none;text-align:right;background-color:#fff;"></div></div>';
		
		$('#sales_invoice_entry_rows').append(data);
	}
}

function authenticate_sales_invoice(sub_area_id){
	var data = new FormData();
	data.append('sales_invoice',1);
	data.append('sub_area_id',sub_area_id);
	data.append('sales_invoice_day',$('#sales_invoice_day').val());
	data.append('sales_invoice_month',$('#sales_invoice_month').val());
	data.append('sales_invoice_year',$('#sales_invoice_year').val());
	
	data.append('sales_invoice_due_day',$('#sales_invoice_due_day').val());
	data.append('sales_invoice_due_month',$('#sales_invoice_due_month').val());
	data.append('sales_invoice_due_year',$('#sales_invoice_due_year').val());
	
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('debtor_date',$('#sales_invoice_debtor_id').val());
	data.append('sales_account_date',$('#sales_invoice_sales_account_id').val());
	data.append('invoice_qty',$('#sales_invoice_qtys').val());
	data.append('invoice_description',$('#sales_invoice_descriptions').val());
	data.append('entry_amounts',$('#sales_invoice_amounts').val());
	data.append('invoice_amount',$('#sales_invoice_total').val());
	data.append('invoice_markup',$('#sales_invoice_markup').val());
	data.append('terms',$('#sales_invoice_terms').val());
	
	send_general_xmlhttp(data);
}

function recalculate_purchase_invoice_value(){
	
	var sub_total = 0;
	var invoice_total = 0;
	var invoice_qtys = '';
	var invoice_description = '';
	var invoice_amounts = '';
	for(var i=0;i<(invoice_variable+1);i++){
		this_total = (Number($('#purchase_unit_'+i).val()) * Number($('#purchase_qty_'+i).val()));
		
		$('#purchase_total_'+i).val(this_total);
		sub_total = sub_total + this_total;
		invoice_total = sub_total;
		
		 
		if(invoice_qtys == ''){
			invoice_qtys = $('#purchase_qty_'+i).val();
			invoice_description = $('#purchase_description_'+i).val();
			invoice_amounts = $('#purchase_unit_'+i).val();
			
		}else{
			invoice_qtys = invoice_qtys+'}'+$('#purchase_qty_'+i).val();
			invoice_description = invoice_description+'}'+$('#purchase_description_'+i).val();
			invoice_amounts = invoice_amounts+'}'+$('#purchase_unit_'+i).val();
			
		}
	}
	$('#purchase_invoice_qtys').val(invoice_qtys);
	$('#purchase_invoice_descriptions').val(invoice_description);
	$('#purchase_invoice_amounts').val(invoice_amounts);
	$('#purchase_sub_total').val(sub_total);
	$('#purchase_invoice_total').val(invoice_total);
}

function add_purchase_invoice_fields(){
	if($('#purchase_description_'+invoice_variable).val() == 'Type service description here' || $('#purchase_unit_'+invoice_variable).val() == 0){
		alert('Please complete filling in the current item first');
		
	}else{
		invoice_variable++
		var data = '<div style="width:100%;min-height:25px;height:auto;float:left;border-bottom:solid 1px #eee;" id="purchase_entry_'+invoice_variable+'"><div style="margin-left:5px;width:50px;height:25px;float:left;text-align:left;line-height:25px;"><input onfocusout="if(this.value==\'\' || this.value == 0){this.value=1}recalculate_purchase_invoice_value();" name="purchase_qty_'+invoice_variable+'" id="purchase_qty_'+invoice_variable+'" value="1" type="text" style="border:none;width:100%;"></div><div style="margin-left:5px;width:305px;min-height:20px;height:auto;float:left;text-align:left;line-height:25px;"><textarea onfocus="if(this.value==\'Type service description here\'){this.value=\'\';this.style.color=\'#000\';}" onfocusout="if(this.value==\'\'){this.value=\'Type service description here\';this.style.color=\'#aaa\';}" name="purchase_description_'+invoice_variable+'" id="purchase_description_'+invoice_variable+'" type="text" style="border:none;width:100%;max-width:100%;color:#aaa;height:17px;font-family:verdana, arial;">Type service description here</textarea></div><div style="margin-left:7px;width:100px;height:25px;float:left;text-align:right;line-height:25px;"><input onfocus="if(this.value==0){this.value=\'\';}" onfocusout="if(this.value==\'\'){this.value=0;}recalculate_purchase_invoice_value();" name="purchase_unit_'+invoice_variable+'" id="purchase_unit_'+invoice_variable+'" value="0" type="text" style="width:100%;color:#000;border:none;text-align:right;" ></div><div style="margin-left:7px;width:100px;height:25px;float:left;text-align:right;line-height:25px;"><input disabled name="purchase_total_'+invoice_variable+'" id="purchase_total_'+invoice_variable+'" value="0" type="text" style="width:100%;color:#000;border:none;text-align:right;background-color:#fff;"></div></div>';
		
		$('#purchase_invoice_entry_rows').append(data);
	}
}


function authenticate_purchase_invoice(sub_area_id){
	if($('#purchase_invoice_number').val() == 'Number here'){
		$('#new_purchase_invoice_error').html('Please enter invoice number');
		
		$('#purchase_invoice_number').css('border-color','red');
		
	}else if($('#purchase_invoice_creditor_id').val() == 0){
		$('#new_purchase_invoice_error').html('Please select creditor');
		
	}else if($('#purchase_invoice_purchase_account_id').val() == 0){
		$('#new_purchase_invoice_error').html('Please select purchase account');
		
	}else if($('#purchase_invoice_total').val() == 0){
		$('#new_purchase_invoice_error').html('Please add at-least one item on invoice');
		
	}else{
		var data = new FormData();
		data.append('purchase_invoice',1);
		data.append('sub_area_id',sub_area_id);
		data.append('purchase_invoice_day',$('#purchase_invoice_day').val());
		data.append('purchase_invoice_month',$('#purchase_invoice_month').val());
		data.append('purchase_invoice_year',$('#purchase_invoice_year').val());
		
		data.append('purchase_invoice_due_day',$('#purchase_invoice_due_day').val());
		data.append('purchase_invoice_due_month',$('#purchase_invoice_due_month').val());
		data.append('purchase_invoice_due_year',$('#purchase_invoice_due_year').val());
		
		data.append('invoice_no',$('#purchase_invoice_number').val());
		
		data.append('company_id',$('#active_company_id').val());
		data.append('user_date',$('#active_user_date').val());
		data.append('creditor_date',$('#purchase_invoice_creditor_id').val());
		data.append('purchase_account_date',$('#purchase_invoice_purchase_account_id').val());
		data.append('expense_account_date',$('#purchase_invoice_expense_account_id').val());
		data.append('invoice_qty',$('#purchase_invoice_qtys').val());
		data.append('invoice_description',$('#purchase_invoice_descriptions').val());
		data.append('entry_amounts',$('#purchase_invoice_amounts').val());
		data.append('invoice_amount',$('#purchase_invoice_total').val());
		data.append('terms',$('#purchase_invoice_terms').val());
		
		send_general_xmlhttp(data);
	}
}

function authenticate_new_contra(sub_area_id){
	if(document.newContra.contraTitle.value=='Enter contra title'){
		alert('You need to input the title of your contra');
	
	}else if(document.newContra.accountFrom.value==0){
		alert('Choose an account to transfer from');
	
	}else if(document.newContra.accountTo.value==0){
		alert('Choose account to transfer to');
	
	}else if(document.newContra.accountFrom.value == document.newContra.accountTo.value){
		alert('You have selected the same account on both the "from account" and "to account" field selections. Account selections must be different');
	
	}else if(document.newContra.contraAmount.value=='Enter amount to transfer'){
		alert('Input amount to transfer');
	
	}else if(document.newContra.contraDetails.value=='Put narration here'){
		alert('Input a brief naration for this contra transfer');
	
	}else{
		var data = new FormData();
		data.append('new_contra',1);
		data.append('sub_area_id',sub_area_id);
		data.append('title',document.newContra.contraTitle.value);
		data.append('contra_day',$('#contra_day').val());
		data.append('contra_month',$('#contra_month').val());
		data.append('contra_year',$('#contra_year').val());
		data.append('from_date',document.newContra.accountFrom.value);
		data.append('to_date',document.newContra.accountTo.value);
		data.append('amount',document.newContra.contraAmount.value);
		data.append('details',document.newContra.contraDetails.value);
		data.append('user_date',$('#active_user_date').val());
		data.append('company_id',$('#active_company_id').val());
		
		send_general_xmlhttp(data);
	}

}

function new_employee_create(){
	if($('#new_employee_name').val() == 'Enter full names here'){
		$('#new_employee_error_message').html('Please enter employee\'s full names');
		$('#new_employee_name').css('border-color','red');
		
	}else if($('#new_employee_basic_pay').val() == 'Enter basic pay here'){
		$('#new_employee_error_message').html('Please enter basic pay');
		$('#new_employee_basic_pay').css('border-color','red');
		
	}else if($('#new_employee_contact').val() == 'Enter basic pay here'){
		$('#new_employee_error_message').html('Enter contact here');
		$('#new_employee_contact').css('border-color','red');
		
	}else if($('#new_employee_position').val() == 'Enter basic pay here'){
		$('#new_employee_error_message').html('Enter employee\'s position');
		$('#new_employee_position').css('border-color','red');		
		
	}else{
		var data = new FormData();
		data.append('new_employee',1);
		data.append('start_day',$('#start_day').val());
		data.append('start_month',$('#start_month').val());
		data.append('start_year',$('#start_year').val());
		data.append('full_names',$('#new_employee_name').val());
		data.append('branch_date',$('#employee_branch').val());
		data.append('basic_pay',$('#new_employee_basic_pay').val());
		data.append('contact',$('#new_employee_contact').val());
		data.append('position',$('#new_employee_position').val());
		data.append('company_id',$('#active_company_id').val());
		data.append('user_date',$('#active_user_date').val());
		
		send_general_xmlhttp(data);		
	}
}

function create_new_employee_department(){
	var data = new FormData();
	data.append('create_new_employee_department',1);
	data.append('title',$('#employee_department_name').val());
	data.append('description',$('#employee_department_description').val());
	data.append('company_id',$('#active_company_id').val());
	
	send_general_xmlhttp(data);
}


function deactivate_employee_departments(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_type_action = -1;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('deactivate_departments',true);
		data.append('selections',$('#selected_items').val());
		
		send_general_xmlhttp(data);
	}
}

function activate_employee_departments(){
	if($('#selected_items').val() == ''){
		$('#type_active_action').html('Select action');
		$('#general_error_msg').fadeIn('fast');
		$('#general_error_msg_txt').html('Oops!! You need to select at least one item');
		
	}else{
		new_member_type_action = -5;
		var selections = $('#selected_items').val();
		
		data = new FormData();
		data.append('activate_departments',true);
		data.append('selections',$('#selected_items').val());
		
		send_general_xmlhttp(data);
	}
}

function fetch_inactive_employee_departments(company_id){
	new_member_type_action = -2;
	
	$('#employee_department_activate_action').show();
	$('#employee_department_deactivate_action').hide();
	
	data = new FormData();
	data.append('inactive_employee_departments',true);
	data.append('company_id',company_id);
	
	send_general_xmlhttp(data);
	
	var waiting_div = '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:30px;text-align:center;font-size:1.2em;">Fetching data. Please wait...</div>';
	
	$('#employee_departments_listing').html(waiting_div);
}

function fetch_active_employee_departments(company_id){
	new_member_type_action = -3;
	
	$('#employee_department_activate_action').hide();
	$('#employee_department_deactivate_action').show();
	
	data = new FormData();
	data.append('active_employee_departments',true);
	data.append('company_id',company_id);
	
	send_general_xmlhttp(data);
	
	var waiting_div = '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:30px;text-align:center;font-size:1.2em;">Fetching data. Please wait...</div>';
	
	$('#employee_departments_listing').html(waiting_div);
}

function fetch_all_employee_departments(company_id){
	new_member_type_action = -4;
	
	$('#employee_departments_activate_action').show();
	$('#employee_departments_deactivate_action').show();
	
	data = new FormData();
	data.append('all_employee_departments',true);
	data.append('company_id',company_id);
	
	send_general_xmlhttp(data);
	
	var waiting_div = '<div style="float:left;width:100%;height:30px;line-height:30px;margin-top:30px;text-align:center;font-size:1.2em;">Fetching data. Please wait...</div>';
	
	$('#employee_departments_listing').html(waiting_div);
}

function update_employee_department(employee_department_id){
	new_member_type_action = employee_department_id;
	$('#update_button_'+employee_department_id).html('Saving');
	var data = new FormData();
	data.append('update_employee_departments',employee_department_id);
	data.append('title',$('#employee_department_title_'+employee_department_id).val());
	data.append('description',$('#employee_department_description_'+employee_department_id).val());
	
	send_general_xmlhttp(data);
}

function create_employee_deduction(){
	var data = new FormData();
	data.append('create_employee_deduction',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('title',$('#employee_deduction_title').val());
	data.append('type',$('#employee_deduction_type').val());
	data.append('code',$('#employee_deduction_code').val());
	
	send_general_xmlhttp(data);	
}

function playSound(filename){
	document.getElementById("sound").innerHTML='<audio autoplay="autoplay"><source src="' + filename + '.mp3" type="audio/mpeg" /><source src="' + filename + '.mp3" type="audio/ogg" /><embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3" /></audio>';
 }
 
function check_chat_scroll(message_date){
	clearTimeout(rep_timer);
	rep_timer = setTimeout("add_to_mark_list("+message_date+")",100);
}

function add_to_mark_list(message_date){
	if($('#mark_as_seen').val() == ''){
		$('#mark_as_seen').val(message_date);
		
	}else{
		var message_dates = $('#mark_as_seen').val();
		var message_dates_array = message_dates.split(',');
		for(var m=0;m<message_dates_array.length;m++){
			
			if(message_dates_array[m] == message_date){
				break;
				
			}else if(message_dates_array[m] != message_date && m == (message_dates_array.length - 1)){
				$('#mark_as_seen').val($('#mark_as_seen').val()+','+message_date);
			}
		}
	}
	
	if(mark_process == 0){
		process_marking();
	}
}

function process_marking(){
	var data = new FormData();
	data.append('process_marking',1);
	data.append('company_id', $('#active_company_id').val());
	data.append('message_dates',$('#mark_as_seen').val());
	
	send_chat_processor(data);
}

function fetch_devices(){
	var data = new FormData();
	data.append('fetch_devices',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('account_type',$('#active_account_type').val());
	
	send_general_xmlhttp(data);
	
}

function authenticate_new_device(){
	if($('#new_device_creating_button').html() == 'Create'){
		if($('#device_name').val() == 'Enter device name here' || $('#device_name').val() == ''){		
			$('#new_device_error_message').show('fast');
			$('#new_device_error_message').html('Please enter device name');
			
		}else if($('#tag_number').val() == 'Enter tag number here' || $('#tag_number').val() == ''){		
			$('#new_device_error_message').show('fast');
			$('#new_device_error_message').html('Please enter device tag number');
			
		}else if($('#selected_device_type').val() == 0){		
			$('#new_device_error_message').show('fast');
			$('#new_device_error_message').html('You need to select type for this device');
			
		}else if($('#selected_member').val() == 0){		
			$('#new_device_error_message').show('fast');
			$('#new_device_error_message').html('You need to select user for this device');
			
		}else{
			var data = new FormData();
			data.append('new_device',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('device_title',$('#device_name').val());
			data.append('device_tag',$('#tag_number').val());
			data.append('device_branch',$('#device_branch').val());
			data.append('device_type',$('#selected_device_type').val());
			data.append('user_date',$('#selected_member').val());
			data.append('device_details',$('#device_particulars').val());
			
			send_general_xmlhttp(data);
			
			$('#new_device_creating_button').html('Wait...');
		}
	}
}

function fetch_device_details(device_date){
	var data = new FormData();
	data.append('fetch_device_details',1);
	data.append('device_date',device_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#ctive_user_date').val());
	send_general_xmlhttp(data);
	
	show_window('item_details',1);
	show_loading_progress('detailed_info');
}

function update_device(device_date){
	var data = new FormData();
	data.append('update_device',1);
	data.append('device_date',device_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('device_name',$('#edit_device_name').val());
	data.append('tag_number',$('#device_tag').val());
	data.append('device_type',$('#edit_device_type').val());
	data.append('user_date',$('#edit_device_user').val());
	data.append('particulars',$('#edit_particulars').val());
	
	$('#edit_device_update_button').html('Wait...');
	
	send_general_xmlhttp(data);
}

function fetch_claim_types(){
	var data = new FormData();
	data.append('fetch_claim_types',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('user_type',$('#user_type').val());
	
	send_general_xmlhttp(data);
	
	show_loading_progress('section_information');
}

function create_claim_type(){
	if($('#create_claim_type').html() == 'Create'){
		if($('#new_claim_type_title').val() == 'Enter title here' || $('#new_claim_type_title').val() == ''){		
			$('#new_claim_type_error_message').show('fast');
			$('#new_claim_type_error_message').html('Please enter claim type title');
			
		}else if($('#new_claim_type_approval_levels').val() == 'Enter number of approval levels here' || $('#new_claim_type_approval_levels').val() == ''){		
			$('#new_claim_type_error_message').show('fast');
			$('#new_claim_type_error_message').html('Please enter number of approval levels');

		}else if($('#new_claim_type_daily_rate').val() == 'Enter daily rate here' || $('#new_claim_type_daily_rate').val() == ''){
			$('#new_claim_type_error_message').show('fast');
			$('#new_claim_type_error_message').html('Please enter daily rate for this claim type');
			
		}else{
			var data = new FormData();
			data.append('create_claim_type',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			data.append('title',$('#new_claim_type_title').val());
			data.append('levels',$('#new_claim_type_approval_levels').val());
			data.append('urgency',$('#new_claim_type_urgency_id').val());
			data.append('color',$('#new_claim_type_color_code').val());
			data.append('daily_rate',$('#new_claim_type_daily_rate').val());
			data.append('max_payable_days',$('#new_claim_type_max_payable').val());
			data.append('allow_day_change',$('#new_claim_type_day_adjustment_input').val());
			
			send_general_xmlhttp(data);
			
			$('#create_claim_type').html('Wait...');
			
		}
	}
}

function fetch_claim_type_details(claim_type_date){
	show_window('item_details');
	show_loading_progress('detailed_info');
	
	var data = new FormData();
	data.append('fetch_claim_type_details',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('claim_type_date',claim_type_date);
	data.append('user_type',$('#user_type').val());
	
	send_general_xmlhttp(data);
}

function delete_claim_type(claim_type_date){
	if($('#claim_delete_button').html('Delete')){
		var c = confirm('Are you sure you wish to delete this claim type? Claims using this claim type will be deleted');
		
		if(c){
			var data = new FormData();
			data.append('delete_claim_type',1);
			data.append('claim_type_date',claim_type_date);
			data.append('company_id',$('#active_company_id').val());
			
			send_general_xmlhttp(data);			
			$('#claim_delete_button').html('Deleting...');
		}
	}
}

function disable_claim_type(claim_type_date,operation){
	if($('#claim_disable_button_1').html() == 'Disable' || $('#claim_disable_button_1').html() == 'Enable'){
		var c = confirm('This will disable/enable this claim type. All claims under it will not be affected. Proceed?');
		
		if(c){
			var data = new FormData();
			data.append('disable_claim_type',1);
			data.append('claim_type_date',claim_type_date);
			data.append('company_id',$('#active_company_id').val());
			data.append('operation',operation);
			
			send_general_xmlhttp(data);			
			$('#claim_disable_button_1').html('Wait...');
			$('#claim_disable_button_2').html('Wait...');
		}
	}
}


function fetch_level_locations(level,table){
	$('#active_'+level+'_location').html('Fetching...');
	
	var data = new FormData();
	data.append('fetch_level_locations',1);
	data.append('level',level);
	data.append('table',table);
	data.append('company_id',$('#active_company_id').val());
	
	send_general_xmlhttp(data);
}

function update_claim_type(claim_type_date){
	var data = new FormData();
	data.append('update_claim_type',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('claim_type_date',claim_type_date);
	data.append('title',$('#claim_type_edit_title').val());
	data.append('levels',$('#claim_type_edit_levels').val());
	data.append('title',$('#claim_type_edit_title').val());
	data.append('daily_rate',$('#claim_type_edit_daily_rate').val());
	data.append('day_limit',$('#edit_claim_type_max_payable').val());
	data.append('day_adjust',$('#edit_claim_type_day_adjustment_input').val());
	data.append('urgency',$('#edit_claim_type_urgency_id').val());
	data.append('color',$('#edit_claim_type_color_code').val());
	
	data.append('creator_rule',$('#edit_creator_rule').val());
	data.append('creator_location',$('#edit_creator_location').val());
	data.append('creator_unit',$('#edit_creator_unit').val());
	
	var approval_rules = $('#edit_creator_rule').val()+':'+$('#edit_creator_location').val()+':'+$('#edit_creator_unit').val();
	
	var level_titles = $('#edit_level_title_0').val();
	for(var i=1;i<Number($('#claim_type_edit_levels').val());i++){
		if($('#edit_level_'+i+'_rule').val() == undefined){
			data.append('level_'+i+'_rule','s');
			data.append('level_'+i+'_location',0);
			data.append('level_'+i+'_unit',0);
			
			approval_rules = approval_rules+',s:0:0';
			
		}else{
			data.append('level_'+i+'_rule',$('#edit_level_'+i+'_rule').val());
			data.append('level_'+i+'_location',$('#edit_level_'+i+'_location').val());
			data.append('level_'+i+'_unit',$('#edit_level_'+i+'_unit').val());
			
			approval_rules = approval_rules+','+$('#edit_level_'+i+'_rule').val()+':'+$('#edit_level_'+i+'_location').val()+':'+$('#edit_level_'+i+'_unit').val();
		}
		
		level_titles = level_titles+','+$('#edit_level_title_'+i).val();
	}
	
	data.append('approval_rules',approval_rules);
	data.append('edit_level_titles',level_titles);
	
	$('#update_claim_type_button_1').html('Wait...');
	$('#update_claim_type_button_2').html('Wait...');
	
	send_general_xmlhttp(data);
		
}

function fetch_payment_claims(){
	general_index = 0;
	var data = new FormData();
	data.append('fetch_payment_claims',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_type',$('#user_type').val())
	data.append('user_date',$('#active_user_date').val())
	

	data.append('search_key',$('#search_key').val());
	data.append('type_id',$('#selected_claim_type').val());
	data.append('unit_id',$('#selected_claim_unit').val());
	data.append('region_id',$('#selected_region_id').val());
	data.append('selected_only_my_approval',$('#selected_only_my_approval').val());
	
	data.append('province_id',$('#selected_provinces_id').val());
	
	data.append('hub_id',$('#selected_districts_id').val());
	
	data.append('site_id',$('#selected_sites_id').val());
	
	data.append('beneficiary_date',$('#selected_claim_agent_date').val());
	
	data.append('start_day',$('#new_report_start_day').val());
	data.append('start_month',$('#new_report_start_month').val());
	data.append('start_year',$('#new_report_start_year').val());
	
	data.append('end_day',$('#new_report_end_day').val());
	data.append('end_month',$('#new_report_end_month').val());
	data.append('end_year',$('#new_report_end_year').val());
	
	data.append('_level',$('#selected_level').val())
	
	show_loading_progress('section_information');
	send_general_xmlhttp(data);
	
}


function add_beneficiary(){
	general_index++;
	var code = $('#beneficiary_').html();
	
	code = code.replace(/_0/g,"_"+general_index);
	code = '<div style="width:100%;float:left;height:25px;line-height:25px;border-bottom:solid 1px #eee;" id="beneficiary_'+general_index+'">'+code+'</div>';
	
	$('#beneficiaries').append(code);
	recalculate_claim_total();
}

function add_edit_beneficiary(){
	var this_index = $('#general_index').val();
	var code = $('#claim_addition').html();
	
	code = code.replace(/_0/g,"_"+this_index);
	code = '<div style="width:100%;float:left;height:25px;line-height:25px;border-bottom:solid 1px #eee;" id="edit_beneficiary_'+this_index+'">'+code+'</div>';
	
	$('#edit_beneficiaries').append(code);
	
	this_index++;
	
	$('#general_index').val(this_index);
	recalculate_edit_claim_total();
}

function recalculate_claim_total(){
	var selected_types = $('#new_claim_type').val();
	var selected_types_array = selected_types.split(",");
	
	var total_value = 0;
	for(var t=0;t<selected_types_array.length;t++){
		var selected_agents = $('#selected_agents_'+selected_types_array[t]).val();
		var selected_agents_array = selected_agents.split(",");
		
		if(selected_agents != ''){
			for(var i = 0;i<selected_agents_array.length;i++){
				if($('#amount_'+selected_types_array[t]+'_'+selected_agents_array[i]).val() != 'Amount here' && $('#amount_'+selected_types_array[t]+'_'+selected_agents_array[i]).val() != '' && $('#amount_'+selected_types_array[t]+'_'+selected_agents_array[i]).val() != 0){
					total_value += Number($('#amount_'+selected_types_array[t]+'_'+selected_agents_array[i]).val());
				}
			}
		}
	}
	$('#claim_total_amount').val(total_value);	
	generate_claim_code();
}

function generate_claim_code(){
	if($('#active_claim_unit').html() == 'Select unit'){
		var claim_unit = '[unit]';
		
	}else{
		var claim_unit = $('#active_claim_unit').html();
		
	}
	
	if($('#active_claim_type').html() == 'Select claim type'){
		var claim_type = '[claim_type]';
		
	}else{
		var claim_type = $('#active_claim_type').html();
		
	}
	
	if(claim_type == '<i>Multiple</i>'){
		claim_type = 'Multiple';
		
	}
	
	if($('#active_claim_site').html() == 'Select site'){
		var claim_site = '[claim_site]';
		
	}else{
		var claim_site = $('#active_claim_site').html();
		
	}
	
	var claim_year = $('#new_claim_year').val();
	var claim_month = $('#new_claim_month').val();
	var claim_day = $('#new_claim_day').val();
	
	claim_code = claim_unit+'.'+claim_type+'.'+claim_site+'.'+claim_year+claim_month+claim_day+'.'+(general_index + 1)+'.'+$('#claim_total_amount').val();
	
	$('#claim_code').val(claim_code);
}

function recalculate_edit_claim_total(){
	var total_value = 0;
	for(var i=0;i<Number($('#general_index').val());i++){
		if(($('#edit_amount_'+i).val() != 'Amount here' && $('#edit_phone_'+i).val() != 'Enter phone number here' && $('#edit_name_'+i).val() != 'Enter beneficiary name here') && ($('#edit_amount_'+i).val() != '' && $('#edit_phone_'+i).val() != '' && $('#edit_name_'+i).val() != '')){
				total_value += Number($('#edit_amount_'+i).val());
				
		}else{
			if($('#edit_amount_'+i).val() == 'Amount here'){
				$('#edit_amount_'+i).css('color','#aaa');
				
			}
			
			if($('#edit_phone_'+i).val() == 'Enter phone number here'){
				$('#edit_phone_'+i).css('color','#aaa');
				
			}
			
			if($('#edit_name_'+i).val() == 'Enter beneficiary name here'){
				$('#edit_name_'+i).css('color','#aaa');
				
			}
		}
	}

	$('#edit_claim_total_amount').val(total_value);	
	generate_claim_edit_code();
}

function generate_claim_edit_code(){
	if($('#edit_active_claim_unit').html() == 'Select unit'){
		var claim_unit = '[unit]';
		
	}else{
		var claim_unit = $('#edit_active_claim_unit').html();
		
	}
	
	if($('#edit_active_claim_type').html() == 'Select claim type'){
		var claim_type = '[claim_type]';
		
	}else{
		var claim_type = $('#edit_active_claim_type').html();
		
	}
	
	if($('#edit_active_claim_site').html() == 'Select site'){
		var claim_site = '[claim_site]';
		
	}else{
		var claim_site = $('#edit_active_claim_site').html();
		
	}
	
	var claim_year = $('#edit_claim_year').val();
	var claim_month = $('#edit_claim_month').val();
	var claim_day = $('#edit_claim_day').val();
	
	claim_code = claim_unit+'.'+claim_type+'.'+claim_site+'.'+claim_year+claim_month+claim_day+'.'+$('#general_index').val()+'.'+$('#edit_claim_total_amount').val();
	
	$('#edit_claim_code').val(claim_code);
}

function create_or_update_claim(claim_date){
	//if($('#create_claim_button').html() == 'Create'){
		
		if($('#new_claim_type').val() == 0){
		show_error_message('Please select claim type');
		
		}else if($('#new_claim_site').val() == -1){
			show_error_message('Please select site for this claim');
			
		}else if($('#claim_total_amount').val() == 0){
			show_error_message('You need to complete adding atleast one beneficiary to this claim');
			
		}else if($('#uploaded_files').val() == ''){
			show_error_message('You need to add a picture for this claim');
			
		}else{		
			var data = new FormData();
			data.append('create_claim_or_update',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			data.append('claim_day',$('#new_claim_day').val());
			data.append('claim_month',$('#new_claim_month').val());
			data.append('claim_year',$('#new_claim_year').val());
			data.append('claim_type_date',$('#new_claim_type').val());
			data.append('claim_unit_id',$('#new_claim_unit').val());
			data.append('claim_site_id',$('#new_claim_site').val());
			data.append('claim_total',$('#claim_total_amount').val());
			data.append('claim_code',$('#claim_code').val());
			data.append('claim_date',claim_date);
			
			data.append('file_src',$('#uploaded_files').val());
			data.append('prev_file_src',$('#prev_upload_file').val());
			
			var claim_types = $('#new_claim_type').val();
			var beneficiaries_code = '';
			
			claim_type_array = claim_types.split(',');
			var details_correct = 1;
			
			for(var ct =0;ct<claim_type_array.length;ct++){
			
				data.append('selected_agents_'+claim_type_array[ct],$('#selected_agents_'+claim_type_array[ct]).val());
				
				var selected_agents = $('#selected_agents_'+claim_type_array[ct]).val();
				var selected_agents_array = selected_agents.split(",");
				
				
				for(var i=0;i<selected_agents_array.length;i++){
					if($('#amount_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val() != 0){
						
						
						if($('#agent_id_number_'+selected_agents_array[i]).val() == ''){
							details_correct = 0;
							
							if(details_to_correct == ''){
								details_to_correct = selected_agents_array[i];
								
							}else{
								var details_to_correct_array = details_to_correct.split(',');
								
								var dfound = 0;
								for(var d=0;d<details_to_correct_array.length;d++){
									if(selected_agents_array[i] == details_to_correct_array[d]){
										dfound = 1;
										
									}	
								}
								
								if(dfound == 0){
									details_to_correct = details_to_correct+','+selected_agents_array[i];
								}
							}
						}else{
							data.append('agent_id_number_'+selected_agents_array[i],$('#agent_id_number_'+selected_agents_array[i]).val());
							data.append('agent_id_type_'+selected_agents_array[i],$('#agent_id_type_'+selected_agents_array[i]).val());
							data.append('agent_gender_'+selected_agents_array[i],$('#agent_gender_'+selected_agents_array[i]).val());
							
							data.append('correction_agent_id_number_'+selected_agents_array[i],$('#correction_agent_id_number_'+selected_agents_array[i]).val());
							data.append('correction_agent_id_type_'+selected_agents_array[i],$('#correction_agent_id_type_'+selected_agents_array[i]).val());
							data.append('correction_agent_gender_'+selected_agents_array[i],$('#correction_agent_gender_'+selected_agents_array[i]).val());
							
							
						}

						if(beneficiaries_code == ''){
							beneficiaries_code = selected_agents_array[i];
							
						}else{
							var added_beneficiaries = beneficiaries_code.split(",");
							
							var found = 0;
							for(var ab=0;ab<added_beneficiaries.length;ab++){
								if(selected_agents_array[i] == added_beneficiaries[ab]){
									found = 1;
									
								}								
							}
							
							if(found == 0){
								beneficiaries_code = beneficiaries_code+','+selected_agents_array[i];
							}
						}
						data.append('phone_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#phone_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						data.append('beneficiaries_code',beneficiaries_code);
						
						data.append('days_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#days_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						data.append('paid_days_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#paid_days_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						
						data.append('rate_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#rate_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						
						data.append('comment_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#comment_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						
						data.append('amount_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#amount_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						data.append('from_date_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#from_date_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						
						data.append('to_date_'+claim_type_array[ct]+'_'+selected_agents_array[i],$('#to_date_'+claim_type_array[ct]+'_'+selected_agents_array[i]).val());
						
						
					}
				}
			}
			
			if(details_correct == 0){
				if(!claim_date){
					show_window_special('missing_claim_details',2,'new_claim');
					$('update_agent_details_close_button').attr('onclick','close_window_special(\'missing_claim_details\',\'new_claim\');');
					
				}else{
					show_window_special('missing_claim_details',2,'edit_claim');
					$('update_agent_details_close_button').attr('onclick','close_window_special(\'missing_claim_details\',\'edit_claim\');');
					
				}
				
				$('#update_id_and_create_claim_button').attr('onclick','correct_claim_beneficiaries('+claim_date+')');
				var missing_beneficiary_details_array = details_to_correct.split(',');
				
				var output_string = '';
				for(var m=0;m<missing_beneficiary_details_array.length;m++){
					$('#correction_beneficiary_name_0').html($('#agent_'+missing_beneficiary_details_array[m]+'_label').html());
					var correction_details = '<div style="width:100%;float:left;height:30px;line-height:30px;border-bottom:solid 1px #eee;" id="correction_details_'+missing_beneficiary_details_array[m]+'">'+$('#correction_details_0').html()+'</div>';
					
					correction_details = correction_details.replace(/_0/g,'_'+missing_beneficiary_details_array[m]);
					
					if(output_string == ''){
						output_string = correction_details;
						
					}else{
						output_string = output_string+correction_details;
					}
				}
				
				$('#missing_beneficiary_details').html(output_string);
				
			}else{
				//alert(details_correct);
				send_general_xmlhttp(data);
				$('#create_claim_button').html('Wait...');
				$('#missing_beneficiary_details').html('');
				details_to_correct = '';
			}
		}
	//}
}

function fetch_claim_details(claim_date){
	show_window('item_details');
	show_loading_progress('detailed_info');
	
	var data = new FormData();
	data.append('fetch_claim_details',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('claim_date',claim_date);
	data.append('user_type',$('#user_type').val());
	data.append('user_date',$('#active_user_date').val());
	
	
	send_general_xmlhttp(data);
}

function delete_claim(claim_date){
	if($('#claim_delete_button').html() == 'Disable'){
		var c = confirm('Are you sure you wish to disable this claim? To undo this, you will need to contact the PIPAT manager.');
		
		if(c){
			var data = new FormData();
			data.append('delete_claim',1);
			data.append('claim_date',claim_date);
			data.append('company_id',$('#active_company_id').val());
			
			send_general_xmlhttp(data);
			
			$('#claim_delete_button').html('Wait...');
		}
	}
}

function edit_claim(claim_date){
	var data = new FormData();
	data.append('edit_claim',1);
	data.append('claim_date',claim_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_account_date').val());
	data.append('user_type',$('#user_type').val());
	
	send_general_xmlhttp(data);
	
	close_window('item_details');
	show_window('edit_claim');
	show_loading_progress('this_claim_details');
}

function update_claim(claim_date){
	
	if($('#update_claim_button').html() == 'Update'){
		
		if($('#edit_claim_total_amount').val() == 0){
			alert('You need to complete adding atleast one beneficiary to this claim');
			
		}else{		
			var data = new FormData();
			data.append('update_claim',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('claim_date',claim_date);
			data.append('user_date',$('#active_user_date').val());
			data.append('claim_day',$('#edit_claim_day').val());
			data.append('claim_month',$('#edit_claim_month').val());
			data.append('claim_year',$('#edit_claim_year').val());
			data.append('claim_type_date',$('#edit_claim_type').val());
			data.append('claim_unit_id',$('#edit_claim_unit').val());
			data.append('claim_site_id',$('#edit_claim_site').val());
			data.append('claim_total',$('#edit_claim_total_amount').val());
			data.append('claim_code',$('#edit_claim_code').val());
			data.append('beneficiaries',($('#general_index').val()));
			data.append('file_src',$('#edit_uploaded_claim_file').val());
			data.append('prev_file_src',$('#prev_claim_file_src').val());
			
			var beneficiaries_code = '';
			for(var i=0;i<$('#general_index').val();i++){
				if(($('#edit_amount_'+i).val() != 'Amount here' && $('#edit_phone_'+i).val() != 'Enter phone number here' && $('#edit_name_'+i).val() != 'Enter beneficiary name here') && ($('#edit_amount_'+i).val() != '' && $('#edit_phone_'+i).val() != '' && $('#edit_name_'+i).val() != '')){
					
					if(beneficiaries_code == ''){
						beneficiaries_code = $('#edit_name_'+i).val()+'~|'+$('#edit_phone_'+i).val()+'~|'+$('#edit_amount_'+i).val()+'~|'+$('#edit_from_day_'+i).val()+'~|'+$('#edit_from_month_'+i).val()+'~|'+$('#edit_from_year_'+i).val()+'~|'+$('#edit_to_day_'+i).val()+'~|'+$('#edit_to_month_'+i).val()+'~|'+$('#edit_to_year_'+i).val();
						
					}else{
						beneficiaries_code = beneficiaries_code+'||'+$('#edit_name_'+i).val()+'~|'+$('#edit_phone_'+i).val()+'~|'+$('#edit_amount_'+i).val()+'~|'+$('#edit_from_day_'+i).val()+'~|'+$('#edit_from_month_'+i).val()+'~|'+$('#edit_from_year_'+i).val()+'~|'+$('#edit_to_day_'+i).val()+'~|'+$('#edit_to_month_'+i).val()+'~|'+$('#edit_to_year_'+i).val();
					}
					
				}
				
				//alert($('#beneficiary_date_0').val());

				data.append('beneficiary_date_'+i,$('#beneficiary_date_'+i).val());
				data.append('name_'+i,$('#edit_name_'+i).val());
				data.append('phone_'+i,$('#edit_phone_'+i).val());
				data.append('amount_'+i,$('#edit_amount_'+i).val());
				data.append('from_day_'+i,$('#edit_from_day_'+i).val());
				data.append('from_month_'+i,$('#edit_from_month_'+i).val());
				data.append('from_year_'+i,$('#edit_from_year_'+i).val());
				data.append('to_day_'+i,$('#edit_to_day_'+i).val());
				data.append('to_month_'+i,$('#edit_to_month_'+i).val());
				data.append('to_year_'+i,$('#edit_to_year_'+i).val());
				
			}
			
			data.append('beneficiaries_code',beneficiaries_code);
			
			send_general_xmlhttp(data);
			$('#update_claim_button').html('Wait...');
		}
	}
}

function scroll_right(div){
	prev_scroll_value = Number($('#'+div).scrollLeft());
	var scroll_value = Number($('#'+div).scrollLeft())+60;
	
	$('#'+div).scrollLeft(scroll_value);
	
	//$('#claim_levels_0_scroll_left').fadeIn();
}

function scroll_left(div){
	scroll_value = Number($('#'+div).scrollLeft())-60;
	
	$('#'+div).scrollLeft(scroll_value);
}

function confirm_level(claim_date,beneficiary_date,index,level,claim_type_date){
	
	var data = new FormData();
	data.append('confirm_level',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('claim_date',claim_date);
	data.append('beneficiary_date',beneficiary_date);
	data.append('level',level);
	data.append('claim_type_date',claim_type_date);
	
	send_general_xmlhttp(data);
	
	$('#approve_menu_'+claim_date+'_'+index+'_'+level).hide();
	data_holder = $('#beneficiary_'+beneficiary_date+'_'+'level_'+level).html();
	$('#beneficiary_'+beneficiary_date+'_'+'level_'+level).html('Wait...');
}

function deny_approval(claim_date,beneficiary_date,level,claim_type_date){
	$('#deny_claim_date').val(claim_date);
	$('#deny_beneficiary_date').val(beneficiary_date);
	$('#deny_level').val(level);
	$('#deny_claim_type_date').val(claim_type_date);
	
	show_window('deny_comment',0);
	
}

function confirm_deny_approval(){
	if($('#deny_button').html() == 'Deny'){
		if($('#item_comment').val() == '' || $('#item_comment').val() == 'No comment added'){
			
			show_error_message('You need to add a comment for your denial');
			
		}else{
			var data = new FormData();
			data.append('deny_confirm',1);
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			data.append('claim_date',$('#deny_claim_date').val());
			data.append('claim_type_date',$('#deny_claim_type_date').val());
			
			data.append('beneficiary_date',$('#deny_beneficiary_date').val());
			data.append('level',$('#deny_level').val());
			data.append('comment',$('#item_comment').val())
			
			send_general_xmlhttp(data);
			$('#deny_button').html('Wait...');
		}
	}
}

function fetch_site_agents(claim_date){
	
	if($('#new_claim_type').val() == 0){
		$('#new_claim_agents_holder').slideDown('fast');
		var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Select claim type...</div>';
		$('#new_claim_agents_holder').html(output_data);
		$('#active_claim_type').html('Select claim type');
		
	}else if($('#new_claim_site').val() == -1){
		$('#new_claim_agents_holder').slideDown('fast');
		var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Select claim site...</div>';
		$('#new_claim_agents_holder').html(output_data);
		
	}else{
		
		//if($('#new_claim_site').val() == 0){
			fetch_caim_search_beneficiaries(claim_date,$('#new_claim_site').val());
			
		/*}else{
			var data = new FormData();
			data.append('fetch_site_agents',1);
			data.append('claim_date',claim_date);
			data.append('company_id',$('#active_company_id').val());
			data.append('user_date',$('#active_user_date').val());
			data.append('claim_type',$('#new_claim_type').val());
			data.append('unit_id',$('#new_claim_unit').val());
			data.append('site_id',$('#new_claim_site').val());
			
			send_general_xmlhttp(data);
			generate_claim_code();
			
			$('#new_claim_agents_holder').slideDown('fast');
			var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Fetching agents. Please wait...</div>';
			$('#new_claim_agents_holder').html(output_data);
			$('#claim_total_amount').val(0);
		}*/
		
		
	}
}

function fetch_caim_search_beneficiaries(claim_date,site_id){
	
	if($('#selected_search_beneficiaries').val() == '' && site_id == 0){
		var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Select at-least one beneficiary</div>';
		$('#new_claim_agents_holder').html(output_data);
	
	}else if($('#new_claim_type').val() == 0){
		$('#new_claim_agents_holder').slideDown('fast');
		var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Select claim type...</div>';
		$('#new_claim_agents_holder').html(output_data);
			
	}else{
		var data = new FormData();
		data.append('fetch_caim_search_beneficiaries',1);
		data.append('claim_date',claim_date);
		data.append('company_id',$('#active_company_id').val());
		data.append('user_date',$('#active_user_date').val());
		data.append('claim_type',$('#new_claim_type').val());
		data.append('unit_id',$('#new_claim_unit').val());
		data.append('site_id',site_id);
		data.append('selected_agents',$('#selected_search_beneficiaries').val());
		
		send_general_xmlhttp(data);
		
		$('#new_claim_agents_holder').slideDown('fast');
		var output_data = '<div style="width:100%;height:20px;text-align:center;line-height:20px;">Fetching agents. Please wait...</div>';
		$('#new_claim_agents_holder').html(output_data);
	}
	
	$('#claim_total_amount').val(0);
	generate_claim_code();
}

function fetch_agent_days(type_date,ind,agent_id){
	var data = new FormData();
	data.append('fetch_agent_days',1);
	data.append('ind',ind);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('claim_type',$('#new_claim_type').val());
	data.append('unit_id',$('#new_claim_unit').val());
	data.append('site_id',$('#new_claim_site').val());
	data.append('type_date',type_date);
	
	data.append('agent_id',agent_id);
	
	//alert($('#from_day_'+type_date+'_'+ind).val());
	
	data.append('from_date',$('#from_date_'+type_date+'_'+ind).val());
	data.append('to_date',$('#to_date_'+type_date+'_'+ind).val());
		
	$('#beneficiary_'+type_date+'_'+ind+'_progress').fadeIn('fast');
	
	send_general_xmlhttp(data);
}

function add_to_agents(type_date,agent_date){
	if($('#selected_agents_'+type_date).val() == ''){
		$('#selected_agents_'+type_date).val(agent_date);

	}else{
		$('#selected_agents_'+type_date).val($('#selected_agents_'+type_date).val()+','+agent_date);
		
	}
	
	recalculate_claim_total();
}

function remove_from_agents(type_date,agent_date){
	var selected_agents = $('#selected_agents_'+type_date).val();
	var selected_agents_array = selected_agents.split(",");
	
	var new_selections = '';
	for(var i=0;i<selected_agents_array.length;i++){
		if(agent_date != selected_agents_array[i]){
			if(new_selections == ''){
				new_selections = selected_agents_array[i];
				
			}else{
				new_selections = new_selections+','+selected_agents_array[i];
				
			}
		}
	}
	$('#selected_agents_'+type_date).val(new_selections);
	
	recalculate_claim_total();
}

function search_claim_site(claim_date){
	$('#claim_site_search_results').html('Searching sites. Please wait...');
	
	var data = new FormData();
	data.append('search_claim_site',1);
	data.append('search_key',$('#search_site_key').val());
	data.append('company_id',$('#active_company_id').val())
	data.append('claim_date',claim_date);
	
	send_general_xmlhttp(data);
}

function search_claim_beneficiary(){
	
	$('#claim_beneficiary_search_results').html('Searching beneficiaries. Please wait...');
	alert($('#claim_beneficiary_search_results').html());
	var data = new FormData();
	data.append('search_claim_beneficiary',1);
	data.append('search_key',$('#search_beneficiary_key').val());
	data.append('company_id',$('#active_company_id').val())
	
	send_general_xmlhttp(data);
}

function search_new_claim_beneficiary(claim_date){

	$('#new_claim_beneficiary_search_results').html('Searching beneficiaries. Please wait...');
	$('#new_claim_beneficiary_search_results_holder').slideDown('fast');
	var data = new FormData();
	data.append('search_new_claim_beneficiary',1);
	data.append('search_key',$('#search_new_beneficiary_key').val());
	data.append('company_id',$('#active_company_id').val())
	data.append('claim_date',claim_date);
	send_general_xmlhttp(data);
}





function add_beneficiary_comment(type_date){
	
	var comment_date = $('#beneficiary_comment_date').val();
	
	if(!isNaN($('#paid_days_'+type_date+'_'+comment_date).val())){
		
		var new_value = $('#paid_days_'+type_date+'_'+comment_date).val();
		
		var old_value = $('#beneficiary_comment_previous_value').val();
		
		$('#beneficiary_comment_new_value').val(new_value);

		
		$('#beneficiary_comment_new_type').val(type_date);		
		$('#beneficiary_comment_previous_date').val(comment_date);
		
		show_window_special('beneficiary_comment',1,'new_claim');
		//document.getElementById('item_comment').focus();
		
	}else{
		alert('Amount should be a numeric value without currency signs or commas');
		
		$('#amount_'+type_date+'_'+comment_date).css('borderColor','red');
	}
	$('#paid_days_'+type_date+'_'+comment_date).val(old_value);
	recalculate_claim_total();
	
	
}

function process_beneficiary_comment(){
	var type_date = $('#beneficiary_comment_new_type').val();
	var comment_date = $('#beneficiary_comment_previous_date').val();
	//var new_value = $('#beneficiary_comment_new_value').val();
	
	$('#paid_days_'+type_date+'_'+comment_date).val($('#beneficiary_comment_new_value').val());
	
	var new_value = Number($('#paid_days_'+type_date+'_'+comment_date).val())*Number($('#rate_'+type_date+'_'+comment_date).val());
	$('#amount_'+type_date+'_'+comment_date).val(new_value);
	$('#comment_'+type_date+'_'+comment_date).val($('#item_comment').val());
	close_window_special('beneficiary_comment','new_claim');
	
	if(document.getElementById('check_'+type_date+'_'+comment_date).checked == false){
		add_to_agents(type_date,comment_date);
		document.getElementById('check_'+type_date+'_'+comment_date).checked = true;
	}
	
	recalculate_claim_total();
	$('#item_comment').val('No comment added');
	$('#item_comment').css('color','#aaa');
}

function add_to_claim_types(claim_date){
	if($('#new_claim_type').val() == 0){
		$('#new_claim_type').val(claim_date);
		
	}else{
		$('#new_claim_type').val($('#new_claim_type').val()+','+claim_date);
	}
	
	$('#active_claim_type').html('<i>Multiple</i>');
}

function remove_from_claim_types(claim_date){
	var current_claim_types = $('#new_claim_type').val();
	var current_claim_type_array = current_claim_types.split(',');
	
	var new_claim_types = 0; 
	for(var c=0;c<current_claim_type_array.length;c++){
		if(current_claim_type_array[c] != claim_date){
			if(new_claim_types == 0){
				new_claim_types = current_claim_type_array[c];
				
			}else{
				new_claim_types = new_claim_types+','+current_claim_type_array[c];
			}
		}	
	}
	
	$('#new_claim_type').val(new_claim_types);
}

function clear_claim_types(claim_date){
	var current_claim_types = $('#new_claim_type').val();
	
	if(current_claim_types != 0){
		var current_claim_type_array = current_claim_types.split(",");
		
		for(var c = 0;c<current_claim_type_array.length;c++){
			document.getElementById('claim_check_'+current_claim_type_array[c]).checked = false;
		}
	}
	$('#new_claim_type').val(claim_date);
	document.getElementById('claim_check_'+claim_date).checked = true;
	
	
}

function fetch_tracker(jump){
	var data = new FormData();
	data.append('fetch_tracker',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('search_key',$('#search_key').val());
	data.append('type_id',$('#selected_claim_type').val());
	data.append('unit_id',$('#selected_claim_unit').val());
	data.append('region_id',$('#selected_region_id').val());
	data.append('selected_only_my_approval',$('#selected_only_my_approval').val());
	
	data.append('province_id',$('#selected_provinces_id').val());
	
	data.append('hub_id',$('#selected_districts_id').val());
	
	data.append('site_id',$('#selected_sites_id').val());
	
	data.append('beneficiary_date',$('#selected_claim_agent_date').val());
	
	data.append('start_day',$('#new_report_start_day').val());
	data.append('start_month',$('#new_report_start_month').val());
	data.append('start_year',$('#new_report_start_year').val());
	
	data.append('end_day',$('#new_report_end_day').val());
	data.append('end_month',$('#new_report_end_month').val());
	data.append('end_year',$('#new_report_end_year').val());
	
	data.append('_level',$('#selected_level').val());
	
	if(jump == undefined){
		data.append('jump',0);
			
	}else{
		data.append('jump',jump);
	}

	send_general_xmlhttp(data);
	show_loading_progress('information_holder');
}

function open_spreadsheet(claim_date){
	var c = confirm('You are about to open a spreadsheet containing selected items. Proceed?');
	
	if(c){
		var key = 'hblhsbsrbefibuqpufubnslnlquigrw2187768';
		var b = $('#claim_'+claim_date+'_selected_beneficiaries').val();
		window.open($('#url').val()+'/spreadsheet.php?s=true&k='+key+'&cd='+claim_date+'&comp='+$('#active_company_id').val()+'&u='+$('#active_user_date').val()+'&b='+b,'spreadsheet');
	}
}

function fetch_report(){
	var data = new FormData();
	data.append('fetch_report',1);
	data.append('selected_report',$('#selected_report').val());
		
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	
	data.append('start_day',$('#new_report_start_day').val());
	data.append('start_month',$('#new_report_start_month').val());
	data.append('start_year',$('#new_report_start_year').val());
	
	data.append('end_day',$('#new_report_end_day').val());
	data.append('end_month',$('#new_report_end_month').val());
	data.append('end_year',$('#new_report_end_year').val());
	
	if($('#selected_focus').val() == undefined){
		data.append('focus',0);
		data.append('consideration',1);
		
	}else{
		data.append('focus',$('#selected_focus').val());
		data.append('consideration',$('#selected_cos').val());
		
	}
	
	send_general_xmlhttp(data);
	
	
	if($('#selected_report').val() != 4){
		show_loading_progress('report_container');
	}
}

function confirm_level_all(claim_date,level,claim_type_date){
	$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level).html('Wait...');
	
	$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level).css('textAlign','center');
	var selected_items = $('#claim_'+claim_date+'_selected_beneficiaries').val();
	
	confirm_level(claim_date,selected_items,0,level,claim_type_date);
	
	
}

function deny_approval_all(claim_date,level,claim_type_date){
	
	var c = confirm('All applicable entries will be denied with similar comment. Proceed to comment?');
	
	if(c){
		var selected_items = $('#claim_'+claim_date+'_selected_beneficiaries').val();
		
		deny_approval(claim_date,selected_items,level,claim_type_date);
	}
}


function export_claim(claim_date,_format){
	window.open($('#url').val()+'/excel_export.php?cd='+claim_date+'&c='+$('#active_company_id').val()+'&f='+_format,'excel_export');
}

function fetch_claim_beneficiaries(claim_date){
	var data = new FormData();
	data.append('fetch_claim_beneficiaries',1);
	data.append('claim_date',claim_date);
	data.append('company_id',$('#active_company_id').val());
	data.append('user_date',$('#active_user_date').val());
	data.append('user_type',$('#user_type').val());
	
	send_general_xmlhttp(data);
	
}

function add_upload_field(){
	if($('#uploaded_files').val() == ''){
		var total_fields = 0;
		
	}else{
		var uploaded_files = $('#uploaded_files').val();
		var uploaded_files_array = uploaded_files.split(',');
		var total_fields = uploaded_files_array.length;
	
	}
	
	if(items == 0){
		items = total_fields;
		
	}
		
	var field = '<div style="width:250px;height:30px;float:left;margin-bottom:10px;" id="image_'+items+'_holder"><input type="file" name="image_'+items+'" id="image_'+items+'" style="height:30px;" onchange="tmp_single_upload('+$('#active_company_id').val()+','+items+');"></div><div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:red;" id="image_'+items+'_error"></div><div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:#000;" id="image_'+items+'_progress"><img src="http://localhost/blueraysit.com/imgs/loading.gif" style="height:20px;float:left;"> <div style="margin-left:6px;width:auto;height:20px;line-height:20px;float:left;">Uploading file... Please wait</div></div>';
	
	$('#image_fields').append(field);
	
	$('#items').val(items);
	items++;
}

function div_mousedown(div_id){
	$('#'+div_id).css('border-color','#006bb3');	
}


function correct_claim_beneficiaries(claim_date){
	var agent_correction_array = details_to_correct.split(',');
	
	var all_fixed = 1;
	for(var d=0;d<agent_correction_array.length;d++){
		if($('#correction_id_number_'+agent_correction_array[d]).val() == ''){
			all_fixed = 0;
			$('#correction_error_msg').show('fast');
			$('#correction_error_msg').html('You need to provide ID Number in highlighted fields');
			$('#correction_id_number_'+agent_correction_array[d]).css('border-color','red');
		}
	}
	
	if(all_fixed == 1){
		for(var d=0;d<agent_correction_array.length;d++){
			
				$('#agent_id_number_'+agent_correction_array[d]).val($('#correction_id_number_'+agent_correction_array[d]).val());

				$('#agent_id_type_'+agent_correction_array[d]).val($('#correction_id_type_'+agent_correction_array[d]).val());

				$('#agent_gender_'+agent_correction_array[d]).val($('#correction_gender_'+agent_correction_array[d]).val());				
		}
		
		if(!claim_date){
			close_window_special('missing_claim_details','new_claim');
			
		}else{
			close_window_special('missing_claim_details','edit_claim');
			
		}
		
		$('#update_id_and_create_claim_button').html('Wait...');
		create_or_update_claim(claim_date);
	}
}

function process_claim_csv(){
	$('#caim_scv').val($('#uploaded_files').val());
	
	reset_image_upload();
}

function fetch_divisions(department_id){
	var data = new FormData();
	data.append('fetch_divisions',1);
	data.append('department_id',department_id);
	
	send_general_xmlhttp(data);
}
