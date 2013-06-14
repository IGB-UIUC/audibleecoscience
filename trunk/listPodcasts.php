<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';

$podcastsHtml = "";
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

	if (isset($_GET['start']) && is_numeric($_GET['start'])) {
		$start = $_GET['start'];
	}
	else {
		$start = 0;
	}

	$count = 10;

	
	$category_id = $_GET['id'];


	$numPodcasts = $categories->numPodcasts($category_id);
	$numPages = getNumPages($numPodcasts,$count);
	$currentPage = $start / $count +1;

	//Number of pages
	$pagesHtml = "<p>";
	if ($currentPage > 1) {
		$startRecord = $start - $count;
		$pagesHtml .= "<a href='listPodcasts.php?id=" . $category_id . "&start=" . $startRecord . "'>Back</a> |";
	}
	for ($i=0;$i<$numPages;$i++) {
		$pageNumber = $i +1;
		$startRecord = $i * $count;
		$pagesHtml .= " <a href='listPodcasts.php?id=" . $category_id . "&start=" . $startRecord . "'>" . $pageNumber . "</a> ";
		if ($pageNumber != $numPages) {
			$pagesHtml .= " | ";
		}
	}
	if ($currentPage < $numPages) {
		$startRecord = $start + $count;
		$pagesHtml .= " | <a href='listPodcasts.php?id=" . $category_id . "&start=" . $startRecord . "'>Next</a> ";
	}
	$pagesHtml .= "</p>";


	$category_name = $categories->getName($category_id);

	$podcasts = $categories->getPodcasts($category_id,$start,$count);
	for ($i=0;$i<count($podcasts);$i++) {
		$source = $podcasts[$i]['podcast_source'];
		$showName = $podcasts[$i]['podcast_showName'];
		$programName = $podcasts[$i]['podcast_programName'];
		$summary = substr($podcasts[$i]['podcast_summary'],0,200);
		$year = $podcasts[$i]['podcast_year'];
		$podcast_id = $podcasts[$i]['podcast_id'];
		$podcastsHtml .= "<div id='listpodcasts'><ul><a href='podcast.php?id=" . $podcast_id . "'>" . $showName . "</a>";
		$podcastsHtml .= "<li>" . $source . "</li>";
		$podcastsHtml .= "<li>" . $programName . "</li>"; 
		$podcastsHtml .= "<li>" . $year . "</li>";
		$podcastsHtml .= "<li>" . $summary . "...</li>";
		$podcastsHtml .= "</ul></div>";


	}





}

?>

<h3><?php echo $category_name; ?></h3>

<?php 

echo $podcastsHtml;
if ($numPages > 1) { echo $pagesHtml; }

include 'includes/footer.inc.php';
?>
