<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:brown;height:25px;line-height:25px;">Settingss</div>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_script('_codes/approval_settings.php','settings');tab_item_change(0);">Approval settings</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_6" onclick="fetch_script('_codes/mie.php','settings');tab_item_change(6);">Expense settings</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="fetch_script('_codes/branches.php','settings');tab_item_change(1);" id="tab_1">Cluster settings</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_2" onclick="fetch_script('_codes/users.php','settings');tab_item_change(2);">Approvers</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_3" onclick="fetch_script('_codes/profile.php','settings');tab_item_change(3);" style="display:none;">Profile settings</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_4" onclick="fetch_script('_codes/system.php','settings');tab_item_change(4);" style="display:none;">System settings</div>	
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_5" onclick="fetch_script('_codes/help.php','settings');tab_item_change(5);">Help</div>
</div>

<div class="general_holder" id="settings"></div>

</div>

<script>
fetch_script('_codes/approval_settings.php','settings');tab_item_change(0);
</script>