<div style="width:350px;height:30px;margin:0 auto;margin-top:2px;margin-bottom:2px;">

		<input type="text" id="agent_search_key" value="Enter agent name, ID or phone number" style="width:100%;height:30px;color:#aaa;text-align:center;" onfocus="if(this.value=='Enter agent name, ID or phone number'){this.value='';this.style.color='#000';}" onfocusout="if(this.value==''){this.value='Enter agent name, ID or phone number';this.style.color='#aaa';}" title="Enter agent name, ID or phone number. You can search for multiple entries by separating each entry with a comma" onkeyup="if (event.keyCode == 13) {$('#tab_'+active_agent_tab).click();}">

	

	</div>



	<div style="width:auto;height:auto;float:left;" id="cluster_0_holder">

	<?php

	$this_branch_id = $user_results['branch_id'];

	if(!$this_branch_id){

		$this_branch_title = 'All clusters';

		$this_branch_id = 0;

		

	}else{

		$this_branch = mysqli_query($connect,"select * from branches where id = $this_branch_id")or die(mysqli_error($connect));

		$this_branch_results = mysqli_fetch_array($this_branch,MYSQLI_ASSOC);

		$this_branch_title = $this_branch_results['title'];

		

	}

	?>

			<div style="width:50px;height:30px;line-height:30px;float:left;">Cluster:</div>

			<div style="width:auto;min-height:30px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['branch_id']){?> $('#branch_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change this option'); <?php }?>" id="active_branch" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_branch_title);?></div>



			<div class="option_menu" id="branch_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(0);">All clusters</div>

				<?php

				

					$branch_menu = mysqli_query($connect,"select * from branches where company_id = $company_id order by title")or die(mysqli_error($connect));



					for($b=0;$b<mysqli_num_rows($branch_menu);$b++){

						$branch_menu_results = mysqli_fetch_array($branch_menu,MYSQLI_ASSOC);

						?>

					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#branch_menu').toggle('fast');$('#active_branch').html($(this).html());$('#selected_branch').val(<?php print($branch_menu_results['id']);?>);"><?php print($branch_menu_results['title']);?></div>

						<?php

					}

				?>

			</div>

			</div>

			<input type="hidden" id="selected_branch" value="<?php print($user_results['branch_id']);?>">

		</div>





	<div style="width:auto;height:auto;float:left;" id="unit_0_holder">

	<?php

	$this_unit_id = $user_results['unit_id'];

	if(!$this_unit_id){

		$this_unit_title = 'Select unit';

		$this_unit_id = 0;

		

	}else{

		$this_unit = mysqli_query($connect,"select * from units where id = $this_unit_id")or die(mysqli_error($connect));

		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);

		$this_unit_title = $this_unit_results['title'];

		

	}

	?>

			<div style="width:40px;height:30px;line-height:30px;float:left;">Unit:</div>

			<div style="width:auto;min-height:30px;height:auto;float:left;">

			<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['unit_id']){?> $('#unit_menu').toggle('fast'); <?php }else{?>  alert('You are not authorized to change unit for this view'); <?php }?>" id="active_unit" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_unit_title);?></div>



			<div class="option_menu" id="unit_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(0);">All units</div>

				<?php

				

					$unit_menu = mysqli_query($connect,"select * from units where company_id = $company_id order by title")or die(mysqli_error($connect));



					for($u=0;$u<mysqli_num_rows($unit_menu);$u++){

						$unit_menu_results = mysqli_fetch_array($unit_menu,MYSQLI_ASSOC);

						?>

					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#unit_menu').toggle('fast');$('#active_unit').html($(this).html());$('#selected_unit').val(<?php print($unit_menu_results['id']);?>);"><?php print($unit_menu_results['title']);?></div>

						<?php

					}

				?>

			</div>

			</div>

			<input type="hidden" id="selected_unit" value="<?php print($user_results['unit_id']);?>">

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



		<div class="option_menu" id="region_menu" style="display:none;width:auto;">

		

		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(0);fetch_menu_items('connect','provinces','region_id',0,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-sites-hub_id-{id}-site-1-1');">All Regions</div>

		

		<?php

			

			$location_menu = mysqli_query($connect,"select * from regions where company_id = $company_id order by title")or die(mysqli_error($connect));



			for($l=0;$l<mysqli_num_rows($location_menu);$l++){

				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);

				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#region_menu').toggle('fast');$('#active_region').html($(this).html());$('#selected_region').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','provinces','region_id',<?php print($location_menu_results['id']);?>,'province',1,1,'connect-hubs-province_id-{id}-hub-1-1|connect-mother_facilities-hub_id-{id}-mother_facility-1-1|connect-sites-mother_facility_id-{id}-site-1-1');"><?php print($location_menu_results['title']);?></div>

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

					<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#province_menu').toggle('fast');$('#active_province').html($(this).html());$('#selected_province').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','hubs','province_id',<?php print($location_menu_results['id']);?>,'district',1,1,'connect-sites-hub_id-{id}-site-1-1|connect-mother_facilities-hub_id-{id}-mother_facility-1-1|connect-sites-mother_facility_id-{id}-site-1-1');"><?php print($location_menu_results['title']);?></div>

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

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#hub_menu').toggle('fast');$('#active_hub').html($(this).html());$('#selected_hub').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','mother_facilities','hub_id',<?php print($location_menu_results['id']);?>,'mother_facility',1,1,'connect-sites-mother_facility_id-{id}-site-1-1');"><?php print($location_menu_results['title']);?></div>

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

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#mother_facility_menu').toggle('fast');$('#active_mother_facility').html($(this).html());$('#selected_mother_facility').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','sites','mother_facility_id',<?php print($location_menu_results['id']);?>,'sites',1,1,'');"><?php print($location_menu_results['title']);?></div>

				<?php

			}

		?>

		

		

		

		</div>

		</div>

		<input type="hidden" id="selected_mother_facility" value="<?php print($this_mother_facility_id);?>">

	</div>

		

	<div style="width:auto;height:auto;float:left;" id="site_holder">

		<div style="width:40px;height:30px;line-height:30px;float:left;">Site:</div>

		<div style="width:auto;min-height:30px;height:auto;float:left;">



			<?php

				$this_site_id = $user_results['site_id'];

				

				if($this_site_id){

					$this_site = mysqli_query($connect,"select * from sites where id = $this_site_id")or die(mysqli_error($connect));

					$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);

					$this_site_title = $this_site_results['title'];

					

				}else{

					$this_site_title = 'All Sites';

					

				}

				

				if($this_district_id){

					$site_search = ' and hub_id = '.$this_district_id;

					

				}else{

					$site_search = ' ';

					

				}

			?>

			

		

		<div class="option_item" title="Click to change option" onclick="<?php if(!$user_results['site_id']){?>$('#site_menu').toggle('fast');<?php }else{?> alert('You are not authorized to change site for his view'); <?php }?>" id="active_site" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;"><?php print($this_site_title);?></div>



		<div class="option_menu" id="site_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">

			<?php

			

			$location_menu = mysqli_query($connect,"select * from sites where company_id = $company_id $site_search order by title")or die(mysqli_error($connect));



			for($l=0;$l<mysqli_num_rows($location_menu);$l++){

				$location_menu_results = mysqli_fetch_array($location_menu,MYSQLI_ASSOC);

				?>

			<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#site_menu').toggle('fast');$('#active_site').html($(this).html());$('#selected_site').val(<?php print($location_menu_results['id']);?>);fetch_menu_items('connect','agents','site_id',<?php print($location_menu_results['id']);?>,'agent',1,1,'');"><?php print($location_menu_results['title']);?></div>

				<?php

			}

		?>

		</div>

		</div>

		<input type="hidden" id="selected_site" value="<?php print($this_site_id);?>">

	</div>
	
	<div style="width:auto;height:auto;float:left;" id="user_selection_holder">
	

		<div style="width:85px;height:30px;line-height:30px;float:left;">Allocated to:</div>

		<div style="width:auto;min-height:30px;height:auto;float:left;">

		<div class="option_item" title="Click to change option" onclick="$('#allocation_menu').toggle('fast');" id="active_allocation" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="min-width:110px;max-width:280px;width:auto;">All agents</div>



		<div class="option_menu" id="allocation_menu" style="display:none;min-width:150px;max-width:280px;width:auto;">
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val('-1');">All agents</div>
		
		<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#allocation_menu').toggle('fast');$('#active_allocation').html($(this).html());$('#selected_allocation').val(0);">[Unallocated agents]</div>
		
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
	
	<div style="width:270px;display:none;position:absolute;height:140px;border:solid 1px #aaa;margin-top:30px;background-color:#fff;" id="agent_search_result_holder">
	<div style="width:100%;height:20px;float:left;background-color:#bf8dbf;color:#fff;text-align:center;">Search results</div>
	
	<div style="width:100%;height:120px;float:left;overflow:auto;" id="search_results_holder"></div>
	
	</div>
	</div>
	

	<div style="width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="report_fetch_button" onclick="fetch_agent_validation_list();" title="Click to fetch report with specified options">Fetch</div>