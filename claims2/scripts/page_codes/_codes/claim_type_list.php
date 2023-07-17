<?php 

include '../scripts/page_codes/_codes/item_details.php';

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="claim_type_status_bar"><strong>Records found:</strong> (Counting...)</div>
<?php
if($active_user_roles[10]){
	?>
<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="fetch_claim_type_details(0);change_window_size('agent_details',400,500,1);" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>

<?php
}
?>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="claims_header"><div style="width:300px;height:20px;float:left;margin-right:3px;">Title</div>
<div style="width:130px;height:20px;float:left;margin-right:3px;">Approval levels</div><div style="width:150px;height:20px;float:left;margin-right:3px;text-align:right;">Daily rate(K)</div><div style="width:150px;height:20px;float:left;margin-right:3px;text-align:right;">Day limit</div><div style="width:150px;height:20px;float:left;margin-right:3px;text-align:left;margin-left:5px;">Day adjustment</div></div>


<div class="general_holder" id="claim_type_list_holder">


</div>

	<script>
fetch_claim_type_code();
</script>