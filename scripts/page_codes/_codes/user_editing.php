<?php
if(isset($_COOKIE['subItem'])){
$userID = $_COOKIE['subItem'];

$user = mysqli_query($connect,"select * from users where id = $userID")or die(mysqli_error($connect));
$userResults = mysqli_fetch_array($user,MYSQLI_ASSOC);
?>
<div style="width:350px;height:auto;margin:0 auto;" id="userDetails">
<div style="width:100%;height:30px;float:left;line-height:30px;text-align:center;font-size:1.4em;margin-top:25px;"><?php print($userResults['_name']);?></div>

<form name="userUpdateForm" method="post" action="">
<div style="width:100%;height:auto;float:left;margin-top:20px;">
<?php
if($activeUserResults['roles'] > 2 || $userResults['id'] == $activeUserResults['id']){
if(!isset($_COOKIE['itemEdit'])){?>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="window.open('index.php?itemEdit=true','_self');">Edit</div>
<?php
}else{
?>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="document.userUpdateForm.submit();">Update</div>
<?php
}
if($activeUserResults['id'] != $userResults['id']){
if($userResults['status']){
	
?>
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';" onclick="var a = confirm('Are you sure you want to disable this user');if(a){window.open('index.php?inact=<?php print($userResults['id']);?>','_self');}">Disable</div>
<?php
}else{?>
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';" onclick="var a = confirm('Are you sure you want to enable this user');if(a){window.open('index.php?act=<?php print($userResults['id']);?>','_self');}">Enable</div>

<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#833';" onmouseout="this.style.backgroundColor='brown';" onclick="var a = confirm('Are you sure you want to enable this user');if(a){window.open('index.php?del=<?php print($userResults['id']);?>','_self');}">Delete</div>
<?php
}
}
}
?>

<div style="width:60px;border:solid 1px #ddd;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="window.open('index.php?closeSubItem=true','_self');">Close</div>
</div>

<input type="hidden" name="action" value="updateUser">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;font-weight:bold;">Name:</div>
<div style="width:300px;height:30px;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<input type="text" name="name" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($userResults['_name']);?>" onfocusout="if(this.value==''){this.value='<?php print($userResults['_name']);?>'}">
<?php
}else{
print($userResults['_name']);
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;font-weight:bold;">User name:</div>
<div style="width:300px;height:30px;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<input type="text" name="username" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($userResults['username']);?>" onfocusout="if(this.value==''){this.value='<?php print($userResults['username']);?>'}">
<?php
}else{
if($userResults['username'] == ''){print('N/A');}else{print($userResults['username']);} 
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;font-weight:bold;">Password:</div>
<div style="width:300px;height:30px;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<input type="text" name="password" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($userResults['password']);?>" onfocusout="if(this.value==''){this.value='<?php print($userResults['password']);?>'}">
<?php
}else{
print($userResults['password']);
}
?>
</div>
</div>

<div style="width:380px;float:left;margin-bottom:10px;display:none;">
<div style="line-height:20px;font-weight:bold;width:100%;height:20px;float:left;line-height:30px;margin-bottom:5px;">Branch:</div>
<div style="width:auto;float:left;">
<?php 
$this_branch_id = $activeUserResults['branch_id'];

if($this_branch_id == 0){
	$this_branch_title = '<i>Unspecified</i>';

}else{
	$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));
	$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);
	$this_branch_title = $this_branch_results['title'];
}

?>
<div class="option_item" title="Click to change option" onclick="$('#this_branch_menu_1').toggle('fast');" id="this_active_account_branch1" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($this_branch_title);?></div>


<div class="option_menu" id="this_branch_menu_1" style="display:none;">
<?php
if($activeUserResults['branch_id'] == 0){?>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';"  onclick="$('#this_active_account_branch1').html($(this).html());$('#this_branch_menu_1').fadeOut('fast');$('#this_active_account_branch_1').val(0);" id="this_account_branch_0"><i>Unspecified</i></div>

<?php
$client_branches = mysqli_query($connect,"select * from branches")or die(mysqli_error($connect));
for($b=0;$b<mysqli_num_rows($client_branches);$b++){
	$client_branches_results = mysqli_fetch_array($client_branches,MYSQLI_ASSOC);
	?>
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';"  onclick="$('#this_active_account_branch1').html($(this).html());$('#this_branch_menu_1').fadeOut('fast');$('#this_active_account_branch_1').val(<?php print($client_branches_results['id']);?>);" id="this_client_branch_<?php print($client_branches_results['id']);?>"><?php print($client_branches_results['title']);?></div>
<?php
}
}
?>
<input type ="hidden" name="this_active_account_branch_1" id="this_active_account_branch_1" value="<?php print($this_branch_id);?>">
</div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;font-weight:bold;">Email:</div>
<div style="width:300px;height:30px;">
<?php print($userResults['email']); ?>
</div>
</div>



