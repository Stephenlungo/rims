<input type="hidden" value="0" id="checklist_expaded">
<div style="width:300px;height:500px;position:fixed;right:5px;z-index:1000;display:none;" id="checklists">
<div style="width:90%;padding:5px;height:500px;float:right;background-color:#ddd;border-radius:5px 5px 5px 5px;" id="checklist_holder">
<div style="width:100%;float:left;height:30px;line-height:30px;background-color:#0aacc3;text-align:center;color:#fff;">Dynamic Check-Lists<div style="width:20px;float:right;height:30px;text-align:center;line-height:30px;cursor:pointer;background-color:brown" onclick="$('#checklists').slideToggle('fast');" onmouseover="this.style.backgroundColor='#ce3333';" onmouseout="this.style.backgroundColor='brown';">X</div><div style="margin-right:5px;width:20px;float:right;height:30px;text-align:center;line-height:30px;cursor:pointer;background-color:#22c4db" onclick="expand_or_collapse_checklist();" onmouseover="this.style.backgroundColor='#41d8ee';" onmouseout="this.style.backgroundColor='#22c4db';">[ ]</div></div>
<div style="width:99.5%;padding:2px;height:465px;float:left;overflow:auto;background-color:#fff;">
<?php
$checklists = mysqli_query($connect,"select * from dynamic_checklists where company_id = $company_id and status = 1")or die(mysqli_error($connect));

for($c=0;$c<mysqli_num_rows($checklists);$c++){
	$checklist_results = mysqli_fetch_array($checklists,MYSQLI_ASSOC);
	?>
<div style="cursor:pointer;width:100%;min-height:30px;height:auto;float;border-bottom:solid 1px #eee;line-height:30px;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" id="checklist_title_<?php print($checklist_results['id']);?>" onclick="fetch_checklist(<?php print($checklist_results['id']);?>);"><?php print($checklist_results['checklist_title']);?></div>

<div style="width:100%;min-height:90px;height:auto;float:left;display:none;border-bottom:solid 2px #ddd;background-color:#f5feff" id="checklist_details_<?php print($checklist_results['id']);?>"></div>

<?php
}
?>
</div>
</div>
<input type="hidden" id="active_checklist_id" value="0">
</div>