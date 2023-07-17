var rep_timer = null;
var general_variable = '';
var general_variable_0 = 0;

$(document).ready (function (){
	
});

var progress_text = '<div style="width:200px;height:auto;margin:0 auto;margin-top:30px;display:none;" id="progress_bar"><div style="width:200px;height:20px;line-height:20px;float:left;text-align:center;" id="loading_text">Fetching data. Please wait...</div><div style="width:200px;background-color:#006bb3;height:5px;float:left;line-height:5px;text-align:left;color:#006bb3;font-size:1.4em;" id="progress_line"></div><div style="width:200px;height:20px;float:left;text-align:center;margin-top:40px;font-size:0.7em;position:absolute;">&#0169; BlueRays Software</div></div>';

if(window.XMLHttpRequest){
	default_general_xmlhttp = new XMLHttpRequest();
	system_general_xmlhttp = new XMLHttpRequest();

}else{
	default_general_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	system_general_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	
}

function login_delay_processor(){
	
	var login_delay = Number($('#login_delay').val());
	var current_login_delay_time = Number($('#current_login_delay_time').val());
	
	if(current_login_delay_time > 0){
		$('#login_progress').html('<div style="width:100%;height:20px;float:left;text-align:center;">Invalid login. Wait... '+current_login_delay_time+'</div>');
		
		var new_login_delay_time = current_login_delay_time-1;
		
		$('#current_login_delay_time').val(new_login_delay_time);
		setTimeout('login_delay_processor()',1000);
	
	}else{
		hide_loading_progress('login_progress');
		$('#login_cover').fadeOut('fast');
		$('#login_progress').html('');
	}
}

default_general_xmlhttp.onreadystatechange = function(){
	if(default_general_xmlhttp.readyState == 4 && default_general_xmlhttp.status == 200){
		var response_text = default_general_xmlhttp.responseText;
		var response_array = response_text.split("~");
	
		if(response_array[0] == 'process_login'){
			if(response_array[1] ==0 || response_array[7] ==0){
				show_div('login_error_msg',response_array[2],0,'fast');				
				
				if(response_array[8] != 0){
					if(response_array[8] == 1){
						$('#login_delay').val(Number(response_array[9]));
						
					}else if(response_array[8] == 2){
						$('#login_delay').val(Number($('#login_delay').val())+Number(response_array[9]));
					}
					
					$('#current_login_delay_time').val($('#login_delay').val());					
					setTimeout('login_delay_processor()',1000);
					
				}else{
					hide_loading_progress('login_progress');
					$('#login_cover').fadeOut('fast');
				}
				
				if(response_array[10] == 0 && response_array[11] == 0){
					$('#forgot_password').slideDown();
				}
				
			}else{
				$('#login_user_id').val(response_array[4]);
				$('#login_user_id').val(response_array[5]);
				$('#login_user_type').val(response_array[6]);
				var this_function_name = response_array[3]+'('+response_array[4]+','+response_array[5]+','+response_array[6]+')';
				eval(this_function_name);
				
				$('#loading_text').html('Login successful. Redirecting...');
				$('#loading_text').css('color','green');
			}
			
		}else if(response_array[0] == 'authenticateRecovery'){
			var user_found = response_array[1];
			var user_id = response_array[2];
			
			if(user_found == 1){
				$('#password_recovery_step_2').slideDown('fast');
				$('#password_recovery_step_1').slideUp('fast');
				$('#login_error_msg').slideUp('fast');
				
			}else{
				$('#password_recovery_step_2').slideUp('fast');
				$('#password_recovery_step_1').slideDown('fast');
				$('#login_error_msg').slideDown('fast');
			}
			
			$('#login_error_msg').html(response_array[3]);
			
			$('#this_user_id').val(user_id);
			$('#check_recovery_button').html('Continue');
			
		}else if(response_array[0] == 'process_password_reset'){
			if(response_array[2] == 1){
				alert('Password reset successfull. Please login with new password...');
					
				if(response_array[4] == 1){
					window.open($('#url').val(),'_self');
					
				}else{
					$('#recovery').slideUp('fast');
					$('#login').slideDown('fast');
					$('#password_recovery_step_1').slideDown('fast');
					$('#password_recovery_step_2').slideUp('fast');
					
					$('#reset_code').val('Enter code from email');
					$('#reset_code').css('color','#aaa')
					;
					$('#reset_password').val('Enter your new password');
					
					$('#reset_password2').val('Re-enter your new password');
					
					$('#login_error_msg').html('Send password reset link');
					$('#login_error_msg').slideUp('fast');
				}
				
			}else{			
				$('#login_error_msg').html(response_array[3]);
				$('#login_error_msg').slideDown('fast');
			}
			
			$('#password_reset_button').html('Reset');
			
		}else if(response_array[0] == 'fetch_menu_items'){
			$('#'+response_array[2]+'_menu').html(response_array[1]);
	
			$('#active_'+response_array[2]).html('Select item');
			
		}else if(response_array[0] == 'quick_search_items'){
			$('#'+response_array[2]+'_results').html(response_array[1]);
			
		}else{
			alert('-root_'+response_array[0]);
		}
	}
}

