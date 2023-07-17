<div style="width:800px;height:350px;position:absolute;z-index:2;display:none;" id="new_user" >
<div class="window_holder" style="width:800px;">
<div class="window_title_bar">Create new user

<div class="window_close_button" onmouseout="this.style.backgroundColor='';" onmouseover="this.style.backgroundColor='brown';" onclick="close_window('new_user');">X</div>
</div>

<div class="window_container" style="width:99.3%;padding:2px;height:350px;" id="new_user_container">
<div style="width:49%;height:auto;float:left;margin-top:5px;margin-bottom:10px;">


<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Full name:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="new_user_fullnames" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter full names here" onfocus="if(this.value=='Enter full names here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter full names here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Email:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="new_user_email" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter user email here" onfocus="if(this.value=='Enter user email here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter user email here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Phone:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="new_user_phone" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter user phone here" onfocus="if(this.value=='Enter user phone here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter user phone here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Cluster:</div>
<div style="width:280px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

<?php
if($user_results['branch_id'] == 0){
	$cluster_title = 'Non-clustered';
	
}else{
	$this_branch_id = $user_results['branch_id'];
	$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
	$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
	
	$cluster_title = $this_branch_results['title'];
}
?>

<div class="option_item" title="Click to change option" onclick="$('#new_user_branch_menu').toggle('fast');" id="new_user_active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:110px;"><?php print($cluster_title);?></div>

<div class="option_menu" id="new_user_branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_user_branch_menu').toggle('fast');$('#new_user_active_branch').html($(this).html());$('#new_user_branch').val(0);" >Non-clustered</div>


<?php
if(!$user_results['branch_id']){
	$branches = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));

	for($b=0;$b<mysqli_num_rows($branches);$b++){
		$branches_results = mysqli_fetch_array($branches,MYSQLI_ASSOC);
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_user_branch_menu').toggle('fast');$('#new_user_active_branch').html($(this).html());$('#new_user_branch').val(<?php print($branches_results['id']);?>);" ><?php print($branches_results['title']);?></div>
		<?php
	}
}
?>
</div>
</div>
<input type="hidden" id="new_user_branch" value="<?php print($user_results['branch_id']);?>">
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">User name:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="text" id="new_user_name" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="Enter user name here" onfocus="if(this.value=='Enter user name here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='Enter user name here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Password:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="password" id="new_user_password" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="password" onfocus="if(this.value=='password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='password';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Re-enter:</div>
<div style="width:280px;height:30px;float:left;line-height:30px;color:#aaa;"><input type="password" id="new_user_password2" style="border:solid 1px #aaa;width:100%;height:30px;color:#aaa;" value="password" onfocus="if(this.value=='password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';$('#new_user_error_message').fadeOut('fast');" onfocusout="if(this.value==''){this.value='password';this.style.color='#aaa';}"></div>
</div>
</div>

<div style="width:49%;height:auto;float:right;margin-top:5px;margin-bottom:10px;">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;float:left;">Access level:</div>
<div style="width:280px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
<?php
$current_access_level = $user_results['roles'];
$current_role = mysqli_query($connect,"select * from roles where id = $current_access_level")or die(mysqli_error($connect));
$current_role_results = mysqli_fetch_array($current_role,MYSQLI_ASSOC);
?>

<div class="option_item" title="Click to change option" onclick="\\$('#new_user_role_menu').toggle('fast');" id="new_user_active_role" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Approver</div>

<div class="option_menu" id="new_user_role_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
<?php
	
	$roles = mysqli_query($connect,"select * from roles where id <= $current_access_level")or die(mysqli_error($connect));

	for($r=0;$r<mysqli_num_rows($roles);$r++){
		$role_results = mysqli_fetch_array($roles,MYSQLI_ASSOC);
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#new_user_role_menu').toggle('fast');$('#new_user_active_role').html($(this).html());$('#new_user_role').val(<?php print($role_results['id']);?>);"><?php print($role_results['title']);?></div>
		<?php
	}
?>
</div>
</div>
<input type="hidden" id="new_user_role" value="1">
</div>

<div style="width:100%;float:left;" id="new_station_regions">
<div style="line-height:20px;width:120px;height:20px;float:left;">Restrict regions to: </div>
<div style="width:250px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#region_menu').toggle('fast');$('#new_station_provinces_id').val(0);$('#new_station_provinces').hide('fast');$('#new_station_districts').hide('fast');$('#new_station_sites').hide('fast');$('#new_station_districts_id').val(0);$('#new_station_sites_id').val(0);" id="active_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" >Allow all regions</div>

<div class="option_menu" id="region_menu" style="display:none;" style="min-width:110px;max-width:280px;width:auto;">

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#new_station_regions_id').val(0);" >Allow all regions</div>
<?php
$regions = mysqli_query($pipat_connect,"select * from regions where company_id = $company_id")or die(mysqli_error($pipat_connect));

for($p=0;$p<mysqli_num_rows($regions);$p++){
	$region_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);

	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#new_station_regions_id').val(<?php print($region_results['id']);?>);fetch_menu_items('provinces','region_id',<?php print($region_results['id']);?>,'districts','province_id');" ><?php print($region_results['title']);?></div>
<?php
}
?>
</div>
</div>
<input type="hidden" name="new_station_regions_id" id="new_station_regions_id" value="0">
</div>

