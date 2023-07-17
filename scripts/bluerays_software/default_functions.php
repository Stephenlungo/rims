<?php
function create_login_page($login_array){
	include 'scripts/login/start.php';
}

function create_query_menu($title,$output_id,$default_value,$default_value_title,$query,$result_column){
	$output_string = '<div class="option_lebel">'.$title.':</div><div style="width:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#'.$output_id.'_menu\').toggle(\'fast\');" id="active_'.$output_id.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';">Select item</div><div class="option_menu" id="'.$output_id.'_menu" style="display:none;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#'.$output_id.'_menu\').fadeOut(\'fast\');$(\'#'.$output_id.'\').val('.$default_value.');$(\'#active_'.$output_id.'\').html($(this).html());" style="min-width:100px;">'.$default_value_title.'</div>';

	for($t=0;$t<mysqli_num_rows($query);$t++){
		$query_results = mysqli_fetch_array($query,MYSQLI_ASSOC);
		
		$output_string .= '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#'.$output_id.'_menu\').fadeOut(\'fast\');$(\'#'.$output_id.'\').val('.$query_results['id'].');$(\'#active_'.$output_id.'\').html($(this).html());" style="min-width:100px;">'.$query_results[$result_column].'</div>';
	}

	$output_string .= '<input type="hidden" id="'.$output_id.'" value="'.$default_value.'"></div></div>';
	return $output_string;
}

function create_list_menu($title,$output_id,$default_value,$default_value_title,$list,$list_values){
	$output_string = '<div class="option_lebel">'.$title.':</div><div style="width:auto;float:left;"><div class="option_item" title="Click to change option" onclick="$(\'#'.$output_id.'_menu\').toggle(\'fast\');" id="active_'.$output_id.'" onmouseover="this.style.backgroundColor=\'#ddd\';" onmouseout="this.style.backgroundColor=\'#eee\';">Select item</div><div class="option_menu" id="'.$output_id.'_menu" style="display:none;"><div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#'.$output_id.'_menu\').fadeOut(\'fast\');$(\'#'.$output_id.'\').val('.$default_value.');$(\'#active_'.$output_id.'\').html($(this).html());" style="min-width:100px;">'.$default_value_title.'</div>';
	

	for($l=0;$l<count($list);$l++){	
		$output_string .= '<div class="option_menu_item" onmouseover="this.style.color=\'#006bb3\';" onmouseout="this.style.color=\'#000\';" onclick="$(\'#'.$output_id.'_menu\').fadeOut(\'fast\');$(\'#'.$output_id.'\').val('.$list_values[$l].');$(\'#active_'.$output_id.'\').html($(this).html());" style="min-width:100px;">'.$list[$l].'</div>';
	}

	$output_string .= '<input type="hidden" id="'.$output_id.'" value="'.$default_value.'"></div></div>';
	return $output_string;
}

function create_menu_bar($menus,$width,$menu_title){
	if($width == ''){
		$width = '100%';
		
	}
	
	$output_string = '<div style="width:'.$width.';min-height:30px;height:auto;float:left;background-color:#ddd;border:solid 1px #aaa;">';
	
	if(isset($menu_title)){
		$output_string .= '<div style="width:100%;height:20px;float:left;line-height:20px;text-align:center;color:#999;border-bottom:solid 1px #aaa;">'.$menu_title.'</div>';
	}
	
	if($menus != ''){
		for($i=0;$i<count($menus);$i++){
			$output_string .= $menus[$i];		
		}
	}
	
	$output_string .= '</div>';
	
	return $output_string;
}

