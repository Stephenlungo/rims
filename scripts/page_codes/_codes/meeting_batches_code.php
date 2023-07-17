
<?php

$skip_location = 0;
$search_string = '';
if($search_key_string != ''){
	if(is_numeric($search_key_string)){
		$search_string .= ' and (batch_number = '.str_replace(",",' or batch_number = ',$search_key_string).')';
		$skip_location = 1;
	}else{
		$search_string .= " and (title LIKE '%".str_replace(",","%' or title LIKE '%",$search_key_string)."%')";		
	}
}

$with_files_filter = '';
if($with_files_id == 1){
	$with_files_filter = " and file_src != ''";
	
}else if($with_files_id == 1){
	$with_files_filter = " and file_src == ''";
	
}

$active_filter = '';
if($status == 1){
	$active_filter = ' and status = 1';
	
}else if($status == 2){
	$active_filter = ' and status = 0';
	
}else if($status == 3){
	$active_filter = ' and status = 2';
}



$meeting_batches = fetch_db_table('connect','meeting_batches',$company_id,'_date desc'," id > 0 and active_status = 1 ".$search_string." and _date >= '".$date_from."' and _date <= '".$date_to."'".$with_files_filter.$active_filter);
$batch_participants = fetch_db_table('connect','meeting_batch_participants',$company_id,'id',"");

$total_records = count($meeting_batches['id']);
?>

<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="list_status_bar" ><strong>Records found:</strong> <?php print(number_format(count($meeting_batches['id'])));?></div></div>

<?php
if($total_records>100){
	$total_records = 100;
	
	?>
	<div style="cursor:pointer;line-height:20px;width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;background-color:#bf8080;color:#fff;text-align:center;" onmouseover="this.style.backgroundColor='#d08f8f';" onmouseout="this.style.backgroundColor='#bf8080';" id="showing_less_holder" ondblclick="$(this).slideUp('fast');">We found too many results for your search. To ensure faster processing, we are only showing 100 records. Please narrow down your filters to view the other records</div>
	<?php
}
?>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="batches_header"><div style="width:20px;height:20px;float:left;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;">Batch number</div><div style="width:90px;height:20px;float:left;margin-right:3px;">Date created</div><div style="width:300px;height:20px;float:left;margin-right:3px;">Batch title</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Meetings/Teams</div><div style="width:200px;height:20px;float:left;margin-right:3px;">Creator</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:left;">Agents</div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:left;">Claim #</div></div>


