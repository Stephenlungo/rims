<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_10" onclick="$('#code_entry').hide();$('#basic_mode').show('fast');tab_item_change(10);">Easy</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_11" onclick="$('#code_entry').slideDown('fast');$('#basic_mode').hide();tab_item_change(11);">Advanced</div>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;" id="basic_mode">
<input type="hidden" id="total_basic_entries" value="1">

<div style="width:100%;height:auto;float:left;" id="basic_entry_container">
<div style="width:100%;height:auto;float:left;margin-bottom:15px;" id="basic_entry_0">
<div style="float:left;width:90%;height:20px;border-bottom:solid 1px #ccc;line-height:20px;font-weight:bold;cursor:pointer;" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" onclick="$('#basic_entry_error_message').slideUp('fast');$('#basic_entry_holder_0').slideToggle('fast');" title="Click to expand/collapse entry" id="entry_title_0">Entry 1</div><div style="cursor:pointer;width:30px;height:20px;line-height:20px;float:left;margin-left:5px;background-color:#aaa;text-align:center;color:#fff;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa'" onclick="$('#ignore_entry_0').val(1);$('#entry_title_0').css('text-decoration','line-through');$('#entry_title_0').css('color','#bbb');$('#cancel_button_0').slideUp('fast');$('#tick_button_0').slideDown('fast');$('#basic_entry_holder_0').slideUp('fast');$('#basic_entry_error_message').slideUp('fast');" id="cancel_button_0" title="Click to ignore this entry">X</div>

<div style="cursor:pointer;display:none;width:30px;height:20px;line-height:20px;float:left;margin-left:5px;background-color:#7c7;text-align:center;color:#fff;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';" onclick="$('#ignore_entry_0').val(0);$('#entry_title_0').css('text-decoration','');$('#entry_title_0').css('color','#000');$('#cancel_button_0').slideDown('fast');$('#tick_button_0').slideUp('fast');$('#basic_entry_error_message').slideUp('fast');" id="tick_button_0" title="Click to include this entry">&#10004</div>
<div style="width:100%;height:auto;float:left;" id="basic_entry_holder_0">
<input type="hidden" id="ignore_entry_0" value="0">
<div style="width:98%;min-height:30px;height:auto;float:left;line-height:30px;">
<div style="width:100%;float:left;height:auto;">
<div style="width:20px;float:left;">D:</div>
<div style="width:40px;float:left;margin-top:3px;">
<select id="basic_entry_day_0">

