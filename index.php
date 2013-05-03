<?php

date_default_timezone_set('UTC');

require('./libs/Client.php');
require('./libs/rssreader.php');
require('./libs/SocialCounter.php');
require_once('./php/autoloader.php');

require('helpers.php');

$client = new Client();
$simple_pie = new SimplePie();

$items = [];
$url = '';

if (isset($_GET['url'])) {
  $url = $_GET['url'];

  $reader = new rssreader($client, $simple_pie);
  $items = $reader->getItems($url, 20);

  //$items = $reader->getTweetCount($items);
  //$items = $reader->getFBCount($items);
  //$items = $reader->getSUCount($items);
  
  //pr($items);die();

  if (!$reader->rss_or_xml) {
    // We must suggest something like
    // "Do you want to test [RSS Link] ?"
    // For that getting the Feeds URL is important

    // '@(https?://\S+?feed\S+)@ui' ???
  }
}

if(isset($_GET['get_count_for']) && isset($_GET['service']))
{
	$url = $_GET['get_count_for'];
	$service = $_GET['service'];
	
	$social_counter = new SocialCounter($client);
	if($service == "twitter")
	{
		$count = $social_counter->getTweetCount($url);
		echo $count;
		die();
	}
	else if($service == "facebook")
	{
		$count = $social_counter->getFBCount($url);
		echo $count;
		die();
	}
	else if($service == "stumbleupon")
	{
		$count = $social_counter->getSUCount($url);
		echo $count;
		die();
	}
}

require('./views/home.php');
