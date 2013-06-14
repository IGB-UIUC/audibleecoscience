<?php
include_once 'includes/main.inc.php';
include_once 'includes/header.inc.php';

if (isset($_GET['start']) && is_numeric($_GET['start'])) {
	$start = $_GET['start'];
}
else {
	$start = 0;
}

$count = 10;

$podcasts = getAllPodcasts($db);

$numPodcasts = count($podcasts);
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


$podcastsHtml = "";
for ($i=0;$i<count($podcasts);$i++) {
	$approved = $podcasts[$i]['podcast_approved'];
	if ($approved == 1) { 
		$approved = "Yes"; 
	}
	elseif ($approved == 0) {
		$approved = "No";
	}
	

	$source = $podcasts[$i]['podcast_source'];
	$showName = $podcasts[$i]['podcast_showName'];
	$programName = $podcasts[$i]['podcast_programName'];
	$time = $podcasts[$i]['podcast_time'];
	$createdBy = $podcasts[$i]['user_name'];
	$podcast_id = $podcasts[$i]['podcast_id'];
	$podcastsHtml .= "<tr><td>" . $approved . "</td>";
	$podcastsHtml .= "<td><a href='podcast.php?id=" . $podcast_id . "'>" . $showName . "</a></td>";	
	$podcastsHtml .= "<td>" . $source . "</td>";
	$podcastsHtml .= "<td>" . $programName . "</td>";
	$podcastsHtml .= "<td>" . $time . "</td>";
	$podcastsHtml .= "<td>" . $createdBy . "</td>"; 
	$podcastsHtml .= "<td><input type='button' value='Edit' onClick=\"window.location.href='editPodcast.php?id=" . $podcast_id . "'\"></td>";
	$podcastsHtml .= "</tr>";


}


?>

<h3>All Podcasts</h3>
<table class='table table-bordered'>
	<tr>
		<th>Approved</th>
		<th>Show Name</th>
		<th>Source</th>
		<th>Program</th>
		<th>Time Uploaded</th>
		<th>Create By</th>
	</tr>
<?php echo $podcastsHtml; ?>

</table>
<?php
if ($numPages > 1) { echo $pagesHtml; }

include 'includes/footer.inc.php';
?>
