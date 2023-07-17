<?php
$user_id = $_COOKIE['user_id'];
$user_date = $_COOKIE['user_date'];
$user = mysqli_query($$this_connection,"select * from users where id = $user_id")or die(mysqli_error($$this_connection));
$user_results = mysqli_fetch_array($user,MYSQLI_ASSOC);

//include 'new_user.php';
//include 'edit_user.php';

if($active_user_roles[4]){
?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_user_group_details(0);$('#user_group_filter_options').slideUp('fast');">Add</div></div>
<?php
}
?>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;" id="user_group_header">
<div style="width:200px;float:left;height:20px;">Title</div>
<div style="width:80px;float:left;height:20px;text-align:left;">Users</div>
<div style="width:200px;float:left;height:20px;text-align:left;">Cluster</div>
<div style="width:180px;float:left;height:20px;text-align:left;">Supervisor</div>
<div style="width:310px;float:left;height:20px;text-align:left;">Group details</div>
</div>

<div class="general_holder" id="user_group_list_holder">


</div>

<script>
fetch_user_group_list_code();
freeze_header('user_group_header');

</script>