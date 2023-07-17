<?php
if($claim_id){
	$button_title = 'Update';
	$this_claim_date = $this_claim_results['_date'];
	
	$this_region_id = $this_claim_results['region_id'];
	$this_province_id = $this_claim_results['province_id'];
	$this_district_id = $this_claim_results['hub_id'];
	$this_site_id = $this_claim_results['site_id'];
	
	$new_claim_type_date = $this_claim_results['claim_type_date'];
	$claim_type_date_array = explode(',',$this_claim_results['claim_type_date']);
	
	$claim_type_list = $this_claim_results['claim_type_date'];
	
	if(count($claim_type_date_array) > 1){
		$title_type_title = '[Multiple]';
	
	}else{
		$title_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$new_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$title_claim_type_results = mysqli_fetch_array($title_claim_type,MYSQLI_ASSOC);
		
		$title_type_title = $title_claim_type_results['title'];
	}
	
	if(!$this_claim_results['unit_id']){
		$active_unit_title = 'Multiple units';
		$unit_search = ' and status = 1';
		$active_unit_id = 0;
		
	}else{
		$active_unit_id = $this_claim_results['unit_id'];
		$unit_search = ' and id = '.$this_claim_results['unit_id'];
		$this_unit_id = $this_claim_results['unit_id'];
		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$active_unit_title = $this_unit_results['title'];
	}
	
	$selected_beneficiaries = $this_claim_results['beneficiaries'];
	$selected_beneficiaries_array = explode(',',$selected_beneficiaries);
	
	$default_agents_code = '';
	$claim_type_data = '';
	
	
	$agent_date_processing_string = '';
	for($c=0;$c<count($claim_type_date_array);$c++){
		$claim_data = '';
		$this_claim_type_date = $claim_type_date_array[$c];
		
		$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
		$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
		
		if(!$this_claim_type_results['billing_type']){
			$claim_type_rate = ' (K'.number_format($this_claim_type_results['daily_rate']).' per day)';
			
		}else{
			$claim_type_rate = ' (K'.number_format($this_claim_type_results['fixed_amount']).' fixed)';
			
		}
		
		$claim_type_data .= '<div style="width:100%;height:auto;float:left;" id="claim_type_holder_'.$this_claim_type_date.'"><div style="width:100%;margin-top:5px;height:20px;line-height:20px;background-color:#ddf;" id="general_claim_type_title_'.$this_claim_type_date.'">'.$this_claim_type_results['title'].$claim_type_rate.'</div><input type="hidden" id="claim_type_included_'.$this_claim_type_date.'" value="0"><div style="width:100%;height:20px;line-height:20px;background-color:#eef;"><div style="width:125px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:100px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">From</div><div style="width:100px;height:20px;float:left;margin-right:3px;">To</div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;">Worked</div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;">Payable</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Rate(K)</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div></div><div style="width:100%;height:auto;float:left;" id="claim_type_beneficiaries_holder_'.$this_claim_type_date.'">';
	
			for($b=0;$b<count($selected_beneficiaries_array);$b++){
				
				$this_selected_benficiary = $selected_beneficiaries_array[$b];
				$phone_numbers_2 = mysqli_query($connect,"select * from phone_numbers where agent_date = '$this_selected_benficiary' and company_id = $company_id")or die(mysqli_error($connect));
				
				
				
					
				$this_agent = mysqli_query($connect,"select * from agents where _date = '$this_selected_benficiary' and company_id = $company_id")or die(mysqli_error($connect));
				$this_agent_results = mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
				
				$this_claim_agent_id = $this_agent_results['id'];
				
				$this_claim_beneficiary = mysqli_query($$module_connect,"select * from claim_beneficiaries where agent_date = '$this_selected_benficiary' and claim_date = '$this_claim_date' and type_date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
				
				if(mysqli_num_rows($this_claim_beneficiary)){
					$this_claim_beneficiary_results = mysqli_fetch_array($this_claim_beneficiary,MYSQLI_ASSOC);
					
					if($agent_date_processing_string == ''){
						$agent_date_processing_string = $this_claim_type_date.'_'.$this_selected_benficiary;
						
					}else{
						$agent_date_processing_string .= ','.$this_claim_type_date.'_'.$this_selected_benficiary;
						
					}
					
					$start_date = $this_claim_beneficiary_results['_from'];
					$end_date = $this_claim_beneficiary_results['_to'];
					$days = $this_claim_beneficiary_results['days'];
					
					if(!$this_claim_type_results['billing_type']){
						$paid_days = $this_claim_beneficiary_results['paid_days'];
						$rate = $this_claim_beneficiary_results['rate'];
						
						$payable_disabled = '';
						
					}else{
						$paid_days = 'N/A';
						$payable_disabled = 'disabled';
						$rate = '<i>Fixed</i>';
					}
					
					$amount = $this_claim_beneficiary_results['amount'];
					$comment = $this_claim_beneficiary_results['comment'];
					
					if($comment == '' || $comment == 'Enter comment here'){
						$comment_display = 'none';
						
					}else{
						$comment_display = '';
						
					}
					
					$phone_number_code = '';
					for($p=0;$p<mysqli_num_rows($phone_numbers_2);$p++){
						$phone_number_results = mysqli_fetch_array($phone_numbers_2,MYSQLI_ASSOC);
						if($phone_number_results['phone_number'] == $this_claim_beneficiary_results['phone']){
							$phone_select = ' selected ';
							
						}else{
							$phone_select = ' ';
							
						}
						$phone_number_code .= '<option '.$phone_select.'>'.$phone_number_results['phone_number'].'</option>';
					
					}
				
					$entry_active = 1;
					$disable_fileds = '';
					$entry_bg_color = '#000';
					
					if($this_claim_beneficiary_results['status'] == 3){
						$disable_button_display = '';
						$edit_date_display = '';
						
					}else{
						$disable_button_display = 'display:none;';
						$edit_date_display = 'display:none';
					}
					
					$enable_button_display = 'display:none;';
				
				}else{
					$start_date = mktime(0,0,0,date('m',time()),date('j',time()),date('Y',time()));
					$end_date = time();
					$days = 0;
					
					if(!$this_claim_type_results['billing_type']){
						$rate = $this_claim_type_results['daily_rate'];
						
						$days = check_agent_activity_days($this_claim_agent_id,0,0,$start_date,$end_date,$company_id);
						
						if($this_claim_type_results['limit_days'] and $days > $this_claim_type_results['max_days']){
							$paid_days = $this_claim_type_results['max_days'];
							
						}else{
							$paid_days = $days;
							
						}
						$payable_disabled = '';
						
						$amount = $rate * $days;
						
					}else{
						$paid_days = 'N/A';
						$rate = '<i>Fixed</i>';
						$payable_disabled = 'disabled';
						
						$amount = $this_claim_type_results['fixed_amount'];
					}
					
					
					$comment = 'Enter comment here';
					$comment_display = 'none';
					
					$phone_number_code = '';
					for($p=0;$p<mysqli_num_rows($phone_numbers_2);$p++){
						$phone_number_results = mysqli_fetch_array($phone_numbers_2,MYSQLI_ASSOC);
						$phone_number_code .= '<option>'.$phone_number_results['phone_number'].'</option>';
					
					}
					
					
					$entry_active = 0;
					$disable_fileds = 'disabled';
					$entry_bg_color = '#aaa';
					$disable_button_display = 'display:none;';
					$enable_button_display = '';
					$edit_date_display = '';
				}
				
				
				if($days == 0){
						$day_color = 'red';
						
					}else{
						$day_color = 'black';
					}
				
				if(strlen($this_agent_results['_name']) > 22){
					$agent_name = substr($this_agent_results['_name'],0,22).'...';
							
				}else{
					$agent_name = $this_agent_results['_name'];
				}
				
				$claim_data .= '<div style="width:100%;min-height:25px;height:auto;line-height:25px;border-bottom:solid 1px #eee;float:left;color:'.$entry_bg_color.'" id="beneficiary_item_'.$this_claim_type_date.'_'.$this_selected_benficiary.'"><div style="width:125px;min-height:20px;height:auto;float:left;margin-right:3px;" id="claim_agent_name_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" ondblclick="$(\'#agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment\').slideToggle(\'fast\');" title="Double-click to view/hide comment">'.$agent_name.'</div><div style="width:120px;height:20px;float:left;margin-right:3px;"><div style="width:560px;height:25px;background-color:#ccc;position:absolute;opacity:0.4;" id="entry_edit_fade_'.$this_claim_type_date.'_'.$this_selected_benficiary.'"><div style="margin-left:561px;cursor:pointer;width:25px;height:25px;position:absolute;line-height:25px;text-align:center;color:#fff;'.$edit_date_display.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'\';" title="Click to edit this agent entry" onclick="$(\'#entry_edit_fade_'.$this_claim_type_date.'_'.$this_selected_benficiary.'\').slideUp(\'fast\');"><img src="'.$url.'/imgs/editing_icon.png" style="width:60%;height:60%"></div></div><select '.$disable_fileds.' id="claim_agent_phone_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" style="width:100%;height:20px;margin-top:3px;">'.$phone_number_code.'</select></div><div style="width:100px;height:25px;float:left;margin-right:3px;" id="claim_agent_nrc_'.$this_claim_type_date.'_'.$this_selected_benficiary.'">'.$this_agent_results['id_number'].'</div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input '.$disable_fileds.' type="text" style="height:20px;width:90%;margin-top:3px;" value="'.date('m/j/Y',$start_date).'" id="agent_start_date_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" onchange="include_fetch_agent_days(\'_'.$this_claim_type_date.'\',\'_'.$this_selected_benficiary.'\','.$this_agent_results['id'].');"></div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input '.$disable_fileds.' type="text" style="height:20px;width:90%;margin-top:3px;" value="'.date('m/j/Y',$end_date).'" id="agent_end_date_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" onchange="include_fetch_agent_days(\'_'.$this_claim_type_date.'\',\'_'.$this_selected_benficiary.'\','.$this_agent_results['id'].');"></div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;color:'.$day_color.'" id="claim_days_worked_'.$this_claim_type_date.'_'.$this_selected_benficiary.'">'.$days.'</div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;"><input '.$disable_fileds.' '.$payable_disabled.' type="text" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="'.$paid_days.'" id="claim_days_payable_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" onchange="recalculate_newclaim_total()" onfocusout="if(this.value!='.$days.'){$(\'#agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment\').slideDown(\'fast\');$(\'#agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment_input\').css(\'borderColor\',\'red\');}else{$(\'#agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment\').slideUp(\'fast\');};"><input type="hidden" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="'.$days.'" id="claim_days_original_payable_'.$this_claim_type_date.'_'.$this_selected_benficiary.'"></div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_rate_'.$this_claim_type_date.'_'.$this_selected_benficiary.'">'.$rate.'</div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_total_'.$this_claim_type_date.'_'.$this_selected_benficiary.'">'.number_format($amount,2).'</div><div style="width:15px;cursor:pointer;margin-left:2px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:#8b8;color:#fff;border:solid 1px #eee;text-align:center;'.$enable_button_display.'" onmouseout="this.style.backgroundColor=\'#8b8\';" onmouseover="this.style.backgroundColor=\'#8d8\';" id="enable_beneficiary_button_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" onclick="change_beneficiary_status(\'_'.$this_claim_type_date.'\',\'_'.$this_selected_benficiary.'\',1);" title="Click to include this beneficiary in this claim" >&#10004;</div><div style="width:15px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:brown;color:#fff;border:solid 1px #eee;text-align:center;cursor:pointer;'.$disable_button_display.'" onmouseout="this.style.backgroundColor=\'brown\';"onmouseover="this.style.backgroundColor=\'brown\';" id="disable_beneficiary_button_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" onclick="change_beneficiary_status(\'_'.$this_claim_type_date.'\',\'_'.$this_selected_benficiary.'\',0);" title="Click to exclude this beneficiary" >&#10005;</div><div style="width:100%;height:25px;float:left;display:'.$comment_display.';" id="agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment"><textarea id="agent_'.$this_claim_type_date.'_'.$this_selected_benficiary.'comment_input" style="min-width:100%;max-width:100%;min-height:20px;max-height:20;color:#aaa;font-family:arial;font-size:0.9em;border:solid 1px #afa;" onfocus="if(this.value==\'Enter comment here\'){this.value=\'\';this.style.color=\'#444\';this.style.borderColor=\'#afa\';}" onfocusout="if(this.value==\'\'){this.value=\'Enter comment here\';this.style.color=\'#aaa\';}">'.$comment.'</textarea></div><div style="width:100%;min-height:25px;line-height:15px;height:auto;float:left;display:none;margin-bottom:10px;" id="beneficiary_date_error_'.$this_claim_type_date.'_'.$this_selected_benficiary.'"></div><input type="hidden" id="beneficiary_active_'.$this_claim_type_date.'_'.$this_selected_benficiary.'" value="'.$entry_active.'"></div><script>$(\'#agent_start_date_'.$this_claim_type_date.'_'.$this_selected_benficiary.'\').datepicker();$(\'#agent_end_date_'.$this_claim_type_date.'_'.$this_selected_benficiary.'\').datepicker();</script>';
				
				
				if($c==0){
					$start_date = mktime(0,0,0,date('m',time()),date('j',time()),date('Y',time()));
					$end_date = time();
					$days = check_agent_activity_days($this_agent_results['id'],0,0,$start_date,$end_date,$company_id);
					
					if($days == 0){
						$day_color = 'red';
						
					}else{
						$day_color = 'black';
					}
					
					$default_agents_code .= '<div style="width:100%;min-height:25px;height:auto;line-height:25px;display:none;" id="agent_default_item_'.$this_selected_benficiary.'"><div style="width:125px;height:20px;float:left;margin-right:3px;" id="claim_agent_name_c_0" ondblclick="$(\'#agent_c_0comment\').slideToggle(\'fast\');" title="Double-click to view/hide comment">'.$agent_name.'</div><div style="width:120px;height:20px;float:left;margin-right:3px;"><select id="claim_agent_phone_c_0" style="width:100%;height:20px;margin-top:3px;">'.$phone_number_code.'</select></div><div style="width:100px;height:25px;float:left;margin-right:3px;" id="claim_agent_nrc_c_0">'.$this_agent_results['id_number'].'</div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input type="text" style="height:20px;width:90%;margin-top:3px;" value="'.date('m/j/Y',$start_date).'" id="agent_start_date_c_0"onchange="include_fetch_agent_days(\'_c\',\'_0\','.$this_agent_results['id'].');" ></div><div style="width:100px;height:25px;float:left;margin-right:3px;"><input type="text" style="height:20px;width:90%;margin-top:3px;" value="'.date('m/j/Y',$end_date).'" id="agent_end_date_c_0" onchange="include_fetch_agent_days(\'_c\',\'_0\','.$this_agent_results['id'].');"></div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;color:'.$day_color.'" id="claim_days_worked_c_0">'.$days.'</div><div style="width:60px;height:25px;float:left;margin-right:3px;text-align:right;"><input type="text" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="'.$days.'" id="claim_days_payable_c_0" onchange="recalculate_newclaim_total()" onfocusout="if(this.value!='.$days.'){$(\'#agent_c_0comment\').slideDown(\'fast\');$(\'#agent_c_0comment_input\').css(\'borderColor\',\'red\');}else{$(\'#agent_c_0comment\').slideUp(\'fast\');};"><input type="hidden" style="height:20px;width:90%;margin-top:3px;text-align:right;" value="'.$days.'" id="claim_days_original_payable_c_0"></div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_rate_c_0">0.00</div><div style="width:70px;height:25px;float:left;margin-right:3px;text-align:right;" id="claim_agent_total_c_0">0.00</div><div style="width:15px;cursor:pointer;margin-left:2px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:#8b8;color:#fff;border:solid 1px #eee;text-align:center;display:none;" onmouseout="this.style.backgroundColor=\'#8b8\';" onmouseover="this.style.backgroundColor=\'#8d8\';" id="enable_beneficiary_button_c_0" onclick="change_beneficiary_status(\'_c\',\'_0\',1);" title="Click to include this beneficiary in this claim" >&#10004;</div><div style="width:15px;float:left;height:15px;margin-top:2px;line-height:15px;background-color:brown;color:#fff;border:solid 1px #eee;text-align:center;cursor:pointer;" onmouseout="this.style.backgroundColor=\'brown\';"onmouseover="this.style.backgroundColor=\'brown\';" id="disable_beneficiary_button_c_0" onclick="change_beneficiary_status(\'_c\',\'_0\',0);" title="Click to exclude this beneficiary" >&#10005;</div><div style="width:100%;height:25px;float:left;display:none;" id="agent_c_0comment"><textarea id="agent_c_0comment_input" style="min-width:100%;max-width:100%;min-height:20px;max-height:20;color:#aaa;font-family:arial;font-size:0.9em;border:solid 1px #afa;" onfocus="if(this.value==\'Enter comment here\'){this.value=\'\';this.style.color=\'#444\';this.style.borderColor=\'#afa\';}" onfocusout="if(this.value==\'\'){this.value=\'Enter comment here\';this.style.color=\'#aaa\';}">Enter comment here</textarea></div><div style="width:100%;min-height:25px;line-height:15px;height:auto;float:left;display:none;margin-bottom:10px;" id="beneficiary_date_error_c_0"></div><input type="hidden" id="beneficiary_active_c_0" value="'.$entry_active.'"></div></div>';
				}
				
			}
		
		$claim_type_data .= $claim_data.'</div><div style="width:100%;margin-top:5px;height:20px;line-height:20px;"><div style="width:160px;height:20px;float:left;margin-right:3px;"></div><div style="width:120px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:60px;height:20px;float:left;margin-right:6px;text-align:right;"></div><div style="width:130px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3" >Sub-Total(K)</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3" id="claim_type_total_'.$this_claim_type_date.'">0</div></div></div>';
	}
	
	if($this_claim_results['file_src'] != ''){
		$uploaded_files = $this_claim_results['file_src'];
		$uploaded_file_array = explode(',',$this_claim_results['file_src']);
		$file_holder_font_size = '1em';
		
		$file_string = '';
		for($f=0;$f<count($uploaded_file_array);$f++){
			$this_file = $uploaded_file_array[$f];
			$this_file_array = explode('.',$this_file);
			
			
			if(file_exists('../imgs/'.$this_file_array[1].'_icon.png')){
				$file_icon = $this_file_array[1].'_icon.png';
				
			}else{
				$file_icon = 'unknown_icon.png';
			}
			
			$file_string .= '<div style="margin:5px;width:auto;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;border:solid 1px #ddd;"  id="attachment_item_'.$f.'"><div style="width:auto;height:30px;float:left;" onmouseover="this.style.backgroundColor=\'#efe\';" onmouseout="this.style.backgroundColor=\'\';" onclick="window.open(\'+$(\'#url\').val()+\'/imgs/attachments/'.$this_file.'\',\'attachment_'.$f.'\');"><div style="margin:2px;width:25px;height:25x;color:#000;text-align:center;float:left;"><img src="../imgs/'.$file_icon.'" style="height:25px"></div><div style="width:auto;height:30x;color:#000;text-align:center;float:left;padding-right:5px;">'.$this_file.'</div></div><div style="width:20px;height:30px;text-align:center;line-height:30px;color:#fff;background-color:brown;float:left;" onmouseover="this.style.backgroundColor=\'#b44e4e\';" onmouseout="this.style.backgroundColor=\'brown\';" onclick="remove_from_selection(\''.$this_file.'\',\'uploaded_files\');$(\'#attachment_item_'.$f.'\').slideUp(\'fast\');$(\'#image_'.$f.'_error\').slideUp(\'fast\');$(\'#image_'.$f.'_progress\').slideUp(\'fast\');$(\'#image_'.$f.'_holder\').slideDown(\'fast\');if($(\'#uploaded_files\').val() == \'\'){$(\'#attachments_holder\').css(\'font-size\',\'1.5em\');$(\'#attachments_holder\').html(\'No attachments added\');}">X</div></div>';
			
		}
	
	}else{
		$uploaded_files = '';
		$file_string = 'No attachments added';
		$file_holder_font_size = '1.5em';
		
	}
	
	
}else{
	$this_claim_date = 0;
	$this_region_id = $user_results['region_id'];
	$this_province_id = $user_results['province_id'];
	$this_district_id = $user_results['hub_id'];
	$this_site_id = $user_results['site_id'];
	
	$agent_date_processing_string = '';
	$button_title = 'Create';
	$new_claim_type_date = '';
	$title_type_title = 'Select claim type';

	$claim_type_list = '';
	
	if(!$user_results['unit_id']){
		$active_unit_title = 'Select unit';
		$unit_search = 'and status = 1';
		$active_unit_id = '-1';
		
	}else{		
		$unit_search = ' and id = '.$user_results['unit_id'];
		$user_unit_id = $user_results['unit_id'];
		$user_unit = mysqli_query($connect,"select * from units where id = $user_unit_id")or die(mysqli_error($connect));
		$user_unit_results = mysqli_fetch_array($user_unit,MYSQLI_ASSOC);
		$active_unit_title = $user_unit_results['title'];
		
		$active_unit_id = $user_unit_id;
	}

	
	$selected_beneficiaries = '';
	
	$default_agents_code = '';
	$claim_type_data = '';
	
	$uploaded_files = '';
	$file_string = 'No attachments added';
	$file_holder_font_size = '1.5em';
}

if(!$user_results['region_id']){
	$filter_string = ' and status = 1';
	
}else if(!$user_results['province_id']){
	$filter_string = ' and (region_id = '.$user_results['region_id'].' or region_id = 0) and status = 1';
		
}else if(!$user_results['hub_id']){
	$filter_string = ' and (province_id = '.$user_results['province_id'].') or ((region_id = '.$user_results['region_id'].' and province_id = 0) or region_id = 0) and status = 1';
	
}else if(!$user_results['site_id']){
	$filter_string = ' and (hub_id = '.$user_results['hub_id'].') or (province_id = '.$user_results['province_id'].' and hub_id = 0) or (region_id = '.$user_results['region_id'].' and province_id = 0) or (region_id = 0) and status = 1';
	
}else{
	$filter_string = ' and (site_id = '.$user_results['site_id'].') or (hub_id = '.$user_results['hub_id'].' and site_id = 0) or (province_id = '.$user_results['province_id'].' and hub_id = 0) or (region_id = '.$user_results['region_id'].' and province_id = 0) or (region_id = 0) and status = 1';
	
}

?>
<input type="hidden" id="agent_processing_queue" value="<?php print($agent_date_processing_string);?>">
<input type="hidden" id="agent_days_processing_queue" value="">
<input type="hidden" id="claim_date" value="<?php print($this_claim_date);?>">
<div style="width:100%;height:auto;float:left;">

<div style="width:700px;min-height:30px;height:auto;margin:0 auto;">
<div style="width:100%;min-height:30px;height:auto;float:left;border-bottom:solid 1px #eee;padding-bottom:5px;">

<div style="width:auto;height:auto;float:left;">
<div style="width:45px;height:30px;line-height:30px;float:left;">Region:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<?php
		if($this_region_id){
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$this_region_title = $this_region_results['title'];
		
		}else{
			$this_region_title = 'Select region';
		}
		?>

		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#new_region_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change region for this view');<?php }?>" id="active_new_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_region_title);?></div>

		<div class="option_menu" id="new_region_menu" style="display:none;min-width:120px;width:auto;">
		<?php
			
			$location_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_region_menu').toggle('fast');$('#active_new_region').html($(this).html());$('#selected_new_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'new_province',1,1,'connect-hubs-province_id-{id}-new_hub-1-1|connect-sites-hub_id-{id}-new_site-1-1');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_new_region" value="<?php print($this_region_id);?>">
		</div>
		
		
		<div style="width:auto;height:auto;float:left;" id="new_province_holder">
			<div style="width:55px;height:30px;line-height:30px;float:left;">Province:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">

			
			<?php
				if($this_province_id){
					$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
					$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
					
					$province_title = $this_province_results['title'];
					
				}else{
					$province_title = 'Select province';
					
				}
				
				if($this_region_id){
					$province_search = ' and region_id = '.$this_region_id;
					
				}else{
					$province_search = ' ';
					
				}
			?>
				
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#new_province_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change province for this view'); <?php }?>" id="active_new_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($province_title);?></div>

			<div class="option_menu" id="new_province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$location_menu = mysqli_query($connect,"select * from provinces where company_id = $company_id $province_search order by title")or die(mysqli_error($connect));

					for($l=0;$l<mysqli_num_rows($location_menu);$l++){
						$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_province_menu').toggle('fast');$('#active_new_province').html($(this).html());$('#selected_new_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'new_hub',1,1,'connect-sites-hub_id-{id}-new_site-1-1');"><?php print($location_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_new_province" value="<?php print($this_province_id);?>">
		</div>
	
	<div style="width:auto;height:auto;float:left;" id="new_hub_holder">
		<div style="width:30px;height:30px;line-height:30px;float:left;">Hub:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				
				if($this_district_id){
					$this_district = mysqli_query($connect,"select * from hubs where id = $this_district_id")or die(mysqli_error($connect));
					$this_district_results = mysqli_fetch_array($this_district,MYSQLI_ASSOC);
					
					$district_title = $this_district_results['title'];
	
				}else{
					$district_title = 'Select hub';
					
				}
				
				if($this_province_id){
					$district_search = ' and province_id = '.$this_province_id;
					
				}else{
					$district_search = ' ';
					
				}
			?>
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#new_hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change hub for this view');<?php }?>" id="active_new_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($district_title);?></div>

		<div class="option_menu" id="new_hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from hubs where company_id = $company_id $district_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_hub_menu').toggle('fast');$('#active_new_hub').html($(this).html());$('#selected_new_hub').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($location_menu_results['id']);?>,'new_site',1,1,'');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		
		
		
		</div>
		</div>
		<input type="hidden" id="selected_new_hub" value="<?php print($this_district_id);?>">
	</div>
		
	<div style="width:auto;height:auto;float:left;" id="new_site_holder">
		<div style="width:30px;height:30px;line-height:30px;float:left;">Site:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				if($this_site_id){
					$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
					$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
					$this_site_title = $this_site_results['title'];
					
				}else{
					$this_site_title = 'Select site';
					
				}
				
				if($this_district_id){
					$site_search = ' and hub_id = '.$this_district_id;
					
				}else{
					$site_search = ' ';
					
				}
			?>
			
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#new_site_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change site for his view'); <?php }?>" id="active_new_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>

		<div class="option_menu" id="new_site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
			$location_menu = mysqli_query($connect,"select * from sites where company_id = $company_id $site_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_site_menu').toggle('fast');$('#active_new_site').html($(this).html());$('#selected_new_site').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_new_site" value="<?php print($this_site_id);?>">
	</div>

























</div>
</div>


<div style="width:700px;min-height:30px;height:auto;margin:0 auto;">
<div style="width:100%;height:auto;float:left;border-bottom:solid 1px #eee;padding-bottom:5px;">
<div style="width:auto;float:left;margin-top:3px;">
<div style="line-height:30px;width:80px;height:30px;float:left;">Claim type: </div>
<div style="min-width:100px;width:auto;min-height:30px;height:auto;float:left;" onclick="$('#claim_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#claim_type_menu').toggle('fast');" id="active_claim_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;width:auto;"><?php print($title_type_title);?></div>


<div class="option_menu" id="claim_type_menu" style="display:none;">
<?php
$request_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id $filter_string order by title")or die(mysqli_error($$module_connect));

for($c=0;$c<mysqli_num_rows($request_types);$c++){
	$request_types_results = mysqli_fetch_array($request_types,MYSQLI_ASSOC);
	
	if(validate_claim_rules($company_id,$user_id,$request_types_results['_date'],0,0)){
		if(!$request_types_results['billing_type']){
			$claim_type_rate = ' (K'.number_format($request_types_results['daily_rate']).' per day)';
			
		}else{
			$claim_type_rate = ' (K'.number_format($request_types_results['fixed_amount']).' fixed)';
			
		}
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" style="min-width:350px;width:100%;"><input type="checkbox" id="claim_check_<?php print($request_types_results['_date']);?>" onclick="if(this.checked){add_to_selection(<?php print($request_types_results['_date']);?>,'new_claim_type');}else{remove_from_selection(<?php print($request_types_results['_date']);?>,'new_claim_type');}refresh_request_types();$('#active_claim_type').html('[Multiple]');" <?php if(search_item_in_list($request_types_results['_date'],$new_claim_type_date,0)){print(' checked ');}?>><a onclick="$('#claim_type_menu').toggle('fast');$('#active_claim_type').html('<?php print($request_types_results['title']);?>');add_claim_type(<?php print($request_types_results['_date']);?>);" id="claim_type_title_<?php print($request_types_results['_date']);?>"><?php print($request_types_results['title'].$claim_type_rate);?></a></div>
		<input type="hidden" id="claim_rate_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['daily_rate']);?>">
		
		<input type="hidden" id="claim_billing_type_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['billing_type']);?>">
		
		<input type="hidden" id="claim_day_adjustment_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['day_adjustment']);?>">
		
		<input type="hidden" id="claim_limit_days_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['limit_days']);?>">
		
		<input type="hidden" id="claim_max_days_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['max_days']);?>">
		
		<input type="hidden" id="claim_fixed_amount_<?php print($request_types_results['_date']);?>" value="<?php print($request_types_results['fixed_amount']);?>">
		<?php
	}
}
?>
</div>
</div>
<input type="hidden" name="new_claim_type" id="new_claim_type" value="<?php print($new_claim_type_date);?>">
</div>
<div style="width:200px;float:right;margin-top:3px;">
<?php


?>
<div style="line-height:30px;width:40px;height:30px;float:left;">Unit: </div>
<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#claim_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#claim_unit_menu').toggle('fast');" id="active_claim_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="auto;"><?php print($active_unit_title);?></div>


<div class="option_menu" id="claim_unit_menu" style="display:none;min-width:160px;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_unit_menu').toggle('fast');$('#active_claim_unit').html($(this).html());$('#new_claim_unit').val(0);" >Multiple units</div>


<?php
$claim_units = mysqli_query($connect,"select * from units where company_id = $company_id $unit_search order by title")or die(mysqli_error($connect));

for($u=0;$u<mysqli_num_rows($claim_units);$u++){
	$claim_unit_results = mysqli_fetch_array($claim_units,MYSQLI_ASSOC);
	
	if(!$claim_unit_results['status']){
		$old_unit = ' [Old]';
		
		
	}else{
		$old_unit = '';
		
	}

	?>
	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_unit_menu').toggle('fast');$('#active_claim_unit').html($(this).html());$('#new_claim_unit').val(<?php print($claim_unit_results['id']);?>);" style="min-width:130px;"><?php print($claim_unit_results['title'].$old_unit);?></div>
	<?php
}
?>
</div>
</div>
<input type="hidden" name="new_claim_unit" id="new_claim_unit" value="<?php print($active_unit_id);?>">
</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;">
<div style="width:400px;margin:0 auto;">
<div style="width:100%;height:auto;float:left;margin-top:5px;">
<input type="text" id="claim_agent_search_input" value="Enter agent name or phone number" style="border:solid 1px #ddd;width:80%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter agent name or phone number'){this.value='';this.style.color='#000';}else if($('#claim_agent_search_results_holder').html() != ''){$('#claim_agent_search_holder').slideDown('fast');}this.style.borderColor='#ddd';$('#claim_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter agent name or phone number';this.style.color='#aaa';}" title="Enter agent name or phone number. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {search_claim_agents();}">

<div style="width:60px;height:30px;background-color:#79c7d6;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#9ad4df';" onmouseout="this.style.backgroundColor='#79c7d6';"  id="agent_search_button" onclick="search_claim_agents();" title="Click to fetch report with specified options">Fetch</div>
</div>

</div>

<div style="padding:2px;position:absolute;z-index:10;width:880px;height:auto;background-color:#fff;border:solid 1px #ddf;margin-top:38px;display:none;" id="claim_agent_search_holder">
<div style="width:100%;height:20px;line-height:20px;text-align:center;float:left;background-color:#79c7d6;color:#fff;">Agent search results <div class="window_close_button" style="height:20px;line-height:20px;background-color:#aaf" onmouseout="this.style.backgroundColor='#aaf';" onmouseover="this.style.backgroundColor='#9595e5';" onclick="$('#claim_agent_search_holder').slideUp('fast');" id="details_close_button">X</div></div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:150px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:80px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Site</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Job title</div></div>


<div style="width:99.5%;min-height:150px;height:auto;float:left;background-color:#f7fcfd" id="claim_agent_search_results_holder"></div>

</div>
</div>



<div style="width:100%;height:auto;float:left;" id="claim_data_holder"><?php print($claim_type_data);?></div>

<div style="width:100%;margin-top:5px;height:20px;line-height:20px;">
<div style="width:160px;height:20px;float:left;margin-right:3px;"></div><div style="width:120px;height:20px;float:left;margin-right:3px;"></div>
<div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:60px;height:20px;float:left;margin-right:6px;text-align:right;"></div><div style="width:130px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3;font-weight:bold;">Grand-Total(K)</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3;font-weight:bold;" id="claim_total">0</div>
</div>

<div style="width:100%;float:left;margin-top:5px;min-height:40px;height:auto;line-height:40px;color:#888;background-color:#fbf1ff;text-align:center;font-size:<?php print($file_holder_font_size);?>;" id="attachments_holder"><?php print($file_string);?></div>


<div style="width:100%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="claim_error_message"></div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_or_update_claim_button" onclick="create_or_update_claim(<?php print($claim_id);?>);"><?php print($button_title);?></div>

<div style="width:80px;height:30px;background-color:#d697ee;color:#fff;#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#faa4ff';" onmouseout="this.style.backgroundColor='#d697ee';"  id="create_claim_button" onclick="add_claim_files();">Add Files</div>
</div>
</div>













<input type="hidden" id="selected_beneficiaries" value="<?php print($selected_beneficiaries);?>">

<div style="width:100%;height:auto;float:left;display:none;" id="claim_type_holder_0" >
<div style="width:100%;margin-top:5px;height:20px;line-height:20px;background-color:#ddf;cursor:pointer;" id="general_claim_type_title_0" onclick="$('#claim_type_bottom_holder_0').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#ddf';" title="Click to hide/unhide beneficiary list"></div>
<input type="hidden" id="claim_type_included_0" value="0">


<div style="width:100%;height:auto;float:left;" id="claim_type_bottom_holder_0">

<div style="width:100%;height:20px;line-height:20px;background-color:#eef;">
<div style="width:135px;height:20px;float:left;margin-right:3px;">Name</div><div style="width:120px;height:20px;float:left;margin-right:3px;">Phone</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">From</div><div style="width:100px;height:20px;float:left;margin-right:3px;">To</div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;">Worked</div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;">Payable</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Rate(K)</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;">Amount(K)</div>
</div>
<div style="width:100%;height:auto;float:left;" id="claim_type_beneficiaries_holder_0">


</div>
</div>

<div style="width:100%;margin-top:5px;height:20px;line-height:20px;">
<div style="width:160px;height:20px;float:left;margin-right:3px;"></div><div style="width:120px;height:20px;float:left;margin-right:3px;"></div>
<div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;"></div><div style="width:60px;height:20px;float:left;margin-right:6px;text-align:right;"></div><div style="width:130px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3" >Sub-Total(K)</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:right;color:#006bb3" id="claim_type_total_0">0</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;" id="default_agent_holder">
<?php print($default_agents_code);?>
</div>

<script>
$('#uploaded_files').val('<?php print($uploaded_files);?>');
recalculate_newclaim_total();

if($('#agent_processing_queue').val() != ''){
	check_date_error();
}
</script>