<?PHP
//include the dom class
require_once("dom.class.php");

//include twitter api class
require_once("twit.class.php");

/*
Standard function that returns links or
more so their 'href' source not that actual
text itself in the link but the href
@return: returns an array of links
*/
function getLinksByURLByDOM($url){
    $array_links_count = 0;
    $array_links = array();
    $html = file_get_html($url);

    foreach($html->find('a') as $element){
        $array_links[$array_links_count] = $element;
        $array_links_count++;
    }
    return $array_links;
}

/*
This function will scrape a particular users
twitter feed, along with time stamp
@return: echos content out.
*/
function getTwitterUserFeedByDOM($url){
	$html = file_get_html($url);
	
	$posts = $html->find('span.entry-content');
	$tstmp = $html->find('a[class]');
	
	//twitter user feeds only contain 20 posts per page
	for($i=0; $i<19; $i++){
		echo $posts[$i]." ".$tstmp[$i]."<br>";
	}
}

/*
This function searches twitter's real time
twitter feed from all users on a search request 
of your choice
@return: prints array of real time queries
*/
function getTwitterSearchFeedByDOM($search){
	$full_url = 'http://search.twitter.com/search?q='.$search;

	$html = file_get_html($full_url);
	$posts = $html->find('span[class=msgtxt en]');
	
	//live twitter feed output
	for($i=0; $i<25; $i++){
		echo $posts[$i]."<br>";
	}
}


/*
This function enables you to query twitter search
and pull data using json and then allow for array parse
this one is easy
*/
function getTwitterSearchFeedByJSON($search){
	$full_url = 'http://search.twitter.com/search.json?q='.$search;
	
	$json = file_get_contents($full_url, true);
	$decode = json_decode($json, true);
	
	$posts = array();
	$user_count = 0;

	//apparently can only return 15 results in json array
	for($i=0; $i<14; $i++){
		//echo "<img src=\"$decode[results][$i][profile_image_url]\"/>";
		$r_user = $decode[results][$i][from_user];
		$r_text = $decode[results][$i][text];
	
		$posts[$user_count][0] = $r_user;
		$posts[$user_count][1] = $r_text;
		$user_count++;	
	}
	return $posts;
}

/*
This function should return the users lists of tweets
*/
function getTwitterUserList(){
	$e_result = exec('curl -u '.$bot_username.':'.$bot_password.' http://api.twitter.com/1/'.$bot_username.'/lists.xml');

	$url = 'http://api.twitter.com/1/'.$bot_username.'/lists.xml';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_USERPWD, "$bot_username:$bot_password"); 
	$result = curl_exec($ch); 
	curl_close($ch); 
	echo $result;
}
?> 
