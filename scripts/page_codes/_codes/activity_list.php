<?php if($active_user_roles[8]){?>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_item_details('activity','0','','','Activity Details','',1);">Add</div></div>
<?php
}
?>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#ddf;" id="activity_list_header"><div style="width:250px;height:20px;float:left;margin-right:3px;">Title</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Unit</div><div style="width:80px;height:20px;float:left;margin-right:3px;">SMS code</div><div style="width:70px;height:20px;float:left;margin-right:3px;">USSD code</div><div style="width:70px;height:20px;float:left;margin-right:3px;">Ordering</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Clusters</div><div style="width:150px;height:20px;float:left;margin-right:3px;">Agent Types</div><div style="width:80px;height:20px;float:left;margin-right:3px;">Warnings</div></div>

<div style="width:100%;height:auto;float:left;" id="activity_list"></div>

<script>
freeze_header('activity_list_header');
fetch_activity_list_code();

</script>