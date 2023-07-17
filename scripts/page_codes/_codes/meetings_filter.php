<div style="width:350px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">
			<input type="text" id="search_key_string" value="Enter meeting name or ID" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter meeting name or ID'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter meeting name or ID';this.style.color='#aaa';}" title="Enter meeting name or ID" onkeyup="if(event.keyCode == 13){fetch_meetings();}">
		
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
				
			<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="meeting_fetch_button" onclick="fetch_meetings()" title="Click to fetch report with specified options">Fetch</div>
		</div>