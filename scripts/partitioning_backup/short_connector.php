<?php $timeZone = date_default_timezone_set('africa/Harare');
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header('Access-Control-Allow-Origin: *');
$url = 'https://www.pipatzambia.org';
$main_url = 'https://www.pipatzambia.org';
$site_url = '../';

$code_url = 'https://secure51.ezhostingserver.com/blueraysit-com';

$prep_url = 'https://www.pipatzambia.org/prep';
$prep_assess_url = 'https://www.pipatzambia.org/prepassess.php';
//print('hi');
//print(getenv('TESTING_MAIN_DATABASE_IP'));
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


/*---------Other important variables and files-----*/
$today = time();
$default_cookie_expiry = time()+3600;

include 'functions.php';

?>