system_general_xmlhttp.onreadystatechange = function(){
	if(general_xmlhttp.readyState == 4 && general_xmlhttp.status == 200){
		//alert('hey');
		var response_text = general_xmlhttp.responseText;
		var response_array = response_text.split("~");
	
		if(response_array[0] == 'fetch_menu_page'){
			$('#page_information_holder').html(response_array[2]);
			
			if(active_menu != response_array[1]){
				$('#menu_'+response_array[1]).css('background-color','#006bb3');
				$('#menu_'+active_menu).css('background-color','');
				active_menu = response_array[1];
			}
	
		}else{
			alert('root_'+response_array[0]);
		}
	}
}


function send_default_general_xmlhttp(a){
	default_general_xmlhttp.open('POST',$('#url').val()+'/default_general_xmlhttp_processor.php',true);
	default_general_xmlhttp.send(a);
}

function send_system_general_xmlhttp(a){
	
	//system_general_xmlhttp.open('POST','../../my_site/general_xmlhttp_processor.php',true);
	system_general_xmlhttp.send(a);
	
	//alert('hey');
}


function authenticate_signin(){
	if($('#login_username').val() == 'Enter your login user name'){
		show_div('login_error_msg','You need to enter your username',0,'fast');
		alarm_input('login_username');
		
	}else if($('#login_password').val() == 'password'){
		show_div('login_error_msg','You need to enter your account password',0,'fast');
		alarm_input('login_password');		
		
	}else{
		$('#login_cover').fadeIn('fast');
		show_loading_progress('login_progress','Checking credentials. Please wait...');

		var function_name = $('#function_name').val();
		process_login(function_name);
		hide_div('login_error_msg',0,'fast');
	}
}

function process_login(function_name){
	var data = new FormData();
	data.append('process_login',1);
	data.append('function_name',function_name);
	data.append('username',$('#login_username').val());
	data.append('password',$('#login_password').val());
	data.append('table_name',$('#table_name').val());
	data.append('connection',$('#connection').val());
	data.append('site_url',$('#url').val());

	send_default_general_xmlhttp(data);
}

function display_progress(progress_cover_id,progress_id){
	$('#'+progress_cover_id).fadeIn('fast');
	$('#'+progress_id).fadeIn('slow');
}

function hide_progress(progress_cover_id,progress_id){
	$('#'+progress_cover_id).fadeOut('fast');
	$('#'+progress_id).fadeOut('fast');
}

function show_loading_progress(div_id,message){
	$('#'+div_id).html(progress_text);
	$('#loading_text').html(message);
	$('#progress_bar').fadeIn('fast');
	animate_progress();
	
}