<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100px;height:30px;line-height:30px;font-weight:bold;">Phone:</div>
<div style="width:300px;height:30px;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<input type="text" name="phone" style="border:solid 1px #aaa;width:100%;height:30px;" value="<?php print($userResults['phone']);?>" onfocusout="if(this.value==''){this.value='<?php print($userResults['phone']);?>'}">
<?php
}else{
if($userResults['phone'] == ''){print('N/A');}else{print($userResults['phone']);} 
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Access level:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="roles" style="width:100%;height:30px;">
<?php
$userRoles = mysqli_query($connect,"select * from roles order by id");

for($u=0;$u<mysqli_num_rows($userRoles);$u++){
$userRoleResults = mysqli_fetch_array($userRoles,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['roles'] == $userRoleResults['id']){print(' selected ');}?> value="<?php print($userRoleResults['id']);?>" <?php if($activeUserResults['roles'] < $userRoleResults['id']){print(' disabled ');}?>><?php print($userRoleResults['_name']);?></option>
<?php
}
?>
</select>
<?php

}else{
$roleID = $userResults['roles'];
$role = mysqli_query($connect,"select * from roles where id = $roleID")or die(mysqli_error($connect));
$roleResults = mysqli_fetch_array($role,MYSQLI_ASSOC);
print($roleResults['_name']);
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Region:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="user_region" style="width:100%;height:30px;">
<option style="height:30px;" <?php if($userResults['region_id'] == 0){print(' selected ');}?> value="0">Allow all regions</option>

<?php
$regions = mysqli_query($pipat_connect,"select * from regions where company_id = $activeCompanyID order by title");

for($u=0;$u<mysqli_num_rows($regions);$u++){
$region_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['region_id'] == $region_results['id']){print(' selected ');}?> value="<?php print($region_results['id']);?>"><?php print($region_results['title']);?></option>
<?php
}
?>
</select>
<?php

}else{
	if(!$userResults['region_id']){
		print('<i>All regions</i>');
	}else{
		$region_id = $userResults['region_id'];
		$region = mysqli_query($pipat_connect,"select * from regions where id = $region_id")or die(mysqli_error($pipat_connect));
		$region_results = mysqli_fetch_array($region,MYSQLI_ASSOC);
		print($region_results['title']);

	}
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Province:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="user_province" style="width:100%;height:30px;">
<option style="height:30px;" <?php if($userResults['province_id'] == 0){print(' selected ');}?> value="0">Allow all provinces</option>

<?php
$provinces = mysqli_query($pipat_connect,"select * from provinces where company_id = $activeCompanyID order by title");

for($u=0;$u<mysqli_num_rows($provinces);$u++){
$province_results = mysqli_fetch_array($provinces,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['province_id'] == $province_results['id']){print(' selected ');}?> value="<?php print($province_results['id']);?>"><?php print($province_results['title']);?></option>
<?php
}
?>
</select>
<?php

}else{
	if(!$userResults['province_id']){
		print('<i>All provinces</i>');
	}else{
		$province_id = $userResults['province_id'];
		$province = mysqli_query($pipat_connect,"select * from provinces where id = $province_id")or die(mysqli_error($pipat_connect));
		$province_results = mysqli_fetch_array($province,MYSQLI_ASSOC);
		print($province_results['title']);

	}
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Hub:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="user_hub" style="width:100%;height:30px;">
<option style="height:30px;" <?php if($userResults['hub_id'] == 0){print(' selected ');}?> value="0">Allow all hubs</option>

<?php
$hubs = mysqli_query($pipat_connect,"select * from districts where company_id = $activeCompanyID order by title");

for($u=0;$u<mysqli_num_rows($hubs);$u++){
$hub_results = mysqli_fetch_array($hubs,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['hub_id'] == $hub_results['id']){print(' selected ');}?> value="<?php print($hub_results['id']);?>"><?php print($hub_results['title']);?></option>
<?php
}
?>
</select>
<?php

}else{
	if(!$userResults['hub_id']){
		print('<i>All hubs</i>');
	}else{
		$hub_id = $userResults['hub_id'];
		$hub = mysqli_query($pipat_connect,"select * from districts where id = $hub_id")or die(mysqli_error($pipat_connect));
		$hub_results = mysqli_fetch_array($hub,MYSQLI_ASSOC);
		print($hub_results['title']);

	}
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Site:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="user_site" style="width:100%;height:30px;">
<option style="height:30px;" <?php if($userResults['hub_id'] == 0){print(' selected ');}?> value="0">Allow all sites</option>

<?php
$sites = mysqli_query($pipat_connect,"select * from sites where company_id = $activeCompanyID order by title");

for($u=0;$u<mysqli_num_rows($sites);$u++){
$site_results = mysqli_fetch_array($sites,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['site_id'] == $site_results['id']){print(' selected ');}?> value="<?php print($site_results['id']);?>"><?php print($site_results['title']);?></option>
<?php
}
?>
</select>
<?php

}else{
	if(!$userResults['site_id']){
		print('<i>All sites</i>');
	}else{
		$site_id = $userResults['site_id'];
		$site = mysqli_query($pipat_connect,"select * from sites where id = $site_id")or die(mysqli_error($pipat_connect));
		$site_results = mysqli_fetch_array($site,MYSQLI_ASSOC);
		print($site_results['title']);

	}
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Unit:</div>
<div style="width:300px;height:30px;float:left;">
<?php
if(isset($_COOKIE['itemEdit'])){?>
<select name="user_unit" style="width:100%;height:30px;">
<option style="height:30px;" <?php if($userResults['hub_id'] == 0){print(' selected ');}?> value="0">Allow all units</option>

<?php
$units = mysqli_query($pipat_connect,"select * from services where company_id = $activeCompanyID order by title");

for($u=0;$u<mysqli_num_rows($units);$u++){
$unit_results = mysqli_fetch_array($units,MYSQLI_ASSOC);
?>
<option style="height:30px;" <?php if($userResults['unit_id'] == $unit_results['id']){print(' selected ');}?> value="<?php print($unit_results['id']);?>"><?php print($unit_results['title']);?></option>
<?php
}
?>
</select>
<?php

}else{
	if(!$userResults['unit_id']){
		print('<i>All units</i>');
	}else{
		$unit_id = $userResults['unit_id'];
		$unit = mysqli_query($pipat_connect,"select * from services where id = $unit_id")or die(mysqli_error($pipat_connect));
		$unit_results = mysqli_fetch_array($unit,MYSQLI_ASSOC);
		print($unit_results['title']);

	}
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Email notification rule:</div>
<div style="width:300px;height:30px;float:left;">

<?php
if(!isset($_COOKIE['itemEdit'])){
	
	if($userResults['email_send_rule'] == 1){
		print('Receive all related');;
		
	}else if($userResults['email_send_rule'] == 2){
		print('Do not receive for lower levels');
		
	}else if($userResults['email_send_rule'] == 3){
		print('Only receive when specific to me');
		
	}else if($userResults['email_send_rule'] == 0){
		print('Do not receive any');
		
	}
	
}else{
	?>
<select name="email_send_rule" id="email_send_rule" style="width:100%;height:30px;">

<option style="height:30px;" value="1" <?php if($userResults['email_send_rule'] == 1){print(' selected ');}?>>Receive all related</option>
<option style="height:30px;" value="2" <?php if($userResults['email_send_rule'] == 2){print(' selected ');}?>>Do not receive for lower levels</option>
<option style="height:30px;" value="3" <?php if($userResults['email_send_rule'] == 3){print(' selected ');}?>>Only receive when specific to me</option>
<option style="height:30px;" value="0" <?php if($userResults['email_send_rule'] == 0){print(' selected ');}?>>Do not receive any</option>
</select>
<?php
}
?>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:200px;height:30px;line-height:30px;font-weight:bold;">Level notification rule:</div>
<div style="width:300px;height:30px;float:left;">

<?php
if(!isset($_COOKIE['itemEdit'])){
	
	if($userResults['notify_on_previous'] == 1){
		print('Notify me when on previous level');;
		
	}else if($userResults['notify_on_previous'] == 0){
		print('Only notify me when on actual level');
		
	}	
}else{
	?>
<select name="email_notify_rule" id="email_notify_rule" style="width:100%;height:30px;">

<option style="height:30px;" value="1" <?php if($userResults['notify_on_previous'] == 1){print(' selected ');}?>>Notify me when on previous level</option>
<option style="height:30px;" value="0" <?php if($userResults['notify_on_previous'] == 0){print(' selected ');}?>>Only notify me when on actual level</option>
</select>
<?php
}
?>
</div>
</div>


<div style="width:100%;height:auto;float:left;margin-top:20px;">
<?php
if($activeUserResults['roles'] > 2 || $userResults['id'] == $activeUserResults['id']){
if(!isset($_COOKIE['itemEdit'])){?>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="window.open('index.php?itemEdit=true','_self');">Edit</div>
<?php
}else{
?>
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="document.userUpdateForm.submit();">Update</div>
<?php
}
if($activeUserResults['id'] != $userResults['id']){
if($userResults['status']){
	
?>
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';" onclick="var a = confirm('Are you sure you want to disable this user');if(a){window.open('index.php?inact=<?php print($userResults['id']);?>','_self');}">Disable</div>
<?php
}else{?>
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#bbb';" onmouseout="this.style.backgroundColor='#aaa';" onclick="var a = confirm('Are you sure you want to enable this user');if(a){window.open('index.php?act=<?php print($userResults['id']);?>','_self');}">Enable</div>

<div style="width:60px;height:30px;background-color:brown;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#833';" onmouseout="this.style.backgroundColor='brown';" onclick="var a = confirm('Are you sure you want to enable this user');if(a){window.open('index.php?del=<?php print($userResults['id']);?>','_self');}">Delete</div>
<?php
}
}
}
?>

<div style="border:solid 1px #ddd;width:60px;height:30px;color:#000;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="window.open('index.php?closeSubItem=true','_self');">Close</div>
</div>

</form>


</div>
<?php
}