<?php
	
	$meetings = fetch_db_table('connect','meetings',$company_id,'id',"");
	$users = fetch_db_table('connect','users',$company_id,'id',"");
	
	$regions = fetch_db_table('connect','regions',$company_id,'id','');
	$provinces = fetch_db_table('connect','provinces',$company_id,'id','');
	$hubs = fetch_db_table('connect','hubs',$company_id,'id','');
	$sites = fetch_db_table('connect','sites',$company_id,'id','');
	$units = fetch_db_table('connect','units',$company_id,'id','');
	
	$record_count = 0;
	
	for($b=0;$b<$total_records;$b++){
		$meeting_ids = explode(',',$meeting_batches['meeting_ids'][$b]);
		
		$number_of_meetings = count($meeting_ids);
		
		$meeting_titles = '';
		$show_record = 1;
		for($mi=0;$mi<count($meeting_ids);$mi++){
			
			$this_index = array_keys($meetings['id'],$meeting_ids[$mi]);
			
			
			
			if(isset($this_index[0])){
				
				$meeting_region_title = 'Unknown';
				$meeting_province_title = 'Unknown';
				$meeting_hub_title = 'Unknown';
				$meeting_site_title = 'Unknown';
				
				$meeting_region_index = array_keys($regions['id'],$meetings['region_id'][$this_index[0]]);
				if(isset($meeting_region_index)){
					$meeting_region_title = $regions['title'][$meeting_region_index[0]];
				}
				
				$meeting_province_index = array_keys($provinces['id'],$meetings['province_id'][$this_index[0]]);
				if(isset($meeting_province_index)){
					$meeting_province_title = $provinces['title'][$meeting_province_index[0]];
				}
				
				$meeting_hub_index = array_keys($hubs['id'],$meetings['hub_id'][$this_index[0]]);
				if(isset($meeting_hub_index)){
					$meeting_hub_title = $hubs['title'][$meeting_hub_index[0]];
				}
				
				$meeting_site_index = array_keys($sites['id'],$meetings['site_id'][$this_index[0]]);
				if(isset($meeting_site_index)){
					$meeting_site_title = $sites['title'][$meeting_site_index[0]];
				}
				
				
				
				if($meeting_titles == ''){
					$meeting_titles = '<div style="width:100%;height:auto;float:left;border-bottom:solid 1px #fff;">'.($mi+1).': '.$meetings['title'][$this_index[0]].' - Code: '.$meetings['meeting_code'][$this_index[0]].' (<strong>Region:</strong> '.$meeting_region_title.', <strong>Province: </strong>'.$meeting_province_title.', <strong>Hub: </strong>'.$meeting_hub_title.', <strong>Site: </strong>'.$meeting_site_title.')</div>';
					
				}else{
					$meeting_titles .= '<div style="width:100%;height:auto;float:left;border-bottom:solid 1px #fff;">'.($mi+1).': '.$meetings['title'][$this_index[0]].' - Code: '.$meetings['meeting_code'][$this_index[0]].' (<strong>Region:</strong> '.$meeting_region_title.', <strong>Province: </strong>'.$meeting_province_title.', <strong>Hub: </strong>'.$meeting_hub_title.', <strong>Site: </strong>'.$meeting_site_title.')</div>';
					
				}
				
				
				if(!$skip_location){
					if($site_id and $meetings['site_id'][$this_index[0]] != $site_id){
						$show_record = 0;
						
						
					}else if($hub_id and $meetings['hub_id'][$this_index[0]] != $hub_id){
						$show_record = 0;
						
					}else if($province_id and $meetings['province_id'][$this_index[0]] != $province_id){
						$show_record = 0;
						
					}else if($region_id and $meetings['region_id'][$this_index[0]] != $region_id){
						$show_record = 0;
						
					}
						
				}
			}
		}
		
		$creator_index = array_keys($users['id'],$meeting_batches['user_id'][$b]);
		
		$creator_title = 'Unknown';
		if(isset($creator_index[0])){
			$creator_title = $users['_name'][$creator_index[0]];
		}
		
		
		$participant_index = array_keys($batch_participants['batch_id'],$meeting_batches['id'][$b]);
		
		$total_participants = 0;
		if(isset($participant_index[0])){
			$total_participants = count($participant_index);
			
		}
		
		$color = '';
		$hover_color = '#eee';
		if($meeting_batches['status'][$b] == 0){
			$color = '#fee';
			$hover_color = '#dee';
			
		}else if($meeting_batches['status'][$b] == 2){
			$color = '#e8f6f5';
			$hover_color = '#c5ebe7';
		}
		
		$claim_number = $meeting_batches['claim_id'][$b];
		if($claim_number == 0){
			$claim_number = 'N/A';
			
		}
		
		if($show_record){
			$record_count++;
			
			$total_batch_files = 0;
			
			$batch_files = '<div style="width:100%;height:90px;line-height:90px;float:left;font-size:1.6em;text-align:center;color:#aaa;">No attachments found</div>';
			
			if($meeting_batches['status'][$b] == 1 and (($user_id == $meeting_batches['user_id'][$b]) || $active_user_roles[8])){
				$batch_files = '<div style="width:100%;height:90px;line-height:90px;float:left;font-size:1.6em;text-align:center;color:#aaa;cursor:pointer;" onmouseover="this.style.backgroundColor=\'#eee\'"  onmouseout="this.style.backgroundColor=\'\'" onclick="open_uploader(\'process_batch_attachment('.$meeting_batches['id'][$b].')\',1);">Click to attach files to this batch</div>';
				
			}
			
			if($meeting_batches['file_src'][$b] != ''){
				$batch_files_array = explode(',',$meeting_batches['file_src'][$b]);
				
				$total_batch_files = count($batch_files_array);
				
				for($f=0;$f<count($batch_files_array);$f++){
					
					$remove_button = '';
					if($meeting_batches['status'][$b] == 1 and ($user_id == $meeting_batches['user_id'][$b] || $active_user_roles[8])){
						$remove_button = '<div style="margin-left:5px;text-align:center;cursor:pointer;width:20px;height:30px;line-height:30px;float:right;background-color:brown;color:#fff;border-radius:20px;" onclick="remove_batch_file('.$meeting_batches['id'][$b].',\''.$batch_files_array[$f].'\')">X</div>';
						
					}
					
					if($f==0){
						$batch_files = '<div style="user-select:none;width:auto;padding:5px;margin:2px;float:left;height:30px;line-height:30px;background-color:#d9d2e9;border-radius:15px;overflow:hidden" id="batch_file_'.$meeting_batches['id'][$b].'_'.$f.'" onmouseover="this.style.backgroundColor=\'#baaed6\'" onmouseout="this.style.backgroundColor=\'#d9d2e9\'" title="Double-click to open file"><div style="cursor:pointer;width:auto;float:left;" ondblclick="window.open($(\'#url\').val()+\'/imgs/'.$batch_files_array[$f].'\',\'file\')">'.$batch_files_array[$f].'</div>'.$remove_button.'</div>';
						
					}else{
						$batch_files .= '<div style="user-select:none;width:auto;padding:5px;margin:5px;float:left;height:30px;line-height:30px;background-color:#d9d2e9;border-radius:15px;overflow:hidden" id="batch_file_'.$meeting_batches['id'][$b].'_'.$f.'" onmouseover="this.style.backgroundColor=\'#baaed6\'" onmouseout="this.style.backgroundColor=\'#d9d2e9\'" title="Double-click to open file"><div style="cursor:pointer;width:auto;float:left;" ondblclick="window.open($(\'#url\').val()+\'/imgs/'.$batch_files_array[$f].'\',\'file\')">'.$batch_files_array[$f].'</div>'.$remove_button.'</div>';
					}
				}
			}
			
			?>
			<div style="width:100%;height;auto;float:left;background-color:<?php print($color);?>;margin-bottom:solid 1px #eee;" id="batch_item_<?php print($meeting_batches['id'][$b]);?>">
				<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>'" onmouseout="this.style.backgroundColor='<?php print($color);?>';" onclick="expand_collapse_batch(<?php print($meeting_batches['id'][$b]);?>)" id="batch_title_<?php print($meeting_batches['id'][$b]);?>"><div style="width:20px;height:20px;float:left;"></div><div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($meeting_batches['batch_number'][$b]);?></div><div style="width:90px;height:20px;float:left;margin-right:3px;"><?php print(date('dS M, Y',$meeting_batches['_date'][$b]));?></div><div style="width:300px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($meeting_batches['title'][$b]);?></div>
			
				<div style="width:100px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($number_of_meetings);?></div><div style="width:200px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($creator_title);?></div><div style="width:70px;min-height:20px;height:auto;float:left;margin-right:3px;text-align:left;"><?php print($total_participants);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;text-align:left;"><?php print($claim_number);?></div></div>
				<input type="hidden" id="batch_expanded_<?php print($meeting_batches['id'][$b]);?>" value="0">
			
				<div style="width:100%;min-height:150px;height;auto;float:left;display:none;border-bottom:solid 1px #aaa;margin-bottom:10px;" id="batch_details_holder_<?php print($meeting_batches['id'][$b]);?>">
				
					<div style="width:100%;height:20px;line-height:20px;background-color:#bbb;text-align:center;cursor:pointer;" onclick="$('#batch_meetings_<?php print($meeting_batches['id'][$b]);?>').slideToggle('fast');">Click to view/hide meetings or teams in this batch</div>
					<div style="padding:2px;width:97%;height:auto;float:left;display:none;background-color:#eee;border-bottom:solid 1px #ccc;margin-bottom:10px;" id="batch_meetings_<?php print($meeting_batches['id'][$b]);?>"><?php print($meeting_titles);?></div>
					
					<div style="width:100%;min-height:90px;height:auto;float:left;" id="batch_files_<?php print($meeting_batches['id'][$b]);?>"><?php print($batch_files);?></div>
					<input type="hidden" id="total_batch_files_<?php print($meeting_batches['id'][$b]);?>" value="<?php print($total_batch_files);?>">
					<div style="width:100%;min-height:30px;height:auto;float:left;margin-top:5px;">
						<div style="width:580px;min-height:30px;height:auto;margin:0 auto;">
							<?php
							if(($user_id == $meeting_batches['user_id'][$b]) || $active_user_roles[8]){
								
								if($meeting_batches['status'][$b] == 1){
								
								?>
									<div style="width:100px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864'" onmouseout="this.style.backgroundColor='orange'" id="batch_meetings_button" onclick="edit_batch(<?php print($meeting_batches['id'][$b]);?>);" title="Click to open claim form">Edit batch</div>
								
								<?php
								}
								?>
							
								<div style="width:120px;height:30px;background-color:#0faeaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#20908e'" onmouseout="this.style.backgroundColor='#0faeaa'" id="batch_meetings_button" onclick="download_participant_claim_form(<?php print($meeting_batches['id'][$b]);?>);" title="Click to open claim form">Open claim form</div>
							
								<?php
								if($meeting_batches['status'][$b] == 1 || $user_id == 1031){
								?>
								
									<div style="width:80px;height:30px;background-color:#9fc5e8;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#7fa4c7'" onmouseout="this.style.backgroundColor='#9fc5e8'" id="batch_meetings_button" onclick="open_uploader('process_batch_attachment(<?php print($meeting_batches['id'][$b]);?>)',1);" title="Click to add files to this batch">Add files</div>
									
									<div style="width:150px;height:30px;background-color:#c27ba0;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#b3608b'" onmouseout="this.style.backgroundColor='#c27ba0'" onclick="send_batch_to_finance(<?php print($meeting_batches['id'][$b]);?>)" title="Click to send this batch to finance for payment processing" id="send_to_finance_button_<?php print($meeting_batches['id'][$b]);?>">Send batch to finance</div>
									
									<div style="width:100px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#8d1d1d'" onmouseout="this.style.backgroundColor='brown'" id="delete_meeting_batch_button" onclick="delete_meeting_batch(<?php print($meeting_batches['id'][$b]);?>)" title="Click to delete this batch">Delete batch</div>
								
								<?php
								}
							}else if($meeting_batches['status'][$b] != 0){
								?>
								<div style="width:100%;height:50px;line-height:20px;float:left;color:purple;font-size:1.2em;text-align:center;">Please note that this batch can only be edited by the creator or a user with super administrative roles</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
	}
if($skip_location || $search_string != ''){
	?>
<script>
	$('#list_status_bar').html('<strong>Records found:</strong> <?php print(number_format($record_count));?>');
	
	
</script>

<?php
}
?>
<script>
freeze_header('batches_header');
</script>