<?php
for($d=1;$d<32;$d++){

	if($d < 10){

		$dd = '0'.$d;

		

	}else{

		$dd = $d;

	}

	?>

<option value="<?php print($d);?>" <?php if(date('j',time()) == $d){print(' selected ');}?>><?php print($dd);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:10px;">M: </div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="basic_entry_month_0">

<?php



for($m=1;$m<13;$m++){

	if($m < 10){

		$dm = '0'.$m;

		

	}else{

		$dm = $m;

	}

	?>

<option value="<?php print($m);?>" <?php if(date('m',time()) == $dm){print(' selected ');}?>><?php print($dm);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:10px;">Y:</div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="basic_entry_year_0">

<?php



for($y=2000;$y<(date('Y',time()) +1);$y++){

	if($y < 10){

		$y = '0'.$y;

		

	}

	?>

<option value="<?php print($y);?>" <?php if(date('Y',time()) == $y){print(' selected ');}?>><?php print($y);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:30px;">Hr: </div>

<div style="width:30px;float:left;margin-top:3px;">

<select id="basic_entry_hour_0">

<?php



for($h=0;$h<24;$h++){

	if( $h < 10){

		$h = '0'.$h;

		

	}

	?>

<option value="<?php print($h);?>" <?php if(date('H',time()) == $h){print(' selected ');}?>><?php print($h);?></option>

<?php

}

?>



</select>

</div>



<div style="width:30px;float:left;margin-left:15px;">Min:</div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="basic_entry_min_0">

<?php



for($m=0;$m<60;$m++){

	if($m < 10){

		$m = '0'.$m;

		

	}

	?>

<option value="<?php print($m);?>" <?php if(date('i',time()) == $m){print(' selected ');}?>><?php print($m);?></option>

<?php

}

?>



</select>

</div>
</div>
</div>
<div style="width:98%;min-height:30px;height:auto;float:left;line-height:30px;">

<input type="hidden" name="new_entry_agent_0" id="new_entry_agent_0" value="0">
<input type="hidden" name="new_entry_site_required_0" id="new_entry_site_required_0" value="0">

<div style="width:100%;float:left;height:auto;" id="search_entry_agents_0">
<div style="line-height:30px;width:90px;height:30px;float:left;">Agent search: </div>
<div style="width:200px;height:25px;float:left;margin-top:1px;">
<input type="text" id="search_agent_key_0" style="width:100%;color:#aaa;height:25px;" value="Enter name or phone here" onfocus="if(this.value=='Enter name or phone here'){this.value='';this.style.color='#000';}else{$('#new_entry_agent_search_results_holder_0').slideDown('fast');}$('#basic_entry_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter name or phone here';this.style.color='#aaa';}" onkeyup="if (event.keyCode == 13) {search_new_entry_agent(0);}">
</div>

<div style="cursor:pointer;width:50px;margin-left:10px;height:25px;line-height:25px;float:left;color:#fff;text-align:center;background-color:#c994c7;" onmouseover="this.style.backgroundColor='#c994a7';" onmouseout="this.style.backgroundColor='#c994c7';" onclick="search_new_entry_agent(0);">Search</div>

<div style="position:absolute;width:250px;height:auto;margin-top:30px;padding:2px;display:none;" id="new_entry_agent_search_results_holder_0">
<div style="width:100%;height:25px;float:left;background-color:#006bb3;text-align:center;line-height:25px;font-size:0.9em;color:#fff;">
Search for agent results
<div style="cursor:pointer;width:20px;height:25px;text-align:center;line-height:25px;color:#fff;float:right;background-color:brown;" onmouseover="this.style.backgroundColor='#f55';" onmouseout="this.style.backgroundColor='brown';" title="Click to exit search" onclick="$('#new_entry_agent_search_results_holder_0').slideUp('fast');">X</div>
</div>
<div style="height:auto;float:left;width:100%;max-height:220px;overflow:auto;background-color:#fee;" id="new_entry_agent_search_results_0"></div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;" id="active_entry_agent_holder_0">
<div style="width:90px;height:30px;line-height:30px;float:left;">Agent:</div>
<div style="width:270px;min-height:20px;height:auto;float:left;line-height:20px;background-color:#eee;padding:3px;" id="active_entry_agent_0"></div>
</div>






</div>
</div>

<input type="hidden" name="new_entry_site_0" id="new_entry_site_0" value="0">

<div style="width:100%;float:left;height:auto;display:none;" id="search_entry_sites_0">
<div style="line-height:30px;width:90px;height:30px;float:left;">Site search: </div>
<div style="width:200px;height:25px;float:left;margin-top:1px;">
<input type="text" id="search_site_key_0" style="width:100%;color:#aaa;height:25px;" value="Enter site name here" onfocus="if(this.value=='Enter site name here'){this.value='';this.style.color='#000';}else{$('#new_entry_site_search_results_holder_0').slideDown('fast');}$('#basic_entry_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter site name here';this.style.color='#aaa';}" onkeyup="if (event.keyCode == 13) {search_new_entry_site(0);}">
</div>

<div style="cursor:pointer;width:50px;margin-left:10px;height:25px;line-height:25px;float:left;color:#fff;text-align:center;background-color:#c994a7;" onmouseover="this.style.backgroundColor='#c994a7';" onmouseout="this.style.backgroundColor='#c994c7';" onclick="search_new_entry_site(0);">Search</div>

<div style="position:absolute;width:250px;height:auto;margin-top:30px;padding:2px;display:none;" id="new_entry_site_search_results_holder_0">
<div style="width:100%;height:25px;float:left;background-color:#006bb3;text-align:center;line-height:25px;font-size:0.9em;color:#fff;">
Search for site results
<div style="cursor:pointer;width:20px;height:25px;text-align:center;line-height:25px;color:#fff;float:right;background-color:brown;" onmouseover="this.style.backgroundColor='#f55';" onmouseout="this.style.backgroundColor='brown';" title="Click to exit search" onclick="$('#new_entry_site_search_results_holder_0').slideUp('fast');">X</div>
</div>
<div style="height:auto;float:left;width:100%;max-height:220px;overflow:auto;background-color:#efe;" id="new_entry_site_search_results_0"></div>
</div>
</div>

<div style="width:100%;height:auto;float:left;margin-bottom:5px;display:none;" id="site_title_holder_0">
<div style="width:90px;height:30px;line-height:30px;float:left;">Site:</div>
<div style="width:280px;min-height:20px;height:auto;float:left;line-height:20px;background-color:#eee;padding:3px;" id="site_title_0"></div>
</div>


<div style="line-height:30px;width:90px;height:30px;float:left;" id="unit_title_0">Unit: </div>
<div style="min-width:100px;width:auto;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#entry_unit_menu_0').toggle('fast');$('#unit_title_0').css('color','#000');$('#basic_entry_error_message').slideUp('fast');" id="active_entry_unit_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;height:auto;width:auto;">Select unit</div>


<div class="option_menu" id="entry_unit_menu_0" style="display:none;min-width:230px;">
<?php
$units = mysqli_query($connect,"select * from units where company_id = $company_id and status = 1 order by title")or die(mysqli_error($connect));

for($a=0;$a<mysqli_num_rows($units);$a++){
	$unit_results = mysqli_fetch_array($units,MYSQLI_ASSOC);
	
	if(!$unit_results['status']){
		$unit_status_title = ' [Disabled]';
		
	}else{
		$unit_status_title = '';
		
	}

	?>
	<div class="option_menu_item" style="min-width:200px;" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#entry_unit_menu_0').toggle('fast');$('#active_entry_unit_0').html($(this).html());$('#new_entry_unit_0').val(<?php print($unit_results['id']);?>);fetch_new_entry_activity('_0',<?php print($unit_results['id']);?>);"><?php print($unit_results['title'].' ('.$unit_results['gsm_code'].')'.$unit_status_title);?></div>
	<?php
}
?>
</div>
<input type="hidden" name="new_entry_unit_0" id="new_entry_unit_0" value="0">
</div>

<div style="width:100%;height:auto;float:left;display:none;" id="new_entry_activities_0">
<div style="line-height:30px;width:90px;height:30px;float:left;" id="activity_title_0">Activity: </div>
<div style="min-width:100px;width:auto;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#entry_activity_menu_0').toggle('fast');$('#activity_title_0').css('color','#000');$('#basic_entry_error_message').slideUp('fast');" id="active_entry_activity_0" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;height:auto;width:auto;">Select activity</div>


<div class="option_menu" id="entry_activity_menu_0" style="display:none;">
</div>
<input type="hidden" name="new_entry_activity_0" id="new_entry_activity_0" value="0">
</div>
</div>




<div style="width:100%;float:left;height:auto;">
<div style="line-height:30px;width:90px;height:30px;float:left;" id="number_title_0">Number: </div>
<div style="width:250px;height:25px;float:left;margin-top:1px;">
<input type="text" id="intervention_number_0" style="width:100%;color:#aaa;height:25px;" value="Enter activity number here" onfocus="if(this.value=='Enter activity number here'){this.value='';this.style.color='#000';}$('#basic_entry_error_message').slideUp('fast');" onfocusout="if(this.value==''){this.value='Enter activity number here';this.style.color='#aaa';}else if(isNaN(this.value) || this.value < 1 ){alert('Number must be an integer greater than 0');this.value='Enter activity number here';this.style.color='#aaa';}">
</div>
</div>
</div>
</div>
</div>

<div style="width:100px;margin:0 auto;height:25px;"><div style="width:100%;height:25x;line-height:25px;float:left;background-color:#ddd;text-align:center;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#ddd';" title="Click to add another entry field" onclick="add_more_new_basic_etries();">Add more</div></div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;">
<div style="margin-left:5px;width:60px;height:30px;background-color:#7c7;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#aca';" onmouseout="this.style.backgroundColor='#7c7';"  id="finish_basic_entries_button" onclick="add_new_basic_entries();">Finish</div>
</div>

<div style="width:100%;min-height:30px;height:auto;line-height:20px;float:left;margin-top:5px;color:red;font-weight:bold;text-align:left;display:none;" id="basic_entry_error_message">Information here</div>
</div>

<div style="width:100%;height:auto;float:left;display:none;margin-top:10px;" id="code_entry">
<input type="hidden" id="total_entries" value="1">
<div style="width:100%;height:auto;float:left;" id="entry_container">
<div style="width:100%;height:auto;float:left;" id="entry_0_container">
<div style="width:98%;height:30px;float:left;line-height:30px;padding:2px;">
<div style="width:100px;float:left;height:auto;">Phone number:</div>
<div style="width:210px;float:left;height:auto;"><input type="text" style="width:100%;height:25px;color:#aaa;border:solid 1px #aaa;" value="Enter phone number here" id="entry_phone_number_0" onfocus="if(this.value == 'Enter phone number here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value == ''){this.value='Enter phone number here';this.style.color='#aaa';}"></div>
</div>

<div style="width:98%;min-height:30px;height:auto;float:left;line-height:30px;padding:2px;">
<div style="width:100%;float:left;height:auto;">
<div style="margin-left:2px;width:20px;float:left;">D:</div>
<div style="width:40px;float:left;margin-top:3px;">
<select id="entry_day_0">

<?php



for($d=1;$d<32;$d++){

	if($d < 10){

		$dd = '0'.$d;

		

	}else{

		$dd = $d;

	}

	?>

<option value="<?php print($d);?>" <?php if(date('j',time()) == $d){print(' selected ');}?>><?php print($dd);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:10px;">M: </div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="entry_month_0">

<?php



for($m=1;$m<13;$m++){

	if($m < 10){

		$dm = '0'.$m;

		

	}else{

		$dm = $m;

	}

	?>

<option value="<?php print($m);?>" <?php if(date('m',time()) == $dm){print(' selected ');}?>><?php print($dm);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:10px;">Y:</div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="entry_year_0">

<?php



for($y=2000;$y<(date('Y',time()) +1);$y++){

	if($y < 10){

		$y = '0'.$y;

		

	}

	?>

<option value="<?php print($y);?>" <?php if(date('Y',time()) == $y){print(' selected ');}?>><?php print($y);?></option>

<?php

}

?>

</select>

</div>



<div style="width:20px;float:left;margin-left:30px;">Hr: </div>

<div style="width:30px;float:left;margin-top:3px;">

<select id="entry_hour_0">

<?php



for($h=0;$h<24;$h++){

	if( $h < 10){

		$h = '0'.$h;

		

	}

	?>

<option value="<?php print($h);?>" <?php if(date('H',time()) == $h){print(' selected ');}?>><?php print($h);?></option>

<?php

}

?>



</select>

</div>



<div style="width:30px;float:left;margin-left:15px;">Min:</div>

<div style="width:40px;float:left;margin-top:3px;">

<select id="entry_min_0">

<?php



for($m=0;$m<60;$m++){

	if($m < 10){

		$m = '0'.$m;

		

	}

	?>

<option value="<?php print($m);?>" <?php if(date('i',time()) == $m){print(' selected ');}?>><?php print($m);?></option>

<?php

}

?>



</select>

</div>








</div>
</div>

<div style="width:98%;min-height:30px;height:auto;float:left;line-height:30px;padding:2px;">
<div style="width:100px;float:left;height:auto;">Message:</div>
<div style="width:210px;float:left;min-height:30px;height:auto;"><textarea id="entry_message_0" style="min-width:100%;max-width:100%;min-height:40px;color:#aaa" onfocus="if(this.value == 'Code comes here'){this.value='';this.style.color='#000';}"  onfocusout="if(this.value == ''){this.value='Code comes here';this.style.color='#aaa';}">Code comes here</textarea></div>
</div>
</div>
</div>

<div style="width:100px;margin:0 auto;height:25px;"><div style="width:100%;height:25x;line-height:25px;float:left;background-color:#aaa;text-align:center;cursor:pointer;" onmouseover="this.style.backgroundColor='#ccc';" onmouseout="this.style.backgroundColor='#aaa';" title="Click to add staff" onclick="add_more_new_etries();">Add more</div></div>

<div style="width:100%;height:auto;float:left;margin-top:10px;margin-bottom:10px;">
<div style="margin-left:5px;width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="finish_entries_button" onclick="add_new_entries();">Finish</div>
</div>

</div>

<script>
$('#tab_10').click();

</script>