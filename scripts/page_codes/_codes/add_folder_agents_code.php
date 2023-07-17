<?php
$this_folder = fetch_db_table('connect','payment_folders',$company_id,'id','id = '.$folder_id);
?>

<div style="width:48%;float:left;height:auto;">


<div style="width:100%;height:30px;float:left;margin-top:2px;margin-bottom:2px;">
		<input type="text" id="search_agent_key_string" value="Enter agent ID, phone, NRC or names" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter agent ID, phone, NRC or names'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter agent ID, phone, NRC or names';this.style.color='#aaa';}" title="Enter search your search. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {search_folder_agents();}">
	
	</div>
	
	
	
	
	
	<div style="width:100%;height:auto;float:left;display:none;" id="search_agents_holder">
		<div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#d5a6bd">Agent search results</div>
		
		<div style="width:100%;height:auto;float:left;height:400px;overflow:auto;" id="agent_folder_search_results"></div>
	</div>
	
</div>

<div style="width:48%;float:right;height:auto;">
	<div style="width:100%;height:auto;border:solid 1px #eee;float:left;margin-top:5px;"><div style="width:100%;height:20px;line-height:20px;float:left;text-align:center;background-color:#d9ead3">Selected agents to add in this folder</div>
	<div style="width:100%;height:auto;float:left;height:400px;overflow:auto;" id="selected_folder_agent_holder"></div>
	
	</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:5px;">
		<div style="width:90px;height:30px;background-color:#93c47d;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#b6d7a8'" onmouseout="this.style.backgroundColor='#93c47d'" id="save_add_agent_to_folder_button" onclick="save_add_agents_to_folder(<?php print($folder_id);?>);" title="Click to save details">Save</div
	</div>
	<input type="hidden" id="this_folder_id" value="<?php print($folder_id);?>">
	</div>
	
	<input type="hidden" id="selected_folder_agents" value="<?php print($this_folder['agent_entries'][0]);?>">
	
	<script>
	function add_to_folder_preview(agent_id){
		
		var preview_agent_div = '<div style="width:100%;min-height:20px;line-height:20px;height:auto;float:left;border-bottom:solid 1px #eee;" id="preview_agent_'+agent_id+'"><div style="width:180px;height:auto;float:left;">'+$('#folder_agent_name_'+agent_id).html()+'</div><div style="width:100px;height:auto;float:left;">'+$('#folder_agent_nrc_'+agent_id).html()+'</div> <div style="width:30px;height:20px;line-height:20px;text-align:center;background-color:brown;color:#fff;float:left;" onclick="var c = confirm(\'Are you sure you wish to remove this agent\');if(c){remove_from_selection('+agent_id+',\'selected_folder_agents\');remove_from_folder_preview('+agent_id+');}">X</div></div>';
		
		$('#selected_folder_agent_holder').append(preview_agent_div);
		
	}
	
	function remove_from_folder_preview(agent_id){
		$('#preview_agent_'+agent_id).remove();
		
		document.getElementById('folder_agent_checkbox_'+agent_id).checked = false;
		
	}
	
	</script>