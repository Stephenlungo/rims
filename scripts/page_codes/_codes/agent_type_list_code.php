<?php

if(!$branch_id){
	$branch_filter = '';
	
}else{
	$branch_filter = ' and branch_id = '.$branch_id;
	
}

if($status == -1){
	$status_filter = '';
	
}else{
	$status_filter = ' and status = '.$status;
	
}

$agent_types = mysqli_query($connect,"select * from agent_types where company_id = $company_id $branch_filter $status_filter order by title")or die(mysqli_error($connect));

if(!mysqli_num_rows($agent_types)){
	?>
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	<?php
	
}else{
	
	$table_query = mysqli_query($connect,"select * from agents where company_id = $company_id")or die(mysqli_error($connect));
	
	for($tr=0;$tr<mysqli_num_rows($table_query);$tr++){
		$table_query_results = mysqli_fetch_array($table_query,MYSQLI_ASSOC);
		
		$agent_type_ids = explode(',',$table_query_results['agent_type_id']);
		
		for($a=0;$a<count($agent_type_ids);$a++){
			if(isset($agent_type_array[$agent_type_ids[$a]])){
				$this_index = count($agent_type_array[$agent_type_ids[$a]]);
				
			}else{
				$this_index = 0;
			}
			$agent_type_array[$agent_type_ids[$a]][$this_index] = $table_query_results['id'];	
		}
	}
	
	
	for($a=0;$a<mysqli_num_rows($agent_types);$a++){
		$agent_type_results = mysqli_fetch_array($agent_types,MYSQLI_ASSOC);
		
		if(!$agent_type_results['status']){
			$status_color = '#aaa';
			
		}else{
			$status_color = '#000';
			
		}
		
		if(!isset($agent_type_array[$agent_type_results['id']])){
			$nummber_of_agents = 0;
			
		}else{
			$nummber_of_agents = count($agent_type_array[$agent_type_results['id']]);
			
		}
	
		$this_branch_id = $agent_type_results['branch_id'];
		
		if(!$this_branch_id){
			$cluster_tiitle = '<i>All clusters</i>';
			
		}else {
			$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
			$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
			$cluster_tiitle = $this_branch_results['title'];
		}

		?>
		
		<div style="width:100%;height:20px;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;color:<?php print($status_color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_item_details('agent_type','<?php print($agent_type_results['id']);?>','','','Agent Type Details','',1);"><div style="width:250px;height:20px;float:left;margin-right:3px;"><?php print($agent_type_results['title']);?></div><div style="width:250px;height:20px;float:left;margin-right:3px;"><?php print($cluster_tiitle);?></div><div style="width:70px;height:20px;float:left;margin-left:5px;margin-right:5px;"><?php print($nummber_of_agents);?></div><div style="width:350px;height:20px;float:left;margin-right:3px;"><?php print($agent_type_results['description']);?></div></div>
		
		<?php
		
	}
}
	
	?>
	
	<script>
$('#agent_type_list_status_bar').html("<strong>Records found: </strong><?php print(number_format(mysqli_num_rows($agent_types)));?>");

</script>