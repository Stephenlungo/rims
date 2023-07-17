<?php
$user_id = $_COOKIE['user_id'];
$user_date = $_COOKIE['user_date'];
/*$user = mysqli_query($connect,"select * from users where id = $user_id")or die(mysqli_error($connect));
$user_results = mysqli_fetch_array($user,MYSQLI_ASSOC);*/

include 'item_details.php';
/*
include 'new_request_type.php';
include 'edit_request_type.php';
include 'new_request_threshold.php';
include 'edit_request_threshold.php';
*/
?>

<div style="width:100%;height:20px;float:left;margin-top:10px;border-bottom:solid 1px #ddd;">

<div style="width:93.82%;height:20px;float:left;font-weight:bold;cursor:pointer;background-color:#eee;" onmouseover="this.style.backgroundColor = '#ddd';" onmouseout="this.style.backgroundColor = '#eee';" title="Click to show/hide" onclick="$('#request_types').slideToggle('fast');">Claim types</div><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;margin:0px;" onclick="<?php if($user_type == 0 and $active_user_roles[8]){?>fetch_request_type_details(0);<?php }else{ ?> alert('Only users with roles for configurations can perform this request');<?php } ?>" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';">Add</div></div>




<div style="width:100%;min-height:30px;height:auto;float:left;" id="approval_settings"></div>

<script>
fetch_claim_type_list_code();
</script>