<div style="width:550px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<div style="width:120px;height:30px;line-height:30px;float:left;">From (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_from" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;">To (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
	
	</div>

<script>
	$(function(){
		$( "#date_from" ).datepicker();
		$( "#date_to" ).datepicker();
	});
</script>

	
	
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
			<div style="width:100px;height:30px;line-height:30px;float:left;">SMS Database:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			
			<div class="option_item" title="Click to change option" onclick="$('#sms_group_menu').toggle('fast');" id="active_sms_group" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All databases</div>

			<div class="option_menu" id="sms_group_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_group_menu').toggle('fast');$('#active_sms_group').html($(this).html());$('#selected_sms_group').val(0);">All databases</div>
				
				<?php
				
				if(!$user_results['branch_id']){
					$branch_search = '';
					
				}else{
					$branch_search = ' and branch_id = '.$user_results['branch_id'];
				}
				
				$sms_group_menu = mysqli_query($connect,"select * from sms_groups where company_id = $company_id $branch_search order by title")or die(mysqli_error($connect));

				for($g=0;$g<mysqli_num_rows($sms_group_menu);$g++){
					$sms_group_menu_results = mysqli_fetch_array($sms_group_menu,MYSQLI_ASSOC);
					?>
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_group_menu').toggle('fast');$('#active_sms_group').html($(this).html());$('#selected_sms_group').val(<?php print($sms_group_menu_results['id']);?>);"><?php print($sms_group_menu_results['title']);?></div>
					<?php
				}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_sms_group" value="0">
		</div>
		
		<div style="width:auto;height:auto;float:left;">
		<div style="width:60px;height:30px;line-height:30px;float:left;">Status:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		
		<div class="option_item" title="Click to change option" onclick="$('#sms_status_menu').toggle('fast');" id="active_sms_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Active</div>

		<div class="option_menu" id="sms_status_menu" style="display:none;width:110px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_status_menu').toggle('fast');$('#active_sms_status').html($(this).html());$('#selected_sms_status').val(-1);">All clients</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_status_menu').toggle('fast');$('#active_sms_status').html($(this).html());$('#selected_sms_status').val(1);">Active</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#sms_status_menu').toggle('fast');$('#active_sms_status').html($(this).html());$('#selected_sms_status').val(0);">Inactive</div>
			
		</div>
		</div>
		<input type="hidden" id="selected_sms_status" value="1">
	</div>
		
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_sms_clients()" title="Click to fetch results">Fetch</div>