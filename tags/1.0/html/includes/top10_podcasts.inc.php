<?php
	$top_podcasts = getTopPodcasts($db);
	$top_podcast_html = "";
	foreach ($top_podcasts as $podcast) {
		$top_podcast_html .= "<li><a href='podcast.php?id=" . $podcast['podcast_id'] . "'><span class='play'>PLAY:</span></a>";
		if ($podcast['podcast_short_summary'] != "") {
			$top_podcast_html .= substr($podcast['podcast_short_summary'],0,100) . "...</li>";
		}
		else {
			$top_podcast_html .= substr($podcast['podcast_summary'],0,100) . "...</li>";
		}

	}



?>

<div class="container_category_podcastlist podcastlist">
<h2>Most Popular Top 10  Podcasts</h2>
<ol>
<?php echo $top_podcast_html; ?>
</ol>
<!-- end class="container_category_podcastlist" -->
    </div>
    <div class="clear"></div>
