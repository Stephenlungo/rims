<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;">
	<div style="width:120px;height:20px;float:left;">Date</div>
	<div style="width:120px;height:20px;float:left;">Time</div>
	<div style="width:220px;height:20px;float:left;">User</div>
	<div style="width:300px;height:20px;float:left">Description</div>
</div>

	<?php
	$changes = mysqli_query($connect,"select * from change_tracker where (alteration_table = 'agents' or alteration_table = 'phone_numbers') and entry_id = $agent_id order by id desc")or die(mysqli_error($connect));
	?>
	
	
	<div style="width:100%;height:auto;float:left;" id="user_current_targets_data">
	<?php
		if(!mysqli_num_rows($changes)){
			?>
			<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onclick="alert('Details unavailable');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
				<div style="width:120px;height:20px;float:left;"><?php print(date('jS M, Y',$this_agent_results['_date']));?></div>
				<div style="width:120px;height:20px;float:left;"><?php print(date('H:i:s',$this_agent_results['_date']));?></div>
				<div style="width:220px;height:20px;float:left;"><i>Unreconnised</i></div>
				<div style="width:300px;height:20px;float:left">User created</div>
			</div>
			
			
			<?php	
		}else{
			for($c=0;$c<mysqli_num_rows($changes);$c++){
				$change_results = mysqli_fetch_array($changes,MYSQLI_ASSOC);
				
				$update_user_id = $change_results['user_id'];
				$this_user_index = array_keys($user_array['id'],$update_user_id);
				
				$update_user = '<i>Not found</i>';
				if(isset($this_user_index[0])){
					$update_user = $user_array['_name'][$this_user_index[0]];
					
				}
				
				?>
				<div style="cursor:pointer;width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onclick="$('#change_details_<?php print($change_results['id']);?>').slideToggle('fast');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
					<div style="width:120px;height:20px;float:left;"><?php print(date('jS M, Y',$change_results['_date']));?></div>
					<div style="width:120px;height:20px;float:left;"><?php print(date('H:i:s',$change_results['_date']));?></div>
					<div style="width:220px;height:20px;float:left;"><?php print($update_user);?></div>
					<div style="width:300px;height:20px;float:left"><?php print($change_results['query_description']);?></div>
				</div>
				<div style="width:100%;max-height:300px;height:auto;float:left;overflow:auto;background-color:#fee;display:none;margin-bottom:10px;;border-bottom:solid 2px #999;padding-bottom:5px;" id="change_details_<?php print($change_results['id']);?>" >
				<strong>SQL string</strong><br>
				<?php 
					print($change_results['sql_query']);?><br><br>
					
					<strong>Undo SQL string</strong><br>
					<?php print($change_results['undo_query']);?>
				</div>
				<?php
			}


		?>
			<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;" onclick="alert('Details unavailable');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
				<div style="width:120px;height:20px;float:left;"><?php print(date('jS M, Y',$this_agent_results['_date']));?></div>
				<div style="width:120px;height:20px;float:left;"><?php print(date('H:i:s',$this_agent_results['_date']));?></div>
				<div style="width:220px;height:20px;float:left;"><i>Unreconnised</i></div>
				<div style="width:300px;height:20px;float:left">User created</div>
			</div>

		<?php			
		}
	?>
	
	
	</div>