<?php
	if($wifi_id){
		$this_wifi = mysqli_query($connect,"select * from wifis where id = $wifi_id")or die(mysqli_error($connect));
		$this_wifi_reuslts = mysqli_fetch_array($this_wifi,MYSQLI_ASSOC);
		
		$title = $this_wifi_reuslts['title'];
		$default_color = '#000';		
		$this_branch_id = $this_wifi_reuslts['branch_id'];
		
		$starting_ip = $this_wifi_reuslts['starting_ip'];
		$ending_ip = $this_wifi_reuslts['ending_ip'];
		$confirmation_message = $this_wifi_reuslts['confirmation_message'];
		$redirect_url = $this_wifi_reuslts['redirect_url'];
		$login_script = $this_wifi_reuslts['login_script'];
		$login_delay = $this_wifi_reuslts['login_delay'];
		$white_list = $this_wifi_reuslts['white_list'];
		$button_text = 'Update';
		
		$allow_re_login = $this_wifi_reuslts['relogin'];
		
		$allow_re_login_title = 'Don\'t allow';
		if($allow_re_login){
			$allow_re_login_title = 'Allow';
		}
		
	}else{
		$title = 'Enter title here';		
		$default_color = '#aaa';
		$this_branch_id = $user_results['branch_id'];
		
		$white_list = 'Enter IP addresses';
		$starting_ip = 'Enter IP here';
		$ending_ip = 'Enter IP here';
		$confirmation_message = 'Enter message here';
		$redirect_url = 'Enter URL here';
		$login_script = 'Enter login script';
		$login_delay = 'Enter login delay';
		$button_text = 'Save';
		
		$allow_re_login_title = 'Allow';
		$allow_re_login = 1;
	}

	if(!$this_branch_id){
		$this_branch_title = 'Non-clustered';
		$this_branch_id = 0;
		
	}else{
		$user_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($user_branch,MYSQLI_ASSOC);
		$this_branch_title = $this_branch_results['title'];
	}

?>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">WI-FI title:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($title);?>"  id="wifi_title" onfocusout="if(this.value==''){this.value='<?php print($title);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter title here'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Cluster:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?>$('#wifi_branch_menu').toggle('fast');<?php }else{?> alert('You are not authorized to modify this option');<?php }?>" id="active_wifi_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>

			<div class="option_menu" id="wifi_branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_branch_menu').toggle('fast');$('#active_wifi_branch').html($(this).html());$('#selected_wifi_branch').val(0);$('#new_wifi_error_message').slideUp('fast');">Non-clustered</div>
			
			
				<?php
				
					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));
					for($u=0;$u<mysqli_num_rows($branch_menu);$u++){
						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_branch_menu').toggle('fast');$('#active_wifi_branch').html($(this).html());$('#selected_wifi_branch').val(<?php print($branch_menu_results['id']);?>);$('#new_wifi_error_message').slideUp('fast');"><?php print($branch_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
	</div>
	<input type="hidden" id="selected_wifi_branch" value="<?php print($this_branch_id);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Starting IP:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($starting_ip);?>"  id="starting_ip" onfocusout="if(this.value==''){this.value='<?php print($starting_ip);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter IP here'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Ending IP:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($ending_ip);?>"  id="ending_ip" onfocusout="if(this.value==''){this.value='<?php print($ending_ip);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter IP here'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Confirmation Message:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($confirmation_message);?>"  id="confirmation_message" onfocusout="if(this.value==''){this.value='<?php print($confirmation_message);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter message here'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Redirect URL:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($redirect_url);?>"  id="redirect_url" onfocusout="if(this.value==''){this.value='<?php print($redirect_url);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter URL here'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Router Login Script:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($login_script);?>"  id="login_script" onfocusout="if(this.value==''){this.value='<?php print($login_script);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter login script'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Router Login delay (Sec):</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;border:solid 1px #aaa;height:30px;color:<?php print($default_color);?>" value="<?php print($login_delay);?>"  id="login_delay" onfocusout="if(this.value==''){this.value='<?php print($login_delay);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter login delay'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">Allow  user re-login :</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">

	<div style="width:auto;min-height:30px;height:auto;float:left;">
		<div class="option_item" title="Click to change option" onclick="$('#wifi_relogin_menu').toggle('fast');" id="active_wifi_relogin" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($allow_re_login_title);?></div>

			<div class="option_menu" id="wifi_relogin_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_relogin_menu').toggle('fast');$('#active_wifi_relogin').html($(this).html());$('#selected_wifi_relogin').val(0);">Don't allow</div>
			
			
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#wifi_relogin_menu').toggle('fast');$('#active_wifi_relogin').html($(this).html());$('#selected_wifi_relogin').val(1);">Allow</div>
					
			</div>
	</div>
	<input type="hidden" id="selected_wifi_relogin" value="<?php print($allow_re_login);?>">
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:150px;height:30px;line-height:30px;float:left;">White-list:</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><textarea style="min-width:100%;max-width:100%;min-height:50px;max-height:50px;font-family:arial;border:solid 1px #aaa;font-size:0.9em;color:<?php print($default_color);?>" onfocusout="if(this.value==''){this.value='<?php print($white_list);?>';this.style.color='<?php print($default_color);?>'}" onfocus="if(this.value=='Enter IP addresses'){this.value='';this.style.color='#000';}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" id="white_list"><?php print($white_list);?></textarea></div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;" id="wifi_update_holder">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="update_or_create_wifi_button" onclick="update_or_create_wifi(<?php print($wifi_id);?>);" title="Click to update wifi details"><?php print($button_text);?></div>

</div>
