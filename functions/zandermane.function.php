<?PHP
/*
This function will return a random quote, feel free to add yours.
Don't copy mine, be creative, I like tea, choose something you like.
*/
function getQuote(){
	$q_array = array();

	$q_array[0] = "I like birds, what is your favorite bird?";
	$q_array[1] = "I like dogs, what is your favorite dog?";
	
	$q_size = (count($q_array) - 1);
	$rand_range = rand(0, $q_size);

	return $q_array[$rand_range];
}

/*
This function will tweet a given message
*/
function tweetThis($search_term){
	include('includes/config.inc.php');

	//base url for posting with curl
	$url = 'http://twitter.com/statuses/update.xml';
	
	//Call this function in scrape.php, will return array
	$posts = getTwitterSearchFeedByJSON($search_term);
	$user_count = 0;

	echo "Twitter bot being user: <strong>$bot_username</strong><br /><br />";

	for($i = 0; $i < 13; $i++) {	
		//grab user, post from array, then increment user counter
		$r_user = $posts[$user_count][0];
		$r_text = $posts[$user_count][1];
		$user_count++;

		//concatenate message to send
		$quo = getQuote();
		$msg = "@$r_user $quo";

		if($bot_username != $r_user){
			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $url);
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$msg");
			curl_setopt($curl_handle, CURLOPT_USERPWD, "$bot_username:$bot_password");
			$buffer = curl_exec($curl_handle);
			curl_close($curl_handle);
	
			if(empty($buffer)){
				echo "Failure: tweet unsuccessfully posted<br />";
			} else {
				echo "Your tweet has been submitted: <strong>$msg</strong> in response to: <strong>$r_text</strong><br />";
			}
		} else {
			echo "Oooops, almost just tweeted myself, nope I caught it!<br />";
		}
	}
	echo "<br />Searching and tweeting for: <strong>$search_term</strong><br />";
}
