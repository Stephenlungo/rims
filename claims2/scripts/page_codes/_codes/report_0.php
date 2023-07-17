<div style="width:99.6%;height:auto;float:left;padding:2px;margin-top:10px;">
<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;font-size:1.2em;display:none;">Claims Status Report</div>
<?php
if($focus == 0){
	$focus_title = 'Regions';
	$query_table = 'regions';
	$table_column = 'region_id';
	
}else if($focus == 1){
	$focus_title = 'Provinces';
	$query_table = 'provinces';
	$table_column = 'province_id';
	
}else if($focus == 2){
	$focus_title = 'Hubs';
	$query_table = 'districts';
	$table_column = 'hub_id';
	
}else if($focus == 3){
	$focus_title = 'Sites';
	$query_table = 'sites';
	$table_column = 'site_id';
}

?>
<div style="width:100%;height:30px;float:left;line-height:30px;">
<div class="option_lebel" style="font-weight:bold;">Focus:</div>
<div style="width:auto;float:left;">
<div class="option_item" title="Click to change option" onclick="$('#focus_menu').toggle('fast');" id="active_focus" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';"><?php print($focus_title);?></div>

<div class="option_menu" id="focus_menu" style="display:none;z-index:1000">
<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#focus_menu').fadeOut('fast');$('#selected_focus').val(0);$('#active_focus').html($(this).html());fetch_report();" style="min-width:100px;">Regions</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#focus_menu').fadeOut('fast');$('#selected_focus').val(1);$('#active_focus').html($(this).html());fetch_report();" style="min-width:100px;">Provinces</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#focus_menu').fadeOut('fast');$('#selected_focus').val(2);$('#active_focus').html($(this).html());fetch_report();" style="min-width:100px;">Hubs</div>

<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#focus_menu').fadeOut('fast');$('#selected_focus').val(3);$('#active_focus').html($(this).html());fetch_report();" style="min-width:100px;">Sites</div>
<input type="hidden" id="selected_focus" value="<?php print($focus);?>">
</div>

</div>

<?php
$amended_memos = mysqli_query($connect,"select * from memos where company_id = $company_id and complete_status = 2")or die(mysqli_error($connect));

$amended_output = '';
for($a=0;$a<mysqli_num_rows($amended_memos);$a++){
	$amended_memo_results = mysqli_fetch_array($amended_memos,MYSQLI_ASSOC);
	
	if($amended_output == ''){
		$amended_output = 'd'.$amended_memo_results['_date'];
		
	}else{
		$amended_output .= ',d'.$amended_memo_results['_date'];
	}
}
?>

<div style="padding-left:4px;padding-right:4px;margin-top:7px;cursor:pointer;width:auto;float:right;text-align:center;height:20px;line-height:20px;background-color:#c33eaa;color:#fff;" onmouseout="this.style.backgroundColor='#c33eaa';" onmouseover="this.style.backgroundColor='purple';" title="Click to view these claims" onclick="<?php if(mysqli_num_rows($amended_memos)){?>window.open($('#url').val()+'?a=13&csearch=<?php print($amended_output.'&s='.$start_date.'&e='.$end_date);?>','_self'); <?php }else{?> alert('There are no amended claims to show');<?php }?>"><strong>Amended:</strong> <?php print(number_format(mysqli_num_rows($amended_memos)));?></div>
</div>

<div style="width:305px;height:20px;line-height:20px;float:left;background-color:#d8e7fd;">
<div style="width:160px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">Item Title</div>
<div style="width:50px;height:20px;line-height:20px;float:left;text-align:left;">Claims</div>

<div style="width:90px;height:20px;line-height:20px;float:left;text-align:right;">Amount(K)</div>

