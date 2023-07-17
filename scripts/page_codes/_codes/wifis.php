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
<div style="width:50px;float:left;height:20px;">ID</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:310px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:140px;float:left;height:20px;">Starting IP</div>
<div style="width:140px;float:left;height:20px;">Ending IP</div>
<div style="width:140px;float:left;height:20px;">Clients</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
	
}


$wifis = mysqli_query($connect,"select * from wifis where company_id = $company_id $branch_search order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($wifis)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records found</div>');
	
}else{
	for($q=0;$q<mysqli_num_rows($wifis);$q++){
		$wifi_results = mysqli_fetch_array($wifis,MYSQLI_ASSOC);
		
		$wifi_id = $wifi_results['id'];
		
		$captive_data_sets = mysqli_query($connect,"select * from captive_data_sets where wifi_id = $wifi_id")or die(mysqlI_error($connect));
		
		if(!$wifi_results['branch_id']){
			$this_branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$this_branch_id = $wifi_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$this_branch_title = $branch_results['title'];
		
		}
		
		?>

		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" title="Click to view details" id="item_<?php print($questionnaires_results['id']);?>" onclick="fetch_wifi_details(<?php print($wifi_results['id']);?>);">
		<div style="width:50px;float:left;height:20px;margin-left:2px;" ><?php print($wifi_results['id']);?></div>
		<div style="width:180px;float:left;height:20px;margin-left:2px;" ><?php print($this_branch_title);?></div>
		<div style="width:310px;float:left;height:20px;" ><?php print($wifi_results['title']);?></div>
		<div style="width:140px;float:left;height:20px;margin-left:2px;"><?php print($wifi_results['starting_ip']);?></div>
		<div style="width:140px;float:left;height:20px;"><?php print($wifi_results['ending_ip']);?></div>
		<div style="width:140px;float:left;height:20px;"><?php print(mysqli_num_rows($captive_data_sets));?></div>
		</div>
		
		
		<?php
	
	}
}
?>