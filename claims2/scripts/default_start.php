<?php
create_login_page($login_array);

?>
<form action="<?php print($url);?>" method="post" id="login_form">
<input type="hidden" id="login_user_id" value="0">
<input type="hidden" id="login_user_date" value="0">
<input type="hidden" id="login_user_type" value="0">
</form>
