<?php
include_once 'includes/main.inc.php';
include_once 'users.class.inc.php';
include_once 'functions.inc.php';

$user = new users($db);
$group = $user->getGroup($username);
if (!($group==1)){
	header('Location: invalid.php');
}


$podcasts = getUnapprovedPodcasts($db);
$unapprovedHtml = "";
for ($i=0;$i<count($podcasts);$i++) {

	$source = $podcasts[$i]['podcast_source'];
        $showName = $podcasts[$i]['podcast_showName'];
        $programName = $podcasts[$i]['podcast_programName'];
        $time = $podcasts[$i]['podcast_time'];
        $createdBy = $podcasts[$i]['user_name'];
        $podcast_id = $podcasts[$i]['podcast_id'];

	$unapprovedHtml .= "<tr><td><a href='podcast.php?id=" . $podcast_id . "'>" . $showName . "</td>";
	$unapprovedHtml .= "<td>" . $source . "</td>";
	$unapprovedHtml .= "<td>" . $programName . "</td>";
	$unapprovedHtml .= "<td>" . $time . "</td>";
	$unapprovedHtml .= "<td>" . $createdBy . "</td>";
	$unapprovedHtml .= "<td><input type='button' value='Edit' onClick=\"window.location.href='editPodcast.php?id=" . $podcast_id . "'\"></td>";
	$unapprovedHtml .= "</tr>";

}

include_once 'includes/header.inc.php';
?>
<p class='subHeader'>Unapproved Podcasts</p>
<table>
<thead>
	<td>Show Name</td>
	<td>Source</td>
	<td>Program</td>
	<td>Time Uploaded</td>
	<td>Create By</td>
	<td></td>
</thead>


<?php echo $unapprovedHtml; ?>


</table>

<?php
include 'includes/footer.inc.php';
?>
