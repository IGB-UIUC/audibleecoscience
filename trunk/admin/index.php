<?php
include 'includes/main.inc.php';
include 'includes/header.inc.php';
include 'functions.inc.php';

$podcasts = getYourPodcasts($username,$mysqlSettings);

$podcastsHtml;
for ($i=0;$i<count($podcasts);$i++) {
	$source = $podcasts[$i]['podcast_source'];
	$showName = $podcasts[$i]['podcast_showName'];
	$programName = $podcasts[$i]['podcast_programName'];
	$approved = $podcasts[$i]['podcast_approved'];
	$podcast_id = $podcasts[$i]['podcast_id'];
	$time = $podcasts[$i]['podcast_time'];
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
<p class='subHeader'>My Podcasts</p>

<table>
        <tr>
		<td>Approved</td>
                <td>Show Name</td>
                <td>Source</td>
                <td>Program</td>
		<td>Time Uploaded</td>
		<td></td>
        </tr>
<?php echo $podcastsHtml; ?>

</table>



<?php

include 'includes/footer.inc.php';
?>
