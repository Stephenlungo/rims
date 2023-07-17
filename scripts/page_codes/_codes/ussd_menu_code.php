<?php
include 'item_details.php';

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="create_new_ussd_menu_item(<?php print($level.','.$parent_id);?>);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>


</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:90px;height:20px;float:left;margin-right:3px;">USSD Code</div>
<div style="width:160px;height:20px;float:left;margin-right:3px;">Title</div>
<div style="width:80px;height:20px;float:left;margin-right:3px;">Show ID</div>
<div style="width:80px;height:20px;float:left;margin-right:3px;">Order</div>

<div style="width:120px;height:20px;float:left;margin-right:3px;">Type</div>

<div style="width:80px;height:20px;float:left;margin-right:3px;">Script</div>

</div>

<?php
$ussd_menu_items = mysqli_query($connect,"select * from ussd_menu where level = $level and parent_id = $parent_id order by _order, title")or die(mysqli_error($connect));

for($u=0;$u<mysqli_num_rows($ussd_menu_items);$u++){
	$ussd_menu_resuts = mysqli_fetch_array($ussd_menu_items,MYSQLI_ASSOC);
	
	if($ussd_menu_resuts['_type']){
		$ussd_menu_item_type = 'Custom';
		$script_src = $ussd_menu_resuts['script'];
		
	}else{
		$ussd_menu_item_type = 'Standard';
		$script_src = 'N/A';
	}
	
	if($ussd_menu_resuts['show_id']){
		$menu_show_id = 'Yes';
		
	}else{
		$menu_show_id = 'No';
	}
	?>
	<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_ussd_menu_details(<?php print($ussd_menu_resuts['id']);?>);">
<div style="width:90px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_menu_resuts['ussd_id']);?></div>
<div style="width:160px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_menu_resuts['title']);?></div>
<div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($menu_show_id);?></div>
<div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_menu_resuts['_order']);?></div>

<div style="width:120px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($ussd_menu_item_type);?></div>

<div style="width:80px;min-height:20px;height:auto;float:left;margin-right:3px;"><?php print($script_src);?></div>
</div>
	
	
	<?php
}
?>