<?PHP
//require the document scrapper class
require_once('classes/dom.class.php');

//require the twitter search class
require_once('classes/twit.class.php');

//require the scrapper class
require_once('functions/scrape.function.php');

//require the twitter bot class
require_once('functions/zandermane.function.php');


/***************************************************/
//add your search term bot will search for
$search = 'tea';

//pass your search term in that bot will tweet back on
tweetThis($search);
