
	<div style="width:350px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
		<input type="text" id="search_key" value="Enter title, ID or code" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter title, ID or code'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter title, ID or code';this.style.color='#aaa';}" title="Enter title, ID or code. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13){fetch_script('_codes/'+$('#active_location_code').val()+'.php','locations');}">
	
	</div>
	
		<div style="width:auto;height:auto;float:left;">
			<div style="width:50px;height:30px;line-height:30px;float:left;">Status:</div>
			<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#status_menu').toggle('fast');" id="active_status" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Active items</div>

			<div class="option_menu" id="status_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val('');">All items</div>
			
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(1);">Active items</div>
				
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#status_menu').toggle('fast');$('#active_status').html($(this).html());$('#selected_status').val(0);">Inactive items</div>
				
				
			</div>
			</div>
			<input type="hidden" id="selected_status" value="1">
		</div>

<div style="width:auto;height:auto;float:left;" id="region_holder">
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

		<div class="option_menu" id="region_menu" style="display:none;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1');">All Regions</div>
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-mother_facilities-hub_id-{id}-mother_facility-1-1');"><?php print($location_menu_results['title']);?></div>
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
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-sites-hub_id-{id}-site-1-1|connect-agents-site_id-{id}-agent-1-1');"><?php print($location_menu_results['title']);?></div>
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
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		
		
		
		</div>
		</div>
		<input type="hidden" id="selected_hub" value="<?php print($this_district_id);?>">
	</div>
	
	<div style="width:auto;height:auto;float:left;" id="mother_facility_holder">
		<div style="width:90px;height:30px;line-height:30px;float:left;">Mother facility:</div>
		<div style="width:auto;min-height:30px;height:auto;float:left;">

			<?php
				$this_mother_facility_id = $user_results['mother_facility_id'];
				
				if($this_mother_facility_id){
					$this_mother_facility = mysqli_query($connect,"select * from mother_facilities where id = $this_mother_facility_id")or die(mysqli_error($connect));
					$this_mother_facility_results = mysqli_fetch_array($this_mother_facility,MYSQLI_ASSOC);
					
					$mother_facility_title = $this_mother_facility_results['title'];
	
				}else{
					$mother_facility_title = 'All Mother Facilities';
					
				}
				
				if($this_mother_facility_id){
					$mother_facility_search = ' and hub_id = '.$this_district_id;
					
				}else{
					$mother_facility_search = ' ';
					
				}
			?>
		
		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['mother_facility_id']){?>$('#mother_facility_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change this menu');<?php }?>" id="active_mother_facility" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($mother_facility_title);?></div>

		<div class="option_menu" id="mother_facility_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<?php
			
			$location_menu = mysqli_query($connect,"select * from mother_facilities where company_id = $company_id $mother_facility_search order by title")or die(mysqli_error($connect));

			for($l=0;$l<mysqli_num_rows($location_menu);$l++){
				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
				?>
			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_menu').toggle('fast');$('#active_mother_facility').html($(this).html());$('#selected_mother_facility').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['title']);?></div>
				<?php
			}
		?>
		
		
		
		</div>
		</div>
		<input type="hidden" id="selected_mother_facility" value="<?php print($this_mother_facility_id);?>">
	</div>
	
	
	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_script('_codes/'+$('#active_location_code').val()+'.php','locations');" title="Click to fetch report with specified options">Fetch</div>