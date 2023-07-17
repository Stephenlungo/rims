var active_menu = 0;
var general_variable_3 = 0;
var general_variable_4 = '';
var general_variable_5 = '';
var general_variable_6 = '';
var detailed_list_timer = 0;


var colors = Array('#fad44c','#d7fa4c','#16b1a8','#1670b1','#9416b1','#b6cda8','#f7caf0','#ed806e','#70790b','#26790b','#69f2ed','#4e9fbc','#32bef1','#f6a2cb','#a8f6a2','#d1d4ce','#f6eef7','#fffb5c','#34342d','#30fbfd');

$(document).ready (function (){
	active_menu = $('#active_area_id').val();
	change_image();
});

if(window.XMLHttpRequest){
	general_xmlhttp = new XMLHttpRequest();
	chat_xmlhttp = new XMLHttpRequest();
	send_message_xmlhttp = new XMLHttpRequest();
	live_window_data_xmlhttp = new XMLHttpRequest();

}else{
	general_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	chat_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	send_message_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	live_window_data_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

live_window_data_xmlhttp.onreadystatechange = function(){
	if(live_window_data_xmlhttp.readyState == 4 && live_window_data_xmlhttp.status == 200){
		var response_text = live_window_data_xmlhttp.responseText;
		var response_array = response_text.split("~");
		
		if(response_array[0] == 'fetch_detailed_list'){
			if($('#last_entry_id').val() == 0){
				display_infor('detailed_list_data_holder',response_array[1]);
				
			}else{
				$('#detailed_list_data_holder').prepend(response_array[1]);
				
			}
		
			clearTimeout(detailed_list_timer);
			
			if($('#report_live_view').val() == 1){
				//var detailed_list_timer = setTimeout("fetch_detailed_list()",5000);
				
			}
			
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
		}
	}
}

chat_xmlhttp.onreadystatechange = function(){
	if(chat_xmlhttp.readyState == 4 && chat_xmlhttp.status == 200){
		var response_text = chat_xmlhttp.responseText;
		var response_array = response_text.split("~");
		
		if(response_array[0] == 'online_refresh'){
			$('#chat_users').html(response_array[1]);
			
			if($('#selected_budges').val() != ''){
				var active_budges = $('#selected_budges').val();
				var budges_array = active_budges.split(',');
			
			
				var chat_messages = response_array[3];
				var chat_messages_array = chat_messages.split('{|||}');
				
				
				
			
				for(var c=0;c<chat_messages_array.length;c++){
					var received_chat_messages = chat_messages_array[c];
					var received_chat_messages_array = received_chat_messages.split('{--}');
					var this_chat_message = received_chat_messages_array[0];					
					
					
					if($('#is_message_start_'+budges_array[c]).val() == 1){
						$('#message_holder_'+budges_array[c]).html(this_chat_message);
						$('#message_holder_'+budges_array[c]).scrollTop($('#message_holder_'+budges_array[c])[0].scrollHeight);
						$('#is_message_start_'+budges_array[c]).val(0);
						
					}else{
						if(this_chat_message != ''){
							$('#message_holder_'+budges_array[c]).append(this_chat_message);
							
							if($('#message_holder_'+budges_array[c]).scrollTop() > $('#message_holder_'+budges_array[c])[0].scrollHeight - 350){
								
								$('#message_holder_'+budges_array[c]).scrollTop($('#message_holder_'+budges_array[c])[0].scrollHeight);
								
							}else{
								
							//alert($('#message_holder_'+budges_array[c]).scrollTop()+' || '+$('#message_holder_'+budges_array[c])[0].scrollHeight);
							
								$('#new_messages_received_'+budges_array[c]).fadeIn('fast');
							
							}
						}
					}
					
					if(received_chat_messages_array[1] != undefined){
						if(received_chat_messages_array[1] == 0){
							$('#chat_budge_title_'+budges_array[c]).css('background-color','#999');
							
						}else{
							$('#chat_budge_title_'+budges_array[c]).css('background-color','#708b6c');
							
						}
					}
					
				}
				
				if(chat_messages_array.length > 0 && chat_messages_array[0] != '' && chat_messages_array[0] != '{--}1' && chat_messages_array[0] != '{--}0' && chat_messages_array[0] != undefined){
					var new_audio = new Audio('imgs/unsure.mp3');
					new_audio.play();
					
				}
			}
			
			var online_refresh_timer = setTimeout('online_refresh('+response_array[2]+')',2000);
			
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
		
		}
	}
}

send_message_xmlhttp.onreadystatechange = function(){
	if(send_message_xmlhttp.readyState == 4 && send_message_xmlhttp.status == 200){
		var response_text = send_message_xmlhttp.responseText;
		var response_array = response_text.split("~");
		
		if(response_array[0] == 'send_message'){
			//alert('Messsage sent');
			
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
		}
	}
}

general_xmlhttp.onreadystatechange = function(){
	if(general_xmlhttp.readyState == 4 && general_xmlhttp.status == 200){
		var response_text = general_xmlhttp.responseText;
		var response_array = response_text.split("~");
		
		if(response_array[0] == 'sign_in_user'){
			window.open($('#system_url').val(),'_self');
			
		}else if(response_array[0] == 'fetch_menu_page'){
			
			$('#page_information_holder').html(response_array[2]);
			
			if(active_menu != response_array[1]){
				$('#menu_progress_'+response_array[1]).fadeOut('fast');
				$('#menu_'+response_array[1]).css('background-color','#006bb3');
				$('#menu_'+active_menu).css('background-color','');
				active_menu = response_array[1];
			}
			
			$('#active_area_id').val(active_menu);
			
			clearTimeout(general_variable);
			hide_progress('main_cover','main_progress');
			$('#info_cover').fadeOut('fast');
			window.scrollTo(0,0);
			
		}else if(response_array[0] == 'session_expired'){	
			alert('Session has expired. You will be re-directed to sign in page...');
			window.open($('#url').val(),'_self');
			
		}else if(response_array[0] == 'fetch_script'){
			display_infor(response_array[1],response_array[2]); 
			
			
		}else if(response_array[0] == 'create_user'){
			if(response_array[1] == 1){
				$('#new_user_error_message').fadeIn('fast');
				$('#new_user_error_message').html('There is another user registered with provided user name. Try a different one');
				$('#new_user_name').css('border-color','red');
				$('#create_user_button').html('Create');
				
			}else{
				close_window('new_user');
				fetch_script('_codes/users.php','settings');
				tab_item_change(2);
			}
			
		}else if(response_array[0] == 'edit_user'){
			display_infor('edit_user_container',response_array[1]);
			
		}else if(response_array[0] == 'update_user' || response_array[0] == 'delete_user'){
			if(response_array[1] == 1){
				$('#edit_user_error_message').fadeIn('fast');
				$('#edit_user_error_message').html('There is another user registered with provided user name. Try a different one');
				$('#edit_user_name').css('border-color','red');
				$('#edit_user_button').html('Update');
				
			}else{
				close_window('edit_user');
				fetch_script('_codes/users.php','settings');
				tab_item_change(2);
			}

		
		}else if(response_array[0] == 'fetch_agent_type_list'){
			display_infor('agents',response_array[1]);
			
		}else if(response_array[0] == 'fetch_agent_type_list_code'){
			display_infor('general_list_holder',response_array[1]);
		
		}else if(response_array[0] == 'fetch_agent_list_code'){
			display_infor('agent_list_holder',response_array[1]);
			general_variable_5 = 0;
			
		}else if(response_array[0] == 'export_agent_list'){
			window.open($('#url').val()+'/'+response_array[1]);
			$('#export_button').html('Export');
			
		}else if(response_array[0] == 'fetch_user_list'){
			display_infor('user_list_holder',response_array[1]);
		
		}else if(response_array[0] == 'fetch_user_group_list'){
			display_infor('user_group_list_holder',response_array[1]);
				
			
		}else if(response_array[0] == 'fetch_entry_item'){
			display_infor('item_details_holder',response_array[1]);	

		}else if(response_array[0] == 'update_entry' || response_array[0] == 'validate_entry' || response_array[0] == 'delete_entry'){
			close_window('item_details');
			
			if(response_array[0] == 'delete_entry'){
				fetch_script('_codes/detailed_list.php?a=0','reporting');tab_item_change(0);
				
			}else{
				if(response_array[0] == 'validate_entry'){
					$('#entry_'+response_array[1]).css('color','black');
					
				}else if(response_array[0] == 'update_entry'){
					$('#entry_'+response_array[1]).css('color','brown');
				}
				
				display_infor('entry_'+response_array[1],response_array[2]);
				
				$('#editing_active').val(0);
				fetch_detailed_list();
			}
			
			
			}else if(response_array[0] == 'fetch_agent_details'){
			display_infor('agent_details_holder',response_array[1]);
			$('#tab_10').click();
			
		}else if(response_array[0] == 'check_phone_number'){
			$('#phone_number_error').slideDown('fast');
			
			if(response_array[1] == 1){
				$('#phone_number_error').html('One of the phone numbers is in use by '+response_array[2]);				
				$('#agent_phone').css('border-color','red');
				$('#phone_number_error').css('color','red');
				$('#phone_number_error_input').val(1);
				
			}else{
				$('#phone_number_error').html('Phone numbers okay ');
				$('#phone_number_error').css('color','green');
				$('#phone_number_error_input').val(0);
			}
			
			$('#phone_number_error').css('text-align','left');
			
		}else if(response_array[0] == 'check_nrc_number'){
			$('#nrc_number_error').slideDown('fast');
			
			if(response_array[1] == 1){
				$('#nrc_number_error').html('Another agent has the same NRC number. Details: '+response_array[2]);				
				$('#agent_nrc').css('border-color','red');
				$('#nrc_number_error').css('color','red');
				$('#nrc_number_error_input').val(1);
				
			}else{
				$('#nrc_number_error').html('NRC numbers okay ');
				$('#nrc_number_error').css('color','green');
				$('#nrc_number_error_input').val(0);
			}
			
			$('#nrc_number_error').css('text-align','left');
			
		}else if(response_array[0] == 'check_user_phone_number'){
			$('#phone_number_error').slideDown('fast');
			
			if(response_array[1] == 1){
				$('#phone_number_error').html('One of the phone numbers is in use by '+response_array[2]);				
				$('#user_phone').css('border-color','red');
				$('#phone_number_error').css('color','red');
				$('#phone_number_error_input').val(1);
				
			}else{
				$('#phone_number_error').html('Phone numbers okay ');
				$('#phone_number_error').css('color','green');
				$('#phone_number_error_input').val(0);
			}
			
			$('#phone_number_error').css('text-align','left');
			
			
			}else if(response_array[0] == 'fetch_agent_targets'  || response_array[0] == 'fetch_agent_changes'){
			display_infor('agent_targets',response_array[1]);
			
		}else if(response_array[0] == 'add_new_target'){
			fetch_targets(response_array[1])
			
		}else if(response_array[0] == 'fetch_targets'){
			display_infor('user_current_targets_data',response_array[1]);
			
		}else if(response_array[0] == 'delete_target'){
			fetch_targets(response_array[1]);
			
		}else if(response_array[0] == 'update_or_create_agent_type' || response_array[0] == 'enable_or_disable_agent_type'){
			close_window('item_details');
			fetch_agent_type_list();
			
		}else if(response_array[0] == 'update_or_create_agent'){
			if($('#payment_claims_active').val() == undefined){
				if(response_array[2] == 0){
					var container_div = '<div style="color:#999;width:100%;mi-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\';" onmouseout="this.style.backgroundColor=\'\';" title="Click to view more details" onclick="fetch_agent_details('+response_array[1]+')" id="user_'+response_array[1]+'">'+response_array[3]+'</div>';
					
					$('#agent_list_holder').prepend(container_div);
					
				}else{
					display_infor('agent_'+response_array[1],response_array[3]);
				}
			
			}else{
				search_claim_agents();
			}
			
			close_window('agent_details');
			
		}else if(response_array[0] == 'update_or_create_user'){
			if(response_array[2] == 0){
				var container_div = '<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\';" onmouseout="this.style.backgroundColor=\'\';" title="Click to edit or view details" onclick="fetch_user_details('+response_array[1]+');$(\'#user_filter_options\').slideUp(\'fast\');">'+response_array[3]+'</div>';
				
				$('#user_list_holder').prepend(container_div);
				
			}else{
				display_infor('user_'+response_array[1],response_array[3]);
			}
			
			close_window('item_details');
			
				
		}else if(response_array[0] == 'update_or_create_user_group' || response_array[0] == 'enable_user_group' || response_array[0] == 'disable_user_group'){
			fetch_user_group_list();
			
			close_window('item_details');
	
			
		}else if(response_array[0] == 'disable_agent'){
			$('#agent_'+response_array[1]).slideUp('fast');
			close_window('agent_details');
			
		}else if(response_array[0] == 'disable_user'){
			if($('#selected_status').val() == ''){
				$('#user_'+response_array[1]).css('color','#999');
				
			}else{
				$('#user_'+response_array[1]).slideUp('fast');
				
			}
			close_window('item_details');
			
		}else if(response_array[0] == 'enable_user'){
			if($('#selected_status').val() == ''){
				$('#user_'+response_array[1]).css('color','#000');
				
			}else{
				$('#user_'+response_array[1]).slideUp('fast');
			}
			
			close_window('item_details');
			
			
		}else if(response_array[0] == 'fetch_user_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_new_entry'){
			display_infor('item_details_holder',response_array[1]);
			
			
		}else if(response_array[0] == 'fetch_user_group_details'){
			display_infor('item_details_holder',response_array[1]);
		
			
		}else if(response_array[0] == 'search_new_entry_agent'){
			$('#new_entry_agent_search_results_'+response_array[1]).html(response_array[2]);
			$('#new_entry_agent_search_results_holder_'+response_array[1]).slideDown('fast');
			
			$('#new_entry_agent_search_results_'+response_array[1]).show('fast');
			
		}else if(response_array[0] == 'search_new_entry_site'){
			$('#new_entry_site_search_results_'+response_array[1]).html(response_array[2]);
			$('#new_entry_site_search_results_holder_'+response_array[1]).slideDown('fast');
			
			$('#new_entry_site_search_results_'+response_array[1]).show('fast');
			
		}else if(response_array[0] == 'fetch_new_entry_activity'){
			$('#entry_activity_menu_'+response_array[1]).html(response_array[2]);
			$('#active_entry_activity_'+response_array[1]).html('Select activity');
			
		}else if(response_array[0] == 'add_new_entries'){
			alert('Entries have been made. For errors, check the bin');
			close_window('item_details');
			
		}else if(response_array[0] == 'add_new_basic_entries'){
			alert('Entries were successfully made..');
			close_window('item_details');
			
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
			
		}else if(response_array[0] == 'save_profile_image'){
			if(response_array[1] == ''){
				$('#profile_image').html('<img src="'+$('#code_url').val()+'/imgs/male_user_icon.jpg" style="width:100%;height:100%;">');
			
			}else{
				$('#profile_image').html('<img src="'+$('#url').val()+'/imgs/'+response_array[1]+'" style="width:100%;height:100%;">');
			}			
			
		}else if(response_array[0] == 'apply_theme'){
			$('#apply_them_button').html('Apply Theme');
			
			if($('#current_them_ind').val() == '-1'){
				$('#img_string').val('');
				
			}else{
				$('#img_string').val(theme_image_array[$('#current_theme_ind').val()]);
			}
			$('#img_ind').val('');
			change_image();
			
		}else if(response_array[0] == 'fetch_item_details'){
			display_infor('item_details_holder',response_array[2]);
			
		}else if(response_array[0] == 'fetch_filter_options'){
			$('#filter_options').html(response_array[2]);
			
			eval(response_array[1]);
			
		}else if(response_array[0] == 'fetch_report_formular'){
			display_infor('report_formular_holder',response_array[1]);
			
			if($('#selected_report').val() == 0){
				$('#delete_report_button').slideUp('fast');
				$('#set_report_default_button').slideUp('fast');
				
			}else{
				$('#delete_report_button').slideDown('fast');
				$('#set_report_default_button').slideDown('fast');
			}

		}else if(response_array[0] == 'fetch_report_column_set'){			
			display_infor('report_column_holder',response_array[1]);
			$('#add_column_button').slideDown('fast');
			
		}else if(response_array[0] == 'save_dynamic_report'){
			display_infor('item_details_holder_1',response_array[1]);
			
		}else if(response_array[0] == 'process_save_dynamic_report'){
			close_window('item_details');
			$('#report_default_display_'+response_array[4]+'_'+response_array[5]).val(0);
			fetch_report(1,response_array[4],response_array[5]);
			
			if(response_array[1] == 0){
				var added_report = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#report_menu\').toggle(\'fast\');$(\'#active_report\').html($(this).html());$(\'#selected_report\').val('+response_array[1]+');$(\'#tab_3\').click();">'+response_array[3]+'</div>';
				
				$('#report_menu').append(added_report);
			}
			
		}else if(response_array[0] == 'fetch_report'){
			$('#report_formular_holder').hide();
			$('#report_settings_holder').hide();
			
			$('#dynamic_report_holder_'+response_array[1]+'_'+response_array[2]).slideDown('fast');
		
			display_infor('dynamic_report_holder_'+response_array[1]+'_'+response_array[2],response_array[3]);
			
		}else if(response_array[0] == 'delete_dynamic_report'){
			$('#report_button_0').click();			
			$('#report_button_'+response_array[1]).remove();
			
		}else if(response_array[0] == 'set_report_as_default'){
			$('#set_report_default_button').html('Set as default');
			
		}else if(response_array[0] == 'export_dynamic_report'){
			$('#dynamic_report_export_button_'+response_array[1]+'_'+response_array[2]).html('Export to excel');
			window.open($('#url').val()+'/'+response_array[3],'dynamic_export');
			
		}else if(response_array[0] == 'fetch_report_advanced_settings'){
			$('#report_settings_holder').html(response_array[1]);
			
			$('#dynamic_report_holder').hide();
			$('#dynamic_report_settings_holder').hide();
			$('#advanced_dynamic_report_settings_holder').slideDown('fast');
			
		}else if(response_array[0] == 'fetch_primary_column_type_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_advanced_report_column'){
			close_window('item_details');
			fetch_report_advanced_settings();
			
		}else if(response_array[0] == 'fetch_graph'){
			display_infor('report_graph_holder',response_array[1]);
			
			
		}else if(response_array[0] == 'save_bar_graph'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'process_save_graph'){
			close_window('item_details');
			
			fetch_saved_graph_list($('#selected_graph_report_'+response_array[2]+'_'+response_array[3]).val(),response_array[2],response_array[3]);
			
			
		}else if(response_array[0] == 'delete_dynamic_graph'){
			$('#graph_report_holder_'+response_array[1]+'_'+response_array[2]).html('<div style="width:100%;height:30px;float:left;line-height:30px;text-align:center;color:#777;font-size:2em;">Graph removed</div>');
			
		}else if(response_array[0] == 'fetch_cluster_user_groups'){
			$('#user_groups_holder').html(response_array[1]);
			
			refresh_user_roles();
			
		}else if(response_array[0] == 'fetch_dashboard'){
			display_infor('dashboard_area_holder',response_array[1]);
			
		
			//$('#dynamic_report_holder_'+response_array[1]+'_'+response_array[2]).hide();
			
		}else if(response_array[0] == 'fetch_dashboard_details' || response_array[0] == 'fetch_area_details'){
			$('#item_details_holder').html(response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_dashboard'){
			close_window('item_details');
			
			if(response_array[1] == 0){
				dashboard_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#dashboard_menu\').toggle(\'fast\');$(\'#active_dashboard\').html($(this).html());fetch_dashboard('+response_array[2]+');$(\'#selected_dashboard\').val('+response_array[2]+');$(\'#edit_dashboard_button\').slideDown(\'fast\');" id="dashboard_item_'+response_array[2]+'" >'+response_array[3]+'</div>';
				
				$('#dashboard_menu').append(dashboard_div);
			
			
				$('#selected_dashboard').val(response_array[2]);
				
				fetch_dashboard(response_array[2]);
				
				fetch_area_details(0);
				
			}else{
				$('#dashboard_item_'+response_array[1]).html(response_array[3]);
				fetch_dashboard(response_array[1]);
				
			}
			
			$('#active_dashboard').html(response_array[3]);
			
		}else if(response_array[0] == 'create_or_update_dashboard_area'){
			close_window('item_details');
			fetch_dashboard(response_array[1]);
			
		}else if(response_array[0] == 'fetch_report_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'delete_dashboard'){
			close_window('item_details');
		
			$('#'+response_array[1]).click();
			
			
		}else if(response_array[0] == 'fetch_wifi_details'){
			display_infor('item_details_holder',response_array[1]);	
			
		}else if(response_array[0] == 'update_or_create_wifi'){
			close_window('item_details');
			fetch_script('_codes/wifis.php?a=2','captive_wifi');
			
		}else if(response_array[0] == 'fetch_captive_client_access_log'){
			display_infor('captive_wifi',response_array[1]);
			
		}else if(response_array[0] == 'export_captive_client_access_log'){
			window.open($('#url').val()+'/'+response_array[1],'export_captive_client_access_log');
			
			$('#captive_clients_export_button').html('Export');
			
		}else if(response_array[0] == 'add_or_update_file'){
			display_infor('item_details_holder',response_array[1]);
			
			
		}else if(response_array[0] == 'process_add_or_update_file'){
			$('#save_upload_images').html('Finish');
			close_window('item_details');
			close_window('image_uploader');
			reset_image_upload();
			fetch_public_files((Number($('#directory_level').val())-1),$('#folder_id').val());
			
		}else if(response_array[0] == 'fetch_public_files'){
			display_infor('public_files_holder_0',response_array[1]);
			
		}else if(response_array[0] == 'delete_files'){
			fetch_public_files((Number($('#directory_level').val())-1),$('#folder_id').val());
			
			$('#delete_files_button').html('Delete');
			
		}else if(response_array[0] == 'paste_selected'){
			$('#paste_button').html('Paste');
			
			fetch_public_files((Number($('#directory_level').val())-1),$('#folder_id').val());
			
			$('#copy_queue').val('');
			
		}else if(response_array[0] == 'process_add_agent_file'){
			$('#close_uploader_button').click();
			$('#agent_file_holder').prepend(response_array[1]);
			$('#no_files_found').slideUp('fast');
			
		}else if(response_array[0] == 'remove_agent_file'){
			$('#agent_file_'+response_array[1]).remove();
			
		}else if(response_array[0] == 'request_validation' || response_array[0] == 'cancel_validation'){
			fetch_agent_details(response_array[1],1);
			
		}else if(response_array[0] == 'fetch_agent_validation_list_code'){
			display_infor('agent_list_holder',response_array[1]);
					
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
		}
		
	}
}

function send_chat_xmlhttp(a){
	chat_xmlhttp.open('POST','general_xmlhttp_processor.php',true);
	chat_xmlhttp.send(a);
}

function send_send_message_xmlhttp(a){
	send_message_xmlhttp.open('POST','general_xmlhttp_processor.php',true);
	send_message_xmlhttp.send(a);
}


function send_general_xmlhttp(a){
	general_xmlhttp.open('POST','general_xmlhttp_processor.php',true);
	general_xmlhttp.send(a);
}

function process_simultanious_xmlhttp(_variable,data){
	var xmlhttp_variable = eval(_variable);
	xmlhttp_variable.open('POST','general_xmlhttp_processor.php',true);
	xmlhttp_variable.send(data);
}

function fetch_item_details(file_identifier,attribute_values,width,height,title,loading_message,position){	
	var identifiers_array = attribute_values.split('-');
	
	var data = new FormData();
	data.append('fetch_item_details',1);
	data.append('file_identifier',file_identifier);
	data.append('attribute_values',attribute_values);
	
	for(var i=0;i<identifiers_array.length;i++){
		data.append('variable_'+i,identifiers_array[i]);
		
	}	
	
	send_general_xmlhttp(data);
	
	if(loading_message == ''){
		loading_message = 'Fetching data. Please wait...';
		
	}
	
	show_window('item_details',position);
	
	if(title != ''){
		$('#item_details_title').html(title);
	}
	
	if(height == ''){
		height = 450;
		
	} 
	
	if(width == ''){
		width = 400;
		
	}
	
	
	change_window_size('item_details',width,height,1);
	
	show_loading_progress('item_details_holder',loading_message);
}

function signin_user(user_id,user_date,user_type){
	//alert('hi');
	var data = new FormData();
	data.append('sign_in_user',1);
	data.append('user_id',user_id);
	data.append('user_date',user_date);
	data.append('user_type',user_type);
	data.append('connection',$('#connection').val());
	
	send_general_xmlhttp(data);
}

function create_user(){
	if($('#create_user_button').html() != 'Wait...'){
		if($('#new_user_fullnames').val() == 'Enter full names here' || $('#new_user_fullnames').val() == ''){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('Please enter the full names of this user');
			$('#new_user_fullnames').css('border-color','red');
				
		}else if($('#new_user_email').val() == 'Enter user email here' || $('#new_user_email').val() == ''){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('You need to provide the email for this user');
			$('#new_user_email').css('border-color','red');
			
		}else if($('#new_user_phone').val() == 'Enter user phone here' || $('#new_user_phone').val() == ''){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('Please enter the phone number for this user');
			$('#new_user_phone').css('border-color','red');
			
		}else if($('#new_user_name').val() == 'Enter user name here' || $('#new_user_name').val() == ''){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('Please enter user name this user');
			$('#new_user_name').css('border-color','red');
			
		}else if($('#new_user_password').val() == 'password' || $('#new_user_password').val() == ''){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('Please enter the password');
			$('#new_user_password').css('border-color','red');
			
		}else if($('#new_user_password2').val() != $('#new_user_password').val()){
			$('#new_user_error_message').fadeIn('fast');
			$('#new_user_error_message').html('Passwords do not match');
			$('#new_user_password2').css('border-color','red');
			
		}else{
			var data = new FormData();
			data.append('create_user',1);
			data.append('company_id',$('#company_id').val());
			data.append('fullnames',$('#new_user_fullnames').val());
			data.append('email',$('#new_user_email').val());
			data.append('phone',$('#new_user_phone').val());
			data.append('username',$('#new_user_name').val());
			data.append('password',$('#new_user_password').val());
			data.append('branch_id',$('#new_user_branch').val());
			data.append('roles',$('#new_user_role').val());
			data.append('region_id',$('#new_station_regions_id').val());
			data.append('province_id',$('#new_station_provinces_id').val());
			data.append('hub_id',$('#new_station_districts_id').val());
			data.append('site_id',$('#new_station_sites_id').val());
			data.append('unit_id',$('#new_user_unit_id').val());
			
			send_general_xmlhttp(data);
			
			$('#create_user_button').html('Wait...');
		}
	}
}

function fetch_user(user_date){
	var data = new FormData();
	data.append('fetch_user',1);
	data.append('company_id',$('#company_id').val());
	data.append('user_date',user_date);
	data.append('active_user_date',$('#user_date').val());
	
	send_general_xmlhttp(data);
	show_window('edit_user',1);
	
	show_loading_progress('edit_user_container','Fetching user data. Wait...');
	general_variable_3 = $('#new_user_container').html();
	$('#new_user_container').html('');
}

function update_user(user_date){
	if($('#edit_user_button').html() != 'Wait...'){
		if($('#edit_user_fullnames').val() == ''){
			$('#edit_user_error_message').fadeIn('fast');
			$('#edit_user_error_message').html('Please enter the full names of this user');
			$('#edit_user_fullnames').css('border-color','red');
				
		}else if($('#edit_user_email').val() == ''){
			$('#edit_user_error_message').fadeIn('fast');
			$('#edit_user_error_message').html('You need to provide the email for this user');
			$('#edit_user_email').css('border-color','red');
			
		}else if($('#edit_user_phone').val() == ''){
			$('#edit_user_error_message').fadeIn('fast');
			$('#edit_user_error_message').html('Please enter the phone number for this user');
			$('#edit_user_phone').css('border-color','red');
			
		}else if($('#edit_user_name').val() == ''){
			$('#edit_user_error_message').fadeIn('fast');
			$('#edit_user_error_message').html('Please enter user name this user');
			$('#edit_user_name').css('border-color','red');
			
		}else if($('#edit_user_password').val() == ''){
			$('#edit_user_error_message').fadeIn('fast');
			$('#edit_user_error_message').html('Please enter the password');
			$('#edit_user_password').css('border-color','red');
			
		}else{
			var data = new FormData();
			data.append('update_user',1);
			data.append('company_id',$('#company_id').val());
			data.append('user_date',user_date);
			data.append('fullnames',$('#edit_user_fullnames').val());
			data.append('email',$('#edit_user_email').val());
			data.append('phone',$('#edit_user_phone').val());
			data.append('username',$('#edit_user_name').val());
			data.append('password',$('#edit_user_password').val());
			data.append('branch_id',$('#edit_user_branch').val());
			data.append('roles',$('#edit_user_role').val());
			data.append('region_id',$('#new_station_regions_id').val());
			data.append('province_id',$('#new_station_provinces_id').val());
			data.append('hub_id',$('#new_station_districts_id').val());
			data.append('site_id',$('#new_station_sites_id').val());
			data.append('unit_id',$('#new_user_unit_id').val());
			
			send_general_xmlhttp(data);
			
			$('#edit_user_button').html('Wait...');
		}
	}
}

function online_refresh(user_id){
	var data = new FormData();
	data.append('online_refresh',1);
	data.append('user_id',user_id);
	data.append('chat_search',$('#user_chat_search').val());
	data.append('active_chats',$('#selected_budges').val());
	
	var active_budges = $('#selected_budges').val();
	var budges_array = active_budges.split(',');
	
	if($('#selected_budges').val() != ''){
		for(var i=0;i<budges_array.length;i++){
			data.append('is_message_start_'+budges_array[i],$('#is_message_start_'+budges_array[i]).val());
			
		}
	}
	
	send_chat_xmlhttp(data);
}

function send_message(to_user_id){
	var to_user_id = to_user_id.replace('_','');
	to_user_id = Number(to_user_id);
	
	var data = new FormData();
	data.append('send_message',1);
	data.append('to_user_id',to_user_id);
	data.append('message',$('#message_'+to_user_id).val());
	
	
	
	var message_div = '<div style="width:80%;margin:5px;height:auto;float:right;background-color:#cfc;padding:3px;border:solid 1px #efe;border-radius:5px;"><div style="width:100%;height:auto;float:left;">'+$('#message_'+to_user_id).val()+'</div><div style="width:100%;height:20px;float:left;color:#777">Just now</div></div>';
	
	$('#message_holder_'+to_user_id).append(message_div);
	$('#message_holder_'+to_user_id).scrollTop($('#message_holder_'+to_user_id)[0].scrollHeight);

	$('#message_'+to_user_id).val('');
	send_send_message_xmlhttp(data);
}

function add_chat(user_id,img_src,_name,_location){
	var item_exists = search_item_in_list('selected_budges',user_id,',');
	
	if(!item_exists){
		var start_items = $('#selected_budges').val();
		var start_items_array = start_items.split(',');
		
		if(start_items_array.length < 4){		
			var budge_code = $('#chat_budge_holder').html();
			
			budge_code = budge_code.replace(/_0/g,'_'+user_id);
			$('#active_budges').append(budge_code);
			
			$('#chat_budge_image_'+user_id).attr('src',img_src);
			
			$('#chat_budge_name_'+user_id).html(_name);
			$('#chat_budge_location_'+user_id).html(_location);
			
			add_to_selection(user_id,'selected_budges');
			
			var items = $('#selected_budges').val();
			var items_array = items.split(',');
			
			$('#active_budges').css('width',(items_array.length * 250)+(10 * items_array.length));
			
			$('#chat_'+user_id).fadeIn('fast');
			
		}else{
			alert('You can only chat with a maximum of four people at the same time. Close one chat to start a new one');
		}
	}else{
		alert('Chat already active');
		
	}
	
	$('#active_budges').fadeIn('fast');
}

function remove_budge(item_id){
	var item_id = item_id.replace('_','');
	item_id = Number(item_id);
	
	remove_from_selection(item_id,'selected_budges');
	
	var items = $('#selected_budges').val();
	var items_array = items.split(',');
		
	var new_length = items_array.length * 250 + (10 * items_array.length);
	
	$('#chat_'+item_id).remove();
	$('#active_budges').css('width',new_length);
	
	if($('#selected_budges').val() == ''){
		$('#active_budges').fadeOut('fast');
		
	}
}


function fetch_entry_item(item_id){
	$('#editing_active').val(1);
	
	var data = new FormData();
	data.append('fetch_entry_item',1);
	data.append('item_id',item_id);
	
	send_general_xmlhttp(data);
	
	$('#filter_options').slideUp('fast');
	$('#details_close_button').attr('onclick',"close_window('item_details');$('#editing_active').val(0);fetch_detailed_list();");
	show_window('item_details',1);
	show_loading_progress('item_details_holder','Fetching data. Please wait...');
}

function show_agent_entries(region_id,province_id,hub_id,site_id,agent_id){
	if(general_variable_5 == ''){
		general_variable_5 = $('#selected_region').val()+','+$('#selected_province').val()+','+$('#selected_hub').val()+','+$('#selected_site').val()+','+$('#selected_agent').val();
		
	}
	
	$('#selected_region').val(region_id);
	$('#province_region').val(province_id);
	$('#selected_hub').val(hub_id);
	$('#selected_site').val(site_id);
	$('#selected_agent').val(agent_id);
	
	$('#active_region').attr('onclick',"alert('Option disabled. Restore report view for all agents to enable this option')");
	$('#active_province').attr('onclick',"alert('Option disabled. Restore report view for all agents to enable this option')");
	$('#active_hub').attr('onclick',"alert('Option disabled. Restore report view for all agents to enable this option')");
	$('#active_site').attr('onclick',"alert('Option disabled. Restore report view for all agents to enable this option')");
	$('#active_agent').attr('onclick',"alert('Option disabled. Restore report view for all agents to enable this option')");
	
	close_window('item_details');
	
	$('#specific_agent_entries').slideDown('fast');
	
	$('#report_fetch_button').click();
}

function show_all_agent_entries(){
	var location_items_array = general_variable_5.split(',');
	
	$('#selected_region').val(location_items_array[0]);
	$('#province_region').val(location_items_array[1]);
	$('#selected_hub').val(location_items_array[2]);
	$('#selected_site').val(location_items_array[3]);
	$('#selected_agent').val(location_items_array[4]);
	
	$('#active_region').attr('onclick',"$('#region_menu').toggle('fast');");
	$('#active_province').attr('onclick',"$('#province_menu').toggle('fast');");
	$('#active_hub').attr('onclick',"$('#hub_menu').toggle('fast');");
	$('#active_site').attr('onclick',"$('#site_menu').toggle('fast');");
	$('#active_agent').attr('onclick',"$('#agent_menu').toggle('fast');");
	
	$('#specific_agent_entries').slideUp('fast');
	
	$('#report_fetch_button').click();
	
	general_variable_5 = '';
	
}

function update_entry(entry_id){
	if($('#update_entry_button').html() != 'Wait...'){
		if(isNaN($('#entry_value').val() || $('#entry_value').val() == '')){
			$('#edit_entry_error_message').slideDown('fast');
			$('#edit_entry_error_message').html('Value field cannot be empty and must be a number');
			$('#entry_value').css('boder-color','red');
		
		}else if($('#selected_entry_region').val() == 0 || $('#selected_entry_province').val() == 0 || $('#selected_entry_hub').val() == 0 || $('#selected_entry_site').val() == 0){
			$('#edit_entry_error_message').slideDown('fast');
			$('#edit_entry_error_message').html('You need to select all location options');
			
		}else{
			var data = new FormData();
			data.append('update_entry',1);
			data.append('entry_id',entry_id);
			data.append('value',$('#entry_value').val());
			data.append('region_id',$('#selected_entry_region').val());
			data.append('province_id',$('#selected_entry_province').val());
			data.append('hub_id',$('#selected_entry_hub').val());
			data.append('site_id',$('#selected_entry_site').val());
			data.append('entry_date',$('#entry_date').val());
			data.append('entry_hour',$('#selected_entry_hour').val());
			data.append('entry_min',$('#selected_entry_min').val());
			data.append('entry_sec',$('#selected_entry_sec').val());
			
			send_general_xmlhttp(data);
			
			$('#update_entry_button').html('Wait...');
			$('#validate_entry_button').html('Wait...');
			$('#delete_entry_button').html('Wait...');
		}
	}
}

function validate_entry(entry_id){
	if($('#validate_entry_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to validate this entry?');
		
		if(c){
			var data = new FormData();
			data.append('validate_entry',1);
			data.append('entry_id',entry_id);
			
			send_general_xmlhttp(data);
			
			$('#update_entry_button').html('Wait...');
			$('#validate_entry_button').html('Wait...');
			$('#delete_entry_button').html('Wait...');
		}
	}
}

function delete_entry(entry_id){
	if($('#delete_entry_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to delete this entry?');
		
		if(c){			
			var data = new FormData();
			data.append('delete_entry',1);
			data.append('entry_id',entry_id);
			
			send_general_xmlhttp(data);
			
			$('#update_entry_button').html('Wait...');
			$('#validate_entry_button').html('Wait...');
			$('#delete_entry_button').html('Wait...');
			
		}
	}
}

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
	
	//setTimeout("change_image()",120000);
	
}

function check_next_image_loaded(img){
	if(img.naturalWidth ===0){
		return false;
		
	}else{
		return true;
		
	}
}

function fetch_agent_type_list(){
	var data = new FormData();
	data.append('fetch_agent_type_list',1);

	send_general_xmlhttp(data);
	
}

function fetch_agent_type_list_code(){
	var data = new FormData();
	data.append('fetch_agent_type_list_code',1);
	data.append('branch_id',$('#selected_branch').val());
	data.append('status',$('#selected_status').val());
	
	send_general_xmlhttp(data);
	show_loading_progress('general_list_holder','Fetching data. Please wait...');
	
}

function fetch_agent_list(status_id){
	fetch_script('_codes/agents_list.php?a='+status_id,'agents');
	
}

function fetch_agent_validation_list(){
	fetch_script('_codes/agent_validation_list.php?a=0','agents');
	
}

function fetch_agent_list_code(area_id){
	var data = new FormData();
	data.append('fetch_agent_list_code',1);
	data.append('unit_id',$('#selected_unit').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	data.append('area_id',area_id);
	data.append('branch_id',$('#selected_branch').val());
	data.append('agent_type',$('#selected_validation').val());
	data.append('database_date',$('#selected_database').val());
	
	data.append('agent_search_key',$('#agent_search_key').val());
		
	send_general_xmlhttp(data);
	general_variable_5 = 1;
	
	show_loading_progress('agent_list_holder','Fetching data. Please wait...');
}

function export_agent_list(){
	var data = new FormData();
	data.append('export_agent_list',1);
	data.append('unit_id',$('#selected_unit').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	data.append('branch_id',$('#selected_branch').val());
	data.append('agent_type',$('#selected_validation').val());
	
	data.append('agent_search_key',$('#agent_search_key').val());
		
	send_general_xmlhttp(data);
	
	$('#export_button').html('Wait...');
	
	if(general_variable_5 == 1){
		$('#agent_list_holder').html('<div style="width:100%;text-align:center;margin-top:30px;height:20px;line-height:20px;font-size:1.1em">Sent to file export</div>');
		
		$('#agent_list_status_bar').html('');
	}
}

function fetch_agent_details(agent_id,area_id,agent_date){
	$('#agent_details_holder').css('height','450px');
	show_window('agent_details',1);
	$('#agent_details_title').html('Agent details');
	$('#agent_filter_options').slideUp('fast');
	
	show_loading_progress('agent_details_holder','Fetching data. Please wait...');
	var data = new FormData();
	data.append('fetch_agent_details',1);
	data.append('agent_id',agent_id);
	data.append('area_id',area_id);
	data.append('agent_date',agent_date);
	
	send_general_xmlhttp(data);
	
	$('#agent_details_close_button').attr('onclick',"close_window('agent_details');tab_item_change("+active_agent_tab+");");
	
}

function fetch_agent_entries(agent_id){
	if($('#last_entry_id').val() != undefined && $('#editing_active').val() == 0){
		var data = new FormData();
		data.append('fetch_detailed_list',1);
		data.append('unit_id',$('#selected_unit').val());
		data.append('branch_id',$('#branch_id').val());
		data.append('activity_id',0);
		data.append('region_id',$('#selected_region').val());
		data.append('province_id',$('#selected_province').val());
		data.append('hub_id',$('#selected_hub').val());
		data.append('site_id',$('#selected_site').val());
		data.append('agent_id',agent_id);
		data.append('validation','-1')
		data.append('date_from',$('#date_from').val());
		data.append('date_to',$('#date_to').val());
		data.append('last_entry_id',$('#last_entry_id').val());
		data.append('last_date',$('#last_date').val());
		
		process_simultanious_xmlhttp('live_window_data_xmlhttp',data);
		
		if($('#last_entry_id').val() == 0){
			show_loading_progress('detailed_list_data_holder','Fetching data. Please wait...');
			
		}
		if($('#selected_report').val() === '-1'){
			$('#detailed_list_holder').slideDown();
			
			$('#report_formular_holder').hide('fast');
			$('#report_settings_holder').hide('fast');
			$('#dynamic_report_holder').hide('fast');
		}
	}
}

function check_phone_number(agent_date){
	if($('#agent_phone').val() != '' && $('#agent_phone').val() != 'Enter phone number here'){
		var data = new FormData();
		data.append('check_phone_number',1);
		data.append('phone_numbers',$('#agent_phone').val());
		data.append('agent_date',agent_date);
		
		send_general_xmlhttp(data);
		
		$('#phone_number_error').slideDown('fast');
		$('#phone_number_error').html('Checking phone number');
		$('#phone_number_error').css('text-align','center');
		$('#phone_number_error').css('color','#000');
	}
}

function check_nrc_number(agent_date){
	if($('#agent_nrc').val() != '' && $('#agent_nrc').val() != 'Enter phone nrc here'){
		var data = new FormData();
		data.append('check_nrc_number',1);
		data.append('nrc_number',$('#agent_nrc').val());
		data.append('agent_date',agent_date);
		
		send_general_xmlhttp(data);
		
		$('#nrc_number_error').slideDown('fast');
		$('#nrc_number_error').html('Checking nrc number');
		$('#nrc_number_error').css('text-align','center');
		$('#nrc_number_error').css('color','#000');
	}
}

function check_user_phone_number(user_id){
	if($('#user_phone').val() != '' && $('#user_phone').val() != 'Enter phone number here'){
		var data = new FormData();
		data.append('check_user_phone_number',1);
		data.append('phone_numbers',$('#user_phone').val());
		data.append('user_id',user_id);
		
		send_general_xmlhttp(data);
		
		$('#phone_number_error').slideDown('fast');
		$('#phone_number_error').html('Checking phone number');
		$('#phone_number_error').css('text-align','center');
		$('#phone_number_error').css('color','#000');
	}
}

function fetch_agent_targets(agent_id){
	var data = new FormData();
	data.append('fetch_agent_targets',1);
	data.append('agent_id',agent_id);
	
	send_general_xmlhttp(data);
	show_loading_progress('agent_targets','Fetching data. Please wait...');
}


function fetch_agent_changes(agent_id){
	var data = new FormData();
	data.append('fetch_agent_changes',1);
	data.append('agent_id',agent_id);
	
	send_general_xmlhttp(data);
	show_loading_progress('agent_targets','Fetching data. Please wait...');
}

function add_new_target(agent_id){
	if($('#new_target_activity_number').val() == '' || $('#new_target_activity_number').val() == 'Number'){
		alert('Activity number cannot be empty');
	
	}else if($('#selected_target_unit').val() == 0 || $('#selected_target_activity').val() == 0){
		alert('You need to select a unit and activity');
		
	}else{
		var data = new FormData();
		data.append('add_new_target',1);
		data.append('agent_id',agent_id);
		data.append('unit_id',$('#selected_target_unit').val());
		data.append('activity_id',$('#selected_target_activity').val());
		data.append('target_day',$('#timer_day').val());
		data.append('target_month',$('#timer_month').val());
		data.append('target_year',$('#timer_year').val());
		data.append('target_hour',$('#timer_hour').val());
		data.append('target_min',$('#timer_min').val());
		data.append('_value',$('#new_target_activity_number').val());
		
		send_general_xmlhttp(data);
	}
}

function fetch_targets(agent_id){
	if($('#selected_target_activity').val() == 0){
		alert("You need to select a unit and an activity");
		
	}else{		
		show_loading_progress('user_current_targets_data','Fetching data. Please wait...');

		var data = new FormData();
		data.append('fetch_targets',1);
		data.append('agent_id',agent_id);
		data.append('unit_id',$('#selected_target_unit').val());
		data.append('activity_id',$('#selected_target_activity').val());
		
		send_general_xmlhttp(data);
	}
}

function delete_target(target_id,agent_id){
	var c = confirm('Are you sure you wish to delete this target for this agent?');
	
	if(c){
		var data = new FormData();
		data.append('delete_target',1);
		data.append('target_id',target_id);
		data.append('agent_id',agent_id);
		
		send_general_xmlhttp(data);
	}
}


function update_or_create_agent(agent_id,agent_date){
	if($('#update_or_create_agent_button').html() != 'Wait...'){
		if($('#agent_name').val() == '' || $('#agent_name').val() == 'Enter agent name here'){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter agent\'s names');
			$('#agent_name').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
		
		}else if($('#agent_phone').val() == '' || $('#agent_phone').val() == 'Enter phone number here'){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter phone number for agent');
			$('#agent_phone').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#nrc_number_error_input').val() == 1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Another agent is using provided NRC. Please use the other agent account');
			$('#agent_nrc').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#agent_nrc').val() == '' || $('#agent_nrc').val() == 'Enter NRC here'){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter NRC number for agent');
			$('#agent_nrc').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#agent_selected_sex').val() == 0){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Select gender');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#agent_username').val() == '' && $('#change_password_id').val() == 1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter username');
			$('#agent_username').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if(($('#agent_password').val() == '' || $('#agent_password').val() == 'password') && $('#change_password_id').val() == 1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter password');
			$('#agent_password').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
			
		}else if($('#agent_password').val() != $('#agent_password_2').val() && $('#change_password_id').val() == 1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Password does not match with confirmation password');
			$('#agent_password').css('border-color','red');
			$('#agent_password_2').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#agent_job_title').val() == '' || $('#agent_job_title').val() == 'Enter job title here'){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Enter job title for this agent');
			$('#agent_job_title').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_agent_unit').val() == -1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Select unit for this agent');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_agent_region').val() == -1){
			$('#new_agent_error_message').slideDown('fast');
			$('#new_agent_error_message').html('Select region for this agent');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
			
		}else{
			var missing_fields = '';
			if($('#agent_email').val() == 'Enter email address here' || $('#agent_email').val() == ''){
				missing_fields = 'Email address is not provided for this agent';
				
			}
			
			if($('#selected_agent_province').val() == 0){
				if(missing_fields == ''){
					missing_fields = 'Agent will be configured to work in all provinces';
					
				}else{
					missing_fields = missing_fields+' and agent will be configured to work in all provinces';
					
				}
				
			}else if($('#selected_agent_hub').val() == 0){
				if(missing_fields == ''){
					missing_fields = ' Agent will be configured to work in all hubs';
					
				}else{
					missing_fields = missing_fields+' and agent will be configured to work in all hubs';
					
				}
				
			}else if($('#selected_agent_site').val() == 0){
				if(missing_fields == ''){
					missing_fields = 'Agent will be configured to work in all sites';
					
				}else{
					missing_fields = missing_fields+' and agent will be configured to work in all sites';
					
				}
				
			}
			
			if(missing_fields == ''){
				var c = confirm('Are you sure you wish to proceed?');
				
			}else{
				var c = confirm(missing_fields+'. Are you sure you wish to proceed?');
			
			}
			
			if(c){
				var data = new FormData();				
				data.append('update_or_create_agent',1);
				data.append('agent_id',agent_id);
				data.append('agent_date',agent_date);
				data.append('agent_name',$('#agent_name').val());
				data.append('agent_phone',$('#agent_phone').val());
				data.append('agent_nrc',$('#agent_nrc').val());
				data.append('agent_sex',$('#agent_selected_sex').val());
				data.append('agent_email',$('#agent_email').val());
				data.append('agent_username',$('#agent_username').val());
				data.append('agent_password',$('#agent_password').val());
				data.append('agent_job_title',$('#agent_job_title').val());
				data.append('branch_id',$('#selected_agent_branch').val());
				data.append('agent_type_id',$('#selected_agent_type').val());
				data.append('unit_id',$('#selected_agent_unit').val());
				data.append('region_id',$('#selected_agent_region').val());
				data.append('province_id',$('#selected_agent_province').val());
				data.append('hub_id',$('#selected_agent_hub').val());
				data.append('mother_facility_id',$('#selected_agent_mother_facility').val());
				data.append('site_id',$('#selected_agent_site').val());
				data.append('_province_id',$('#selected_agent_loc_province').val());
				data.append('_district_id',$('#selected_agent_district').val());
				data.append('_constituency_id',$('#selected_agent_constituency').val());
				data.append('change_password_id',$('#change_password_id').val());
				data.append('permissions',$('#agent_system_access_input').val()+','+$('#agent_ussd_access_input').val()+','+$('#agent_sms_reporting_input').val()+','+$('#agent_training_access_input').val());
				
				send_general_xmlhttp(data);
				
				$('#update_or_create_agent_button').html('Wait...');
				
			}
		}
	}
}

function disable_agent(agent_id,agent_date){
	if($('#disable_agent_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this agent? Entries for this agent will not be affected');
		
		if(c){
			var data = new FormData();
			data.append('disable_agent',1);
			data.append('agent_id',agent_id);
			data.append('agent_date',agent_date);
			
			send_general_xmlhttp(data);

			$('#disable_agent_button').html('Wait...');
		}
	}
}

function enable_agent(agent_id){
	if($('#enable_agent_button').html() != 'Wait...'){
		if($('#phone_number_error_input').val() == 1){
			alert('Agent cannot be enabled until the phone number conflict is resolved');
			
		}else{
			var c = confirm('Are you sure you wish to enable this agent? Entries for this agent will not be affected');
		
			if(c){
				var data = new FormData();
				data.append('enable_agent',1);
				data.append('agent_id',agent_id);
				data.append('agent_phone',$('#agent_phone').val());
				
				send_general_xmlhttp(data);

				$('#enable_agent_button').html('Wait...');
			}
			
		}
	}	
}


function update_or_create_agent_type(agent_type_id){
	if($('#update_or_create_agent_type_button').html() != 'Wait...'){
		if($('#agent_type_title').val() == '' || $('#agent_type_title').val() == 'Enter title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter title of this agent group');
			$('#agent_type_title').css('border-color','red');
			
		}else if($('#agent_type_description').val() == '' || $('#agent_type_description').val() == 'Enter description here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter description');
			$('#agent_type_description').css('border-color','red');
			
		
		}else{
			var c = confirm('Are you sure you wish to proceed?');
				
			
			if(c){
				var data = new FormData();				
				data.append('update_or_create_agent_type',1);
				data.append('agent_type_id',agent_type_id);
				data.append('agent_type_title',$('#agent_type_title').val());
				data.append('agent_type_description',$('#agent_type_description').val());
				data.append('branch_id',$('#selected_agent_type_branch').val());
				
				send_general_xmlhttp(data);
				
				$('#update_or_create_agent_type_button').html('Wait...');
				
			}
		}
	}
}