function sky_compute($input_script){
	$output_script = '';
	$input_script_array = explode("{",$input_script);
	for($t=0;$t<count($input_script_array);$t++){
		$function_string = '<div style="width:100%;height:auto;float:left;" id="function_'.$t.'">';
		$input_script_function_array = explode("};",$input_script_array);
		
		$this_function_array = explode('.',$input_script_function_array[0]);
		
		if(isset($this_function_array[1])){
			$this_function_name = $this_function_array[1];
			$parent_id = $this_function_array[0];
			
		}else{
			$this_function_name = $this_function_array[0];
			$parent_id = '';
		}
		
		$this_function_code = $input_script_function_array[1];
		
		$code_functions = explode(')',$this_function_code);
		for($s=0;$s<count($code_functions);$s++){
			if($code_functions[$s] != ''){
				$function_array = explode('(',$code_functions[$s]);
				$function_names[$s] = $function_array[0];
				
				if(isset($function_array[1])){
					$function_attributes[$t] = '$'.str_replace(';',';$',$function_array[1]);
					if(substr($function_attributes[$t],strlen($function_attributes[$t])-1,strlen($function_attributes[$t])) == '$'){
						$function_attributes[$t] = substr($function_attributes[$t],0,strlen($function_attributes[$t])-2);
						
					}
					
					$variable_list[0] = $function_attributes[$t].'~'.$t;
					
				}else{				
					$variable_list[0] = '~'.$t;
					
				}	
				$function_string .= call_user_func_array($function_names[$t],$variable_list);
				
				$output_script .= $function_string;
			}
		}
	}
	
	return $output_script;
}

function check_item_in_list($item,$list,$list_type,$delimiter){
	if(!$list_type){
		$list = explode($delimiter,$list);
		
	}
	
	$found = 0;
	for($i=0;$i<count($list);$i++){
		if($item == 0 and $list[$i] === ''){
			$found = 0;
			
		}else if($item == $list[$i]){
			$found = 1;
			
		}
	}
	
	return $found;
}

/*function sky_compute($input_script){
	$script_functions = explode('};',$input_script);
	
	$output_script = '';
	for($t=0;$t<count($script_functions);$t++){
		if($script_functions[$t] != ''){
			$function_parrent_array = explode('{',$script_functions[$t]);
			
			$script_sub_functions = explode('}',$function_parrent_array[1]);
			
			for($s=0;$s<count($script_sub_functions);$s++){
				if($script_sub_functions[$s] != ''){
					$function_array = explode('{',$script_sub_functions[$s]);
					$function_names[$s] = $function_array[0];
					
					if(isset($function_array[1])){
						$function_attributes[$t] = '$'.str_replace(';',';$',$function_array[1]);
						if(substr($function_attributes[$t],strlen($function_attributes[$t])-1,strlen($function_attributes[$t])) == '$'){
							$function_attributes[$t] = substr($function_attributes[$t],0,strlen($function_attributes[$t])-2);
							
						}
						
						$variable_list[0] = $function_attributes[$t].'~'.$t;
						
					}else{
						
						$variable_list[0] = '~'.$t;
						
					}	
					$function_string = call_user_func_array($function_names[$t],$variable_list);
					
					$output_script .= $function_string;
				}
			}
		}
	}
	
	return $output_script;
}*/

function create_slide_button($variables){
	$input_variables = explode('~',$variables);
	$item_index = $input_variables[1];
	
	$width='100%';
	$height='20px';
	$background_color='#eef';
	$text_color='#000';
	$text_align='center';
	$font_size='0.9em';
	$button_label='My button';
	$slider_height='auto';
	$slider_min_height='50px';
	$slider_background_color='#eee';
	$slider_content='';
	$margin_top='0px';
	$margin_bottom='0px';
	$id = 'filter_options_'.$item_index;
	$padding = '2px';

	$variables = explode(";",$input_variables[0]);
	for($v=0;$v<count($variables);$v++){
		if($variables[$v] != ''){
			eval($variables[$v].';');
		}
	}
	
	$output_string = '<div style="width:'.$width.';height:auto;float:left;"><div style="width:100%;height:'.$height.';margin-top:'.$margin_top.';line-height:20px;float:left;background-color:#eef;text-align:'.$text_align.';cursor:pointer;" onclick="$(\'#'.$id.'\').slideToggle(\'fast\');" onmouseover="this.style.backgroundColor=\'#ddf\';" onmouseout="this.style.backgroundColor=\'#eef\';">'.$button_label.'</div><div style="width:99.6%;height:'.$slider_height.';float:left;display:none;background-color:'.$slider_background_color.';border-top:solid 1px #ddd;border-bottom:solid 1px #ddd;padding-bottom:5px;margin-bottom:'.$margin_bottom.';padding:'.$padding.'" id="'.$id.'">'.$slider_content.'</div></div>';
	
	return $output_string;
}

