	<div style="width:100%;height:30px;line-height:30px;float:left;background-color:#ede1ef;text-align:center;font-size:1.2em;margin-top:5px;"><?php print($dynamic_form_resuls['form_title']);?> Form</div><?php
	
	
	if($dynamic_form_resuls['description'] != ''){
	?>
	<div style="width:100%;min-height:40px;height:auto;float:left;margin-bottom:5px;border-bottom:solid 1px #eee;"><?php print($dynamic_form_resuls['description']);?></div>
	
	<?php	
	}
	
	?>
	<input type="hidden" id="form_dependencies_<?php print($form_id);?>" value="<?php print($dynamic_form_resuls['dependencies']);?>">
	<input type="hidden" id="form_data_processing_method_<?php print($form_id);?>" value="<?php print($dynamic_form_resuls['data_processing_method']);?>">
	
	<div style="width:100%;height:auto;float:left;<?php if(!$client_id){print('display:none');}?>" id="historic_form_data_<?php print($form_id);?>">
	
	<?php
	$form_data_sets = mysqli_query($connect,"select * from dynamic_form_data_sets where dynamic_form_id = $form_id and client_id = $client_id order by _date desc")or die(mysqli_error($connect));
	
	if(mysqli_num_rows($form_data_sets) and $dynamic_form_resuls['data_processing_method'] == 0){
		$new_option_title = 'Replace';
		
	}else{
		$new_option_title = 'New';
	}
	?>
	
	<div style="width:100%;height:25px;float:left;margin-top:2px;"><div style="width:50px;height:20px;float:left;background-color:orange;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#ffc863';" onmouseout="this.style.backgroundColor='orange'" onclick="$('#historic_form_data_<?php print($form_id);?>').hide();$('#form_data_entry_<?php print($form_id);?>').slideDown('fast');"><?php print($new_option_title);?></div></div>
	
	<?php	
	for($fd=0;$fd<mysqli_num_rows($form_data_sets);$fd++){
		$data_set_results = mysqli_fetch_array($form_data_sets,MYSQLI_ASSOC);
		$data_set_id = $data_set_results['id'];
		
		if($data_set_results['user_id'] == ''){
			$this_user_name = 'Self assessed';
			
		}else{
			$data_user_id = $data_set_results['user_id'];
			$this_user = mysqli_query($connect,"select * from users where id = '$data_user_id' and company_id = $company_id")or die(mysqli_error($connect));
			$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
			
			$this_user_name = $this_user_results['_name'];
		}
		
		?>
		<div style="width:99.2%;height:25px;line-height:25px;float:left;padding-left:5px;cursor:pointer;margin-top:2px;background-color:#fde7fe" onmouseover="this.style.backgroundColor='#fef0fe';" onmouseout="this.style.backgroundColor='#fde7fe'" onclick="$('#historic_data_holder_<?php print($data_set_results['id']);?>').slideToggle('fast');" id="histori_data_title_<?php print($data_set_results['id']);?>">Submitted on <?php print(date('jS M, Y',$data_set_results['_date']).' - '.date('H:i:s',$data_set_results['_date']).'. User: '.$this_user_name);?></div>
		
		<script>
		$('#dynamic_form_validated_<?php print($form_id);?>').val(1);
		</script>
		
		<div style="width:100%;height:auto;float:left;background-color:#fffaff;display:none;" id="historic_data_holder_<?php print($data_set_results['id']);?>">
		
		<div style="width:100%;float:left;margin-right:5px;height:20px;line-height:20px;">
		<?php
		if($active_user_roles[7] || $data_set_results['user_id'] == $user_results['id']){?>
		
			<div style="width:70px;height:20px;float:right;background-color:brown;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#c14545';" onmouseout="this.style.backgroundColor='brown';" onclick="delete_prep_form_data_set(<?php print($data_set_id.','.$client_id);?>);" id="prep_form_data_set_delete_button_<?php print($data_set_id);?>">Delete</div>
		
			<div style="width:80px;margin-right:5px;height:20px;float:right;background-color:#006bb3;line-height:20px;text-align:center;color:#fff;margin-top:2px;cursor:pointer" onmouseover="this.style.backgroundColor='#339eb3';" onmouseout="this.style.backgroundColor='#006bb3';" onclick="export_prep_form_data_set(<?php print($data_set_id.','.$client_id);?>);" id="prep_form_data_set_export_button_<?php print($data_set_id);?>">Export PDF</div>
			
			
		
			<?php
		}
		?>
		</div>
		
		<?php
			$form_categories = mysqli_query($connect,"select * from dynamic_form_categories where dynamic_form_id = $form_id and status = 1 order by _order")or die(mysqli_error($connect));
			
			for($ca=0;$ca<mysqli_num_rows($form_categories);$ca++){
				$form_category_results = mysqli_fetch_array($form_categories,MYSQLI_ASSOC);
				$this_category_id = $form_category_results['id'];
				
				?>
				<div style="width:100%;height:30px;line-height:30px;font-size:1.2em;color:#536a01;float:left;border-bottom:solid 1px #eef"><div style="width:auto;height:30px;float:left;"><?php print($form_category_results['title']);?></div><?php if($active_user_roles[6] || $data_set_results['user_id'] == $user_results['id']){?><div style="font-size:0.8em;width:30px;float:left;text-align:center;line-height:25px;margin-top:2px;color:#fff;margin-left:5px;background-color:green;cursor:pointer;" onmouseover="this.style.backgroundColor='#129612';" onmouseout="this.style.backgroundColor='green';" title="Click to edit category values" onclick="fetch_prep_category_details(<?php print($this_category_id.','.$data_set_id);?>)">Edit</div><?php } ?></div>
				
				<div style="width:100%;height:auto;float:left;" id="category_data_<?php print($this_category_id);?>">
				
				<?php
				
				
				$form_category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $this_category_id and dynamic_form_id = $form_id and status = 1 order by _order")or die(mysqli_error($connect));
						
				for($o=0;$o<mysqli_num_rows($form_category_options);$o++){
					$form_category_option_results = mysqli_fetch_array($form_category_options,MYSQLI_ASSOC);
					$this_option_id = $form_category_option_results['id'];

					$option_value_check = mysqli_query($connect,"select * from dynamic_form_values where dynamic_form_id = $form_id and dynamic_form_category_id = $this_category_id and dynamic_form_category_option_id = $this_option_id and dynamic_form_data_set_id = $data_set_id")or die(mysqli_error($connect));
					
					$option_value = '';
					if(mysqli_num_rows($option_value_check)){
						$option_value_check = mysqli_fetch_array($option_value_check,MYSQLI_ASSOC);
						$option_value = $option_value_check['_value'];
						
					}
					
				
					if($form_category_option_results['option_type'] == 0 || $form_category_option_results['option_type'] == 1){						
						?>
						<div style="width:100%;min-height:20px;height:auto;float:left;line-height:20px;">
						
							<div style="width:20px;float:left;height:20px;">
							<?php
							if($option_value != ''){
								print('&#10003');
							}
							?>
							</div>
							<div style="width:auto;float:left;min-height:20px;height:auto;float:left"><?php print($form_category_option_results['category_title']);?></div>
						</div>
						
						<?php
					
					}else if($form_category_option_results['option_type'] == 2 || $form_category_option_results['option_type'] == 3 || $form_category_option_results['option_type'] == 4){
						?>
						<div style="100%;height:auto;float:left;margin-bottom:2px;">
						<div style="width:140px;margin-left:20px;min-height:20px;height:auto;float:left;line-height:20px;">
							<?php print($form_category_option_results['category_title']);?>:
						</div>
						
						<div style="width:200px;float:left;height:20px;line-height:20px;margin-left:5px;margin-right:5px;">
						<?php
						if($form_category_option_results['option_type'] == 2){
							if($option_value == ''){
								print('<i style="color:#aaa;">Not provided or not applicable</i>');
								
							}else{
								print($option_value);
								
							}
							
						}else{
							if($option_value == 0 || $option_value == ''){
								print('<i style="color:#aaa;">N/A</i>');
								
							}else{
								print(date('jS M, Y',$option_value));
							}
						}
						?>
						</div>
						</div>
						<?php
						
					}else if($form_category_option_results['option_type'] == 5){
						?>
						<div style="100%;height:auto;float:left;margin-bottom:2px;">
						<div style="width:140px;margin-left:20px;min-height:20px;height:auto;float:left;line-height:20px;">
							<?php print($form_category_option_results['category_title']);?>:
						</div>
						
						<div style="width:200px;float:left;height:20px;line-height:20px;margin-left:5px;margin-right:5px;">
						<?php
						if($form_category_option_results['option_type'] == 2){
							if($option_value == ''){
								print('<i style="color:#aaa;">Not provided or not applicable</i>');
								
							}else{
								print($option_value);
								
							}
							
						}else{
							if($option_value != ''){
								print($option_value);
								
							}
						}
						?>
						</div>
						</div>
						<?php
					}
				}
				?>
				
				</div>
				<?php
			}	
			?>
		
		
		</div>
		<?php
	}
	?>
	

	</div>
	
	
	<div style="width:100%;height:auto;float:left;<?php if($client_id){print('display:none');}?>" id="form_data_entry_<?php print($form_id);?>">
	
	<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:5px;" id="form_update_holder_<?php print($form_id);?>">
		<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa';"  id="client_form_button_<?php print($form_id);?>" onclick="$('#historic_form_data_<?php print($form_id);?>').slideDown('fast');$('#form_data_entry_<?php print($form_id);?>').hide();" title="Click to close entry form">Cancel</div>
		
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_form_button_<?php print($form_id);?>" onclick="create_or_update_client_form(<?php print($form_id.','.$form_ind);?>);" title="Click to update account details">Save</div>
	</div>
	
	<?php
	
