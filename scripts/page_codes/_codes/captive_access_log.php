<div style="width:100%;height:25px;float:left;margin-top:2px;margin-bottom:2px;">

	<div style="width:auto;height:auto;float:left;">
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<div class="option_item" title="Click to export" onclick="$('#export_menu').toggle('fast');" id="captive_clients_export_button" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';"  style="min-width:100px;width:auto;text-align:center;background-color:#bbf;color:#fff;border:none;">Export to excel</div>

		<div class="option_menu" id="export_menu" style="display:none;width:100px;background-color:#eef;border:solid 1px #ddf;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#export_menu').toggle('fast');$('#captive_clients_export_button').html($(this).html());$('#selected_export_format').val(1);export_captive_client_access_log();">Compact format</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#export_menu').toggle('fast');$('#captive_clients_export_button').html($(this).html());$('#selected_export_format').val(0);export_captive_client_access_log();">Extensive format</div>
		
		
		</div>
		</div>
		<input type="hidden" id="selected_export_format" value="0">
		</div>
	</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:150px;float:left;height:20px;margin-left:2px;">WI-FI</div>
<div style="width:200px;float:left;height:20px;">Survey</div>
<div style="width:140px;float:left;height:20px;">IP Address</div>
<div style="width:90px;float:left;height:20px;">User name</div>
<div style="width:100px;float:left;height:20px;">Date</div>
<div style="width:100px;float:left;height:20px;">Time</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}

$date_from_array = explode('/',$date_from);
$date_from_stamp = mktime(0,0,0,$date_from_array[0],$date_from_array[1],$date_from_array[2]);

$date_to_array = explode('/',$date_to);
$date_to_stamp = mktime(23,59,59,$date_to_array[0],$date_to_array[1],$date_to_array[2]);

$survey_search = '';
if($survey_id){
	$survey_search = ' and questionnaire_id = '.$survey_id;
	
}

$wifi_search = '';
if($wifi_id){
	$wifi_search = ' and wifi_id = '.$wifi_id;
	
}

$access_log = mysqli_query($connect,"select * from prep_questionnaire_data_sets where company_id = $company_id and module_id = 4 $branch_search $wifi_search $survey_search and (_date >= '$date_from_stamp' and _date <= '$date_to_stamp') order by _date desc")or die(mysqli_error($connect));

if(!mysqli_num_rows($access_log)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records found</div>');
	
}else{
	for($a=0;$a<mysqli_num_rows($access_log);$a++){
		$access_log_results = mysqli_fetch_array($access_log,MYSQLI_ASSOC);
		
		if(!$access_log_results['captive_user_id']){
			$captive_user = '<i>Unallocated</i>';
			
		}else{
			$captive_user_id = $access_log_results['captive_user_id'];
			$captive_user = mysqli_query($connect,"select * from pbi_campaign_users where id = $captive_user_id")or die(mysqli_error($connect));
			$captive_user_results = mysqli_fetch_array($captive_user,MYSQLI_ASSOC);
			
			$captive_user = $captive_user_results['username'];
		}
		
		if(!$access_log_results['wifi_id']){
			$wifi_title = '<i>Unallocated</i>';
			
		}else{
			$wifi_id = $access_log_results['wifi_id'];
			$wifi = mysqli_query($connect,"select * from wifis where id = $wifi_id")or die(mysqli_error($connect));
			$wifi_results = mysqli_fetch_array($wifi,MYSQLI_ASSOC);
			
			$wifi_title = $wifi_results['title'];
		}
		
		
		$survey_id = $access_log_results['questionnaire_id'];
		$survey = mysqli_query($connect,"select * from prep_questionnaires where id = $survey_id")or die(mysqli_error($connect));
		$survey_results = mysqli_fetch_array($survey,MYSQLI_ASSOC);
			
		
	
		if(!$captive_user_results['branch_id']){
			$this_branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$branch_id = $captive_user_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$this_branch_title = $branch_results['title'];
		}
	
		$start_date = date('jS M, Y',$access_log_results['_date']);
		$start_time = date('H:i:s',$access_log_results['_date']);
	
		?>

		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details">
			<div style="width:180px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($this_branch_title);?></div>
				<div style="width:150px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($wifi_title);?></div>
				<div style="width:200px;float:left;min-height:20px;height:auto;"><?php print($survey_results['title']);?></div>
				<div style="width:140px;float:left;height:20px;"><?php print($access_log_results['ip_address']);?></div>
				<div style="width:90px;float:left;min-height:20px;height:auto;"><?php print($captive_user);?></div>
				<div style="width:100px;float:left;height:20px;"><?php print($start_date);?></div>
				<div style="width:100px;float:left;height:20px;"><?php print($start_time);?></div>
			
		</div>		
		<?php
	}
}