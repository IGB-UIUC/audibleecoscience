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
                $summary = substr($podcasts[$i]['podcast_summary'],0,200);
                $podcasts_html .= "<h4><a href='podcast.php?id=";
		$podcasts_html .= $podcasts[$i]['podcast_id'] . "'>" . $podcasts[$i]['podcast_showName'] . "</a></h4>";
		$podcasts_html .= "<ul>";
                $podcasts_html .= "<li>" . $podcasts[$i]['podcast_source'] . "</li>";
                $podcasts_html .= "<li>" . $podcasts[$i]['podcast_showName'] . "</li>";
                $podcasts_html .= "<li>" . $podcasts[$i]['podcast_year'] . "</li>";
                $podcasts_html .= "<li>" . $summary . "...</li>";
                $podcasts_html .= "</ul>";

	}
}


?>

<h4>Welcome to Andrew Leakey's Podcast website.  Select a category on the left.</h4>
<form class='form-search' method='get' action='<?php echo $_SERVER['PHP_SELF'];?>'>
        <div class='input-append'>
		<?php if ($category_id) {
			echo "<input type='hidden' name='category' value='" . $category_id . "'>";

		} ?>
                <input type='text' name='search' class='input-long search-query' value='<?php echo $search; ?>'>
                <button type='submit' class='btn'>Search</button>
        </div>
</form>


<?php echo $podcasts_html; ?>
<?php echo $pages_html; ?>
<?php
include 'includes/footer.inc.php';
?>
