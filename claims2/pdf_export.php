<?php

include 'scripts/short_connector.php';
require("scripts/fpdf.php");

$company_id = 1;

if(isset($_GET['m']) and isset($_GET['k']) and $_GET['k'] == 'hblhsbsrbefibuqpufubnslnlquigrw2187768'){
	$memo_date = $_GET['m'];
	
	$this_memo = mysqli_query($connect,"select * from memos where _date = '$memo_date' and company_id = $company_id")or die(mysqli_error($connect));
	
	
	$this_memo_results = mysqli_fetch_array($this_memo,MYSQLI_ASSOC);
	
	$memo_locations = explode("}",$this_memo_results['locations']);
		
		if($memo_locations[0] == ''){
			$region_location = '';
			
		}else{
			$location_ids = explode(',',$memo_locations[0]);
			
			$region_location = '';
			for($l=0;$l<count($location_ids);$l++){
				$this_location_id = $location_ids[$l];
				
				$this_location = mysqli_query($pipat_connect,"select * from regions where id = $this_location_id")or die(mysqli_error($pipat_connect));
				$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
				
				if($region_location == ''){
					$region_location = $this_location_results['title'];
					
				}else{
					$region_location .= ','.$this_location_results['title'];
					
				}
			}
		}
		
		if($memo_locations[1] == ''){
			$province_location = '';
			
		}else{
			$location_ids = explode(',',$memo_locations[1]);
			
			$province_location = '';
			for($l=0;$l<count($location_ids);$l++){
				$this_location_id = $location_ids[$l];
				
				$this_location = mysqli_query($pipat_connect,"select * from provinces where id = $this_location_id")or die(mysqli_error($pipat_connect));
				$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
				
				if($region_location == ''){
					$province_location = $this_location_results['title'];
					
				}else{
					$province_location .= ','.$this_location_results['title'];
					
				}
			}
		}
		
		if($memo_locations[2] == ''){
			$hub_location = '';
			
		}else{
			$location_ids = explode(',',$memo_locations[2]);
			
			$hub_location = '';
			for($l=0;$l<count($location_ids);$l++){
				$this_location_id = $location_ids[$l];
				
				$this_location = mysqli_query($pipat_connect,"select * from districts where id = $this_location_id")or die(mysqli_error($pipat_connect));
				$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
				
				if($region_location == ''){
					$hub_location = $this_location_results['title'];
					
				}else{
					$hub_location .= ','.$this_location_results['title'];
					
				}
			}
		}
		
		if($memo_locations[3] == ''){
			$site_location = '';
			
		}else{
			$location_ids = explode(',',$memo_locations[3]);
			
			$hub_location = '';
			for($l=0;$l<count($location_ids);$l++){
				$this_location_id = $location_ids[$l];
				
				$this_location = mysqli_query($pipat_connect,"select * from sites where id = $this_location_id")or die(mysqli_error($pipat_connect));
				$this_location_results = mysqli_fetch_array($this_location,MYSQLI_ASSOC);
				
				if($region_location == ''){
					$site_location = $this_location_results['title'];
					
				}else{
					$site_location .= ','.$this_location_results['title'];
					
				}
			}
		}
		$location_string = '';
		
		if($region_location != ''){
			$location_string .= 'Regions{'.$region_location.'}, ';
			
		}
		
		if($province_location != ''){
			$location_string .= 'Provinces{'.$province_location.'}, ';
			
		}
		
		if($hub_location != ''){
			$location_string .= 'Hubs{'.$hub_location.'}, ';
			
		}
		
		if($site_location != ''){
			$location_string .= 'Sites{'.$site_location.'}, ';
			
		}
		
		$staff = explode(',',$this_memo_results['staff']);
		
		$staff_string = '';
		for($s=0;$s<count($staff);$s++){
			$this_staff_id = $staff[$s];
			
			$this_staff = mysqli_query($pipat_connect,"select * from users where id = $this_staff_id")or die(mysqli_error($pipat_connect));
			$this_staff_results = mysqli_fetch_array($this_staff,MYSQLI_ASSOC);
			
			if($staff_string == ''){
				$staff_string = $this_staff_results['_name'];
				
			}else{
				$staff_string .= ','.$this_staff_results['_name'];
				
			}
			
		}
	
	if($_GET['a']){
		$letter = new FPDF("P","mm","A4");
		$letter -> SetTitle('PIPAT Bills Tracker - Activity Travel Authorization Form');
		$letter -> setSubject('PIPAT Bills Tracker - Activity Travel Authorization Form');
		$letter -> setAuthor("BlueRays Software");
		$letter -> setCreator("BlueRays Software");
		$letter -> setFont("Arial","",'9');
		$letter -> addPage();
		$letter -> setTopMargin(10);
		
		
		
		$letter -> setFont("Arial","",'6');
		$letter -> cell(0,5,'PIPAT - Bills Tracker V1.0',0,1,"R",0);
		$letter -> cell(0,5,'Copyrights - BlueRays Software',0,1,"R",0);
		
		$letter -> ln(2);
		$letter -> setFont("Arial","B",'13');
		$letter -> cell(187,5,'USAID DISCOVER HEALTH PROJECT',0,2,"C",0);
		$letter -> ln(2);
		$letter -> cell(187,5,'Activity Travel Authorization Form',0,2,"C",0);
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'1. BASIC INFORMATION',0,2,"l",0);
		
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'To:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['memo_to'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Date of Submission:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,date('jS M, Y',$this_memo_results['_date']),1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Activity title:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['title'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Objective:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['objective'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Budget code:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['budget_code'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Indicator:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['indicator'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Facilitators / Staff:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$staff_string,1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'TLAs:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['no_logistic_persons'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Locations:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$location_string,1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Departure date:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,date('jS M, Y',$this_memo_results['departure_date']),1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Return date:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,date('jS M, Y',$this_memo_results['return_date']),1,2,"l",0);
		
		
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'2. ACTIVITY / WORKSHOP DATES',0,2,"l",0);
		
		
		$activity_schedule = explode("|~",$this_memo_results['activity_schedule']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,4,'Date',1,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,'Activity',1,2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		for($a=0;$a<count($activity_schedule);$a++){
			$this_activity = explode("}~",$activity_schedule[$a]);
			$letter -> setx(10);
			$letter -> cell(50,4,date('jS M, Y',$this_activity[0]),"B",0,"l",0);
			$letter -> setx(62);		
			$letter -> cell(130,4,$this_activity[1],"B",2,"l",0);
		
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'3. STAFF TRAVEL REQUIREMENTS',0,2,"l",0);
		
		if($this_memo_results['lodging_requirements']){
			$loding_requirements = 'Yes';
			
		}else{
			$loding_requirements = 'No';
			
		}
		
		if($this_memo_results['driver_requirements']){
			$driver_requirements = 'Yes';
			
		}else{
			$driver_requirements = 'No';
			
		}
		
		if($this_memo_results['vehicle_requirements']){
			$vehicle_requirements = 'Yes';
			
		}else{
			$vehicle_requirements = 'No';
			
		}
		
		if($this_memo_results['mie_requirements']){
			$mie_requirements = 'Yes';
			
		}else{
			$mie_requirements = 'No';
			
		}
		
		$letter -> setx(10);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(50,4,'a) Lodging / Hotel Accommodation:',0,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,$loding_requirements,0,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(50,4,'b) Driver:',0,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,$driver_requirements,0,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(50,4,'c) Vehicle:',0,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,$vehicle_requirements,0,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(50,4,'d) M&IE:',0,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,$mie_requirements,0,2,"l",0);
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'4. ACTIVITY REQUIREMENTS',0,2,"l",0);
		
		$activity_requirements = explode("|~",$this_memo_results['activity_requirements']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(15,4,'Qty',1,0,"R",0);
		$letter -> setx(26);		
		$letter -> cell(15,4,'Days',1,0,"R",0);
		
		$letter -> setx(42);		
		$letter -> cell(98,4,'Description',1,0,"l",0);
		
		$letter -> setx(141);		
		$letter -> cell(25,4,'Unit(K)',1,0,"R",0);
		
		$letter -> setx(167);		
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		
		$letter -> setFont("Arial","",'8');
		for($a=0;$a<count($activity_requirements);$a++){
			$this_activity_requirement = explode('}~',$activity_requirements[$a]);
			
			$letter -> setx(10);
			$letter -> cell(15,4,$this_activity_requirement[0],'B',0,"R",0);
			$letter -> setx(26);		
			$letter -> cell(15,4,$this_activity_requirement[1],'B',0,"R",0);
			
			$letter -> setx(42);		
			$letter -> cell(98,4,$this_activity_requirement[2],'B',0,"l",0);
			
			$letter -> setx(141);		
			$letter -> cell(25,4,number_format($this_activity_requirement[3],2),'B',0,"R",0);
			
			$letter -> setx(167);		
			$letter -> cell(25,4,number_format($this_activity_requirement[4],2),'B',2,"R",0);
		
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'5. PARTICIPANTS',0,2,"l",0);
		$participants = explode("|~",$this_memo_results['participants']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(65,4,'Name',1,0,"L",0);
		$letter -> setx(76);		
		$letter -> cell(50,4,'Organization',1,0,"L",0);
		
		$letter -> setx(127);		
		$letter -> cell(42,4,'Location',1,0,"l",0);
		
		$letter -> setx(170);
		$letter -> cell(20,4,'CHW/GRZ',1,2,"L",0);
		
		$letter -> setFont("Arial","",'8');
		for($p=0;$p<count($participants);$p++){
			$this_participants = explode('}~',$participants[$p]);
			
			if($this_participants[3] == 0){
				$participant_title = 'CHW';
				
			}else if($this_participants[3] == 1){
				$participant_title = 'GRZ';
				
			}else{
				$participant_title = 'Staff';
				
			}
			
			$letter -> setx(10);
			$letter -> cell(65,4,$this_participants[0],"B",0,"L",0);
			$letter -> setx(76);		
			$letter -> cell(50,4,$this_participants[1],"B",0,"L",0);
			
			$letter -> setx(127);		
			$letter -> cell(42,4,$this_participants[2],"B",0,"l",0);
			
			$letter -> setx(170);
			$letter -> cell(20,4,$participant_title,"B",2,"L",0);
		
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'6. OFFICE SUPPLIES / STATIONARY',0,2,"l",0);		
		
		$office_requirements = explode("|~",$this_memo_results['office_requirements']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,4,'Qty',1,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,'Description',1,2,"l",0);
		
		if($this_memo_results['office_requirements'] != ''){
			$letter -> setFont("Arial","",'8');
			for($o=0;$o<count($office_requirements);$o++){
				$this_requirement = explode("}~",$office_requirements[$o]);
				$letter -> setx(10);
				$letter -> cell(50,4,$this_requirement[0],"B",0,"l",0);
				$letter -> setx(62);		
				$letter -> cell(130,4,$this_requirement[1],"B",2,"l",0);
			
			}
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'7. EQUIPMENT FOR USE / HIRE',0,2,"l",0);		
		
		$equipment_requirements = explode("|~",$this_memo_results['equipment_requirements']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,4,'Qty',1,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,'Description',1,2,"l",0);
		
		if($this_memo_results['equipment_requirements'] != ''){
			$letter -> setFont("Arial","",'8');
			for($e=0;$e<count($equipment_requirements);$e++){
				$this_equipment = explode("}~",$equipment_requirements[$e]);
				$letter -> setx(10);
				$letter -> cell(50,4,$this_equipment[0],"B",0,"l",0);
				$letter -> setx(62);		
				$letter -> cell(130,4,$this_equipment[1],"B",2,"l",0);
			
			}
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'8. MEDICAL COMMODITIES / CONSUMABLES',0,2,"l",0);		
		
		$medical_requirements = explode("|~",$this_memo_results['medical_requirements']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,4,'Qty',1,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,'Description',1,2,"l",0);
		
		if($this_memo_results['medical_requirements'] != ''){
		$letter -> setFont("Arial","",'8');
			for($m=0;$m<count($medical_requirements);$m++){
				$this_medical_requirement = explode("}~",$medical_requirements[$m]);
				$letter -> setx(10);
				$letter -> cell(50,4,$this_medical_requirement[0],"B",0,"l",0);
				$letter -> setx(62);		
				$letter -> cell(130,4,$this_medical_requirement[1],"B",2,"l",0);
			
			}
		}
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'9. OTHER REQUIREMENTS',0,2,"l",0);		
		
		$other_requirements = explode("|~",$this_memo_results['other_requirements']);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,4,'Qty',1,0,"l",0);
		$letter -> setx(62);		
		$letter -> cell(130,4,'Description',1,2,"l",0);
		
		if($this_memo_results['other_requirements'] != ''){
		$letter -> setFont("Arial","",'8');
			for($o=0;$o<count($other_requirements);$o++){
				$this_other_requirements = explode("}~",$other_requirements[$o]);
				$letter -> setx(10);
				$letter -> cell(50,4,$this_other_requirements[0],"B",0,"l",0);
				$letter -> setx(62);		
				$letter -> cell(130,4,$this_other_requirements[1],"B",2,"l",0);
			
			}
		}
		
		$memo_user_date = $this_memo_results['user_date'];
		
		$memo_user = mysqli_query($claims_connect,"select * from users where _date = '$memo_user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
		
		if(!mysqli_num_rows($memo_user)){
			$memo_user = mysqli_query($pipat_connect,"select * from users where _date = '$memo_user_date' and company_id = $company_id")or die(mysqli_error($claims_connect));
			
			$memo_user_results = mysqli_fetch_array($memo_user,MYSQLI_ASSOC);
			
			if($memo_user_results['district_id'] != 0){
				$memo_user_hub = $memo_user_results['district_id'];
				$this_hub = mysqli_query($pipat_connect,"select * from districts where id = $memo_user_hub")or die(mysqli_error($pipat_connect));
				$this_memo_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
				
			}else{
				$hub_title = '';
				
			}
			
		}else{
			$memo_user_results = mysqli_fetch_array($memo_user,MYSQLI_ASSOC);
			
			if($memo_user_results['hub_id'] != 0){
				$memo_user_hub = $memo_user_results['hub_id'];
				$this_hub = mysqli_query($pipat_connect,"select * from districts where id = $memo_user_hub")or die(mysqli_error($pipat_connect));
				$this_memo_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
				$hub_title = $this_memo_hub_results['title'];
				
			}else{
				$hub_title = '';
				
			}
		}
		
		if($memo_user_results['region_id'] != 0){
			$memo_user_region = $memo_user_results['region_id'];
			$this_region = mysqli_query($pipat_connect,"select * from regions where id = $memo_user_region")or die(mysqli_error($pipat_connect));
			$this_memo_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			
			$region_title = $this_memo_region_results['title'];
				
		}else{
			$region_title = '';
			
		}
		
		if($memo_user_results['province_id'] != 0){
			$memo_user_province = $memo_user_results['province_id'];
			$this_province = mysqli_query($pipat_connect,"select * from provinces where id = $memo_user_province")or die(mysqli_error($pipat_connect));
			$this_memo_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
			
			$province_title = $this_memo_province_results['title'];
				
		}else{
			$province_title = '';
			
		}
		
		if($memo_user_results['site_id'] != 0){
			$memo_user_site = $memo_user_results['site_id'];
			$this_site = mysqli_query($pipat_connect,"select * from sites where id = $memo_user_site")or die(mysqli_error($pipat_connect));
			$this_memo_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
			
			$site_title = $this_memo_site_results['title'];
				
		}else{
			$site_title = '';
			
		}
		
		if($region_title == ''){
			$memo_user_location_string = 'All regions';
			
		}else{
			$memo_user_location_string = 'Region: '.$region_title;
			
			if($province_title != ''){
				$memo_user_location_string .= ', Province: '.$province_title;
				
			}
			
			if($hub_title != ''){
				$memo_user_location_string .= ', Hub: '.$hub_title;
				
			}
			
			if($site_title != ''){
				$memo_user_location_string .= ', Site: '.$site_title;
				
			}
		}
		
		
		
		
		if($this_memo_results['approval_status']){
			$memo_approval_user_date = $this_memo_results['approval_user'];
			
			$memo_approval_user = mysqli_query($claims_connect,"select * from users where _date = '$memo_approval_user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
			
			
			$memo_approval_user_results = mysqli_fetch_array($memo_approval_user,MYSQLI_ASSOC);
			
			$memo_aproval_user = $memo_approval_user_results ['_name'];
			
			if($memo_approval_user_results ['responsibility'] == ''){
				$memo_aproval_user_position = '(Not defined)';
				
			}else{
				$memo_aproval_user_position = $memo_approval_user_results ['responsibility'];
			
			}
			
			
			
			if($memo_approval_user_results['region_id'] != 0){
				$memo_approval_user_region = $memo_approval_user_results['region_id'];
				$this_region = mysqli_query($pipat_connect,"select * from regions where id = $memo_approval_user_region")or die(mysqli_error($pipat_connect));
				$this_memo_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
				
				$region_title = $this_memo_region_results['title'];
					
			}else{
				$region_title = '';
				
			}
		
			if($memo_approval_user_results['province_id'] != 0){
				$memo_approval_user_province = $memo_approval_user_results['province_id'];
				$this_province = mysqli_query($pipat_connect,"select * from provinces where id = $memo_approval_user_province")or die(mysqli_error($pipat_connect));
				$this_memo_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
				
				$province_title = $this_memo_province_results['title'];
					
			}else{
				$province_title = '';
				
			}
			
			
			if($memo_approval_user_results['hub_id'] != 0){
				$memo_approval_user_hub = $memo_approval_user_results['hub_id'];
				$this_hub = mysqli_query($pipat_connect,"select * from districts where id = $memo_approval_user_hub")or die(mysqli_error($pipat_connect));
				$this_memo_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
				$hub_title = $this_memo_hub_results['title'];
				
			}else{
				$hub_title = '';
				
			}
			
			if($memo_approval_user_results['site_id'] != 0){
				$memo_approval_user_site = $memo_approval_user_results['site_id'];
				$this_site = mysqli_query($pipat_connect,"select * from sites where id = $memo_pproval_user_site")or die(mysqli_error($pipat_connect));
				$this_memo_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
				
				$site_title = $this_memo_site_results['title'];
					
			}else{
				$site_title = '';
				
			}
		
			if($region_title == ''){
				
				$memo_approval_user_location_string = 'All regions';
				
			}else{
				
				$memo_approval_user_location_string = 'Region: '.$region_title;
				
				if($province_title != ''){
					$memo_approval_user_location_string .= ', Province: '.$province_title;
					
				}
				
				if($hub_title != ''){
					$memo_approval_user_location_string .= ', Hub: '.$hub_title;
					
				}
				
				if($site_title != ''){
					$memo_approval_user_location_string .= ', Site: '.$site_title;
					
				}
			}
			
			
			
			
		}else{
			$memo_aproval_user = '';
			$memo_aproval_user_position = '';
			$memo_approval_user_location_string = '(Not yet defined)';
		}
		
		$letter -> ln(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'Travel Request Prepared by:',0,2,"l",0);	
		
		$letter -> ln(5);
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Name:",0,0,"l",0);
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$memo_user_results['_name'],"B",0,"l",0);
		
		
		$letter -> setx(96);
		$letter -> cell(20,4,"Signature:",0,0,"l",0);
		
		$letter -> setx(107);	
		$letter -> cell(40,4,"","B",2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Position:",0,0,"l",0);
		
		if($memo_user_results['responsibility'] == ''){
			$user_responsibility = '(Not defined)';
			
		}else{
			$user_responsibility = $memo_user_results['responsibility'];
			
		}
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$user_responsibility,0,2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Location:",0,0,"l",0);
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$memo_user_location_string,0,0,"l",0);
		
		$letter -> ln(10);
		$letter -> setx(10);
		$letter -> multicell(0,4,"I, as supervisor for the technical team carrying out this activity, concur with the travel and activity proposed herein and give authorisation for the activity budget to be prepared for approval by the relevant authorities:",0,"L",0);
		
		$letter -> ln(10);
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Name:",0,0,"l",0);
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$memo_aproval_user,"B",0,"l",0);
		
		$letter -> setx(96);
		$letter -> cell(20,4,"Signature:",0,0,"l",0);
		
		$letter -> setx(107);	
		$letter -> cell(40,4,"","B",2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Position:",0,0,"l",0);
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$memo_aproval_user_position,0,2,"l",0);
		
		
		
		$letter -> setFont("Arial","",'8');
		$letter -> setx(26);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(40,4,"Supervisor/Team leader",0,2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Location:",0,0,"l",0);
		
		$letter -> setx(26);	
		$letter -> cell(40,4,$memo_approval_user_location_string,0,2,"l",0);
		
		$letter -> setFont("Arial","",'8');
		$letter -> ln(15);
		$letter -> setFont("Arial","",'8');
		$letter -> setx(10);
		$letter -> cell(15,4,"Thanking you in advance",0,2,"l",0);		
		
		$letter -> output();
		
	}else{
		$this_budget = mysqli_query($connect,"select * from budgets where memo_date = '$memo_date' and company_id = $company_id")or die(mysqli_error($connect));
		$this_budget_results = mysqli_fetch_array($this_budget,MYSQLI_ASSOC);
		
		$budget_user_date = $this_budget_results['user_date'];
		$budget_user = mysqli_query($claims_connect,"select * from users where _date = '$budget_user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
		
		if(!mysqli_num_rows($budget_user)){
			$budget_user = mysqli_query($pipat_connect,"select * from users where _date = '$budget_user_date' and company_id = $company_id")or die(mysqli_error($pipat_connect));
		}
		
		$budget_user_results = mysqli_fetch_array($budget_user,MYSQLI_ASSOC);
		
		
		$participant_string = '';
		$participants = explode('|~',$this_memo_results['participants']);
		if(count($participants) == 1 and ($participants[0] == '')){
			$num_participants = 0;
			
		}else{
			
			$num_participants = count($participants);
			
			for($p=0;$p<count($participants);$p++){
			$this_participant = explode("}~",$participants[$p]);
			
			if($participant_string == ''){
				$participant_string = $this_participant[0].' ('.$this_participant[1].')';
				
			}else{
				$participant_string .= ', '.$this_participant[0].' ('.$this_participant[1].')';
				
			}
		}
		}
		
		
		$letter = new FPDF("P","mm","A4");
		$letter -> SetTitle('PIPAT Bills Tracker - Budget');
		$letter -> setSubject('PIPAT Bills Tracker - Budget');
		$letter -> setAuthor("BlueRays Software");
		$letter -> setCreator("BlueRays Software");
		$letter -> setFont("Arial","",'9');
		$letter -> addPage();
		$letter -> setTopMargin(10);
		
		$letter -> setFont("Arial","",'6');
		$letter -> cell(0,5,'PIPAT - Bills Tracker V1.0',0,1,"R",0);
		$letter -> cell(0,5,'Copyrights - BlueRays Software',0,1,"R",0);
		
		$letter -> ln(2);
		$letter -> setFont("Arial","B",'13');
		$letter -> cell(187,5,'USAID DISCOVER HEALTH PROJECT',0,2,"C",0);
		$letter -> ln(2);
		$letter -> cell(187,5,'Workshop / Meeting / Admin Budget',0,2,"C",0);
		
		$letter -> ln(5);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'1. WORKSHOP INFORMATION',0,2,"l",0);
		
		$letter -> cell(50,5,'Workshop title:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['title'].' - '.$this_memo_results['subject'].' - '.$this_memo_results['objective'],1,2,"l",0);
		
		$range_days = ceil(($this_memo_results['return_date'] - $this_memo_results['departure_date']) / 86400);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Date range:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,date('jS M, Y',$this_memo_results['departure_date']).' to '.date('jS M, Y',$this_memo_results['return_date']).' ('.$range_days.' days)',1,2,"l",0);
		
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Locations:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$location_string,1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Facilitators / Staff:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$staff_string,1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Technical in charge:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> cell(130,5,'',1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> cell(50,5,'Admin support:',1,0,"l",0);
		$letter -> setx(62);
		$letter -> cell(130,5,'',1,2,"l",0);
		
		$letter -> setx(10);
		
		$letter -> cell(50,5,'Number of participants:',1,0,"l",0);
		$letter -> setx(62);
		
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$num_participants,1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Activity number:',1,0,"l",0);
		$letter -> setx(62);
		
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$this_memo_results['budget_code'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Budget prepared by:',1,0,"l",0);
		$letter -> setx(62);
		
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,$budget_user_results['_name'],1,2,"l",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(50,5,'Date prepared:',1,0,"l",0);
		$letter -> setx(62);
		
		$letter -> setFont("Arial","",'8');
		$letter -> cell(130,5,date('jS M, Y',$this_budget_results['budget_date']),1,2,"l",0);
		
		$letter -> ln(5);
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'2. LODGING / FACILITIES',0,2,"l",0);
		$letter -> cell(187,5,'a) Meals / Refreshments',0,2,"l",0);
		
		$letter -> cell(55,4,'Name',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'People',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'Days',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Unit(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		$letter -> setFont("Arial","",'8');
		$meal_string = explode('~|',$this_budget_results['meal_string']);	
		for($m=0;$m<count($meal_string);$m++){
			$this_meal = explode("~}",$meal_string[$m]);
			$letter -> cell(55,5,$this_meal[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_meal[2],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,$this_meal[3],"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,number_format($this_meal[1],2),"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_meal[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['meal_total'],2),"B",2,"R",0);
		
		$letter -> ln(5);
		$letter -> setx(10);
		$letter -> cell(187,5,'b) Conference Facilities',0,2,"l",0);
		$letter -> cell(77,4,'Description',1,0,"l",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'Days',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Unit(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		
		if($this_budget_results['conference_string'] != ''){
			$conference_string = explode('~|',$this_budget_results['conference_string']);	
			for($c=0;$c<count($conference_string);$c++){
				$this_conference = explode("~}",$conference_string[$c]);
				$letter -> cell(77,5,$this_conference[0],"B",0,"l",0);
				$letter -> setx(89);
				$letter -> cell(20,5,$this_conference[2],"B",0,"R",0);
				$letter -> setx(111);
				$letter -> cell(25,5,number_format($this_conference[1],2),"B",0,"R",0);
				$letter -> setx(138);
				$letter -> cell(25,5,number_format($this_conference[3],2),"B",2,"R",0);		
				$letter -> setx(10);
			}
			$this_conference_total = $this_budget_results['conference_total'];
			
		}else{
			$this_conference_total = 0;
			
		}
		
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_conference_total,2),"B",2,"R",0);
		
		$letter -> ln(5);
		$letter -> setx(10);
		$letter -> cell(187,5,'c) Accommodation (Staff, Facilitators and Participants)',0,2,"l",0);
		$letter -> cell(55,4,'Name',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'People',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'Nights',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Unit(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$accommodation_string = explode('~|',$this_budget_results['accommodation_string']);	
		for($a=0;$a<count($accommodation_string);$a++){
			$this_accommodation = explode("~}",$accommodation_string[$a]);
			$letter -> cell(55,5,$this_accommodation[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_accommodation[2],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,$this_accommodation[3],"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,number_format($this_accommodation[1],2),"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_accommodation[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['accommodation_total'],2),"B",2,"R",0);
		
		
		$letter -> setx(10);
		$letter -> cell(187,5,'c) Distribution of funds for lodging/ facilities',0,2,"l",0);
		$letter -> cell(126,4,'Name',1,0,"l",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$distribution_string = explode('~|',$this_budget_results['distribution_string']);
		
		for($d=0;$d<count($distribution_string);$d++){
			$this_disribution = explode("~}",$distribution_string[$d]);
			$letter -> cell(126,5,$this_disribution[0],"B",0,"l",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_disribution[1],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['distribution_total'],2),"B",2,"R",0);
		
		$letter -> setx(10);
		$letter -> ln(5);
		
		$letter -> cell(153,5,'Total Lodging / Facilities',0,0,"R",0);
		$letter -> setx(168);
		//$letter -> setTextColor(255,255,255);
		$letter -> cell(23,5,'K'.number_format($this_budget_results['meal_total']+$this_budget_results['conference_total']+$this_budget_results['accommodation_total'],2),"B",2,"R",0);
		
		$letter -> setTextColor(0,0,0);
		$letter -> setFont("Arial","B",'8');
		$letter -> ln(5);
		$letter -> setx(10);
		$letter -> cell(187,5,'3. M&IE AND ALLOWANCES ',0,2,"l",0);
		$letter -> cell(187,5,'a) Staff',0,2,"l",0);
		
		$letter -> cell(55,4,'Name',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'Days',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'M&IE(K)',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Allowance(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Total(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$mie_string = explode('~|',$this_budget_results['staff_mie_string']);	
		for($m=0;$m<count($mie_string);$m++){
			$this_mie = explode("~}",$mie_string[$m]);
			$letter -> cell(55,5,$this_mie[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_mie[1],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,number_format($this_mie[2],2),"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,number_format($this_mie[3],2),"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_mie[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['staff_mie_total'],2),"B",2,"R",0);
		
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'b) Participants',0,2,"l",0);
		
		$letter -> cell(55,4,'Name',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'Days',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'M&IE(K)',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Allowance(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Total(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$participant_mie_string = explode('~|',$this_budget_results['participant_mie_string']);	
		for($m=0;$m<count($participant_mie_string);$m++){
			$this_mie = explode("~}",$participant_mie_string[$m]);
			$letter -> cell(55,5,$this_mie[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_mie[1],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,number_format($this_mie[2],2),"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,number_format($this_mie[3],2),"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_mie[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['participant_mie_total'],2),"B",2,"R",0);
		
		$letter -> setx(10);
		$letter -> ln(5);
		
		$letter -> cell(153,5,'Total M&IE and Allowances',0,0,"R",0);
		$letter -> setx(168);
		//$letter -> setTextColor(255,255,255);
		$letter -> cell(23,5,'K'.number_format($this_budget_results['staff_mie_total']+$this_budget_results['participant_mie_total'],2),"B",2,"R",0);
		
		$letter -> setTextColor(0,0,0);
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'4. TRANSPORT REFUNDS',0,2,"l",0);
		
		$letter -> cell(55,4,'Name',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'Distance(km)',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'Cost/km (K)',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Trips',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$refund_string = explode('~|',$this_budget_results['refund_string']);	
		for($r=0;$r<count($refund_string);$r++){
			$this_refund = explode("~}",$refund_string[$r]);
			$letter -> cell(55,5,$this_refund[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_refund[1],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,number_format($this_refund[2],2),"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,$this_refund[3],"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_refund[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['refund_total'],2),"B",2,"R",0);
		
		
		$letter -> setTextColor(0,0,0);
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'5 MISCELLANEOUS REQUIREMENTS',0,2,"l",0);
		
		$letter -> cell(55,4,'Item',1,0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,4,'Days',1,0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,4,'Qty',1,0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,4,'Unit(K)',1,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,4,'Amount(K)',1,2,"R",0);
		$letter -> setx(10);
		
		$letter -> setFont("Arial","",'8');
		$misc_string = explode('~|',$this_budget_results['misc_string']);	
		for($m=0;$m<count($misc_string);$m++){
			$this_misc = explode("~}",$misc_string[$m]);
			$letter -> cell(55,5,$this_misc[0],"B",0,"l",0);
			$letter -> setx(67);
			$letter -> cell(20,5,$this_misc[1],"B",0,"R",0);
			$letter -> setx(89);
			$letter -> cell(20,5,$this_misc[2],"B",0,"R",0);
			$letter -> setx(111);
			$letter -> cell(25,5,number_format($this_misc[3],2),"B",0,"R",0);
			$letter -> setx(138);
			$letter -> cell(25,5,number_format($this_misc[4],2),"B",2,"R",0);
			$letter -> setx(10);
		}
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_budget_results['misc_total'],2),"B",2,"R",0);
		
		
		
		if($this_memo_results['allocated_amount'] == 0){
			$allocated_amount = '';
			
		}else{
			$allocated_amount = number_format($this_memo_results['allocated_amount'],2);
		}
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> setTextColor(0,0,0);
		$letter -> cell(153,5,'6. AMOUNT ALLOCATED IN BUDGET FOR THE MONTH (K):',0,0,"R",0);
		$letter -> setx(168);
		
		$letter -> cell(23,5,$allocated_amount,"B",2,"R",0);
		
		$letter -> setx(10);
		$letter -> ln(5);
		
		$total_budget = $this_budget_results['meal_total']+$this_budget_results['conference_total']+$this_budget_results['accommodation_total']+$this_budget_results['staff_mie_total']+$this_budget_results['participant_mie_total']+$this_budget_results['refund_total']+$this_budget_results['misc_total'];
		
		$letter -> cell(153,5,'TOTAL ESTIMATED WORKSHOP COSTS (K):',0,0,"R",0);
		$letter -> setx(168);
		$letter -> setTextColor(255,255,255);
		$letter -> cell(23,5,number_format($total_budget,2),"B",2,"R",2);
		
		$balance = $this_memo_results['allocated_amount'] - $total_budget;
		
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> setTextColor(0,0,0);
		$letter -> cell(153,5,'BALANCE (K):',0,0,"R",0);
		$letter -> setx(168);
		
		if($this_memo_results['allocated_amount'] == 0){
			$budget_balance = '';
			
		}else{
			$budget_balance = number_format($balance,2);
			
		}
		
		$letter -> cell(23,5,$budget_balance,"B",2,"R",0);
		
		
		
		$letter -> setTextColor(0,0,0);
		$letter -> setx(10);
		$letter -> setFont("Arial","B",'8');
		$letter -> cell(187,5,'7. APPROVALS',0,2,"l",0);
		
		
		$letter -> cell(45,4,'Approver',1,0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'Signature',1,0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'Name',1,0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'Date',1,2,"L",0);
			
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> cell(45,4,'Technical in Charge:',"B",0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'',"B",0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'',"B",0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'',"B",2,"L",0);
		
		
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> cell(45,4,'DPD:',"B",0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'',"B",0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'',"B",0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'',"B",2,"L",0);
		
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> cell(45,4,'PA:',"B",0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'',"B",0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'',"B",0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'',"B",2,"L",0);
		
		
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> cell(45,4,'FAD:',"B",0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'',"B",0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'',"B",0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'',"B",2,"L",0);
		
		$letter -> setx(10);
		$letter -> ln(5);
		$letter -> cell(45,4,'PD:',"B",0,"l",0);
		$letter -> setx(57);
		$letter -> cell(30,4,'',"B",0,"L",0);
		$letter -> setx(89);
		$letter -> cell(40,4,'',"B",0,"L",0);
		$letter -> setx(131);
		$letter -> cell(25,4,'',"B",2,"L",0);
		
		$letter -> output();
	}
	
}else{
	print('Illegal access of claims spreadsheet. Contact PIPAT administrator');
}
?>