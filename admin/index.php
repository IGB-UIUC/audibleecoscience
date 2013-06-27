<?php
include_once 'includes/main.inc.php';
include_once 'includes/session.inc.php';
include_once 'includes/header.inc.php';

$user = new users($db);
$group = $user->getGroup($username);

$podcasts = getYourPodcasts($username,$db);

$podcastsHtml = "";
foreach ($podcasts as $podcast) {
	$source = $podcast['podcast_source'];
	$showName = $podcast['podcast_showName'];
	$programName = $podcast['podcast_programName'];
	$approved = $podcast['podcast_approved'];
	$podcast_id = $podcast['podcast_id'];
	$time = $podcast['podcast_time'];
	$podcastsHtml .= "<tr>";
	if ($approved == 1) {
		$podcastsHtml .= "<td>Yes</td>";
	}
	elseif ($approved == 0) {
		$podcastsHtml .= "<td>No</td>";
	}
	$podcastsHtml .= "<td><a href='podcast.php?id=" . $podcast_id . "'>" . $showName . "</a></td>";
	$podcastsHtml .= "<td>" . $source . "</td>";
	$podcastsHtml .= "<td>" . $programName . "</td>";
	$podcastsHtml .= "<td>" . $time . "</td>";
	
	if ($approved == 0) {
		$podcastsHtml .= "<td><input type='button' value='Edit' onClick=\"window.location.href='editPodcast.php?id=" . $podcast_id . "'\"></td>";

	}
	$podcastsHtml .= "</tr>";
}

?>
<h3>My Podcasts</h3>

<table class='table table-bordered'>
        <tr>
		<th>Approved</th>
                <th>Show Name</th>
                <th>Source</th>
                <th>Program</th>
		<th>Time Uploaded</th>
        </tr>
<?php echo $podcastsHtml; ?>

</table>



<?php

include 'includes/footer.inc.php';
?>
