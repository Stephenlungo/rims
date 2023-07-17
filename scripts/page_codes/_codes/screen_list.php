<?php
include 'screening.php';

?>

<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
<div style="width:auto;height:20px;float:left;line-height:20px;" id="detailed_list_status_bar"></div>

<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onclick="start_screening()" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" title="Click to add entry">New</div>
</div>

<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;"><div style="width:90px;height:20px;float:left;margin-right:3px;">Date</div>
<div style="width:60px;height:20px;float:left;margin-right:3px;">Client ID</div>
<div style="width:150px;height:20px;float:left;margin-right:3px;">Names</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Phone</div>
<div style="width:80px;height:20px;float:left;margin-right:3px;">Gender</div>
<div style="width:60px;height:20px;float:left;margin-right:3px;">Age</div>
<div style="width:100px;height:20px;float:left;margin-right:3px;">Province</div><div style="width:110px;height:20px;float:left;margin-right:3px;">Hub</div><div style="width:100px;height:20px;float:left;margin-right:3px;">Facility</div><div style="width:70px;height:20px;float:left;margin-right:3px;">Risk level</div></div>

<div style="width:100%;hight:auto;float:left;" id="detailed_list_holder">
<?php
$regions = mysqli_query($connect,"select * from regions where company_id = $company_id")or die(mysqli_error($pipat_connect));		
		for($r=0;$r<mysqli_num_rows($regions);$r++){
			$region_results = mysqli_fetch_array($regions,MYSQLI_ASSOC);
			$region_id_array[$r] = $region_results['id'];
			$region_title_array[$r] = $region_results['title'];
			
		}
		
		$provinces = mysqli_query($connect,"select * from provinces where company_id = $company_id")or die(mysqli_error($pipat_connect));		
		for($p=0;$p<mysqli_num_rows($provinces);$p++){
			$province_results = mysqli_fetch_array($provinces,MYSQLI_ASSOC);
			$province_id_array[$p] = $province_results['id'];
			$province_title_array[$p] = $province_results['title'];
			
		}
		
		$hubs = mysqli_query($connect,"select * from hubs where company_id = $company_id")or die(mysqli_error($pipat_connect));
		for($h=0;$h<mysqli_num_rows($hubs);$h++){
			$hub_results = mysqli_fetch_array($hubs,MYSQLI_ASSOC);
			$hub_id_array[$h] = $hub_results['id'];
			$hub_title_array[$h] = $hub_results['title'];
			
		}
		
		$sites = mysqli_query($connect,"select * from sites where company_id = $company_id")or die(mysqli_error($pipat_connect));
		for($s=0;$s<mysqli_num_rows($sites);$s++){
			$site_results = mysqli_fetch_array($sites,MYSQLI_ASSOC);
			$site_id_array[$s] = $site_results['id'];
			$site_title_array[$s] = $site_results['title'];
			
		}
		
		$agents = mysqli_query($connect,"select * from agents where company_id = $company_id")or die(mysqli_error($pipat_connect));
		for($a=0;$a<mysqli_num_rows($agents);$a++){
			$agent_results = mysqli_fetch_array($agents,MYSQLI_ASSOC);
			$agent_id_array[$a] = $agent_results['id'];
			$agent_title_array[$a] = $agent_results['_name'];
			
		}

$clients = mysqli_query($connect,"select * from prep_clients where status = 1 and company_id = $company_id order by id desc")or die(mysqli_error($connect));

for($c=0;$c<mysqli_num_rows($clients);$c++){
	$client_results = mysqli_fetch_array($clients,MYSQLI_ASSOC);
	
	if($client_results['region_id']){			
			for($r=0;$r<count($region_id_array);$r++){
				if($region_id_array[$r] == $client_results['region_id']){
					$region_title = $region_title_array[$r];
					break;
				}
			}
			
		}else{
			$region_title = '<i>Unknown</i>';
			
		}
		
		
		if($client_results['province_id']){
			for($p=0;$p<count($province_id_array);$p++){
				if($province_id_array[$p] == $client_results['province_id']){
					$province_title = $province_title_array[$p];
					break;
				}
			}			
		}else{
			$province_title = '<i>Unknown</i>';
			
		}
		
		if($client_results['hub_id']){
			for($h=0;$h<count($hub_id_array);$h++){
				if($hub_id_array[$h] == $client_results['hub_id']){
					$hub_title = $hub_title_array[$h];
					break;
				}
			}			
		}else{
			$hub_title = '<i>Unknown</i>';
			
		}
		
		if($client_results['site_id']){
			for($s=0;$s<count($site_id_array);$s++){
				if($site_id_array[$s] == $client_results['site_id']){
					$site_title = $site_title_array[$s];
					break;
				}
			}			
		}else{
			$site_title = '<i>Unknown</i>';
			
		}
		
		if($client_results['agent_id']){
			for($a=0;$a<count($agent_id_array);$a++){
				if($agent_id_array[$a] == $client_results['agent_id']){
					$agent_title = $agent_title_array[$a];
					break;
				}
			}			
		}else{
			$agent_title = '<i>Unknown</i>';
			
		}
		
		if($client_results['risk_level'] == 0){
			$risk_level = 'No risk';
			
		}else if ($client_results['risk_level'] == 1){
			$risk_level = 'Low risk';
			
		}else if($client_results['risk_level'] == 2){
			$risk_level = 'Medium risk';
			
		}else if($client_results['risk_level'] == 3){
			$risk_level = 'High risk';
		}
		
		if($client_results['sex'] == 0){
			$client_gender = 'Male';
			
		}else{
			$client_gender = 'Female';
			
		}
	?>
	<div style="cursor:pointer;width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';"><div style="width:90px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print(date('jS M, Y',$client_results['_date']));?></div>
<div style="width:60px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_results['id']);?></div>
<div style="width:150px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_results['_name']);?></div>
<div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_results['phone']);?></div>
<div style="width:80px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_gender);?></div>
<div style="width:60px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($client_results['age']);?></div>
<div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($province_title);?></div><div style="width:110px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($hub_title);?></div><div style="width:100px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($site_title);?></div><div style="width:70px;height:auto;line-height:20px;float:left;margin-right:3px;"><?php print($risk_level);?></div></div>
	
	<?php
}
?>



</div>

<script>
//fetch_client_list();

</script>