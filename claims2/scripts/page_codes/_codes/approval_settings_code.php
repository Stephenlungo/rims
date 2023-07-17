<div style="width:100%;height:auto;float:left;" id="request_types">
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:280px;float:left;height:20px;">Title</div>
<div style="width:200px;float:left;height:20px;text-align:left;">Cluster</div>
<div style="width:180px;float:left;height:20px;text-align:left;">Approval levels</div>
<div style="width:80px;float:left;height:20px;text-align:left;">Color</div>
<div style="width:180px;float:left;height:20px;text-align:left;">Priority</div>
</div>

<?php

$request_types = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id $filter_string order by title, status desc, title asc")or die(mysqli_error($$module_connect));

if(!mysqli_num_rows($request_types)){
	?>
	<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;font-weight:bold;color:red;">No results were found</div>
	<?php	
}

for($r=0;$r<mysqli_num_rows($request_types);$r++){
	$request_type_results = mysqli_fetch_array($request_types,MYSQLI_ASSOC);
	
	$approval_levels = explode(']',$request_type_results['rule_string']);
	
	if(!$request_type_results['status']){
		$status_color = 'color:#aaa';
		$font_style = 'font-style:italic';
		
	}else{
		$status_color = 'color:black';
		$font_style = 'font-style:normal';
	}
	
	if(!$request_type_results['branch_id']){
		$branch_title = 'Non-clustered';
		
	}else{
		$branch_id = $request_type_results['branch_id'];
		$this_branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
		
		$branch_title = $this_branch_results['title'];
	}
	
	$priority_id = $request_type_results['urgency'];
	$this_priority = mysqli_query($$module_connect,"select * from priorities where id = $priority_id")or die(mysqli_error($$module_connect));
	$this_priority_results = mysqli_fetch_array($this_priority,MYSQLI_ASSOC);
	
	if($request_type_results['color_code'] == 'faa'){
		$color = 'Red';
		
	}else if($request_type_results['color_code'] == '000'){
		$color = 'Black';
		
	}else if($request_type_results['color_code'] == 'ddd'){
		$color = 'Gray';
		
	}else if($request_type_results['color_code'] == 'eef'){
		$color = 'Blue';
		
	}else if($request_type_results['color_code'] == 'ffc864'){
		$color = 'Orange';
		
	}else if($request_type_results['color_code'] == '' || $request_type_results['color_code'] == '#'){
		$color = 'Automatic';
		
	}

	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;<?php print($status_color.';'.$font_style);?>;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_request_type_details(<?php print($request_type_results['id']);?>);">
	<div style="width:280px;float:left;min-height:20px;height:auto;line-height:20px;"><?php print($request_type_results['title']);?></div>
	<div style="width:200px;float:left;min-height:20px;height:auto;line-height:20px;text-align:left;"><?php print($branch_title);?></div>
	<div style="width:180px;float:left;min-height:20px;height:auto;line-height:20px;text-align:left;"><?php print(count($approval_levels));?></div>
	<div style="width:80px;float:left;min-height:20px;height:auto;line-height:20px;text-align:left;"><?php print($color);?></div>
	<div style="width:180px;float:left;min-height:20px;height:auto;line-height:20px;text-align:left;"><?php print($this_priority_results['title']);?></div>
	</div>
	
	<?php	
}
?>
</div>

<div style="width:100%;height:20px;float:left;margin-top:10px;border-bottom:solid 1px #ddd;">

<div style="width:93.82%;height:20px;float:left;font-weight:bold;cursor:pointer;background-color:#eee;" onmouseover="this.style.backgroundColor = '#ddd';" onmouseout="this.style.backgroundColor = '#eee';" title="Click to show/hide" onclick="$('#threashholds').slideToggle('fast');">Approval groups</div><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;margin:0px;" onclick="fetch_request_threshold(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div></div>
<div style="width:100%;height:auto;float:left;" id="threashholds">
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:280px;float:left;height:20px;">Title</div>
<div style="width:200px;float:left;height:20px;text-align:left;">Cluster</div>
</div>

<?php
if(!$user_results['branch_id']){
	$branch_search = '';
	
}else{
	$branch_search = ' and branch_id = '.$user_results['branch_id'];
}

$approval_thresholds = mysqli_query($$module_connect,"select * from approval_thresholds where company_id = $company_id $filter_string order by title, status desc, title asc")or die(mysqli_error($$module_connect));

for($a=0;$a<mysqli_num_rows($approval_thresholds);$a++){
	$approval_thresholds_results = mysqli_fetch_array($approval_thresholds,MYSQLI_ASSOC);
	
	if(!$approval_thresholds_results['branch_id']){
		$branch_title = 'Non-clustered';
		
	}else{
		$branch_id = $approval_thresholds_results['branch_id'];
		$this_branch = mysqli_query($connect,"select * from branches where id = $branch_id")or die(mysqli_error($connect));
		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
		
		$branch_title = $this_branch_results['title'];
	}
	
	if(!$approval_thresholds_results['status']){
		$status_color = 'color:#aaa';
		$font_style = 'font-style:italic';
		
	}else{
		$status_color = 'color:black';
		$font_style = 'font-style:normal';
	}

	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;<?php print($status_color.';'.$font_style);?>;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_request_threshold(<?php print($approval_thresholds_results['id']);?>);">
	<div style="width:280px;float:left;height:20px;"><?php print($approval_thresholds_results['title']);?></div>
	<div style="width:200px;float:left;height:20px;text-align:left;"><?php print($branch_title);?></div>
	</div>
	<?php	
}
?>
</div>