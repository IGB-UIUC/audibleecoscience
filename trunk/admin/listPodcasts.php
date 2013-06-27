<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new user($db,$ldap,$username);
$admin = $user->is_admin();

if (!($admin)){
        header('Location: invalid.php');
}

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
	$pagesHtml .= "<a href='listPodcasts.php?start=" . $startRecord . "'>Back</a> |";
}
for ($i=0;$i<$numPages;$i++) {
	$pageNumber = $i +1;
	$startRecord = $i * $count;
	$pagesHtml .= " <a href='listPodcasts.php?start=" . $startRecord . "'>" . $pageNumber . "</a> ";
	if ($pageNumber != $numPages) {
		$pagesHtml .= " | ";
	}
}
if ($currentPage < $numPages) {
	$startRecord = $start + $count;
	$pagesHtml .= " | <a href='listPodcasts.php?start=" . $startRecord . "'>Next</a> ";
}
	$pagesHtml .= "</p>";


$podcastsHtml = "";
foreach ($podcasts as $podcast) {

	$approved = "No";
	if ($podcast['podcast_approved'] == 1) { 
		$approved = "Yes"; 
	}
	
	$podcastsHtml .= "<tr><td>" . $approved . "</td>";
	$podcastsHtml .= "<td><a href='podcast.php?id=" . $podcast['podcast_id'] . "'>" . $podcast['podcast_showName'] . "</a></td>";	
	$podcastsHtml .= "<td>" . $podcast['podcast_source'] . "</td>";
	$podcastsHtml .= "<td>" . $podcast['podcast_programName'] . "</td>";
	$podcastsHtml .= "<td>" . $podcast['podcast_time'] . "</td>";
	$podcastsHtml .= "<td>" . $podcast['user_name'] . "</td>"; 
	$podcastsHtml .= "<td><input type='button' value='Edit' ";
	$podcastsHtml .= "onClick=\"window.location.href='editPodcast.php?id=" . $podcast['podcast_id'] . "'\"></td>";
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
		<th></th>
	</tr>
<?php echo $podcastsHtml; ?>

</table>
<?php
if ($numPages > 1) { echo $pagesHtml; }

include 'includes/footer.inc.php';
?>
