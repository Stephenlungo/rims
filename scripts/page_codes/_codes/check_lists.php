
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
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_item_details('check_list','0',800,400,'Check List Details','',1);$('#item_details_title_bar').css('background-color','#0aacc3');" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div>
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


$dynamic_checklists = mysqli_query($connect,"select * from dynamic_checklists where company_id = $company_id and status = 1 $branch_search order by _order")or die(mysqli_error($connect));

if(!mysqli_num_rows($dynamic_checklists)){
	print('<div style="width:100%;height:20px;line-height:20px;float:left;color:#f00;text-align:center;font-weight:bold;">No records were found</div>');
	
}else{
	for($d=0;$d<mysqli_num_rows($dynamic_checklists);$d++){
		$dynamic_checklist_results = mysqli_fetch_array($dynamic_checklists,MYSQLI_ASSOC);
				
		if(!$dynamic_checklist_results['branch_id']){
			$branch_title = '<i>Non-clusterd</i>';
			
		}else{
			$checklist_branch_id = $dynamic_checklist_results['branch_id'];
			$branch = mysqli_query($connect,"select * from branches where id = $checklist_branch_id")or die(mysqli_error($connect));
			$branch_results = mysqli_fetch_array($branch,MYSQLI_ASSOC);
			
			$branch_title = $branch_results['title'];
		
		}
		
		$user_date = $dynamic_checklist_results['user_date'];
		$this_user =mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
		$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
		?>
		<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_item_details('check_list','<?php print($dynamic_checklist_results['id']);?>',800,400,'Check List Details','',1);$('#item_details_title_bar').css('background-color','#0aacc3');">
			<div style="width:50px;float:left;height:20px;"><?php print($dynamic_checklist_results['id']);?></div>
			<div style="width:180px;float:left;height:20px;margin-left:2px;"><?php print($branch_title);?></div>
			<div style="width:280px;float:left;height:20px;margin-left:2px;"><?php print($dynamic_checklist_results['checklist_title']);?></div>
			<div style="width:280px;float:left;height:20px;"><?php print(date('jS M, Y',$dynamic_checklist_results['_date']));?></div>
			<div style="width:40px;float:left;height:20px;"><?php print($this_user_results['_name']);?></div>
		</div>
		<?php
	
	}
}
?>