<?php
$regions = mysqli_query($pipat_connect,"select * from $query_table where company_id = $company_id order by title")or die(mysqli_error($pipat_connect));
$region_ids = '';
$region_totals = 0;
$region_total_amount = 0;
$last_level = 0;
for($r=0;$r<mysqli_num_rows($regions);$r++){
	$regions_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
	$this_region_id = $regions_results['id'];
	
	if($region_ids == ''){
		$region_ids = $this_region_id;
		
	}else{
		$region_ids .= ','.$this_region_id;
		
	}	
	
	$this_region_claims = mysqli_query($connect,"select * from memos where $table_column = $this_region_id and _date >= '$start_date' and _date <= '$end_date' and complete_status != 1")or die(mysqli_error($connect));

	$region_totals += mysqli_num_rows($this_region_claims);
	
	$this_region_amount = 0;
	for($c=0;$c<mysqli_num_rows($this_region_claims);$c++){
		$this_region_claims_results = mysqli_fetch_array($this_region_claims,MYSQLI_ASSOC);
		
		if($last_level < $this_region_claims_results['approval_level']){
			$last_level = $this_region_claims_results['approval_level'];
		
		}
	
		$this_region_amount += $this_region_claims_results['allocated_amount'];
		
	}
	$region_total_amount += $this_region_amount;
	
	
	if(strlen($regions_results['title']) > 20){
		$this_title = substr($regions_results['title'],0,20).'...';
						
	}else{
		$this_title = $regions_results['title'];
	}

	?>
	<div style="width:305px;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;">
	<div style="width:160px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;" title="<?php print($regions_results['title']);?>"><?php print($this_title);?></div>
	<div style="width:50px;height:20px;line-height:20px;float:left;text-align:right;" title="Total claims in <?php print($regions_results['title']);?>"><?php print(number_format(mysqli_num_rows($this_region_claims)));?></div>
	
	<div style="width:90px;height:20px;line-height:20px;float:left;text-align:right;" title="Total claims value in <?php print($regions_results['title']);?>"><?php print(number_format($this_region_amount,2));?></div>
	</div>
<?php
}

	$this_region_claims = mysqli_query($connect,"select * from memos where $table_column = 0 and _date >= '$start_date' and _date <= '$end_date' and complete_status != 1")or die(mysqli_error($connect));

	$region_totals += mysqli_num_rows($this_region_claims);
	
	$this_region_amount = 0;
	for($c=0;$c<mysqli_num_rows($this_region_claims);$c++){
		$this_region_claims_results = mysqli_fetch_array($this_region_claims,MYSQLI_ASSOC);
	
		$this_region_amount += 0;
		
		if($last_level < $this_region_claims_results['approval_level']){
			$last_level = $this_region_claims_results['approval_level'];
		
		}
		
	}
	$region_total_amount += $this_region_amount;
	
	
	if(strlen($regions_results['title']) > 20){
		$this_title = substr($regions_results['title'],0,20).'...';
						
	}else{
		$this_title = $regions_results['title'];
	}
	
	?>
	<div style="width:305px;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;">
	<div style="width:160px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;" title="Unspecified locations"><i>UNSPECIFIED</i></div>
	<div style="width:50px;height:20px;line-height:20px;float:left;text-align:right;" title="Total claims in <?php print($regions_results['title']);?>"><?php print(number_format(mysqli_num_rows($this_region_claims)));?></div>
	
	<div style="width:90px;height:20px;line-height:20px;float:left;text-align:right;" title="Total claims value in <?php print($regions_results['title']);?>"><?php print(number_format($this_region_amount,2));?></div>
	</div>

<div style="width:305px;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;font-weight:bold;border-bottom:solid 1px #000">
	<div style="width:160px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">TOTAL CLAIMS</div>
	<div style="width:50px;height:20px;line-height:20px;float:left;text-align:right;"><?php print($region_totals);?></div>
	
	<div style="width:90px;height:20px;line-height:20px;float:left;text-align:right;"></div>
</div>

<div style="width:305px;height:20px;line-height:20px;float:left;border-bottom:solid 1px #eee;font-weight:bold;border-bottom:solid 1px #000">
	<div style="width:160px;height:20px;line-height:20px;float:left;text-align:left;margin-left:2px;">TOTAL VALUES</div>
	<div style="width:50px;height:20px;line-height:20px;float:left;text-align:right;"></div>
	
	<div style="width:90px;height:20px;line-height:20px;float:left;text-align:right;">K<?php print(number_format($region_total_amount,2));?></div>
</div>
	
</div>

<div style="width:669px;height:auto;line-height:20px;float:left;margin-left:2px;overflow:auto;">
<div style="min-width:669px;width:<?php print(($last_level + 2) * 72);?>px;height:20px;line-height:20px;float:left;margin-left:2px;background-color:#d8e7fd;">

<?php
for($l=-1;$l<$last_level+1;$l++){
	$level_claims[$l] = 0;
?>

	<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;">Level <?php print($l+2);?></div>
	<?php
}
?>
</div>

