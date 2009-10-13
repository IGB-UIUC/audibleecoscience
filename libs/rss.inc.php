<?php


include_once 'functions.inc.php';

function getRSS($mysqlSettings,$webaddress) {

	$podcasts = getRecentPodcasts($mysqlSettings);
	
	$rssData;
	for($i=0;$i<count($podcasts);$i++) {
	
		$id = $podcasts[$i]['podcast_id'];
		$title = htmlspecialchars(stripslashes($podcasts[$i]['podcast_showName']));
		$shortDescription = substr($podcasts[$i]['podcast_summary'],0,200);
		$shortDescription = htmlspecialchars(strip_tags(stripslashes($shortDescription)));
		$time = strtotime($podcasts[$i]['podcast_time']);
		$time = date("D, d M Y H:i:s O",$time);
		$link = $webaddress . "podcast.php?id=" . $id;
		$rssData .= "<item>";
		$rssData .= "<title>" . $title . "</title>";
		$rssData .= "<description>" . $shortDescription . "...</description>";
		$rssData .= "<link>" . $link . "</link>"; 
		$rssData .= "<pubDate>" . $time . "</pubDate>";
		$rssData .= "</item>";
	
	}





return $rssData;
}








?>
