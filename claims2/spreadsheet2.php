<?php



if(isset($_GET['s']) and isset($_GET['k']) and $_GET['k'] == 'hblhsbsrbefibuqpufubnslnlquigrw2187768'){
	include 'scripts/connector.php';
	@require("scripts/fpdf.php");
	include '../common_data_loop.php';
	
	$alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Z');
	$ascension_index = $_GET['asc'];
	
	
	
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
	
	
	$claims_type_array = fetch_db_table('claims_connect','request_types',1,'id','');
	$claim_array = fetch_db_table('claims_connect',$payment_claims_table,1,'id',"_date = '".$claim_date."'");
	$claims_beneficiary_array = fetch_db_table('claims_connect',$claim_beneficiaries_table,1,'id',"claim_date = '".$claim_date."'");
	$unit_array = fetch_db_table('connect','units',1,'id',"");
	
	$beneficiary_entries = fetch_db_table('connect','_data',1,'id',"");
	$beneficiary_entries_2 = fetch_db_table('connect','_data_new',1,'id',"");
	
	if($_GET['asc_type'] == 1){
		$claim_number = $claim_array['claim_id'][0].$alphabet[$_GET['asc']].' (RETURNED)';
		
	}else{
		$claim_number = $claim_array['claim_id'][0].$alphabet[$_GET['asc']];
		
	}
	
	
	
	class PDF extends FPDF{
		function Header(){
			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Move to the right
			//$this->Cell(80);
			// Title
			
			
			$this->Cell(0,5,'Payment Claim Form',0,0,'C');
			$this -> ln(6);
			$this -> setTextColor("100","100","100");
			$this -> setFont("Arial","B",'11');
			$this -> cell(0,5,'Service Providers',0,2,"C",0);
			$this -> cell(0,5,'Claim Number: '.$GLOBALS['claim_number'],0,2,"R",0);
				
				
			
			
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
			
			$this->SetFont('Arial','I',7);
			// Print centered page number
			$this->Cell(0,3,'Page '.$this->PageNo(),0,0,'C');
		}
	}

	$letter = new PDF("P","mm","A4");
	
	
	$letter -> SetTitle('Claims Spreadsheet');
	$letter -> setSubject('Claims Spreadsheet');
	$letter -> setAuthor("BlueRays Software");
	$letter -> setCreator("BlueRays Software");
	$letter -> setFont("Arial","",'9');
	$letter -> addPage();
	$letter -> setTopMargin(10);
	
	$letter -> ln(2);
	
	$claim_region_title = 'Unspecified region';
	if($claim_array['region_id'][0] != 0){
		$region_index = array_keys($region_array['id'],$claim_array['region_id'][0]);
		
		if(isset($region_index[0])){
			$claim_region_title = $region_array['title'][$region_index[0]];
			$claim_location = 'Region: '.$claim_region_title;
		}
	}
	
	$claim_province_title = 'Unspecified province';
	if($claim_array['hub_id'][0] != 0){
		$province_index = array_keys($province_array['id'],$claim_array['province_id'][0]);
		
		if(isset($province_index[0])){
			$claim_province_title = $province_array['title'][$province_index[0]];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title;
		}
	}
	
	$claim_hub_title = 'Unspecified hub';
	if($claim_array['hub_id'][0] != 0){
		$hub_index = array_keys($hub_array['id'],$claim_array['hub_id'][0]);
		
		if(isset($hub_index[0])){
			$claim_hub_title = $hub_array['title'][$hub_index[0]];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title.', '.$claim_hub_title;
		}
	}
	
	$claim_site_title = 'Unspecified site';
	if($claim_array['site_id'][0] != 0){
		$site_index = array_keys($site_array['id'],$claim_array['site_id'][0]);
		
		if(isset($site_index[0])){
			$claim_site_title = $site_array['title'][$site_index[0]];
			$claim_location = 'Region: '.$claim_region_title.', Province: '.$claim_province_title.', '.$claim_hub_title.', '.$claim_site_title;
		}
	}
	
	$unit_title = 'Multiple units';
	if($claim_array['unit_id'][0] != 0){
		$unit_index = array_keys($unit_array['id'],$claim_array['unit_id'][0]);
		
		if(isset($unit_index[0])){
			$unit_title = $unit_array['title'][$unit_index[0]];
			
		}
	}

	$user_site_title = 'Unspecified site';
	if($user_array['site_id'][0] != 0){
		$site_index = array_keys($site_array['id'],$user_results['site_id']);
		
		if(isset($site_index[0])){
			$user_site_title = $site_array['title'][$site_index[0]];
			
		}
	}
	
	$user_hub_title = 'Unspecified hub';
	if($user_results['hub_id'][0] != 0){
		$hub_index = array_keys($hub_array['id'],$user_results['hub_id'][0]);
		
		if(isset($hub_index[0])){
			$user_hub_title = $hub_array['title'][$hub_index[0]];
			
		}
	}
	
	$user_province_title = 'Unspecified province';
	if($user_results['hub_id'][0] != 0){
		$province_index = array_keys($province_array['id'],$user_results['province_id'][0]);
		
		if(isset($province_index[0])){
			$user_province_title = $province_array['title'][$province_index[0]];
			
		}
	}
	
	$user_region_title = 'Unspecified region';
	if($user_results['region_id'][0] != 0){
		$region_index = array_keys($region_array['id'],$user_results['region_id'][0]);
		
		if(isset($region_index[0])){
			$user_region_title = $region_array['title'][$region_index[0]];
			
		}
	}
	
	$user_unit_title = 'Multiple units';
	if($user_array['unit_id'][0] != 0){
		$unit_index = array_keys($unit_array['id'],$user_array['unit_id'][0]);
		
		if(isset($unit_index[0])){
			$user_unit_title = $unit_array['title'][$unit_index[0]];
			
		}
	}
	
	
			
			$beneficiary_array = explode(']',$beneficiary_id_string);
			//$beneficiary_date_string = $beneficiary_array[$ct];
			//$this_claim_type_beneficiary_array = explode(',',$beneficiary_date_string);
			
			
			$beneficiaries_array = explode(',',$claim_array['beneficiaries'][0]);
			$claim_type_array = explode(',',$claim_array['claim_type_date'][0]);
			
			for($b=0;$b<count($beneficiaries_array);$b++){
				
				$this_beneficiary_index = array_keys($claims_beneficiary_array['agent_date'],$beneficiaries_array[$b]);
				for($ct=0;$ct<count($claim_type_array);$ct++){
					
					
					if(isset($this_beneficiary_index[0])){
						$ben_index = -1;
						for($bi=0;$bi<count($this_beneficiary_index);$bi++){
							if($claims_beneficiary_array['type_date'][$this_beneficiary_index[$bi]] == $claim_type_array[$ct]){
								$ben_index = $bi;
								
								break;
							}							
						}
						if($ben_index != -1){
							$claim_type_total = 0;
							$claim_type_beneficiaries_array = explode(',',$beneficiary_array[$ct]);
							
							$check_beneficiary = array_keys($claim_type_beneficiaries_array,$beneficiaries_array[$b]);
							
							if(isset($check_beneficiary[0])){
								
								$this_claim_type_date = $claim_type_array[$ct];
							
								$claim_type_index = array_keys($claims_type_array['_date'],$this_claim_type_date);
								
								if(isset($claim_type_index[0])){
									$claim_name[$b][$ct] = $claims_type_array['title'][$claim_type_index[0]];
									$total_claim_days[$b][$ct] = 0;
									$claim_rate[$b][$ct] = $claims_type_array['daily_rate'][$claim_type_index[0]];
									$claim_billing_type[$b][$ct] = $claims_type_array['billing_type'][$claim_type_index[0]];
									
									$claim_type_name = $claims_type_array['title'][$claim_type_index[0]];
									
									if(!$claims_type_array['billing_type'][$claim_type_index[0]]){
										$claim_type_rate = ' (K'.number_format($claims_type_array['daily_rate'][$claim_type_index[0]],2).' per day)';
										$rate_amount = number_format($claims_type_array['daily_rate'][$claim_type_index[0]],2);
										
									}else{
										$claim_type_rate = ' (K'.number_format($claims_type_array['fixed_amount'][$claim_type_index[0]],2).' fixed rate)';
										$rate_amount = $claims_type_array['fixed_amount'][$claim_type_index[0]];
									}
							
									if($ct==0){
										$letter -> setFillColor("0","107","179");
										$letter -> setFont("Arial","B",'8');
										$letter -> setTextColor("250","250","250");
										$letter -> cell(25,4,'Date',0,0,"L",1);
										$letter -> setTextColor("0","0","0");
										$letter -> cell(0,4,date('jS M, Y',$claim_array['claim_date'][0]),0,1,"L",0);

										$letter -> ln(1);
										$letter -> setTextColor("250","250","250");
										$letter -> cell(25,4,'Creator',0,0,"L",1);
										$letter -> setTextColor("0","0","0");
										$letter -> cell(0,4,$user_results['_name'].' ('.$user_region_title.', '.$user_province_title.', '.$user_hub_title.', '.$user_site_title.') ['.$user_results['phone'].']',0,1,"L",0);

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
										$letter -> cell(47,4,$claims_beneficiary_array['_name'][$this_beneficiary_index[$ben_index]],"B",0,"L",0);

										$letter -> setx(100);
										
										//$letter -> setTextColor("250","250","250");
										$letter -> cell(30,4,'Phone',1,0,"L",0);
										$letter -> setTextColor("0","0","0");
										$letter -> cell(40,4,$claims_beneficiary_array['phone'][$this_beneficiary_index[$ben_index]],"B",1,"L",0);
										
										$letter -> ln(1);
										//$letter -> setTextColor("250","250","250");
										$letter -> cell(25,4,'NRC',1,0,"L",0);
										$letter -> setTextColor("0","0","0");
										$letter -> cell(47,4,$claims_beneficiary_array['nrc'][$this_beneficiary_index[$ben_index]],"B",0,"L",0);
										
										$letter -> setx(100);
										//$letter -> setTextColor("250","250","250");
										$letter -> cell(30,4,'District worked from',1,0,"L",0);
										$letter -> setTextColor("0","0","0");
										$letter -> cell(40,4,"","B",1,"L",0);
									}
									
									$letter -> ln(1);
									$letter -> setFont("Arial","B",'8');
									$letter -> setFillColor("0","0","0");
									$letter -> setTextColor("250","250","250");
									$letter -> cell(0,5,$claim_type_name.$claim_type_rate,1,1,"L",1);
									$letter -> setTextColor("0","0","0");
									$letter -> cell(25,4,'Date',1,0,"L",0);
									$letter -> cell(65,4,'Site',1,0,"L",0);
									$letter -> cell(25,4,'Clients',1,0,"L",0);
									$letter -> cell(20,4,'Rate (K)',1,0,"R",0);
									$letter -> cell(25,4,'Amount (K)',1,0,"R",0);
									$letter -> cell(30,4,'Sign',1,1,"L",0);
									$letter -> setFont("Arial","",'8');
									
									
									
									$this_agent_index = array_keys($agent_array['_date'],$claims_beneficiary_array['agent_date'][$this_beneficiary_index[$ben_index]]);
									
									if(isset($this_agent_index[0])){
										$this_beneficiary_entry_index = array_keys($beneficiary_entries['agent_id'],$agent_array['id'][$this_agent_index[0]]);
										
										$this_beneficiary_entry_index_2 = array_keys($beneficiary_entries_2['agent_id'],$agent_array['id'][$this_agent_index[0]]);
										
										
										if(isset($this_beneficiary_entry_index[0])){
									
											$ben_from_date = $claims_beneficiary_array['_from'][$this_beneficiary_index[$ben_index]];
											$ben_to_date = $claims_beneficiary_array['_to'][$this_beneficiary_index[$ben_index]];
											
											$from_date = mktime(0,0,0,date('m',$ben_from_date),date('j',$ben_from_date),date('Y',$ben_from_date));
											$to_date = mktime(23,59,0,date('m',$ben_to_date),date('j',$ben_to_date),date('Y',$ben_to_date));
											
							
											$days_in_period = ($to_date-$from_date)/86400;
											
											$this_date = $from_date;
											$total_days = 0;
											for($d=0;$d<$days_in_period;$d++){					
												$found = 0;
												
												for($dt=0;$dt<count($this_beneficiary_entry_index);$dt++){
													if($beneficiary_entries['_date'][$this_beneficiary_entry_index[$dt]] >= $this_date and  $beneficiary_entries['_date'][$this_beneficiary_entry_index[$dt]] <= ($this_date+86400)){
														$found = 1;
														$total_days++;
														break;
													}
												}
												
												if(!$found){
													if(isset($this_beneficiary_entry_index_2[0])){
														for($dt=0;$dt<count($this_beneficiary_entry_index_2);$dt++){
															if($beneficiary_entries_2['_date'][$this_beneficiary_entry_index_2[$dt]] >= $this_date and  $beneficiary_entries_2['_date'][$this_beneficiary_entry_index_2[$dt]] <= ($this_date+86400)){
																$found = 1;
																$total_days++;
																break;
															}
														}
													}
												}
												
												if($found){
													$letter -> cell(25,4,date('jS M, Y',$this_date),"B",0,"L",0);
													$letter -> cell(65,4,'',"B",0,"L",0);
													$letter -> cell(25,4,'',"B",0,"L",0);
													$letter -> cell(20,4,$rate_amount,"B",0,"R",0);
													
													if(!$claims_type_array['billing_type'][$claim_type_index[0]]){
														$amount = $rate_amount;
														
													}else{
														$amount = number_format($claims_type_array['fixed_amount'][$claim_type_index[0]]);									
													
													}
													
													$letter -> cell(25,4,$amount,"B",0,"R",0);
													
													$letter -> cell(30,4,'',"B",1,"L",0);
													
													$claim_type_total += $amount;
												}
												$this_date +=86400;
											}
											
											$total_claim_days[$b][$ct] = $total_days;
											
											$letter -> setx(125);
											$letter -> cell(20,4,'Total',0,0,"R",0);
											$letter -> cell(25,4,number_format($claim_type_total,2),"B",1,"R",0);
											
											$letter -> setx(125);
											$letter -> cell(20,4,'Payable',0,0,"R",0);
											$letter -> cell(25,4,number_format($claims_beneficiary_array['amount'][$this_beneficiary_index[$ben_index]],2),"B",1,"R",0);
											
										//	if($beneficiary_comment_array[$b] != ''){
												$letter -> ln(3);
												$letter -> setx(3);
												$letter -> cell(20,4,'Comment',0,0,"R",0);
												$letter -> cell(177,4,$claims_beneficiary_array['comment'][$this_beneficiary_index[$ben_index]],"B",1,"L",0);
											//}
											
											//$total_for_beneficiary += $claim_type_total;
											
											//$type_total[$c] = $claim_type_total;
											////$beneficiary_payable[$c] = $claims_beneficiary_array['paid_days'][$this_beneficiary_index[0]];
											//$total_claim_days[$c] = $total_days;
											
											$letter -> ln(5);
										}
									}
									
									if($ct == count($claim_type_array)-1){
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
										$payable_days_total = 0;
										
										for($c1=0;$c1<count($claim_type_array);$c1++){
											if(isset($claim_name[$b][$c1])){
											$letter -> cell(65,4,$claim_name[$b][$c1],1,0,"L",0);
											$letter -> cell(24,4,$total_claim_days[$b][$c1],1,0,"R",0);
											
											$this_rate_amount = $claim_rate[$b][$c1];
											
											if(!$claim_billing_type[$b][$c1]){
												$total_amount = $this_rate_amount*$claims_beneficiary_array['paid_days'][$this_beneficiary_index[$ben_index]];
												
											}else{
												//$this_rate_amount = 'Fixed';
												$total_amount = $claim_fixed_amount[$c1];
											}
											$letter -> cell(24,4,$claims_beneficiary_array['paid_days'][$this_beneficiary_index[$ben_index]],1,0,"R",0);
											$letter -> cell(25,4,$this_rate_amount,1,0,"R",0);
											$letter -> cell(20,4,$total_amount,1,1,"R",0);
											//print($this_rate_amount.'<br>');
											//$rate_total += $this_rate_amount;
											
											$days_total += $total_claim_days[$b][$c1];
											$payable_days_total += $claims_beneficiary_array['paid_days'][$this_beneficiary_index[$ben_index]];
											
											$amount_total += $total_amount;
											}
											
										}
										
										$letter -> setFont("Arial","B",'8');
										$letter -> cell(65,4,'Totals',1,0,"R",0);
										$letter -> cell(24,4,$days_total,1,0,"R",0);
										$letter -> cell(24,4,$payable_days_total,1,0,"R",0);
										$letter -> cell(25,4,'N/A',1,0,"R",0);
										$letter -> cell(20,4,number_format($amount_total,2),1,1,"R",0);
										
									}
								}
								if($ct == count($claim_type_array)-1 and $b < count($beneficiaries_array)-1){
									$letter -> addPage();	
										
								}
							}
						}
					}
				}
			
				/*
				$this_beneficiary_index = array_keys($claims_beneficiary_array['agent_date'],$this_claim_type_beneficiary_array[$b]);
				
				if(isset($this_beneficiary_index[0])){
					
					$claim_type_dates = $claim_array['claim_type_date'][0];
	
					$claim_type_date_array = explode(',',$claim_type_dates);
					
					for($ct=0;$ct<count($claim_type_date_array);$ct++){
						$this_claim_type_date = $claim_type_date_array[$ct];
						
						$claim_type_index = array_keys($claims_type_array['_date'],$this_claim_type_date);
						$claim_type_total = 0;
						if(isset($claim_type_index[0])){
							$claim_type_name = $claims_type_array['title'][$claim_type_index[0]];
							
							if(!$claims_type_array['billing_type'][$claim_type_index[0]]){
								$claim_type_rate = ' (K'.number_format($claims_type_array['daily_rate'][$claim_type_index[0]],2).' per day)';
								$rate_amount = number_format($claims_type_array['daily_rate'][$claim_type_index[0]],2);
								
							}else{
								$claim_type_rate = ' (K'.number_format($claims_type_array['fixed_amount'][$claim_type_index[0]],2).' fixed rate)';
								$rate_amount = $claims_type_array['fixed_amount'][$claim_type_index[0]];
							}
					
					$letter -> setFillColor("0","107","179");
					$letter -> setFont("Arial","B",'8');
					$letter -> setTextColor("250","250","250");
					$letter -> cell(25,4,'Date',0,0,"L",1);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(0,4,date('jS M, Y',$claim_array['claim_date'][0]),0,1,"L",0);

					$letter -> ln(1);
					$letter -> setTextColor("250","250","250");
					$letter -> cell(25,4,'Creator',0,0,"L",1);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(0,4,$user_results['_name'].' ('.$user_region_title.', '.$user_province_title.', '.$user_hub_title.', '.$user_site_title.') ['.$user_results['phone'].']',0,1,"L",0);

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
					$letter -> cell(47,4,$claims_beneficiary_array['_name'][$this_beneficiary_index[0]],"B",0,"L",0);

					$letter -> setx(100);
					
					//$letter -> setTextColor("250","250","250");
					$letter -> cell(30,4,'Phone',1,0,"L",0);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(40,4,$claims_beneficiary_array['phone'][$this_beneficiary_index[0]],"B",1,"L",0);
					
					$letter -> ln(1);
					//$letter -> setTextColor("250","250","250");
					$letter -> cell(25,4,'NRC',1,0,"L",0);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(47,4,$claims_beneficiary_array['nrc'][$this_beneficiary_index[0]],"B",0,"L",0);
					
					$letter -> setx(100);
					//$letter -> setTextColor("250","250","250");
					$letter -> cell(30,4,'District worked from',1,0,"L",0);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(40,4,"","B",1,"L",0);
					$beneficiary_found = 1;
					
					$letter -> ln(1);
					$letter -> setFont("Arial","B",'8');
					$letter -> setFillColor("0","0","0");
					$letter -> setTextColor("250","250","250");
					$letter -> cell(0,5,$claim_type_name.$claim_type_rate,1,1,"L",1);
					$letter -> setTextColor("0","0","0");
					$letter -> cell(25,4,'Date',1,0,"L",0);
					$letter -> cell(65,4,'Site',1,0,"L",0);
					$letter -> cell(25,4,'Clients',1,0,"L",0);
					$letter -> cell(20,4,'Rate (K)',1,0,"R",0);
					$letter -> cell(25,4,'Amount (K)',1,0,"R",0);
					$letter -> cell(30,4,'Sign',1,1,"L",0);
					$letter -> setFont("Arial","",'8');
					
					
					
					$this_agent_index = array_keys($agent_array['_date'],$claims_beneficiary_array['agent_date'][$this_beneficiary_index[0]]);
					
					if(isset($this_agent_index[0])){
					
						$this_beneficiary_entry_index = array_keys($beneficiary_entries['agent_id'],$agent_array['id'][$this_agent_index[0]]);
						
						if(isset($this_beneficiary_entry_index[0])){
					
							$ben_from_date = $claims_beneficiary_array['_from'][$this_beneficiary_index[0]];
							$ben_to_date = $claims_beneficiary_array['_to'][$this_beneficiary_index[0]];
							
							$from_date = mktime(0,0,0,date('m',$ben_from_date),date('j',$ben_from_date),date('Y',$ben_from_date));
							$to_date = mktime(23,59,0,date('m',$ben_to_date),date('j',$ben_to_date),date('Y',$ben_to_date));
							
			
							$days_in_period = ($to_date-$from_date)/86400;
							
							$this_date = $from_date;
							$total_days = 0;
							for($d=0;$d<$days_in_period;$d++){					
								$found = 0;
								
								for($dt=0;$dt<count($this_beneficiary_entry_index);$dt++){
									if($beneficiary_entries['_date'][$this_beneficiary_entry_index[$dt]] >= $this_date and  $beneficiary_entries['_date'][$this_beneficiary_entry_index[$dt]] <= ($this_date+86400)){
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
									
									if(!$claims_type_array['billing_type'][$claim_type_index[0]]){
										$amount = $rate_amount;
										
									}else{
										$amount = number_format($claims_type_array['fixed_amount'][$claim_type_index[0]]);									
									
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
							$letter -> cell(25,4,number_format($claims_beneficiary_array['amount'][$this_beneficiary_index[0]],2),"B",1,"R",0);
							
						//	if($beneficiary_comment_array[$b] != ''){
								$letter -> ln(3);
								$letter -> setx(3);
								$letter -> cell(20,4,'Comment',0,0,"R",0);
								$letter -> cell(177,4,$claims_beneficiary_array['comment'][$this_beneficiary_index[0]],"B",1,"L",0);
							//}
							
							//$total_for_beneficiary += $claim_type_total;
							
							//$type_total[$c] = $claim_type_total;
							////$beneficiary_payable[$c] = $claims_beneficiary_array['paid_days'][$this_beneficiary_index[0]];
							//$total_claim_days[$c] = $total_days;
							
							$letter -> ln(5);
						}
					}
				}				
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
			
			/*for($c1=0;$c1<count($claim_type_array);$c1++){
			    if(isset($claim_name[$c1])){
				$letter -> cell(65,4,$claim_name[$c1],1,0,"L",0);
				$letter -> cell(24,4,$total_claim_days[$c1],1,0,"R",0);
				
				$this_rate_amount = $claim_rate[$c1];
				
				if(!$claim_billing_type[$c1]){
					$total_amount = $this_rate_amount*$beneficiary_payable[$c1];
					
				}else{
					//$this_rate_amount = 'Fixed';
					$total_amount = $claim_fixed_amount[$c1];
				}
				$letter -> cell(24,4,$beneficiary_payable[$c1],1,0,"R",0);
				$letter -> cell(25,4,$this_rate_amount,1,0,"R",0);
				$letter -> cell(20,4,number_format($total_amount,2),1,1,"R",0);
			    //print($this_rate_amount.'<br>');
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
			
			*/
			
			/*$letter -> cell(20,4,'Beneficiary Total',0,0,"R",0);
			$letter -> cell(25,4,number_format($total_for_beneficiary,2),"B",0,"R",0);*/
			
			/*if($beneficiary_found and $b <count($provider_beneficiary_array)-1){
				$letter -> addPage();
			
			}
		}*/	
	}
	
	$letter -> output();
}
?>