<div style="width:100%;float:left;display:none;" id="new_station_provinces">
<div style="line-height:30px;width:120px;height:30px;float:left;">Province: </div>
<div style="width:250px;min-height:30px;height:auto;float:left;line-height:30px;" onclick="$('#new_user_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#provinces_menu').toggle('fast');" id="active_provinces" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Allow all provinces</div>
<div class="option_menu" id="provinces_menu" style="display:none;">

</div>
</div>
<input type="hidden" name="new_station_provinces_id" id="new_station_provinces_id" value="0">
</div>



<div style="width:100%;float:left;display:none;" id="new_station_districts">
<div style="line-height:20px;width:120px;height:30px;line-height:30px;float:left;">Hub: </div>

<div style="width:250px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">

<div class="option_item" title="Click to change option" onclick="$('#districts_menu').toggle('fast');" id="active_districts" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">No districts found</div>



<div class="option_menu" id="districts_menu" style="display:none;">


</div>
</div>
<input type="hidden" name="new_station_districts_id" id="new_station_districts_id" value="0">
</div>
<div style="width:100%;float:left;display:none;" id="new_station_sites">
<div style="line-height:20px;width:120px;height:20px;float:left;">Site: </div>
<div style="width:250px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#sites_menu').toggle('fast');" id="active_sites" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">No constituencies found</div>
<div class="option_menu" id="sites_menu" style="display:none;">
</div>
</div>
<input type="hidden" name="new_station_sites_id" id="new_station_sites_id" value="0">
</div>

<div style="width:100%;float:left;margin-top:10px;" >
<div style="line-height:20px;width:120px;height:20px;float:left;">Restrict unit to: </div>
<div style="width:250px;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
<div class="option_item" title="Click to change option" onclick="$('#user_unit_menu').toggle('fast');" id="active_user_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';">Allow all units</div>

<div class="option_menu" id="user_unit_menu" style="display:none;">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#new_user_unit_id').val(0);" >Allow all units</div>


<?php
$units = mysqli_query($pipat_connect,"select * from services where company_id = $company_id")or die(mysqli_error($pipat_connect));

for($u=0;$u<mysqli_num_rows($units);$u++){
	$unit_results = mysqli_fetch_array($units,MYSQLI_ASSOC);

	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_unit_menu').toggle('fast');$('#active_user_unit').html($(this).html());$('#new_user_unit_id').val(<?php print($unit_results['id']);?>);" ><?php print($unit_results['title']);?></div>
<?php
}
?>
</div>
</div>
<input type="hidden" name="new_user_unit_id" id="new_user_unit_id" value="0">
</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="create_user_button" onclick="create_user();">Create</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:center;display:none;" id="new_user_error_message">Information here</div>
</div>
</div>
</div>
</div>
