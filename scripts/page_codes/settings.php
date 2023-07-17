<?php
include '_codes/item_details.php';
include '_codes/user_details.php';
		?>
<div style="width:99.5%;height:auto;float:left;padding:2px;" >
<div class="page_title" style="cursor:pointer;background-color:brown;height:25px;line-height:25px;" onclick="$('#filter_options').slideToggle('fast');" id="settings_title">Settings</div>
<div style="display:none;width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;" id="filter_options"></div>
<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/profile_settings.php','settings');tab_item_change(1);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');">Profile Settings</div>

<?php
if($module_connect == 'claims_connect'){?>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="tab_item_change(0);fetch_filter_options('claim_type','fetch_claim_type_list()','settings');">Approval Settings</div>

<script>
tab_item_change(0);
$('#tab_0').click();
</script>
<?php
}
?>

<?php
if($module_connect == 'pipat_admin_central'){?>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="tab_item_change(0);fetch_filter_options('claim_type','fetch_claim_type_list()','settings');">Approval Settings</div>
<script>
tab_item_change(0);
$('#tab_0').click();
</script>
<?php
}
?>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="tab_item_change(2);fetch_filter_options('user','fetch_user_list()','settings');" id="tab_2">Users</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="tab_item_change(7);fetch_filter_options('user_group','fetch_user_group_list()','settings');" id="tab_7">User groups</div>

<?php
if($module_connect == 'connect'){?><div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="fetch_script('_codes/exchanger_settings.php','settings');tab_item_change(8);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');" id="tab_8">Exchanger settings</div><div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="fetch_script('_codes/branches.php','settings');tab_item_change(4);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');" id="tab_4">Cluster settings</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/companies.php','settings');tab_item_change(3);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');">Company settings</div>


<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_5" onclick="fetch_script('_codes/system_settings.php','settings');tab_item_change(5);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');">System settings</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_6" onclick="fetch_script('_codes/system.php','settings');tab_item_change(6);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');" style="display:none;">System settings</div>


<script>
tab_item_change(1);
$('#tab_1').click();
</script>
<?php
}
?>



<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" id="tab_9" onclick="fetch_script('_codes/about.php','settings');tab_item_change(9);$('#filter_options').slideUp('fast');$('#settings_title').attr('onclick','');">About RIMS</div>
</div>

<div class="general_holder" id="settings"></div>

</div>