function enable_or_disable_agent_type(agent_type_id,new_status){
	if($('#agent_type_status_change_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to update this item? Agents will not be affected');
		
		if(c){
			var data = new FormData();
			data.append('enable_or_disable_agent_type',1);
			data.append('agent_type_id',agent_type_id);
			data.append('new_status',new_status);
			
			send_general_xmlhttp(data);

			$('#agent_type_status_change_button').html('Wait...');
			$('#update_or_create_agent_type_button').html('Wait...');
		}
	}
}


function disable_user(user_id){
	if($('#disable_agent_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this user? No data will be affected');
		
		if(c){
			var data = new FormData();
			data.append('disable_user',1);
			data.append('user_id',user_id);
			
			send_general_xmlhttp(data);

			$('#disable_user_button').html('Wait...');
		}
	}
}

function enable_user(user_id){
	if($('#enable_user_button').html() != 'Wait...'){
		if($('#phone_number_error_input').val() == 1){
			alert('User cannot be enabled until the phone number conflict is resolved');
			
		}else{
			var c = confirm('Are you sure you wish to enable this user? No data will be affected');
		
			if(c){
				var data = new FormData();
				data.append('enable_user',1);
				data.append('user_id',user_id);
				data.append('user_phone',$('#user_phone').val());
				
				send_general_xmlhttp(data);

				$('#enable_user_button').html('Wait...');
			}
			
		}
	}	
}