<div style="width:<?php print(($last_level + 2) * 72);?>px;height:auto;line-height:20px;float:left;margin-left:2px;">

<?php 
$region_id_array = explode(",",$region_ids);
for($r=0;$r<count($region_id_array);$r++){
	$this_region_id = $region_id_array[$r];
	
	for($l=-1;$l<$last_level+1;$l++){
		$this_level = $l+1;
	
		$region_claims = mysqli_query($connect,"select * from memos where $table_column = $this_region_id and _date >= '$start_date' and _date <= '$end_date' and approval_level = $l and complete_status != 1")or die(mysqli_error($connect));
		
		
		$level_approvals[$l] = 0;
		$level_claim_titles[$l] = '';
		$level_amounts[$l] = 0;
		
		if(!isset($level_totals[$l])){
			$level_totals[$l] = 0;
			
		}
		
		if(!isset($level_amount_totals[$l])){
			$level_amount_totals[$l] = 0;
			
		}
		
		for($rc=0;$rc<mysqli_num_rows($region_claims);$rc++){
			$region_claims_results = mysqli_fetch_array($region_claims,MYSQLI_ASSOC);
			
			$level_approvals[$l]++;
			$level_totals[$l]++;
			
		
					$level_claim_titles[$l] = $region_claims_results['id'];
			
			$level_amounts[$l] += $region_claims_results['allocated_amount'];
			$level_amount_totals[$l] += $region_claims_results['allocated_amount'];
		}
	}
	
	for($l=-1;$l<$last_level+1;$l++){
		?>
		<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;border-bottom:solid 1px #eee;cursor:pointer;" title="<?php print('Level '.($l+1).': K'.number_format($level_amounts[$l],2).'.  Click to view these claims')?>" onclick="window.open($('#url').val()+'?a=13&csearch=<?php print($level_claim_titles[$l].'&s='.$start_date.'&e='.$end_date);?>','_self');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><?php print(number_format($level_approvals[$l],0));?></div>
	<?php
	}
}



for($l=-1;$l<$last_level+1;$l++){
	$this_level = $l+1;

	$region_claims = mysqli_query($connect,"select * from memos where $table_column = 0 and _date >= '$start_date' and _date <= '$end_date' and approval_level = $l and complete_status != 1")or die(mysqli_error($connect));
	
	$level_approvals[$l] = 0;
	$level_claim_titles[$l] = '';
	$level_amounts[$l] = 0;
	
	if(!isset($level_totals[$l])){
		$level_totals[$l] = 0;
		
	}
	
	if(!isset($level_amount_totals[$l])){
		$level_amount_totals[$l] = 0;
		
	}
	
	for($rc=0;$rc<mysqli_num_rows($region_claims);$rc++){
		$region_claims_results = mysqli_fetch_array($region_claims,MYSQLI_ASSOC);
		
		$level_approvals[$l]++;
		$level_totals[$l]++;
		
		
			if($level_claim_titles[$l] == ''){
				$level_claim_titles[$l] = $region_claims_results['id'];
				
			}else{
				$level_claim_titles[$l] .= ','.$region_claims_results['id'];
			}
		
		
			
		$level_amounts[$l] += 0;
		$level_amount_totals[$l] += 0;
	}
}

for($l=-1;$l<$last_level+1;$l++){
	?>
	<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;border-bottom:solid 1px #eee;cursor:pointer;" title="<?php print('Level '.($l+1).': K'.number_format($level_amounts[$l],2).'.  Click to view these claims')?>" onclick="window.open($('#url').val()+'?a=13&csearch=<?php print($level_claim_titles[$l].'&s='.$start_date.'&e='.$end_date);?>','_self');" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><?php print(number_format($level_approvals[$l],0));?></div>
<?php
}
	



	for($l=-1;$l<$last_level+1;$l++){
	?>
		<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;border-bottom:solid 1px #000;font-weight:bold;" title="<?php print('K'.number_format($level_amount_totals[$l],0));?>"><?php print(number_format($level_totals[$l],0));?></div>
	<?php
	}
	
	for($l=-1;$l<$last_level+1;$l++){
	?>
		<div style="width:70px;height:20px;line-height:20px;float:left;text-align:right;margin-left:2px;border-bottom:solid 1px #000;font-weight:bold;"><?php print('K'.number_format($level_amount_totals[$l],0));?></div>
	<?php
	}
?>
</div>
</div>
</div>