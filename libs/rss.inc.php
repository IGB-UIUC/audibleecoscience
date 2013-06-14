<?php


include_once 'functions.inc.php';

function getRSS($db,$webaddress) {

	$podcasts = getRecentPodcasts($db);
	
	$rssData = "";
	foreach ($podcasts as $podcast) {
	
		$id = $podcast['podcast_id'];
		$title = htmlspecialchars(stripslashes($podcast['podcast_showName']));
		$shortDescription = substr($podcast['podcast_summary'],0,200);
		$shortDescription = htmlspecialchars(strip_tags(stripslashes($shortDescription)));
		$time = strtotime($podcast['podcast_time']);
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