$form_categories = mysqli_query($connect,"select * from dynamic_form_categories where dynamic_form_id = $form_id and status = 1 order by _order")or die(mysqli_error($connect));

if(!$dynamic_form_resuls['form_display_type']){
	
	$category_id_string = '';
	for($c=0;$c<mysqli_num_rows($form_categories);$c++){
		$form_category_results = mysqli_fetch_array($form_categories,MYSQLI_ASSOC);
		$this_category_id = $form_category_results['id'];
		
		if($category_id_string == ''){
			$category_id_string = $this_category_id;
			
		}else{
			$category_id_string .= ','.$this_category_id;
			
		}
		
		if($form_category_results['necessity']){
			$this_category_title = $form_category_results['title'].'*';

		}else {
			$this_category_title = $form_category_results['title'];

		}		
		
		?>
		<div style="width:100%;height:auto;float:left;margin-bottom:15px;">
		<div style="width:100%;height:30px;line-height:30px;font-size:1.2em;color:#536a01;float:left;border-bottom:solid 1px #eef" id="category_title_<?php print($this_category_id);?>"><?php print($this_category_title);?></div><input type="hidden" id="category_option_<?php print($this_category_id);?>_required" value="<?php print($form_category_results['necessity']);?>">
		
		<?php
		
		if($form_category_results['header_text'] != ''){
			?>
			<div style="width:100%;min-height:20px;line-height:20px;height:auto;float:left;background-color:#eee;font-weight:bold;margin-bottom:5px;"><?php print($form_category_results['header_text']);?></div>
			
			<?php
			
		}
		
		$form_category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $this_category_id and dynamic_form_id = $form_id and status = 1 order by _order")or die(mysqli_error($connect));
				
		$category_option_id_string = '';
		$default_option_id = '';
		for($o=0;$o<mysqli_num_rows($form_category_options);$o++){
			$form_category_option_results = mysqli_fetch_array($form_category_options,MYSQLI_ASSOC);
			$this_option_id = $form_category_option_results['id'];
			
			if($category_option_id_string == ''){
				$category_option_id_string = $form_category_option_results['id'];
				
			}else{
				$category_option_id_string .= ','.$form_category_option_results['id'];
				
			}
		
			if($form_category_option_results['option_type'] == 0 || $form_category_option_results['option_type'] == 1){
				if($form_category_option_results['default_option']){
					$checked_status = ' checked ';
					$option_value = 1;
					$default_option_id = $this_option_id;
	
				}else{
					$checked_status = '';
					$option_value = '';
					
				}
				?>
				<div style="width:100%;min-height:20px;height:auto;float:left;line-height:20px;">
				<input type="hidden" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" value="<?php print($option_value);?>">
				
				
				
					<div style="width:20px;float:left;height:20px;">
						<?php
						if($form_category_option_results['option_type'] == 0){
							?>
							<input <?php print($checked_status);?> type="radio" name="category_options_<?php print($this_category_id);?>" id="category_options_<?php print($this_category_id.'_'.$this_option_id);?>" onclick="if($('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val() != 1){$('#category_option_<?php print($this_category_id);?>_'+$('#active_category_option_<?php print($this_category_id);?>').val()+'_value').val('');$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(1);$('#active_category_option_<?php print($this_category_id);?>').val(<?php print($this_option_id);?>);}else{$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val('');$('#active_category_option_<?php print($this_category_id);?>').val('');this.checked = false;}">
						<?php
						}else{
						?>
							<input <?php print($checked_status);?> type="checkbox" id="category_options_<?php print($this_category_id.'_'.$this_option_id);?>" onchange="if(this.checked){$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(1);}else{$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val('');}">
							
						<?php
						}
						?>
					</div>
					<div style="width:auto;float:left;min-height:20px;height:auto;float:left"><label for="category_options_<?php print($this_category_id.'_'.$this_option_id);?>"><?php print($form_category_option_results['category_title']);?></label></div>
				</div>
				
				<?php
			
			}else if($form_category_option_results['option_type'] == 2 || $form_category_option_results['option_type'] == 3 || $form_category_option_results['option_type'] == 4){
				
				if($form_category_option_results['option_type'] != 2){
					$border_shade = 'border-bottom:solid 1px #a2cdea';
					$font_thickness = 'font-weight:bold';
					
				}else{
					$border_shade = '';
					$font_thickness = '';
				}
				?>
				<div style="100%;height:auto;float:left;margin-bottom:2px;<?php print($border_shade);?>">
				<div style="width:auto;margin-left:20px;min-height:30px;height:auto;float:left;line-height:30px;<?php print($font_thickness);?>">
					<?php print($form_category_option_results['category_title']);?>:
				</div>
				
				<div style="width:auto;float:left;height:30px;line-height:30px;margin-left:5px;margin-right:5px;">
				<?php
				if($form_category_option_results['option_type'] == 2){
					?>
					<input type="text" value="Enter response here" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" style="width:100%;height:25px;color:#aaa;" onfocus="if(this.value=='Enter response here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter response here';this.style.color='#aaa';}">
					<?php
					
				}else{
					?>
					
					<div style="width:auto;height:20px;float:left;" >
					<div style="width:auto;float:left;height:auto;" id="option_day_options_<?php print($this_category_id.'_'.$this_option_id);?>">
						<div style="line-height:30px;width:30px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3"><i>Day:</i></div>
							<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#form_field_day_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');" id="form_field_active_day_<?php print($this_category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;">Select date</div>


			<div class="option_menu" id="form_field_day_menu_<?php print($this_category_id.'_'.$this_option_id);?>" style="display:none;width:80px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_field_day_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');$('#option_month_options_<?php print($this_category_id.'_'.$this_option_id);?>').slideUp('fast');$('#option_year_options_<?php print($this_category_id.'_'.$this_option_id);?>').slideUp('fast');$('#form_field_active_day_<?php print($this_category_id.'_'.$this_option_id);?>').html($(this).html());$('#form_field_day_value_<?php print($this_category_id.'_'.$this_option_id);?>').val(0);" style="width:80px;">N/A</div>
			
			<?php
			for($d1=1;$d1<32;$d1++){
				if($d1<10){
					$do='0'.$d1;
				}else{
					$do = $d1;
				}
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_field_day_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');$('#option_month_options_<?php print($this_category_id.'_'.$this_option_id);?>').slideDown('fast');$('#option_year_options_<?php print($this_category_id.'_'.$this_option_id);?>').slideDown('fast');$('#form_field_active_day_<?php print($this_category_id.'_'.$this_option_id);?>').html($(this).html());$('#form_field_day_value_<?php print($this_category_id.'_'.$this_option_id);?>').val(<?php print($d1);?>);" style="width:40px;"><?php print($do);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" id="form_field_day_value_<?php print($this_category_id.'_'.$this_option_id);?>" value="0">
			</div>
			</div>
			
			<div style="width:auto;float:left;height:auto;display:none;" id="option_month_options_<?php print($this_category_id.'_'.$this_option_id);?>">
			<div style="line-height:30px;width:40px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3">Month:</div>
			<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#form_field_month_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');" id="form_field_active_month_<?php print($this_category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print(date('m',time()));?></div>


			<div class="option_menu" id="form_field_month_menu_<?php print($this_category_id.'_'.$this_option_id);?>" style="display:none;">
			<?php
			for($m=1;$m<13;$m++){
				
				if($m<10){
					$mo='0'.$m;
				}else{
					$mo = $m;
				}
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_field_month_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');$('#form_field_active_month_<?php print($this_category_id.'_'.$this_option_id);?>').html($(this).html());$('#form_field_month_value_<?php print($this_category_id.'_'.$this_option_id);?>').val(<?php print($m);?>);" style="width:40px;"><?php print($mo);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" name="form_field_month_value_<?php print($this_category_id.'_'.$this_option_id);?>" id="form_field_month_value_<?php print($this_category_id.'_'.$this_option_id);?>" value="<?php print(date('m',time()));?>">
			</div>
			</div>
			
			<div style="width:auto;float:left;height:auto;display:none" id="option_year_options_<?php print($this_category_id.'_'.$this_option_id);?>">
			<div style="line-height:30px;width:20px;height:30px;float:left;font-size:0.9em;text-align:right;margin-right:2px;color:#006bb3">Yr:</div>
			<div style="width:auto;min-height:20px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="$('#form_field_year_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');" id="form_field_active_year_<?php print($this_category_id.'_'.$this_option_id);?>" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="text-align:center;"><?php print(date('Y',time()));?></div>


			<div class="option_menu" id="form_field_year_menu_<?php print($this_category_id.'_'.$this_option_id);?>" style="display:none;">
			<?php
			for($y=(date('Y',time()) + 5);$y>(date('Y',time()) - 100);$y--){
				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#form_field_year_menu_<?php print($this_category_id.'_'.$this_option_id);?>').toggle('fast');$('#form_field_active_year_<?php print($this_category_id.'_'.$this_option_id);?>').html($(this).html());$('#form_field_year_value_<?php print($this_category_id.'_'.$this_option_id);?>').val(<?php print($y);?>);" style="width:75px;"><?php print($y);?></div>
			<?php
			}
			?>
			</div>
			<input type="hidden" name="form_field_year_value_<?php print($this_category_id.'_'.$this_option_id);?>" id="form_field_year_value_<?php print($this_category_id.'_'.$this_option_id);?>" value="<?php print(date('Y',time()));?>">
			</div>

			</div>
			</div>
					
					
					<?php
				}
				?>
				</div>
				</div>
				<?php
				
			}else if($form_category_option_results['option_type'] == 5){
				?>
				<div style="100%;height:auto;float:left;margin-bottom:2px;margin-top:30px;">
				<div style="width:100%;margin-left:20px;min-height:20px;height:auto;float:left;line-height:20px;font-weight:bold;">
					<?php print($form_category_option_results['category_title']);?>
				</div>
				
				<div style="width:700px;height:300px;float:left;background-color:red;" id="map_<?php print($this_option_id);?>">
					<?php
					include 'map_script.php';
					?>
				</div>
				
				<div style="width:100%;float:left;height:30px;line-height:30px;margin-top:5px;">
				<div style="width:auto;float:left;height:30px;line-height:30px;">Coordinates: </div><div style="width:auto;float:left;margin-left:5px;"><input type="text" value="Enter response here" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" style="width:400px;height:25px;" onfocus="if(this.value=='Enter response here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter response here';this.style.color='#aaa';}"></div></div>
				</div>
				<?php
				
				
			}
			?>
			<input type="hidden" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_type" value="<?php print($form_category_option_results['option_type']);?>">
			
			<input type="hidden" value="<?php print($form_category_option_results['schedule_message']);?>" id="category_option_schedule_message_<?php print($this_category_id.'_'.$this_option_id);?>">
			
			<input type="hidden" value="<?php print($form_category_option_results['days_before_due_date']);?>" id="category_option_schedule_days_<?php print($this_category_id.'_'.$this_option_id);?>">
			
			<?php
		}
		
		
		
		if($form_category_results['footer_text'] != ''){
			?>
			<div style="width:100%;min-height:20px;line-height:20px;height:auto;float:left;font-size:0.9em;border-bottom:solid 1px #eee;"><?php print($form_category_results['footer_text']);?></div>
			
			<?php
			
		}
		
		?>
		<input type="hidden" id="active_category_option_<?php print($this_category_id);?>" value="<?php print($default_option_id);?>">
		</div>

		<input type="hidden" id="cagetory_option_id_string_<?php print($this_category_id);?>" value="<?php print($category_option_id_string);?>">
		
			<?php
		
		
	}
	?>
	<input type="hidden" id="category_id_string_<?php print($form_id);?>" value="<?php print($category_id_string);?>">

	<?php
}else{
if(mysqli_num_rows($form_categories) > 1){
$block_categories = mysqli_num_rows($form_categories)/2;

}else{
	$block_categories = mysqli_num_rows($form_categories);
	
}


$category_id_string = '';
for($b=0;$b<2;$b++){
	?>
	<div style="width:49%;margin-right:5px;float:left;height:auto;">
	
	<?php
	
	$starting_category_ind = $b*$block_categories;
	
	for($c=0;$c<$block_categories;$c++){
		$form_category_results = mysqli_fetch_array($form_categories,MYSQLI_ASSOC);
		if($form_category_results['id'] != ''){
			$this_category_id = $form_category_results['id'];
			
			if($category_id_string == ''){
				$category_id_string = $this_category_id;
				
			}else{
				$category_id_string .= ','.$this_category_id;
				
			}
			
			if($form_category_results['necessity']){
				$category_title = $form_category_results['title'].'*';
				
			}else{
				$category_title = $form_category_results['title'];
				
			}
			
			?>
			<div style="width:370px;margin:2px;height:auto;float:left;padding:5px;border:solid 1px #ddd;">
			<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;background-color:#666;color:#fff;" id="category_title_<?php print($this_category_id);?>"><?php print($category_title);?></div><input type="hidden" id="active_category_option_<?php print($this_category_id);?>" value=""><input type="hidden" id="category_option_<?php print($this_category_id);?>_required" value="<?php print($form_category_results['necessity']);?>">
			
			<?php
			if($form_category_results['header_text'] != ''){
				?>
				<div style="width:100%;min-height:30px;height:auto;float:left;font-size:0.85em;font-weight:bold;"><?php print($form_category_results['header_text']);?></div>
				<?php
			}
			
			$form_category_options = mysqli_query($connect,"select * from dynamic_form_category_options where dynamic_form_category_id = $this_category_id and dynamic_form_id = $form_id and status = 1")or die(mysqli_error($connect));
				
			$category_option_id_string = '';
			for($o=0;$o<mysqli_num_rows($form_category_options);$o++){
				$form_category_option_results = mysqli_fetch_array($form_category_options,MYSQLI_ASSOC);
				$this_option_id = $form_category_option_results['id'];
				
				if($category_option_id_string == ''){
					$category_option_id_string = $form_category_option_results['id'];
					
				}else{
					$category_option_id_string .= ','.$form_category_option_results['id'];
					
				}
			
				if($form_category_option_results['option_type'] == 0 || $form_category_option_results['option_type'] == 1){
					if($form_category_option_results['default_option']){
						$checked_status = ' checked ';
						$option_value = 1;
						
					}else{
						$checked_status = '';
						$option_value = '';
					}
					?>
					<div style="width:180px;min-height:20px;height:auto;float:left;line-height:20px;">
					<input type="hidden" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" value="<?php print($option_value);?>">
						<div style="width:20px;float:left;height:20px;">
						<?php
						if($form_category_option_results['option_type'] == 0){
							?>
							<input <?php print($checked_status);?> type="radio" name="category_options_<?php print($this_category_id);?>" id="category_options_<?php print($this_category_id.'_'.$this_option_id);?>" onclick="if($('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val() != 1){$('#category_option_<?php print($this_category_id);?>_'+$('#active_category_option_<?php print($this_category_id);?>').val()+'_value').val('');$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(1);$('#active_category_option_<?php print($this_category_id);?>').val(<?php print($this_option_id);?>);}else{$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val('');$('#active_category_option_<?php print($this_category_id);?>').val('');this.checked = false;}">
						<?php
						}else{
						?>
							<input <?php print($checked_status);?> type="checkbox" id="category_options_<?php print($this_category_id.'_'.$this_option_id);?>" onchange="if(this.checked){$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(1);}else{$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val('');}">
							
						<?php
						}
						?>
						</div>
						<div style="width:160px;float:left;min-height:20px;height:auto;float:left"><label for="category_options_<?php print($this_category_id.'_'.$this_option_id);?>"><?php print($form_category_option_results['category_title']);?></label></div>
					</div>
					
					<?php
				
				}else if($form_category_option_results['option_type'] == 2 || $form_category_option_results['option_type'] == 3 || $form_category_option_results['option_type'] == 4){
					?>
					
					<div style="width:100%;min-height:20px;height:auto;float:left;line-height:20px;">
						<?php print($form_category_option_results['category_title']);?>
					</div>
					
					<div style="width:100%;min-height:20px;height:25px;float:left;line-height:20px;margin-bottom:10px;">
					<?php
					if($form_category_option_results['option_type'] == 2){
						?>
						<input type="text" value="Enter response here" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" style="width:100%;height:25px;color:#aaa;" onfocus="if(this.value=='Enter response here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter response here';this.style.color='#aaa';}">
						<?php
						
					}else{
						?>
						<input type="text" value="<?php print(date('m/j/Y',time()));?>" id="category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value" style="width:100%;height:25px;">
						
						<script>
						$(function(){
							$( "#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value").datepicker();
						});
						</script>
						<?php
					}
					?>
					</div>
					
					<?php
					
				}
			}
			
			if($form_category_results['footer_text'] != ''){
				?>
				<div style="width:100%;min-height:30px;line-height:30px;height:auto;float:left;font-size:0.85em;"><i><?php print($form_category_results['footer_text']);?></i></div>
				<?php
			}
			
			?>
			<input type="hidden" id="cagetory_option_id_string_<?php print($this_category_id);?>" value="<?php print($category_option_id_string);?>">
			</div>
			<?php
		
		}
	}
	?>
	</div>
	<?php
}
?>
<input type="hidden" id="category_id_string_<?php print($form_id);?>" value="<?php print($category_id_string);?>">

<?php
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:5px;" id="form_update_holder_<?php print($form_id);?>">
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa';"  id="client_form_button_<?php print($form_id);?>" onclick="$('#historic_form_data_<?php print($form_id);?>').slideDown('fast');$('#form_data_entry_<?php print($form_id);?>').hide();" title="Click to close entry form">Cancel</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_form_button_<?php print($form_id);?>" onclick="create_or_update_client_form(<?php print($form_id.','.$form_ind);?>);" title="Click to update account details">Save</div>
</div>

</div>