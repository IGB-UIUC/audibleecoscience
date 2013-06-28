<?
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';


$podcasts = getRecentPodcasts($db);
$podcasts_html = "";
foreach ($podcasts as $podcast) {
                $summary = substr($podcast['podcast_summary'],0,200);
                $podcasts_html .= "<h4><a href='podcast.php?id=";
		$podcasts_html .= $podcast['podcast_id'] . "'>" . $podcast['podcast_showName'] . "</a></h4>";
		$podcasts_html .= "<ul>";
                $podcasts_html .= "<li>" . $podcast['podcast_source'] . "</li>";
                $podcasts_html .= "<li>" . $podcast['podcast_showName'] . "</li>";
                $podcasts_html .= "<li>" . $podcast['podcast_year'] . "</li>";
                $podcasts_html .= "<li>" . $summary . "...</li>";
                $podcasts_html .= "</ul>";


}


?>

<h4>Welcome to Andrew Leakey's Podcast website.  Select a category on the left.</h4>
<form class='form-search' method='get' action='<?php echo $_SERVER['PHP_SELF'];?>'>
        <div class='input-append'>
                <input type='text' name='search' class='input-long search-query' value='<?php echo $search; ?>'>
                <button type='submit' class='btn'>Search</button>
        </div>
</form>


<?php echo $podcasts_html; ?>
<?php
include 'includes/footer.inc.php';
?>
