var active_menu = 0;
var general_variable_3 = 0;
var general_variable_4 = '';
var general_variable_5 = '';


if(window.XMLHttpRequest){
	module_xmlhttp = new XMLHttpRequest();
	module_xmlhttp_2 = new XMLHttpRequest();
	module_xmlhttp_3 = new XMLHttpRequest();
	
}else{
	module_xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	module_xmlhttp_2 = new ActiveXObject("Microsoft.XMLHTTP");
	module_xmlhttp_3 = new ActiveXObject("Microsoft.XMLHTTP");
}

$(document).ready (function (){
	active_menu = $('#active_area_id').val();
	change_image();
});

module_xmlhttp.onreadystatechange = function(){
	if(module_xmlhttp.readyState == 4 && module_xmlhttp.status == 200){
		var response_text = module_xmlhttp.responseText;
		var response_array = response_text.split("~");

		if(response_array[0] == 'session_expired'){	
			alert('Session has expired. You will be re-directed to sign in page...');
			window.open($('#url').val(),'_self');
		
		}else if(response_array[0] == 'create_request_type'){
			close_window('new_request_type');
			fetch_script('_codes/approval_settings.php','settings');
		
		}else if(response_array[0] == 'fetch_request_type_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'delete_request_type' || response_array[0] == 'update_request_type'){
			if(response_array[1] == 1){				
				alert('Request type was not deleted because some system items are using it. This request type has been disabled instead');
			}
	
			close_window('edit_request_type');
			fetch_script('_codes/approval_settings.php','settings');
			
		}else if(response_array[0] == 'create_request_threshold'){
			if(response_array[1] == 2){
				alert('All approval limits have exceeded the maximum cluster limit of '+response_array[2]+', and the threshold has not been saved. Please change limit amounts and try again');
				
				$('#create_request_threshold_button').html('Create');
			
			}else {
				if(response_array[1] == 1){
					alert('Some approval limits had exceeded the maximum cluster limit '+response_array[2]+', and have been removed from the threshold configuration. Requests above the threshold cluster limit will be escalated to the specified cluster on the threshold\'s cluster settings');
				
				}
			
				close_window('new_request_threshold');
				fetch_script('_codes/approval_settings.php','settings');
			}
			
		}else if(response_array[0] == 'delete_request_threshold' || response_array[0] == 'update_request_threshold'){
			close_window('edit_request_threshold');
			fetch_script('_codes/approval_settings.php','settings');
			
			
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
			
			
		}else if(response_array[0] == 'approve_level'){
			if(response_array[4] != 0){
				alert(response_array[5]);
				$('#item_approvals_'+response_array[1]).html(general_variable_5);
				
				$('#level_approval_buttons_'+response_array[1]+'_'+response_array[2]).html(general_variable_4);
				
			}else{
				var direction_variable = 'memo_approval_direction_'+response_array[1]+' = 1';
				eval(direction_variable);
				
				var func = 'send_bill_xmlhttp_'+response_array[1]+'()';
				eval(func);
				
				if(response_array[3] == 1){
					$('#item_approvals_'+response_array[1]).slideUp('slow');
					$('#memo_'+response_array[1]+'_title').hide('medium');
					
					calculate_tab_totals();
					
				}
			}
			
		}else if(response_array[0] == 'confirm_deny'){
			if(response_array[3] != 0){
				alert(response_array[5]);
				
				$('#item_approvals_'+response_array[1]).html(general_variable_5);
				
			}else{
				close_window('deny_comment');
				var direction_variable = 'memo_approval_direction_'+response_array[1]+' = 0';
				eval(direction_variable);
				
				var func = 'send_bill_xmlhttp_'+response_array[1]+'()';
				eval(func);
				
				if(response_array[4] == 1){
					$('#item_approvals_'+response_array[1]).slideUp('slow');
					$('#memo_'+response_array[1]+'_title').hide('medium');
					
					calculate_tab_totals();
					
				}
			}
			
			$('#deny_button').html('Deny');
			
		}else if(response_array[0] == 'fetch_payment_claims'){
			display_infor('payment_claim_list_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_claim_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'search_claim_agents'){
			display_infor('claim_agent_search_results_holder',response_array[1]);
	
		}else if(response_array[0] == 'process_claim_images'){
			close_window('image_uploader');
			$('#save_upload_images').html('Finish');
			
			var file_names = $('#uploaded_files').val();
			var file_name_array = file_names.split(',');
			
			var file_types = response_array[1];
			var file_type_array = file_types.split(',');
			
			for(var f=0;f<file_name_array.length;f++){
				//if(check_if_file_exists($('#code_url').val()+'/imgs/'+file_type_array[f]+'_icon.png')){
				var file_icon = file_type_array[f]+'_icon.png';
				/*	
				}else{
					
					file_icon = 'unknown_icon.png';
				}*/
				
				var file_button = '<div style="margin:5px;width:auto;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;border:solid 1px #ddd;"  id="attachment_item_'+f+'"><div style="width:auto;height:30px;float:left;" onmouseover="this.style.backgroundColor=\'#efe\';" onmouseout="this.style.backgroundColor=\'\';" onclick="window.open(\''+$('#url').val()+'/imgs/attachments/'+file_name_array[f]+'\',\'attachment_'+f+'\');"><div style="margin:2px;width:25px;height:25x;color:#000;text-align:center;float:left;"><img src="../imgs/'+file_icon+'" style="height:25px"></div><div style="width:auto;height:30x;color:#000;text-align:center;float:left;padding-right:5px;">'+file_name_array[f]+'</div></div><div style="width:20px;height:30px;text-align:center;line-height:30px;color:#fff;background-color:brown;float:left;" onmouseover="this.style.backgroundColor=\'#b44e4e\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="remove_from_selection(\''+file_name_array[f]+'\',\'uploaded_files\');$(\'#attachment_item_'+f+'\').slideUp(\'fast\');$(\'#image_'+f+'_error\').slideUp(\'fast\');$(\'#image_'+f+'_progress\').slideUp(\'fast\');$(\'#image_'+f+'_holder\').slideDown(\'fast\');if($(\'#uploaded_files\').val() == \'\'){$(\'#attachments_holder\').css(\'font-size\',\'1.5em\');$(\'#attachments_holder\').html(\'No attachments added\');}">X</div></div>';
				
				if(f==0){
					$('#attachments_holder').html(file_button);
					$('#attachments_holder').css('font-size','1em');
				
				}else{
					$('#attachments_holder').append(file_button);
				}
			}
			
		}else if(response_array[0] == 'create_or_update_claim'){
			close_window('item_details');
			$('#item_details_holder').html('');
			$('#uploaded_files').val('');
			
			reset_image_upload();
			
			//fetch_payment_claims();
			
			if(response_array[1] == 0){
				$('#tab_1').click();
				
			}else{
				$('#tab_3').click();
				
			}
			
		}else if(response_array[0] == 'process_change_claim_status'){
			$('#claim_'+response_array[1]+'_holder').hide('fast');
			close_window('item_details');
			
		}else if(response_array[0] == 'fetch_claim_type_code'){
			display_infor('claim_type_list_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_claim_type_details'){
			display_infor('item_details_holder',response_array[1]);
		
		}else if(response_array[0] == 'create_or_update_request_type' || response_array[0] == 'enable_or_disable_request_type' || response_array[0] == 'create_or_update_threshold' || response_array[0] == 'enable_or_disable_threshold'){
			close_window('item_details');
			
			fetch_claim_type_list();
			
		}else if(response_array[0] == 'fetch_claim_type_list_code'){
			display_infor('approval_settings',response_array[1]);
			
		}else if(response_array[0] == 'fetch_request_threshold'){
			display_infor('item_details_holder',response_array[1]);
			
		
			
		}else if(response_array[0] == 'process_level_confirm_queue'){
			var approval_code = $('#approval_queue').val();		
			var approval_code_array = approval_code.split('|');
			
			var code_string = '';
			for(var ac=1;ac<approval_code_array.length;ac++){
				if(approval_code_array[ac] != undefined){
					if(code_string == ''){
						code_string = approval_code_array[ac];
					}else{
						code_string = code_string+'|'+approval_code_array[ac];

					}					
				}
			}
			
			$('#approval_queue').val(code_string);
			
			
			
			if(response_array[6] != ''){
				var file_string = response_array[6];
				var file_array = file_string.split(',');
				
				var file_string_2 = '';
				for(var f =0;f<file_array.length;f++){
					if(file_string_2 == ''){
						
						file_string_2 = '<a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''+$('#url').val()+'/imgs/'+file_array[f]+'\',\'file_download\')">'+file_array[f]+'</a>';
						
						
					}else{
						file_string_2 = file_string+'<br><a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''+$('#url').val()+'/imgs/'+file_array[f]+'\',\'file_download\')">'+file_array[f]+'</a>';
						
					}
					 
				}
			
				$('#file_approver_bottons_'+response_array[1]+'_'+response_array[2]+'_'+response_array[5]).slideUp('fast');
				$('#file_redo_button_'+response_array[1]+'_'+response_array[2]+'_'+response_array[5]).slideUp('fast');
				$('#level_approved_'+response_array[1]+'_'+response_array[2]+'_0_'+response_array[5]).val(1);
				
			}else{
				$('#beneficiary_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]+'_'+response_array[5]+'_level').html('<font style="color:green;text-align:center;">Approved</font>');
			
				$('#level_approved_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[5]).val(1);
				
			}
			
			if($('#approval_queue').val() != ''){
				process_level_confirm_queue();
				
			}
			
			if(response_array[7] == 1){
				$('#claim_'+response_array[1]+'_holder').slideUp('fast');
				
			}
			
			if(response_array[8] == 1){
				$('#claim_'+response_array[1]+'_active').val(0);
				fetch_claim_beneficiaries(response_array[1],0);
				
			}
			
		}else if(response_array[0] == 'fetch_rejection_options' || response_array[0] == 'change_claim_status'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'process_level_reject_queue'){
			if(response_array[3] == 0){
				$('#claim_file_holder_'+response_array[1]+'_'+response_array[2]+'_'+response_array[5]).html('<font style="color:brown;text-align:center;">Sent to level '+(Number(response_array[8])+1)+'</font>');
				
			}else{
				$('#beneficiary_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]+'_'+response_array[5]+'_level').html('<font style="color:brown;text-align:center;">Sent to level '+(Number(response_array[8])+1)+'</font>');
				
				$('#beneficiary_checkbox_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]).click();
				document.getElementById('beneficiary_checkbox_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]).disabled = true;
				
				
			}
			
			close_window('item_details');
			$('#item_details_holder').html('');
			
			if(response_array[9] == 1){
				$('#claim_'+response_array[1]+'_active').val(0);
				fetch_claim_beneficiaries(response_array[1],0);
				
			}
			
			if(response_array[10] == 1){
				$('#claim_'+response_array[1]+'_holder').slideUp('fast');
				
			}
			
		}else if(response_array[0] == 'generate_claim_csv'){
			$('#active_csv_form_'+response_array[1]).html('CSV for ZOONA');
			window.open($('#url').val()+'/'+response_array[2]);
			
		}else if(response_array[0] == 'fetch_request_type_agent'){
			display_infor('search_agent_results_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_claim_schedule'){
			display_infor('claim_schedule_list_holder1',response_array[1]);
			
		}else if(response_array[0] == 'fetch_awaiting_creation_claims'){
			display_infor('awaiting_creation_holder',response_array[1]);
			
		}else if(response_array[0] == 'fetch_claim_schedule_details'){
			display_infor('item_details_holder',response_array[1]);
			
		}else if(response_array[0] == 'create_or_update_schedule_type' || response_array[0] == 'delete_schedule_type'){
			close_window('item_details');
			$('#item_details_holder').html('');
			fetch_claim_schedule();
			
		}else if(response_array[0] == 'run_spreadsheet_beneficiary_queue'){
			if(response_array[6] == ''){
				if(response_array[5] == 0){
					$('#ascension_beneficiary_remove_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).slideUp('fast');
					$('#ascension_beneficiary_add_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).slideDown('fast');
					$('#ascension_beneficiary_holder_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).css('color','#aaa');
					
					remove_from_selection(response_array[3],'spreadsheet_'+response_array[7]+'_'+response_array[4]);
					
				}else{
					$('#ascension_beneficiary_add_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).slideUp('fast');
					$('#ascension_beneficiary_remove_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).slideDown('fast');
					$('#ascension_beneficiary_holder_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).css('color','#000');
					
					add_to_selection(response_array[3],'spreadsheet_'+response_array[7]+'_'+response_array[4]);
				}
				
			}else{
				alert(response_array[6]);
				
				
			}
			
			$('#ascension_beneficiary_status_'+response_array[1]+'_'+response_array[2]+'_'+response_array[3]+'_'+response_array[4]).html('');
			var processing_queue = $('#spreadsheet_beneficiary_remove_queue_'+response_array[1]+'_'+response_array[2]).val();
			var processing_queue_array = processing_queue.split(',');
			
			var new_queue_string = '';
			for(var p=0;p<processing_queue_array.length;p++){
				if(p != 0){
					if(new_queue_string == ''){
						new_queue_string = processing_queue_array[p];
						
					}else{
						new_queue_string = new_queue_string+','+processing_queue_array[p];
						
					}
				}
			}
			
			$('#spreadsheet_beneficiary_remove_queue_'+response_array[1]+'_'+response_array[2]).val(new_queue_string)
			
			if(new_queue_string != ''){
				run_spreadsheet_beneficiary_queue(response_array[2]);
			}
			
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
			//alert(response_array[0]);
		}
		
	}
}

module_xmlhttp_2.onreadystatechange = function(){
	if(module_xmlhttp_2.readyState == 4 && module_xmlhttp_2.status == 200){
		var response_text = module_xmlhttp_2.responseText;
		var response_array = response_text.split("~");

		if(response_array[0] == 'session_expired'){	
			alert('Session has expired. You will be re-directed to sign in page...');
			window.open($('#url').val(),'_self');
		
		}else if(response_array[0] == 'check_date_error'){
			$('#beneficiary_date_error_'+response_array[2]+'_'+response_array[3]).css('color','brown');
			if(response_array[1] == 1 || response_array[1] == 2 || response_array[5] == 0){
				
				
				if(response_array[4] == '' && response_array[5] == 0){
					var error_message  = 'Rule error: '+response_array[6];
					
				}else if(response_array[4] != '' && response_array[5] == 0){
					var error_message  = response_array[4]+'<br>Rule error: '+response_array[6];
					
				}else if(response_array[5] == 1){
					var error_message  = response_array[4];
					
				}
				
				$('#beneficiary_date_error_'+response_array[2]+'_'+response_array[3]).slideDown('fast');
				$('#beneficiary_date_error_'+response_array[2]+'_'+response_array[3]).html(error_message);

				if(response_array[1] == 2 || response_array[5] == 0){
					//$('#beneficiary_active_'+response_array[2]+'_'+response_array[3]).val(0);
					
					$('#disable_beneficiary_button_'+response_array[2]+'_'+response_array[3]).click();
					$('#enable_beneficiary_button_'+response_array[2]+'_'+response_array[3]).hide('fast');
					$('#beneficiary_date_error_'+response_array[2]+'_'+response_array[3]).slideDown('fast');
					$('#agent_'+response_array[2]+'_'+response_array[3]+'comment').slideUp('fast');
					
				}else{
					$('#beneficiary_active_'+response_array[2]+'_'+response_array[3]).val(1);
					$('#agent_'+response_array[2]+'_'+response_array[3]+'comment').slideDown('fast');
					
				}
				
			}else{
				$('#beneficiary_date_error_'+response_array[2]+'_'+response_array[3]).slideUp('fast');
				$('#beneficiary_active_'+response_array[2]+'_'+response_array[3]).val(1);
				$('#agent_'+response_array[2]+'_'+response_array[3]+'comment').slideUp('fast');
			}
			
			remove_from_selection(response_array[2]+'_'+response_array[3],'agent_processing_queue');
			
			if($('#agent_processing_queue').val() != ''){
				check_date_error();
				
			}
		
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
			//alert(response_array[0]);
		}
	}
}

module_xmlhttp_3.onreadystatechange = function(){
	if(module_xmlhttp_3.readyState == 4 && module_xmlhttp_3.status == 200){
		var response_text = module_xmlhttp_3.responseText;
		var response_array = response_text.split("~");

		if(response_array[0] == 'session_expired'){
			alert('Session has expired. You will be re-directed to sign in page...');
			window.open($('#url').val(),'_self');
		
		}else if(response_array[0] == 'fetch_agent_days'){
			$('#claim_days_worked_'+response_array[2]+'_'+response_array[3]).html(response_array[1]);
			
			if($('#claim_billing_type_'+response_array[2]).val() == 0){
				if($('#claim_limit_days_'+response_array[2]).val() == 1 && (Number(response_array[1]) > Number($('#claim_max_days_'+response_array[2]).val()))){
					$('#claim_days_payable_'+response_array[2]+'_'+response_array[3]).val($('#claim_max_days_'+response_array[2]).val());
					
				}else{
					$('#claim_days_payable_'+response_array[2]+'_'+response_array[3]).val(response_array[1]);
					
				}
				
				recalculate_newclaim_total();
			}
			
			
			if(response_array[1] == 0){
				$('#claim_days_worked_'+response_array[2]+'_'+response_array[3]).css('color','red');
			}
			
			if(response_array[4] == 1){
				add_check_date_queue(response_array[2],response_array[3]);
			}
			
			
			remove_from_selection(response_array[2]+'_'+response_array[3]+'_'+response_array[4],'agent_days_processing_queue');
			
			if($('#agent_days_processing_queue').val() != ''){
				fetch_agent_days();
				
			}
		}else{
			$('#main_error_output').html(response_array[0]);
			$('#main_error_output').slideDown('fast');
			//alert(response_array[0]);
		}
	}
}

function add_file_upload(level){
	var document_index = Number($('#level_'+level+'_upload_documents').val());
	
	var input_field = '<div style="width:100%;height:auto;float:left;margin-top:5px;"><div style="line-height:30px;width:80px;height:30px;float:left;">File '+(document_index + 1)+': </div><div style="width:220px;min-height:30px;height:auto;float:left;"><div style="width:250px;height:30px;float:left;"><input type="text" id="edit_request_file_'+level+'_'+document_index+'" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter title here" onfocus="if(this.value==\'Enter title here\'){this.value=\'\';this.style.color=\'#000\';}this.style.borderColor=\'#aaa\';$(\'#new_request_error_message\').hide(\'fast\');" onfocusout="if(this.value==\'\'){this.value=\'Enter title here\';this.style.color=\'#aaa\';}"></div></div></div>';
	
	$('#'+level+'_documents').append(input_field);
	document_index++;
	$('#level_'+level+'_upload_documents').val(document_index);
}

function add_request_type_approver_level(){
	var total_levels = Number($('#total_request_type_levels').val());
	var this_div = $('#default_approval_level').html();
	
	this_div = '<div style="width:100%;float:left;height:auto;" id="approval_level_'+total_levels+'">'+this_div.replace(/_y/g,'_'+total_levels)+'</div>';
	
	//alert($('#level_h_y').val());
	//this_div = this_div.replace(/_y/g,'_'+total_levels);
	this_div = this_div.replace(/_z/g,'_0');
	
	$('#approval_levels').append(this_div);
	$('#level_header_'+total_levels).html('Level '+(total_levels+1));
	
	
	if(total_levels == 0){
		$('#notify_creator_0').slideUp('fast');
		
	}
	
	total_levels++;
	
	$('#total_request_type_levels').val(total_levels);
}

function fetch_request_type_details(request_type_id){
	var data = new FormData();
	data.append('fetch_request_type_details',1);
	data.append('request_type_id',request_type_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details',1);
	show_loading_progress('item_details_holder','Prepairing. Wait...');
	
	change_window_size('item_details',800,500,1);
	$('#item_details_title').html('Request type details');
}

function create_or_update_request_type(request_type_id,new_copy){
	
	if($('#request_type_title').val() == '' || $('#request_type_title').val() == 'Enter request type title'){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('You need to enter the title of this claim type');
		$('#request_type_title').css('border-color','red');
		
		$('#approval_levels').slideUp('fast');		
		
	}else if($('#selected_billing_type').val() == 1 && $('#request_type_amount').val() == 0){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('You need to specify the fixed value for this claim type');
		$('#request_type_amount').css('border-color','red');
		
		$('#approval_levels').slideUp('fast');		
		
	}else if($('#selected_billing_type').val() == 0 && $('#daily_rate').val() == 0){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('You need to enter the daily rate for this claim type');
		$('#daily_rate').css('border-color','red');
		
		$('#approval_levels').slideUp('fast');		
		
	}else if($('#selected_limit_days').val() == 1 && $('#max_days').val() == 0){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('You need to set the max payable days for this claim type');
		$('#max_days').css('border-color','red');
		
		$('#approval_levels').slideUp('fast');
		

	}else if($('#selected_request_region').val() == -1){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('Select a location where this claim should be available');
				
		$('#approval_levels').slideUp('fast');	
		
	}else if($('#total_request_type_levels').val() < 1){
		$('#error_message').fadeIn('fast');
		$('#error_message').html('You need to set atleast two approval levels');
				
		$('#approval_levels').slideDown('fast');	
				
	}else{
		
		
		var rule_validation = 1;
		
		if($('#selected_billing_rule').val() == 1){
			if($('#selected_activities_rule_unit').val() == 0){
				rule_validation = 0;
				$('#error_message').fadeIn('fast');
				$('#error_message').html('You need to select a unit for the ativity billing rule');
						
				$('#approval_levels').slideDown('fast');
				
			}else if($('#selected_activities_rule_activity').val() == 0){
				rule_validation = 0;
				$('#error_message').fadeIn('fast');
				$('#error_message').html('You need to select an activity for the billing rule');
						
				$('#approval_levels').slideDown('fast');
				
			}else if($('#billing_rule_activity_number').val() == 0){
				rule_validation = 0;
				$('#error_message').fadeIn('fast');
				$('#error_message').html('Activity number must be greater than 0');
						
				$('#approval_levels').slideDown('fast');
				
			}
		}
		
		
		$('#approval_levels').slideDown('fast');
		
		var total_levels = $('#total_request_type_levels').val();
		
		error = 0;
		for(var l=0;l<total_levels;l++){
			if($('#level_title_'+l).val() == 'Enter title here'){
				$('#error_message').fadeIn('fast');
				$('#error_message').html('You need to add the level title for level '+(l+1));
				$('#level_title_'+l).css('border-color','red');
	
				error = 1;
				
			}else if($('#action_title_'+l).val() == 'Enter title here'){
				$('#error_message').fadeIn('fast');
				$('#error_message').html('You need to add the action title for level '+(l+1));
				$('#action_title_'+l).css('border-color','red');
				
				
				error = 1;
				
				
			}else if($('#selected_approver_type_'+l).val() == 1 && $('#selected_approver_group_'+l).val() == 0){
				$('#error_message').fadeIn('fast');
				$('#error_message').html('Select a group approver for level '+(l+1));
				
				
				error = 1;
				
				
			}else if($('#selected_approver_type_'+l).val() == 2 && $('#selected_approver_user_'+l).val() == 0){
				$('#error_message').fadeIn('fast');
				$('#error_message').html('Select a user approver for level '+(l+1));
				
				
				error = 1;
			}
		}

		if(!error && rule_validation == 1){
			var data = new FormData();
			data.append('create_or_update_request_type',1);
			data.append('request_type_id',request_type_id);
			data.append('new_copy',new_copy);
			data.append('title',$('#request_type_title').val());
			data.append('billing_type',$('#selected_billing_type').val());
			data.append('daily_rate',$('#daily_rate').val());
			data.append('limit_days',$('#selected_limit_days').val());
			data.append('max_days',$('#max_days').val());
			data.append('day_adjustment',$('#selected_day_adjustment').val());
			data.append('request_type_amount',$('#request_type_amount').val());
			data.append('billing_rule_id',$('#selected_billing_rule').val());
			data.append('billing_rule_unit',$('#selected_activities_rule_unit').val());
			data.append('billing_rule_activity',$('#selected_activities_rule_activity').val());
			data.append('billing_rule_activity_number',$('#billing_rule_activity_number').val());
			data.append('billing_rule_day',$('#billing_rule_day').val());
			data.append('billing_rule_amount',$('#biling_rule_amount').val());
			data.append('urgency',$('#selected_urgency').val());
			data.append('color',$('#selected_color').val());
			data.append('levels',$('#total_request_type_levels').val());
			data.append('region_id',$('#selected_request_region').val());
			data.append('province_id',$('#selected_request_province').val());
			data.append('hub_id',$('#selected_request_hub').val());
			data.append('site_id',$('#selected_request_site').val());
			
			data.append('scheduler_trigger',$('#selected_schedule_trigger').val());
			data.append('trigger_day',$('#selected_trigger_day').val());
			data.append('trigger_month_day',$('#selected_trigger_date').val());
			data.append('scheduler_payment_from_date_day',$('#selected_from_day').val());
			data.append('scheduler_payment_from_date_month',$('#selected_from_month').val());
			data.append('scheduler_payment_from_date_month_operator',$('#selected_payment_from_month_operator').val());
			data.append('scheduler_payment_from_date_month_addition',$('#payment_from_addition').val());
			
			data.append('scheduler_payment_to_date_day',$('#selected_to_day').val());
			data.append('scheduler_payment_to_date_month',$('#selected_to_month').val());
			data.append('scheduler_payment_to_date_month_operator',$('#selected_payment_to_month_operator').val());
			data.append('scheduler_payment_to_date_month_addition',$('#payment_to_addition').val());
			
			data.append('scheduler_recurrence',$('#selected_trigger_recurrence').val());
			data.append('scheduler_schedule_type',$('#selected_schedule_type').val());
			data.append('scheduler_location_depth',$('#selected_location_depth').val());
			data.append('scheduler_unknown_locations',$('#selected_unspecified_locations').val());
			data.append('scheduler_days_worked_id',$('#selected_days_worked').val());
			data.append('scheduler_force_days',$('#force_days').val());
			data.append('scheduler_force_days_justification',$('#force_days_justification').val());
			data.append('scheduler_schedule_rule',$('#selected_schedule_rule').val());
			data.append('scheduler_beneficiary_type',$('#selected_beneficiary_selection').val());
			data.append('scheduler_agent_groups',$('#selected_agent_type').val());
			data.append('scheduler_agent_units',$('#selected_unit').val());
			data.append('scheduler_custom_agents',$('#selected_request_type_agents').val());
			data.append('scheduler_execution_notification',$('#selected_schedule_notification').val());
			
			
			for(var l=0;l<total_levels;l++){
				var total_documents = Number($('#total_documents_'+l).val());
				
				data.append('level_title_'+l,$('#level_title_'+l).val());
				data.append('action_title_'+l,$('#action_title_'+l).val());
				data.append('action_type_'+l,$('#selected_action_type_'+l).val());
				data.append('approver_type_'+l,$('#selected_approver_type_'+l).val());
				data.append('approver_location_level_'+l,$('#selected_location_level_'+l).val());
				data.append('approver_location_'+l,$('#selected_approver_area_'+l).val());
				data.append('approver_unit_'+l,$('#selected_approver_unit_'+l).val());
				data.append('approver_group_'+l,$('#selected_approver_group_'+l).val());
				data.append('approver_user_'+l,$('#selected_approver_user_'+l).val());
				data.append('notify_creator_'+l,$('#selected_notify_creator_'+l).val());
				data.append('notify_levels_'+l,$('#request_notify_stages_'+l).val());
				
				data.append('total_documents_'+l,$('#total_documents_'+l).val());
				for(var d=0;d<total_documents;d++){
					data.append('document_'+l+'_'+d,$('#document_'+l+'_'+d).val());
					data.append('document_active_'+l+'_'+d,$('#document_active_'+l+'_'+d).val());	
				}
				
				data.append('delay_monitor_switch_'+l,$('#selected_delay_monitor_'+l).val());
				data.append('delay_length_'+l,$('#delay_length_'+l).val());
				data.append('delay_flag_claim_'+l,$('#flag_claim_input_'+l).val());
				data.append('delay_notify_creator_'+l,$('#notify_creator_input_'+l).val());
				data.append('delay_notify_levels_'+l,$('#monitor_notify_levels_'+l).val());
				data.append('delay_notify_user_'+l,$('#selected_monitor_user_'+l).val());
				data.append('delay_notify_user_group_'+l,$('#selected_monitor_user_group_'+l).val());
			}
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			$('#update_or_create_request_type_button').html('Wait...');
		}
	}
}

function add_group_approver(){
	var index = Number($('#total_approvers').val());
	var string_code = '<div style="width:100%;height:auto;float:left;margin-bottom:35px;" id="approver_'+index+'">'+$('#default_approver').html()+'</div>';
	
	string_code = string_code.replace(/_z/g,"_"+index);
	$('#approvers').append(string_code);
	
	$('#approver_header_'+index).html('Approver '+(index+1));
	
	index++;
	$('#total_approvers').val(index);
}


function create_or_update_threshold(threshold_id){
	if($('#update_or_create_threshold_button').html() != 'Wait..'){
		if($('#threshold_title').val() == 'Enter title here' || $('#threshold_title').val() == ''){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to put a title for this setting');
			$('#threshold_title').css('border-color','red');		
		
		}else{
			var total_thresholds = $('#total_approvers').val();
			
			var error = 0;
			for(var a=0;a<total_thresholds;a++){
				if($('#selected_limit_amount_'+a).val() == 1 && $('#limit_amount_value_'+a).val() == 'Enter amount here' && $('#approver_active_'+a).val() == 1){
					$('#error_message').slideDown('fast');
					$('#error_message').html('You need to enter the limit amount for approver '+(a+1));
					$('#limit_amount_value_'+a).css('border-color','red');
					
					error = 1;
				}
			}
			
			
			
			if(!error){
				var data = new FormData();
				data.append('create_or_update_threshold',1);
				data.append('threshold_id',threshold_id);
				data.append('title',$('#threshold_title').val());		
				data.append('region_id',$('#selected_request_region').val());
				data.append('province_id',$('#selected_request_province').val());
				data.append('hub_id',$('#selected_request_hub').val());
				data.append('site_id',$('#selected_request_site').val());
				
				data.append('total_approvers',total_thresholds);		
				
				for(var a=0;a<total_thresholds;a++){
					data.append('value_limitation_'+a,$('#selected_limit_amount_'+a).val());
					data.append('limit_value_'+a,$('#limit_amount_value_'+a).val());
					data.append('lower_amounts_'+a,$('#selected_low_amount_'+a).val());
					data.append('high_amounts_'+a,$('#selected_high_amount_'+a).val());
					data.append('approver_type_'+a,$('#selected_approver_type_'+a).val());
					data.append('approver_level_'+a,$('#selected_approver_type_'+a).val());
					data.append('approver_location_'+a,$('#selected_approver_area_'+a).val());
					data.append('approver_unit_'+a,$('#selected_approver_unit_'+a).val());
					data.append('approver_group_'+a,0);
					data.append('approver_user_'+a,$('#selected_approver_user_'+a).val());
					data.append('user_allocation_'+a,$('#selected_user_allocation_'+a).val());
					data.append('approver_active_'+a,$('#approver_active_'+a).val());
					
				}
				
				process_simultanious_xmlhttp('module_xmlhttp',data);
				$('#update_or_create_threshold_button').html('Wait...');
			}
		}
	}
}


function fetch_request_threshold(threshold_id){
	var data = new FormData();
	data.append('fetch_request_threshold',1);
	data.append('threshold_id',threshold_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details');
	show_loading_progress('item_details_holder','Preparing. One moment please...');
}

/*function add_approval_file(memo_id,level,file_ind){
	$('#uploaded_file_'+memo_id+'_'+level+'_'+file_ind).val($('#uploaded_files').val());
		
	$('#file_upload_button_'+memo_id+'_'+level+'_'+file_ind).hide('fast');
	$('#file_upload_name_holder_'+memo_id+'_'+level+'_'+file_ind).show('fast');
	$('#file_upload_name_'+memo_id+'_'+level+'_'+file_ind).html($('#uploaded_files').val());
	
	$('#uploaded_files').val('');
	
	close_window('image_uploader');
}

function approve_level(memo_id,level,action_type,total_levels){
	var c = confirm('Are you sure you wish to approve this level?');
	
	if(c){
		var data = new FormData();
		data.append('approve_level',1);
		data.append('memo_id',memo_id);
		data.append('level',level);
		data.append('action_type',action_type);
		data.append('total_levels',total_levels);
		
		var error = 0;
		
		if(action_type == 2){
			var total_documents = $('#total_documents').val();
			data.append('total_documents',total_documents);
			
			for(var d=0;d<total_documents;d++){
				if($('#uploaded_file_'+memo_id+'_'+level+'_'+d).val() == ''){
					error = 1;
					
				}else{
					data.append('file_'+d,$('#uploaded_file_'+memo_id+'_'+level+'_'+d).val());
					
				}
				
			}
		}
		
		if(error == 0){
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			general_variable_4 = $('#level_approval_buttons_'+memo_id+'_'+level).html();
			$('#level_approval_buttons_'+level).html('Wait...');
			
			general_variable_5 = $('#item_approvals_'+memo_id).html();
			
			var this_progress_text = '<div style="width:100%;height:200px;text-align:center;float:left;font-size:1.1em;" ><div style="width:100%;height:20px;float:left;margin-top:70px;">Approving level. This should not take long...</div><div style="width:100%;height:20px;float:left;"><img src="http://localhost/blueraysit.com/imgs/loading.gif"></div></div>';
			
			$('#item_approvals_'+memo_id).html(this_progress_text);
			
		}else if(error == 1){
			alert('Could not approve this level because some files have not been uploaded. Upload all files and try again');
			
		}
	}
}
*/

function deny_level(memo_id,level,action_type,total_levels){
	
	if(level == 0){
		alert('You cannot deny approval of level 1. You can choose to remove the memo instead');
		
	}else{
		var select_options = '';
		for(var l=0;l<level;l++){
			
			if(select_options == ''){
			select_options = '<option value="'+l+'" selected>'+(l+1)+'</option>';
				
			}else{
				select_options = select_options+'<option value="'+l+'" selected>'+(l+1)+'</option>';
				
			}
		}
		
		$('#jump_level').html(select_options);
		$('#deny_button').attr('onclick','confirm_deny('+memo_id+','+level+','+action_type+','+total_levels+')');
		show_window('deny_comment',0);
	}
}

function confirm_deny(memo_id,level,action_type,total_levels){
	if($('#deny_button').html() == 'Deny'){
		if($('#item_comment').val() == 'No comment added'){
			$('#deny_error_message').html('You need to add a comment for your denial');
			$('#item_comment').css('borderColor','red');
			
		}else{
			var data = new FormData();
			data.append('confirm_deny',1);
			data.append('comment',$('#item_comment').val());
			data.append('jump_to',$('#jump_level').val());
			data.append('memo_id',memo_id);
			data.append('level',level);
			data.append('action_type',action_type);
			data.append('total_levels',total_levels);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			general_variable_5 = $('#item_approvals_'+memo_id).html();
			
			var this_progress_text = '<div style="width:100%;height:200px;text-align:center;float:left;font-size:1.1em;" ><div style="width:100%;height:20px;float:left;margin-top:70px;">Rejecting level. This should not take long...</div><div style="width:100%;height:20px;float:left;"><img src="http://localhost/blueraysit.com/imgs/loading.gif"></div></div>';
			
			$('#item_approvals_'+memo_id).html(this_progress_text);
		}
	}
}

function fetch_claim_beneficiaries(claim_date,request_type){
	$('#claim_'+claim_date+'_beneficiaries').slideToggle('fast');
	$('#claims_filter_options').slideUp('fast');
	
	if($('#claim_'+claim_date+'_active').val() == 0 || request_type == 1){
		var this_progress_text = '<div style="width:100%;height:200px;text-align:center;float:left;font-size:1.1em;" ><div style="width:100%;height:20px;float:left;margin-top:70px;">Loading approval levels. One moment please...</div><div style="width:100%;height:20px;float:left;"><img src="'+$('#code_url').val()+'/imgs/loading.gif"></div></div>';
		
		display_infor('claim_'+claim_date+'_beneficiaries',this_progress_text);
		
		$('#claim_'+claim_date+'_active').val(1);
		
		$('#claim_'+claim_date).attr("onmouseover","this.style.backgroundColor='#37aea8'");
		$('#claim_'+claim_date).attr("onmouseout","this.style.backgroundColor='#34b8b2'");
		$('#claim_'+claim_date).css('backgroundColor','#34b8b2');
		$('#claim_'+claim_date).css('color','#fff');
		
		var data = new FormData();
		data.append('fetch_claim_beneficiaries',1);
		data.append('claim_date',claim_date);
		
		process_simultanious_xmlhttp('claim_xmlhttp_'+claim_date,data);
		
	}else{
		$('#claim_'+claim_date+'_active').val(0);
		
		$('#claim_'+claim_date).attr("onmouseover","this.style.backgroundColor='#eee'");
		$('#claim_'+claim_date).attr("onmouseout","this.style.backgroundColor=''");
		$('#claim_'+claim_date).css("color",$('#claim_'+claim_date+'_original_color').val());
		$('#claim_'+claim_date).css('backgroundColor','');
		
	}
}

function fetch_payment_claims(){
	var data = new FormData();
	data.append('fetch_payment_claims',1);
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('user_id',$('#selected_user').val());
	data.append('unit_id',$('#selected_unit').val());
	data.append('claim_type_id',$('#selected_claim_type').val());
	data.append('level',$('#selected_level').val());
	data.append('level_consideration',$('#selected_level_consideration').val());
	data.append('search_key',$('#payment_claim_search_key').val());
	data.append('strictness_id',$('#selected_strict').val());
	data.append('status',$('#claim_status').val());
	
	data.append('date_from',$('#claim_search_date_from').val());
	data.append('date_to',$('#claim_search_date_to').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('payment_claim_list_holder','Fetching data. Wait...');
}

function generate_claim_csv(claim_date,claim_id,ascension_ind){
	
	var data = new FormData();
	data.append('generate_claim_csv',1);
	data.append('claim_date',claim_date);
	data.append('claim_id',claim_id);
	data.append('ascension_ind',ascension_ind);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	$('#active_csv_form_'+claim_date).html('Wait...');
	
	//window.open($('#url').val()+'/excel_export.php?cd='+claim_date+'&c='+company_id+'&f='+_format,'excel_export');
}

function open_spreadsheet(claim_id,user_date,company_id,_type,ascensions,spreadsheet_id,spreadsheet_holders){
	var key = 'hblhsbsrbefibuqpufubnslnlquigrw2187768';
	
	if(spreadsheet_id == ''){
		var claim_type_holder = 'claim_type_date_string_'+claim_id;
		var beneficiary_holder = 'selected_beneficiaries_'+claim_id;
		
	}else{
		var claim_type_holder = spreadsheet_holders+'_claim_types';
		var beneficiary_holder = spreadsheet_holders;
		
		
	}
	
	var claim_type_date_string = $('#'+claim_type_holder).val();
	var claim_type_date_array = claim_type_date_string.split(',');
	
	var beneficiary_string = '';
	for(var c =0;c<claim_type_date_array.length;c++){
		if($('#'+beneficiary_holder+'_'+claim_type_date_array[c]).val() == 0){
			$('#'+beneficiary_holder+'_'+claim_type_date_array[c]).val(0);
			
		}
		
		if(beneficiary_string == ''){
			beneficiary_string = $('#'+beneficiary_holder+'_'+claim_type_date_array[c]).val();
			
		}else{
			beneficiary_string = beneficiary_string+']'+$('#'+beneficiary_holder+'_'+claim_type_date_array[c]).val();
			
		}		
	}
	
	if(_type==4){	
		window.open($('#url').val()+'/spreadsheet2.php?s=true&asc='+ascensions+'&asc_type='+spreadsheet_id+'&k='+key+'&t='+_type+'&ci='+claim_id+'&comp='+company_id+'&u='+user_date+'&b='+beneficiary_string,'spreadsheet');
		
	}else{
		window.open($('#url').val()+'/spreadsheet.php?s=true&asc='+ascensions+'&asc_type='+spreadsheet_id+'&k='+key+'&t='+_type+'&ci='+claim_id+'&comp='+company_id+'&u='+user_date+'&b='+beneficiary_string,'spreadsheet');
		
	}
	
	if(_type==1 && spreadsheet_id == ''){
		var this_timeout = setTimeout("fetch_claim_beneficiaries("+claim_id+",1)",5000);
		
	}
}

function fetch_claim_details(claim_id){
	show_window('item_details',1);
	
	change_window_size('item_details',900,500,1);
	
	$('#item_details_title').html('Payment claim');
	
	var data = new FormData();
	data.append('fetch_claim_details',1);
	data.append('claim_id',claim_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Fetching data. Wait...');
}




function search_claim_agents(){
	
	if($('#selected_new_region').val() == 0){
		$('#claim_error_message').slideDown('fast');
		$('#claim_error_message').html('Select location for this claim');
		
	}else if($('#new_claim_type').val() == ''){
		$('#claim_error_message').slideDown('fast');
		$('#claim_error_message').html('You need to select a claim type before adding beneficiaries');
		
	}else if($('#new_claim_unit').val() == '-1'){
		$('#claim_error_message').slideDown('fast');
		$('#claim_error_message').html('You need to select a unit for this claim');
		
	}else{
		if($('#claim_agent_search_input').val() == 'Enter agent name or phone number' || $('#claim_agent_search_input').val() == ''){
			$('#claim_agent_search_input').css('borderColor','red');
			
			$('#claim_error_message').slideDown('fast');
			$('#claim_error_message').html('Enter name or phone number of agent in the highligted search field');
			
		}else{
			var data = new FormData();
			data.append('search_claim_agents',1);
			data.append('search_key',$('#claim_agent_search_input').val());
			data.append('selected_beneficiaries',$('#selected_beneficiaries').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			
			$('#claim_agent_search_holder').slideDown('fast');
			
			$('#claim_agent_search_holder').css('min-height','150px');
			
			show_loading_progress('claim_agent_search_results_holder','Retrieving. One moment please...');
		}
	}
}

function add_claim_type(claim_date){
	if($('#new_claim_type').val() != ''){
		var selected_claim_types = $('#new_claim_type').val();
		var selected_claim_types_array = selected_claim_types.split(',');
		
		for(var c=0;c<selected_claim_types_array.length;c++){
			this_date = selected_claim_types_array[c];
			
			//$('#claim_check_'+this_date).click();
			document.getElementById('claim_check_'+this_date).checked = false;
			remove_from_selection(this_date,'new_claim_type');
		}
	
	}
	
	document.getElementById('claim_check_'+claim_date).checked = true;
	add_to_selection(claim_date,'new_claim_type');
	
	refresh_request_types();
}

function refresh_request_types(){
	if($('#new_claim_type').val() == ''){
		$('#claim_data_holder').html('');
		$('#claim_total').html(0);
		$('#agent_search_button').click();
		$('#active_claim_type').html('Selet claim type');
		
		
	}else{	
		var selected_claim_types = $('#new_claim_type').val();
		var selected_claim_types_array = selected_claim_types.split(',');
		
		for(var c=0;c<selected_claim_types_array.length;c++){
		
			this_date = selected_claim_types_array[c];
			
			var claim_type_holder = '<div style="border-bottom:solid 1px #eee;width:100%;height:auto;float:left;" id="claim_type_holder_'+this_date+'">'+$('#claim_type_holder_0').html()+'</div>';
			
			var claim_type_holder = claim_type_holder.replace(/_0/g,'_'+this_date);
			
			if(c==0){
				display_infor('claim_data_holder',claim_type_holder);
				
			}else{
				$('#claim_data_holder').append(claim_type_holder);
				
			}
			
			$('#general_claim_type_title_'+this_date).html($('#claim_type_title_'+this_date).html());
		
		}
		if($('#selected_beneficiaries').val() != ''){
			include_all_beneficiaries();
			
		}
	}
}

function add_agent_date_queue(claim_type_date,beneficiary_date){
	if(!search_item_in_list('agent_processing_queue',claim_type_date+'_'+beneficiary_date,',')){
		if($('#agent_processing_queue').val() == ''){		
			$('#agent_processing_queue').val(claim_type_date+'_'+beneficiary_date);
			check_date_error();
			
		}else{
			$('#agent_processing_queue').val($('#agent_processing_queue').val()+','+claim_type_date+'_'+beneficiary_date);
			
		}
		
		$('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).html('Checking for claim conflicts and date errors...');
		$('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).css('color','#000');
		$('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).slideDown();
	}
}

function check_date_error(){
	if($('#agent_processing_queue').val() != ''){
		var agent_processing_queue = $('#agent_processing_queue').val();
		var agent_processing_queue_array = agent_processing_queue.split(',');
		var this_agent_date_array = agent_processing_queue_array[0];
		var this_agent_array = this_agent_date_array.split('_');
		
		claim_type_date = this_agent_array[0];
		beneficiary_date = this_agent_array[1];
		
		var data = new FormData();
		data.append('check_date_error',1);
		data.append('claim_type_date',claim_type_date);
		data.append('beneficiary_date',beneficiary_date);
		data.append('from_date',$('#agent_start_date_'+claim_type_date+'_'+beneficiary_date).val());
		data.append('to_date',$('#agent_end_date_'+claim_type_date+'_'+beneficiary_date).val());
		data.append('claim_date',$('#claim_date').val());
		
		process_simultanious_xmlhttp('module_xmlhttp_2',data);
	}	
}

function check_all_date_errors(){
	var claim_types = $('#new_claim_type').val();
	var claim_type_array = claim_types.split(',');
	
	var beneficiaries = $('#selected_beneficiaries').val();
	
	var beneficiaries_array = beneficiaries.split(',');
	
	for(var c=0;c<claim_type_array.length;c++){
		for(var b=0;b<beneficiaries_array.length;b++){
			add_check_date_queue(claim_type_array[c],beneficiaries_array[b]);
		}
	}	
}


function include_all_beneficiaries(){
	if($('#selected_beneficiaries').val() != ''){
		var selected_claim_types = $('#new_claim_type').val();
		var selected_claim_types_array = selected_claim_types.split(',');
		
		var selected_beneficiaries = $('#selected_beneficiaries').val();
		var selected_beneficiaries_array = selected_beneficiaries.split(',');
		
	/*	for(var c =0;c<selected_claim_types_array.length;c++){
			var this_claim_date = selected_claim_types_array[c];
			*/
			for(var b=0;b<selected_beneficiaries_array.length;b++){
				var this_beneficiary_date = selected_beneficiaries_array[b];
				include_beneficiary(this_beneficiary_date);
			}	
		//}
	}
}

function include_beneficiary(agent_date){
	var selected_claim_types = $('#new_claim_type').val();
	var selected_claim_types_array = selected_claim_types.split(',');
	
	for(var c =0;c<selected_claim_types_array.length;c++){
		var this_claim_date = selected_claim_types_array[c];
		
		var agent_code = '<div style="width:100%;min-height:25px;height:auto;line-height:25px;border-bottom:solid 1px #eee;float:left;" id="beneficiary_item_'+this_claim_date+'_'+agent_date+'">'+$('#agent_default_item_'+agent_date).html()+'</div>';
		
		agent_code = agent_code.replace(/_c/g,'_'+this_claim_date);
		agent_code = agent_code.replace(/_0/g,'_'+agent_date);
		
		$('#claim_type_beneficiaries_holder_'+this_claim_date).append(agent_code);
		
		$("#agent_start_date_"+this_claim_date+"_"+agent_date).datepicker();
		$("#agent_end_date_"+this_claim_date+"_"+agent_date).datepicker();
		
		if($('#claim_billing_type_'+this_claim_date).val() == 0){			
				$('#claim_agent_rate_'+this_claim_date+'_'+agent_date).html($('#claim_rate_'+this_claim_date).val());
			
		}else{
			$('#claim_agent_rate_'+this_claim_date+'_'+agent_date).html('<i>Fixed</i>');
			$('#claim_days_payable_'+this_claim_date+'_'+agent_date).val('N/A');
			document.getElementById('claim_days_payable_'+this_claim_date+'_'+agent_date).disabled = true;
			
		}
		
		if($('#claim_day_adjustment_'+this_claim_date).val() == 0){
			document.getElementById('claim_days_payable_'+this_claim_date+'_'+agent_date).disabled = true;
		}
		
		add_agent_date_queue(this_claim_date,agent_date)
	}
	
	recalculate_newclaim_total();
}

function remove_beneficiary(agent_date){
	var selected_claim_types = $('#new_claim_type').val();
	var selected_claim_types_array = selected_claim_types.split(',');
	
	for(var c =0;c<selected_claim_types_array.length;c++){
		var this_claim_date = selected_claim_types_array[c];
		
		$('#beneficiary_item_'+this_claim_date+'_'+agent_date).remove();
	}
	
	recalculate_newclaim_total()
}

function change_beneficiary_status(claim_type_date,beneficiary_date,_status){
	claim_type_date = claim_type_date.replace('_','');
	beneficiary_date = beneficiary_date.replace('_','');
	
	if(_status == 1){
		$('#beneficiary_item_'+claim_type_date+'_'+beneficiary_date).css('color','#000');
		$('#beneficiary_active_'+claim_type_date+'_'+beneficiary_date).val(1);
		$('#enable_beneficiary_button_'+claim_type_date+'_'+beneficiary_date).hide();
		$('#disable_beneficiary_button_'+claim_type_date+'_'+beneficiary_date).slideDown('fast');
		
		document.getElementById('claim_agent_phone_'+claim_type_date+'_'+beneficiary_date).disabled = false;
		
		document.getElementById('agent_start_date_'+claim_type_date+'_'+beneficiary_date).disabled = false;
		document.getElementById('agent_end_date_'+claim_type_date+'_'+beneficiary_date).disabled = false;
		
		if($('#claim_days_payable_'+claim_type_date+'_'+beneficiary_date).val() != 'N/A' && $('#claim_day_adjustment_'+claim_type_date).val() == 1){
			document.getElementById('claim_days_payable_'+claim_type_date+'_'+beneficiary_date).disabled = false;
			
			
		}
		
		if($('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).html() != '' && $('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).html() != 'Checking for claim conflicts and date errors...'){
			$('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).slideDown('fast');
			$('#agent_'+claim_type_date+'_'+beneficiary_date+'comment').slideDown('fast');
			
		}
		
		if($('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).html() == '<strong>Error:</strong> The "From" date is ahead of the "To" date. This entry will be excluded.'){
			$('#beneficiary_active_'+claim_type_date+'_'+beneficiary_date).val(0);
			
			alert('This entry will still be excluded due to the date error');
			
			$('#agent_'+claim_type_date+'_'+beneficiary_date+'comment').slideUp('fast');
			
		}
		
		add_agent_date_queue(claim_type_date,beneficiary_date);
		
		
	}else{
		$('#beneficiary_item_'+claim_type_date+'_'+beneficiary_date).css('color','#aaa');
		$('#beneficiary_active_'+claim_type_date+'_'+beneficiary_date).val(0);
		$('#enable_beneficiary_button_'+claim_type_date+'_'+beneficiary_date).slideDown('fast');
		$('#disable_beneficiary_button_'+claim_type_date+'_'+beneficiary_date).hide();
		
		document.getElementById('claim_agent_phone_'+claim_type_date+'_'+beneficiary_date).disabled = true;
		
		document.getElementById('agent_start_date_'+claim_type_date+'_'+beneficiary_date).disabled = true;
		document.getElementById('agent_end_date_'+claim_type_date+'_'+beneficiary_date).disabled = true;
		if($('#claim_days_payable_'+claim_type_date+'_'+beneficiary_date).val() != 'N/A' && $('#claim_billing_type_'+claim_type_date).val() == 0){
			document.getElementById('claim_days_payable_'+claim_type_date+'_'+beneficiary_date).disabled = true;
			
		}
		
		$('#beneficiary_date_error_'+claim_type_date+'_'+beneficiary_date).slideUp('fast');
		$('#agent_'+claim_type_date+'_'+beneficiary_date+'comment').slideUp('fast');
	}
	
	recalculate_newclaim_total();
}

function recalculate_newclaim_total(){
	var selected_claim_types = $('#new_claim_type').val();
	var selected_claim_types_array = selected_claim_types.split(',');

	var selected_beneficiaries = $('#selected_beneficiaries').val();
	var selected_beneficiaries_array = selected_beneficiaries.split(',');
	
	var grand_total = 0;
	for(var c =0;c<selected_claim_types_array.length;c++){
		var claim_type_total = 0;
		var this_claim_date = selected_claim_types_array[c];
		
		for(var b=0;b<selected_beneficiaries_array.length;b++){
			var this_beneficiary_date = selected_beneficiaries_array[b];
			
			if($('#claim_billing_type_'+this_claim_date).val() == 0){
				var item_value = Number($('#claim_days_payable_'+this_claim_date+'_'+this_beneficiary_date).val()) * Number($('#claim_agent_rate_'+this_claim_date+'_'+this_beneficiary_date).html());
				
			}else{
				var item_value = Number($('#claim_fixed_amount_'+this_claim_date).val());
				
			}
			
			//item_value = Math.round(item_value,2);
		
			$('#claim_agent_total_'+this_claim_date+'_'+this_beneficiary_date).html(item_value);
			
			if($('#beneficiary_active_'+this_claim_date+'_'+this_beneficiary_date).val() == 1){
				claim_type_total += item_value;
				
				grand_total += item_value;
				
			}
		}
		
		$('#claim_type_total_'+this_claim_date).html(claim_type_total);
	}
	
	$('#claim_total').html(grand_total);
}

function include_fetch_agent_days(claim_type_date,agent_date,agent_id){
	claim_type_date = claim_type_date.replace('_','');
	agent_date = agent_date.replace('_','');
	
	if(!search_item_in_list('agent_days_processing_queue',claim_type_date+'_'+agent_date+'_'+agent_id,',')){
		if($('#agent_days_processing_queue').val() == ''){
			$('#agent_days_processing_queue').val(claim_type_date+'_'+agent_date+'_'+agent_id);
			fetch_agent_days();
			
		}else{
			$('#agent_days_processing_queue').val($('#agent_days_processing_queue').val()+','+claim_type_date+'_'+agent_date+'_'+agent_id);
			
		}
		
		$('#claim_days_worked_'+claim_type_date+'_'+agent_date).html('Wait...');
		if($('#claim_billing_type_'+claim_type_date).val() == 0){
			$('#claim_days_payable_'+claim_type_date+'_'+agent_date).val('Wait...');		
		}
		
		$('#claim_days_worked_'+claim_type_date+'_'+agent_date).css('color','black');
	}
	
	add_agent_date_queue(claim_type_date,agent_date)
}

function fetch_agent_days(){
	if($('#agent_days_processing_queue').val() != ''){
		var processing_queue = $('#agent_days_processing_queue').val();
		var processing_queue_array = processing_queue.split(',');
		var this_processing_queue_values = processing_queue_array[0];
		var this_processing_queue_value_array = this_processing_queue_values.split('_');
		
		var claim_type_date = this_processing_queue_value_array[0];
		var agent_date = this_processing_queue_value_array[1];
		var agent_id = this_processing_queue_value_array[2];
		
		var data = new FormData();
		data.append('fetch_agent_days',1);
		data.append('agent_date',agent_date);
		data.append('agent_id',agent_id);
		data.append('claim_type_date',claim_type_date);
		data.append('unit_id',$('#new_claim_unit').val());
		data.append('date_from',$('#agent_start_date_'+claim_type_date+'_'+agent_date).val());
		data.append('date_to',$('#agent_end_date_'+claim_type_date+'_'+agent_date).val());
		
		process_simultanious_xmlhttp('module_xmlhttp_3',data);
	}
}

function add_claim_files(){	
	open_uploader('process_claim_images()',1);
	$('#uploader_window_title').css('background-color','#d697ee');
}

function add_approval_file(claim_date,claim_type_date,level_index){
	$('#uploaded_files').val('');
	open_uploader("process_approval_files('"+claim_date+"','"+claim_type_date+"','"+level_index+"')",1);
	$('#uploader_window_title').css('background-color','#35bcc7');
	
}

function process_approval_files(claim_date,claim_type_date,level_index){
	$('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val($('#uploaded_files').val());
	
	var addition_div = '<div style="font-weight:bold;padding-left:4px;width:99%;height:auto;float:left;margin-top:5px;margin-bottom:15px;">Uploaded files: </div>';
	
	var added_files = $('#uploaded_files').val();
	var added_files_array = added_files.split(',');
	
	
	for(var f=0;f<added_files_array.length;f++){
		
		var added_file_name = added_files_array[f];
		
		if(added_file_name.length > 10){
			added_file_name = added_file_name.substring(0,10)+'...';
			
		}
		
		addition_div = addition_div+'<br><a title="Click to open file" style="cursor:pointer;" onmouseover="this.style.color=\'orange\'" onmouseout="this.style.color=\'\'" onclick="window.open(\''+$('#url').val()+'/imgs/'+added_files_array[f]+'\',\'file_download\')">'+(f+1)+'. '+added_file_name+'</a><br>';
		
	}
	
	addition_div = addition_div+'<div style="font-weight:bold;width:30px;margin-left:40px;height:20px;line-height:20px;float:left;text-algin:center;font-size:1.5em;margin-bottom:5px;color:orange;cursor:pointer;" onmouseover="this.style.color=\'#000\';" onmouseout="this.style.color=\'orange\'" title="Click to change files" onclick="$(\'#added_file_holder_'+claim_date+'_'+claim_type_date+'_'+level_index+'\').slideUp(\'fast\');$(\'#add_file_holder_'+claim_date+'_'+claim_type_date+'_'+level_index+'\').slideDown(\'fast\');" id="file_redo_button_'+claim_date+'_'+claim_type_date+'_'+level_index+'">&#8634</div>';
	
	$('#added_file_holder_'+claim_date+'_'+claim_type_date+'_'+level_index).html(addition_div);
	$('#added_file_holder_'+claim_date+'_'+claim_type_date+'_'+level_index).slideDown('fast');
	
	$('#add_file_holder_'+claim_date+'_'+claim_type_date+'_'+level_index).slideUp('fast');
	
	reset_image_upload();
	
	close_window('image_uploader');
	
}

function process_claim_images(){
	if($('#save_upload_images').html() != 'Wait...'){
		var data = new FormData();
		data.append('process_claim_images',1);
		data.append('uploaded_files',$('#uploaded_files').val());
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#save_upload_images').html('Wait');
	}
}

function create_or_update_claim(claim_id){
	if($('#create_or_update_claim_button').html() != 'Wait...'){
		
		if($('#selected_new_region').val() == 0){
			$('#claim_error_message').slideDown('fast');
			$('#claim_error_message').html('You need to select a location for this claim');
		
		}else if($('#claim_total').html() == 0){
			$('#claim_error_message').slideDown('fast');
			$('#claim_error_message').html('You cannot create a claim of K0 value. Please check if all beneficiaries have been included and all payment periods correctly specified');
			
		}else{
			var error=0;
			var zero_error = 0;
			var selected_claim_types = $('#new_claim_type').val();
			var selected_claim_types_array = selected_claim_types.split(',');

			var selected_beneficiaries = $('#selected_beneficiaries').val();
			var selected_beneficiaries_array = selected_beneficiaries.split(',');
			
			for(var c = 0;c<selected_claim_types_array.length;c++){
				var this_claim_date = selected_claim_types_array[c];
				
				for(var b=0;b<selected_beneficiaries_array.length;b++){
					var this_beneficiary_date = selected_beneficiaries_array[b];
					
					if($('#claim_billing_type_'+this_claim_date).val() == 0 && $('#claim_day_adjustment_'+this_claim_date).val() == 1 && $('#beneficiary_active_'+this_claim_date+'_'+this_beneficiary_date).val() == 1){
						if(($('#claim_days_payable_'+this_claim_date+'_'+this_beneficiary_date).val() != $('#claim_days_original_payable_'+this_claim_date+'_'+this_beneficiary_date).val()) && $('#agent_'+this_claim_date+'_'+this_beneficiary_date+'comment_input').val() == 'Enter comment here'){
							$('#agent_'+this_claim_date+'_'+this_beneficiary_date+'comment').slideDown('fast');
							$('#agent_'+this_claim_date+'_'+this_beneficiary_date+'comment_input').css('border-color','red');
							error=1;
						}
						
					}

					if($('#beneficiary_active_'+this_claim_date+'_'+this_beneficiary_date).val() == 1 && $('#claim_agent_total_'+this_claim_date+'_'+this_beneficiary_date).html() == '0'){
						zero_error = 1;
					}					
				}	
			}
			
			if(error){
				$('#claim_error_message').slideDown('fast');
				$('#claim_error_message').html('You have changed the payable days the system computed for some beneficiaries. Please add justifications for these changes in highligted comment fields');
				
			
				
			}else{
				var c_message = 'Do you wish to proceed creating this claim?';
				
				if($('#uploaded_files').val() == ''){
					var c_message = 'This claim has no attachments added. '+c_message;
					
				}
				
				if(zero_error){
					c_message = c_message+' (Please note that entries with zero total amounts will be excluded)';
					
				}
				
				var c=confirm(c_message);
				
				if(c){
					var data = new FormData();
					data.append('create_or_update_claim',1);
					data.append('claim_id',claim_id);
					data.append('unit_id',$('#new_claim_unit').val());
					data.append('claim_types',$('#new_claim_type').val());				
					data.append('claim_beneficiaries',$('#selected_beneficiaries').val());
					data.append('uploaded_files',$('#uploaded_files').val());
					data.append('claim_total',$('#claim_total').html());
					
					data.append('region_id',$('#selected_new_region').val());
					data.append('province_id',$('#selected_new_province').val());
					data.append('hub_id',$('#selected_new_hub').val());
					data.append('site_id',$('#selected_new_site').val());
					
					var selected_claim_types = $('#new_claim_type').val();
					var selected_claim_types_array = selected_claim_types.split(',');

					var selected_beneficiaries = $('#selected_beneficiaries').val();
					var selected_beneficiaries_array = selected_beneficiaries.split(',');
					
					for(var c = 0;c<selected_claim_types_array.length;c++){
						var this_claim_date = selected_claim_types_array[c];
						
						for(var b=0;b<selected_beneficiaries_array.length;b++){
							var this_beneficiary_date = selected_beneficiaries_array[b];
							
							data.append('phone_number_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_agent_phone_'+this_claim_date+'_'+this_beneficiary_date).val());
							if(!claim_id){
								data.append('nrc_number_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_agent_nrc_'+this_claim_date+'_'+this_beneficiary_date).val());
								
							}else{
								data.append('nrc_number_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_agent_nrc_'+this_claim_date+'_'+this_beneficiary_date).html());
								
							}
							data.append('date_from_'+this_claim_date+'_'+this_beneficiary_date,$('#agent_start_date_'+this_claim_date+'_'+this_beneficiary_date).val());
							data.append('date_to_'+this_claim_date+'_'+this_beneficiary_date,$('#agent_end_date_'+this_claim_date+'_'+this_beneficiary_date).val());
							data.append('days_worked_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_days_worked_'+this_claim_date+'_'+this_beneficiary_date).html());
							
							data.append('days_payable_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_days_payable_'+this_claim_date+'_'+this_beneficiary_date).val());
							
							data.append('rate_'+this_claim_date+'_'+this_beneficiary_date,$('#claim_agent_rate_'+this_claim_date+'_'+this_beneficiary_date).html());
							
							data.append('comment_'+this_claim_date+'_'+this_beneficiary_date,$('#agent_'+this_claim_date+'_'+this_beneficiary_date+'comment_input').val());
							data.append('beneficiary_active_'+this_claim_date+'_'+this_beneficiary_date,$('#beneficiary_active_'+this_claim_date+'_'+this_beneficiary_date).val());
							
						}
					}
					
					process_simultanious_xmlhttp('module_xmlhttp',data);

					$('#create_or_update_claim_button').html('Wait...');
				}
			}
		}
	}
}


function disable_claim(claim_date){
	if($('#claim_disable_button_'+claim_date).html() != 'Wait...'){
		var c = confirm('Are you sure you wish to disable this claim?');
		
		if(c){
			var data = new FormData();
			data.append('disable_claim',1);
			data.append('claim_date',claim_date);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#claim_disable_button_'+claim_date).html('Wait...');
		}
	}
}

function enable_claim(claim_date){
	if($('#claim_enable_button_'+claim_date).html() != 'Wait...'){
		var c = confirm('Are you sure you wish to enable this claim?');
		
		if(c){
			var data = new FormData();
			data.append('enable_claim',1);
			data.append('claim_date',claim_date);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#claim_enable_button_'+claim_date).html('Wait...');
		}
	}
}

function fetch_claim_type_code(){
	var data = new  FormData();
	data.append('fetch_claim_type_code',1);
	
	if($('#selected_status').val() == undefined){
		data.append('status',1);
		
	}else{
		data.append('status',$('#selected_status').val());
		
	}
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('claim_type_list_holder','Exctacting. One moment please...');
}


function fetch_claim_type_list(){
	fetch_script('_codes/approval_settings.php','settings',1);
	
}

function fetch_claim_type_list_code(){
	var data = new FormData();
	data.append('fetch_claim_type_list_code',1);
	
	data.append('status',$('#selected_status').val());
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('site_id',$('#selected_site').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('approval_settings','Preparing data. Wait...');
	
}


function fetch_claim_type_details(claim_type_id){
	var data = new FormData();
	data.append('fetch_claim_type_details',1);
	data.append('claim_type_id',claim_type_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_window('item_details',1);
	
	show_loading_progress('item_details_holder','Fetching data. Wait...');
	
	change_window_size('item_details',700,500,1);
}

function add_approval_upload(level){
	var this_level = level.replace('_','');
	var total_documents = Number($('#total_documents_'+this_level).val());
	
	var document_div = '<div style="width:100%;height:30px;line-height:30px;float:left;" id="document_'+this_level+'_'+total_documents+'_holder">'+$('#document_'+this_level+'_0_holder').html()+'</div>';
	
	document_div = document_div.replace(/_x/g,'_'+total_documents);
	document_div = document_div.replace('document_active_'+this_level+'_0','document_active_'+this_level+'_'+total_documents);
	document_div = document_div.replace('document_'+this_level+'_0','document_'+this_level+'_'+total_documents);
	document_div = document_div.replace('remove_button_'+this_level+'_0','remove_button_'+this_level+'_'+total_documents);
	
	document_div = document_div.replace(/Document 1/g,'Document '+(total_documents+1));
		
	$('#document_holder_'+this_level).append(document_div);
	
	$('#remove_button_'+this_level+'_'+total_documents).slideDown('fast');
	
	total_documents++;
	$('#total_documents_'+this_level).val(total_documents);
}

function remove_approval_upload(level,document_ind){
	var this_level = level.replace('_','');
	var this_document = document_ind.replace('_','');
	
	$('#document_'+this_level+'_'+this_document+'_holder').slideUp('fast');
	$('#document_active_'+this_level+'_'+this_document).val(0);
}

function enable_or_disable_request_type(request_type_id,action_type){
	if($('#disable_request_type_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('enable_or_disable_request_type',1);
		data.append('request_type_id',request_type_id);
		data.append('action_type',action_type);
		
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#disable_request_type_button').html('Wait...');
		$('#enable_request_type_button').html('Wait...');
	}
}

function enable_or_disable_threshold(threshold_id,action_type){
	if($('#threshold_status_change_button').html() != 'Wait...'){
		var data = new FormData();
		data.append('enable_or_disable_threshold',1);
		data.append('threshold_id',threshold_id);
		data.append('action_type',action_type);		
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#threshold_status_change_button').html('Wait...');
	}
}





function confirm_level(claim_date,claim_type_date,beneficiary_date,claim_type_index,level_index,request_type,action_type){
	
	var all_uploaded = 1;
	if(action_type == 1){
		var total_files = Number($('#total_confirm_files_'+claim_date+'_'+claim_type_date+'_'+level_index).val());

		for(var f=0;f<total_files;f++){
			if($('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val() == ''){
				all_uploaded = 0;
			}
		}
	}
	
	if(level_index == 0){
		var last_level_approved = 1;
		
	}else{
		
		var last_level_approved = 0;
		if($('#level_action_type_'+claim_date+'_'+claim_type_date+'_'+(level_index-1)).val() == 1){			
			if($('#level_approved_'+claim_date+'_'+claim_type_date+'_0_'+(level_index-1)).val() == 1){
				last_level_approved = 1;
				
			}
			
			
		}else{
			if(action_type == 1){
				var claim_beneficiaries = $('#all_beneficiaries_'+claim_date+'_'+claim_type_date).val();
				var claim_beneficiaries_array = claim_beneficiaries.split(',');
				
				last_level_approved = 1;
			
				for(var cb=0;cb<claim_beneficiaries_array.length;cb++){
					
					if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+claim_beneficiaries_array[cb]+'_'+(level_index-1)).val() == 0){
						last_level_approved = 0;
						break;
					}					
				}
				
				
			}else{
				if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+beneficiary_date+'_'+(level_index-1)).val() == 1){
					last_level_approved = 1;
					
				}
			}				
		}		
	}
	
	if(last_level_approved == 0){
		alert('Level '+(level_index)+' needs to be approved before approving this level');
		$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level_index).slideDown('fast');
		
	}else{		
		if(all_uploaded == 0){
			alert('You need to upload all files for level '+(level_index+1));
		
		}else if(!request_type){
			var c = confirm('Are you sure you want to approve this level?');
			
		}else{
			var c = 1;
		}
		
		if(c){
			if(!search_item_in_list('approval_queue',claim_date+'-'+claim_type_date+'-'+beneficiary_date+'-'+claim_type_index+'-'+level_index,',')){
				if($('#approval_queue').val() == ''){
					$('#approval_queue').val(claim_date+'}'+claim_type_date+'}'+beneficiary_date+'}'+claim_type_index+'}'+level_index+'}'+$('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val());
					
					var act = setTimeout("process_level_confirm_queue()",1000);
					
				}else{
					$('#approval_queue').val($('#approval_queue').val()+'|'+claim_date+'}'+claim_type_date+'}'+beneficiary_date+'}'+claim_type_index+'}'+level_index+'}'+$('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val());
					
				}
				
				$('#beneficiary_'+claim_date+'_'+claim_type_date+'_'+beneficiary_date+'_'+claim_type_index+'_'+level_index+'_level').html('Approving...');
				
				$('#file_approver_bottons_'+claim_date+'_'+claim_type_date+'_'+level_index).html('Approving...');
			}
		}
	}
}

function process_level_confirm_queue(){
	if($('#approval_queue').val() != ''){
		var approval_code = $('#approval_queue').val();		
		var approval_code_array = approval_code.split('|');
		
		var data = new FormData();
		data.append('process_level_confirm_queue',1);
		data.append('approval_code',approval_code_array[0]);
		data.append('total_in_queue',approval_code_array.length);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
	}	
}

function confirm_level_all(claim_date,claim_type_date,claim_type_index,level_index){
	var c = confirm('Are you sure you want to approve this level for all selected beneficiaries?');
	
	if(c){
		if($('#selected_beneficiaries_'+claim_date+'_'+claim_type_date).val() == ''){
			var c1 = confirm('You have not selected any beneficiary for this claimm type. Do you wish to approve all applicable beneficiaries for this claim type?');
			
			var selected_beneficiaries = $('#all_beneficiaries_'+claim_date+'_'+claim_type_date).val();
			
		}else{
			var c1 = 1;
			var selected_beneficiaries = $('#selected_beneficiaries_'+claim_date+'_'+claim_type_date).val();
		}
		
		
		
		
		var selected_beneficiaries_array = selected_beneficiaries.split(',');

		for(var b=0;b<selected_beneficiaries_array.length;b++){
			if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+selected_beneficiaries_array[b]+'_'+level_index).val() == 0){
				confirm_level(claim_date,claim_type_date,selected_beneficiaries_array[b],claim_type_index,level_index,1,1);
			}
		}
		
		$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level_index).slideUp('fast');
	}
}

function check_all_claims(claim_date){
	var claim_types = $('#claim_type_date_string_'+claim_date).val();
	
	var claim_type_array = claim_types.split(',');
	
	for(var c =0;c<claim_type_array.length;c++){		
		var beneficiaries_string = $('#all_beneficiaries_'+claim_date+'_'+claim_type_array[c]).val();
		var beneficiaries_array = beneficiaries_string.split(',');
		
		for(var b=0;b<beneficiaries_array.length;b++){
			$('#beneficiary_checkbox_'+claim_date+'_'+claim_type_array[c]+'_'+beneficiaries_array[b]).click();
		}		
	}	
}





//Rejecting levels
function reject_level(claim_date,claim_type_date,beneficiary_date,claim_type_index,level_index,request_type,action_type){	
	
	if(level_index == 0){
		var last_level_approved = 1;
		
	}else{
		
		var last_level_approved = 0;
		
		if($('#level_action_type_'+claim_date+'_'+claim_type_date+'_'+(level_index-1)).val() == 1){			
			if($('#level_approved_'+claim_date+'_'+claim_type_date+'_0_'+(level_index-1)).val() == 1){
				last_level_approved = 1;
				
			}
			
			
		}else{
			if(action_type == 1){
				var claim_beneficiaries = $('#selected_beneficiaries_'+claim_date+'_'+claim_type_date).val();
				var claim_beneficiaries_array = claim_beneficiaries.split(',');
				
				last_level_approved = 1;
				for(var cb=0;cb<claim_beneficiaries_array.length;cb++){
					
					if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+claim_beneficiaries_array[cb]+'_'+(level_index-1)).val() == 0){
						last_level_approved = 0;
						break;
					}					
				}
				
				
			}else{
				if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+beneficiary_date+'_'+(level_index-1)).val() == 1){
					last_level_approved = 1;
					
				}
			}				
		}		
	}
	
	if(last_level_approved == 0){
		$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level_index).slideDown('fast');
		alert('Level '+(level_index)+' must be approved before acting on this level');
		
	}else{
		
		if($('#selected_re_approval').val() == undefined){
			fetch_rejection_options(claim_date,claim_type_date,beneficiary_date,claim_type_index,level_index,request_type,action_type);
		
		}else if(!request_type){
			var c = confirm('Are you sure you want to reject this level?');
			
		}else{
			var c = 1;
		}
		
		
		if(c){
			$('#level_continue_rejection_button').html('Wait...');
			if(!search_item_in_list('rejection_queue',claim_date+'-'+claim_type_date+'-'+beneficiary_date+'-'+claim_type_index+'-'+level_index,',')){
				if($('#rejection_queue').val() == ''){
					$('#rejection_queue').val(claim_date+'}'+claim_type_date+'}'+beneficiary_date+'}'+claim_type_index+'}'+level_index+'}'+$('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val()+'}'+$('#selected_jump_level').val()+'}'+$('#selected_re_approval').val()+'}'+$('#rejection_comment').val());
					
					process_level_reject_queue();
					
				}else{
					$('#rejection_queue').val($('#rejection_queue').val()+'|'+claim_date+'}'+claim_type_date+'}'+beneficiary_date+'}'+claim_type_index+'}'+level_index+'}'+$('#file_'+claim_date+'_'+claim_type_date+'_'+level_index).val()+'}'+$('#selected_jump_level').val()+'}'+$('#selected_re_approval').val()+'}'+$('#rejection_comment').val());
					
				}
				
				$('#beneficiary_'+claim_date+'_'+claim_type_date+'_'+beneficiary_date+'_'+claim_type_index+'_'+level_index+'_level').html('Approving...');
				
				$('#file_approver_bottons_'+claim_date+'_'+claim_type_date+'_'+level_index).html('Approving...');
			}
		}
	}
}

function process_level_reject_queue(){
	if($('#rejection_queue').val() != ''){
		var rejection_code = $('#rejection_queue').val();		
		var approval_code_array = rejection_code.split('|');
		
		var data = new FormData();
		data.append('process_level_reject_queue',1);
		data.append('rejection_code',approval_code_array[0]);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
	}	
}

function reject_level_all(claim_date,claim_type_date,claim_type_index,level_index){
	var c = confirm('Are you sure you want to reject this level for all selected beneficiaries?');
	
	if(c){
		var selected_beneficiaries = $('#selected_beneficiaries_'+claim_date+'_'+claim_type_date).val();
		
		var selected_beneficiaries_array = selected_beneficiaries.split(',');
		
		for(var b=0;b<selected_beneficiaries_array.length;b++){
			if($('#level_approved_'+claim_date+'_'+claim_type_date+'_'+selected_beneficiaries_array[b]+'_'+level_index).val() == 0){
				reject_level(claim_date,claim_type_date,selected_beneficiaries_array[b],claim_type_index,level_index,1,0);
			}
		}
		
		$('#all_actions_'+claim_date+'_'+claim_type_date+'_'+level_index).slideUp('fast');
	}
}

function fetch_rejection_options(claim_date,claim_type_date,beneficiary_date,claim_type_index,level_index,request_type,action_type){
	
	var data = new FormData();
	data.append('fetch_rejection_options',1);
	data.append('claim_date',claim_date);
	data.append('claim_type_date',claim_type_date);
	data.append('beneficiary_date',beneficiary_date);
	data.append('level_index',level_index);
	data.append('claim_type_index',claim_type_index);
	data.append('request_type',request_type);
	data.append('action_type',action_type);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details');
	
	change_window_size('item_details',450,500,1);
	
	show_loading_progress('item_details_holder','Preparing options. Wait...');
	$('#item_details_title').html('Level '+(level_index+1)+' rejection options');
	$('#item_details_title_bar').css('background-color','#e18d8d');
	
	$('#details_close_button').attr('onclick',"close_window('item_details');$('#item_details_holder').html('');");
}

function change_claim_status(claim_date){
	var data = new FormData();
	
	data.append('change_claim_status',1);
	data.append('claim_date',claim_date);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	show_window('item_details');
	
	change_window_size('item_details',450,500,1);
	
	show_loading_progress('item_details_holder','Preparing options. Wait...');
	$('#item_details_title_bar').css('background-color','brown');
	$('#item_details_title').html('Change claim status');
	$('#item_details_title_bar').css('background-color','#b0b679');
}

function process_change_claim_status(claim_date){
	if($('#claim_status_change_button').html() != 'Wait...'){
		var c = confirm('Are you sure you wish to change the satus of this claim?');
		
		if(c){
			var data = new FormData();
			data.append('process_change_claim_status',1);
			data.append('new_status',$('#claim_new_status').val());
			data.append('claim_date',claim_date);
			data.append('comment',$('#status_change_comment').val());
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#claim_status_change_button').html('Wait...');
		}
	}
}

function fetch_request_type_agent(){
	var data = new FormData();
	data.append('fetch_request_type_agent',1);
	data.append('search_key',$('#agent_search_key').val());
	show_loading_progress('search_agent_results_holder','Fetching agents. Wait...');
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function add_to_request_type_agent(agent_id,agent_name,phone_number,nrc){	
	var div_code = '<div style="float:left;width:auto;height:30px;line-height:30px;text-align:center;background-color:#d6b8d6;margin:5px;margin-bottom:0px;padding-left:5px;" id="request_type_beneficiary_'+agent_id+'" title="Phone: '+phone_number+', NRC: '+nrc+'">'+agent_name+'<div style="margin-left:2px;color:#fff;width:20px;float:right;height:30px;line-height:30px;text-align:center;background-color:brown;cursor:pointer;" onmouseover="this.style.backgroundColor=\'red\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="remove_from_request_type_agent('+agent_id+');" title="Click to remove">X</div></div>';
	
	$('#request_type_beneficiaries_holder').append(div_code);
	
	add_to_selection(agent_id,'selected_request_type_agents');
	
}

function remove_from_request_type_agent(agent_id){
	var c = confirm('Are you sure you wish to remove this agent?');
	
	if(c){
		remove_from_selection(agent_id,'selected_request_type_agents');
		$('#request_type_beneficiary_'+agent_id).remove();
	
	}else{
		document.getElementById('agent_'+agent_id+'_checkbox').checked = true;
		
	}
}

function fetch_claim_schedule(){
	var data = new FormData();
	data.append('fetch_claim_schedule',1);
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('user_id',$('#selected_user').val());
	data.append('unit_id',$('#selected_unit').val());
	data.append('claim_type_id',$('#selected_claim_type').val());
	data.append('level',$('#selected_level').val());
	data.append('level_consideration',$('#selected_level_consideration').val());
	data.append('status',$('#claim_status').val());
	
	data.append('date_from',$('#claim_search_date_from').val());
	data.append('date_to',$('#claim_search_date_to').val());
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('claim_schedule_list_holder','Fetching data. Wait...');
}

function fetch_awaiting_beneficiaries(awaiting_date){
	$('#awaiting_'+awaiting_date+'_beneficiaries').slideToggle('fast');
	$('#claims_filter_options').slideUp('fast');
	
	if($('#awaiting_'+awaiting_date+'_active').val() == 0){
		var this_progress_text = '<div style="width:100%;height:200px;text-align:center;float:left;font-size:1.1em;" ><div style="width:100%;height:20px;float:left;margin-top:70px;">Loading beneficiaries. One moment please...</div><div style="width:100%;height:20px;float:left;"><img src="'+$('#code_url').val()+'/imgs/loading.gif"></div></div>';
		
		display_infor('awaiting_'+awaiting_date+'_beneficiaries',this_progress_text);
		
		$('#awaiting_'+awaiting_date+'_active').val(1);
		
		$('#awaiting_'+awaiting_date).attr("onmouseover","this.style.backgroundColor='#d2a1a1'");
		$('#awaiting_'+awaiting_date).attr("onmouseout","this.style.backgroundColor='#d69494'");
		$('#awaiting_'+awaiting_date).css('backgroundColor','#d69494');
		$('#awaiting_'+awaiting_date).css('color','#fff');
		
		var data = new FormData();
		data.append('fetch_awaiting_beneficiaries',1);
		data.append('awaiting_date',awaiting_date);
		
		process_simultanious_xmlhttp('awaiting_xmlhttp_'+awaiting_date,data);
		
	}else{
		$('#awaiting_'+awaiting_date+'_active').val(0);
		
		$('#awaiting_'+awaiting_date).attr("onmouseover","this.style.backgroundColor='#eee'");
		$('#awaiting_'+awaiting_date).attr("onmouseout","this.style.backgroundColor=''");
		$('#awaiting_'+awaiting_date).css("color",'');
		$('#awaiting_'+awaiting_date).css('backgroundColor','');
		
	}
}

function fetch_awaiting_creation_claims(){
	var data = new FormData();
	data.append('fetch_awaiting_creation_claims',1);
	data.append('region_id',$('#selected_region').val());
	data.append('province_id',$('#selected_province').val());
	data.append('hub_id',$('#selected_hub').val());
	data.append('date_from',$('#claim_search_date_from').val());
	data.append('date_to',$('#claim_search_date_to').val());
	
	show_loading_progress('awaiting_creation_holder','Fetching data. Wait...');
	process_simultanious_xmlhttp('module_xmlhttp',data);
}

function create_claim_from_awaiting(claim_date){
	if($('#create_awaiting_claim_button_'+claim_date).html() != 'Wait...'){
		var c= confirm('Are you sure you wish to create this claim? Please note that beneficiaries with 0 amount will be skipped. This entry will be deleted after creation');
		
		if(c){
			var data = new FormData();
			data.append('create_claim_from_awaiting',1);
			data.append('claim_date',claim_date);
			
			process_simultanious_xmlhttp('awaiting_xmlhttp_'+claim_date,data);
			
			$('#create_awaiting_claim_button_'+claim_date).html('Wait...');
		}
	}
}

function delete_awaiting_claim(claim_date){
	if($('#delete_awaiting_claim_button_'+claim_date).html() != 'Wait...'){
		
		var c= confirm('Are you sure you wish to delete this entry? This action cannot be undone');
		if(c){
			var data = new FormData();
			data.append('delete_awaiting_claim',1);
			data.append('claim_date',claim_date);
			
			process_simultanious_xmlhttp('awaiting_xmlhttp_'+claim_date,data);
			
			$('#delete_awaiting_claim_button_'+claim_date).html('Wait...');
		}
	}
}

function fetch_claim_schedule_details(schedule_id){
	show_window('item_details',1);
	
	change_window_size('item_details',800,500,1);
	
	$('#item_details_title').html('Schedule details');
	$('#details_close_button').attr("onclick","$('#item_details_holder').html('');close_window('item_details')")
	
	var data = new FormData();
	data.append('fetch_claim_schedule_details',1);
	data.append('schedule_id',schedule_id);
	
	process_simultanious_xmlhttp('module_xmlhttp',data);
	
	show_loading_progress('item_details_holder','Fetching data. Wait...');
}

function create_or_update_schedule_type(schedule_id){
	if($('#update_or_create_request_type_button').html() != 'Wait...'){
		if($('#selected_claim_type').val() == ''){
			$('#error_message').slideDown('fast');
			$('#error_message').html('You need to select a claim type');
		
		}else if($('#selected_region').val() == '-1'){
			$('#error_message').slideDown('fast');
			$('#error_message').html('Select a region for which this instruction should be executed');
			
		}else{
			var data = new FormData();
			data.append('create_or_update_schedule_type',1);
			data.append('schedule_id',schedule_id);
			data.append('scheduler_trigger',$('#selected_schedule_trigger').val());
			data.append('trigger_day',$('#selected_trigger_day').val());
			data.append('trigger_month_day',$('#selected_trigger_date').val());
			data.append('scheduler_payment_from_date_day',$('#selected_from_day').val());
			data.append('scheduler_payment_from_date_month',$('#selected_from_month').val());
			data.append('scheduler_payment_from_date_month_operator',$('#selected_payment_from_month_operator').val());
			data.append('scheduler_payment_from_date_month_addition',$('#payment_from_addition').val());
			
			data.append('scheduler_payment_to_date_day',$('#selected_to_day').val());
			data.append('scheduler_payment_to_date_month',$('#selected_to_month').val());
			data.append('scheduler_payment_to_date_month_operator',$('#selected_payment_to_month_operator').val());
			data.append('scheduler_payment_to_date_month_addition',$('#payment_to_addition').val());
			
			data.append('scheduler_recurrence',$('#selected_trigger_recurrence').val());
			data.append('scheduler_schedule_type',$('#selected_schedule_type').val());
			data.append('scheduler_location_depth',$('#selected_location_depth').val());
			data.append('scheduler_unknown_locations',$('#selected_unspecified_locations').val());
			data.append('scheduler_days_worked_id',$('#selected_days_worked').val());
			data.append('scheduler_force_days',$('#force_days').val());
			data.append('scheduler_force_days_justification',$('#force_days_justification').val());
			data.append('scheduler_schedule_rule',$('#selected_schedule_rule').val());
			data.append('scheduler_beneficiary_type',$('#selected_beneficiary_selection').val());
			data.append('scheduler_agent_groups',$('#selected_agent_type').val());
			data.append('scheduler_agent_units',$('#selected_unit').val());
			data.append('scheduler_custom_agents',$('#selected_request_type_agents').val());
			data.append('scheduler_execution_notification',$('#selected_schedule_notification').val());
			
			data.append('request_type_dates',$('#selected_claim_type').val());
			data.append('region_id',$('#selected_region').val());
			data.append('province_id',$('#selected_province').val());
			data.append('hub_id',$('#selected_hub').val());
			data.append('mother_facility_id',$('#selected_mother_facility').val());
			data.append('site_id',$('#selected_site').val());
			
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			$('#update_or_create_request_type_button').html('Wait...');
		}
	}
}

function delete_schedule_type(schedule_id){
	if($('#delete_schedule_button').html() != 'Wait...'){
		
		var c = confirm('Are you sure you wish to delete this schedule?');
		
		if(c){
			var data = new FormData();
			data.append('delete_schedule_type',1);
			data.append('schedule_id',schedule_id);
			
			process_simultanious_xmlhttp('module_xmlhttp',data);
			
			$('#delete_schedule_button').html('Wait...');
		}
	}
}

function change_status_spreadsheet_beneficiary(claim_date,ascension_ind,beneficiary_date,claim_type_date,new_status,spreadsheet_identifier){
	if($('#ascension_beneficiary_status_'+claim_date+'_'+ascension_ind+'_'+beneficiary_date+'_'+claim_type_date).html() == ''){
		var c = confirm('Are you sure you wish to remove this beneficiary from this spreadsheet?');
		
		if(c){
			var processing_queue = $('#spreadsheet_beneficiary_remove_queue_'+claim_date+'_'+ascension_ind).val();
			
			if(processing_queue==''){
				$('#spreadsheet_beneficiary_remove_queue_'+claim_date+'_'+ascension_ind).val(claim_date+'-'+beneficiary_date+'-'+claim_type_date+'-'+new_status);
				
			}else{
				$('#spreadsheet_beneficiary_remove_queue_'+claim_date+'_'+ascension_ind).val(processing_queue+','+claim_date+'-'+beneficiary_date+'-'+claim_type_date+'-'+new_status);
				
			}
			
			$('#ascension_beneficiary_status_'+claim_date+'_'+ascension_ind+'_'+beneficiary_date+'_'+claim_type_date).html('<i>Queued for status change</i>');
			
			if(processing_queue == ''){
				run_spreadsheet_beneficiary_queue(claim_date,ascension_ind,spreadsheet_identifier);
				
			}
		}
	}
}

function run_spreadsheet_beneficiary_queue(claim_date,ascension_ind,spreadsheet_identifier){
	
	var processing_queue = $('#spreadsheet_beneficiary_remove_queue_'+claim_date+'_'+ascension_ind).val();
	var processing_queue_array = processing_queue.split(',');
	
	if(processing_queue != ''){
		this_queue_item = processing_queue_array[0];
		
		var this_processing_queue_array = this_queue_item.split(',');
		
		var beneficiary_array = this_processing_queue_array[0].split('-');
		//alert(beneficiary_array.length);
		var data = new FormData();
		data.append('run_spreadsheet_beneficiary_queue',1);
		data.append('ascension_ind',ascension_ind);
		data.append('claim_date',beneficiary_array[0]);
		data.append('beneficiary_date',beneficiary_array[1]);
		data.append('claim_type_date',beneficiary_array[2]);
		data.append('new_status',beneficiary_array[3]);
		data.append('spreadsheet_identifier',spreadsheet_identifier);
		
		process_simultanious_xmlhttp('module_xmlhttp',data);
		
		$('#ascension_beneficiary_status_'+ascension_ind+'_'+beneficiary_array[0]+'_'+beneficiary_array[1]).html('<i>Changing status</i>');
	}
}