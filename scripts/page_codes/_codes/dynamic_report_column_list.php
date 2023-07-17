<div style="width:100%;height:20px;float:left;">
	<div class="general_button" style="float:right;width:60px;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_primary_column_type_details(0);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">Add</div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="claims_header">
	<div style="width:300px;height:20px;float:left;margin-right:3px;">Title</div>
	<div style="width:80px;height:20px;float:left;margin-right:3px;text-align:right;">Column sets</div>
	<div style="width:130px;height:20px;float:left;margin-left:3px;text-align:left;">Accessibility</div>
	<div style="width:300px;height:20px;float:left;margin-left:3px;text-align:left;">Description</div>
</div>

<?php
$dynamic_report_primary_columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_column_types where company_id = $company_id")or die(mysqli_error($$module_connect));

if(!mysqli_num_rows($dynamic_report_primary_columns)){
	?>
	
	<div style="width:100%;height:20px;line-height:20px;float:left;color:red;text-align:center;font-weight:bold;">No records were found</div>
	
	<?php	
}else{
	for($dr=0;$dr<mysqli_num_rows($dynamic_report_primary_columns);$dr++){
		$dynamic_report_primary_columns_results = mysqli_fetch_array($dynamic_report_primary_columns,MYSQLI_ASSOC);
		$this_type_id = $dynamic_report_primary_columns_results['id'];
		
		$type_columns = mysqli_query($$module_connect,"select * from dynamic_report_primary_columns where primary_column_type_id  = $this_type_id")or die(mysqli_error($$module_connect));
		?>
		
		<div style="width:100%;height:20px;line-height:20px;float:left;cursor:pointer;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_primary_column_type_details(<?php print($dynamic_report_primary_columns_results['id']);?>);">
			<div style="width:300px;height:20px;float:left;margin-right:3px;"><?php print($dynamic_report_primary_columns_results['title']);?></div>
			<div style="width:80px;height:20px;float:left;margin-right:3px;text-align:right;"><?php print(mysqli_num_rows($type_columns));?></div>
			<div style="width:130px;height:20px;float:left;margin-left:3px;text-align:left;"></div>
			<div style="width:300px;height:20px;float:left;margin-left:3px;text-align:left;"></div>
		</div>
		
		<?php
		
		
	}
}
?>