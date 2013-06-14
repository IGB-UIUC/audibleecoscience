<?php
include_once 'includes/main.inc.php';
include_once 'podcast.class.inc.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	$podcast = new podcast($id,$db);
	$podcast->downloadPodcast($absPodcastDirectory);



}



?>
