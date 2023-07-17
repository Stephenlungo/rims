<div style="width:100%;height:auto;float:left;" id="basic_information">
<form action="" method="post" name="company_signup_form">
<input type="hidden" id="item_selections" name="item_selections" value="">
<input type="hidden" name="action" value="signup_company">
<div style="width:300px;margin-top:20px;float:left;color:#006BB3;margin-bottom:10px;">Fill the form bellow to create a trial account</div>

<div style="width:300px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Company name:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter your company name here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter your company name here';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" name="company_name" value="Enter your company name here"></div>
</div>

<div style="width:300px;float:left;margin-top:10px;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Your name:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter your name here'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter your name here';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" name="admin_name" value="Enter your name here"></div>
</div>

<div style="width:300px;float:left;margin-top:10px;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Your email:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='Enter your login email'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='Enter your login email';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="text" name="admin_email" value="Enter your login email"></div>
</div>

<div style="width:300px;margin-top:10px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Password:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='password';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="password" name="admin_password" value="password"></div>
</div>

<div style="width:300px;margin-top:10px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;">Re-enter password:</div>
<div style="width:100%;height:30px;float:left;"><input onfocus="if(this.value=='password'){this.value='';this.style.color='#000';}this.style.borderColor='#aaa';document.getElementById('errorMsg').value='';" onfocusout="if(this.value==''){this.value='password';this.style.color='#aaa';}" style="border:solid 1px #aaa;color:#aaa;height:30px;width:100%;" type="password" name="admin_password_2" value="password"></div>
</div>



<div style="width:300px;height:30px;float:left;margin-top:10px;">
<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="$('#sector_categories').fadeIn('fast');$('#basic_information').hide();">Next >></div>

<div style="width:120px;height:30px;color:#000;text-align:left;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="$('#signup').hide();$('#signin').fadeIn('fast');">Sign in</div>
</div>
</form>
</div>


<div style="width:100%;height:370px;float:left;display:none;" id="sector_categories">
<div style="width:300px;margin-top:20px;float:left;color:#006BB3;margin-bottom:10px;">Select industrial categories</div>
<div style="width:100%;height:300px;overflow:auto;float:left;">
<?php

$industrial_sectors = mysqli_query($connect,"select * from industrial_sectors order by title")or die(mysqli_error($connect));


for($i=0;$i<mysqli_num_rows($industrial_sectors);$i++){
	$industrial_sector_results = mysqli_fetch_array($industrial_sectors,MYSQLI_ASSOC);
	
	$industrial_sector_id = $industrial_sector_results['id'];
	
	$industrial_sector_categories = mysqli_query($connect,"select * from sector_categories where sector_id = $industrial_sector_id order by title")or die(mysqli_error($connect));
	
	if(mysqli_num_rows($industrial_sector_categories) >0){
?>
<div style="width:300px;margin-top:10px;float:left;">
<div style="line-height:20px;width:100%;height:20px;float:left;cursor:pointer;border-bottom:solid 1px #aaa;" onclick="$('#sector_'+<?php print($industrial_sector_results['id']);?>).toggle('fast');" title="Click to view categories in this sector"><?php print($industrial_sector_results['title']);?></div>
<div style="width:100%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #aaa;display:none;" id="sector_<?php print($industrial_sector_results['id']);?>">
<?php
for($is=0;$is<mysqli_num_rows($industrial_sector_categories);$is++){
	$industrial_sector_categories_results = mysqli_fetch_array($industrial_sector_categories,MYSQLI_ASSOC);
	?>
	<input type="checkbox" name="category_<?php print($industrial_sector_categories_results['id']);?>" id="category_<?php print($industrial_sector_categories_results['id']);?>" onchange="if(this.checked){add_to_selections(<?php print($industrial_sector_categories_results['id']);?>);}else{remove_selections(<?php print($industrial_sector_categories_results['id']);?>);}"> <label for="category_<?php print($industrial_sector_categories_results['id']);?>" id="category_<?php print($industrial_sector_categories_results['id']);?>"><?php print($industrial_sector_categories_results['title']);?></label><br>
	
	
	<?php
}
?>
</div>
</div>
<?php
	}
}
?>
</div>
<div style="width:300px;height:30px;float:left;margin-top:2px;">
<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa';" onclick="$('#sector_categories').hide();$('#basic_information').fadeIn('fast');"><< Back</div>

<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';" onclick="authenticate_company_registration();">Finish</div>

<div style="width:120px;height:30px;color:#000;text-align:left;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.color='orange';" onmouseout="this.style.color='#000';" onclick="$('#signup').hide();$('#signin').fadeIn('fast');">Sign in</div>
</div>
</div>