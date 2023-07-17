<?php
include 'item_details_1.php';

$form_values = fetch_db_table('connect','dynamic_form_values',1,'id','dynamic_form_id  = '.$form_id.' and client_id = '.$client_id.' and (dynamic_form_category_option_id = 341 || dynamic_form_category_option_id = 347 || dynamic_form_category_option_id = 340 || dynamic_form_category_option_id = 348 or dynamic_form_category_option_id = 492 or dynamic_form_category_option_id = 508 or dynamic_form_category_option_id = 524 or dynamic_form_category_option_id = 540 or dynamic_form_category_option_id = 556 or dynamic_form_category_option_id = 572 or dynamic_form_category_option_id = 588 or dynamic_form_category_option_id = 604 or dynamic_form_category_option_id = 620 or dynamic_form_category_option_id = 636 or dynamic_form_category_option_id = 652 or dynamic_form_category_option_id = 668 or dynamic_form_category_option_id = 684 or dynamic_form_category_option_id = 700)');

$data_sets = fetch_db_table('connect','dynamic_form_data_sets',1,'id','dynamic_form_id  = '.$form_id.' and client_id = '.$client_id);

$asset_array = array();
$form_dates = array();
for($d=0;$d<count($data_sets['id']);$d++){
	$form_dates[count($form_dates)] = $form_values['_value'][$d];
	$asset_array[$form_values['_value'][$d]] = array($data_sets['id'][$d],$data_sets['_date'][$d],$data_sets['user_id'][$d],$data_sets['entry_method'][$d]);
	
}

rsort($form_dates);
?>


<div style="width:100%;height:30px;line-height:30px;float:left;font-size:1.3em;margin-top:5px;"><div style="width:auto;heigth:auto;float:left;"><?php print($this_form_results['form_title']);?> forms for this client</div>

<?php
if(!count($data_sets['id']) || $this_form_results['data_processing_method'] == 1){
	?>

<div style="width:102px;height:25px;margin-top:2px;background-color:#006bb3;color:#fff;text-align:center;line-height:25px;float:right;margin-right:5px;cursor:pointer;font-size:0.7em;" onmouseover="this.style.backgroundColor='#2084c7';" onmouseout="this.style.backgroundColor='#006bb3';" title="Click to create new form" onclick="fetch_dynamic_form_details(<?php print($form_id);?>,0)">Fill in new form</div>
<?php
}
?>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:100px;height:20px;float:left;margin-right:3px;">Date entered</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Time entered</div>
<div style="width:190px;height:20px;float:left;margin-right:3px;">Date of investigation in form</div>

<div style="width:200px;height:20px;float:left;margin-right:3px;">Entered by</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Phone number</div>
<div style="width:180px;height:20px;float:left;margin-right:3px;">Entry method</div>
</div>

<?php
if(!count($data_sets['id'])){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;font-weight:bold;text-align:center;">No records were found</div>
	<?php
}else{
	for($ds=0;$ds<count($form_dates);$ds++){
		$this_entry = $asset_array[$form_dates[$ds]];
		
		$set_user_id = $this_entry[2];
		
		if($this_entry[3] == 2){
			$user_table = 'agents';
			
		}else{
			$user_table = 'users';
			
		}
		
		$set_user = mysqlI_query($connect,"select * from $user_table where id = $set_user_id")or die(mysqli_error($connect));
		$set_user_results = mysqli_fetch_array($set_user,MYSQLI_ASSOC);

		if($this_entry[3] == 1){
			$background_color = '#fee';
			
		}else{
			$background_color = '';
			
		}
		
		$entry_method_title = 'Unknown';
		if($this_entry[3] == 0){
			$entry_method_title = 'Live system';
			
		}else if($this_entry[3] == 1){
			$entry_method_title = 'Offline system';
			
		}else if($this_entry[3] == 2){
			$entry_method_title = 'USSD';
			
		}
		
		?>
			<div style="cursor:pointer;width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;background-color:<?php print($background_color);?>" onmouseover="this.style.backgroundColor='#eee'" onmouseout="this.style.backgroundColor='<?php print($background_color);?>'" title="Click to view this form" onclick="fetch_dynamic_form_details(<?php print($form_id.','.$this_entry[0]);?>)">
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$this_entry[1]));?></div>
				<div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print(date('H:i:s',$this_entry[1]));?></div>
				<div style="width:190px;height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$form_dates[$ds]));?></div>
				<div style="width:200px;height:20px;float:left;margin-right:3px;"><?php print($set_user_results['_name']);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($set_user_results['phone']);?></div>
				<div style="width:180px;height:20px;float:left;margin-right:3px;"><?php print($entry_method_title);?></div>
			</div>
		<?php
	}
}
?>
