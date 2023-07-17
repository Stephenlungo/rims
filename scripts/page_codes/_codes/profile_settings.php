<?php

include 'image_uploader.php';

?>

<div style="width:58%;height:auto;float:left;">
<div style="width:100%;height:30px;float:left;margin-top:10px;line-height:30px;" id="profile_themes">
<div style="width:135px;height:30px;float:left;font-weight:bold;">Background Theme:</div>

<input type="hidden" id="current_theme_ind" value="<?php print($user_results['theme_ind']);?>">
<input type="hidden" id="active_theme_ind" value="-1">
<script>
var active_theme_ind = $('#active_theme_ind').val();
var theme_image_string = $('#theme_imgs').val();
var theme_title_string = $('#theme_titles').val();

var theme_image_array = theme_image_string.split('|');
var theme_title_array = theme_title_string.split('|');

for(var t=-1;t<theme_title_array.length;t++){
	
	if($('#current_theme_ind').val() == t){
		bg_color='006bb3';
		color = '#fff';
		active_theme_ind = t;
		show_theme_previews(t);
	}else{
		bg_color='';
		color = '#000';
		
	}
	
	if(t==-1){
		theme_title = 'None';
		
	}else{
		theme_title = theme_title_array[t];
	}

var theme_div = '<div style="cursor:pointer;min-width:50px;width:auto;padding-left:5px;padding-right:5px;height:30px;float:left;margin-right:5px;line-height:30px;text-align:center;border:solid 1px #ccc;background-color:'+bg_color+';color:'+color+';" onmouseover="this.style.borderColor=\'orange\'" onmouseout="this.style.borderColor=\'#ccc\'" onclick="$(\'#theme_button_\'+active_theme_ind).css(\'background-color\',\'#fff\');$(\'#theme_button_\'+active_theme_ind).css(\'color\',\'#000\');$(this).css(\'background-color\',\'#006bb3\');$(this).css(\'color\',\'#fff\');active_theme_ind='+t+';show_theme_previews('+t+')" id="theme_button_'+t+'">'+theme_title+'</div>';

$('#profile_themes').append(theme_div);

}

function show_theme_previews(ind){
	$('#current_theme_ind').val(ind);
	if(ind == -1){
		$('#profile_theme_images').html('');
		
	}else{
		var these_images = theme_image_array[ind];		
		var these_images_array = these_images.split(',');
		
		
		
		
		var profile_theme_image_strings = '';
		for(i=0;i<these_images_array.length;i++){
			profile_theme_image_strings += '<div style="cursor:pointer;width:86px;height:85px;float:left;border:solid 1px #ddd;margin:3px;" onmouseover="this.style.borderColor=\'orange\';" onmouseout="this.style.borderColor=\'#ddd\';" title="Click to preview on background"><img src="'+$('#code_url').val()+'/imgs/default_bg_images/'+these_images_array[i]+'" style="width:100%;height:100%;" onclick="change_background_image(\''+these_images_array[i]+'\');"></div>';
		}		
		$('#profile_theme_images').html(profile_theme_image_strings);
	}
}

function change_background_image(img_src){
	var current_image = $('#code_url').val()+'/imgs/default_bg_images/'+img_src;
	$('#main_body').css("backgroundImage","url('"+current_image+"')");
	
}
</script>

</div>

<div style="width:100%;height:auto;float:left;background-color:#eee;margin-top:10px;">
<div style="width:100%;height:auto;float:left;line-height:30px;" id="profile_theme_images">
</div>

<div style="width:100%;height:30px;float:left;margin-top:5px;margin-bottom:10px;line-height:30px;">
<div style="width:90px;height:30px;background-color:green;color:#fff;text-align:center;line-height:30px;float:left;margin-left:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#7a7';" onmouseout="this.style.backgroundColor='green';"  id="apply_them_button" onclick="apply_theme();" title="Click to save current theme settings">Apply Theme</div>
</div>
</div>
</div>


<div style="width:40%;min-height:320px;height:auto;float:left;margin:5px;">
<div style="width:100%;height:30px;float:left;line-height:30px;text-align:center;" title="Double click to remove" ondblclick="var c = confirm('Are you sure you wish to remove your picture?');if(c){$('#uploaded_file').val('');save_profile_image()};">Your Picture</div>
<div style="width:100%;height:320px;float:left;border:solid 1px #ddd;padding:5px;" id="profile_image" onclick="open_uploader('save_profile_image()',0);" title="Click to change profile picture" >
<?php 
if($user_results['img_src'] == ''){
	if($user_results['gender'] == 1){
		$file_src = $code_url.'/imgs/male_user_icon.jpg';
		
	}else{
		$file_src = $code_url.'/imgs/female_user_icon.jpg';
		
	}
	
}else{
	$file_src = $main_url.'/imgs/'.$user_results['img_src'];
}
?>
	<img src="<?php print($file_src);?>" style="width:100%;height:100%;">
	</div>
</div>