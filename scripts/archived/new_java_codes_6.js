
if(window.XMLHttpRequest){
	module_xmlhttp = new XMLHttpRequest();
	
}else{
	module_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

module_xmlhttp.onreadystatechange = function(){
	if(module_xmlhttp.readyState == 4 && module_xmlhttp.status == 200){
		var response_text = module_xmlhttp.responseText;
		var response_array = response_text.split("~");
	
		if(response_array[0] == 'create_or_update_branch'){
			close_window('item_details');
			fetch_script('_codes/branches.php','settings');
			
		}else if(response_array[0] == 'fetch_branch'){
			display_infor('item_details_holder',response_array[1]);
		
		
		}else if(response_array[0] == 'start_screening'){
			display_infor('screen_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'ussd_activity_log' || response_array[0] == 'fetch_sms_queue' || response_array[0] == 'fetch_sms_clients' || response_array[0] == 'fetch_sms_client_groups'){
			display_infor('ussd_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_ussd_menu'){
			if(response_array[1] > ussd_current_level){
				$('#ussd_menu_navigation').append(response_array[2]);
			
			}
			ussd_current_level = response_array[1];
			display_infor('ussd_menu_hoder',response_array[3]);
			
		}else if(response_array[0] == 'fetch_ussd_menu_details' || response_array[0] == 'create_new_ussd_menu_item'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_ussd_menu_item'){
			close_window('item_details');
			
			fetch_ussd_menu(response_array[1],response_array[2]);
	
		}else if(response_array[0] == 'delete_ussd_menu_item'){
			close_window('item_details');
			
			fetch_ussd_menu(response_array[1],response_array[2]);
			
		
			
		}else if(response_array[0] == 'check_site_title'){
			$('#site_title_error').slideDown('fast');
			
			if(response_array[1] == 1){
				$('#site_title_error').html('Another site appears to have the same name. The following are the site details: '+response_array[2]);				
				$('#site_title').css('border-color','orange');
				$('#site_title_error').css('color','purple');
				$('#site_title_error_input').val(1);
				
			}else{
				$('#site_title_error').html('Site title okay');
				$('#site_title_error').css('color','green');
				$('#site_title_error_input').val(0);
			}
			
			$('#site_title_error').css('text-align','left');
		
		}else if(response_array[0] == 'check_site_gsm_code'){
			$('#site_gsm_error').slideDown('fast');
			
			if(response_array[1] == 1){
				$('#site_gsm_error').html('Another site appears to be using the same USSD/SMS code. The following are the site details: '+response_array[2]);				
				$('#gsm_code').css('border-color','red');
				$('#site_gsm_error').css('color','red');
				$('#site_gsm_error_input').val(1);
				
			}else{
				$('#site_gsm_error').html('Site USSD/SMS code okay');
				$('#site_gsm_error').css('color','green');
				$('#site_gsm_error_input').val(0);
			}
			
			$('#site_gsm_error').css('text-align','left');
		
			
		
			
		}else if(response_array[0] == 'disable_site'){
			if($('#selected_status').val() == ''){
				$('#facility_'+response_array[1]).css('color','#999');
				
			}else{
				$('#facility_'+response_array[1]).slideUp('fast');
				
			}
			close_window('item_details');
			
		}else if(response_array[0] == 'enable_site'){
			if($('#selected_status').val() == ''){
				$('#facility_'+response_array[1]).css('color','#000');
				
			}else{
				$('#facility_'+response_array[1]).slideUp('fast');
			}
			
			close_window('item_details');
			
			
		}else if(response_array[0] == 'disable_mother_facility'){
			if($('#selected_status').val() == ''){
				$('#mother_facility_'+response_array[1]).css('color','#999');
				
			}else{
				$('#mother_facility_'+response_array[1]).slideUp('fast');
				
			}
			close_window('item_details');
			
		}else if(response_array[0] == 'enable_mother_facility'){
			if($('#selected_status').val() == ''){
				$('#mother_facility_'+response_array[1]).css('color','#000');
				
			}else{
				$('#mother_facility_'+response_array[1]).slideUp('fast');
			}
			
			close_window('item_details');
			
		
			
		}else if(response_array[0] == 'fetch_facility_list_code'){
			display_infor('general_list_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_mother_facility_list_code'){
			display_infor('general_list_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_facility_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_mother_facility_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'update_or_create_site'){
			if(response_array[1] == 0){
				var output_div = '<div style="width:100%;color:#000;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\';" onmouseout="this.style.backgroundColor=\'\';" onclick="fetch_facility_details('+response_array[2]+');" id="facility_'+response_array[2]+'">'+response_array[3]+'</div>';
				$('#general_list_holder').prepend(output_div);
				
			}else{
				display_infor('facility_'+response_array[2],response_array[3]);
				
			}
			
			close_window('item_details');
			
		}else if(response_array[0] == 'update_or_create_mother_facility'){
			if(response_array[1] == 0){
				var output_div = '<div style="width:100%;color:#000;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\';" onmouseout="this.style.backgroundColor=\'\';" onclick="fetch_mother_facility_details('+response_array[2]+');" id="mother_facility_'+response_array[2]+'">'+response_array[3]+'</div>';
				$('#general_list_holder').prepend(output_div);
				
			}else{
				display_infor('mother_facility_'+response_array[2],response_array[3]);
				
			}
			
			close_window('item_details');
			
		}else if(response_array[0] == 'fetch_question_set'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_edit_question_set'){
			close_window('item_details');
			
		}else if(response_array[0] == 'fetch_questionnaire'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_edit_questionnaire'){
			close_window('item_details');
			
			if($('#module_id').val() == 4){
				fetch_script('_codes/survey_list.php?a=1','captive_wifi');tab_item_change(1);
				
			}else if($('#module_id').val() == 5){
				fetch_analytical_survey_settings();
				
			}else{
				fetch_script('_codes/questionnaire_list.php?a=1','prep_admin');tab_item_change(1);
			}
			
		}else if(response_array[0] == 'questionnaire_next'){
			$('#questionnaire_title_holder').slideDown('fast');
			$('#questionnaire_title_holder').html(response_array[1]);
			display_infor('screen_data_holder',response_array[2]);
			
		}else if(response_array[0] == 'fetch_client_list'){
			display_infor('client_list_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_client_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_client'){			
			$('#client_profile_button').val('Update');
			$('#client_profile_validated').val(1);
			
			$('#client_update_status').slideDown('fast');
			$('#client_update_status').html('Client profile updated successfully...');
			
			$('#client_profile_button').html('Update');
			
			setTimeout("hide_item('client_update_status')",10000);
			
		}else if(response_array[0] == 'fetch_dynamic_form'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_edit_dynamic_form'){
			close_window('item_details');
			$('#tab_2').click();
			
		}else if(response_array[0] == 'create_or_edit_dynamic_checklist'){
			close_window('item_details');
			$('#tab_3').click();
			
		}else if(response_array[0] == 'create_or_update_client_screening'){
			$('#result_status').slideUp('fast');
			$('#result_status').html('');
			
			$('#client_screening_validated').val(1);
			$('#client_id').val(response_array[1]);
			
			if(response_array[2] == 1){
				$('#client_'+response_array[1]).slideUp('fast');
				
			}
			
		}else if(response_array[0] == 'create_or_update_client_form'){
			$('#dynamic_form_validated_'+response_array[1]).val(1);
		
			fetch_client_details(response_array[2],response_array[3]);
			
			/*$('#client_form_button_'+response_array[1]).html('Update');
			$('#client_update_status').slideDown('fast');
			$('#client_update_status').html('Client form updated successfully... Please check and update other applicable forms for this client');
			
			setTimeout("hide_item('client_update_status')",10000);*/
			
		}else if(response_array[0] == 'fetch_activity_list_code'){
			display_infor('activity_list',response_array[1]);
			
		}else if(response_array[0] == 'fetch_unit_list_code'){
			display_infor('unit_list',response_array[1]);
			
		}else if(response_array[0] == 'update_or_create_activity'){
			fetch_activity_list();
			close_window('item_details');	
			
		}else if(response_array[0] == 'update_or_create_unit'){
			fetch_unit_list();
			close_window('item_details');
			
		}else if(response_array[0] == 'checklist_code'){
			$('#checklist_details_'+response_array[1]).html(response_array[2]);
			
		}else if(response_array[0] == 'search_checklist_clients'){
			display_infor('checklist_client_search_results_'+response_array[1],response_array[2]);
			
		}else if(response_array[0] == 'create_or_update_checklist'){
			$('#checklist_save_button_'+checklist_id).html('Save');
			
		}else if(response_array[0] == 'fetch_screening_results'){
			display_infor('screen_data_holder',response_array[1]);
			
		}else if(response_array[0] == 'delete_prep_data_set'){
			$('#questionnaire_data_set_title_'+response_array[1]).slideUp('fast');
			$('#questionnaire_data_set_results_'+response_array[1]).slideUp('fast');
			
			$('#questionnaire_data_set_title_'+response_array[1]).remove();
			$('#questionnaire_data_set_results_'+response_array[1]).remove();
			
			$('#client_risk_'+response_array[3]).html(response_array[4]);
			
			if(response_array[2] == 1){
				$('#client_'+response_array[3]).slideUp('fast');
				
			}
			
		}else if(response_array[0] == 'delete_prep_form_data_set'){
			$('#histori_data_title_'+response_array[1]).slideUp('fast');
			$('#historic_data_holder_'+response_array[1]).slideUp('fast');
			
			$('#histori_data_title_'+response_array[1]).remove();
			$('#historic_data_holder_'+response_array[1]).remove();
			
		}else if(response_array[0] == 'fetch_scheduler'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_prep_scheduler'){
			close_window('item_details');
			fetch_script('_codes/prep_message_scheduler.php?a=0','prep_admin');tab_item_change(0);
			
		}else if(response_array[0] == 'fetch_schedule_message'){
			display_infor('message_editior_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_prep_scheduler_message'){
			close_window('message_editior_details');
			$('#message_'+response_array[1]).html(response_array[2]);
			
		}else if(response_array[0] == 'generate_decryption_key'){
			if(response_array[1] == 1){
				generate_decryption_key();
				
			}else{
				$('#decryption_key_holder').html('<input type="text" id="dencryption_key" style="height:20px;width:200px;" value="'+response_array[2]+'">');
					
				fetch_client_list();
			}
			
		}else if(response_array[0] == 'validate_key'){
			if(response_array[1] == 1){
				fetch_client_list();
				alert('Key validation successfully...');
				$('#code_validate_button').slideUp('fast');
				
				
			}else {
				$('#code_validate_button').html('Check');
				alert(response_array[2]);
				
				
			}
			
		}else if(response_array[0] == 'export_prep_clients'){
			$('#client_export_button').html('Export');
			window.open($('#url').val()+'/'+response_array[1],'file_download');
			var file_src = response_array[1];
		
			
		}else if(response_array[0] == 'delete_file'){
			//alert('File deleted');
			
		}else if(response_array[0] == 'change_client_status'){
			var total_records = Number($('#records_number').html());
			if(response_array[2] == 0){
				if($('#account_status').val() == -1){
					$('#client_'+response_array[1]).css('color','#aaa');
					
				}else{
					$('#client_'+response_array[1]).slideUp('fast');
					
					total_records--;
					$('#records_number').html(total_records);
				}
				
			}else{
				if($('#account_status').val() == -1){
					$('#client_'+response_array[1]).css('color','#000');
					
				}else{
					$('#client_'+response_array[1]).slideUp('fast');
					total_records--;
					$('#records_number').html(total_records);
					
				}				
			}

			close_window('item_details');

		}else if(response_array[0] == 'delete_prep_client'){			
			$('#client_'+response_array[1]).slideUp('fast');
			
			var total_records = Number($('#records_number').html());
			total_records--;
			$('#records_number').html(total_records);
			
			close_window('item_details');
			
		}else if(response_array[0] == 'fetch_prep_category_details'){
			display_infor('prep_category_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'update_form_category'){
			//alert('Category value updated successfully...');
			close_window('prep_category_details');
			
			$('#category_data_'+response_array[2]).html(response_array[3]);
			
			
		}else if(response_array[0] == 'fetch_questionnaire_client_identity'){
			display_infor('screen_data_holder',response_array[1]);
			
		}else if(response_array[0] == 'save_prep_report'){
			display_infor('item_details_holder_1',response_array[1]);
			
		}else if(response_array[0] == 'process_save_prep_report'){
			close_window('item_details');
			
		}else if(response_array[0] == 'populate_profile_data'){
			$('#client_name').val(response_array[2]);
			$('#client_phone').val(response_array[3]);
			
			$('#client_selected_sex').val(response_array[4]);
			$('#active_sex').html(response_array[5]);

			$('#selected_population_category').val(response_array[6]);
			$('#active_population_category').html(response_array[7]);
			
			if(response_array[2] != 0){
				$('#client_name').css('color','#000');
				$('#client_phone').css('color','#000');
				
			}else{
				$('#client_name').css('color','#aaa');
				$('#client_phone').css('color','#aaa');
				
			}
			
			$('#client_profile_updated').val(1);
			
		}else if(response_array[0] == 'fetch_dynamic_form_details' || response_array[0] == 'fetch_dynamic_form_list'){
			display_infor('dynamic_form_'+response_array[1],response_array[3]);
			
		}else if(response_array[0] == 'fetch_adherence_agent'){
			$('#adherence_agent_search_results').html(response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_custom_client_form'){
			fetch_dynamic_form_list(response_array[1]);
			
			$('#dynamic_form_'+response_array[1]+'_done').val(1);
			
		}else if(response_array[0] == 'fetch_sms_details' || response_array[0] == 'fetch_group_details' || response_array[0] == 'fetch_sms_client_details'){
			display_infor('item_details_holder_'+response_array[1],response_array[2]);
			
		}else if(response_array[0] == 'update_sms_message'){
			close_window('item_details_'+response_array[1]);
			fetch_sms_queue();
			
		}else if(response_array[0] == 'process_prep_uploader'){
			if(response_array[1] == 1){
				alert('Data upload successful');
				
			}else if(response_array[1] == 2){
				alert('Data upload complete with errors');
				
			}
			
			$('#process_prep_file_button').html('Process');
			$('#tool_excel_file').html('');
			reset_image_upload();
			
		}else if(response_array[0] == 'update_sms_group'){
			close_window('item_details_'+response_array[1]);
			fetch_sms_client_groups();
			
		}else if(response_array[0] == 'update_sms_client'){
			close_window('item_details_'+response_array[1]);
			fetch_sms_clients();
			
		}else if(response_array[0] == 'fetch_story'){
			$('#'+response_array[1]+'_holder').html(response_array[2]);
			
		}else if(response_array[0] == 'share_newsletter_post'){
			fetch_script('_codes/newsletter_stories.php?a=0','newsletter');
			
		}else if(response_array[0] == 'fetch_analytical_survey_settings' || response_array[0] == 'fetch_analytical_survey'){
			display_infor('analytical_survey',response_array[1]);
			
		}else if(response_array[0] == 'process_analytical_survey'){
			fetch_analytical_survey();
			
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
			//alert(response_array[0]);
		}
	}
}

function hide_item(item_id){
	$('#'+item_id).slideUp('fast');
}


function create_or_update_branch(branch_id){
	if($('#create_branch_button').html() != 'Wait...'){
		if($('#branch_name').val() == 'Enter cluster name here' || $('#branch_name').val() == ''){
			$('#new_branch_error_message').fadeIn('fast');
			$('#new_branch_error_message').html('Please enter the cluster name');
			$('#branch_name').css('border-color','red');
			
		}else if($('#branch_phone').val() == 'Enter phone number here' || $('#branch_phone').val() == ''){
			$('#new_branch_error_message').fadeIn('fast');
			$('#new_branch_error_message').html('Enter official contact number for this cluster');
			$('#branch_phone').css('border-color','red');
			
		}else if($('#branch_email').val() == 'Enter email here' || $('#branch_email').val() == ''){
			$('#new_branch_error_message').fadeIn('fast');
			$('#new_branch_error_message').html('Enter official contact number for this cluster');
			$('#branch_email').css('border-color','red');			
			
		}else{
			var data = new FormData();
			data.append('create_or_update_branch',1);
			data.append('branch_id',branch_id);
			data.append('branch_name',$('#branch_name').val());
			data.append('branch_phone',$('#branch_phone').val());
			data.append('branch_email',$('#branch_email').val());
			data.append('branch_notes',$('#branch_notes').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#create_branch_button').html('Wait...');
		}	
	}
}

function fetch_branch(branch_id){
	var data = new FormData();
	data.append('fetch_branch',1);
	data.append('branch_id',branch_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#item_details_title').html('Cluster Details');
	show_window('item_details',1);
	change_window_size('item_details',400,400,1);
	show_loading_progress('item_details_holder','Preparing. One moment please.');
}

function disable_or_enable_branch(new_status,branch_date){
	if($('#disable_or_enabe_branch_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to make this change?');
		if(c){
			var data = new FormData();
			data.append('disable_or_enable_branch',1);
			data.append('new_status',new_status);
			data.append('branch_id',branch_date);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#disable_or_enabe_branch_button').html('Wait...');
		}
	}
}




function fetch_detailed_list(){
	if($('#last_entry_id').val() != undefined && $('#editing_active').val() == 0){
		var data = new FormData();
		data.append('fetch_detailed_list',1);
		data.append('branch_id',$('#selected_branch').val());
		data.append('unit_id',$('#selected_unit').val());
		data.append('activity_id',$('#selected_activity').val());
		data.append('region_id',$('#selected_region').val());
		data.append('province_id',$('#selected_province').val());
		data.append('hub_id',$('#selected_hub').val());
		data.append('site_id',$('#selected_site').val());
		
		data.append('agent_id',$('#selected_agent').val());

		data.append('validation',$('#selected_validation').val())
		data.append('date_from',$('#date_from').val());
		data.append('date_to',$('#date_to').val());
		data.append('last_entry_id',$('#last_entry_id').val());
		data.append('last_date',$('#last_date').val());
		
		process_simultanious_xmlhttp('live_window_data_xmlhttp',data);
		
		if($('#last_entry_id').val() == 0){
			show_loading_progress('detailed_list_data_holder','Fetching data. Please wait...');
			
		}
		
		if($('#selected_report').val() == '-1'){
			
			$('#detailed_list_holder').slideDown();
			$('#report_formular_holder').slideUp('fast');
			$('#report_settings_holder').slideUp('fast');
			$('#dynamic_report_holder_0_0').slideUp('fast');
		}
		
		
	}
}


function start_screening(){
	show_window('screening');
	show_loading_progress('screen_details_holder','Loading. One moment please...');
	
	var data = new FormData();
	data.append('start_screening',1);
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function ussd_activity_log(){
	var data = new FormData();
	data.append('ussd_activity_log',1);
	data.append('date_from',$('#date_from').val());
	data.append('date_to',$('#date_to').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	data.append('agent_id',$('#selected_agent').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	
	show_loading_progress('ussd_holder','Loading. One moment please...');
}

function fetch_sms_queue(){
	var data = new FormData();
	data.append('fetch_sms_queue',1);
	data.append('status',$('#selected_sms_status').val());
	data.append('sms_branch_id',$('#selected_branch').val());
	data.append('module_id',$('#selected_sms_module').val());
	data.append('group_id',$('#selected_sms_group').val());
	data.append('date_from',$('#date_from').val());
	data.append('date_to',$('#date_to').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_loading_progress('ussd_holder','Loading. One moment please...');
}

function fetch_ussd_menu(level,parent_id){
	close_window('item_details');
	var data = new FormData();
	data.append('fetch_ussd_menu',1);
	data.append('level',level);
	data.append('parent_id',parent_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	for(var l = level+1;l<ussd_current_level+1;l++){
		$('#menu_navigation_'+l).remove();
	
	}
}

function fetch_ussd_menu_details(menu_id){
	$('#item_details_holder').css('height','300px');
	$('#item_details_title').html('Item details');
	show_window('item_details',1);
	show_loading_progress('item_details_holder','Fetching. One moment please...');
	
	var data = new FormData();
	data.append('fetch_ussd_menu_details',1);
	data.append('menu_id',menu_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function create_or_update_ussd_menu_item(menu_id,parent_id,level){	
	if($('#create_or_edit_menu_button').html() != 'Wait...'){
	
		if($('#ussd_menu_title').val() == 'Enter title here' || $('#ussd_menu_title').val() == ''){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to enter a title for this menu item');
			$('#ussd_menu_title').css('boder-color','red');
			
		}else if($('#new_ussd_menu_show_id').val() == 1 && ($('#ussd_menu_id').val() == '' || $('#ussd_menu_id').val() == '0')){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to enter a USSD Code for this menu item');
			$('#ussd_menu_id').css('boder-color','red');

		}else if($('#new_ussd_menu_type').val() == 1 && ($('#ussd_menu_script').val() == '' || $('#ussd_menu_script').val() == 'Enter script source here')){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to enter a script file name for this menu item');
			$('#ussd_menu_script').css('boder-color','red');
			
			
		}else{
			var data = new FormData();
			
			data.append('create_or_update_ussd_menu_item',1);
			data.append('menu_id',menu_id);
			data.append('parent_id',parent_id);
			data.append('title',$('#ussd_menu_title').val());
			data.append('show_id',$('#new_ussd_menu_show_id').val());
			data.append('ussd_id',$('#ussd_menu_id').val());
			data.append('_type',$('#new_ussd_menu_type').val());
			data.append('script_src',$('#ussd_menu_script').val());
			data.append('_order',$('#ussd_menu_order').val());
			data.append('level',level);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);

			$('#create_or_edit_menu_button').html('Wait...');			
		}
	}
}

function create_new_ussd_menu_item(level,parent_id){
	show_window('item_details',1);
	$('#item_details_holder').css('height','330px');
	
	$('#item_details_title').html('Create new menu item');
	show_loading_progress('item_details_holder','Preparing. Wait...');
	
	var data = new FormData();
	data.append('create_new_ussd_menu_item',1);
	data.append('level',level);
	data.append('parent_id',parent_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function delete_ussd_menu_item(menu_id,level,parent_id){
	var c = confirm('Are you sure you wish to delete this item? This action cannot be undone.');
	
	if(c){
		var data = new FormData();
		data.append('delete_ussd_menu_item',1);
		data.append('menu_id',menu_id);
		data.append('level',level);
		data.append('parent_id',parent_id);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		
		$('#menu_delete_button').html('Wait...');		
	}
}



function check_site_title(site_id){
	if($('#site_title').val() != '' && $('#site_title').val() != 'Enter title for this site here'){
		var data = new FormData();
		data.append('check_site_title',1);
		data.append('site_title',$('#site_title').val());
		data.append('site_id',site_id);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#site_title_error').slideDown('fast');
		$('#site_title_error').html('Checking site title');
		$('#site_title_error').css('text-align','center');
		$('#site_title_error').css('color','#000');
	}
}

function check_site_gsm_code(site_id){
	if($('#site_gsm_error').html() == '' || $('#site_title_error').html() == 'Checking site title'){
		var checker = setTimeout("check_site_gsm_code("+site_id+")",1000);
		$('#site_gsm_error').html('Checking site USSD/SMS code');
		
	}else{
		if($('#gsm_code').val() != '' && $('#gsm_code').val() != 'Enter code here'){
			var data = new FormData();
			data.append('check_site_gsm_code',1);
			data.append('gsm_code',$('#gsm_code').val());
			data.append('site_id',site_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#site_gsm_error').slideDown('fast');
			$('#site_gsm_error').html('Checking site USSD/SMS code');
			$('#site_gsm_error').css('text-align','center');
			$('#site_gsm_error').css('color','#000');
		}
	}
	
}



function disable_site(site_id){
	if($('#disable_agent_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this site? Agents will not be able to report under it');
		
		if(c){
			var data = new FormData();
			data.append('disable_site',1);
			data.append('site_id',site_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);

			$('#disable_site_button').html('Wait...');
		}
	}
}

function enable_site(site_id){
	if($('#enable_site_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to enable this site? Agents will be able to report under it');
	
		if(c){
			var data = new FormData();
			data.append('enable_site',1);
			data.append('site_id',agent_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);

			$('#enable_site_button').html('Wait...');
		}
			
		
	}	
}

function disable_mother_facility(mother_facility_id){
	if($('#disable_mother_facility_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this item? Agents will not be able to report under it');
		
		if(c){
			var data = new FormData();
			data.append('disable_mother_facility',1);
			data.append('mother_facility_id',mother_facility_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);

			$('#disable_mother_facility_button').html('Wait...');
		}
	}
}

function enable_mother_facility(mother_facility_id){
	if($('#enable_mother_facility_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to enable this item? Agents will be able to report under it');
	
		if(c){
			var data = new FormData();
			data.append('enable_mother_facility',1);
			data.append('mother_facility_id',mother_facility_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);

			$('#enable_mother_facility_button').html('Wait...');
		}
	}	
}

function fetch_facility_list(){
	fetch_script('_codes/facility_list.php?a=1','locations');
	
}

function fetch_mother_facility_list_code(){
	var data = new FormData();
	data.append('fetch_mother_facility_list_code',1);
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('status_id',$('#selected_status').val());
	
	data.append('mother_facility_search_key',$('#search_key').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('general_list_holder','Fetching data. Please wait...');
}

function fetch_facility_list_code(){
	var data = new FormData();
	data.append('fetch_facility_list_code',1);
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('mother_facility_id',$('#selected_mother_facility').val());
	data.append('site_id',$('#selected_site').val());
	data.append('status_id',$('#selected_status').val());
	
	data.append('fatility_search_key',$('#search_key').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('general_list_holder','Fetching data. Please wait...');
}

function fetch_facility_details(facility_id){
	var data = new FormData();
	data.append('fetch_facility_details',1);
	data.append('facility_id',facility_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details',1);
	
	show_loading_progress('item_details_holder','Fetching data. Please wait...');
	$('#location_filter_options').slideUp('fast');
}

function fetch_mother_facility_details(mother_facility_id){
	var data = new FormData();
	data.append('fetch_mother_facility_details',1);
	data.append('mother_facility_id',mother_facility_id);
	
	//change_window_size('item_details',300,300,1);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details',1);
	
	show_loading_progress('item_details_holder','Fetching data. Please wait...');
	$('#location_filter_options').slideUp('fast');
	
	
}

function update_or_create_site(site_id){
	if($('#site_gsm_error').html() == '' || $('#site_gsm_error').html() == 'Checking site USSD/SMS code'){
		var checker = setTimeout("update_or_create_site("+site_id+")",1000);
		
	}else{
		if($('#update_or_create_site_button').html() != 'Wait...'){
			if($('#site_title').val() == '' || $('#site_title').val() == 'Enter title for this site here'){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('Enter title for this site');
				$('#site_title').css('border-color','red');
				
			}else if($('#site_type').val() == '' || $('#site_type').val() == 'Enter this site type here'){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('Enter this site type');
				$('#site_type').css('border-color','red');
			
			}else if($('#gsm_code').val() == '' || $('#gsm_code').val() == 'Enter code here'){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('Enter code to use for USSD/SMS reporting');
				$('#gsm_code').css('border-color','red');
						
			}else if($('#gps_code').val() == '' || $('#gps_code').val() == 'Enter code here'){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('Enter GPS location coordinates for this site');
				$('#gps_code').css('border-color','red');
				
			}else if($('#site_gsm_error_input').val() == 1){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('Another site is using the same USSD/SMS code');
					
			}else if($('#selected_site_region').val() == 0){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('You need to specify the region in which this site is located');
					
			}else if($('#selected_site_province').val() == 0){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('You need to specify the province in which this site is located');
				
			}else if($('#selected_site_hub').val() == 0){
				$('#new_site_error_message').slideDown('fast');
				$('#new_site_error_message').html('You need to specify the hub in which this site is located');
				
			
			}else{
				var missing_fields = '';
				if($('#site_identified').val() == '' || $('#site_identified').val() == 'Not set'){
					missing_fields = 'Identification date for this site is not set';
					
				}
				
				if($('#site_assessed').val() == '' || $('#site_assessed').val() == 'Not set'){
					if(missing_fields == ''){
						missing_fields = 'Assessment date for this site is not set';
						
					}else if($('#site_started').val() == '' || $('#site_started').val() == 'Not set'){
						missing_fields = missing_fields+',  assessment date for this site is not set';
						
					}else{
						missing_fields = missing_fields+' and assessment date for this site is not set';
						
					}
				}
				
				if($('#site_started').val() == '' || $('#site_started').val() == 'Not set'){
					if(missing_fields == ''){
						missing_fields = 'Starting date for this site is not set';
							
					}else{
						missing_fields = missing_fields+' and starting date for this site is not set';
						
					}
				}
				
				if($('#site_title_error_input').val() == 1){
					if(missing_fields == ''){
						missing_fields = 'Note that there is another site with exactly the same name';
							
					}else{
						missing_fields = missing_fields+'. Also note that there is another site with exactly the same name';
						
					}
				}
					
				
				if(missing_fields == ''){
					var c = confirm('Are you sure you wish to proceed?');
					
				}else{
					var c = confirm(missing_fields+'. Are you sure you wish to proceed?');
					
				}
				
				if(c){
					var data = new FormData();				
					data.append('update_or_create_site',1);
					data.append('site_id',site_id);
					data.append('site_title',$('#site_title').val());
					data.append('site_type',$('#site_type').val());
					data.append('gsm_code',$('#gsm_code').val());
					data.append('gps_code',$('#gps_code').val());
					data.append('site_identified',$('#site_identified').val());
					data.append('site_assessed',$('#site_assessed').val());
					data.append('site_started',$('#site_started').val());
					data.append('site_grading',$('#site_selected_grading').val());
					data.append('region_id',$('#selected_site_region').val());
					data.append('province_id',$('#selected_site_province').val());
					data.append('hub_id',$('#selected_site_hub').val());
					data.append('mother_facility_id',$('#selected_site_mother_facility').val());
									
					process_simultanious_xmlhttp('module_xmlhttp',data);
					
					$('#update_or_create_site_button').html('Wait...');
					
				}
			}
		}
	}
}

function update_or_create_mother_facility(mother_facility_id){	
	if($('#update_or_create_mother_button').html() != 'Wait...'){
		if($('#mother_facility_title').val() == '' || $('#mother_facility_title').val() == 'Enter title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter title for mother facility');
			$('#mother_facility_title').css('border-color','red');
			
		}else if($('#selected_mother_facility_region').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to specify the region in which this mother facility is located');
				
		}else if($('#selected_mother_facility_province').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to specify the province in which this mother facility is located');
			
		}else if($('#selected_mother_facility_hub').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to specify the hub in which this mother facility is located');
			
		}else{
			var c = confirm('Are you sure you wish to proceed?');

			if(c){
				var data = new FormData();				
				data.append('update_or_create_mother_facility',1);
				data.append('mother_facility_id',mother_facility_id);
				data.append('mother_facility_title',$('#mother_facility_title').val());
				data.append('region_id',$('#selected_mother_facility_region').val());
				data.append('province_id',$('#selected_mother_facility_province').val());
				data.append('hub_id',$('#selected_mother_facility_hub').val());
								
				process_simultanious_xmlhttp('module_xmlhttp',data);
				
				$('#update_or_create_mother_facility_button').html('Wait...');
				
			}
		}
	}
}

function process_data_download(){
	window.open($('#url').val()+'/excel_export.php?date_from='+$('#date_from').val()+'&date_to='+$('#date_to').val()+'&unit_id='+$('#selected_unit').val()+'&branch_id='+$('#selected_branch').val()+'&activity_id='+$('#selected_activity').val()+'&region_id='+$('#selected_region').val()+'&province_id='+$('#selected_province').val()+'&hub_id='+$('#selected_hub').val()+'&site_id='+$('#selected_site').val()+'&agent_id='+$('#selected_agent').val()+'&validation_status='+$('#selected_validation').val()+'&file_type='+$('#selected_file_type').val()+'&data='+$('#selected_data').val(),'excel_output');
}

/*function fetch_report(){
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
		
	}else{
		data.append('focus',$('#selected_focus').val());
		
	}

	send_general_xmlhttp(data);
	
	
	if($('#selected_report').val() != 4){
		show_loading_progress('report_container');
	}
}*/

function create_or_edit_questionnaire(questionnaire_id){
	//if($('#create_questionnaire_button').html() != 'Wait...'){
		if($('#questionnaire_title').val() == '' || $('#questionnaire_title').val() == 'Enter title here'){
			$('#new_questionnaire_error_message').fadeIn('fast');
			$('#new_questionnaire_error_message').html('Please enter title for this questionnaire');
			$('#questionnaire_title').css('border-color','red');
			
		}else if($('#total_sessions').val() == 0){
			$('#new_questionnaire_error_message').fadeIn('fast');
			$('#new_questionnaire_error_message').html('You need to add at-least one session');
				
		}else{
			var total_sessions = Number($('#total_sessions').val());
			
			var error = 0;
			var session_active = 0;
			var question_active = 0;
			var option_active = 0;
			for(var s=0;s<total_sessions;s++){
				if(document.getElementById('session_item_title_'+s).disabled == false && ($('#session_item_title_'+s).val() == 'Enter title here' || $('#session_item_title_'+s).val() == '')){
					$('#session_item_title_'+s).css('border-color','red');
					
					$('#session_'+s+'_holder').slideDown('fast');
					error = 1;
					
				}else if(document.getElementById('session_item_title_'+s).disabled == false){
					session_active = 1;
					
				}
				
				var total_questions = $('#total_questions_'+s).val();
				
				for(var q = 0;q<total_questions;q++){
					if(document.getElementById('question_'+s+'_'+q).disabled == false && ($('#question_'+s+'_'+q).val() == 'Enter question here' || $('#question_'+s+'_'+q).val() == '')){
						$('#question_'+s+'_'+q).css('border-color','red');
						
						$('#session_'+s+'_holder').slideDown('fast');
						error = 1;
						
					}else if(document.getElementById('question_'+s+'_'+q).disabled == false){
						question_active = 1;					
						
					}
					
					
					var total_options = $('#total_question_options_'+s+'_'+q).val();
					
					for(var o=0;o<total_options;o++){
						if(document.getElementById('option_'+s+'_'+q+'_'+o).disabled == false && ($('#option_'+s+'_'+q+'_'+o).val() == 'Enter option here' || $('#option_'+s+'_'+q+'_'+o).val() == '')){
							$('#option_'+s+'_'+q+'_'+o).css('border-color','red');
							
							$('#session_'+s+'_holder').slideDown('fast');
							error = 1;
						
						}else if(document.getElementById('option_'+s+'_'+q+'_'+o).disabled == false){
							option_active = 1;
							
						}
					}
				}
			}
			
			if(error){
				$('#new_questionnaire_error_message').fadeIn('fast');
				$('#new_questionnaire_error_message').html('Check and ensure that the fields highlighted in red are fillied in correctly');
				
			}else if(!session_active){
				$('#new_questionnaire_error_message').fadeIn('fast');
				$('#new_questionnaire_error_message').html('All questionnaire sessions are disabled. You need to have at-least one active questionnaire session');
				
			}else if(!question_active){
				$('#new_questionnaire_error_message').fadeIn('fast');
				$('#new_questionnaire_error_message').html('All questions are disabled. You need to have at-least one active question');
				
			}else if(!option_active){
				$('#new_questionnaire_error_message').fadeIn('fast');
				$('#new_questionnaire_error_message').html('All options are disabled. You need to have at-least one active option');
		
			}else{
				var data = new FormData();
				data.append('create_or_edit_questionnaire',1);
				data.append('questionnaire_id',questionnaire_id);
				data.append('title',$('#questionnaire_title').val());
				data.append('description',$('#new_questionnaire_description').val());
				data.append('branch_id',$('#questionnaire_branch_id').val());
				data.append('client_identity',$('#new_slient_identity').val());
				data.append('welcome_image',$('#uploaded_files').val());				
				data.append('removed_sessions',$('#removed_sessions').val());
				data.append('module_id',$('#module_id').val());
				
				if($('#module_id').val() == 4){
					data.append('wifi_id',$('#wifi_id').val());
					
				}
				
				var total_sessions = Number($('#total_sessions').val());
				data.append('total_sessions',total_sessions);
				for(var s=0;s<total_sessions;s++){
					data.append('session_title_'+s,$('#session_item_title_'+s).val());
					data.append('session_order_'+s,$('#group_order_'+s).val());
					data.append('session_id_'+s,$('#session_id_'+s).val());
					
					data.append('removed_questions_'+s,$('#removed_questions_'+s).val());
						
					var total_questions = $('#total_questions_'+s).val();
					data.append('total_questions_'+s,total_questions);
					
					for(var q = 0;q<total_questions;q++){
						data.append('question_'+s+'_'+q,$('#question_'+s+'_'+q).val());
						data.append('question_option_type_'+s+'_'+q,$('#selected_option_type_'+s+'_'+q).val());
						data.append('question_id_'+s+'_'+q,$('#question_id_'+s+'_'+q).val());
						data.append('removed_question_options_'+s+'_'+q,$('#removed_question_options_'+s+'_'+q).val());
						data.append('question_order_'+s+'_'+q,$('#question_order_'+s+'_'+q).val());
												
						var total_options = $('#total_question_options_'+s+'_'+q).val();
						data.append('total_options_'+s+'_'+q,total_options);						
						for(var o=0;o<total_options;o++){
							data.append('option_'+s+'_'+q+'_'+o,$('#option_'+s+'_'+q+'_'+o).val());
							data.append('option_score_'+s+'_'+q+'_'+o,$('#option_value_'+s+'_'+q+'_'+o).val());
							data.append('option_id_'+s+'_'+q+'_'+o,$('#option_id_'+s+'_'+q+'_'+o).val());
							data.append('option_order_'+s+'_'+q+'_'+o,$('#option_order_'+s+'_'+q+'_'+o).val());
						}
					}				
				}				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				$('#create_questionnaire_button').html('Wait...');
			}
		}
	//}
}

function remove_group(session_index){
	session_index = session_index.replace('_','');
	session_index = Number(session_index);
	
	var total_questions = Number($('#total_questions_'+session_index).val());
	
	if(document.getElementById('session_item_title_'+session_index).disabled == false){
		document.getElementById('session_item_title_'+session_index).disabled = true;
		document.getElementById('group_order_'+session_index).disabled = true;
		add_to_selection(session_index,'removed_sessions');
		
	}else{
		document.getElementById('session_item_title_'+session_index).disabled = false;
		document.getElementById('group_order_'+session_index).disabled = false;
		remove_from_selection(session_index,'removed_sessions');
		
	}
	
	for(var question_index = 0;question_index<total_questions;question_index++){
		remove_question('_'+session_index,'_'+question_index);
		
	}
	
	
}


function remove_question(session_index,question_index){
	session_index = session_index.replace('_','');
	session_index = Number(session_index);
	
	question_index = question_index.replace('_','');
	question_index = Number(question_index);
	
	var total_options = $('#total_question_options_'+session_index+'_'+question_index).val();
	
	if(document.getElementById('question_'+session_index+'_'+question_index).disabled == false){
		document.getElementById('question_'+session_index+'_'+question_index).disabled = true;
		
		for(var o=0;o<total_options;o++){
			document.getElementById('option_'+session_index+'_'+question_index+'_'+o).disabled = true;
			document.getElementById('option_value_'+session_index+'_'+question_index+'_'+o).disabled = true;
			
		}
		$('#add_question_option_button_'+session_index+'_'+question_index+'_'+(total_options-1)).fadeOut('fast');		
		add_to_selection(question_index,'removed_questions_'+session_index);
		
	}else{
		if(document.getElementById('session_item_title_'+session_index).disabled == false){
			document.getElementById('question_'+session_index+'_'+question_index).disabled = false;
			
			for(var o=0;o<total_options;o++){
				document.getElementById('option_'+session_index+'_'+question_index+'_'+o).disabled = false;
				document.getElementById('option_value_'+session_index+'_'+question_index+'_'+o).disabled = false;
				
			}
			
			$('#add_question_option_button_'+session_index+'_'+question_index+'_'+(total_options-1)).fadeIn('fast');		
			remove_from_selection(question_index,'removed_questions_'+session_index);
			$('#removed_question_options_'+session_index+'_'+question_index).val('');
		}
	}
}

function remove_option(session_index,question_index,option_index){
	session_index = session_index.replace('_','');
	session_index = Number(session_index);
	
	question_index = question_index.replace('_','');
	question_index = Number(question_index);
	
	option_index = option_index.replace('_','');
	option_index = Number(option_index);
	
	if(document.getElementById('option_'+session_index+'_'+question_index+'_'+option_index).disabled == false){
		document.getElementById('option_'+session_index+'_'+question_index+'_'+option_index).disabled = true;
		document.getElementById('option_value_'+session_index+'_'+question_index+'_'+option_index).disabled = true;		
		add_to_selection(option_index,'removed_question_options_'+session_index+'_'+question_index);
		
	}else{
		if(document.getElementById('session_item_title_'+session_index).disabled == false && document.getElementById('question_'+session_index+'_'+question_index).disabled == false){
			document.getElementById('option_'+session_index+'_'+question_index+'_'+option_index).disabled = false;
			document.getElementById('option_value_'+session_index+'_'+question_index+'_'+option_index).disabled = false;
			remove_from_selection(option_index,'removed_question_options_'+session_index+'_'+question_index);
		}
	}
}

function upload_questionnaire_image(){
	close_window('image_uploader');
	
	$('#active_uploaded_image').html($('#uploaded_files').val());
}


function add_question(session_index){
	session_index = session_index.replace('_','');
	session_index = Number(session_index);
	
	var total_questions = Number($('#total_questions_'+session_index).val());
	
	var question_div = $('#question_s_holder').html();
	question_div = question_div.replace(/_s/g,'_'+session_index);
	question_div = question_div.replace(/_qq/g,'_'+total_questions);
	
	question_div = '<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;" id="question_'+total_questions+'_holder">'+question_div+'</div>';
	question_div = question_div.replace('Question 1','Question '+(total_questions+1));
	$('#questions_holder_'+session_index).append(question_div);
	
	$('#question_order_'+session_index+'_'+total_questions).val(total_questions+1);
	
	var total_options = $('#total_question_options_s_qq').val();	
	for(var t =0; t<total_options;t++){
		$('#option_title_'+session_index+'_'+total_questions+'_'+t).attr('ondblclick',"remove_option('_"+total_sessions+"','_"+total_questions+"','_"+t+"')");
		
	}
	
	$('#total_questions_'+session_index).val((total_questions+1));
}

function add_question_option(session_index,question_index){
	session_index = session_index.replace('_','');
	question_index = question_index.replace('_','');

	var total_question_options = Number($('#total_question_options_'+session_index+'_'+question_index).val());
	
	var option_div = $('#question_option_s_qq_0').html();
	option_div = option_div.replace(/_s_qq_0/g,'_'+session_index+'_'+question_index+'_'+(total_question_options));
	
	option_div = option_div.replace(/_s/g,'_'+session_index);
	option_div = option_div.replace(/_qq/g,'_'+question_index);
	option_div = option_div.replace(/'_o'/g,"'_"+total_question_options+"'");
	
	option_div = option_div.replace('Option 1','Option '+(Number(total_question_options)+1));
	
	
	option_div = '<div style="width:100%;height:auto;float:left;margin-top:5px;" id="question_option_'+session_index+'_'+question_index+'_'+total_question_options+'">'+option_div+'</div>';
	
	
	$('#qustion_options_'+session_index+'_'+question_index).append(option_div);
	$('#add_question_option_button_'+session_index+'_'+question_index+'_'+(total_question_options-1)).fadeOut('fast');

	$('#add_question_option_button_'+session_index+'_'+question_index+'_'+(total_question_options)).fadeIn('fast');

	
	total_question_options++;
	$('#option_order_'+session_index+'_'+question_index+'_'+(total_question_options-1)).val(total_question_options);
	$('#total_question_options_'+session_index+'_'+question_index).val(total_question_options);
}

function fetch_question_set(question_set_id){
	var data = new FormData();
	data.append('fetch_question_set',1);
	data.append('question_set_id',question_set_id);
	
	show_window('item_details',1);
	change_window_size('item_details',800,500,1);
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Preparing. One moment...');
}

function create_or_edit_question_set(question_set_id){
	//if($('#create_question_set_button').html() != 'Wait...'){
		if($('#selected_questionnaire').val() == 0){
			$('#questionnaire_set_error_message').slideDown('fast');
			$('#questionnaire_set_error_message').html('You need to select a questionnaire');
			
		}else if($('#selected_session').val() == 0){
			$('#questionnaire_set_error_message').slideDown('fast');
			$('#questionnaire_set_error_message').html('You need to select a session');
			
		}else{
			var data = new FormData();
			data.append('create_or_edit_question_set',1);
			data.append('questionnaire_id',$('#selected_questionnaire').val());
			data.append('session_id',$('#selected_session').val());
			
			var total_questions = Number($('#total_questions').val());
			
			data.append('total_questions',total_questions);
			for(var q=0;q<total_questions;q++){
				var total_question_options = Number($('#total_question_options_'+q).val());
				
				data.append('total_question_options_'+q,total_question_options);
				data.append('question_title_'+q,$('#question_'+q).val());
				data.append('question_option_type_'+q,$('#selected_option_type_'+q).val());
				data.append('question_id_'+q,$('#question_'+q).val());
			
				for(var o=0;o<total_question_options;o++){
					data.append('question_option_title_'+q+'_'+o,$('#option_'+q+'_'+o).val());
					data.append('question_option_score_'+q+'_'+o,$('#option_score_'+q+'_'+o).val());
					
					
				}		
			}
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#create_question_set_button').html('Wait...');
		}
	//}
}

function fetch_questionnaire(questionnaire_id){
	var data = new FormData();
	data.append('fetch_questionnaire',1);
	data.append('questionnaire_id',questionnaire_id);
	data.append('module_id',$('#module_id').val());
	
	show_window('item_details',1);
	change_window_size('item_details',1000,500,1);
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Preparing. One moment...');
	$('#item_details_title').html('Questionnaire details');
	$('#item_details_title_bar').css('background-color','#dfb859');

}

function add_session(){
	var total_sessions = Number($('#total_sessions').val());	
	var session_div = $('#default_sessions_holder').html();
	
	session_div = session_div.replace(/_s/g,'_'+total_sessions);
	session_div = session_div.replace(/_qq/g,'_0');	
	
	$('#sessions_holder').append(session_div);
	
	var total_options = $('#total_question_options_s_qq').val();	
	for(var t =0; t<total_options;t++){
		$('#option_title_'+total_sessions+'_0_'+t).attr('ondblclick',"remove_option('_"+total_sessions+"','_0','_"+t+"')");
		
	}
	
	$('#session_title_'+total_sessions).html('Session '+(total_sessions+1));
	$('#group_order_'+total_sessions).val(total_sessions+1);
	$('#session_'+(total_sessions-1)+'_holder').slideUp('fast');
	total_sessions++;	
	$('#total_sessions').val(total_sessions);
	
}

function delete_questionnaire(questionnaire_id){
	if($('#delete_questionnaire_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to delete this questionnaire? This action cannot be undone');
		
		if(c){
			var data = new FormData();
			data.append('delete_questionnaire',1);
			data.append('questionnaire_id',questionnaire_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#delete_questionnaire_button').html('Wait...');
		}
	}
}

function questionnaire_next(questionnaire_id,session_id,question_id,ordering,index,answer_id,answer_score){
	var data = new FormData();
	data.append('questionnaire_next',1);
	data.append('question_id',question_id);
	data.append('questionnaire_id',questionnaire_id);
	data.append('session_id',session_id);
	data.append('ordering',ordering);
	data.append('_index',index);
	data.append('answer_id',answer_id);
	data.append('answer_score',answer_score);
	data.append('tmp_client_id',$('#tmp_client_id').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('screen_data_holder','Fetching question. Please wait...');
		
	add_to_selection(answer_score,'client_scores');
}

function fetch_client_list(){
	var data = new FormData();
	data.append('fetch_client_list',1);
	data.append('client_status',$('#active_client_status').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	data.append('agent_id',$('#selected_agent').val());
	
	data.append('from_day',$('#selected_from_day').val());
	data.append('from_month',$('#selected_from_month').val());
	data.append('from_year',$('#selected_from_year').val());	
	data.append('to_day',$('#selected_to_day').val());
	data.append('to_month',$('#selected_to_month').val());
	data.append('to_year',$('#selected_to_year').val());
	data.append('date_basis',$('#selected_date_basis').val());
	
	data.append('search_key',$('#client_search_key').val());
	data.append('account_status',$('#account_status').val());
	data.append('status_category',$('#selected_status_category').val());
	data.append('client_active_status',$('#client_active_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('client_list_holder','Fetching data. Please wait...');
}

function fetch_client_details(client_id,form_ind){
	var data = new FormData();
	data.append('fetch_client_details',1);
	data.append('client_id',client_id);
	data.append('client_status',$('#active_client_status').val());
	data.append('form_ind',form_ind);
	show_window('item_details',1);
	//change_window_size('item_details',400,500,1);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Preparing. One moment...');
	$('#item_details_title').html('PrEP Client Account <div style="font-size:0.7em;width:30px;text-align:center;cursor:pointer;line-height:30px;float:right;background-color:#22c4db" onmouseover="this.style.backgroundColor=\'#41d8ee\';" onmouseout="this.style.backgroundColor=\'#22c4db\';" onclick="$(\'#checklists\').slideToggle(\'fast\');" title="Click to show or hide checklist docker">&#10003..</div>');
	$('#item_details_title_bar').css('background-color','#9e269e');
	
	$('#details_close_button').attr('onclick',"close_window('item_details');");
}

function fetch_dynamic_form(form_id){
	var data = new FormData();
	data.append('fetch_dynamic_form',1);
	data.append('form_id',form_id);
	show_window('item_details',1);
	change_window_size('item_details',850,500,1);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Preparing. One moment...');
	$('#item_details_title').html('Dynamic Form Details');
	$('#item_details_title_bar').css('background-color','#9e269e');
	
}

function complete_assessment(){
	$('#tab_11').click();	
};

function create_or_update_client(){
	if($('#client_profile_button').html() != 'Wait...'){
		var error = 0;
		if($('#client_screening_validated').val() == 1){
			if($('#client_name').val() == '' || $('#client_name').val() == 'Enter client name here'){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('You need to provide the client name');
				$('#client_name').css('border-color','red');
				
				error = 1;
				
			}else if($('#client_phone').val() == '' || $('#client_phone').val() == 'Enter phone number here'){			
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('Please enter phone number for this client');
				$('#client_phone').css('border-color','red');
				
				error = 1;
				
			}else if($('#client_nrc').val() == '' || $('#client_nrc').val() == 'Enter NRC here'){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('Enter client NRC');
				$('#client_nrc').css('border-color','red');
				
				error = 1;			
				
			}else if($('#client_age').val() == '' || $('#client_age').val() == 'Enter age here'){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('Enter client age');
				$('#client_age').css('border-color','red');
				
				error = 1;
				
			}else if($('#client_selected_sex').val() == '0'){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('Select sex');			
				
				error = 1;
				
			}else if($('#selected_client_region').val() == -1 || $('#selected_client_province').val() == 0 || $('#selected_client_hub').val() == 0 || $('#selected_client_site').val() == 0){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('You need to select the site location for which this client will be registered');			
				
				error = 1;			
				
			}else if($('#selected_client_province').val() == 0){
				$('#new_client_error_message').slideDown('fast');
				$('#new_client_error_message').html('You need to select the site location for which this client will be registered');			
				
				error = 1;
			}
		}
		
		if(!error){
			var data = new FormData();
			data.append('create_or_update_client',1);
			data.append('tmp_client_id',$('#tmp_client_id').val());
			data.append('client_id',$('#client_id').val());
			data.append('screening_score',$('#total_score').val());
			data.append('client_name',$('#client_name').val());
			data.append('client_phone',$('#client_phone').val());
			data.append('client_nrc',$('#client_nrc').val());
			data.append('client_age',$('#client_age').val());
			data.append('client_email',$('#client_email').val());
			data.append('client_sex',$('#client_selected_sex').val());
			data.append('region_id',$('#selected_client_region').val());
			data.append('province_id',$('#selected_client_province').val());
			data.append('hub_id',$('#selected_client_hub').val());
			data.append('site_id',$('#selected_client_site').val());
			data.append('agent_id',$('#selected_client_agent').val());
			data.append('status_id',$('#selected_profile_client_status').val());
			data.append('population_category_id',$('#selected_population_category').val());
			data.append('implementing_partner_id',$('#selected_implementing_partner').val());
			data.append('knowledge_source_id',$('#selected_knowledge_source').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#client_profile_button').html('Wait...');
		}
	}
}

function populate_profile_data(){
	var data = new FormData();
	data.append('populate_profile_data',1);
	data.append('client_id',$('#client_id').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#client_name').val('Fetching. Wait...');
	document.getElementById('client_name').disabled = false;
	
	$('#client_phone').val('Fetching. Wait...');
	document.getElementById('client_phone').disabled = false;
}


function add_form_category(){
	var div_code = $('#default_field_holder').html();
	
	var total_categories = Number($('#total_categories').val());
	
	div_code =div_code.replace(/catind/g,total_categories);
	div_code =div_code.replace(/opind/g,0);
	
	$('#form_categories_holder').append(div_code);
	
	$('#category_ordering_'+total_categories).val(total_categories+1);
	
	total_categories++;
	
	$('#total_categories').val(total_categories);
	
}

function add_form_option(category_ind,option_ind){
	var div_code = $('#category_option_holder_catind').html();
	
	var total_options = Number($('#total_category_options_'+category_ind).val());
	
	div_code =div_code.replace(/catind/g,category_ind);
	div_code =div_code.replace(/opind/g,total_options);
	
	total_options++;
	div_code = div_code.replace('Option 1','Option '+total_options);
	
	$('#category_option_holder_'+category_ind).append(div_code);
	$('#category_option_ordering_'+category_ind+'_'+(total_options-1)).val(total_options);
	
	$('#add_option_button_'+category_ind+'_'+(option_ind)).slideUp('fast');
	
	
	
	$('#total_category_options_'+category_ind).val(total_options);
}

function add_checklist_option(category_ind){
	var div_code = $('#category_option_holder_catind').html();
	
	var total_options = Number($('#total_category_options_'+category_ind).val());
	
	div_code =div_code.replace(/catind/g,category_ind);
	div_code =div_code.replace(/opind/g,total_options);
	
	total_options++;
	div_code = div_code.replace('Activity 1','Activity '+total_options);
	
	$('#category_option_holder_'+category_ind).append(div_code);
	$('#category_option_ordering_'+category_ind+'_'+(total_options-1)).val(total_options);
	
	
	$('#total_category_options_'+category_ind).val(total_options);
}

function disable_or_enable_form_cateory(category_ind){
	var total_options = $('#total_category_options_'+category_ind).val();
	
	if($('#category_active_'+category_ind).val() == 1){
		$('#category_active_'+category_ind).val(0);
		document.getElementById('category_title_'+category_ind).disabled = true;
		document.getElementById('category_ordering_'+category_ind).disabled = true;
		document.getElementById('category_header_txt_'+category_ind).disabled = true;
		document.getElementById('category_footer_txt_'+category_ind).disabled = true;
	
		for(var o=0;o<total_options;o++){
			document.getElementById('category_option_title_'+category_ind+'_'+o).disabled = true;
			document.getElementById('category_option_ordering_'+category_ind+'_'+o).disabled = true;
			$('#category_option_active_'+category_ind+'_'+o).val(0);
		}
		
		$('#add_option_button_'+category_ind+'_'+(total_options-1)).slideUp('fast')
	
	}else{
		$('#category_active_'+category_ind).val(1);
		document.getElementById('category_title_'+category_ind).disabled = false;
		document.getElementById('category_ordering_'+category_ind).disabled = false;
		document.getElementById('category_header_txt_'+category_ind).disabled = false;
		document.getElementById('category_footer_txt_'+category_ind).disabled = false;
		
		for(var o=0;o<total_options;o++){
			document.getElementById('category_option_title_'+category_ind+'_'+o).disabled = false;
			document.getElementById('category_option_ordering_'+category_ind+'_'+o).disabled = false;
			$('#category_option_active_'+category_ind+'_'+o).val(1);
		}
		
		$('#add_option_button_'+category_ind+'_'+(total_options-1)).slideDown('fast')
	}
}


function disable_or_enable_option(category_ind,o){
	if($('#category_option_active_'+category_ind+'_'+o).val() == 1){
		document.getElementById('category_option_title_'+category_ind+'_'+o).disabled = true;
		document.getElementById('category_option_ordering_'+category_ind+'_'+o).disabled = true;
		$('#category_option_active_'+category_ind+'_'+o).val(0);
		
		if(o+1 == Number($('#total_category_options_'+category_ind).val())){
			$('#add_option_button_'+category_ind+'_'+o).slideUp('fast')
			
		}	
	
	}else{
		document.getElementById('category_option_title_'+category_ind+'_'+o).disabled = false;
		document.getElementById('category_option_ordering_'+category_ind+'_'+o).disabled = false;
		$('#category_option_active_'+category_ind+'_'+o).val(1);
		
		if(o+1 == Number($('#total_category_options_'+category_ind).val())){
			$('#add_option_button_'+category_ind+'_'+o).slideDown('fast')
			
		}	
	}
}


function create_or_edit_dynamic_form(form_id){
	if($('#create_or_edit_dynamic_form_button').html() != 'Wait...'){
		if($('#dynamic_form_title').val() == 'Enter form title here' || $('#dynamic_form_title').val() == 'Enter form title here'){
			$('#new_dynamic_form_error_message').slideDown('fast');
			$('#new_dynamic_form_error_message').html('Enter the form name');
			$('#dynamic_form_title').css('border-color','red');
			
		}else if($('#total_categories').val() == 0){
			$('#new_dynamic_form_error_message').slideDown('fast');
			$('#new_dynamic_form_error_message').html('You need to add at-least one form data category');

		}else{
			var total_categories = $('#total_categories').val();
			
			
			var error = 0;		
			for(var c=0;c<total_categories;c++){
				if($('#category_active_'+c).val() == 1 && ($('#category_title_'+c).val() == 'Enter title here' || $('#category_title_'+c).val() == '')){
					$('#category_title_'+c).css('border-color','red');
					error = 1;
				}			
				
				var total_options = $('#total_category_options_'+c).val();
							
				for(var o=0;o<total_options;o++){
					if($('#category_option_active_'+c+'_'+o).val() == 1 && ($('#category_option_title_'+c+'_'+o).val() == 'Enter title here' || $('#category_option_title_'+c+'_'+o).val() == '')){
						$('#category_option_title_'+c+'_'+o).css('border-color','red');
						error = 1;					
					}
				}
			}
			
			if(error){
				$('#new_dynamic_form_error_message').slideDown('fast');
				$('#new_dynamic_form_error_message').html('Please check and ensure that you have filled in the highlighted fields');
				
			}else{
				var data = new FormData();
				data.append('create_or_edit_dynamic_form',1);
				data.append('form_id',form_id);
				data.append('form_title',$('#dynamic_form_title').val());
				data.append('branch_id',$('#dynamic_form_branch_id').val());
				data.append('description',$('#dynamic_form_description').val());
				data.append('form_order',$('#dynamic_form_order').val());
				data.append('custom_script',$('#dynamic_form_custom_script').val());
				data.append('dependencies',$('#form_dependecies').val());
				data.append('data_processing_method',$('#data_processing_method').val());
				data.append('status_change_id',$('#selected_form_status_change').val());
				data.append('form_status',$('#dynamic_form_status').val());
				data.append('messaging_schedule_id',$('#selected_messaging_schedule_id').val());
				
				data.append('total_categories',total_categories);
				for(var c=0;c<total_categories;c++){
					data.append('category_active_'+c,$('#category_active_'+c).val());
					data.append('category_id_'+c,$('#category_id_'+c).val());
					data.append('category_title_'+c,$('#category_title_'+c).val())
					data.append('category_ordering_'+c,$('#category_ordering_'+c).val());
					data.append('category_header_text_'+c,$('#category_header_txt_'+c).val());
					data.append('category_footer_text_'+c,$('#category_footer_txt_'+c).val());
					data.append('category_necessity_'+c,$('#category_option_necessity_'+c).val());
					data.append('category_default_option_'+c,$('#default_category_option_'+c).val());
					
					var total_options = $('#total_category_options_'+c).val();
					data.append('total_options_'+c,$('#total_category_options_'+c).val());
					for(var o=0;o<total_options;o++){
						data.append('category_option_active_'+c+'_'+o,$('#category_option_active_'+c+'_'+o).val());
						data.append('category_option_id_'+c+'_'+o,$('#category_option_id_'+c+'_'+o).val());
						data.append('category_option_title_'+c+'_'+o,$('#category_option_title_'+c+'_'+o).val());
						data.append('category_option_ordering_'+c+'_'+o,$('#category_option_ordering_'+c+'_'+o).val());
						data.append('category_option_type_'+c+'_'+o,$('#category_option_type_'+c+'_'+o).val());
						data.append('category_option_days_before_'+c+'_'+o,$('#days_before_date_due_'+c+'_'+o).val());
						data.append('category_option_schedule_message_'+c+'_'+o,$('#schedule_message_'+c+'_'+o).val());
					}
				}
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				
				$('#create_or_edit_dynamic_form_button').html('Wait...');
			}
		}
	}
}

function create_or_edit_dynamic_checklist(checklist_id){
	if($('#create_or_edit_dynamic_checklist_button').html() != 'Wait...'){
		if($('#dynamic_form_checklist').val() == 'Enter form title here' || $('#dynamic_checklist_title').val() == 'Enter checklist title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter the checklist title');
			$('#dynamic_checklist_title').css('border-color','red');
			
		}else if($('#total_categories').val() == 0){
			$('#new_dynamic_form_error_message').slideDown('fast');
			$('#new_dynamic_form_error_message').html('You need to add at-least one form data category');

		}else{
			var total_categories = $('#total_categories').val();
			
			
			var error = 0;	
			var option_error = 1;
			var category_error = 1;			
			for(var c=0;c<total_categories;c++){
				if($('#category_active_'+c).val() == 1 && ($('#category_title_'+c).val() == 'Enter title here' || $('#category_title_'+c).val() == '')){
					$('#category_title_'+c).css('border-color','red');
					error = 1;
					
				}else if($('#category_active_'+c).val() == 1){
					category_error = 0;
					
				}
				
				
				var total_options = $('#total_category_options_'+c).val();
							
				for(var o=0;o<total_options;o++){
					if($('#category_option_active_'+c+'_'+o).val() == 1 && ($('#category_option_title_'+c+'_'+o).val() == 'Enter title here' || $('#category_option_title_'+c+'_'+o).val() == '')){
						$('#category_option_title_'+c+'_'+o).css('border-color','red');
						error = 1;		
					}
					
					if($('#category_option_active_'+c+'_'+o).val() == 1 && ($('#category_description_'+c+'_'+o).val() == 'Enter text here' || $('#category_description_'+c+'_'+o).val() == '')){
						$('#category_description_'+c+'_'+o).css('border-color','red');
						error = 1;		
					
					}else if($('#category_option_active_'+c+'_'+o).val() == 1){
						option_error = 0;
						
					}
					
				}
			}
			
			if(error){
				$('#error_message').slideDown('fast');
				$('#error_message').html('Please check and ensure that you have filled in the highlighted fields');
				
			}else if(category_error || option_error){
				$('#error_message').slideDown('fast');
				$('#error_message').html('Please ensure that you have added atleast one active activity and category');
				
				
			}else{
				var data = new FormData();
				data.append('create_or_edit_dynamic_checklist',1);
				data.append('checklist_id',checklist_id);
				data.append('checklist_title',$('#dynamic_checklist_title').val());
				data.append('branch_id',$('#dynamic_checklist_branch_id').val());
				data.append('description',$('#dynamic_checklist_description').val());
				data.append('dependencies',$('#checklist_dependecies').val());
				data.append('data_processing_method',$('#data_processing_method').val());
				data.append('form_linkage_id',$('#form_linkage_id').val());
				
				data.append('total_categories',total_categories);
				for(var c=0;c<total_categories;c++){
					data.append('category_active_'+c,$('#category_active_'+c).val());
					data.append('category_id_'+c,$('#category_id_'+c).val());
					data.append('category_title_'+c,$('#category_title_'+c).val())
					data.append('category_ordering_'+c,$('#category_ordering_'+c).val());
										
					var total_options = $('#total_category_options_'+c).val();
					data.append('total_options_'+c,$('#total_category_options_'+c).val());
					for(var o=0;o<total_options;o++){
						data.append('category_option_active_'+c+'_'+o,$('#category_option_active_'+c+'_'+o).val());
						data.append('category_option_id_'+c+'_'+o,$('#category_option_id_'+c+'_'+o).val());
						data.append('category_option_title_'+c+'_'+o,$('#category_option_title_'+c+'_'+o).val());
						data.append('category_option_ordering_'+c+'_'+o,$('#category_option_ordering_'+c+'_'+o).val());
						data.append('category_option_necessity_'+c+'_'+o,$('#category_option_necessity_'+c+'_'+o).val());
						data.append('category_option_description_'+c+'_'+o,$('#category_description_'+c+'_'+o).val());
					}
				}
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				
				$('#create_or_edit_dynamic_checklist_button').html('Wait...');
			}
		}
	}
}

function create_or_update_client_screening(tmp_client_id,client_id,questionnaire_id,score){
	var data = new FormData();
	data.append('create_or_update_client_screening',1);
	data.append('client_id',client_id);
	data.append('prep_area',general_variable_0);
	data.append('tmp_client_id',tmp_client_id);
	data.append('questionnaire_id',questionnaire_id);
	data.append('screening_score',score);
	
	data.append('client_name',$('#screening_client_name').val());
	data.append('client_phone',$('#screening_client_phone').val());
		
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#result_status').html('Saving results....');
	$('#result_status').slideDown('fast');
}

function validate_dynamic_form(form_id){
	var category_string = $('#category_id_string_'+form_id).val();
	var category_array = category_string.split(',');
	
	var error_found = 0;
	
	for(var c =0;c<category_array.length;c++){
		
		if($('#category_option_'+category_array[c]+'_required').val() == 1){
			var category_option_string = $('#cagetory_option_id_string_'+category_array[c]).val();
			var category_option_array = category_option_string.split(',');
			
			active_option_found = 0;
			for(var o=0;o<category_option_array.length;o++){
				if($('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_value').val() != ''){
					active_option_found  = 1;
					
					//alert($('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_value').val());
				}
			}

			if(!active_option_found){
				$('#category_title_'+category_array[c]).css('background-color','brown');				
				$('#category_title_'+category_array[c]).css('color','fff');				
				error_found = 1;
				
			}else{
				$('#category_title_'+category_array[c]).css('background-color','');
				$('#category_title_'+category_array[c]).css('color','#536a01');	
				
			}
		}
	}
	
	return error_found;
}


function create_or_update_client_form(form_id,form_ind){
	var form_validation = validate_dynamic_form(form_id);
	
	var dependencies_passed = 1;
	var dependecies_titles = '';
	if($('#form_dependencies_'+form_id).val() != ''){
		var form_dependecies_string = $('#form_dependencies_'+form_id).val();
		var form_dependecies_array = form_dependecies_string.split(',');		
		
		for(var f=0;f<form_dependecies_array.length;f++){			
			if($('#dynamic_form_validated_'+form_dependecies_array[f]).val() == 0){
				dependencies_passed = 0;
				
				if(dependecies_titles == ''){
					dependecies_titles = $('#dynamic_form_title_'+form_dependecies_array[f]).val();
					
				}else{
					dependecies_titles = dependecies_titles+', '+$('#dynamic_form_title_'+form_dependecies_array[f]).val();
					
				}
			}			
		}
	}

	if(!dependencies_passed){
		alert('To save this form, you first need to fill in and save the following form\s: '+dependecies_titles);
		
	}else{
		if(form_validation){
			alert('Please check and ensure that the mandatory fields (highlighted in brown) are not left unspecified');
			
		}else{
			var data = new FormData();
			data.append('create_or_update_client_form',1);
			data.append('client_id',$('#client_id').val());
			data.append('form_id',form_id);
			data.append('form_ind',form_ind);
			data.append('category_string',$('#category_id_string_'+form_id).val());
			data.append('processing_method',$('#form_data_processing_method_'+form_id).val());
			
			var category_string = $('#category_id_string_'+form_id).val();
			var category_array = category_string.split(',');
			
			for(var c =0;c<category_array.length;c++){
				data.append('category_option_string_'+category_array[c],$('#cagetory_option_id_string_'+category_array[c]).val());
				
				var category_option_string = $('#cagetory_option_id_string_'+category_array[c]).val();
				var category_option_array  = category_option_string.split(',');
				
				for(var o=0;o<category_option_array.length;o++){
					data.append('category_option_'+category_array[c]+'_'+category_option_array[o]+'_value',$('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_value').val());
					data.append('category_option_'+category_array[c]+'_'+category_option_array[o]+'_type',$('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_type').val());
					data.append('category_option_schedule_message_'+category_array[c]+'_'+category_option_array[o],$('#category_option_schedule_message_'+category_array[c]+'_'+category_option_array[o]).val());
					data.append('category_option_schedule_days_'+category_array[c]+'_'+category_option_array[o],$('#category_option_schedule_days_'+category_array[c]+'_'+category_option_array[o]).val());
					
					if($('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_type').val() == 3 || $('#category_option_'+category_array[c]+'_'+category_option_array[o]+'_type').val() == 4){
						
						data.append('category_option_'+category_array[c]+'_'+category_option_array[o]+'_day',$('#form_field_day_value_'+category_array[c]+'_'+category_option_array[o]).val());
						
						data.append('category_option_'+category_array[c]+'_'+category_option_array[o]+'_month',$('#form_field_month_value_'+category_array[c]+'_'+category_option_array[o]).val());
						
						data.append('category_option_'+category_array[c]+'_'+category_option_array[o]+'_year',$('#form_field_year_value_'+category_array[c]+'_'+category_option_array[o]).val());
						
					}
				}
			}

			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#client_form_button_'+form_id).html('Wait...');
		}
	}
}



function fetch_activity_list(){
	fetch_script('_codes/activity_list.php?a=6','locations');
}

function fetch_activity_list_code(){
	var data = new FormData();
	
	data.append('fetch_activity_list_code',1);
	data.append('unit_id',$('#selected_unit').val());
	data.append('status',$('#selected_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('activity_list','Fetching data. Please wait...');
}

function fetch_unit_list(){
	fetch_script('_codes/unit_list.php?a=5','locations');
}

function fetch_unit_list_code(){
	var data = new FormData();
	
	data.append('fetch_unit_list_code',1);
	data.append('status',$('#selected_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('unit_list','Fetching data. Please wait...');
}

function update_or_create_activity(activity_id){
	if($('#update_or_create_activity_button').html() != 'Wait...'){
		
		if($('#activity_title').val() == 'Enter activity title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter title for this activity');
			$('#activity_title').css('border-color','red');
			
		}else if($('#activity_sms_code').val() == 'Enter SMS code here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter SMS code');
			$('#activity_sms_code').css('border-color','red');
			
		}else if($('#activity_ussd_code').val() == 'Enter USSD code here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter USSD code');
			$('#activity_ussd_code').css('border-color','red');
			
		}else if($('#selected_activity_unit').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to select a unit');
			
		}else{
			var data = new FormData();
			data.append('update_or_create_activity',1);
			data.append('activity_id',activity_id);
			data.append('title',$('#activity_title').val());
			data.append('max_value',$('#activity_max_value').val());
			data.append('sms_code',$('#activity_sms_code').val());
			data.append('ussd_code',$('#activity_ussd_code').val());
			data.append('_order',$('#activity_ussd_ordering').val());
			data.append('unit_id',$('#selected_activity_unit').val());
			data.append('branch_ids',$('#selected_activity_clusters').val());
			data.append('agent_type_ids',$('#selected_activity_agent_types').val());
			data.append('warnings',$('#selected_activity_warnings').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#update_or_create_activity_button').html('Wait...');
			$('#activity_status_change_button').html('Wait...');
		}
	}
}

function enable_or_disable_activity(activity_id,new_status){
	if($('#activity_status_change_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('enable_or_disable_activity',1);
		data.append('activity_id',activity_id);
		data.append('new_status',new_status);
	
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#activity_status_change_button').html('Wait...');
		$('#update_or_create_activity_button').html('Wait...');
	
	}
}

function update_or_create_unit(unit_id){
	if($('#update_or_create_unit_button').html() != 'Wait...'){
		
		if($('#unit_title').val() == 'Enter unit title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter title for this unit');
			$('#unit_title').css('border-color','red');
			
		}else if($('#unit_sms_code').val() == 'Enter SMS code here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter SMS code');
			$('#unit_sms_code').css('border-color','red');
			
		}else if($('#unit_ussd_code').val() == 'Enter USSD code here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter USSD code');
			$('#unit_ussd_code').css('border-color','red');
			
		}else{		
			var data = new FormData();
			data.append('update_or_create_unit',1);
			data.append('unit_id',unit_id);
			data.append('title',$('#unit_title').val());
			data.append('sms_code',$('#unit_sms_code').val());
			data.append('ussd_code',$('#unit_ussd_code').val());
			data.append('ussd_ordering',$('#unit_ussd_ordering').val());
			data.append('branch_ids',$('#selected_unit_clusters').val());
			data.append('agent_types',$('#selected_unit_agent_types').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#update_or_create_unit_button').html('Wait...');
			$('#unit_status_change_button').html('Wait...');
		
		}
	}
}

function enable_or_disable_unit(activity_id,new_status){
	if($('#unit_status_change_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('enable_or_disable_unit',1);
		data.append('unit_id',activity_id);
		data.append('new_status',new_status);
	
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#unit_status_change_button').html('Wait...');
		$('#update_or_create_unit_button').html('Wait...');
	
	}
}

function fetch_checklist(checklist_id){
	if($('#active_checklist_id').val() == checklist_id){
		$('#checklist_details_'+$('#active_checklist_id').val()).slideUp('fast');
		
		$('#checklist_title_'+$('#active_checklist_id').val()).css('background-color','');
		$('#checklist_title_'+$('#active_checklist_id').val()).attr('onmouseover','#eee');
		$('#checklist_title_'+$('#active_checklist_id').val()).attr('onmouseout','');
		
		$('#active_checklist_id').val(0);
		
	}else{
		var data = new FormData();
		data.append('fetch_checklist',1);
		data.append('checklist_id',checklist_id);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		if($('#active_checklist_id').val() != 0){
			$('#checklist_details_'+$('#active_checklist_id').val()).slideUp('fast');
			
			$('#checklist_title_'+$('#active_checklist_id').val()).css('background-color','');
			$('#checklist_title_'+$('#active_checklist_id').val()).attr('onmouseover','#eee');
			$('#checklist_title_'+$('#active_checklist_id').val()).attr('onmouseout','');
			
		}
		
		$('#checklist_title_'+checklist_id).css('background-color','#dcf7fb');
		$('#checklist_title_'+checklist_id).attr('onmouseover','#cbf3f9');
		$('#checklist_title_'+checklist_id).attr('onmouseout','#dcf7fb');
		
		$('#checklist_details_'+checklist_id).slideDown('fast');	
		$('#checklist_details_'+checklist_id).html('<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;margin-top:20px;text-align:center;">Preparing list...</div>');
		
		$('#active_checklist_id').val(checklist_id);
	}
}

function search_checklist_clients(checklist_id){
	if($('#checklist_client_search_input').val() == 'Enter name, ID or phone' || $('#checklist_client_search_input').val() == ''){
		alert('Enter client name, client ID, prep ID or phone number in the search field');
		
	}else{
		var data = new FormData();
		data.append('search_checklist_clients',1);
		data.append('checklist_id',checklist_id);
		data.append('search_key',$('#checklist_client_search_input').val());
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		$('#checklist_client_search_results').html('<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;margin-top:20px;text-align:center;">Fetching. Wait...</div>');
		
		$('#checklist_client_search_results_holder_'+checklist_id).slideDown('fast');
	}
}

function disable_or_enable_dynamic_form(form_id,new_form_status){
	if($('#disable_or_enable_form_button_1').html() != 'Wait...'){
		var data = new FormData();
		data.append('disable_or_enable_dynamic_form',1);
		data.append('form_id',form_id);
		data.append('new_form_status',new_form_status);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#disable_or_enable_form_button_1').html('Wait...');
		$('#disable_or_enable_form_button_0').html('Wait...');
	}
}

function expand_or_collapse_checklist(){
	if($('#checklist_expaded').val() == 0){
		
		$('#checklists').css('position','absolute');
		
		change_window_size('checklists',800,500,1);
		$('#checklist_expaded').val(1);
		
	}else{
		$('#checklists').css('width','300px');
		$('#checklists').css('position','fixed');
		$('#checklists').css('left','');
		$('#checklists').css('right','5px');
		$('#checklists').css('margin-top','0px');
		$('#checklist_expaded').val(0);
	}
}

function fetch_screening_results(questionnaire_id,client_id){
	var data = new FormData();
	data.append('fetch_screening_results',1);
	data.append('questionnaire_id',questionnaire_id);
	data.append('client_id',client_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('screen_data_holder','Loading. Please wait...');
}

function create_or_update_checklist(checklist_id){
	if($('#selected_checklist_client_'+checklist_id).val() == -1){
		$('#checklist_error_message').slideDown('fast');
		$('#checklist_error_message').html('You need to select a client for which this checklist is being applied');
		
	}else if($('#selected_checklist_client_'+checklist_id).val() == 0 && $('#client_id').val() == 0){
		$('#checklist_error_message').html('You have not yet completed the client profile. Please complete that before saving this checklist');
		
	}else{
		var data = new FormData();
		data.append('create_or_update_checklist',1);
		data.append('checkklist_id',checklist_id);
		data.append('client_id',client_id);
		
		data.append('category_ids',$('#category_ids_'+checklist_id).val());
		
		var category_ids = $('#category_ids_'+checklist_id).val();
		var category_id_array = category_ids.split(',');
		
		for(var c =0;c<category_id_array.length;c++){
			var this_category_id = category_id_array[c];
			var category_option_ids = $('#category_option_ids_'+checklist_id+'_'+this_category_id).val();
			
			data.append('category_option_ids_'+this_category_id,category_option_ids);
			
			var category_option_array = category_option_ids.split(',');
			
			for(var o=0;o<category_option_array.length;o++){
				var this_option_id = category_option_array[o];
				data.append('category_option_value_'+this_option_id,$('#checklist_input_value_'+checklist_id+'_'+this_category_id+'_'+this_option_id).val());
			}			
		}

		process_simultanious_xmlhttp('module_xmlhttp',data);
		$('#checklist_save_button_'+checklist_id).html('Wait...');
	}
}

function delete_prep_data_set(data_set_id,client_id){
	if($('#prep_dadta_set_delete_button_'+data_set_id).html() != 'Wait...'){		
		var c = confirm('Are you sure you wish to delete this questionnaire answer data set? This action cannot be undone');
		
		if(c){		
			var data = new FormData();
			data.append('delete_prep_data_set',1);
			data.append('data_set_id',data_set_id);
			data.append('client_id',client_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#prep_dadta_set_delete_button_'+data_set_id).html('Wait...');
			$('#questionnaire_data_set_results_'+data_set_id).slideUp('fast');
			$('#questionnaire_data_set_title_'+data_set_id).html('Deleting. Wait...');
		}
	}
}

function delete_prep_form_data_set(data_set_id,client_id){
	if($('#prep_form_data_set_delete_button_'+data_set_id).html() != 'Wait...'){		
		var c = confirm('Are you sure you wish to delete this form data set for this client? This action cannot be undone');
		
		if(c){		
			var data = new FormData();
			data.append('delete_prep_form_data_set',1);
			data.append('data_set_id',data_set_id);
			data.append('client_id',client_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#prep_form_data_set_delete_button_'+data_set_id).html('Wait...');
			$('#historic_data_holder_'+data_set_id).slideUp('fast');
			$('#histori_data_title_'+data_set_id).html('Deleting. Wait...');
		}
	}
}

function fetch_scheduler(scheduler_id){
	show_window('item_details',1);
	
	if(scheduler_id){
		change_window_size('item_details',950,500,1);
	
	}else{
		change_window_size('item_details',450,400,1);
		
	}
	
	show_loading_progress('item_details_holder','Preparing. Wait...');
	
	var data = new FormData();
	data.append('fetch_scheduler',1);
	data.append('scheduler_id',scheduler_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function create_or_update_prep_scheduler(scheduler_id){
	var data = new FormData();
	data.append('create_or_update_prep_scheduler',1);
	data.append('scheduler_id',scheduler_id);
	
	data.append('title',$('#schedule_title').val());
	data.append('schedule_type',$('#selected_schedule_type').val());
	data.append('schedule_days',$('#schedule_days').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#cheduler_update_button').html('Wait...');
	
}

function fetch_schedule_message(scheduler_id,day){
	var data = new FormData();
	data.append('fetch_schedule_message',1);
	data.append('scheduler_id',scheduler_id);
	data.append('day',day);
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_window('message_editior_details',1);	
	show_loading_progress('message_editior_details_holder','Preparing. Please wait...');
	
	$('#message_editior_title').html('Day '+day+' settings');
}


function create_or_update_prep_scheduler_message(scheduler_id,day){
	
	var data = new FormData();
	data.append('create_or_update_prep_scheduler_message',1);
	data.append('scheduler_id',scheduler_id);
	data.append('day',day);
	data.append('entry_message',$('#entry_message').val());
	data.append('hour',$('#selected_entry_hour').val());
	data.append('minute',$('#selected_entry_min').val());
	data.append('sec',$('#selected_entry_sec').val());
	
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#scheduler_massage_update_button').html('Wait...');
}

function export_prep_clients(client_status,type){	
	var data = new FormData();
	data.append('export_prep_clients',1);
	data.append('client_status',client_status);
	
	data.append('from_day',$('#selected_from_day').val());
	data.append('from_month',$('#selected_from_month').val());
	data.append('from_year',$('#selected_from_year').val());	
	data.append('to_day',$('#selected_to_day').val());
	data.append('to_month',$('#selected_to_month').val());
	data.append('to_year',$('#selected_to_year').val());
	data.append('date_basis',$('#selected_date_basis').val());
	
	
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('agent_id',$('#selected_agent').val());
	data.append('site_id',$('#selected_site').val());
	data.append('type',type);
	data.append('search_key',$('#client_search_key').val());
	data.append('account_status',$('#account_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#client_export_button').html('Wait...');
	//window.open($('#url').val()+'/prep_export.php?client_status='+$('#active_client_status').val()+'&date_from='+$('#date_from').val()+'&date_to='+$('#date_to').val()+'&region_id='+$('#selected_region').val()+'&province_id='+$('#selected_province').val()+'&hub_id='+$('#selected_hub').val()+'&site_id='+$('#selected_site').val()+'&agent_id='+$('#selected_agent').val(),'prep_export');
}

function generate_decryption_key(){
	if($('#generate_key').html() != 'Wait...'){
		var data = new FormData();
		data.append('generate_decryption_key',1);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#generate_key').html('Wait...');
	}
}

function validate_key(){
	if($('#code_validate_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('validate_key',1);
		data.append('key_code',$('#dencryption_key').val());
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		$('#code_validate_button').html('Wait...');
	}
}

function delete_file(file_name){
	var data = new FormData();
	data.append('delete_file',1);
	data.append('file_name',file_name);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);	
}

function change_client_status(client_id,new_status){
	if($('#client_status_button').html() != 'Wait...'){
		if(new_status == 1){
			var message = 'This will enable this account. Proceed?';
			
		}else{
			var message = 'This will disable this account. Proceed?';
			
		}
		var c = confirm(message);
		
		if(c){
			var data = new FormData();
			data.append('change_client_status',1);
			data.append('client_id',client_id);
			data.append('new_status',new_status);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#client_status_button').html('Wait...');
		}
	}
}

function delete_client(client_id){
	if($('#client_delete_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to delete this account? This action cannot be undone');
		
		if(c){
			var data = new FormData();
			data.append('delete_prep_client',1);
			data.append('client_id',client_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			$('#client_delete_button').html('Wait...');			
		}
	}
}

function export_prep_form_data_set(data_set_id,client_id){
	window.open($('#url').val()+'/prep_pdf_export.php?did='+data_set_id+'&client_id='+client_id,'prep_export');
}

function fetch_prep_category_details(category_id,data_set_id){
	
	var data = new FormData();
	data.append('fetch_prep_category_details',1);
	data.append('category_id',category_id);
	data.append('data_set_id',data_set_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('prep_category_details',1);
	
	show_loading_progress('prep_category_details_holder','Preparing. One moment...');
}

function update_form_category(category_id,data_set_id){
	if($('#update_form_category').html() != 'Wait...'){
		var data = new FormData();
		data.append('update_form_category',1);
		data.append('category_id',category_id);
		data.append('data_set_id',data_set_id);
		
		data.append('category_option_string_'+category_id,$('#update_cagetory_option_id_string_'+category_id).val());
					
		var category_option_string = $('#update_cagetory_option_id_string_'+category_id).val();
		var category_option_array  = category_option_string.split(',');
		
		for(var o=0;o<category_option_array.length;o++){
			data.append('category_option_'+category_id+'_'+category_option_array[o]+'_value',$('#update_category_option_'+category_id+'_'+category_option_array[o]+'_value').val());
			data.append('category_option_'+category_id+'_'+category_option_array[o]+'_type',$('#update_category_option_'+category_id+'_'+category_option_array[o]+'_type').val());
			data.append('category_option_schedule_message_'+category_id+'_'+category_option_array[o],$('#update_category_option_schedule_message_'+category_id+'_'+category_option_array[o]).val());
			data.append('category_option_schedule_days_'+category_id+'_'+category_option_array[o],$('#update_category_option_schedule_days_'+category_id+'_'+category_option_array[o]).val());
			
			if($('#update_category_option_'+category_id+'_'+category_option_array[o]+'_type').val() == 3 || $('#update_category_option_'+category_id+'_'+category_option_array[o]+'_type').val() == 4){
						
				data.append('category_option_'+category_id+'_'+category_option_array[o]+'_day',$('#update_form_field_day_value_'+category_id+'_'+category_option_array[o]).val());
				
				data.append('category_option_'+category_id+'_'+category_option_array[o]+'_month',$('#update_form_field_month_value_'+category_id+'_'+category_option_array[o]).val());
				
				data.append('category_option_'+category_id+'_'+category_option_array[o]+'_year',$('#update_form_field_year_value_'+category_id+'_'+category_option_array[o]).val());
			
			}
		}
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#update_form_category').html('Wait...');
	}	
}

function fetch_role_list(){
	var data = new FormData();
	data.append('fetch_role_list',1);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function fetch_questionnaire_client_identity(questionnaire_id){
	var data = new FormData();
	data.append('fetch_questionnaire_client_identity',1);
	data.append('questionnaire_id',questionnaire_id);
	
	show_loading_progress('screen_data_holder','Loading. Please wait...');
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}


function check_client_location_details(questionnaire_id){
	if($('#client_name_input').val() == '' || $('#client_name_input').val() == 'Enter your names here'){
		$('#client_name_input').css('boder-color','red');
		$('#error_message').slideDown('fast');
		$('#error_message').html('Please enter your names');
				
	}else if($('#client_phone_number_input').val() == '' || $('#client_phone_number_input').val() == '+260'){
		$('#client_phone_number_input').css('boder-color','red');
		$('#error_message').slideDown('fast');
		$('#error_message').html('Enter your phone number. If you dont have a phone, please enter the phone number of the person you live with or mostly found with');
	
	}else{	
		$('#screening_client_phone').val($('#client_phone_number_input').val());
		$('#screening_client_name').val($('#client_name_input').val());
		
		questionnaire_next(questionnaire_id,0,0,0,1,'','')
	}
}

function change_secondary_tabs(tab_index){
	var standard_bg_color = '#aef';
	var standard_hover_color = '#def';
	var standard_text_color = '#000';
	
	var active_tab_text_color = '#fff';
	var active_tab_bg_color = '#aaf';
	var active_tab_hover_color = '#99f';
	
	$('#tab_100').css('background-color',standard_bg_color);
	$('#tab_100').css('color',standard_text_color);
	$('#tab_100').attr('onmouseover',"this.style.backgroundColor='"+standard_hover_color+"'");
	$('#tab_100').attr('onmouseout',"this.style.backgroundColor='"+standard_bg_color+"'");
	
	$('#tab_101').css('color',standard_text_color);
	$('#tab_101').css('background-color',standard_bg_color);
	$('#tab_101').attr('onmouseover',"this.style.backgroundColor='"+standard_hover_color+"'");
	$('#tab_101').attr('onmouseout',"this.style.backgroundColor='"+standard_bg_color+"'");
	
	$('#tab_102').css('color',standard_text_color);
	$('#tab_102').css('background-color',standard_bg_color);
	$('#tab_102').attr('onmouseover',"this.style.backgroundColor='"+standard_hover_color+"'");
	$('#tab_102').attr('onmouseout',"this.style.backgroundColor='"+standard_bg_color+"'");
	
	$('#tab_'+tab_index).css('color',active_tab_text_color);
	$('#tab_'+tab_index).css('background-color',active_tab_bg_color);
	$('#tab_'+tab_index).attr('onmouseover',"this.style.backgroundColor='"+active_tab_hover_color+"'");
	$('#tab_'+tab_index).attr('onmouseout',"this.style.backgroundColor='"+active_tab_bg_color+"'");
}




function process_save_prep_report(report_id){	
	if($('#report_title').val() == 'Enter report title here'){
		$('#save_report_error_message').slideDown('fast');
		$('#save_report_error_message').html('Please enter report title');
		
	}else if($('#selected_user_cluster').val() == -1){
		$('#save_report_error_message').slideDown('fast');
		$('#save_report_error_message').html('Please select a cluster');
		
	}else if($('#selected_report_accessibility_type').val() == 1 && $('#selected_report_group_accessibility').val() == 0){
		$('#save_report_error_message').slideDown('fast');
		$('#save_report_error_message').html('You need to select a user group allowed to access this report');	
	
	}else{
		close_window('item_details_1');
		$('#save_report_error_message').slideUp('fast');

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
			
		}else{
			var data = new FormData();
			if(additional_column_string == ''){
				data.append('rule_string',columns_string);
				
			}else{
				data.append('rule_string',columns_string+','+additional_column_string);
			}
			data.append('process_save_prep_report',1);
			data.append('report_id',report_id);
			data.append('primary_column_type_id',$('#selected_report_primary_column').val());
			data.append('title',$('#report_title').val());
			data.append('cluster_id',$('#selected_user_cluster').val());
			data.append('accessibility_type',$('#selected_report_accessibility_type').val());
			data.append('report_accessibility',$('#selected_report_standard_accessibility').val());
			data.append('group_id',$('#selected_report_group_accessibility').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			$('#save_report_button').html('Wait...');			
		}
	}
}

function fetch_dynamic_form_list(form_id,ignore_form_data){
	$('#client_profile').hide();
	$('#client_screening').hide();
	$('#client_update_holder').slideDown('fast');
	$('#dynamic_form_holder').slideDown('fast');
	
	var dynamic_forms = $('#dynamic_forms').val();
	
	var dynamic_form_array = dynamic_forms.split(',');
	
	for(var i=0;i<dynamic_form_array.length;i++){
		if(dynamic_form_array[i] != form_id){
			$('#dynamic_form_'+dynamic_form_array[i]).hide();	
		}
	}
	
	
	if($('#form_'+form_id+'_active').val() == 1 && ignore_form_data ==0){
		$('#dynamic_form_'+form_id).slideDown('fast');
		
	}else{
		var data = new FormData();
		data.append('fetch_dynamic_form_list',1);
		data.append('form_id',form_id);
		data.append('client_id',$('#client_id').val());
		
		$('#dynamic_form_'+form_id).slideDown('fast');
		show_loading_progress('dynamic_form_'+form_id,'Preparing form. Wait...');
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
	}
}

function fetch_dynamic_form_details(form_id,data_set_id){
	$('#client_profile').hide();
	$('#client_screening').hide();
	$('#client_update_holder').slideDown('fast');
	
	var dynamic_forms = $('#dynamic_forms').val();
	
	var dynamic_form_array = dynamic_forms.split(',');
	
	for(var i=0;i<dynamic_form_array.length;i++){
		$('#dynamic_form_'+dynamic_form_array[i]).hide();	
	}
	
	if($('#dynamic_form_populated_'+form_id).val() == 0){
		var data = new FormData();
		data.append('fetch_dynamic_form_details',1);
		data.append('form_id',form_id);
		data.append('client_id',$('#client_id').val());
		data.append('data_set_id',data_set_id);
		
		$('#dynamic_form_'+form_id).hide();
		show_loading_progress('dynamic_form_'+form_id,'Preparing form. Wait...');
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
	}
	
	$('#dynamic_form_'+form_id).slideDown('fast');
}

function fetch_adherence_agent(){
	if($('#adherence_agent_search_input').val() == 'Search for mobilizer here' || $('#adherence_agent_search_input').val() == ''){
		alert('Enter agent name in the search field');
		
	}else{
		var data = new FormData();
		data.append('fetch_adherence_agent',1);
		data.append('agent_input_field',$('#adherence_agent_search_input').val());
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#adherence_agent_seach').slideDown('fast');
		$('#adherence_agent_search_results').html('Fetching. Please wait...');
	
	}
}

function fetch_basic_details(form_id){
	$('#form_client_name_'+form_id).html($('#client_name').val());
	
	$('#form_client_gender_'+form_id).html($('#active_sex').html());
}

function create_or_update_custom_client_form(form_id,data_set_id){
	$('#custom_form_error_message').slideUp('fast');
	$('#custom_form_error_message').html('');
	form_validation_successful = 0;
	if(form_id == 2){
		
		if($('#selected_locator_day').val() == 0 || $('#selected_locator_month').val() == 0 || $('#selected_locator_year').val() == 0){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Please enter the date appearing on the hard copy');
			$('#locator_date_holder').css('border','solid 1px red');
		
		}else if($('#option_109').val() == '' && $('#option_110').val() == '' && $('#option_111').val() == ''){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('You need to select the entry type');
			$('#entry_type_holder').css('border-color','red');
			
		}else if($('#option_110').val() == 1 && $('#option_110_text').val() == 'Enter facility here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Please enter facility where this client is being transfered from');
			$('#entry_type_holder').css('border-color','red');
			
		/*	
		}else if($('#option_112').val() == '' && $('#option_113').val() == '' && $('#option_114').val() == '' && $('#option_115').val() == ''){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Select marital status for this client');
			$('#entry_type_holder').css('border-color','#888');
			$('#marital_status_holder').css('border-color','red');
			
			
		}else if($('#option_116').val() == '' && $('#option_117').val() == '' && $('#option_118').val() == ''){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Select highest level of education');				
			$('#marital_status_holder').css('border-color','#aaa');
			$('#education_level_holder').css('color','red');
			*/
			
		}else if($('#option_117').val() == 1 && $('#option_117_text').val() == 'Enter highest grade here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter the highest grade for this client');
			$('#education_level_holder').css('color','#000');
			$('#option_117_text').css('border-color','red');
			
		}else if($('#option_119_text').val() == 'Enter house number here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter home address for this client');
			$('#education_level_holder').css('color','#000');
			$('#option_119_text').css('border-color','red');
			
		}else if($('#option_120_text').val() == 'Enter street name here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter street name for this client');
			
			$('#option_119_text').css('border-color','#aaa');
			$('#option_120_text').css('border-color','red');
			
		}else if($('#option_290_text').val() == 'Enter township here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter township and town for this client');
			
			$('#option_120_text').css('border-color','#aaa');
			$('#option_290_text').css('border-color','red');
			
		}else if($('#option_123_text').val() == 'Enter names here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter emergency contact name');
			
			$('#option_290_text').css('border-color','#aaa');
			$('#option_123_text').css('border-color','red');
			
		}else if($('#option_124_text').val() == 'Enter relationship here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter relationship with provided emergency contact');
			
			$('#option_123_text').css('border-color','#aaa');
			$('#option_124_text').css('border-color','red');
			
		}else if($('#option_125_text').val() == 'Enter house number here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter house number for emerrgency contact');
			
			$('#option_124_text').css('border-color','#aaa');
			$('#option_125_text').css('border-color','red');
			
		}else if($('#option_349_text').val() == 'Enter street name here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter street name for provided contact');
			
			$('#option_125_text').css('border-color','#aaa');
			$('#option_349_text').css('border-color','red');
			
		}else if($('#option_350_text').val() == 'Enter township here'){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Enter town and township for provided emergency contact');
			
			$('#option_349_text').css('border-color','#aaa');
			$('#option_350_text').css('border-color','red');
			
		}else{
			form_validation_successful = 1;
		}
		
	}else if(form_id == 3){
		
			
		if($('#selected_initiation_day').val() == 0 || $('#selected_initiation_month').val() == 0 || $('#selected_initiation_year').val() == 0){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Please enter the investigation date as it appears on the hard copy');
			$('#initiation_date_holder').css('border','solid 1px red');
			
			level_1_validation = 0;
			
		}else{		
			level_1_validation = 1;
			if($('#option_357').val() == 1){
				if($('#option_359').val() == '' && $('#option_360').val() == ''){
					$('#custom_form_error_message').slideDown('fast');
					$('#custom_form_error_message').html('You need to select how many people client had sex with');
					$('#number_client_has_sex_with').css('color','red');
					
					level_1_validation = 0;
					
				}else if($('#option_362').val() == 1 && ($('#option_363').val() == '' && $('#option_364').val() == '' && $('#option_365').val() == '' && $('#option_366').val() == '' && $('#option_367').val() == '' && $('#option_368').val() == '')){
					$('#custom_form_error_message').slideDown('fast');
					$('#custom_form_error_message').html('You need to accept at-least one risky behaviour engaged in by client\'s sex partner');
					$('#sex_with_risky_partner').css('color','red');
					
					level_1_validation = 0;
				}
			}
		}
			
		if(level_1_validation){
			if(($('#option_372').val() == '' || $('#option_373').val() == 1) && ($('#option_374').val() ==1 || $('#option_376').val() == 1)){
				
				$('#custom_form_error_message').slideDown('fast');
				$('#custom_form_error_message').html('Check options selected on client\'s partner\'s HIV treatment');
				
				$('#partner_hiv_treatment').css('color','red');
				
			}else{
				form_validation_successful = 1;
				
			}
		}
		
	}else if(form_id == 1){		
		if($('#selected_follow_up_day').val() == 0 || $('#selected_follow_up_month').val() == 0 || $('#selected_follow_up_year').val() == 0){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Please enter the investigation date as it appears on the hard copy');
			$('#follow_up_date_holder').css('border','solid 1px red');
			
		}else{
			form_validation_successful = 1;
			
		}
		
	}else if(form_id == 6){
		if($('#selected_adherence_day').val() == 0 || $('#selected_adherence_month').val() == 0 || $('#selected_adherence_year').val() == 0){
			$('#custom_form_error_message').slideDown('fast');
			$('#custom_form_error_message').html('Please enter the investigation date as it appears on the hard copy');
			$('#adherence_date_holder').css('border','solid 1px red');
			
		}else{
			form_validation_successful = 1;
			
		}
		
	}
		
	if(form_validation_successful){
		var c = confirm('Are you sure you wish to proceed with saving this form?');
		
		if(c){
			var data = new FormData();			
			data.append('create_or_update_custom_client_form',1);
			data.append('form_id',form_id);
			data.append('data_set_id',data_set_id);
			data.append('client_id',$('#client_id').val());
			data.append('form_option_string',$('#form_option_string_'+form_id).val());
			data.append('form_option_type_string',$('#form_option_type_string_'+form_id).val());
			
			var option_id_string = $('#form_option_string_'+form_id).val();
			var option_type_string = $('#form_option_type_string_'+form_id).val();
			var option_id_array = option_id_string.split(',');
			var option_type_array = option_type_string.split(',');
			
			for(var o =0;o<option_id_array.length;o++){
				
				if(option_type_array[o] == 2 && $('#option_'+option_id_array[o]).val() == 1 && $('#option_'+option_id_array[o]+'_text').val() != undefined){
					
					if($('#option_'+option_id_array[o]+'_text').val() == ''){
						form_validation_successful = 0;						
						$('#custom_form_error_message').slideDown('fast');
						$('#custom_form_error_message').html('Provide values for fields highlighted in red');
						$('#option_'+option_id_array[o]+'_text').css('border-color','red');
						$('#option_'+option_id_array[o]+'_title').css('color','red');
						
					}else{
						data.append('option_'+option_id_array[o],$('#option_'+option_id_array[o]+'_text').val());
					}
					
				}else if($('#option_'+option_id_array[o]).val() != undefined){
					data.append('option_'+option_id_array[o],$('#option_'+option_id_array[o]).val());				
					
				}
			}
			
			if(form_validation_successful){
				process_simultanious_xmlhttp('module_xmlhttp',data);
			
				$('#dynamic_form_save_button_'+form_id).html('Wait...');
			}
		}
	}
}

function delete_prep_form(form_id,data_set_id){
	if($('#delete_prep_form_button_'+data_set_id).html() != 'Wait...'){
		
		var c = confirm('Are you sure you wish to delete this form? This action cannot be undone');
		
		if(c){
			var data = new FormData();
			data.append('delete_prep_form',1);
			data.append('data_set_id',data_set_id);
			data.append('form_id',form_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);			
			$('#delete_prep_form_button_'+data_set_id).html('Wait...');
			
		}		
	}	
}

function custom_form_checkbox_activation(field_id){
	if(document.getElementById('field_'+field_id).checked == true){
		$('#option_'+field_id).val(1);
		
	}else{
		$('#option_'+field_id).val('');
		
	}
}

function fetch_questionnaire_ession(session_index,question_index){
	session_index = session_index.replace("_","");
	question_index = question_index.replace("_","");
	
	var total_sessions = Number($('#total_sessions').val());
	
	var session_div = '';
	for(var s=0;s<total_sessions;s++){
		if(s != session_index){
			if(session_div == ''){
				session_div = '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#question_dependency_ession_menu_'+session_index+'_'+question_index+'\').toggle(\'fast\');$(\'#active_question_dependency_ession_'+session_index+'_'+question_index+'\').html($(this).html());$(\'#selected_question_dependency_ession_'+session_index+'_'+question_index+'\').val(0);">Session '+(s+1)+'</div>';

			}else{
				session_div = session_div+'<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#question_dependency_ession_menu_'+session_index+'_'+question_index+'\').toggle(\'fast\');$(\'#active_question_dependency_ession_'+session_index+'_'+question_index+'\').html($(this).html());$(\'#selected_question_dependency_ession_'+session_index+'_'+question_index+'\').val(0);">Session '+(s+1)+'</div>'

			}				
		}
	}
	
	$('#question_dependency_ession_menu_'+session_index+'_'+question_index).html(session_div);
}

function fetch_sms_details(message_id){
	var new_window_index = create_data_window();
	change_window_size('item_details_'+new_window_index,400,500,1);
	show_window('item_details_'+new_window_index);
	
	$('#item_details_holder_'+new_window_index).css('height','450px');
	

	
	$('#details_close_button_'+new_window_index).attr('onclick','close_window(\'item_details_'+new_window_index+'\');$(\'#item_details_'+new_window_index+'\').remove();');
	
	show_loading_progress('item_details_holder_'+new_window_index,'Preparing data. Wait...');
	
	var data = new FormData();
	data.append('fetch_sms_details',1);
	data.append('message_id',message_id);
	data.append('holder_index',new_window_index);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function update_sms_message(message_id){
	if($('#add_to_queue_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to add this message to the queue?');

		if(c){
			if($('#selected_message_type').val() == 1 && $('#selected_sms_group').val() == 0){
				$('#error_message').slideDown('fast');
				$('#error_message').html('You need to select a message group');
				
			}else if($('#selected_message_type').val() == 0 && ($('#sms_to').val() == '260' || $('#sms_to').val() == '')){
				$('#error_message').slideDown('fast');
				$('#error_message').html('You need to enter the receipient phone number');
				
				$('#sms_to').css('border-color','red');
				
			}else if($('#text_message').val() == 'Enter message here' || $('#text_message').val() == ''){
				$('#error_message').slideDown('fast');
				$('#error_message').html('Enter message to send');
				$('#text_message').css('border-color','red');
				
			}else{
				var data = new FormData();
				data.append('update_sms_message',1);
				data.append('holder_index',$('#this_holder_index').val());
				data.append('message_id',message_id);
				data.append('message_type',$('#selected_message_type').val());
				data.append('message_group',$('#selected_sms_group').val());
				data.append('sms_to',$('#sms_to').val());
				data.append('_day',$('#selected_day').val());
				data.append('_month',$('#selected_month').val());
				data.append('_year',$('#selected_year').val());
				data.append('_hour',$('#selected_hour').val());
				data.append('_minute',$('#selected_minute').val());
				data.append('_second',$('#selected_second').val());
				data.append('text_message',$('#text_message').val());
				data.append('message_user_date',$('#selected_user_date').val());
				data.append('module_id',$('#this_sms_module').val());
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				$('#add_to_queue_button').html('Wait...');
			}
		}
	}
}

function delete_sms_message(message_id){
	if($('#delete_sms_button').html() != 'Wait....'){
		var c = confirm('Are you sure you wish to delete this item?');
		
		if(c){
			var data = new FormData();
			data.append('delete_sms_message',1);
			data.append('message_id',message_id);
			data.append('holder_index',$('#this_holder_index').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			$('#delete_sms_button').html('Wait...');		
		}
	}
}

function fetch_sms_clients(){
	var data = new FormData();
	
	data.append('fetch_sms_clients',1);
	data.append('client_branch',$('#selected_branch').val());
	data.append('group_id',$('#selected_sms_group').val());
	data.append('status',$('#selected_sms_status').val());
	data.append('date_from',$('#date_from').val());
	data.append('date_to',$('#date_to').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_loading_progress('ussd_holder','Fetching data. Please wait...');
}


function fetch_sms_client_groups(){
	var data = new FormData();
	data.append('fetch_sms_client_groups',1);
	data.append('group_branch',$('#selected_branch').val());
	data.append('status',$('#selected_group_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_loading_progress('ussd_holder','Fetching data. Please wait...');
}

function fetch_group_details(group_id){
	var new_window_index = create_data_window();
	change_window_size('item_details_'+new_window_index,400,500,1);
	show_window('item_details_'+new_window_index);
	
	$('#item_details_holder_'+new_window_index).css('height','450px');
	
	
	$('#details_close_button_'+new_window_index).attr('onclick','close_window(\'item_details_'+new_window_index+'\');$(\'#item_details_'+new_window_index+'\').remove();');
	
	show_loading_progress('item_details_holder_'+new_window_index,'Preparing data. Wait...');
	
	var data = new FormData();
	data.append('fetch_group_details',1);
	data.append('group_id',group_id);
	data.append('holder_index',new_window_index);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function update_sms_group(group_id){
	if($('#group_update_button').html() != 'Wait...'){
		if($('#group_title').val() == 'Enter title here'){			
			$('#group_title').css('border-color','red');
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to enter the title off this group');
			
		}else if($('#group_description').val() == 'Enter details here'){
			$('#group_description').css('border-color','red');
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter the description of this group');
			
		}else{		
			var c = confirm('Are you sure you wish to proceed?');		
			if(c){
				var data = new FormData();
				data.append('update_sms_group',1);
				data.append('group_id',group_id);
				data.append('group_title',$('#group_title').val());
				data.append('description',$('#group_description').val());
				data.append('branch_id',$('#selected_group_branch').val());
				data.append('window_index',$('#window_index').val());
				data.append('agent_group_ids',$('#selected_agent_group_ids').val());
				
				$('#group_update_button').html('Wait...');
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
			}
		}
	}
}

function change_group_status(group_id,new_status){
	if($('#disable_group_button').html() != 'Wait...'){
		
		if(new_status == 1){
			var c = confirm('Are you sure you wish to enable this group?');
			
		}else{
			var c = confirm('Are you sure you wish to disable this group?');
			
		}
		
		if(c){
			var data = new FormData();
			data.append('change_group_status',1);
			data.append('new_status',new_status);
			data.append('group_id',group_id);
			data.append('window_index',$('#window_index').val());
			
			$('#disable_group_button').html('Wait...');
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
		}
	}
}

function fetch_sms_client_details(client_id){
	var new_window_index = create_data_window();
	change_window_size('item_details_'+new_window_index,400,500,1);
	show_window('item_details_'+new_window_index);
	
	$('#item_details_holder_'+new_window_index).css('height','450px');
	
	
	$('#details_close_button_'+new_window_index).attr('onclick','close_window(\'item_details_'+new_window_index+'\');$(\'#item_details_'+new_window_index+'\').remove();');
	
	show_loading_progress('item_details_holder_'+new_window_index,'Preparing data. Wait...');
	
	var data = new FormData();
	data.append('fetch_sms_client_details',1);
	data.append('client_id',client_id);
	data.append('holder_index',new_window_index);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}


function update_sms_client(client_id){	
	if($('#client_update_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to proceed?');
		
		if(c){
			var data = new FormData();
			data.append('update_sms_client',1);
			data.append('client_id',client_id);
			data.append('client_name',$('#client_name').val());
			data.append('client_phone',$('#client_phone').val());
			data.append('client_email',$('#client_email').val());
			data.append('group_id',$('#selected_client_group').val());
			data.append('details',$('#client_description').val());
			data.append('window_index',$('#window_index').val());
			
			$('#client_update_button').html('Wait...');
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
		}
	}	
}


function change_sms_client_status(client_id,new_status){
	if($('#disable_client_button').html() != 'Wait...'){
		
		if(new_status == 1){
			var c = confirm('Are you sure you wish to enable this client?');
			
		}else{
			var c = confirm('Are you sure you wish to disable this client?');
			
		}
		
		if(c){
			var data = new FormData();
			data.append('change_sms_client_status',1);
			data.append('new_status',new_status);
			data.append('client_id',client_id);
			data.append('window_index',$('#window_index').val());
			
			$('#disable_client_button').html('Wait...');
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
		}
	}
}

function process_prep_uploader(){
	if($('#process_prep_file_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to update PrEP records? This action cannot be undone');
		
		if(c){
			if($('#tool_excel_file').html() == ''){
				alert('Please select the file with data you wish to upload');
				
			}else{
				var data = new FormData();
				data.append('process_prep_uploader',1);
				data.append('uploaded_file',$('#tool_excel_file').html());
				data.append('id_type',$('#selected_id_type').val());
				data.append('data_set_type',$('#selected_data_set').val());
				
				process_simultanious_xmlhttp('module_xmlhttp',data);		
				$('#process_prep_file_button').html('Wait...');
			}
		}
	}
}

function fetch_story(story_id){
	var window_index = create_data_window();
	
	show_window('item_details_'+window_index,1);
	change_window_size('item_details_'+window_index,700,500,1);
	
	show_loading_progress('item_details_'+window_index+'_holder','Preparing. Wait...');
	
	var data = new FormData();
	data.append('fetch_story',1);
	data.append('story_id',story_id);
	data.append('holder_id','item_details_'+window_index);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function add_post_images(){
	
	if($('#post_files').val() == ''){
		$('#post_files').val($('#uploaded_files').val());
		
	}else{
		$('#post_files').val($('#post_files').val()+','+$('#uploaded_files').val());
		
	}
	
	var uploaded_images = $('#post_files').val();
	var uploaded_images_array = uploaded_images.split(',');
	
	var image_div = '';
	var icon_src = '';
	var non_image_src = '';
	for(var f =0;f<uploaded_images_array.length;f++){
		var this_file_name = uploaded_images_array[f];
		var this_file_array = this_file_name.split('.');
		
		if(this_file_array[1] == 'jpg' || this_file_array[1] == 'JPG' || this_file_array[1] == 'gif' || this_file_array[1] == 'GIF' || this_file_array[1] == 'JPEG' || this_file_array[1] == 'jpeg' || this_file_array[1] == 'bmp' || this_file_array[1] == 'BMP'){
			image_div = image_div+'<div style="width:80px;float:left;height:80px;float:left;border:solid 1px orange;margin:5px;" id="known_file_'+f+'"><div style="position:absolute;margin-left:60px;width:20px;line-height:20px;float:left;text-align:center;line-height:20px;background-color:brown;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#b46767\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="var c = confirm(\'Are you sure you wish to remove this file?\');if(c){remove_from_selection(\''+uploaded_images_array[f]+'\',\'post_files\');$(\'#known_file_'+f+'\').remove();}" title="Click to remove">X</div><img src=\'imgs/'+uploaded_images_array[f]+'\' style="width:100%;height:100%;cursor:pointer;" onclick="window.open(\'imgs/'+uploaded_images_array[f]+'\',\'_file\');" title="Click to open"></div>';
			
		}else{
			if(this_file_array[1] == 'doc' || this_file_array[1] == 'docx'){
				if(icon_src == ''){
					icon_src = 'doc_icon.png';
					non_image_src = uploaded_images_array[f];
				
				}else{
					icon_src = icon_src+',doc_icon.png';
					non_image_src = non_image_src+','+uploaded_images_array[f];
					
				}
			}else if(this_file_array[1] == 'xls' || this_file_array[1] == 'xlsx'){
				if(icon_src == ''){
					icon_src = 'xls_icon.png';
					non_image_src = uploaded_images_array[f];
				
				}else{
					icon_src = icon_src+',xls_icon.png';
					non_image_src = non_image_src+','+uploaded_images_array[f];
					
				}
				
			}else if(this_file_array[1] == 'pdf'){
				if(icon_src == ''){
					icon_src = 'pdf_icon.png';
					non_image_src = uploaded_images_array[f];
				
				}else{
					icon_src = icon_src+',pdf_icon.png';
					non_image_src = non_image_src+','+uploaded_images_array[f];
					
				}
				
			}else{
				if(icon_src == ''){
					icon_src = 'unknown_icon.png';
					non_image_src = uploaded_images_array[f];
				
				}else{
					icon_src = icon_src+',unknown_icon.png';
					non_image_src = non_image_src+','+uploaded_images_array[f];
					
				}
			}
		}
	}
	
	$('#post_images').html(image_div);
	
	
	if(icon_src != ''){
		var non_image_div = '<div style="width:100%;height:auto;float:left;">';
		var icon_src_array = icon_src.split(',');
		var non_image_src_array = non_image_src.split(',');
		for(var f =0;f<icon_src_array.length;f++){
			non_image_div = non_image_div+'<div style="margin:2px;width:auto;float:left;height:30px;float:left;background-color:#fee;padding:2px;" id="unknown_file_'+f+'"><div style="width:30px;height:30px;float:left;"><img src=\'imgs/'+icon_src_array[f]+'\' style="width:100%;height:100%;"></div><div style="width:auto;float:left;height:30px;line-height:30px;margin-left:2px;margin-right:2px;cursor:pointer;" onclick="window.open(\'imgs/'+non_image_src_array[f]+'\',\'_file\');" title="Click to open">'+non_image_src_array[f]+'</div><div style="width:20px;line-height:30px;float:left;text-align:center;line-height:30px;background-color:brown;color:#fff;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#b46767\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="var c = confirm(\'Are you sure you wish to remove this file?\');if(c){remove_from_selection(\''+non_image_src_array[f]+'\',\'post_files\');$(\'#unknown_file_'+f+'\').remove();}" title="Click to remove">X</div></div>';
			
		}
		
		non_image_div = non_image_div+'</div>';
		
		$('#post_images').append(non_image_div);
	}
	
	
	
	
	reset_image_upload();
	close_window('image_uploader');
}

function share_newsletter_post(){
	if($('#share_post_button').html() != 'Wait...'){
		
		if($('#story_title').val()=='Enter title here'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Enter title of your story');
			
			$('#story_title').css('border-color','red');
		
		}else if($('#post_message').val() == 'Share your story'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You cannot share an empty story. Please add some text to your story');
			
			$('#post_message').css('border-color','red');
			
		}else if($('#selected_publication').val() == 0){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to select a publication where this story should be featured');
			
			$('#post_message').css('border-color','red');
			
		}else{
			if($('#post_files').val() == ''){
				var c = confirm('Posts are usually more attractive with pictures. Proceed positng without pictures?');
				
			}else{
				var c = confirm('Proceed with posting?');
			}
			
			if(c){
				var data = new FormData();
				data.append('share_newsletter_post',1);
				data.append('post_title',$('#story_title').val());
				data.append('post_message',$('#post_message').val());
				data.append('publication',$('#selected_publication').val());
				data.append('post_files',$('#post_files').val());
				
				$('#share_post_button').html('Wait...');
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
			}
		}
	}
}

function fetch_analytical_survey_settings(){
	var data = new FormData();
	data.append('fetch_analytical_survey_settings',1);
	data.append('survey_status',$('#selected_analytical_survey_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function fetch_analytical_survey(){
	var data = new FormData();
	data.append('fetch_analytical_survey',1);
	data.append('survey_status',$('#selected_analytical_survey_status').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function start_analytical_survey(survey_id,data_set_id){
	var data = new FormData();
	data.append('start_analytical_survey',1);
	data.append('survey_id',survey_id);
	data.append('data_set_id',data_set_id);
	
	show_loading_progress('analytical_survey','Loading survey. Wait...');
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function process_analytical_survey(survey_id){
	if($('#submit_analytical_survey_button').html() != 'Wait...'){
		var question_id_string = $('#question_id_string').val();
		var question_id_string_array = question_id_string.split(',');
		
		var validation_passed = 1;
		for(var q=0;q<question_id_string_array.length;q++){
			if($('#question_answer_'+question_id_string_array[q]).val() == '' && $('#question_mandatory_'+question_id_string_array[q]).val()==1){
				validation_passed = 0;
				$('#question_title_'+question_id_string_array[q]).css('color','purple');
			
			}
		}
		
		if(!validation_passed){
			$('#error_message').html('Fields highlighted in purple are mandatory. Please specify answers');
			$('#error_message').slideDown('fast');

		}else{
			var c = confirm('Are you sure you wish to proceed with submiting with survey?');
			
			if(c){
				var data = new FormData();
				data.append('process_analytical_survey',1);
				data.append('survey_id',survey_id);
				data.append('question_id_string',$('#question_id_string').val());
				data.append('module_id',$('#module_id').val());			
				
				for(var q=0;q<question_id_string_array.length;q++){
					data.append('question_answer_'+question_id_string_array[q],$('#question_answer_'+question_id_string_array[q]).val());
					data.append('option_type_'+question_id_string_array[q],$('#question_option_type_'+question_id_string_array[q]).val());
				}
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				$('#submit_analytical_survey_button').html('Wait...');
			}
		}
	}
}

function fetch_analytical_survey_responses(){	
	var data = new FormData();
	data.append('fetch_analytical_survey_responses',1);
	
	show_loading_progress('analytical_survey','Loading responses. Wait...');
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}