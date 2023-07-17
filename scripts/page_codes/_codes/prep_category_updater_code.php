<div style="width:100%;height:30px;line-height:30px;font-size:1.2em;color:#536a01;float:left;border-bottom:solid 1px #eef"><div style="width:auto;height:30px;float:left;"><?php print($this_category_results['title']);?></div></div>
<?php
$form_category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $category_id and status = 1 order by _order")or die(mysqli_error($connect));
				
		$update_category_option_id_string = '';
		$default_option_id = '';
		for($o=0;$o<mysqli_num_rows($form_category_options);$o++){
			$form_update_category_option_results = mysqli_fetch_array($form_category_options,MYSQLI_ASSOC);
			$this_option_id = $form_update_category_option_results['id'];
			
			if($update_category_option_id_string == ''){
				$update_category_option_id_string = $form_update_category_option_results['id'];
				
			}else{
				$update_category_option_id_string .= ','.$form_update_category_option_results['id'];
				
			}
			
			$check_option_value = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_category_id = $category_id and dynamic_form_category_option_id = $this_option_id and dynamic_form_data_set_id = $data_set_id")or die(mysqli_error($connect));
		
			if($form_update_category_option_results['option_type'] == 0 || $form_update_category_option_results['option_type'] == 1){
				if(mysqli_num_rows($check_option_value)){
					$checked_status = ' checked ';
					$option_value = 1;
					$default_option_id = $this_option_id;
	
				}else{
					$checked_status = '';
					$option_value = '';
					
				}
				?>
				<div style="width:100%;min-height:20px;height:auto;float:left;line-height:20px;">
				<input type="hidden" id="update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value" value="<?php print($option_value);?>">
				
				
				
					<div style="width:20px;float:left;height:20px;">
					<?php
					if($form_update_category_option_results['option_type'] == 0){
						?>
						<input <?php print($checked_status);?> type="radio" name="update_category_options_<?php print($category_id);?>" id="update_category_options_<?php print($category_id.'_'.$this_option_id);?>" onclick="if($('#update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value').val() != 1){$('#update_category_option_<?php print($category_id);?>_'+$('#active_update_category_option_<?php print($category_id);?>').val()+'_value').val('');$('#update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value').val(1);$('#active_update_category_option_<?php print($category_id);?>').val(<?php print($this_option_id);?>);}else{$('#update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value').val('');$('#active_update_category_option_<?php print($category_id);?>').val('');this.checked = false;}">
					<?php
					}else{
					?>
						<input <?php print($checked_status);?> type="checkbox" id="update_category_options_<?php print($category_id.'_'.$this_option_id);?>" onchange="if(this.checked){$('#update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value').val(1);}else{$('#update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value').val('');}">
						
					<?php
					}
					?>
					</div>
					<div style="width:auto;float:left;min-height:20px;height:auto;float:left"><label for="update_category_options_<?php print($category_id.'_'.$this_option_id);?>"><?php print($form_update_category_option_results['category_title']);?></label></div>
				</div>
				
				<?php
			
			}else if($form_update_category_option_results['option_type'] == 2 || $form_update_category_option_results['option_type'] == 3 || $form_update_category_option_results['option_type'] == 4){
				
				if(mysqli_num_rows($check_option_value)){
					$check_option_value_results = mysqli_fetch_array($check_option_value,MYSQLI_ASSOC);
					
					$this_value = $check_option_value_results['_value'];
					
				}else{
					$this_value = '';
					
				}
				
				?>
				<div style="100%;height:auto;float:left;margin-bottom:2px;">
				<div style="width:140px;margin-left:20px;min-height:20px;height:auto;float:left;line-height:20px;">
					<?php print($form_update_category_option_results['category_title']);?>:
				</div>
				
				<div style="width:250px;float:left;height:30px;line-height:30px;margin-left:5px;margin-right:5px;">
				<?php
				if($form_update_category_option_results['option_type'] == 2){
					?>
					<input type="text" value="<?php print($this_value);?>" id="update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value" style="width:100%;height:25px;color:#aaa;" onfocus="if(this.value=='Enter response here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter response here';this.style.color='#aaa';}">
					<?php
					
				}else{
					
					if($this_value == 0){
						$option_hidding = 'display:none;';
						$day_title = 'Select date';
						$day_value = 0;
						
						$month_title = date('m',time());
						$month_value = date('m',time());
						
						$year_title = date('Y',time());
						$year_value = date('Y',time());
						
					}else{
						$option_hidding = '';
						
						$day_title = date('j',$this_value);
						$day_value = date('j',$this_value);
						
						$month_title = date('m',$this_value);
						$month_value = date('m',$this_value);
						
						$year_title = date('Y',$this_value);
						$year_value = date('Y',$this_value);
						
					}
					?>
					
					<div style="width:auto;height:20px;float:left;" >
					<div style="width:auto;float:left;height:auto;" id="update_option_day_options_<?php print($category_id.'_'.$this_option_id);?>">
						<div style="line-height:30px;width:30px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3"><i>Day:</i></div>
							<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#update_form_field_day_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');" id="update_form_field_active_day_<?php print($category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print($day_title);?></div>


			<div class="option_menu" id="update_form_field_day_menu_<?php print($category_id.'_'.$this_option_id);?>" style="display:none;width:80px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#update_form_field_day_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');$('#update_option_month_options_<?php print($category_id.'_'.$this_option_id);?>').slideUp('fast');$('#update_option_year_options_<?php print($category_id.'_'.$this_option_id);?>').slideUp('fast');$('#update_form_field_active_day_<?php print($category_id.'_'.$this_option_id);?>').html($(this).html());$('#update_form_field_day_value_<?php print($category_id.'_'.$this_option_id);?>').val(0);" style="width:80px;">N/A</div>
			
			<?php
			for($d=1;$d<32;$d++){
				if($d<10){
					$do='0'.$d;
				}else{
					$do = $d;
				}
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#update_form_field_day_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');$('#update_option_month_options_<?php print($category_id.'_'.$this_option_id);?>').slideDown('fast');$('#update_option_year_options_<?php print($category_id.'_'.$this_option_id);?>').slideDown('fast');$('#update_form_field_active_day_<?php print($category_id.'_'.$this_option_id);?>').html($(this).html());$('#update_form_field_day_value_<?php print($category_id.'_'.$this_option_id);?>').val(<?php print($d);?>);" style="width:40px;"><?php print($do);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" name="update_form_field_day_value_<?php print($category_id.'_'.$this_option_id);?>" id="update_form_field_day_value_<?php print($category_id.'_'.$this_option_id);?>" value="<?php print($day_value);?>">
			</div>
			</div>
			
			<div style="width:auto;float:left;height:auto;<?php print($option_hidding);?>" id="update_option_month_options_<?php print($category_id.'_'.$this_option_id);?>">
			<div style="line-height:30px;width:40px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3">Month:</div>
			<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#update_form_field_month_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');" id="update_form_field_active_month_<?php print($category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print($month_title);?></div>


			<div class="option_menu" id="update_form_field_month_menu_<?php print($category_id.'_'.$this_option_id);?>" style="display:none;">
			<?php
			for($m=1;$m<13;$m++){
				
				if($m<10){
					$mo='0'.$m;
				}else{
					$mo = $m;
				}
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#update_form_field_month_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');$('#update_form_field_active_month_<?php print($category_id.'_'.$this_option_id);?>').html($(this).html());$('#update_form_field_month_value_<?php print($category_id.'_'.$this_option_id);?>').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" name="update_form_field_month_value_<?php print($category_id.'_'.$this_option_id);?>" id="update_form_field_month_value_<?php print($category_id.'_'.$this_option_id);?>" value="<?php print($month_value);?>">
			</div>
			</div>
			
			<div style="width:auto;float:left;height:auto;<?php print($option_hidding);?>" id="update_option_year_options_<?php print($category_id.'_'.$this_option_id);?>">
			<div style="line-height:30px;width:20px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3">Yr:</div>
			<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#update_form_field_year_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');" id="update_form_field_active_year_<?php print($category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print($year_title);?></div>


			<div class="option_menu" id="update_form_field_year_menu_<?php print($category_id.'_'.$this_option_id);?>" style="display:none;">
			<?php
			for($y=(date('Y',time()) + 5);$y>(date('Y',time()) - 100);$y--){
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#update_form_field_year_menu_<?php print($category_id.'_'.$this_option_id);?>').toggle('fast');$('#update_form_field_active_year_<?php print($category_id.'_'.$this_option_id);?>').html($(this).html());$('#update_form_field_year_value_<?php print($category_id.'_'.$this_option_id);?>').val(<?php print($y);?>);" style="width:75px;"><?php print($y);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" name="update_form_field_year_value_<?php print($category_id.'_'.$this_option_id);?>" id="update_form_field_year_value_<?php print($category_id.'_'.$this_option_id);?>" value="<?php print($year_value);?>">
			</div>

			</div>
			</div>
			<?php
				}
				?>
				</div>
				</div>
				<?php
				
			}else if($form_update_category_option_results['option_type'] == 5){
				if(mysqli_num_rows($check_option_value)){
					$check_option_value_results = mysqli_fetch_array($check_option_value,MYSQLI_ASSOC);
					
					$this_value = $check_option_value_results['_value'];
					
				}else{
					$this_value = '';
					
				}
				
				
				
				?>
				<div style="100%;height:auto;float:left;margin-bottom:2px;margin-top:30px;">
				<div style="width:100%;margin-left:20px;min-height:20px;height:auto;float:left;line-height:20px;font-weight:bold;">
					<?php print($form_update_category_option_results['category_title']);?>
				</div>
				
				<div style="width:700px;height:300px;float:left;background-color:red;" id="map_<?php print($this_option_id);?>">
					<?php
					include 'map_script.php';
					?>
				</div>
				
				<div style="width:100%;float:left;height:30px;line-height:30px;margin-top:5px;">
				<div style="width:auto;float:left;height:30px;line-height:30px;">Coordinates: </div><div style="width:auto;float:left;margin-left:5px;"><input type="text" value="<?php print($this_value);?>" id="update_category_option_<?php print($category_id.'_'.$this_option_id);?>_value" style="width:400px;height:25px;" onfocus="if(this.value=='Enter response here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter response here';this.style.color='#aaa';}"></div></div>
				</div>
				<?php
				
				
			}
			?>
			<input type="hidden" id="update_category_option_<?php print($category_id.'_'.$this_option_id);?>_type" value="<?php print($form_update_category_option_results['option_type']);?>">
			
			<input type="hidden" value="<?php print($form_update_category_option_results['schedule_message']);?>" id="update_category_option_schedule_message_<?php print($category_id.'_'.$this_option_id);?>">
			
			<input type="hidden" value="<?php print($form_update_category_option_results['days_before_due_date']);?>" id="update_category_option_schedule_days_<?php print($category_id.'_'.$this_option_id);?>">
			
			
			<?php
		}
		
		?>
		<input type="hidden" id="update_cagetory_option_id_string_<?php print($category_id);?>" value="<?php print($update_category_option_id_string);?>">
			
		<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:5px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_form_category" onclick="update_form_category(<?php print($category_id.','.$data_set_id);?>);" title="Click to update details">Update</div>
</div>