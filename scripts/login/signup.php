<div style="margin-left:20px;width:375px;height:500px;float:left;<?php if(!isset($_COOKIE['signup_error'])){?>display:none;<?php }?>" id="signup">

<div class="progress_cover" id="login_cover" ></div>
<div class="progress_animation" id="login_progress"><img src="imgs/progress_1.gif" height="100%">
<br>
Please wait<br>
<div class="progress_cancel" onclick="window.open('index.php?a=1','_self');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='#ddd';">
Cancel
</div>
</div>

<div style="width:100%;height:30px;margin-top:10px;float:left;border-bottom:solid 1px #eee;">
<div style="width:30px;height:30px;float:left;"><img src="../imgs/logo_official.jpg" style="width:100%;height:100%;"></div>
<div style="margin-left:10px;width:300px;height:100%;line-height:30px;float:left;font-size:1.2em;color:#000;">Create a business account</div>
</div>

<?php
include 'scripts/signup_form.php';

?>




<?php
if(isset($_COOKIE['recoverySent'])){?>
<div style="width:350px;min-height:30px;height:auto;float:left;color:green;font-size:1.3em;margin-top:10px;">We have sent you a recovery email. <br>Check your mail...</div>
<?php
}elseif(isset($_COOKIE['passwordReset']) and $_COOKIE['passwordReset'] == 'true'){
?>
<div style="width:350px;min-height:30px;height:auto;float:left;color:green;font-size:1.3em;margin-top:10px;">You have changed your password. <br>Use your new password to sign in...</div>
<?php
}elseif(isset($_COOKIE['accountActivated'])){
?>
<div style="width:350px;min-height:30px;height:auto;float:left;color:green;font-size:1.3em;margin-top:10px;">Your account has been activated. <br>Use login information sent earlier to enter...</div>
<?php
}elseif(isset($_COOKIE['accountDeleted'])){
?>
<div style="width:350px;min-height:30px;height:auto;float:left;color:green;font-size:1.3em;margin-top:10px;">Account has been removed</div>
<?php
}
?>

<div style="width:350px;height:30px;float:left;margin-top:5px;"><input disabled=true style="background-color:#fff;color:#f00;border:none;height:30px;width:100%;" type="text" name="signup_errorMsg" id="signup_errorMsg" 
value="<?php
if(isset($_COOKIE['signup_error'])){
print("There is a use registered with this email address.");
}
?>"
></div>




<div style="width:300px;float:left;font-size:0.9em;">
<div style="line-height:20px;width:100%;height:20px;float:left;cursor:pointer;" onmouseover="this.style.color='#006BB3';" onmouseout="this.style.color='#000';" onclick="window.open('about.php','aboutStern',300,400);">About Sync Zambia</div>
<div style="line-height:20px;width:100%;height:20px;float:left;">&#0169; Sync Advertising Limited</div>
</div>

</div>