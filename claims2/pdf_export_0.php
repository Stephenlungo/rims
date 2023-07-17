<?php

include 'scripts/short_connector.php';
require("scripts/fpdf.php");

$company_id = 1;

if(isset($_GET['m']) and isset($_GET['k']) and $_GET['k'] == 'hblhsbsrbefibuqpufubnslnlquigrw2187768'){
	$memo_date = $_GET['m'];
	
	$this_memo = mysqli_query($connect,"select * from memos where _date = '$memo_date' and company_id = $company_id")or die(mysqli_error($connect));
	
	
	$this_memo_results = mysqli_fetch_array($this_memo,MYSQLI_ASSOC);
	
	$this_budget = mysqli_query($connect,"select * from budgets where memo_date = '$memo_date' and company_id = $company_id")or die(mysqli_error($connect));
	$this_budget_results = mysqli_fetch_array($this_budget,MYSQLI_ASSOC);
	
	$budget_user_date = $this_budget_results['user_date'];
	$budget_user = mysqli_query($claims_connect,"select * from users where _date = '$budget_user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
	
	if(!mysqli_num_rows($budget_user)){
		$budget_user = mysqli_query($pipat_connect,"select * from users where _date = '$budget_user_date' and company_id = $company_id")or die(mysqli_error($pipat_connect));
	}
	
	$budget_user_results = mysqli_fetch_array($budget_user,MYSQLI_ASSOC);
	
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
		
	
	$letter = new FPDF("P","mm","A4");
	$letter -> SetTitle('PIPAT Bills Tracker');
	$letter -> setSubject('PIPAT Bills Tracker');
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
	$letter -> cell(130,5,$this_memo_results['title'].' - '.$this_memo_results['subject'].' - '.$this_memo_results['objective'],1,2,"l",0);
	
	$range_days = ceil(($this_memo_results['return_date'] - $this_memo_results['departure_date']) / 86400);
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Date range:',1,0,"l",0);
	$letter -> setx(62);
	$letter -> cell(130,5,date('jS M, Y',$this_memo_results['departure_date']).' to '.date('jS M, Y',$this_memo_results['return_date']).' ('.$range_days.' days)',1,2,"l",0);
	
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Locations:',1,0,"l",0);
	$letter -> setx(62);
	$letter -> cell(130,5,$location_string,1,2,"l",0);
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Facilitators / Staff:',1,0,"l",0);
	$letter -> setx(62);
	$letter -> cell(130,5,$staff_string,1,2,"l",0);
	
	$letter -> setx(10);
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
	
	$letter -> cell(130,5,$num_participants,1,2,"l",0);
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Activity number:',1,0,"l",0);
	$letter -> setx(62);
	
	$letter -> cell(130,5,$this_memo_results['budget_code'],1,2,"l",0);
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Budget prepared by:',1,0,"l",0);
	$letter -> setx(62);
	
	$letter -> cell(130,5,$budget_user_results['_name'],1,2,"l",0);
	
	$letter -> setx(10);
	$letter -> cell(50,5,'Date prepared:',1,0,"l",0);
	$letter -> setx(62);
	
	$letter -> cell(130,5,date('jS M, Y',$this_budget_results['budget_date']),1,2,"l",0);
	
	$letter -> ln(5);
	$letter -> setx(10);
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
	$conference_string = explode('~|',$this_budget_results['conference_string']);	
	for($c=0;$c<count($conference_string);$c++){
		$this_conference = explode("~}",$conference_string[$c]);
		$letter -> cell(77,5,$this_conference[0],"B",0,"l",0);
		$letter -> setx(89);
		$letter -> cell(20,5,$this_conference[2],"B",0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,5,$this_conference[1],"B",0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,number_format($this_conference[3],2),"B",2,"R",0);		
		$letter -> setx(10);
	}
	
	$letter -> setFont("Arial","B",'8');
	$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
	$letter -> setx(138);
	$letter -> cell(25,5,number_format($this_budget_results['conference_total'],2),"B",2,"R",0);
	
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
	$letter -> cell(187,5,'d) Distribution of Funds for Lodging / Facilities',0,2,"l",0);
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
	$letter -> setTextColor(255,255,255);
	$letter -> cell(23,5,'K'.number_format($this_budget_results['meal_total']+$this_budget_results['conference_total']+$this_budget_results['accommodation_total'],2),"B",2,"R",2);
	
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
		$letter -> cell(20,5,$this_mie[2],"B",0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,5,$this_mie[3],"B",0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,$this_mie[4],"B",2,"R",0);
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
		$letter -> cell(20,5,$this_mie[2],"B",0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,5,$this_mie[3],"B",0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,$this_mie[4],"B",2,"R",0);
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
	$letter -> setTextColor(255,255,255);
	$letter -> cell(23,5,'K'.number_format($this_budget_results['staff_mie_total']+$this_budget_results['participant_mie_total'],2),"B",2,"R",2);
	
	$letter -> setTextColor(0,0,0);
	$letter -> setx(10);
	$letter -> setFont("Arial","B",'8');
	$letter -> cell(187,5,'c) Transport Refunds',0,2,"l",0);
	
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
		$letter -> cell(20,5,$this_refund[2],"B",0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,5,$this_refund[3],"B",0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,$this_refund[4],"B",2,"R",0);
		$letter -> setx(10);
	}
	$letter -> setFont("Arial","B",'8');
	$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
	$letter -> setx(138);
	$letter -> cell(25,5,number_format($this_budget_results['refund_total'],2),"B",2,"R",0);
	
	
	$letter -> setTextColor(0,0,0);
	$letter -> setx(10);
	$letter -> setFont("Arial","B",'8');
	$letter -> cell(187,5,'d) Miscellaneous requirements',0,2,"l",0);
	
	$letter -> cell(55,4,'Name',1,0,"l",0);
	$letter -> setx(67);
	$letter -> cell(20,4,'Item',1,0,"R",0);
	$letter -> setx(89);
	$letter -> cell(20,4,'Qty',1,0,"R",0);
	$letter -> setx(111);
	$letter -> cell(25,4,'Days',1,0,"R",0);
	$letter -> setx(138);
	$letter -> cell(25,4,'Unit',1,2,"R",0);
	$letter -> setx(10);
	
	$letter -> setFont("Arial","",'8');
	$refund_string = explode('~|',$this_budget_results['refund_string']);	
	for($r=0;$r<count($refund_string);$r++){
		$this_refund = explode("~}",$refund_string[$r]);
		$letter -> cell(55,5,$this_refund[0],"B",0,"l",0);
		$letter -> setx(67);
		$letter -> cell(20,5,$this_refund[1],"B",0,"R",0);
		$letter -> setx(89);
		$letter -> cell(20,5,$this_refund[2],"B",0,"R",0);
		$letter -> setx(111);
		$letter -> cell(25,5,$this_refund[3],"B",0,"R",0);
		$letter -> setx(138);
		$letter -> cell(25,5,$this_refund[4],"B",2,"R",0);
		$letter -> setx(10);
	}
	$letter -> setFont("Arial","B",'8');
	$letter -> cell(126,5,'Sub-Total',0,0,"R",0);
	$letter -> setx(138);
	$letter -> cell(25,5,number_format($this_budget_results['refund_total'],2),"B",2,"R",0);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	$letter -> output();
	
}else{
	print('Illegal access of claims spreadsheet. Contact PIPAT administrator');
}
?>