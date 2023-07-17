<div style="width:100%;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<div style="width:100%;float:left;">
<div style="width:90px;height:30px;line-height:30px;float:left;font-weight:bold;">From:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_report_day_menu').toggle('fast');" id="active_from_report_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>

<input type="hidden" id="date_from_report" value="">
<input type="hidden" id="date_to_report" value="">
<div class="option_menu" id="from_report_day_menu" style="display:none;">
<?php
if(date('j',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_report_day_menu').toggle('fast');$('#active_from_report_day').html($(this).html());$('#selected_from_report_day').val(<?php print($d);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($do);?></div>
		<?php
	}
	
}else{
	for($d=31;$d>0;$d--){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_report_day_menu').toggle('fast');$('#active_from_report_day').html($(this).html());$('#selected_from_report_day').val(<?php print($d);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_from_report_day" id="selected_from_report_day" value="">
</div>



<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_report_month_menu').toggle('fast');" id="active_from_report_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>


<div class="option_menu" id="from_report_month_menu" style="display:none;">
<?php



	for($m=1;$m<13;$m++){
		
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_report_month_menu').toggle('fast');$('#active_from_report_month').html($(this).html());$('#selected_from_report_month').val(<?php print($m);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($mo);?></div>
		<?php
	}

?>
</div>
<input type="hidden" name="selected_from_report_month" id="selected_from_report_month" value="">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#from_report_year_menu').toggle('fast');" id="active_from_report_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>


<div class="option_menu" id="from_report_year_menu" style="display:none;width:65px;">
<?php
	for($y=(date('Y',time()));$y>(date('Y',time()) - 5);$y--){
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#from_report_year_menu').toggle('fast');$('#active_from_report_year').html($(this).html());$('#selected_from_report_year').val(<?php print($y);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:50px;"><?php print($y);?></div>
	<?php
	}

?>
</div>
<input type="hidden" name="selected_from_report_year" id="selected_from_report_year" value="">
</div>

</div>





<div style="width:100%;float:left;">
<div style="width:90px;height:30px;line-height:30px;float:left;font-weight:bold;">To:</div>
<div style="line-height:30px;width:30px;height:30px;float:left;">Day:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_report_day_menu').toggle('fast');" id="active_to_report_day" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>


<div class="option_menu" id="to_report_day_menu" style="display:none;">
<?php

if(date('j',time()) < 15){
	for($d=1;$d<32;$d++){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		
	
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_report_day_menu').toggle('fast');$('#active_to_report_day').html($(this).html());$('#selected_to_report_day').val(<?php print($d);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($do);?></div>
		
		<?php
	}
}else{
	for($d=31;$d>0;$d--){
		if($d<10){
			$do='0'.$d;
		}else{
			$do = $d;
		}
		?>

	<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_report_day_menu').toggle('fast');$('#active_to_report_day').html($(this).html());$('#selected_to_report_day').val(<?php print($d);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($do);?></div>
	<?php
	}
}
?>
</div>
<input type="hidden" name="selected_to_report_day" id="selected_to_report_day" value="">
</div>

<div style="line-height:30px;width:40px;height:30px;float:left;">Month:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_report_month_menu').toggle('fast');" id="active_to_report_month" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>


<div class="option_menu" id="to_report_month_menu" style="display:none;">
<?php
	for($m=1;$m<13;$m++){
		if($m<10){
			$mo='0'.$m;
		}else{
			$mo = $m;
		}
		?>
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_report_month_menu').toggle('fast');$('#active_to_report_month').html($(this).html());$('#selected_to_report_month').val(<?php print($m);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:40px;"><?php print($mo);?></div>
	
		<?php
	}

?>
</div>
<input type="hidden" name="selected_to_report_month" id="selected_to_report_month" value="">
</div>

<div style="line-height:30px;width:32px;height:30px;float:left;">Year:</div>
<div style="width:50px;min-height:30px;height:auto;float:left;">

<div class="option_item" title="Click to change option" onclick="$('#to_report_year_menu').toggle('fast');" id="active_to_report_year" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"></div>


<div class="option_menu" id="to_report_year_menu" style="display:none;width:65px;">
<?php
for($y=(date('Y',time()));$y>(date('Y',time()) - 10);$y--){
	?>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#to_report_year_menu').toggle('fast');$('#active_to_report_year').html($(this).html());$('#selected_to_report_year').val(<?php print($y);?>);$('#date_from_report').val($('#selected_from_report_month').val()+'/'+$('#selected_from_report_day').val()+'/'+$('#selected_from_report_year').val());$('#date_to_report').val($('#selected_to_report_month').val()+'/'+$('#selected_to_report_day').val()+'/'+$('#selected_to_report_year').val());" style="width:50px;"><?php print($y);?></div>
<?php
}
?>
</div>
<input type="hidden" name="selected_to_report_year" id="selected_to_report_year" value="">
</div>

	</div>
	<div style="width:auto;height:auto;float:left;">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Date basis:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		
		<div class="option_item" title="Click to change option" onclick="$('#date_basis_report_menu').toggle('fast');" id="active_date_basis_report" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">Date of entry</div>

		<div class="option_menu" id="date_basis_report_menu" style="display:none;width:auto;width:150px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_basis_report_menu').toggle('fast');$('#active_date_basis_report').html($(this).html());$('#selected_date_basis_report').val(0);">Date of entry</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#date_basis_report_menu').toggle('fast');$('#active_date_basis_report').html($(this).html());$('#selected_date_basis_report').val(1);">Initiation date</div>
		</div>
		</div>
		<input type="hidden" id="selected_date_basis_report" value="0">
	</div>
	
	
	</div>



































<div style="width:100%;height:20px;margin-top:20px;float:left;">Select the type of entry errors you wish to fetch:</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="missing_age" onchange="if(this.checked){add_to_selection(1,'error_type_ids');}else{remove_from_selection(1,'error_type_ids');}"> <label for="missing_age">Any missing sex or age (or "weird" ages)</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="female_msm" onchange="if(this.checked){add_to_selection(2,'error_type_ids');}else{remove_from_selection(2,'error_type_ids');}"> <label for="female_msm">MSM who are female</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="male_fsw" onchange="if(this.checked){add_to_selection(3,'error_type_ids');}else{remove_from_selection(3,'error_type_ids');}"> <label for="male_fsw">FSW who are male</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="wrong_agyw" onchange="if(this.checked){add_to_selection(4,'error_type_ids');}else{remove_from_selection(4,'error_type_ids');}"> <label for="wrong_agyw">AGYW who are male or older than 24 years</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="earlier_initiation" onchange="if(this.checked){add_to_selection(5,'error_type_ids');}else{remove_from_selection(5,'error_type_ids');}"> <label for="earlier_initiation">The next pharmacy or Clinical date is earlier than the Initiation Date</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="same_clinical_visits" onchange="if(this.checked){add_to_selection(6,'error_type_ids');}else{remove_from_selection(6,'error_type_ids');}"> <label for="same_clinical_visits">Clinical visits 1 and 2 (any subsequent one) happened on the same date</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="earlier_date_of_entry" onchange="if(this.checked){add_to_selection(7,'error_type_ids');}else{remove_from_selection(7,'error_type_ids');}"> <label for="earlier_date_of_entry">The date of entry is earlier than the Initiation Date</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="date_of_entry_older_by_over_a_week" onchange="if(this.checked){add_to_selection(8,'error_type_ids');}else{remove_from_selection(8,'error_type_ids');}"> <label for="date_of_entry_older_by_over_a_week">The date of entry is 7 days later (or more) than the Initiation Date</label>
</div>

<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="wrong_follow_up_dates" onchange="if(this.checked){add_to_selection(9,'error_type_ids');}else{remove_from_selection(9,'error_type_ids');}"> <label for="wrong_follow_up_dates">Multiple follow-up clinical visits with same date</label>
</div>


<div style="width:100%;height:20px;line-heigth:20px;float:left;">
<input checked type="checkbox" id="duplicate_records" onchange="if(this.checked){add_to_selection(10,'error_type_ids');}else{remove_from_selection(10,'error_type_ids');}"> <label for="duplicate_records">Duplicate records (Name,Facility)</label>
</div>

<div style="width:100%;height:auto;float:left;margin-top:10px;">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Presentation:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;"  >
		
		<div class="option_item" title="Click to change option" onclick="$('#presentation_menu').toggle('fast');" id="active_presentation" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;">All errors types on one worksheet</div>

		<div class="option_menu" id="presentation_menu" style="display:none;width:auto;width:250px;">
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#presentation_menu').toggle('fast');$('#active_presentation').html($(this).html());$('#selected_presentation').val(1);">Each error type on separate worksheet</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#presentation_menu').toggle('fast');$('#active_presentation').html($(this).html());$('#selected_presentation').val(0);">All errors types on one worksheet</div>
		</div>
		</div>
		<input type="hidden" id="selected_presentation" value="0">
	</div>
	
	

<div style="margin-top:20px;width:90px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_error_report_button" onclick="process_error_report();" title="Click to fetch report with specified options">Fetch report</div>

<input type="hidden" id="error_type_ids" value="1,2,3,4,5,6,7,8,9,10">

<script>
$('#selected_from_report_day').val($('#selected_from_day').val());
$('#active_from_report_day').html($('#selected_from_day').val());

$('#selected_from_report_month').val($('#selected_from_month').val());
$('#active_from_report_month').html($('#selected_from_month').val());

$('#selected_from_report_year').val($('#selected_from_year').val());
$('#active_from_report_year').html($('#selected_from_year').val());

$('#selected_to_report_day').val($('#selected_to_day').val());
$('#active_to_report_day').html($('#selected_to_day').val());

$('#selected_to_report_month').val($('#selected_to_month').val());
$('#active_to_report_month').html($('#selected_to_month').val());

$('#selected_to_report_year').val($('#selected_to_year').val());
$('#active_to_report_year').html($('#selected_to_year').val());

$('#date_from_report').val($('#date_from').val());
$('#date_to_report').val($('#date_to').val());

$('#selected_date_basis_report').val($('#selected_date_basis').val());
$('#active_date_basis_report').html($('#active_date_basis').html());


</script>