function disable_user_group(user_group_id){
	if($('#disable_user_group_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this user group? No data will be affected');
		
		if(c){
			var data = new FormData();
			data.append('disable_user_group',1);
			data.append('user_group_id',user_group_id);
			
			send_general_xmlhttp(data);

			$('#disable_user_group_button').html('Wait...');
		}
	}
}

function enable_user_group(user_group_id){
	if($('#enable_user_group_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to enable this user group? No data will be affected');

		if(c){
			var data = new FormData();
			data.append('enable_user_group',1);
			data.append('user_group_id',user_group_id);

			send_general_xmlhttp(data);

			$('#enable_user_group_button').html('Wait...');
		}
	}
}

function fetch_user_list(){
	fetch_script('_codes/user_list.php','settings');
}

function fetch_user_group_list(){
	fetch_script('_codes/user_group_list.php','settings');
}

function fetch_user_list_code(){
	var data = new FormData();
	data.append('fetch_user_list_code',1);
	data.append('unit_id',$('#selected_unit').val());
	data.append('user_group_id',$('#selected_user_groups').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());	
	data.append('status',$('#selected_status').val());	
	data.append('agent_search_key',$('#agent_search_key').val());
	data.append('branch_id',$('#selected_branch').val());
		
	send_general_xmlhttp(data);
	
	show_loading_progress('user_list_holder','Fetching data. Please wait...');	
}

function fetch_user_group_list_code(){
	var data = new FormData();
	data.append('fetch_user_group_list_code',1);
	data.append('status',$('#selected_status').val());	
	data.append('search_key',$('#user_group_search_key').val());
	data.append('branch_id',$('#selected_branch').val());
		
	send_general_xmlhttp(data);
	
	show_loading_progress('user_group_list_holder','Fetching data. Please wait...');	
}

function fetch_user_details(user_id){
	var data = new FormData();
	data.append('fetch_user_details',1);
	data.append('user_id',user_id);

	send_general_xmlhttp(data);
	
	show_window('item_details',1);
	$('#item_details_title').html('User Account Details');
	$('#item_details_title_bar').css('background-color','brown');
	change_window_size('item_details',800,500,1);
	show_loading_progress('item_details_holder','Fetching data. Please wait...');	
}

function fetch_user_group_details(user_group_id){
	var data = new FormData();
	data.append('fetch_user_group_details',1);
	data.append('user_group_id',user_group_id);

	send_general_xmlhttp(data);
	
	show_window('item_details',1);
	$('#item_details_title').html('User Group Details');
	$('#item_details_title_bar').css('background-color','brown');
	change_window_size('item_details',400,400,1);
	show_loading_progress('item_details_holder','Fetching data. Please wait...');	
}

function update_or_create_user(user_id){
	if($('#update_or_create_agent_button').html() != 'Wait...'){
		if($('#user_name').val() == '' || $('#user_name').val() == 'Enter names for this user here'){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter names for this user');
			$('#user_name').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
		
		}else if($('#user_phone').val() == '' || $('#user_phone').val() == 'Enter phone number here'){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter phone number for user');
			$('#user_phone').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#phone_number_error_input').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('One of the phone numbers provided is being used by another user. Please resolve this to proceed');
			$('#user_phone').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#user_nrc').val() == '' || $('#user_nrc').val() == 'Enter NRC here'){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter NRC number for user');
			$('#user_nrc').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#user_selected_sex').val() == 0){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select gender');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#user_username').val() == '' && $('#change_password_id').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter username');
			$('#user_username').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#username_passed').val() == 0 && $('#change_password_id').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Username must meet complexity requirements');
			$('#user_username').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#user_password').val() == '' && $('#change_password_id').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter password');
			$('#user_password').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#password_passed').val() == 0 && $('#change_password_id').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Password must meet password complexity requirements');
			$('#user_password').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);			
			
		}else if($('#user_password').val() != $('#user_password_2').val() && $('#change_password_id').val() == 1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Password does not match with confirmation password');
			$('#user_password').css('border-color','red');
			$('#user_password_2').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#user_job_title').val() == '' || $('#user_job_title').val() == 'Enter job title here'){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Enter job title for this user');
			$('#user_job_title').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_user_cluster').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select a cluster for this user from the cluster menu');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_user_unit').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select unit for this user');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_user_region').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select region for this user from the regions menu');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
			
		}else if($('#selected_supervisor').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select a supervisor for this user from the supervisors menu');
			
		}else if($('#selected_department').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select a department for this user from the departments menu');
			
		}else if($('#selected_division').val() == -1){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('Select a division for this user from the divisions menu');
			
		}else if($('#pipat_main_access_input').val() == 0 && $('#pipat_claims_access_input').val() == 0 && $('#pipat_bills_access_input').val() == 0 && $('#pipat_training_access_input').val() == 0 && $('#pipat_logistice_access_input').val() == 0){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('You need to allow this user access to at-least one PIPAT system');
			
		}else{
			var missing_fields = '';
			if($('#agent_email').val() == 'Enter email address here' || $('#user_email').val() == ''){
				missing_fields = 'Email address is not provided for this user';
				
			}
			
			if($('#selected_user_province').val() == 0){
				if(missing_fields == ''){
					missing_fields = 'User will be configured to work in all provinces';
					
				}else{
					missing_fields = missing_fields+' and user will be configured to work in all provinces';
					
				}
				
			}else if($('#selected_user_hub').val() == 0){
				if(missing_fields == ''){
					missing_fields = ' User will be configured to work in all hubs';
					
				}else{
					missing_fields = missing_fields+' and user will be configured to work in all hubs';
					
				}
				
			}else if($('#selected_user_site').val() == 0){
				if(missing_fields == ''){
					missing_fields = 'User will be configured to work in all sites';
					
				}else{
					missing_fields = missing_fields+' and user will be configured to work in all sites';
					
				}
				
			}
			
			if(missing_fields == ''){
				var c = confirm('Are you sure you wish to proceed?');
				
			}else{
				var c = confirm(missing_fields+'. Are you sure you wish to proceed?');
				
			}
			
			if(c){
				var data = new FormData();				
				data.append('update_or_create_user',1);
				data.append('user_id',user_id);
				data.append('user_name',$('#user_name').val());
				data.append('user_phone',$('#user_phone').val());
				data.append('user_nrc',$('#user_nrc').val());
				data.append('user_sex',$('#user_selected_sex').val());
				data.append('user_email',$('#user_email').val());
				data.append('user_username',$('#user_username').val());
				data.append('user_password',$('#user_password').val());
				data.append('user_job_title',$('#user_job_title').val());
				data.append('cluster_id',$('#selected_user_cluster').val());
				data.append('user_group_ids',$('#selected_group_ids').val());
				data.append('unit_id',$('#selected_user_unit').val());
				data.append('region_id',$('#selected_user_region').val());
				data.append('province_id',$('#selected_user_province').val());
				data.append('hub_id',$('#selected_user_hub').val());
				data.append('site_id',$('#selected_user_site').val());
				data.append('supervisor_id',$('#selected_supervisor').val());
				data.append('department_id',$('#selected_department').val());
				data.append('division_id',$('#selected_division').val());
				data.append('division_supervisor',$('#selected_division_supervisor').val());
				data.append('change_password_id',$('#change_password_id').val());
				data.append('permissions',$('#pipat_main_access_input').val()+','+$('#pipat_main_data_creation_input').val()+','+$('#pipat_main_agent_creation_input').val()+','+$('#pipat_main_facility_creation_input').val()+','+$('#pipat_main_user_creation_input').val()+','+$('#pipat_main_report_view_input').val()+','+$('#pipat_main_prep_client_creation_input').val()+','+$('#pipat_main_prep_admin_input').val()+','+$('#pipat_main_super_input').val()+','+$('#pipat_claims_access_input').val()+','+$('#pipat_claims_type_input').val()+','+$('#pipt_claims_notifications_input').val()+','+$('#pipat_bills_access_input').val()+','+$('#pipat_bills_type_input').val()+','+$('#pipat_bills_notification_input').val()+','+$('#pipat_training_access_input').val()+','+$('#pipat_training_admin_input').val()+','+$('#pipat_logistice_access_input').val()+','+$('#pipat_logistics_admin_input').val()+','+$('#prep_key_generation_input').val()+','+$('#change_finance_processing_input').val());
				
				send_general_xmlhttp(data);
				
				$('#update_or_create_user_button').html('Wait...');
				
			}
		}
	}
}


