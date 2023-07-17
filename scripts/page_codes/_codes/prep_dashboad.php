<div style="width:100%;min-height:700px;height:auto;float:left;" id="prep_dashboard">

<div style="width:100%;height:auto;float:left;" id="dashboard_area_holder"><div style="width:100%;height:700px;float:left;line-height:700px;text-align:center;color:#777;font-size:2em;">No dashboard selected</div></div>


</div>

<script>
if($('#selected_dashboard').val() != 0){
	fetch_dashboard($('#selected_dashboard').val());
	
}

</script>