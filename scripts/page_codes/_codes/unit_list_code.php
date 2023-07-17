<?php

$units = mysqli_query($connect,"select * from units where company_id = $company_id $status_filter order by _order, title")or die(mysqli_error($connect));

for($u=0;$u<mysqli_num_rows($units);$u++){
	$unit_results = mysqli_fetch_array($units,MYSQLI_ASSOC);
	
	if(!$unit_results['status']){
		$status_color = '#aaa';
		
	}else{
		$status_color = '#000';
		
	}
	
	if($unit_results['branch_ids'] === ''){
		$branch_title = '<i style="color:red">Not accessible to all</i>';
		
	}else{
		$branch_id_array = explode(',',$unit_results['branch_ids']);
		
		$branch_title = '';
		for($b=0;$b<count($branch_id_array);$b++){
			$this_unit_branch_id = $branch_id_array[$b];
			
			$this_unit_branch = mysqli_query($connect,"select * from branches where id = $this_unit_branch_id")or die(mysqli_error($connect));
			$this_branch_results = mysqli_fetch_array($this_unit_branch,MYSQLI_ASSOC);
			
			if($branch_title == ''){
				$branch_title = $this_branch_results['title'];
				
			}else{
				$branch_title .= ', '.$this_branch_results['title'];
				
				
			}
		}		
	}
	
	if($unit_results['agent_type_ids'] === ''){
		$agent_type_title = '<i style="color:red;">Not accessible to all</i>';
		
	}else{
		$agent_type_id_array = explode(',',$unit_results['agent_type_ids']);
		
		$agent_type_title = '';
		for($a=0;$a<count($agent_type_id_array);$a++){
			$this_unit_agent_type_id = $agent_type_id_array[$a];
			
			$this_unit_agent_type = mysqli_query($connect,"select * from agent_types where id = $this_unit_agent_type_id")or die(mysqli_error($connect));
			$this_agent_type_results = mysqli_fetch_array($this_unit_agent_type,MYSQLI_ASSOC);
			
			if($agent_type_title == ''){
				$agent_type_title = $this_agent_type_results['title'];
				
			}else{
				$agent_type_title .= ', '.$this_agent_type_results['title'];
			}
		}		
	}
	
	?>

	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;color:<?php print($status_color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_item_details('unit','<?php print($unit_results['id']);?>','','','Unit Details','',1);"><div style="width:200px;height:20px;float:left;margin-right:3px;"><?php print($unit_results['title']);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($unit_results['gsm_code']);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($unit_results['ussd_code']);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($unit_results['_order']);?></div><div style="width:250px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($branch_title);?></div><div style="width:250px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_type_title);?></div></div>
	
	<?php
	
}
	
	?>