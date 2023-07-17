<?php

include 'item_details.php';

if($a){
	$bg_color = '#ddf';
	
}else if($a == 0){
	$bg_color = '#fdd';
	
}else{
	$bg_color = '#dfd';
}

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">

<?php
if($a){?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_wifi_details(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php 
}
?>

</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:150px;float:left;height:20px;margin-left:2px;">User Name</div>
<div style="width:140px;float:left;height:20px;">Password</div>
<div style="width:90px;float:left;height:20px;">Status</div>
<div style="width:100px;float:left;height:20px;">Date Started</div>
<div style="width:100px;float:left;height:20px;">Time Started</div>
<div style="width:140px;float:left;height:20px;">Session Code</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}


$captive_users = mysqli_query($connect,"select * from pbi_campaign_users where company_id = $company_id $branch_search order by status desc, username asc")or die(mysqli_error($connect));

if(!mysqli_num_rows($captive_users)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records found</div>');
	
}else{
	for($u=0;$u<mysqli_num_rows($captive_users);$u++){
		$captive_user_results = mysqli_fetch_array($captive_users,MYSQLI_ASSOC);
		
		$captive_user_id = $captive_user_results['id'];
	
		if(!$captive_user_results['branch_id']){
			$this_branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$branch_id = $captive_user_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$this_branch_title = $branch_results['title'];
		}
		
		$user_status = '<font color="green">Active</font>';
		if(!$captive_user_results['status']){
			$user_status = 'Inactive';
			
		}
		
		$start_date = '<i>N/A</i>';
		$start_time = '<i>N/A</i>';
		if($captive_user_results['session_start']){
			$start_date = date('jS M, Y',$captive_user_results['session_start']);
			$start_time = date('H:i:s',$captive_user_results['session_start']);
		}
		
		$session_code = '<i>N/A</i>';
		if($captive_user_results['session_code']){
			$session_code = $captive_user_results['session_code'];
		}
		
		?>

		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details">
			<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($this_branch_title);?></div>
			<div style="width:150px;float:left;height:20px;margin-left:2px;"><?php print($captive_user_results['username']);?></div>
			<div style="width:140px;float:left;height:20px;"><?php print($captive_user_results['password']);?></div>
			<div style="width:90px;float:left;height:20px;"><?php print($user_status);?></div>
			<div style="width:100px;float:left;height:20px;"><?php print($start_date);?></div>
			<div style="width:100px;float:left;height:20px;"><?php print($start_time);?></div>
			<div style="width:140px;float:left;height:20px;"><?php print($session_code);?></div>
			
		</div>		
		<?php
	
	}
}
?>