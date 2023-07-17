<?php
$claim_approvals_results = mysqli_fetch_array($claim_approvals,MYSQLI_ASSOC);
$user_date = $claim_approvals_results['user_date'];
$approval_user = mysqli_query($connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($connect));
$approval_user_results = mysqli_fetch_array($approval_user,MYSQLI_ASSOC);

if($claim_approvals_results['status'] == 0){
	$background_color = 'brown';
	$hover_color = '#852828';
	$text_color = 'white';
	$comment = $claim_approvals_results['comment'].' (by: '.$approval_user_results['_name'].', Date: '.date('jS M, Y',$claim_approvals_results['_date']).', Time: '.date('H:i:s',$claim_approvals_results['_date']).')';
	$title = '&#8592;';
	
}else if($claim_approvals_results['status'] == 1){
	if($this_beneficiary_results['denied']){
		$background_color = '#c33eaa';
		$hover_color = '#53a953';
		
	}else{
		$background_color = '#6ac96a';
		$hover_color = '#53a953';
	}
	
	$text_color = 'white';
	$comment = 'Confirmed by: '.$approval_user_results['_name'].', Date: '.date('jS M, Y',$claim_approvals_results['_date']).', Time: '.date('H:i:s',$claim_approvals_results['_date']);
	$title = '&#8594;';
}
?>
<div style="border-radius:0px;text-align:center;width:100px;height:20px;line-height:20px;float:left;<?php print('color:'.$text_color.';background-color:'.$background_color.';');?>" title="<?php print($comment);?>" onmouseover="this.style.backgroundColor='<?php print($hover_color);?>';" onmouseout="this.style.backgroundColor='<?php print($background_color);?>';">
<?php print($title);?>
</div>

<?php	