function update_or_create_user_group(user_group_id){
	if($('#update_or_create_user_group_button').html() != 'Wait...'){
		if($('#user_group_name').val() == '' || $('#user_group_name').val() == 'Enter group name here'){
			$('#new_error_message').slideDown('fast');
			$('#new_error_message').html('You need to enter the name of this group');
			$('#user_group_name').css('border-color','red');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
		
		}else if($('#selected_user_cluster').val() == -1){
			$('#new_error_message').slideDown('fast');
			$('#new_error_message').html('Select a cluster for this user group from the cluster menu');
			
			$('#item_details_holder').scrollTop($('#item_details_holder')[0].scrollHeight);
		
		}else if($('#selected_supervisor').val() == -1){
			$('#new_error_message').slideDown('fast');
			$('#new_error_message').html('Select a supervisor for this user group from the supervisors menu');
			
			
		}else if($('#pipat_main_access_input').val() == 0 && $('#pipat_claims_access_input').val() == 0 && $('#pipat_bills_access_input').val() == 0 && $('#pipat_training_access_input').val() == 0 && $('#pipat_logistice_access_input').val() == 0){
			$('#new_user_error_message').slideDown('fast');
			$('#new_user_error_message').html('You need to allow this user group access to at-least one PIPAT system');
			
		}else{
			var missing_fields = '';
			var c = confirm('Are you sure you wish to proceed?');

			if(c){
				var data = new FormData();				
				data.append('update_or_create_user_group',1);
				data.append('user_group_id',user_group_id);
				data.append('user_group_name',$('#user_group_name').val());
				data.append('cluster_id',$('#selected_user_cluster').val());
				data.append('supervisor_date',$('#selected_supervisor').val());
				data.append('group_details',$('#group_details').val());
				data.append('permissions',$('#pipat_main_access_input').val()+','+$('#pipat_main_data_creation_input').val()+','+$('#pipat_main_agent_creation_input').val()+','+$('#pipat_main_facility_creation_input').val()+','+$('#pipat_main_user_creation_input').val()+','+$('#pipat_main_report_view_input').val()+','+$('#pipat_main_prep_client_creation_input').val()+','+$('#pipat_main_prep_admin_input').val()+','+$('#pipat_main_super_input').val()+','+$('#pipat_claims_access_input').val()+','+$('#pipat_claims_type_input').val()+','+$('#pipt_claims_notifications_input').val()+','+$('#pipat_bills_access_input').val()+','+$('#pipat_bills_type_input').val()+','+$('#pipat_bills_notification_input').val()+','+$('#pipat_training_access_input').val()+','+$('#pipat_training_admin_input').val()+','+$('#pipat_logistice_access_input').val()+','+$('#pipat_logistics_admin_input').val()+','+$('#prep_key_generation_input').val());
				
				send_general_xmlhttp(data);
				
				$('#update_or_create_user_group_button').html('Wait...');
				
			}
		}
	}
}

function create_new_entry(){
	var data = new FormData();
	data.append('create_new_entry',1);	
	send_general_xmlhttp(data);
	
	show_window('item_details',1);
	
	change_window_size('item_details',400,500,1);
	
	show_loading_progress('item_details_holder','Preparing. Please wait...');
	
	
}

function add_more_new_basic_etries(){
	var added_fields = Number($('#total_basic_entries').val());
	
	var new_field = $('#basic_entry_0').html();
	new_field = new_field.replace(/_0/g,"_"+added_fields);
	new_field = new_field.replace('search_new_entry_agent(0)',"search_new_entry_agent("+added_fields+")");
	new_field = new_field.replace('search_new_entry_site(0)',"search_new_entry_site("+added_fields+")");
	
	new_field = new_field.replace('search_new_entry_agent(0)',"search_new_entry_agent("+added_fields+")");
	new_field = new_field.replace('search_new_entry_site(0)',"search_new_entry_site("+added_fields+")");
	
	$('#basic_entry_holder_'+(added_fields-1)).slideUp('fast');
	
	
	
	new_field = '<div style="width:100%;height:auto;float:left;margin-bottom:15px;"  id="basic_entry_'+added_fields+'">'+new_field+'</div>';
	
	$('#basic_entry_container').append(new_field);

	$('#basic_entry_day_'+added_fields).val($('#basic_entry_day_'+(added_fields - 1)).val());
	$('#basic_entry_month_'+added_fields).val($('#basic_entry_month_'+(added_fields - 1)).val());
	$('#basic_entry_year_'+added_fields).val($('#basic_entry_year_'+(added_fields - 1)).val());
	$('#basic_entry_hour_'+added_fields).val($('#basic_entry_hour_'+(added_fields - 1)).val());
	$('#basic_entry_min_'+added_fields).val($('#basic_entry_min_'+(added_fields - 1)).val());
	$('#new_entry_site_'+added_fields).val($('#new_entry_site_'+(added_fields - 1)).val());
	$('#active_entry_site_'+added_fields).html($('#active_entry_site_'+(added_fields - 1)).html());
	$('#new_entry_agent_'+added_fields).val($('#new_entry_agent_'+(added_fields - 1)).val());
	$('#new_entry_site_required_'+added_fields).val($('#new_entry_site_required_'+(added_fields - 1)).val());
	$('#active_entry_agent_'+added_fields).html($('#active_entry_agent_'+(added_fields - 1)).html());
	$('#entry_agent_site_'+added_fields).css('display',$('#entry_agent_site_'+(added_fields - 1)).css('display'));
	
	$('#basic_entry_holder_'+added_fields).slideDown('fast');
	
	if($('#ignore_entry_0').val() == 1){
		$('#tick_button_'+(added_fields)).click();
		
	}

	added_fields++;
	$('#entry_title_'+(added_fields - 1)).html('Entry '+added_fields);
	
	$('#total_basic_entries').val(added_fields);
}

function search_new_entry_agent(item_ind){
	var data = new FormData();
	data.append('search_new_entry_agent',1);
	data.append('search_key',$('#search_agent_key_'+item_ind).val());
	data.append('item_ind',item_ind);
	data.append('branch_id',$('#branch_id').val());
	
	$('#new_entry_agent_search_results_'+item_ind).html('Searching for agents. Please wait...');
	$('#new_entry_agent_search_results_holder_'+item_ind).fadeIn('fast');
	
	send_general_xmlhttp(data);
}

