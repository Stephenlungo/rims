
<?php

$activities = mysqli_query($connect,"select * from activities where company_id = $company_id $activity_filter order by _order,title")or die(mysqli_error($connect));

if(!mysqli_num_rows($activities)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
	
}else{
	for($a=0;$a<mysqli_num_rows($activities);$a++){
		$activity_results = mysqli_fetch_array($activities,MYSQLI_ASSOC);
		
		if($activity_results['services'] == ''){
			$unit_title = '<i style="color:red;">Unspecified</i>';
			
		}else{
			$unit_id = $activity_results['services'];
			$this_unit = mysqli_query($connect,"select * from units where id = $unit_id")or die(mysqli_error($connect));
			
			if(!mysqli_num_rows($this_unit)){
				$unit_title = '<i style="color:red;">Unit not found</i>';
				
			}else{
				$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
				
				if($this_unit_results['status']){
					$unit_title = $this_unit_results['title'];
					
				}else{
					$unit_title = $this_unit_results['title'].'[Disabled]';
					
				}
			}			
		}
			
		if($activity_results['warning']){
			$warning = '<font color="red">On</font>';
			
		}else{
			$warning = 'Off';
		}
		
		if(!$activity_results['status']){
			$status_color = '#aaa';
			
		}else{
			$status_color = '#000';
			
		}
		
		
		if($activity_results['branch_ids'] === ''){
			$branch_title = '<i style="color:red;">Not accessible to all</i>';
			
		}else{
			$branch_id_array = explode(',',$activity_results['branch_ids']);
			
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
		
		if($activity_results['agent_type_ids'] === ''){
			$agent_type_title = '<i style="color:red;">Not accessible to all</i>';
			
		}else{
			$agent_type_id_array = explode(',',$activity_results['agent_type_ids']);
			
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
		
		<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($status_color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_item_details('activity','<?php print($activity_results['id']);?>','','','Activity Details','',1);"><div style="width:250px;height:20px;float:left;margin-right:3px;"><?php print($activity_results['title']);?></div><div style="width:100px;height:20px;float:left;margin-right:3px;"><?php print($unit_title);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($activity_results['gsm_code']);?></div><div style="width:70px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($activity_results['ussd_code']);?></div><div style="width:70px;height:20px;float:left;margin-right:3px;"><?php print($activity_results['_order']);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($branch_title);?></div><div style="width:150px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($agent_type_title);?></div><div style="width:80px;height:20px;float:left;margin-right:3px;"><?php print($warning);?></div></div>
		
		<?php
	}
}
	?>