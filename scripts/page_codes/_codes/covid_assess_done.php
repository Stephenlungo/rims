<script>

$('#total_score').val(<?php print($total_score);?>);

</script>



<?php

//if(!isset($_GET['uid'])){

	?>

	<div style="display:none;width:60px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;float:left;margin-right:5px;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_screening_button" onclick="complete_assessment()" title="Click to update account details">Next</div>

	

		

	<?php

//}

if($pass_status){

	?>

	

	<div style="width:auto;float:left;height:auto;" id="client_facility_list_button_holder">

	<div style="width:100%;height:30px;line-height:30px;float:left;text-align:center;margin-top:10px">Please click below to view the facility list:</div>

	

	

	<div style="width:100%;height;auto;float:left;">

	<div style="width:90px;height:30px;background-color:orange;color:#fff;text-align:center;line-height:30px;margin:0 auto;cursor:pointer;" onmouseover="this.style.backgroundColor='#ffc864';" onmouseout="this.style.backgroundColor='orange';"  id="client_facility_list_button" onclick="window.open($('#url').val()+'/imgs/prep_facilities.pdf','facilities');" title="Click to update account details">Facility list</div>

	</div>

	</div>

	

	<div style="width:100%;float:left;height:auto;" id="client_proceed_button_holder">	

	<div style="width:100%;height;auto;float:left;">

	<div style="width:120px;height:30px;background-color:#9bd075;color:#fff;text-align:center;line-height:30px;margin:0 auto;cursor:pointer;" onmouseover="this.style.backgroundColor='#addf8b';" onmouseout="this.style.backgroundColor='#9bd075';"  onclick="$('#tab_11').click();" title="Click to proceed entering client details">Proceed to Profile</div>

	</div>

	</div>

	<script>

	//create_or_update_client();

	create_or_update_covid_client_screening($('#tmp_client_id').val(),$('#client_id').val(),<?php print($questionnaire_id);?>,$('#total_score').val());

	

	if($('#direct_access').val() == undefined){

		$('#client_facility_list_button_holder').hide();

	

	}else{

		$('#client_proceed_button_holder').hide();

		

	}

	</script>

	

	<?php

}

?>

