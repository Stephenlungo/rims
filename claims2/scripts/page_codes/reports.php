<?php
include '_codes/item_details.php';
?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#c79a2c;cursor:pointer" title="Click to hide/show filter options" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c7bf6c';" onmouseout="this.style.backgroundColor='#c79a2c';">Dynamic Reports</div>

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none;" id="filter_options">
<div style="width:100%;height:auto;float:left;margin-bottom:10px;">
	<div style="width:300px;margin:0 auto;height:auto;">
			<div style="width:85px;height:30px;line-height:30px;float:left;">Preset report:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">
		
		<?php
			$default_report = mysqli_query($$module_connect,"select * from dynamic_reports where company_id = $company_id and default_report = 1 and (accessibility = 0 or accessibility = $user_id) order by accessibility desc")or die(mysqli_error($$module_connect));
			
			if(mysqli_num_rows($default_report)){
				$default_report_results = mysqli_fetch_array($default_report,MYSQLI_ASSOC);
				
				$this_report_id = $default_report_results['id'];
				$report_title = $default_report_results['title'];
				
			}else{
				$this_report_id = 0;
				$report_title = 'Create New';
				
			}
			
			?>
		
		<div class="option_item" title="Click to change option" onclick="$('#report_menu').toggle('fast');" id="active_report" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($report_title);?></div>

		<div class="option_menu" id="report_menu" style="display:none;width:auto;">		
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_menu').toggle('fast');$('#active_report').html($(this).html());$('#selected_report').val(0);$('#dynamic_report_settings_holder').html('');fetch_report(0);" id="report_button_0">Create New</div>
			
			<?php 
				$dynamic_reports = mysqli_query($$module_connect,"select * from dynamic_reports where company_id = $company_id and (accessibility = 0 or accessibility = $user_id)")or die(mysqli_error($$module_connect));
				
				for($r=0;$r<mysqli_num_rows($dynamic_reports);$r++){
					$dynamci_report_results = mysqli_fetch_array($dynamic_reports,MYSQLI_ASSOC);
					
					?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#report_menu').toggle('fast');$('#active_report').html($(this).html());$('#selected_report').val(<?php print($dynamci_report_results['id']);?>);fetch_report(1);$('#dynamic_report_settings_holder').html('');" id="report_button_<?php print($dynamci_report_results['id']);?>"><?php print($dynamci_report_results['title']);?></div>
					
					<?php
				}
				?>
		
		</div>
		</div>
		<input type="hidden" id="selected_report" value="<?php print($this_report_id);?>">
		</div>
	</div>
	<div style="width:900px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
	
	<div style="width:400px;float:left;">
		<input type="text" id="payment_claim_search_key" value="Enter search text here" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter results search text here'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter search text here';this.style.color='#aaa';}" title="Enter search text here" onkeyup="if (event.keyCode == 13) {fetch_payment_claims();}">
	</div>
	
		<div style="width:120px;height:30px;line-height:30px;float:left;margin-left:5px;">From (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_from" style="width:100%;height:30px;" value="<?php print(date('m/01/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;">To (mm/dd/yyyy):</div>
		<div style="width:120px;height:30px;float:left;line-height:30px;">
		<input type="text" id="date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}">
		</div>
		
		<div style="width:auto;height:auto;float:left;">
			<div style="width:60px;height:30px;line-height:30px;float:left;">Region:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
		
		<?php
		$this_region_id = $user_results['region_id'];
		if($this_region_id){
			$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$this_region_title = $this_region_results['title'];
		
		}else{
			$this_region_title = 'All Regions';
		}
		?>

		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['region_id']){?>$('#region_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change region for this view');<?php }?>" id="active_region" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:270px;width:auto;"><?php print($this_region_title);?></div>

		<div class="option_menu" id="region_menu" style="display:none;width:auto;width:120px;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1');">All Regions</div>
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-users-hub_id-{id}-user-1-1');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_region" value="<?php print($this_region_id);?>">
		</div>
		
		
		<div style="width:auto;height:auto;float:left;" id="province_holder">
			<div style="width:70px;height:30px;line-height:30px;float:left;">Provinces:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">

			
			<?php
				$this_province_id = $user_results['province_id'];
				
				if($this_province_id){
					$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));
					$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
					
					$province_title = $this_province_results['title'];
					
				}else{
					$province_title = 'All Provinces';
					
				}
				
				if($this_region_id){
					$province_search = ' and region_id = '.$this_region_id;
					
				}else{
					$province_search = ' ';
					
				}
			?>
				
			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['province_id']){?>$('#province_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change province for this view'); <?php }?>" id="active_province" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($province_title);?></div>

			<div class="option_menu" id="province_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				<?php
				
					$location_menu = mysqli_query($connect,"select * from provinces where company_id = $company_id $province_search order by title")or die(mysqli_error($connect));

					for($l=0;$l<mysqli_num_rows($location_menu);$l++){
						$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
						?>
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-users-hub_id-{id}-user-1-1');"><?php print($location_menu_results['title']);?></div>
						<?php
					}
				?>
			</div>
			</div>
			<input type="hidden" id="selected_province" value="<?php print($this_province_id);?>">
		</div>
	
	<div style="width:auto;height:auto;float:left;" id="hub_holder">
		<div style="width:40px;height:30px;line-height:30px;float:left;">Hub:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				$this_district_id = $user_results['hub_id'];
				
				if($this_district_id){
					$this_district = mysqli_query($connect,"select * from hubs where id = $this_district_id")or die(mysqli_error($connect));
					$this_district_results = mysqli_fetch_array($this_district,MYSQLI_ASSOC);
					
					$district_title = $this_district_results['title'];
	
				}else{
					$district_title = 'All Hubs';
					
				}
				
				if($this_province_id){
					$district_search = ' and province_id = '.$this_province_id;
					
				}else{
					$district_search = ' ';
					
				}
			?>
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['hub_id']){?>$('#hub_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change hub for this view');<?php }?>" id="active_hub" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($district_title);?></div>

		<div class="option_menu" id="hub_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from hubs where company_id = $company_id $district_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','users','hub_id',<?php print($location_menu_results['id']);?>,'user',1,1,'');"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		
		
		
		</div>
		</div>
		<input type="hidden" id="selected_hub" value="<?php print($this_district_id);?>">
	</div>
		
	<div style="width:auto;height:auto;float:left;" id="user_holder">
		<div style="width:40px;height:30px;line-height:30px;float:left;">User:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php				
				if($this_district_id){
					$user_search = ' and hub_id = '.$this_district_id;
					
				}else{
					$site_search = ' ';
					
				}
			?>
			
		
		<div class="option_item" title="Click to change option" onclick="$('#user_menu').toggle('fast');" id="active_user" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Select user</div>

		<div class="option_menu" id="user_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<?php
			
			$location_menu = mysqli_query($connect,"select * from users where company_id = $company_id $site_search order by _name")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#user_menu').toggle('fast');$('#active_user').html($(this).html());$('#selected_user').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['_name']);?></div>
				<?php
			}
		?>
		</div>
		</div>
		<input type="hidden" id="selected_user" value="0">
	</div>
	
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="$('#filter_options').slideUp('fast');if($('#dynamic_report_settings_holder').html() == ''){fetch_report(1);}else{fetch_report(0);}" title="Click to fetch report with specified options">Fetch</div>
	
	
	
	</div>
	</div>
	
	
	<div class="general_menu_holder">
	<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="tab_item_change(2);active_agent_tab=2;if($('#dynamic_report_settings_holder').html() == ''){fetch_report(1);}else{fetch_report(0);}$('#filter_options').slideUp('fast');">Report</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="tab_item_change(3);active_agent_tab=3;fetch_report_settings();$('#filter_options').slideUp('fast');">Settings</div>


<div style="float:right" class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="tab_item_change(4);active_agent_tab=4;fetch_report_advanced_settings();$('#filter_options').slideUp('fast');">Advanced</div>

</div>
<input type="hidden" id="payment_claims_active" value="1">
<div style="width:975px;min-height:500px;max-height:1200px;overflow:auto;float:left;">
<div class="general_holder" id="dynamic_report_holder" style="display:none;min-width:975px"></div>



<div class="general_holder" id="dynamic_report_settings_holder" style="display:none"></div>
<div class="general_holder" id="advanced_dynamic_report_settings_holder" style="display:none"></div>
</div>
<script>
fetch_report(1);
//fetch_report_advanced_settings();tab_item_change(4);active_agent_tab=4;
$( function() {
	$( "#date_from" ).datepicker();
	$( "#date_to" ).datepicker();
} );
</script>