function uploadFile($formField, $fileName, $fileSize, $uploadDirectory,$fileExtension){
	if($fileExtension == 'image'){
		$fileExtension = 'jpg,JPG,jpeg,JPEG,bmp,BMP,gif,GIF,pdf';
	}
	$uploadError = '';
$uploaddir = $uploadDirectory;

$fileType = explode('/', $_FILES[$formField]["type"]);
$originalFileName = basename($_FILES[$formField]["name"]);

if($fileName == ''){
	$originalFileName = explode('.',$originalFileName);
	
	
	$this_file_name  = '';
	for($i=0;$i<count($originalFileName);$i++){
		
		if($i < count($originalFileName)-1){
			if($this_file_name == ''){
				$this_file_name = $file_name_array[$i];
				
			}else{
				$this_file_name .= '.'.$file_name_array[$i];
			}
		}
	}
	
	$fileName = str_replace(","," ",$this_file_name);	
}
	if(!isset($fileType[1])){
		$extension = 'file';
		
	}else{
		$extension = $fileType[1];
	
	}
	
	if($extension == 'vnd.openxmlformats-officedocument.spreadsheetml.sheet'){
		$extension = 'xlsx';
		
	}else if($extension == 'vnd.ms-excel'){
		$extension = 'xls';
		
	}else if ($extension == 'msword'){
		$extension = 'doc';
		
	}else if($extension == 'vnd.openxmlformats-officedocument.wordprocessingml.document'){
		$extension = 'docx';
		
	}else if($extension == 'vnd.ms-powerpoint'){
		$extension = 'ppt';
		
	}else if($extension == 'vnd.openxmlformats-officedocument.presentationml.presentation'){
		$extension = 'pptx';
		
	}else if($extension == 'vnd.openxmlformats-officedocument.presentationml.slideshow'){
		$extension = 'ppsx';
		
	}else if($extension == 'octet-stream'){
		$extension = 'tdbx';
		
	}else if($extension == 'x-zip-compressed'){
		$extension = 'zip';
		
	}else if($extension == 'plain'){
		$extension = 'txt';
		
	}else if($extension == 'x-msdownload'){
		$extension = 'exe';
		
	}
	
	if($fileExtension != 'all' and (!strstr($fileExtension,']'))){

		if(!strstr($fileExtension,$extension)){	
			$uploadError = 'File type. Provided: '.$extension.', Required: '.$fileExtension;
		}
	}	


	$newFileName = $fileName.'.'.$extension;
	$uploadfile = $uploaddir.$newFileName;
	
	if(file_exists($uploadfile)){
		$newFileName = $fileName.'_'.time().'.'.$extension;
		$uploadfile = $uploaddir.$newFileName;
	}

	if($fileSize != 0){
	if($_FILES[$formField]["size"] > $fileSize){
		if($uploadError === ''){
	$uploadError = 'File size';
		}else{
			$uploadError .= ',File size';
		}
	}
	}

	$returnValue[0] = 0;
	$returnValue[1] = '';
	if($uploadError == ''){
	if (move_uploaded_file($_FILES[$formField]['tmp_name'], $uploadfile)){
		
		if(strstr($fileExtension,']')){
			$forcedExtensionArray = explode(']',$fileExtension);
			$newExtension = $forcedExtensionArray[1];
			$newFileName = $fileName.'.'.$newExtension;
			$newUploadFile = $uploaddir.$newFileName;
			rename($uploadfile,$newUploadFile);
		}

		$returnValue[0] = 1;
		$returnValue[1] = $newFileName;
		$returnValue[2] = $_FILES[$formField]["size"];
		$returnValue[3] = $extension;
		
		return $returnValue;
		
	}else{
		$returnValue[0] = 0;
		$returnValue[1] = 'Unknown error '.$_FILES[$formField]["error"];
		return $returnValue;
	}

	}else{
		$returnValue[0] = 0;
		$returnValue[1] = $uploadError;
		return $returnValue;
	}
}

