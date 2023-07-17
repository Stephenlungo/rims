<div style="width:80%;margin: 0 auto;height:auto;">
<div style="width:100%;height:auto;float:left;margin-bottom:5px;margin-top:40px;color:#006bb3;font-size:1.3em;">Please answer the following questions:</div>

<div style="width:100%;height:auto;float:left;margin-bottom:20px;">
<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">What is your name?</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;color:#aaa" value="Enter your names here"  id="client_name_input" onfocus="if(this.value=='Enter your names here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter your names here';this.style.color='#aaa';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
<div style="width:100%;height:30px;line-height:30px;float:left;font-weight:bold;">What is your phone number (or for the person you live with)?</div>
<div style="width:230px;min-height:30px;height:auto;float:left;line-height:30px;"><input type="text" style="width:100%;height:30px;border:solid 1px #aaa;" value="+260"  id="client_phone_number_input" onfocus="if(this.value=='Enter location here'){this.value='';this.style.color='#000'}$('#error_message').slideUp('fast');this.style.borderColor='#aaa';" onfocusout="if(this.value==''){this.value='Enter location here';}"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;font-weight:bold;color:red;display:none" id="error_message"></div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;">
<div style="width:90px;height:30px;background-color:#9bd075;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#addf8b';" onmouseout="this.style.backgroundColor='#9bd075';"  id="update_or_create_agent_button" onclick="check_client_location_details(<?php print($questionnaire_id)?>);" title="Click to update account details">Continue</div>

<div style="width:60px;height:30px;background-color:#aaa;color:#fff;text-align:center;line-height:30px;float:right;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#888';" onmouseout="this.style.backgroundColor='#aaa';"  id="cancelling_button" onclick="" title="Click to disable the account">Cancel</div>
</div>

<script>
if($('#direct_access').val() == undefined){
	$('#cancelling_button').attr('onclick',"fetch_client_details(0)");
	
}else{
	$('#cancelling_button').attr('onclick',"window.open('"+$('#url').val()+"/prepassess.php?uid=0','_self')");
	
}
</script>