function animate_progress(){
	$('#progress_line').animate({marginTop:(10) + 'px'},'slow');
	$('#progress_line').animate({marginTop:(0) + 'px'},'slow');
	
	var general_variable = setTimeout("animate_progress()",1000);
}

function hide_loading_progress(div_id){
	//$('#loading_text').html('');
	$('#progress_bar').fadeOut('fast');
	//animate_progress();
}

function show_div(div_id,message,show_type,speed){
	if(show_type == 0){
		$('#'+div_id).fadeIn(speed);
		
	}else if(show_type == 1){
		$('#'+div_id).slideDown(speed);
		
	}else if(show_type == 2){
		$('#'+div_id).show(speed);
		
	}
	
	$('#'+div_id).html(message);
}

function hide_div(div_id,show_type,speed){
	if(show_type == 0){
		$('#'+div_id).fadeOut(speed);
		
	}else if(show_type == 1){
		$('#'+div_id).slideUp(speed);
		
	}else if(show_type == 2){
		$('#'+div_id).hide(speed);
		
	}
}

function alarm_input(input_id){
	document.getElementById(input_id).style.borderColor='red';
}

function disalarm_input(input_id){
	document.getElementById(input_id).style.borderColor='#aaa';
}

function clear_input_value(input_id,value){	
	if($('#'+input_id).val() == ''+value+''){
		
		$('#'+input_id).val('');
		$('#'+input_id).css('color','#000');
		
		
	}
}

function refill_input_value(input_id,value){
	if($('#'+input_id).val()==''){
		$('#'+input_id).val(value);
		$('#'+input_id).css('color','#aaa');
		
	}
}

function show_window(a,b){
	$('#info_cover').fadeIn('fast');
	$('#'+a).fadeIn('fast');
	center_item_vertical(a,b);
}

