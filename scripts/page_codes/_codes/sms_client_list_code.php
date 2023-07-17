<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<?php
if($active_user_roles[8]){
	?>
	<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_sms_client_details(0)" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
	<?php
}
?>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:140px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">SMS database</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Name</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">Phone number</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">Date added</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Agent</div>
</div>

<?php

if(!$sms_branch_id){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$sms_branch_id;
}

if(!$group_id){
	$group_search = '';
	
}else{
	$group_search = ' and group_id = '.$group_id;
	
}

if($status_id == -1){
	$status_filter = '';
	
}else{
	$status_filter = ' and status = '.$status_id;
	
}

$sms_clients = mysqli_query($connect,"select * from sms_clients where company_id = $company_id $status_filter and _date >= '$date_from' and _date <= '$date_to' $branch_search $group_search order by _date")or die(mysqli_error($connect));

if(!mysqli_num_rows($sms_clients )){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($s=0;$s<mysqli_num_rows($sms_clients );$s++){
		$sms_clients_results = mysqli_fetch_array($sms_clients,MYSQLI_ASSOC);
		
		if(!$sms_clients_results['branch_id']){
			$sms_branch_title = '<i>Non-clustered</i>';
			
		}else{
			$sms_branch_id = $sms_clients_results['branch_id'];
			$sms_branch = mysqli_query($connect,"select * from branches where id = $sms_branch_id")or die(mysqli_error($connect));
			$sms_branch_results = mysqli_fetch_array($sms_branch,MYSQLI_ASSOC);
			
			$sms_branch_title = $sms_branch_results['title'];

		}
		
		if(!$sms_clients_results['group_id']){
			$sms_group_title = '<i>Not grouped</i>';
			
		}else{
			$sms_group_id = $sms_clients_results['group_id'];
			$sms_group = mysqli_query($connect,"select * from sms_groups where id = $sms_group_id")or die(mysqli_error($connect));
			$sms_group_results = mysqli_fetch_array($sms_group,MYSQLI_ASSOC);
			
			$sms_group_title = $sms_group_results['title'];

		}
		
		$this_agent_date = $sms_clients_results['agent_date'];
		if($this_agent_date == '' || $this_agent_date == 0){
			$this_user_date = $sms_clients_results['user_date'];
			
			if($this_user_date == '' || $this_user_date == 0){
				$sms_user_name = '<font color="red">Unspecified</font>';
				
			}else{
				$sms_user = mysqli_query($connect,"select * from users where _date = '$this_user_date' and company_id = $company_id")or die(mysqli_error($connect));
				
				if(mysqli_num_rows($sms_user)){
					$sms_user_results = mysqli_fetch_array($sms_user,MYSQLI_ASSOC);
					
					$sms_user_name = $sms_user_results['_name'];
				}else{
					$sms_user_name = '<font color="red">Not found</font>';
					
				}
			}
		}else{
			$sms_agent = mysqli_query($connect,"select * from agents where _date = '$this_agent_date' and company_id = $company_id")or die(mysqli_error($connect));
				
			if(mysqli_num_rows($sms_agent)){
				$sms_agent_results = mysqli_fetch_array($sms_agent,MYSQLI_ASSOC);
				
				$sms_agent_name = $sms_agent_results['_name'];
			}else{
				$sms_agent_name = '<font color="red">Agent not found</font>';
				
			}
		}
		
		
		if($sms_clients_results['status'] == 1){
			$color = '#000';
			
		}else if($sms_clients_results['status'] == 0){
			$color = '#aaa';
		}
	
		
		$date_added = date('jS M, Y',$sms_clients_results['_date']);
		
			?>
			
			<div style="width:100%;height:20px;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;color:<?php print($color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click for more details" onclick="fetch_sms_client_details(<?php print($sms_clients_results['id']);?>);">
				<div style="width:140px;float:left;height:20px;margin-left:2px;"><?php print($sms_branch_title);?></div>
				<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($sms_group_title);?></div>
				<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($sms_clients_results['_name']);?></div>
				<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print($sms_clients_results['phone_number']);?></div>
				<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print($date_added);?></div>
				<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($sms_agent_name);?></div>
				
			</div>
		<?php
	
	}
}
?>