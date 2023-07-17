	<div style="width:100%;height:30px;float:left;margin-top:10px;">Number of agents to allocate: <?php print(count($selected_agents));?></div>
	
	<div style="width:auto;height:auto;float:left;" id="user_selection_holder1">
		<div style="width:85px;height:30px;line-height:30px;float:left;color:#006bb3">Allocate to:</div>

		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#allocation_menu1').toggle('fast');" id="active_allocation1" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($user_results['_name']);?></div>



		<div class="option_menu" id="allocation_menu1" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu1').toggle('fast');$('#active_allocation1').html($(this).html());$('#selected_allocation1').val(0);">[Remove allocation]</div>
		
		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu1').toggle('fast');$('#active_allocation1').html($(this).html());$('#selected_allocation1').val(<?php print($user_results['id']);?>);"><?php print($user_results['_name']);?></div>

			<?php
			
			$this_users = mysqli_query($connect,"select * from users where id != $user_id order by _name")or die(mysqli_error($connect));
			
			for($u=0;$u<mysqli_num_rows($this_users);$u++){
				$this_user_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
				?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu1').toggle('fast');$('#active_allocation1').html($(this).html());$('#selected_allocation1').val(<?php print($this_user_results['id']);?>);"><?php print($this_user_results['_name']);?></div>
				
				<?php
			}
			?>

		</div>

		</div>

		<input type="hidden" id="selected_allocation1" value="<?php print($user_results['id']);?>">
		
		<div style="cursor:pointer;width:30px;height:25px;float:left;margin-right:2px;text-align:center;line-height:25px;border:solid 1px #ccc;" class="fa fa-search" onmouseover="this.style.backgroundColor='purple';this.style.color='#fff';" onmouseout="this.style.backgroundColor='';this.style.color='#000';" title="Click to search users" onclick="$('#search_selection_holder1').slideDown('fast');$('#user_selection_holder1').slideUp('fast');"></div>
	</div>
	
	<div style="width:auto;height:auto;float:left;margin-right:5px;border:solid 1px purple;display:none;background-color:#fff5ff" id="search_selection_holder1">
	<div style="width:80px;height:30px;line-height:30px;float:left;color:#006bb3;margin-left:2px;">Search user:</div>

		<div style="width:auto;min-height:30px;height:auto;float:left;">
	<input type="text" style="height:25px;width:110px;margin-top:2px;" id="allocation_users_search_key1" onkeyup="if (event.keyCode == 13) {search_allocation_users(1);}"></div>
	<div style="width:50px;cursor:pointer;height:30px;line-height:30px;float:left;margin-left:5px;text-align:center;background-color:purple;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#a921a9';" onmouseout="this.style.backgroundColor='purple';" onclick="search_allocation_users(1);">Search</div>
	
	<div style="width:20px;height:30px;line-height:30px;float:left;text-align:center;background-color:#999;cursor:pointer;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#888';" onmouseout="this.style.backgroundColor='#999';" onclick="$('#search_selection_holder1').slideUp('fast');$('#user_selection_holder1').slideDown('fast');">X</div>
	
	<div style="width:270px;display:none;position:absolute;height:140px;border:solid 1px #aaa;margin-top:30px;background-color:#fff;" id="agent_search_result_holder1">
	<div style="width:100%;height:20px;float:left;background-color:#bf8dbf;color:#fff;text-align:center;">Search results</div>
	
	<div style="width:100%;height:120px;float:left;overflow:auto;" id="search_results_holder1"></div>
	
	</div>
	</div>
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="user_allocation_button" onclick="complete_allocate_user();" title="Click to update account details">Allocate</div>

</div>