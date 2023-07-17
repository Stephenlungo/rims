<?php 
include '../scripts/page_codes/_codes/item_details.php';
include '../scripts/page_codes/_codes/agent_details.php';
include '../scripts/page_codes/_codes/image_uploader.php';

?>

<div style="width:99.5%;height:auto;float:left;padding:2px;">
	<div class="page_title" style="background-color:#c79a2c;cursor:pointer;line-height:20px;" title="Click to hide/show filter options" onclick="$('#claims_filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#c7bf6c';" onmouseout="this.style.backgroundColor='#c79a2c';">Payment claims</div>
	
	<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="claims_filter_options">
	
		<div style="width:1000px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
			<div style="width:300px;float:left;">
				<input type="text" id="payment_claim_search_key" value="Enter beneficiary name, phone number or Claim ID" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter beneficiary name, phone number or Claim ID'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter beneficiary name, phone number or Claim ID';this.style.color='#aaa';}" title="Enter claim number, beneficiary name or phone number. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {fetch_payment_claims();}">
			</div>
			
			<div style="width:auto;height:auto;float:left;" id="strict_0_holder">
				<div style="width:65px;height:30px;line-height:30px;float:left;margin-left:2px;color:#006bb3">Search for:</div>
				
				<div style="width:auto;min-height:30px;height:auto;float:left;">
					<div class="option_item" title="Click to change option" onclick="$('#strict_menu').toggle('fast');" id="active_strict" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:90px;max-width:280px;width:auto;">Claim number</div>
					
					<div class="option_menu" id="strict_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
						<div style="display:none;" class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(0);">All results</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(1);" title="This will ignore other filter options">Claim number</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(2);">Beneficiary name</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(3);">Phone number</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(4);">Creator</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(6);">District</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#strict_menu').toggle('fast');$('#active_strict').html($(this).html());$('#selected_strict').val(5);">Batch #</div>
						
						
					</div>
				</div>
				<input type="hidden" id="selected_strict" value="1">
				
			</div>
			
			<div style="width:120px;height:30px;line-height:30px;float:left;margin-left:2px;color:#006bb3">From (mm/dd/yyyy):</div>
			<div style="width:120px;height:30px;float:left;line-height:30px;"><input type="text" id="claim_search_date_from" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}"></div>
			
			<div style="width:105px;height:30px;line-height:30px;float:left;margin-left:10px;color:#006bb3">To (mm/dd/yyyy):</div>
			<div style="width:120px;height:30px;float:left;line-height:30px;">
			<input type="text" id="claim_search_date_to" style="width:100%;height:30px;" value="<?php print(date('m/d/Y',time()));?>" onfocus="if(this.value=='Click to add date'){this.value='';}" onfocusout="if(this.value==''){this.value='Click to add date';}"></div>
			
		</div>
		
		<div style="width:auto;height:auto;float:left;" id="unit_0_holder">
			<?php 
				$this_unit_id = $user_results['unit_id'];	
				if(!$this_unit_id){
					$this_unit_title = 'Select unit';
					$this_unit_id = -1;
					
				}else{
					$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));
					
					$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
					$this_unit_title = $this_unit_results['title'];
					
				}
			
			?>
		
			<div style="width:40px;height:30px;line-height:30px;float:left;color:#006bb3">Unit:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?> $('#unit_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change unit for this view'); <?php }?>" id="active_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>	
				
				<div class="option_menu" id="unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(-1);">All units</div>
				
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(0);">Multiple Units</div>
					
					<?php
					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));
					
					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){
						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);
						
						if($unit_menu_results['status'] == 0){
							$unit_status = ' [disabled]';
						}else{
							$unit_status = '';
						}
						
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_menu_results['title'].$unit_status);?></div>
						<?php
					}
					?>
					
				</div>
				
			</div>
			
			<input type="hidden" id="selected_unit" value="<?php print($this_unit_id);?>">
			
		</div>
		
		<div style="width:auto;height:auto;float:left;" id="claim_type_holder">
			<div style="width:80px;height:30px;line-height:30px;float:left;color:#006bb3">Claim type:</div>	<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#claim_type_menu').slideToggle('fast');" id="active_claim_type" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>
				
				<div class="option_menu" id="claim_type_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_menu').toggle('fast');$('#active_claim_type').html($(this).html());$('#selected_claim_type').val(0);">All claim types</div>
					
					<?php
					$claim_type_menu = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id and status = 1 order by title")or die(mysqli_error($$module_connect));
					
					for($t=0;$t<mysqli_num_rows($claim_type_menu);$t++){						$claim_type_menu_results = mysqli_fetch_array($claim_type_menu,MYSQLI_ASSOC);
					
					?><div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#claim_type_menu').toggle('fast');$('#active_claim_type').html($(this).html());$('#selected_claim_type').val(<?php print($claim_type_menu_results['_date']);?>);"><?php print($claim_type_menu_results['title']);?></div>
					
					<?php
					
					}
					
					?>
				</div>
			</div>
			<input type="hidden" id="selected_claim_type" value="0">
	
		<div style="width:auto;height:auto;float:left;" id="creator_selection_holder">
			<div style="width:65px;height:30px;line-height:30px;float:left;color:#006bb3">Creator:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#creator_menu').toggle('fast');" id="active_creator" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All creators</div>
				
				<div class="option_menu" id="creator_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creator_menu').toggle('fast');$('#active_creator').html($(this).html());$('#selected_creator').val(0);">All creators</div>
				
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creator_menu').toggle('fast');$('#active_creator').html($(this).html());$('#selected_creator').val(<?php print($user_results['id']);?>);"><?php print($user_results['_name']);?></div>
					
					<?php
					
					$this_users = mysqli_query($connect,"select * from users where id != $user_id order by _name")or die(mysqli_error($connect));
					
					for($u=0;$u<mysqli_num_rows($this_users);$u++){
						$this_user_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creator_menu').toggle('fast');$('#active_creator').html($(this).html());$('#selected_creator').val(<?php print($this_user_results['_date']);?>);"><?php print($this_user_results['_name']);?></div>
						
						<?php
					}
						?>
						
				</div>
			</div>
			<input type="hidden" id="selected_creator" value="0">
			
			<div style="cursor:pointer;width:30px;height:25px;float:left;margin-right:2px;text-align:center;line-height:25px;border:solid 1px #ccc;" class="fa fa-search" onmouseover="this.style.backgroundColor='purple';this.style.color='#fff';" onmouseout="this.style.backgroundColor='';this.style.color='#000';" title="Click to search users" onclick="$('#search_creator_selection_holder').slideDown('fast');$('#creator_selection_holder').hide('fast');"></div>
		</div>
		
			
		<div style="width:auto;height:auto;float:left;margin-right:5px;border:solid 1px purple;display:none;background-color:#fff5ff" id="search_creator_selection_holder">
		
			<div style="width:80px;height:30px;line-height:30px;float:left;color:#006bb3;margin-left:2px;">Search user:</div>
		
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<input type="text" style="height:25px;width:110px;margin-top:2px;" id="creator_users_search_key" onkeyup="if (event.keyCode == 13) {search_creator_users();}"></div>
			
			<div style="width:50px;cursor:pointer;height:30px;line-height:30px;float:left;margin-left:5px;text-align:center;background-color:purple;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#a921a9';" onmouseout="this.style.backgroundColor='purple';" onclick="search_creator_users();">Search</div>
			
			<div style="width:20px;height:30px;line-height:30px;float:left;text-align:center;background-color:#999;cursor:pointer;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#888';" onmouseout="this.style.backgroundColor='#999';" onclick="$('#search_creator_selection_holder').slideUp('fast');$('#creator_selection_holder').slideDown('fast');">X</div>
			
			<div style="width:270px;display:none;position:absolute;height:140px;border:solid 1px #aaa;margin-top:30px;background-color:#fff;" id="creator_search_result_holder">	<div style="width:100%;height:20px;float:left;background-color:#bf8dbf;color:#fff;text-align:center;">Search results</div>
			
			<div style="width:100%;height:120px;float:left;overflow:auto;" id="creator_search_results_holder"></div>
			</div>
		</div>
		
		</div>
			
		<div style="width:100%;height:auto;float:left;">
			<div style="width:60px;height:30px;line-height:30px;float:left;color:#006bb3">Region:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;" onclick="$('#new_user_error_message').hide('fast');">
				<?php
				$this_region_id = $user_results['region_id'];
				
				if($this_region_id){
					$this_region = mysqli_query($connect,"select * from regions where id = $this_region_id")or die(mysqli_error($connect));
					
					$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);			$this_region_title = $this_region_results['title'];
					
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
						?><div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1');"><?php print($location_menu_results['title']);?></div>
						
						<?php
					}
					?>
				</div>
			</div>
			<input type="hidden" id="selected_region" value="<?php print($this_region_id);?>">
		
				
			<div style="width:auto;height:auto;float:left;" id="province_holder">
				<div style="width:70px;height:30px;line-height:30px;float:left;color:#006bb3">Provinces:</div>
				
				<div style="width:auto;min-height:30px;height:auto;float:left;">
				<?php
					$this_province_id = $user_results['province_id'];
					
					if($this_province_id){
						$this_province = mysqli_query($connect,"select * from provinces where id = $this_province_id")or die(mysqli_error($connect));					
						$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);		$province_title = $this_province_results['title'];
						
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
						
						for($l=0;$l<mysqli_num_rows($location_menu);$l++){						$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
						?>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-sites-hub_id-{id}-site-1-1');"><?php print($location_menu_results['title']);?></div>
						
						<?php
						}
						?>
					</div>
				</div>
				
				<input type="hidden" id="selected_province" value="<?php print($this_province_id);?>">
			</div>
					
			<div style="width:auto;height:auto;float:left;" id="hub_holder">
				<div style="width:40px;height:30px;line-height:30px;float:left;color:#006bb3">Hub:</div>
				<div style="width:auto;min-height:30px;height:auto;float:left;">
				
					<?php
					$this_district_id = $user_results['hub_id'];
					
					if($this_district_id){
						$this_district = mysqli_query($connect,"select * from hubs where id = $this_district_id")or die(mysqli_error($connect));
						
						$this_district_results = mysqli_fetch_array($this_district,MYSQLI_ASSOC);			$district_title = $this_district_results['title'];
						
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
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','sites','hub_id',<?php print($location_menu_results['id']);?>,'site',1,1,'');"><?php print($location_menu_results['title']);?></div>

						<?php
						}
						?>
						
					</div>
				</div>
				<input type="hidden" id="selected_hub" value="<?php print($this_district_id);?>">
			</div>
			
			<div style="width:auto;height:auto;float:left;" id="site_holder1">
				<div style="width:40px;height:30px;line-height:30px;float:left;color:#006bb3">Site:</div>
				<div style="width:auto;min-height:30px;height:auto;float:left;">
				
					<?php
					$this_site_id = $user_results['site_id'];
					
					if($this_site_id){
						$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));
						
						$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);			$site_title = $this_site_results['title'];
						
					}else{
						$site_title = 'All sites';
						
					}
					
					if($this_district_id){
						$site_search = ' and hub_id = '.$this_district_id;
						
					}else{
						$site_search = ' ';
						
					}
					?>
					
					<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#site_menu').toggle('fast'); <?php }else{?> alert('You are not authorized to change site for this view');<?php }?>" id="active_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($site_title);?></div>

					<div class="option_menu" id="site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					
						<?php
						$location_menu = mysqli_query($connect,"select * from sites where company_id = $company_id $site_search order by title")or die(mysqli_error($connect));
						
						for($l=0;$l<mysqli_num_rows($location_menu);$l++){
							$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);
							
							?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_menu').toggle('fast');$('#active_site').html($(this).html());$('#selected_site').val(<?php print($location_menu_results['id']);?>);"><?php print($location_menu_results['title']);?></div>

						<?php
						}
						?>
						
					</div>
				</div>
				<input type="hidden" id="selected_site" value="<?php print($this_site_id);?>">
			</div>
			
			<div style="width:auto;height:auto;float:left;" id="creation_method_holder1">
				<div style="width:105px;height:30px;line-height:30px;float:left;color:#006bb3">Creation method:</div>
				<div style="width:auto;min-height:30px;height:auto;float:left;">
				
					<div class="option_item" title="Click to change option" onclick="$('#creation_method_menu').toggle('fast'); " id="active_creation_method" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All claims</div>

					<div class="option_menu" id="creation_method_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creation_method_menu').toggle('fast');$('#active_creation_method').html($(this).html());$('#selected_creation_method').val(0);">All claims</div>
							
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creation_method_menu').toggle('fast');$('#active_creation_method').html($(this).html());$('#selected_creation_method').val(1);">Automatic (Batches/Folders)</div>
							
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#creation_method_menu').toggle('fast');$('#active_creation_method').html($(this).html());$('#selected_creation_method').val(2);">Manual</div>
					</div>
				</div>
				<input type="hidden" id="selected_creation_method" value="0">
			</div>
		</div>
			
			<div style="width:auto;height:auto;float:left;" id="level_holder">
			<div style="width:40px;height:30px;line-height:30px;float:left;color:#006bb3">Level:</div>		<div style="width:auto;min-height:30px;height:auto;float:left;">
					<?php
					$claim_type_menu = mysqli_query($$module_connect,"select * from request_types where company_id = $company_id and status = 1 order by title")or die(mysqli_error($$module_connect));
					
					$higher_level = 1;
					
					for($t=0;$t<mysqli_num_rows($claim_type_menu);$t++){
						$claim_type_menu_results = mysqli_fetch_array($claim_type_menu,MYSQLI_ASSOC);$rule_string_array = explode(']',$claim_type_menu_results['rule_string']);
						
						if(count($rule_string_array) > $higher_level){
							$higher_level = count($rule_string_array);
						}
					}
					?>
					<div class="option_item" title="Click to change option" onclick="$('#level_menu').toggle('fast');" id="active_level" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All levels</div>
					
					<div class="option_menu" id="level_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_menu').toggle('fast');$('#active_level').html($(this).html());$('#selected_level').val(-1);">All levels</div>
						<?php
						for($l=0;$l<$higher_level;$l++){
							?>
							<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_menu').toggle('fast');$('#active_level').html($(this).html());$('#selected_level').val(<?php print($l);?>);">Level <?php print($l+1);?></div> 
							
						<?php 
						}
						?>		
					</div>
				</div>
				<input type="hidden" id="selected_level" value="-1">
			</div>
				
			<div style="width:auto;height:auto;float:left;" id="level_holder">
				<div style="width:120px;height:30px;line-height:30px;float:left;color:#006bb3">Level consideration:</div>
				
				<div style="width:auto;min-height:30px;height:auto;float:left;">
					<div class="option_item" title="Click to change option" onclick="$('#level_consideration_menu').toggle('fast');" id="active_level_consideration" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Beneficiaries</div>
					
					<div class="option_menu" id="level_consideration_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_consideration_menu').toggle('fast');$('#active_level_consideration').html($(this).html());$('#selected_level_consideration').val(0);">Beneficiaries</div>	
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#level_consideration_menu').toggle('fast');$('#active_level_consideration').html($(this).html());$('#selected_level_consideration').val(1);">Payment Claims</div>
					</div>
				</div>
				
				<input type="hidden" id="selected_level_consideration" value="-1">
				
				<div style="width:120px;height:30px;line-height:30px;float:left;color:#006bb3">Finance processed:</div>
				<div style="width:auto;min-height:30px;height:auto;float:left;">
					<div class="option_item" title="Click to change option" onclick="$('#finance_processed_menu').toggle('fast');" id="active_finance_processed" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All claims</div>
					
					<div class="option_menu" id="finance_processed_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#finance_processed_menu').toggle('fast');$('#active_finance_processed').html($(this).html());$('#selected_finance_processed').val(-1);">All claims</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#finance_processed_menu').toggle('fast');$('#active_finance_processed').html($(this).html());$('#selected_finance_processed').val(0);">Not processed</div>
						
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#finance_processed_menu').toggle('fast');$('#active_finance_processed').html($(this).html());$('#selected_finance_processed').val(1);">Processed</div>
					</div>
					<input type="hidden" id="selected_finance_processed" value="-1">
				</div>
				
			</div>
			
			
		<div style="width:auto;height:auto;float:left;" id="user_selection_holder">
			<div style="width:85px;height:30px;line-height:30px;float:left;color:#006bb3">Allocated to:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#allocation_menu').toggle('fast');" id="active_allocation" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All claims</div>
				
				<div class="option_menu" id="allocation_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
				
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val('-1');">All claims</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val(0);">[Unallocated claims]</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val('-2');">[Allocated to any user]</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val(<?php print($user_results['id']);?>);"><?php print($user_results['_name']);?></div>
					
					<?php
					
					$this_users = mysqli_query($connect,"select * from users where id != $user_id order by _name")or die(mysqli_error($connect));
					
					for($u=0;$u<mysqli_num_rows($this_users);$u++){
						$this_user_results = mysqli_fetch_array($this_users,MYSQLI_ASSOC);
						?>
						<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val(<?php print($this_user_results['id']);?>);"><?php print($this_user_results['_name']);?></div>
						
						<?php
					}
						?>
						
				</div>
			</div>
			<input type="hidden" id="selected_allocation" value="-1">
			
			<div style="cursor:pointer;width:30px;height:25px;float:left;margin-right:2px;text-align:center;line-height:25px;border:solid 1px #ccc;" class="fa fa-search" onmouseover="this.style.backgroundColor='purple';this.style.color='#fff';" onmouseout="this.style.backgroundColor='';this.style.color='#000';" title="Click to search users" onclick="$('#search_selection_holder').slideDown('fast');$('#user_selection_holder').slideUp('fast');"></div>
		</div>
			
		<div style="width:auto;height:auto;float:left;margin-right:5px;border:solid 1px purple;display:none;background-color:#fff5ff" id="search_selection_holder">
		
			<div style="width:80px;height:30px;line-height:30px;float:left;color:#006bb3;margin-left:2px;">Search user:</div>
		
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<input type="text" style="height:25px;width:110px;margin-top:2px;" id="allocation_users_search_key" onkeyup="if (event.keyCode == 13) {search_allocation_users(0);}"></div>
			
			<div style="width:50px;cursor:pointer;height:30px;line-height:30px;float:left;margin-left:5px;text-align:center;background-color:purple;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#a921a9';" onmouseout="this.style.backgroundColor='purple';" onclick="search_allocation_users(0);">Search</div>
			
			<div style="width:20px;height:30px;line-height:30px;float:left;text-align:center;background-color:#999;cursor:pointer;margin-right:2px;color:#fff;" onmouseover="this.style.backgroundColor='#888';" onmouseout="this.style.backgroundColor='#999';" onclick="$('#search_selection_holder').slideUp('fast');$('#user_selection_holder').slideDown('fast');">X</div>
			
			<div style="width:270px;display:none;position:absolute;height:140px;border:solid 1px #aaa;margin-top:30px;background-color:#fff;" id="agent_search_result_holder">	<div style="width:100%;height:20px;float:left;background-color:#bf8dbf;color:#fff;text-align:center;">Search results</div>
			
			<div style="width:100%;height:120px;float:left;overflow:auto;" id="search_results_holder"></div>
			</div>
		</div>
		
		<div style="width:auto;height:auto;float:left;">
			<div style="width:105px;height:30px;line-height:30px;float:left;color:#006bb3">Allocation colors:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#allocation_colors_menu').toggle('fast');" id="active_allocation_colors" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Show</div>
				
				<div class="option_menu" id="allocation_colors_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_colors_menu').toggle('fast');$('#active_allocation_colors').html($(this).html());$('#selected_allocation_colors').val(0);">Do not show</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_colors_menu').toggle('fast');$('#active_allocation_colors').html($(this).html());$('#selected_allocation_colors').val(1);">Show</div>
					
				</div>
			</div>
			<input type="hidden" id="selected_allocation_colors" value="1">	


			
			<div style="width:60px;height:30px;line-height:30px;float:left;color:#006bb3">Ordering:</div>
			
			<div style="width:auto;min-height:30px;height:auto;float:left;">
				<div class="option_item" title="Click to change option" onclick="$('#ordering_menu').toggle('fast');" id="active_ordering" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">Claim number [Ascending]</div>
				
				<div class="option_menu" id="ordering_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ordering_menu').toggle('fast');$('#active_ordering').html($(this).html());$('#selected_ordering').val(0);">Claim number [Ascending]</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ordering_menu').toggle('fast');$('#active_ordering').html($(this).html());$('#selected_ordering').val(1);">Claim number [Descending]</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ordering_menu').toggle('fast');$('#active_ordering').html($(this).html());$('#selected_ordering').val(2);">Claim amount [Ascending]</div>
					
					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#ordering_menu').toggle('fast');$('#active_ordering').html($(this).html());$('#selected_ordering').val(3);">Claim amount [Descending]</div>
					
				</div>
			</div>
			
			<input type="hidden" id="selected_ordering" value="0">
		</div>			
		
		
		
		
		<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_payment_claims();" title="Click to fetch report with specified options">Fetch</div>
	</div>
	
	<div class="general_menu_holder">
		<div style="width:auto;float:left;height:auto;background-color:#e19ca3;color:#fff;">
			<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_5" onclick="fetch_script('_codes/awaiting_creation.php?a=5','payment_claims',1);tab_item_change(5);active_agent_tab=5">Awaiting creation</div>
		</div>
		
		<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="fetch_script('_codes/payment_claim_list.php?a=3','payment_claims',1);tab_item_change(3);tab_item_change(3);active_agent_tab=3;">For amendment</div>
		
		<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="fetch_script('_codes/payment_claim_list.php?a=1','payment_claims',1);tab_item_change(1);active_agent_tab=1;">Pending</div>
		
		<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="fetch_script('_codes/payment_claim_list.php?a=2','payment_claims',1);tab_item_change(2);active_agent_tab=2">Completed</div>
		
		<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="fetch_script('_codes/payment_claim_list.php?a=0','payment_claims',1);tab_item_change(0);active_agent_tab=0">Disabled</div>
		
		<div style="width:auto;float:right;height:auto;background-color:#c9b1ce;color:#000;">
			<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_6" onclick="fetch_script('_codes/claim_schedules.php?a=6','payment_claims',1);tab_item_change(6);active_agent_tab=6" style="float:right;">Claim schedules</div>
			
			<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_4" onclick="fetch_script('_codes/processed_schedules.php?a=4','payment_claims',1);tab_item_change(4);active_agent_tab=4" style="float:right;width:140px;">Processed schedules</div>
		</div>
		
	</div>
	<input type="hidden" id="payment_claims_active" value="1">
	<div class="general_holder" id="payment_claims"></div>
</div>

<script>
	fetch_script('_codes/payment_claim_list.php?a=1','payment_claims',1);

	tab_item_change(1);

	$(function(){
		$( "#claim_search_date_from" ).datepicker();
		$( "#claim_search_date_to" ).datepicker();
	});
</script>