function create_time_jq($input_data){
	$input_date_array = explode("/",$input_data);
	
	$time_stamp = mktime(0,0,0,$input_date_array[0],$input_date_array[1],$input_date_array[2]);
	return $time_stamp;
}

function get_column_names($sqli_query,$return_type){
	$return_array = array();
	$return_string = '';
	for($i=0;$i<mysqli_num_fields($sqli_query);$i++){
		$field_set = mysqli_fetch_field($sqli_query);
		$field_name = $field_set->name;
		
		$return_array[$i] = $field_name;
		
		if($return_string == ''){
			$return_string = $field_name;
			
		}else{
			$return_string .= ','.$field_name;
			
		}		
	}
	
	if(!$return_type){
		return $return_array;
		
	}else{
		return $return_string;
	}
}

function fetch_db_table($connection,$table_name,$company_id,$ordering,$filter_string){
	if(!isset($ordering)){
		$ordering = 'id';
	}
	
	if($filter_string != ''){
		$filter_string = ' and '.$filter_string;
		
	}
	
	//print("select * from $table_name where company_id = $company_id $filter_string order by $ordering");
	
	$table_query = mysqli_query($GLOBALS[$connection],"select * from $table_name where company_id = $company_id $filter_string order by $ordering")or die(mysqli_error($GLOBALS[$connection]));
	
	
	
	$table_columns = get_column_names($table_query,0);
	for($c=0;$c<count($table_columns);$c++){
		$table_array[$table_columns[$c]] = array();
	}
	
	for($tr=0;$tr<mysqli_num_rows($table_query);$tr++){
		$table_query_results = mysqli_fetch_array($table_query,MYSQLI_ASSOC);
		
		for($c=0;$c<count($table_columns);$c++){
			$table_array[$table_columns[$c]][$tr] = $table_query_results[$table_columns[$c]];
		}
	}
	
	return $table_array;	
}

function fetch_db_table1($connection,$table_name,$company_id,$ordering,$filter_string){
	if(!isset($ordering)){
		$ordering = 'id';
	}
	
	if($filter_string != ''){
		$filter_string = ' and '.$filter_string;
		
	}
	
	$table_query = mysqli_query($GLOBALS[$connection],"select * from $table_name where company_id = $company_id $filter_string order by $ordering")or die(mysqli_error($GLOBALS[$connection]));
	
	$table_columns = get_column_names($table_query,0);
	for($c=0;$c<count($table_columns);$c++){
		$table_array[$table_columns[$c]] = array();
	}
	
	for($tr=0;$tr<mysqli_num_rows($table_query);$tr++){
		$table_query_results = mysqli_fetch_array($table_query,MYSQLI_ASSOC);
		
		for($c=0;$c<count($table_columns);$c++){
			$table_array[$table_columns[$c]][$tr] = $table_query_results[$table_columns[$c]];
		}
	}
	
	return $table_array;	
}

function new_fetch_db_table($connection,$table_name,$company_id,$ordering,$filter_string){
	if(!isset($ordering)){
		$ordering = 'id';
	}
	
	if($filter_string != ''){
		$filter_string = ' and '.$filter_string;
		
	}
	
	if($company_id != ''){
		$company_filter = ' company_id = '.$company_id;
		
	}else{
		$company_filter = ' id > 0';
		
	}
	
	$table_query = mysqli_query($GLOBALS[$connection],"select * from $table_name where $company_filter $filter_string order by $ordering")or die(mysqli_error($GLOBALS[$connection]));
	
	$table_columns = get_column_names($table_query,0);
	for($c=0;$c<count($table_columns);$c++){
		$table_array[$table_columns[$c]] = array();
	}
	
	$id_string = '';
	for($tr=0;$tr<mysqli_num_rows($table_query);$tr++){
		$table_query_results = mysqli_fetch_array($table_query,MYSQLI_ASSOC);
		
		for($c=0;$c<count($table_columns);$c++){
			$table_array[$table_columns[$c]][$tr] = $table_query_results[$table_columns[$c]];
		}
		
		if($id_string == ''){
			$id_string = $table_query_results['id'];
			
		}else{
			$id_string .= ','.$table_query_results['id'];
		}
	}
	
	$output_array[0] = $table_columns;
	$output_array[1] = $table_array;
	$output_array[2] = $id_string;
	
	return $output_array;
}

