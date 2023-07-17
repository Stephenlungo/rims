<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:10px;font-size:1.3em">Global  settings</div>



<div style="width:100%;height:auto;float:left;margin-bottom:2px;">
	<div style="width:120px;height:30px;line-height:30px;float:left;">Enable exchanger:</div>
	<div style="width:130px;min-height:30px;height:auto;float:left;line-height:30px;">
		<div style="width:auto;min-height:30px;height:auto;float:left;">
			<div class="option_item" title="Click to change option" onclick="$('#limit_login_attempts_menu').toggle('fast');" id="active_limit_login_attempts" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor='#eee';" style="width:auto;">Enabled</div>		
			
			<div class="option_menu" id="limit_login_attempts_menu" style="display:none;width:auto;">			
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_login_attempts_menu').toggle('fast');$('#active_limit_login_attempts').html($(this).html());$('#selected_limit_login_attempts').val(0);$('#limit_attempts_holder').slideUp('fast');">Disable</div>
				
				<div class="option_menu_item" onmouseover="this.style.color='#006bb3';" onmouseout="this.style.color='#000';" onclick="$('#limit_login_attempts_menu').toggle('fast');$('#active_limit_login_attempts').html($(this).html());$('#selected_limit_login_attempts').val(1);$('#limit_attempts_holder').slideDown('fast');">Enable</div>
			</div>
		</div>
		<input type="hidden" id="selected_limit_login_attempts" value="<?php print($limit_login_attempts_id);?>">
	</div>
</div>

<div style="width:100%;height:30px;line-height:30px;float:left;margin-top:10px;font-size:1.3em">External applications</div>
<div style="width:100%;height:20px;float:left;margin-top:2px;margin-bottom:2px;">
	<?php 
	if($active_user_roles[8]){
		?>
		<div class="general_button" style="float:right;height:20px;line-height:20px;background-color:#bbf;color:#fff;" onmouseover="this.style.backgroundColor = '#ccf';" onmouseout="this.style.backgroundColor = '#bbf';" onclick="fetch_item_details('external_app','0','500','','App details','',1);">Add</div>
	<?php
	}
	?>
</div>
<div style="width:100%;height:20px;line-height:20px;float:left;background-color:#eef;">
	<div style="width:80px;float:left;height:20px;">App ID</div>
	<div style="width:100px;float:left;height:20px;">Date creted</div>
	<div style="width:200px;float:left;height:20px;">App name</div>
	<div style="width:230px;float:left;height:20px;">Organisation</div>
	<div style="width:180px;float:left;height:20px;">Modules</div>
	<div style="width:180px;float:left;height:20px;">Status</div>
</div>

<?php
$apps = mysqli_query($connect,"select * from external_apps where company_id = $company_id")or die(mysqli_error($connect));


for($a=0;$a<mysqli_num_rows($apps);$a++){
	$app_results = mysqli_fetch_array($apps,MYSQLI_ASSOC);
	
	$module_string = str_replace('6',' Transport',str_replace('5',' Training',str_replace('4',' PrEP',str_replace('3',' Human Resource',str_replace('2',' Administration',str_replace('1',' Claims',str_replace("0"," RIMS Main",$app_results['module_string'])))))));
	
	$app_status = 'Inactive';
	$color = '#aaa';
	if($app_results['status']){
		$app_status = 'Active';
		$color = '#000';
	}
	
	?>
	<div style="width:100%;min-height:20px;height:auto;line-height:20px;float:left;border-bottom:solid 1px #eee;cursor:pointer;color:<?php print($color);?>" onmouseover="this.style.backgroundColor='#eee';" onmouseout="this.style.backgroundColor=''" onclick="fetch_item_details('external_app','<?php print($app_results['id']);?>','500','','App details','',1);">
		<div style="width:80px;float:left;min-height:20px;height:auto;"><?php print($app_results['id']);?></div>
		<div style="width:100px;float:left;min-height:20px;height:auto;"><?php print(date('jS M, Y',$app_results['_date']));?></div>
		<div style="width:200px;float:left;min-height:20px;height:auto;"><?php print($app_results['title']);?></div>
		<div style="width:230px;float:left;min-height:20px;height:auto;"><?php print($app_results['organisation']);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;"><?php print($module_string);?></div>
		<div style="width:180px;float:left;min-height:20px;height:auto;"><?php print($app_status);?></div>
	</div>
	<?php	
}

?>