function search_new_entry_site(item_ind){
	var data = new FormData();
	data.append('search_new_entry_site',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('search_key',$('#search_site_key_'+item_ind).val());
	data.append('item_ind',item_ind);
	
	$('#new_entry_site_search_results_'+item_ind).html('Searching for sites. Please wait...');
	$('#new_entry_site_search_results_holder_'+item_ind).fadeIn('fast');
	
	send_general_xmlhttp(data);
	
}

function search_new_entry_site(item_ind){
	var data = new FormData();
	data.append('search_new_entry_site',1);
	data.append('search_key',$('#search_site_key_'+item_ind).val());
	data.append('item_ind',item_ind);
	
	$('#new_entry_site_search_results_'+item_ind).html('Searching for sites. Please wait...');
	$('#new_entry_site_search_results_holder_'+item_ind).fadeIn('fast');
	
	send_general_xmlhttp(data);
	
}

function fetch_new_entry_activity(item_ind,unit_id){
	item_ind = item_ind.replace('_','');
	
	//alert(item_ind);
	var data = new FormData();
	data.append('fetch_new_entry_activity',1);
	data.append('company_id',$('#active_company_id').val());
	data.append('unit_id',unit_id);
	data.append('item_ind',item_ind);
	
	$('#new_entry_activities_'+item_ind).slideDown('fast');
	$('#active_entry_activity_'+item_ind).html('Fetching unit activities...');
	
	$('#entry_activity_menu_'+item_ind).html('');
	
	send_general_xmlhttp(data);
	
}

function add_new_entries(){
	//if($('#finish_entries_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('add_new_entries',1);
		data.append('total_entries',$('#total_entries').val());
		
		var total_entries = $('#total_entries').val();
		
		for(var e=0;e<total_entries;e++){
			data.append('entry_phone_'+e,$('#entry_phone_number_'+e).val());
			data.append('entry_day_'+e,$('#entry_day_'+e).val());
			data.append('entry_month_'+e,$('#entry_month_'+e).val());
			data.append('entry_year_'+e,$('#entry_year_'+e).val());
			data.append('entry_hour_'+e,$('#entry_hour_'+e).val());
			data.append('entry_min_'+e,$('#entry_min_'+e).val());
			data.append('entry_message_'+e,$('#entry_message_'+e).val());
		}
		
		send_general_xmlhttp(data);
		
		$('#finish_entries_button').html('Wait...');
		
	//}
}


function add_new_basic_entries(){
	if($('#finish_basic_entries_button').html() != 'Wait...'){
		
		
		var total_entries = $('#total_basic_entries').val();
		
		var error = 0;
		for(var e=0;e<total_entries;e++){
			if($('#ignore_entry_'+e).val() == 0){
				if($('#new_entry_agent_'+e).val() == 0){
					$('#basic_entry_error_message').slideDown('fast');
					$('#basic_entry_error_message').html('Please search and pick an agent for entry '+(e+1));
					
					error = 1;
				
				}else if($('#new_entry_site_required_'+e).val() == 1 && $('#new_entry_site_'+e).val() == 0){					
					$('#basic_entry_error_message').slideDown('fast');
					$('#basic_entry_error_message').html('Selected agent is set to report in multiple sites. Please search and pick a site for entry '+(e+1));
					
					error = 1;
					
				}else if($('#new_entry_unit_'+e).val() == 0){
					$('#basic_entry_error_message').slideDown('fast');
					$('#basic_entry_error_message').html('Select unit for entry '+(e+1));
					
					error = 1;
					
				}else if($('#new_entry_activity_'+e).val() == 0){
					$('#basic_entry_error_message').slideDown('fast');
					$('#basic_entry_error_message').html('Select activity for entry '+(e+1));
					
					error = 1;
					
				}else if($('#intervention_number_'+e).val() == 'Enter activity number here' || $('#intervention_number_'+e).val() == ''){
					$('#basic_entry_error_message').slideDown('fast');
					$('#basic_entry_error_message').html('Enter number for entry '+(e+1));
					
					error = 1;
					
				}
			}
			
			if(error){
				break;
			}
		}
					
		if(!error){
			var data = new FormData();
			data.append('add_new_basic_entries',1);
			data.append('total_entries',$('#total_basic_entries').val());	
			for(var e=0;e<total_entries;e++){
				data.append('entry_agent_'+e,$('#new_entry_agent_'+e).val());
				data.append('entry_day_'+e,$('#basic_entry_day_'+e).val());
				data.append('entry_month_'+e,$('#basic_entry_month_'+e).val());
				data.append('entry_year_'+e,$('#basic_entry_year_'+e).val());
				data.append('entry_hour_'+e,$('#basic_entry_hour_'+e).val());
				data.append('entry_min_'+e,$('#basic_entry_min_'+e).val());
				data.append('unit_'+e,$('#new_entry_unit_'+e).val());
				data.append('site_required_'+e,$('#new_entry_site_required_'+e).val());
				data.append('site_'+e,$('#new_entry_site_'+e).val());
				data.append('ignore_entry_'+e,$('#ignore_entry_'+e).val());
				
				data.append('activity_'+e,$('#new_entry_activity_'+e).val());
				data.append('number_'+e,$('#intervention_number_'+e).val());
			}
			
			send_general_xmlhttp(data);
		
			$('#finish_basic_entries_button').html('Wait...');
		}	
	}
}

function fetch_filter_options(filter_name,function_name,waiting_div){
	var data = new FormData();
	data.append('fetch_filter_options',1);
	data.append('filter_name',filter_name);
	data.append('function_name',function_name);
	
	send_general_xmlhttp(data);
	
	$('#filter_options').html('<div style="width:100%;height:30px;float:left;line-height:30px;margin-top:20px;text-align:center;">Preparing filter options. Wait...</div>');
	
	show_loading_progress(waiting_div,'Preparing. Please wait...');
	
	$('#settings_title').attr("onclick","$('#filter_options').slideToggle('fast')");
	
}

function save_profile_image(){
	var data = new FormData();
	data.append('save_profile_image',1);
	data.append('uploaded_file',$('#uploaded_files').val());
	send_general_xmlhttp(data);
	
	show_loading_progress('profile_image','Updating image. Wait...');
	close_window('image_uploader');
	
}

function apply_theme(){
	var data = new FormData();	
	data.append('apply_theme',1);
	data.append('current_theme_ind',$('#current_theme_ind').val());
	
	send_general_xmlhttp(data);
	
	$('#apply_them_button').html('Wait...');
}

function fetch_report_formular(){
	$('#report_live_view').val(0);
	$('#detailed_list_holder').slideUp();
	$('#report_formular_holder').slideDown('fast');
	$('#report_settings_holder').slideUp('fast');
	$('#dynamic_report_holder').slideUp('fast');
	
	if($('#report_formular_holder').html() == ''){
		
		var data = new FormData();
		data.append('fetch_report_formular',1);
		data.append('report_id',$('#selected_report').val());
		
		show_loading_progress('report_formular_holder','Fetching formular. Wait...');
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
	}
}

function fetch_report_settings(){
	$('#selected_report').val(0);
	$('#report_live_view').val(0);
	$('#detailed_list_holder').slideUp();
	$('#dynamic_report_holder').slideUp('fast');
	$('#report_formular_holder').slideUp('fast');
	$('#report_settings_holder').slideDown('fast');
	fetch_report_advanced_settings();
	show_loading_progress('report_settings_holder','Fetching formular. Wait...');
	change_window_size('item_details',400,450,1);
}

/*function fetch_report_settings(){
	if($('#dynamic_report_settings_holder').html() == ''){
		var data = new FormData();
		
		data.append('fetch_report_settings',1);
		data.append('report_id',$('#selected_report').val());
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#dynamic_report_holder').hide();
		$('#advanced_dynamic_report_settings_holder').hide();
		$('#dynamic_report_settings_holder').slideDown('fast');
		
		show_loading_progress('dynamic_report_settings_holder','Reading settings. Wait...');
		
	}else{
		$('#dynamic_report_holder').hide();
		$('#advanced_dynamic_report_settings_holder').hide();
		$('#dynamic_report_settings_holder').slideDown('fast');
		
	}
	
	tab_item_change(3);active_agent_tab=3;
}*/

function fetch_report_details(dashboard_id,dashboard_area_id){
	var report_id = $('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val();
	show_window('item_details',1);
	
	change_window_size('item_details',900,500,1);
	
	var data = new FormData();
	data.append('fetch_report_details',1);
	data.append('report_id',report_id);
	data.append('module_id',$('#module_id').val());
	data.append('dashboard_id',dashboard_id);
	data.append('area_id',dashboard_area_id);
	process_simultanious_xmlhttp('general_xmlhttp',data);
	
	$('#item_details_title').html('Custom Report Builder');
	
	show_loading_progress('item_details_holder','Preparing. One moment please.');
}

function fetch_report(reading_type,dashboard_id,dashboard_area_id){
	//alert(reading_type);
	if((!reading_type || $('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val() == 0) && ($('#report_formular_holder_'+dashboard_id+'_'+dashboard_area_id).html() == '' || $('#selected_report_primary_column_'+dashboard_id+'_'+dashboard_area_id).val() == 0)){
		fetch_report_settings();
		
	}else{
		var data = new FormData();
		data.append('fetch_report',1);
		data.append('report_id',$('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val());
		data.append('reading_type',reading_type);
		
		if(!reading_type){
			var total_columns = Number($('#total_report_columns_'+dashboard_id+'_'+dashboard_area_id).val());
			
			var rule_string = '';
			for(var c =0;c<total_columns;c++){
				if($('#column_'+c+'_active_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
					if(rule_string == ''){
						rule_string = $('#selected_column_'+c+'_'+dashboard_id+'_'+dashboard_area_id).val()+']'+$('#selected_column_disaggregation_'+c+'_'+dashboard_id+'_'+dashboard_area_id).val()+']'+$('#column_width_input_'+c+'_'+dashboard_area+'_'+dashboard_area_id).val();
						
					}else{
						rule_string = rule_string+'|'+$('#selected_column_'+c+'_'+dashboard_area+'_'+dashboard_area_id).val()+']'+$('#selected_column_disaggregation_'+c+'_'+dashboard_id+'_'+dashboard_area_id).val()+']'+$('#column_width_input_'+c+'_'+dashboard_id+'_'+dashboard_area_id).val();
						
					}
				}				
			}
			
			data.append('rule_string',rule_string);
			data.append('primary_column_type',$('#selected_report_primary_column_'+dashboard_id+'_'+dashboard_area_id).val());
		}
		
		data.append('module_id',$('#module_id').val());
		data.append('dashboard_id',dashboard_id);
		data.append('dashboard_area_id',dashboard_area_id);
		data.append('search_key',$('#payment_claim_search_key').val());
		data.append('date_from',$('#date_from').val());
		data.append('date_to',$('#date_to').val());
		data.append('region_id',$('#selected_region').val());
		data.append('province_id',$('#selected_province').val());
		data.append('hub_id',$('#selected_hub').val());
		data.append('site_id',$('#selected_id').val());
		data.append('user_id',$('#selected_user').val());
		
		if($('#filter_script').val() == undefined){
			data.append('filter_script','');
			
		}else{
			data.append('filter_script',$('#filter_script').val());
			
		}
		
		if($('#module_id').val() == 3){
			data.append('client_status',$('#client_active_status').val());
			data.append('agent_id',$('#selected_agent').val());
			
			data.append('search_key',$('#client_search_key').val());
			data.append('account_status',$('#account_status').val());
			data.append('status_category',$('#selected_status_category').val());
			data.append('client_active_status',$('#client_active_status').val());
			
		}		
		
		process_simultanious_xmlhttp('area_xmlhttp_'+dashboard_id+'_'+dashboard_area_id,data);
		$('#dynamic_report_holder_'+dashboard_id+'_'+dashboard_area_id).html('<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:30px;"><img src="imgs/loader1.gif"></div>');
		$('#report_formular_holder_'+dashboard_id+'_'+dashboard_area_id).hide();
		$('#report_settings_holder_'+dashboard_id+'_'+dashboard_area_id).hide();
		$('#dynamic_report_holder_'+dashboard_id+'_'+dashboard_area_id).slideDown('fast');
		tab_item_change(0);active_agent_tab=0;
		
		$('#report_settings_button_'+dashboard_id+'_'+dashboard_area_id).slideDown('fast');
		
		$('#report_graph_holder_'+dashboard_id+'_'+dashboard_area_id).slideUp('fast');
		
		//$('#dynamic_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('width','975px');
		
	}
}

function fetch_report_column_set(set_id){	
	var data = new FormData();
	data.append('fetch_report_column_set',1);
	data.append('set_id',set_id);
	//data.append('report_id',$('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val());
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	show_loading_progress('report_column_holder','Fetching column set');
	//$('#add_column_button').slideUp('fast');
	
	
}

function add_dynamic_report_column(){
	var total_columns = Number($('#total_report_columns').val());
	
	var data_div = '<div style="width:100%;float:left;height:auto;" id="column_'+total_columns+'_holder">'+$('#column_0_holder').html()+'</div>';
	
	data_div = data_div.replace('','');
	
	data_div = data_div.replace(/_0/g,'_'+total_columns);
	
	total_columns++;
	$('#total_report_columns').val(total_columns);
	data_div = data_div.replace('Column 1','Column '+(total_columns));
	
	data_div = data_div.replace(/0,/g,(total_columns-1)+',');
	
	
	$('#column_holder').append(data_div);
	
	check_data_dependancy_conlumns(total_columns-1,0);
}

function check_data_dependancy_columns(column_ind,_type){
	//alert(column_ind);
	
	if(!_type){
		var last_column = column_ind;
		
	}else{
		var last_column = Number($('#total_report_columns').val());
	}
	
	var data_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_'+column_ind+'_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_'+column_ind+'\').html($(this).html());$(\'#selected_column_data_dependancy_'+column_ind+'\').val(\'i\');"><i>Independent</i></div>';
	
	if((!_type && $('#selected_column_'+column_ind+'_value_type').val() != 0 && $('#selected_column_'+column_ind+'_value_type').val() != 3) || _type==1){
		for(var c=0;c<last_column;c++){
			if($('#selected_column_'+c+'_value_type').val() != 0 && $('#selected_column_'+c+'_value_type').val() != 3 && $('#column_'+c+'_active').val() == 1){
				var temp_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#column_data_dependancy_'+column_ind+'_menu\').toggle(\'fast\');$(\'#active_column_data_dependancy_'+column_ind+'\').html($(this).html());$(\'#selected_column_data_dependancy_'+column_ind+'\').val('+c+');">'+$('#active_column_'+c).html()+'</div>';
				if(data_div == ''){
					data_div = temp_div;
				
				}else{
					data_div = data_div+temp_div;			
				}
			}
		}
	}
	
	$('#selected_column_data_dependancy_'+column_ind).val('i');
	$('#active_column_data_dependancy_'+column_ind).html('<i>Independent</i>');
	$('#column_data_dependancy_'+column_ind+'_menu').html(data_div);
}

/*function save_dynamic_report(report_id){
	var total_columns = Number($('#total_report_columns').val());
	
	var error_found = 0;
	var error_column_string = '';
	for(var c =0;c<total_columns;c++){
		if($('#selected_column_'+c).val() ==0){
			error_found = 1;
			
			if(error_column_string == ''){
				error_column_string = 'Column '+(c+1);
				
			}else{
				error_column_string = error_column_string+', '+'Column '+(c+1);
				
			}
		}		
	}
	

	if(error_found){
		$('#error_message').html('You need to select column value for the following columns: '+error_column_string);		
		$('#error_message').slideDown('fast');
		
	}else{
		show_window('item_details_1');
		change_window_size('item_details_1',400,450,1);
		
		var data = new FormData();
		data.append('save_dynamic_report',1);
		data.append('report_id',report_id);
		process_simultanious_xmlhttp('general_xmlhttp',data);
		//change_window_size('item_details_holder','',300);
		
		$('#item_details_title_bar_1').css('background-color','#e89af6');
		$('#item_details_title_1').html('Save dynamic report');	
		show_loading_progress('item_details_holder_1','Preparing options. Wait...');
	
	}
}*/

function save_dynamic_report(report_id){
	//if($('#save_report_button').html() != 'Wait...'){
		if($('#selected_report_primary_column').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to select a primary column first');
			
		}else{
			var error = 0;
			
			var columns_added = Number($('#total_report_columns').val());
			for(var c =0;c<columns_added;c++){
				if($('#selected_column_'+c).val() == 0 && $('#column_'+c+'_active').val() == 1){
					error = 1;
				}
			}

			if(error){
				$('#error_message').slideDown('fast');
				$('#error_message').html('Select columns for all added fields');
				
			}else{
				$('#error_message').slideUp('fast');
				
				if($('#dashboard_id').val() == 0){				
					show_window('item_details_1');
					$('#item_details_title_bar_1').css('background-color','#e89af6');
					
					$('#item_details_title_1').html('Save Custom Report');

					var data = new FormData();
					data.append('save_dynamic_report',1);
					data.append('report_id',report_id);
					
					process_simultanious_xmlhttp('general_xmlhttp',data);
					
					show_loading_progress('item_details_holder_1','Preparing options. One moment...');
					
				}else{
					process_save_dynamic_report();
					
				}				
			}
		}
	//}
}

function process_save_dynamic_report(){
	if($('#save_report_button').html() != 'Wait...'){
		if($('#report_title').val() == '' || $('#repor_title').val() == 'Enter report title here'){
			$('#save_report_error_message').slideDown('fast');
			$('#save_report_error_message').html('Please enter your report title');
			$('#report_title').css('border-color','red');
		
		}else{			
			error = 0;
			var data = new FormData();
			data.append('process_save_dynamic_report',1);
			data.append('report_id',$('#custom_report_id').val());
			data.append('primary_column_type',$('#selected_report_primary_column').val());
			data.append('title',$('#report_title').val());
			data.append('module_id',$('#module_id').val());
			data.append('dashboard_id',$('#dashboard_id').val());
			data.append('dashboard_area_id',$('#dashboard_area_id').val());
			data.append('default_display',$('#selected_default_display').val());
			
			if($('#dashboard_id').val() == 0){
				data.append('branch_id',$('#selected_user_cluster').val());
				data.append('accessibility_type_id',$('#selected_accessibility_type').val());
				data.append('group_ids',$('#selected_group_ids').val());
				data.append('unit_ids',$('#selected_dashboard_unit').val());
				data.append('user_ids',$('#selected_user').val());
				
				data.append('region_id',$('#selected_dashboard_region').val());
				data.append('province_id',$('#selected_dashboard_province').val());
				data.append('hub_id',$('#selected_dashboard_hub').val());
				data.append('site_id',$('#selected_dashboard_site').val());
				data.append('set_default',$('#selected_set_default').val());
			}
			
			var columns_string = '';
			var columns_added = Number($('#total_report_columns').val());
			for(var c =0;c<columns_added;c++){
				if($('#column_'+c+'_active').val() == 1){
					if(columns_string == ''){
						columns_string = $('#selected_column_'+c).val()+']'+$('#selected_column_disaggregation_'+c).val()+']'+$('#column_width_input_'+c).val()+']'+$('#selected_column_data_dependancy_'+c).val();
						
					}else{
						columns_string = columns_string+'|'+$('#selected_column_'+c).val()+']'+$('#selected_column_disaggregation_'+c).val()+']'+$('#column_width_input_'+c).val()+']'+$('#selected_column_data_dependancy_'+c).val();				
					}				
				}				
			}
			
			if($('#module_id').val() == 3){
				var selected_additional_columns = $('#selected_additional_columns').val();
				var selected_additional_columns_array = selected_additional_columns.split(',');
				
				var additional_column_string = '';
				if($('#selected_additional_columns').val() != ''){
					for(var ac=0;ac<selected_additional_columns_array.length;ac++){
						if(additional_column_string == ''){
							additional_column_string = selected_additional_columns_array[ac]+'-'+$('#selected_output_processing_'+selected_additional_columns_array[ac]).val()+'-'+$('#selected_column_data_dependancy_'+selected_additional_columns_array[ac]).val();
							
						}else{
							additional_column_string = additional_column_string+'|'+selected_additional_columns_array[ac]+'-'+$('#selected_output_processing_'+selected_additional_columns_array[ac]).val()+'-'+$('#selected_column_data_dependancy_'+selected_additional_columns_array[ac]).val();
							
						}
					}
				}
				
				if(additional_column_string == '' && columns_string == ''){
					$('#error_message').slideDown('fast');
					$('#error_message').html('You have not added any columns to your report');
					error = 1;
					
				}else{
					if(additional_column_string == ''){
						data.append('rule_string',columns_string);
						
					}else{
						data.append('rule_string',columns_string+','+additional_column_string);
					}		
				}
			}else{
				data.append('rule_string',columns_string);				
			}
			
			if(!error){
				var c = confirm('Are you sure you wish to proceed saving this report? Please note that graphs attached to this report will be deleted');
			
				if(c){
					process_simultanious_xmlhttp('general_xmlhttp',data);
					$('#save_report_button').html('Wait...');
				}
			}
		}
	}
}

function delete_dynamic_report(){
	if($('#delete_report_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to delete this report?');
		
		if(c){
			var data = new FormData();
			data.append('delete_dynamic_report',1);
			data.append('report_id',$('#selected_report').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#delete_report_button').html('Wait...');
		}
	}
}

function set_report_as_default(){
	if($('#set_report_default_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to set this report as default?');
		
		if(c){
		var data = new FormData();
			data.append('set_report_as_default',1);
			data.append('report_id',$('#selected_report').val());
			
			process_simultanious_xmlhttp('general_xmlhttp',data);
			
			$('#set_report_default_button').html('Wait...');
		}		
	}
}

function export_dynamic_report(dashboard_id,dashboard_area_id){
	if($('#dynamic_report_export_button_'+dashboard_id+'_'+dashboard_area_id).html() != 'Wait...'){
		var data = new FormData();
		data.append('export_dynamic_report',1);
		data.append('dashboard_id',dashboard_id);
		data.append('dashboard_area_id',dashboard_area_id);
		data.append('column_string',$('#column_string_'+dashboard_id+'_'+dashboard_area_id).val());
		data.append('row_string',$('#row_string_'+dashboard_id+'_'+dashboard_area_id).val());
		data.append('column_formating_string',$('#column_formating_string_'+dashboard_id+'_'+dashboard_area_id).val());
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
		
		$('#dynamic_report_export_button_'+dashboard_id+'_'+dashboard_area_id).html('Wait...');
	
	}
}

function fetch_report_advanced_settings(){
	var data = new FormData();
	data.append('fetch_report_advanced_settings',1);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
}

function fetch_primary_column_type_details(primary_column_id){
	var data = new FormData();
	data.append('fetch_primary_column_type_details',1);
	data.append('primary_column_id',primary_column_id);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	show_window('item_details',1);
	show_loading_progress('item_details_holder','Prepairing. Wait...');
	change_window_size('item_details',750,600,1);
	
	$('#item_details_title').html('Advanced report settings');
	
}

function delete_advanced_report_column(primary_column_type_id){
	if($('#delete_primary_column_button').html() != 'Wait...'){	
		var c = confirm('Are you sure you wish to delete this item? Please note that this action cannot be undone');
		
		if(c){
			var data = new FormData();
			data.append('delete_advanced_report_column',1);
			data.append('primary_column_type_id',primary_column_type_id);
			
			process_simultanious_xmlhttp('general_xmlhttp',data);
			
			$('#delete_primary_column_button').html('Wait...');		
		}
	}
}

function add_disagregation_item_definition(column_id){
	column_id = column_id.replace('_','');
	
	
	var total_columns = Number($('#total_disagregation_item_definitions_'+column_id).val());
	
	var data_div = $('#disagregation_item_definitions_holder_c').html();
	data_div = data_div.replace(/_c/g,'_'+column_id);
	data_div = data_div.replace(/_z/g,'_'+total_columns);

	$('#disagregation_item_definitions_holder_'+column_id).append(data_div);
	total_columns++;
	$('#total_disagregation_item_definitions_'+column_id).val(total_columns);
}


function add_advanced_report_column(){	
	var total_columns = Number($('#total_columns').val());
	
	var data_div = $('#default_advanced_report_columns').html();
	data_div = data_div.replace(/_c/g,'_'+total_columns);
	data_div = data_div.replace(/_y/g,'_0');
	
	data_div = data_div.replace('Column 1','Column '+(total_columns+1));
	
	$('#advanced_report_columns').append(data_div);
	
	//$('#column_operator_'+(total_columns-1)).slideDown('fast');
	
	total_columns++;
	$('#total_columns').val(total_columns);
}

function add_advanced_report_operator(column_ind){
	column_ind = column_ind.replace('_','');
	
	var total_operators = Number($('#total_operators_'+column_ind).val());
	
	var data_div = '<div style="width:100%;height:auto;float:left;" id="column_data_'+column_ind+'_'+total_operators+'">'+$('#column_data_c_y').html()+'</div>';
	
	
	
	data_div = data_div.replace(/_c/g,'_'+column_ind);
	data_div = data_div.replace(/_y/g,'_'+total_operators);
	
	$('#column_data_holder_'+column_ind).append(data_div);
	
	$('#column_operator_'+column_ind+'_'+(total_operators-1)).slideDown('fast');
	
	total_operators++;
	
	$('#total_operators_'+column_ind).val(total_operators);
	
}

function create_or_update_advanced_report_column(primary_column_id){
	if($('#create_or_update_primary_column_button').html() != 'Wait...'){
		if($('#primary_column_type_title').val() == 'Enter text here'){
			$('#error_message').html('You need to provice primary column title');
			$('#error_message').slideDown('fast');
			$('#primary_column_type_title').css('border-color','red');
			
		}else if($('#reference_table').val() == 'Enter table name here'){
			$('#error_message').html('Enter a reference table');
			$('#error_message').slideDown('fast');
			$('#reference_table').css('border-color','red');
			
			
		}else{
			var total_columns = Number($('#total_columns').val());
			
			var error = 0;
			for(var c = 0;c<total_columns;c++){
				
				if($('#advanced_report_item_'+c+'_active').val() == 1){
					
					if($('#column_title_'+c).val() == 'Enter text here'){
						error = 1;
						$('#column_title_'+c).css('border-color','red');
						
					}
					
					var total_operators = Number($('#total_operators_'+c).val());
					
					for(var o = 0;o<total_operators;o++){
						if($('#advanced_report_operator_'+c+'_'+o+'_active').val() == 1){
							
							if($('#internal_table_item_'+c+'_'+o).val() == 'Enter text here' || $('#internal_table_item_'+c+'_'+o).val() == ''){
								error = 1;
								$('#internal_table_item_'+c+'_'+o).css('border-color','red');								
							}
							
							if($('#advanced_report_table_type_id_'+c+'_'+o).val() == 1 && ($('#external_table_'+c+'_'+o).val() == 'Enter text here' || $('#external_table_item_'+c+'_'+o).val() == 'Enter text here' || $('#external_value_item_'+c+'_'+o).val() == 'Enter text here')){
								
								error = 1;
								$('#external_table_'+c+'_'+o).css('border-color','red');
								$('#external_table_item_'+c+'_'+o).css('border-color','red');
								$('#external_value_item_'+c+'_'+o).css('border-color','red');								
							}
							
							if($('#advanced_report_table_type_id_'+c+'_'+o).val() == 1 && ($('#value_filter_id_'+c+'_'+o).val() != 0 && ($('#value_filter_'+c+'_'+o).val() == 'Enter text here' || $('#column_filter_'+c+'_'+o).val() == 'Enter text here'))){
								error = 1;
								$('#value_filter_'+c+'_'+o).css('border-color','red');	
								$('#column_filter_'+c+'_'+o).css('border-color','red');									
							}
							
							var total_translations = $('#total_translations_'+c+'_'+o).val();
							
							var translation_string = '';
							for(var ct=0;ct<total_translations;ct++){
								if($('#translation_'+c+'_'+o+'+'+ct).val() == 1){
									
									if(translation_string == ''){
										translation_string = $('#translation_value_'+c+'_'+o+'_'+ct).val()+'-'+$('#translation_'+c+'_'+o+'_'+ct).val();
										
									}else{
										translation_string += ','+$('#translation_value_'+c+'_'+o+'_'+ct).val()+'-'+$('#translation_'+c+'_'+o+'_'+ct).val();
										
									}								
								}
							}							
						}
					}
					
					if($('#value_disagregation_id_'+c).val() == 1 && $('#value_disagregation_column_'+c).val() == 'Enter text here'){
						error = 1;
						$('#value_disagregation_column_'+c).css('border-color','red');		
						
					}
					
					var total_disagregation_definitions = Number($('#total_disagregation_item_definitions_'+c).val());				
					for(var d =0;d<total_disagregation_definitions;d++){
						if($('#disagregation_item_definition_active_'+c+'_'+d).val() == 1){
							if($('#value_disagregation_id_'+c).val() == 1 && ($('#value_disagregation_'+c+'_'+d).val() == 'Enter text here' || $('#value_disagregation_definition_'+c+'_'+d).val() == 'Enter text here')){
								error = 1;
								$('#value_disagregation_'+c+'_'+d).css('border-color','red');
								$('#value_disagregation_definition_'+c+'_'+d).css('border-color','red');
							}
						}
					}
				}
			}

			if(error){
				$('#error_message').html('Provide data for fields highlighted in red');
				$('#error_message').slideDown('fast');
				
				
			}else{
				if(primary_column_id){
					var c = confirm('Are you sure you wish to update settings for this primary column type');
					
				}else{
					var c = 1;
					
				}
				
				
				if(c){				
					var data = new FormData();
					data.append('create_or_update_advanced_report_column',1);
					data.append('primary_column_type_id',primary_column_id);
					data.append('primary_column_title',$('#primary_column_type_title').val());
					data.append('reference_table',$('#reference_table').val());
					data.append('data_reference_column',$('#data_reference_column').val());
					data.append('query_type',$('#advanced_report_query_type_id').val());
					data.append('module_id',$('#advanced_report_query_module_id').val());
					
					var total_columns = Number($('#total_columns').val());
					
					data.append('total_columns',total_columns);
					var error = 0;
					for(var c = 0;c<total_columns;c++){
						data.append('column_id_'+c,$('#advanced_report_item_id_'+c).val());
						data.append('column_title_'+c,$('#column_title_'+c).val());
						data.append('column_active_'+c,$('#advanced_report_item_'+c+'_active').val());
						
						var total_operators = Number($('#total_operators_'+c).val());
						data.append('total_operators_'+c,total_operators);
						for(var o =0;o<total_operators;o++){
							data.append('operator_active_'+c+'_'+o,$('#advanced_report_operator_'+c+'_'+o+'_active').val());
							data.append('table_type_'+c+'_'+o,$('#advanced_report_table_type_id_'+c+'_'+o).val());
							data.append('internal_column_'+c+'_'+o,$('#internal_table_item_'+c+'_'+o).val());
							data.append('query_type_'+c+'_'+o,$('#advanced_report_query_type_id_'+c+'_'+o).val());
							data.append('external_table_'+c+'_'+o,$('#external_table_'+c+'_'+o).val());
							data.append('external_column_'+c+'_'+o,$('#external_table_item_'+c+'_'+o).val());
							data.append('external_value_column_'+c+'_'+o,$('#external_value_item_'+c+'_'+o).val());
							data.append('filter_type_'+c+'_'+o,$('#value_filter_id_'+c+'_'+o).val());
							data.append('value_filter_'+c+'_'+o,$('#value_filter_'+c+'_'+o).val());
							data.append('column_filter_'+c+'_'+o,$('#column_filter_'+c+'_'+o).val());
							data.append('output_processing_id_'+c+'_'+o,$('#output_processing_id_'+c+'_'+o).val());
							data.append('value_type_id_'+c+'_'+o,$('#value_type_id_'+c+'_'+o).val());
							data.append('operator_'+c+'_'+o,$('#operator_'+c+'_'+o).val());
							data.append('comment_type_'+c+'_'+o,$('#comment_type_id_'+c+'_'+o).val());
							data.append('comment_script_'+c+'_'+o,$('#comment_script_'+c+'_'+o).val());
							data.append('comment_source_table_type_'+c+'_'+o,$('#source_column_type_id_'+c+'_'+o).val());
							data.append('comment_query_type_'+c+'_'+o,$('#comment_advanced_report_query_type_id_'+c+'_'+o).val());
							data.append('comment_source_column_'+c+'_'+o,$('#source_table_item_'+c+'_'+o).val());
							data.append('comment_target_table_type_'+c+'_'+o,$('#target_table_type_id_'+c+'_'+o).val());
							data.append('comment_external_table_'+c+'_'+o,$('#comment_external_table_'+c+'_'+o).val());
							data.append('comment_external_column_'+c+'_'+o,$('#comment_external_table_item_'+c+'_'+o).val());
							data.append('comment_value_column_'+c+'_'+o,$('#comment_external_value_item_'+c+'_'+o).val());
							data.append('comment_value_filter_type_'+c+'_'+o,$('#comment_value_filter_id_'+c+'_'+o).val());
							data.append('comment_filter_column_'+c+'_'+o,$('#comment_column_filter_'+c+'_'+o).val());
							data.append('comment_value_filter_'+c+'_'+o,$('#comment_value_filter_'+c+'_'+o).val());
							data.append('comment_output_processing_'+c+'_'+o,$('#comment_output_processing_id_'+c+'_'+o).val());
							data.append('comment_value_type_'+c+'_'+o,$('#comment_value_type_id_'+c+'_'+o).val());
							
							data.append('value_translation_'+c+'_'+o,$('#value_translator_id_'+c+'_'+o).val());
							var total_translations = $('#total_translations_'+c+'_'+o).val();
							
							var translation_string = '';
							
							if($('#value_translator_id_'+c+'_'+o).val() == 1){
								for(var ct=0;ct<total_translations;ct++){
									if($('#translation_value_'+c+'_'+o+'_'+ct).val() != '' && $('#translation_'+c+'_'+o+'_'+ct).val() != ''){
										if(translation_string == ''){
											translation_string = $('#translation_value_'+c+'_'+o+'_'+ct).val()+'-'+$('#translation_'+c+'_'+o+'_'+ct).val();
											
										}else{
											translation_string = translation_string+','+$('#translation_value_'+c+'_'+o+'_'+ct).val()+'-'+$('#translation_'+c+'_'+o+'_'+ct).val();
											
										}								
									}
								}
							}

							data.append('translations_'+c+'_'+o,translation_string);							
							
						}
						
						data.append('value_disagregation_id_'+c,$('#value_disagregation_id_'+c).val());
						data.append('value_disagregation_column_'+c,$('#value_disagregation_column_'+c).val());
						
						var total_disagregation_definitions = Number($('#total_disagregation_item_definitions_'+c).val());
						data.append('total_disagregation_definitions_'+c,total_disagregation_definitions);						
						for(var d =0;d<total_disagregation_definitions;d++){
							
								data.append('disagregation_item_definition_active_'+c+'_'+d,$('#disagregation_item_definition_active_'+c+'_'+d).val());
								data.append('disagregation_definition_type_id_'+c+'_'+d,$('#disagregation_definition_type_id_'+c+'_'+d).val());
								data.append('value_disagregation_'+c+'_'+d,$('#value_disagregation_'+c+'_'+d).val());
								data.append('value_disagregation_definition_'+c+'_'+d,$('#value_disagregation_definition_'+c+'_'+d).val());
							
						}										
					}
					
					process_simultanious_xmlhttp('general_xmlhttp',data);
					
					$('#create_or_update_primary_column_button').html('Wait...');
				}
			}			
		}
	}
}

function fetch_graph(){
	var data = new FormData();
	data.append('fetch_graph',1);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
}


function fetch_graph_settings(graph_type_id,loading_style,dynamic_graph_id,dashboard_id,dashboard_area_id){
	
	if($('#this_graph_id_'+dashboard_id+'_'+dashboard_area_id).val() == undefined){
		//dynamic_graph_id = 0;
		
	}else{
		//dynamic_graph_id = $('#this_graph_id_'+dashboard_id+'_'+dashboard_area_id).val();
		
	}
	
	if(loading_style == 0){
		show_window('item_details_'+dashboard_id+'_'+dashboard_area_id);
		
	}else{
		$('#item_details_'+dashboard_id+'_'+dashboard_area_id).fadeOut('fast');
		
	}

	change_window_size('item_details',400,450,1);
	if(graph_type_id == $('#selected_graph_type_'+dashboard_id+'_'+dashboard_area_id).val()){
		display_infor('item_details_holder_'+dashboard_id+'_'+dashboard_area_id,general_variable_6);
	
	}else{
		var data = new FormData();
		data.append('fetch_graph_settings',1);
		data.append('graph_type_id',graph_type_id);
		data.append('dynamic_graph_id',dynamic_graph_id);
		data.append('loading_style',loading_style);
		data.append('dashboard_id',dashboard_id);
		data.append('dashboard_area_id',dashboard_area_id);
		
		$('#item_details_title_'+dashboard_id+'_'+dashboard_area_id).html('Graph Settings');
		process_simultanious_xmlhttp('area_xmlhttp_'+dashboard_id+'_'+dashboard_area_id,data);
		
		show_loading_progress('item_details_holder_'+dashboard_id+'_'+dashboard_area_id,'Reading settings. Wait...');
		
		
	}
}

function add_graph_columns(dashboard_id,dashboard_area_id){
	var total_data_columns = Number($('#total_data_columns_'+dashboard_id+'_'+dashboard_area_id).val());
	var data_div = '<div style="width:100%;height:auto;float:left;margin-bottom:10px;" id="data_column_'+dashboard_id+'_'+dashboard_area_id+'_0_holder">'+$('#data_column_'+dashboard_id+'_'+dashboard_area_id+'_0_holder').html()+'</div>';
	
	data_div = data_div.replace(/_0/g,'_'+total_data_columns);
	data_div = data_div.replace('Data Column 1','Data Column '+(total_data_columns+1));
	data_div = data_div.replace('Value Column 1','Value Column '+(total_data_columns+1));
	data_div = data_div.replace('Column 1','Column '+(total_data_columns+1));
	
	$('#data_columns_holder_'+dashboard_id+'_'+dashboard_area_id).append(data_div);
	
	$('#data_column_remove_button_'+dashboard_id+'_'+dashboard_area_id+'_'+total_data_columns).slideDown('fast');
	
	$('#active_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+total_data_columns).css('background-color',colors[total_data_columns]);
	$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+total_data_columns).val(colors[total_data_columns]);
	
	$('#data_column_content_holder_'+dashboard_id+'_'+dashboard_area_id+'_'+(total_data_columns-1)).slideUp('fast');
	$('#data_column_content_holder_'+dashboard_id+'_'+dashboard_area_id+'_'+(total_data_columns)).slideDown('fast');
	
	total_data_columns++;
	$('#total_data_columns_'+dashboard_id+'_'+dashboard_area_id).val(total_data_columns);
}

function round(value, decimals) {
  return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function create_graph(dashboard_id,dashboard_area_id,graph_type,labels,values,colors,border_color,data_set_lebel){
	labels = labels.split('-]');
	values = values.split('-]');
	colors = colors.split('-]');
	border_color = border_color.split('-]');
	
	var this_convas = '<canvas style="width:'+$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('width')+';height:'+$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('height')+';z-index:0;" id="report_graph_canvas_'+dashboard_id+'_'+dashboard_area_id+'"></canvas>';
	
	$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).html(this_convas);
	var ctx = document.getElementById('report_graph_canvas_'+dashboard_id+'_'+dashboard_area_id);
	var myChart = new Chart(ctx, {
		type: graph_type,
		data: {
			labels: labels,
			datasets: [{
				label: data_set_lebel,
				data: values,
				backgroundColor: colors,
				borderColor: border_color,
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero: true
					}
				}]
			},
			onClick:function(e){
				var activePoints = myChart.getElementsAtEvent(e);
				
				if(activePoints[0]!= undefined){
					var selectedIndex = activePoints[0]._index;
					fetch_graph_comment(dashboard_id,dashboard_area_id,selectedIndex);
				
				}
			}
		}
	});
	
	Chart.pluginService.register({
    afterDraw: function(chartInstance) {
        var ctx = chartInstance.chart.ctx;

        // render the value of the chart above the bar
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';

        chartInstance.data.datasets.forEach(function (dataset) {
            for (var i = 0; i < dataset.data.length; i++) {
                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                ctx.fillText(dataset.data[i], model.x, model.y - 2);
            }
        });
  }
});
}


function generate_bar_graph(graph_id,dashboard_id,dashboard_area_id){
	$('#selected_graph').val(graph_id);
	$('#selected_graph_type_'+dashboard_id+'_'+dashboard_area_id).val(graph_id);
	$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val($('#graph_size_value_'+dashboard_id+'_'+dashboard_area_id).val());
//	area_variable[dashboard_id][dashboard_area_id] = $('#item_details_holder_'+dashboard_id+'_'+dashboard_area_id).html();
	close_window('item_details_'+dashboard_id+'_'+dashboard_area_id);
	
	var total_data_columns = Number($('#total_data_columns_'+dashboard_id+'_'+dashboard_area_id).val());
	
	var area_width = $('#report_graph_holder_'+dashboard_id+'_'+dashboard_area_id).css('width');
	area_width = area_width.replace('px','');	
	area_width = Number(area_width)-80;
	
	
	var column_total = 0;
	for(var c =0;c<total_data_columns;c++){
		if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
			if(column_total < Number($('#report_view_column_max_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val())){
				column_total = Number($('#report_view_column_max_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val());
				
			}
		}
	}
	
	var total_rows = Number($('#total_rows_'+dashboard_id+'_'+dashboard_area_id).val());
	var total_active_bars = 0;
	for(var r =0;r<total_rows;r++){
		for(var c =0;c<total_data_columns;c++){
			if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
				total_active_bars++;
			}
			
		}		
	}
	
	var bar_width = (area_width/total_active_bars) - 5;	
	
	range = column_total+(column_total * 0.1);
	
	var bar_data = '';
	var graph_holder_div = '';
	var labels = '';
	var values = 'none';
	var graph_colors = '';
	var border_color = '';
	var data_set_lebel = '';
	var real_row_index = '';
	if($('#selected_graph_type_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
		var graph_holder_div = '<div style="margin-top:10px;min-width:99%;width:auto;height:auto;float:left;border-bottom:solid 1px #bbb;position:relative;" id="graph_holder_'+dashboard_id+'_'+dashboard_area_id+'">';
		
		if($('#selected_show_title').val() == 1){
			graph_holder_div = graph_holder_div+'<div style="width:100%;margin-left:110px;height:30px;float:left;margin-bottom:10px;line-height:30px;font-weight:bold;font-size:1.3em;">'+$('#graph_name_'+dashboard_id+'_'+dashboard_area_id).val()+'</div>';
			
		}
		
		
		if($('#selected_show_legend_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
			graph_holder_div = graph_holder_div+'<div style="margin-left:110px;width:90%;height:auto;float:left;">';
			for(var c =0;c<total_data_columns;c++){
				if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
					
					graph_holder_div = graph_holder_div+'<div style="width:20px;margin-right:5px;height:20px;float:left;background-color:'+$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+';margin-3px;"></div><div style="width:auto;float:left;height:20px;line-height:20px;margin-right:10px;">'+$('#active_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).html()+' ('+$('#report_view_column_total_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val()+')</div>';
					
				}
			}
			
			graph_holder_div = graph_holder_div+'</div>';
		
		}
		
		
		
		var measument_value = range/20;
		var this_measument = 0;
		var measument_height = (Number($('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()) / 20)
		
		if($('#selected_show_grid_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
			graph_holder_div = graph_holder_div+'<div style="width:100px;float:left;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;border-right:solid 1px #bbb;font-size:0.8em;font-weight:bold;">';
			
			for(var m=20;m>0;m--){			
				this_measument = m*measument_value;
				graph_holder_div = graph_holder_div+'<div style="width:92px;cursor:pointer;height:'+measument_height+'px;line-height:'+measument_height+'px;float:left;text-align:right;position:relative;" onmouseover="$(\'#row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'\').css(\'border-color\',\'#006bb3\');this.style.backgroundColor=\'#eee\'" onmouseout="$(\'#row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'\').css(\'border-color\',\'#eee\');this.style.backgroundColor=\'\'">'+round(this_measument,2)+'<div style="min-width:700px;height:1px;border-top:solid 1px #eee;position:absolute;margin-left:95px;bottom:10px;cursor:pointer;" id="row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'"></div></div>';
				
				
			}
			graph_holder_div = graph_holder_div+'</div>';
		}
		
		
		//alert(total_rows);
		for(var r =0;r<total_rows;r++){
			var this_bar = '<div style="width:auto;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;margin-right:4px;float:left;position:relative;">';
			
			var this_bar_data = '';
			
			for(var c =0;c<total_data_columns;c++){
				if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
					var column_value = $('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'_'+r).val();
					var row_title = $('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_data_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'_'+r).val();
					
					var column_title = $('#report_view_column_title_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val();
					
					if(column_value == undefined){
						alert('Row: '+r+' - '+c)
					}
					
					column_value = column_value.replace(/,/g,'');
					
					
				
					var bar_height = column_value / range * 100;
					//alert(bar_height);
					if(column_value == 0){
						//column_value = '';
						
					}
					var this_bar_color = $('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val();
					
					if($('#selected_overlay_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 0){
						var bar_position = 'relative';
						
						if(c==0){						
							var bar_label = '<div style="min-width:130px;width:auto;position:absolute;text-align:left;height:'+(bar_width*total_data_columns)+'px;line-height:'+(bar_width)+'px;bottom:'+(-1*(bar_width+5))+'px;transform: rotate(90deg);transform-origin:top left;left:'+bar_width+'px">'+row_title+'</div>';
							
							
							
							data_set_lebel = column_title;
							
						}else{
							bar_label = '';
							
						}
						
					}else{
						var bar_position = 'absolute';
						var bar_label = '';
						
					}
					
					if($('#selected_show_value_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
						var this_value = column_value;
						
					}else{
						var this_value = '';
						
					}
					
					this_bar_data = this_bar_data+'<div style="width:'+bar_width+'px;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;float:left;position:'+bar_position+';"><div style="width:'+bar_width+'px;height:'+bar_height+'%;background-color:'+this_bar_color+';position:absolute;bottom:0px;text-align:left;cursor:pointer;" onmouseover="$(this).css(\'filter\',\'brightness(130%)\')" onmouseout="$(this).css(\'filter\',\'brightness(100%)\')" title="'+row_title+': '+column_title+' = '+column_value+'"></div><div style="width:'+bar_width+'px;height:20px;line-height:20px;position:absolute;text-align:center;bottom:'+bar_height+'%">'+this_value+'</div>'+bar_label+'</div>';
					
					if(this_value != 0){
						
						if(values == 'none'){
							values = this_value;
							graph_colors = this_bar_color;
							labels = row_title;
							real_row_index = r;
						}else{
							values = values+'-]'+this_value;
							graph_colors = graph_colors+'-]'+this_bar_color;
							labels = labels+'-]'+row_title;
							real_row_index = real_row_index+'-]'+r;
						}
					}
				
				}
			}
			bar_data = bar_data+this_bar+this_bar_data+'</div>';
		}
	}
	
	if($('#js_option_id_'+dashboard_id+'_'+dashboard_area_id).val() == 0){
		var js_id = $('#js_id_'+dashboard_id+'_'+dashboard_area_id).val();
		
	}else{
		var js_id = $('#js_option_id_'+dashboard_id+'_'+dashboard_area_id).val();
		
	}
	
	if(js_id == 'pie' || js_id == 'doughnut' || js_id == 'scatter'){
		graph_colors = colors.toString();
		
		graph_colors = graph_colors.replace(/,/g,'-]');
	}
	$('#real_row_index_'+dashboard_id+'_'+dashboard_area_id).val(real_row_index);
	create_graph(dashboard_id,dashboard_area_id,js_id,labels,values,graph_colors,graph_colors,data_set_lebel);		
}

function generate_bar_graph_old(graph_id,dashboard_id,dashboard_area_id){
	$('#selected_graph').val(graph_id);
	$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val($('#graph_size_value_'+dashboard_id+'_'+dashboard_area_id).val());
	general_variable_6 = $('#item_details_holder').html();
	close_window('item_details');
	
	var total_data_columns = Number($('#total_data_columns_'+dashboard_id+'_'+dashboard_area_id).val());
	
	var area_width = $('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('width');
	area_width = area_width.replace('px','');	
	area_width = Number(area_width)-80;
	
	
	var column_total = 0;
	for(var c =0;c<total_data_columns;c++){
		if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
			if(column_total < Number($('#report_view_column_max_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val())){
				column_total = Number($('#report_view_column_max_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val());
				
			}
		}
	}
	
	var total_rows = Number($('#total_rows_'+dashboard_id+'_'+dashboard_area_id).val());
	var total_active_bars = 0;
	for(var r =0;r<total_rows;r++){
		for(var c =0;c<total_data_columns;c++){
			if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
				total_active_bars++;
			}
			
		}		
	}
	
	var bar_width = (area_width/total_active_bars) - 5;	
	
	range = column_total+(column_total * 0.1);
	
	var bar_data = '';
	var graph_holder_div = '';
	if($('#selected_graph_type_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
		var graph_holder_div = '<div style="margin-top:10px;min-width:99%;width:auto;height:auto;float:left;border-bottom:solid 1px #bbb;position:relative;" id="graph_holder_'+dashboard_id+'_'+dashboard_area_id+'">';
		
		if($('#selected_show_title').val() == 1){
			graph_holder_div = graph_holder_div+'<div style="width:100%;margin-left:110px;height:30px;float:left;margin-bottom:10px;line-height:30px;font-weight:bold;font-size:1.3em;">'+$('#graph_name_'+dashboard_id+'_'+dashboard_area_id).val()+'</div>';
			
		}
		
		
		if($('#selected_show_legend_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
			graph_holder_div = graph_holder_div+'<div style="margin-left:110px;width:90%;height:auto;float:left;">';
			for(var c =0;c<total_data_columns;c++){
				if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
					
					graph_holder_div = graph_holder_div+'<div style="width:20px;margin-right:5px;height:20px;float:left;background-color:'+$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+';margin-3px;"></div><div style="width:auto;float:left;height:20px;line-height:20px;margin-right:10px;">'+$('#active_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).html()+' ('+$('#report_view_column_total_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val()+')</div>';
					
				}
			}
			
			graph_holder_div = graph_holder_div+'</div>';
		
		}
		
		
		
		var measument_value = range/20;
		var this_measument = 0;
		var measument_height = (Number($('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()) / 20)
		
		if($('#selected_show_grid_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
			graph_holder_div = graph_holder_div+'<div style="width:100px;float:left;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;border-right:solid 1px #bbb;font-size:0.8em;font-weight:bold;">';
			
			for(var m=20;m>0;m--){			
				this_measument = m*measument_value;
				graph_holder_div = graph_holder_div+'<div style="width:92px;cursor:pointer;height:'+measument_height+'px;line-height:'+measument_height+'px;float:left;text-align:right;position:relative;" onmouseover="$(\'#row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'\').css(\'border-color\',\'#006bb3\');this.style.backgroundColor=\'#eee\'" onmouseout="$(\'#row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'\').css(\'border-color\',\'#eee\');this.style.backgroundColor=\'\'">'+round(this_measument,2)+'<div style="min-width:700px;height:1px;border-top:solid 1px #eee;position:absolute;margin-left:95px;bottom:10px;cursor:pointer;" id="row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m+'"></div></div>';
				
				
			}
			graph_holder_div = graph_holder_div+'</div>';
		}
		
		
		
		for(var r =0;r<total_rows;r++){
			var this_bar = '<div style="width:auto;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;margin-right:4px;float:left;position:relative;">';
			
			var this_bar_data = '';
			for(var c =0;c<total_data_columns;c++){
				if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
					var column_value = $('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'_'+r).val();
					var row_title = $('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_data_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'_'+r).val();
					
					var column_title = $('#report_view_column_title_'+dashboard_id+'_'+dashboard_area_id+'_'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()).val();
					
					column_value = column_value.replace(/,/g,'');
					
					var bar_height = column_value / range * 100;
					//alert(bar_height);
					if(column_value == 0){
						column_value = '';
						
					}
					var this_bar_color = $('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val();
					
					if($('#selected_overlay_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 0){
						var bar_position = 'relative';
						
						if(c==0){						
							var bar_label = '<div style="min-width:130px;width:auto;position:absolute;text-align:left;height:'+(bar_width*total_data_columns)+'px;line-height:'+(bar_width)+'px;bottom:'+(-1*(bar_width+5))+'px;transform: rotate(90deg);transform-origin:top left;left:'+bar_width+'px">'+row_title+'</div>';
							
						}else{
							bar_label = '';
							
						}
						
					}else{
						var bar_position = 'absolute';
						var bar_label = '';
						
					}
					
					if($('#selected_show_value_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
						var this_value = column_value;
						
					}else{
						var this_value = '';
						
					}
					
					this_bar_data = this_bar_data+'<div style="width:'+bar_width+'px;height:'+$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val()+'px;float:left;position:'+bar_position+';"><div style="width:'+bar_width+'px;height:'+bar_height+'%;background-color:'+this_bar_color+';position:absolute;bottom:0px;text-align:left;cursor:pointer;" onmouseover="$(this).css(\'filter\',\'brightness(130%)\')" onmouseout="$(this).css(\'filter\',\'brightness(100%)\')" title="'+row_title+': '+column_title+' = '+column_value+'"></div><div style="width:'+bar_width+'px;height:20px;line-height:20px;position:absolute;text-align:center;bottom:'+bar_height+'%">'+this_value+'</div>'+bar_label+'</div>';
				
				}
			}
			bar_data = bar_data+this_bar+this_bar_data+'</div>';
		}
	}

	graph_holder_div = graph_holder_div+bar_data+'</div>';
	display_infor('graph_report_holder_'+dashboard_id+'_'+dashboard_area_id,graph_holder_div);
	
	$('#graph_holder_'+dashboard_id+'_'+dashboard_area_id).css('width',Number(total_active_bars*30)+'px');
	
	for(var m=20;m>0;m--){
		$('#row_measure_'+dashboard_id+'_'+dashboard_area_id+'_'+m).css('width',Number(total_active_bars*30));
	}
	
	$('#graph_options_button_'+dashboard_id+'_'+dashboard_area_id).slideDown('fast');
			
}

function fetch_saved_graph_list(report_id,dashboard_id,dashboard_area_id){	
	$('#saved_graphs_holder').html('Loading list. Wait...');
	
	var data = new FormData();
	data.append('fetch_saved_graph_list',report_id);
	data.append('report_id',report_id);
	data.append('dashboard_id',dashboard_id);
	data.append('dashboard_area_id',dashboard_area_id);
	
	process_simultanious_xmlhttp('area_xmlhttp_'+dashboard_id+'_'+dashboard_area_id,data);
}

function save_bar_graph(graph_id,dashboard_id,dashboard_area_id){
	//$('#item_details_holder').html(general_variable_6);
	//general_variable_6 = '';
	var data = new FormData();
	data.append('save_bar_graph',1);
	data.append('graph_data_source',$('#selected_data_source_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('title',$('#graph_name_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('graph_size',$('#graph_size_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('graph_type',$('#selected_graph_type_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('report_id',$('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('graph_id',graph_id);
	data.append('show_title',$('#selected_show_title_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('show_legend',$('#selected_show_legend_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('show_grid',$('#selected_show_legend_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('dashboard_id',dashboard_id);
	data.append('dashboard_area_id',dashboard_area_id);

	var total_data_columns = $('#total_data_columns_'+dashboard_id+'_'+dashboard_area_id).val();
	
	var rule_string = '';
	for(var c=0;c<total_data_columns;c++){
		if($('#graph_column_active_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val() == 1){
			if(rule_string == ''){
				rule_string = $('#selected_graph_data_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_show_value_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_overlay_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val();
				
				
			}else{
				rule_string = rule_string+']'+$('#selected_graph_data_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_graph_value_column_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_show_value_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_overlay_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val()+'}'+$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_'+c).val();
				
			}		
		}
	}
	
	data.append('rule_string',rule_string);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	change_window_size('item_details',400,450,1);
	show_window('item_details');
	show_loading_progress('item_details_holder','Preparing options. Wait...');
	$('#item_details_title').html('Save graph settings');
}

function process_save_graph(){
	//if($('#graph_saving_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('process_save_graph',1);
		data.append('title',$('#saving_graph_title').val());
		data.append('graph_size',$('#graph_size').val());
		data.append('graph_variables',$('#graph_variables').val());
		data.append('rule_string',$('#rule_string').val());
		data.append('graph_accessibility',$('#selected_saving_accessibility').val());
		data.append('is_default',$('#selected_saving_make_default').val());
		data.append('graph_id',$('#this_graph_id').val());
		data.append('dashboard_id',$('#dashboard_id').val());
		data.append('dashboard_area_id',$('#dashboard_area_id').val());
		data.append('module_id',$('#module_id').val());
		data.append('show_title',$('#show_title').val());
		data.append('show_legend',$('#show_legend').val());
		data.append('show_grid',$('#show_grid').val());
		
		$('#graph_saving_button').html('Wait...');
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
	//}
}

function fetch_saved_graph(saved_graph_id,report_id,graph_type_id,dashboard_id,dashboard_area_id){
	if(report_id == $('#selected_report_'+dashboard_id+'_'+dashboard_area_id).val()){
		//show_window('item_details');
	//	show_loading_progress('item_details_holder','Fetching Graph settings. Wait...');
		$('#item_details_title').html('Graph Settings');

		var data = new FormData();
		data.append('fetch_saved_graph',1);
		data.append('saved_graph_id',saved_graph_id);
		data.append('graph_type_id',graph_type_id);
		data.append('report_id',report_id);
		data.append('dashboard_id',dashboard_id);
		data.append('dashboard_area_id',dashboard_area_id);
		process_simultanious_xmlhttp('area_xmlhttp_'+dashboard_id+'_'+dashboard_area_id,data);
		
		general_variable_5 = $('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).html();
		$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).html('<div style="width:'+$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('width')+';height:'+$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('height')+';float:left;line-height:'+$('#graph_report_holder_'+dashboard_id+'_'+dashboard_area_id).css('height')+';text-align:center;color:#aaa;font-size:3em;">Loading Graph. Wait...</div>');
	}
}

function delete_dynamic_graph(graph_id,dashboard_id,dashboard_area_id){
	if($('#bar_graph_delete_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('delete_dynamic_graph',1);
		data.append('graph_id',graph_id);
		data.append('dashboard_id',dashboard_id);
		data.append('dashboard_area_id',dashboard_area_id);
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
		
		$('#bar_graph_delete_button').html('Wait...');
	}
}

function fetch_cluster_user_groups(cluster_id,this_user_id){
	
	var data = new FormData();
	data.append('fetch_cluster_user_groups',1);
	data.append('cluster_id',cluster_id);
	data.append('this_user_id',this_user_id);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	
	$('#user_groups_holder').html('Fetching user groups. Wait...');
	
}

function restore_user_roles(){
	var this_user_roles = $('#this_user_default_roles').val();
	var this_user_roles_array = this_user_roles.split(',');
	
	for(var gr=0;gr<this_user_roles_array.length;gr++){
		if(this_user_roles_array[gr] == 1){
			if(gr==0){
				document.getElementById('pipat_main_access').checked = true;
				$('#pipat_main_access_input').val(1);
				
			}else if(gr == 1){
				document.getElementById('pipat_main_data_creation').checked = true; 
				$('#pipat_main_data_creation_input').val(1);
				
			}else if(gr == 2){
				document.getElementById('pipat_main_agent_creation').checked = true;
				$('#pipat_main_agent_creation_input').val(1);
				
			}else if(gr == 3){
				document.getElementById('pipat_main_facility_creation').checked = true;
				$('#pipat_main_facility_creation_input').val(1);
				
			}else if(gr == 4){
				document.getElementById('pipat_main_user_creation').checked = true;
				$('#pipat_main_user_creation_input').val(1);
				
			}else if(gr == 5){
				document.getElementById('pipat_main_report_view').checked = true;
				$('#pipat_main_report_view_input').val(1);
				
			}else if(gr == 6){
				document.getElementById('pipat_main_prep_client_creation').checked = true;
				$('#pipat_main_prep_client_creation_input').val(1);
				
			}else if(gr == 7){
				document.getElementById('pipat_main_prep_admin').checked = true;
				$('#pipat_main_prep_admin').val(1);
				
			}else if(gr == 8){
				document.getElementById('pipat_main_super').checked = true;
				$('#pipat_main_super_input').val(1);
				
			}else if(gr == 9){
				document.getElementById('pipat_claims_access').checked = true;
				$('#pipat_claims_access_input').val(1);
				
			}else if(gr == 10){
				document.getElementById('pipat_claims_type').checked = true;
				$('#pipat_claims_type_input').val(1);
				
			}else if(gr == 11){
				document.getElementById('pipt_claims_notifications').checked = true;
				$('#pipt_claims_notifications_input').val(1);
				
			}else if(gr == 12){
				document.getElementById('pipat_bills_access').checked = true;
				$('#pipat_bills_access_input').val(1);
				
			}else if(gr == 13){
				document.getElementById('pipat_bills_type').checked = true;
				$('#pipat_bills_type_input').val(1);
				
			}else if(gr == 14){
				document.getElementById('pipat_bills_notification').checked = true;
				$('#pipat_bills_notification_input').val(1);
				
			}else if(gr == 15){
				document.getElementById('pipat_training_access').checked = true;
				$('#pipat_training_access_input').val(1);
				
			}else if(gr == 16){
				document.getElementById('pipat_training_admin').checked = true;
				$('#pipat_training_admin_input').val(1);
				
			}else if(gr == 17){
				document.getElementById('pipat_logistice_access').checked = true;
				$('#pipat_logistice_access_input').val(1);
				
			}else if(gr == 18){
				document.getElementById('pipat_logistics_admin').checked = true;
				$('#pipat_logistics_admin_input').val(1);
			
			}else if(gr == 19){
				document.getElementById('prep_key_generation').checked = true;
				$('#prep_key_generation_input').val(1);
			}
			
		}else{
			if(gr==0){
				document.getElementById('pipat_main_access').checked = false;
				$('#pipat_main_access_input').val(0);
				
			}else if(gr == 1){
				document.getElementById('pipat_main_data_creation').checked = false; 
				$('#pipat_main_data_creation_input').val(0);
				
			}else if(gr == 2){
				document.getElementById('pipat_main_agent_creation').checked = false;
				$('#pipat_main_agent_creation_input').val(0);
				
			}else if(gr == 3){
				document.getElementById('pipat_main_facility_creation').checked = false;
				$('#pipat_main_facility_creation_input').val(0);
				
			}else if(gr == 4){
				document.getElementById('pipat_main_user_creation').checked = false;
				$('#pipat_main_user_creation_input').val(0);
				
			}else if(gr == 5){
				document.getElementById('pipat_main_report_view').checked = false;
				$('#pipat_main_report_view_input').val(0);
				
			}else if(gr == 6){
				document.getElementById('pipat_main_prep_client_creation').checked = false;
				$('#pipat_main_prep_client_creation_input').val(0);
				
			}else if(gr == 7){
				document.getElementById('pipat_main_prep_admin').checked = false;
				$('#pipat_main_prep_admin').val(0);
				
			}else if(gr == 8){
				document.getElementById('pipat_main_super').checked = false;
				$('#pipat_main_super_input').val(0);
				
			}else if(gr == 9){
				document.getElementById('pipat_claims_access').checked = false;
				$('#pipat_claims_access_input').val(0);
				
			}else if(gr == 10){
				document.getElementById('pipat_claims_type').checked = false;
				$('#pipat_claims_type_input').val(0);
				
			}else if(gr == 11){
				document.getElementById('pipt_claims_notifications').checked = false;
				$('#pipt_claims_notifications_input').val(0);
				
			}else if(gr == 12){
				document.getElementById('pipat_bills_access').checked = false;
				$('#pipat_bills_access_input').val(0);
				
			}else if(gr == 13){
				document.getElementById('pipat_bills_type').checked = false;
				$('#pipat_bills_type_input').val(0);
				
			}else if(gr == 14){
				document.getElementById('pipat_bills_notification').checked = false;
				$('#pipat_bills_notification_input').val(0);
				
			}else if(gr == 15){
				document.getElementById('pipat_training_access').checked = false;
				$('#pipat_training_access_input').val(0);
				
			}else if(gr == 16){
				document.getElementById('pipat_training_admin').checked = false;
				$('#pipat_training_admin_input').val(0);
				
			}else if(gr == 17){
				document.getElementById('pipat_logistice_access').checked = false;
				$('#pipat_logistice_access_input').val(0);
				
			}else if(gr == 18){
				document.getElementById('pipat_logistics_admin').checked = false;
				$('#pipat_logistics_admin_input').val(0);
			
			}else if(gr == 19){
				document.getElementById('prep_key_generation').checked = false;
				$('#prep_key_generation_input').val(0);
			}
		}		
	}
}


function refresh_user_roles(){
	var operator_roles = $('#user_role').val();
	var selected_group_ids = $('#selected_group_ids').val();
	var this_user_roles = $('#this_user_default_roles').val();
	
	var operator_roles_array = operator_roles.split(',');
	var selected_group_id_array = selected_group_ids.split(',');
	var this_user_roles_array = this_user_roles.split(',');
	
	restore_user_roles();
	
	for(var g=0;g<selected_group_ids.length;g++){
		var this_group_roles = $('#group_roles_'+selected_group_ids[g]).val();
		
		var this_group_roles_array = this_group_roles.split(',');		
		for(var gr=0;gr<this_group_roles_array.length;gr++){
			
			if(this_group_roles_array[gr] == 1 &&  operator_roles_array[gr] == 1 && this_user_roles_array[gr] == 0){				
				if(gr==0){
					document.getElementById('pipat_main_access').checked = true;
					$('#pipat_main_access_input').val(1);
					
				}else if(gr == 1){
					document.getElementById('pipat_main_data_creation').checked = true; 
					$('#pipat_main_data_creation_input').val(1);
					
				}else if(gr == 2){
					document.getElementById('pipat_main_agent_creation').checked = true;
					$('#pipat_main_agent_creation_input').val(1);
					
				}else if(gr == 3){
					document.getElementById('pipat_main_facility_creation').checked = true;
					$('#pipat_main_facility_creation_input').val(1);
					
				}else if(gr == 4){
					document.getElementById('pipat_main_user_creation').checked = true;
					$('#pipat_main_user_creation_input').val(1);
					
				}else if(gr == 5){
					document.getElementById('pipat_main_report_view').checked = true;
					$('#pipat_main_report_view_input').val(1);
					
				}else if(gr == 6){
					document.getElementById('pipat_main_prep_client_creation').checked = true;
					$('#pipat_main_prep_client_creation_input').val(1);
					
				}else if(gr == 7){
					document.getElementById('pipat_main_prep_admin').checked = true;
					$('#pipat_main_prep_admin').val(1);
					
				}else if(gr == 8){
					document.getElementById('pipat_main_super').checked = true;
					$('#pipat_main_super_input').val(1);
					
				}else if(gr == 9){
					document.getElementById('pipat_claims_access').checked = true;
					$('#pipat_claims_access_input').val(1);
					
				}else if(gr == 10){
					document.getElementById('pipat_claims_type').checked = true;
					$('#pipat_claims_type_input').val(1);
					
				}else if(gr == 11){
					document.getElementById('pipt_claims_notifications').checked = true;
					$('#pipt_claims_notifications_input').val(1);
					
				}else if(gr == 12){
					document.getElementById('pipat_bills_access').checked = true;
					$('#pipat_bills_access_input').val(1);
					
				}else if(gr == 13){
					document.getElementById('pipat_bills_type').checked = true;
					$('#pipat_bills_type_input').val(1);
					
				}else if(gr == 14){
					document.getElementById('pipat_bills_notification').checked = true;
					$('#pipat_bills_notification_input').val(1);
					
				}else if(gr == 15){
					document.getElementById('pipat_training_access').checked = true;
					$('#pipat_training_access_input').val(1);
					
				}else if(gr == 16){
					document.getElementById('pipat_training_admin').checked = true;
					$('#pipat_training_admin_input').val(1);
					
				}else if(gr == 17){
					document.getElementById('pipat_logistice_access').checked = true;
					$('#pipat_logistice_access_input').val(1);
					
				}else if(gr == 18){
					document.getElementById('pipat_logistics_admin').checked = true;
					$('#pipat_logistics_admin_input').val(1);
				
				}else if(gr == 19){
					document.getElementById('prep_key_generation').checked = true;
					$('#prep_key_generation_input').val(1);
				}
			}
		}
	}
}

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($('#'+element).html()).select();
  document.execCommand("copy");
  $temp.remove();
  alert('Text copied');
}

function fetch_dashboard(dashboard_id){
	var data = new FormData();
	data.append('fetch_dashboard',1);
	data.append('dashboard_id',dashboard_id);
	data.append('module_id',$('#module_id').val());
	
	if($('#filter_script').val() == undefined){
		data.append('filter_script','');
		
	}else{
		data.append('filter_script',$('#filter_script').val());
		
	}
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	
	$('#dashboard_area_holder').html('<div style="width:100%;height:700px;float:left;line-height:700px;text-align:center;color:#999;font-size:2em;">Fetching dashboard...</div>');
}

function fetch_dashboard_graph(dashboard_id,dashboard_area_id){
	
	if($('#report_default_display_'+dashboard_id+'_'+dashboard_area_id).val() == 1){
		$('#dynamic_report_holder_'+dashboard_id+'_'+dashboard_area_id).hide();
		$('#report_graph_holder_'+dashboard_id+'_'+dashboard_area_id).fadeIn('fast');
		
	}else{
		$('#dynamic_report_holder_'+dashboard_id+'_'+dashboard_area_id).fadeIn();
		$('#report_graph_holder_'+dashboard_id+'_'+dashboard_area_id).hide('fast');
		
	}
	
	$('#report_graph_holder_'+dashboard_id+'_'+dashboard_area_id).html('<div style="width:100%;height:'+$('#area_height_'+dashboard_id+'_'+dashboard_area_id).val()+'px;float:left;line-height:'+$('#area_height_'+dashboard_id+'_'+dashboard_area_id).val()+'px;text-align:center;color:#999;font-size:2em;">Initializing graph</div>');
	
	var data = new FormData();
	data.append('fetch_dashboard_graph',1);
	data.append('dashboard_id',dashboard_id);
	data.append('dashboard_area_id',dashboard_area_id);
	data.append('area_width',$('#area_width_'+dashboard_id+'_'+dashboard_area_id).val());
	data.append('area_height',$('#area_height_'+dashboard_id+'_'+dashboard_area_id).val());
	
	process_simultanious_xmlhttp('area_xmlhttp_'+dashboard_id+'_'+dashboard_area_id,data);
}

function add_column_translation(column_ind,operator_ind){
	var total_columns = Number($('#total_translations_'+column_ind+'_'+operator_ind).val());
	
	var div_code = '<div style="width:100%;height:auto;float:left;" id="translation_holder_'+column_ind+'_'+operator_ind+'_'+total_columns+'"><div style="line-height:30px;width:50px;height:30px;float:left;line-height:30px;">Value:</div><div style="line-height:30px;width:70px;height:30px;float:left;"><input type="text" id="translation_value_'+column_ind+'_'+operator_ind+'_'+total_columns+'" value="0" style="width:100%;height:25px;"></div> <div style="line-height:30px;width:90px;height:30px;float:left;line-height:30px;margin-left:5px;">Translates To:</div><div style="line-height:30px;width:70px;height:30px;float:left;"><input type="text" id="translation_'+column_ind+'_'+operator_ind+'_'+total_columns+'" value="0" style="width:100%;height:25px;"></div> <div style="margin-left:2px;width:25px;margin-top:2px;height:25px;line-height:25px;text-align:center;float:left;background-color:brown;color:#fff;" id="remove_translate_'+column_ind+'_'+operator_ind+'_'+total_columns+'" onclick="var c = confirm(\'Are you sure you wish to remove this translation?\');if(c){$(\'#translation_holder_'+column_ind+'_'+operator_ind+'_'+total_columns+'\').slideUp(\'fast\');$(\'#translation_'+column_ind+'_'+operator_ind+'_'+total_columns+'_active\').val(0);}">X</div><input type="hidden" id="translation_'+column_ind+'_'+operator_ind+'_'+total_columns+'_active" value="1"></div>';
	
	$('#custom_transator_data_holder_'+column_ind+'_'+operator_ind).append(div_code);
	
	total_columns++;
	
	$('#total_translations_'+column_ind+'_'+operator_ind).val(total_columns);
}

function fetch_dashboard_details(dashboard_id){
	var data = new FormData();
	data.append('fetch_dashboard_details',1);
	data.append('dashboard_id',dashboard_id);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	$('#item_details').fadeIn('fast');
	show_loading_progress('item_details_holder','Preparing. Please wait...');
	$('#item_details_title').html('Dashboard Details');
	change_window_size('item_details',500,500,1);
}

function fetch_area_details(area_id){
	var data = new FormData();
	data.append('fetch_area_details',1);
	data.append('area_id',area_id);
	data.append('dashboard_id',$('#selected_dashboard').val());
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	$('#item_details').fadeIn('fast');
	show_loading_progress('item_details_holder','Preparing. Please wait...');
	
	if(!area_id){
		$('#item_details_title').html('Add Dashboard Data Space');
	
	}else{
		$('#item_details_title').html('Dashboard Data Space Details');
		
	}
	
	change_window_size('item_details',500,500,1);
}

function create_or_update_dashboard(dashboard_id){
	if($('#dashboard_save_button').html() != 'Wait...'){	
		if($('#dashboard_title').val() == 'Enter title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need provide a title for this dashboard');
			$('#dashboard_title').css('border-color','red');
		
		}else if(($('#selected_accessibility_type').val() == 0 || $('#selected_accessibility_type').val() == 1  || $('#selected_accessibility_type').val() == 2 ) && $('#selected_dashboard_region').val() == '-1'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to select the location');

		}else{
			$('#error_message').slideUp('fast');
			
			var c = confirm('Are you sure you wish to proceed?');
	
			if(c){
				var data = new FormData();
				data.append('create_or_update_dashboard',1);
				data.append('dashboard_id',dashboard_id);
				data.append('dashboard_title',$('#dashboard_title').val());
				data.append('dashboard_description',$('#dashboard_description').val());
				data.append('branch_id',$('#selected_user_cluster').val());
				data.append('module_id',$('#module_id').val());
				data.append('accessibility_type_id',$('#selected_accessibility_type').val());
				data.append('dashboard_group_ids',$('#selected_group_ids').val());
				data.append('dashboard_unit_ids',$('#selected_dashboard_unit').val());
				data.append('dashboard_users',$('#selected_user').val());
				
				data.append('region_id',$('#selected_dashboard_region').val());
				data.append('province_id',$('#selected_dashboard_province').val());
				data.append('hub_id',$('#selected_dashboard_hub').val());
				data.append('site_id',$('#selected_dashboard_site').val());
				data.append('set_default',$('#selected_set_default').val());
				data.append('show_description',$('#show_dashboard_description').val());
				
				process_simultanious_xmlhttp('general_xmlhttp',data);
				$('#dashboard_save_button').html('Wait...');
			}
		}
	}	
}

function create_or_update_dashboard_area(dashboard_id,area_id){
	if($('#area_save_button').html() != 'Wait...'){
		if($('#area_title').val() == 'Enter title here'){
		$('#error_message').slideDown('fast');
		$('#error_message').html('You need provide a title for this area');
		$('#area_title').css('border-color','red');
	
		}else{
			var c = confirm('Are you sure you wish to proceed?');
	
			if(c){
				var data = new FormData();
				data.append('create_or_update_dashboard_area',1);
				data.append('dashboard_id',dashboard_id);
				data.append('branch_id',$('#branch_id').val());
				data.append('module_id',$('#module_id').val());
				
				data.append('area_id',area_id);
				
				data.append('title',$('#area_title').val());
				data.append('show_title',$('#show_area_title').val());
				data.append('description',$('#area_description').val());
				data.append('show_description',$('#show_area_description').val());
				data.append('width',$('#area_width').val());
				data.append('height',$('#area_height').val());
				data.append('ordering',$('#area_ordering').val());
				data.append('show_buttons',$('#selected_show_buttons').val());
				
				process_simultanious_xmlhttp('general_xmlhttp',data);
				$('#area_save_button').html('Wait...');
				
			}
		}
	}
}

function delete_dashboard(dashboard_id){
	if($('#delete_dashboard_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to delete this dashboard? All custom reports ad graphs under it will be deleted');
		
		if(c){
			var data = new FormData();
			data.append('delete_dashboard',1);
			data.append('module_id',$('#module_id').val());
			data.append('dashboard_id',dashboard_id);
			process_simultanious_xmlhttp('general_xmlhttp',data);
			
			$('#delete_dashboard_button').html('Wait...');
		}
	}
}

function fetch_wifi_details(wifi_id){
	show_window('item_details');
	
	show_loading_progress('item_details_holder','Preparing. Wait...');
	
	var data = new FormData();
	data.append('fetch_wifi_details',1);
	data.append('wifi_id',wifi_id);
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
}

function update_or_create_wifi(wifi_id){
	if($('#update_or_create_wifi_button').html() != 'Wait...'){
		
		if($('#wifi_title').val() == 'Enter title here'){
			$('#wifi_title').css('border-color','red');
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter WI-FI title');
			
		}else if($('#starting_ip').val() == 'Enter IP here'){
			$('#starting_ip').css('border-color','red');
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter starting IP for this WI-FI');
			
		}else if($('#ending_ip').val() == 'Enter IP here'){
			$('#ending_ip').css('border-color','red');
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter ending IP for this WI-FI');
			
		}else{
			var c = confirm('Are you sure you wish to proceed?');
			if(c){
				var data = new FormData();
				data.append('update_or_create_wifi',1);
				data.append('wifi_id',wifi_id);
				data.append('title',$('#wifi_title').val());
				data.append('branch_id',$('#selected_wifi_branch').val());
				data.append('starting_ip',$('#starting_ip').val());
				data.append('ending_ip',$('#ending_ip').val());
				data.append('confirmation_message',$('#confirmation_message').val());
				data.append('redirect_url',$('#redirect_url').val());
				data.append('login_script',$('#login_script').val());
				data.append('login_delay',$('#login_delay').val());
				data.append('white_list',$('#white_list').val());
				data.append('user_relogin',$('#selected_wifi_relogin').val());
				
				process_simultanious_xmlhttp('general_xmlhttp',data);
				
				
				$('#update_or_create_wifi_button').html('Wait...');
			}
			
		}
		
	}
}

function create_data_window(){
	var new_window_index = Number($('#window_index').val());
	var new_window_z_index = Number($('#window_z_index').val());
	var data_div = '<div style="width:400px;height:450px;position:absolute;z-index:'+new_window_z_index+';display:none;" id="item_details_'+new_window_index+'" ><div class="window_holder" style="width:100%;"><div class="window_title_bar" id="item_details_title_bar_'+new_window_index+'"><div style="width:92%;height:auto;float:left;text-align:center;" id="item_details_title_'+new_window_index+'">Details</div><div class="window_close_button" onmouseout="this.style.backgroundColor=\'\';" onmouseover="this.style.backgroundColor=\'#c95e5e\';" onclick="close_window(\'item_details_'+new_window_index+'\');" id="details_close_button_'+new_window_index+'">X</div></div><div class="window_container" style="width:98.61%;padding:0.5%;height:250px;" id="item_details_holder_'+new_window_index+'"></div></div></div>';
	
	$('#main_body').prepend(data_div);
	
	
	$('#window_index').val(new_window_index+1);
	$('#window_z_index').val(new_window_z_index+1);
	
	return new_window_index;
	
}

function fetch_graph_comment(dashboard_id,dashboard_area_id,entry_ind){
	create_data_window();
	var new_window_index = create_data_window();
	
	var real_row_index_string = $('#real_row_index_'+dashboard_id+'_'+dashboard_area_id).val();
	var real_row_index_array = real_row_index_string.split('-]');
	
	show_window('item_details_'+new_window_index);
	
	$('#item_details_title_'+new_window_index).html($('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_0_'+real_row_index_array[entry_ind]).val());
	
	$('#item_details_title_bar_'+new_window_index).css('backgroundColor',$('#selected_bar_color_'+dashboard_id+'_'+dashboard_area_id+'_0').val());
	
	var output_div = '<div style="width:100%;height:auto;float:left;font-wight:bold;text-align:center;">Population category and data filtering options for <br><strong>'+$('#report_view_row_value_'+dashboard_id+'_'+dashboard_area_id+'_0_'+real_row_index_array[entry_ind]).val()+'</strong></div>';
	
	output_div = output_div+'<div style="width:100%;margin-top:20px;height:30px;float:left;font-wight:bold;text-align:center;">Coming soon</div>';
	
	$('#item_details_holder_'+new_window_index).html(output_div);
	
}


/**
 * Get the user IP throught the webkitRTCPeerConnection
 * @param onNewIP {Function} listener function to expose the IP locally
 * @return undefined
 */
function getUserIP(onNewIP) { //  onNewIp - your listener function for new IPs
    //compatibility for firefox and chrome
    var myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
    var pc = new myPeerConnection({
        iceServers: []
    }),
    noop = function() {},
    localIPs = {},
    ipRegex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/g,
    key;

    function iterateIP(ip) {
        if (!localIPs[ip]) onNewIP(ip);
        localIPs[ip] = true;
    }

     //create a bogus data channel
    pc.createDataChannel("");

    // create offer and set local description
    pc.createOffer().then(function(sdp) {
        sdp.sdp.split('\n').forEach(function(line) {
            if (line.indexOf('candidate') < 0) return;
            line.match(ipRegex).forEach(iterateIP);
        });
        
        pc.setLocalDescription(sdp, noop, noop);
    }).catch(function(reason) {
        // An error occurred, so handle the failure to connect
    });

    //listen for candidate events
    pc.onicecandidate = function(ice) {
        if (!ice || !ice.candidate || !ice.candidate.candidate || !ice.candidate.candidate.match(ipRegex)) return;
        ice.candidate.candidate.match(ipRegex).forEach(iterateIP);
    };
}	

function fetch_captive_client_access_log(){
	show_loading_progress('captive_wifi','Fetching data. Wait...');
	
	var data = new FormData();
	data.append('fetch_captive_client_access_log',1);
	data.append('wifi_id',$('#selected_wifi').val());
	data.append('survey_id',$('#selected_survey').val());
	data.append('date_from',$('#date_from').val());
	data.append('date_to',$('#date_to').val());
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
}

function export_captive_client_access_log(){
	if($('#captive_clients_export_button').html() != 'Wait...'){
		
		if($('#selected_survey').val() == 0){
			alert('You cannot combine all surveys in one export. Please select one survey to export');
			
		}else{		
			var data = new FormData();
			data.append('export_captive_client_access_log',1);
			
			data.append('wifi_id',$('#selected_wifi').val());
			data.append('survey_id',$('#selected_survey').val());
			data.append('export_format',$('#selected_export_format').val());
			data.append('date_from',$('#date_from').val());
			data.append('date_to',$('#date_to').val());
			
			process_simultanious_xmlhttp('general_xmlhttp',data);
			
			$('#captive_clients_export_button').html('Wait...');
		
		}
	}
}

function fetch_general_dashboard(holder_id){
	fetch_script('_codes/general_dashboard.php?a=0',holder_id);
}


function add_prep_uploaded_file(){
	$('#tool_excel_file').html($('#uploaded_files').val());
	$('#uploaded_files').val('');
	close_window('image_uploader');
	
}


function add_or_update_file(file_id,_type){
	show_window('item_details',1);
	show_loading_progress('item_details_holder','Preparing. Wait...');	
	change_window_size('item_details',400,400,1);
	
	if(_type == 0){
		var item_name = 'file';
		
	}else{
		var item_name = 'folder';
	}
	
	if(file_id == 0){
		$('#item_details_title').html('Add '+item_name);
	
	}else{
		$('#item_details_title').html('Update '+item_name+' settings');
	
	}
	
	var data = new FormData();
	data.append('add_or_update_file',1);
	data.append('file_id',file_id);
	data.append('_type',_type);
	data.append('folder_id',$('#folder_id').val());
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
}

function autheticate_add_file(file_id,_type){
	if($('#file_name').val() == '' || $('#file_name').val() == 'Enter name here'){
		$('#file_name').css('border-color','red');
		$('#error_message').slideDown('fast');
		$('#error_message').html('You need to enter name of this file');
		
	}else{
		if(file_id != 0 || _type == 1){
			process_add_or_update_file(file_id,_type);
			
			
		}else{
			open_uploader('process_add_or_update_file('+file_id+','+_type+')', 0);
			
		}
	}	
}

function process_add_or_update_file(file_id,_type){
	var data = new FormData();
	data.append('process_add_or_update_file',1);
	data.append('folder_id',$('#folder_id').val());
	data.append('file_id',file_id);
	data.append('_type',_type);
	data.append('file_name',$('#file_name').val());
	data.append('file_src',$('#uploaded_files').val());
	data.append('file_description',$('#file_description').val());
	data.append('accessibility',$('#selected_accessbility').val());
	data.append('allow_delete',$('#selected_allow_delete').val());
	data.append('region_id',$('#selected_request_region').val());
	data.append('province_id',$('#selected_request_province').val());
	data.append('hub_id',$('#selected_request_hub').val());
	data.append('facility_id',$('#selected_request_site').val());
	
	
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	
	$('#save_upload_images').html('Wait...');
}

function fetch_public_files(this_level,folder_id){
	
	var directory_level = Number($('#directory_level').val());
	
	for(var d = this_level+1;d<directory_level;d++){
		$('#directory_'+d).remove();
		
	}
	
	$('#directory_level').val(this_level+1);
	
	var data = new FormData();
	data.append('folder_id',folder_id);
	data.append('fetch_public_files',1);
	data.append('file_status',$('#file_status').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('facility_id',$('#selected_site').val());
	data.append('item_sorting',$('#item_sorting').val());
	show_loading_progress('item_details_holder','Reading. Wait...');	
	
	process_simultanious_xmlhttp('general_xmlhttp',data);
	
	$('#folder_id').val(folder_id);
	
}

function fetch_folder_files(folder_id,folder_title){
	
	var this_director_level = Number($('#directory_level').val());
	
	var directory_div = '<div style="width:auto;float:left;" id="directory_'+this_director_level+'" onclick="fetch_public_files('+this_director_level+','+folder_id+');"><div style="cursor:pointer;width:auto;float:left;height:20x;line-height:20px;background-color:#eee;text-align:center;padding:3px;margin-left:5px;padding-left:6px;padding-right:6px;" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';" >'+folder_title+'</div><div style="width: 0;height: 0; border-top: 13px solid transparent;border-bottom: 13px solid transparent;border-left: 13px solid #eee;float:left;"></div></div>';
	

	$('#file_directories').append( directory_div);
	$('#folder_id').val(folder_id);
	
	fetch_public_files(this_director_level,folder_id);
	
	this_director_level++;
	$('#directory_level').val(this_director_level);
}

function delete_files(){
	if($('#delete_files_button').html() != 'Wait...'){
		
		if($('#selected_files').val() == ''){
			alert('You have not selected any items');
			
		}else{
		
			var c = confirm('Are you sure you wish to delete selected items?');
			
			if(c){
				var data = new FormData();
				data.append('delete_files',1);
				data.append('selected_files',$('#selected_files').val());
				
				$('#delete_files_button').html('Wait...');
				
				process_simultanious_xmlhttp('general_xmlhttp',data);
				
			}
			
			$('#copy_queue').val('');
		}
	}
}

function copy_selected(_type){
	if($('#selected_files').val() == ''){
			alert('You have not selected any items');
			
	}else{
		$('#copy_queue').val($('#selected_files').val());
		
		$('#copy_or_cut').val(_type);
		
		if(_type==1){
			var selected_items = $('#selected_files').val();
			var selected_items_array = selected_items.split(',');
			
			for(var i= 0;i<selected_items_array.length;i++){
				$('#file_item_'+selected_items_array[i]).css('color','#aaa');
				
			}			
		}
	}
}

function paste_selected(folder_id){
	if($('#paste_button').html() != 'Wait...'){
		if($('#copy_queue').val() == ''){
				alert('You have not copied any items');
				
		}else{
		
			var data = new FormData();
			
			data.append('paste_selected',1);
			data.append('folder_id',folder_id);
			data.append('copy_queue',$('#copy_queue').val());
			data.append('copy_or_cut',$('#copy_or_cut').val());
			
			$('#paste_button').html('Wait...');
			
			process_simultanious_xmlhttp('general_xmlhttp',data);
		}
	}
}

function check_copy_status(){
	if($('#copy_queue').val() == ''){
		$('#copy_status_holder').slideUp('fast');
		
	}else{
		var copy_queue = $('#copy_queue').val();
		var copy_queue_array = copy_queue.split(',');
		
		$('#copy_status_holder').html(''+copy_queue_array.length+' items copied | <a onclick="$(\'#copy_queue\').val(\'\');$(\'#copy_status_holder\').slideUp(\'fast\');fetch_public_files((Number($(\'#directory_level\').val())-1),$(\'#folder_id\').val());" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" style="cursor:pointer;" title="Click to clear copy memory">Clear </a>|');
		
		$('#copy_status_holder').slideDown('fast');
	}	
}

function process_add_agent_file(agent_id){
	if($('#uploaded_files').val() == ''){
		alert('You need to add at-least one file');
		
	}else{	
		var data = new FormData();
		data.append('process_add_agent_file',1);
		data.append('agent_id',agent_id);
		data.append('uploaded_files',$('#uploaded_files').val());
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
		
		$('#save_upload_images').html('Wait..');		
	}
}

function remove_agent_file(agent_id,file_id){
	var c = confirm('Are you sure you wish to remove this file?');
	
	if(c){
		var data = new FormData();
		data.append('remove_agent_file',1);
		data.append('agent_id',agent_id);
		data.append('file_id',file_id);
		
		$('#agent_file_'+file_id).html('<div style="width:100%;height:20px;line-height:20px;text-align:center;float:left;">Removing file. Wait....</div>');
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
	}
}

function request_validation(agent_id){
	var c = confirm('Are you sure you wish to submit this agent for finance validation?');
	
	if(c){
		var data = new FormData();
		data.append('request_validation',1);
		data.append('agent_id',agent_id);
		
		$('#request_validation_button').html('Wait...');
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
	}
}


function cancel_validation(agent_id){
	var c = confirm('Are you sure you wish to remove this agent from list of agents to be validated by finance?');
	
	if(c){
		var data = new FormData();
		data.append('cancel_validation',1);
		data.append('agent_id',agent_id);
		
		$('#request_validation_button').html('Wait...');
		
		process_simultanious_xmlhttp('general_xmlhttp',data);
	}
}

function fetch_agent_validation_list_code(){
	var data = new FormData();
	data.append('fetch_agent_validation_list_code',1);
	data.append('unit_id',$('#selected_unit').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	data.append('branch_id',$('#selected_branch').val());
	data.append('user_allocation',$('#selected_allocation').val());

	data.append('agent_search_key',$('#agent_search_key').val());
		
	send_general_xmlhttp(data);
	
	show_loading_progress('agent_list_holder','Fetching data. Please wait...');
}