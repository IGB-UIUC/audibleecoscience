<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';
$count = __COUNT__;
$start = 0;
$get_array = array();
if (isset($_GET['start']) && is_numeric($_GET['start'])) {
        $start = $_GET['start'];
	$get_array['start'] = $start;
}

$category_id = 0;
if (isset($_GET['category']) && (is_numeric($_GET['category']))) {
	$category_id = $_GET['category'];
	$get_array['category'] = $category_id;
}
$search = "";
if (isset($_GET['search'])) {
	$search = $_GET['search'];
	$get_array['search'] = $search;
}
$start_date = 0;
$end_date = 0;
$approved = 1;
$podcasts = get_podcasts($db,$start_date,$end_date,$approved,$category_id,$search);
$num_podcasts = count($podcasts);
$pages_url = $_SERVER['PHP_SELF'] . "?" . http_build_query($get_array);
$pages_html = get_pages_html($pages_url,$num_podcasts,$start,$count);

$podcasts_html = "";
for ($i=$start;$i<$start+$count;$i++) {
	if (array_key_exists($i,$podcasts)) {
		$podcasts_html .= "\n<div class='category'>\n";
		$podcasts_html .= "<div class='category_img'>\n<a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
		$podcasts_html .= "<img src='" . __PICTURE_WEB_DIR__ . "/" . $podcasts[$i]['category_filename'] . "' ";
		$podcasts_html .= "alt='" . $podcasts[$i]['category_name'] . "'></a>\n<!-- end: class='category_img' -->\n</div>";
		$podcasts_html .= "\n<div class='category_content'>";
		$podcasts_html .= "\n<h2><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>" . $podcasts[$i]['podcast_showName'];
		$podcasts_html .= "</a></h2>\n";
		if ($podcasts[$i]['podcast_short_summary'] != "") {
			$podcasts_html .= "<p><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
			$podcasts_html .= substr($podcasts[$i]['podcast_short_summary'],0,100) . "...</a></p>";	
		}
		else {
			$podcasts_html .= "<p><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
                        $podcasts_html .= substr($podcasts[$i]['podcast_summary'],0,100) . "...</a></p>";  
		}
  		$podcasts_html .= "</div>\n <div class='clear'></div>\n <!-- end: class=\"category\" --> \n</div>\n\n";

	}
}


?>

<div class="clear"></div>

<div class="container_category_podcastlist">

<?php echo $podcasts_html; ?>
<?php echo $pages_html."\n "; ?>
<!-- end: class="container_category_podcastlist -->
</div><div class="clear"></div>
<?php

include_once 'includes/footer.inc.php';
?>
