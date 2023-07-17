<div style="width:350px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<input type="text" id="agent_search_key" value="Enter group name here" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter group name here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter group name here';this.style.color='#aaa';}" title="Enter group name. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {fetch_user_group_list()}">
	
	</div>
	
	<div style="width:auto;height:auto;float:left;" id="cluster_0_holder">
		<?php
		$this_branch_id = $user_results['branch_id'];
		if(!$this_branch_id){
			$this_branch_title = 'All clusters';
			$this_branch_id = 0;
			
		}else{
			$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
			$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
			$this_branch_title = $this_branch_results['title'];
			
		}
		?>
			<div style="width:50px;height:30px;line-height:30px;float:left;">Cluster:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?> $('#branch_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change this option'); <?php }?>" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

			<div class="option_menu" id="branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(0);">All clusters</div>
				<?php
				
					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

					for($b=0;$b<mysqli_num_rows($branch_menu);$b++){
						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(<?php print($branch_menu_results['id']);?>);"><?php print($branch_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_branch" value="<?php print($user_results['branch_id']);?>">
		</div>
		
		<div style="width:auto;height:auto;float:left;">
			<div style="width:50px;height:30px;line-height:30px;float:left;">Status:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#status_menu').toggle('fast');" id="active_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Active user groups</div>

			<div class="option_menu" id="status_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val('');">All user groups</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(1);">Active user groups</div>
					
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(0);">Inactive user groups</div>
			</div>
			</div>
			<input type="hidden" id="selected_status" value="1">
		</div>

	
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="group_fetch_button" onclick="fetch_user_group_list();" title="Click to fetch report with specified options">Fetch</div>