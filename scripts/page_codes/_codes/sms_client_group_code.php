<?php
//include 'item_details.php';
?>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<?php
if($active_user_roles[8]){
	?>
	<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_group_details(0)" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
	<?php
}
?>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:140px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Clients</div>
<div style="width:100px;float:left;height:20px;margin-left:2px;">Date added</div>
</div>

<?php

if(!$group_branch_id){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$group_branch_id;
}

$sms_groups = mysqli_query($connect,"select * from sms_groups where company_id = $company_id $status_filter $branch_search order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($sms_groups )){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($g=0;$g<mysqli_num_rows($sms_groups);$g++){
		$sms_group_results = mysqli_fetch_array($sms_groups,MYSQLI_ASSOC);
		$this_group_id = $sms_group_results['id'];
		
		if(!$sms_group_results['branch_id']){
			$sms_branch_title = '<i>Non-clustered</i>';
			
		}else{
			$sms_branch_id = $sms_group_results['branch_id'];
			$sms_branch = mysqli_query($connect,"select * from branches where id = $sms_branch_id")or die(mysqli_error($connect));
			$sms_branch_results = mysqli_fetch_array($sms_branch,MYSQLI_ASSOC);
			
			$sms_branch_title = $sms_branch_results['title'];

		}
		
		$clients = mysqli_query($connect,"select * from sms_clients where group_id = $this_group_id")or die(mysqli_error($connect));
		
		
		if($sms_group_results['status'] == 1){
			$color = '#000';
			
		}else{
			$color = '#aaa';
		}
	
		
		$date_added = date('jS M, Y',$sms_group_results['_date']);
		
			?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;color:<?php print($color);?>" onclick="fetch_group_details(<?php print($sms_group_results['id']);?>)" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';">
		<div style="width:140px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($sms_branch_title);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;margin-left:2px;"><?php print($sms_group_results['title']);?></div>
		<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print(mysqli_num_rows($clients));?></div>
		<div style="width:100px;float:left;height:20px;margin-left:2px;"><?php print($date_added);?></div>
	</div>
		<?php
	
	}
}
?>