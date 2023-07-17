
<?php

include 'item_details.php';

if($a){
	$bg_color = '#ddf';
	
}else if($a == 0){
	$bg_color = '#fdd';
	
}else{
	$bg_color = '#dfd';
}

$module_id = $a;

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">

<?php
if($a){?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_dynamic_form(<?php print('0,'.$a);?>);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
<?php 
}
?>

</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:<?php print($bg_color);?>;">
<div style="width:50px;float:left;height:20px;">ID</div>
<div style="width:180px;float:left;height:20px;margin-left:2px;">Cluster</div>
<div style="width:280px;float:left;height:20px;margin-left:2px;">Title</div>
<div style="width:280px;float:left;height:20px;">Date created</div>
<div style="width:40px;float:left;height:20px;">Creator</div>
</div>

<?php
if($branch_id == 0){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$branch_id;
}


$dynamic_forms = mysqli_query($connect,"select * from dynamic_forms where company_id = $company_id and module_id = $module_id and status = 1 $branch_search order by _order")or die(mysqli_error($connect));

if(!mysqli_num_rows($dynamic_forms)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($d=0;$d<mysqli_num_rows($dynamic_forms);$d++){
		$dynamic_form_results = mysqli_fetch_array($dynamic_forms,MYSQLI_ASSOC);
				
		if(!$dynamic_form_results['branch_id']){
			$branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$indicator_group_branch_id = $dynamic_form_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $indicator_group_branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$branch_title = $branch_results['title'];
		
		}
		
		$user_date = $dynamic_form_results['user_date'];
		$this_user = mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
		
		if(mysqli_num_rows($this_user)){
			$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
			$this_user_name = $this_user_results['_name'];
			
		}else{
			$this_user_name = '<i>Unknown</i>';
			
		}
		?>
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_dynamic_form(<?php print($dynamic_form_results['id'].','.$a);?>);">
			<div style="width:50px;float:left;height:20px;"><?php print($dynamic_form_results['id']);?></div>
			<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($branch_title);?></div>
			<div style="width:280px;float:left;height:20px;margin-left:2px;"><?php print($dynamic_form_results['form_title']);?></div>
			<div style="width:280px;float:left;height:20px;"><?php print(date('jS M, Y',$dynamic_form_results['_date']));?></div>
			<div style="width:40px;float:left;height:20px;"><?php print($this_user_name);?></div>
		</div>
		<?php
	
	}
}
?>