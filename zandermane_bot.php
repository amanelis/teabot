<?PHP
//include the scrapper class
require_once('scrape.php');

//include config file for username:password
//oddly in this call to curl on line 60
//it will not accept variable declarations
//from our config.inc.php file
require_once('config.inc.php');

/*
This function will return a random quote, feel free to add yours.
Don't copy mine, be creative, I like tea, choose something you like.
*/
function getQuote(){
	$q_array = array();

	$q_array[0] = "You like warm beer!";
	$q_array[1] = "You like fake beer!";
	$q_array[2] = "You like carbonated water!";
	
	$q_size = (count($q_array) - 1);
	$rand_range = rand(0, $q_size);

	return $q_array[$rand_range];
}

/*
This function will tweet a given message
*/
function tweetThis($search_term){
	if($bot_username == '' || $bot_password == '') {
		echo "Please edit the config.inc.php file with your bot's username:password<br />";
		exit(-1);
	}

	//base url for posting with curl
	$url = 'http://twitter.com/statuses/update.xml';
	
	//Call this function in scrape.php, will return array
	$posts = getTwitterSearchFeedByJSON($search_term);
	$user_count = 0;

	for($i = 0; $i < 13; $i++) {	
		//grab user, post from array, then increment user counter
		$r_user = $posts[$user_count][0];
		$r_text = $posts[$user_count][1];
		$user_count++;

		//concatenate message to send
		$quo = getQuote();
		$msg = "@$r_user $quo";

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$msg");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "USERNAME:PASSWORD");
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
	
		if (empty($buffer)) {
			echo "Failure: tweet unsuccessfully posted<br />";
		} else {
			echo "Twitter bot being user: <strong>$bot_username</strong> with a search on <strong>$search</strong><br />";
			echo "Your tweet has been submitted: <strong>$msg</strong><br />";
		}
	}
}
$search = "beer";
tweetThis($search);
?>
