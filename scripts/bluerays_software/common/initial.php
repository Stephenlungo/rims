<div style="width:410px;height:auto;margin:0 auto;margin-top:40px;">
<div style="width:410px;min-height:480px;height:auto;margin:0 auto;margin-top:60px;background-color:#fff;text-align:center;">
	
		<div style="width:100%;height:100px;line-height:50px;border-bottom:solid 1px #eee;">
			<div style="width:70px;height:70px;margin: 0 auto;"><img src="<?php print($url);?>imgs/jsi_logo.png" style="height:70px;width:70px;"></div>
			<div style="width:100%;height:30px;line-height:30px;float:left;font-size:1.4em;">Welcome to RIMS 2.0</div>
			<div style="width:100%;height:20px;line-height:20px;float:left;color:#666;font-size:1.1em">"Easy | Fast | Reliable"</div>
		</div>
		
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;font-size:1em;margin-top:10px;color:#006bb3">We need to perform an initial installation of the system. Please follow the steps below</div>
		<div style="width:100%;height:auto;float:left;margin-top:10px;" id="configuration_steps">
			<div style="width:100%;height:auto;line-height:20px;float:left;margin-top:5px;text-align:left;">
				<div style="width:100%;height:30px;line-height:30px;float:left;">System access key:</div>

				<div style="width:100%;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value=""  id="access_key" placeholder="Enter access key here"></div>
			
			</div>
			
			<div style="width:100%;height:auto;line-height:20px;float:left;margin-top:5px;text-align:left;font-size:0.9em;color:#777;"><i>A system access key is a unique system instance identifier. This key is required for each system installation and is obtained from integrator administrators</i></div>
		
		
		
			<div style="width:100%;height:auto;float:left;margin-top:20px;display:none;color:red;" id="error_message"></div>
			<div style="width:100%;height:auto;float:left;margin-top:20px;">
			<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="proceed_setup_button" onclick="check_access_key();" title="Click to proceed">Next</div>
		
			</div>
			
			</div>
		
		<div style="width:100%;height:auto;float:left;margin-top:20px;display:none;text-align:left;" id="system_setup_summary">
			<div style="width:100%;height:20px;line-height:20px;float:left;font-size:1em;color:green;font-weight:bold;">Access key validation successful...</div>
			<div style="width:100%;height:auto;float:left;">
				<div style="width:100px;height:30px;line-height:30px;float:left;">System name:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;" id="system_name"></div>
			</div>
			
			<div style="width:100%;height:auto;float:left;">
				<div style="width:100px;height:30px;line-height:30px;float:left;">Licensed to:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;" id="system_company"></div>
			</div>
			
			<div style="width:100%;height:auto;float:left;">
				<div style="width:100px;height:30px;line-height:30px;float:left;">Configured URL:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;" id="system_url"></div>
			</div>
			
			<div style="width:100%;height:auto;float:left;">
				<div style="width:100px;height:30px;line-height:30px;float:left;">License expiry:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;" id="license_expiry"></div>
			</div>
			
			<div style="width:100%;height:auto;float:left;margin-top:20px;">
				<div style="width:100%;height:30px;line-height:30px;float:left;">Installation components:</div>
				<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;">
				<input type="checkbox" id="database_input" checked onchange="if(this.checked){add_to_selection(0,'installation_components');}else{remove_from_selection(0,'installation_components');}"><label for="database_input">System database</label><br>
				<input type="checkbox" id="system_files_input" checked onchange="if(this.checked){add_to_selection(1,'installation_components');}else{remove_from_selection(1,'installation_components');}"><label for="system_files_input">System files</label><br>
				<input id="installation_components" type="hidden" value="0,1">
				</div>
			</div>
			
			<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;display:none;color:red;" id="summary_error_message"></div>
			
			<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="begin_setup_button" onclick="begin_initial_setup();" title="Click to proceed">Next</div>  <div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';"  id="cancel_setup_button" onclick="$('#system_setup_summary').slideUp('fast');$('#configuration_steps').slideDown('fast');document.getElementById('access_key').disabled=false" title="Click to proceed">Cancel</div>
			
			
		</div>
		
		<div style="width:100%;height:auto;float:left;display:none;margin-top:20px;" id="Installation_progress">
		<div style="width:100%;height:20px;line-height:20px;float:left;margin-top:5px;" id="installation_phase_title">Installing system. Wait...</div>
		<div style="width:100%;height:20px;line-height:20px;float:left;"><img src="http://localhost/blueraysit.com/imgs/loading_2.gif" style="height:20px;"></div>
		</div>
		
		
		
		<div style="width:100%;height:40px;line-height:15px;float:left;font-size:0.8em;margin-top:10px;color:#666">By USAID DISCOVER - Health<br>Zambia</div>
</div>

</div>