function add_to_selection(selection_id,input_id){
	var selected_items = $('#'+input_id).val();
	if(selected_items == ''){
		selected_items = selection_id;
	
	}else{
		selected_items = selected_items+','+selection_id;
	}
	
	$('#'+input_id).val(selected_items);
	
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

function trim_from_selection(index,input_id){	
	items = $('#'+input_id).val();
	items_array = items.split(',');
	
	var new_items = '';
	for(var i=0;i<items_array.length;i++){
		
		if(index == i){
			break;
			
		}
		
		if(new_items === ''){
			new_items = items_array[i];
		
		}else{
			new_items = new_items+','+items_array[i];			
		}
	}
	
	$('#'+input_id).val(new_items);
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

function open_uploader(function_name, multiple_images){
	show_window('image_uploader',1);
	
	if(multiple_images == 0){
		$('#uploader_more_images').hide('fast');
	}
	$('#save_upload_images').attr('onclick',function_name);	
}

function reset_image_upload(){
	$('#uploaded_files').val('');
	var items = Number($('#items').val());
	
	for(var i =0;i<(items +1);i++){
		$('#image_'+i+'_progress').hide('fast');
		$('#image_'+i+'_error').hide();
		$('#image_'+i+'_holder').show('fast');
		$('#image_'+i).val('');
	}
	
	$('#uploader_error_message').html('');
	$('#uploader_error_message').hide('fast');
}

function add_upload_field(){
	var total_fields = Number($('#items').val());
	total_fields++;
	
	var field = '<div style="width:250px;height:30px;float:left;margin-bottom:10px;" id="image_'+total_fields+'_holder"><input type="file" name="image_'+total_fields+'" id="image_'+total_fields+'" style="height:30px;color:transparent" onchange="tmp_single_upload('+$('#company_id').val()+','+total_fields+');"></div><div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:red;" id="image_'+total_fields+'_error"></div><div style="display:none;width:250px;min-height:20px;height:auto;line-height:20px;float:left;margin-bottom:10px;color:#000;" id="image_'+total_fields+'_progress"><img src="http://localhost/blueraysit.com/imgs/loading.gif" style="height:20px;float:left;"> <div style="margin-left:6px;width:auto;height:20px;line-height:20px;float:left;">Uploading image... Please wait</div></div>';
	
	$('#image_fields').append(field);
	
	$('#items').val(total_fields);
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
	data.append('allow_no_session',$('#allow_no_session').val());
	
	send_general_xmlhttp(data);
}

function fetch_menu_page(menu_id){
	var data = new FormData();
	data.append('fetch_menu_page',1);
	data.append('menu_id',menu_id);
	data.append('company_id',$('#company_id').val());
	data.append('user_id',$('#user_id').val());
	data.append('license_expiry',$('#license_expiry').val());
	
	send_general_xmlhttp(data);
	clearTimeout(general_variable);
	animate_menu(menu_id);
	//$('#menu_progress_'+menu_id).fadeIn('fast');
}

function fetch_script(script,receiving_div,src_type){
	var data = new FormData();
	data.append('fetch_script',1);
	data.append('company_id',$('#company_id').val());
	data.append('script',script);
	data.append('receiving_div',receiving_div);
	
	data.append('active_area_id',$('#active_area_id').val());
	
	if(src_type == undefined){
		data.append('src_type',0);
		
	}else{
		data.append('src_type',src_type);
		
	}
	
	send_general_xmlhttp(data);
	
	show_loading_progress(receiving_div,'Extracting. One moment please.');
}

function tab_item_change(active_tab_id){
	$('#tab_'+general_variable_0).css('background-color','');
	$('#tab_'+general_variable_0).attr('onmouseover','this.style.backgroundColor=\'#ddd\';');
	$('#tab_'+general_variable_0).attr('onmouseout','this.style.backgroundColor=\'\';');
	
	$('#tab_'+active_tab_id).hide();
	$('#tab_'+active_tab_id).slideDown('fast');
	
	$('#tab_'+active_tab_id).css('background-color','#ccc');
	$('#tab_'+active_tab_id).attr('onmouseover','');
	$('#tab_'+active_tab_id).attr('onmouseout','');

	general_variable_0 = active_tab_id;
}

function animate_menu(menu_id){
	if(active_menu != menu_id){
		$('#menu_'+menu_id).animate({marginLeft:(10) + 'px'},'fast');
		$('#menu_'+menu_id).animate({marginLeft:(0) + 'px'},'fast');
		general_variable = setTimeout("animate_menu("+menu_id+")",1000);
	
		var area_height = $('#info_area').css('height');
		$('#main_cover').css('height',area_height);
		display_progress('main_cover','main_progress');
		
		center_item_vertical('main_progress',0);
		
	}
}

function close_window(a){
	$('#'+a).fadeOut('fast');
	$('#info_cover').fadeOut('fast');
}

function show_window(a,b){
	$('#info_cover').fadeIn('fast');
	$('#'+a).fadeIn('fast');
	center_item_vertical(a,b);
	center_item_horizontal(a,b);
}

function close_window_special(a,area_id){
	$('#'+a).fadeOut('fast');
	$('#'+area_id+'_cover').fadeOut('fast');
}

function show_window_special(a,b,area_id){
	$('#'+area_id+'_cover').fadeIn('fast');
	$('#'+a).fadeIn('fast');
	center_item_vertical(a,b);
	center_item_horizontal(a,b);
}

function display_infor(div_id,info){
	$('#progress_bar').fadeOut('fast');
	clearTimeout(general_variable);
	$('#'+div_id).hide();
	$('#'+div_id).html(info);
	$('#'+div_id).fadeIn('medium');
}

function change_window_size(window_id,new_width,new_height,centering){	
	if($('#'+window_id).css('width') != new_width+'px'){
		$('#'+window_id).css('width',new_width+'px');
		center_item_horizontal(window_id,0);
		center_item_horizontal(window_id,1);
		
	}
	
	if($('#'+window_id+'_holder').css('height') != new_height+'px'){
		$('#'+window_id+'_holder').css('height',new_height+'px');
		//center_item_vertical(window_id,0);
		center_item_vertical(window_id,1);
	}
	
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
	
	//if(document.getElementById(item_id).marginTop != smaller_vertical_position+'px'){
		$('#'+item_id).animate({marginTop:(smaller_vertical_position) + 'px'},'fast');
		
	//}
}

function center_item_horizontal(item_id,item_position_type){
	var bigger_width = window.outerWidth;
	
	
	
	var smaller_width = $('#'+item_id).css('width');
	smaller_width = smaller_width.replace('px','');
	
	var bigger_center = bigger_width / 2;
	var smaller_half = smaller_width / 2;
	
	
	var smaller_horizontal_position = bigger_center - smaller_half;
	
	if(item_position_type == null || item_position_type == 1){
		smaller_horizontal_position = smaller_horizontal_position + window.pageXOffset - 200;
		
	}
	
	smaller_horizontal_position +=300;
	
	//alert(smaller_horizontal_position);
	/*
	smaller_width = smaller_width.replace('px','');
	alert(smaller_width);
	var entry_times = bigger_width / smaller_width;
	var horizontal_center_position = (entry_times / 2) * smaller_width;
	
	var smaller_horizontal_position = horizontal_center_position - (smaller_width/2);
	
	if(item_position_type == null){
		smaller_horizontal_position = smaller_horizontal_position + window.pageXOffset + 10;
		
	}else{
		if(item_position_type == 0){
			//smaller_horizontal_position = smaller_horizontal_position + window.pageXOffset-10;
			
		}else if(item_position_type == 1){
			smaller_horizontal_position = smaller_horizontal_position + window.pageXOffset+10;
			
		}
	}*/
	
	//if($('#'+item_id).css('left') != smaller_horizontal_position+'px'){
		$('#'+item_id).animate({left:(smaller_horizontal_position) + 'px'},'fast');
	//}
}

function fetch_menu_items(db_query,db_table,table_column,item_id,return_div_id,clear_values,hide_field,continues_values,target_function,check_support,check_function){
	
	var data = new FormData();
	data.append('fetch_menu_items',1);
	data.append('db_query',db_query);
	data.append('db_table',db_table);
	data.append('table_column',table_column);
	data.append('item_id',item_id);
	data.append('return_div_id',return_div_id);
	data.append('continues_values',continues_values);
	data.append('company_id',$('#company_id').val());
	
	if(target_function == undefined){
		target_function = '';
	}
	
	if(check_support == undefined){
		check_support = 0;
	}
	
	if(check_function == undefined){
		check_function = '';
	}
	
	data.append('target_function',target_function);
	data.append('check_support',check_support);
	data.append('check_function',check_function);
	
	if(clear_values){		
		$('#selected_'+return_div_id).val(0);
		$('#active_'+return_div_id).html('Fetching...');
		$('#'+return_div_id+'_menu').html('');
	
		if(continues_values != ''){
			var total_menus = continues_values.split('|');

			for(var m =0;m<total_menus.length;m++){
				var fields = total_menus[m];
				var fields_array = fields.split('-');
				var next_return_div_id = fields_array[4];
				
				$('#selected_'+next_return_div_id).val(0);
				$('#active_'+next_return_div_id).html('Select item');
				$('#'+next_return_div_id+'_menu').html('');
			}
		}
	}
	
	if(hide_field){
		$('#'+return_div_id+'_holder').slideDown('fast');
		
		if(continues_values != ''){
			var total_menus = continues_values.split('|');

			for(var m =0;m<total_menus.length;m++){
				$('#'+next_return_div_id+'_holder').slideUp('fast');
			}
		}
	}
	
	send_default_general_xmlhttp(data);
}


function quick_search_items(db_connect,db_table,search_column,filter_column,filter_value,search_id){
	$('#'+search_id+'_resuts_holder').slideDown('fast');
	
	if($('#member_search_results').html() != 'No results were found'){
		$('#'+search_id+'_results').append('Searching...');
	
	}else{
		$('#'+search_id+'_results').html('Searching...');
		
	}

	var data = new FormData();
	data.append('quick_search_items',1);
	data.append('db_connect',db_connect);
	data.append('db_table',db_table);
	data.append('search_column',search_column);
	data.append('filter_column',filter_column);
	data.append('filter_value',filter_value);
	data.append('search_id',search_id);
	data.append('search_input',$('#'+search_id+'_input').val());
	
	send_default_general_xmlhttp(data);
	
}

function search_item_in_list(holder_id,item_id,delimiter){
	var items = $('#'+holder_id).val();
	
	var items_array = items.split(delimiter);
	
	var item_found = 0;
	for(var i=0;i<items_array.length;i++){
		if(items_array[i] == item_id){
			item_found = 1;
			
		}		
	}
	
	return item_found;
}

function check_if_mobile(){
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
		|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

	return isMobile;
}

function animate_home_image(){
	var home_images = $('#img_url').val();
	var home_images_array = home_images.split(',');
	
	$('#active_home_image').css('display','none');
	$('#active_home_image').attr('src',home_images_array[general_variable_0]);
	$('#active_home_image').fadeIn('fast');
	
	if(home_images_array.length > 1){
		var home_ann_interval = setTimeout('animate_home_image()',10000);
		
		if(general_variable_0 < (home_images_array.length - 1)){
			general_variable_0++;
			
		}else{
			general_variable_0 = 0;
			
		}
	}
}

function freeze_header(div_id){
	$('#frozen_header').attr('style',$('#'+div_id).attr('style')+';margin-left:220px;width:980px;position:absolute;color:#000;border-bottom:solid 1px #ccc;');
	$('#frozen_header').html($('#'+div_id).html());
}

function check_if_file_exists(url){
	var file = new Image();
	file.src = url;
	return file.height !=0;
}

function authenticateRecovery(){
	if($('#recovery_usermame').val() == 'Enter your login user name' || $('#recovery_usermame').val() == ''){
		$('#login_error_msg').slideDown('fast');
		$('#login_error_msg').html('You need to provide your user name');
		
	}else{
		var data = new FormData();
		data.append('authenticateRecovery',1);
		data.append('user_name',$('#recovery_usermame').val());
		data.append('table_name',$('#table_name').val());
		data.append('connection',$('#connection').val());
		
		send_default_general_xmlhttp(data);
		$('#check_recovery_button').html('Wait...');
	}
}

function process_password_reset(){	
	if($('#reset_code').val() == '' || $('#reset_code').val() == 'Enter code sent to your email'){
		$('#login_error_msg').html('Enter code send to your email');
		$('#login_error_msg').slideDown('fast');
		
	}else if($('#reset_password').val() == '' || $('#reset_password').val() == 'Enter your new password'){
		$('#login_error_msg').html('Enter new password');
		$('#login_error_msg').slideDown('fast');
		
	}else if($('#reset_password').val() != $('#reset_password2').val()){
		$('#login_error_msg').html('Password should match confirmation password');
		$('#login_error_msg').slideDown('fast');
		
	}else{
		var c = confirm('Are you sure you wish to proceed?');
		
		if(c){
			
			var data = new FormData();
			data.append('process_password_reset',1);
			data.append('this_user_id',$('#this_user_id').val());
			data.append('new_password',$('#reset_password').val());
			data.append('table_name',$('#table_name').val());
			data.append('connection',$('#connection').val());
			data.append('reset_code',$('#reset_code').val());
			
			var admin_request = 0
			if($('#admin_request').val() != undefined){
				var admin_request = $('#admin_request').val();
			}
			
			var reset_var = 0;
			if($('#reset_var') != undefined){
				reset_var = $('#reset_var').val();
			}
			
			data.append('reset_var',reset_var);
			data.append('admin_request',admin_request);
			
			send_default_general_xmlhttp(data);
			$('#password_reset_button').html('Wait...');
		}
	}
}