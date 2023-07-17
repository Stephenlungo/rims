<?php

if($client_id){
	$this_client = mysqli_query($connect,"select * from sms_clients where id = $client_id")or die(mysqli_error($connect));
	$this_client_results = mysqli_fetch_array($this_client,MYSQLI_ASSOC);
	
	$sms_client_name = $this_client_results['_name'];
	$sms_client_phone = $this_client_results['phone_number'];
	$sms_client_email = $this_client_results['email'];
	$sms_client_details = $this_client_results['details'];
	
	$this_group_id = $this_client_results['group_id'];
	if(!$this_group_id){
		$this_group_title = '<i>Unspecified</i>';
		
	}else{		
		$this_group = mysqli_query($connect,"select * from sms_groups where id = $this_group_id")or die(mysqli_error($connect));
		$this_group_results = mysqli_fetch_array($this_group,MYSQLI_ASSOC);
		
		$this_group_title = $this_group_results['title'];

	}
	
	$button_text = 'Update';
	
	$this_client_status = $this_client_results['status'];
	
	$font_color = '#000';
	
}else{
	$sms_client_name = 'Enter name here';
	$sms_client_phone = '260';
	$sms_client_email = 'Enter email here';
	$sms_client_details = 'Enter details here';

	$this_group_id = 0;
	$this_group_title = '<i>Unspecified</i>';
	
	$button_text = 'Save';
	
	$this_client_status = 0;
	
	$font_color = '#aaa';
}

if($this_client_status == 1){
	$client_status_title = 'Disable';
	
}else{
	$client_status_title = 'Enable';	
}
?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Name:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($font_color);?>" value="<?php print($sms_client_name);?>"  id="client_name" onfocusout="if(this.value==''){this.value='Enter name here';this.style.color='#aaa';}" onfocus="if(this.value=='Enter name here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Phone:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#000" value="<?php print($sms_client_phone);?>"  id="client_phone" onfocusout="if(this.value==''){this.value='260';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:130px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:240px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:<?php print($font_color);?>" value="<?php print($sms_client_email);?>"  id="client_email" onfocusout="if(this.value==''){this.value='Enter email here';this.style.color='#aaa';}" onfocus="if(this.value=='Enter email here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');"></div>
</div>


<div style="width:auto;height:auto;float:left;" id="cluster_0_holder">
	<div style="width:130px;height:30px;line-height:30px;float:left;">Group:</div>
	<div style="width:auto;min-height:30px;height:auto;float:left;">
	<div class="option_item" title="Click to change option" onclick="$('#client_group_menu').toggle('fast');" id="active_client_group" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_group_title);?></div>

	<div class="option_menu" id="client_group_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_group_menu').toggle('fast');$('#active_client_group').html($(this).html());$('#selected_client_group').val(0);"><i>Unspecified</i></div>
		<?php
		
			$client_group_menu = mysqli_query($connect,"select * from sms_groups where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));

			for($g=0;$g<mysqli_num_rows($client_group_menu);$g++){
				$client_group_menu_results = mysqli_fetch_array($client_group_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#client_group_menu').toggle('fast');$('#active_client_group').html($(this).html());$('#selected_client_group').val(<?php print($client_group_menu_results['id']);?>);"><?php print($client_group_menu_results['title']);?></div>
				<?php
			}
		?>
	</div>
	</div>
	<input type="hidden" id="selected_client_group" value="<?php print($this_group_id);?>">
</div>

	<div style="width:100%;height:auto;float:left;">
		<div style="width:130px;height:30px;line-height:30px;float:left;">Details:</div>
		<div style="width:240px;height:60px;float:left;"><textarea style="font-family:arial;font-size:0.9em;min-width:100%;max-width:100%;border:solid 1px #aaa;min-height:100%;max-height:100%;color:<?php print($font_color);?>" onfocusout="if(this.value==''){this.value='Enter details here';this.style.color='#aaa';}" onfocus="if(this.value=='Enter details here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#error_message').slideUp('fast');" id="client_description"><?php print($sms_client_details);?></textarea></div>
	</div>

	<div style="width:100%;height:auto;float:left;margin-bottom:2px;color:red;display:none;margin-top:5px;font-weight:bold;" id="error_message"></div>

	<div style="width:100%;height:auto;float:left;margin-top:30px;">
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_update_button" title="Click to save client" onclick="update_sms_client(<?php print($client_id);?>);"><?php print($button_text);?></div>
		
		<?php
		if($client_id and $active_user_roles[8]){
			if($this_client_status){
				
				$hover_out_color = 'brown';
				$hover_color = 'red';
				
			}else{
				$hover_out_color = '#5c5';
				$hover_color = '#7e7';
			}
			?>
			<div style="width:60px;height:30px;background-color:<?php print($hover_out_color);?>;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($hover_out_color);?>';"  id="disable_client_button" onclick="change_sms_client_status(<?php print($client_id.','.$this_client_status);?>);" title="Click to change status of client"><?php print($client_status_title);?></div>
			<?php
		}
		?>
	</div>