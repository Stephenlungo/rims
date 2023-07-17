<input type="hidden" id="company_id" value="<?php print($company_results['id']);?>">
<input type="hidden" id="user_id" value="<?php print($user_id);?>">
<input type="hidden" id="user_role" value="<?php print($user_results['roles']);?>">
<input type="hidden" id="user_date" value="<?php print($user_date);?>">
<input type="hidden" id="active_area_id" value="<?php print($activeAreaID);?>">
<input type="hidden" id="items" value="0">
<input type="hidden" id="uploaded_files" value="">

<div class="wrapper">
<div style="opacity:<?php print($foreground_opacity/100);?>;filter:alpha(opacity=<?php print($foreground_opacity);?>);width:1200px;height:100%;position:fixed;z-index:-2;background-color:<?php print($foreground_color.';color:'.$paper_txt_color);?>;">
</div>

<div class="header" style="height:auto;">
<div class="logo">
<div class="logo_image"><img src="<?php print($system_logo);?>" height="100%" width="100%"></div>
<div class="logo_txt"><?php print($system_name);?></div>
</div>

<div class="company_title"><?php print($company_results['_name']);?></div>

<div class="header_user">Hi, <a style="cursor:pointer;" onclick="window.open('index.php?a=8&sa=3&i=<?php print($user_id);?>','_self');" onmouseover="this.style.color='#006BB3';" onmouseout="this.style.color='#888';"><?php print($logged_user_name);?></a> | <font onclick="window.open('index.php?logout=true','_self');" style="cursor:pointer;" onmouseover="this.style.color='#bbb';" onmouseout="this.style.color='#888';">Logout</font><br>
<?php
if($active_role > 0){?>
<a style="font-size:0.9em;cursor:pointer;<?php if(($license_expiry - $today) < 0){print('color:red');}?>" onclick="window.open('index.php?a=4&sa=4&i=3','_self');" <?php if(($license_expiry - $today) > 0){?> onmouseover="this.style.color='#006BB3';" onmouseout="this.style.color='#888';" <?php }?> ><strong>License:</strong> <?php print($license_name.' ('); if(($license_expiry - $today) < 0){print('expired about '.round(($today - $license_expiry)/60/60/24).' day/s ago)');}else{print('about '.round(($license_expiry - $today)/60/60/24).' day/s remaining)');}
?></a><br>
<?php
}
?>
</div>
</div>

<div class="header" id="header_2" style="display:none;position:fixed;min-height:40px;height:auto;background-color:none;">
<div style="width:100%;height:auto;float:left;background-color:#006bb3;color:#fff;">
<div class="logo">
<div class="logo_image"><img src="<?php print($system_logo);?>" height="100%" width="100%"></div>
<div class="logo_txt" style="color:#fff;"><?php print($system_name);?></div>
</div>

<div class="company_title"><?php print($company_results['_name']);?></div>

<div class="header_user" style="color:#fff;">Hi, <a style="cursor:pointer;" onclick="window.open('index.php?a=8&sa=3&i=<?php print($activeUserID);?>','_self');" onmouseover="this.style.color='#bbb';" onmouseout="this.style.color='#fff';"><?php print($logged_user_name);?></a> | <font onclick="window.open('index.php?logout=true','_self');" style="cursor:pointer;color:#fff;" onmouseover="this.style.color='#bbb';" onmouseout="this.style.color='#fff';">Logout</font><br>
<?php
if($active_role > 0){?>
<a style="font-size:0.9em;color:#fff;cursor:pointer;<?php if(($license_expiry - $today) < 0){print('color:red');}?>" onclick="window.open('index.php?a=4&sa=4&i=3','_self');" <?php if(($license_expiry - $today) > 0){?> onmouseover="this.style.color='#bbb';" onmouseout="this.style.color='#fff';" <?php }?> ><strong>License:</strong> <?php print($license_name.' ('); if(($license_expiry - $today) < 0){print('expired about '.round(($today - $license_expiry)/60/60/24).' day/s ago)');}else{print('about '.round(($license_expiry - $today)/60/60/24).' day/s remaining)');}
?></a><br>
<?php
}
?>
</div>
</div>
<div style="width:100%;float:left;">

