<?php
$timeZone = date_default_timezone_set('africa/Harare');
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header('Access-Control-Allow-Origin: *');

/*---------Company access key and system ID-----*/
$access_key = getenv('PIPAT_MAIN_ACCESS_KEY');
$system_id = getenv('PIPAT_MAIN_SYSTEM_ID');

$this_pipat_main_database_ip = getenv('PIPAT_MAIN_DATABASE_IP');
$this_pipat_main_database_name = getenv('PIPAT_MAIN_DATABASE_NAME');
$this_pipat_main_database_username = getenv('PIPAT_MAIN_DATABASE_USERNAME');
$this_pipat_main_database_password = getenv('PIPAT_MAIN_DATABASE_PASSWORD');

$connect = mysqli_connect($this_pipat_main_database_ip,$this_pipat_main_database_username,$this_pipat_main_database_password);
mysqli_query($connect,'use '.$this_pipat_main_database_name)or die(mysqli_error($connect));

$module_connect = 'connect';
$module_dir = '';

//URL declarations
$this_settings = mysqli_query($connect,"select * from settings")or die(mysqli_error($connect));
$settings_results = mysqli_fetch_array($this_settings,MYSQLI_ASSOC);

$url = $settings_results['url'];
$main_url =  $settings_results['main_url'];
$site_url = '../';
$code_url = $settings_results['code_url'];

$prep_url = $settings_results['prep_url'];
$prep_assess_url = $settings_results['prep_assess_url'];

$request = explode('/',$_SERVER['REQUEST_URI']);
$cookie_url = $_SERVER['HTTP_HOST'];

/*---------Other important variables and files-----*/
$today = time();
$default_cookie_expiry = $today+$settings_results['cookie_expiry'];

//Database table partitioning definitions
$default_partition_names[0][0] = 'Daily reporting';
$default_partition_names[0][1][0] = '_data';
$default_partition_names[0][2][0] = '_date';
$default_partition_names[0][3][0] = 1;

$default_partition_names[1][0] = 'USSD';
$default_partition_names[1][1][0] = 'ussd_activity_log';
$default_partition_names[1][2][0] = '_date';
$default_partition_names[1][3][0] = 1;

$default_partition_names[2][0] = 'Agents';
$default_partition_names[2][1][0] = 'agents';
$default_partition_names[2][1][1] = 'phone_numbers';
$default_partition_names[2][2][0] = '_date';
$default_partition_names[2][2][1] = 'agent_date';
$default_partition_names[2][3][0] = 1;

$default_partition_names[3][0] = 'Users';
$default_partition_names[3][1][0] = 'users';
$default_partition_names[3][2][0] = '_date';
$default_partition_names[3][3][0] = 1;

$default_partition_names[4][0] = 'User activities';
$default_partition_names[4][1][0] = 'user_access_log';
$default_partition_names[4][2][0] = '_date';
$default_partition_names[4][3][0] = 1;

$default_partition_names[5][0] = 'PrEP clients';
$default_partition_names[5][1][0] = 'prep_clients';
$default_partition_names[5][1][1] = 'dynamic_form_data_sets';
$default_partition_names[5][1][2] = 'prep_questionnaire_data_sets';
$default_partition_names[5][2][0] = '_date';
$default_partition_names[5][2][1] = '_date';
$default_partition_names[5][2][2] = '_date';
$default_partition_names[5][3][0] = 1;

$default_partition_names[6][0] = 'PrEP dynamic form entries';
$default_partition_names[6][1][0] = 'dynamic_form_values';
$default_partition_names[6][1][1] = 'prep_client_answers';
$default_partition_names[6][2][0] = '_date';
$default_partition_names[6][2][1] = '_date';
$default_partition_names[6][3][0] = 1;

$default_partition_names[7][0] = 'Payment claims';
$default_partition_names[7][1][0] = 'payment_claims';
$default_partition_names[7][1][1] = 'claim_beneficiaries';
$default_partition_names[7][1][2] = 'ascension_beneficiaries';
$default_partition_names[7][2][0] = '_date';
$default_partition_names[7][2][1] = '_date';
$default_partition_names[7][2][2] = '_date';
$default_partition_names[7][3][0] = 2;

$default_partition_names[8][0] = 'Payment claims data';
$default_partition_names[8][1][0] = 'claim_approvals';
$default_partition_names[8][2][0] = '_date';
$default_partition_names[8][3][0] = 2;

include 'functions.php';
?>