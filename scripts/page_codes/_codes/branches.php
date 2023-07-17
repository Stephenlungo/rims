<?php 
include 'item_details.php';
?>

<?php if($active_user_roles[8]){?>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_branch(0);">Add</div></div>
<?php
}
?>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:250px;float:left;height:20px;">Cluster name</div>
<div style="width:180px;float:left;height:20px;">Phone Number</div>
<div style="width:180px;float:left;height:20px;">Email</div>
<div style="width:360px;float:left;height:20px;">Notes</div>
</div>

<?php
$branches = mysqli_query($connect,"select * from branches where company_id = $company_id")or die(mysqli_error($connect));
for($b=0;$b<mysqli_num_rows($branches);$b++){
	$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);
	
	if($branches_results['status']){
		$color = '#000';
		
	}else{
		$color = '#aaa';
		
	}

	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_branch(<?php print($branches_results['id']);?>);">
		<div style="width:250px;float:left;height:20px;"><?php print($branches_results['title']);?></div>
		<div style="width:180px;float:left;height:20px;"><?php print($branches_results['phone']);?></div><div style="width:180px;float:left;height:20px;"><?php print($branches_results['email']);?></div>
		<div style="width:360px;float:left;height:20px;"><?php print($branches_results['details']);?></div>
	</div>
	<?php
}
?>
