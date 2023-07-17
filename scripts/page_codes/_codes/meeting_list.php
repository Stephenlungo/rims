<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="list_status_bar" onclick="$('#claim_number_holder').slideToggle('fast');" title="Click to view claim numbers"><strong>Records found:</strong> (Counting...)</div><div style="width:auto;height:20px;line-height:20px;float:left;margin-left:5px;left;">| Selected: </div>

<div style="width:auto;height:20px;line-height:20px;float:left;margin-left:5px;" id="total_selections"></div>

<div style="user-select: none;width:50px;height:20px;line-height:20px;float:left;margin-left:5px;cursor:pointer;" onmouseover="this.style.color='brown'" onmouseout="this.style.color=''" ondblclick="clear_selections('selected_meetings','meeting_check_box_','total_selections',1);" title="Double-click to clear all">| Clear</div>


<div class="general_button" style="margin-right:40px;width:90px;float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="view_meeting_details(0,0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">Create New</div>

<div class="general_button" style="margin-right:5px;width:110px;float:right;height:20px;line-height:20px;background-color:#a64d79;color:#fff;" onclick="export_meeting_list();" onmouseover="this.style.backgroundColor = '#943966';" onmouseout="this.style.backgroundColor = '#a64d79';" title="Click to add entry" id="export_meeting_button">Export meetings</div>

<div class="general_button" style="margin-right:5px;width:130px;float:right;height:20px;line-height:20px;background-color:#a64d79;color:#fff;" onclick="export_participant_list();" onmouseover="this.style.backgroundColor = '#943966';" onmouseout="this.style.backgroundColor = '#a64d79';" title="Click to add entry" id="export_participant_button">Export participants</div>

<div class="general_button" style="margin-right:5px;width:110px;float:right;height:20px;line-height:20px;background-color:#0faeaa;color:#fff;" onclick="batch_meetings();" onmouseover="this.style.backgroundColor='#20908e'" onmouseout="this.style.backgroundColor='#0faeaa'" title="Click to add entry" id="batch_meetings_button">Batch selected</div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="meetings_header"><div style="width:20px;height:20px;float:left;"><input type="checkbox" onchange="if(this.checked){select_in_view(1);}else{select_in_view(0);}" id="meeting_check_box_parent"></div><div style="width:50px;height:20px;float:left;margin-right:3px;">Code</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:280px;height:20px;float:left;margin-right:3px;">Title</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Creator</div><div style="width:183px;height:20px;float:left;margin-right:3px;">Location</div><div style="width:50px;height:20px;float:left;margin-right:3px;">Agents</div><div style="width:70px;height:20px;float:left;margin-right:3px;">Batch #</div><div style="width:70px;height:20px;float:left;margin-right:3px;">Claim #</div></div>


<?php
$search_string = '';
$skip_location = 0;
if($search_key_string != ''){
	if(is_numeric($search_key_string)){
		$search_string .= ' and (meeting_code = '.str_replace(",",' or meeting_code = ',$search_key_string).')';
		$skip_location = 1;
	}else{
		$search_string .= " and (title LIKE '%".str_replace(",","%' or title LIKE '%",$search_key_string)."%')";		
	}
}

if(!$skip_location){
	if($region_id){
		$search_string .= ' and region_id = '.$region_id;
	}

	if($province_id){
		$search_string .= ' and province_id = '.$province_id;
		
	}

	if($hub_id){
		$search_string .= ' and hub_id = '.$hub_id;
		
	}

	if($site_id){
		$search_string .= ' and site_id = '.$site_id;
	}
}

$meetings = fetch_db_table('connect','meetings',$company_id,'meeting_code desc, title'," id > 0 ".$search_string);
$id_in_view = '';
if(count($meetings['id']) > 500){
	?>
	
	<div style="width:100%;height:30px;line-height:30px;margin-top:40px;font-size:1.4em;float:left;text-align:center;color:brown"><i>Oops! There are too many results. Please narrow down your search for faster processing</i></div>
	
	<?php
	
}else{
	$regions = fetch_db_table('connect','regions',$company_id,'id',"");
	$provinces = fetch_db_table('connect','provinces',$company_id,'id',"");
	$hubs = fetch_db_table('connect','hubs',$company_id,'id',"");
	$sites = fetch_db_table('connect','sites',$company_id,'id',"");
	$users = fetch_db_table('connect','users',$company_id,'id',"");
	$units = fetch_db_table('connect','units',$company_id,'id'," status = 1");
	$activities = fetch_db_table('connect','activities',$company_id,'id',"");

	$meeting_batches = fetch_db_table('connect','meeting_batches',$company_id,'id',"");
	$participants = fetch_db_table('connect','meeting_participants',$company_id,'id'," status != 0 and active_status != 0");
	
	
	for($m=0;$m<count($meetings['id']);$m++){
		
		if($id_in_view == ''){
			$id_in_view = $meetings['id'][$m];
			
		}else{
			$id_in_view .= ','.$meetings['id'][$m];
			
		}
		
		$region_id = $meetings['region_id'][$m];
		$province_id = $meetings['province_id'][$m];
		$hub_id = $meetings['hub_id'][$m];
		$site_id = $meetings['site_id'][$m];
		$unit_id = $meetings['quick_report_unit_id'][$m];
		$activity_id = $meetings['quick_report_activity_id'][$m];
		
		$location_string = '';
		if($region_id){
			$region_index = array_keys($regions['id'],$region_id);
			
			if(isset($region_index[0])){
				$this_region_title = $regions['title'][$region_index[0]];
				
				$location_string .= 'Region: '.$this_region_title;
			}
		}
		
		if($province_id){
			$province_index = array_keys($provinces['id'],$province_id);
			
			if(isset($province_index[0])){
				$this_province_title = $provinces['title'][$province_index[0]];
				
				$location_string .= ', Privince: '.$this_province_title;
			}
		}
		
		$user_index = array_keys($users['id'],$meetings['user_id'][$m]);
		$meeting_creator = $users['_name'][$user_index[0]];

		$this_hub_title = 'Select item';
		if($hub_id){
			$hub_index = array_keys($hubs['id'],$hub_id);
			
			if(isset($hub_index[0])){
				$this_hub_title = $hubs['title'][$hub_index[0]];
				
				$location_string .= ', Hub: '.$this_hub_title;
			}
		}

		$this_site_title = 'Select item';
		if($site_id){
			$site_index = array_keys($sites['id'],$site_id);
			
			if(isset($site_index[0])){
				$this_site_title = $sites['title'][$site_index[0]];
				
				$location_string .= ', Site: '.$this_site_title;
			}
		}

		$this_unit_title = 'Unlimited';
		if($unit_id){
			$unit_index = array_keys($units['id'],$unit_id);
			
			if(isset($unit_index[0])){
				$this_unit_title = $units['title'][$unit_index[0]];
			}
		}

		$this_activity_title = 'Unlimited';
		if($activity_id){
			$activity_index = array_keys($activities['id'],$activity_id);
			
			if(isset($activity_index[0])){
				$this_activity_title = $activities['title'][$activity_index[0]];
			}
		}
		
		$participant_index = array_keys($participants['meeting_id'],$meetings['id'][$m]);
		
		$total_participants = 0;
		if(isset($participant_index[0])){
			$total_participants = count($participant_index);
			
		}
		
		$color = '';
		$hover_color = '';
		$check_disabled = '';
		$meeting_batched = 0;
		$batch_number = 'N/A';
		$claim_number = 'N/A';
		if($meetings['batched'][$m] == 1){
			$color = '#c2eae9';
			$hover_color = '#b2dad9';
			$check_disabled = ' disabled ';
			
			$meeting_batched = 1;
			
			$batch_number = $meetings['batch_number'][$m];
			
			$batch_index = array_keys($meeting_batches['batch_number'],$batch_number);
			
			if(isset($batch_index[0])){
				if($meeting_batches['claim_id'][$batch_index[0]]){
					$claim_number = $meeting_batches['claim_id'][$batch_index[0]];
				}
			}
		}
		
		
		
		?>
		<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;background-color:<?php print($color);?>;" id="meeting_title_<?php print($meetings['id'][$m]);?>" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($color);?>'" ><div style="width:20px;height:20px;float:left;"><input <?php print($check_disabled);?> type="checkbox" onchange="if(this.checked){add_to_selection(<?php print($meetings['id'][$m]);?>,'selected_meetings')}else{remove_from_selection(<?php print($meetings['id'][$m]);?>,'selected_meetings')};recount_selections('selected_meetings','total_selections',1)" id="meeting_check_box_<?php print($meetings['id'][$m]);?>"></div><div style="width:auto;height:auto;float:left;" onclick="expand_collapse_meeting(<?php print($meetings['id'][$m]);?>)" ><div style="width:50px;height:20px;float:left;margin-right:3px;"><?php print($meetings['meeting_code'][$m]);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print(date('d/m/Y',$meetings['_date'][$m]));?></div>
	<div style="width:280px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($meetings['title'][$m]);?></div><div style="width:150px;height:20px;float:left;margin-right:3px;"><?php print($meeting_creator);?></div><div style="width:183px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($location_string);?></div><div style="width:50px;height:20px;float:left;margin-right:3px;"><?php print($total_participants);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;"><?php print($batch_number);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;"><?php print($claim_number);?></div></div></div>

	<div style="width:100%;height:auto;float:left;min-height:200px;display:none;background-color:#e2ebed;margin-bottom:30px;" id="meeting_details_holder_<?php print($meetings['id'][$m]);?>"><?php if($meetings['batched'][$m] == 0){?><div style="width:100%;height:30px;float:left;" id="meeting_main_buttons_holder_0_<?php print($meetings['id'][$m]);?>"><div style="width:100px;height:25px;float:left;background-color:orange;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="view_meeting_details(<?php print($meetings['id'][$m].','.$meetings['parent_id'][$m]);?>,0);" onmouseover="this.style.backgroundColor='#ffb225'" onmouseout="this.style.backgroundColor='orange'">Edit meeting</div><div style="width:auto;float:left;" id="button_holder_0_<?php print($meetings['parent_id'][$m]);?>"><div style="width:120px;height:25px;float:left;background-color:#718a66;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="approve_meeting_participants(<?php print($meetings['id'][$m]);?>,1);" onmouseover="this.style.backgroundColor='#65745f'" onmouseout="this.style.backgroundColor='#718a66'" id="approve_meeting_participants_button_<?php print($meetings['id'][$m]);?>">Approve selected</div><div style="width:130px;height:25px;float:left;background-color:#f6abab;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="approve_meeting_participants(<?php print($meetings['id'][$m]);?>,0);" onmouseover="this.style.backgroundColor='#ea9a9a'" onmouseout="this.style.backgroundColor='#f6abab'" id="disapprove_meeting_participants_button_<?php print($meetings['id'][$m]);?>">Disapprove selected</div><div style="width:110px;height:25px;float:left;background-color:#006bb3;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="move_participants(<?php print($meetings['id'][$m]);?>);" onmouseover="this.style.backgroundColor='#3592d0'" onmouseout="this.style.backgroundColor='#006bb3'">Move selected</div><div style="width:120px;height:25px;float:right;background-color:brown;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="delete_meeting_participants(<?php print($meetings['id'][$m]);?>);" onmouseover="this.style.backgroundColor='#9a3a3a'" onmouseout="this.style.backgroundColor='brown'" id="delete_meeting_participants_button_<?php print($meetings['id'][$m]);?>">Delete selected</div></div></div><?php }else{ ?> <div style="width:100%;height:30px;line-height:30px;text-align:center;color:purple;font-size:1.2em;">This facility meeting/team is batched for payment. Editing is not available</div><?php }?>

	<div style="width:100%;min-height:160px;height:auto;float:left;" id="meeting_details_<?php print($meetings['id'][$m]);?>"></div><?php if($meetings['batched'][$m] == 0){?><div style="width:100%;height:30px;float:left;" id="meeting_main_buttons_holder_1_<?php print($meetings['id'][$m]);?>">

	<div style="width:100px;height:25px;float:left;background-color:orange;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="view_meeting_details(<?php print($meetings['id'][$m].','.$meetings['parent_id'][$m]);?>,0);" onmouseover="this.style.backgroundColor='#ffb225'" onmouseout="this.style.backgroundColor='orange'">Edit meeting</div><div style="width:auto;float:left;" id="button_holder_1_<?php print($meetings['parent_id'][$m]);?>"><div style="width:120px;height:25px;float:left;background-color:#718a66;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="approve_meeting_participants(<?php print($meetings['id'][$m]);?>,1);" onmouseover="this.style.backgroundColor='#65745f'" onmouseout="this.style.backgroundColor='#718a66'" id="approve_meeting_participants_button_1_<?php print($meetings['id'][$m]);?>">Approve selected</div><div style="width:130px;height:25px;float:left;background-color:#f6abab;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="approve_meeting_participants(<?php print($meetings['id'][$m]);?>,0);" onmouseover="this.style.backgroundColor='#ea9a9a'" onmouseout="this.style.backgroundColor='#f6abab'" id="disapprove_meeting_participants_button_1_<?php print($meetings['id'][$m]);?>">Disapprove selected</div><div style="width:110px;height:25px;float:left;background-color:#006bb3;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="move_participants(<?php print($meetings['id'][$m]);?>);" onmouseover="this.style.backgroundColor='#3592d0'" onmouseout="this.style.backgroundColor='#006bb3'">Move selected</div><div style="width:120px;height:25px;float:right;background-color:brown;text-align:center;line-height:25px;color:#fff;cursor:pointer;margin:2px;" onclick="delete_meeting_participants(<?php print($meetings['id'][$m]);?>);" onmouseover="this.style.backgroundColor='#9a3a3a'" onmouseout="this.style.backgroundColor='brown'" id="delete_meeting_participants_button_1_<?php print($meetings['id'][$m]);?>">Delete selected</div></div></div><?php }?></div>
		<input type="hidden" id="meeting_expanded_<?php print($meetings['id'][$m]);?>" id="0">
		<input type="hidden" id="meeting_batched_<?php print($meetings['id'][$m]);?>" value="<?php print($meeting_batched);?>">
		
		<script>
			if(window.XMLHttpRequest){
				meeting_xmlhttp_<?php print($meetings['id'][$m]);?> = new XMLHttpRequest();
				
			}else{
				meeting_xmlhttp_<?php print($meetings['id'][$m]);?> = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			meeting_xmlhttp_<?php print($meetings['id'][$m]);?>.onreadystatechange = function(){
				if(meeting_xmlhttp_<?php print($meetings['id'][$m]);?>.readyState == 4 && meeting_xmlhttp_<?php print($meetings['id'][$m]);?>.status == 200){
					var response_text = meeting_xmlhttp_<?php print($meetings['id'][$m]);?>.responseText;
					var response_array = response_text.split("[]");
				
					if(response_array[0] == 'show_meeting_participants'){
						$('#meeting_details_<?php print($meetings['id'][$m]);?>').html(response_array[1]);
						
					}else{
						$('#main_error_output').html(response_array[0]);
						$('#main_error_output').slideDown('fast');
					}
				}
			}
						
			
		</script>
		
		<?php
	}
}
?>
<input type="hidden" id="id_in_view_string" value="<?php print($id_in_view);?>">
<script>
$('#list_status_bar').html("<strong>Records found: </strong><?php print(count($meetings['id']));?>");

recount_selections('selected_meetings','total_selections',1);
mark_selected('selected_meetings','meeting_check_box_');

freeze_header('meetings_header');
</script>