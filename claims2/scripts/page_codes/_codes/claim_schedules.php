<div style="width:100%;min-height:20px;height:auto;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;cursor:pointer;" id="claim_list_status_bar" onclick="$('#claim_number_holder').slideToggle('fast');" title="Click to view claim numbers"><strong>Records found:</strong> (Counting...)</div>


<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_claim_schedule_details(0);change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>
</div>


<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#fee;" id="claims_schedule_header"><div style="width:100px;height:20px;float:left;margin-right:3px;">Date created</div>
<div style="width:160px;height:20px;float:left;margin-right:3px;">Claim types</div><div style="width:260px;height:20px;float:left;margin-right:3px;">Location</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Creator</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Schedule type</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Execution date</div><div style="width:60px;height:20px;float:left;margin-right:3px;text-align:right;">Recurrence</div></div>
<div class="general_holder" id="claim_schedule_list_holder1">


</div>
<script>
fetch_claim_schedule();
freeze_header('claims_schedule_header');

</script>