function table_to_string($query_array,$delimeter_1,$delimeter_2){
	if(!isset($delimeter_1)){
		$delimeter_1 = ']';
	}
	
	if(!isset($delimeter_2)){
		$delimeter_2 = '~';
	}
	
	$output_string = '';
	if(!isset($query_array[0]['id'])){
		//var_dump($query_array);
		
	}
	for($o=0;$o<count($query_array[1]['id']);$o++){
		$row_string = '';
		for($c=0;$c<count($query_array[0]);$c++){
			if($row_string == ''){
				$row_string = $query_array[1][$query_array[0][$c]][$o];
				
			}else{
				$row_string .= $delimeter_2.$query_array[1][$query_array[0][$c]][$o];
				
			}
		}
		
		if($output_string == '' and $row_string != ''){
			$output_string = $row_string;
			
		}else{
			$output_string .= $delimeter_1.$row_string;
			
		}
	}
	
	return $output_string;
}

function table_columns_to_string($query_array,$delimeter){
	if(!isset($delimeter)){
		$delimeter = '~';
	}
	
	$row_string = '';
	for($c=0;$c<count($query_array[0]);$c++){
		if($row_string == ''){
			$row_string = $query_array[0][$c];
			
		}else{
			$row_string .= $delimeter.$query_array[0][$c];
			
		}
	}
	
	return $row_string;
}


function simple_encode($input_string){
	$alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	$alphabet_2 = array('z','y','x','w','v','u','t','s','r','q','p','o','n','m','l','k','j','i','h','g','f','e','d','c','b','a','Z','Y','X','W','V','U','T','S','R','Q','P','O','N','M','L','K','J','I','H','G','F','E','D','C','B','A');

	$input_array = str_split($input_string);

	$new_string = '';
	for($a=0;$a<count($input_array);$a++){
		
		$letter_index = array_keys($alphabet,$input_array[$a]);
		
		if(isset($letter_index[0])){
			if($new_string == ''){
				$new_string = $alphabet_2[$letter_index[0]];
				
			}else{
				$new_string .= $alphabet_2[$letter_index[0]];
			}
		}else{
			$new_string .= $input_array[$a];
		}
	}
	
	return $new_string;	
}

function simple_decode($input_string){
	$alphabet = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	$alphabet_2 = array('z','y','x','w','v','u','t','s','r','q','p','o','n','m','l','k','j','i','h','g','f','e','d','c','b','a','Z','Y','X','W','V','U','T','S','R','Q','P','O','N','M','L','K','J','I','H','G','F','E','D','C','B','A');

	$input_array = str_split($input_string);

	$new_string = '';
	for($a=0;$a<count($input_array);$a++){
		
		$letter_index = array_keys($alphabet_2,$input_array[$a]);
		
		if(isset($letter_index[0])){
			if($new_string == ''){
				$new_string = $alphabet[$letter_index[0]];
				
			}else{
				$new_string .= $alphabet[$letter_index[0]];
			}
		}else{
			$new_string .= $input_array[$a];
		}
	}
	
	return $new_string;	
}


/*function myfunc($a='',$b=''){
	
	eval($a.';');
	
	if($b === ''){
		$b = 'Not defined';
		
	}else{
		eval($b.';');
	}
	return 'a='.$a.', b='.$b;
}*/
?>