<?php
//include 'scripts/functions.php';
include 'scripts/connector.php';
@require("scripts/fpdf.php");

if(isset($_GET['s']) and isset($_GET['k']) and $_GET['k'] == 'hblhsbsrbefibuqpufubnslnlquigrw2187768'){
	
	$claim_date = $_GET['ci'];
	$company_id = $_GET['comp'];
	$user_date = $_GET['u'];
	$beneficiary_id_string = $_GET['b'];
	
	$this_default_partition_name = $default_partition_names[7][1][0];
	$this_default_beneficiaries_partition_name = $default_partition_names[7][1][1];
	$this_default_ascension_partition_name = $default_partition_names[7][1][2];

	$partitions = fetch_database_partitions(7,$claim_date,$claim_date);
	
	$payment_claims_table = $this_default_partition_name.'_partition_'.$partitions[0];
	
	$claim_beneficiaries_table = $this_default_beneficiaries_partition_name.'_partition_'.$partitions[0];
	
	$claim_ascension_table = $this_default_ascension_partition_name.'_partition_'.$partitions[0];
	
	$this_default_approval_partition_name = $default_partition_names[8][1][0];
	
	$approval_partitions = fetch_database_partitions(8,$claim_date,$claim_date);
	
	$approvals_table = $this_default_approval_partition_name.'_partition_'.$approval_partitions[0];
	
	$this_claim = mysqli_query($$module_connect,"select * from $payment_claims_table where _date = '$claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
	$this_claim_results = mysqli_fetch_array($this_claim,MYSQLI_ASSOC);
	
	$claim_id = $this_claim_results['id'];
	
	$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Z');
	$ascension_index = $_GET['asc'];
	
	if($_GET['asc_type'] == 1){
		$claim_number = $this_claim_results['claim_id'].$alphabet[$_GET['asc']].' (RETURNED)';
		
	}else{
		$claim_number = $this_claim_results['claim_id'].$alphabet[$_GET['asc']];
		
	}
	
	
	
	$this_claim_date = $this_claim_results['_date'];
	$claim_beneficiaries = mysqli_query($$module_connect,"select * from $claim_beneficiaries_table where claim_date = '$this_claim_date' and company_id = $company_id")or die(mysqlI_error($$module_connect));
	
	$beneficiary_type_date_array = array();
	$beneficiary_type_date_array = array();
	$beneficiary_region_id_array = array();
	$beneficiary_province_id_array = array();
	$beneficiary_hub_id_array = array();
	$beneficiary_site_id_array = array();
	$beneficiary_name_array = array();
	$beneficiary_phone_array = array();
	$beneficiary_nrc_array = array();
	$beneficiary_days_array = array();
	$beneficiary_paid_days_array = array();
	$beneficiary_rate_array = array();
	$beneficiary_amount_array = array();
	$beneficiary_comment_array = array();
	$beneficiary_from_array = array();
	$beneficiary_to_array = array();
	$beneficiary_level_array = array();		
	$beneficiary_agent_date_array = array();
	$beneficiary_id_array = array();
	
	for($b=0;$b<mysqli_num_rows($claim_beneficiaries);$b++){
		$claim_beneficiary_results = mysqli_fetch_array($claim_beneficiaries,MYSQLI_ASSOC);		
		
		$beneficiary_type_date_array[$b] = $claim_beneficiary_results['type_date'];
		$beneficiary_region_id_array[$b] = $claim_beneficiary_results['region_id'];
		$beneficiary_province_id_array[$b] = $claim_beneficiary_results['province_id'];
		$beneficiary_hub_id_array[$b] = $claim_beneficiary_results['hub_id'];
		$beneficiary_site_id_array[$b] = $claim_beneficiary_results['site_id'];
		$beneficiary_name_array[$b] = $claim_beneficiary_results['_name'];
		$beneficiary_phone_array[$b] = $claim_beneficiary_results['phone'];
		$beneficiary_nrc_array[$b] = $claim_beneficiary_results['nrc'];
		$beneficiary_days_array[$b] = $claim_beneficiary_results['days'];
		$beneficiary_paid_days_array[$b] = $claim_beneficiary_results['paid_days'];
		$beneficiary_rate_array[$b] = $claim_beneficiary_results['rate'];
		$beneficiary_amount_array[$b] = $claim_beneficiary_results['amount'];
		$beneficiary_comment_array[$b] = $claim_beneficiary_results['comment'];
		$beneficiary_from_array[$b] = $claim_beneficiary_results['_from'];
		$beneficiary_to_array[$b] = $claim_beneficiary_results['_to'];
		$beneficiary_level_array[$b] = $claim_beneficiary_results['level'];
		$beneficiary_agent_date_array[$b] = $claim_beneficiary_results['agent_date'];
		$beneficiary_id_array[$b] = $claim_beneficiary_results['id'];
	}
	
	$claim_users = mysqli_query($connect,"select * from users where company_id = $company_id")or die(mysqli_error($connect));
	
	$claim_user_name_array = array();
	$claim_user_id_array = array();
	$claim_user_date_array = array(); 
	$claim_user_phone_array = array(); 
	for($cu=0;$cu<mysqli_num_rows($claim_users);$cu++){
		$claim_user_results = mysqli_fetch_array($claim_users,MYSQLI_ASSOC);
		$claim_user_date[$cu] = $claim_user_results['_date'];
		
		$claim_user_name_array[$cu] = $claim_user_results['_name'];
		$claim_user_id_array[$cu] = $claim_user_results['id'];
		$claim_user_date_array[$cu] = $claim_user_results['_date'];
		$claim_user_phone_array[$cu] = $claim_user_results['phone'];
	}
	
	$approvals = mysqli_query($$module_connect,"select * from $approvals_table where claim_date = '$this_claim_date' and company_id = $company_id and status = 1 order by level")or die(mysqli_error($$module_connect));
	
	$approval_user_date_array = array();
	$approval_date_array = array();
	$approval_level_array = array();
	$approval_claim_type_date_array = array();
	$approval_beneficiary_array = array();
	for($a=0;$a<mysqli_num_rows($approvals);$a++){
		$approval_results = mysqli_fetch_array($approvals,MYSQLI_ASSOC);
		
		$approval_user_date_array[$a] = $approval_results['user_date'];
		$approval_date_array[$a] = $approval_results['_date'];
		$approval_level_array[$a] = $approval_results['level'];
		$approval_claim_type_date_array[$a] = $approval_results['type_date'];
		$approval_beneficiary_array[$a] = $approval_results['beneficiary_date'];
		
	}
	
	$this_claim_user_date = $this_claim_results['user_date'];
	$this_user = mysqli_query($connect,"select * from users where _date = '$this_claim_user_date' and company_id = $company_id")or die(mysqli_error($connect));
	$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
	
	$sites = mysqli_query($connect,"select * from sites where company_id = $company_id")or die(mysqli_error($connect));
	
	$site_id_array = array();
	$site_title_array = array();
	$site_hub_array = array();
	$site_province_array = array();
	$site_region_array = array();	
	for($s=0;$s<mysqli_num_rows($sites);$s++){
		$site_results = mysqli_fetch_array($sites,MYSQLI_ASSOC);
		
		$site_id_array[$s] = $site_results['id'];
		$site_title_array[$s] = $site_results['title'];
		$site_hub_array[$s] = $site_results['hub_id'];
		$site_province_array[$s] = $site_results['province_id'];
		$site_region_array[$s] = $site_results['region_id'];
	}
	
	
	$hubs = mysqli_query($connect,"select * from hubs where company_id = $company_id")or die(mysqli_error($connect));
	
	$hub_id_array = array();	
	$hub_title_array = array();	
	$hub_province_array = array();
	$hub_region_array = array();	
	for($h=0;$h<mysqli_num_rows($hubs);$h++){
		$hub_results = mysqli_fetch_array($hubs,MYSQLI_ASSOC);
		
		$hub_id_array[$h] = $hub_results['id'];		
		$hub_title_array[$h] = $hub_results['title'];		
		$hub_province_array[$h] = $hub_results['province_id'];
		$hub_region_array[$h] = $hub_results['region_id'];
	}
	
	$provinces = mysqli_query($connect,"select * from provinces where company_id = $company_id")or die(mysqli_error($connect));
	
	$province_id_array = array();	
	$province_title_array = array();	
	$province_region_array = array();	
	for($p=0;$p<mysqli_num_rows($provinces);$p++){
		$province_results = mysqli_fetch_array($provinces,MYSQLI_ASSOC);
		
		$province_id_array[$p] = $province_results['id'];
		$province_title_array[$p] = $province_results['title'];
		$province_region_array[$p] = $province_results['region_id'];
	}
	
	$regions = mysqli_query($connect,"select * from regions where company_id = $company_id")or die(mysqli_error($connect));
	
	$region_id_array = array();
	$region_title_array = array();
	for($r=0;$r<mysqli_num_rows($regions);$r++){
		$region_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
		
		$region_id_array[$r] = $region_results['id'];
		$region_title_array[$r] = $region_results['title'];
	}
	
	$user_site_title = 'Unspecified site';
	$user_site_index = array_keys($site_id_array,$this_user_results['site_id']);
	
	if(isset($user_site_index[0])){
		$user_site_title = $site_title_array[$user_site_index[0]];
		
	}
	
	$user_hub_title = 'Unspecified hub';
	$user_hub_index = array_keys($hub_id_array,$this_user_results['hub_id']);
	
	if(isset($user_hub_index[0])){
		$user_hub_title = $hub_title_array[$user_hub_index[0]];
		
	}
	
	$user_province_index = array_keys($province_id_array,$this_user_results['province_id']);
	$user_province_title = 'Unspecified province';
	
	if(isset($user_province_index[0])){
		$user_province_title = $province_title_array[$user_province_index[0]];
		
	}
	
	$user_region_index = array_keys($region_id_array,$this_user_results['region_id']);
	
	$user_region_title = 'Unspecified region';
	if(isset($usr_region_index[0])){
		$user_region_title = $region_title_array[$usr_region_index[0]];
		
	}
	
	if($this_claim_results['unit_id'] != 0){
		$unit_id = $this_claim_results['unit_id'];
		$this_unit = mysqli_query($connect,"select * from units where id = $unit_id")or die(mysqli_error($connect));
		$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
		$unit_title = $this_unit_results['title'];
		
	}else{
		$unit_title = 'Multiple units';
	}
	
	
	for($r=0;$r<count($region_id_array);$r++){
		if($region_id_array[$r] == $this_claim_results['region_id']){
			$claim_region_title = $region_title_array[$r];
			$claim_location = 'Region: '.$claim_region_title;
			
			break;
			
		}else if($r==count($region_id_array)-1){
			$claim_region_title = 'Unspecified region';
		}
	}
	
	for($p=0;$p<count($province_id_array);$p++){
		if($province_id_array[$p] == $this_claim_results['province_id']){
			$claim_province_title = $province_title_array[$p];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title;
			break;
			
		}else if($p==count($province_id_array)-1){
			$claim_province_title = 'Unspecified province';
			
		}
	}
	
	for($h=0;$h<count($hub_id_array);$h++){
		
		if($hub_id_array[$h] == $this_claim_results['hub_id']){
			$claim_hub_title = $hub_title_array[$h];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title.', Hub: '.$claim_hub_title;
			
			break;
			
		}else if($h == count($hub_id_array)-1){
			$claim_hub_title = 'Unspecified hub';
			
			
		}
	}
	
	for($s=0;$s<count($site_id_array);$s++){
		if($site_id_array[$s] == $this_claim_results['site_id']){
			$claim_site_title = $site_title_array[$s];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title.', Hub: '.$claim_hub_title.', Site: '.$claim_site_title;
			break;
		
		}else if($s == (count($site_id_array) -1)){
			$claim_site_title = 'Unspecified site';
			
		}		
		
	}
	
	$payment_folder_title = '';
	if($this_claim_results['title'] != ''){
		
		$payment_folder_title = $this_claim_results['title'];
	}
	
	

	
	
	class PDF extends FPDF{
		function Header(){
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Move to the right
			//$this->Cell(80);
			// Title
			
			if($_GET['t'] < 3){
				$this->Cell(0,5,'Payment Claim Spreadsheet',0,0,'C');
				
				$this -> ln(6);
				
				if($_GET['t']){
					$this -> setFont("Arial","B",'12');
					$this -> cell(0,5,'Claim Number: '.$GLOBALS['claim_number'],0,2,"C",0);
					
				}else{
					$this -> setTextColor("255","0","0");
					$this -> setFont("Arial","B",'11');
					$this -> cell(0,5,'(DRAFT. NOT TO BE USED FOR PAYMENT PROCESSING)',0,2,"C",0);
					
				}
			
			}else if($_GET['t'] == 3 || $_GET['t'] == 5){
				
				$this->Cell(0,5,'Payment Claim Form',0,0,'C');
				$this -> ln(6);
				$this -> setTextColor("100","100","100");
				$this -> setFont("Arial","B",'11');
				$this -> cell(0,5,'Community Mobilization Agents',0,2,"C",0);
				$this -> cell(0,5,'Claim Number: '.$GLOBALS['claim_number'],0,2,"R",0);
				
			}else if($_GET['t'] == 4){
				$this->Cell(0,5,'Payment Claim Form',0,0,'C');
				$this -> ln(6);
				$this -> setTextColor("100","100","100");
				$this -> setFont("Arial","B",'11');
				$this -> cell(0,5,'Service Providers',0,2,"C",0);
				$this -> cell(0,5,'Claim Number: '.$GLOBALS['claim_number'],0,2,"R",0);
				
				
			}
			
			// Line break
			$this -> ln(2);
		}
		
		
		function Footer(){
			// Go to 1.5 cm from bottom
			
			$this->SetY(-13);
			// Select Arial italic 8
			$this -> setFont("Arial","",'8');
			$this -> setFillColor("0","0","0");
			$this -> setTextColor("255","255","255");
			
			
			$this -> setFont("Arial","B",'7');
			$this -> setTextColor("0","0","0");
			$this -> setFillColor("255","255","255");	
			
			if(!$_GET['t']){
				$sign_text = "DO NOT SIGN";
				
			}else{
				$sign_text = "";
				
			}
			
			if($_GET['t'] < 3){
				
				
				$this -> cell(20,5,'FM Approval:',1,0,"L",1);
				$this -> cell(50,5,$sign_text,"B",0,"L",1);	
				
				$this->SetX(85);
				$this -> cell(8,5,'Date:',1,0,"L",1);
				$this -> cell(40,5,$sign_text,"B",0,"L",1);	
				
				$this->SetX(163);
				$this -> cell(20,5,'FD Approval:',1,0,"L",1);
				$this -> cell(50,5,$sign_text,"B",0,"L",0);	
				
				$this->SetX(237);
				$this -> cell(8,5,'Date:',1,0,"L",1);
				$this -> cell(40,5,$sign_text,"B",1,"L",0);			
			
			}else{				
				$this -> cell(17,5,'Supervisor:',1,0,"L",1);
				$this -> cell(40,5,$sign_text,"B",0,"L",1);	
				
				$this->SetX(68);
				$this -> cell(9,5,'Sign:',1,0,"L",1);
				$this -> cell(30,5,$sign_text,"B",0,"L",1);
				
				$this->SetX(108);
				$this -> cell(9,5,'Date:',1,0,"L",1);
				$this -> cell(26,5,$sign_text,"B",0,"L",1);
				
				
				$this->SetX(153);
				$this -> cell(19,5,'Manager:',1,0,"L",1);
				$this -> cell(40,5,$sign_text,"B",0,"L",0);	
				
				$this->SetX(213);
				$this -> cell(9,5,'Sign:',1,0,"L",1);
				$this -> cell(26,5,$sign_text,"B",0,"L",0);
				
				$this->SetX(249);
				$this -> cell(9,5,'Date:',1,0,"L",1);
				$this -> cell(26,5,$sign_text,"B",1,"L",0);
				
				$this -> cell(0,5,"All payments are valid for 60 days. Terms and Conditions will apply.",0,1,"C",0);
				
			}
			
			
			
			$this->SetFont('Arial','I',7);
			// Print centered page number
			$this->Cell(0,3,'Page '.$this->PageNo(),0,0,'C');
		}
		
		
	}
	
	if($_GET['t'] == 4){
		$letter = new PDF("P","mm","A4");
	
	}else{
		$letter = new PDF("L","mm","A4");
		
	}
	
	$letter -> SetTitle('Claims Spreadsheet');
	$letter -> setSubject('Claims Spreadsheet');
	$letter -> setAuthor("BlueRays Software");
	$letter -> setCreator("BlueRays Software");
	$letter -> setFont("Arial","",'9');
	$letter -> addPage();
	$letter -> setTopMargin(10);
	//$letter -> Footer('Hallo');
	
	
	if($_GET['t'] != 4){	
		$letter -> ln(2);
		$letter -> setFont("Arial","B",'10');
		$letter -> setTextColor("250","250","250");
		$letter -> cell(30,5,'Date',0,0,"L",1);
		$letter -> setTextColor("0","0","0");
		$letter -> cell(0,5,date('jS M, Y',$this_claim_results['claim_date']),0,1,"L",0);
		
		$letter -> ln(2);
		$letter -> setTextColor("250","250","250");
		$letter -> cell(30,5,'Creator',0,0,"L",1);
		$letter -> setTextColor("0","0","0");
		$letter -> cell(0,5,$this_user_results['_name'].' ('.$user_region_title.', '.$user_province_title.', '.$user_hub_title.', '.$user_site_title.') ['.$this_user_results['phone'].']',0,1,"L",0);

		$letter -> ln(2);
		$letter -> setTextColor("250","250","250");
		$letter -> cell(30,5,'Unit',0,0,"L",1);
		$letter -> setTextColor("0","0","0");
		$letter -> cell(0,5,$unit_title,0,1,"L",0);
		
		$letter -> ln(2);
		$letter -> setTextColor("250","250","250");
		$letter -> cell(30,5,'Claim Location',0,0,"L",1);
		$letter -> setTextColor("0","0","0");
		$letter -> cell(0,5,$claim_location,0,1,"L",0);
		
		
		if($this_claim_results['title'] != ''){
			
			$letter -> ln(2);
			$letter -> setTextColor("250","250","250");
			$letter -> cell(30,5,'Payment Folder',0,0,"L",1);
			$letter -> setTextColor("0","0","0");
			$letter -> cell(0,5,$payment_folder_title,0,1,"L",0);
			$letter -> setFont("Arial","",'9');
			
		}else{
			$letter -> setFont("Arial","",'9');
		}
	
	}

	/*if($_GET['t'] < 3){
		$letter -> setx(233);
		$letter -> cell(27,5,'Claim Total:',0,0,"R",0);

		$letter -> setx(261);
		$letter -> cell(26,5,'K'.number_format($this_claim_results['amount'],2),0,1,"R",0);
		
	}else{
		
		
	}*/
	$letter -> ln(2);
	$claim_type_array = explode(',',$this_claim_results['claim_type_date']);
	$claim_type_beneficiaries_array = explode(']',$beneficiary_id_string);
	
	if($_GET['t'] == 4){
		$provider_beneficiary_string = $claim_type_beneficiaries_array[0];	
		if(count($claim_type_beneficiaries_array) > 1){
			
			for($ct=1;$ct<count($claim_type_beneficiaries_array);$ct++){
				$this_claim_type_beneficiary_array = explode(',',$claim_type_beneficiaries_array[$ct]);
				for($cb=0;$cb<count($this_claim_type_beneficiary_array);$cb++){
					if($this_claim_type_beneficiary_array[$cb] != ''){
						
						if(!search_item_in_list($this_claim_type_beneficiary_array[$cb],$provider_beneficiary_string,0)){
							$provider_beneficiary_string .= ','.$this_claim_type_beneficiary_array[$cb];
							
						}						
					}
				}
			}
		}
		//print($provider_beneficiary_string);
		$provider_beneficiary_array = explode(',',$provider_beneficiary_string);
		if($provider_beneficiary_string != '' and $provider_beneficiary_string != 0){
		for($b=0;$b<count($provider_beneficiary_array);$b++){
			$total_for_beneficiary = 0;
			$beneficiary_found = 0;
			for($c=0;$c<count($claim_type_array);$c++){
				$claim_type_total = 0;
				//print($provider_beneficiary_array[$b].' - '.$claim_type_beneficiaries_array[$c].'<br>');
					
					if(search_item_in_list($provider_beneficiary_array[$b],$claim_type_beneficiaries_array[$c],0)){
						
						if(!$beneficiary_found){
							$letter -> setFillColor("0","107","179");
							$letter -> setFont("Arial","B",'8');
							$letter -> setTextColor("250","250","250");
							$letter -> cell(25,4,'Date',0,0,"L",1);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(0,4,date('jS M, Y',$this_claim_results['claim_date']),0,1,"L",0);

							$letter -> ln(1);
							$letter -> setTextColor("250","250","250");
							$letter -> cell(25,4,'Creator',0,0,"L",1);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(0,4,$this_user_results['_name'].' ('.$user_region_title.', '.$user_province_title.', '.$user_hub_title.', '.$user_site_title.') ['.$this_user_results['phone'].']',0,1,"L",0);

							$letter -> ln(1);
							$letter -> setTextColor("250","250","250");
							$letter -> cell(25,4,'Unit',0,0,"L",1);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(0,4,$unit_title,0,1,"L",0);
							
							$letter -> ln(1);
							$letter -> setTextColor("250","250","250");
							$letter -> cell(25,4,'Claim Location',0,0,"L",1);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(0,4,$claim_location,0,1,"L",0);
							
							
							$letter -> ln(3);
							$letter -> setTextColor("0","0","0");
							$letter -> setFont("Arial","B",'8');
							$letter -> cell(25,4,'Provider name',1,0,"L",0);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(47,4,$beneficiary_name_array[$b],"B",0,"L",0);
						
							$letter -> setx(100);
							
							//$letter -> setTextColor("250","250","250");
							$letter -> cell(30,4,'Phone',1,0,"L",0);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(40,4,$beneficiary_phone_array[$b],"B",1,"L",0);
							
							$letter -> ln(1);
							//$letter -> setTextColor("250","250","250");
							$letter -> cell(25,4,'NRC',1,0,"L",0);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(47,4,$beneficiary_nrc_array[$b],"B",0,"L",0);
							
							$letter -> setx(100);
							//$letter -> setTextColor("250","250","250");
							$letter -> cell(30,4,'District worked from',1,0,"L",0);
							$letter -> setTextColor("0","0","0");
							$letter -> cell(40,4,"","B",1,"L",0);
							$beneficiary_found = 1;
						}
						
						$this_claim_type_date = $claim_type_array[$c];
						$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
						$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
						
						if(!$this_claim_type_results['billing_type']){
							$claim_type_rate = ' (K'.number_format($this_claim_type_results['daily_rate'],2).' per day)';
							$rate_amount = number_format($this_claim_type_results['daily_rate'],2);
							
						}else{
							$claim_type_rate = ' (K'.number_format($this_claim_type_results['fixed_amount'],2).' fixed rate)';
							$rate_amount = 'Fixed';
						}
						
						
						$letter -> ln(1);
						$letter -> setFont("Arial","B",'8');
						$letter -> setFillColor("0","0","0");
						$letter -> setTextColor("250","250","250");
						$letter -> cell(0,5,$this_claim_type_results['title'].$claim_type_rate,1,1,"L",1);
						$letter -> setTextColor("0","0","0");
						$letter -> cell(25,4,'Date',1,0,"L",0);
						$letter -> cell(65,4,'Site',1,0,"L",0);
						$letter -> cell(25,4,'Clients',1,0,"L",0);
						$letter -> cell(20,4,'Rate (K)',1,0,"R",0);
						$letter -> cell(25,4,'Amount (K)',1,0,"R",0);
						$letter -> cell(30,4,'Sign',1,1,"L",0);
						$letter -> setFont("Arial","",'8');
						
						$claim_name[$c] = $this_claim_type_results['title'];
						$claim_rate[$c] = $this_claim_type_results['daily_rate'];
						$claim_fixed_amount[$c] = $this_claim_type_results['fixed_amount'];
						$claim_billing_type[$c] = $this_claim_type_results['billing_type'];
						
						$this_agent_date = $provider_beneficiary_array[$b];
						$this_agent = mysqli_query($connect,"select * from agents where _date = '$this_agent_date' and company_id = $company_id")or die(mysqli_error($connect));
						$this_agent_results = mysqli_fetch_array($this_agent,MYSQLI_ASSOC);
						$agent_id = $this_agent_results['id'];
						
						if($this_claim_results['unit_id'] != 0){
							$beneficiary_entries = mysqli_query($connect,"select * from _data where agent_id = $agent_id and unit_id = $unit_id")or die(mysqli_error($connect));
							
						}else{
							$beneficiary_entries = mysqli_query($connect,"select * from _data where agent_id = $agent_id")or die(mysqli_error($connect));
							
						}
						//print(mysqli_num_rows($beneficiary_entries).' - '.$agent_id.'<br>');
						
						$data_agent_id_array = array();
						$data_date_array = array();
						for($d=0;$d<mysqli_num_rows($beneficiary_entries);$d++){
							$beneficiary_entry_results = mysqli_fetch_array($beneficiary_entries,MYSQLI_ASSOC);
							
							$data_agent_id_array[$d] = $beneficiary_entry_results['agent_id'];
							$data_date_array[$d] = $beneficiary_entry_results['_date'];
						}
						
						if($this_claim_results['unit_id'] != 0){
							$beneficiary_entries_1 = mysqli_query($connect,"select * from _data_new where agent_id = $agent_id and unit_id = $unit_id")or die(mysqli_error($connect));
							
						}else{
							$beneficiary_entries_1 = mysqli_query($connect,"select * from _data_new where agent_id = $agent_id")or die(mysqli_error($connect));
							
						}
						
						for($d1=0;$d1<mysqli_num_rows($beneficiary_entries_1);$d1++){
							$beneficiary_entry_results_1 = mysqli_fetch_array($beneficiary_entries_1,MYSQLI_ASSOC);
							
							$data_agent_id_array[count($data_agent_id_array)] = $beneficiary_entry_results_1['agent_id'];
							$data_date_array[count($data_date_array)] = $beneficiary_entry_results_1['_date'];
						}
						
						$this_beneficiary_array_index = array_keys($beneficiary_agent_date_array,$provider_beneficiary_array[$b]);
						
						$ben_from_date = $beneficiary_from_array[$this_beneficiary_array_index[0]];
						$ben_to_date = $beneficiary_to_array[$this_beneficiary_array_index[0]];
						
						$from_date = mktime(0,0,0,date('m',$ben_from_date),date('j',$ben_from_date),date('Y',$ben_from_date));
						$to_date = mktime(23,59,0,date('m',$ben_to_date),date('j',$ben_to_date),date('Y',$ben_to_date));
						
		
						$days_in_period = ($to_date-$from_date)/86400;
						
						//print($days_in_period);
						
						$this_date = $from_date;
						$total_days = 0;
						for($d=0;$d<$days_in_period;$d++){					
							$found = 0;
							
							for($dt=0;$dt<count($data_date_array);$dt++){
								//print($data_date_array[$dt].' ('.date('jS M, Y',$data_date_array[$dt]).' - '.$unit_id.' - '.$agent_id.') - '.$this_date.'<br>');
								if($data_date_array[$dt] >= $this_date and  $data_date_array[$dt] <= ($this_date+86400)){
									$found = 1;
									$total_days++;
									break;
								}
							}
							
							if($found){
								$letter -> cell(25,4,date('jS M, Y',$this_date),"B",0,"L",0);
								$letter -> cell(65,4,'',"B",0,"L",0);
								$letter -> cell(25,4,'',"B",0,"L",0);
								$letter -> cell(20,4,$rate_amount,"B",0,"R",0);
								
								if(!$this_claim_type_results['billing_type']){
									$amount = $rate_amount;
									
								}else{
									$amount = number_format($this_claim_type_results['fixed_amount']);									
								
								}
								
								$letter -> cell(25,4,$amount,"B",0,"R",0);
								
								$letter -> cell(30,4,'',"B",1,"L",0);
								
								$claim_type_total += $amount;
							}
							$this_date +=86400;
						}
						$letter -> setx(125);
						$letter -> cell(20,4,'Total',0,0,"R",0);
						$letter -> cell(25,4,number_format($claim_type_total,2),"B",1,"R",0);
						
						$letter -> setx(125);
						$letter -> cell(20,4,'Payable',0,0,"R",0);
						$letter -> cell(25,4,number_format($beneficiary_amount_array[$b],2),"B",1,"R",0);
						
					//	if($beneficiary_comment_array[$b] != ''){
							$letter -> ln(3);
							$letter -> setx(3);
							$letter -> cell(20,4,'Comment',0,0,"R",0);
							$letter -> cell(177,4,$beneficiary_comment_array[$b],"B",1,"L",0);
						//}
						
						$total_for_beneficiary += $claim_type_total;
						
						$type_total[$c] = $claim_type_total;
						$beneficiary_payable[$c] = $beneficiary_paid_days_array[$b];
						$total_claim_days[$c] = $total_days;
					}
				
				
				
				$letter -> ln(5);
			}
			
			$letter -> ln(5);
			$letter -> setTextColor("0","0","0");
			$letter -> setFont("Arial","B",'8');
			$letter -> cell(65,4,'Claim Type',1,0,"L",0);
			$letter -> cell(24,4,'Total Days',1,0,"R",0);
			$letter -> cell(24,4,'Payable days',1,0,"R",0);
			$letter -> cell(25,4,'Rate(K)',1,0,"R",0);
			$letter -> cell(20,4,'Total(K)',1,1,"R",0);
			$letter -> setFont("Arial","",'8');
			$rate_total = 0;
			$days_total = 0;
			$amount_total = 0;
			$worked_days_total = 0;
			
			for($c1=0;$c1<count($claim_type_array);$c1++){
			    if(isset($claim_name[$c1])){
				$letter -> cell(65,4,$claim_name[$c1],1,0,"L",0);
				$letter -> cell(24,4,$total_claim_days[$c1],1,0,"R",0);
				
				if(!$claim_billing_type[$c1]){
					$this_rate_amount = $claim_rate[$c1];
					$total_amount = $this_rate_amount*$beneficiary_payable[$c1];
				}else{
					$this_rate_amount = 'Fixed';
					$total_amount = $claim_fixed_amount[$c1];
				}
				$letter -> cell(24,4,$beneficiary_payable[$c1],1,0,"R",0);
				$letter -> cell(25,4,$this_rate_amount,1,0,"R",0);
				$letter -> cell(20,4,number_format($total_amount,2),1,1,"R",0);
			    
				$rate_total += $this_rate_amount;
				$days_total += $total_claim_days[$c1];
				$worked_days_total += $beneficiary_payable[$c1];
			    
				$amount_total += $total_amount;
			    }
			    
			}
			
			$letter -> setFont("Arial","B",'8');
			$letter -> cell(65,4,'Totals',1,0,"R",0);
			$letter -> cell(24,4,$days_total,1,0,"R",0);
			$letter -> cell(24,4,$worked_days_total,1,0,"R",0);
			$letter -> cell(25,4,'N/A',1,0,"R",0);
			$letter -> cell(20,4,number_format($amount_total,2),1,1,"R",0);
			
			
			
			/*$letter -> cell(20,4,'Beneficiary Total',0,0,"R",0);
			$letter -> cell(25,4,number_format($total_for_beneficiary,2),"B",0,"R",0);*/
			
			if($beneficiary_found and $b <count($provider_beneficiary_array)-1){
				$letter -> addPage();
			
			}
		}
		}else{
			$letter -> setFont("Arial","",'8');
			$letter -> setTextColor("250","0","0");
			$letter -> cell(0,4,'No beneficiaries selected',0,0,"C",0);
			
		}
		
	}else{
		$grand_total = 0;
		$beneficiary_sql_string = '';
		for($c=0;$c<count($claim_type_array);$c++){
			$this_claim_type_date = $claim_type_array[$c];
			
			if(isset($claim_type_beneficiaries_array[$c])){
				$claim_type_beneficiaries = explode(',',$claim_type_beneficiaries_array[$c]);
				
				
				$this_claim_type = mysqli_query($$module_connect,"select * from request_types where _date = '$this_claim_type_date' and company_id = $company_id")or die(mysqli_error($$module_connect));
				$this_claim_type_results = mysqli_fetch_array($this_claim_type,MYSQLI_ASSOC);
				
				$rule_string_array = explode(']',$this_claim_type_results['rule_string']);
				
				if(!$this_claim_type_results['billing_type']){
					$claim_type_rate = ' (K'.number_format($this_claim_type_results['daily_rate'],2).' per day)';
					
				}else{
					$claim_type_rate = ' (K'.number_format($this_claim_type_results['fixed_amount'],2).' fixed rate)';
					
				}
				
				$letter -> setFont("Arial","",'9');
				
				$letter -> setTextColor("255","255","255");
				$letter -> setFillColor("0","107","179");
				
				if($letter -> GetY() > 168){
					$letter -> ln(20);
				}
				
				if($_GET['t'] != 4){
					$letter -> cell(0,5,$this_claim_type_results['title'].$claim_type_rate,0,1,"L",1);
					
				}
				
				$letter -> ln(1);
				$letter -> setFont("Arial","B",'8');
				$letter -> setTextColor("0","0","0");
				$letter -> setFillColor("0","107","2");
				$filed_fill = 0;
				$field_border = 1;
				
				if($_GET['t'] < 3){
					$letter -> cell(50,5,'Agent Name',$field_border,0,"L",$filed_fill);
					
					
					$letter -> setx(61);
					$letter -> cell(35,5,'Phone Number',$field_border,0,"L",$filed_fill);
				
					$letter -> setx(97);
					$letter -> cell(25,5,'NRC Number',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(123);
					$letter -> cell(30,5,'Date From',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(154);
					$letter -> cell(30,5,'Date To',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(185);
					$letter -> cell(23,5,'Days Worked',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(209);
					$letter -> cell(23,5,'Payable Days',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(233);
					$letter -> cell(27,5,'Rate(K)',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(261);
					$letter -> cell(26,5,'Amount(K)',$field_border,1,"R",$filed_fill);
					
				}else if($_GET['t'] == 3  || $_GET['t'] == 5){
					$letter -> cell(45,5,'Agent Name',$field_border,0,"L",$filed_fill);
					
					
					$letter -> setx(56);
					$letter -> cell(25,5,'Phone Number',$field_border,0,"L",$filed_fill);
				
					$letter -> setx(82);
					$letter -> cell(20,5,'NRC Number',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(103);
					$letter -> cell(37,5,'Site',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(141);
					$letter -> cell(23,5,'Date From',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(165);
					$letter -> cell(23,5,'Date To',$field_border,0,"L",$filed_fill);
					
					$letter -> setx(189);
					$letter -> cell(18,5,'PIPAT Days',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(208);
					$letter -> cell(20,5,'Payable Days',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(229);
					$letter -> cell(15,5,'Rate(K)',$field_border,0,"R",$filed_fill);
					
					$letter -> setx(245);
					$letter -> cell(25,5,'Amount(K)',$field_border,0,"R",$filed_fill);
					$letter -> setx(271);
					$letter -> cell(16,5,'Sign',$field_border,1,"L",$filed_fill);
				}
				
				$letter -> setTextColor("0","0","0");
				$letter -> setFillColor("255","255","255");
				
				$letter -> setFont("Arial","",'9');
				$sub_total = 0;
				for($cb=0;$cb<count($claim_type_beneficiaries);$cb++){
					$this_beneficiary_id = $claim_type_beneficiaries[$cb];
					//$letter -> cell(50,5,$this_beneficiary_id,$field_border,0,"L",$filed_fill);
					
					
					for($b=0;$b<count($beneficiary_id_array);$b++){					
						if($beneficiary_type_date_array[$b] == $this_claim_type_date and $this_beneficiary_id == $beneficiary_agent_date_array[$b]){
							
							if($beneficiary_sql_string == ''){
								$beneficiary_sql_string = "($company_id,'$this_claim_date','".$beneficiary_agent_date_array[$b]."','".$claim_type_array[$c]."',".$ascension_index.",'".time()."')";
								
							}else{
								$beneficiary_sql_string .= ",($company_id,'$this_claim_date','".$beneficiary_agent_date_array[$b]."','".$claim_type_array[$c]."',".$ascension_index.",'".time()."')";
								
							}
							
							$filed_fill = 0;
								$field_border = 0;
								
								if(!$this_claim_type_results['billing_type']){
									$this_rate = $beneficiary_rate_array[$b];
									$this_payable = $beneficiary_paid_days_array[$b];
									
								}else{
									$this_rate = 'Fixed';
									$this_payable = 'N/A';
									
								}
								
							if($_GET['t'] < 3){
								
								$letter -> cell(50,5,$beneficiary_name_array[$b],$field_border,0,"L",$filed_fill);
								
								
								$letter -> setx(61);
								$letter -> cell(35,5,$beneficiary_phone_array[$b],$field_border,0,"L",$filed_fill);
							
								$letter -> setx(97);
								$letter -> cell(25,5,$beneficiary_nrc_array[$b],$field_border,0,"L",$filed_fill);
								
								$letter -> setx(123);
								$letter -> cell(30,5,date('jS M, Y',$beneficiary_from_array[$b]),$field_border,0,"L",$filed_fill);
								
								$letter -> setx(154);
							    $letter -> cell(30,5,date('jS M, Y', (int)$beneficiary_to_array[$b]),$field_border,0,"L",$filed_fill);
								
								
								
								$letter -> setx(185);
								$letter -> cell(23,5,$beneficiary_days_array[$b],$field_border,0,"R",$filed_fill);
								
								$letter -> setx(209);
								$letter -> cell(23,5,$this_payable,$field_border,0,"R",$filed_fill);
								
								$letter -> setx(233);
								$letter -> cell(27,5,number_format($beneficiary_rate_array[$b],2),$field_border,0,"R",$filed_fill);
								
								$letter -> setx(261);
								$letter -> cell(26,5,number_format($beneficiary_amount_array[$b],2),$field_border,1,"R",$filed_fill);
								
								$sub_total += $beneficiary_amount_array[$b];
								
								
								
								
								for($s=0;$s<count($site_id_array);$s++){
									if($site_id_array[$s] == $beneficiary_site_id_array[$b]){
										$agent_site_title = $site_title_array[$s];
										break;
									
									}else if($s == (count($site_id_array) -1)){
										$agent_site_title = 'Unspecified site';
										
									}		
									
								}
								
								for($h=0;$h<count($hub_id_array);$h++){
									
									if($beneficiary_hub_id_array[$b] == $hub_id_array[$h]){
										$agent_hub_title = $hub_title_array[$h];
										break;
										
									}else if($h == count($hub_id_array)-1){
										$agent_hub_title = 'Unspecified hub';
										
									}
								}
								
								for($p=0;$p<count($province_id_array);$p++){
									if($beneficiary_province_id_array[$b] == $province_id_array[$p]){
										$agent_province_title = $province_title_array[$p];
										break;
										
									}else if($p==count($province_id_array)-1){
										$agent_province_title = 'Unspecified province';
										
									}
								}
								
								for($r=0;$r<count($region_id_array);$r++){
									if($beneficiary_region_id_array[$b] == $region_id_array[$r]){
										$agent_region_title = $region_title_array[$r];
										break;
										
									}else if($r==count($region_id_array)-1){
										$agent_region_title = 'Unspecified region';
									}
								}
								
								$letter -> setTextColor("160","90","90");					
								
								$letter -> setFont("Arial","",'7');
								
								if($beneficiary_comment_array[$b] != '' and $beneficiary_comment_array[$b] != 'Enter comment here'){
									$letter -> multicell(0,3,'Comment: '.$beneficiary_comment_array[$b],0,1);
									
								}
								
								$letter -> setTextColor("90","90","90");	
								
								$letter -> multicell(0,3,'Location => Region: '.$agent_region_title.', Province: '.$agent_province_title.', Hub: '.$agent_hub_title.', Site: '.$agent_site_title.'. (Note: "Unspecified" means the agent is configured to work in any location at that level)',0,1);
								
								$approval_string = '';
								$this_first_approval_date = 0;
								$recent_approval_time = time();
								for($a=0;$a<count($approval_date_array);$a++){
									
									if($approval_beneficiary_array[$a] == $beneficiary_agent_date_array[$b] and $approval_claim_type_date_array[$a] == $this_claim_type_date){
										
										$recent_approval_time = time();
										if($approval_level_array[$a] == 0){
											$this_first_approval_date = $approval_date_array[$a];
											
										}
										
										
										
										if($approval_level_array[$a] == count($rule_string_array)){
											$recent_approval_time = $approval_date_array[$a];
											
										}
										
										for($cu=0;$cu<count($claim_user_id_array);$cu++){
											
											if($claim_user_date_array[$cu] == $approval_user_date_array[$a]){
												$this_approver_name = 'Level '.($approval_level_array[$a]+1).': '.date('H:i:s',$approval_date_array[$a]).' - '.date('jS M, Y',$approval_date_array[$a]).' - '.$claim_user_name_array[$cu].' ('.$claim_user_phone_array[$cu].')';
												break;
												
											}else if($cu== count($claim_user_id_array) -1){
												$this_approver_name = 'Level '.($approval_level_array[$a]+1).': User not found';
												
											}
										}
									
										if($approval_string  == ''){
											$approver_string = $this_approver_name;
											
										}else{
											$approver_string .= ', '.$this_approver_name;
										}
									}
								}
								$letter -> SetDrawColor("150","150","150");
								$letter -> multicell(0,3,'Total approval delay: '.round((($recent_approval_time - $this_first_approval_date)/86400),1).' days, Approvers => '.$approver_string,"B",1);
								$letter -> SetDrawColor("0","0","0");
								
								$letter -> setFont("Arial","",'9');
								$letter -> setTextColor("0","0","0");
								
								$letter -> ln(2);
								
							}else if($_GET['t'] == 3  || $_GET['t'] == 5){
								$letter -> cell(45,5,$beneficiary_name_array[$b],"B",0,"L",$filed_fill);						
								
								$letter -> setx(56);
								$letter -> cell(25,5,$beneficiary_phone_array[$b],"B",0,"L",$filed_fill);
							
								$letter -> setx(82);
								$letter -> cell(20,5,$beneficiary_nrc_array[$b],"B",0,"L",$filed_fill);
								
								$letter -> setx(103);
								$letter -> cell(37,5,'',"B",0,"L",$filed_fill);
								
								$letter -> setx(141);
								$letter -> cell(23,5,date('jS M, Y',$beneficiary_from_array[$b]),"B",0,"L",$filed_fill);
								
								$letter -> setx(165);
								$letter -> cell(23,5,date('jS M, Y',$beneficiary_to_array[$b]),"B",0,"L",$filed_fill);
								
								$letter -> setx(189);
								$letter -> cell(18,5,$beneficiary_days_array[$b],"B",0,"R",$filed_fill);
								
								$letter -> setx(208);
								$letter -> cell(20,5,$beneficiary_paid_days_array[$b],"B",0,"R",$filed_fill);
								
								$letter -> setx(229);
								$letter -> cell(15,5,number_format($beneficiary_rate_array[$b],2),"B",0,"R",$filed_fill);
								
								$letter -> setx(245);
								$letter -> cell(25,5,number_format($beneficiary_amount_array[$b],2),"B",0,"R",$filed_fill);
								$letter -> setx(271);
								$letter -> cell(16,5,'',"B",1,"L",$filed_fill);
								
							}
						}
					}
				}
				
				if($_GET['t'] < 3){
					$letter -> setx(233);
					$letter -> cell(27,5,'Sub-Total:',0,0,"R",$filed_fill);

					$letter -> setx(261);
					$letter -> cell(26,5,number_format($sub_total,2),"B",1,"R",$filed_fill);
					
					$grand_total += $sub_total;
					
				}
				
				$letter -> ln(5);
			}
			
			if($_GET['t'] == 5 and $c < (count($claim_type_array) - 1)){
				$letter -> addPage();
			}
		}
		
		if($beneficiary_sql_string != '' and $_GET['t'] == 1 and $_GET['asc_type'] == 0){
			
			$add_ascension_beneficiaries = mysqli_query($$module_connect,"insert into $claim_ascension_table (company_id,claim_date,agent_date,type_date,ascension_ind,_date) VALUES $beneficiary_sql_string")or die(mysqli_error($$module_connect));
			
			if($this_claim_results['ascensions'] == 0){
				$ascension_dates = time();
				$ascension_user_dates = $user_date;
				
			}else{
				$ascension_dates = $this_claim_results['ascension_dates'].','.time();
				$ascension_user_dates = $this_claim_results['ascension_user_dates'].','.$user_date;
				
			}
			
			$new_ascensions = $this_claim_results['ascensions']+1;
				
			
			$update_payment_claim = mysqli_query($$module_connect,"update $payment_claims_table set ascensions = $new_ascensions,ascension_dates = '$ascension_dates', ascension_user_dates = '$ascension_user_dates' where _date = '$this_claim_date' and company_id = $company_id")or die(mysqli_error($$module_connect));;
			
			//print($update_payment_claim);
		}
	}
	
	
	if($_GET['t'] < 3){
		$letter -> setFont("Arial","B",'9');
		$letter -> ln(5);
		$letter -> setx(233);
		$letter -> cell(27,5,'Grand Total: ',0,0,"R",0);

		$letter -> setx(261);
		$letter -> cell(26,5,'K'.number_format($grand_total,2),0,1,"R",0);
	}
	
	$claim_type_array = explode(',',$this_claim_results['claim_type_date']);
	$claim_type_beneficiaries_array = explode(']',$beneficiary_id_string);
	
	$letter -> output();
	
}else{
	print('Illegal access of claims spreadsheet. Contact PIPAT administrator');
}
?>