<div style="width:980px;position:absolute;margin-left:220px;" id="frozen_header"></div>

</div>
</div>






<?php
$areas = mysqli_query($$module_connect,"select * from areas where publishStatus = 1 order by _order")or die(mysqli_error($$module_connect));
?>



<div class="navigation_holder" >

</div>


<div class="info_holder">

<?php 

include 'scripts/main_progress.php';
?>

<div class="section_holder" style="margin-top:20px;color:#fff" id="section_holder">
<?php
if($enable_chat){?>
<div style="cursor:pointer;width:100%;height:15px;line-height:15px;float:left;opacity:0.3;text-align:center;background-color:#fff;color:#000;font-size:1.4em;margin-bottom:2px;" title="Click to hide/show menu" onmouseover="this.style.opacity='0.7';" onmouseout="this.style.opacity='0.3';" onclick="$('#menu_holder').slideToggle('fast');animate_height();">&#8645 </div>

<?php
}
?>
<div style="width:100%;height:auto;float:left;" id="menu_holder">
<?php
for($a=0;$a<mysqli_num_rows($areas);$a++){
$areaResults = mysqli_fetch_array($areas,MYSQLI_ASSOC);

if($a==0){
	$first_menu = $areaResults['id'];
}
?>
<div style="cursor:pointer;<?php if($activeAreaID == $areaResults['id']){print('background-color:#006bb3;color:#fff;');}if($a==(mysqli_num_rows($areas) - 1)){print('border:none;');}?>" class="navigation_item" onmouseover="this.style.fontWeight='bold';" onmouseout="this.style.fontWeight='normal';" onclick="fetch_menu_page(<?php print($areaResults['id']);?>)" id="menu_<?php print($areaResults['id']);?>">
<div style="text-align:right;width:200px;position:absolute;z-index:1;margin-top:3px;display:none;" id="menu_progress_<?php print($areaResults['id']);?>"><div style="width:15px;height:15px;float:right;"><img src="<?php print($code_url);?>/imgs/button_progress.gif" width="100%;" height="100%"></div></div>

<?php if($areaResults['img_src'] != '' and $areaResults['show_img']){
	?>
	
	<div style="width:25px;hight:25px;float:left;margin-right:3px;border-radius:3px;border:solid 1px #fff;background-color:#eee;"><img src="imgs/<?php print($areaResults['img_src']);?>" style="width:25px;height:25px;"></div>
	
	<?php	
}
print($areaResults['_name']);?>
</div>
<?php
}
?>
</div>
<?php

if($enable_chat){
	include 'scripts/chat.php';
}
?>


</div>




<div class="info_area" style="color:<?php print($paper_txt_color);?>;opacity:<?php print($paper_opacity/100);?>;filter:alpha(opacity=<?php print($paper_opacity);?>);background-color:<?php print($paper_color.';color:'.$paper_txt_color);?>;" id="info_area">
<div class="info_cover" id="info_cover"></div>
<div style="width:100%;height:auto;float:left;" id="page_information_holder"></div>
<?php
/*
if(isset($_COOKIE['activeSubArea'])){
	include 'scripts/'.$sub_area_results['script'];
	
}else{
	//include 'scripts/'.$activeAreaResults['script'];
}*/
?>
<div class="chat_area" id="chat_area"></div>
</div>
</div>

<?php
if($enable_chat){
	include 'scripts/page_codes/_codes/chat_budge.php';
	?>
	<div style="width:250px;margin-left:220px;height:350px;float:left;position:fixed;bottom:20px;display:none;" id="active_budges"></div>

	<?php
}
?>
</div>


<?php
if(!$activeAreaID){
	?>
	<script>
		fetch_menu_page(<?php print($first_menu);?>);
	
	</script>	
	<?php
}

?>

<div id="footer" title="Click to open website for developers" class="footer" style="height:20px;">


<div class="copyright" onclick="window.open('http://www.blueraysit.com','blueraysit.com');" onmouseover="this.style.color='#006BB3';" onmouseout="this.style.color='#000';">&#0169; BlueRays Software</div>

</div>

<script>
fetch_menu_page(<?php print($activeAreaID);?>);
</script>