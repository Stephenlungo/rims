<?php 
include 'item_details.php';
?>

<?php if($company_results['_type']){?>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;"><div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_item_details('company','0','','','Company Details','',1);">Add</div></div>
<?php
}
?>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
<div style="width:250px;float:left;height:20px;">Company name</div>
<div style="width:140px;float:left;height:20px;">Phone</div>
<div style="width:180px;float:left;height:20px;">Email</div>
<div style="width:180px;float:left;height:20px;">Type</div>
<div style="width:200px;float:left;height:20px;">Notes</div>
</div>

<?php
if($company_results['_type']){
	$company_filter = '';
	
}else{
	$company_filter = ' where id = '.$company_id;
	
}


$companies = mysqli_query($connect,"select * from companies $company_filter")or die(mysqli_error($connect));
for($b=0;$b<mysqli_num_rows($companies);$b++){
	$this_company_results = mysqli_fetch_array($companies,MYSQLI_ASSOC);
	
	if($this_company_results['status']){
		$color = '#000';
		
	}else{
		$color = '#aaa';
		
	}
	
	if($this_company_results['_type']){
		$company_type = 'Super administrator';
		
	}else{
		$company_type = 'Standard';
	}

	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor='';" onclick="fetch_item_details('company','<?php print($this_company_results['id']);?>','','','Company Details','',1);">
	<div style="width:250px;float:left;min-height:20px;height:auto;"><?php print($this_company_results['_name']);?></div>
	<div style="width:140px;float:left;min-height:20px;height:auto;"><?php print($this_company_results['tel']);?></div>
	<div style="width:180px;float:left;min-height:20px;height:auto;"><?php print($this_company_results['email']);?></div>
	<div style="width:180px;float:left;min-height:20px;height:auto;"><?php print($company_type);?></div>
	<div style="width:200px;float:left;min-height:20px;height:auto;"><?php print($this_company_results['details']);?></div>
	</div>
	<?php
}
?>
