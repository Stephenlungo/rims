<div style="width:930px;height:300px;margin:0 auto;margin-top:30px;">

<div style="padding:2px;width:300px;height:185px;float:left;margin:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to manage and approve payment claims" onclick="<?php if(!$active_user_roles[0]){?> alert('Oops!! You are not authorized to access this module');<?php }else{?> window.open('<?php print($main_url);?>','parent');<?php }?>">
<?php
if(!$active_user_roles[0]){
	?>
	<div style="position:absolute;height:185px;width:300px;background-color:#fff;opacity:0.8;"></div>
	<?php
}
?>	
	

<div style="width:100%;height:150px;float:left;background-color:#fff;"><img src="<?php print($main_url);?>/imgs/pipat_main_icon.png" style="height:100%;margin-left:20%"></div>
<div style="margin-top:2px;width:100%;height:auto;float:left;line-height:30px;text-align:center;font-size:1.2em;color:#000;">PIPAT Main</div>
<div style="width:100%;height:auto;float:left;"></div>
</div>

<div style="padding:2px;width:300px;height:185px;float:left;margin:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to manage and approve bills" onclick="<?php if(!$active_user_roles[12]){?> alert('Oops!! You are not authorized to access this module');<?php }else{?> alert('You are authorized to access this module but it is currently unavailable. Contact system development team');<?php }?>">

<?php
if(!$active_user_roles[12]){
	?>
	<div style="position:absolute;height:185px;width:300px;background-color:#fff;opacity:0.8;"></div>
	<?php
}
?>	

<div style="width:100%;height:150px;float:left;background-color:#fff;" ><img src="<?php print($main_url);?>/imgs/bills_tracker_icon.png" style="height:100%;margin-left:25%;" ></div>
<div style="margin-top:2px;width:100%;height:auto;float:left;line-height:30px;text-align:center;font-size:1.2em;color:#000;">PIPAT Bills Tracker</div>
<div style="width:100%;height:auto;float:left;"></div>
</div>
<div style="padding:2px;width:300px;height:185px;float:left;margin:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to manage trips and vehicles" onclick="<?php if(!$active_user_roles[17]){?> alert('Oops!! You are not authorized to access this module');<?php }else{?> alert('You are authorized to access this module but it is currently unavailable. Contact system development team');<?php }?>">
<?php
if(!$active_user_roles[17]){
	?>
	<div style="position:absolute;height:185px;width:300px;background-color:#fff;opacity:0.8;"></div>
	<?php
}
?>	
<div style="width:100%;height:150px;float:left;background-color:#fff;"><img src="<?php print($main_url);?>/imgs/transport_icon.jpg" style="height:100%;margin-left:25%;"></div>
<div style="margin-top:2px;width:100%;height:auto;float:left;line-height:30px;text-align:center;font-size:1.2em;color:#000;">PIPAT Transport and Logistics</div>
<div style="width:100%;height:auto;float:left;"></div>
</div>

<div style="padding:2px;width:300px;height:185px;float:left;margin:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to manage and track procurement processes" onclick="alert('Oops!! You are not authorized to access this module');">
<div style="position:absolute;height:185px;width:300px;background-color:#fff;opacity:0.8;"></div>
<div style="width:100%;height:150px;float:left;background-color:#fff;"><img src="<?php print($main_url);?>/imgs/procurement_icon.png" style="height:100%;margin-left:10%;"></div>
<div style="margin-top:2px;width:100%;height:auto;float:left;line-height:30px;text-align:center;font-size:1.2em;color:#000;">PIPAT Procurement Tracker</div>
<div style="width:100%;height:auto;float:left;"></div>
</div>

<div style="padding:2px;width:300px;height:185px;float:left;margin:2px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='';" title="Click to manage and training courses" onclick="<?php if(!$active_user_roles[15]){?> alert('You are not authorized to access this module');<?php }else{?> alert('You are authorized to access this module but it is currently unavailable. Contact system development team');<?php }?>">
<?php
if(!$active_user_roles[15]){
	?>
	<div style="position:absolute;height:185px;width:300px;background-color:#fff;opacity:0.8;"></div>
	<?php
}
?>	

<div style="width:100%;height:150px;float:left;background-color:#fff;"><img src="<?php print($main_url);?>/imgs/training_manager.png" style="height:100%;margin-left:25%;"></div>
<div style="margin-top:2px;width:100%;height:auto;float:left;line-height:30px;text-align:center;font-size:1.2em;color:#000;">PIPAT Training Manager</div>
<div style="width:100%;height:auto;float:left;"></div>
</div>


</div>