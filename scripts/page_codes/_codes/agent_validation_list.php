<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:4px;">

<div style="width:auto;height:20px;float:left;line-height:20px;" id="agent_list_status_bar"><strong>Records found:</strong> (Counting...)</div>
<div style="width:80px;cursor:pointer;height:20px;line-height:20px;float:right;background-color:#eef;text-align:center;border:solid 1px #ccc;" onmouseover="this.style.backgroundColor='#ddf'" onmouseout="this.style.backgroundColor='#eef'" onclick="allocate_agent();change_window_size('agent_details',400,500,1);">Allocate</div>
</div>

<div style="width:100%;height:20px;height:auto;float:left;display:none;" id="legend_holder"></div>




<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ccf" id="agent_validation_header"><div style="width:20px;height:20px;float:left;"></div><div style="width:100px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:130px;height:20px;float:left;margin-right:3px;">Agent name</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div><div style="width:80px;height:20px;float:left;margin-right:3px;">NRC</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Region</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:90px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:90px;height:20px;float:left;margin-right:3px;">Site</div>
<div style="width:130px;height:20px;float:left;margin-right:3px;">Submited by</div>
</div>



<div style="width:100%;hight:auto;float:left;" id="agent_list_holder"></div>

<script>
fetch_agent_validation_list_code();
freeze_header('agent_validation_header');
</script>