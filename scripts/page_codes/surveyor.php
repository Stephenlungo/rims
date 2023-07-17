<div style="width:99.5%;height:auto;float:left;padding:2px;">
<div class="page_title" style="background-color:#a0bf2d;cursor:pointer" title="Click to hide/show filter options" onclick="$('#filter_options').slideToggle('fast');" onmouseover="this.style.backgroundColor='#99b433';" onmouseout="this.style.backgroundColor='#a0bf2d';">Analytical Survey</div>

<input type="hidden" id="module_id" value="5">

<div style="width:99.6%;height:auto;float:left;background-color:#eee;border-bottom:solid 1px #bbb;padding:2px;display:none" id="filter_options"></div>

<div class="general_menu_holder">
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_1" onclick="if(active_agent_tab!=1){fetch_filter_options('analytical_survey_dashboard','fetch_analytical_survey_dashboard()','analytical_survey');}else{fetch_analytical_survey_dashboard();}tab_item_change(1);active_agent_tab=1;">Dashboard</div>
<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_0" onclick="if(active_agent_tab!=0){fetch_filter_options('analytical_survey','fetch_analytical_survey()','analytical_survey');}else{fetch_analytical_survey();}tab_item_change(0);active_agent_tab=0">Surveys</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_3" onclick="if(active_agent_tab!=3){fetch_filter_options('analytical_survey_responses','fetch_analytical_survey_responses()','analytical_survey');}else{fetch_analytical_survey_responses();}tab_item_change(3);active_agent_tab=3">Survey Responses</div>

<div class="tab" onmouseover="this.style.backgroundColor='#ddd';" onmouseout="this.style.backgroundColor=''" id="tab_2" onclick="if(active_agent_tab!=2){fetch_filter_options('analytical_survey_settings','fetch_analytical_survey_settings()','analytical_survey');}else{fetch_analytical_survey_settings();}tab_item_change(2);active_agent_tab=2" style="float:right;border-left:solid 1px #ddd;">Survey Settings</div>
</div>

<div class="general_holder" id="analytical_survey"></div>

</div>

<script>
	var active_agent_tab = -1;
	$('#tab_0').click();
</script>