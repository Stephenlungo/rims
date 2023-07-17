<div style="width:100%;height:30px;float:left;margin-bottom:10px;margin-top:10px;">
<input type="hidden" id="selected_checklist_client_<?php print($checklist_id);?>" value="0"><div style="width:auto;float:left;line-height:30px;height:30px;margin-right:5px;">Client:</div>
	<div style="width:auto;height:30px;line-height:30px;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#checklist_client_menu_<?php print($checklist_id);?>').toggle('fast');" id="active_client_check_list_<?php print($checklist_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:90px;max-width:100%;width:auto;">Current Client</div>

	<div class="option_menu" id="checklist_client_menu_<?php print($checklist_id);?>" style="display:none;width:auto;">
		
	
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#checklist_client_menu_<?php print($checklist_id);?>').toggle('fast');$('#active_client_check_list_<?php print($checklist_id);?>').html($(this).html());$('#selected_checklist_client_<?php print($checklist_id);?>').val(0);$('#checklist_client_search_<?php print($checklist_id);?>').slideUp('fast');$('#checklist_client_search_results_holder_<?php print($checklist_id);?>').slideUp('fast');">Current Client</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#checklist_client_menu_<?php print($checklist_id);?>').toggle('fast');$('#active_client_check_list_<?php print($checklist_id);?>').html($(this).html());$('#selected_checklist_client_<?php print($checklist_id);?>').val('-1');$('#checklist_client_search_<?php print($checklist_id);?>').slideDown('fast');">Search for client</div>
	</div>
	</div>
</div>
<input type="hidden" id="checkilst_<?php print($checklist_id);?>_client" value="0">

<div style="width:100%;height:30px;float:left;margin-bottom:10px;display:none;" id="checklist_client_search_<?php print($checklist_id);?>">
<div style="width:auto;float:left;line-height:30px;height:30px;margin-right:3px;">Search:</div>
<div style="width:147px;height:30px;float:left;"><input type="text" id="checklist_client_search_input" value="Enter name, ID or phone" style="width:100%;height:30px;color:#aaa;" onfocus="if(this.value=='Enter name, ID or phone'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter name, ID or phone';this.style.color='#aaa';}" onkeyup="if(event.keyCode == 13) {search_checklist_clients(<?php print($checklist_id);?>);};"></div>

<div style="cursor:pointer;color:#fff;width:50px;height:30px;float:left;margin-left:5px;background-color:orange;text-align:center;line-height:30px;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="search_checklist_clients(<?php print($checklist_id);?>);">Search</div>

</div>

<div style="width:255px;height:145px;float:left;margin-bottom:10px;background-color:#fff;position:absolute;margin-top:100px;border:solid 1px #ddd;display:none;" id="checklist_client_search_results_holder_<?php print($checklist_id);?>">

<div style="width:100%;height:20px;float:left;background-color:#8ae35c;text-align:center;line-height:20px;">Client Search Results<div style="float:right;height:20px;width:20px;text-align:center;line-height:20px;background-color:#a52a2a;cursor:pointer;" onmouseover="this.style.backgroundColor='#ba5050';" onmouseout="this.style.backgroundColor='#a52a2a'" onclick="$('#checklist_client_search_results_holder_<?php print($checklist_id);?>').slideUp('fast');">X</div></div>

<div style="width:100%;height:auto;float:left;" id="checklist_client_search_results_<?php print($checklist_id);?>"></div>
</div>

<?php
	$categories = mysqli_query($connect,"select * from dynamic_checklist_categories where dynamic_checklist_id = $checklist_id and status = 1 order by _order")or die(mysqli_error($connect));
	
	$category_ids = '';
	for($c=0;$c<mysqli_num_rows($categories);$c++){
		$category_results = mysqli_fetch_array($categories,MYSQLI_ASSOC);
		?>
		<div style="width:100%;min-height:20px;height:auto;float:left;font-weight:bold;margin-top:5px;"><?php print($category_results['title']);?></div>
		<?php
		
		$this_category_id = $category_results['id'];
		
		if($category_ids == ''){
			$category_ids = $this_category_id;
			
		}else{
			$category_ids .= ','.$this_category_id;
		}
		
		$category_options = mysqli_query($connect,"select * from dynamic_checklist_category_options where dynamic_checklist_id  = $checklist_id and dynamic_checklist_category_id = $this_category_id and status = 1 order by _order")or die(mysqli_error($connect));
		
		$category_option_ids = '';
		for($o=0;$o<mysqli_num_rows($category_options);$o++){
			$category_option_results = mysqli_fetch_array($category_options,MYSQLI_ASSOC);
			$this_option_id = $category_option_results['id'];
			
			if($category_option_ids == ''){
				$category_option_ids = $this_option_id;
				
			}else{
				$category_option_ids .= ','.$this_option_id;				
			}
			
			?>
			<div style="width:100%;min-height:20px;height:auto;float:left;"><div style="width:20px;height:20px;float:left;"><input type="checkbox" id="checklist_option_<?php print($this_category_id.','.$this_option_id);?>" onchange="if(this.checked){$('#checklist_input_<?php print($checklist_id.'_'.$this_option_id);?>').val(1);}else{$('#checklist_input_<?php print($checklist_id.'_'.$this_option_id);?>').val(0);}"></div><div style="width:90%;min-height:20px;line-height:20px;height:auto;float:left;margin-left:5px;border-bottom:solid 1px #eee;background-color:#ecd98d"><label for="checklist_option_<?php print($this_category_id.','.$this_option_id);?>"><?php print(($o+1).'. '.$category_option_results['option_title']);?></label></div></div>
			<div style="width:90%;margin-left:25px;min-height:20px;height:auto;float:left;margin-bottom:10px;font-size:0.85em;"><label for="checklist_option_<?php print($this_category_id.','.$this_option_id);?>"><?php print($category_option_results['description']);?></label></div>
			<input id="checklist_input_value_<?php print($checklist_id.'_'.$this_category_id.'_'.$this_option_id);?>" value="0" type="hidden"> 
			
			<?php
		}
		?>
		<input id="category_option_ids_<?php print($checklist_id.','.$this_category_id);?>" value="<?php print($category_option_ids);?>" type="hidden">
		
		<?php
	}
?>
<input id="category_ids_<?php print($checklist_id);?>" type="hidden" value="<?php print($category_ids);?>">

<div style="width:100%;height:30px;margin-bottom:20px;float:left;font-weight:bold;color:red;display:none;" id="checklist_error_message"></div>

<div style="width:100%;height:30px;margin-bottom:20px;float:left;"><div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="checklist_save_button_<?php print($checklist_id);?>" onclick="create_or_update_checklist(<?php print($checklist_id);?>);" title="Click to update account details">Save</div></div>