<?php
include 'edit_memo.php';
include 'image_uploader.php';
include 'deny_comment.php';

$memos = mysqli_query($connect,"select * from memos where company_id = $company_id and complete_status = $a and approval_status != 2 order by id desc")or die(mysqli_error($connect));

if(!mysqli_num_rows($memos)){
	print('<div style="width:100%;height:20px;float:left;text-align:center;line-height:20px;color:red;font-weight:bold;">No records where found</div>');
	
}else{
	for($m=0;$m<mysqli_num_rows($memos);$m++){
		
		$memo_results = mysqli_fetch_array($memos,MYSQLI_ASSOC);
		$memo_id = $memo_results['id'];
		
		$request_type = $memo_results['request_type'];
		$this_request_type = mysqli_query($connect,"select * from request_types where id = $request_type")or die(mysqli_error($connect));
		$this_request_type_results = mysqli_fetch_array($this_request_type,MYSQLI_ASSOC);
		
		$user_date = $memo_results['user_date'];
		$this_user = mysqli_query($pipat_connect,"select * from users where _date = '$user_date' and company_id = $company_id")or die(mysqli_error($pipat_connect));
		
		if(!mysqli_num_rows($this_user)){
			$this_user = mysqli_query($claims_connect,"select * from users where _date = '$user_date' and companyID = $company_id")or die(mysqli_error($claims_connect));
		}
		$this_user_results = mysqli_fetch_array($this_user,MYSQLI_ASSOC);
		
		if(!$this_user_results ['region_id']){
			$region_title = '<i>Unspecified region</i>';
			
		}else{
			$region_id = $this_user_results ['region_id'];
			$this_region = mysqli_query($pipat_connect,"select * from regions where id = $region_id")or die(mysqlI_error($pipat_connect));
			$this_region_results = mysqli_fetch_array($this_region,MYSQLI_ASSOC);
			$region_title = $this_region_results['title'];
		}
		
		
		if(!$this_user_results['province_id']){
			$province_title = '<i>Unspecified province</i>';
			
		}else{
			$province_id = $this_user_results['province_id'];
			$this_province = mysqli_query($pipat_connect,"select * from provinces where id = $province_id")or die(mysqli_error($pipat_connect));
			$this_province_results = mysqli_fetch_array($this_province,MYSQLI_ASSOC);
			$province_title = $this_province_results['title'];
		}
		
		if(isset($this_user_results['hub_id'])){
			$hub_id = $this_user_results['hub_id'];
			
		}else{
			$hub_id = $this_user_results['district_id'];
			
		}
		
		if(!$hub_id){
			$hub_title = '<i>Unspecified hub</i>';
			
		}else{
			$hub_id = $this_user_results['hub_id'];
			$this_hub = mysqli_query($pipat_connect,"select * from districts where id = $hub_id")or die(mysqli_error($pipat_connect));
			$this_hub_results = mysqli_fetch_array($this_hub,MYSQLI_ASSOC);
			
			$hub_title = $this_hub_results['title'];
		}
		
		if(!$this_user_results['site_id']){
			$site_title = '<i>Unspecified site</i>';
			
		}else{
			$site_id = $this_user_results['site_id'];
			$this_site = mysqli_query($pipat_connect,"select * from sites where id = $site_id")or die(mysqli_error($pipat_connect));
			$this_site_results = mysqli_fetch_array($this_site,MYSQLI_ASSOC);
			
			$site_title = $this_site_results['title'];
		}
		
		if(isset($this_user_results['unit_id'])){
			$unit_id = $this_user_results['unit_id'];
			
		}else{
			$unit_id = 0;
			
		}
		
		if(!$unit_id){
			$unit_title = '<i>Unspecified unit</i>';
			
		}else{
			$unit_id = $this_user_results['unit_id'];
			$this_unit = mysqli_query($pipat_connect,"select * from services where id = $unit_id")or die(mysqli_error($pipat_connect));
			$this_unit_results = mysqli_fetch_array($this_unit,MYSQLI_ASSOC);
			
			$unit_title = $this_unit_results['title'];
		}
		?>
		
		<script>
			var color_toggle_<?php print($memo_id);?> = '';
			var color_text_toggle_<?php print($memo_id);?> = '';
			var memo_approval_direction_<?php print($memo_id);?> = <?php print($memo_results['approval_direction']);?>;

			function color_toggle_act_<?php print($memo_id);?>(color_1,color_2){
				$('#claim_<?php print($memo_id);?>_title').fadeOut(50);
				$('#claim_<?php print($memo_id);?>_title').fadeIn(300);
				
				if(color_toggle_<?php print($memo_id);?> == color_1){
					color_toggle_<?php print($memo_id);?> = color_2;
					
					return color_2;
					
				}else{
					color_toggle_<?php print($memo_id);?> = color_1;
					send_bill_xmlhttp_<?php print($memo_id);?>();
					
					return color_1;
				}
				
				
			}

			function color_text_toggle_act_<?php print($memo_id);?>(color_1,color_2){
				if(color_text_toggle_<?php print($memo_id);?> == color_1){
					color_text_toggle_<?php print($memo_id);?> = color_2;
					return color_2;
					
				}else{
					color_text_toggle_<?php print($memo_id);?> = color_1;
					return color_1;
				}
			}
				
			if(window.XMLHttpRequest){
				bill_general_xmlhttp_<?php print($memo_id);?> = new XMLHttpRequest();

			}else{
				bill_general_xmlhttp_<?php print($memo_id);?> = new ActiveXObject("Microsoft.XMLHTTP");
				
			}
			
			bill_general_xmlhttp_<?php print($memo_id);?>.onreadystatechange = function(){
				if(bill_general_xmlhttp_<?php print($memo_id);?>.readyState == 4 && bill_general_xmlhttp_<?php print($memo_id);?>.status == 200){
					var response_text = bill_general_xmlhttp_<?php print($memo_id);?>.responseText;
					var response_array = response_text.split('|||');
					if(response_array[0] == 'fetch_bill_approvals'){
						
						//display_infor('item_approvals_<?php print($m);?>',response_array[1]);
						$('#item_approvals_<?php print($memo_id);?>').html(response_array[1]);

						animate_bill_direction(<?php print($memo_id);?>);
						
					}else if(response_array[0] == 'session_expired'){
						alert('Session has expired. You will be re-directed to sign in page...');
						window.open($('#url').val(),'_self');
					}else{
						alert(response_array[0]);
						
					}
				}
			}
					
			function send_bill_xmlhttp_<?php print($memo_id);?>(){
				var data = new FormData()
				data.append('fetch_bill_approvals',1);
				data.append('memo_date','<?php print($memo_results['_date']);?>');
				bill_general_xmlhttp_<?php print($memo_id);?>.open('POST','general_xmlhttp_processor.php',true);
				bill_general_xmlhttp_<?php print($memo_id);?>.send(data);
			}
				
				
			function animate_bill_direction(memo_id){
				$('#item_direction_'+memo_id).fadeIn('slow');
				
				if(memo_approval_direction_<?php print($memo_id);?> == 1){
					$('#item_direction_'+memo_id).html('>>');
					$('#item_direction_'+memo_id).css('marginLeft','0px');
					$('#item_direction_'+memo_id).animate({marginLeft:(900) + 'px'},2000);
				
				}else{
					$('#item_direction_'+memo_id).html('<<');
					$('#item_direction_'+memo_id).css('marginLeft','900px');
					$('#item_direction_'+memo_id).animate({marginLeft:(0) + 'px'},2000);
				
				}
				
				$('#item_direction_'+memo_id).fadeOut('slow');
			}
		</script>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	<div style="width:99.5%;min-height:15px;height:auto;float:left;background-color:<?php print($this_request_type_results['color_code']);?>;border:solid 1px #aaa;line-height:20px;text-align:left;cursor:pointer;margin-top:2px;padding:2px;" onclick="$('#item_approvals_<?php print($memo_id);?>').slideToggle('fast');$(this).css('background-color',color_toggle_act_<?php print($memo_id);?>('#44aeb3','<?php print($this_request_type_results['color_code']);?>'));$(this).css('color',color_text_toggle_act_<?php print($memo_id);?>('#fff','<?php print($memo_id);?>'));" onmouseover="this.style.borderColor='green';" onmouseout="this.style.borderColor='#aaa';" id="memo_<?php print($memo_id);?>_title">
	<div style="width:100%;min-height:20px;height:auto;float:left;font-size:1em;font-weight:bold;"><?php print($memo_results['id'].': '.$memo_results['title']);?> (<?php print($this_request_type_results['title']);?>)</div>

	<div style="width:100%;height:15px;float:left;line-height:15px;font-size:0.9em;"><?php print($region_title.', '.$province_title.', '.$hub_title.', '.$site_title.', '.$unit_title.', Date: '.date('jS M, Y',$memo_results['_date']).' ('.$this_user_results['_name'].' - '.$this_user_results['phone'].')');?></div>
	</div>


	<div style="width:99.5%;height:auto;float:left;border:solid 1px #44aeb3;line-height:20px;overflow:auto;display:none;padding:2px;margin-bottom:10px;" id="item_approvals_<?php print($memo_id);?>" >
	<div style="width:100%;height:200px;text-align:center;float:left;font-size:1.1em;" >
	<div style="width:100%;height:20px;float:left;margin-top:70px;">
	Loading approval levels. One moment please...</div>
	<div style="width:100%;height:20px;float:left;">
	<img src="http://localhost/blueraysit.com/imgs/loading.gif">
	</div>
	</div>
	</div>
	<?php
	}
}
?>

<script>
$('#count_<?php print($a);?>').html('<?php print(mysqli_num_rows($memos));?>');
</script>