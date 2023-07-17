<div style="width:100%;height:30px;float:left;">
	<div style="width:auto;height:auto;float:left;">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Saved reports:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		<div class="option_item" title="Click to change option" onclick="$('#saved_reprts_menu').toggle('fast');" id="active_saved_reprts" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Select report</div>

		<div class="option_menu" id="saved_reprts_menu" style="display:none;width:auto;width:250px;">
			<?php
			$saved_reports = mysqli_query($connect,"select * from dynamic_reports where module_id = 2 and dashboard_id = 0 and dashboard_area_id = 0 order by title")or die(mysqli_error($connect));
			
			$default_report_id = 0;
			for($r=0;$r<mysqli_num_rows($saved_reports);$r++){
				$saved_report_results = mysqli_fetch_array($saved_reports,MYSQLI_ASSOC);
				
				if($saved_report_results['default_report']){
					$default_report_id = $saved_report_results['id'];
				}
				?>
				<div class="option_menu_item" style="width:230px;" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#saved_reprts_menu').toggle('fast');$('#active_saved_reprts').html($(this).html());$('#selected_report').val(<?php print($saved_report_results['id']);?>);$('#report_graph_holder_0_0').hide();fetch_report(1,<?php print($saved_report_results['module_id'].','.$saved_report_results['dashboard_id'].','.$saved_report_results['dashboard_area_id']);?>);" id="report_menu_item_<?php print($saved_report_results['id']);?>"><?php print($saved_report_results['title']);?></div>
				<?php
			}
			?>
		</div>
		</div>
		<input type="hidden" id="selected_report" value="0">
	</div>
	
	<div class="tab" style="background-color:#fee;width:120px;float:right;border:solid 1px #ddd;height:25px;line-height:25px;;" onmouseover="this.style.backgroundColor='#fdd';" onmouseout="this.style.backgroundColor='#fee'" id="advanced_settings_button" onclick="fetch_report_settings()">Advanced Settings</div>

	<div class="tab" style="display:none;background-color:#eee;width:100px;float:right;border:solid 1px #ddd;height:25px;line-height:25px;margin-right:3px;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee'" id="report_settings_button" onclick="fetch_report_prep_details($('#selected_report').val());">Report Settings</div>

	<div style="cursor:pointer;margin-right:5px;margin-top:3px;background-color:#bbf;width:80px;height:20px;float:right;line-height:20px;text-align:center;color:#fff;" onclick="fetch_report_prep_details(0)" onmouseover="this.style.backgroundColor='#ccf';" onmouseout="this.style.backgroundColor='#bbf';">New Report</div>
</div>

<div class="general_holder" id="reporting"></div>

<div style="width:100%;overflow:auto;hight:auto;float:left;display:none;" id="dynamic_report_holder_0_0"></div>
<div class="general_holder" style="display:none;" id="report_graph_holder_0_0"></div>
<div style="width:100%;hight:auto;float:left;display:none;" id="report_formular_holder"></div>
<div style="width:100%;hight:auto;float:left;display:none;" id="report_settings_holder">advanced settings</div>



<?php
if($default_report_id){
	?>
	<script>
		$('#report_menu_item_<?php print($default_report_id);?>').click();
		$('#saved_reprts_menu').slideUp('fast');
	</script>
	
	<?php
	
}

?>