<?
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
		$podcasts_html .= "<div class='category'>";
		$podcasts_html .= "<div class='category_img'><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
		$podcasts_html .= "<img src='" . __PICTURE_WEB_DIR__ . "/" . $podcasts[$i]['category_filename'] . "' ";
		$podcasts_html .= "alt='" . $podcasts[$i]['category_name'] . "'></a></div>";
		$podcasts_html .= "<div class='category_content'>";
		$podcasts_html .= "<h2><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>" . $podcasts[$i]['podcast_source'];
		$podcasts_html .= "</a></h2>";
		if ($podcasts[$i]['podcast_short_summary'] != "") {
			$podcasts_html .= "<p><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
			$podcasts_html .= substr($podcasts[$i]['podcast_short_summary'],0,100) . "...</a></p>";	
		}
		else {
			$podcasts_html .= "<p><a href='podcast.php?id=" . $podcasts[$i]['podcast_id'] . "'>";
                        $podcasts_html .= substr($podcasts[$i]['podcast_summary'],0,100) . "...</a></p>";  
		}
  		$podcasts_html .= "</div><div class='clear'></div></div>";

	}
}


?>
<div class="clear"></div>

<div class="container_category_podcastlist">

<?php echo $podcasts_html; ?>
<?php echo $pages_html; ?>
<?php

include_once 'includes/footer.inc.php';
?>
