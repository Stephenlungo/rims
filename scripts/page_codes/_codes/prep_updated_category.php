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