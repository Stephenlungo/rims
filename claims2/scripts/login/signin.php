<div style="width:100%;min-height:60px;height:auto;float:left;border-bottom:solid 1px #eee;margin-top:10px">
<input type="hidden" id="table_name" value="<?php print($table);?>">
<input type="hidden" id="query_resource" value="<?php print($query_resource);?>">
<input type="hidden" id="connection" value="<?php print($connection);?>">
<input type="hidden" id="code_url" value="<?php print($code_url);?>">
<input type="hidden" id="system_url" value="<?php print($site_url);?>">
<input type="hidden" id="function_name" value="<?php print($function_name);?>">


<div style="width:60px;height:60px;float:left;"><img src="<?php print($site_url.'/'.$logo);?>" style="width:100%;height:100%;"></div>

<div style="margin-left:10px;width:300px;height:auto%;line-height:60px;float:left;font-size:1.2em;color:#000;"><?php print($login_title);?></div>

</div>

<div class="progress_cover" id="login_cover"></div>
<div class="start_progress_animation" id="login_progress" style="width:250px;margin-left:50px;">
</div>

<?php
include 'login_signin.php';
include 'login_recovery.php';
?>
<div style="width:350px;height:30px;float:left;margin-top:20px;color:red;display:none;" id="login_error_msg"></div>

<?php print($bottom_notes_url);
?>



</div>