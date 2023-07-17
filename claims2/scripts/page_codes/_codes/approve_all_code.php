<?php
if($this_claim_results['status'] != 0){?>
<div style="width:auto;float:left;margin-left:5px;text-align:left;text-align:center;margin-top:2px;" id="all_actions_<?php print($this_claim_date.'_'.$this_claim_type_date.'_'.$l);?>">
<div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#898;color:#fff;cursor:pointer;" onmouseout="this.style.backgroundColor='#898';" onmouseover="this.style.backgroundColor='#8d8';" onclick="confirm_level_all(<?php print($this_claim_date.','.$this_claim_type_date.','.$c.','.$l.',1');?>);" title="Click to approve this level for applicable entries">&#10004; all</div> <?php if($l!= 0){?><div style="width:30px;margin-left:3px;float:left;height:20px;text-align:center;background-color:#e88;color:#fff;cursor:pointer;display:none;" onmouseout="this.style.backgroundColor='#e88';"onmouseover="this.style.backgroundColor='brown';" onclick="reject_level_all(<?php print($this_claim_date.','.$this_claim_type_date.','.$c.','.$l);?>)" title="Click to deny approval of this level for applicable entries">&#10005; all</div><?php }?>
</div>

<?php
}
?>