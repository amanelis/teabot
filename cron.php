<?PHP
//define the path to the runing bot implementation
define('POST_URL', 'http://www.YOURDOMAIN.com/ztbot/run.php');

//we are using curl to run cron.
$ch = curl_init(POST_URL);
curl_setopt($ch, CURL_POST, 1);
curl_setopt($ch, CURL_HEADER, 0);
curl_setopt($ch, CURL_RETURNTRANSFER, 1);

//exec and store output
$return_data = curl_exec($ch);

//Starting output just incase you want to see return
ob_start();

//output buffer
echo $return_data;

//clearn up output buffer
ob_get_clean();

//close our curl 
curl_close($ch);
?>
